<?php
require_once __DIR__ . "/../../../controllers/kelola-menu-controller.php";
$username = $_SESSION['username'];
$id_menu = $_GET["id_menu"];
$data = MenuController::getForm($id_menu);
$role = $_SESSION['peran'] ?? 'User';
$tanggal = date("l, d F Y");
$kategoriQuery = "SELECT * FROM kategori ORDER BY nama_kategori ASC";
$kategoriResult = mysqli_query($conn, $kategoriQuery);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Menu - Edit</title>
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
        <h2 class="title">Menu - Edit</h2>

        <a href="index.php?page=kelola-menu" class="btn back-link" role="button">← Kembali</a>

        <div class="form">
            <form action="index.php?page=proses-edit-menu" method="POST">
                <div class="form-group  my-3">
                    <label for="id-menu">ID Menu</label>
                    <input type="text" class="form-control" id="id-menu" name="id_menu"
                        value="<?php echo $data["id_menu"]; ?>" readonly>
                </div>
                <div class="form-group  my-3">
                    <label for="nama_menu">Nama Menu</label>
                    <input type="text" class="form-control" id="nama_menu" name="nama_menu"
                        value="<?php echo $data["nama_menu"]; ?>" required>
                </div>
                <div class="form-group my-3">
                    <label for="id_kategori">Kategori</label>
                    <select name="id_kategori" id="id_kategori" class="form-control" required>
                        <option value="">-- Pilih Kategori --</option>
                        <?php
                        while ($kategori = mysqli_fetch_assoc($kategoriResult)) {
                            $selected = $kategori['id_kategori'] == $data['id_kategori'] ? 'selected' : '';
                            echo "<option value='{$kategori['id_kategori']}' $selected>{$kategori['nama_kategori']}</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group my-3">
                    <label for="stok-minimal">Stok Minimal</label>
                    <input type="text" class="form-control" id="stok-minimal" name="stok_minimal"
                        value="<?php echo $data["stok_minimal"]; ?>" required>
                </div>
                <div class="form-group  my-3">
                    <label for="stok">Stok Saat Ini</label>
                    <input type="text" class="form-control" id="stok" name="stok" value="<?php echo $data["stok"]; ?>"
                        required>
                </div>
                <div class="form-group  my-3">
                    <label for="hpp">Harga Pokok</label>
                    <input type="text" class="form-control" id="hpp" name="hpp" value="<?php echo $data["hpp"]; ?>"
                        required>
                </div>
                <div class="form-group  my-3">
                    <label for="harga-jual">Harga Jual</label>
                    <input type="text" class="form-control" id="harga-jual" name="harga_jual"
                        value="<?php echo $data["harga_jual"]; ?>" readonly>
                </div>
                <div class="text-center mt-4">
                    <button type="submit" name="update" class="btn btn-submit">Edit</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>