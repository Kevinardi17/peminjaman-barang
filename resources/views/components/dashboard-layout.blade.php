<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Dashboard' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-100 min-h-screen relative">
    @if(session('login_success'))
        <div id="login-toast" class="fixed top-5 left-1/2 -translate-x-1/2 z-50 flex items-center w-full max-w-sm p-4 space-x-3 text-slate-800 bg-white rounded-2xl shadow-lg border border-slate-100 transition-opacity duration-500" role="alert">
            <div class="inline-flex items-center justify-center flex-shrink-0 w-10 h-10 text-green-500 bg-green-100 rounded-xl">
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
                </svg>
                <span class="sr-only">Success icon</span>
            </div>
            <div class="ml-3 text-sm font-semibold">{{ session('login_success') }}</div>
            <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-white text-slate-400 hover:text-slate-900 rounded-lg p-1.5 hover:bg-slate-100 inline-flex items-center justify-center h-8 w-8" onclick="document.getElementById('login-toast').remove()">
                <span class="sr-only">Close</span>
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
            </button>
        </div>
        <script>
            setTimeout(() => {
                const toast = document.getElementById('login-toast');
                if (toast) {
                    toast.style.opacity = '0';
                    setTimeout(() => toast.remove(), 500);
                }
            }, 3000);
        </script>
    @endif

    <div class="min-h-screen md:flex">
        <aside class="hidden md:flex md:flex-col md:w-64 bg-slate-900 text-white fixed inset-y-0 left-0 z-40">
            <div class="px-6 py-5 border-b border-slate-800">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo SMK N 5 Bandar Lampung" class="h-12 w-12 rounded-md object-cover bg-transparent" />
                    <div>
                        <h1 class="text-lg font-bold leading-tight">Peminjaman Barang</h1>
                        <p class="text-sm text-slate-300">SMK N 5 Bandar Lampung</p>
                    </div>
                </div>
            </div>

            <nav class="flex-1 overflow-y-auto px-4 py-4 space-y-4">
                <div class="space-y-1">
                    <button type="button" class="w-full flex items-center justify-between px-4 py-2 text-xs font-semibold uppercase tracking-wider text-slate-400 rounded-xl hover:bg-slate-800 transition" data-toggle="menu" data-target="menu-main" aria-expanded="false">
                        Main Menu
                        <span class="text-slate-200">+</span>
                    </button>
                    <div id="menu-main" class="space-y-1 hidden pl-4">
                        <a href="{{ route('dashboard') }}" class="block px-4 py-2.5 rounded-xl hover:bg-slate-800 transition">Dashboard</a>
                    </div>
                </div>

                @if(auth()->user()->isSuperadmin() || auth()->user()->isAdminJurusan())
                    <div class="space-y-1">
                        <button type="button" class="w-full flex items-center justify-between px-4 py-2 text-xs font-semibold uppercase tracking-wider text-slate-400 rounded-xl hover:bg-slate-800 transition" data-toggle="menu" data-target="menu-master-data" aria-expanded="false">
                            Master Data
                            <span class="text-slate-200">+</span>
                        </button>
                        <div id="menu-master-data" class="space-y-1 hidden pl-4">
                            <a href="{{ route('jurusan.index') }}" class="block px-4 py-2.5 rounded-xl hover:bg-slate-800 transition">Jurusan</a>
                            <a href="{{ route('kategori.index') }}" class="block px-4 py-2.5 rounded-xl hover:bg-slate-800 transition">Kategori</a>
                            <a href="{{ route('barang.index') }}" class="block px-4 py-2.5 rounded-xl hover:bg-slate-800 transition">Barang</a>
                        </div>
                    </div>
                @endif

                @if(auth()->user()->isSuperadmin() || auth()->user()->isAdminJurusan() || auth()->user()->isPeminjam())
                    <div class="space-y-1">
                        <button type="button" class="w-full flex items-center justify-between px-4 py-2 text-xs font-semibold uppercase tracking-wider text-slate-400 rounded-xl hover:bg-slate-800 transition" data-toggle="menu" data-target="menu-transaksi" aria-expanded="false">
                            Transaksi
                            <span class="text-slate-200">+</span>
                        </button>
                        <div id="menu-transaksi" class="space-y-1 hidden pl-4">
                            @if(auth()->user()->isSuperadmin() || auth()->user()->isAdminJurusan())
                                <a href="{{ route('peminjaman.index') }}" class="block px-4 py-2.5 rounded-xl hover:bg-slate-800 transition">Peminjaman</a>
                                <a href="{{ route('pengembalian.index') }}" class="block px-4 py-2.5 rounded-xl hover:bg-slate-800 transition">Pengembalian</a>
                                <a href="{{ route('riwayat.index') }}" class="block px-4 py-2.5 rounded-xl hover:bg-slate-800 transition">Riwayat</a>
                            @endif
                            @if(auth()->user()->isPeminjam())
                                <a href="{{ route('peminjaman.create') }}" class="block px-4 py-2.5 rounded-xl hover:bg-slate-800 transition">Ajukan Peminjaman</a>
                                <a href="{{ route('peminjaman.index') }}" class="block px-4 py-2.5 rounded-xl hover:bg-slate-800 transition">Status Peminjaman</a>
                                <a href="{{ route('riwayat.index') }}" class="block px-4 py-2.5 rounded-xl hover:bg-slate-800 transition">Riwayat Peminjaman</a>
                                <a href="{{ route('riwayat.index') }}" class="block px-4 py-2.5 rounded-xl hover:bg-slate-800 transition">Riwayat Pengembalian</a>
                            @endif
                        </div>
                    </div>
                @endif

                <div class="space-y-1">
                    <button type="button" class="w-full flex items-center justify-between px-4 py-2 text-xs font-semibold uppercase tracking-wider text-slate-400 rounded-xl hover:bg-slate-800 transition" data-toggle="menu" data-target="menu-settings" aria-expanded="false">
                        Pengaturan
                        <span class="text-slate-200">+</span>
                    </button>
                    <div id="menu-settings" class="space-y-1 hidden pl-4">
                        @if(auth()->user()->isSuperadmin() || auth()->user()->isAdminJurusan())
                            <a href="{{ route('management-user.index') }}" class="block px-4 py-2.5 rounded-xl hover:bg-slate-800 transition">Management User</a>
                        @endif
                        <a href="{{ route('profil.edit') }}" class="block px-4 py-2.5 rounded-xl hover:bg-slate-800 transition">Profil</a>
                    </div>
                </div>
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
            <div class="mb-6 flex justify-between items-center gap-4">
                <h2 class="text-2xl font-bold text-slate-800">{{ $title ?? 'Dashboard' }}</h2>

                <!-- Profile Shortcut -->
                <a href="{{ route('profil.edit') }}" class="flex items-center gap-3 bg-white hover:bg-slate-50 p-2 pr-4 rounded-full transition shadow-sm border border-slate-200 group">
                    <div class="w-10 h-10 rounded-full bg-slate-800 text-white flex items-center justify-center font-bold overflow-hidden shadow-inner">
                        @if(auth()->user()->profile_photo_path)
                            <img src="{{ asset('storage/' . auth()->user()->profile_photo_path) }}" alt="Foto Profil" class="w-full h-full object-cover group-hover:scale-110 transition-transform">
                        @else
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=0f172a&color=fff&bold=true" alt="Avatar" class="w-full h-full object-cover group-hover:scale-110 transition-transform">
                        @endif
                    </div>
                    <div class="text-left hidden sm:block">
                        <p class="text-sm font-bold text-slate-800 leading-tight">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-slate-500 capitalize">{{ str_replace('_', ' ', auth()->user()->role) }}</p>
                    </div>
                </a>
            </div>

            {{ $slot }}
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('[data-toggle="menu"]').forEach(function (button) {
                button.addEventListener('click', function () {
                    var targetId = button.getAttribute('data-target');
                    var panel = document.getElementById(targetId);
                    if (!panel) {
                        return;
                    }
                    var expanded = button.getAttribute('aria-expanded') === 'true';
                    panel.classList.toggle('hidden');
                    button.setAttribute('aria-expanded', String(!expanded));
                    var icon = button.querySelector('span');
                    if (icon) {
                        icon.textContent = expanded ? '+' : '−';
                    }
                });
            });
        });
    </script>
</body>
</html>