<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Page Not Found - {{ config('app.name', 'Laravel') }}</title>
        
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700&display=swap" rel="stylesheet" />
        
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            body { font-family: 'Inter', sans-serif; }
            .gradient-bg {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            }
            .floating {
                animation: floating 3s ease-in-out infinite;
            }
            @keyframes floating {
                0%, 100% { transform: translateY(0px); }
                50% { transform: translateY(-20px); }
            }
        </style>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen gradient-bg flex flex-col justify-center items-center px-4 relative overflow-hidden">
            <!-- Background Pattern -->
            <div class="absolute inset-0 opacity-10">
                <div class="absolute inset-0" style="background-image: radial-gradient(circle at 25% 25%, white 2px, transparent 2px), radial-gradient(circle at 75% 75%, white 2px, transparent 2px); background-size: 50px 50px;"></div>
            </div>
            
            <div class="text-center relative z-10">
                <!-- 404 Number -->
                <div class="floating mb-8">
                    <h1 class="text-9xl md:text-[12rem] font-bold text-white opacity-20 leading-none">404</h1>
                </div>
                
                <!-- Error Icon -->
                <div class="mx-auto w-24 h-24 bg-white bg-opacity-20 rounded-full flex items-center justify-center mb-8">
                    <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6-4h6m2 5.291A7.962 7.962 0 0112 15c-2.34 0-4.5-1.01-6-2.709M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                    </svg>
                </div>
                
                <!-- Error Message -->
                <div class="mb-8">
                    <h2 class="text-4xl md:text-5xl font-bold text-white mb-4">Page Not Found</h2>
                    <p class="text-xl text-indigo-100 mb-2">Oops! The page you're looking for doesn't exist.</p>
                    <p class="text-indigo-200">It might have been moved, deleted, or you entered the wrong URL.</p>
                </div>
                
                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                    <a href="{{ url('/') }}" 
                       class="bg-white text-indigo-600 hover:bg-gray-100 px-8 py-3 rounded-xl font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                        <span class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                            Go Home
                        </span>
                    </a>
                    
                    <button onclick="history.back()" 
                            class="bg-transparent border-2 border-white text-white hover:bg-white hover:text-indigo-600 px-8 py-3 rounded-xl font-semibold transition-all duration-200">
                        <span class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Go Back
                        </span>
                    </button>
                </div>
                
                <!-- Additional Help -->
                <div class="mt-12 bg-white bg-opacity-10 backdrop-blur-sm rounded-xl p-6 max-w-md mx-auto">
                    <h3 class="text-white font-semibold mb-3">Need Help?</h3>
                    <p class="text-indigo-100 text-sm mb-4">
                        If you believe this is an error, please contact our support team.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-2 text-sm">
                        <span class="text-indigo-200">Error Code: 404</span>
                        <span class="text-indigo-200 hidden sm:inline">•</span>
                        <span class="text-indigo-200">{{ now()->format('Y-m-d H:i:s') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
