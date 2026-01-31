<?php
// 1. Query Data Article & Gallery
$sql_article = "SELECT * FROM article";
$result_article = $conn->query($sql_article);
$jumlah_article = $result_article->num_rows;

$sql_gallery = "SELECT * FROM gallery";
$result_gallery = $conn->query($sql_gallery);
$jumlah_gallery = $result_gallery->num_rows;

// 2. Ambil Foto Profil User
$username_login = $_SESSION['username'];
$sql_user = "SELECT foto FROM user WHERE username = '$username_login'";
$result_user = $conn->query($sql_user);
$row_user = $result_user->fetch_assoc();
$foto_profil = $row_user['foto'];
?>

<div class="row text-center pt-3">
    <div class="col">
        <h4 class="mb-1 fw-normal">Selamat Datang,</h4>
        <h1 class="fw-bold mb-4" style="color: #9370DB;"><?= $_SESSION['username'] ?></h1>
    </div>
</div>

<div class="row text-center mb-5">
    <div class="col">
        <?php
        if ($foto_profil != '' && file_exists("img/" . $foto_profil)) {
            // Tampilkan foto asli jika ada
            echo '<img src="img/' . $foto_profil . '" class="rounded-circle shadow" style="width: 200px; height: 200px; object-fit: cover;">';
        } else {
            // Tampilkan placeholder (Saya ganti backgroundnya jadi Ungu juga biar serasi)
            echo '<img src="https://ui-avatars.com/api/?name='.$_SESSION['username'].'&background=9370DB&color=ffffff&size=200" class="rounded-circle shadow" style="width: 200px; height: 200px; object-fit: cover;">';
        }
        ?>
    </div>
</div>

<div class="row row-cols-1 row-cols-md-4 g-4 justify-content-center mb-5">
    <div class="col">
        <div class="card mb-3 shadow" style="max-width: 18rem; border-color: #9370DB;">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div class="p-3">
                        <h5 class="card-title"><i class="bi bi-newspaper"></i> Article</h5> 
                    </div>
                    <div class="p-3">
                        <span class="badge rounded-pill fs-2" style="background-color: #9370DB; color: white;"><?= $jumlah_article; ?></span>
                    </div> 
                </div>
            </div>
        </div>
    </div> 
    
    <div class="col">
        <div class="card mb-3 shadow" style="max-width: 18rem; border-color: #9370DB;">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div class="p-3">
                        <h5 class="card-title"><i class="bi bi-camera"></i> Gallery</h5> 
                    </div>
                    <div class="p-3">
                        <span class="badge rounded-pill fs-2" style="background-color: #9370DB; color: white;"><?= $jumlah_gallery; ?></span>
                    </div> 
                </div>
            </div>
        </div>
    </div> 
</div>