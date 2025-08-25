@extends('layout.app')
@section('content')
    <!-- ======= Hero Section ======= -->
    <section id="hero" class="d-flex justify-cntent-center align-items-center">
        <div id="heroCarousel" class="container carousel carousel-fade" data-bs-ride="carousel" data-bs-interval="5000">

            <!-- Slide 1 -->
            <div class="carousel-item active slide-1">
                <div class="carousel-container">
                    <h2 class="animate__animated animate__fadeInDown" style="color: white;">Selamat Datang di <span>Desa Mekarmukti</span>
                    </h2>
                    <p class="animate__animated animate__fadeInUp"></p>
                    <a href="/about" class="btn-get-started animate__animated animate__fadeInUp" style="color: black;">Baca Lainnya</a>
                </div>
            </div>

            <!-- Slide 2 -->
            <div class="carousel-item slide-2">
                <div class="carousel-container">
                    <h2 class="animate__animated animate__fadeInDown">Sejarah Pembangunan Desa</h2>
                    <p class="animate__animated animate__fadeInUp">Desa Mekarmukti Kecamatan Cihampelas adalah salah
                        satu Desa
                        termaju dalam Pembangunan disegala Bidang, baik Pembangunan sarana dan prasarana, Pembangunan
                        Ekonomi,
                        Pendidikan, Kesehatan, UMKM maupun Pembangunan Sosial lainnya bila dibanding dengan Desa lain
                        yang ada di
                        kecamatan Cihampelas. </p>
                    <a href="/pemerintahan" class="btn-get-started animate__animated animate__fadeInUp">Baca Lainnya</a>
                </div>
            </div>

            <!-- Slide 3 -->
            <div class="carousel-item slide-3">
                <div class="carousel-container">
                    <h2 class="animate__animated animate__fadeInDown">Karakteristik Desa</h2>
                    <p class="animate__animated animate__fadeInUp">Desa Mekarmukti merupakan perdesaan dengan mata
                        pencaharian
                        sebagian besar penduduk adalah sector industri rumah tangga yang bergerak dibidang Wajit,
                        Gurilem, Pindang, dll.
                    </p>
                    <a href="/potensi-desa" class="btn-get-started animate__animated animate__fadeInUp">Baca Lainnya</a>
                </div>
            </div>

            <a class="carousel-control-prev" href="#heroCarousel" role="button" data-bs-slide="prev">
                <span class="carousel-control-prev-icon bx bx-chevron-left" aria-hidden="true"></span>
            </a>

            <a class="carousel-control-next" href="#heroCarousel" role="button" data-bs-slide="next">
                <span class="carousel-control-next-icon bx bx-chevron-right" aria-hidden="true"></span>
            </a>

        </div>
    </section>

    <main id="main">

        <section class="services">
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


        <section class="why-us " data-aos="fade-up" date-aos-delay="200">
            <div class="container">

                <div class="w-full text-center">
                    <h3 class="pt-10 text-4xl">Kabar Desa</h3>
                    <p class="border-b md:mx-60 max-sm:text-sm">Informasi Mengenai Perkembangan dan Berita Desa Terbaru.
                    </p>
                </div>

                <div class="grid grid-cols-2 gap-5 max-sm:grid-cols-1 mb-5">
                    @foreach ($artikel as $i)
                        <div class="border-b-2  p-3">
                            <a
                                href="{{ route('detailartikel', ['tanggal' => $i->created_at->format('Y-m-d'), 'judul' => Str::slug($i->judul, '-')]) }}">
                                <h3 class="mt-2 text-xl">{{ $i->judul }}</h3>
                                <p>{{ $i->header }}</p>
                            </a>
                            @if (strpos($i->sampul, 'youtube'))
                                <iframe class="h-[90%] w-full min-h-80 max-sm:min-h-60" src="{{ $i->sampul }}"
                                    title="YouTube video player" frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                    referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                            @else
                                <img src="{{ asset('img/' . $i->sampul) }}" alt="" class="w-full h-[90%]">
                            @endif
                        </div>
                    @endforeach

                </div>
                <button type="button" class="btn btn-primary mb-3 ms-auto"> <a href="{{ route('berita') }}">Berita
                        Lainnya</a> </button>
            </div>
        </section>

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
