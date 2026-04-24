<?php
$pageTitle = 'Tambah Kategori';
$pageIcon = 'plus-circle';
require_once __DIR__ . '/../templates/header.php';
require_once __DIR__ . '/../templates/sidebar.php';
?>

<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card form-card">
            <div class="card-header">
                <h5><i class="bi bi-plus-circle me-2"></i>Tambah Kategori Baru</h5>
            </div>
            <div class="card-body">
                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger"><i class="bi bi-exclamation-triangle me-2"></i><?= $error ?></div>
                <?php endif; ?>

                <form method="POST">
                    <div class="mb-3">
                        <label for="nama_kategori" class="form-label">Nama Kategori <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="nama_kategori" name="nama_kategori" value="<?= htmlspecialchars($_POST['nama_kategori'] ?? '') ?>" required autofocus>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i>Simpan</button>
                        <a href="<?= App::BASE_URL ?>/index.php?page=kategori" class="btn btn-secondary"><i class="bi bi-arrow-left me-1"></i>Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../templates/footer.php'; ?>
