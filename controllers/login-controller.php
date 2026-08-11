<?php
session_start();
require "./includes/config.php"; // Menghubungkan ke database

$username = $_POST["username"];
$password = $_POST["password"];

$query = mysqli_query($conn, "SELECT * FROM user 
WHERE username='$username' AND password='$password' AND status_user = 1"); // fungsi mysqli untuk mengambil data user yang aktif
$cek = mysqli_num_rows($query); // Mengecek apakah ada data yang sesuai dengan username dan password yang dimasukkan

if($cek > 0){
    $data = mysqli_fetch_assoc($query); // Mengambil data user yang sesuai
        $_SESSION['username'] = $username; // Menyimpan username ke session
        $_SESSION['id_user'] = $data['id_user'];
        $_SESSION['peran'] = $data['peran'];
        $_SESSION['status_user'] = $data['status_user'];
        $_SESSION['login'] = true;

        if ($data['peran'] == "Owner") {
            header("location:index.php?page=dashboard-owner");
        } else if ($data['peran'] == "Kasir") {
            header("location:index.php?page=dashboard-kasir");
        }
} else {
    echo "<script>alert('Username atau Password salah!'); window.location = 'index.php?page=login';</script>";
}