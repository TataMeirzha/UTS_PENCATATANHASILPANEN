<?php
session_start();

include "koneksi.php";

if (isset($_POST['login'])) {

    if (!isset($conn)) {
    die("Koneksi database gagal.");
    }

    $username = $_POST['username'];
    $pass     = $_POST['password'];

    $query  = "SELECT * FROM tbl_user WHERE username = '$username'";
    $result = mysqli_query($conn, $query);
    $data   = mysqli_fetch_assoc($result);

    // ✅ CEK LOGIN
    if ($data && password_verify($pass, $data['password'])) {

        $_SESSION['username'] = $data['username'];
        $_SESSION['role']     = $data['role'];

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