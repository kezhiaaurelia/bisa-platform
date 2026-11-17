@extends('layouts.app')

@section('title', 'Daftar Kuis — BISA')

@section('content')
<div class="bg-gray-50 min-h-screen py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Header --}}
        <div class="bg-white rounded-3xl p-8 border border-gray-100 shadow-sm mb-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-purple-100 text-purple-800 rounded-full text-xs font-bold uppercase tracking-wider mb-2">
                    ⏱️ Mode Kuis
                </span>
                <h1 class="text-3xl font-black text-charcoal-dark">Kuis Berwaktu & Simulasi</h1>
                <p class="text-sm text-gray-500 mt-1 max-w-xl">
                    Uji kesiapanmu dengan batasan waktu nyata. Latih ketepatan dan manajemen waktu seperti saat ujian sesungguhnya.
                </p>
            </div>
            <a href="{{ route('map.show') }}" class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-charcoal text-xs font-bold rounded-xl transition flex items-center gap-2 self-start md:self-auto">
                <span>🗺️ Kembali ke Map</span>
            </a>
        </div>

        {{-- Quiz Cards Grid --}}
        @if($quizzes->isEmpty())
            <div class="bg-white rounded-3xl p-12 text-center border border-gray-100 shadow-sm">
                <div class="text-5xl mb-4">⏱️</div>
                <h3 class="text-lg font-bold text-charcoal">Belum Ada Kuis Tersedia</h3>
                <p class="text-sm text-gray-500 mt-1">Admin sedang menyiapkan paket kuis terbaru.</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($quizzes as $quiz)
                    <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm hover:border-bisa hover:shadow-md transition flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between gap-2 mb-3">
                                <span class="px-3 py-1 bg-purple-50 text-purple-700 text-[11px] font-bold rounded-lg uppercase">
                                    {{ $quiz->category ? $quiz->category->name : 'Kuis' }}
                                </span>
                                <span class="px-2.5 py-1 bg-amber-50 text-amber-700 text-[11px] font-semibold rounded-lg flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    {{ $quiz->duration_minutes }} Menit
                                </span>
                            </div>

                            <h3 class="text-lg font-bold text-charcoal-dark mb-2">
                                {{ $quiz->title }}
                            </h3>
                            <p class="text-xs text-gray-500 line-clamp-2 leading-relaxed mb-4">
                                {{ $quiz->description }}
                            </p>

                            <div class="flex items-center gap-4 text-xs text-gray-400 mb-6">
                                <div class="flex items-center gap-1">
                                    <span>📝</span>
                                    <span>{{ $quiz->questions_count }} Soal</span>
                                </div>
                                <div class="flex items-center gap-1">
                                    <span>🎯</span>
                                    <span>Passing: {{ $quiz->pass_percentage }}%</span>
                                </div>
                            </div>
                        </div>

                        <div class="pt-4 border-t border-gray-100">
                            <a href="{{ route('quiz.show', $quiz->id) }}"
                               class="w-full py-2.5 bg-purple-600 hover:bg-purple-700 text-white font-bold text-xs rounded-xl transition shadow-md shadow-purple-600/20 flex items-center justify-center gap-2">
                                <span>Ikuti Kuis</span>
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection

