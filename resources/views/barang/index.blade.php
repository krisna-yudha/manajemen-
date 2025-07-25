<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Manajemen Stok Barang
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <!-- Header Section -->
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-medium">
                            @if(Auth::user()->role === 'manager')
                                Monitor Stok Barang
                            @else
                                Daftar Barang
                            @endif
                        </h3>
                        @if(Auth::user()->role === 'gudang')
                            <a href="{{ route('barang.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                                Tambah Barang Baru
                            </a>
                        @endif
                    </div>

                    <!-- Success Message -->
                    @if(session('success'))
                        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- Stats Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <h4 class="font-semibold text-blue-800">Total Barang</h4>
                            <p class="text-2xl font-bold text-blue-600">{{ $barangs->total() }}</p>
                        </div>
                        <div class="bg-green-50 p-4 rounded-lg">
                            <h4 class="font-semibold text-green-800">Tersedia</h4>
                            <p class="text-2xl font-bold text-green-600">{{ $barangs->where('status', 'tersedia')->count() }}</p>
                        </div>
                        <div class="bg-yellow-50 p-4 rounded-lg">
                            <h4 class="font-semibold text-yellow-800">Stok Rendah</h4>
                            <p class="text-2xl font-bold text-yellow-600">{{ $barangs->filter(function($barang) { return $barang->isLowStock(); })->count() }}</p>
                        </div>
                        <div class="bg-red-50 p-4 rounded-lg">
                            <h4 class="font-semibold text-red-800">Maintenance</h4>
                            <p class="text-2xl font-bold text-red-600">{{ $barangs->where('status', 'maintenance')->count() }}</p>
                        </div>
                    </div>

                    <!-- Table -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full table-auto">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Foto</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stok</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($barangs as $barang)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($barang->foto)
                                            <img src="{{ asset('storage/' . $barang->foto) }}" class="h-12 w-12 object-cover rounded" alt="{{ $barang->nama_barang }}">
                                        @else
                                            <div class="h-12 w-12 bg-gray-200 rounded flex items-center justify-center">
                                                <span class="text-gray-400 text-xs">No Photo</span>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $barang->kode_barang }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $barang->nama_barang }}</div>
                                        <div class="text-sm text-gray-500">{{ Str::limit($barang->deskripsi, 50) }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">
                                            {{ $barang->kategori }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">
                                            <div class="flex items-center space-x-2">
                                                <span class="font-semibold {{ $barang->isLowStock() ? 'text-red-600' : 'text-green-600' }}">
                                                    {{ $barang->stok }}
                                                </span>
                                                <span class="text-gray-500">total</span>
                                            </div>
                                            @if(Auth::user()->role === 'gudang')
                                                <div class="text-xs text-gray-600">
                                                    Tersedia: <span class="font-medium text-blue-600">{{ $barang->stok_tersedia }}</span>
                                                </div>
                                                <div class="text-xs text-gray-600">
                                                    Dipinjam: <span class="font-medium text-orange-600">{{ $barang->stok_dipinjam }}</span>
                                                </div>
                                            @endif
                                            <div class="text-xs text-gray-500">Min: {{ $barang->stok_minimum }}</div>
                                        </div>
                                        @if($barang->isLowStock())
                                            <span class="text-xs text-red-600">⚠️ Stok Rendah</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                            @if($barang->status === 'tersedia') bg-green-100 text-green-800
                                            @elseif($barang->status === 'maintenance') bg-yellow-100 text-yellow-800
                                            @else bg-red-100 text-red-800
                                            @endif">
                                            {{ ucfirst($barang->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                        <a href="{{ route('barang.show', $barang) }}" class="text-blue-600 hover:text-blue-900">Detail</a>
                                        @if(Auth::user()->role === 'gudang')
                                            <a href="{{ route('barang.edit', $barang) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                            <form method="POST" action="{{ route('barang.destroy', $barang) }}" class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900" 
                                                        onclick="return confirm('Yakin ingin menghapus barang ini?')">
                                                    Hapus
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                                        Belum ada data barang
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $barangs->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
