<?php
require_once 'includes/config.php';

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = md5($_POST['password']);
    
    $query = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($conn, $query);
    
    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        
        if ($user['role'] == 'admin') {
            header("Location: pages/admin/barang.php");
        } else {
            header("Location: pages/user/list-barang.php");
        }
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login - Sistem Peminjaman Barang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(120deg, #2980b9, #8e44ad);
            height: 100vh;
        }
        .card {
            border: 0;
            border-radius: 1rem;
            box-shadow: 0 0.5rem 1rem 0 rgba(0, 0, 0, 0.1);
        }
        .card-body {
            padding: 2rem;
        }
        .form-control {
            border-radius: 2rem;
            padding: 0.75rem 1.5rem;
        }
        .btn-primary {
            border-radius: 2rem;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            background: linear-gradient(120deg, #2980b9, #8e44ad);
            border: none;
        }
        .btn-primary:hover {
            background: linear-gradient(120deg, #3498db, #9b59b6);
            transform: translateY(-2px);
            box-shadow: 0 7px 14px rgba(50, 50, 93, 0.1), 0 3px 6px rgba(0, 0, 0, 0.08);
        }
        .logo-container {
            text-align: center;
            margin-bottom: 2rem;
        }
        .logo-icon {
            font-size: 4rem;
            background: linear-gradient(120deg, #2980b9, #8e44ad);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>
</head>
<body class="d-flex align-items-center">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <div class="logo-container">
                            <i class="fas fa-boxes logo-icon"></i>
                            <h3 class="mt-3 mb-4">Login</h3>
                        </div>
                        <?php if(isset($_POST['login']) && mysqli_num_rows($result) == 0): ?>
                            <div class="alert alert-danger text-center">
                                Username atau password salah!
                            </div>
                        <?php endif; ?>
                        <form method="POST">
                            <div class="mb-4">
                                <div class="input-group">
                                    <span class="input-group-text bg-transparent border-end-0">
                                        <i class="fas fa-user text-muted"></i>
                                    </span>
                                    <input type="text" name="username" class="form-control border-start-0" 
                                           placeholder="Username" required>
                                </div>
                            </div>
                            <div class="mb-4">
                                <div class="input-group">
                                    <span class="input-group-text bg-transparent border-end-0">
                                        <i class="fas fa-lock text-muted"></i>
                                    </span>
                                    <input type="password" name="password" class="form-control border-start-0" 
                                           placeholder="Password" required>
                                </div>
                            </div>
                            <button type="submit" name="login" class="btn btn-primary w-100 mb-3">
                                Login
                            </button>
                            <div class="text-center">
                                <a href="register.php" class="text-decoration-none">
                                    <i class="fas fa-user-plus me-1"></i>Belum punya akun? Register
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer class="fixed-bottom text-center p-3 text-white">
        <small>&copy; <?= date('Y') ?> Made with ❤️</small>
    </footer>
</body>
</html>
