<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard Gudang
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium mb-4">Welcome Staff Gudang, {{ Auth::user()->name }}!</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                        <div class="bg-orange-50 p-6 rounded-lg">
                            <h4 class="font-semibold text-orange-800 mb-2">Total Items</h4>
                            <p class="text-2xl font-bold text-orange-600">0</p>
                        </div>
                        <div class="bg-yellow-50 p-6 rounded-lg">
                            <h4 class="font-semibold text-yellow-800 mb-2">Low Stock</h4>
                            <p class="text-2xl font-bold text-yellow-600">0</p>
                        </div>
                        <div class="bg-red-50 p-6 rounded-lg">
                            <h4 class="font-semibold text-red-800 mb-2">Out of Stock</h4>
                            <p class="text-2xl font-bold text-red-600">0</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-white border rounded-lg p-6">
                            <h4 class="font-semibold text-gray-800 mb-4">Inventory Management</h4>
                            <div class="space-y-3">
                                <a href="{{ route('barang.create') }}" class="block w-full bg-orange-600 text-white text-center py-2 px-4 rounded hover:bg-orange-700">
                                    Add New Item
                                </a>
                                <a href="{{ route('barang.index') }}" class="block w-full bg-yellow-600 text-white text-center py-2 px-4 rounded hover:bg-yellow-700">
                                    Manage Stock
                                </a>
                                <a href="{{ route('rental.pending.gudang') }}" class="block w-full bg-green-600 text-white text-center py-2 px-4 rounded hover:bg-green-700">
                                    Approve Rentals
                                </a>
                            </div>
                        </div>
                        
                        <div class="bg-white border rounded-lg p-6">
                            <h4 class="font-semibold text-gray-800 mb-4">Recent Stock Movements</h4>
                            <div class="space-y-2 text-sm">
                                <p class="text-gray-600">• No recent movements</p>
                                <p class="text-gray-500 text-xs">Stock movements will appear here</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 p-4 bg-blue-50 rounded-lg">
                        <h4 class="font-semibold text-blue-800 mb-2">Gudang Access</h4>
                        <p class="text-blue-600 text-sm">Sebagai staff gudang, Anda memiliki akses untuk:</p>
                        <ul class="text-blue-600 text-sm mt-2 space-y-1">
                            <li>• Mengelola inventory dan stok barang</li>
                            <li>• Membuat laporan gudang</li>
                            <li>• Update status barang masuk/keluar</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
