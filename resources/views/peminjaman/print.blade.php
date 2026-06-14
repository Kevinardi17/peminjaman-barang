<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Peminjaman - {{ $peminjaman->no_peminjaman }}</title>
    @vite(['resources/css/app.css'])
    <style>
        @page { size: A4; margin: 20mm; }
        body { font-family: 'Inter', sans-serif; background-color: white; color: #1e293b; }
        .print-container { max-width: 800px; margin: 0 auto; padding: 20px; }
        @media print {
            .no-print { display: none !important; }
            .print-container { padding: 0; border: none !important; box-shadow: none !important; }
            body { -webkit-print-color-adjust: exact; print-color-adjust: exact; background-color: white !important; }
        }
        .kop-surat { border-bottom: 3px solid #1e293b; margin-bottom: 2rem; padding-bottom: 1rem; }
    </style>
</head>
<body class="bg-slate-50 antialiased">

    <!-- Action Bar (No Print) -->
    <div class="no-print bg-white border-b border-slate-200 px-6 py-4 flex justify-end items-center sticky top-0 shadow-sm z-50">
        <button onclick="window.print()" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg font-semibold transition shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6.728 10.154A4.5 4.5 0 0 1 11.25 6h1.5a4.5 4.5 0 0 1 4.522 4.154m-10.5 0A4.5 4.5 0 0 0 2.25 14.654v1.592c0 .828.672 1.5 1.5 1.5h16.5a1.5 1.5 0 0 0 1.5-1.5v-1.592a4.5 4.5 0 0 0-4.478-4.5M6.728 10.154 6.75 6.75m10.5 3.4v-3.4m-10.5 3.4h10.5M8.25 18.75h7.5m-7.5-1.5h7.5" />
            </svg>
            Cetak Dokumen
        </button>
    </div>

    <!-- Document -->
    <div class="print-container bg-white shadow-xl md:my-8 md:rounded-xl md:border border-slate-200 min-h-[297mm]">
        <!-- KOP Surat -->
        <div class="kop-surat flex items-center gap-6">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-24 h-24 object-contain">
            <div class="flex-1 text-center pr-24">
                <h1 class="text-2xl font-bold uppercase tracking-wide text-slate-900">SMK N 5 Bandar Lampung</h1>
                <p class="text-slate-600 font-medium mt-1">Sistem Manajemen Peminjaman Barang Inventaris</p>
                <p class="text-sm text-slate-500">Jl. Pangeran Tirtayasa, Sukabumi, Bandar Lampung</p>
            </div>
        </div>

        <div class="text-center mb-8">
            <h2 class="text-xl font-bold text-slate-800 uppercase underline underline-offset-4">Bukti Peminjaman Barang</h2>
            <p class="text-slate-500 mt-2 font-medium">Nomor: <span class="text-slate-800">{{ $peminjaman->no_peminjaman }}</span></p>
        </div>

        <!-- Info Grid -->
        <div class="grid grid-cols-2 gap-6 mb-8 text-sm">
            <div class="space-y-3">
                <div class="grid grid-cols-3">
                    <span class="text-slate-500 font-medium">Nama Peminjam</span>
                    <span class="col-span-2 font-semibold text-slate-800">: {{ $peminjaman->user->name }}</span>
                </div>
                <div class="grid grid-cols-3">
                    <span class="text-slate-500 font-medium">Status</span>
                    <span class="col-span-2 font-semibold text-slate-800 flex items-center gap-2">: 
                        <span class="uppercase px-2 py-0.5 rounded text-xs font-bold border 
                            {{ $peminjaman->status == 'dipinjam' ? 'bg-blue-100 text-blue-700 border-blue-200' : 'bg-slate-100 text-slate-700 border-slate-200' }}">
                            {{ $peminjaman->status }}
                        </span>
                    </span>
                </div>
            </div>
            <div class="space-y-3">
                <div class="grid grid-cols-3">
                    <span class="text-slate-500 font-medium">Tgl Peminjaman</span>
                    <span class="col-span-2 font-semibold text-slate-800">: {{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->translatedFormat('d F Y') }}</span>
                </div>
                <div class="grid grid-cols-3">
                    <span class="text-slate-500 font-medium">Rencana Kembali</span>
                    <span class="col-span-2 font-semibold text-slate-800">: {{ \Carbon\Carbon::parse($peminjaman->tanggal_rencana_kembali)->translatedFormat('d F Y') }}</span>
                </div>
            </div>
        </div>

        <!-- Table -->
        <table class="w-full text-left border-collapse mb-12">
            <thead>
                <tr class="bg-slate-100 border-y-2 border-slate-300">
                    <th class="py-3 px-4 font-bold text-slate-800 w-16 text-center">No</th>
                    <th class="py-3 px-4 font-bold text-slate-800">Nama Barang</th>
                    <th class="py-3 px-4 font-bold text-slate-800 w-32 text-center">Jumlah</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                @foreach($peminjaman->details as $index => $detail)
                <tr>
                    <td class="py-3 px-4 text-center text-slate-600 border-b border-slate-200">{{ $index + 1 }}</td>
                    <td class="py-3 px-4 font-medium text-slate-800 border-b border-slate-200">{{ $detail->barang->nama_barang }}</td>
                    <td class="py-3 px-4 text-center font-semibold text-slate-800 border-b border-slate-200">{{ $detail->jumlah }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Signatures -->
        <div class="flex justify-between items-end pt-8">
            <div class="text-center w-64">
                <p class="text-slate-600 mb-16">Peminjam,</p>
                <p class="font-bold text-slate-800 underline">{{ $peminjaman->user->name }}</p>
                <p class="text-sm text-slate-500 mt-1">NIP/NIS: ......................</p>
            </div>
            <div class="text-center w-64">
                <p class="text-slate-600 mb-16">Mengetahui,<br>Admin Jurusan</p>
                <p class="font-bold text-slate-800 underline">......................................</p>
                <p class="text-sm text-slate-500 mt-1">NIP: ......................</p>
            </div>
        </div>
    </div>
</body>
</html>