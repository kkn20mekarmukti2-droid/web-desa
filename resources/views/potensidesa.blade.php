@extends('layout.app')
@section('judul', 'Potensi Desa Mekarmukti')
@section('content')

    <main id="main">

        <section class="breadcrumbs">
            <div class="container">

                <div class="d-flex justify-content-between align-items-center">
                    <h2>Potensi Desa</h2>
                    <ol>
                        <li><a href="index.html">Beranda</a></li>
                        <li>Potensi Desa</li>
                    </ol>
                </div>

            </div>
        </section>

        <section class="bumdes">

            <div class="container">

                <div class="row">
                    <div class="col-md-12 mb-5 position-relative">
                        <div class="gambar text-center">
                            <img src="assets/img/bumdes.png" class="img-fluid" width="900px" alt="">
                        </div>
                    </div>
                </div>

                <div class=" row">
                    @foreach ($kategori as $i)
                        <div class="col-md-4 mt-2">
                            <div class="card">
                                @if (strpos($i->sampul, 'youtube'))
                                    <iframe class="aspect-video card-img-top" src="{{ $i->sampul }}"
                                        title="YouTube video player" frameborder="0"
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                        referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                                @else
                                    <img src="{{ asset('img/' . $i->sampul) }}" alt=""
                                        class="card-img-top">
                                @endif
                                <div class="card-body flex flex-col justify-between h-40">
                                    <div class="">
                                        <h5 class="card-title">{{ $i->judul }}</h5>
                                        <p class="card-text">{{ $i->header }}</p>
                                    </div>
                                    <a href="{{ route('detailartikel', ['tanggal' => $i->created_at->format('Y-m-d'), 'judul' => Str::slug($i->judul)]) }}"
                                        class="btn btn-primary">Kunjungi Berita</a>
                                </div>
                            </div>
                        </div>
                    @endforeach



                </div>


            </div>


        </section>


    </main>

@endsection
