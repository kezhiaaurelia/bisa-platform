@extends('layouts.app')

@section('title', 'Pusat Bantuan & Komunitas — BISA')

@section('content')
<div class="bg-gray-50 dark:bg-[#0E1017] min-h-screen py-10 transition-colors duration-200">
    <div class="max-w-4xl mx-auto px-4 sm:px-6">

        {{-- Top Card --}}
        <div class="bg-white dark:bg-[#161922] rounded-3xl p-6 sm:p-8 border border-gray-100 dark:border-white/10 shadow-sm mb-8 animate-fade-in-down">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-blue-100 dark:bg-blue-950/40 text-blue-800 dark:text-blue-300 rounded-full text-xs font-black uppercase tracking-wider mb-2">
                <i class="bi bi-question-circle-fill text-blue-600"></i> Pusat Informasi & Bantuan
            </span>
            <h1 class="text-2xl sm:text-3xl font-black text-charcoal-dark dark:text-white">
                Ada yang Bisa Kami Bantu?
            </h1>
            <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-1 max-w-2xl leading-relaxed">
                Temukan jawaban seputar teknis simulasi tryout, materi belajar, atau hubungi langsung admin akademik via WhatsApp.
            </p>

            <div class="mt-6 flex flex-wrap items-center gap-3">
                <a href="https://wa.me/6281234567890?text=Halo%20Admin%20BISA,%20saya%20butuh%20bantuan%20seputar%20platform" target="_blank" class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-xs rounded-xl shadow-md transition flex items-center gap-2">
                    <i class="bi bi-whatsapp text-sm"></i>
                    <span>Chat WhatsApp Admin BISA</span>
                </a>
                <a href="https://chat.whatsapp.com/sample-bisa-komunitas" target="_blank" class="px-5 py-2.5 bg-white dark:bg-white/10 border border-gray-200 dark:border-white/10 text-charcoal-dark dark:text-white font-bold text-xs rounded-xl hover:border-bisa transition flex items-center gap-2">
                    <i class="bi bi-people-fill text-bisa"></i>
                    <span>Gabung Komunitas Pejuang PTN</span>
                </a>
            </div>
        </div>

        {{-- FAQ Accordion --}}
        <div class="bg-white dark:bg-[#161922] rounded-3xl p-6 sm:p-8 border border-gray-100 dark:border-white/10 shadow-sm mb-8 animate-fade-in-up">
            <h2 class="text-base font-extrabold text-charcoal-dark dark:text-white mb-6 flex items-center gap-2">
                <i class="bi bi-patch-question-fill text-bisa"></i>
                <span>Pertanyaan yang Sering Diajukan (FAQ)</span>
            </h2>

            <div class="space-y-4 text-xs" x-data="{ active: null }">
                <div class="p-4 rounded-2xl bg-gray-50 dark:bg-white/5 border border-gray-100 dark:border-white/5">
                    <button type="button" @click="active = active === 1 ? null : 1" class="w-full flex items-center justify-between font-bold text-charcoal-dark dark:text-white text-left">
                        <span>Bagaimana sistem penilaian skor di Tryout BISA?</span>
                        <i class="bi" :class="active === 1 ? 'bi-chevron-up' : 'bi-chevron-down'"></i>
                    </button>
                    <div x-show="active === 1" x-cloak class="mt-2 text-gray-500 dark:text-gray-400 leading-relaxed pt-2 border-t border-gray-200/50 dark:border-white/5">
                        BISA mengadopsi sistem pembobotan <em>Item Response Theory (IRT)</em> mirip panitia SNPMB resmi, di mana butir soal yang jarang dijawab benar oleh peserta lain akan bernilai bobot poin lebih tinggi dibanding soal mudah.
                    </div>
                </div>

                <div class="p-4 rounded-2xl bg-gray-50 dark:bg-white/5 border border-gray-100 dark:border-white/5">
                    <button type="button" @click="active = active === 2 ? null : 2" class="w-full flex items-center justify-between font-bold text-charcoal-dark dark:text-white text-left">
                        <span>Apa perbedaan Mode Latihan dan Mode Kuis?</span>
                        <i class="bi" :class="active === 2 ? 'bi-chevron-up' : 'bi-chevron-down'"></i>
                    </button>
                    <div x-show="active === 2" x-cloak class="mt-2 text-gray-500 dark:text-gray-400 leading-relaxed pt-2 border-t border-gray-200/50 dark:border-white/5">
                        Mode Latihan santai tanpa batas waktu dengan pembahasan yang dapat dibuka seketika. Sedangkan Mode Kuis memiliki hitungan mundur waktu nyata dengan feedback benar/salah yang disembunyikan sampai sesi kuis selesai.
                    </div>
                </div>

                <div class="p-4 rounded-2xl bg-gray-50 dark:bg-white/5 border border-gray-100 dark:border-white/5">
                    <button type="button" @click="active = active === 3 ? null : 3" class="w-full flex items-center justify-between font-bold text-charcoal-dark dark:text-white text-left">
                        <span>Apakah fitur KakAI Tutor AI bisa diakses lewat smartphone?</span>
                        <i class="bi" :class="active === 3 ? 'bi-chevron-up' : 'bi-chevron-down'"></i>
                    </button>
                    <div x-show="active === 3" x-cloak class="mt-2 text-gray-500 dark:text-gray-400 leading-relaxed pt-2 border-t border-gray-200/50 dark:border-white/5">
                        Ya, seluruh platform BISA dioptimalkan responsif untuk perangkat ponsel, tablet, maupun laptop sehingga kamu bisa berkonsultasi dengan KakAI kapan saja dan di mana saja.
                    </div>
                </div>
            </div>
        </div>

        {{-- Ticket / Feedback Form --}}
        <div class="bg-white dark:bg-[#161922] rounded-3xl p-6 sm:p-8 border border-gray-100 dark:border-white/10 shadow-sm animate-fade-in-up">
            <h2 class="text-base font-extrabold text-charcoal-dark dark:text-white mb-4 flex items-center gap-2">
                <i class="bi bi-chat-left-dots-fill text-bisa"></i>
                <span>Kirim Tiket Laporan / Pertanyaan ke Admin</span>
            </h2>

            <form action="{{ route('support.store') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label for="subject" class="block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300 mb-1">
                        Subjek Pertanyaan / Laporan
                    </label>
                    <input type="text"
                           name="subject"
                           id="subject"
                           required
                           placeholder="Contoh: Laporan Kunci Soal No. 12 Subtes Kuantitatif"
                           class="w-full px-4 py-3 rounded-2xl border border-gray-200 dark:border-white/10 bg-gray-50 dark:bg-white/5 text-xs text-charcoal-dark dark:text-white focus:outline-none focus:border-bisa">
                </div>

                <div>
                    <label for="message" class="block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300 mb-1">
                        Detail Pesan
                    </label>
                    <textarea name="message"
                              id="message"
                              rows="3"
                              required
                              placeholder="Tuliskan kendala atau pertanyaanmu dengan rinci..."
                              class="w-full px-4 py-3 rounded-2xl border border-gray-200 dark:border-white/10 bg-gray-50 dark:bg-white/5 text-xs text-charcoal-dark dark:text-white focus:outline-none focus:border-bisa"></textarea>
                </div>

                <button type="submit" class="py-3 px-6 bg-charcoal-dark text-white font-bold text-xs rounded-xl hover:bg-black transition">
                    Kirim Tiket Bantuan
                </button>
            </form>
        </div>

    </div>
</div>
@endsection

