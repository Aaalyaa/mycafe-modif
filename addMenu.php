<?php
session_start();
include "config.php";

$id_user = $_SESSION['id_user'];
$idTransaksi = $_SESSION['id_transaksi'];
$idMenu = $_POST['id_menu'];

$cek = $conn->query("SELECT * FROM data_transaksi WHERE id_transaksi = '$idTransaksi'");
$sql = "SELECT * FROM menu WHERE id_menu = '$idMenu'";
$result = $conn->query($sql);
$menu = $result->fetch_assoc();

if (!$menu || $menu['stok'] <= 0) {
    $_SESSION['error'] = "Stok menu habis.";
    header("Location: transaksi.php");
    exit;
}

$checkSql = "SELECT * FROM detail_transaksi WHERE id_transaksi = '$idTransaksi' AND id_menu = '$idMenu'";
$checkResult = $conn->query($checkSql);

if ($checkResult->num_rows > 0) {
    $detail = $checkResult->fetch_assoc();
    $newJumlah = $detail['jumlah'] + 1;
    $newSubtotal = $newJumlah * $menu['harga_jual'];

    $updateSql = "UPDATE detail_transaksi SET jumlah = '$newJumlah', subtotal = '$newSubtotal' 
                  WHERE id_transaksi = '$idTransaksi' AND id_menu = '$idMenu'";
    $conn->query($updateSql);
} else {
    $jumlah = 1;
    $subtotal = $menu['harga_jual'];

    $insertSql = "INSERT INTO detail_transaksi (id_transaksi, id_menu, jumlah, subtotal) 
                  VALUES ('$idTransaksi', '$idMenu', '$jumlah', '$subtotal')";

    if (!$conn->query($insertSql)) {
        die("Gagal menambahkan detail transaksi: " . $conn->error);
    }
}

$newStock = $menu['stok'] - 1;
$updateStockSql = "UPDATE menu SET stok = '$newStock' WHERE id_menu = '$idMenu'";
$conn->query($updateStockSql);

if (isset($_POST['search_menu'])) {
    $_SESSION['search_menu'] = $_POST['search_menu'];
}
if (isset($_POST['kategori_menu'])) {
    $_SESSION['kategori_menu'] = $_POST['kategori_menu'];
}

header("Location: transaksi.php");
exit;
