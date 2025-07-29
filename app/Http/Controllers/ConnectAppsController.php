<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ConnectAppsController extends Controller
{
    public function index()
    {
        // Configuraciones para diferentes clientes de correo
        $emailClients = [
            'outlook' => [
                'name' => 'Microsoft Outlook',
                'incoming' => [
                    'server' => 'mail.devdatep.com',
                    'port' => 993,
                    'security' => 'SSL/TLS'
                ],
                'outgoing' => [
                    'server' => 'mail.devdatep.com',
                    'port' => 587,
                    'security' => 'STARTTLS'
                ]
            ],
            'thunderbird' => [
                'name' => 'Mozilla Thunderbird',
                'incoming' => [
                    'server' => 'mail.devdatep.com',
                    'port' => 993,
                    'security' => 'SSL/TLS'
                ],
                'outgoing' => [
                    'server' => 'mail.devdatep.com',
                    'port' => 587,
                    'security' => 'STARTTLS'
                ]
            ],
            'apple_mail' => [
                'name' => 'Apple Mail',
                'incoming' => [
                    'server' => 'mail.devdatep.com',
                    'port' => 993,
                    'security' => 'SSL/TLS'
                ],
                'outgoing' => [
                    'server' => 'mail.devdatep.com',
                    'port' => 587,
                    'security' => 'STARTTLS'
                ]
            ]
        ];

        return view('connect-apps.index', compact('emailClients'));
    }
}
