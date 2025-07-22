<?php 
// require_once 'header_template.php';

// $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// // Ambil data user berdasarkan ID
// $query_select = "SELECT * FROM users WHERE iduser = $id";
// $run_query_select = mysqli_query($conn, $query_select);

// if (!$run_query_select || mysqli_num_rows($run_query_select) == 0) {
//     echo "<p>User tidak ditemukan.</p>";
//     exit;
// }

// $d = mysqli_fetch_object($run_query_select);

include '../database.php';

// Validasi ID harus ada, harus angka, dan lebih dari 0
if (!isset($_GET['id']) || !is_numeric($_GET['id']) || (int)$_GET['id'] <= 0) {
    header('Location: users.php');
    exit;
}

$id = (int)$_GET['id'];

// Cek user
$query_select = "SELECT * FROM users WHERE iduser = $id";
$run_query_select = mysqli_query($conn, $query_select);
if (!$run_query_select || mysqli_num_rows($run_query_select) == 0) {
    header('Location: index.php');
    exit;
}

$d = mysqli_fetch_object($run_query_select);

// Baru di sini kita panggil header_template karena semua validasi lolos
require_once 'header_template.php';


// Proses update jika form disubmit
if (isset($_POST['submit'])) {
    $nama   = mysqli_real_escape_string($conn, $_POST['nama']);
    $telpon = mysqli_real_escape_string($conn, $_POST['telpon']);
    $user   = mysqli_real_escape_string($conn, $_POST['user']);
    $pass   = !empty($_POST['pass']) ? md5($_POST['pass']) : $d->password; // kalau password diisi, update. Kalau tidak, pakai password lama

    $query_update = "UPDATE users SET 
        nama_lengkap = '$nama',
        no_telpon = '$telpon',
        username = '$user',
        password = '$pass'
        WHERE iduser = $id";

    if (mysqli_query($conn, $query_update)) {
        echo "<script>
            alert('Data berhasil diperbarui!');
            window.location.href = 'users.php';
        </script>";
        exit;
    } else {
        echo "<p style='color:red;'>Gagal update data: " . mysqli_error($conn) . "</p>";
    }
}
?>

<div class="content">
    <div class="container">
        <h3 class="page-tittle">Edit User</h3>
        <div class="card">
            <form action="" method="post">
                <div class="input-grup">
                    <label>Nama Lengkap</label>
                    <input type="text" name="nama" placeholder="Nama Lengkap" class="input-control" value="<?= htmlspecialchars($d->nama_lengkap) ?>" required>
                </div>

                <div class="input-grup">
                    <label>No Telpon</label>
                    <input type="text" name="telpon" placeholder="No Telpon" class="input-control" value="<?= htmlspecialchars($d->no_telpon) ?>">
                </div>

                <div class="input-grup">
                    <label>Username</label>
                    <input type="text" name="user" placeholder="Username" class="input-control" value="<?= htmlspecialchars($d->username) ?>" required>
                </div>

                <div class="input-grup">
                    <label>Password <small>(Kosongkan jika tidak ingin mengubah)</small></label>
                    <input type="password" name="pass" placeholder="Password baru" class="input-control">
                </div>

                <div class="input-grup">
                    <button type="button" onclick="window.location.href = 'users.php'" class="btn-back">Kembali</button>
                    <button type="submit" name="submit" class="btn-submit">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once 'footer_template.php'; ?>
