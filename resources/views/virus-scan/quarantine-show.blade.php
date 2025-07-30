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

    <!-- Email Information -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
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
                    <label class="block text-sm font-medium text-gray-700 mb-2">Fecha de Cuarentena</label>
                    <p class="text-sm text-gray-900 bg-gray-50 p-3 rounded-md">{{ $virusScan->scanned_at->format('d/m/Y H:i:s') }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Motor de Análisis</label>
                    <p class="text-sm text-gray-900 bg-gray-50 p-3 rounded-md">{{ $virusScan->scan_engine ?? 'ClamAV' }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Threat Detection Details -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900 flex items-center">
                <i class="fas fa-exclamation-triangle text-red-600 mr-2"></i>
                Amenaza Detectada
            </h2>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tipo de Amenaza</label>
                    <div class="flex items-center bg-red-50 p-3 rounded-md">
                        <i class="{{ $virusScan->threat_type_icon }} text-red-600 mr-2"></i>
                        <span class="text-sm font-medium text-red-800">{{ $virusScan->threat_type_text }}</span>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nombre de la Amenaza</label>
                    <span class="inline-flex items-center px-3 py-2 rounded-full text-sm font-medium bg-red-100 text-red-800">
                        <i class="fas fa-bug mr-1"></i>
                        {{ $virusScan->threat_name ?? $virusScan->threat_display_name }}
                    </span>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Resultado del Análisis</label>
                    <span class="inline-flex items-center px-3 py-2 rounded-full text-sm font-medium {{ $virusScan->scan_result_badge }}">
                        {{ $virusScan->result_text }}
                    </span>
                </div>
                @if($virusScan->file_hash)
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Hash del Archivo</label>
                    <p class="text-xs text-gray-600 bg-gray-50 p-3 rounded-md font-mono break-all">{{ $virusScan->file_hash }}</p>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- File Attachment Information -->
    @if($virusScan->attachment_name || $virusScan->file_name)
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900 flex items-center">
                <i class="fas fa-paperclip text-gray-600 mr-2"></i>
                Archivo Adjunto
            </h2>
        </div>
        <div class="p-6">
            <div class="bg-red-50 border border-red-200 rounded-md p-4 mb-4">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-triangle text-red-600 mr-2"></i>
                    <span class="text-sm font-medium text-red-800">Archivo Potencialmente Peligroso</span>
                </div>
                <p class="text-xs text-red-600 mt-1">Este archivo ha sido identificado como una amenaza. No lo descargues a menos que sepas lo que estás haciendo.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nombre del Archivo</label>
                    <div class="flex items-center bg-gray-50 p-3 rounded-md">
                        @php
                            $fileName = $virusScan->attachment_name ?? $virusScan->file_name;
                            $extension = pathinfo($fileName, PATHINFO_EXTENSION);
                            $iconClass = match(strtolower($extension)) {
                                'pdf' => 'fas fa-file-pdf text-red-600',
                                'doc', 'docx' => 'fas fa-file-word text-blue-600',
                                'xls', 'xlsx' => 'fas fa-file-excel text-green-600',
                                'txt' => 'fas fa-file-alt text-gray-600',
                                'exe' => 'fas fa-cog text-red-600',
                                'zip', 'rar' => 'fas fa-file-archive text-yellow-600',
                                'jpg', 'jpeg', 'png', 'gif' => 'fas fa-file-image text-purple-600',
                                default => 'fas fa-file text-gray-600'
                            };
                        @endphp
                        <i class="{{ $iconClass }} mr-2"></i>
                        <span class="text-sm text-gray-900">{{ $fileName }}</span>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tipo de Archivo</label>
                    <div class="bg-gray-50 p-3 rounded-md">
                        <span class="text-sm text-gray-900">
                            @if($extension)
                                .{{ strtoupper($extension) }} 
                                @switch(strtolower($extension))
                                    @case('exe')
                                        (Ejecutable)
                                        @break
                                    @case('pdf')
                                        (Documento PDF)
                                        @break
                                    @case('txt')
                                        (Archivo de Texto)
                                        @break
                                    @case('zip')
                                    @case('rar')
                                        (Archivo Comprimido)
                                        @break
                                    @default
                                        ({{ ucfirst(strtolower($extension)) }})
                                @endswitch
                            @else
                                Desconocido
                            @endif
                        </span>
                    </div>
                </div>
            </div>

            <!-- File Content Preview -->
            @if($virusScan->attachment_content)
            <div class="mt-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Vista Previa del Contenido</label>
                <div class="bg-gray-100 border rounded-md p-4">
                    <pre class="text-xs text-gray-700 whitespace-pre-wrap max-h-40 overflow-y-auto">{{ Str::limit($virusScan->attachment_content, 500) }}</pre>
                    @if(strlen($virusScan->attachment_content) > 500)
                        <p class="text-xs text-gray-500 mt-2">... (contenido truncado)</p>
                    @endif
                </div>
            </div>
            @endif

            <!-- Download Button -->
            <div class="mt-4 flex justify-end">
                <a href="{{ route('virus-scan.download-attachment', $virusScan) }}" 
                   class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm transition-colors"
                   onclick="return confirm('⚠️ ADVERTENCIA: Este archivo contiene amenazas detectadas.\n\n¿Estás seguro de que quieres descargarlo?\n\nSolo hazlo si eres un experto en seguridad y sabes cómo manejar archivos maliciosos de forma segura.')">
                    <i class="fas fa-download mr-2"></i>
                    Descargar Archivo (Peligroso)
                </a>
            </div>
        </div>
    </div>
    @endif

    <!-- Email Content -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">Contenido del Mensaje</h2>
        </div>
        <div class="p-6">
            <div class="bg-gray-50 p-4 rounded-md">
                <pre class="text-sm text-gray-900 whitespace-pre-wrap">{{ $virusScan->message_content ?? 'Sin contenido disponible' }}</pre>
            </div>
        </div>
    </div>

    <!-- Technical Details -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">Detalles Técnicos</h2>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">ID del Email</label>
                    <p class="text-sm text-gray-900 bg-gray-50 p-3 rounded-md">{{ $virusScan->email_id ?? 'N/A' }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">ID del Análisis</label>
                    <p class="text-sm text-gray-900 bg-gray-50 p-3 rounded-md">{{ $virusScan->id }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Estado de Cuarentena</label>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                        <i class="fas fa-lock mr-1"></i>
                        En Cuarentena
                    </span>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Fecha de Creación</label>
                    <p class="text-sm text-gray-900 bg-gray-50 p-3 rounded-md">{{ $virusScan->created_at->format('d/m/Y H:i:s') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Actions -->
    <div class="flex justify-end space-x-3">
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
