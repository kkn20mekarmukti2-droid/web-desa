@extends('layout.app')
@section('content')
<main class="mt-20 w-full mb-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Hero Section with Breadcrumb --}}
        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-orange-600 via-red-600 to-pink-800 shadow-2xl mb-8">
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
                                    <span class="text-white font-medium">Struktur Pemerintahan</span>
                                </div>
                            </li>
                        </ol>
                    </nav>
                </div>
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-4 leading-tight">
                    Struktur Pemerintahan
                </h1>
                <p class="text-xl text-white/90 max-w-3xl mx-auto leading-relaxed">
                    Struktur organisasi dan aparatur pemerintahan Desa Mekarmukti yang melayani masyarakat dengan profesional
                </p>
            </div>
            <!-- Animated background elements -->
            <div class="absolute top-10 left-10 w-20 h-20 bg-white/10 rounded-full animate-pulse"></div>
            <div class="absolute bottom-10 right-10 w-16 h-16 bg-white/5 rounded-full animate-bounce"></div>
            <div class="absolute top-1/3 right-1/3 w-12 h-12 bg-white/5 rounded-full animate-ping"></div>
        </div>

        {{-- Summary Section --}}
        <div class="grid lg:grid-cols-2 gap-8 mb-12">
            {{-- Overview --}}
            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
                <div class="bg-gradient-to-r from-orange-500 to-red-600 px-8 py-6">
                    <h2 class="text-2xl font-bold text-white flex items-center">
                        <i class="fa-solid fa-users-gear mr-3"></i>
                        Aparatur Pemerintahan
                    </h2>
                    <p class="text-orange-100 mt-2">Komposisi perangkat desa</p>
                </div>
                
                <div class="p-8">
                    <p class="text-gray-600 leading-relaxed mb-6">
                        Jumlah perangkat Desa Mekarmukti Tahun 2021 sebanyak <strong class="text-orange-600 text-xl">11 orang</strong> terdiri dari:
                    </p>
                    
                    <div class="grid grid-cols-1 gap-4">
                        @php
                            $struktur = [
                                ['Kepala Desa', '1 Orang', 'crown', 'orange'],
                                ['Sekretaris Desa', '1 Orang', 'user-tie', 'blue'],
                                ['Kepala Urusan', '3 Orang', 'users', 'green'],
                                ['Kepala Kasi', '3 Orang', 'user-friends', 'purple'],
                                ['Kepala Dusun', '4 Orang', 'map-location-dot', 'red']
                            ];
                        @endphp
                        
                        @foreach($struktur as $item)
                            <div class="flex items-center justify-between p-4 bg-gradient-to-r from-{{ $item[3] }}-50 to-{{ $item[3] }}-100 rounded-xl border border-{{ $item[3] }}-200">
                                <div class="flex items-center space-x-3">
                                    <div class="bg-gradient-to-r from-{{ $item[3] }}-500 to-{{ $item[3] }}-600 p-2 rounded-full">
                                        <i class="fa-solid fa-{{ $item[2] }} text-white"></i>
                                    </div>
                                    <span class="font-semibold text-gray-900">{{ $item[0] }}</span>
                                </div>
                                <span class="bg-{{ $item[3] }}-500 text-white px-3 py-1 rounded-full font-bold text-sm">
                                    {{ $item[1] }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            
            {{-- Vision Overview --}}
            <div class="space-y-6">
                <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-purple-500 to-indigo-600 px-8 py-6">
                        <h2 class="text-2xl font-bold text-white flex items-center">
                            <i class="fa-solid fa-bullseye mr-3"></i>
                            Visi & Misi Ringkas
                        </h2>
                        <p class="text-purple-100 mt-2">MOTEKAR dalam aksi</p>
                    </div>
                    
                    <div class="p-8">
                        <div class="text-center mb-6">
                            <h3 class="text-xl font-bold text-gray-900 mb-3">MOTEKAR</h3>
                            <p class="text-gray-600 text-sm leading-relaxed mb-4">
                                Gotong Royong Membangun Desa Mekarmukti yang:
                            </p>
                            
                            <div class="grid grid-cols-1 gap-2">
                                @php
                                    $motekar = [
                                        ['M', 'Maju', 'rocket', 'blue'],
                                        ['O', 'Profesional', 'star', 'green'],
                                        ['T', 'Tangguh', 'shield-alt', 'orange'],
                                        ['E', 'Kreatif', 'lightbulb', 'purple'],
                                        ['K', 'Religius', 'heart', 'red']
                                    ];
                                @endphp
                                
                                @foreach($motekar as $item)
                                    <div class="flex items-center space-x-3 p-2 bg-{{ $item[3] }}-50 rounded-lg">
                                        <div class="bg-{{ $item[3] }}-500 text-white w-8 h-8 rounded-full flex items-center justify-center font-bold text-sm">
                                            {{ $item[0] }}
                                        </div>
                                        <span class="font-medium text-gray-800">{{ $item[1] }}</span>
                                        <i class="fa-solid fa-{{ $item[2] }} text-{{ $item[3] }}-500 ml-auto"></i>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- Organizational Structure --}}
        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-indigo-500 to-purple-600 px-8 py-6">
                <h2 class="text-3xl font-bold text-white flex items-center">
                    <i class="fa-solid fa-sitemap mr-4"></i>
                    Struktur Organisasi
                </h2>
                <p class="text-indigo-100 mt-2">Aparatur Desa Mekarmukti</p>
            </div>
            
            <div class="p-8">
                {{-- Head of Village --}}
                <div class="flex justify-center mb-8">
                    <div class="bg-gradient-to-br from-yellow-400 to-orange-500 rounded-2xl p-6 shadow-xl hover:shadow-2xl transition-all duration-300 hover:scale-105 max-w-md">
                        <div class="flex items-center space-x-4">
                            <img src="{{ asset('img/perangkat/kades.jpg') }}" alt="Kepala Desa" 
                                 class="w-20 h-20 object-cover rounded-full border-4 border-white shadow-lg">
                            <div class="text-center flex-1">
                                <h3 class="text-xl font-bold text-white mb-1">ANDRIAWAN BURHANUDIN, SH</h3>
                                <p class="text-yellow-100 font-semibold text-sm uppercase tracking-wide">Kepala Desa</p>
                                <div class="mt-2">
                                    <span class="bg-white text-orange-600 px-3 py-1 rounded-full text-xs font-bold">
                                        <i class="fa-solid fa-crown mr-1"></i> MOTEKAR
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                {{-- Secretary --}}
                <div class="flex justify-center mb-8">
                    <div class="bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl p-5 shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105 max-w-sm">
                        <div class="flex items-center space-x-3">
                            <img src="{{ asset('img/perangkat/sekdes.jpg') }}" alt="Sekretaris Desa" 
                                 class="w-16 h-16 object-cover rounded-full border-3 border-white shadow-md">
                            <div class="text-center flex-1">
                                <h4 class="text-lg font-bold text-white mb-1">YADI DAMANHURI, ST</h4>
                                <p class="text-blue-100 font-semibold text-sm">Sekretaris Desa</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                {{-- Staff Grid --}}
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @php
                        $staff = [
                            ['name' => 'LALAN JAELANI', 'position' => 'Kasi Kesejahteraan', 'image' => 'lalan.jpg', 'color' => 'green'],
                            ['name' => 'NENG IA FITRI A', 'position' => 'Kaur Keuangan', 'image' => 'nengia.jpg', 'color' => 'purple'],
                            ['name' => 'ASFHA NUGRAHA ARIFIN', 'position' => 'Kasi Pemerintahan', 'image' => 'asfa.jpg', 'color' => 'red'],
                            ['name' => 'WAHYU HADIAN, SE', 'position' => 'Kaur Perencanaan', 'image' => 'wahyu.jpg', 'color' => 'blue'],
                            ['name' => 'TISNA UNDAYA', 'position' => 'Kaur Tata Usaha', 'image' => 'uun.jpg', 'color' => 'indigo'],
                            ['name' => 'DEWI LISTIANI ABIDIN', 'position' => 'Kasi Pelayanan', 'image' => 'dewi.jpg', 'color' => 'pink'],
                            ['name' => 'ENCEP MULYANA', 'position' => 'Kadus I', 'image' => 'encep.jpg', 'color' => 'orange'],
                            ['name' => 'AGUS RIDWAN', 'position' => 'Kadus II', 'image' => 'ridwan.jpg', 'color' => 'emerald'],
                            ['name' => 'FEBRI HARDIANSYAH', 'position' => 'Kadus III', 'image' => 'febri.jpg', 'color' => 'yellow'],
                            ['name' => 'PERI', 'position' => 'Kadus IV', 'image' => 'peri.jpg', 'color' => 'teal']
                        ];
                    @endphp
                    
                    @foreach($staff as $person)
                        <div class="group bg-white rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 border border-{{ $person['color'] }}-100 hover:border-{{ $person['color'] }}-300 hover:-translate-y-2 overflow-hidden">
                            <div class="relative">
                                <img src="{{ asset('img/perangkat/' . $person['image']) }}" 
                                     alt="{{ $person['name'] }}" 
                                     class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-500">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                <div class="absolute top-3 right-3">
                                    <div class="bg-{{ $person['color'] }}-500 p-2 rounded-full shadow-lg">
                                        <i class="fa-solid fa-user text-white text-sm"></i>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="p-4 text-center">
                                <h4 class="font-bold text-gray-900 text-sm mb-2 group-hover:text-{{ $person['color'] }}-600 transition-colors">
                                    {{ $person['name'] }}
                                </h4>
                                <p class="text-{{ $person['color'] }}-600 font-semibold text-xs uppercase tracking-wide">
                                    {{ $person['position'] }}
                                </p>
                                <div class="mt-3">
                                    <div class="bg-{{ $person['color'] }}-100 text-{{ $person['color'] }}-700 px-3 py-1 rounded-full text-xs font-medium inline-block">
                                        <i class="fa-solid fa-badge-check mr-1"></i>
                                        Aktif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                {{-- Statistics --}}
                <div class="mt-12 grid grid-cols-1 md:grid-cols-4 gap-6">
                    @php
                        $stats = [
                            ['Total Aparatur', '11', 'users', 'blue'],
                            ['Kepala Dusun', '4', 'map-location-dot', 'green'],
                            ['Staff Administrasi', '6', 'file-alt', 'purple'],
                            ['Tahun Pelayanan', '2021-2027', 'calendar', 'orange']
                        ];
                    @endphp
                    
                    @foreach($stats as $stat)
                        <div class="bg-gradient-to-br from-{{ $stat[3] }}-50 to-{{ $stat[3] }}-100 rounded-xl p-6 text-center border border-{{ $stat[3] }}-200">
                            <div class="bg-{{ $stat[3] }}-500 p-3 rounded-full w-fit mx-auto mb-3">
                                <i class="fa-solid fa-{{ $stat[2] }} text-white text-xl"></i>
                            </div>
                            <h3 class="text-2xl font-bold text-{{ $stat[3] }}-700 mb-1">{{ $stat[1] }}</h3>
                            <p class="text-{{ $stat[3] }}-600 font-medium text-sm">{{ $stat[0] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@section('script')
<script>
    // Add interactive hover effects
    document.addEventListener('DOMContentLoaded', function() {
        // Card hover animations
        const staffCards = document.querySelectorAll('.group');
        staffCards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.boxShadow = '0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04)';
            });
            card.addEventListener('mouseleave', function() {
                this.style.boxShadow = '';
            });
        });
        
        // Statistics counter animation
        const stats = document.querySelectorAll('.text-2xl.font-bold');
        const observerOptions = {
            threshold: 0.7,
            rootMargin: '0px 0px -100px 0px'
        };
        
        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.animation = 'fadeInUp 0.6s ease-out forwards';
                }
            });
        }, observerOptions);
        
        stats.forEach(stat => observer.observe(stat));
    });
</script>

<style>
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    /* Custom hover effects */
    .group:hover .group-hover\\:scale-110 {
        transform: scale(1.1);
    }
    
    .group:hover .group-hover\\:opacity-100 {
        opacity: 1;
    }
</style>
@endsection
