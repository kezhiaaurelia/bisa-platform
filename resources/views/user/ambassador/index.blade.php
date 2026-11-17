@extends('layouts.app')

@section('title', 'Program Ambassador & Komunitas — BISA')

@section('content')
<div class="bg-gray-50 dark:bg-[#0E1017] min-h-screen py-10 transition-colors duration-200">
    <div class="max-w-4xl mx-auto px-4 sm:px-6">

        {{-- Top Card --}}
        <div class="bg-white dark:bg-[#161922] rounded-3xl p-6 sm:p-8 border border-gray-100 dark:border-white/10 shadow-sm mb-8 animate-fade-in-down">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-amber-100 dark:bg-amber-950/40 text-amber-800 dark:text-amber-300 rounded-full text-xs font-black uppercase tracking-wider mb-2">
                <i class="bi bi-megaphone-fill text-bisa"></i> Program Student Ambassador
            </span>
            <h1 class="text-2xl sm:text-3xl font-black text-charcoal-dark dark:text-white">
                Jadilah Duta Pelajar BISA di Sekolahmu
            </h1>
            <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-1 max-w-2xl leading-relaxed">
                Ajak teman-teman sekolahmu mempersiapkan ujian masuk PTN dengan lebih terarah. Dapatkan sertifikat nasional, akses akun VIP gratis, dan insentif menarik!
            </p>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 rounded-2xl bg-emerald-50 dark:bg-emerald-950/40 text-emerald-800 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800/40 text-xs font-bold animate-fade-in-down flex items-center gap-2">
                <i class="bi bi-check-circle-fill"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if($application && $application->status === 'approved')
            {{-- Ambassador Active Dashboard --}}
            <div class="bg-gradient-to-br from-bisa to-amber-600 text-white rounded-3xl p-6 sm:p-8 shadow-xl mb-8 animate-scale-in">
                <div class="flex items-center justify-between pb-4 border-b border-white/20 mb-4">
                    <span class="text-xs font-bold uppercase tracking-wider">Status: Duta Pelajar Aktif ✓</span>
                    <span class="text-xs bg-white/20 px-3 py-1 rounded-full font-bold">Terverifikasi</span>
                </div>

                <div class="grid sm:grid-cols-2 gap-6 items-center">
                    <div>
                        <span class="text-xs text-white/80 block mb-1">Kode Referral Ajakanmu:</span>
                        <div class="inline-flex items-center gap-3 bg-white text-bisa px-5 py-2.5 rounded-2xl font-black text-lg tracking-wider shadow">
                            <span>{{ $application->referral_code }}</span>
                            <button type="button" onclick="navigator.clipboard.writeText('{{ $application->referral_code }}'); alert('Kode disalin!');" class="text-xs text-gray-400 hover:text-bisa">
                                <i class="bi bi-copy"></i>
                            </button>
                        </div>
                        <p class="text-[11px] text-white/80 mt-2">
                            Bagikan kode ini kepada teman sekelasmu untuk mendapatkan potongan tryout & reward!
                        </p>
                    </div>

                    <div class="bg-white/10 rounded-2xl p-4 text-center backdrop-blur-sm">
                        <div class="text-3xl font-black">{{ $application->total_referrals }}</div>
                        <span class="text-xs font-semibold text-white/90">Siswa Telah Bergabung Lewat Kode Kamu</span>
                    </div>
                </div>
            </div>
        @else
            {{-- Registration Form --}}
            <div class="bg-white dark:bg-[#161922] rounded-3xl p-6 sm:p-8 border border-gray-100 dark:border-white/10 shadow-sm animate-fade-in-up">
                <h2 class="text-base font-extrabold text-charcoal-dark dark:text-white mb-6 flex items-center gap-2">
                    <i class="bi bi-person-plus-fill text-bisa"></i>
                    <span>Formulir Pendaftaran Duta Pelajar</span>
                </h2>

                <form action="{{ route('ambassador.apply') }}" method="POST" class="space-y-5">
                    @csrf

                    <div>
                        <label for="school_name" class="block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300 mb-1.5">
                            Asal Sekolah (SMA / SMK / MA) <span class="text-danger">*</span>
                        </label>
                        <input type="text"
                               name="school_name"
                               id="school_name"
                               required
                               placeholder="Contoh: SMAN 1 Bandung"
                               class="w-full px-4 py-3 rounded-2xl border border-gray-200 dark:border-white/10 bg-gray-50 dark:bg-white/5 text-sm text-charcoal-dark dark:text-white focus:outline-none focus:border-bisa">
                    </div>

                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <label for="instagram_handle" class="block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300 mb-1.5">
                                Akun Instagram <span class="text-gray-400 lowercase text-[10px]">(opsional)</span>
                            </label>
                            <input type="text"
                                   name="instagram_handle"
                                   id="instagram_handle"
                                   placeholder="@username"
                                   class="w-full px-4 py-3 rounded-2xl border border-gray-200 dark:border-white/10 bg-gray-50 dark:bg-white/5 text-sm text-charcoal-dark dark:text-white focus:outline-none focus:border-bisa">
                        </div>

                        <div>
                            <label for="tiktok_handle" class="block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300 mb-1.5">
                                Akun TikTok <span class="text-gray-400 lowercase text-[10px]">(opsional)</span>
                            </label>
                            <input type="text"
                                   name="tiktok_handle"
                                   id="tiktok_handle"
                                   placeholder="@username"
                                   class="w-full px-4 py-3 rounded-2xl border border-gray-200 dark:border-white/10 bg-gray-50 dark:bg-white/5 text-sm text-charcoal-dark dark:text-white focus:outline-none focus:border-bisa">
                        </div>
                    </div>

                    <div>
                        <label for="motivation" class="block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300 mb-1.5">
                            Alasan Ingin Menjadi Duta Pelajar BISA <span class="text-danger">*</span>
                        </label>
                        <textarea name="motivation"
                                  id="motivation"
                                  rows="3"
                                  required
                                  placeholder="Ceritakan rencanamu untuk mengajak teman-teman sekolahmu belajar bersama..."
                                  class="w-full px-4 py-3 rounded-2xl border border-gray-200 dark:border-white/10 bg-gray-50 dark:bg-white/5 text-sm text-charcoal-dark dark:text-white focus:outline-none focus:border-bisa"></textarea>
                    </div>

                    <button type="submit"
                            class="w-full py-3.5 bg-bisa hover:bg-bisa-dark text-white font-extrabold text-xs rounded-xl shadow-md transition flex items-center justify-center gap-2">
                        <i class="bi bi-send-fill"></i>
                        <span>Kirim Pendaftaran Duta Pelajar</span>
                    </button>
                </form>
            </div>
        @endif

    </div>
</div>
@endsection

