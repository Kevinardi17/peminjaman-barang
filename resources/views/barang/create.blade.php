<x-dashboard-layout title="Tambah Barang">
    <div class="bg-white rounded-2xl shadow-sm border p-5 max-w-2xl">
        <form action="{{ route('barang.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf

            <div>
                <label class="block mb-1 font-medium">Jurusan</label>
                <select name="jurusan_id" class="w-full border rounded-lg px-3 py-2">
                    <option value="">-- Pilih Jurusan --</option>
                    @foreach($jurusans as $jurusan)
                        <option value="{{ $jurusan->id }}" {{ old('jurusan_id') == $jurusan->id ? 'selected' : '' }}>
                            {{ $jurusan->kode }} - {{ $jurusan->nama }}
                        </option>
                    @endforeach
                </select>
                @error('jurusan_id') <small class="text-red-600">{{ $message }}</small> @enderror
            </div>

            <div>
                <label class="block mb-1 font-medium">Kategori</label>
                <select name="kategori_id" class="w-full border rounded-lg px-3 py-2">
                    <option value="">-- Pilih Kategori --</option>
                    @foreach($kategoris as $kategori)
                        <option value="{{ $kategori->id }}" {{ old('kategori_id') == $kategori->id ? 'selected' : '' }}>
                            {{ $kategori->nama }} ({{ $kategori->jurusan->kode }})
                        </option>
                    @endforeach
                </select>
                @error('kategori_id') <small class="text-red-600">{{ $message }}</small> @enderror
            </div>

            <div>
                <label class="block mb-1 font-medium">Kode Barang</label>
                <input type="text" name="kode_barang" value="{{ old('kode_barang') }}" class="w-full border rounded-lg px-3 py-2">
                @error('kode_barang') <small class="text-red-600">{{ $message }}</small> @enderror
            </div>

            <div>
                <label class="block mb-1 font-medium">Nama Barang</label>
                <input type="text" name="nama_barang" value="{{ old('nama_barang') }}" class="w-full border rounded-lg px-3 py-2">
                @error('nama_barang') <small class="text-red-600">{{ $message }}</small> @enderror
            </div>

            <div>
                <label class="block mb-1 font-medium">Stok</label>
                <input type="number" name="stok" value="{{ old('stok', 0) }}" class="w-full border rounded-lg px-3 py-2" min="0">
                @error('stok') <small class="text-red-600">{{ $message }}</small> @enderror
            </div>

            <div>
                <label class="block mb-1 font-medium">Kondisi</label>
                <input type="text" name="kondisi" value="{{ old('kondisi', 'baik') }}" class="w-full border rounded-lg px-3 py-2">
                @error('kondisi') <small class="text-red-600">{{ $message }}</small> @enderror
            </div>

            <div>
                <label class="block mb-1 font-medium">Keterangan</label>
                <textarea name="keterangan" rows="4" class="w-full border rounded-lg px-3 py-2">{{ old('keterangan') }}</textarea>
                @error('keterangan') <small class="text-red-600">{{ $message }}</small> @enderror
            </div>

            <div>
                <label class="block mb-1 font-medium">Foto Barang (Opsional)</label>
                <input type="file" name="foto" class="w-full border rounded-lg px-3 py-2 text-sm" accept="image/*">
                @error('foto') <small class="text-red-600">{{ $message }}</small> @enderror
            </div>

            <div class="flex gap-2">
                <a href="{{ route('barang.index') }}" class="px-4 py-2 bg-slate-200 rounded-lg">Kembali</a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg">Simpan</button>
            </div>
        </form>
    </div>
</x-dashboard-layout>