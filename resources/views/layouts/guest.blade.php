<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            body { font-family: 'Inter', sans-serif; }
        </style>
    </head>
    <body class="font-sans text-gray-900 antialiased bg-gray-50">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
            {{-- <!-- Logo Section -->
            <div class="mb-6">
                <div class="flex items-center justify-center">
                    <div class="bg-blue-600 p-3 rounded-xl shadow-lg">
                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/>
                        </svg>
                    </div>
                    <div class="ml-4 mt-6">
                        <h1 class="text-xl font-bold text-gray-900">Rental Management</h1>
                        <p class="text-sm text-gray-500">Modern & Secure</p>
                    </div>
                </div>
            </div> --}}

            <!-- Form Container -->
            <div class="w-full sm:max-w-md">
                <div class="bg-white px-6 py-8 shadow-lg sm:rounded-lg border border-gray-200">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>
