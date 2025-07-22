<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detail Barang: {{ $barang->nama_barang }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <!-- Header Section -->
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-medium">Informasi Barang</h3>
                        <div class="space-x-2">
                            @if(Auth::user()->role === 'gudang')
                                <a href="{{ route('barang.edit', $barang) }}" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                                    Edit Barang
                                </a>
                            @endif
                            <a href="{{ route('barang.index') }}" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">
                                Kembali
                            </a>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Left Column - Basic Info -->
                        <div class="space-y-6">
                            <!-- Foto -->
                            @if($barang->foto)
                                <div>
                                    <img src="{{ Storage::url($barang->foto) }}" class="w-full h-64 object-cover rounded-lg shadow-md" alt="{{ $barang->nama_barang }}">
                                </div>
                            @else
                                <div class="w-full h-64 bg-gray-200 rounded-lg flex items-center justify-center">
                                    <span class="text-gray-400 text-lg">Tidak ada foto</span>
                                </div>
                            @endif

                            <!-- Basic Details -->
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h4 class="font-semibold text-gray-700 mb-3">Informasi Dasar</h4>
                                <div class="space-y-2">
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Kode Barang:</span>
                                        <span class="font-medium">{{ $barang->kode_barang }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Nama Barang:</span>
                                        <span class="font-medium">{{ $barang->nama_barang }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Kategori:</span>
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">
                                            {{ $barang->kategori }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column - Detailed Info -->
                        <div class="space-y-6">
                            <!-- Stock Info -->
                            <div class="bg-blue-50 p-4 rounded-lg">
                                <h4 class="font-semibold text-blue-700 mb-3">Informasi Stok</h4>
                                <div class="space-y-2">
                                    <div class="flex justify-between">
                                        <span class="text-blue-600">Stok Tersedia:</span>
                                        <span class="font-bold text-2xl {{ $barang->isLowStock() ? 'text-red-600' : 'text-green-600' }}">
                                            {{ $barang->stok }}
                                        </span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-blue-600">Stok Minimum:</span>
                                        <span class="font-medium">{{ $barang->stok_minimum }}</span>
                                    </div>
                                    @if($barang->isLowStock())
                                        <div class="bg-red-100 border border-red-400 text-red-700 px-3 py-2 rounded text-sm">
                                            ⚠️ Stok rendah! Perlu restock segera.
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Stock Management -->
                            @if(Auth::user()->role === 'gudang')
                                <div class="bg-blue-50 p-4 rounded-lg">
                                    <h4 class="font-semibold text-blue-700 mb-3">Kelola Stok</h4>
                                    <div class="space-y-3">
                                        <div class="flex justify-between items-center">
                                            <span class="text-blue-600">Stok Saat Ini:</span>
                                            <span class="font-bold text-lg text-blue-800">{{ $barang->stok }} unit</span>
                                        </div>
                                        
                                        <!-- Stock Adjustment Form -->
                                        <form action="{{ route('barang.adjust-stock', $barang) }}" method="POST" class="space-y-3">
                                            @csrf
                                            @method('PATCH')
                                            
                                            <div>
                                                <label class="block text-sm font-medium text-blue-700 mb-1">Jenis Penyesuaian</label>
                                                <select name="adjustment_type" class="w-full text-sm border-blue-300 rounded-md" required>
                                                    <option value="">Pilih jenis penyesuaian</option>
                                                    <option value="add">➕ Tambah Stok</option>
                                                    <option value="subtract">➖ Kurangi Stok</option>
                                                </select>
                                            </div>
                                            
                                            <div>
                                                <label class="block text-sm font-medium text-blue-700 mb-1">Jumlah</label>
                                                <input type="number" name="adjustment_amount" min="1" max="1000" 
                                                       class="w-full text-sm border-blue-300 rounded-md" 
                                                       placeholder="Masukkan jumlah" required>
                                            </div>
                                            
                                            <div>
                                                <label class="block text-sm font-medium text-blue-700 mb-1">Alasan</label>
                                                <textarea name="adjustment_reason" rows="2" 
                                                          class="w-full text-sm border-blue-300 rounded-md" 
                                                          placeholder="Jelaskan alasan penyesuaian stok..." required></textarea>
                                            </div>
                                            
                                            <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 text-sm font-medium">
                                                Sesuaikan Stok
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endif

                            <!-- Status & Condition -->
                            <div class="bg-green-50 p-4 rounded-lg">
                                <h4 class="font-semibold text-green-700 mb-3">Status & Kondisi</h4>
                                <div class="space-y-2">
                                    <div class="flex justify-between">
                                        <span class="text-green-600">Status:</span>
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                            @if($barang->status === 'tersedia') bg-green-100 text-green-800
                                            @elseif($barang->status === 'maintenance') bg-yellow-100 text-yellow-800
                                            @else bg-red-100 text-red-800
                                            @endif">
                                            {{ ucfirst($barang->status) }}
                                        </span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-green-600">Kondisi:</span>
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                            @if($barang->kondisi === 'baik') bg-green-100 text-green-800
                                            @elseif($barang->kondisi === 'maintenance') bg-yellow-100 text-yellow-800
                                            @else bg-red-100 text-red-800
                                            @endif">
                                            {{ ucfirst($barang->kondisi) }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Additional Info -->
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h4 class="font-semibold text-gray-700 mb-3">Informasi Tambahan</h4>
                                <div class="space-y-2">
                                    @if($barang->lokasi_penyimpanan)
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Lokasi:</span>
                                            <span class="font-medium">{{ $barang->lokasi_penyimpanan }}</span>
                                        </div>
                                    @endif
                                    @if($barang->harga_sewa_per_hari)
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Harga Sewa/Hari:</span>
                                            <span class="font-medium text-green-600">Rp {{ number_format($barang->harga_sewa_per_hari, 0, ',', '.') }}</span>
                                        </div>
                                    @endif
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Dibuat:</span>
                                        <span class="font-medium">{{ $barang->created_at->format('d/m/Y H:i') }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Diupdate:</span>
                                        <span class="font-medium">{{ $barang->updated_at->format('d/m/Y H:i') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Description -->
                    @if($barang->deskripsi)
                        <div class="mt-8">
                            <h4 class="font-semibold text-gray-700 mb-3">Deskripsi</h4>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <p class="text-gray-700 leading-relaxed">{{ $barang->deskripsi }}</p>
                            </div>
                        </div>
                    @endif

                    <!-- Rental Actions for Members -->
                    @if(Auth::user()->role === 'member' && $barang->status === 'tersedia' && $barang->stok > 0)
                        <div class="mt-8 bg-blue-50 border border-blue-200 p-4 rounded-lg">
                            <h4 class="font-semibold text-blue-700 mb-3">Ingin Meminjam Barang Ini?</h4>
                            <p class="text-blue-600 mb-4">Barang ini tersedia untuk dipinjam. Klik tombol di bawah untuk mengajukan permohonan rental.</p>
                            <a href="{{ route('rental.create', ['barang_id' => $barang->id]) }}" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                                Ajukan Rental
                            </a>
                        </div>
                    @elseif(Auth::user()->role === 'member')
                        <div class="mt-8 bg-yellow-50 border border-yellow-200 p-4 rounded-lg">
                            <h4 class="font-semibold text-yellow-700 mb-3">Barang Tidak Tersedia</h4>
                            <p class="text-yellow-600">Maaf, barang ini sedang tidak tersedia untuk dipinjam saat ini.</p>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
