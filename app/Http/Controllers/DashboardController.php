<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mailbox;
use App\Models\Forwarder;
use App\Models\EmailAlias;
use App\Models\VirusScan;

class DashboardController extends Controller
{
    public function index()
    {
        // Obtener estadísticas reales de la base de datos
        $stats = [
            'total_mailboxes' => Mailbox::count(),
            'active_mailboxes' => Mailbox::where('active', true)->count(),
            'forwarders' => Forwarder::count(),
            'storage_used' => $this->calculateStorageUsed(),
        ];

        // Estadísticas de seguridad
        $securityStats = [
            'total_scans' => VirusScan::count(),
            'threats_detected' => VirusScan::threatDetected()->count(),
            'threats_today' => VirusScan::threatDetected()->today()->count(),
            'quarantined' => VirusScan::quarantined()->count(),
        ];

        // Obtener buzones recientes REALES de la base de datos
        $recentMailboxes = Mailbox::latest()
            ->take(3)
            ->get();

        // Obtener amenazas recientes
        $recentThreats = VirusScan::threatDetected()
            ->latest('scanned_at')
            ->take(5)
            ->get();

        // Simular algunos escaneos para demo (remover en producción)
        $this->simulateScansForDemo();

        return view('dashboard', compact('stats', 'securityStats', 'recentMailboxes', 'recentThreats'));
    }

    private function calculateStorageUsed()
    {
        // Aquí puedes implementar la lógica real para calcular el almacenamiento usado
        // Por ahora retornamos un valor de ejemplo
        $totalUsed = Mailbox::sum('storage_used') ?? 0;
        return $this->formatBytes($totalUsed);
    }

    private function formatBytes($bytes, $precision = 2)
    {
        $units = array('B', 'KB', 'MB', 'GB', 'TB');

        for ($i = 0; $bytes > 1024; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, $precision) . ' ' . $units[$i];
    }

    private function simulateScansForDemo()
    {
        // Solo simular si no hay datos de escaneo
        if (VirusScan::count() < 10) {
            $mailboxes = Mailbox::pluck('email')->toArray();
            $externalEmails = [
                'usuario@gmail.com',
                'contacto@ejemplo.com',
                'spam@sospechoso.com',
                'phishing@banco-falso.com',
                'malware@infectado.net'
            ];

            for ($i = 0; $i < 15; $i++) {
                $sender = $externalEmails[array_rand($externalEmails)];
                $recipient = $mailboxes[array_rand($mailboxes)] ?? 'test@devdatep.com';
                
                \App\Http\Controllers\VirusScanController::simulateScan(
                    $sender,
                    $recipient,
                    'Correo de Prueba ' . ($i + 1)
                );
            }
        }
    }
}
