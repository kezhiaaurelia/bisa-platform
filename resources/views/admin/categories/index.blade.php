@extends('layouts.admin')

@section('title', 'Kelola Kategori Persiapan — BISA')

@section('content')
<div class="space-y-6">

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-charcoal-dark">Kategori Persiapan</h1>
            <p class="text-xs text-gray-500 mt-1">Kelola jenis persiapan tes (TKA, SNBT, UTBK, dll.) secara dinamis.</p>
        </div>

        <a href="{{ route('admin.categories.create') }}" class="px-4 py-2 bg-bisa hover:bg-bisa-dark text-white text-xs font-bold rounded-xl transition shadow-sm self-start sm:self-auto">
            + Tambah Kategori
        </a>
    </div>

    <div class="bg-white rounded-3xl border border-gray-200/80 shadow-sm overflow-hidden">
        <table class="w-full text-left text-xs text-charcoal">
            <thead class="bg-gray-50 border-b border-gray-200 text-[11px] font-extrabold uppercase tracking-wider text-gray-500">
                <tr>
                    <th class="p-4">Kategori</th>
                    <th class="p-4">Slug</th>
                    <th class="p-4">Deskripsi</th>
                    <th class="p-4 text-center">Jumlah Subtes</th>
                    <th class="p-4 text-center">Status</th>
                    <th class="p-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($categories as $cat)
                    <tr class="hover:bg-gray-50/50 transition">
                        <td class="p-4">
                            <span class="font-extrabold text-charcoal-dark text-sm">{{ $cat->name }}</span>
                        </td>
                        <td class="p-4 font-mono text-gray-500">{{ $cat->slug }}</td>
                        <td class="p-4 text-gray-600 max-w-xs truncate">{{ $cat->description }}</td>
                        <td class="p-4 text-center font-bold text-bisa">{{ $cat->subjects_count }}</td>
                        <td class="p-4 text-center">
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold {{ $cat->is_active ? 'bg-success-light text-success' : 'bg-gray-100 text-gray-400' }}">
                                {{ $cat->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </td>
                        <td class="p-4 text-right space-x-2">
                            <a href="{{ route('admin.categories.edit', $cat->id) }}" class="text-bisa font-bold hover:underline">Edit</a>
                            <form action="{{ route('admin.categories.destroy', $cat->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus kategori ini beserta seluruh subtes di dalamnya?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-danger font-bold hover:underline">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="p-8 text-center text-gray-400">Belum ada kategori.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection

