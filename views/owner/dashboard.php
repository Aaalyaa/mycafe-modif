<!DOCTYPE html>
<html>

<head>
    <title>Dashboard Owner</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css"
        integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style-owner.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <?php
    require "includes/config.php";
    require "includes/auth.php";
    $username = $_SESSION['username'];
    $tanggal_sekarang = date("l, d F Y");
    $role = $_SESSION['peran'] ?? 'User';
    $query = "SELECT DATE(tgl_transaksi) AS tanggal, 
                 SUM(total_harga) AS total
          FROM data_transaksi
          GROUP BY DATE(tgl_transaksi)
          ORDER BY tanggal DESC
          LIMIT 7";

    $result = mysqli_query($conn, $query);

    $tanggal = [];
    $total = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $tanggal[] = $row['tanggal'];
        $total[] = $row['total'];
    }
    ?>

    <nav class="navbar navbar-custom d-flex justify-content-between align-items-center">
        <div class="navbar-left">
            <?php echo $tanggal_sekarang . " | " . $username . " (" . $role . ")"; ?>
        </div>
        <div class="navbar-right">
            <a href="index.php?page=logout" class="btn btn-logout"
                onclick="return confirm('Apakah kamu yakin ingin keluar dari website?')">Logout</a>
        </div>
    </nav>

    <div class="container welcome-container mt-5 mb-5 text-center">
        <div class="header">
            <h2>Selamat Datang Di Dashboard Owner, <?php echo $username; ?>!</h2>
        </div>
    </div>
    <div class="container menu-container mt-5">
        <div class="header">
            <h3>Aksi Cepat</h3>
        </div>
        <div class="row">
            <div class="col-sm-6 col-md-4 mb-3">
                <div class="card card-menu p-3 shadow-sm">
                    <a href="index.php?page=kelola-menu">
                        <h5>📋 Kelola Menu</h5>
                    </a>
                </div>
            </div>
            <div class="col-sm-6 col-md-4 mb-3">
                <div class="card card-menu p-3 shadow-sm">
                    <a href="index.php?page=kelola-kategori">
                        <h5>📑 Kelola Kategori</h5>
                    </a>
                </div>
            </div>
            <div class="col-sm-6 col-md-4 mb-3">
                <div class="card card-menu p-3 shadow-sm">
                    <a href="index.php?page=lihat-laporan">
                        <h5>📊 Lihat Laporan Transaksi</h5>
                    </a>
                </div>
            </div>
            <div class="col-sm-6 col-md-4 mb-3">
                <div class="card card-menu p-3 shadow-sm">
                    <a href="index.php?page=kelola-kasir">
                        <h5>👤 Kelola Akun Kasir</h5>
                    </a>
                </div>
            </div>
            <div class="col-sm-6 col-md-4 mb-3">
                <div class="card card-menu p-3 shadow-sm">
                    <a href="index.php?page=owner-akun">
                        <h5>⚙️ Tentang Akun Anda</h5>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="container table-wrapper mt-5 mb-5">
        <div class="header">
            <h3>Daftar Menu Di bawah Stok Minimum</h3>
        </div>
        <table class="table table-bordered table-striped text-center">
            <thead>
                <tr>
                    <th>Nama Menu</th>
                    <th>Harga Jual (Rp)</th>
                    <th>Stok Saat Ini</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $menuQuery = "SELECT * FROM menu WHERE stok <= stok_minimal ORDER BY nama_menu ASC";
                $menuResult = mysqli_query($conn, $menuQuery);

                if ($menuResult && mysqli_num_rows($menuResult) > 0) {
                    while ($menu = mysqli_fetch_assoc($menuResult)) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($menu['nama_menu']) . "</td>";
                        echo "<td>Rp " . number_format($menu['harga_jual'], 0, ',', '.') . "</td>";
                        echo "<td>" . $menu['stok'] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='3' class='text-center'>Tidak ada menu di bawah stok minimum.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <div class="container table-wrapper mt-5 mb-5">
        <div class="header">
            <h3>Daftar Transaksi 7 Hari Terakhir</h3>
        </div>
        <table class="table table-bordered table-striped text-center">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Total Penjualan (Rp)</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach (array_reverse($tanggal) as $index => $tgl) {
                    echo "<tr>";
                    echo "<td>" . $tgl . "</td>";
                    echo "<td>Rp " . number_format($total[$index], 0, ',', '.') . "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <div class="container statistik-container mt-5 mb-5 text-center">
        <div class="header">
            <h3>Statistik Penjualan</h3>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="card card-statistik p-3 shadow-sm">
                    <h4>Total Penjualan 7 Hari Terakhir</h4>
                    <p>Rp <?= number_format(array_sum($total), 0, ',', '.'); ?>,-</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card card-statistik p-3 shadow-sm">
                    <h4>Jumlah Transaksi 7 Hari Terakhir</h4>
                    <p><?= count($tanggal); ?> Transaksi</p>
                </div>
            </div>
        </div>
    </div>
    <div class="container grafik-container mt-5 mb-5 text-center">
        <div class="header">
            <h3>Grafik Penjualan 7 Hari Terakhir</h3>
        </div>
        <canvas id="grafikPenjualan"></canvas>
    </div>

    <script>
        const ctx = document.getElementById('grafikPenjualan').getContext('2d');

        const chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?= json_encode(array_reverse($tanggal)) ?>,
                datasets: [{
                    label: 'Total Penjualan (Rp)',
                    data: <?= json_encode(array_reverse($total)) ?>,
                    backgroundColor: 'rgba(255, 252, 245, 0.5)',
                    borderColor: 'rgba(223, 174, 161, 1)',
                    borderWidth: 2
                }]
            },
            options: {
                plugins: {
                    legend: {
                        labels: {
                            color: '#fff6ee',
                            font: {
                                size: 14,
                                family: 'Poppins'
                            }
                        }
                    },
                    tooltip: {
                        backgroundColor: '#fefefe',
                        titleColor: '#333',
                        bodyColor: '#555',
                        borderColor: '#ccc',
                        borderWidth: 1
                    }
                },
                scales: {
                    x: {
                        ticks: {
                            color: '#fff6ee',
                            font: {
                                size: 12,
                                family: 'Poppins'
                            }
                        },
                        grid: {
                            color: '#a0765b'
                        }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            color: '#fff6ee',
                            callback: function (value) {
                                return 'Rp ' + value.toLocaleString();
                            }
                        },
                        grid: {
                            color: '#a0765b'
                        }
                    }
                }
            }
        });
    </script>
</body>

</html>