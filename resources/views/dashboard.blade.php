@extends('layouts.app')

@section('title', 'Dashboard - Administración de Correos')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Overview</h1>
        <p class="text-gray-600">Email administration dashboard</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="p-2 bg-indigo-100 rounded-lg">
                    <i class="fas fa-envelope text-indigo-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Mailboxes</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['total_mailboxes'] ?? 4 }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="p-2 bg-green-100 rounded-lg">
                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Active Mailboxes</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['active_mailboxes'] ?? 4 }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="p-2 bg-yellow-100 rounded-lg">
                    <i class="fas fa-share text-yellow-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Forwarders</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['forwarders'] ?? 3 }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="p-2 bg-purple-100 rounded-lg">
                    <i class="fas fa-database text-purple-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Storage Used</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['storage_used'] ?? '55.2 MB' }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Recent Mailboxes</h3>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @foreach([
                        ['email' => 'ventas@devdatep.com', 'created' => '2 days ago'],
                        ['email' => 'reclutamiento@devdatep.com', 'created' => '1 week ago'],
                        ['email' => 'gerencia@devdatep.com', 'created' => '2 weeks ago']
                    ] as $mailbox)
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-indigo-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-envelope text-indigo-600 text-sm"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900">{{ $mailbox['email'] }}</p>
                                <p class="text-xs text-gray-500">Created {{ $mailbox['created'] }}</p>
                            </div>
                        </div>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            Active
                        </span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Quick Actions</h3>
            </div>
            <div class="p-6">
                <div class="space-y-3">
                    <a href="{{ route('mailboxes.create') }}" class="flex items-center p-3 rounded-lg border border-gray-200 hover:bg-gray-50 transition-colors">
                        <div class="p-2 bg-indigo-100 rounded-lg">
                            <i class="fas fa-plus text-indigo-600"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-900">Create Mailbox</p>
                            <p class="text-xs text-gray-500">Add a new email account</p>
                        </div>
                    </a>
                    
                    <a href="{{ route('forwarders.create') }}" class="flex items-center p-3 rounded-lg border border-gray-200 hover:bg-gray-50 transition-colors">
                        <div class="p-2 bg-green-100 rounded-lg">
                            <i class="fas fa-share text-green-600"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-900">Setup Forwarder</p>
                            <p class="text-xs text-gray-500">Forward emails to another address</p>
                        </div>
                    </a>
                    
                    <a href="{{ route('email-alias.create') }}" class="flex items-center p-3 rounded-lg border border-gray-200 hover:bg-gray-50 transition-colors">
                        <div class="p-2 bg-yellow-100 rounded-lg">
                            <i class="fas fa-at text-yellow-600"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-900">Create Alias</p>
                            <p class="text-xs text-gray-500">Add an email alias</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
