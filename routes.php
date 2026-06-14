<?php

$page = $_GET['page'] ?? 'dashboard';

switch($page){

    case 'dashboard':
        include 'dashboard.php';
        break;

    case 'daftar_monitoring':
        include 'daftar_monitoring.php';
        break;

    case 'tambah':
        include 'tambah_monitoring.php';
        break;

    default:
        include 'dashboard.php';
}
?>