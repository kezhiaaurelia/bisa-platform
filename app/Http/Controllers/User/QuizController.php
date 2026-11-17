<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\LearningLevel;
use App\Models\LearningProgress;
use App\Models\Question;
use App\Models\QuestionOption;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use App\Models\UserAnswer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class QuizController extends Controller
{
    /**
     * List available quizzes.
     */
    public function index(Request $request): View
    {
        $categories = Category::active()->ordered()->get();
        $quizzes = Quiz::where('type', 'quiz')
            ->where('is_active', true)
            ->with(['category', 'subject', 'learningLevel'])
            ->withCount('questions')
            ->latest()
            ->get();

        return view('user.quiz.index', compact('categories', 'quizzes'));
    }

    /**
     * Show quiz briefing / detail before starting.
     */
    public function show(Request $request, int $quizId): View
    {
        $quiz = Quiz::where('id', $quizId)->with(['subject', 'category'])->withCount('questions')->firstOrFail();
        $user = $request->user();

        // Check if user has ongoing attempt
        $existingAttempt = QuizAttempt::where('user_id', $user->id)
            ->where('quiz_id', $quiz->id)
            ->where('status', 'in_progress')
            ->first();

        // Check past completed attempts
        $pastAttempts = QuizAttempt::where('user_id', $user->id)
            ->where('quiz_id', $quiz->id)
            ->where('status', 'completed')
            ->latest()
            ->get();

        return view('user.quiz.detail', compact('quiz', 'existingAttempt', 'pastAttempts'));
    }

    /**
     * Start or resume a timed quiz.
     */
    public function start(Request $request, int $quizId): RedirectResponse
    {
        $user = $request->user();
        $quiz = Quiz::where('id', $quizId)->with('questions.options')->firstOrFail();

        if ($quiz->questions->isEmpty()) {
            return back()->with('error', 'Kuis ini belum memiliki soal.');
        }

        // Find or create in-progress attempt
        $attempt = QuizAttempt::firstOrCreate(
            [
                'user_id' => $user->id,
                'quiz_id' => $quiz->id,
                'status' => 'in_progress',
            ],
            [
                'subject_id' => $quiz->subject_id,
                'learning_level_id' => $quiz->learning_level_id,
                'type' => $quiz->type,
                'start_time' => now(),
                'total_questions' => $quiz->questions->count(),
            ]
        );

        // Check if time expired
        $durationMinutes = $quiz->duration_minutes;
        $expiryTime = $attempt->start_time->copy()->addMinutes($durationMinutes);

        if (now()->greaterThanOrEqualTo($expiryTime)) {
            // Auto submit expired attempt
            return $this->autoSubmitExpiredAttempt($attempt);
        }

        return redirect()->route('quiz.attempt', ['attemptId' => $attempt->id, 'qIndex' => 1]);
    }

    /**
     * The quiz answering arena (Timed!).
     */
    public function attempt(Request $request, int $attemptId, int $qIndex = 1): View|RedirectResponse
    {
        $user = $request->user();
        $attempt = QuizAttempt::where('id', $attemptId)->where('user_id', $user->id)->firstOrFail();

        if ($attempt->status !== 'in_progress') {
            return redirect()->route('results.show', $attempt->id);
        }

        $quiz = $attempt->quiz;
        $durationMinutes = $quiz ? $quiz->duration_minutes : 30;
        $expiryTime = $attempt->start_time->copy()->addMinutes($durationMinutes);

        // Check if time has expired
        if (now()->greaterThanOrEqualTo($expiryTime)) {
            return $this->autoSubmitExpiredAttempt($attempt);
        }

        $remainingSeconds = max(0, (int) now()->diffInSeconds($expiryTime, false));

        // Questions in quiz
        $questions = $quiz->questions()->with('options')->get();
        $totalQuestions = $questions->count();

        if ($qIndex < 1 || $qIndex > $totalQuestions) {
            $qIndex = 1;
        }

        $currentQuestion = $questions->values()->get($qIndex - 1);

        // Get student's current selected option for this question (if any)
        $currentAnswer = UserAnswer::where('quiz_attempt_id', $attempt->id)
            ->where('question_id', $currentQuestion->id)
            ->first();

        // Map of answered question IDs for progress indicators (NO correct/incorrect revealed!)
        $answeredQuestionIds = UserAnswer::where('quiz_attempt_id', $attempt->id)
            ->whereNotNull('selected_option_id')
            ->pluck('question_id')
            ->toArray();

        return view('user.quiz.attempt', compact(
            'attempt',
            'quiz',
            'questions',
            'currentQuestion',
            'qIndex',
            'totalQuestions',
            'currentAnswer',
            'answeredQuestionIds',
            'remainingSeconds'
        ));
    }

    /**
     * Save an answer during quiz (Silent save - NO correct/incorrect revealed!).
     */
    public function saveAnswer(Request $request, int $attemptId, int $questionId): JsonResponse
    {
        $request->validate([
            'option_id' => ['nullable', 'exists:question_options,id'],
            'selected_options' => ['nullable', 'array'],
            'selected_options.*' => ['integer', 'exists:question_options,id'],
        ]);

        $user = $request->user();
        $attempt = QuizAttempt::where('id', $attemptId)->where('user_id', $user->id)->firstOrFail();

        if ($attempt->status !== 'in_progress') {
            return response()->json(['error' => 'Kuis sudah berakhir.'], 400);
        }

        $question = Question::with('options')->findOrFail($questionId);

        if ($question->isMultiple() || $request->has('selected_options')) {
            $selectedIds = collect($request->input('selected_options', []))
                ->map(fn ($id) => (int) $id)
                ->sort()
                ->values()
                ->toArray();

            $correctIds = $question->options->where('is_correct', true)
                ->pluck('id')
                ->map(fn ($id) => (int) $id)
                ->sort()
                ->values()
                ->toArray();

            $isCorrect = ($selectedIds === $correctIds);
            $primaryId = ! empty($selectedIds) ? $selectedIds[0] : null;

            UserAnswer::updateOrCreate(
                [
                    'quiz_attempt_id' => $attempt->id,
                    'question_id' => $question->id,
                ],
                [
                    'selected_option_id' => $primaryId,
                    'selected_options' => $selectedIds,
                    'is_correct' => $isCorrect,
                ]
            );

            return response()->json([
                'success' => true,
                'message' => 'Jawaban disimpan',
                'question_id' => $question->id,
                'selected_options' => $selectedIds,
            ]);
        }

        $selectedOption = QuestionOption::where('id', $request->option_id)
            ->where('question_id', $question->id)
            ->firstOrFail();

        // Calculate is_correct internally, but DO NOT return it to frontend!
        $isCorrect = (bool) $selectedOption->is_correct;

        UserAnswer::updateOrCreate(
            [
                'quiz_attempt_id' => $attempt->id,
                'question_id' => $question->id,
            ],
            [
                'selected_option_id' => $selectedOption->id,
                'selected_options' => [$selectedOption->id],
                'is_correct' => $isCorrect,
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Jawaban disimpan',
            'question_id' => $question->id,
            'selected_option_id' => $selectedOption->id,
        ]);
    }

    /**
     * Submit and finish the quiz (manual or via auto submit).
     */
    public function finish(Request $request, int $attemptId): RedirectResponse
    {
        $user = $request->user();
        $attempt = QuizAttempt::where('id', $attemptId)->where('user_id', $user->id)->firstOrFail();

        return $this->finalizeAttempt($attempt);
    }

    /**
     * Finalize and calculate score for attempt.
     */
    protected function finalizeAttempt(QuizAttempt $attempt): RedirectResponse
    {
        $answers = UserAnswer::where('quiz_attempt_id', $attempt->id)->get();
        $correctCount = $answers->where('is_correct', true)->count();
        $incorrectCount = $answers->where('is_correct', false)->whereNotNull('selected_option_id')->count();
        $unanswered = max(0, $attempt->total_questions - $answers->whereNotNull('selected_option_id')->count());

        $score = $attempt->total_questions > 0
            ? ($correctCount / $attempt->total_questions) * 100
            : 0;

        $attempt->update([
            'end_time' => now(),
            'correct_answers' => $correctCount,
            'incorrect_answers' => $incorrectCount,
            'unanswered' => $unanswered,
            'score' => $score,
            'status' => 'completed',
        ]);

        // If quiz was for a level and passed, mark level complete!
        if ($attempt->learning_level_id) {
            $level = LearningLevel::find($attempt->learning_level_id);
            if ($level && $score >= $level->min_score_to_unlock) {
                LearningProgress::updateOrCreate(
                    [
                        'user_id' => $attempt->user_id,
                        'learning_level_id' => $level->id,
                    ],
                    [
                        'status' => 'completed',
                        'score' => $score,
                        'completed_at' => now(),
                    ]
                );
            }
        }

        return redirect()->route('results.show', $attempt->id);
    }

    protected function autoSubmitExpiredAttempt(QuizAttempt $attempt): RedirectResponse
    {
        $attempt->status = 'expired';

        return $this->finalizeAttempt($attempt);
    }
}
