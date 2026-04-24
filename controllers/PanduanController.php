<?php

class PanduanController
{
    public function __construct()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . App::BASE_URL . '/index.php?page=auth&action=login');
            exit;
        }

        // Hanya siswa yang bisa akses
        if ($_SESSION['role'] !== 'siswa') {
            header('Location: ' . App::BASE_URL . '/index.php?page=dashboard');
            exit;
        }
    }

    public function index()
    {
        $pageTitle = 'Cara Meminjam Buku';
        $pageIcon = 'question-circle';
        require_once __DIR__ . '/../views/templates/header.php';
        require_once __DIR__ . '/../views/templates/sidebar.php';
        require_once __DIR__ . '/../views/panduan/index.php';
        require_once __DIR__ . '/../views/templates/footer.php';
    }
}
