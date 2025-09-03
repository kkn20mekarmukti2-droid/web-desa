@extends('layout.app')
@section('judul', isset($_GET['kategori']) ? $_GET['kategori'] . ' Desa Mekarmuti' : 'Berita Desa')
@section('content')
    <main class="mt-20 w-full mb-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Hero Section with Breadcrumb -->
            <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-blue-600 via-purple-600 to-indigo-800 shadow-2xl mb-8">
                <div class="absolute inset-0 bg-black/20"></div>
                <div class="relative px-8 py-16 text-center">
                    <div class="mb-4">
                        <nav class="flex justify-center" aria-label="Breadcrumb">
                            <ol class="inline-flex items-center space-x-1 md:space-x-3 text-white/80">
                                <li class="inline-flex items-center">
                                    <i class="fa-solid fa-house text-white/60"></i>
                                </li>
                                <li>
                                    <div class="flex items-center">
                                        <i class="fa-solid fa-chevron-right text-white/60 mx-2"></i>
                                        <span class="text-white font-medium">Berita</span>
                                    </div>
                                </li>
                            </ol>
                        </nav>
                    </div>
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-4 leading-tight">
                        {{ isset($_GET['kategori']) ? 'Kategori: ' . $_GET['kategori'] : (isset($_GET['search']) ? 'Pencarian: "' . $_GET['search'] . '"' : 'Berita Terbaru') }}
                    </h1>
                    <p class="text-xl text-white/90 max-w-2xl mx-auto leading-relaxed">
                        {{ isset($_GET['kategori']) ? 'Artikel dalam kategori ' . $_GET['kategori'] : (isset($_GET['search']) ? 'Hasil pencarian untuk "' . $_GET['search'] . '"' : 'Temukan berbagai informasi terkini dan artikel menarik dari Desa Mekarmuti') }}
                    </p>
                </div>
                <!-- Animated background elements -->
                <div class="absolute top-10 left-10 w-20 h-20 bg-white/10 rounded-full animate-pulse"></div>
                <div class="absolute bottom-10 right-10 w-16 h-16 bg-white/5 rounded-full animate-bounce"></div>
                <div class="absolute top-1/2 left-1/4 w-12 h-12 bg-white/5 rounded-full animate-ping"></div>
            </div>

            <!-- Subscribe Section with modern card design -->
            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 mb-8 p-6 md:p-8">
                <div class="flex flex-col md:flex-row items-center justify-between space-y-4 md:space-y-0">
                    <div class="flex items-center space-x-4">
                        <div class="bg-gradient-to-r from-blue-500 to-purple-600 p-3 rounded-full">
                            <i class="fa-solid fa-bell text-white text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-900">Berlangganan Newsletter</h3>
                            <p class="text-gray-600">Dapatkan notifikasi artikel terbaru langsung ke email Anda</p>
                        </div>
                    </div>
                    <button id="subscribeButton"
                        class="bg-gradient-to-r from-blue-600 to-purple-600 text-white font-bold py-3 px-8 rounded-full shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-1 hover:scale-105 flex items-center space-x-2 group">
                        <i class="fa-solid fa-paper-plane group-hover:animate-bounce transition-all"></i>
                        <span>Berlangganan</span>
                    </button>
                </div>
            </div>
            <!-- Mobile Search Bar -->
            <div class="md:hidden mb-6">
                <form action="{{ route('berita') }}" method="get"
                    class="bg-white rounded-2xl shadow-lg border border-gray-100 p-4">
                    <div class="flex items-center space-x-3">
                        <div class="bg-gradient-to-r from-blue-500 to-purple-600 p-3 rounded-full">
                            <i class="fa-solid fa-magnifying-glass text-white"></i>
                        </div>
                        <input type="text" name="search" placeholder="Cari berita..." value="{{ request('search') }}"
                            class="flex-grow p-3 border-none focus:outline-none text-gray-700 placeholder-gray-400">
                        <button type="submit" 
                            class="bg-gradient-to-r from-blue-600 to-purple-600 text-white px-6 py-3 rounded-full font-medium hover:shadow-lg transition-all duration-300">
                            Cari
                        </button>
                    </div>
                </form>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                <!-- Main Content Area -->
                <div class="lg:col-span-3 space-y-6">
                    <!-- Articles Grid -->
                    <div class="grid gap-6">
                        @foreach ($artikel as $index => $i)
                            @php
                                $readingTime = max(1, ceil(str_word_count(strip_tags($i->header . ' ' . $i->deskripsi)) / 200));
                            @endphp
                            
                            <!-- Premium Article Card -->
                            <article class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 overflow-hidden border border-gray-100">
                                <div class="grid md:grid-cols-5 h-full">
                                    <!-- Image Section -->
                                    <div class="md:col-span-2 relative overflow-hidden">
                                        <div class="aspect-[4/3] md:h-full relative">
                                            @if (strpos($i->sampul, 'youtube'))
                                                <div class="absolute inset-0 bg-gradient-to-br from-red-500 via-red-600 to-red-700 flex items-center justify-center">
                                                    <div class="text-center text-white">
                                                        <i class="fab fa-youtube text-6xl mb-4 opacity-90"></i>
                                                        <p class="text-lg font-medium">Video YouTube</p>
                                                    </div>
                                                </div>
                                            @elseif($i->sampul && file_exists(public_path('img/' . $i->sampul)))
                                                <img src="{{ asset('img/' . $i->sampul) }}" 
                                                     alt="{{ $i->judul }}" 
                                                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                                            @else
                                                <div class="w-full h-full bg-gradient-to-br from-blue-500 via-purple-500 to-indigo-600 flex items-center justify-center">
                                                    <div class="text-center text-white">
                                                        <i class="bi bi-newspaper text-5xl mb-4 opacity-90"></i>
                                                        <p class="text-lg font-medium">Artikel Berita</p>
                                                    </div>
                                                </div>
                                            @endif
                                            
                                            <!-- Overlay gradient -->
                                            <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                            
                                            <!-- Category Badge -->
                                            @if ($i->kategori != '')
                                                <div class="absolute top-4 left-4">
                                                    <span class="bg-gradient-to-r from-blue-600 to-purple-600 text-white px-3 py-1 rounded-full text-sm font-medium shadow-lg">
                                                        <i class="fa-solid fa-tag mr-1"></i>
                                                        {{ $i->getKategori->judul }}
                                                    </span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <!-- Content Section -->
                                    <div class="md:col-span-3 p-6 md:p-8 flex flex-col justify-between">
                                        <div class="space-y-4">
                                            <!-- Article Title -->
                                            <h2 class="text-2xl lg:text-3xl font-bold text-gray-900 group-hover:text-blue-600 transition-colors duration-300 leading-tight">
                                                <a href="{{ route('detailartikel', ['tanggal' => $i->created_at->format('Y-m-d'), 'judul' => Str::slug($i->judul)]) }}"
                                                   class="hover:underline">
                                                    {{ $i->judul }}
                                                </a>
                                            </h2>
                                            
                                            <!-- Article Excerpt -->
                                            <p class="text-gray-600 text-lg leading-relaxed">
                                                {{ Str::limit($i->header, 150) }}
                                                <a href="{{ route('detailartikel', ['tanggal' => $i->created_at->format('Y-m-d'), 'judul' => Str::slug($i->judul)]) }}"
                                                   class="text-blue-600 hover:text-purple-600 font-medium hover:underline transition-colors duration-300">
                                                    Baca selengkapnya
                                                </a>
                                            </p>
                                        </div>
                                        
                                        <!-- Article Meta -->
                                        <div class="pt-4 border-t border-gray-100">
                                            <div class="flex items-center justify-between">
                                                <div class="flex items-center space-x-4 text-sm text-gray-500">
                                                    <div class="flex items-center space-x-2">
                                                        <i class="fa-solid fa-user text-blue-500"></i>
                                                        <span class="font-medium">{{ $i->creator->name }}</span>
                                                    </div>
                                                    <div class="flex items-center space-x-2">
                                                        <i class="fa-solid fa-calendar-days text-green-500"></i>
                                                        <span>{{ $i->created_at->format('d M Y') }}</span>
                                                    </div>
                                                    <div class="flex items-center space-x-2">
                                                        <i class="fa-solid fa-clock text-orange-500"></i>
                                                        <span>{{ $readingTime }} menit</span>
                                                    </div>
                                                </div>
                                                
                                                <!-- Read More Button -->
                                                <a href="{{ route('detailartikel', ['tanggal' => $i->created_at->format('Y-m-d'), 'judul' => Str::slug($i->judul)]) }}"
                                                   class="bg-gradient-to-r from-blue-600 to-purple-600 text-white px-6 py-2 rounded-full font-medium hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300 group-hover:scale-105">
                                                    <i class="fa-solid fa-arrow-right mr-2"></i>
                                                    Baca
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>
                    
                    <!-- Pagination with modern styling -->
                    <div class="flex justify-center mt-12">
                        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                            {{ $artikel->links('paginate') }}
                        </div>
                    </div>
                </div>
                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Desktop Search -->
                    <div class="hidden md:block">
                        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                            <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                                <i class="fa-solid fa-magnifying-glass text-blue-600 mr-3"></i>
                                Pencarian
                            </h3>
                            <form action="{{ route('berita') }}" method="get">
                                <div class="relative">
                                    <input type="text" name="search" placeholder="Cari berita..." value="{{ request('search') }}"
                                        class="w-full p-4 pr-12 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                                    <button type="submit" 
                                        class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-gradient-to-r from-blue-600 to-purple-600 text-white p-2 rounded-lg hover:shadow-lg transition-all duration-300">
                                        <i class="fa-solid fa-magnifying-glass"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Categories -->
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                            <i class="fa-solid fa-tags text-purple-600 mr-3"></i>
                            Kategori
                        </h3>
                        <div class="space-y-2">
                            @foreach ($listkategori as $k)
                                <a href="{{ route('berita', ['kategori' => $k->judul]) }}"
                                   class="group flex items-center justify-between p-3 rounded-xl hover:bg-gradient-to-r hover:from-blue-50 hover:to-purple-50 transition-all duration-300">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-2 h-2 bg-gradient-to-r from-blue-500 to-purple-500 rounded-full group-hover:scale-150 transition-transform"></div>
                                        <span class="text-gray-700 group-hover:text-gray-900 font-medium">{{ $k->judul }}</span>
                                    </div>
                                    <span class="bg-gradient-to-r from-blue-100 to-purple-100 text-blue-700 px-2 py-1 rounded-full text-sm font-medium">
                                        {{ $k->artikel_count }}
                                    </span>
                                </a>
                            @endforeach
                        </div>
                    </div>

                    <!-- Recommended Articles -->
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                        <div class="mb-6">
                            <h3 class="text-xl font-bold text-gray-900 flex items-center">
                                <i class="fa-solid fa-star text-yellow-500 mr-3"></i>
                                Artikel Pilihan
                            </h3>
                            <div class="h-1 bg-gradient-to-r from-yellow-400 to-orange-500 rounded-full mt-2 w-1/3"></div>
                        </div>
                        
                        <div class="space-y-4">
                            @foreach ($rekomendasi as $i)
                                <article class="group">
                                    <a href="{{ route('detailartikel', ['tanggal' => $i->created_at->format('Y-m-d'), 'judul' => Str::slug($i->judul)]) }}"
                                       class="block">
                                        <div class="flex space-x-4 p-3 rounded-xl hover:bg-gradient-to-r hover:from-gray-50 hover:to-blue-50 transition-all duration-300">
                                            <!-- Thumbnail -->
                                            <div class="flex-shrink-0 w-20 h-16 relative overflow-hidden rounded-lg">
                                                @if (strpos($i->sampul, 'youtube'))
                                                    @php
                                                        $youtubeUrl = $i->sampul;
                                                        preg_match('/embed\/([^\?]*)/', $youtubeUrl, $matches);
                                                        $thumbnail = $matches[1] ?? null;
                                                    @endphp
                                                    <img src="https://img.youtube.com/vi/{{ $thumbnail }}/hqdefault.jpg"
                                                         alt="{{ $i->judul }}" 
                                                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                                                    <div class="absolute inset-0 bg-red-500/20 flex items-center justify-center">
                                                        <i class="fab fa-youtube text-white text-lg"></i>
                                                    </div>
                                                @elseif($i->sampul && file_exists(public_path('img/' . $i->sampul)))
                                                    <img src="{{ asset('img/' . $i->sampul) }}" 
                                                         alt="{{ $i->judul }}" 
                                                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                                                @else
                                                    <div class="w-full h-full bg-gradient-to-br from-gray-200 to-gray-300 flex items-center justify-center">
                                                        <i class="bi bi-image text-gray-400 text-xl"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            
                                            <!-- Content -->
                                            <div class="flex-1 min-w-0">
                                                <h4 class="text-sm font-semibold text-gray-900 group-hover:text-blue-600 transition-colors duration-300 line-clamp-2 leading-snug">
                                                    {{ Str::limit($i->judul, 60, '...') }}
                                                </h4>
                                                <div class="mt-2 flex items-center space-x-2 text-xs text-gray-500">
                                                    <i class="fa-solid fa-calendar-days text-green-500"></i>
                                                    <span>{{ $i->created_at->format('d M Y') }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </article>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <style>
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
@endsection
