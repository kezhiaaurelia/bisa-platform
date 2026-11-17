<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\QuizAttempt;
use App\Models\Subject;
use App\Models\UserAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ProgressController extends Controller
{
    /**
     * Show comprehensive user learning progress & stats.
     */
    public function index(Request $request): View
    {
        $user = $request->user();

        // 1. Overall Category Progress
        $categories = Category::active()->ordered()->with('subjects.learningLevels')->get();
        $categoryProgress = [];

        foreach ($categories as $cat) {
            $totalLevels = 0;
            $completedLevels = 0;

            foreach ($cat->subjects as $subj) {
                $totalLevels += $subj->learningLevels->count();
                $completedLevels += $subj->learningLevels->filter(function ($lvl) use ($user) {
                    return $lvl->getUserStatus($user) === 'completed';
                })->count();
            }

            $percentage = $totalLevels > 0 ? round(($completedLevels / $totalLevels) * 100) : 0;
            $categoryProgress[$cat->slug] = [
                'name' => $cat->name,
                'percentage' => $percentage,
                'completed' => $completedLevels,
                'total' => $totalLevels,
            ];
        }

        // 2. Activity Metrics
        $totalQuestions = UserAnswer::whereHas('attempt', fn ($q) => $q->where('user_id', $user->id))->count();
        $totalCorrect = UserAnswer::whereHas('attempt', fn ($q) => $q->where('user_id', $user->id))->where('is_correct', true)->count();
        $totalIncorrect = UserAnswer::whereHas('attempt', fn ($q) => $q->where('user_id', $user->id))->where('is_correct', false)->count();

        $totalPractices = QuizAttempt::where('user_id', $user->id)->where('type', 'practice')->where('status', 'completed')->count();
        $totalQuizzes = QuizAttempt::where('user_id', $user->id)->where('type', 'quiz')->where('status', 'completed')->count();
        $totalTryouts = QuizAttempt::where('user_id', $user->id)->where('type', 'tryout')->where('status', 'completed')->count();

        $avgScore = QuizAttempt::where('user_id', $user->id)->where('status', 'completed')->avg('score') ?? 0;

        // 3. Subject Mastery Analysis (Paling dikuasai vs Perlu ditingkatkan)
        $subjectScores = QuizAttempt::where('user_id', $user->id)
            ->whereNotNull('subject_id')
            ->where('status', 'completed')
            ->select('subject_id', DB::raw('AVG(score) as avg_score'), DB::raw('COUNT(*) as total_attempts'))
            ->groupBy('subject_id')
            ->with('subject')
            ->get();

        $strongestSubject = $subjectScores->sortByDesc('avg_score')->first();
        $weakestSubject = $subjectScores->sortBy('avg_score')->first();

        // 4. Detailed History (Latihan vs Kuis)
        $practiceHistory = QuizAttempt::where('user_id', $user->id)
            ->where('type', 'practice')
            ->with('subject')
            ->latest()
            ->take(10)
            ->get();

        $quizHistory = QuizAttempt::where('user_id', $user->id)
            ->whereIn('type', ['quiz', 'tryout'])
            ->with(['quiz', 'subject'])
            ->latest()
            ->take(10)
            ->get();

        return view('user.progress.index', compact(
            'user',
            'categoryProgress',
            'totalQuestions',
            'totalCorrect',
            'totalIncorrect',
            'totalPractices',
            'totalQuizzes',
            'totalTryouts',
            'avgScore',
            'strongestSubject',
            'weakestSubject',
            'practiceHistory',
            'quizHistory'
        ));
    }
}
