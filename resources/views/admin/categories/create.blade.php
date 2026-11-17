@extends('layouts.admin')

@section('title', 'Tambah Kategori — BISA')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-black text-charcoal-dark">Tambah Kategori Baru</h1>
            <p class="text-xs text-gray-500 mt-1">Buat kategori persiapan baru (misal: Ujian Mandiri, Kedinasan).</p>
        </div>
        <a href="{{ route('admin.categories.index') }}" class="text-xs font-bold text-gray-500 hover:text-charcoal">
            ← Kembali
        </a>
    </div>

    <div class="bg-white rounded-3xl p-8 border border-gray-200/80 shadow-sm">
        <form action="{{ route('admin.categories.store') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label for="name" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1.5">Nama Kategori</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required
                    placeholder="Contoh: SNBT, Kedinasan, SIMAK UI"
                    class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:border-bisa focus:ring-2 focus:ring-bisa/20 focus:outline-none">
            </div>

            <div>
                <label for="description" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1.5">Deskripsi</label>
                <textarea id="description" name="description" rows="3"
                    placeholder="Penjelasan singkat mengenai kategori persiapan ini..."
                    class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:border-bisa focus:ring-2 focus:ring-bisa/20 focus:outline-none">{{ old('description') }}</textarea>
            </div>

            <div>
                <label for="order" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1.5">Urutan Tampil (Order)</label>
                <input id="order" type="number" name="order" value="{{ old('order', 1) }}"
                    class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:border-bisa focus:ring-2 focus:ring-bisa/20 focus:outline-none">
            </div>

            <div class="pt-2">
                <label class="flex items-center gap-2 cursor-pointer select-none text-sm text-gray-700">
                    <input type="checkbox" name="is_active" value="1" checked class="w-4 h-4 text-bisa rounded border-gray-300 focus:ring-bisa">
                    <span>Aktifkan kategori ini agar tampil ke siswa</span>
                </label>
            </div>

            <div class="pt-4 border-t border-gray-100 flex justify-end gap-3">
                <a href="{{ route('admin.categories.index') }}" class="px-5 py-2.5 rounded-xl border border-gray-200 text-xs font-bold text-gray-600 hover:bg-gray-50">
                    Batal
                </a>
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-bisa hover:bg-bisa-dark text-white text-xs font-bold transition shadow-sm">
                    Simpan Kategori
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

