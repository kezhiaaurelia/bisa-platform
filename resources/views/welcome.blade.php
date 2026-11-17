@extends('layouts.app')

@section('title', 'BISA — Belajar Intensif dan Simulasi Akademik | Persiapan Masuk Perguruan Tinggi')

@section('content')

{{-- =========================================================================
     1. HERO SECTION (Academic Adventure & Gamified Learning Map)
     Entrance animation: Step 1 (Navbar) -> Step 2 (Headline) -> Step 3 (Visual Map)
     -> Step 4 (CTA & Trust Badges) -> Step 5 (Staggered Stickers Pop-in)
========================================================================= --}}
<section class="relative overflow-hidden bg-gradient-to-b from-bisa-50/70 via-white to-gray-50/50 dark:from-[#0B0D13] dark:via-[#11141E] dark:to-[#0E1017] transition-colors duration-300 py-16 lg:py-24 border-b border-gray-100 dark:border-white/5">
    {{-- Subtle academic grid background --}}
    <div class="absolute inset-0 opacity-[0.03] dark:opacity-[0.05] pointer-events-none"
         style="background-image: radial-gradient(circle, #2B2E38 1px, transparent 1px); background-size: 24px 24px;">
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
        <div class="grid lg:grid-cols-12 gap-12 lg:gap-8 items-center">

            {{-- Left Column: Copy & Actions --}}
            <div class="lg:col-span-6 space-y-6">
                {{-- Academic category badge --}}
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 bg-bisa-100 dark:bg-bisa-900/40 text-bisa-800 dark:text-bisa-300 rounded-full text-xs font-bold uppercase tracking-wider border border-bisa/20 animate-fade-in-down">
                    <span class="w-2 h-2 rounded-full bg-bisa animate-ping"></span>
                    <i class="bi bi-mortarboard-fill text-bisa text-sm"></i>
                    <span>Persiapan Masuk PTN Impian 2025</span>
                </div>

                {{-- Main Headline --}}
                <div class="animate-slide-left">
                    <h1 class="text-4xl sm:text-5xl lg:text-5xl xl:text-6xl font-black text-charcoal-dark dark:text-white leading-[1.12] tracking-tight">
                        Siap Masuk <span class="text-bisa underline decoration-bisa/30 decoration-wavy underline-offset-8">Perguruan Tinggi</span> Impianmu?
                    </h1>
                    <p class="text-lg sm:text-xl font-bold text-gray-700 dark:text-gray-200 mt-4 leading-snug">
                        Belajar Lebih Terarah, Siap Melangkah ke PTN Favorit.
                    </p>
                </div>

                {{-- Body Subtext --}}
                <p class="text-sm sm:text-base text-gray-600 dark:text-gray-300 leading-relaxed max-w-xl animate-fade-in-up delay-100">
                    Bukan sekadar bank soal biasa. <strong>BiSA</strong> memandu persiapan SNBT, TKA, dan UTBK lewat <em>Learning Journey Map</em> interaktif—buka materi level demi level, latih daya tahan dengan timer realistis, dan pantau grafik kesiapanmu setiap hari.
                </p>

                {{-- CTA Action Buttons --}}
                <div class="flex flex-wrap items-center gap-4 pt-2 animate-fade-in-up delay-200">
                    <a href="{{ route('register') }}"
                       class="inline-flex items-center gap-2.5 px-7 py-3.5 bg-bisa hover:bg-bisa-dark text-white font-extrabold text-sm rounded-2xl shadow-lg shadow-bisa/25 hover:shadow-xl hover:shadow-bisa/35 transition-all transform hover:-translate-y-0.5 active:translate-y-0">
                        <span>Mulai Belajar Gratis</span>
                        <i class="bi bi-arrow-right text-base font-bold"></i>
                    </a>
                    <a href="#cara-belajar"
                       class="inline-flex items-center gap-2 px-6 py-3.5 bg-white dark:bg-[#1A1E27] border-2 border-gray-200 dark:border-white/10 text-charcoal-dark dark:text-gray-200 font-bold text-sm rounded-2xl hover:border-bisa hover:text-bisa dark:hover:border-bisa dark:hover:text-bisa transition shadow-sm hover:shadow">
                        <i class="bi bi-map-fill text-bisa"></i>
                        <span>Lihat Cara Belajar</span>
                    </a>
                </div>

                {{-- Trust & Academic Standards Badges --}}
                <div class="pt-6 border-t border-gray-200/70 dark:border-white/10 flex flex-wrap items-center gap-5 text-xs text-gray-600 dark:text-gray-400 animate-fade-in-up delay-300">
                    <div class="flex items-center gap-2">
                        <span class="w-5 h-5 rounded-full bg-emerald-100 dark:bg-emerald-950/50 text-emerald-600 dark:text-emerald-400 flex items-center justify-center font-bold text-xs">✓</span>
                        <span class="font-medium">Sesuai Silabus Resmi SNPMB</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-5 h-5 rounded-full bg-emerald-100 dark:bg-emerald-950/50 text-emerald-600 dark:text-emerald-400 flex items-center justify-center font-bold text-xs">✓</span>
                        <span class="font-medium">Sistem Penilaian IRT Realistis</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-5 h-5 rounded-full bg-emerald-100 dark:bg-emerald-950/50 text-emerald-600 dark:text-emerald-400 flex items-center justify-center font-bold text-xs">✓</span>
                        <span class="font-medium">Pembahasan Konsep Mendalam</span>
                    </div>
                </div>
            </div>

            {{-- Right Column: Academic Adventure Journey Map Showcase --}}
            <div class="lg:col-span-6 relative animate-slide-right">
                {{-- Main Interactive Map Showcase Container --}}
                <div class="relative bg-white dark:bg-[#161922] rounded-3xl p-6 sm:p-7 shadow-xl border border-gray-200/80 dark:border-white/10">

                    {{-- Card Header: Map Subtest Title --}}
                    <div class="flex items-center justify-between pb-4 mb-5 border-b border-gray-100 dark:border-white/10">
                        <div class="flex items-center gap-3">
                            <span class="w-10 h-10 rounded-2xl bg-bisa/15 text-bisa flex items-center justify-center text-lg font-black shadow-inner">
                                <i class="bi bi-compass-fill"></i>
                            </span>
                            <div>
                                <span class="text-[11px] font-bold uppercase tracking-wider text-bisa">Peta Belajar Aktif</span>
                                <h3 class="text-sm font-extrabold text-charcoal-dark dark:text-white">Subtes: Penalaran Umum (SNBT)</h3>
                            </div>
                        </div>
                        <span class="px-3 py-1 bg-emerald-50 dark:bg-emerald-950/40 text-emerald-700 dark:text-emerald-300 text-xs font-extrabold rounded-full border border-emerald-200 dark:border-emerald-800/40">
                            Level 3 dari 6
                        </span>
                    </div>

                    {{-- Curved Journey Route (Academic Path with Nodes) --}}
                    <div class="space-y-4 relative py-2">
                        {{-- Node 1: Completed --}}
                        <div class="flex items-center gap-4 group">
                            <div class="relative flex items-center justify-center w-12 h-12 rounded-2xl bg-emerald-500 text-white shadow-md shadow-emerald-500/20 shrink-0">
                                <i class="bi bi-check-lg text-xl font-black"></i>
                                <span class="absolute -bottom-1 -right-1 w-4 h-4 rounded-full bg-white dark:bg-[#161922] flex items-center justify-center text-[9px] font-bold text-emerald-600">1</span>
                            </div>
                            <div class="flex-1 min-w-0 bg-gray-50 dark:bg-white/5 p-3 rounded-2xl border border-gray-100 dark:border-white/5">
                                <div class="flex items-center justify-between">
                                    <span class="text-xs font-bold text-charcoal-dark dark:text-white">Dasar Silogisme & Logika Proposisi</span>
                                    <span class="text-[11px] font-extrabold text-emerald-600 dark:text-emerald-400">100 / 100</span>
                                </div>
                                <span class="text-[11px] text-gray-500 dark:text-gray-400 block mt-0.5">Materi & 15 Soal • Selesai</span>
                            </div>
                        </div>

                        {{-- Node 2: Completed --}}
                        <div class="flex items-center gap-4 group">
                            <div class="relative flex items-center justify-center w-12 h-12 rounded-2xl bg-emerald-500 text-white shadow-md shadow-emerald-500/20 shrink-0">
                                <i class="bi bi-check-lg text-xl font-black"></i>
                                <span class="absolute -bottom-1 -right-1 w-4 h-4 rounded-full bg-white dark:bg-[#161922] flex items-center justify-center text-[9px] font-bold text-emerald-600">2</span>
                            </div>
                            <div class="flex-1 min-w-0 bg-gray-50 dark:bg-white/5 p-3 rounded-2xl border border-gray-100 dark:border-white/5">
                                <div class="flex items-center justify-between">
                                    <span class="text-xs font-bold text-charcoal-dark dark:text-white">Latihan Penalaran Deduktif & Analitik</span>
                                    <span class="text-[11px] font-extrabold text-emerald-600 dark:text-emerald-400">92 / 100</span>
                                </div>
                                <span class="text-[11px] text-gray-500 dark:text-gray-400 block mt-0.5">Mode Latihan Santai • Selesai</span>
                            </div>
                        </div>

                        {{-- Node 3: Current / Active (Pulsing Glow!) --}}
                        <div class="flex items-center gap-4 group">
                            <div class="relative flex items-center justify-center w-12 h-12 rounded-2xl bg-bisa text-white shadow-lg shadow-bisa/30 shrink-0 animate-pulse-glow">
                                <i class="bi bi-stopwatch text-xl"></i>
                                <span class="absolute -top-1 -right-1 flex h-3.5 w-3.5">
                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-3.5 w-3.5 bg-amber-500"></span>
                                </span>
                            </div>
                            <div class="flex-1 min-w-0 bg-bisa-50/70 dark:bg-bisa-950/30 p-3 rounded-2xl border-2 border-bisa/50">
                                <div class="flex items-center justify-between">
                                    <span class="text-xs font-black text-bisa-900 dark:text-bisa-200">Kuis Waktu: Penalaran Induktif</span>
                                    <span class="text-[10px] font-extrabold px-2 py-0.5 bg-bisa text-white rounded-full uppercase tracking-wider">Aktif</span>
                                </div>
                                <span class="text-[11px] text-bisa-800 dark:text-bisa-300 block mt-0.5">15 Menit • Target Nilai: 80</span>
                            </div>
                        </div>

                        {{-- Node 4: Locked --}}
                        <div class="flex items-center gap-4 opacity-60">
                            <div class="flex items-center justify-center w-12 h-12 rounded-2xl bg-gray-100 dark:bg-white/10 text-gray-400 dark:text-gray-500 shrink-0 border border-dashed border-gray-300 dark:border-white/20">
                                <i class="bi bi-lock-fill text-lg"></i>
                            </div>
                            <div class="flex-1 min-w-0 bg-gray-50 dark:bg-white/5 p-3 rounded-2xl border border-dashed border-gray-200 dark:border-white/10">
                                <span class="text-xs font-semibold text-gray-500 dark:text-gray-400 block">Latihan Pola Bilangan & Geometri Soal</span>
                                <span class="text-[10px] text-gray-400 block mt-0.5">Selesaikan Kuis Level 3 untuk membuka</span>
                            </div>
                        </div>

                        {{-- Final Milestone Node --}}
                        <div class="flex items-center gap-4 opacity-75">
                            <div class="flex items-center justify-center w-12 h-12 rounded-2xl bg-gold-light dark:bg-amber-950/40 text-gold-dark dark:text-amber-400 shrink-0 border border-gold/40">
                                <i class="bi bi-award-fill text-xl"></i>
                            </div>
                            <div class="flex-1 min-w-0 bg-gold-light/40 dark:bg-amber-950/20 p-3 rounded-2xl border border-gold/30">
                                <div class="flex items-center justify-between">
                                    <span class="text-xs font-bold text-charcoal-dark dark:text-white">Milestone: Target Skor 720+ PTN</span>
                                    <span class="text-[10px] font-extrabold text-gold-dark dark:text-amber-400">🏆 Kampus Impian</span>
                                </div>
                                <span class="text-[11px] text-gray-500 dark:text-gray-400 block mt-0.5">Prediksi Kelulusan STEI ITB / FK UI</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Staggered Pop-in Academic Stickers / Badges --}}
                {{-- Sticker 1: Top Right --}}
                <div class="hidden sm:flex absolute -top-5 -right-4 bg-white dark:bg-[#1A1E27] rounded-2xl shadow-xl border border-gray-200/80 dark:border-white/10 px-4 py-3 items-center gap-3 animate-sticker delay-150">
                    <span class="w-10 h-10 rounded-xl bg-orange-100 dark:bg-orange-950/40 text-orange-600 dark:text-orange-400 flex items-center justify-center text-lg">
                        <i class="bi bi-journal-check"></i>
                    </span>
                    <div>
                        <div class="text-xs font-black text-charcoal-dark dark:text-white">10.000+ Soal</div>
                        <div class="text-[11px] text-gray-500 dark:text-gray-400">Bank Soal & Pembahasan</div>
                    </div>
                </div>

                {{-- Sticker 2: Bottom Left --}}
                <div class="hidden sm:flex absolute -bottom-5 -left-4 bg-white dark:bg-[#1A1E27] rounded-2xl shadow-xl border border-gray-200/80 dark:border-white/10 px-4 py-3 items-center gap-3 animate-sticker delay-300">
                    <span class="w-10 h-10 rounded-xl bg-amber-100 dark:bg-amber-950/40 text-amber-600 dark:text-amber-400 flex items-center justify-center text-lg">
                        <i class="bi bi-fire"></i>
                    </span>
                    <div>
                        <div class="text-xs font-black text-charcoal-dark dark:text-white">7 Hari Streak</div>
                        <div class="text-[11px] text-gray-500 dark:text-gray-400">Konsistensi Belajar Siswa</div>
                    </div>
                </div>

                {{-- Sticker 3: Right Center --}}
                <div class="hidden md:flex absolute top-1/2 -right-6 -translate-y-1/2 bg-white dark:bg-[#1A1E27] rounded-2xl shadow-xl border border-gray-200/80 dark:border-white/10 px-4 py-2.5 items-center gap-2.5 animate-sticker delay-450">
                    <span class="w-8 h-8 rounded-lg bg-emerald-100 dark:bg-emerald-950/40 text-emerald-600 dark:text-emerald-400 flex items-center justify-center text-sm font-black">
                        <i class="bi bi-trophy-fill"></i>
                    </span>
                    <div>
                        <div class="text-xs font-black text-emerald-600 dark:text-emerald-400">98.4% Lulus</div>
                        <div class="text-[10px] text-gray-400">PTN Favorit Pilihan 1 & 2</div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

{{-- =========================================================================
     2. SECTION: MAU MULAI DARI MANA? (3 Pilihan Persiapan dengan Variasi Desain)
========================================================================= --}}
<section id="programs" class="py-20 bg-white dark:bg-[#0E1017] transition-colors duration-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Section Header --}}
        <div class="text-center max-w-2xl mx-auto mb-14" data-reveal>
            <div class="inline-flex items-center gap-2 px-3 py-1 bg-bisa-50 dark:bg-bisa-950/40 text-bisa font-bold text-xs rounded-full uppercase tracking-wider mb-3 border border-bisa/20">
                <i class="bi bi-bullseye"></i>
                <span>Pilih Jalur Seleksi</span>
            </div>
            <h2 class="text-3xl lg:text-4xl font-extrabold text-charcoal-dark dark:text-white tracking-tight">
                Mau Mulai dari Mana?
            </h2>
            <p class="text-gray-500 dark:text-gray-400 mt-3 text-sm leading-relaxed">
                Setiap jalur seleksi perguruan tinggi memiliki karakter soal yang berbeda. Pilih program sesuai target ujianmu tahun ini.
            </p>
        </div>

        {{-- 3 Asymmetric / Varied Cards --}}
        <div class="grid md:grid-cols-3 gap-8 items-stretch">

            {{-- Card 1: TKA (Tes Kemampuan Akademik) --}}
            <div class="group relative bg-white dark:bg-[#161922] border-2 border-gray-100 dark:border-white/10 rounded-3xl p-8 hover:border-bisa/60 dark:hover:border-bisa/60 hover:shadow-xl transition-all duration-300 flex flex-col justify-between" data-reveal>
                <div>
                    <div class="flex items-center justify-between mb-6">
                        <div class="w-14 h-14 rounded-2xl bg-orange-100 dark:bg-orange-950/40 text-orange-600 dark:text-orange-400 flex items-center justify-center text-2xl group-hover:bg-bisa group-hover:text-white transition-all shadow-sm">
                            <i class="bi bi-book-half"></i>
                        </div>
                        <span class="text-xs font-bold px-3 py-1 rounded-full bg-gray-100 dark:bg-white/5 text-gray-600 dark:text-gray-300">
                            Ujian Mandiri
                        </span>
                    </div>

                    <h3 class="text-2xl font-black text-charcoal-dark dark:text-white mb-2">TKA</h3>
                    <div class="text-xs font-bold text-bisa mb-3">Tes Kemampuan Akademik</div>
                    <p class="text-sm text-gray-500 dark:text-gray-400 leading-relaxed mb-6">
                        Kuasai materi mendalam kelompok Saintek dan Soshum untuk seleksi mandiri PTN terkemuka seperti SIMAK UI, UTUL UGM, SMUP Unpad, dan Ujian Mandiri lainnya.
                    </p>

                    <div class="space-y-2.5 pt-4 border-t border-gray-100 dark:border-white/10 text-xs text-gray-600 dark:text-gray-300">
                        <div class="flex items-center gap-2">
                            <i class="bi bi-check-circle-fill text-bisa"></i>
                            <span>10 Mata Pelajaran Terpadu (Fisika, Kimia, dll)</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <i class="bi bi-check-circle-fill text-bisa"></i>
                            <span>Rangkuman Rumus dan Intisari Bab</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <i class="bi bi-check-circle-fill text-bisa"></i>
                            <span>Kumpulan Arsip Soal 5 Tahun Terakhir</span>
                        </div>
                    </div>
                </div>

                <div class="mt-8 pt-4">
                    <a href="{{ route('map.show', ['categorySlug' => 'tka']) }}"
                       class="w-full inline-flex items-center justify-center gap-2 py-3 px-4 rounded-xl font-bold text-xs text-charcoal-dark dark:text-white bg-gray-100 dark:bg-white/5 hover:bg-bisa hover:text-white dark:hover:bg-bisa transition">
                        <span>Buka Jalur TKA</span>
                        <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>

            {{-- Card 2: SNBT (Seleksi Nasional Berbasis Tes) — FEATURED CARD --}}
            <div class="group relative bg-white dark:bg-[#161922] border-2 border-bisa dark:border-bisa rounded-3xl p-8 hover:shadow-2xl hover:shadow-bisa/20 transition-all duration-300 flex flex-col justify-between ring-4 ring-bisa/15 transform md:-translate-y-2" data-reveal>
                {{-- Recommended Badge --}}
                <div class="absolute -top-3.5 left-1/2 -translate-x-1/2 px-4 py-1 bg-gradient-to-r from-bisa to-bisa-dark text-white rounded-full text-[10px] font-black uppercase tracking-wider shadow-md flex items-center gap-1.5">
                    <i class="bi bi-star-fill text-[9px] text-amber-300"></i>
                    <span>Paling Banyak Dipilih</span>
                </div>

                <div>
                    <div class="flex items-center justify-between mb-6">
                        <div class="w-14 h-14 rounded-2xl bg-bisa text-white flex items-center justify-center text-2xl shadow-lg shadow-bisa/30 transition-all">
                            <i class="bi bi-bullseye"></i>
                        </div>
                        <span class="text-xs font-bold px-3 py-1 rounded-full bg-bisa-100 dark:bg-bisa-900/40 text-bisa-800 dark:text-bisa-300">
                            Jalur Nasional
                        </span>
                    </div>

                    <h3 class="text-2xl font-black text-charcoal-dark dark:text-white mb-2">SNBT</h3>
                    <div class="text-xs font-bold text-bisa mb-3">Seleksi Nasional Berbasis Tes</div>
                    <p class="text-sm text-gray-500 dark:text-gray-400 leading-relaxed mb-6">
                        Pelatihan terstruktur 7 subtes resmi SNPMB: Tes Potensi Skolastik (TPS), Literasi Bahasa Indonesia & Inggris, serta Penalaran Matematika.
                    </p>

                    <div class="space-y-2.5 pt-4 border-t border-gray-100 dark:border-white/10 text-xs text-gray-700 dark:text-gray-200 font-medium">
                        <div class="flex items-center gap-2">
                            <i class="bi bi-check-circle-fill text-bisa"></i>
                            <span>7 Subtes Lengkap Sesuai Standar Resmi</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <i class="bi bi-check-circle-fill text-bisa"></i>
                            <span>Peta Level Terpandu (Materi Dasar s.d Soal HOTS)</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <i class="bi bi-check-circle-fill text-bisa"></i>
                            <span>Mendukung Format Pilihan Ganda Kompleks</span>
                        </div>
                    </div>
                </div>

                <div class="mt-8 pt-4">
                    <a href="{{ route('map.show', ['categorySlug' => 'snbt']) }}"
                       class="w-full inline-flex items-center justify-center gap-2 py-3 px-4 rounded-xl font-extrabold text-xs text-white bg-bisa hover:bg-bisa-dark shadow-md shadow-bisa/25 transition">
                        <span>Mulai Persiapan SNBT Sekarang</span>
                        <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>

            {{-- Card 3: UTBK (Ujian Tulis Berbasis Komputer) --}}
            <div class="group relative bg-white dark:bg-[#161922] border-2 border-gray-100 dark:border-white/10 rounded-3xl p-8 hover:border-bisa/60 dark:hover:border-bisa/60 hover:shadow-xl transition-all duration-300 flex flex-col justify-between" data-reveal>
                <div>
                    <div class="flex items-center justify-between mb-6">
                        <div class="w-14 h-14 rounded-2xl bg-blue-100 dark:bg-blue-950/40 text-blue-600 dark:text-blue-400 flex items-center justify-center text-2xl group-hover:bg-info group-hover:text-white transition-all shadow-sm">
                            <i class="bi bi-laptop"></i>
                        </div>
                        <span class="text-xs font-bold px-3 py-1 rounded-full bg-gray-100 dark:bg-white/5 text-gray-600 dark:text-gray-300">
                            Simulasi CAT
                        </span>
                    </div>

                    <h3 class="text-2xl font-black text-charcoal-dark dark:text-white mb-2">UTBK</h3>
                    <div class="text-xs font-bold text-info dark:text-blue-400 mb-3">Ujian Tulis Berbasis Komputer</div>
                    <p class="text-sm text-gray-500 dark:text-gray-400 leading-relaxed mb-6">
                        Paket drill soal komprehensif dengan antarmuka yang dirancang presisi menyerupai sistem CAT resmi panitia seleksi, melatih kecepatan dan ketepatan.
                    </p>

                    <div class="space-y-2.5 pt-4 border-t border-gray-100 dark:border-white/10 text-xs text-gray-600 dark:text-gray-300">
                        <div class="flex items-center gap-2">
                            <i class="bi bi-check-circle-fill text-info dark:text-blue-400"></i>
                            <span>Simulasi Antarmuka Mirip Sistem Asli</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <i class="bi bi-check-circle-fill text-info dark:text-blue-400"></i>
                            <span>Perhitungan Skor Nilai Prediksi IRT</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <i class="bi bi-check-circle-fill text-info dark:text-blue-400"></i>
                            <span>Analisis Detail Kelemahan Subtes</span>
                        </div>
                    </div>
                </div>

                <div class="mt-8 pt-4">
                    <a href="{{ route('map.show', ['categorySlug' => 'utbk']) }}"
                       class="w-full inline-flex items-center justify-center gap-2 py-3 px-4 rounded-xl font-bold text-xs text-charcoal-dark dark:text-white bg-gray-100 dark:bg-white/5 hover:bg-info hover:text-white transition">
                        <span>Buka Simulasi UTBK</span>
                        <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- =========================================================================
     3. SECTION: SATU PLATFORM, BANYAK CARA BELAJAR (Asymmetric Bento Grid)
========================================================================= --}}
<section id="cara-belajar" class="py-20 bg-gray-50/70 dark:bg-[#11141E] transition-colors duration-200 border-y border-gray-100 dark:border-white/5">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Section Header --}}
        <div class="text-center max-w-2xl mx-auto mb-14" data-reveal>
            <div class="inline-flex items-center gap-2 px-3 py-1 bg-bisa-50 dark:bg-bisa-950/40 text-bisa font-bold text-xs rounded-full uppercase tracking-wider mb-3 border border-bisa/20">
                <i class="bi bi-lightbulb-fill"></i>
                <span>Metode Belajar Modern</span>
            </div>
            <h2 class="text-3xl lg:text-4xl font-extrabold text-charcoal-dark dark:text-white tracking-tight">
                Satu Platform, Banyak Cara Belajar
            </h2>
            <p class="text-gray-500 dark:text-gray-400 mt-3 text-sm leading-relaxed">
                Tiap siswa punya ritme belajar berbeda. Di BISA, kamu bisa pilih mode sesuai kesiapanmu: dari memahami konsep dasar sampai simulasi di bawah tekanan waktu.
            </p>
        </div>

        {{-- Bento Grid Layout (Varied Dimensions) --}}
        <div class="grid md:grid-cols-12 gap-6">

            {{-- 1. Modul Belajar (Wide Top-Left Bento) --}}
            <div class="md:col-span-7 bg-white dark:bg-[#161922] rounded-3xl p-8 border border-gray-100 dark:border-white/10 shadow-sm hover:shadow-md transition-all flex flex-col justify-between" data-reveal="left">
                <div>
                    <div class="flex items-center gap-3 mb-4">
                        <span class="w-12 h-12 rounded-2xl bg-amber-100 dark:bg-amber-950/40 text-amber-700 dark:text-amber-300 flex items-center justify-center text-xl">
                            <i class="bi bi-journal-richtext"></i>
                        </span>
                        <div>
                            <span class="text-[11px] font-bold text-bisa uppercase tracking-wider">Modul Pembelajaran</span>
                            <h3 class="text-xl font-extrabold text-charcoal-dark dark:text-white">Teori Ringkas & Strategi Pola Soal</h3>
                        </div>
                    </div>
                    <p class="text-sm text-gray-500 dark:text-gray-400 leading-relaxed mb-6">
                        Tidak perlu membaca buku setebal ratusan halaman. Materi disarikan menjadi konsep esensial dengan contoh soal representatif, pola jebakan, dan trik pengerjaan cepat dalam hitungan detik.
                    </p>
                    <div class="grid sm:grid-cols-2 gap-3 text-xs text-gray-600 dark:text-gray-300">
                        <div class="p-3 rounded-xl bg-gray-50 dark:bg-white/5 border border-gray-100 dark:border-white/5">
                            <span class="font-bold text-charcoal-dark dark:text-white block mb-0.5">📌 Poin Kunci Tiap Bab</span>
                            <span>Intisari konsep tanpa penjelasan bertele-tele.</span>
                        </div>
                        <div class="p-3 rounded-xl bg-gray-50 dark:bg-white/5 border border-gray-100 dark:border-white/5">
                            <span class="font-bold text-charcoal-dark dark:text-white block mb-0.5">💡 Cheat-Sheet Rumus</span>
                            <span>Rumus cepat dan pola eliminasi jawaban salah.</span>
                        </div>
                    </div>
                </div>
                <div class="mt-6 pt-4 border-t border-gray-100 dark:border-white/10 flex items-center justify-between text-xs font-semibold text-bisa">
                    <span>Tersedia untuk semua level belajar</span>
                    <i class="bi bi-arrow-right"></i>
                </div>
            </div>

            {{-- 2. Mode Latihan Santai (Right Bento) --}}
            <div class="md:col-span-5 bg-white dark:bg-[#161922] rounded-3xl p-8 border border-gray-100 dark:border-white/10 shadow-sm hover:shadow-md transition-all flex flex-col justify-between" data-reveal="right">
                <div>
                    <div class="flex items-center gap-3 mb-4">
                        <span class="w-12 h-12 rounded-2xl bg-emerald-100 dark:bg-emerald-950/40 text-emerald-700 dark:text-emerald-300 flex items-center justify-center text-xl">
                            <i class="bi bi-pencil-square"></i>
                        </span>
                        <div>
                            <span class="text-[11px] font-bold text-emerald-600 dark:text-emerald-400 uppercase tracking-wider">Mode Latihan</span>
                            <h3 class="text-xl font-extrabold text-charcoal-dark dark:text-white">Belajar Santai Tanpa Beban</h3>
                        </div>
                    </div>
                    <p class="text-sm text-gray-500 dark:text-gray-400 leading-relaxed mb-4">
                        Kerjakan soal sesuai ritmemu sendiri. Tanpa hitung mundur waktu. Jawaban langsung dicek seketika dan tombol <strong>"Lihat Pembahasan"</strong> dapat dibuka kapan saja untuk membedah langkah penyelesaian.
                    </p>
                    <div class="p-3.5 rounded-2xl bg-emerald-50 dark:bg-emerald-950/30 border border-emerald-200 dark:border-emerald-800/30 text-xs text-emerald-900 dark:text-emerald-200">
                        <span class="font-bold">✨ Cocok Untuk:</span> Membangun fondasi konsep, memahami logika soal baru, dan mencatat pola pembahasan tanpa terburu-buru.
                    </div>
                </div>
                <div class="mt-6 pt-4 border-t border-gray-100 dark:border-white/10">
                    <a href="{{ route('practice.index') }}" class="inline-flex items-center gap-2 text-xs font-bold text-emerald-600 dark:text-emerald-400 hover:underline">
                        <span>Coba Mode Latihan Sekarang</span>
                        <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>

            {{-- 3. Mode Kuis Waktu (Bottom-Left Bento) --}}
            <div class="md:col-span-5 bg-white dark:bg-[#161922] rounded-3xl p-8 border border-gray-100 dark:border-white/10 shadow-sm hover:shadow-md transition-all flex flex-col justify-between" data-reveal="left">
                <div>
                    <div class="flex items-center gap-3 mb-4">
                        <span class="w-12 h-12 rounded-2xl bg-purple-100 dark:bg-purple-950/40 text-purple-700 dark:text-purple-300 flex items-center justify-center text-xl">
                            <i class="bi bi-stopwatch-fill"></i>
                        </span>
                        <div>
                            <span class="text-[11px] font-bold text-purple-600 dark:text-purple-400 uppercase tracking-wider">Mode Kuis</span>
                            <h3 class="text-xl font-extrabold text-charcoal-dark dark:text-white">Simulasi Tekanan Waktu Asli</h3>
                        </div>
                    </div>
                    <p class="text-sm text-gray-500 dark:text-gray-400 leading-relaxed mb-4">
                        Latih manajemen waktu dengan countdown timer realistis. Feedback benar/salah disembunyikan sampai seluruh sesi selesai, menguji ketahanan mental persis suasana ruang ujian resmi.
                    </p>
                    <div class="p-3.5 rounded-2xl bg-purple-50 dark:bg-purple-950/30 border border-purple-200 dark:border-purple-800/30 text-xs text-purple-900 dark:text-purple-200">
                        <span class="font-bold">⏱️ Fitur Utama:</span> Timer presisi, auto-save jawaban per detik, serta peringatan waktu 5 menit terakhir.
                    </div>
                </div>
                <div class="mt-6 pt-4 border-t border-gray-100 dark:border-white/10">
                    <a href="{{ route('tryouts.index') }}" class="inline-flex items-center gap-2 text-xs font-bold text-purple-600 dark:text-purple-400 hover:underline">
                        <span>Mulai Kuis Simulasi</span>
                        <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>

            {{-- 4. Tryout Periodik & Evaluasi IRT (Bottom-Right Bento) --}}
            <div class="md:col-span-7 bg-white dark:bg-[#161922] rounded-3xl p-8 border border-gray-100 dark:border-white/10 shadow-sm hover:shadow-md transition-all flex flex-col justify-between" data-reveal="right">
                <div>
                    <div class="flex items-center gap-3 mb-4">
                        <span class="w-12 h-12 rounded-2xl bg-blue-100 dark:bg-blue-950/40 text-blue-700 dark:text-blue-300 flex items-center justify-center text-xl">
                            <i class="bi bi-trophy-fill"></i>
                        </span>
                        <div>
                            <span class="text-[11px] font-bold text-blue-600 dark:text-blue-400 uppercase tracking-wider">Tryout Nasional</span>
                            <h3 class="text-xl font-extrabold text-charcoal-dark dark:text-white">Simulasi IRT & Pemeringkatan Kampus</h3>
                        </div>
                    </div>
                    <p class="text-sm text-gray-500 dark:text-gray-400 leading-relaxed mb-6">
                        Ujian akbar berkala dengan sistem pembobotan <em>Item Response Theory</em> (IRT). Ketahui peluang kelulusanmu di program studi impian lewat analisis passing grade dan grafik perbandingan nasional.
                    </p>
                    <div class="grid sm:grid-cols-3 gap-3 text-center">
                        <div class="p-3 rounded-2xl bg-gray-50 dark:bg-white/5 border border-gray-100 dark:border-white/5">
                            <div class="text-lg font-black text-blue-600 dark:text-blue-400">Skor IRT</div>
                            <span class="text-[11px] text-gray-500 dark:text-gray-400">Pembobotan Tingkat Kesulitan</span>
                        </div>
                        <div class="p-3 rounded-2xl bg-gray-50 dark:bg-white/5 border border-gray-100 dark:border-white/5">
                            <div class="text-lg font-black text-bisa">Peluang PTN</div>
                            <span class="text-[11px] text-gray-500 dark:text-gray-400">Rekomendasi Pilihan 1 & 2</span>
                        </div>
                        <div class="p-3 rounded-2xl bg-gray-50 dark:bg-white/5 border border-gray-100 dark:border-white/5">
                            <div class="text-lg font-black text-emerald-600 dark:text-emerald-400">Peringkat</div>
                            <span class="text-[11px] text-gray-500 dark:text-gray-400">Leaderboard Peserta</span>
                        </div>
                    </div>
                </div>
                <div class="mt-6 pt-4 border-t border-gray-100 dark:border-white/10 flex items-center justify-between text-xs font-semibold text-blue-600 dark:text-blue-400">
                    <a href="{{ route('tryouts.index') }}" class="hover:underline flex items-center gap-1.5">
                        <span>Lihat Jadwal Tryout Aktif</span>
                        <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- =========================================================================
     4. SECTION: LEARNING MAP DETAIL (Visualisasi Peta Petualangan Belajar)
========================================================================= --}}
<section class="py-20 bg-white dark:bg-[#0E1017] transition-colors duration-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-12 gap-12 items-center">

            {{-- Explanation --}}
            <div class="lg:col-span-5 space-y-6" data-reveal="left">
                <div class="inline-flex items-center gap-2 px-3 py-1 bg-bisa-50 dark:bg-bisa-950/40 text-bisa font-bold text-xs rounded-full uppercase tracking-wider border border-bisa/20">
                    <i class="bi bi-geo-alt-fill"></i>
                    <span>Konsep Belajar Terstruktur</span>
                </div>
                <h2 class="text-3xl lg:text-4xl font-extrabold text-charcoal-dark dark:text-white tracking-tight leading-tight">
                    Peta Belajar: Taklukkan Materi Level demi Level
                </h2>
                <p class="text-sm text-gray-600 dark:text-gray-300 leading-relaxed">
                    Belajar persiapan tes perguruan tinggi sering kali terasa membingungkan karena begitu banyaknya materi. Di BISA, setiap subtes disusun menjadi <strong>checkpoint terarah</strong>:
                </p>

                <div class="space-y-3.5 text-xs text-gray-600 dark:text-gray-300">
                    <div class="flex items-start gap-3">
                        <span class="w-6 h-6 rounded-lg bg-emerald-500 text-white flex items-center justify-center font-bold text-xs shrink-0 mt-0.5">✓</span>
                        <div>
                            <strong class="text-charcoal-dark dark:text-white">Level Selesai (Completed):</strong>
                            Materi yang telah kamu tuntaskan dengan nilai di atas batas kelulusan. Dapat diulang kapan saja untuk evaluasi.
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <span class="w-6 h-6 rounded-lg bg-bisa text-white flex items-center justify-center font-bold text-xs shrink-0 mt-0.5">⚡</span>
                        <div>
                            <strong class="text-charcoal-dark dark:text-white">Level Aktif (Current):</strong>
                            Fokus belajarmu saat ini. Dilengkapi target skor minimal untuk membuka level berikutnya.
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <span class="w-6 h-6 rounded-lg bg-gray-200 dark:bg-white/10 text-gray-500 flex items-center justify-center font-bold text-xs shrink-0 mt-0.5">🔒</span>
                        <div>
                            <strong class="text-charcoal-dark dark:text-white">Level Terkunci (Locked):</strong>
                            Mencegah kebiasaan melompati materi sebelum dasar konsep benar-benar kuat.
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <span class="w-6 h-6 rounded-lg bg-gold text-white flex items-center justify-center font-bold text-xs shrink-0 mt-0.5">🏆</span>
                        <div>
                            <strong class="text-charcoal-dark dark:text-white">Milestone Pencapaian:</strong>
                            Tahapan krusial seperti Tryout Akhir dan simulasi kesiapan passing grade prodi pilihan.
                        </div>
                    </div>
                </div>

                <div class="pt-2">
                    <a href="{{ route('map.show', ['categorySlug' => 'snbt']) }}"
                       class="inline-flex items-center gap-2 px-6 py-3 bg-charcoal-dark hover:bg-black dark:bg-white/10 dark:hover:bg-white/20 text-white font-bold text-xs rounded-xl transition">
                        <span>Jelajahi Peta Belajar Sekarang</span>
                        <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>

            {{-- Map Graphic Showcase --}}
            <div class="lg:col-span-7" data-reveal="right">
                <div class="bg-gradient-to-br from-bisa-50/60 via-white to-gray-50/50 dark:from-[#131722] dark:via-[#161922] dark:to-[#1A1E27] rounded-3xl p-6 sm:p-8 border border-gray-200/80 dark:border-white/10 shadow-lg">
                    <div class="flex items-center justify-between pb-4 mb-6 border-b border-gray-100 dark:border-white/10">
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-3 rounded-full bg-emerald-500"></span>
                            <span class="text-xs font-bold text-charcoal-dark dark:text-white">Jalur: Literasi Bahasa Indonesia</span>
                        </div>
                        <span class="text-[11px] text-gray-400">Total 5 Level Pembelajaran</span>
                    </div>

                    {{-- Horizontal Visual Nodes --}}
                    <div class="grid grid-cols-2 sm:grid-cols-5 gap-4 text-center">
                        {{-- Step 1 --}}
                        <div class="p-3 bg-white dark:bg-white/5 rounded-2xl border border-emerald-200 dark:border-emerald-800/40 shadow-sm flex flex-col items-center">
                            <div class="w-10 h-10 rounded-xl bg-emerald-500 text-white flex items-center justify-center text-sm font-black mb-2 shadow-sm">
                                <i class="bi bi-check-lg"></i>
                            </div>
                            <span class="text-[10px] font-bold text-emerald-600 dark:text-emerald-400 uppercase">Level 1</span>
                            <span class="text-xs font-extrabold text-charcoal-dark dark:text-white mt-0.5 line-clamp-1">Ide Pokok Paragraf</span>
                            <span class="text-[10px] text-gray-400 mt-1">Selesai (Skor 95)</span>
                        </div>

                        {{-- Step 2 --}}
                        <div class="p-3 bg-white dark:bg-white/5 rounded-2xl border border-emerald-200 dark:border-emerald-800/40 shadow-sm flex flex-col items-center">
                            <div class="w-10 h-10 rounded-xl bg-emerald-500 text-white flex items-center justify-center text-sm font-black mb-2 shadow-sm">
                                <i class="bi bi-check-lg"></i>
                            </div>
                            <span class="text-[10px] font-bold text-emerald-600 dark:text-emerald-400 uppercase">Level 2</span>
                            <span class="text-xs font-extrabold text-charcoal-dark dark:text-white mt-0.5 line-clamp-1">Makna Kata & Istilah</span>
                            <span class="text-[10px] text-gray-400 mt-1">Selesai (Skor 90)</span>
                        </div>

                        {{-- Step 3 (Active) --}}
                        <div class="p-3 bg-bisa-50 dark:bg-bisa-950/40 rounded-2xl border-2 border-bisa shadow-md flex flex-col items-center animate-pulse-glow">
                            <div class="w-10 h-10 rounded-xl bg-bisa text-white flex items-center justify-center text-sm font-black mb-2 shadow-sm">
                                <i class="bi bi-play-fill text-lg"></i>
                            </div>
                            <span class="text-[10px] font-black text-bisa uppercase">Level 3</span>
                            <span class="text-xs font-black text-charcoal-dark dark:text-white mt-0.5 line-clamp-1">Simpulan Teks Argumentatif</span>
                            <span class="text-[10px] font-bold text-bisa mt-1">Sedang Berjalan</span>
                        </div>

                        {{-- Step 4 --}}
                        <div class="p-3 bg-gray-50 dark:bg-white/5 rounded-2xl border border-dashed border-gray-200 dark:border-white/10 flex flex-col items-center opacity-60">
                            <div class="w-10 h-10 rounded-xl bg-gray-100 dark:bg-white/10 text-gray-400 flex items-center justify-center text-sm font-bold mb-2">
                                <i class="bi bi-lock-fill"></i>
                            </div>
                            <span class="text-[10px] font-bold text-gray-400 uppercase">Level 4</span>
                            <span class="text-xs font-semibold text-gray-400 mt-0.5 line-clamp-1">Analisis Hubungan Antar Paragraf</span>
                            <span class="text-[10px] text-gray-400 mt-1">Terkunci</span>
                        </div>

                        {{-- Step 5 (Milestone) --}}
                        <div class="p-3 bg-gold-light/40 dark:bg-amber-950/20 rounded-2xl border border-gold/40 flex flex-col items-center opacity-80">
                            <div class="w-10 h-10 rounded-xl bg-gold text-white flex items-center justify-center text-sm font-black mb-2">
                                <i class="bi bi-trophy-fill"></i>
                            </div>
                            <span class="text-[10px] font-bold text-gold-dark dark:text-amber-400 uppercase">Tryout</span>
                            <span class="text-xs font-bold text-charcoal-dark dark:text-white mt-0.5 line-clamp-1">Tryout Akhir Literasi</span>
                            <span class="text-[10px] text-gray-400 mt-1">Milestone</span>
                        </div>
                    </div>

                    {{-- Bottom Advice Note --}}
                    <div class="mt-6 p-4 rounded-2xl bg-white dark:bg-[#1A1E27] border border-gray-100 dark:border-white/10 flex items-center gap-3">
                        <i class="bi bi-info-circle-fill text-bisa text-base"></i>
                        <span class="text-xs text-gray-600 dark:text-gray-300">
                            Setiap level menyimpan catatan pengerjaan riwayat, jumlah benar/salah, serta rekomendasi pengulangan materi jika passing score belum tercapai.
                        </span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- =========================================================================
     5. SECTION: PROGRESS BELAJAR (Student Analytics & Achievements)
========================================================================= --}}
<section class="py-20 bg-gray-50/70 dark:bg-[#11141E] transition-colors duration-200 border-y border-gray-100 dark:border-white/5">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-12 gap-12 items-center">

            {{-- Metric Card Preview --}}
            <div class="lg:col-span-7 space-y-6" data-reveal="left">
                <div class="bg-white dark:bg-[#161922] rounded-3xl p-6 sm:p-8 border border-gray-100 dark:border-white/10 shadow-lg">
                    <div class="flex items-center justify-between pb-4 mb-6 border-b border-gray-100 dark:border-white/10">
                        <div>
                            <span class="text-[11px] font-bold text-bisa uppercase tracking-wider">Dashboard Kemajuan Siswa</span>
                            <h3 class="text-lg font-extrabold text-charcoal-dark dark:text-white">Kesiapan Ujian Masuk PTN</h3>
                        </div>
                        <span class="px-3 py-1 bg-bisa-100 dark:bg-bisa-900/40 text-bisa font-black text-xs rounded-full">
                            Skor Rata-Rata: 82.4
                        </span>
                    </div>

                    {{-- Circular & Bars Progress --}}
                    <div class="grid sm:grid-cols-12 gap-6 items-center mb-6">
                        {{-- Circular Stat --}}
                        <div class="sm:col-span-5 text-center p-4 bg-gray-50 dark:bg-white/5 rounded-2xl border border-gray-100 dark:border-white/5">
                            <div class="relative w-28 h-28 mx-auto flex items-center justify-center">
                                <svg class="w-full h-full transform -rotate-90" viewBox="0 0 36 36">
                                    <path class="text-gray-200 dark:text-white/10 stroke-current" stroke-width="3.5" fill="none" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"/>
                                    <path class="text-bisa stroke-current" stroke-dasharray="74, 100" stroke-width="3.5" stroke-linecap="round" fill="none" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"/>
                                </svg>
                                <div class="absolute inset-0 flex flex-col items-center justify-center">
                                    <span class="text-2xl font-black text-charcoal-dark dark:text-white">74%</span>
                                    <span class="text-[10px] text-gray-400 font-bold uppercase">Kesiapan</span>
                                </div>
                            </div>
                            <span class="text-xs text-gray-500 dark:text-gray-400 mt-2 block font-medium">Berdasarkan 7 Subtes</span>
                        </div>

                        {{-- Breakdown Bars --}}
                        <div class="sm:col-span-7 space-y-3.5 text-xs">
                            <div>
                                <div class="flex justify-between font-bold mb-1">
                                    <span class="text-charcoal-dark dark:text-gray-200">Penalaran Umum (TPS)</span>
                                    <span class="text-bisa font-extrabold">86%</span>
                                </div>
                                <div class="w-full h-2.5 bg-gray-100 dark:bg-white/10 rounded-full overflow-hidden">
                                    <div class="h-full bg-bisa rounded-full" style="width: 86%"></div>
                                </div>
                            </div>
                            <div>
                                <div class="flex justify-between font-bold mb-1">
                                    <span class="text-charcoal-dark dark:text-gray-200">Literasi B. Indonesia & Inggris</span>
                                    <span class="text-emerald-600 dark:text-emerald-400 font-extrabold">78%</span>
                                </div>
                                <div class="w-full h-2.5 bg-gray-100 dark:bg-white/10 rounded-full overflow-hidden">
                                    <div class="h-full bg-emerald-500 rounded-full" style="width: 78%"></div>
                                </div>
                            </div>
                            <div>
                                <div class="flex justify-between font-bold mb-1">
                                    <span class="text-charcoal-dark dark:text-gray-200">Penalaran Matematika</span>
                                    <span class="text-blue-600 dark:text-blue-400 font-extrabold">64%</span>
                                </div>
                                <div class="w-full h-2.5 bg-gray-100 dark:bg-white/10 rounded-full overflow-hidden">
                                    <div class="h-full bg-blue-500 rounded-full" style="width: 64%"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Badges / Counters Grid --}}
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 pt-4 border-t border-gray-100 dark:border-white/10 text-center">
                        <div class="p-2.5 rounded-xl bg-gray-50 dark:bg-white/5">
                            <div class="text-sm font-black text-charcoal-dark dark:text-white">120+</div>
                            <span class="text-[10px] text-gray-400">Soal Dikerjakan</span>
                        </div>
                        <div class="p-2.5 rounded-xl bg-gray-50 dark:bg-white/5">
                            <div class="text-sm font-black text-purple-600 dark:text-purple-400">14 Sesi</div>
                            <span class="text-[10px] text-gray-400">Kuis Berwaktu</span>
                        </div>
                        <div class="p-2.5 rounded-xl bg-gray-50 dark:bg-white/5">
                            <div class="text-sm font-black text-amber-500">🔥 7 Hari</div>
                            <span class="text-[10px] text-gray-400">Streak Belajar</span>
                        </div>
                        <div class="p-2.5 rounded-xl bg-gray-50 dark:bg-white/5">
                            <div class="text-sm font-black text-emerald-600 dark:text-emerald-400">6 Badge</div>
                            <span class="text-[10px] text-gray-400">Achievement</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Text & Explanation --}}
            <div class="lg:col-span-5 space-y-5" data-reveal="right">
                <div class="inline-flex items-center gap-2 px-3 py-1 bg-bisa-50 dark:bg-bisa-950/40 text-bisa font-bold text-xs rounded-full uppercase tracking-wider border border-bisa/20">
                    <i class="bi bi-graph-up-arrow"></i>
                    <span>Pantau Kemajuanmu</span>
                </div>
                <h2 class="text-3xl lg:text-4xl font-extrabold text-charcoal-dark dark:text-white tracking-tight leading-tight">
                    Progress Nyata, Percaya Diri Meningkat
                </h2>
                <p class="text-sm text-gray-600 dark:text-gray-300 leading-relaxed">
                    Tidak ada lagi rasa cemas tanpa arah. Di BISA, setiap latihan, jawaban benar, dan kesalahan tercatat secara rapi. Kamu tahu persis subtes mana yang sudah kuat dan materi mana yang perlu diperdalam lagi sebelum hari H ujian.
                </p>

                <div class="space-y-3 pt-2 text-xs text-gray-600 dark:text-gray-300">
                    <div class="flex items-center gap-2.5">
                        <i class="bi bi-patch-check-fill text-bisa text-base"></i>
                        <span>Riwayat pengerjaan lengkap dengan analisis butir soal</span>
                    </div>
                    <div class="flex items-center gap-2.5">
                        <i class="bi bi-patch-check-fill text-bisa text-base"></i>
                        <span>Peringatan streak harian untuk membangun disiplin belajar</span>
                    </div>
                    <div class="flex items-center gap-2.5">
                        <i class="bi bi-patch-check-fill text-bisa text-base"></i>
                        <span>Statistik perbandingan akurasi dengan target passing grade</span>
                    </div>
                </div>

                <div class="pt-4">
                    <a href="{{ route('register') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-bisa hover:bg-bisa-dark text-white font-bold text-xs rounded-xl shadow-md shadow-bisa/25 transition">
                        <span>Buat Akun & Mulai Pantau Progresmu</span>
                        <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- =========================================================================
     6. SECTION: APA KATA MEREKA? (Testimonial Pejuang Kampus)
========================================================================= --}}
<section id="testimoni" class="py-20 bg-white dark:bg-[#0E1017] transition-colors duration-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Section Header --}}
        <div class="text-center max-w-2xl mx-auto mb-14" data-reveal>
            <div class="inline-flex items-center gap-2 px-3 py-1 bg-amber-50 dark:bg-amber-950/40 text-amber-700 dark:text-amber-300 font-bold text-xs rounded-full uppercase tracking-wider mb-3 border border-amber-200 dark:border-amber-800/40">
                <i class="bi bi-chat-quote-fill"></i>
                <span>Kisah Sukses Pejuang PTN</span>
            </div>
            <h2 class="text-3xl lg:text-4xl font-extrabold text-charcoal-dark dark:text-white tracking-tight">
                Diterima di Kampus Impian Bersama BiSA
            </h2>
            <p class="text-gray-500 dark:text-gray-400 mt-3 text-sm leading-relaxed">
                Cerita jujur dari alumni yang berhasil menaklukkan seleksi masuk perguruan tinggi negeri favorit.
            </p>
        </div>

        {{-- 3 Realistic Student Testimonials --}}
        <div class="grid md:grid-cols-3 gap-8">

            {{-- Review 1 --}}
            <div class="bg-gray-50 dark:bg-[#161922] rounded-3xl p-7 border border-gray-100 dark:border-white/10 shadow-sm hover:shadow-md transition-all flex flex-col justify-between" data-reveal>
                <div>
                    <div class="flex items-center gap-3.5 mb-5">
                        <div class="w-12 h-12 rounded-2xl bg-bisa text-white flex items-center justify-center font-black text-sm shadow-md">
                            FR
                        </div>
                        <div>
                            <div class="font-extrabold text-sm text-charcoal-dark dark:text-white">Fathur Rizky</div>
                            <div class="text-xs font-bold text-bisa">Lolos STEI-R ITB '24</div>
                            <span class="text-[10px] text-gray-400">SMAN 1 Bandung</span>
                        </div>
                    </div>
                    <p class="text-xs text-gray-600 dark:text-gray-300 leading-relaxed italic">
                        "Peta belajar BiSA bener-bener bikin nagih! Dulu paling males drill soal Penalaran Matematika, tapi karena formatnya petualangan level, aku tertantang unlock sampai level terakhir. Pas ujian aslinya format soalnya bener-bener familiar!"
                    </p>
                </div>
                <div class="flex items-center justify-between pt-5 mt-4 border-t border-gray-200/60 dark:border-white/10 text-xs">
                    <span class="text-amber-400">★★★★★</span>
                    <span class="text-[11px] text-gray-400">Alumni SNBT 2024</span>
                </div>
            </div>

            {{-- Review 2 --}}
            <div class="bg-gray-50 dark:bg-[#161922] rounded-3xl p-7 border border-gray-100 dark:border-white/10 shadow-sm hover:shadow-md transition-all flex flex-col justify-between" data-reveal>
                <div>
                    <div class="flex items-center gap-3.5 mb-5">
                        <div class="w-12 h-12 rounded-2xl bg-gold-dark text-white flex items-center justify-center font-black text-sm shadow-md">
                            NA
                        </div>
                        <div>
                            <div class="font-extrabold text-sm text-charcoal-dark dark:text-white">Nabila Azzahra</div>
                            <div class="text-xs font-bold text-gold-dark dark:text-amber-400">Lolos Pendidikan Dokter UI '24</div>
                            <span class="text-[10px] text-gray-400">SMAN 8 Jakarta</span>
                        </div>
                    </div>
                    <p class="text-xs text-gray-600 dark:text-gray-300 leading-relaxed italic">
                        "Fitur dua mode belajarnya sangat juara. Waktu konsepnya masih bingung, aku pake Mode Latihan buat baca pembahasan instan. Menjelang ujian, baru gas Mode Kuis buat ngelatih ketahanan mental dengan timer."
                    </p>
                </div>
                <div class="flex items-center justify-between pt-5 mt-4 border-t border-gray-200/60 dark:border-white/10 text-xs">
                    <span class="text-amber-400">★★★★★</span>
                    <span class="text-[11px] text-gray-400">Alumni SIMAK UI 2024</span>
                </div>
            </div>

            {{-- Review 3 --}}
            <div class="bg-gray-50 dark:bg-[#161922] rounded-3xl p-7 border border-gray-100 dark:border-white/10 shadow-sm hover:shadow-md transition-all flex flex-col justify-between" data-reveal>
                <div>
                    <div class="flex items-center gap-3.5 mb-5">
                        <div class="w-12 h-12 rounded-2xl bg-emerald-600 text-white flex items-center justify-center font-black text-sm shadow-md">
                            DP
                        </div>
                        <div>
                            <div class="font-extrabold text-sm text-charcoal-dark dark:text-white">Daffa Pratama</div>
                            <div class="text-xs font-bold text-emerald-600 dark:text-emerald-400">Lolos Manajemen UGM '24</div>
                            <span class="text-[10px] text-gray-400">SMAN 3 Yogyakarta</span>
                        </div>
                    </div>
                    <p class="text-xs text-gray-600 dark:text-gray-300 leading-relaxed italic">
                        "UI-nya clean dan gak bikin pusing, apalagi fitur dark mode-nya sangat nyaman buat belajar tengah malam. Latihan soal kompleks multi-jawaban di BiSA sangat membantu waktu nemu soal sejenis di SNBT kemarin."
                    </p>
                </div>
                <div class="flex items-center justify-between pt-5 mt-4 border-t border-gray-200/60 dark:border-white/10 text-xs">
                    <span class="text-amber-400">★★★★★</span>
                    <span class="text-[11px] text-gray-400">Alumni SNBT 2024</span>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- =========================================================================
     7. SECTION: TENTANG BISA (Pedagogical Pillars & Mission)
========================================================================= --}}
<section id="tentang" class="py-20 bg-gray-50/70 dark:bg-[#11141E] transition-colors duration-200 border-t border-gray-100 dark:border-white/5">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-12 gap-12 items-center">

            <div class="lg:col-span-6 space-y-6" data-reveal="left">
                <div class="inline-flex items-center gap-2 px-3 py-1 bg-bisa-50 dark:bg-bisa-950/40 text-bisa font-bold text-xs rounded-full uppercase tracking-wider border border-bisa/20">
                    <i class="bi bi-mortarboard-fill"></i>
                    <span>Filosofi & Pilar BISA</span>
                </div>
                <h2 class="text-3xl lg:text-4xl font-extrabold text-charcoal-dark dark:text-white tracking-tight leading-tight">
                    Belajar Intensif dan Simulasi Akademik
                </h2>
                <p class="text-sm text-gray-600 dark:text-gray-300 leading-relaxed">
                    <strong>BISA</strong> lahir dari kegelisahan bahwa persiapan masuk perguruan tinggi sering kali membosankan, menakutkan, dan terasa tidak terjangkau. Kami merancang platform ini dengan memadukan keketatan akademik dan petualangan gamifikasi modern, agar setiap pelajar di seluruh pelosok Indonesia memiliki peluang yang sama menembus universitas impian mereka.
                </p>

                <div class="grid sm:grid-cols-2 gap-4 pt-2">
                    <div class="p-4 rounded-2xl bg-white dark:bg-[#161922] border border-gray-100 dark:border-white/10 shadow-sm">
                        <i class="bi bi-shield-check text-bisa text-xl block mb-2"></i>
                        <h4 class="text-xs font-bold text-charcoal-dark dark:text-white mb-1">Kurikulum Mutakhir</h4>
                        <p class="text-[11px] text-gray-500 dark:text-gray-400 leading-relaxed">Diselaraskan dengan tren silabus resmi BPPP dan SNPMB terkini.</p>
                    </div>
                    <div class="p-4 rounded-2xl bg-white dark:bg-[#161922] border border-gray-100 dark:border-white/10 shadow-sm">
                        <i class="bi bi-controller text-bisa text-xl block mb-2"></i>
                        <h4 class="text-xs font-bold text-charcoal-dark dark:text-white mb-1">Gamifikasi Seimbang</h4>
                        <p class="text-[11px] text-gray-500 dark:text-gray-400 leading-relaxed">Motivasi belajar terjaga tinggi tanpa mengurangi kedalaman akademis.</p>
                    </div>
                    <div class="p-4 rounded-2xl bg-white dark:bg-[#161922] border border-gray-100 dark:border-white/10 shadow-sm">
                        <i class="bi bi-lightbulb text-bisa text-xl block mb-2"></i>
                        <h4 class="text-xs font-bold text-charcoal-dark dark:text-white mb-1">Pembahasan Solutif</h4>
                        <p class="text-[11px] text-gray-500 dark:text-gray-400 leading-relaxed">Menjelaskan alur logika berpikir, bukan sekadar kunci jawaban.</p>
                    </div>
                    <div class="p-4 rounded-2xl bg-white dark:bg-[#161922] border border-gray-100 dark:border-white/10 shadow-sm">
                        <i class="bi bi-people text-bisa text-xl block mb-2"></i>
                        <h4 class="text-xs font-bold text-charcoal-dark dark:text-white mb-1">Inklusif & Mudah Diakses</h4>
                        <p class="text-[11px] text-gray-500 dark:text-gray-400 leading-relaxed">Bisa diakses nyaman lewat laptop maupun smartphone.</p>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-6" data-reveal="right">
                <div class="relative bg-white dark:bg-[#161922] rounded-3xl p-8 border border-gray-100 dark:border-white/10 shadow-xl text-center">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo BISA" class="h-20 mx-auto mb-6 dark:brightness-110">
                    <h3 class="text-lg font-black text-charcoal-dark dark:text-white mb-2">
                        Siap Memulai Langkah Pertamamu?
                    </h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400 max-w-md mx-auto leading-relaxed mb-6">
                        Pintu masuk universitas impian dibuka oleh mereka yang memulai persiapan lebih awal dan konsisten setiap harinya.
                    </p>
                    <div class="flex items-center justify-center gap-4">
                        <a href="{{ route('register') }}" class="px-6 py-3 bg-bisa hover:bg-bisa-dark text-white font-extrabold text-xs rounded-xl shadow-md transition">
                            Daftar Akun Siswa Sekarang
                        </a>
                        <a href="{{ route('login') }}" class="px-6 py-3 bg-gray-100 dark:bg-white/10 text-charcoal-dark dark:text-white font-bold text-xs rounded-xl hover:bg-gray-200 dark:hover:bg-white/20 transition">
                            Masuk
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- =========================================================================
     8. SECTION: FINAL CTA BANNER (High Energy & Academic Stickers)
========================================================================= --}}
<section class="py-20 bg-gradient-to-br from-bisa-50 via-white to-gold-light/40 dark:from-[#0B0D13] dark:via-[#11141E] dark:to-[#171B26] transition-colors duration-200">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center" data-reveal>
        {{-- Floating Academic Badges around CTA --}}
        <div class="inline-flex items-center gap-2 px-4 py-1.5 bg-bisa-100 dark:bg-bisa-900/40 text-bisa-800 dark:text-bisa-300 rounded-full text-xs font-bold uppercase tracking-wider mb-6 border border-bisa/20">
            <i class="bi bi-rocket-takeoff-fill text-bisa"></i>
            <span>Mulai Perjalanan Akademikmu Hari Ini</span>
        </div>

        <h2 class="text-3xl sm:text-4xl lg:text-5xl font-black text-charcoal-dark dark:text-white mb-5 tracking-tight">
            Sudah Siap Melangkah ke Kampus Impian?
        </h2>

        <p class="text-sm sm:text-base text-gray-600 dark:text-gray-300 mb-8 max-w-2xl mx-auto leading-relaxed">
            Bergabunglah bersama ribuan pejuang PTN lainnya di platform <strong>BISA</strong>. Akses ratusan modul, peta belajar bertahap, dan simulasi kuis gratis tanpa syarat rumit.
        </p>

        <div class="flex flex-wrap items-center justify-center gap-4">
            <a href="{{ route('register') }}"
               class="inline-flex items-center gap-2.5 px-8 py-4 bg-bisa hover:bg-bisa-dark text-white font-extrabold text-sm sm:text-base rounded-2xl shadow-xl shadow-bisa/30 hover:shadow-2xl hover:shadow-bisa/40 transition-all transform hover:-translate-y-0.5 active:translate-y-0">
                <span>Daftar Akun Siswa Gratis</span>
                <i class="bi bi-arrow-right font-black"></i>
            </a>
            <a href="{{ route('login') }}"
               class="inline-flex items-center gap-2 px-7 py-4 bg-white dark:bg-[#1A1E27] border-2 border-gray-200 dark:border-white/10 text-charcoal-dark dark:text-gray-200 font-bold text-sm sm:text-base rounded-2xl hover:border-bisa hover:text-bisa transition shadow-sm">
                <span>Sudah Punya Akun? Masuk</span>
            </a>
        </div>

        <div class="text-xs text-gray-400 dark:text-gray-500 mt-5 flex items-center justify-center gap-2">
            <i class="bi bi-shield-lock-fill"></i>
            <span>Daftar cepat dengan email • Langsung akses peta belajar hari ini</span>
        </div>
    </div>
</section>

@endsection

@push('scripts')
{{-- Scroll-Triggered Entrance Observer for Smooth Reveal --}}
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const revealElements = document.querySelectorAll('[data-reveal]');
        if ('IntersectionObserver' in window) {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('revealed');
                        observer.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.12,
                rootMargin: '0px 0px -40px 0px'
            });

            revealElements.forEach(el => observer.observe(el));
        } else {
            // Fallback for older browsers
            revealElements.forEach(el => el.classList.add('revealed'));
        }
    });
</script>
@endpush
