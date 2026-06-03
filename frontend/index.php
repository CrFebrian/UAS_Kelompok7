<?php
$result = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_POST['userId'] ?? '';
    $productId = $_POST['productId'] ?? '';
    $tier = $_POST['tier'] ?? 'REGULAR';
    $quantity = $_POST['quantity'] ?? '0';
    $duration = $_POST['duration'] ?? '0';
    $isGroup = isset($_POST['isGroup']) ? 'true' : 'false';
    $address = $_POST['address'] ?? '';

    $url = 'http://localhost:8080/api/order';
    $data = json_encode([
        'userId' => $userId,
        'productId' => $productId,
        'tier' => $tier,
        'quantity' => $quantity,
        'duration' => $duration,
        'isGroup' => $isGroup,
        'address' => $address
    ]);

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Content-Length: ' . strlen($data)
    ]);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode === 200) {
        $result = json_decode($response, true);
    } else {
        $result = ['status' => 'ERROR', 'message' => 'Backend system error occurred'];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>FreshGrocer - Order Form</title>
</head>
<body>
<div id="app-container">
    <h1>FreshGrocer Order Form</h1>

    <?php if ($result): ?>
        <div id="result-box">
            <?php if (($result['status'] ?? '') === 'SUCCESS'): ?>
                <h3 id="success-msg">Pesanan Berhasil</h3>
                <p id="res-total">Total: <?php echo $result['total']; ?></p>
                <p id="res-discount">Diskon: <?php echo $result['discount']; ?></p>
                <p id="res-delivery">Ongkir: <?php echo $result['deliveryFee']; ?></p>
                <p id="res-address">Alamat: <?php echo $_POST['address']; ?></p>
            <?php else: ?>
                <h3 id="error-msg">Pesanan Gagal</h3>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <form id="orderForm" method="POST" action="">
        <div>
            <label for="userId">ID Pengguna</label>
            <input type="text" id="userId" name="userId">
        </div>

        <div>
            <label for="tier">Tier Pelanggan</label>
            <select id="tier" name="tier">
                <option value="REGULAR">REGULAR</option>
                <option value="BRONZE">BRONZE</option>
                <option value="SILVER">SILVER</option>
                <option value="GOLD">GOLD</option>
            </select>
        </div>

        <div>
            <label for="productId">Produk</label>
            <select id="productId" name="productId">
                <option value="P001" data-stock="50">Beras Premium 5kg</option>
                <option value="P002" data-stock="20">Minyak Goreng 2L</option>
                <option value="P003" data-stock="100">Gula Pasir 1kg</option>
            </select>
        </div>

        <div>
            <label for="quantity">Kuantitas</label>
            <input type="number" id="quantity" name="quantity">
            <span id="quantityError" style="color:red; display:none;"></span>
        </div>

        <div>
            <label for="duration">Durasi Berlangganan (Bulan)</label>
            <input type="number" id="duration" name="duration">
            <span id="durationError" style="color:red; display:none;"></span>
        </div>

        <div>
            <label>
                <input type="checkbox" id="isGroup" name="isGroup"> Group Buying
            </label>
        </div>

        <div>
            <label for="address">Alamat Lengkap</label>
            <textarea id="address" name="address" rows="3"></textarea>
        </div>

        <button type="submit" id="submitBtn">Kirim Pesanan</button>
    </form>
</div>
<script src="assets/app.js"></script>
</body>
</html>