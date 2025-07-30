@extends('layouts.app')

@section('title', 'Create Auto-Reply - Administración de Correos')

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
                    <a href="{{ route('auto-reply.index') }}" class="text-sm font-medium text-gray-500 hover:text-indigo-600">Automatic Reply</a>
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
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Create Automatic Reply</h1>
        <p class="text-gray-600">Set up an automatic response for a mailbox</p>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">Auto-Reply Configuration</h2>
        </div>
        
        <form action="{{ route('auto-reply.store') }}" method="POST" class="p-6">
            @csrf
            
            <div class="space-y-6">
                <div>
                    <label for="mailbox_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Mailbox
                    </label>
                    <select 
                        id="mailbox_id" 
                        name="mailbox_id" 
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('mailbox_id') border-red-300 @enderror"
                        required
                    >
                        <option value="">Select a mailbox...</option>
                        @foreach($mailboxes as $mailbox)
                            <option value="{{ $mailbox->id }}" {{ old('mailbox_id') == $mailbox->id ? 'selected' : '' }}>
                                {{ $mailbox->email }}
                            </option>
                        @endforeach
                    </select>
                    @error('mailbox_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-sm text-gray-500">Select the mailbox for this auto-reply</p>
                </div>

                <div>
                    <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">
                        Subject
                    </label>
                    <input 
                        type="text" 
                        id="subject" 
                        name="subject" 
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('subject') border-red-300 @enderror" 
                        placeholder="Out of Office"
                        value="{{ old('subject') }}"
                        required
                    >
                    @error('subject')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-sm text-gray-500">Subject line for the automatic reply</p>
                </div>

                <div>
                    <label for="message" class="block text-sm font-medium text-gray-700 mb-2">
                        Message
                    </label>
                    <textarea 
                        id="message" 
                        name="message" 
                        rows="6"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('message') border-red-300 @enderror" 
                        placeholder="Thank you for your email. I am currently out of office..."
                        required
                    >{{ old('message') }}</textarea>
                    @error('message')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-sm text-gray-500">The automatic reply message</p>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="start_date" class="block text-sm font-medium text-gray-700 mb-2">
                            Start Date (Optional)
                        </label>
                        <input 
                            type="date" 
                            id="start_date" 
                            name="start_date" 
                            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('start_date') border-red-300 @enderror" 
                            value="{{ old('start_date') }}"
                        >
                        @error('start_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="end_date" class="block text-sm font-medium text-gray-700 mb-2">
                            End Date (Optional)
                        </label>
                        <input 
                            type="date" 
                            id="end_date" 
                            name="end_date" 
                            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('end_date') border-red-300 @enderror" 
                            value="{{ old('end_date') }}"
                        >
                        @error('end_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
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
                        <span class="ml-2 text-sm text-gray-700">Activate auto-reply immediately</span>
                    </label>
                </div>
            </div>

            <div class="flex justify-end space-x-3 mt-8 pt-6 border-t border-gray-200">
                <a href="{{ route('auto-reply.index') }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-md transition-colors">
                    Cancel
                </a>
                <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-md transition-colors">
                    Create Auto-Reply
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
