<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }} - {{ ucfirst(Auth::user()->role) }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium mb-4">Selamat datang, {{ Auth::user()->name }}!</h3>
                    <p class="text-gray-600 mb-6">Role Anda: <span class="font-semibold text-blue-600">{{ ucfirst(Auth::user()->role) }}</span></p>
                    
                    @if(Auth::user()->role === 'manager')
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="bg-blue-50 p-4 rounded-lg">
                                <h4 class="font-semibold text-blue-800">Manager Dashboard</h4>
                                <p class="text-blue-600 text-sm">Akses penuh ke semua fitur</p>
                                <a href="{{ route('manager.dashboard') }}" class="mt-2 inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                                    Ke Dashboard Manager
                                </a>
                            </div>
                            <div class="bg-green-50 p-4 rounded-lg">
                                <h4 class="font-semibold text-green-800">Manajemen User</h4>
                                <p class="text-green-600 text-sm">Kelola role dan user</p>
                                <a href="{{ route('manager.users') }}" class="mt-2 inline-block bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                                    Kelola User
                                </a>
                            </div>
                            <div class="bg-purple-50 p-4 rounded-lg">
                                <h4 class="font-semibold text-purple-800">Laporan</h4>
                                <p class="text-purple-600 text-sm">Lihat semua laporan</p>
                                <button class="mt-2 bg-purple-600 text-white px-4 py-2 rounded hover:bg-purple-700">
                                    Lihat Laporan
                                </button>
                            </div>
                        </div>
                    @elseif(Auth::user()->role === 'gudang')
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="bg-orange-50 p-4 rounded-lg">
                                <h4 class="font-semibold text-orange-800">Dashboard Gudang</h4>
                                <p class="text-orange-600 text-sm">Kelola inventory dan stok</p>
                                <a href="{{ route('gudang.dashboard') }}" class="mt-2 inline-block bg-orange-600 text-white px-4 py-2 rounded hover:bg-orange-700">
                                    Ke Dashboard Gudang
                                </a>
                            </div>
                            <div class="bg-yellow-50 p-4 rounded-lg">
                                <h4 class="font-semibold text-yellow-800">Stok Barang</h4>
                                <p class="text-yellow-600 text-sm">Monitor dan update stok</p>
                                <button class="mt-2 bg-yellow-600 text-white px-4 py-2 rounded hover:bg-yellow-700">
                                    Kelola Stok
                                </button>
                            </div>
                        </div>
                    @elseif(Auth::user()->role === 'member')
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="bg-indigo-50 p-4 rounded-lg">
                                <h4 class="font-semibold text-indigo-800">Dashboard Member</h4>
                                <p class="text-indigo-600 text-sm">Akses terbatas untuk member</p>
                                <a href="{{ route('member.dashboard') }}" class="mt-2 inline-block bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                                    Ke Dashboard Member
                                </a>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h4 class="font-semibold text-gray-800">Aktivitas</h4>
                                <p class="text-gray-600 text-sm">Lihat aktivitas Anda</p>
                                <button class="mt-2 bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">
                                    Lihat Aktivitas
                                </button>
                            </div>
                        </div>
                    @endif

                    <div class="mt-8 p-4 bg-gray-50 rounded-lg">
                        <h4 class="font-semibold text-gray-800 mb-2">Informasi Akses Role</h4>
                        <ul class="text-sm text-gray-600 space-y-1">
                            <li><strong>Manager:</strong> Akses penuh ke semua fitur, dapat mengelola user dan role</li>
                            <li><strong>Gudang:</strong> Dapat mengelola inventory, stok barang, dan laporan gudang</li>
                            <li><strong>Member:</strong> Akses terbatas, hanya dapat melihat data tertentu</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
