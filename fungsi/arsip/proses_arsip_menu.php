<?php
include '../../config.php';

$id_menu = $_GET['id_menu'];
$status = $_GET['status'];

$query = "UPDATE menu SET status_menu = $status WHERE id_menu = $id_menu";

if (mysqli_query($conn, $query)) {
    header("Location: arsip_menu.php?pesan=sukses");
} else {
    echo "Gagal mengubah status menu.";
}
