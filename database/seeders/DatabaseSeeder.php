<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Mailbox;
use App\Models\Forwarder;
use App\Models\EmailAlias;
use App\Models\VirusScan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Crear usuario administrador
        User::create([
            'name' => 'Administrador',
            'email' => 'admin@equipo1.com',
            'password' => Hash::make('password123'),
        ]);

        // Crear algunos mailboxes de ejemplo
        $mailboxes = [
            [
                'email' => 'ventas@equipo1.com',
                'password' => Hash::make('password123'),
                'quota' => 1024,
                'storage_used' => 3670000,
                'active' => true
            ],
            [
                'email' => 'reclutamiento@equipo1.com',
                'password' => Hash::make('password123'),
                'quota' => 1024,
                'storage_used' => 50960000,
                'active' => true
            ],
            [
                'email' => 'gerencia@equipo1.com',
                'password' => Hash::make('password123'),
                'quota' => 2048,
                'storage_used' => 748000,
                'active' => true
            ],
            [
                'email' => 'soporte@equipo1.com',
                'password' => Hash::make('password123'),
                'quota' => 1024,
                'storage_used' => 1200000,
                'active' => true
            ],
            [
                'email' => 'marketing@equipo1.com',
                'password' => Hash::make('password123'),
                'quota' => 2048,
                'storage_used' => 890000,
                'active' => true
            ]
        ];

        foreach ($mailboxes as $mailboxData) {
            Mailbox::create($mailboxData);
        }

        // Crear algunos forwarders
        Forwarder::create([
            'source_email' => 'info@equipo1.com',
            'destination_email' => 'ventas@equipo1.com',
            'active' => true
        ]);

        Forwarder::create([
            'source_email' => 'contacto@equipo1.com',
            'destination_email' => 'soporte@equipo1.com',
            'active' => true
        ]);

        Forwarder::create([
            'source_email' => 'ayuda@equipo1.com',
            'destination_email' => 'soporte@equipo1.com',
            'active' => true
        ]);

        // Crear algunos alias
        $ventas = Mailbox::where('email', 'ventas@equipo1.com')->first();
        $gerencia = Mailbox::where('email', 'gerencia@equipo1.com')->first();
        $soporte = Mailbox::where('email', 'soporte@equipo1.com')->first();

        EmailAlias::create([
            'alias_email' => 'comercial@equipo1.com',
            'mailbox_id' => $ventas->id,
            'active' => true
        ]);

        EmailAlias::create([
            'alias_email' => 'admin@equipo1.com',
            'mailbox_id' => $gerencia->id,
            'active' => true
        ]);

        EmailAlias::create([
            'alias_email' => 'help@equipo1.com',
            'mailbox_id' => $soporte->id,
            'active' => true
        ]);

        // Crear algunos análisis de virus de ejemplo
        $virusScans = [
            [
                'email_id' => 'email_001',
                'sender_email' => 'cliente@empresa.com',
                'recipient_email' => 'ventas@equipo1.com',
                'subject' => 'Consulta sobre productos',
                'scan_result' => 'clean',
                'threat_type' => null,
                'threat_name' => null,
                'file_name' => null,
                'file_hash' => null,
                'scan_engine' => 'ClamAV',
                'quarantined' => false,
                'scanned_at' => now()->subHours(2),
            ],
            [
                'email_id' => 'email_002',
                'sender_email' => 'spam@malicious.com',
                'recipient_email' => 'soporte@equipo1.com',
                'subject' => 'Oferta increíble - Haga clic aquí',
                'scan_result' => 'threat_detected',
                'threat_type' => 'spam',
                'threat_name' => 'Spam.Generic',
                'file_name' => null,
                'file_hash' => null,
                'scan_engine' => 'ClamAV',
                'quarantined' => true,
                'scanned_at' => now()->subHours(4),
            ],
            [
                'email_id' => 'email_003',
                'sender_email' => 'phishing@fake-bank.com',
                'recipient_email' => 'admin@equipo1.com',
                'subject' => 'Verificación urgente de cuenta bancaria',
                'scan_result' => 'threat_detected',
                'threat_type' => 'phishing',
                'threat_name' => 'Phishing.BankFraud',
                'file_name' => null,
                'file_hash' => null,
                'scan_engine' => 'ClamAV',
                'quarantined' => true,
                'scanned_at' => now()->subHours(6),
            ],
            [
                'email_id' => 'email_004',
                'sender_email' => 'partner@empresa-legit.com',
                'recipient_email' => 'gerencia@equipo1.com',
                'subject' => 'Propuesta de colaboración',
                'scan_result' => 'clean',
                'threat_type' => null,
                'threat_name' => null,
                'file_name' => 'propuesta.pdf',
                'file_hash' => 'sha256:abc123def456',
                'scan_engine' => 'ClamAV',
                'quarantined' => false,
                'scanned_at' => now()->subHours(8),
            ],
            [
                'email_id' => 'email_005',
                'sender_email' => 'virus@infected.com',
                'recipient_email' => 'marketing@equipo1.com',
                'subject' => 'Archivo adjunto importante',
                'scan_result' => 'threat_detected',
                'threat_type' => 'virus',
                'threat_name' => 'Win32.Trojan.Generic',
                'file_name' => 'documento.exe',
                'file_hash' => 'sha256:def789ghi012',
                'scan_engine' => 'ClamAV',
                'quarantined' => true,
                'scanned_at' => now()->subHours(12),
            ]
        ];

        foreach ($virusScans as $scanData) {
            VirusScan::create($scanData);
        }
    }
}
