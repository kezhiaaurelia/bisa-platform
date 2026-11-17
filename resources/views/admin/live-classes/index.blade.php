@extends('layouts.admin')

@section('title', 'Kelola Kelas Live — Admin BISA')

@section('content')
<div class="space-y-6 animate-fade-in-up">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-charcoal-dark dark:text-white">Kelola Sesi Kelas Live</h1>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Buat jadwal bimbingan interaktif, tentor, tautan meeting, dan upload rekaman.</p>
        </div>
        <a href="{{ route('admin.live-classes.create') }}" class="px-4 py-2.5 bg-bisa hover:bg-bisa-dark text-white text-xs font-bold rounded-xl shadow-md transition flex items-center gap-1.5 self-start sm:self-auto">
            <span>+ Jadwalkan Kelas Baru</span>
        </a>
    </div>

    <div class="bg-white dark:bg-[#161922] rounded-3xl border border-gray-200/80 dark:border-white/10 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-gray-50 dark:bg-white/5 text-gray-400 font-bold uppercase tracking-wider text-[10px]">
                    <tr>
                        <th class="py-3.5 px-6">Topik Sesi</th>
                        <th class="py-3.5 px-6">Tentor Pengajar</th>
                        <th class="py-3.5 px-6">Jadwal Sesi</th>
                        <th class="py-3.5 px-6">Pendaftar</th>
                        <th class="py-3.5 px-6">Link Meet</th>
                        <th class="py-3.5 px-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-white/5">
                    @forelse($classes as $c)
                        <tr class="hover:bg-gray-50 dark:hover:bg-white/5 transition">
                            <td class="py-4 px-6 font-bold text-charcoal-dark dark:text-white">
                                {{ $c->title }}
                            </td>
                            <td class="py-4 px-6 font-semibold text-bisa">
                                {{ $c->instructor_name }}
                            </td>
                            <td class="py-4 px-6 text-gray-500 dark:text-gray-400">
                                {{ $c->scheduled_at->format('d M Y, H:i') }} WIB
                            </td>
                            <td class="py-4 px-6 font-black text-charcoal-dark dark:text-white">
                                {{ $c->registrations_count }} Siswa
                            </td>
                            <td class="py-4 px-6">
                                @if($c->meet_url)
                                    <a href="{{ $c->meet_url }}" target="_blank" class="text-blue-500 hover:underline font-bold">Buka Link ↗</a>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-right">
                                <form action="{{ route('admin.live-classes.destroy', $c->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus sesi live ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-danger hover:underline font-bold text-[11px]">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-gray-400">Belum ada sesi kelas live yang dijadwalkan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($classes->hasPages())
            <div class="p-4 border-t border-gray-100 dark:border-white/10">
                {{ $classes->links() }}
            </div>
        @endif
    </div>
</div>
@endsection

