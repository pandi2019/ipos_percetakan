<?php
include '../../config/auth.php';
include '../../config/database.php';
include '../../templates/header.php';

if(isset($_POST['simpan'])){

    // upload
    $file = $_FILES['file']['name'];
    move_uploaded_file($_FILES['file']['tmp_name'], __DIR__ . "/../../uploads/" . $file);

    $produk = $_POST['produk'];
    
    // ambil produk
    $p = $conn->query("SELECT * FROM produk WHERE id=$produk")->fetch_assoc();
    $harga = (int)$p['harga'];
    
    
    
    // default
    $tinggi = isset($_POST['tinggi']) ? $_POST['tinggi'] : 0;
    $lebar   = isset($_POST['lebar']) ? $_POST['lebar'] : 0;
    $qty     = isset($_POST['qty']) ? $_POST['qty'] : 0;

    $tinggi = (float) str_replace(',', '.', $_POST['tinggi'] ?? 0);
    $lebar  = (float) str_replace(',', '.', $_POST['lebar'] ?? 0);
    $qty    = (int) ($_POST['qty'] ?? 1);

if($qty <= 0){
    $qty = 1;
}

if($p['tipe'] == 'qty'){

    $subtotal = $qty * $harga;
    $total = $subtotal;
    

}else{

$luas = $tinggi * $lebar;
$total = $luas * $qty * $harga;
$subtotal = $luas * $qty * $harga;
}

    // simpan transaksi
    $conn->query("INSERT INTO transaksi VALUES(NULL, $_POST[pelanggan], NOW(), '$total', '$file', 'proses')");
    
    $id_transaksi = $conn->insert_id;
    $conn->query("INSERT INTO transaksi_detail 
    (transaksi_id, produk_id, qty, lebar, tinggi, harga, subtotal) 
    VALUES 
    ('$id_transaksi','$produk','$qty','$lebar','$tinggi','$harga','$subtotal')");
    
    $conn->query("UPDATE transaksi SET total='$total' WHERE id=$id_transaksi");

    header("Location: index.php?page=transaksi&status=sukses");
    exit;
}

?>

<?php

if(isset($_GET['hapus'])){

$id = (int) $_GET['hapus'];

// hapus detail dulu
$conn->query("DELETE FROM transaksi_detail WHERE transaksi_id='$id'");

// hapus transaksi
$conn->query("DELETE FROM transaksi WHERE id='$id'");

echo "<script>
    alert('Transaksi berhasil dihapus');
    window.location.href = 'index.php?page=transaksi';
</script>";
exit;
}
?>


<?php if(isset($_GET['status']) && $_GET['status']=='sukses'){ ?>
<div class="alert alert-success">
    Data berhasil disimpan!
</div>

<?php } ?>

<h3><i class="bi bi-cash-coin"></i> Transaksi</h3>

<form method="post" enctype="multipart/form-data" class="card p-3 shadow">

<div class="row">
<div class="col-md-6 mb-3">
<label>Pelanggan</label>

<select name="pelanggan" class="form-control">
<?php
$p = $conn->query("SELECT * FROM pelanggan");
while($d=$p->fetch_assoc()){
echo "<option value='$d[id]'>$d[nama]</option>";
}
?>

</select>
</div>

<div class="col-md-6 mb-3">
<label>Produk</label>

<select name="produk" id="produk" class="form-select">
<option value="">-- Pilih Produk --</option>

<?php
$q = $conn->query("SELECT * FROM produk");
while($p=$q->fetch_assoc()){
?>
<option 
value="<?= $p['id'] ?>" 
data-tipe="<?= $p['tipe'] ?>">
<?= $p['nama_produk'] ?>
</option>
<?php } ?>
</select>
</div>
</div>

<div id="formUkuran">
    <label>Tinggi</label>
    <input type="number" step="0.01" name="tinggi" class="form-control">

    <label>Lebar</label>
    <input type="number" step="0.01" name="lebar" class="form-control mt-2">
</div>

<div id="formQty">
    <label>Jumlah</label>
    <input type="number" name="qty" class="form-control" value="1" min="1">
</div>

<div class="mb-3">
<label>Upload Desain</label>
<input type="file" name="file" class="form-control">
</div>

<button class="btn btn-primary" name="simpan">Proses</button>

</form>

<hr>

<div class="card shadow">
<div class="card-body">

<h4 class="mb-3"><i class="bi bi-chat-left-text-fill"></i> Riwayat Transaksi</h4>

<div class="table-responsive">
<table class="table table-bordered table-striped">

<thead class="table-dark">
<tr>
<th>No</th>
<th>Tanggal</th>
<th>Pelanggan</th>
<th>Total</th>
<th>Desain</th>
<th>Status</th>
<th>Ubah</th>
<th>Aksi</th>
</tr>
</thead>

<tbody>

<?php
$no=1;

$q = $conn->query("
SELECT t.*, p.nama 
FROM transaksi t 
JOIN pelanggan p ON t.pelanggan_id=p.id
ORDER BY t.id DESC
");

while($d=$q->fetch_assoc()){
?>

<tr>
<td><?= $no++ ?></td>
<td><?= date('d-m-Y', strtotime($d['tanggal'])) ?></td>
<td><?= $d['nama'] ?></td>
<td>Rp <?= number_format($d['total']) ?></td>
<td>
<a href="/ipos_percetakan/uploads/<?= $d['file_desain'] ?>" target="_blank" class="btn btn-info btn-sm">
    <i class="bi bi-image"></i> Lihat
</a>
</td>

<!-- STATUS -->
<td>
<?php
if($d['status']=='proses'){
    echo "<span class='badge bg-warning'>Proses</span>";
}elseif($d['status']=='selesai'){
    echo "<span class='badge bg-primary'>Selesai</span>";
}else{
    echo "<span class='badge bg-success'>Diambil</span>";
}
?>
</td>

<!-- UBAH STATUS -->
<td>
<form method="post" action="ubah_status.php">
<input type="hidden" name="id" value="<?= $d['id'] ?>">

<select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
<option value="proses" <?= $d['status']=='proses'?'selected':'' ?>>Proses</option>
<option value="selesai" <?= $d['status']=='selesai'?'selected':'' ?>>Selesai</option>
<option value="diambil" <?= $d['status']=='diambil'?'selected':'' ?>>Diambil</option>
</select>

<td>
    <a href="?page=transaksi&hapus=<?= $d['id'] ?>" 
       class="btn btn-danger btn-sm"
       onclick="return confirm('Hapus transaksi ini?')">
        <i class="bi bi-trash"></i> Hapus
    </a>
</td>

</form>
</td>

</tr>

<?php } ?>

</tbody>
</table>
</div>

</div>
</div>
<script>
document.addEventListener("DOMContentLoaded", function(){

    let produk = document.getElementById("produk");

    produk.addEventListener("change", function(){

        let selected = this.options[this.selectedIndex];

        // DEBUG
        console.log(selected.outerHTML);

        let tipe = selected.getAttribute("data-tipe");

        console.log("TIPE:", tipe);

        let formUkuran = document.getElementById("formUkuran");
        let formQty = document.getElementById("formQty");

        // HANYA kontrol ukuran
    if(tipe == "qty"){
    formUkuran.style.display = "none";
    } else {
    formUkuran.style.display = "block";
    }

    });

});
</script>

<?php include '../../templates/footer.php'; ?>