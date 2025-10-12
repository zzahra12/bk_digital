<?php 
require_once 'config.php'; 
if (!isLoggedIn() || getUserRole() != 'siswa') { header("Location: login.php"); exit(); }
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Siswa - Konseling SMK</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 20px; background-color: #f4f4f4; }
        header { background-color: #4CAF50; color: white; padding: 15px; text-align: center; }
        .container { max-width: 600px; margin: 20px auto; padding: 20px; background: white; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        form { display: flex; flex-direction: column; }
        textarea { padding: 10px; margin: 10px 0; border: 1px solid #ddd; border-radius: 5px; resize: vertical; }
        button { background-color: #4CAF50; color: white; padding: 10px; border: none; border-radius: 5px; cursor: pointer; }
        .nav { text-align: center; margin: 20px 0; }
        .nav a { margin: 0 10px; color: #4CAF50; text-decoration: none; }
    </style>
</head>
<body>
    <header>
        <h1>Selamat Datang, <?php echo $_SESSION['nama']; ?>!</h1>
        <p>Role: Siswa</p>
    </header>
    
    <div class="nav">
        <a href="lihat_keluhan_siswa.php">Lihat Keluhan Saya</a> | 
        <a href="logout.php">Logout</a>
    </div>
    
    <div class="container">
        <h2>Kirim Keluhan Baru</h2>
        <p>Kirim keluhan Anda (di sekolah atau luar sekolah). Guru akan merespons segera.</p>
        <form action="process_keluhan.php" method="POST">
            <label for="keluhan">Keluhan:</label>
            <textarea id="keluhan" name="keluhan_text" rows="6" placeholder="Ceritakan keluhan Anda secara detail..." required></textarea>
            <button type="submit">Kirim Keluhan</button>
        </form>
        
        <?php if (isset($_SESSION['success'])) { echo '<p style="color: green;">' . $_SESSION['success'] . '</p>'; unset($_SESSION['success']); } ?>
    </div>
</body>
</html>