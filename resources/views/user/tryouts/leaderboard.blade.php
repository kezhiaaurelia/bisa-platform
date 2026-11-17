@extends('layouts.app')

@section('title', 'Leaderboard & Ranking Nasional — ' . $event->title)

@section('content')
<div class="bg-gray-50 dark:bg-[#0E1017] min-h-screen py-10 transition-colors duration-200">
    <div class="max-w-5xl mx-auto px-4 sm:px-6">

        {{-- Top Card --}}
        <div class="bg-white dark:bg-[#161922] rounded-3xl p-6 sm:p-8 border border-gray-100 dark:border-white/10 shadow-sm mb-8 animate-fade-in-down">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-gray-100 dark:border-white/10">
                <div>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-amber-100 dark:bg-amber-950/40 text-amber-800 dark:text-amber-300 rounded-full text-xs font-black uppercase tracking-wider mb-2">
                        <i class="bi bi-trophy-fill text-amber-500"></i> Peringkat Nasional Peserta
                    </span>
                    <h1 class="text-2xl font-black text-charcoal-dark dark:text-white">
                        {{ $event->title }}
                    </h1>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                        Sistem Penilaian Berskala IRT (Item Response Theory) • Update Real-Time
                    </p>
                </div>

                <a href="{{ route('tryouts.index') }}" class="px-4 py-2 bg-gray-100 dark:bg-white/10 hover:bg-gray-200 dark:hover:bg-white/20 text-charcoal dark:text-gray-200 rounded-xl text-xs font-bold transition flex items-center gap-1.5 self-start sm:self-auto">
                    <i class="bi bi-arrow-left"></i> Kembali ke Event
                </a>
            </div>

            {{-- User Rank Summary (if taken) --}}
            @if($userReg && $userReg->score !== null)
                <div class="mt-6 p-4 rounded-2xl bg-bisa-50/70 dark:bg-bisa-950/30 border border-bisa/30 flex flex-wrap items-center justify-between gap-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-bisa text-white flex items-center justify-center font-black text-sm">
                            #{{ $userReg->national_rank ?? '-' }}
                        </div>
                        <div>
                            <span class="text-xs font-bold text-charcoal-dark dark:text-white">Peringkat Kamu Saat Ini</span>
                            <div class="text-[11px] text-gray-500 dark:text-gray-400">Terus drill subtes terlemah untuk mendongkrak skor IRT!</div>
                        </div>
                    </div>
                    <div class="flex items-center gap-4 text-xs font-bold">
                        <div>Skor: <span class="text-bisa font-black text-sm">{{ number_format($userReg->score, 1) }}</span></div>
                        <div>Skor IRT: <span class="text-emerald-600 font-black text-sm">{{ number_format($userReg->irt_score ?? ($userReg->score * 7.5), 1) }}</span></div>
                    </div>
                </div>
            @endif
        </div>

        {{-- Leaderboard Table --}}
        <div class="bg-white dark:bg-[#161922] rounded-3xl border border-gray-100 dark:border-white/10 shadow-sm overflow-hidden animate-fade-in-up">
            <div class="p-6 pb-4 border-b border-gray-100 dark:border-white/10 flex items-center justify-between">
                <h3 class="font-black text-sm text-charcoal-dark dark:text-white flex items-center gap-2">
                    <i class="bi bi-award-fill text-gold"></i> Top 50 Skor Tertinggi Nasional
                </h3>
                <span class="text-xs text-gray-400">Total Peserta: {{ $rankings->count() }} Siswa</span>
            </div>

            @if($rankings->isEmpty())
                <div class="p-12 text-center text-xs text-gray-400">
                    <i class="bi bi-hourglass-split text-3xl text-gray-300 block mb-2"></i>
                    Belum ada skor yang tercatat untuk event ini. Jadilah yang pertama menyelesaikan simulasi!
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-gray-50 dark:bg-white/5 text-gray-400 font-bold uppercase tracking-wider text-[10px]">
                            <tr>
                                <th class="py-3.5 px-6">Rank</th>
                                <th class="py-3.5 px-6">Nama Peserta</th>
                                <th class="py-3.5 px-6">Target Kampus</th>
                                <th class="py-3.5 px-6 text-center">Skor Mentah</th>
                                <th class="py-3.5 px-6 text-right">Skor IRT</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-white/5 font-medium">
                            @foreach($rankings as $idx => $r)
                                <tr class="hover:bg-gray-50 dark:hover:bg-white/5 transition {{ auth()->id() === $r->user_id ? 'bg-bisa-50/50 dark:bg-bisa-950/20 font-bold' : '' }}">
                                    <td class="py-4 px-6">
                                        @if($idx === 0)
                                            <span class="w-6 h-6 rounded-full bg-gold text-white font-black inline-flex items-center justify-center text-xs shadow-sm">🥇</span>
                                        @elseif($idx === 1)
                                            <span class="w-6 h-6 rounded-full bg-gray-300 text-charcoal font-black inline-flex items-center justify-center text-xs shadow-sm">🥈</span>
                                        @elseif($idx === 2)
                                            <span class="w-6 h-6 rounded-full bg-amber-600 text-white font-black inline-flex items-center justify-center text-xs shadow-sm">🥉</span>
                                        @else
                                            <span class="text-gray-400 font-bold">#{{ $idx + 1 }}</span>
                                        @endif
                                    </td>
                                    <td class="py-4 px-6 text-charcoal-dark dark:text-white">
                                        <div class="flex items-center gap-2.5">
                                            <span class="w-7 h-7 rounded-lg bg-bisa text-white flex items-center justify-center font-bold text-xs">
                                                {{ strtoupper(substr($r->user?->name ?? 'U', 0, 1)) }}
                                            </span>
                                            <span>{{ $r->user?->name ?? 'Peserta BISA' }}</span>
                                        </div>
                                    </td>
                                    <td class="py-4 px-6 text-gray-500 dark:text-gray-400">
                                        {{ $r->user?->target_ptn ?? 'Pejuang PTN' }}
                                    </td>
                                    <td class="py-4 px-6 text-center font-bold text-charcoal-dark dark:text-white">
                                        {{ number_format($r->score, 1) }}
                                    </td>
                                    <td class="py-4 px-6 text-right font-black text-emerald-600 dark:text-emerald-400 text-sm">
                                        {{ number_format($r->irt_score ?? ($r->score * 7.5), 1) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

    </div>
</div>
@endsection

