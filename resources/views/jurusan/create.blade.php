
<x-dashboard-layout title="Tambah Jurusan">
    <div class="bg-white rounded-2xl shadow-sm border p-5 max-w-2xl">
        <form action="{{ route('jurusan.store') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block mb-1 font-medium">Kode Jurusan</label>
                <input type="text" name="kode" value="{{ old('kode') }}" class="w-full border rounded-lg px-3 py-2">
                @error('kode') <small class="text-red-600">{{ $message }}</small> @enderror
            </div>

            <div>
                <label class="block mb-1 font-medium">Nama Jurusan</label>
                <input type="text" name="nama" value="{{ old('nama') }}" class="w-full border rounded-lg px-3 py-2">
                @error('nama') <small class="text-red-600">{{ $message }}</small> @enderror
            </div>

            <div class="flex gap-2">
                <a href="{{ route('jurusan.index') }}" class="px-4 py-2 bg-slate-200 rounded-lg">Kembali</a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg">Simpan</button>
            </div>
        </form>
    </div>
</x-dashboard-layout>