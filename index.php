<?php
require_once 'includes/config.php';

// Jika sudah login, redirect sesuai role
if (isset($_SESSION['user_id'])) {
    if ($_SESSION['role'] == 'admin') {
        header("Location: pages/admin/barang.php");
    } else {
        header("Location: pages/user/list-barang.php");
    }
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Sistem Peminjaman Barang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="hero">
        <div class="container text-center">
            <i class="fas fa-boxes fa-5x mb-4 text-white"></i>
            <h1 class="display-4 mb-4 fw-bold">Sistem Peminjaman Barang</h1>
            <p class="lead mb-5">Sistem manajemen peminjaman barang yang mudah dan efisien</p>
            <div>
                <a href="login.php" class="btn btn-primary btn-lg mx-2">
                    <i class="fas fa-sign-in-alt me-2"></i>Login
                </a>
                <a href="register.php" class="btn btn-outline-light btn-lg mx-2">
                    <i class="fas fa-user-plus me-2"></i>Register
                </a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
