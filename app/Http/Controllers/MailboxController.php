<?php

namespace App\Http\Controllers;

use App\Models\Mailbox;
use App\Models\EmailAlias;
use App\Models\Forwarder;
use App\Models\AutoReply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class MailboxController extends Controller
{
    public function index()
    {
        $mailboxes = Mailbox::with(['aliases', 'autoReplies'])->get();
        return view('mailboxes.index', compact('mailboxes'));
    }

    public function create()
    {
        return view('mailboxes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|string|max:255|unique:mailboxes,email',
            'password' => ['required', 'confirmed', Password::min(8)],
            'quota' => 'required|in:1,2,5,10,unlimited',
            'active' => 'boolean'
        ], [
            'email.required' => 'La dirección de correo es obligatoria.',
            'email.unique' => 'Esta dirección de correo ya existe.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'quota.required' => 'La cuota de almacenamiento es obligatoria.',
        ]);

        // Convertir quota a MB
        $quotaInMB = $request->quota === 'unlimited' ? null : (int)$request->quota * 1024;

        Mailbox::create([
            'email' => $request->email . '@equipo1.com',
            'password' => Hash::make($request->password),
            'quota' => $quotaInMB,
            'active' => $request->boolean('active', true),
        ]);

        return redirect()->route('mailboxes.index')
            ->with('success', 'Buzón de correo creado exitosamente.');
    }

    public function show(Mailbox $mailbox)
    {
        $mailbox->load(['aliases', 'autoReplies']);
        return view('mailboxes.show', compact('mailbox'));
    }

    public function edit(Mailbox $mailbox)
    {
        return view('mailboxes.edit', compact('mailbox'));
    }

    public function update(Request $request, Mailbox $mailbox)
    {
        $request->validate([
            'quota' => 'required|in:1,2,5,10,unlimited',
            'active' => 'boolean'
        ], [
            'quota.required' => 'La cuota de almacenamiento es obligatoria.',
        ]);

        // Convertir quota a MB
        $quotaInMB = $request->quota === 'unlimited' ? null : (int)$request->quota * 1024;

        $mailbox->update([
            'quota' => $quotaInMB,
            'active' => $request->boolean('active'),
        ]);

        return redirect()->route('mailboxes.index')
            ->with('success', 'Buzón de correo actualizado exitosamente.');
    }

    public function destroy(Mailbox $mailbox)
    {
        try {
            // Soft delete related aliases
            EmailAlias::where('mailbox_id', $mailbox->id)->delete();
            
            // Soft delete related forwarders
            Forwarder::where('source_email', $mailbox->email)
                ->orWhere('destination_email', $mailbox->email)
                ->delete();
            
            // Soft delete related auto replies
            AutoReply::where('mailbox_id', $mailbox->id)->delete();
            
            // Soft delete the mailbox
            $mailbox->delete();
            
            return redirect()->route('mailboxes.index')
                ->with('success', 'Buzón de correo eliminado exitosamente.');
                
        } catch (\Exception $e) {
            return redirect()->route('mailboxes.index')
                ->with('error', 'Error al eliminar el buzón de correo: ' . $e->getMessage());
        }
    }

    public function changePassword(Request $request, Mailbox $mailbox)
    {
        $request->validate([
            'password' => ['required', 'confirmed', Password::min(8)],
        ], [
            'password.required' => 'La contraseña es obligatoria.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
        ]);

        $mailbox->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->back()
            ->with('success', 'Contraseña actualizada exitosamente.');
    }
}
