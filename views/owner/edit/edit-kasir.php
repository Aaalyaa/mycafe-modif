<?php
require_once __DIR__ . "/../../../controllers/kelola-kasir-controller.php";
$id_user = $_GET["id_user"];
$data = KasirController::editForm($id_user);
$username = $_SESSION['username'];
$tanggal = date("l, d F Y");
$role = $_SESSION['peran'] ?? 'User';
?>

<!DOCTYPE html>
<html>

<head>
    <title>Kasir - Edit Akun</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css"
        integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <link rel="stylesheet" href="/mycafe-modif/css/style-form.css">
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
        <h2 class="title">Edit Akun Kasir</h2>

        <a href="index.php?page=kelola-kasir" class="btn back-link" role="button">← Kembali</a>

        <div class="form">
            <form action="index.php?page=proses-edit-kasir" method="POST">
                <div class="form-group  my-3">
                    <label for="id_user">ID Kasir</label>
                    <input type="text" class="form-control" id="id_user" name="id_user"
                        value="<?php echo $data["id_user"]; ?>" readonly>
                </div>
                <div class="form-group  my-3">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" id="username" name="username"
                        value="<?php echo $data["username"]; ?>" required>
                </div>
                <div class="form-group  my-3">
                    <label for="password">Password</label>
                    <input type="text" class="form-control" id="password" name="password"
                        value="<?php echo $data["password"]; ?>" required>
                </div>
        </div>

        <div class="text-center mt-4">
            <button type="submit" name="update" class="btn btn-submit">Edit</button>
        </div>
        </form>
    </div>
    </div>
</body>

</html>