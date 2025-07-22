<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Dashboard Member</h2>
                <p class="text-gray-600 mt-1">Rental & Request Management</p>
            </div>
            <div class="mt-4 sm:mt-0">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-indigo-100 text-indigo-800">
                    ✓ Member Access
                </span>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Welcome Section -->
            <div class="bg-gradient-to-r from-indigo-600 to-indigo-700 rounded-xl shadow-lg mb-8">
                <div class="px-6 py-8 sm:px-8">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-xl font-semibold text-white">Selamat datang, {{ Auth::user()->name }}!</h3>
                            <p class="text-indigo-100">Member • Rental Services</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistics Overview -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <div class="text-2xl font-bold text-gray-900">{{ \App\Models\Barang::where('stok', '>', 0)->count() }}</div>
                            <div class="text-sm text-gray-600">Available Items</div>
                        </div>
                    </div>
                    <div class="mt-4">
                        <div class="text-sm text-blue-600">
                            Barang siap disewa
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <div class="text-2xl font-bold text-gray-900">{{ \App\Models\Rental::where('user_id', Auth::id())->where('status', 'approved')->count() }}</div>
                            <div class="text-sm text-gray-600">Approved Rentals</div>
                        </div>
                    </div>
                    <div class="mt-4">
                        <div class="text-sm text-green-600">
                            Rental disetujui
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <div class="text-2xl font-bold text-gray-900">{{ \App\Models\Rental::where('user_id', Auth::id())->where('status', 'pending')->count() }}</div>
                            <div class="text-sm text-gray-600">Pending Requests</div>
                        </div>
                    </div>
                    <div class="mt-4">
                        <div class="text-sm text-yellow-600">
                            Menunggu approval
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <div class="text-2xl font-bold text-gray-900">{{ \App\Models\Rental::where('user_id', Auth::id())->count() }}</div>
                            <div class="text-sm text-gray-600">Total Rentals</div>
                        </div>
                    </div>
                    <div class="mt-4">
                        <div class="text-sm text-purple-600">
                            Semua rental Anda
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Actions Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                <!-- Quick Actions -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6">Quick Actions</h3>
                    <div class="space-y-4">
                        <a href="{{ route('barang.available') }}" class="flex items-center p-4 rounded-lg bg-gray-50 hover:bg-gray-100 transition-colors group">
                            <div class="w-12 h-12 bg-blue-100 group-hover:bg-blue-200 rounded-xl flex items-center justify-center mr-4 transition-colors">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <div class="font-medium text-gray-900">View Available Items</div>
                                <div class="text-sm text-gray-600">Browse barang yang tersedia untuk disewa</div>
                            </div>
                            <svg class="w-5 h-5 text-gray-400 group-hover:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>

                        <a href="{{ route('rental.create') }}" class="flex items-center p-4 rounded-lg bg-gray-50 hover:bg-gray-100 transition-colors group">
                            <div class="w-12 h-12 bg-green-100 group-hover:bg-green-200 rounded-xl flex items-center justify-center mr-4 transition-colors">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <div class="font-medium text-gray-900">Submit Rental Request</div>
                                <div class="text-sm text-gray-600">Ajukan permintaan sewa barang</div>
                            </div>
                            <svg class="w-5 h-5 text-gray-400 group-hover:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>

                        <a href="{{ route('rental.index') }}" class="flex items-center p-4 rounded-lg bg-gray-50 hover:bg-gray-100 transition-colors group">
                            <div class="w-12 h-12 bg-purple-100 group-hover:bg-purple-200 rounded-xl flex items-center justify-center mr-4 transition-colors">
                                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <div class="font-medium text-gray-900">View My Rentals</div>
                                <div class="text-sm text-gray-600">Lihat history dan status rental Anda</div>
                            </div>
                            <svg class="w-5 h-5 text-gray-400 group-hover:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>

                        <a href="{{ route('rental.history') }}" class="flex items-center p-4 rounded-lg bg-gray-50 hover:bg-gray-100 transition-colors group">
                            <div class="w-12 h-12 bg-gray-100 group-hover:bg-gray-200 rounded-xl flex items-center justify-center mr-4 transition-colors">
                                <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <div class="font-medium text-gray-900">Rental History</div>
                                <div class="text-sm text-gray-600">Riwayat lengkap aktivitas rental</div>
                            </div>
                            <svg class="w-5 h-5 text-gray-400 group-hover:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- My Recent Rentals -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6">My Recent Rentals</h3>
                    <div class="space-y-4">
                        @forelse(\App\Models\Rental::where('user_id', Auth::id())->with('barang')->latest()->take(5)->get() as $rental)
                            <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                                <div class="w-2 h-2 
                                    @if($rental->status === 'pending') bg-yellow-500
                                    @elseif($rental->status === 'approved') bg-green-500
                                    @elseif($rental->status === 'rejected') bg-red-500
                                    @else bg-gray-500 @endif
                                    rounded-full mr-3"></div>
                                <div class="flex-1">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $rental->barang->nama_barang }}
                                    </div>
                                    <div class="text-xs text-gray-600">
                                        {{ $rental->tanggal_mulai }} - {{ $rental->tanggal_selesai }} • 
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                            @if($rental->status === 'pending') bg-yellow-100 text-yellow-800
                                            @elseif($rental->status === 'approved') bg-green-100 text-green-800
                                            @elseif($rental->status === 'rejected') bg-red-100 text-red-800
                                            @else bg-gray-100 text-gray-800 @endif">
                                            {{ ucfirst($rental->status) }}
                                        </span>
                                    </div>
                                </div>
                                <div class="text-xs text-gray-500">
                                    {{ $rental->created_at->diffForHumans() }}
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-4 text-gray-500">
                                <svg class="w-12 h-12 mx-auto text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                                <p class="text-sm">No rentals yet</p>
                                <p class="text-xs text-gray-400">Start by browsing available items</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Member Features -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">Member Features & Access</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="text-center p-4 bg-indigo-50 rounded-lg">
                        <div class="w-12 h-12 bg-indigo-100 rounded-xl flex items-center justify-center mx-auto mb-3">
                            <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </div>
                        <div class="text-lg font-semibold text-indigo-800">Browse Items</div>
                        <div class="text-sm text-indigo-600">Lihat semua barang yang tersedia untuk disewa</div>
                    </div>

                    <div class="text-center p-4 bg-green-50 rounded-lg">
                        <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center mx-auto mb-3">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                        </div>
                        <div class="text-lg font-semibold text-green-800">Submit Requests</div>
                        <div class="text-sm text-green-600">Ajukan permintaan rental dengan mudah</div>
                    </div>

                    <div class="text-center p-4 bg-blue-50 rounded-lg">
                        <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center mx-auto mb-3">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2-2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                        </div>
                        <div class="text-lg font-semibold text-blue-800">Track History</div>
                        <div class="text-sm text-blue-600">Monitor status dan riwayat rental</div>
                    </div>
                </div>

                <div class="mt-6 p-4 bg-yellow-50 rounded-lg">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <svg class="w-5 h-5 text-yellow-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h4 class="text-sm font-medium text-yellow-800">Member Guidelines</h4>
                            <div class="mt-1 text-sm text-yellow-700">
                                <ul class="list-disc list-inside space-y-1">
                                    <li>Pastikan untuk mengecek ketersediaan barang sebelum mengajukan rental</li>
                                    <li>Rental request akan diproses oleh staff gudang dalam 1-2 hari kerja</li>
                                    <li>Hubungi manager untuk pertanyaan atau bantuan lebih lanjut</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
