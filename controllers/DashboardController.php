<?php

require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Buku.php';
require_once __DIR__ . '/../models/Kategori.php';
require_once __DIR__ . '/../models/Peminjaman.php';
require_once __DIR__ . '/../models/Pengembalian.php';

class DashboardController
{
    public function __construct()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . App::BASE_URL . '/index.php?page=auth&action=login');
            exit;
        }
    }

    public function index()
    {
        $role = $_SESSION['role'];

        if ($role === 'admin') {
            $this->admin();
        } else {
            $this->siswa();
        }
    }

    public function admin()
    {
        if ($_SESSION['role'] !== 'admin') {
            header('Location: ' . App::BASE_URL . '/index.php?page=dashboard');
            exit;
        }

        $userModel = new User();
        $bukuModel = new Buku();
        $kategoriModel = new Kategori();
        $peminjamanModel = new Peminjaman();
        $pengembalianModel = new Pengembalian();

        $totalSiswa = $userModel->countSiswa();
        $totalBuku = $bukuModel->count();
        $totalKategori = $kategoriModel->count();
        $totalPeminjaman = $peminjamanModel->count();
        $totalPeminjamanAktif = $peminjamanModel->countActive();
        $totalPengembalian = $pengembalianModel->count();
        $peminjamanAktif = $peminjamanModel->getActivePinjaman();
        
        // Ambil data peminjaman yang terlambat
        $peminjamanBelumDikembalikan = $pengembalianModel->getPeminjamanBelumDikembalikan();
        $peminjamanTerlambat = array_filter($peminjamanBelumDikembalikan, fn($p) => $p->hari_terlambat > 0);
        $totalDendaTerhitung = array_sum(array_column($peminjamanTerlambat, 'estimasi_denda'));

        require_once __DIR__ . '/../views/dashboard/admin.php';
    }

    public function siswa()
    {
        if ($_SESSION['role'] !== 'siswa') {
            header('Location: ' . App::BASE_URL . '/index.php?page=dashboard');
            exit;
        }

        $peminjamanModel = new Peminjaman();
        $peminjamanSaya = $peminjamanModel->getByUserId($_SESSION['user_id']);

        require_once __DIR__ . '/../views/dashboard/siswa.php';
    }
}
