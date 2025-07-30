@extends('layouts.app')

@section('title', 'Edit Email Alias - Administración de Correos')

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
                    <a href="{{ route('email-alias.index') }}" class="text-sm font-medium text-gray-500 hover:text-indigo-600">Email Alias</a>
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
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Edit Email Alias</h1>
        <p class="text-gray-600">Update settings for {{ $alias->alias_email }}</p>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">Alias Configuration</h2>
        </div>
        
        <form action="{{ route('email-alias.update', $alias) }}" method="POST" class="p-6">
            @csrf
            @method('PUT')
            
            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Alias Email Address
                    </label>
                    <input 
                        type="text" 
                        value="{{ $alias->alias_email }}"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 bg-gray-50 text-gray-500"
                        readonly
                    >
                    <p class="mt-1 text-sm text-gray-500">Alias email address cannot be changed</p>
                </div>

                <div>
                    <label for="forwards_to" class="block text-sm font-medium text-gray-700 mb-2">
                        Forward To
                    </label>
                    <select 
                        id="forwards_to" 
                        name="forwards_to" 
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('forwards_to') border-red-300 @enderror"
                        required
                    >
                        <option value="">Select a mailbox...</option>
                        @foreach($mailboxes as $mailbox)
                            <option value="{{ $mailbox->email }}" {{ old('forwards_to', $alias->mailbox->email) === $mailbox->email ? 'selected' : '' }}>
                                {{ $mailbox->email }}
                            </option>
                        @endforeach
                    </select>
                    @error('forwards_to')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-sm text-gray-500">Select the mailbox that will receive emails sent to this alias</p>
                </div>

                <div>
                    <label class="flex items-center">
                        <input 
                            type="checkbox" 
                            name="active" 
                            value="1" 
                            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            {{ old('active', $alias->active) ? 'checked' : '' }}
                        >
                        <span class="ml-2 text-sm text-gray-700">Alias is active</span>
                    </label>
                </div>
            </div>

            <div class="flex justify-end space-x-3 mt-8 pt-6 border-t border-gray-200">
                <a href="{{ route('email-alias.index') }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-md transition-colors">
                    Cancel
                </a>
                <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-md transition-colors">
                    Update Alias
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
