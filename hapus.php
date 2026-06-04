<?php
session_start();

if($_SESSION['role'] != 'admin'){
    die("Akses ditolak");
}
include "koneksi.php";

$id = $_GET['id'];

$data = mysqli_query($conn,
"SELECT * FROM postingan
WHERE id='$id'");

$d = mysqli_fetch_array($data);

$foto = $d['foto'];

unlink("uploads/" . $foto);

mysqli_query($conn,
"DELETE FROM postingan
WHERE id='$id'");

header("Location: dashboard.php");
?>