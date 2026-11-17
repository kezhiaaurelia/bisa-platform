@extends('layouts.app')

@section('title', $quiz->title . ' — BISA')

@section('content')
<div class="bg-gray-50 min-h-screen py-12">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-3xl p-8 sm:p-10 border border-gray-100 shadow-sm">

            <div class="flex items-center gap-2 mb-4">
                <span class="px-3 py-1 bg-purple-100 text-purple-800 rounded-full text-xs font-bold uppercase tracking-wider">
                    ⏱️ Mode Kuis Berwaktu
                </span>
                @if($quiz->subject)
                    <span class="text-xs text-gray-500 font-semibold">• {{ $quiz->subject->name }}</span>
                @endif
            </div>

            <h1 class="text-3xl font-extrabold text-charcoal-dark mb-3">
                {{ $quiz->title }}
            </h1>

            <p class="text-sm text-gray-600 leading-relaxed mb-8">
                {{ $quiz->description ?? 'Kuis ini dirancang untuk mensimulasikan situasi ujian nyata dengan batasan waktu.' }}
            </p>

            {{-- Rules and Info Cards --}}
            <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 mb-8">
                <div class="p-4 rounded-2xl bg-gray-50 border border-gray-100 text-center">
                    <div class="text-xs text-gray-400 font-semibold uppercase mb-1">Durasi</div>
                    <div class="text-xl font-black text-charcoal-dark">{{ $quiz->duration_minutes }} Menit</div>
                </div>
                <div class="p-4 rounded-2xl bg-gray-50 border border-gray-100 text-center">
                    <div class="text-xs text-gray-400 font-semibold uppercase mb-1">Jumlah Soal</div>
                    <div class="text-xl font-black text-charcoal-dark">{{ $quiz->questions_count }} Soal</div>
                </div>
                <div class="p-4 rounded-2xl bg-gray-50 border border-gray-100 text-center col-span-2 sm:col-span-1">
                    <div class="text-xs text-gray-400 font-semibold uppercase mb-1">Target Nilai</div>
                    <div class="text-xl font-black text-bisa">{{ $quiz->pass_percentage }}%</div>
                </div>
            </div>

            {{-- Crucial instructions from Prompt Section 5 --}}
            <div class="bg-amber-50 rounded-2xl p-5 border border-amber-200/80 mb-8 space-y-2 text-xs text-amber-900 leading-relaxed">
                <div class="font-bold flex items-center gap-1.5 text-sm">
                    <span>⚠️</span> Perhatian Penting Pengerjaan Kuis:
                </div>
                <ul class="list-disc list-inside space-y-1.5 pl-1 text-gray-700">
                    <li>Timer akan langsung berjalan begitu kuis dimulai.</li>
                    <li><strong>Status benar atau salah TIDAK akan ditampilkan</strong> saat Anda menjawab soal.</li>
                    <li>Anda bebas berpindah ke soal manapun dan mengubah jawaban sebelum waktu berakhir.</li>
                    <li>Jika waktu habis, kuis akan <strong>otomatis tersubmit</strong> dan jawaban tersimpan.</li>
                    <li>Nilai dan pembahasan lengkap untuk setiap nomor akan terbuka di halaman hasil setelah kuis berakhir.</li>
                </ul>
            </div>

            {{-- Past attempt info if exists --}}
            @if($pastAttempts->isNotEmpty())
                <div class="mb-8 p-4 rounded-2xl bg-gray-50 border border-gray-100">
                    <div class="text-xs font-bold text-charcoal-dark mb-2">Riwayat Pengerjaan Terakhir Anda:</div>
                    <div class="flex items-center justify-between text-xs text-gray-600">
                        <span>Skor: <strong class="text-bisa text-sm">{{ number_format($pastAttempts->first()->score, 0) }}</strong> / 100</span>
                        <span>Benar: {{ $pastAttempts->first()->correct_answers }} soal</span>
                        <span>{{ $pastAttempts->first()->created_at->diffForHumans() }}</span>
                    </div>
                </div>
            @endif

            {{-- Start action --}}
            <div class="flex flex-col sm:flex-row items-center gap-4 pt-4 border-t border-gray-100">
                <a href="{{ route('quizzes.index') }}" class="w-full sm:w-auto px-6 py-3 rounded-xl border border-gray-200 text-xs font-bold text-gray-600 hover:bg-gray-50 text-center transition">
                    Kembali
                </a>
                <form action="{{ route('quiz.start', $quiz->id) }}" method="POST" class="w-full sm:flex-1">
                    @csrf
                    <button type="submit" class="w-full py-3.5 bg-purple-600 hover:bg-purple-700 text-white font-extrabold text-sm rounded-xl transition shadow-lg shadow-purple-600/25 flex items-center justify-center gap-2">
                        <span>{{ $existingAttempt ? 'Lanjutkan Kuis' : 'Mulai Kerjakan Kuis Sekarang' }}</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </button>
                </form>
            </div>

        </div>
    </div>
</div>
@endsection

