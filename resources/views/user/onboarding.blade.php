@extends('layouts.app')

@section('title', 'Atur Target Belajar PTN — BISA')

@section('content')
<div class="min-h-screen py-12 bg-gradient-to-br from-bisa-50/60 via-white to-gold-light/30 dark:from-[#0B0D13] dark:via-[#11141E] dark:to-[#171B26] transition-colors duration-200">
    <div class="max-w-2xl mx-auto px-4 sm:px-6">

        {{-- Header Card --}}
        <div class="text-center mb-8 animate-fade-in-down">
            <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full text-xs font-black uppercase tracking-wider bg-bisa-100 dark:bg-bisa-900/40 text-bisa-800 dark:text-bisa-300 border border-bisa/20 mb-3">
                <i class="bi bi-compass-fill text-bisa"></i> Onboarding Pejuang Kampus
            </span>
            <h1 class="text-3xl font-black text-charcoal-dark dark:text-white">
                Tentukan Target Perguruan Tinggi Impianmu
            </h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-2 max-w-lg mx-auto">
                Bantu BISA menyusun peta belajar, rekomendasi materi, dan target passing grade yang presisi untukmu.
            </p>
        </div>

        {{-- Form Box --}}
        <div class="bg-white dark:bg-[#161922] rounded-3xl p-6 sm:p-10 border border-gray-100 dark:border-white/10 shadow-xl animate-fade-in-up">
            <form action="{{ route('onboarding.store') }}" method="POST" class="space-y-6">
                @csrf

                {{-- Jalur Masuk Pilihan --}}
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-charcoal-dark dark:text-gray-200 mb-2">
                        1. Jalur Seleksi Utama Targetmu <span class="text-danger">*</span>
                    </label>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <label class="relative flex flex-col p-4 rounded-2xl border-2 cursor-pointer transition text-center hover:border-bisa has-checked:border-bisa has-checked:bg-bisa-50/50 dark:has-checked:bg-bisa-950/25">
                            <input type="radio" name="target_path" value="snbt" class="sr-only" checked>
                            <span class="text-xl mb-1">🎯</span>
                            <span class="text-xs font-extrabold text-charcoal-dark dark:text-white">SNBT / UTBK</span>
                            <span class="text-[10px] text-gray-400 mt-0.5">Jalur Nasional Tes</span>
                        </label>

                        <label class="relative flex flex-col p-4 rounded-2xl border-2 cursor-pointer transition text-center hover:border-bisa has-checked:border-bisa has-checked:bg-bisa-50/50 dark:has-checked:bg-bisa-950/25">
                            <input type="radio" name="target_path" value="tka" class="sr-only">
                            <span class="text-xl mb-1">📚</span>
                            <span class="text-xs font-extrabold text-charcoal-dark dark:text-white">TKA Mandiri</span>
                            <span class="text-[10px] text-gray-400 mt-0.5">SIMAK / UTUL / SMUP</span>
                        </label>

                        <label class="relative flex flex-col p-4 rounded-2xl border-2 cursor-pointer transition text-center hover:border-bisa has-checked:border-bisa has-checked:bg-bisa-50/50 dark:has-checked:bg-bisa-950/25">
                            <input type="radio" name="target_path" value="mandiri" class="sr-only">
                            <span class="text-xl mb-1">🏆</span>
                            <span class="text-xs font-extrabold text-charcoal-dark dark:text-white">Kedinasan & Lainnya</span>
                            <span class="text-[10px] text-gray-400 mt-0.5">STAN, STIS, Poltek</span>
                        </label>
                    </div>
                </div>

                {{-- Target PTN --}}
                <div>
                    <label for="target_ptn" class="block text-xs font-bold uppercase tracking-wider text-charcoal-dark dark:text-gray-200 mb-1.5">
                        2. Perguruan Tinggi Negeri (PTN) Impian <span class="text-danger">*</span>
                    </label>
                    <input type="text"
                           id="target_ptn"
                           name="target_ptn"
                           required
                           list="ptn-list"
                           value="{{ old('target_ptn', $user->target_ptn) }}"
                           placeholder="Contoh: Institut Teknologi Bandung (ITB)"
                           class="w-full px-4 py-3 rounded-2xl border border-gray-200 dark:border-white/10 bg-gray-50 dark:bg-white/5 text-sm text-charcoal-dark dark:text-white focus:outline-none focus:border-bisa focus:ring-2 focus:ring-bisa/20 transition">
                    <datalist id="ptn-list">
                        <option value="Universitas Indonesia (UI)">
                        <option value="Institut Teknologi Bandung (ITB)">
                        <option value="Universitas Gadjah Mada (UGM)">
                        <option value="Universitas Airlangga (UNAIR)">
                        <option value="Universitas Diponegoro (UNDIP)">
                        <option value="Institut Pertanian Bogor (IPB)">
                        <option value="Institut Teknologi Sepuluh Nopember (ITS)">
                        <option value="Universitas Padjadjaran (UNPAD)">
                        <option value="Universitas Brawijaya (UB)">
                        <option value="Universitas Sebelas Maret (UNS)">
                        <option value="Universitas Sumatera Utara (USU)">
                        <option value="Universitas Hasanuddin (UNHAS)">
                    </datalist>
                </div>

                {{-- Target Program Studi / Jurusan --}}
                <div>
                    <label for="target_major" class="block text-xs font-bold uppercase tracking-wider text-charcoal-dark dark:text-gray-200 mb-1.5">
                        3. Program Studi / Jurusan Tujuan <span class="text-danger">*</span>
                    </label>
                    <input type="text"
                           id="target_major"
                           name="target_major"
                           required
                           list="major-list"
                           value="{{ old('target_major', $user->target_major) }}"
                           placeholder="Contoh: Teknik Informatika / Kedokteran"
                           class="w-full px-4 py-3 rounded-2xl border border-gray-200 dark:border-white/10 bg-gray-50 dark:bg-white/5 text-sm text-charcoal-dark dark:text-white focus:outline-none focus:border-bisa focus:ring-2 focus:ring-bisa/20 transition">
                    <datalist id="major-list">
                        <option value="Pendidikan Dokter">
                        <option value="Teknik Informatika / Ilmu Komputer">
                        <option value="Manajemen / Bisnis">
                        <option value="Ilmu Hukum">
                        <option value="Farmasi">
                        <option value="Akuntansi">
                        <option value="Psikologi">
                        <option value="Teknik Elektro">
                        <option value="Teknik Sipil">
                        <option value="Hubungan Internasional">
                        <option value="Teknik Industri">
                    </datalist>
                </div>

                {{-- Nomor WhatsApp (Opsional) --}}
                <div>
                    <label for="phone" class="block text-xs font-bold uppercase tracking-wider text-charcoal-dark dark:text-gray-200 mb-1.5">
                        4. Nomor WhatsApp Siswa <span class="text-gray-400 text-[10px] lowercase">(opsional untuk reminder kuis)</span>
                    </label>
                    <input type="tel"
                           id="phone"
                           name="phone"
                           value="{{ old('phone', $user->phone) }}"
                           placeholder="081234567890"
                           class="w-full px-4 py-3 rounded-2xl border border-gray-200 dark:border-white/10 bg-gray-50 dark:bg-white/5 text-sm text-charcoal-dark dark:text-white focus:outline-none focus:border-bisa focus:ring-2 focus:ring-bisa/20 transition">
                </div>

                <div class="pt-4">
                    <button type="submit"
                            class="w-full py-4 px-6 bg-bisa hover:bg-bisa-dark text-white font-extrabold text-sm rounded-2xl shadow-lg shadow-bisa/25 transition transform hover:-translate-y-0.5 active:translate-y-0 flex items-center justify-center gap-2">
                        <span>Simpan & Buka Dashboard Belajar</span>
                        <i class="bi bi-arrow-right"></i>
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>
@endsection

