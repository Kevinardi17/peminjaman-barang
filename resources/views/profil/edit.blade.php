<x-dashboard-layout title="Profil">
    <div class="bg-white rounded-2xl shadow-sm border p-5 max-w-2xl">
        @if(session('success'))
            <div class="mb-4 rounded-lg bg-green-100 text-green-700 px-4 py-3">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('profil.update') }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block mb-1 font-medium">Nama</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full border rounded-lg px-3 py-2">
                @error('name') <small class="text-red-600">{{ $message }}</small> @enderror
            </div>

            <div>
                <label class="block mb-1 font-medium">Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full border rounded-lg px-3 py-2">
                @error('email') <small class="text-red-600">{{ $message }}</small> @enderror
            </div>

            <div>
                <label class="block mb-1 font-medium">No HP</label>
                <input type="text" name="no_hp" value="{{ old('no_hp', $user->no_hp) }}" class="w-full border rounded-lg px-3 py-2">
                @error('no_hp') <small class="text-red-600">{{ $message }}</small> @enderror
            </div>

            @if($user->role !== 'superadmin')
                <div>
                    <label class="block mb-1 font-medium">Jenis Pengguna</label>
                    <select name="jenis_pengguna" class="w-full border rounded-lg px-3 py-2">
                        <option value="">-- Pilih --</option>
                        <option value="siswa" {{ old('jenis_pengguna', $user->jenis_pengguna) === 'siswa' ? 'selected' : '' }}>Siswa</option>
                        <option value="guru" {{ old('jenis_pengguna', $user->jenis_pengguna) === 'guru' ? 'selected' : '' }}>Guru</option>
                    </select>
                    @error('jenis_pengguna') <small class="text-red-600">{{ $message }}</small> @enderror
                </div>

                <div>
                    <label class="block mb-1 font-medium">Asal / Kelas / Jabatan</label>
                    <input type="text" name="asal_kelas_jabatan" value="{{ old('asal_kelas_jabatan', $user->asal_kelas_jabatan) }}" class="w-full border rounded-lg px-3 py-2">
                    @error('asal_kelas_jabatan') <small class="text-red-600">{{ $message }}</small> @enderror
                </div>

                @if($user->role === 'peminjam')
                    <div>
                        <label class="block mb-1 font-medium">Jurusan</label>
                        <select name="jurusan_id" class="w-full border rounded-lg px-3 py-2">
                            <option value="">-- Pilih Jurusan --</option>
                            @foreach($jurusans as $jurusan)
                                <option value="{{ $jurusan->id }}" {{ old('jurusan_id', $user->jurusan_id) == $jurusan->id ? 'selected' : '' }}>
                                    {{ $jurusan->kode }} - {{ $jurusan->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('jurusan_id') <small class="text-red-600">{{ $message }}</small> @enderror
                    </div>
                @endif
            @endif

            <div>
                <label class="block mb-1 font-medium">Password Baru</label>
                <input type="password" name="password" class="w-full border rounded-lg px-3 py-2">
                @error('password') <small class="text-red-600">{{ $message }}</small> @enderror
            </div>

            <div>
                <label class="block mb-1 font-medium">Konfirmasi Password Baru</label>
                <input type="password" name="password_confirmation" class="w-full border rounded-lg px-3 py-2">
            </div>

            <div class="flex gap-2">
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg">Simpan</button>
            </div>
        </form>
    </div>
</x-dashboard-layout>