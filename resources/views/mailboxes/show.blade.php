@extends('layouts.app')

@section('title', 'Mailbox Details - Administración de Correos')

@section('content')
<div class="max-w-4xl mx-auto">
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
                    <span class="text-sm font-medium text-gray-900">{{ $mailbox->email }}</span>
                </div>
            </li>
        </ol>
    </nav>

    <!-- Page Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $mailbox->email }}</h1>
                <p class="text-gray-600">Mailbox details and configuration</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('mailboxes.edit', $mailbox) }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg flex items-center space-x-2 transition-colors">
                    <i class="fas fa-edit w-4 h-4"></i>
                    <span>Edit</span>
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Info -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Basic Information -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">Basic Information</h2>
                </div>
                <div class="p-6">
                    <dl class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Email Address</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $mailbox->email }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Status</dt>
                            <dd class="mt-1">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $mailbox->active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $mailbox->active ? 'Active' : 'Inactive' }}
                                </span>
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Storage Quota</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $mailbox->formatted_quota }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Storage Used</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $mailbox->formatted_storage_used }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Created</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $mailbox->created_at->format('M d, Y H:i') }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Last Login</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ $mailbox->last_login ? $mailbox->last_login->format('M d, Y H:i') : 'Never' }}
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>

            <!-- Storage Usage -->
            @if($mailbox->quota)
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">Storage Usage</h2>
                </div>
                <div class="p-6">
                    <div class="mb-4">
                        <div class="flex justify-between text-sm text-gray-600 mb-2">
                            <span>{{ $mailbox->formatted_storage_used }} used</span>
                            <span>{{ $mailbox->usage_percentage }}%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-blue-600 h-2 rounded-full transition-all duration-300 w-[{{ min($mailbox->usage_percentage, 100) }}%]"></div>
                        </div>
                        <div class="flex justify-between text-xs text-gray-500 mt-1">
                            <span>0</span>
                            <span>{{ $mailbox->formatted_quota }}</span>
                        </div>
                    </div>
                    @if($mailbox->usage_percentage > 80)
                        <div class="bg-yellow-50 border border-yellow-200 rounded-md p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-exclamation-triangle text-yellow-400"></i>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-yellow-800">Storage Warning</h3>
                                    <div class="mt-2 text-sm text-yellow-700">
                                        <p>This mailbox is using {{ $mailbox->usage_percentage }}% of its storage quota. Consider increasing the quota or cleaning up old emails.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            @endif

            <!-- Related Items -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">Related Items</h2>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="text-center p-4 border border-gray-200 rounded-lg">
                            <div class="text-2xl font-bold text-indigo-600">{{ $mailbox->aliases->count() }}</div>
                            <div class="text-sm text-gray-500">Email Aliases</div>
                        </div>
                        <div class="text-center p-4 border border-gray-200 rounded-lg">
                            <div class="text-2xl font-bold text-green-600">{{ $mailbox->autoReplies->count() }}</div>
                            <div class="text-sm text-gray-500">Auto Replies</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Quick Actions -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Quick Actions</h3>
                </div>
                <div class="p-6 space-y-3">
                    <a href="{{ route('mailboxes.edit', $mailbox) }}" class="flex items-center p-3 rounded-lg border border-gray-200 hover:bg-gray-50 transition-colors">
                        <div class="p-2 bg-indigo-100 rounded-lg">
                            <i class="fas fa-edit text-indigo-600"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-900">Edit Mailbox</p>
                            <p class="text-xs text-gray-500">Update settings</p>
                        </div>
                    </a>
                    
                    <button type="button" class="flex items-center p-3 rounded-lg border border-gray-200 hover:bg-gray-50 transition-colors w-full" onclick="openChangePasswordModal()">
                        <div class="p-2 bg-green-100 rounded-lg">
                            <i class="fas fa-key text-green-600"></i>
                        </div>
                        <div class="ml-3 text-left">
                            <p class="text-sm font-medium text-gray-900">Change Password</p>
                            <p class="text-xs text-gray-500">Update login password</p>
                        </div>
                    </button>
                    
                    <a href="{{ route('email-alias.create') }}?mailbox={{ $mailbox->id }}" class="flex items-center p-3 rounded-lg border border-gray-200 hover:bg-gray-50 transition-colors">
                        <div class="p-2 bg-yellow-100 rounded-lg">
                            <i class="fas fa-at text-yellow-600"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-900">Create Alias</p>
                            <p class="text-xs text-gray-500">Add email alias</p>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Email Aliases -->
            @if($mailbox->aliases->count() > 0)
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Email Aliases</h3>
                </div>
                <div class="p-6">
                    <div class="space-y-2">
                        @foreach($mailbox->aliases as $alias)
                        <div class="flex items-center justify-between p-2 bg-gray-50 rounded">
                            <span class="text-sm text-gray-900">{{ $alias->alias_email }}</span>
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $alias->active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $alias->active ? 'Active' : 'Inactive' }}
                            </span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
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
            <form action="{{ route('mailboxes.change-password', $mailbox) }}" method="POST">
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

@push('scripts')
<script>
function openChangePasswordModal() {
    document.getElementById('changePasswordModal').classList.remove('hidden');
}

function closeChangePasswordModal() {
    document.getElementById('changePasswordModal').classList.add('hidden');
}
</script>
@endpush
@endsection
