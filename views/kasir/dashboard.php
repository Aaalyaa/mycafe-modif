<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage Kasir</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="css/style-kasir.css">
</head>

<body>

    <?php
    include "includes/config.php";
    include "includes/auth.php";
    $tanggal = date("l, d F Y");
    $nama = $_SESSION['username'] ?? 'Guest';
    $role = $_SESSION['peran'] ?? 'User';
    $where = "";

    if (!empty($_GET['start_date']) && !empty($_GET['end_date'])) {
        $start_date = $_GET['start_date'];
        $end_date = $_GET['end_date'];
        $where = "AND tgl_transaksi BETWEEN '$start_date' AND '$end_date'";
    }

    $sql = "SELECT * FROM data_transaksi WHERE id_user = '" . $_SESSION['id_user'] . "' $where ORDER BY tgl_transaksi DESC";
    ?>

    <nav class="navbar navbar-custom d-flex justify-content-between align-items-center">
        <div class="navbar-left">
            <?php echo $tanggal . " | " . $nama . " (" . $role . ")"; ?>
        </div>
        <div class="navbar-right">
            <a href="index.php?page=kasir-akun" class="btn btn-akun">Lihat Informasi Akun</a>
            <a href="index.php?page=logout" class="btn btn-logout"
                onclick="return confirm('Apakah kamu yakin ingin keluar dari website?')">Logout</a>
        </div>
    </nav>

    <div class="mt-4 text-center">
        <h2 align="center">Histori Transaksi Anda</h2>
    </div>

    <div class="container table-wrapper">
        <div class="row mt-5 mb-1 align-items-center">
            <div class="col-md-8">
                <form method="GET" class="form-row align-items-center filter-form">
                    <div class="col-auto">
                        <label for="start_date" class="col-form-label">Dari:</label>
                    </div>
                    <div class="col-auto">
                        <input type="date" class="form-control" name="start_date"
                            value="<?= $_GET['start_date'] ?? '' ?>">
                    </div>
                    <div class="col-auto">
                        <label for="end_date" class="col-form-label">Sampai:</label>
                    </div>
                    <div class="col-auto">
                        <input type="date" class="form-control" name="end_date" value="<?= $_GET['end_date'] ?? '' ?>">
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-filter">Filter</button>
                        <a href="homepage-kasir.php" class="btn btn-reset ml-2">Reset</a>
                    </div>
                </form>
            </div>
 
            <div class="col-md-4 text-right mt-3 mt-md-0">
                <a href="transaksi-baru.php" class="btn btn-brown">
                    <i class="fas fa-plus mr-1"></i>Input Penjualan Terbaru</a>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-hover text-center">
                <thead>
                    <tr>
                        <th scope="col">ID Transaksi</th>
                        <th scope="col">Tanggal Transaksi</th>
                        <th scope="col">Total Pembelian</th>
                        <th scope="col">Bayar</th>
                        <th scope="col">Kembalian</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                    while ($data = $result->fetch_assoc()) {
                        ?>

                        <tr>
                            <td><?= htmlspecialchars($data["id_transaksi"]); ?></td>
                            <td><?= date("d-m-Y", strtotime($data["tgl_transaksi"])); ?></td>
                            <td>Rp <?= number_format($data["total_harga"], 0, ',', '.'); ?>,-</td>
                            <td>Rp <?= number_format($data["bayar"], 0, ',', '.'); ?>,-</td>
                            <td>Rp <?= number_format($data["kembali"], 0, ',', thousands_separator: '.'); ?>,-</td>
                            <td class="action-buttons">
                                <div class="btn-actions"><a
                                        href="fungsi/lihat/detail_transaksi_kasir.php?id_transaksi=<?php echo $data["id_transaksi"]; ?>"
                                        class="btn btn-detail">Detail</a>
                                </div>
                            </td>
                        </tr>
                        <?php
                        }
                    } else {
                        ?>
                        <tr>
                            <td colspan="6" class="text-center font-weight-bold">
                                Anda belum melakukan transaksi apapun.
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                    </tbody>
            </table>
        </div>
    </div>
</body>

</html>