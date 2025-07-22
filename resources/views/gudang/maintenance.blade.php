<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Kelola Barang Maintenance</h2>
                <p class="text-gray-600 mt-1">Monitor dan update status barang yang perlu perawatan</p>
            </div>
            <div class="mt-4 sm:mt-0">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-orange-100 text-orange-800">
                    ⚠️ Maintenance Center
                </span>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <div class="text-2xl font-bold text-gray-900">{{ $stats['maintenance'] }}</div>
                            <div class="text-sm text-gray-600">Status Maintenance</div>
                        </div>
                    </div>
                    <div class="mt-4">
                        <div class="text-sm text-yellow-600">
                            Barang dalam perawatan
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <div class="text-2xl font-bold text-gray-900">{{ $stats['rusak'] }}</div>
                            <div class="text-sm text-gray-600">Kondisi Rusak</div>
                        </div>
                    </div>
                    <div class="mt-4">
                        <div class="text-sm text-red-600">
                            Perlu perbaikan
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <div class="text-2xl font-bold text-gray-900">{{ $stats['need_repair'] }}</div>
                            <div class="text-sm text-gray-600">Perlu Perawatan</div>
                        </div>
                    </div>
                    <div class="mt-4">
                        <div class="text-sm text-orange-600">
                            Segera ditangani
                        </div>
                    </div>
                </div>
            </div>

            <!-- Success Message -->
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Maintenance Items Table -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Daftar Barang Maintenance</h3>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Foto</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode & Nama</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kondisi</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Catatan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($maintenanceItems as $barang)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center">
                                            @if($barang->foto)
                                                <img src="{{ Storage::url($barang->foto) }}" alt="{{ $barang->nama_barang }}" class="w-full h-full object-cover rounded-lg">
                                            @else
                                                <svg class="w-8 h-8 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4z"></path>
                                                </svg>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $barang->kode_barang }}</div>
                                        <div class="text-sm text-gray-500">{{ $barang->nama_barang }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                            {{ $barang->kategori }}
                                        </span>
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
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                            @if($barang->kondisi === 'baik') bg-green-100 text-green-800
                                            @elseif($barang->kondisi === 'maintenance') bg-yellow-100 text-yellow-800
                                            @else bg-red-100 text-red-800
                                            @endif">
                                            {{ ucfirst($barang->kondisi) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900 max-w-xs truncate">
                                            {{ $barang->catatan_maintenance ?: '-' }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                        <button onclick="openMaintenanceModal('{{ $barang->id }}', '{{ $barang->nama_barang }}', '{{ $barang->status }}', '{{ $barang->kondisi }}', '{{ $barang->catatan_maintenance }}')" 
                                                class="text-indigo-600 hover:text-indigo-900">
                                            Update Status
                                        </button>
                                        <a href="{{ route('barang.show', $barang) }}" class="text-blue-600 hover:text-blue-900">Detail</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                                        <svg class="w-12 h-12 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak ada barang maintenance</h3>
                                        <p class="text-gray-500">Semua barang dalam kondisi baik</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($maintenanceItems->hasPages())
                    <div class="px-6 py-4 border-t border-gray-200">
                        {{ $maintenanceItems->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Maintenance Modal -->
    <div id="maintenanceModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50 flex items-center justify-center p-4 transition-opacity duration-150">
        <div class="relative bg-white rounded-xl shadow-2xl w-full max-w-lg mx-auto transform transition-all duration-150 scale-95">
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-6 border-b border-gray-200">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-orange-100 rounded-full flex items-center justify-center mr-3">
                        <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Update Status Maintenance</h3>
                        <p class="text-sm text-gray-500">Ubah status dan kondisi barang</p>
                    </div>
                </div>
                <button type="button" onclick="closeMaintenanceModal()" class="text-gray-400 hover:text-gray-600 focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="p-6">
                <form id="maintenanceForm" method="POST">
                    @csrf
                    @method('PATCH')
                    
                    <!-- Barang Info -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                            Nama Barang
                        </label>
                        <div id="barangName" class="text-sm font-medium text-gray-900 bg-gray-50 p-3 rounded-lg border border-gray-200"></div>
                    </div>

                    <!-- Status Selection -->
                    <div class="mb-6">
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Status Barang
                        </label>
                        <select name="status" id="status" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 transition-colors" required>
                            <option value="tersedia">✅ Tersedia</option>
                            <option value="maintenance">⚠️ Maintenance</option>
                            <option value="tidak_tersedia">❌ Tidak Tersedia</option>
                        </select>
                    </div>

                    <!-- Kondisi Selection -->
                    <div class="mb-6">
                        <label for="kondisi" class="block text-sm font-medium text-gray-700 mb-2">
                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                            Kondisi Fisik
                        </label>
                        <select name="kondisi" id="kondisi" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 transition-colors" required>
                            <option value="baik">🟢 Baik</option>
                            <option value="maintenance">🟡 Perlu Maintenance</option>
                            <option value="rusak">🔴 Rusak</option>
                        </select>
                    </div>

                    <!-- Catatan Maintenance -->
                    <div class="mb-6">
                        <label for="catatan_maintenance" class="block text-sm font-medium text-gray-700 mb-2">
                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            Catatan Maintenance
                        </label>
                        <textarea name="catatan_maintenance" id="catatan_maintenance" rows="4" 
                                  class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 transition-colors resize-none"
                                  placeholder="Jelaskan kondisi barang, perbaikan yang dilakukan, atau catatan lainnya..."></textarea>
                        <p class="text-xs text-gray-500 mt-1">Catatan ini akan membantu tracking riwayat maintenance barang</p>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex justify-end space-x-3 pt-4 border-t border-gray-200">
                        <button type="button" onclick="closeMaintenanceModal()" 
                                class="px-6 py-2.5 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-300 transition-colors font-medium">
                            Batal
                        </button>
                        <button type="submit" 
                                class="px-6 py-2.5 bg-orange-600 text-white rounded-lg hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-orange-500 transition-colors font-medium">
                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                            </svg>
                            Update Status
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openMaintenanceModal(id, name, status, kondisi, catatan) {
            document.getElementById('barangName').textContent = name;
            document.getElementById('status').value = status;
            document.getElementById('kondisi').value = kondisi;
            document.getElementById('catatan_maintenance').value = catatan || '';
            
            const form = document.getElementById('maintenanceForm');
            form.action = `/maintenance/barang/${id}`;
            
            const modal = document.getElementById('maintenanceModal');
            modal.classList.remove('hidden');
            
            // Add animation
            setTimeout(() => {
                modal.querySelector('.relative').classList.add('scale-100');
            }, 10);
            
            // Focus on first input
            document.getElementById('status').focus();
        }

        function closeMaintenanceModal() {
            const modal = document.getElementById('maintenanceModal');
            modal.querySelector('.relative').classList.remove('scale-100');
            
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 150);
        }

        // Close modal when clicking outside
        document.getElementById('maintenanceModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeMaintenanceModal();
            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                const modal = document.getElementById('maintenanceModal');
                if (!modal.classList.contains('hidden')) {
                    closeMaintenanceModal();
                }
            }
        });

        // Form validation and submission
        document.getElementById('maintenanceForm').addEventListener('submit', function(e) {
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            
            // Show loading state
            submitBtn.innerHTML = `
                <svg class="w-4 h-4 inline mr-1 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
                Memproses...
            `;
            submitBtn.disabled = true;
            
            // If form validation fails, restore button
            setTimeout(() => {
                if (!this.checkValidity()) {
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                }
            }, 100);
        });

        // Auto-expand textarea
        const textarea = document.getElementById('catatan_maintenance');
        textarea.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = (this.scrollHeight) + 'px';
        });
    </script>
</x-app-layout>
