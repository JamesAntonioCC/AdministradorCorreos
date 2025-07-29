<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mailbox;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class MailboxController extends Controller
{
    public function index()
    {
        $mailboxes = Mailbox::orderBy('created_at', 'desc')->get();
        $remainingMailboxes = 100 - $mailboxes->count(); // Límite de ejemplo

        return view('mailboxes.index', compact('mailboxes', 'remainingMailboxes'));
    }

    public function create()
    {
        return view('mailboxes.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|string|max:255|unique:mailboxes,email',
            'password' => ['required', 'confirmed', Password::min(8)],
            'quota' => 'required|in:1,2,5,10,unlimited',
            'active' => 'boolean'
        ]);

        // Agregar el dominio al email
        $fullEmail = $validated['email'] . '@devdatep.com';

        $mailbox = Mailbox::create([
            'email' => $fullEmail,
            'password' => Hash::make($validated['password']),
            'quota' => $validated['quota'] === 'unlimited' ? null : (int)$validated['quota'] * 1024, // MB
            'storage_used' => 0,
            'active' => $request->has('active'),
        ]);

        return redirect()->route('mailboxes.index')
            ->with('success', 'Mailbox created successfully!');
    }

    public function show(Mailbox $mailbox)
    {
        return view('mailboxes.show', compact('mailbox'));
    }

    public function edit(Mailbox $mailbox)
    {
        return view('mailboxes.edit', compact('mailbox'));
    }

    public function update(Request $request, Mailbox $mailbox)
    {
        $validated = $request->validate([
            'quota' => 'required|in:1,2,5,10,unlimited',
            'active' => 'boolean'
        ]);

        $mailbox->update([
            'quota' => $validated['quota'] === 'unlimited' ? null : (int)$validated['quota'] * 1024,
            'active' => $request->has('active'),
        ]);

        return redirect()->route('mailboxes.index')
            ->with('success', 'Mailbox updated successfully!');
    }

    public function destroy(Mailbox $mailbox)
    {
        // Eliminar alias y forwarders relacionados
        $mailbox->aliases()->delete();
        $mailbox->forwardersAsSource()->delete();
        $mailbox->forwardersAsDestination()->delete();
        
        $mailbox->delete();

        return redirect()->route('mailboxes.index')
            ->with('success', 'Mailbox deleted successfully!');
    }

    public function changePassword(Request $request, Mailbox $mailbox)
    {
        $validated = $request->validate([
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        $mailbox->update([
            'password' => Hash::make($validated['password']),
        ]);

        return back()->with('success', 'Password changed successfully!');
    }
}
