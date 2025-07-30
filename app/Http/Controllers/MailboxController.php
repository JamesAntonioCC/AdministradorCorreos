<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mailbox;
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
        ], [
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.unique' => 'Este correo electrónico ya existe.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'quota.required' => 'La cuota de almacenamiento es obligatoria.',
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
            ->with('success', '¡Buzón creado exitosamente!');
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
        ], [
            'quota.required' => 'La cuota de almacenamiento es obligatoria.',
        ]);

        $mailbox->update([
            'quota' => $validated['quota'] === 'unlimited' ? null : (int)$validated['quota'] * 1024,
            'active' => $request->has('active'),
        ]);

        return redirect()->route('mailboxes.index')
            ->with('success', '¡Buzón actualizado exitosamente!');
    }

    public function destroy(Mailbox $mailbox)
    {
        try {
            // Eliminar alias y forwarders relacionados (soft delete también)
            $mailbox->aliases()->delete();
            $mailbox->forwardersAsSource()->delete();
            $mailbox->forwardersAsDestination()->delete();
            $mailbox->autoReplies()->delete();
            
            // Soft delete del mailbox
            $mailbox->delete();

            return redirect()->route('mailboxes.index')
                ->with('success', '¡Buzón eliminado exitosamente!');
        } catch (\Exception $e) {
            return redirect()->route('mailboxes.index')
                ->with('error', 'Error al eliminar el buzón: ' . $e->getMessage());
        }
    }

    public function changePassword(Request $request, Mailbox $mailbox)
    {
        $validated = $request->validate([
            'password' => ['required', 'confirmed', Password::min(8)],
        ], [
            'password.required' => 'La contraseña es obligatoria.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
        ]);

        $mailbox->update([
            'password' => Hash::make($validated['password']),
        ]);

        return back()->with('success', '¡Contraseña cambiada exitosamente!');
    }
}
