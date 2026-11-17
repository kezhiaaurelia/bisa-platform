@extends('layouts.admin')

@section('title', 'Kelola Bank Soal — BISA')

@section('content')
<div class="space-y-6">

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-charcoal-dark">Bank Soal Akademik</h1>
            <p class="text-xs text-gray-500 mt-1">Kelola pertanyaan, pilihan jawaban A-E, kunci jawaban, dan pembahasan (Manual / AI).</p>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('admin.import.index') }}" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-charcoal text-xs font-bold rounded-xl transition flex items-center gap-1.5">
                <span>📥 Import Excel</span>
            </a>
            <a href="{{ route('admin.questions.create') }}" class="px-4 py-2 bg-bisa hover:bg-bisa-dark text-white text-xs font-bold rounded-xl transition shadow-sm">
                + Tambah Soal Manual
            </a>
        </div>
    </div>

    {{-- Filter bar --}}
    <div class="bg-white p-4 rounded-2xl border border-gray-200/80 shadow-sm flex flex-wrap items-center gap-4 text-xs">
        <form method="GET" action="{{ route('admin.questions.index') }}" class="flex flex-wrap items-center gap-3 w-full sm:w-auto">
            <select name="subject_id" onchange="this.form.submit()" class="px-3 py-2 rounded-xl border border-gray-200 bg-white">
                <option value="">-- Semua Subtes --</option>
                @foreach($subjects as $s)
                    <option value="{{ $s->id }}" {{ $subjectId == $s->id ? 'selected' : '' }}>
                        {{ $s->category ? $s->category->name . ' - ' : '' }}{{ $s->name }}
                    </option>
                @endforeach
            </select>

            <select name="difficulty" onchange="this.form.submit()" class="px-3 py-2 rounded-xl border border-gray-200 bg-white">
                <option value="">-- Semua Kesulitan --</option>
                <option value="easy" {{ $difficulty === 'easy' ? 'selected' : '' }}>Mudah (Easy)</option>
                <option value="medium" {{ $difficulty === 'medium' ? 'selected' : '' }}>Sedang (Medium)</option>
                <option value="hard" {{ $difficulty === 'hard' ? 'selected' : '' }}>Sulit (Hard)</option>
            </select>

            <select name="source" onchange="this.form.submit()" class="px-3 py-2 rounded-xl border border-gray-200 bg-white">
                <option value="">-- Sumber Pembahasan --</option>
                <option value="manual" {{ $source === 'manual' ? 'selected' : '' }}>Manual</option>
                <option value="ai" {{ $source === 'ai' ? 'selected' : '' }}>AI Assistant</option>
            </select>

            @if($subjectId || $difficulty || $source)
                <a href="{{ route('admin.questions.index') }}" class="text-xs text-danger font-semibold hover:underline">Reset Filter</a>
            @endif
        </form>
    </div>

    {{-- Questions Table --}}
    <div class="bg-white rounded-3xl border border-gray-200/80 shadow-sm overflow-hidden">
        <table class="w-full text-left text-xs text-charcoal">
            <thead class="bg-gray-50 border-b border-gray-200 text-[11px] font-extrabold uppercase tracking-wider text-gray-500">
                <tr>
                    <th class="p-4 w-1/3">Pertanyaan</th>
                    <th class="p-4">Subtes / Kategori</th>
                    <th class="p-4 text-center">Kunci</th>
                    <th class="p-4 text-center">Kesulitan</th>
                    <th class="p-4 text-center">Pembahasan</th>
                    <th class="p-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($questions as $q)
                    @php $correct = $q->options->firstWhere('is_correct', true); @endphp
                    <tr class="hover:bg-gray-50/50 transition">
                        <td class="p-4">
                            <div class="font-bold text-charcoal-dark line-clamp-2 leading-relaxed">
                                {{ $q->question_text }}
                            </div>
                            <div class="text-[10px] text-gray-400 mt-1">
                                {{ $q->options->count() }} Pilihan Jawaban
                            </div>
                        </td>
                        <td class="p-4">
                            <span class="font-bold text-charcoal">{{ $q->subject ? $q->subject->name : '—' }}</span>
                            <div class="text-[10px] text-gray-400">
                                {{ $q->subject && $q->subject->category ? $q->subject->category->name : '' }}
                            </div>
                        </td>
                        <td class="p-4 text-center">
                            <span class="w-7 h-7 rounded-lg bg-success-light text-success font-black text-xs inline-flex items-center justify-center border border-success/30">
                                {{ $correct ? $correct->option_key : '—' }}
                            </span>
                        </td>
                        <td class="p-4 text-center">
                            <span class="px-2 py-0.5 rounded-md text-[10px] font-bold uppercase
                                {{ $q->difficulty === 'easy' ? 'bg-emerald-50 text-emerald-700' : '' }}
                                {{ $q->difficulty === 'medium' ? 'bg-amber-50 text-amber-700' : '' }}
                                {{ $q->difficulty === 'hard' ? 'bg-rose-50 text-rose-700' : '' }}
                            ">
                                {{ $q->difficulty }}
                            </span>
                        </td>
                        <td class="p-4 text-center">
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold {{ $q->explanation_source === 'ai' ? 'bg-purple-100 text-purple-700' : 'bg-gray-100 text-gray-700' }}">
                                {{ $q->explanation_source === 'ai' ? '🤖 AI Draft' : '✍️ Manual' }}
                            </span>
                        </td>
                        <td class="p-4 text-right space-x-2">
                            <a href="{{ route('admin.questions.edit', $q->id) }}" class="text-bisa font-bold hover:underline">Edit</a>
                            <form action="{{ route('admin.questions.destroy', $q->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus soal ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-danger font-bold hover:underline">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="p-8 text-center text-gray-400">Belum ada soal dalam bank soal.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        @if($questions->hasPages())
            <div class="p-4 border-t border-gray-100">
                {{ $questions->links() }}
            </div>
        @endif
    </div>

</div>
@endsection

