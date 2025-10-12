<?php 
require_once 'config.php'; 
if (!isLoggedIn() || getUserRole() != 'guru') { header("Location: login.php"); exit(); }

$stmt = $pdo->query("
    SELECT k.id, k.keluhan_text, k.tanggal, k.status, s.nama as siswa_nama, s.kelas 
    FROM keluhan k 
    JOIN users s ON k.siswa_id = s.id 
    ORDER BY k.tanggal DESC
");
$keluhan_list = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Guru - Konseling SMK</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 20px; background-color: #f4f4f4; }
        header { background-color: #4CAF50; color: white; padding: 15px; text-align: center; border-radius: 5px; }
        .container { max-width: 800px; margin: 20px auto; padding: 20px; background: white; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        .keluhan { border: 1px solid #ddd; margin: 15px 0; padding: 15px; border-radius: 5px; background: #f9f9f9; }
        .keluhan h3 { margin-top: 0; color: #333; }
        .status-baru { color: #ff9800; font-weight: bold; }
        .status-dibaca { color: #2196F3; }
        .status-dibalas { color: #4CAF50; }
        a { color: #4CAF50; text-decoration: none; }
        a:hover { text-decoration: underline; }
        .nav { text-align: center; margin: 20px 0; }
    </style>
</head>
<body>
    <header>
        <h1>Selamat Datang, <?php echo $_SESSION['nama']; ?>!</h1>
        <p>Role: Guru BK</p>
    </header>
    
    <div class="nav">
        <a href="logout.php">Logout</a>
    </div>
    
    <div class="container">
        <h2>Daftar Keluhan Siswa</h2>
        <p>Klik "Balas" untuk merespons keluhan siswa atau buat jadwal pertemuan.</p>
        
        <?php if (empty($keluhan_list)): ?>
            <p>Belum ada keluhan dari siswa.</p>
        <?php else: ?>
            <?php foreach ($keluhan_list as $k): ?>
                <div class="keluhan">
                    <h3>Dari: <?php echo htmlspecialchars($k['siswa_nama']); ?> (Kelas: <?php echo htmlspecialchars($k['kelas'] ?? 'Tidak ditentukan'); ?>)</h3>
                    <p><strong>Tanggal:</strong> <?php echo date('d/m/Y H:i', strtotime($k['tanggal'])); ?></p>
                    <p><strong>Status:</strong> <span class="status-<?php echo $k['status']; ?>"> <?php echo ucfirst($k['status']); ?> </span></p>
                    <p><strong>Keluhan:</strong><br><?php echo nl2br(htmlspecialchars($k['keluhan_text'])); ?></p>
                    <a href="balas_keluhan.php?id=<?php echo $k['id']; ?>">Balas Keluhan</a>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</body>
</html>