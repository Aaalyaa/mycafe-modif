<?php
include "../../config.php";
include "../../auth.php";
$id_transaksi = $_GET["id_transaksi"];
$query = "SELECT 
        data_transaksi.id_transaksi, 
        data_transaksi.total_harga, 
        data_transaksi.bayar,
        data_transaksi.kembali,
        data_transaksi.tgl_transaksi, 
        user.username as kasir
        FROM data_transaksi 
        INNER JOIN user ON data_transaksi.id_user = user.id_user
        WHERE id_transaksi = '$id_transaksi'";
$result = mysqli_query($conn, $query);
$data_1 = mysqli_fetch_array($result);
$tanggal = date("l, d F Y");
$nama = $_SESSION['username'] ?? 'Guest';
$role = $_SESSION['peran'] ?? 'User';
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Detail Transaksi</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css"
        integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <link rel="stylesheet" href="../../css/style-detail.css">
</head>

<body>
    <nav class="navbar navbar-custom d-flex justify-content-between align-items-center">
        <div class="navbar-left">
            <?php echo $tanggal . " | " . $nama . " (" . $role . ")"; ?>
        </div>
        <div class="navbar-right">
            <a href="../../kasir-akun.php" class="btn btn-akun">Lihat Informasi Akun</a>
            <a href="../../logout.php" class="btn btn-logout"
                onclick="return confirm('Apakah kamu yakin ingin keluar dari website?')">Logout</a>
        </div>
    </nav>

    <div class="container mt-3">
        <h2>Detail Transaksi</h2>
        <a href="../../homepage-kasir.php" class="btn btn-kembali mb-3">Kembali</a>
        <a href="../../cetak_struk.php?id_transaksi=<?= $data_1['id_transaksi']; ?>" class="btn btn-struk mb-3"
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
                $query = "SELECT 
            menu.nama_menu as menu,
            detail_transaksi.jumlah,
            detail_transaksi.subtotal
            FROM detail_transaksi 
            INNER JOIN menu ON detail_transaksi.id_menu = menu.id_menu
            WHERE id_transaksi = '$id_transaksi'";
                $result = mysqli_query($conn, $query);
                while ($data_2 = mysqli_fetch_array($result)) {
                    ?>
                    <tr>
                        <td><?php echo $data_2['menu']; ?></td>
                        <td><?php echo $data_2['jumlah']; ?></td>
                        <td>Rp <?php echo number_format($data_2['subtotal'], 0, ',', '.'); ?>,-</td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>