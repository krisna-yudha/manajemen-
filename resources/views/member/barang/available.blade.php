<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Barang Tersedia</h2>
                <p class="text-gray-600 mt-1">Pilih barang yang ingin Anda rental</p>
            </div>
            <div class="mt-4 sm:mt-0">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                    {{ $barangs->total() }} Barang
                </span>
            </div>
        </div>
    </x-slot>

    <style>
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .item-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .item-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
        }
        .aspect-square {
            aspect-ratio: 1 / 1;
        }
        .aspect-square img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
        }
    </style>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Search and Filter -->
            <div class="bg-white overflow-hidden shadow-sm rounded-lg mb-6 border border-gray-100">
                <div class="p-4">
                    <div class="flex flex-col lg:flex-row gap-3">
                        <!-- Search Bar -->
                        <div class="flex-1">
                            <form method="GET" action="{{ route('member.barang.available') }}">
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-4 w-4 text-gray-400 group-focus-within:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                        </svg>
                                    </div>
                                    <input 
                                        type="text" 
                                        name="search" 
                                        value="{{ request('search') }}"
                                        placeholder="Cari nama barang, kode, atau kategori..."
                                        class="pl-9 pr-20 w-full rounded-lg border-gray-200 bg-gray-50 focus:bg-white focus:border-blue-400 focus:ring-2 focus:ring-blue-100 text-sm py-2.5 transition-all duration-200 placeholder-gray-400"
                                    >
                                    <button type="submit" class="absolute inset-y-0 right-0 pr-2 flex items-center">
                                        <span class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1.5 rounded-md text-xs font-medium transition-all duration-200 shadow-sm hover:shadow">
                                            <svg class="w-3 h-3 mr-1 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                            </svg>
                                            Cari
                                        </span>
                                    </button>
                                </div>
                            </form>
                        </div>
                        
                        <!-- Filters -->
                        <div class="flex flex-col sm:flex-row gap-2">
                            <div class="relative">
                                <select 
                                    id="categoryFilter" 
                                    onchange="filterByCategory()"
                                    class="appearance-none bg-gray-50 border border-gray-200 rounded-lg px-3 py-2.5 pr-8 text-xs focus:border-blue-400 focus:ring-2 focus:ring-blue-100 focus:bg-white w-full sm:w-auto transition-all duration-200"
                                >
                                    <option value="">🏷️ Semua Kategori</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category }}">{{ $category }}</option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                                    <svg class="h-3 w-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </div>
                            <div class="relative">
                                <select 
                                    id="availabilityFilter" 
                                    onchange="filterByAvailability()"
                                    class="appearance-none bg-gray-50 border border-gray-200 rounded-lg px-3 py-2.5 pr-8 text-xs focus:border-blue-400 focus:ring-2 focus:ring-blue-100 focus:bg-white w-full sm:w-auto transition-all duration-200"
                                >
                                    <option value="">📊 Semua Status</option>
                                    <option value="available">✅ Tersedia</option>
                                    <option value="low_stock">⚠️ Stok Sedikit</option>
                                    <option value="unavailable">❌ Habis</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                                    <svg class="h-3 w-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    @if(request('search'))
                        <div class="mt-3 flex items-center justify-between bg-blue-50 rounded-lg p-2.5 border border-blue-100">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span class="text-xs text-blue-700">
                                    Hasil pencarian: <strong>"{{ request('search') }}"</strong>
                                </span>
                            </div>
                            <a href="{{ route('member.barang.available') }}" class="text-blue-600 hover:text-blue-800 text-xs font-medium">
                                ✕ Hapus
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Items Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                @forelse($barangs as $barang)
                    <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden item-card flex flex-col h-full hover:border-gray-200 transition-colors duration-200" 
                         data-category="{{ $barang->kategori }}"
                         data-availability="{{ $barang->stok <= 0 ? 'unavailable' : ($barang->stok <= 5 ? 'low_stock' : 'available') }}">
                        
                        <!-- Item Image -->
                        <div class="relative aspect-square bg-gradient-to-br from-gray-50 to-gray-100 flex items-center justify-center overflow-hidden">
                            @if($barang->foto)
                                <img src="{{ asset('storage/' . $barang->foto) }}" 
                                     alt="{{ $barang->nama_barang }}"
                                     class="w-full h-full object-cover object-center transition-transform duration-300 hover:scale-105">
                            @else
                                <div class="text-center">
                                    <svg class="w-12 h-12 text-gray-300 mx-auto mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <p class="text-xs text-gray-400">No Image</p>
                                </div>
                            @endif
                            
                            <!-- Status Badge -->
                            <div class="absolute top-2 left-2">
                                @if($barang->stok > 0)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-green-500 text-white shadow-sm">
                                        <div class="w-1 h-1 bg-white rounded-full mr-1"></div>
                                        Tersedia
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-red-500 text-white shadow-sm">
                                        <div class="w-1 h-1 bg-white rounded-full mr-1"></div>
                                        Habis
                                    </span>
                                @endif
                            </div>
                            
                            <!-- Code Badge -->
                            <div class="absolute top-2 right-2">
                                <span class="text-xs font-bold text-white bg-black bg-opacity-60 px-1.5 py-0.5 rounded backdrop-blur-sm">
                                    {{ $barang->kode_barang }}
                                </span>
                            </div>
                        </div>

                        <!-- Item Details -->
                        <div class="p-3 flex-grow flex flex-col">
                            <!-- Header Info -->
                            <div class="mb-3">
                                <h3 class="font-bold text-sm text-gray-900 mb-1 line-clamp-2 leading-tight">{{ $barang->nama_barang }}</h3>
                                <div class="flex items-center justify-between mb-2">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-700">
                                        {{ $barang->kategori }}
                                    </span>
                                </div>
                                <p class="text-xs text-gray-600 leading-relaxed line-clamp-2">{{ $barang->deskripsi ?? 'Barang berkualitas untuk kebutuhan rental Anda' }}</p>
                            </div>
                            
                            <!-- Quick Info Cards -->
                            <div class="grid grid-cols-2 gap-2 mb-3">
                                <!-- Stock Card -->
                                <div class="bg-gradient-to-r {{ $barang->stok <= 0 ? 'from-red-50 to-red-100 border-red-200' : ($barang->stok < 5 ? 'from-yellow-50 to-yellow-100 border-yellow-200' : 'from-green-50 to-green-100 border-green-200') }} p-2 rounded border text-center">
                                    <p class="text-xs font-medium {{ $barang->stok <= 0 ? 'text-red-600' : ($barang->stok < 5 ? 'text-yellow-600' : 'text-green-600') }}">Stok</p>
                                    <p class="text-sm font-bold {{ $barang->stok <= 0 ? 'text-red-700' : ($barang->stok < 5 ? 'text-yellow-700' : 'text-green-700') }}">{{ $barang->stok }}</p>
                                </div>
                                
                                <!-- Location Card -->
                                <div class="bg-gradient-to-r from-blue-50 to-blue-100 p-2 rounded border border-blue-200 text-center">
                                    <p class="text-xs font-medium text-blue-600">Lokasi</p>
                                    <p class="text-xs font-semibold text-blue-700 truncate">{{ $barang->lokasi ?? 'Gudang' }}</p>
                                </div>
                            </div>

                            <!-- Stock Warning -->
                            @if($barang->stok > 0 && $barang->stok <= $barang->stok_minimum)
                            <div class="mb-2 p-1.5 bg-yellow-50 border border-yellow-200 rounded text-center">
                                <span class="text-xs font-medium text-yellow-700">⚠️ Stok Terbatas!</span>
                            </div>
                            @endif

                            <!-- Action Buttons -->
                            <div class="mt-auto space-y-1.5">
                                @if($barang->stok > 0)
                                    <a href="{{ route('member.rental.create', ['barang_id' => $barang->id]) }}" 
                                       class="w-full bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white px-3 py-2 rounded text-xs font-bold transition-all duration-200 text-center block shadow-sm hover:shadow transform hover:-translate-y-0.5">
                                        <div class="flex items-center justify-center">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                            </svg>
                                            Ajukan Rental
                                        </div>
                                    </a>
                                @else
                                    <button disabled 
                                            class="w-full bg-gray-200 text-gray-500 px-3 py-2 rounded text-xs font-bold cursor-not-allowed">
                                        <div class="flex items-center justify-center">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636m12.728 12.728L18.364 5.636M5.636 18.364l12.728-12.728" />
                                            </svg>
                                            Tidak Tersedia
                                        </div>
                                    </button>
                                @endif
                                
                                <button onclick="showItemDetail({{ $barang->id }}, '{{ addslashes($barang->nama_barang) }}', '{{ $barang->kategori }}', '{{ $barang->kode_barang }}', {{ $barang->stok }}, '{{ addslashes($barang->lokasi ?? '') }}', '{{ addslashes($barang->deskripsi ?? '') }}', '{{ $barang->foto ? asset('storage/' . $barang->foto) : '' }}')" 
                                        class="w-full bg-white hover:bg-gray-50 text-gray-600 px-3 py-1.5 rounded text-xs font-medium transition-colors duration-200 border border-gray-200 hover:border-gray-300">
                                    <div class="flex items-center justify-center">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 616 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        Detail
                                    </div>
                                </button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full">
                        <div class="text-center py-16 bg-white rounded-xl border border-gray-200">
                            <svg class="mx-auto h-16 w-16 text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2 2v-5m16 0h-2M4 13h2m13-4V8a1 1 0 00-1-1H7a1 1 0 00-1 1v1"></path>
                            </svg>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak ada barang</h3>
                            <p class="text-sm text-gray-500">
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
    <div id="itemDetailModal" class="fixed inset-0 bg-black bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative min-h-screen flex items-center justify-center p-4">
            <div class="relative w-full max-w-4xl bg-white rounded-xl shadow-2xl max-h-[90vh] overflow-y-auto">
                <div class="sticky top-0 bg-white border-b border-gray-200 px-6 py-4 rounded-t-xl z-10">
                    <div class="flex justify-between items-center">
                        <h3 class="text-xl lg:text-2xl font-bold text-gray-900" id="modalTitle">Detail Barang</h3>
                        <button onclick="closeItemDetail()" class="text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-full p-2 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>
                <div id="modalContent" class="p-6">
                    <!-- Content will be loaded here -->
                </div>
            </div>
        </div>
    </div>

    <script>
        function filterByCategory() {
            const category = document.getElementById('categoryFilter').value;
            const availability = document.getElementById('availabilityFilter').value;
            filterCards(category, availability);
        }

        function filterByAvailability() {
            const category = document.getElementById('categoryFilter').value;
            const availability = document.getElementById('availabilityFilter').value;
            filterCards(category, availability);
        }

        function filterCards(category, availability) {
            const cards = document.querySelectorAll('.item-card');
            let visibleCount = 0;
            
            console.log('Filtering with:', { category, availability });
            
            cards.forEach(card => {
                const matchCategory = category === '' || card.dataset.category === category;
                const cardAvailability = card.dataset.availability;
                
                let matchAvailability = false;
                if (availability === '') {
                    matchAvailability = true;
                } else if (availability === 'available') {
                    matchAvailability = cardAvailability === 'available';
                } else if (availability === 'low_stock') {
                    matchAvailability = cardAvailability === 'low_stock';
                } else if (availability === 'unavailable') {
                    matchAvailability = cardAvailability === 'unavailable';
                }
                
                console.log('Card:', {
                    category: card.dataset.category,
                    availability: cardAvailability,
                    matchCategory,
                    matchAvailability,
                    visible: matchCategory && matchAvailability
                });
                
                if (matchCategory && matchAvailability) {
                    card.style.display = 'block';
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });
            
            console.log('Visible cards:', visibleCount);
            
            // Show/hide no results message
            const noResults = document.getElementById('noResults');
            if (visibleCount === 0 && (category !== '' || availability !== '')) {
                if (!noResults) {
                    const container = document.querySelector('.grid');
                    const div = document.createElement('div');
                    div.id = 'noResults';
                    div.className = 'col-span-full text-center py-16 bg-white rounded-xl border border-gray-200';
                    div.innerHTML = `
                        <svg class="mx-auto h-16 w-16 text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak ada hasil</h3>
                        <p class="text-sm text-gray-500">Tidak ada barang yang sesuai dengan filter yang dipilih.</p>
                    `;
                    container.appendChild(div);
                }
            } else if (noResults) {
                noResults.remove();
            }
        }

        function showItemDetail(id, nama, kategori, kode, stok, lokasi, deskripsi, foto) {
            document.getElementById('modalTitle').textContent = nama;
            
            const content = `
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Image Section -->
                    <div class="space-y-4">
                        <div class="aspect-square bg-gray-50 rounded-xl overflow-hidden border border-gray-200">
                            ${foto ? 
                                `<img src="${foto}" alt="${nama}" class="w-full h-full object-cover">` :
                                `<div class="w-full h-full flex items-center justify-center">
                                    <div class="text-center">
                                        <svg class="w-20 h-20 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <p class="text-sm text-gray-400 font-medium">Tidak ada foto</p>
                                    </div>
                                 </div>`
                            }
                        </div>
                        
                        <!-- Status Badge -->
                        <div class="flex justify-center">
                            ${stok > 0 ? 
                                `<span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold bg-green-100 text-green-800 border border-green-200">
                                    <div class="w-2 h-2 bg-green-400 rounded-full mr-2"></div>
                                    Tersedia untuk Rental
                                 </span>` :
                                `<span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold bg-red-100 text-red-800 border border-red-200">
                                    <div class="w-2 h-2 bg-red-400 rounded-full mr-2"></div>
                                    Tidak Tersedia
                                 </span>`
                            }
                        </div>
                    </div>
                    
                    <!-- Details Section -->
                    <div class="space-y-6">
                        <div>
                            <h4 class="text-2xl font-bold text-gray-900 mb-3">${nama}</h4>
                            <p class="text-gray-600 leading-relaxed">${deskripsi || 'Barang berkualitas untuk kebutuhan rental Anda.'}</p>
                        </div>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                                <div class="text-xs text-gray-500 mb-1 font-medium">Kode Barang</div>
                                <div class="font-bold text-lg text-gray-900">${kode}</div>
                            </div>
                            <div class="bg-blue-50 p-4 rounded-lg border border-blue-200">
                                <div class="text-xs text-blue-600 mb-1 font-medium">Kategori</div>
                                <div class="font-bold text-lg text-blue-900">${kategori}</div>
                            </div>
                            <div class="bg-green-50 p-4 rounded-lg border border-green-200">
                                <div class="text-xs text-green-600 mb-1 font-medium">Stok Tersedia</div>
                                <div class="font-bold text-lg text-green-900">${stok} unit</div>
                            </div>
                            <div class="bg-purple-50 p-4 rounded-lg border border-purple-200">
                                <div class="text-xs text-purple-600 mb-1 font-medium">Lokasi</div>
                                <div class="font-bold text-lg text-purple-900">${lokasi || 'Tidak ditentukan'}</div>
                            </div>
                        </div>
                        
                        <!-- Action Button -->
                        <div class="pt-4">
                            ${stok > 0 ? 
                                `<a href="/member/rental/create?barang_id=${id}" 
                                   class="w-full bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white px-6 py-4 rounded-lg font-bold text-lg transition-all duration-200 text-center block shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                    <div class="flex items-center justify-center">
                                        <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                        </svg>
                                        Ajukan Rental Sekarang
                                    </div>
                                  </a>` :
                                `<button disabled class="w-full bg-gray-200 text-gray-500 px-6 py-4 rounded-lg font-bold text-lg cursor-not-allowed">
                                    <div class="flex items-center justify-center">
                                        <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636m12.728 12.728L18.364 5.636M5.636 18.364l12.728-12.728" />
                                        </svg>
                                        Tidak Dapat Dirental
                                    </div>
                                 </button>`
                            }
                        </div>
                    </div>
                </div>
            `;
            
            document.getElementById('modalContent').innerHTML = content;
            document.getElementById('itemDetailModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeItemDetail() {
            document.getElementById('itemDetailModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        // Close modal when clicking outside
        document.getElementById('itemDetailModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeItemDetail();
            }
        });

        // Close modal with ESC key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeItemDetail();
            }
        });
    </script>
</x-app-layout>
