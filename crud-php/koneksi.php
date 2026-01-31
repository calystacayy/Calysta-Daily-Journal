<?php
date_default_timezone_set('Asia/Jakarta');

$servername = "";
$username = "";
$password = "";
$db = "";

// Cek apakah sedang berjalan di Localhost (Laptop) atau Hosting
if ($_SERVER['SERVER_NAME'] == 'localhost' || $_SERVER['SERVER_NAME'] == '127.0.0.1') {
    // === KONEKSI LOKAL (XAMPP) ===
    $servername = "localhost";
    $username = "root";
    $password = "";
    $db = "Calystawebdailyjournal"; 
} else {
    // === KONEKSI HOSTING (InfinityFree) ===
    
    // FIX: Hostname diganti jadi sql206 sesuai screenshot panelmu
    $servername = "sql206.infinityfree.com"; 
    
    // Username & Password
    $username = "if0_41037596";
    $password = "B5ZUaEny78"; 
    
    // Nama Database
    $db = "if0_41037596_calystadb";
}

$conn = new mysqli($servername, $username, $password, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>