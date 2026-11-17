@extends('layouts.admin')

@section('title', 'Transaksi & Pendapatan Premium — Admin BISA')

@section('content')
<div class="space-y-6 animate-fade-in-up">
    <div>
        <h1 class="text-2xl font-black text-charcoal-dark dark:text-white">Kelola Transaksi & Paket Premium</h1>
        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Pantau pembayaran langganan siswa, total pendapatan, dan riwayat aktivasi VIP.</p>
    </div>

    {{-- Revenue summary --}}
    <div class="grid sm:grid-cols-3 gap-4">
        <div class="bg-white dark:bg-[#161922] p-5 rounded-3xl border border-gray-200/80 dark:border-white/10 shadow-sm">
            <span class="text-gray-400 text-[11px] font-bold uppercase tracking-wider">Total Pendapatan</span>
            <div class="text-2xl font-black text-emerald-600 dark:text-emerald-400 mt-1">
                Rp {{ number_format($totalRevenue, 0, ',', '.') }}
            </div>
            <span class="text-[10px] text-gray-400">Akumulasi transaksi sukses</span>
        </div>

        <div class="bg-white dark:bg-[#161922] p-5 rounded-3xl border border-gray-200/80 dark:border-white/10 shadow-sm">
            <span class="text-gray-400 text-[11px] font-bold uppercase tracking-wider">Transaksi Berhasil</span>
            <div class="text-2xl font-black text-charcoal-dark dark:text-white mt-1">
                {{ number_format($successCount) }}
            </div>
            <span class="text-[10px] text-gray-400">Paket siswa aktif</span>
        </div>

        <div class="bg-white dark:bg-[#161922] p-5 rounded-3xl border border-gray-200/80 dark:border-white/10 shadow-sm">
            <span class="text-gray-400 text-[11px] font-bold uppercase tracking-wider">Status Gateway</span>
            <div class="text-2xl font-black text-bisa mt-1">
                Aktif (QRIS & VA)
            </div>
            <span class="text-[10px] text-gray-400">Konfirmasi otomatis</span>
        </div>
    </div>

    {{-- Transactions Table --}}
    <div class="bg-white dark:bg-[#161922] rounded-3xl border border-gray-200/80 dark:border-white/10 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-gray-50 dark:bg-white/5 text-gray-400 font-bold uppercase tracking-wider text-[10px]">
                    <tr>
                        <th class="py-3.5 px-6">ID</th>
                        <th class="py-3.5 px-6">Siswa</th>
                        <th class="py-3.5 px-6">Paket Berlangganan</th>
                        <th class="py-3.5 px-6">Nominal</th>
                        <th class="py-3.5 px-6">Metode</th>
                        <th class="py-3.5 px-6">Waktu</th>
                        <th class="py-3.5 px-6 text-right">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-white/5 font-medium">
                    @forelse($transactions as $t)
                        <tr class="hover:bg-gray-50 dark:hover:bg-white/5 transition">
                            <td class="py-4 px-6 text-gray-400 font-mono">#TRX-{{ $t->id }}</td>
                            <td class="py-4 px-6 font-bold text-charcoal-dark dark:text-white">
                                {{ $t->user?->name ?? 'User' }}
                                <div class="text-[10px] text-gray-400 font-normal">{{ $t->user?->email }}</div>
                            </td>
                            <td class="py-4 px-6 font-semibold">{{ $t->plan_name }}</td>
                            <td class="py-4 px-6 font-black text-emerald-600 dark:text-emerald-400">
                                Rp {{ number_format($t->amount, 0, ',', '.') }}
                            </td>
                            <td class="py-4 px-6 text-gray-500">{{ $t->payment_method }}</td>
                            <td class="py-4 px-6 text-gray-400">{{ $t->created_at->format('d M Y, H:i') }}</td>
                            <td class="py-4 px-6 text-right">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-black uppercase bg-emerald-100 dark:bg-emerald-950/40 text-emerald-700 dark:text-emerald-300">
                                    Sukses
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-8 text-center text-gray-400">Belum ada data transaksi langganan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($transactions->hasPages())
            <div class="p-4 border-t border-gray-100 dark:border-white/10">
                {{ $transactions->links() }}
            </div>
        @endif
    </div>
</div>
@endsection

