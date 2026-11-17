<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LearningMapController extends Controller
{
    /**
     * Show learning map for a category and subject.
     */
    public function show(Request $request, ?string $categorySlug = 'snbt', ?string $subjectSlug = null): View
    {
        $categories = Category::active()->ordered()->get();
        $currentCategory = Category::where('slug', $categorySlug)->firstOrFail();

        $subjects = $currentCategory->subjects()->active()->ordered()->get();

        if ($subjectSlug) {
            $currentSubject = $subjects->firstWhere('slug', $subjectSlug) ?? $subjects->first();
        } else {
            $currentSubject = $subjects->first();
        }

        $levels = collect();
        if ($currentSubject) {
            $levels = $currentSubject->learningLevels()
                ->where('is_active', true)
                ->orderBy('level_number')
                ->with(['modules', 'quizzes'])
                ->get();
        }

        $user = $request->user();

        // Compute level node states for the user
        $nodeStates = [];
        $hasFoundCurrent = false;

        foreach ($levels as $level) {
            $status = $level->getUserStatus($user);

            if ($status === 'available' && ! $hasFoundCurrent) {
                $nodeStates[$level->id] = 'current';
                $hasFoundCurrent = true;
            } else {
                $nodeStates[$level->id] = $status;
            }
        }

        return view('user.learning-map', compact(
            'categories',
            'currentCategory',
            'subjects',
            'currentSubject',
            'levels',
            'nodeStates',
            'user'
        ));
    }
}
