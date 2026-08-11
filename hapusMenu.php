<?php
session_start();
include "config.php";

if (isset($_POST['search_menu'])) {
    $_SESSION['search_menu'] = $_POST['search_menu'];
}
if (isset($_POST['kategori_menu'])) {
    $_SESSION['kategori_menu'] = $_POST['kategori_menu'];
}

$idTransaksi = $_SESSION['id_transaksi'];
$idMenu = $_POST['id_menu'];

$sql = "SELECT * FROM detail_transaksi WHERE id_transaksi = '$idTransaksi' AND id_menu = '$idMenu'";
$result = $conn->query($sql);
$detail = $result->fetch_assoc();

if ($detail) {
    $jumlah = $detail['jumlah'];

    $conn->query("DELETE FROM detail_transaksi WHERE id_transaksi = '$idTransaksi' AND id_menu = '$idMenu'");
    $conn->query("UPDATE menu SET stok = stok + $jumlah WHERE id_menu = '$idMenu'");
}

header("Location: transaksi.php");
exit;
?>
