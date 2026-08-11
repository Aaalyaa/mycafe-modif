<?php
require_once __DIR__ . "/../../../controllers/kelola-kategori-controller.php";
$id_kategori = $_GET["id_kategori"];
$data = KategoriController::getForm($id_kategori);
$username = $_SESSION['username'];
$tanggal = date("l, d F Y");
$role = $_SESSION['peran'] ?? 'User';
?>

<!DOCTYPE html>
<html>

<head>
    <title>Kategori - Edit</title>
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
        <h2 class="title">Kategori - Edit</h2>

        <a href="index.php?page=kelola-kategori" class="btn back-link" role="button">← Kembali</a>

        <div class="form">
            <form action="index.php?page=proses-edit-kategori" method="POST">
                <div class="form-group  my-3">
                    <label for="id-kategori">ID Kategori</label>
                    <input type="text" class="form-control" id="id-kategori" name="id_kategori"
                        value="<?php echo $data["id_kategori"]; ?>" readonly>
                </div>
                <div class="form-group  my-3">
                    <label for="nama-kategori">Nama Kategori</label>
                    <input type="text" class="form-control" id="nama-kategori" name="nama_kategori"
                        value="<?php echo $data["nama_kategori"]; ?>" required>
                </div>
                <div class="text-center mt-4">
                    <button type="submit" name="update" class="btn btn-submit">Edit</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>