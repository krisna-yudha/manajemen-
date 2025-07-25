<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Barang: {{ $barang->nama_barang }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form method="POST" action="{{ route('barang.update', $barang) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Kode Barang -->
                            <div>
                                <label for="kode_barang" class="block text-sm font-medium text-gray-700">Kode Barang</label>
                                <input type="text" name="kode_barang" id="kode_barang" 
                                       value="{{ old('kode_barang', $barang->kode_barang) }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-gray-100 cursor-not-allowed"
                                       readonly required>
                                <p class="mt-1 text-xs text-gray-500">Kode barang tidak dapat diubah</p>
                                @error('kode_barang')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Nama Barang -->
                            <div>
                                <label for="nama_barang" class="block text-sm font-medium text-gray-700">Nama Barang</label>
                                <input type="text" name="nama_barang" id="nama_barang" 
                                       value="{{ old('nama_barang', $barang->nama_barang) }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                       placeholder="Masukkan nama barang" required>
                                @error('nama_barang')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Kategori -->
                            <div>
                                <label for="kategori" class="block text-sm font-medium text-gray-700">Kategori</label>
                                <select name="kategori" id="kategori" 
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                    <option value="">Pilih Kategori</option>
                                    <option value="Elektronik" {{ old('kategori', $barang->kategori) === 'Elektronik' ? 'selected' : '' }}>Elektronik</option>
                                    <option value="Furniture" {{ old('kategori', $barang->kategori) === 'Furniture' ? 'selected' : '' }}>Furniture</option>
                                    <option value="Kendaraan" {{ old('kategori', $barang->kategori) === 'Kendaraan' ? 'selected' : '' }}>Kendaraan</option>
                                    <option value="Peralatan" {{ old('kategori', $barang->kategori) === 'Peralatan' ? 'selected' : '' }}>Peralatan</option>
                                    <option value="Lainnya" {{ old('kategori', $barang->kategori) === 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                </select>
                                @error('kategori')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Stok -->
                            <div>
                                <label for="stok" class="block text-sm font-medium text-gray-700">Stok</label>
                                <input type="number" name="stok" id="stok" 
                                       value="{{ old('stok', $barang->stok) }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                       min="0" required>
                                @error('stok')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Stok Minimum -->
                            <div>
                                <label for="stok_minimum" class="block text-sm font-medium text-gray-700">Stok Minimum</label>
                                <input type="number" name="stok_minimum" id="stok_minimum" 
                                       value="{{ old('stok_minimum', $barang->stok_minimum) }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                       min="0" required>
                                @error('stok_minimum')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Kondisi -->
                            <div>
                                <label for="kondisi" class="block text-sm font-medium text-gray-700">Kondisi</label>
                                <select name="kondisi" id="kondisi" 
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                    <option value="baik" {{ old('kondisi', $barang->kondisi) === 'baik' ? 'selected' : '' }}>Baik</option>
                                    <option value="rusak" {{ old('kondisi', $barang->kondisi) === 'rusak' ? 'selected' : '' }}>Rusak</option>
                                    <option value="maintenance" {{ old('kondisi', $barang->kondisi) === 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                                </select>
                                @error('kondisi')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Status -->
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                                <select name="status" id="status" 
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                    <option value="tersedia" {{ old('status', $barang->status) === 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                                    <option value="tidak_tersedia" {{ old('status', $barang->status) === 'tidak_tersedia' ? 'selected' : '' }}>Tidak Tersedia</option>
                                    <option value="maintenance" {{ old('status', $barang->status) === 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                                </select>
                                @error('status')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Lokasi Penyimpanan -->
                            <div>
                                <label for="lokasi_penyimpanan" class="block text-sm font-medium text-gray-700">Lokasi Penyimpanan</label>
                                <input type="text" name="lokasi_penyimpanan" id="lokasi_penyimpanan" 
                                       value="{{ old('lokasi_penyimpanan', $barang->lokasi_penyimpanan) }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                       placeholder="Contoh: Rak A-01, Gudang 1">
                                @error('lokasi_penyimpanan')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Harga Sewa -->
                            <div>
                                <label for="harga_sewa_per_hari" class="block text-sm font-medium text-gray-700">Harga Sewa per Hari (Rp)</label>
                                <input type="number" name="harga_sewa_per_hari" id="harga_sewa_per_hari" 
                                       value="{{ old('harga_sewa_per_hari', $barang->harga_sewa_per_hari) }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                       min="0" step="0.01">
                                @error('harga_sewa_per_hari')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Deskripsi -->
                        <div class="mt-6">
                            <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                            <textarea name="deskripsi" id="deskripsi" rows="4"
                                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                      placeholder="Deskripsi detail barang">{{ old('deskripsi', $barang->deskripsi) }}</textarea>
                            @error('deskripsi')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Foto -->
                        <div class="mt-6">
                            <label for="foto" class="block text-sm font-medium text-gray-700">Foto Barang</label>
                            @if($barang->foto)
                                <div class="mb-3">
                                    <img src="{{ asset('storage/' . $barang->foto) }}" class="h-32 w-32 object-cover rounded" alt="{{ $barang->nama_barang }}">
                                    <p class="text-sm text-gray-500">Foto saat ini</p>
                                </div>
                            @endif
                            <input type="file" name="foto" id="foto" accept="image/*"
                                   class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                            @error('foto')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Action Buttons -->
                        <div class="mt-8 flex justify-end space-x-4">
                            <a href="{{ route('barang.index') }}" class="bg-gray-600 text-white px-6 py-2 rounded hover:bg-gray-700">
                                Batal
                            </a>
                            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                                Update Barang
                            </button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
