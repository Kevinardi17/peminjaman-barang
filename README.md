<div align="center">
  <img src="https://www.unila.ac.id/wp-content/uploads/2024/08/Logo-Unila-Statuta-PNG-300x296.png" width="300" alt="Laravel Logo">
  
  # LAPORAN UAS - MATA KULIAH WEB FRAMEWORK (SEMESTER 6)
  **Sistem Manajemen Peminjaman Barang Inventaris (SMK N 5 Bandar Lampung)**
</div>

---

## 👨‍🎓 Identitas Mahasiswa
- **Nama:** Kevin Ardi Setyawan *(Silakan sesuaikan/tambahkan)*
- **NPM:** [NPM Anda]
- **Mata Kuliah:** Web Framework
- **Semester:** 6

---

## 📖 Deskripsi Proyek
**Sistem Manajemen Peminjaman Barang Inventaris** adalah aplikasi berbasis web yang dirancang untuk memfasilitasi proses sirkulasi (peminjaman dan pengembalian) barang di SMK N 5 Bandar Lampung. Aplikasi ini mengubah proses manual menjadi digital sehingga lebih tertata, terekapitulasi dengan baik, dan mudah dipantau oleh admin sekolah.

### ✨ Fitur Utama:
1. **Multi-Role User:** Terdapat 3 hak akses, yaitu Superadmin, Admin Jurusan, dan Peminjam.
2. **Master Data:** Pengelolaan data inti meliputi Data Jurusan, Kategori, Barang, dan Manajemen Pengguna.
3. **Sirkulasi Peminjaman & Pengembalian:** 
   - Pengajuan peminjaman oleh *Peminjam*.
   - Proses persetujuan/penolakan oleh *Admin*.
   - Proses pengembalian barang beserta pencatatan status keterlambatan dan unggah bukti foto.
   - Perekaman nama petugas peminjaman.
4. **Riwayat Transaksi:** Semua riwayat dicatat otomatis dan aman.
5. **Cetak Laporan:** Pembuatan dan pencetakan surat bukti fisik peminjaman & pengembalian yang siap ditandatangani.
6. **Smart Polling (Real-time):** Pembaruan otomatis pada tabel data (tidak perlu *refresh* manual).

---

## 🛠️ Framework & Teknologi yang Digunakan
Proyek ini dibangun secara *Full-Stack* menggunakan ekosistem pengembangan modern:
- **Backend Framework:** [Laravel 13](https://laravel.com/) (PHP 8.3)
- **Frontend Framework:** [Tailwind CSS 3.1](https://tailwindcss.com/) & [Alpine.js](https://alpinejs.dev/)
- **Templating Engine:** Laravel Blade
- **Build Tool:** Vite
- **Database:** MySQL / SQLite

---

## 🌐 Cara Akses Aplikasi Secara Online

Aplikasi ini telah di-hosting dan dapat diakses langsung melalui browser tanpa perlu melakukan instalasi lokal. 

1. **Buka Browser**, disarankan menggunakan Google Chrome, Mozilla Firefox, atau Safari.
2. **Kunjungi Tautan**: Akses alamat website berikut:
   👉 **[https://vinlab.my.id/peminjamanbarang](https://vinlab.my.id/peminjamanbarang)**
3. **Login Pengguna**: Gunakan kredensial (Email/Password) yang telah didaftarkan oleh Administrator untuk masuk ke dalam dasbor sesuai peran (Role) masing-masing.

---

## 💻 Cara Menjalankan Aplikasi (Instalasi Lokal)

Untuk menjalankan proyek ini di komputer lokal untuk keperluan penilaian, silakan ikuti langkah-langkah berikut:

### Prasyarat:
Pastikan komputer Anda telah terinstal **PHP (>= 8.3)**, **Composer**, **Node.js & NPM**, serta **Database Server** (seperti XAMPP / MySQL).

### Langkah-langkah:
1. **Kloning Proyek**  
   Ekstrak folder proyek atau lakukan kloning dari repositori ini, lalu masuk ke direktori proyek melalui terminal:
   ```bash
   cd peminjaman-barang
   ```

2. **Instalasi Dependensi**  
   Jalankan perintah berikut untuk menginstal pustaka PHP dan JavaScript:
   ```bash
   composer install
   npm install
   ```

3. **Konfigurasi Lingkungan (.env)**  
   Salin file `.env.example` dan ubah namanya menjadi `.env`:
   ```bash
   cp .env.example .env
   ```
   Buka file `.env` dan sesuaikan konfigurasi database Anda:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=peminjaman_barang
   DB_USERNAME=root
   DB_PASSWORD=
   ```

4. **Generate App Key & Migrasi Database**  
   Buat *key* keamanan aplikasi dan jalankan migrasi database:
   ```bash
   php artisan key:generate
   php artisan migrate
   ```

5. **Kompilasi Aset Frontend**  
   Bangun file CSS dan JS menggunakan Vite:
   ```bash
   npm run build
   ```
   *(Atau gunakan `npm run dev` untuk mode pengembangan).*

6. **Jalankan Server**  
   Aktifkan *local development server* Laravel:
   ```bash
   php artisan serve
   ```
   Buka browser dan akses aplikasi melalui tautan: **http://localhost:8000**

---

<div align="center">
  <i>Dikembangkan menggunakan Laravel Framework untuk memenuhi tugas akhir mata kuliah Web Framework.</i>
</div>

