<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

include __DIR__ . '/koneksi.php'; // ✅ path relatif yang benar

// ✅ Validasi dulu sebelum proses
if (empty($_POST['username']) || empty($_POST['email']) || empty($_POST['password'])) {
    echo "Username, Email dan Password wajib diisi!";
    exit;
}

$username = $_POST['username'];
$email    = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

// ✅ Prepared statement (cegah SQL injection)
$stmt = $conn->prepare("INSERT INTO user (username, email, password, role) VALUES (?, ?, ?, 'user')");
$stmt->bind_param("sss", $username, $email, $password);

if ($stmt->execute()) {
    $stmt->close();
    header("Location: login.php");
    exit;
} else {
    echo "Register Gagal: " . $conn->error;
    $stmt->close();
}
?>