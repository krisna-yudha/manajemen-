<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detail Rental - {{ $rental->kode_rental }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Success Message -->
            @if(session('success'))
                <div class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Rental Status Card -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-medium text-gray-900">Status Rental</h3>
                        <div class="flex items-center space-x-3">
                            @if($rental->status === 'pending')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                    <div class="w-2 h-2 bg-yellow-400 rounded-full mr-2"></div>
                                    Menunggu Approval
                                </span>
                            @elseif($rental->status === 'approved')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                    <div class="w-2 h-2 bg-blue-400 rounded-full mr-2"></div>
                                    Disetujui
                                </span>
                            @elseif($rental->status === 'active')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                    <div class="w-2 h-2 bg-green-400 rounded-full mr-2"></div>
                                    Sedang Dipinjam
                                </span>
                            @elseif($rental->status === 'completed')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                    <div class="w-2 h-2 bg-gray-400 rounded-full mr-2"></div>
                                    Selesai
                                </span>
                            @elseif($rental->status === 'rejected')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                    <div class="w-2 h-2 bg-red-400 rounded-full mr-2"></div>
                                    Ditolak
                                </span>
                            @endif
                            <span class="text-sm text-gray-500">{{ $rental->kode_rental }}</span>
                        </div>
                    </div>

                    <!-- Progress Timeline -->
                    <div class="relative">
                        <div class="flex items-center justify-between">
                            <!-- Step 1: Submitted -->
                            <div class="flex flex-col items-center">
                                <div class="w-8 h-8 rounded-full bg-green-500 flex items-center justify-center mb-2">
                                    <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <div class="text-xs text-center">
                                    <div class="font-medium text-gray-900">Diajukan</div>
                                    <div class="text-gray-500">{{ $rental->created_at->format('d/m/Y H:i') }}</div>
                                </div>
                            </div>

                            <!-- Progress Line -->
                            <div class="flex-1 h-1 mx-4 {{ in_array($rental->status, ['approved', 'active', 'completed']) ? 'bg-green-500' : 'bg-gray-300' }}"></div>

                            <!-- Step 2: Approved -->
                            <div class="flex flex-col items-center">
                                <div class="w-8 h-8 rounded-full {{ in_array($rental->status, ['approved', 'active', 'completed']) ? 'bg-green-500' : ($rental->status === 'rejected' ? 'bg-red-500' : 'bg-gray-300') }} flex items-center justify-center mb-2">
                                    @if(in_array($rental->status, ['approved', 'active', 'completed']))
                                        <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                    @elseif($rental->status === 'rejected')
                                        <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                        </svg>
                                    @else
                                        <div class="w-3 h-3 bg-white rounded-full"></div>
                                    @endif
                                </div>
                                <div class="text-xs text-center">
                                    <div class="font-medium text-gray-900">
                                        {{ $rental->status === 'rejected' ? 'Ditolak' : 'Disetujui' }}
                                    </div>
                                    <div class="text-gray-500">
                                        @if($rental->tanggal_disetujui)
                                            {{ \Carbon\Carbon::parse($rental->tanggal_disetujui)->format('d/m/Y H:i') }}
                                        @else
                                            -
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Progress Line -->
                            <div class="flex-1 h-1 mx-4 {{ in_array($rental->status, ['active', 'completed']) ? 'bg-green-500' : 'bg-gray-300' }}"></div>

                            <!-- Step 3: Active -->
                            <div class="flex flex-col items-center">
                                <div class="w-8 h-8 rounded-full {{ in_array($rental->status, ['active', 'completed']) ? 'bg-green-500' : 'bg-gray-300' }} flex items-center justify-center mb-2">
                                    @if(in_array($rental->status, ['active', 'completed']))
                                        <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                    @else
                                        <div class="w-3 h-3 bg-white rounded-full"></div>
                                    @endif
                                </div>
                                <div class="text-xs text-center">
                                    <div class="font-medium text-gray-900">Dipinjam</div>
                                    <div class="text-gray-500">
                                        @if($rental->tanggal_diambil)
                                            {{ \Carbon\Carbon::parse($rental->tanggal_diambil)->format('d/m/Y H:i') }}
                                        @else
                                            -
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Progress Line -->
                            <div class="flex-1 h-1 mx-4 {{ $rental->status === 'completed' ? 'bg-green-500' : 'bg-gray-300' }}"></div>

                            <!-- Step 4: Completed -->
                            <div class="flex flex-col items-center">
                                <div class="w-8 h-8 rounded-full {{ $rental->status === 'completed' ? 'bg-green-500' : 'bg-gray-300' }} flex items-center justify-center mb-2">
                                    @if($rental->status === 'completed')
                                        <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                    @else
                                        <div class="w-3 h-3 bg-white rounded-full"></div>
                                    @endif
                                </div>
                                <div class="text-xs text-center">
                                    <div class="font-medium text-gray-900">Dikembalikan</div>
                                    <div class="text-gray-500">
                                        @if($rental->tanggal_kembali_aktual)
                                            {{ \Carbon\Carbon::parse($rental->tanggal_kembali_aktual)->format('d/m/Y H:i') }}
                                        @else
                                            -
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Item Information -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Barang</h3>
                        
                        <div class="flex items-center space-x-4 mb-4">
                            <div class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center">
                                <svg class="w-8 h-8 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4z"></path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h4 class="font-semibold text-gray-900">{{ $rental->barang->nama_barang }}</h4>
                                <p class="text-sm text-gray-500">{{ $rental->barang->kode_barang }}</p>
                            </div>
                        </div>

                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-500">Kategori:</span>
                                <span class="text-sm font-medium text-gray-900">{{ $rental->barang->kategori }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-500">Jumlah Dipinjam:</span>
                                <span class="text-sm font-medium text-gray-900">{{ $rental->jumlah }} unit</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-500">Lokasi:</span>
                                <span class="text-sm font-medium text-gray-900">{{ $rental->barang->lokasi ?? '-' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Rental Details -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Detail Rental</h3>
                        
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-500">Tanggal Pinjam:</span>
                                <span class="text-sm font-medium text-gray-900">
                                    {{ $rental->tanggal_pinjam ? \Carbon\Carbon::parse($rental->tanggal_pinjam)->format('d/m/Y') : '-' }}
                                </span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-500">Rencana Kembali:</span>
                                <span class="text-sm font-medium text-gray-900">
                                    {{ $rental->tanggal_kembali_rencana ? \Carbon\Carbon::parse($rental->tanggal_kembali_rencana)->format('d/m/Y') : '-' }}
                                </span>
                            </div>
                            @if($rental->tanggal_kembali_aktual)
                                <div class="flex justify-between">
                                    <span class="text-sm text-gray-500">Tanggal Kembali:</span>
                                    <span class="text-sm font-medium text-gray-900">
                                        {{ \Carbon\Carbon::parse($rental->tanggal_kembali_aktual)->format('d/m/Y') }}
                                    </span>
                                </div>
                            @endif
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-500">Durasi:</span>
                                <span class="text-sm font-medium text-gray-900">
                                    @if($rental->tanggal_pinjam && $rental->tanggal_kembali_rencana)
                                        {{ \Carbon\Carbon::parse($rental->tanggal_pinjam)->diffInDays(\Carbon\Carbon::parse($rental->tanggal_kembali_rencana)) }} hari
                                    @else
                                        -
                                    @endif
                                </span>
                            </div>
                            @if($rental->disetujui_oleh)
                                <div class="flex justify-between">
                                    <span class="text-sm text-gray-500">Disetujui oleh:</span>
                                    <span class="text-sm font-medium text-gray-900">{{ $rental->approver->name ?? '-' }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Purpose and Notes -->
            <div class="mt-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Keperluan & Catatan</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Keperluan/Tujuan:</label>
                            <p class="text-sm text-gray-900 bg-gray-50 p-3 rounded-md">{{ $rental->keperluan }}</p>
                        </div>
                        
                        @if($rental->catatan)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Catatan:</label>
                                <p class="text-sm text-gray-900 bg-gray-50 p-3 rounded-md">{{ $rental->catatan }}</p>
                            </div>
                        @endif

                        @if($rental->catatan_admin)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Catatan dari Admin:</label>
                                <p class="text-sm text-gray-900 bg-blue-50 p-3 rounded-md border border-blue-200">{{ $rental->catatan_admin }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="mt-6 flex justify-between">
                <a href="{{ route('member.rental.history') }}" 
                   class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition-colors">
                    ← Kembali ke Riwayat
                </a>
                
                <div class="space-x-2">
                    @if($rental->status === 'pending')
                        <span class="text-sm text-gray-500 italic">Menunggu persetujuan staf gudang</span>
                    @elseif($rental->status === 'approved')
                        <span class="text-sm text-green-600 italic">Silakan ambil barang di gudang</span>
                    @elseif($rental->status === 'active')
                        <span class="text-sm text-blue-600 italic">Barang sedang dipinjam</span>
                    @elseif($rental->status === 'completed')
                        <span class="text-sm text-gray-600 italic">Rental telah selesai</span>
                    @elseif($rental->status === 'rejected')
                        <span class="text-sm text-red-600 italic">Rental ditolak</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
