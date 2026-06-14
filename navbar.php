<?php
if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit;
}
?>
<div class="navbar">
    <h2>Smartwaste monitoring</h2>
    <div>
        <a href="dashboard.php">Dashboard</a>
        <a href="daftar_monitoring.php">Data Laporan</a>
        <a href="tambah_monitoring.php" class="btn btn-success">+ Tambah Laporan</a>
        <a href="logout.php" class="btn btn-danger">Logout</a>
    </div>
</div>
