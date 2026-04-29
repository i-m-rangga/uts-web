<?php
header('Content-Type: application/json');
require_once 'koneksi.php';

$judul       = trim($_POST['judul'] ?? '');
$id_penulis  = isset($_POST['id_penulis']) ? (int)$_POST['id_penulis'] : 0;
$id_kategori = isset($_POST['id_kategori']) ? (int)$_POST['id_kategori'] : 0;
$isi         = trim($_POST['isi'] ?? '');

if (!$judul || $id_penulis <= 0 || $id_kategori <= 0 || !$isi) {
    echo json_encode(['status' => 'error', 'message' => 'Semua field wajib diisi']);
    exit;
}

if (!isset($_FILES['gambar']) || $_FILES['gambar']['error'] !== UPLOAD_ERR_OK) {
    echo json_encode(['status' => 'error', 'message' => 'Gambar wajib diunggah']);
    exit;
}

$tmp  = $_FILES['gambar']['tmp_name'];
$size = $_FILES['gambar']['size'];

if ($size > 2 * 1024 * 1024) {
    echo json_encode(['status' => 'error', 'message' => 'Ukuran file maksimal 2 MB']);
    exit;
}

$finfo   = new finfo(FILEINFO_MIME_TYPE);
$mime    = $finfo->file($tmp);
$allowed = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];

if (!in_array($mime, $allowed)) {
    echo json_encode(['status' => 'error', 'message' => 'Tipe file tidak diizinkan']);
    exit;
}

$ext       = pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION);
$nama_file = uniqid('artikel_', true) . '.' . strtolower($ext);
$tujuan    = __DIR__ . '/uploads_artikel/' . $nama_file;

if (!move_uploaded_file($tmp, $tujuan)) {
    echo json_encode(['status' => 'error', 'message' => 'Gagal mengupload gambar']);
    exit;
}

// Generate hari_tanggal
date_default_timezone_set('Asia/Jakarta');
$hari   = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
$bulan  = [
    1=>'Januari', 2=>'Februari', 3=>'Maret',
    4=>'April',   5=>'Mei',      6=>'Juni',
    7=>'Juli',    8=>'Agustus',  9=>'September',
    10=>'Oktober',11=>'November',12=>'Desember'
];
$sekarang    = new DateTime();
$nama_hari   = $hari[$sekarang->format('w')];
$tanggal     = $sekarang->format('j');
$nama_bulan  = $bulan[(int)$sekarang->format('n')];
$tahun       = $sekarang->format('Y');
$jam         = $sekarang->format('H:i');
$hari_tanggal = "$nama_hari, $tanggal $nama_bulan $tahun | $jam";

$stmt = $koneksi->prepare("INSERT INTO artikel (id_penulis, id_kategori, judul, isi, gambar, hari_tanggal) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param('iissss', $id_penulis, $id_kategori, $judul, $isi, $nama_file, $hari_tanggal);

if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Artikel berhasil ditambahkan']);
} else {
    if (file_exists($tujuan)) unlink($tujuan);
    echo json_encode(['status' => 'error', 'message' => 'Gagal menyimpan data: ' . $koneksi->error]);
}

$stmt->close();
$koneksi->close();
