<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            User Management - Manager Only
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-medium">Manage Users & Roles</h3>
                        <a href="{{ route('manager.users.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                            Add New User
                        </a>
                    </div>

                    @if(session('success'))
                        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full table-auto">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Current Role</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($users as $user)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-500">{{ $user->email }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                            @if($user->role === 'manager') bg-blue-100 text-blue-800
                                            @elseif($user->role === 'gudang') bg-orange-100 text-orange-800
                                            @else bg-gray-100 text-gray-800
                                            @endif">
                                            {{ ucfirst($user->role) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        @if($user->id !== Auth::id())
                                            <form method="POST" action="{{ route('manager.users.update-role', $user) }}" class="inline-block">
                                                @csrf
                                                @method('PATCH')
                                                <select name="role" onchange="this.form.submit()" 
                                                        class="text-xs border rounded px-2 py-1 
                                                        @if($user->role === 'manager') border-blue-300
                                                        @elseif($user->role === 'gudang') border-orange-300
                                                        @else border-gray-300
                                                        @endif">
                                                    <option value="manager" {{ $user->role === 'manager' ? 'selected' : '' }}>Manager</option>
                                                    <option value="gudang" {{ $user->role === 'gudang' ? 'selected' : '' }}>Gudang</option>
                                                    <option value="member" {{ $user->role === 'member' ? 'selected' : '' }}>Member</option>
                                                </select>
                                            </form>
                                        @else
                                            <span class="text-gray-400 text-xs">Current User</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <h4 class="font-semibold text-blue-800">Manager</h4>
                            <p class="text-blue-600 text-sm">Full access to all features</p>
                            <p class="text-blue-500 text-xs mt-1">Count: {{ $users->where('role', 'manager')->count() }}</p>
                        </div>
                        <div class="bg-orange-50 p-4 rounded-lg">
                            <h4 class="font-semibold text-orange-800">Gudang</h4>
                            <p class="text-orange-600 text-sm">Inventory and stock management</p>
                            <p class="text-orange-500 text-xs mt-1">Count: {{ $users->where('role', 'gudang')->count() }}</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h4 class="font-semibold text-gray-800">Member</h4>
                            <p class="text-gray-600 text-sm">Limited access</p>
                            <p class="text-gray-500 text-xs mt-1">Count: {{ $users->where('role', 'member')->count() }}</p>
                        </div>
                    </div>

                    <div class="mt-6 p-4 bg-yellow-50 rounded-lg">
                        <h4 class="font-semibold text-yellow-800 mb-2">Role Permissions</h4>
                        <div class="text-yellow-600 text-sm space-y-1">
                            <p><strong>Manager:</strong> Dapat mengakses semua fitur, mengelola user dan role</p>
                            <p><strong>Gudang:</strong> Dapat mengelola inventory, stok, dan laporan gudang</p>
                            <p><strong>Member:</strong> Akses terbatas, hanya dapat melihat data tertentu</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
