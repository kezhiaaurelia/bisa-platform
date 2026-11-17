@extends('layouts.guest')

@section('title', 'Daftar Akun Siswa — BISA')

@section('content')
<div class="mb-6 text-center">
    <h2 class="text-2xl font-black text-charcoal-dark dark:text-white tracking-tight">Mulai Petualangan Belajar 🚀</h2>
    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Daftar sekarang dan taklukkan ujian perguruan tinggi impianmu!</p>
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

<form method="POST" action="{{ route('register') }}" class="space-y-4">
    @csrf

    <div>
        <label for="name" class="block text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider mb-1.5">Nama Lengkap Siswa</label>
        <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
            placeholder="Contoh: Budi Pratama"
            class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-white/10 bg-white dark:bg-[#1E222D] focus:outline-none focus:border-bisa focus:ring-2 focus:ring-bisa/20 text-sm text-gray-800 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500 transition">
    </div>

    <div>
        <label for="email" class="block text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider mb-1.5">Email</label>
        <input id="email" type="email" name="email" value="{{ old('email') }}" required
            placeholder="nama@email.com"
            class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-white/10 bg-white dark:bg-[#1E222D] focus:outline-none focus:border-bisa focus:ring-2 focus:ring-bisa/20 text-sm text-gray-800 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500 transition">
    </div>

    <div>
        <label for="password" class="block text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider mb-1.5">Password</label>
        <input id="password" type="password" name="password" required
            placeholder="Minimal 6 karakter"
            class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-white/10 bg-white dark:bg-[#1E222D] focus:outline-none focus:border-bisa focus:ring-2 focus:ring-bisa/20 text-sm text-gray-800 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500 transition">
    </div>

    <div>
        <label for="password_confirmation" class="block text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider mb-1.5">Konfirmasi Password</label>
        <input id="password_confirmation" type="password" name="password_confirmation" required
            placeholder="Ulangi password"
            class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-white/10 bg-white dark:bg-[#1E222D] focus:outline-none focus:border-bisa focus:ring-2 focus:ring-bisa/20 text-sm text-gray-800 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500 transition">
    </div>

    <button type="submit"
        class="w-full py-3 bg-bisa hover:bg-bisa-dark text-white font-extrabold text-sm rounded-xl shadow-lg shadow-bisa/25 transition transform hover:-translate-y-0.5 active:translate-y-0">
        Daftar Akun Siswa
    </button>
</form>

<div class="mt-6 text-center text-xs text-gray-500 dark:text-gray-400">
    Sudah punya akun?
    <a href="{{ route('login') }}" class="font-bold text-bisa hover:underline ml-1">Masuk</a>
</div>
@endsection
