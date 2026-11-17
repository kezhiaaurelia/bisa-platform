@extends('layouts.app')

@section('title', 'Hasil Pengerjaan — BISA')

@section('content')
<div class="bg-gray-50 dark:bg-[#0E1017] min-h-screen py-10 transition-colors duration-200">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Score Summary Card --}}
        <div class="bg-white dark:bg-[#161922] rounded-3xl p-8 sm:p-10 border border-gray-100 dark:border-white/10 shadow-sm mb-8 text-center relative overflow-hidden transition-colors duration-200 animate-fade-in-down">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-bisa-100 dark:bg-bisa-900/40 text-bisa-800 dark:text-bisa-300 rounded-full text-xs font-bold uppercase tracking-wider mb-4 border border-bisa/20">
                🎉 Hasil {{ ucfirst($attempt->type) }}
            </span>

            <h1 class="text-2xl sm:text-3xl font-extrabold text-charcoal-dark dark:text-white mb-1">
                {{ $attempt->quiz ? $attempt->quiz->title : ($attempt->subject ? $attempt->subject->name : 'Sesi Latihan') }}
            </h1>
            <p class="text-xs text-gray-500 dark:text-gray-400 mb-8">
                Diselesaikan pada {{ $attempt->end_time ? $attempt->end_time->format('d M Y, H:i') : now()->format('d M Y, H:i') }} • Durasi: {{ $durationFormatted }}
            </p>

            {{-- Big Score Circle --}}
            <div class="inline-flex flex-col items-center justify-center w-36 h-36 rounded-full bg-gradient-to-tr from-bisa to-gold text-white shadow-xl shadow-bisa/20 mb-8 ring-8 ring-bisa-50 dark:ring-bisa-900/20 transform hover:scale-105 transition duration-300">
                <span class="text-xs font-bold uppercase tracking-widest text-white/80">Nilai</span>
                <span class="text-4xl font-black">{{ number_format($attempt->score, 0) }}</span>
                <span class="text-[10px] text-white/80">dari 100</span>
            </div>

            {{-- 4 Stat Badges --}}
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 max-w-2xl mx-auto pt-6 border-t border-gray-100 dark:border-white/10">
                <div class="p-3.5 rounded-2xl bg-success-light dark:bg-emerald-950/30 border border-success/20 dark:border-emerald-700/30">
                    <div class="text-xs text-success-800 dark:text-emerald-300 font-bold mb-0.5">Benar</div>
                    <div class="text-2xl font-black text-success">{{ $attempt->correct_answers }}</div>
                    <div class="text-[10px] text-gray-400">soal</div>
                </div>

                <div class="p-3.5 rounded-2xl bg-danger-light dark:bg-rose-950/30 border border-danger/20 dark:border-rose-700/30">
                    <div class="text-xs text-danger-800 dark:text-rose-300 font-bold mb-0.5">Salah</div>
                    <div class="text-2xl font-black text-danger">{{ $attempt->incorrect_answers }}</div>
                    <div class="text-[10px] text-gray-400">soal</div>
                </div>

                <div class="p-3.5 rounded-2xl bg-gray-50 dark:bg-white/5 border border-gray-200 dark:border-white/10">
                    <div class="text-xs text-gray-600 dark:text-gray-400 font-bold mb-0.5">Kosong</div>
                    <div class="text-2xl font-black text-charcoal dark:text-white">{{ $attempt->unanswered }}</div>
                    <div class="text-[10px] text-gray-400">soal</div>
                </div>

                <div class="p-3.5 rounded-2xl bg-bisa-50 dark:bg-bisa-950/30 border border-bisa-200 dark:border-bisa-800/30">
                    <div class="text-xs text-bisa-800 dark:text-bisa-300 font-bold mb-0.5">Akurasi</div>
                    <div class="text-2xl font-black text-bisa">
                        {{ $attempt->total_questions > 0 ? number_format(($attempt->correct_answers / $attempt->total_questions) * 100, 0) : 0 }}%
                    </div>
                    <div class="text-[10px] text-gray-400">ketepatan</div>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="flex flex-wrap items-center justify-center gap-4 mt-8 pt-6 border-t border-gray-100 dark:border-white/10">
                <a href="{{ route('map.show') }}" class="px-5 py-2.5 bg-bisa hover:bg-bisa-dark text-white text-xs font-bold rounded-xl transition shadow-md shadow-bisa/20 flex items-center gap-2 transform hover:-translate-y-0.5">
                    <span>🗺️ Lanjut ke Peta Belajar</span>
                </a>
                <a href="{{ route('dashboard') }}" class="px-5 py-2.5 bg-gray-100 dark:bg-white/10 hover:bg-gray-200 dark:hover:bg-white/20 text-charcoal dark:text-white text-xs font-bold rounded-xl transition">
                    Ke Dashboard
                </a>
            </div>
        </div>

        {{-- Section: Detailed Explanations for all questions (Opened one by one) --}}
        <div class="bg-white dark:bg-[#161922] rounded-3xl p-6 sm:p-8 border border-gray-100 dark:border-white/10 shadow-sm transition-colors duration-200 animate-fade-in-up">
            <div class="flex items-center justify-between pb-4 border-b border-gray-100 dark:border-white/10 mb-6">
                <div>
                    <h2 class="text-xl font-extrabold text-charcoal-dark dark:text-white">Pembahasan Soal</h2>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Pelajari pembahasan detail setiap nomor untuk memperkuat pemahamanmu</p>
                </div>
                <button type="button" onclick="toggleAllExplanations()" class="text-xs font-bold text-bisa hover:underline">
                    <span id="toggleAllLabel">Buka Semua</span>
                </button>
            </div>

            <div class="space-y-6">
                @foreach($userAnswers as $idx => $ua)
                    @php
                        $q = $ua->question;
                        $num = $idx + 1;
                        $correctOpt = $q->options->firstWhere('is_correct', true);
                        $userOpt = $ua->selectedOption;
                        $isUserCorrect = (bool) $ua->is_correct;
                    @endphp

                    <div class="rounded-2xl border p-5 transition-all
                        {{ $isUserCorrect ? 'border-success/30 bg-success-light/10 dark:bg-emerald-950/20' : ($userOpt ? 'border-danger/30 bg-danger-light/10 dark:bg-rose-950/20' : 'border-gray-200 dark:border-white/10 bg-gray-50/50 dark:bg-white/5') }}
                    ">
                        {{-- Number & Result Badge --}}
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-xs font-extrabold text-charcoal-dark dark:text-white">
                                Soal No. {{ $num }}
                            </span>
                            @if($isUserCorrect)
                                <span class="px-2.5 py-1 bg-success text-white text-[10px] font-bold rounded-md">
                                    ✓ Benar
                                </span>
                            @elseif($userOpt)
                                <span class="px-2.5 py-1 bg-danger text-white text-[10px] font-bold rounded-md">
                                    ✕ Salah
                                </span>
                            @else
                                <span class="px-2.5 py-1 bg-gray-200 dark:bg-white/10 text-gray-600 dark:text-gray-400 text-[10px] font-bold rounded-md">
                                    ○ Tidak Dijawab
                                </span>
                            @endif
                        </div>

                        {{-- Question text --}}
                        <div class="text-sm font-medium text-charcoal-dark dark:text-gray-200 leading-relaxed mb-4">
                            {!! nl2br(e($q->question_text)) !!}
                        </div>

                        {{-- Choices comparison --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-xs mb-4">
                            <div class="p-2.5 rounded-xl border border-gray-200 dark:border-white/10 bg-white dark:bg-[#1E222D] flex items-center justify-between">
                                <span class="text-gray-500 dark:text-gray-400">Jawaban Anda:</span>
                                <span class="font-bold {{ $isUserCorrect ? 'text-success' : 'text-danger' }}">
                                    {{ $userOpt ? $userOpt->option_key . '. ' . $userOpt->option_text : '— (Kosong)' }}
                                </span>
                            </div>
                            <div class="p-2.5 rounded-xl border border-success/40 bg-success-light/40 dark:bg-emerald-950/30 flex items-center justify-between">
                                <span class="text-gray-600 dark:text-emerald-400">Kunci Jawaban:</span>
                                <span class="font-bold text-success-800 dark:text-emerald-300">
                                    {{ $correctOpt ? $correctOpt->option_key . '. ' . $correctOpt->option_text : '—' }}
                                </span>
                            </div>
                        </div>

                        {{-- Accordion Toggle for Explanation --}}
                        <button type="button"
                                onclick="toggleSingleExplanation({{ $num }})"
                                class="w-full flex items-center justify-between py-2 text-xs font-bold text-charcoal dark:text-gray-300 hover:text-bisa border-t border-gray-100 dark:border-white/10 transition">
                            <span class="flex items-center gap-1.5">
                                <span>💡</span>
                                <span id="btn-label-{{ $num }}">Lihat Pembahasan</span>
                            </span>
                            <svg id="arrow-{{ $num }}" class="w-4 h-4 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </button>

                        <div id="expl-box-{{ $num }}" class="explanation-box hidden pt-3 border-t border-gray-100 dark:border-white/10 text-xs text-charcoal dark:text-gray-300 leading-relaxed">
                            <div class="p-4 rounded-xl bg-gray-50 dark:bg-[#12151E] border border-gray-200/60 dark:border-white/10">
                                <div class="font-bold text-charcoal-dark dark:text-white uppercase tracking-wider text-[10px] mb-1">
                                    Analisis & Konsep:
                                </div>
                                {!! nl2br(e($q->explanation ?? 'Tidak ada pembahasan khusus untuk soal ini.')) !!}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    </div>
</div>

@push('scripts')
<script>
    let allOpen = false;

    function toggleSingleExplanation(num) {
        const box = document.getElementById('expl-box-' + num);
        const arrow = document.getElementById('arrow-' + num);
        const label = document.getElementById('btn-label-' + num);

        if (box.classList.contains('hidden')) {
            box.classList.remove('hidden');
            arrow.classList.add('rotate-180');
            label.textContent = 'Tutup Pembahasan';
        } else {
            box.classList.add('hidden');
            arrow.classList.remove('rotate-180');
            label.textContent = 'Lihat Pembahasan';
        }
    }

    function toggleAllExplanations() {
        allOpen = !allOpen;
        const boxes = document.querySelectorAll('.explanation-box');
        const label = document.getElementById('toggleAllLabel');

        boxes.forEach((box, i) => {
            const num = i + 1;
            const arrow = document.getElementById('arrow-' + num);
            const btnLabel = document.getElementById('btn-label-' + num);

            if (allOpen) {
                box.classList.remove('hidden');
                if (arrow) arrow.classList.add('rotate-180');
                if (btnLabel) btnLabel.textContent = 'Tutup Pembahasan';
            } else {
                box.classList.add('hidden');
                if (arrow) arrow.classList.remove('rotate-180');
                if (btnLabel) btnLabel.textContent = 'Lihat Pembahasan';
            }
        });

        label.textContent = allOpen ? 'Tutup Semua' : 'Buka Semua';
    }
</script>
@endpush
@endsection
