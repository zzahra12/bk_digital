<?php require_once 'config.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Konseling SMK</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .container { background: white; padding: 30px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); width: 350px; }
        input, select { width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #ddd; border-radius: 5px; box-sizing: border-box; }
        button { background-color: #4CAF50; color: white; padding: 10px; width: 100%; border: none; border-radius: 5px; cursor: pointer; }
        button:hover { background-color: #45a049; }
        .error { color: red; margin-top: 10px; }
        .success { color: green; margin-top: 10px; }
        .back-link { text-align: center; margin-top: 20px; }
        .back-link a { color: #4CAF50; text-decoration: none; }
        .note { font-size: 12px; color: #666; margin-top: 5px; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Register Akun Baru</h2>
        <p>Buat akun untuk siswa atau guru. Setelah daftar, silakan login.</p>
        
        <?php 
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $username = trim($_POST['username']);
            $email = trim($_POST['email']);
            $password = $_POST['password'];
            $nama = trim($_POST['nama']);
            $kelas = trim($_POST['kelas'] ?? '');  // Opsional untuk guru
            $role = $_POST['role'] ?? '';

            $errors = [];
            if (empty($username) || strlen($username) < 3) $errors[] = "Username minimal 3 karakter dan unik.";
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Email tidak valid.";
            if (strlen($password) < 6) $errors[] = "Password minimal 6 karakter.";
            if (empty($nama)) $errors[] = "Nama lengkap wajib.";
            if (empty($role) || !in_array($role, ['siswa', 'guru'])) $errors[] = "Pilih role yang valid (siswa atau guru).";

            // Cek username unik
            $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
            $stmt->execute([$username]);
            if ($stmt->fetch()) $errors[] = "Username sudah dipakai!";

            // Untuk guru, kelas opsional – tapi validasi kalau siswa
            if ($role == 'siswa' && empty($kelas)) $errors[] = "Kelas wajib untuk siswa.";

            if (empty($errors)) {
                // Hash password
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                
                // Insert user dengan role yang dipilih
                $stmt = $pdo->prepare("INSERT INTO users (username, password, role, nama, kelas) VALUES (?, ?, ?, ?, ?)");
                if ($stmt->execute([$username, $hashed_password, $role, $nama, $kelas])) {
                    echo "<p class='success'>✅ Akun berhasil dibuat sebagai <strong>$role</strong>! Silakan login.</p>";
                    echo "<script>setTimeout(() => { window.location.href = 'login.php'; }, 2000);</script>";
                } else {
                    echo "<p class='error'>Gagal buat akun. Coba lagi. (Error: " . implode(', ', $pdo->errorInfo()) . ")</p>";
                }
            } else {
                echo "<p class='error'>" . implode('<br>', $errors) . "</p>";
            }
        }
        ?>
        
        <form action="register.php" method="POST">
            <input type="text" name="username" placeholder="Username (misal: andi_smk atau bu_bk)" required>
            <input type="email" name="email" placeholder="Email (misal: andi@smk.com)" required>
            <input type="password" name="password" placeholder="Password (minimal 6 karakter)" required>
            <input type="text" name="nama" placeholder="Nama Lengkap" required>
            
            <select name="role" required>
                <option value="">Pilih Role</option>
                <option value="siswa">Siswa</option>
                <option value="guru">Guru</option>
            </select>
            <div class="note">* Kelas opsional untuk guru.</div>
            
            <input type="text" name="kelas" placeholder="Kelas (misal: XII TKJ 1) – opsional untuk guru">
            
            <button type="submit">Register</button>
        </form>
        
        <div class="back-link">
            <a href="login.php">← Sudah punya akun? Login</a>
        </div>
    </div>
</body>
</html>