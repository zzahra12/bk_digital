<?php 
require_once 'config.php'; 
if (!isLoggedIn() || getUserRole() != 'guru') { header("Location: login.php"); exit(); }

$keluhan_id = $_GET['id'] ?? 0;
if ($keluhan_id == 0) { header("Location: dashboard_guru.php"); exit(); }

$stmt = $pdo->prepare("SELECT k.keluhan_text, s.nama as siswa_nama FROM keluhan k JOIN users s ON k.siswa_id = s.id WHERE k.id = ?");
$stmt->execute([$keluhan_id]);
$keluhan = $stmt->fetch();
if (!$keluhan) { header("Location: dashboard_guru.php"); exit(); }

// Update status ke 'dibaca'
$pdo->prepare("UPDATE keluhan SET status = 'dibaca' WHERE id = ?")->execute([$keluhan_id]);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Balas Keluhan - Konseling SMK</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 20px; background-color: #f4f4f4; }
        .container { max-width: 600px; margin: 20px auto; padding: 20px; background: white; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        textarea { width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #ddd; border-radius: 5px; resize: vertical; }
        button { background-color: #4CAF50; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; }
        .back { margin-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Balas Keluhan dari <?php echo htmlspecialchars($keluhan['siswa_nama']); ?></h2>
        <p><strong>Keluhan:</strong><br><?php echo nl2br(htmlspecialchars($keluhan['keluhan_text'])); ?></p>
        
        <form action="process_balasan.php" method="POST">
            <input type="hidden" name="keluhan_id" value="<?php echo $keluhan_id; ?>">
            <label for="balasan">Balasan Anda (sertakan saran atau jadwal pertemuan):</label>
            <textarea id="balasan" name="balasan_text" rows="6" required placeholder="Tulis balasan Anda di sini..."></textarea>
            <button type="submit">Kirim Balasan</button>
        </form>
        
        <div class="back">
            <a href="dashboard_guru.php">← Kembali ke Dashboard</a>
        </div>
    </div>
</body>
</html>
