<x-guest-layout>
    <div class="w-full max-w-3xl">
        <div class="bg-white rounded-[20px] shadow-lg border border-slate-200 px-6 py-8">
            <div class="flex flex-col items-center text-center mb-6">
                <img src="{{ asset('images/logo.png') }}" alt="Logo SMKN 5" class="w-20 h-20 object-contain mb-3">
                <h1 class="text-lg md:text-xl font-semibold text-slate-900">
                    SMK N 5 BANDAR LAMPUNG
                </h1>
                <p class="text-slate-600 mt-2">Sistem Peminjaman Barang</p>
            </div>

            <form method="POST" action="{{ route('register') }}" class="space-y-4 md:space-y-0 md:grid md:grid-cols-2 md:gap-5">
                @csrf

                <div>
                    <label for="name" class="block text-sm font-semibold text-slate-700 mb-2">Nama <span class="text-red-500">*</span></label>
                    <input
                        id="name"
                        name="name"
                        type="text"
                        value="{{ old('name') }}"
                        required
                        autofocus
                        autocomplete="name"
                        class="w-full rounded-xl border border-slate-300 px-4 py-2.5 focus:border-blue-500 focus:ring-blue-500"
                    >
                    @error('name')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-semibold text-slate-700 mb-2">Email <span class="text-red-500">*</span></label>
                    <input
                        id="email"
                        name="email"
                        type="email"
                        value="{{ old('email') }}"
                        required
                        autocomplete="username"
                        class="w-full rounded-xl border border-slate-300 px-4 py-2.5 focus:border-blue-500 focus:ring-blue-500"
                    >
                    @error('email')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="no_hp" class="block text-sm font-semibold text-slate-700 mb-2">No. HP <span class="text-red-500">*</span></label>
                    <input
                        id="no_hp"
                        name="no_hp"
                        type="text"
                        value="{{ old('no_hp') }}"
                        required
                        placeholder="08xxxxxxxxxx atau 628xxxxxxxxx"
                        class="w-full rounded-xl border border-slate-300 px-4 py-2.5 focus:border-blue-500 focus:ring-blue-500"
                    >
                    <p class="mt-1 text-xs text-slate-500">Minimal 10 angka dan diawali dengan 08 atau 62.</p>
                    @error('no_hp')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="jenis_pengguna" class="block text-sm font-semibold text-slate-700 mb-2">Jenis Pengguna <span class="text-red-500">*</span></label>
                    <select
                        id="jenis_pengguna"
                        name="jenis_pengguna"
                        required
                        class="w-full rounded-xl border border-slate-300 px-4 py-2.5 focus:border-blue-500 focus:ring-blue-500"
                    >
                        <option value="">-- Pilih --</option>
                        <option value="siswa" {{ old('jenis_pengguna') == 'siswa' ? 'selected' : '' }}>Siswa</option>
                        <option value="guru" {{ old('jenis_pengguna') == 'guru' ? 'selected' : '' }}>Guru</option>
                    </select>
                    @error('jenis_pengguna')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="asal_kelas_jabatan" class="block text-sm font-semibold text-slate-700 mb-2">Asal / Kelas / Jabatan <span class="text-red-500">*</span></label>
                    <input
                        id="asal_kelas_jabatan"
                        name="asal_kelas_jabatan"
                        type="text"
                        value="{{ old('asal_kelas_jabatan') }}"
                        required
                        class="w-full rounded-xl border border-slate-300 px-4 py-2.5 focus:border-blue-500 focus:ring-blue-500"
                    >
                    @error('asal_kelas_jabatan')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="jurusan_id" class="block text-sm font-semibold text-slate-700 mb-2">Jurusan Asal <span class="text-red-500">*</span></label>
                    <select
                        id="jurusan_id"
                        name="jurusan_id"
                        required
                        class="w-full rounded-xl border border-slate-300 px-4 py-2.5 focus:border-blue-500 focus:ring-blue-500"
                    >
                        <option value="">-- Pilih Jurusan --</option>
                        @foreach($jurusans as $jurusan)
                            <option value="{{ $jurusan->id }}" {{ old('jurusan_id') == $jurusan->id ? 'selected' : '' }}>
                                {{ $jurusan->kode }} - {{ $jurusan->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('jurusan_id')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-semibold text-slate-700 mb-2">Kata Sandi <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <input
                            id="password"
                            name="password"
                            type="password"
                            required
                            autocomplete="new-password"
                            class="w-full rounded-xl border border-slate-300 px-4 py-2.5 focus:border-blue-500 focus:ring-blue-500 pr-10"
                        >
                        <button type="button" onclick="togglePassword('password', 'eye-icon-pw')" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-500 hover:text-slate-700">
                            <svg id="eye-icon-pw" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                              <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            </svg>
                        </button>
                    </div>
                    <p class="mt-1 text-xs text-slate-500">Minimal 8 karakter.</p>
                    @error('password')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-semibold text-slate-700 mb-2">Konfirmasi Kata Sandi <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <input
                            id="password_confirmation"
                            name="password_confirmation"
                            type="password"
                            required
                            autocomplete="new-password"
                            class="w-full rounded-xl border border-slate-300 px-4 py-2.5 focus:border-blue-500 focus:ring-blue-500 pr-10"
                        >
                        <button type="button" onclick="togglePassword('password_confirmation', 'eye-icon-pw-conf')" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-500 hover:text-slate-700">
                            <svg id="eye-icon-pw-conf" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                              <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="md:col-span-2 space-y-4 pt-2">
                    <button
                        type="submit"
                        class="w-full rounded-xl bg-blue-600 py-2.5 text-base font-bold text-white shadow hover:bg-blue-700 transition"
                    >
                        Daftar
                    </button>

                    <a
                        href="{{ route('login') }}"
                        class="flex w-full items-center justify-center rounded-xl bg-slate-100 py-2.5 text-base font-semibold text-slate-800 border border-slate-200 hover:bg-slate-200 transition"
                    >
                        Sudah punya akun? Login
                    </a>
                </div>
            </form>
        </div>
    </div>
    <script>
        function togglePassword(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            if (input.type === 'password') {
                input.type = 'text';
                icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />';
            } else {
                input.type = 'password';
                icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />';
            }
        }
    </script>
</x-guest-layout>