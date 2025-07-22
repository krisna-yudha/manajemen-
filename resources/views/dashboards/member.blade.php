<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard Member
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium mb-4">Welcome Member, {{ Auth::user()->name }}!</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div class="bg-indigo-50 p-6 rounded-lg">
                            <h4 class="font-semibold text-indigo-800 mb-2">Your Activities</h4>
                            <p class="text-2xl font-bold text-indigo-600">0</p>
                        </div>
                        <div class="bg-gray-50 p-6 rounded-lg">
                            <h4 class="font-semibold text-gray-800 mb-2">Notifications</h4>
                            <p class="text-2xl font-bold text-gray-600">0</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-white border rounded-lg p-6">
                            <h4 class="font-semibold text-gray-800 mb-4">Available Actions</h4>
                            <div class="space-y-3">
                                <a href="{{ route('barang.available') }}" class="block w-full bg-indigo-600 text-white text-center py-2 px-4 rounded hover:bg-indigo-700">
                                    View Available Items
                                </a>
                                <a href="{{ route('rental.create') }}" class="block w-full bg-blue-600 text-white text-center py-2 px-4 rounded hover:bg-blue-700">
                                    Submit Rental Request
                                </a>
                                <a href="{{ route('rental.index') }}" class="block w-full bg-gray-600 text-white text-center py-2 px-4 rounded hover:bg-gray-700">
                                    View My Rentals
                                </a>
                            </div>
                        </div>
                        
                        <div class="bg-white border rounded-lg p-6">
                            <h4 class="font-semibold text-gray-800 mb-4">Recent Activity</h4>
                            <div class="space-y-2 text-sm">
                                <p class="text-gray-600">• No recent activity</p>
                                <p class="text-gray-500 text-xs">Your activities will appear here</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 p-4 bg-yellow-50 rounded-lg">
                        <h4 class="font-semibold text-yellow-800 mb-2">Member Access</h4>
                        <p class="text-yellow-600 text-sm">Sebagai member, Anda memiliki akses terbatas untuk:</p>
                        <ul class="text-yellow-600 text-sm mt-2 space-y-1">
                            <li>• Melihat item yang tersedia</li>
                            <li>• Melihat riwayat aktivitas pribadi</li>
                            <li>• Mengajukan permintaan</li>
                        </ul>
                        <p class="text-yellow-600 text-xs mt-3">Untuk akses lebih lanjut, hubungi manager atau admin sistem.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
