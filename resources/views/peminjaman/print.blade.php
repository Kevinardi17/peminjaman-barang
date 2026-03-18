<!DOCTYPE html>
<html>
<head>
    <title>Cetak Peminjaman</title>
    <style>
        .btn-print {
            display: inline-block;
            margin-bottom: 15px;
            padding: 8px 14px;
            background: #2563eb;
            color: white;
            border-radius: 6px;
            text-decoration: none;
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

    <h2>Bukti Peminjaman</h2>

    <p>No: {{ $peminjaman->no_peminjaman }}</p>
    <p>Nama: {{ $peminjaman->user->name }}</p>
    <p>Tanggal Pinjam: {{ $peminjaman->tanggal_pinjam }}</p>
    <p>Rencana Kembali: {{ $peminjaman->tanggal_rencana_kembali }}</p>

    <hr>

    <table border="1" cellpadding="5" cellspacing="0" width="100%">
        <tr>
            <th>Barang</th>
            <th>Jumlah</th>
        </tr>

        @foreach($peminjaman->details as $detail)
        <tr>
            <td>{{ $detail->barang->nama_barang }}</td>
            <td>{{ $detail->jumlah }}</td>
        </tr>
        @endforeach
    </table>

</body>
</html>