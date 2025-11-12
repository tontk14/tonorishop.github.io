<?php
session_start();
require_once 'conn.php';

// ตรวจสอบ action ที่ส่งมาจาก URL
if (isset($_GET['action'])) {
    $action = $_GET['action'];

    // ✅ เพิ่มสินค้าเข้าตะกร้า
    if ($action == "add" && isset($_GET['id'])) {
        $productID = $conn->real_escape_string($_GET['id']);

        $sql = "SELECT productID, product_name, price FROM product WHERE productID = '$productID'";
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            $product = $result->fetch_assoc();

            if (!isset($_SESSION['cart'])) {
                $_SESSION['cart'] = [];
            }

            if (isset($_SESSION['cart'][$productID])) {
                $_SESSION['cart'][$productID]['qty'] = ($_SESSION['cart'][$productID]['qty'] ?? 0) + 1;
            } else {
                $_SESSION['cart'][$productID] = [
                    "productID" => $product['productID'] ?? '',
                    "name"      => $product['product_name'] ?? '',
                    "price"     => $product['price'] ?? 0,
                    "qty"       => 1
                ];
            }
        }
    }

    // ✅ ลบสินค้า
    if ($action == "remove" && isset($_GET['id'])) {
        $productID = $_GET['id'];
        if (isset($_SESSION['cart'][$productID])) {
            unset($_SESSION['cart'][$productID]);
        }
    }

    // ✅ ล้างตะกร้า
    if ($action == "clear") {
        unset($_SESSION['cart']);
    }

    header("Location: cart.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>ตะกร้าสินค้า | EC Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-family: Arial, sans-serif; background: #fdfcf8; padding: 20px; }
        h2 { text-align: center; margin-bottom:20px; }
        table {
            border-collapse: collapse;
            width: 80%;
            margin: 20px auto;
            background: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0px 2px 6px rgba(0,0,0,0.1);
        }
        th, td { padding: 12px; border-bottom: 1px solid #ddd; text-align: center; }
        th { background: #f5f5f5; }
        .btn { display: inline-block; padding: 6px 12px; background: #3498db; color: #fff; border-radius: 6px; text-decoration:none; }
        .btn:hover { background: #2980b9; }
        .danger { background: #e74c3c; }
        .danger:hover { background: #c0392b; }
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
        <li class="nav-item"><a class="nav-link" href="index.php">หน้าแรก</a></li>
        <li class="nav-item"><a class="nav-link" href="logout.php">ออกจากสู่ระบบ</a></li>
        <li class="nav-item"><a class="nav-link" href="show_allProduct.php">สินค้าทั้งหมด</a></li>
      </ul>
    </div>
  </div>
</nav>
<!-- 🔹 End Navbar -->

<h2>🛒 ตะกร้าสินค้า</h2>
<table>
    <tr>
        <th>รหัสสินค้า</th>
        <th>ชื่อสินค้า</th>
        <th>ราคา</th>
        <th>จำนวน</th>
        <th>รวม</th>
        <th>จัดการ</th>
    </tr>
    <?php
    $total = 0;
    if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
        foreach ($_SESSION['cart'] as $item) {
            $productID = $item['productID'] ?? '';
            $name      = $item['name'] ?? '';
            $price     = $item['price'] ?? 0;
            $qty       = $item['qty'] ?? 0;

            $subtotal = $price * $qty;
            $total += $subtotal;

            echo "<tr>
                    <td>{$productID}</td>
                    <td>{$name}</td>
                    <td>" . number_format($price, 2) . " บาท</td>
                    <td>{$qty}</td>
                    <td>" . number_format($subtotal, 2) . " บาท</td>
                    <td><a class='btn danger' href='cart.php?action=remove&id={$productID}'>ลบ</a></td>
                  </tr>";
        }
        echo "<tr>
                <td colspan='4' style='text-align:right;'><strong>ราคารวมทั้งหมด</strong></td>
                <td colspan='2'><strong>" . number_format($total, 2) . " บาท</strong></td>
              </tr>";
    } else {
        echo "<tr><td colspan='6'>ไม่มีสินค้าในตะกร้า</td></tr>";
    }
    ?>
</table>

<div style="text-align:center;">
    <a class="btn" href="show_allProduct.php">⬅ เลือกซื้อสินค้าต่อ</a>
    <a class="btn danger" href="cart.php?action=clear">🗑 ล้างตะกร้า</a>
    <?php if ($total > 0): ?>
        <a class="btn" style="background:green;" href="checkout.php">✅ ดำเนินการสั่งซื้อ</a>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
