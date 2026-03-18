<x-dashboard-layout title="Ajukan Peminjaman">
    <div class="bg-white rounded-2xl shadow-sm border p-5 max-w-4xl">
        <form action="{{ route('peminjaman.store') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block mb-1 font-medium">Jurusan Tujuan</label>
                <select name="jurusan_tujuan_id" class="w-full border rounded-lg px-3 py-2" required>
                    <option value="">-- Pilih Jurusan --</option>
                    @foreach($jurusans as $jurusan)
                        <option value="{{ $jurusan->id }}">{{ $jurusan->kode }} - {{ $jurusan->nama }}</option>
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block mb-1 font-medium">Tanggal Pinjam</label>
                    <input type="date" name="tanggal_pinjam" class="w-full border rounded-lg px-3 py-2" required>
                </div>
                <div>
                    <label class="block mb-1 font-medium">Tanggal Rencana Kembali</label>
                    <input type="date" name="tanggal_rencana_kembali" class="w-full border rounded-lg px-3 py-2" required>
                </div>
            </div>

            <div class="space-y-3">
                <label class="block font-medium">Pilih Barang</label>

                @foreach($barangs as $barang)
                    <div class="border rounded-lg p-3 flex items-center justify-between gap-4">
                        <div>
                            <div class="font-medium">{{ $barang->nama_barang }}</div>
                            <div class="text-sm text-slate-500">{{ $barang->jurusan->kode }} | Stok: {{ $barang->stok }}</div>
                        </div>

                        <div class="flex items-center gap-2">
                            <input type="checkbox" name="barang_id[]" value="{{ $barang->id }}">
                            <input type="number" name="jumlah[]" min="1" value="1" class="w-24 border rounded-lg px-3 py-2">
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="flex gap-2">
                <a href="{{ route('peminjaman.index') }}" class="px-4 py-2 bg-slate-200 rounded-lg">Kembali</a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg">Ajukan</button>
            </div>
        </form>
    </div>
</x-dashboard-layout>