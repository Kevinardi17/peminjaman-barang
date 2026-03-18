<x-dashboard-layout title="Edit Jurusan">
    <div class="bg-white rounded-2xl shadow-sm border p-5 max-w-2xl">
        <form action="{{ route('jurusan.update', $jurusan) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block mb-1 font-medium">Kode Jurusan</label>
                <input type="text" name="kode" value="{{ old('kode', $jurusan->kode) }}" class="w-full border rounded-lg px-3 py-2">
                @error('kode') <small class="text-red-600">{{ $message }}</small> @enderror
            </div>

            <div>
                <label class="block mb-1 font-medium">Nama Jurusan</label>
                <input type="text" name="nama" value="{{ old('nama', $jurusan->nama) }}" class="w-full border rounded-lg px-3 py-2">
                @error('nama') <small class="text-red-600">{{ $message }}</small> @enderror
            </div>

            <div class="flex gap-2">
                <a href="{{ route('jurusan.index') }}" class="px-4 py-2 bg-slate-200 rounded-lg">Kembali</a>
                <button type="submit" class="px-4 py-2 bg-yellow-500 text-white rounded-lg">Update</button>
            </div>
        </form>
    </div>
</x-dashboard-layout>