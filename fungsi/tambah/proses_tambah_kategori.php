<?php
    require "../../config.php";

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['tambah'])) {
        $nama_kategori = htmlspecialchars($_POST["nama_kategori"]);

        $sql = "INSERT INTO kategori (nama_kategori) VALUES ('$nama_kategori')";
        $hasil = mysqli_query($conn, $sql);

        if ($hasil) {
            header("Location: ../../kategori.php");

        } else {
            echo "<div class='alert alert-danger'> Data Gagal ditambahkan.</div>";

        }
    }
?>