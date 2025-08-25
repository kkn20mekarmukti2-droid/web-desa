@extends('layout.app')
@section('content')
<main id="main">

    {{-- Breadcrumb --}}
    <section class="breadcrumbs py-3 bg-light border-bottom">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="fw">Visi</h2>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
                    <li class="breadcrumb-item active">Struktur Pemerintahan</li>
                </ol>
            </div>
        </div>
    </section>

    {{--Visi dan Misi--}}
    <section class="features py-5">
        <div class="container">

            <div class="section-title text-center mb-5">
                <h2 class="fw-bold ">Visi & Misi Desa Mekarmukti</h2>
                <p class="text-muted w-75 mx-auto">
                    Berdasarkan kondisi saat ini dan tantangan yang akan dihadapi dalam enam tahun mendatang,
                    dengan mempertimbangkan modal dasar, potensi, serta keinginan masyarakat demi tercapainya
                    tujuan yang terukur dan terkendali.
                </p>
            </div>

            {{--Visi--}}
            <div class="row align-items-center mb-5" data-aos="fade-up">
                <div class="col-md-5">
                    <img src="assets/img/pamong2.jpg" class="img-fluid rounded shadow" alt="Visi Desa">
                </div>
                <div class="col-md-7 pt-4">
                    <h3 class="fw-bold text-center">VISI</h3>
                    <p class="fst-italic text-center">Adapun Visi Kepala Desa Mekarmukti sebagai berikut:</p>
                    <div class="alert fw-bold text-center shadow-sm">
                        Gotong Royong Membangun Desa Mekarmukti yang Maju, Profesional, Tangguh, Kreatif dan Religius (MOTEKAR)
                    </div>
                    <div class="row g-3">
                        @php
                            $visiList = [
                                ['Maju','Mewujudkan Desa Mekarmukti yang harmonis dan dinamis, dengan bersama atasi permasalahan melalui musyawarah dan mufakat.'],
                                ['Profesional','Mewujudkan masyarakat Desa Mekarmukti yang unggul dan produktif melalui peningkatan sumber daya manusia dan potensi lingkungan dengan terus membangun sarana dan prasarana penunjang untuk giat dan lancarnya roda perekonomian masyarakat.'],
                                ['Tangguh','Siap dan sedia menghadapi perkembangan di era digital.'],
                                ['Kreatif','Menumbuhkembangkan kreatifitas kelompok-Kelompok masyarakat di bidang Pendidikan, Pertanian, Peternakan Kesehatan dan Mufakat.'],
                                ['Religius','Mewujudkan masyarakat Desa Mekarmukti yang berahlakul karimah dalam setiap gerak dan sendi kehidupan berlandaskan iman dan taqwa dengan menggiatkan peran para ulama dan meningkatkan kegiatan dibidang keagamaan serta terus membangun sarana dan prasarana peribadatan dan majlis ta’lim sebagai pusat Rohani.']
                            ];
                        @endphp
                        @foreach($visiList as $visi)
                        <div class="col-md-6">
                            <div class="card shadow-sm h-100 border-0">
                                <div class="card-body">
                                    <h5 class="fw-bold"><i class="bi bi-check-circle-fill me-2"></i>{{ $visi[0] }}</h5>
                                    <p class="mb-0 text-muted">{{ $visi[1] }}</p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{--Misi--}}
            <div class="row align-items-center" data-aos="fade-up">
                <div class="col-md-5 order-1 order-md-2">
                    <img src="assets/img/pamong3.jpg" class="img-fluid rounded shadow" alt="Misi Desa">
                </div>
                <div class="col-md-7 pt-4 order-2 order-md-1">
                    <h3 class="fw-bold">MISI</h3>
                    <ul class="list-group list-group-flush">
                        @php
                            $misiList = [
                                'Pelayanan administrasi desa berbasis digital.',
                                'Perbaikan sarana infrastruktur.',
                                'Membangun tempat pengolahan sampah terpadu.',
                                'Bantuan modal bergulir bagi UMKM.',
                                'Subsidi dana kesehatan untuk dhuafa.',
                                'Kadedeh tahunan bagi guru ngaji, anak yatim & dhuafa.',
                                'Alokasi dana pertanian & perikanan.',
                                'Beasiswa pelajar berprestasi & dhuafa.',
                                'Stadion mini / lapang desa.',
                                'Membangun sanggar seni & budaya.'
                            ];
                        @endphp
                        @foreach($misiList as $misi)
                        <li class="list-group-item d-flex align-items-center">
                            <i class="bi bi-check-circle-fill text-success me-2"></i> {{ $misi }}
                        </li>
                        @endforeach
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
    Fancybox.bind('[data-fancybox="gallery"]', {});
</script>
@endsection
