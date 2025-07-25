<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Manager Dashboard</h2>
                <p class="text-gray-600 mt-1">Monitoring & User Management</p>
            </div>
            <div class="mt-4 sm:mt-0">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                    ✓ Full Access
                </span>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Statistics Overview -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <div class="text-2xl font-bold text-gray-900">{{ $totalUsers }}</div>
                            <div class="text-sm text-gray-600">Total Users</div>
                        </div>
                    </div>
                    <div class="mt-4">
                        <div class="text-sm">
                            <span class="text-blue-600">0 Managers</span> • 
                            <span class="text-orange-600">0 Gudang</span> • 
                            <span class="text-indigo-600">0 Members</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <div class="text-2xl font-bold text-gray-900">{{ $totalBarang }}</div>
                            <div class="text-sm text-gray-600">Total Barang</div>
                        </div>
                    </div>
                    <div class="mt-4">
                        <div class="text-sm">
                            <span class="text-green-600">0 Available</span> • 
                            <span class="text-red-600">0 Out of Stock</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <div class="text-2xl font-bold text-gray-900">{{ $pendingApprovals }}</div>
                            <div class="text-sm text-gray-600">Pending Rentals</div>
                        </div>
                    </div>
                    <div class="mt-4">
                        <div class="text-sm text-orange-600">
                            Memerlukan persetujuan
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <div class="text-2xl font-bold text-gray-900">{{ $activeRentals }}</div>
                            <div class="text-sm text-gray-600">Active Rentals</div>
                        </div>
                    </div>
                    <div class="mt-4">
                        <div class="text-sm text-purple-600">
                            Sedang berlangsung
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                <!-- Quick Actions -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6">Quick Actions</h3>
                    <div class="space-y-4">
                        <a href="{{ route('manager.users') }}" class="flex items-center p-4 rounded-lg bg-gray-50 hover:bg-gray-100 transition-colors group">
                            <div class="w-12 h-12 bg-blue-100 group-hover:bg-blue-200 rounded-xl flex items-center justify-center mr-4 transition-colors">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <div class="font-medium text-gray-900">Manage Users</div>
                                <div class="text-sm text-gray-600">Add, edit, or manage user roles</div>
                            </div>
                            <svg class="w-5 h-5 text-gray-400 group-hover:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>

                        <a href="{{ route('rental.index') }}" class="flex items-center p-4 rounded-lg bg-gray-50 hover:bg-gray-100 transition-colors group">
                            <div class="w-12 h-12 bg-green-100 group-hover:bg-green-200 rounded-xl flex items-center justify-center mr-4 transition-colors">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <div class="font-medium text-gray-900">All Rentals</div>
                                <div class="text-sm text-gray-600">Monitor all rental activities</div>
                            </div>
                            <svg class="w-5 h-5 text-gray-400 group-hover:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>

                        <a href="{{ route('manager.report.barang') }}" class="flex items-center p-4 rounded-lg bg-gray-50 hover:bg-gray-100 transition-colors group">
                            <div class="w-12 h-12 bg-purple-100 group-hover:bg-purple-200 rounded-xl flex items-center justify-center mr-4 transition-colors">
                                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <div class="font-medium text-gray-900">Reports & Analytics</div>
                                <div class="text-sm text-gray-600">View comprehensive reports</div>
                            </div>
                            <svg class="w-5 h-5 text-gray-400 group-hover:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6">Recent Activity</h3>
                    <div class="space-y-4">
                        @forelse($recentActivities as $activity)
                            <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                                <div class="w-2 h-2 bg-blue-500 rounded-full mr-3"></div>
                                <div class="flex-1">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $activity['title'] }}
                                    </div>
                                    <div class="text-xs text-gray-600">
                                        {{ $activity['time'] }}
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-4 text-gray-500">
                                No recent activity
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- System Overview -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">System Overview</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- System Health -->
                    <div class="text-center p-4 bg-green-50 rounded-lg">
                        <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center mx-auto mb-3">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="text-lg font-semibold text-green-800">System Health</div>
                        <div class="text-sm text-green-600">All systems operational</div>
                    </div>

                    <!-- Data Backup -->
                    <div class="text-center p-4 bg-blue-50 rounded-lg">
                        <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center mx-auto mb-3">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                            </svg>
                        </div>
                        <div class="text-lg font-semibold text-blue-800">Last Backup</div>
                        <div class="text-sm text-blue-600">{{ now()->format('d M Y') }}</div>
                    </div>

                    <!-- Security Status -->
                    <div class="text-center p-4 bg-purple-50 rounded-lg">
                        <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center mx-auto mb-3">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <div class="text-lg font-semibold text-purple-800">Security</div>
                        <div class="text-sm text-purple-600">Protected & Secure</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
