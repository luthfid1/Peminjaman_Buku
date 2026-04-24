<?php
$pageTitle = 'Data Pengembalian';
$pageIcon = 'arrow-return-left';
require_once __DIR__ . '/../templates/header.php';
require_once __DIR__ . '/../templates/sidebar.php';
?>

<div class="card data-card">
    <div class="card-header">
        <h5><i class="bi bi-arrow-return-left me-2"></i>Daftar Pengembalian</h5>
        <a href="<?= App::BASE_URL ?>/index.php?page=pengembalian&action=create" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-lg me-1"></i>Catat Pengembalian
        </a>
    </div>
    <div class="card-body p-0">
        <?php if (!empty($pengembalian)): ?>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Peminjam</th>
                            <th>Buku</th>
                            <th>Tgl Pinjam</th>
                            <th>Tgl Kembali</th>
                            <th>Tgl Dikembalikan</th>
                            <th>Keterlambatan</th>
                            <th>Denda</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pengembalian as $i => $pg): 
                            $hariTerlambat = max(0, ceil((strtotime($pg->tanggal_pengembalian) - strtotime($pg->tanggal_kembali)) / (60 * 60 * 24)));
                        ?>
                            <tr <?= $hariTerlambat > 0 ? 'class="table-warning"' : '' ?>>
                                <td><?= $i + 1 ?></td>
                                <td><strong><?= htmlspecialchars($pg->nama_lengkap) ?></strong></td>
                                <td><?= htmlspecialchars($pg->judul) ?></td>
                                <td><?= date('d/m/Y', strtotime($pg->tanggal_pinjam)) ?></td>
                                <td><?= date('d/m/Y', strtotime($pg->tanggal_kembali)) ?></td>
                                <td><?= date('d/m/Y', strtotime($pg->tanggal_pengembalian)) ?></td>
                                <td>
                                    <?php if ($hariTerlambat > 0): ?>
                                        <span class="badge bg-danger">
                                            <i class="bi bi-exclamation-circle me-1"></i>
                                            <?= $hariTerlambat ?> hari
                                        </span>
                                    <?php else: ?>
                                        <span class="badge bg-success">Tepat Waktu</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($pg->denda > 0): ?>
                                        <span class="badge bg-danger">Rp <?= number_format($pg->denda, 0, ',', '.') ?></span>
                                    <?php else: ?>
                                        <span class="badge bg-success">Rp 0</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="<?= App::BASE_URL ?>/index.php?page=pengembalian&action=delete&id=<?= $pg->id ?>" class="btn btn-danger btn-sm" title="Hapus" onclick="return confirm('Yakin ingin menghapus data pengembalian ini?')">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <i class="bi bi-inbox d-block"></i>
                <h5>Belum ada pengembalian</h5>
                <p class="text-muted">Klik tombol "Catat Pengembalian" untuk mencatat.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php require_once __DIR__ . '/../templates/footer.php'; ?>
