<?php
include '../../config/auth.php';
include '../../config/database.php';
include '../../templates/header.php';

$data = $conn->query("SELECT * FROM produk");

?>
<?php if(isset($_GET['status'])){ ?>

<?php if($_GET['status']=='sukses'){ ?>
    <div class="alert alert-success">
        Produk berhasil ditambahkan!
    </div>
<?php } ?>

<?php if($_GET['status']=='update'){ ?>
    <div class="alert alert-success">
        Produk berhasil diupdate!
    </div>
<?php } ?>

<?php if($_GET['status']=='hapus'){ ?>
    <div class="alert alert-success">
        Produk berhasil dihapus!
    </div>
<?php } ?>

<?php } ?>

<div class="card shadow">
<div class="card-body">

<h4><i class="bi bi-box"></i> Data Produk</h4>

<a href="tambah.php" class="btn btn-primary mb-3">+ Tambah</a>

<table class="table table-bordered table-striped">
<tr>
<th>Nama</th>
<th>Harga</th>
<th>Tipe</th>
<th>Aksi</th>
</tr>

<?php while($d=$data->fetch_assoc()){ ?>
<tr>
<td><?= $d['nama_produk'] ?></td>
<td>Rp <?= number_format($d['harga'],0,',','.') ?></td>
<td>
<?= $d['tipe']=='qty' 
    ? "<span class='badge bg-success'>Qty</span>" 
    : "<span class='badge bg-primary'>Ukuran</span>" ?>
</td>
<td>
<a href="edit.php?id=<?= $d['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
<a href="hapus.php?id=<?= $d['id'] ?>" class="btn btn-danger btn-sm">Hapus</a>
</td>

</tr>
<?php } ?>

</table>

</div>
</div>

<?php include '../../templates/footer.php'; ?>