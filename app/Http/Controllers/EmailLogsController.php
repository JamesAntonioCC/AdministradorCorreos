<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EmailLogsController extends Controller
{
    public function index(Request $request)
    {
        // Simulamos logs de correo - en una implementación real esto vendría de la base de datos
        $logs = collect([
            [
                'id' => 1,
                'timestamp' => now()->subMinutes(5),
                'from' => 'ventas@equipo1.com',
                'to' => 'cliente@example.com',
                'subject' => 'Propuesta comercial',
                'status' => 'delivered',
                'size' => '2.3 KB'
            ],
            [
                'id' => 2,
                'timestamp' => now()->subMinutes(15),
                'from' => 'info@example.com',
                'to' => 'reclutamiento@equipo1.com',
                'subject' => 'Consulta sobre servicios',
                'status' => 'received',
                'size' => '1.8 KB'
            ],
            [
                'id' => 3,
                'timestamp' => now()->subHour(),
                'from' => 'gerencia@equipo1.com',
                'to' => 'equipo@equipo1.com',
                'subject' => 'Reunión semanal',
                'status' => 'failed',
                'size' => '3.1 KB'
            ]
        ]);

        // Filtros
        if ($request->filled('status')) {
            $logs = $logs->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $logs = $logs->filter(function ($log) use ($search) {
                return str_contains($log['from'], $search) || 
                       str_contains($log['to'], $search) || 
                       str_contains($log['subject'], $search);
            });
        }

        return view('email-logs.index', compact('logs'));
    }
}
