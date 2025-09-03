@extends('layout.app')
@section('judul', 'Galeri Desa Mekarmukti')
@section('content')
<main class="mt-20 w-full mb-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Hero Section with Breadcrumb --}}
        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-cyan-600 via-blue-600 to-indigo-800 shadow-2xl mb-8">
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
                                    <span class="text-white font-medium">Galeri Desa</span>
                                </div>
                            </li>
                        </ol>
                    </nav>
                </div>
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-4 leading-tight">
                    Galeri Desa
                </h1>
                <p class="text-xl text-white/90 max-w-3xl mx-auto leading-relaxed">
                    Kumpulan dokumentasi kegiatan, momen berharga, dan kehidupan sehari-hari masyarakat Desa Mekarmukti
                </p>
            </div>
            <!-- Animated background elements -->
            <div class="absolute top-10 left-10 w-20 h-20 bg-white/10 rounded-full animate-pulse"></div>
            <div class="absolute bottom-10 right-10 w-16 h-16 bg-white/5 rounded-full animate-bounce"></div>
            <div class="absolute top-1/3 left-1/3 w-12 h-12 bg-white/5 rounded-full animate-ping"></div>
        </div>

        {{-- Gallery Statistics --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-8">
            @php
                $totalItems = $gallery->count();
                $photos = $gallery->where('type', 'foto')->count();
                $videos = $gallery->where('type', 'youtube')->count();
                $tiktoks = $gallery->where('type', 'tiktok')->count();
                
                $stats = [
                    ['Total Media', $totalItems, 'images', 'blue'],
                    ['Foto', $photos, 'camera', 'green'],
                    ['Video YouTube', $videos, 'video', 'red'],
                    ['TikTok', $tiktoks, 'mobile-alt', 'purple']
                ];
            @endphp
            
            @foreach($stats as $stat)
                <div class="bg-white rounded-2xl shadow-lg border border-{{ $stat[3] }}-100 p-6 text-center hover:shadow-xl transition-all duration-300 hover:scale-105">
                    <div class="bg-gradient-to-r from-{{ $stat[3] }}-500 to-{{ $stat[3] }}-600 p-4 rounded-full w-fit mx-auto mb-4">
                        <i class="fa-solid fa-{{ $stat[2] }} text-white text-2xl"></i>
                    </div>
                    <h3 class="text-3xl font-bold text-{{ $stat[3] }}-700 mb-2">{{ $stat[1] }}</h3>
                    <p class="text-{{ $stat[3] }}-600 font-medium">{{ $stat[0] }}</p>
                </div>
            @endforeach
        </div>

        {{-- Filter Tabs --}}
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 mb-8">
            <div class="flex flex-wrap justify-center gap-4">
                <button onclick="filterGallery('all')" class="filter-btn active bg-gradient-to-r from-blue-500 to-cyan-500 text-white px-6 py-3 rounded-full font-medium hover:shadow-lg transition-all duration-300 hover:scale-105">
                    <i class="fa-solid fa-th mr-2"></i>
                    Semua Media
                </button>
                <button onclick="filterGallery('foto')" class="filter-btn bg-gradient-to-r from-green-500 to-emerald-500 text-white px-6 py-3 rounded-full font-medium hover:shadow-lg transition-all duration-300 hover:scale-105">
                    <i class="fa-solid fa-camera mr-2"></i>
                    Foto
                </button>
                <button onclick="filterGallery('youtube')" class="filter-btn bg-gradient-to-r from-red-500 to-pink-500 text-white px-6 py-3 rounded-full font-medium hover:shadow-lg transition-all duration-300 hover:scale-105">
                    <i class="fab fa-youtube mr-2"></i>
                    YouTube
                </button>
                <button onclick="filterGallery('tiktok')" class="filter-btn bg-gradient-to-r from-purple-500 to-indigo-500 text-white px-6 py-3 rounded-full font-medium hover:shadow-lg transition-all duration-300 hover:scale-105">
                    <i class="fab fa-tiktok mr-2"></i>
                    TikTok
                </button>
            </div>
        </div>

        {{-- Gallery Grid --}}
        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-cyan-500 to-blue-600 px-8 py-6">
                <h2 class="text-3xl font-bold text-white flex items-center">
                    <i class="fa-solid fa-photo-film mr-4"></i>
                    Koleksi Media
                </h2>
                <p class="text-cyan-100 mt-2">Dokumentasi kegiatan dan momen Desa Mekarmukti</p>
            </div>
            
            <div class="p-8">
                <div class="masonry-grid columns-1 md:columns-2 lg:columns-3 xl:columns-4 gap-6 space-y-6">
                    @foreach ($gallery as $i)
                        @if ($i->type == 'foto')
                            <div class="gallery-item break-inside-avoid mb-6 foto" data-type="foto">
                                <div class="group relative overflow-hidden rounded-xl shadow-lg hover:shadow-2xl transition-all duration-500 bg-white border border-gray-100">
                                    <div class="relative overflow-hidden">
                                        <a data-fancybox="gallery" href="{{ asset('galeri/' . $i->url) }}" data-caption="{{ $i->judul }}">
                                            <img src="{{ asset('galeri/' . $i->url) }}" 
                                                 class="w-full object-cover group-hover:scale-110 transition-transform duration-500" 
                                                 alt="{{ $i->judul }}"
                                                 loading="lazy">
                                            <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                        </a>
                                        
                                        {{-- Photo Overlay --}}
                                        <div class="absolute top-3 right-3">
                                            <div class="bg-green-500 p-2 rounded-full shadow-lg">
                                                <i class="fa-solid fa-camera text-white text-sm"></i>
                                            </div>
                                        </div>
                                        
                                        {{-- Title Overlay --}}
                                        @if($i->judul)
                                            <div class="absolute bottom-0 left-0 right-0 p-4 transform translate-y-full group-hover:translate-y-0 transition-transform duration-300">
                                                <h3 class="text-white font-semibold text-sm">{{ $i->judul }}</h3>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                        @elseif ($i->type == 'youtube')
                            <div class="gallery-item break-inside-avoid mb-6 youtube" data-type="youtube">
                                <div class="group relative overflow-hidden rounded-xl shadow-lg hover:shadow-2xl transition-all duration-500 bg-white border border-gray-100">
                                    <div class="relative">
                                        <a data-fancybox="gallery" href="{{ $i->url }}" data-type="iframe" data-caption="{{ $i->judul }}">
                                            @php
                                                preg_match('/embed\/([^\?]*)/', $i->url, $matches);
                                                $videoId = $matches[1] ?? '';
                                            @endphp
                                            
                                            @if($videoId)
                                                <div class="relative aspect-video">
                                                    <img src="https://img.youtube.com/vi/{{ $videoId }}/maxresdefault.jpg" 
                                                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" 
                                                         alt="{{ $i->judul }}">
                                                    <div class="absolute inset-0 bg-black/30 group-hover:bg-black/40 transition-colors duration-300"></div>
                                                    <div class="absolute inset-0 flex items-center justify-center">
                                                        <div class="bg-red-600 p-4 rounded-full shadow-lg group-hover:scale-110 transition-transform duration-300">
                                                            <i class="fab fa-youtube text-white text-2xl"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                <iframe class="w-full aspect-video rounded-lg" src="{{ $i->url }}" frameborder="0"
                                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                                        allowfullscreen></iframe>
                                            @endif
                                        </a>
                                        
                                        {{-- YouTube Badge --}}
                                        <div class="absolute top-3 right-3">
                                            <div class="bg-red-600 p-2 rounded-full shadow-lg">
                                                <i class="fab fa-youtube text-white text-sm"></i>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    {{-- Video Title --}}
                                    @if($i->judul)
                                        <div class="p-4">
                                            <h3 class="font-semibold text-gray-900 text-sm group-hover:text-red-600 transition-colors duration-300">
                                                {{ $i->judul }}
                                            </h3>
                                        </div>
                                    @endif
                                </div>
                            </div>

                        @elseif ($i->type == 'tiktok')
                            <div class="gallery-item break-inside-avoid mb-6 tiktok" data-type="tiktok">
                                <div class="group relative overflow-hidden rounded-xl shadow-lg hover:shadow-2xl transition-all duration-500 bg-white border border-gray-100">
                                    <div class="relative">
                                        <a data-fancybox="gallery" 
                                           href="https://www.tiktok.com/player/v1/{{ $i->url }}?&music_info=1&description=1&loop=1&autoplay=1"
                                           data-type="iframe" data-caption="{{ $i->judul }}">
                                            
                                            <div class="aspect-[9/16] bg-gradient-to-br from-purple-500 to-pink-500 flex items-center justify-center">
                                                <div class="text-center text-white p-6">
                                                    <div class="bg-white/20 p-4 rounded-full mb-4 group-hover:scale-110 transition-transform duration-300">
                                                        <i class="fab fa-tiktok text-4xl"></i>
                                                    </div>
                                                    <p class="font-semibold">TikTok Video</p>
                                                    <p class="text-sm opacity-80 mt-2">Klik untuk memutar</p>
                                                </div>
                                            </div>
                                        </a>
                                        
                                        {{-- TikTok Badge --}}
                                        <div class="absolute top-3 right-3">
                                            <div class="bg-gradient-to-r from-purple-500 to-pink-500 p-2 rounded-full shadow-lg">
                                                <i class="fab fa-tiktok text-white text-sm"></i>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    {{-- TikTok Title --}}
                                    @if($i->judul)
                                        <div class="p-4">
                                            <h3 class="font-semibold text-gray-900 text-sm group-hover:text-purple-600 transition-colors duration-300">
                                                {{ $i->judul }}
                                            </h3>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
                
                {{-- Empty State --}}
                @if($gallery->isEmpty())
                    <div class="text-center py-16">
                        <div class="bg-gradient-to-br from-gray-100 to-gray-200 p-8 rounded-full w-24 h-24 mx-auto mb-6 flex items-center justify-center">
                            <i class="fa-solid fa-photo-film text-gray-400 text-3xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-600 mb-2">Belum Ada Media</h3>
                        <p class="text-gray-500">Galeri akan diperbarui dengan dokumentasi kegiatan terbaru</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</main>

@endsection

@section('script')
<script>
    // Initialize Fancybox for gallery
    Fancybox.bind('[data-fancybox="gallery"]', {
        Toolbar: {
            display: {
                left: ["infobar"],
                middle: [
                    "zoomIn",
                    "zoomOut",
                    "toggle1to1",
                    "rotateCCW",
                    "rotateCW",
                    "flipX",
                    "flipY",
                ],
                right: ["slideshow", "thumbs", "close"],
            },
        },
        Images: {
            zoom: true,
        },
        Carousel: {
            infinite: false,
        }
    });

    // Gallery Filter Functionality
    function filterGallery(type) {
        const items = document.querySelectorAll('.gallery-item');
        const buttons = document.querySelectorAll('.filter-btn');
        
        // Update active button
        buttons.forEach(btn => {
            btn.classList.remove('active', 'ring-2', 'ring-offset-2');
        });
        event.target.classList.add('active', 'ring-2', 'ring-offset-2');
        
        // Animate items out
        items.forEach(item => {
            item.style.transform = 'scale(0.8)';
            item.style.opacity = '0';
        });
        
        // Show/hide items after animation
        setTimeout(() => {
            items.forEach(item => {
                if (type === 'all' || item.dataset.type === type) {
                    item.style.display = 'block';
                    setTimeout(() => {
                        item.style.transform = 'scale(1)';
                        item.style.opacity = '1';
                        item.style.transition = 'all 0.4s ease';
                    }, 50);
                } else {
                    item.style.display = 'none';
                }
            });
        }, 200);
    }

    // Lazy loading for better performance
    document.addEventListener('DOMContentLoaded', function() {
        const images = document.querySelectorAll('img[loading="lazy"]');
        
        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.classList.add('loaded');
                    observer.unobserve(img);
                }
            });
        });

        images.forEach(img => {
            imageObserver.observe(img);
        });

        // Statistics counter animation
        const stats = document.querySelectorAll('.text-3xl.font-bold');
        const statsObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const target = entry.target;
                    const finalValue = parseInt(target.textContent);
                    let currentValue = 0;
                    const increment = Math.ceil(finalValue / 50);
                    
                    const timer = setInterval(() => {
                        currentValue += increment;
                        if (currentValue >= finalValue) {
                            currentValue = finalValue;
                            clearInterval(timer);
                        }
                        target.textContent = currentValue;
                    }, 30);
                    
                    statsObserver.unobserve(target);
                }
            });
        }, { threshold: 0.5 });

        stats.forEach(stat => {
            statsObserver.observe(stat);
        });
    });

    // Enhanced hover effects
    document.querySelectorAll('.gallery-item').forEach(item => {
        item.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-8px)';
            this.style.transition = 'all 0.3s ease';
        });
        
        item.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
</script>

<style>
    /* Enhanced Gallery Styles */
    .gallery-item {
        transition: all 0.3s ease;
        transform-origin: center;
    }
    
    .gallery-item img.loaded {
        animation: fadeInImage 0.5s ease-out;
    }
    
    @keyframes fadeInImage {
        from {
            opacity: 0;
            transform: scale(0.95);
        }
        to {
            opacity: 1;
            transform: scale(1);
        }
    }
    
    /* Masonry responsive adjustments */
    .masonry-grid {
        column-gap: 1.5rem;
    }
    
    .masonry-grid .gallery-item {
        display: inline-block;
        width: 100%;
        margin-bottom: 1.5rem;
    }
    
    /* Filter button active state */
    .filter-btn.active {
        box-shadow: 0 10px 25px rgba(59, 130, 246, 0.4);
        transform: translateY(-2px);
    }
    
    /* Custom scrollbar for better UX */
    ::-webkit-scrollbar {
        width: 8px;
    }
    
    ::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }
    
    ::-webkit-scrollbar-thumb {
        background: linear-gradient(to bottom, #3b82f6, #1d4ed8);
        border-radius: 10px;
    }
    
    ::-webkit-scrollbar-thumb:hover {
        background: linear-gradient(to bottom, #1d4ed8, #1e3a8a);
    }
    
    /* Mobile optimizations */
    @media (max-width: 768px) {
        .masonry-grid {
            columns: 2 !important;
            column-gap: 1rem;
        }
        
        .gallery-item {
            margin-bottom: 1rem;
        }
    }
    
    @media (max-width: 640px) {
        .masonry-grid {
            columns: 1 !important;
        }
    }
</style>
@endsection
