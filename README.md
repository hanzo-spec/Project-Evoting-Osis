# **Projek E-Voting Calon Ketua dan Wakil Ketua OSIS**
projek ini adalah sebuah website sederhana yang dirancang untuk mempermudah pemungutan suara di lingkungan sekolah.
Berikut adalah penjelasan mengenai projek ini, mulai dari latar belakang hingga cara kerja setiap filenya.
## 1. Pengenalan Projek
Projek ini adalah sistem pemungutan suara elektronik (E-Voting) berbasis web.
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



Proyek E-Voting Calon Ketua dan Wakil Ketua OSIS SMK PUSDIKHUBAD CIMAHI ini adalah sebuah sistem berbasis web yang dirancang untuk mendigitalisasi proses pemungutan suara (voting) dalam pemilihan internal sekolah.
Berikut adalah penjelasan lengkap mengenai proyek, hubungan antar-file, bedah kode, fitur, hingga saran pengembangannya.
## 1. Alasan Dibuatnya Proyek
Proyek ini dibuat untuk menggantikan metode pemilihan konvensional (menggunakan kertas suara fisik) menjadi sistem digital. Alasan utamanya meliputi:
 * **Efisiensi Waktu dan Biaya:** Menghemat anggaran pencetakan surat suara dan mempercepat proses penghitungan suara secara *real-time*.
 * **Akurasi Data:** Meminimalkan risiko kesalahan manusia (*human error*) saat menghitung suara manual.
 * **Kemudahan Akses:** Siswa-siswi dapat melihat visi-misi kandidat dan memberikan hak suara mereka langsung melalui perangkat komputer atau *smartphone* yang terhubung ke jaringan sekolah.
## 2. Hubungan Antar-File (Arsitektur Sistem)
Sistem ini bekerja secara dinamis dengan alur interaksi antar-file sebagai berikut:
```
                  [ style.css / dashboard.css (Desain Tampilan) ]
                                       |
[ login.php ] -------> [ proseslog.php ] -------> [ dashboard.php ]
                               |                         |
                        [ koneksi.php ]                  |-----> [ vote.php ]
                               |                         |
                    ( Database: voting_osis )            |-----> [ hapus.php ]
                               |
                        [ upload.php ]

```
 1. **koneksi.php** adalah fondasi utama yang menghubungkan database MySQL (voting_osis) ke semua file PHP yang membutuhkan manipulasi data (proseslog.php, dashboard.php, vote.php, hapus.php, upload.php).
 2. Pengguna pertama kali masuk melalui **login.php**, lalu datanya diproses oleh **proseslog.php**. Jika sukses, pengguna diarahkan ke **dashboard.php**.
 3. Di dalam **dashboard.php**, pengguna dengan peran (role) *user* dapat memilih kandidat yang memicu jalannya fungsi di **vote.php**. Sementara pengguna dengan *role* *admin* akan melihat tombol hapus yang memicu **hapus.php**.
 4. **upload.php** berdiri sendiri sebagai halaman khusus admin untuk menambahkan data kandidat baru ke dalam database.
 5. **style.css** mengatur tampilan visual halaman login, sedangkan **dashboard.css** mengatur estetika halaman utama pemilihan.
## 3. Penjelasan Kode dari Masing-Masing File
### a. koneksi.php
 * **Fungsi:** Mengatur konfigurasi kredensial database lokal menggunakan fungsi mysqli_connect().
 * **Analisis Kode:** Jika koneksi ke server database localhost dengan user root dan database voting_osis gagal, sistem akan otomatis berhenti (die) dan menampilkan pesan error.
### b. login.php & style.css
 * **Fungsi:** Menyediakan antarmuka (UI) form input bagi pengguna untuk memasukkan *username* dan *password*.
 * **Analisis Kode:** Menggunakan tag <form> dengan metode POST yang mengarah ke proseslog.php. CSS di file ini mengatur agar kotak login berada tepat di tengah layar dengan latar belakang hijau muda khas.
### c. proseslog.php
 * **Fungsi:** Melakukan verifikasi akun pengguna ke database dan membuat sesi aktif (*session*).
 * **Analisis Kode:** Mengambil data dari input form, lalu mencocokkannya menggunakan query SQL SELECT * FROM users WHERE username='...' AND password='...'. Jika ditemukan, data username dan role disimpan dalam array superglobal $_SESSION, lalu pengguna dialihkan ke halaman dashboard via header().
### d. dashboard.php & dashboard.css
 * **Fungsi:** Halaman utama tempat siswa melihat daftar kandidat dan jumlah perolehan suara sementara.
 * **Analisis Kode:** Menggunakan perulangan while(mysqli_fetch_array(...)) untuk menampilkan semua baris data dari tabel postingan (foto, keterangan visi-misi, dan jumlah vote). File ini juga memiliki logika kondisional: tombol "Hapus" hanya akan dirender di browser jika $_SESSION['role'] == 'admin'.
### e. vote.php
 * **Fungsi:** Memproses pemberian suara dan mencegah kecurangan pemilih ganda.
 * **Analisis Kode:** Sistem membaca IP Address pengguna ($_SERVER['REMOTE_ADDR']) dan mengeceknya di tabel riwayat_vote. Jika IP tersebut sudah ada, voting ditolak lewat alert JavaScript. Jika belum pernah memilih, sistem menjalankan query UPDATE postingan SET vote = vote + 1 dan mencatat IP tersebut agar tidak bisa memilih lagi.
### f. hapus.php
 * **Fungsi:** Fitur khusus admin untuk menghapus kandidat dari daftar.
 * **Analisis Kode:** Memiliki proteksi awal if($_SESSION['role'] != 'admin') { die(...); }. Selain menghapus data di database lewat query DELETE, file ini juga menggunakan fungsi unlink() untuk menghapus file gambar fisik dari folder uploads/ di server agar penyimpanan tidak penuh.
### g. upload.php
 * **Fungsi:** Mengunggah foto kandidat dan menyimpan deskripsi visi-misi mereka.
 * **Analisis Kode:** Menggunakan enkapsulasi form enctype="multipart/form-data" agar dapat memproses file. Fungsi move_uploaded_file() bertugas memindahkan foto dari direktori sementara server ke folder tujuan (uploads/).
## 4. Fitur yang Tersedia pada Proyek
 * **Sistem Autentikasi (Login Multi-role):** Memisahkan hak akses antara Akun Admin (farhan ganteng) dan Akun User/Siswa (siswa siswi).
 * **Manajemen Kandidat Dinamis:** Admin dapat mengunggah gambar kandidat beserta visi misinya, serta menghapus kandidat yang tidak lagi dicalonkan.
 * **Sistem Pemungutan Suara (Voting System):** Siswa dapat memberikan suaranya ke kandidat pilihan hanya dengan satu klik tombol.
 * **Proteksi Double-Vote Berbasis IP:** Membaca alamat IP (::1 untuk localhost atau IP lokal jaringan) guna membatasi agar satu perangkat komputer/HP hanya bisa memberikan satu kali suara secara keseluruhan.
 * **Penghitungan Suara Real-time:** Jumlah vote langsung diakumulasikan di database dan ditampilkan di dashboard saat itu juga.
## 5. Bahasa Pemrograman & Teknologi yang Digunakan
 * **PHP (Hypertext Preprocessor):** Digunakan sebagai bahasa pemrograman utama di sisi server (*back-end*) untuk logika bisnis, manajemen sesi, dan pengolahan form.
 * **HTML5 & CSS3:** Digunakan untuk menyusun struktur dokumen web dan merancang desain tampilan visual agar responsif.
 * **SQL (Structured Query Language):** Digunakan untuk berinteraksi dengan sistem manajemen database (RDBMS) MySQL/MariaDB dalam menyimpan data user, kandidat, dan log voting.
## 6. Kekurangan Sistem Saat Ini (Celah Keamanan & Bug)
Meskipun sistem ini sudah berjalan dengan baik untuk fungsi dasarnya, terdapat beberapa kekurangan krusial:
 * **Keamanan Login Sangat Lemah (SQL Injection):** File proseslog.php memasukkan variabel $username langsung ke dalam query SQL tanpa sanitasi atau *prepared statements*. Ini membuat sistem sangat mudah dibobol hacker menggunakan teknik SQL Injection. Selain itu, password di database masih berupa teks polos (*plain text*), belum di-hash (misal menggunakan password_hash()).
 * **Proteksi Vote Kurang Akurat:** Validasi berbasis IP Address (REMOTE_ADDR) kurang efektif jika diimplementasikan di laboratorium sekolah. Di laboratorium, biasanya banyak komputer menggunakan satu IP Publik/Gateway yang sama (NAT). Akibatnya, jika satu siswa sudah memilih, siswa lain di komputer berbeda dalam ruangan tersebut tidak akan bisa memilih karena IP-nya dianggap sama.
 * **Halaman dashboard.php Tidak Memiliki Proteksi Sesi:** Pengguna luar bisa langsung membuka halaman dashboard.php secara ilegal lewat URL tanpa login terlebih dahulu, karena tidak ada pengecekan isset($_SESSION['username']) di baris paling atas kode.
 * **Validasi File Upload Lemah:** File upload.php tidak menyaring ekstensi file. Seseorang bisa saja mengunggah file berbahaya (seperti file .php berisi malware) berkedok foto kandidat.
## 7. Saran Pengembangan ke Depan (Modernisasi Proyek)
Untuk meningkatkan keamanan dan fungsionalitas, proyek ini dapat dikembangkan lebih lanjut dengan poin-poin berikut:
 * **Implementasi Keamanan:** Mengubah semua query SQL menjadi *Prepared Statements* menggunakan ekstensi PDO atau MySQLi yang aman untuk mencegah SQL Injection, serta menerapkan password_hash() saat menyimpan password user.
 * **Validasi Pemilih Menggunakan Akun (Bukan IP):** Mengubah relasi tabel riwayat_vote agar tidak mencatat IP address, melainkan mencatat user_id dari tabel users. Tambahkan kolom status_memilih (0 atau 1) di tabel users untuk memastikan satu akun hanya bisa memilih sekali, terlepas dari komputer mana pun ia login.
 * **Pemisahan Halaman Admin (Back-Office):** Membuat folder atau halaman khusus untuk admin (seperti admin_dashboard.php), sehingga halaman utama siswa bersih dari elemen-elemen tombol hapus atau manajemen unggahan.
 * **Visualisasi Grafik Hasil (Chart):** Menambahkan library JavaScript seperti *Chart.js* pada halaman admin untuk menampilkan hasil persentase pemungutan suara dalam bentuk diagram lingkaran (*pie chart*) atau diagram batang yang menarik dan mudah dibaca saat pemilu selesai.
## Kesimpulan
Proyek E-Voting SMK PUSDIKHUBAD CIMAHI ini merupakan sebuah aplikasi berbasis web (PHP/MySQL) yang **fungsional dan sangat baik untuk diimplementasikan pada skala lokal atau simulasi pembelajaran**. Sistem ini telah berhasil memetakan kebutuhan dasar proses pemilu (adanya panitia/admin, adanya pemilih/user, dan rekapitulasi suara). Namun, untuk dapat diimplementasikan secara resmi pada pemilihan nyata yang melibatkan banyak siswa, aplikasi ini wajib diperbaiki terlebih dahulu dari sisi **keamanan autentikasi** dan **mekanisme pelacakan hak suara** agar asas pemilu yang jujur, adil, dan rahasia dapat terpenuhi seutuhnya.

