<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Dashboard' }}</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* Custom scrollbar for sidebar */
        .sidebar-scroll::-webkit-scrollbar { width: 4px; }
        .sidebar-scroll::-webkit-scrollbar-track { background: transparent; }
        .sidebar-scroll::-webkit-scrollbar-thumb { background: #334155; border-radius: 4px; }
    </style>
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

    <div x-data="{ sidebarOpen: window.innerWidth >= 768, sidebarCollapsed: false }" class="min-h-screen flex">
        <!-- Overlay/Backdrop for mobile -->
        <div x-show="sidebarOpen && window.innerWidth < 768" x-transition.opacity style="display: none;" @click="sidebarOpen = false" class="fixed inset-0 z-30 bg-slate-900/50 backdrop-blur-sm md:hidden"></div>

        <aside :class="[sidebarOpen ? 'translate-x-0' : '-translate-x-full', sidebarCollapsed ? 'md:w-20' : 'md:w-72', 'w-72']" class="flex flex-col bg-[#111827] text-slate-300 fixed inset-y-0 left-0 z-40 transition-all duration-300 ease-in-out shadow-2xl border-r border-slate-800/60">
            <div class="px-4 py-6 border-b border-slate-800/60 flex items-center justify-between" :class="sidebarCollapsed ? 'justify-center px-2' : ''">
                <div class="flex items-center gap-3 cursor-pointer overflow-hidden" @click="sidebarCollapsed = false">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-9 w-9 shrink-0 rounded-md object-cover bg-transparent" />
                    <div x-show="!sidebarCollapsed" class="transition-opacity duration-300 overflow-hidden">
                        <h1 class="text-[15px] font-bold text-white leading-tight truncate">Peminjaman Barang</h1>
                        <p class="text-[11px] text-slate-400 truncate mt-0.5">SMK N 5 Bandar Lampung</p>
                    </div>
                </div>
                <!-- Tombol Minimize Sidebar -->
                <button @click="sidebarCollapsed = true" x-show="!sidebarCollapsed" class="hidden md:flex items-center justify-center p-1.5 rounded-lg text-slate-400 hover:text-white hover:bg-slate-800 transition focus:outline-none shrink-0" title="Minimize Sidebar">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18.75 19.5l-7.5-7.5 7.5-7.5m-6 15L5.25 12l7.5-7.5" />
                    </svg>
                </button>
                <!-- Mobile close button -->
                <button @click="sidebarOpen = false" class="md:hidden p-1.5 rounded-lg text-slate-400 hover:text-white hover:bg-slate-800 transition focus:outline-none shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>

            <nav class="flex-1 overflow-y-auto sidebar-scroll px-3 py-4 space-y-2">
                @php
                    $isMainActive = request()->routeIs('dashboard');
                    $isMasterActive = request()->routeIs('jurusan.*') || request()->routeIs('kategori.*') || request()->routeIs('barang.*');
                    $isTransaksiActive = request()->routeIs('peminjaman.*') || request()->routeIs('pengembalian.*') || request()->routeIs('riwayat.*');
                    $isPengaturanActive = request()->routeIs('management-user.*') || request()->routeIs('profil.*');
                @endphp

                <!-- Main Menu -->
                <div class="space-y-1 relative">
                    <button type="button" @click="if(sidebarCollapsed) sidebarCollapsed = false; else toggleMenu($event.currentTarget)" class="w-full flex items-center justify-between px-3 py-2.5 text-sm font-medium tracking-wide rounded-xl transition border {{ $isMainActive ? 'bg-blue-600/20 border-blue-500/50 text-yellow-400' : 'text-slate-300 border-transparent hover:bg-slate-800' }}" data-target="menu-main" aria-expanded="{{ $isMainActive ? 'true' : 'false' }}" :class="sidebarCollapsed ? 'justify-center' : ''" title="Main Menu">
                        <div class="flex items-center gap-3">
                            <svg class="w-6 h-6 shrink-0 {{ $isMainActive ? 'text-yellow-400' : 'text-slate-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" /></svg>
                            <span x-show="!sidebarCollapsed" class="whitespace-nowrap transition-opacity font-semibold">Main Menu</span>
                        </div>
                        <span x-show="!sidebarCollapsed" class="transition-transform duration-200 {{ $isMainActive ? 'rotate-180' : '' }}">
                            <svg class="w-4 h-4 {{ $isMainActive ? 'text-yellow-400' : 'text-slate-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" /></svg>
                        </span>
                    </button>
                    <div id="menu-main" class="{{ $isMainActive ? 'block' : 'hidden' }} px-3 py-2 mt-1 space-y-1 border border-slate-700 bg-slate-800/30 rounded-xl" x-show="!sidebarCollapsed">
                        <a href="{{ route('dashboard') }}" class="flex items-center gap-2 px-3 py-2 text-sm {{ request()->routeIs('dashboard') ? 'text-white font-semibold' : 'text-slate-400 hover:text-white' }} rounded-lg hover:bg-slate-700/50 transition">
                            <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
                            <span class="whitespace-nowrap">Dashboard</span>
                        </a>
                    </div>
                </div>

                <!-- Master Data -->
                @if(auth()->user()->isSuperadmin() || auth()->user()->isAdminJurusan())
                <div class="space-y-1 relative">
                    <button type="button" @click="if(sidebarCollapsed) sidebarCollapsed = false; else toggleMenu($event.currentTarget)" class="w-full flex items-center justify-between px-3 py-2.5 text-sm font-medium tracking-wide rounded-xl transition border {{ $isMasterActive ? 'bg-blue-600/20 border-blue-500/50 text-yellow-400' : 'text-slate-300 border-transparent hover:bg-slate-800' }}" data-target="menu-master" aria-expanded="{{ $isMasterActive ? 'true' : 'false' }}" :class="sidebarCollapsed ? 'justify-center' : ''" title="Master Data">
                        <div class="flex items-center gap-3">
                            <svg class="w-6 h-6 shrink-0 {{ $isMasterActive ? 'text-yellow-400' : 'text-slate-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4" /></svg>
                            <span x-show="!sidebarCollapsed" class="whitespace-nowrap transition-opacity font-semibold">Master Data</span>
                        </div>
                        <span x-show="!sidebarCollapsed" class="transition-transform duration-200 {{ $isMasterActive ? 'rotate-180' : '' }}">
                            <svg class="w-4 h-4 {{ $isMasterActive ? 'text-yellow-400' : 'text-slate-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" /></svg>
                        </span>
                    </button>
                    <div id="menu-master" class="{{ $isMasterActive ? 'block' : 'hidden' }} px-3 py-2 mt-1 space-y-1 border border-slate-700 bg-slate-800/30 rounded-xl" x-show="!sidebarCollapsed">
                        @if(auth()->user()->isSuperadmin())
                        <a href="{{ route('jurusan.index') }}" class="flex items-center gap-2 px-3 py-2 text-sm {{ request()->routeIs('jurusan.*') ? 'text-white font-semibold' : 'text-slate-400 hover:text-white' }} rounded-lg hover:bg-slate-700/50 transition">
                            <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
                            <span class="whitespace-nowrap">Jurusan</span>
                        </a>
                        @endif
                        <a href="{{ route('kategori.index') }}" class="flex items-center gap-2 px-3 py-2 text-sm {{ request()->routeIs('kategori.*') ? 'text-white font-semibold' : 'text-slate-400 hover:text-white' }} rounded-lg hover:bg-slate-700/50 transition">
                            <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
                            <span class="whitespace-nowrap">Kategori</span>
                        </a>
                        <a href="{{ route('barang.index') }}" class="flex items-center gap-2 px-3 py-2 text-sm {{ request()->routeIs('barang.*') ? 'text-white font-semibold' : 'text-slate-400 hover:text-white' }} rounded-lg hover:bg-slate-700/50 transition">
                            <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
                            <span class="whitespace-nowrap">Barang</span>
                        </a>
                    </div>
                </div>
                @endif

                <!-- Transaksi -->
                @if(auth()->user()->isSuperadmin() || auth()->user()->isAdminJurusan() || auth()->user()->isPeminjam())
                <div class="space-y-1 relative">
                    <button type="button" @click="if(sidebarCollapsed) sidebarCollapsed = false; else toggleMenu($event.currentTarget)" class="w-full flex items-center justify-between px-3 py-2.5 text-sm font-medium tracking-wide rounded-xl transition border {{ $isTransaksiActive ? 'bg-blue-600/20 border-blue-500/50 text-yellow-400' : 'text-slate-300 border-transparent hover:bg-slate-800' }}" data-target="menu-transaksi" aria-expanded="{{ $isTransaksiActive ? 'true' : 'false' }}" :class="sidebarCollapsed ? 'justify-center' : ''" title="Transaksi">
                        <div class="flex items-center gap-3">
                            <svg class="w-6 h-6 shrink-0 {{ $isTransaksiActive ? 'text-yellow-400' : 'text-slate-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                            <span x-show="!sidebarCollapsed" class="whitespace-nowrap transition-opacity font-semibold">Transaksi</span>
                        </div>
                        <span x-show="!sidebarCollapsed" class="transition-transform duration-200 {{ $isTransaksiActive ? 'rotate-180' : '' }}">
                            <svg class="w-4 h-4 {{ $isTransaksiActive ? 'text-yellow-400' : 'text-slate-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" /></svg>
                        </span>
                    </button>
                    <div id="menu-transaksi" class="{{ $isTransaksiActive ? 'block' : 'hidden' }} px-3 py-2 mt-1 space-y-1 border border-slate-700 bg-slate-800/30 rounded-xl" x-show="!sidebarCollapsed">
                        @if(auth()->user()->isSuperadmin() || auth()->user()->isAdminJurusan())
                        <a href="{{ route('peminjaman.index') }}" class="flex items-center gap-2 px-3 py-2 text-sm {{ request()->routeIs('peminjaman.*') ? 'text-white font-semibold' : 'text-slate-400 hover:text-white' }} rounded-lg hover:bg-slate-700/50 transition">
                            <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
                            <span class="whitespace-nowrap">Peminjaman</span>
                        </a>
                        <a href="{{ route('pengembalian.index') }}" class="flex items-center gap-2 px-3 py-2 text-sm {{ request()->routeIs('pengembalian.*') ? 'text-white font-semibold' : 'text-slate-400 hover:text-white' }} rounded-lg hover:bg-slate-700/50 transition">
                            <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
                            <span class="whitespace-nowrap">Pengembalian</span>
                        </a>
                        <a href="{{ route('riwayat.index') }}" class="flex items-center gap-2 px-3 py-2 text-sm {{ request()->routeIs('riwayat.*') ? 'text-white font-semibold' : 'text-slate-400 hover:text-white' }} rounded-lg hover:bg-slate-700/50 transition">
                            <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
                            <span class="whitespace-nowrap">Riwayat</span>
                        </a>
                        @endif
                        @if(auth()->user()->isPeminjam())
                        <a href="{{ route('peminjaman.create') }}" class="flex items-center gap-2 px-3 py-2 text-sm {{ request()->routeIs('peminjaman.create') ? 'text-white font-semibold' : 'text-slate-400 hover:text-white' }} rounded-lg hover:bg-slate-700/50 transition">
                            <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
                            <span class="whitespace-nowrap">Ajukan Peminjaman</span>
                        </a>
                        <a href="{{ route('peminjaman.index') }}" class="flex items-center gap-2 px-3 py-2 text-sm {{ request()->routeIs('peminjaman.index') ? 'text-white font-semibold' : 'text-slate-400 hover:text-white' }} rounded-lg hover:bg-slate-700/50 transition">
                            <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
                            <span class="whitespace-nowrap">Status Peminjaman</span>
                        </a>
                        <a href="{{ route('riwayat.index') }}" class="flex items-center gap-2 px-3 py-2 text-sm {{ request()->routeIs('riwayat.*') ? 'text-white font-semibold' : 'text-slate-400 hover:text-white' }} rounded-lg hover:bg-slate-700/50 transition">
                            <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
                            <span class="whitespace-nowrap">Riwayat</span>
                        </a>
                        @endif
                    </div>
                </div>
                @endif

                <!-- Pengaturan -->
                <div class="space-y-1 relative">
                    <button type="button" @click="if(sidebarCollapsed) sidebarCollapsed = false; else toggleMenu($event.currentTarget)" class="w-full flex items-center justify-between px-3 py-2.5 text-sm font-medium tracking-wide rounded-xl transition border {{ $isPengaturanActive ? 'bg-blue-600/20 border-blue-500/50 text-yellow-400' : 'text-slate-300 border-transparent hover:bg-slate-800' }}" data-target="menu-settings" aria-expanded="{{ $isPengaturanActive ? 'true' : 'false' }}" :class="sidebarCollapsed ? 'justify-center' : ''" title="Pengaturan">
                        <div class="flex items-center gap-3">
                            <svg class="w-6 h-6 shrink-0 {{ $isPengaturanActive ? 'text-yellow-400' : 'text-slate-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                            <span x-show="!sidebarCollapsed" class="whitespace-nowrap transition-opacity font-semibold">Pengaturan</span>
                        </div>
                        <span x-show="!sidebarCollapsed" class="transition-transform duration-200 {{ $isPengaturanActive ? 'rotate-180' : '' }}">
                            <svg class="w-4 h-4 {{ $isPengaturanActive ? 'text-yellow-400' : 'text-slate-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" /></svg>
                        </span>
                    </button>
                    <div id="menu-settings" class="{{ $isPengaturanActive ? 'block' : 'hidden' }} px-3 py-2 mt-1 space-y-1 border border-slate-700 bg-slate-800/30 rounded-xl" x-show="!sidebarCollapsed">
                        @if(auth()->user()->isSuperadmin() || auth()->user()->isAdminJurusan())
                        <a href="{{ route('management-user.index') }}" class="flex items-center gap-2 px-3 py-2 text-sm {{ request()->routeIs('management-user.*') ? 'text-white font-semibold' : 'text-slate-400 hover:text-white' }} rounded-lg hover:bg-slate-700/50 transition">
                            <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
                            <span class="whitespace-nowrap">Management User</span>
                        </a>
                        @endif
                        <a href="{{ route('profil.edit') }}" class="flex items-center gap-2 px-3 py-2 text-sm {{ request()->routeIs('profil.*') ? 'text-white font-semibold' : 'text-slate-400 hover:text-white' }} rounded-lg hover:bg-slate-700/50 transition">
                            <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
                            <span class="whitespace-nowrap">Profil</span>
                        </a>
                    </div>
                </div>

            </nav>

            <div class="p-4 border-t border-slate-800/60">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center px-4 py-2.5 bg-slate-800/50 hover:bg-red-500/10 border border-slate-700/50 hover:border-red-500/50 text-slate-300 hover:text-red-500 rounded-xl text-sm font-semibold transition-all duration-200" title="Keluar">
                        <svg x-show="sidebarCollapsed" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" /></svg>
                        <span x-show="!sidebarCollapsed">Keluar</span>
                    </button>
                </form>
            </div>
        </aside>

        <main :class="[sidebarOpen ? (sidebarCollapsed ? 'md:ml-20' : 'md:ml-72') : 'ml-0']" class="flex-1 p-4 md:p-6 w-full max-w-full overflow-x-hidden transition-all duration-300 ease-in-out">
            <div class="mb-6 flex justify-between items-center gap-4">
                <div class="flex items-center gap-3">
                    <!-- Hamburger Button -->
                    <button x-show="!sidebarOpen" @click="sidebarOpen = true" class="p-2 bg-white rounded-lg border border-slate-200 text-slate-600 hover:bg-slate-50 transition shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                        </svg>
                    </button>
                    <h2 class="text-xl md:text-2xl font-bold text-slate-800">{{ $title ?? 'Dashboard' }}</h2>
                </div>

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
        function toggleMenu(button) {
            var targetId = button.getAttribute('data-target');
            var panel = document.getElementById(targetId);
            if (!panel) return;
            var expanded = button.getAttribute('aria-expanded') === 'true';
            
            if (expanded) {
                panel.classList.remove('block');
                panel.classList.add('hidden');
                button.setAttribute('aria-expanded', 'false');
                var svg = button.querySelector('span svg');
                if(svg && svg.parentNode.classList.contains('transition-transform')) {
                    svg.parentNode.classList.remove('rotate-180');
                }
            } else {
                panel.classList.remove('hidden');
                panel.classList.add('block');
                button.setAttribute('aria-expanded', 'true');
                var svg = button.querySelector('span svg');
                if(svg && svg.parentNode.classList.contains('transition-transform')) {
                    svg.parentNode.classList.add('rotate-180');
                }
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            // Global Smart Polling for Real-Time Tables
            if (document.getElementById('realtime-tbody')) {
                setInterval(() => {
                    const openModals = document.querySelectorAll('[id^="modal"]:not(.hidden)');
                    if (openModals.length > 0) return;

                    fetch(window.location.href, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(res => res.text())
                    .then(html => {
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(html, 'text/html');
                        
                        const newTbody = doc.getElementById('realtime-tbody');
                        if (newTbody && document.getElementById('realtime-tbody')) {
                            document.getElementById('realtime-tbody').innerHTML = newTbody.innerHTML;
                        }

                        const newPagination = doc.getElementById('realtime-pagination');
                        if (newPagination && document.getElementById('realtime-pagination')) {
                            document.getElementById('realtime-pagination').innerHTML = newPagination.innerHTML;
                        }
                    })
                    .catch(err => console.error('Error polling table:', err));
                }, 5000); 
            }
        });
    </script>
</body>
</html>