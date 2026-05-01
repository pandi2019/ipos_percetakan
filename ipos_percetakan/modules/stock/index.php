<?php
include '../../config/auth.php';
include '../../config/database.php';
include '../../templates/header.php';

if(isset($_POST['simpan'])){

    $nama = $_POST['nama'];
    $jumlah = $_POST['jumlah'];
    $jenis = $_POST['jenis'];
    $keterangan = $_POST['keterangan'];

    $sql = "INSERT INTO stok 
    (nama_barang, jumlah, jenis, keterangan) 
    VALUES 
    ('$nama','$jumlah','$jenis','$keterangan')";

    if(!$conn->query($sql)){
        die("ERROR NYA: " . $conn->error);
    }

    echo "<div class='alert alert-success'>Berhasil disimpan!</div>";

}
?>

<h3 class="mb-3"><i class="bi bi-box-fill"></i> Stock Barang</h3>

<div class="card shadow border-0">
<div class="card-body">

<form method="post">

<div class="row">

<div class="col-md-6 mb-3">
<label class="form-label">Nama Barang</label>
<input type="text" name="nama" class="form-control" placeholder="Contoh: Kertas A4" required>
</div>

<div class="col-md-3 mb-3">
<label class="form-label">Jumlah</label>
<input type="number" name="jumlah" class="form-control" required>
</div>

<div class="col-md-3 mb-3">
<label class="form-label">Jenis</label>
<select name="jenis" class="form-select">
<option value="masuk">Masuk</option>
<option value="keluar">Keluar</option>
</select>
</div>

</div>

<div class="mb-3">
<label class="form-label">Keterangan</label>
<textarea name="keterangan" class="form-control" rows="2" placeholder="Catatan..."></textarea>
</div>

<button type="submit" name="simpan" class="btn btn-primary">
<i class="bi bi-save"></i> Simpan
</button>

</form>

<div class="card shadow mt-4 border-0">
<div class="card-body">

<h5 class="mb-3"><i class="bi bi-chat-left-text-fill"></i> Riwayat Stock</h5>

<div class="table-responsive">
<table class="table table-hover align-middle">

<thead class="table-dark">
<tr>
<th>No</th>
<th>Barang</th>
<th>Jumlah</th>
<th>Jenis</th>
<th>Keterangan</th>
<th>Tanggal</th>
</tr>
</thead>

<tbody>

<?php
$no=1;
$q = $conn->query("SELECT * FROM stok ORDER BY id DESC");

while($d=$q->fetch_assoc()){
?>
<tr>

<td><?= $no++ ?></td>

<td>
<i class="bi bi-box-seam text-primary"></i>
<strong><?= $d['nama_barang'] ?></strong>
</td>

<td>
<span class="fw-bold <?= $d['jenis']=='masuk' ? 'text-success' : 'text-danger' ?>">
<?= $d['jumlah'] ?>
</span>
</td>

<td>
<?php if($d['jenis']=='masuk'){ ?>
<span class="badge bg-success">
<i class="bi bi-arrow-down"></i> Masuk
</span>
<?php }else{ ?>
<span class="badge bg-danger">
<i class="bi bi-arrow-up"></i> Keluar
</span>
<?php } ?>
</td>

<td><?= $d['keterangan'] ?></td>

<td>
<small class="text-muted">
<?= date('d M Y - H:i', strtotime($d['tanggal'])) ?>
</small>
</td>

</tr>
<?php } ?>

</tbody>
</table>
</div>

</div>
</div>
<?php include '../../templates/footer.php'; ?>