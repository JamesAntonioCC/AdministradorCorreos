@extends('layouts.app')

@section('title', 'Mailboxes - Administración de Correos')

@section('content')
<div class="max-w-7xl mx-auto">
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
                    <span class="text-sm font-medium text-gray-500">Emails</span>
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
                    <span class="text-sm font-medium text-gray-900">Mailboxes</span>
                </div>
            </li>
        </ol>
    </nav>

    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Mailboxes</h1>
    </div>

    <!-- Mailboxes Section -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <!-- Section Header -->
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-gray-900">Your mailboxes</h2>
                    <p class="text-sm text-gray-500">{{ $remainingMailboxes ?? 96 }} remaining</p>
                </div>
                <button class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg flex items-center space-x-2 transition-colors">
                    <i class="fas fa-plus w-4 h-4"></i>
                    <span>Create a mailbox</span>
                </button>
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Mailbox
                            <i class="fas fa-sort ml-1"></i>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                            <i class="fas fa-sort ml-1"></i>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Usage
                        </th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($mailboxes ?? [
                        ['email' => 'ventas@devdatep.com', 'status' => 'Active', 'used' => '3.67 MB', 'total' => '1.00 GB', 'percentage' => 0],
                        ['email' => 'reclutamiento@devdatep.com', 'status' => 'Active', 'used' => '50.96 MB', 'total' => '1.00 GB', 'percentage' => 4],
                        ['email' => 'gerencia@devdatep.com', 'status' => 'Active', 'used' => '748.00 KB', 'total' => '1.00 GB', 'percentage' => 0],
                        ['email' => 'ventas_online@devdatep.com', 'status' => 'Active', 'used' => '593.00 KB', 'total' => '1.00 GB', 'percentage' => 0]
                    ] as $mailbox)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <span class="text-sm font-medium text-gray-900">{{ $mailbox['email'] }}</span>
                                <button class="ml-2 text-gray-400 hover:text-gray-600">
                                    <i class="fas fa-copy w-4 h-4"></i>
                                </button>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-2 h-2 bg-green-400 rounded-full mr-2"></div>
                                <span class="text-sm text-gray-900">{{ $mailbox['status'] }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">
                                @if($mailbox['percentage'] > 0)
                                    <div class="mb-1">{{ $mailbox['percentage'] }}% used</div>
                                @else
                                    <div class="mb-1">0% used</div>
                                @endif
                                <div class="text-xs text-gray-500">{{ $mailbox['used'] }} / {{ $mailbox['total'] }}</div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex items-center justify-end space-x-2">
                                <a href="#" class="text-indigo-600 hover:text-indigo-900 font-medium">Webmail</a>
                                <div class="relative">
                                    <button class="text-gray-400 hover:text-gray-600 p-1" data-dropdown-toggle="dropdown-{{ $loop->index }}">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <div id="dropdown-{{ $loop->index }}" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-10 border border-gray-200" data-dropdown>
                                        <div class="py-1">
                                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                <i class="fas fa-edit w-4 h-4 mr-2"></i>
                                                Edit mailbox
                                            </a>
                                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                <i class="fas fa-key w-4 h-4 mr-2"></i>
                                                Change password
                                            </a>
                                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                <i class="fas fa-cog w-4 h-4 mr-2"></i>
                                                Settings
                                            </a>
                                            <div class="border-t border-gray-100"></div>
                                            <a href="#" class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                                                <i class="fas fa-trash w-4 h-4 mr-2"></i>
                                                Delete mailbox
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center">
                            <div class="text-gray-500">
                                <i class="fas fa-envelope text-4xl mb-4"></i>
                                <p class="text-lg font-medium">No mailboxes found</p>
                                <p class="text-sm">Create your first mailbox to get started</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Create Mailbox Modal -->
<div id="createMailboxModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900">Create New Mailbox</h3>
                <button class="text-gray-400 hover:text-gray-600" onclick="closeModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form action="{{ route('mailboxes.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                    <div class="flex">
                        <input type="text" id="email" name="email" class="flex-1 border border-gray-300 rounded-l-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="username">
                        <span class="bg-gray-50 border border-l-0 border-gray-300 rounded-r-md px-3 py-2 text-gray-500">@devdatep.com</span>
                    </div>
                </div>
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                    <input type="password" id="password" name="password" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
                <div class="mb-6">
                    <label for="quota" class="block text-sm font-medium text-gray-700 mb-2">Storage Quota (GB)</label>
                    <select id="quota" name="quota" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="1">1 GB</option>
                        <option value="2">2 GB</option>
                        <option value="5">5 GB</option>
                        <option value="10">10 GB</option>
                    </select>
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeModal()" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-md">
                        Cancel
                    </button>
                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-md">
                        Create Mailbox
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openCreateModal() {
    document.getElementById('createMailboxModal').classList.remove('hidden');
}

function closeModal() {
    document.getElementById('createMailboxModal').classList.add('hidden');
}

// Open modal when clicking create button
document.querySelector('button:has(i.fa-plus)').addEventListener('click', openCreateModal);
</script>
@endsection
