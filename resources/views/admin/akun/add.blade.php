<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('assets/img/motekar-bg.png') }}" rel="icon">
    <link href="{{ asset('assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">
    <title>Add User</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 p-10">
    <div class="container mx-auto mt-10">
        <h1 class="text-2xl font-bold mb-4">Tambah User</h1>

        @if ($errors->any())
            <div class="bg-red-500 text-white p-4 mb-4 rounded">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('akun.new') }}" method="POST" class="bg-white shadow-md rounded p-4">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Nama</label>
                <input type="text" name="name" value="{{ old('name') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Password</label>
                <input type="password" name="password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Ulangi Password</label>
                <input type="password" name="password_confirmation" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Role</label>
                <select name="role" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    <option value="0">Admin</option>
                    <option value="1">Writer</option>
                </select>
            </div>
            <div class="flex items-center justify-between">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Add User</button>
            </div>
        </form>
    </div>
</body>
</html>
