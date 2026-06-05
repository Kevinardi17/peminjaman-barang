<x-dashboard-layout title="Profil">
    <div class="bg-white rounded-2xl shadow-sm border p-6 md:p-8 max-w-3xl mx-auto mt-4">
        @if(session('success'))
            <div class="mb-6 rounded-xl bg-green-100 text-green-700 px-4 py-3 font-medium">
                {{ session('success') }}
            </div>
        @endif

        <div class="flex justify-between items-center mb-8 pb-4 border-b border-slate-100">
            <div>
                <h3 class="text-xl font-bold text-slate-800">Informasi Profil</h3>
                <p class="text-sm text-slate-500 mt-1">Kelola data diri dan foto profil Anda.</p>
            </div>
            <button type="button" id="btn-edit" class="px-5 py-2 bg-slate-800 text-white rounded-xl hover:bg-slate-700 transition font-medium text-sm flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                </svg>
                Edit Profil
            </button>
        </div>

        <form action="{{ route('profil.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6" id="profile-form">
            @csrf
            @method('PUT')

            <!-- Foto Section -->
            <div class="flex flex-col items-center justify-center gap-4 pb-6 border-b border-slate-100 text-center">
                <div class="relative w-32 h-32 rounded-full bg-slate-100 flex-shrink-0 overflow-hidden shadow-inner border border-slate-200">
                    @if($user->profile_photo_path)
                        <img src="{{ asset('storage/' . $user->profile_photo_path) }}" alt="Foto Profil" class="w-full h-full object-cover">
                    @else
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=0f172a&color=fff&bold=true&size=128" alt="Avatar" class="w-full h-full object-cover">
                    @endif
                </div>
                
                <div class="space-y-3 hidden profile-edit-field w-full max-w-sm mx-auto">
                    <div>
                        <label class="block mb-1 font-medium text-sm text-slate-700">Unggah Foto Baru</label>
                        <input type="file" name="foto" accept="image/*" class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer text-center" disabled>
                        <p class="mt-2 text-xs text-slate-500">Format yang didukung: JPG, PNG, GIF. Maksimal: 2MB.</p>
                        @error('foto') <small class="text-red-600 block mt-1">{{ $message }}</small> @enderror
                    </div>
                    @if($user->profile_photo_path)
                    <div class="flex justify-center items-center gap-2 mt-3 p-2 px-3 bg-red-50 rounded-lg">
                        <input type="checkbox" name="hapus_foto" id="hapus_foto" value="1" class="rounded border-red-300 text-red-600 focus:ring-red-500 cursor-pointer" disabled>
                        <label for="hapus_foto" class="text-sm text-red-700 font-medium cursor-pointer">Hapus foto saat ini</label>
                    </div>
                    @endif
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block mb-1.5 font-medium text-slate-700 text-sm">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full border border-slate-300 bg-slate-50 rounded-xl px-4 py-2.5 focus:bg-white focus:ring-2 focus:ring-blue-500 transition disabled:opacity-70" disabled>
                    @error('name') <small class="text-red-600">{{ $message }}</small> @enderror
                </div>

                <div>
                    <label class="block mb-1.5 font-medium text-slate-700 text-sm">Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full border border-slate-300 bg-slate-50 rounded-xl px-4 py-2.5 focus:bg-white focus:ring-2 focus:ring-blue-500 transition disabled:opacity-70" disabled>
                    @error('email') <small class="text-red-600">{{ $message }}</small> @enderror
                </div>

                <div>
                    <label class="block mb-1.5 font-medium text-slate-700 text-sm">No HP / WhatsApp</label>
                    <input type="text" name="no_hp" value="{{ old('no_hp', $user->no_hp) }}" class="w-full border border-slate-300 bg-slate-50 rounded-xl px-4 py-2.5 focus:bg-white focus:ring-2 focus:ring-blue-500 transition disabled:opacity-70" disabled>
                    @error('no_hp') <small class="text-red-600">{{ $message }}</small> @enderror
                </div>

                @if($user->role !== 'superadmin')
                    <div>
                        <label class="block mb-1.5 font-medium text-slate-700 text-sm">Jenis Pengguna</label>
                        <select name="jenis_pengguna" class="w-full border border-slate-300 bg-slate-50 rounded-xl px-4 py-2.5 focus:bg-white focus:ring-2 focus:ring-blue-500 transition disabled:opacity-70" disabled>
                            <option value="">-- Pilih --</option>
                            <option value="siswa" {{ old('jenis_pengguna', $user->jenis_pengguna) === 'siswa' ? 'selected' : '' }}>Siswa</option>
                            <option value="guru" {{ old('jenis_pengguna', $user->jenis_pengguna) === 'guru' ? 'selected' : '' }}>Guru</option>
                        </select>
                        @error('jenis_pengguna') <small class="text-red-600">{{ $message }}</small> @enderror
                    </div>

                    <div>
                        <label class="block mb-1.5 font-medium text-slate-700 text-sm">Asal / Kelas / Jabatan</label>
                        <input type="text" name="asal_kelas_jabatan" value="{{ old('asal_kelas_jabatan', $user->asal_kelas_jabatan) }}" class="w-full border border-slate-300 bg-slate-50 rounded-xl px-4 py-2.5 focus:bg-white focus:ring-2 focus:ring-blue-500 transition disabled:opacity-70" disabled>
                        @error('asal_kelas_jabatan') <small class="text-red-600">{{ $message }}</small> @enderror
                    </div>

                    @if($user->role === 'peminjam')
                        <div>
                            <label class="block mb-1.5 font-medium text-slate-700 text-sm">Jurusan</label>
                            <select name="jurusan_id" class="w-full border border-slate-300 bg-slate-50 rounded-xl px-4 py-2.5 focus:bg-white focus:ring-2 focus:ring-blue-500 transition disabled:opacity-70" disabled>
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
            </div>

            <!-- Password Change Section -->
            <div class="hidden profile-edit-field space-y-6 pt-6 border-t border-slate-100 mt-6">
                <h4 class="font-bold text-slate-800">Ubah Password <span class="text-sm font-normal text-slate-500 ml-2">(Kosongkan jika tidak ingin diubah)</span></h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block mb-1.5 font-medium text-slate-700 text-sm">Password Baru</label>
                        <input type="password" name="password" class="w-full border border-slate-300 bg-slate-50 rounded-xl px-4 py-2.5 focus:bg-white focus:ring-2 focus:ring-blue-500 transition" disabled>
                        @error('password') <small class="text-red-600">{{ $message }}</small> @enderror
                    </div>
                    <div>
                        <label class="block mb-1.5 font-medium text-slate-700 text-sm">Konfirmasi Password Baru</label>
                        <input type="password" name="password_confirmation" class="w-full border border-slate-300 bg-slate-50 rounded-xl px-4 py-2.5 focus:bg-white focus:ring-2 focus:ring-blue-500 transition" disabled>
                    </div>
                </div>
            </div>

            <div class="flex gap-3 justify-end pt-4 hidden profile-edit-field mt-6 border-t border-slate-100">
                <button type="button" id="btn-cancel" class="px-5 py-2.5 bg-slate-100 text-slate-700 rounded-xl hover:bg-slate-200 transition font-medium text-sm">Batal</button>
                <button type="submit" class="px-5 py-2.5 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition font-medium text-sm">Simpan Perubahan</button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const btnEdit = document.getElementById('btn-edit');
            const btnCancel = document.getElementById('btn-cancel');
            const form = document.getElementById('profile-form');
            const editFields = document.querySelectorAll('.profile-edit-field');
            const inputs = form.querySelectorAll('input:not([type="hidden"]), select');

            // Set initial state
            inputs.forEach(input => input.disabled = true);
            
            // Check if there are validation errors, if so, force edit mode
            const hasErrors = @json($errors->any());
            
            function toggleEditMode(enable) {
                if (enable) {
                    btnEdit.classList.add('hidden');
                    editFields.forEach(el => el.classList.remove('hidden'));
                    inputs.forEach(input => input.disabled = false);
                } else {
                    btnEdit.classList.remove('hidden');
                    editFields.forEach(el => el.classList.add('hidden'));
                    inputs.forEach(input => input.disabled = true);
                }
            }

            if (hasErrors) {
                toggleEditMode(true);
            }

            btnEdit.addEventListener('click', () => toggleEditMode(true));
            btnCancel.addEventListener('click', () => {
                // If there are no errors, just toggle UI, else reload page to clear errors
                if (hasErrors) {
                    window.location.reload();
                } else {
                    toggleEditMode(false);
                    form.reset(); // Revert to original values
                }
            });
        });
    </script>
</x-dashboard-layout>