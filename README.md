# **Projek E-Voting Calon Ketua dan Wakil Ketua OSIS**
 * projek ini adalah sebuah website sederhana yang dirancang untuk mempermudah pemungutan suara di lingkungan sekolah.
Berikut adalah penjelasan mengenai projek ini, mulai dari latar belakang hingga cara kerja setiap filenya.
## 1. Pengenalan Projek
 * Projek ini adalah sistem pemungutan suara elektronik (E-Voting) berbasis web.
Website ini memungkinkan siswa-siswi untuk melihat daftar kandidat ketua dan wakil ketua OSIS beserta visi-misi mereka, lalu memberikan suara (*voting*) secara digital.
## 2. Alasan Dibuatnya Projek
 * **Efisiensi Waktu dan Biaya:** Mengurangi penggunaan kertas untuk surat suara dan mempercepat proses perhitungan suara serta siswa tidak perlu mengantri saat akan melakukan voting.
 * **Akurasi Data:** Mengurangi risiko kesalahan manusia dalam menghitung suara secara manual.
## 3. Bahasa Pemrograman yang Dipakai
 * **PHP:** Digunakan sebagai bahasa pemrograman utama di sisi server (*Backend*) untuk memproses logika bisnis, interaksi database, dan manajemen sesi pengguna.
 * **HTML:** Digunakan untuk membuat struktur dan kerangka dasar halaman web.
 * **CSS:** Digunakan untuk mengatur tampilan, seperti warna, dan estetika halaman web agar menarik.
 * **MySQL/MySQLi:** Digunakan sebagai sistem manajemen database untuk menyimpan data pengguna, data kandidat (postingan), dan riwayat voting.
## 4. Struktur File dan Cara Kerja Masing-Masing File
### 1. koneksi.php
 * **Fungsi:** Menghubungkan website dengan database MySQL.
 * **Cara Kerja:** File ini mendefinisikan informasi database (localhost, user: root, nama database: voting_osis). Menggunakan fungsi mysqli_connect(). Jika koneksi gagal, aplikasi akan berhenti dan menampilkan pesan error. File ini disertakan (include) di hampir semua file lain yang membutuhkan akses data.
### 2. login.php
 * **Fungsi:** Halaman awal bagi pengguna untuk masuk ke dalam sistem.
 * **Cara Kerja:** Menampilkan form input untuk *Username* dan *Password*. Ketika tombol "Login" ditekan, data form akan dikirim ke file proseslog.php menggunakan metode POST.
### 3. proseslog.php
 * **Fungsi:** Memproses validasi akun pengguna yang mencoba login.
 * **Cara Kerja:** Menerima data dari login.php, lalu mencocokkannya dengan tabel users di database. Jika data cocok, sistem memulai sesi (session_start()), menyimpan informasi username dan role (apakah dia 'admin' atau 'siswa'), lalu mengalihkan halaman ke dashboard.php. Jika salah, muncul pesan "username atau password salah".
### 4. dashboard.php
 * **Fungsi:** Halaman utama setelah login yang menampilkan daftar kandidat.
 * **Cara Kerja:** File ini mengambil data dari tabel postingan di database. Menggunakan perulangan while, sistem menampilkan nomor urut kandidat, foto kandidat, keterangan seperti (visi-misi), dan jumlah suara yang sudah diperoleh.
   * **Fitur Hak Akses:** File ini memeriksa $_SESSION['role']. Jika yang login adalah **admin**, maka tombol "Hapus" kandidat akan muncul. Jika siswa biasa, tombol tersebut disembunyikan.
### 5. vote.php
 * **Fungsi:** Memproses pemberian suara (*voting*) untuk kandidat tertentu.
 * **Cara Kerja:** File ini mengambil ID kandidat dari URL (metode GET) dan mendeteksi IP Address komputer pemilih lewat $_SERVER['REMOTE_ADDR'].
   1. Sistem mengecek ke tabel riwayat_vote apakah IP tersebut sudah pernah memilih atau belum.
   2. Jika **sudah**, muncul peringatan bahwa user sudah memilih, lalu dikembalikan ke dashboard.
   3. Jika **belum**, sistem mengupdate tabel postingan (menambah jumlah suara: vote = vote + 1) dan mencatat IP tersebut ke tabel riwayat_vote agar tidak bisa memilih lagi, lalu dialihkan kembali ke dashboard.
### 6. upload.php
 * **Fungsi:** Halaman khusus untuk menambahkan (mengunggah foto) kandidat.
 * **Cara Kerja:** Menyediakan form input file gambar dan teks keterangan. Saat tombol upload ditekan, file gambar akan dipindahkan ke folder uploads/ menggunakan fungsi move_uploaded_file(), dan data nama file beserta keterangan akan disimpan ke database dalam tabel postingan.
### 7. hapus.php
 * **Fungsi:** Menghapus data kandidat (Fitur khusus admin).
 * **Cara Kerja:** Memvalidasi terlebih dahulu apakah yang mengakses benar-benar admin. Jika bukan, akses ditolak (die). Jika benar admin, file ini akan mengambil ID kandidat, menghapus file foto fisik yang ada di folder uploads/ menggunakan fungsi unlink(), lalu menghapus baris data kandidat tersebut di database lewat perintah DELETE.
### 8. style.css
 * **Fungsi:** Mengatur tampilan halaman login.php.
 * **Cara Kerja:** Memberikan warna latar belakang hijau muda, memposisikan kotak login tepat di tengah halaman (*center*), mengatur jenis font (Arial), serta mempercantik tombol login.
### 9. dashboard.css
 * **Fungsi:** Mengatur tata letak dan desain halaman utama (dashboard.php).
 * **Cara Kerja:** Mengatur desain agar rapi, membuat efek dekorasi geometris modern di pojok kanan atas layar menggunakan properti clip-path dan linear-gradient, serta mengatur layout kartu kandidat agar berjajar rapi secara responsif menggunakan display: flex.
