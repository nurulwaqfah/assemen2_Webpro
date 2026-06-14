<?php include 'koneksi.php';
if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit;
}

if(isset($_GET['id'])){
    $id = $_GET['id'];
    $user_id = $_SESSION['user_id'];

    // Ambil nama file foto dulu
    $ambil = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT foto_bukti FROM monitoring WHERE id='$id' AND user_id='$user_id'"));
    
    // Hapus file fisik
    if($ambil && file_exists("uploads/".$ambil['foto_bukti'])){
    unlink("uploads/".$ambil['foto_bukti']);
}

    // Hapus data dari database
    mysqli_query($koneksi, "DELETE FROM monitoring WHERE id='$id' AND user_id='$user_id'");
}

header("Location: daftar_monitoring.php");
exit;
?>