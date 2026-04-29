<?php
header('Content-Type: application/json');
require_once 'koneksi.php';

$nama_depan   = trim($_POST['nama_depan'] ?? '');
$nama_belakang = trim($_POST['nama_belakang'] ?? '');
$user_name    = trim($_POST['user_name'] ?? '');
$password     = $_POST['password'] ?? '';

if (!$nama_depan || !$nama_belakang || !$user_name || !$password) {
    echo json_encode(['status' => 'error', 'message' => 'Semua field wajib diisi']);
    exit;
}

// Handle foto upload
$nama_foto = 'default.png';
if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
    $tmp  = $_FILES['foto']['tmp_name'];
    $size = $_FILES['foto']['size'];

    if ($size > 2 * 1024 * 1024) {
        echo json_encode(['status' => 'error', 'message' => 'Ukuran file maksimal 2 MB']);
        exit;
    }

    $finfo     = new finfo(FILEINFO_MIME_TYPE);
    $mime      = $finfo->file($tmp);
    $allowed   = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];

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

$hashed = password_hash($password, PASSWORD_BCRYPT);

$stmt = $koneksi->prepare("INSERT INTO penulis (nama_depan, nama_belakang, user_name, password, foto) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param('sssss', $nama_depan, $nama_belakang, $user_name, $hashed, $nama_foto);

if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Penulis berhasil ditambahkan']);
} else {
    // Hapus foto jika insert gagal
    if ($nama_foto !== 'default.png' && file_exists(__DIR__ . '/uploads_penulis/' . $nama_foto)) {
        unlink(__DIR__ . '/uploads_penulis/' . $nama_foto);
    }
    echo json_encode(['status' => 'error', 'message' => 'Gagal menyimpan data: ' . $koneksi->error]);
}

$stmt->close();
$koneksi->close();
