@extends('layout.app')
@section('judul', 'Detail Produk UMKM')
@section('content')
<div class="container py-5">
    <div class="max-w-lg mx-auto bg-white shadow rounded-lg p-6 flex flex-col items-center">
        <img src="{{ asset('storage/' . $produk->gambar) }}" alt="{{ $produk->nama_produk }}" class="w-40 h-40 object-cover rounded mb-3">
        <h2 class="font-bold text-2xl mb-2">{{ $produk->nama_produk }}</h2>
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
</div>
@endsection
