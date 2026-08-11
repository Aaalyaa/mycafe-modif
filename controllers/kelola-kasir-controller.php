<?php
require_once __DIR__ . "/../models/kelola-kasir-model.php";

class KasirController
{
    public static function editForm($id_user)
    {
        return KasirModel::getById($id_user);
    }

    public static function updateStatusKasir($id_user, $status) {
        global $conn;

        $query = "UPDATE user SET status_user = ? WHERE id_user = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "ii", $status, $id_user);

        if (mysqli_stmt_execute($stmt)) {
            header("Location: index.php?page=arsip-kasir");
            exit();
        } else {
            echo "Gagal mengubah status user.";
        }
    }

    public static function updateKasir($data)
    {
        $id_user = $data["id_user"];
        $username = $data["username"];
        $password = $data["password"];

        if (KasirModel::update($id_user, $username, $password)) {
            header("Location: index.php?page=kelola-kasir");
            exit;
        } else {
            echo "<script>alert('Data kasir gagal diedit!'); window.location.href='index.php?page=edit-kasir';</script>";
            exit;
        }
    }

    public static function tambahKasir($data)
    {
        $username = $data["username"];
        $password = $data["password"];
        $peran = 'Kasir';

        if (KasirModel::insert($username, $password, $peran)) {
            header("Location: index.php?page=kelola-kasir");
        } else {
            echo "<script>alert('Data kasir gagal ditambahkan!'); window.location.href='index.php?page=tambah-kasir';</script>";
            exit;
        }
    }

    public static function getByAktif() {
        $result_user = KasirModel::viewactive();

        include 'views/owner/kelola-kasir.php';
    }

    public static function getByNonaktif() {
        $result_user = KasirModel::viewinactive();

        include 'views/owner/arsip/arsip-kasir.php';
    }
}
