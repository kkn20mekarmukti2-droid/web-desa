@extends('layout.app')

@section('title', 'Beranda - Desa Mekarmukti')

@section('content')

{{-- Include Hero Welcome Component --}}
@include('components.hero-welcome')

  <main id="main">

        <!-- ======= Services Section dengan background wave color ======= -->
        <section class="services" style="background-color: #EAF2F7; padding-top: 60px; margin-top: -1px;">
            <div class="container">

                <div class="row">
                    <div class="col-md-6 col-lg-3 d-flex align-items-stretch" data-aos="fade-up">
                        <div class="icon-box icon-box-pink">
                            <div class="icon"><i class="bx bxl-dribbble"></i></div>
                            <h4 class="title"><a href="#">Sejarah Terbentuk Desa</a></h4>
                            <p class="description">Desa Mekarmukti adalah sebuah Desa yang merupakan Pamekaran dari Desa Cihampelas yang pada waktu itu Kecamatan Cililin, Kawedanaan Cililin,  Kabupaten Bandung.  </p>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-3 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="100">
                        <div class="icon-box icon-box-cyan">
                            <div class="icon"><i class="bx bx-file"></i></div>
                            <h4 class="title"><a href="#">Sejarah Pembangunan Desa</a></h4>
                            <p class="description">Desa Mekarmukti Kecamatan Cihampelas adalah salah satu Desa termaju
                                dalam
                                Pembangunan disegala Bidang, baik Pembangunan sarana dan prasarana, Pembangunan Ekonomi,
                                UMKM dan Pendidikan.
                            </p>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-3 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="200">
                        <div class="icon-box icon-box-green">
                            <div class="icon"><i class="bx bx-tachometer"></i></div>
                            <h4 class="title"><a href="#">Topografi Desa</a></h4>
                            <p class="description">Desa Mekarmukti merupakan desa yang berada di daerah perbukitan
                                dengan ketinggian
                                antara 274 Meter (diatas permukaan laut). </p>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-3 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="200">
                        <div class="icon-box icon-box-blue">
                            <div class="icon"><i class="bx bx-world"></i></div>
                            <h4 class="title"><a href="">Isu Strategis Yang dihadapi
                                </a></h4>
                            <p class="description">Isu strategis merupakan permasalahan yang berkaitan
                                dengan fenomena atau belum dapat deselesaikan pada periode
                                lima tahun sebelumnya.</p>
                        </div>
                    </div>

                </div>

            </div>
        </section>
        
        {{-- ======= Berita Terbaru Section ======= --}}
        <section class="py-12 bg-white">
            <div class="container">
                <div class="section-title text-center" data-aos="fade-up">
                    <h2 class="text-3xl font-bold text-gray-800 mb-4">Berita Terbaru</h2>
                    <p class="text-gray-600 mb-8">Informasi terkini dari Desa Mekarmukti</p>
                </div>
                
                <div class="row" data-aos="fade-up" data-aos-delay="100">
                    @if($artikel && $artikel->count() > 0)
                        @foreach($artikel->take(3) as $berita)
                            <div class="col-lg-4 col-md-6 mb-4">
                                <div class="card h-100 shadow-sm border-0">
                                    @if($berita->gambar)
                                        <img src="{{ asset('img/' . $berita->gambar) }}" class="card-img-top" alt="{{ $berita->judul }}" style="height: 200px; object-fit: cover;">
                                    @else
                                        <div class="card-img-top bg-gray-200 d-flex align-items-center justify-content-center" style="height: 200px;">
                                            <i class="bi bi-image text-gray-400" style="font-size: 3rem;"></i>
                                        </div>
                                    @endif
                                    <div class="card-body d-flex flex-column">
                                        <small class="text-muted mb-2">{{ $berita->created_at->format('d M Y') }}</small>
                                        <h5 class="card-title">{{ Str::limit($berita->judul, 50) }}</h5>
                                        <p class="card-text flex-grow-1">{{ Str::limit(strip_tags($berita->konten), 100) }}</p>
                                        <a href="{{ route('detailartikel', ['tanggal' => $berita->created_at->format('Y-m-d'), 'judul' => Str::slug($berita->judul)]) }}" 
                                           class="btn btn-outline-primary mt-auto">Baca Selengkapnya</a>
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
        
        <div class="flex flex-col sm:flex-row  items-center justify-between bg-gray-100 p-6 space-y-4 sm:space-y-0 sm:w-[1280px] mx-auto rounded-md"
            data-aos="fade-up" date-aos-delay="200">
            <p class="text-center sm:text-left text-gray-700 text-lg font-medium">
                Jangan ketinggalan! Subscribe untuk menerima notifikasi terkait artikel terbaru dari Desa Kami.
            </p>
            <button id="subscribeButton"
                class="transform bg-blue-500 text-white font-bold py-2 px-6 rounded-lg shadow-lg transition duration-300 ease-in-out hover:-translate-y-1 hover:scale-105 hover:bg-blue-600 flex items-center space-x-2 group">
                <i class="fa-solid fa-bell group-hover:animate-bounce transition-all"></i>
                <span>Subscribe</span>
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
