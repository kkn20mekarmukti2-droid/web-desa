@extends('layout.app')
@section('judul', $artikel->judul)
@section('penulis', $artikel->creator->name)
@section('content')
    <style>
        /* Styling untuk gambar artikel */
        .article-image-container {
            border-radius: 0.5rem;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .article-image-container:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
        }
        
        .article-image {
            transition: transform 0.3s ease;
        }
        
        /* Styling untuk gambar dalam konten prose */
        .prose {
            width: 100%;
            max-width: 100%;
        }
        
        .prose img {
            max-width: 100%;
            height: auto;
            border-radius: 0.5rem;
            margin: 0 auto;
        }
        
        /* Styling untuk gambar dalam galeri */
        .image-gallery {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 1rem;
            margin: 1.5rem 0;
        }
        
        .image-gallery-item {
            border-radius: 0.5rem;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        /* Responsive fixes */
        @media (max-width: 768px) {
            .prose {
                font-size: 0.95rem;
            }
            
            .prose h2 {
                font-size: 1.4rem;
            }
            
            .prose h3 {
                font-size: 1.2rem;
            }
        }
    </style>
    <div class="container mx-auto px-4 mt-24 mb-20">
        <div class="grid grid-cols-12 gap-8">
            <div class="col-span-12 lg:col-span-8">
                <!-- Breadcrumb -->
                <div class="w-full rounded-sm bg-slate-100 flex px-2 py-2 items-center text-sm mb-6">
                    <i class="fa-solid fa-house text-blue-500"></i>
                    <div class="opacity-35 mx-1">/</div>
                    <div class="font-semibold text-blue-500">Berita</div>
                    <div class="opacity-35 mx-2">/</div> {{ \Illuminate\Support\Str::limit($artikel->judul, 50, '...') }}
                </div>
                
                <!-- Article Header -->
                <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-6 mb-8">
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900 mb-3">{{ $artikel->judul }}</h1>
                    <h2 class="text-lg font-medium text-gray-700 mb-4">{{ $artikel->header }}</h2>
                    
                    <div class="flex flex-wrap items-center text-sm text-gray-600 gap-4 mb-2">
                        @if ($artikel->kategori != '')
                            <div class="flex items-center">
                                <i class="fa-solid fa-tag mr-2"></i>
                                <span>{{ $artikel->getKategori->judul }}</span>
                            </div>
                        @endif
                        <div class="flex items-center">
                            <i class="fa-solid fa-calendar-days mr-2"></i>
                            <span>{{ date('d M Y', strtotime($artikel->created_at)) }}</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fa-regular fa-user mr-2"></i>
                            <span>Oleh: {{ $artikel->creator->name }}</span>
                        </div>
                    </div>
                </div>
                
                <!-- Article Featured Image/Video -->
                <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-6 mb-8">
                    <div class="max-w-3xl mx-auto">
                        @if (strpos($artikel->sampul, 'youtube'))
                            <div class="relative overflow-hidden rounded-lg shadow-md">
                                <iframe class="w-full aspect-video" src="{{ $artikel->sampul }}" title="YouTube video player"
                                    frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                    referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                            </div>
                        @elseif($artikel->sampul && file_exists(public_path('img/' . $artikel->sampul)))
                            <div class="article-image-container">
                                <img src="{{ asset('img/' . $artikel->sampul) }}" alt="{{ $artikel->judul }}" 
                                    class="w-full h-auto object-contain rounded-lg shadow-md cursor-pointer article-image" 
                                    onclick="openImagePreview(this.src)" 
                                    data-src="{{ asset('img/' . $artikel->sampul) }}">
                            </div>
                        @else
                            <div class="w-full aspect-[16/9] bg-gradient-to-br from-blue-100 to-blue-200 flex items-center justify-center rounded-lg shadow-md">
                                <div class="text-center">
                                    <i class="bi bi-newspaper text-blue-500" style="font-size: 4rem;"></i>
                                    <p class="text-blue-600 mt-3 font-medium">{{ $artikel->judul }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            
                <!-- Article Content -->
                <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-6">
                    <div class="prose max-w-3xl mx-auto">{!! $artikel->deskripsi !!}</div>
                </div>
            </div>
            
            <!-- Sidebar -->
            <div class="col-span-12 lg:col-span-4">
                <div class="bg-white rounded-lg border border-gray-200 shadow-sm sticky top-24">
                    <div class="border-b border-gray-200">
                        <h3 class="text-lg font-bold text-gray-900 p-4">Artikel Terkait</h3>
                    </div>
                    <div class="p-4">
                        @foreach ($rekomendasi as $i)
                            <a href="{{ route('detailartikel', ['tanggal' => $i->created_at->format('Y-m-d'), 'judul' => Str::slug($i->judul)]) }}"
                                class="group flex items-start gap-3 pb-4 mb-4 border-b border-gray-100 last:border-0 last:mb-0 last:pb-0">
                                
                                <div class="w-20 h-20 flex-shrink-0 rounded-md overflow-hidden">
                                    @if (strpos($i->sampul, 'youtube'))
                                        @php
                                            $youtubeUrl = $i->sampul;
                                            preg_match('/embed\/([^\?]*)/', $youtubeUrl, $matches);
                                            $thumbnail = $matches[1] ?? null;
                                        @endphp
                                        <img src="https://img.youtube.com/vi/{{ $thumbnail }}/hqdefault.jpg" 
                                            alt="{{ $i->judul }}"
                                            class="w-full h-full object-cover">
                                    @else
                                        <img src="{{ asset('img/' . $i->sampul) }}" 
                                            alt="{{ $i->judul }}" 
                                            class="w-full h-full object-cover">
                                    @endif
                                </div>
                                
                                <div class="flex-1">
                                    <h4 class="text-sm font-medium text-gray-900 group-hover:text-blue-600 line-clamp-2 mb-1">
                                        {{ Str::limit($i->judul, 60, '...') }}
                                    </h4>
                                    <div class="flex items-center text-xs text-gray-500">
                                        <i class="fa-solid fa-calendar-days mr-1"></i>
                                        <span>{{ date('d M Y', strtotime($i->created_at)) }}</span>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    
    <!-- Lightbox untuk preview gambar -->
    <div id="image-preview-modal" class="fixed inset-0 bg-black bg-opacity-80 z-50 hidden items-center justify-center p-4">
        <div class="relative max-w-4xl w-full">
            <button onclick="closeImagePreview()" class="absolute -top-10 right-0 text-white text-2xl font-bold">&times;</button>
            <img id="preview-image" src="" alt="Preview" class="max-w-full max-h-[80vh] mx-auto object-contain">
        </div>
    </div>

    <script>
        // Fungsi untuk membuka lightbox
        function openImagePreview(src) {
            const modal = document.getElementById('image-preview-modal');
            const previewImage = document.getElementById('preview-image');
            
            previewImage.src = src;
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            
            // Tambahkan event listener untuk menutup modal dengan klik di luar gambar
            modal.addEventListener('click', function(e) {
                if (e.target === modal) {
                    closeImagePreview();
                }
            });
            
            // Tambahkan event listener untuk menutup modal dengan tombol escape
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    closeImagePreview();
                }
            });
        }
        
        // Fungsi untuk menutup lightbox
        function closeImagePreview() {
            const modal = document.getElementById('image-preview-modal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
        
        // Proses gambar yang ada dalam konten artikel
        document.addEventListener('DOMContentLoaded', function() {
            // Mencari semua gambar dalam konten artikel (div dengan class 'prose')
            const contentImages = document.querySelectorAll('.prose img');
            
            contentImages.forEach(img => {
                // Bungkus dengan container untuk styling konsisten
                const container = document.createElement('div');
                container.className = 'flex justify-center my-4';
                
                const wrapper = document.createElement('div');
                wrapper.className = 'max-w-3xl w-full rounded-lg shadow-sm overflow-hidden';
                wrapper.style.maxWidth = '100%';
                
                // Salin gambar ke dalam wrapper baru
                const newImg = img.cloneNode(true);
                newImg.className = 'w-full h-auto object-contain cursor-pointer hover:opacity-95 transition-opacity';
                newImg.setAttribute('onclick', 'openImagePreview(this.src)');
                
                // Gantikan gambar asli dengan struktur baru
                wrapper.appendChild(newImg);
                container.appendChild(wrapper);
                img.parentNode.replaceChild(container, img);
            });
        });
    </script>
@endsection
