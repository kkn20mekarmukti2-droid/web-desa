@extends('layout.app')
@section('judul', 'Produk UMKM Unggulan Desa Mekarmukti')
@section('content')
<div class="container py-5">
    <h2 class="text-center font-bold text-2xl mb-6">Produk UMKM Unggulan</h2>
    <div class="flex flex-wrap justify-center gap-8">
        @forelse($produkList as $produk)
        <div class="bg-white shadow rounded-lg p-4 w-full md:w-96 lg:w-80 flex flex-col items-center">
            <img src="{{ asset('storage/' . $produk->gambar) }}" alt="{{ $produk->nama_produk }}" class="w-32 h-32 object-cover rounded mb-3">
            <h3 class="font-semibold text-lg mb-2">{{ $produk->nama_produk }}</h3>
            <p class="text-gray-700 mb-2">{{ $produk->deskripsi }}</p>
            <a href="https://wa.me/{{ $produk->nomor_telepon }}" target="_blank" class="bg-green-600 text-white px-4 py-2 rounded mt-2">Hubungi via WhatsApp</a>
            @auth
            <div class="flex gap-2 mt-3">
                <a href="{{ route('produk-umkm.edit', $produk->id) }}" class="text-blue-600">Edit</a>
                <form action="{{ route('produk-umkm.destroy', $produk->id) }}" method="POST" onsubmit="return confirm('Yakin hapus produk?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-600">Hapus</button>
                </form>
            </div>
            @endauth
        </div>
        @empty
        <div class="text-center text-gray-500">Belum ada produk UMKM yang ditambahkan.</div>
        @endforelse
    </div>
    <div class="mt-6 flex justify-center">{{ $produkList->links() }}</div>
    @auth
    <div class="mt-8 text-center">
        <a href="{{ route('produk-umkm.create') }}" class="bg-primary-600 text-white px-6 py-2 rounded">Tambah Produk UMKM</a>
    </div>
    @endauth
</div>
@endsection
