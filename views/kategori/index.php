<?php
$pageTitle = 'Data Kategori';
$pageIcon = 'tags';
require_once __DIR__ . '/../templates/header.php';
require_once __DIR__ . '/../templates/sidebar.php';
?>

<div class="card data-card">
    <div class="card-header">
        <h5><i class="bi bi-tags me-2"></i>Daftar Kategori</h5>
        <a href="<?= App::BASE_URL ?>/index.php?page=kategori&action=create" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-lg me-1"></i>Tambah Kategori
        </a>
    </div>
    <div class="card-body p-0">
        <?php if (!empty($kategori)): ?>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Kategori</th>
                            <th>Dibuat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($kategori as $i => $k): ?>
                            <tr>
                                <td><?= $i + 1 ?></td>
                                <td><strong><?= htmlspecialchars($k->nama_kategori) ?></strong></td>
                                <td><?= date('d/m/Y', strtotime($k->created_at)) ?></td>
                                <td>
                                    <a href="<?= App::BASE_URL ?>/index.php?page=kategori&action=edit&id=<?= $k->id ?>" class="btn btn-warning btn-sm" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a href="<?= App::BASE_URL ?>/index.php?page=kategori&action=delete&id=<?= $k->id ?>" class="btn btn-danger btn-sm" title="Hapus" onclick="return confirm('Yakin ingin menghapus kategori ini?')">
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
                <i class="bi bi-tag d-block"></i>
                <h5>Belum ada kategori</h5>
                <p class="text-muted">Klik tombol "Tambah Kategori" untuk menambahkan.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php require_once __DIR__ . '/../templates/footer.php'; ?>
