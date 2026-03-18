<x-dashboard-layout title="Edit Kategori">
    <div class="bg-white rounded-2xl shadow-sm border p-5 max-w-2xl">
        <form action="{{ route('kategori.update', $kategori) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block mb-1 font-medium">Jurusan</label>
                <select name="jurusan_id" class="w-full border rounded-lg px-3 py-2">
                    <option value="">-- Pilih Jurusan --</option>
                    @foreach($jurusans as $jurusan)
                        <option value="{{ $jurusan->id }}" {{ old('jurusan_id', $kategori->jurusan_id) == $jurusan->id ? 'selected' : '' }}>
                            {{ $jurusan->kode }} - {{ $jurusan->nama }}
                        </option>
                    @endforeach
                </select>
                @error('jurusan_id') <small class="text-red-600">{{ $message }}</small> @enderror
            </div>

            <div>
                <label class="block mb-1 font-medium">Nama Kategori</label>
                <input type="text" name="nama" value="{{ old('nama', $kategori->nama) }}" class="w-full border rounded-lg px-3 py-2">
                @error('nama') <small class="text-red-600">{{ $message }}</small> @enderror
            </div>

            <div>
                <label class="block mb-1 font-medium">Deskripsi</label>
                <textarea name="deskripsi" rows="4" class="w-full border rounded-lg px-3 py-2">{{ old('deskripsi', $kategori->deskripsi) }}</textarea>
                @error('deskripsi') <small class="text-red-600">{{ $message }}</small> @enderror
            </div>

            <div class="flex gap-2">
                <a href="{{ route('kategori.index') }}" class="px-4 py-2 bg-slate-200 rounded-lg">Kembali</a>
                <button type="submit" class="px-4 py-2 bg-yellow-500 text-white rounded-lg">Update</button>
            </div>
        </form>
    </div>
</x-dashboard-layout>