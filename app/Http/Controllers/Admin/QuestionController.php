<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\QuestionOption;
use App\Models\Subject;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class QuestionController extends Controller
{
    public function index(Request $request): View
    {
        $subjectId = $request->query('subject_id');
        $difficulty = $request->query('difficulty');
        $source = $request->query('source');

        $query = Question::with(['subject.category', 'options'])->latest();

        if ($subjectId) {
            $query->where('subject_id', $subjectId);
        }
        if ($difficulty) {
            $query->where('difficulty', $difficulty);
        }
        if ($source) {
            $query->where('explanation_source', $source);
        }

        $questions = $query->paginate(15);
        $subjects = Subject::ordered()->with('category')->get();

        return view('admin.questions.index', compact('questions', 'subjects', 'subjectId', 'difficulty', 'source'));
    }

    public function create(): View
    {
        $subjects = Subject::ordered()->with('category')->get();

        return view('admin.questions.create', compact('subjects'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'subject_id' => ['required', 'exists:subjects,id'],
            'question_text' => ['required', 'string'],
            'difficulty' => ['required', 'in:easy,medium,hard'],
            'explanation' => ['nullable', 'string'],
            'explanation_source' => ['required', 'in:manual,ai'],
            'explanation_status' => ['required', 'in:draft,published'],
            'correct_answer' => ['required', 'in:A,B,C,D,E'],
            'options' => ['required', 'array', 'min:4'],
            'options.A' => ['required', 'string'],
            'options.B' => ['required', 'string'],
            'options.C' => ['required', 'string'],
            'options.D' => ['required', 'string'],
            'options.E' => ['nullable', 'string'],
            'is_active' => ['boolean'],
        ]);

        $question = Question::create([
            'subject_id' => $validated['subject_id'],
            'question_text' => $validated['question_text'],
            'difficulty' => $validated['difficulty'],
            'explanation' => $validated['explanation'],
            'explanation_source' => $validated['explanation_source'],
            'explanation_status' => $validated['explanation_status'],
            'is_active' => $request->boolean('is_active', true),
        ]);

        foreach ($validated['options'] as $key => $text) {
            if (! empty($text)) {
                QuestionOption::create([
                    'question_id' => $question->id,
                    'option_key' => $key,
                    'option_text' => $text,
                    'is_correct' => $validated['correct_answer'] === $key,
                ]);
            }
        }

        return redirect()->route('admin.questions.index')->with('success', 'Soal berhasil ditambahkan.');
    }

    public function edit(Question $question): View
    {
        $question->load('options');
        $subjects = Subject::ordered()->with('category')->get();

        return view('admin.questions.edit', compact('question', 'subjects'));
    }

    public function update(Request $request, Question $question): RedirectResponse
    {
        $validated = $request->validate([
            'subject_id' => ['required', 'exists:subjects,id'],
            'question_text' => ['required', 'string'],
            'difficulty' => ['required', 'in:easy,medium,hard'],
            'explanation' => ['nullable', 'string'],
            'explanation_source' => ['required', 'in:manual,ai'],
            'explanation_status' => ['required', 'in:draft,published'],
            'correct_answer' => ['required', 'in:A,B,C,D,E'],
            'options' => ['required', 'array', 'min:4'],
            'options.A' => ['required', 'string'],
            'options.B' => ['required', 'string'],
            'options.C' => ['required', 'string'],
            'options.D' => ['required', 'string'],
            'options.E' => ['nullable', 'string'],
            'is_active' => ['boolean'],
        ]);

        $question->update([
            'subject_id' => $validated['subject_id'],
            'question_text' => $validated['question_text'],
            'difficulty' => $validated['difficulty'],
            'explanation' => $validated['explanation'],
            'explanation_source' => $validated['explanation_source'],
            'explanation_status' => $validated['explanation_status'],
            'is_active' => $request->boolean('is_active'),
        ]);

        // Update or recreate options
        $question->options()->delete();
        foreach ($validated['options'] as $key => $text) {
            if (! empty($text)) {
                QuestionOption::create([
                    'question_id' => $question->id,
                    'option_key' => $key,
                    'option_text' => $text,
                    'is_correct' => $validated['correct_answer'] === $key,
                ]);
            }
        }

        return redirect()->route('admin.questions.index')->with('success', 'Soal berhasil diperbarui.');
    }

    public function destroy(Question $question): RedirectResponse
    {
        $question->delete();

        return redirect()->route('admin.questions.index')->with('success', 'Soal berhasil dihapus.');
    }

    /**
     * AI Assistance Stub: Generate an educational explanation draft for admin preview & editing (Section 15).
     */
    public function generateAiExplanation(Request $request): JsonResponse
    {
        $questionText = $request->input('question_text');
        $correctKey = $request->input('correct_answer');
        $correctText = $request->input('correct_text');

        // AI generated educational draft analysis
        $draft = "Analisis Konsep:\n".
                 "Soal ini menguji pemahaman mengenai logika dan penalaran deduktif.\n\n".
                 "Langkah Pembahasan:\n".
                 "1. Identifikasi premis utama dan kata kunci dalam pertanyaan.\n".
                 "2. Eliminasi opsi jawaban yang kontradiktif atau tidak didukung premis.\n".
                 "3. Opsi ({$correctKey}) '{$correctText}' merupakan simpulan yang paling valid dan konsisten secara kaidah akademik.";

        return response()->json([
            'success' => true,
            'draft' => $draft,
            'source' => 'ai',
        ]);
    }
}
