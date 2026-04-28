<?php
session_start();
include __DIR__ . '/koneksi.php'; // ✅ path relatif yang benar

if (isset($_POST['login'])) {

    $username = $_POST['username'];
    $pass     = $_POST['password'];

    // ✅ Prepared statement (cegah SQL injection)
    $stmt = $conn->prepare("SELECT * FROM user WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $data = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if ($data && password_verify($pass, $data['password'])) {
        $_SESSION['login']    = true;
        $_SESSION['username'] = $username;
        $_SESSION['role']     = $data['role'];

        if ($data['role'] == 'admin') {
            header("Location: /api/dashboardadmin.php"); // ✅ typo "dasboard" diperbaiki
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