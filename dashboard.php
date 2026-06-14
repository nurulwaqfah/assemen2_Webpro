<?php include 'koneksi.php'; 
if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit;
}

include 'navbar.php';

$user_id = $_SESSION['user_id'];

// Hitung Data
$total = mysqli_fetch_array(mysqli_query($koneksi, "SELECT COUNT(*) FROM monitoring WHERE user_id='$user_id'"))[0];
$kosong = mysqli_fetch_array(mysqli_query($koneksi, "SELECT COUNT(*) FROM monitoring WHERE user_id='$user_id' AND status_kondisi='Kosong'"))[0];
$penuh = mysqli_fetch_array(mysqli_query($koneksi, "SELECT COUNT(*) FROM monitoring WHERE user_id='$user_id' AND status_kondisi='Penuh'"))[0];
$overflow  = mysqli_fetch_array(mysqli_query($koneksi, "SELECT COUNT(*) FROM monitoring WHERE user_id='$user_id' AND status_kondisi='Overflow'"))[0];

$terbaru = mysqli_query($koneksi, "SELECT * FROM monitoring WHERE user_id='$user_id' ORDER BY waktu_monitoring DESC LIMIT 5");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

<div class="container">
    <h1>Selamat Datang, <?= $_SESSION['nama'] ?> 👋</h1>

    <div class="stats-grid">
        <div class="stat-card">
            <h3><?= $total ?></h3>
            <p>Total Laporan</p>
        </div>
        <div class="stat-card" style="background:linear-gradient(135deg,#27ae60,#2ecc71)">
    <h3><?= $kosong ?></h3>
    <p>Sampah Kosong</p>
</div>
       <div class="stat-card" style="background:linear-gradient(135deg,#f39c12,#f1c40f)">
    <h3><?= $penuh ?></h3>
    <p>Sampah Penuh</p>
</div>
<div class="stat-card" style="background:linear-gradient(135deg,#e74c3c,#c0392b)">
    <h3><?= $overflow ?></h3>
    <p>Sampah Overflow</p>
</div>