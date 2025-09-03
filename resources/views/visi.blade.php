@extends('layout.app')
@section('content')
<main class="mt-20 w-full mb-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Hero Section with Breadcrumb --}}
        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-purple-600 via-indigo-600 to-blue-800 shadow-2xl mb-8">
            <div class="absolute inset-0 bg-black/20"></div>
            <div class="relative px-8 py-16 text-center">
                <div class="mb-4">
                    <nav class="flex justify-center" aria-label="Breadcrumb">
                        <ol class="inline-flex items-center space-x-1 md:space-x-3 text-white/80">
                            <li class="inline-flex items-center">
                                <a href="{{ route('home') }}" class="text-white/70 hover:text-white transition-colors">
                                    <i class="fa-solid fa-house"></i>
                                </a>
                            </li>
                            <li>
                                <div class="flex items-center">
                                    <i class="fa-solid fa-chevron-right text-white/60 mx-2"></i>
                                    <span class="text-white font-medium">Visi & Misi</span>
                                </div>
                            </li>
                        </ol>
                    </nav>
                </div>
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-4 leading-tight">
                    Visi & Misi
                </h1>
                <p class="text-xl text-white/90 max-w-3xl mx-auto leading-relaxed">
                    Panduan strategis untuk membangun Desa Mekarmukti yang maju, profesional, tangguh, kreatif dan religius
                </p>
            </div>
            <!-- Animated background elements -->
            <div class="absolute top-10 left-10 w-20 h-20 bg-white/10 rounded-full animate-pulse"></div>
            <div class="absolute bottom-10 right-10 w-16 h-16 bg-white/5 rounded-full animate-bounce"></div>
            <div class="absolute top-1/2 right-1/4 w-12 h-12 bg-white/5 rounded-full animate-ping"></div>
        </div>

        {{-- Introduction --}}
        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 mb-8 p-8 text-center">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Visi & Misi Desa Mekarmukti</h2>
            <p class="text-lg text-gray-600 leading-relaxed max-w-4xl mx-auto">
                Berdasarkan kondisi saat ini dan tantangan yang akan dihadapi dalam enam tahun mendatang,
                dengan mempertimbangkan modal dasar, potensi, serta keinginan masyarakat demi tercapainya
                tujuan yang terukur dan terkendali.
            </p>
        </div>

        {{-- VISI Section --}}
        <div class="grid lg:grid-cols-2 gap-8 mb-12">
            {{-- Vision Image --}}
            <div class="relative group">
                <div class="absolute inset-0 bg-gradient-to-r from-purple-600 to-blue-600 rounded-2xl opacity-20 group-hover:opacity-30 transition-opacity"></div>
                <img src="assets/img/pamong2.jpg" class="w-full h-96 object-cover rounded-2xl shadow-xl group-hover:scale-[1.02] transition-transform duration-500" alt="Visi Desa">
                <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent rounded-2xl"></div>
                <div class="absolute bottom-6 left-6 text-white">
                    <h3 class="text-2xl font-bold mb-2">Visi 2021-2027</h3>
                    <p class="text-white/80">Kepala Desa Mekarmukti</p>
                </div>
            </div>
            
            {{-- Vision Content --}}
            <div class="space-y-6">
                <div class="bg-gradient-to-br from-purple-50 to-indigo-50 rounded-2xl p-8 border border-purple-100">
                    <div class="flex items-center mb-6">
                        <div class="bg-gradient-to-r from-purple-600 to-blue-600 p-3 rounded-full mr-4">
                            <i class="fa-solid fa-eye text-white text-2xl"></i>
                        </div>
                        <h3 class="text-3xl font-bold text-gray-900">VISI</h3>
                    </div>
                    
                    <div class="bg-white rounded-xl p-6 shadow-lg border border-purple-200 mb-6">
                        <p class="text-center text-lg font-bold text-gray-800 leading-relaxed">
                            "Gotong Royong Membangun Desa Mekarmukti yang Maju, Profesional, Tangguh, Kreatif dan Religius"
                        </p>
                        <div class="text-center mt-4">
                            <span class="bg-gradient-to-r from-purple-600 to-blue-600 text-white px-6 py-2 rounded-full text-xl font-bold">
                                MOTEKAR
                            </span>
                        </div>
                    </div>
                </div>
                
                {{-- MOTEKAR Breakdown --}}
                <div class="grid grid-cols-1 gap-4">
                    @php
                        $visiList = [
                            ['Maju', 'Mewujudkan Desa Mekarmukti yang harmonis dan dinamis, dengan bersama atasi permasalahan melalui musyawarah dan mufakat.', 'green'],
                            ['Profesional', 'Mewujudkan masyarakat Desa Mekarmukti yang unggul dan produktif melalui peningkatan sumber daya manusia dan potensi lingkungan.', 'blue'],
                            ['Tangguh', 'Siap dan sedia menghadapi perkembangan di era digital.', 'purple'],
                            ['Kreatif', 'Menumbuhkembangkan kreatifitas kelompok-kelompok masyarakat di bidang Pendidikan, Pertanian, Peternakan, Kesehatan.', 'orange'],
                            ['Religius', 'Mewujudkan masyarakat Desa Mekarmukti yang berakhlakul karimah dalam setiap gerak dan sendi kehidupan berlandaskan iman dan taqwa.', 'red']
                        ];
                    @endphp
                    
                    @foreach($visiList as $visi)
                        <div class="bg-white rounded-xl shadow-lg border border-{{ $visi[2] }}-100 p-4 hover:shadow-xl hover:scale-[1.02] transition-all duration-300 group">
                            <div class="flex items-start space-x-4">
                                <div class="bg-gradient-to-r from-{{ $visi[2] }}-500 to-{{ $visi[2] }}-600 p-3 rounded-full flex-shrink-0">
                                    <i class="fa-solid fa-check text-white"></i>
                                </div>
                                <div class="flex-1">
                                    <h4 class="text-xl font-bold text-{{ $visi[2] }}-700 mb-2">{{ $visi[0] }}</h4>
                                    <p class="text-gray-600 leading-relaxed">{{ $visi[1] }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
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

        {{-- MISI Section --}}
        <div class="grid lg:grid-cols-2 gap-8">
            {{-- Mission Content --}}
            <div class="space-y-6">
                <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-2xl p-8 border border-green-100">
                    <div class="flex items-center mb-6">
                        <div class="bg-gradient-to-r from-green-600 to-emerald-600 p-3 rounded-full mr-4">
                            <i class="fa-solid fa-bullseye text-white text-2xl"></i>
                        </div>
                        <h3 class="text-3xl font-bold text-gray-900">MISI</h3>
                    </div>
                    
                    <p class="text-gray-700 mb-6 text-lg">
                        Visi berada diatas Misi sehingga Visi kemudian dijabarkan kedalam misi untuk dapat dilaksanakan, 
                        maka Misi Desa Mekarmukti adalah:
                    </p>
                </div>
                
                {{-- Mission List --}}
                <div class="space-y-3">
                    @php
                        $misiList = [
                            ['Pelayanan administrasi desa berbasis digital.', 'fa-laptop', 'blue'],
                            ['Perbaikan sarana infrastruktur.', 'fa-road', 'green'],
                            ['Membangun tempat pengolahan sampah terpadu.', 'fa-recycle', 'emerald'],
                            ['Bantuan modal bergulir bagi UMKM.', 'fa-coins', 'yellow'],
                            ['Subsidi dana kesehatan untuk dhuafa.', 'fa-heart', 'red'],
                            ['Kadedeh tahunan bagi guru ngaji, anak yatim & dhuafa.', 'fa-hands-helping', 'purple'],
                            ['Alokasi dana pertanian & perikanan.', 'fa-seedling', 'green'],
                            ['Beasiswa pelajar berprestasi & dhuafa.', 'fa-graduation-cap', 'indigo'],
                            ['Stadion mini / lapang desa.', 'fa-futbol', 'orange'],
                            ['Membangun sanggar seni & budaya.', 'fa-palette', 'pink']
                        ];
                    @endphp
                    
                    @foreach($misiList as $index => $misi)
                        <div class="bg-white rounded-xl shadow-lg border border-{{ $misi[2] }}-100 p-4 hover:shadow-xl hover:scale-[1.02] transition-all duration-300 group">
                            <div class="flex items-center space-x-4">
                                <div class="bg-gradient-to-r from-{{ $misi[2] }}-500 to-{{ $misi[2] }}-600 p-3 rounded-full flex-shrink-0">
                                    <i class="fa-solid {{ $misi[1] }} text-white"></i>
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center space-x-3">
                                        <span class="bg-{{ $misi[2] }}-100 text-{{ $misi[2] }}-800 px-3 py-1 rounded-full text-sm font-bold">
                                            {{ $index + 1 }}
                                        </span>
                                        <p class="text-gray-800 font-medium leading-relaxed">{{ $misi[0] }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            
            {{-- Mission Image --}}
            <div class="relative group">
                <div class="absolute inset-0 bg-gradient-to-r from-green-600 to-emerald-600 rounded-2xl opacity-20 group-hover:opacity-30 transition-opacity"></div>
                <img src="assets/img/pamong3.jpg" class="w-full h-96 object-cover rounded-2xl shadow-xl group-hover:scale-[1.02] transition-transform duration-500" alt="Misi Desa">
                <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent rounded-2xl"></div>
                <div class="absolute bottom-6 left-6 text-white">
                    <h3 class="text-2xl font-bold mb-2">10 Program Prioritas</h3>
                    <p class="text-white/80">Misi Pembangunan Desa</p>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@section('script')
<script>
    // Add some interactive animations
    document.addEventListener('DOMContentLoaded', function() {
        // Smooth scroll animations for cards
        const cards = document.querySelectorAll('.group');
        cards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-4px)';
            });
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });
    });
</script>
@endsection
