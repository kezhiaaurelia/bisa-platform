<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\QuizAttempt;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Show the user profile page.
     */
    public function show(Request $request): View
    {
        $user = $request->user();

        $recentAttempts = QuizAttempt::where('user_id', $user->id)
            ->with(['quiz', 'subject'])
            ->latest()
            ->limit(10)
            ->get();

        return view('user.profile.show', compact('user', 'recentAttempts'));
    }

    /**
     * Update user profile information.
     */
    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
            'target_ptn' => ['nullable', 'string', 'max:255'],
            'target_major' => ['nullable', 'string', 'max:255'],
            'target_path' => ['nullable', 'in:snbt,tka,mandiri'],
            'password' => ['nullable', 'string', 'min:6'],
        ]);

        $data = [
            'name' => $request->name,
            'phone' => $request->phone,
            'target_ptn' => $request->target_ptn,
            'target_major' => $request->target_major,
            'target_path' => $request->target_path ?? $user->target_path,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return back()->with('success', 'Data profil dan target perguruan tinggi berhasil diperbarui!');
    }
}

