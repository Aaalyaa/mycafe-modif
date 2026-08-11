<?php
include "includes/config.php";
include "includes/auth.php";
$username = $_SESSION['username'];
$tanggal = date("l, d F Y");
$role = $_SESSION['peran'] ?? 'User';
?>

<!DOCTYPE html>
<html>

<head>
    <title>Tambah Akun Kasir</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css"
        integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style-form.css">
</head>

<body>
    <nav class="navbar navbar-custom d-flex justify-content-between align-items-center">
        <div class="navbar-left">
            <?php echo $tanggal . " | " . $username . " (" . $role . ")"; ?>
        </div>
        <div class="navbar-right">
            <a href="index.php?page=logout" class="btn btn-logout"
                onclick="return confirm('Apakah kamu yakin ingin keluar dari website?')">Logout</a>
        </div>
    </nav>
    <div class="container mt-5 mb-5">
        <h2 class="title">Tambah Akun Kasir</h2>

        <a href="index.php?page=kelola-kasir" class="btn back-link" role="button">← Kembali ke Tabel</a>

        <div class="form">
            <form action="index.php?page=proses-tambah-kasir" method="POST">
                <div class="form-group
                    my-3">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
                <div class="form-group
                    my-3">
                    <label for="password">Password</label>
                    <input type="text" class="form-control" id="password" name="password" required>
                </div>
                <div class="text-center mt-4">
                    <button type="submit" name="tambah" class="btn btn-submit">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>