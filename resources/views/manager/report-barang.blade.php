<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Report Barang & Rental - Analytics Dashboard
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Summary Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-6 mb-8">
                <!-- Barang Keluar -->
                <div class="bg-gradient-to-r from-red-500 to-red-600 overflow-hidden shadow-sm sm:rounded-lg text-white">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium opacity-90">Barang Keluar</div>
                                <div class="text-3xl font-bold">{{ $trafikData['barangKeluar'] }}</div>
                                <div class="text-xs opacity-75">Total yang dirental</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Barang Masuk -->
                <div class="bg-gradient-to-r from-blue-500 to-blue-600 overflow-hidden shadow-sm sm:rounded-lg text-white">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium opacity-90">Barang Masuk</div>
                                <div class="text-3xl font-bold">{{ $trafikData['barangMasuk'] }}</div>
                                <div class="text-xs opacity-75">Total yang dikembalikan</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sedang Rental -->
                <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 overflow-hidden shadow-sm sm:rounded-lg text-white">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 2L3 7v11a1 1 0 001 1h3v-8h6v8h3a1 1 0 001-1V7l-7-5z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium opacity-90">Sedang Rental</div>
                                <div class="text-3xl font-bold">{{ $trafikData['sedangRental'] }}</div>
                                <div class="text-xs opacity-75">Aktif saat ini</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Rental -->
                <div class="bg-gradient-to-r from-green-500 to-green-600 overflow-hidden shadow-sm sm:rounded-lg text-white">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium opacity-90">Total Rental</div>
                                <div class="text-3xl font-bold">{{ $trafikData['totalRental'] }}</div>
                                <div class="text-xs opacity-75">Sepanjang masa</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Maintenance -->
                <div class="bg-gradient-to-r from-orange-500 to-orange-600 overflow-hidden shadow-sm sm:rounded-lg text-white">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium opacity-90">Maintenance</div>
                                <div class="text-3xl font-bold">{{ $trafikData['maintenance'] }}</div>
                                <div class="text-xs opacity-75">Perlu perawatan</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Rusak -->
                <div class="bg-gradient-to-r from-purple-500 to-purple-600 overflow-hidden shadow-sm sm:rounded-lg text-white">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium opacity-90">Rusak</div>
                                <div class="text-3xl font-bold">{{ $trafikData['rusak'] }}</div>
                                <div class="text-xs opacity-75">Kondisi rusak</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts Row 1 -->
            <div class="grid grid-cols-1 gap-6 mb-8">
                <!-- Rental Trend Chart -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-6">Trafik Rental (6 Bulan Terakhir)</h3>
                        <div class="relative" style="height: 300px;">
                            <canvas id="rentalTrendChart"></canvas>
                        </div>
                    </div>
                </div>

                {{-- <!-- Status Rental Pie Chart -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-6">Status Rental</h3>
                        <div class="relative" style="height: 300px;">
                            <canvas id="statusRentalChart"></canvas>
                        </div>
                    </div>
                </div> --}}
            </div>

            <!-- Charts Row 2 -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                <!-- User Stats -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-6">Staff & Member Aktif</h3>
                        <div class="relative" style="height: 300px;">
                            <canvas id="userStatsChart"></canvas>
                        </div>
                        <div class="mt-4 grid grid-cols-2 gap-4">
                            <div class="text-center">
                                <div class="text-2xl font-bold text-blue-600">{{ $userStats['gudang'] }}</div>
                                <div class="text-sm text-gray-500">Staff Gudang</div>
                            </div>
                            <div class="text-center">
                                <div class="text-2xl font-bold text-green-600">{{ $userStats['member'] }}</div>
                                <div class="text-sm text-gray-500">Member Aktif</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Kategori Barang -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-6">Distribusi Barang per Kategori</h3>
                        <div class="relative" style="height: 300px;">
                            <canvas id="kategoriChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detailed Summary Table -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-6">Ringkasan Detail per Kategori</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tersedia</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Maintenance</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rusak</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Condition %</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($kategoriData as $kategori)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $kategori->kategori ?: 'Tidak Berkategori' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $kategori->total }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-green-600">{{ $kategori->tersedia }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-yellow-600">{{ $kategori->maintenance }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-red-600">{{ $kategori->rusak }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            @php
                                                $goodPercentage = $kategori->total > 0 ? ($kategori->tersedia / $kategori->total) * 100 : 0;
                                                $goodPercentage = max(0, min(100, $goodPercentage));
                                            @endphp
                                            <div class="flex items-center">
                                                <div class="flex-1 bg-gray-200 rounded-full h-2 mr-3">
                                                    <div class="bg-green-600 h-2 rounded-full" style="width: {{ number_format($goodPercentage, 1) }}%"></div>
                                                </div>
                                                <span class="text-xs">{{ round($goodPercentage, 1) }}%</span>
                                            </div>
                                            <div class="text-xs text-gray-400 mt-1">Good Condition</div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                            Belum ada data kategori
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pass data to JavaScript -->
    <script>
        window.managerReportData = {!! $chartDataJson !!};
    </script>
</x-app-layout>
