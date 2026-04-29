<?php
session_start();
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

        // ✅ SIMPAN KE SESSION (bukan cookie)
        $_SESSION['login']    = true;
        $_SESSION['username'] = $data['username'];
        $_SESSION['role']     = $data['role'];

        // ✅ REDIRECT SESUAI ROLE
        if ($data['role'] == 'admin') {
           echo "login berhasil";
        } else {
            echo "login gagal";
        }
        exit;

    } else {
        header("Location: /api/login.php?error=1");
        exit;
    }
}
?>