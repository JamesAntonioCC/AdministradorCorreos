@extends('layouts.app')

@section('title', 'Buzones de Correo - Administración de Correos')

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
                    <span class="text-sm font-medium text-gray-500">Correos</span>
                </div>
            </li>
            <li>
                <div class="flex items-center">
                    <i class="fas fa-chevron-right w-4 h-4 text-gray-400 mx-2"></i>
                    <span class="text-sm font-medium text-gray-500">devdatep.com</span>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <i class="fas fa-chevron-right w-4 h-4 text-gray-400 mx-2"></i>
                    <span class="text-sm font-medium text-gray-900">Buzones de Correo</span>
                </div>
            </li>
        </ol>
    </nav>

    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Buzones de Correo</h1>
    </div>

    <!-- Mailboxes Section -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <!-- Section Header -->
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-gray-900">Tus buzones de correo</h2>
                    <p class="text-sm text-gray-500">{{ $remainingMailboxes ?? 96 }} restantes</p>
                </div>
                <button class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg flex items-center space-x-2 transition-colors" onclick="openCreateModal()">
                    <i class="fas fa-plus w-4 h-4"></i>
                    <span>Crear buzón</span>
                </button>
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Buzón de Correo
                            <i class="fas fa-sort ml-1"></i>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Estado
                            <i class="fas fa-sort ml-1"></i>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Uso
                        </th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Acciones
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($mailboxes as $mailbox)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <span class="text-sm font-medium text-gray-900">{{ $mailbox->email }}</span>
                                <button class="ml-2 text-gray-400 hover:text-gray-600" onclick="copyToClipboard('{{ $mailbox->email }}')">
                                    <i class="fas fa-copy w-4 h-4"></i>
                                </button>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-2 h-2 {{ $mailbox->active ? 'bg-green-400' : 'bg-red-400' }} rounded-full mr-2"></div>
                                <span class="text-sm text-gray-900">{{ $mailbox->active ? 'Activo' : 'Inactivo' }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">
                                @if($mailbox->usage_percentage > 0)
                                    <div class="mb-1">{{ $mailbox->usage_percentage }}% usado</div>
                                @else
                                    <div class="mb-1">0% usado</div>
                                @endif
                                <div class="text-xs text-gray-500">{{ $mailbox->formatted_storage_used }} / {{ $mailbox->formatted_quota }}</div>
                                @if($mailbox->usage_percentage > 0)
                                    <div class="w-full bg-gray-200 rounded-full h-1 mt-1">
                                        <div class="bg-blue-600 h-1 rounded-full w-[{{ min($mailbox->usage_percentage, 100) }}%]"></div>
                                    </div>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex items-center justify-end space-x-2">
                                <!-- Webmail Button -->
                                <a href="#" class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-indigo-600 bg-indigo-50 hover:bg-indigo-100 rounded-md transition-colors">
                                    <i class="fas fa-envelope w-3 h-3 mr-1"></i>
                                    Webmail
                                </a>
                                
                                <!-- Action Buttons -->
                                <div class="flex items-center space-x-1">
                                    <!-- Edit Button -->
                                    <a href="{{ route('mailboxes.edit', $mailbox) }}" 
                                       class="inline-flex items-center justify-center w-8 h-8 text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-md transition-colors"
                                       title="Editar buzón">
                                        <i class="fas fa-edit w-4 h-4"></i>
                                    </a>
                                    
                                    <!-- Change Password Button -->
                                    <a href="{{ route('mailboxes.change-password', $mailbox) }}"
                                    class="inline-flex items-center justify-center w-8 h-8 text-gray-400 hover:text-green-600 hover:bg-green-50 rounded-md transition-colors"
                                    title="Cambiar Contraseña">
                                        <i class="fas fa-key w-4 h-4"></i>
                                    </a>
                                    
                                    <!-- Settings/View Button -->
                                    <a href="{{ route('mailboxes.show', $mailbox) }}" 
                                       class="inline-flex items-center justify-center w-8 h-8 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-md transition-colors"
                                       title="Ver detalles">
                                        <i class="fas fa-cog w-4 h-4"></i>
                                    </a>
                                    
                                    <!-- Delete Button -->
                                    <form action="{{ route('mailboxes.destroy', $mailbox) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete {{ $mailbox->email }}?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="inline-flex items-center justify-center w-8 h-8 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-md transition-colors"
                                            title="Eliminar buzón">
                                            <i class="fas fa-trash w-4 h-4"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center">
                            <div class="text-gray-500">
                                <i class="fas fa-envelope text-4xl mb-4"></i>
                                <p class="text-lg font-medium">No se encontraron buzones</p>
                                <p class="text-sm">Crea tu primer buzón para comenzar</p>
                                <a href="{{ route('mailboxes.create') }}" class="mt-4 inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                                    <i class="fas fa-plus mr-2"></i>
                                    Crear Buzón
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
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
            <form id="changePasswordForm" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Correo Electrónico</label>
                    <input type="text" id="changePasswordEmail" class="w-full border border-gray-300 rounded-md px-3 py-2 bg-gray-50" readonly>
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
            <p class="text-sm text-gray-500 mb-4">¿Estás seguro de que deseas eliminar <span id="deleteEmailName" class="font-medium"></span>? Esta acción no se puede deshacer.</p>
            <form id="deleteForm" method="POST">
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

<!-- Create Mailbox Modal -->
<div id="createMailboxModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900">Crear Nuevo Buzón</h3>
                <button class="text-gray-400 hover:text-gray-600" onclick="closeCreateModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form action="{{ route('mailboxes.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Dirección de Correo</label>
                    <div class="flex">
                        <input type="text" id="email" name="email" class="flex-1 border border-gray-300 rounded-l-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="usuario" required>
                        <span class="bg-gray-50 border border-l-0 border-gray-300 rounded-r-md px-3 py-2 text-gray-500">@devdatep.com</span>
                    </div>
                </div>
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Contraseña</label>
                    <input type="password" id="password" name="password" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                </div>
                <div class="mb-4">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Confirmar Contraseña</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                </div>
                <div class="mb-6">
                    <label for="quota" class="block text-sm font-medium text-gray-700 mb-2">Cuota de Almacenamiento (GB)</label>
                    <select id="quota" name="quota" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="1">1 GB</option>
                        <option value="2">2 GB</option>
                        <option value="5">5 GB</option>
                        <option value="10">10 GB</option>
                    </select>
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeCreateModal()" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-md">
                        Cancelar
                    </button>
                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-md">
                        Crear Buzón
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
function openCreateModal() {
    document.getElementById('createMailboxModal').classList.remove('hidden');
}

function closeCreateModal() {
    document.getElementById('createMailboxModal').classList.add('hidden');
}

function openChangePasswordModal(mailboxId, email) {
    document.getElementById('changePasswordEmail').value = email;
    document.getElementById('changePasswordForm').action = '/mailboxes/' + mailboxId + '/change-password';
    document.getElementById('changePasswordModal').classList.remove('hidden');
}

function closeChangePasswordModal() {
    document.getElementById('changePasswordModal').classList.add('hidden');
    document.getElementById('changePasswordForm').reset();
}

function confirmDelete(mailboxId, email) {
    document.getElementById('deleteEmailName').textContent = email;
    document.getElementById('deleteForm').action = '/mailboxes/' + mailboxId;
    document.getElementById('deleteModal').classList.remove('hidden');
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
}

function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        // Show a temporary success message
        const button = event.target.closest('button');
        const icon = button.querySelector('i');
        icon.className = 'fas fa-check w-4 h-4 text-green-500';
        setTimeout(() => {
            icon.className = 'fas fa-copy w-4 h-4';
        }, 2000);
    });
}
</script>
@endpush
@endsection
