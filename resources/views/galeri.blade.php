@extends('layout.app')
@section('judul', 'Galeri Desa Mekarmukti')
@section('content')
    <main id="main">

        <!-- ======= Our Services Section ======= -->
        <section class="breadcrumbs">
            <div class="container">

                <div class="d-flex justify-content-between align-items-center">
                    <h2>Galeri</h2>
                    <ol>
                        <li><a href="index.html">Beranda</a></li>
                        <li>Galeri</li>
                    </ol>
                </div>

            </div>
        </section>

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
