<?php
include 'koneksi.php';
if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit;
}

include 'navbar.php';
include 'functions.php';

$pesan = "";
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $user_id        = $_SESSION['user_id'];
    $lokasi_tempat_sampah = $_POST['lokasi_tempat_sampah'];
    $waktu_monitoring  = $_POST['waktu_monitoring'];
    $volume_sampah = $_POST['volume_sampah'];
    $deskripsi      = $_POST['deskripsi'];

    $status = hitungStatus($volume_sampah);

    // Upload Foto
    $foto = $_FILES['foto_bukti']['name'];
    $tmp  = $_FILES['foto_bukti']['tmp_name'];
    $ukuran = $_FILES['foto_bukti']['size'];
    $ext  = pathinfo($foto, PATHINFO_EXTENSION);
    $nama_foto = time().".".$ext; // Nama unik
    $lokasi_upload = "uploads/".$nama_foto;

    // Validasi
    if(
    empty($lokasi_tempat_sampah) ||
    empty($waktu_monitoring) ||
    empty($volume_sampah) ||
    empty($deskripsi)
){
        $pesan = "<div class='alert alert-danger'>Semua kolom wajib diisi!</div>";
    } elseif(!is_numeric($volume_sampah)){
        $pesan = "<div class='alert alert-danger'>Volume sampah harus berupa angka!</div>";
    } elseif(!in_array($ext, ['jpg','jpeg','png'])){
        $pesan = "<div class='alert alert-danger'>Format foto harus JPG/JPEG/PNG!</div>";
    } elseif($ukuran > 2097152){
    $pesan = "<div class='alert alert-danger'>Ukuran foto maksimal 2 MB!</div>";
    } else {
        move_uploaded_file($tmp, $lokasi_upload);
        $sql = "INSERT INTO monitoring (user_id, lokasi_tempat_sampah, waktu_monitoring, volume_sampah, status_kondisi, deskripsi, foto_bukti) 
                VALUES ('$user_id','$lokasi_tempat_sampah','$waktu_monitoring','$volume_sampah','$status','$deskripsi','$nama_foto')";
        mysqli_query($koneksi, $sql);
        $pesan = "<div class='alert alert-success'>Laporan berhasil ditambahkan! <a href='daftar_monitoring.php'>Lihat Data</a></div>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Laporan</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<div class="container">
    <div class="card">
        <h2>Tambah Monitor</h2>
        <?= $pesan ?>
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label>Lokasi Kejadian</label>
                <input type="text" name="lokasi_tempat_sampah" placeholder="Contoh: Pasar Kota, Taman Kota, Terminal, Sekolah" required>
            </div>
            <div class="form-group">
                <label>Waktu Monitoring</label>
                <input type="datetime-local" name="waktu_monitoring" required>
            </div>
            <div class="form-group">
                <label>volume_sampah</label>
                <input type="number" name="volume_sampah" min="1" required>
            </div>
            <div class="form-group">
                <label>Deskripsi Kondisi</label>
                <textarea name="deskripsi" rows="4" placeholder="Jelaskan kondisi di lapangan..." required></textarea>
            </div>
            <div class="form-group">
                <label>Foto Bukti (JPG/PNG)</label>
                <input type="file" name="foto_bukti" accept=".jpg,.jpeg,.png" required>
            </div>
            <button type="submit" class="btn btn-primary">Simpan Laporan</button>
            <a href="daftar_monitoring.php" class="btn btn-danger">Batal</a>
        </form>
    </div>
</div>
<?php include 'footer.php'; ?>
</body>
</html>