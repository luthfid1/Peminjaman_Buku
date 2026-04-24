<?php
$pageTitle = 'Edit Anggota';
$pageIcon = 'pencil';
require_once __DIR__ . '/../templates/header.php';
require_once __DIR__ . '/../templates/sidebar.php';
?>

<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card form-card">
            <div class="card-header">
                <h5><i class="bi bi-pencil me-2"></i>Edit Anggota</h5>
            </div>
            <div class="card-body">
                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger"><i class="bi bi-exclamation-triangle me-2"></i><?= $error ?></div>
                <?php endif; ?>

                <form method="POST">
                    <div class="mb-3">
                        <label for="nama_lengkap" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" value="<?= htmlspecialchars($_POST['nama_lengkap'] ?? $anggota_item->nama_lengkap) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="username" class="form-label">Username <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="username" name="username" value="<?= htmlspecialchars($_POST['username'] ?? $anggota_item->username) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password <small class="text-muted">(kosongkan jika tidak ingin mengubah)</small></label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i>Update</button>
                        <a href="<?= App::BASE_URL ?>/index.php?page=anggota" class="btn btn-secondary"><i class="bi bi-arrow-left me-1"></i>Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../templates/footer.php'; ?>
