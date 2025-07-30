<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Mailbox;
use App\Models\Forwarder;
use App\Models\EmailAlias;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Crear usuario administrador
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@devdatep.com',
            'password' => Hash::make('password123'),
        ]);

        // Crear algunos mailboxes de ejemplo
        $mailboxes = [
            [
                'email' => 'ventas@devdatep.com',
                'password' => Hash::make('password123'),
                'quota' => 1024,
                'storage_used' => 3670000,
                'active' => true
            ],
            [
                'email' => 'reclutamiento@devdatep.com',
                'password' => Hash::make('password123'),
                'quota' => 1024,
                'storage_used' => 50960000,
                'active' => true
            ],
            [
                'email' => 'gerencia@devdatep.com',
                'password' => Hash::make('password123'),
                'quota' => 2048,
                'storage_used' => 748000,
                'active' => true
            ]
        ];

        foreach ($mailboxes as $mailboxData) {
            Mailbox::create($mailboxData);
        }

        // Crear algunos forwarders
        Forwarder::create([
            'source_email' => 'info@devdatep.com',
            'destination_email' => 'ventas@devdatep.com',
            'active' => true
        ]);

        Forwarder::create([
            'source_email' => 'support@devdatep.com',
            'destination_email' => 'reclutamiento@devdatep.com',
            'active' => true
        ]);

        // Crear algunos alias
        $ventas = Mailbox::where('email', 'ventas@devdatep.com')->first();
        $gerencia = Mailbox::where('email', 'gerencia@devdatep.com')->first();

        EmailAlias::create([
            'alias_email' => 'contacto@devdatep.com',
            'mailbox_id' => $ventas->id,
            'active' => true
        ]);

        EmailAlias::create([
            'alias_email' => 'admin@devdatep.com',
            'mailbox_id' => $gerencia->id,
            'active' => true
        ]);
    }
}
