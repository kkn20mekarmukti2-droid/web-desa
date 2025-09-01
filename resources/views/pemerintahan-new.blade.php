@extends('layout.app')
@section('judul', 'Struktur Pemerintahan Desa')
@section('content')

<!-- Hero Section -->
<div class="relative bg-gradient-to-r from-blue-600 to-blue-800 py-20">
    <div class="absolute inset-0 bg-black opacity-20"></div>
    <div class="relative container mx-auto px-4 text-center text-white">
        <h1 class="text-4xl md:text-5xl font-bold mb-4">🏛️ Pemerintahan Desa Mekarmukti</h1>
        <p class="text-xl md:text-2xl opacity-90">Struktur Organisasi & Aparatur Desa</p>
        <nav class="flex justify-center mt-6" aria-label="Breadcrumb">
            <ol class="flex items-center space-x-2 text-sm">
                <li><a href="{{ route('home') }}" class="hover:text-blue-200 transition-colors">🏠 Beranda</a></li>
                <li><span class="text-blue-200 mx-2">›</span></li>
                <li class="text-blue-200">Pemerintahan</li>
            </ol>
        </nav>
    </div>
</div>

<div class="py-12">
    <!-- Visi Misi Section -->
    <section class="mb-16">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-6">🎯 Visi & Misi</h2>
                <p class="text-gray-600 leading-relaxed">
                    Berdasarkan kondisi saat ini dan tantangan yang akan dihadapi dalam enam tahun mendatang, 
                    berikut adalah visi dan misi Desa Mekarmukti untuk periode 2021-2027.
                </p>
            </div>

            <div class="grid md:grid-cols-2 gap-12 items-center">
                <!-- Visi -->
                <div class="bg-white rounded-xl shadow-lg p-8 border border-gray-100">
                    <div class="text-center mb-6">
                        <div class="inline-flex items-center justify-center w-16 h-16 bg-blue-100 rounded-full mb-4">
                            <span class="text-2xl">🌟</span>
                        </div>
                        <h3 class="text-2xl font-bold text-blue-600">VISI</h3>
                        <div class="mt-4">
                            <p class="text-3xl font-bold text-gray-800 tracking-wider">MOTEKAR</p>
                            <p class="text-sm text-gray-600 italic mt-2">Visi Kepala Desa Mekarmukti 2021 – 2027</p>
                        </div>
                    </div>
                    <ul class="space-y-3">
                        <li class="flex items-center text-gray-700">
                            <span class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 font-bold text-sm mr-3">M</span>
                            <span class="font-semibold">Maju</span>
                        </li>
                        <li class="flex items-center text-gray-700">
                            <span class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 font-bold text-sm mr-3">O</span>
                            <span class="font-semibold">Profesional</span>
                        </li>
                        <li class="flex items-center text-gray-700">
                            <span class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 font-bold text-sm mr-3">T</span>
                            <span class="font-semibold">Tangguh</span>
                        </li>
                        <li class="flex items-center text-gray-700">
                            <span class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 font-bold text-sm mr-3">E</span>
                            <span class="font-semibold">Kreatif</span>
                        </li>
                        <li class="flex items-center text-gray-700">
                            <span class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 font-bold text-sm mr-3">K</span>
                            <span class="font-semibold">Religius</span>
                        </li>
                    </ul>
                </div>

                <!-- Misi -->
                <div class="bg-white rounded-xl shadow-lg p-8 border border-gray-100">
                    <div class="text-center mb-6">
                        <div class="inline-flex items-center justify-center w-16 h-16 bg-green-100 rounded-full mb-4">
                            <span class="text-2xl">🎯</span>
                        </div>
                        <h3 class="text-2xl font-bold text-green-600">MISI</h3>
                        <p class="text-sm text-gray-600 italic mt-2">Program Kerja Desa Mekarmukti</p>
                    </div>
                    <ul class="space-y-2 text-sm text-gray-700">
                        <li class="flex items-start">
                            <span class="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center text-green-600 text-xs font-bold mt-0.5 mr-3 flex-shrink-0">1</span>
                            <span>Pelayanan administrasi desa berbasis digital dan transparansi anggaran</span>
                        </li>
                        <li class="flex items-start">
                            <span class="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center text-green-600 text-xs font-bold mt-0.5 mr-3 flex-shrink-0">2</span>
                            <span>Perbaikan sarana infrastruktur</span>
                        </li>
                        <li class="flex items-start">
                            <span class="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center text-green-600 text-xs font-bold mt-0.5 mr-3 flex-shrink-0">3</span>
                            <span>Bangun tempat pengolahan sampah terpadu / TPST 3R</span>
                        </li>
                        <li class="flex items-start">
                            <span class="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center text-green-600 text-xs font-bold mt-0.5 mr-3 flex-shrink-0">4</span>
                            <span>Bantuan modal bergulir bagi UMKM</span>
                        </li>
                        <li class="flex items-start">
                            <span class="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center text-green-600 text-xs font-bold mt-0.5 mr-3 flex-shrink-0">5</span>
                            <span>Subsidi dana kesehatan untuk dhuafa</span>
                        </li>
                        <li class="flex items-start">
                            <span class="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center text-green-600 text-xs font-bold mt-0.5 mr-3 flex-shrink-0">6</span>
                            <span>Kadedeh tahunan bagi guru ngaji, anak yatim & dhuafa</span>
                        </li>
                        <li class="flex items-start">
                            <span class="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center text-green-600 text-xs font-bold mt-0.5 mr-3 flex-shrink-0">7</span>
                            <span>Alokasi dana pertanian & perikanan</span>
                        </li>
                        <li class="flex items-start">
                            <span class="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center text-green-600 text-xs font-bold mt-0.5 mr-3 flex-shrink-0">8</span>
                            <span>Beasiswa pelajar berprestasi & dhuafa</span>
                        </li>
                        <li class="flex items-start">
                            <span class="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center text-green-600 text-xs font-bold mt-0.5 mr-3 flex-shrink-0">9</span>
                            <span>Stadion mini / lapang desa</span>
                        </li>
                        <li class="flex items-start">
                            <span class="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center text-green-600 text-xs font-bold mt-0.5 mr-3 flex-shrink-0">10</span>
                            <span>Membangun sanggar seni & budaya</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Aparatur Stats -->
    <section class="mb-16 bg-gray-50 py-12">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto">
                <h2 class="text-3xl font-bold text-center text-gray-800 mb-8">📊 Aparatur Pemerintahan</h2>
                <p class="text-center text-gray-600 mb-8">Jumlah perangkat Desa Mekarmukti sebanyak 11 orang terdiri dari:</p>
                
                <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                    <div class="bg-white rounded-lg p-6 text-center shadow-md hover:shadow-lg transition-shadow">
                        <div class="text-3xl text-blue-600 font-bold">1</div>
                        <div class="text-sm text-gray-600 mt-1">Kepala Desa</div>
                    </div>
                    <div class="bg-white rounded-lg p-6 text-center shadow-md hover:shadow-lg transition-shadow">
                        <div class="text-3xl text-green-600 font-bold">1</div>
                        <div class="text-sm text-gray-600 mt-1">Sekretaris Desa</div>
                    </div>
                    <div class="bg-white rounded-lg p-6 text-center shadow-md hover:shadow-lg transition-shadow">
                        <div class="text-3xl text-purple-600 font-bold">3</div>
                        <div class="text-sm text-gray-600 mt-1">Kepala Urusan</div>
                    </div>
                    <div class="bg-white rounded-lg p-6 text-center shadow-md hover:shadow-lg transition-shadow">
                        <div class="text-3xl text-orange-600 font-bold">3</div>
                        <div class="text-sm text-gray-600 mt-1">Kepala Seksi</div>
                    </div>
                    <div class="bg-white rounded-lg p-6 text-center shadow-md hover:shadow-lg transition-shadow col-span-2 md:col-span-1">
                        <div class="text-3xl text-red-600 font-bold">4</div>
                        <div class="text-sm text-gray-600 mt-1">Kepala Dusun</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Struktur Organisasi -->
    <section class="mb-16">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl md:text-4xl font-bold text-center text-gray-800 mb-12">👥 Struktur Organisasi</h2>
            
            <!-- Organizational Chart -->
            <div class="max-w-7xl mx-auto">
                
                <!-- Kepala Desa (Top Level) -->
                <div class="flex justify-center mb-12">
                    <div class="org-card border-4 border-yellow-400">
                        <div class="w-24 h-24 mx-auto mb-4 rounded-full overflow-hidden bg-gray-200">
                            @if(isset($grouped['kepala_desa']) && $grouped['kepala_desa']->foto && file_exists(public_path($grouped['kepala_desa']->foto)))
                            <img src="{{ asset($grouped['kepala_desa']->foto) }}" alt="Kepala Desa" class="w-full h-full object-cover">
                            @else
                            <div class="w-full h-full flex items-center justify-center text-gray-400">
                                <i class="fas fa-user text-2xl"></i>
                            </div>
                            @endif
                        </div>
                        <h3 class="font-bold text-lg text-center">
                            {{ $grouped['kepala_desa']->nama ?? 'KEPALA DESA' }}
                        </h3>
                        <p class="text-sm text-center text-yellow-600 font-semibold mt-1">
                            {{ $grouped['kepala_desa']->jabatan ?? 'KEPALA DESA' }}
                        </p>
                    </div>
                </div>

                <!-- Sekretaris Desa (Second Level) -->
                <div class="flex justify-center mb-12">
                    <div class="org-card border-4 border-green-400">
                        <div class="w-20 h-20 mx-auto mb-4 rounded-full overflow-hidden bg-gray-200">
                            @if(isset($grouped['sekretaris']) && $grouped['sekretaris']->foto && file_exists(public_path($grouped['sekretaris']->foto)))
                            <img src="{{ asset($grouped['sekretaris']->foto) }}" alt="Sekretaris Desa" class="w-full h-full object-cover">
                            @else
                            <div class="w-full h-full flex items-center justify-center text-gray-400">
                                <i class="fas fa-user text-xl"></i>
                            </div>
                            @endif
                        </div>
                        <h3 class="font-bold text-base text-center">
                            {{ $grouped['sekretaris']->nama ?? 'SEKRETARIS DESA' }}
                        </h3>
                        <p class="text-sm text-center text-green-600 font-semibold mt-1">
                            {{ $grouped['sekretaris']->jabatan ?? 'Sekretaris Desa' }}
                        </p>
                    </div>
                </div>

                <!-- Staff Level -->
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6 mb-8">
                    <!-- Kasi & Kaur -->
                    @php
                        $staffList = collect();
                        if(isset($grouped['kepala_urusan'])) $staffList = $staffList->merge($grouped['kepala_urusan']);
                        if(isset($grouped['kepala_seksi'])) $staffList = $staffList->merge($grouped['kepala_seksi']);
                        $staffList = $staffList->sortBy('urutan');
                    @endphp
                    
                    @foreach($staffList as $staff)
                    <div class="org-card-small border-2 border-blue-400">
                        <div class="w-16 h-16 mx-auto mb-3 rounded-full overflow-hidden bg-gray-200">
                            @if($staff->foto && file_exists(public_path($staff->foto)))
                            <img src="{{ asset($staff->foto) }}" alt="{{ $staff->nama }}" class="w-full h-full object-cover">
                            @else
                            <div class="w-full h-full flex items-center justify-center text-gray-400">
                                <i class="fas fa-user text-sm"></i>
                            </div>
                            @endif
                        </div>
                        <h4 class="font-semibold text-xs text-center">{{ $staff->nama }}</h4>
                        <p class="text-xs text-center text-blue-600 font-medium">{{ $staff->jabatan }}</p>
                    </div>
                    @endforeach
                </div>

                <!-- Kepala Dusun -->
                <div class="text-center mb-6">
                    <h3 class="text-xl font-bold text-gray-800">Kepala Dusun</h3>
                </div>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                    @if(isset($grouped['kepala_dusun']))
                    @foreach($grouped['kepala_dusun'] as $kadus)
                    <div class="org-card-small border-2 border-red-400">
                        <div class="w-16 h-16 mx-auto mb-3 rounded-full overflow-hidden bg-gray-200">
                            @if($kadus->foto && file_exists(public_path($kadus->foto)))
                            <img src="{{ asset($kadus->foto) }}" alt="{{ $kadus->nama }}" class="w-full h-full object-cover">
                            @else
                            <div class="w-full h-full flex items-center justify-center text-gray-400">
                                <i class="fas fa-user text-sm"></i>
                            </div>
                            @endif
                        </div>
                        <h4 class="font-semibold text-xs text-center">{{ $kadus->nama }}</h4>
                        <p class="text-xs text-center text-red-600 font-medium">{{ $kadus->jabatan }}</p>
                    </div>
                    @endforeach
                    @endif
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Custom Styles -->
<style>
.org-card {
    @apply bg-white rounded-xl shadow-lg p-6 transition-all duration-300 hover:shadow-xl hover:scale-105 max-w-xs;
}

.org-card-small {
    @apply bg-white rounded-lg shadow-md p-4 transition-all duration-300 hover:shadow-lg hover:scale-105;
}

.breadcrumb {
    background: transparent;
}

.breadcrumb li {
    display: inline-flex;
    align-items: center;
}
</style>

@endsection
