<x-guest-layout>
    <!-- Header -->
    <div class="text-center mb-6">
        <h2 class="text-2xl font-bold text-gray-900">Welcome Back</h2>
        <p class="text-gray-600 mt-1">Sign in to your account</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                Email
            </label>
            <input id="email" 
                   type="email" 
                   name="email" 
                   value="{{ old('email') }}" 
                   required 
                   autofocus 
                   autocomplete="username"
                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                   placeholder="Enter your email">
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
                   autocomplete="current-password"
                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                   placeholder="Enter your password">
            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center">
            <input id="remember_me" 
                   type="checkbox" 
                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" 
                   name="remember">
            <label for="remember_me" class="ml-2 block text-sm text-gray-600">
                Remember me
            </label>
        </div>

        <!-- Submit Button -->
        <button type="submit" 
                class="w-full bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-200 font-medium">
            Sign In
        </button>

        <!-- Links -->
        <div class="mt-4 text-center space-y-2">
            @if (Route::has('password.request'))
                <a class="text-sm text-blue-600 hover:text-blue-500" 
                   href="{{ route('password.request') }}">
                    Forgot your password?
                </a>
            @endif
            
            @if (Route::has('register'))
                <div class="text-sm text-gray-600">
                    Don't have an account? 
                    <a class="text-blue-600 hover:text-blue-500 font-medium" 
                       href="{{ route('register') }}">
                        Sign up
                    </a>
                </div>
            @endif
        </div>
    </form>
</x-guest-layout>
