<x-enhanced-layout 
    title="Tambah User Baru"
    :breadcrumbs="[
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => 'User Management', 'url' => route('manager.users.index')],
        ['label' => 'Tambah User Baru']
    ]">

    <x-slot name="actions">
        <a href="{{ route('manager.users.index') }}" class="btn-secondary">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali
        </a>
    </x-slot>

    <div class="card-modern">
        <div class="bg-gradient-to-r from-blue-600 to-purple-600 px-6 py-4 rounded-t-2xl">
            <h3 class="text-lg font-semibold text-white">Informasi User Baru</h3>
            <p class="text-blue-100 text-sm">Masukkan data lengkap untuk user baru</p>
        </div>

        <form method="POST" 
              action="{{ route('manager.users.store') }}" 
              class="p-6 space-y-6"
              x-data="{ 
                  confirmPassword: '',
                  password: '',
                  get passwordMatch() {
                      return this.password === this.confirmPassword || this.confirmPassword === '';
                  }
              }">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Name -->
                <x-form-input 
                    name="name"
                    label="Nama Lengkap"
                    placeholder="Masukkan nama lengkap"
                    value="{{ old('name') }}"
                    required="true"
                    icon='<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>'
                />

                <!-- Email -->
                <x-form-input 
                    name="email"
                    type="email"
                    label="Email"
                    placeholder="example@email.com"
                    value="{{ old('email') }}"
                    required="true"
                    icon='<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>'
                />

                <!-- Password -->
                <x-form-input 
                    name="password"
                    type="password"
                    label="Password"
                    placeholder="Minimal 8 karakter"
                    required="true"
                    x-model="password"
                    icon='<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m0 0a2 2 0 012 2v6a2 2 0 01-2 2H9a2 2 0 01-2-2V9a2 2 0 012-2m0 0V5a2 2 0 012-2h4a2 2 0 012 2v2M9 7h6"></path>'
                />

                <!-- Password Confirmation -->
                <div>
                    <x-form-input 
                        name="password_confirmation"
                        type="password"
                        label="Konfirmasi Password"
                        placeholder="Ulangi password"
                        required="true"
                        x-model="confirmPassword"
                        icon='<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>'
                    />
                    <div x-show="!passwordMatch && confirmPassword !== ''" 
                         x-transition
                         class="mt-1 text-sm text-red-600">
                        Password tidak cocok
                    </div>
                    <div x-show="passwordMatch && confirmPassword !== ''" 
                         x-transition
                         class="mt-1 text-sm text-green-600">
                        Password cocok
                    </div>
                </div>

                <!-- Role -->
                <div>
                    <label for="role" class="form-label">
                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                        Role
                    </label>
                    <select id="role" 
                            name="role" 
                            required 
                            class="form-input">
                        <option value="">Pilih Role</option>
                        <option value="gudang" {{ old('role') === 'gudang' ? 'selected' : '' }}>Gudang</option>
                        <option value="member" {{ old('role') === 'member' ? 'selected' : '' }}>Member</option>
                    </select>
                    @error('role')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status -->
                <div>
                    <label class="form-label">
                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                        Status
                    </label>
                    <div class="flex items-center">
                        <label class="inline-flex items-center">
                            <input type="checkbox" 
                                   name="is_active" 
                                   value="1" 
                                   {{ old('is_active', true) ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            <span class="ml-2 text-sm text-gray-700">User aktif</span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                <a href="{{ route('manager.users.index') }}" class="btn-secondary">
                    Batal
                </a>
                <button type="submit" 
                        class="btn-primary"
                        :disabled="!passwordMatch"
                        :class="{ 'opacity-50 cursor-not-allowed': !passwordMatch }">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Simpan User
                </button>
            </div>
        </form>
    </div>
</x-enhanced-layout>
