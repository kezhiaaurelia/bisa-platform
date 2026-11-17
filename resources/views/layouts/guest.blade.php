<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'BISA — Belajar Intensif dan Simulasi Akademik')</title>

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
</head>
<body class="bg-gradient-to-br from-bisa-50/80 via-white to-gold-light/40 dark:from-[#0B0D13] dark:via-[#11141E] dark:to-[#171B26] min-h-screen flex items-center justify-center font-sans antialiased text-charcoal-dark dark:text-gray-100 transition-colors duration-200 relative p-4 selection:bg-bisa selection:text-white">

    {{-- Quick Theme Toggle for Auth Pages --}}
    <div class="fixed top-5 right-5 z-50">
        <button @click="$store.theme.toggle()"
                type="button"
                title="Ganti Tema (Gelap/Terang)"
                class="p-2.5 rounded-2xl bg-white/90 dark:bg-[#1A1E27]/90 text-gray-700 dark:text-yellow-400 hover:text-bisa dark:hover:text-yellow-300 shadow-md border border-gray-200 dark:border-white/10 backdrop-blur-md transition-all transform hover:scale-105 active:scale-95 focus:outline-none">
            <template x-if="!$store.theme.dark">
                {{-- Moon Icon (Dark Mode Trigger) --}}
                <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                </svg>
            </template>
            <template x-if="$store.theme.dark">
                {{-- Sun Icon (Light Mode Trigger) --}}
                <svg class="w-5 h-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 9h-1m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
            </template>
        </button>
    </div>

    <div class="w-full max-w-md mx-auto px-4 py-8 animate-scale-in">
        {{-- Logo --}}
        <div class="text-center mb-8">
            <a href="{{ url('/') }}" class="inline-block transition transform hover:scale-105">
                <img src="{{ asset('images/logo-full.png') }}" alt="BISA" class="h-14 mx-auto dark:brightness-110">
            </a>
        </div>

        {{-- Card --}}
        <div class="bg-white dark:bg-[#161922] rounded-3xl shadow-xl dark:shadow-2xl border border-gray-100 dark:border-white/10 p-8 transition-colors duration-200">
            @yield('content')
        </div>

        <p class="text-center text-xs text-gray-500 dark:text-gray-400 mt-6">
            &copy; {{ date('Y') }} BISA — Belajar Intensif dan Simulasi Akademik
        </p>
    </div>
</body>
</html>

