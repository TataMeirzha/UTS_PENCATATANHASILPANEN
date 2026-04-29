<?php
include_once __DIR__ . '/koneksi.php'; 

if (isset($_POST['login'])) {

    if (!$conn) {
        die("Koneksi database tidak tersedia.");
    }

    $username = $_POST['username'];
    $pass     = $_POST['password'];

    $query  = "SELECT * FROM tbl_user WHERE username = '$username'";
    $result = mysqli_query($conn, $query);
    $data   = mysqli_fetch_assoc($result);

    // ✅ CEK LOGIN
    if ($data && password_verify($pass, $data['password'])) {

        setcookie('username', $data['username'], time() + 3600, '/');
        setcookie('role',     $data['role'],     time() + 3600, '/');

        // ✅ REDIRECT SESUAI ROLE
        if ($data['role'] == 'admin') {
            header ("Location: /api/dashboardadmin.php");
        } else {
            header("Location: /api/dashboarduser.php");
        }
        exit;

    } else {
        header("Location: /api/login.php?error=1");
        exit;
    }
}
?>