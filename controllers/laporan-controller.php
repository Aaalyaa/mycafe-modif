<?php
require_once __DIR__ . "/../models/laporan-model.php";

class LaporanController
{
    public static function getDetail($id_transaksi)
    {
        return LaporanModel::getByIdAll($id_transaksi);
    }

    public static function getItem($id_transaksi)
    {
        return LaporanModel::getByIdItem($id_transaksi);
    }

    public static function getLaporan()
    {
        $start_date = $_GET['start_date'] ?? null;
        $end_date = $_GET['end_date'] ?? null;

        $result = LaporanModel::tampilLaporan($start_date, $end_date);

        include 'views/owner/laporan-transaksi.php';
    }

    public static function getHistoriKasir()
    {
        $start_date = $_GET['start_date'] ?? null;
        $end_date = $_GET['end_date'] ?? null;
        $id_user = $_SESSION['id_user'] ?? null;

        $result = LaporanModel::tampilLaporan($start_date, $end_date, $id_user);

        include 'views/kasir/dashboard.php';
    }
}
