<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\SupportTicket;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SupportController extends Controller
{
    /**
     * Display FAQ & Help desk page.
     */
    public function index(Request $request): View
    {
        $user = $request->user();
        $tickets = SupportTicket::where('user_id', $user->id)->latest()->get();

        return view('user.support.index', compact('user', 'tickets'));
    }

    /**
     * Submit a support ticket or report question error.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'subject' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:2000'],
            'question_id' => ['nullable', 'exists:questions,id'],
        ]);

        SupportTicket::create([
            'user_id' => $request->user()->id,
            'question_id' => $request->question_id,
            'subject' => $request->subject,
            'message' => $request->message,
            'status' => 'open',
        ]);

        return back()->with('success', 'Pesan bantuanmu telah terkirim ke tim akademik BISA. Kami akan merespons secepatnya!');
    }
}

