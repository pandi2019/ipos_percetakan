<?php
include '../../config/auth.php';
include '../../config/database.php';
include '../../templates/header.php';

$id = $_GET['id'];
$data = $conn->query("SELECT * FROM produk WHERE id=$id")->fetch_assoc();

if(isset($_POST['update'])){
    $conn->query("UPDATE produk SET 
nama_produk='$_POST[nama]',
harga='$_POST[harga]',
tipe='$_POST[tipe]'
WHERE id=$id");

header("Location: index.php?page=produk&status=update");
exit;
}
?>

<div class="card shadow-lg rounded-4">
<div class="card-body">

<h4><i class="bi bi-pencil-square"></i> Edit Produk</h4>

<form method="post">

<div class="mb-3">
    <label class="form-label">Nama Produk</label>
    <input type="text" name="nama" 
           class="form-control" 
           value="<?= $data['nama_produk'] ?>" required>
</div>

<div class="mb-3">
    <label class="form-label">Harga</label>
    <input type="number" name="harga" 
           class="form-control" 
           value="<?= $data['harga'] ?>" required>
</div>

<div class="mb-3">
    <label class="form-label">Tipe Produk</label>
    <select name="tipe" class="form-select">

        <option value="ukuran" <?= $data['tipe']=='ukuran'?'selected':'' ?>>
            Ukuran
        </option>

        <option value="qty" <?= $data['tipe']=='qty'?'selected':'' ?>>
            Qty
        </option>

    </select>
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