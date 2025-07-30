<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmailAlias;
use App\Models\Mailbox;

class EmailAliasController extends Controller
{
    public function index()
    {
        $aliases = EmailAlias::with('mailbox')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('email-alias.index', compact('aliases'));
    }

    public function create()
    {
        $mailboxes = Mailbox::where('active', true)->get();
        return view('email-alias.create', compact('mailboxes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'alias' => 'required|string|max:255',
            'forwards_to' => 'required|exists:mailboxes,email',
            'active' => 'boolean'
        ]);

        // Agregar el dominio al alias
        $aliasEmail = $validated['alias'] . '@devdatep.com';

        // Verificar que el alias no exista como mailbox
        if (Mailbox::where('email', $aliasEmail)->exists()) {
            return back()->withErrors([
                'alias' => 'This email address already exists as a mailbox.'
            ])->withInput();
        }

        // Verificar que no exista ya un alias con el mismo email
        if (EmailAlias::where('alias_email', $aliasEmail)->exists()) {
            return back()->withErrors([
                'alias' => 'This alias already exists.'
            ])->withInput();
        }

        // Obtener el mailbox de destino
        $mailbox = Mailbox::where('email', $validated['forwards_to'])->first();

        EmailAlias::create([
            'alias_email' => $aliasEmail,
            'mailbox_id' => $mailbox->id,
            'active' => $request->has('active'),
        ]);

        return redirect()->route('email-alias.index')
            ->with('success', 'Email alias created successfully!');
    }

    public function edit(EmailAlias $alias)
    {
        $mailboxes = Mailbox::where('active', true)->get();
        return view('email-alias.edit', compact('alias', 'mailboxes'));
    }

    public function update(Request $request, EmailAlias $alias)
    {
        $validated = $request->validate([
            'forwards_to' => 'required|exists:mailboxes,email',
            'active' => 'boolean'
        ]);

        $mailbox = Mailbox::where('email', $validated['forwards_to'])->first();

        $alias->update([
            'mailbox_id' => $mailbox->id,
            'active' => $request->has('active'),
        ]);

        return redirect()->route('email-alias.index')
            ->with('success', 'Email alias updated successfully!');
    }

    public function destroy(EmailAlias $alias)
    {
        $alias->delete();

        return redirect()->route('email-alias.index')
            ->with('success', 'Email alias deleted successfully!');
    }
}
