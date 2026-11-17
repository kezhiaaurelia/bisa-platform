<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OnboardingController extends Controller
{
    /**
     * Show the onboarding wizard form.
     */
    public function show(Request $request): View|RedirectResponse
    {
        $user = $request->user();

        return view('user.onboarding', compact('user'));
    }

    /**
     * Store onboarding preferences.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'target_ptn' => ['required', 'string', 'max:255'],
            'target_major' => ['required', 'string', 'max:255'],
            'target_path' => ['required', 'in:snbt,tka,mandiri'],
            'phone' => ['nullable', 'string', 'max:20'],
        ]);

        $user = $request->user();
        $user->update([
            'target_ptn' => $request->target_ptn,
            'target_major' => $request->target_major,
            'target_path' => $request->target_path,
            'phone' => $request->phone,
            'onboarding_completed' => true,
        ]);

        return redirect()->route('dashboard')->with('success', 'Selamat datang di BISA! Target belajarmu telah berhasil diatur.');
    }
}

