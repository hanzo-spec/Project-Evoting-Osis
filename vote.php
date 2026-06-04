<?php
include "koneksi.php";

$id = $_GET['id'];

$ip = $_SERVER['REMOTE_ADDR'];

$cek = mysqli_query($conn,
"SELECT * FROM riwayat_vote
WHERE ip_address='$ip'");

if(mysqli_num_rows($cek) > 0){

    echo "
    <script>
    alert('Kamu sudah vote foto ini!');
    window.location='dashboard.php';
    </script>
    ";

}else{

    mysqli_query($conn,
    "UPDATE postingan
    SET vote = vote + 1
    WHERE id='$id'");

    mysqli_query($conn,
    "INSERT INTO riwayat_vote
    (postingan_id, ip_address)
    VALUES('$id', '$ip')");

    header("Location: dashboard.php");
}
?>