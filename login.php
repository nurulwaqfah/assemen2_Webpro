<?php include 'koneksi.php';

$pesan = "";
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $email = $_POST['email'];
    $pass  = md5($_POST['password']);

    $cek = mysqli_query($koneksi, "SELECT * FROM users WHERE email='$email' AND password='$pass'");
    if(mysqli_num_rows($cek) == 1){
        $data = mysqli_fetch_assoc($cek);
        $_SESSION['user_id'] = $data['id'];
        $_SESSION['nama']    = $data['nama'];
        header("Location: dashboard.php");
        exit;
    } else {
        $pesan = "<div class='alert alert-danger'>Email atau Password salah!</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

<div class="navbar">
    <h2>SmartWaste Monitoring</h2>
    <a href="index.php">← Kembali</a>
</div>

<div class="container">
    <div class="card" style="max-width: 500px; margin: 0 auto;">
        <h2>Login Operator</h2>
        <?= $pesan ?>
        <form method="POST" autocomplete="off">
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" autocomplete="off" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" autocomplete="new-password" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Masuk</button>
        </form>
    </div>
</div>

<?php include 'footer.php'; ?>
</body>
</html>