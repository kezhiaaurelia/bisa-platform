<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'BISA — Belajar Intensif dan Simulasi Akademik')</title>
    <meta name="description" content="Platform persiapan masuk perguruan tinggi dengan latihan soal, simulasi tryout, dan tracking progress belajar.">

    {{-- Dark Mode Immediate Initialization (Prevents FOUT) --}}
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
<body class="bg-gray-50 text-charcoal-dark dark:bg-[#0E1017] dark:text-gray-100 font-sans antialiased min-h-screen flex flex-col justify-between selection:bg-bisa selection:text-white transition-colors duration-200">
    <x-navbar />

    <main class="flex-grow">
        @yield('content')
    </main>

    <x-footer />

    @stack('scripts')
</body>
</html>

