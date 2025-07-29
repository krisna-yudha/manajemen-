<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between animate-fadeIn">
            <h2 class="text-3xl font-bold bg-gradient-to-r from-gray-900 to-gray-600 bg-clip-text text-transparent">
                {{ $title ?? 'Dashboard' }}
            </h2>
            <div class="mt-3 sm:mt-0 flex items-center space-x-4">
                @if(isset($actions))
                    {{ $actions }}
                @endif
                <div class="flex items-center space-x-2">
                    <div class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></div>
                    <span class="text-sm text-gray-600">{{ Auth::user()->name }}</span>
                    <span class="badge badge-info">{{ ucfirst(Auth::user()->role) }}</span>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if(isset($stats))
                <!-- Stats Overview -->
                @if(is_array($stats))
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                        @foreach($stats as $index => $stat)
                            <div class="stats-card animate-fadeIn" style="animation-delay: {{ $index * 0.1 }}s">
                                <div class="relative z-10">
                                    <div class="flex items-center justify-between mb-2">
                                        <div class="p-3 rounded-xl {{ $stat['color'] ?? 'bg-blue-100' }}">
                                            <svg class="w-6 h-6 {{ $stat['text_color'] ?? 'text-blue-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                {!! $stat['icon'] ?? '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>' !!}
                                            </svg>
                                        </div>
                                        @if(isset($stat['trend']))
                                            <div class="flex items-center text-sm {{ $stat['trend'] > 0 ? 'text-green-600' : ($stat['trend'] < 0 ? 'text-red-600' : 'text-gray-600') }}">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    @if($stat['trend'] > 0)
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                                    @elseif($stat['trend'] < 0)
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"></path>
                                                    @else
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                                    @endif
                                                </svg>
                                                {{ abs($stat['trend']) }}%
                                            </div>
                                        @endif
                                    </div>
                                    <div class="text-3xl font-bold text-gray-900 mb-1">{{ $stat['value'] }}</div>
                                    <div class="text-sm text-gray-600">{{ $stat['title'] ?? $stat['label'] }}</div>
                                    @if(isset($stat['subtitle']))
                                        <div class="text-xs text-gray-500 mt-1">{{ $stat['subtitle'] }}</div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="mb-8 animate-fadeIn">
                        {{ $stats }}
                    </div>
                @endif
            @endif

            @if(isset($breadcrumbs))
                <!-- Breadcrumbs -->
                @if(is_array($breadcrumbs))
                    <nav class="flex mb-8 animate-slideInLeft" aria-label="Breadcrumb">
                        <ol class="inline-flex items-center space-x-1 md:space-x-3">
                            @foreach($breadcrumbs as $index => $breadcrumb)
                                <li class="inline-flex items-center">
                                    @if($index > 0)
                                        <svg class="w-4 h-4 text-gray-400 mx-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                    @endif
                                    @if(isset($breadcrumb['url']) && !$loop->last)
                                        <a href="{{ $breadcrumb['url'] }}" class="text-gray-500 hover:text-gray-700 transition-colors duration-200">
                                            {{ $breadcrumb['label'] }}
                                        </a>
                                    @else
                                        <span class="text-gray-900 font-medium">{{ $breadcrumb['label'] }}</span>
                                    @endif
                                </li>
                            @endforeach
                        </ol>
                    </nav>
                @else
                    <div class="mb-8 animate-slideInLeft">
                        {{ $breadcrumbs }}
                    </div>
                @endif
            @endif

            <!-- Flash Messages -->
            @if(session('success'))
                <div class="mb-6 animate-scaleIn">
                    <div class="bg-gradient-to-r from-green-500 to-green-600 text-white p-4 rounded-xl shadow-lg flex items-center">
                        <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span class="font-medium">{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 animate-scaleIn">
                    <div class="bg-gradient-to-r from-red-500 to-red-600 text-white p-4 rounded-xl shadow-lg flex items-center">
                        <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        <span class="font-medium">{{ session('error') }}</span>
                    </div>
                </div>
            @endif

            @if(session('warning'))
                <div class="mb-6 animate-scaleIn">
                    <div class="bg-gradient-to-r from-yellow-500 to-orange-500 text-white p-4 rounded-xl shadow-lg flex items-center">
                        <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                        <span class="font-medium">{{ session('warning') }}</span>
                    </div>
                </div>
            @endif

            <!-- Main Content -->
            <div class="animate-fadeIn" style="animation-delay: 0.2s">
                {{ $slot }}
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // Auto hide flash messages
            setTimeout(() => {
                const flashMessages = document.querySelectorAll('[class*="bg-gradient-to-r from-green"], [class*="bg-gradient-to-r from-red"], [class*="bg-gradient-to-r from-yellow"]');
                flashMessages.forEach(msg => {
                    msg.style.transition = 'all 0.5s ease-out';
                    msg.style.opacity = '0';
                    msg.style.transform = 'translateY(-20px)';
                    setTimeout(() => msg.remove(), 500);
                });
            }, 5000);

            // Add loading states for buttons
            document.addEventListener('DOMContentLoaded', function() {
                const buttons = document.querySelectorAll('button[type="submit"], .btn-primary, .btn-secondary, .btn-success, .btn-danger, .btn-warning');
                
                buttons.forEach(button => {
                    button.addEventListener('click', function(e) {
                        if (this.form && this.form.checkValidity()) {
                            this.innerHTML = `
                                <div class="loading-dots">
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                </div>
                                <span class="ml-2">Processing...</span>
                            `;
                            this.disabled = true;
                        }
                    });
                });
            });

            // Smooth scroll for anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });
        </script>
    @endpush
</x-app-layout>
