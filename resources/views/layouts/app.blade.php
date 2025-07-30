<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Administración de Correos')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .sidebar-item:hover {
            background-color: #f3f4f6;
        }
        .sidebar-item.active {
            background-color: #e5e7eb;
            border-right: 3px solid #6366f1;
        }
        .dropdown-menu {
            z-index: 1000;
            min-width: 200px;
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Header -->
    <header class="bg-white border-b border-gray-200 px-6 py-4">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <div class="flex items-center space-x-2">
                    <div class="w-8 h-8 bg-gradient-to-r from-blue-600 to-purple-600 rounded flex items-center justify-center">
                        <span class="text-white font-bold text-sm">EM</span>
                    </div>
                    <span class="font-bold text-xl text-gray-800">EmailMaster</span>
                </div>
            </div>
            
            <div class="flex items-center space-x-4">
                <div class="relative">
                    <input type="text" placeholder="Buscar..." class="bg-gray-100 rounded-lg px-4 py-2 pl-10 w-64 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                </div>
                
                <div class="flex items-center space-x-2">
                    <div class="relative">
                        <button class="flex items-center space-x-2 text-gray-700 hover:text-gray-900" onclick="toggleUserMenu()">
                            <div class="w-8 h-8 bg-gray-300 rounded-full flex items-center justify-center">
                                <i class="fas fa-user text-gray-600"></i>
                            </div>
                            <span class="text-sm">{{ Auth::user()->name }}</span>
                            <i class="fas fa-chevron-down text-xs"></i>
                        </button>
                        <div id="userMenu" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-50 border border-gray-200">
                            <div class="py-1">
                                <div class="px-4 py-2 text-sm text-gray-700 border-b border-gray-100">
                                    <div class="font-medium">{{ Auth::user()->name }}</div>
                                    <div class="text-xs text-gray-500">{{ Auth::user()->email }}</div>
                                </div>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-sign-out-alt w-4 h-4 mr-2"></i>
                                        Cerrar Sesión
                                    </button>
                                </form>
                            </div>
                        </div>
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
                        <a href="{{ route('dashboard') }}" class="sidebar-item {{ request()->routeIs('dashboard') ? 'active' : '' }} flex items-center px-6 py-3 text-gray-700 hover:bg-gray-50">
                            <i class="fas fa-home w-5 h-5 mr-3 {{ request()->routeIs('dashboard') ? 'text-indigo-600' : '' }}"></i>
                            Panel Principal
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('mailboxes.index') }}" class="sidebar-item {{ request()->routeIs('mailboxes.*') ? 'active' : '' }} flex items-center px-6 py-3 text-gray-700">
                            <i class="fas fa-envelope w-5 h-5 mr-3 {{ request()->routeIs('mailboxes.*') ? 'text-indigo-600' : '' }}"></i>
                            Buzones de Correo
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('forwarders.index') }}" class="sidebar-item {{ request()->routeIs('forwarders.*') ? 'active' : '' }} flex items-center px-6 py-3 text-gray-700 hover:bg-gray-50">
                            <i class="fas fa-share w-5 h-5 mr-3 {{ request()->routeIs('forwarders.*') ? 'text-indigo-600' : '' }}"></i>
                            Reenvíos
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('email-alias.index') }}" class="sidebar-item {{ request()->routeIs('email-alias.*') ? 'active' : '' }} flex items-center px-6 py-3 text-gray-700 hover:bg-gray-50">
                            <i class="fas fa-at w-5 h-5 mr-3 {{ request()->routeIs('email-alias.*') ? 'text-indigo-600' : '' }}"></i>
                            Alias de Correo
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('auto-reply.index') }}" class="sidebar-item {{ request()->routeIs('auto-reply.*') ? 'active' : '' }} flex items-center px-6 py-3 text-gray-700 hover:bg-gray-50">
                            <i class="fas fa-reply w-5 h-5 mr-3 {{ request()->routeIs('auto-reply.*') ? 'text-indigo-600' : '' }}"></i>
                            Respuesta Automática
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('email-logs.index') }}" class="sidebar-item {{ request()->routeIs('email-logs.*') ? 'active' : '' }} flex items-center px-6 py-3 text-gray-700 hover:bg-gray-50">
                            <i class="fas fa-list w-5 h-5 mr-3 {{ request()->routeIs('email-logs.*') ? 'text-indigo-600' : '' }}"></i>
                            Registros de Correo
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('virus-scan.index') }}" class="sidebar-item {{ request()->routeIs('virus-scan.*') ? 'active' : '' }} flex items-center px-6 py-3 text-gray-700 hover:bg-gray-50">
                            <i class="fas fa-shield-alt w-5 h-5 mr-3 {{ request()->routeIs('virus-scan.*') ? 'text-indigo-600' : '' }}"></i>
                            Análisis de Virus
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('email-import.index') }}" class="sidebar-item {{ request()->routeIs('email-import.*') ? 'active' : '' }} flex items-center px-6 py-3 text-gray-700 hover:bg-gray-50">
                            <i class="fas fa-download w-5 h-5 mr-3 {{ request()->routeIs('email-import.*') ? 'text-indigo-600' : '' }}"></i>
                            Importar Correos
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-6">
            @if(session('success'))
                <div class="mb-4 bg-green-50 border border-green-200 rounded-md p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-check-circle text-green-400"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 bg-red-50 border border-red-200 rounded-md p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-circle text-red-400"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <script>
        function toggleUserMenu() {
            document.getElementById('userMenu').classList.toggle('hidden');
        }

        // Close user menu when clicking outside
        document.addEventListener('click', function(event) {
            const userMenu = document.getElementById('userMenu');
            const userButton = event.target.closest('button');
            
            if (!userButton || userButton.onclick !== toggleUserMenu) {
                userMenu.classList.add('hidden');
            }
        });
    </script>

    @stack('scripts')
</body>
</html>
