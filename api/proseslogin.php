<?php
session_start();
include_once __DIR__ . '/koneksi.php'; 

if (isset($_POST['login'])) {

    if (!$conn) {
        die("Koneksi database tidak tersedia.");
    }

    $username = $_POST['username'];
    $pass     = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM tbl_user WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $data = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    // ✅ CEK LOGIN
    if ($data && password_verify($pass, $data['password'])) {

        // ✅ SIMPAN KE SESSION (bukan cookie)
        $_SESSION['login']    = true;
        $_SESSION['username'] = $data['username'];
        $_SESSION['role']     = $data['role'];

        // ✅ REDIRECT SESUAI ROLE
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