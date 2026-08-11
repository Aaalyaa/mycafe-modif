<?php
session_start();
include "config.php";

date_default_timezone_set('Asia/Jakarta');
$tgl = date("Y-m-d H:i:s");
$id_user = $_SESSION['id_user'];

$sql = "INSERT INTO data_transaksi (total_harga, bayar, kembali, tgl_transaksi, id_user) 
        VALUES (0, 0, 0, '$tgl', '$id_user')";
if ($conn->query($sql)) {
    $_SESSION['id_transaksi'] = $conn->insert_id;
    header("Location: transaksi.php");
    exit;
} else {
    die("Gagal buat transaksi: " . $conn->error);
}
