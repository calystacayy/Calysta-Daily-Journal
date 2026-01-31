<table class="table table-hover">
    <thead class="table-dark">
        <tr>
            <th>No</th>
            <th class="w-25">Tanggal</th>
            <th class="w-25">Gambar</th>
            <th class="w-25">Deskripsi</th>
            <th class="w-25">Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php
        include "koneksi.php";

        $hlm = (isset($_POST['hlm'])) ? $_POST['hlm'] : 1;
        $limit = 3;
        $limit_start = ($hlm - 1) * $limit;
        $no = $limit_start + 1;

        $sql = "SELECT * FROM gallery ORDER BY tanggal DESC LIMIT $limit_start, $limit";
        $hasil = $conn->query($sql);

        while ($row = $hasil->fetch_assoc()) {
        ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= $row['tanggal'] ?></td>
                <td>
                    <?php
                    if ($row['gambar'] != '' && file_exists("img/" . $row['gambar'])) {
                        echo '<img src="img/' . $row['gambar'] . '" width="100" class="img-fluid rounded">';
                    }
                    ?>
                </td>
                <td><?= $row['deskripsi'] ?></td>
                <td>
                    <button type="button" class="btn btn-warning btn-sm btn-edit" 
                        data-id="<?= $row['id'] ?>" 
                        data-tanggal="<?= $row['tanggal'] ?>" 
                        data-deskripsi="<?= $row['deskripsi'] ?>" 
                        data-gambar="<?= $row['gambar'] ?>">
                        <i class="bi bi-pencil"></i>
                    </button>

                    <form method="post" action="" class="d-inline">
                        <input type="hidden" name="id" value="<?= $row['id'] ?>">
                        <input type="hidden" name="gambar" value="<?= $row['gambar'] ?>">
                        <button type="submit" name="hapus" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data ini?')">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
        <?php
        }
        ?>
    </tbody>
</table>

<?php 
$sql1 = "SELECT * FROM gallery";
$hasil1 = $conn->query($sql1); 
$total_records = $hasil1->num_rows;
?>
<p>Total Gallery : <?php echo $total_records; ?></p>