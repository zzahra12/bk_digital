<?php
$host = 'localhost';
$dbname = 'konseling_smk';  // Coba ganti ke nama lain kalau beda, misal 'bk_digital'
$username = 'root';
$password = '';

echo "<h2>Debug Database Konseling SMK</h2>";
echo "<p>Host: $host | DB: $dbname | User: $username</p>";

try {
    // Koneksi ke MySQL tanpa DB dulu (untuk list semua DB)
    $pdo_all = new PDO("mysql:host=$host;charset=utf8", $username, $password);
    $pdo_all->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<h3>Daftar Semua Database:</h3>";
    $dbs = $pdo_all->query("SHOW DATABASES")->fetchAll(PDO::FETCH_COLUMN);
    echo "<ul>";
    foreach ($dbs as $db) {
        echo "<li>$db</li>";
    }
    echo "</ul>";
    
    // Cek apakah DB konseling_smk ada
    if (in_array($dbname, $dbs)) {
        echo "<p style='color:green;'>✅ Database '$dbname' ADA!</p>";
        
        // Koneksi ke DB spesifik
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // List semua tabel di DB
        echo "<h3>Daftar Tabel di '$dbname':</h3>";
        $tables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
        echo "<ul>";
        if (empty($tables)) {
            echo "<li style='color:red;'>❌ TIDAK ADA TABEL! (Ini penyebab error)</li>";
        } else {
            foreach ($tables as $table) {
                echo "<li style='color:blue;'>$table</li>";
            }
        }
        echo "</ul>";
        
        // Cek spesifik tabel users
        $check_users = $pdo->query("SHOW TABLES LIKE 'users'")->fetch();
        if ($check_users) {
            echo "<p style='color:green;'>✅ Tabel 'users' ADA!</p>";
            
            // Cek data di users
            $users = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
            echo "<p>Jumlah user: $users</p>";
            if ($users > 0) {
                $sample = $pdo->query("SELECT username FROM users LIMIT 1")->fetchColumn();
                echo "<p>Contoh username: $sample</p>";
            }
        } else {
            echo "<p style='color:red;'>❌ Tabel 'users' TIDAK ADA! Jalankan CREATE TABLE.</p>";
        }
        
        // Cek tabel lain
        $check_keluhan = $pdo->query("SHOW TABLES LIKE 'keluhan'")->fetch();
        echo "<p>Tabel 'keluhan': " . ($check_keluhan ? "✅ ADA" : "❌ TIDAK ADA") . "</p>";
        
        $check_balasan = $pdo->query("SHOW TABLES LIKE 'balasan'")->fetch();
        echo "<p>Tabel 'balasan': " . ($check_balasan ? "✅ ADA" : "❌ TIDAK ADA") . "</p>";
        
    } else {
        echo "<p style='color:red;'>❌ Database '$dbname' TIDAK ADA! Buat dulu.</p>";
        echo "<p>Coba cek nama DB di Laragon (mungkin 'bk_digital' atau lain?).</p>";
    }
    
} catch(PDOException $e) {
    echo "<p style='color:red;'>❌ Koneksi GAGAL: " . $e->getMessage() . "</p>";
    echo "<p>Cek: Laragon MySQL running? Password root kosong?</p>";
}

// Tombol untuk buat DB otomatis (klik kalau mau)
echo "<hr><p><a href='setup.php' style='background:#4CAF50;color:white;padding:10px;'>Klik di sini untuk Setup Otomatis (buat DB & tabel)</a></p>";
?>