<?php
include '../../config/auth.php';
include '../../config/database.php';
include '../../templates/header.php';

$id = $_GET['id'];

// ambil data pelanggan
$data = $conn->query("SELECT * FROM pelanggan WHERE id=$id")->fetch_assoc();

// proses update
if(isset($_POST['update'])){
    $conn->query("UPDATE pelanggan SET 
        nama='$_POST[nama]',
        no_hp='$_POST[hp]',
        alamat='$_POST[alamat]'
        WHERE id=$id
    ");

header("Location: index.php?page=pelanggan&status=update");
exit;
}
?>

<div class="card shadow">
<div class="card-body">

<h4 class="mb-3">
    <i class="bi bi-pencil-square"></i> Edit Pelanggan
</h4>

<form method="post">

<div class="mb-3">
    <label class="form-label">Nama Pelanggan</label>
    <input type="text" name="nama" class="form-control"
           value="<?= $data['nama'] ?>" required>
</div>

<div class="mb-3">
    <label class="form-label">No HP</label>
    <input type="text" name="hp" class="form-control"
           value="<?= $data['no_hp'] ?>" required>
</div>

<div class="mb-3">
    <label class="form-label">Alamat</label>
    <textarea name="alamat" class="form-control" rows="3"><?= $data['alamat'] ?></textarea>
</div>

<div class="d-flex gap-2">
    <button name="update" class="btn btn-success">
        <i class="bi bi-save"></i> Update
    </button>

    <a href="index.php" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

</form>

</div>
</div>

<?php include '../../templates/footer.php'; ?>