<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required
                autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required
                autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- No. HP -->
        <div>
            <x-input-label for="no_hp" :value="'No. HP'" />
            <x-text-input id="no_hp" class="block mt-1 w-full" type="text" name="no_hp" :value="old('no_hp')"
                required />
            <x-input-error :messages="$errors->get('no_hp')" class="mt-2" />
        </div>

        <!-- Jenis Pengguna -->
        <div class="mt-4">
            <x-input-label for="jenis_pengguna" :value="'Jenis Pengguna'" />
            <select id="jenis_pengguna" name="jenis_pengguna"
                class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                required>
                <option value="">-- Pilih --</option>
                <option value="siswa" {{ old('jenis_pengguna') == 'siswa' ? 'selected' : '' }}>Siswa</option>
                <option value="guru" {{ old('jenis_pengguna') == 'guru' ? 'selected' : '' }}>Guru</option>
            </select>
            <x-input-error :messages="$errors->get('jenis_pengguna')" class="mt-2" />
        </div>

        <!-- Asal / Kelas / Jabatan -->
        <div class="mt-4">
            <x-input-label for="asal_kelas_jabatan" :value="'Asal / Kelas / Jabatan'" />
            <x-text-input id="asal_kelas_jabatan" class="block mt-1 w-full" type="text" name="asal_kelas_jabatan"
                :value="old('asal_kelas_jabatan')" required />
            <x-input-error :messages="$errors->get('asal_kelas_jabatan')" class="mt-2" />
        </div>

        <!-- Jurusan Asal -->
        <div class="mt-4">
            <x-input-label for="jurusan_id" :value="'Jurusan Asal'" />
            <select id="jurusan_id" name="jurusan_id"
                class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                required>
                <option value="">-- Pilih Jurusan --</option>
                @foreach($jurusans as $jurusan)
                    <option value="{{ $jurusan->id }}" {{ old('jurusan_id') == $jurusan->id ? 'selected' : '' }}>
                        {{ $jurusan->kode }} - {{ $jurusan->nama }}
                    </option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('jurusan_id')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>