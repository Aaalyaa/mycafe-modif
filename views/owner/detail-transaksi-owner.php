<?php
require_once __DIR__ . "/../../controllers/laporan-controller.php";
$id_transaksi = $_GET["id_transaksi"];
$username = $_SESSION['username'];
$tanggal = date("l, d F Y");
$role = $_SESSION['peran'] ?? 'User';
$data_1 = LaporanController::getDetail($id_transaksi);
$data_2 = LaporanController::getItem($id_transaksi);
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
            <?php echo $tanggal . " | " . $username . " (" . $role . ")"; ?>
        </div>
        <div class="navbar-right">
            <a href="index.php?page=logout" class="btn btn-logout"
                onclick="return confirm('Apakah kamu yakin ingin keluar dari website?')">Logout</a>
        </div>
    </nav>
    <div class="container mt-3">
        <h2>Detail Transaksi</h2>
        <a href="index.php?page=lihat-laporan" class="btn btn-kembali mb-3">Kembali</a>
        <a href="views/struk/cetak_struk.php?id_transaksi=<?= $id_transaksi ?>" class="btn btn-struk mb-3"
            target="_blank">Cetak Struk</a>


        <div class="card mb-4 card-transaksi-header">
            <div class="card-body">
                <h5>ID Transaksi: <?php echo $data_1['id_transaksi']; ?></h5>
                <p>Tanggal Transaksi: <?php echo date("d-m-Y H:i:s", strtotime($data_1['tgl_transaksi'])); ?></p>
                <p>Kasir: <?php echo $data_1['kasir']; ?></p>
                <p>Total harga: Rp <?php echo number_format($data_1['total_harga'], 0, ',', '.'); ?>,-</p>
                <p>Bayar: Rp <?php echo number_format($data_1['bayar'], 0, ',', '.'); ?>,-</p>
                <p>Kembali: Rp <?php echo number_format($data_1['kembali'], 0, ',', '.'); ?>,-</p>
            </div>
        </div>

        <h4>Daftar Item</h4>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Menu</th>
                    <th>Jumlah</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($data_2 as $item) {
                    ?>
                    <tr>
                        <td><?php echo $item['menu']; ?></td>
                        <td><?php echo $item['jumlah']; ?></td>
                        <td>Rp <?php echo number_format($item['subtotal'], 0, ',', '.'); ?>,-</td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>