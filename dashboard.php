<?php
session_start();


include "koneksi.php";

$data = mysqli_query($conn,
"SELECT * FROM postingan");
?>

<!DOCTYPE html>
<html>
    <head>
    <title>Pilih Calon Ketua dan Wakil</title>
    <link rel="stylesheet" href="dashboard.css">
    
    </head>
<div class="container">
    <body>

        <h1 class="halo">HALOOO SISWA SISWI</h1>

        <div class="deskripsi">
        <h2>
            Selamat datang di E-voting calon ketua osis dan wakil ketua osis<br>
        Silahakan baca Visi dan Misi dari masing-masing kandidat<br>
        Lalu pilih kandidat terbaikmu!!
        </div></h2>
    
    <br>

        
        <h1 class="judul-kandidat">Daftar Kandidat</h1>
        <div class="kandidat-area"></div>

<?php $no = 1;

while($d = mysqli_fetch_array($data)) { ?>

    <div style="margin-bottom:30px;">

        <div class="kandidat">

        <div class="nomor-kandidat">Kandidat <?php echo $no; ?>
    </div>
        <img src="uploads/<?php echo $d['foto']; ?>"
        width="200">

        <div class="keterangan">
            <?php echo nl2br($d['keterangan']); ?>
            </div>

        <p>
            Vote: <?php echo $d['vote']; ?>
        </p>

        <a href="vote.php?id=<?php echo $d['id']; ?>">
            <button>Pilih Kandidat</button>
        </a>
        </div>

    </div>

    <hr>

        <?php if($_SESSION['role'] == 'admin'){ ?>


    <div class="hapus">
        <a href="hapus.php?id=<?php echo $d['id']; ?>">
    <button>Hapus</button>    
    </a>
    </div>

<?php } ?>
<?php $no++; ?>
<?php } ?>

</div>
</div>
</div>
</body>
</html>