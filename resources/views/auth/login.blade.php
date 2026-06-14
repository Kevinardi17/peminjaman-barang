<x-guest-layout>
    <div class="w-full max-w-sm">
        <div class="bg-white rounded-[20px] shadow-lg border border-slate-200 px-6 py-8">
            <div class="flex flex-col items-center text-center mb-6">
                <img src="{{ asset('images/logo.png') }}" alt="Logo SMKN 5" class="w-20 h-20 object-contain mb-3">
                <h1 class="text-lg md:text-xl font-semibold text-slate-900">
                    SMK N 5 BANDAR LAMPUNG
                </h1>
                <p class="text-slate-600 mt-2">Sistem Peminjaman Barang</p>
            </div>

            @if (session('status'))
                <div class="mb-4 rounded-xl bg-green-100 text-green-700 px-4 py-3 text-sm">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf

                <div>
                    <label for="login" class="block text-sm font-semibold text-slate-700 mb-2">Email atau Nama</label>
                    <input
                        id="login"
                        name="login"
                        type="text"
                        value="{{ old('login') }}"
                        required
                        autofocus
                        autocomplete="username"
                        class="w-full rounded-xl border border-slate-300 px-4 py-2.5 focus:border-blue-500 focus:ring-blue-500"
                    >
                    @error('login')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-semibold text-slate-700 mb-2">Kata Sandi</label>
                    <div class="relative">
                        <input
                            id="password"
                            name="password"
                            type="password"
                            required
                            autocomplete="current-password"
                            class="w-full rounded-xl border border-slate-300 px-4 py-2.5 pr-12 focus:border-blue-500 focus:ring-blue-500"
                        >
                        <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-500 hover:text-slate-700">
                            <!-- Eye icon -->
                            <svg id="eye-icon" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <!-- Eye slash icon -->
                            <svg id="eye-slash-icon" class="h-5 w-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.978 9.978 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                            </svg>
                        </button>
                    </div>
                    @error('password')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center">
                    <label for="remember_me" class="inline-flex items-center gap-2 text-sm text-slate-600">
                        <input id="remember_me" type="checkbox" class="rounded border-slate-300 text-blue-600 shadow-sm focus:ring-blue-500" name="remember">
                        <span>Ingat saya</span>
                    </label>
                </div>

                <button
                    type="submit"
                    class="w-full rounded-xl bg-blue-600 py-2.5 text-base font-bold text-white shadow hover:bg-blue-700 transition"
                >
                    Masuk
                </button>

                <a
                    href="{{ route('register') }}"
                    class="flex w-full items-center justify-center rounded-xl bg-slate-100 py-2.5 text-base font-semibold text-slate-800 border border-slate-200 hover:bg-slate-200 transition"
                >
                    Daftar
                </a>

                <div class="flex items-center justify-between pt-1 text-sm">
                    @if (Route::has('password.request'))
                        <a class="text-slate-500 underline hover:text-slate-700" href="{{ route('password.request') }}">
                            Lupa kata sandi
                        </a>
                    @else
                        <span></span>
                    @endif

                    <span class="text-slate-400">Admin / User</span>
                </div>
            </form>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');
            const eyeSlashIcon = document.getElementById('eye-slash-icon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.add('hidden');
                eyeSlashIcon.classList.remove('hidden');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.remove('hidden');
                eyeSlashIcon.classList.add('hidden');
            }
        }
    </script>
</x-guest-layout>