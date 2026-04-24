<?php
$pageTitle = 'Dashboard Admin';
$pageIcon = 'speedometer2';
require_once __DIR__ . '/../templates/header.php';
require_once __DIR__ . '/../templates/sidebar.php';
?>

<style>
    .welcome-banner {
        background: linear-gradient(135deg, #7b2ff7 0%, #a855f7 50%, #c084fc 100%);
        border-radius: 16px;
        padding: 2rem 2.5rem;
        color: white;
        position: relative;
        overflow: hidden;
        box-shadow: 0 8px 32px rgba(123, 47, 247, 0.25);
    }
    .welcome-banner::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 300px;
        height: 300px;
        background: rgba(255,255,255,0.08);
        border-radius: 50%;
    }
    .welcome-banner::after {
        content: '';
        position: absolute;
        bottom: -30%;
        right: 10%;
        width: 200px;
        height: 200px;
        background: rgba(255,255,255,0.05);
        border-radius: 50%;
    }
    .welcome-banner h2 {
        font-weight: 800;
        font-size: 1.6rem;
        margin-bottom: 0.3rem;
    }
    .welcome-banner p {
        opacity: 0.9;
        margin: 0;
        font-size: 0.95rem;
    }
    .welcome-banner .welcome-date {
        background: rgba(255,255,255,0.15);
        backdrop-filter: blur(10px);
        padding: 0.4rem 1rem;
        border-radius: 20px;
        font-size: 0.85rem;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        margin-top: 0.8rem;
    }

    .stat-card-new {
        border: none;
        border-radius: 14px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        overflow: hidden;
        background: white;
    }
    .stat-card-new:hover {
        transform: translateY(-6px);
        box-shadow: 0 12px 35px rgba(0,0,0,0.12);
    }
    .stat-card-new .card-body {
        padding: 1.5rem;
    }
    .stat-card-new .stat-icon-modern {
        width: 56px;
        height: 56px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: white;
    }
    .stat-card-new .stat-value {
        font-size: 2rem;
        font-weight: 800;
        color: #1a1a2e;
        line-height: 1;
    }
    .stat-card-new .stat-label {
        font-size: 0.78rem;
        color: #858796;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        font-weight: 700;
    }
    .icon-purple { background: linear-gradient(135deg, #7b2ff7, #a855f7); }
    .icon-emerald { background: linear-gradient(135deg, #10b981, #059669); }
    .icon-sky { background: linear-gradient(135deg, #0ea5e9, #0284c7); }
    .icon-amber { background: linear-gradient(135deg, #f59e0b, #d97706); }

    .recent-loans-card {
        border: none;
        border-radius: 14px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        overflow: hidden;
    }
    .recent-loans-card .card-header {
        background: white;
        border-bottom: 2px solid #f1f5f9;
        padding: 1.25rem 1.5rem;
    }
    .recent-loans-card .card-header h5 {
        font-weight: 700;
        color: #1a1a2e;
        margin: 0;
        font-size: 1.05rem;
    }
    .recent-loans-card .table thead th {
        background: #fafafe;
        font-weight: 700;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        color: #858796;
        padding: 0.9rem 1rem;
        border: none;
    }
    .recent-loans-card .table tbody td {
        padding: 0.9rem 1rem;
        vertical-align: middle;
        border-color: #f8f9fc;
        color: #333;
    }
    .recent-loans-card .table tbody tr {
        transition: background 0.15s ease;
    }
    .recent-loans-card .table tbody tr:hover {
        background: #f5f3ff;
    }
    .badge-dipinjam {
        background: linear-gradient(135deg, #f59e0b, #d97706);
        color: white;
        font-weight: 600;
        padding: 0.4rem 0.9rem;
        border-radius: 20px;
        font-size: 0.75rem;
    }
</style>

<!-- Welcome Banner -->
<div class="welcome-banner mb-4">
    <h2><i class="bi bi-stars me-2"></i>Selamat Datang, <?= htmlspecialchars($_SESSION['nama_lengkap']) ?>!</h2>
    <p>Kelola perpustakaan Anda dengan mudah dari sini.</p>
    <div class="welcome-date">
        <i class="bi bi-calendar3"></i>
        <?= strftime('%A') ?>, <?= date('d F Y') ?>
    </div>
</div>

<!-- Stat Cards -->
<div class="row g-4 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="card stat-card-new">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="stat-label">Total Buku</div>
                        <div class="stat-value"><?= $totalBuku ?></div>
                    </div>
                    <div class="stat-icon-modern icon-purple">
                        <i class="bi bi-journal-bookmark"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card stat-card-new">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="stat-label">Total Anggota</div>
                        <div class="stat-value"><?= $totalSiswa ?></div>
                    </div>
                    <div class="stat-icon-modern icon-emerald">
                        <i class="bi bi-people-fill"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card stat-card-new">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="stat-label">Peminjaman Aktif</div>
                        <div class="stat-value"><?= $totalPeminjamanAktif ?></div>
                    </div>
                    <div class="stat-icon-modern icon-sky">
                        <i class="bi bi-arrow-left-right"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card stat-card-new">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="stat-label">Total Pengembalian</div>
                        <div class="stat-value"><?= $totalPengembalian ?></div>
                    </div>
                    <div class="stat-icon-modern icon-amber">
                        <i class="bi bi-arrow-return-left"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Active Loans -->
<div class="card recent-loans-card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5><i class="bi bi-clock-history me-2" style="color:#7b2ff7"></i>Peminjaman Aktif Terbaru</h5>
        <a href="<?= App::BASE_URL ?>/index.php?page=peminjaman" class="btn btn-primary btn-sm" style="border-radius: 20px; padding: 0.4rem 1.2rem;">
            <i class="bi bi-eye me-1"></i>Lihat Semua
        </a>
    </div>
    <div class="card-body p-0">
        <?php if (!empty($peminjamanAktif)): ?>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Peminjam</th>
                            <th>Buku</th>
                            <th>Tanggal Pinjam</th>
                            <th>Tanggal Kembali</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach (array_slice($peminjamanAktif, 0, 5) as $i => $p): ?>
                            <tr>
                                <td><span class="fw-semibold text-muted"><?= $i + 1 ?></span></td>
                                <td><strong><?= htmlspecialchars($p->nama_lengkap) ?></strong></td>
                                <td><?= htmlspecialchars($p->judul) ?></td>
                                <td><?= date('d/m/Y', strtotime($p->tanggal_pinjam)) ?></td>
                                <td><?= date('d/m/Y', strtotime($p->tanggal_kembali)) ?></td>
                                <td><span class="badge badge-dipinjam">Dipinjam</span></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="text-center py-5">
                <i class="bi bi-inbox d-block" style="font-size: 3.5rem; color: #d1d5db; margin-bottom: 1rem;"></i>
                <h5 class="fw-bold text-muted">Tidak ada peminjaman aktif</h5>
                <p class="text-muted small">Semua buku sudah dikembalikan</p>
            </div>
        <?php endif; ?>
    </div>
</div>
