<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PricingController extends Controller
{
    /**
     * Display pricing plans and premium feature comparisons.
     */
    public function index(Request $request): View
    {
        $user = $request->user();

        return view('user.pricing.index', compact('user'));
    }

    /**
     * Checkout & activate premium membership.
     */
    public function checkout(Request $request): RedirectResponse
    {
        $request->validate([
            'plan_name' => ['required', 'string'],
            'amount' => ['required', 'integer'],
            'payment_method' => ['required', 'string'],
        ]);

        $user = $request->user();

        // Record transaction
        Transaction::create([
            'user_id' => $user->id,
            'plan_name' => $request->plan_name,
            'amount' => $request->amount,
            'payment_method' => $request->payment_method,
            'status' => 'success',
        ]);

        // Activate premium
        $months = str_contains(strtolower($request->plan_name), 'tahunan') ? 12 : 3;
        $user->update([
            'is_premium' => true,
            'premium_until' => now()->addMonths($months),
        ]);

        return redirect()->route('dashboard')->with('success', "Selamat! Akunmu telah berhasil di-upgrade ke Paket {$request->plan_name}. Seluruh fitur Tryout Akbar, Modul Eksklusif, dan KakAI Unlimited telah aktif!");
    }
}

