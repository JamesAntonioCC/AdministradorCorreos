<?php

namespace App\Http\Controllers;

use App\Models\Mailbox;
use App\Models\EmailAlias;
use App\Models\Forwarder;
use App\Models\VirusScan;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Estadísticas generales
        $stats = [
            'total_mailboxes' => Mailbox::count(),
            'active_mailboxes' => Mailbox::where('active', true)->count(),
            'forwarders' => Forwarder::count(),
            'storage_used' => $this->formatBytes($this->getTotalStorageUsed()),
        ];

        // Estadísticas de seguridad - ESTA VARIABLE FALTABA
        $securityStats = [
            'total_scans' => VirusScan::count(),
            'threats_detected' => VirusScan::where('scan_result', '!=', 'clean')->count(),
            'threats_today' => VirusScan::where('scan_result', '!=', 'clean')
                ->whereDate('scanned_at', today())->count(),
            'quarantined' => VirusScan::where('quarantined', true)->count(),
        ];

        // Buzones recientes - CAMBIAR NOMBRE DE VARIABLE
        $recentMailboxes = Mailbox::latest()
            ->take(5)
            ->get();

        // Amenazas recientes - CAMBIAR NOMBRE Y AGREGAR PROCESAMIENTO
        $recentThreats = VirusScan::where('scan_result', '!=', 'clean')
            ->latest('scanned_at')
            ->take(5)
            ->get()
            ->map(function ($threat) {
                $threat->threat_type_icon = $this->getThreatIcon($threat->scan_result);
                $threat->scan_result_badge = $this->getScanResultBadge($threat->scan_result);
                $threat->threat_name = $this->getThreatName($threat->scan_result);
                return $threat;
            });

        return view('dashboard', compact('stats', 'securityStats', 'recentMailboxes', 'recentThreats'));
    }

    private function getTotalStorageUsed()
    {
        // Simular cálculo de almacenamiento usado
        return Mailbox::sum('storage_used') ?? 0;
    }

    private function formatBytes($bytes, $precision = 2)
    {
        $units = array('B', 'KB', 'MB', 'GB', 'TB');

        for ($i = 0; $bytes > 1024; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, $precision) . ' ' . $units[$i];
    }

    private function getThreatIcon($scanResult)
    {
        $icons = [
            'spam' => 'fas fa-envelope-open-text',
            'virus' => 'fas fa-bug',
            'malware' => 'fas fa-skull-crossbones',
            'phishing' => 'fas fa-fish',
            'suspicious' => 'fas fa-exclamation-triangle',
            'threat_detected' => 'fas fa-exclamation-triangle',
        ];

        return $icons[$scanResult] ?? 'fas fa-exclamation-triangle';
    }

    private function getScanResultBadge($scanResult)
    {
        $badges = [
            'clean' => 'bg-green-100 text-green-800',
            'spam' => 'bg-yellow-100 text-yellow-800',
            'virus' => 'bg-red-100 text-red-800',
            'malware' => 'bg-red-100 text-red-800',
            'phishing' => 'bg-orange-100 text-orange-800',
            'suspicious' => 'bg-yellow-100 text-yellow-800',
            'threat_detected' => 'bg-red-100 text-red-800',
        ];

        return $badges[$scanResult] ?? 'bg-gray-100 text-gray-800';
    }

    private function getThreatName($scanResult)
    {
        $names = [
            'spam' => 'Spam Detectado',
            'virus' => 'Virus Detectado',
            'malware' => 'Malware Detectado',
            'phishing' => 'Phishing Detectado',
            'suspicious' => 'Contenido Sospechoso',
            'threat_detected' => 'Amenaza Detectada',
        ];

        return $names[$scanResult] ?? 'Amenaza Desconocida';
    }
}
