@extends('layout.app')
@section('judul', 'Produk UMKM Unggulan Desa Mekarmukti')
@section('content')
<div class="container py-5">
    <!-- Header Section -->
    <div class="text-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">🏪 Produk UMKM Unggulan</h1>
        <p class="text-gray-600 text-lg">Dukung produk lokal UMKM Desa Mekarmukti</p>
    </div>

    <!-- Add Product Button (Admin Only) -->
    @auth
    <div class="text-center mb-6">
        <a href="{{ route('produk-umkm.create') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-500 to-purple-600 text-white font-semibold rounded-lg hover:from-blue-600 hover:to-purple-700 transform hover:scale-105 transition-all duration-200 shadow-lg">
            <i class="fas fa-plus mr-2"></i>
            Tambah Produk UMKM
        </a>
    </div>
    @endauth

    <!-- Products Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @forelse($produkList as $produk)
        <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-2 transition-all duration-300 overflow-hidden border border-gray-100">
            <!-- Product Image -->
            <div class="relative overflow-hidden">
                @if($produk->gambar)
                <img src="{{ asset('storage/' . $produk->gambar) }}" alt="{{ $produk->nama_produk }}" class="w-full h-48 object-cover">
                @else
                <div class="w-full h-48 bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                    <i class="fas fa-image text-gray-400 text-4xl"></i>
                </div>
                @endif
                
                <!-- Admin Controls Overlay -->
                @auth
                <div class="absolute top-2 right-2 flex gap-1">
                    <a href="{{ route('produk-umkm.edit', $produk->id) }}" class="bg-blue-500 hover:bg-blue-600 text-white p-2 rounded-full text-xs transition-colors">
                        <i class="fas fa-edit"></i>
                    </a>
                    <form action="{{ route('produk-umkm.destroy', $produk->id) }}" method="POST" onsubmit="return confirm('Yakin hapus produk {{ $produk->nama_produk }}?')" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white p-2 rounded-full text-xs transition-colors">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </div>
                @endauth
            </div>

            <!-- Product Info -->
            <div class="p-4">
                <h3 class="font-bold text-lg text-gray-800 mb-2 line-clamp-2">{{ $produk->nama_produk }}</h3>
                <p class="text-gray-600 text-sm mb-4 line-clamp-3">{{ $produk->deskripsi }}</p>
                
                <!-- Action Buttons -->
                <div class="flex flex-col gap-2">
                    <a href="https://wa.me/{{ $produk->nomor_telepon }}?text=Halo,%20saya%20tertarik%20dengan%20produk%20{{ urlencode($produk->nama_produk) }}%20dari%20UMKM%20Desa%20Mekarmukti" 
                       target="_blank" 
                       class="w-full bg-green-500 hover:bg-green-600 text-white font-semibold py-2.5 px-4 rounded-lg flex items-center justify-center transition-all duration-200 transform hover:scale-105">
                        <i class="fab fa-whatsapp mr-2"></i>
                        Hubungi Penjual
                    </a>
                    <a href="{{ route('produk-umkm.show', $produk->id) }}" 
                       class="w-full bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2.5 px-4 rounded-lg flex items-center justify-center transition-all duration-200">
                        <i class="fas fa-eye mr-2"></i>
                        Lihat Detail
                    </a>
                </div>
            </div>
        </div>
        @empty
        <!-- Empty State -->
        <div class="col-span-full text-center py-16">
            <div class="bg-gray-50 rounded-xl p-8 max-w-md mx-auto">
                <i class="fas fa-store text-gray-300 text-6xl mb-4"></i>
                <h3 class="text-xl font-semibold text-gray-600 mb-2">Belum Ada Produk UMKM</h3>
                <p class="text-gray-500 mb-4">Belum ada produk UMKM yang ditambahkan ke dalam sistem.</p>
                @auth
                <a href="{{ route('produk-umkm.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors">
                    <i class="fas fa-plus mr-2"></i>
                    Tambah Produk Pertama
                </a>
                @endauth
            </div>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($produkList->hasPages())
    <div class="mt-8 flex justify-center">
        <div class="bg-white rounded-lg shadow p-1">
            {{ $produkList->links() }}
        </div>
    </div>
    @endif
</div>

<!-- Custom CSS for better styling -->
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

/* Hover effects */
.product-card {
    transition: all 0.3s ease;
}

.product-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
}
</style>
@endsection
