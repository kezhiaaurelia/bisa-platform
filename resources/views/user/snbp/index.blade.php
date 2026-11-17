@extends('layouts.app')

@section('title', 'Analisis & Rasionalisasi SNBP Rapor — BISA')

@section('content')
<div class="bg-gray-50 dark:bg-[#0E1017] min-h-screen py-10 transition-colors duration-200">
    <div class="max-w-4xl mx-auto px-4 sm:px-6">

        {{-- Top Card --}}
        <div class="bg-white dark:bg-[#161922] rounded-3xl p-6 sm:p-8 border border-gray-100 dark:border-white/10 shadow-sm mb-8 animate-fade-in-down">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-emerald-100 dark:bg-emerald-950/40 text-emerald-800 dark:text-emerald-300 rounded-full text-xs font-black uppercase tracking-wider mb-2">
                <i class="bi bi-graph-up-arrow"></i> Kalkulator Rasionalisasi SNBP
            </span>
            <h1 class="text-2xl sm:text-3xl font-black text-charcoal-dark dark:text-white">
                Analisis Peluang Nilai Rapor & KIP Kuliah
            </h1>
            <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-1 max-w-2xl leading-relaxed">
                Prediksi persentase kelulusanmu pada Seleksi Nasional Berdasarkan Prestasi (SNBP) menggunakan algoritma komparasi passing grade dan faktor akreditasi sekolah.
            </p>
        </div>

        {{-- Latest Analysis Result (if just submitted) --}}
        @if(session('analysis_result'))
            @php $res = session('analysis_result'); @endphp
            <div class="bg-gradient-to-br from-emerald-500 to-teal-700 text-white rounded-3xl p-6 sm:p-8 shadow-xl mb-8 animate-scale-in">
                <div class="flex items-center justify-between pb-4 border-b border-white/20 mb-4">
                    <span class="text-xs font-bold uppercase tracking-wider text-emerald-200">Hasil Analisis Peluang</span>
                    <span class="text-xs text-white/80">Baru Saja Dihitung</span>
                </div>
                <div class="grid sm:grid-cols-12 gap-6 items-center">
                    <div class="sm:col-span-4 text-center p-4 bg-white/10 rounded-2xl backdrop-blur-md">
                        <div class="text-4xl sm:text-5xl font-black">{{ $res->chance_percentage }}%</div>
                        <span class="text-xs font-bold text-emerald-100 mt-1 block">Estimasi Peluang Lolos</span>
                    </div>
                    <div class="sm:col-span-8 space-y-2">
                        <div class="text-base font-black">
                            {{ $res->target_major }} • {{ $res->target_ptn }}
                        </div>
                        <p class="text-xs text-emerald-50 leading-relaxed">
                            {{ $res->recommendation_text }}
                        </p>
                    </div>
                </div>
            </div>
        @endif

        {{-- Input Form --}}
        <div class="bg-white dark:bg-[#161922] rounded-3xl p-6 sm:p-8 border border-gray-100 dark:border-white/10 shadow-sm mb-10 animate-fade-in-up">
            <h2 class="text-base font-extrabold text-charcoal-dark dark:text-white mb-6 flex items-center gap-2">
                <i class="bi bi-calculator-fill text-bisa"></i>
                <span>Masukkan Data Nilai & Pilihan Jurusan</span>
            </h2>

            <form action="{{ route('snbp.calculate') }}" method="POST" class="space-y-6">
                @csrf

                <div class="grid sm:grid-cols-2 gap-6">
                    <div>
                        <label for="target_ptn" class="block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300 mb-1.5">
                            Target PTN <span class="text-danger">*</span>
                        </label>
                        <input type="text"
                               name="target_ptn"
                               id="target_ptn"
                               required
                               value="{{ old('target_ptn', $user->target_ptn) }}"
                               placeholder="Contoh: Universitas Indonesia (UI)"
                               class="w-full px-4 py-3 rounded-2xl border border-gray-200 dark:border-white/10 bg-gray-50 dark:bg-white/5 text-sm text-charcoal-dark dark:text-white focus:outline-none focus:border-bisa">
                    </div>

                    <div>
                        <label for="target_major" class="block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300 mb-1.5">
                            Target Program Studi / Jurusan <span class="text-danger">*</span>
                        </label>
                        <input type="text"
                               name="target_major"
                               id="target_major"
                               required
                               value="{{ old('target_major', $user->target_major) }}"
                               placeholder="Contoh: Pendidikan Dokter"
                               class="w-full px-4 py-3 rounded-2xl border border-gray-200 dark:border-white/10 bg-gray-50 dark:bg-white/5 text-sm text-charcoal-dark dark:text-white focus:outline-none focus:border-bisa">
                    </div>
                </div>

                <div class="grid sm:grid-cols-3 gap-6">
                    <div>
                        <label for="avg_report_score" class="block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300 mb-1.5">
                            Rata-Rata Rapor Sem 1-5 <span class="text-danger">*</span>
                        </label>
                        <input type="number"
                               step="0.01"
                               min="70"
                               max="100"
                               name="avg_report_score"
                               id="avg_report_score"
                               required
                               value="{{ old('avg_report_score', '88.50') }}"
                               placeholder="Contoh: 88.50"
                               class="w-full px-4 py-3 rounded-2xl border border-gray-200 dark:border-white/10 bg-gray-50 dark:bg-white/5 text-sm text-charcoal-dark dark:text-white focus:outline-none focus:border-bisa">
                    </div>

                    <div>
                        <label for="school_accreditation" class="block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300 mb-1.5">
                            Akreditasi Sekolah <span class="text-danger">*</span>
                        </label>
                        <select name="school_accreditation"
                                id="school_accreditation"
                                class="w-full px-4 py-3 rounded-2xl border border-gray-200 dark:border-white/10 bg-gray-50 dark:bg-white/5 text-sm text-charcoal-dark dark:text-white focus:outline-none focus:border-bisa">
                            <option value="A">Akreditasi A (Kuota 40%)</option>
                            <option value="B">Akreditasi B (Kuota 25%)</option>
                            <option value="C">Akreditasi C (Kuota 5%)</option>
                        </select>
                    </div>

                    <div>
                        <label for="rank_in_class" class="block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300 mb-1.5">
                            Peringkat Paralel <span class="text-gray-400 lowercase text-[10px]">(opsional)</span>
                        </label>
                        <input type="number"
                               name="rank_in_class"
                               id="rank_in_class"
                               placeholder="Contoh: 5"
                               class="w-full px-4 py-3 rounded-2xl border border-gray-200 dark:border-white/10 bg-gray-50 dark:bg-white/5 text-sm text-charcoal-dark dark:text-white focus:outline-none focus:border-bisa">
                    </div>
                </div>

                <button type="submit"
                        class="w-full py-4 bg-bisa hover:bg-bisa-dark text-white font-extrabold text-sm rounded-2xl shadow-md transition flex items-center justify-center gap-2">
                    <i class="bi bi-cpu-fill"></i>
                    <span>Hitung Rasionalisasi Peluang SNBP Sekarang</span>
                </button>
            </form>
        </div>

        {{-- Previous Analyses History --}}
        @if($analyses->isNotEmpty())
            <div class="bg-white dark:bg-[#161922] rounded-3xl p-6 sm:p-8 border border-gray-100 dark:border-white/10 shadow-sm">
                <h3 class="text-sm font-extrabold text-charcoal-dark dark:text-white mb-4 flex items-center gap-2">
                    <i class="bi bi-clock-history text-bisa"></i>
                    <span>Riwayat Analisis Tersimpan</span>
                </h3>

                <div class="space-y-3">
                    @foreach($analyses as $item)
                        <div class="p-4 rounded-2xl bg-gray-50 dark:bg-white/5 border border-gray-100 dark:border-white/5 flex flex-wrap items-center justify-between gap-4">
                            <div>
                                <div class="font-extrabold text-xs text-charcoal-dark dark:text-white">
                                    {{ $item->target_major }} — {{ $item->target_ptn }}
                                </div>
                                <span class="text-[11px] text-gray-400">Nilai Rapor: {{ number_format($item->avg_report_score, 1) }} • {{ $item->created_at->format('d M Y') }}</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <span class="px-3 py-1 rounded-full text-xs font-black
                                    {{ $item->chance_percentage >= 70 ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-950/40 dark:text-emerald-300' : 'bg-amber-100 text-amber-800 dark:bg-amber-950/40 dark:text-amber-300' }}
                                ">
                                    Peluang {{ $item->chance_percentage }}%
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

    </div>
</div>
@endsection

