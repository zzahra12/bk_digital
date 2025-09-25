<?php
// Proses form keluhan
if (isset($_POST['submit'])) {
    $judul   = htmlspecialchars($_POST['judul']);
    $isi     = htmlspecialchars($_POST['isi']);
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tulis Keluhan</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #ffffff;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
      position: relative;
    }

    .circle {
      position: absolute;
      border-radius: 50%;
    }

    .circle-top {
      width: 250px;
      height: 250px;
      background-color: #739ac9;
      top: -100px;
      left: -100px;
    }

    .circle-top::after {
      content: "";
      position: absolute;
      width: 100px;
      height: 100px;
      background-color: #16384c;
      border-radius: 50%;
      top: 80px;
      left: 150px;
    }

    .circle-bottom {
      width: 250px;
      height: 250px;
      background-color: #739ac9;
      bottom: -100px;
      right: -100px;
    }

    .circle-bottom::after {
      content: "";
      position: absolute;
      width: 100px;
      height: 100px;
      background-color: #16384c;
      border-radius: 50%;
      top: 80px;
      left: -50px;
    }

    .container {
      background-color: #16384c;
      padding: 30px;
      border-radius: 15px;
      width: 320px;
      text-align: center;
    }

    h2 {
      color: white;
      margin-bottom: 20px;
    }

    input, textarea, button {
      width: 100%;
      padding: 12px;
      margin: 10px 0;
      border: none;
      border-radius: 20px;
      font-size: 14px;
      font-family: Arial, sans-serif;
    }

    input, textarea {
      background-color: #d9d9d9;
    }

    textarea {
      resize: none;
      height: 80px;
    }

    button {
      background-color: #325d79;
      color: white;
      font-weight: bold;
      cursor: pointer;
    }

    button:hover {
      background-color: #24495e;
    }

    .hasil {
      background: #fff;
      margin-top: 20px;
      padding: 15px;
      border-radius: 10px;
      text-align: left;
      color: #16384c;
    }
  </style>
</head>
<body>
  <div class="circle circle-top"></div>
  <div class="circle circle-bottom"></div>

  <div class="container">
    <h2>Tulis Keluhan</h2>
    <form method="POST" action="">
      <input type="text" name="judul" placeholder="Keluhan" required>
      <textarea name="isi" placeholder="Ceritakan masalah anda..." required></textarea>
      <button type="submit" name="submit">Kirim</button>
    </form>

    <?php if (!empty($judul)): ?>
      <div class="hasil">
        <strong>Keluhan Terkirim:</strong><br><br>
        <strong>Judul:</strong> <?= $judul ?><br>
        <strong>Isi:</strong> <?= nl2br($isi) ?>
      </div>
    <?php endif; ?>
  </div>
</body>
</html>
