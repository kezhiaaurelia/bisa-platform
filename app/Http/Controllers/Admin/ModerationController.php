<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SupportTicket;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ModerationController extends Controller
{
    public function index(Request $request): View
    {
        $tickets = SupportTicket::with(['user', 'question'])->latest()->paginate(15);

        return view('admin.moderation.index', compact('tickets'));
    }

    public function reply(Request $request, int $id): RedirectResponse
    {
        $request->validate([
            'admin_reply' => ['required', 'string', 'max:2000'],
            'status' => ['required', 'in:open,resolved,closed'],
        ]);

        $ticket = SupportTicket::findOrFail($id);
        $ticket->update([
            'admin_reply' => $request->admin_reply,
            'status' => $request->status,
        ]);

        return back()->with('success', 'Balasan tiket berhasil dikirim ke siswa.');
    }
}

