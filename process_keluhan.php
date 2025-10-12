<?php
require_once 'config.php';

if (!isLoggedIn() || getUserRole() != 'siswa') { header("Location: login.php"); exit(); }

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $keluhan_text = htmlspecialchars($_POST['keluhan_text']);
    $siswa_id = $_SESSION['user_id'];

    if (empty($keluhan_text)) {
        $_SESSION['error'] = "Keluhan tidak boleh kosong!";
        header("Location: dashboard_siswa.php");
        exit();
    }

    $stmt = $pdo->prepare("INSERT INTO keluhan (siswa_id, keluhan_text) VALUES (?, ?)");
    if ($stmt->execute([$siswa_id, $keluhan_text])) {
        $_SESSION['success'] = "Keluhan berhasil dikirim!";
    } else {
        $_SESSION['error'] = "Gagal kirim keluhan.";
    }
}

header("Location: dashboard_siswa.php");
exit();
?>