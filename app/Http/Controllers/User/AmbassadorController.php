<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\AmbassadorApplication;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AmbassadorController extends Controller
{
    /**
     * Show Ambassador program info and registration form.
     */
    public function index(Request $request): View
    {
        $user = $request->user();
        $application = AmbassadorApplication::where('user_id', $user->id)->first();

        return view('user.ambassador.index', compact('user', 'application'));
    }

    /**
     * Submit an application to become a BISA Ambassador.
     */
    public function apply(Request $request): RedirectResponse
    {
        $request->validate([
            'school_name' => ['required', 'string', 'max:255'],
            'instagram_handle' => ['nullable', 'string', 'max:255'],
            'tiktok_handle' => ['nullable', 'string', 'max:255'],
            'motivation' => ['required', 'string', 'max:1000'],
        ]);

        $user = $request->user();
        $code = strtoupper('BISA-'.Str::random(5));

        AmbassadorApplication::updateOrCreate(
            ['user_id' => $user->id],
            [
                'school_name' => $request->school_name,
                'instagram_handle' => $request->instagram_handle,
                'tiktok_handle' => $request->tiktok_handle,
                'motivation' => $request->motivation,
                'referral_code' => $code,
                'status' => 'approved',
                'total_referrals' => 0,
            ]
        );

        return back()->with('success', "Selamat! Pendaftaranmu sebagai BISA Campus Ambassador telah disetujui. Kode ajakanmu: {$code}");
    }
}
