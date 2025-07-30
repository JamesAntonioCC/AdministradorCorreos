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

        // Crear algunos análisis de virus de ejemplo - ACTUALIZADO CON NUEVOS CAMPOS
        $virusScans = [
            [
                'email_id' => 'email_001',
                'sender_email' => 'cliente@empresa.com',
                'recipient_email' => 'ventas@equipo1.com',
                'subject' => 'Consulta sobre productos',
                'message_content' => 'Estimados,

Me dirijo a ustedes para solicitar información detallada sobre su catálogo de productos. Estoy interesado en conocer precios, disponibilidad y condiciones de entrega.

Quedo atento a su respuesta.

Saludos cordiales,
Juan Pérez
Cliente Empresa S.A.',
                'attachment_name' => null,
                'attachment_content' => null,
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
                'message_content' => '¡¡¡FELICIDADES!!!

Usted ha sido seleccionado para recibir $1,000,000 USD completamente GRATIS.

Para reclamar su premio, haga clic INMEDIATAMENTE en el siguiente enlace:
http://malicious-site-fake.com/claim-prize-now

¡No pierda esta oportunidad única!

IMPORTANTE: Esta oferta expira en 24 horas.',
                'attachment_name' => 'premio.txt',
                'attachment_content' => 'hola - este es un archivo malicioso que simula contener un virus',
                'scan_result' => 'threat_detected',
                'threat_type' => 'spam',
                'threat_name' => 'Spam.Generic',
                'file_name' => 'premio.txt',
                'file_hash' => 'sha256:malicious123',
                'scan_engine' => 'ClamAV',
                'quarantined' => true,
                'scanned_at' => now()->subHours(4),
            ],
            [
                'email_id' => 'email_003',
                'sender_email' => 'phishing@fake-bank.com',
                'recipient_email' => 'admin@equipo1.com',
                'subject' => 'Verificación urgente de cuenta bancaria',
                'message_content' => 'ALERTA DE SEGURIDAD - ACCIÓN REQUERIDA

Estimado cliente,

Hemos detectado actividad sospechosa en su cuenta bancaria. Por su seguridad, necesitamos que verifique su información inmediatamente.

Haga clic aquí para verificar: http://fake-bank-security.com/verify

Si no verifica su cuenta en las próximas 2 horas, será suspendida temporalmente.

Atentamente,
Departamento de Seguridad
Banco Falso',
                'attachment_name' => 'formulario_verificacion.txt',
                'attachment_content' => 'hola - formulario falso diseñado para robar credenciales bancarias',
                'scan_result' => 'threat_detected',
                'threat_type' => 'phishing',
                'threat_name' => 'Phishing.BankFraud',
                'file_name' => 'formulario_verificacion.txt',
                'file_hash' => 'sha256:phishing456',
                'scan_engine' => 'ClamAV',
                'quarantined' => true,
                'scanned_at' => now()->subHours(6),
            ],
            [
                'email_id' => 'email_004',
                'sender_email' => 'partner@empresa-legit.com',
                'recipient_email' => 'gerencia@equipo1.com',
                'subject' => 'Propuesta de colaboración',
                'message_content' => 'Estimados señores,

Nos dirigimos a ustedes desde Empresa Legítima S.A. para proponer una alianza estratégica que podría beneficiar a ambas organizaciones.

Adjuntamos una propuesta detallada para su consideración. Estaríamos encantados de programar una reunión para discutir los detalles.

Quedamos a la espera de su respuesta.

Cordialmente,
María González
Directora de Desarrollo de Negocios
Empresa Legítima S.A.',
                'attachment_name' => null,
                'attachment_content' => null,
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
                'message_content' => 'Hola,

Por favor revise urgentemente el archivo adjunto. Contiene información crítica que necesita su atención inmediata.

No comparta este archivo con nadie más.

Gracias.',
                'attachment_name' => 'documento_importante.txt',
                'attachment_content' => 'hola - este archivo simula contener código malicioso tipo trojan',
                'scan_result' => 'threat_detected',
                'threat_type' => 'virus',
                'threat_name' => 'Win32.Trojan.Generic',
                'file_name' => 'documento.exe',
                'file_hash' => 'sha256:def789ghi012',
                'scan_engine' => 'ClamAV',
                'quarantined' => true,
                'scanned_at' => now()->subHours(12),
            ],
            [
                'email_id' => 'email_006',
                'sender_email' => 'malware@suspicious.net',
                'recipient_email' => 'reclutamiento@equipo1.com',
                'subject' => 'CV - Candidato interesado',
                'message_content' => 'Buenos días,

Adjunto mi currículum vitae para la posición publicada en su sitio web.

Tengo amplia experiencia en el área y estoy muy interesado en formar parte de su equipo.

Espero su respuesta.

Saludos,
Candidato Falso',
                'attachment_name' => 'cv_malicioso.txt',
                'attachment_content' => 'hola - archivo que simula ser un CV pero contiene malware',
                'scan_result' => 'threat_detected',
                'threat_type' => 'malware',
                'threat_name' => 'Malware.Suspicious.Generic',
                'file_name' => 'cv_malicioso.txt',
                'file_hash' => 'sha256:malware789',
                'scan_engine' => 'ClamAV',
                'quarantined' => true,
                'scanned_at' => now()->subMinutes(30),
            ]
        ];

        foreach ($virusScans as $scanData) {
            VirusScan::create($scanData);
        }
    }
}
