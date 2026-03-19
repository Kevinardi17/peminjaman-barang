<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Sistem Peminjaman Barang') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-200">
    <div class="min-h-screen flex items-center justify-center px-4 py-10">
        {{ $slot }}
    </div>
</body>
</html>