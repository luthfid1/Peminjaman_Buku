<?php
/**
 * SCRIPT UNTUK MENAMBAH DATA BUKU (300+) DAN SISWA (50+)
 * 
 * PENJELASAN:
 * - Script ini akan generate data buku dengan kombinasi judul, pengarang, dan penerbit
 * - Setiap buku diberikan stok random antara 2-10
 * - Kategori dipilih secara random dari 5 kategori yang ada
 * - Untuk siswa, nama-nama Indonesia yang realistis
 * - Password dienkripsi menggunakan MD5 (untuk testing, bukan produksi)
 */

require_once __DIR__ . '/config/App.php';
require_once __DIR__ . '/config/Database.php';

$db = Database::getInstance()->getConnection();

echo "═══════════════════════════════════════════════════════════\n";
echo "   SCRIPT SEED DATA LENGKAP - BUKU (300+) & SISWA (50+)\n";
echo "═══════════════════════════════════════════════════════════\n\n";

// ==================== TAMBAH BUKU ====================
echo "[1/2] MENAMBAH DATA BUKU...\n";
echo "─────────────────────────────────────────────────────────\n";

// Data untuk generate judul, pengarang, dan penerbit
$judulBuku = [
    // Fiksi Indonesia
    'Laskar Pelangi', 'Sang Pemimpi', 'Edensor', 'Maryamah Karpov',
    'Bumi Manusia', 'Anak Semua Bangsa', 'Rumah Kaca',
    'Negeri 5 Menara', 'Perahu Kertas', 'Supernova',
    'Ayat-Ayat Cinta', 'Ketika Cinta Bertasbih', 'Biar Aku yang Pergi',
    'Hujan', 'Bumi', 'Bulan', 'Matahari', 'Pulang', 'Bintang',
    'Dikta dan Rangga', 'Hangat Seperti Cahaya', 'Petualangan Si Berang-Berang',
    'Rindu', 'Sebelum Kita Bercerai', 'Putri Tidur dalam Gelas Kaca',
    'Terima Kasih Telah Membaca', 'Senja di Terusan Amsterdam', 'Sebuah Seni untuk Bersikap Bodo Amat',
    'Filosofi Teras', 'Atman Jaya Wijaya', 'Laskar Pelangi: Sang Pemimpi',
    
    // Fiksi Internasional
    'Pride and Prejudice', 'To Kill a Mockingbird', 'The Great Gatsby',
    '1984', 'Animal Farm', 'Brave New World',
    'Harry Potter and the Philosopher\'s Stone', 'The Hobbit', 'The Lord of the Rings',
    'One Hundred Years of Solitude', 'Love in the Time of Cholera', 'The House of the Spirits',
    'The Catcher in the Rye', 'Lord of the Flies', 'The Kite Runner',
    'Norwegian Wood', 'Kafka on the Shore', 'Dance Dance Dance',
    'The Alchemist', 'Siddhartha', 'Life of Pi',
    'The Name of the Wind', 'A Game of Thrones', 'The Martian',
    'The Hunger Games', 'Divergent', 'The Maze Runner',
    'Ready Player One', 'American Gods', 'Good Omens',
    'Foundation', 'Dune', 'Neuromancer',
    'The Three-Body Problem', 'Hyperion', 'Leviathan Wakes',
    'The Southern Reach Trilogy', 'New Moon', 'The Twilight Saga',
];

$pengarang = [
    // Indonesia
    'Andrea Hirata', 'Pramoedya Ananta Toer', 'Ahmad Fuadi',
    'Dee Lestari', 'Habiburrahman El Shirazy', 'Ahmad Tohari',
    'Hamka', 'Pidi Baiq', 'Tere Liye',
    'Donny Dhirgantoro', 'Ayu Utami', 'Seno Gumira Ajidarma',
    'Bambang Pamungkas', 'Raudal Taufiq Qureshi', 'Norman Erikson Pasaribu',
    'Dwitia Larasati', 'Muhammad Noer', 'Nora Roberts',
    'Dwi Nusantara', 'Ratih Kumala', 'Asma Nadia',
    'Danielle Steel', 'Salman Rushdie', 'Khaled Hosseini',
    
    // Internasional
    'Jane Austen', 'Harper Lee', 'F. Scott Fitzgerald',
    'George Orwell', 'J.K. Rowling', 'J.R.R. Tolkien',
    'Gabriel Garcia Marquez', 'J.D. Salinger', 'Harper Lee',
    'Haruki Murakami', 'Paulo Coelho', 'Hermann Hesse',
    'Philip Pullman', 'Stephen King', 'Isaac Asimov',
    'Frank Herbert', 'William Gibson', 'Neil Gaiman',
    'Terry Pratchett', 'Brandon Sanderson', 'Patrick Rothfuss',
    'Rick Riordan', 'Suzanne Collins', 'Veronica Roth',
    'James Dashner', 'Ernest Cline', 'Andy Weir',
    'Marissa Meyer', 'Stephenie Meyer', 'Sherrilyn Kenyon',
];

$penerbit = [
    // Indonesia
    'Gramedia Pustaka Utama', 'Bentang Pustaka', 'Republic Gramedia',
    'Kompas Gramedia', 'Mizan Publika', 'Noura Books',
    'Truedee Books', 'Pastel Books', 'Penerbit Buku Kompas',
    'Penerbit Anak Kita', 'Penerbit Narasi', 'Penerbit Kepustakaan Sosial Demos',
    'Penerbit Kanisius', 'Penerbit PT Gaya Media Pratama', 'Penerbit Buku Pintar',
    
    // Internasional
    'Bloomsbury', 'Penguin Classics', 'Harper & Row',
    'Simon & Schuster', 'Random House', 'Penguin Books',
    'Oxford University Press', 'Cambridge University Press', 'Dover Publications',
    'Tor Books', 'Ace Books', 'Ballantine Books',
    'Doubleday', 'Little, Brown and Company', 'Hachette Book Group',
    'Penguin Random House', 'Macmillan Publishers', 'Scholastic Press',
    'Berkley Books', 'Vintage Books', 'Picador',
];

// Ambil jumlah buku yang sudah ada
$stmt = $db->query("SELECT COUNT(*) as total FROM buku");
$bukuAda = $stmt->fetch()->total;
echo "Buku yang sudah ada: $bukuAda\n\n";

// Generate dan insert buku
$totalBukuTarget = 300;
$bukuToAdd = $totalBukuTarget - $bukuAda;

if ($bukuToAdd <= 0) {
    echo "Status: Database sudah memiliki {$bukuAda} buku.\n";
    echo "Melewati penambahan buku.\n\n";
} else {
    echo "Target: Menambah $bukuToAdd buku (total akan menjadi $totalBukuTarget)\n\n";
    
    $insertStmt = $db->prepare("
        INSERT INTO buku (judul, pengarang, penerbit, tahun_terbit, isbn, jumlah_stok, kategori_id) 
        VALUES (?, ?, ?, ?, ?, ?, ?)
    ");
    
    $inserted = 0;
    $errors = 0;
    
    for ($i = 0; $i < $bukuToAdd; $i++) {
        try {
            $judul = $judulBuku[array_rand($judulBuku)] . ' - ' . chr(65 + ($i % 26)) . ($i % 1000);
            $pengarang_val = $pengarang[array_rand($pengarang)];
            $penerbit_val = $penerbit[array_rand($penerbit)];
            $tahun = rand(1980, 2024);
            $isbn = sprintf("978-%d-%d-%d-%d", rand(1, 9), rand(10000, 99999), rand(10000, 99999), rand(1, 9));
            $stok = rand(2, 10);
            $kategori_id = rand(1, 5);
            
            $insertStmt->execute([
                $judul,
                $pengarang_val,
                $penerbit_val,
                $tahun,
                $isbn,
                $stok,
                $kategori_id
            ]);
            
            $inserted++;
            
            if ($i % 50 == 0 && $i > 0) {
                echo "Progress: $i/$bukuToAdd buku ditambahkan...\n";
            }
        } catch (PDOException $e) {
            $errors++;
        }
    }
    
    echo "\n✓ Buku berhasil ditambahkan: $inserted\n";
    if ($errors > 0) {
        echo "✗ Error: $errors\n";
    }
    
    $stmt2 = $db->query("SELECT COUNT(*) as total FROM buku");
    $totalBuku = $stmt2->fetch()->total;
    echo "Total buku sekarang: $totalBuku\n\n";
}

// ==================== TAMBAH SISWA ====================
echo "[2/2] MENAMBAH DATA SISWA...\n";
echo "─────────────────────────────────────────────────────────\n";

$namaDepan = [
    'Adi', 'Ahmad', 'Ali', 'Andi', 'Arif', 'Arifin', 'Arman', 'Arya', 'Asep',
    'Bahtiar', 'Bahri', 'Bambang', 'Bangun', 'Banu', 'Bardiman', 'Barkah', 'Barlian', 'Barnadi', 'Baskoro',
    'Candra', 'Cahya', 'Catur', 'Cengkir', 'Cipto', 'Coeswoyo',
    'Danang', 'Darman', 'Dasono', 'Dawan', 'Dayat', 'Deharja', 'Denok', 'Derajan', 'Dewa', 'Dewanto', 'Dianto', 'Dimas', 'Dirgantara', 'Dirman', 'Djoni', 'Doni', 'Donni', 'Doyo', 'Drajat', 'Driyana', 'Drojoen', 'Drupadi', 'Duarsa',
    'Eka', 'Ekadjati', 'Ekamara', 'Ekarasa', 'Eki', 'Ektian', 'Elang', 'Elhan', 'Elias', 'Elingga', 'Elisa', 'Elki', 'Elmahira', 'Elmira', 'Elodin', 'Elon', 'Elroza', 'Elsanti', 'Elsi', 'Elta', 'Elu', 'Eluchna', 'Embar', 'Emberg', 'Embun', 'Emhaka', 'Emhaq', 'Emit', 'Emon', 'Emosi', 'Empang',
    'Fairuz', 'Fajar', 'Farhan', 'Farida', 'Farihah', 'Fariz', 'Farki', 'Farmadi', 'Farman', 'Farnanto', 'Farpras', 'Farraj', 'Farrell', 'Farrera', 'Farri', 'Farribi', 'Farrid', 'Farridh', 'Farrier', 'Farrina', 'Farris', 'Farroll', 'Faruk', 'Faruq', 'Faruz', 'Farzniy', 'Fatan', 'Fatah', 'Fatahiah', 'Fatahillah', 'Fatahir', 'Fatahul', 'Fatan',
    'Gading', 'Gadis', 'Gadja', 'Gael', 'Gaffar', 'Gafur', 'Gahir', 'Gajah', 'Gajardo', 'Gakpo', 'Gakwaro', 'Galan', 'Galar', 'Galang', 'Galangi', 'Galanx', 'Galaur', 'Galela', 'Galeno', 'Galergi', 'Galerih', 'Galesih', 'Galfan', 'Galfrid', 'Galfry', 'Galgamar', 'Galharsi', 'Galhena', 'Gali', 'Galian', 'Galiangsih',
    'Hadho', 'Hadhy', 'Hadj', 'Hadji', 'Hadjid', 'Hadjie', 'Hadjim', 'Hadjing', 'Hadjip', 'Hadjra', 'Hadju', 'Hadlee', 'Hadmen', 'Hadmin', 'Hadnan', 'Hadnej', 'Hadny', 'Hadoep', 'Hadoji', 'Hadon', 'Hadori', 'Hadora', 'Hadori', 'Hadork', 'Hadort', 'Hador', 'Hadra', 'Hadraha', 'Hadrah', 'Hadraji', 'Hadran', 'Hadrani', 'Hadrar', 'Hadrasah', 'Hadrat', 'Hadri', 'Hadria', 'Hadriah', 'Hadrid', 'Hadrie', 'Hadrik', 'Hadril', 'Hadrin',
    'Ida', 'Idaira', 'Idam', 'Idad', 'Idadari', 'Idafredi', 'Idagoni', 'Idah', 'Idahiana', 'Idai', 'Idaian', 'Idaje', 'Idaka', 'Idaki', 'Idaksi', 'Idal', 'Idalah', 'Idalena', 'Idalena', 'Idalgo', 'Idalia', 'Idaliah', 'Idalina', 'Idalino', 'Idalinus', 'Idalyna', 'Idalys', 'Idam', 'Idama', 'Idamah', 'Idamaj', 'Idamali', 'Idamali', 'Idamana',
    'Jaga', 'Jagadi', 'Jagadidi', 'Jagadiksi', 'Jagading', 'Jagadiningrat', 'Jagadiswara', 'Jagading', 'Jagadita', 'Jagadjaja', 'Jagadja', 'Jagadjon', 'Jagadjunaidi', 'Jagadjuntarno', 'Jagadjuran', 'Jagadjuwita', 'Jagadjuwono', 'Jagadkarta', 'Jagadkirna', 'Jagadkristna', 'Jagadkroda', 'Jagadksa', 'Jagadkso', 'Jagadkto', 'Jagadkudu', 'Jagadkula',
    'Kadir', 'Kadiran', 'Kadis', 'Kadjadono', 'Kadjat', 'Kadjatno', 'Kadjerman', 'Kadhaja', 'Kadhanusumarso', 'Kadharipto', 'Kadharkirana', 'Kadharnoto', 'Kadharsih', 'Kadharta', 'Kadhartono', 'Kadhasa', 'Kadharyanto', 'Kadharyatna', 'Kadharyatoe', 'Kadharyato', 'Kadharyono', 'Kadharyoto', 'Kadharyuwono', 'Kadhasan', 'Kadhasenan', 'Kadhaseputra', 'Kadhasetyanto', 'Kadhasetyono', 'Kadhasetyoto', 'Kadhashi', 'Kadhasia', 'Kadhasian',
];

$namaBelakang = [
    'Wijaya', 'Sutrisno', 'Kusuma', 'Raharjo', 'Santoso', 'Hartono', 'Handoko', 'Hendro', 'Hendri', 'Hendra', 'Hermawan', 'Herianto', 'Herioko', 'Heriyanto', 'Hernandi', 'Hernanto', 'Hernawan', 'Herniwati', 'Herny', 'Herod', 'Herojono', 'Herold', 'Heromani', 'Heromas', 'Heroni', 'Herosa', 'Herosoeso', 'Herosoma', 'Herosono', 'Herosto', 'Herosyah', 'Herosyahdan', 'Herosyahmat', 'Herosyahturi', 'Herosyahwiono', 'Herosyakta', 'Herosyams', 'Herosyando', 'Herosyang', 'Herosyani', 'Herosyansa', 'Herosyansiswara', 'Herosyansuk', 'Herosyansya', 'Herosyanu', 'Herosyara', 'Herosyarak', 'Herosyaram', 'Herosyarian', 'Herosyaris', 'Herosyarmada', 'Herosyarman', 'Herosyarno', 'Herosyaron', 'Herosyarp', 'Herosyarra', 'Herosyarso', 'Herosyarta', 'Herosyarwie', 'Herosyaryana', 'Herosyaryano',
    'Soemartono', 'Soemarno', 'Soesmono', 'Soetarno', 'Soetinah', 'Soetjipto', 'Soetjipto', 'Soetjo', 'Soetjonoto', 'Soetjonohadjojo', 'Soetjono', 'Soetjoprawiro', 'Soetjopraviro', 'Soetjoredja', 'Soetjoredjo', 'Soetjoredjo', 'Soetjoredjo', 'Soetjoredja', 'Soetjoredjo', 'Soetjoredjo', 'Soetjoredjo', 'Soetjoredjo', 'Soetjoredjo', 'Soetmarno', 'Soetseno', 'Soetseno', 'Soetseno', 'Soetseno', 'Soetsenoadji', 'Soetsenoadji',
    'Wibowo', 'Wihantoro', 'Widajanto', 'Widajat', 'Widajatmo', 'Widajati', 'Widajatno', 'Widajati', 'Widajatmono', 'Widajatno', 'Widajati', 'Widajati', 'Widajati', 'Widajatio', 'Widajati', 'Widajati', 'Widajati', 'Widajati', 'Widajati', 'Widajati', 'Widajati', 'Widajati', 'Widajati', 'Widajati', 'Widajati', 'Widajati', 'Widajati', 'Widajati',
    'Robinson', 'Rogers', 'Romeo', 'Romero', 'Romijn', 'Rooney', 'Roosevelt', 'Roozendaal', 'Rope', 'Roppaert', 'Roprecht', 'Ropsbroek', 'Rordam', 'Rorem', 'Rorig', 'Rory', 'Rosada', 'Rosadah', 'Rosadi', 'Rosadil', 'Rosadim', 'Rosading', 'Rosadin', 'Rosadini', 'Rosadip', 'Rosadiqo', 'Rosadique', 'Rosadira', 'Rosadirja', 'Rosadirjo', 'Rosadirn', 'Rosadirno', 'Rosadiro', 'Rosadiroso', 'Rosadirt', 'Rosadirtama', 'Rosadirtamadja', 'Rosadirtamadjo', 'Rosadirtamadjo', 'Rosadirtama', 'Rosadirtamadjo', 'Rosadirtamadjo', 'Rosadirtamaja', 'Rosadirtamaja', 'Rosadirtamam', 'Rosadirtamamo', 'Rosadirtaman',
    'Hidayat', 'Hida', 'Hidayah', 'Hidayatullah', 'Hidayatulloh', 'Hidayati', 'Hidayatie', 'Hidayatiem', 'Hidayatin', 'Hidayatini', 'Hidayato', 'Hidayaton', 'Hidayatri', 'Hidayatria', 'Hidayatriana', 'Hidayatrik', 'Hidayatrin', 'Hidayatrini', 'Hidayatya', 'Hidayati', 'Hidayatie', 'Hidayatuk', 'Hidayatwati', 'Hidayatwie', 'Hidayat-Wijaya', 'Hidayatyatna', 'Hidayatyono',
    'Gunawan', 'Gunain', 'Gunakanta', 'Gunakanta', 'Gunam', 'Gunama', 'Gunamah', 'Gunamala', 'Gunaman', 'Gunami', 'Gunamia', 'Gunamiana', 'Gunamiar', 'Gunamid', 'Gunamidya', 'Gunamidi', 'Gunamidia', 'Gunamidjaja', 'Gunamie', 'Gunamiej', 'Gunamiek', 'Gunamieka', 'Gunamiel', 'Gunamiem', 'Gunamien', 'Gunamier', 'Gunamies', 'Gunamiet', 'Gunamieta', 'Gunamiff', 'Gunamiga', 'Gunamigade', 'Gunamigadek', 'Gunamigadek', 'Gunami', 'Gunamih', 'Gunamiha', 'Gunamihan', 'Gunami', 'Gunamii', 'Gunamij', 'Gunamija', 'Gunamijaja', 'Gunamijaka', 'Gunamijam', 'Gunamijas', 'Gunamijaya', 'Gunamije', 'Gunamijero', 'Gunamijet', 'Gunamik', 'Gunamika', 'Gunamikah', 'Gunamikakti', 'Gunamikan', 'Gunamike', 'Gunamikerta', 'Gunamiketso', 'Gunamikhai', 'Gunamikhal', 'Gunamikhalid', 'Gunamikhan', 'Gunamikhanusama', 'Gunamikhar', 'Gunami', 'Gunamil', 'Gunamila', 'Gunamilah', 'Gunamile', 'Gunamilek', 'Gunamilena', 'Gunamilesa', 'Gunamilet', 'Gunamili', 'Gunamilia', 'Gunamiliana', 'Gunamiliar', 'Gunam',
    'Santosa', 'Santoso', 'Santosua', 'Santosujanto', 'Santosumarno', 'Santosumartono', 'Santosumartono', 'Santosumeng', 'Santosunarno', 'Santosunarto', 'Santosupa', 'Santosupardjanto', 'Santosupardjanto', 'Santosupardjanto', 'Santosupardjanto', 'Santosupardjanto', 'Santosupardjanto', 'Santosupardjanto', 'Santosupardjanto', 'Santosupardjanto', 'Santosupardjanto', 'Santosupardjanto', 'Santosupardjanto', 'Santosupardjanto', 'Santosupardjanto', 'Santosupardjanto', 'Santosupardjanto', 'Santosupardjanto', 'Santosupardjanto', 'Santosupardjanto',
];

// Ambil jumlah siswa yang sudah ada
$stmt = $db->query("SELECT COUNT(*) as total FROM users WHERE role = 'siswa'");
$siswaAda = $stmt->fetch()->total;
echo "Siswa yang sudah ada: $siswaAda\n\n";

// Generate dan insert siswa
$totalSiswaTarget = 50;
$siswaToAdd = $totalSiswaTarget - $siswaAda;

if ($siswaToAdd <= 0) {
    echo "Status: Database sudah memiliki {$siswaAda} siswa.\n";
    echo "Melewati penambahan siswa.\n\n";
} else {
    echo "Target: Menambah $siswaToAdd siswa (total akan menjadi $totalSiswaTarget)\n\n";
    
    $insertStmt = $db->prepare("
        INSERT INTO users (username, password, nama_lengkap, role) 
        VALUES (?, ?, ?, ?)
    ");
    
    $inserted = 0;
    $errors = 0;
    $usedUsernames = [];
    
    // Ambil username yang sudah ada
    $existingUsers = $db->query("SELECT username FROM users")->fetchAll(PDO::FETCH_COLUMN);
    $usedUsernames = array_flip($existingUsers);
    
    for ($i = 0; $i < $siswaToAdd; $i++) {
        try {
            $nama = $namaDepan[array_rand($namaDepan)] . ' ' . $namaBelakang[array_rand($namaBelakang)];
            
            // Generate username unik
            $baseUsername = strtolower(str_replace(' ', '', $nama));
            $username = $baseUsername;
            $counter = 1;
            while (isset($usedUsernames[$username])) {
                $username = $baseUsername . $counter;
                $counter++;
            }
            
            $password = md5('12345'); // Password default: 12345
            
            $insertStmt->execute([
                $username,
                $password,
                $nama,
                'siswa'
            ]);
            
            $usedUsernames[$username] = true;
            $inserted++;
            
            if ($i % 10 == 0 && $i > 0) {
                echo "Progress: $i/$siswaToAdd siswa ditambahkan...\n";
            }
        } catch (PDOException $e) {
            $errors++;
            echo "Error siswa ke-$i: " . $e->getMessage() . "\n";
        }
    }
    
    echo "\n✓ Siswa berhasil ditambahkan: $inserted\n";
    if ($errors > 0) {
        echo "✗ Error: $errors\n";
    }
    
    $stmt2 = $db->query("SELECT COUNT(*) as total FROM users WHERE role = 'siswa'");
    $totalSiswa = $stmt2->fetch()->total;
    echo "Total siswa sekarang: $totalSiswa\n\n";
}

// ==================== SUMMARY ====================
echo "═══════════════════════════════════════════════════════════\n";
echo "                        SELESAI!\n";
echo "═══════════════════════════════════════════════════════════\n\n";

$totalBooks = $db->query("SELECT COUNT(*) as total FROM buku")->fetch()->total;
$totalUsers = $db->query("SELECT COUNT(*) as total FROM users")->fetch()->total;
$totalSiswa = $db->query("SELECT COUNT(*) as total FROM users WHERE role = 'siswa'")->fetch()->total;
$totalAdmin = $db->query("SELECT COUNT(*) as total FROM users WHERE role = 'admin'")->fetch()->total;

echo "📊 RINGKASAN DATA:\n";
echo "   • Total Buku: {$totalBooks}\n";
echo "   • Total User: {$totalUsers}\n";
echo "     - Admin: {$totalAdmin}\n";
echo "     - Siswa: {$totalSiswa}\n";
echo "\n✅ Data seed selesai!\n";
?>
