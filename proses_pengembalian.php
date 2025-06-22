<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_pinjaman = $_POST['id_pinjaman'];
    $tanggal = $_POST['tanggal_kembali'];

    // Validasi input
    if (empty($id_pinjaman) || empty($tanggal)) {
        echo "<script>alert('Data tidak lengkap!'); window.location='pengembalian.php';</script>";
        exit;
    }

    // Cek apakah sudah dikembalikan
    $cek = $conn->query("SELECT * FROM daftar_pengembalian WHERE id_pinjaman = '$id_pinjaman'");
    if ($cek && $cek->num_rows > 0) {
        echo "<script>alert('Pinjaman ini sudah dikembalikan!'); window.location='pengembalian.php';</script>";
        exit;
    }

    // Ambil ID Buku dari daftar_pinjaman
    $result = $conn->query("SELECT id_buku FROM daftar_pinjaman WHERE id_pinjaman = '$id_pinjaman'");
    if (!$result || $result->num_rows == 0) {
        echo "<script>alert('ID pinjaman tidak ditemukan!'); window.location='pengembalian.php';</script>";
        exit;
    }

    $data = $result->fetch_assoc();
    $id_buku = $data['id_buku'];

    // Tambahkan ke daftar_pengembalian
    $insert = $conn->query("INSERT INTO daftar_pengembalian (id_pinjaman, tanggal_kembali) VALUES ('$id_pinjaman', '$tanggal')");

    // Tambah stok buku
    $update = $conn->query("UPDATE daftar_buku SET stok = stok + 1 WHERE id_buku = '$id_buku'");

    if ($insert && $update) {
        echo "<script>alert('Pengembalian berhasil disimpan!'); window.location='index.php';</script>";
    } else {
        echo "<script>alert('Gagal menyimpan data.'); window.location='pengembalian.php';</script>";
    }
} else {
    header("Location: pengembalian.php");
    exit;
}
?>
