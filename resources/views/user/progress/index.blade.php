@extends('layouts.app')

@section('title', 'Perkembangan Belajar Saya — BISA')

@section('content')
<div class="bg-gray-50 min-h-screen py-10">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Header Banner --}}
        <div class="bg-white rounded-3xl p-8 border border-gray-100 shadow-sm mb-8 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-bisa-100 text-bisa-800 rounded-full text-xs font-bold uppercase tracking-wider mb-2">
                    📈 Progress Tracking
                </span>
                <h1 class="text-3xl font-black text-charcoal-dark">Perkembangan Belajar Saya</h1>
                <p class="text-sm text-gray-500 mt-1 max-w-xl">
                    Pantau target, lihat akumulasi pengerjaan soal, dan evaluasi subtes yang perlu diperkuat.
                </p>
            </div>
            <a href="{{ route('map.show') }}" class="px-5 py-2.5 bg-bisa hover:bg-bisa-dark text-white text-xs font-bold rounded-xl transition shadow-sm flex items-center gap-2 self-start md:self-auto">
                <span>🗺️ Lanjut ke Peta Belajar</span>
            </a>
        </div>

        <div class="grid lg:grid-cols-3 gap-8">

            {{-- Left 2 cols: Progress bars and mastery cards --}}
            <div class="lg:col-span-2 space-y-8">

                {{-- Category Progress Bars --}}
                <div class="bg-white rounded-3xl p-6 sm:p-8 border border-gray-100 shadow-sm">
                    <h3 class="text-base font-extrabold text-charcoal-dark uppercase tracking-wider mb-6">
                        Progress Kategori Persiapan
                    </h3>

                    <div class="space-y-6">
                        @foreach($categoryProgress as $slug => $data)
                            <div>
                                <div class="flex items-center justify-between text-xs mb-2">
                                    <span class="font-extrabold text-charcoal-dark text-sm">{{ $data['name'] }}</span>
                                    <span class="font-black text-bisa text-sm">{{ $data['percentage'] }}%</span>
                                </div>
                                <div class="w-full h-3.5 bg-gray-100 rounded-full overflow-hidden p-0.5">
                                    <div class="h-full rounded-full transition-all duration-1000
                                        {{ $slug === 'tka' ? 'bg-bisa' : ($slug === 'snbt' ? 'bg-gold' : 'bg-info') }}
                                    " style="width: {{ max(4, $data['percentage']) }}%"></div>
                                </div>
                                <div class="text-[11px] text-gray-400 mt-1.5 flex justify-between">
                                    <span>Tingkat Penguasaan</span>
                                    <span>{{ $data['completed'] }} dari {{ max(1, $data['total']) }} level selesai</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Subject Mastery Analysis (Paling Dikuasai vs Perlu Ditingkatkan) --}}
                <div class="grid sm:grid-cols-2 gap-4">
                    {{-- Most Mastered --}}
                    <div class="bg-white rounded-3xl p-6 border border-emerald-100 shadow-sm relative overflow-hidden">
                        <div class="flex items-center gap-2 text-xs font-bold text-success uppercase tracking-wider mb-2">
                            <span>🏆</span> Paling Dikuasai
                        </div>
                        @if($strongestSubject)
                            <h4 class="text-lg font-black text-charcoal-dark mb-1">
                                {{ $strongestSubject->subject ? $strongestSubject->subject->name : 'Subtes Pilihan' }}
                            </h4>
                            <p class="text-xs text-gray-500 mb-3">Rata-rata Skor: <strong class="text-success text-sm">{{ number_format($strongestSubject->avg_score, 1) }}</strong></p>
                            <span class="text-[11px] text-gray-400">{{ $strongestSubject->total_attempts }} kali dikerjakan</span>
                        @else
                            <p class="text-xs text-gray-400">Kerjakan latihan untuk melihat subtes terkuatmu.</p>
                        @endif
                    </div>

                    {{-- Needs Improvement --}}
                    <div class="bg-white rounded-3xl p-6 border border-amber-100 shadow-sm relative overflow-hidden">
                        <div class="flex items-center gap-2 text-xs font-bold text-amber-700 uppercase tracking-wider mb-2">
                            <span>⚡</span> Perlu Ditingkatkan
                        </div>
                        @if($weakestSubject)
                            <h4 class="text-lg font-black text-charcoal-dark mb-1">
                                {{ $weakestSubject->subject ? $weakestSubject->subject->name : 'Subtes Evaluasi' }}
                            </h4>
                            <p class="text-xs text-gray-500 mb-3">Rata-rata Skor: <strong class="text-amber-600 text-sm">{{ number_format($weakestSubject->avg_score, 1) }}</strong></p>
                            <a href="{{ route('practice.start', $weakestSubject->subject_id) }}" class="text-[11px] font-bold text-bisa hover:underline">
                                Latih subtes ini lagi →
                            </a>
                        @else
                            <p class="text-xs text-gray-400">Belum cukup data analisis.</p>
                        @endif
                    </div>
                </div>

                {{-- Tabs: Riwayat Latihan vs Riwayat Kuis --}}
                <div class="bg-white rounded-3xl p-6 sm:p-8 border border-gray-100 shadow-sm">
                    <h3 class="text-base font-extrabold text-charcoal-dark uppercase tracking-wider mb-6">
                        Riwayat Aktivitas
                    </h3>

                    <div class="space-y-6">
                        <div>
                            <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">Latihan Terakhir</h4>
                            @if($practiceHistory->isEmpty())
                                <p class="text-xs text-gray-400">Belum ada riwayat latihan.</p>
                            @else
                                <div class="space-y-2">
                                    @foreach($practiceHistory as $p)
                                        <div class="flex items-center justify-between p-3 rounded-xl bg-gray-50 text-xs">
                                            <span class="font-bold text-charcoal-dark">{{ $p->subject ? $p->subject->name : 'Latihan Mandiri' }}</span>
                                            <div class="flex items-center gap-4">
                                                <span class="text-gray-400">{{ $p->created_at->diffForHumans() }}</span>
                                                <span class="font-bold text-success">{{ number_format($p->score, 0) }} Poin</span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        <div class="pt-4 border-t border-gray-100">
                            <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">Kuis & Tryout Terakhir</h4>
                            @if($quizHistory->isEmpty())
                                <p class="text-xs text-gray-400">Belum ada riwayat kuis.</p>
                            @else
                                <div class="space-y-2">
                                    @foreach($quizHistory as $q)
                                        <div class="flex items-center justify-between p-3 rounded-xl bg-gray-50 text-xs">
                                            <span class="font-bold text-charcoal-dark">{{ $q->quiz ? $q->quiz->title : 'Kuis' }}</span>
                                            <div class="flex items-center gap-4">
                                                <span class="text-gray-400">{{ $q->created_at->diffForHumans() }}</span>
                                                <span class="font-bold text-purple-700">{{ number_format($q->score, 0) }} Poin</span>
                                                <a href="{{ route('results.show', $q->id) }}" class="text-bisa font-bold hover:underline">Review</a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

            </div>

            {{-- Right col: Overall metrics overview --}}
            <div class="space-y-6">
                <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm">
                    <h3 class="text-xs font-extrabold text-charcoal-dark uppercase tracking-wider mb-6">Akumulasi Belajar</h3>

                    <div class="space-y-4">
                        <div class="flex items-center justify-between p-3.5 rounded-2xl bg-bisa-50">
                            <span class="text-xs font-semibold text-charcoal">Total Soal Dijawab</span>
                            <span class="text-lg font-black text-bisa">{{ $totalQuestions }}</span>
                        </div>

                        <div class="flex items-center justify-between p-3.5 rounded-2xl bg-success-light">
                            <span class="text-xs font-semibold text-charcoal">Jawaban Benar</span>
                            <span class="text-lg font-black text-success">{{ $totalCorrect }}</span>
                        </div>

                        <div class="flex items-center justify-between p-3.5 rounded-2xl bg-danger-light">
                            <span class="text-xs font-semibold text-charcoal">Jawaban Salah</span>
                            <span class="text-lg font-black text-danger">{{ $totalIncorrect }}</span>
                        </div>

                        <div class="flex items-center justify-between p-3.5 rounded-2xl bg-purple-50">
                            <span class="text-xs font-semibold text-charcoal">Kuis Selesai</span>
                            <span class="text-lg font-black text-purple-700">{{ $totalQuizzes }}</span>
                        </div>

                        <div class="flex items-center justify-between p-3.5 rounded-2xl bg-emerald-50">
                            <span class="text-xs font-semibold text-charcoal">Tryout Diikuti</span>
                            <span class="text-lg font-black text-emerald-700">{{ $totalTryouts }}</span>
                        </div>

                        <div class="flex items-center justify-between p-3.5 rounded-2xl bg-gray-50 border border-gray-100">
                            <span class="text-xs font-semibold text-charcoal">Rata-Rata Nilai</span>
                            <span class="text-lg font-black text-charcoal-dark">{{ number_format($avgScore, 1) }}</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

