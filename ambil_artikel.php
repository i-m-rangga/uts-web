<?php
header('Content-Type: application/json');
require_once 'koneksi.php';

$sql = "SELECT a.id, a.judul, a.gambar, a.hari_tanggal, a.isi,
               p.nama_depan, p.nama_belakang,
               k.nama_kategori
        FROM artikel a
        JOIN penulis p ON a.id_penulis = p.id
        JOIN kategori_artikel k ON a.id_kategori = k.id
        ORDER BY a.id DESC";

$stmt = $koneksi->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

$stmt->close();
$koneksi->close();

echo json_encode(['status' => 'success', 'data' => $data]);
