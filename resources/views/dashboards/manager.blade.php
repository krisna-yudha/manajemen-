<x-enhanced-layout>
    <x-slot name="header">
        <div class="bg-gradient-to-r from-blue-600 via-blue-700 to-indigo-800 text-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
                    <div>
                        <h1 class="text-2xl md:text-3xl font-bold">Dashboard Manager</h1>
                        <p class="text-blue-100 mt-1">Executive Overview • System Analytics • Management Control</p>
                    </div>
                    <div class="hidden md:block">
                        <div class="text-right">
                            <p class="text-sm text-blue-200">{{ now()->format('l, d F Y') }}</p>
                            <p class="text-xs text-blue-300">{{ now()->format('H:i') }} WIB</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Welcome Section -->
            <div class="mb-8">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-xl font-bold text-gray-900">Selamat datang, {{ Auth::user()->name }}!</h2>
                            <p class="text-gray-600 mt-1">Berikut adalah ringkasan sistem management inventory dan rental</p>
                        </div>
                        <div class="hidden md:block">
                            <div class="flex items-center space-x-4">
                                <div class="text-center">
                                    <div class="text-2xl font-bold text-blue-600">{{ App\Models\User::count() }}</div>
                                    <div class="text-xs text-gray-500">Total Users</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-2xl font-bold text-green-600">{{ App\Models\Barang::count() }}</div>
                                    <div class="text-xs text-gray-500">Items</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-2xl font-bold text-purple-600">{{ App\Models\Rental::count() }}</div>
                                    <div class="text-xs text-gray-500">Rentals</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Key Statistics Grid -->
            <div class="mb-8">
                <h3 class="text-xl font-bold text-gray-900 mb-6">Key Performance Indicators</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4 md:gap-6">
                    
                    <!-- Active Rentals -->
                    <div class="bg-gradient-to-br from-blue-500 to-blue-600 p-6 rounded-xl text-white shadow-sm hover:shadow-lg transition-all duration-300">
                        <div class="flex items-center justify-between">
                            <div>
                                <div class="text-2xl font-bold">{{ App\Models\Rental::where('status', 'ongoing')->count() }}</div>
                                <div class="text-xs opacity-90">Active Rentals</div>
                            </div>
                            <div class="p-3 bg-white bg-opacity-20 rounded-xl">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Pending Approvals -->
                    <div class="bg-gradient-to-br from-yellow-500 to-yellow-600 p-6 rounded-xl text-white shadow-sm hover:shadow-lg transition-all duration-300">
                        <div class="flex items-center justify-between">
                            <div>
                                <div class="text-2xl font-bold">{{ App\Models\Rental::where('status', 'pending')->count() }}</div>
                                <div class="text-xs opacity-90">Pending</div>
                            </div>
                            <div class="p-3 bg-white bg-opacity-20 rounded-xl">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Available Items -->
                    <div class="bg-gradient-to-br from-green-500 to-green-600 p-6 rounded-xl text-white shadow-sm hover:shadow-lg transition-all duration-300">
                        <div class="flex items-center justify-between">
                            <div>
                                <div class="text-2xl font-bold">{{ App\Models\Barang::where('status', 'tersedia')->where('kondisi', 'baik')->count() }}</div>
                                <div class="text-xs opacity-90">Available</div>
                            </div>
                            <div class="p-3 bg-white bg-opacity-20 rounded-xl">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Out of Stock -->
                    <div class="bg-gradient-to-br from-red-500 to-red-600 p-6 rounded-xl text-white shadow-sm hover:shadow-lg transition-all duration-300">
                        <div class="flex items-center justify-between">
                            <div>
                                <div class="text-2xl font-bold">{{ App\Models\Barang::where('stok', 0)->count() }}</div>
                                <div class="text-xs opacity-90">Out of Stock</div>
                            </div>
                            <div class="p-3 bg-white bg-opacity-20 rounded-xl">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Maintenance Items -->
                    <div class="bg-gradient-to-br from-orange-500 to-orange-600 p-6 rounded-xl text-white shadow-sm hover:shadow-lg transition-all duration-300">
                        <div class="flex items-center justify-between">
                            <div>
                                <div class="text-2xl font-bold">{{ App\Models\Barang::where('status', 'maintenance')->count() }}</div>
                                <div class="text-xs opacity-90">Maintenance</div>
                            </div>
                            <div class="p-3 bg-white bg-opacity-20 rounded-xl">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Total Staff -->
                    <div class="bg-gradient-to-br from-indigo-500 to-indigo-600 p-6 rounded-xl text-white shadow-sm hover:shadow-lg transition-all duration-300">
                        <div class="flex items-center justify-between">
                            <div>
                                <div class="text-2xl font-bold">{{ App\Models\User::whereIn('role', ['manager', 'gudang'])->count() }}</div>
                                <div class="text-xs opacity-90">Staff</div>
                            </div>
                            <div class="p-3 bg-white bg-opacity-20 rounded-xl">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Dashboard Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
                
                <!-- Management Actions -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 h-full">
                        <h3 class="text-lg font-semibold text-gray-900 mb-6 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                            </svg>
                            Executive Actions
                        </h3>
                        <div class="space-y-4">
                            <a href="{{ route('manager.users') }}" class="flex items-center p-4 rounded-xl bg-gradient-to-r from-blue-50 to-blue-100 hover:from-blue-100 hover:to-blue-200 transition-all duration-300 group">
                                <div class="w-12 h-12 bg-blue-600 rounded-xl flex items-center justify-center mr-4 group-hover:bg-blue-700 transition-colors">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <div class="font-semibold text-gray-900">Manage Users & Roles</div>
                                    <div class="text-sm text-gray-600">Control user permissions dan roles</div>
                                </div>
                                <svg class="w-5 h-5 text-gray-400 group-hover:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>

                            <a href="{{ route('manager.report.barang') }}" class="flex items-center p-4 rounded-xl bg-gradient-to-r from-green-50 to-green-100 hover:from-green-100 hover:to-green-200 transition-all duration-300 group">
                                <div class="w-12 h-12 bg-green-600 rounded-xl flex items-center justify-center mr-4 group-hover:bg-green-700 transition-colors">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <div class="font-semibold text-gray-900">Analytics & Reports</div>
                                    <div class="text-sm text-gray-600">Detailed business intelligence</div>
                                </div>
                                <svg class="w-5 h-5 text-gray-400 group-hover:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>

                            <a href="{{ route('rental.index') }}" class="flex items-center p-4 rounded-xl bg-gradient-to-r from-purple-50 to-purple-100 hover:from-purple-100 hover:to-purple-200 transition-all duration-300 group">
                                <div class="w-12 h-12 bg-purple-600 rounded-xl flex items-center justify-center mr-4 group-hover:bg-purple-700 transition-colors">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <div class="font-semibold text-gray-900">All Rentals</div>
                                    <div class="text-sm text-gray-600">Monitor rental activities</div>
                                </div>
                                <svg class="w-5 h-5 text-gray-400 group-hover:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>

                            <a href="{{ route('barang.index') }}" class="flex items-center p-4 rounded-xl bg-gradient-to-r from-orange-50 to-orange-100 hover:from-orange-100 hover:to-orange-200 transition-all duration-300 group">
                                <div class="w-12 h-12 bg-orange-600 rounded-xl flex items-center justify-center mr-4 group-hover:bg-orange-700 transition-colors">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <div class="font-semibold text-gray-900">Inventory Overview</div>
                                    <div class="text-sm text-gray-600">Monitor stock levels</div>
                                </div>
                                <svg class="w-5 h-5 text-gray-400 group-hover:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- System Status & Recent Activity -->
                <div class="lg:col-span-2">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 h-full">
                        
                        <!-- User Roles Distribution -->
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-6 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                User Distribution
                            </h3>
                            <div class="space-y-4">
                                <div class="flex items-center justify-between p-3 bg-blue-50 rounded-lg">
                                    <div class="flex items-center">
                                        <div class="w-3 h-3 bg-blue-600 rounded-full mr-3"></div>
                                        <span class="text-sm font-medium text-gray-900">Managers</span>
                                    </div>
                                    <span class="text-lg font-bold text-blue-600">{{ App\Models\User::where('role', 'manager')->count() }}</span>
                                </div>
                                <div class="flex items-center justify-between p-3 bg-green-50 rounded-lg">
                                    <div class="flex items-center">
                                        <div class="w-3 h-3 bg-green-600 rounded-full mr-3"></div>
                                        <span class="text-sm font-medium text-gray-900">Staff Gudang</span>
                                    </div>
                                    <span class="text-lg font-bold text-green-600">{{ App\Models\User::where('role', 'gudang')->count() }}</span>
                                </div>
                                <div class="flex items-center justify-between p-3 bg-purple-50 rounded-lg">
                                    <div class="flex items-center">
                                        <div class="w-3 h-3 bg-purple-600 rounded-full mr-3"></div>
                                        <span class="text-sm font-medium text-gray-900">Members</span>
                                    </div>
                                    <span class="text-lg font-bold text-purple-600">{{ App\Models\User::where('role', 'member')->count() }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Recent System Activity -->
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-6 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Recent Activity
                            </h3>
                            <div class="space-y-3 max-h-64 overflow-y-auto">
                                @forelse(App\Models\Rental::with(['user', 'barang'])->latest()->take(6)->get() as $rental)
                                    <div class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                                        <div class="w-2 h-2 
                                            @if($rental->status === 'pending') bg-yellow-500
                                            @elseif($rental->status === 'approved') bg-green-500
                                            @elseif($rental->status === 'ongoing') bg-blue-500
                                            @elseif($rental->status === 'returned') bg-gray-500
                                            @else bg-red-500 @endif
                                            rounded-full mr-3 flex-shrink-0"></div>
                                        <div class="flex-1 min-w-0">
                                            <div class="text-sm font-medium text-gray-900 truncate">
                                                {{ $rental->barang->nama_barang }}
                                            </div>
                                            <div class="flex items-center mt-1">
                                                <span class="text-xs text-gray-600 mr-2">{{ $rental->user->name }}</span>
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium
                                                    @if($rental->status === 'pending') bg-yellow-100 text-yellow-800
                                                    @elseif($rental->status === 'approved') bg-green-100 text-green-800
                                                    @elseif($rental->status === 'ongoing') bg-blue-100 text-blue-800
                                                    @elseif($rental->status === 'returned') bg-gray-100 text-gray-800
                                                    @else bg-red-100 text-red-800 @endif">
                                                    {{ ucfirst($rental->status) }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="text-xs text-gray-500 flex-shrink-0">
                                            {{ $rental->created_at->diffForHumans() }}
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center py-6 text-gray-500">
                                        <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                        </svg>
                                        <p class="text-sm">No recent activity</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Inventory Status Overview -->
            <div class="mb-8">
                <h3 class="text-xl font-bold text-gray-900 mb-6">Inventory Health Status</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    
                    <!-- Items by Category -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <h4 class="text-lg font-semibold text-gray-900 mb-4">Items by Category</h4>
                        <div class="space-y-3">
                            @php
                                $categories = App\Models\Barang::selectRaw('kategori, COUNT(*) as total')
                                    ->groupBy('kategori')
                                    ->orderBy('total', 'desc')
                                    ->get();
                            @endphp
                            @forelse($categories as $category)
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-600">{{ $category->kategori ?: 'Uncategorized' }}</span>
                                    <span class="text-sm font-semibold text-gray-900">{{ $category->total }}</span>
                                </div>
                            @empty
                                <p class="text-sm text-gray-500">No categories found</p>
                            @endforelse
                        </div>
                    </div>

                    <!-- Stock Alerts -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <h4 class="text-lg font-semibold text-gray-900 mb-4">Stock Alerts</h4>
                        <div class="space-y-3">
                            @php
                                $lowStockItems = App\Models\Barang::where('stok', '<=', 5)->where('stok', '>', 0)->take(5)->get();
                                $outOfStockItems = App\Models\Barang::where('stok', 0)->count();
                            @endphp
                            <div class="flex items-center justify-between p-3 bg-red-50 rounded-lg">
                                <span class="text-sm text-red-700">Out of Stock</span>
                                <span class="text-sm font-bold text-red-600">{{ $outOfStockItems }}</span>
                            </div>
                            <div class="flex items-center justify-between p-3 bg-yellow-50 rounded-lg">
                                <span class="text-sm text-yellow-700">Low Stock (≤5)</span>
                                <span class="text-sm font-bold text-yellow-600">{{ $lowStockItems->count() }}</span>
                            </div>
                            @if($lowStockItems->count() > 0)
                                <div class="mt-3 pt-3 border-t border-gray-200">
                                    <p class="text-xs text-gray-500 mb-2">Items need restocking:</p>
                                    @foreach($lowStockItems as $item)
                                        <div class="text-xs text-gray-600">• {{ $item->nama_barang }} ({{ $item->stok }} left)</div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- System Health -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <h4 class="text-lg font-semibold text-gray-900 mb-4">System Health</h4>
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">Database Status</span>
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    ● Healthy
                                </span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">Active Users</span>
                                <span class="text-sm font-semibold text-gray-900">{{ App\Models\User::count() }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">Total Transactions</span>
                                <span class="text-sm font-semibold text-gray-900">{{ App\Models\Rental::count() }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">System Uptime</span>
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    99.9%
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer Info -->
            <div class="text-center py-6 text-gray-500 border-t border-gray-200">
                <p class="text-sm">Management System Dashboard • Last updated: {{ now()->format('d/m/Y H:i') }}</p>
            </div>
        </div>
    </div>
</x-enhanced-layout>
