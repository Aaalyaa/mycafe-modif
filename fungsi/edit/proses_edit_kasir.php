<?php
session_start();
require "../../config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $id_user = $_POST["id_user"];
    $username = $_POST["username"];
    $password = $_POST["password"];

    $sql = "UPDATE user SET
        username = '$username',
        password = '$password'
        WHERE id_user = '$id_user'";

    if (mysqli_query($conn, $sql)) {
        header("Location: ../../kasir.php");
        exit;
    } else {
        echo "<div class='alert alert-danger'> Data Gagal disimpan.</div>";
    }
}
?>