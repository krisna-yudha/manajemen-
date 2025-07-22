<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Barang Tersedia untuk Rental
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Search and Filter -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex flex-col md:flex-row gap-4">
                        <div class="flex-1">
                            <form method="GET" action="{{ route('member.barang.available') }}">
                                <div class="flex gap-2">
                                    <input 
                                        type="text" 
                                        name="search" 
                                        value="{{ request('search') }}"
                                        placeholder="Cari nama barang, kode, atau kategori..."
                                        class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    >
                                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                        Cari
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div class="flex gap-2">
                            <select 
                                id="categoryFilter" 
                                onchange="filterByCategory()"
                                class="rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            >
                                <option value="">Semua Kategori</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category }}">{{ $category }}</option>
                                @endforeach
                            </select>
                            <select 
                                id="availabilityFilter" 
                                onchange="filterByAvailability()"
                                class="rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            >
                                <option value="">Semua</option>
                                <option value="available">Tersedia</option>
                                <option value="low_stock">Stok Sedikit (< 5)</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Items Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @forelse($barangs as $barang)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow item-card" 
                         data-category="{{ $barang->kategori }}"
                         data-availability="{{ $barang->stok > 0 ? ($barang->stok < 5 ? 'low_stock' : 'available') : 'unavailable' }}">
                        
                        <!-- Item Image -->
                        <div class="h-48 bg-gray-200 flex items-center justify-center">
                            <svg class="w-16 h-16 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4z"></path>
                            </svg>
                        </div>

                        <!-- Item Details -->
                        <div class="p-4">
                            <div class="flex justify-between items-start mb-2">
                                <h3 class="font-semibold text-lg text-gray-900 truncate">{{ $barang->nama_barang }}</h3>
                                <span class="text-xs font-medium text-gray-500 bg-gray-100 px-2 py-1 rounded">
                                    {{ $barang->kode_barang }}
                                </span>
                            </div>
                            
                            <p class="text-sm text-gray-600 mb-3 line-clamp-2">{{ $barang->deskripsi ?? 'Tidak ada deskripsi' }}</p>
                            
                            <div class="space-y-2 mb-4">
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-500">Kategori:</span>
                                    <span class="font-medium">{{ $barang->kategori }}</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-500">Stok:</span>
                                    <span class="font-medium {{ $barang->stok <= 0 ? 'text-red-600' : ($barang->stok < 5 ? 'text-yellow-600' : 'text-green-600') }}">
                                        {{ $barang->stok }} unit
                                    </span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-500">Lokasi:</span>
                                    <span class="font-medium">{{ $barang->lokasi ?? '-' }}</span>
                                </div>
                            </div>

                            <!-- Status Badge -->
                            <div class="mb-4">
                                @if($barang->stok > 0)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <div class="w-1.5 h-1.5 bg-green-400 rounded-full mr-1"></div>
                                        Tersedia
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        <div class="w-1.5 h-1.5 bg-red-400 rounded-full mr-1"></div>
                                        Tidak Tersedia
                                    </span>
                                @endif
                            </div>

                            <!-- Actions -->
                            <div class="space-y-2">
                                @if($barang->stok > 0)
                                    <a href="{{ route('member.rental.create', ['barang_id' => $barang->id]) }}" 
                                       class="w-full bg-blue-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-blue-700 transition-colors text-center block">
                                        Ajukan Rental
                                    </a>
                                @else
                                    <button disabled 
                                            class="w-full bg-gray-300 text-gray-500 px-4 py-2 rounded-md text-sm font-medium cursor-not-allowed">
                                        Tidak Tersedia
                                    </button>
                                @endif
                                
                                <button onclick="showItemDetail({{ $barang->id }})" 
                                        class="w-full bg-gray-100 text-gray-700 px-4 py-2 rounded-md text-sm font-medium hover:bg-gray-200 transition-colors">
                                    Lihat Detail
                                </button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full">
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2 2v-5m16 0h-2M4 13h2m13-4V8a1 1 0 00-1-1H7a1 1 0 00-1 1v1"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada barang</h3>
                            <p class="mt-1 text-sm text-gray-500">
                                @if(request('search'))
                                    Tidak ada barang yang sesuai dengan pencarian "{{ request('search') }}".
                                @else
                                    Saat ini tidak ada barang yang tersedia untuk rental.
                                @endif
                            </p>
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($barangs->hasPages())
                <div class="mt-8">
                    {{ $barangs->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Item Detail Modal -->
    <div id="itemDetailModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
        <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-1/2 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-medium text-gray-900" id="modalTitle">Detail Barang</h3>
                    <button onclick="closeItemDetail()" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <div id="modalContent">
                    <!-- Content will be loaded here -->
                </div>
            </div>
        </div>
    </div>

    <script>
        function filterByCategory() {
            const category = document.getElementById('categoryFilter').value;
            const cards = document.querySelectorAll('.item-card');
            
            cards.forEach(card => {
                if (category === '' || card.dataset.category === category) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        }

        function filterByAvailability() {
            const availability = document.getElementById('availabilityFilter').value;
            const cards = document.querySelectorAll('.item-card');
            
            cards.forEach(card => {
                if (availability === '' || card.dataset.availability === availability) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        }

        function showItemDetail(barangId) {
            // Show modal
            document.getElementById('itemDetailModal').classList.remove('hidden');
            
            // Load content (you can implement AJAX here)
            document.getElementById('modalContent').innerHTML = `
                <div class="text-center py-4">
                    <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600 mx-auto"></div>
                    <p class="mt-2 text-sm text-gray-500">Memuat detail...</p>
                </div>
            `;
            
            // You can implement AJAX call here to load detailed information
            setTimeout(() => {
                document.getElementById('modalContent').innerHTML = `
                    <p class="text-gray-700 mb-4">Detail lengkap barang akan ditampilkan di sini.</p>
                    <p class="text-sm text-gray-500">Fitur ini dapat dikembangkan lebih lanjut dengan AJAX untuk memuat detail dari server.</p>
                `;
            }, 1000);
        }

        function closeItemDetail() {
            document.getElementById('itemDetailModal').classList.add('hidden');
        }

        // Close modal when clicking outside
        document.getElementById('itemDetailModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeItemDetail();
            }
        });
    </script>
</x-app-layout>
