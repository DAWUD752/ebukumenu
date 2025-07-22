<?php
    include 'database.php';

    $where = '';
    if(isset($_GET['kategori'])) {
        $where = ' WHERE kategori = "'.$_GET['kategori'].'"';
    }

    $query_select = 'SELECT * FROM produk' . $where;
    $run_query_select = mysqli_query($conn, $query_select);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home-Ebook Menu</title>
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
            /* Margin bottom awal untuk footer collapsed */
            margin-bottom: 60px;
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
            box-sizing: border-box;
        }

        /* sidebar */
        .sidebar {
            position: fixed;
            width: 250px;
            top: 0;
            bottom: 0;
            background-color: #333;
            padding-top: 35px;
            transition: all .5s;
            z-index: 98;
            color: white;
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
            color: #eee;
        }

        .sidebar-body ul {
            list-style: none;
        }

        .sidebar-body ul li a {
            width: 100%;
            display: inline-block;
            padding: 12px 15px;
            box-sizing: border-box;
            color: white;
            transition: background-color 0.3s ease;
        }

        .sidebar-body ul li a:hover {
            background-color: #555;
            color: white;
        }

        .sidebar-body ul li:not(:last-child) {
            border-bottom: 1px solid #555;
        }

        /* banner */
        .banner {
            border-bottom: 1px solid #cccccc;
            padding: 70px 15px 40px;
            background-image: url(assets/img/banner.jpg);
            background-size: cover;
            background-repeat: no-repeat;
            background-position: bottom;
            position: relative;
        }

        .banner::before {
            content: '';
            display: block;
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: linear-gradient(to right, rgba(227, 227, 227, 0.8), rgba(232, 231, 230, 0.5));
        }

        .banner-text {
            position: relative;
            color: rgb(9, 9, 9);
        }

        /* konten */
        .content {
            padding: 25px 0;
        }

        .container {
            width: 540px;
            padding-left: 15px;
            padding-right: 15px;
            box-sizing: border-box;
            margin-left: auto;
            margin-right: auto;
        }

        .row {
            margin-left: -15px;
            margin-right: -15px;
            display: flex;
            flex-wrap: wrap;
        }

        .col-6 {
            flex: 0 0 50%;
            box-sizing: border-box;
            margin-bottom: 15px;
            padding-left: 15px;
            padding-right: 15px;
        }

        .card-menu {
            border: 1px solid #ccc;
            background-color: #ffffff;
            border-radius: 5px;
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .card-menu img {
            width: 100%;
            height: 150px;
            object-fit: cover;
            border-top-right-radius: 5px;
            border-top-left-radius: 5px;
        }

        .card-body {
            padding: 8px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .menu-name {
            height: 45px;
            overflow: hidden;
            display: -webkit-box;
            text-overflow: ellipsis;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            margin-bottom: 8px;
        }

        .menu-price {
            font-weight: bold;
            text-align: right;
            margin-bottom: 10px;
        }

        .add-to-cart-btn {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #67595e;
            color: white;
            text-align: center;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .add-to-cart-btn:hover {
            background-color: #534b4f;
        }

        /* Order Footer - Slide Up/Down */
        .order-footer {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            background-color: #ffffff;
            border-top: 1px solid #ccc;
            box-shadow: 0 -2px 5px rgba(0,0,0,0.1);
            box-sizing: border-box;
            z-index: 99;
            transition: transform 0.3s ease-in-out; /* Animasi slide */
            /* Default: Sembunyikan sebagian besar, sisakan tinggi header */
            transform: translateY(calc(100% - 60px)); /* Tinggi header 60px */
        }

        .order-footer.expanded {
            transform: translateY(0); /* Tampilkan seluruh footer */
        }

        .order-footer-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px;
            cursor: pointer;
            background-color: #f5f5f5; /* Warna latar belakang header */
            border-bottom: 1px solid #eee;
            min-height: 60px; /* Tinggi minimum header */
            box-sizing: border-box;
        }

        .order-summary-info {
            display: flex;
            align-items: center;
        }

        /* Gaya untuk teks "Pesanan Anda" */
        .order-summary-text {
            font-weight: bold;
            color: #333;
            margin-left: 10px; /* Jarak antara ikon dan teks "Pesanan Anda" */
        }

        /* Gaya untuk ikon keranjang */
        .order-cart-icon {
            color: #67595e;
        }

        /* Ini adalah jumlah item yang menggantikan posisi harga di header footer */
        .order-items-count-summary {
            font-weight: bold;
            color: #333;
            font-size: 1.1em; /* Ukuran font agar menonjol */
        }

        /* Gaya untuk total harga di header, tapi sekarang disembunyikan */
        .order-total-price-header {
            display: none; /* Sembunyikan total harga di header collapsed */
        }

        .order-toggle-icon {
            font-size: 1.2em;
            color: #67595e;
            transition: transform 0.3s ease;
        }

        .order-footer.expanded .order-toggle-icon {
            transform: rotate(180deg); /* Panah berputar saat expanded */
        }

        .order-footer-content {
            padding: 15px; /* Padding saat konten terlihat */
            max-height: 0; /* Default hidden */
            overflow: hidden;
            transition: max-height 0.3s ease-in-out, padding 0.3s ease-in-out;
        }

        .order-footer.expanded .order-footer-content {
            max-height: 500px; /* Cukup tinggi untuk konten (sesuaikan jika perlu) */
            padding: 15px; /* Padding untuk konten */
        }

        .order-footer-section {
            margin-bottom: 10px;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
        }

        .order-footer-section:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }

        .order-summary-title {
            font-weight: bold;
            margin-bottom: 10px;
            color: #67595e;
        }

        .order-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 8px;
        }

        .order-item-details {
            display: flex;
            flex-direction: column;
        }

        .order-item-name {
            font-weight: bold;
        }

        .order-item-price {
            font-size: 0.9em;
            color: #777;
        }

        .order-item-controls {
            display: flex;
            align-items: center;
        }

        .order-item-qty-btn {
            background-color: #eee;
            border: 1px solid #ccc;
            padding: 4px 8px;
            cursor: pointer;
            border-radius: 3px;
            font-weight: bold;
        }

        .order-item-qty {
            margin: 0 8px;
            font-weight: bold;
        }

        .order-total-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 10px;
            font-size: 1.1em;
        }

        .order-total-text {
            font-weight: bold;
            color: #333;
        }

        .order-total-price-content { /* Untuk total di dalam konten footer */
            font-weight: bold;
            color: #d9534f;
        }

        .input-group {
            margin-top: 15px;
            display: flex;
            flex-direction: column;
        }

        .input-group label {
            font-size: 0.9em;
            margin-bottom: 5px;
            color: #555;
        }

        .input-group input {
            padding: 8px 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-family: 'Montserrat', sans-serif;
            font-size: 1em;
        }

        .whatsapp-btn {
            background-color: #25d366; /* WhatsApp green */
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            font-size: 1.1em;
            width: 100%;
            margin-top: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: background-color 0.3s ease;
        }

        .whatsapp-btn:hover {
            background-color: #1da851;
        }

        @media (max-width: 768px) {
            .container {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="navbar">
        <a href="#" id="btnBars">
            <i class="fa fa-bars"></i>
        </a>
     </div>

     <div class="sidebar sidebar-hide ">
        <div class="sidebar-body">
            <h2>Kategori</h2>
            <ul>
                <li><a href="index.php">Semua Kategori</a></li>
                <li><a href="?kategori=Makanan">Makanan</a></li>
                <li><a href="?kategori=Minuman">Minuman</a></li>
            </ul>
        </div>
      </div>

      <div class="banner">
        <div class="banner-text">
            <h1>Korean Grill Malang</h1>
            <p>Daftar Menu Makanan & Minuman</p>
        </div>
       </div>

       <div class="content">
            <div class="container">
                <div class="row">

                    <?php
                        if ($run_query_select->num_rows > 0) {
                            while($row = mysqli_fetch_array($run_query_select)) {
                    ?>
                    <div class="col-6">
                        <div class="card-menu">
                            <a href="detail.php?id=<?= $row['idproduk']?>">
                                <img src="uploads/products/<?= $row['foto']?> ">
                            </a>
                            <div class="card-body">
                                <div>
                                    <div class="menu-name"><?= $row['namaproduk'] ?></div>
                                    <div class="menu-price">Rp<?= number_format($row['hargaproduk'], 0, ',', '.')?></div>
                                </div>
                                <button class="add-to-cart-btn" data-id="<?= $row['idproduk'] ?>" data-name="<?= $row['namaproduk'] ?>" data-price="<?= $row['hargaproduk'] ?>">Tambah Pesanan</button>
                            </div>
                        </div>

                    </div>
                    <?php }} else{ ?>
                        <div>Menu Tidak Tersedia</div>
                    <?php }?>
                   </div>
            </div>
        </div>

    <div class="order-footer" id="orderFooter">
        <div class="order-footer-header" id="orderFooterHeader">
            <div class="order-summary-info">
                <i class="fas fa-shopping-cart order-cart-icon"></i> <span class="order-summary-text">Pesanan Anda</span>
            </div>
            <div class="order-summary-right">
                <span id="orderItemsCountSummary" class="order-items-count-summary">0 items</span> <span id="totalOrderPriceHeader" class="order-total-price-header">Rp0</span> <i class="fas fa-chevron-down order-toggle-icon"></i>
            </div>
        </div>

        <div class="order-footer-content">
            <div class="order-footer-section">
                <div class="order-summary-title">Detail Pesanan</div>
                <div id="cartItemsContainer">
                    <div style="text-align: center; color: #777;">Belum ada pesanan.</div>
                </div>
            </div>

            <div class="order-footer-section">
                <div class="order-total-row">
                    <span class="order-total-text">Total:</span>
                    <span class="order-total-price-content" id="totalOrderPriceContent">Rp0</span>
                </div>
            </div>

            <div class="input-group">
                <label for="tableNumber">Nomor Meja</label>
                <input type="text" id="tableNumber" placeholder="Contoh: Meja 5">
            </div>
            <div class="input-group">
                <label for="customerName">Nama Anda</label>
                <input type="text" id="customerName" placeholder="Contoh: Budi">
            </div>

            <button class="whatsapp-btn" id="sendOrderWhatsapp">
                <i class="fab fa-whatsapp"></i> Kirim via WhatsApp
            </button>
        </div>
    </div>

    <script type="text/javascript">
        var btnBars = document.getElementById('btnBars');
        var sidebar = document.querySelector(".sidebar");
        var addToCartButtons = document.querySelectorAll('.add-to-cart-btn');

        // Elemen-elemen untuk footer
        var orderFooter = document.getElementById('orderFooter');
        var orderFooterHeader = document.getElementById('orderFooterHeader');
        var orderFooterContent = document.querySelector('.order-footer-content');

        // Element untuk jumlah item di header ringkas
        var orderItemsCountSummaryElement = document.getElementById('orderItemsCountSummary');
        // Element untuk total harga di header (hidden by CSS)
        var totalOrderPriceHeaderElement = document.getElementById('totalOrderPriceHeader');

        // Element untuk total harga di dalam konten expanded
        var totalOrderPriceContentElement = document.getElementById('totalOrderPriceContent');

        var cartItemsContainer = document.getElementById('cartItemsContainer');

        // DUA ELEMENT INPUT BARU
        var tableNumberInput = document.getElementById('tableNumber');
        var customerNameInput = document.getElementById('customerName');

        var sendOrderWhatsappBtn = document.getElementById('sendOrderWhatsapp');

        var cart = {}; // Objek keranjang untuk menyimpan item dan jumlahnya

        // Tinggi default header footer (saat tersembunyi/collapsed)
        const FOOTER_HEADER_HEIGHT = 60; // Sesuaikan jika padding/font size berubah
        // Margin bottom body saat footer expanded
        // Mungkin perlu sedikit disesuaikan karena ada 2 input field
        const EXPANDED_FOOTER_MARGIN_BOTTOM = 300; // Disesuaikan, sebelumnya 250px

        btnBars.addEventListener('click', function(e) {
            e.preventDefault();
            sidebar.classList.toggle('sidebar-show');
        });

        // Fungsi untuk memperbarui tampilan keranjang dan total harga
        function updateCartDisplay() {
            cartItemsContainer.innerHTML = ''; // Kosongkan kontainer sebelum mengisi ulang
            let total = 0;
            let totalItems = 0;

            for (const productId in cart) {
                const item = cart[productId];
                if (item.qty > 0) {
                    totalItems += item.qty;
                    const itemElement = document.createElement('div');
                    itemElement.classList.add('order-item');
                    itemElement.innerHTML = `
                        <div class="order-item-details">
                            <div class="order-item-name">${item.name}</div>
                            <div class="order-item-price">Rp${new Intl.NumberFormat('id-ID').format(item.price)}</div>
                        </div>
                        <div class="order-item-controls">
                            <button class="order-item-qty-btn decrease-qty" data-id="${item.id}">-</button>
                            <span class="order-item-qty">${item.qty}</span>
                            <button class="order-item-qty-btn increase-qty" data-id="${item.id}">+</button>
                        </div>
                    `;
                    cartItemsContainer.appendChild(itemElement);
                    total += item.price * item.qty;
                }
            }

            // Pesan "Belum ada pesanan." jika keranjang kosong
            if (totalItems === 0) {
                cartItemsContainer.innerHTML = '<div style="text-align: center; color: #777;">Belum ada pesanan.</div>';
            }

            // Update elemen jumlah item di header ringkas
            orderItemsCountSummaryElement.textContent = `${totalItems} ${totalItems === 1 ? 'item' : 'items'}`;
            // Update total harga di header (walaupun disembunyikan)
            totalOrderPriceHeaderElement.textContent = `Rp${new Intl.NumberFormat('id-ID').format(total)}`;
            // Update total harga di dalam konten expanded
            totalOrderPriceContentElement.textContent = `Rp${new Intl.NumberFormat('id-ID').format(total)}`;

            // Sinkronkan margin body dengan status footer (expanded/collapsed)
            if (orderFooter.classList.contains('expanded')) {
                document.body.style.marginBottom = EXPANDED_FOOTER_MARGIN_BOTTOM + 'px';
            } else {
                document.body.style.marginBottom = FOOTER_HEADER_HEIGHT + 'px';
            }
        }

        // Event listener untuk tombol "Tambah Pesanan"
        addToCartButtons.forEach(button => {
            button.addEventListener('click', function() {
                const productId = this.dataset.id;
                const productName = this.dataset.name;
                const productPrice = parseFloat(this.dataset.price);

                if (cart[productId]) {
                    cart[productId].qty++;
                } else {
                    cart[productId] = {
                        id: productId,
                        name: productName,
                        price: productPrice,
                        qty: 1
                    };
                }
                updateCartDisplay();
            });
        });

        // Event delegation untuk tombol tambah/kurang jumlah di dalam keranjang
        cartItemsContainer.addEventListener('click', function(event) {
            if (event.target.classList.contains('increase-qty')) {
                const productId = event.target.dataset.id;
                if (cart[productId]) {
                    cart[productId].qty++;
                    updateCartDisplay();
                }
            } else if (event.target.classList.contains('decrease-qty')) {
                const productId = event.target.dataset.id;
                if (cart[productId] && cart[productId].qty > 0) {
                    cart[productId].qty--;
                    if (cart[productId].qty === 0) {
                        delete cart[productId]; // Hapus item jika kuantitasnya 0
                    }
                    updateCartDisplay();
                }
            }
        });

        // Event listener untuk header footer (untuk toggle expand/collapse)
        orderFooterHeader.addEventListener('click', function() {
            orderFooter.classList.toggle('expanded');
            if (orderFooter.classList.contains('expanded')) {
                document.body.style.marginBottom = EXPANDED_FOOTER_MARGIN_BOTTOM + 'px';
            } else {
                document.body.style.marginBottom = FOOTER_HEADER_HEIGHT + 'px';
            }
        });

        // Event listener untuk tombol "Kirim via WhatsApp"
        sendOrderWhatsappBtn.addEventListener('click', function() {
            const tableNumber = tableNumberInput.value.trim(); // Ambil nilai Nomor Meja
            const customerName = customerNameInput.value.trim(); // Ambil nilai Nama Anda

            // *** VALIDASI BARU UNTUK DUA INPUT ***
            if (!tableNumber && !customerName) {
                alert('Mohon isi Nomor Meja dan Nama Anda terlebih dahulu!');
                if (!orderFooter.classList.contains('expanded')) {
                    orderFooter.classList.add('expanded');
                    document.body.style.marginBottom = EXPANDED_FOOTER_MARGIN_BOTTOM + 'px';
                }
                return;
            } else if (!tableNumber) {
                alert('Mohon isi Nomor Meja terlebih dahulu!');
                if (!orderFooter.classList.contains('expanded')) {
                    orderFooter.classList.add('expanded');
                    document.body.style.marginBottom = EXPANDED_FOOTER_MARGIN_BOTTOM + 'px';
                }
                return;
            } else if (!customerName) {
                alert('Mohon isi Nama Anda terlebih dahulu!');
                if (!orderFooter.classList.contains('expanded')) {
                    orderFooter.classList.add('expanded');
                    document.body.style.marginBottom = EXPANDED_FOOTER_MARGIN_BOTTOM + 'px';
                }
                return;
            }

            let orderMessage = `Halo Korean Grill Malang!\n\n`;

            // Sertakan kedua informasi dalam pesan WhatsApp
            orderMessage += `Pesanan dari:\n`;
            orderMessage += `- *Nomor Meja: ${tableNumber}*\n`;
            orderMessage += `- *Nama: ${customerName}*\n\n`;


            let totalOrder = 0;
            let hasItems = false;

            for (const productId in cart) {
                const item = cart[productId];
                if (item.qty > 0) {
                    hasItems = true;
                    orderMessage += `- ${item.name} (x${item.qty}) - Rp${new Intl.NumberFormat('id-ID').format(item.price * item.qty)}\n`;
                    totalOrder += item.price * item.qty;
                }
            }

            if (!hasItems) {
                alert('Keranjang pesanan Anda kosong. Silakan tambahkan menu terlebih dahulu.');
                return;
            }

            orderMessage += `\n*Total: Rp${new Intl.NumberFormat('id-ID').format(totalOrder)}*\n\n`;
            orderMessage += `Terima kasih!`;

            // Nomor WhatsApp tujuan (ganti dengan nomor yang benar)
            const whatsappNumber = '6281998802674'; // Ganti dengan nomor WhatsApp tujuan Anda

            const whatsappUrl = `https://wa.me/${whatsappNumber}?text=${encodeURIComponent(orderMessage)}`;
            window.open(whatsappUrl, '_blank');
        });

        // Inisialisasi tampilan keranjang saat halaman dimuat
        updateCartDisplay();
    </script>
</body>
</html>