<!DOCTYPE html>
<html>
    <head>
        <title>Upload foto</title>
</head>
<body>

<h2>Upload Foto</h2>

<form action="" method="post" enctype="multipart/form-data">
    <input type="file" name="foto" required><br><br>

    <textarea name="keterangan"
    placeholder="Masukkan keterangan"></textarea><br><br>

    <button type="submit" name="upload">
        Upload
    </button>
</form>

</body>
</html>

<?php
include "koneksi.php";

if(isset($_POST['upload'])){

    $namaFoto = $_FILES['foto']['name'];
    $tmp = $_FILES['foto']['tmp_name'];

    $keterangan = $_POST['keterangan'];

    move_uploaded_file($tmp, "uploads/" . $namaFoto);

    mysqli_query($conn,
    "INSERT INTO postingan(foto, keterangan)
    VALUES('$namaFoto', '$keterangan')");

    echo "Upload berhasil!";
}
?>
</form>
</body>
</html>