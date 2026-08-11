<?php
session_start();
include "config.php";

if (!isset($_POST['total_harga']) || !isset($_POST['bayar']) || !isset($_POST['kembali'])) {
    $_SESSION['error'] = "Data pembayaran tidak lengkap.";
    header("Location: transaksi.php");
    exit;
}

$idTransaksi = $_SESSION['id_transaksi'];
$total = $_POST['total_harga'];
$bayar = $_POST['bayar'];
$kembali = $_POST['kembali'];

if (!$idTransaksi) {
    die("ID transaksi tidak ditemukan dalam session.");
}

if ($bayar < $total) {
    $_SESSION['error'] = "Uang bayar tidak mencukupi total harga.";
    header("Location: transaksi.php");
    exit;
}

$update = "UPDATE data_transaksi 
           SET total_harga = '$total', bayar = '$bayar', kembali = '$kembali'
           WHERE id_transaksi = '$idTransaksi'";

if ($conn->query($update)) {
    unset($_SESSION['id_transaksi']);
    header("Location: detail.php?id_transaksi=$idTransaksi");
    exit;
} else {
    die("Gagal update transaksi: " . $conn->error);
}
?>
