<?php
include '../../config/database.php';

$conn->query("DELETE FROM pelanggan WHERE id=$_GET[id]");
header("Location: index.php?page=pelanggan&status=hapus");
exit;