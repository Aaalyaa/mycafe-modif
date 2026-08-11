<?php
require_once __DIR__ . "/../models/kelola-kategori-model.php";

class KategoriController {
    public static function getForm($id_kategori)
    {
        return KategoriModel::getById($id_kategori);
    }

    public static function arsipKategori($id_kategori, $status) {
        global $conn;

        $query = "UPDATE kategori SET status_kategori = ? WHERE id_kategori = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "ii", $status, $id_kategori);

        if (mysqli_stmt_execute($stmt)) {
            header("Location: index.php?page=arsip-kategori");
            exit();
        } else {
            echo "<script>alert('Gagal mengarsipkan kategori ini.'); window.location.href='index.php?page=kelola-kategori';</script>";
        }
    }

    public static function editKategori($data) {
        $id_kategori = $data["id_kategori"];
        $nama_kategori = $data["nama_kategori"];

        if (KategoriModel::update($id_kategori, $nama_kategori)) {
            header("Location: index.php?page=kelola-kategori");
            exit();
        } else {
            echo "<script>alert('Kategori gagal diedit!'); window.location.href='index.php?page=kelola-kategori';</script>";
        }
    }

    public static function tambahKategori($data)
    {
        $nama_kategori = $data["nama_kategori"];

        if (KategoriModel::insert($nama_kategori)) {
            header("Location: index.php?page=kelola-kategori");
        } else {
            echo "<script>alert('Kategori gagal ditambahkan!'); window.location.href='index.php?page=tambah-kasir';</script>";
            exit;
        }
    }

    public static function getByAktif() {
        $result_kategori = KategoriModel::viewactive();

        include 'views/owner/kelola-kategori.php';
    }

    public static function getByNonaktif() {
        $result_kategori = KategoriModel::viewinactive();

        include 'views/owner/arsip/arsip-kategori.php';
    }
}