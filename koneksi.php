<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$db   = 'smartwaste_monitoring';

$koneksi = mysqli_connect($host, $user, $pass, $db);

if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

session_start(); // Wajib untuk login/session
?>