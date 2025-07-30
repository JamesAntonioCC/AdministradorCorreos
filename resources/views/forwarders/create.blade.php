@extends('layouts.app')

@section('title', 'Crear Reenvío - Administración de Correos')

@section('content')
<div class="max-w-2xl mx-auto">
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
                    <a href="{{ route('forwarders.index') }}" class="text-sm font-medium text-gray-500 hover:text-indigo-600">Reenvíos</a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <i class="fas fa-chevron-right w-4 h-4 text-gray-400 mx-2"></i>
                    <span class="text-sm font-medium text-gray-900">Crear</span>
                </div>
            </li>
        </ol>
    </nav>

    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Crear Reenvío de Correo</h1>
        <p class="text-gray-600">Reenvía correos de una dirección a otra</p>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">Configuración del Reenvío</h2>
        </div>
        
        <form action="{{ route('forwarders.store') }}" method="POST" class="p-6">
            @csrf
            
            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Dirección de Correo Origen
                    </label>
                    
                    <!-- Radio buttons for source type -->
                    <div class="mb-4 space-y-2">
                        <label class="flex items-center">
                            <input type="radio" name="source_type" value="existing" class="text-indigo-600" checked onchange="toggleSourceType()">
                            <span class="ml-2 text-sm text-gray-700">Usar buzón existente</span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio" name="source_type" value="new" class="text-indigo-600" onchange="toggleSourceType()">
                            <span class="ml-2 text-sm text-gray-700">Crear nueva dirección de correo</span>
                        </label>
                    </div>

                    <!-- Existing mailbox selector -->
                    <div id="existingMailboxSelect" class="mb-4">
                        <select 
                            id="existing_mailbox" 
                            name="existing_mailbox" 
                            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        >
                            <option value="">Selecciona un buzón existente...</option>
                            @foreach($mailboxes as $mailbox)
                                <option value="{{ $mailbox->email }}" {{ old('existing_mailbox') === $mailbox->email ? 'selected' : '' }}>
                                    {{ $mailbox->email }}
                                </option>
                            @endforeach
                        </select>
                        <p class="mt-1 text-sm text-gray-500">Selecciona un buzón desde el cual reenviar</p>
                    </div>

                    <!-- New email input -->
                    <div id="newEmailInput" class="mb-4 hidden">
                        <div class="flex">
                            <input 
                                type="text" 
                                id="source" 
                                name="source" 
                                class="flex-1 border border-gray-300 rounded-l-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('source') border-red-300 @enderror" 
                                placeholder="info"
                                value="{{ old('source') }}"
                            >
                            <span class="bg-gray-50 border border-l-0 border-gray-300 rounded-r-md px-3 py-2 text-gray-500">@equipo1.com</span>
                        </div>
                        <p class="mt-1 text-sm text-gray-500">Crea una nueva dirección de correo para reenvío</p>
                    </div>

                    @error('source')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    @error('existing_mailbox')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="destination" class="block text-sm font-medium text-gray-700 mb-2">
                        Dirección de Correo Destino
                    </label>
                    <input 
                        type="email" 
                        id="destination" 
                        name="destination" 
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('destination') border-red-300 @enderror" 
                        placeholder="admin@equipo1.com"
                        value="{{ old('destination') }}"
                        required
                    >
                    @error('destination')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-sm text-gray-500">Los correos serán reenviados a esta dirección</p>
                </div>

                <div>
                    <label class="flex items-center">
                        <input 
                            type="checkbox" 
                            name="active" 
                            value="1" 
                            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            {{ old('active', true) ? 'checked' : '' }}
                        >
                        <span class="ml-2 text-sm text-gray-700">Activar reenvío inmediatamente</span>
                    </label>
                </div>
            </div>

            <div class="flex justify-end space-x-3 mt-8 pt-6 border-t border-gray-200">
                <a href="{{ route('forwarders.index') }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-md transition-colors">
                    Cancelar
                </a>
                <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-md transition-colors">
                    Crear Reenvío
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function toggleSourceType() {
    const existingRadio = document.querySelector('input[name="source_type"][value="existing"]');
    const newRadio = document.querySelector('input[name="source_type"][value="new"]');
    const existingSelect = document.getElementById('existingMailboxSelect');
    const newInput = document.getElementById('newEmailInput');
    
    if (existingRadio.checked) {
        existingSelect.classList.remove('hidden');
        newInput.classList.add('hidden');
        document.getElementById('existing_mailbox').required = true;
        document.getElementById('source').required = false;
    } else {
        existingSelect.classList.add('hidden');
        newInput.classList.remove('hidden');
        document.getElementById('existing_mailbox').required = false;
        document.getElementById('source').required = true;
    }
}
</script>
@endpush
@endsection
