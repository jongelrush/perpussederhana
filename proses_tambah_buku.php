<?php
session_start();
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul     = $_POST['judul'] ?? '';
    $pengarang = $_POST['pengarang'] ?? '';
    $tahun     = $_POST['tahun'] ?? '';
    $stok      = $_POST['stok'] ?? 0;

    if ($judul === '' || $pengarang === '' || $tahun === '' || $stok === '') {
        echo "<script>alert('Semua field wajib diisi!'); window.history.back();</script>";
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO daftar_buku (judul, pengarang, tahun_terbit, stok) VALUES (?, ?, ?, ?)");
    if ($stmt) {
        $stmt->bind_param("ssii", $judul, $pengarang, $tahun, $stok);
        if ($stmt->execute()) {
            echo "<script>alert('Buku berhasil ditambahkan!'); window.location='index.php';</script>"; // ⬅ diarahkan ke dashboard
        } else {
            echo "<script>alert('Gagal menambahkan buku: {$stmt->error}'); window.history.back();</script>";
        }
        $stmt->close();
    } else {
        echo "<script>alert('Query error: {$conn->error}'); window.history.back();</script>";
    }
} else {
    header("Location: tambah_buku.php");
    exit;
}
?>
