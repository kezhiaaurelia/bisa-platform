<?php

namespace App\Http\Controllers\Admin;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Models\AmbassadorApplication;
use App\Models\Category;
use App\Models\LiveClass;
use App\Models\Question;
use App\Models\QuizAttempt;
use App\Models\Subject;
use App\Models\SupportTicket;
use App\Models\Transaction;
use App\Models\TryoutEvent;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $totalUsers = User::where('role', UserRole::User)->count();
        $activeUsers = User::where('role', UserRole::User)
            ->whereNotNull('last_login_at')
            ->where('last_login_at', '>=', now()->subDays(30))
            ->count();

        $premiumUsers = User::where('is_premium', true)->count();
        $totalRevenue = Transaction::where('status', 'success')->sum('amount');
        $activeTryoutEvents = TryoutEvent::where('is_published', true)->count();
        $liveClassesCount = LiveClass::count();
        $pendingTickets = SupportTicket::where('status', 'open')->count();
        $ambassadorsCount = AmbassadorApplication::where('status', 'approved')->count();

        $totalQuestions = Question::count();
        $totalPractices = QuizAttempt::where('type', 'practice')->count();
        $totalQuizzes = QuizAttempt::where('type', 'quiz')->count();
        $totalTryouts = QuizAttempt::where('type', 'tryout')->count();

        $categoriesCount = Category::count();
        $subjectsCount = Subject::count();

        $latestUsers = User::where('role', UserRole::User)->latest()->take(6)->get();
        $latestAttempts = QuizAttempt::with(['user', 'quiz', 'subject'])->latest()->take(6)->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'activeUsers',
            'premiumUsers',
            'totalRevenue',
            'activeTryoutEvents',
            'liveClassesCount',
            'pendingTickets',
            'ambassadorsCount',
            'totalQuestions',
            'totalPractices',
            'totalQuizzes',
            'totalTryouts',
            'categoriesCount',
            'subjectsCount',
            'latestUsers',
            'latestAttempts'
        ));
    }
}
