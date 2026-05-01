<?php
include '../../config/auth.php';
include '../../config/database.php';
include '../../templates/header.php';

if(isset($_POST['simpan'])){
    $conn->query("INSERT INTO pelanggan 
    VALUES(NULL,'$_POST[nama]','$_POST[hp]','$_POST[alamat]')");
    
    header("Location: index.php?page=pelanggan&status=sukses");
exit;
}
?>

<div class="card shadow-lg rounded-4">
<div class="card-body">

<h4 class="mb-3">
    <i class="bi bi-person-plus"></i> Tambah Pelanggan
</h4>

<form method="post">

<div class="mb-3">
    <label class="form-label">Nama Pelanggan</label>
    <input type="text" name="nama" class="form-control" placeholder="Masukkan nama" required>
</div>

<div class="mb-3">
    <label class="form-label">No HP</label>
    <input type="text" name="hp" class="form-control" placeholder="08xxxxxxxxxx" required>
</div>

<div class="mb-3">
    <label class="form-label">Alamat</label>
    <textarea name="alamat" class="form-control" rows="3" placeholder="Alamat lengkap"></textarea>
</div>

<div class="d-flex gap-2">
    <button name="simpan" class="btn btn-success">
        <i class="bi bi-save"></i> Simpan
    </button>

    <a href="index.php" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

</form>

</div>
</div>

<?php include '../../templates/footer.php'; ?>