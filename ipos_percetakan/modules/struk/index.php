<?php
include '../../config/auth.php';
include '../../config/database.php';
include '../../templates/header.php';


?>
<style>
@media print {

    body * {
        visibility: hidden;
    }

    #area-print, #area-print * {
        visibility: visible;
    }

    #area-print {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
    }

    .no-print {
        display: none !important;
    }

}
</style>

<form method="get">

<div class="mb-3">
<label>Nama Pelanggan</label>
<select name="nama" class="form-control" required>

<option value="">-- Pilih Pelanggan --</option>

<?php
$q = $conn->query("SELECT * FROM pelanggan");

while($d = $q->fetch_assoc()){
?>

<option value="<?= $d['id'] ?>">
    <?= $d['nama'] ?>
</option>

<?php } ?>

</select>
</div>

<button type="submit" class="btn btn-primary w-100">
Tampilkan Struk
</button>

</form>

<?php
$nama = $_GET['nama'] ?? null;

$dataPelanggan = null;
$allDetail = [];
$totalAll = 0;

if($nama){

    // ambil pelanggan
    $dataPelanggan = $conn->query("
        SELECT * FROM pelanggan WHERE id='$nama'
    ")->fetch_assoc();

    // ambil semua transaksi pelanggan
    $transaksi = $conn->query("
        SELECT id 
        FROM transaksi 
        WHERE pelanggan_id='$nama'
        ORDER BY id ASC
    ");

    while($t = $transaksi->fetch_assoc()){

        $id = $t['id'];

        // ambil detail tiap transaksi
        $detail = $conn->query("
            SELECT td.*, p.nama_produk
            FROM transaksi_detail td
            JOIN produk p ON td.produk_id = p.id
            WHERE td.transaksi_id='$id'
        ");

        while($d = $detail->fetch_assoc()){
            $allDetail[] = $d;
            $totalAll += $d['subtotal'];
        }
    }
}
?>

<?php if($nama && !empty($allDetail)){ ?>

<div class="card p-4 mt-4" id="area-print" class="card p-4 mt-4" style="max-width:350px;margin:auto;">

<h5 class="text-center">Again's Percetakan</h5>
<p class="text-center"> <th>Nama :</th> <?= $dataPelanggan['nama'] ?></p>

<hr>

<!-- HEADER -->
<div class="d-flex small fw-bold mb-2">
    <div style="width:60%">Nama</div>
    <div style="width:15%; text-align:center;">Qty</div>
    <div style="width:25%; text-align:right;">Total</div>
</div>

<hr>

<?php foreach($allDetail as $d){ ?>

<div class="d-flex small mb-2">
    
    <!-- NAMA -->
    <div style="width:60%">
        <?= $d['nama_produk'] ?? '-' ?><br>

        <?php if(($d['lebar'] ?? 0) > 0){ ?>
            <small><?= $d['lebar'] ?> x <?= $d['tinggi'] ?></small>
        <?php } ?>
    </div>

    <!-- QTY -->
    <div style="width:15%; text-align:center;">
        <?= $d['qty'] ?? 0 ?>
    </div>

    <!-- TOTAL -->
    <div style="width:25%; text-align:right;">
        Rp <?= number_format($d['subtotal'],0,',','.') ?>
    </div>

</div>

<?php } ?>



<hr>

<div class="d-flex justify-content-between fw-bold">
<span>Total</span>
<span>Rp <?= number_format($totalAll,0,',','.') ?></span>
</div>

<button onclick="window.print()" class="btn btn-primary w-100 mt-3 no-print">
Print
</button>

<button onclick="kirimWA()" class="btn btn-success w-100 mt-2 no-print">
    <i class="bi bi-whatsapp"></i> Bagikan JPG
</button>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

<script>
function kirimWA() {

    let area = document.getElementById("area-print");

    html2canvas(area, { scale: 2 }).then(canvas => {

        let image = canvas.toDataURL("image/jpeg", 0.9);

        // download otomatis
        let link = document.createElement('a');
        link.href = image;
        link.download = "struk.jpg";
        link.click();

        // buka WA
        window.open("https://wa.me/", "_blank");
    });
}

</script>

<?php } ?>
        
<?php include '../../templates/footer.php'; ?>