@extends('layouts.app')

@section('title', 'Peta Belajar — ' . ($currentSubject ? $currentSubject->name : 'BISA'))

@section('content')
<div class="bg-gradient-to-b from-bisa-50/60 via-white to-gray-50 dark:from-[#0E1017] dark:via-[#121520] dark:to-[#0B0D13] min-h-screen pb-20 transition-colors duration-200">

    {{-- Top Category & Subject Selector --}}
    <div class="bg-white dark:bg-[#161922] border-b border-gray-100 dark:border-white/10 shadow-sm sticky top-16 z-40 transition-colors duration-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3">
            {{-- Category Tabs --}}
            <div class="flex items-center justify-between gap-4 border-b border-gray-100 dark:border-white/10 pb-3 mb-3">
                <div class="flex items-center gap-2 overflow-x-auto no-scrollbar">
                    @foreach($categories as $cat)
                        <a href="{{ route('map.show', ['categorySlug' => $cat->slug]) }}"
                           class="px-4 py-2 rounded-xl text-sm font-bold transition flex items-center gap-2 shrink-0 {{ $currentCategory->id === $cat->id ? 'bg-bisa text-white shadow-md shadow-bisa/20 ring-2 ring-bisa/30' : 'bg-gray-100 dark:bg-white/5 text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-white/10' }}">
                            <span>{{ $cat->name }}</span>
                        </a>
                    @endforeach
                </div>

                {{-- User XP / Progress Widget --}}
                <div class="hidden sm:flex items-center gap-3 bg-gold-light dark:bg-amber-950/30 px-3.5 py-1.5 rounded-xl border border-gold/30 dark:border-amber-700/30">
                    <span class="text-xl">⭐</span>
                    <div>
                        <div class="text-xs font-semibold text-charcoal dark:text-gray-200">Petualangan Belajar</div>
                        <div class="text-xs text-gold-dark dark:text-amber-400 font-bold">{{ $currentSubject ? $currentSubject->name : '' }}</div>
                    </div>
                </div>
            </div>

            {{-- Subject Pills (Horizontal Scrollable) --}}
            <div class="flex items-center gap-2 overflow-x-auto no-scrollbar py-1">
                @foreach($subjects as $subj)
                    <a href="{{ route('map.show', ['categorySlug' => $currentCategory->slug, 'subjectSlug' => $subj->slug]) }}"
                       class="px-3.5 py-1.5 rounded-lg text-xs font-semibold transition shrink-0 {{ $currentSubject && $currentSubject->id === $subj->id ? 'bg-charcoal dark:bg-bisa text-white ring-2 ring-charcoal/20 dark:ring-bisa/30 shadow-sm' : 'bg-gray-50 dark:bg-white/5 text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-white/10 border border-gray-200/80 dark:border-white/10' }}">
                        {{ $subj->name }}
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Map Banner / Header --}}
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 pt-8 animate-fade-in-down">
        <div class="bg-gradient-to-r from-charcoal via-charcoal-light to-charcoal dark:from-[#181C26] dark:via-[#1F2432] dark:to-[#181C26] rounded-3xl p-6 sm:p-8 text-white shadow-xl border border-white/5 relative overflow-hidden">
            <div class="relative z-10 max-w-xl">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-bisa/30 text-bisa-300 rounded-full text-xs font-bold uppercase tracking-wider mb-3">
                    🗺️ Learning Adventure Map
                </span>
                <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight">
                    {{ $currentSubject ? $currentSubject->name : 'Peta Perjalanan Belajar' }}
                </h1>
                <p class="text-gray-300 text-sm mt-2 leading-relaxed">
                    {{ $currentSubject ? $currentSubject->description : 'Selesaikan tantangan setiap level untuk membuka materi berikutnya hingga siap menghadapi simulasi ujian!' }}
                </p>

                <div class="flex flex-wrap items-center gap-4 mt-5 pt-4 border-t border-white/10 text-xs">
                    <div class="flex items-center gap-1.5">
                        <span class="w-3 h-3 rounded-full bg-success"></span>
                        <span class="text-gray-300">Selesai</span>
                    </div>
                    <div class="flex items-center gap-1.5">
                        <span class="w-3 h-3 rounded-full bg-bisa ring-2 ring-white"></span>
                        <span class="text-white font-semibold">Tantangan Aktif</span>
                    </div>
                    <div class="flex items-center gap-1.5">
                        <span class="w-3 h-3 rounded-full bg-info"></span>
                        <span class="text-gray-300">Tersedia</span>
                    </div>
                    <div class="flex items-center gap-1.5">
                        <span class="w-3 h-3 rounded-full bg-gray-500"></span>
                        <span class="text-gray-400">Terkunci</span>
                    </div>
                </div>
            </div>

            {{-- Background decorative illustration --}}
            <div class="absolute -right-8 -bottom-8 opacity-15 pointer-events-none hidden md:block">
                <img src="{{ asset('images/logo-icon.png') }}" alt="" class="w-64 h-64">
            </div>
        </div>
    </div>

    {{-- The Learning Map Journey Canvas --}}
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12 animate-fade-in-up">
        @if($levels->isEmpty())
            <div class="bg-white dark:bg-[#161922] rounded-3xl p-12 text-center border border-gray-100 dark:border-white/10 shadow-sm">
                <div class="text-5xl mb-4">🗺️</div>
                <h3 class="text-lg font-bold text-charcoal dark:text-white">Belum Ada Level Tersedia</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Admin sedang menyiapkan peta belajar untuk mata pelajaran ini.</p>
            </div>
        @else
            <div class="relative py-8">

                {{-- Winding Connector SVG Path for Desktop & Mobile --}}
                <div class="absolute left-1/2 top-10 bottom-10 w-2 -translate-x-1/2 bg-gradient-to-b from-bisa via-gold to-gray-300 dark:to-white/10 rounded-full z-0 hidden sm:block"></div>
                <div class="absolute left-8 top-10 bottom-10 w-1.5 bg-gradient-to-b from-bisa via-gold to-gray-300 dark:to-white/10 rounded-full z-0 sm:hidden"></div>

                <div class="space-y-16 relative z-10">

                    {{-- START CHECKPOINT --}}
                    <div class="flex items-center sm:justify-center pl-4 sm:pl-0">
                        <div class="bg-white dark:bg-[#161922] px-5 py-2.5 rounded-full border-2 border-bisa shadow-md flex items-center gap-2">
                            <span class="text-lg">🚩</span>
                            <span class="text-xs font-extrabold text-charcoal dark:text-white uppercase tracking-widest">Titik Mulai</span>
                        </div>
                    </div>

                    @foreach($levels as $index => $level)
                        @php
                            $state = $nodeStates[$level->id] ?? 'locked';
                            $isRight = $index % 2 === 1;
                        @endphp

                        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4 sm:gap-8 {{ $isRight ? 'sm:flex-row-reverse' : '' }}">

                            {{-- Left/Right Level Card --}}
                            <div class="w-full sm:w-1/2 pl-16 sm:pl-0 {{ $isRight ? 'sm:text-left' : 'sm:text-right' }}">
                                <div class="bg-white dark:bg-[#161922] rounded-2xl p-5 border transition-all duration-300 shadow-sm
                                    {{ $state === 'current' ? 'border-2 border-bisa shadow-lg shadow-bisa/15 ring-4 ring-bisa/10 dark:ring-bisa/20' : '' }}
                                    {{ $state === 'completed' ? 'border-success/30 bg-success-light/20 dark:bg-emerald-950/20' : '' }}
                                    {{ $state === 'available' ? 'border-info/30 hover:border-bisa dark:border-white/10 dark:hover:border-bisa' : '' }}
                                    {{ $state === 'locked' ? 'border-gray-200/70 dark:border-white/5 bg-gray-50/70 dark:bg-white/5 opacity-70' : '' }}
                                ">
                                    <div class="flex items-center gap-2 {{ $isRight ? 'justify-start' : 'sm:justify-end' }} mb-2">
                                        <span class="px-2.5 py-0.5 rounded-md text-[11px] font-bold uppercase
                                            {{ $level->type === 'material' ? 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300' : '' }}
                                            {{ $level->type === 'practice' ? 'bg-amber-100 dark:bg-amber-900/30 text-amber-800 dark:text-amber-300' : '' }}
                                            {{ $level->type === 'quiz' ? 'bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300' : '' }}
                                            {{ $level->type === 'tryout' ? 'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-800 dark:text-emerald-300' : '' }}
                                        ">
                                            {{ ucfirst($level->type) }}
                                        </span>
                                        <span class="text-xs font-semibold text-gold-dark dark:text-amber-400 flex items-center gap-1">
                                            <span>+{{ $level->xp_reward }} XP</span>
                                        </span>
                                    </div>

                                    <h3 class="font-bold text-base text-charcoal-dark dark:text-white mb-1">
                                        Level {{ $level->level_number }}: {{ $level->title }}
                                    </h3>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 leading-relaxed mb-4">
                                        {{ $level->description }}
                                    </p>

                                    {{-- Action Buttons based on state --}}
                                    @if($state === 'locked')
                                        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-xl bg-gray-100 dark:bg-white/5 text-gray-400 dark:text-gray-500 text-xs font-semibold">
                                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/></svg>
                                            Selesaikan level sebelumnya
                                        </div>
                                    @elseif($level->type === 'material')
                                        @php $module = $level->modules->first(); @endphp
                                        <a href="{{ $module ? route('module.show', $module->id) : '#' }}"
                                           class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 transition shadow-sm">
                                            <span>Baca Modul</span>
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                                        </a>
                                    @elseif($level->type === 'practice')
                                        <a href="{{ route('practice.start', ['subjectId' => $currentSubject->id, 'levelId' => $level->id]) }}"
                                           class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-bold text-white bg-bisa hover:bg-bisa-dark transition shadow-md shadow-bisa/20">
                                            <span>Mulai Latihan</span>
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                                        </a>
                                    @elseif($level->type === 'quiz')
                                        @php $quiz = $level->quizzes->first(); @endphp
                                        <a href="{{ $quiz ? route('quiz.show', $quiz->id) : '#' }}"
                                           class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-bold text-white bg-purple-600 hover:bg-purple-700 transition shadow-md shadow-purple-600/20">
                                            <span>Mulai Kuis (Timer)</span>
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        </a>
                                    @elseif($level->type === 'tryout')
                                        @php $tryout = $level->quizzes->first(); @endphp
                                        <a href="{{ $tryout ? route('quiz.show', $tryout->id) : route('tryouts.index') }}"
                                           class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-bold text-white bg-emerald-600 hover:bg-emerald-700 transition shadow-md shadow-emerald-600/20">
                                            <span>Simulasi Tryout</span>
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                        </a>
                                    @endif
                                </div>
                            </div>

                            {{-- Center Node Icon (Circle) --}}
                            <div class="absolute left-8 sm:left-1/2 -translate-x-1/2 flex items-center justify-center">
                                @if($state === 'completed')
                                    <div class="w-14 h-14 rounded-full bg-success text-white flex items-center justify-center shadow-lg shadow-success/30 ring-4 ring-white dark:ring-[#161922] border-2 border-success">
                                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                    </div>
                                @elseif($state === 'current')
                                    <div class="w-16 h-16 rounded-full bg-bisa text-white flex items-center justify-center shadow-xl shadow-bisa/40 ring-4 ring-bisa/30 dark:ring-bisa/40 animate-pulse-glow border-2 border-white dark:border-[#161922]">
                                        <span class="text-2xl">⭐</span>
                                    </div>
                                @elseif($state === 'available')
                                    <div class="w-14 h-14 rounded-full bg-info text-white flex items-center justify-center shadow-md ring-4 ring-white dark:ring-[#161922] border-2 border-info">
                                        <span class="text-xl">🔵</span>
                                    </div>
                                @else
                                    <div class="w-12 h-12 rounded-full bg-gray-200 dark:bg-white/10 text-gray-400 dark:text-gray-500 flex items-center justify-center ring-4 ring-white dark:ring-[#161922] border border-gray-300 dark:border-white/10">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/></svg>
                                    </div>
                                @endif
                            </div>

                            {{-- Spacer for other side on desktop --}}
                            <div class="hidden sm:block sm:w-1/2"></div>
                        </div>
                    @endforeach

                    {{-- FINAL SIMULATION / TROPHY --}}
                    <div class="flex items-center sm:justify-center pl-4 sm:pl-0 pt-6">
                        <div class="bg-gradient-to-r from-gold to-bisa text-white px-6 py-3 rounded-full shadow-lg flex items-center gap-2 transform hover:scale-105 transition duration-300">
                            <span class="text-2xl">🏆</span>
                            <span class="text-xs font-black uppercase tracking-wider">Perguruan Tinggi Impian Menanti!</span>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
