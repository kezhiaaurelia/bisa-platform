@extends('layouts.admin')

@section('title', 'Kelola Event Tryout Akbar — Admin BISA')

@section('content')
<div class="space-y-6 animate-fade-in-up">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-charcoal-dark dark:text-white">Kelola Event Tryout Nasional</h1>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Buat jadwal event simulasi, atur durasi, status gratis/premium, dan rilis pembahasan.</p>
        </div>
        <a href="{{ route('admin.tryout-events.create') }}" class="px-4 py-2.5 bg-bisa hover:bg-bisa-dark text-white text-xs font-bold rounded-xl shadow-md transition flex items-center gap-1.5 self-start sm:self-auto">
            <span>+ Buat Event Tryout Baru</span>
        </a>
    </div>

    <div class="bg-white dark:bg-[#161922] rounded-3xl border border-gray-200/80 dark:border-white/10 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-gray-50 dark:bg-white/5 text-gray-400 font-bold uppercase tracking-wider text-[10px]">
                    <tr>
                        <th class="py-3.5 px-6">Event Tryout</th>
                        <th class="py-3.5 px-6">Tipe Jalur</th>
                        <th class="py-3.5 px-6">Jadwal Pelaksanaan</th>
                        <th class="py-3.5 px-6">Durasi</th>
                        <th class="py-3.5 px-6">Akses</th>
                        <th class="py-3.5 px-6">Peserta</th>
                        <th class="py-3.5 px-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-white/5">
                    @forelse($events as $ev)
                        <tr class="hover:bg-gray-50 dark:hover:bg-white/5 transition">
                            <td class="py-4 px-6 font-bold text-charcoal-dark dark:text-white">
                                {{ $ev->title }}
                            </td>
                            <td class="py-4 px-6">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase bg-bisa-50 dark:bg-bisa-950/40 text-bisa">
                                    {{ strtoupper($ev->event_type) }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-gray-500 dark:text-gray-400">
                                {{ $ev->start_date->format('d M') }} - {{ $ev->end_date->format('d M Y') }}
                            </td>
                            <td class="py-4 px-6 font-semibold text-charcoal-dark dark:text-white">
                                {{ $ev->duration_minutes }} Menit
                            </td>
                            <td class="py-4 px-6">
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold {{ $ev->is_premium ? 'bg-gold/20 text-gold-dark' : 'bg-emerald-100 text-emerald-700' }}">
                                    {{ $ev->is_premium ? 'Premium' : 'Gratis' }}
                                </span>
                            </td>
                            <td class="py-4 px-6 font-black text-charcoal-dark dark:text-white">
                                {{ $ev->registrations_count }} Siswa
                            </td>
                            <td class="py-4 px-6 text-right space-x-2">
                                <a href="{{ route('tryouts.leaderboard', $ev->id) }}" target="_blank" class="px-2.5 py-1 bg-gray-100 dark:bg-white/10 hover:bg-gray-200 text-charcoal-dark dark:text-gray-200 rounded-lg text-[11px] font-bold transition">
                                    Leaderboard
                                </a>
                                <form action="{{ route('admin.tryout-events.destroy', $ev->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus event ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-2 py-1 text-danger hover:underline font-bold text-[11px]">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-8 text-center text-gray-400">Belum ada event tryout yang dibuat.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($events->hasPages())
            <div class="p-4 border-t border-gray-100 dark:border-white/10">
                {{ $events->links() }}
            </div>
        @endif
    </div>
</div>
@endsection

