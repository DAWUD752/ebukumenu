<?php 
    session_start() ;
    if(!isset($_SESSION['uid'])){
        header('location:../login.php');
    }

    include '../database.php' ;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel-Ebook Menu</title>
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

            /* navbar */
            a {
                color: inherit;
                text-decoration: none;
            }

            .navbar {
                padding: 0.5rem 1rem;
                background-color: #67595e;
                color: white;
                position: fixed;
                width: 100%;
                top: 0;
                left: 0;
                z-index: 99;
                display: flex;
            }

            .navbar h1 {
                /* border: 1px solid; */
                margin-left: 15px;
                font-size: 20px;
                line-height: 19px;
            }

            /* sidebar */
            .sidebar {
                position: fixed;
                width: 250px;
                top: 0;
                bottom: 0;
                background-color: rgb(255, 255, 255);
                padding-top: 35px;
                transition: all .5s;
                z-index: 98;
            }

            .sidebar-hide {
                left: -250px;
            }

            .sidebar-show {
                left: 0;
            }

            .sidebar-body {
                padding: 15px;
            }

            .sidebar-body h2 {
                margin-bottom: 8px;
            }

            .sidebar-body ul {
                list-style: none;
            }

            .sidebar-body ul li a {
                width: 100%;
                display: inline-block;
                padding: 7px 15px;
                box-sizing: border-box;
            }

            .sidebar-body ul li a:hover {
                background-color: #67595e;
                color: white;
            }

            .sidebar-body ul li:not(:last-child) {
                border-bottom: 1px solid #ccc;
            }

            /* content */
            .content {
                /* border: 1px solid; */
                padding: 60px 0;
            }

            .container {
                /* border: 1px solid; */
                width: 960px;
                margin-left: auto;
                margin-right: auto
            }

            /* admin beranda */

            .page-tittle {
                margin-bottom: 10px;
                margin-left: 5px;
            }

            .card {
                border: 1px solid #ccc;
                background-color: white;
                padding: 15px;
                border-radius: 10px;
            }

            .card h2 {
                margin-bottom: 3px;
            }

            .card p {
                color: gray;
            }

            .table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 8px;
            }

            .table thead th,
            .table tbody td {
                border: 1px solid;
                padding: 3px;
            }

            .btn {
                border: 1px solid;
                padding: 3px 8px;
                display: inline-block;
                background-color: #67595e;
                color: white;
                border-radius: 3px;
            }

            .input-grup {
                
                margin-bottom: 8px;
            
            }

            .input-grup label {
                display: block;
                margin-bottom: 5px;
            }

            .input-control {
                width: 100%;
                box-sizing: border-box;
                padding: 0.5rem;
                font-size: 1rem;
            }

            .btn-submit {
                border: 1px solid #67595e;
                padding: 8px 20px;
                display: inline-block;
                background-color: #67595e;
                color: white;
                border-radius: 3px;
                font-size: 1rem;
                cursor: pointer;
            }

            .btn-back {
                border: 1px solid ;
                padding: 8px 20px;
                display: inline-block;
                border-radius: 3px;
                font-size: 1rem;
                cursor: pointer;
            }
     </style>
</head>
<body>
    <!-- Navbar -->
     <div class="navbar">
        <a href="#" id="btnBars">
            <i class="fa fa-bars"></i>
        </a>
        <h1>Si Admin Korean Grill Malang</h1>
     </div>

     <!-- sidebar -->
      <div class="sidebar sidebar-hide ">
        <div class="sidebar-body">
            <h2>Navigasi</h2>
            <ul>
                <li><a href="index.php">Beranda</a></li>
                <li><a href="users.php">Users</a></li>
                <li><a href="produk.php">Produk</a></li>
                <li><a href="qrcode.php">Qr Code</a></li>
                <li><a href="logout.php">Log Out</a></li>
            </ul>
        </div>
      </div>