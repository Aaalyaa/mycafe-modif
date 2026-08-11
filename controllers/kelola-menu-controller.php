<?php
require_once __DIR__ . "/../models/kelola-menu-model.php";

class MenuController
{
    public static function getForm($id_menu)
    {
        return MenuModel::getById($id_menu);
    }

    public static function arsipMenu($id_menu, $status)
    {
        global $conn;

        $query = "UPDATE menu SET status_menu = ? WHERE id_menu = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "ii", $status, $id_menu);

        if (mysqli_stmt_execute($stmt)) {
            header("Location: index.php?page=arsip-menu");
            exit();
        } else {
            echo "Gagal mengarsipkan menu.";
        }
    }

    public static function editMenu($data)
    {
        $id_menu = $data["id_menu"];
        $nama_menu = $data["nama_menu"];
        $stok_minimal = $data["stok_minimal"];
        $stok = $data["stok"];
        $hpp = $data["hpp"];
        $id_kategori = $data["id_kategori"];

        if (MenuModel::update($id_menu, $nama_menu, $stok_minimal, $stok, $hpp, $id_kategori)) {
            header("Location: index.php?page=kelola-menu");
            exit();
        } else {
            echo "<script>alert('Menu gagal diedit!'); window.location.href='index.php?page=edit-menu';</script>";
        }
    }

    public static function tambahMenu($data)
    {
        $nama_menu = htmlspecialchars($data["nama_menu"]);
        $id_kategori = $data["id_kategori"];
        $stok_minimal = $data["stok_minimal"];
        $stok = $data["stok"];
        $hpp = $data["hpp"];

        if (MenuModel::insert($nama_menu, $id_kategori, $stok_minimal, $stok, $hpp)) {
            header("Location: index.php?page=kelola-menu");
        } else {
            echo "<script>alert('Kategori gagal ditambahkan!'); window.location.href='index.php?page=tambah-menu';</script>";
            exit;
        }
    }

    public static function getByAktif() {
        $kategori = $_GET['kategori'] ?? null;

        $result_kategori = MenuModel::getAllKategori();
        $result_menu = MenuModel::tampilMenu($kategori);

        include 'views/owner/kelola-menu.php';
    }

    public static function getByNonaktif() {
        $kategori = $_GET['kategori'] ?? null;

        $result_kategori = MenuModel::getAllKategori();
        $result_menu = MenuModel::tampilMenuArsip($kategori);

        include 'views/owner/arsip/arsip-menu.php';
    }
}
