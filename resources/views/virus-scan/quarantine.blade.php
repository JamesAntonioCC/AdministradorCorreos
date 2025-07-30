@extends('layouts.app')

@section('title', 'Cuarentena - Administración de Correos')

@section('content')
<div class="max-w-7xl mx-auto">
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
                    <span class="text-sm font-medium text-gray-900">Cuarentena</span>
                </div>
            </li>
        </ol>
    </nav>

    <!-- Page Header -->
    <div class="mb-8">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Correos en Cuarentena</h1>
                <p class="text-gray-600">Gestiona los correos que han sido puestos en cuarentena por amenazas detectadas</p>
            </div>
            <div>
                <a href="{{ route('virus-scan.index') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Volver a Análisis
                </a>
            </div>
        </div>
    </div>

    <!-- Mensajes de éxito/error -->
    @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 rounded-md p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-check-circle text-green-400"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-green-700">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="p-3 bg-red-100 rounded-lg">
                    <i class="fas fa-lock text-red-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Total en Cuarentena</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['total_quarantined'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="p-3 bg-yellow-100 rounded-lg">
                    <i class="fas fa-clock text-yellow-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Hoy</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['today_quarantined'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="p-3 bg-green-100 rounded-lg">
                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Liberados</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['released'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Quarantined Emails Table -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-gray-900">Correos en Cuarentena</h2>
                    <p class="text-sm text-gray-500">{{ $quarantinedEmails->total() }} correos en cuarentena</p>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Remitente
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Destinatario
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Asunto
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Amenaza
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Fecha
                        </th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Acciones
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($quarantinedEmails as $email)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-sm font-medium text-gray-900">{{ $email->sender_email }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-sm text-gray-900">{{ $email->recipient_email }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-sm text-gray-900">{{ $email->subject }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <i class="{{ $email->threat_type_icon }} text-red-600 mr-2"></i>
                                <span class="text-sm text-gray-900">{{ $email->threat_display_name }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-sm text-gray-900">{{ $email->scanned_at->format('d/m/Y H:i') }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex items-center justify-end space-x-2">
                                <!-- Ver detalles -->
                                <a href="{{ route('virus-scan.quarantine.show', $email->id) }}" class="text-indigo-600 hover:text-indigo-900" title="Ver detalles">
                                    <i class="fas fa-eye w-4 h-4"></i>
                                </a>

                                <!-- Liberar -->
                                <form action="{{ route('virus-scan.release', $email) }}" method="POST" style="display:inline;" onsubmit="return confirm('¿Estás seguro de que quieres liberar este correo de cuarentena?');">
                                    @csrf
                                    <button type="submit" class="text-green-600 hover:text-green-900" title="Liberar">
                                        <i class="fas fa-unlock w-4 h-4"></i>
                                    </button>
                                </form>

                                <!-- Eliminar -->
                                <form action="{{ route('virus-scan.delete', $email) }}" method="POST" style="display:inline;" onsubmit="return confirm('¿Estás seguro de que quieres eliminar permanentemente este correo?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900" title="Eliminar">
                                        <i class="fas fa-trash w-4 h-4"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                            No hay correos en cuarentena.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Paginación -->
        @if($quarantinedEmails->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $quarantinedEmails->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
