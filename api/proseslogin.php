<?php
include "koneksi.php";

if (isset($_POST['login'])) {

    if (!isset($conn)) {
        die("Koneksi database gagal.");
    }

    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $pass     = $_POST['password'];

    // ✅ Tabel disamakan dengan prosesregistrasi.php
    $query  = "SELECT * FROM user WHERE username = '$username'";
    $result = mysqli_query($conn, $query);
    $data   = mysqli_fetch_assoc($result);

    if ($data && password_verify($pass, $data['password'])) {

        // ✅ Cookie, bukan session (stabil di Vercel)
        setcookie('username', $data['username'], time() + 3600, '/');
        setcookie('role',     $data['role'],     time() + 3600, '/');

        if ($data['role'] == 'admin') {
            header("Location: /api/dashboardadmin.php");
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