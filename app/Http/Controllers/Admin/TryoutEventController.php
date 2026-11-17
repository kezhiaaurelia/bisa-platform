<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\TryoutEvent;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TryoutEventController extends Controller
{
    public function index(Request $request): View
    {
        $events = TryoutEvent::with('category')->withCount('registrations')->latest()->paginate(15);

        return view('admin.tryouts.index', compact('events'));
    }

    public function create(): View
    {
        $categories = Category::active()->get();

        return view('admin.tryouts.create', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'event_type' => ['required', 'in:snbt,utbk,tka,mandiri'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'duration_minutes' => ['required', 'integer', 'min:15'],
            'is_premium' => ['boolean'],
            'description' => ['nullable', 'string'],
        ]);

        $validated['is_premium'] = $request->boolean('is_premium');
        $validated['is_published'] = $request->boolean('is_published');
        $validated['release_discussion'] = $request->boolean('release_discussion');

        TryoutEvent::create($validated);

        return redirect()->route('admin.tryout-events.index')->with('success', 'Event tryout berhasil dipublikasikan!');
    }

    public function edit(TryoutEvent $tryoutEvent): View
    {
        $categories = Category::active()->get();

        return view('admin.tryouts.edit', compact('tryoutEvent', 'categories'));
    }

    public function update(Request $request, TryoutEvent $tryoutEvent): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'event_type' => ['required', 'in:snbt,utbk,tka,mandiri'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date'],
            'duration_minutes' => ['required', 'integer', 'min:15'],
            'description' => ['nullable', 'string'],
        ]);

        $validated['is_premium'] = $request->boolean('is_premium');
        $validated['is_published'] = $request->boolean('is_published');
        $validated['release_discussion'] = $request->boolean('release_discussion');

        $tryoutEvent->update($validated);

        return redirect()->route('admin.tryout-events.index')->with('success', 'Event tryout berhasil diperbarui!');
    }

    public function destroy(TryoutEvent $tryoutEvent): RedirectResponse
    {
        $tryoutEvent->delete();

        return back()->with('success', 'Event tryout berhasil dihapus.');
    }
}

