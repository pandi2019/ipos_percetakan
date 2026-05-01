<?php
include '../../config/database.php';

$id = $_POST['id'];
$status = $_POST['status'];

$conn->query("UPDATE transaksi SET status='$status' WHERE id=$id");

header("Location: index.php");