<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $hapus = $conn->query("DELETE FROM anggota WHERE id_anggota = $id");

    if ($hapus) {
        echo "<script>alert('Anggota berhasil dihapus.'); window.location='daftar_anggota.php';</script>";
    } else {
        echo "<script>alert('Gagal menghapus anggota.'); window.history.back();</script>";
    }
} else {
    header("Location: daftar_anggota.php");
    exit;
}
?>
