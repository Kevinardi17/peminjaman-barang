<?php

namespace App\Http\Controllers;

use App\Models\Jurusan;
use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        $query = Kategori::with('jurusan');

        if ($user->role === 'admin_jurusan') {
            $query->where('jurusan_id', $user->jurusan_id);
        }

        if ($request->filled('search')) {
            $query->where('nama', 'like', '%' . $request->search . '%');
        }

        $kategoris = $query->latest()->paginate(10)->withQueryString();

        return view('kategori.index', compact('kategoris'));
    }

    public function create()
    {
        $user = auth()->user();

        $jurusans = $user->role === 'superadmin'
            ? Jurusan::orderBy('nama')->get()
            : Jurusan::where('id', $user->jurusan_id)->get();

        return view('kategori.create', compact('jurusans'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'jurusan_id' => ['required', 'exists:jurusans,id'],
            'nama' => ['required', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string'],
        ]);

        if ($user->role === 'admin_jurusan' && (int) $request->jurusan_id !== (int) $user->jurusan_id) {
            abort(403, 'Akses ditolak');
        }

        Kategori::create([
            'jurusan_id' => $request->jurusan_id,
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit(Kategori $kategori)
    {
        $user = auth()->user();

        if ($user->role === 'admin_jurusan' && $kategori->jurusan_id !== $user->jurusan_id) {
            abort(403, 'Akses ditolak');
        }

        $jurusans = $user->role === 'superadmin'
            ? Jurusan::orderBy('nama')->get()
            : Jurusan::where('id', $user->jurusan_id)->get();

        return view('kategori.edit', compact('kategori', 'jurusans'));
    }

    public function update(Request $request, Kategori $kategori)
    {
        $user = auth()->user();

        if ($user->role === 'admin_jurusan' && $kategori->jurusan_id !== $user->jurusan_id) {
            abort(403, 'Akses ditolak');
        }

        $request->validate([
            'jurusan_id' => ['required', 'exists:jurusans,id'],
            'nama' => ['required', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string'],
        ]);

        if ($user->role === 'admin_jurusan' && (int) $request->jurusan_id !== (int) $user->jurusan_id) {
            abort(403, 'Akses ditolak');
        }

        $kategori->update([
            'jurusan_id' => $request->jurusan_id,
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Kategori $kategori)
    {
        $user = auth()->user();

        if ($user->role === 'admin_jurusan' && $kategori->jurusan_id !== $user->jurusan_id) {
            abort(403, 'Akses ditolak');
        }

        $kategori->delete();

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil dihapus.');
    }
}