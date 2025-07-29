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
                            @elseif($rental->status === 'ongoing')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                    <div class="w-2 h-2 bg-green-400 rounded-full mr-2"></div>
                                    Sedang Dipinjam
                                </span>
                            @elseif($rental->status === 'returned')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                    <div class="w-2 h-2 bg-gray-400 rounded-full mr-2"></div>
                                    Dikembalikan
                                </span>
                            @elseif($rental->status === 'rejected')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                    <div class="w-2 h-2 bg-red-400 rounded-full mr-2"></div>
                                    Ditolak
                                </span>
                            @elseif($rental->status === 'overdue')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                    <div class="w-2 h-2 bg-red-400 rounded-full mr-2"></div>
                                    Terlambat
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Progress Timeline -->
                    <div class="mt-6">
                        <div class="flex items-center justify-between text-sm">
                            <div class="flex flex-col items-center">
                                <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                                    <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <span class="mt-2 text-green-600 font-medium">Diajukan</span>
                                <span class="text-gray-500 text-xs">{{ $rental->created_at->format('d/m/Y H:i') }}</span>
                            </div>
                            
                            <div class="flex-1 h-1 mx-4 {{ in_array($rental->status, ['approved', 'ongoing', 'returned']) ? 'bg-green-500' : 'bg-gray-200' }}"></div>
                            
                            <div class="flex flex-col items-center">
                                <div class="w-8 h-8 {{ in_array($rental->status, ['approved', 'ongoing', 'returned']) ? 'bg-green-500' : ($rental->status === 'rejected' ? 'bg-red-500' : 'bg-gray-300') }} rounded-full flex items-center justify-center">
                                    @if(in_array($rental->status, ['approved', 'ongoing', 'returned']))
                                        <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                    @elseif($rental->status === 'rejected')
                                        <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                        </svg>
                                    @endif
                                </div>
                                <span class="mt-2 {{ in_array($rental->status, ['approved', 'ongoing', 'returned']) ? 'text-green-600' : ($rental->status === 'rejected' ? 'text-red-600' : 'text-gray-500') }} font-medium">
                                    {{ $rental->status === 'rejected' ? 'Ditolak' : 'Disetujui' }}
                                </span>
                                @if($rental->tanggal_disetujui)
                                    <span class="text-gray-500 text-xs">{{ \Carbon\Carbon::parse($rental->tanggal_disetujui)->format('d/m/Y H:i') }}</span>
                                @endif
                            </div>
                            
                            <div class="flex-1 h-1 mx-4 {{ $rental->status === 'ongoing' || $rental->status === 'returned' ? 'bg-green-500' : 'bg-gray-200' }}"></div>
                            
                            <div class="flex flex-col items-center">
                                <div class="w-8 h-8 {{ $rental->status === 'ongoing' || $rental->status === 'returned' ? 'bg-green-500' : 'bg-gray-300' }} rounded-full flex items-center justify-center">
                                    @if($rental->status === 'ongoing' || $rental->status === 'returned')
                                        <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                    @endif
                                </div>
                                <span class="mt-2 {{ $rental->status === 'ongoing' || $rental->status === 'returned' ? 'text-green-600' : 'text-gray-500' }} font-medium">Diambil</span>
                            </div>
                            
                            <div class="flex-1 h-1 mx-4 {{ $rental->status === 'returned' ? 'bg-green-500' : 'bg-gray-200' }}"></div>
                            
                            <div class="flex flex-col items-center">
                                <div class="w-8 h-8 {{ $rental->status === 'returned' ? 'bg-green-500' : 'bg-gray-300' }} rounded-full flex items-center justify-center">
                                    @if($rental->status === 'returned')
                                        <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                    @endif
                                </div>
                                <span class="mt-2 {{ $rental->status === 'returned' ? 'text-green-600' : 'text-gray-500' }} font-medium">Dikembalikan</span>
                                @if($rental->tanggal_kembali_aktual)
                                    <span class="text-gray-500 text-xs">{{ \Carbon\Carbon::parse($rental->tanggal_kembali_aktual)->format('d/m/Y') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Rental Information -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Rental</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Member Information -->
                        <div>
                            <h4 class="text-sm font-medium text-gray-700 mb-3">Informasi Peminjam</h4>
                            <div class="space-y-2">
                                <div class="flex justify-between">
                                    <span class="text-sm text-gray-500">Nama:</span>
                                    <span class="text-sm font-medium text-gray-900">{{ $rental->user->name }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-sm text-gray-500">Email:</span>
                                    <span class="text-sm font-medium text-gray-900">{{ $rental->user->email }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Barang Information -->
                        <div>
                            <h4 class="text-sm font-medium text-gray-700 mb-3">Informasi Barang</h4>
                            <div class="space-y-2">
                                <div class="flex justify-between">
                                    <span class="text-sm text-gray-500">Nama Barang:</span>
                                    <span class="text-sm font-medium text-gray-900">{{ $rental->barang->nama }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-sm text-gray-500">Kode Barang:</span>
                                    <span class="text-sm font-medium text-gray-900">{{ $rental->barang->kode_barang }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-sm text-gray-500">Jumlah:</span>
                                    <span class="text-sm font-medium text-gray-900">{{ $rental->jumlah }} unit</span>
                                </div>
                            </div>
                        </div>

                        <!-- Rental Dates -->
                        <div>
                            <h4 class="text-sm font-medium text-gray-700 mb-3">Tanggal Rental</h4>
                            <div class="space-y-2">
                                <div class="flex justify-between">
                                    <span class="text-sm text-gray-500">Tanggal Pinjam:</span>
                                    <span class="text-sm font-medium text-gray-900">{{ \Carbon\Carbon::parse($rental->tanggal_pinjam)->format('d/m/Y') }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-sm text-gray-500">Rencana Kembali:</span>
                                    <span class="text-sm font-medium text-gray-900">{{ \Carbon\Carbon::parse($rental->tanggal_kembali_rencana)->format('d/m/Y') }}</span>
                                </div>
                                @if($rental->tanggal_kembali_aktual)
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-500">Kembali Aktual:</span>
                                        <span class="text-sm font-medium text-gray-900">{{ \Carbon\Carbon::parse($rental->tanggal_kembali_aktual)->format('d/m/Y') }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Additional Info -->
                        <div>
                            <h4 class="text-sm font-medium text-gray-700 mb-3">Informasi Tambahan</h4>
                            <div class="space-y-2">
                                @if($rental->total_biaya)
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-500">Total Biaya:</span>
                                        <span class="text-sm font-medium text-gray-900">Rp {{ number_format($rental->total_biaya, 0, ',', '.') }}</span>
                                    </div>
                                @endif
                                @if($rental->denda > 0)
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-500">Denda:</span>
                                        <span class="text-sm font-medium text-red-600">Rp {{ number_format($rental->denda, 0, ',', '.') }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Catatan -->
            @if($rental->keperluan || $rental->catatan || $rental->catatan_approval || $rental->catatan_admin)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Catatan</h3>
                        
                        @if($rental->keperluan)
                            <div class="mb-4">
                                <h4 class="text-sm font-medium text-gray-700 mb-2">Keperluan</h4>
                                <p class="text-sm text-gray-600 bg-gray-50 p-3 rounded-lg">{{ $rental->keperluan }}</p>
                            </div>
                        @endif

                        @if($rental->catatan)
                            <div class="mb-4">
                                <h4 class="text-sm font-medium text-gray-700 mb-2">Catatan Member</h4>
                                <p class="text-sm text-gray-600 bg-gray-50 p-3 rounded-lg">{{ $rental->catatan }}</p>
                            </div>
                        @endif

                        @if($rental->catatan_approval)
                            <div class="mb-4">
                                <h4 class="text-sm font-medium text-gray-700 mb-2">Catatan Approval</h4>
                                <p class="text-sm text-gray-600 bg-blue-50 p-3 rounded-lg">{{ $rental->catatan_approval }}</p>
                            </div>
                        @endif

                        @if($rental->catatan_admin)
                            <div class="mb-4">
                                <h4 class="text-sm font-medium text-gray-700 mb-2">Catatan Admin</h4>
                                <p class="text-sm text-gray-600 bg-yellow-50 p-3 rounded-lg">{{ $rental->catatan_admin }}</p>
                            </div>
                        @endif

                        @if($rental->kondisi_kembali)
                            <div class="mb-4">
                                <h4 class="text-sm font-medium text-gray-700 mb-2">Kondisi Pengembalian</h4>
                                <p class="text-sm text-gray-600 bg-green-50 p-3 rounded-lg">{{ $rental->kondisi_kembali }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Admin Actions -->
            @if(auth()->user()->role === 'gudang')
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Aksi Gudang</h3>
                        
                        <div class="flex flex-wrap gap-3">
                            @if($rental->status === 'pending' && auth()->user()->role === 'gudang')
                                <!-- Approve Button -->
                                <button type="button" onclick="openApproveModal()" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium">
                                    Setujui
                                </button>

                                <!-- Reject Button -->
                                <button type="button" onclick="openRejectModal()" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm font-medium">
                                    Tolak
                                </button>
                            @endif

                            @if($rental->status === 'approved' && auth()->user()->role === 'gudang')
                                <!-- Mark as Taken -->
                                <form action="{{ route('rental.take', $rental) }}" method="POST" class="inline-block">
                                    @csrf
                                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium">
                                        Konfirmasi Diambil
                                    </button>
                                </form>
                            @endif

                            @if($rental->status === 'ongoing' && auth()->user()->role === 'gudang')
                                <!-- Mark as Returned -->
                                <button onclick="openReturnModal()" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium">
                                    Konfirmasi Dikembalikan
                                </button>
                            @endif

                            <!-- Back Button -->
                            <a href="{{ route('rental.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg text-sm font-medium">
                                Kembali
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Approve Modal -->
    <div id="approveModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900 text-center">Setujui Rental</h3>
                <form action="{{ route('rental.approve', $rental) }}" method="POST" class="mt-4">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Catatan Approval (Opsional)</label>
                        <textarea name="catatan_approval" rows="3" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500" placeholder="Tambahkan catatan approval..."></textarea>
                    </div>
                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="closeApproveModal()" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg text-sm">
                            Batal
                        </button>
                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm">
                            Setujui
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Reject Modal -->
    <div id="rejectModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900 text-center">Tolak Rental</h3>
                <form action="{{ route('rental.reject', $rental) }}" method="POST" class="mt-4">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Alasan Penolakan <span class="text-red-500">*</span></label>
                        <textarea name="catatan_approval" rows="3" required class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-500" placeholder="Masukkan alasan penolakan..."></textarea>
                    </div>
                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="closeRejectModal()" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg text-sm">
                            Batal
                        </button>
                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm">
                            Tolak
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Return Modal -->
    <div id="returnModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900 text-center">Konfirmasi Pengembalian</h3>
                <form action="{{ route('rental.return', $rental) }}" method="POST" class="mt-4">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Kondisi Barang <span class="text-red-500">*</span></label>
                        <select name="kondisi_kembali" required class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
                            <option value="">Pilih kondisi barang</option>
                            <option value="baik">Baik</option>
                            <option value="rusak ringan">Rusak Ringan</option>
                            <option value="rusak berat">Rusak Berat</option>
                            <option value="hilang">Hilang</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Denda (Rp)</label>
                        <input type="number" name="denda" min="0" step="1000" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500" placeholder="0">
                        <p class="text-xs text-gray-500 mt-1">Kosongkan jika tidak ada denda</p>
                    </div>
                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="closeReturnModal()" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg text-sm">
                            Batal
                        </button>
                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm">
                            Konfirmasi Dikembalikan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openApproveModal() {
            document.getElementById('approveModal').classList.remove('hidden');
        }

        function closeApproveModal() {
            document.getElementById('approveModal').classList.add('hidden');
        }

        function openRejectModal() {
            document.getElementById('rejectModal').classList.remove('hidden');
        }

        function closeRejectModal() {
            document.getElementById('rejectModal').classList.add('hidden');
        }

        function openReturnModal() {
            document.getElementById('returnModal').classList.remove('hidden');
        }

        function closeReturnModal() {
            document.getElementById('returnModal').classList.add('hidden');
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            let approveModal = document.getElementById('approveModal');
            let rejectModal = document.getElementById('rejectModal');
            let returnModal = document.getElementById('returnModal');
            if (event.target == approveModal) {
                approveModal.classList.add('hidden');
            }
            if (event.target == rejectModal) {
                rejectModal.classList.add('hidden');
            }
            if (event.target == returnModal) {
                returnModal.classList.add('hidden');
            }
        }
    </script>
</x-app-layout>
