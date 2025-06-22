<?php
$conn = new mysqli("localhost", "root", "", "perpus");
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Perpustakaan</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h3 class="mb-4">📊 Laporan & Statistik Perpustakaan</h3>

    <!-- A. Buku yang sedang dipinjam -->
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-info text-white">📚 Buku yang Sedang Dipinjam</div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead><tr><th>Judul</th><th>Peminjam</th><th>Tanggal Pinjam</th></tr></thead>
                <tbody>
                <?php
                $a = $conn->query("
                    SELECT b.judul, a.nama, p.tanggal_pinjam
                    FROM daftar_pinjaman p
                    JOIN daftar_buku b ON p.id_buku = b.id_buku
                    JOIN anggota a ON p.id_anggota = a.id_anggota
                    WHERE p.id_pinjaman NOT IN (
                        SELECT id_pinjaman FROM daftar_pengembalian
                    )
                ");
                while ($row = $a->fetch_assoc()) {
                    echo "<tr><td>{$row['judul']}</td><td>{$row['nama']}</td><td>{$row['tanggal_pinjam']}</td></tr>";
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- B. Statistik per bulan -->
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-primary text-white">📅 Statistik Peminjaman per Bulan</div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead><tr><th>Bulan</th><th>Jumlah Peminjaman</th></tr></thead>
                <tbody>
                <?php
                $b = $conn->query("
                    SELECT DATE_FORMAT(tanggal_pinjam, '%Y-%m') AS bulan, COUNT(*) AS jumlah
                    FROM daftar_pinjaman
                    GROUP BY bulan
                    ORDER BY bulan DESC
                ");
                while ($row = $b->fetch_assoc()) {
                    echo "<tr><td>{$row['bulan']}</td><td>{$row['jumlah']}</td></tr>";
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- C. Peminjam Paling Aktif -->
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-success text-white">👤 Peminjam Buku Paling Aktif</div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead><tr><th>Nama</th><th>Total Pinjam</th></tr></thead>
                <tbody>
                <?php
                $c = $conn->query("
                    SELECT a.nama, COUNT(*) AS total_pinjam
                    FROM daftar_pinjaman p
                    JOIN anggota a ON p.id_anggota = a.id_anggota
                    GROUP BY a.nama
                    ORDER BY total_pinjam DESC
                    LIMIT 5
                ");
                while ($row = $c->fetch_assoc()) {
                    echo "<tr><td>{$row['nama']}</td><td>{$row['total_pinjam']}</td></tr>";
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- D. Rata-rata Lama Peminjaman -->
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-warning">⏳ Rata-Rata Lama Peminjaman (hari)</div>
        <div class="card-body">
            <?php
            $d = $conn->query("
                SELECT ROUND(AVG(DATEDIFF(k.tanggal_kembali, p.tanggal_pinjam)), 2) AS rata_rata
                FROM daftar_pinjaman p
                JOIN daftar_pengembalian k ON p.id_pinjaman = k.id_pinjaman
            ");
            $rata = $d->fetch_assoc()['rata_rata'] ?? 0;
            echo "<h4>{$rata} Hari</h4>";
            ?>
        </div>
    </div>

    <a href="index.php" class="btn btn-secondary">⬅️ Kembali ke Dashboard</a>
</div>
</body>
</html>
