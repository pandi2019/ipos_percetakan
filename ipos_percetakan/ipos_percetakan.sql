CREATE DATABASE ipos_percetakan;
USE ipos_percetakan;

CREATE TABLE produk (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_produk VARCHAR(100),
    harga_per_cm DECIMAL(10,2)
);

CREATE TABLE pelanggan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100),
    no_hp VARCHAR(20),
    alamat TEXT
);

CREATE TABLE transaksi (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pelanggan_id INT,
    tanggal DATETIME DEFAULT CURRENT_TIMESTAMP,
    total DECIMAL(10,2),
    file_desain VARCHAR(255)
);

CREATE TABLE transaksi_detail (
    id INT AUTO_INCREMENT PRIMARY KEY,
    transaksi_id INT,
    produk_id INT,
    lebar DECIMAL(10,2),
    tinggi DECIMAL(10,2),
    harga DECIMAL(10,2),
    subtotal DECIMAL(10,2)
);

CREATE TABLE user (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50),
    password VARCHAR(255)
);

INSERT INTO user (username, password) 
VALUES ('admin', MD5('admin123'));