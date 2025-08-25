@extends('layout.app')

@section('content')
<main id="main">

    {{-- Breadcrumbs --}}
    <section class="breadcrumbs py-3 bg-light border-bottom">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <h2 class="mb-0 fw-semibold">Sejarah</h2>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('home') }}">Beranda</a>
                    </li>
                    <li class="breadcrumb-item active">Sejarah Desa</li>
                </ol>
            </div>
        </div>
    </section>

    {{-- Content --}}
    <section class="features py-5">
        <div class="container">

            {{-- Title --}}
            <div class="section-title text-center mb-2">
                <h2 class="fw-bold">Sejarah Desa Mekarmukti</h2>
                <p class="text-muted w-75 mx-auto">
                    Berikut adalah sejarah singkat terbentuknya Desa Mekarmukti, Kecamatan Cihampelas, Kabupaten Bandung Barat.
                </p>
            </div>

            {{-- Description --}}
            <div class="row justify-content-center" data-aos="fade-up">
                <div class="col-lg-8 col-md-10">

                    <p class="text-justify">
                        Desa Mekarmukti Kecamatan Cihampelas Kabupaten Bandung Barat adalah Desa Pamekaran dari Desa Cihampelas yang pada waktu itu masih ikut bergabung dengan Kecamatan Cililin, Kawedanaan Cililin, Kabupaten Bandung. Desa Mekarmukti berdiri pada tanggal <strong>5 Mei 1982</strong>.
                    </p>

                    <p class="text-justify">
                        Desa Mekarmukti memiliki luas wilayah <strong>441.00 Hektare</strong> yang berbatasan langsung dengan desa lain seperti di sebelah utara berbatasan dengan Desa Cihampelas, bagian selatan berbatasan dengan Desa Karang Tanjung, sebelah barat dengan Desa Mekarjaya, dan sebelah timur dengan Desa Citapen. Desa Mekarmukti terbagi menjadi <strong>4 Dusun, 11 RW, dan 63 RT</strong>.
                    </p>

                    <p class="text-justify">
                        Penduduk Desa Mekarmukti sebagian besar berprofesi sebagai petani dan nelayan ikan tambak. Selain itu, ada juga yang berprofesi sebagai buruh dan pekerjaan lainnya.
                    </p>

                    <p class="text-justify mb-3">
                        Desa Mekarmukti telah mengalami pergantian kepemimpinan sebanyak 7 kali, dimulai dari:
                    </p>

                    {{-- List Kepala Desa --}}
                    <ul class="list-group shadow-sm">
                        <li class="list-group-item">
                            <i class="bi bi-person-fill me-2 text-primary"></i> 1982 - 1985 : Bapak H. Sofyan
                        </li>
                        <li class="list-group-item">
                            <i class="bi bi-person-fill me-2 text-primary"></i> 1985 - 1993 : Bapak H. Mulloh
                        </li>
                        <li class="list-group-item">
                            <i class="bi bi-person-fill me-2 text-primary"></i> 1993 - 2002 : Bapak Udin Samsudin
                        </li>
                        <li class="list-group-item">
                            <i class="bi bi-person-fill me-2 text-primary"></i> 2002 - 2007 : Bapak Asep Supriatna
                        </li>
                        <li class="list-group-item">
                            <i class="bi bi-person-fill me-2 text-primary"></i> 2007 - 2019 : Bapak H. Deden Sutisna <small>(2 periode)</small>
                        </li>
                        <li class="list-group-item">
                            <i class="bi bi-person-fill me-2 text-primary"></i> 2019 : Bapak PJS Tatang Muslim
                        </li>
                        <li class="list-group-item">
                            <i class="bi bi-person-fill me-2 text-primary"></i> 2019 - Sekarang : Bapak Andriawan Burhanudin, SH
                            <span class="badge bg-success ms-2">MOTEKAR</span>
                            <small>(Maju, Profesional, Tangguh, Kreatif, Religius)</small>
                        </li>
                    </ul>

                </div>
            </div>
        </div>
    </section>

</main>
@endsection

@section('script')
<script>
    AOS.init();
</script>
@endsection
