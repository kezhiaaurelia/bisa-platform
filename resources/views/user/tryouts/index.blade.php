@extends('layouts.app')

@section('title', 'Event Tryout Akbar & Simulasi PTN — BISA')

@section('content')
<div class="bg-gray-50 dark:bg-[#0E1017] min-h-screen py-10 transition-colors duration-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Header Card --}}
        <div class="bg-white dark:bg-[#161922] rounded-3xl p-6 sm:p-8 border border-gray-100 dark:border-white/10 shadow-sm mb-8 flex flex-col md:flex-row md:items-center justify-between gap-6 animate-fade-in-down">
            <div>
                <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-emerald-100 dark:bg-emerald-950/40 text-emerald-800 dark:text-emerald-300 rounded-full text-xs font-black uppercase tracking-wider mb-2">
                    <i class="bi bi-trophy-fill text-emerald-600"></i> Event Tryout & Simulasi Nasional
                </span>
                <h1 class="text-2xl sm:text-3xl font-black text-charcoal-dark dark:text-white">
                    Simulasi Tryout Berstandar Resmi
                </h1>
                <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-1 max-w-2xl leading-relaxed">
                    Kerjakan simulasi dengan timer presisi per subtes, dapatkan analisis nilai berskala Item Response Theory (IRT), serta pantau posisimu di Ranking Nasional.
                </p>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('pricing.index') }}" class="px-4 py-2.5 bg-bisa-50 dark:bg-bisa-950/40 text-bisa border border-bisa/30 hover:bg-bisa hover:text-white rounded-xl text-xs font-bold transition flex items-center gap-2">
                    <i class="bi bi-star-fill text-amber-500"></i>
                    <span>Paket Tryout Premium</span>
                </a>
            </div>
        </div>

        {{-- Category / Type Filter Buttons --}}
        <div class="flex items-center gap-2 pb-4 mb-6 overflow-x-auto text-xs font-bold">
            <a href="{{ route('tryouts.index', ['type' => 'all']) }}"
               class="px-4 py-2 rounded-xl transition {{ $selectedType === 'all' ? 'bg-bisa text-white shadow-md' : 'bg-white dark:bg-[#161922] text-gray-600 dark:text-gray-300 border border-gray-200 dark:border-white/10 hover:border-bisa' }}">
                Semua Event
            </a>
            <a href="{{ route('tryouts.index', ['type' => 'snbt']) }}"
               class="px-4 py-2 rounded-xl transition {{ $selectedType === 'snbt' ? 'bg-bisa text-white shadow-md' : 'bg-white dark:bg-[#161922] text-gray-600 dark:text-gray-300 border border-gray-200 dark:border-white/10 hover:border-bisa' }}">
                🎯 SNBT 2025
            </a>
            <a href="{{ route('tryouts.index', ['type' => 'utbk']) }}"
               class="px-4 py-2 rounded-xl transition {{ $selectedType === 'utbk' ? 'bg-bisa text-white shadow-md' : 'bg-white dark:bg-[#161922] text-gray-600 dark:text-gray-300 border border-gray-200 dark:border-white/10 hover:border-bisa' }}">
                💻 UTBK CAT
            </a>
            <a href="{{ route('tryouts.index', ['type' => 'mandiri']) }}"
               class="px-4 py-2 rounded-xl transition {{ $selectedType === 'mandiri' ? 'bg-bisa text-white shadow-md' : 'bg-white dark:bg-[#161922] text-gray-600 dark:text-gray-300 border border-gray-200 dark:border-white/10 hover:border-bisa' }}">
                🏛️ Ujian Mandiri (TKA)
            </a>
        </div>

        {{-- Section 1: Event Tryout Berjalan & Terjadwal --}}
        <div class="mb-12">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-black text-charcoal-dark dark:text-white flex items-center gap-2">
                    <i class="bi bi-calendar-event text-bisa"></i>
                    <span>Event Tryout Akbar Nasional</span>
                </h2>
                <span class="text-xs text-gray-400">{{ $events->count() }} Event Tersedia</span>
            </div>

            @if($events->isEmpty())
                <div class="bg-white dark:bg-[#161922] rounded-3xl p-10 text-center border border-gray-100 dark:border-white/10">
                    <p class="text-xs text-gray-400">Belum ada event tryout untuk kategori ini.</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($events as $ev)
                        @php
                            $userStatus = $userRegistrations[$ev->id] ?? null;
                            $isRegistered = (bool) $userStatus;
                        @endphp

                        <div class="bg-white dark:bg-[#161922] rounded-3xl p-6 border border-gray-100 dark:border-white/10 shadow-sm hover:shadow-lg transition-all flex flex-col justify-between">
                            <div>
                                {{-- Badges --}}
                                <div class="flex items-center justify-between gap-2 mb-3">
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider
                                        {{ $ev->event_type === 'snbt' ? 'bg-amber-100 dark:bg-amber-950/40 text-amber-800 dark:text-amber-300' : '' }}
                                        {{ $ev->event_type === 'utbk' ? 'bg-blue-100 dark:bg-blue-950/40 text-blue-800 dark:text-blue-300' : '' }}
                                        {{ $ev->event_type === 'mandiri' ? 'bg-purple-100 dark:bg-purple-950/40 text-purple-800 dark:text-purple-300' : '' }}
                                    ">
                                        {{ strtoupper($ev->event_type) }}
                                    </span>

                                    @if($ev->is_premium)
                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-black bg-gold/20 text-gold-dark dark:text-amber-300 border border-gold/40 flex items-center gap-1">
                                            <i class="bi bi-star-fill text-[9px]"></i> Premium
                                        </span>
                                    @else
                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 dark:bg-emerald-950/40 text-emerald-700 dark:text-emerald-300">
                                            Gratis
                                        </span>
                                    @endif
                                </div>

                                <h3 class="text-base font-extrabold text-charcoal-dark dark:text-white mb-2 leading-snug">
                                    {{ $ev->title }}
                                </h3>

                                <p class="text-xs text-gray-500 dark:text-gray-400 line-clamp-2 leading-relaxed mb-4">
                                    {{ $ev->description }}
                                </p>

                                {{-- Details row --}}
                                <div class="space-y-1.5 p-3 rounded-2xl bg-gray-50 dark:bg-white/5 text-[11px] text-gray-600 dark:text-gray-300 mb-5">
                                    <div class="flex items-center justify-between">
                                        <span class="text-gray-400">Jadwal Sesi:</span>
                                        <span class="font-bold">{{ $ev->start_date->format('d M') }} - {{ $ev->end_date->format('d M Y') }}</span>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <span class="text-gray-400">Durasi Tes:</span>
                                        <span class="font-bold">{{ $ev->duration_minutes }} Menit (Format Asli)</span>
                                    </div>
                                </div>
                            </div>

                            {{-- Actions --}}
                            <div class="pt-4 border-t border-gray-100 dark:border-white/10 space-y-2">
                                <div class="flex items-center justify-between gap-2">
                                    @if(!$isRegistered)
                                        <form action="{{ route('tryouts.register', $ev->id) }}" method="POST" class="w-full">
                                            @csrf
                                            <button type="submit" class="w-full py-2.5 bg-bisa hover:bg-bisa-dark text-white font-extrabold text-xs rounded-xl shadow-md transition">
                                                Daftar Event Tryout Ini
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('tryouts.start', $ev->id) }}" method="POST" class="w-full">
                                            @csrf
                                            <button type="submit" class="w-full py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-xs rounded-xl shadow-md transition flex items-center justify-center gap-1.5">
                                                <i class="bi bi-play-circle-fill"></i>
                                                <span>Mulai Pengerjaan Ujian</span>
                                            </button>
                                        </form>
                                    @endif
                                </div>

                                <div class="text-center">
                                    <a href="{{ route('tryouts.leaderboard', $ev->id) }}" class="text-[11px] font-bold text-gray-500 hover:text-bisa inline-flex items-center gap-1">
                                        <i class="bi bi-bar-chart-line-fill"></i>
                                        <span>Lihat Ranking Nasional & Leaderboard</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Section 2: Paket Drill Tryout Mandiri --}}
        <div>
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-black text-charcoal-dark dark:text-white flex items-center gap-2">
                    <i class="bi bi-layers-fill text-bisa"></i>
                    <span>Paket Drill Tryout Mandiri (Bisa Dikerjakan Kapan Saja)</span>
                </h2>
                <span class="text-xs text-gray-400">{{ $tryouts->count() }} Paket Latihan</span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($tryouts as $to)
                    @php
                        $isCompleted = in_array($to->id, $completedTryouts);
                    @endphp

                    <div class="bg-white dark:bg-[#161922] rounded-3xl p-6 border border-gray-100 dark:border-white/10 shadow-sm hover:border-emerald-500/40 hover:shadow-lg transition flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between gap-2 mb-3">
                                <span class="px-3 py-1 bg-emerald-50 dark:bg-emerald-950/30 text-emerald-800 dark:text-emerald-300 text-xs font-bold rounded-full uppercase">
                                    {{ $to->category ? $to->category->name : 'Simulasi Ujian' }}
                                </span>
                                <span class="px-3 py-1 bg-amber-50 dark:bg-amber-950/30 text-amber-700 dark:text-amber-300 text-xs font-semibold rounded-full flex items-center gap-1.5">
                                    <i class="bi bi-stopwatch"></i>
                                    {{ $to->duration_minutes }} Menit
                                </span>
                            </div>

                            <h3 class="text-lg font-extrabold text-charcoal-dark dark:text-white mb-2">
                                {{ $to->title }}
                            </h3>
                            <p class="text-xs text-gray-500 dark:text-gray-400 leading-relaxed mb-5">
                                {{ $to->description }}
                            </p>

                            <div class="grid grid-cols-3 gap-2 p-3.5 rounded-2xl bg-gray-50 dark:bg-white/5 text-center mb-5 text-xs">
                                <div>
                                    <div class="text-gray-400 text-[10px] uppercase font-bold">Jumlah Soal</div>
                                    <div class="font-extrabold text-charcoal-dark dark:text-white text-sm mt-0.5">{{ $to->questions_count }}</div>
                                </div>
                                <div>
                                    <div class="text-gray-400 text-[10px] uppercase font-bold">Passing Grade</div>
                                    <div class="font-extrabold text-bisa text-sm mt-0.5">{{ $to->pass_percentage }}%</div>
                                </div>
                                <div>
                                    <div class="text-gray-400 text-[10px] uppercase font-bold">Status</div>
                                    <div class="font-extrabold text-sm mt-0.5 {{ $isCompleted ? 'text-success' : 'text-blue-600' }}">
                                        {{ $isCompleted ? 'Selesai' : 'Tersedia' }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="pt-4 border-t border-gray-100 dark:border-white/10 flex items-center justify-between">
                            <span class="text-xs text-gray-400">Gratis untuk Siswa BISA</span>
                            <a href="{{ route('quiz.show', $to->id) }}"
                               class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl transition shadow-md flex items-center gap-2">
                                <span>{{ $isCompleted ? 'Kerjakan Ulang' : 'Mulai Simulasi' }}</span>
                                <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    </div>
</div>
@endsection
