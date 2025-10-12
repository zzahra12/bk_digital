<?php
require_once 'config.php';

if (isLoggedIn()) {
    $role = getUserRole();
    if ($role == 'siswa') {
        header("Location: dashboard_siswa.php");
    } else {
        header("Location: dashboard_guru.php");
    }
    exit();
} else {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konseling SMK</title>
    <style> body { font-family: Arial, sans-serif; text-align: center; padding: 50px; } </style>
</head>
<body>
    <h1>Selamat Datang di Layanan Konseling SMK</h1>
    <p><a href="register.php">Atau buat akun baru di sini</a></p>
</body>
</html>