<?php
$pageTitle = 'Dashboard Siswa';
$pageIcon = 'speedometer2';
require_once __DIR__ . '/../templates/header.php';
require_once __DIR__ . '/../templates/sidebar.php';
?>

<div class="card mb-4" style="border: none; border-radius: 1rem; overflow: hidden; box-shadow: var(--card-shadow);">
    <div class="card-body p-4" style="background: linear-gradient(135deg, #595c66 0%, #8a53d3 100%); color: white;">
        <h3 class="mb-1">Selamat Datang, <?= htmlspecialchars($_SESSION['nama_lengkap']) ?>! 👋</h3>
        <p class="mb-0 opacity-75">Selamat membaca.</p>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="card stat-card">
            <div class="card-body border-left-primary">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="stat-label">Total Peminjaman</div>
                        <div class="stat-value"><?= count($peminjamanSaya) ?></div>
                    </div>
                    <div class="stat-icon bg-primary">
                        <i class="bi bi-journal-text"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card stat-card">
            <div class="card-body border-left-warning">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="stat-label">Sedang Dipinjam</div>
                        <div class="stat-value"><?= count(array_filter($peminjamanSaya, fn($p) => $p->status === 'dipinjam')) ?></div>
                    </div>
                    <div class="stat-icon bg-warning">
                        <i class="bi bi-hourglass-split"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card stat-card">
            <div class="card-body border-left-success">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="stat-label">Sudah Dikembalikan</div>
                        <div class="stat-value"><?= count(array_filter($peminjamanSaya, fn($p) => $p->status === 'dikembalikan')) ?></div>
                    </div>
                    <div class="stat-icon bg-success">
                        <i class="bi bi-check-circle"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- My Loans -->
<div class="card data-card mb-4">
    <div class="card-header">
        <h5><i class="bi bi-journal-text me-2"></i>Riwayat Peminjaman Saya</h5>
    </div>
    <div class="card-body p-0">
        <?php if (!empty($peminjamanSaya)): ?>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Judul Buku</th>
                            <th>Pengarang</th>
                            <th>Tanggal Pinjam</th>
                            <th>Tanggal Kembali</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($peminjamanSaya as $i => $p): ?>
                            <tr>
                                <td><?= $i + 1 ?></td>
                                <td><strong><?= htmlspecialchars($p->judul) ?></strong></td>
                                <td><?= htmlspecialchars($p->pengarang) ?></td>
                                <td><?= date('d/m/Y', strtotime($p->tanggal_pinjam)) ?></td>
                                <td><?= date('d/m/Y', strtotime($p->tanggal_kembali)) ?></td>
                                <td>
                                    <?php if ($p->status === 'dipinjam'): ?>
                                        <span class="badge bg-warning text-dark">Dipinjam</span>
                                    <?php else: ?>
                                        <span class="badge bg-success">Dikembalikan</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <i class="bi bi-journal-x d-block"></i>
                <h5>Belum ada peminjaman</h5>
                <p class="text-muted">Kamu belum meminjam buku apapun</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php require_once __DIR__ . '/../templates/footer.php'; ?>
