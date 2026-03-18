<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Dashboard' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-100 min-h-screen">
    <div class="flex min-h-screen">
        <aside class="w-64 bg-slate-900 text-white hidden md:flex md:flex-col">
            <div class="px-6 py-5 border-b border-slate-800">
                <h1 class="text-lg font-bold">Peminjaman Barang</h1>
                <p class="text-sm text-slate-400 mt-1">{{ auth()->user()->name }}</p>
                <p class="text-xs text-slate-500">{{ auth()->user()->role }}</p>
            </div>

            <nav class="flex-1 px-4 py-4 space-y-2">
                <a href="{{ route('dashboard') }}" class="block px-4 py-2 rounded-lg hover:bg-slate-800">Dashboard</a>

                @if(auth()->user()->isSuperadmin())
                    <a href="#" class="block px-4 py-2 rounded-lg hover:bg-slate-800">Jurusan</a>
                @endif

                @if(auth()->user()->isSuperadmin() || auth()->user()->isAdminJurusan())
                    <a href="{{ route('management-user.index') }}"
                        class="block px-4 py-2 rounded-lg hover:bg-slate-800">Management User</a>
                    <a href="{{ route('kategori.index') }}"
                        class="block px-4 py-2 rounded-lg hover:bg-slate-800">Kategori</a>
                    <a href="{{ route('barang.index') }}" class="block px-4 py-2 rounded-lg hover:bg-slate-800">Barang</a>
                    <a href="#" class="block px-4 py-2 rounded-lg hover:bg-slate-800">Peminjaman</a>
                    <a href="#" class="block px-4 py-2 rounded-lg hover:bg-slate-800">Pengembalian</a>
                    <a href="#" class="block px-4 py-2 rounded-lg hover:bg-slate-800">Riwayat</a>
                @endif

                @if(auth()->user()->isPeminjam())
                    <a href="#" class="block px-4 py-2 rounded-lg hover:bg-slate-800">Ajukan Peminjaman</a>
                    <a href="#" class="block px-4 py-2 rounded-lg hover:bg-slate-800">Status Peminjaman</a>
                    <a href="#" class="block px-4 py-2 rounded-lg hover:bg-slate-800">Riwayat Peminjaman</a>
                    <a href="#" class="block px-4 py-2 rounded-lg hover:bg-slate-800">Riwayat Pengembalian</a>
                @endif

                <a href="{{ route('profil.edit') }}" class="block px-4 py-2 rounded-lg hover:bg-slate-800">Profil</a>
            </nav>

            <div class="p-4 border-t border-slate-800">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full px-4 py-2 bg-red-500 hover:bg-red-600 rounded-lg text-sm font-medium">
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        <main class="flex-1 p-6">
            <div class="mb-6">
                <h2 class="text-2xl font-bold text-slate-800">{{ $title ?? 'Dashboard' }}</h2>
                <p class="text-sm text-slate-500">Selamat datang, {{ auth()->user()->name }}</p>
            </div>

            {{ $slot }}
        </main>
    </div>
</body>

</html>