<?php 
    // require_once 'header_template.php';

    // $query_select = 'select * from qrcode where idqrcode = "'.$_GET['id'].'"' ;
    // $run_query_select = mysqli_query($conn, $query_select) ;
    // $d = mysqli_fetch_object($run_query_select) ;

    include '../database.php';

    $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

    // Ambil data QR code
    $query_select = "SELECT * FROM qrcode WHERE idqrcode = $id";
    $run_query_select = mysqli_query($conn, $query_select);

    // Jika tidak ditemukan, redirect ke halaman QR Code utama
    if (!$run_query_select || mysqli_num_rows($run_query_select) == 0) {
        header('location:qrcode.php');
        exit;
    }

    $d = mysqli_fetch_object($run_query_select);

    // Aman untuk load header
    require_once 'header_template.php';
    
?>

<div class="content">
    <div class="container">

        <h3 class="page-tittle">Detail Qr Code</h3>


        <div class="card">

            <img src="../uploads/qrcode/<?= $d->qrname ?>">

            <hr style="margin-bottom: 10px;">

            <button type="button" onclick="window.location = 'qrcode.php'" class="btn-back">Kembali</button>
           

        </div>
    </div>
</div>

<?php require_once 'footer_template.php'; ?>


      