<x-dashboard-layout title="Tambah User">
    <div class="bg-white rounded-2xl shadow-sm border p-5 max-w-2xl">
        <form action="{{ route('management-user.store') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block mb-1 font-medium">Nama</label>
                <input type="text" name="name" value="{{ old('name') }}" class="w-full border rounded-lg px-3 py-2">
                @error('name') <small class="text-red-600">{{ $message }}</small> @enderror
            </div>

            <div>
                <label class="block mb-1 font-medium">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" class="w-full border rounded-lg px-3 py-2">
                @error('email') <small class="text-red-600">{{ $message }}</small> @enderror
            </div>

            <div>
                <label class="block mb-1 font-medium">No HP</label>
                <input type="text" name="no_hp" value="{{ old('no_hp') }}" class="w-full border rounded-lg px-3 py-2">
                @error('no_hp') <small class="text-red-600">{{ $message }}</small> @enderror
            </div>

            @if(auth()->user()->role === 'superadmin')
                <div>
                    <label class="block mb-1 font-medium">Role</label>
                    <select name="role" id="role" class="w-full border rounded-lg px-3 py-2">
                        <option value="peminjam" {{ old('role') === 'peminjam' ? 'selected' : '' }}>Peminjam</option>
                        <option value="admin_jurusan" {{ old('role') === 'admin_jurusan' ? 'selected' : '' }}>Admin Jurusan</option>
                    </select>
                    @error('role') <small class="text-red-600">{{ $message }}</small> @enderror
                </div>
            @else
                <input type="hidden" name="role" id="role" value="peminjam">
            @endif

            <div id="peminjam_fields" class="space-y-4">
                <div>
                    <label class="block mb-1 font-medium">Jenis Pengguna</label>
                    <select name="jenis_pengguna" class="w-full border rounded-lg px-3 py-2">
                        <option value="">-- Pilih --</option>
                        <option value="siswa" {{ old('jenis_pengguna') === 'siswa' ? 'selected' : '' }}>Siswa</option>
                        <option value="guru" {{ old('jenis_pengguna') === 'guru' ? 'selected' : '' }}>Guru</option>
                    </select>
                    @error('jenis_pengguna') <small class="text-red-600">{{ $message }}</small> @enderror
                </div>

                <div>
                    <label class="block mb-1 font-medium">Asal / Kelas / Jabatan</label>
                    <input type="text" name="asal_kelas_jabatan" value="{{ old('asal_kelas_jabatan') }}" class="w-full border rounded-lg px-3 py-2">
                    @error('asal_kelas_jabatan') <small class="text-red-600">{{ $message }}</small> @enderror
                </div>
            </div>

            <div>
                <label class="block mb-1 font-medium">Jurusan</label>
                <select name="jurusan_id" class="w-full border rounded-lg px-3 py-2">
                    <option value="">-- Pilih Jurusan --</option>
                    @foreach($jurusans as $jurusan)
                        <option value="{{ $jurusan->id }}" {{ old('jurusan_id') == $jurusan->id ? 'selected' : '' }}>
                            {{ $jurusan->kode }} - {{ $jurusan->nama }}
                        </option>
                    @endforeach
                </select>
                @error('jurusan_id') <small class="text-red-600">{{ $message }}</small> @enderror
            </div>

            <div>
                <label class="block mb-1 font-medium">Password</label>
                <input type="password" name="password" class="w-full border rounded-lg px-3 py-2">
                @error('password') <small class="text-red-600">{{ $message }}</small> @enderror
            </div>

            <div>
                <label class="block mb-1 font-medium">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="w-full border rounded-lg px-3 py-2">
            </div>

            <div class="flex gap-2">
                <a href="{{ route('management-user.index') }}" class="px-4 py-2 bg-slate-200 rounded-lg">Kembali</a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg">Simpan</button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const roleSelect = document.getElementById('role');
            const peminjamFields = document.getElementById('peminjam_fields');

            function toggleFields() {
                if (roleSelect && roleSelect.value === 'admin_jurusan') {
                    peminjamFields.style.display = 'none';
                } else {
                    peminjamFields.style.display = 'block';
                }
            }

            if (roleSelect) {
                roleSelect.addEventListener('change', toggleFields);
                toggleFields();
            }
        });
    </script>
</x-dashboard-layout>