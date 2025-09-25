<?php
// Jika tombol submit ditekan
if (isset($_POST['submit'])) {
    $nama     = htmlspecialchars($_POST['nama']);
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']); // tidak pakai hash karena tidak disimpan
    $role     = htmlspecialchars($_POST['role']);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #ffffff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
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
        input, select, button {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: none;
            border-radius: 20px;
            font-size: 14px;
        }
        input, select {
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
        .hasil {
            color: white;
            margin-top: 20px;
            text-align: left;
        }

        .circle {
  position: absolute;
  border-radius: 50%;
}

.circle-top {
  width: 250px;
  height: 250px;
  background-color: #739ac9; /* biru muda */
  top: -100px;
  left: -100px;
}

.circle-top::after {
  content: "";
  position: absolute;
  width: 100px;
  height: 100px;
  background-color: #16384c; /* biru tua */
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

    </style>
</head>
<body>
    <div class="circle circle-top"></div>
    <div class="circle circle-bottom"></div>


<div class="container">
    <h2>Registrasi</h2>
    <form method="POST" action="">
        <input type="text" name="nama" placeholder="Nama Lengkap" required>
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <select name="role" required>
            <option value="" disabled selected>Pilih Role</option>
            <option value="admin">Guru</option>
            <option value="user">Siswa</option>
        </select>
        <button type="submit" name="submit">Kirim</button>
    </form>

    <?php if (!empty($nama)): ?>
        <div class="hasil">
            <strong>Data Registrasi:</strong><br>
            Nama: <?= $nama ?> <br>
            Username: <?= $username ?> <br>
            Password: <?= $password ?> <br>
            Role: <?= $role ?> <br>
        </div>
    <?php endif; ?>
</div>

</body>
</html>