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
                    <select name="jurusan_tujuan_id" id="jurusan_tujuan_id" class="w-full text-center border border-slate-200 bg-slate-100 text-slate-500 rounded-xl px-4 py-2.5 pointer-events-none appearance-none" style="background-image: none;" required>
                        <option value="">Otomatis terisi saat memilih barang</option>
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
            <div class="mb-6 flex flex-col md:flex-row md:justify-between md:items-end gap-4 border-b border-slate-100 pb-4">
                <div class="flex-1">
                    <h3 class="text-xl font-bold text-slate-800">2. Katalog Barang</h3>
                    <p class="text-sm text-slate-500 mt-1">Cari dan pilih barang. Jurusan akan otomatis disesuaikan.</p>
                </div>
                
                <!-- Filters & Search -->
                <div class="flex flex-col md:flex-row items-end gap-3 w-full md:w-auto flex-wrap">
                    <select id="filter-jurusan" class="w-full md:w-40 border border-slate-300 bg-white rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition cursor-pointer">
                        <option value="">Semua Jurusan</option>
                        @foreach($jurusans as $j)
                            <option value="{{ $j->id }}">{{ $j->kode }}</option>
                        @endforeach
                    </select>

                    <select id="filter-kategori" class="w-full md:w-40 border border-slate-300 bg-white rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition cursor-pointer">
                        <option value="">Semua Kategori</option>
                        @foreach($kategoris as $k)
                            <option value="{{ $k->id }}">{{ $k->nama }}</option>
                        @endforeach
                    </select>

                    <div class="relative w-full md:w-64">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        <input type="text" id="search-barang" class="w-full border border-slate-300 bg-white rounded-xl pl-10 pr-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition" placeholder="Cari nama barang...">
                    </div>
                </div>

                <div class="text-sm font-semibold bg-slate-100 text-slate-600 px-4 py-2.5 rounded-xl transition-colors h-fit flex-shrink-0">
                    Item Dipilih: <span id="selected-count" class="ml-1 px-2 py-0.5 bg-white rounded-md border border-slate-200">0</span>
                </div>
            </div>

            <!-- Grid Barang -->
            <div id="grid-barang" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
                @foreach($barangs as $barang)
                    <div class="barang-item flex flex-col bg-white rounded-2xl border-2 border-slate-100 shadow-sm overflow-hidden transition-all duration-300 hover:shadow-md hover:border-blue-200 cursor-pointer group"
                        data-jurusan="{{ $barang->jurusan_id }}"
                        data-kategori="{{ $barang->kategori_id }}"
                        data-nama="{{ strtolower($barang->nama_barang) }}"
                        style="display: flex;">
                        
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
                                <div class="flex items-center justify-between mt-2">
                                    <p class="text-xs text-slate-500 font-medium px-2 py-0.5 bg-slate-100 inline-block rounded-md">{{ $barang->kategori->nama ?? 'Umum' }}</p>
                                    
                                    @php
                                        $dipinjam = \App\Models\DetailPeminjaman::where('barang_id', $barang->id)
                                            ->whereHas('peminjaman', function($q) {
                                                $q->where('status', 'dipinjam');
                                            })->sum('jumlah');
                                        $tersedia = $barang->stok - $dipinjam;
                                    @endphp

                                    <button type="button" 
                                        onclick="event.stopPropagation(); openDetailModal(this)"
                                        data-nama="{{ $barang->nama_barang }}"
                                        data-kode="{{ $barang->kode_barang }}"
                                        data-kategori="{{ $barang->kategori->nama ?? 'Umum' }}"
                                        data-stok="{{ $barang->stok }}"
                                        data-tersedia="{{ $tersedia }}"
                                        data-kondisi="{{ $barang->kondisi }}"
                                        data-keterangan="{{ $barang->keterangan }}"
                                        data-foto="{{ $barang->foto ? asset('storage/' . $barang->foto) : '' }}"
                                        class="text-xs font-semibold text-blue-600 bg-blue-50 hover:bg-blue-100 px-2 py-1 rounded flex items-center gap-1 transition">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        Detail
                                    </button>
                                </div>
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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <h4 class="text-xl font-bold text-slate-800">Barang Tidak Ditemukan</h4>
                <p class="text-slate-500 mt-2 max-w-md mx-auto">Tidak ada barang yang cocok dengan kata kunci pencarian Anda.</p>
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

    <!-- Detail Modal -->
    <div id="detailModal" class="fixed inset-0 z-[100] flex items-center justify-center hidden opacity-0 transition-opacity duration-300">
        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="closeDetailModal()"></div>
        
        <div id="detailModalCard" class="relative bg-white rounded-3xl shadow-2xl border border-slate-200 w-full max-w-3xl mx-4 overflow-hidden transform scale-95 opacity-0 transition-all duration-300 flex flex-col max-h-[90vh]">
            <!-- Header -->
            <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                <h3 class="text-lg font-bold text-slate-800">Detail Barang</h3>
                <button onclick="closeDetailModal()" class="p-2 text-slate-400 hover:text-slate-600 hover:bg-slate-200/50 rounded-full transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            
            <!-- Body -->
            <div class="p-6 overflow-y-auto">
                <div class="flex flex-col md:flex-row gap-6">
                    <!-- Foto -->
                    <div class="w-full md:w-1/3 shrink-0">
                        <img id="modal-foto" src="" alt="Foto" class="w-full aspect-square object-cover rounded-2xl border border-slate-200 shadow-sm hidden">
                        <div id="modal-nofoto" class="w-full aspect-square bg-slate-50 flex flex-col items-center justify-center rounded-2xl border border-slate-200 text-slate-400">
                            <svg class="w-12 h-12 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" /></svg>
                            <span class="text-sm">Belum ada foto</span>
                        </div>
                    </div>
                    
                    <!-- Info -->
                    <div class="w-full md:w-2/3">
                        <div class="mb-5">
                            <h1 id="modal-nama" class="text-2xl font-bold text-slate-900 mb-1"></h1>
                            <p id="modal-kode" class="text-slate-500 font-mono text-sm"></p>
                        </div>

                        <div class="grid grid-cols-2 gap-3 mb-5">
                            <div class="bg-slate-50 p-3 rounded-xl border border-slate-100">
                                <h3 class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1">Kategori</h3>
                                <p id="modal-kategori" class="font-semibold text-slate-800 text-sm"></p>
                            </div>
                            <div class="bg-slate-50 p-3 rounded-xl border border-slate-100">
                                <h3 class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-1">Stok Tersedia</h3>
                                <p class="font-bold text-blue-600 text-base"><span id="modal-tersedia"></span> <span class="text-slate-400 font-medium text-xs">/ <span id="modal-stok"></span> total</span></p>
                            </div>
                            <div class="bg-slate-50 p-3 rounded-xl border border-slate-100 col-span-2">
                                <h3 class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-2">Kondisi Barang</h3>
                                <div id="modal-kondisi" class="flex flex-wrap gap-1.5"></div>
                            </div>
                        </div>

                        <div>
                            <h3 class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-2">Keterangan</h3>
                            <div id="modal-keterangan" class="p-4 bg-slate-50 rounded-xl text-slate-700 text-sm border border-slate-100 min-h-[80px]"></div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Footer -->
            <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50 flex justify-end">
                <button onclick="closeDetailModal()" class="px-5 py-2 bg-slate-800 text-white font-medium rounded-xl hover:bg-slate-900 transition shadow-sm">Tutup</button>
            </div>
        </div>
    </div>

    <script>
        // Modal functions
        function openDetailModal(btn) {
            const nama = btn.getAttribute('data-nama');
            const kode = btn.getAttribute('data-kode');
            const kategori = btn.getAttribute('data-kategori');
            const stok = btn.getAttribute('data-stok');
            const tersedia = btn.getAttribute('data-tersedia');
            const kondisi = btn.getAttribute('data-kondisi');
            const keterangan = btn.getAttribute('data-keterangan');
            const foto = btn.getAttribute('data-foto');

            document.getElementById('modal-nama').textContent = nama;
            document.getElementById('modal-kode').textContent = kode;
            document.getElementById('modal-kategori').textContent = kategori;
            document.getElementById('modal-stok').textContent = stok;
            document.getElementById('modal-tersedia').textContent = tersedia;
            document.getElementById('modal-keterangan').textContent = keterangan || 'Tidak ada keterangan.';

            // Kondisi
            const kondisiContainer = document.getElementById('modal-kondisi');
            kondisiContainer.innerHTML = '';
            if (kondisi) {
                kondisi.split(',').forEach(c => {
                    if (c.trim()) {
                        kondisiContainer.innerHTML += `<span class="px-2 py-1 bg-white border border-slate-200 text-slate-700 rounded-md text-[11px] font-bold shadow-sm">${c.trim()}</span>`;
                    }
                });
            } else {
                kondisiContainer.innerHTML = `<span class="text-slate-400 text-sm">-</span>`;
            }

            // Foto
            const imgEl = document.getElementById('modal-foto');
            const noImgEl = document.getElementById('modal-nofoto');
            if (foto) {
                imgEl.src = foto;
                imgEl.classList.remove('hidden');
                noImgEl.classList.add('hidden');
            } else {
                imgEl.classList.add('hidden');
                noImgEl.classList.remove('hidden');
            }

            // Show Modal
            const modal = document.getElementById('detailModal');
            const card = document.getElementById('detailModalCard');
            modal.classList.remove('hidden');
            
            setTimeout(() => {
                modal.classList.remove('opacity-0');
                card.classList.remove('scale-95', 'opacity-0');
                card.classList.add('scale-100', 'opacity-100');
            }, 10);
        }

        function closeDetailModal() {
            const modal = document.getElementById('detailModal');
            const card = document.getElementById('detailModalCard');
            
            modal.classList.add('opacity-0');
            card.classList.remove('scale-100', 'opacity-100');
            card.classList.add('scale-95', 'opacity-0');
            
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        }

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

            const searchInput = document.getElementById('search-barang');

            function enforceJurusanRule() {
                const checkedItems = Array.from(document.querySelectorAll('.barang-checkbox:checked'));
                
                if (checkedItems.length > 0) {
                    // Set jurusan
                    const firstItemJurusan = checkedItems[0].closest('.barang-item').getAttribute('data-jurusan');
                    jurusanSelect.value = firstItemJurusan;
                    
                    // Disable and gray out items from other jurusans
                    barangItems.forEach(item => {
                        const itemJurusan = item.getAttribute('data-jurusan');
                        const checkbox = item.querySelector('.barang-checkbox');
                        
                        if (itemJurusan !== firstItemJurusan) {
                            item.classList.add('opacity-40', 'grayscale');
                            item.style.pointerEvents = 'none';
                            checkbox.disabled = true;
                        } else {
                            item.classList.remove('opacity-40', 'grayscale');
                            item.style.pointerEvents = 'auto';
                            checkbox.disabled = false;
                        }
                    });
                } else {
                    // Reset everything if no items are checked
                    jurusanSelect.value = '';
                    barangItems.forEach(item => {
                        item.classList.remove('opacity-40', 'grayscale');
                        item.style.pointerEvents = 'auto';
                        item.querySelector('.barang-checkbox').disabled = false;
                    });
                }
            }

            // Toggle card checkbox when clicking on the card
            barangItems.forEach(item => {
                item.addEventListener('click', function() {
                    if (this.style.pointerEvents === 'none') return; // skip if disabled
                    
                    const checkbox = this.querySelector('.barang-checkbox');
                    checkbox.checked = !checkbox.checked;
                    updateCardVisual(this);
                    applyCheckboxValidation();
                    enforceJurusanRule();
                });
                
                // Prevent clicking input directly from triggering double clicks
                item.querySelector('input[type="number"]').addEventListener('click', function(e) {
                    e.stopPropagation();
                });
                
                // Initialize visual state (in case of old input)
                updateCardVisual(item);
            });

            const filterJurusan = document.getElementById('filter-jurusan');
            const filterKategori = document.getElementById('filter-kategori');

            function applyFilters() {
                const keyword = searchInput.value.toLowerCase();
                const jurVal = filterJurusan.value;
                const katVal = filterKategori.value;
                let visibleCount = 0;

                barangItems.forEach(item => {
                    const itemName = item.getAttribute('data-nama');
                    const itemJur = item.getAttribute('data-jurusan');
                    const itemKat = item.getAttribute('data-kategori');

                    const matchSearch = itemName.includes(keyword);
                    const matchJur = jurVal === '' || itemJur === jurVal;
                    const matchKat = katVal === '' || itemKat === katVal;

                    if (matchSearch && matchJur && matchKat) {
                        item.style.display = 'flex';
                        visibleCount++;
                    } else {
                        item.style.display = 'none';
                    }
                });

                if (visibleCount === 0) {
                    emptyBarang.classList.remove('hidden');
                    gridBarang.classList.add('hidden');
                } else {
                    emptyBarang.classList.add('hidden');
                    gridBarang.classList.remove('hidden');
                }
                applyCheckboxValidation();
            }

            searchInput.addEventListener('input', applyFilters);
            filterJurusan.addEventListener('change', applyFilters);
            filterKategori.addEventListener('change', applyFilters);

            function getVisibleCheckboxes() {
                return Array.from(document.querySelectorAll('.barang-item'))
                    .filter(item => item.style.display !== 'none' && item.style.pointerEvents !== 'none')
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

            // Run on load to apply old input logic if any
            enforceJurusanRule();
            applyFilters();
        });
    </script>
</x-dashboard-layout>