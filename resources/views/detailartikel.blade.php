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
        .prose img {
            max-width: 100%;
            height: auto;
            border-radius: 0.5rem;
            margin: 1.5rem auto;
        }
        
        /* Gallery grid untuk multiple images */
        .image-gallery {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 0.75rem;
            margin: 1.5rem 0;
        }
        
        .image-gallery img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 0.375rem;
            cursor: pointer;
        }
        
        /* Zoom effect pada hover */
        .zoom-effect {
            overflow: hidden;
        }
        
        .zoom-effect img {
            transition: transform 0.5s ease;
        }
        
        .zoom-effect:hover img {
            transform: scale(1.05);
        }
    </style>
    <div class="grid grid-cols-8 max-sm:grid-cols-1 mx-80 max-sm:mx-10 mt-24 mb-72 max-sm:mb-40">

        <div class="col-span-6 max-sm:col-span-1">
            <div class="w-full rounded-sm bg-slate-100 flex px-2 py-2 items-center text-sm"><i
                    class="fa-solid fa-house text-blue-500"></i>
                <div class="opacity-35 mx-1">/</div>
                <div class="font-semibold text-blue-500">Berita</div>
                <div class="opacity-35 mx-2">/</div> {{ \Illuminate\Support\Str::limit($artikel->judul, 50, '...') }}
            </div>
            <hr class="mt-10">
            <h1 class="text-4xl font-bold text-blue-600">{{ $artikel->judul }}
            </h1>
            <h2 class="text-xl font-semibold ">{{ $artikel->header }}
            </h2>
            <div class="flex text-primary/80 gap-5 text-xs mt-2 max-sm:gap-2 max-sm:text-[10px]">
                @if ($artikel->kategori != '')
                    <div class="flex items-center"><i class="fa-solid fa-tag">&nbsp;</i>
                        <p>{{ $artikel->getKategori->judul }}</p>
                    </div>
                @endif
                <div class="flex items-center"><i class="fa-solid fa-calendar-days">&nbsp;</i>
                    <p>{{ date('d  M  Y', strtotime($artikel->created_at)) }}</p>
                </div>
                <div class="flex items-center"><i class="fa-regular fa-user">&nbsp;</i>
                    <p>Oleh : {{ $artikel->creator->name }}</p>
                </div>
            </div>
            <div class="my-10 flex justify-center">
                <div class="max-w-[800px] w-full mx-auto" style="max-width: 70%;">
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
                        {{-- Placeholder untuk detail artikel --}}
                        <div class="w-full aspect-[16/9] bg-gradient-to-br from-blue-100 to-blue-200 flex items-center justify-center rounded-lg shadow-md">
                            <div class="text-center">
                                <i class="bi bi-newspaper text-blue-500" style="font-size: 4rem;"></i>
                                <p class="text-blue-600 mt-3 font-medium">{{ $artikel->judul }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Lightbox untuk preview gambar -->
            <div id="image-preview-modal" class="fixed inset-0 bg-black bg-opacity-75 z-50 hidden items-center justify-center p-4">
                <div class="relative max-w-4xl w-full">
                    <button onclick="closeImagePreview()" class="absolute -top-10 right-0 text-white text-2xl font-bold">&times;</button>
                    <img id="preview-image" src="" alt="Preview" class="max-w-full max-h-[80vh] mx-auto">
                </div>
            </div>
            <div class="my-10 mx-5 prose">{!! $artikel->deskripsi !!}</div>
        </div>
        <div class="mt-40 ml-10 col-span-2 max-sm:col-span-1 max-sm:ml-0">
            <div>
                <div class="w-full flex">
                    <h2 class="text-lg font-semibold rounded-t-md border-t-4 border-t-black border-x w-fit p-2">
                        BERITA ACAK</h2>
                    <div class="border-b flex-grow"></div>
                </div>
                <div class="rounded-b-md px-3 border-t-0 border-x border-b pt-3">
                    @foreach ($rekomendasi as $i)
                        <a href="{{ route('detailartikel', ['tanggal' => $i->created_at->format('Y-m-d'), 'judul' => Str::slug($i->judul)]) }}"
                            class="group">

                            <div class="border-b border-black/20 mb-3 flex">
                                @if (strpos($i->sampul, 'youtube'))
                                    @php
                                        $youtubeUrl = $i->sampul;
                                        preg_match('/embed\/([^\?]*)/', $youtubeUrl, $matches);
                                        $thumbnail = $matches[1] ?? null;
                                    @endphp
                                    <img src="https://img.youtube.com/vi/{{ $thumbnail }}/hqdefault.jpg" alt=""
                                        class="w-1/4">
                                @else
                                    <img src="{{ asset('img/' . $i->sampul) }}" alt="" class="w-1/4">
                                @endif
                                <div class="ml-1">
                                    <p class="group-hover:font-bold transition-all text-xs">
                                        {{ Str::limit($i->judul, 50, '...') }}</p>
                                    <p class="text-xs text-black/50 group-hover:text-black/90"><i
                                            class="fa-solid fa-calendar-days"></i>
                                        {{ date('d/m/Y', strtotime($i->created_at)) }}</p>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
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
                wrapper.className = 'max-w-[800px] w-full mx-auto rounded-lg shadow-md overflow-hidden';
                wrapper.style.maxWidth = '70%';
                
                // Salin gambar ke dalam wrapper baru
                const newImg = img.cloneNode(true);
                newImg.className = 'w-full h-auto object-contain cursor-pointer';
                newImg.setAttribute('onclick', 'openImagePreview(this.src)');
                
                // Gantikan gambar asli dengan struktur baru
                wrapper.appendChild(newImg);
                container.appendChild(wrapper);
                img.parentNode.replaceChild(container, img);
            });
        });
    </script>
@endsection
