<?php
session_start();

// Tangkap data dari form login
if (isset($_POST['submit'])) {
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);

    // Contoh data akun manual (bisa diubah sesuai kebutuhan)
    $akun = [
        'admin' => '12345',
        'siswa' => 'abcde'
    ];

    if (isset($akun[$username]) && $akun[$username] === $password) {
        $_SESSION['username'] = $username;
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Username atau password salah!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
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
      width: 300px;
      text-align: center;
    }

    h2 {
      color: white;
      margin-bottom: 20px;
    }

    input, button {
      width: 100%;
      padding: 12px;
      margin: 10px 0;
      border: none;
      border-radius: 20px;
      font-size: 14px;
    }

    input {
      background-color: #d9d9d9;
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

    .error {
      color: #ffb3b3;
      font-size: 14px;
      margin-bottom: 10px;
    }
  </style>
</head>
<body>
  <div class="circle circle-top"></div>
  <div class="circle circle-bottom"></div>

  <div class="container">
    <h2>Login</h2>
    <?php if (!empty($error)): ?>
      <div class="error"><?= $error ?></div>
    <?php endif; ?>
    <form method="POST" action="">
      <input type="text" name="username" placeholder="Email or Username" required>
      <input type="password" name="password" placeholder="Password" required>
      <button type="submit" name="submit">Login</button>
    </form>
  </div>
</body>
</html>
