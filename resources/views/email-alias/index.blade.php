@extends('layouts.app')

@section('title', 'Email Alias - Administración de Correos')

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
            <li aria-current="page">
                <div class="flex items-center">
                    <i class="fas fa-chevron-right w-4 h-4 text-gray-400 mx-2"></i>
                    <span class="text-sm font-medium text-gray-900">Email Alias</span>
                </div>
            </li>
        </ol>
    </nav>

    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Email Alias</h1>
        <p class="text-gray-600">Create alternative email addresses that forward to existing mailboxes</p>
    </div>

    <!-- Email Alias Section -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <!-- Section Header -->
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-gray-900">Active Aliases</h2>
                    <p class="text-sm text-gray-500">{{ count($aliases ?? []) }} aliases configured</p>
                </div>
                <button onclick="openCreateAliasModal()" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg flex items-center space-x-2 transition-colors">
                    <i class="fas fa-plus w-4 h-4"></i>
                    <span>Create alias</span>
                </button>
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Alias Email
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Forwards To
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($aliases ?? [
                        ['alias' => 'contacto@devdatep.com', 'forwards_to' => 'ventas@devdatep.com', 'status' => 'Active'],
                        ['alias' => 'admin@devdatep.com', 'forwards_to' => 'gerencia@devdatep.com', 'status' => 'Active'],
                        ['alias' => 'help@devdatep.com', 'forwards_to' => 'ventas@devdatep.com', 'status' => 'Inactive']
                    ] as $alias)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <span class="text-sm font-medium text-gray-900">{{ $alias['alias'] }}</span>
                                <button class="ml-2 text-gray-400 hover:text-gray-600">
                                    <i class="fas fa-copy w-4 h-4"></i>
                                </button>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-sm text-gray-900">{{ $alias['forwards_to'] }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-2 h-2 {{ $alias['status'] === 'Active' ? 'bg-green-400' : 'bg-red-400' }} rounded-full mr-2"></div>
                                <span class="text-sm text-gray-900">{{ $alias['status'] }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex items-center justify-end space-x-2">
                                <button class="text-indigo-600 hover:text-indigo-900">Edit</button>
                                <button class="text-red-600 hover:text-red-900">Delete</button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center">
                            <div class="text-gray-500">
                                <i class="fas fa-at text-4xl mb-4"></i>
                                <p class="text-lg font-medium">No aliases configured</p>
                                <p class="text-sm">Create your first email alias</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Create Alias Modal -->
<div id="createAliasModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900">Create Email Alias</h3>
                <button class="text-gray-400 hover:text-gray-600" onclick="closeAliasModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form action="{{ route('email-alias.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="alias" class="block text-sm font-medium text-gray-700 mb-2">Alias Email</label>
                    <div class="flex">
                        <input type="text" id="alias" name="alias" class="flex-1 border border-gray-300 rounded-l-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="alias">
                        <span class="bg-gray-50 border border-l-0 border-gray-300 rounded-r-md px-3 py-2 text-gray-500">@devdatep.com</span>
                    </div>
                </div>
                <div class="mb-6">
                    <label for="forwards_to" class="block text-sm font-medium text-gray-700 mb-2">Forward To</label>
                    <select id="forwards_to" name="forwards_to" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="">Select mailbox...</option>
                        <option value="ventas@devdatep.com">ventas@devdatep.com</option>
                        <option value="reclutamiento@devdatep.com">reclutamiento@devdatep.com</option>
                        <option value="gerencia@devdatep.com">gerencia@devdatep.com</option>
                        <option value="ventas_online@devdatep.com">ventas_online@devdatep.com</option>
                    </select>
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeAliasModal()" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-md">
                        Cancel
                    </button>
                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-md">
                        Create Alias
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openCreateAliasModal() {
    document.getElementById('createAliasModal').classList.remove('hidden');
}

function closeAliasModal() {
    document.getElementById('createAliasModal').classList.add('hidden');
}
</script>
@endsection
