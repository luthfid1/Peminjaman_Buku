<?php
$pageTitle = 'Data Anggota';
$pageIcon = 'people';
require_once __DIR__ . '/../templates/header.php';
require_once __DIR__ . '/../templates/sidebar.php';
?>

<div class="card data-card">
    <div class="card-header">
        <h5><i class="bi bi-people me-2"></i>Daftar Anggota (Siswa)</h5>
        <a href="<?= App::BASE_URL ?>/index.php?page=anggota&action=create" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-lg me-1"></i>Tambah Anggota
        </a>
    </div>
    <div class="card-body p-0">
        <?php if (!empty($anggota)): ?>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Username</th>
                            <th>Nama Lengkap</th>
                            <th>Tgl Daftar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($anggota as $i => $a): ?>
                            <tr>
                                <td><?= $i + 1 ?></td>
                                <td><code><?= htmlspecialchars($a->username) ?></code></td>
                                <td><strong><?= htmlspecialchars($a->nama_lengkap) ?></strong></td>
                                <td><?= date('d/m/Y', strtotime($a->created_at)) ?></td>
                                <td>
                                    <a href="<?= App::BASE_URL ?>/index.php?page=anggota&action=edit&id=<?= $a->id ?>" class="btn btn-warning btn-sm" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a href="<?= App::BASE_URL ?>/index.php?page=anggota&action=delete&id=<?= $a->id ?>" class="btn btn-danger btn-sm" title="Hapus" onclick="return confirm('Yakin ingin menghapus anggota ini?')">
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
                <i class="bi bi-person-x d-block"></i>
                <h5>Belum ada anggota</h5>
                <p class="text-muted">Klik tombol "Tambah Anggota" untuk menambahkan.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php require_once __DIR__ . '/../templates/footer.php'; ?>
