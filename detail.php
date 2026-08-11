<?php
include "config.php";
include "auth.php";

if (!isset($_GET['id_transaksi'])) {
    echo "ID transaksi tidak ditemukan.";
    exit;
}

$id_transaksi = intval($_GET['id_transaksi']);
$tanggal = date("l, d F Y");
$nama = $_SESSION['username'] ?? 'Guest';
$role = $_SESSION['peran'] ?? 'User';

$transaksi = $conn->query("SELECT dt.*, u.username 
                           FROM data_transaksi dt 
                           JOIN user u ON dt.id_user = u.id_user 
                           WHERE dt.id_transaksi = $id_transaksi")->fetch_assoc();

if (!$transaksi) {
    echo "Transaksi tidak ditemukan.";
    exit;
}

$detail = $conn->query("SELECT d.*, m.nama_menu 
                        FROM detail_transaksi d 
                        JOIN menu m ON d.id_menu = m.id_menu 
                        WHERE d.id_transaksi = $id_transaksi");

?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Detail Transaksi</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css"
        integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style-detail.css">
</head>

<body>

    <nav class="navbar navbar-custom d-flex justify-content-between align-items-center">
        <div class="navbar-left">
            <?php echo $tanggal . " | " . $nama . " (" . $role . ")"; ?>
        </div>
    </nav>

    <div class="container mt-3">
        <h2>Detail Transaksi</h2>
        <a href="cetak_struk.php?id_transaksi=<?= $transaksi['id_transaksi']; ?>" class="btn btn-struk mb-3"
            target="_blank">Cetak Struk</a>
        <a href="transaksi-baru.php" class="btn btn-new mb-3">Transaksi Baru</a>
        <a href="homepage-kasir.php" class="btn btn-kembali mb-3">Kembali Ke Beranda</a>

        <div class="card mb-4 card-transaksi-header">
            <div class="card-body">
                <h5>ID Transaksi: <?= $transaksi['id_transaksi'] ?></h5>
                <p>Kasir: <?= htmlspecialchars($transaksi['username']) ?></p>
                <p>Tanggal: <?= date("d-m-Y H:i:s", strtotime($transaksi['tgl_transaksi'])) ?></p>
                <p>Total: Rp <?= number_format($transaksi['total_harga'], 0, ',', '.') ?>,-</p>
                <p>Bayar: Rp <?= number_format($transaksi['bayar'], 0, ',', '.') ?>,-</p>
                <p>Kembali: Rp <?= number_format($transaksi['kembali'], 0, ',', '.') ?>,-</p>
            </div>
        </div>

        <h4>Daftar Item</h4>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Nama Menu</th>
                    <th>Jumlah</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($detail->num_rows > 0):
                    while ($row = $detail->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['nama_menu']) ?></td>
                            <td><?= $row['jumlah'] ?></td>
                            <td>Rp <?= number_format($row['subtotal'], 0, ',', '.') ?>,-</td>
                        </tr>
                    <?php endwhile; else:
                endif; ?>
            </tbody>
        </table>

    </div>

</body>

</html>