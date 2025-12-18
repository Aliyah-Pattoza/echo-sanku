<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - Echo Sanku</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-sanku-primary to-sanku-secondary min-h-screen">
    <div class="min-h-screen flex items-center justify-center p-4 py-8">
        <div class="w-full max-w-md">
            <!-- Logo Section -->
            <div class="text-center mb-6">
                <a href="{{ route('welcome') }}" class="inline-flex items-center gap-3 mb-4 hover:scale-105 transition-all">
                    <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-full bg-white flex items-center justify-center shadow-lg">
                        <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-white flex items-center justify-center group-hover:scale-110 transition-transform duration-300 overflow-hidden">
                            <img src="{{ asset('images/ldp.png') }}" alt="Echo Sanku logo" class="h-7 w-7 sm:h-10 sm:w-10 object-contain">
                        </div>
                    </div>
                    <div class="text-white text-left">
                        <h1 class="text-xl sm:text-2xl font-bold">ECHO SANKU</h1>
                        <p class="text-xs sm:text-sm opacity-90">Sampah Jadi Uang Saku</p>
                    </div>
                </a>
                <h2 class="text-2xl sm:text-3xl font-bold text-white">Bergabung Sekarang! 🚀</h2>
                <p class="text-sanku-light opacity-90 mt-2 text-sm sm:text-base">Buat akun dan mulai menabung dari sampah</p>
            </div>

            <!-- Register Card -->
            <div class="bg-white rounded-2xl shadow-2xl p-6 sm:p-8">
                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <!-- Name -->
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-semibold text-sanku-dark mb-2">
                            Nama Lengkap
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-sanku-secondary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <input 
                                id="name" 
                                type="text" 
                                name="name" 
                                value="{{ old('name') }}" 
                                required 
                                autofocus 
                                autocomplete="name"
                                class="w-full pl-10 pr-4 py-2.5 sm:py-3 border-2 border-sanku-cream rounded-lg focus:outline-none focus:ring-2 focus:ring-sanku-accent focus:border-transparent transition-all text-sm sm:text-base"
                                placeholder="Masukkan nama lengkap"
                            >
                        </div>
                        @error('name')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email Address -->
                    <div class="mb-4">
                        <label for="email" class="block text-sm font-semibold text-sanku-dark mb-2">
                            Email
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-sanku-secondary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                                </svg>
                            </div>
                            <input 
                                id="email" 
                                type="email" 
                                name="email" 
                                value="{{ old('email') }}" 
                                required 
                                autocomplete="username"
                                class="w-full pl-10 pr-4 py-2.5 sm:py-3 border-2 border-sanku-cream rounded-lg focus:outline-none focus:ring-2 focus:ring-sanku-accent focus:border-transparent transition-all text-sm sm:text-base"
                                placeholder="nama@email.com"
                            >
                        </div>
                        @error('email')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="mb-4">
                        <label for="password" class="block text-sm font-semibold text-sanku-dark mb-2">
                            Password
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-sanku-secondary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <input 
                                id="password" 
                                type="password" 
                                name="password" 
                                required 
                                autocomplete="new-password"
                                class="w-full pl-10 pr-4 py-2.5 sm:py-3 border-2 border-sanku-cream rounded-lg focus:outline-none focus:ring-2 focus:ring-sanku-accent focus:border-transparent transition-all text-sm sm:text-base"
                                placeholder="Minimal 8 karakter"
                            >
                        </div>
                        @error('password')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div class="mb-6">
                        <label for="password_confirmation" class="block text-sm font-semibold text-sanku-dark mb-2">
                            Konfirmasi Password
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-sanku-secondary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <input 
                                id="password_confirmation" 
                                type="password" 
                                name="password_confirmation" 
                                required 
                                autocomplete="new-password"
                                class="w-full pl-10 pr-4 py-2.5 sm:py-3 border-2 border-sanku-cream rounded-lg focus:outline-none focus:ring-2 focus:ring-sanku-accent focus:border-transparent transition-all text-sm sm:text-base"
                                placeholder="Ulangi password"
                            >
                        </div>
                        @error('password_confirmation')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <button 
                        type="submit"
                        class="w-full py-2.5 sm:py-3 px-4 bg-sanku-primary hover:bg-sanku-accent text-white font-bold rounded-lg shadow-lg hover:shadow-xl transition-all transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-sanku-accent focus:ring-offset-2 text-sm sm:text-base"
                    >
                        Daftar Sekarang
                    </button>
                </form>

                <!-- Login Link -->
                <div class="mt-6 text-center">
                    <p class="text-sanku-secondary text-sm sm:text-base">
                        Sudah punya akun? 
                        <a href="{{ route('login') }}" class="text-sanku-primary hover:text-sanku-accent font-bold transition-colors">
                            Masuk di sini
                        </a>
                    </p>
                </div>
            </div>

            <!-- Info -->
            <div class="mt-6 text-center">
                <p class="text-white text-xs sm:text-sm opacity-90">
                    🌱 Gratis dan mudah! Mulai berkontribusi untuk lingkungan
                </p>
            </div>
        </div>
    </div>
</body>
</html>