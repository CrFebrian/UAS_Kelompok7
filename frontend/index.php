<?php
// Paksa PHP menampilkan error jika ada salah ketik
ini_set('display_errors', 1);
error_reporting(E_ALL);

$result = null;

// Eksekusi kode hanya jika tombol "Kirim Pesanan" diklik (Metode POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_POST['userId'] ?? '';
    $productId = $_POST['productId'] ?? '';
    $tier = $_POST['tier'] ?? 'REGULAR';
    $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;
    $address = $_POST['address'] ?? '';

    // 1. Tentukan harga satuan produk berdasarkan pilihan
    $pricePerItem = 0;
    $productName = '';
    
    if ($productId === 'P001') {
        $pricePerItem = 75000;
        $productName = 'Beras Premium 5kg';
    } elseif ($productId === 'P002') {
        $pricePerItem = 35000;
        $productName = 'Minyak Goreng 2L';
    } elseif ($productId === 'P003') {
        $pricePerItem = 15000;
        $productName = 'Gula Pasir 1kg';
    }

    // 2. Hitung total kotor
    $totalGross = $pricePerItem * $quantity;

    // 3. Hitung diskon berdasarkan Tier Pelanggan
    $discount = 0;
    if (strcasecmp($tier, 'GOLD') === 0) {
        $discount = intval($totalGross * 0.10); // 10%
    } elseif (strcasecmp($tier, 'SILVER') === 0) {
        $discount = intval($totalGross * 0.05); // 5%
    } elseif (strcasecmp($tier, 'BRONZE') === 0) {
        $discount = intval($totalGross * 0.02); // 2%
    }

    // 4. Ongkir tetap jika ada transaksi
    $deliveryFee = ($totalGross > 0) ? 15000 : 0;

    // 5. Total akhir yang harus dibayar
    $totalFinal = $totalGross - $discount + $deliveryFee;

    // Simpan hasil kalkulasi ke dalam array untuk ditampilkan di kotak hijau
    $result = [
        'status' => 'SUCCESS',
        'product' => $productName,
        'quantity' => $quantity,
        'total' => 'Rp ' . number_format($totalFinal, 0, ',', '.'),
        'discount' => 'Rp ' . number_format($discount, 0, ',', '.'),
        'deliveryFee' => 'Rp ' . number_format($deliveryFee, 0, ',', '.'),
        'address' => $address
    ];
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>FreshGrocer - Form Pemesanan Otomatis</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f7f6; margin: 0; padding: 20px; display: flex; justify-content: center; }
        .container { background: white; padding: 30px; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); width: 100%; max-width: 500px; }
        h1 { text-align: center; color: #2c3e50; margin-bottom: 25px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; color: #34495e; }
        input[type="text"], input[type="number"], select, textarea { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        button { width: 100%; padding: 12px; background-color: #28a745; color: white; border: none; border-radius: 4px; font-size: 16px; font-weight: bold; cursor: pointer; transition: background 0.2s; }
        button:hover { background-color: #218838; }
        .result-box { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; padding: 15px; border-radius: 5px; margin-bottom: 20px; }
        .result-box h3 { margin-top: 0; color: #155724; border-bottom: 1px solid #c3e6cb; padding-bottom: 5px; }
        .result-box p { margin: 5px 0; }
    </style>
</head>
<body>

<div class="container">
    <h1>FreshGrocer Order Form</h1>

    <?php if ($result && $result['status'] === 'SUCCESS'): ?>
        <div class="result-box" id="result-box">
            <h3 id="success-msg">🎉 Pesanan Berhasil Ditransfer!</h3>
            <p><b>Produk:</b> <?php echo $result['product']; ?> (x<?php echo $result['quantity']; ?>)</p>
            <p id="res-discount"><b>Diskon Pelanggan:</b> <span style="color: #dc3545;"><?php echo $result['discount']; ?></span></p>
            <p id="res-delivery"><b>Ongkos Kirim:</b> <?php echo $result['deliveryFee']; ?></p>
            <p id="res-total" style="font-size: 18px;"><b>Total Bayar:</b> <span style="color: #28a745; font-weight:bold;"><?php echo $result['total']; ?></span></p>
            <p id="res-address"><b>Alamat Pengiriman:</b> <?php echo htmlspecialchars($result['address']); ?></p>
        </div>
    <?php endif; ?>

    <form id="orderForm" method="POST" action="">
        <div class="form-group">
            <label for="userId">ID Pengguna</label>
            <input type="text" id="userId" name="userId" placeholder="Contoh: USR-MADIUN-01" required>
        </div>

        <div class="form-group">
            <label for="tier">Tier Pelanggan (Grup Diskon)</label>
            <select id="tier" name="tier">
                <option value="REGULAR">REGULAR (Diskon 0%)</option>
                <option value="BRONZE">BRONZE (Diskon 2%)</option>
                <option value="SILVER">SILVER (Diskon 5%)</option>
                <option value="GOLD">GOLD (Diskon 10%)</option>
            </select>
        </div>

        <div class="form-group">
            <label for="productId">Pilih Produk Pangan</label>
            <select id="productId" name="productId">
                <option value="P001">Beras Premium 5kg (Rp 75.000)</option>
                <option value="P002">Minyak Goreng 2L (Rp 35.000)</option>
                <option value="P003">Gula Pasir 1kg (Rp 15.000)</option>
            </select>
        </div>

        <div class="form-group">
            <label for="quantity">Kuantitas / Jumlah Item</label>
            <input type="number" id="quantity" name="quantity" min="1" value="1" required>
        </div>

        <div class="form-group">
            <label for="address">Alamat Pengiriman</label>
            <textarea id="address" name="address" rows="3" placeholder="Masukkan alamat lengkap penyerahan..." required></textarea>
        </div>

        <button type="submit" id="submitBtn">Kirim Pesanan</button>
    </form>
</div>

</body>
</html>