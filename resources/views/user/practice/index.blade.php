@extends('layouts.app')

@section('title', 'Pilih Mata Pelajaran — Mode Latihan BISA')

@section('content')
<div class="bg-gray-50 min-h-screen py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Header --}}
        <div class="bg-white rounded-3xl p-8 border border-gray-100 shadow-sm mb-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-amber-100 text-amber-800 rounded-full text-xs font-bold uppercase tracking-wider mb-2">
                    ✍️ Mode Latihan Bebas
                </span>
                <h1 class="text-3xl font-black text-charcoal-dark">Pilih Mata Pelajaran / Subtes</h1>
                <p class="text-sm text-gray-500 mt-1 max-w-xl">
                    Kerjakan soal tanpa batas waktu, dapatkan feedback instan setelah memilih jawaban, dan pahami setiap konsep melalui pembahasan lengkap.
                </p>
            </div>
            <a href="{{ route('map.show') }}" class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-charcoal text-xs font-bold rounded-xl transition flex items-center gap-2 self-start md:self-auto">
                <span>🗺️ Kembali ke Map</span>
            </a>
        </div>

        {{-- Categories list --}}
        <div class="space-y-10">
            @foreach($categories as $cat)
                <div>
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-9 h-9 rounded-xl bg-bisa text-white flex items-center justify-center font-bold text-sm shadow-sm">
                            {{ substr($cat->name, 0, 1) }}
                        </div>
                        <div>
                            <h2 class="text-xl font-extrabold text-charcoal-dark">{{ $cat->name }}</h2>
                            <p class="text-xs text-gray-500">{{ $cat->description }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($cat->subjects as $subj)
                            <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:border-bisa hover:shadow-md transition group flex flex-col justify-between">
                                <div>
                                    <h3 class="font-bold text-charcoal-dark group-hover:text-bisa transition mb-1 text-base">
                                        {{ $subj->name }}
                                    </h3>
                                    <p class="text-xs text-gray-500 line-clamp-2 mb-4 leading-relaxed">
                                        {{ $subj->description }}
                                    </p>
                                </div>
                                <div class="pt-4 border-t border-gray-50 flex items-center justify-between">
                                    <a href="{{ route('map.show', ['categorySlug' => $cat->slug, 'subjectSlug' => $subj->slug]) }}"
                                       class="text-xs font-semibold text-gray-400 hover:text-charcoal transition">
                                        Lihat Map
                                    </a>
                                    <a href="{{ route('practice.start', $subj->id) }}"
                                       class="px-4 py-2 bg-bisa hover:bg-bisa-dark text-white rounded-xl text-xs font-bold transition shadow-sm flex items-center gap-1.5">
                                        <span>Mulai Latihan</span>
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection

