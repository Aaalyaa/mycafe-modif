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
    <title>Informasi Akun Kasir</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css"
        integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style-table.css">
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
    <div class="header mt-4 text-center">
        <h2 align="center">Informasi Akun Kasir</h2>
    </div>
    <div class="container table-wrapper mb-4">
        <div class="row mt-4 mb-3 align-items-center">
            <div class="col-md-6">
                <a href="index.php?page=dashboard-owner" class="btn btn-kembali">Kembali</a>
            </div>
            <div class="col-md-6 text-right">
                <a href="index.php?page=arsip-kasir" class="btn btn-arsip mb-2" role="button">Lihat Arsip</a>
                <a href="index.php?page=tambah-kasir" class="btn btn-tambah mb-2 ml-2" role="button">+ Buat Akun
                    Kasir</a>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-hover text-center">
                <thead>
                    <tr>
                        <th>ID Kasir</th>
                        <th>Username</th>
                        <th>Password</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <?php
                while ($data = $result_user->fetch_assoc()) {
                    ?>

                    <tbody>
                        <tr>
                            <td><?php echo $data["id_user"]; ?></td>
                            <td><?php echo $data["username"]; ?></td>
                            <td><?php echo $data["password"]; ?></td>
                            <td class="action-buttons">
                                <div class="btn-actions">
                                    <a href="index.php?page=edit-kasir&id_user=<?php echo $data["id_user"]; ?>"
                                        class="btn btn-sm btn-edit mr-2">Edit</a>
                                    <a href="index.php?page=proses-arsip-kasir&id_user=<?= $data['id_user'] ?>&status=0"
                                        class="btn btn-status btn-sm">Nonaktifkan</a>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                    <?php
                }
                ?>
            </table>
        </div>
    </div>
</body>

</html>