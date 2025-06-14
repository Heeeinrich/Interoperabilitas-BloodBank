# Sistem Pengelola Donor Darah

## Tentang Platform
Sistem Pengelola Donor Darah adalah platform berbasis website yang terintegrasi dengan katalog API untuk mendukung interoperabilitas antara rumah sakit dan sistem donor darah. Platform ini memungkinkan pengelolaan data pendonor, stok darah, dan permintaan darah secara real-time dan terpusat.

## Fitur Utama

- **Dashboard Stok Darah**: Melihat stok darah berdasarkan golongan dan jumlah unit tersedia.
- **Manajemen Pendonor**: Menampilkan dan menambah data pendonor darah.
- **Donasi Darah**: Menampilkan, menambah, serta mengedit aktivitas donor darah.
- **Permintaan Darah**: Melihat dan merespons permintaan darah dari sistem rumah sakit.
- **Distribusi (Handed Over)**: Melihat daftar darah yang telah disalurkan ke rumah sakit.
- **Otentikasi Pengguna**: Sistem login dan registrasi untuk akses pengguna.

## Teknologi yang Digunakan

- **Bahasa Pemrograman**: PHP, JavaScript  
- **Framework & Library**: Bootstrap v4.3.1, jQuery  
- **Desain Antarmuka**: Figma  
- **Tools**: Visual Studio Code, GitHub  

## Penggunaan

### Mendaftar dan Login
1. Buka halaman utama sistem.
2. Klik **"Register"** untuk membuat akun baru jika belum memiliki.
3. Login menggunakan akun yang telah terdaftar.

### Dashboard
1. Setelah login, pengguna diarahkan ke halaman **Home**.
2. Halaman ini menampilkan ringkasan stok darah, total pendonor, serta permintaan darah terbaru.

### Manajemen Pendonor
1. Masuk ke menu **Donors**.
2. Melihat daftar pendonor dan detail riwayat donor.
3. Klik **"Tambah Donor"** untuk menambahkan data baru.

### Manajemen Stok Darah
- **Melihat**: Masuk ke menu **Blood Donatiosn** untuk melihat data stok darah.
- **Menambahkan**: Klik **"New Entry"**, isi data, lalu simpan.
- **Mengedit**: Klik tombol **"Edit"**, ubah data, dan simpan.
- **Menghapus**: Klik **"Delete"**, lalu konfirmasi penghapusan.

### Permintaan Darah dari Rumah Sakit
- **Melihat**: Masuk ke menu **Request**, lalu lihat daftar permintaan masuk.
- **Menyetujui**: Klik **"Setujui"**, lalu permintaan darah akan berpindah ke **Handed Over**.
- **Menolak**: Klik **"Tolak"**, lalu konfirmasi penolakan.

### Distribusi Darah (Handed Over)
1. Masuk ke menu **Handed Over**.
2. Lihat daftar darah yang telah disalurkan ke rumah sakit, termasuk status apakah darah sudah diterima oleh pihak rumah sakit.

## Rencana Pengembangan

- Integrasi notifikasi email untuk status permintaan darah
- Sistem reminder untuk donor berkala
- Statistik visualisasi donor per wilayah
- Dashboard admin untuk monitoring lintas rumah sakit
- Penjadwalan distribusi darah otomatis

## Kontribusi

Kontribusi terbuka untuk pengembangan proyek ini. Langkah-langkah:

1. Fork repositori
2. Buat branch (`git checkout -b fitur-xyz`)
3. Commit perubahan (`git commit -m 'Menambahkan fitur xyz'`)
4. Push ke branch (`git push origin fitur-xyz`)
5. Ajukan Pull Request

## Lisensi

Sistem ini dilisensikan di bawah [MIT License](LICENSE).

## Kontak

Teknologi Rekayasa Perangkat Lunak,  
Sekolah Vokasi,    
Universitas Gadjah Mada
