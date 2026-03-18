<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\DetailPeminjaman;
use App\Models\Jurusan;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PeminjamanController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->role === 'peminjam') {
            $peminjamans = Peminjaman::with(['jurusanTujuan', 'details.barang'])
                ->where('user_id', $user->id)
                ->latest()
                ->paginate(10);
        } elseif ($user->role === 'admin_jurusan') {
            $peminjamans = Peminjaman::with(['user', 'jurusanTujuan'])
                ->where('jurusan_tujuan_id', $user->jurusan_id)
                ->latest()
                ->paginate(10);
        } else {
            $peminjamans = Peminjaman::with(['user', 'jurusanTujuan'])
                ->latest()
                ->paginate(10);
        }

        return view('peminjaman.index', compact('peminjamans'));
    }

    public function create()
    {
        abort_if(auth()->user()->role !== 'peminjam', 403);

        $jurusans = Jurusan::orderBy('nama')->get();
        $barangs = Barang::with('jurusan')
            ->where('stok', '>', 0)
            ->orderBy('nama_barang')
            ->get();

        return view('peminjaman.create', compact('jurusans', 'barangs'));
    }

    public function store(Request $request)
    {
        abort_if(auth()->user()->role !== 'peminjam', 403);

        $request->validate([
            'jurusan_tujuan_id' => ['required', 'exists:jurusans,id'],
            'tanggal_pinjam' => ['required', 'date'],
            'tanggal_rencana_kembali' => ['required', 'date', 'after_or_equal:tanggal_pinjam'],
            'barang_id' => ['required', 'array', 'min:1'],
            'barang_id.*' => ['required', 'exists:barangs,id'],
            'jumlah' => ['required', 'array', 'min:1'],
            'jumlah.*' => ['required', 'integer', 'min:1'],
        ]);

        DB::transaction(function () use ($request) {
            $noPeminjaman = 'PJM-' . now()->format('Ymd') . '-' . str_pad((string) (Peminjaman::count() + 1), 4, '0', STR_PAD_LEFT);

            $peminjaman = Peminjaman::create([
                'no_peminjaman' => $noPeminjaman,
                'user_id' => auth()->id(),
                'jurusan_tujuan_id' => $request->jurusan_tujuan_id,
                'status' => 'menunggu',
                'tanggal_pinjam' => $request->tanggal_pinjam,
                'tanggal_rencana_kembali' => $request->tanggal_rencana_kembali,
                'status_keterlambatan' => 'belum_kembali',
            ]);

            foreach ($request->barang_id as $index => $barangId) {
                $barang = Barang::findOrFail($barangId);
                $jumlah = (int) $request->jumlah[$index];

                if ($barang->jurusan_id != $request->jurusan_tujuan_id) {
                    abort(422, 'Barang harus sesuai jurusan tujuan.');
                }

                if ($jumlah > $barang->stok) {
                    abort(422, 'Jumlah pinjam melebihi stok tersedia.');
                }

                DetailPeminjaman::create([
                    'peminjaman_id' => $peminjaman->id,
                    'barang_id' => $barangId,
                    'jumlah' => $jumlah,
                ]);
            }
        });

        return redirect()->route('peminjaman.index')->with('success', 'Pengajuan peminjaman berhasil dibuat.');
    }
}