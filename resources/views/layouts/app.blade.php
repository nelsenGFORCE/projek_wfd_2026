<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Bioskop Petra') - Bioskop Petra</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        petra: {
                            DEFAULT: '#1C7287',
                            dark: '#155A6B',
                            light: '#2A8A9F',
                        }
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
<body class="bg-gray-50 text-gray-800 min-h-screen flex flex-col">

    <nav class="bg-petra-dark shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <a href="{{ url('/') }}" class="flex items-center space-x-2">
                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M18 4l2 4h-3l-2-4h-2l2 4h-3l-2-4H8l2 4H7L5 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V4h-4zM4 18V8h16v10H4zm6-2h2v-4h2v4h2v-6h-6v6z"/>
                        </svg>
                        <span class="text-white font-bold text-xl tracking-wide">Bioskop Petra</span>
                    </a>
                </div>

                <div class="hidden md:flex items-center space-x-6">
                    <a href="{{ route('home') }}" class="text-white hover:text-petra-light transition-colors font-medium">Home</a>
                    <a href="{{ route('movies.index') }}" class="text-white hover:text-petra-light transition-colors font-medium">Movies</a>
                    @auth
                        <a href="{{ route('transactions.index') }}" class="text-white hover:text-petra-light transition-colors font-medium">My Tickets</a>
                    @endauth
                </div>

                <div class="hidden md:flex items-center space-x-4">
                    @guest
                        <a href="{{ route('login') }}" class="text-white hover:text-petra-light transition-colors font-medium">Login</a>
                        <a href="{{ route('register') }}" class="bg-white text-petra-dark px-4 py-2 rounded-lg font-semibold hover:bg-gray-100 transition-colors">Register</a>
                    @endguest
                    @auth
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center space-x-2 text-white hover:text-petra-light transition-colors focus:outline-none">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                <span>{{ auth()->user()->name }}</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>
                            <div x-show="open" @click.away="open = false" x-cloak x-transition class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl py-1 z-50">
                                <a href="{{ route('transactions.index') }}" class="block px-4 py-2 text-gray-700 hover:bg-petra-light hover:text-white transition-colors">My Tickets</a>
                                @auth
                                    @if(auth()->user()->isAdmin())
                                        <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-gray-700 hover:bg-petra-light hover:text-white transition-colors">Admin Panel</a>
                                    @endif
                                @endauth
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 text-gray-700 hover:bg-red-500 hover:text-white transition-colors">Logout</button>
                                </form>
                            </div>
                        </div>
                    @endauth
                </div>

                <div class="md:hidden flex items-center">
                    <button @click="mobileMenu = !mobileMenu" class="text-white focus:outline-none">
                        <svg x-show="!mobileMenu" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                        <svg x-show="mobileMenu" x-cloak class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <div x-show="mobileMenu" x-cloak x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-1" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-1" class="md:hidden bg-petra-dark border-t border-petra-light">
            <div class="px-4 pt-2 pb-3 space-y-1">
                <a href="{{ route('home') }}" class="block text-white hover:bg-petra-light px-3 py-2 rounded-md text-base font-medium transition-colors">Home</a>
                <a href="{{ route('movies.index') }}" class="block text-white hover:bg-petra-light px-3 py-2 rounded-md text-base font-medium transition-colors">Movies</a>
@auth
                        <a href="{{ route('transactions.index') }}" class="block text-white hover:bg-petra-light px-3 py-2 rounded-md text-base font-medium transition-colors">My Tickets</a>
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="block text-white hover:bg-petra-light px-3 py-2 rounded-md text-base font-medium transition-colors">Admin Panel</a>
                        @endif
                    @endauth
                <div class="border-t border-petra-light pt-2 mt-2">
                    @guest
                        <a href="{{ route('login') }}" class="block text-white hover:bg-petra-light px-3 py-2 rounded-md text-base font-medium transition-colors">Login</a>
                        <a href="{{ route('register') }}" class="block text-white hover:bg-petra-light px-3 py-2 rounded-md text-base font-medium transition-colors">Register</a>
                    @endguest
                    @auth
                        <div class="px-3 py-2 text-petra-light font-medium">{{ auth()->user()->name }}</div>
                        <a href="{{ url('/my-tickets') }}" class="block text-white hover:bg-petra-light px-3 py-2 rounded-md text-base font-medium transition-colors">My Tickets</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-left text-white hover:bg-red-600 px-3 py-2 rounded-md text-base font-medium transition-colors">Logout</button>
                        </form>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <main class="flex-1">
        @yield('content')
    </main>

    <footer class="bg-petra-dark text-white mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <div class="flex items-center space-x-2 mb-4">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M18 4l2 4h-3l-2-4h-2l2 4h-3l-2-4H8l2 4H7L5 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V4h-4zM4 18V8h16v10H4zm6-2h2v-4h2v4h2v-6h-6v6z"/>
                        </svg>
                        <span class="font-bold text-xl">Bioskop Petra</span>
                    </div>
                    <p class="text-gray-300 text-sm">Your premium cinema experience. Watch the latest movies in comfort and style.</p>
                </div>
                <div>
                    <h3 class="font-semibold text-lg mb-4">Quick Links</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ route('home') }}" class="text-gray-300 hover:text-white transition-colors">Home</a></li>
                        <li><a href="{{ route('movies.index') }}" class="text-gray-300 hover:text-white transition-colors">Movies</a></li>
                        @auth
                            <li><a href="{{ route('transactions.index') }}" class="text-gray-300 hover:text-white transition-colors">My Tickets</a></li>
                        @endauth
                    </ul>
                </div>
                <div>
                    <h3 class="font-semibold text-lg mb-4">Contact Us</h3>
                    <ul class="space-y-2 text-gray-300 text-sm">
                        <li class="flex items-center space-x-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <span>Jl. Petra No. 1, Surabaya</span>
                        </li>
                        <li class="flex items-center space-x-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                            <span>(031) 123-4567</span>
                        </li>
                        <li class="flex items-center space-x-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            <span>info@bioskoppetra.id</span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-petra-light mt-8 pt-6 text-center text-gray-400 text-sm">
                <p>&copy; {{ date('Y') }} Bioskop Petra. All rights reserved.</p>
            </div>
        </div>
    </footer>

    </body>
</html>