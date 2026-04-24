<?php

require_once __DIR__ . '/../models/Pengembalian.php';
require_once __DIR__ . '/../models/Peminjaman.php';

class PengembalianController
{
    private $pengembalianModel;
    private $peminjamanModel;

    public function __construct()
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header('Location: ' . App::BASE_URL . '/index.php?page=auth&action=login');
            exit;
        }
        $this->pengembalianModel = new Pengembalian();
        $this->peminjamanModel = new Peminjaman();
    }

    public function index()
    {
        $pengembalian = $this->pengembalianModel->getAllWithLateInfo();
        require_once __DIR__ . '/../views/pengembalian/index.php';
    }

    public function create()
    {
        $peminjamanAktif = $this->peminjamanModel->getActivePinjaman();
        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'peminjaman_id' => $_POST['peminjaman_id'] ?? '',
                'tanggal_pengembalian' => $_POST['tanggal_pengembalian'] ?? '',
                'denda' => $_POST['denda'] ?? 0,
                'keterangan' => trim($_POST['keterangan'] ?? '')
            ];

            if (empty($data['peminjaman_id']) || empty($data['tanggal_pengembalian'])) {
                $error = 'Peminjaman dan tanggal pengembalian harus diisi!';
            } else {
                // Hitung denda otomatis berdasarkan keterlambatan
                $hitungDenda = $this->pengembalianModel->calculateDenda(
                    $data['peminjaman_id'],
                    $data['tanggal_pengembalian'],
                    5000 // Denda per hari: Rp 5000
                );

                // Jika ada input denda manual, gunakan yang lebih besar
                $dendaInput = (int)$data['denda'];
                $data['denda'] = max($hitungDenda['denda'], $dendaInput);

                if ($this->pengembalianModel->create($data)) {
                    $_SESSION['flash_success'] = 'Pengembalian berhasil dicatat!';
                    if ($hitungDenda['hari_terlambat'] > 0) {
                        $_SESSION['flash_info'] = 'Peminjaman terlambat ' . $hitungDenda['hari_terlambat'] . ' hari. Denda otomatis: Rp ' . number_format($hitungDenda['denda'], 0, ',', '.');
                    }
                    header('Location: ' . App::BASE_URL . '/index.php?page=pengembalian');
                    exit;
                } else {
                    $error = 'Gagal mencatat pengembalian!';
                }
            }
        }

        require_once __DIR__ . '/../views/pengembalian/create.php';
    }

    public function delete()
    {
        $id = $_GET['id'] ?? null;
        if ($id) {
            if ($this->pengembalianModel->delete($id)) {
                $_SESSION['flash_success'] = 'Data pengembalian berhasil dihapus!';
            } else {
                $_SESSION['flash_error'] = 'Gagal menghapus data pengembalian!';
            }
        }
        header('Location: ' . App::BASE_URL . '/index.php?page=pengembalian');
        exit;
    }
}
