<?php

require_once __DIR__ . '/../config/Database.php';

class Laporan
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    /**
     * Dapatkan statistik peminjaman
     */
    public function getStatistikPeminjaman()
    {
        $stmt = $this->db->query("
            SELECT 
                COUNT(*) as total_peminjaman,
                SUM(CASE WHEN status = 'pengajuan' THEN 1 ELSE 0 END) as pengajuan,
                SUM(CASE WHEN status = 'disetujui' THEN 1 ELSE 0 END) as disetujui,
                SUM(CASE WHEN status = 'dipinjam' THEN 1 ELSE 0 END) as dipinjam,
                SUM(CASE WHEN status = 'dikembalikan' THEN 1 ELSE 0 END) as dikembalikan
            FROM peminjaman
        ");
        return $stmt->fetch();
    }

    /**
     * Dapatkan statistik pengembalian
     */
    public function getStatistikPengembalian()
    {
        $stmt = $this->db->query("
            SELECT 
                COUNT(*) as total_pengembalian,
                SUM(denda) as total_denda,
                AVG(denda) as rata_rata_denda,
                MAX(denda) as denda_terbesar
            FROM pengembalian
        ");
        return $stmt->fetch();
    }

    /**
     * Peminjaman per status
     */
    public function getPeminjamanPerStatus()
    {
        $stmt = $this->db->query("
            SELECT 
                status,
                COUNT(*) as jumlah
            FROM peminjaman
            GROUP BY status
            ORDER BY jumlah DESC
        ");
        return $stmt->fetchAll();
    }

    /**
     * Buku yang paling sering dipinjam
     */
    public function getBukuPalingDipinjam($limit = 10)
    {
        $stmt = $this->db->prepare("
            SELECT 
                b.id,
                b.judul,
                b.pengarang,
                COUNT(p.id) as total_peminjaman
            FROM buku b
            LEFT JOIN peminjaman p ON b.id = p.buku_id
            GROUP BY b.id, b.judul, b.pengarang
            ORDER BY total_peminjaman DESC
            LIMIT :limit
        ");
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * Pengguna paling aktif meminjam
     */
    public function getPenggunaPalingAktif($limit = 10)
    {
        $stmt = $this->db->prepare("
            SELECT 
                u.id,
                u.nama_lengkap,
                u.username,
                COUNT(p.id) as total_peminjaman
            FROM users u
            LEFT JOIN peminjaman p ON u.id = p.user_id
            WHERE u.role = 'siswa'
            GROUP BY u.id, u.nama_lengkap, u.username
            ORDER BY total_peminjaman DESC
            LIMIT :limit
        ");
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * Pengembalian per bulan
     */
    public function getPengembalianPerBulan($tahun = null)
    {
        if (!$tahun) {
            $tahun = date('Y');
        }

        $stmt = $this->db->prepare("
            SELECT 
                MONTH(tanggal_pengembalian) as bulan,
                MONTHNAME(tanggal_pengembalian) as nama_bulan,
                COUNT(*) as total_pengembalian,
                SUM(denda) as total_denda
            FROM pengembalian
            WHERE YEAR(tanggal_pengembalian) = :tahun
            GROUP BY MONTH(tanggal_pengembalian), MONTHNAME(tanggal_pengembalian)
            ORDER BY MONTH(tanggal_pengembalian)
        ");
        $stmt->execute(['tahun' => $tahun]);
        return $stmt->fetchAll();
    }

    /**
     * Peminjaman per bulan
     */
    public function getPeminjamanPerBulan($tahun = null)
    {
        if (!$tahun) {
            $tahun = date('Y');
        }

        $stmt = $this->db->prepare("
            SELECT 
                MONTH(tanggal_pinjam) as bulan,
                MONTHNAME(tanggal_pinjam) as nama_bulan,
                COUNT(*) as total_peminjaman
            FROM peminjaman
            WHERE YEAR(tanggal_pinjam) = :tahun
            GROUP BY MONTH(tanggal_pinjam), MONTHNAME(tanggal_pinjam)
            ORDER BY MONTH(tanggal_pinjam)
        ");
        $stmt->execute(['tahun' => $tahun]);
        return $stmt->fetchAll();
    }

    /**
     * Peminjaman yang terlambat
     */
    public function getPeminjamanTerlambat()
    {
        $stmt = $this->db->query("
            SELECT 
                p.*,
                u.nama_lengkap,
                b.judul,
                DATEDIFF(CURDATE(), p.tanggal_kembali) as hari_terlambat,
                DATEDIFF(CURDATE(), p.tanggal_kembali) * 5000 as estimasi_denda
            FROM peminjaman p
            JOIN users u ON p.user_id = u.id
            JOIN buku b ON p.buku_id = b.id
            WHERE p.tanggal_kembali < CURDATE() 
            AND p.status IN ('disetujui', 'dipinjam')
            ORDER BY hari_terlambat DESC
        ");
        return $stmt->fetchAll();
    }

    /**
     * Laporan lengkap peminjaman dan pengembalian
     */
    public function getLaporanLengkap($tanggal_awal = null, $tanggal_akhir = null)
    {
        if (!$tanggal_awal) {
            $tanggal_awal = date('Y-m-01');
        }
        if (!$tanggal_akhir) {
            $tanggal_akhir = date('Y-m-t');
        }

        $stmt = $this->db->prepare("
            SELECT 
                p.id,
                p.tanggal_pinjam,
                p.tanggal_kembali,
                p.status,
                u.nama_lengkap,
                u.username,
                b.judul,
                b.pengarang,
                pg.tanggal_pengembalian,
                pg.denda,
                pg.keterangan
            FROM peminjaman p
            JOIN users u ON p.user_id = u.id
            JOIN buku b ON p.buku_id = b.id
            LEFT JOIN pengembalian pg ON p.id = pg.peminjaman_id
            WHERE DATE(p.tanggal_pinjam) BETWEEN :tanggal_awal AND :tanggal_akhir
            ORDER BY p.tanggal_pinjam DESC
        ");
        $stmt->execute([
            'tanggal_awal' => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir
        ]);
        return $stmt->fetchAll();
    }

    /**
     * Statistik stok buku
     */
    public function getStatistikStok()
    {
        $stmt = $this->db->query("
            SELECT 
                COUNT(*) as total_buku,
                SUM(jumlah_stok) as total_stok,
                SUM(CASE WHEN jumlah_stok = 0 THEN 1 ELSE 0 END) as buku_habis,
                SUM(CASE WHEN jumlah_stok > 0 AND jumlah_stok <= 3 THEN 1 ELSE 0 END) as buku_hampir_habis
            FROM buku
        ");
        return $stmt->fetch();
    }
}
