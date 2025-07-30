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
                        <a href="{{ route('virus-scan.quarantine') }}" class="sidebar-item {{ request()->routeIs('virus-scan.quarantine') ? 'active' : '' }} flex items-center px-6 py-3 text-gray-700 hover:bg-gray-50">
                            <i class="fas fa-lock w-5 h-5 mr-3 {{ request()->routeIs('virus-scan.quarantine') ? 'text-indigo-600' : '' }}"></i>
                            Cuarentena
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

    <!-- Modal para ver detalles del virus scan -->
    <div id="virusScanModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-gray-900" id="modalTitle">Detalles del Análisis</h3>
                    <button onclick="closeVirusScanModal()" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div id="modalContent" class="space-y-4">
                    <!-- Content will be loaded here -->
                </div>
                <div class="flex justify-end space-x-3 mt-6">
                    <button onclick="closeVirusScanModal()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                        Cerrar
                    </button>
                    <button id="quarantineBtn" onclick="quarantineEmail()" class="hidden px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                        Poner en Cuarentena
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleUserMenu() {
            document.getElementById('userMenu').classList.toggle('hidden');
        }

        // Close user menu when clicking outside
        document.addEventListener('click', function(event) {
            const userMenu = document.getElementById('userMenu');
            const userButton = event.target.closest('button');
            
            if (!userButton || !userButton.onclick || userButton.onclick.toString().indexOf('toggleUserMenu') === -1) {
                userMenu.classList.add('hidden');
            }
        });

        // Virus scan modal functions
        let currentScanId = null;

        function showVirusScanDetails(scanId, senderEmail, recipientEmail, subject, scanResult, threatName, scannedAt) {
            currentScanId = scanId;
            document.getElementById('modalTitle').textContent = 'Detalles del Análisis de Virus';
            
            const content = `
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Remitente</label>
                        <p class="mt-1 text-sm text-gray-900">${senderEmail}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Destinatario</label>
                        <p class="mt-1 text-sm text-gray-900">${recipientEmail}</p>
                    </div>
                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Asunto</label>
                        <p class="mt-1 text-sm text-gray-900">${subject}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Resultado</label>
                        <p class="mt-1 text-sm text-gray-900">${scanResult}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Amenaza</label>
                        <p class="mt-1 text-sm text-gray-900">${threatName || 'Ninguna'}</p>
                    </div>
                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Fecha de Análisis</label>
                        <p class="mt-1 text-sm text-gray-900">${scannedAt}</p>
                    </div>
                </div>
            `;
            
            document.getElementById('modalContent').innerHTML = content;
            
            // Show quarantine button if threat detected
            const quarantineBtn = document.getElementById('quarantineBtn');
            if (scanResult !== 'Limpio') {
                quarantineBtn.classList.remove('hidden');
            } else {
                quarantineBtn.classList.add('hidden');
            }
            
            document.getElementById('virusScanModal').classList.remove('hidden');
        }

        function closeVirusScanModal() {
            document.getElementById('virusScanModal').classList.add('hidden');
            currentScanId = null;
        }

        function quarantineEmail() {
            if (currentScanId) {
                // Create form and submit
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/virus-scan/${currentScanId}/quarantine`;
                
                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = '{{ csrf_token() }}';
                
                form.appendChild(csrfToken);
                document.body.appendChild(form);
                form.submit();
            }
        }
    </script>

    @stack('scripts')
</body>
</html>
