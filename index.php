<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}
include 'koneksi.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Perpustakaan</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .sidebar {
            height: 100vh;
            background-color: #212529;
            position: fixed;
            top: 0;
            left: 0;
            padding-top: 60px;
            width: 220px;
        }
        .sidebar a {
            color: #adb5bd;
            padding: 12px 20px;
            display: block;
            text-decoration: none;
        }
        .sidebar a:hover, .sidebar a.active {
            background-color: #343a40;
            color: #fff;
        }
        .main-content {
            margin-left: 220px;
            padding: 30px;
        }
        .sidebar .logo {
            position: fixed;
            top: 0;
            left: 0;
            width: 220px;
            background-color: #343a40;
            color: #fff;
            text-align: center;
            padding: 15px;
            font-weight: bold;
            font-size: 18px;
        }
    </style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
    <div class="logo">
        📚 Perpustakaan
    </div>
    <a href="index.php" class="active"><i class="bi bi-bar-chart-fill"></i> Statistik</a>
    <a href="daftar_buku.php"><i class="bi bi-book"></i> Daftar Buku</a>
    <a href="tambah_buku.php"><i class="bi bi-plus-square"></i> Tambah Buku</a>
    <a href="tambah_peminjaman.php"><i class="bi bi-journal-arrow-up"></i> Tambah Peminjaman</a>
    <a href="pengembalian.php"><i class="bi bi-journal-arrow-down"></i> Pengembalian Buku</a>
    <a href="tambah_anggota.php"><i class="bi bi-person-plus"></i> Tambah Anggota</a>
    <a href="daftar_anggota.php"><i class="bi bi-people-fill"></i> Daftar Anggota</a>
    <a href="logout.php" class="text-danger"><i class="bi bi-box-arrow-right"></i> Logout</a>
</div>

<!-- Main Content -->
<div class="main-content">
    <h2 class="mb-4"><i class="bi bi-bar-chart-fill"></i> Statistik Perpustakaan</h2>

    <div class="row mb-4">
        <!-- Buku yang sedang dipinjam -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <i class="bi bi-book-half"></i> Buku yang Sedang Dipinjam
                </div>
                <ul class="list-group list-group-flush">
                    <?php
                    $pinjam = $conn->query("
                        SELECT b.judul, a.nama
                        FROM daftar_pinjaman p
                        JOIN daftar_buku b ON p.id_buku = b.id_buku
                        JOIN anggota a ON p.id_anggota = a.id_anggota
                        WHERE p.id_pinjaman NOT IN (
                            SELECT id_pinjaman FROM daftar_pengembalian
                        )
                        LIMIT 5
                    ");
                    if ($pinjam->num_rows > 0) {
                        while ($r = $pinjam->fetch_assoc()) {
                            echo "<li class='list-group-item'>{$r['judul']} - <em>{$r['nama']}</em></li>";
                        }
                    } else {
                        echo "<li class='list-group-item text-muted'>Tidak ada pinjaman aktif</li>";
                    }
                    ?>
                </ul>
            </div>
        </div>

        <!-- Statistik per bulan -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <i class="bi bi-calendar-event"></i> Peminjaman per Bulan
                </div>
                <div class="card-body">
                    <table class="table table-sm table-bordered mb-0">
                        <thead><tr><th>Bulan</th><th>Jumlah</th></tr></thead>
                        <tbody>
                        <?php
                        $stat = $conn->query("
                            SELECT DATE_FORMAT(tanggal_pinjam, '%Y-%m') AS bulan, COUNT(*) AS jumlah
                            FROM daftar_pinjaman
                            GROUP BY bulan
                            ORDER BY bulan DESC
                            LIMIT 3
                        ");
                        while ($row = $stat->fetch_assoc()) {
                            echo "<tr><td>{$row['bulan']}</td><td>{$row['jumlah']}</td></tr>";
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Peminjam Aktif -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-warning text-dark">
                    <i class="bi bi-people-fill"></i> Top 3 Peminjam Paling Aktif
                </div>
                <div class="card-body">
                    <table class="table table-sm table-bordered mb-0">
                        <thead><tr><th>Nama</th><th>Total Pinjam</th></tr></thead>
                        <tbody>
                        <?php
                        $aktif = $conn->query("
                            SELECT a.nama, COUNT(*) AS total
                            FROM daftar_pinjaman p
                            JOIN anggota a ON p.id_anggota = a.id_anggota
                            GROUP BY a.nama
                            ORDER BY total DESC
                            LIMIT 3
                        ");
                        while ($row = $aktif->fetch_assoc()) {
                            echo "<tr><td>{$row['nama']}</td><td>{$row['total']}</td></tr>";
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Rata-rata peminjaman -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-info text-white">
                    <i class="bi bi-clock-history"></i> Rata-Rata Lama Peminjaman
                </div>
                <div class="card-body">
                    <div class="alert alert-light mb-0">
                        <?php
                        $rata = $conn->query("
                            SELECT ROUND(AVG(DATEDIFF(k.tanggal_kembali, p.tanggal_pinjam)), 2) AS rata
                            FROM daftar_pinjaman p
                            JOIN daftar_pengembalian k ON p.id_pinjaman = k.id_pinjaman
                        ");
                        $hasil = $rata->fetch_assoc();
                        echo $hasil['rata'] ? "{$hasil['rata']} hari" : "Belum ada data pengembalian.";
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
