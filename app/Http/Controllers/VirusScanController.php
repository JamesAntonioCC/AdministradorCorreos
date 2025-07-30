<?php

namespace App\Http\Controllers;

use App\Models\VirusScan;
use Illuminate\Http\Request;

class VirusScanController extends Controller
{
    public function index()
    {
        $scans = VirusScan::latest('scanned_at')->paginate(20);
        
        $stats = [
            'clean_emails' => VirusScan::where('scan_result', 'clean')->count(),
            'threats_detected' => VirusScan::where('scan_result', '!=', 'clean')->count(),
            'quarantined' => VirusScan::where('quarantined', true)->count(),
            'scans_today' => VirusScan::whereDate('scanned_at', today())->count(),
        ];

        return view('virus-scan.index', compact('scans', 'stats'));
    }

    // NUEVO MÉTODO PARA MOSTRAR DETALLES DE UN ANÁLISIS
    public function show(VirusScan $virusScan)
    {
        return view('virus-scan.show', compact('virusScan'));
    }

    public function quarantine()
    {
        $quarantinedEmails = VirusScan::where('quarantined', true)
            ->latest('scanned_at')
            ->paginate(20);
        
        $stats = [
            'total_quarantined' => VirusScan::where('quarantined', true)->count(),
            'today_quarantined' => VirusScan::where('quarantined', true)
                ->whereDate('scanned_at', today())->count(),
            'released' => VirusScan::where('quarantined', false)
                ->where('scan_result', '!=', 'clean')->count(),
        ];

        return view('virus-scan.quarantine', compact('quarantinedEmails', 'stats'));
    }

    // NUEVO MÉTODO PARA MOSTRAR DETALLES DE UN CORREO EN CUARENTENA
    public function showQuarantine(VirusScan $virusScan)
    {
        // Verificar que el correo esté en cuarentena
        if (!$virusScan->quarantined) {
            return redirect()->route('virus-scan.quarantine')
                ->with('error', 'Este correo no está en cuarentena.');
        }

        return view('virus-scan.quarantine-show', compact('virusScan'));
    }

    public function putInQuarantine(VirusScan $virusScan)
    {
        $virusScan->update(['quarantined' => true]);
        
        return redirect()->back()->with('success', 'Correo puesto en cuarentena exitosamente.');
    }

    public function release(VirusScan $virusScan)
    {
        $virusScan->update(['quarantined' => false]);
        
        return redirect()->back()->with('success', 'Correo liberado de cuarentena exitosamente.');
    }

    public function delete(VirusScan $virusScan)
    {
        $virusScan->delete();
        
        return redirect()->back()->with('success', 'Correo eliminado permanentemente.');
    }
}
