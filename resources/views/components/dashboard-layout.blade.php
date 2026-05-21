<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Dashboard' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-100 min-h-screen">
    <div class="min-h-screen md:flex">
        <aside class="hidden md:flex md:flex-col md:w-64 bg-slate-900 text-white fixed inset-y-0 left-0 z-40">
            <div class="px-6 py-5 border-b border-slate-800">
                <h1 class="text-base font-bold">Peminjaman Barang</h1>
                <p class="text-xs text-slate-300 mt-1">{{ auth()->user()->name }}</p>
                <p class="text-[11px] text-slate-500">{{ auth()->user()->role }}</p>
            </div>

            <nav class="flex-1 overflow-y-auto px-4 py-4 space-y-2">
                <a href="{{ route('dashboard') }}" class="block text-sm px-4 py-2.5 rounded-xl hover:bg-slate-800 transition">Dashboard</a>
                <a href="{{ route('jurusan.index') }}" class="block text-sm px-4 py-2.5 rounded-xl hover:bg-slate-800 transition">Jurusan</a>

                @if(auth()->user()->isSuperadmin() || auth()->user()->isAdminJurusan())
                    <a href="{{ route('management-user.index') }}" class="block text-sm px-4 py-2.5 rounded-xl hover:bg-slate-800 transition">Management User</a>
                    <a href="{{ route('kategori.index') }}" class="block text-sm px-4 py-2.5 rounded-xl hover:bg-slate-800 transition">Kategori</a>
                    <a href="{{ route('barang.index') }}" class="block text-sm px-4 py-2.5 rounded-xl hover:bg-slate-800 transition">Barang</a>
                    <a href="{{ route('peminjaman.index') }}" class="block text-sm px-4 py-2.5 rounded-xl hover:bg-slate-800 transition">Peminjaman</a>
                    <a href="{{ route('pengembalian.index') }}" class="block text-sm px-4 py-2.5 rounded-xl hover:bg-slate-800 transition">Pengembalian</a>
                    <a href="{{ route('riwayat.index') }}" class="block text-sm px-4 py-2.5 rounded-xl hover:bg-slate-800 transition">Riwayat</a>
                @endif

                @if(auth()->user()->isPeminjam())
                    <a href="{{ route('peminjaman.create') }}" class="block text-sm px-4 py-2.5 rounded-xl hover:bg-slate-800 transition">Ajukan Peminjaman</a>
                    <a href="{{ route('peminjaman.index') }}" class="block text-sm px-4 py-2.5 rounded-xl hover:bg-slate-800 transition">Status Peminjaman</a>
                    <a href="{{ route('riwayat.index') }}" class="block text-sm px-4 py-2.5 rounded-xl hover:bg-slate-800 transition">Riwayat Peminjaman</a>
                    <a href="{{ route('riwayat.index') }}" class="block text-sm px-4 py-2.5 rounded-xl hover:bg-slate-800 transition">Riwayat Pengembalian</a>
                @endif

                <a href="{{ route('profil.edit') }}" class="block text-sm px-4 py-2.5 rounded-xl hover:bg-slate-800 transition">Profil</a>
            </nav>

            <div class="p-4 border-t border-slate-800">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full px-4 py-2.5 bg-red-500 hover:bg-red-600 rounded-xl text-sm font-medium transition">
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        <main class="flex-1 md:ml-64 p-6">
            <div class="mb-6">
                <h2 class="text-3xl font-bold text-slate-800">{{ $title ?? 'Dashboard' }}</h2>
                <p class="text-sm text-slate-600">Selamat datang, {{ auth()->user()->name }}</p>
            </div>

            {{ $slot }}
        </main>
    </div>
</body>
</html>