<?php
$host     = 'localhost';
$user     = 'root';
$password = '';
$database = 'db_blog';

$koneksi = new mysqli($host, $user, $password, $database);

if ($koneksi->connect_error) {
    die(json_encode([
        'status'  => 'error',
        'message' => 'Koneksi database gagal: ' . $koneksi->connect_error
    ]));
}

$koneksi->set_charset('utf8mb4');
