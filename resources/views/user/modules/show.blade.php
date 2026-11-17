@extends('layouts.app')

@section('title', $module->title . ' — Modul Belajar BISA')

@section('content')
<div class="bg-gray-50 min-h-screen py-10">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Breadcrumb & Back --}}
        <div class="mb-6 flex items-center justify-between text-xs">
            <div class="flex items-center gap-2 text-gray-500">
                <a href="{{ route('modules.index') }}" class="hover:underline">Modul</a>
                <span>/</span>
                <span class="text-gray-700 font-semibold">{{ $module->subject ? $module->subject->name : 'Materi' }}</span>
                <span>/</span>
                <span class="text-bisa font-bold line-clamp-1">{{ $module->title }}</span>
            </div>

            <a href="{{ route('modules.index') }}" class="text-xs font-bold text-gray-500 hover:text-charcoal">
                ← Kembali ke Daftar Modul
            </a>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 rounded-2xl bg-success-light border border-success/30 text-success-800 text-xs font-bold flex items-center gap-2">
                <span>🎉</span>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        {{-- Reader Card --}}
        <div class="bg-white rounded-3xl p-8 sm:p-12 border border-gray-100 shadow-sm mb-8">
            <div class="flex flex-wrap items-center gap-3 mb-4">
                <span class="px-3 py-1 bg-blue-100 text-blue-800 text-xs font-bold rounded-full uppercase">
                    {{ $module->subject ? $module->subject->name : 'Modul' }}
                </span>
                <span class="text-xs text-gray-400 font-medium">
                    ⏱️ Estimasi Baca: {{ $module->reading_time_minutes }} Menit
                </span>
                @if($isCompleted)
                    <span class="px-3 py-1 bg-success-light text-success text-xs font-bold rounded-full ml-auto">
                        ✓ Sudah Selesai
                    </span>
                @endif
            </div>

            <h1 class="text-2xl sm:text-3xl font-extrabold text-charcoal-dark mb-8 pb-6 border-b border-gray-100">
                {{ $module->title }}
            </h1>

            {{-- Module Body --}}
            <div class="prose max-w-none text-charcoal-dark leading-relaxed text-sm space-y-4">
                {!! nl2br(e($module->content)) !!}
            </div>

            {{-- Completion Action --}}
            <div class="mt-12 pt-8 border-t border-gray-100 flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="text-xs text-gray-500">
                    @if($isCompleted)
                        <span>Anda telah menyelesaikan modul ini.</span>
                    @else
                        <span>Sudah selesai membaca dan memahami materinya?</span>
                    @endif
                </div>

                @if(! $isCompleted)
                    <form action="{{ route('module.complete', $module->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="px-6 py-3 bg-success hover:bg-emerald-700 text-white text-xs font-bold rounded-xl transition shadow-md shadow-success/20 flex items-center gap-2">
                            <span>✓ Tandai Modul Selesai</span>
                        </button>
                    </form>
                @else
                    <a href="{{ route('map.show') }}" class="px-6 py-3 bg-bisa hover:bg-bisa-dark text-white text-xs font-bold rounded-xl transition shadow-sm flex items-center gap-2">
                        <span>🗺️ Lanjut ke Tantangan di Map</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </a>
                @endif
            </div>
        </div>

    </div>
</div>
@endsection

