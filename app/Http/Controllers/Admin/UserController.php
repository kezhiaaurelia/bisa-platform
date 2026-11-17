<?php

namespace App\Http\Controllers\Admin;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(Request $request): View
    {
        $query = User::where('role', UserRole::User)
            ->withCount(['quizAttempts as practice_count' => fn ($q) => $q->where('type', 'practice')])
            ->withCount(['quizAttempts as quiz_count' => fn ($q) => $q->where('type', 'quiz')]);

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('name', 'like', "%{$s}%")
                    ->orWhere('email', 'like', "%{$s}%")
                    ->orWhere('target_ptn', 'like', "%{$s}%");
            });
        }

        if ($request->filled('status')) {
            if ($request->status === 'premium') {
                $query->where('is_premium', true);
            } elseif ($request->status === 'free') {
                $query->where('is_premium', false);
            }
        }

        $users = $query->latest()->paginate(15)->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    /**
     * Toggle premium status of user.
     */
    public function togglePremium(Request $request, int $id): RedirectResponse
    {
        $user = User::findOrFail($id);
        $newStatus = ! $user->is_premium;

        $user->update([
            'is_premium' => $newStatus,
            'premium_until' => $newStatus ? now()->addMonths(6) : null,
        ]);

        $statusText = $newStatus ? 'diaktifkan sebagai Premium' : 'diubah menjadi Akun Reguler';

        return back()->with('success', "Status paket pengguna {$user->name} berhasil {$statusText}.");
    }

    /**
     * Reset user password to default.
     */
    public function resetPassword(Request $request, int $id): RedirectResponse
    {
        $user = User::findOrFail($id);
        $user->update([
            'password' => Hash::make('bisa12345'),
        ]);

        return back()->with('success', "Password pengguna {$user->name} berhasil direset menjadi 'bisa12345'.");
    }
}
