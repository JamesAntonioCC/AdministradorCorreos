<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Administración de Correos')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .sidebar-item:hover {
            background-color: #f3f4f6;
        }
        .sidebar-item.active {
            background-color: #e5e7eb;
            border-right: 3px solid #6366f1;
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Header -->
    <header class="bg-white border-b border-gray-200 px-6 py-4">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <div class="flex items-center space-x-2">
                    <div class="w-8 h-8 bg-indigo-600 rounded flex items-center justify-center">
                        <span class="text-white font-bold text-sm">H</span>
                    </div>
                    <span class="font-bold text-xl">HOSTINGER</span>
                </div>
            </div>
            
            <div class="flex items-center space-x-4">
                <div class="relative">
                    <input type="text" placeholder="Search" class="bg-gray-100 rounded-lg px-4 py-2 pl-10 w-64 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                    <span class="absolute right-3 top-2 bg-indigo-100 text-indigo-600 px-2 py-1 rounded text-xs">Beta</span>
                </div>
                
                <div class="flex items-center space-x-2">
                    <div class="relative">
                        <i class="fas fa-shopping-cart text-gray-600"></i>
                        <span class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs">1</span>
                    </div>
                    <div class="w-8 h-8 bg-gray-300 rounded-full flex items-center justify-center">
                        <i class="fas fa-user text-gray-600"></i>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="flex">
        <!-- Sidebar -->
        <aside class="w-64 bg-white border-r border-gray-200 min-h-screen">
            <nav class="py-4">
                <ul class="space-y-1">
                    <li>
                        <a href="{{ route('dashboard') }}" class="sidebar-item flex items-center px-6 py-3 text-gray-700 hover:bg-gray-50">
                            <i class="fas fa-home w-5 h-5 mr-3"></i>
                            Overview
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('mailboxes.index') }}" class="sidebar-item active flex items-center px-6 py-3 text-gray-700">
                            <i class="fas fa-envelope w-5 h-5 mr-3 text-indigo-600"></i>
                            Mailboxes
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('forwarders.index') }}" class="sidebar-item flex items-center px-6 py-3 text-gray-700 hover:bg-gray-50">
                            <i class="fas fa-share w-5 h-5 mr-3"></i>
                            Forwarders
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('email-alias.index') }}" class="sidebar-item flex items-center px-6 py-3 text-gray-700 hover:bg-gray-50">
                            <i class="fas fa-at w-5 h-5 mr-3"></i>
                            Email Alias
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('auto-reply.index') }}" class="sidebar-item flex items-center px-6 py-3 text-gray-700 hover:bg-gray-50">
                            <i class="fas fa-reply w-5 h-5 mr-3"></i>
                            Automatic Reply
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('connect-domain.index') }}" class="sidebar-item flex items-center px-6 py-3 text-gray-700 hover:bg-gray-50">
                            <i class="fas fa-globe w-5 h-5 mr-3"></i>
                            Connect Domain
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('connect-apps.index') }}" class="sidebar-item flex items-center px-6 py-3 text-gray-700 hover:bg-gray-50">
                            <i class="fas fa-mobile-alt w-5 h-5 mr-3"></i>
                            Connect Apps & Devices
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('email-logs.index') }}" class="sidebar-item flex items-center px-6 py-3 text-gray-700 hover:bg-gray-50">
                            <i class="fas fa-list w-5 h-5 mr-3"></i>
                            Email Logs
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('email-import.index') }}" class="sidebar-item flex items-center px-6 py-3 text-gray-700 hover:bg-gray-50">
                            <i class="fas fa-download w-5 h-5 mr-3"></i>
                            Email Import
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('custom-dkim.index') }}" class="sidebar-item flex items-center px-6 py-3 text-gray-700 hover:bg-gray-50">
                            <i class="fas fa-cog w-5 h-5 mr-3"></i>
                            Custom DKIM
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('tutorials.index') }}" class="sidebar-item flex items-center px-6 py-3 text-gray-700 hover:bg-gray-50">
                            <i class="fas fa-book w-5 h-5 mr-3"></i>
                            Tutorials
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-6">
            @yield('content')
        </main>
    </div>

    <script>
        // JavaScript para funcionalidades interactivas
        document.addEventListener('DOMContentLoaded', function() {
            // Dropdown menus
            const dropdownButtons = document.querySelectorAll('[data-dropdown-toggle]');
            dropdownButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const dropdownId = this.getAttribute('data-dropdown-toggle');
                    const dropdown = document.getElementById(dropdownId);
                    dropdown.classList.toggle('hidden');
                });
            });

            // Close dropdowns when clicking outside
            document.addEventListener('click', function() {
                const dropdowns = document.querySelectorAll('[data-dropdown]');
                dropdowns.forEach(dropdown => {
                    dropdown.classList.add('hidden');
                });
            });
        });
    </script>
</body>
</html>
