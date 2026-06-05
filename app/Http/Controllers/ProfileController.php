<?php

namespace App\Http\Controllers;

use App\Models\Jurusan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = auth()->user();

        $jurusans = $user->role === 'superadmin'
            ? Jurusan::orderBy('nama')->get()
            : Jurusan::when($user->jurusan_id, function ($query) use ($user) {
                $query->where('id', $user->jurusan_id);
            })->orderBy('nama')->get();

        return view('profil.edit', compact('user', 'jurusans'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'no_hp' => ['nullable', 'string', 'max:20'],
            'password' => ['nullable', 'confirmed', 'min:8'],
            'foto' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            'hapus_foto' => ['nullable', 'boolean'],
        ];

        if ($user->role !== 'superadmin') {
            $rules['jenis_pengguna'] = ['nullable', 'in:siswa,guru'];
            $rules['asal_kelas_jabatan'] = ['nullable', 'string', 'max:255'];
            $rules['jurusan_id'] = ['nullable', 'exists:jurusans,id'];
        }

        $validated = $request->validate($rules);

        if ($user->role === 'admin_jurusan') {
            $validated['jurusan_id'] = $user->jurusan_id;
        }

        if ($user->role === 'superadmin') {
            $validated['jurusan_id'] = null;
            $validated['jenis_pengguna'] = null;
            $validated['asal_kelas_jabatan'] = 'Superadmin Sistem';
        }

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        if ($request->hasFile('foto')) {
            if ($user->profile_photo_path) {
                Storage::disk('public')->delete($user->profile_photo_path);
            }
            $validated['profile_photo_path'] = $request->file('foto')->store('profile-photos', 'public');
        } elseif ($request->boolean('hapus_foto')) {
            if ($user->profile_photo_path) {
                Storage::disk('public')->delete($user->profile_photo_path);
            }
            $validated['profile_photo_path'] = null;
        }

        unset($validated['foto'], $validated['hapus_foto']);

        $user->update($validated);

        return redirect()->route('profil.edit')->with('success', 'Profil berhasil diperbarui.');
    }
}