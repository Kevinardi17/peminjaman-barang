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
            ->whereIn('role', ['admin_jurusan', 'peminjam']);

        if ($authUser->role === 'admin_jurusan') {
            $query->where('role', 'peminjam')
                ->where('jurusan_id', $authUser->jurusan_id);
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

        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'no_hp' => ['required', 'string', 'max:20'],
            'role' => ['required', 'in:admin_jurusan,peminjam'],
            'jurusan_id' => ['nullable', 'exists:jurusans,id'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];

        if ($request->role === 'peminjam') {
            $rules['jenis_pengguna'] = ['required', 'in:siswa,guru'];
            $rules['asal_kelas_jabatan'] = ['required', 'string', 'max:255'];
        }

        $request->validate($rules);

        if ($authUser->role === 'admin_jurusan') {
            $request->merge([
                'role' => 'peminjam',
                'jurusan_id' => $authUser->jurusan_id,
            ]);
        }

        if ($authUser->role === 'admin_jurusan' && (int) $request->jurusan_id !== (int) $authUser->jurusan_id) {
            abort(403);
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'role' => $request->role,
            'jenis_pengguna' => $request->role === 'peminjam' ? $request->jenis_pengguna : null,
            'asal_kelas_jabatan' => $request->role === 'peminjam'
                ? $request->asal_kelas_jabatan
                : 'Admin Jurusan',
            'jurusan_id' => $request->role === 'admin_jurusan' ? $request->jurusan_id : $request->jurusan_id,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('management-user.index')->with('success', 'User berhasil ditambahkan.');
    }

    public function edit(User $management_user)
    {
        $authUser = auth()->user();
        $user = $management_user;

        if ($user->role === 'superadmin') {
            abort(403, 'Akses ditolak');
        }

        if ($authUser->role === 'admin_jurusan' && $user->role !== 'peminjam') {
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

        if ($user->role === 'superadmin') {
            abort(403, 'Akses ditolak');
        }

        if ($authUser->role === 'admin_jurusan' && $user->role !== 'peminjam') {
            abort(403, 'Akses ditolak');
        }

        if ($authUser->role === 'admin_jurusan' && $user->jurusan_id !== $authUser->jurusan_id) {
            abort(403, 'Akses ditolak');
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'no_hp' => ['required', 'string', 'max:20'],
            'role' => ['nullable', 'in:peminjam,admin_jurusan'],
            'jenis_pengguna' => [Rule::requiredIf($request->role === 'peminjam' || (!isset($request->role) && $user->role === 'peminjam')), 'nullable', 'in:siswa,guru'],
            'asal_kelas_jabatan' => [Rule::requiredIf($request->role === 'peminjam' || (!isset($request->role) && $user->role === 'peminjam')), 'nullable', 'string', 'max:255'],
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
            'jurusan_id' => $request->jurusan_id,
        ];

        if ($authUser->role === 'superadmin' && $request->filled('role')) {
            $data['role'] = $request->role;
        }
        
        $currentRole = $data['role'] ?? $user->role;
        
        $data['jenis_pengguna'] = $currentRole === 'peminjam' ? $request->jenis_pengguna : null;
        $data['asal_kelas_jabatan'] = $currentRole === 'peminjam' ? $request->asal_kelas_jabatan : 'Admin Jurusan';

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

        if ($user->role === 'superadmin') {
            abort(403, 'Akses ditolak');
        }

        if ($authUser->role === 'admin_jurusan' && $user->role !== 'peminjam') {
            abort(403, 'Akses ditolak');
        }

        if ($authUser->role === 'admin_jurusan' && $user->jurusan_id !== $authUser->jurusan_id) {
            abort(403, 'Akses ditolak');
        }

        $user->delete();

        return redirect()->route('management-user.index')->with('success', 'User berhasil dihapus.');
    }

    public function show(User $management_user)
    {
        $authUser = auth()->user();
        $user = $management_user;

        if ($authUser->role === 'admin_jurusan' && $user->jurusan_id !== $authUser->jurusan_id) {
            abort(403, 'Akses ditolak');
        }

        return view('management-user.show', compact('user'));
    }
}