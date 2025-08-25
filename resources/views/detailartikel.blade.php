@extends('layout.app')
@section('judul', $artikel->judul)
@section('penulis', $artikel->creator->name)
@section('content')
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
            @if (strpos($artikel->sampul, 'youtube'))
                <iframe class="w-full aspect-video my-5" src="{{ $artikel->sampul }}" title="YouTube video player"
                    frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                    referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
            @else
                <img src="{{ asset('img/' . $artikel->sampul) }}" alt="" class="w-full bg-cover mt-10">
            @endif
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

@endsection
