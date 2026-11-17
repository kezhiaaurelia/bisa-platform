@extends('layouts.admin')

@section('title', 'Kelola Kuis & Tryout (Waktu) — BISA')

@section('content')
<div class="space-y-6">

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-charcoal-dark">Kelola Kuis & Tryout Berwaktu</h1>
            <p class="text-xs text-gray-500 mt-1">Konfigurasi durasi pengerjaan (menit), passing grade, dan paket soal ujian.</p>
        </div>

        <a href="{{ route('admin.quizzes.create') }}" class="px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white text-xs font-bold rounded-xl transition shadow-sm self-start sm:self-auto">
            + Buat Kuis / Tryout Baru
        </a>
    </div>

    <div class="bg-white rounded-3xl border border-gray-200/80 shadow-sm overflow-hidden">
        <table class="w-full text-left text-xs text-charcoal">
            <thead class="bg-gray-50 border-b border-gray-200 text-[11px] font-extrabold uppercase tracking-wider text-gray-500">
                <tr>
                    <th class="p-4">Judul Paket</th>
                    <th class="p-4">Tipe</th>
                    <th class="p-4">Kategori / Subtes</th>
                    <th class="p-4 text-center">Durasi Timer</th>
                    <th class="p-4 text-center">Soal</th>
                    <th class="p-4 text-center">Passing</th>
                    <th class="p-4 text-center">Status</th>
                    <th class="p-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($quizzes as $q)
                    <tr class="hover:bg-gray-50/50 transition">
                        <td class="p-4">
                            <span class="font-extrabold text-charcoal-dark text-sm">{{ $q->title }}</span>
                            <div class="text-[10px] text-gray-400 mt-0.5 max-w-xs truncate">{{ $q->description }}</div>
                        </td>
                        <td class="p-4">
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase {{ $q->type === 'tryout' ? 'bg-emerald-100 text-emerald-800' : 'bg-purple-100 text-purple-700' }}">
                                {{ $q->type }}
                            </span>
                        </td>
                        <td class="p-4">
                            <span class="font-bold text-charcoal">{{ $q->category ? $q->category->name : 'Semua Kategori' }}</span>
                            @if($q->subject)
                                <div class="text-[10px] text-gray-400">{{ $q->subject->name }}</div>
                            @endif
                        </td>
                        <td class="p-4 text-center">
                            <span class="font-black text-xs text-purple-700 px-2.5 py-1 bg-purple-50 rounded-lg">
                                ⏱️ {{ $q->duration_minutes }} Menit
                            </span>
                        </td>
                        <td class="p-4 text-center font-bold text-charcoal">{{ $q->questions_count }}</td>
                        <td class="p-4 text-center font-bold text-bisa">{{ $q->pass_percentage }}%</td>
                        <td class="p-4 text-center">
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold {{ $q->is_active ? 'bg-success-light text-success' : 'bg-gray-100 text-gray-400' }}">
                                {{ $q->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </td>
                        <td class="p-4 text-right space-x-2">
                            <a href="{{ route('admin.quizzes.edit', $q->id) }}" class="text-bisa font-bold hover:underline">Edit</a>
                            <form action="{{ route('admin.quizzes.destroy', $q->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus paket kuis ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-danger font-bold hover:underline">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="p-8 text-center text-gray-400">Belum ada paket kuis dibuat.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        @if($quizzes->hasPages())
            <div class="p-4 border-t border-gray-100">
                {{ $quizzes->links() }}
            </div>
        @endif
    </div>

</div>
@endsection

