<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\LearningProgress;
use App\Models\Module;
use App\Models\ModuleProgress;
use App\Models\Subject;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ModuleController extends Controller
{
    /**
     * List all learning modules grouped by subject.
     */
    public function index(Request $request): View
    {
        $categories = Category::active()->ordered()->with(['subjects.modules' => function ($q) {
            $q->where('is_active', true)->orderBy('order');
        }])->get();

        $user = $request->user();

        // Completed module IDs for user
        $completedModuleIds = ModuleProgress::where('user_id', $user->id)
            ->where('is_completed', true)
            ->pluck('module_id')
            ->toArray();

        return view('user.modules.index', compact('categories', 'completedModuleIds'));
    }

    /**
     * Show a specific module reader.
     */
    public function show(Request $request, int $moduleId): View
    {
        $module = Module::where('id', $moduleId)
            ->with(['subject.category', 'learningLevel'])
            ->firstOrFail();

        $user = $request->user();

        $isCompleted = ModuleProgress::where('user_id', $user->id)
            ->where('module_id', $module->id)
            ->where('is_completed', true)
            ->exists();

        // Sibling modules in the same subject
        $siblingModules = Module::where('subject_id', $module->subject_id)
            ->where('is_active', true)
            ->orderBy('order')
            ->get();

        return view('user.modules.show', compact('module', 'isCompleted', 'siblingModules'));
    }

    /**
     * Mark module as completed.
     */
    public function complete(Request $request, int $moduleId): RedirectResponse
    {
        $user = $request->user();
        $module = Module::findOrFail($moduleId);

        ModuleProgress::updateOrCreate(
            [
                'user_id' => $user->id,
                'module_id' => $module->id,
            ],
            [
                'is_completed' => true,
                'completed_at' => now(),
            ]
        );

        // If module is tied to a learning level, mark level complete!
        if ($module->learning_level_id) {
            LearningProgress::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'learning_level_id' => $module->learning_level_id,
                ],
                [
                    'status' => 'completed',
                    'score' => 100,
                    'completed_at' => now(),
                ]
            );
        }

        return back()->with('success', 'Modul berhasil ditandai selesai! XP telah ditambahkan.');
    }
}
