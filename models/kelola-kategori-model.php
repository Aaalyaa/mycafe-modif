<?php
require_once "includes/config.php";

class KategoriModel {
    public static function getById($id_kategori) {
        global $conn;
        $stmt = $conn->prepare("SELECT * FROM kategori WHERE id_kategori = ?");
        $stmt->bind_param("i", $id_kategori);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public static function update($id_kategori, $nama_kategori) {
        global $conn;
        $stmt = $conn->prepare("UPDATE kategori SET nama_kategori = ? WHERE id_kategori = ?");
        $stmt->bind_param("si", $nama_kategori, $id_kategori);
        return $stmt->execute();
    }

    public static function insert($nama_kategori) {
        global $conn;
        $stmt = $conn->prepare("INSERT INTO kategori (nama_kategori) VALUES (?)");
        $stmt->bind_param("s", $nama_kategori);
        return $stmt->execute();
    }

    public static function viewactive() {
        global $conn;
        $query = "SELECT * FROM kategori WHERE status_kategori = 1 ORDER BY id_kategori ASC";
        return $conn->query($query);
    }

    public static function viewinactive() {
        global $conn;
        $query = "SELECT * FROM kategori WHERE status_kategori = 0 ORDER BY id_kategori ASC";
        return $conn->query($query);
    }
}