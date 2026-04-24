<?php

require_once __DIR__ . '/../models/User.php';

class AnggotaController
{
    private $userModel;

    public function __construct()
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header('Location: ' . App::BASE_URL . '/index.php?page=auth&action=login');
            exit;
        }
        $this->userModel = new User();
    }

    public function index()
    {
        $anggota = $this->userModel->getAllSiswa();
        require_once __DIR__ . '/../views/anggota/index.php';
    }

    public function create()
    {
        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'username' => trim($_POST['username'] ?? ''),
                'password' => $_POST['password'] ?? '',
                'nama_lengkap' => trim($_POST['nama_lengkap'] ?? ''),
                'role' => 'siswa'
            ];

            if (empty($data['username']) || empty($data['password']) || empty($data['nama_lengkap'])) {
                $error = 'Semua field harus diisi!';
            } else {
                // Cek username sudah ada
                $existing = $this->userModel->getByUsername($data['username']);
                if ($existing) {
                    $error = 'Username sudah digunakan!';
                } else {
                    if ($this->userModel->create($data)) {
                        $_SESSION['flash_success'] = 'Anggota berhasil ditambahkan!';
                        header('Location: ' . App::BASE_URL . '/index.php?page=anggota');
                        exit;
                    } else {
                        $error = 'Gagal menambahkan anggota!';
                    }
                }
            }
        }

        require_once __DIR__ . '/../views/anggota/create.php';
    }

    public function edit()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: ' . App::BASE_URL . '/index.php?page=anggota');
            exit;
        }

        $anggota_item = $this->userModel->getById($id);
        if (!$anggota_item) {
            header('Location: ' . App::BASE_URL . '/index.php?page=anggota');
            exit;
        }

        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'username' => trim($_POST['username'] ?? ''),
                'password' => $_POST['password'] ?? '',
                'nama_lengkap' => trim($_POST['nama_lengkap'] ?? ''),
                'role' => 'siswa'
            ];

            if (empty($data['username']) || empty($data['nama_lengkap'])) {
                $error = 'Username dan nama lengkap harus diisi!';
            } else {
                // Cek username sudah ada (kecuali user ini sendiri)
                $existing = $this->userModel->getByUsername($data['username']);
                if ($existing && $existing->id != $id) {
                    $error = 'Username sudah digunakan!';
                } else {
                    if ($this->userModel->update($id, $data)) {
                        $_SESSION['flash_success'] = 'Anggota berhasil diupdate!';
                        header('Location: ' . App::BASE_URL . '/index.php?page=anggota');
                        exit;
                    } else {
                        $error = 'Gagal mengupdate anggota!';
                    }
                }
            }
        }

        require_once __DIR__ . '/../views/anggota/edit.php';
    }

    public function delete()
    {
        $id = $_GET['id'] ?? null;
        if ($id) {
            if ($this->userModel->delete($id)) {
                $_SESSION['flash_success'] = 'Anggota berhasil dihapus!';
            } else {
                $_SESSION['flash_error'] = 'Gagal menghapus anggota!';
            }
        }
        header('Location: ' . App::BASE_URL . '/index.php?page=anggota');
        exit;
    }
}
