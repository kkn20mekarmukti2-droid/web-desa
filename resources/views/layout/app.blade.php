<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <meta content="@yield('judul', 'Desa Mekarmukti, pemekaran Desa Cihampelas pada 1980, adalah desa termuda di Kecamatan Cihampelas, Kabupaten Bandung Barat. Temukan lebih lanjut di sini!')" name="description">
    <meta cont            <!-- Navigation Links -->
            <nav style="padding: 1rem 0;">
                <div>
                    <a href="javascript:void(0)" onclick="toggleMobileDropdown('profileDropdown')" style="
                        display: block;
                        color: white;
                        text-decoration: none;
                        padding: 1rem 1.5rem;
                        font-size: 16px;
                        font-weight: 500;
                        border-bottom: 1px solid #374151;
                        transition: all 0.25s ease;
                        position: relative;
                    " onmouseover="this.style.color='#F59E0B'; this.style.backgroundColor='rgba(245, 158, 11, 0.1)'" 
                       onmouseout="this.style.color='white'; this.style.backgroundColor='transparent'">
                        Profile Desa
                        <span style="
                            position: absolute;
                            right: 1.5rem;
                            top: 50%;
                            transform: translateY(-50%);
                            transition: transform 0.25s ease;
                            font-size: 12px;
                        " id="profileChevron">▼</span>
                    </a>
                    
                    <div id="profileDropdown" style="
                        max-height: 0;
                        overflow: hidden;
                        transition: max-height 0.25s ease-in-out;
                        background: #0f172a;
                    ">
                        <a href="{{ route('sejarah') }}" onclick="closeMobileMenu()" style="
                            display: block;
                            color: #d1d5db;
                            text-decoration: none;
                            padding: 0.75rem 2.5rem;
                            font-size: 14px;
                            border-bottom: 1px solid #374151;
                            transition: all 0.2s ease;
                        " onmouseover="this.style.color='#F59E0B'; this.style.backgroundColor='rgba(245, 158, 11, 0.05)'" 
                           onmouseout="this.style.color='#d1d5db'; this.style.backgroundColor='transparent'">
                            Sejarah
                        </a>
                        <a href="{{ route('visi') }}" onclick="closeMobileMenu()" style="
                            display: block;
                            color: #d1d5db;
                            text-decoration: none;
                            padding: 0.75rem 2.5rem;
                            font-size: 14px;
                            border-bottom: 1px solid #374151;
                            transition: all 0.2s ease;
                        " onmouseover="this.style.color='#F59E0B'; this.style.backgroundColor='rgba(245, 158, 11, 0.05)'" 
                           onmouseout="this.style.color='#d1d5db'; this.style.backgroundColor='transparent'">
                            Visi & Misi
                        </a>
                        <a href="{{ route('pemerintahan') }}" onclick="closeMobileMenu()" style="
                            display: block;
                            color: #d1d5db;
                            text-decoration: none;
                            padding: 0.75rem 2.5rem;
                            font-size: 14px;
                            border-bottom: 1px solid #374151;
                            transition: all 0.2s ease;
                        " onmouseover="this.style.color='#F59E0B'; this.style.backgroundColor='rgba(245, 158, 11, 0.05)'" 
                           onmouseout="this.style.color='#d1d5db'; this.style.backgroundColor='transparent'">
                            Struktur Organisasi
                        </a>
                    </div>
                </div>rmukti, cihampelas, berita desa,desa mekarmukti" name="keywords">
    <meta property="og:title" content="@yield('judul', 'Desa Mekarmukti')">
    <meta property="og:description" content="@yield('judul', 'Desa Mekarmukti, pemekaran Desa Cihampelas pada 1980, adalah desa termuda di Kecamatan Cihampelas, Kabupaten Bandung Barat. Temukan lebih lanjut di sini!')">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta name="author" content="@yield('penulis', 'Rasyid Shidiq')">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('judul', 'Web Desa Mekarmukti Kec. Cihampelas Bandung Barat')</title>

    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">

    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Roboto:300,300i,400,400i,500,500i,700,700i&display=swap"
        rel="stylesheet">

    {{-- Tailwind CSS CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>
    
    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <link href="{{ asset('assets/vendor/animate.css/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/aos/aos.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">
    <script src="https://kit.fontawesome.com/994f229ca1.js" crossorigin="anonymous"></script>
    <script src="{{ asset('assets/js/fancybox.umd.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('assets/css/fancybox.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css"
        integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>


    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        /* Minimal Modern Enhancements - Navbar Original Style */
        #navbar a {
            font-size: 15px;
            font-weight: 500;
            color: white;
            white-space: nowrap;
            transition: 0.3s;
            text-decoration: none;
            padding: 10px 15px;
            border-radius: 6px;
        }
        #navbar a i {
            font-size: 18px;
        }
        #navbar a:hover {
            color: #FFA500;
            background: rgba(255, 165, 0, 0.1);
            transform: none;
        }
        #navbar .dropdown ul a:hover {
            background: rgba(255, 165, 0, 0.1);
            color: #F59E0B;
        }
        /* Dropdown menu styling dengan Motekar theme */
        #navbar .dropdown ul {
            background: rgba(0, 0, 0, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(245, 158, 11, 0.3);
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.3);
        }
        #navbar .dropdown ul a {
            color: #FFFFFF !important;
            font-weight: 500;
            padding: 8px 15px;
            border-radius: 6px;
            margin: 2px 8px;
        }
        #navbar .dropdown ul a:hover {
            background: rgba(255, 165, 0, 0.1) !important;
            color: #F59E0B !important;
        }
        
        /* Button styling dengan warna logo Motekar */
        .btn-warning, .btn.btn-warning {
            background: linear-gradient(135deg, #F59E0B, #FFA500, #FF8C00) !important;
            border: 1px solid #F59E0B !important;
            color: white !important;
            font-weight: 600 !important;
            padding: 8px 16px !important;
            border-radius: 8px !important;
            transition: all 0.3s ease !important;
            box-shadow: 0 2px 8px rgba(245, 158, 11, 0.3) !important;
            min-height: 40px !important;
        }
        .btn-warning:hover, .btn.btn-warning:hover {
            background: linear-gradient(135deg, #D97706, #FF8C00, #E67E22) !important;
            transform: translateY(-2px) !important;
            box-shadow: 0 4px 12px rgba(245, 158, 11, 0.4) !important;
            color: white !important;
            border-color: #D97706 !important;
        }
        
        /* Mobile-specific styling for slide-in drawer */
        @media (max-width: 991px) {
            .btn-warning, .btn.btn-warning {
                padding: 10px 20px !important;
                font-size: 14px !important;
                min-height: 44px !important;
            }
            
            /* Mobile Navigation Toggle */
            .mobile-nav-toggle {
                display: block !important;
                color: #fff !important;
                font-size: 28px !important;
                cursor: pointer !important;
                padding: 8px !important;
                margin: 0 !important;
                border: none !important;
                background: transparent !important;
                line-height: 1 !important;
                transition: all 0.3s ease !important;
                z-index: 100000 !important;
                position: relative !important;
            }
            
            .mobile-nav-toggle:hover {
                color: #F59E0B !important;
                transform: scale(1.1) !important;
            }
            
            /* Hide desktop navbar on mobile */
            #navbar > ul {
                display: none !important;
            }
        }
        
        /* Desktop: hide mobile nav toggle and show navbar */
        @media (min-width: 992px) {
            .mobile-nav-toggle {
                display: none !important;
            }
            
            #navbar ul {
                display: flex !important;
            }
        }
        .btn-secondary, .btn.btn-secondary {
            background: linear-gradient(135deg, #6B7280, #4B5563, #374151) !important;
            border: none !important;
            color: white !important;
            font-weight: 600 !important;
            padding: 8px 16px !important;
            border-radius: 8px !important;
            transition: all 0.3s ease !important;
            box-shadow: 0 2px 4px rgba(107, 114, 128, 0.3) !important;
        }
        .btn-secondary:hover, .btn.btn-secondary:hover {
            background: linear-gradient(135deg, #4B5563, #374151, #1F2937) !important;
            transform: translateY(-2px) !important;
            box-shadow: 0 4px 12px rgba(107, 114, 128, 0.4) !important;
            color: white !important;
        }
        /* Logo styling sesuai Motekar theme */
        .logo h1 {
            font-family: 'Roboto', sans-serif;
            letter-spacing: 1px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
        }
        .logo h1 a {
            color: #FFFFFF !important;
            text-decoration: none;
        }
        .logo h1 a:hover {
            color: #FFA500 !important;
        }
        /* Footer styling untuk konsistensi */
        #footer {
            color: white;
            position: relative;
        }
        #footer::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle at 20% 20%, rgba(79, 70, 229, 0.1) 0%, transparent 50%),
                        radial-gradient(circle at 80% 80%, rgba(245, 158, 11, 0.1) 0%, transparent 50%),
                        radial-gradient(circle at 40% 60%, rgba(59, 130, 246, 0.05) 0%, transparent 50%);
            pointer-events: none;
        }
        #footer > * {
            position: relative;
            z-index: 1;
        }
        #footer h3, #footer h4 {
            color: #FFFFFF;
        }
        #footer p {
            color: #D1D5DB;
        }
        #footer .social-links a {
            background: rgba(255, 165, 0, 0.1);
            border: 1px solid rgba(255, 165, 0, 0.3);
            color: #FFFFFF;
            transition: all 0.3s ease;
        }
        #footer .social-links a:hover {
            background: #F59E0B;
            color: #000000;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
        }
        /* Modal dengan aksen Motekar */
        .modal-content {
            border-radius: 12px !important;
            overflow: hidden !important;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.2) !important;
            border: 1px solid rgba(245, 158, 11, 0.2) !important;
        }
        .modal-header {
            background: linear-gradient(135deg, #F59E0B, #FFA500) !important;
            color: white !important;
            border: none !important;
        }
        .modal-header .btn-close {
            filter: brightness(0) invert(1) !important;
        }
        .btn {
            border-radius: 8px !important;
            transition: all 0.3s ease !important;
            font-weight: 600 !important;
        }
        .btn:hover {
            transform: translateY(-1px) !important;
        }
    </style>



</head>

<body>

    <!-- ======= Header ======= -->
    <header id="header" class="fixed-top d-flex align-items-center" style="background: linear-gradient(135deg, #000000, #1f2937, #374151); border-bottom: 2px solid #F59E0B; backdrop-filter: blur(10px);">
        <div class="container d-flex justify-content-between align-items-center">

            <img src="{{ asset('assets/img/motekar-bg.png') }}" alt="" width="45px" class="m-lg-auto" style="border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
            <div class="container d-flex justify-content-between align-items-center">

                <div class="logo">
                    <h1 class="text-light" style="font-size: 2.2rem; margin-bottom: 0; line-height: 1; font-weight: 700;"> 
                        <a href="{{ route('home') }}"><span>MEKARMUKTI</span></a>
                    </h1>
                </div>

                <nav id="navbar" class="navbar">
      <ul>
        <li><a href="{{ route('home') }}"><i class="bx bx-home"></i></a></li>

        <!-- Profile Desa -->
        <li class="dropdown">
          <a href="#"><span>Profile Desa</span> <i class="bi bi-chevron-down"></i></a>
          <ul>
            <li><a href="{{ route('sejarah') }}">Sejarah</a></li>
            <li><a href="{{ route('visi') }}">Visi & Misi</a></li>
            <li><a href="{{ route('pemerintahan') }}">Struktur Organisasi</a></li>
          </ul>
        </li>

        <!-- Informasi Desa -->
        <li class="dropdown">
          <a href="#"><span>Informasi Desa</span> <i class="bi bi-chevron-down"></i></a>
          <ul>
            <li><a href="{{ route('berita') }}">Berita</a></li>
            <li><a href="{{ route('galeri') }}">Galeri</a></li>
            <li><a href="{{ route('potensidesa') }}">Potensi Desa</a></li>
          </ul>
        </li>

        <li><a href="{{ route('data.penduduk') }}">Data Statistik</a></li>

        <li><a href="{{ route('kontak') }}">Kontak</a></li>

        <li>
            <!-- Tombol untuk membuka modal -->
            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#formPengaduan">
                Buat Pengaduan
            </button>
        </li>
      </ul>
      <i class="bi bi-list mobile-nav-toggle" onclick="openMobileMenu()"></i>
    </nav><!-- .navbar -->

        <!-- Mobile Navigation - Slide-in Drawer System -->
        <!-- Overlay -->
        <div id="mobileOverlay" style="
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            background: rgba(0, 0, 0, 0.5);
            z-index: 99998;
            opacity: 0;
            transition: opacity 0.3s ease-in-out;
        " onclick="closeMobileMenu()"></div>

        <!-- Slide-in Panel -->
        <div id="mobileMenuPanel" style="
            position: fixed;
            top: 0;
            right: 0;
            width: 70%;
            max-width: 320px;
            height: 100vh;
            background: #111827;
            z-index: 99999;
            transform: translateX(100%);
            transition: transform 0.3s ease-in-out;
            overflow-y: auto;
            box-shadow: -4px 0 20px rgba(0, 0, 0, 0.3);
        ">
            <!-- Header with Close Button -->
            <div style="
                padding: 1rem 1.5rem;
                border-bottom: 1px solid #374151;
                display: flex;
                justify-content: flex-end;
                align-items: center;
                min-height: 60px;
            ">
                <button onclick="closeMobileMenu()" id="closeMobileBtn" style="
                    background: none;
                    border: none;
                    color: #F59E0B;
                    font-size: 20px;
                    cursor: pointer;
                    padding: 8px;
                    border-radius: 4px;
                    transition: background-color 0.2s ease;
                    line-height: 1;
                " onmouseover="this.style.backgroundColor='rgba(245, 158, 11, 0.1)'" 
                   onmouseout="this.style.backgroundColor='transparent'">
                    ✕
                </button>
            </div>

            <!-- Navigation Links -->
            <nav style="padding: 1rem 0;">
                <a href="{{ route('home') }}" onclick="closeMobileMenu()" style="
                    display: block;
                    color: white;
                    text-decoration: none;
                    padding: 1rem 1.5rem;
                    font-size: 16px;
                    font-weight: 500;
                    border-bottom: 1px solid #374151;
                    transition: all 0.25s ease;
                " onmouseover="this.style.color='#F59E0B'; this.style.backgroundColor='rgba(245, 158, 11, 0.1)'" 
                   onmouseout="this.style.color='white'; this.style.backgroundColor='transparent'">
                    Profile Desa
                </a>

                <div>
                    <a href="javascript:void(0)" onclick="toggleMobileDropdown('informasiDropdown')" style="
                        display: block;
                        color: white;
                        text-decoration: none;
                        padding: 1rem 1.5rem;
                        font-size: 16px;
                        font-weight: 500;
                        border-bottom: 1px solid #374151;
                        transition: all 0.25s ease;
                        position: relative;
                    " onmouseover="this.style.color='#F59E0B'; this.style.backgroundColor='rgba(245, 158, 11, 0.1)'" 
                       onmouseout="this.style.color='white'; this.style.backgroundColor='transparent'">
                        Informasi Desa
                        <span style="
                            position: absolute;
                            right: 1.5rem;
                            top: 50%;
                            transform: translateY(-50%);
                            transition: transform 0.25s ease;
                            font-size: 12px;
                        " id="informasiChevron">▼</span>
                    </a>
                    
                    <div id="informasiDropdown" style="
                        max-height: 0;
                        overflow: hidden;
                        transition: max-height 0.25s ease-in-out;
                        background: #0f172a;
                    ">
                        <a href="{{ route('berita') }}" onclick="closeMobileMenu()" style="
                            display: block;
                            color: #d1d5db;
                            text-decoration: none;
                            padding: 0.75rem 2.5rem;
                            font-size: 14px;
                            border-bottom: 1px solid #374151;
                            transition: all 0.2s ease;
                        " onmouseover="this.style.color='#F59E0B'; this.style.backgroundColor='rgba(245, 158, 11, 0.05)'" 
                           onmouseout="this.style.color='#d1d5db'; this.style.backgroundColor='transparent'">
                            Berita
                        </a>
                        <a href="{{ route('galeri') }}" onclick="closeMobileMenu()" style="
                            display: block;
                            color: #d1d5db;
                            text-decoration: none;
                            padding: 0.75rem 2.5rem;
                            font-size: 14px;
                            border-bottom: 1px solid #374151;
                            transition: all 0.2s ease;
                        " onmouseover="this.style.color='#F59E0B'; this.style.backgroundColor='rgba(245, 158, 11, 0.05)'" 
                           onmouseout="this.style.color='#d1d5db'; this.style.backgroundColor='transparent'">
                            Galeri
                        </a>
                        <a href="{{ route('potensidesa') }}" onclick="closeMobileMenu()" style="
                            display: block;
                            color: #d1d5db;
                            text-decoration: none;
                            padding: 0.75rem 2.5rem;
                            font-size: 14px;
                            border-bottom: 1px solid #374151;
                            transition: all 0.2s ease;
                        " onmouseover="this.style.color='#F59E0B'; this.style.backgroundColor='rgba(245, 158, 11, 0.05)'" 
                           onmouseout="this.style.color='#d1d5db'; this.style.backgroundColor='transparent'">
                            Potensi Desa
                        </a>
                    </div>
                </div>

                <a href="{{ route('data.penduduk') }}" onclick="closeMobileMenu()" style="
                    display: block;
                    color: white;
                    text-decoration: none;
                    padding: 1rem 1.5rem;
                    font-size: 16px;
                    font-weight: 500;
                    border-bottom: 1px solid #374151;
                    transition: all 0.25s ease;
                " onmouseover="this.style.color='#F59E0B'; this.style.backgroundColor='rgba(245, 158, 11, 0.1)'" 
                   onmouseout="this.style.color='white'; this.style.backgroundColor='transparent'">
                    Data Statistik
                </a>

                <a href="{{ route('kontak') }}" onclick="closeMobileMenu()" style="
                    display: block;
                    color: white;
                    text-decoration: none;
                    padding: 1rem 1.5rem;
                    font-size: 16px;
                    font-weight: 500;
                    border-bottom: 1px solid #374151;
                    transition: all 0.25s ease;
                " onmouseover="this.style.color='#F59E0B'; this.style.backgroundColor='rgba(245, 158, 11, 0.1)'" 
                   onmouseout="this.style.color='white'; this.style.backgroundColor='transparent'">
                    Kontak
                </a>

                <button type="button" onclick="openPengaduanModal()" style="
                    display: block;
                    width: calc(100% - 3rem);
                    color: white;
                    text-decoration: none;
                    padding: 1rem 1.5rem;
                    margin: 1rem 1.5rem 0 1.5rem;
                    font-size: 16px;
                    font-weight: 500;
                    background: #F59E0B;
                    border: none;
                    border-radius: 6px;
                    text-align: center;
                    cursor: pointer;
                    transition: all 0.2s ease;
                " onmouseover="this.style.backgroundColor='#D97706'; this.style.transform='translateY(-1px)'" 
                   onmouseout="this.style.backgroundColor='#F59E0B'; this.style.transform='translateY(0)'">
                    Buat Pengaduan
                </button>
            </nav>
        </div>

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


        </li>
      </ul>
    </div>
  </div>
</nav>


            </div>
    </header>


    @yield('content')


    <footer id="footer" data-aos="fade-up" data-aos-easing="ease-in-out" data-aos-duration="500" 
            style="background: #000000; position: relative; overflow: hidden;">
        
        <!-- Logo Watermark Background -->
        <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); opacity: 0.05; z-index: 0; pointer-events: none;">
            <img src="{{ asset('assets/img/motekar-bg.png') }}" alt="Watermark" style="width: 300px; height: 300px;">
        </div>

        <div class="footer-top" style="background: transparent; position: relative; z-index: 1;">
            <div class="container">
                <div class="row">

                    <div class="col-lg-3 col-md-6 footer-links flex justify-center">
                        <img src="{{ asset('assets/img/kbb-logo.png') }}" class="" alt="">
                    </div>

                    <div class="col-lg-3 col-md-6 footer-contact">
                        <h4>Kontak Kami</h4>
                        <p>
                            Desa Mekarmukti <br>
                            Kec.Cihampelas, 40562 <br>
                            Bandung Barat, Jawa Barat <br><br>
                            <strong>Telepon:</strong>+62 851-5762-2980<br>
                            <strong>Email:</strong> desamotekar00@gmail.com<br>
                            <strong>Ambulance:</strong> +62 831‑3836‑4566<br>
                        </p>
                    </div>

                    <div class="col-lg-3 col-md-6 footer-info">
                        <h3>Tentang Desa</h3>
                        <p>Desa Mekarmukti Kecamatan Cihampelas Kabupaten Bandung Barat adalah Desa yang merupakan Pamekaran dari Desa Cihampelas yang pada waktu itu Kecamatan Cililin, Kawedanaan Cililin,  Kabupaten Bandung. </p>
                    </div>

                    <div class="col-lg-3 col-md-6 footer-contact">
                        <h4>Sosial Media Kami</h4>
                        <div class="social-links mt-3">
                            <a href="https://www.youtube.com/@desamekarmukti3378" class="youtube"><i
                                    class="bx bxl-youtube"></i></a>
                            <a href="" class="facebook"><i class="bx bxl-facebook"></i></a>
                            <a href="https://www.instagram.com/mekarmukti_id/" class="instagram"><i
                                    class="bx bxl-instagram"></i></a>
                            <a href="" class="whatsapp"><i class="bx bxl-whatsapp"></i></a>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="container" style="border-top: 1px solid rgba(255,255,255,0.2); padding-top: 20px;">
            <div class="copyright" style="color: white; text-align: center;">
                &copy; Copyright <strong><span>Desa Mekarmukti</span></strong>. All rights reserved.
            </div>
            <div class="credits" style="color: rgba(255,255,255,0.8); text-align: center; margin-top: 10px;">
                Designed by 
                <a href="https://www.instagram.com/kkn_mekarmuktiplb/" style="color: #F59E0B; transition: all 0.3s;" onmouseover="this.style.color='#FFA500'" onmouseout="this.style.color='#F59E0B'">KKN Politeknik LP3I Bandung</a> 
                & 
                <a href="https://www.instagram.com/kkn20mekarmukti2/" style="color: #F59E0B; transition: all 0.3s;" onmouseover="this.style.color='#FFA500'" onmouseout="this.style.color='#F59E0B'">KKN Universitas Muhammadiyah Bandung</a>
            </div>
        </div>
    </footer><!-- End Footer -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="{{ asset('assets/vendor/purecounter/purecounter_vanilla.js') }} "></script>
    <script src="{{ asset('assets/vendor/aos/aos.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/waypoints/noframework.waypoints.js') }}"></script>
    <script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"
        integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        toastr.options = {
            'progressBar': true,
            'closeButton': true,
            'timeOut': 10000
        }
         @if (Session::has('pesan'))
            toastr.success("{{ Session::get('pesan') }}");
        @elseif (Session::has('error'))
            toastr.error("{{ Session::get('error') }}");
        @endif
    </script>
    @yield('script')
    <script>
        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.register('/firebase-messaging-sw.js')
                .then(function(registration) {
                    // console.log('Service Worker registered with scope:', registration.scope);
                }).catch(function(err) {
                    console.log('Service Worker registration failed:', err);
                });
        }
    </script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <script src="{{ asset('assets/js/notifs.js') }}" type="module"></script>

    <!-- Mobile Navigation JavaScript - Slide-in Drawer -->
    <script>
        // Open mobile menu with slide-in animation
        function openMobileMenu() {
            const overlay = document.getElementById('mobileOverlay');
            const panel = document.getElementById('mobileMenuPanel');
            const toggle = document.querySelector('.mobile-nav-toggle');
            
            // Show overlay first
            overlay.style.display = 'block';
            
            // Force reflow and animate
            requestAnimationFrame(() => {
                overlay.style.opacity = '1';
                panel.style.transform = 'translateX(0)';
            });
            
            // Change hamburger to X
            toggle.classList.remove('bi-list');
            toggle.classList.add('bi-x');
            
            // Prevent body scroll
            document.body.style.overflow = 'hidden';
            
            console.log('Mobile menu opened with slide-in animation');
        }
        
        // Close mobile menu with slide-out animation
        function closeMobileMenu() {
            const overlay = document.getElementById('mobileOverlay');
            const panel = document.getElementById('mobileMenuPanel');
            const toggle = document.querySelector('.mobile-nav-toggle');
            
            // Hide panel first
            panel.style.transform = 'translateX(100%)';
            overlay.style.opacity = '0';
            
            // Hide overlay after animation
            setTimeout(() => {
                overlay.style.display = 'none';
            }, 300);
            
            // Change X back to hamburger
            toggle.classList.remove('bi-x');
            toggle.classList.add('bi-list');
            
            // Restore body scroll
            document.body.style.overflow = '';
            
            console.log('Mobile menu closed with slide-out animation');
        }
        
        // Toggle dropdown in mobile menu
        function toggleMobileDropdown(dropdownId) {
            const dropdown = document.getElementById(dropdownId);
            let chevron;
            
            if (dropdownId === 'profileDropdown') {
                chevron = document.getElementById('profileChevron');
            } else if (dropdownId === 'informasiDropdown') {
                chevron = document.getElementById('informasiChevron');
            }
            
            // Close all other dropdowns first
            const allDropdowns = ['profileDropdown', 'informasiDropdown'];
            const allChevrons = ['profileChevron', 'informasiChevron'];
            
            allDropdowns.forEach((id, index) => {
                if (id !== dropdownId) {
                    const otherDropdown = document.getElementById(id);
                    const otherChevron = document.getElementById(allChevrons[index]);
                    if (otherDropdown && otherChevron) {
                        otherDropdown.style.maxHeight = '0';
                        otherChevron.style.transform = 'translateY(-50%) rotate(0deg)';
                    }
                }
            });
            
            // Toggle current dropdown
            if (dropdown.style.maxHeight === '250px') {
                // Close dropdown
                dropdown.style.maxHeight = '0';
                chevron.style.transform = 'translateY(-50%) rotate(0deg)';
            } else {
                // Open dropdown
                dropdown.style.maxHeight = '250px';
                chevron.style.transform = 'translateY(-50%) rotate(180deg)';
            }
        }
        
        // Open pengaduan modal and close menu
        function openPengaduanModal() {
            closeMobileMenu();
            // Wait for menu to close, then open modal
            setTimeout(() => {
                const modal = new bootstrap.Modal(document.getElementById('formPengaduan'));
                modal.show();
            }, 350);
        }
        
        // Initialize mobile navigation
        document.addEventListener('DOMContentLoaded', function() {
            // Close mobile menu on window resize (desktop)
            window.addEventListener('resize', function() {
                if (window.innerWidth > 991) {
                    const overlay = document.getElementById('mobileOverlay');
                    if (overlay.style.display === 'block') {
                        closeMobileMenu();
                    }
                }
            });
            
            // Prevent page scroll when overlay is active
            document.getElementById('mobileOverlay').addEventListener('touchmove', function(e) {
                e.preventDefault();
            }, { passive: false });
            
            console.log('Slide-in drawer navigation initialized successfully!');
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Ensure mobile nav toggle works
            const mobileNavToggle = document.querySelector('.mobile-nav-toggle');
            const navbar = document.querySelector('#navbar');
            
            if (mobileNavToggle && navbar) {
                mobileNavToggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    // Toggle navbar-mobile class
                    navbar.classList.toggle('navbar-mobile');
                    
                    // Toggle icon between list and x
                    this.classList.toggle('bi-list');
                    this.classList.toggle('bi-x');
                    
                    console.log('Mobile nav toggle clicked', navbar.classList.contains('navbar-mobile'));
                });
                
                // Close mobile menu when clicking on nav links
                const navLinks = document.querySelectorAll('#navbar ul li a');
                navLinks.forEach(link => {
                    link.addEventListener('click', function() {
                        if (navbar.classList.contains('navbar-mobile')) {
                            navbar.classList.remove('navbar-mobile');
                            mobileNavToggle.classList.remove('bi-x');
                            mobileNavToggle.classList.add('bi-list');
                        }
                    });
                });
                
                // Handle dropdown in mobile
                const dropdownLinks = document.querySelectorAll('#navbar .dropdown > a');
                dropdownLinks.forEach(link => {
                    link.addEventListener('click', function(e) {
                        if (navbar.classList.contains('navbar-mobile')) {
                            e.preventDefault();
                            const dropdown = this.nextElementSibling;
                            if (dropdown) {
                                dropdown.classList.toggle('dropdown-active');
                            }
                        }
                    });
                });
            } else {
                console.error('Mobile nav elements not found:', {
                    toggle: !!mobileNavToggle,
                    navbar: !!navbar
                });
            }
        });
    </script>

</body>

</html>
