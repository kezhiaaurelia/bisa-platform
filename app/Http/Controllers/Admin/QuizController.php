<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\Subject;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class QuizController extends Controller
{
    public function index(): View
    {
        $quizzes = Quiz::with(['category', 'subject'])->withCount('questions')->latest()->paginate(15);

        return view('admin.quizzes.index', compact('quizzes'));
    }

    public function create(): View
    {
        $categories = Category::ordered()->get();
        $subjects = Subject::ordered()->with('category')->get();
        $questions = Question::where('is_active', true)->with('subject')->latest()->get();

        return view('admin.quizzes.create', compact('categories', 'subjects', 'questions'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'subject_id' => ['nullable', 'exists:subjects,id'],
            'description' => ['nullable', 'string'],
            'type' => ['required', 'in:quiz,tryout'],
            'duration_minutes' => ['required', 'integer', 'min:1', 'max:300'], // Configurable duration!
            'pass_percentage' => ['required', 'integer', 'min:1', 'max:100'],
            'difficulty' => ['required', 'in:easy,medium,hard'],
            'is_active' => ['boolean'],
            'questions' => ['nullable', 'array'],
            'questions.*' => ['exists:questions,id'],
        ]);

        $validated['slug'] = Str::slug($validated['title']).'-'.rand(100, 999);
        $validated['is_active'] = $request->boolean('is_active', true);

        $quiz = Quiz::create($validated);

        if (! empty($validated['questions'])) {
            $quiz->questions()->sync($validated['questions']);
        }

        return redirect()->route('admin.quizzes.index')->with('success', 'Kuis/Tryout berhasil dibuat dengan durasi '.$validated['duration_minutes'].' menit.');
    }

    public function edit(Quiz $quiz): View
    {
        $quiz->load('questions');
        $categories = Category::ordered()->get();
        $subjects = Subject::ordered()->with('category')->get();
        $questions = Question::where('is_active', true)->with('subject')->latest()->get();

        return view('admin.quizzes.edit', compact('quiz', 'categories', 'subjects', 'questions'));
    }

    public function update(Request $request, Quiz $quiz): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'subject_id' => ['nullable', 'exists:subjects,id'],
            'description' => ['nullable', 'string'],
            'type' => ['required', 'in:quiz,tryout'],
            'duration_minutes' => ['required', 'integer', 'min:1', 'max:300'],
            'pass_percentage' => ['required', 'integer', 'min:1', 'max:100'],
            'difficulty' => ['required', 'in:easy,medium,hard'],
            'is_active' => ['boolean'],
            'questions' => ['nullable', 'array'],
            'questions.*' => ['exists:questions,id'],
        ]);

        $validated['is_active'] = $request->boolean('is_active');
        $quiz->update($validated);

        if (isset($validated['questions'])) {
            $quiz->questions()->sync($validated['questions']);
        }

        return redirect()->route('admin.quizzes.index')->with('success', 'Kuis/Tryout berhasil diperbarui.');
    }

    public function destroy(Quiz $quiz): RedirectResponse
    {
        $quiz->delete();

        return redirect()->route('admin.quizzes.index')->with('success', 'Kuis/Tryout berhasil dihapus.');
    }
}
