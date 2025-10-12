<?php 
require_once 'config.php';  // Line 1: Include config (session_start() dan $pdo)
if (!isLoggedIn() || getUserRole() != 'siswa') { header("Location: login.php"); exit(); }  // Cek login siswa

$siswa_id = $_SESSION['user_id'] ?? 0;  // Line 3: Fix key 'user_id' (bukan 'users_id'), handle null
if ($siswa_id == 0) { header("Location: dashboard_siswa.php"); exit(); }  // Keamanan

// Query untuk fetch keluhan + balasan (handle null dengan LEFT JOIN)
$stmt = $pdo->prepare("
    SELECT k.id, k.keluhan_text, k.tanggal as keluhan_tanggal, k.status,
           b.balasan_text, b.tanggal as balasan_tanggal, u.nama as guru_nama
    FROM keluhan k 
    LEFT JOIN balasan b ON k.id = b.keluhan_id 
    LEFT JOIN users u ON b.guru_id = u.id 
    WHERE k.siswa_id = ? 
    ORDER BY k.tanggal DESC, b.tanggal DESC
");
$stmt->execute([$siswa_id]);  // Line 6: Execute dengan $pdo dari config
$keluhan_list = $stmt->fetchAll(PDO::FETCH_GROUP);  // Group by keluhan_id untuk multiple balasan
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keluhan Saya - Konseling SMK</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; background-color: #f4f4f4; margin: 0; }
        header { background-color: #4CAF50; color: white; padding: 15px; text-align: center; border-radius: 5px; }
        .container { max-width: 800px; margin: 20px auto; padding: 20px; background: white; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        .keluhan { border: 1px solid #ddd; margin: 15px 0; padding: 15px; border-radius: 5px; background: #f9f9f9; }
        .keluhan h3 { margin-top: 0; color: #333; }
        .balasan { background: #e8f5e8; margin-left: 20px; padding: 10px; border-radius: 5px; margin-top: 10px; }
        .status-baru { color: #ff9800; font-weight: bold; }
        .status-dibaca { color: #2196F3; }
        .status-dibalas { color: #4CAF50; }
        a { color: #4CAF50; text-decoration: none; }
        a:hover { text-decoration: underline; }
        .nav { text-align: center; margin: 20px 0; }
        .no-keluhan { text-align: center; color: #666; font-style: italic; }
    </style>
</head>
<body>
    <header>
        <h1>Selamat Datang, <?php echo htmlspecialchars($_SESSION['nama'] ?? 'Siswa'); ?>!</h1>
        <p>Role: Siswa</p>
    </header>
    
    <div class="nav">
        <a href="dashboard_siswa.php">← Kembali ke Dashboard</a> | 
        <a href="logout.php">Logout</a>
    </div>
    
    <div class="container">
        <h2>Keluhan Saya</h2>
        
        <?php if (empty($keluhan_list)): ?>
            <p class="no-keluhan">Belum ada keluhan. <a href="dashboard_siswa.php">Kirim keluhan baru</a>.</p>
        <?php else: ?>
            <?php foreach ($keluhan_list as $keluhan_id => $items): 
                $keluhan = $items[0];  // Keluhan pertama (utama)
                $tanggal_display = !empty($keluhan['keluhan_tanggal']) ? date('d/m/Y H:i', strtotime($keluhan['keluhan_tanggal'])) : 'Tidak tersedia';
                $status_display = $keluhan['status'] ?? 'baru';
                $status_class = $status_display;
            ?>
                <div class="keluhan">
                    <h3>Keluhan ID <?php echo $keluhan_id; ?> (<?php echo $tanggal_display; ?>)</h3>
                    <p><strong>Status:</strong> <span class="status-<?php echo htmlspecialchars($status_class); ?>"> <?php echo ucfirst($status_display); ?> </span></p>
                    <p><strong>Keluhan:</strong><br><?php echo nl2br(htmlspecialchars($keluhan['keluhan_text'] ?? '')); ?></p>
                    
                    <?php if (!empty($items)): ?>
                        <?php foreach ($items as $item): 
                            if (!empty($item['balasan_text'])): ?>
                                <div class="balasan">
                                    <h4>Balasan dari <?php echo htmlspecialchars($item['guru_nama'] ?? 'Guru'); ?> (<?php echo !empty($item['balasan_tanggal']) ? date('d/m/Y H:i', strtotime($item['balasan_tanggal'])) : 'Tidak tersedia'; ?>)</h4>
                                    <p><?php echo nl2br(htmlspecialchars($item['balasan_text'])); ?></p>
                                </div>
                            <?php endif; 
                        endforeach; ?>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</body>
</html>