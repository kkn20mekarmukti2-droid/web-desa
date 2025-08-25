<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('assets/img/motekar-bg.png') }}" rel="icon">
    <link href="{{ asset('assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">
    <title>Tambah RT</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 p-10">
    <div class="container mx-auto mt-28">
        <h1 class="text-2xl font-bold mb-4">Tambah RT</h1>

        @if ($errors->any())
            <div class="bg-red-500 text-white p-4 mb-4 rounded">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('rt.store') }}" method="POST" enctype="multipart/form-data" class="bg-white shadow-md rounded p-4">
            @csrf
            <input type="hidden" name="rw" value="{{ $rw->rw }}">
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Nama</label>
                <input type="text" name="nama" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">RT</label>
                <input type="number" name="rt" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Kontak</label>
                <input type="text" name="kontak" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Foto</label>
                <input type="file" name="foto" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            <div class="flex items-center justify-between">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Simpan</button>
            </div>
        </form>
    </div>
</body>
</html>
