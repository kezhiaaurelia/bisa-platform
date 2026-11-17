@extends('layouts.app')

@section('title', 'Latihan Soal ' . $qIndex . ' dari ' . $totalQuestions . ' — BISA')

@section('content')
<div class="bg-gray-50 dark:bg-[#0E1017] min-h-screen py-8 transition-colors duration-200">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Top Header / Info bar --}}
        <div class="bg-white dark:bg-[#161922] rounded-2xl p-4 sm:p-5 border border-gray-100 dark:border-white/10 shadow-sm mb-6 flex flex-wrap items-center justify-between gap-4 animate-fade-in-down">
            <div class="flex items-center gap-3">
                <span class="px-3 py-1 bg-amber-100 dark:bg-amber-900/30 text-amber-800 dark:text-amber-300 rounded-lg text-xs font-bold uppercase tracking-wider">
                    ✍️ Mode Latihan
                </span>
                <span class="text-xs text-gray-500 dark:text-gray-400 font-medium">
                    {{ $attempt->subject ? $attempt->subject->name : 'Mata Pelajaran' }}
                </span>
            </div>

            <div class="flex items-center gap-3">
                <form action="{{ route('practice.finish', $attempt->id) }}" method="POST" onsubmit="return confirm('Selesaikan sesi latihan sekarang?');">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-charcoal dark:bg-white/10 hover:bg-black dark:hover:bg-white/20 text-white text-xs font-bold rounded-xl transition shadow-sm">
                        Selesaikan Latihan
                    </button>
                </form>
            </div>
        </div>

        {{-- Main Question Grid --}}
        <div class="grid lg:grid-cols-4 gap-6 animate-fade-in-up">

            {{-- Question Card (Cols 1-3) --}}
            <div class="lg:col-span-3 space-y-6">
                <div class="bg-white dark:bg-[#161922] rounded-3xl p-6 sm:p-8 border border-gray-100 dark:border-white/10 shadow-sm transition-colors duration-200">
                    {{-- Question Meta --}}
                    <div class="flex items-center justify-between pb-4 border-b border-gray-100 dark:border-white/10 mb-6">
                        <div class="flex items-center gap-2.5">
                            <span class="text-sm font-extrabold text-charcoal-dark dark:text-white">
                                Soal No. {{ $qIndex }} <span class="text-gray-400 font-normal">dari {{ $totalQuestions }}</span>
                            </span>
                            @if($currentQuestion->isMultiple())
                                <span class="px-2 py-0.5 bg-purple-100 dark:bg-purple-900/40 text-purple-700 dark:text-purple-300 rounded text-[10px] font-bold uppercase tracking-wider">
                                    Pilihan Ganda Kompleks
                                </span>
                            @endif
                        </div>
                        <span class="text-xs font-semibold px-2.5 py-1 rounded-md
                            {{ $currentQuestion->difficulty === 'easy' ? 'bg-emerald-50 dark:bg-emerald-950/30 text-emerald-700 dark:text-emerald-300' : '' }}
                            {{ $currentQuestion->difficulty === 'medium' ? 'bg-amber-50 dark:bg-amber-950/30 text-amber-700 dark:text-amber-300' : '' }}
                            {{ $currentQuestion->difficulty === 'hard' ? 'bg-rose-50 dark:bg-rose-950/30 text-rose-700 dark:text-rose-300' : '' }}
                        ">
                            Tingkat: {{ ucfirst($currentQuestion->difficulty) }}
                        </span>
                    </div>

                    {{-- Question Body --}}
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

                    {{-- Options List --}}
                    <div class="space-y-3" id="optionsContainer">
                        @foreach($currentQuestion->options as $opt)
                            @php
                                $isSelected = $existingAnswer && $existingAnswer->selected_option_id === $opt->id;
                                $isAnswered = (bool) $existingAnswer;
                                $isCorrectOpt = (bool) $opt->is_correct;
                            @endphp

                            <button type="button"
                                    onclick="selectOption({{ $opt->id }})"
                                    id="option-btn-{{ $opt->id }}"
                                    class="option-button w-full text-left p-4 rounded-2xl border-2 transition-all flex items-start gap-4 text-sm font-medium
                                        {{ $isSelected && $isCorrectOpt ? 'border-success bg-success-light dark:bg-emerald-950/30 text-success-800 dark:text-emerald-200' : '' }}
                                        {{ $isSelected && !$isCorrectOpt ? 'border-danger bg-danger-light dark:bg-rose-950/30 text-danger-800 dark:text-rose-200' : '' }}
                                        {{ !$isSelected && $isAnswered && $isCorrectOpt ? 'border-success bg-success-light/40 dark:bg-emerald-950/20 text-success-800 dark:text-emerald-300' : '' }}
                                        {{ !$isAnswered ? 'border-gray-100 dark:border-white/10 bg-white dark:bg-[#1E222D] text-charcoal-dark dark:text-gray-200 hover:border-bisa/60 dark:hover:border-bisa/60 hover:bg-bisa-50/20 dark:hover:bg-white/5' : 'border-gray-100 dark:border-white/10 bg-white dark:bg-[#1E222D] text-charcoal-dark dark:text-gray-200' }}
                                    ">
                                <span id="badge-{{ $opt->id }}"
                                      class="w-7 h-7 rounded-xl flex items-center justify-center font-bold text-xs shrink-0
                                        {{ $isSelected && $isCorrectOpt ? 'bg-success text-white' : '' }}
                                        {{ $isSelected && !$isCorrectOpt ? 'bg-danger text-white' : '' }}
                                        {{ !$isSelected ? 'bg-gray-100 dark:bg-white/10 text-charcoal dark:text-gray-200' : '' }}
                                      ">
                                    {{ $opt->option_key }}
                                </span>
                                <span class="flex-1 pt-0.5 leading-relaxed">{{ $opt->option_text }}</span>
                                <span id="status-icon-{{ $opt->id }}" class="shrink-0 text-base">
                                    @if($isSelected && $isCorrectOpt)
                                        ✅
                                    @elseif($isSelected && !$isCorrectOpt)
                                        ❌
                                    @endif
                                </span>
                            </button>
                        @endforeach
                    </div>

                    {{-- Feedback Banner --}}
                    <div id="feedbackBanner" class="mt-6 p-4 rounded-2xl border transition-all {{ $existingAnswer ? '' : 'hidden' }}
                        {{ $existingAnswer && $existingAnswer->is_correct ? 'bg-success-light dark:bg-emerald-950/40 border-success/30 text-success-900 dark:text-emerald-300' : 'bg-danger-light dark:bg-rose-950/40 border-danger/30 text-danger-900 dark:text-rose-300' }}
                    ">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2 font-bold text-sm">
                                <span id="feedbackIcon">{{ $existingAnswer && $existingAnswer->is_correct ? '✅' : '❌' }}</span>
                                <span id="feedbackText">{{ $existingAnswer && $existingAnswer->is_correct ? 'Jawaban Anda Benar!' : 'Jawaban Anda Kurang Tepat' }}</span>
                            </div>

                            <button type="button" onclick="toggleExplanation()" class="text-xs font-bold text-charcoal dark:text-gray-200 underline hover:text-bisa transition">
                                <span id="explanationToggleLabel">Buka Pembahasan</span>
                            </button>
                        </div>
                    </div>

                    {{-- Explanation Box (Immediately Viewable) --}}
                    <div id="explanationBox" class="mt-4 p-5 rounded-2xl bg-gray-50 dark:bg-[#12151E] border border-gray-200/80 dark:border-white/10 text-xs text-charcoal dark:text-gray-300 leading-relaxed {{ $existingAnswer ? '' : 'hidden' }}">
                        <div class="flex items-center justify-between font-bold text-charcoal-dark dark:text-white uppercase tracking-wider mb-2 text-[11px]">
                            <span class="flex items-center gap-1.5"><span>💡</span> Pembahasan Soal</span>
                            <span class="text-bisa font-bold">Kunci: {{ $currentQuestion->options->firstWhere('is_correct', true)?->option_key ?? '-' }}</span>
                        </div>
                        <div id="explanationContent">
                            {!! nl2br(e($currentQuestion->explanation ?? 'Tidak ada pembahasan khusus untuk soal ini.')) !!}
                        </div>

                        {{-- Tanya KakAI Tutor AI CTA --}}
                        <div class="mt-4 pt-3 border-t border-gray-200/60 dark:border-white/10 flex flex-wrap items-center justify-between gap-2">
                            <span class="text-[11px] text-gray-500 dark:text-gray-400">Belum paham dengan langkah penyelesaian di atas?</span>
                            <button type="button"
                                    onclick="askKakaiForQuestion({{ $currentQuestion->id }})"
                                    class="px-3 py-1.5 rounded-xl bg-bisa hover:bg-bisa-dark text-white font-extrabold text-[11px] flex items-center gap-1.5 shadow-sm transition">
                                <i class="bi bi-robot"></i>
                                <span>Tanya KakAI Soal Ini</span>
                            </button>
                        </div>
                    </div>

                    {{-- KakAI Modal for this Question --}}
                    <div id="kakaiModal" class="hidden fixed inset-0 z-50 overflow-y-auto bg-black/60 backdrop-blur-sm p-4 flex items-center justify-center">
                        <div class="bg-white dark:bg-[#161922] max-w-xl w-full rounded-3xl p-6 sm:p-7 border border-gray-100 dark:border-white/10 shadow-2xl relative animate-scale-in">
                            <div class="flex items-center justify-between pb-3 border-b border-gray-100 dark:border-white/10 mb-4">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-8 h-8 rounded-xl bg-bisa text-white flex items-center justify-center font-bold text-xs">
                                        <i class="bi bi-robot"></i>
                                    </div>
                                    <span class="font-extrabold text-sm text-charcoal-dark dark:text-white">Penjelasan Eksklusif KakAI</span>
                                </div>
                                <button type="button" onclick="closeKakaiModal()" class="w-8 h-8 rounded-lg bg-gray-100 dark:bg-white/10 hover:bg-gray-200 dark:hover:bg-white/20 text-gray-500 flex items-center justify-center transition">
                                    ✕
                                </button>
                            </div>

                            <div id="kakaiLoading" class="py-8 text-center text-xs text-gray-400">
                                <span class="w-3 h-3 rounded-full bg-bisa animate-ping inline-block mb-2"></span>
                                <div>KakAI sedang membedah logika konsep dan trik cepat soal ini...</div>
                            </div>

                            <div id="kakaiBody" class="space-y-3.5 text-xs text-gray-700 dark:text-gray-300 hidden">
                                <div id="kakaiSummary" class="font-semibold text-charcoal-dark dark:text-white leading-relaxed"></div>
                                <div class="p-3 bg-blue-50 dark:bg-blue-950/30 text-blue-900 dark:text-blue-200 rounded-xl">
                                    <span class="font-bold block mb-1">🎯 Konsep yang Diuji:</span>
                                    <div id="kakaiConcept"></div>
                                </div>
                                <div class="p-3 bg-amber-50 dark:bg-amber-950/30 text-amber-900 dark:text-amber-200 rounded-xl">
                                    <span class="font-bold block mb-1">⚡ Trik Cepat Menjawab:</span>
                                    <div id="kakaiTrick"></div>
                                </div>
                                <div class="p-3 bg-emerald-50 dark:bg-emerald-950/30 text-emerald-900 dark:text-emerald-200 rounded-xl">
                                    <span class="font-bold block mb-1">💡 Contoh & Analogi:</span>
                                    <div id="kakaiAnalogy"></div>
                                </div>
                            </div>

                            <div class="pt-4 mt-4 border-t border-gray-100 dark:border-white/10 flex justify-end">
                                <button type="button" onclick="closeKakaiModal()" class="px-4 py-2 bg-charcoal-dark text-white rounded-xl text-xs font-bold hover:bg-black transition">
                                    Sudah Paham, Lanjut Soal Berikutnya ✓
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- Nav Buttons (Prev & Next) --}}
                    <div class="flex items-center justify-between pt-8 mt-8 border-t border-gray-100 dark:border-white/10">
                        @if($qIndex > 1)
                            <a href="{{ route('practice.show', ['attemptId' => $attempt->id, 'qIndex' => $qIndex - 1]) }}"
                               class="px-5 py-2.5 rounded-xl border border-gray-200 dark:border-white/10 text-xs font-bold text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-white/5 transition flex items-center gap-1.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                                <span>Sebelumnya</span>
                            </a>
                        @else
                            <div></div>
                        @endif

                        @if($qIndex < $totalQuestions)
                            <a href="{{ route('practice.show', ['attemptId' => $attempt->id, 'qIndex' => $qIndex + 1]) }}"
                               class="px-5 py-2.5 rounded-xl bg-bisa hover:bg-bisa-dark text-white text-xs font-bold transition shadow-sm flex items-center gap-1.5">
                                <span>Selanjutnya</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </a>
                        @else
                            <form action="{{ route('practice.finish', $attempt->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="px-5 py-2.5 rounded-xl bg-success hover:bg-emerald-700 text-white text-xs font-bold transition shadow-md shadow-success/20 flex items-center gap-1.5">
                                    <span>Selesaikan Latihan</span>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Question Navigator Sidebar (Col 4) --}}
            <div class="lg:col-span-1">
                <div class="bg-white dark:bg-[#161922] rounded-3xl p-6 border border-gray-100 dark:border-white/10 shadow-sm sticky top-24 transition-colors duration-200">
                    <h4 class="text-xs font-extrabold text-charcoal-dark dark:text-white uppercase tracking-wider mb-4">Nomor Soal</h4>

                    <div class="grid grid-cols-5 gap-2">
                        @foreach($questions as $i => $q)
                            @php
                                $num = $i + 1;
                                $isCurrent = $num === $qIndex;
                                $hasAnswered = array_key_exists($q->id, $answeredQuestionIds);
                                $isCorrect = $hasAnswered ? $answeredQuestionIds[$q->id] : null;
                            @endphp

                            <a href="{{ route('practice.show', ['attemptId' => $attempt->id, 'qIndex' => $num]) }}"
                               class="w-full aspect-square rounded-xl font-bold text-xs flex items-center justify-center transition border
                                    {{ $isCurrent ? 'ring-2 ring-bisa border-bisa font-black' : '' }}
                                    {{ $hasAnswered && $isCorrect ? 'bg-success-light dark:bg-emerald-950/40 text-success dark:text-emerald-300 border-success/30' : '' }}
                                    {{ $hasAnswered && !$isCorrect ? 'bg-danger-light dark:bg-rose-950/40 text-danger dark:text-rose-300 border-danger/30' : '' }}
                                    {{ !$hasAnswered ? 'bg-gray-50 dark:bg-white/5 text-gray-600 dark:text-gray-300 border-gray-100 dark:border-white/5 hover:bg-gray-100 dark:hover:bg-white/10' : '' }}
                               ">
                                {{ $num }}
                            </a>
                        @endforeach
                    </div>

                    <div class="mt-6 pt-4 border-t border-gray-100 dark:border-white/10 space-y-2 text-[11px] text-gray-500 dark:text-gray-400">
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-3 rounded-full bg-success"></span>
                            <span>Jawaban Benar</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-3 rounded-full bg-danger"></span>
                            <span>Jawaban Salah</span>
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
    let isExplanationOpen = false;

    function selectOption(optionId) {
        fetch('{{ route('practice.answer', ['attemptId' => $attempt->id, 'questionId' => $currentQuestion->id]) }}', {
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
                // Reset all options styling
                document.querySelectorAll('.option-button').forEach(btn => {
                    btn.classList.remove('border-success', 'bg-success-light', 'border-danger', 'bg-danger-light', 'text-success-800', 'text-danger-800');
                    btn.classList.add('border-gray-100');
                });

                // Highlight chosen button
                const chosenBtn = document.getElementById('option-btn-' + optionId);
                const chosenBadge = document.getElementById('badge-' + optionId);
                const chosenStatus = document.getElementById('status-icon-' + optionId);

                if (data.is_correct) {
                    chosenBtn.classList.add('border-success', 'bg-success-light', 'text-success-800');
                    chosenBadge.className = 'w-7 h-7 rounded-xl flex items-center justify-center font-bold text-xs shrink-0 bg-success text-white';
                    chosenStatus.textContent = '✅';
                } else {
                    chosenBtn.classList.add('border-danger', 'bg-danger-light', 'text-danger-800');
                    chosenBadge.className = 'w-7 h-7 rounded-xl flex items-center justify-center font-bold text-xs shrink-0 bg-danger text-white';
                    chosenStatus.textContent = '❌';

                    // Also show correct answer
                    if (data.correct_option_id) {
                        const correctBtn = document.getElementById('option-btn-' + data.correct_option_id);
                        if (correctBtn) {
                            correctBtn.classList.add('border-success', 'bg-success-light/40');
                        }
                    }
                }

                // Show feedback banner
                const banner = document.getElementById('feedbackBanner');
                banner.classList.remove('hidden', 'bg-success-light', 'border-success/30', 'text-success-900', 'bg-danger-light', 'border-danger/30', 'text-danger-900');

                if (data.is_correct) {
                    banner.classList.add('bg-success-light', 'border-success/30', 'text-success-900');
                    document.getElementById('feedbackIcon').textContent = '✅';
                    document.getElementById('feedbackText').textContent = 'Jawaban Anda Benar!';
                } else {
                    banner.classList.add('bg-danger-light', 'border-danger/30', 'text-danger-900');
                    document.getElementById('feedbackIcon').textContent = '❌';
                    document.getElementById('feedbackText').textContent = 'Jawaban Anda Kurang Tepat (Kunci: ' + data.correct_option_key + ')';
                }

                // Update explanation content
                if (data.explanation) {
                    document.getElementById('explanationContent').textContent = data.explanation;
                }
            }
        });
    }

    function toggleExplanation() {
        const box = document.getElementById('explanationBox');
        const label = document.getElementById('explanationToggleLabel');
        isExplanationOpen = !isExplanationOpen;

        if (isExplanationOpen) {
            box.classList.remove('hidden');
            label.textContent = 'Tutup Pembahasan';
        } else {
            box.classList.add('hidden');
            label.textContent = 'Buka Pembahasan';
        }
    }

    async function askKakaiForQuestion(questionId) {
        const modal = document.getElementById('kakaiModal');
        const loading = document.getElementById('kakaiLoading');
        const body = document.getElementById('kakaiBody');

        modal.classList.remove('hidden');
        loading.classList.remove('hidden');
        body.classList.add('hidden');

        try {
            const res = await fetch("{{ route('kakai.ask') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ question_id: questionId })
            });
            const data = await res.json();
            if (data.success && data.reply) {
                document.getElementById('kakaiSummary').textContent = data.reply.summary;
                document.getElementById('kakaiConcept').textContent = data.reply.concept;
                document.getElementById('kakaiTrick').textContent = data.reply.speed_trick;
                document.getElementById('kakaiAnalogy').textContent = data.reply.analogy;

                loading.classList.add('hidden');
                body.classList.remove('hidden');
            }
        } catch (e) {
            loading.textContent = 'Terjadi kendala saat menghubungi KakAI. Silakan coba kembali.';
        }
    }

    function closeKakaiModal() {
        document.getElementById('kakaiModal').classList.add('hidden');
    }
</script>
@endpush
@endsection
