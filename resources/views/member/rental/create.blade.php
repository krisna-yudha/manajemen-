<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Ajukan Rental Barang
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('member.rental.store') }}" class="space-y-6">
                @csrf
                
                <!-- Selected Item (if from barang page) -->
                @if(request('barang_id'))
                    @php($selectedBarang = App\Models\Barang::find(request('barang_id')))
                    @if($selectedBarang)
                        <div class="bg-blue-50 overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6">
                                <h3 class="text-lg font-medium text-blue-900 mb-4">Barang yang Dipilih</h3>
                                <div class="flex items-center space-x-4">
                                    <div class="flex-shrink-0 w-16 h-16 bg-blue-200 rounded-lg flex items-center justify-center">
                                        <svg class="w-8 h-8 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4z"></path>
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="font-semibold text-blue-900">{{ $selectedBarang->nama_barang }}</h4>
                                        <p class="text-sm text-blue-700">{{ $selectedBarang->kode_barang }} | {{ $selectedBarang->kategori }}</p>
                                        <p class="text-sm text-blue-600">Stok tersedia: {{ $selectedBarang->stok }} unit</p>
                                    </div>
                                </div>
                                <input type="hidden" name="barang_id" value="{{ $selectedBarang->id }}">
                            </div>
                        </div>
                    @endif
                @endif

                <!-- Rental Form -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-6">Informasi Rental</h3>
                        
                        <!-- Select Item (if not pre-selected) -->
                        @if(!request('barang_id'))
                            <div class="mb-6">
                                <label for="barang_id" class="block text-sm font-medium text-gray-700 mb-2">
                                    Pilih Barang <span class="text-red-500">*</span>
                                </label>
                                <select 
                                    id="barang_id" 
                                    name="barang_id" 
                                    required
                                    onchange="updateBarangInfo()"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                >
                                    <option value="">Pilih barang...</option>
                                    @foreach($availableBarangs as $barang)
                                        <option 
                                            value="{{ $barang->id }}"
                                            data-stok="{{ $barang->stok_tersedia }}"
                                            data-kategori="{{ $barang->kategori }}"
                                            data-lokasi="{{ $barang->lokasi }}"
                                        >
                                            {{ $barang->nama_barang }} ({{ $barang->kode_barang }}) - 
                                            Tersedia: {{ $barang->stok_tersedia }} unit - {{ $barang->rental_status }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('barang_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                
                                <!-- Selected Item Info -->
                                <div id="selectedItemInfo" class="mt-3 p-3 bg-gray-50 rounded-md hidden">
                                    <div class="text-sm text-gray-600">
                                        <div><strong>Kategori:</strong> <span id="itemKategori">-</span></div>
                                        <div><strong>Lokasi:</strong> <span id="itemLokasi">-</span></div>
                                        <div><strong>Stok Tersedia:</strong> <span id="itemStok">-</span> unit</div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Jumlah -->
                            <div>
                                <label for="jumlah" class="block text-sm font-medium text-gray-700 mb-2">
                                    Jumlah <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="number" 
                                    id="jumlah" 
                                    name="jumlah" 
                                    min="1"
                                    @if(request('barang_id') && $selectedBarang)
                                        max="{{ $selectedBarang->stok }}"
                                    @endif
                                    value="{{ old('jumlah', 1) }}"
                                    required
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                >
                                @error('jumlah')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Tanggal Pinjam -->
                            <div>
                                <label for="tanggal_pinjam" class="block text-sm font-medium text-gray-700 mb-2">
                                    Tanggal Pinjam <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="date" 
                                    id="tanggal_pinjam" 
                                    name="tanggal_pinjam" 
                                    value="{{ old('tanggal_pinjam', date('Y-m-d')) }}"
                                    min="{{ date('Y-m-d') }}"
                                    required
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                >
                                @error('tanggal_pinjam')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Tanggal Kembali Rencana -->
                            <div>
                                <label for="tanggal_kembali_rencana" class="block text-sm font-medium text-gray-700 mb-2">
                                    Tanggal Kembali Rencana <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="date" 
                                    id="tanggal_kembali_rencana" 
                                    name="tanggal_kembali_rencana" 
                                    value="{{ old('tanggal_kembali_rencana') }}"
                                    min="{{ date('Y-m-d') }}"
                                    required
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                >
                                @error('tanggal_kembali_rencana')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Durasi (Auto-calculated) -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Durasi Rental
                                </label>
                                <div class="w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-md text-gray-700">
                                    <span id="durasiRental">-</span> hari
                                </div>
                            </div>
                        </div>

                        <!-- Keperluan -->
                        <div class="mt-6">
                            <label for="keperluan" class="block text-sm font-medium text-gray-700 mb-2">
                                Keperluan/Tujuan Rental <span class="text-red-500">*</span>
                            </label>
                            <textarea 
                                id="keperluan" 
                                name="keperluan" 
                                rows="4"
                                placeholder="Jelaskan untuk apa barang ini akan digunakan..."
                                required
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            >{{ old('keperluan') }}</textarea>
                            @error('keperluan')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Catatan Tambahan -->
                        <div class="mt-6">
                            <label for="catatan" class="block text-sm font-medium text-gray-700 mb-2">
                                Catatan Tambahan
                            </label>
                            <textarea 
                                id="catatan" 
                                name="catatan" 
                                rows="3"
                                placeholder="Catatan khusus atau permintaan tambahan (opsional)..."
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            >{{ old('catatan') }}</textarea>
                            @error('catatan')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Important Notes -->
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-yellow-800">Penting untuk Diperhatikan:</h3>
                            <div class="mt-2 text-sm text-yellow-700">
                                <ul class="list-disc list-inside space-y-1">
                                    <li>Permintaan rental akan direview oleh staf gudang sebelum disetujui</li>
                                    <li>Pastikan tanggal dan durasi rental sesuai dengan kebutuhan Anda</li>
                                    <li>Barang harus dikembalikan sesuai dengan tanggal yang telah ditentukan</li>
                                    <li>Kondisi barang harus tetap baik saat dikembalikan</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex justify-end space-x-4">
                    <a href="{{ route('member.barang.available') }}" 
                       class="px-6 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition-colors">
                        Batal
                    </a>
                    <button type="submit" 
                            class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                        Ajukan Rental
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function updateBarangInfo() {
            const select = document.getElementById('barang_id');
            const selectedOption = select.options[select.selectedIndex];
            const infoDiv = document.getElementById('selectedItemInfo');
            
            if (selectedOption.value) {
                document.getElementById('itemKategori').textContent = selectedOption.dataset.kategori || '-';
                document.getElementById('itemLokasi').textContent = selectedOption.dataset.lokasi || '-';
                document.getElementById('itemStok').textContent = selectedOption.dataset.stok || '0';
                
                // Update max quantity
                const jumlahInput = document.getElementById('jumlah');
                jumlahInput.max = selectedOption.dataset.stok;
                
                infoDiv.classList.remove('hidden');
            } else {
                infoDiv.classList.add('hidden');
            }
        }

        function calculateDuration() {
            const tanggalPinjam = document.getElementById('tanggal_pinjam').value;
            const tanggalKembali = document.getElementById('tanggal_kembali_rencana').value;
            
            if (tanggalPinjam && tanggalKembali) {
                const date1 = new Date(tanggalPinjam);
                const date2 = new Date(tanggalKembali);
                const timeDiff = date2.getTime() - date1.getTime();
                const dayDiff = Math.ceil(timeDiff / (1000 * 3600 * 24));
                
                document.getElementById('durasiRental').textContent = dayDiff > 0 ? dayDiff : 0;
            } else {
                document.getElementById('durasiRental').textContent = '-';
            }
        }

        // Event listeners for date calculation
        document.getElementById('tanggal_pinjam').addEventListener('change', calculateDuration);
        document.getElementById('tanggal_kembali_rencana').addEventListener('change', calculateDuration);

        // Auto-set return date to 1 week after borrow date
        document.getElementById('tanggal_pinjam').addEventListener('change', function() {
            const borrowDate = new Date(this.value);
            const returnDate = new Date(borrowDate);
            returnDate.setDate(returnDate.getDate() + 7);
            
            document.getElementById('tanggal_kembali_rencana').value = returnDate.toISOString().split('T')[0];
            calculateDuration();
        });

        // Initial calculation
        calculateDuration();
    </script>
</x-app-layout>
