<?php
session_start();
include "config.php";

$idTransaksi = $_SESSION['id_transaksi'];
$sql = "delete from data_transaksi where id_transaksi='$idTransaksi' ";
$hasil = mysqli_query($conn, $sql);

if ($hasil) {
    unset($_SESSION['id_transaksi']);

    header("Location: homepage-kasir.php");
    echo "<div class='alert alert-success'> Data Berhasil dihapus.</div>";
} else {
    echo "<div class='alert alert-danger'> Data Gagal dihapus.</div>";
}
exit;
?>