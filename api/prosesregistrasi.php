<?php
// Tambahkan CORS header di paling atas
header("Access-Control-Allow-Origin: https://pemweb-frontend.vercel.app");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

// Gunakan path relatif, bukan absolute path
include __DIR__ . '/koneksi.php';

// Validasi DULU sebelum ambil data
if (empty($_POST['username']) || empty($_POST['email']) || empty($_POST['password'])) {
    echo "Username, Email dan Password wajib diisi!";
    exit;
}

$username = $_POST['username'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

// Gunakan prepared statement (cegah SQL injection)
$stmt = $conn->prepare("INSERT INTO user (username, email, password, role) VALUES (?, ?, ?, 'user')");
$stmt->bind_param("sss", $username, $email, $password);

if ($stmt->execute()) {
    header("Location: /api/login.php");
    exit;
} else {
    echo "Register Gagal: " . $conn->error;
}

$stmt->close();
?>