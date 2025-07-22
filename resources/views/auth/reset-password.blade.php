<x-guest-layout>
    <!-- Header -->
    <div class="text-center mb-6">
        <h2 class="text-2xl font-bold text-gray-900">Reset Password</h2>
        <p class="text-gray-600 mt-1">Create a new password for your account</p>
    </div>

    <!-- Security Notice -->
    <div class="bg-amber-50 border border-amber-200 rounded-lg p-4 mb-6">
        <p class="text-sm text-amber-800 text-center">
            <span class="font-medium">Security tip:</span> Choose a strong password with at least 8 characters
        </p>
    </div>

    <form method="POST" action="{{ route('password.store') }}" class="space-y-4">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                Email Address
            </label>
            <input id="email" 
                   type="email" 
                   name="email" 
                   value="{{ old('email', $request->email) }}" 
                   required 
                   autofocus 
                   autocomplete="username"
                   readonly
                   class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-50 text-gray-600"
                   placeholder="Your email address">
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <!-- New Password -->
        <div>
            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                New Password
            </label>
            <input id="password" 
                   type="password" 
                   name="password" 
                   required 
                   autocomplete="new-password"
                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                   placeholder="Enter your new password">
            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">
                Confirm New Password
            </label>
            <input id="password_confirmation" 
                   type="password" 
                   name="password_confirmation" 
                   required 
                   autocomplete="new-password"
                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                   placeholder="Confirm your new password">
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
        </div>

        <!-- Submit Button -->
        <button type="submit" 
                class="w-full bg-green-600 text-white py-2 px-4 rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition duration-200 font-medium">
            Reset Password
        </button>

        <!-- Back to Login -->
        <div class="text-center">
            <a class="text-sm text-gray-600 hover:text-blue-500 font-medium" 
               href="{{ route('login') }}">
                ← Back to login
            </a>
        </div>
    </form>
</x-guest-layout>
