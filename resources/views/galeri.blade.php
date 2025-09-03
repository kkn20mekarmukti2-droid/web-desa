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

        <section class="contact" data-aos="fade-up" data-aos-easing="ease-in-out" data-aos-duration="500">
            <div class="container">

                <div
                    class="columns-4 max-sm:columns-2 gap-3 space-y-3">
                    @foreach ($gallery as $i)
             @if ($i->type == 'foto')
                <div class="">
                    <div class="rounded-lg">
                        <a data-fancybox="gallery" href="{{ asset('galeri/' . $i->url) }}"
                            data-caption="{{ $i->judul }}">
                            <img src="{{ asset('galeri/' . $i->url) }}" class="w-full rounded-lg" alt="...">
                        </a>
                    </div>
                </div>
            @elseif ($i->type == 'youtube')
                <div class="">
                    <div class="">
                        <a data-fancybox="gallery"
                            href="{{ $i->url }}"
                            data-type="iframe" data-caption="{{ $i->judul }}">

                            <iframe class="w-full aspect-video rounded-lg" src="{{ $i->url }}" frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen></iframe>
                        </a>
                    </div>
                </div>
            @elseif ($i->type == 'tiktok')
                <div class="">
                    <div class="">
                        <a data-fancybox="gallery"
                            href="https://www.tiktok.com/player/v1/{{ $i->url }}?&music_info=1&description=1&loop=1&autoplay=1"
                            data-type="iframe" data-caption="{{ $i->judul }}">

                            <iframe
                                src="https://www.tiktok.com/player/v1/{{ $i->url }}?description=1&loop=1"
                                allow="fullscreen;" title="test" class="rounded-lg w-full aspect-9/16"></iframe>
                        </a>
                    </div>
                </div>
                @endif
                @endforeach

            </div>

            </div>
        </section>

    </main>

@endsection
@section('script')
    <script>
        Fancybox.bind('[data-fancybox="gallery"]', {
            //
        });
    </script>
@endsection
