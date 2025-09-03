@extends('layout.app')

@section('content')
<main class="mt-20 w-full mb-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Hero Section with Breadcrumbs --}}
        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-emerald-600 via-teal-600 to-cyan-800 shadow-2xl mb-8">
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
                                    <span class="text-white font-medium">Sejarah Desa</span>
                                </div>
                            </li>
                        </ol>
                    </nav>
                </div>
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-4 leading-tight">
                    Sejarah Desa Mekarmukti
                </h1>
                <p class="text-xl text-white/90 max-w-3xl mx-auto leading-relaxed">
                    Perjalanan terbentuknya Desa Mekarmukti, dari pamekaran hingga menjadi desa yang maju dan berkembang di Kecamatan Cihampelas, Kabupaten Bandung Barat
                </p>
            </div>
            <!-- Animated background elements -->
            <div class="absolute top-10 left-10 w-20 h-20 bg-white/10 rounded-full animate-pulse"></div>
            <div class="absolute bottom-10 right-10 w-16 h-16 bg-white/5 rounded-full animate-bounce"></div>
            <div class="absolute top-1/2 left-1/4 w-12 h-12 bg-white/5 rounded-full animate-ping"></div>
        </div>

        {{-- Main Content --}}
        <div class="grid lg:grid-cols-3 gap-8">
            {{-- Story Content --}}
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
                    {{-- Timeline Header --}}
                    <div class="bg-gradient-to-r from-emerald-500 to-teal-600 px-8 py-6">
                        <h2 class="text-2xl font-bold text-white flex items-center">
                            <i class="fa-solid fa-book-open mr-3"></i>
                            Sejarah Singkat
                        </h2>
                        <p class="text-emerald-100 mt-2">Perjalanan pembentukan Desa Mekarmukti</p>
                    </div>
                    
                    {{-- Content --}}
                    <div class="p-8 space-y-6">
                        <div class="prose prose-lg max-w-none">
                            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl p-6 border-l-4 border-blue-500 mb-6">
                                <p class="text-gray-800 leading-relaxed mb-0">
                                    Desa Mekarmukti Kecamatan Cihampelas Kabupaten Bandung Barat adalah Desa Pamekaran dari Desa Cihampelas yang pada waktu itu masih ikut bergabung dengan Kecamatan Cililin, Kawedanaan Cililin, Kabupaten Bandung. Desa Mekarmukti berdiri pada tanggal <strong class="text-blue-700 font-bold text-xl">5 Mei 1982</strong>.
                                </p>
                            </div>

                            <div class="grid md:grid-cols-2 gap-6 my-8">
                                <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-xl p-6 border border-green-200">
                                    <div class="flex items-center mb-3">
                                        <i class="fa-solid fa-map text-green-600 text-2xl mr-3"></i>
                                        <h3 class="text-lg font-bold text-green-800">Luas Wilayah</h3>
                                    </div>
                                    <p class="text-3xl font-bold text-green-700">441.00</p>
                                    <p class="text-green-600 font-medium">Hektare</p>
                                </div>
                                
                                <div class="bg-gradient-to-br from-purple-50 to-indigo-50 rounded-xl p-6 border border-purple-200">
                                    <div class="flex items-center mb-3">
                                        <i class="fa-solid fa-home text-purple-600 text-2xl mr-3"></i>
                                        <h3 class="text-lg font-bold text-purple-800">Pembagian Wilayah</h3>
                                    </div>
                                    <div class="space-y-1">
                                        <p class="text-purple-700"><span class="font-bold">4</span> Dusun</p>
                                        <p class="text-purple-700"><span class="font-bold">11</span> RW</p>
                                        <p class="text-purple-700"><span class="font-bold">63</span> RT</p>
                                    </div>
                                </div>
                            </div>

                            <p class="text-gray-700 leading-relaxed mb-6 text-lg">
                                Desa Mekarmukti memiliki batas wilayah yang strategis:
                            </p>

                            <div class="grid grid-cols-2 gap-4 mb-8">
                                <div class="bg-orange-50 rounded-lg p-4 border-l-4 border-orange-500">
                                    <div class="flex items-center space-x-2">
                                        <i class="fa-solid fa-compass text-orange-600"></i>
                                        <span class="font-semibold text-orange-800">Utara:</span>
                                        <span class="text-gray-700">Desa Cihampelas</span>
                                    </div>
                                </div>
                                <div class="bg-red-50 rounded-lg p-4 border-l-4 border-red-500">
                                    <div class="flex items-center space-x-2">
                                        <i class="fa-solid fa-compass text-red-600"></i>
                                        <span class="font-semibold text-red-800">Selatan:</span>
                                        <span class="text-gray-700">Desa Karang Tanjung</span>
                                    </div>
                                </div>
                                <div class="bg-blue-50 rounded-lg p-4 border-l-4 border-blue-500">
                                    <div class="flex items-center space-x-2">
                                        <i class="fa-solid fa-compass text-blue-600"></i>
                                        <span class="font-semibold text-blue-800">Barat:</span>
                                        <span class="text-gray-700">Desa Mekarjaya</span>
                                    </div>
                                </div>
                                <div class="bg-green-50 rounded-lg p-4 border-l-4 border-green-500">
                                    <div class="flex items-center space-x-2">
                                        <i class="fa-solid fa-compass text-green-600"></i>
                                        <span class="font-semibold text-green-800">Timur:</span>
                                        <span class="text-gray-700">Desa Citapen</span>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-gradient-to-r from-amber-50 to-orange-50 rounded-xl p-6 border border-amber-200">
                                <div class="flex items-center mb-4">
                                    <i class="fa-solid fa-users text-amber-600 text-2xl mr-3"></i>
                                    <h3 class="text-lg font-bold text-amber-800">Mata Pencaharian</h3>
                                </div>
                                <p class="text-gray-700 leading-relaxed">
                                    Penduduk Desa Mekarmukti sebagian besar berprofesi sebagai <strong>petani</strong> dan <strong>nelayan ikan tambak</strong>. Selain itu, ada juga yang berprofesi sebagai buruh dan pekerjaan lainnya.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Leadership Timeline Sidebar --}}
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden sticky top-8">
                    <div class="bg-gradient-to-r from-indigo-500 to-purple-600 px-6 py-4">
                        <h3 class="text-xl font-bold text-white flex items-center">
                            <i class="fa-solid fa-crown mr-3"></i>
                            Kepemimpinan
                        </h3>
                        <p class="text-indigo-100 text-sm mt-1">Sejarah Kepala Desa</p>
                    </div>
                    
                    <div class="p-6 max-h-96 overflow-y-auto">
                        <div class="space-y-4">
                            @php
                                $leaders = [
                                    ['period' => '1982 - 1985', 'name' => 'H. Sofyan', 'color' => 'blue'],
                                    ['period' => '1985 - 1993', 'name' => 'H. Mulloh', 'color' => 'green'],
                                    ['period' => '1993 - 2002', 'name' => 'Udin Samsudin', 'color' => 'purple'],
                                    ['period' => '2002 - 2007', 'name' => 'Asep Supriatna', 'color' => 'orange'],
                                    ['period' => '2007 - 2019', 'name' => 'H. Deden Sutisna', 'color' => 'red', 'note' => '2 periode'],
                                    ['period' => '2019', 'name' => 'PJS Tatang Muslim', 'color' => 'gray', 'note' => 'Pelaksana tugas'],
                                    ['period' => '2019 - Sekarang', 'name' => 'Andriawan Burhanudin, SH', 'color' => 'emerald', 'current' => true]
                                ];
                            @endphp
                            
                            @foreach($leaders as $index => $leader)
                                <div class="relative flex items-center space-x-4 pb-4 
                                    @if(!$loop->last) border-l-2 border-{{ $leader['color'] }}-200 ml-3 @endif">
                                    
                                    <div class="absolute left-0 transform -translate-x-1/2 
                                        w-6 h-6 bg-{{ $leader['color'] }}-500 rounded-full border-4 border-white 
                                        shadow-lg flex items-center justify-center">
                                        @if(isset($leader['current']))
                                            <i class="fa-solid fa-star text-white text-xs"></i>
                                        @else
                                            <div class="w-2 h-2 bg-white rounded-full"></div>
                                        @endif
                                    </div>
                                    
                                    <div class="ml-4 flex-1">
                                        <div class="bg-gray-50 rounded-lg p-3 
                                            @if(isset($leader['current'])) ring-2 ring-emerald-200 bg-emerald-50 @endif">
                                            <p class="text-xs font-medium text-{{ $leader['color'] }}-600 mb-1">
                                                {{ $leader['period'] }}
                                            </p>
                                            <p class="font-semibold text-gray-900 text-sm">
                                                {{ $leader['name'] }}
                                            </p>
                                            @if(isset($leader['note']))
                                                <p class="text-xs text-gray-600 mt-1">({{ $leader['note'] }})</p>
                                            @endif
                                            @if(isset($leader['current']))
                                                <div class="flex items-center mt-2">
                                                    <span class="bg-emerald-500 text-white px-2 py-1 rounded-full text-xs font-medium">
                                                        MOTEKAR
                                                    </span>
                                                    <span class="text-xs text-emerald-600 ml-2">
                                                        Maju, Profesional, Tangguh, Kreatif, Religius
                                                    </span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@section('script')
<style>
    /* Custom scrollbar for timeline */
    .overflow-y-auto::-webkit-scrollbar {
        width: 4px;
    }
    .overflow-y-auto::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }
    .overflow-y-auto::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 10px;
    }
    .overflow-y-auto::-webkit-scrollbar-thumb:hover {
        background: #a8a8a8;
    }
</style>
@endsection
