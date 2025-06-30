<?php
require_once '../../includes/config.php';
require_once '../../includes/functions.php';
checkLogin();
?>
<!DOCTYPE html>
<html>
<head>
    <title>User - Sistem Peminjaman Barang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../assets/css/style.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="sidebar">
        <div class="sidebar-header">
            <h3><i class="fas fa-boxes me-2"></i>User Panel</h3>
        </div>
        <div class="nav flex-column">
            <a class="nav-link" href="list-barang.php"><i class="fas fa-box"></i> Daftar Barang</a>
            <a class="nav-link" href="riwayat.php"><i class="fas fa-history"></i> Riwayat</a>
            <a class="nav-link" href="../../logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>
    </div>
    <div class="main-content">
        <div class="container-fluid">
