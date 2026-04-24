<?php

require_once __DIR__ . '/../models/Laporan.php';

class LaporanController
{
    private $laporanModel;

    public function __construct()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . App::BASE_URL . '/index.php?page=auth&action=login');
            exit;
        }

        // Hanya admin yang bisa lihat laporan
        if ($_SESSION['role'] !== 'admin') {
            header('Location: ' . App::BASE_URL . '/index.php?page=dashboard');
            exit;
        }

        $this->laporanModel = new Laporan();
    }

    public function index()
    {
        // Ambil semua statistik
        $statistikPeminjaman = $this->laporanModel->getStatistikPeminjaman();
        $statistikPengembalian = $this->laporanModel->getStatistikPengembalian();
        $statistikStok = $this->laporanModel->getStatistikStok();
        $peminjamanPerStatus = $this->laporanModel->getPeminjamanPerStatus();
        $bukuPalingDipinjam = $this->laporanModel->getBukuPalingDipinjam(5);
        $penggunaPalingAktif = $this->laporanModel->getPenggunaPalingAktif(5);
        $peminjamanTerlambat = $this->laporanModel->getPeminjamanTerlambat();
        $peminjamanPerBulan = $this->laporanModel->getPeminjamanPerBulan();
        $pengembalianPerBulan = $this->laporanModel->getPengembalianPerBulan();

        require_once __DIR__ . '/../views/laporan/index.php';
    }

    public function lengkap()
    {
        $tanggal_awal = $_GET['tanggal_awal'] ?? null;
        $tanggal_akhir = $_GET['tanggal_akhir'] ?? null;

        $laporanData = $this->laporanModel->getLaporanLengkap($tanggal_awal, $tanggal_akhir);

        require_once __DIR__ . '/../views/laporan/lengkap.php';
    }

    public function export()
    {
        $tanggal_awal = $_GET['tanggal_awal'] ?? date('Y-m-01');
        $tanggal_akhir = $_GET['tanggal_akhir'] ?? date('Y-m-t');
        $format = $_GET['format'] ?? 'pdf';

        $laporanData = $this->laporanModel->getLaporanLengkap($tanggal_awal, $tanggal_akhir);

        if ($format === 'csv') {
            $this->exportCSV($laporanData, $tanggal_awal, $tanggal_akhir);
        } elseif ($format === 'pdf') {
            $this->exportPDF($laporanData, $tanggal_awal, $tanggal_akhir);
        }
    }

    private function exportCSV($data, $tanggal_awal, $tanggal_akhir)
    {
        $filename = 'Laporan_Peminjaman_' . $tanggal_awal . '_' . $tanggal_akhir . '.csv';
        header('Content-Type: text/csv; charset=UTF-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        $output = fopen('php://output', 'w');
        fputcsv($output, ['LAPORAN PEMINJAMAN DAN PENGEMBALIAN BUKU']);
        fputcsv($output, ['Periode: ' . $tanggal_awal . ' s/d ' . $tanggal_akhir]);
        fputcsv($output, []);

        // Header
        fputcsv($output, [
            'No',
            'ID Peminjaman',
            'Nama Peminjam',
            'Username',
            'Judul Buku',
            'Pengarang',
            'Tanggal Pinjam',
            'Tanggal Kembali',
            'Status',
            'Tanggal Pengembalian',
            'Denda'
        ]);

        // Data
        $no = 1;
        foreach ($data as $row) {
            fputcsv($output, [
                $no++,
                $row->id,
                $row->nama_lengkap,
                $row->username,
                $row->judul,
                $row->pengarang,
                date('d/m/Y', strtotime($row->tanggal_pinjam)),
                date('d/m/Y', strtotime($row->tanggal_kembali)),
                $row->status,
                $row->tanggal_pengembalian ? date('d/m/Y', strtotime($row->tanggal_pengembalian)) : '-',
                'Rp ' . number_format($row->denda ?? 0, 0, ',', '.')
            ]);
        }

        fclose($output);
        exit;
    }

    private function exportPDF($data, $tanggal_awal, $tanggal_akhir)
    {
        // Untuk PDF bisa menggunakan library seperti TCPDF atau mPDF
        // Untuk sekarang, kita buat simple HTML yang bisa di-print dengan Ctrl+P
        header('Content-Type: text/html; charset=UTF-8');
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <title>Laporan Peminjaman</title>
            <style>
                body { font-family: Arial; margin: 20px; }
                table { border-collapse: collapse; width: 100%; margin-top: 20px; }
                th, td { border: 1px solid #000; padding: 8px; text-align: left; }
                th { background-color: #f2f2f2; }
                .header { text-align: center; margin-bottom: 30px; }
            </style>
        </head>
        <body>
            <div class="header">
                <h2>LAPORAN PEMINJAMAN DAN PENGEMBALIAN BUKU</h2>
                <p>Periode: <?= $tanggal_awal ?> s/d <?= $tanggal_akhir ?></p>
                <p>Tanggal Cetak: <?= date('d/m/Y H:i:s') ?></p>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>ID</th>
                        <th>Nama Peminjam</th>
                        <th>Judul Buku</th>
                        <th>Tgl Pinjam</th>
                        <th>Tgl Kembali</th>
                        <th>Status</th>
                        <th>Denda</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; foreach ($data as $row): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $row->id ?></td>
                        <td><?= htmlspecialchars($row->nama_lengkap) ?></td>
                        <td><?= htmlspecialchars($row->judul) ?></td>
                        <td><?= date('d/m/Y', strtotime($row->tanggal_pinjam)) ?></td>
                        <td><?= date('d/m/Y', strtotime($row->tanggal_kembali)) ?></td>
                        <td><?= $row->status ?></td>
                        <td>Rp <?= number_format($row->denda ?? 0, 0, ',', '.') ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <script>
                window.print();
            </script>
        </body>
        </html>
        <?php
        exit;
    }
}
