<?php
require_once "includes/config.php";

class LaporanModel
{
    public static function getByIdAll($id_transaksi)
    {
        global $conn;
        $stmt = $conn->prepare("SELECT 
        data_transaksi.id_transaksi, 
        data_transaksi.total_harga, 
        data_transaksi.bayar,
        data_transaksi.kembali,
        data_transaksi.tgl_transaksi, 
        user.username as kasir
        FROM data_transaksi 
        INNER JOIN user ON data_transaksi.id_user = user.id_user
        WHERE id_transaksi = ?");
        $stmt->bind_param("i", $id_transaksi);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public static function getByIdItem($id_transaksi)
    {
        global $conn;
        $stmt = $conn->prepare("SELECT 
            menu.nama_menu as menu,
            detail_transaksi.jumlah,
            detail_transaksi.subtotal
            FROM detail_transaksi 
            INNER JOIN menu ON detail_transaksi.id_menu = menu.id_menu
            WHERE id_transaksi = ?");
        $stmt->bind_param("i", $id_transaksi);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public static function tampilLaporan($start_date = null, $end_date = null, $id_user = null)
    {
        global $conn;
        $where = [];
        $params = [];
        $types = "";

        if ($start_date && $end_date) {
            $where[] = "data_transaksi.tgl_transaksi BETWEEN ? AND ?";
            $params[] = $start_date;
            $params[] = $end_date;
            $types .= "ss";
        }
        if ($id_user) {
            $where[] = "data_transaksi.id_user = ?";
            $params[] = $id_user;
            $types .= "i";
        }

        $whereSql = $where ? "WHERE " . implode(" AND ", $where) : "";
        $stmt = $conn->prepare("SELECT 
        data_transaksi.id_transaksi,
        data_transaksi.total_harga,
        data_transaksi.bayar,
        data_transaksi.kembali,
        data_transaksi.tgl_transaksi,
        user.username AS kasir
        FROM data_transaksi 
        INNER JOIN user ON data_transaksi.id_user = user.id_user
        $whereSql ORDER BY data_transaksi.tgl_transaksi DESC");

        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }
        $stmt->execute();
        return $stmt->get_result();
    }
}
