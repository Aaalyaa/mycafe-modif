<?php
require "../../includes/config.php";
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
$data = mysqli_fetch_array($result);

$query_item = "SELECT 
    menu.nama_menu as menu,
    detail_transaksi.jumlah,
    detail_transaksi.subtotal
    FROM detail_transaksi 
    INNER JOIN menu ON detail_transaksi.id_menu = menu.id_menu
    WHERE id_transaksi = '$id_transaksi'";
$result_item = mysqli_query($conn, $query_item);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Struk</title>
    <link rel="stylesheet" href="css/style-struk.css">
    <script>
        window.onload = function() {
            window.print();
        };
    </script>
</head>
<body>
    <div class="struk-container">
        <h2>Struk Pembelian</h2>
        <p>ID: <?= $data['id_transaksi'] ?></p>
        <p>Kasir: <?= $data['kasir'] ?></p>
        <p><?= date("d-m-Y H:i:s", strtotime($data['tgl_transaksi'])) ?></p>

        <table>
            <thead>
                <tr>
                    <th>Menu</th>
                    <th>Qty</th>
                    <th>Sub</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($item = mysqli_fetch_array($result_item)) { ?>
                    <tr>
                        <td><?= $item['menu'] ?></td>
                        <td><?= $item['jumlah'] ?></td>
                        <td><?= number_format($item['subtotal'], 0, ',', '.') ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <p class="total">Total: Rp <?= number_format($data['total_harga'], 0, ',', '.') ?></p>
        <p class="total">Bayar: Rp <?= number_format($data['bayar'], 0, ',', '.') ?></p>
        <p class="total">Kembali: Rp <?= number_format($data['kembali'], 0, ',', '.') ?></p>

        <div class="footer">
            <p>Terima kasih</p>
            <p>~ MyCoffeeShop POS ~</p>
        </div>
    </div>
</body>
</html>
