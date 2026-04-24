<?php
$pageTitle = 'Data Buku';
$pageIcon = 'journal-bookmark';
require_once __DIR__ . '/../templates/header.php';
require_once __DIR__ . '/../templates/sidebar.php';
?>

<!-- Search & Filter -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" class="d-flex">
            <input type="hidden" name="page" value="buku">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Cari judul atau pengarang..." name="search" value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-search me-1"></i>Cari
                </button>
                <a href="<?= App::BASE_URL ?>/index.php?page=buku" class="btn btn-secondary">
                    <i class="bi bi-arrow-counterclockwise me-1"></i>Reset
                </a>
            </div>
        </form>
    </div>
</div>

<div class="card data-card">
    <div class="card-header">
        <h5><i class="bi bi-journal-bookmark me-2"></i>Daftar Buku</h5>
        <a href="<?= App::BASE_URL ?>/index.php?page=buku&action=create" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-lg me-1"></i>Tambah Buku
        </a>
    </div>
    <div class="card-body p-0">
        <?php if (!empty($buku)): ?>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Judul</th>
                            <th>Pengarang</th>
                            <th>Penerbit</th>
                            <th>Tahun</th>
                            <th>ISBN</th>
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
                                <td><small><?= htmlspecialchars($b->isbn ?? '-') ?></small></td>
                                <td><span class="badge bg-info"><?= htmlspecialchars($b->nama_kategori ?? '-') ?></span></td>
                                <td>
                                    <?php if ($b->jumlah_stok > 0): ?>
                                        <span class="badge bg-success"><?= $b->jumlah_stok ?></span>
                                    <?php else: ?>
                                        <span class="badge bg-danger">0</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="<?= App::BASE_URL ?>/index.php?page=buku&action=edit&id=<?= $b->id ?>" class="btn btn-warning btn-sm" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a href="<?= App::BASE_URL ?>/index.php?page=buku&action=delete&id=<?= $b->id ?>" class="btn btn-danger btn-sm" title="Hapus" onclick="return confirm('Yakin ingin menghapus buku ini?')">
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
                <i class="bi bi-journal-x d-block"></i>
                <h5>Belum ada data buku</h5>
                <p class="text-muted">Klik tombol "Tambah Buku" untuk menambahkan.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php require_once __DIR__ . '/../templates/footer.php'; ?>
