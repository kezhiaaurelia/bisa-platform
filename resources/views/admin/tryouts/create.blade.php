@extends('layouts.admin')

@section('title', 'Buat Event Tryout Baru — Admin BISA')

@section('content')
<div class="max-w-3xl mx-auto space-y-6 animate-fade-in-up">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-black text-charcoal-dark dark:text-white">Buat Event Tryout Baru</h1>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Konfigurasi jadwal, format waktu, dan status pembobotan IRT.</p>
        </div>
        <a href="{{ route('admin.tryout-events.index') }}" class="text-xs font-bold text-gray-500 hover:text-bisa">← Kembali</a>
    </div>

    <div class="bg-white dark:bg-[#161922] rounded-3xl p-6 sm:p-8 border border-gray-200/80 dark:border-white/10 shadow-sm">
        <form action="{{ route('admin.tryout-events.store') }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <label for="title" class="block text-xs font-bold uppercase tracking-wider text-charcoal-dark dark:text-gray-200 mb-1.5">
                    Nama Event Tryout <span class="text-danger">*</span>
                </label>
                <input type="text" name="title" id="title" required placeholder="Contoh: Tryout Akbar SNBT Nasional 2025 #2" class="w-full px-4 py-3 rounded-2xl border border-gray-200 dark:border-white/10 bg-gray-50 dark:bg-white/5 text-sm text-charcoal-dark dark:text-white focus:outline-none focus:border-bisa">
            </div>

            <div class="grid sm:grid-cols-2 gap-4">
                <div>
                    <label for="event_type" class="block text-xs font-bold uppercase tracking-wider text-charcoal-dark dark:text-gray-200 mb-1.5">
                        Jenis Jalur Seleksi <span class="text-danger">*</span>
                    </label>
                    <select name="event_type" id="event_type" class="w-full px-4 py-3 rounded-2xl border border-gray-200 dark:border-white/10 bg-gray-50 dark:bg-white/5 text-sm text-charcoal-dark dark:text-white focus:outline-none focus:border-bisa">
                        <option value="snbt">SNBT 2025 (TPS & Literasi)</option>
                        <option value="utbk">UTBK CAT Terpadu</option>
                        <option value="mandiri">Ujian Mandiri (TKA PTN)</option>
                        <option value="tka">TKA Saintek & Soshum</option>
                    </select>
                </div>

                <div>
                    <label for="duration_minutes" class="block text-xs font-bold uppercase tracking-wider text-charcoal-dark dark:text-gray-200 mb-1.5">
                        Durasi Pengerjaan (Menit) <span class="text-danger">*</span>
                    </label>
                    <input type="number" name="duration_minutes" id="duration_minutes" required value="120" min="15" class="w-full px-4 py-3 rounded-2xl border border-gray-200 dark:border-white/10 bg-gray-50 dark:bg-white/5 text-sm text-charcoal-dark dark:text-white focus:outline-none focus:border-bisa">
                </div>
            </div>

            <div class="grid sm:grid-cols-2 gap-4">
                <div>
                    <label for="start_date" class="block text-xs font-bold uppercase tracking-wider text-charcoal-dark dark:text-gray-200 mb-1.5">
                        Waktu Mulai <span class="text-danger">*</span>
                    </label>
                    <input type="datetime-local" name="start_date" id="start_date" required class="w-full px-4 py-3 rounded-2xl border border-gray-200 dark:border-white/10 bg-gray-50 dark:bg-white/5 text-sm text-charcoal-dark dark:text-white focus:outline-none focus:border-bisa">
                </div>

                <div>
                    <label for="end_date" class="block text-xs font-bold uppercase tracking-wider text-charcoal-dark dark:text-gray-200 mb-1.5">
                        Waktu Selesai <span class="text-danger">*</span>
                    </label>
                    <input type="datetime-local" name="end_date" id="end_date" required class="w-full px-4 py-3 rounded-2xl border border-gray-200 dark:border-white/10 bg-gray-50 dark:bg-white/5 text-sm text-charcoal-dark dark:text-white focus:outline-none focus:border-bisa">
                </div>
            </div>

            <div>
                <label for="description" class="block text-xs font-bold uppercase tracking-wider text-charcoal-dark dark:text-gray-200 mb-1.5">
                    Deskripsi & Petunjuk Event
                </label>
                <textarea name="description" id="description" rows="3" placeholder="Informasi format subtes, syarat kelulusan, dan petunjuk teknis tryout..." class="w-full px-4 py-3 rounded-2xl border border-gray-200 dark:border-white/10 bg-gray-50 dark:bg-white/5 text-sm text-charcoal-dark dark:text-white focus:outline-none focus:border-bisa"></textarea>
            </div>

            <div class="p-4 rounded-2xl bg-gray-50 dark:bg-white/5 border border-gray-100 dark:border-white/5 space-y-3">
                <label class="flex items-center gap-3 cursor-pointer text-xs font-bold text-charcoal-dark dark:text-white">
                    <input type="checkbox" name="is_premium" value="1" class="rounded border-gray-300 text-bisa focus:ring-bisa">
                    <span>Khusus Pengguna Akun Premium (VIP Only)</span>
                </label>

                <label class="flex items-center gap-3 cursor-pointer text-xs font-bold text-charcoal-dark dark:text-white">
                    <input type="checkbox" name="is_published" value="1" checked class="rounded border-gray-300 text-bisa focus:ring-bisa">
                    <span>Publikasikan Langsung ke Siswa</span>
                </label>

                <label class="flex items-center gap-3 cursor-pointer text-xs font-bold text-charcoal-dark dark:text-white">
                    <input type="checkbox" name="release_discussion" value="1" checked class="rounded border-gray-300 text-bisa focus:ring-bisa">
                    <span>Rilis Kunci & Pembahasan Setelah Selesai</span>
                </label>
            </div>

            <button type="submit" class="w-full py-3.5 bg-bisa hover:bg-bisa-dark text-white font-extrabold text-xs rounded-xl shadow-md transition">
                Simpan & Publikasikan Event Tryout
            </button>
        </form>
    </div>
</div>
@endsection

