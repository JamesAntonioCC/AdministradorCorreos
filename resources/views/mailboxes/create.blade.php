@extends('layouts.app')

@section('title', 'Create Mailbox - Administración de Correos')

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
                    <span class="text-sm font-medium text-gray-900">Create</span>
                </div>
            </li>
        </ol>
    </nav>

    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Create New Mailbox</h1>
        <p class="text-gray-600">Create a new email account for your domain</p>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">Mailbox Configuration</h2>
        </div>
        
        <form action="{{ route('mailboxes.store') }}" method="POST" class="p-6">
            @csrf
            
            <div class="space-y-6">
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                        Email Address
                    </label>
                    <div class="flex">
                        <input 
                            type="text" 
                            id="email" 
                            name="email" 
                            class="flex-1 border border-gray-300 rounded-l-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('email') border-red-300 @enderror" 
                            placeholder="username"
                            value="{{ old('email') }}"
                            required
                        >
                        <span class="bg-gray-50 border border-l-0 border-gray-300 rounded-r-md px-3 py-2 text-gray-500">@devdatep.com</span>
                    </div>
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-sm text-gray-500">Choose a unique username for the email address</p>
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                        Password
                    </label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('password') border-red-300 @enderror"
                        required
                    >
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-sm text-gray-500">Choose a strong password for this mailbox</p>
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                        Confirm Password
                    </label>
                    <input 
                        type="password" 
                        id="password_confirmation" 
                        name="password_confirmation" 
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        required
                    >
                    <p class="mt-1 text-sm text-gray-500">Confirm the password</p>
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
                        <option value="1" {{ old('quota', '1') === '1' ? 'selected' : '' }}>1 GB</option>
                        <option value="2" {{ old('quota') === '2' ? 'selected' : '' }}>2 GB</option>
                        <option value="5" {{ old('quota') === '5' ? 'selected' : '' }}>5 GB</option>
                        <option value="10" {{ old('quota') === '10' ? 'selected' : '' }}>10 GB</option>
                        <option value="unlimited" {{ old('quota') === 'unlimited' ? 'selected' : '' }}>Unlimited</option>
                    </select>
                    @error('quota')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-sm text-gray-500">Set the storage limit for this mailbox</p>
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
                        <span class="ml-2 text-sm text-gray-700">Activate mailbox immediately</span>
                    </label>
                </div>
            </div>

            <div class="flex justify-end space-x-3 mt-8 pt-6 border-t border-gray-200">
                <a href="{{ route('mailboxes.index') }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-md transition-colors">
                    Cancel
                </a>
                <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-md transition-colors">
                    Create Mailbox
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
