<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Ajukan Rental Barang
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <!-- Error Messages -->
                    @if($errors->any())
                        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded mb-4">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('rental.store') }}">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Barang Selection -->
                            <div class="md:col-span-2">
                                <label for="barang_id" class="block text-sm font-medium text-gray-700">Pilih Barang</label>
                                <select name="barang_id" id="barang_id" 
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" 
                                        required onchange="updateStokInfo()">
                                    <option value="">-- Pilih Barang --</option>
                                    @foreach($barangs as $barang)
                                        <option value="{{ $barang->id }}" 
                                                data-stok="{{ $barang->stok_tersedia }}"
                                                data-harga="{{ $barang->harga_sewa_per_hari }}"
                                                {{ old('barang_id') == $barang->id ? 'selected' : '' }}>
                                            {{ $barang->nama_barang }} ({{ $barang->kode_barang }}) - 
                                            Stok: {{ $barang->stok_tersedia }} - 
                                            Rp {{ number_format($barang->harga_sewa_per_hari, 0, ',', '.') }}/hari
                                        </option>
                                    @endforeach
                                </select>
                                @error('barang_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                <div id="stok-info" class="mt-2 text-sm text-gray-600"></div>
                            </div>

                            <!-- Jumlah -->
                            <div>
                                <label for="jumlah" class="block text-sm font-medium text-gray-700">Jumlah</label>
                                <input type="number" name="jumlah" id="jumlah" 
                                       value="{{ old('jumlah', 1) }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                       min="1" required onchange="calculateTotal()">
                                @error('jumlah')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Tanggal Pinjam -->
                            <div>
                                <label for="tanggal_pinjam" class="block text-sm font-medium text-gray-700">Tanggal Pinjam</label>
                                <input type="date" name="tanggal_pinjam" id="tanggal_pinjam" 
                                       value="{{ old('tanggal_pinjam') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                       min="{{ date('Y-m-d') }}" required onchange="calculateTotal()">
                                @error('tanggal_pinjam')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Tanggal Kembali -->
                            <div>
                                <label for="tanggal_kembali_rencana" class="block text-sm font-medium text-gray-700">Tanggal Kembali</label>
                                <input type="date" name="tanggal_kembali_rencana" id="tanggal_kembali_rencana" 
                                       value="{{ old('tanggal_kembali_rencana') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                       required onchange="calculateTotal()">
                                @error('tanggal_kembali_rencana')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Keperluan -->
                        <div class="mt-6">
                            <label for="keperluan" class="block text-sm font-medium text-gray-700">Keperluan/Tujuan Rental</label>
                            <textarea name="keperluan" id="keperluan" rows="4"
                                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                      placeholder="Jelaskan keperluan atau tujuan rental barang ini..."
                                      required>{{ old('keperluan') }}</textarea>
                            @error('keperluan')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Cost Calculation -->
                        <div id="cost-calculation" class="mt-6 p-4 bg-blue-50 rounded-lg" style="display: none;">
                            <h4 class="font-semibold text-blue-800 mb-2">Perhitungan Biaya</h4>
                            <div class="text-blue-600 text-sm space-y-1">
                                <div>Durasi: <span id="duration-days">0</span> hari</div>
                                <div>Harga per hari: Rp <span id="price-per-day">0</span></div>
                                <div>Jumlah barang: <span id="quantity-display">1</span> unit</div>
                                <div class="font-semibold text-blue-800">Total Biaya: Rp <span id="total-cost">0</span></div>
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="flex items-center justify-end mt-6 space-x-3">
                            <a href="{{ route('rental.index') }}" class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400">
                                Batal
                            </a>
                            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                                Ajukan Rental
                            </button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>

    <script>
        function updateStokInfo() {
            const select = document.getElementById('barang_id');
            const option = select.options[select.selectedIndex];
            const stokInfo = document.getElementById('stok-info');
            
            if (option.value) {
                const stok = option.getAttribute('data-stok');
                stokInfo.innerHTML = `Stok tersedia: <strong>${stok} unit</strong>`;
                stokInfo.className = 'mt-2 text-sm text-green-600';
                
                // Update max jumlah
                document.getElementById('jumlah').max = stok;
            } else {
                stokInfo.innerHTML = '';
            }
            
            calculateTotal();
        }

        function calculateTotal() {
            const barangSelect = document.getElementById('barang_id');
            const jumlah = document.getElementById('jumlah').value;
            const tanggalPinjam = document.getElementById('tanggal_pinjam').value;
            const tanggalKembali = document.getElementById('tanggal_kembali_rencana').value;
            
            if (barangSelect.value && jumlah && tanggalPinjam && tanggalKembali) {
                const option = barangSelect.options[barangSelect.selectedIndex];
                const hargaPerHari = parseFloat(option.getAttribute('data-harga'));
                
                const startDate = new Date(tanggalPinjam);
                const endDate = new Date(tanggalKembali);
                const timeDiff = endDate.getTime() - startDate.getTime();
                const daysDiff = Math.ceil(timeDiff / (1000 * 3600 * 24)) + 1;
                
                if (daysDiff > 0) {
                    const totalCost = hargaPerHari * jumlah * daysDiff;
                    
                    document.getElementById('duration-days').textContent = daysDiff;
                    document.getElementById('price-per-day').textContent = hargaPerHari.toLocaleString('id-ID');
                    document.getElementById('quantity-display').textContent = jumlah;
                    document.getElementById('total-cost').textContent = totalCost.toLocaleString('id-ID');
                    document.getElementById('cost-calculation').style.display = 'block';
                } else {
                    document.getElementById('cost-calculation').style.display = 'none';
                }
            } else {
                document.getElementById('cost-calculation').style.display = 'none';
            }
        }

        // Set minimum date for tanggal_kembali when tanggal_pinjam changes
        document.getElementById('tanggal_pinjam').addEventListener('change', function() {
            const tanggalPinjam = this.value;
            const tanggalKembali = document.getElementById('tanggal_kembali_rencana');
            
            if (tanggalPinjam) {
                const nextDay = new Date(tanggalPinjam);
                nextDay.setDate(nextDay.getDate() + 1);
                tanggalKembali.min = nextDay.toISOString().split('T')[0];
                
                // If current tanggal_kembali is before tanggal_pinjam, reset it
                if (tanggalKembali.value && tanggalKembali.value <= tanggalPinjam) {
                    tanggalKembali.value = '';
                }
            }
        });
    </script>
</x-app-layout>
