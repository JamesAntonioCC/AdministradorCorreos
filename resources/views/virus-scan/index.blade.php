@extends('layouts.app')

@section('title', 'Resultados de Análisis de Virus - Administración de Correos')

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
                    <span class="text-sm font-medium text-gray-900">Resultados de Análisis de Virus</span>
                </div>
            </li>
        </ol>
    </nav>

    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Resultados de Análisis de Virus</h1>
        <p class="text-gray-600">Monitorea la seguridad del correo y detección de amenazas</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="p-2 bg-blue-100 rounded-lg">
                    <i class="fas fa-shield-alt text-blue-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Análisis</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['total_scans'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="p-2 bg-red-100 rounded-lg">
                    <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Amenazas Detectadas</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['threats_detected'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="p-2 bg-gray-100 rounded-lg">
                    <i class="fas fa-lock text-gray-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">En Cuarentena</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['quarantined'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="p-2 bg-green-100 rounded-lg">
                    <i class="fas fa-calendar-day text-green-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Análisis de Hoy</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['today_scans'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
        <div class="px-6 py-4">
            <form method="GET" class="grid grid-cols-1 md:grid-cols-6 gap-4">
                <div>
                    <input type="text" name="search" placeholder="Buscar correos..." value="{{ request('search') }}" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
                <div>
                    <select name="scan_result" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="">Todos los Resultados</option>
                        <option value="clean" {{ request('scan_result') === 'clean' ? 'selected' : '' }}>Limpio</option>
                        <option value="threat_detected" {{ request('scan_result') === 'threat_detected' ? 'selected' : '' }}>Amenaza Detectada</option>
                        <option value="suspicious" {{ request('scan_result') === 'suspicious' ? 'selected' : '' }}>Sospechoso</option>
                    </select>
                </div>
                <div>
                    <select name="threat_type" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="">Todos los Tipos de Amenaza</option>
                        <option value="virus" {{ request('threat_type') === 'virus' ? 'selected' : '' }}>Virus</option>
                        <option value="malware" {{ request('threat_type') === 'malware' ? 'selected' : '' }}>Malware</option>
                        <option value="phishing" {{ request('threat_type') === 'phishing' ? 'selected' : '' }}>Phishing</option>
                        <option value="spam" {{ request('threat_type') === 'spam' ? 'selected' : '' }}>Spam</option>
                    </select>
                </div>
                <div>
                    <input type="date" name="date_from" value="{{ request('date_from') }}" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
                <div>
                    <input type="date" name="date_to" value="{{ request('date_to') }}" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
                <div>
                    <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md transition-colors">
                        <i class="fas fa-search mr-2"></i>Filtrar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Scan Results Table -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha/Hora</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">De</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Para</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Asunto</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Resultado</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amenaza</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($scans as $scan)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-sm text-gray-900">{{ $scan->scanned_at->format('d M Y H:i') }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-sm text-gray-900">{{ $scan->sender_email }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-sm text-gray-900">{{ $scan->recipient_email }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-sm text-gray-900">{{ $scan->subject ?? 'Sin asunto' }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $scan->scan_result_badge }}">
                                @switch($scan->scan_result)
                                    @case('clean')
                                        Limpio
                                        @break
                                    @case('threat_detected')
                                        Amenaza Detectada
                                        @break
                                    @case('suspicious')
                                        Sospechoso
                                        @break
                                    @default
                                        {{ ucfirst($scan->scan_result) }}
                                @endswitch
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($scan->threat_name)
                                <div class="flex items-center">
                                    <i class="{{ $scan->threat_type_icon }} text-red-600 mr-2"></i>
                                    <span class="text-sm text-gray-900">{{ $scan->threat_name }}</span>
                                </div>
                            @else
                                <span class="text-sm text-gray-500">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            @if($scan->scan_result === 'threat_detected')
                                @if($scan->quarantined)
                                    <form action="{{ route('virus-scan.release', $scan) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="text-green-600 hover:text-green-900 mr-2">Liberar</button>
                                    </form>
                                @else
                                    <form action="{{ route('virus-scan.quarantine', $scan) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="text-red-600 hover:text-red-900 mr-2">Cuarentena</button>
                                    </form>
                                @endif
                            @endif
                            @if($scan->quarantined)
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    <i class="fas fa-lock w-3 h-3 mr-1"></i>
                                    En Cuarentena
                                </span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center">
                            <div class="text-gray-500">
                                <i class="fas fa-shield-alt text-4xl mb-4"></i>
                                <p class="text-lg font-medium">No se encontraron resultados de análisis</p>
                                <p class="text-sm">Los resultados de análisis de correo aparecerán aquí</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($scans->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $scans->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
