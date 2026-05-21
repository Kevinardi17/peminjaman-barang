<x-guest-layout>
    <div class="w-full max-w-md">
        <div class="bg-white rounded-[22px] shadow-lg border border-slate-200 px-8 py-10">
            <div class="flex flex-col items-center text-center mb-8">
                <img src="{{ asset('images/logo-smkn5.png') }}" alt="Logo SMKN 5" class="w-24 h-24 object-contain mb-4">
                <h1 class="text-2xl font-bold text-slate-900">
                    SMK N 5 BANDAR LAMPUNG
                </h1>
                <p class="text-sm text-slate-600 mt-2">Sistem Peminjaman Barang</p>
            </div>

            <form method="POST" action="{{ route('register') }}" class="space-y-5">
                @csrf

                <div>
                    <label for="name" class="block text-sm font-semibold text-slate-700 mb-2">Nama</label>
                    <input
                        id="name"
                        name="name"
                        type="text"
                        value="{{ old('name') }}"
                        required
                        autofocus
                        autocomplete="name"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-blue-500 focus:ring-blue-500"
                    >
                    @error('name')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-semibold text-slate-700 mb-2">Email</label>
                    <input
                        id="email"
                        name="email"
                        type="email"
                        value="{{ old('email') }}"
                        required
                        autocomplete="username"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-blue-500 focus:ring-blue-500"
                    >
                    @error('email')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="no_hp" class="block text-sm font-semibold text-slate-700 mb-2">No. HP</label>
                    <input
                        id="no_hp"
                        name="no_hp"
                        type="text"
                        value="{{ old('no_hp') }}"
                        required
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-blue-500 focus:ring-blue-500"
                    >
                    @error('no_hp')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="jenis_pengguna" class="block text-sm font-semibold text-slate-700 mb-2">Jenis Pengguna</label>
                    <select
                        id="jenis_pengguna"
                        name="jenis_pengguna"
                        required
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-blue-500 focus:ring-blue-500"
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
                    <label for="asal_kelas_jabatan" class="block text-sm font-semibold text-slate-700 mb-2">Asal / Kelas / Jabatan</label>
                    <input
                        id="asal_kelas_jabatan"
                        name="asal_kelas_jabatan"
                        type="text"
                        value="{{ old('asal_kelas_jabatan') }}"
                        required
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-blue-500 focus:ring-blue-500"
                    >
                    @error('asal_kelas_jabatan')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="jurusan_id" class="block text-sm font-semibold text-slate-700 mb-2">Jurusan Asal</label>
                    <select
                        id="jurusan_id"
                        name="jurusan_id"
                        required
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-blue-500 focus:ring-blue-500"
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
                    <label for="password" class="block text-sm font-semibold text-slate-700 mb-2">Password</label>
                    <input
                        id="password"
                        name="password"
                        type="password"
                        required
                        autocomplete="new-password"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-blue-500 focus:ring-blue-500"
                    >
                    @error('password')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-semibold text-slate-700 mb-2">Konfirmasi Password</label>
                    <input
                        id="password_confirmation"
                        name="password_confirmation"
                        type="password"
                        required
                        autocomplete="new-password"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-blue-500 focus:ring-blue-500"
                    >
                </div>

                <button
                    type="submit"
                    class="w-full rounded-xl bg-blue-600 py-3 text-base font-semibold text-white shadow hover:bg-blue-700 transition"
                >
                    Register
                </button>

                <a
                    href="{{ route('login') }}"
                    class="flex w-full items-center justify-center rounded-xl bg-slate-100 py-3 text-base font-semibold text-slate-800 border border-slate-200 hover:bg-slate-200 transition"
                >
                    Sudah punya akun? Login
                </a>
            </form>
        </div>
    </div>
</x-guest-layout>