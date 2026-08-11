<?php
require_once __DIR__ . "/../models/kelola-owner-model.php";

class OwnerController {
    public static function editForm($id_user)
    {
        return OwnerModel::getById($id_user);
    }

    public static function updateOwner($postData) {
        $id_user = $postData["id_user"];
        $username = $postData["username"];
        $password = $postData["password"];

        if (OwnerModel::update($id_user, $username, $password)) {
            header("Location: index.php?page=owner-akun&pesan=sukses");
            exit;
        } else {
            header("Location: index.php?page=owner-akun&pesan=gagal");
            exit;
        }
    }
}