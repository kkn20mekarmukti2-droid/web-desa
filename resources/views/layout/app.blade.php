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
    
    <!-- Fonts - Enhanced Typography -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Roboto:300,300i,400,400i,500,500i,700,700i&display=swap" rel="stylesheet">
    
    <!-- CSS Framework & Assets -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <!-- Enhanced CSS Libraries -->
    <link href="{{ asset('assets/vendor/animate.css/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/aos/aos.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">
    
    <!-- FontAwesome Icons -->
    <script src="https://kit.fontawesome.com/994f229ca1.js" crossorigin="anonymous"></script>
    
    <!-- Custom Styles -->
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
    
    <!-- Enhanced Tailwind Config & Custom Styles -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'sans': ['Open Sans', 'Roboto', 'system-ui', 'sans-serif'],
                        'heading': ['Roboto', 'Open Sans', 'sans-serif'],
                    },
                    colors: {
                        'primary': {
                            50: '#fefbf3',
                            100: '#fef3c7',
                            200: '#fde68a', 
                            300: '#fcd34d',
                            400: '#fbbf24',
                            500: '#F59E0B',
                            600: '#d97706',
                            700: '#b45309',
                            800: '#92400e',
                            900: '#78350f'
                        },
                        'gray': {
                            50: '#f9fafb',
                            100: '#f3f4f6',
                            200: '#e5e7eb',
                            300: '#d1d5db',
                            400: '#9ca3af',
                            500: '#6b7280',
                            600: '#4b5563',
                            700: '#374151',
                            800: '#1f2937',
                            900: '#111827'
                        }
                    },
                    animation: {
                        'fadeIn': 'fadeIn 0.5s ease-in-out',
                        'slideIn': 'slideIn 0.3s ease-out',
                        'bounce-slow': 'bounce 2s infinite',
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': { opacity: '0' },
                            '100%': { opacity: '1' }
                        },
                        slideIn: {
                            '0%': { transform: 'translateX(100%)' },
                            '100%': { transform: 'translateX(0)' }
                        }
                    }
                }
            }
        }
    </script>
    
    <style>
        /* Enhanced UI/UX Styling */
        body {
            font-family: 'Open Sans', 'Roboto', sans-serif;
        }
        
        /* Enhanced Header Styling */
        #header {
            background: linear-gradient(135deg, #000000, #1f2937, #374151);
            border-bottom: 3px solid #F59E0B;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
        }
        
        /* Enhanced Navigation Styling */
        .nav-link {
            position: relative;
            transition: all 0.3s ease;
            font-weight: 500;
        }
        
        .nav-link:hover {
            transform: translateY(-2px);
        }
        
        .nav-link::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 50%;
            width: 0;
            height: 2px;
            background: #F59E0B;
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }
        
        .nav-link:hover::after {
            width: 100%;
        }
        
        /* FORCE DROPDOWN TO WORK - Override all conflicts */
        .nav-dropdown-pure:hover .dropdown-content {
            opacity: 1 !important;
            visibility: visible !important;
            transform: translateY(0) !important;
            display: block !important;
        }
        
        .nav-dropdown-pure .dropdown-content {
            display: block !important;
        }
        
        .nav-dropdown-pure:hover .dropdown-arrow {
            transform: rotate(180deg) !important;
        }
        
        .dropdown-link:hover {
            background: rgba(245, 158, 11, 0.2) !important;
            transform: translateX(5px) !important;
            color: #FFA500 !important;
        }
        
        /* Additional force styling */
        nav .nav-dropdown-pure {
            position: relative !important;
            display: inline-block !important;
        }
        
        nav .nav-dropdown-pure .dropdown-content {
            position: absolute !important;
            top: 100% !important;
            left: 0 !important;
            z-index: 9999 !important;
        }

        /* Enhanced Button Styling */
        .btn-enhanced {
            background: linear-gradient(135deg, #F59E0B, #FFA500, #FF8C00) !important;
            border: none !important;
            color: white !important;
            font-weight: 600 !important;
            border-radius: 12px !important;
            transition: all 0.3s ease !important;
            box-shadow: 0 4px 15px rgba(245, 158, 11, 0.3) !important;
            position: relative !important;
            overflow: hidden !important;
        }
        
        .btn-enhanced::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s ease;
        }
        
        .btn-enhanced:hover {
            background: linear-gradient(135deg, #D97706, #FF8C00, #E67E22) !important;
            transform: translateY(-3px) !important;
            box-shadow: 0 8px 25px rgba(245, 158, 11, 0.4) !important;
            color: white !important;
        }
        
        .btn-enhanced:hover::before {
            left: 100%;
        }
        
        /* Enhanced Mobile Menu Styling */
        .mobile-menu-panel {
            background: linear-gradient(135deg, #111827, #1f2937) !important;
            box-shadow: -10px 0 40px rgba(0, 0, 0, 0.5) !important;
            border-left: 3px solid #F59E0B !important;
        }
        
        .mobile-menu-item {
            transition: all 0.3s ease !important;
            border-radius: 10px !important;
            margin: 4px 0 !important;
        }
        
        .mobile-menu-item:hover {
            background: rgba(245, 158, 11, 0.1) !important;
            transform: translateX(8px) !important;
            border-left: 3px solid #F59E0B !important;
            padding-left: 1rem !important;
        }
        
        /* Enhanced Mobile Menu Button */
        #mobileMenuButton {
            position: relative;
            transition: all 0.3s ease;
        }
        
        #mobileMenuButton:hover {
            transform: scale(1.1);
            background: rgba(245, 158, 11, 0.2);
            border-radius: 8px;
        }
        
        /* Enhanced Close Button */
        #closeMobileMenu {
            background: rgba(245, 158, 11, 0.1);
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            cursor: pointer !important;
            border: none;
            outline: none;
            z-index: 10001 !important;
            position: relative !important;
            pointer-events: auto !important;
        }
        
        #closeMobileMenu:hover {
            background: rgba(245, 158, 11, 0.3);
            transform: rotate(90deg) scale(1.1);
        }
        
        #closeMobileMenu:active {
            transform: rotate(90deg) scale(0.95);
            background: rgba(245, 158, 11, 0.5);
        }
        
        /* Logo Enhancement */
        .logo-img {
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }
        
        .logo-img:hover {
            transform: rotate(5deg) scale(1.05);
            border-color: #F59E0B;
            box-shadow: 0 0 20px rgba(245, 158, 11, 0.5);
        }
        
        /* Brand Text - Enhanced Responsive Style */
        .brand-text {
            color: #ffffff !important;
            text-decoration: none !important;
            transition: all 0.3s ease !important;
            font-size: 1.6rem !important; /* Reduced for mobile */
            font-weight: 700 !important;
            line-height: 1 !important;
            white-space: nowrap !important; /* Prevent text wrapping */
        }
        
        .brand-text:hover {
            color: #F59E0B !important;
            text-decoration: none !important;
        }
        
        /* Desktop size for brand text */
        @media (min-width: 768px) {
            .brand-text {
                font-size: 2.2rem !important;
            }
        }
        
        /* Header flex improvements */
        .header-container {
            display: flex !important;
            align-items: center !important;
            justify-content: space-between !important;
            gap: 1rem !important;
            width: 100% !important;
        }
        
        .logo-section {
            display: flex !important;
            align-items: center !important;
            gap: 0.75rem !important;
            flex-shrink: 1 !important;
            min-width: 0 !important;
            overflow: hidden !important;
        }
        
        /* Enhanced Mobile Menu Button Positioning */
        #mobileMenuButton {
            position: relative !important;
            transition: all 0.3s ease !important;
            flex-shrink: 0 !important; /* Prevent hamburger from shrinking */
            min-width: 44px !important;
            min-height: 44px !important;
            z-index: 1001 !important;
        }
        
        /* Mobile container padding optimization */
        @media (max-width: 767px) {
            .container {
                padding-left: 1rem !important;
                padding-right: 1rem !important;
            }
            
            .header-container {
                gap: 0.5rem !important;
            }
            
            .logo-section {
                gap: 0.5rem !important;
            }
            
            .logo-img {
                width: 2rem !important;
                height: 2rem !important;
            }
        }
        
        /* Enhanced Footer Styling */
        footer {
            background: linear-gradient(135deg, #1f2937 0%, #111827 100%) !important;
        }
        
        footer h3, footer h4 {
            color: #ffffff !important;
            font-weight: 600 !important;
        }
        
        footer .social-links a {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid #374151;
            border-radius: 50%;
            transition: all 0.3s ease;
        }
        
        footer .social-links a:hover {
            background-color: #F59E0B;
            border-color: #F59E0B;
            transform: translateY(-2px);
        }
        
        footer .footer-link {
            transition: all 0.3s ease;
            position: relative;
        }
        
        footer .footer-link:hover {
            color: #F59E0B !important;
            padding-left: 4px;
        }
        
        footer .contact-item {
            transition: all 0.3s ease;
        }
        
        footer .contact-item:hover {
            transform: translateX(2px);
        }
        
        /* Footer responsive */
        @media (max-width: 768px) {
            footer .grid {
                grid-template-columns: 1fr !important;
                gap: 2rem !important;
            }
        }
    </style>
    
    @stack('styles')
</head>

<body class="font-sans antialiased">
    <!-- Header -->
    <header id="header" class="fixed top-0 left-0 right-0 z-50">
        <div class="container mx-auto px-4">
            <div class="header-container h-16 lg:h-20">
                
                <!-- Logo & Brand -->
                <div class="logo-section">
                    <img src="{{ asset('assets/img/motekar-bg.png') }}" 
                         alt="Logo Mekarmukti" 
                         class="logo-img w-8 h-8 lg:w-12 lg:h-12 rounded-lg shadow-md flex-shrink-0">
                    <div class="logo">
                        <h1 class="text-white mb-0 leading-none font-heading">
                            <a href="{{ route('home') }}" class="brand-text">
                                <span>MEKARMUKTI</span>
                            </a>
                        </h1>
                    </div>
                </div>
                
                <!-- Desktop Navigation -->
                <nav class="hidden lg:flex items-center space-x-8">
                    <a href="{{ route('home') }}" class="nav-link text-white hover:text-primary-500 transition-all duration-300">
                        <i class="bi bi-house-door-fill text-lg"></i>
                    </a>
                    
                    <!-- Profile Desa Dropdown - Pure CSS -->
                    <div class="nav-dropdown-pure" style="position: relative; display: inline-block;">
                        <button class="nav-link flex items-center space-x-2 text-white hover:text-primary-500 transition-all duration-300 font-medium" style="background: none; border: none; cursor: pointer;">
                            <i class="bi bi-people-fill"></i>
                            <span>Profile Desa</span>
                            <i class="bi bi-chevron-down text-xs dropdown-arrow" style="transition: transform 0.3s ease;"></i>
                        </button>
                        
                        <div class="dropdown-content" style="
                            position: absolute;
                            top: 100%;
                            left: 0;
                            background: rgba(0, 0, 0, 0.95);
                            backdrop-filter: blur(15px);
                            border: 1px solid rgba(245, 158, 11, 0.3);
                            border-radius: 12px;
                            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.4);
                            min-width: 220px;
                            z-index: 1000;
                            opacity: 0;
                            visibility: hidden;
                            transform: translateY(10px);
                            transition: all 0.3s ease;
                            margin-top: 8px;
                            padding: 8px;
                        ">
                            <a href="{{ route('sejarah') }}" style="
                                display: flex;
                                align-items: center;
                                padding: 12px 16px;
                                color: white;
                                text-decoration: none;
                                border-radius: 8px;
                                margin: 2px 0;
                                transition: all 0.3s ease;
                            " class="dropdown-link">
                                <i class="bi bi-clock-history" style="color: #F59E0B; margin-right: 8px;"></i>
                                Sejarah
                            </a>
                            <a href="{{ route('visi') }}" style="
                                display: flex;
                                align-items: center;
                                padding: 12px 16px;
                                color: white;
                                text-decoration: none;
                                border-radius: 8px;
                                margin: 2px 0;
                                transition: all 0.3s ease;
                            " class="dropdown-link">
                                <i class="bi bi-eye-fill" style="color: #F59E0B; margin-right: 8px;"></i>
                                Visi & Misi
                            </a>
                            <a href="{{ route('pemerintahan') }}" style="
                                display: flex;
                                align-items: center;
                                padding: 12px 16px;
                                color: white;
                                text-decoration: none;
                                border-radius: 8px;
                                margin: 2px 0;
                                transition: all 0.3s ease;
                            " class="dropdown-link">
                                <i class="bi bi-diagram-3-fill" style="color: #F59E0B; margin-right: 8px;"></i>
                                Struktur Organisasi
                            </a>
                        </div>
                    </div>
                    
                    <!-- Informasi Desa Dropdown - Pure CSS -->
                    <div class="nav-dropdown-pure" style="position: relative; display: inline-block;">
                        <button class="nav-link flex items-center space-x-2 text-white hover:text-primary-500 transition-all duration-300 font-medium" style="background: none; border: none; cursor: pointer;">
                            <i class="bi bi-info-circle-fill"></i>
                            <span>Informasi Desa</span>
                            <i class="bi bi-chevron-down text-xs dropdown-arrow" style="transition: transform 0.3s ease;"></i>
                        </button>
                        
                        <div class="dropdown-content" style="
                            position: absolute;
                            top: 100%;
                            left: 0;
                            background: rgba(0, 0, 0, 0.95);
                            backdrop-filter: blur(15px);
                            border: 1px solid rgba(245, 158, 11, 0.3);
                            border-radius: 12px;
                            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.4);
                            min-width: 220px;
                            z-index: 1000;
                            opacity: 0;
                            visibility: hidden;
                            transform: translateY(10px);
                            transition: all 0.3s ease;
                            margin-top: 8px;
                            padding: 8px;
                        ">
                            <a href="{{ route('berita') }}" style="
                                display: flex;
                                align-items: center;
                                padding: 12px 16px;
                                color: white;
                                text-decoration: none;
                                border-radius: 8px;
                                margin: 2px 0;
                                transition: all 0.3s ease;
                            " class="dropdown-link">
                                <i class="bi bi-newspaper" style="color: #F59E0B; margin-right: 8px;"></i>
                                Berita
                            </a>
                            <a href="{{ route('galeri') }}" style="
                                display: flex;
                                align-items: center;
                                padding: 12px 16px;
                                color: white;
                                text-decoration: none;
                                border-radius: 8px;
                                margin: 2px 0;
                                transition: all 0.3s ease;
                            " class="dropdown-link">
                                <i class="bi bi-images" style="color: #F59E0B; margin-right: 8px;"></i>
                                Galeri
                            </a>
                            <a href="{{ route('potensidesa') }}" style="
                                display: flex;
                                align-items: center;
                                padding: 12px 16px;
                                color: white;
                                text-decoration: none;
                                border-radius: 8px;
                                margin: 2px 0;
                                transition: all 0.3s ease;
                            " class="dropdown-link">
                                <i class="bi bi-gem" style="color: #F59E0B; margin-right: 8px;"></i>
                                Potensi Desa
                            </a>
                        </div>
                    </div>
                    
                    <a href="{{ route('data.penduduk') }}" class="nav-link text-white hover:text-primary-500 transition-all duration-300 flex items-center space-x-2 font-medium">
                        <i class="bi bi-bar-chart-fill"></i>
                        <span>Data Statistik</span>
                    </a>
                    
                    <a href="{{ route('kontak') }}" class="nav-link text-white hover:text-primary-500 transition-all duration-300 flex items-center space-x-2 font-medium">
                        <i class="bi bi-envelope-fill"></i>
                        <span>Kontak</span>
                    </a>
                    
                    <!-- Enhanced CTA Button -->
                    <button type="button" 
                            class="btn-enhanced px-6 py-3 text-sm font-semibold flex items-center space-x-2"
                            data-bs-toggle="modal" 
                            data-bs-target="#formPengaduan">
                        <i class="bi bi-chat-dots-fill"></i>
                        <span>Buat Pengaduan</span>
                    </button>
                </nav>
                
                <!-- Enhanced Mobile Menu Button -->
                <button id="mobileMenuButton" 
                        class="lg:hidden text-white text-2xl p-3 hover:text-primary-500 transition-all duration-300 rounded-lg">
                    <i class="bi bi-list"></i>
                </button>
                
            </div>
        </div>
    </header>
    
    <!-- Enhanced Mobile Navigation Panel -->
    <div id="mobileMenu" class="fixed inset-0 z-40 lg:hidden transform translate-x-full transition-transform duration-300 ease-in-out">
        <!-- Enhanced Overlay -->
        <div id="mobileOverlay" class="absolute inset-0 bg-black bg-opacity-60 backdrop-blur-sm"></div>
        
        <!-- Enhanced Panel -->
        <div class="mobile-menu-panel absolute top-0 right-0 h-full w-80 max-w-[85vw]">
            <div class="flex flex-col h-full">
                <!-- Enhanced Panel Header -->
                <div class="flex items-center justify-between p-6 border-b border-gray-600">
                    <div class="flex items-center space-x-3">
                        <img src="{{ asset('assets/img/motekar-bg.png') }}" 
                             alt="Logo" 
                             class="w-8 h-8 rounded-lg">
                        <span class="text-white font-bold text-lg">Menu</span>
                    </div>
                    <!-- Tombol close disembunyikan sementara -->
                    <button id="closeMobileMenu" 
                            class="text-white text-2xl hover:text-primary-500 transition-all duration-300 hidden"
                            aria-label="Close Menu">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>
                
                <!-- Enhanced Panel Content -->
                <nav class="flex-1 overflow-y-auto p-6">
                    <div class="space-y-3">
                        <!-- Home -->
                        <a href="{{ route('home') }}" class="mobile-menu-item flex items-center space-x-4 text-white hover:bg-gray-800 px-4 py-3 rounded-xl transition-all duration-300">
                            <i class="bi bi-house-door-fill text-primary-500 text-xl"></i>
                            <span class="font-medium">Beranda</span>
                        </a>
                        
                        <!-- Profile Desa -->
                        <div class="space-y-2">
                            <button class="mobile-dropdown-toggle mobile-menu-item flex items-center justify-between w-full text-white hover:bg-gray-800 px-4 py-3 rounded-xl transition-all duration-300" 
                                    data-target="profileDropdown">
                                <div class="flex items-center space-x-4">
                                    <i class="bi bi-people-fill text-primary-500 text-xl"></i>
                                    <span class="font-medium">Profile Desa</span>
                                </div>
                                <i class="bi bi-chevron-down transition-transform duration-300"></i>
                            </button>
                            <div id="profileDropdown" class="hidden ml-12 space-y-2">
                                <a href="{{ route('sejarah') }}" class="mobile-menu-item block text-gray-300 hover:text-white hover:bg-gray-800 px-4 py-2 rounded-lg transition-all duration-300">
                                    <i class="bi bi-clock-history me-2"></i>Sejarah
                                </a>
                                <a href="{{ route('visi') }}" class="mobile-menu-item block text-gray-300 hover:text-white hover:bg-gray-800 px-4 py-2 rounded-lg transition-all duration-300">
                                    <i class="bi bi-eye-fill me-2"></i>Visi & Misi
                                </a>
                                <a href="{{ route('pemerintahan') }}" class="mobile-menu-item block text-gray-300 hover:text-white hover:bg-gray-800 px-4 py-2 rounded-lg transition-all duration-300">
                                    <i class="bi bi-diagram-3-fill me-2"></i>Struktur Organisasi
                                </a>
                            </div>
                        </div>
                        
                        <!-- Informasi Desa -->
                        <div class="space-y-2">
                            <button class="mobile-dropdown-toggle mobile-menu-item flex items-center justify-between w-full text-white hover:bg-gray-800 px-4 py-3 rounded-xl transition-all duration-300" 
                                    data-target="informasiDropdown">
                                <div class="flex items-center space-x-4">
                                    <i class="bi bi-info-circle-fill text-primary-500 text-xl"></i>
                                    <span class="font-medium">Informasi Desa</span>
                                </div>
                                <i class="bi bi-chevron-down transition-transform duration-300"></i>
                            </button>
                            <div id="informasiDropdown" class="hidden ml-12 space-y-2">
                                <a href="{{ route('berita') }}" class="mobile-menu-item block text-gray-300 hover:text-white hover:bg-gray-800 px-4 py-2 rounded-lg transition-all duration-300">
                                    <i class="bi bi-newspaper me-2"></i>Berita
                                </a>
                                <a href="{{ route('galeri') }}" class="mobile-menu-item block text-gray-300 hover:text-white hover:bg-gray-800 px-4 py-2 rounded-lg transition-all duration-300">
                                    <i class="bi bi-images me-2"></i>Galeri
                                </a>
                                <a href="{{ route('potensidesa') }}" class="mobile-menu-item block text-gray-300 hover:text-white hover:bg-gray-800 px-4 py-2 rounded-lg transition-all duration-300">
                                    <i class="bi bi-gem me-2"></i>Potensi Desa
                                </a>
                            </div>
                        </div>
                        
                        <!-- Data Statistik -->
                        <a href="{{ route('data.penduduk') }}" class="mobile-menu-item flex items-center space-x-4 text-white hover:bg-gray-800 px-4 py-3 rounded-xl transition-all duration-300">
                            <i class="bi bi-bar-chart-fill text-primary-500 text-xl"></i>
                            <span class="font-medium">Data Statistik</span>
                        </a>
                        
                        <!-- Kontak -->
                        <a href="{{ route('kontak') }}" class="mobile-menu-item flex items-center space-x-4 text-white hover:bg-gray-800 px-4 py-3 rounded-xl transition-all duration-300">
                            <i class="bi bi-envelope-fill text-primary-500 text-xl"></i>
                            <span class="font-medium">Kontak</span>
                        </a>
                        
                        <!-- Enhanced CTA Button -->
                        <div class="pt-4 border-t border-gray-600 mt-6">
                            <button type="button" 
                                    class="btn-enhanced w-full px-6 py-4 text-center font-semibold flex items-center justify-center space-x-3"
                                    data-bs-toggle="modal" 
                                    data-bs-target="#formPengaduan">
                                <i class="bi bi-chat-dots-fill text-lg"></i>
                                <span>Buat Pengaduan</span>
                            </button>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </div>
    
    <!-- Main Content -->
    <main id="main" class="pt-16 lg:pt-20">
        @yield('content')
    </main>
    
    <!-- Enhanced Footer -->
    <footer class="bg-gray-900 text-white">
        <div class="container mx-auto px-4 py-12">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                
                <!-- About Desa Section -->
                <div class="lg:col-span-2">
                    <div class="flex items-center space-x-3 mb-4">
                        <img src="{{ asset('assets/img/motekar-bg.png') }}" 
                             alt="Logo Mekarmukti" 
                             class="w-12 h-12 rounded-lg shadow-md">
                        <div>
                            <h3 class="text-xl font-bold text-white">Desa Mekarmukti</h3>
                            <p class="text-gray-300 text-sm">Cihampelas, Bandung Barat</p>
                        </div>
                    </div>
                    <p class="text-gray-300 mb-4 leading-relaxed">
                        Desa Mekarmukti Kecamatan Cihampelas Kabupaten Bandung Barat adalah Desa yang merupakan Pamekaran dari Desa Cihampelas yang pada waktu itu Kecamatan Cililin, Kawedanaan Cililin, Kabupaten Bandung.
                    </p>
                    <div class="social-links flex space-x-4">
                        <a href="https://www.facebook.com/desamekarmukti" target="_blank" class="text-gray-400 hover:text-white transition-colors duration-300" title="Facebook Desa Mekarmukti">
                            <i class="fab fa-facebook-f text-lg"></i>
                        </a>
                        <a href="https://www.instagram.com/mekarmukti_id/" target="_blank" class="text-gray-400 hover:text-white transition-colors duration-300" title="Instagram Desa Mekarmukti">
                            <i class="fab fa-instagram text-lg"></i>
                        </a>
                        <a href="https://www.youtube.com/@desamekarmukti_motekar" target="_blank" class="text-gray-400 hover:text-white transition-colors duration-300" title="YouTube Desa Mekarmukti">
                            <i class="fab fa-youtube text-lg"></i>
                        </a>
                        <a href="https://wa.me/6285157622980" target="_blank" class="text-gray-400 hover:text-white transition-colors duration-300" title="WhatsApp Desa Mekarmukti">
                            <i class="fab fa-whatsapp text-lg"></i>
                        </a>
                    </div>
                </div>
                
                <!-- Quick Links -->
                <div>
                    <h4 class="text-lg font-semibold mb-4 text-white">Link Cepat</h4>
                    <ul class="space-y-2">
                        <li>
                            <a href="{{ route('home') }}" class="footer-link text-gray-300 hover:text-primary-500 transition-colors duration-300 flex items-center">
                                <i class="bi bi-chevron-right text-xs mr-2"></i>
                                Beranda
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('sejarah') }}" class="footer-link text-gray-300 hover:text-primary-500 transition-colors duration-300 flex items-center">
                                <i class="bi bi-chevron-right text-xs mr-2"></i>
                                Sejarah Desa
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('visi') }}" class="footer-link text-gray-300 hover:text-primary-500 transition-colors duration-300 flex items-center">
                                <i class="bi bi-chevron-right text-xs mr-2"></i>
                                Visi & Misi
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('berita') }}" class="footer-link text-gray-300 hover:text-primary-500 transition-colors duration-300 flex items-center">
                                <i class="bi bi-chevron-right text-xs mr-2"></i>
                                Berita Desa
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('kontak') }}" class="footer-link text-gray-300 hover:text-primary-500 transition-colors duration-300 flex items-center">
                                <i class="bi bi-chevron-right text-xs mr-2"></i>
                                Kontak
                            </a>
                        </li>
                    </ul>
                </div>
                
                <!-- Contact Info -->
                <div>
                    <h4 class="text-lg font-semibold mb-4 text-white">Kontak Kami</h4>
                    <div class="space-y-3">
                        <div class="contact-item flex items-start space-x-3">
                            <i class="bi bi-geo-alt-fill text-primary-500 mt-1"></i>
                            <div>
                                <p class="text-gray-300 text-sm leading-relaxed">
                                    Desa Mekarmukti<br>
                                    Kec.Cihampelas, 40562<br>
                                    Bandung Barat, Jawa Barat
                                </p>
                            </div>
                        </div>
                        <div class="contact-item flex items-center space-x-3">
                            <i class="bi bi-telephone-fill text-primary-500"></i>
                            <p class="text-gray-300 text-sm">+62 851-5762-2980</p>
                        </div>
                        <div class="contact-item flex items-center space-x-3">
                            <i class="bi bi-envelope-fill text-primary-500"></i>
                            <p class="text-gray-300 text-sm">desamotekar00@gmail.com</p>
                        </div>
                        <div class="contact-item flex items-center space-x-3">
                            <i class="bi bi-truck text-primary-500"></i>
                            <div>
                                <p class="text-gray-300 text-sm"><strong>Ambulance:</strong> +62 831‑3836‑4566</p>
                            </div>
                        </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Footer Bottom -->
            <div class="text-center border-t border-gray-700 pt-6 mt-8">
                <div class="mb-4">
                    <p class="text-gray-300">&copy; {{ date('Y') }} Copyright <strong><span class="text-white">Desa Mekarmukti</span></strong>. All rights reserved.</p>
                </div>
                <div class="text-gray-400 text-sm">
                    Designed by 
                    <a href="https://www.instagram.com/kkn_mekarmuktiplb/" target="_blank"
                       class="text-primary-500 hover:text-primary-400 transition-colors duration-300 font-medium">
                        KKN Politeknik LP3I Bandung
                    </a> 
                    & 
                    <a href="https://www.instagram.com/kkn20mekarmukti2/" target="_blank"
                       class="text-primary-500 hover:text-primary-400 transition-colors duration-300 font-medium">
                        KKN Universitas Muhammadiyah Bandung
                    </a>
                </div>
            </div>
        </div>
    </footer>
    
    <!-- Modal Pengaduan -->
    <div class="modal fade" id="formPengaduan" tabindex="-1" aria-labelledby="formPengaduanLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-warning text-dark">
                    <h5 class="modal-title" id="formPengaduanLabel">Form Pengaduan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="pengaduanForm" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">No. Telepon / WhatsApp</label>
                            <input type="text" name="telepon" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Isi Pengaduan</label>
                            <textarea name="isi_pengaduan" class="form-control" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Lampiran (Opsional)</label>
                            <input type="file" name="lampiran" class="form-control">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" form="pengaduanForm" class="btn btn-warning">Kirim Pengaduan</button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Enhanced Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Enhanced Asset Scripts -->
    <script src="{{ asset('assets/vendor/aos/aos.js') }}"></script>
    <script src="{{ asset('assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
    
    <!-- Enhanced Mobile Navigation Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM fully loaded, initializing mobile navigation...');
            
            // Get all elements with detailed logging - CORRECTED IDs
            const mobileMenuButton = document.getElementById('mobileMenuButton');  // CORRECTED
            const mobileMenu = document.getElementById('mobileMenu');
            const closeMobileMenu = document.getElementById('closeMobileMenu');
            const mobileOverlay = document.getElementById('mobileOverlay');  // CORRECTED
            const mobileMenuIcon = mobileMenuButton ? mobileMenuButton.querySelector('i') : null;
            
            console.log('Mobile menu elements found:', {
                mobileMenuButton: !!mobileMenuButton,
                mobileMenu: !!mobileMenu,
                closeMobileMenu: !!closeMobileMenu,
                mobileOverlay: !!mobileOverlay,
                mobileMenuIcon: !!mobileMenuIcon
            });
            
            if (closeMobileMenu) {
                console.log('Close button element:', closeMobileMenu);
                console.log('Close button classes:', closeMobileMenu.className);
            }
            
            // Enhanced open mobile menu function
            function openMobileMenu() {
                console.log('Opening mobile menu...');
                if (!mobileMenu) {
                    console.error('Mobile menu element not found!');
                    return;
                }
                
                mobileMenu.classList.remove('translate-x-full');
                if (mobileMenuIcon) {
                    mobileMenuIcon.className = 'bi bi-x-lg';
                    console.log('Changed hamburger to X icon');
                }
                document.body.style.overflow = 'hidden';
                
                // Add animation class
                mobileMenu.classList.add('animate-slideIn');
                
                console.log('Mobile menu opened successfully');
            }
            
            // Enhanced close mobile menu function  
            function closeMobileMenuPanel() {
                console.log('Closing mobile menu...');
                if (!mobileMenu) {
                    console.error('Mobile menu element not found!');
                    return;
                }
                
                mobileMenu.classList.add('translate-x-full');
                if (mobileMenuIcon) {
                    mobileMenuIcon.className = 'bi bi-list';
                    console.log('Changed X back to hamburger icon');
                }
                document.body.style.overflow = '';
                
                // Remove animation class after transition
                setTimeout(() => {
                    if (mobileMenu) {
                        mobileMenu.classList.remove('animate-slideIn');
                    }
                }, 300);
                
                console.log('Mobile menu closed successfully');
            }
            
            // Enhanced event listeners with better error handling
            if (mobileMenuButton) {
                console.log('Setting up mobile menu button event listener...');
                mobileMenuButton.addEventListener('click', function(e) {
                    console.log('Mobile menu button clicked');
                    e.preventDefault();
                    e.stopPropagation();
                    openMobileMenu();
                });
            } else {
                console.error('Mobile menu button not found!');
            }
            
            if (closeMobileMenu) {
                console.log('Setting up close button event listener...');
                
                // Multiple event listeners to ensure it works
                closeMobileMenu.addEventListener('click', function(e) {
                    console.log('Close button clicked via click event');
                    e.preventDefault();
                    e.stopPropagation();
                    closeMobileMenuPanel();
                }, true); // Use capture phase
                
                closeMobileMenu.addEventListener('touchstart', function(e) {
                    console.log('Close button touched via touchstart event');
                    e.preventDefault();
                    e.stopPropagation();
                    closeMobileMenuPanel();
                }, true);
                
                // Test if button is clickable
                console.log('Close button styles:', window.getComputedStyle(closeMobileMenu));
            } else {
                console.error('Close mobile menu button not found!');
            }
            
            if (mobileOverlay) {
                console.log('Setting up overlay event listener...');
                mobileOverlay.addEventListener('click', function(e) {
                    console.log('Overlay clicked');
                    e.preventDefault();
                    e.stopPropagation();
                    closeMobileMenuPanel();
                });
            } else {
                console.error('Mobile overlay not found!');
            }
            
            // Enhanced mobile dropdown functionality
            const dropdownToggles = document.querySelectorAll('.mobile-dropdown-toggle');
            console.log('Found', dropdownToggles.length, 'dropdown toggles');
            
            dropdownToggles.forEach(toggle => {
                toggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    
                    const target = this.getAttribute('data-target');
                    const dropdown = document.getElementById(target);
                    const chevron = this.querySelector('i.bi-chevron-down');
                    
                    if (dropdown && chevron) {
                        dropdown.classList.toggle('hidden');
                        chevron.classList.toggle('rotate-180');
                        
                        // Add smooth animation
                        if (!dropdown.classList.contains('hidden')) {
                            dropdown.style.maxHeight = dropdown.scrollHeight + 'px';
                        } else {
                            dropdown.style.maxHeight = '0px';
                        }
                    }
                });
            });
            
            // Enhanced window resize handler
            window.addEventListener('resize', function() {
                if (window.innerWidth >= 1024) {
                    console.log('Window resized to desktop, closing mobile menu');
                    closeMobileMenuPanel();
                }
            });
            
            // Initialize enhanced libraries if available
            if (typeof AOS !== 'undefined') {
                AOS.init({
                    duration: 800,
                    easing: 'ease-in-out',
                    once: true,
                    mirror: false
                });
            }
            
            if (typeof GLightbox !== 'undefined') {
                GLightbox({
                    selector: '.glightbox'
                });
            }
            
            // Enhanced smooth scrolling
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });
            
            console.log('Enhanced mobile navigation initialized successfully');
            
            // Enhanced hover dropdown ready
            console.log('Professional hover dropdown navigation ready');
            
            // Debug function for testing
            window.debugMobileMenu = function() {
                console.log('Debug info:', {
                    mobileMenuButton: !!mobileMenuButton,
                    mobileMenu: !!mobileMenu,
                    closeMobileMenu: !!closeMobileMenu,
                    mobileOverlay: !!mobileOverlay,
                    menuVisible: mobileMenu ? !mobileMenu.classList.contains('translate-x-full') : 'N/A'
                });
            };
        });
        
        // Enhanced keyboard support
        document.addEventListener('keydown', function(e) {
            // Close mobile menu with Escape key
            if (e.key === 'Escape') {
                console.log('Escape key pressed');
                const mobileMenu = document.getElementById('mobileMenu');
                if (mobileMenu && !mobileMenu.classList.contains('translate-x-full')) {
                    const mobileMenuIcon = document.querySelector('#mobileMenuButton i');
                    
                    mobileMenu.classList.add('translate-x-full');
                    if (mobileMenuIcon) {
                        mobileMenuIcon.className = 'bi bi-list';
                    }
                    document.body.style.overflow = '';
                    console.log('Mobile menu closed with Escape key');
                }
            }
        });
    </script>
    
    <script>
        // Professional hover dropdown - CSS-only animations
        console.log('Hover dropdown loaded - CSS animations active');
    </script>
    
    @stack('scripts')
</body>
</html>
