<nav x-data="{ mobileOpen: false, scrolled: false }"
     @scroll.window="scrolled = (window.pageYOffset > 10)"
     :class="scrolled ? 'bg-white/95 dark:bg-[#121520]/95 backdrop-blur-md shadow-sm border-gray-200/60 dark:border-white/10' : 'bg-white/80 dark:bg-[#121520]/80 backdrop-blur-sm border-gray-100 dark:border-white/5'"
     class="border-b sticky top-0 z-50 transition-all duration-300 animate-fade-in-down">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between transition-all duration-300" :class="scrolled ? 'h-14' : 'h-16'">
            {{-- Logo --}}
            <a href="{{ url('/') }}" class="flex items-center gap-2.5 shrink-0 group">
                <img src="{{ asset('images/logo-icon.png') }}" alt="BISA" class="h-9 w-9 transition-transform group-hover:scale-105 duration-200">
                <span class="text-xl font-black text-charcoal-dark dark:text-white tracking-tight">BiSA</span>
                <span class="hidden sm:inline-flex items-center px-2 py-0.5 text-[10px] font-extrabold bg-bisa-100 dark:bg-bisa-900/40 text-bisa-700 dark:text-bisa-300 rounded-full border border-bisa/20">EDTECH</span>
            </a>

            {{-- Desktop Nav --}}
            <div class="hidden md:flex items-center gap-1 text-sm font-semibold text-gray-700 dark:text-gray-200">
                <a href="{{ url('/') }}" class="px-3.5 py-2 rounded-xl hover:text-bisa hover:bg-bisa-50 dark:hover:bg-white/5 transition">Beranda</a>

                {{-- Belajar Dropdown (TKA, SNBT, UTBK) --}}
                <div x-data="{ open: false }" @click.outside="open = false" class="relative">
                    <button @click="open = !open"
                            type="button"
                            class="px-3.5 py-2 rounded-xl hover:text-bisa hover:bg-bisa-50 dark:hover:bg-white/5 transition inline-flex items-center gap-1 focus:outline-none">
                        <span>Belajar</span>
                        <svg class="w-4 h-4 transition-transform duration-200" :class="open ? 'rotate-180 text-bisa' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div x-show="open"
                         x-cloak
                         x-transition:enter="transition ease-out duration-150"
                         x-transition:enter-start="opacity-0 scale-95 -translate-y-1"
                         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-100"
                         x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                         x-transition:leave-end="opacity-0 scale-95 -translate-y-1"
                         class="absolute top-full left-0 mt-1 w-64 bg-white dark:bg-[#1A1E27] rounded-2xl shadow-xl dark:shadow-2xl border border-gray-100 dark:border-white/10 py-2.5 z-50">
                        <a href="{{ route('map.show', ['categorySlug' => 'tka']) }}" @click="open = false" class="flex items-center gap-3 px-4 py-2.5 hover:bg-bisa-50 dark:hover:bg-white/5 hover:text-bisa transition">
                            <span class="w-8 h-8 rounded-xl bg-orange-100 text-orange-700 dark:bg-orange-950/40 dark:text-orange-300 flex items-center justify-center shrink-0">
                                <i class="bi bi-book-half text-sm"></i>
                            </span>
                            <div>
                                <span class="font-extrabold text-charcoal-dark dark:text-white block text-xs">TKA</span>
                                <span class="text-[11px] text-gray-400 dark:text-gray-400 font-normal">Tes Kemampuan Akademik</span>
                            </div>
                        </a>
                        <a href="{{ route('map.show', ['categorySlug' => 'snbt']) }}" @click="open = false" class="flex items-center gap-3 px-4 py-2.5 hover:bg-bisa-50 dark:hover:bg-white/5 hover:text-bisa transition">
                            <span class="w-8 h-8 rounded-xl bg-amber-100 text-amber-700 dark:bg-amber-950/40 dark:text-amber-300 flex items-center justify-center shrink-0">
                                <i class="bi bi-bullseye text-sm"></i>
                            </span>
                            <div class="flex-1">
                                <div class="flex items-center justify-between">
                                    <span class="font-extrabold text-charcoal-dark dark:text-white text-xs">SNBT</span>
                                    <span class="text-[9px] font-bold px-1.5 py-0.2 rounded bg-bisa/20 text-bisa uppercase">Populer</span>
                                </div>
                                <span class="text-[11px] text-gray-400 dark:text-gray-400 font-normal">Seleksi Nasional Berbasis Tes</span>
                            </div>
                        </a>
                        <a href="{{ route('map.show', ['categorySlug' => 'utbk']) }}" @click="open = false" class="flex items-center gap-3 px-4 py-2.5 hover:bg-bisa-50 dark:hover:bg-white/5 hover:text-bisa transition">
                            <span class="w-8 h-8 rounded-xl bg-blue-100 text-blue-700 dark:bg-blue-950/40 dark:text-blue-300 flex items-center justify-center shrink-0">
                                <i class="bi bi-trophy-fill text-sm"></i>
                            </span>
                            <div>
                                <span class="font-extrabold text-charcoal-dark dark:text-white block text-xs">UTBK</span>
                                <span class="text-[11px] text-gray-400 dark:text-gray-400 font-normal">Ujian Tulis Berbasis Komputer</span>
                            </div>
                        </a>
                    </div>
                </div>

                <a href="{{ route('practice.index') }}" class="px-3 py-2 rounded-xl hover:text-bisa hover:bg-bisa-50 dark:hover:bg-white/5 transition">Latihan</a>
                <a href="{{ route('tryouts.index') }}" class="px-3 py-2 rounded-xl hover:text-bisa hover:bg-bisa-50 dark:hover:bg-white/5 transition">Tryout</a>
                <a href="{{ route('modules.index') }}" class="px-3 py-2 rounded-xl hover:text-bisa hover:bg-bisa-50 dark:hover:bg-white/5 transition">Modul</a>
                <a href="{{ route('live-classes.index') }}" class="px-3 py-2 rounded-xl hover:text-bisa hover:bg-bisa-50 dark:hover:bg-white/5 transition">Kelas Live</a>
                <a href="{{ route('kakai.index') }}" class="px-3 py-2 rounded-xl text-bisa hover:bg-bisa-50 dark:hover:bg-white/5 font-extrabold transition flex items-center gap-1.5">
                    <i class="bi bi-robot"></i>
                    <span>KakAI</span>
                </a>
                <a href="{{ route('snbp.index') }}" class="px-3 py-2 rounded-xl hover:text-bisa hover:bg-bisa-50 dark:hover:bg-white/5 transition">SNBP</a>
                <a href="{{ route('pricing.index') }}" class="px-3 py-2 rounded-xl text-amber-600 dark:text-amber-400 hover:bg-amber-50 dark:hover:bg-white/5 font-bold transition flex items-center gap-1">
                    <i class="bi bi-star-fill text-[10px]"></i>
                    <span>Premium</span>
                </a>
            </div>

            {{-- Controls: Theme Toggle & Auth Buttons --}}
            <div class="hidden md:flex items-center gap-2.5">
                {{-- Theme Toggle Button --}}
                <button @click="$store.theme.toggle()"
                        type="button"
                        title="Ganti Tema (Gelap/Terang)"
                        class="p-2.5 rounded-xl text-gray-600 dark:text-yellow-400 hover:bg-gray-100 dark:hover:bg-white/10 transition focus:outline-none flex items-center justify-center transform active:scale-95">
                    <template x-if="!$store.theme.dark">
                        <i class="bi bi-moon-stars text-base text-gray-700"></i>
                    </template>
                    <template x-if="$store.theme.dark">
                        <i class="bi bi-sun-fill text-base text-yellow-400"></i>
                    </template>
                </button>

                @auth
                    <div x-data="{ open: false }" @click.outside="open = false" class="relative">
                        <button @click="open = !open"
                                type="button"
                                class="flex items-center gap-2.5 px-3 py-1.5 rounded-xl hover:bg-gray-50 dark:hover:bg-white/5 border border-gray-200 dark:border-white/10 transition focus:outline-none">
                            <div class="w-7 h-7 bg-bisa text-white rounded-lg flex items-center justify-center font-black text-xs">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                            <span class="text-xs font-bold text-charcoal-dark dark:text-white">{{ auth()->user()->name }}</span>
                            <svg class="w-3.5 h-3.5 text-gray-400 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </button>
                        <div x-show="open"
                             x-cloak
                             x-transition:enter="transition ease-out duration-150"
                             x-transition:enter-start="opacity-0 scale-95 -translate-y-1"
                             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-100"
                             x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                             x-transition:leave-end="opacity-0 scale-95 -translate-y-1"
                             class="absolute right-0 top-full mt-2 w-52 bg-white dark:bg-[#1A1E27] rounded-2xl shadow-xl dark:shadow-2xl border border-gray-100 dark:border-white/10 py-2 z-50 text-xs">
                            @if(auth()->user()->isAdmin())
                                <a href="{{ route('admin.dashboard') }}" @click="open = false" class="block px-4 py-2 font-bold text-purple-700 dark:text-purple-300 hover:bg-purple-50 dark:hover:bg-purple-950/30">
                                    ⚙️ Dashboard Admin
                                </a>
                                <hr class="my-1 border-gray-100 dark:border-white/10">
                            @endif
                            <a href="{{ route('dashboard') }}" @click="open = false" class="block px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-bisa-50 dark:hover:bg-white/5 hover:text-bisa font-semibold">Dashboard Siswa</a>
                            <a href="{{ route('map.show') }}" @click="open = false" class="block px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-bisa-50 dark:hover:bg-white/5 hover:text-bisa font-semibold">🗺️ Peta Belajar</a>
                            <a href="{{ route('progress.index') }}" @click="open = false" class="block px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-bisa-50 dark:hover:bg-white/5 hover:text-bisa font-semibold">📈 Progress Saya</a>
                            <a href="{{ route('profile.show') }}" @click="open = false" class="block px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-bisa-50 dark:hover:bg-white/5 hover:text-bisa font-semibold">🎯 Target & Profil</a>
                            <a href="{{ route('ambassador.index') }}" @click="open = false" class="block px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-bisa-50 dark:hover:bg-white/5 hover:text-bisa font-semibold">🤝 Ambassador</a>
                            <a href="{{ route('support.index') }}" @click="open = false" class="block px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-bisa-50 dark:hover:bg-white/5 hover:text-bisa font-semibold">💬 Pusat Bantuan</a>
                            <hr class="my-1 border-gray-100 dark:border-white/10">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-danger hover:bg-danger-light dark:hover:bg-rose-950/30 font-bold">Keluar</button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="px-4 py-2 text-xs font-bold text-charcoal-dark dark:text-gray-200 hover:text-bisa dark:hover:text-bisa transition">Masuk</a>
                    <a href="{{ route('register') }}" class="px-5 py-2.5 text-xs font-black text-white bg-bisa hover:bg-bisa-dark rounded-xl transition shadow-md shadow-bisa/20 transform hover:-translate-y-0.5 active:translate-y-0">Daftar</a>
                @endauth
            </div>

            {{-- Mobile Buttons (Theme + Hamburger) --}}
            <div class="flex items-center gap-1 md:hidden">
                <button @click="$store.theme.toggle()"
                        type="button"
                        title="Ganti Tema"
                        class="p-2 rounded-xl text-gray-600 dark:text-yellow-400 hover:bg-gray-100 dark:hover:bg-white/10 transition focus:outline-none">
                    <template x-if="!$store.theme.dark">
                        <i class="bi bi-moon-stars text-base text-gray-700"></i>
                    </template>
                    <template x-if="$store.theme.dark">
                        <i class="bi bi-sun-fill text-base text-yellow-400"></i>
                    </template>
                </button>

                <button @click="mobileOpen = !mobileOpen" type="button" class="p-2 rounded-xl text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-white/10 transition focus:outline-none">
                    <svg x-show="!mobileOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    <svg x-show="mobileOpen" x-cloak class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Mobile Menu --}}
    <div x-show="mobileOpen" x-cloak x-transition class="md:hidden border-t border-gray-100 dark:border-white/10 bg-white dark:bg-[#161922] transition-colors duration-200">
        <div class="px-4 py-3 space-y-1 text-xs font-semibold">
            <a href="{{ url('/') }}" class="block px-3 py-2.5 rounded-xl text-gray-700 dark:text-gray-200 hover:bg-bisa-50 dark:hover:bg-white/5 hover:text-bisa">Beranda</a>
            <div class="px-3 pt-2 text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Persiapan Belajar</div>
            <a href="{{ route('map.show', ['categorySlug' => 'tka']) }}" class="block px-5 py-2 rounded-xl text-gray-600 dark:text-gray-300 hover:bg-bisa-50 dark:hover:bg-white/5 hover:text-bisa">TKA</a>
            <a href="{{ route('map.show', ['categorySlug' => 'snbt']) }}" class="block px-5 py-2 rounded-xl text-gray-600 dark:text-gray-300 hover:bg-bisa-50 dark:hover:bg-white/5 hover:text-bisa">SNBT</a>
            <a href="{{ route('map.show', ['categorySlug' => 'utbk']) }}" class="block px-5 py-2 rounded-xl text-gray-600 dark:text-gray-300 hover:bg-bisa-50 dark:hover:bg-white/5 hover:text-bisa">UTBK</a>
            <a href="{{ route('practice.index') }}" class="block px-3 py-2.5 rounded-xl text-gray-700 dark:text-gray-200 hover:bg-bisa-50 dark:hover:bg-white/5 hover:text-bisa">Latihan Soal</a>
            <a href="{{ route('tryouts.index') }}" class="block px-3 py-2.5 rounded-xl text-gray-700 dark:text-gray-200 hover:bg-bisa-50 dark:hover:bg-white/5 hover:text-bisa">Tryout Akbar</a>
            <a href="{{ route('modules.index') }}" class="block px-3 py-2.5 rounded-xl text-gray-700 dark:text-gray-200 hover:bg-bisa-50 dark:hover:bg-white/5 hover:text-bisa">Modul Belajar</a>
            <a href="{{ route('live-classes.index') }}" class="block px-3 py-2.5 rounded-xl text-gray-700 dark:text-gray-200 hover:bg-bisa-50 dark:hover:bg-white/5 hover:text-bisa">Kelas Live</a>
            <a href="{{ route('kakai.index') }}" class="block px-3 py-2.5 rounded-xl text-bisa font-bold hover:bg-bisa-50 dark:hover:bg-white/5">KakAI (Tutor AI)</a>
            <a href="{{ route('snbp.index') }}" class="block px-3 py-2.5 rounded-xl text-gray-700 dark:text-gray-200 hover:bg-bisa-50 dark:hover:bg-white/5 hover:text-bisa">SNBP Analisis</a>
            <a href="{{ route('pricing.index') }}" class="block px-3 py-2.5 rounded-xl text-amber-600 dark:text-amber-400 font-bold hover:bg-amber-50 dark:hover:bg-white/5">Paket Premium</a>
            <a href="{{ url('/#tentang') }}" class="block px-3 py-2.5 rounded-xl text-gray-700 dark:text-gray-200 hover:bg-bisa-50 dark:hover:bg-white/5 hover:text-bisa">Tentang</a>
        </div>
        <div class="px-4 py-3 border-t border-gray-100 dark:border-white/10 space-y-2">
            @auth
                <a href="{{ route('dashboard') }}" class="block w-full text-center px-4 py-2.5 text-xs font-bold text-bisa bg-bisa-50 dark:bg-bisa-900/30 rounded-xl">Dashboard Siswa</a>
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="block w-full text-center px-4 py-2.5 text-xs font-bold text-purple-700 dark:text-purple-300 bg-purple-50 dark:bg-purple-900/30 rounded-xl">Dashboard Admin</a>
                @endif
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="block w-full text-center px-4 py-2.5 text-xs font-bold text-danger">Keluar</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="block w-full text-center px-4 py-2.5 text-xs font-bold text-gray-700 dark:text-gray-200 border border-gray-200 dark:border-white/10 rounded-xl">Masuk</a>
                <a href="{{ route('register') }}" class="block w-full text-center px-4 py-2.5 text-xs font-black text-white bg-bisa rounded-xl">Daftar</a>
            @endauth
        </div>
    </div>
</nav>
