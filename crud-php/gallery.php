<?php
// Cek apakah user sudah login
if (!isset($_SESSION['username'])) {
    header("location:login.php");
    exit;
}

// Cek apakah user_id ada (Fix untuk error "Column user_id cannot be null")
// Jika user login sebelum kode login.php diperbaiki, session ini belum ada.
if (!isset($_SESSION['user_id'])) {
    echo "<script>
            alert('Sesi kedaluwarsa, silakan login ulang agar ID tercatat.');
            document.location='login.php';
          </script>";
    exit;
}

// === LOGIKA SIMPAN / EDIT ===
if (isset($_POST['simpan'])) {
    $tanggal = $_POST['tanggal'];
    $deskripsi = $_POST['deskripsi'];
    $id = $_POST['id']; // Menangkap ID jika mode edit
    $gambar = $_FILES['gambar']['name'];
    
    // AMBIL ID DARI SESSION (YANG SUDAH KITA PERBAIKI DI LOGIN.PHP)
    $user_id = $_SESSION['user_id']; 

    // Cek apakah ada gambar baru yg diupload
    if ($gambar != "") {
        $target_dir = "img/";
        $target_file = $target_dir . basename($gambar);
        
        // Validasi upload file
        if(move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file)) {
            // Jika Mode EDIT & ada gambar baru
            if ($id != "") {
                // Hapus gambar lama dulu
                $sql_cek = "SELECT * FROM gallery WHERE id = '$id'";
                $res_cek = $conn->query($sql_cek);
                $row_cek = $res_cek->fetch_assoc();
                if($row_cek['gambar'] != '' && file_exists("img/".$row_cek['gambar'])){
                    unlink("img/".$row_cek['gambar']);
                }
                
                // Update dengan gambar baru
                $stmt = $conn->prepare("UPDATE gallery SET tanggal=?, deskripsi=?, gambar=? WHERE id=?");
                $stmt->bind_param("sssi", $tanggal, $deskripsi, $gambar, $id);
            } else {
                // Mode INSERT (Tambah Baru) - Masukkan user_id
                $stmt = $conn->prepare("INSERT INTO gallery (tanggal, deskripsi, gambar, user_id) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("sssi", $tanggal, $deskripsi, $gambar, $user_id);
            }
        } else {
            echo "<script>alert('Upload Gagal!');</script>";
            return; // Berhenti jika upload gagal
        }
    } else {
        // Jika tidak ada gambar baru (hanya edit teks)
        if ($id != "") {
            $stmt = $conn->prepare("UPDATE gallery SET tanggal=?, deskripsi=? WHERE id=?");
            $stmt->bind_param("ssi", $tanggal, $deskripsi, $id);
        } else {
            // Wajib ada gambar kalau tambah baru
            echo "<script>alert('Gambar wajib diisi!');</script>";
            return;
        }
    }

    if ($stmt->execute()) {
        echo "<script>alert('Simpan data sukses'); document.location='admin.php?page=gallery';</script>";
    } else {
        echo "<script>alert('Simpan data gagal'); document.location='admin.php?page=gallery';</script>";
    }
    $stmt->close();
}

// === LOGIKA HAPUS ===
if (isset($_POST['hapus'])) {
    $id = $_POST['id'];
    $gambar = $_POST['gambar'];

    if ($gambar != '' && file_exists("img/" . $gambar)) {
        unlink("img/" . $gambar);
    }

    $stmt = $conn->prepare("DELETE FROM gallery WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "<script>alert('Hapus data sukses'); document.location='admin.php?page=gallery';</script>";
    } else {
        echo "<script>alert('Hapus data gagal'); document.location='admin.php?page=gallery';</script>";
    }
    $stmt->close();
}
?>

<div class="container mt-3">
  <button type="button" class="btn text-white mb-2" style="background-color: #9370DB;" data-bs-toggle="modal" data-bs-target="#modalTambah">
    <i class="bi bi-plus-lg"></i> Tambah Gallery
</button>
    
    <div class="row">
        <div class="table-responsive" id="gallery_data">
            </div>
    </div>
</div>

<div class="modal fade" id="modalTambah" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Form Gallery</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" name="id" id="id">
                    
                    <div class="mb-3">
                        <label for="tanggal" class="form-label">Tanggal</label>
                        <input type="datetime-local" class="form-control" name="tanggal" id="tanggal" required>
                    </div>
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea class="form-control" name="deskripsi" id="deskripsi" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="gambar" class="form-label">Gambar</label>
                        <input type="file" class="form-control" name="gambar" id="gambar">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <input type="submit" value="simpan" name="simpan" class="btn btn-purple">
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function(){
    load_data();
    
    // Fungsi Load Data
    function load_data(page){
        $.ajax({
            url:"gallery_data.php",
            method:"POST",
            data:{page:page},
            success:function(data){
                $('#gallery_data').html(data);
            }
        })
    }

    // Klik Edit -> Isi Modal
    $(document).on('click', '.btn-edit', function(){
        var id = $(this).data('id');
        var tanggal = $(this).data('tanggal');
        var deskripsi = $(this).data('deskripsi');
        var gambar = $(this).data('gambar');

        // Isi form di modal
        $('#id').val(id);
        $('#tanggal').val(tanggal);
        $('#deskripsi').val(deskripsi);
        // Gambar tidak bisa di-set valuenya karena security browser

        $('#modalTambah').modal('show');
    });

    // Reset Form kalau Modal ditutup
    $('#modalTambah').on('hidden.bs.modal', function () {
        $('#id').val('');
        $('#tanggal').val('');
        $('#deskripsi').val('');
        $('#gambar').val('');
    });
});
</script>