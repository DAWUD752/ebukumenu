<?php 
    include 'database.php';

    // Validasi dan amankan ID
    $id = isset($_GET['id']) ? intval($_GET['id']) : 0;

    // Ambil detail produk
    $query_select = "SELECT * FROM produk WHERE idproduk = $id";
    $run_query_select = mysqli_query($conn, $query_select);
    $d = mysqli_fetch_object($run_query_select);

    if(!$d) {
        header('location:index.php') ;
    }

    // Ambil extra menu
    $query_extra = mysqli_query($conn, "SELECT * FROM extra_menu WHERE idproduk = $id");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail-Ebook Menu</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css" integrity="sha512-q3eWabyZPc1XTCmF+8/LuE1ozpg5xxn7iO89yfSOd5/oKvyqLngoNGsx8jq92Y8eXJ/IRxQbEC+FGSYxtk2oiw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <style>
        
        *{
            padding: 0;
            margin: 0;
        }

        body {
            font-family: 'Montserrat', sans-serif;
            background-color: #f9f1f0;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        /* detail content */

        .container {
            width: 540px;
            margin-left: auto;
            margin-right: auto;
        }

        .card-menu {
            background-color: white;
            position: relative;
            margin-bottom: 15px;
        }

        .card-menu .btn-Back {
            border: 1px solid #ccc;
            padding: 10px 15px;
            display: inline-block;
            border-radius: 50%;
            background-color: white;
            position: absolute;
            top: 10px;
            left: 10px;
        }

        .card-menu img {
            width: 100%;
        }

        .card-body {
            padding: 15px;
        }

        .card-body .menu-name {
            font-size: 20px;
        }

        .card-body .menu-description {
            font-size: 13px;
            color: gray;
            margin-bottom: 15px;
        }

        .card-body .menu-price {
            font-size: 20px;
            font-weight: bold;
        }

        .extra-menu {
            background-color: white;
            padding: 15px;
            margin-bottom: 25px;
        }

        .extra-menu h3 {
            margin-bottom: 8px;
        }

        .extra-menu ul {
            list-style: none;
        }

        .extra-menu ul li {
            padding: 5px 0;
            display: flex;
            justify-content: space-between;
        }

        .extra-menu ul li:not(:last-child) {
            border-bottom: 1px dashed;
        }

        @media (max-width: 768px) {
            .container {
                width: 100%;
            }
        }
    </style>
    <!-- <link rel="stylesheet" href="detail.css"> -->
</head>
<body>
    <!-- detail content -->
     <div class="container">
        <div class="card-menu">
            <a href="index.php" class="btn-Back"><i class="fa fa-arrow-left"></i></a>
            <img src="uploads/products/<?= $d->foto?>">

            <div class="card-body">
                <div class="menu-name"><?= $d->namaproduk?></div>
                <div class="menu-description"><?= $d->deskripsi?></div>
                <div class="menu-price">Rp<?= number_format($d->hargaproduk ,0, ',', '.')?></div>
            </div>
        </div>

        <?php if(mysqli_num_rows($query_extra) > 0) { ?>
        <div class="extra-menu">
            <h3>Menu Tambahan</h3>
            <ul>
                <?php while($extra = mysqli_fetch_assoc($query_extra)) { ?>
                    <li>
                        <span><?= htmlspecialchars($extra['nama']) ?></span>
                        <span>Rp<?= number_format($extra['harga'], 0, ',', '.') ?></span>
                    </li>
                <?php } ?>
            </ul>
        </div>
        <?php } ?>
     </div>
</body>
</html>