<?php 
    require_once 'header_template.php';
?>

<div class="content">
    <div class="container">

        <h3 class="page-tittle">Tambah User</h3>

            

        <div class="card">
          
            <form action="" method="post">
                <div class="input-grup">
                    <label>Nama Lengkap</label>
                    <input type="text" name="nama" placeholder="Nama Lengkap" class="input-control" required>
                </div>

                 <div class="input-grup">
                    <label>No Telpon</label>
                    <input type="text" name="telpon" placeholder="No Telpon" class="input-control">
                </div>

                <div class="input-grup">
                    <label>Username</label>
                    <input type="text" name="user" placeholder="Username" class="input-control" required>
                </div>

                <div class="input-grup">
                    <label>Password</label>
                    <input type="password" name="pass" placeholder="Password" class="input-control" required>
                </div>

                <div class="input-grup">
                    <button type="button" onclick="window.location.href = 'users.php'" class="btn-back">Kembali</button>
                    <button type="submit" name="submit" class="btn-submit">Simpan</button>
                </div>

                <!-- <div class="input-grup">
                    <label>Nama Lengkap</label>
                    <input type="text" name="nama" placeholder="Nama Lengkap" class="input-control">
                </div>

                <div class="input-grup">
                    <label>Nama Lengkap</label>
                    <input type="text" name="nama" placeholder="Nama Lengkap" class="input-control">
                </div> -->
            </form>

            <?php 

                if(isset($_POST['submit'])) {
                    
                    // proses insert data
                    $query_insert = "INSERT INTO users (nama_lengkap, no_telpon, username, password) 
                    VALUES ('{$_POST['nama']}', '{$_POST['telpon']}', '{$_POST['user']}', '".md5($_POST['pass'])."')";


                    $run_query_insert = mysqli_query($conn, $query_insert);

                    if($run_query_insert) {
                        echo 'simpan data berhasil';
                    } else {
                        echo 'simpan data gagal: ' . mysqli_error($conn);
                    }

                }

            ?>

        </div>
    </div>
</div>

<?php require_once 'footer_template.php'; ?>


      