<?php include 'koneksi.php'; 
if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit;
}
include 'navbar.php';

$user_id = $_SESSION['user_id'];
$data = mysqli_query($koneksi, "SELECT * FROM monitoring WHERE user_id='$user_id' ORDER BY waktu_monitoring DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Laporan</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<div class="container">
    <div class="card">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1rem;">
            <h2>Daftar Monitoring</h2>
            <a href="tambah_monitoring.php" class="btn btn-success">+ Tambah Baru</a>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Lokasi</th>
                    <th>Waktu</th>
                    <th>Jumlah</th>
                    <th>Status</th>
                    <th>Foto</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no=1; while($row=mysqli_fetch_assoc($data)){ ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $row['lokasi_tempat_sampah'] ?></td>
                    <td><?= date('d/m/Y H:i', strtotime($row['waktu_monitoring'])) ?></td>
                    <td><?= $row['volume_sampah'] ?>%</td>
                 <td>
<?php
if($row['status_kondisi'] == 'Kosong'){
    $warna = '#27ae60';
}elseif($row['status_kondisi'] == 'Penuh'){
    $warna = '#f39c12';
}else{
    $warna = '#e74c3c';
}
?>
<span style="background:<?= $warna ?>;color:white;padding:8px 12px;border-radius:10px;">
    <?= $row['status_kondisi'] ?>
</span>
</td>
                    <td>
                        <a href="uploads/<?= $row['foto_bukti'] ?>" target="_blank">
                            <img src="uploads/<?= $row['foto_bukti'] ?>" width="50" height="50" style="object-fit:cover; border-radius:4px;">
                        </a>
                    </td>
                    <td>
                        <a href="edit_monitoring.php?id=<?= $row['id'] ?>" class="btn btn-primary" style="padding:0.3rem 0.6rem; font-size:0.8rem">Edit</a>
                        <a href="hapus_monitoring.php?id=<?= $row['id'] ?>" class="btn btn-danger" style="padding:0.3rem 0.6rem; font-size:0.8rem" onclick="return confirm('Yakin hapus data ini?')">Hapus</a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<?php include 'footer.php'; ?>
</body>
</html>