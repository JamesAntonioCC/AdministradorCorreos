@extends('layouts.app')

@section('title', 'Email Import - Administración de Correos')

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
            <li aria-current="page">
                <div class="flex items-center">
                    <i class="fas fa-chevron-right w-4 h-4 text-gray-400 mx-2"></i>
                    <span class="text-sm font-medium text-gray-900">Email Import</span>
                </div>
            </li>
        </ol>
    </nav>

    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Email Import</h1>
        <p class="text-gray-600">Import contacts and emails from external sources</p>
    </div>

    <!-- Import Form -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">Import Data</h2>
            <p class="text-sm text-gray-500">Upload a CSV file to import contacts or emails</p>
        </div>
        
        <form action="{{ route('email-import.import') }}" method="POST" enctype="multipart/form-data" class="p-6">
            @csrf
            
            <div class="space-y-6">
                <div>
                    <label for="import_type" class="block text-sm font-medium text-gray-700 mb-2">
                        Import Type
                    </label>
                    <select 
                        id="import_type" 
                        name="import_type" 
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('import_type') border-red-300 @enderror"
                        required
                    >
                        <option value="">Select import type...</option>
                        <option value="contacts" {{ old('import_type') === 'contacts' ? 'selected' : '' }}>Contacts</option>
                        <option value="emails" {{ old('import_type') === 'emails' ? 'selected' : '' }}>Emails</option>
                    </select>
                    @error('import_type')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-sm text-gray-500">Choose what type of data you want to import</p>
                </div>

                <div>
                    <label for="mailbox_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Target Mailbox
                    </label>
                    <select 
                        id="mailbox_id" 
                        name="mailbox_id" 
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('mailbox_id') border-red-300 @enderror"
                        required
                    >
                        <option value="">Select mailbox...</option>
                        @php
                            $mailboxes = \App\Models\Mailbox::where('active', true)->get();
                        @endphp
                        @foreach($mailboxes as $mailbox)
                            <option value="{{ $mailbox->id }}" {{ old('mailbox_id') == $mailbox->id ? 'selected' : '' }}>
                                {{ $mailbox->email }}
                            </option>
                        @endforeach
                    </select>
                    @error('mailbox_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-sm text-gray-500">Select the mailbox to import data into</p>
                </div>

                <div>
                    <label for="import_file" class="block text-sm font-medium text-gray-700 mb-2">
                        Import File
                    </label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                        <div class="space-y-1 text-center">
                            <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-4"></i>
                            <div class="flex text-sm text-gray-600">
                                <label for="import_file" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                    <span>Upload a file</span>
                                    <input 
                                        id="import_file" 
                                        name="import_file" 
                                        type="file" 
                                        accept=".csv,.txt"
                                        class="sr-only"
                                        required
                                    >
                                </label>
                                <p class="pl-1">or drag and drop</p>
                            </div>
                            <p class="text-xs text-gray-500">CSV or TXT up to 10MB</p>
                        </div>
                    </div>
                    @error('import_file')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex justify-end space-x-3 mt-8 pt-6 border-t border-gray-200">
                <a href="{{ route('dashboard') }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-md transition-colors">
                    Cancel
                </a>
                <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-md transition-colors">
                    <i class="fas fa-upload mr-2"></i>
                    Start Import
                </button>
            </div>
        </form>
    </div>

    <!-- Import Instructions -->
    <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-6">
        <div class="flex">
            <div class="flex-shrink-0">
                <i class="fas fa-info-circle text-blue-400 text-xl"></i>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-blue-800">Import Instructions</h3>
                <div class="mt-2 text-sm text-blue-700">
                    <p class="mb-2"><strong>For Contacts:</strong></p>
                    <ul class="list-disc list-inside mb-4">
                        <li>CSV format with columns: name, email, phone (optional)</li>
                        <li>First row should contain column headers</li>
                    </ul>
                    <p class="mb-2"><strong>For Emails:</strong></p>
                    <ul class="list-disc list-inside">
                        <li>Standard mbox or CSV format</li>
                        <li>Emails will be imported to the selected mailbox</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
