<?php
// Tampilkan error PHP (debugging)
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include 'koneksi.php';

// Pastikan method POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $nama    = $_POST['nama'] ?? '';
    $alamat  = $_POST['alamat'] ?? '';
    $no_telp = $_POST['no_telp'] ?? '';

    // Validasi form
    if (empty($nama) || empty($alamat) || empty($no_telp)) {
        echo "<script>alert('Semua field wajib diisi!'); window.history.back();</script>";
        exit;
    }

    // Query simpan menggunakan prepared statement
    $stmt = $conn->prepare("INSERT INTO anggota (nama, alamat, no_telp) VALUES (?, ?, ?)");
    if ($stmt) {
        $stmt->bind_param("sss", $nama, $alamat, $no_telp);
        if ($stmt->execute()) {
            echo "<script>alert('Anggota berhasil ditambahkan!'); window.location='index.php';</script>";
        } else {
            echo "<script>alert('Gagal menyimpan data: {$stmt->error}'); window.history.back();</script>";
        }
        $stmt->close();
    } else {
        echo "<script>alert('Query error: {$conn->error}'); window.history.back();</script>";
    }
} else {
    header("Location: tambah_anggota.php");
    exit;
}
?>
