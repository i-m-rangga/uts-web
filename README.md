# 📝 Sistem Manajemen Blog (CMS)

Aplikasi web berbasis PHP untuk mengelola data **penulis**, **artikel**, dan **kategori artikel** secara lengkap. Seluruh operasi CRUD berjalan secara *asynchronous* menggunakan **Fetch API** tanpa reload halaman.

> **Mata Kuliah:** Pemrograman Web  
> **Dosen:** A'la Syauqi, M.Kom.  
> **Semester:** Genap 2025/2026

---

## 🗂️ Daftar Isi

- [Fitur Aplikasi](#-fitur-aplikasi)
- [Teknologi yang Digunakan](#-teknologi-yang-digunakan)
- [Struktur Folder](#-struktur-folder)
- [Struktur Database](#-struktur-database)
- [Persyaratan Sistem](#-persyaratan-sistem)
- [Langkah Instalasi](#-langkah-instalasi)
- [Cara Menjalankan](#-cara-menjalankan)
- [Panduan Penggunaan](#-panduan-penggunaan)
- [Keamanan](#-keamanan)
- [Rubrik Penilaian](#-rubrik-penilaian)

---

## ✨ Fitur Aplikasi

### Kelola Penulis
- Menampilkan daftar penulis beserta foto profil, nama, username, dan password (terenkripsi)
- Tambah penulis baru dengan upload foto profil
- Edit data penulis (password & foto bersifat opsional saat edit)
- Hapus penulis — dilindungi: tidak bisa dihapus jika masih memiliki artikel
- Foto default (`default.png`) otomatis tampil jika penulis tidak mengupload foto

### Kelola Artikel
- Menampilkan daftar artikel beserta gambar, judul, kategori, nama penulis, dan tanggal
- Tambah artikel baru dengan upload gambar wajib
- Dropdown penulis dan kategori diisi dinamis dari database
- Tanggal otomatis diisi oleh server (timezone `Asia/Jakarta`) dengan format `Senin, 13 April 2026 | 15:17`
- Edit artikel (gambar bersifat opsional saat edit)
- Hapus artikel — file gambar ikut terhapus dari server

### Kelola Kategori Artikel
- Menampilkan daftar kategori beserta keterangan
- Tambah, edit, dan hapus kategori
- Hapus kategori — dilindungi: tidak bisa dihapus jika masih digunakan artikel

---

## 🛠️ Teknologi yang Digunakan

| Teknologi | Versi | Keterangan |
|-----------|-------|------------|
| PHP | 7.4+ | Backend & logika server |
| MySQL | 5.7+ | Database |
| JavaScript (Vanilla) | ES6+ | Fetch API untuk operasi async |
| HTML5 & CSS3 | — | Tampilan antarmuka |
| Apache | 2.4+ | Web server (via XAMPP/Laragon) |

---

## 📁 Struktur Folder

```
blog/
├── index.php                  # Halaman utama aplikasi (single-page)
├── koneksi.php                # Konfigurasi koneksi database
│
├── ambil_penulis.php          # READ   - Ambil semua penulis
├── ambil_satu_penulis.php     # READ   - Ambil satu penulis by ID
├── simpan_penulis.php         # CREATE - Tambah penulis baru
├── update_penulis.php         # UPDATE - Perbarui data penulis
├── hapus_penulis.php          # DELETE - Hapus penulis
│
├── ambil_kategori.php         # READ   - Ambil semua kategori
├── ambil_satu_kategori.php    # READ   - Ambil satu kategori by ID
├── simpan_kategori.php        # CREATE - Tambah kategori baru
├── update_kategori.php        # UPDATE - Perbarui data kategori
├── hapus_kategori.php         # DELETE - Hapus kategori
│
├── ambil_artikel.php          # READ   - Ambil semua artikel (JOIN)
├── ambil_satu_artikel.php     # READ   - Ambil satu artikel by ID
├── simpan_artikel.php         # CREATE - Tambah artikel baru
├── update_artikel.php         # UPDATE - Perbarui data artikel
├── hapus_artikel.php          # DELETE - Hapus artikel + file gambar
│
├── db_blog.sql                # Script SQL database + data contoh
│
├── uploads_penulis/           # Folder upload foto penulis
│   ├── .htaccess              # Blokir eksekusi PHP di folder ini
│   └── default.png            # Foto profil default (siluet)
│
└── uploads_artikel/           # Folder upload gambar artikel
    └── .htaccess              # Blokir eksekusi PHP di folder ini
```

---

## 🗄️ Struktur Database

### Nama Database: `db_blog`

#### Tabel `penulis`

| Kolom | Tipe | Keterangan |
|-------|------|------------|
| `id` | INT, AUTO_INCREMENT | Primary Key |
| `nama_depan` | VARCHAR(100) | Nama depan penulis |
| `nama_belakang` | VARCHAR(100) | Nama belakang penulis |
| `user_name` | VARCHAR(50), UNIQUE | Username login |
| `password` | VARCHAR(255) | Password (bcrypt hash) |
| `foto` | VARCHAR(255) | Nama file foto profil |

#### Tabel `kategori_artikel`

| Kolom | Tipe | Keterangan |
|-------|------|------------|
| `id` | INT, AUTO_INCREMENT | Primary Key |
| `nama_kategori` | VARCHAR(100), UNIQUE | Nama kategori |
| `keterangan` | TEXT | Deskripsi kategori |

#### Tabel `artikel`

| Kolom | Tipe | Keterangan |
|-------|------|------------|
| `id` | INT, AUTO_INCREMENT | Primary Key |
| `id_penulis` | INT | Foreign Key → `penulis(id)` |
| `id_kategori` | INT | Foreign Key → `kategori_artikel(id)` |
| `judul` | VARCHAR(255) | Judul artikel |
| `isi` | TEXT | Isi konten artikel |
| `gambar` | VARCHAR(255) | Nama file gambar |
| `hari_tanggal` | VARCHAR(50) | Tanggal dibuat (format Indonesia) |

#### Relasi Antartabel

```
penulis (id) ──────────────────┐
                               │ ON DELETE RESTRICT
                               ▼ ON UPDATE CASCADE
                          artikel (id_penulis)
                          artikel (id_kategori)
                               ▲ ON DELETE RESTRICT
                               │ ON UPDATE CASCADE
kategori_artikel (id) ─────────┘
```

---

## 💻 Persyaratan Sistem

Pastikan perangkat lunak berikut sudah terinstal:

- **XAMPP** (v7.4+) atau **Laragon** — sudah mencakup PHP, MySQL, dan Apache
- **Browser** modern (Chrome, Firefox, Edge)
- **phpMyAdmin** — untuk manajemen database (sudah termasuk di XAMPP/Laragon)

---

## 🚀 Langkah Instalasi

### Langkah 1 — Clone atau Ekstrak Proyek

**Jika dari GitHub:**
```bash
git clone https://github.com/username/nama-repo.git
```

**Jika dari file ZIP:**
Ekstrak file `blog_cms.zip`, sehingga terdapat folder `blog/` di dalamnya.

---

### Langkah 2 — Letakkan Folder di htdocs

Salin folder `blog/` ke direktori root web server:

- **XAMPP (Windows):** `C:\xampp\htdocs\`
- **XAMPP (Mac/Linux):** `/opt/lampp/htdocs/`
- **Laragon:** `C:\laragon\www\`

Hasil akhir: `C:\xampp\htdocs\blog\` (atau sesuai OS)

---

### Langkah 3 — Jalankan XAMPP / Laragon

Aktifkan dua service berikut:
- ✅ **Apache**
- ✅ **MySQL**

---

### Langkah 4 — Import Database

1. Buka browser, akses **phpMyAdmin**: `http://localhost/phpmyadmin`
2. Klik tab **SQL** di bagian atas
3. Salin seluruh isi file `db_blog.sql`, tempel ke kolom SQL, lalu klik **Go**

   *Atau gunakan cara import file:*
   - Klik **Import** → **Choose File** → pilih `db_blog.sql` → klik **Go**

4. Pastikan database `db_blog` dan ketiga tabelnya berhasil dibuat

---

### Langkah 5 — Konfigurasi Koneksi Database

Buka file `blog/koneksi.php` dan sesuaikan pengaturan berikut:

```php
$host     = 'localhost';   // host database (biasanya localhost)
$user     = 'root';        // username MySQL (default XAMPP: root)
$password = '';            // password MySQL (default XAMPP: kosong)
$database = 'db_blog';     // nama database
```

> **Catatan:** Jika Anda menggunakan Laragon atau konfigurasi MySQL kustom, sesuaikan `$user` dan `$password` dengan kredensial Anda.

---

### Langkah 6 — Verifikasi Folder Upload

Pastikan dua folder berikut ada dan dapat ditulis (*writable*) oleh server:

```
blog/uploads_penulis/
blog/uploads_artikel/
```

Jika di Linux/Mac, jalankan perintah berikut untuk memberikan izin:

```bash
chmod 755 blog/uploads_penulis
chmod 755 blog/uploads_artikel
```

---

## ▶️ Cara Menjalankan

Setelah instalasi selesai, buka browser dan akses:

```
http://localhost/blog/
```

Aplikasi akan langsung menampilkan halaman **Kelola Penulis** sebagai tampilan awal.

---

## 📖 Panduan Penggunaan

### Navigasi
Gunakan menu di sidebar kiri untuk berpindah antar fitur:
- **Kelola Penulis** — manajemen data penulis
- **Kelola Artikel** — manajemen data artikel
- **Kelola Kategori** — manajemen kategori artikel

---

### Menambah Data

1. Klik tombol **+ Tambah [Penulis / Artikel / Kategori]** di pojok kanan atas
2. Isi semua field yang tersedia pada form modal yang muncul
3. Klik **Simpan Data** — data tersimpan tanpa reload halaman

---

### Mengedit Data

1. Klik tombol **Edit** pada baris data yang ingin diubah
2. Form modal akan terbuka dan terisi otomatis dengan data terkini dari database
3. Ubah field yang diperlukan, lalu klik **Simpan Perubahan**

> Untuk penulis dan artikel, field **password** dan **foto/gambar** bersifat opsional saat edit — kosongkan jika tidak ingin mengubahnya.

---

### Menghapus Data

1. Klik tombol **Hapus** pada baris data yang ingin dihapus
2. Modal konfirmasi akan muncul
3. Klik **Ya, Hapus** untuk mengkonfirmasi, atau **Batal** untuk membatalkan

> ⚠️ **Perhatian:**
> - Penulis yang masih memiliki artikel **tidak dapat dihapus**
> - Kategori yang masih digunakan artikel **tidak dapat dihapus**
> - Gambar artikel akan **otomatis terhapus** dari server saat artikel dihapus

---

### Format Upload File

| Jenis | Tipe yang Diizinkan | Ukuran Maksimal |
|-------|---------------------|-----------------|
| Foto Penulis | JPEG, PNG, GIF, WEBP | 2 MB |
| Gambar Artikel | JPEG, PNG, GIF, WEBP | 2 MB |

---

## 🔒 Keamanan

Aplikasi ini menerapkan beberapa lapisan keamanan:

| Fitur | Implementasi |
|-------|-------------|
| **Enkripsi Password** | `password_hash()` dengan algoritma `PASSWORD_BCRYPT` |
| **Prepared Statements** | Semua query database menggunakan `mysqli` prepared statements untuk mencegah SQL Injection |
| **Validasi Tipe File** | Menggunakan fungsi `finfo` (magic bytes), bukan `$_FILES['type']` yang mudah dimanipulasi |
| **Sanitasi Output** | Semua output HTML menggunakan `htmlspecialchars()` untuk mencegah XSS |
| **Proteksi Folder Upload** | File `.htaccess` di kedua folder upload mencegah eksekusi file PHP berbahaya |
| **Validasi Ukuran File** | Maksimal 2 MB per file upload |

---

## 📊 Rubrik Penilaian

| No | Komponen | Bobot |
|----|----------|-------|
| 1 | Struktur database dan perintah SQL | 10 |
| 2 | Koneksi PHP dan database | 5 |
| 3 | Tampilan / GUI | 10 |
| 4 | CRUD Kategori Artikel | 10 |
| 5 | CRUD Penulis | 25 |
| 6 | CRUD Artikel | 30 |
| 7 | Validasi dan keamanan | 10 |
| | **Total** | **100** |

---

## 📦 Ketentuan Pengumpulan

- Seluruh folder `blog/` beserta isinya di-upload ke repositori **GitHub**
- Sertakan file database hasil ekspor berformat `.sql`
- Buat **video demo** aplikasi dan upload ke **YouTube**
- Kumpulkan tautan GitHub dan YouTube melalui **Google Classroom**
- **Batas pengumpulan:** Rabu, 29 Mei 2026 pukul 23.59 WIB

---

## 👨‍💻 Informasi Proyek

| | |
|--|--|
| **Mata Kuliah** | Pemrograman Web |
| **Jenis Ujian** | UTS Take Home Test |
| **Dosen** | A'la Syauqi, M.Kom. |
| **Semester** | Genap 2025/2026 |
| **Deadline** | 29 Mei 2026, 23.59 WIB |