<?php
    session_start();
    if(isset($_SESSION['uid'])){
        header('location:admin/index.php');
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login-Ebook Menu</title>
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

        /* login */

        .container {
            width: 100%;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .card-login {
            border: 1px solid #ccc;
            background-color: white;
            width: 300px;
            padding: 25px 15px;
            box-sizing: border-box;
            border-radius: 30px;
            box-shadow: 10px 10px 5px 0px rgba(0,0,0,0.75);
            -webkit-box-shadow: 10px 10px 5px 0px rgba(0,0,0,0.75);
            -moz-box-shadow: 10px 10px 5px 0px rgba(0,0,0,0.75);
        }

        .card-login h2 {
            margin-bottom: 10px;
            display: flex;
            justify-content: center;
        }

        .input-control {
            width: 100%;
            display: block;
            padding: 0.5rem 1rem;
            box-sizing: border-box;
            font-size: 1rem;
            margin-bottom: 8px;
        }

        .btn {
            display: block;
            width: 100%;
            padding: 0.5rem 1rem;
            cursor: pointer;
            font-size: 1rem;
        }
    </style>
    <!-- <link rel="stylesheet" href="login.css"> -->
</head>
<body>
    <!-- login -->
     <div class="container">
        <div class="card-login">

            <h2>Login</h2>
            <form action="" method="post">
                <input type="text" name="user" placeholder="username" class="input-control">
                <input type="password" name="pass" placeholder="password" class="input-control">
                <button type="submit" name="login" class="btn">Login</button>
            </form>

            <!-- Cek Tombol btn pake php -->
            <?php 
                // cek tombol
                if (isset($_POST['login'])) {

                    include'database.php' ;

                    // cek data login
                    $query_select = 'select * from users
                    where username = "'.mysqli_real_escape_string($conn, $_POST['user']).'"
                    and password = "'.mysqli_real_escape_string($conn, md5($_POST['pass'])).'"' ;

                    $run_query_select = mysqli_query($conn, $query_select) ;
                    $d = mysqli_fetch_object($run_query_select) ;

                    if($d) {
                        
                        $_SESSION['uid'] = $d->iduser;
                        $_SESSION['uname'] = $d->nama_lengkap;

                        mysqli_query($conn, "UPDATE users SET tgl_login = NOW() WHERE iduser = " . $d->iduser);

                        header('location:admin/index.php');

                        }else{
                            echo 'Username atau Password Salah';
                        }

                }
            ?>

        </div>
     </div>

</body>
</html>