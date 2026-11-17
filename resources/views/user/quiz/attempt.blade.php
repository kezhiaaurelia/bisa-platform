@extends('layouts.app')

@section('title', 'Kuis ' . $quiz->title . ' — Soal ' . $qIndex . ' / ' . $totalQuestions)

@section('content')
<div class="bg-gray-50 dark:bg-[#0E1017] min-h-screen py-8 transition-colors duration-200">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Top Sticky Header with Countdown Timer --}}
        <div class="bg-white dark:bg-[#161922] rounded-2xl p-4 sm:p-5 border border-gray-100 dark:border-white/10 shadow-sm mb-6 flex items-center justify-between gap-4 sticky top-16 z-30 transition-colors duration-200 animate-fade-in-down">
            <div>
                <span class="text-xs text-purple-700 dark:text-purple-300 font-bold uppercase tracking-wider block">
                    ⏱️ {{ $quiz->title }}
                </span>
                <span class="text-xs text-gray-400">
                    Soal {{ $qIndex }} dari {{ $totalQuestions }}
                </span>
            </div>

            {{-- Countdown Display --}}
            <div class="flex items-center gap-3">
                <div class="flex items-center gap-2 px-4 py-2 bg-purple-50 dark:bg-purple-950/40 border border-purple-200 dark:border-purple-800/40 rounded-xl">
                    <svg class="w-4 h-4 text-purple-700 dark:text-purple-300 animate-spin" style="animation-duration: 3s;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span id="countdownTimer" class="font-mono text-base font-black text-purple-900 dark:text-purple-200 tracking-wider">
                        --:--
                    </span>
                </div>

                {{-- Finish button --}}
                <form id="finishQuizForm" action="{{ route('quiz.finish', $attempt->id) }}" method="POST">
                    @csrf
                    <button type="submit" onclick="return confirm('Apakah Anda yakin ingin mengakhiri kuis dan mengumpulkan semua jawaban?');"
                            class="px-4 py-2 bg-charcoal dark:bg-white/10 hover:bg-black dark:hover:bg-white/20 text-white text-xs font-bold rounded-xl transition shadow-sm">
                        Kumpulkan Kuis
                    </button>
                </form>
            </div>
        </div>

        {{-- Main Quiz Body --}}
        <div class="grid lg:grid-cols-4 gap-6 animate-fade-in-up">

            {{-- Question Card (Cols 1-3) --}}
            <div class="lg:col-span-3 space-y-6">
                <div class="bg-white dark:bg-[#161922] rounded-3xl p-6 sm:p-8 border border-gray-100 dark:border-white/10 shadow-sm transition-colors duration-200">

                    {{-- Question Meta --}}
                    <div class="flex items-center justify-between pb-4 border-b border-gray-100 dark:border-white/10 mb-6">
                        <div class="flex items-center gap-2.5">
                            <span class="text-sm font-extrabold text-charcoal-dark dark:text-white">
                                Pertanyaan No. {{ $qIndex }}
                            </span>
                            @if($currentQuestion->isMultiple())
                                <span class="px-2 py-0.5 bg-purple-100 dark:bg-purple-900/40 text-purple-700 dark:text-purple-300 rounded text-[10px] font-bold uppercase tracking-wider">
                                    Pilihan Ganda Kompleks
                                </span>
                            @endif
                        </div>
                        <span class="text-xs text-gray-400 font-medium">
                            Bobot: 1 Poin
                        </span>
                    </div>

                    {{-- Question Text --}}
                    <div class="text-base text-charcoal-dark dark:text-gray-100 leading-relaxed font-medium mb-6">
                        {!! nl2br(e($currentQuestion->question_text)) !!}
                    </div>

                    {{-- Question Stimulus Image (if any) --}}
                    @if($currentQuestion->image)
                        <div class="mb-6 rounded-2xl overflow-hidden border border-gray-200 dark:border-white/10 bg-gray-50 dark:bg-white/5 p-2 inline-block max-w-full">
                            <a href="{{ asset('storage/' . $currentQuestion->image) }}" target="_blank" title="Klik untuk memperbesar gambar stimulus" class="block relative group cursor-zoom-in">
                                <img src="{{ asset('storage/' . $currentQuestion->image) }}" alt="Stimulus Soal {{ $qIndex }}" class="max-h-80 w-auto rounded-xl object-contain">
                                <span class="absolute bottom-2 right-2 px-2.5 py-1 bg-black/75 text-white text-[11px] font-semibold rounded-lg opacity-0 group-hover:opacity-100 transition flex items-center gap-1.5 shadow">
                                    <i class="bi bi-arrows-fullscreen"></i> Perbesar Gambar
                                </span>
                            </a>
                        </div>
                    @endif

                    {{-- Options List (NO correctness revealed!) --}}
                    <div class="space-y-3">
                        @foreach($currentQuestion->options as $opt)
                            @php
                                $isSelected = $currentAnswer && $currentAnswer->selected_option_id === $opt->id;
                            @endphp

                            <button type="button"
                                    onclick="saveAnswer({{ $opt->id }})"
                                    id="quiz-opt-{{ $opt->id }}"
                                    class="quiz-option-button w-full text-left p-4 rounded-2xl border-2 transition-all flex items-start gap-4 text-sm font-medium
                                        {{ $isSelected ? 'border-purple-600 bg-purple-50 dark:bg-purple-950/30 text-purple-900 dark:text-purple-200 shadow-sm' : 'border-gray-100 dark:border-white/10 bg-white dark:bg-[#1E222D] hover:border-gray-300 dark:hover:border-white/20 text-charcoal dark:text-gray-200' }}
                                    ">
                                <span id="quiz-badge-{{ $opt->id }}"
                                      class="w-7 h-7 rounded-xl flex items-center justify-center font-bold text-xs shrink-0 transition
                                        {{ $isSelected ? 'bg-purple-600 text-white' : 'bg-gray-100 dark:bg-white/10 text-charcoal dark:text-gray-200' }}
                                      ">
                                    {{ $opt->option_key }}
                                </span>
                                <span class="flex-1 pt-0.5 leading-relaxed">{{ $opt->option_text }}</span>
                            </button>
                        @endforeach
                    </div>

                    {{-- Auto-save status feedback --}}
                    <div id="saveStatus" class="mt-4 text-right text-[11px] text-gray-400 italic">
                        {{ $currentAnswer ? '✓ Jawaban Anda tersimpan' : 'Pilih salah satu jawaban' }}
                    </div>

                    {{-- Navigation buttons --}}
                    <div class="flex items-center justify-between pt-8 mt-8 border-t border-gray-100 dark:border-white/10">
                        @if($qIndex > 1)
                            <a href="{{ route('quiz.attempt', ['attemptId' => $attempt->id, 'qIndex' => $qIndex - 1]) }}"
                               class="px-5 py-2.5 rounded-xl border border-gray-200 dark:border-white/10 text-xs font-bold text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-white/5 transition flex items-center gap-1.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                                <span>Sebelumnya</span>
                            </a>
                        @else
                            <div></div>
                        @endif

                        @if($qIndex < $totalQuestions)
                            <a href="{{ route('quiz.attempt', ['attemptId' => $attempt->id, 'qIndex' => $qIndex + 1]) }}"
                               class="px-5 py-2.5 rounded-xl bg-purple-600 hover:bg-purple-700 text-white text-xs font-bold transition shadow-sm flex items-center gap-1.5">
                                <span>Selanjutnya</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </a>
                        @else
                            <button type="button"
                                    onclick="document.getElementById('finishQuizForm').submit()"
                                    class="px-5 py-2.5 rounded-xl bg-charcoal dark:bg-purple-600 hover:bg-black dark:hover:bg-purple-700 text-white text-xs font-bold transition shadow-md flex items-center gap-1.5">
                                <span>Kumpulkan Jawaban</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            </button>
                        @endif
                    </div>

                </div>
            </div>

            {{-- Question Jump Sidebar (Col 4) --}}
            <div class="lg:col-span-1">
                <div class="bg-white dark:bg-[#161922] rounded-3xl p-6 border border-gray-100 dark:border-white/10 shadow-sm sticky top-36 transition-colors duration-200">
                    <h4 class="text-xs font-extrabold text-charcoal-dark dark:text-white uppercase tracking-wider mb-4">Navigasi Soal</h4>

                    <div class="grid grid-cols-5 gap-2">
                        @foreach($questions as $i => $q)
                            @php
                                $num = $i + 1;
                                $isCurrent = $num === $qIndex;
                                $isAnswered = in_array($q->id, $answeredQuestionIds);
                            @endphp

                            <a href="{{ route('quiz.attempt', ['attemptId' => $attempt->id, 'qIndex' => $num]) }}"
                               id="nav-badge-{{ $q->id }}"
                               class="w-full aspect-square rounded-xl font-bold text-xs flex items-center justify-center transition border
                                    {{ $isCurrent ? 'ring-2 ring-purple-600 border-purple-600 font-black' : '' }}
                                    {{ $isAnswered ? 'bg-purple-600 text-white border-purple-600' : 'bg-gray-50 dark:bg-white/5 text-gray-600 dark:text-gray-300 border-gray-100 dark:border-white/5 hover:bg-gray-100 dark:hover:bg-white/10' }}
                                ">
                                {{ $num }}
                            </a>
                        @endforeach
                    </div>

                    <div class="mt-6 pt-4 border-t border-gray-100 dark:border-white/10 space-y-2 text-[11px] text-gray-500 dark:text-gray-400">
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-3 rounded-full bg-purple-600"></span>
                            <span>Sudah Dijawab</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-3 rounded-full bg-gray-200 dark:bg-white/20"></span>
                            <span>Belum Dijawab</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@push('scripts')
<script>
    // Countdown Timer System
    let remainingSeconds = {{ $remainingSeconds }};
    const timerDisplay = document.getElementById('countdownTimer');
    const finishForm = document.getElementById('finishQuizForm');

    function formatTime(seconds) {
        const mins = Math.floor(seconds / 60);
        const secs = seconds % 60;
        return String(mins).padStart(2, '0') + ':' + String(secs).padStart(2, '0');
    }

    function updateTimer() {
        if (remainingSeconds <= 0) {
            timerDisplay.textContent = '00:00';
            timerDisplay.classList.add('text-danger');
            // Auto submit immediately!
            alert('Waktu ujian telah habis! Sistem akan mengumpulkan lembar jawaban Anda.');
            finishForm.submit();
            return;
        }

        timerDisplay.textContent = formatTime(remainingSeconds);

        if (remainingSeconds <= 300) { // under 5 minutes
            timerDisplay.classList.add('text-danger');
            timerDisplay.parentElement.classList.add('bg-danger-light', 'border-danger/40');
        }

        remainingSeconds--;
    }

    updateTimer();
    const timerInterval = setInterval(updateTimer, 1000);

    // Save Answer without revealing correctness
    function saveAnswer(optionId) {
        const statusEl = document.getElementById('saveStatus');
        statusEl.textContent = 'Menyimpan jawaban...';

        fetch('{{ route('quiz.answer', ['attemptId' => $attempt->id, 'questionId' => $currentQuestion->id]) }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ option_id: optionId })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Deselect all
                document.querySelectorAll('.quiz-option-button').forEach(btn => {
                    btn.classList.remove('border-purple-600', 'bg-purple-50', 'text-purple-900', 'shadow-sm');
                    btn.classList.add('border-gray-100');
                });
                document.querySelectorAll('[id^="quiz-badge-"]').forEach(badge => {
                    badge.className = 'w-7 h-7 rounded-xl flex items-center justify-center font-bold text-xs shrink-0 transition bg-gray-100 text-charcoal';
                });

                // Select chosen
                const chosen = document.getElementById('quiz-opt-' + optionId);
                const chosenBadge = document.getElementById('quiz-badge-' + optionId);
                chosen.classList.remove('border-gray-100');
                chosen.classList.add('border-purple-600', 'bg-purple-50', 'text-purple-900', 'shadow-sm');
                chosenBadge.className = 'w-7 h-7 rounded-xl flex items-center justify-center font-bold text-xs shrink-0 transition bg-purple-600 text-white';

                // Update sidebar button
                const navBadge = document.getElementById('nav-badge-{{ $currentQuestion->id }}');
                if (navBadge) {
                    navBadge.classList.remove('bg-gray-50', 'text-gray-600');
                    navBadge.classList.add('bg-purple-600', 'text-white', 'border-purple-600');
                }

                statusEl.textContent = '✓ Jawaban Anda berhasil tersimpan';
            }
        })
        .catch(err => {
            statusEl.textContent = '⚠️ Gagal menyimpan, coba lagi';
        });
    }
</script>
@endpush
@endsection
