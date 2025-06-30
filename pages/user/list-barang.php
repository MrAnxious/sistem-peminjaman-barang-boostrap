<?php include '../templates/user_header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-box me-2"></i>Daftar Barang</h2>
    <div class="input-group" style="width: 300px;">
        <input type="text" class="form-control" id="searchInput" 
               placeholder="Cari barang..." onkeyup="searchItems()">
        <span class="input-group-text"><i class="fas fa-search"></i></span>
    </div>
</div>

<div class="row">
    <?php
    $barang = mysqli_query($conn, "SELECT * FROM barang WHERE stok > 0");
    while($row = mysqli_fetch_assoc($barang)):
    ?>
    <div class="col-md-4 mb-3 barang-card">
        <div class="card">
            <?php if($row['foto']): ?>
                <img src="/JOKIAN/Jokian_Adek_tingkat/assets/uploads/<?= $row['foto'] ?>" class="card-img-top">
            <?php endif; ?>
            <div class="card-body">
                <h5 class="card-title"><?= $row['nama'] ?></h5>
                <p class="card-text"><?= $row['deskripsi'] ?></p>
                <p>Stok: <?= $row['stok'] ?></p>
                <a href="pinjam.php?id=<?= $row['id'] ?>" class="btn btn-primary">
                    <i class="fas fa-hand-holding me-1"></i>Pinjam
                </a>
            </div>
        </div>
    </div>
    <?php endwhile; ?>
</div>

<?php include '../templates/user_footer.php'; ?>
