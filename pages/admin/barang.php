<?php include '../templates/admin_header.php'; ?>

<head>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../../assets/js/script.js"></script>
</head>

<?php
if (isset($_POST['tambah'])) {
    $nama = $_POST['nama'];
    $kategori = $_POST['kategori'];
    $deskripsi = $_POST['deskripsi'];
    $stok = $_POST['stok'];
    
    $foto = '';
    if(isset($_FILES['foto'])) {
        $foto = uploadFoto($_FILES['foto']);
    }
    
    $query = "INSERT INTO barang (nama, kategori_id, deskripsi, stok, foto) 
              VALUES ('$nama', $kategori, '$deskripsi', $stok, '$foto')";
    mysqli_query($conn, $query);
}

if (isset($_POST['edit'])) {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $kategori = $_POST['kategori'];
    $deskripsi = $_POST['deskripsi'];
    $stok = $_POST['stok'];
    
    $query = "UPDATE barang SET nama='$nama', kategori_id=$kategori, 
              deskripsi='$deskripsi', stok=$stok WHERE id=$id";
    
    if(isset($_FILES['foto']) && $_FILES['foto']['name']) {
        $foto = uploadFoto($_FILES['foto']);
        $query = "UPDATE barang SET nama='$nama', kategori_id=$kategori, 
                  deskripsi='$deskripsi', stok=$stok, foto='$foto' WHERE id=$id";
    }
    
    mysqli_query($conn, $query);
}

if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($conn, "DELETE FROM barang WHERE id = $id");
}

$barang = mysqli_query($conn, "SELECT b.*, k.nama as kategori FROM barang b 
                              LEFT JOIN kategori_barang k ON b.kategori_id = k.id");
$kategori = mysqli_query($conn, "SELECT * FROM kategori_barang");
?>

<h2>Data Barang</h2>
<button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalTambah">
    Tambah Barang
</button>

<table class="table">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Kategori</th>
            <th>Stok</th>
            <th>Foto</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php $no = 1; while($row = mysqli_fetch_assoc($barang)): ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= $row['nama'] ?></td>
            <td><?= $row['kategori'] ?></td>
            <td><?= $row['stok'] ?></td>
            <td>
                <?php if($row['foto']): ?>
                    <img src="/JOKIAN/Jokian_Adek_tingkat/assets/uploads/<?= $row['foto'] ?>" width="50">
                <?php endif; ?>
            </td>
            <td>
                <button class="btn btn-warning btn-sm" data-bs-toggle="modal" 
                        data-bs-target="#modalEdit<?= $row['id'] ?>">Edit</button>
                <a href="?hapus=<?= $row['id'] ?>" class="btn btn-danger btn-sm" 
                   onclick="return confirmDelete(this.href)">Hapus</a>
            </td>
        </tr>

        <!-- Modal Edit -->
        <div class="modal fade" id="modalEdit<?= $row['id'] ?>">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Barang</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="<?= $row['id'] ?>">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label>Nama Barang</label>
                                <input type="text" name="nama" class="form-control" 
                                       value="<?= $row['nama'] ?>" required>
                            </div>
                            <div class="mb-3">
                                <label>Kategori</label>
                                <select name="kategori" class="form-control" required>
                                    <?php while($kat = mysqli_fetch_assoc($kategori)): ?>
                                        <option value="<?= $kat['id'] ?>" <?= $kat['id'] == $row['kategori_id'] ? 'selected' : '' ?>>
                                            <?= $kat['nama'] ?>
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label>Deskripsi</label>
                                <textarea name="deskripsi" class="form-control"><?= $row['deskripsi'] ?></textarea>
                            </div>
                            <div class="mb-3">
                                <label>Stok</label>
                                <input type="number" name="stok" class="form-control" value="<?= $row['stok'] ?>" required>
                            </div>
                            <div class="mb-3">
                                <label>Foto</label>
                                <input type="file" name="foto" class="form-control" onchange="previewImage(this)">
                                <img id="preview" src="" style="display:none; max-width: 200px; margin-top: 10px;">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" name="edit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <?php endwhile; ?>
    </tbody>
</table>

<!-- Modal Tambah -->
<div class="modal fade" id="modalTambah">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Barang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Nama Barang</label>
                        <input type="text" name="nama" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Kategori</label>
                        <select name="kategori" class="form-control" required>
                            <?php while($kat = mysqli_fetch_assoc($kategori)): ?>
                                <option value="<?= $kat['id'] ?>"><?= $kat['nama'] ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Deskripsi</label>
                        <textarea name="deskripsi" class="form-control"></textarea>
                    </div>
                    <div class="mb-3">
                        <label>Stok</label>
                        <input type="number" name="stok" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Foto</label>
                        <input type="file" name="foto" class="form-control" onchange="previewImage(this)">
                        <img id="preview" src="" style="display:none; max-width: 200px; margin-top: 10px;">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" name="tambah" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include '../templates/admin_footer.php'; ?>
