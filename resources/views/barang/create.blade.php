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
                <input type="number" id="input-stok" name="stok" value="{{ old('stok', 0) }}" class="w-full border rounded-lg px-3 py-2" min="0">
                @error('stok') <small class="text-red-600">{{ $message }}</small> @enderror
            </div>

            <div>
                <label class="block mb-1 font-medium">Kondisi Masing-Masing Barang</label>
                <div id="kondisi-container" class="space-y-2 p-3 border rounded-lg bg-slate-50 max-h-64 overflow-y-auto">
                    <!-- Text inputs akan di-generate oleh JS -->
                </div>
                <input type="hidden" id="input-kondisi" name="kondisi" value="{{ old('kondisi', 'Baik') }}">
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    const stokInput = document.getElementById('input-stok');
    const container = document.getElementById('kondisi-container');
    const kondisiInput = document.getElementById('input-kondisi');

    function decodeKondisi(str, stok) {
        let result = [];
        if (!str) {
            for(let i=0; i<stok; i++) result.push('Baik');
            return result;
        }
        
        const parts = str.split(',');
        for (let p of parts) {
            p = p.trim();
            const match = p.match(/^(\d+)\s+(.+)$/);
            if (match) {
                const count = parseInt(match[1]);
                const cond = match[2];
                for (let i=0; i<count; i++) result.push(cond);
            } else {
                if (p) {
                    for(let i=0; i<stok; i++) result.push(p);
                    break;
                }
            }
        }
        
        while(result.length < stok) result.push('Baik');
        return result.slice(0, stok);
    }

    function encodeKondisi() {
        const inputs = container.querySelectorAll('input[type="text"]');
        const counts = {};
        inputs.forEach(inp => {
            const val = inp.value.trim() || 'Baik';
            counts[val] = (counts[val] || 0) + 1;
        });
        
        const parts = [];
        for (let [cond, count] of Object.entries(counts)) {
            parts.push(`${count} ${cond}`);
        }
        kondisiInput.value = parts.join(', ');
    }

    function renderInputs() {
        const stok = parseInt(stokInput.value) || 0;
        const existingInputs = Array.from(container.querySelectorAll('input[type="text"]')).map(s => s.value);
        
        let initialArr = [];
        if (existingInputs.length === 0 && kondisiInput.value) {
            initialArr = decodeKondisi(kondisiInput.value, stok);
        } else {
            initialArr = existingInputs;
        }

        container.innerHTML = '';
        
        if (stok === 0) {
            container.innerHTML = '<p class="text-sm text-slate-500 italic">Isi jumlah stok terlebih dahulu.</p>';
            kondisiInput.value = '';
            return;
        }

        for (let i = 0; i < stok; i++) {
            const val = initialArr[i] || 'Baik';
            
            const div = document.createElement('div');
            div.className = 'flex items-center gap-3 bg-white p-2 border border-slate-200 rounded-lg shadow-sm';
            
            const label = document.createElement('span');
            label.className = 'text-sm font-bold w-24 text-slate-700';
            label.textContent = `Barang #${i + 1}`;
            
            const input = document.createElement('input');
            input.type = 'text';
            input.className = 'flex-1 border-slate-300 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500 py-2 px-3';
            input.value = val;
            
            input.addEventListener('input', encodeKondisi);
            
            div.appendChild(label);
            div.appendChild(input);
            container.appendChild(div);
        }
        
        encodeKondisi();
    }

    stokInput.addEventListener('input', renderInputs);
    renderInputs();
});
</script>