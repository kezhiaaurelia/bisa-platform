@extends('layouts.guest')

@section('title', 'Masuk — BISA')

@section('content')
<div class="mb-6 text-center">
    <h2 class="text-2xl font-black text-charcoal-dark dark:text-white tracking-tight">Selamat Datang Kembali! 👋</h2>
    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Masuk untuk melanjutkan petualangan belajarmu.</p>
</div>

@if ($errors->any())
    <div class="mb-4 p-3.5 bg-danger-light dark:bg-rose-950/40 border border-danger/20 dark:border-rose-800/40 rounded-2xl text-xs text-danger dark:text-rose-300 animate-fade-in-down">
        <ul class="list-disc list-inside space-y-1">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('login') }}" class="space-y-4">
    @csrf

    <div>
        <label for="email" class="block text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider mb-1.5">Email Siswa / Admin</label>
        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
            placeholder="nama@email.com"
            class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-white/10 bg-white dark:bg-[#1E222D] focus:outline-none focus:border-bisa focus:ring-2 focus:ring-bisa/20 text-sm text-gray-800 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500 transition">
    </div>

    <div>
        <div class="flex items-center justify-between mb-1.5">
            <label for="password" class="block text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Password</label>
        </div>
        <input id="password" type="password" name="password" required
            placeholder="••••••••"
            class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-white/10 bg-white dark:bg-[#1E222D] focus:outline-none focus:border-bisa focus:ring-2 focus:ring-bisa/20 text-sm text-gray-800 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500 transition">
    </div>

    <div class="flex items-center justify-between text-xs">
        <label class="flex items-center gap-2 cursor-pointer select-none">
            <input type="checkbox" name="remember" class="w-4 h-4 text-bisa border-gray-300 dark:border-white/20 rounded focus:ring-bisa bg-white dark:bg-[#1E222D]">
            <span class="text-gray-600 dark:text-gray-400">Ingat saya</span>
        </label>
    </div>

    <button type="submit"
        class="w-full py-3 bg-bisa hover:bg-bisa-dark text-white font-extrabold text-sm rounded-xl shadow-lg shadow-bisa/25 transition transform hover:-translate-y-0.5 active:translate-y-0">
        Masuk Sekarang
    </button>
</form>

{{-- Demo Accounts Quick Helper --}}
<div class="mt-6 p-3.5 bg-gray-50 dark:bg-white/5 rounded-2xl border border-gray-100 dark:border-white/10 text-[11px] text-gray-500 dark:text-gray-400">
    <div class="font-bold text-charcoal-dark dark:text-gray-200 mb-1">Akun Akses BISA:</div>
    <div class="flex justify-between items-center py-0.5">
        <span>Admin: <strong class="text-charcoal-dark dark:text-white">admin@bisa.com</strong></span>
        <span class="text-gray-400">pass: password</span>
    </div>
    <div class="flex justify-between items-center py-0.5">
        <span>Siswa: <strong class="text-charcoal-dark dark:text-white">siswa@bisa.com</strong></span>
        <span class="text-gray-400">pass: password</span>
    </div>
</div>

<div class="mt-6 text-center text-xs text-gray-500 dark:text-gray-400">
    Belum punya akun?
    <a href="{{ route('register') }}" class="font-bold text-bisa hover:underline ml-1">Daftar sekarang</a>
</div>
@endsection
