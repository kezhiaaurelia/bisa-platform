<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\LearningLevel;
use App\Models\LearningProgress;
use App\Models\Question;
use App\Models\QuestionOption;
use App\Models\QuizAttempt;
use App\Models\Subject;
use App\Models\UserAnswer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PracticeController extends Controller
{
    /**
     * List subjects for practice mode.
     */
    public function index(Request $request): View
    {
        $categories = Category::active()->ordered()->with(['subjects' => function ($q) {
            $q->active()->ordered();
        }])->get();

        return view('user.practice.index', compact('categories'));
    }

    /**
     * Start or resume a practice session.
     */
    public function start(Request $request, int $subjectId): RedirectResponse
    {
        $user = $request->user();
        $subject = Subject::findOrFail($subjectId);
        $levelId = $request->query('levelId');

        $query = Question::where('subject_id', $subjectId)->where('is_active', true);
        if ($levelId) {
            $query->where('learning_level_id', $levelId);
        }

        $questions = $query->with('options')->get();

        if ($questions->isEmpty()) {
            // If specific level has no questions, fallback to subject questions
            $questions = Question::where('subject_id', $subjectId)->where('is_active', true)->with('options')->get();
        }

        if ($questions->isEmpty()) {
            return back()->with('error', 'Belum ada soal tersedia untuk mata pelajaran ini.');
        }

        // Find or create in-progress practice attempt
        $attempt = QuizAttempt::firstOrCreate(
            [
                'user_id' => $user->id,
                'subject_id' => $subject->id,
                'learning_level_id' => $levelId,
                'type' => 'practice',
                'status' => 'in_progress',
            ],
            [
                'start_time' => now(),
                'total_questions' => $questions->count(),
            ]
        );

        return redirect()->route('practice.show', ['attemptId' => $attempt->id, 'qIndex' => 1]);
    }

    /**
     * Show a question in practice mode.
     */
    public function show(Request $request, int $attemptId, int $qIndex = 1): View|RedirectResponse
    {
        $user = $request->user();
        $attempt = QuizAttempt::where('id', $attemptId)->where('user_id', $user->id)->firstOrFail();

        $query = Question::where('subject_id', $attempt->subject_id)->where('is_active', true);
        if ($attempt->learning_level_id) {
            $query->where('learning_level_id', $attempt->learning_level_id);
        }

        $questions = $query->with('options')->get();
        if ($questions->isEmpty()) {
            $questions = Question::where('subject_id', $attempt->subject_id)->where('is_active', true)->with('options')->get();
        }

        $totalQuestions = $questions->count();
        if ($qIndex < 1 || $qIndex > $totalQuestions) {
            $qIndex = 1;
        }

        $currentQuestion = $questions->values()->get($qIndex - 1);

        // Check if user already answered this question in this attempt
        $existingAnswer = UserAnswer::where('quiz_attempt_id', $attempt->id)
            ->where('question_id', $currentQuestion->id)
            ->with('selectedOption')
            ->first();

        // All answers in this attempt for question navigator
        $answeredQuestionIds = UserAnswer::where('quiz_attempt_id', $attempt->id)
            ->pluck('is_correct', 'question_id')
            ->toArray();

        return view('user.practice.show', compact(
            'attempt',
            'questions',
            'currentQuestion',
            'qIndex',
            'totalQuestions',
            'existingAnswer',
            'answeredQuestionIds'
        ));
    }

    /**
     * Answer a question in practice mode (Instant feedback!).
     */
    public function answer(Request $request, int $attemptId, int $questionId): JsonResponse
    {
        $request->validate([
            'option_id' => ['nullable', 'exists:question_options,id'],
            'selected_options' => ['nullable', 'array'],
            'selected_options.*' => ['integer', 'exists:question_options,id'],
        ]);

        $user = $request->user();
        $attempt = QuizAttempt::where('id', $attemptId)->where('user_id', $user->id)->firstOrFail();
        $question = Question::where('id', $questionId)->with('options')->firstOrFail();

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
                'is_multiple' => true,
                'is_correct' => $isCorrect,
                'selected_options' => $selectedIds,
                'correct_options' => $correctIds,
                'correct_keys' => $question->options->where('is_correct', true)->pluck('option_key')->toArray(),
                'explanation' => $question->explanation,
            ]);
        }

        $selectedOption = QuestionOption::where('id', $request->option_id)->where('question_id', $question->id)->firstOrFail();
        $isCorrect = (bool) $selectedOption->is_correct;
        $correctOption = $question->options->firstWhere('is_correct', true);

        // Save or update user answer
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
            'is_multiple' => false,
            'is_correct' => $isCorrect,
            'selected_option_id' => $selectedOption->id,
            'correct_option_id' => $correctOption ? $correctOption->id : null,
            'correct_option_key' => $correctOption ? $correctOption->option_key : null,
            'explanation' => $question->explanation,
        ]);
    }

    /**
     * Finish practice session and update progress.
     */
    public function finish(Request $request, int $attemptId): RedirectResponse
    {
        $user = $request->user();
        $attempt = QuizAttempt::where('id', $attemptId)->where('user_id', $user->id)->firstOrFail();

        $answers = UserAnswer::where('quiz_attempt_id', $attempt->id)->get();
        $correctCount = $answers->where('is_correct', true)->count();
        $incorrectCount = $answers->where('is_correct', false)->count();
        $unanswered = max(0, $attempt->total_questions - $answers->count());

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

        // If this practice was for a learning level and score meets threshold, complete level!
        if ($attempt->learning_level_id) {
            $level = LearningLevel::find($attempt->learning_level_id);
            if ($level && $score >= $level->min_score_to_unlock) {
                LearningProgress::updateOrCreate(
                    [
                        'user_id' => $user->id,
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
}
