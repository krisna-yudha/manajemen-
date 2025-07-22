<x-guest-layout>
    <!-- Header -->
    <div class="text-center mb-6">
        <h2 class="text-2xl font-bold text-gray-900">Verify Your Email</h2>
        <p class="text-gray-600 mt-1">We've sent a verification link to your email</p>
    </div>

    <!-- Verification Information -->
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
        <p class="text-sm text-blue-800 text-center">
            Thanks for signing up! Please check your email and click the verification link to activate your account.
        </p>
    </div>

    <!-- Status Message -->
    @if (session('status') == 'verification-link-sent')
        <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
            <p class="text-sm text-green-800 text-center font-medium">
                ✓ A new verification link has been sent to your email address.
            </p>
        </div>
    @endif

    <!-- Action Buttons -->
    <div class="space-y-4">
        <!-- Resend Button -->
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" 
                    class="w-full bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-200 font-medium">
                Resend Verification Email
            </button>
        </form>

        <!-- Logout Button -->
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" 
                    class="w-full bg-gray-100 text-gray-700 py-2 px-4 rounded-lg hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition duration-200 font-medium">
                Sign Out
            </button>
        </form>
    </div>

    <!-- Help Text -->
    <div class="mt-6 text-center">
        <p class="text-xs text-gray-500">
            Check your spam folder if you don't see the email
        </p>
    </div>
</x-guest-layout>
