<?php
$pageTitle = 'Debug Peminjaman';
$pageIcon = 'bug';
require_once __DIR__ . '/config/App.php';
require_once __DIR__ . '/config/Database.php';
require_once __DIR__ . '/models/Peminjaman.php';
require_once __DIR__ . '/views/templates/header.php';
require_once __DIR__ . '/views/templates/sidebar.php';

// Mock session untuk testing
$_SESSION['role'] = 'admin';
$_SESSION['user_id'] = 1;

$peminjamanModel = new Peminjaman();
$peminjaman = $peminjamanModel->getAllWithLateInfo();

echo "<div class='container-fluid mt-5'>";
echo "<h3>Debug: Halaman Peminjaman Admin</h3>";
echo "<hr>";

// Debug Info
echo "<div class='alert alert-info'>";
echo "<strong>Debug Info:</strong><br>";
echo "Role: " . $_SESSION['role'] . "<br>";
echo "Total Data Peminjaman: " . count($peminjaman) . "<br>";

if (!empty($peminjaman)) {
    echo "<strong>Breakdown Status:</strong><br>";
    $pengajuan = array_filter($peminjaman, fn($p) => $p->status === 'pengajuan');
    $disetujui = array_filter($peminjaman, fn($p) => in_array($p->status, ['disetujui', 'dipinjam']));
    $dikembalikan = array_filter($peminjaman, fn($p) => $p->status === 'dikembalikan');
    
    echo "- Pengajuan: " . count($pengajuan) . "<br>";
    echo "- Disetujui & Dipinjam: " . count($disetujui) . "<br>";
    echo "- Dikembalikan: " . count($dikembalikan) . "<br>";
} else {
    echo "<span class='badge bg-warning'>Data kosong!</span>";
}
echo "</div>";

// Actual Tabs
echo "<div class='card mt-4'>";
echo "<div class='card-header'>";
echo "<h5 class='mb-0'><i class='bi bi-arrow-left-right me-2'></i>Data Peminjaman (Dengan Tabs)</h5>";
echo "</div>";
echo "<div class='card-body p-0'>";

if ($_SESSION['role'] === 'admin') {
    // Tabs
    echo "<ul class='nav nav-tabs px-3 pt-3' role='tablist' style='border-bottom: 2px solid #e3e6f0;'>";
    
    // Tab 1
    echo "<li class='nav-item' role='presentation'>";
    echo "<a class='nav-link active' id='tab-pengajuan' href='#content-pengajuan' data-bs-toggle='tab' role='tab' aria-controls='content-pengajuan' aria-selected='true' style='cursor: pointer;'>";
    echo "<i class='bi bi-hourglass-split me-1'></i>Menunggu Persetujuan";
    $pengajuan = array_filter($peminjaman, fn($p) => $p->status === 'pengajuan');
    echo "<span class='badge bg-danger ms-2'>" . count($pengajuan) . "</span>";
    echo "</a>";
    echo "</li>";
    
    // Tab 2
    echo "<li class='nav-item' role='presentation'>";
    echo "<a class='nav-link' id='tab-disetujui' href='#content-disetujui' data-bs-toggle='tab' role='tab' aria-controls='content-disetujui' aria-selected='false' style='cursor: pointer;'>";
    echo "<i class='bi bi-check-circle me-1'></i>Disetujui & Dipinjam";
    $disetujui = array_filter($peminjaman, fn($p) => in_array($p->status, ['disetujui', 'dipinjam']));
    echo "<span class='badge bg-info ms-2'>" . count($disetujui) . "</span>";
    echo "</a>";
    echo "</li>";
    
    // Tab 3
    echo "<li class='nav-item' role='presentation'>";
    echo "<a class='nav-link' id='tab-dikembalikan' href='#content-dikembalikan' data-bs-toggle='tab' role='tab' aria-controls='content-dikembalikan' aria-selected='false' style='cursor: pointer;'>";
    echo "<i class='bi bi-check-double me-1'></i>Dikembalikan";
    $dikembalikan = array_filter($peminjaman, fn($p) => $p->status === 'dikembalikan');
    echo "<span class='badge bg-success ms-2'>" . count($dikembalikan) . "</span>";
    echo "</a>";
    echo "</li>";
    
    echo "</ul>";
    
    // Content
    echo "<div class='tab-content' style='padding-top: 1.5rem;'>";
    
    // Content 1
    echo "<div class='tab-pane fade show active' id='content-pengajuan' role='tabpanel' aria-labelledby='tab-pengajuan'>";
    echo "<div class='px-3 pb-3'>";
    if (!empty($pengajuan)) {
        echo "<table class='table table-hover table-sm'>";
        echo "<thead><tr><th>No</th><th>Peminjam</th><th>Buku</th><th>Status</th></tr></thead>";
        echo "<tbody>";
        foreach ($pengajuan as $i => $p) {
            echo "<tr>";
            echo "<td>" . (count($pengajuan) - $i) . "</td>";
            echo "<td>" . htmlspecialchars($p->nama_lengkap) . "</td>";
            echo "<td>" . htmlspecialchars($p->judul) . "</td>";
            echo "<td><span class='badge bg-warning text-dark'>Pengajuan</span></td>";
            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";
    } else {
        echo "<div class='alert alert-success mt-3'>";
        echo "<i class='bi bi-check-circle me-2'></i>Tidak ada pengajuan";
        echo "</div>";
    }
    echo "</div>";
    echo "</div>";
    
    // Content 2
    echo "<div class='tab-pane fade' id='content-disetujui' role='tabpanel' aria-labelledby='tab-disetujui'>";
    echo "<div class='px-3 pb-3'>";
    if (!empty($disetujui)) {
        echo "<table class='table table-hover table-sm'>";
        echo "<thead><tr><th>No</th><th>Peminjam</th><th>Buku</th><th>Status</th></tr></thead>";
        echo "<tbody>";
        foreach ($disetujui as $i => $p) {
            echo "<tr>";
            echo "<td>" . (count($disetujui) - $i) . "</td>";
            echo "<td>" . htmlspecialchars($p->nama_lengkap) . "</td>";
            echo "<td>" . htmlspecialchars($p->judul) . "</td>";
            echo "<td><span class='badge bg-info'>" . ucfirst($p->status) . "</span></td>";
            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";
    } else {
        echo "<div class='alert alert-info mt-3'>";
        echo "<i class='bi bi-inbox me-2'></i>Tidak ada peminjaman aktif";
        echo "</div>";
    }
    echo "</div>";
    echo "</div>";
    
    // Content 3
    echo "<div class='tab-pane fade' id='content-dikembalikan' role='tabpanel' aria-labelledby='tab-dikembalikan'>";
    echo "<div class='px-3 pb-3'>";
    if (!empty($dikembalikan)) {
        echo "<table class='table table-hover table-sm'>";
        echo "<thead><tr><th>No</th><th>Peminjam</th><th>Buku</th><th>Status</th></tr></thead>";
        echo "<tbody>";
        foreach ($dikembalikan as $i => $p) {
            echo "<tr>";
            echo "<td>" . (count($dikembalikan) - $i) . "</td>";
            echo "<td>" . htmlspecialchars($p->nama_lengkap) . "</td>";
            echo "<td>" . htmlspecialchars($p->judul) . "</td>";
            echo "<td><span class='badge bg-success'>Dikembalikan</span></td>";
            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";
    } else {
        echo "<div class='alert alert-success mt-3'>";
        echo "<i class='bi bi-check-all me-2'></i>Belum ada buku yang dikembalikan";
        echo "</div>";
    }
    echo "</div>";
    echo "</div>";
    
    echo "</div>";
}

echo "</div>";
echo "</div>";

echo "<script>";
echo "console.log('Bootstrap Loaded:', typeof bootstrap !== 'undefined');";
echo "console.log('Tab Elements Found:', document.querySelectorAll('[data-bs-toggle=\"tab\"]').length);";
echo "document.querySelectorAll('[data-bs-toggle=\"tab\"]').forEach(el => {";
echo "  el.addEventListener('click', function(e) {";
echo "    console.log('Tab clicked:', this.id);";
echo "  });";
echo "});";
echo "</script>";

echo "</div>";
?>
