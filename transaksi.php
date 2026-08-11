<!DOCTYPE html>
<html>

<head>
    <title>Transaksi</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css"
        integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <link rel="icon" href="img/favicon.png">
    <link rel="stylesheet" href="css/style-transaksi.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <?php
    include "config.php";
    include "auth.php";

    date_default_timezone_set('Asia/Jakarta');

    $id_user = $_SESSION['id_user'];
    $idTransaksi = $_SESSION['id_transaksi'];
    $tanggal = date("l, d F Y");
    $nama = $_SESSION['username'] ?? 'Guest';
    $role = $_SESSION['peran'] ?? 'User';
    $searchValue = '';
    $kategoriValue = '';
    $menuResult = null;
    $showTable = false;

    if (isset($_SESSION['search_menu'])) {
        $_POST['search_menu'] = $_SESSION['search_menu'];
        unset($_SESSION['search_menu']);
    }
    if (isset($_SESSION['kategori_menu'])) {
        $_POST['kategori_menu'] = $_SESSION['kategori_menu'];
        unset($_SESSION['kategori_menu']);
    }

    if (isset($_POST['reset_menu'])) {
        $searchValue = '';
        $kategoriValue = '';
        $showTable = false;
    } elseif (isset($_POST['search_menu']) || isset($_POST['kategori_menu'])) {
        $searchValue = $_POST['search_menu'];
        $kategoriValue = $_POST['kategori_menu'];
        $kategori = mysqli_real_escape_string($conn, $kategoriValue);
        $cari = mysqli_real_escape_string($conn, $searchValue);
        $query = "SELECT m.*, k.nama_kategori FROM menu m 
        JOIN kategori k 
        ON m.id_kategori = k.id_kategori 
        WHERE m.status_menu = 1";

        if ($searchValue !== '' && $kategoriValue !== '') {
            $query .= " AND nama_menu LIKE '%$cari%' AND m.id_kategori = '$kategori'";
        } elseif ($searchValue !== '') {
            $query .= " AND nama_menu LIKE '%$cari%'";
        } elseif ($kategoriValue !== '') {
            $query .= " AND m.id_kategori = '$kategori'";
        }

        $menuResult = $conn->query($query);
        $showTable = true;
    } else {
        $showTable = false;
    }

    $latestTransaksi = $conn->query("SELECT * FROM data_transaksi WHERE id_user = '$id_user' ORDER BY tgl_transaksi DESC LIMIT 1");
    ?>

    <nav class="navbar navbar-custom d-flex justify-content-between align-items-center">
        <div class="navbar-left">
            <?php echo $tanggal . " | " . $nama . " (" . $role . ")"; ?>
            | Transaksi ID: <?= $idTransaksi ?>
        </div>
        <div class="navbar-right">
            <!-- <a href="cancel-transaksi.php" class="btn btn-out btn-sm"
                onclick="return confirm('Apakah kamu yakin ingin membatalkan transaksi ini?')">Batalkan transaksi &
                kembali</a> -->
        </div>
    </nav>

    <div class="card-body">
        <h4>Daftar Menu</h4>
        <form method="POST" class="form-inline mb-3">
            <input type="text" name="search_menu" class="form-control mr-2"
                value="<?= htmlspecialchars($searchValue) ?>" placeholder="Ketik nama menu...">

            <select name="kategori_menu" class="form-control mr-2">
                <option value="">-- Semua Kategori --</option>
                <?php
                $kategoriQuery = $conn->query("
        SELECT DISTINCT k.id_kategori, k.nama_kategori 
        FROM kategori k 
        JOIN menu m ON k.id_kategori = m.id_kategori 
        WHERE m.status_menu = 1 AND k.status_kategori = 1
    ");

                while ($row = $kategoriQuery->fetch_assoc()):
                    $selected = ($kategoriValue == $row['id_kategori']) ? 'selected' : '';
                    echo "<option value='{$row['id_kategori']}' $selected>{$row['nama_kategori']}</option>";
                endwhile;
                ?>
            </select>

            <button type="submit" name="cari" class="btn btn-cari mr-2">Cari</button>
            <button type="submit" name="reset_menu" class="btn btn-reset">Reset</button>
        </form>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nama Menu</th>
                    <th>Harga Jual</th>
                    <th>Stok Saat Ini</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($menuResult && $menuResult->num_rows > 0):
                    while ($menu = $menuResult->fetch_assoc()):
                        ?>
                        <tr>
                            <td><?= $menu['nama_menu'] ?></td>
                            <td>Rp <?= number_format($menu['harga_jual'], 0, ',', '.'); ?>,-</td>
                            <td><?= $menu['stok'] ?></td>
                            <td>
                                <?php if ($menu['stok'] > 0): ?>
                                    <form method="POST" action="addMenu.php" style="display:inline;">
                                        <input type="hidden" name="id_menu" value="<?= $menu['id_menu'] ?>">
                                        <input type="hidden" name="search_menu" value="<?= htmlspecialchars($searchValue) ?>">
                                        <input type="hidden" name="kategori_menu" value="<?= htmlspecialchars($kategoriValue) ?>">
                                        <button type="submit" class="btn btn-sm btn-add">Tambah</button>
                                    </form>
                                <?php else: ?>
                                    <span class="text-light">Stok tidak mencukupi</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php elseif ($showTable): ?>
                    <tr>
                        <td colspan="4" class="text-center text-black">Menu tersebut tidak tersedia.</td>
                    </tr>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="text-center text-empty">Masukkan menu yang tersedia!</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="card-body">
        <h4>Daftar Pesanan</h4>
        <table class="table table-bordered">
            <tr>
                <th>ID Menu</th>
                <th>Nama Menu</th>
                <th>Jumlah</th>
                <th>Subtotal</th>
                <th>Aksi</th>
            </tr>
            <?php
            $detail = $conn->query("SELECT dt.*, m.nama_menu FROM detail_transaksi dt 
                            JOIN menu m ON dt.id_menu = m.id_menu 
                            WHERE id_transaksi = '$idTransaksi'");
            $total = 0;

            while ($item = $detail->fetch_assoc()):
                $total += $item['subtotal'];
                ?>
                <tr>
                    <td><?= $item['id_menu'] ?></td>
                    <td><?= $item['nama_menu'] ?></td>
                    <td><?= $item['jumlah'] ?></td>
                    <td>Rp <?= number_format($item['subtotal'], 0, ',', '.'); ?>,-</td>
                    <td>
                        <?php if ($item['jumlah'] > 1): ?>
                            <form method="POST" action="kurangi.php" style="display:inline;">
                                <input type="hidden" name="id_menu" value="<?= $item['id_menu'] ?>">
                                <input type="hidden" name="search_menu" value="<?= htmlspecialchars($searchValue) ?>">
                                <input type="hidden" name="kategori_menu" value="<?= htmlspecialchars($kategoriValue) ?>">
                                <button type="submit" class="btn btn-sm btn-decrease">Kurangi</button>
                            </form>
                        <?php endif; ?>
                        <form method="POST" action="hapusMenu.php" style="display:inline;">
                            <input type="hidden" name="id_menu" value="<?= $item['id_menu'] ?>">
                            <input type="hidden" name="search_menu" value="<?= htmlspecialchars($searchValue) ?>">
                            <input type="hidden" name="kategori_menu" value="<?= htmlspecialchars($kategoriValue) ?>">
                            <button type="submit" class="btn btn-sm btn-delete">Batal</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
            <tr>
                <td colspan="3"><strong>Total</strong></td>
                <td colspan="2"><strong>Rp <?= number_format($total, 0, ',', '.') ?>,-</strong></td>
            </tr>
        </table>
    </div>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?= $_SESSION['error'];
        unset($_SESSION['error']); ?></div>
    <?php endif; ?>
    <form action="simpanTransaksi.php" method="POST" class="form-bayar">
        <input type="hidden" name="total_harga" id="total_harga" value="<?= $total ?>">

        <div class="form-row mb-2">
            <input type="number" name="bayar" id="bayar" class="form-pembayaran mr-2" required placeholder="Uang Bayar">
            <input type="number" name="kembali" id="kembali" class="form-kembalian" readonly placeholder="Uang Kembali">
        </div>

        <div class="form-row">
            <button type="submit" class="btn btn-done">Bayar</button>
        </div>
    </form>

    <script>
        document.getElementById('bayar').addEventListener('input', function () {
            const total = parseInt(document.getElementById('total_harga').value) || 0;
            const bayar = parseInt(this.value) || 0;
            const kembali = bayar - total;

            document.getElementById('kembali').value = kembali >= 0 ? kembali : 0;
        });

        document.querySelector('.form-bayar').addEventListener('submit', function (e) {
            const total = parseInt(document.getElementById('total_harga').value) || 0;
            const bayar = parseInt(document.getElementById('bayar').value) || 0;

            if (bayar < total) {
                alert("Uang bayar tidak boleh kurang dari total transaksi!");
                e.preventDefault();
            }
        });
    </script>

</body>

</html>