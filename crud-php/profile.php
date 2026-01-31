<?php
// Cek apakah tombol simpan diklik
if (isset($_POST['simpan'])) {
    $password_baru = $_POST['password'];
    $foto = $_FILES['foto']['name'];
    $username = $_SESSION['username'];
    $foto_lama = $_POST['foto_lama'];

    // 1. Logika Ganti Password
    if ($password_baru != "") {
        $password_hash = md5($password_baru); // Standar enkripsi MD5 sesuai soal
        
        $stmt = $conn->prepare("UPDATE user SET password=? WHERE username=?");
        $stmt->bind_param("ss", $password_hash, $username);
        
        if ($stmt->execute()) {
            echo "<script>alert('Password berhasil diubah!');</script>";
        } else {
            echo "<script>alert('Gagal ubah password!');</script>";
        }
        $stmt->close();
    }

    // 2. Logika Ganti Foto Profil
    if ($foto != "") {
        $target_dir = "img/";
        $target_file = $target_dir . basename($foto);
        $tipe_file = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $upload_ok = 1;

        // Cek apakah file benar-benar gambar
        $check = getimagesize($_FILES["foto"]["tmp_name"]);
        if($check !== false) {
            $upload_ok = 1;
        } else {
            echo "<script>alert('File bukan gambar!');</script>";
            $upload_ok = 0;
        }

        // Upload jika aman
        if ($upload_ok == 1) {
            if (move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file)) {
                // Hapus foto lama jika ada (dan bukan default)
                if ($foto_lama != '' && file_exists("img/" . $foto_lama)) {
                    unlink("img/" . $foto_lama);
                }

                // Update database
                $stmt = $conn->prepare("UPDATE user SET foto=? WHERE username=?");
                $stmt->bind_param("ss", $foto, $username);
                
                if ($stmt->execute()) {
                    echo "<script>alert('Foto profil berhasil diperbarui!');</script>";
                } else {
                    echo "<script>alert('Gagal update database foto!');</script>";
                }
                $stmt->close();
            } else {
                echo "<script>alert('Maaf, terjadi kesalahan saat mengupload file.');</script>";
            }
        }
    }
    
    // Refresh halaman agar data terbaru langsung muncul
    echo "<meta http-equiv='refresh' content='0; url=admin.php?page=profile'>";
}

// Ambil data user yang sedang login
$sql = "SELECT * FROM user WHERE username = '".$_SESSION['username']."'";
$result = $conn->query($sql);
$data = $result->fetch_assoc();
?>

<div class="card shadow-sm">
    <div class="card-body">
        <form method="POST" action="" enctype="multipart/form-data">
            
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control bg-light" id="username" name="username" value="<?= $data['username'] ?>" readonly>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Ganti Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Tulis Password Baru Jika Ingin Mengganti Password Saja">
            </div>

            <div class="mb-3">
                <label for="foto" class="form-label">Ganti Foto Profil</label>
                <input type="file" class="form-control" id="foto" name="foto">
                <input type="hidden" name="foto_lama" value="<?= $data['foto'] ?>">
            </div>

            <div class="mb-3 text-center">
                <label class="form-label d-block">Foto Profil Saat Ini:</label>
                <?php
                if ($data['foto'] != '' && file_exists("img/" . $data['foto'])) {
                    echo '<img src="img/' . $data['foto'] . '" class="rounded-circle border border-2" width="150" height="150" style="object-fit:cover">';
                } else {
                    echo '<img src="https://ui-avatars.com/api/?name='.$data['username'].'&background=random" class="rounded-circle border border-2" width="150" height="150">';
                }
                ?>
            </div>

            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary" name="simpan">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>