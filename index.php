<?php include 'koneksi.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Smartwaste_monitoring</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

<div class="navbar">
    <h2>Smartwaste monitoring</h2>
    <div>
        <a href="login.php">Login</a>
        <a href="register.php" class="btn btn-success">Daftar Akun</a>
    </div>
</div>

<div class="container">
    <div class="card" style="text-align:center; padding:4rem 2rem;">
        <h1>Sistem Waste Monitoring</h1>
        <p style="font-size:1.2rem; color:#666; max-width:700px; margin:1rem auto;">
            Solusi Untuk memantau Waste di Kota.
        </p>
        <a href="register.php" class="btn btn-primary mt-3">Mulai Lapor Sekarang</a>
    </div>
</div>

<?php include 'footer.php'; ?>
</body>
</html>