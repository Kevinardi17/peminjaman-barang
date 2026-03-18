<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Peminjaman Barang') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-100 flex items-center justify-center">
    <div class="bg-white shadow rounded-2xl p-8 w-full max-w-xl text-center">
        <h1 class="text-3xl font-bold text-slate-800 mb-3">Sistem Peminjaman Barang</h1>
        <p class="text-slate-500 mb-6">SMKN 5 Bandar Lampung</p>

        <div class="flex items-center justify-center gap-3">
            @auth
                <a href="{{ route('dashboard') }}"
                   class="px-5 py-2 bg-slate-900 text-white rounded-lg hover:bg-slate-800">
                    Dashboard
                </a>
            @else
                <a href="{{ route('login') }}"
                   class="px-5 py-2 bg-slate-900 text-white rounded-lg hover:bg-slate-800">
                    Login
                </a>

                <a href="{{ route('register') }}"
                   class="px-5 py-2 bg-slate-200 text-slate-800 rounded-lg hover:bg-slate-300">
                    Register
                </a>
            @endauth
        </div>
    </div>
</body>
</html>