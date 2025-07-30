@extends('layouts.app')

@section('title', 'Panel Principal - Administración de Correos')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Panel Principal</h1>
        <p class="text-gray-600">Panel de administración de correo electrónico</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="p-2 bg-indigo-100 rounded-lg">
                    <i class="fas fa-envelope text-indigo-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Buzones</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['total_mailboxes'] ?? 0 }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="p-2 bg-green-100 rounded-lg">
                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Buzones Activos</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['active_mailboxes'] ?? 0 }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="p-2 bg-yellow-100 rounded-lg">
                    <i class="fas fa-share text-yellow-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Reenvíos</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['forwarders'] ?? 0 }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="p-2 bg-purple-100 rounded-lg">
                    <i class="fas fa-database text-purple-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Almacenamiento Usado</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['storage_used'] ?? '0 B' }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Security Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="p-2 bg-blue-100 rounded-lg">
                    <i class="fas fa-shield-alt text-blue-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Análisis</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $securityStats['total_scans'] ?? 0 }}</p>
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
                    <p class="text-2xl font-bold text-gray-900">{{ $securityStats['threats_detected'] ?? 0 }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="p-2 bg-orange-100 rounded-lg">
                    <i class="fas fa-clock text-orange-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Amenazas Hoy</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $securityStats['threats_today'] ?? 0 }}</p>
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
                    <p class="text-2xl font-bold text-gray-900">{{ $securityStats['quarantined'] ?? 0 }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Threat Detection Chart -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Detección de Amenazas (Últimos 7 días)</h3>
            </div>
            <canvas id="threatChart" width="400" height="200"></canvas>
        </div>

        <!-- Threat Types Distribution -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Tipos de Amenazas</h3>
            </div>
            <canvas id="threatTypesChart" width="400" height="200"></canvas>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Buzones Recientes</h3>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @forelse($recentMailboxes as $mailbox)
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-indigo-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-envelope text-indigo-600 text-sm"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900">{{ $mailbox->email }}</p>
                                <p class="text-xs text-gray-500">Creado {{ $mailbox->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $mailbox->active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $mailbox->active ? 'Activo' : 'Inactivo' }}
                        </span>
                    </div>
                    @empty
                    <div class="text-center text-gray-500 py-8">
                        <i class="fas fa-envelope text-4xl mb-4 text-gray-300"></i>
                        <p class="text-lg font-medium">No hay buzones aún</p>
                        <p class="text-sm">Crea tu primer buzón para comenzar</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900">Amenazas Recientes</h3>
                    <a href="{{ route('virus-scan.index') }}" class="text-sm text-indigo-600 hover:text-indigo-800">Ver todas</a>
                </div>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @forelse($recentThreats as $threat)
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center">
                                <i class="{{ $threat->threat_type_icon }} text-red-600 text-sm"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900">{{ $threat->threat_name }}</p>
                                <p class="text-xs text-gray-500">{{ $threat->sender_email }} → {{ $threat->recipient_email }}</p>
                                <p class="text-xs text-gray-400">{{ $threat->scanned_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        <div class="flex flex-col items-end">
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $threat->scan_result_badge }}">
                                {{ ucfirst(str_replace('_', ' ', $threat->scan_result)) }}
                            </span>
                            @if($threat->quarantined)
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800 mt-1">
                                    <i class="fas fa-lock w-3 h-3 mr-1"></i>
                                    En Cuarentena
                                </span>
                            @endif
                        </div>
                    </div>
                    @empty
                    <div class="text-center text-gray-500 py-8">
                        <i class="fas fa-shield-alt text-4xl mb-4 text-gray-300"></i>
                        <p class="text-lg font-medium">No se detectaron amenazas</p>
                        <p class="text-sm">Tu sistema de correo está seguro</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="mt-6 bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Acciones Rápidas</h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <a href="{{ route('mailboxes.create') }}" class="flex items-center p-4 rounded-lg border border-gray-200 hover:bg-gray-50 transition-colors">
                    <div class="p-2 bg-indigo-100 rounded-lg">
                        <i class="fas fa-plus text-indigo-600"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-900">Crear Buzón</p>
                        <p class="text-xs text-gray-500">Agregar nueva cuenta de correo</p>
                    </div>
                </a>
                
                <a href="{{ route('forwarders.create') }}" class="flex items-center p-4 rounded-lg border border-gray-200 hover:bg-gray-50 transition-colors">
                    <div class="p-2 bg-green-100 rounded-lg">
                        <i class="fas fa-share text-green-600"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-900">Configurar Reenvío</p>
                        <p class="text-xs text-gray-500">Reenviar correos a otra dirección</p>
                    </div>
                </a>
                
                <a href="{{ route('email-alias.create') }}" class="flex items-center p-4 rounded-lg border border-gray-200 hover:bg-gray-50 transition-colors">
                    <div class="p-2 bg-yellow-100 rounded-lg">
                        <i class="fas fa-at text-yellow-600"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-900">Crear Alias</p>
                        <p class="text-xs text-gray-500">Agregar alias de correo</p>
                    </div>
                </a>

                <a href="{{ route('virus-scan.index') }}" class="flex items-center p-4 rounded-lg border border-gray-200 hover:bg-gray-50 transition-colors">
                    <div class="p-2 bg-red-100 rounded-lg">
                        <i class="fas fa-shield-alt text-red-600"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-900">Análisis de Seguridad</p>
                        <p class="text-xs text-gray-500">Ver resultados de análisis de virus</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Threat Detection Chart (Line Chart)
const threatCtx = document.getElementById('threatChart').getContext('2d');
const threatChart = new Chart(threatCtx, {
    type: 'line',
    data: {
        labels: ['Hace 7 días', 'Hace 6 días', 'Hace 5 días', 'Hace 4 días', 'Hace 3 días', 'Hace 2 días', 'Ayer'],
        datasets: [{
            label: 'Amenazas Detectadas',
            data: [2, 5, 3, 8, 4, 6, 3],
            borderColor: 'rgb(239, 68, 68)',
            backgroundColor: 'rgba(239, 68, 68, 0.1)',
            tension: 0.4,
            fill: true
        }, {
            label: 'Correos Limpios',
            data: [45, 52, 48, 61, 55, 67, 58],
            borderColor: 'rgb(34, 197, 94)',
            backgroundColor: 'rgba(34, 197, 94, 0.1)',
            tension: 0.4,
            fill: true
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom',
            }
        },
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

// Threat Types Chart (Doughnut Chart)
const threatTypesCtx = document.getElementById('threatTypesChart').getContext('2d');
const threatTypesChart = new Chart(threatTypesCtx, {
    type: 'doughnut',
    data: {
        labels: ['Spam', 'Virus', 'Malware', 'Phishing', 'Enlaces Sospechosos'],
        datasets: [{
            data: [45, 12, 8, 15, 20],
            backgroundColor: [
                '#FCD34D',
                '#EF4444',
                '#8B5CF6',
                '#F97316',
                '#06B6D4'
            ],
            borderWidth: 2,
            borderColor: '#ffffff'
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom',
            }
        }
    }
});
</script>
@endpush
@endsection
