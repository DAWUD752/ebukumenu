<?php 
    require_once 'header_template.php';
?>

<div class="content">
    <div class="container">

        <h3 class="page-tittle">Tambah Produk</h3>

            

        <div class="card">
          
            <form action="" method="post" enctype="multipart/form-data">
                <div class="input-grup">
                    <label>Nama Produk</label>
                    <input type="text" name="nama" placeholder="Nama Produk" class="input-control" required>
                </div>

                 <div class="input-grup">
                    <label>Harga</label>
                    <input type="text" name="harga" placeholder="Harga" class="input-control">
                </div>

                <div class="input-grup">
                    <label>Deskripsi</label>
                    <textarea class="input-control" name="deskripsi" placeholder="Deskripsi"></textarea>
                </div>

                <div class="input-grup">
                    <label>Kategori</label>
                    <select class="input-control" name="kategori">
                        <option value="">pilih</option>
                        <option value="Makanan">Makanan</option>
                        <option value="Minuman">Minuman</option>
                    </select>
                </div>

                <div class="input-grup">
                    <label>Foto</label>
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
                    <tbody id="extraMenuList"></tbody>
                </table>

                <div style="text-align: right; margin-top: 10px;">
                    <button type="button" class="btn-submit" id="btnAdd">Tambah Extra Menu</button>
                </div>

                <div class="input-grup">
                    <button type="button" onclick="window.location.href = 'produk.php'" class="btn-back">Kembali</button>
                    <button type="submit" name="submit" class="btn-submit">Simpan</button>
                </div>

            </form>

            <?php 

                if(isset($_POST['submit'])) {
                    
                    // proses tambah produk


                    // tampung data file yang akan di upload
                    $name = $_FILES['foto']['name'];
                    $tmp_name = $_FILES['foto']['tmp_name'];

                    // proses upload file
                    
                    move_uploaded_file($tmp_name, '../uploads/products/' . $name);

                    // proses insert

                    $query_insert = 'insert into produk (namaproduk, hargaproduk, deskripsi, foto, kategori) value (
                        "'.$_POST['nama'].'", 
                        "'.$_POST['harga'].'", 
                        "'.$_POST['deskripsi'].'", 
                        "'.$name.'", 
                        "'.$_POST['kategori'].'"
                    )';

                    $run_query_insert = mysqli_query($conn, $query_insert);
                    $idproduk = mysqli_insert_id($conn);

                    if(!$run_query_insert){
                        echo 'Data Berhasil Di simpan' .mysqli_error($conn);
                        exit();
                    }

                    
                    // proses tambah extra menu
                    $sql = [];

                    if (isset($_POST['extraname']) && isset($_POST['extraharga'])) {
                        for ($i = 0; $i < count($_POST['extraname']); $i++) {
                            $nama = trim($_POST['extraname'][$i]);
                            $harga = trim($_POST['extraharga'][$i]);

                            // hanya tambahkan jika nama dan harga tidak kosong
                            if ($nama !== '' && $harga !== '') {
                                $sql[] = '("' . $idproduk . '", "' . $nama . '", "' . $harga . '")';
                            }
                        }
                    }

                    // jalankan query hanya jika ada extra menu valid
                    if (!empty($sql)) {
                        $query_insert_extra_menu = 'INSERT INTO extra_menu (idproduk, nama, harga) VALUES ' . implode(',', $sql);
                        $run_query_insert_extra_menu = mysqli_query($conn, $query_insert_extra_menu);

                        if (!$run_query_insert_extra_menu) {
                            echo 'Data extra menu gagal disimpan: ' . mysqli_error($conn);
                            exit();
                        }
                    }

                    echo 'Produk berhasil disimpan';

            }

            ?>

        </div>
    </div>
</div>



<script>
    var btnAdd = document.getElementById("btnAdd");
    var extraMenuList = document.getElementById("extraMenuList");

    btnAdd.addEventListener("click", function(e) {
        e.preventDefault();

        // Buat elemen baris baru
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

    // Delegasi event listener ke table, supaya tombol hapus berfungsi
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


      