<?php
include 'koneksi.php';

$id_anggota = $_POST['id_anggota'];
$id_buku = $_POST['id_buku'];
$tanggal = $_POST['tanggal_pinjam'];

$conn->query("INSERT INTO daftar_pinjaman (id_anggota, id_buku, tanggal_pinjam) VALUES ('$id_anggota', '$id_buku', '$tanggal')");
$conn->query("UPDATE daftar_buku SET stok = stok - 1 WHERE id_buku = '$id_buku'");

echo "<script>alert('Peminjaman berhasil disimpan!'); window.location='index.php';</script>";
?>
