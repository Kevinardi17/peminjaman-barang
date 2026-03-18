<?php

namespace App\Http\Controllers;

use App\Models\Jurusan;
use Illuminate\Http\Request;

class JurusanController extends Controller
{
    public function index(Request $request)
    {
        $query = Jurusan::query();

        if ($request->filled('search')) {
            $query->where('kode', 'like', '%' . $request->search . '%')
                ->orWhere('nama', 'like', '%' . $request->search . '%');
        }

        $jurusans = $query->latest()->paginate(10)->withQueryString();

        return view('jurusan.index', compact('jurusans'));
    }

    public function create()
    {
        return view('jurusan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode' => ['required', 'string', 'max:20', 'unique:jurusans,kode'],
            'nama' => ['required', 'string', 'max:255'],
        ]);

        Jurusan::create($request->only('kode', 'nama'));

        return redirect()->route('jurusan.index')->with('success', 'Jurusan berhasil ditambahkan.');
    }

    public function edit(Jurusan $jurusan)
    {
        return view('jurusan.edit', compact('jurusan'));
    }

    public function update(Request $request, Jurusan $jurusan)
    {
        $request->validate([
            'kode' => ['required', 'string', 'max:20', 'unique:jurusans,kode,' . $jurusan->id],
            'nama' => ['required', 'string', 'max:255'],
        ]);

        $jurusan->update($request->only('kode', 'nama'));

        return redirect()->route('jurusan.index')->with('success', 'Jurusan berhasil diperbarui.');
    }

    public function destroy(Jurusan $jurusan)
    {
        $jurusan->delete();

        return redirect()->route('jurusan.index')->with('success', 'Jurusan berhasil dihapus.');
    }
}