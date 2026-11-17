<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\QuizAttempt;
use App\Models\UserAnswer;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ResultController extends Controller
{
    /**
     * Show comprehensive quiz / practice / tryout results with full explanations.
     */
    public function show(Request $request, int $attemptId): View
    {
        $user = $request->user();
        $attempt = QuizAttempt::where('id', $attemptId)
            ->where('user_id', $user->id)
            ->with(['quiz', 'subject', 'learningLevel'])
            ->firstOrFail();

        // Get all user answers with question, options, and selected option
        $userAnswers = UserAnswer::where('quiz_attempt_id', $attempt->id)
            ->with(['question.options', 'selectedOption'])
            ->get();

        // Time taken
        $durationSeconds = 0;
        if ($attempt->start_time && $attempt->end_time) {
            $durationSeconds = $attempt->start_time->diffInSeconds($attempt->end_time);
        }

        $durationFormatted = sprintf(
            '%d menit %d detik',
            floor($durationSeconds / 60),
            $durationSeconds % 60
        );

        return view('user.results.show', compact('attempt', 'userAnswers', 'durationFormatted'));
    }
}
