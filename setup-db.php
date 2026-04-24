<?php
// Setup Database Script
require_once __DIR__ . '/config/App.php';

try {
    // Connect ke MySQL server tanpa database nama dulu
    $connection = new PDO(
        "mysql:host=" . App::DB_HOST,
        App::DB_USER,
        App::DB_PASS,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
        ]
    );
    
    // Baca SQL file
    $sqlFile = __DIR__ . '/perpustakaan.sql';
    $sqlContent = file_get_contents($sqlFile);
    
    // Eksekusi setiap statement
    $statements = explode(';', $sqlContent);
    $count = 0;
    
    foreach ($statements as $statement) {
        $statement = trim($statement);
        if (!empty($statement)) {
            $connection->exec($statement);
            $count++;
        }
    }
    
    echo "✓ Database setup berhasil!\n";
    echo "✓ Eksekusi SQL: $count statements\n";
    echo "\nData login:\n";
    echo "Username: admin\n";
    echo "Password: 1234\n";
    
} catch (PDOException $e) {
    echo "✗ Error: " . $e->getMessage() . "\n";
}
?>
