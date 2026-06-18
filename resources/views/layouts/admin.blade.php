<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel') - Cinema Booking</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        petra: '#1C7287',
                        'petra-dark': '#155969',
                        'petra-light': '#2A9BB8',
                    }
                }
            }
        }
    </script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside id="sidebar" class="fixed z-30 inset-y-0 left-0 w-64 bg-petra transform -translate-x-full lg:translate-x-0 lg:static lg:inset-auto transition-transform duration-200 ease-in-out">
            <div class="flex items-center justify-center h-16 bg-petra-dark">
                <a href="{{ route('admin.dashboard') }}" class="text-white text-xl font-bold tracking-wide">
                    <svg class="w-8 h-8 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z"/>
                    </svg>
                    CineAdmin
                </a>
            </div>

            <nav class="mt-6 px-4 space-y-2">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 rounded-lg text-white hover:bg-petra-dark transition-colors duration-150 {{ request()->routeIs('admin.dashboard') ? 'bg-petra-dark' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                    Dashboard
                </a>
                <a href="{{ route('admin.movies.index') }}" class="flex items-center px-4 py-3 rounded-lg text-white hover:bg-petra-dark transition-colors duration-150 {{ request()->routeIs('admin.movies.*') ? 'bg-petra-dark' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z"/>
                    </svg>
                    Movies
                </a>
                <a href="{{ route('admin.studios.index') }}" class="flex items-center px-4 py-3 rounded-lg text-white hover:bg-petra-dark transition-colors duration-150 {{ request()->routeIs('admin.studios.*') ? 'bg-petra-dark' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                    Studios
                </a>
                <a href="{{ route('admin.schedules.index') }}" class="flex items-center px-4 py-3 rounded-lg text-white hover:bg-petra-dark transition-colors duration-150 {{ request()->routeIs('admin.schedules.*') ? 'bg-petra-dark' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    Schedules
                </a>
                <a href="{{ route('admin.transactions.index') }}" class="flex items-center px-4 py-3 rounded-lg text-white hover:bg-petra-dark transition-colors duration-150 {{ request()->routeIs('admin.transactions.*') ? 'bg-petra-dark' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                    </svg>
                    Transactions
                </a>
            </nav>
        </aside>

        <!-- Overlay for mobile -->
        <div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-20 hidden lg:hidden" onclick="toggleSidebar()"></div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col lg:ml-0">
            <!-- Top Bar -->
            <header class="bg-white shadow-sm border-b border-gray-200 sticky top-0 z-10">
                <div class="flex items-center justify-between h-16 px-4 lg:px-8">
                    <button onclick="toggleSidebar()" class="lg:hidden text-gray-600 hover:text-petra focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>

                    <div class="flex-1 lg:flex-none">
                        <h2 class="text-lg font-semibold text-gray-800">@yield('title', 'Dashboard')</h2>
                    </div>

                    <div class="flex items-center space-x-4">
                        <div class="hidden sm:block text-right">
                            <p class="text-sm font-medium text-gray-700">{{ auth()->user()->name ?? 'Admin' }}</p>
                            <p class="text-xs text-gray-500">{{ auth()->user()->email ?? 'admin@cinema.com' }}</p>
                        </div>
                        <div class="w-9 h-9 bg-petra rounded-full flex items-center justify-center text-white text-sm font-bold">
                            {{ strtoupper(auth()->user()->name ?? 'A')[0] }}
                        </div>
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="text-gray-500 hover:text-red-500 transition-colors" title="Logout">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 p-4 lg:p-8">
                @if(session('success'))
                    <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg flex items-center justify-between" id="success-message">
                        <span>{{ session('success') }}</span>
                        <button onclick="document.getElementById('success-message').remove()" class="text-green-500 hover:text-green-700">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
                        </button>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }
    </script>
</body>
</html>