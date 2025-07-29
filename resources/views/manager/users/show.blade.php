<x-enhanced-layout>
    <x-slot name="title">Detail User: {{ $user->name }}</x-slot>

    <x-slot name="actions">
        <a href="{{ route('manager.users.edit', $user) }}" 
           class="btn-primary inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors duration-200"
           style="cursor: pointer;">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
            </svg>
            Edit User
        </a>
        <a href="{{ route('manager.users.index') }}" 
           class="btn-secondary inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors duration-200"
           style="cursor: pointer;">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali
        </a>
    </x-slot>

    <x-slot name="breadcrumbs">
        <nav class="flex" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                        </svg>
                        Dashboard
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <a href="{{ route('manager.users.index') }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2">Users</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">{{ $user->name }}</span>
                    </div>
                </li>
            </ol>
        </nav>
    </x-slot>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- User Profile Card -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100">
                        <div class="bg-gradient-to-r from-blue-600 to-purple-600 px-6 py-8 text-center">
                            <div class="w-24 h-24 bg-white rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
                                <svg class="w-12 h-12 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-white">{{ $user->name }}</h3>
                            <p class="text-blue-100">{{ $user->email }}</p>
                            <div class="mt-3">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                                    {{ $user->role === 'gudang' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800' }}">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="p-6 space-y-4">
                            <div class="flex items-center justify-between">
                                <span class="text-gray-600">Status</span>
                                @if($user->is_active)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <div class="w-1.5 h-1.5 bg-green-400 rounded-full mr-1"></div>
                                        Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        <div class="w-1.5 h-1.5 bg-red-400 rounded-full mr-1"></div>
                                        Nonaktif
                                    </span>
                                @endif
                            </div>
                            
                            <div class="flex items-center justify-between">
                                <span class="text-gray-600">Bergabung</span>
                                <span class="font-medium">{{ $user->created_at->format('d F Y') }}</span>
                            </div>
                            
                            <div class="flex items-center justify-between">
                                <span class="text-gray-600">Terakhir Update</span>
                                <span class="font-medium">{{ $user->updated_at->format('d F Y') }}</span>
                            </div>
                        </div>

                        <!-- Quick Actions -->
                        <div class="p-6 bg-gray-50 border-t" x-data="{ 
                            showDeleteConfirm: false,
                            showStatusConfirm: false 
                        }">
                            <h4 class="text-sm font-medium text-gray-900 mb-3">Quick Actions</h4>
                            
                            <!-- Test Button for Debugging -->
                            <div class="mb-4 p-2 bg-yellow-50 border border-yellow-200 rounded">
                                <button type="button"
                                        onclick="testClick()"
                                        class="w-full px-3 py-2 text-sm bg-yellow-500 hover:bg-yellow-600 text-white rounded"
                                        style="cursor: pointer;">
                                    🧪 Test Click (Debug)
                                </button>
                                <button type="button"
                                        x-data="debugClick()"
                                        @click="test()"
                                        class="w-full mt-1 px-3 py-2 text-sm bg-blue-500 hover:bg-blue-600 text-white rounded"
                                        style="cursor: pointer;">
                                    🧪 Test Alpine Click
                                </button>
                            </div>
                            
                            <div class="space-y-2">
                                <!-- Toggle Status Button -->
                                <button type="button"
                                        @click="showStatusConfirm = true"
                                        class="w-full text-left px-3 py-2 text-sm rounded-lg transition-colors duration-200 {{ $user->is_active ? 'text-red-600 hover:bg-red-50' : 'text-green-600 hover:bg-green-50' }}"
                                        style="cursor: pointer; background-color: transparent; border: none;">
                                    {{ $user->is_active ? 'Nonaktifkan User' : 'Aktifkan User' }}
                                </button>
                                
                                <!-- Delete Button -->
                                <button type="button"
                                        @click="showDeleteConfirm = true"
                                        class="w-full text-left px-3 py-2 text-sm text-red-600 hover:bg-red-50 rounded-lg transition-colors duration-200"
                                        style="cursor: pointer; background-color: transparent; border: none;">
                                    Hapus User
                                </button>
                            </div>

                            <!-- Status Confirmation Modal -->
                            <div x-show="showStatusConfirm" 
                                 x-transition:enter="transition ease-out duration-300"
                                 x-transition:enter-start="opacity-0 scale-95"
                                 x-transition:enter-end="opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-200"
                                 x-transition:leave-start="opacity-100 scale-100"
                                 x-transition:leave-end="opacity-0 scale-95"
                                 class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
                                 style="z-index: 9999;"
                                 @click.self="showStatusConfirm = false"
                                 @keydown.escape.window="showStatusConfirm = false">
                                <div class="bg-white rounded-xl p-6 max-w-md mx-4 shadow-xl">
                                    <h3 class="text-lg font-medium text-gray-900 mb-4">Konfirmasi Perubahan Status</h3>
                                    <p class="text-gray-600 mb-6">
                                        Yakin ingin {{ $user->is_active ? 'menonaktifkan' : 'mengaktifkan' }} user <strong>{{ $user->name }}</strong>?
                                    </p>
                                    <div class="flex justify-end space-x-3">
                                        <button type="button" 
                                                @click="showStatusConfirm = false"
                                                class="btn-secondary inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors duration-200"
                                                style="cursor: pointer;">
                                            Batal
                                        </button>
                                        <form method="POST" action="{{ route('manager.users.toggle-status', $user) }}" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" 
                                                    class="btn-{{ $user->is_active ? 'danger' : 'success' }} inline-flex items-center px-4 py-2 {{ $user->is_active ? 'bg-red-600 hover:bg-red-700' : 'bg-green-600 hover:bg-green-700' }} text-white font-medium rounded-lg transition-colors duration-200"
                                                    style="cursor: pointer;">
                                                {{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Delete Confirmation Modal -->
                            <div x-show="showDeleteConfirm" 
                                 x-transition:enter="transition ease-out duration-300"
                                 x-transition:enter-start="opacity-0 scale-95"
                                 x-transition:enter-end="opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-200"
                                 x-transition:leave-start="opacity-100 scale-100"
                                 x-transition:leave-end="opacity-0 scale-95"
                                 class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
                                 style="z-index: 9999;"
                                 @click.self="showDeleteConfirm = false"
                                 @keydown.escape.window="showDeleteConfirm = false">
                                <div class="bg-white rounded-xl p-6 max-w-md mx-4 shadow-xl">
                                    <h3 class="text-lg font-medium text-red-900 mb-4">Konfirmasi Hapus User</h3>
                                    <p class="text-gray-600 mb-6">
                                        Yakin ingin menghapus user <strong>{{ $user->name }}</strong>? 
                                        <br><span class="text-red-600 font-medium">Tindakan ini tidak dapat dibatalkan.</span>
                                    </p>
                                    <div class="flex justify-end space-x-3">
                                        <button type="button" 
                                                @click="showDeleteConfirm = false"
                                                class="btn-secondary inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors duration-200"
                                                style="cursor: pointer;">
                                            Batal
                                        </button>
                                        <form method="POST" action="{{ route('manager.users.destroy', $user) }}" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="btn-danger inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition-colors duration-200"
                                                    style="cursor: pointer;">
                                                Hapus User
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- User Details & Activities -->
                <div class="lg:col-span-2 space-y-8">
                    <!-- Account Information -->
                    <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
                        <div class="flex items-center mb-6">
                            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-900">Informasi Akun</h3>
                                <p class="text-gray-600">Detail lengkap tentang user</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Nama Lengkap</label>
                                    <p class="mt-1 text-lg font-semibold text-gray-900">{{ $user->name }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Email</label>
                                    <p class="mt-1 text-lg font-semibold text-gray-900">{{ $user->email }}</p>
                                </div>
                            </div>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Role</label>
                                    <p class="mt-1">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                                            {{ $user->role === 'gudang' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800' }}">
                                            {{ ucfirst($user->role) }}
                                        </span>
                                    </p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Status Akun</label>
                                    <p class="mt-1">
                                        @if($user->is_active)
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                                <div class="w-2 h-2 bg-green-400 rounded-full mr-2"></div>
                                                Aktif
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                                <div class="w-2 h-2 bg-red-400 rounded-full mr-2"></div>
                                                Nonaktif
                                            </span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Activity Summary -->
                    <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
                        <div class="flex items-center mb-6">
                            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-4">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-900">Ringkasan Aktivitas</h3>
                                <p class="text-gray-600">Statistik aktivitas user dalam sistem</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            <div class="text-center p-4 bg-blue-50 rounded-lg">
                                <div class="text-2xl font-bold text-blue-600">0</div>
                                <div class="text-sm text-gray-600">Total Login</div>
                            </div>
                            <div class="text-center p-4 bg-green-50 rounded-lg">
                                <div class="text-2xl font-bold text-green-600">0</div>
                                <div class="text-sm text-gray-600">Rental Aktif</div>
                            </div>
                            <div class="text-center p-4 bg-yellow-50 rounded-lg">
                                <div class="text-2xl font-bold text-yellow-600">0</div>
                                <div class="text-sm text-gray-600">Pending</div>
                            </div>
                            <div class="text-center p-4 bg-purple-50 rounded-lg">
                                <div class="text-2xl font-bold text-purple-600">0</div>
                                <div class="text-sm text-gray-600">Selesai</div>
                            </div>
                        </div>
                    </div>

                    <!-- Account Timestamps -->
                    <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
                        <div class="flex items-center mb-6">
                            <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center mr-4">
                                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-900">Timeline Akun</h3>
                                <p class="text-gray-600">Riwayat waktu penting akun</p>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <div>
                                    <span class="text-sm font-medium text-gray-900">Akun Dibuat</span>
                                    <p class="text-xs text-gray-500">{{ $user->created_at->format('l, d F Y H:i') }}</p>
                                </div>
                                <span class="text-sm text-gray-600">{{ $user->created_at->diffForHumans() }}</span>
                            </div>
                            
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <div>
                                    <span class="text-sm font-medium text-gray-900">Terakhir Diperbarui</span>
                                    <p class="text-xs text-gray-500">{{ $user->updated_at->format('l, d F Y H:i') }}</p>
                                </div>
                                <span class="text-sm text-gray-600">{{ $user->updated_at->diffForHumans() }}</span>
                            </div>

                            @if($user->email_verified_at)
                            <div class="flex items-center justify-between p-3 bg-green-50 rounded-lg">
                                <div>
                                    <span class="text-sm font-medium text-green-900">Email Terverifikasi</span>
                                    <p class="text-xs text-green-600">{{ $user->email_verified_at->format('l, d F Y H:i') }}</p>
                                </div>
                                <span class="text-sm text-green-600">{{ $user->email_verified_at->diffForHumans() }}</span>
                            </div>
                            @else
                            <div class="flex items-center justify-between p-3 bg-yellow-50 rounded-lg">
                                <div>
                                    <span class="text-sm font-medium text-yellow-900">Email</span>
                                    <p class="text-xs text-yellow-600">Belum terverifikasi</p>
                                </div>
                                <span class="text-sm text-yellow-600">Perlu verifikasi</span>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

</x-enhanced-layout>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('User show page loaded');
    
    // Force all links and buttons to be clickable
    const allClickables = document.querySelectorAll('a, button, [role="button"]');
    allClickables.forEach(element => {
        // Ensure element is clickable
        element.style.cursor = 'pointer';
        element.style.pointerEvents = 'auto';
        element.style.userSelect = 'none';
        
        // Add click event listener for feedback
        element.addEventListener('click', function(e) {
            console.log('Element clicked:', this.tagName, this.textContent?.trim());
            
            // Visual feedback
            this.style.transform = 'scale(0.95)';
            setTimeout(() => {
                this.style.transform = 'scale(1)';
            }, 100);
        });
        
        // Add hover effect
        element.addEventListener('mouseenter', function() {
            this.style.opacity = '0.9';
        });
        
        element.addEventListener('mouseleave', function() {
            this.style.opacity = '1';
        });
    });
    
    // Ensure forms are submittable
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            console.log('Form submitted:', this.action);
            
            // Show loading state on submit button
            const submitBtn = this.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.style.opacity = '0.7';
                submitBtn.textContent += '...';
            }
        });
    });
    
    // Force Alpine.js to initialize if not already
    if (typeof Alpine !== 'undefined' && !window.Alpine) {
        console.log('Starting Alpine.js manually');
        Alpine.start();
    }
});

// Alpine.js initialization
document.addEventListener('alpine:init', () => {
    console.log('Alpine.js initialized for user show page');
    
    // Debug Alpine data
    Alpine.data('debugClick', () => ({
        test() {
            console.log('Alpine click test works!');
            alert('Alpine.js is working!');
        }
    }));
});

// Add a test button to verify functionality
window.testClick = function() {
    console.log('Global test function called');
    alert('JavaScript is working!');
};

// Force refresh Alpine components after page load
setTimeout(() => {
    if (typeof Alpine !== 'undefined') {
        console.log('Re-initializing Alpine components');
        document.querySelectorAll('[x-data]').forEach(el => {
            if (el._x_dataStack) {
                Alpine.destroyTree(el);
                Alpine.initTree(el);
            }
        });
    }
}, 100);
</script>
@endpush
