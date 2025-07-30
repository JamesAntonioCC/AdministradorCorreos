<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TutorialsController extends Controller
{
    public function index()
    {
        $tutorials = [
            [
                'title' => 'Setting up your first mailbox',
                'description' => 'Learn how to create and configure your first email account',
                'duration' => '5 min',
                'category' => 'Getting Started'
            ],
            [
                'title' => 'Configuring email forwarders',
                'description' => 'Set up email forwarding to redirect messages',
                'duration' => '3 min',
                'category' => 'Configuration'
            ],
            [
                'title' => 'Setting up email clients',
                'description' => 'Configure Outlook, Thunderbird, and other email clients',
                'duration' => '8 min',
                'category' => 'Email Clients'
            ],
            [
                'title' => 'Managing DNS records',
                'description' => 'Configure MX, SPF, and DKIM records for your domain',
                'duration' => '10 min',
                'category' => 'DNS'
            ]
        ];

        return view('tutorials.index', compact('tutorials'));
    }
}
