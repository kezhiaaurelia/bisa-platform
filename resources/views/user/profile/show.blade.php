@extends('layouts.app')

@section('title', 'Profil Siswa — BISA')

@section('content')
<div class="bg-gray-50 dark:bg-[#0E1017] min-h-screen py-10 transition-colors duration-200">
    <div class="max-w-5xl mx-auto px-4 sm:px-6">

        {{-- Flash Messages --}}
        @if(session('success'))
            <div class="mb-6 p-4 rounded-2xl bg-emerald-50 dark:bg-emerald-950/40 text-emerald-800 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800/40 text-xs font-bold animate-fade-in-down flex items-center gap-2">
                <i class="bi bi-check-circle-fill"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <div class="grid lg:grid-cols-3 gap-8">

            {{-- Left: Profile Card & Membership --}}
            <div class="space-y-6">
                <div class="bg-white dark:bg-[#161922] rounded-3xl p-6 sm:p-7 border border-gray-100 dark:border-white/10 shadow-sm text-center">
                    <div class="w-20 h-20 rounded-3xl bg-gradient-to-br from-bisa to-gold text-white font-black text-3xl mx-auto flex items-center justify-center shadow-lg shadow-bisa/20 mb-4">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>

                    <h2 class="text-lg font-black text-charcoal-dark dark:text-white">{{ $user->name }}</h2>
                    <p class="text-xs text-gray-400 mb-4">{{ $user->email }}</p>

                    <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-extrabold
                        {{ $user->isPremium() ? 'bg-gold/20 text-gold-dark dark:text-amber-300 border border-gold/40' : 'bg-gray-100 dark:bg-white/10 text-gray-600 dark:text-gray-300' }}
                    ">
                        <i class="bi bi-star-fill text-[10px]"></i>
                        <span>{{ $user->isPremium() ? 'Akun Premium VIP' : 'Akun Siswa Reguler' }}</span>
                    </div>

                    @if($user->isPremium())
                        <div class="text-[11px] text-gray-400 mt-2">
                            Aktif s.d: {{ $user->premium_until ? $user->premium_until->format('d M Y') : 'Aktif' }}
                        </div>
                    @else
                        <div class="mt-4 pt-4 border-t border-gray-100 dark:border-white/10">
                            <a href="{{ route('pricing.index') }}" class="w-full py-2.5 px-4 bg-bisa hover:bg-bisa-dark text-white rounded-xl text-xs font-bold transition flex items-center justify-center gap-1.5 shadow-sm">
                                <i class="bi bi-rocket-takeoff-fill"></i>
                                <span>Upgrade ke Premium</span>
                            </a>
                        </div>
                    @endif
                </div>

                {{-- Target Summary Box --}}
                <div class="bg-white dark:bg-[#161922] rounded-3xl p-6 border border-gray-100 dark:border-white/10 shadow-sm">
                    <h3 class="text-xs font-black uppercase tracking-wider text-charcoal-dark dark:text-white mb-3 flex items-center gap-2">
                        <i class="bi bi-mortarboard-fill text-bisa"></i>
                        <span>Target Kelulusan</span>
                    </h3>
                    <div class="space-y-3 text-xs">
                        <div>
                            <span class="text-gray-400 block text-[10px] uppercase">Perguruan Tinggi</span>
                            <span class="font-extrabold text-charcoal-dark dark:text-white">{{ $user->target_ptn ?? 'Belum diatur' }}</span>
                        </div>
                        <div>
                            <span class="text-gray-400 block text-[10px] uppercase">Program Studi</span>
                            <span class="font-extrabold text-charcoal-dark dark:text-white">{{ $user->target_major ?? 'Belum diatur' }}</span>
                        </div>
                        <div>
                            <span class="text-gray-400 block text-[10px] uppercase">Fokus Jalur</span>
                            <span class="font-extrabold text-bisa uppercase">{{ $user->target_path ?? 'SNBT' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right: Profile Edit Form --}}
            <div class="lg:col-span-2">
                <div class="bg-white dark:bg-[#161922] rounded-3xl p-6 sm:p-8 border border-gray-100 dark:border-white/10 shadow-sm">
                    <h3 class="text-base font-black text-charcoal-dark dark:text-white mb-6 flex items-center gap-2">
                        <i class="bi bi-person-gear text-bisa"></i>
                        <span>Ubah Data Diri & Target Kampus</span>
                    </h3>

                    <form action="{{ route('profile.update') }}" method="POST" class="space-y-5">
                        @csrf
                        @method('PUT')

                        <div>
                            <label for="name" class="block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300 mb-1.5">
                                Nama Lengkap Siswa
                            </label>
                            <input type="text"
                                   name="name"
                                   id="name"
                                   required
                                   value="{{ old('name', $user->name) }}"
                                   class="w-full px-4 py-3 rounded-2xl border border-gray-200 dark:border-white/10 bg-gray-50 dark:bg-white/5 text-sm text-charcoal-dark dark:text-white focus:outline-none focus:border-bisa">
                        </div>

                        <div>
                            <label for="phone" class="block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300 mb-1.5">
                                Nomor WhatsApp
                            </label>
                            <input type="tel"
                                   name="phone"
                                   id="phone"
                                   value="{{ old('phone', $user->phone) }}"
                                   placeholder="081234567890"
                                   class="w-full px-4 py-3 rounded-2xl border border-gray-200 dark:border-white/10 bg-gray-50 dark:bg-white/5 text-sm text-charcoal-dark dark:text-white focus:outline-none focus:border-bisa">
                        </div>

                        <div class="grid sm:grid-cols-2 gap-4">
                            <div>
                                <label for="target_ptn" class="block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300 mb-1.5">
                                    Target PTN
                                </label>
                                <input type="text"
                                       name="target_ptn"
                                       id="target_ptn"
                                       value="{{ old('target_ptn', $user->target_ptn) }}"
                                       placeholder="Contoh: Universitas Indonesia"
                                       class="w-full px-4 py-3 rounded-2xl border border-gray-200 dark:border-white/10 bg-gray-50 dark:bg-white/5 text-sm text-charcoal-dark dark:text-white focus:outline-none focus:border-bisa">
                            </div>

                            <div>
                                <label for="target_major" class="block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300 mb-1.5">
                                    Target Jurusan
                                </label>
                                <input type="text"
                                       name="target_major"
                                       id="target_major"
                                       value="{{ old('target_major', $user->target_major) }}"
                                       placeholder="Contoh: Teknik Informatika"
                                       class="w-full px-4 py-3 rounded-2xl border border-gray-200 dark:border-white/10 bg-gray-50 dark:bg-white/5 text-sm text-charcoal-dark dark:text-white focus:outline-none focus:border-bisa">
                            </div>
                        </div>

                        <div>
                            <label for="password" class="block text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300 mb-1.5">
                                Password Baru <span class="text-gray-400 lowercase text-[10px]">(kosongkan jika tidak ingin mengubah)</span>
                            </label>
                            <input type="password"
                                   name="password"
                                   id="password"
                                   placeholder="••••••••"
                                   class="w-full px-4 py-3 rounded-2xl border border-gray-200 dark:border-white/10 bg-gray-50 dark:bg-white/5 text-sm text-charcoal-dark dark:text-white focus:outline-none focus:border-bisa">
                        </div>

                        <div class="pt-4 flex items-center justify-between">
                            <button type="submit" class="px-6 py-3 bg-bisa hover:bg-bisa-dark text-white font-extrabold text-xs rounded-xl shadow-md transition">
                                Simpan Perubahan Profil
                            </button>

                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="text-xs font-bold text-danger hover:underline">
                                    Keluar dari Akun
                                </button>
                            </form>
                        </div>
                    </form>
                </div>
            </div>

        </div>

    </div>
</div>
@endsection

