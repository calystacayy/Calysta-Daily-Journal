<?php
session_start();
include "koneksi.php";

// cek login
if (!isset($_SESSION['username'])) {
    header("location:login.php");
    exit;
}

// halaman aktif
$currentPage = $_GET['page'] ?? 'dashboard';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>My Daily Journal | Admin</title>

    <link rel="icon" href="img/logo.png" />
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" />
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
      crossorigin="anonymous"
    />

    <!-- ===== UI MASKULIN & CERAH ===== -->
   <style>
        html, body {
            height: 100%;
        }

        body {
            display: flex;
            flex-direction: column;
            background: linear-gradient(180deg, #ffffff 0%, #f1f4f8 100%);
        }

        #content {
            flex: 1;
        }

        /* ===== NAVBAR (LAVENDER) ===== */
        .navbar {
            /* Ganti warna emas jadi Lavender Gradasi */
            background: linear-gradient(90deg, #9370DB, #8A2BE2) !important; 
            border-bottom: none;
        }

        .navbar-brand {
            font-weight: 700;
            color: #ffffff !important;
            letter-spacing: .5px;
        }

        .nav-link {
            color: #E6E6FA !important; /* Lavender muda banget buat teks */
            font-weight: 500;
            transition: all .2s ease;
        }

        .nav-link:hover {
            color: #ffffff !important;
        }

        .nav-link.active {
            color: #ffffff !important;
            font-weight: 600;
            border-bottom: 3px solid #ffffff;
        }

        /* USER DROPDOWN */
        .dropdown-toggle {
            color: #ffffff !important;
            font-weight: 600;
        }

        .dropdown-menu {
            border-radius: 10px;
        }

        /* ===== FOOTER (LAVENDER) ===== */
        footer {
            /* Ganti warna emas jadi Lavender Gradasi */
            background: linear-gradient(90deg, #9370DB, #8A2BE2);
            border-top: none;
            color: #e5e7eb;
        }

        footer a i {
            color: #ffffff !important;
            transition: transform .25s ease;
        }

        footer a:hover i {
            color: #E6E6FA !important;
            transform: translateY(-4px);
        }

        footer .fw-semibold {
            color: #ffffffff;
        }
        
        footer a {
            text-decoration: none !important;
        }
        
        /* Ganti Judul Halaman Dashboard jadi Ungu */
        .lead {
            color: #9370DB; 
            border-color: #9370DB !important;
        }
    </style>
</head>

<body>

<!-- ================= NAVBAR ================= -->
<nav class="navbar navbar-expand-sm sticky-top">
    <div class="container">
        <a class="navbar-brand" target="_blank" href=".">My Daily Journal</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
           <ul class="navbar-nav ms-auto mb-2 mb-lg-0 text-dark">
    <li class="nav-item">
        <a class="nav-link" href="admin.php?page=dashboard">Dashboard</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="admin.php?page=article">Article</a>
    </li> 
    <li class="nav-item">
        <a class="nav-link" href="admin.php?page=gallery">Gallery</a>
    </li> 
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle text-danger fw-bold" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <?= $_SESSION['username']?>
        </a>
        <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="admin.php?page=profile">Profile</a></li>
            <li><a class="dropdown-item" href="logout.php">Logout</a></li>
        </ul>
    </li> 
</ul>
        </div>
    </div>
</nav>

<!-- ================= CONTENT ================= -->
<section id="content" class="p-5">
    <div class="container">
        <?php
        if(isset($_GET['page'])){
            ?>
            <h4 class="lead display-6 pb-2 border-bottom border-danger-subtle"><?= ucfirst($_GET['page'])?></h4>
            <?php
            include($_GET['page'].".php");
        }else{
            include("dashboard.php");
        }
        ?>
    </div>
</section>

<!-- ================= FOOTER ================= -->
<footer class="text-center p-5">
    <div>
        <a href="https://www.instagram.com/calysstaa_?igsh=MTh2YzlzcnVkYmp1Yg==">
            <i class="bi bi-instagram h2 p-2"></i>
        </a>
        <a href="https://www.tiktok.com/@beyyiii_?_r=1&_t=ZS-93WZBLd5oUX">
            <i class="bi bi-tiktok h2 p-2"></i>
        </a>
        <a href="https://wa.me/+6285951123571">
            <i class="bi bi-whatsapp h2 p-2"></i>
        </a>
    </div>
    <div class="fw-semibold text-dark">
        <p style="color: white;">
     Calysta Cayla Putri Anggraini © 2025
    </p>
    </div>
</footer>

<script
  src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
  crossorigin="anonymous">
</script>

</body>
</html>
