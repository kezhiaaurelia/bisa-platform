<footer class="bg-charcoal-dark dark:bg-[#0A0C11] text-white border-t border-white/5 transition-colors duration-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10">
            {{-- Brand --}}
            <div class="lg:col-span-1">
                <div class="flex items-center gap-2 mb-4">
                    <img src="{{ asset('images/logo-icon.png') }}" alt="BISA" class="h-9 w-9">
                    <span class="text-xl font-black tracking-tight">BiSA</span>
                </div>
                <p class="text-gray-400 text-xs leading-relaxed mb-4">
                    <strong>Belajar Intensif dan Simulasi Akademik</strong> — Platform edtech persiapan masuk perguruan tinggi berbasis visual peta petualangan belajar, drill soal adaptif, dan simulasi tryout untuk siswa SMA/SMK se-Indonesia.
                </p>
                <div class="flex items-center gap-2 text-xs text-bisa font-semibold">
                    <i class="bi bi-patch-check-fill text-sm"></i>
                    <span>Sesuai Standar Silabus BPPP & SNPMB</span>
                </div>
            </div>

            {{-- Program Jalur --}}
            <div>
                <h4 class="font-bold text-xs uppercase tracking-wider text-gray-300 mb-4 flex items-center gap-2">
                    <i class="bi bi-mortarboard-fill text-bisa"></i> Program Belajar
                </h4>
                <ul class="space-y-2.5 text-xs text-gray-400">
                    <li><a href="{{ route('map.show', ['categorySlug' => 'snbt']) }}" class="hover:text-bisa transition flex items-center gap-1.5"><i class="bi bi-chevron-right text-[10px]"></i> Persiapan SNBT Terpadu</a></li>
                    <li><a href="{{ route('map.show', ['categorySlug' => 'tka']) }}" class="hover:text-bisa transition flex items-center gap-1.5"><i class="bi bi-chevron-right text-[10px]"></i> Persiapan TKA Mandiri</a></li>
                    <li><a href="{{ route('map.show', ['categorySlug' => 'utbk']) }}" class="hover:text-bisa transition flex items-center gap-1.5"><i class="bi bi-chevron-right text-[10px]"></i> Drill Soal UTBK Realistis</a></li>
                    <li><a href="{{ route('tryouts.index') }}" class="hover:text-bisa transition flex items-center gap-1.5"><i class="bi bi-chevron-right text-[10px]"></i> Simulasi Tryout Nasional</a></li>
                </ul>
            </div>

            {{-- Fitur Belajar --}}
            <div>
                <h4 class="font-bold text-xs uppercase tracking-wider text-gray-300 mb-4 flex items-center gap-2">
                    <i class="bi bi-controller text-bisa"></i> Fitur & Metode
                </h4>
                <ul class="space-y-2.5 text-xs text-gray-400">
                    <li><a href="{{ route('practice.index') }}" class="hover:text-bisa transition flex items-center gap-1.5"><i class="bi bi-chevron-right text-[10px]"></i> Mode Latihan Santai</a></li>
                    <li><a href="{{ route('tryouts.index') }}" class="hover:text-bisa transition flex items-center gap-1.5"><i class="bi bi-chevron-right text-[10px]"></i> Mode Kuis Berwaktu</a></li>
                    <li><a href="{{ url('/#cara-belajar') }}" class="hover:text-bisa transition flex items-center gap-1.5"><i class="bi bi-chevron-right text-[10px]"></i> Modul & Ringkasan Rumus</a></li>
                    <li><a href="{{ route('dashboard') }}" class="hover:text-bisa transition flex items-center gap-1.5"><i class="bi bi-chevron-right text-[10px]"></i> Pelacak Progress & Streak</a></li>
                </ul>
            </div>

            {{-- BISA Community & Info --}}
            <div>
                <h4 class="font-bold text-xs uppercase tracking-wider text-gray-300 mb-4 flex items-center gap-2">
                    <i class="bi bi-info-circle-fill text-bisa"></i> Informasi
                </h4>
                <ul class="space-y-2.5 text-xs text-gray-400">
                    <li><a href="{{ url('/#tentang') }}" class="hover:text-bisa transition flex items-center gap-1.5"><i class="bi bi-chevron-right text-[10px]"></i> Tentang BISA</a></li>
                    <li><a href="{{ url('/#testimoni') }}" class="hover:text-bisa transition flex items-center gap-1.5"><i class="bi bi-chevron-right text-[10px]"></i> Cerita Sukses Siswa</a></li>
                    <li><a href="{{ route('register') }}" class="hover:text-bisa transition flex items-center gap-1.5"><i class="bi bi-chevron-right text-[10px]"></i> Daftar Akun Gratis</a></li>
                    <li><a href="{{ route('login') }}" class="hover:text-bisa transition flex items-center gap-1.5"><i class="bi bi-chevron-right text-[10px]"></i> Masuk ke Akun Siswa</a></li>
                </ul>
            </div>
        </div>

        <div class="border-t border-white/10 mt-12 pt-8 flex flex-col sm:flex-row justify-between items-center gap-4">
            <p class="text-xs text-gray-400">&copy; {{ date('Y') }} <strong>BISA (Belajar Intensif dan Simulasi Akademik)</strong>. Dibuat untuk pejuang perguruan tinggi Indonesia.</p>
            <div class="flex items-center gap-3">
                <a href="https://instagram.com" target="_blank" rel="noopener noreferrer" title="Instagram BISA" class="w-8 h-8 rounded-lg bg-white/5 hover:bg-bisa flex items-center justify-center text-gray-300 hover:text-white transition">
                    <i class="bi bi-instagram text-sm"></i>
                </a>
                <a href="https://youtube.com" target="_blank" rel="noopener noreferrer" title="YouTube BISA" class="w-8 h-8 rounded-lg bg-white/5 hover:bg-bisa flex items-center justify-center text-gray-300 hover:text-white transition">
                    <i class="bi bi-youtube text-sm"></i>
                </a>
                <a href="https://tiktok.com" target="_blank" rel="noopener noreferrer" title="TikTok BISA" class="w-8 h-8 rounded-lg bg-white/5 hover:bg-bisa flex items-center justify-center text-gray-300 hover:text-white transition">
                    <i class="bi bi-tiktok text-sm"></i>
                </a>
                <a href="https://twitter.com" target="_blank" rel="noopener noreferrer" title="X (Twitter) BISA" class="w-8 h-8 rounded-lg bg-white/5 hover:bg-bisa flex items-center justify-center text-gray-300 hover:text-white transition">
                    <i class="bi bi-twitter-x text-sm"></i>
                </a>
            </div>
        </div>
    </div>
</footer>

