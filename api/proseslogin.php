<?php
include_once __DIR__ . '/koneksi.php'; 

if (isset($_POST['login'])) {
    // Pastikan koneksi berhasil sebelum lanjut
    if (!$conn) {
        die("Koneksi database tidak tersedia.");
    }

    $username = $_POST['username'];
    $pass     = $_POST['password'];

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