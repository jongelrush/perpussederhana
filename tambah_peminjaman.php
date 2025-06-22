<?php include 'koneksi.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Peminjaman</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>➕ Tambah Peminjaman</h2>
    <form action="proses_peminjaman.php" method="POST">
        <div class="mb-3">
            <label>Anggota</label>
            <select name="id_anggota" class="form-select" required>
                <option value="">--Pilih--</option>
                <?php
                $anggota = $conn->query("SELECT * FROM anggota");
                while ($row = $anggota->fetch_assoc()) {
                    echo "<option value='{$row['id_anggota']}'>{$row['nama']}</option>";
                }
                ?>
            </select>
        </div>
        <div class="mb-3">
            <label>Buku</label>
            <select name="id_buku" class="form-select" required>
                <option value="">--Pilih--</option>
                <?php
                $buku = $conn->query("SELECT * FROM daftar_buku WHERE stok > 0");
                while ($row = $buku->fetch_assoc()) {
                    echo "<option value='{$row['id_buku']}'>{$row['judul']}</option>";
                }
                ?>
            </select>
        </div>
        <div class="mb-3">
            <label>Tanggal Pinjam</label>
            <input type="date" name="tanggal_pinjam" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="index.php" class="btn btn-secondary">Batal</a>
    </form>
</div>
</body>
</html>

<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    echo "❌ Akses ditolak.";
    exit;
}
?>
