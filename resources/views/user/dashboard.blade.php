@extends('layouts.app')

@section('title', 'Dashboard Siswa — BISA')

@section('content')
<div class="bg-gradient-to-b from-bisa-50/50 via-white to-gray-50 dark:from-[#0E1017] dark:via-[#121520] dark:to-[#0B0D13] min-h-screen pb-20 transition-colors duration-200">

    {{-- Welcome Hero with Profile summary & Target PTN --}}
    <div class="bg-white dark:bg-[#161922] border-b border-gray-100 dark:border-white/10 transition-colors duration-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 animate-fade-in-down">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-bisa to-gold text-white font-black text-2xl flex items-center justify-center shadow-lg shadow-bisa/20 ring-4 ring-bisa/10 transform hover:scale-105 transition duration-300">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <div>
                        <div class="flex flex-wrap items-center gap-2">
                            <h1 class="text-2xl font-bold text-charcoal-dark dark:text-white">Halo, {{ $user->name }}! 👋</h1>
                            @if($user->isPremium())
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-black bg-gold/20 text-gold-dark dark:text-amber-300 border border-gold/40">
                                    ★ VIP Premium
                                </span>
                            @else
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-bisa-100 dark:bg-bisa-900/40 text-bisa-800 dark:text-bisa-300">
                                    Pejuang {{ strtoupper($user->target_path ?? 'SNBT') }}
                                </span>
                            @endif
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-50 dark:bg-amber-950/40 text-amber-700 dark:text-amber-300 border border-amber-200/50 dark:border-amber-700/30">
                                🔥 Streak 3 Hari
                            </span>
                        </div>
                        <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-1 flex flex-wrap items-center gap-2">
                            <span>Target: <strong class="text-charcoal-dark dark:text-white">{{ $user->target_major ?? 'Belum Diatur' }}</strong> di <strong class="text-bisa">{{ $user->target_ptn ?? 'Pilih Kampus' }}</strong></span>
                            <a href="{{ route('onboarding') }}" class="text-[11px] text-bisa hover:underline font-bold">[Ubah Target]</a>
                        </p>
                    </div>
                </div>

                <div class="flex flex-wrap items-center gap-3">
                    <a href="{{ route('kakai.index') }}"
                       class="px-4 py-2.5 bg-purple-50 dark:bg-purple-950/40 text-purple-700 dark:text-purple-300 hover:bg-purple-600 hover:text-white rounded-xl text-xs font-extrabold border border-purple-200 dark:border-purple-800/40 transition flex items-center gap-2">
                        <i class="bi bi-robot"></i>
                        <span>Tanya KakAI</span>
                    </a>
                    <a href="{{ route('map.show', ['categorySlug' => 'snbt']) }}"
                       class="px-5 py-2.5 bg-bisa hover:bg-bisa-dark text-white text-xs font-extrabold rounded-xl shadow-lg shadow-bisa/25 transition flex items-center gap-2">
                        <i class="bi bi-compass-fill"></i>
                        <span>Buka Peta Belajar</span>
                    </a>
                </div>
            </div>

            {{-- 4 Stat Badges --}}
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-8">
                <div class="bg-bisa-50/70 dark:bg-bisa-950/25 rounded-2xl p-4 border border-bisa-100 dark:border-bisa-800/30 transition hover:-translate-y-1 duration-200">
                    <div class="flex items-center gap-2 text-bisa text-xs font-bold uppercase tracking-wider mb-1">
                        <i class="bi bi-pencil-fill"></i> Soal Dikerjakan
                    </div>
                    <div class="text-2xl font-extrabold text-charcoal-dark dark:text-white">{{ $totalQuestionsAnswered }}</div>
                </div>

                <div class="bg-blue-50/70 dark:bg-blue-950/25 rounded-2xl p-4 border border-blue-100 dark:border-blue-800/30 transition hover:-translate-y-1 duration-200">
                    <div class="flex items-center gap-2 text-blue-600 dark:text-blue-400 text-xs font-bold uppercase tracking-wider mb-1">
                        <i class="bi bi-journal-text"></i> Latihan Selesai
                    </div>
                    <div class="text-2xl font-extrabold text-charcoal-dark dark:text-white">{{ $totalPractices }}</div>
                </div>

                <div class="bg-purple-50/70 dark:bg-purple-950/25 rounded-2xl p-4 border border-purple-100 dark:border-purple-800/30 transition hover:-translate-y-1 duration-200">
                    <div class="flex items-center gap-2 text-purple-600 dark:text-purple-400 text-xs font-bold uppercase tracking-wider mb-1">
                        <i class="bi bi-stopwatch-fill"></i> Kuis Selesai
                    </div>
                    <div class="text-2xl font-extrabold text-charcoal-dark dark:text-white">{{ $totalQuizzes }}</div>
                </div>

                <div class="bg-emerald-50/70 dark:bg-emerald-950/25 rounded-2xl p-4 border border-emerald-100 dark:border-emerald-800/30 transition hover:-translate-y-1 duration-200">
                    <div class="flex items-center gap-2 text-emerald-600 dark:text-emerald-400 text-xs font-bold uppercase tracking-wider mb-1">
                        <i class="bi bi-bullseye"></i> Rata-Rata Nilai
                    </div>
                    <div class="text-2xl font-extrabold text-charcoal-dark dark:text-white">{{ number_format($avgScore, 1) }}</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Menu Utama Navigation Grid (Sesuai Flowchart 1 & 3) --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-8 animate-fade-in-up">
        <h2 class="text-xs font-bold uppercase tracking-wider text-gray-400 mb-3">Menu & Fitur Pembelajaran BISA</h2>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-3">
            {{-- 1. Latihan Soal --}}
            <a href="{{ route('practice.index') }}" class="p-4 rounded-2xl bg-white dark:bg-[#161922] border border-gray-100 dark:border-white/10 hover:border-bisa hover:shadow-md transition text-center group">
                <div class="w-10 h-10 rounded-xl bg-orange-100 dark:bg-orange-950/40 text-orange-600 dark:text-orange-400 flex items-center justify-center text-lg mx-auto mb-2 group-hover:bg-bisa group-hover:text-white transition">
                    <i class="bi bi-pencil-square"></i>
                </div>
                <div class="font-extrabold text-xs text-charcoal-dark dark:text-white">Latihan Soal</div>
                <span class="text-[10px] text-gray-400">7 Subtes SNBT</span>
            </a>

            {{-- 2. Tryout Akbar --}}
            <a href="{{ route('tryouts.index') }}" class="p-4 rounded-2xl bg-white dark:bg-[#161922] border border-gray-100 dark:border-white/10 hover:border-bisa hover:shadow-md transition text-center group">
                <div class="w-10 h-10 rounded-xl bg-emerald-100 dark:bg-emerald-950/40 text-emerald-600 dark:text-emerald-400 flex items-center justify-center text-lg mx-auto mb-2 group-hover:bg-emerald-600 group-hover:text-white transition">
                    <i class="bi bi-trophy-fill"></i>
                </div>
                <div class="font-extrabold text-xs text-charcoal-dark dark:text-white">Tryout Akbar</div>
                <span class="text-[10px] text-gray-400">Skor IRT & Ranking</span>
            </a>

            {{-- 3. Materi & Modul --}}
            <a href="{{ route('modules.index') }}" class="p-4 rounded-2xl bg-white dark:bg-[#161922] border border-gray-100 dark:border-white/10 hover:border-bisa hover:shadow-md transition text-center group">
                <div class="w-10 h-10 rounded-xl bg-blue-100 dark:bg-blue-950/40 text-blue-600 dark:text-blue-400 flex items-center justify-center text-lg mx-auto mb-2 group-hover:bg-blue-600 group-hover:text-white transition">
                    <i class="bi bi-journal-richtext"></i>
                </div>
                <div class="font-extrabold text-xs text-charcoal-dark dark:text-white">Materi & Modul</div>
                <span class="text-[10px] text-gray-400">Ringkasan Rumus</span>
            </a>

            {{-- 4. Kelas Live --}}
            <a href="{{ route('live-classes.index') }}" class="p-4 rounded-2xl bg-white dark:bg-[#161922] border border-gray-100 dark:border-white/10 hover:border-bisa hover:shadow-md transition text-center group">
                <div class="w-10 h-10 rounded-xl bg-purple-100 dark:bg-purple-950/40 text-purple-600 dark:text-purple-400 flex items-center justify-center text-lg mx-auto mb-2 group-hover:bg-purple-600 group-hover:text-white transition">
                    <i class="bi bi-camera-video-fill"></i>
                </div>
                <div class="font-extrabold text-xs text-charcoal-dark dark:text-white">Kelas Live</div>
                <span class="text-[10px] text-gray-400">Bimbingan Tentor</span>
            </a>

            {{-- 5. KakAI Tutor AI --}}
            <a href="{{ route('kakai.index') }}" class="p-4 rounded-2xl bg-white dark:bg-[#161922] border border-gray-100 dark:border-white/10 hover:border-bisa hover:shadow-md transition text-center group">
                <div class="w-10 h-10 rounded-xl bg-amber-100 dark:bg-amber-950/40 text-amber-600 dark:text-amber-400 flex items-center justify-center text-lg mx-auto mb-2 group-hover:bg-amber-500 group-hover:text-white transition">
                    <i class="bi bi-robot"></i>
                </div>
                <div class="font-extrabold text-xs text-charcoal-dark dark:text-white">KakAI Tutor AI</div>
                <span class="text-[10px] text-gray-400">Tanya Jawab 24/7</span>
            </a>

            {{-- 6. SNBP Analisis --}}
            <a href="{{ route('snbp.index') }}" class="p-4 rounded-2xl bg-white dark:bg-[#161922] border border-gray-100 dark:border-white/10 hover:border-bisa hover:shadow-md transition text-center group">
                <div class="w-10 h-10 rounded-xl bg-teal-100 dark:bg-teal-950/40 text-teal-600 dark:text-teal-400 flex items-center justify-center text-lg mx-auto mb-2 group-hover:bg-teal-600 group-hover:text-white transition">
                    <i class="bi bi-graph-up-arrow"></i>
                </div>
                <div class="font-extrabold text-xs text-charcoal-dark dark:text-white">SNBP Analisis</div>
                <span class="text-[10px] text-gray-400">Rasionalisasi Rapor</span>
            </a>
        </div>
    </div>

    {{-- Main Container --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-10 animate-fade-in-up">
        <div class="grid lg:grid-cols-3 gap-8">

            {{-- Col 1 & 2: Interactive Learning Map Preview --}}
            <div class="lg:col-span-2 space-y-8">

                {{-- Interactive Map Card --}}
                <div class="bg-white dark:bg-[#161922] rounded-3xl p-6 sm:p-8 border border-gray-100 dark:border-white/10 shadow-sm relative overflow-hidden transition-colors duration-200">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-gray-100 dark:border-white/10 mb-6">
                        <div>
                            <span class="text-xs font-bold text-bisa uppercase tracking-wider">Perjalanan Belajar Aktif</span>
                            <h2 class="text-xl font-extrabold text-charcoal-dark dark:text-white mt-0.5">
                                {{ $featuredSubject ? $featuredSubject->name : 'Peta Belajar SNBT' }}
                            </h2>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Selesaikan tiap level untuk membuka level berikutnya</p>
                        </div>

                        <div class="flex items-center gap-2">
                            <a href="{{ route('map.show', ['categorySlug' => 'snbt']) }}"
                               class="text-xs font-bold text-bisa hover:underline flex items-center gap-1 group">
                                <span>Lihat Peta Lengkap</span>
                                <i class="bi bi-chevron-right text-[10px]"></i>
                            </a>
                        </div>
                    </div>

                    {{-- Horizontal Visual Map Nodes --}}
                    @if($featuredLevels->isNotEmpty())
                        <div class="relative py-6">
                            {{-- Connector Line --}}
                            <div class="absolute left-6 right-6 top-1/2 -translate-y-1/2 h-2 bg-gradient-to-r from-bisa via-gold to-gray-200 dark:to-white/10 rounded-full z-0 hidden sm:block"></div>

                            <div class="grid grid-cols-1 sm:grid-cols-5 gap-6 relative z-10">
                                @foreach($featuredLevels->take(5) as $lvl)
                                    @php
                                        $nodeStatus = $lvl->getUserStatus($user);
                                    @endphp
                                    <div class="flex flex-col items-center text-center group">
                                        {{-- Circle Node --}}
                                        <div class="w-14 h-14 rounded-2xl flex items-center justify-center font-bold text-sm shadow-md transition-all duration-300 group-hover:scale-110 mb-3
                                            {{ $nodeStatus === 'completed' ? 'bg-success text-white shadow-success/20 ring-4 ring-success/20' : '' }}
                                            {{ $nodeStatus === 'available' ? 'bg-bisa text-white shadow-bisa/30 ring-4 ring-bisa/20 animate-pulse-glow' : '' }}
                                            {{ $nodeStatus === 'locked' ? 'bg-gray-100 dark:bg-white/5 text-gray-400 dark:text-gray-500 border border-gray-200 dark:border-white/10' : '' }}
                                        ">
                                            @if($nodeStatus === 'completed')
                                                <i class="bi bi-check-lg text-xl font-black"></i>
                                            @elseif($nodeStatus === 'available')
                                                ⭐
                                            @else
                                                <i class="bi bi-lock-fill text-sm"></i>
                                            @endif
                                        </div>

                                        <div class="text-xs font-bold text-charcoal-dark dark:text-gray-200 line-clamp-1">
                                            Level {{ $lvl->level_number }}
                                        </div>
                                        <div class="text-[11px] text-gray-500 dark:text-gray-400 mt-0.5 line-clamp-1">
                                            {{ $lvl->title }}
                                        </div>

                                        @if($nodeStatus === 'available')
                                            <a href="{{ route('practice.start', ['subjectId' => $featuredSubject->id, 'levelId' => $lvl->id]) }}"
                                               class="mt-2 px-3 py-1 bg-bisa text-white rounded-lg text-[10px] font-bold shadow-sm hover:bg-bisa-dark transition">
                                                Mulai
                                            </a>
                                        @elseif($nodeStatus === 'completed')
                                            <span class="mt-2 text-[10px] font-bold text-success">Selesai</span>
                                        @else
                                            <span class="mt-2 text-[10px] text-gray-400 dark:text-gray-500">Terkunci</span>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                {{-- Categories & Subjects Explorer --}}
                <div class="bg-white dark:bg-[#161922] rounded-3xl p-6 sm:p-8 border border-gray-100 dark:border-white/10 shadow-sm transition-colors duration-200">
                    <h3 class="text-base font-extrabold text-charcoal-dark dark:text-white mb-4">Pilih Subtes Belajar</h3>

                    <div class="space-y-4">
                        @foreach($categories as $cat)
                            <div class="border border-gray-100 dark:border-white/10 rounded-2xl p-4 hover:border-bisa/40 dark:hover:border-bisa/50 transition">
                                <div class="flex items-center justify-between mb-3">
                                    <div class="flex items-center gap-2">
                                        <span class="w-2.5 h-2.5 rounded-full bg-bisa"></span>
                                        <h4 class="font-extrabold text-charcoal-dark dark:text-white text-sm">{{ $cat->name }}</h4>
                                        <span class="text-xs text-gray-400">({{ $cat->subjects->count() }} subtes)</span>
                                    </div>
                                    <a href="{{ route('map.show', ['categorySlug' => $cat->slug]) }}"
                                       class="text-xs font-bold text-bisa hover:underline">
                                        Buka Map →
                                    </a>
                                </div>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($cat->subjects as $subj)
                                        <a href="{{ route('map.show', ['categorySlug' => $cat->slug, 'subjectSlug' => $subj->slug]) }}"
                                           class="px-3 py-1.5 bg-gray-50 dark:bg-white/5 hover:bg-bisa-50 dark:hover:bg-white/10 hover:text-bisa dark:hover:text-bisa rounded-xl text-xs font-semibold text-gray-700 dark:text-gray-300 transition border border-gray-100 dark:border-white/5">
                                            {{ $subj->name }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Col 3: Side Panel (Quick Actions & Recent Activity) --}}
            <div class="space-y-6">
                {{-- Mode Selection Card --}}
                <div class="bg-gradient-to-br from-charcoal to-charcoal-dark dark:from-[#1A1E27] dark:to-[#12141A] rounded-3xl p-6 text-white shadow-xl border border-white/5">
                    <h3 class="text-base font-bold mb-1">Pilih Mode Belajar</h3>
                    <p class="text-xs text-gray-300 mb-6">Pilih gaya belajarmu hari ini</p>

                    <div class="space-y-3">
                        <a href="{{ route('practice.index') }}"
                           class="flex items-center gap-3.5 p-3.5 rounded-2xl bg-white/10 dark:bg-white/5 hover:bg-white/20 dark:hover:bg-white/10 transition group">
                            <span class="text-2xl">✍️</span>
                            <div class="flex-1 min-w-0">
                                <div class="text-sm font-bold text-white group-hover:text-bisa transition">Mode Latihan</div>
                                <div class="text-[11px] text-gray-400">Santai, tanpa batas waktu, pembahasan instan</div>
                            </div>
                        </a>

                        <a href="{{ route('quizzes.index') }}"
                           class="flex items-center gap-3.5 p-3.5 rounded-2xl bg-white/10 dark:bg-white/5 hover:bg-white/20 dark:hover:bg-white/10 transition group">
                            <span class="text-2xl">⏱️</span>
                            <div class="flex-1 min-w-0">
                                <div class="text-sm font-bold text-white group-hover:text-gold transition">Mode Kuis</div>
                                <div class="text-[11px] text-gray-400">Timer berjalan, simulasi ujian sesungguhnya</div>
                            </div>
                        </a>

                        <a href="{{ route('tryouts.index') }}"
                           class="flex items-center gap-3.5 p-3.5 rounded-2xl bg-white/10 dark:bg-white/5 hover:bg-white/20 dark:hover:bg-white/10 transition group">
                            <span class="text-2xl">🎯</span>
                            <div class="flex-1 min-w-0">
                                <div class="text-sm font-bold text-white group-hover:text-emerald-400 transition">Tryout Akbar</div>
                                <div class="text-[11px] text-gray-400">Simulasi UTBK lengkap dengan analisis IRT</div>
                            </div>
                        </a>
                    </div>
                </div>

                {{-- Ambassador Banner --}}
                <div class="p-5 rounded-3xl bg-amber-50 dark:bg-amber-950/20 border border-amber-200/60 dark:border-amber-900/40">
                    <div class="flex items-center gap-3 mb-2">
                        <span class="text-xl">🤝</span>
                        <h4 class="font-bold text-xs text-amber-900 dark:text-amber-200">Program Ambassador BISA</h4>
                    </div>
                    <p class="text-[11px] text-amber-800 dark:text-amber-300 leading-relaxed mb-3">
                        Dapatkan sertifikat resmi & akses VIP dengan menjadi perwakilan duta pelajar BISA di sekolahmu.
                    </p>
                    <a href="{{ route('ambassador.index') }}" class="inline-flex items-center gap-1.5 text-xs font-black text-amber-900 dark:text-amber-200 hover:underline">
                        <span>Pelajari & Daftar</span>
                        <i class="bi bi-arrow-right"></i>
                    </a>
                </div>

                {{-- Recent Activity --}}
                <div class="bg-white dark:bg-[#161922] rounded-3xl p-6 border border-gray-100 dark:border-white/10 shadow-sm transition-colors duration-200">
                    <h3 class="text-xs font-black uppercase tracking-wider text-charcoal-dark dark:text-white mb-4">Riwayat Terakhir</h3>

                    @if($recentAttempts->isEmpty())
                        <div class="text-center py-6 text-gray-400 dark:text-gray-500 text-xs">
                            Belum ada riwayat pengerjaan soal. Mulai sekarang!
                        </div>
                    @else
                        <div class="space-y-3">
                            @foreach($recentAttempts as $attempt)
                                <div class="flex items-center justify-between p-3 rounded-xl bg-gray-50 dark:bg-white/5 border border-gray-100 dark:border-white/5 text-xs">
                                    <div>
                                        <div class="font-bold text-charcoal-dark dark:text-white">
                                            {{ $attempt->quiz ? $attempt->quiz->title : ($attempt->subject ? $attempt->subject->name : 'Latihan Mandiri') }}
                                        </div>
                                        <div class="text-[11px] text-gray-400">
                                            {{ ucfirst($attempt->type) }} • {{ $attempt->created_at->diffForHumans() }}
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <span class="font-black text-sm {{ $attempt->score >= 70 ? 'text-success' : 'text-bisa' }}">
                                            {{ number_format($attempt->score, 0) }}
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
