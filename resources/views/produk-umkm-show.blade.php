@extends('layout.app')
@section('judul', $produk->nama_produk . ' - Produk UMKM')
@section('content')
<div class="container py-5">
    <!-- Breadcrumb -->
    <nav class="mb-6" aria-label="breadcrumb">
        <ol class="breadcrumb bg-transparent p-0 m-0">
            <li class="breadcrumb-item"><a href="/" class="text-blue-600">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('produk-umkm.index') }}" class="text-blue-600">Produk UMKM</a></li>
            <li class="breadcrumb-item active">{{ $produk->nama_produk }}</li>
        </ol>
    </nav>

    <!-- Product Detail -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="md:flex">
            <!-- Product Image -->
            <div class="md:w-1/2">
                @if($produk->gambar && file_exists(public_path('storage/' . $produk->gambar)))
                <img src="{{ asset('storage/' . $produk->gambar) }}" alt="{{ $produk->nama_produk }}" class="w-full h-96 md:h-full object-cover">
                @elseif($produk->gambar)
                <img src="{{ asset($produk->gambar) }}" alt="{{ $produk->nama_produk }}" class="w-full h-96 md:h-full object-cover">
                @else
                <div class="w-full h-96 md:h-full bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                    <i class="fas fa-image text-gray-400 text-8xl"></i>
                </div>
                @endif
            </div>

            <!-- Product Info -->
            <div class="md:w-1/2 p-8">
                <div class="mb-4">
                    <h1 class="text-3xl font-bold text-gray-800 mb-2">{{ $produk->nama_produk }}</h1>
                    <div class="flex items-center text-sm text-gray-500 mb-4">
                        <i class="fas fa-store mr-2"></i>
                        <span>Produk UMKM Desa Mekarmukti</span>
                    </div>
                </div>

                <!-- Description -->
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-3">Deskripsi Produk</h3>
                    <p class="text-gray-600 leading-relaxed">{{ $produk->deskripsi }}</p>
                </div>

                <!-- Contact Info -->
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-3">Informasi Kontak</h3>
                    <div class="flex items-center text-gray-600">
                        <i class="fab fa-whatsapp text-green-500 mr-2"></i>
                        <span>{{ $produk->nomor_telepon }}</span>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-3">
                    <a href="https://wa.me/{{ $produk->nomor_telepon }}?text=Halo,%20saya%20tertarik%20dengan%20produk%20{{ urlencode($produk->nama_produk) }}%20dari%20UMKM%20Desa%20Mekarmukti" 
                       target="_blank" 
                       class="flex-1 bg-green-500 hover:bg-green-600 text-white font-semibold py-3 px-6 rounded-lg flex items-center justify-center transition-all duration-200 transform hover:scale-105 shadow-lg">
                        <i class="fab fa-whatsapp mr-2"></i>
                        Hubungi Penjual
                    </a>
                    <a href="{{ route('produk-umkm.index') }}" 
                       class="flex-1 bg-gray-500 hover:bg-gray-600 text-white font-semibold py-3 px-6 rounded-lg flex items-center justify-center transition-all duration-200">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Kembali
                    </a>
                </div>

                <!-- Admin Controls -->
                @auth
                <div class="mt-6 pt-6 border-t border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800 mb-3">Panel Admin</h3>
                    <div class="flex gap-3">
                        <a href="{{ route('produk-umkm.edit', $produk->id) }}" 
                           class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg flex items-center transition-colors">
                            <i class="fas fa-edit mr-2"></i>
                            Edit Produk
                        </a>
                        <form action="{{ route('produk-umkm.destroy', $produk->id) }}" method="POST" onsubmit="return confirm('Yakin hapus produk {{ $produk->nama_produk }}?')" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg flex items-center transition-colors">
                                <i class="fas fa-trash mr-2"></i>
                                Hapus Produk
                            </button>
                        </form>
                    </div>
                </div>
                @endauth
            </div>
        </div>
    </div>

    <!-- Related Products Section -->
    <div class="mt-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Produk UMKM Lainnya</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @php
                $relatedProducts = \App\Models\ProdukUmkm::where('id', '!=', $produk->id)->take(4)->get();
            @endphp
            
            @foreach($relatedProducts as $related)
            <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-2 transition-all duration-300 overflow-hidden border border-gray-100">
                <div class="relative overflow-hidden">
                    @if($related->gambar && file_exists(public_path('storage/' . $related->gambar)))
                    <img src="{{ asset('storage/' . $related->gambar) }}" alt="{{ $related->nama_produk }}" class="w-full h-48 object-cover">
                    @elseif($related->gambar)
                    <img src="{{ asset($related->gambar) }}" alt="{{ $related->nama_produk }}" class="w-full h-48 object-cover">
                    @else
                    <div class="w-full h-48 bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                        <i class="fas fa-image text-gray-400 text-4xl"></i>
                    </div>
                    @endif
                </div>
                
                <div class="p-4">
                    <h3 class="font-bold text-lg text-gray-800 mb-2 line-clamp-2">{{ $related->nama_produk }}</h3>
                    <p class="text-gray-600 text-sm mb-4 line-clamp-3">{{ $related->deskripsi }}</p>
                    
                    <div class="flex flex-col gap-2">
                        <a href="https://wa.me/{{ $related->nomor_telepon }}?text=Halo,%20saya%20tertarik%20dengan%20produk%20{{ urlencode($related->nama_produk) }}%20dari%20UMKM%20Desa%20Mekarmukti" 
                           target="_blank" 
                           class="w-full bg-green-500 hover:bg-green-600 text-white font-semibold py-2.5 px-4 rounded-lg flex items-center justify-center transition-all duration-200">
                            <i class="fab fa-whatsapp mr-2"></i>
                            Hubungi
                        </a>
                        <a href="{{ route('produk-umkm.show', $related->id) }}" 
                           class="w-full bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2.5 px-4 rounded-lg flex items-center justify-center transition-all duration-200">
                            <i class="fas fa-eye mr-2"></i>
                            Detail
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
@endsection
