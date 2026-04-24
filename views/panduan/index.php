<?php $pageTitle = 'Cara Meminjam Buku'; ?>

<!-- Panduan Container -->
<div class="container-fluid">
    <!-- Intro Section -->
    <div class="card mb-4" style="border: none; border-radius: 1rem; overflow: hidden; box-shadow: var(--card-shadow);">
        <div class="card-body p-4" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
            <h2 class="mb-2"><i class="bi bi-lightbulb me-2"></i>Panduan Meminjam Buku</h2>
            <p class="mb-0 opacity-75">Ikuti langkah-langkah sederhana di bawah untuk meminjam buku dari perpustakaan kami</p>
        </div>
    </div>

    <!-- Main Steps -->
    <div class="row mb-4">
        <!-- Step 1 -->
        <div class="col-lg-6 mb-3">
            <div class="card h-100" style="border: 2px solid #667eea; border-radius: 1rem;">
                <div class="card-body">
                    <div class="d-flex align-items-start mb-3">
                        <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center text-white me-3" style="width: 50px; height: 50px; flex-shrink: 0; font-size: 1.5rem; font-weight: bold;">
                            1
                        </div>
                        <div>
                            <h5 class="card-title mb-2"><strong>Jelajahi Katalog Buku</strong></h5>
                            <p class="text-muted mb-0">Buka menu <strong>"Katalog Buku"</strong> di sidebar untuk melihat daftar lengkap buku yang tersedia di perpustakaan.</p>
                        </div>
                    </div>
                    <div class="alert alert-info py-2">
                        <i class="bi bi-info-circle me-2"></i>
                        <small>Kamu bisa melihat judul, pengarang, penerbit, kategori, dan jumlah stok buku</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Step 2 -->
        <div class="col-lg-6 mb-3">
            <div class="card h-100" style="border: 2px solid #667eea; border-radius: 1rem;">
                <div class="card-body">
                    <div class="d-flex align-items-start mb-3">
                        <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center text-white me-3" style="width: 50px; height: 50px; flex-shrink: 0; font-size: 1.5rem; font-weight: bold;">
                            2
                        </div>
                        <div>
                            <h5 class="card-title mb-2"><strong>Pilih Buku yang Ingin Dipinjam</strong></h5>
                            <p class="text-muted mb-0">Cari buku yang ingin kamu pinjam. Pastikan buku tersebut memiliki stok yang tersedia (stok > 0).</p>
                        </div>
                    </div>
                    <div class="alert alert-warning py-2">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        <small>Buku dengan stok "Habis" tidak bisa dipinjam untuk saat ini</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Step 3 -->
        <div class="col-lg-6 mb-3">
            <div class="card h-100" style="border: 2px solid #667eea; border-radius: 1rem;">
                <div class="card-body">
                    <div class="d-flex align-items-start mb-3">
                        <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center text-white me-3" style="width: 50px; height: 50px; flex-shrink: 0; font-size: 1.5rem; font-weight: bold;">
                            3
                        </div>
                        <div>
                            <h5 class="card-title mb-2"><strong>Ajukan Permintaan Peminjaman</strong></h5>
                            <p class="text-muted mb-0">Klik tombol <strong>"Pinjam"</strong> atau <strong>"Ajukan"</strong> pada buku pilihan kamu, lalu isi form permintaan peminjaman.</p>
                        </div>
                    </div>
                    <div class="alert alert-info py-2">
                        <i class="bi bi-info-circle me-2"></i>
                        <small>Isi tanggal pinjam dan tanggal target pengembalian dengan sesuai</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Step 4 -->
        <div class="col-lg-6 mb-3">
            <div class="card h-100" style="border: 2px solid #667eea; border-radius: 1rem;">
                <div class="card-body">
                    <div class="d-flex align-items-start mb-3">
                        <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center text-white me-3" style="width: 50px; height: 50px; flex-shrink: 0; font-size: 1.5rem; font-weight: bold;">
                            4
                        </div>
                        <div>
                            <h5 class="card-title mb-2"><strong>Tunggu Persetujuan Admin</strong></h5>
                            <p class="text-muted mb-0">Admin perpustakaan akan memproses permintaan peminjaman kamu. Cek status di menu <strong>"Peminjaman Saya"</strong>.</p>
                        </div>
                    </div>
                    <div class="alert alert-info py-2">
                        <i class="bi bi-info-circle me-2"></i>
                        <small>Proses persetujuan biasanya dilakukan dalam 1-2 hari kerja</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Step 5 -->
        <div class="col-lg-6 mb-3">
            <div class="card h-100" style="border: 2px solid #667eea; border-radius: 1rem;">
                <div class="card-body">
                    <div class="d-flex align-items-start mb-3">
                        <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center text-white me-3" style="width: 50px; height: 50px; flex-shrink: 0; font-size: 1.5rem; font-weight: bold;">
                            5
                        </div>
                        <div>
                            <h5 class="card-title mb-2"><strong>Ambil Buku di Perpustakaan</strong></h5>
                            <p class="text-muted mb-0">Setelah disetujui, datang ke perpustakaan untuk mengambil buku dengan membawa bukti peminjaman.</p>
                        </div>
                    </div>
                    <div class="alert alert-warning py-2">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        <small>Jangan lupa memenuhi batas tanggal pengembalian yang telah ditentukan</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Step 6 -->
        <div class="col-lg-6 mb-3">
            <div class="card h-100" style="border: 2px solid #667eea; border-radius: 1rem;">
                <div class="card-body">
                    <div class="d-flex align-items-start mb-3">
                        <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center text-white me-3" style="width: 50px; height: 50px; flex-shrink: 0; font-size: 1.5rem; font-weight: bold;">
                            6
                        </div>
                        <div>
                            <h5 class="card-title mb-2"><strong>Kembalikan Buku Tepat Waktu</strong></h5>
                            <p class="text-muted mb-0">Kembalikan buku ke perpustakaan sebelum batas tanggal pengembalian. Perpustakaan akan mencatat pengembalian.</p>
                        </div>
                    </div>
                    <div class="alert alert-success py-2">
                        <i class="bi bi-check-circle me-2"></i>
                        <small>Buku yang dikembalikan akan muncul di history peminjaman kamu</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Important Rules -->
    <div class="card mb-4" style="border-left: 5px solid #dc3545;">
        <div class="card-header bg-light">
            <h5 class="mb-0"><i class="bi bi-exclamation-triangle me-2 text-danger"></i>Tata Tertib Peminjaman</h5>
        </div>
        <div class="card-body">
            <ul class="list-group list-group-flush">
                <li class="list-group-item d-flex">
                    <i class="bi bi-check-lg text-success me-2"></i>
                    <span>Siswa dapat meminjam maksimal <strong>3 buku sekaligus</strong></span>
                </li>
                <li class="list-group-item d-flex">
                    <i class="bi bi-check-lg text-success me-2"></i>
                    <span>Durasi peminjaman adalah <strong>14 hari</strong> (dua minggu)</span>
                </li>
                <li class="list-group-item d-flex">
                    <i class="bi bi-check-lg text-success me-2"></i>
                    <span>Perpanjangan peminjaman dapat dilakukan jika buku belum di-request oleh siswa lain</span>
                </li>
                <li class="list-group-item d-flex">
                    <strong style="color: #dc3545;"><i class="bi bi-x-lg text-danger me-2"></i>
                    Keterlambatan pengembalian akan dikenakan denda Rp 5.000 per hari</strong>
                </li>
                <li class="list-group-item d-flex">
                    <strong style="color: #dc3545;"><i class="bi bi-x-lg text-danger me-2"></i>
                    Buku yang hilang atau rusak akan diganti dengan buku baru atau denda pengganti</strong>
                </li>
                <li class="list-group-item d-flex">
                    <i class="bi bi-check-lg text-success me-2"></i>
                    <span>Buku dengan kondisi rusak sebaiknya dilestarikan dan dikembalikan dalam kondisi baik</span>
                </li>
            </ul>
        </div>
    </div>

    <!-- FAQ Section -->
    <div class="card">
        <div class="card-header bg-light">
            <h5 class="mb-0"><i class="bi bi-question-circle me-2"></i>Pertanyaan Umum (FAQ)</h5>
        </div>
        <div class="card-body">
            <div class="accordion" id="faqAccordion">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                            Berapa lama proses persetujuan peminjaman buku?
                        </button>
                    </h2>
                    <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Proses persetujuan biasanya memakan waktu <strong>1-2 hari kerja</strong>. Hasil persetujuan akan ditampilkan di halaman "Peminjaman Saya".
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                            Apa yang harus dilakukan jika lupa buku di sekolah?
                        </button>
                    </h2>
                    <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Silakan datang ke perpustakaan secepatnya atau hubungi admin untuk melaporkan keterlambatan. Keterlambatan akan dikenakan denda Rp 5.000 per hari.
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                            Bisakah saya memperbarui jadwal peminjaman?
                        </button>
                    </h2>
                    <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Tidak bisa diubah melalui sistem. Silakan hubungi <strong>admin perpustakaan</strong> untuk perubahan jadwal peminjaman.
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq4">
                            Bagaimana jika buku yang ingin dipinjam habis?
                        </button>
                    </h2>
                    <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Tunggu sampai ada stok baru atau hubungi admin untuk reservasi buku. Sistem akan memberitahu ketika buku tersedia kembali.
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq5">
                            Bisakah saya memperpanjang peminjaman buku?
                        </button>
                    </h2>
                    <div id="faq5" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Ya, bisa. Silakan hubungi admin perpustakaan untuk meminta perpanjangan, dengan syarat buku tersebut belum di-request oleh siswa lain.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Contact Section -->
    <div class="row mt-4 mb-4">
        <div class="col-md-6">
            <div class="card bg-light border-0">
                <div class="card-body text-center">
                    <i class="bi bi-telephone text-primary" style="font-size: 2rem;"></i>
                    <h6 class="mt-3 mb-2">Hubungi Admin</h6>
                    <p class="text-muted mb-0">Telp: 0812-3456-7890<br>Jam Kerja: Senin - Jumat, 07:00 - 15:00</p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card bg-light border-0">
                <div class="card-body text-center">
                    <i class="bi bi-geo-alt text-success" style="font-size: 2rem;"></i>
                    <h6 class="mt-3 mb-2">Lokasi Perpustakaan</h6>
                    <p class="text-muted mb-0">Ruang 101, Gedung A<br>Jl. Pendidikan No. 123</p>
                </div>
            </div>
        </div>
    </div>
</div>