@extends('layouts.app')

@section('title', 'Detalles del Análisis - Administración de Correos')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Breadcrumb -->
    <nav class="flex mb-6" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('dashboard') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-indigo-600">
                    <i class="fas fa-home w-4 h-4 mr-2"></i>
                    Inicio
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <i class="fas fa-chevron-right w-4 h-4 text-gray-400 mx-2"></i>
                    <a href="{{ route('virus-scan.index') }}" class="text-sm font-medium text-gray-700 hover:text-indigo-600">Análisis de Virus</a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <i class="fas fa-chevron-right w-4 h-4 text-gray-400 mx-2"></i>
                    <span class="text-sm font-medium text-gray-900">Detalles del Análisis</span>
                </div>
            </li>
        </ol>
    </nav>

    <!-- Page Header -->
    <div class="mb-8">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Detalles del Análisis</h1>
                <p class="text-gray-600">Información detallada del análisis de virus</p>
            </div>
            <div>
                <a href="{{ route('virus-scan.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg text-sm transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Volver
                </a>
            </div>
        </div>
    </div>

    <!-- Scan Details -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">Información del Correo</h2>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Remitente</label>
                    <p class="text-sm text-gray-900 bg-gray-50 p-3 rounded-md">{{ $virusScan->sender_email }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Destinatario</label>
                    <p class="text-sm text-gray-900 bg-gray-50 p-3 rounded-md">{{ $virusScan->recipient_email }}</p>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Asunto</label>
                    <p class="text-sm text-gray-900 bg-gray-50 p-3 rounded-md">{{ $virusScan->subject }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Resultado del Análisis</label>
                    @php
                        $result = $virusScan->scan_result;
                        $resultText = [
                            'clean' => 'Limpio',
                            'threat_detected' => 'Amenaza Detectada',
                            'suspicious' => 'Sospechoso',
                            'error' => 'Error'
                        ][$result] ?? 'Desconocido';
                        
                        $resultClass = [
                            'clean' => 'bg-green-100 text-green-800',
                            'threat_detected' => 'bg-red-100 text-red-800',
                            'suspicious' => 'bg-yellow-100 text-yellow-800',
                            'error' => 'bg-gray-100 text-gray-800'
                        ][$result] ?? 'bg-gray-100 text-gray-800';
                    @endphp
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $resultClass }}">
                        {{ $resultText }}
                    </span>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Estado</label>
                    @if($virusScan->quarantined)
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                            <i class="fas fa-lock mr-1"></i>
                            En Cuarentena
                        </span>
                    @else
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                            <i class="fas fa-check mr-1"></i>
                            Libre
                        </span>
                    @endif
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Fecha de Análisis</label>
                    <p class="text-sm text-gray-900 bg-gray-50 p-3 rounded-md">{{ $virusScan->scanned_at->format('d/m/Y H:i:s') }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">ID del Análisis</label>
                    <p class="text-sm text-gray-900 bg-gray-50 p-3 rounded-md">{{ $virusScan->id }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Actions -->
    <div class="mt-6 flex justify-end space-x-3">
        @if($virusScan->scan_result !== 'clean' && !$virusScan->quarantined)
        <form action="{{ route('virus-scan.put-in-quarantine', $virusScan) }}" method="POST" onsubmit="return confirm('¿Poner este correo en cuarentena?');">
            @csrf
            <button type="submit" class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-lg text-sm transition-colors">
                <i class="fas fa-shield-alt mr-2"></i>
                Poner en Cuarentena
            </button>
        </form>
        @endif

        @if($virusScan->quarantined)
        <form action="{{ route('virus-scan.release', $virusScan) }}" method="POST" onsubmit="return confirm('¿Liberar este correo de cuarentena?');">
            @csrf
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm transition-colors">
                <i class="fas fa-unlock mr-2"></i>
                Liberar de Cuarentena
            </button>
        </form>
        @endif

        <form action="{{ route('virus-scan.delete', $virusScan) }}" method="POST" onsubmit="return confirm('¿Eliminar permanentemente este correo?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm transition-colors">
                <i class="fas fa-trash mr-2"></i>
                Eliminar
            </button>
        </form>
    </div>
</div>
@endsection
