<?php
include '../../config.php';

$id_user = $_GET['id_user'];
$status = $_GET['status'];

$query = "UPDATE user SET status_user = $status WHERE id_user = $id_user";

if (mysqli_query($conn, $query)) {
    header("Location: arsip_kasir.php?pesan=sukses");
} else {
    echo "Gagal mengubah status menu.";
}
?>