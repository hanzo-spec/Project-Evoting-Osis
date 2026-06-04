<?php
include 'koneksi.php';

session_start();

$username = $_POST['username'];
$password = $_POST['password'];

$query = "SELECT * FROM users
 WHERE username='$username'
 AND password='$password'";

$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {


$data = mysqli_fetch_assoc($result);

$_SESSION['username'] = $data['username'];
$_SESSION['role'] = $data['role'];

header("Location: dashboard.php");

}else{
    echo "username atau password salah";
}
?>