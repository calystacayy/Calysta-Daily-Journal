<?php
include "koneksi.php"; 
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>CalystaCalysta Daily Journal</title>
    <link rel="icon" href="img/logo.png" />
    
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css"
    />
    
    <style>
        /* CSS Lavender Custom */
        .bg-lavender {
            background: linear-gradient(90deg, #9370DB, #8A2BE2) !important;
        }
        .bg-lavender-fade {
            background-color: #E6E6FA !important;
        }
        
        /* Navbar Text & Brand jadi Putih */
        .navbar-brand, .nav-link {
            color: white !important; 
        }
        
        /* Teks Judul Lavender */
        .text-lavender {
            color: #9370DB !important;
        }
    </style>
    
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
      crossorigin="anonymous"
    />
  </head>
  <body>
    <nav class="navbar navbar-expand-sm sticky-top bg-lavender">
      <div class="container">
        <a class="navbar-brand" href="#">Calysta Daily Journal</a>
        <button
          class="navbar-toggler"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#navbarSupportedContent"
          aria-controls="navbarSupportedContent"
          aria-expanded="false"
          aria-label="Toggle navigation"
        >
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link" href="#">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#article">Article</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#gallery">Gallery</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#schedule">Schedule</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#aboutme">About Me</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="login.php" target="_blank">Login</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <section id="hero" class="text-center p-5 bg-lavender-fade text-sm-start">
      <div class="container">
        <div class="d-sm-flex flex-sm-row-reverse align-items-center">
          <img src="https://img.freepik.com/free-vector/happy-freelancer-with-computer-home-young-man-sitting-armchair-using-laptop-chatting-online-smiling-vector-illustration-distance-work-online-learning-freelance_74855-8401.jpg?t=st=1736413753~exp=1736417353~hmac=55395a14d567c94b7931b6814088a8511634b8686e9690196230f0653658514e&w=996" class="img-fluid" width="300" />
          <div>
            <h1 class="fw-bold display-4">Create Memories, Save It, Replay It</h1>
            <h4 class="lead display-6">Mencatat semua kegiatan sehari-hari yang ada tanpa terkecuali</h4>
            <span id="tanggal"></span>
            <span id="jam"></span>
          </div>
        </div>
      </div>
    </section>

    <section id="article" class="text-center p-5">
      <div class="container">
        <h1 class="fw-bold display-4 pb-3">Article</h1>
        <div class="row row-cols-1 row-cols-md-3 g-4 justify-content-center">
          <?php
          $sql = "SELECT * FROM article ORDER BY tanggal DESC";
          $hasil = $conn->query($sql); 

          while($row = $hasil->fetch_assoc()){
          ?>
            <div class="col">
              <div class="card h-100">
                <img src="img/<?= $row["gambar"]?>" class="card-img-top" alt="..." />
                <div class="card-body">
                  <h5 class="card-title"><?= $row["judul"]?></h5>
                  <p class="card-text">
                    <?= $row["isi"]?>
                  </p>
                </div>
                <div class="card-footer">
                  <small class="text-body-secondary">
                    <?= $row["tanggal"]?>
                  </small>
                </div>
              </div>
            </div>
          <?php
          }
          ?> 
        </div>
      </div>
    </section>

    <section id="gallery" class="text-center p-5 bg-lavender-fade">
        <div class="container">
            <h1 class="fw-bold display-4 pb-3">Gallery</h1>
            <div id="carouselExample" class="carousel slide">
                <div class="carousel-inner">
                    <?php
                    $sql = "SELECT * FROM gallery ORDER BY tanggal DESC";
                    $hasil = $conn->query($sql);

                    $active = "active";
                    
                    if ($hasil->num_rows > 0) {
                        while ($row = $hasil->fetch_assoc()) {
                    ?>
                        <div class="carousel-item <?= $active ?>">
                            <img src="img/<?= $row['gambar'] ?>" class="d-block w-100" alt="Gallery Image" style="height: 500px; object-fit: cover;">
                        </div>
                    <?php
                            $active = ""; 
                        }
                    } else {
                         echo '<div class="carousel-item active">
                                <img src="https://via.placeholder.com/800x400?text=Belum+Ada+Gallery" class="d-block w-100" alt="No Image">
                              </div>';
                    }
                    ?>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
    </section>

    <footer class="text-center p-5 bg-lavender">
      <div>
        <a href="https://www.instagram.com/calysstaa_?igsh=MTh2YzlzcnVkYmp1Yg=="
          ><i class="bi bi-instagram h2 p-2 text-white"></i
        ></a>
        <a href="https://www.tiktok.com/@beyyiii_?_r=1&_t=ZS-93WZBLd5oUX"
          ><i class="bi bi-tiktok h2 p-2 text-white"></i
        ></a>
        <a href="https://wa.me/+6285951123571"
          ><i class="bi bi-whatsapp h2 p-2 text-white"></i
        ></a>
      </div>
      <div class="text-white"> Calysta Cayla Putri Anggraini &copy; 2025</div>
    </footer>

    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
      crossorigin="anonymous"
    ></script>
    <script type="text/javascript">
      window.setTimeout("tampilWaktu()", 1000);

      function tampilWaktu() {
        var waktu = new Date();
        var bulan = waktu.getMonth() + 1;

        setTimeout("tampilWaktu()", 1000);
        document.getElementById("tanggal").innerHTML =
          waktu.getDate() + "/" + bulan + "/" + waktu.getFullYear();
        document.getElementById("jam").innerHTML =
          waktu.getHours() +
          ":" +
          waktu.getMinutes() +
          ":" +
          waktu.getSeconds();
      }
    </script>
  </body>
</html>