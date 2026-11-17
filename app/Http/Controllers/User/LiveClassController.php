<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\LiveClass;
use App\Models\LiveClassRegistration;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LiveClassController extends Controller
{
    /**
     * Display live interactive class schedules and video archives.
     */
    public function index(Request $request): View
    {
        $user = $request->user();

        $upcomingClasses = LiveClass::where('scheduled_at', '>=', now())
            ->orderBy('scheduled_at')
            ->get();

        $recordedClasses = LiveClass::whereNotNull('recording_url')
            ->orderByDesc('scheduled_at')
            ->get();

        $registeredClassIds = LiveClassRegistration::where('user_id', $user->id)
            ->pluck('live_class_id')
            ->toArray();

        return view('user.live-classes.index', compact('upcomingClasses', 'recordedClasses', 'registeredClassIds'));
    }

    /**
     * Register user for a live class session.
     */
    public function register(Request $request, int $classId): RedirectResponse
    {
        $user = $request->user();
        $liveClass = LiveClass::findOrFail($classId);

        if ($liveClass->is_premium && ! $user->isPremium()) {
            return redirect()->route('pricing.index')->with('warning', 'Kelas Live ini khusus untuk siswa paket Premium. Upgrade sekarang untuk mengakses seluruh sesi live.');
        }

        LiveClassRegistration::firstOrCreate([
            'user_id' => $user->id,
            'live_class_id' => $liveClass->id,
        ]);

        return back()->with('success', "Kamu berhasil terdaftar di sesi {$liveClass->title}! Tautan meeting telah aktif.");
    }
}

