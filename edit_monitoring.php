<?php include 'koneksi.php'; 
if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit;
}
include 'navbar.php';

$id = $_GET['id'];
$cek = mysqli_query($koneksi, "SELECT * FROM monitoring WHERE id='$id' AND user_id='$_SESSION[user_id]'");
if(mysqli_num_rows($cek) == 0){ echo "Data tidak ditemukan!"; exit; }
$d = mysqli_fetch_assoc($cek);

$pesan = "";
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $lokasi_tempat_sampah     = $_POST['lokasi_tempat_sampah'];
    $waktu_monitoring  = $_POST['waktu_monitoring'];
    $volume_sampah = $_POST['volume_sampah'];
    $deskripsi      = $_POST['deskripsi'];

    // Update Status Otomatis
   if($volume_sampah >= 0 && $volume_sampah <= 40){
    $status = "Kosong";
}
elseif($volume_sampah >= 41 && $volume_sampah <= 80){
    $status = "Penuh";
}
else{
    $status = "Overflow";
}
    // Cek jika ada foto baru
    if($_FILES['foto_bukti']['name'] != ""){
        $foto = $_FILES['foto_bukti']['name'];
        $tmp  = $_FILES['foto_bukti']['tmp_name'];
        $ext  = pathinfo($foto, PATHINFO_EXTENSION);
        if(in_array($ext, ['jpg','jpeg','png'])){
            // Hapus foto lama
            if(file_exists("uploads/".$d['foto_bukti'])){
    unlink("uploads/".$d['foto_bukti']);
}
            // Simpan foto baru
            $nama_foto = time().".".$ext;
            move_uploaded_file($tmp, "uploads/".$nama_foto);
            $upd_foto = ", foto_bukti='$nama_foto'";
        } else {
            $pesan = "<div class='alert alert-danger'>Format foto salah!</div>";
        }
    } else {
        $nama_foto = $d['foto_bukti'];
        $upd_foto = "";
    }

    if(empty($pesan)){
        $sql = "UPDATE monitoring SET 
                lokasi_tempat_sampah='$lokasi_tempat_sampah', waktu_monitoring='$waktu_monitoring', volume_sampah='$volume_sampah', 
                status_kondisi='$status', deskripsi='$deskripsi' $upd_foto 
                WHERE id='$id' AND user_id='$_SESSION[user_id]'";
        mysqli_query($koneksi, $sql);
        $pesan = "<div class='alert alert-success'>Data berhasil diubah! <a href='daftar_monitoring.php'>Kembali</a></div>";
        // Refresh data
        $d = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM monitoring WHERE id='$id'"));
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit monitoring</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<div class="container">
    <div class="card">
        <h2>Edit monitoring</h2>
        <?= $pesan ?>
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label>Lokasi tempat sampah</label>
                <input type="text" name="lokasi_tempat_sampah" value="<?= $d['lokasi_tempat_sampah'] ?>" required>
            </div>
            <div class="form-group">
                <label>Waktu Pelaporan monitoring</label>
                <input type="datetime-local" name="waktu_monitoring" value="<?= date('Y-m-d\TH:i', strtotime($d['waktu_monitoring'])) ?>" required>
            </div>
            <div class="form-group">
                <label>volume sampah</label>
                <input type="number" name="volume_sampah" value="<?= $d['volume_sampah'] ?>" min="1" required>
            </div>
            <div class="form-group">
                <label>Deskripsi Kondisi</label>
                <textarea name="deskripsi" rows="4" required><?= $d['deskripsi'] ?></textarea>
            </div>
            <div class="form-group">
                <label>Foto Bukti Saat Ini:</label><br>
                <img src="uploads/<?= $d['foto_bukti'] ?>" width="100" style="margin-bottom:0.5rem; border-radius:4px;"><br>
                <label>Ganti Foto (opsional):</label>
                <input type="file" name="foto_bukti" accept=".jpg,.jpeg,.png">
            </div>
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            <a href="daftar_monitoring.php" class="btn btn-danger">Batal</a>
        </form>
    </div>
</div>
<?php include 'footer.php'; ?>
</body>
</html>