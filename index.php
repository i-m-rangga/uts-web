<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Manajemen Blog (CMS)</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f0f2f5;
            color: #333;
        }

        /* HEADER */
        header {
            background: #fff;
            padding: 14px 24px;
            display: flex;
            align-items: center;
            gap: 12px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.08);
            position: sticky;
            top: 0;
            z-index: 100;
        }
        header .logo-icon {
            background: #3b82f6;
            color: #fff;
            width: 36px; height: 36px;
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            font-size: 18px;
        }
        header .header-text h1 {
            font-size: 16px;
            font-weight: 700;
            color: #1e293b;
        }
        header .header-text p {
            font-size: 12px;
            color: #64748b;
        }

        /* LAYOUT */
        .layout {
            display: flex;
            min-height: calc(100vh - 64px);
        }

        /* SIDEBAR */
        aside {
            width: 220px;
            background: #fff;
            padding: 20px 0;
            border-right: 1px solid #e2e8f0;
            flex-shrink: 0;
        }
        aside .menu-label {
            font-size: 11px;
            font-weight: 600;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            padding: 0 20px 10px;
        }
        aside a {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 20px;
            color: #475569;
            text-decoration: none;
            font-size: 14px;
            border-left: 3px solid transparent;
            transition: all 0.15s;
        }
        aside a:hover { background: #f1f5f9; color: #1e293b; }
        aside a.active {
            background: #eff6ff;
            color: #2563eb;
            border-left-color: #2563eb;
            font-weight: 600;
        }
        aside a .icon { font-size: 16px; }

        /* MAIN CONTENT */
        main {
            flex: 1;
            padding: 28px;
            overflow: auto;
        }

        /* CONTENT HEADER */
        .content-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .content-header h2 {
            font-size: 18px;
            font-weight: 700;
            color: #1e293b;
        }

        /* BUTTONS */
        .btn {
            padding: 8px 16px;
            border: none;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: opacity 0.15s;
        }
        .btn:hover { opacity: 0.85; }
        .btn-primary { background: #2563eb; color: #fff; }
        .btn-success { background: #16a34a; color: #fff; }
        .btn-warning { background: #d97706; color: #fff; }
        .btn-danger  { background: #dc2626; color: #fff; }
        .btn-secondary { background: #94a3b8; color: #fff; }
        .btn-sm { padding: 5px 12px; font-size: 12px; }

        /* TABLE */
        .card {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 1px 4px rgba(0,0,0,0.07);
            overflow: hidden;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        thead tr {
            background: #f8fafc;
        }
        th {
            padding: 12px 16px;
            text-align: left;
            font-size: 12px;
            font-weight: 700;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            border-bottom: 1px solid #e2e8f0;
        }
        td {
            padding: 12px 16px;
            font-size: 13px;
            color: #374151;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: middle;
        }
        tr:last-child td { border-bottom: none; }
        tr:hover td { background: #fafafa; }

        /* FOTO */
        .foto-thumb {
            width: 40px; height: 40px;
            border-radius: 50%;
            object-fit: cover;
            background: #e2e8f0;
        }
        .gambar-thumb {
            width: 50px; height: 38px;
            border-radius: 5px;
            object-fit: cover;
            background: #e2e8f0;
        }

        /* BADGE KATEGORI */
        .badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            background: #dbeafe;
            color: #1d4ed8;
        }
        .badge-green { background: #dcfce7; color: #166534; }
        .badge-purple { background: #ede9fe; color: #6d28d9; }
        .badge-orange { background: #ffedd5; color: #9a3412; }

        /* PASSWORD MASK */
        .pwd-mask { color: #94a3b8; font-size: 18px; letter-spacing: 2px; }

        /* MODAL OVERLAY */
        .overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(15,23,42,0.45);
            z-index: 200;
            align-items: center;
            justify-content: center;
        }
        .overlay.active { display: flex; }

        .modal {
            background: #fff;
            border-radius: 12px;
            padding: 28px;
            width: 480px;
            max-width: 95vw;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 20px 60px rgba(0,0,0,0.2);
            animation: slideUp 0.2s ease;
        }
        @keyframes slideUp {
            from { transform: translateY(20px); opacity: 0; }
            to   { transform: translateY(0);    opacity: 1; }
        }
        .modal h3 {
            font-size: 17px;
            font-weight: 700;
            margin-bottom: 20px;
            color: #1e293b;
        }

        /* CONFIRM MODAL */
        .modal-confirm {
            text-align: center;
            padding: 32px 28px;
        }
        .modal-confirm .trash-icon {
            background: #fee2e2;
            color: #dc2626;
            width: 56px; height: 56px;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 24px;
            margin: 0 auto 16px;
        }
        .modal-confirm h3 { margin-bottom: 6px; }
        .modal-confirm p  { font-size: 13px; color: #64748b; margin-bottom: 24px; }
        .modal-confirm .btn-row { display: flex; gap: 10px; justify-content: center; }

        /* FORM */
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
            margin-bottom: 14px;
        }
        .form-row.single { grid-template-columns: 1fr; }
        .form-group { display: flex; flex-direction: column; gap: 5px; }
        .form-group label {
            font-size: 13px;
            font-weight: 600;
            color: #475569;
        }
        .form-group input,
        .form-group textarea,
        .form-group select {
            border: 1px solid #e2e8f0;
            border-radius: 7px;
            padding: 8px 12px;
            font-size: 13px;
            color: #1e293b;
            outline: none;
            transition: border-color 0.15s;
            width: 100%;
        }
        .form-group input:focus,
        .form-group textarea:focus,
        .form-group select:focus { border-color: #3b82f6; }
        .form-group textarea { resize: vertical; min-height: 90px; }

        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 20px;
        }

        /* ALERT */
        .alert {
            padding: 10px 14px;
            border-radius: 7px;
            font-size: 13px;
            margin-bottom: 14px;
            display: none;
        }
        .alert.show { display: block; }
        .alert-success { background: #dcfce7; color: #166534; border: 1px solid #bbf7d0; }
        .alert-error   { background: #fee2e2; color: #991b1b; border: 1px solid #fecaca; }

        /* TANGGAL */
        .tanggal-text { font-size: 12px; color: #64748b; }

        /* SECTION hidden */
        .section { display: none; }
        .section.active { display: block; }

        /* EMPTY STATE */
        .empty-state {
            text-align: center;
            padding: 48px;
            color: #94a3b8;
        }
        .empty-state p { font-size: 14px; margin-top: 8px; }
    </style>
</head>
<body>

<!-- HEADER -->
<header>
    <div class="logo-icon">&#9998;</div>
    <div class="header-text">
        <h1>Sistem Manajemen Blog (CMS)</h1>
        <p>Blog Kami</p>
    </div>
</header>

<div class="layout">

    <!-- SIDEBAR -->
    <aside>
        <div class="menu-label">Menu Utama</div>
        <a href="#" class="active" id="menu-penulis" onclick="showSection('penulis'); return false;">
            <span class="icon">&#128100;</span> Kelola Penulis
        </a>
        <a href="#" id="menu-artikel" onclick="showSection('artikel'); return false;">
            <span class="icon">&#128196;</span> Kelola Artikel
        </a>
        <a href="#" id="menu-kategori" onclick="showSection('kategori'); return false;">
            <span class="icon">&#128193;</span> Kelola Kategori
        </a>
    </aside>

    <!-- MAIN -->
    <main>

        <!-- ======= SECTION PENULIS ======= -->
        <div id="section-penulis" class="section active">
            <div class="content-header">
                <h2>Data Penulis</h2>
                <button class="btn btn-primary" onclick="openModalTambahPenulis()">+ Tambah Penulis</button>
            </div>
            <div class="card">
                <table id="tabel-penulis">
                    <thead>
                        <tr>
                            <th>Foto</th>
                            <th>Nama</th>
                            <th>Username</th>
                            <th>Password</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="tbody-penulis">
                        <tr><td colspan="5" class="empty-state">Memuat data...</td></tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- ======= SECTION ARTIKEL ======= -->
        <div id="section-artikel" class="section">
            <div class="content-header">
                <h2>Data Artikel</h2>
                <button class="btn btn-primary" onclick="openModalTambahArtikel()">+ Tambah Artikel</button>
            </div>
            <div class="card">
                <table id="tabel-artikel">
                    <thead>
                        <tr>
                            <th>Gambar</th>
                            <th>Judul</th>
                            <th>Kategori</th>
                            <th>Penulis</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="tbody-artikel">
                        <tr><td colspan="6" class="empty-state">Memuat data...</td></tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- ======= SECTION KATEGORI ======= -->
        <div id="section-kategori" class="section">
            <div class="content-header">
                <h2>Data Kategori Artikel</h2>
                <button class="btn btn-primary" onclick="openModalTambahKategori()">+ Tambah Kategori</button>
            </div>
            <div class="card">
                <table id="tabel-kategori">
                    <thead>
                        <tr>
                            <th>Nama Kategori</th>
                            <th>Keterangan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="tbody-kategori">
                        <tr><td colspan="3" class="empty-state">Memuat data...</td></tr>
                    </tbody>
                </table>
            </div>
        </div>

    </main>
</div>

<!-- ==================== MODAL TAMBAH PENULIS ==================== -->
<div class="overlay" id="overlay-tambah-penulis">
    <div class="modal">
        <h3>Tambah Penulis</h3>
        <div class="alert" id="alert-tambah-penulis"></div>
        <div class="form-row">
            <div class="form-group">
                <label>Nama Depan</label>
                <input type="text" id="tp-nama-depan" placeholder="Ahmad">
            </div>
            <div class="form-group">
                <label>Nama Belakang</label>
                <input type="text" id="tp-nama-belakang" placeholder="Fauzi">
            </div>
        </div>
        <div class="form-row single">
            <div class="form-group">
                <label>Username</label>
                <input type="text" id="tp-username" placeholder="ahmad_f">
            </div>
        </div>
        <div class="form-row single">
            <div class="form-group">
                <label>Password</label>
                <input type="password" id="tp-password" placeholder="&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;">
            </div>
        </div>
        <div class="form-row single">
            <div class="form-group">
                <label>Foto Profil</label>
                <input type="file" id="tp-foto" accept="image/*">
            </div>
        </div>
        <div class="form-actions">
            <button class="btn btn-secondary" onclick="closeOverlay('overlay-tambah-penulis')">Batal</button>
            <button class="btn btn-primary" onclick="simpanPenulis()">Simpan Data</button>
        </div>
    </div>
</div>

<!-- ==================== MODAL EDIT PENULIS ==================== -->
<div class="overlay" id="overlay-edit-penulis">
    <div class="modal">
        <h3>Edit Penulis</h3>
        <div class="alert" id="alert-edit-penulis"></div>
        <input type="hidden" id="ep-id">
        <div class="form-row">
            <div class="form-group">
                <label>Nama Depan</label>
                <input type="text" id="ep-nama-depan">
            </div>
            <div class="form-group">
                <label>Nama Belakang</label>
                <input type="text" id="ep-nama-belakang">
            </div>
        </div>
        <div class="form-row single">
            <div class="form-group">
                <label>Username</label>
                <input type="text" id="ep-username">
            </div>
        </div>
        <div class="form-row single">
            <div class="form-group">
                <label>Password Baru (kosongkan jika tidak diganti)</label>
                <input type="password" id="ep-password" placeholder="&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;">
            </div>
        </div>
        <div class="form-row single">
            <div class="form-group">
                <label>Foto Profil (kosongkan jika tidak diganti)</label>
                <input type="file" id="ep-foto" accept="image/*">
            </div>
        </div>
        <div class="form-actions">
            <button class="btn btn-secondary" onclick="closeOverlay('overlay-edit-penulis')">Batal</button>
            <button class="btn btn-primary" onclick="updatePenulis()">Simpan Perubahan</button>
        </div>
    </div>
</div>

<!-- ==================== MODAL HAPUS PENULIS ==================== -->
<div class="overlay" id="overlay-hapus-penulis">
    <div class="modal modal-confirm">
        <div class="trash-icon">&#128465;</div>
        <h3>Hapus data ini?</h3>
        <p>Data yang dihapus tidak dapat dikembalikan.</p>
        <input type="hidden" id="hapus-penulis-id">
        <div class="btn-row">
            <button class="btn btn-secondary" onclick="closeOverlay('overlay-hapus-penulis')">Batal</button>
            <button class="btn btn-danger" onclick="hapusPenulis()">Ya, Hapus</button>
        </div>
    </div>
</div>

<!-- ==================== MODAL TAMBAH ARTIKEL ==================== -->
<div class="overlay" id="overlay-tambah-artikel">
    <div class="modal">
        <h3>Tambah Artikel</h3>
        <div class="alert" id="alert-tambah-artikel"></div>
        <div class="form-row single">
            <div class="form-group">
                <label>Judul</label>
                <input type="text" id="ta-judul" placeholder="Judul artikel...">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label>Penulis</label>
                <select id="ta-penulis"></select>
            </div>
            <div class="form-group">
                <label>Kategori</label>
                <select id="ta-kategori"></select>
            </div>
        </div>
        <div class="form-row single">
            <div class="form-group">
                <label>Isi Artikel</label>
                <textarea id="ta-isi" placeholder="Tulis isi artikel di sini..."></textarea>
            </div>
        </div>
        <div class="form-row single">
            <div class="form-group">
                <label>Gambar</label>
                <input type="file" id="ta-gambar" accept="image/*">
            </div>
        </div>
        <div class="form-actions">
            <button class="btn btn-secondary" onclick="closeOverlay('overlay-tambah-artikel')">Batal</button>
            <button class="btn btn-primary" onclick="simpanArtikel()">Simpan Data</button>
        </div>
    </div>
</div>

<!-- ==================== MODAL EDIT ARTIKEL ==================== -->
<div class="overlay" id="overlay-edit-artikel">
    <div class="modal">
        <h3>Edit Artikel</h3>
        <div class="alert" id="alert-edit-artikel"></div>
        <input type="hidden" id="ea-id">
        <div class="form-row single">
            <div class="form-group">
                <label>Judul</label>
                <input type="text" id="ea-judul">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label>Penulis</label>
                <select id="ea-penulis"></select>
            </div>
            <div class="form-group">
                <label>Kategori</label>
                <select id="ea-kategori"></select>
            </div>
        </div>
        <div class="form-row single">
            <div class="form-group">
                <label>Isi Artikel</label>
                <textarea id="ea-isi"></textarea>
            </div>
        </div>
        <div class="form-row single">
            <div class="form-group">
                <label>Gambar (kosongkan jika tidak diganti)</label>
                <input type="file" id="ea-gambar" accept="image/*">
            </div>
        </div>
        <div class="form-actions">
            <button class="btn btn-secondary" onclick="closeOverlay('overlay-edit-artikel')">Batal</button>
            <button class="btn btn-primary" onclick="updateArtikel()">Simpan Perubahan</button>
        </div>
    </div>
</div>

<!-- ==================== MODAL HAPUS ARTIKEL ==================== -->
<div class="overlay" id="overlay-hapus-artikel">
    <div class="modal modal-confirm">
        <div class="trash-icon">&#128465;</div>
        <h3>Hapus data ini?</h3>
        <p>Data yang dihapus tidak dapat dikembalikan.</p>
        <input type="hidden" id="hapus-artikel-id">
        <div class="btn-row">
            <button class="btn btn-secondary" onclick="closeOverlay('overlay-hapus-artikel')">Batal</button>
            <button class="btn btn-danger" onclick="hapusArtikel()">Ya, Hapus</button>
        </div>
    </div>
</div>

<!-- ==================== MODAL TAMBAH KATEGORI ==================== -->
<div class="overlay" id="overlay-tambah-kategori">
    <div class="modal">
        <h3>Tambah Kategori</h3>
        <div class="alert" id="alert-tambah-kategori"></div>
        <div class="form-row single">
            <div class="form-group">
                <label>Nama Kategori</label>
                <input type="text" id="tk-nama" placeholder="Nama kategori...">
            </div>
        </div>
        <div class="form-row single">
            <div class="form-group">
                <label>Keterangan</label>
                <textarea id="tk-keterangan" placeholder="Deskripsi kategori..."></textarea>
            </div>
        </div>
        <div class="form-actions">
            <button class="btn btn-secondary" onclick="closeOverlay('overlay-tambah-kategori')">Batal</button>
            <button class="btn btn-primary" onclick="simpanKategori()">Simpan Data</button>
        </div>
    </div>
</div>

<!-- ==================== MODAL EDIT KATEGORI ==================== -->
<div class="overlay" id="overlay-edit-kategori">
    <div class="modal">
        <h3>Edit Kategori</h3>
        <div class="alert" id="alert-edit-kategori"></div>
        <input type="hidden" id="ek-id">
        <div class="form-row single">
            <div class="form-group">
                <label>Nama Kategori</label>
                <input type="text" id="ek-nama">
            </div>
        </div>
        <div class="form-row single">
            <div class="form-group">
                <label>Keterangan</label>
                <textarea id="ek-keterangan"></textarea>
            </div>
        </div>
        <div class="form-actions">
            <button class="btn btn-secondary" onclick="closeOverlay('overlay-edit-kategori')">Batal</button>
            <button class="btn btn-primary" onclick="updateKategori()">Simpan Perubahan</button>
        </div>
    </div>
</div>

<!-- ==================== MODAL HAPUS KATEGORI ==================== -->
<div class="overlay" id="overlay-hapus-kategori">
    <div class="modal modal-confirm">
        <div class="trash-icon">&#128465;</div>
        <h3>Hapus data ini?</h3>
        <p>Data yang dihapus tidak dapat dikembalikan.</p>
        <input type="hidden" id="hapus-kategori-id">
        <div class="btn-row">
            <button class="btn btn-secondary" onclick="closeOverlay('overlay-hapus-kategori')">Batal</button>
            <button class="btn btn-danger" onclick="hapusKategori()">Ya, Hapus</button>
        </div>
    </div>
</div>

<script>
// ============================================================
// UTILS
// ============================================================
function esc(str) {
    const d = document.createElement('div');
    d.appendChild(document.createTextNode(str ?? ''));
    return d.innerHTML;
}

function showAlert(id, msg, type) {
    const el = document.getElementById(id);
    el.textContent = msg;
    el.className = 'alert show alert-' + type;
    setTimeout(() => { el.classList.remove('show'); }, 3500);
}

function openOverlay(id)  { document.getElementById(id).classList.add('active'); }
function closeOverlay(id) { document.getElementById(id).classList.remove('active'); }

// Tutup overlay saat klik di luar modal
document.querySelectorAll('.overlay').forEach(ov => {
    ov.addEventListener('click', function(e) {
        if (e.target === this) this.classList.remove('active');
    });
});

// Warna badge otomatis
const badgeColors = ['', 'badge-green', 'badge-purple', 'badge-orange'];
const badgeCache = {};
let badgeIdx = 0;
function getBadgeClass(nama) {
    if (!badgeCache[nama]) {
        badgeCache[nama] = badgeColors[badgeIdx % badgeColors.length];
        badgeIdx++;
    }
    return badgeCache[nama];
}

// ============================================================
// NAVIGASI
// ============================================================
function showSection(name) {
    document.querySelectorAll('.section').forEach(s => s.classList.remove('active'));
    document.querySelectorAll('aside a').forEach(a => a.classList.remove('active'));
    document.getElementById('section-' + name).classList.add('active');
    document.getElementById('menu-' + name).classList.add('active');

    if (name === 'penulis')  loadPenulis();
    if (name === 'artikel')  loadArtikel();
    if (name === 'kategori') loadKategori();
}

// ============================================================
// ================== PENULIS =================================
// ============================================================
function loadPenulis() {
    fetch('ambil_penulis.php')
        .then(r => r.json())
        .then(res => {
            const tbody = document.getElementById('tbody-penulis');
            if (!res.data || res.data.length === 0) {
                tbody.innerHTML = '<tr><td colspan="5"><div class="empty-state"><p>Belum ada data penulis</p></div></td></tr>';
                return;
            }
            tbody.innerHTML = res.data.map(p => `
                <tr>
                    <td><img class="foto-thumb" src="uploads_penulis/${esc(p.foto)}"
                        onerror="this.src='uploads_penulis/default.png'" alt="foto"></td>
                    <td>${esc(p.nama_depan)} ${esc(p.nama_belakang)}</td>
                    <td>${esc(p.user_name)}</td>
                    <td><span class="pwd-mask">${esc(p.password).substring(0,14)}&#8230;</span></td>
                    <td>
                        <button class="btn btn-warning btn-sm" onclick="openEditPenulis(${p.id})">Edit</button>
                        <button class="btn btn-danger btn-sm" onclick="konfirmasiHapusPenulis(${p.id})">Hapus</button>
                    </td>
                </tr>`).join('');
        })
        .catch(() => {
            document.getElementById('tbody-penulis').innerHTML =
                '<tr><td colspan="5"><div class="empty-state"><p>Gagal memuat data</p></div></td></tr>';
        });
}

function openModalTambahPenulis() {
    document.getElementById('tp-nama-depan').value = '';
    document.getElementById('tp-nama-belakang').value = '';
    document.getElementById('tp-username').value = '';
    document.getElementById('tp-password').value = '';
    document.getElementById('tp-foto').value = '';
    openOverlay('overlay-tambah-penulis');
}

function simpanPenulis() {
    const fd = new FormData();
    fd.append('nama_depan',    document.getElementById('tp-nama-depan').value.trim());
    fd.append('nama_belakang', document.getElementById('tp-nama-belakang').value.trim());
    fd.append('user_name',     document.getElementById('tp-username').value.trim());
    fd.append('password',      document.getElementById('tp-password').value);
    const foto = document.getElementById('tp-foto').files[0];
    if (foto) fd.append('foto', foto);

    fetch('simpan_penulis.php', { method: 'POST', body: fd })
        .then(r => r.json())
        .then(res => {
            showAlert('alert-tambah-penulis', res.message, res.status === 'success' ? 'success' : 'error');
            if (res.status === 'success') {
                setTimeout(() => closeOverlay('overlay-tambah-penulis'), 1000);
                loadPenulis();
            }
        });
}

function openEditPenulis(id) {
    fetch('ambil_satu_penulis.php?id=' + id)
        .then(r => r.json())
        .then(res => {
            if (res.status !== 'success') return;
            const p = res.data;
            document.getElementById('ep-id').value         = p.id;
            document.getElementById('ep-nama-depan').value = p.nama_depan;
            document.getElementById('ep-nama-belakang').value = p.nama_belakang;
            document.getElementById('ep-username').value   = p.user_name;
            document.getElementById('ep-password').value   = '';
            document.getElementById('ep-foto').value       = '';
            openOverlay('overlay-edit-penulis');
        });
}

function updatePenulis() {
    const fd = new FormData();
    fd.append('id',            document.getElementById('ep-id').value);
    fd.append('nama_depan',    document.getElementById('ep-nama-depan').value.trim());
    fd.append('nama_belakang', document.getElementById('ep-nama-belakang').value.trim());
    fd.append('user_name',     document.getElementById('ep-username').value.trim());
    fd.append('password',      document.getElementById('ep-password').value);
    const foto = document.getElementById('ep-foto').files[0];
    if (foto) fd.append('foto', foto);

    fetch('update_penulis.php', { method: 'POST', body: fd })
        .then(r => r.json())
        .then(res => {
            showAlert('alert-edit-penulis', res.message, res.status === 'success' ? 'success' : 'error');
            if (res.status === 'success') {
                setTimeout(() => closeOverlay('overlay-edit-penulis'), 1000);
                loadPenulis();
            }
        });
}

function konfirmasiHapusPenulis(id) {
    document.getElementById('hapus-penulis-id').value = id;
    openOverlay('overlay-hapus-penulis');
}

function hapusPenulis() {
    const id = document.getElementById('hapus-penulis-id').value;
    const fd = new FormData();
    fd.append('id', id);
    fetch('hapus_penulis.php', { method: 'POST', body: fd })
        .then(r => r.json())
        .then(res => {
            closeOverlay('overlay-hapus-penulis');
            if (res.status === 'success') {
                loadPenulis();
            } else {
                alert(res.message);
            }
        });
}

// ============================================================
// ================== ARTIKEL =================================
// ============================================================
function loadArtikel() {
    fetch('ambil_artikel.php')
        .then(r => r.json())
        .then(res => {
            const tbody = document.getElementById('tbody-artikel');
            if (!res.data || res.data.length === 0) {
                tbody.innerHTML = '<tr><td colspan="6"><div class="empty-state"><p>Belum ada data artikel</p></div></td></tr>';
                return;
            }
            tbody.innerHTML = res.data.map(a => `
                <tr>
                    <td><img class="gambar-thumb" src="uploads_artikel/${esc(a.gambar)}" alt="gambar"></td>
                    <td>${esc(a.judul)}</td>
                    <td><span class="badge ${getBadgeClass(a.nama_kategori)}">${esc(a.nama_kategori)}</span></td>
                    <td>${esc(a.nama_depan)} ${esc(a.nama_belakang)}</td>
                    <td class="tanggal-text">${esc(a.hari_tanggal)}</td>
                    <td>
                        <button class="btn btn-warning btn-sm" onclick="openEditArtikel(${a.id})">Edit</button>
                        <button class="btn btn-danger btn-sm" onclick="konfirmasiHapusArtikel(${a.id})">Hapus</button>
                    </td>
                </tr>`).join('');
        });
}

function loadDropdownPenulis(selectId, selectedId = null) {
    fetch('ambil_penulis.php')
        .then(r => r.json())
        .then(res => {
            const sel = document.getElementById(selectId);
            sel.innerHTML = res.data.map(p =>
                `<option value="${p.id}" ${p.id == selectedId ? 'selected' : ''}>${esc(p.nama_depan)} ${esc(p.nama_belakang)}</option>`
            ).join('');
        });
}

function loadDropdownKategori(selectId, selectedId = null) {
    fetch('ambil_kategori.php')
        .then(r => r.json())
        .then(res => {
            const sel = document.getElementById(selectId);
            sel.innerHTML = res.data.map(k =>
                `<option value="${k.id}" ${k.id == selectedId ? 'selected' : ''}>${esc(k.nama_kategori)}</option>`
            ).join('');
        });
}

function openModalTambahArtikel() {
    document.getElementById('ta-judul').value = '';
    document.getElementById('ta-isi').value = '';
    document.getElementById('ta-gambar').value = '';
    loadDropdownPenulis('ta-penulis');
    loadDropdownKategori('ta-kategori');
    openOverlay('overlay-tambah-artikel');
}

function simpanArtikel() {
    const fd = new FormData();
    fd.append('judul',       document.getElementById('ta-judul').value.trim());
    fd.append('id_penulis',  document.getElementById('ta-penulis').value);
    fd.append('id_kategori', document.getElementById('ta-kategori').value);
    fd.append('isi',         document.getElementById('ta-isi').value.trim());
    const gambar = document.getElementById('ta-gambar').files[0];
    if (gambar) fd.append('gambar', gambar);

    fetch('simpan_artikel.php', { method: 'POST', body: fd })
        .then(r => r.json())
        .then(res => {
            showAlert('alert-tambah-artikel', res.message, res.status === 'success' ? 'success' : 'error');
            if (res.status === 'success') {
                setTimeout(() => closeOverlay('overlay-tambah-artikel'), 1000);
                loadArtikel();
            }
        });
}

function openEditArtikel(id) {
    fetch('ambil_satu_artikel.php?id=' + id)
        .then(r => r.json())
        .then(res => {
            if (res.status !== 'success') return;
            const a = res.data;
            document.getElementById('ea-id').value    = a.id;
            document.getElementById('ea-judul').value = a.judul;
            document.getElementById('ea-isi').value   = a.isi;
            document.getElementById('ea-gambar').value = '';
            loadDropdownPenulis('ea-penulis', a.id_penulis);
            loadDropdownKategori('ea-kategori', a.id_kategori);
            openOverlay('overlay-edit-artikel');
        });
}

function updateArtikel() {
    const fd = new FormData();
    fd.append('id',          document.getElementById('ea-id').value);
    fd.append('judul',       document.getElementById('ea-judul').value.trim());
    fd.append('id_penulis',  document.getElementById('ea-penulis').value);
    fd.append('id_kategori', document.getElementById('ea-kategori').value);
    fd.append('isi',         document.getElementById('ea-isi').value.trim());
    const gambar = document.getElementById('ea-gambar').files[0];
    if (gambar) fd.append('gambar', gambar);

    fetch('update_artikel.php', { method: 'POST', body: fd })
        .then(r => r.json())
        .then(res => {
            showAlert('alert-edit-artikel', res.message, res.status === 'success' ? 'success' : 'error');
            if (res.status === 'success') {
                setTimeout(() => closeOverlay('overlay-edit-artikel'), 1000);
                loadArtikel();
            }
        });
}

function konfirmasiHapusArtikel(id) {
    document.getElementById('hapus-artikel-id').value = id;
    openOverlay('overlay-hapus-artikel');
}

function hapusArtikel() {
    const id = document.getElementById('hapus-artikel-id').value;
    const fd = new FormData();
    fd.append('id', id);
    fetch('hapus_artikel.php', { method: 'POST', body: fd })
        .then(r => r.json())
        .then(res => {
            closeOverlay('overlay-hapus-artikel');
            if (res.status === 'success') loadArtikel();
            else alert(res.message);
        });
}

// ============================================================
// ================== KATEGORI ================================
// ============================================================
function loadKategori() {
    fetch('ambil_kategori.php')
        .then(r => r.json())
        .then(res => {
            const tbody = document.getElementById('tbody-kategori');
            if (!res.data || res.data.length === 0) {
                tbody.innerHTML = '<tr><td colspan="3"><div class="empty-state"><p>Belum ada data kategori</p></div></td></tr>';
                return;
            }
            tbody.innerHTML = res.data.map(k => `
                <tr>
                    <td><span class="badge ${getBadgeClass(k.nama_kategori)}">${esc(k.nama_kategori)}</span></td>
                    <td>${esc(k.keterangan)}</td>
                    <td>
                        <button class="btn btn-warning btn-sm" onclick="openEditKategori(${k.id})">Edit</button>
                        <button class="btn btn-danger btn-sm" onclick="konfirmasiHapusKategori(${k.id})">Hapus</button>
                    </td>
                </tr>`).join('');
        });
}

function openModalTambahKategori() {
    document.getElementById('tk-nama').value = '';
    document.getElementById('tk-keterangan').value = '';
    openOverlay('overlay-tambah-kategori');
}

function simpanKategori() {
    const fd = new FormData();
    fd.append('nama_kategori', document.getElementById('tk-nama').value.trim());
    fd.append('keterangan',    document.getElementById('tk-keterangan').value.trim());

    fetch('simpan_kategori.php', { method: 'POST', body: fd })
        .then(r => r.json())
        .then(res => {
            showAlert('alert-tambah-kategori', res.message, res.status === 'success' ? 'success' : 'error');
            if (res.status === 'success') {
                setTimeout(() => closeOverlay('overlay-tambah-kategori'), 1000);
                loadKategori();
            }
        });
}

function openEditKategori(id) {
    fetch('ambil_satu_kategori.php?id=' + id)
        .then(r => r.json())
        .then(res => {
            if (res.status !== 'success') return;
            const k = res.data;
            document.getElementById('ek-id').value          = k.id;
            document.getElementById('ek-nama').value        = k.nama_kategori;
            document.getElementById('ek-keterangan').value  = k.keterangan ?? '';
            openOverlay('overlay-edit-kategori');
        });
}

function updateKategori() {
    const fd = new FormData();
    fd.append('id',            document.getElementById('ek-id').value);
    fd.append('nama_kategori', document.getElementById('ek-nama').value.trim());
    fd.append('keterangan',    document.getElementById('ek-keterangan').value.trim());

    fetch('update_kategori.php', { method: 'POST', body: fd })
        .then(r => r.json())
        .then(res => {
            showAlert('alert-edit-kategori', res.message, res.status === 'success' ? 'success' : 'error');
            if (res.status === 'success') {
                setTimeout(() => closeOverlay('overlay-edit-kategori'), 1000);
                loadKategori();
            }
        });
}

function konfirmasiHapusKategori(id) {
    document.getElementById('hapus-kategori-id').value = id;
    openOverlay('overlay-hapus-kategori');
}

function hapusKategori() {
    const id = document.getElementById('hapus-kategori-id').value;
    const fd = new FormData();
    fd.append('id', id);
    fetch('hapus_kategori.php', { method: 'POST', body: fd })
        .then(r => r.json())
        .then(res => {
            closeOverlay('overlay-hapus-kategori');
            if (res.status === 'success') loadKategori();
            else alert(res.message);
        });
}

// ============================================================
// INIT
// ============================================================
loadPenulis();
</script>
</body>
</html>
