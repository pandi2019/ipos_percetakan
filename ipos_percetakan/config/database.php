<?php
$conn = new mysqli("localhost", "root", "", "ipos_percetakan");

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>