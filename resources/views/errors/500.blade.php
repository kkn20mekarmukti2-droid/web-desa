<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Server Error</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-900 text-gray-100 flex items-center justify-center min-h-screen">
    <div class="text-center">
        <h1 class="text-6xl font-bold text-red-600 mb-4">500</h1>
        <p class="text-xl mb-6">Terjadi kesalahan pada server.</p>
        <p class="text-lg mb-6">Kami sedang memperbaiki masalah ini. Silakan coba lagi nanti.</p>
        @auth
        <p class="text-lg">Jika Anda membutuhkan bantuan segera, <a href="https://facebook.com/rasid369/"
                class="text-blue-400 hover:underline">hubungi Creator</a>.</p>
        @endauth
        <a href="{{ url('/') }}"
            class="mt-4 text-blue-400 hover:underline text-lg">Kembali ke Beranda</a>
    </div>
</body>

</html>
