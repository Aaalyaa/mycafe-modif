<?php
include '../../config.php';

$id_kategori = $_GET['id_kategori'];
$status = $_GET['status'];

$query = "UPDATE kategori SET status_kategori = $status WHERE id_kategori = $id_kategori";

if (mysqli_query($conn, $query)) {
    header("Location: arsip_kategori.php?pesan=sukses");
} else {
    echo "Gagal mengubah status menu.";
}
?>