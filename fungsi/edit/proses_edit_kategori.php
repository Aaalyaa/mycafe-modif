<?php
session_start();
require "../../config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $id_kategori = $_POST["id_kategori"];
    $nama_kategori = $_POST["nama_kategori"];

    $sql = "UPDATE kategori SET
        nama_kategori = '$nama_kategori'
        WHERE id_kategori = $id_kategori";

    if (mysqli_query($conn, $sql)) {
        header("Location: ../../kategori.php");
        exit;
    } else {
        echo "<div class='alert alert-danger'> Data Gagal disimpan.</div>";
    }
}
?>