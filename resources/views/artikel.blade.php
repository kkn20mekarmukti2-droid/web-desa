@extends('layout.app')
@section('judul', isset($_GET['kategori']) ? $_GET['kategori'] . ' Desa Mekarmuti' : 'Berita Desa')
@section('content')
    <main class="mt-24 flex justify-center w-full mb-10">
        <div class="w-[1200px]">

            <div class="rounded-sm bg-slate-100 flex px-2 py-2 items-center text-sm mb-3 max-sm:mx-10"><i
                    class="fa-solid fa-house text-blue-500"></i>
                <div class="opacity-35 mx-1">/</div>
                <div class="font-semibold">Berita</div>
            </div>
            <div class="flex flex-col sm:flex-row  items-center justify-between bg-gray-100 p-6 space-y-4 sm:space-y-0 w-full mx-auto rounded-md max-sm:mb-4"
                >
                <p class="text-center sm:text-left text-gray-700 text-lg font-medium max-sm:text-sm">
                    Jangan ketinggalan! Subscribe untuk menerima notifikasi terkait artikel terbaru.
                </p>
                <button id="subscribeButton"
                    class="transform bg-blue-500 text-white font-bold py-2 px-6 rounded-lg shadow-lg transition duration-300 ease-in-out hover:-translate-y-1 hover:scale-105 hover:bg-blue-600 flex items-center space-x-2 group">
                    <i class="fa-solid fa-bell group-hover:animate-bounce transition-all"></i>
                    <span>Subscribe</span>
                </button>
            </div>
            <h1 class="mb-2 text-2xl font-semibold text-blue-800 max-sm:mx-12">
                {{ isset($_GET['kategori']) ? 'Kategori Berita ' . $_GET['kategori'] : (isset($_GET['search']) ? 'Berita "' . $_GET['search'] . '"' : 'Berita') }}
            </h1>
            <form action="{{ route('berita') }}" method="get"
                class="flex items-center justify-between border border-gray-300 rounded-md mx-5 mb-4 sm:hidden">
                <input type="text" name="search" placeholder="Pencarian Berita..."
                    class="flex-grow p-2 border-none focus:outline-none">
                <button type="submit" class="p-2"><i class="fa-solid fa-magnifying-glass"></i></button>
            </form>
            <div class="grid grid-cols-4 gap-10 max-sm:grid-cols-1">
                <div class="col-span-3 max-sm:col-span-1 max-sm:mx-10 space-y-3">
                    @foreach ($artikel as $i)
                        <div class="w-full h-52 max-sm:h-32 grid grid-cols-3 sm:gap-5 max-sm:gap-2 border-b">
                            <div class="flex items-center rounded-md ">
                                @if (strpos($i->sampul, 'youtube'))
                                    <iframe class="aspect-video w-full" src="{{ $i->sampul }}"
                                        title="YouTube video player" frameborder="0"
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                        referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                                @elseif($i->sampul && file_exists(public_path('img/' . $i->sampul)))
                                    <img src="{{ asset('img/' . $i->sampul) }}" alt="" class="w-full object-cover rounded-md">
                                @else
                                    {{-- Placeholder untuk artikel tanpa gambar --}}
                                    <div class="w-full aspect-video bg-gradient-to-br from-blue-100 to-blue-200 flex items-center justify-center rounded-md">
                                        <div class="text-center">
                                            <i class="bi bi-newspaper text-blue-500" style="font-size: 2rem;"></i>
                                            <small class="d-block text-blue-600 mt-1 text-xs">Artikel Berita</small>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="col-span-2 py-3">
                                <a href="{{ route('detailartikel', ['tanggal' => $i->created_at->format('Y-m-d'), 'judul' => Str::slug($i->judul)]) }}"
                                    class="group">
                                    <h1 class="text-blue-600 font-bold text-xl max-sm:text-base">{{ $i->judul }}</h1>
                                </a>
                                <div class="flex items-center gap-3">
                                    @if ($i->kategori != '')
                                        <p class="text-xs text-black/50 group-hover:text-black/90 max-sm:text-[.6rem]"><i
                                                class="fa-solid fa-tag"></i>
                                            {{ $i->getKategori->judul }}
                                        </p>
                                    @endif
                                    <p class="text-xs text-black/50 group-hover:text-black/90 max-sm:text-[.6rem]"><i
                                            class="fa-solid fa-calendar-days"></i>
                                        {{ date('d/m/Y', strtotime($i->created_at)) }}</p>
                                    <p class="text-xs text-black/50 group-hover:text-black/90 max-sm:text-[.7rem]"><i
                                            class="fa-solid fa-user scale-90 mr-1"></i>{{ $i->creator->name }}</p>
                                </div>
                                <p class="text-xs">
                                    <span class="mr-1">{{ $i->header }}</span>
                                    <a href="{{ route('detailartikel', ['tanggal' => $i->created_at->format('Y-m-d'), 'judul' => Str::slug($i->judul)]) }}"
                                        class="text-blue-600 hover:underline">
                                        Selengkapnya
                                    </a>
                                </p>

                            </div>
                        </div>
                    @endforeach
                    <div class="flex justify-center mt-4">
                        {{ $artikel->links('paginate') }}
                    </div>
                </div>
                <div class="flex justify-center">
                    <div class="w-full max-sm:mx-10 space-y-7">
                        <div class="max-sm:hidden">
                            <form action="{{ route('berita') }}" method="get"
                                class="w-full flex items-center border border-gray-300 rounded-md p-2">
                                <input type="text" name="search" placeholder="Pencarian Berita..."
                                    class="flex-grow p-2 border-none focus:outline-none">
                                <button type="submit" class="p-2"><i class="fa-solid fa-magnifying-glass"></i></button>
                            </form>
                        </div>
                        <div>
                            <h2 class="font-semibold text-xl">Kategori</h2>
                            <ul>
                                @foreach ($listkategori as $k)
                                    <li><a href="{{ route('berita', ['kategori' => $k->judul]) }}"><i
                                                class="fa-sharp fa-solid fa-play scale-50 mr-1"></i>{{ $k->judul }}
                                            ({{ $k->artikel_count }})
                                        </a></li>
                                @endforeach
                            </ul>
                        </div>
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
                                                <img src="https://img.youtube.com/vi/{{ $thumbnail }}/hqdefault.jpg"
                                                    alt="" class="w-1/4">
                                            @elseif($i->sampul && file_exists(public_path('img/' . $i->sampul)))
                                                <img src="{{ asset('img/' . $i->sampul) }}" alt="" class="w-1/4 object-cover">
                                            @else
                                                {{-- Mini placeholder untuk sidebar --}}
                                                <div class="w-1/4 aspect-video bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                                                    <i class="bi bi-image text-gray-400 text-lg"></i>
                                                </div>
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
            </div>
        </div>
    </main>
@endsection
