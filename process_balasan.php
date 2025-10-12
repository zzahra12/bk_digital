<?php
require_once 'config.php';

if (!isLoggedIn() || getUserRole() != 'guru') { header("Location: login.php"); exit(); }

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $keluhan_id = (int)$_POST['keluhan_id'];
    $balasan_text = htmlspecialchars($_POST['balasan_text']);
    $guru_id = $_SESSION['user_id'];

    if (empty($balasan_text) || $keluhan_id <= 0) {
        $_SESSION['error'] = "Data tidak lengkap!";
        header("Location: dashboard_guru.php");
        exit();
    }

    // Explicit set tanggal (hindari null)
    $tanggal = date('Y-m-d H:i:s');

    // Insert ke balasan (4 kolom: keluhan_id, guru_id, balasan_text, tanggal)
    $stmt = $pdo->prepare("INSERT INTO balasan (keluhan_id, guru_id, balasan_text, tanggal) VALUES (?, ?, ?, ?)");
    if ($stmt->execute([$keluhan_id, $guru_id, $balasan_text, $tanggal])) {
        // Update status keluhan ke 'dibalas'
        $pdo->prepare("UPDATE keluhan SET status = 'dibalas' WHERE id = ?")->execute([$keluhan_id]);
        $_SESSION['success'] = "Balasan berhasil dikirim!";
    } else {
        $_SESSION['error'] = "Gagal simpan balasan: " . print_r($stmt->errorInfo(), true);
    }
}

header("Location: dashboard_guru.php");
exit();
?>