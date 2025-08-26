@extends('layout.app')

@section('title', 'Beranda - Desa Mekarmukti')

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
        <section class="py-8 md:py-12 bg-white">
            <div class="container">
                <div class="section-title text-center" data-aos="fade-up">
                    <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-3 md:mb-4">Berita Terbaru</h2>
                    <p class="text-gray-600 mb-6 md:mb-8 text-sm md:text-base">Informasi terkini dari Desa Mekarmukti</p>
                </div>
                
                <div class="row" data-aos="fade-up" data-aos-delay="100">
                    @if($artikel && $artikel->count() > 0)
                        @foreach($artikel->take(3) as $berita)
                            <div class="col-lg-4 col-md-6 mb-4">
                                <div class="card h-100 shadow-sm border-0">
                                    @if($berita->sampul)
                                        <!-- Debug: Show image path -->
                                        <div class="position-relative">
                                            <img src="{{ asset('img/' . $berita->sampul) }}" 
                                                 class="card-img-top img-fluid w-100" 
                                                 alt="{{ $berita->judul }}" 
                                                 style="height: 180px; object-fit: cover;"
                                                 loading="lazy"
                                                 onerror="console.error('Image failed to load:', this.src); this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                            <!-- Fallback placeholder -->
                                            <div class="card-img-top bg-light d-none align-items-center justify-content-center position-absolute top-0 start-0 w-100 h-100" 
                                                 style="height: 180px; background: #f8f9fa;">
                                                <div class="text-center">
                                                    <i class="bi bi-image text-muted" style="font-size: 2.5rem;"></i>
                                                    <small class="d-block text-muted mt-2">Gambar tidak ditemukan</small>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Debug info - remove in production -->
                                        <small class="text-muted px-2">Path: {{ asset('img/' . $berita->sampul) }}</small>
                                    @else
                                        <div class="card-img-top bg-light d-flex align-items-center justify-content-center" 
                                             style="height: 180px; background: #f8f9fa;">
                                            <div class="text-center">
                                                <i class="bi bi-image text-muted" style="font-size: 2.5rem;"></i>
                                                <small class="d-block text-muted mt-2">Tidak ada gambar</small>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="card-body d-flex flex-column p-3 md:p-4">
                                        <small class="text-muted mb-2">{{ $berita->created_at->format('d M Y') }}</small>
                                        <h5 class="card-title text-base md:text-lg">{{ Str::limit($berita->judul, 45) }}</h5>
                                        <p class="card-text flex-grow-1 text-sm md:text-base">{{ Str::limit(strip_tags($berita->deskripsi), 80) }}</p>
                                        <a href="{{ route('detailartikel', ['tanggal' => $berita->created_at->format('Y-m-d'), 'judul' => Str::slug($berita->judul)]) }}" 
                                           class="btn btn-outline-primary mt-auto btn-sm">Baca Selengkapnya</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="col-12 text-center">
                            <p class="text-muted">Belum ada berita tersedia.</p>
                        </div>
                    @endif
                </div>
                
                <div class="text-center mt-4" data-aos="fade-up" data-aos-delay="200">
                    <a href="{{ route('berita') }}" class="btn btn-primary btn-lg">Lihat Semua Berita</a>
                </div>
            </div>
        </section>
        {{-- End Berita Section --}}
        
        <div class="flex flex-col sm:flex-row items-center justify-between bg-gray-100 p-4 md:p-6 space-y-3 sm:space-y-0 max-w-6xl mx-auto rounded-md"
            data-aos="fade-up" date-aos-delay="200">
            <p class="text-center sm:text-left text-gray-700 text-base md:text-lg font-medium px-2">
                Jangan ketinggalan! Subscribe untuk menerima notifikasi terkait artikel terbaru dari Desa Kami.
            </p>
            <button id="subscribeButton"
                class="transform bg-blue-500 text-white font-bold py-3 px-6 md:py-2 md:px-6 rounded-lg shadow-lg transition duration-300 ease-in-out hover:-translate-y-1 hover:scale-105 hover:bg-blue-600 flex items-center space-x-2 group min-h-[48px]">
                <i class="fa-solid fa-bell group-hover:animate-bounce transition-all"></i>
                <span class="text-sm md:text-base">Subscribe</span>
            </button>
        </div>


                </div>
      </div>
    </section><!-- End Services Section -->
    
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
