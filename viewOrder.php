<?php
session_start();
require_once 'conn.php';

// ต้องล็อกอินก่อน
if (!isset($_SESSION['sess_username'])) {
    die("⚠️ กรุณาเข้าสู่ระบบก่อนดูคำสั่งซื้อ");
}
$username = $_SESSION['sess_username'];

// ตรวจสอบว่ามี order_id ส่งมาหรือไม่
if (!isset($_GET['order_id'])) {
    die("❌ ไม่พบรหัสคำสั่งซื้อ");
}
$order_id = (int) $_GET['order_id'];

// ดึงข้อมูลคำสั่งซื้อ
$sql_order = "SELECT * FROM orders WHERE order_id = ? AND username = ?";
$stmt = $conn->prepare($sql_order);
$stmt->bind_param("is", $order_id, $username);
$stmt->execute();
$result = $stmt->get_result();
$order = $result->fetch_assoc();

if (!$order) {
    die("❌ ไม่พบคำสั่งซื้อ หรือคุณไม่มีสิทธิ์ดูคำสั่งซื้อนี้");
}

// ✅ ดึงชื่อลูกค้าจาก members
$sql_user = "SELECT name FROM members WHERE username = ?";
$stmt_user = $conn->prepare($sql_user);
$stmt_user->bind_param("s", $username);
$stmt_user->execute();
$res_user = $stmt_user->get_result();
$userData = $res_user->fetch_assoc();
$customerName = $userData['name'] ?? $username;

// ดึงรายละเอียดสินค้าในคำสั่งซื้อนี้
$sql_items = "SELECT * FROM order_details WHERE order_id = ?";
$stmt_items = $conn->prepare($sql_items);
$stmt_items->bind_param("i", $order_id);
$stmt_items->execute();
$items = $stmt_items->get_result();
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>รายละเอียดคำสั่งซื้อ #<?= $order_id ?> | EC Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-family: Arial, sans-serif; background:#fdfcf8; padding:20px; }
        .container { max-width: 800px; margin:auto; background:white; padding:20px; border-radius:10px; box-shadow:0 2px 6px rgba(0,0,0,0.1); }
        h2 { text-align:center; margin-bottom:20px; }
        .order-info { margin-bottom:20px; line-height:1.6; }
        table { width:100%; border-collapse:collapse; margin-bottom:20px; }
        th, td { padding:10px; border:1px solid #ddd; text-align:center; }
        th { background:#f5f5f5; }
        .total { text-align:right; font-weight:bold; }
        .back-btn { display:inline-block; padding:8px 16px; background:#3498db; color:white; text-decoration:none; border-radius:6px; }
        .back-btn:hover { background:#2980b9; }
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
        <li class="nav-item"><a class="nav-link" href="logout.php">ออกจากระบบ</a></li>
         <li class="nav-item"><a class="nav-link" href="index.php">หน้าแรก</a></li>
         <li class="nav-item"><a class="nav-link active" href="show_profile.php">โปรไฟล์</a></li>
      </ul>
    </div>
  </div>
</nav>
<!-- 🔹 End Navbar -->

<div class="container">
    <h2>📦 รายละเอียดคำสั่งซื้อ #<?= htmlspecialchars($order_id) ?></h2>

    <div class="order-info">
        <p><strong>ชื่อลูกค้า:</strong> <?= htmlspecialchars($customerName) ?></p>
        <p><strong>วันที่สั่งซื้อ:</strong> <?= htmlspecialchars($order['order_date']) ?></p>
        <p><strong>วิธีชำระเงิน:</strong> <?= htmlspecialchars($order['payment_method']) ?></p>
        <p><strong>ที่อยู่จัดส่ง:</strong> <?= nl2br(htmlspecialchars($order['shipping_address'])) ?></p>
        <p><strong>ราคารวม:</strong> <?= number_format($order['total_price'], 2) ?> บาท</p>
    </div>

    <h3>สินค้าในคำสั่งซื้อ</h3>
    <table>
        <tr>
            <th>รหัสสินค้า</th>
            <th>ชื่อสินค้า</th>
            <th>ราคา</th>
            <th>จำนวน</th>
            <th>รวม</th>
        </tr>
        <?php
        $order_total = 0;
        while ($item = $items->fetch_assoc()) {
            $sum = $item['price'] * $item['quantity'];
            $order_total += $sum;
            echo "<tr>
                    <td>{$item['product_id']}</td>
                    <td>{$item['product_name']}</td>
                    <td>" . number_format($item['price'], 2) . " บาท</td>
                    <td>{$item['quantity']}</td>
                    <td>" . number_format($sum, 2) . " บาท</td>
                  </tr>";
        }
        echo "<tr>
                <td colspan='4' class='total'>ยอดรวม</td>
                <td><strong>" . number_format($order_total, 2) . " บาท</strong></td>
              </tr>";
        ?>
    </table>

    <div style="text-align:center;">
        <a href="show_allProduct.php" class="back-btn">⬅ กลับไปเลือกซื้อสินค้า</a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
