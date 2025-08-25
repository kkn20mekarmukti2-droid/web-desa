<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <meta content="@yield('judul', 'Desa Mekarmukti, pemekaran Desa Cihampelas pada 1980, adalah desa termuda di Kecamatan Cihampelas, Kabupaten Bandung Barat. Temukan lebih lanjut di sini!')" name="description">
    <meta content="desa, mekarmukti, cihampelas, berita desa,desa mekarmukti" name="keywords">
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

    <link href="{{ asset('assets/vendor/animate.css/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/aos/aos.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
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



</head>

<body>

    <!-- ======= Header ======= -->
    <header id="header" class="fixed-top d-flex align-items-center ">
        <div class="container d-flex justify-content-between align-items-center">

            <img src="{{ asset('assets/img/motekar-bg.png') }}" alt="" width="45px" class="m-lg-auto">
            <div class="container d-flex justify-content-between align-items-center">

                <div class="logo">
                    <h1 class="text-light"> <a href="index.html"><span>Mekarmukti</span></a></h1>
                    <h6 class="text-light max-sm:text-xs">Kec.Cihampelas, Kab.Bandung Barat, Jawa Barat</h6>

                </div>

    <nav class="navbar navbar-expand-lg navbar-dark bg-transparent border-0 shadow-none">
  <div class="container">
    <a class="navbar-brand" href="{{ route('home') }}">
      <!-- Logo atau teks bisa di sini -->
    </a>

    <!-- Tombol hamburger (Bootstrap 5) -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
        aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Menu -->
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <ul class="navbar-nav ms-auto align-items-center">
        <li class="nav-item">
          <a class="nav-link" href="{{ route('home') }}">
            <i class="fas fa-home"></i>
          </a>
        </li>

        <!-- Profile Desa -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Profile Desa
          </a>
          <ul class="dropdown-menu" aria-labelledby="profileDropdown">
            <li><a class="dropdown-item" href="{{ route('sejarah') }}">Sejarah</a></li>
            <li><a class="dropdown-item" href="{{ route('visi') }}">Visi & Misi</a></li>
            <li><a class="dropdown-item" href="{{ route('pemerintahan') }}">Struktur Organisasi</a></li>
          </ul>
        </li>

        <!-- Informasi Desa -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="infoDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Informasi Desa
          </a>
          <ul class="dropdown-menu" aria-labelledby="infoDropdown">
            <li><a class="dropdown-item" href="{{ route('berita') }}">Berita</a></li>
            <li><a class="dropdown-item" href="{{ route('galeri') }}">Galeri</a></li>
            <li><a class="dropdown-item" href="{{ route('potensidesa') }}">Potensi Desa</a></li>
          </ul>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="{{ route('data.penduduk') }}">Data Statistik</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="{{ route('kontak') }}">Kontak</a>
        </li>

        <li class="nav-item">
            <!-- Tombol untuk membuka modal -->
<button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#formPengaduan">
    Buat Pengaduan 🚀
</button>

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


    <footer id="footer" data-aos="fade-up" data-aos-easing="ease-in-out" data-aos-duration="500">

        <div class="footer-top">
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

        <div class="container">
            <div class="copyright">
                &copy; Copyright <strong><span>Desa Mekarmukti</span></strong>.
            </div>
            <div class="credits">
                Designed by <a href="https://www.instagram.com/kkn_mekarmuktiplb/">KKN Politeknik LP3I Bandung</a>
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

</body>

</html>
