<?php
require_once "includes/config.php";

class MenuModel {
    public static function getById($id_menu) {
        global $conn;
        $stmt = $conn->prepare("SELECT * FROM menu WHERE id_menu = ?");
        $stmt->bind_param("i", $id_menu);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public static function update($id_menu, $nama_menu, $stok_minimal, $stok, $hpp, $id_kategori) {
        global $conn;
        $stmt = $conn->prepare("UPDATE menu SET 
        id_kategori = ?, nama_menu = ?, stok_minimal = ?, stok = ?, hpp = ?
        WHERE id_menu = ?");
        $stmt->bind_param("isiiii", $id_kategori, $nama_menu, $stok_minimal, $stok, $hpp, $id_menu);
        return $stmt->execute();
    }

    public static function insert($nama_menu, $id_kategori, $stok_minimal, $stok, $hpp) {
        global $conn;
        $stmt = $conn->prepare("INSERT INTO menu (id_kategori, nama_menu, stok_minimal, stok, hpp) 
        VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("isiii", $id_kategori, $nama_menu, $stok_minimal, $stok, $hpp);
        return $stmt->execute();
    }

    public static function getAllKategori() {
        global $conn;
        $query = "SELECT * FROM kategori WHERE status_kategori = 1 ORDER BY nama_kategori ASC";
        return $conn->query($query);
    }

    public static function tampilMenu($kategori = null) {
        global $conn;
        $sql = "SELECT 
                    menu.id_menu, 
                    menu.nama_menu, 
                    kategori.nama_kategori AS kategori, 
                    menu.stok_minimal, 
                    menu.stok, 
                    menu.hpp, 
                    menu.harga_jual 
                FROM menu 
                INNER JOIN kategori ON menu.id_kategori = kategori.id_kategori 
                WHERE menu.status_menu = 1";

        if (!empty($kategori)) {
            $sql .= " AND menu.id_kategori = '$kategori'";
        }

        $sql .= " ORDER BY menu.id_menu ASC";
        return $conn->query($sql);
    }

    public static function tampilMenuArsip($kategori = null) {
        global $conn;
        $sql = "SELECT 
                    menu.id_menu, 
                    menu.nama_menu, 
                    kategori.nama_kategori AS kategori, 
                    menu.stok_minimal, 
                    menu.stok, 
                    menu.hpp, 
                    menu.harga_jual 
                FROM menu 
                INNER JOIN kategori ON menu.id_kategori = kategori.id_kategori 
                WHERE menu.status_menu = 0";

        if (!empty($kategori)) {
            $sql .= " AND menu.id_kategori = '$kategori'";
        }

        $sql .= " ORDER BY menu.id_menu ASC";
        return $conn->query($sql);
    }
}