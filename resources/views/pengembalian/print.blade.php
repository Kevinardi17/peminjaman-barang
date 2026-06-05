<!DOCTYPE html>
<html>
<head>
    <title>Cetak Bukti Pengembalian</title>
    <style>
        .btn-print {
            display: inline-block;
            margin-bottom: 15px;
            padding: 8px 14px;
            background: #2563eb;
            color: white;
            border-radius: 6px;
            text-decoration: none;
            border: none;
            cursor: pointer;
            font-family: sans-serif;
            font-size: 14px;
        }

        body {
            font-family: sans-serif;
            color: #333;
        }

        .status-badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: bold;
            color: white;
        }

        .status-tepat {
            background-color: #10b981;
        }

        .status-terlambat {
            background-color: #ef4444;
        }

        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>

    <div class="no-print">
        <button onclick="window.print()" class="btn-print">Print</button>
    </div>

    <h2>Bukti Pengembalian Barang</h2>

    <table cellpadding="3" cellspacing="0">
        <tr>
            <td><strong>No Peminjaman</strong></td>
            <td>: {{ $peminjaman->no_peminjaman }}</td>
        </tr>
        <tr>
            <td><strong>Nama Peminjam</strong></td>
            <td>: {{ $peminjaman->user->name ?? '-' }}</td>
        </tr>
        <tr>
            <td><strong>Tanggal Pinjam</strong></td>
            <td>: {{ $peminjaman->tanggal_pinjam }}</td>
        </tr>
        <tr>
            <td><strong>Rencana Kembali</strong></td>
            <td>: {{ $peminjaman->tanggal_rencana_kembali }}</td>
        </tr>
        <tr>
            <td><strong>Tanggal Dikembalikan</strong></td>
            <td>: {{ $peminjaman->tanggal_kembali }}</td>
        </tr>
        <tr>
            <td><strong>Keterlambatan</strong></td>
            <td>: 
                @if($peminjaman->status_keterlambatan === 'terlambat')
                    <span class="status-badge status-terlambat">Terlambat</span>
                @else
                    <span class="status-badge status-tepat">Tepat Waktu</span>
                @endif
            </td>
        </tr>
        <tr>
            <td><strong>Petugas Penerima</strong></td>
            <td>: {{ $peminjaman->petugasPengembalian->name ?? '-' }}</td>
        </tr>
    </table>

    <hr style="margin: 20px 0;">

    <h3>Rincian Barang Dikembalikan</h3>
    <table border="1" cellpadding="8" cellspacing="0" width="100%">
        <tr style="background-color: #f1f5f9;">
            <th align="left">Nama Barang</th>
            <th align="center">Jumlah</th>
        </tr>

        @foreach($peminjaman->details as $detail)
        <tr>
            <td>{{ $detail->barang->nama_barang }}</td>
            <td align="center">{{ $detail->jumlah }}</td>
        </tr>
        @endforeach
    </table>

    <div style="margin-top: 50px; text-align: right;">
        <p>Petugas Jurusan,</p>
        <br><br><br>
        <p><strong>{{ $peminjaman->petugasPengembalian->name ?? '___________________' }}</strong></p>
    </div>

</body>
</html>
