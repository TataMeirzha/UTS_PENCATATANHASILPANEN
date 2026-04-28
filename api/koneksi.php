<?php
$host = 'gateway01.ap-southeast-1.prod.alicloud.tidbcloud.com';
$port = 4000;
$user = '4SAcQGX7jXvf57V.root';
$pass = 'BeEFAGBjqkuT6bps';
$db   = 'db_panen';

// Inisialisasi mysqli
$conn = mysqli_init();

// SSL wajib untuk TiDB Serverless
mysqli_ssl_set($conn, NULL, NULL, NULL, NULL, NULL);

$real_connect = mysqli_real_connect(
    $conn,
    $host,
    $user,
    $pass,
    $db,
    $port,
    NULL,
    MYSQLI_CLIENT_SSL
);

if (!$real_connect) {
    die("Koneksi ke TiDB Cloud gagal: " . mysqli_connect_error());
}
?>