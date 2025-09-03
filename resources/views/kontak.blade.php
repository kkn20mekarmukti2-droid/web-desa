@extends('layout.app')
@section('judul', 'Kontak Desa Mekarmukti')
@section('content')

    <main id="main">

        <section class="breadcrumbs">
            <div class="container">
                <div class="d-flex justify-content-between align-items-center">
                    <h2>Kontak Desa</h2>
                    <ol>
                        <li><a href="{{ route('home') }}">Beranda</a></li>
                        <li>Kontak</li>
                    </ol>
                </div>
            </div>
        </section>

        <section class="contact" data-aos="fade-up" data-aos-easing="ease-in-out" data-aos-duration="500">
            <div class="container">
                
                <!-- Hero Section -->
                <div class="text-center mb-5">
                    <h1 class="text-3xl font-bold text-gray-800 mb-3">📞 Hubungi Kami</h1>
                    <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                        Pemerintah Desa Mekarmukti siap melayani masyarakat. Silakan hubungi kami melalui informasi kontak di bawah ini.
                    </p>
                </div>

                <!-- Contact Cards -->
                <div class="row g-4 mb-5">
                    <!-- Alamat -->
                    <div class="col-lg-4 col-md-6">
                        <div class="card h-100 border-0 shadow-sm hover:shadow-lg transition-all duration-300">
                            <div class="card-body text-center p-4">
                                <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 80px; height: 80px;">
                                    <i class="bx bx-map text-primary" style="font-size: 2.5rem;"></i>
                                </div>
                                <h4 class="card-title text-primary mb-3">📍 Alamat Kantor</h4>
                                <p class="card-text text-gray-600 lh-base">
                                    <strong>Desa Mekarmukti</strong><br>
                                    Kec. Cihampelas<br>
                                    Kab. Bandung Barat<br>
                                    Jawa Barat 40562
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="col-lg-4 col-md-6">
                        <div class="card h-100 border-0 shadow-sm hover:shadow-lg transition-all duration-300">
                            <div class="card-body text-center p-4">
                                <div class="bg-success bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 80px; height: 80px;">
                                    <i class="bx bx-envelope text-success" style="font-size: 2.5rem;"></i>
                                </div>
                                <h4 class="card-title text-success mb-3">📧 Email Resmi</h4>
                                <p class="card-text text-gray-600 mb-3">
                                    Hubungi kami via email untuk keperluan resmi dan informasi layanan
                                </p>
                                <a href="mailto:pelayanan@mekarmukti.id" class="btn btn-outline-success btn-sm">
                                    <i class="bx bx-envelope me-2"></i>
                                    pelayanan@mekarmukti.id
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Telepon -->
                    <div class="col-lg-4 col-md-6">
                        <div class="card h-100 border-0 shadow-sm hover:shadow-lg transition-all duration-300">
                            <div class="card-body text-center p-4">
                                <div class="bg-warning bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 80px; height: 80px;">
                                    <i class="bx bx-phone-call text-warning" style="font-size: 2.5rem;"></i>
                                </div>
                                <h4 class="card-title text-warning mb-3">📱 Telepon/WhatsApp</h4>
                                <p class="card-text text-gray-600 mb-3">
                                    Hubungi kami langsung untuk informasi cepat dan layanan darurat
                                </p>
                                <div class="d-flex flex-column gap-2">
                                    <a href="tel:+6285798121885" class="btn btn-outline-warning btn-sm">
                                        <i class="bx bx-phone me-2"></i>
                                        +62 857-9812-1885
                                    </a>
                                    <a href="https://wa.me/6285798121885" target="_blank" class="btn btn-success btn-sm">
                                        <i class="fab fa-whatsapp me-2"></i>
                                        Chat WhatsApp
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- CTA Section -->
                <div class="row">
                    <div class="col-12">
                        <div class="card border-0 bg-gradient-primary text-white">
                            <div class="card-body text-center p-5">
                                <h3 class="card-title mb-4">💌 Punya Keluhan atau Saran?</h3>
                                <p class="card-text lead mb-4">
                                    Gunakan layanan pengaduan online kami untuk menyampaikan keluhan, saran, atau aspirasi Anda dengan mudah dan aman.
                                </p>
                                <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center">
                                    <a href="{{ route('pengaduan') }}" class="btn btn-light btn-lg">
                                        <i class="fas fa-comment-dots me-2"></i>
                                        Buat Pengaduan
                                    </a>
                                    <a href="{{ route('home') }}" class="btn btn-outline-light btn-lg">
                                        <i class="fas fa-home me-2"></i>
                                        Kembali ke Beranda
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>

        <!-- Maps Section -->
        <section class="map mt-4">
            <div class="container-fluid p-0">
                <div class="text-center mb-4">
                    <h3 class="text-2xl font-bold text-gray-800 mb-2">🗺️ Lokasi Kantor Desa</h3>
                    <p class="text-gray-600">Temukan lokasi kantor Desa Mekarmukti dengan mudah</p>
                </div>
                <div class="map-container" style="height: 450px; border-radius: 15px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
                    <iframe
                        src="https://www.google.com/maps/place/KANTOR+DESA+MEKARMUKTI/@-6.9316757,107.4620144,19z/data=!3m1!4b1!4m6!3m5!1s0x2e68fb7c39b424a3:0xe7640e0d1e691952!8m2!3d-6.9316757!4d107.4626581!16s%2Fg%2F11k3ds2_9q?entry=ttu&g_ep=EgoyMDI1MDgyNS4wIKXMDSoASAFQAw%3D%3D"
                        width="100%" 
                        height="450" 
                        frameborder="0" 
                        style="border:0;" 
                        allowfullscreen="">
                    </iframe>
                </div>
            </div>
        </section>

    </main>

@endsection

<style>
.card {
    transition: all 0.3s ease;
}

.card:hover {
    transform: translateY(-5px);
}

.bg-gradient-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.map-container {
    position: relative;
    overflow: hidden;
}

.map-container::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(45deg, rgba(102, 126, 234, 0.1), rgba(118, 75, 162, 0.1));
    pointer-events: none;
    z-index: 1;
}

.map-container iframe {
    position: relative;
    z-index: 2;
}

@media (max-width: 768px) {
    .card-body {
        padding: 1.5rem !important;
    }
    
    .bg-gradient-primary .card-body {
        padding: 2rem 1.5rem !important;
    }
}
</style>
