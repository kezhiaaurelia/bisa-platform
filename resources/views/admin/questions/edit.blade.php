@extends('layouts.admin')

@section('title', 'Edit Soal — BISA')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-black text-charcoal-dark">Edit Soal</h1>
            <p class="text-xs text-gray-500 mt-1">Perbarui data pertanyaan, pilihan jawaban, kunci, atau pembahasan.</p>
        </div>
        <a href="{{ route('admin.questions.index') }}" class="text-xs font-bold text-gray-500 hover:text-charcoal">
            ← Kembali
        </a>
    </div>

    @if ($errors->any())
        <div class="p-4 bg-danger-light border border-danger/20 rounded-2xl text-xs text-danger">
            <ul class="list-disc list-inside space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-3xl p-8 border border-gray-200/80 shadow-sm">
        <form action="{{ route('admin.questions.update', $question->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid sm:grid-cols-2 gap-4">
                <div>
                    <label for="subject_id" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1.5">Mata Pelajaran / Subtes</label>
                    <select id="subject_id" name="subject_id" required
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:border-bisa focus:ring-2 focus:ring-bisa/20 focus:outline-none bg-white">
                        @foreach($subjects as $s)
                            <option value="{{ $s->id }}" {{ old('subject_id', $question->subject_id) == $s->id ? 'selected' : '' }}>
                                {{ $s->category ? $s->category->name . ' - ' : '' }}{{ $s->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="difficulty" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1.5">Tingkat Kesulitan</label>
                    <select id="difficulty" name="difficulty" required
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:border-bisa focus:ring-2 focus:ring-bisa/20 focus:outline-none bg-white">
                        <option value="easy" {{ old('difficulty', $question->difficulty) === 'easy' ? 'selected' : '' }}>Mudah (Easy)</option>
                        <option value="medium" {{ old('difficulty', $question->difficulty) === 'medium' ? 'selected' : '' }}>Sedang (Medium)</option>
                        <option value="hard" {{ old('difficulty', $question->difficulty) === 'hard' ? 'selected' : '' }}>Sulit (Hard)</option>
                    </select>
                </div>
            </div>

            <div>
                <label for="question_text" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1.5">Teks Pertanyaan / Soal</label>
                <textarea id="question_text" name="question_text" rows="4" required
                    class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:border-bisa focus:ring-2 focus:ring-bisa/20 focus:outline-none">{{ old('question_text', $question->question_text) }}</textarea>
            </div>

            {{-- Options A-E --}}
            <div class="space-y-3 pt-2">
                <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider">Pilihan Jawaban & Kunci</label>

                @php
                    $correctOption = $question->options->firstWhere('is_correct', true);
                    $currentCorrectKey = $correctOption ? $correctOption->option_key : 'A';
                @endphp

                @foreach(['A', 'B', 'C', 'D', 'E'] as $key)
                    @php
                        $optModel = $question->options->firstWhere('option_key', $key);
                        $optText = $optModel ? $optModel->option_text : '';
                    @endphp

                    <div class="flex items-center gap-3 p-3 rounded-2xl border border-gray-100 bg-gray-50/50">
                        <label class="flex items-center gap-2 cursor-pointer select-none">
                            <input type="radio" name="correct_answer" value="{{ $key }}" {{ old('correct_answer', $currentCorrectKey) === $key ? 'checked' : '' }}
                                class="w-4 h-4 text-bisa border-gray-300 focus:ring-bisa">
                            <span class="w-6 h-6 rounded-lg bg-charcoal text-white font-bold text-xs flex items-center justify-center">
                                {{ $key }}
                            </span>
                        </label>
                        <input type="text" name="options[{{ $key }}]" value="{{ old('options.' . $key, $optText) }}"
                            placeholder="Teks pilihan jawaban {{ $key }}"
                            {{ in_array($key, ['A','B','C','D']) ? 'required' : '' }}
                            id="option_input_{{ $key }}"
                            class="flex-1 px-3.5 py-2 rounded-xl border border-gray-200 text-sm focus:border-bisa focus:ring-2 focus:ring-bisa/20 focus:outline-none bg-white">
                    </div>
                @endforeach
            </div>

            {{-- Explanation --}}
            <div class="pt-4 border-t border-gray-100 space-y-3">
                <div class="flex items-center justify-between">
                    <label for="explanation" class="block text-xs font-semibold text-charcoal-dark uppercase tracking-wider">
                        💡 Pembahasan Soal
                    </label>
                    <button type="button" onclick="generateAiDraft()"
                        class="px-3 py-1.5 bg-purple-50 hover:bg-purple-100 text-purple-700 text-xs font-bold rounded-xl border border-purple-200 transition flex items-center gap-1.5">
                        <span>🤖 Bantu dengan AI</span>
                    </button>
                </div>

                <div class="flex items-center gap-6 text-xs text-gray-700 py-1">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" name="explanation_source" value="manual" {{ old('explanation_source', $question->explanation_source) === 'manual' ? 'checked' : '' }} id="source_manual" class="text-bisa focus:ring-bisa">
                        <span>Pembahasan Manual</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" name="explanation_source" value="ai" {{ old('explanation_source', $question->explanation_source) === 'ai' ? 'checked' : '' }} id="source_ai" class="text-purple-600 focus:ring-purple-600">
                        <span>Pembahasan AI</span>
                    </label>

                    <div class="ml-auto flex items-center gap-2">
                        <span class="text-gray-400 text-[11px]">Status:</span>
                        <select name="explanation_status" class="px-2.5 py-1 rounded-lg border border-gray-200 text-xs bg-white">
                            <option value="published" {{ old('explanation_status', $question->explanation_status) === 'published' ? 'selected' : '' }}>Dipublikasikan</option>
                            <option value="draft" {{ old('explanation_status', $question->explanation_status) === 'draft' ? 'selected' : '' }}>Draf</option>
                        </select>
                    </div>
                </div>

                <textarea id="explanation" name="explanation" rows="4"
                    class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:border-bisa focus:ring-2 focus:ring-bisa/20 focus:outline-none">{{ old('explanation', $question->explanation) }}</textarea>
            </div>

            <div class="pt-2">
                <label class="flex items-center gap-2 cursor-pointer select-none text-sm text-gray-700">
                    <input type="checkbox" name="is_active" value="1" {{ $question->is_active ? 'checked' : '' }} class="w-4 h-4 text-bisa rounded border-gray-300 focus:ring-bisa">
                    <span>Soal aktif dan dapat dikerjakan siswa</span>
                </label>
            </div>

            <div class="pt-6 border-t border-gray-100 flex justify-end gap-3">
                <a href="{{ route('admin.questions.index') }}" class="px-5 py-2.5 rounded-xl border border-gray-200 text-xs font-bold text-gray-600 hover:bg-gray-50">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-bisa hover:bg-bisa-dark text-white text-xs font-bold transition shadow-sm">
                    Simpan Perubahan Soal
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function generateAiDraft() {
        const questionText = document.getElementById('question_text').value;
        const correctRadio = document.querySelector('input[name="correct_answer"]:checked');
        const correctKey = correctRadio ? correctRadio.value : 'A';
        const correctInput = document.getElementById('option_input_' + correctKey);
        const correctText = correctInput ? correctInput.value : '';

        fetch('{{ route('admin.questions.aiExplanation') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                question_text: questionText,
                correct_answer: correctKey,
                correct_text: correctText
            })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                document.getElementById('explanation').value = data.draft;
                document.getElementById('source_ai').checked = true;
                alert('Draf pembahasan AI berhasil di-generate! Silakan edit sebelum disimpan.');
            }
        });
    }
</script>
@endpush
@endsection

