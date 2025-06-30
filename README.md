# Sistem Peminjaman Barang

Sistem manajemen peminjaman barang dengan PHP dan MySQL.

## Persyaratan Sistem

- PHP 7.4 atau lebih tinggi
- MySQL 5.7 atau lebih tinggi
- Web Server (Apache/Nginx)

## Cara Instalasi

1. Clone atau download repository ini
2. Buat database MySQL baru
3. Import file `db_peminjaman.sql` ke database yang telah dibuat
4. Konfigurasi database di `includes/config.php`:
   ```php
   $host = 'localhost';
   $user = 'root';     // Sesuaikan dengan username MySQL Anda
   $pass = '';         // Sesuaikan dengan password MySQL Anda
   $db = 'db_peminjaman';
   ```
7. Akses aplikasi melalui browser `localhost`

## Akun Default

1. Admin:
   - Username: admin
   - Password: admin123

2. User:
   - Username: user
   - Password: user123

## Fitur

1. Admin:
   - Manajemen barang (CRUD)
   - Manajemen kategori
   - Approval peminjaman
   - Laporan peminjaman (dengan export Excel)

2. User:
   - Lihat daftar barang
   - Ajukan peminjaman
   - Lihat riwayat peminjaman
