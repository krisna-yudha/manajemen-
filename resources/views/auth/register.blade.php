<x-guest-layout>
    <!-- Header -->
    <div class="text-center mb-6">
        <h2 class="text-2xl font-bold text-gray-900">Create Account</h2>
        {{-- <p class="text-gray-600 mt-1">Join our rental management system</p> --}}
    </div>
    
    {{-- <!-- Info Box -->
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-3 mb-6">
        <p class="text-xs text-blue-800 text-center">
            <span class="font-medium">Member Account:</span> Access rental system and track your bookings
        </p>
    </div> --}}

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <!-- Name -->
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                Full Name
            </label>
            <input id="name" 
                   type="text" 
                   name="name" 
                   value="{{ old('name') }}" 
                   required 
                   autofocus 
                   autocomplete="name"
                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                   placeholder="Enter your full name">
            <x-input-error :messages="$errors->get('name')" class="mt-1" />
        </div>

        <!-- Email -->
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                Email Address
            </label>
            <input id="email" 
                   type="email" 
                   name="email" 
                   value="{{ old('email') }}" 
                   required 
                   autocomplete="username"
                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                   placeholder="Enter your email address">
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                Password
            </label>
            <input id="password" 
                   type="password" 
                   name="password" 
                   required 
                   autocomplete="new-password"
                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                   placeholder="Create a password">
            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">
                Confirm Password
            </label>
            <input id="password_confirmation" 
                   type="password" 
                   name="password_confirmation" 
                   required 
                   autocomplete="new-password"
                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                   placeholder="Confirm your password">
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
        </div>

        <!-- Terms -->
        <div class="bg-gray-50 p-3 rounded-lg">
            <p class="text-xs text-gray-600 text-center">
                By creating an account, you agree to our Terms of Service and Privacy Policy
            </p>
        </div>

        <!-- Submit Button -->
        <button type="submit" 
                class="w-full bg-green-600 text-white py-2 px-4 rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition duration-200 font-medium">
            Create Account
        </button>

        <!-- Back to Login -->
        <div class="text-center">
            <span class="text-sm text-gray-600">Already have an account? </span>
            <a class="text-sm text-blue-600 hover:text-blue-500 font-medium" 
               href="{{ route('login') }}">
                Sign in
            </a>
        </div>
    </form>
</x-guest-layout>
