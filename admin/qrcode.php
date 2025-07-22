<?php 
    require_once 'header_template.php';

    $query_select = 'select * from qrcode' ;
    $run_query_select = mysqli_query($conn, $query_select) ;

    // cek jika ada parameter delete
    if(isset($_GET['delete'])) {
    $idToDelete = $_GET['delete'];

    // Ambil nama file QR code-nya sebelum dihapus dari database
    $getFoto = mysqli_query($conn, "SELECT qrname FROM qrcode WHERE idqrcode = '$idToDelete'");
    if ($getFoto && mysqli_num_rows($getFoto) > 0) {
        $foto = mysqli_fetch_assoc($getFoto)['qrname'];
        
        // Hapus data dari database
        $query_delete = "DELETE FROM qrcode WHERE idqrcode = '$idToDelete'";
        $run_query_delete = mysqli_query($conn, $query_delete);

        // Jika query delete sukses, hapus juga file di server
        if($run_query_delete) {
            if (file_exists("../uploads/qrcode/$foto")) {
                unlink("../uploads/qrcode/$foto");
            }
            echo "<script>window.location = 'qrcode.php'</script>";
        } else {
            echo "<script>alert('Data gagal dihapus')</script>";
        }
    } else {
        echo "<script>alert('QR Code tidak ditemukan')</script>";
    }
}

?>

<div class="content">
    <div class="container">

        <h3 class="page-tittle">Qr Code</h3>


        <div class="card">
            <a href="qrcode_add.php" class="btn" title="Tambah Data"><i class="fa fa-plus"></i></a>
         
            <table class="table">
                <thead>
                    <tr>
                        <th width="50">NO</th>
                        <th>URL</th>
                        <th width="100">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(mysqli_num_rows($run_query_select) > 0) { ?>
                    <?php $nomor = 1; ?>
                    <?php while($row = mysqli_fetch_array($run_query_select)) {?>
                    <tr>
                        <td align="center"><?= $nomor++ ?></td>
                        <td align="center"><?= $row['url'] ?></td>
                        <td align="center">
                            <a href="qrcode_detail.php?id=<?= $row['idqrcode'] ?>" class="btn" title="Detail Data"><i class="fa fa-eye"></i></a>
                            <a href="?delete=<?= $row['idqrcode'] ?>" class="btn" onclick="return confirm('Yakin?')" title="Hapus Data"><i class="fa fa-times"></i></a>
                        </td>
                    </tr>

                    <?php }}else{ ?>
                        <tr>
                            <td colspan="3">tidak ada data</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>

        </div>
    </div>
</div>

<?php require_once 'footer_template.php'; ?>


      