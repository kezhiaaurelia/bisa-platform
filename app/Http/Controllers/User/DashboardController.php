<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\QuizAttempt;
use App\Models\UserAnswer;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        // Categories with active subjects
        $categories = Category::active()->ordered()->with(['subjects' => function ($q) {
            $q->active()->ordered();
        }])->get();

        // User stats
        $totalQuestionsAnswered = UserAnswer::whereHas('attempt', fn ($q) => $q->where('user_id', $user->id))->count();
        $totalPractices = QuizAttempt::where('user_id', $user->id)->where('type', 'practice')->where('status', 'completed')->count();
        $totalQuizzes = QuizAttempt::where('user_id', $user->id)->where('type', 'quiz')->where('status', 'completed')->count();
        $totalTryouts = QuizAttempt::where('user_id', $user->id)->where('type', 'tryout')->where('status', 'completed')->count();

        $avgScore = QuizAttempt::where('user_id', $user->id)
            ->where('status', 'completed')
            ->avg('score') ?? 0;

        // Recent attempts
        $recentAttempts = QuizAttempt::where('user_id', $user->id)
            ->with(['quiz', 'subject', 'learningLevel'])
            ->latest()
            ->take(5)
            ->get();

        // Default active subject for Learning Journey preview on dashboard (e.g., SNBT Penalaran Umum)
        $featuredCategory = $categories->where('slug', 'snbt')->first() ?? $categories->first();
        $featuredSubject = $featuredCategory ? $featuredCategory->subjects->first() : null;
        $featuredLevels = $featuredSubject
            ? $featuredSubject->learningLevels()->where('is_active', true)->orderBy('level_number')->get()
            : collect();

        return view('user.dashboard', compact(
            'user',
            'categories',
            'totalQuestionsAnswered',
            'totalPractices',
            'totalQuizzes',
            'totalTryouts',
            'avgScore',
            'recentAttempts',
            'featuredSubject',
            'featuredLevels'
        ));
    }
}
