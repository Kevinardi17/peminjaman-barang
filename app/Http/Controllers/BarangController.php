<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Jurusan;
use App\Models\Kategori;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        $query = Barang::with(['jurusan', 'kategori']);

        if ($user->role === 'admin_jurusan') {
            $query->where('jurusan_id', $user->jurusan_id);
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama_barang', 'like', '%' . $request->search . '%')
                  ->orWhere('kode_barang', 'like', '%' . $request->search . '%');
            });
        }

        $barangs = $query->latest()->paginate(10)->withQueryString();

        return view('barang.index', compact('barangs'));
    }

    public function create()
    {
        $user = auth()->user();

        $jurusans = $user->role === 'superadmin'
            ? Jurusan::orderBy('nama')->get()
            : Jurusan::where('id', $user->jurusan_id)->get();

        $kategoris = $user->role === 'superadmin'
            ? Kategori::with('jurusan')->orderBy('nama')->get()
            : Kategori::where('jurusan_id', $user->jurusan_id)->orderBy('nama')->get();

        return view('barang.create', compact('jurusans', 'kategoris'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'jurusan_id' => ['required', 'exists:jurusans,id'],
            'kategori_id' => ['required', 'exists:kategoris,id'],
            'kode_barang' => ['required', 'string', 'max:255', 'unique:barangs,kode_barang'],
            'nama_barang' => ['required', 'string', 'max:255'],
            'stok' => ['required', 'integer', 'min:0'],
            'kondisi' => ['nullable', 'string', 'max:255'],
            'keterangan' => ['nullable', 'string'],
            'foto' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ]);

        if ($user->role === 'admin_jurusan' && (int) $request->jurusan_id !== (int) $user->jurusan_id) {
            abort(403, 'Akses ditolak');
        }

        $kategori = Kategori::findOrFail($request->kategori_id);

        if ((int) $kategori->jurusan_id !== (int) $request->jurusan_id) {
            return back()->withErrors([
                'kategori_id' => 'Kategori tidak sesuai dengan jurusan.'
            ])->withInput();
        }

        $data = $request->only([
            'jurusan_id',
            'kategori_id',
            'kode_barang',
            'nama_barang',
            'stok',
            'kondisi',
            'keterangan',
        ]);

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('barang', 'public');
        }

        Barang::create($data);

        return redirect()->route('barang.index')->with('success', 'Barang berhasil ditambahkan.');
    }

    public function edit(Barang $barang)
    {
        $user = auth()->user();

        if ($user->role === 'admin_jurusan' && $barang->jurusan_id !== $user->jurusan_id) {
            abort(403, 'Akses ditolak');
        }

        $jurusans = $user->role === 'superadmin'
            ? Jurusan::orderBy('nama')->get()
            : Jurusan::where('id', $user->jurusan_id)->get();

        $kategoris = $user->role === 'superadmin'
            ? Kategori::with('jurusan')->orderBy('nama')->get()
            : Kategori::where('jurusan_id', $user->jurusan_id)->orderBy('nama')->get();

        return view('barang.edit', compact('barang', 'jurusans', 'kategoris'));
    }

    public function update(Request $request, Barang $barang)
    {
        $user = auth()->user();

        if ($user->role === 'admin_jurusan' && $barang->jurusan_id !== $user->jurusan_id) {
            abort(403, 'Akses ditolak');
        }

        $request->validate([
            'jurusan_id' => ['required', 'exists:jurusans,id'],
            'kategori_id' => ['required', 'exists:kategoris,id'],
            'kode_barang' => ['required', 'string', 'max:255', 'unique:barangs,kode_barang,' . $barang->id],
            'nama_barang' => ['required', 'string', 'max:255'],
            'stok' => ['required', 'integer', 'min:0'],
            'kondisi' => ['nullable', 'string', 'max:255'],
            'keterangan' => ['nullable', 'string'],
            'foto' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ]);

        if ($user->role === 'admin_jurusan' && (int) $request->jurusan_id !== (int) $user->jurusan_id) {
            abort(403, 'Akses ditolak');
        }

        $kategori = Kategori::findOrFail($request->kategori_id);

        if ((int) $kategori->jurusan_id !== (int) $request->jurusan_id) {
            return back()->withErrors([
                'kategori_id' => 'Kategori tidak sesuai dengan jurusan.'
            ])->withInput();
        }

        $data = $request->only([
            'jurusan_id',
            'kategori_id',
            'kode_barang',
            'nama_barang',
            'stok',
            'kondisi',
            'keterangan',
        ]);

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('barang', 'public');
        }

        $barang->update($data);

        return redirect()->route('barang.index')->with('success', 'Barang berhasil diperbarui.');
    }

    public function destroy(Barang $barang)
    {
        $user = auth()->user();

        if ($user->role === 'admin_jurusan' && $barang->jurusan_id !== $user->jurusan_id) {
            abort(403, 'Akses ditolak');
        }

        $barang->delete();

        return redirect()->route('barang.index')->with('success', 'Barang berhasil dihapus.');
    }

    public function show(Barang $barang)
    {
        $user = auth()->user();
        if ($user->role === 'admin_jurusan' && $barang->jurusan_id !== $user->jurusan_id) {
            abort(403);
        }

        // Calculate available stock
        $dipinjam = \App\Models\DetailPeminjaman::where('barang_id', $barang->id)
            ->whereHas('peminjaman', function($q) {
                $q->where('status', 'dipinjam');
            })->sum('jumlah');

        $tersedia = $barang->stok - $dipinjam;

        return view('barang.show', compact('barang', 'tersedia', 'dipinjam'));
    }

    public function history(Barang $barang)
    {
        $user = auth()->user();
        if ($user->role === 'admin_jurusan' && $barang->jurusan_id !== $user->jurusan_id) {
            abort(403);
        }

        $riwayats = \App\Models\Peminjaman::with(['user', 'jurusanTujuan'])
            ->whereHas('details', function($q) use ($barang) {
                $q->where('barang_id', $barang->id);
            })
            ->latest()
            ->paginate(10);

        return view('barang.history', compact('barang', 'riwayats'));
    }
}