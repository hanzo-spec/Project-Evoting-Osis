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
 5. **style.css** mengatur tampilan halaman login, sedangkan **dashboard.css** mengatur tampilan halaman utama pemilihan(dashboard.php).
## 3. Penjelasan Beberapa Kode dari Masing-Masing File
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
## 5. Bahasa Pemrograman yang Digunakan
 * **PHP (Hypertext Preprocessor)**
 * **HTML**
 * **CSS**
 * **SQL (Structured Query Language)**

