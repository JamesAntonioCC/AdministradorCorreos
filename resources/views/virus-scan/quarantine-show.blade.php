@extends('layouts.app')

@section('title', 'Detalles de Cuarentena - Administración de Correos')

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
                    <a href="{{ route('virus-scan.quarantine') }}" class="text-sm font-medium text-gray-700 hover:text-indigo-600">Cuarentena</a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <i class="fas fa-chevron-right w-4 h-4 text-gray-400 mx-2"></i>
                    <span class="text-sm font-medium text-gray-900">Detalles</span>
                </div>
            </li>
        </ol>
    </nav>

    <!-- Page Header -->
    <div class="mb-8">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Correo en Cuarentena</h1>
                <p class="text-gray-600">Detalles del correo puesto en cuarentena</p>
            </div>
            <div>
                <a href="{{ route('virus-scan.quarantine') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg text-sm transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Volver a Cuarentena
                </a>
            </div>
        </div>
    </div>

    <!-- Warning Alert -->
    <div class="mb-6 bg-red-50 border border-red-200 rounded-md p-4">
        <div class="flex">
            <div class="flex-shrink-0">
                <i class="fas fa-exclamation-triangle text-red-400"></i>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-red-800">Correo en Cuarentena</h3>
                <p class="mt-1 text-sm text-red-700">Este correo ha sido puesto en cuarentena debido a amenazas detectadas. Manéjalo con precaución.</p>
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
                    <label class="block text-sm font-medium text-gray-700 mb-2">Amenaza Detectada</label>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                        <i class="fas fa-exclamation-triangle mr-1"></i>
                        {{ $virusScan->threat_name ?? $virusScan->scan_result }}
                    </span>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Fecha de Cuarentena</label>
                    <p class="text-sm text-gray-900 bg-gray-50 p-3 rounded-md">{{ $virusScan->scanned_at->format('d/m/Y H:i:s') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Actions -->
    <div class="mt-6 flex justify-end space-x-3">
        <form action="{{ route('virus-scan.release', $virusScan) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que quieres liberar este correo de cuarentena?');">
            @csrf
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm transition-colors">
                <i class="fas fa-unlock mr-2"></i>
                Liberar de Cuarentena
            </button>
        </form>

        <form action="{{ route('virus-scan.delete', $virusScan) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que quieres eliminar permanentemente este correo?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm transition-colors">
                <i class="fas fa-trash mr-2"></i>
                Eliminar Permanentemente
            </button>
        </form>
    </div>
</div>
@endsection
