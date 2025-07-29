<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Member Dashboard</h2>
                <p class="text-gray-600 mt-1">Rental Barang & Equipment</p>
            </div>
            <div class="mt-4 sm:mt-0">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-purple-100 text-purple-800">
                    ✓ Member Access
                </span>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Welcome Section -->
            <div class="bg-gradient-to-r from-purple-600 to-purple-700 rounded-xl shadow-lg mb-6 md:mb-8">
                <div class="px-4 py-6 md:px-8 md:py-8">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 md:w-12 md:h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 md:w-6 md:h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-xl md:text-2xl font-semibold text-white">Selamat datang kembali!</h3>
                            <p class="text-purple-100">{{ Auth::user()->name }} • Member</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6 mb-6 md:mb-8">
                <!-- My Active Rentals -->
                <div class="bg-white p-4 md:p-6 rounded-xl shadow-sm border border-gray-200">
                    <div class="flex items-center">
                        <div class="p-2 md:p-3 bg-green-100 rounded-xl">
                            <svg class="w-5 h-5 md:w-6 md:h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-3 md:ml-4">
                            <div class="text-xl md:text-2xl font-bold text-gray-900">{{ $myActiveRentals ?? '0' }}</div>
                            <div class="text-xs md:text-sm text-gray-600">Rental Aktif</div>
                        </div>
                    </div>
                </div>

                <!-- Pending Approvals -->
                <div class="bg-white p-4 md:p-6 rounded-xl shadow-sm border border-gray-200">
                    <div class="flex items-center">
                        <div class="p-2 md:p-3 bg-yellow-100 rounded-xl">
                            <svg class="w-5 h-5 md:w-6 md:h-6 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="ml-3 md:ml-4">
                            <div class="text-xl md:text-2xl font-bold text-gray-900">{{ $myPendingRentals ?? '0' }}</div>
                            <div class="text-xs md:text-sm text-gray-600">Menunggu</div>
                        </div>
                    </div>
                </div>

                <!-- Total Rentals -->
                <div class="bg-white p-4 md:p-6 rounded-xl shadow-sm border border-gray-200">
                    <div class="flex items-center">
                        <div class="p-2 md:p-3 bg-blue-100 rounded-xl">
                            <svg class="w-5 h-5 md:w-6 md:h-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path>
                                <path fill-rule="evenodd" d="M4 5a2 2 0 012-2v1a1 1 0 102 0V3h6v1a1 1 0 102 0V3a2 2 0 012 2v6a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 3a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="ml-3 md:ml-4">
                            <div class="text-xl md:text-2xl font-bold text-gray-900">{{ $myTotalRentals ?? '0' }}</div>
                            <div class="text-xs md:text-sm text-gray-600">Total Rental</div>
                        </div>
                    </div>
                </div>

                <!-- Available Items -->
                <div class="bg-white p-4 md:p-6 rounded-xl shadow-sm border border-gray-200">
                    <div class="flex items-center">
                        <div class="p-2 md:p-3 bg-indigo-100 rounded-xl">
                            <svg class="w-5 h-5 md:w-6 md:h-6 text-indigo-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 2C5.477 2 2 5.477 2 10s3.477 8 8 8 8-3.477 8-8-3.477-8-8-8zM8 5a1 1 0 100 2h4a1 1 0 100-2H8zm-1 4a1 1 0 011-1h4a1 1 0 110 2H8a1 1 0 01-1-1zm1 3a1 1 0 100 2h4a1 1 0 100-2H8z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="ml-3 md:ml-4">
                            <div class="text-xl md:text-2xl font-bold text-gray-900">{{ $availableItems ?? '0' }}</div>
                            <div class="text-xs md:text-sm text-gray-600">Tersedia</div>
                        </div>
                    </div>
                </div>
            </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-yellow-500 rounded-full flex items-center justify-center">
                                    <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 2L3 7v11a1 1 0 001 1h3v-8h6v8h3a1 1 0 001-1V7l-7-5z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-500">Menunggu Approval</div>
                                <div class="text-2xl font-bold text-gray-900">{{ $myPendingRentals ?? '0' }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Rentals -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center">
                                    <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-500">Total Rental</div>
                                <div class="text-2xl font-bold text-gray-900">{{ $myTotalRentals ?? '0' }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Available Items -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-purple-500 rounded-full flex items-center justify-center">
                                    <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-500">Barang Tersedia</div>
                                <div class="text-2xl font-bold text-gray-900">{{ $availableItems ?? '0' }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-8">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-6">Quick Actions</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <a href="{{ route('member.barang.available') }}" class="p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                                    <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <div class="font-medium text-gray-900">Lihat Barang</div>
                                    <div class="text-sm text-gray-500">Browse barang yang tersedia</div>
                                </div>
                            </div>
                        </a>

                        <a href="{{ route('member.rental.create') }}" class="p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-4">
                                    <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <div class="font-medium text-gray-900">Ajukan Rental</div>
                                    <div class="text-sm text-gray-500">Buat permintaan rental baru</div>
                                </div>
                            </div>
                        </a>

                        <a href="{{ route('member.rental.history') }}" class="p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center mr-4">
                                    <svg class="w-5 h-5 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                                        <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <div class="font-medium text-gray-900">Riwayat Rental</div>
                                    <div class="text-sm text-gray-500">Lihat history rental Anda</div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Recent Rentals -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-6">Rental Terbaru</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode Rental</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Barang</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Pinjam</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Kembali</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($recentRentals as $rental)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $rental->kode_rental }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $rental->barang->nama_barang ?? 'N/A' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $rental->tanggal_pinjam ? \Carbon\Carbon::parse($rental->tanggal_pinjam)->format('d/m/Y') : '-' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $rental->tanggal_kembali_rencana ? \Carbon\Carbon::parse($rental->tanggal_kembali_rencana)->format('d/m/Y') : '-' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($rental->status === 'pending')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                    Menunggu Approval
                                                </span>
                                            @elseif($rental->status === 'approved')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                    Disetujui
                                                </span>
                                            @elseif($rental->status === 'active')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    Aktif
                                                </span>
                                            @elseif($rental->status === 'completed')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                    Selesai
                                                </span>
                                            @elseif($rental->status === 'rejected')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                    Ditolak
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="{{ route('member.rental.show', $rental) }}" class="text-indigo-600 hover:text-indigo-900">
                                                Detail
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                            Belum ada rental
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if(count($recentRentals) > 0)
                        <div class="mt-4 text-center">
                            <a href="{{ route('member.rental.history') }}" class="text-sm text-indigo-600 hover:text-indigo-900">
                                Lihat semua riwayat rental →
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
