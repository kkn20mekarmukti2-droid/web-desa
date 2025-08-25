@extends('layout.app')
@section('judul', 'Data RW ' . str_pad($rw->rw, 2, '0', STR_PAD_LEFT). ' Desa Mekarmukti')
@section('nav', 'rtrw')
@section('content')
    <main class="bg-gray-100">
        <div class="container mx-auto p-4">
            <h1 class="text-3xl font-bold text-center mb-8"></h1>
            <div class="bg-white shadow-md rounded-lg p-4 mb-6 mt-28">
                <div class="flex items-center my-5 justify-center scale-105">
                    <div class=" border-b-2 pb-2 px-4 flex items-center border-yellow-400">
                        <img src="https://www.its.ac.id/aktuaria/wp-content/uploads/sites/100/2018/03/user.png" alt="Photo of "
                            class="w-16 h-16 rounded-full mr-4">
                        <div>
                            <h2 class="text-xl font-semibold">{{$rw->nama}}</h2>
                            <p class="text-gray-600">RW {{ str_pad($rw->rw, 2, '0', STR_PAD_LEFT) }}</p>
                            <p class="text-gray-600">{{$rw->kontak}}</p>
                        </div>

                    </div>
                </div>
                <h3 class="text-lg font-bold mb-2">RT dari RW {{ str_pad($rw->rw, 2, '0', STR_PAD_LEFT) }}</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach ($rw->rts as $rt)
                        <div class="bg-gray-50 p-4 rounded-lg shadow">
                            <div class="flex items-center mb-2">
                                <img src="https://www.its.ac.id/aktuaria/wp-content/uploads/sites/100/2018/03/user.png"
                                    alt="Photo of " class="w-12 h-12 rounded-full mr-3">
                                <div class="flex flex-col justify-center">
                                    <h4 class="text-md font-semibold">{{$rt->nama}}</h4>
                                    <p class="text-gray-600">RT {{ str_pad($rt->rt, 2, '0', STR_PAD_LEFT) }}</p>
                                    @if ($rt->kontak)
                                    <p class="text-gray-600">{{$rt->kontak}}</p>

                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
            {{-- @else
            <p class="text-center text-gray-600">No RW data available.</p>
        @endif --}}
        </div>
    </main>
@endsection
