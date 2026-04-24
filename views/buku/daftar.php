<?php
$pageTitle = 'Katalog Buku';
$pageIcon = 'book';
require_once __DIR__ . '/../templates/header.php';
require_once __DIR__ . '/../templates/sidebar.php';
?>

<!-- Search & Filter -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" class="d-flex">
            <input type="hidden" name="page" value="buku">
            <input type="hidden" name="action" value="daftar">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Cari judul buku..." name="search" value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-search me-1"></i>Cari
                </button>
                <a href="<?= App::BASE_URL ?>/index.php?page=buku&action=daftar" class="btn btn-secondary">
                    <i class="bi bi-arrow-counterclockwise me-1"></i>Reset
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Katalog Buku -->
<?php $view = $_GET['view'] ?? 'table'; ?>
<div class="card data-card">
    <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="mb-0"><i class="bi bi-book me-2"></i>Katalog Buku</h5>
        <div class="btn-group" role="group" aria-label="View toggle">
            <?php
                $qs = $_GET;
                $qs['view'] = 'table';
                $tableUrl = App::BASE_URL . '/index.php?' . http_build_query($qs);
                $qs['view'] = 'grid';
                $gridUrl = App::BASE_URL . '/index.php?' . http_build_query($qs);
            ?>
            <a href="<?= $tableUrl ?>" class="btn btn-sm <?= $view === 'table' ? 'btn-primary' : 'btn-outline-secondary' ?>" title="Tampilan Tabel">
                <i class="bi bi-list"></i>
            </a>
            <a href="<?= $gridUrl ?>" class="btn btn-sm <?= $view === 'grid' ? 'btn-primary' : 'btn-outline-secondary' ?>" title="Tampilan Grid">
                <i class="bi bi-grid-3x3-gap-fill"></i>
            </a>
        </div>
    </div>
    <div class="card-body p-3">
        <?php if (!empty($buku)): ?>
            <?php if ($view === 'grid'): ?>
                <div class="row g-3">
                    <?php foreach ($buku as $i => $b): ?>
                        <div class="col-6 col-md-4 col-lg-3">
                            <div class="card h-100">
                                <div class="card-body d-flex flex-column">
                                    <h6 class="card-title mb-1" title="<?= htmlspecialchars($b->judul) ?>"><?= htmlspecialchars(mb_strimwidth($b->judul,0,40,'...')) ?></h6>
                                    <p class="text-muted mb-2 small"><?= htmlspecialchars($b->pengarang) ?></p>
                                    <p class="mb-2"><span class="badge bg-info"><?= htmlspecialchars($b->nama_kategori ?? '-') ?></span></p>
                                    <div class="mt-auto">
                                        <?php if ($b->jumlah_stok > 0): ?>
                                            <button type="button" class="btn btn-sm btn-success w-100 mb-2" data-bs-toggle="modal" data-bs-target="#pinjamModal<?= $b->id ?>">
                                                <i class="bi bi-journal-check me-1"></i>Pinjam
                                            </button>
                                        <?php else: ?>
                                            <button class="btn btn-sm btn-secondary w-100" disabled>Tidak Tersedia</button>
                                        <?php endif; ?>
                                        <small class="d-block text-muted mt-2">Stok: <?= $b->jumlah_stok ?></small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Peminjaman -->
                        <div class="modal fade" id="pinjamModal<?= $b->id ?>" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Ajukan Peminjaman</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <form action="<?= App::BASE_URL ?>/index.php?page=peminjaman&action=ajukan" method="POST">
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="form-label">Judul Buku</label>
                                                <input type="text" class="form-control" value="<?= htmlspecialchars($b->judul) ?>" disabled>
                                                <input type="hidden" name="buku_id" value="<?= $b->id ?>">
                                            </div>
                                            <div class="mb-3">
                                                <label for="tanggal_pinjam<?= $b->id ?>" class="form-label">Tanggal Pinjam</label>
                                                <input type="date" class="form-control" id="tanggal_pinjam<?= $b->id ?>" name="tanggal_pinjam" value="<?= date('Y-m-d') ?>" min="<?= date('Y-m-d') ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="tanggal_kembali<?= $b->id ?>" class="form-label">Tanggal Target Kembali</label>
                                                <input type="date" class="form-control" id="tanggal_kembali<?= $b->id ?>" name="tanggal_kembali" value="<?= date('Y-m-d', strtotime('+14 days')) ?>" min="<?= date('Y-m-d') ?>" required>
                                            </div>
                                            <div class="alert alert-info">
                                                <small>Durasi peminjaman maksimal 14 hari. Keterlambatan akan dikenakan denda Rp 5.000 per hari.</small>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-primary">
                                                <i class="bi bi-check me-1"></i>Ajukan
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Judul</th>
                                <th>Pengarang</th>
                                <th>Penerbit</th>
                                <th>Tahun</th>
                                <th>Kategori</th>
                                <th>Stok</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($buku as $i => $b): ?>
                                <tr>
                                    <td><?= $i + 1 ?></td>
                                    <td><strong><?= htmlspecialchars($b->judul) ?></strong></td>
                                    <td><?= htmlspecialchars($b->pengarang) ?></td>
                                    <td><?= htmlspecialchars($b->penerbit) ?></td>
                                    <td><?= $b->tahun_terbit ?></td>
                                    <td><span class="badge bg-info"><?= htmlspecialchars($b->nama_kategori ?? '-') ?></span></td>
                                    <td>
                                        <?php if ($b->jumlah_stok > 0): ?>
                                            <span class="badge bg-success"><?= $b->jumlah_stok ?> Tersedia</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger">Habis</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ($b->jumlah_stok > 0): ?>
                                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#pinjamModal<?= $b->id ?>" title="Pinjam">
                                                <i class="bi bi-journal-check me-1"></i>Pinjam
                                            </button>
                                        <?php else: ?>
                                            <button class="btn btn-secondary btn-sm" disabled>Tidak Tersedia</button>
                                        <?php endif; ?>
                                    </td>
                                </tr>

                                <!-- Modal Peminjaman (reused) -->
                                <div class="modal fade" id="pinjamModal<?= $b->id ?>" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Ajukan Peminjaman</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <form action="<?= App::BASE_URL ?>/index.php?page=peminjaman&action=ajukan" method="POST">
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label class="form-label">Judul Buku</label>
                                                        <input type="text" class="form-control" value="<?= htmlspecialchars($b->judul) ?>" disabled>
                                                        <input type="hidden" name="buku_id" value="<?= $b->id ?>">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="tanggal_pinjam<?= $b->id ?>" class="form-label">Tanggal Pinjam</label>
                                                        <input type="date" class="form-control" id="tanggal_pinjam<?= $b->id ?>" name="tanggal_pinjam" value="<?= date('Y-m-d') ?>" min="<?= date('Y-m-d') ?>" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="tanggal_kembali<?= $b->id ?>" class="form-label">Tanggal Target Kembali</label>
                                                        <input type="date" class="form-control" id="tanggal_kembali<?= $b->id ?>" name="tanggal_kembali" value="<?= date('Y-m-d', strtotime('+14 days')) ?>" min="<?= date('Y-m-d') ?>" required>
                                                    </div>
                                                    <div class="alert alert-info">
                                                        <small>Durasi peminjaman maksimal 14 hari. Keterlambatan akan dikenakan denda Rp 5.000 per hari.</small>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-primary">
                                                        <i class="bi bi-check me-1"></i>Ajukan
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        <?php else: ?>
            <div class="empty-state text-center py-5">
                <i class="bi bi-journal-x d-block mb-2" style="font-size:36px"></i>
                <h5>Belum ada buku</h5>
                <p class="text-muted">Perpustakaan belum memiliki koleksi buku.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php require_once __DIR__ . '/../templates/footer.php'; ?>
