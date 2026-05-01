<?php
include '../../config/database.php';

$conn->query("DELETE FROM produk WHERE id=$_GET[id]");
header("Location: index.php?page=produk&status=hapus");
exit;