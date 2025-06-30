<?php include '../templates/admin_header.php'; ?>

<div class="card">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0"><i class="fas fa-file-alt me-2"></i>Laporan Peminjaman</h5>
    </div>
    <div class="card-body">
        <div class="mb-3">
            <form method="GET" class="row g-3">
                <div class="col-auto">
                    <input type="date" name="dari" class="form-control" value="<?= $_GET['dari'] ?? '' ?>">
                </div>
                <div class="col-auto">
                    <input type="date" name="sampai" class="form-control" value="<?= $_GET['sampai'] ?? '' ?>">
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-filter me-1"></i>Filter
                    </button>
                    <a href="?export=1<?= isset($_GET['dari']) ? '&dari='.$_GET['dari'].'&sampai='.$_GET['sampai'] : '' ?>" 
                       class="btn btn-success">
                        <i class="fas fa-file-excel me-1"></i>Export Excel
                    </a>
                </div>
            </form>
        </div>

        <?php
        $where = "";
        if(isset($_GET['dari']) && isset($_GET['sampai'])) {
            $where = "WHERE p.tanggal_pinjam BETWEEN '{$_GET['dari']}' AND '{$_GET['sampai']}'";
        }

        $query = "SELECT p.*, u.nama_lengkap, b.nama as nama_barang, dp.jumlah 
                FROM peminjaman p 
                JOIN users u ON p.user_id = u.id
                JOIN detail_peminjaman dp ON p.id = dp.peminjaman_id
                JOIN barang b ON dp.barang_id = b.id
                $where
                ORDER BY p.tanggal_pinjam DESC";

        $peminjaman = mysqli_query($conn, $query);

        if(isset($_GET['export'])) {
            $data = [];
            if(mysqli_num_rows($peminjaman) > 0) {
                while($row = mysqli_fetch_assoc($peminjaman)) {
                    $data[] = $row;
                }
            }
            exportToExcel($data, 'laporan_peminjaman');
            exit;
        }
        ?>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Peminjam</th>
                        <th>Barang</th>
                        <th>Jumlah</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(mysqli_num_rows($peminjaman) > 0): ?>
                        <?php $no = 1; while($row = mysqli_fetch_assoc($peminjaman)): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= date('d/m/Y', strtotime($row['tanggal_pinjam'])) ?></td>
                            <td><?= $row['nama_lengkap'] ?></td>
                            <td><?= $row['nama_barang'] ?></td>
                            <td><?= $row['jumlah'] ?></td>
                            <td>
                                <?php
                                $status_class = '';
                                switch($row['status']) {
                                    case 'pending': $status_class = 'warning'; break;
                                    case 'disetujui': $status_class = 'success'; break;
                                    case 'ditolak': $status_class = 'danger'; break;
                                    case 'dikembalikan': $status_class = 'info'; break;
                                }
                                ?>
                                <span class="badge bg-<?= $status_class ?>"><?= $row['status'] ?></span>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center">Tidak ada data</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include '../templates/admin_footer.php'; ?>
