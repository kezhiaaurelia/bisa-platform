<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\QuizAttempt;
use App\Models\Subject;
use App\Models\UserAnswer;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AnalyticsController extends Controller
{
    public function index(Request $request): View
    {
        $totalAnswers = UserAnswer::count();
        $correctAnswers = UserAnswer::where('is_correct', true)->count();
        $accuracyRate = $totalAnswers > 0 ? round(($correctAnswers / $totalAnswers) * 100, 1) : 0;

        // Subtests performance
        $subjectStats = Subject::withCount(['questions'])
            ->get()
            ->map(function ($subj) {
                $attempts = QuizAttempt::where('subject_id', $subj->id)->whereNotNull('score')->get();
                $avgScore = $attempts->avg('score') ?? 0;

                return [
                    'name' => $subj->name,
                    'questions_count' => $subj->questions_count,
                    'avg_score' => round($avgScore, 1),
                ];
            });

        // Most challenging questions (most incorrect answers)
        $difficultQuestions = Question::with('subject')
            ->has('userAnswers')
            ->get()
            ->map(function ($q) {
                $total = $q->userAnswers()->count();
                $correct = $q->userAnswers()->where('is_correct', true)->count();
                $errorRate = $total > 0 ? round((($total - $correct) / $total) * 100, 1) : 0;

                return [
                    'id' => $q->id,
                    'subject' => $q->subject?->name,
                    'text' => $q->question_text,
                    'error_rate' => $errorRate,
                    'attempts' => $total,
                ];
            })
            ->sortByDesc('error_rate')
            ->take(5);

        return view('admin.analytics.index', compact(
            'accuracyRate',
            'totalAnswers',
            'subjectStats',
            'difficultQuestions'
        ));
    }
}

