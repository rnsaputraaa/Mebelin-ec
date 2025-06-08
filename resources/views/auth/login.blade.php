<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="icon" type="image/png" href="img/logo1.png">
    <link href="https://fonts.googleapis.com/css2?family=Inter&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    @vite('resources/css/app.css')
</head>

<body class="min-h-screen flex items-center justify-center" style="background-color: #C9B194;">
    <div class="w-full max-w-5xl mx-4">
        <div class="text-center mb-5 mt-5">
            <img src="img/logo.png" alt="MEBELIN" class="mx-auto h-16">
        </div>

        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden p-8">
                <div class="flex flex-col md:flex-row gap-8">
                    <div class="w-full hidden md:flex items-center justify-center">
                        <div class="w-full max-w-md">
                            <img src="img/log.png" alt="Furniture Illustration" class="w-full h-auto rounded-3xl">
                        </div>
                    </div>

                    <div class="w-full md:w-1/2 flex items-center justify-center">
                        <div class="w-full max-w-sm p-8 rounded-3xl shadow-lg" style="background-color: #BAA388;">
                            <div class="text-center mb-8">
                                <h2 class="text-3xl font-bold text-white mb-2">Masuk</h2>
                                <p class="text-white text-sm mt-2">Belum punya akun? <a href="{{ route('register') }}" class="text-blue-900 underline hover:text-white">Daftar</a></p>
                            </div>

                        <form method="POST" action="{{ route('login') }}" class="space-y-6">
                            @csrf

                            <div>
                                <input 
                                    id="email" 
                                    class="w-full px-4 py-3 rounded-lg border-0 bg-white placeholder-gray-500 text-gray-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-white" 
                                    type="email" 
                                    name="email" 
                                    value="{{ old('email') }}" 
                                    placeholder="Email"
                                    required 
                                    autofocus 
                                />
                                @error('email')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <input 
                                    id="password" 
                                    class="w-full px-4 py-3 rounded-lg border-0 bg-white placeholder-gray-500 text-gray-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-white"
                                    type="password"
                                    name="password"
                                    placeholder="Enter your password"
                                    required 
                                />
                                @error('password')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="text-right">
                                @if (Route::has('password.request'))
                                    <a class="text-gray-900 text-sm hover:text-white" href="{{ route('password.request') }}">
                                        Reset Password
                                    </a>
                                @endif
                            </div>

                            <button type="submit" class="w-full bg-white text-gray-900 font-semibold py-3 rounded-lg shadow-sm">
                                Login
                            </button>

                            <div class="flex items-center py-4">
                                <div class="flex-grow h-px bg-white"></div>
                                <span class="px-4 text-gray-900 text-sm">Or Login with</span>
                                <div class="flex-grow h-px bg-white"></div>
                            </div>

                            <button type="button" class="w-full bg-white text-gray-800 font-semibold py-3 rounded-lg flex items-center justify-center space-x-2 shadow-md">
                                <svg class="w-5 h-5" viewBox="0 0 24 24">
                                    <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                                    <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                                    <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                                    <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                                </svg>
                                <span>Google</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center mt-5">
            <p class="text-gray-900 text-sm mb-5">© 2025 Mebelin. All rights reserved.</p>
        </div>
    </div>
</body>
</html>