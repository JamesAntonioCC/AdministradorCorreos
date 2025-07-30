@extends('layouts.app')

@section('title', 'Editar Buzón - Administración de Correos')

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
                    <a href="{{ route('mailboxes.index') }}" class="text-sm font-medium text-gray-500 hover:text-indigo-600">Buzones</a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <i class="fas fa-chevron-right w-4 h-4 text-gray-400 mx-2"></i>
                    <span class="text-sm font-medium text-gray-900">Editar</span>
                </div>
            </li>
        </ol>
    </nav>

    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Editar Buzón</h1>
        <p class="text-gray-600">Actualizar configuración para {{ $mailbox->email }}</p>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">Configuración del Buzón</h2>
        </div>
        
        <form action="{{ route('mailboxes.update', $mailbox) }}" method="POST" class="p-6">
            @csrf
            @method('PUT')
            
            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Dirección de Correo Electrónico
                    </label>
                    <input 
                        type="text" 
                        value="{{ $mailbox->email }}"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 bg-gray-50 text-gray-500"
                        readonly
                    >
                    <p class="mt-1 text-sm text-gray-500">La dirección de correo no se puede cambiar</p>
                </div>

                <div>
                    <label for="quota" class="block text-sm font-medium text-gray-700 mb-2">
                        Cuota de Almacenamiento
                    </label>
                    <select 
                        id="quota" 
                        name="quota" 
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('quota') border-red-300 @enderror"
                    >
                        <option value="1" {{ old('quota', $mailbox->quota == 1024 ? '1' : '') === '1' ? 'selected' : '' }}>1 GB</option>
                        <option value="2" {{ old('quota', $mailbox->quota == 2048 ? '2' : '') === '2' ? 'selected' : '' }}>2 GB</option>
                        <option value="5" {{ old('quota', $mailbox->quota == 5120 ? '5' : '') === '5' ? 'selected' : '' }}>5 GB</option>
                        <option value="10" {{ old('quota', $mailbox->quota == 10240 ? '10' : '') === '10' ? 'selected' : '' }}>10 GB</option>
                        <option value="unlimited" {{ old('quota', !$mailbox->quota ? 'unlimited' : '') === 'unlimited' ? 'selected' : '' }}>Ilimitado</option>
                    </select>
                    @error('quota')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-sm text-gray-500">Uso actual: {{ $mailbox->formatted_storage_used }}</p>
                </div>

                <div>
                    <label class="flex items-center">
                        <input 
                            type="checkbox" 
                            name="active" 
                            value="1" 
                            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            {{ old('active', $mailbox->active) ? 'checked' : '' }}
                        >
                        <span class="ml-2 text-sm text-gray-700">El buzón está activo</span>
                    </label>
                    <p class="mt-1 text-sm text-gray-500">Los buzones inactivos no pueden enviar ni recibir correos</p>
                </div>
            </div>

            <div class="flex justify-end space-x-3 mt-8 pt-6 border-t border-gray-200">
                <a href="{{ route('mailboxes.index') }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-md transition-colors">
                    Cancelar
                </a>
                <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-md transition-colors">
                    Actualizar Buzón
                </button>
            </div>
        </form>
    </div>

    <!-- Additional Actions -->
    <div class="mt-6 bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Acciones Adicionales</h3>
        </div>
        <div class="p-6 space-y-4">
            <div class="flex items-center justify-between">
                <div>
                    <h4 class="text-sm font-medium text-gray-900">Cambiar Contraseña</h4>
                    <p class="text-sm text-gray-500">Actualizar la contraseña del buzón</p>
                </div>
                <a href="{{ route('mailboxes.change-password', $mailbox) }}"
                class="px-4 py-2 text-sm font-medium text-indigo-600 bg-indigo-50 hover:bg-indigo-100 rounded-md">
                    Cambiar Contraseña
                </a>
            </div>
            
            <div class="border-t border-gray-200 pt-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h4 class="text-sm font-medium text-red-900">Eliminar Buzón</h4>
                        <p class="text-sm text-red-600">Eliminar permanentemente este buzón y todos sus datos</p>
                    </div>
                    <form action="{{ route('mailboxes.destroy', $mailbox) }}" method="POST" style="display:inline;" onsubmit="return confirm('¿Estás seguro de que deseas eliminar {{ $mailbox->email }}? Esta acción no se puede deshacer.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 text-sm font-medium text-red-600 bg-red-50 hover:bg-red-100 rounded-md">
                            Eliminar Buzón
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Change Password Modal -->
<div id="changePasswordModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900">Cambiar Contraseña</h3>
                <button class="text-gray-400 hover:text-gray-600" onclick="closeChangePasswordModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form id="changePasswordForm" action="{{ route('mailboxes.change-password', $mailbox) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Correo</label>
                    <input type="text" value="{{ $mailbox->email }}" class="w-full border border-gray-300 rounded-md px-3 py-2 bg-gray-50" readonly>
                </div>
                <div class="mb-4">
                    <label for="new_password" class="block text-sm font-medium text-gray-700 mb-2">Nueva Contraseña</label>
                    <input type="password" id="new_password" name="password" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                </div>
                <div class="mb-6">
                    <label for="confirm_password" class="block text-sm font-medium text-gray-700 mb-2">Confirmar Contraseña</label>
                    <input type="password" id="confirm_password" name="password_confirmation" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeChangePasswordModal()" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-md">
                        Cancelar
                    </button>
                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-md">
                        Cambiar Contraseña
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-4">
                <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mb-2">Eliminar Buzón</h3>
            <p class="text-sm text-gray-500 mb-4">¿Estás seguro de que deseas eliminar <span class="font-medium">{{ $mailbox->email }}</span>? Esta acción no se puede deshacer.</p>
            <form action="{{ route('mailboxes.destroy', $mailbox) }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="flex justify-center space-x-3">
                    <button type="button" onclick="closeDeleteModal()" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-md">
                        Cancelar
                    </button>
                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-red-600 hover:bg-red-700 rounded-md">
                        Eliminar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
function openChangePasswordModal(mailboxId, email) {
    document.getElementById('changePasswordModal').classList.remove('hidden');
}

function closeChangePasswordModal() {
    document.getElementById('changePasswordModal').classList.add('hidden');
}

function confirmDelete(mailboxId, email) {
    document.getElementById('deleteModal').classList.remove('hidden');
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
}
</script>
@endpush
@endsection
