<?php
header('Content-Type: application/json');
require_once 'koneksi.php';

$id          = isset($_POST['id']) ? (int)$_POST['id'] : 0;
$judul       = trim($_POST['judul'] ?? '');
$id_penulis  = isset($_POST['id_penulis']) ? (int)$_POST['id_penulis'] : 0;
$id_kategori = isset($_POST['id_kategori']) ? (int)$_POST['id_kategori'] : 0;
$isi         = trim($_POST['isi'] ?? '');

if ($id <= 0 || !$judul || $id_penulis <= 0 || $id_kategori <= 0 || !$isi) {
    echo json_encode(['status' => 'error', 'message' => 'Data tidak lengkap']);
    exit;
}

// Ambil data lama
$stmtOld = $koneksi->prepare("SELECT gambar FROM artikel WHERE id = ?");
$stmtOld->bind_param('i', $id);
$stmtOld->execute();
$old = $stmtOld->get_result()->fetch_assoc();
$stmtOld->close();

if (!$old) {
    echo json_encode(['status' => 'error', 'message' => 'Data tidak ditemukan']);
    exit;
}

$nama_file = $old['gambar'];

// Handle gambar baru jika ada
if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
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
}

$stmt = $koneksi->prepare("UPDATE artikel SET id_penulis=?, id_kategori=?, judul=?, isi=?, gambar=? WHERE id=?");
$stmt->bind_param('iisssi', $id_penulis, $id_kategori, $judul, $isi, $nama_file, $id);

if ($stmt->execute()) {
    if ($nama_file !== $old['gambar']) {
        $file_lama = __DIR__ . '/uploads_artikel/' . $old['gambar'];
        if (file_exists($file_lama)) unlink($file_lama);
    }
    echo json_encode(['status' => 'success', 'message' => 'Artikel berhasil diperbarui']);
} else {
    if ($nama_file !== $old['gambar'] && file_exists(__DIR__ . '/uploads_artikel/' . $nama_file)) {
        unlink(__DIR__ . '/uploads_artikel/' . $nama_file);
    }
    echo json_encode(['status' => 'error', 'message' => 'Gagal memperbarui data']);
}

$stmt->close();
$koneksi->close();
