@extends('layouts.app')

@section('title', 'Edit Mailbox - Administración de Correos')

@section('content')
<div class="max-w-2xl mx-auto">
    <!-- Breadcrumb -->
    <nav class="flex mb-6" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('dashboard') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-indigo-600">
                    <i class="fas fa-home w-4 h-4 mr-2"></i>
                    Home
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <i class="fas fa-chevron-right w-4 h-4 text-gray-400 mx-2"></i>
                    <a href="{{ route('mailboxes.index') }}" class="text-sm font-medium text-gray-500 hover:text-indigo-600">Mailboxes</a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <i class="fas fa-chevron-right w-4 h-4 text-gray-400 mx-2"></i>
                    <span class="text-sm font-medium text-gray-900">Edit</span>
                </div>
            </li>
        </ol>
    </nav>

    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Edit Mailbox</h1>
        <p class="text-gray-600">Update settings for {{ $mailbox->email }}</p>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">Mailbox Settings</h2>
        </div>
        
        <form action="{{ route('mailboxes.update', $mailbox) }}" method="POST" class="p-6">
            @csrf
            @method('PUT')
            
            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Email Address
                    </label>
                    <input 
                        type="text" 
                        value="{{ $mailbox->email }}"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 bg-gray-50 text-gray-500"
                        readonly
                    >
                    <p class="mt-1 text-sm text-gray-500">Email address cannot be changed</p>
                </div>

                <div>
                    <label for="quota" class="block text-sm font-medium text-gray-700 mb-2">
                        Storage Quota
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
                        <option value="unlimited" {{ old('quota', !$mailbox->quota ? 'unlimited' : '') === 'unlimited' ? 'selected' : '' }}>Unlimited</option>
                    </select>
                    @error('quota')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-sm text-gray-500">Current usage: {{ $mailbox->formatted_storage_used }}</p>
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
                        <span class="ml-2 text-sm text-gray-700">Mailbox is active</span>
                    </label>
                    <p class="mt-1 text-sm text-gray-500">Inactive mailboxes cannot send or receive emails</p>
                </div>
            </div>

            <div class="flex justify-end space-x-3 mt-8 pt-6 border-t border-gray-200">
                <a href="{{ route('mailboxes.index') }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-md transition-colors">
                    Cancel
                </a>
                <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-md transition-colors">
                    Update Mailbox
                </button>
            </div>
        </form>
    </div>

    <!-- Additional Actions -->
    <div class="mt-6 bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Additional Actions</h3>
        </div>
        <div class="p-6 space-y-4">
            <div class="flex items-center justify-between">
                <div>
                    <h4 class="text-sm font-medium text-gray-900">Change Password</h4>
                    <p class="text-sm text-gray-500">Update the mailbox password</p>
                </div>
                <a href="{{ route('mailboxes.change-password', $mailbox) }}" class="px-4 py-2 text-sm font-medium text-indigo-600 bg-indigo-50 hover:bg-indigo-100 rounded-md">
                    Change Password
                </a>
            </div>
            
            <div class="border-t border-gray-200 pt-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h4 class="text-sm font-medium text-red-900">Delete Mailbox</h4>
                        <p class="text-sm text-red-600">Permanently delete this mailbox and all its data</p>
                    </div>
                    <form action="{{ route('mailboxes.destroy', $mailbox) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete {{ $mailbox->email }}?');" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 text-sm font-medium text-red-600 bg-red-50 hover:bg-red-100 rounded-md">
                            Delete Mailbox
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
                <h3 class="text-lg font-medium text-gray-900">Change Password</h3>
                <button class="text-gray-400 hover:text-gray-600" onclick="closeChangePasswordModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form id="changePasswordForm" action="{{ route('mailboxes.change-password', $mailbox) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                    <input type="text" value="{{ $mailbox->email }}" class="w-full border border-gray-300 rounded-md px-3 py-2 bg-gray-50" readonly>
                </div>
                <div class="mb-4">
                    <label for="new_password" class="block text-sm font-medium text-gray-700 mb-2">New Password</label>
                    <input type="password" id="new_password" name="password" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                </div>
                <div class="mb-6">
                    <label for="confirm_password" class="block text-sm font-medium text-gray-700 mb-2">Confirm Password</label>
                    <input type="password" id="confirm_password" name="password_confirmation" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeChangePasswordModal()" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-md">
                        Cancel
                    </button>
                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-md">
                        Change Password
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
            <h3 class="text-lg font-medium text-gray-900 mb-2">Delete Mailbox</h3>
            <p class="text-sm text-gray-500 mb-4">Are you sure you want to delete <span class="font-medium">{{ $mailbox->email }}</span>? This action cannot be undone.</p>
            <form action="{{ route('mailboxes.destroy', $mailbox) }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="flex justify-center space-x-3">
                    <button type="button" onclick="closeDeleteModal()" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-md">
                        Cancel
                    </button>
                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-red-600 hover:bg-red-700 rounded-md">
                        Delete
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
