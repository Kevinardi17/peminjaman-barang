<x-dashboard-layout title="Ajukan Peminjaman">
    <form action="{{ route('peminjaman.store') }}" method="POST" id="form-peminjaman" class="max-w-6xl mx-auto space-y-6">
        @csrf

        <!-- Error Alert -->
        @if($errors->any())
            <div class="bg-red-50 border border-red-200 p-4 rounded-2xl shadow-sm mb-6">
                <div class="flex items-start">
                    <div class="flex-shrink-0 mt-0.5">
                        <svg class="h-5 w-5 text-red-500" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-bold text-red-800">Terdapat kesalahan pada isian:</h3>
                        <ul class="mt-1 text-sm text-red-700 list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <!-- Informasi Peminjaman -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 md:p-8">
            <div class="mb-6 border-b border-slate-100 pb-4">
                <h3 class="text-xl font-bold text-slate-800">1. Informasi Peminjaman</h3>
                <p class="text-sm text-slate-500 mt-1">Pilih jurusan tujuan dan rentang waktu peminjaman Anda.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="md:col-span-1">
                    <label class="block mb-1.5 font-medium text-sm text-slate-700">Jurusan Tujuan</label>
                    <select name="jurusan_tujuan_id" id="jurusan_tujuan_id" class="w-full border border-slate-300 bg-slate-50 rounded-xl px-4 py-2.5 focus:bg-white focus:ring-2 focus:ring-blue-500 transition cursor-pointer" required>
                        <option value="">-- Pilih Jurusan --</option>
                        @foreach($jurusans as $jurusan)
                            <option value="{{ $jurusan->id }}" {{ old('jurusan_tujuan_id') == $jurusan->id ? 'selected' : '' }}>
                                {{ $jurusan->kode }} - {{ $jurusan->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block mb-1.5 font-medium text-sm text-slate-700">Tanggal Pinjam</label>
                    <input type="date" name="tanggal_pinjam" value="{{ old('tanggal_pinjam') }}" class="w-full border border-slate-300 bg-slate-50 rounded-xl px-4 py-2.5 focus:bg-white focus:ring-2 focus:ring-blue-500 transition cursor-pointer" required>
                </div>
                <div>
                    <label class="block mb-1.5 font-medium text-sm text-slate-700">Tanggal Rencana Kembali</label>
                    <input type="date" name="tanggal_rencana_kembali" value="{{ old('tanggal_rencana_kembali') }}" class="w-full border border-slate-300 bg-slate-50 rounded-xl px-4 py-2.5 focus:bg-white focus:ring-2 focus:ring-blue-500 transition cursor-pointer" required>
                </div>
            </div>
        </div>

        <!-- Pilih Barang -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 md:p-8">
            <div class="mb-6 flex flex-col sm:flex-row sm:justify-between sm:items-end gap-4 border-b border-slate-100 pb-4">
                <div>
                    <h3 class="text-xl font-bold text-slate-800">2. Pilih Barang</h3>
                    <p class="text-sm text-slate-500 mt-1">Daftar barang yang ditampilkan menyesuaikan jurusan tujuan.</p>
                </div>
                <div class="text-sm font-semibold bg-slate-100 text-slate-600 px-4 py-2 rounded-xl transition-colors">
                    Item Dipilih: <span id="selected-count" class="ml-1 px-2 py-0.5 bg-white rounded-md border border-slate-200">0</span>
                </div>
            </div>

            <!-- Grid Barang -->
            <div id="grid-barang" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
                @foreach($barangs as $barang)
                    <div class="barang-item flex flex-col bg-white rounded-2xl border-2 border-slate-100 shadow-sm overflow-hidden transition-all duration-200 hover:shadow-md hover:border-blue-200 cursor-pointer group"
                        data-jurusan="{{ $barang->jurusan_id }}"
                        style="display: none;">
                        
                        <!-- Gambar & Badge -->
                        <div class="relative h-44 bg-slate-100 flex items-center justify-center overflow-hidden border-b border-slate-100">
                            @if($barang->foto)
                                <img src="{{ asset('storage/' . $barang->foto) }}" alt="{{ $barang->nama_barang }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            @else
                                <svg class="w-16 h-16 text-slate-300 group-hover:scale-110 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                </svg>
                            @endif
                            <div class="absolute top-3 left-3 bg-white/90 backdrop-blur-sm text-xs font-bold px-2.5 py-1 rounded-lg shadow-sm text-slate-700 border border-slate-200/50">
                                Stok: {{ $barang->stok }}
                            </div>
                            <div class="absolute top-3 right-3 bg-white border-2 border-slate-200 rounded-lg w-7 h-7 flex items-center justify-center checkbox-indicator transition-colors shadow-sm">
                                <svg class="w-4 h-4 text-white opacity-0 check-icon transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                        </div>

                        <!-- Info Barang -->
                        <div class="p-4 flex-1 flex flex-col justify-between">
                            <div>
                                <h4 class="font-bold text-slate-800 leading-tight line-clamp-2" title="{{ $barang->nama_barang }}">{{ $barang->nama_barang }}</h4>
                                <p class="text-xs text-slate-500 mt-1.5 font-medium px-2 py-0.5 bg-slate-100 inline-block rounded-md">{{ $barang->kategori->nama ?? 'Umum' }}</p>
                            </div>
                            
                            <!-- Input Jumlah -->
                            <div class="mt-4 pt-4 border-t border-slate-100 flex items-center justify-between" onclick="event.stopPropagation();">
                                <label class="text-sm font-semibold text-slate-600">Jumlah Pinjam:</label>
                                <input
                                    type="number"
                                    name="jumlah[{{ $barang->id }}]"
                                    min="1"
                                    max="{{ $barang->stok }}"
                                    value="{{ old('jumlah.' . $barang->id, 1) }}"
                                    class="w-20 text-center border border-slate-300 rounded-lg px-2 py-1.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm font-bold text-slate-800"
                                >
                                <input
                                    type="checkbox"
                                    class="barang-checkbox hidden"
                                    name="barang_id[]"
                                    value="{{ $barang->id }}"
                                    {{ in_array($barang->id, old('barang_id', [])) ? 'checked' : '' }}
                                >
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Empty State -->
            <div id="empty-barang" class="hidden text-center py-20 px-4">
                <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-slate-100 mb-5">
                    <svg class="w-10 h-10 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                </div>
                <h4 id="empty-title" class="text-xl font-bold text-slate-800">Pilih Jurusan Tujuan</h4>
                <p id="empty-desc" class="text-slate-500 mt-2 max-w-md mx-auto">Silakan pilih jurusan tujuan di atas untuk melihat daftar barang yang tersedia untuk dipinjam.</p>
            </div>
        </div>

        <!-- Form Actions (Sticky Bottom) -->
        <div class="flex justify-end gap-3 sticky bottom-6 bg-white/90 backdrop-blur-md p-4 rounded-2xl shadow-lg border border-slate-200/60 z-10">
            <a href="{{ route('peminjaman.index') }}" class="px-6 py-2.5 bg-slate-100 text-slate-700 rounded-xl hover:bg-slate-200 transition font-medium">Batal</a>
            <button type="submit" class="px-8 py-2.5 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition font-bold shadow-md shadow-blue-500/30 flex items-center gap-2">
                Kirim Pengajuan
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
            </button>
        </div>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const formPeminjaman = document.getElementById('form-peminjaman');
            const jurusanSelect = document.getElementById('jurusan_tujuan_id');
            const barangItems = document.querySelectorAll('.barang-item');
            const emptyBarang = document.getElementById('empty-barang');
            const emptyTitle = document.getElementById('empty-title');
            const emptyDesc = document.getElementById('empty-desc');
            const gridBarang = document.getElementById('grid-barang');
            const selectedCountEl = document.getElementById('selected-count');

            // Function to update visual state of card when checked
            function updateCardVisual(item) {
                const checkbox = item.querySelector('.barang-checkbox');
                const indicator = item.querySelector('.checkbox-indicator');
                const icon = item.querySelector('.check-icon');
                
                if (checkbox.checked) {
                    item.classList.add('border-blue-500', 'ring-2', 'ring-blue-100', 'bg-blue-50/20');
                    item.classList.remove('border-slate-100');
                    indicator.classList.add('bg-blue-600', 'border-blue-600');
                    indicator.classList.remove('bg-white', 'border-slate-200');
                    icon.classList.remove('opacity-0');
                } else {
                    item.classList.remove('border-blue-500', 'ring-2', 'ring-blue-100', 'bg-blue-50/20');
                    item.classList.add('border-slate-100');
                    indicator.classList.remove('bg-blue-600', 'border-blue-600');
                    indicator.classList.add('bg-white', 'border-slate-200');
                    icon.classList.add('opacity-0');
                }
                updateSelectedCount();
            }

            function updateSelectedCount() {
                const count = document.querySelectorAll('.barang-checkbox:checked').length;
                selectedCountEl.textContent = count;
                const parentBadge = selectedCountEl.parentElement;
                
                if(count > 0) {
                    parentBadge.classList.add('bg-blue-100', 'text-blue-800', 'border-blue-200');
                    parentBadge.classList.remove('bg-slate-100', 'text-slate-600', 'border-transparent');
                } else {
                    parentBadge.classList.remove('bg-blue-100', 'text-blue-800', 'border-blue-200');
                    parentBadge.classList.add('bg-slate-100', 'text-slate-600', 'border-transparent');
                }
            }

            // Toggle card checkbox when clicking on the card
            barangItems.forEach(item => {
                item.addEventListener('click', function() {
                    const checkbox = this.querySelector('.barang-checkbox');
                    checkbox.checked = !checkbox.checked;
                    updateCardVisual(this);
                    applyCheckboxValidation();
                });
                
                // Initialize visual state (in case of old input)
                updateCardVisual(item);
            });

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
                    visibleCheckboxes[0].setCustomValidity('Harap pilih minimal 1 barang dengan mengklik kartunya.');
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
                        item.style.display = 'flex'; // Reset to flex to use our classes
                        visibleCount++;
                    } else {
                        item.style.display = 'none';
                        checkbox.checked = false;
                        checkbox.required = false;
                        checkbox.setCustomValidity('');
                        updateCardVisual(item);
                    }
                });

                if (!selectedJurusan) {
                    emptyTitle.textContent = 'Pilih Jurusan Tujuan';
                    emptyDesc.textContent = 'Silakan pilih jurusan tujuan di atas untuk melihat daftar barang yang tersedia untuk dipinjam.';
                    emptyBarang.classList.remove('hidden');
                    gridBarang.classList.add('hidden');
                } else if (visibleCount === 0) {
                    emptyTitle.textContent = 'Barang Kosong';
                    emptyDesc.textContent = 'Tidak ada barang yang tersedia atau stok habis pada jurusan ini.';
                    emptyBarang.classList.remove('hidden');
                    gridBarang.classList.add('hidden');
                } else {
                    emptyBarang.classList.add('hidden');
                    gridBarang.classList.remove('hidden');
                }

                applyCheckboxValidation();
                updateSelectedCount();
            }

            jurusanSelect.addEventListener('change', filterBarangByJurusan);

            formPeminjaman.addEventListener('submit', function () {
                applyCheckboxValidation();
            });

            // Prevent number input from affecting max/min values unexpectedly
            const numberInputs = document.querySelectorAll('input[type="number"]');
            numberInputs.forEach(input => {
                input.addEventListener('change', function() {
                    const max = parseInt(this.getAttribute('max'));
                    const min = parseInt(this.getAttribute('min'));
                    let val = parseInt(this.value);
                    
                    if (val > max) this.value = max;
                    if (val < min || isNaN(val)) this.value = min;
                });
            });

            // Run on load
            filterBarangByJurusan();
        });
    </script>
</x-dashboard-layout>