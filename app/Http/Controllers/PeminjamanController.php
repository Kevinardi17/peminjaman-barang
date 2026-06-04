<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\DetailPeminjaman;
use App\Models\Jurusan;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PeminjamanController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->role === 'peminjam') {
            $peminjamans = Peminjaman::with(['user', 'jurusanTujuan', 'details.barang', 'petugasPeminjaman'])
                ->where('user_id', $user->id)
                ->latest()
                ->paginate(10);
        } elseif ($user->role === 'admin_jurusan') {
            $peminjamans = Peminjaman::with(['user', 'jurusanTujuan', 'details.barang', 'petugasPeminjaman'])
                ->where('jurusan_tujuan_id', $user->jurusan_id)
                ->latest()
                ->paginate(10);
        } else {
            $peminjamans = Peminjaman::with(['user', 'jurusanTujuan', 'details.barang', 'petugasPeminjaman'])
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
            'barang_id' => ['nullable', 'array'],
            'barang_id.*' => ['exists:barangs,id'],
            'jumlah' => ['nullable', 'array'],
        ]);

        if (!$request->has('barang_id') || count($request->barang_id) === 0) {
            return back()
                ->withErrors([
                    'barang_id' => 'Silakan checklist minimal 1 barang terlebih dahulu.'
                ])
                ->withInput();
        }

        $selectedBarangIds = $request->barang_id;
        $jumlahInputs = $request->jumlah ?? [];
        $detailItems = [];

        foreach ($selectedBarangIds as $barangId) {
            $barang = Barang::findOrFail($barangId);
            $jumlah = isset($jumlahInputs[$barangId]) ? (int) $jumlahInputs[$barangId] : 0;

            if ($jumlah < 1) {
                return back()
                    ->withErrors([
                        'barang_id' => "Jumlah untuk barang {$barang->nama_barang} harus minimal 1."
                    ])
                    ->withInput();
            }

            if ((int) $barang->jurusan_id !== (int) $request->jurusan_tujuan_id) {
                return back()
                    ->withErrors([
                        'barang_id' => "Barang {$barang->nama_barang} tidak sesuai dengan jurusan tujuan."
                    ])
                    ->withInput();
            }

            if ($jumlah > $barang->stok) {
                return back()
                    ->withErrors([
                        'barang_id' => "Stok {$barang->nama_barang} tidak cukup. Stok tersedia: {$barang->stok}."
                    ])
                    ->withInput();
            }

            $detailItems[] = [
                'barang_id' => $barang->id,
                'jumlah' => $jumlah,
            ];
        }

        if (count($detailItems) === 0) {
            return back()
                ->withErrors([
                    'barang_id' => 'Pilih minimal 1 barang untuk diajukan.'
                ])
                ->withInput();
        }

        DB::transaction(function () use ($request, $detailItems) {
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

            foreach ($detailItems as $item) {
                DetailPeminjaman::create([
                    'peminjaman_id' => $peminjaman->id,
                    'barang_id' => $item['barang_id'],
                    'jumlah' => $item['jumlah'],
                ]);
            }
        });

        return redirect()->route('peminjaman.index')->with('success', 'Pengajuan peminjaman berhasil dibuat.');
    }

    public function approve(Request $request, Peminjaman $peminjaman)
    {
        $user = auth()->user();

        if ($user->role === 'admin_jurusan' && $peminjaman->jurusan_tujuan_id !== $user->jurusan_id) {
            abort(403);
        }

        if ($peminjaman->status !== 'menunggu') {
            return back()->with('error', 'Status tidak valid.');
        }

        $request->validate([
            'foto_peminjaman' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ]);

        DB::transaction(function () use ($request, $peminjaman, $user) {
            foreach ($peminjaman->details as $detail) {
                $barang = $detail->barang;

                if ($detail->jumlah > $barang->stok) {
                    return back()->with('error', "Stok {$barang->nama_barang} tidak cukup.");
                }

                $barang->decrement('stok', $detail->jumlah);
            }

            $fotoPath = $request->file('foto_peminjaman')->store('peminjaman', 'public');

            $peminjaman->update([
                'status' => 'dipinjam',
                'petugas_peminjaman_id' => $user->id,
                'foto_peminjaman' => $fotoPath,
            ]);
        });

        return back()->with('success', 'Peminjaman disetujui.');
    }

    public function reject(Request $request, Peminjaman $peminjaman)
    {
        $user = auth()->user();

        if ($user->role === 'admin_jurusan' && $peminjaman->jurusan_tujuan_id !== $user->jurusan_id) {
            abort(403);
        }

        $request->validate([
            'alasan_penolakan' => ['required', 'string']
        ]);

        $peminjaman->update([
            'status' => 'ditolak',
            'alasan_penolakan' => $request->alasan_penolakan
        ]);

        return back()->with('success', 'Peminjaman ditolak.');
    }

    public function print(Peminjaman $peminjaman)
    {
        $user = auth()->user();

        if ($user->role === 'admin_jurusan' && $peminjaman->jurusan_tujuan_id !== $user->jurusan_id) {
            abort(403);
        }

        return view('peminjaman.print', compact('peminjaman'));
    }

    public function pengembalianIndex()
    {
        $user = auth()->user();

        $query = Peminjaman::with(['user', 'jurusanTujuan', 'details.barang', 'petugasPeminjaman', 'petugasPengembalian'])
            ->where('status', 'dipinjam');

        if ($user->role === 'admin_jurusan') {
            $query->where('jurusan_tujuan_id', $user->jurusan_id);
        }

        $peminjamans = $query->latest()->paginate(10);

        return view('pengembalian.index', compact('peminjamans'));
    }

    public function kembalikan(Request $request, Peminjaman $peminjaman)
    {
        $user = auth()->user();

        if ($user->role === 'admin_jurusan' && $peminjaman->jurusan_tujuan_id !== $user->jurusan_id) {
            abort(403);
        }

        if ($peminjaman->status !== 'dipinjam') {
            return back()->with('error', 'Status peminjaman tidak valid.');
        }

        $request->validate([
            'foto_pengembalian' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ]);

        DB::transaction(function () use ($request, $peminjaman, $user) {
            foreach ($peminjaman->details as $detail) {
                $detail->barang->increment('stok', $detail->jumlah);
            }

            $fotoPath = $request->file('foto_pengembalian')->store('pengembalian', 'public');

            $tanggalKembali = now()->toDateString();
            $statusKeterlambatan = $tanggalKembali > $peminjaman->tanggal_rencana_kembali
                ? 'terlambat'
                : 'tepat_waktu';

            $peminjaman->update([
                'status' => 'dikembalikan',
                'tanggal_kembali' => $tanggalKembali,
                'foto_pengembalian' => $fotoPath,
                'petugas_pengembalian_id' => $user->id,
                'status_keterlambatan' => $statusKeterlambatan,
            ]);
        });

        return back()->with('success', 'Barang berhasil dikembalikan.');
    }

    public function riwayat(Request $request)
    {
        $user = auth()->user();

        $query = Peminjaman::with(['user', 'jurusanTujuan'])
            ->whereIn('status', ['dikembalikan', 'ditolak']);

        if ($user->role === 'peminjam') {
            $query->where('user_id', $user->id);
        }

        if ($user->role === 'admin_jurusan') {
            $query->where('jurusan_tujuan_id', $user->jurusan_id);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('no_peminjaman', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'like', "%{$search}%");
                    });
            });
        }

        $riwayats = $query->latest()->paginate(10)->withQueryString();

        return view('riwayat.index', compact('riwayats'));
    }

    public function destroyRiwayat(Peminjaman $peminjaman)
    {
        $user = auth()->user();

        if (!in_array($peminjaman->status, ['dikembalikan', 'ditolak'])) {
            return back()->with('error', 'Hanya riwayat selesai yang dapat dihapus.');
        }

        if ($user->role === 'admin_jurusan' && $peminjaman->jurusan_tujuan_id !== $user->jurusan_id) {
            abort(403);
        }

        $peminjaman->delete();

        return redirect()->route('riwayat.index')->with('success', 'Riwayat berhasil dihapus.');
    }
}