<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            My Rentals
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <!-- Header Section -->
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-medium">
                            @if(Auth::user()->role === 'manager' || Auth::user()->role === 'gudang')
                                Semua Rental
                            @else
                                Rental Saya
                            @endif
                        </h3>
                        @if(Auth::user()->role === 'member')
                            <a href="{{ route('rental.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                                Ajukan Rental Baru
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
                        <div class="bg-yellow-50 p-4 rounded-lg">
                            <h4 class="font-semibold text-yellow-800">Pending</h4>
                            <p class="text-2xl font-bold text-yellow-600">{{ $rentals->where('status', 'pending')->count() }}</p>
                        </div>
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <h4 class="font-semibold text-blue-800">Approved</h4>
                            <p class="text-2xl font-bold text-blue-600">{{ $rentals->where('status', 'approved')->count() }}</p>
                        </div>
                        <div class="bg-green-50 p-4 rounded-lg">
                            <h4 class="font-semibold text-green-800">Ongoing</h4>
                            <p class="text-2xl font-bold text-green-600">{{ $rentals->where('status', 'ongoing')->count() }}</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h4 class="font-semibold text-gray-800">Returned</h4>
                            <p class="text-2xl font-bold text-gray-600">{{ $rentals->where('status', 'returned')->count() }}</p>
                        </div>
                    </div>

                    <!-- Table -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full table-auto">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode</th>
                                    @if(Auth::user()->role === 'manager' || Auth::user()->role === 'gudang')
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Peminjam</th>
                                    @endif
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Barang</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Periode</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($rentals as $rental)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $rental->kode_rental }}</div>
                                        <div class="text-sm text-gray-500">{{ $rental->created_at->format('d/m/Y') }}</div>
                                    </td>
                                    @if(Auth::user()->role === 'manager' || Auth::user()->role === 'gudang')
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $rental->user->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $rental->user->email }}</div>
                                    </td>
                                    @endif
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $rental->barang->nama_barang }}</div>
                                        <div class="text-sm text-gray-500">{{ $rental->jumlah }} unit</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">
                                            {{ $rental->tanggal_pinjam->format('d/m/Y') }} - 
                                            {{ $rental->tanggal_kembali_rencana->format('d/m/Y') }}
                                        </div>
                                        <div class="text-sm text-gray-500">{{ $rental->duration }} hari</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $rental->getStatusBadgeClass() }}">
                                            {{ ucfirst($rental->status) }}
                                        </span>
                                        @if($rental->isOverdue())
                                            <div class="text-xs text-red-600 mt-1">⚠️ Overdue</div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">Rp {{ number_format($rental->total_biaya, 0, ',', '.') }}</div>
                                        @if($rental->denda > 0)
                                            <div class="text-sm text-red-600">Denda: Rp {{ number_format($rental->denda, 0, ',', '.') }}</div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('rental.show', $rental) }}" class="text-blue-600 hover:text-blue-900">Detail</a>
                                        
                                        @if(Auth::user()->role === 'manager' || Auth::user()->role === 'gudang')
                                            @if($rental->status === 'approved')
                                                <form method="POST" action="{{ route('rental.start', $rental) }}" class="inline-block ml-2">
                                                    @csrf
                                                    <button type="submit" class="text-green-600 hover:text-green-900">
                                                        Mulai
                                                    </button>
                                                </form>
                                            @elseif($rental->status === 'ongoing')
                                                <button onclick="openReturnModal('{{ $rental->id }}')" class="text-orange-600 hover:text-orange-900 ml-2">
                                                    Return
                                                </button>
                                            @endif
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="{{ Auth::user()->role === 'member' ? 6 : 7 }}" class="px-6 py-4 text-center text-gray-500">
                                        Belum ada data rental
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $rentals->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Return Modal -->
    <div id="returnModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden items-center justify-center">
        <div class="bg-white p-6 rounded-lg shadow-lg max-w-md w-full mx-4">
            <h3 class="text-lg font-medium mb-4">Return Barang</h3>
            <form id="returnForm" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="kondisi_kembali" class="block text-sm font-medium text-gray-700">Kondisi Barang</label>
                    <textarea name="kondisi_kembali" id="kondisi_kembali" rows="3" required
                              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                              placeholder="Kondisi barang saat dikembalikan..."></textarea>
                </div>
                <div class="mb-4">
                    <label for="denda" class="block text-sm font-medium text-gray-700">Denda (Rp)</label>
                    <input type="number" name="denda" id="denda" min="0" step="1000"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                           placeholder="0">
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeReturnModal()" class="bg-gray-300 text-gray-700 px-4 py-2 rounded">
                        Batal
                    </button>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
                        Return Barang
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openReturnModal(rentalId) {
            document.getElementById('returnForm').action = `/rental/${rentalId}/return`;
            document.getElementById('returnModal').classList.remove('hidden');
            document.getElementById('returnModal').classList.add('flex');
        }

        function closeReturnModal() {
            document.getElementById('returnModal').classList.add('hidden');
            document.getElementById('returnModal').classList.remove('flex');
            document.getElementById('returnForm').reset();
        }
    </script>
</x-app-layout>
