<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel — BISA')</title>

    {{-- Dark Mode Immediate Initialization --}}
    <script>
        (function() {
            try {
                const savedTheme = localStorage.getItem('bisa_theme');
                if (savedTheme === 'dark' || (!savedTheme && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                    document.documentElement.classList.add('dark');
                } else {
                    document.documentElement.classList.remove('dark');
                }
            } catch (e) {}
        })();
    </script>

    @fonts
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="bg-gray-100 text-charcoal-dark dark:bg-[#0B0D13] dark:text-gray-100 font-sans antialiased transition-colors duration-200 selection:bg-bisa selection:text-white">
    <div class="min-h-screen flex flex-col md:flex-row">

        {{-- Admin Sidebar --}}
        <aside class="w-full md:w-64 bg-charcoal-dark dark:bg-[#121520] text-white shrink-0 flex flex-col justify-between border-r border-white/5">
            <div>
                {{-- Sidebar Brand & Theme Toggle --}}
                <div class="p-6 border-b border-white/10 flex items-center justify-between gap-3">
                    <div class="flex items-center gap-3">
                        <img src="{{ asset('images/logo-icon.png') }}" alt="BISA" class="w-8 h-8">
                        <div>
                            <div class="font-bold text-base tracking-wide">BiSA Admin</div>
                            <div class="text-[10px] text-gray-400">Control & Learning Center</div>
                        </div>
                    </div>

                    {{-- Theme Toggle Button in Admin --}}
                    <button @click="$store.theme.toggle()"
                            type="button"
                            title="Ganti Tema (Gelap/Terang)"
                            class="p-1.5 rounded-lg bg-white/10 hover:bg-white/20 text-yellow-400 transition focus:outline-none">
                        <template x-if="!$store.theme.dark">
                            <svg class="w-4 h-4 text-gray-300 hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
                        </template>
                        <template x-if="$store.theme.dark">
                            <svg class="w-4 h-4 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 9h-1m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        </template>
                    </button>
                </div>

                {{-- Sidebar Navigation --}}
                <nav class="p-4 space-y-1 text-xs font-semibold">
                    <a href="{{ route('admin.dashboard') }}"
                       class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition {{ request()->routeIs('admin.dashboard') ? 'bg-bisa text-white shadow-md shadow-bisa/30' : 'text-gray-300 hover:bg-white/10' }}">
                        <span>📊</span>
                        <span>Dashboard</span>
                    </a>

                    <div class="pt-4 pb-1 px-3.5 text-[10px] font-bold uppercase tracking-wider text-gray-500">Master Akademik</div>

                    <a href="{{ route('admin.categories.index') }}"
                       class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition {{ request()->routeIs('admin.categories.*') ? 'bg-bisa text-white shadow-md shadow-bisa/30' : 'text-gray-300 hover:bg-white/10' }}">
                        <span>📂</span>
                        <span>Kelola Kategori</span>
                    </a>

                    <a href="{{ route('admin.subjects.index') }}"
                       class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition {{ request()->routeIs('admin.subjects.*') ? 'bg-bisa text-white shadow-md shadow-bisa/30' : 'text-gray-300 hover:bg-white/10' }}">
                        <span>📚</span>
                        <span>Mata Pelajaran</span>
                    </a>

                    <div class="pt-4 pb-1 px-3.5 text-[10px] font-bold uppercase tracking-wider text-gray-500">Bank Soal & Ujian</div>

                    <a href="{{ route('admin.questions.index') }}"
                       class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition {{ request()->routeIs('admin.questions.*') ? 'bg-bisa text-white shadow-md shadow-bisa/30' : 'text-gray-300 hover:bg-white/10' }}">
                        <span>✍️</span>
                        <span>Kelola Soal</span>
                    </a>

                    <a href="{{ route('admin.import.index') }}"
                       class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition {{ request()->routeIs('admin.import.*') ? 'bg-bisa text-white shadow-md shadow-bisa/30' : 'text-gray-300 hover:bg-white/10' }}">
                        <span>📥</span>
                        <span>Import Excel</span>
                    </a>

                    <a href="{{ route('admin.quizzes.index') }}"
                       class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition {{ request()->routeIs('admin.quizzes.*') ? 'bg-bisa text-white shadow-md shadow-bisa/30' : 'text-gray-300 hover:bg-white/10' }}">
                        <span>⏱️</span>
                        <span>Kuis & Tryout (Waktu)</span>
                    </a>

                    <div class="pt-4 pb-1 px-3.5 text-[10px] font-bold uppercase tracking-wider text-gray-500">Event & Pembelajaran</div>

                    <a href="{{ route('admin.tryout-events.index') }}"
                       class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition {{ request()->routeIs('admin.tryout-events.*') ? 'bg-bisa text-white shadow-md shadow-bisa/30' : 'text-gray-300 hover:bg-white/10' }}">
                        <span>🎯</span>
                        <span>Event Tryout Akbar</span>
                    </a>

                    <a href="{{ route('admin.live-classes.index') }}"
                       class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition {{ request()->routeIs('admin.live-classes.*') ? 'bg-bisa text-white shadow-md shadow-bisa/30' : 'text-gray-300 hover:bg-white/10' }}">
                        <span>📹</span>
                        <span>Kelas Live</span>
                    </a>

                    <div class="pt-4 pb-1 px-3.5 text-[10px] font-bold uppercase tracking-wider text-gray-500">Manajemen & Laporan</div>

                    <a href="{{ route('admin.transactions.index') }}"
                       class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition {{ request()->routeIs('admin.transactions.*') ? 'bg-bisa text-white shadow-md shadow-bisa/30' : 'text-gray-300 hover:bg-white/10' }}">
                        <span>💳</span>
                        <span>Transaksi & Premium</span>
                    </a>

                    <a href="{{ route('admin.moderation.index') }}"
                       class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition {{ request()->routeIs('admin.moderation.*') ? 'bg-bisa text-white shadow-md shadow-bisa/30' : 'text-gray-300 hover:bg-white/10' }}">
                        <span>💬</span>
                        <span>Moderasi & Laporan</span>
                    </a>

                    <a href="{{ route('admin.analytics.index') }}"
                       class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition {{ request()->routeIs('admin.analytics.*') ? 'bg-bisa text-white shadow-md shadow-bisa/30' : 'text-gray-300 hover:bg-white/10' }}">
                        <span>📈</span>
                        <span>Laporan & Analitik</span>
                    </a>

                    <div class="pt-4 pb-1 px-3.5 text-[10px] font-bold uppercase tracking-wider text-gray-500">Pengguna</div>

                    <a href="{{ route('admin.users.index') }}"
                       class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition {{ request()->routeIs('admin.users.*') ? 'bg-bisa text-white shadow-md shadow-bisa/30' : 'text-gray-300 hover:bg-white/10' }}">
                        <span>👥</span>
                        <span>Kelola User Siswa</span>
                    </a>

                    <div class="pt-4 pb-1 px-3.5 text-[10px] font-bold uppercase tracking-wider text-gray-500">Tampilan Siswa</div>
                    <a href="{{ route('dashboard') }}" target="_blank"
                       class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-gray-300 hover:bg-white/10 transition">
                        <span>🚀</span>
                        <span>Buka Area Siswa ↗</span>
                    </a>
                </nav>
            </div>

            {{-- Sidebar Footer --}}
            <div class="p-4 border-t border-white/10">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-xs font-bold text-white">{{ auth()->user()->name }}</div>
                        <div class="text-[10px] text-gray-400">Administrator</div>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="p-2 text-gray-400 hover:text-danger transition text-xs font-bold" title="Logout">
                            🚪
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        {{-- Main Admin Content Area --}}
        <main class="flex-1 min-w-0 p-6 lg:p-10 bg-gray-50 dark:bg-[#0E1017] transition-colors duration-200">
            @if(session('success'))
                <div class="mb-6 p-4 rounded-2xl bg-success-light dark:bg-success-950/40 border border-success/30 text-success-900 dark:text-emerald-300 text-xs font-bold flex items-center gap-2 animate-fade-in-down">
                    <span>✅</span>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 p-4 rounded-2xl bg-danger-light dark:bg-danger-950/40 border border-danger/30 text-danger-900 dark:text-rose-300 text-xs font-bold flex items-center gap-2 animate-fade-in-down">
                    <span>⚠️</span>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            @yield('content')
        </main>

    </div>

    @stack('scripts')
</body>
</html>

    </div>

    @stack('scripts')
</body>
</html>

