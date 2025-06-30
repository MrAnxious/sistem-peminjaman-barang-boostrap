-- Hapus database jika sudah ada
DROP DATABASE IF EXISTS db_peminjaman;
CREATE DATABASE db_peminjaman;
USE db_peminjaman;

-- Buat tabel users
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE,
    password VARCHAR(32),
    role ENUM('admin', 'user'),
    nama_lengkap VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Buat tabel kategori_barang
CREATE TABLE kategori_barang (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nama VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Buat tabel barang
CREATE TABLE barang (
    id INT PRIMARY KEY AUTO_INCREMENT,
    kategori_id INT,
    nama VARCHAR(100),
    deskripsi TEXT,
    stok INT,
    foto VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (kategori_id) REFERENCES kategori_barang(id)
);

-- Buat tabel peminjaman
CREATE TABLE peminjaman (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    tanggal_pinjam DATE,
    tanggal_kembali DATE,
    status ENUM('pending', 'disetujui', 'ditolak', 'dikembalikan'),
    alasan TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Buat tabel detail_peminjaman
CREATE TABLE detail_peminjaman (
    id INT PRIMARY KEY AUTO_INCREMENT,
    peminjaman_id INT,
    barang_id INT,
    jumlah INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (peminjaman_id) REFERENCES peminjaman(id),
    FOREIGN KEY (barang_id) REFERENCES barang(id)
);

-- Insert default admin dan user
INSERT INTO users (username, password, role, nama_lengkap) VALUES
('admin', MD5('admin123'), 'admin', 'Administrator'),
('user', MD5('user123'), 'user', 'Regular User');
