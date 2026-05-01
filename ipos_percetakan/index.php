<?php
include 'config/auth.php';
include 'config/database.php';
include 'templates/header.php';

// QUERY DATA GRAFIK
$data = $conn->query("
    SELECT DATE(tanggal) as tgl, SUM(total) as total
    FROM transaksi
    GROUP BY DATE(tanggal)
");

$tanggal = [];
$total = [];

while($d = $data->fetch_assoc()){
    $tanggal[] = $d['tgl'];
    $total[] = $d['total'];
}

if(empty($tanggal)){
    $tanggal = ["Belum ada data"];
    $total = [0];
}

?>

<div class="card shadow">
    <div class="card-body text-center">
        <h3>Again's Percetakan</h3>
        <p>Selamat Datang Di Again's Percetakan</p>
    </div>
</div>

<div class="card shadow">
    <div class="card-body">
        <h4><i class="bi bi-clipboard-data-fill"></i> Grafik Penjualan</h4>
        <canvas id="chartPenjualan"></canvas>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function(){
    console.log(<?= json_encode($tanggal) ?>);
    console.log(<?= json_encode($total) ?>);
    const ctx = document.getElementById('chartPenjualan');

    new Chart(ctx, {
        type: 'line',
        data: {
        labels: <?= json_encode($tanggal) ?>,
        datasets: [{
        label: 'Total Penjualan',
        data: <?= json_encode($total) ?>,
        borderWidth: 2,
        fill: true,
        tension: 0.4 // 👈 TARO DI SINI
        }]
        },
        options: {  // 👈 TAMBAHKAN DI SINI
            scales: {
                y: {
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + value.toLocaleString();
                        }
                    }
                }
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return 'Rp ' + context.raw.toLocaleString();
                        }
                    }
                }
            }
        }
    });

});
</script>

<?php include 'templates/footer.php'; ?>