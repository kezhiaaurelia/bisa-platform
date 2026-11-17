@extends('layouts.admin')

@section('title', 'Buat Kuis / Tryout — BISA')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-black text-charcoal-dark">Buat Kuis / Tryout Baru</h1>
            <p class="text-xs text-gray-500 mt-1">Konfigurasikan durasi timer dan pilih soal yang diujikan.</p>
        </div>
        <a href="{{ route('admin.quizzes.index') }}" class="text-xs font-bold text-gray-500 hover:text-charcoal">
            ← Kembali
        </a>
    </div>

    @if ($errors->any())
        <div class="p-4 bg-danger-light border border-danger/20 rounded-2xl text-xs text-danger">
            <ul class="list-disc list-inside space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-3xl p-8 border border-gray-200/80 shadow-sm">
        <form action="{{ route('admin.quizzes.store') }}" method="POST" class="space-y-6">
            @csrf

            <div class="grid sm:grid-cols-3 gap-4">
                <div class="sm:col-span-2">
                    <label for="title" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1.5">Judul Kuis / Tryout</label>
                    <input id="title" type="text" name="title" value="{{ old('title') }}" required
                        placeholder="Contoh: Kuis Penalaran Analitis Bab 1"
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:border-bisa focus:ring-2 focus:ring-bisa/20 focus:outline-none">
                </div>

                <div>
                    <label for="type" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1.5">Tipe Ujian</label>
                    <select id="type" name="type" required
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:border-bisa focus:ring-2 focus:ring-bisa/20 focus:outline-none bg-white">
                        <option value="quiz" {{ old('type') === 'quiz' ? 'selected' : '' }}>Kuis Subtes</option>
                        <option value="tryout" {{ old('type') === 'tryout' ? 'selected' : '' }}>Simulasi Tryout Akbar</option>
                    </select>
                </div>
            </div>

            <div class="grid sm:grid-cols-2 gap-4">
                <div>
                    <label for="category_id" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1.5">Kategori Persiapan</label>
                    <select id="category_id" name="category_id"
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:border-bisa focus:ring-2 focus:ring-bisa/20 focus:outline-none bg-white">
                        <option value="">-- Semua / Umum --</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="subject_id" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1.5">Mata Pelajaran (Opsional)</label>
                    <select id="subject_id" name="subject_id"
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:border-bisa focus:ring-2 focus:ring-bisa/20 focus:outline-none bg-white">
                        <option value="">-- Semua / Multi Subtes --</option>
                        @foreach($subjects as $s)
                            <option value="{{ $s->id }}" {{ old('subject_id') == $s->id ? 'selected' : '' }}>
                                {{ $s->category ? $s->category->name . ' - ' : '' }}{{ $s->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Timer Section (Section 6 & 16 Requirements) --}}
            <div class="p-6 bg-purple-50/60 rounded-3xl border border-purple-200/80 space-y-4">
                <div class="flex items-center gap-2">
                    <span class="text-xl">⏱️</span>
                    <div>
                        <h4 class="font-bold text-sm text-purple-900">Konfigurasi Sistem Timer & Penilaian</h4>
                        <p class="text-xs text-purple-700">Durasi ditentukan secara manual oleh admin dalam menit (bukan otomatis dari jumlah soal).</p>
                    </div>
                </div>

                <div class="grid sm:grid-cols-3 gap-4 pt-2">
                    <div>
                        <label for="duration_minutes" class="block text-xs font-bold text-purple-900 uppercase tracking-wider mb-1.5">
                            Durasi Kuis (Menit)
                        </label>
                        <input id="duration_minutes" type="number" name="duration_minutes" value="{{ old('duration_minutes', 30) }}" min="1" max="300" required
                            class="w-full px-4 py-2.5 rounded-xl border border-purple-200 text-sm font-bold text-purple-900 bg-white focus:outline-none focus:ring-2 focus:ring-purple-400">
                        <span class="text-[10px] text-purple-600 mt-1 block">Contoh: 15, 30, 60 menit</span>
                    </div>

                    <div>
                        <label for="pass_percentage" class="block text-xs font-bold text-purple-900 uppercase tracking-wider mb-1.5">
                            Passing Grade (%)
                        </label>
                        <input id="pass_percentage" type="number" name="pass_percentage" value="{{ old('pass_percentage', 70) }}" min="1" max="100" required
                            class="w-full px-4 py-2.5 rounded-xl border border-purple-200 text-sm font-bold text-purple-900 bg-white focus:outline-none focus:ring-2 focus:ring-purple-400">
                    </div>

                    <div>
                        <label for="difficulty" class="block text-xs font-bold text-purple-900 uppercase tracking-wider mb-1.5">
                            Tingkat Kesulitan
                        </label>
                        <select id="difficulty" name="difficulty" required
                            class="w-full px-4 py-2.5 rounded-xl border border-purple-200 text-sm font-bold text-purple-900 bg-white focus:outline-none focus:ring-2 focus:ring-purple-400">
                            <option value="easy">Mudah (Easy)</option>
                            <option value="medium" selected>Sedang (Medium)</option>
                            <option value="hard">Sulit (Hard)</option>
                        </select>
                    </div>
                </div>
            </div>

            <div>
                <label for="description" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1.5">Petunjuk / Deskripsi Kuis</label>
                <textarea id="description" name="description" rows="3"
                    placeholder="Instruksi pengerjaan bagi siswa..."
                    class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:border-bisa focus:ring-2 focus:ring-bisa/20 focus:outline-none">{{ old('description') }}</textarea>
            </div>

            {{-- Select Questions --}}
            <div class="space-y-3 pt-2">
                <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider">Pilih Soal yang Diujikan</label>
                <p class="text-[11px] text-gray-400">Centang soal-soal di bawah ini yang ingin dimasukkan ke dalam paket kuis ini.</p>

                <div class="max-h-72 overflow-y-auto space-y-2 p-3 bg-gray-50 rounded-2xl border border-gray-200">
                    @forelse($questions as $q)
                        <label class="flex items-start gap-3 p-3 rounded-xl bg-white border border-gray-100 hover:border-bisa cursor-pointer text-xs">
                            <input type="checkbox" name="questions[]" value="{{ $q->id }}" class="mt-0.5 w-4 h-4 text-purple-600 rounded border-gray-300 focus:ring-purple-500">
                            <div class="flex-1 min-w-0">
                                <div class="font-bold text-charcoal-dark line-clamp-1">{{ $q->question_text }}</div>
                                <div class="text-[10px] text-gray-400 mt-0.5">
                                    {{ $q->subject ? $q->subject->name : 'Umum' }} • Kesulitan: {{ ucfirst($q->difficulty) }}
                                </div>
                            </div>
                        </label>
                    @empty
                        <p class="text-xs text-gray-400 text-center py-4">Belum ada soal tersedia. Tambahkan soal terlebih dahulu.</p>
                    @endforelse
                </div>
            </div>

            <div class="pt-2">
                <label class="flex items-center gap-2 cursor-pointer select-none text-sm text-gray-700">
                    <input type="checkbox" name="is_active" value="1" checked class="w-4 h-4 text-purple-600 rounded border-gray-300 focus:ring-purple-500">
                    <span>Aktifkan kuis ini agar dapat dikerjakan siswa</span>
                </label>
            </div>

            <div class="pt-6 border-t border-gray-100 flex justify-end gap-3">
                <a href="{{ route('admin.quizzes.index') }}" class="px-5 py-2.5 rounded-xl border border-gray-200 text-xs font-bold text-gray-600 hover:bg-gray-50">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-purple-600 hover:bg-purple-700 text-white text-xs font-bold transition shadow-sm">
                    Simpan Paket Kuis
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

