<x-guest-layout>
    <div class="w-full max-w-md">
        <div class="bg-white rounded-[22px] shadow-lg border border-slate-200 px-8 py-10">
            <div class="flex flex-col items-center text-center mb-8">
                <img src="{{ asset('images/logo.png') }}" alt="Logo SMKN 5" class="w-24 h-24 object-contain mb-4">
                <h1 class="text-xl md:text-2xl font-semibold text-slate-900">
                    SMK N 5 BANDAR LAMPUNG
                </h1>
                <p class="text-slate-600 mt-2">Sistem Peminjaman Barang</p>
            </div>

            @if (session('status'))
                <div class="mb-4 rounded-xl bg-green-100 text-green-700 px-4 py-3 text-sm">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <div>
                    <label for="email" class="block text-sm font-semibold text-slate-700 mb-2">Email</label>
                    <input
                        id="email"
                        name="email"
                        type="email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                        autocomplete="username"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-blue-500 focus:ring-blue-500"
                    >
                    @error('email')
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
                        autocomplete="current-password"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-blue-500 focus:ring-blue-500"
                    >
                    @error('password')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center">
                    <label for="remember_me" class="inline-flex items-center gap-2 text-sm text-slate-600">
                        <input id="remember_me" type="checkbox" class="rounded border-slate-300 text-blue-600 shadow-sm focus:ring-blue-500" name="remember">
                        <span>Remember me</span>
                    </label>
                </div>

                <button
                    type="submit"
                    class="w-full rounded-xl bg-blue-600 py-3.5 text-lg font-bold text-white shadow hover:bg-blue-700 transition"
                >
                    Log In
                </button>

                <a
                    href="{{ route('register') }}"
                    class="flex w-full items-center justify-center rounded-xl bg-slate-100 py-3.5 text-lg font-semibold text-slate-800 border border-slate-200 hover:bg-slate-200 transition"
                >
                    Register
                </a>

                <div class="flex items-center justify-between pt-1 text-sm">
                    @if (Route::has('password.request'))
                        <a class="text-slate-500 underline hover:text-slate-700" href="{{ route('password.request') }}">
                            Forgot your password?
                        </a>
                    @else
                        <span></span>
                    @endif

                    <span class="text-slate-400">Admin / User</span>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>