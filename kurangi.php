<?php
session_start();
include "config.php";

$idTransaksi = $_SESSION['id_transaksi'];
$idMenu = $_POST['id_menu'];

if (isset($_POST['search_menu'])) {
    $_SESSION['search_menu'] = $_POST['search_menu'];
}
if (isset($_POST['kategori_menu'])) {
    $_SESSION['kategori_menu'] = $_POST['kategori_menu'];
}

$cekDetail = $conn->query("SELECT * FROM detail_transaksi WHERE id_transaksi='$idTransaksi' AND id_menu='$idMenu'");
$menu = $conn->query("SELECT * FROM menu WHERE id_menu='$idMenu'")->fetch_assoc();

if ($cekDetail->num_rows > 0) {
    $detail = $cekDetail->fetch_assoc();

    if ($detail['jumlah'] > 1) {
        $newJumlah = $detail['jumlah'] - 1;
        $newSubtotal = $newJumlah * $menu['harga_jual'];

        $conn->query("UPDATE detail_transaksi SET jumlah='$newJumlah', subtotal='$newSubtotal' WHERE id_transaksi='$idTransaksi' AND id_menu='$idMenu'");
        $conn->query("UPDATE menu SET stok = stok + 1 WHERE id_menu='$idMenu'");
    }
}

header("Location: transaksi.php");
exit;
?>