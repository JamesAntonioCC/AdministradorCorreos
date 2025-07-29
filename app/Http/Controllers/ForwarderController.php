<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Forwarder;
use App\Models\Mailbox;
use Illuminate\Routing\Controller;

class ForwarderController extends Controller
{
    public function index()
    {
        $forwarders = Forwarder::with(['sourceMailbox', 'destinationMailbox'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('forwarders.index', compact('forwarders'));
    }

    public function create()
    {
        $mailboxes = Mailbox::where('active', true)->get();
        return view('forwarders.create', compact('mailboxes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'source' => 'required|string|max:255',
            'destination' => 'required|email|max:255',
            'active' => 'boolean'
        ]);

        // Agregar el dominio al email fuente
        $sourceEmail = $validated['source'] . '@devdatep.com';

        // Verificar que el email fuente no exista como mailbox
        if (Mailbox::where('email', $sourceEmail)->exists()) {
            return back()->withErrors([
                'source' => 'This email address already exists as a mailbox.'
            ])->withInput();
        }

        // Verificar que no exista ya un forwarder con la misma fuente
        if (Forwarder::where('source_email', $sourceEmail)->exists()) {
            return back()->withErrors([
                'source' => 'A forwarder for this email address already exists.'
            ])->withInput();
        }

        Forwarder::create([
            'source_email' => $sourceEmail,
            'destination_email' => $validated['destination'],
            'active' => $request->has('active'),
        ]);

        return redirect()->route('forwarders.index')
            ->with('success', 'Forwarder created successfully!');
    }

    public function edit(Forwarder $forwarder)
    {
        $mailboxes = Mailbox::where('active', true)->get();
        return view('forwarders.edit', compact('forwarder', 'mailboxes'));
    }

    public function update(Request $request, Forwarder $forwarder)
    {
        $validated = $request->validate([
            'destination' => 'required|email|max:255',
            'active' => 'boolean'
        ]);

        $forwarder->update([
            'destination_email' => $validated['destination'],
            'active' => $request->has('active'),
        ]);

        return redirect()->route('forwarders.index')
            ->with('success', 'Forwarder updated successfully!');
    }

    public function destroy(Forwarder $forwarder)
    {
        $forwarder->delete();

        return redirect()->route('forwarders.index')
            ->with('success', 'Forwarder deleted successfully!');
    }
}
