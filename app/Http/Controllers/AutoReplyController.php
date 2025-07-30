<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AutoReply;
use App\Models\Mailbox;

class AutoReplyController extends Controller
{
    public function index()
    {
        $autoReplies = AutoReply::with('mailbox')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('auto-reply.index', compact('autoReplies'));
    }

    public function create()
    {
        $mailboxes = Mailbox::where('active', true)->get();
        return view('auto-reply.create', compact('mailboxes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'mailbox_id' => 'required|exists:mailboxes,id',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'active' => 'boolean'
        ]);

        AutoReply::create([
            'mailbox_id' => $validated['mailbox_id'],
            'subject' => $validated['subject'],
            'message' => $validated['message'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'active' => $request->has('active'),
        ]);

        return redirect()->route('auto-reply.index')
            ->with('success', '¡Respuesta automática creada exitosamente!');
    }

    public function edit(AutoReply $autoReply)
    {
        $mailboxes = Mailbox::where('active', true)->get();
        return view('auto-reply.edit', compact('autoReply', 'mailboxes'));
    }

    public function update(Request $request, AutoReply $autoReply)
    {
        $validated = $request->validate([
            'mailbox_id' => 'required|exists:mailboxes,id',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'active' => 'boolean'
        ]);

        $autoReply->update([
            'mailbox_id' => $validated['mailbox_id'],
            'subject' => $validated['subject'],
            'message' => $validated['message'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'active' => $request->has('active'),
        ]);

        return redirect()->route('auto-reply.index')
            ->with('success', '¡Respuesta automática actualizada exitosamente!');
    }

    public function destroy(AutoReply $autoReply)
    {
        $autoReply->delete();

        return redirect()->route('auto-reply.index')
            ->with('success', '¡Respuesta automática eliminada exitosamente!');
    }
}
