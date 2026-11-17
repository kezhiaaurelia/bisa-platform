@extends('layouts.admin')

@section('title', 'Kelola User Siswa — BISA')

@section('content')
<div class="space-y-6">

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-charcoal-dark">Data Pengguna Siswa</h1>
            <p class="text-xs text-gray-500 mt-1">Daftar siswa yang terdaftar dalam platform BISA.</p>
        </div>
    </div>

    {{-- Users Table --}}
    <div class="bg-white rounded-3xl border border-gray-200/80 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-charcoal">
                <thead class="bg-gray-50 border-b border-gray-200 text-[11px] font-extrabold uppercase tracking-wider text-gray-500">
                    <tr>
                        <th class="p-4">Nama Siswa</th>
                        <th class="p-4">Email</th>
                        <th class="p-4">Terdaftar</th>
                        <th class="p-4">Terakhir Login</th>
                        <th class="p-4 text-center">Latihan</th>
                        <th class="p-4 text-center">Kuis</th>
                        <th class="p-4">Status Akun</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($users as $user)
                        <tr class="hover:bg-gray-50/50 transition">
                            <td class="p-4">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-8 h-8 rounded-full bg-bisa-100 text-bisa font-bold flex items-center justify-center text-xs shrink-0">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <span class="font-bold text-charcoal-dark">{{ $user->name }}</span>
                                </div>
                            </td>
                            <td class="p-4 font-mono text-gray-600">{{ $user->email }}</td>
                            <td class="p-4 text-gray-500">{{ $user->created_at->format('d M Y') }}</td>
                            <td class="p-4 text-gray-500">
                                {{ $user->last_login_at ? $user->last_login_at->diffForHumans() : 'Belum pernah' }}
                            </td>
                            <td class="p-4 text-center font-bold text-blue-600">{{ $user->practice_count }}</td>
                            <td class="p-4 text-center font-bold text-purple-600">{{ $user->quiz_count }}</td>
                            <td class="p-4">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-success-light text-success border border-success/20">
                                    Aktif
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-8 text-center text-gray-400">Belum ada user siswa terdaftar.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
            <div class="p-4 border-t border-gray-100">
                {{ $users->links() }}
            </div>
        @endif
    </div>

</div>
@endsection

