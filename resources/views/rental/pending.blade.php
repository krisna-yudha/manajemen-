<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Daftar Rental - Pending Approval
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <!-- Header Section -->
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-medium">Rental Menunggu Approval</h3>
                        <div class="text-sm text-gray-600">
                            Total: {{ $pendingRentals->total() }} permohonan
                        </div>
                    </div>

                    <!-- Success Message -->
                    @if(session('success'))
                        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- Error Message -->
                    @if($errors->any())
                        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded mb-4">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Table -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full table-auto">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode Rental</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Peminjam</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Barang</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Periode</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Keperluan</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($pendingRentals as $rental)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $rental->kode_rental }}</div>
                                        <div class="text-sm text-gray-500">{{ $rental->created_at->format('d/m/Y H:i') }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $rental->user->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $rental->user->email }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $rental->barang->nama_barang }}</div>
                                        <div class="text-sm text-gray-500">{{ $rental->barang->kode_barang }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $rental->jumlah }} unit</div>
                                        <div class="text-sm text-gray-500">
                                            Stok tersedia: {{ $rental->barang->stok_tersedia }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">
                                            {{ $rental->tanggal_pinjam->format('d/m/Y') }} - 
                                            {{ $rental->tanggal_kembali_rencana->format('d/m/Y') }}
                                        </div>
                                        <div class="text-sm text-gray-500">{{ $rental->duration }} hari</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900 max-w-xs truncate">{{ $rental->keperluan }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex space-x-2">
                                            <!-- Approve Button -->
                                            <form method="POST" action="{{ route('rental.approve', $rental) }}" class="inline-block">
                                                @csrf
                                                <div class="space-y-2">
                                                    <input type="text" name="catatan_approval" placeholder="Catatan (opsional)" 
                                                           class="text-xs px-2 py-1 border rounded w-32">
                                                    <button type="submit" class="bg-green-600 text-white px-3 py-1 rounded text-xs hover:bg-green-700"
                                                            onclick="return confirm('Approve rental ini?')">
                                                        Approve
                                                    </button>
                                                </div>
                                            </form>
                                            
                                            <!-- Reject Button -->
                                            <form method="POST" action="{{ route('rental.reject', $rental) }}" class="inline-block">
                                                @csrf
                                                <div class="space-y-2">
                                                    <input type="text" name="catatan_approval" placeholder="Alasan reject" 
                                                           class="text-xs px-2 py-1 border rounded w-32" required>
                                                    <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded text-xs hover:bg-red-700"
                                                            onclick="return confirm('Reject rental ini?')">
                                                        Reject
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                                        Tidak ada rental yang menunggu approval
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $pendingRentals->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
