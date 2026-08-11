<?php
require_once "includes/config.php";

class KasirModel {
    public static function getById($id_user) {
        global $conn;
        $stmt = $conn->prepare("SELECT * FROM user WHERE id_user = ?");
        $stmt->bind_param("i", $id_user);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public static function update($id_user, $username, $password) {
        global $conn;
        $stmt = $conn->prepare("UPDATE user SET username = ?, password = ? WHERE id_user = ?");
        $stmt->bind_param("ssi", $username, $password, $id_user);
        return $stmt->execute();
    }

    public static function insert($username, $password, $peran) {
        global $conn;
        $stmt = $conn->prepare("INSERT INTO user (username, password, peran) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $password, $peran);
        return $stmt->execute();
    }

    public static function viewactive() {
        global $conn;
        $query = "SELECT * FROM user WHERE peran = 'Kasir' AND status_user = 1";
        return $conn->query($query);
    }

    public static function viewinactive() {
        global $conn;
        $query = "SELECT * FROM user WHERE peran = 'Kasir' AND status_user = 0";
        return $conn->query($query);
    }
}