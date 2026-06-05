<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Jurusan;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register', [
            'jurusans' => Jurusan::orderBy('nama')->get()
        ]);
    }
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'no_hp' => ['required', 'string', 'min:10', 'regex:/^(08|62)/', 'max:20'],
            'jenis_pengguna' => ['required', 'in:siswa,guru'],
            'asal_kelas_jabatan' => ['required', 'string', 'max:255'],
            'jurusan_id' => ['required', 'exists:jurusans,id'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'no_hp' => $request->no_hp,
            'role' => 'peminjam',
            'jenis_pengguna' => $request->jenis_pengguna,
            'asal_kelas_jabatan' => $request->asal_kelas_jabatan,
            'jurusan_id' => $request->jurusan_id,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
