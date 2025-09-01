@extends('layout.app')
@section('judul', 'Tambah Produk UMKM')
@section('content')
<div class="container py-5">
    <h2 class="text-center font-bold text-2xl mb-6">Tambah Produk UMKM</h2>
    <form action="{{ route('produk-umkm.store') }}" method="POST" enctype="multipart/form-data" class="max-w-lg mx-auto bg-white shadow rounded-lg p-6">
        @csrf
        <div class="mb-4">
            <label for="nama_produk" class="block font-semibold mb-1">Nama Produk</label>
            <input type="text" name="nama_produk" id="nama_produk" class="w-full border rounded px-3 py-2" required>
        </div>
        <div class="mb-4">
            <label for="deskripsi" class="block font-semibold mb-1">Deskripsi</label>
            <textarea name="deskripsi" id="deskripsi" class="w-full border rounded px-3 py-2" required></textarea>
        </div>
        <div class="mb-4">
            <label for="gambar" class="block font-semibold mb-1">Gambar Produk</label>
            <input type="file" name="gambar" id="gambar" class="w-full border rounded px-3 py-2">
        </div>
        <div class="mb-4">
            <label for="nomor_telepon" class="block font-semibold mb-1">Nomor Telepon UMKM (untuk WhatsApp)</label>
            <input type="text" name="nomor_telepon" id="nomor_telepon" class="w-full border rounded px-3 py-2" required placeholder="Contoh: 6281234567890">
        </div>
        <button type="submit" class="bg-primary-600 text-white px-6 py-2 rounded">Simpan Produk</button>
    </form>
</div>
@endsection
