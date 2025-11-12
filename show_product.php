<?php
session_start();
require_once 'conn.php';

// ตรวจสอบ productID
if (!isset($_GET['productID'])) {
    die("❌ ไม่พบรหัสสินค้า");
}

$productID = $_GET['productID'];

// ดึงข้อมูลสินค้า
$sql = "SELECT * FROM product WHERE productID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $productID);
$stmt->execute();
$product = $stmt->get_result()->fetch_assoc();

if (!$product) {
    die("❌ ไม่พบข้อมูลสินค้า");
}

// เพิ่มสินค้าเข้าตะกร้าเมื่อกดปุ่ม
$addedMessage = '';
if (isset($_POST['cart'])) {
    $id = $product['ProductID'];
    $name = $product['product_name'];
    $price = $product['price'];
    $quantity = 1;

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // ถ้าสินค้าอยู่แล้วในตะกร้า เพิ่มจำนวน
    if (isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id]['quantity'] += $quantity;
    } else {
        $_SESSION['cart'][$id] = [
            'name' => $name,
            'price' => $price,
            'quantity' => $quantity
        ];
    }

    $addedMessage = "✅ เพิ่มสินค้า '{$name}' เข้าตะกร้าแล้ว";
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<title><?= htmlspecialchars($product['product_name']) ?> | TONORI Shop</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body { background:#fdfcf8; font-family:"Sarabun", sans-serif; }
.product-container { max-width: 1000px; margin: 40px auto; background:#fff; padding:20px; border-radius:12px; box-shadow:0 4px 10px rgba(0,0,0,0.1); }
.product-image { text-align:center; }
.product-image img { max-width:100%; border-radius:10px; box-shadow:0 2px 6px rgba(0,0,0,0.1); }
.product-details h2 { color:#333; }
.product-details .price { font-size:1.5rem; font-weight:bold; color:#d35400; }
.btn-cart { background:#28a745; color:#fff; padding:10px 20px; border-radius:8px; text-decoration:none; display:inline-block; margin-right:10px; border:none; cursor:pointer;}
.btn-cart:hover { background:#218838; color:#fff; }
.btn-back { background:#6c757d; color:#fff; padding:10px 20px; border-radius:8px; text-decoration:none; display:inline-block; }
.btn-back:hover { background:#5a6268; color:#fff; }
.added-message { color: green; margin-top: 10px; font-weight: bold; }
</style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
<div class="container">
<a class="navbar-brand fw-bold text-success" href="index.php">TONORI Shop</a>
<div class="collapse navbar-collapse justify-content-end" id="navbarNav">
<ul class="navbar-nav">
<li class="nav-item"><a class="nav-link" href="index.php">หน้าแรก</a></li>
<li class="nav-item"><a class="nav-link" href="show_allProduct.php">สินค้าทั้งหมด</a></li>
<li class="nav-item"><a class="nav-link" href="cart.php">ตะกร้าสินค้า</a></li>
</ul>
</div>
</div>
</nav>

<div class="container product-container">
<div class="row">
  <div class="col-md-6 product-image">
    <?php if (!empty($product['image']) && file_exists("Product_image/" . $product['image'])): ?>
      <img src="Product_image/<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['product_name']) ?>">
    <?php else: ?>
      <img src="noimage.png" alt="ไม่มีรูป">
    <?php endif; ?>
  </div>

  <div class="col-md-6 product-details">
    <h2><?= htmlspecialchars($product['product_name'], ENT_QUOTES, 'UTF-8') ?></h2>
    <p class="price"><?= number_format($product['price'], 2) ?> บาท</p>
    <p><?= nl2br(htmlspecialchars($product['details'], ENT_QUOTES, 'UTF-8')) ?></p>

    <!-- ปุ่มเพิ่มลงตะกร้า -->
    <form method="post" style="display:inline-block;">
        <button type="submit" name="add_to_cart" class="btn-cart">
            🛒 เพิ่มลงตะกร้า
        </button>
    </form>
    <a href="show_allProduct.php" class="btn-back">⬅ กลับไปหน้าสินค้าทั้งหมด</a>

    <?php if (!empty($addedMessage)): ?>
        <p class="added-message"><?= $addedMessage ?></p>
    <?php endif; ?>
  </div>
</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
