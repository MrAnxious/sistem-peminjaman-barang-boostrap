<?php
require_once '../../includes/config.php';
require_once '../../includes/functions.php';
checkLogin();

if (!isset($_GET['id'])) {
    header("Location: list-barang.php");
    exit();
}

$barang_id = $_GET['id'];
$barang = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM barang WHERE id = $barang_id"));

if (isset($_POST['pinjam'])) {
    $user_id = $_SESSION['user_id'];
    $tanggal_pinjam = $_POST['tanggal_pinjam'];
    $tanggal_kembali = $_POST['tanggal_kembali'];
    $jumlah = $_POST['jumlah'];
    $alasan = $_POST['alasan'];
    
    // Validasi stok
    if ($jumlah <= $barang['stok']) {
        mysqli_query($conn, "INSERT INTO peminjaman (user_id, tanggal_pinjam, tanggal_kembali, status, alasan) 
                            VALUES ($user_id, '$tanggal_pinjam', '$tanggal_kembali', 'pending', '$alasan')");
        $peminjaman_id = mysqli_insert_id($conn);
        
        mysqli_query($conn, "INSERT INTO detail_peminjaman (peminjaman_id, barang_id, jumlah) 
                            VALUES ($peminjaman_id, $barang_id, $jumlah)");
        
        // Kurangi stok
        mysqli_query($conn, "UPDATE barang SET stok = stok - $jumlah WHERE id = $barang_id");
        
        header("Location: riwayat.php");
        exit();
    } else {
        $error = "Jumlah melebihi stok yang tersedia!";
    }
}

include '../templates/user_header.php';
?>

<div class="card">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0"><i class="fas fa-hand-holding me-2"></i>Form Peminjaman</h5>
    </div>
    <div class="card-body">
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>
        <form method="POST" onsubmit="return validatePinjam(this)">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label>Tanggal Pinjam</label>
                        <input type="date" name="tanggal_pinjam" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Tanggal Kembali</label>
                        <input type="date" name="tanggal_kembali" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Jumlah</label>
                        <input type="number" name="jumlah" class="form-control" 
                               max="<?= $barang['stok'] ?>" required>
                        <small class="text-muted">Stok tersedia: <?= $barang['stok'] ?></small>
                    </div>
                    <div class="mb-3">
                        <label>Alasan Peminjaman</label>
                        <textarea name="alasan" class="form-control" rows="3" required 
                                  placeholder="Jelaskan alasan peminjaman barang"></textarea>
                    </div>
                    <button type="submit" name="pinjam" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i>Pinjam
                    </button>
                    <a href="list-barang.php" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i>Kembali
                    </a>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Detail Barang</h5>
                            <hr>
                            <?php if($barang['foto']): ?>
                                <img src="/JOKIAN/Jokian_Adek_tingkat/assets/uploads/<?= $barang['foto'] ?>" 
                                     class="img-fluid mb-3 rounded">
                            <?php endif; ?>
                            <h6><?= $barang['nama'] ?></h6>
                            <p class="text-muted"><?= $barang['deskripsi'] ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<?php include '../templates/user_footer.php'; ?>
