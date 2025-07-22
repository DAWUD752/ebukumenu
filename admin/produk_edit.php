<?php 

include '../database.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Ambil data produk
$query_select = "SELECT * FROM produk WHERE idproduk = $id";
$run_query_select = mysqli_query($conn, $query_select);

if (!$run_query_select || mysqli_num_rows($run_query_select) == 0) {
    header('location:produk.php');
    exit;
}

$d = mysqli_fetch_object($run_query_select);

// Ambil extra menu
$query_extra = mysqli_query($conn, "SELECT * FROM extra_menu WHERE idproduk = $id");
$extraMenus = [];
while ($em = mysqli_fetch_assoc($query_extra)) {
    $extraMenus[] = $em;
}

// Proses update
if (isset($_POST['submit'])) {
    $nama   = mysqli_real_escape_string($conn, $_POST['nama']);
    $harga  = mysqli_real_escape_string($conn, $_POST['harga']);
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);
    $kategori = mysqli_real_escape_string($conn, $_POST['kategori']);

    // Upload foto baru jika ada
    $fotoBaru = $_FILES['foto']['name'];
    $tmp_name = $_FILES['foto']['tmp_name'];

    if (!empty($fotoBaru)) {
        move_uploaded_file($tmp_name, '../uploads/products/' . $fotoBaru);
    } else {
        $fotoBaru = $d->foto;
    }

    $query_update = "UPDATE produk SET 
        namaproduk = '$nama',
        hargaproduk = '$harga',
        deskripsi = '$deskripsi',
        kategori = '$kategori',
        foto = '$fotoBaru'
        WHERE idproduk = $id";

    if (mysqli_query($conn, $query_update)) {
        // Update extra menu: hapus lama lalu tambah baru
        mysqli_query($conn, "DELETE FROM extra_menu WHERE idproduk = $id");

        $sql = [];
        if (isset($_POST['extraname'])) {
            for ($i = 0; $i < count($_POST['extraname']); $i++) {
                $namaExtra = mysqli_real_escape_string($conn, $_POST['extraname'][$i]);
                $hargaExtra = mysqli_real_escape_string($conn, $_POST['extraharga'][$i]);
                $sql[] = "($id, '$namaExtra', '$hargaExtra')";
            }
            $query_insert_extra = "INSERT INTO extra_menu (idproduk, nama, harga) VALUES " . implode(",", $sql);
            mysqli_query($conn, $query_insert_extra);
        }

        echo "<script>alert('Produk berhasil diperbarui'); window.location.href='produk.php';</script>";
        exit;
    } else {
        $error_message = "Gagal update data: " . mysqli_error($conn);
    }
}

// Sekarang aman untuk memanggil file HTML template
require_once 'header_template.php';
?>

<?php if (isset($error_message)): ?>
<p style="color:red;"><?= $error_message ?></p>
<?php endif; ?>

<div class="content">
    <div class="container">
        <h3 class="page-tittle">Edit Produk</h3>
        <div class="card">
            <form action="" method="post" enctype="multipart/form-data">
                <div class="input-grup">
                    <label>Nama Produk</label>
                    <input type="text" name="nama" class="input-control" value="<?= htmlspecialchars($d->namaproduk) ?>" required>
                </div>

                <div class="input-grup">
                    <label>Harga</label>
                    <input type="text" name="harga" class="input-control" value="<?= htmlspecialchars($d->hargaproduk) ?>">
                </div>

                <div class="input-grup">
                    <label>Deskripsi</label>
                    <textarea name="deskripsi" class="input-control"><?= htmlspecialchars($d->deskripsi) ?></textarea>
                </div>

                <div class="input-grup">
                    <label>Kategori</label>
                    <select class="input-control" name="kategori">
                        <option value="">pilih</option>
                        <option value="Makanan" <?= $d->kategori == 'Makanan' ? 'selected' : '' ?>>Makanan</option>
                        <option value="Minuman" <?= $d->kategori == 'Minuman' ? 'selected' : '' ?>>Minuman</option>
                    </select>
                </div>

                <div class="input-grup">
                    <label>Foto</label><br>
                    <img src="../uploads/products/<?= $d->foto ?>" width="100" alt="Foto produk"><br><br>
                    <input type="file" name="foto">
                </div>

                <h3>Extra Menu</h3>
                <table class="table">
                    <thead>
                        <tr>
                            <th>NAMA</th>
                            <th>HARGA</th>
                            <th width="100">HAPUS</th>
                        </tr>
                    </thead>
                    <tbody id="extraMenuList">
                        <?php foreach ($extraMenus as $extra): ?>
                        <tr>
                            <td><input type="text" name="extraname[]" class="input-control" value="<?= htmlspecialchars($extra['nama']) ?>" required></td>
                            <td><input type="text" name="extraharga[]" class="input-control" value="<?= htmlspecialchars($extra['harga']) ?>" required></td>
                            <td align="center"><button type="button" class="btn btn-remove"><i class="fa fa-times"></i></button></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <div style="text-align: right; margin-top: 10px;">
                    <button type="button" class="btn-submit" id="btnAdd">Tambah Extra Menu</button>
                </div>

                <div class="input-grup">
                    <button type="button" onclick="window.location.href = 'produk.php'" class="btn-back">Kembali</button>
                    <button type="submit" name="submit" class="btn-submit">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    var btnAdd = document.getElementById("btnAdd");
    var extraMenuList = document.getElementById("extraMenuList");

    btnAdd.addEventListener("click", function(e) {
        e.preventDefault();
        var listItem = document.createElement('tr');
        listItem.innerHTML = `
            <td><input type="text" name="extraname[]" class="input-control" required></td>
            <td><input type="text" name="extraharga[]" class="input-control" required></td>
            <td align="center">
                <button type="button" class="btn btn-remove"><i class="fa fa-times"></i></button>
            </td>
        `;
        extraMenuList.appendChild(listItem);
    });

    extraMenuList.addEventListener("click", function(e) {
        if (e.target.closest(".btn-remove")) {
            e.preventDefault();
            var row = e.target.closest("tr");
            if (row) {
                row.remove();
            }
        }
    });
</script>

<?php require_once 'footer_template.php'; ?>
