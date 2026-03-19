<x-dashboard-layout title="Ajukan Peminjaman">
    <div class="bg-white rounded-2xl shadow-sm border p-5 max-w-4xl">
        <form action="{{ route('peminjaman.store') }}" method="POST" class="space-y-4" id="form-peminjaman">
            @csrf

            <div>
                <label class="block mb-1 font-medium">Jurusan Tujuan</label>
                <select name="jurusan_tujuan_id" id="jurusan_tujuan_id" class="w-full border rounded-lg px-3 py-2" required>
                    <option value="">-- Pilih Jurusan --</option>
                    @foreach($jurusans as $jurusan)
                        <option value="{{ $jurusan->id }}" {{ old('jurusan_tujuan_id') == $jurusan->id ? 'selected' : '' }}>
                            {{ $jurusan->kode }} - {{ $jurusan->nama }}
                        </option>
                    @endforeach
                </select>
                @error('jurusan_tujuan_id')
                    <small class="text-red-600">{{ $message }}</small>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block mb-1 font-medium">Tanggal Pinjam</label>
                    <input type="date" name="tanggal_pinjam" value="{{ old('tanggal_pinjam') }}" class="w-full border rounded-lg px-3 py-2" required>
                    @error('tanggal_pinjam')
                        <small class="text-red-600">{{ $message }}</small>
                    @enderror
                </div>
                <div>
                    <label class="block mb-1 font-medium">Tanggal Rencana Kembali</label>
                    <input type="date" name="tanggal_rencana_kembali" value="{{ old('tanggal_rencana_kembali') }}" class="w-full border rounded-lg px-3 py-2" required>
                    @error('tanggal_rencana_kembali')
                        <small class="text-red-600">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="space-y-3">
                <label class="block font-medium">Pilih Barang</label>

                @error('barang_id')
                    <div class="mt-2 mb-2 rounded-lg bg-red-100 text-red-700 px-4 py-3">
                        {{ $message }}
                    </div>
                @enderror

                <div class="mb-2 text-sm text-slate-600">
                    Pilih barang sesuai dengan jurusan tujuan yang dipilih.
                </div>

                @foreach($barangs as $barang)
                    <div class="barang-item border rounded-lg p-3 flex items-center justify-between gap-4"
                        data-jurusan="{{ $barang->jurusan_id }}"
                        style="display: none;">
                        <div>
                            <div class="font-medium">{{ $barang->nama_barang }}</div>
                            <div class="text-sm text-slate-500">
                                Asal Jurusan:
                                <span class="font-medium">{{ $barang->jurusan->kode }} - {{ $barang->jurusan->nama }}</span>
                            </div>
                            <div class="text-sm text-slate-500">
                                Stok tersedia: {{ $barang->stok }}
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <input
                                type="checkbox"
                                class="barang-checkbox h-4 w-4"
                                name="barang_id[]"
                                value="{{ $barang->id }}"
                                {{ in_array($barang->id, old('barang_id', [])) ? 'checked' : '' }}
                            >

                            <input
                                type="number"
                                name="jumlah[{{ $barang->id }}]"
                                min="1"
                                value="{{ old('jumlah.' . $barang->id, 1) }}"
                                class="w-24 border rounded-lg px-3 py-2"
                            >
                        </div>
                    </div>
                @endforeach

                <div id="empty-barang" class="text-sm text-slate-500 border rounded-lg p-4">
                    Pilih jurusan tujuan terlebih dahulu.
                </div>
            </div>

            <div class="flex gap-2">
                <a href="{{ route('peminjaman.index') }}" class="px-4 py-2 bg-slate-200 rounded-lg">Kembali</a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg">Ajukan</button>
            </div>
        </form>
    </div>

    <script>
        const formPeminjaman = document.getElementById('form-peminjaman');
        const jurusanSelect = document.getElementById('jurusan_tujuan_id');
        const barangItems = document.querySelectorAll('.barang-item');
        const emptyBarang = document.getElementById('empty-barang');

        function getVisibleCheckboxes() {
            return Array.from(document.querySelectorAll('.barang-item'))
                .filter(item => item.style.display !== 'none')
                .map(item => item.querySelector('.barang-checkbox'));
        }

        function resetCheckboxValidation() {
            document.querySelectorAll('.barang-checkbox').forEach(cb => {
                cb.required = false;
                cb.setCustomValidity('');
            });
        }

        function applyCheckboxValidation() {
            resetCheckboxValidation();

            const visibleCheckboxes = getVisibleCheckboxes();
            if (visibleCheckboxes.length === 0) return;

            const anyChecked = visibleCheckboxes.some(cb => cb.checked);

            if (!anyChecked) {
                visibleCheckboxes[0].required = true;
                visibleCheckboxes[0].setCustomValidity('Harap checklist bidang ini.');
            }
        }

        function filterBarangByJurusan() {
            const selectedJurusan = jurusanSelect.value;
            let visibleCount = 0;

            barangItems.forEach(item => {
                const itemJurusan = item.getAttribute('data-jurusan');
                const checkbox = item.querySelector('.barang-checkbox');
                const jumlahInput = item.querySelector('input[type="number"]');

                if (selectedJurusan && itemJurusan === selectedJurusan) {
                    item.style.display = 'flex';
                    visibleCount++;
                } else {
                    item.style.display = 'none';
                    checkbox.checked = false;
                    checkbox.required = false;
                    checkbox.setCustomValidity('');
                    jumlahInput.value = 1;
                }
            });

            if (!selectedJurusan) {
                emptyBarang.textContent = 'Pilih jurusan tujuan terlebih dahulu.';
                emptyBarang.style.display = 'block';
            } else if (visibleCount === 0) {
                emptyBarang.textContent = 'Tidak ada barang tersedia pada jurusan ini.';
                emptyBarang.style.display = 'block';
            } else {
                emptyBarang.style.display = 'none';
            }

            applyCheckboxValidation();
        }

        jurusanSelect.addEventListener('change', filterBarangByJurusan);

        document.addEventListener('change', function (e) {
            if (e.target.classList.contains('barang-checkbox')) {
                applyCheckboxValidation();
            }
        });

        formPeminjaman.addEventListener('submit', function () {
            applyCheckboxValidation();
        });

        filterBarangByJurusan();
    </script>
</x-dashboard-layout>