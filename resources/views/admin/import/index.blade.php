@extends('layouts.admin')

@section('title', 'Import Soal Excel — BISA')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-black text-charcoal-dark">Import Soal Massal (Excel / CSV)</h1>
            <p class="text-xs text-gray-500 mt-1">Unggah file spreadsheet untuk memasukkan puluhan hingga ratusan soal sekaligus.</p>
        </div>
        <a href="{{ route('admin.questions.index') }}" class="text-xs font-bold text-gray-500 hover:text-charcoal">
            ← Bank Soal
        </a>
    </div>

    {{-- Error Reporting per line if validation failed (Section 14 requirement) --}}
    @if(session('import_errors'))
        <div class="p-6 bg-danger-light border-2 border-danger/30 rounded-3xl text-xs text-danger-900 space-y-3">
            <div class="flex items-center gap-2 font-black text-sm text-danger">
                <span>⚠️</span>
                <span>Terjadi Kesalahan Validasi Data Import:</span>
            </div>
            <p class="text-gray-600">Sistem membatalkan import secara otomatis agar tidak ada data korup yang masuk ke database. Harap perbaiki baris-baris berikut pada file Anda:</p>
            <div class="max-h-60 overflow-y-auto space-y-1.5 p-3 bg-white rounded-2xl border border-danger/20 font-mono text-[11px]">
                @foreach(session('import_errors') as $err)
                    <div class="flex items-start gap-2 text-danger">
                        <span>•</span>
                        <span>{{ $err }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    {{-- Template Download Card --}}
    <div class="bg-gradient-to-r from-bisa-50 to-gold-light p-6 rounded-3xl border border-bisa-200/60 flex flex-col sm:flex-row items-center justify-between gap-4">
        <div>
            <h3 class="font-extrabold text-sm text-charcoal-dark">Unduh Format Template Import</h3>
            <p class="text-xs text-gray-600 mt-0.5">Gunakan format kolom resmi agar data dapat divalidasi dengan lancar.</p>
        </div>
        <a href="{{ route('admin.import.template') }}" class="px-5 py-2.5 bg-bisa hover:bg-bisa-dark text-white font-bold text-xs rounded-xl transition shadow-sm flex items-center gap-2 shrink-0">
            <span>📥 Unduh Template CSV</span>
        </a>
    </div>

    {{-- Upload Form --}}
    <div class="bg-white rounded-3xl p-8 border border-gray-200/80 shadow-sm">
        <form action="{{ route('admin.import.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div>
                <label for="file" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-2">Pilih File Spreadsheet (.csv / .xlsx)</label>
                <input type="file" name="file" id="file" required accept=".csv,.xlsx,.txt"
                    class="w-full p-4 border-2 border-dashed border-gray-200 hover:border-bisa rounded-2xl cursor-pointer text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-bisa-100 file:text-bisa-800 hover:file:bg-bisa-200">
            </div>

            <div class="p-4 bg-gray-50 rounded-2xl text-[11px] text-gray-500 space-y-2">
                <div class="font-bold text-charcoal-dark uppercase tracking-wider text-[10px]">Struktur Kolom Template:</div>
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-2 font-mono text-[10px]">
                    <span class="bg-white p-1 rounded border">category</span>
                    <span class="bg-white p-1 rounded border">subject</span>
                    <span class="bg-white p-1 rounded border">question</span>
                    <span class="bg-white p-1 rounded border">option_a</span>
                    <span class="bg-white p-1 rounded border">option_b</span>
                    <span class="bg-white p-1 rounded border">option_c</span>
                    <span class="bg-white p-1 rounded border">option_d</span>
                    <span class="bg-white p-1 rounded border">option_e</span>
                    <span class="bg-white p-1 rounded border text-bisa font-bold">correct_answer</span>
                    <span class="bg-white p-1 rounded border">explanation</span>
                    <span class="bg-white p-1 rounded border">difficulty</span>
                </div>
            </div>

            <div class="pt-4 border-t border-gray-100 flex justify-end gap-3">
                <a href="{{ route('admin.questions.index') }}" class="px-5 py-2.5 rounded-xl border border-gray-200 text-xs font-bold text-gray-600 hover:bg-gray-50">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-bisa hover:bg-bisa-dark text-white text-xs font-bold transition shadow-sm flex items-center gap-2">
                    <span>Mulai Proses Import</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

