<?php
/**
 * Script untuk fix database schema
 * Jalankan dengan membuka: http://localhost/perpustakaan/fix-database.php
 */

require_once __DIR__ . '/config/Database.php';

try {
    $db = Database::getInstance()->getConnection();
    
    // Alter table peminjaman untuk menambahkan status 'pengajuan'
    $sql = "ALTER TABLE peminjaman MODIFY COLUMN status ENUM('pengajuan', 'disetujui', 'dipinjam', 'dikembalikan') NOT NULL DEFAULT 'pengajuan'";
    
    $db->exec($sql);
    
    echo "<div style='padding: 20px; background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; border-radius: 4px;'>";
    echo "<h2>✅ Database Schema Berhasil Diperbaiki!</h2>";
    echo "<p><strong>Perubahan yang dilakukan:</strong></p>";
    echo "<ul>";
    echo "<li>Tambah status 'pengajuan' ke kolom ENUM di tabel 'peminjaman'</li>";
    echo "<li>Set default status menjadi 'pengajuan'</li>";
    echo "</ul>";
    echo "<p><a href='index.php?page=peminjaman' style='color: #0c5460;'>&larr; Kembali ke Peminjaman</a></p>";
    echo "</div>";
    
} catch (Exception $e) {
    echo "<div style='padding: 20px; background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; border-radius: 4px;'>";
    echo "<h2>❌ Terjadi Error</h2>";
    echo "<p><strong>Error:</strong> " . htmlspecialchars($e->getMessage()) . "</p>";
    echo "</div>";
}
?>
