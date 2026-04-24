<?php

require_once __DIR__ . '/../models/Kategori.php';

class KategoriController
{
    private $kategoriModel;

    public function __construct()
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header('Location: ' . App::BASE_URL . '/index.php?page=auth&action=login');
            exit;
        }
        $this->kategoriModel = new Kategori();
    }

    public function index()
    {
        $kategori = $this->kategoriModel->getAll();
        require_once __DIR__ . '/../views/kategori/index.php';
    }

    public function create()
    {
        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'nama_kategori' => trim($_POST['nama_kategori'] ?? '')
            ];

            if (empty($data['nama_kategori'])) {
                $error = 'Nama kategori harus diisi!';
            } else {
                if ($this->kategoriModel->create($data)) {
                    $_SESSION['flash_success'] = 'Kategori berhasil ditambahkan!';
                    header('Location: ' . App::BASE_URL . '/index.php?page=kategori');
                    exit;
                } else {
                    $error = 'Gagal menambahkan kategori!';
                }
            }
        }

        require_once __DIR__ . '/../views/kategori/create.php';
    }

    public function edit()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: ' . App::BASE_URL . '/index.php?page=kategori');
            exit;
        }

        $kategori_item = $this->kategoriModel->getById($id);
        if (!$kategori_item) {
            header('Location: ' . App::BASE_URL . '/index.php?page=kategori');
            exit;
        }

        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'nama_kategori' => trim($_POST['nama_kategori'] ?? '')
            ];

            if (empty($data['nama_kategori'])) {
                $error = 'Nama kategori harus diisi!';
            } else {
                if ($this->kategoriModel->update($id, $data)) {
                    $_SESSION['flash_success'] = 'Kategori berhasil diupdate!';
                    header('Location: ' . App::BASE_URL . '/index.php?page=kategori');
                    exit;
                } else {
                    $error = 'Gagal mengupdate kategori!';
                }
            }
        }

        require_once __DIR__ . '/../views/kategori/edit.php';
    }

    public function delete()
    {
        $id = $_GET['id'] ?? null;
        if ($id) {
            if ($this->kategoriModel->delete($id)) {
                $_SESSION['flash_success'] = 'Kategori berhasil dihapus!';
            } else {
                $_SESSION['flash_error'] = 'Gagal menghapus kategori!';
            }
        }
        header('Location: ' . App::BASE_URL . '/index.php?page=kategori');
        exit;
    }
}
