<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Echo Sanku - Ubah Sampah Jadi Uang Saku</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'sanku-primary': '#4A7C59',
                        'sanku-secondary': '#8B6F47',
                        'sanku-accent': '#7FB069',
                        'sanku-dark': '#2D3E2E',
                        'sanku-light': '#F5F3E7',
                        'sanku-cream': '#E8DCC4',
                        'sanku-brown': '#8b7355'
                    }
                }
            }
        }
    </script>
    <style>
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        @keyframes pulse-soft {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        .float-animation {
            animation: float 3s ease-in-out infinite;
        }
        .pulse-soft {
            animation: pulse-soft 2s ease-in-out infinite;
        }
        .navbar-scroll {
            transition: background-color 0.3s ease;
            background-color: rgba(45, 62, 46, 0.1);
        }
        .navbar-scroll.scrolled {
            background-color: rgba(45, 62, 46, 0.95);
            border-bottom-color: rgba(255, 255, 255, 0.05);
        }
    </style>
</head>
<body class="bg-gradient-to-br from-sanku-light via-sanku-cream to-white min-h-screen">
    <!-- Navigation -->
    <nav id="navbar" class="navbar-scroll fixed top-0 w-full z-50 border-b border-white border-opacity-10">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-3">
                <!-- Logo -->
                <a href="#" class="flex items-center gap-2 sm:gap-3 group">
                    <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-white flex items-center justify-center shadow-md group-hover:shadow-lg group-hover:scale-110 transition-all duration-300 overflow-hidden flex-shrink-0">
                        <img src="{{ asset('images/ldp.png') }}" alt="Echo Sanku icon" class="h-7 w-7 sm:h-9 sm:w-9 object-contain" onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 200 200%22%3E%3Ctext x=%2250%25%22 y=%2250%25%22 font-size=%2280%22 text-anchor=%22middle%22 dy=%22.3em%22%3E🌱%3C/text%3E%3C/svg%3E'">
                    </div>
                    <img src="{{ asset('images/logo.png') }}" alt="Echo Sanku branding" class="h-10 sm:h-14 object-contain flex-shrink-0">
                </a>

                <!-- Auth Buttons -->
                <div class="flex gap-2 sm:gap-3">
                    <a href="{{ route('login') }}" class="px-4 sm:px-6 py-2 rounded-lg font-semibold bg-sanku-accent text-white hover:bg-opacity-90 hover:scale-105 transition-all duration-300 shadow-lg text-sm sm:text-base">
                        Login
                    </a>
                    <a href="{{ route('register') }}" class="px-4 sm:px-6 py-2 rounded-lg font-semibold bg-sanku-light text-sanku-dark hover:bg-opacity-90 hover:scale-105 transition-all duration-300 shadow-lg text-sm sm:text-base">
                        Register
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16 lg:py-20">
        <!-- Main Title with Animation -->
        <div class="text-center mb-12 sm:mb-16">
            <div class="inline-block mb-6 float-animation">
                <span class="text-6xl sm:text-7xl">♻️</span>
            </div>
            <h2 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-sanku-dark mb-4 sm:mb-6 leading-tight">
                Ubah Sampahmu Jadi Uang! 💰
            </h2>
            <p class="text-lg sm:text-xl text-sanku-dark opacity-90 max-w-3xl mx-auto leading-relaxed">
                Bank Sampah RSUD Lanto Daeng Pasewang hadir untuk mengubah botol dan plastik bekas menjadi tabungan. Sampah bernilai, bumi sehat!
            </p>
        </div>

        <!-- Features Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 lg:gap-8 max-w-6xl mx-auto mb-12 sm:mb-16">
            <!-- Feature 1: Tukar Sampah -->
            <div class="group bg-sanku-light rounded-2xl shadow-xl p-6 sm:p-8 hover:shadow-2xl hover:scale-105 transition-all duration-300 cursor-pointer">
                <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-full mx-auto mb-4 sm:mb-6 bg-sanku-accent flex items-center justify-center group-hover:rotate-12 transition-transform duration-300 shadow-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 sm:h-10 sm:w-10 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                    </svg>
                </div>
                <h3 class="text-xl sm:text-2xl font-bold mb-3 text-sanku-dark text-center">Tukar Sampah</h3>
                <p class="text-sanku-secondary text-center leading-relaxed">Bawa botol & plastik, dapatkan uang tunai langsung</p>
            </div>

            <!-- Feature 2: Harga Jelas -->
            <div class="group bg-sanku-light rounded-2xl shadow-xl p-6 sm:p-8 hover:shadow-2xl hover:scale-105 transition-all duration-300 cursor-pointer">
                <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-full mx-auto mb-4 sm:mb-6 bg-sanku-accent flex items-center justify-center group-hover:rotate-12 transition-transform duration-300 shadow-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 sm:h-10 sm:w-10 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h3 class="text-xl sm:text-2xl font-bold mb-3 text-sanku-dark text-center">Harga Jelas</h3>
                <p class="text-sanku-secondary text-center leading-relaxed">Harga transparan untuk setiap jenis sampah</p>
            </div>

            <!-- Feature 3: Pantau Saldo -->
            <div class="group bg-sanku-light rounded-2xl shadow-xl p-6 sm:p-8 hover:shadow-2xl hover:scale-105 transition-all duration-300 cursor-pointer">
                <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-full mx-auto mb-4 sm:mb-6 bg-sanku-accent flex items-center justify-center group-hover:rotate-12 transition-transform duration-300 shadow-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 sm:h-10 sm:w-10 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                </div>
                <h3 class="text-xl sm:text-2xl font-bold mb-3 text-sanku-dark text-center">Pantau Saldo</h3>
                <p class="text-sanku-secondary text-center leading-relaxed">Lihat riwayat & total tabungan kapan saja</p>
            </div>
        </div>

        <!-- SECTION: Information & Location -->
        <section id="info" class="py-12">
            <div class="max-w-5xl mx-auto">
                <div class="text-center mb-12">
                    <div class="flex items-center justify-center gap-3 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-sanku-dark" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <h2 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-sanku-dark">
                            Informasi & Lokasi
                        </h2>
                    </div>
                    <p class="text-lg text-sanku-dark opacity-90">
                        Kunjungi kami dan mulai menabung dari sampah
                    </p>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Information Card -->
                    <div class="bg-white rounded-2xl shadow-2xl p-8">
                        <h3 class="text-2xl font-bold text-sanku-dark mb-6">Detail Informasi</h3>
                        
                        <div class="space-y-5">
                            <!-- Lokasi -->
                            <div class="flex items-start gap-4 p-4 bg-sanku-light rounded-xl hover:shadow-lg transition-all hover:scale-105 cursor-pointer">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-sanku-accent flex-shrink-0 mt-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <div>
                                    <p class="font-bold text-sanku-primary mb-1">Lokasi</p>
                                    <p class="text-sanku-dark">RSUD Lanto Daeng Pasewang, Jeneponto</p>
                                    <p class="text-sm text-sanku-secondary mt-1">Sulawesi Selatan, Indonesia</p>
                                </div>
                            </div>

                            <!-- Jam Operasional -->
                            <div class="flex items-start gap-4 p-4 bg-sanku-light rounded-xl hover:shadow-lg transition-all hover:scale-105 cursor-pointer">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-sanku-accent flex-shrink-0 mt-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <div>
                                    <p class="font-bold text-sanku-primary mb-1">Jam Operasional</p>
                                    <p class="text-sanku-dark">Senin - Sabtu: 10.00 - 12.00</p>
                                    <p class="text-sm text-sanku-secondary mt-1">Minggu & Libur Nasional Tutup</p>
                                </div>
                            </div>

                            <!-- Jenis Sampah -->
                            <div class="flex items-start gap-4 p-4 bg-sanku-light rounded-xl hover:shadow-lg transition-all hover:scale-105 cursor-pointer">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-sanku-accent flex-shrink-0 mt-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                </svg>
                                <div>
                                    <p class="font-bold text-sanku-primary mb-1">Jenis Sampah</p>
                                    <p class="text-sanku-dark">Botol plastik, Kardus, Plastik kemasan, Kertas</p>
                                </div>
                            </div>

                            <!-- Kontak -->
                            <div class="flex items-start gap-4 p-4 bg-sanku-light rounded-xl hover:shadow-lg transition-all hover:scale-105 cursor-pointer">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-sanku-accent flex-shrink-0 mt-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                                <div>
                                    <p class="font-bold text-sanku-primary mb-1">Kontak</p>
                                    <p class="text-sanku-dark">+62 852-4283-4442</p>
                                    <p class="text-sm text-sanku-secondary mt-1">Hubungi kami untuk info lebih lanjut</p>
                                </div>
                            </div>
                        </div>

                        <!-- CTA Button -->
                        <div class="mt-8">
                            <a href="#" class="flex items-center justify-center gap-2 w-full px-6 py-4 bg-sanku-primary hover:bg-sanku-accent text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                                <span>Daftar Sekarang</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                </svg>
                            </a>
                        </div>
                    </div>

                    <!-- Map Card -->
                    <div class="bg-white rounded-2xl shadow-2xl p-8">
                        <h3 class="text-2xl font-bold text-sanku-dark mb-6">Lokasi Kami</h3>
                        
                        <!-- Google Maps Embed -->
                        <div class="rounded-xl overflow-hidden shadow-lg mb-4 hover:shadow-2xl transition-shadow" style="height: 350px;">
                            <iframe 
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3973.123456789!2d119.7600689!3d-5.6846027!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2db937b6ab6a7b11%3A0x2c04b7458f7212a0!2sRSUD%20LANTO%20DG%20PASEWANG!5e0!3m2!1sen!2sid!4v1234567890"
                                width="100%" 
                                height="100%" 
                                style="border:0;" 
                                allowfullscreen="" 
                                loading="lazy" 
                                referrerpolicy="no-referrer-when-downgrade">
                            </iframe>
                        </div>
                        
                        <!-- Direction Button -->
                        <a href="https://www.google.com/maps/search/RSUD+LDP+Jeneponto" 
                        target="_blank"
                        class="flex items-center justify-center gap-2 w-full px-6 py-3 bg-sanku-accent hover:bg-sanku-primary text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                            </svg>
                            <span>Buka di Google Maps</span>
                        </a>

                        <p class="text-sm text-sanku-secondary text-center mt-4">
                            📍 Klik untuk petunjuk arah menuju lokasi
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Bottom Message -->
        <div class="text-center mt-12 sm:mt-16">
            <div class="inline-flex items-center gap-2 bg-white bg-opacity-20 backdrop-blur-sm px-6 py-3 rounded-full pulse-soft">
                <span class="text-2xl">🌱</span>
                <p class="text-sanku-dark font-medium">Mari bersama jaga bumi kita!</p>
                <span class="text-2xl">🌍</span>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-sanku-dark bg-opacity-30 backdrop-blur-sm mt-12 py-6 border-t border-white border-opacity-10">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <p class="text-white opacity-75 text-sm">
                &copy; 2025 Echo Sanku - Bank Sampah RSUD LDP. All rights reserved.
            </p>
        </div>
    </footer>

    <script>
        const navbar = document.getElementById('navbar');
        
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
    </script>
</body>
</html>