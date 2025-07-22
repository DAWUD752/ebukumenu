<?php 
require_once 'header_template.php';

// Proses hapus data
if (isset($_GET['delete'])) {
    $idToDelete = (int)$_GET['delete'];

    // Hapus extra_menu terlebih dahulu untuk mencegah error foreign key (jika ada relasi)
    mysqli_query($conn, "DELETE FROM extra_menu WHERE idproduk = $idToDelete");

    // Ambil nama file foto dulu
    $getFoto = mysqli_query($conn, "SELECT foto FROM produk WHERE idproduk = $idToDelete");
    if ($getFoto && mysqli_num_rows($getFoto) > 0) {
    $foto = mysqli_fetch_assoc($getFoto)['foto'];
    if (file_exists("../uploads/products/$foto")) {
        unlink("../uploads/products/$foto"); // hapus file dari server
    }
}


    $query_delete = "DELETE FROM produk WHERE idproduk = $idToDelete";
    $run_query_delete = mysqli_query($conn, $query_delete);

    if ($run_query_delete) {
        echo "<script>alert('Produk berhasil dihapus'); window.location = 'produk.php';</script>";
    } else {
        echo "<script>alert('Data gagal dihapus: " . mysqli_error($conn) . "');</script>";
    }
}

// Ambil data produk
$query_select = 'SELECT * FROM produk';
$run_query_select = mysqli_query($conn, $query_select);
?>

<div class="content">
    <div class="container">

        <h3 class="page-tittle">Produk</h3>


        <div class="card">
            <a href="produk_add.php" class="btn" title="Tambah Data"><i class="fa fa-plus"></i></a>
         
            <table class="table">
                <thead>
                    <tr>
                        <th width="50">NO</th>
                        <th>FOTO</th>
                        <th>NAMA</th>
                        <th>HARGA</th>
                        <th>KATEGORI</th>
                        <th>DESKRIPSI</th>
                        <th width="100">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(mysqli_num_rows($run_query_select) > 0) { ?>
                    <?php $nomor = 1; ?>
                    <?php while($row = mysqli_fetch_array($run_query_select)) {?>
                    <tr>
                        <td align="center"><?= $nomor++ ?></td>
                        <td><img src="../uploads/products/<?= $row['foto'] ?>" width="80"></td>
                        <td align="center"><?= $row['namaproduk'] ?></td>
                        <td align="center"><?= $row['hargaproduk'] ?></td>
                        <td align="center"><?= $row['kategori'] ?></td>
                        <td align="center"><?= $row['deskripsi'] ?></td>
                        <td align="center">
                            <a href="produk_edit.php?id=<?= $row['idproduk'] ?>" class="btn" title="Edit Data"><i class="fa fa-edit"></i></a>
                            <a href="?delete=<?= $row['idproduk'] ?>" class="btn" onclick="return confirm('Yakin?')" title="Hapus Data"><i class="fa fa-times"></i></a>
                        </td>
                    </tr>

                    <?php }}else{ ?>
                        <tr>
                            <td colspan="7">tidak ada data</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>

        </div>
    </div>
</div>

<?php require_once 'footer_template.php'; ?>


      