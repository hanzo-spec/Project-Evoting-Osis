Project E-Voting Calon Ketua dan Wakil Ketua OSIS SMK PUSDIKHUBAD CIMAHI ini adalah sebuah sistem berbasis web yang dirancang untuk mempermudah proses pemungutan suara (voting) dalam pemilihan di sekolah.
Berikut adalah penjelasan mengenai project ini.
## 1. Alasan Dibuatnya Project
Project ini dibuat untuk menggantikan metode pemilihan konvensional (menggunakan kertas suara fisik) menjadi sistem digital. Alasan nya meliputi:
 * **Efisiensi Waktu dan Biaya:** Menghemat anggaran pencetakan surat suara dan mempercepat proses penghitungan suara secara *real-time*.
 * **Akurasi Data:** Meminimalkan risiko kesalahan manusia (*human error*) saat menghitung suara manual.
 * **Kemudahan Akses:** Siswa-siswi dapat melihat visi-misi kandidat dan memberikan hak suara mereka langsung melalui perangkat komputer atau smartphone.
## 2. Penjelasan setiap file 
 1. **koneksi.php** adalah fondasi utama yang menghubungkan database MySQL (voting_osis) ke semua file PHP yang membutuhkan manipulasi data (proseslog.php, dashboard.php, vote.php, hapus.php, upload.php).
 2. Pengguna pertama kali masuk melalui **login.php**, lalu datanya diproses oleh **proseslog.php**. Jika sukses, pengguna diarahkan ke **dashboard.php**.
 3. Di dalam **dashboard.php**, pengguna dengan peran *user* dapat memilih kandidat yang memicu jalannya fungsi di **vote.php**. Sementara pengguna dengan peran *admin* akan melihat tombol hapus yang memicu **hapus.php**.
 4. **upload.php** berdiri sendiri sebagai halaman khusus admin untuk menambahkan data kandidat baru ke dalam database.
 5. **style.css** mengatur tampilan halaman login, sedangkan **dashboard.css** mengatur tampilan halaman utama pemilihan(dashboard.php)

Berikut adalah penjelasan untuk kode program project *E-Voting Calon Ketua dan Wakil Ketua OSIS SMK PUSDIKHUBAD CIMAHI*.
## 1. DATABASE (voting_osis.sql)
File ini adalah skrip SQL untuk membuat struktur tabel dan mengisi data awal (seed data) ke dalam database MySQL menggunakan phpMyAdmin.
### Bagian Pengaturan Awal (Header Metadata)
```sql
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

```
 * **SET SQL_MODE...**: Mengatur agar jika ada nilai 0 pada kolom AUTO_INCREMENT, nilai tersebut tidak otomatis berubah ke urutan berikutnya.
 * **START TRANSACTION;**: Memulai sesi transaksi database. Jika seluruh perintah di bawahnya sukses, data akan disimpan secara permanen (COMMIT).
 * **SET time_zone...**: Mengatur zona waktu database ke UTC (+00:00).
```sql
/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

```
 * Bagian ini adalah *conditional comments* untuk mengamankan enkripsi karakter agar mendukung format utf8mb4 (kompatibel dengan berbagai simbol, emoji, dan teks universal).
### Tabel 1: postingan (Data Kandidat)
```sql
CREATE TABLE `postingan` (
  `id` int(11) NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `vote` int(11) DEFAULT 0,
  `foto_wakil` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

```
 * **CREATE TABLE...**: Membuat tabel bernama postingan untuk menampung data visi, misi, dan foto kandidat.
 * **id**: Angka bulat (int), batas maksimal panjang tampilan 11 digit, tidak boleh kosong (NOT NULL). Berfungsi sebagai ID unik kandidat.
 * **foto**: Menyimpan nama file gambar ketua (maksimal 255 karakter). Berupa DEFAULT NULL (boleh kosong di awal).
 * **keterangan**: Tipe data text untuk menampung teks panjang (visi, misi, dan identitas kandidat).
 * **vote**: Angka bulat untuk menghitung jumlah suara. Standarnya bernilai 0 (DEFAULT 0).
 * **foto_wakil**: Menyimpan nama file gambar wakil ketua (tidak terpakai penuh di web saat ini, tapi strukturnya ada).
 * **ENGINE=InnoDB**: Menggunakan *storage engine* InnoDB yang mendukung relasi antar tabel (*Foreign Key*) dan transaksi yang aman.
```sql
INSERT INTO `postingan` (`id`, `foto`, `keterangan`, `vote`, `foto_wakil`) VALUES
(16, '1-min.png', 'IDENTITAS KANDIDAT\r\nVISI MISI KANDIDAT', 1, NULL),
(17, '1-min.png', 'IDENTITAS KANDIDAT\r\nVISI MISI KANDIDAT', 0, NULL),
(18, '1-min.png', 'IDENTITAS KANDIDAT\r\nVISI MISI KANDIDAT', 0, NULL);

```
 * Memasukkan 3 data kandidat awal (ID 16, 17, 18). Kandidat 16 sudah mendapatkan 1 vote, sedangkan yang lain masih 0. \r\n menandakan baris baru (Enter) pada teks keterangan.
### Tabel 2: riwayat_vote (Log Pemilih)
```sql
CREATE TABLE `riwayat_vote` (
  `id` int(11) NOT NULL,
  `postingan_id` int(11) DEFAULT NULL,
  `ip_addres` varchar(100) DEFAULT NULL,
  `ip_address` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

```
 * Tabel ini mencatat rekam jejak komputer/perangkat yang sudah melakukan voting agar tidak terjadi manipulasi suara (memilih berulang kali).
 * *Catatan Struktural:* Terdapat typo kolom yaitu ip_addres (kurang s) dan kolom perbaikan ip_address. Sistem PHP pada web ini menggunakan kolom ip_address.
```sql
INSERT INTO `riwayat_vote` (`id`, `postingan_id`, `ip_addres`, `ip_address`) VALUES
(9, 16, NULL, '::1');

```
 * Mencatat bahwa perangkat dengan IP ::1 (artinya *localhost* pada IPv6) telah memberikan suara kepada kandidat dengan postingan_id bernilai 16.
### Tabel 3: users (Data Akun)
```sql
CREATE TABLE `users` (
  `ID` int(11) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `role` varchar(20) DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

```
 * Tabel untuk otentikasi pengguna saat login. Kolom role menentukan hak akses user (apakah dia admin yang bisa menghapus data atau user biasa).
```sql
INSERT INTO `users` (`ID`, `username`, `password`, `role`) VALUES
(1, 'farhan ganteng', '12345', 'admin'),
(2, 'siswa siswi', '12345', 'user');

```
 * Memasukkan dua user bawaan. Akun farhan ganteng bertindak sebagai Admin, sementara akun siswa siswi bertindak sebagai Pemilih (User).
### Konfigurasi Indeks & Auto Increment
```sql
ALTER TABLE `postingan` ADD PRIMARY KEY (`id`);
ALTER TABLE `riwayat_vote` ADD PRIMARY KEY (`id`);
ALTER TABLE `users` ADD PRIMARY KEY (`ID`);

```
 * **ALTER TABLE... ADD PRIMARY KEY**: Menentukan kolom id / ID dari masing-masing tabel sebagai *Primary Key* (identitas utama yang unik dan tidak boleh kembar).
```sql
ALTER TABLE `postingan` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
ALTER TABLE `riwayat_vote` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
ALTER TABLE `users` MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

```
 * **MODIFY... AUTO_INCREMENT**: Mengubah sifat kolom ID agar otomatis bertambah 1 angka setiap kali ada data baru yang masuk. AUTO_INCREMENT=19 artinya data berikutnya otomatis mendapat ID 19.
 * **COMMIT;**: Mengunci dan menerapkan seluruh perubahan ke database secara permanen.
## 2. BEDAH FILE PHP & INTERAKSI BARIS KODE
### file: koneksi.php
```php
<?php
$host = "localhost"; // Menyimpan alamat server database (lokal komputer)
$user = "root";      // Username default untuk server database lokal XAMPP
$pass = "";          // Password default XAMPP (kosong)
$db = "voting_osis"; // Nama database yang dituju

// Membuat koneksi ke MySQL menggunakan fungsi mysqli_connect
$conn = mysqli_connect($host, $user, $pass, $db);

// Memeriksa apakah koneksi berhasil atau gagal
if (!$conn) {
    // Jika koneksi gagal (!artinya tidak/gagal), matikan script (die) dan tampilkan pesan error
    die("koneksi gagal: " . mysqli_connect_error());
}
?>

```
### file: login.php
```html
<!DOCTYPE html>
<html>
    <head>
    <title>E-Voting Calon Ketua Osis</title>
    <!-- Menghubungkan halaman html ini ke stylesheet style.css -->
    <link rel="stylesheet" href="style.css">
    </head>
    <body>
       <!-- Container utama pembungkus seluruh konten halaman login -->
       <div class="container">

       <!-- Bagian judul teks selamat datang -->
       <div class="judul">
        <h1>Selamat Datang <br>di Pemilihan Calon Ketua Osis dan Wakil Ketua Osis<br> SMK PUSDIKHUBAD CIMAHI</h1></div><br><br>

        <!-- Kotak putih tempat form login -->
        <div class="login-box">
           <h2> Silahkan Login</h2>
        <!-- Form mengirim data ke proseslog.php menggunakan metode POST agar data tersembunyi di URL -->
        <form action="proseslog.php" method="POST">
            <label>Username:</label><br>
            <!-- Input teks untuk username dengan atribut name="username" sebagai pengenal di PHP -->
            <input type="text" name="username"><br>
            <label>Password:</label><br>
            <!-- Input password (karakter akan disamarkan jadi bintang/bulatan) dengan name="password" -->
            <input type="password" name="password"><br>
            <!-- Tombol untuk memicu pengiriman data form -->
            <button type="submit">Login</button>
        </form>
        </div>
</div>
    </body>
</html>

```
### file: proseslog.php
```php
<?php
include 'koneksi.php'; // Menyisipkan file koneksi database agar bisa memakai variabel $conn

session_start(); // Memulai session PHP untuk menyimpan data login pengguna di server

// Mengambil data yang diketikkan user di form login.php berdasarkan atribut 'name'
$username = $_POST['username'];
$password = $_POST['password'];

// Menyusun perintah SQL untuk mencari user yang username dan password-nya cocok
$query = "SELECT * FROM users WHERE username='$username' AND password='$password'";

// Menjalankan query SQL ke database
$result = mysqli_query($conn, $query);

// Memeriksa apakah ada baris data yang ditemukan (jika > 0 berarti akunnya ada)
if (mysqli_num_rows($result) > 0) {

    // Mengambil data hasil query dalam bentuk array asosiatif
    $data = mysqli_fetch_assoc($result);

    // Menyimpan data username dan role ke dalam SESSION agar bisa diakses di halaman lain
    $_SESSION['username'] = $data['username'];
    $_SESSION['role'] = $data['role'];

    // Mengalihkan (redirect) paksa browser ke halaman dashboard.php
    header("Location: dashboard.php");

} else {
    // Jika data tidak ditemukan, cetak tulisan gagal di layar
    echo "username atau password salah";
}
?>

```
### file: dashboard.php
```php
<?php
session_start(); // Memulai/melanjutkan session untuk membaca siapa yang sedang login

include "koneksi.php"; // Menghubungkan ke database

// Mengambil seluruh data kandidat dari tabel postingan
$data = mysqli_query($conn, "SELECT * FROM postingan");
?>

<!DOCTYPE html>
<html>
    <head>
    <title>Pilih Calon Ketua dan Wakil</title>
    <!-- Menghubungkan halaman ke file dashboard.css -->
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
        </div></h2> <!-- Catatan penulisan: Struktur tag menutup </h2> di luar </div> terbalik, namun browser masih mencoba membacanya -->
    
    <br>
        
        <h1 class="judul-kandidat">Daftar Kandidat</h1>
        <div class="kandidat-area"></div>

<?php 
$no = 1; // Membuat variabel counter untuk penomoran otomatis kandidat (Kandidat 1, Kandidat 2, dst)

// Melakukan perulangan (looping) selama data kandidat di database masih ada
while($d = mysqli_fetch_array($data)) { ?>

    <div style="margin-bottom:30px;"> <!-- Pembungkus luar satu blok kandidat dengan jarak bawah 30px -->

        <div class="kandidat">

        <!-- Menampilkan nomor urut kandidat secara dinamis -->
        <div class="nomor-kandidat">Kandidat <?php echo $no; ?></div>
        
        <!-- Menampilkan foto kandidat yang diambil dari folder 'uploads/' berdasarkan nama file di database -->
        <img src="uploads/<?php echo $d['foto']; ?>" width="200">

        <div class="keterangan">
            <!-- nl2br berfungsi mengubah baris baru (\n) di database menjadi tag <br> di HTML agar teks berparagraf -->
            <?php echo nl2br($d['keterangan']); ?>
        </div>

        <p>
            <!-- Menampilkan perolehan jumlah vote saat ini -->
            Vote: <?php echo $d['vote']; ?>
        </p>

        <!-- Link tombol untuk memilih. Mengirimkan ID kandidat lewat URL (Metode GET), misal: vote.php?id=16 -->
        <a href="vote.php?id=<?php echo $d['id']; ?>">
            <button>Pilih Kandidat</button>
        </a>
        </div>

    </div>

    <hr> <!-- Garis pembatas horizontal antar kandidat -->

    <!-- Cek Kondisi: Tombol Hapus di bawah ini HANYA muncul jika akun yang login memiliki role 'admin' -->
    <?php if($_SESSION['role'] == 'admin'){ ?>
        <div class="hapus">
            <!-- Link untuk menghapus kandidat berdasarkan ID ke file hapus.php -->
            <a href="hapus.php?id=<?php echo $d['id']; ?>">
                <button>Hapus</button>    
            </a>
        </div>
    <?php } ?>

<?php 
$no++; // Menambah nomor urut (+1) untuk iterasi kandidat berikutnya
} // Penutup perulangan while 
?>

</div>
</div>
</div>
</body>
</html>

```
### file: vote.php
```php
<?php
include "koneksi.php"; // Menyisipkan koneksi database

$id = $_GET['id']; // Mengambil ID kandidat yang dipilih dari parameter URL (?id=...)

$ip = $_SERVER['REMOTE_ADDR']; // Mengambil alamat IP (IP Address) dari perangkat komputer pemilih

// Mengecek ke database apakah IP komputer ini sudah pernah memilih sebelumnya
$cek = mysqli_query($conn, "SELECT * FROM riwayat_vote WHERE ip_address='$ip'");

// Jika jumlah baris lebih dari 0, berarti IP ini sudah tercatat pernah memilih
if(mysqli_num_rows($cek) > 0){
    // Tampilkan pesan peringatan pop-up JavaScript dan kembalikan user ke dashboard.php
    echo "
    <script>
    alert('Kamu sudah vote foto ini!');
    window.location='dashboard.php';
    </script>
    ";
} else {
    // Jika IP belum pernah memilih, lakukan penambahan 1 poin vote pada kandidat bersangkutan
    mysqli_query($conn, "UPDATE postingan SET vote = vote + 1 WHERE id='$id'");

    // Catat IP Address komputer tersebut ke tabel riwayat_vote agar tidak bisa memilih lagi
    mysqli_query($conn, "INSERT INTO riwayat_vote (postingan_id, ip_address) VALUES('$id', '$ip')");

    // Kembalikan ke halaman dashboard dengan kondisi data vote yang sudah diperbarui
    header("Location: dashboard.php");
}
?>

```
### file: hapus.php
```php
<?php
session_start(); // Memulai session

// Keamanan: Jika role penjelajah bukan 'admin', program langsung dihentikan paksa (Akses ditolak)
if($_SESSION['role'] != 'admin'){
    die("Akses ditolak");
}

include "koneksi.php"; // Konek ke DB

$id = $_GET['id']; // Mengambil ID data yang mau dihapus dari URL

// Mengambil data kandidat tersebut terlebih dahulu untuk mengetahui nama file fotonya
$data = mysqli_query($conn, "SELECT * FROM postingan WHERE id='$id'");
$d = mysqli_fetch_array($data);
$foto = $d['foto']; // Menyimpan nama file foto (misal: 1-min.png) ke variabel $foto

// Menghapus file gambar fisik dari dalam folder penyimpanan 'uploads' di server lokal komputer
unlink("uploads/" . $foto);

// Menghapus baris data kandidat dari database berdasarkan ID-nya
mysqli_query($conn, "DELETE FROM postingan WHERE id='$id'");

// Mengalihkan kembali halaman ke dashboard.php setelah proses hapus selesai
header("Location: dashboard.php");
?>

```
### file: upload.php
```html
<!DOCTYPE html>
<html>
    <head>
        <title>Upload foto</title>
</head>
<body>

<h2>Upload Foto</h2>

<!-- Form upload data wajib menggunakan metode POST dan wajib memakai atribut enctype="multipart/form-data" agar file bisa terkirim -->
<form action="" method="post" enctype="multipart/form-data">
    <!-- Input untuk memilih file gambar dari komputer -->
    <input type="file" name="foto" required><br><br>

    <!-- Tempat mengetik deskripsi visi dan misi kandidat -->
    <textarea name="keterangan" placeholder="Masukkan keterangan"></textarea><br><br>

    <!-- Tombol kirim dengan name="upload" untuk divalidasi PHP di bawah -->
    <button type="submit" name="upload">Upload</button>
</form>

</body>
</html>

<?php
include "koneksi.php"; // Sambungkan database

// Memeriksa apakah tombol dengan name="upload" sudah diklik oleh user
if(isset($_POST['upload'])){

    $namaFoto = $_FILES['foto']['name']; // Mengambil nama asli file yang diunggah (misal: 'kandidat1.jpg')
    $tmp = $_FILES['foto']['tmp_name'];   // Mengambil lokasi penyimpanan sementara file tersebut di sistem server

    $keterangan = $_POST['keterangan'];  // Mengambil teks dari textarea

    // Memindahkan file dari lokasi sementara ($tmp) ke folder permanen proyek bernama "uploads/"
    move_uploaded_file($tmp, "uploads/" . $namaFoto);

    // Memasukkan nama file foto dan teks keterangan baru ke dalam tabel postingan database
    mysqli_query($conn, "INSERT INTO postingan(foto, keterangan) VALUES('$namaFoto', '$keterangan')");

    // Memberitahu user bahwa proses berhasil
    echo "Upload berhasil!";
}
?>
<!-- Catatan Penulisan: Di baris akhir file terdapat sisa tag penutup </form> </body> </html> yang berlebih (duplikat), namun tidak merusak sistem back-end PHP -->

```
### file: style.css (Desain Halaman Login)
```css
body{
    margin: 0;             /* Menghilangkan jarak bawaan luar browser di tepi layar */
    padding: 0;            /* Menghilangkan jarak bawaan dalam browser */
    font-family: Arial, sans-serif; /* Mengubah font bawaan menjadi Arial */
    background-color: #d9f5c4; /* Mewarnai latar belakang halaman dengan warna hijau muda */
}

.container{
    width: 90%;            /* Lebar container mengambil 90% dari total lebar layar */
    min-height: 90hv;      /* Typo aman: Seharusnya 90vh (Viewport Height). Mengatur tinggi minimal 90% dari tinggi layar */
    margin: 20px auto;     /* Jarak atas-bawah kotak 20px, auto membuat kotak otomatis berada di tengah secara horizontal */
    background-color: #d9f5c4; /* Warna background container disamakan dengan body */
    position: relative;    /* Mengatur posisi elemen agar menjadi acuan bagi elemen anak di dalamnya */
}

.judul{
    width: 700px;          /* Membatasi lebar teks judul maksimal 700 pixel */
    margin: auto;          /* Membuat teks judul berada tepat di posisi tengah halaman */
    text-align: center;    /* Mengatur perataan teks menjadi rata tengah */
    padding-top: 70px;     /* Memberikan jarak kosong antara tepi atas halaman ke judul sebesar 70px */
}

.judul h1{
    font-size: 40px;       /* Mengatur ukuran huruf judul menjadi besar (40 pixel) */
    color: black;          /* Warna teks hitam */
    font-weight: normal;   /* Membuat teks tidak terlalu tebal */
    line-height: 1.5;      /* Mengatur jarak spasi antar baris kalimat agar tidak terlalu rapat */
}

.login-box{
    width: 300px;          /* Lebar kotak formulir login diatur pasti 300px */
    background-color: white; /* Mengubah background kotak form menjadi putih bersih */
    border: 2px solid gray; /* Memberi garis pinggir tipis berwarna abu-abu ukuran 2px */
    padding: 20px;         /* Memberi jarak dalam sebesar 20px dari garis kotak ke isi formulir */
    margin: 40px auto;     /* Jarak kotak login dari judul di atasnya adalah 40px, auto membuat kotak rata tengah */
    border-radius: 15px;   /* Membuat sudut-sudut kotak login melengkung halus (tidak lancip) */
}

.login-box h2{
    margin-top: 0;         /* Menghilangkan jarak kosong di atas teks "Silahkan Login" */
    font-weight: normal;   /* Desain teks judul form dibuat berbobot normal */
}

.login-box label{
    font-size: 18px;       /* Mengatur ukuran teks label "Username:" dan "Password:" menjadi 18px */
}

.login-box input{
    width: 100%;           /* Lebar input teks memenuhi 100% dari ruang dalam kotak login */
    padding: 8px;          /* Memberikan ruang tebal ketikan di dalam form setebal 8px */
    margin-top: 5px;       /* Jarak label ke kotak input */
    margin-bottom: 15px;   /* Jarak dari input ke elemen di bawahnya agar tidak menempel */
    border: 1px solid black; /* Garis pinggir kotak input tipis hitam */
    box-sizing: border-box; /* Memastikan padding dalam tidak merusak/melebarkan ukuran total kotak input */
}

.login-box button{
    padding: 8px 20px;     /* Ukuran tombol login: tinggi internal 8px, lebar kesamping 20px */
    background-color: white; /* Warna tombol putih */
    border: 1px solid black; /* Garis pinggir tombol hitam */
    cursor: pointer;       /* Mengubah kursor mouse menjadi icon tangan menunjuk saat menyentuh tombol */
}

```
### file: dashboard.css (Desain Halaman Utama Pemilihan)
```css
body{
    margin: 0; padding: 0;
    background-color: #f5f5f5; /* Latar belakang dashboard berwarna abu-abu sangat terang */
    font-family: Arial, sans-serif;
}

.container{
    width: 95%;
    min-height: 100vh;     /* Tinggi container memenuhi 100% dari tinggi layar monitor */
    margin: 15px auto;
    background-color: white; /* Area utama tempat baca kandidat berwarna putih kontras */
    position: relative;
    padding-bottom: 80px;  /* Memberikan ruang kosong di dasar bawah halaman agar konten tidak terpotong */
}

/* Dekorasi Segitiga Estetik di Sudut Kanan Atas Dashboard */
.container::before{
    content: "";           /* Wajib diisi string kosong agar elemen buatan (pseudo-element) ini muncul */
    position: absolute;    /* Menempelkan elemen secara bebas berdasarkan koordinat top dan right */
    top: 0; right: 0;      /* Mengunci posisi di pojok kanan atas container */
    width: 220px; height: 220px; /* Ukuran area dekorasi */
    /* Membuat efek bergaris hijau kombinasi berlapis menggunakan efek gradasi linier bermiringan 135 derajat */
    background: linear-gradient(
        135deg,
        #4d8b5b 0%, #4d8b5b 15%,
        white 15%, white 22%,
        #7dbb88 22%, #7dbb88 35%,
        white 35%, white 42%,
        #a6d6ac 42%
    );
    clip-path: polygon(100% 0, 0 0, 100% 100%); /* Memotong kotak dekorasi menjadi bentuk segitiga siku-siku sempurna */
}

.halo{
    text-align: center;
    font-size: 55px;
    font-weight: lighter;  /* Membuat teks sambutan "HALOOO..." bergaya tipis modis */
    color: black;
    padding-top: 25px;
    letter-spacing: 3px;   /* Memberikan jarak renggang antar huruf sebesar 3px */
}

.deskripsi{
    text-align: center;
    margin-top: 70px;
    font-size: 34px;
    color: black;
    line-height: 1.6;
}

.judul-kandidat{
    text-align: center;
    font-size: 55px;
    margin-top: 40px;
    margin-bottom: 50px;
}

.kandidat-area{
    display: flex;         /* Mengaktifkan sistem Flexbox agar susunan kandidat bisa berjejer ke samping */
    justify-content: center; /* Membuat barisan kandidat berkumpul rapi di tengah */
    gap: 80px;             /* Memberikan jarak antara kotak kandidat 1 dengan kandidat lainnya sebesar 80px */
    flex-wrap: wrap;       /* Jika layar HP sempit, kotak kandidat otomatis turun rapi ke bawah */
}

.kandidat{
    text-align: center;    /* Mengatur seluruh elemen di dalam kotak kandidat (nama, foto, tombol) rata tengah */
}

.kandidat img{
    width: 220px; height: 220px; /* Memaksa foto kandidat berukuran persegi 220px x 220px */
    object-fit: cover;     /* Jika foto asli tidak persegi, foto dipotong otomatis secara proporsional agar tidak gepeng */
    border: 2px solid #666; /* Garis tepi foto abu-abu gelap */
    background-color: #72d0ff; /* Background cadangan jika foto gagal dimuat */
}

.keterangan{
    margin-top: 15px;
    font-size: 24px;
    color: #555;           /* Warna teks deskripsi abu-abu agar nyaman dibaca */
    line-height: 1.4;
}

.vote{
    margin-top: 10px;
    font-size: 22px;
    color: #444;
}

/* Tombol Pilih Kandidat */
.kandidat button{
    margin-top: 20px;
    padding: 8px 30px;
    font-size: 22px;
    background-color: white;
    border: 2px solid #666;
    cursor: pointer;
}

/* Efek Interaktif Tombol */
.kandidat button:hover{
    background-color: #d9f5c4; /* Saat kursor mouse menyentuh tombol pilih, warna berubah menjadi hijau muda */
}

.hapus{
    margin-top: 15px;
}

/* Tombol Hapus (Khusus Admin) */
.hapus button{
    padding: 7px 20px;
    background-color: white;
    border: 2px solid red; /* Menggunakan aksen garis tepi warna merah penanda bahaya/hapus */
    color: red;            /* Warna tulisan teks merah */
    cursor: pointer;
}

.hapus button:hover{
    background-color: red; /* Saat disentuh mouse, tombol terisi penuh warna merah */
    color: white;          /* Tulisan di dalam tombol berganti menjadi warna putih */
}

.nomor-kandidat{
    font-size: 28px;
    font-weight: bold;     /* Menandakan teks nomor urut tebal (Kandidat 1, dst) */
    margin-bottom: 15px;
}

## 4. Fitur yang Tersedia pada Proyek
 * **Sistem Autentikasi (Login Multi-role):** Memisahkan hak akses antara Akun Admin (farhan ganteng) dan Akun User/Siswa (siswa siswi).
 * **Manajemen Kandidat Dinamis:** Admin dapat mengunggah gambar kandidat beserta visi misinya, serta menghapus kandidat yang tidak lagi dicalonkan.
 * **Sistem Pemungutan Suara (Voting System):** Siswa dapat memberikan suaranya ke kandidat pilihan hanya dengan satu klik tombol.
 * **Proteksi Double-Vote Berbasis IP:** Membaca alamat IP (::1 untuk localhost atau IP lokal jaringan) guna membatasi agar satu perangkat komputer/HP hanya bisa memberikan satu kali suara secara keseluruhan.
 * **Penghitungan Suara Real-time:** Jumlah vote langsung diakumulasikan di database dan ditampilkan di dashboard saat itu juga.
## 5. Bahasa Pemrograman yang Digunakan
 * **PHP (Hypertext Preprocessor)**
 * **HTML**
 * **CSS**
 * **SQL (Structured Query Language)**

