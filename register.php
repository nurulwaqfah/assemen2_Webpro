<?php include 'koneksi.php';

$pesan = "";
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $pass  = $_POST['password'];

    // Validasi
    if(empty($nama) || empty($email) || empty($pass)){
        $pesan = "<div class='alert alert-danger'>Semua field wajib diisi!</div>";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $pesan = "<div class='alert alert-danger'>Format email tidak valid!</div>";
    } elseif (strlen($pass) < 6){
        $pesan = "<div class='alert alert-danger'>Password minimal 6 karakter!</div>";
    } else {
        $pass_hash = md5($pass);
        $cek = mysqli_query($koneksi, "SELECT * FROM users WHERE email='$email'");
        if(mysqli_num_rows($cek) > 0){
            $pesan = "<div class='alert alert-danger'>Email sudah terdaftar!</div>";
        } else {
            mysqli_query($koneksi, "INSERT INTO users (nama,email,password) VALUES ('$nama','$email','$pass_hash')");
            $pesan = "<div class='alert alert-success'>Berhasil daftar! Silakan <a href='login.php'>Login</a></div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Akun</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

<div class="navbar">
    <h2>Smartwaste monitoring</h2>
    <a href="index.php">← Kembali</a>
</div>

<div class="container">
    <div class="card" style="max-width: 500px; margin: 0 auto;">
        <h2>Daftar Akun Operator</h2>
        <?= $pesan ?>
        <form method="POST">
            <div class="form-group">
                <label>Nama Lengkap</label>
                <input type="text" name="nama" required>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Daftar Sekarang</button>
        </form>
    </div>
</div>

<?php include 'footer.php'; ?>
</body>
</html>