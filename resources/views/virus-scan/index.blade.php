@extends('layouts.app')

@section('title', 'Análisis de Virus - Administración de Correos')

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
            <li aria-current="page">
                <div class="flex items-center">
                    <i class="fas fa-chevron-right w-4 h-4 text-gray-400 mx-2"></i>
                    <span class="text-sm font-medium text-gray-900">Análisis de Virus</span>
                </div>
            </li>
        </ol>
    </nav>

    <!-- Page Header -->
    <div class="mb-8">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Análisis de Virus</h1>
                <p class="text-gray-600">Monitoreo y análisis de amenazas en correos electrónicos</p>
            </div>
            <div>
                <a href="{{ route('virus-scan.quarantine') }}" class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-lg text-sm transition-colors">
                    <i class="fas fa-shield-alt mr-2"></i>
                    Ver Cuarentena
                </a>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="p-3 bg-green-100 rounded-lg">
                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Correos Limpios</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['clean_emails'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="p-3 bg-red-100 rounded-lg">
                    <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Amenazas Detectadas</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['threats_detected'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="p-3 bg-yellow-100 rounded-lg">
                    <i class="fas fa-shield-alt text-yellow-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">En Cuarentena</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['quarantined'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="p-3 bg-blue-100 rounded-lg">
                    <i class="fas fa-clock text-blue-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Análisis Hoy</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['scans_today'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Virus Scans Table -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-gray-900">Análisis Recientes</h2>
                    <p class="text-sm text-gray-500">{{ $scans->total() }} análisis realizados</p>
                </div>
                <div class="flex space-x-2">
                    <select class="border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="">Todos los resultados</option>
                        <option value="clean">Limpios</option>
                        <option value="threat_detected">Amenazas</option>
                        <option value="quarantined">En cuarentena</option>
                    </select>
                    <button class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm transition-colors">
                        <i class="fas fa-sync-alt mr-2"></i>
                        Actualizar
                    </button>
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
                            Resultado
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
                    @forelse($scans as $scan)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-sm font-medium text-gray-900">{{ $scan->sender_email }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-sm text-gray-900">{{ $scan->recipient_email }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-sm text-gray-900">{{ $scan->subject }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $result = $scan->scan_result;
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
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $resultClass }}">
                                {{ $resultText }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-sm text-gray-900">{{ $scan->scanned_at->format('d/m/Y H:i') }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex items-center justify-end space-x-2">
                                <a href="{{ route('virus-scan.show', $scan->id ?? 1) }}" class="text-indigo-600 hover:text-indigo-900" title="Ver detalles">
                                    <i class="fas fa-eye w-4 h-4"></i>
                                </a>
                                @if($scan->scan_result !== 'clean' && !$scan->quarantined)
                                <form action="{{ route('virus-scan.put-in-quarantine', $scan) }}" method="POST" style="display:inline;" onsubmit="return confirm('¿Poner este correo en cuarentena?');">
                                    @csrf
                                    <button type="submit" class="text-yellow-600 hover:text-yellow-900" title="Poner en cuarentena">
                                        <i class="fas fa-shield-alt w-4 h-4"></i>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                            No hay análisis de virus disponibles.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Paginación -->
        @if($scans->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $scans->links() }}
        </div>
        @endif
    </div>
</div>

<script>
function viewScanDetails(scanId) {
    alert('Ver detalles del análisis #' + scanId);
    // Aquí puedes implementar la lógica para mostrar detalles
}
</script>
@endsection