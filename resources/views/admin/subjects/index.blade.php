@extends('layouts.admin')

@section('title', 'Kelola Mata Pelajaran / Subtes — BISA')

@section('content')
<div class="space-y-6">

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-charcoal-dark">Mata Pelajaran & Subtes</h1>
            <p class="text-xs text-gray-500 mt-1">Kelola subtes yang ada di bawah setiap kategori secara dinamis dari database.</p>
        </div>

        <a href="{{ route('admin.subjects.create') }}" class="px-4 py-2 bg-bisa hover:bg-bisa-dark text-white text-xs font-bold rounded-xl transition shadow-sm self-start sm:self-auto">
            + Tambah Subtes / Mapel
        </a>
    </div>

    {{-- Filter by Category --}}
    <div class="flex items-center gap-2 overflow-x-auto pb-1">
        <a href="{{ route('admin.subjects.index') }}"
           class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition {{ !$categoryId ? 'bg-charcoal text-white' : 'bg-white text-gray-600 border border-gray-200' }}">
            Semua Kategori
        </a>
        @foreach($categories as $cat)
            <a href="{{ route('admin.subjects.index', ['category_id' => $cat->id]) }}"
               class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition {{ $categoryId == $cat->id ? 'bg-bisa text-white' : 'bg-white text-gray-600 border border-gray-200' }}">
                {{ $cat->name }}
            </a>
        @endforeach
    </div>

    <div class="bg-white rounded-3xl border border-gray-200/80 shadow-sm overflow-hidden">
        <table class="w-full text-left text-xs text-charcoal">
            <thead class="bg-gray-50 border-b border-gray-200 text-[11px] font-extrabold uppercase tracking-wider text-gray-500">
                <tr>
                    <th class="p-4">Mata Pelajaran / Subtes</th>
                    <th class="p-4">Kategori Induk</th>
                    <th class="p-4 text-center">Soal</th>
                    <th class="p-4 text-center">Modul</th>
                    <th class="p-4 text-center">Level Map</th>
                    <th class="p-4 text-center">Status</th>
                    <th class="p-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($subjects as $subj)
                    <tr class="hover:bg-gray-50/50 transition">
                        <td class="p-4">
                            <span class="font-extrabold text-charcoal-dark text-sm">{{ $subj->name }}</span>
                            <div class="text-[11px] text-gray-400 mt-0.5 truncate max-w-xs">{{ $subj->description }}</div>
                        </td>
                        <td class="p-4 font-bold text-gray-600">
                            {{ $subj->category ? $subj->category->name : '—' }}
                        </td>
                        <td class="p-4 text-center font-bold text-bisa">{{ $subj->questions_count }}</td>
                        <td class="p-4 text-center font-bold text-blue-600">{{ $subj->modules_count }}</td>
                        <td class="p-4 text-center font-bold text-purple-600">{{ $subj->learning_levels_count }}</td>
                        <td class="p-4 text-center">
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold {{ $subj->is_active ? 'bg-success-light text-success' : 'bg-gray-100 text-gray-400' }}">
                                {{ $subj->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </td>
                        <td class="p-4 text-right space-x-2">
                            <a href="{{ route('admin.subjects.edit', $subj->id) }}" class="text-bisa font-bold hover:underline">Edit</a>
                            <form action="{{ route('admin.subjects.destroy', $subj->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus mata pelajaran ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-danger font-bold hover:underline">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="p-8 text-center text-gray-400">Belum ada mata pelajaran.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        @if($subjects->hasPages())
            <div class="p-4 border-t border-gray-100">
                {{ $subjects->links() }}
            </div>
        @endif
    </div>

</div>
@endsection

