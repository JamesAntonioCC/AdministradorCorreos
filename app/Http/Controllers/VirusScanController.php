<?php

namespace App\Http\Controllers;

use App\Models\VirusScan;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class VirusScanController extends Controller
{
    public function index()
    {
        $scans = VirusScan::latest('scanned_at')->paginate(20);
        
        $stats = [
            'clean_emails' => VirusScan::clean()->count(),
            'threats_detected' => VirusScan::threats()->count(),
            'quarantined' => VirusScan::quarantined()->count(),
            'scans_today' => VirusScan::today()->count(),
        ];

        return view('virus-scan.index', compact('scans', 'stats'));
    }

    public function show(VirusScan $virusScan)
    {
        return view('virus-scan.show', compact('virusScan'));
    }

    public function quarantine()
    {
        $quarantinedEmails = VirusScan::quarantined()
            ->latest('scanned_at')
            ->paginate(20);
        
        $stats = [
            'total_quarantined' => VirusScan::quarantined()->count(),
            'today_quarantined' => VirusScan::quarantined()->today()->count(),
            'released' => VirusScan::where('quarantined', false)
                ->threats()->count(),
        ];

        return view('virus-scan.quarantine', compact('quarantinedEmails', 'stats'));
    }

    public function showQuarantine(VirusScan $virusScan)
    {
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

    public function downloadAttachment(VirusScan $virusScan)
    {
        if (!$virusScan->attachment_name || !$virusScan->attachment_content) {
            return redirect()->back()->with('error', 'No hay archivo adjunto disponible.');
        }

        return response($virusScan->attachment_content)
            ->header('Content-Type', 'text/plain')
            ->header('Content-Disposition', 'attachment; filename="' . $virusScan->attachment_name . '"');
    }
}
