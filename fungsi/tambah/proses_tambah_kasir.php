<?php
session_start();
require "../../config.php";

if (isset($_POST['tambah'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "INSERT INTO user (username, password, peran) VALUES ('$username', '$password', 'Kasir')";
    $result = $conn->query($sql);

    if ($result) {
        echo "<script>alert('Data berhasil ditambahkan!'); window.location.href='../../kasir.php';</script>";
    } else {
        echo "<script>alert('Data gagal ditambahkan!'); window.location.href='../../kasir.php';</script>";
    }
}
?>