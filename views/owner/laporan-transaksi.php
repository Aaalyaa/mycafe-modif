<?php
include "includes/config.php";
include "includes/auth.php";
$username = $_SESSION['username'];
$tanggal = date("l, d F Y");
$role = $_SESSION['peran'] ?? 'User';
?>

<!DOCTYPE html>
<html>

<head>
    <title>Laporan Transaksi</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css"
        integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style-table.css">
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
    <div class="header mt-4 text-center">
        <h2 align="center">Laporan Transaksi</h2>
    </div>
    <div class="container table-wrapper mb-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <a href="index.php?page=dashboard-owner" class="btn btn-kembali">Kembali</a>

            <form method="GET" action="index.php" class="form-inline filter-form">
                <input type="hidden" name="page" value="lihat-laporan">
                <label for="start-date" class="mr-2">Dari:</label>
                <input type="date" class="form-control mr-3" name="start_date" value="<?= $_GET['start_date'] ?? null ?>">

                <label for="end-date" class="mr-2">Sampai:</label>
                <input type="date" class="form-control mr-3" name="end_date" value="<?= $_GET['end_date'] ?? null ?>">

                <button type="submit" class="btn btn-filter mr-2">Filter</button>
                <a href="index.php?page=lihat-laporan" class="btn btn-reset">Reset</a>
            </form>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-hover text-center">
                <thead>
                    <tr>
                        <th>ID Transaksi</th>
                        <th>Tanggal Transaksi</th>
                        <th>Total Harga</th>
                        <th>Bayar</th>
                        <th>Kembalian</th>
                        <th>Kasir</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <?php
                while ($data = $result->fetch_assoc()) {
                    ?>

                    <tbody>
                        <tr>
                            <td><?php echo $data["id_transaksi"]; ?></td>
                            <td><?php echo date("d-m-Y H:i:s", strtotime($data['tgl_transaksi'])); ?></td>
                            <td><?php echo number_format($data["total_harga"], 0, ',', '.'); ?></td>
                            <td><?php echo number_format($data["bayar"], 0, ',', '.'); ?></td>
                            <td><?php echo number_format($data["kembali"], 0, ',', '.'); ?></td>
                            <td><?php echo $data["kasir"]; ?></td>
                            <td class="action-buttons">
                                <div class="btn-actions"><a
                                        href="index.php?page=detail-owner&id_transaksi=<?php echo $data["id_transaksi"]; ?>"
                                        class="btn btn-detail">Detail</a>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                    <?php
                }
                ?>
            </table>
        </div>
    </div>
</body>

</html>