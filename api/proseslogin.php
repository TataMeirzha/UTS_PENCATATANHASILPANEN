<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once __DIR__ . '/koneksi.php'; 

if (isset($_POST['login'])) {
    // Pastikan koneksi berhasil sebelum lanjut
    if (!$conn) {
        die("Koneksi database tidak tersedia.");
    $stmt = $conn->prepare("SELECT * FROM `user` WHERE `username` = ?");
    }

if ($stmt === false) {
    // Jika baris ini terpanggil, berarti ada yang salah dengan query/koneksi
    die("Error pada Prepare: " . $conn->error);
}

// Baris 13 (Sekarang bind_param seharusnya aman)
$stmt->bind_param("s", $username);
    $stmt = $conn->prepare("SELECT * FROM user WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $data = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if ($data && password_verify($pass, $data['password'])) {
        // --- KONFIGURASI COOKIE ---
        // Durasi: 1 jam (3600 detik)
        $expiry = time() + 3600; 
        
        // Simpan data ke cookie (disarankan simpan yang esensial saja)
        setcookie('login', 'true', $expiry, "/");
        setcookie('username', $username, $expiry, "/");
        setcookie('role', $data['role'], $expiry, "/");

        // Redirect berdasarkan role
        if ($data['role'] == 'admin') {
            header("Location: /api/dashboardadmin.php");
        } else {
            header("Location: /api/PencatatanPanen.php");
        }
        exit;

    } else {
        header("Location: /api/login.php?error=1");
        exit;
    }
}
?>