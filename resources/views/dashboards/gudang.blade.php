<x-enhanced-layout>
    <x-slot name="title">Dashboard Gudang</x-slot>
    
    <!-- Enhanced Header -->
    <div class="mb-8">
        <div class="bg-gradient-to-r from-orange-600 to-orange-700 rounded-2xl shadow-xl p-6 md:p-8 text-white">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="p-3 bg-white bg-opacity-20 rounded-xl">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl md:text-3xl font-bold">Selamat datang, {{ Auth::user()->name }}!</h1>
                        <p class="text-orange-100 mt-1">Warehouse Management • Inventory Control</p>
                    </div>
                </div>
                <div class="hidden md:block">
                    <div class="text-right">
                        <p class="text-sm text-orange-200">{{ now()->format('l, d F Y') }}</p>
                        <p class="text-xs text-orange-300">{{ now()->format('H:i') }} WIB</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Overview -->
    <div class="mb-8">
        <h2 class="text-xl font-bold text-gray-900 mb-6">Statistik Inventory</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6">
            <!-- Total Items -->
            <div class="bg-white p-4 md:p-6 rounded-xl shadow-sm border border-gray-200 hover:shadow-lg transition-all duration-300 group">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-xl md:text-2xl font-bold text-blue-600">{{ \App\Models\Barang::count() }}</div>
                        <div class="text-xs md:text-sm text-gray-600">Total Items</div>
                    </div>
                    <div class="p-3 bg-blue-100 rounded-xl group-hover:bg-blue-200 transition-colors duration-300">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                    </div>
                </div>
                <div class="mt-3 text-xs text-blue-600 bg-blue-50 px-2 py-1 rounded-full inline-block">
                    Seluruh barang di gudang
                </div>
            </div>

            <!-- Available Stock -->
            <div class="bg-white p-4 md:p-6 rounded-xl shadow-sm border border-gray-200 hover:shadow-lg transition-all duration-300 group">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-xl md:text-2xl font-bold text-green-600">{{ \App\Models\Barang::where('stok', '>', 0)->count() }}</div>
                        <div class="text-xs md:text-sm text-gray-600">Available</div>
                    </div>
                    <div class="p-3 bg-green-100 rounded-xl group-hover:bg-green-200 transition-colors duration-300">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-3 text-xs text-green-600 bg-green-50 px-2 py-1 rounded-full inline-block">
                    Siap untuk rental
                </div>
            </div>

            <!-- Out of Stock -->
            <div class="bg-white p-4 md:p-6 rounded-xl shadow-sm border border-gray-200 hover:shadow-lg transition-all duration-300 group">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-xl md:text-2xl font-bold text-red-600">{{ \App\Models\Barang::where('stok', 0)->count() }}</div>
                        <div class="text-xs md:text-sm text-gray-600">Out of Stock</div>
                    </div>
                    <div class="p-3 bg-red-100 rounded-xl group-hover:bg-red-200 transition-colors duration-300">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-3 text-xs text-red-600 bg-red-50 px-2 py-1 rounded-full inline-block">
                    Perlu restocking
                </div>
            </div>

            <!-- Pending Rentals -->
            <div class="bg-white p-4 md:p-6 rounded-xl shadow-sm border border-gray-200 hover:shadow-lg transition-all duration-300 group">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-xl md:text-2xl font-bold text-yellow-600">{{ \App\Models\Rental::where('status', 'pending')->count() }}</div>
                        <div class="text-xs md:text-sm text-gray-600">Pending</div>
                    </div>
                    <div class="p-3 bg-yellow-100 rounded-xl group-hover:bg-yellow-200 transition-colors duration-300">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-3 text-xs text-yellow-600 bg-yellow-50 px-2 py-1 rounded-full inline-block">
                    Menunggu persetujuan
                </div>
            </div>
        </div>
    </div>
    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Quick Actions -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 lg:p-8">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-bold text-gray-900">Quick Actions</h3>
                <div class="p-2 bg-orange-100 rounded-lg">
                    <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
            </div>
            
            <div class="space-y-3">
                <a href="{{ route('barang.create') }}" class="flex items-center p-4 rounded-xl bg-gradient-to-r from-blue-50 to-blue-100 hover:from-blue-100 hover:to-blue-200 transition-all duration-300 group">
                    <div class="p-3 bg-blue-500 rounded-xl text-white group-hover:bg-blue-600 transition-colors duration-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                    </div>
                    <div class="ml-4 flex-1">
                        <div class="font-semibold text-gray-900">Add New Item</div>
                        <div class="text-sm text-gray-600">Tambah barang baru ke inventory</div>
                    </div>
                    <svg class="w-5 h-5 text-gray-400 group-hover:text-blue-600 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>

                <a href="{{ route('barang.index') }}" class="flex items-center p-4 rounded-xl bg-gradient-to-r from-green-50 to-green-100 hover:from-green-100 hover:to-green-200 transition-all duration-300 group">
                    <div class="p-3 bg-green-500 rounded-xl text-white group-hover:bg-green-600 transition-colors duration-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <div class="ml-4 flex-1">
                        <div class="font-semibold text-gray-900">Manage Stock</div>
                        <div class="text-sm text-gray-600">Kelola stok dan update inventory</div>
                    </div>
                    <svg class="w-5 h-5 text-gray-400 group-hover:text-green-600 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>

                <a href="{{ route('rental.pending.gudang') }}" class="flex items-center p-4 rounded-xl bg-gradient-to-r from-yellow-50 to-yellow-100 hover:from-yellow-100 hover:to-yellow-200 transition-all duration-300 group">
                    <div class="p-3 bg-yellow-500 rounded-xl text-white group-hover:bg-yellow-600 transition-colors duration-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ml-4 flex-1">
                        <div class="font-semibold text-gray-900">Approve Rentals</div>
                        <div class="text-sm text-gray-600">Review dan setujui rental request</div>
                    </div>
                    <svg class="w-5 h-5 text-gray-400 group-hover:text-yellow-600 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>

                <a href="{{ route('rental.index') }}" class="flex items-center p-4 rounded-xl bg-gradient-to-r from-purple-50 to-purple-100 hover:from-purple-100 hover:to-purple-200 transition-all duration-300 group">
                    <div class="p-3 bg-purple-500 rounded-xl text-white group-hover:bg-purple-600 transition-colors duration-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <div class="ml-4 flex-1">
                        <div class="font-semibold text-gray-900">All Rentals</div>
                        <div class="text-sm text-gray-600">Lihat semua data rental</div>
                    </div>
                    <svg class="w-5 h-5 text-gray-400 group-hover:text-purple-600 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 lg:p-8">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-bold text-gray-900">Recent Activity</h3>
                <div class="p-2 bg-blue-100 rounded-lg">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            
            <div class="space-y-3 max-h-80 overflow-y-auto">
                @forelse(\App\Models\Rental::with(['user', 'barang'])->latest()->take(8)->get() as $rental)
                    <div class="flex items-center p-3 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors duration-200">
                        <div class="w-2 h-2 bg-orange-500 rounded-full mr-3 flex-shrink-0"></div>
                        <div class="flex-1 min-w-0">
                            <div class="text-sm font-medium text-gray-900 truncate">
                                {{ $rental->barang->nama_barang }}
                            </div>
                            <div class="flex items-center mt-1">
                                <span class="text-xs text-gray-600 mr-2">{{ $rental->user->name }}</span>
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium
                                    @if($rental->status === 'pending') bg-yellow-100 text-yellow-800
                                    @elseif($rental->status === 'approved') bg-green-100 text-green-800
                                    @elseif($rental->status === 'rejected') bg-red-100 text-red-800
                                    @else bg-gray-100 text-gray-800 @endif">
                                    {{ ucfirst($rental->status) }}
                                </span>
                            </div>
                        </div>
                        <div class="text-xs text-gray-500 flex-shrink-0">
                            {{ $rental->created_at->diffForHumans() }}
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8 text-gray-500">
                        <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                        <p class="text-sm">No recent activity</p>
                        <p class="text-xs text-gray-400 mt-1">Activity will appear here as rentals are processed</p>
                    </div>
                @endforelse
            </div>
            
            @if(\App\Models\Rental::count() > 8)
            <div class="mt-4 text-center">
                <a href="#" class="text-sm text-blue-600 hover:text-blue-700 font-medium">View all activity →</a>
            </div>
            @endif
        </div>
    </div>

    <!-- Warehouse Permissions Info -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 lg:p-8">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-xl font-bold text-gray-900">Warehouse Access & Permissions</h3>
            <div class="p-2 bg-green-100 rounded-lg">
                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                </svg>
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="text-center p-6 bg-gradient-to-br from-orange-50 to-orange-100 rounded-xl border border-orange-200">
                <div class="w-14 h-14 bg-orange-500 rounded-xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                </div>
                <div class="text-lg font-bold text-orange-800 mb-2">Inventory Management</div>
                <div class="text-sm text-orange-700">Kelola stock, tambah barang baru, dan update inventory system</div>
            </div>

            <div class="text-center p-6 bg-gradient-to-br from-green-50 to-green-100 rounded-xl border border-green-200">
                <div class="w-14 h-14 bg-green-500 rounded-xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="text-lg font-bold text-green-800 mb-2">Rental Approval</div>
                <div class="text-sm text-green-700">Approve atau reject rental requests dari member</div>
            </div>

            <div class="text-center p-6 bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl border border-blue-200">
                <div class="w-14 h-14 bg-blue-500 rounded-xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                </div>
                <div class="text-lg font-bold text-blue-800 mb-2">Stock Monitoring</div>
                <div class="text-sm text-blue-700">Monitor stock levels, movements, dan maintenance</div>
            </div>
        </div>
    </div>
</x-enhanced-layout>
