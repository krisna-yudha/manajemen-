<x-guest-layout>
    <!-- Header -->
    <div class="text-center mb-6">
        <h2 class="text-2xl font-bold text-gray-900">Forgot Password</h2>
        <p class="text-gray-600 mt-1">Enter your email to reset your password</p>
    </div>

    <!-- Information -->
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
        <p class="text-sm text-blue-800 text-center">
            <span class="font-medium">Reset Password:</span> Masukkan email Anda dan kami akan mengirimkan link untuk reset password
        </p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                Email Address
            </label>
            <input id="email" 
                   type="email" 
                   name="email" 
                   value="{{ old('email') }}" 
                   required 
                   autofocus
                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                   placeholder="Enter your registered email">
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <!-- Submit Button -->
        <button type="submit" 
                class="w-full bg-orange-600 text-white py-2 px-4 rounded-lg hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 transition duration-200 font-medium">
            Send Reset Link
        </button>

        <!-- Back to Login -->
        <div class="text-center">
            <span class="text-sm text-gray-600">Remember your password? </span>
            <a class="text-sm text-blue-600 hover:text-blue-500 font-medium" 
               href="{{ route('login') }}">
                Back to login
            </a>
        </div>
    </form>
</x-guest-layout>
