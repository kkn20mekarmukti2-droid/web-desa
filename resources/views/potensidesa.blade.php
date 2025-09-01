@extends('layout.app')
@section('judul', 'Produk UMKM Unggulan Desa Mekarmukti')
@section('content')

    <main id="main">

        <section class="breadcrumbs">
            <div class="container">

                <div class="d-flex justify-content-between align-items-center">
                    <h2>Produk UMKM</h2>
                    <ol>
                        <li><a href="index.html">Beranda</a></li>
                        <li>Produk UMKM</li>
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
                                @elseif($i->sampul && file_exists(public_path('img/' . $i->sampul)))
                                    <img src="{{ asset('img/' . $i->sampul) }}" alt="" class="card-img-top object-cover">
                                @else
                                    {{-- Placeholder untuk kartu produk UMKM --}}
                                    <div class="card-img-top bg-gradient-to-br from-green-100 to-green-200 d-flex align-items-center justify-content-center" style="height: 200px;">
                                        <div class="text-center">
                                            <i class="bi bi-gem text-green-600" style="font-size: 3rem;"></i>
                                            <small class="d-block text-green-700 mt-2 fw-medium">Produk UMKM</small>
                                        </div>
                                    </div>
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
