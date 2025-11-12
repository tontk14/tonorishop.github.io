<?php
session_start();
require_once 'conn.php';

if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    header("Location: cart.php");
    exit;
}

// ต้องล็อกอินก่อน
if (!isset($_SESSION['sess_username'])) {
    die("⚠️ กรุณาเข้าสู่ระบบก่อนทำการสั่งซื้อ");
}
$username = $_SESSION['sess_username'];

// ✅ ดึงชื่อลูกค้าจาก members
$sql_user = "SELECT name FROM members WHERE username = ?";
$stmt = $conn->prepare($sql_user);
$stmt->bind_param("s", $username);
$stmt->execute();
$res = $stmt->get_result();
$userData = $res->fetch_assoc();
$customerName = $userData['name'] ?? $username;

// ✅ เมื่อกดยืนยันสั่งซื้อ
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $address = $conn->real_escape_string($_POST['address']);
    $payment = $conn->real_escape_string($_POST['payment_method']);

    $total = 0;
    foreach ($_SESSION['cart'] as $item) {
        $total += $item['price'] * $item['qty'];
    }

    try {
        $conn->begin_transaction();

        $sql = "INSERT INTO orders (username, total_price, payment_method, shipping_address)
                VALUES ('$username', '$total', '$payment', '$address')";
        if (!$conn->query($sql)) {
            throw new Exception("Insert order failed: " . $conn->error);
        }
        $order_id = $conn->insert_id;

        foreach ($_SESSION['cart'] as $item) {
            $pid   = $conn->real_escape_string($item['productID']);
            $pname = $conn->real_escape_string($item['name']);
            $qty   = (int)$item['qty'];
            $price = (float)$item['price'];

            $sql_detail = "INSERT INTO order_details (order_id, product_id, product_name, quantity, price)
                           VALUES ('$order_id', '$pid', '$pname', '$qty', '$price')";
            if (!$conn->query($sql_detail)) {
                throw new Exception("Insert order_detail failed: " . $conn->error);
            }
        }

        $conn->commit();
        unset($_SESSION['cart']);

        echo "<div style='text-align:center; margin-top:50px; font-family:Arial;'>
                <h2 style='color:green;'>✅ สั่งซื้อสำเร็จ</h2>
                <p>รหัสคำสั่งซื้อของคุณคือ 
                   <strong><a href='viewOrder.php?order_id={$order_id}'>#{$order_id}</a></strong>
                </p>
                <a href='show_allProduct.php'>🛍️ กลับไปเลือกซื้อสินค้าต่อ</a>
              </div>";
        exit;

    } catch (Exception $e) {
        $conn->rollback();
        die("❌ เกิดข้อผิดพลาด: " . $e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>ยืนยันการสั่งซื้อ | EC Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-family: Arial, sans-serif; background:#fdfcf8; padding:20px; }
        .container { max-width: 700px; margin:auto; background:white; padding:20px; border-radius:10px; box-shadow:0 2px 6px rgba(0,0,0,0.1); }
        h2 { text-align:center; margin-bottom:20px; }
        table { width:100%; border-collapse:collapse; margin-bottom:20px; }
        th, td { padding:10px; border:1px solid #ddd; text-align:center; }
        th { background:#f5f5f5; }
    </style>
</head>
<body>

<!-- 🔹 Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand text-success fw-bold" href="index.php">TONORI Shop</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarNav" aria-controls="navbarNav"
            aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
      <ul class="navbar-nav">
       
        <li class="nav-item"><a class="nav-link" href="show_allProduct.php">สินค้าทั้งหมด</a></li>
        <li class="nav-item"><a class="nav-link active" href="cart.php">ตะกร้าสินค้า</a></li>
      </ul>
    </div>
  </div>
</nav>
<!-- 🔹 End Navbar -->

<div class="container">
    <h2>🛒 ยืนยันการสั่งซื้อ</h2>

    <h3>สินค้าในตะกร้า</h3>
    <table>
        <tr>
            <th>สินค้า</th>
            <th>ราคา</th>
            <th>จำนวน</th>
            <th>รวม</th>
        </tr>
        <?php
        $total = 0;
        foreach ($_SESSION['cart'] as $item) {
            $sum = $item['price'] * $item['qty'];
            $total += $sum;
            echo "<tr>
                    <td>{$item['name']}</td>
                    <td>" . number_format($item['price'], 2) . "</td>
                    <td>{$item['qty']}</td>
                    <td>" . number_format($sum, 2) . "</td>
                  </tr>";
        }
        echo "<tr>
                <td colspan='3'><strong>รวมทั้งหมด</strong></td>
                <td><strong>" . number_format($total, 2) . " บาท</strong></td>
              </tr>";
        ?>
    </table>

    <h3>ข้อมูลการจัดส่ง</h3>
    <form method="post">
        <div class="mb-3">
            <label class="form-label">ชื่อลูกค้า</label>
            <input type="text" class="form-control" value="<?= htmlspecialchars($customerName) ?>" readonly>
        </div>
        <div class="mb-3">
            <label class="form-label">ที่อยู่จัดส่ง</label>
            <textarea class="form-control" name="address" required></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">วิธีชำระเงิน</label>
            <select class="form-select" name="payment_method" required>
                <option value="COD">เก็บเงินปลายทาง</option>
                <option value="Bank Transfer">โอนผ่านธนาคาร</option>
                <option value="Credit Card">บัตรเครดิต</option>
            </select>
        </div>
        <div class="text-center">
            <button type="submit" class="btn btn-success">✅ ยืนยันการสั่งซื้อ</button>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
