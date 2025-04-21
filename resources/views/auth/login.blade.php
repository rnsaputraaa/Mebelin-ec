<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4 text-sm text-white" :status="session('status')" />

    <h2 class="text-3xl font-bold text-white mb-4">Masuk</h2>
    <p class="text-sm text-white mb-6">Belum Punya Akun? <a href="{{ route('register') }}" class="text-blue-200 underline">Daftar</a></p>
    
    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf
        
        <!-- Email Address -->
        <div>
            <input id="email" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                type="email" name="email" value="{{ old('email') }}" placeholder="Email" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-xs text-red-200" />
        </div>
        
        <!-- Password -->
        <div>
            <input id="password" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                type="password" name="password" placeholder="Enter your password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-xs text-red-200" />
        </div>
        
        <!-- Remember Me -->
        <div class="flex items-center">
            <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
            <span class="ml-2 text-sm text-white">{{ __('Remember me') }}</span>
        </div>
        
        <!-- Forgot Password -->
        <div class="text-right">
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-xs text-white">
                    Reset Password 
                </a>
            @endif
        </div>
        
        <!-- Login Button -->
        <button type="submit" class="w-full bg-white text-gray-800 font-semibold py-2 px-4 rounded-md hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
            Login
        </button>
        
        <!-- Or register with -->
        <div class="text-center text-white text-xs">
            Or register with
        </div>
        
        <!-- Google Login -->
        <a href="#" class="w-full bg-white text-gray-800 font-semibold py-2 px-4 rounded-md hover:bg-gray-100 flex items-center justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" viewBox="0 0 24 24">
                <path d="M12.545 10.239v3.821h5.445c-.712 2.315-2.647 3.972-5.445 3.972-3.332 0-6.033-2.701-6.033-6.032s2.701-6.032 6.033-6.032c1.498 0 2.866.549 3.921 1.453l2.814-2.814C17.503 2.988 15.139 2 12.545 2 7.021 2 2.543 6.477 2.543 12s4.478 10 10.002 10c8.396 0 10.249-7.85 9.426-11.748l-9.426-.013z" fill="#4285F4"/>
            </svg>
            Google
        </a>
    </form>
</x-guest-layout>