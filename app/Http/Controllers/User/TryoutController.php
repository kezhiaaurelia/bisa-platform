<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use App\Models\TryoutEvent;
use App\Models\TryoutRegistration;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TryoutController extends Controller
{
    /**
     * List all available comprehensive tryout events & drill tryouts.
     */
    public function index(Request $request): View
    {
        $user = $request->user();
        $categories = Category::active()->ordered()->get();

        // 1. Tryout Events (SNBT, UTBK, TKA, Mandiri PTN)
        $selectedType = $request->input('type', 'all');
        $eventsQuery = TryoutEvent::where('is_published', true)->with('category')->latest();
        if ($selectedType !== 'all') {
            $eventsQuery->where('event_type', $selectedType);
        }
        $events = $eventsQuery->get();

        // User registrations for events
        $userRegistrations = TryoutRegistration::where('user_id', $user->id)
            ->pluck('status', 'tryout_event_id')
            ->toArray();

        // Standalone Tryouts Quizzes for continuous drill
        $tryouts = Quiz::where('type', 'tryout')
            ->where('is_active', true)
            ->with(['category', 'subject'])
            ->withCount('questions')
            ->latest()
            ->get();

        $completedTryouts = QuizAttempt::where('user_id', $user->id)
            ->where('type', 'tryout')
            ->where('status', 'completed')
            ->pluck('quiz_id')
            ->toArray();

        return view('user.tryouts.index', compact(
            'categories',
            'events',
            'userRegistrations',
            'tryouts',
            'completedTryouts',
            'selectedType'
        ));
    }

    /**
     * Register for a tryout event.
     */
    public function register(Request $request, int $eventId): RedirectResponse
    {
        $user = $request->user();
        $event = TryoutEvent::findOrFail($eventId);

        if ($event->is_premium && ! $user->isPremium()) {
            return redirect()->route('pricing.index')->with('warning', 'Event Tryout ini khusus untuk pengguna paket Premium. Silakan upgrade paket belajarmu!');
        }

        TryoutRegistration::firstOrCreate(
            [
                'user_id' => $user->id,
                'tryout_event_id' => $event->id,
            ],
            [
                'status' => 'registered',
            ]
        );

        return back()->with('success', "Kamu berhasil terdaftar di event {$event->title}! Siapkan dirimu saat pengerjaan dimulai.");
    }

    /**
     * Start the tryout event.
     */
    public function start(Request $request, int $eventId): RedirectResponse
    {
        $user = $request->user();
        $event = TryoutEvent::findOrFail($eventId);

        if ($event->is_premium && ! $user->isPremium()) {
            return redirect()->route('pricing.index')->with('warning', 'Event ini memerlukan akses akun Premium.');
        }

        $registration = TryoutRegistration::where('user_id', $user->id)
            ->where('tryout_event_id', $event->id)
            ->first();

        if (! $registration) {
            $registration = TryoutRegistration::create([
                'user_id' => $user->id,
                'tryout_event_id' => $event->id,
                'status' => 'registered',
            ]);
        }

        // Find or create quiz for tryout event
        $quiz = Quiz::where('type', 'tryout')->where('is_active', true)->first();
        if (! $quiz) {
            return back()->with('error', 'Bank soal untuk simulasi tryout ini sedang dipersiapkan.');
        }

        $attempt = QuizAttempt::firstOrCreate(
            [
                'user_id' => $user->id,
                'quiz_id' => $quiz->id,
                'status' => 'in_progress',
            ],
            [
                'start_time' => now(),
                'total_questions' => $quiz->questions()->count(),
                'type' => 'tryout',
            ]
        );

        $registration->update([
            'quiz_attempt_id' => $attempt->id,
            'status' => 'in_progress',
        ]);

        return redirect()->route('quiz.attempt', ['attemptId' => $attempt->id, 'qIndex' => 1]);
    }

    /**
     * View National Ranking (Leaderboard) & Subtest Analysis for an event.
     */
    public function leaderboard(Request $request, int $eventId): View
    {
        $user = $request->user();
        $event = TryoutEvent::findOrFail($eventId);

        // Fetch registered participants with scores
        $rankings = TryoutRegistration::where('tryout_event_id', $event->id)
            ->whereNotNull('score')
            ->with('user')
            ->orderByDesc('score')
            ->limit(50)
            ->get();

        // User's own registration in this event
        $userReg = TryoutRegistration::where('tryout_event_id', $event->id)
            ->where('user_id', $user->id)
            ->first();

        return view('user.tryouts.leaderboard', compact('event', 'rankings', 'userReg'));
    }
}
