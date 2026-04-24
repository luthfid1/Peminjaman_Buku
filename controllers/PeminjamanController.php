<?php

require_once __DIR__ . '/../models/Peminjaman.php';
require_once __DIR__ . '/../models/Buku.php';
require_once __DIR__ . '/../models/User.php';

class PeminjamanController
{
    private $peminjamanModel;
    private $bukuModel;
    private $userModel;

    public function __construct()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . App::BASE_URL . '/index.php?page=auth&action=login');
            exit;
        }
        $this->peminjamanModel = new Peminjaman();
        $this->bukuModel = new Buku();
        $this->userModel = new User();
    }

    public function index()
    {
        if ($_SESSION['role'] === 'admin') {
            $peminjaman = $this->peminjamanModel->getAllWithLateInfo();
        } else {
            $peminjaman = $this->peminjamanModel->getByUserId($_SESSION['user_id']);
        }
        require_once __DIR__ . '/../views/peminjaman/index.php';
    }

    // Siswa mengajukan peminjaman
    public function ajukan()
    {
        if ($_SESSION['role'] !== 'siswa') {
            header('Location: ' . App::BASE_URL . '/index.php?page=peminjaman');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'user_id' => $_SESSION['user_id'],
                'buku_id' => $_POST['buku_id'] ?? '',
                'tanggal_pinjam' => $_POST['tanggal_pinjam'] ?? '',
                'tanggal_kembali' => $_POST['tanggal_kembali'] ?? ''
            ];

            if (empty($data['buku_id']) || empty($data['tanggal_pinjam']) || empty($data['tanggal_kembali'])) {
                $_SESSION['flash_error'] = 'Semua field harus diisi!';
            } elseif (strtotime($data['tanggal_pinjam']) < strtotime(date('Y-m-d'))) {
                $_SESSION['flash_error'] = 'Tanggal pinjam tidak boleh kurang dari hari ini!';
            } else {
                // Cek stok buku
                $bukuItem = $this->bukuModel->getById($data['buku_id']);
                if ($bukuItem && $bukuItem->jumlah_stok <= 0) {
                    $_SESSION['flash_error'] = 'Stok buku habis!';
                } else if ($bukuItem && strtotime($data['tanggal_kembali']) <= strtotime($data['tanggal_pinjam'])) {
                    $_SESSION['flash_error'] = 'Tanggal kembali harus lebih besar dari tanggal pinjam!';
                } else {
                    if ($this->peminjamanModel->create($data)) {
                        $_SESSION['flash_success'] = 'Permintaan peminjaman berhasil diajukan! Admin akan memproses dalam 1-2 hari kerja.';
                    } else {
                        $_SESSION['flash_error'] = 'Gagal mengajukan peminjaman!';
                    }
                }
            }
        }
        
        header('Location: ' . App::BASE_URL . '/index.php?page=buku&action=daftar');
        exit;
    }

    public function create()
    {
        if ($_SESSION['role'] !== 'admin') {
            header('Location: ' . App::BASE_URL . '/index.php?page=peminjaman');
            exit;
        }

        $buku = $this->bukuModel->getAll();
        $siswa = $this->userModel->getAllSiswa();
        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'user_id' => $_POST['user_id'] ?? '',
                'buku_id' => $_POST['buku_id'] ?? '',
                'tanggal_pinjam' => $_POST['tanggal_pinjam'] ?? '',
                'tanggal_kembali' => $_POST['tanggal_kembali'] ?? ''
            ];

            if (empty($data['user_id']) || empty($data['buku_id']) || empty($data['tanggal_pinjam']) || empty($data['tanggal_kembali'])) {
                $error = 'Semua field harus diisi!';
            } elseif (strtotime($data['tanggal_pinjam']) < strtotime(date('Y-m-d'))) {
                $error = 'Tanggal pinjam tidak boleh kurang dari hari ini!';
            } else {
                // Cek stok buku
                $bukuItem = $this->bukuModel->getById($data['buku_id']);
                if ($bukuItem && $bukuItem->jumlah_stok <= 0) {
                    $error = 'Stok buku habis!';
                } else {
                    if ($this->peminjamanModel->create($data)) {
                        $_SESSION['flash_success'] = 'Peminjaman berhasil ditambahkan!';
                        header('Location: ' . App::BASE_URL . '/index.php?page=peminjaman');
                        exit;
                    } else {
                        $error = 'Gagal menambahkan peminjaman!';
                    }
                }
            }
        }

        require_once __DIR__ . '/../views/peminjaman/create.php';
    }

    public function edit()
    {
        if ($_SESSION['role'] !== 'admin') {
            header('Location: ' . App::BASE_URL . '/index.php?page=peminjaman');
            exit;
        }

        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: ' . App::BASE_URL . '/index.php?page=peminjaman');
            exit;
        }

        $peminjaman_item = $this->peminjamanModel->getById($id);
        if (!$peminjaman_item) {
            header('Location: ' . App::BASE_URL . '/index.php?page=peminjaman');
            exit;
        }

        $buku = $this->bukuModel->getAll();
        $siswa = $this->userModel->getAllSiswa();
        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'user_id' => $_POST['user_id'] ?? '',
                'buku_id' => $_POST['buku_id'] ?? '',
                'tanggal_pinjam' => $_POST['tanggal_pinjam'] ?? '',
                'tanggal_kembali' => $_POST['tanggal_kembali'] ?? '',
                'status' => $_POST['status'] ?? 'dipinjam'
            ];

            if (empty($data['user_id']) || empty($data['buku_id']) || empty($data['tanggal_pinjam']) || empty($data['tanggal_kembali'])) {
                $error = 'Semua field harus diisi!';
            } else {
                if ($this->peminjamanModel->update($id, $data)) {
                    $_SESSION['flash_success'] = 'Peminjaman berhasil diupdate!';
                    header('Location: ' . App::BASE_URL . '/index.php?page=peminjaman');
                    exit;
                } else {
                    $error = 'Gagal mengupdate peminjaman!';
                }
            }
        }

        require_once __DIR__ . '/../views/peminjaman/edit.php';
    }

    public function delete()
    {
        if ($_SESSION['role'] !== 'admin') {
            header('Location: ' . App::BASE_URL . '/index.php?page=peminjaman');
            exit;
        }

        $id = $_GET['id'] ?? null;
        if ($id) {
            if ($this->peminjamanModel->delete($id)) {
                $_SESSION['flash_success'] = 'Peminjaman berhasil dihapus!';
            } else {
                $_SESSION['flash_error'] = 'Gagal menghapus peminjaman!';
            }
        }
        header('Location: ' . App::BASE_URL . '/index.php?page=peminjaman');
        exit;
    }

    // Approve peminjaman dari siswa
    public function approve()
    {
        if ($_SESSION['role'] !== 'admin') {
            header('Location: ' . App::BASE_URL . '/index.php?page=peminjaman');
            exit;
        }

        $id = $_GET['id'] ?? null;
        if ($id) {
            if ($this->peminjamanModel->updateStatus($id, 'dipinjam')) {
                $_SESSION['flash_success'] = 'Peminjaman berhasil disetujui!';
            } else {
                $_SESSION['flash_error'] = 'Gagal menyetujui peminjaman!';
            }
        }
        header('Location: ' . App::BASE_URL . '/index.php?page=peminjaman');
        exit;
    }

    // Tolak peminjaman dari siswa
    public function reject()
    {
        if ($_SESSION['role'] !== 'admin') {
            header('Location: ' . App::BASE_URL . '/index.php?page=peminjaman');
            exit;
        }

        $id = $_GET['id'] ?? null;
        if ($id) {
            if ($this->peminjamanModel->rejectPeminjaman($id)) {
                $_SESSION['flash_success'] = 'Peminjaman berhasil ditolak!';
            } else {
                $_SESSION['flash_error'] = 'Gagal menolak peminjaman!';
            }
        }
        header('Location: ' . App::BASE_URL . '/index.php?page=peminjaman');
        exit;
    }
}