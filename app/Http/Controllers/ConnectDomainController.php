<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ConnectDomainController extends Controller
{
    public function index()
    {
        // Información de configuración DNS
        $dnsRecords = [
            [
                'type' => 'MX',
                'name' => '@',
                'value' => 'mail.devdatep.com',
                'priority' => '10',
                'status' => 'verified'
            ],
            [
                'type' => 'A',
                'name' => 'mail',
                'value' => '192.168.1.100',
                'priority' => '-',
                'status' => 'verified'
            ],
            [
                'type' => 'TXT',
                'name' => '@',
                'value' => 'v=spf1 include:_spf.devdatep.com ~all',
                'priority' => '-',
                'status' => 'pending'
            ]
        ];

        return view('connect-domain.index', compact('dnsRecords'));
    }

    public function verify(Request $request)
    {
        // Aquí implementarías la lógica para verificar los registros DNS
        // Por ahora solo simulamos la verificación
        
        return back()->with('success', 'DNS records verification initiated. Please allow up to 24 hours for propagation.');
    }
}
