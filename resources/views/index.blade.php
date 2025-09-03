@extends('layout.app')

@section('title', 'Beranda - Desa Mekarmukti')
@section('body-class', 'home-hero-override')

@section('content')

{{-- Custom CSS for Brand-Consistent 3-Card Layout --}}
<style>
/* ZERO GAP: Hero to Cards - Override default main margin */
#main {
    margin: 0 !important;
    margin-top: 0 !important;
    padding: 0 !important;
}

/* Enhanced Services Section - Perfect seamless connection */
.services {
    position: relative;
    z-index: 10;
    margin-top: 0 !important;
    padding-top: 0 !important;
}

/* Ensure container padding provides the spacing we want */
.services .container {
    padding-top: 50px !important;
    padding-bottom: 60px !important;
}

.services .icon-box {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    padding: 35px 30px;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    text-align: center;
    height: 100%;
    border: 2px solid transparent;
    position: relative;
    overflow: hidden;
}

/* Hover Effects with Orange Brand Color */
.services .icon-box:hover {
    transform: translateY(-8px) scale(1.02);
    box-shadow: 0 12px 35px rgba(0, 0, 0, 0.15);
    border-color: #F59E0B;
}

.services .icon-box:focus-within {
    outline: 3px solid rgba(245, 158, 11, 0.3);
    outline-offset: 2px;
}

/* Icon Badge Styles */
.services .icon-badge {
    width: 70px;
    height: 70px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 25px;
    position: relative;
    transition: all 0.3s ease;
}

.services .icon-badge i {
    font-size: 32px;
    color: white;
    transition: transform 0.3s ease;
}

.services .icon-box:hover .icon-badge i {
    transform: scale(1.1);
}

/* Brand Color Variations */
/* Orange Accent - Primary Brand */
.services .icon-box-orange .bg-orange {
    background: linear-gradient(135deg, #F59E0B, #D97706);
}

.services .icon-box-orange:hover .bg-orange {
    background: linear-gradient(135deg, #D97706, #B45309);
}

/* Dark Accent with Orange Hover */
.services .icon-box-dark .bg-dark {
    background: linear-gradient(135deg, #374151, #111827);
}

.services .icon-box-dark:hover .bg-dark {
    background: linear-gradient(135deg, #F59E0B, #D97706);
}

/* Blue Accent with Orange Hover */
.services .icon-box-blue .bg-blue {
    background: linear-gradient(135deg, #3B82F6, #2563EB);
}

.services .icon-box-blue:hover .bg-blue {
    background: linear-gradient(135deg, #F59E0B, #D97706);
}

/* Typography */
.services .icon-box .title {
    margin-bottom: 20px;
    font-size: 20px;
    font-weight: 700;
    line-height: 1.3;
}

.services .icon-box .title a {
    color: #1F2937;
    text-decoration: none;
    transition: color 0.3s ease;
}

.services .icon-box:hover .title a {
    color: #F59E0B;
}

.services .icon-box .description {
    font-size: 15px;
    line-height: 1.6;
    color: #6B7280;
    margin: 0;
}

/* Responsive Grid Adjustments */
@media (max-width: 767.98px) {
    .services .icon-box {
        margin-bottom: 20px;
        padding: 25px 20px;
    }
    
    .services .icon-badge {
        width: 60px;
        height: 60px;
        margin-bottom: 20px;
    }
    
    .services .icon-badge i {
        font-size: 28px;
    }
    
    .services .icon-box .title {
        font-size: 18px;
        margin-bottom: 15px;
    }
    
    .services .icon-box .description {
        font-size: 14px;
        line-height: 1.5;
    }
    
    /* Better mobile container spacing */
    .services .container {
        padding-top: 40px !important;
        padding-bottom: 40px !important;
    }
}

@media (min-width: 768px) and (max-width: 991.98px) {
    /* Tablet: 2+1 layout with centered third card */
    .services .row > .col-md-12 {
        display: flex;
        justify-content: center;
    }
}

@media (min-width: 992px) {
    /* Desktop: Perfect 3-column layout */
    .services .icon-box {
        min-height: 320px;
    }
}

/* Subtle Background Pattern */
.services::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 100%;
    background: linear-gradient(135deg, rgba(245, 158, 11, 0.02) 0%, rgba(245, 158, 11, 0.01) 100%);
    pointer-events: none;
}
</style>

{{-- Include Hero Welcome Component --}}
@include('components.hero-welcome')

  <main id="main">

        <!-- ======= Services Section - No Gap dari Hero ======= -->
        <section class="services" style="background-color: #EAF2F7;">
            <div class="container">

                <div class="row justify-content-center">
                    <!-- Card 1: Sejarah Terbentuk Desa - Orange Accent -->
                    <div class="col-12 col-md-6 col-lg-4 d-flex align-items-stretch mb-4" data-aos="fade-up">
                        <div class="icon-box icon-box-orange w-100">
                            <div class="icon-badge bg-orange">
                                <i class="bx bxl-dribbble"></i>
                            </div>
                            <h4 class="title"><a href="#" class="text-dark fw-bold">Sejarah Terbentuk Desa</a></h4>
                            <p class="description text-muted">Desa Mekarmukti adalah sebuah Desa yang merupakan Pamekaran dari Desa Cihampelas yang pada waktu itu Kecamatan Cililin, Kawedanaan Cililin, Kabupaten Bandung.</p>
                        </div>
                    </div>

                    <!-- Card 2: Sejarah Pembangunan Desa - Dark Accent with Orange Hover -->
                    <div class="col-12 col-md-6 col-lg-4 d-flex align-items-stretch mb-4" data-aos="fade-up" data-aos-delay="100">
                        <div class="icon-box icon-box-dark w-100">
                            <div class="icon-badge bg-dark">
                                <i class="bx bx-file"></i>
                            </div>
                            <h4 class="title"><a href="#" class="text-dark fw-bold">Sejarah Pembangunan Desa</a></h4>
                            <p class="description text-muted">Desa Mekarmukti Kecamatan Cihampelas adalah salah satu Desa termaju dalam Pembangunan disegala Bidang, baik Pembangunan sarana dan prasarana, Pembangunan Ekonomi, UMKM dan Pendidikan.</p>
                        </div>
                    </div>

                    <!-- Card 3: Topografi Desa - Blue Accent with Orange Hover -->
                    <div class="col-12 col-md-12 col-lg-4 d-flex align-items-stretch mb-4" data-aos="fade-up" data-aos-delay="200">
                        <div class="icon-box icon-box-blue w-100">
                            <div class="icon-badge bg-blue">
                                <i class="bx bx-tachometer"></i>
                            </div>
                            <h4 class="title"><a href="#" class="text-dark fw-bold">Topografi Desa</a></h4>
                            <p class="description text-muted">Desa Mekarmukti merupakan desa yang berada di daerah perbukitan dengan ketinggian antara 274 Meter (diatas permukaan laut).</p>
                        </div>
                    </div>
                </div>

            </div>
        </section>
        
        {{-- ======= Berita Terbaru Section ======= --}}
        <section class="berita-section" style="background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%); position: relative; overflow: hidden;">
            <!-- Background Pattern -->
            <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; opacity: 0.05; background-image: radial-gradient(circle at 1px 1px, #F59E0B 1px, transparent 0); background-size: 20px 20px;"></div>
            
            <div class="container py-5" style="position: relative; z-index: 2;">
                <!-- Enhanced Section Header -->
                <div class="text-center mb-5" data-aos="fade-up">
                    <div class="d-inline-block mb-3">
                        <span class="badge bg-primary px-4 py-2 rounded-pill text-uppercase fw-medium ls-1" style="font-size: 0.75rem; letter-spacing: 1px;">
                            <i class="fas fa-newspaper me-2"></i>
                            Informasi Terkini
                        </span>
                    </div>
                    <h2 class="display-5 fw-bold text-gray-900 mb-4">
                        📰 Berita Terbaru
                    </h2>
                    <p class="lead text-gray-600 max-w-2xl mx-auto">
                        Dapatkan informasi terkini seputar kegiatan, program, dan perkembangan terbaru dari Desa Mekarmukti
                    </p>
                    <div class="divider mx-auto mt-4" style="width: 60px; height: 4px; background: linear-gradient(90deg, #F59E0B, #D97706); border-radius: 2px;"></div>
                </div>
                
                <!-- Modern News Cards Grid -->
                <div class="row g-4" data-aos="fade-up" data-aos-delay="100">
                    @if($artikel && $artikel->count() > 0)
                        @foreach($artikel->take(3) as $index => $berita)
                            <div class="col-lg-4 col-md-6">
                                <article class="news-card h-100" style="background: white; border-radius: 20px; overflow: hidden; box-shadow: 0 8px 25px rgba(0,0,0,0.1); transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94); border: 0;">
                                    <!-- Image Container with Overlay -->
                                    <div class="position-relative overflow-hidden" style="height: 220px;">
                                        @if($berita->sampul && file_exists(public_path('img/' . $berita->sampul)))
                                            <img src="{{ asset('img/' . $berita->sampul) }}" 
                                                 class="w-100 h-100" 
                                                 alt="{{ $berita->judul }}" 
                                                 style="object-fit: cover; transition: transform 0.4s ease;"
                                                 loading="lazy">
                                        @else
                                            <div class="w-100 h-100 d-flex align-items-center justify-content-center" 
                                                 style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                                <div class="text-center text-white">
                                                    <i class="fas fa-newspaper" style="font-size: 3rem; opacity: 0.9;"></i>
                                                    <div class="mt-2 fw-medium">Artikel Berita</div>
                                                </div>
                                            </div>
                                        @endif
                                        
                                        <!-- Category Badge -->
                                        <div class="position-absolute" style="top: 15px; left: 15px;">
                                            <span class="badge bg-primary px-3 py-2 rounded-pill fw-medium" style="backdrop-filter: blur(10px); background: rgba(59, 130, 246, 0.9) !important;">
                                                <i class="fas fa-tag me-1"></i>
                                                Berita
                                            </span>
                                        </div>
                                        
                                        <!-- Date Badge -->
                                        <div class="position-absolute" style="top: 15px; right: 15px;">
                                            <span class="badge bg-dark px-3 py-2 rounded-pill fw-medium" style="backdrop-filter: blur(10px); background: rgba(0, 0, 0, 0.7) !important;">
                                                <i class="fas fa-calendar-alt me-1"></i>
                                                {{ $berita->created_at->format('d M') }}
                                            </span>
                                        </div>
                                        
                                        <!-- Gradient Overlay -->
                                        <div class="position-absolute bottom-0 start-0 end-0" style="height: 60%; background: linear-gradient(transparent, rgba(0,0,0,0.7)); opacity: 0; transition: opacity 0.3s ease;"></div>
                                    </div>
                                    
                                    <!-- Card Content -->
                                    <div class="p-4">
                                        <!-- Meta Information -->
                                        <div class="d-flex align-items-center mb-3 text-muted" style="font-size: 0.875rem;">
                                            <i class="fas fa-clock me-2 text-primary"></i>
                                            <span>{{ $berita->created_at->format('d M Y') }}</span>
                                            <span class="mx-2">•</span>
                                            <i class="fas fa-user me-2 text-success"></i>
                                            <span>Admin Desa</span>
                                        </div>
                                        
                                        <!-- Title -->
                                        <h5 class="card-title fw-bold mb-3" style="color: #1f2937; line-height: 1.4; font-size: 1.125rem;">
                                            {{ Str::limit($berita->judul, 60) }}
                                        </h5>
                                        
                                        <!-- Description -->
                                        <p class="card-text text-gray-600 mb-4" style="line-height: 1.6; font-size: 0.95rem;">
                                            {{ Str::limit(strip_tags($berita->deskripsi), 90) }}
                                        </p>
                                        
                                        <!-- Action Button -->
                                        <div class="d-flex justify-content-between align-items-center">
                                            <a href="{{ route('detailartikel', ['tanggal' => $berita->created_at->format('Y-m-d'), 'judul' => Str::slug($berita->judul)]) }}" 
                                               class="btn btn-primary btn-sm px-4 py-2 rounded-pill fw-medium" style="transition: all 0.3s ease; text-decoration: none;">
                                                <i class="fas fa-arrow-right me-2"></i>
                                                Baca Artikel
                                            </a>
                                            
                                            <!-- Reading Time -->
                                            <small class="text-muted d-flex align-items-center">
                                                <i class="fas fa-book-open me-1"></i>
                                                {{ ceil(str_word_count(strip_tags($berita->deskripsi)) / 200) }} min
                                            </small>
                                        </div>
                                    </div>
                                    
                                    <!-- Hover Effect Border -->
                                    <div class="position-absolute top-0 start-0 end-0 bottom-0 rounded-4 pointer-events-none" style="border: 2px solid transparent; transition: border-color 0.3s ease;"></div>
                                </article>
                            </div>
                        @endforeach
                        
                        <!-- Featured Article Banner (Conditional - if more than 3 articles) -->
                        @if($artikel->count() > 3)
                            <div class="col-12 mt-5" data-aos="fade-up" data-aos-delay="300">
                                <div class="featured-banner p-4 rounded-4" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; position: relative; overflow: hidden;">
                                    <div class="row align-items-center">
                                        <div class="col-md-8">
                                            <h4 class="fw-bold mb-2">
                                                <i class="fas fa-star me-2"></i>
                                                Ada {{ $artikel->count() - 3 }} artikel menarik lainnya!
                                            </h4>
                                            <p class="mb-0 opacity-90">
                                                Jangan lewatkan berita dan informasi penting lainnya dari Desa Mekarmukti
                                            </p>
                                        </div>
                                        <div class="col-md-4 text-md-end mt-3 mt-md-0">
                                            <a href="{{ route('berita') }}" class="btn btn-light btn-lg px-4 py-2 rounded-pill fw-medium">
                                                <i class="fas fa-newspaper me-2"></i>
                                                Lihat Semua
                                            </a>
                                        </div>
                                    </div>
                                    <!-- Background Pattern -->
                                    <div class="position-absolute top-0 end-0" style="width: 200px; height: 200px; opacity: 0.1; background-image: radial-gradient(circle, white 2px, transparent 2px); background-size: 30px 30px;"></div>
                                </div>
                            </div>
                        @endif
                        
                    @else
                        <!-- Empty State -->
                        <div class="col-12">
                            <div class="text-center py-5">
                                <div class="mb-4">
                                    <i class="fas fa-newspaper text-gray-400" style="font-size: 4rem;"></i>
                                </div>
                                <h4 class="text-gray-600 mb-3">Belum Ada Berita</h4>
                                <p class="text-gray-500 mb-4">Berita dan artikel akan segera hadir. Pantau terus halaman ini untuk mendapatkan informasi terbaru!</p>
                                <a href="{{ route('home') }}" class="btn btn-outline-primary">
                                    <i class="fas fa-home me-2"></i>
                                    Kembali ke Beranda
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
                
                <!-- Call to Action Section -->
                @if($artikel && $artikel->count() > 0)
                    <div class="row justify-content-center mt-5">
                        <div class="col-lg-8">
                            <div class="cta-card text-center p-5 rounded-4" style="background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%); border: 2px dashed #cbd5e1;" data-aos="fade-up" data-aos-delay="400">
                                <div class="mb-4">
                                    <i class="fas fa-bell text-warning" style="font-size: 3rem;"></i>
                                </div>
                                <h4 class="fw-bold text-gray-800 mb-3">Jangan Ketinggalan!</h4>
                                <p class="text-gray-600 mb-4 lead">
                                    Dapatkan notifikasi untuk berita dan pengumuman terbaru dari Desa Mekarmukti langsung di perangkat Anda.
                                </p>
                                <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center">
                                    <a href="{{ route('berita') }}" class="btn btn-primary btn-lg px-5 py-3 rounded-pill">
                                        <i class="fas fa-newspaper me-2"></i>
                                        Jelajahi Semua Berita
                                    </a>
                                    <button id="subscribeButton" class="btn btn-outline-warning btn-lg px-5 py-3 rounded-pill">
                                        <i class="fas fa-bell me-2"></i>
                                        Subscribe Notifikasi
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </section>
        
        {{-- ======= Majalah Desa Section ======= --}}
        <section class="majalah-section py-5" style="background: linear-gradient(135deg, #1e293b 0%, #334155 100%); position: relative; overflow: hidden;">
            <!-- Background Pattern -->
            <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; opacity: 0.1; background-image: url('data:image/svg+xml,<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 100 20\"><defs><radialGradient id=\"a\" cx=\"50%\" cy=\"50%\"><stop offset=\"0%\" stop-color=\"rgba(255,255,255,.1)\"/><stop offset=\"100%\" stop-color=\"rgba(255,255,255,0)\"/></radialGradient></defs><circle fill=\"url(%23a)\" cx=\"10\" cy=\"10\" r=\"10\"/><circle fill=\"url(%23a)\" cx=\"90\" cy=\"5\" r=\"5\"/><circle fill=\"url(%23a)\" cx=\"70\" cy=\"15\" r=\"7\"/><circle fill=\"url(%23a)\" cx=\"30\" cy=\"5\" r=\"3\"/></svg>') repeat;"></div>
            
            <div class="container" style="position: relative; z-index: 2;">
                <!-- Section Header -->
                <div class="text-center mb-5" data-aos="fade-up">
                    <div class="d-inline-block mb-3">
                        <span class="badge bg-warning px-4 py-2 rounded-pill text-dark text-uppercase fw-medium ls-1" style="font-size: 0.75rem; letter-spacing: 1px;">
                            <i class="fas fa-book me-2"></i>
                            Digital Magazine
                        </span>
                    </div>
                    <h2 class="display-5 fw-bold text-white mb-4">
                        📚 Majalah Desa Digital
                    </h2>
                    <p class="lead text-white-75 max-w-2xl mx-auto" style="color: rgba(255,255,255,0.8);">
                        Nikmati pengalaman membaca majalah desa secara digital dengan efek flipbook yang interaktif
                    </p>
                    <div class="divider mx-auto mt-4" style="width: 60px; height: 4px; background: linear-gradient(90deg, #F59E0B, #D97706); border-radius: 2px;"></div>
                </div>

                @if(isset($latestMajalah) && $latestMajalah)
                <!-- Featured Magazine -->
                <div class="row align-items-center" data-aos="fade-up" data-aos-delay="100">
                    <div class="col-lg-6 mb-4 mb-lg-0">
                        <div class="magazine-preview position-relative">
                            <div class="magazine-cover-container" style="perspective: 1000px;">
                                <div class="magazine-cover" style="transform: rotateY(-15deg) rotateX(5deg); transition: all 0.6s ease;">
                                    @if($latestMajalah->cover_image && file_exists(public_path('storage/' . $latestMajalah->cover_image)))
                                        <img src="{{ asset('storage/' . $latestMajalah->cover_image) }}" 
                                             alt="Cover {{ $latestMajalah->judul }}"
                                             class="img-fluid rounded-3 shadow-lg"
                                             style="width: 100%; max-width: 400px; height: auto;">
                                    @else
                                        <div class="img-fluid rounded-3 shadow-lg d-flex align-items-center justify-content-center" 
                                             style="width: 100%; max-width: 400px; height: 500px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                            <div class="text-center text-white">
                                                <i class="fas fa-book fa-4x mb-3"></i>
                                                <h5>{{ $latestMajalah->judul }}</h5>
                                            </div>
                                        </div>
                                    @endif
                                    
                                    <!-- Floating Badge -->
                                    <div class="position-absolute top-0 start-0 m-3">
                                        <span class="badge bg-success px-3 py-2 rounded-pill">
                                            <i class="fas fa-star me-1"></i>
                                            Terbaru
                                        </span>
                                    </div>
                                    
                                    <!-- Pages Count Badge -->
                                    <div class="position-absolute bottom-0 end-0 m-3">
                                        <span class="badge bg-dark px-3 py-2 rounded-pill">
                                            {{ $latestMajalah->total_pages }} Halaman
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-6">
                        <div class="magazine-info text-white">
                            <h3 class="fw-bold mb-3" style="font-size: 2.5rem; line-height: 1.2;">
                                {{ $latestMajalah->judul }}
                            </h3>
                            
                            <p class="lead mb-4" style="color: rgba(255,255,255,0.9); line-height: 1.6;">
                                {{ $latestMajalah->deskripsi }}
                            </p>
                            
                            <!-- Magazine Stats -->
                            <div class="magazine-stats mb-4">
                                <div class="row text-center">
                                    <div class="col-4">
                                        <div class="stat-item">
                                            <h4 class="text-warning fw-bold mb-1">{{ $latestMajalah->total_pages }}</h4>
                                            <small class="text-white-75">Halaman</small>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="stat-item">
                                            <h4 class="text-warning fw-bold mb-1">{{ $latestMajalah->tanggal_terbit->format('M') }}</h4>
                                            <small class="text-white-75">{{ $latestMajalah->tanggal_terbit->format('Y') }}</small>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="stat-item">
                                            <h4 class="text-warning fw-bold mb-1">
                                                <i class="fas fa-eye"></i>
                                            </h4>
                                            <small class="text-white-75">Digital</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Action Buttons -->
                            <div class="d-flex flex-column flex-sm-row gap-3">
                                <a href="{{ route('majalah.desa') }}" 
                                   class="btn btn-warning btn-lg px-5 py-3 rounded-pill fw-medium">
                                    <i class="fas fa-book-open me-2"></i>
                                    Baca Sekarang
                                </a>
                                <a href="{{ route('majalah.desa') }}" 
                                   class="btn btn-outline-light btn-lg px-5 py-3 rounded-pill fw-medium">
                                    <i class="fas fa-th-large me-2"></i>
                                    Lihat Koleksi
                                </a>
                            </div>
                            
                            <!-- Publication Date -->
                            <div class="mt-4 pt-3 border-top" style="border-color: rgba(255,255,255,0.2) !important;">
                                <small class="text-white-75">
                                    <i class="fas fa-calendar-alt me-2"></i>
                                    Diterbitkan {{ $latestMajalah->tanggal_terbit->format('d F Y') }}
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
                @else
                <!-- Empty State -->
                <div class="text-center py-5" data-aos="fade-up" data-aos-delay="100">
                    <div class="mb-4">
                        <i class="fas fa-book text-white-50" style="font-size: 4rem;"></i>
                    </div>
                    <h4 class="text-white mb-3">Majalah Segera Hadir</h4>
                    <p class="text-white-75 mb-4">Kami sedang mempersiapkan majalah digital yang menarik untuk Anda. Pantau terus halaman ini!</p>
                    <a href="{{ route('home') }}" class="btn btn-outline-warning btn-lg px-5 py-3 rounded-pill">
                        <i class="fas fa-home me-2"></i>
                        Kembali ke Beranda
                    </a>
                </div>
                @endif
            </div>
        </section>
        
        <style>
        /* Modern News Cards Styling */
        .news-card {
            transform: translateY(0);
            cursor: pointer;
        }
        
        .news-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.15) !important;
        }
        
        .news-card:hover img {
            transform: scale(1.05);
        }
        
        .news-card:hover .position-absolute.bottom-0 {
            opacity: 1;
        }
        
        .news-card:hover .position-absolute.top-0.start-0.end-0.bottom-0 {
            border-color: #F59E0B;
        }
        
        .news-card .btn-primary:hover {
            transform: translateX(5px);
        }
        
        /* Featured Banner Animation */
        .featured-banner {
            animation: float 6s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-5px); }
        }
        
        /* CTA Card Hover */
        .cta-card {
            transition: all 0.3s ease;
        }
        
        .cta-card:hover {
            border-color: #F59E0B;
            background: linear-gradient(135deg, #fff7ed 0%, #fef3e2 100%);
        }
        
        /* Subscribe Button Animation */
        #subscribeButton {
            transition: all 0.3s ease;
        }
        
        #subscribeButton:hover {
            transform: translateY(-2px);
        }
        
        #subscribeButton:hover i {
            animation: ring 0.5s ease-in-out;
        }
        
        @keyframes ring {
            0%, 100% { transform: rotate(0deg); }
            25% { transform: rotate(-10deg); }
            75% { transform: rotate(10deg); }
        }
        
        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .news-card {
                margin-bottom: 1.5rem;
            }
            
            .featured-banner {
                text-align: center;
            }
            
            .display-5 {
                font-size: 2rem;
            }
        }
        </style>
        {{-- End Berita Section --}}
        
        <style>
        /* Magazine Section Styles */
        .magazine-cover:hover {
            transform: rotateY(0deg) rotateX(0deg) scale(1.05) !important;
        }
        
        .text-white-75 {
            color: rgba(255,255,255,0.75) !important;
        }
        
        .magazine-stats .stat-item {
            padding: 0 10px;
        }
        
        @media (max-width: 768px) {
            .magazine-cover {
                transform: none !important;
            }
            
            .magazine-info h3 {
                font-size: 2rem !important;
            }
            
            .magazine-stats {
                margin-bottom: 2rem;
            }
        }
        </style>
        {{-- End Majalah Section --}}
        
        {{-- End Main Content --}}
  </main><!-- End #main -->

    </main>
@endsection
@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const heroElement = document.getElementById('hero');

            function updateBackgroundImage(slideIndex) {
                const images = [
                    '/img/IMG_9152.png',
                    '/img/kantor.png',
                    '/img/IMG_9152.png'
                ];
                heroElement.style.setProperty('--background-image', `url(${images[slideIndex]})`);
            }

            const carousel = document.querySelector('#heroCarousel');
            const carouselItems = document.querySelectorAll('.carousel-item');

            carousel.addEventListener('slid.bs.carousel', function(event) {
                const slideIndex = Array.from(carouselItems).indexOf(event.relatedTarget);
                updateBackgroundImage(slideIndex);
            });

            updateBackgroundImage(0);
        });
    </script>
@endsection
