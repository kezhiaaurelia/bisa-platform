@extends('layouts.admin')

@section('title', 'Dashboard Administrator — BISA')

@section('content')
<div class="space-y-8 animate-fade-in-up">

    {{-- Top Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-charcoal-dark dark:text-white">Dashboard Administrator</h1>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Ringkasan metrik statistik dan aktivitas platform BISA.</p>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('admin.questions.create') }}" class="px-4 py-2 bg-bisa hover:bg-bisa-dark text-white text-xs font-bold rounded-xl transition shadow-md shadow-bisa/20">
                + Tambah Soal Baru
            </a>
            <a href="{{ route('admin.quizzes.create') }}" class="px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white text-xs font-bold rounded-xl transition shadow-md shadow-purple-600/20">
                + Buat Kuis Baru
            </a>
        </div>
    </div>

    {{-- Financial & Operations Banner --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-gradient-to-br from-emerald-600 to-teal-700 text-white p-5 rounded-2xl shadow-sm">
            <div class="text-[11px] font-bold uppercase tracking-wider text-emerald-100">Total Pendapatan</div>
            <div class="text-2xl font-black mt-1">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
            <div class="text-[10px] text-emerald-100/80 mt-1">Akumulasi langganan</div>
        </div>

        <div class="bg-gradient-to-br from-bisa to-amber-600 text-white p-5 rounded-2xl shadow-sm">
            <div class="text-[11px] font-bold uppercase tracking-wider text-amber-100">Siswa Premium VIP</div>
            <div class="text-2xl font-black mt-1">{{ number_format($premiumUsers) }} Siswa</div>
            <div class="text-[10px] text-amber-100/80 mt-1">Akses penuh aktif</div>
        </div>

        <div class="bg-gradient-to-br from-blue-600 to-indigo-700 text-white p-5 rounded-2xl shadow-sm">
            <div class="text-[11px] font-bold uppercase tracking-wider text-blue-100">Event Tryout</div>
            <div class="text-2xl font-black mt-1">{{ $activeTryoutEvents }} Event</div>
            <div class="text-[10px] text-blue-100/80 mt-1">Berjalan & terjadwal</div>
        </div>

        <div class="bg-gradient-to-br from-purple-600 to-violet-700 text-white p-5 rounded-2xl shadow-sm">
            <div class="text-[11px] font-bold uppercase tracking-wider text-purple-100">Laporan & Tiket</div>
            <div class="text-2xl font-black mt-1">{{ $pendingTickets }} Tiket</div>
            <div class="text-[10px] text-purple-100/80 mt-1">Perlu respons admin</div>
        </div>
    </div>

    {{-- 6 Main Stat Cards --}}
    <div class="grid grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-4">
        <div class="bg-white dark:bg-[#161922] p-5 rounded-2xl border border-gray-200/80 dark:border-white/10 shadow-sm transition hover:-translate-y-1 duration-200">
            <div class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">Total User</div>
            <div class="text-2xl font-black text-charcoal-dark dark:text-white mt-1">{{ number_format($totalUsers) }}</div>
            <div class="text-[10px] text-gray-400 mt-1">Siswa terdaftar</div>
        </div>

        <div class="bg-white dark:bg-[#161922] p-5 rounded-2xl border border-gray-200/80 dark:border-white/10 shadow-sm transition hover:-translate-y-1 duration-200">
            <div class="text-[11px] font-bold text-success uppercase tracking-wider">User Aktif</div>
            <div class="text-2xl font-black text-success mt-1">{{ number_format($activeUsers) }}</div>
            <div class="text-[10px] text-gray-400 mt-1">30 hari terakhir</div>
        </div>

        <div class="bg-white dark:bg-[#161922] p-5 rounded-2xl border border-gray-200/80 dark:border-white/10 shadow-sm transition hover:-translate-y-1 duration-200">
            <div class="text-[11px] font-bold text-bisa uppercase tracking-wider">Total Soal</div>
            <div class="text-2xl font-black text-bisa mt-1">{{ number_format($totalQuestions) }}</div>
            <div class="text-[10px] text-gray-400 mt-1">Bank soal aktif</div>
        </div>

        <div class="bg-white dark:bg-[#161922] p-5 rounded-2xl border border-gray-200/80 dark:border-white/10 shadow-sm transition hover:-translate-y-1 duration-200">
            <div class="text-[11px] font-bold text-blue-600 dark:text-blue-400 uppercase tracking-wider">Total Latihan</div>
            <div class="text-2xl font-black text-blue-600 dark:text-blue-400 mt-1">{{ number_format($totalPractices) }}</div>
            <div class="text-[10px] text-gray-400 mt-1">Sesi latihan siswa</div>
        </div>

        <div class="bg-white dark:bg-[#161922] p-5 rounded-2xl border border-gray-200/80 dark:border-white/10 shadow-sm transition hover:-translate-y-1 duration-200">
            <div class="text-[11px] font-bold text-purple-600 dark:text-purple-400 uppercase tracking-wider">Total Kuis</div>
            <div class="text-2xl font-black text-purple-600 dark:text-purple-400 mt-1">{{ number_format($totalQuizzes) }}</div>
            <div class="text-[10px] text-gray-400 mt-1">Kuis dikerjakan</div>
        </div>

        <div class="bg-white dark:bg-[#161922] p-5 rounded-2xl border border-gray-200/80 dark:border-white/10 shadow-sm transition hover:-translate-y-1 duration-200">
            <div class="text-[11px] font-bold text-emerald-600 dark:text-emerald-400 uppercase tracking-wider">Total Tryout</div>
            <div class="text-2xl font-black text-emerald-600 dark:text-emerald-400 mt-1">{{ number_format($totalTryouts) }}</div>
            <div class="text-[10px] text-gray-400 mt-1">Simulasi selesai</div>
        </div>
    </div>

    {{-- Activity and User Tables Grid --}}
    <div class="grid lg:grid-cols-2 gap-8">
        {{-- Latest Registered Students --}}
        <div class="bg-white dark:bg-[#161922] rounded-3xl p-6 border border-gray-200/80 dark:border-white/10 shadow-sm transition-colors duration-200">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-extrabold text-charcoal-dark dark:text-white uppercase tracking-wider">Siswa Terdaftar Terbaru</h3>
                <a href="{{ route('admin.users.index') }}" class="text-xs font-bold text-bisa hover:underline">Semua User →</a>
            </div>

            <div class="space-y-3">
                @forelse($latestUsers as $u)
                    <div class="flex items-center justify-between p-3 rounded-xl bg-gray-50 dark:bg-white/5 border border-gray-100 dark:border-white/5 text-xs">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-bisa-100 dark:bg-bisa-900/40 text-bisa font-bold flex items-center justify-center">
                                {{ strtoupper(substr($u->name, 0, 1)) }}
                            </div>
                            <div>
                                <div class="font-bold text-charcoal-dark dark:text-white">{{ $u->name }}</div>
                                <div class="text-[11px] text-gray-400">{{ $u->email }}</div>
                            </div>
                        </div>
                        <div class="text-[11px] text-gray-400">
                            {{ $u->created_at->format('d M Y') }}
                        </div>
                    </div>
                @empty
                    <p class="text-xs text-gray-400 text-center py-4">Belum ada data siswa.</p>
                @endforelse
            </div>
        </div>

        {{-- Latest Attempts --}}
        <div class="bg-white dark:bg-[#161922] rounded-3xl p-6 border border-gray-200/80 dark:border-white/10 shadow-sm transition-colors duration-200">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-extrabold text-charcoal-dark dark:text-white uppercase tracking-wider">Aktivitas Pengerjaan Terbaru</h3>
                <span class="text-xs text-gray-400">Live feed</span>
            </div>

            <div class="space-y-3">
                @forelse($latestAttempts as $att)
                    <div class="flex items-center justify-between p-3 rounded-xl bg-gray-50 dark:bg-white/5 border border-gray-100 dark:border-white/5 text-xs">
                        <div>
                            <div class="font-bold text-charcoal-dark dark:text-white">
                                {{ $att->user ? $att->user->name : 'Siswa' }}
                            </div>
                            <div class="text-[11px] text-gray-400">
                                {{ $att->quiz ? $att->quiz->title : ($att->subject ? $att->subject->name : 'Latihan') }} • {{ ucfirst($att->type) }}
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="font-black text-sm {{ $att->score >= 70 ? 'text-success' : 'text-bisa' }}">
                                Skor: {{ number_format($att->score, 0) }}
                            </div>
                            <div class="text-[10px] text-gray-400">{{ $att->created_at->diffForHumans() }}</div>
                        </div>
                    </div>
                @empty
                    <p class="text-xs text-gray-400 text-center py-4">Belum ada aktivitas pengerjaan.</p>
                @endforelse
            </div>
        </div>
    </div>

</div>
@endsection
