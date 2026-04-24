<?php
session_start();

require_once __DIR__ . '/config/App.php';
require_once __DIR__ . '/config/Database.php';

// Simple Router
$page = isset($_GET['page']) ? $_GET['page'] : 'home';
$action = isset($_GET['action']) ? $_GET['action'] : 'index';

// Route mapping
$routes = [
    'home' => 'HomeController',
    'auth' => 'AuthController',
    'dashboard' => 'DashboardController',
    'buku' => 'BukuController',
    'kategori' => 'KategoriController',
    'anggota' => 'AnggotaController',
    'peminjaman' => 'PeminjamanController',
    'pengembalian' => 'PengembalianController',
    'panduan' => 'PanduanController',
    'laporan' => 'LaporanController',
    'api' => 'ApiController',
];

// Check if route exists
if (array_key_exists($page, $routes)) {
    $controllerName = $routes[$page];
    require_once __DIR__ . '/controllers/' . $controllerName . '.php';
    $controller = new $controllerName();

    // Check if action/method exists
    if (method_exists($controller, $action)) {
        $controller->$action();
    } else {
        $controller->index();
    }
} else {
    // 404 - Page not found
    http_response_code(404);
    echo "<h1>404 - Halaman tidak ditemukan</h1>";
    echo "<a href='" . App::BASE_URL . "'>Kembali ke Beranda</a>";
}
