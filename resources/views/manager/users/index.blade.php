<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <h2 class="text-2xl font-bold text-gray-900">User Management</h2>
            <a href="{{ route('manager.users.create') }}" class="btn-primary mt-4 sm:mt-0">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Add User
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Stats Cards -->
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4 md:gap-6 mb-6 md:mb-8">
                <div class="bg-white p-4 md:p-6 rounded-xl shadow-sm border border-gray-200">
                    <div class="flex items-center">
                        <div class="p-2 md:p-3 bg-blue-100 rounded-xl">
                            <svg class="w-5 h-5 md:w-6 md:h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-3 md:ml-4">
                            <div class="text-xl md:text-2xl font-bold text-gray-900">{{ $stats['total'] }}</div>
                            <div class="text-xs md:text-sm text-gray-600">Total Users</div>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white p-4 md:p-6 rounded-xl shadow-sm border border-gray-200">
                    <div class="flex items-center">
                        <div class="p-2 md:p-3 bg-green-100 rounded-xl">
                            <svg class="w-5 h-5 md:w-6 md:h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-3 md:ml-4">
                            <div class="text-xl md:text-2xl font-bold text-gray-900">{{ $stats['active'] }}</div>
                            <div class="text-xs md:text-sm text-gray-600">Active</div>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white p-4 md:p-6 rounded-xl shadow-sm border border-gray-200">
                    <div class="flex items-center">
                        <div class="p-2 md:p-3 bg-red-100 rounded-xl">
                            <svg class="w-5 h-5 md:w-6 md:h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-3 md:ml-4">
                            <div class="text-xl md:text-2xl font-bold text-gray-900">{{ $stats['inactive'] }}</div>
                            <div class="text-xs md:text-sm text-gray-600">Inactive</div>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white p-4 md:p-6 rounded-xl shadow-sm border border-gray-200">
                    <div class="flex items-center">
                        <div class="p-2 md:p-3 bg-purple-100 rounded-xl">
                            <svg class="w-5 h-5 md:w-6 md:h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"></path>
                            </svg>
                        </div>
                        <div class="ml-3 md:ml-4">
                            <div class="text-xl md:text-2xl font-bold text-gray-900">{{ $stats['gudang'] }}</div>
                            <div class="text-xs md:text-sm text-gray-600">Gudang</div>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white p-4 md:p-6 rounded-xl shadow-sm border border-gray-200">
                    <div class="flex items-center">
                        <div class="p-2 md:p-3 bg-indigo-100 rounded-xl">
                            <svg class="w-5 h-5 md:w-6 md:h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <div class="ml-3 md:ml-4">
                            <div class="text-xl md:text-2xl font-bold text-gray-900">{{ $stats['member'] }}</div>
                            <div class="text-xs md:text-sm text-gray-600">Member</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filters -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 md:p-6 mb-4 md:mb-6">
                <form method="GET" class="space-y-4 md:space-y-0 md:flex md:gap-4">
                    <div class="flex-1">
                        <input type="text" name="search" value="{{ request('search') }}" 
                               placeholder="Cari nama atau email..." 
                               class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    </div>
                    <div class="md:w-40">
                        <select name="role" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            <option value="">Semua Role</option>
                            <option value="gudang" {{ request('role') === 'gudang' ? 'selected' : '' }}>Gudang</option>
                            <option value="member" {{ request('role') === 'member' ? 'selected' : '' }}>Member</option>
                        </select>
                    </div>
                    <div class="md:w-40">
                        <select name="status" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            <option value="">Semua Status</option>
                            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Aktif</option>
                            <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                        </select>
                    </div>
                    <div class="flex gap-2">
                        <button type="submit" class="flex-1 md:flex-none px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium">
                            Filter
                        </button>
                        @if(request('search') || request('role') || request('status'))
                            <a href="{{ route('manager.users.index') }}" class="flex-1 md:flex-none px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 text-center font-medium">
                                Clear
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            <!-- Users Table -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <!-- Mobile Card View (hidden on md and up) -->
                <div class="block md:hidden">
                    @forelse($users as $user)
                        <div class="border-b border-gray-200 p-4">
                            <div class="flex items-start justify-between">
                                <div class="flex items-center flex-1">
                                    <div class="w-10 h-10 rounded-full bg-gradient-to-r from-blue-500 to-purple-500 flex items-center justify-center text-white font-semibold text-sm">
                                        {{ strtoupper(substr($user->name, 0, 2)) }}
                                    </div>
                                    <div class="ml-3 flex-1">
                                        <div class="font-medium text-gray-900">{{ $user->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $user->email }}</div>
                                        <div class="flex items-center mt-1 space-x-2">
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                                {{ $user->role === 'gudang' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800' }}">
                                                {{ ucfirst($user->role) }}
                                            </span>
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                                {{ $user->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                {{ $user->is_active ? 'Aktif' : 'Nonaktif' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="ml-2 flex flex-col space-y-1">
                                    <a href="{{ route('manager.users.show', $user) }}" 
                                       class="inline-flex items-center justify-center px-3 py-1.5 text-xs font-medium rounded-lg bg-blue-100 text-blue-700 hover:bg-blue-200">
                                        Detail
                                    </a>
                                    <a href="{{ route('manager.users.edit', $user) }}" 
                                       class="inline-flex items-center justify-center px-3 py-1.5 text-xs font-medium rounded-lg bg-indigo-100 text-indigo-700 hover:bg-indigo-200">
                                        Edit
                                    </a>
                                </div>
                            </div>
                            <div class="mt-3 flex space-x-2">
                                <form method="POST" action="{{ route('manager.users.toggle-status', $user) }}" class="flex-1">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" 
                                            class="w-full inline-flex items-center justify-center px-3 py-1.5 text-xs font-medium rounded-lg {{ $user->is_active ? 'bg-red-100 text-red-700 hover:bg-red-200' : 'bg-green-100 text-green-700 hover:bg-green-200' }}"
                                            onclick="return confirm('Yakin ingin {{ $user->is_active ? 'menonaktifkan' : 'mengaktifkan' }} user ini?')">
                                        {{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('manager.users.destroy', $user) }}" class="flex-1">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="w-full inline-flex items-center justify-center px-3 py-1.5 text-xs font-medium rounded-lg bg-red-100 text-red-700 hover:bg-red-200"
                                            onclick="return confirm('Yakin ingin menghapus user ini? Tindakan ini tidak dapat dibatalkan.')">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="p-8 text-center">
                            <svg class="w-12 h-12 text-gray-400 mb-4 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                            </svg>
                            <p class="text-gray-500 text-lg font-medium">Belum ada user</p>
                            <p class="text-gray-400 text-sm mt-1">Tidak ada user yang sesuai dengan filter yang dipilih.</p>
                            <a href="{{ route('manager.users.create') }}" class="mt-4 inline-block px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                                Tambah User Baru
                            </a>
                        </div>
                    @endforelse
                </div>

                <!-- Desktop Table View (hidden on mobile) -->
                <div class="hidden md:block overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-sm font-medium text-gray-900">User</th>
                                <th class="px-6 py-4 text-left text-sm font-medium text-gray-900">Role</th>
                                <th class="px-6 py-4 text-left text-sm font-medium text-gray-900">Status</th>
                                <th class="px-6 py-4 text-left text-sm font-medium text-gray-900">Bergabung</th>
                                <th class="px-6 py-4 text-right text-sm font-medium text-gray-900">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($users as $user)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 rounded-full bg-gradient-to-r from-blue-500 to-purple-500 flex items-center justify-center text-white font-semibold text-sm">
                                                {{ strtoupper(substr($user->name, 0, 2)) }}
                                            </div>
                                            <div class="ml-3">
                                                <div class="font-medium text-gray-900">{{ $user->name }}</div>
                                                <div class="text-sm text-gray-500">{{ $user->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                            {{ $user->role === 'gudang' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800' }}">
                                            {{ ucfirst($user->role) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                            {{ $user->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $user->is_active ? 'Aktif' : 'Nonaktif' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900">
                                        {{ $user->created_at->format('d M Y') }}
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex items-center justify-end space-x-2">
                                            <a href="{{ route('manager.users.show', $user) }}" 
                                               class="inline-flex items-center px-3 py-1.5 text-sm font-medium rounded-lg bg-blue-100 text-blue-700 hover:bg-blue-200">
                                                Detail
                                            </a>
                                            <a href="{{ route('manager.users.edit', $user) }}" 
                                               class="inline-flex items-center px-3 py-1.5 text-sm font-medium rounded-lg bg-indigo-100 text-indigo-700 hover:bg-indigo-200">
                                                Edit
                                            </a>
                                            <form method="POST" action="{{ route('manager.users.toggle-status', $user) }}" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" 
                                                        class="inline-flex items-center px-3 py-1.5 text-sm font-medium rounded-lg {{ $user->is_active ? 'bg-red-100 text-red-700 hover:bg-red-200' : 'bg-green-100 text-green-700 hover:bg-green-200' }}"
                                                        onclick="return confirm('Yakin ingin {{ $user->is_active ? 'menonaktifkan' : 'mengaktifkan' }} user ini?')">
                                                    {{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                                </button>
                                            </form>
                                            <form method="POST" action="{{ route('manager.users.destroy', $user) }}" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="inline-flex items-center px-3 py-1.5 text-sm font-medium rounded-lg bg-red-100 text-red-700 hover:bg-red-200"
                                                        onclick="return confirm('Yakin ingin menghapus user ini? Tindakan ini tidak dapat dibatalkan.')">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center">
                                            <svg class="w-12 h-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                            </svg>
                                            <p class="text-gray-500 text-lg font-medium">Belum ada user</p>
                                            <p class="text-gray-400 text-sm mt-1">Tidak ada user yang sesuai dengan filter yang dipilih.</p>
                                            <a href="{{ route('manager.users.create') }}" class="mt-4 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                                                Tambah User Baru
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($users->hasPages())
                    <div class="px-6 py-4 border-t border-gray-200">
                        <div class="flex items-center justify-between">
                            <div class="text-sm text-gray-700">
                                Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of {{ $users->total() }} results
                            </div>
                            <div>
                                {{ $users->appends(request()->query())->links() }}
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
