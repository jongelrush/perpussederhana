<?php include 'koneksi.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Buku</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>📘 Daftar Buku</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Judul</th>
                <th>Pengarang</th>
                <th>Tahun</th>
                <th>Stok</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $result = $conn->query("SELECT * FROM daftar_buku");
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['judul']}</td>
                        <td>{$row['pengarang']}</td>
                        <td>{$row['tahun_terbit']}</td>
                        <td>{$row['stok']}</td>
                      </tr>";
            }
            ?>
        </tbody>
    </table>
    <a href="index.php" class="btn btn-secondary">⬅️ Kembali</a>
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
