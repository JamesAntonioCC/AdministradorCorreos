<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mailbox;
use App\Models\Forwarder;
use App\Models\EmailAlias;
use Illuminate\Routing\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        // Obtener estadísticas para el dashboard
        $stats = [
            'total_mailboxes' => Mailbox::count(),
            'active_mailboxes' => Mailbox::where('active', true)->count(),
            'forwarders' => Forwarder::count(),
            'storage_used' => $this->calculateStorageUsed(),
        ];

        // Obtener buzones recientes
        $recentMailboxes = Mailbox::latest()
            ->take(3)
            ->get()
            ->map(function ($mailbox) {
                return [
                    'email' => $mailbox->email,
                    'created' => $mailbox->created_at->diffForHumans(),
                ];
            });

        return view('dashboard', compact('stats', 'recentMailboxes'));
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
}
