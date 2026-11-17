<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LiveClass;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LiveClassController extends Controller
{
    public function index(Request $request): View
    {
        $classes = LiveClass::withCount('registrations')->latest()->paginate(15);

        return view('admin.live-classes.index', compact('classes'));
    }

    public function create(): View
    {
        return view('admin.live-classes.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'instructor_name' => ['required', 'string', 'max:255'],
            'category_slug' => ['required', 'string'],
            'scheduled_at' => ['required', 'date'],
            'duration_minutes' => ['required', 'integer', 'min:30'],
            'meet_url' => ['nullable', 'url'],
            'recording_url' => ['nullable', 'url'],
            'description' => ['nullable', 'string'],
        ]);

        $validated['is_premium'] = $request->boolean('is_premium');

        LiveClass::create($validated);

        return redirect()->route('admin.live-classes.index')->with('success', 'Jadwal kelas live berhasil dibuat!');
    }

    public function destroy(LiveClass $liveClass): RedirectResponse
    {
        $liveClass->delete();

        return back()->with('success', 'Kelas live berhasil dihapus.');
    }
}

