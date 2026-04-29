<?php
header('Content-Type: application/json');
require_once 'koneksi.php';

$id            = isset($_POST['id']) ? (int)$_POST['id'] : 0;
$nama_depan    = trim($_POST['nama_depan'] ?? '');
$nama_belakang = trim($_POST['nama_belakang'] ?? '');
$user_name     = trim($_POST['user_name'] ?? '');
$password      = $_POST['password'] ?? '';

if ($id <= 0 || !$nama_depan || !$nama_belakang || !$user_name) {
    echo json_encode(['status' => 'error', 'message' => 'Data tidak lengkap']);
    exit;
}

// Ambil data lama
$stmtOld = $koneksi->prepare("SELECT foto FROM penulis WHERE id = ?");
$stmtOld->bind_param('i', $id);
$stmtOld->execute();
$old = $stmtOld->get_result()->fetch_assoc();
$stmtOld->close();

if (!$old) {
    echo json_encode(['status' => 'error', 'message' => 'Data tidak ditemukan']);
    exit;
}

$nama_foto = $old['foto'];

// Handle foto baru jika ada
if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
    $tmp  = $_FILES['foto']['tmp_name'];
    $size = $_FILES['foto']['size'];

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

    $ext       = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
    $nama_foto = uniqid('foto_', true) . '.' . strtolower($ext);
    $tujuan    = __DIR__ . '/uploads_penulis/' . $nama_foto;

    if (!move_uploaded_file($tmp, $tujuan)) {
        echo json_encode(['status' => 'error', 'message' => 'Gagal mengupload foto']);
        exit;
    }
}

// Build query
if ($password !== '') {
    $hashed = password_hash($password, PASSWORD_BCRYPT);
    $stmt = $koneksi->prepare("UPDATE penulis SET nama_depan=?, nama_belakang=?, user_name=?, password=?, foto=? WHERE id=?");
    $stmt->bind_param('sssssi', $nama_depan, $nama_belakang, $user_name, $hashed, $nama_foto, $id);
} else {
    $stmt = $koneksi->prepare("UPDATE penulis SET nama_depan=?, nama_belakang=?, user_name=?, foto=? WHERE id=?");
    $stmt->bind_param('ssssi', $nama_depan, $nama_belakang, $user_name, $nama_foto, $id);
}

if ($stmt->execute()) {
    // Hapus foto lama jika diganti
    if ($nama_foto !== $old['foto'] && $old['foto'] !== 'default.png') {
        $file_lama = __DIR__ . '/uploads_penulis/' . $old['foto'];
        if (file_exists($file_lama)) unlink($file_lama);
    }
    echo json_encode(['status' => 'success', 'message' => 'Penulis berhasil diperbarui']);
} else {
    if ($nama_foto !== $old['foto'] && file_exists(__DIR__ . '/uploads_penulis/' . $nama_foto)) {
        unlink(__DIR__ . '/uploads_penulis/' . $nama_foto);
    }
    echo json_encode(['status' => 'error', 'message' => 'Gagal memperbarui data']);
}

$stmt->close();
$koneksi->close();
