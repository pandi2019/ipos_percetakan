<?php
include '../../config/auth.php';
include '../../config/database.php';
include '../../templates/header.php';

$data = $conn->query("SELECT * FROM pelanggan");
?>
<?php if(isset($_GET['status'])){ ?>

<?php if($_GET['status']=='sukses'){ ?>
    <div class="alert alert-success">
        Pelanggan berhasil ditambahkan!
    </div>
<?php } ?>

<?php if($_GET['status']=='update'){ ?>
    <div class="alert alert-success">
        Pelanggan berhasil diupdate!
    </div>
<?php } ?>

<?php if($_GET['status']=='hapus'){ ?>
    <div class="alert alert-success">
        Pelanggan berhasil dihapus!
    </div>
<?php } ?>
<?php } ?>
<div class="card shadow">
<div class="card-body">

<h4 class="mb-3">
    <i class="bi bi-people"></i> Data Pelanggan
</h4>

<a href="tambah.php" class="btn btn-primary mb-3">
    <i class="bi bi-plus-circle"></i> Tambah Pelanggan
</a>

<div class="table-responsive">
<table class="table table-bordered table-striped table-hover align-middle">

<thead class="table-dark">
<tr>
    <th>No</th>
    <th>Nama</th>
    <th>No HP</th>
    <th>Alamat</th>
    <th class="text-center">Aksi</th>
</tr>
</thead>

<tbody>
<?php 
$no=1;
while($d=$data->fetch_assoc()){ ?>
<tr>
<td><?= $no++ ?></td>
<td><?= $d['nama'] ?></td>
<td><?= $d['no_hp'] ?></td>
<td><?= $d['alamat'] ?></td>
<td class="text-center">

    <a href="edit.php?id=<?= $d['id'] ?>" class="btn btn-warning btn-sm">
        <i class="bi bi-pencil-square"></i>
    </a>

    <a href="hapus.php?id=<?= $d['id'] ?>" 
       class="btn btn-danger btn-sm"
       onclick="return confirm('Yakin hapus pelanggan ini?')">
        <i class="bi bi-trash"></i>
    </a>

</td>
</tr>
<?php } ?>
</tbody>

</table>
</div>

</div>
</div>

<?php include '../../templates/footer.php'; ?>