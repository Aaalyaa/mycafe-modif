<?php
    require "../../config.php";

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['tambah'])) {
        $nama_menu = htmlspecialchars($_POST["nama_menu"]);
        $id_kategori = $_POST["id_kategori"];
        $stok_minimal = $_POST["stok_minimal"];
        $stok = $_POST["stok"];
        $hpp = $_POST["hpp"];

        $sql = "INSERT INTO menu (id_kategori, nama_menu, stok_minimal, stok, hpp) 
        VALUES ($id_kategori, '$nama_menu', $stok_minimal, $stok, $hpp)";
        $hasil = mysqli_query($conn, $sql);

        if ($hasil) {
            header("Location: ../../menu.php");

        } else {
            echo "<div class='alert alert-danger'> Data Gagal ditambahkan.</div>";

        }
    }
?>