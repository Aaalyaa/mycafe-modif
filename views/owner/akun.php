<?php
require "includes/config.php";
require "includes/auth.php";
$username = $_SESSION['username'];
$tanggal = date("l, d F Y");
$adminQuery = "SELECT * FROM user WHERE username = '$username'";
$adminResult = mysqli_query($conn, $adminQuery);
$adminData = mysqli_fetch_assoc($adminResult);
?>
<!DOCTYPE html>
<html>

<head>
    <title>Owner - Akun</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css"
        integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style-info.css">
</head>

<body>
    <nav class="navbar navbar-custom d-flex justify-content-between align-items-center">
        <div class="navbar-left">
            <?php echo $tanggal; ?>
        </div>
        <div class="navbar-right">
            <a href="index.php?page=logout" class="btn btn-logout"
                onclick="return confirm('Apakah kamu yakin ingin keluar dari website?')">Logout</a>
        </div>
    </nav>
    <div class="wrapper-center">
        <div class="card mx-auto" style="max-width: 500px;">
            <div class="card-header text-center">
                Informasi Owner
            </div>
            <div class="card-body">
                <p><strong>ID User:</strong> <?php echo $adminData['id_user']; ?></p>
                <p><strong>Username:</strong> <?php echo $adminData['username']; ?></p>
                <p><strong>Password:</strong> <?php echo $adminData['password']; ?></p>

                <div class="text-center">
                    <a href="index.php?page=edit-owner&id_user=<?php echo $adminData['id_user']; ?>"
                        class="btn btn-edit">Edit</a>
                    <a href="index.php?page=dashboard-owner" class="btn btn-back">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>