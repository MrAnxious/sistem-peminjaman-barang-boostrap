<?php include '../templates/admin_header.php'; ?>

<?php
if (isset($_GET['setuju'])) {
    $id = $_GET['setuju'];
    mysqli_query($conn, "UPDATE peminjaman SET status = 'disetujui' WHERE id = $id");
}

if (isset($_GET['tolak'])) {
    $id = $_GET['tolak'];
    mysqli_query($conn, "UPDATE peminjaman SET status = 'ditolak' WHERE id = $id");
}

if (isset($_GET['kembali'])) {
    $id = $_GET['kembali'];
    
    // Ambil detail peminjaman
    $detail = mysqli_fetch_assoc(mysqli_query($conn, 
        "SELECT * FROM detail_peminjaman WHERE peminjaman_id = $id"));
    
    // Update stok barang
    mysqli_query($conn, 
        "UPDATE barang SET stok = stok + {$detail['jumlah']} 
         WHERE id = {$detail['barang_id']}");
    
    // Update status peminjaman
    mysqli_query($conn, 
        "UPDATE peminjaman SET status = 'dikembalikan' WHERE id = $id");
}

$peminjaman = mysqli_query($conn, "SELECT p.*, u.nama_lengkap, b.nama as barang, dp.jumlah 
                                  FROM peminjaman p 
                                  LEFT JOIN users u ON p.user_id = u.id 
                                  LEFT JOIN detail_peminjaman dp ON p.id = dp.peminjaman_id
                                  LEFT JOIN barang b ON dp.barang_id = b.id
                                  ORDER BY p.tanggal_pinjam DESC");
?>

<h2>Data Peminjaman</h2>
<table class="table">
    <thead>
        <tr>
            <th>No</th>
            <th>Peminjam</th>
            <th>Barang</th>
            <th>Jumlah</th>
            <th>Tanggal Pinjam</th>
            <th>Tanggal Kembali</th>
            <th>Alasan</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php $no = 1; while($row = mysqli_fetch_assoc($peminjaman)): ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= $row['nama_lengkap'] ?></td>
            <td><?= $row['barang'] ?></td>
            <td><?= $row['jumlah'] ?></td>
            <td><?= $row['tanggal_pinjam'] ?></td>
            <td><?= $row['tanggal_kembali'] ?></td>
            <td><?= $row['alasan'] ?></td>
            <td><?= $row['status'] ?></td>
            <td>
                <?php 
                if($row['status'] == 'pending') {
                    echo '<a href="?setuju='.$row['id'].'" class="btn btn-success btn-sm">Setuju</a>
                          <a href="?tolak='.$row['id'].'" class="btn btn-danger btn-sm">Tolak</a>';
                } else if($row['status'] == 'disetujui') {
                    echo '<a href="?kembali='.$row['id'].'" class="btn btn-info btn-sm">Kembalikan</a>';
                }
                ?>
            </td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<?php include '../templates/admin_footer.php'; ?>
