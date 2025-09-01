<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- SEO Meta Tags -->
    <meta name="description" content="@yield('description', 'Desa Mekarmukti, pemekaran Desa Cihampelas pada 1980, adalah desa termuda di Kecamatan Cihampelas, Kabupaten Bandung Barat. Temukan lebih lanjut di sini!')">
    <meta name="keywords" content="@yield('keywords', 'desa, mekarmukti, cihampelas, berita desa, desa mekarmukti')">
    <meta name="author" content="@yield('author', 'Desa Mekarmukti')">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Open Graph -->
    <meta property="og:title" content="@yield('title', 'Desa Mekarmukti')">
    <meta property="og:description" content="@yield('description', 'Desa Mekarmukti, pemekaran Desa Cihampelas pada 1980, adalah desa termuda di Kecamatan Cihampelas, Kabupaten Bandung Barat. Temukan lebih lanjut di sini!')">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">
    
    <title>@yield('title', 'Web Desa Mekarmukti Kec. Cihampelas Bandung Barat')</title>
    
    <!-- Favicons -->
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- CSS Framework & Icons -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <!-- Custom Tailwind Config -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'sans': ['Inter', 'system-ui', 'sans-serif'],
                    },
                    colors: {
                        'primary': {
                            50: '#fefbf3',
                            500: '#F59E0B',
                            600: '#d97706',
                            700: '#b45309'
                        },
                        'gray': {
                            800: '#1f2937',
                            900: '#111827'
                        }
                    }
                }
            }
        }
    </script>
    
    @stack('styles')
</head>

<body class="font-sans antialiased">
    <!-- Header -->
    <header id="header" class="fixed top-0 left-0 right-0 z-50 bg-gradient-to-r from-black via-gray-800 to-gray-700 border-b-2 border-primary-500 backdrop-blur-md">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between h-16 lg:h-20">
                
                <!-- Logo & Brand -->
                <div class="flex items-center space-x-4">
                    <img src="{{ asset('assets/img/motekar-bg.png') }}" 
                         alt="Logo Mekarmukti" 
                         class="w-10 h-10 lg:w-12 lg:h-12 rounded-lg shadow-md">
                    <div class="text-white">
                        <h1 class="text-xl lg:text-2xl font-bold leading-none">
                            <a href="{{ route('home') }}" class="hover:text-primary-500 transition-colors">
                                MEKARMUKTI
                            </a>
                        </h1>
                    </div>
                </div>
                
                <!-- Desktop Navigation -->
                <nav class="hidden lg:flex items-center space-x-8">
                    <a href="{{ route('home') }}" class="text-white hover:text-primary-500 transition-colors">
                        <i class="bi bi-house"></i>
                    </a>
                    
                    <!-- Profile Desa Dropdown -->
                    <div class="relative group">
                        <button class="flex items-center space-x-1 text-white hover:text-primary-500 transition-colors">
                            <span>Profile Desa</span>
                            <i class="bi bi-chevron-down text-sm"></i>
                        </button>
                        <div class="absolute top-full left-0 mt-2 w-48 bg-white rounded-lg shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
                            <a href="{{ route('sejarah') }}" class="block px-4 py-2 text-gray-700 hover:bg-primary-50 hover:text-primary-700 first:rounded-t-lg">Sejarah</a>
                            <a href="{{ route('visi') }}" class="block px-4 py-2 text-gray-700 hover:bg-primary-50 hover:text-primary-700">Visi & Misi</a>
                            <a href="{{ route('pemerintahan') }}" class="block px-4 py-2 text-gray-700 hover:bg-primary-50 hover:text-primary-700 last:rounded-b-lg">Struktur Organisasi</a>
                        </div>
                    </div>
                    
                    <!-- Informasi Desa Dropdown -->
                    <div class="relative group">
                        <button class="flex items-center space-x-1 text-white hover:text-primary-500 transition-colors">
                            <span>Informasi Desa</span>
                            <i class="bi bi-chevron-down text-sm"></i>
                        </button>
                        <div class="absolute top-full left-0 mt-2 w-48 bg-white rounded-lg shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
                            <a href="{{ route('berita') }}" class="block px-4 py-2 text-gray-700 hover:bg-primary-50 hover:text-primary-700 first:rounded-t-lg">Berita</a>
                            <a href="{{ route('galeri') }}" class="block px-4 py-2 text-gray-700 hover:bg-primary-50 hover:text-primary-700">Galeri</a>
                            <a href="{{ route('potensidesa') }}" class="block px-4 py-2 text-gray-700 hover:bg-primary-50 hover:text-primary-700 last:rounded-b-lg">Produk UMKM</a>
                        </div>
                    </div>
                    
                    <a href="{{ route('data.penduduk') }}" class="text-white hover:text-primary-500 transition-colors">Data Statistik</a>
                    <a href="{{ route('kontak') }}" class="text-white hover:text-primary-500 transition-colors">Kontak</a>
                    
                    <!-- CTA Button -->
                    <button type="button" 
                            class="bg-primary-500 hover:bg-primary-600 text-white px-4 py-2 rounded-lg font-medium transition-colors text-sm"
                            data-bs-toggle="modal" 
                            data-bs-target="#formPengaduan">
                        Buat Pengaduan
                    </button>
                </nav>
                
                <!-- Mobile Menu Button -->
                <button id="mobileMenuButton" 
                        class="lg:hidden text-white text-2xl p-2 hover:text-primary-500 transition-colors">
                    <i class="bi bi-list"></i>
                </button>
                
            </div>
        </div>
    </header>
    
    <!-- Mobile Navigation Panel -->
    <div id="mobileMenu" class="fixed inset-0 z-40 lg:hidden transform translate-x-full transition-transform duration-300 ease-in-out">
        <!-- Overlay -->
        <div id="mobileOverlay" class="absolute inset-0 bg-black bg-opacity-50"></div>
        
        <!-- Panel -->
        <div class="absolute top-0 right-0 h-full w-80 max-w-[80vw] bg-gray-900">
            <div class="flex flex-col h-full">
                <!-- Panel Header -->
                <div class="flex items-center justify-between p-4 border-b border-gray-700">
                    <span class="text-white font-semibold">Menu</span>
                    <button id="closeMobileMenu" class="text-white text-2xl hover:text-primary-500 transition-colors">
                        <i class="bi bi-x"></i>
                    </button>
                </div>
                
                <!-- Panel Content -->
                <nav class="flex-1 overflow-y-auto p-4">
                    <div class="space-y-2">
                        <a href="{{ route('home') }}" class="flex items-center space-x-3 text-white hover:bg-gray-800 px-3 py-2 rounded-lg transition-colors">
                            <i class="bi bi-house"></i>
                            <span>Beranda</span>
                        </a>
                        
                        <!-- Profile Desa -->
                        <div class="space-y-1">
                            <button class="mobile-dropdown-toggle flex items-center justify-between w-full text-white hover:bg-gray-800 px-3 py-2 rounded-lg transition-colors" 
                                    data-target="profileDropdown">
                                <span>Profile Desa</span>
                                <i class="bi bi-chevron-down transition-transform duration-200"></i>
                            </button>
                            <div id="profileDropdown" class="hidden ml-6 space-y-1">
                                <a href="{{ route('sejarah') }}" class="block text-gray-300 hover:text-white hover:bg-gray-800 px-3 py-2 rounded-lg transition-colors">Sejarah</a>
                                <a href="{{ route('visi') }}" class="block text-gray-300 hover:text-white hover:bg-gray-800 px-3 py-2 rounded-lg transition-colors">Visi & Misi</a>
                                <a href="{{ route('pemerintahan') }}" class="block text-gray-300 hover:text-white hover:bg-gray-800 px-3 py-2 rounded-lg transition-colors">Struktur Organisasi</a>
                            </div>
                        </div>
                        
                        <!-- Informasi Desa -->
                        <div class="space-y-1">
                            <button class="mobile-dropdown-toggle flex items-center justify-between w-full text-white hover:bg-gray-800 px-3 py-2 rounded-lg transition-colors" 
                                    data-target="informasiDropdown">
                                <span>Informasi Desa</span>
                                <i class="bi bi-chevron-down transition-transform duration-200"></i>
                            </button>
                            <div id="informasiDropdown" class="hidden ml-6 space-y-1">
                                <a href="{{ route('berita') }}" class="block text-gray-300 hover:text-white hover:bg-gray-800 px-3 py-2 rounded-lg transition-colors">Berita</a>
                                <a href="{{ route('galeri') }}" class="block text-gray-300 hover:text-white hover:bg-gray-800 px-3 py-2 rounded-lg transition-colors">Galeri</a>
                                <a href="{{ route('potensidesa') }}" class="block text-gray-300 hover:text-white hover:bg-gray-800 px-3 py-2 rounded-lg transition-colors">Produk UMKM</a>
                            </div>
                        </div>
                        
                        <a href="{{ route('data.penduduk') }}" class="flex items-center space-x-3 text-white hover:bg-gray-800 px-3 py-2 rounded-lg transition-colors">
                            <i class="bi bi-bar-chart"></i>
                            <span>Data Statistik</span>
                        </a>
                        
                        <a href="{{ route('kontak') }}" class="flex items-center space-x-3 text-white hover:bg-gray-800 px-3 py-2 rounded-lg transition-colors">
                            <i class="bi bi-envelope"></i>
                            <span>Kontak</span>
                        </a>
                        
                        <!-- CTA Button -->
                        <button type="button" 
                                class="w-full mt-4 bg-primary-500 hover:bg-primary-600 text-white px-4 py-3 rounded-lg font-medium transition-colors"
                                data-bs-toggle="modal" 
                                data-bs-target="#formPengaduan">
                            <i class="bi bi-chat-dots me-2"></i>
                            Buat Pengaduan
                        </button>
                    </div>
                </nav>
            </div>
        </div>
    </div>
    
    <!-- Main Content -->
    <main id="main" class="pt-16 lg:pt-20">
        @yield('content')
    </main>
    
    <!-- Footer -->
    <footer class="bg-gray-900 text-white">
        <div class="container mx-auto px-4 py-8">
            <div class="text-center">
                <p>&copy; {{ date('Y') }} Desa Mekarmukti. Semua hak dilindungi.</p>
            </div>
        </div>
    </footer>
    
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Mobile Navigation Script -->
    <script>
        // Mobile Menu functionality
        const mobileMenuButton = document.getElementById('mobileMenuButton');
        const mobileMenu = document.getElementById('mobileMenu');
        const closeMobileMenu = document.getElementById('closeMobileMenu');
        const mobileOverlay = document.getElementById('mobileOverlay');
        const mobileMenuIcon = mobileMenuButton.querySelector('i');
        
        // Open mobile menu
        mobileMenuButton.addEventListener('click', function() {
            mobileMenu.classList.remove('translate-x-full');
            mobileMenuIcon.className = 'bi bi-x';
            document.body.style.overflow = 'hidden';
        });
        
        // Close mobile menu
        function closeMobileMenuPanel() {
            mobileMenu.classList.add('translate-x-full');
            mobileMenuIcon.className = 'bi bi-list';
            document.body.style.overflow = '';
        }
        
        closeMobileMenu.addEventListener('click', closeMobileMenuPanel);
        mobileOverlay.addEventListener('click', closeMobileMenuPanel);
        
        // Mobile dropdown functionality
        const dropdownToggles = document.querySelectorAll('.mobile-dropdown-toggle');
        dropdownToggles.forEach(toggle => {
            toggle.addEventListener('click', function() {
                const target = this.getAttribute('data-target');
                const dropdown = document.getElementById(target);
                const chevron = this.querySelector('i');
                
                dropdown.classList.toggle('hidden');
                chevron.classList.toggle('rotate-180');
            });
        });
        
        // Close mobile menu on window resize
        window.addEventListener('resize', function() {
            if (window.innerWidth >= 1024) {
                closeMobileMenuPanel();
            }
        });
    </script>
    
    @stack('scripts')
</body>
</html>
