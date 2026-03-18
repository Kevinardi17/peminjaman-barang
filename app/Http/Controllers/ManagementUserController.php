<?php

namespace App\Http\Controllers;

use App\Models\Jurusan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ManagementUserController extends Controller
{
    public function index(Request $request)
    {
        $authUser = auth()->user();

        $query = User::with('jurusan')
            ->where('role', 'peminjam');

        if ($authUser->role === 'admin_jurusan') {
            $query->where('jurusan_id', $authUser->jurusan_id);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('no_hp', 'like', "%{$search}%");
            });
        }

        $users = $query->latest()->paginate(10)->withQueryString();

        return view('management-user.index', compact('users'));
    }

    public function create()
    {
        $authUser = auth()->user();

        $jurusans = $authUser->role === 'superadmin'
            ? Jurusan::orderBy('nama')->get()
            : Jurusan::where('id', $authUser->jurusan_id)->get();

        return view('management-user.create', compact('jurusans'));
    }

    public function store(Request $request)
    {
        $authUser = auth()->user();

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'no_hp' => ['required', 'string', 'max:20'],
            'jenis_pengguna' => ['required', 'in:siswa,guru'],
            'asal_kelas_jabatan' => ['required', 'string', 'max:255'],
            'jurusan_id' => ['required', 'exists:jurusans,id'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if ($authUser->role === 'admin_jurusan' && (int) $request->jurusan_id !== (int) $authUser->jurusan_id) {
            abort(403, 'Akses ditolak');
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'role' => 'peminjam',
            'jenis_pengguna' => $request->jenis_pengguna,
            'asal_kelas_jabatan' => $request->asal_kelas_jabatan,
            'jurusan_id' => $request->jurusan_id,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('management-user.index')->with('success', 'User berhasil ditambahkan.');
    }

    public function edit(User $management_user)
    {
        $authUser = auth()->user();
        $user = $management_user;

        if ($user->role !== 'peminjam') {
            abort(403, 'Akses ditolak');
        }

        if ($authUser->role === 'admin_jurusan' && $user->jurusan_id !== $authUser->jurusan_id) {
            abort(403, 'Akses ditolak');
        }

        $jurusans = $authUser->role === 'superadmin'
            ? Jurusan::orderBy('nama')->get()
            : Jurusan::where('id', $authUser->jurusan_id)->get();

        return view('management-user.edit', compact('user', 'jurusans'));
    }

    public function update(Request $request, User $management_user)
    {
        $authUser = auth()->user();
        $user = $management_user;

        if ($user->role !== 'peminjam') {
            abort(403, 'Akses ditolak');
        }

        if ($authUser->role === 'admin_jurusan' && $user->jurusan_id !== $authUser->jurusan_id) {
            abort(403, 'Akses ditolak');
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'no_hp' => ['required', 'string', 'max:20'],
            'jenis_pengguna' => ['required', 'in:siswa,guru'],
            'asal_kelas_jabatan' => ['required', 'string', 'max:255'],
            'jurusan_id' => ['required', 'exists:jurusans,id'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        if ($authUser->role === 'admin_jurusan' && (int) $request->jurusan_id !== (int) $authUser->jurusan_id) {
            abort(403, 'Akses ditolak');
        }

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'jenis_pengguna' => $request->jenis_pengguna,
            'asal_kelas_jabatan' => $request->asal_kelas_jabatan,
            'jurusan_id' => $request->jurusan_id,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('management-user.index')->with('success', 'User berhasil diperbarui.');
    }

    public function destroy(User $management_user)
    {
        $authUser = auth()->user();
        $user = $management_user;

        if ($user->role !== 'peminjam') {
            abort(403, 'Akses ditolak');
        }

        if ($authUser->role === 'admin_jurusan' && $user->jurusan_id !== $authUser->jurusan_id) {
            abort(403, 'Akses ditolak');
        }

        $user->delete();

        return redirect()->route('management-user.index')->with('success', 'User berhasil dihapus.');
    }
}