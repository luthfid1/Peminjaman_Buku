<?php
$pageTitle = 'Laporan Lengkap';
$pageIcon = 'file-earmark';
require_once __DIR__ . '/../templates/header.php';
require_once __DIR__ . '/../templates/sidebar.php';
?>

<div class="card data-card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="bi bi-file-earmark me-2"></i>Laporan Lengkap Peminjaman & Pengembalian</h5>
            <div class="btn-group">
                <a href="<?= App::BASE_URL ?>/index.php?page=laporan&action=export&format=csv" class="btn btn-sm btn-success">
                    <i class="bi bi-download me-1"></i>Export CSV
                </a>
                <a href="<?= App::BASE_URL ?>/index.php?page=laporan&action=export&format=pdf" class="btn btn-sm btn-danger">
                    <i class="bi bi-file-pdf me-1"></i>Export PDF
                </a>
            </div>
        </div>
    </div>
    <div class="card-body p-0">
        <!-- Filter Section -->
        <div class="p-3 bg-light border-bottom">
            <form method="GET" class="row g-3">
                <input type="hidden" name="page" value="laporan">
                <input type="hidden" name="action" value="lengkap">
                
                <div class="col-md-4">
                    <label for="tanggal_awal" class="form-label">Tanggal Awal</label>
                    <input type="date" class="form-control" id="tanggal_awal" name="tanggal_awal" 
                           value="<?= $_GET['tanggal_awal'] ?? date('Y-m-01') ?>">
                </div>
                <div class="col-md-4">
                    <label for="tanggal_akhir" class="form-label">Tanggal Akhir</label>
                    <input type="date" class="form-control" id="tanggal_akhir" name="tanggal_akhir" 
                           value="<?= $_GET['tanggal_akhir'] ?? date('Y-m-t') ?>">
                </div>
                <div class="col-md-4" style="display: flex; align-items: flex-end;">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-search me-1"></i>Filter
                    </button>
                </div>
            </form>
        </div>

        <!-- Data Table -->
        <?php if (!empty($laporanData)): ?>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead style="background-color: #f8f9fc;">
                        <tr>
                            <th>No</th>
                            <th>ID</th>
                            <th>Nama Peminjam</th>
                            <th>Judul Buku</th>
                            <th>Pengarang</th>
                            <th>Tgl Pinjam</th>
                            <th>Tgl Kembali</th>
                            <th>Status</th>
                            <th>Tgl Pengembalian</th>
                            <th>Denda</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; foreach ($laporanData as $row): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $row->id ?></td>
                            <td><?= htmlspecialchars($row->nama_lengkap) ?></td>
                            <td><?= htmlspecialchars($row->judul) ?></td>
                            <td><?= htmlspecialchars($row->pengarang) ?></td>
                            <td><?= date('d/m/Y', strtotime($row->tanggal_pinjam)) ?></td>
                            <td><?= date('d/m/Y', strtotime($row->tanggal_kembali)) ?></td>
                            <td>
                                <?php 
                                    $statusBadge = [
                                        'pengajuan' => 'warning text-dark',
                                        'disetujui' => 'info',
                                        'dipinjam' => 'primary',
                                        'dikembalikan' => 'success'
                                    ];
                                    $badgeClass = $statusBadge[$row->status] ?? 'secondary';
                                ?>
                                <span class="badge bg-<?= $badgeClass ?>"><?= ucfirst($row->status) ?></span>
                            </td>
                            <td>
                                <?php if ($row->tanggal_pengembalian): ?>
                                    <?= date('d/m/Y', strtotime($row->tanggal_pengembalian)) ?>
                                <?php else: ?>
                                    <span class="text-muted">-</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($row->denda): ?>
                                    <span class="badge bg-danger">Rp <?= number_format($row->denda, 0, ',', '.') ?></span>
                                <?php else: ?>
                                    <span class="text-muted">-</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="p-3 bg-light border-top">
                <p class="mb-0 text-muted">Total Data: <strong><?= count($laporanData) ?></strong> records</p>
            </div>
        <?php else: ?>
            <div class="p-5 text-center">
                <i class="bi bi-inbox" style="font-size: 3rem; opacity: 0.3; display: block; margin-bottom: 1rem;"></i>
                <h5>Tidak ada data</h5>
                <p class="text-muted">Belum ada peminjaman dalam periode yang dipilih</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php require_once __DIR__ . '/../templates/footer.php'; ?>