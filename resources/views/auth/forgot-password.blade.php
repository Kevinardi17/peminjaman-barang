<x-guest-layout>
    <div class="w-full max-w-md">
        <div class="bg-white rounded-[22px] shadow-lg border border-slate-200 px-8 py-10">
            <div class="flex flex-col items-center text-center mb-6">
                <img src="{{ asset('images/logo-smkn5.png') }}" class="w-16 h-16 mb-4">
                <h1 class="text-2xl font-extrabold text-slate-900">
                    Lupa Kata Sandi
                </h1>
                <p class="text-slate-600 text-sm mt-2">
                    Masukkan email kamu, kami akan kirim link untuk reset kata sandi.
                </p>
            </div>

            @if (session('status'))
                <div class="mb-4 rounded-xl bg-green-100 text-green-700 px-4 py-3 text-sm">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
                @csrf

                <div>
                    <label for="email" class="block text-sm font-semibold text-slate-700 mb-2">
                        Email
                    </label>
                    <input
                        id="email"
                        name="email"
                        type="email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-blue-500 focus:ring-blue-500"
                    >
                    @error('email')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <button
                    type="submit"
                    class="w-full rounded-xl bg-blue-600 py-3.5 text-lg font-bold text-white hover:bg-blue-700 transition"
                >
                    Kirim Link Reset Kata Sandi
                </button>

                <a
                    href="{{ route('login') }}"
                    class="flex w-full items-center justify-center rounded-xl bg-slate-100 py-3.5 text-lg font-semibold text-slate-800 border border-slate-200 hover:bg-slate-200 transition"
                >
                    Kembali ke Login
                </a>
            </form>
        </div>
    </div>
</x-guest-layout>