@extends('layouts.app')

@section('title', 'Paket Belajar & Keanggotaan Premium — BISA')

@section('content')
<div class="bg-gradient-to-b from-bisa-50/60 via-white to-gray-50 dark:from-[#0E1017] dark:via-[#121520] dark:to-[#0B0D13] min-h-screen py-14 transition-colors duration-200">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Heading --}}
        <div class="text-center max-w-2xl mx-auto mb-14 animate-fade-in-down">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-gold/20 text-gold-dark dark:text-amber-300 rounded-full text-xs font-black uppercase tracking-wider mb-2 border border-gold/40">
                <i class="bi bi-star-fill text-amber-500"></i> Investasi Masa Depan Akademikmu
            </span>
            <h1 class="text-3xl sm:text-4xl font-black text-charcoal-dark dark:text-white">
                Pilih Paket Belajar Pejuang PTN
            </h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-2 leading-relaxed">
                Biaya terjangkau untuk seluruh siswa se-Indonesia. Buka akses penuh bank soal ribuan nomor, simulasi tryout berkala, dan tutor AI tanpa batas.
            </p>
        </div>

        {{-- Pricing Cards Grid --}}
        <div class="grid md:grid-cols-2 gap-8 max-w-4xl mx-auto mb-16 animate-fade-in-up">

            {{-- 1. Free Tier --}}
            <div class="bg-white dark:bg-[#161922] rounded-3xl p-8 border border-gray-200 dark:border-white/10 shadow-sm flex flex-col justify-between">
                <div>
                    <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase bg-gray-100 dark:bg-white/10 text-gray-600 dark:text-gray-300">
                        Akses Siswa
                    </span>
                    <h3 class="text-2xl font-black text-charcoal-dark dark:text-white mt-3 mb-1">Paket Gratis</h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-6">Mulai pemahaman dasar tanpa biaya sepeser pun.</p>

                    <div class="text-3xl font-black text-charcoal-dark dark:text-white mb-6">
                        Rp 0 <span class="text-xs font-normal text-gray-400">/ selamanya</span>
                    </div>

                    <div class="space-y-3 text-xs text-gray-600 dark:text-gray-300">
                        <div class="flex items-center gap-2.5">
                            <i class="bi bi-check-circle-fill text-emerald-500"></i>
                            <span>Akses Peta Belajar Level 1 - 3</span>
                        </div>
                        <div class="flex items-center gap-2.5">
                            <i class="bi bi-check-circle-fill text-emerald-500"></i>
                            <span>Mode Latihan 100+ Soal Dasar</span>
                        </div>
                        <div class="flex items-center gap-2.5">
                            <i class="bi bi-check-circle-fill text-emerald-500"></i>
                            <span>Kuis Berwaktu Subtes TPS</span>
                        </div>
                        <div class="flex items-center gap-2.5 text-gray-400">
                            <i class="bi bi-x-circle text-gray-300"></i>
                            <span>Tryout Akbar IRT Nasional Berkala</span>
                        </div>
                        <div class="flex items-center gap-2.5 text-gray-400">
                            <i class="bi bi-x-circle text-gray-300"></i>
                            <span>Akses Sesi Bimbingan Kelas Live</span>
                        </div>
                    </div>
                </div>

                <div class="pt-8 mt-6 border-t border-gray-100 dark:border-white/10">
                    <a href="{{ route('dashboard') }}" class="w-full py-3 bg-gray-100 dark:bg-white/10 hover:bg-gray-200 dark:hover:bg-white/20 text-charcoal-dark dark:text-white font-bold text-xs rounded-xl transition flex items-center justify-center">
                        Sudah Aktif di Akunmu
                    </a>
                </div>
            </div>

            {{-- 2. Premium Pejuang PTN (Featured) --}}
            <div class="bg-white dark:bg-[#161922] rounded-3xl p-8 border-2 border-bisa dark:border-bisa shadow-2xl relative flex flex-col justify-between ring-4 ring-bisa/15 transform md:-translate-y-2">
                <div class="absolute -top-3.5 right-6 px-3.5 py-1 bg-gradient-to-r from-bisa to-amber-500 text-white rounded-full text-[10px] font-black uppercase tracking-wider shadow-md">
                    Paling Direkomendasikan 🔥
                </div>

                <div>
                    <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase bg-bisa-100 dark:bg-bisa-900/40 text-bisa-800 dark:text-bisa-300">
                        Full Access VIP
                    </span>
                    <h3 class="text-2xl font-black text-charcoal-dark dark:text-white mt-3 mb-1">Pejuang PTN Premium</h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-6">Persiapan intensif tembus prodi impian pilihan ke-1.</p>

                    <div class="text-3xl font-black text-bisa mb-6">
                        Rp 49.000 <span class="text-xs font-normal text-gray-400">/ 3 bulan akses</span>
                    </div>

                    <div class="space-y-3 text-xs text-gray-700 dark:text-gray-200 font-medium">
                        <div class="flex items-center gap-2.5">
                            <i class="bi bi-check-circle-fill text-bisa text-sm"></i>
                            <span>Seluruh Peta Belajar Level (Materi Dasar s.d HOTS)</span>
                        </div>
                        <div class="flex items-center gap-2.5">
                            <i class="bi bi-check-circle-fill text-bisa text-sm"></i>
                            <span>Akses Seluruh Event Tryout Nasional Berbobot IRT</span>
                        </div>
                        <div class="flex items-center gap-2.5">
                            <i class="bi bi-check-circle-fill text-bisa text-sm"></i>
                            <span>Konsultasi KakAI Tutor AI 24/7 Tanpa Batas</span>
                        </div>
                        <div class="flex items-center gap-2.5">
                            <i class="bi bi-check-circle-fill text-bisa text-sm"></i>
                            <span>Ikuti Seluruh Sesi Bimbingan Kelas Live & Rekaman</span>
                        </div>
                        <div class="flex items-center gap-2.5">
                            <i class="bi bi-check-circle-fill text-bisa text-sm"></i>
                            <span>Unduh Modul Rumus Cepat & Ringkasan Bab</span>
                        </div>
                    </div>
                </div>

                {{-- Checkout Form --}}
                <div class="pt-8 mt-6 border-t border-gray-100 dark:border-white/10">
                    <form action="{{ route('pricing.checkout') }}" method="POST">
                        @csrf
                        <input type="hidden" name="plan_name" value="Pejuang PTN Premium (3 Bulan)">
                        <input type="hidden" name="amount" value="49000">
                        <input type="hidden" name="payment_method" value="QRIS / Instant">

                        <button type="submit"
                                class="w-full py-3.5 bg-bisa hover:bg-bisa-dark text-white font-extrabold text-xs rounded-xl shadow-lg shadow-bisa/30 transition flex items-center justify-center gap-2">
                            <i class="bi bi-lightning-charge-fill"></i>
                            <span>Aktifkan Paket Premium Sekarang</span>
                        </button>
                    </form>
                    <span class="text-[10px] text-gray-400 text-center block mt-2">Aktivasi otomatis instan dalam hitungan detik</span>
                </div>
            </div>

        </div>

    </div>
</div>
@endsection

