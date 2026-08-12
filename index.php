<?php
session_start();

$page = $_GET['page'] ?? 'login'; // set default ke login

switch ($page) {
    case 'login':
        require 'views/auth/login.php';
        break;

    case 'proses-login':
        require 'controllers/login-controller.php';
        break;

    case 'dashboard-owner':
        require 'views/owner/dashboard.php';
        break;

    case 'dashboard-kasir':
        require_once 'controllers/laporan-controller.php';
        LaporanController::getHistoriKasir();
        break;

    case 'owner-akun':
        require 'views/owner/akun.php';
        break;

    case 'kasir-akun':
        require 'views/kasir/akun.php';
        break;

    case 'edit-owner':
        require 'views/owner/edit/edit-owner.php';
        break;

    case 'proses-edit-owner':
        require_once 'controllers/kelola-owner-controller.php';
        OwnerController::updateOwner($_POST);
        break;

    case 'kelola-kasir':
        require_once 'controllers/kelola-kasir-controller.php';
        KasirController::getByAktif();
        break;

    case 'arsip-kasir':
        require_once 'controllers/kelola-kasir-controller.php';
        KasirController::getByNonaktif();
        break;

    case 'proses-arsip-kasir':
        require_once 'controllers/kelola-kasir-controller.php';
        KasirController::updateStatusKasir($_GET['id_user'], $_GET['status']);
        break;

    case 'edit-kasir':
        require 'views/owner/edit/edit-kasir.php';
        break;

    case 'proses-edit-kasir':
        require_once 'controllers/kelola-kasir-controller.php';
        KasirController::updateKasir($_POST);
        break;

    case 'tambah-kasir':
        require 'views/owner/tambah/tambah-kasir.php';
        break;

    case 'proses-tambah-kasir':
        require_once 'controllers/kelola-kasir-controller.php';
        KasirController::tambahKasir($_POST);
        break;

    case 'kelola-kategori':
        require_once 'controllers/kelola-kategori-controller.php';
        KategoriController::getByAktif();
        break;

    case 'arsip-kategori':
        require_once 'controllers/kelola-kategori-controller.php';
        KategoriController::getByNonaktif();
        break;

    case 'proses-arsip-kategori':
        require 'controllers/kelola-kategori-controller.php';
        KategoriController::arsipKategori($_GET['id_kategori'], $_GET['status']);
        break;

    case 'edit-kategori':
        require 'views/owner/edit/edit-kategori.php';
        break;

    case 'proses-edit-kategori':
        require_once 'controllers/kelola-kategori-controller.php';
        KategoriController::editKategori($_POST);
        break;

    case 'tambah-kategori':
        require 'views/owner/tambah/tambah-kategori.php';
        break;

    case 'proses-tambah-kategori':
        require_once 'controllers/kelola-kategori-controller.php';
        KategoriController::tambahKategori($_POST);
        break;

    case 'kelola-menu':
        require_once 'controllers/kelola-menu-controller.php';
        MenuController::getByAktif();
        break;

    case 'arsip-menu':
        require_once 'controllers/kelola-menu-controller.php';
        MenuController::getByNonaktif();
        break;

    case 'proses-arsip-menu':
        require 'controllers/kelola-menu-controller.php';
        MenuController::arsipMenu($_GET['id_menu'], $_GET['status']);
        break;

    case 'edit-menu':
        require 'views/owner/edit/edit-menu.php';
        break;

    case 'proses-edit-menu':
        require_once 'controllers/kelola-menu-controller.php';
        MenuController::editMenu($_POST);
        break;

    case 'tambah-menu':
        require 'views/owner/tambah/tambah-menu.php';
        break;

    case 'proses-tambah-menu':
        require_once 'controllers/kelola-menu-controller.php';
        MenuController::tambahMenu($_POST);
        break;
    
    case 'lihat-laporan':
        require_once 'controllers/laporan-controller.php';
        LaporanController::getLaporan();
        break;

    case 'detail-owner':
        require 'views/owner/detail-transaksi-owner.php';
        break;

    case 'logout':
        session_unset();
        session_destroy();
        header("Location: index.php?page=login");
        break;

    default:
        echo "Halaman tidak ditemukan";
}
