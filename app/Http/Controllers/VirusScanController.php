<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VirusScan;

class VirusScanController extends Controller
{
    public function index(Request $request)
    {
        $query = VirusScan::query();

        // Filtros
        if ($request->filled('scan_result')) {
            $query->where('scan_result', $request->scan_result);
        }

        if ($request->filled('threat_type')) {
            $query->where('threat_type', $request->threat_type);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('sender_email', 'like', "%{$search}%")
                  ->orWhere('recipient_email', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%")
                  ->orWhere('threat_name', 'like', "%{$search}%");
            });
        }

        if ($request->filled('date_from')) {
            $query->whereDate('scanned_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('scanned_at', '<=', $request->date_to);
        }

        $scans = $query->orderBy('scanned_at', 'desc')->paginate(20);

        // Estadísticas
        $stats = [
            'total_scans' => VirusScan::count(),
            'threats_detected' => VirusScan::threatDetected()->count(),
            'quarantined' => VirusScan::quarantined()->count(),
            'today_scans' => VirusScan::today()->count(),
        ];

        return view('virus-scan.index', compact('scans', 'stats'));
    }

    public function quarantine(VirusScan $virusScan)
    {
        $virusScan->update(['quarantined' => true]);
        
        return back()->with('success', '¡Correo puesto en cuarentena exitosamente!');
    }

    public function release(VirusScan $virusScan)
    {
        $virusScan->update(['quarantined' => false]);
        
        return back()->with('success', '¡Correo liberado de cuarentena!');
    }

    // Simular escaneo de virus (en producción esto sería un job/queue)
    public static function simulateScan($senderEmail, $recipientEmail, $subject = null)
    {
        // Simular diferentes tipos de amenazas
        $threats = [
            ['type' => 'virus', 'name' => 'Win32.Trojan.Generic', 'probability' => 0.05],
            ['type' => 'malware', 'name' => 'Adware.Generic', 'probability' => 0.03],
            ['type' => 'phishing', 'name' => 'Phishing.Banking', 'probability' => 0.02],
            ['type' => 'suspicious_link', 'name' => 'Enlace.Sospechoso', 'probability' => 0.08],
            ['type' => 'spam', 'name' => 'Spam.Generic', 'probability' => 0.15],
        ];

        $scanResult = 'clean';
        $threatType = null;
        $threatName = null;
        $quarantined = false;

        // Simular detección de amenazas
        foreach ($threats as $threat) {
            if (rand(1, 100) <= ($threat['probability'] * 100)) {
                $scanResult = 'threat_detected';
                $threatType = $threat['type'];
                $threatName = $threat['name'];
                $quarantined = in_array($threat['type'], ['virus', 'malware', 'phishing']);
                break;
            }
        }

        return VirusScan::create([
            'email_id' => 'email_' . uniqid(),
            'sender_email' => $senderEmail,
            'recipient_email' => $recipientEmail,
            'subject' => $subject,
            'scan_result' => $scanResult,
            'threat_type' => $threatType,
            'threat_name' => $threatName,
            'quarantined' => $quarantined,
            'scanned_at' => now(),
        ]);
    }
}
