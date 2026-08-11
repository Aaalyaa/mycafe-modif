<?php
require_once "includes/config.php";

class OwnerModel
{
    public static function getById($id_user)
    {
        global $conn;
        $stmt = $conn->prepare("SELECT * FROM user WHERE id_user = ?");
        $stmt->bind_param("i", $id_user);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public static function update($id_user, $username, $password)
    {
        global $conn;
        $stmt = $conn->prepare("UPDATE user SET username = ?, password = ? WHERE id_user = ?");
        $stmt->bind_param("ssi", $username, $password, $id_user);
        return $stmt->execute();

        if ($_SESSION['id_user'] == $id_user) {
            $_SESSION['username'] = $username;
        }
    }
}
