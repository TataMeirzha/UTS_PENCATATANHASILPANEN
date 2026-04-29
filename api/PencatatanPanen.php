<?php
include "koneksi.php";

if(!isset($_COOKIE['username'])){
    header("Location: /api/login.php");
    exit;
}

$username = $_COOKIE['username'];

// SIMPAN DATA
if(isset($_POST['simpan'])){
    $tanggal   = mysqli_real_escape_string($conn, $_POST['tanggal_panen']);
    $komoditas = mysqli_real_escape_string($conn, $_POST['komoditas_panen']);
    $jumlah    = (int)$_POST['jumlah_panen'];
    $satuan    = mysqli_real_escape_string($conn, $_POST['satuan_panen']);

    // Hapus kolom id — biarkan auto increment
    $query = "INSERT INTO tbl_panen (tanggal, komoditas, jumlah, satuan) 
              VALUES ('$tanggal','$komoditas','$jumlah','$satuan')";

    if(mysqli_query($conn, $query)){
        header("Location: /api/PencatatanPanen.php");
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

// HAPUS DATA
if(isset($_GET['hapus'])){
    $id = (int)$_GET['hapus'];
    mysqli_query($conn, "DELETE FROM tbl_panen WHERE id='$id'");
    header("Location: /api/PencatatanPanen.php");
    exit;
}
?>