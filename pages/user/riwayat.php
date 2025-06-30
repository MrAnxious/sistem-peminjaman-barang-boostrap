<?php include '../templates/user_header.php'; ?>

<div class="card">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0"><i class="fas fa-history me-2"></i>Riwayat Peminjaman</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Barang</th>
                        <th>Jumlah</th>
                        <th>Tanggal Pinjam</th>
                        <th>Tanggal Kembali</th>
                        <th>Alasan</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $user_id = $_SESSION['user_id'];
                    $peminjaman = mysqli_query($conn, "SELECT p.*, b.nama as nama_barang, dp.jumlah 
                                                      FROM peminjaman p 
                                                      JOIN detail_peminjaman dp ON p.id = dp.peminjaman_id
                                                      JOIN barang b ON dp.barang_id = b.id
                                                      WHERE p.user_id = $user_id
                                                      ORDER BY p.tanggal_pinjam DESC");
                    
                    $no = 1;
                    while($row = mysqli_fetch_assoc($peminjaman)):
                    ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $row['nama_barang'] ?></td>
                        <td><?= $row['jumlah'] ?></td>
                        <td><?= date('d/m/Y', strtotime($row['tanggal_pinjam'])) ?></td>
                        <td><?= date('d/m/Y', strtotime($row['tanggal_kembali'])) ?></td>
                        <td><?= $row['alasan'] ?></td>
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
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include '../templates/user_footer.php'; ?>
