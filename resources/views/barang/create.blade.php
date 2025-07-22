<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tambah Barang Baru
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <!-- Mode Selection -->
                    <div class="mb-8">
                        <div class="flex space-x-1 rounded-lg bg-gray-100 p-1">
                            <button type="button" id="newItemBtn" onclick="switchMode('new')" 
                                    class="w-1/2 rounded-md py-2 px-4 text-sm font-medium transition-colors bg-white text-gray-900 shadow">
                                Tambah Barang Baru
                            </button>
                            <button type="button" id="addStockBtn" onclick="switchMode('existing')" 
                                    class="w-1/2 rounded-md py-2 px-4 text-sm font-medium transition-colors text-gray-500 hover:text-gray-900">
                                Tambah Stok Barang Existing
                            </button>
                        </div>
                    </div>

                    <!-- Add Stock to Existing Item Form -->
                    <div id="existingItemForm" class="hidden">
                        <form method="POST" action="{{ route('barang.store') }}">
                            @csrf
                            <input type="hidden" name="add_to_existing" value="1">
                            
                            <div class="space-y-6">
                                <h3 class="text-lg font-medium text-gray-900">Tambah Stok ke Barang yang Sudah Ada</h3>
                                
                                <div>
                                    <label for="existing_barang_id" class="block text-sm font-medium text-gray-700 mb-2">Pilih Barang</label>
                                    <div class="relative">
                                        <input type="text" id="search_barang" placeholder="Cari barang..." class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 mb-2">
                                        <select name="existing_barang_id" id="existing_barang_id" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                            <option value="">Pilih barang untuk ditambah stoknya...</option>
                                            @foreach($existingBarangs as $item)
                                                <option value="{{ $item->id }}" data-current-stock="{{ $item->stok }}" data-search="{{ strtolower($item->kode_barang . ' ' . $item->nama_barang) }}">
                                                    {{ $item->kode_barang }} - {{ $item->nama_barang }} (Stok saat ini: {{ $item->stok }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('existing_barang_id')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="additional_stock" class="block text-sm font-medium text-gray-700 mb-2">Jumlah Stok yang Ditambahkan</label>
                                    <input type="number" name="additional_stock" id="additional_stock" min="1" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                    @error('additional_stock')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="stock_reason" class="block text-sm font-medium text-gray-700 mb-2">Alasan Penambahan Stok</label>
                                    <textarea name="stock_reason" id="stock_reason" rows="3" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Jelaskan alasan penambahan stok (contoh: pembelian baru, pengembalian dari perbaikan, dll)" required></textarea>
                                    @error('stock_reason')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="flex justify-end space-x-3">
                                    <a href="{{ route('barang.index') }}" class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400">
                                        Batal
                                    </a>
                                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                                        Tambah Stok
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- New Item Form -->
                    <div id="newItemForm">
                        <form method="POST" action="{{ route('barang.store') }}" enctype="multipart/form-data">
                            @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Kode Barang -->
                            <div>
                                <label for="kode_barang" class="block text-sm font-medium text-gray-700">Kode Barang</label>
                                <input type="text" name="kode_barang" id="kode_barang" 
                                       value="{{ old('kode_barang', $nextKodeBarang ?? 'IND0001') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-gray-100 cursor-not-allowed"
                                       placeholder="IND0001" readonly required>
                                <p class="mt-1 text-xs text-gray-500">Kode barang akan dibuat otomatis dengan format IND + 4 digit angka</p>
                                @error('kode_barang')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Nama Barang -->
                            <div>
                                <label for="nama_barang" class="block text-sm font-medium text-gray-700">Nama Barang</label>
                                <input type="text" name="nama_barang" id="nama_barang" 
                                       value="{{ old('nama_barang') }}"
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
                                    <option value="Elektronik" {{ old('kategori') === 'Elektronik' ? 'selected' : '' }}>Elektronik</option>
                                    <option value="Furniture" {{ old('kategori') === 'Furniture' ? 'selected' : '' }}>Furniture</option>
                                    <option value="Kendaraan" {{ old('kategori') === 'Kendaraan' ? 'selected' : '' }}>Kendaraan</option>
                                    <option value="Peralatan" {{ old('kategori') === 'Peralatan' ? 'selected' : '' }}>Peralatan</option>
                                    <option value="Lainnya" {{ old('kategori') === 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                </select>
                                @error('kategori')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Stok -->
                            <div>
                                <label for="stok" class="block text-sm font-medium text-gray-700">Stok</label>
                                <input type="number" name="stok" id="stok" 
                                       value="{{ old('stok') }}"
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
                                       value="{{ old('stok_minimum', 5) }}"
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
                                    <option value="baik" {{ old('kondisi') === 'baik' ? 'selected' : '' }}>Baik</option>
                                    <option value="rusak" {{ old('kondisi') === 'rusak' ? 'selected' : '' }}>Rusak</option>
                                    <option value="maintenance" {{ old('kondisi') === 'maintenance' ? 'selected' : '' }}>Maintenance</option>
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
                                    <option value="tersedia" {{ old('status') === 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                                    <option value="tidak_tersedia" {{ old('status') === 'tidak_tersedia' ? 'selected' : '' }}>Tidak Tersedia</option>
                                    <option value="maintenance" {{ old('status') === 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                                </select>
                                @error('status')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Lokasi Penyimpanan -->
                            <div>
                                <label for="lokasi_penyimpanan" class="block text-sm font-medium text-gray-700">Lokasi Penyimpanan</label>
                                <input type="text" name="lokasi_penyimpanan" id="lokasi_penyimpanan" 
                                       value="{{ old('lokasi_penyimpanan') }}"
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
                                       value="{{ old('harga_sewa_per_hari') }}"
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
                                      placeholder="Deskripsi detail barang">{{ old('deskripsi') }}</textarea>
                            @error('deskripsi')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Foto -->
                        <div class="mt-6">
                            <label for="foto" class="block text-sm font-medium text-gray-700">Foto Barang</label>
                            <input type="file" name="foto" id="foto" accept="image/*"
                                   class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                            <p class="mt-1 text-sm text-gray-500">PNG, JPG, GIF up to 2MB</p>
                            @error('foto')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Buttons -->
                        <div class="flex items-center justify-end mt-6 space-x-3">
                            <a href="{{ route('barang.index') }}" class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400">
                                Batal
                            </a>
                            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                                Simpan Barang
                            </button>
                        </div>

                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script>
        function switchMode(mode) {
            const newItemForm = document.getElementById('newItemForm');
            const existingItemForm = document.getElementById('existingItemForm');
            const newItemBtn = document.getElementById('newItemBtn');
            const addStockBtn = document.getElementById('addStockBtn');

            if (mode === 'new') {
                newItemForm.classList.remove('hidden');
                existingItemForm.classList.add('hidden');
                newItemBtn.className = 'w-1/2 rounded-md py-2 px-4 text-sm font-medium transition-colors bg-white text-gray-900 shadow';
                addStockBtn.className = 'w-1/2 rounded-md py-2 px-4 text-sm font-medium transition-colors text-gray-500 hover:text-gray-900';
            } else {
                newItemForm.classList.add('hidden');
                existingItemForm.classList.remove('hidden');
                newItemBtn.className = 'w-1/2 rounded-md py-2 px-4 text-sm font-medium transition-colors text-gray-500 hover:text-gray-900';
                addStockBtn.className = 'w-1/2 rounded-md py-2 px-4 text-sm font-medium transition-colors bg-white text-gray-900 shadow';
            }
        }

        // Show current stock when selecting existing item
        document.getElementById('existing_barang_id').addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const currentStock = selectedOption.getAttribute('data-current-stock');
            
            if (currentStock) {
                const stockInfo = document.createElement('div');
                stockInfo.id = 'current-stock-info';
                stockInfo.className = 'mt-2 text-sm text-blue-600 font-medium';
                stockInfo.textContent = `Stok saat ini: ${currentStock} unit`;
                
                // Remove existing info if any
                const existingInfo = document.getElementById('current-stock-info');
                if (existingInfo) {
                    existingInfo.remove();
                }
                
                // Add after the select element
                this.parentNode.appendChild(stockInfo);
            }
        });

        // Search functionality for existing items
        document.getElementById('search_barang').addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const select = document.getElementById('existing_barang_id');
            const options = select.querySelectorAll('option');
            
            options.forEach(option => {
                if (option.value === '') {
                    option.style.display = 'block';
                    return;
                }
                
                const searchData = option.getAttribute('data-search');
                if (searchData && searchData.includes(searchTerm)) {
                    option.style.display = 'block';
                } else {
                    option.style.display = 'none';
                }
            });
        });

        // Auto-calculate total stock
        document.getElementById('additional_stock').addEventListener('input', function() {
            const additionalStock = parseInt(this.value) || 0;
            const currentStockInfo = document.getElementById('current-stock-info');
            
            if (currentStockInfo && additionalStock > 0) {
                const currentStock = parseInt(currentStockInfo.textContent.match(/\d+/)[0]);
                const totalStock = currentStock + additionalStock;
                
                let totalInfo = document.getElementById('total-stock-info');
                if (!totalInfo) {
                    totalInfo = document.createElement('div');
                    totalInfo.id = 'total-stock-info';
                    totalInfo.className = 'mt-1 text-sm text-green-600 font-medium';
                    this.parentNode.appendChild(totalInfo);
                }
                
                totalInfo.textContent = `Total stok setelah penambahan: ${totalStock} unit`;
            }
        });
    </script>
</x-app-layout>
