<?php

require_once __DIR__ . '/../models/User.php';

class AuthController
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    public function index()
    {
        $this->login();
    }

    public function login()
    {
        // Jika sudah login, redirect ke dashboard
        if (isset($_SESSION['user_id'])) {
            header('Location: ' . App::BASE_URL . '/index.php?page=dashboard');
            exit;
        }

        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $password = $_POST['password'] ?? '';

            if (empty($username) || empty($password)) {
                $error = 'Username dan password harus diisi!';
            } else {
                $user = $this->userModel->getByUsername($username);

                if ($user && $this->userModel->verifyPassword($password, $user->password)) {
                    $_SESSION['user_id'] = $user->id;
                    $_SESSION['username'] = $user->username;
                    $_SESSION['nama_lengkap'] = $user->nama_lengkap;
                    $_SESSION['role'] = $user->role;

                    header('Location: ' . App::BASE_URL . '/index.php?page=dashboard');
                    exit;
                } else {
                    $error = 'Username atau password salah!';
                }
            }
        }

        require_once __DIR__ . '/../views/auth/login.php';
    }

    public function logout()
    {
        session_destroy();
        header('Location: ' . App::BASE_URL . '/index.php?page=auth&action=login');
        exit;
    }

    public function register()
    {
        // Jika sudah login, redirect ke dashboard
        if (isset($_SESSION['user_id'])) {
            header('Location: ' . App::BASE_URL . '/index.php?page=dashboard');
            exit;
        }

        $error = '';
        $success = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nama_lengkap = trim($_POST['nama_lengkap'] ?? '');
            $username = trim($_POST['username'] ?? '');
            $password = $_POST['password'] ?? '';
            $password_confirm = $_POST['password_confirm'] ?? '';

            // Validasi
            if (empty($nama_lengkap) || empty($username) || empty($password) || empty($password_confirm)) {
                $error = 'Semua field harus diisi!';
            } elseif (strlen($username) < 4) {
                $error = 'Username minimal 4 karakter!';
            } elseif (strlen($password) < 6) {
                $error = 'Password minimal 6 karakter!';
            } elseif ($password !== $password_confirm) {
                $error = 'Password dan konfirmasi password tidak cocok!';
            } else {
                // Cek username sudah ada
                $existingUser = $this->userModel->getByUsername($username);
                if ($existingUser) {
                    $error = 'Username sudah terdaftar! Gunakan username lain.';
                } else {
                    // Buat akun baru
                    $data = [
                        'username' => $username,
                        'password' => $password,
                        'nama_lengkap' => $nama_lengkap,
                        'role' => 'siswa' // Default role adalah siswa
                    ];

                    if ($this->userModel->create($data)) {
                        $success = 'Akun berhasil dibuat! Silakan login dengan akun Anda.';
                        // Redirect ke login setelah 2 detik
                        header('Refresh: 2; url=' . App::BASE_URL . '/index.php?page=auth&action=login');
                    } else {
                        $error = 'Terjadi kesalahan saat membuat akun!';
                    }
                }
            }
        }

        require_once __DIR__ . '/../views/auth/register.php';
    }
}
