@extends('layouts.admin')

@section('title', 'Jadwalkan Kelas Live — Admin BISA')

@section('content')
<div class="max-w-2xl mx-auto space-y-6 animate-fade-in-up">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-black text-charcoal-dark dark:text-white">Jadwalkan Kelas Live Baru</h1>
        <a href="{{ route('admin.live-classes.index') }}" class="text-xs font-bold text-gray-500 hover:text-bisa">← Kembali</a>
    </div>

    <div class="bg-white dark:bg-[#161922] rounded-3xl p-6 sm:p-8 border border-gray-200/80 dark:border-white/10 shadow-sm">
        <form action="{{ route('admin.live-classes.store') }}" method="POST" class="space-y-4 text-xs">
            @csrf

            <div>
                <label class="block font-bold uppercase tracking-wider mb-1">Judul Topik Sesi <span class="text-danger">*</span></label>
                <input type="text" name="title" required placeholder="Contoh: Bedah Soal Kuantitatif & Logika Aljabar" class="w-full px-4 py-3 rounded-2xl border border-gray-200 dark:border-white/10 bg-gray-50 dark:bg-white/5 text-sm text-charcoal-dark dark:text-white focus:outline-none focus:border-bisa">
            </div>

            <div class="grid sm:grid-cols-2 gap-4">
                <div>
                    <label class="block font-bold uppercase tracking-wider mb-1">Nama Tentor / Pengajar <span class="text-danger">*</span></label>
                    <input type="text" name="instructor_name" required placeholder="Contoh: Kak Bambang, M.Sc." class="w-full px-4 py-3 rounded-2xl border border-gray-200 dark:border-white/10 bg-gray-50 dark:bg-white/5 text-sm text-charcoal-dark dark:text-white focus:outline-none focus:border-bisa">
                </div>

                <div>
                    <label class="block font-bold uppercase tracking-wider mb-1">Kategori Program <span class="text-danger">*</span></label>
                    <select name="category_slug" class="w-full px-4 py-3 rounded-2xl border border-gray-200 dark:border-white/10 bg-gray-50 dark:bg-white/5 text-sm text-charcoal-dark dark:text-white focus:outline-none focus:border-bisa">
                        <option value="snbt">SNBT 2025</option>
                        <option value="tka">TKA Mandiri</option>
                        <option value="utbk">UTBK CAT</option>
                    </select>
                </div>
            </div>

            <div class="grid sm:grid-cols-2 gap-4">
                <div>
                    <label class="block font-bold uppercase tracking-wider mb-1">Jadwal Sesi Live <span class="text-danger">*</span></label>
                    <input type="datetime-local" name="scheduled_at" required class="w-full px-4 py-3 rounded-2xl border border-gray-200 dark:border-white/10 bg-gray-50 dark:bg-white/5 text-sm text-charcoal-dark dark:text-white focus:outline-none focus:border-bisa">
                </div>

                <div>
                    <label class="block font-bold uppercase tracking-wider mb-1">Durasi (Menit) <span class="text-danger">*</span></label>
                    <input type="number" name="duration_minutes" value="90" required class="w-full px-4 py-3 rounded-2xl border border-gray-200 dark:border-white/10 bg-gray-50 dark:bg-white/5 text-sm text-charcoal-dark dark:text-white focus:outline-none focus:border-bisa">
                </div>
            </div>

            <div>
                <label class="block font-bold uppercase tracking-wider mb-1">Link Ruang Meeting (Google Meet / Zoom)</label>
                <input type="url" name="meet_url" placeholder="https://meet.google.com/..." class="w-full px-4 py-3 rounded-2xl border border-gray-200 dark:border-white/10 bg-gray-50 dark:bg-white/5 text-sm text-charcoal-dark dark:text-white focus:outline-none focus:border-bisa">
            </div>

            <div>
                <label class="block font-bold uppercase tracking-wider mb-1">Deskripsi Singkat Pembahasan</label>
                <textarea name="description" rows="3" placeholder="Materi yang akan dibedah pada sesi ini..." class="w-full px-4 py-3 rounded-2xl border border-gray-200 dark:border-white/10 bg-gray-50 dark:bg-white/5 text-sm text-charcoal-dark dark:text-white focus:outline-none focus:border-bisa"></textarea>
            </div>

            <div class="pt-2">
                <button type="submit" class="w-full py-3.5 bg-bisa hover:bg-bisa-dark text-white font-extrabold text-xs rounded-xl shadow-md transition">
                    Simpan Jadwal Kelas Live
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

