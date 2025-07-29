<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-gray-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - {{ $title ?? 'Dashboard' }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Additional Head Content -->
    @stack('head')
</head>
<body class="h-full font-sans antialiased bg-gray-50">
    <div class="min-h-full flex flex-col">
        <!-- Enhanced Navigation -->
        <nav class="bg-white shadow-sm border-b border-gray-200 sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <!-- Logo and Brand -->
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <a href="{{ route('dashboard') }}" class="flex items-center space-x-2">
                                <div class="w-8 h-8 bg-gradient-to-br from-blue-600 to-purple-600 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"/>
                                    </svg>
                                </div>
                                <span class="text-xl font-bold text-gray-900 hidden sm:block">Management</span>
                            </a>
                        </div>

                        <!-- Desktop Navigation -->
                        <div class="hidden md:ml-10 md:flex md:items-center md:space-x-8">
                            @auth
                                @if(auth()->user()->role === 'manager')
                                    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'nav-link-active' : 'nav-link-inactive' }}">
                                        Dashboard
                                    </a>
                                    <a href="{{ route('manager.users.index') }}" class="nav-link {{ request()->routeIs('manager.users.*') ? 'nav-link-active' : 'nav-link-inactive' }}">
                                        Users
                                    </a>
                                @elseif(auth()->user()->role === 'gudang')
                                    <a href="{{ route('gudang.dashboard') }}" class="nav-link {{ request()->routeIs('gudang.dashboard') ? 'nav-link-active' : 'nav-link-inactive' }}">
                                        Dashboard
                                    </a>
                                @elseif(auth()->user()->role === 'member')
                                    <a href="{{ route('member.dashboard') }}" class="nav-link {{ request()->routeIs('member.dashboard') ? 'nav-link-active' : 'nav-link-inactive' }}">
                                        Dashboard
                                    </a>
                                @endif
                            @endauth
                        </div>
                    </div>

                    <!-- User Menu -->
                    <div class="flex items-center space-x-4">
                        @auth
                            <!-- Mobile menu button -->
                            <button type="button" class="md:hidden p-2 rounded-md text-gray-500 hover:text-gray-700 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500" x-on:click="mobileMenuOpen = !mobileMenuOpen">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                                </svg>
                            </button>

                            <!-- User dropdown -->
                            <div class="relative" x-data="{ userMenuOpen: false }">
                                <button type="button" class="flex items-center space-x-3 p-2 rounded-lg hover:bg-gray-100 transition-colors duration-200" x-on:click="userMenuOpen = !userMenuOpen">
                                    <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center">
                                        <span class="text-white text-sm font-medium">{{ substr(auth()->user()->name, 0, 1) }}</span>
                                    </div>
                                    <div class="hidden sm:block text-left">
                                        <p class="text-sm font-medium text-gray-900">{{ auth()->user()->name }}</p>
                                        <p class="text-xs text-gray-500 capitalize">{{ auth()->user()->role }}</p>
                                    </div>
                                    <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                    </svg>
                                </button>

                                <!-- User dropdown menu -->
                                <div x-show="userMenuOpen" x-on:click.outside="userMenuOpen = false" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="absolute right-0 mt-2 w-56 rounded-lg shadow-lg bg-white ring-1 ring-black ring-opacity-5 divide-y divide-gray-100 z-50">
                                    <div class="px-4 py-3">
                                        <p class="text-sm text-gray-900 font-medium">{{ auth()->user()->name }}</p>
                                        <p class="text-sm text-gray-500">{{ auth()->user()->email }}</p>
                                        <p class="text-xs text-gray-400 capitalize mt-1">Role: {{ auth()->user()->role }}</p>
                                    </div>
                                    <div class="py-1">
                                        <a href="{{ route('profile.edit') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors duration-200">
                                            <svg class="w-4 h-4 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                            </svg>
                                            Profile
                                        </a>
                                    </div>
                                    <div class="py-1">
                                        <form method="POST" action="{{ route('logout') }}" class="w-full">
                                            @csrf
                                            <button type="submit" class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors duration-200">
                                                <svg class="w-4 h-4 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                                </svg>
                                                Logout
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="flex items-center space-x-4">
                                <a href="{{ route('login') }}" class="text-gray-700 hover:text-gray-900 font-medium">Login</a>
                                <a href="{{ route('register') }}" class="btn-primary">Register</a>
                            </div>
                        @endauth
                    </div>
                </div>

                <!-- Mobile Navigation Menu -->
                @auth
                <div x-show="mobileMenuOpen" x-on:click.outside="mobileMenuOpen = false" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="md:hidden border-t border-gray-200 bg-white">
                    <div class="px-2 pt-2 pb-3 space-y-1">
                        @if(auth()->user()->role === 'manager')
                            <a href="{{ route('dashboard') }}" class="nav-link-mobile {{ request()->routeIs('dashboard') ? 'nav-link-active' : 'nav-link-inactive' }}">
                                Dashboard
                            </a>
                            <a href="{{ route('manager.users.index') }}" class="nav-link-mobile {{ request()->routeIs('manager.users.*') ? 'nav-link-active' : 'nav-link-inactive' }}">
                                Users
                            </a>
                        @elseif(auth()->user()->role === 'gudang')
                            <a href="{{ route('gudang.dashboard') }}" class="nav-link-mobile {{ request()->routeIs('gudang.dashboard') ? 'nav-link-active' : 'nav-link-inactive' }}">
                                Dashboard
                            </a>
                        @elseif(auth()->user()->role === 'member')
                            <a href="{{ route('member.dashboard') }}" class="nav-link-mobile {{ request()->routeIs('member.dashboard') ? 'nav-link-active' : 'nav-link-inactive' }}">
                                Dashboard
                            </a>
                        @endif
                    </div>
                </div>
                @endauth
            </div>
        </nav>

        <!-- Breadcrumbs (if provided) -->
        @if(isset($breadcrumbs) && count($breadcrumbs) > 0)
        <div class="bg-white border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3">
                <nav class="flex" aria-label="Breadcrumb">
                    <ol class="flex items-center space-x-2">
                        @foreach($breadcrumbs as $breadcrumb)
                            <li class="flex items-center">
                                @if(!$loop->first)
                                    <svg class="w-4 h-4 text-gray-400 mx-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 111.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                @endif
                                @if(isset($breadcrumb['url']) && !$loop->last)
                                    <a href="{{ $breadcrumb['url'] }}" class="text-sm text-gray-500 hover:text-gray-700 transition-colors duration-200">
                                        {{ $breadcrumb['title'] }}
                                    </a>
                                @else
                                    <span class="text-sm text-gray-900 font-medium">{{ $breadcrumb['title'] }}</span>
                                @endif
                            </li>
                        @endforeach
                    </ol>
                </nav>
            </div>
        </div>
        @endif

        <!-- Page Header (if provided) -->
        @if(isset($header))
        <header class="bg-white border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                {{ $header }}
            </div>
        </header>
        @endif

        <!-- Main Content -->
        <main class="flex-1 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                <!-- Flash Messages -->
                @if(session('success'))
                <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg animate-fadeIn">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        {{ session('success') }}
                    </div>
                </div>
                @endif

                @if(session('error'))
                <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg animate-fadeIn">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                        </svg>
                        {{ session('error') }}
                    </div>
                </div>
                @endif

                <!-- Page Content -->
                <div class="animate-fadeIn">
                    {{ $slot }}
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="bg-white border-t border-gray-200 mt-auto">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <div class="flex items-center space-x-2 mb-4 md:mb-0">
                        <div class="w-6 h-6 bg-gradient-to-br from-blue-600 to-purple-600 rounded-md flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"/>
                            </svg>
                        </div>
                        <span class="text-sm text-gray-600">© {{ date('Y') }} Management System. All rights reserved.</span>
                    </div>
                    <div class="flex items-center space-x-4 text-sm text-gray-500">
                        <span>Built with Laravel & Tailwind CSS</span>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <!-- Additional Scripts -->
    @stack('scripts')

    <!-- Alpine.js initialization -->
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('layout', () => ({
                mobileMenuOpen: false,
                userMenuOpen: false,
                
                init() {
                    // Auto-close mobile menu on resize
                    window.addEventListener('resize', () => {
                        if (window.innerWidth >= 768) {
                            this.mobileMenuOpen = false;
                        }
                    });
                }
            }));
        });
    </script>
</body>
</html>
