# ☕ MyCafe — Aplikasi Kasir Kafe

MyCafe adalah aplikasi kasir berbasis web yang dikembangkan sebagai proyek sekolah. Aplikasi ini membantu proses transaksi penjualan serta menyediakan fitur pengelolaan menu dan pemantauan penjualan untuk pemilik kafe.

Repository ini merupakan versi modifikasi dan pengembangan dari proyek awal MyCafe.

## ✨ Fitur Utama

### 🧾 Transaksi Kasir
- Memulai transaksi penjualan dan menambahkan menu ke transaksi.
- Menghitung total pembayaran, uang yang dibayarkan, dan kembalian.
- Melihat riwayat serta detail transaksi.
- Mencetak struk transaksi.

### 🍽️ Pengelolaan Menu
- Mengelola data menu dan kategori.
- Mencari menu dan memfilter menu berdasarkan kategori.
- Mengarsipkan menu yang tidak aktif.

### 📊 Dashboard dan Laporan Pemilik
- Melihat ringkasan penjualan melalui dashboard.
- Memantau riwayat dan detail transaksi.
- Menampilkan ringkasan penjualan dalam bentuk grafik.
- Melihat informasi stok minimum untuk membantu pemantauan persediaan.

### 👤 Pengelolaan Akun
- Login berdasarkan akun pengguna.
- Mengelola akun kasir melalui akun pemilik.
- Mengarsipkan akun kasir yang tidak aktif.

## 🧰 Teknologi yang Digunakan

- **Backend:** PHP Native
- **Database:** MySQL dengan MySQLi
- **Frontend:** HTML, CSS, JavaScript
- **CSS Framework:** Bootstrap 4.6
- **JavaScript Library:** jQuery
- **Visualisasi Data:** Chart.js

## 🖥️ Cara Menjalankan Aplikasi

### Prasyarat

- Web server lokal, seperti XAMPP atau Laragon
- PHP
- MySQL atau MariaDB
- Browser web

### Langkah Instalasi

**1. Clone repository**

```bash
git clone https://github.com/Aaalyaa/mycafe-modif.git
cd mycafe-modif
```

**2. Siapkan direktori proyek**

Jika menggunakan Laragon, letakkan folder proyek di direktori `www`, misalnya `C:\laragon\www\mycafe-modif`.

**3. Siapkan database**

Buat database MySQL dengan nama `db_cafe`, kemudian sesuaikan konfigurasi koneksi pada file `config.php` dengan pengaturan MySQL lokal.

**4. Siapkan struktur database**

Pastikan tabel dan data yang dibutuhkan aplikasi telah tersedia. Repository ini belum menyertakan berkas ekspor SQL siap impor, sehingga struktur database perlu disiapkan secara terpisah.

**5. Jalankan aplikasi**

Aktifkan web server dan MySQL, kemudian akses melalui browser:

```text
http://localhost/mycafe-modif/
```

> **Catatan:** Petunjuk ini merupakan panduan awal. Aplikasi belum bisa dijalankan sepenuhnya hanya dengan mengimpor database dari repository karena berkas SQL belum disertakan.

## 📁 Struktur Repository

- `controllers/` — logika pemrosesan aplikasi.
- `models/` — pengelolaan data.
- `views/` — halaman antarmuka aplikasi.
- `includes/` — berkas pendukung yang digunakan bersama.
- `css/` — stylesheet aplikasi.
- `fungsi/` — fungsi pendukung aplikasi.

## 🔧 Pengembangan Selanjutnya

Proyek ini masih dapat dikembangkan, terutama dalam aspek:

- Peningkatan validasi input dan keamanan autentikasi.
- Penggunaan prepared statements untuk query database.
- Penyempurnaan dokumentasi serta penyediaan berkas database.
- Pengujian fitur transaksi dan laporan secara menyeluruh.

## 👩‍💻 Pengembang

**Aaalyaa**  
GitHub: [@Aaalyaa](https://github.com/Aaalyaa)

Repository: [mycafe-modif](https://github.com/Aaalyaa/mycafe-modif)
