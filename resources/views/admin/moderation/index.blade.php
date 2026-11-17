@extends('layouts.admin')

@section('title', 'Moderasi & Tiket Bantuan — Admin BISA')

@section('content')
<div class="space-y-6 animate-fade-in-up">
    <div>
        <h1 class="text-2xl font-black text-charcoal-dark dark:text-white">Moderasi & Laporan Soal Siswa</h1>
        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Review feedback, pertanyaan bantuan, dan koreksi butir soal dari pengguna.</p>
    </div>

    <div class="bg-white dark:bg-[#161922] rounded-3xl border border-gray-200/80 dark:border-white/10 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-gray-50 dark:bg-white/5 text-gray-400 font-bold uppercase tracking-wider text-[10px]">
                    <tr>
                        <th class="py-3.5 px-6">Siswa</th>
                        <th class="py-3.5 px-6">Subjek</th>
                        <th class="py-3.5 px-6">Pesan Kendala</th>
                        <th class="py-3.5 px-6">Status</th>
                        <th class="py-3.5 px-6 text-right">Balasan Admin</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-white/5 font-medium">
                    @forelse($tickets as $tk)
                        <tr class="hover:bg-gray-50 dark:hover:bg-white/5 transition">
                            <td class="py-4 px-6 font-bold text-charcoal-dark dark:text-white">
                                {{ $tk->user?->name ?? 'Siswa' }}
                                <div class="text-[10px] text-gray-400 font-normal">{{ $tk->created_at->format('d M H:i') }}</div>
                            </td>
                            <td class="py-4 px-6 font-semibold">{{ $tk->subject }}</td>
                            <td class="py-4 px-6 text-gray-600 dark:text-gray-300 max-w-xs">{{ $tk->message }}</td>
                            <td class="py-4 px-6">
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold
                                    {{ $tk->status === 'resolved' ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}
                                ">
                                    {{ ucfirst($tk->status) }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-right">
                                <form action="{{ route('admin.moderation.reply', $tk->id) }}" method="POST" class="inline-flex items-center gap-2">
                                    @csrf
                                    <input type="text" name="admin_reply" value="{{ $tk->admin_reply }}" placeholder="Ketik balasan..." required class="px-3 py-1.5 rounded-xl border border-gray-200 dark:border-white/10 text-xs bg-gray-50 dark:bg-white/5">
                                    <input type="hidden" name="status" value="resolved">
                                    <button type="submit" class="px-3 py-1.5 bg-bisa text-white rounded-xl font-bold hover:bg-bisa-dark transition">Kirim</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-8 text-center text-gray-400">Tidak ada tiket bantuan yang masuk saat ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($tickets->hasPages())
            <div class="p-4 border-t border-gray-100 dark:border-white/10">
                {{ $tickets->links() }}
            </div>
        @endif
    </div>
</div>
@endsection

