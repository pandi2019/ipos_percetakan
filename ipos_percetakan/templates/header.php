<!DOCTYPE html>
<html>
<head>
<?php if(isset($_SESSION['success'])){ ?>
    <div class="alert alert-success">
    <i class="bi bi-check-circle"></i><?= $_SESSION['success']; ?>
    </div>
<?php unset($_SESSION['success']); } ?>
<link rel="icon" href="/ipos_percetakan/assets/ag.png">
    <title>AGAINS PERCETAKAN</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Icon -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    

</head>

<body style="background:#f4f6f9;">

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-dark text-white bg-cyan shadow-sm">
<div class="container">
<style>
  .bg-cyan {
    background-color: #097ddb !important;
  }
   
</style>

    <!-- LOGO -->
    <a class="navbar-brand d-flex align-items-center" href="/ipos_percetakan">
        <img src="/ipos_percetakan/assets/ag.png" width="35" class="me-2">
        <strong>Again's Percetakan</strong>
    </a>

    <!-- TOGGLE MOBILE -->
    <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#menu">
        <span class="navbar-toggler-icon"></span>
    </button>
    
    <!-- MENU -->
    <div class="collapse navbar-collapse"  id="menu">
        <ul class="navbar-nav ms-auto">

            <li class="nav-item">
                <a class="nav-link" href="/ipos_percetakan/index.php">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="/ipos_percetakan/modules/produk/index.php">
                    <i class="bi bi-box"></i> Produk
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="/ipos_percetakan/modules/pelanggan/index.php">
                    <i class="bi bi-people"></i> Pelanggan
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="/ipos_percetakan/modules/transaksi/index.php">
                    <i class="bi bi-cash-coin"></i> Transaksi
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="/ipos_percetakan/modules/pengeluaran/index.php">
                    <i class="bi bi-receipt"></i> Pengeluaran
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="/ipos_percetakan/modules/stock/index.php">
                    <i class="bi bi-box-fill"></i> Stock Barang
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="/ipos_percetakan/modules/struk/index.php">
                    <i class="bi bi-printer-fill"></i> Cetak Struk
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="/ipos_percetakan/modules/profil/index.php">
                    <i class="bi bi-person"></i> Profil
                </a>
            </li>

            <li class="nav-item">
                <a class="btn btn-danger btn-sm" href="/ipos_percetakan/logout.php">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </a>
            </li>

            <li class="nav-item ms-3">
                <span class="text-white me-3">
                    <i class="bi bi-person-circle"></i> <?= $_SESSION['username'] ?? 'User' ?>
                </span>
            </li>

        </ul>
    </div>

</div>
</nav>

<!-- CONTENT -->
<div class="container mt-4">