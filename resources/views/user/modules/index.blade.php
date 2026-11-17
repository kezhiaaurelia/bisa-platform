@extends('layouts.app')

@section('title', 'Modul Pembelajaran — BISA')

@section('content')
<div class="bg-gray-50 min-h-screen py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Header --}}
        <div class="bg-white rounded-3xl p-8 border border-gray-100 shadow-sm mb-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-bold uppercase tracking-wider mb-2">
                    📖 Modul Pembelajaran
                </span>
                <h1 class="text-3xl font-black text-charcoal-dark">Kumpulan Materi Terstruktur</h1>
                <p class="text-sm text-gray-500 mt-1 max-w-xl">
                    Pahami konsep teori dan rangkuman materi dari dasar hingga tingkat tinggi untuk persiapan ujian masuk PTN.
                </p>
            </div>
            <a href="{{ route('map.show') }}" class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-charcoal text-xs font-bold rounded-xl transition flex items-center gap-2 self-start md:self-auto">
                <span>🗺️ Kembali ke Map</span>
            </a>
        </div>

        <div class="space-y-12">
            @foreach($categories as $cat)
                <div>
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-8 h-8 rounded-lg bg-blue-600 text-white flex items-center justify-center font-bold text-xs">
                            {{ substr($cat->name, 0, 1) }}
                        </div>
                        <div>
                            <h2 class="text-xl font-black text-charcoal-dark">{{ $cat->name }}</h2>
                            <p class="text-xs text-gray-400">Modul subtes {{ $cat->name }}</p>
                        </div>
                    </div>

                    <div class="space-y-6">
                        @foreach($cat->subjects as $subj)
                            @if($subj->modules->isNotEmpty())
                                <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
                                    <h3 class="font-bold text-base text-charcoal-dark mb-4 flex items-center gap-2">
                                        <span class="w-2 h-2 rounded-full bg-blue-600"></span>
                                        {{ $subj->name }}
                                    </h3>

                                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                        @foreach($subj->modules as $mod)
                                            @php
                                                $isDone = in_array($mod->id, $completedModuleIds);
                                            @endphp

                                            <a href="{{ route('module.show', $mod->id) }}"
                                               class="p-4 rounded-xl border transition flex items-start gap-3 group
                                                    {{ $isDone ? 'border-success/30 bg-success-light/20 hover:border-success' : 'border-gray-100 bg-gray-50/50 hover:border-bisa hover:bg-white' }}
                                               ">
                                                <div class="w-8 h-8 rounded-lg flex items-center justify-center shrink-0 font-bold text-xs
                                                    {{ $isDone ? 'bg-success text-white' : 'bg-blue-100 text-blue-700' }}
                                                ">
                                                    @if($isDone)
                                                        ✓
                                                    @else
                                                        📖
                                                    @endif
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <h4 class="font-bold text-xs text-charcoal-dark group-hover:text-bisa transition line-clamp-1 mb-1">
                                                        {{ $mod->title }}
                                                    </h4>
                                                    <span class="text-[11px] text-gray-400">
                                                        ⏱️ {{ $mod->reading_time_minutes }} menit baca
                                                    </span>
                                                </div>
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection

