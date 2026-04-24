<?php

require_once __DIR__ . '/../models/Buku.php';
require_once __DIR__ . '/../models/Kategori.php';

class BukuController
{
    private $bukuModel;
    private $kategoriModel;

    public function __construct()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . App::BASE_URL . '/index.php?page=auth&action=login');
            exit;
        }
        $this->bukuModel = new Buku();
        $this->kategoriModel = new Kategori();
    }

    public function index()
    {
        
        if ($_SESSION['role'] !== 'admin') {
            header('Location: ' . App::BASE_URL . '/index.php?page=buku&action=daftar');
            exit;
        }

        $search = trim($_GET['search'] ?? '');
        if (!empty($search)) {
            $buku = $this->bukuModel->search($search);
        } else {
            $buku = $this->bukuModel->getAll();
        }
        require_once __DIR__ . '/../views/buku/index.php';
    }

    // Katalog buku untuk siswa
    public function daftar()
    {
        if ($_SESSION['role'] !== 'siswa') {
            header('Location: ' . App::BASE_URL . '/index.php?page=dashboard');
            exit;
        }

        $search = trim($_GET['search'] ?? '');
        if (!empty($search)) {
            $buku = $this->bukuModel->search($search);
        } else {
            $buku = $this->bukuModel->getAll();
        }
        require_once __DIR__ . '/../views/buku/daftar.php';
    }

    public function create()
    {
        if ($_SESSION['role'] !== 'admin') {
            header('Location: ' . App::BASE_URL . '/index.php?page=buku');
            exit;
        }

        $kategori = $this->kategoriModel->getAll();
        $error = '';
        $success = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'judul' => trim($_POST['judul'] ?? ''),
                'pengarang' => trim($_POST['pengarang'] ?? ''),
                'penerbit' => trim($_POST['penerbit'] ?? ''),
                'tahun_terbit' => $_POST['tahun_terbit'] ?? '',
                'isbn' => trim($_POST['isbn'] ?? ''),
                'jumlah_stok' => (int)($_POST['jumlah_stok'] ?? 0),
                'kategori_id' => $_POST['kategori_id'] ?? null
            ];

            if (empty($data['judul']) || empty($data['pengarang']) || empty($data['penerbit'])) {
                $error = 'Judul, pengarang, dan penerbit harus diisi!';
            } elseif ($data['jumlah_stok'] < 1) {
                $error = 'Jumlah stok minimal adalah 1!';
            } else {
                if ($this->bukuModel->create($data)) {
                    $_SESSION['flash_success'] = 'Buku berhasil ditambahkan!';
                    header('Location: ' . App::BASE_URL . '/index.php?page=buku');
                    exit;
                } else {
                    $error = 'Gagal menambahkan buku!';
                }
            }
        }

        require_once __DIR__ . '/../views/buku/create.php';
    }

    public function edit()
    {
        if ($_SESSION['role'] !== 'admin') {
            header('Location: ' . App::BASE_URL . '/index.php?page=buku');
            exit;
        }

        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: ' . App::BASE_URL . '/index.php?page=buku');
            exit;
        }

        $buku_item = $this->bukuModel->getById($id);
        if (!$buku_item) {
            header('Location: ' . App::BASE_URL . '/index.php?page=buku');
            exit;
        }

        $kategori = $this->kategoriModel->getAll();
        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'judul' => trim($_POST['judul'] ?? ''),
                'pengarang' => trim($_POST['pengarang'] ?? ''),
                'penerbit' => trim($_POST['penerbit'] ?? ''),
                'tahun_terbit' => $_POST['tahun_terbit'] ?? '',
                'isbn' => trim($_POST['isbn'] ?? ''),
                'jumlah_stok' => (int)($_POST['jumlah_stok'] ?? 0),
                'kategori_id' => $_POST['kategori_id'] ?? null
            ];

            if (empty($data['judul']) || empty($data['pengarang']) || empty($data['penerbit'])) {
                $error = 'Judul, pengarang, dan penerbit harus diisi!';
            } else {
                if ($this->bukuModel->update($id, $data)) {
                    $_SESSION['flash_success'] = 'Buku berhasil diupdate!';
                    header('Location: ' . App::BASE_URL . '/index.php?page=buku');
                    exit;
                } else {
                    $error = 'Gagal mengupdate buku!';
                }
            }
        }

        require_once __DIR__ . '/../views/buku/edit.php';
    }

    public function delete()
    {
        if ($_SESSION['role'] !== 'admin') {
            header('Location: ' . App::BASE_URL . '/index.php?page=buku');
            exit;
        }

        $id = $_GET['id'] ?? null;
        if ($id) {
            // Cek apakah buku sedang dipinjam
            if ($this->bukuModel->isBorrowed($id)) {
                $_SESSION['flash_error'] = 'Buku tidak bisa dihapus karena sedang dipinjam!';
            } else {
                if ($this->bukuModel->delete($id)) {
                    $_SESSION['flash_success'] = 'Buku berhasil dihapus!';
                } else {
                    $_SESSION['flash_error'] = 'Gagal menghapus buku!';
                }
            }
        }
        header('Location: ' . App::BASE_URL . '/index.php?page=buku');
        exit;
    }
}
