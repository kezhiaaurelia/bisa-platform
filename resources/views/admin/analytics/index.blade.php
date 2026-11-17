@extends('layouts.admin')

@section('title', 'Laporan & Analitik — Admin BISA')

@section('content')
<div class="space-y-8 animate-fade-in-up">
    <div>
        <h1 class="text-2xl font-black text-charcoal-dark dark:text-white">Laporan & Analitik Akademik</h1>
        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Evaluasi performa subtes, tingkat kesulitan butir soal, dan retensi belajar siswa.</p>
    </div>

    {{-- Top Highlights --}}
    <div class="grid sm:grid-cols-2 gap-6">
        <div class="bg-white dark:bg-[#161922] p-6 rounded-3xl border border-gray-200/80 dark:border-white/10 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">Akurasi Jawaban Siswa</span>
                <div class="text-3xl font-black text-emerald-600 dark:text-emerald-400 mt-1">{{ $accuracyRate }}%</div>
                <span class="text-[11px] text-gray-400">Dari total {{ number_format($totalAnswers) }} pengerjaan soal</span>
            </div>
            <div class="w-14 h-14 rounded-2xl bg-emerald-100 dark:bg-emerald-950/40 text-emerald-600 flex items-center justify-center text-2xl font-black">
                <i class="bi bi-pie-chart-fill"></i>
            </div>
        </div>

        <div class="bg-white dark:bg-[#161922] p-6 rounded-3xl border border-gray-200/80 dark:border-white/10 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">Algoritma Penilaian</span>
                <div class="text-3xl font-black text-bisa mt-1">IRT Standard</div>
                <span class="text-[11px] text-gray-400">Tersinkronisasi silabus SNPMB 2025</span>
            </div>
            <div class="w-14 h-14 rounded-2xl bg-bisa-100 dark:bg-bisa-900/40 text-bisa flex items-center justify-center text-2xl font-black">
                <i class="bi bi-graph-up"></i>
            </div>
        </div>
    </div>

    {{-- Subtests Average Performance --}}
    <div class="bg-white dark:bg-[#161922] rounded-3xl p-6 border border-gray-200/80 dark:border-white/10 shadow-sm">
        <h3 class="font-extrabold text-sm text-charcoal-dark dark:text-white mb-4">Rata-Rata Skor per Mata Pelajaran & Subtes</h3>
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($subjectStats as $st)
                <div class="p-4 rounded-2xl bg-gray-50 dark:bg-white/5 border border-gray-100 dark:border-white/5">
                    <div class="flex items-center justify-between mb-2">
                        <span class="font-bold text-xs text-charcoal-dark dark:text-white truncate">{{ $st['name'] }}</span>
                        <span class="text-xs font-black text-bisa">{{ $st['avg_score'] }}</span>
                    </div>
                    <div class="w-full h-2 bg-gray-200 dark:bg-white/10 rounded-full overflow-hidden">
                        <div class="h-full bg-bisa rounded-full" style="width: {{ min(100, $st['avg_score']) }}%"></div>
                    </div>
                    <div class="text-[10px] text-gray-400 mt-2">{{ $st['questions_count'] }} Butir Soal</div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Top Most Challenging Questions --}}
    <div class="bg-white dark:bg-[#161922] rounded-3xl p-6 border border-gray-200/80 dark:border-white/10 shadow-sm">
        <h3 class="font-extrabold text-sm text-charcoal-dark dark:text-white mb-4">5 Butir Soal Paling Banyak Salah (Tingkat Error Tertinggi)</h3>
        <div class="space-y-3 text-xs">
            @forelse($difficultQuestions as $dq)
                <div class="p-4 rounded-2xl bg-rose-50/50 dark:bg-rose-950/20 border border-rose-100 dark:border-rose-900/30 flex items-center justify-between gap-4">
                    <div class="flex-1 min-w-0">
                        <span class="text-[10px] font-bold uppercase text-rose-600 block mb-0.5">{{ $dq['subject'] }} • Soal #{{ $dq['id'] }}</span>
                        <p class="font-medium text-charcoal-dark dark:text-gray-200 truncate">{{ $dq['text'] }}</p>
                    </div>
                    <div class="text-right shrink-0">
                        <span class="px-2.5 py-1 rounded-full bg-rose-100 dark:bg-rose-900/50 text-rose-700 dark:text-rose-300 font-black text-xs">
                            {{ $dq['error_rate'] }}% Salah
                        </span>
                        <span class="text-[10px] text-gray-400 block mt-1">{{ $dq['attempts'] }} Kali Dikerjakan</span>
                    </div>
                </div>
            @empty
                <p class="text-gray-400 text-center py-4">Belum cukup data pengerjaan butir soal.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection

