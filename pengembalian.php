<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo "❌ Anda tidak punya akses.";
    exit;
}
include 'koneksi.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Form Pengembalian</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background-color: #f1f4f6;">
<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header bg-warning text-dark">
            <h4 class="mb-0">📦 Pengembalian Buku</h4>
        </div>
        <div class="card-body">
            <form action="proses_pengembalian.php" method="POST">
                <div class="mb-3">
                    <label for="id_pinjaman" class="form-label">Pilih Transaksi Peminjaman</label>
                    <select name="id_pinjaman" class="form-select" required>
                        <option value="">-- Pilih --</option>
                        <?php
                        $query = $conn->query("
                            SELECT p.id_pinjaman, a.nama, b.judul 
                            FROM daftar_pinjaman p
                            JOIN anggota a ON p.id_anggota = a.id_anggota
                            JOIN daftar_buku b ON p.id_buku = b.id_buku
                            WHERE p.id_pinjaman NOT IN (
                                SELECT id_pinjaman FROM daftar_pengembalian
                            )
                        ");
                        if ($query && $query->num_rows > 0) {
                            while ($row = $query->fetch_assoc()) {
                                echo "<option value='{$row['id_pinjaman']}'>#{$row['id_pinjaman']} - {$row['nama']} - {$row['judul']}</option>";
                            }
                        } else {
                            echo "<option value=''>Tidak ada peminjaman aktif</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="tanggal_kembali" class="form-label">Tanggal Pengembalian</label>
                    <input type="date" name="tanggal_kembali" class="form-control" required>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="index.php" class="btn btn-secondary">⬅️ Kembali</a>
                    <button type="submit" class="btn btn-success">Simpan Pengembalian</button>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>
