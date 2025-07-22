<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard Manager
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium mb-4">Welcome Manager, {{ Auth::user()->name }}!</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                        <div class="bg-blue-50 p-6 rounded-lg">
                            <h4 class="font-semibold text-blue-800 mb-2">Total Users</h4>
                            <p class="text-2xl font-bold text-blue-600">{{ App\Models\User::count() }}</p>
                        </div>
                        <div class="bg-green-50 p-6 rounded-lg">
                            <h4 class="font-semibold text-green-800 mb-2">Manager</h4>
                            <p class="text-2xl font-bold text-green-600">{{ App\Models\User::where('role', 'manager')->count() }}</p>
                        </div>
                        <div class="bg-orange-50 p-6 rounded-lg">
                            <h4 class="font-semibold text-orange-800 mb-2">Staff Gudang</h4>
                            <p class="text-2xl font-bold text-orange-600">{{ App\Models\User::where('role', 'gudang')->count() }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-white border rounded-lg p-6">
                            <h4 class="font-semibold text-gray-800 mb-4">Quick Actions</h4>
                            <div class="space-y-3">
                                <a href="{{ route('manager.users') }}" class="block w-full bg-blue-600 text-white text-center py-2 px-4 rounded hover:bg-blue-700">
                                    Manage Users & Roles
                                </a>
                                <button class="block w-full bg-green-600 text-white text-center py-2 px-4 rounded hover:bg-green-700">
                                    View All Reports
                                </button>
                                <button class="block w-full bg-purple-600 text-white text-center py-2 px-4 rounded hover:bg-purple-700">
                                    System Settings
                                </button>
                            </div>
                        </div>
                        
                        <div class="bg-white border rounded-lg p-6">
                            <h4 class="font-semibold text-gray-800 mb-4">Recent Activities</h4>
                            <div class="space-y-2 text-sm">
                                <p class="text-gray-600">• System backup completed</p>
                                <p class="text-gray-600">• New user registered</p>
                                <p class="text-gray-600">• Inventory updated</p>
                                <p class="text-gray-600">• Report generated</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
