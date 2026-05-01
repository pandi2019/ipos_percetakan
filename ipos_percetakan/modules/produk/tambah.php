<?php
include '../../config/auth.php';
include '../../config/database.php';
include '../../templates/header.php';

if(isset($_POST['simpan'])){
$nama = $_POST['nama'];
$harga = str_replace(['Rp', '.', ' '], '', $_POST['harga']);
$tipe = $_POST['tipe'];

$conn->query("INSERT INTO produk (nama_produk, harga, tipe)
VALUES ('$_POST[nama]', '$harga', '$tipe')");
    header("Location: index.php?page=produk&status=sukses");
    exit;
}
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container mt-5">
<div class="card shadow">
<div class="card-body">

<h4 class="mb-3">
<i class="bi bi-box"></i> Tambah Produk
</h4>

<form method="post">
<div class="mb-3">
    <label>Nama Produk</label>
    <input type="text" name="nama" class="form-control">
</div>

<div class="mb-3">
    <label class="form-label">Harga</label>
    <input type="text" id="harga" name="harga" class="form-control" placeholder="Rp 0" required>
</div>

<div class="mb-3">
    <label class="form-label">Tipe Produk</label>
    <select name="tipe" class="form-select" required>
        <option value="">-- Pilih Tipe --</option>
        <option value="ukuran">Ukuran (Tinggi x Lebar)</option>
        <option value="qty">Qty (Jumlah)</option>
    </select>
</div>

<button class="btn btn-success" name="simpan">Simpan</button>
<a href="index.php" class="btn btn-secondary">Kembali</a>
</form>

</div>
</div>
</div>
<script>
const harga = document.getElementById('harga');

harga.addEventListener('keyup', function(e){
    let angka = this.value.replace(/[^,\d]/g, '').toString();
    let split = angka.split(',');
    let sisa = split[0].length % 3;
    let rupiah = split[0].substr(0, sisa);
    let ribuan = split[0].substr(sisa).match(/\d{3}/gi);

    if(ribuan){
        let separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
    }

    this.value = 'Rp ' + rupiah;
});
</script>
<?php include '../../templates/footer.php'; ?>