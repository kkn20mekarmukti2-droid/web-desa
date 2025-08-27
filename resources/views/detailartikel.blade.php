@extends('layout.app')
@section('judul', $artikel->judul)
@section('penulis', $artikel->creator->name)
@section('content')
    <style>
        /* Styling untuk semua gambar */
        .article-image-container {
            border-radius: 0.5rem;
            overflow: hidden;
            position: relative;
            aspect-ratio: 16/9;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        .article-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
            transition: transform 0.3s ease;
        }
        
        .article-image-container:hover .article-image {
            transform: scale(1.02);
        }
        
        /* Styling untuk prose dan gambar di dalamnya */
        .prose {
            width: 100%;
            max-width: 100%;
        }
        
        .prose img {
            max-width: 100%;
            height: auto;
            display: block;
            margin: 1.5rem auto;
            border-radius: 0.5rem;
            cursor: pointer;
        }
        
        /* Media Card Styling */
        .media-card {
            background-color: white;
            border-radius: 0.5rem;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }
        
        .media-card:hover {
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
            transform: translateY(-2px);
        }
        
        /* Lightbox Styling */
        .lightbox {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.9);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }
        
        .lightbox.active {
            opacity: 1;
            visibility: visible;
        }
        
        .lightbox-content {
            max-width: 90%;
            max-height: 90%;
            transform: scale(0.9);
            transition: transform 0.3s ease;
        }
        
        .lightbox.active .lightbox-content {
            transform: scale(1);
        }
        
        .close-lightbox {
            position: absolute;
            top: 20px;
            right: 20px;
            color: white;
            font-size: 30px;
            cursor: pointer;
            z-index: 1001;
        }
        
        /* Responsive fixes */
        @media (max-width: 768px) {
            .prose {
                font-size: 0.95rem;
            }
        }
    </style>
    <div class="container mx-auto px-4 py-8 mt-16">
        <div class="max-w-6xl mx-auto">
            <!-- Breadcrumb -->
            <div class="flex items-center text-sm text-gray-600 mb-6">
                <a href="/" class="hover:text-blue-600 transition-colors">
                    <i class="fa-solid fa-home"></i>
                </a>
                <span class="mx-2">/</span>
                <a href="/berita" class="hover:text-blue-600 transition-colors">Berita</a>
                <span class="mx-2">/</span>
                <span class="text-gray-400">{{ \Illuminate\Support\Str::limit($artikel->judul, 40, '...') }}</span>
            </div>
            
            <!-- Article Header -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
                <h1 class="text-2xl md:text-3xl font-bold text-gray-900 mb-3">{{ $artikel->judul }}</h1>
                
                <div class="flex flex-wrap items-center text-sm text-gray-600 gap-x-4 gap-y-2 mb-4">
                    <div class="flex items-center">
                        <i class="fa-solid fa-calendar-days mr-2"></i>
                        <span>{{ date('d M Y', strtotime($artikel->created_at)) }}</span>
                    </div>
                    @if ($artikel->kategori != '')
                    <div class="flex items-center">
                        <i class="fa-solid fa-tag mr-2"></i>
                        <span>{{ $artikel->getKategori->judul }}</span>
                    </div>
                    @endif
                    <div class="flex items-center">
                        <i class="fa-regular fa-user mr-2"></i>
                        <span>{{ $artikel->creator->name }}</span>
                    </div>
                </div>
                
                @if ($artikel->header)
                <p class="text-gray-700 text-lg mb-2">{{ $artikel->header }}</p>
                @endif
            </div>
            
            <!-- Article Featured Media -->
            <div class="mb-8">
                <div class="media-card">
                    <div class="aspect-[16/9] relative overflow-hidden">
                        @if (strpos($artikel->sampul, 'youtube'))
                            <iframe src="{{ $artikel->sampul }}" 
                                class="absolute inset-0 w-full h-full" 
                                title="YouTube video player" 
                                frameborder="0" 
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                                allowfullscreen>
                            </iframe>
                        @elseif($artikel->sampul && file_exists(public_path('img/' . $artikel->sampul)))
                            <div class="article-image-container">
                                <img src="{{ asset('img/' . $artikel->sampul) }}" 
                                    alt="{{ $artikel->judul }}" 
                                    class="article-image" 
                                    onclick="openLightbox('{{ asset('img/' . $artikel->sampul) }}')">
                            </div>
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-blue-100 to-blue-200 flex items-center justify-center">
                                <div class="text-center">
                                    <i class="bi bi-newspaper text-blue-500" style="font-size: 4rem;"></i>
                                    <p class="text-blue-600 mt-3 font-medium">{{ $artikel->judul }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            
            <!-- Article Content -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                <!-- Main Content -->
                <div class="lg:col-span-8">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <div class="prose max-w-none">{!! $artikel->deskripsi !!}</div>
                    </div>
                </div>
                
                <!-- Sidebar -->
                <div class="lg:col-span-4">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 sticky top-24">
                        <div class="p-4 border-b border-gray-100">
                            <h3 class="text-lg font-bold text-gray-900">Artikel Terkait</h3>
                        </div>
                        <div class="p-4">
                            @foreach ($rekomendasi as $i)
                                <a href="{{ route('detailartikel', ['tanggal' => $i->created_at->format('Y-m-d'), 'judul' => Str::slug($i->judul)]) }}" 
                                   class="group block mb-4 pb-4 border-b border-gray-100 last:border-0 last:mb-0 last:pb-0">
                                    <div class="flex gap-3">
                                        <div class="w-20 h-20 flex-shrink-0 rounded-md overflow-hidden">
                                            @if (strpos($i->sampul, 'youtube'))
                                                @php
                                                    $youtubeUrl = $i->sampul;
                                                    preg_match('/embed\/([^\?]*)/', $youtubeUrl, $matches);
                                                    $thumbnail = $matches[1] ?? null;
                                                @endphp
                                                <img src="https://img.youtube.com/vi/{{ $thumbnail }}/hqdefault.jpg" 
                                                     alt="{{ $i->judul }}" 
                                                     class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
                                            @else
                                                <img src="{{ asset('img/' . $i->sampul) }}" 
                                                     alt="{{ $i->judul }}" 
                                                     class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
                                            @endif
                                        </div>
                                        <div class="flex-1">
                                            <h4 class="text-sm font-medium text-gray-900 group-hover:text-blue-600 line-clamp-2 transition-colors">
                                                {{ Str::limit($i->judul, 60, '...') }}
                                            </h4>
                                            <div class="flex items-center mt-2 text-xs text-gray-500">
                                                <i class="fa-solid fa-calendar-days mr-1"></i>
                                                <span>{{ date('d M Y', strtotime($i->created_at)) }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Lightbox -->
    <div id="lightbox" class="lightbox" onclick="closeLightbox()">
        <span class="close-lightbox">&times;</span>
        <img id="lightbox-image" class="lightbox-content" src="" alt="Gambar artikel">
    </div>
    
    <script>
        // Fungsi untuk menangani lightbox
        function openLightbox(imageSrc) {
            const lightbox = document.getElementById('lightbox');
            const lightboxImage = document.getElementById('lightbox-image');
            
            lightboxImage.src = imageSrc;
            lightbox.classList.add('active');
            
            // Mencegah scroll pada body
            document.body.style.overflow = 'hidden';
        }
        
        function closeLightbox() {
            const lightbox = document.getElementById('lightbox');
            lightbox.classList.remove('active');
            
            // Mengembalikan scroll pada body
            document.body.style.overflow = '';
        }
        
        // Close lightbox with ESC key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeLightbox();
            }
        });
        
        // Proses gambar dalam konten artikel
        document.addEventListener('DOMContentLoaded', function() {
            // Mencari semua gambar dalam konten artikel
            const contentImages = document.querySelectorAll('.prose img');
            
            contentImages.forEach(img => {
                // Membuat container untuk gambar
                const container = document.createElement('div');
                container.className = 'my-6';
                
                // Membuat wrapper dengan styling konsisten
                const wrapper = document.createElement('div');
                wrapper.className = 'media-card';
                
                // Membuat div untuk aspect ratio
                const aspectRatioDiv = document.createElement('div');
                aspectRatioDiv.className = 'article-image-container';
                
                // Salin gambar ke dalam struktur baru
                const newImg = document.createElement('img');
                newImg.src = img.src;
                newImg.alt = img.alt || 'Gambar artikel';
                newImg.className = 'article-image';
                newImg.setAttribute('onclick', `openLightbox('${img.src}')`);
                
                // Bangun struktur DOM
                aspectRatioDiv.appendChild(newImg);
                wrapper.appendChild(aspectRatioDiv);
                container.appendChild(wrapper);
                
                // Gantikan gambar asli dengan struktur baru
                img.parentNode.replaceChild(container, img);
            });
        });
    </script>
@endsection
