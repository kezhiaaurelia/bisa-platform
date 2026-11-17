@extends('layouts.app')

@section('title', 'Kelas Live Interaktif — BISA')

@section('content')
<div class="bg-gray-50 dark:bg-[#0E1017] min-h-screen py-10 transition-colors duration-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Header Card --}}
        <div class="bg-white dark:bg-[#161922] rounded-3xl p-6 sm:p-8 border border-gray-100 dark:border-white/10 shadow-sm mb-8 flex flex-col md:flex-row md:items-center justify-between gap-6 animate-fade-in-down">
            <div>
                <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-purple-100 dark:bg-purple-950/40 text-purple-800 dark:text-purple-300 rounded-full text-xs font-black uppercase tracking-wider mb-2">
                    <i class="bi bi-camera-video-fill text-purple-600"></i> Kelas Live Interaktif
                </span>
                <h1 class="text-2xl sm:text-3xl font-black text-charcoal-dark dark:text-white">
                    Bimbingan Langsung Bersama Tentor Ahli
                </h1>
                <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-1 max-w-2xl leading-relaxed">
                    Tanya jawab langsung, kupas tuntas trik pengerjaan cepat soal HOTS, dan tonton ulang rekaman kelas kapan saja.
                </p>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('pricing.index') }}" class="px-4 py-2.5 bg-bisa-50 dark:bg-bisa-950/40 text-bisa border border-bisa/30 hover:bg-bisa hover:text-white rounded-xl text-xs font-bold transition flex items-center gap-2">
                    <i class="bi bi-star-fill text-amber-500"></i>
                    <span>Akses Seluruh Kelas (Premium)</span>
                </a>
            </div>
        </div>

        {{-- Section 1: Upcoming Live Classes --}}
        <div class="mb-12 animate-fade-in-up">
            <h2 class="text-lg font-black text-charcoal-dark dark:text-white mb-4 flex items-center gap-2">
                <i class="bi bi-broadcast text-rose-500 animate-pulse"></i>
                <span>Jadwal Sesi Mendatang</span>
            </h2>

            @if($upcomingClasses->isEmpty())
                <div class="bg-white dark:bg-[#161922] rounded-3xl p-10 text-center border border-gray-100 dark:border-white/10 text-xs text-gray-400">
                    Belum ada jadwal sesi live baru minggu ini. Cek kembali segera!
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($upcomingClasses as $lc)
                        @php
                            $isRegistered = in_array($lc->id, $registeredClassIds);
                        @endphp

                        <div class="bg-white dark:bg-[#161922] rounded-3xl p-6 border border-gray-100 dark:border-white/10 shadow-sm hover:shadow-lg transition-all flex flex-col justify-between">
                            <div>
                                <div class="flex items-center justify-between gap-2 mb-3">
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase bg-purple-100 dark:bg-purple-950/40 text-purple-700 dark:text-purple-300">
                                        {{ strtoupper($lc->category_slug) }}
                                    </span>
                                    <span class="text-[11px] font-bold text-gray-400">
                                        ⏱️ {{ $lc->duration_minutes }} Menit
                                    </span>
                                </div>

                                <h3 class="text-base font-extrabold text-charcoal-dark dark:text-white mb-2 leading-snug">
                                    {{ $lc->title }}
                                </h3>

                                <div class="flex items-center gap-2 text-xs text-bisa font-bold mb-3">
                                    <i class="bi bi-person-badge-fill"></i>
                                    <span>{{ $lc->instructor_name }}</span>
                                </div>

                                <p class="text-xs text-gray-500 dark:text-gray-400 line-clamp-2 leading-relaxed mb-4">
                                    {{ $lc->description }}
                                </p>

                                <div class="p-3 rounded-2xl bg-gray-50 dark:bg-white/5 text-[11px] text-gray-600 dark:text-gray-300 space-y-1 mb-5">
                                    <div class="flex items-center justify-between">
                                        <span class="text-gray-400">Hari & Waktu:</span>
                                        <span class="font-bold">{{ $lc->scheduled_at->format('d M Y, H:i') }} WIB</span>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <span class="text-gray-400">Platform:</span>
                                        <span class="font-bold">Google Meet / Zoom HD</span>
                                    </div>
                                </div>
                            </div>

                            <div class="pt-4 border-t border-gray-100 dark:border-white/10">
                                @if(!$isRegistered)
                                    <form action="{{ route('live-classes.register', $lc->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="w-full py-2.5 bg-bisa hover:bg-bisa-dark text-white font-extrabold text-xs rounded-xl shadow-md transition">
                                            Daftar Kelas Ini (Gratis)
                                        </button>
                                    </form>
                                @else
                                    <a href="{{ $lc->meet_url ?? '#' }}" target="_blank" class="w-full py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-xs rounded-xl shadow-md transition flex items-center justify-center gap-2">
                                        <i class="bi bi-camera-video"></i>
                                        <span>Masuk Ruang Kelas Live</span>
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Section 2: Recorded Live Classes --}}
        <div>
            <h2 class="text-lg font-black text-charcoal-dark dark:text-white mb-4 flex items-center gap-2">
                <i class="bi bi-play-btn-fill text-bisa"></i>
                <span>Arsip Rekaman Sesi Sebelumnya</span>
            </h2>

            @if($recordedClasses->isEmpty())
                <div class="bg-white dark:bg-[#161922] rounded-3xl p-8 text-center border border-gray-100 dark:border-white/10 text-xs text-gray-400">
                    Belum ada rekaman sesi yang dipublikasikan.
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($recordedClasses as $rc)
                        <div class="bg-white dark:bg-[#161922] rounded-3xl p-6 border border-gray-100 dark:border-white/10 shadow-sm flex flex-col justify-between">
                            <div>
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-black uppercase bg-gray-100 dark:bg-white/10 text-gray-600 dark:text-gray-300">
                                    Rekaman Video
                                </span>
                                <h3 class="text-sm font-extrabold text-charcoal-dark dark:text-white mt-2 mb-1">
                                    {{ $rc->title }}
                                </h3>
                                <p class="text-xs text-gray-400 mb-4">Pengajar: {{ $rc->instructor_name }}</p>
                            </div>

                            <a href="{{ $rc->recording_url }}" target="_blank" class="py-2 px-4 rounded-xl bg-gray-100 dark:bg-white/10 hover:bg-bisa hover:text-white text-charcoal-dark dark:text-white font-bold text-xs transition flex items-center justify-center gap-2">
                                <i class="bi bi-play-circle-fill text-sm"></i>
                                <span>Tonton Rekaman Kelas</span>
                            </a>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

    </div>
</div>
@endsection

