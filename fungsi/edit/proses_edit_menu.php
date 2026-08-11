<?php
session_start();
require "../../config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $id_menu = $_POST["id_menu"];
    $nama_menu = $_POST["nama_menu"];
    $stok_minimal = $_POST["stok_minimal"];
    $stok = $_POST["stok"];
    $hpp = $_POST["hpp"];
    $id_kategori = $_POST["id_kategori"];


    if ($stok < $stok_minimal) {
        echo "<script>alert('Gagal menyimpan! Stok tidak boleh lebih kecil dari stok minimal.'); 
    window.location = 'edit_menu.php?id_menu=$id_menu';</script>";
        exit;
    }

    $sql = "UPDATE menu SET
        id_kategori = '$id_kategori',
        nama_menu = '$nama_menu',
        stok_minimal = $stok_minimal,
        stok = $stok,
        hpp = $hpp
        WHERE id_menu = '$id_menu'";

    if (mysqli_query($conn, $sql)) {
        header("Location: ../../menu.php");
        exit;
    } else {
        echo "<div class='alert alert-danger'> Data Gagal disimpan.</div>";
    }
}
?>