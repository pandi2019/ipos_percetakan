<?php
include '../../config/auth.php';
include '../../config/database.php';
include '../../templates/header.php';

$qTotal = $conn->query("SELECT total FROM pengeluaran_total WHERE id=1");

if(!$qTotal){
    die("Error: " . $conn->error);
}

$dataTotal = $qTotal->fetch_assoc();

$total_pengeluaran = $dataTotal['total'] ?? 0;


// ================== PROSES POST ==================
if(isset($_POST['simpan'])){

    $nama = $_POST['nama'];
    $jumlah = preg_replace('/[^0-9]/', '', $_POST['jumlah']);
    $jumlah = (int)$jumlah;
    $keterangan = $_POST['keterangan'];

    // simpan pengeluaran
    $conn->query("INSERT INTO pengeluaran 
    (nama_pengeluaran, jumlah, keterangan) 
    VALUES 
    ('$nama','$jumlah','$keterangan')");

    // update total
    $conn->query("UPDATE pengeluaran_total 
    SET total = total + $jumlah 
    WHERE id = 1");

    header("Location: index.php?page=pengeluaran&status=sukses");
    exit;
}

    // RESET
    if(isset($_POST['reset_total'])){
    $conn->query("UPDATE pengeluaran_total SET total = 0 WHERE id=1");

    header("Location: index.php?page=pengeluaran&status=reset");
    exit;
}
?>


<?php if(isset($_GET['status']) && $_GET['status']=='reset'){ ?>
<div class="alert alert-warning">
    Semua total pengeluaran berhasil direset!
</div>

<?php } ?>

<?php if(isset($_GET['status']) && $_GET['status']=='sukses'){ ?>

    <div class="alert alert-success">
    Data pengeluaran berhasil disimpan!
</div>
<?php } ?>


<h3 class="mb-4"><i class="bi bi-receipt"></i> Pengeluaran</h3>

<div class="card shadow border-0">
<div class="card-body">

<form method="post" action="index.php?page=pengeluaran">

<div class="row g-3">

<div class="col-md-6">
<label class="form-label">Nama Pengeluaran</label>
<div class="input-group">
<span class="input-group-text"><i class="bi bi-cart"></i></span>
<input type="text" name="nama" class="form-control" placeholder="Barang" required>
</div>
</div>

<div class="col-md-6">
<label class="form-label">Jumlah</label>
<div class="input-group">
<span class="input-group-text">Rp</span>
<input type="text" name="jumlah" id="jumlah" class="form-control" placeholder="Rp 0">
</div>
</div>

<div class="col-12">
<label class="form-label">Keterangan</label>
<textarea name="keterangan" class="form-control" rows="2" placeholder="Tambahkan catatan..."></textarea>
</div>
</div>

<div class="card bg-danger text-white shadow border-0 mb-3">
<div class="card-body d-flex justify-content-between align-items-center">

<div class=mt-3>
<h6>Total Pengeluaran</h6>
<h3>Rp <?= number_format($total_pengeluaran, 0, ',', '.') ?></h3>
</div>

<i class="bi bi-cash-stack fs-1"></i>

</div>
</div>

<div class="row">

<div class="col-md-4">
    <!-- CARD TOTAL -->
</div>

<div class="col-md-8">
    <!-- nanti bisa isi grafik -->
</div>
</div>


<button type="submit" name="simpan" class="btn btn-danger mt-3">
<i class="bi bi-save"></i> Simpan Pengeluaran
</button>
</form>

<form method="post" action="index.php?page=pengeluaran" onsubmit="return confirm('Reset total pengeluaran?')">
    <button type="submit" name="reset_total" class="btn btn-warning mt-3">
    <i class="bi bi-bootstrap-reboot"></i> Reset Total 
    </button>
</form>


<div class="card shadow border-0 mt-4">
<div class="card-body">

<div class="d-flex justify-content-between align-items-center mb-3">
<h5 class="mb-0"><i class="bi bi-chat-left-text-fill"></i> Riwayat Pengeluaran</h5>
</div>

<div class="table-responsive">
<table class="table table-hover align-middle">

<thead class="table-dark">
<tr>
<th>No</th>
<th>Pengeluaran</th>
<th>Jumlah</th>
<th>Keterangan</th>
<th>Tanggal</th>
</tr>
</thead>

<script>
let input = document.getElementById("jumlah");

input.addEventListener("keyup", function(){

    let angka = this.value.replace(/[^,\d]/g, "").toString();
    let split = angka.split(",");
    let sisa = split[0].length % 3;
    let rupiah = split[0].substr(0, sisa);
    let ribuan = split[0].substr(sisa).match(/\d{3}/gi);

    if(ribuan){
        let separator = sisa ? "." : "";
        rupiah += separator + ribuan.join(".");
    }

    this.value = "Rp " + rupiah;
});
</script>

<tbody>

<?php
$no=1;
$q = $conn->query("SELECT * FROM pengeluaran ORDER BY id DESC");

while($d=$q->fetch_assoc()){
?>

<tr>

<td><?= $no++ ?></td>

<td>
<i class="bi bi-bag text-danger"></i>
<strong><?= $d['nama_pengeluaran'] ?></strong>
</td>

<td>
<span class="fw-bold text-danger">
Rp <?= number_format($d['jumlah']) ?>
</span>
</td>

<td>
<small><?= $d['keterangan'] ?></small>
</td>

<td>
<span class="badge bg-secondary">
<?= date('d M Y', strtotime($d['tanggal'])) ?>
</span>
</td>

</tr>

<?php } ?>

</tbody>
</table>
</div>
</div>
</div>

<?php include '../../templates/footer.php'; ?>