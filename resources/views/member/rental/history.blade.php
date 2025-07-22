<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Riwayat Rental Saya
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Statistics Cards -->
            <div class="grid grid-cols-2 md:grid-cols-6 gap-4 mb-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-4 text-center">
                        <div class="text-2xl font-bold text-gray-900">{{ $stats['total'] }}</div>
                        <div class="text-xs text-gray-500">Total</div>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-4 text-center">
                        <div class="text-2xl font-bold text-yellow-600">{{ $stats['pending'] }}</div>
                        <div class="text-xs text-gray-500">Pending</div>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-4 text-center">
                        <div class="text-2xl font-bold text-blue-600">{{ $stats['approved'] }}</div>
                        <div class="text-xs text-gray-500">Disetujui</div>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-4 text-center">
                        <div class="text-2xl font-bold text-green-600">{{ $stats['active'] }}</div>
                        <div class="text-xs text-gray-500">Aktif</div>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-4 text-center">
                        <div class="text-2xl font-bold text-gray-600">{{ $stats['completed'] }}</div>
                        <div class="text-xs text-gray-500">Selesai</div>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-4 text-center">
                        <div class="text-2xl font-bold text-red-600">{{ $stats['rejected'] }}</div>
                        <div class="text-xs text-gray-500">Ditolak</div>
                    </div>
                </div>
            </div>

            <!-- Filters and Search -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex flex-col md:flex-row gap-4">
                        <div class="flex-1">
                            <form method="GET" action="{{ route('member.rental.history') }}" class="flex gap-2">
                                <input type="hidden" name="status" value="{{ request('status') }}">
                                <input 
                                    type="text" 
                                    name="search" 
                                    value="{{ request('search') }}"
                                    placeholder="Cari kode rental atau nama barang..."
                                    class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                >
                                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                    Cari
                                </button>
                            </form>
                        </div>
                        <div class="flex gap-2">
                            <form method="GET" action="{{ route('member.rental.history') }}" class="flex gap-2">
                                <input type="hidden" name="search" value="{{ request('search') }}">
                                <select 
                                    name="status" 
                                    onchange="this.form.submit()"
                                    class="rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                >
                                    <option value="">Semua Status</option>
                                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Disetujui</option>
                                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Aktif</option>
                                    <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Selesai</option>
                                    <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Ditolak</option>
                                </select>
                            </form>
                            <a href="{{ route('member.rental.create') }}" 
                               class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition-colors">
                                + Rental Baru
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Rentals List -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if($rentals->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode Rental</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Barang</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Rental</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($rentals as $rental)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="text-sm font-medium text-gray-900">{{ $rental->kode_rental }}</div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $rental->barang->nama_barang ?? 'N/A' }}</div>
                                                <div class="text-sm text-gray-500">{{ $rental->barang->kode_barang ?? 'N/A' }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $rental->jumlah }} unit</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">
                                                    {{ $rental->tanggal_pinjam ? \Carbon\Carbon::parse($rental->tanggal_pinjam)->format('d/m/Y') : '-' }}
                                                </div>
                                                <div class="text-sm text-gray-500">
                                                    s/d {{ $rental->tanggal_kembali_rencana ? \Carbon\Carbon::parse($rental->tanggal_kembali_rencana)->format('d/m/Y') : '-' }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if($rental->status === 'pending')
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                        <div class="w-1.5 h-1.5 bg-yellow-400 rounded-full mr-1"></div>
                                                        Menunggu Approval
                                                    </span>
                                                @elseif($rental->status === 'approved')
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                        <div class="w-1.5 h-1.5 bg-blue-400 rounded-full mr-1"></div>
                                                        Disetujui
                                                    </span>
                                                @elseif($rental->status === 'active')
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                        <div class="w-1.5 h-1.5 bg-green-400 rounded-full mr-1"></div>
                                                        Sedang Dipinjam
                                                    </span>
                                                @elseif($rental->status === 'completed')
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                        <div class="w-1.5 h-1.5 bg-gray-400 rounded-full mr-1"></div>
                                                        Selesai
                                                    </span>
                                                @elseif($rental->status === 'rejected')
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                        <div class="w-1.5 h-1.5 bg-red-400 rounded-full mr-1"></div>
                                                        Ditolak
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <a href="{{ route('member.rental.show', $rental) }}" 
                                                   class="text-indigo-600 hover:text-indigo-900 mr-3">
                                                    Detail
                                                </a>
                                                @if($rental->status === 'pending')
                                                    <span class="text-gray-400">|</span>
                                                    <button onclick="showCancelModal('{{ $rental->id }}')" 
                                                            class="text-red-600 hover:text-red-900 ml-3">
                                                        Batalkan
                                                    </button>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        @if($rentals->hasPages())
                            <div class="mt-6">
                                {{ $rentals->links() }}
                            </div>
                        @endif
                    @else
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada rental</h3>
                            <p class="mt-1 text-sm text-gray-500">
                                @if(request('search') || request('status'))
                                    Tidak ada rental yang sesuai dengan filter yang dipilih.
                                @else
                                    Mulai ajukan rental pertama Anda!
                                @endif
                            </p>
                            <div class="mt-6">
                                <a href="{{ route('member.rental.create') }}" 
                                   class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                                    <svg class="-ml-1 mr-2 h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"></path>
                                    </svg>
                                    Ajukan Rental Baru
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Cancel Rental Modal -->
    <div id="cancelModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                    <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.93L13.732 4.242c-.77-1.333-2.694-1.333-3.464 0L3.34 16.07c-.77 1.263.192 2.93 1.732 2.93z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mt-2">Batalkan Rental</h3>
                <div class="mt-2 px-7 py-3">
                    <p class="text-sm text-gray-500">
                        Apakah Anda yakin ingin membatalkan permintaan rental ini? Tindakan ini tidak dapat dibatalkan.
                    </p>
                </div>
                <div class="items-center px-4 py-3">
                    <button id="confirmCancel" 
                            class="px-4 py-2 bg-red-500 text-white text-base font-medium rounded-md shadow-sm hover:bg-red-600 mr-2">
                        Ya, Batalkan
                    </button>
                    <button onclick="closeCancelModal()" 
                            class="px-4 py-2 bg-gray-300 text-gray-800 text-base font-medium rounded-md shadow-sm hover:bg-gray-400">
                        Tidak
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        let selectedRentalId = null;

        function showCancelModal(rentalId) {
            selectedRentalId = rentalId;
            document.getElementById('cancelModal').classList.remove('hidden');
        }

        function closeCancelModal() {
            selectedRentalId = null;
            document.getElementById('cancelModal').classList.add('hidden');
        }

        document.getElementById('confirmCancel').addEventListener('click', function() {
            if (selectedRentalId) {
                // You can implement the cancel functionality here
                // For now, we'll just close the modal
                console.log('Cancelling rental:', selectedRentalId);
                closeCancelModal();
                // In a real implementation, you would send a request to cancel the rental
            }
        });

        // Close modal when clicking outside
        document.getElementById('cancelModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeCancelModal();
            }
        });
    </script>
</x-app-layout>
