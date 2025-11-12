<?php
require_once 'conn.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// ตรวจสอบการเชื่อมต่อ
if (!$conn) {
    die("เชื่อมต่อฐานข้อมูลไม่สำเร็จ: " . mysqli_connect_error());
}

// ดึงข้อมูลสินค้าทั้งหมด
$sql = "SELECT productID, product_name, price, details, image FROM product";
$result = $conn->query($sql);

if (!$result) {
    die("เกิดข้อผิดพลาดในการดึงข้อมูล: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>สินค้าทั้งหมด | TONORI Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-family: Arial, sans-serif; background: #fdfcf8; margin: 0; padding: 0; }
        h2 { text-align: center; margin: 20px; }
        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            max-width: 1100px;
            margin: auto;
            padding: 20px;
        }
        .card { background: #fff; border-radius: 10px; box-shadow: 0 2px 6px rgba(0,0,0,0.1); padding: 15px; text-align: center; }
        .card img { max-width: 100%; height: 180px; object-fit: cover; border-radius: 6px; transition: transform 0.2s; }
        .card img:hover { transform: scale(1.05); }
        .card h3 { margin: 10px 0; color: #333; font-size: 1.2rem; }
        .price { font-weight: bold; color: #d35400; margin-bottom: 10px; }
        .btn { display: inline-block; padding: 8px 14px; background: #3498db; color: white; border-radius: 6px; text-decoration: none; }
        .btn:hover { background: #2980b9; }
    </style>
</head>
<body>

<?php if (!defined('MAIN_PAGE')): ?>
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
        <li class="nav-item"><a class="nav-link" href="register_form.php">สมัครสมาชิก</a></li>
        <li class="nav-item"><a class="nav-link" href="login_form.php">เข้าสู่ระบบ</a></li>
        <li class="nav-item"><a class="nav-link active" href="Show_allProduct.php">สินค้าทั้งหมด</a></li>
        <li class="nav-item"><a class="nav-link" href="cart.php">ตะกร้าสินค้า</a></li>
      </ul>
    </div>
  </div>
</nav>
<?php endif; ?>

<h2>📦 สินค้าทั้งหมด</h2>

<div class="product-grid">
    <?php
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div class='card'>";

            // ✅ คลิกรูปไป show_product.php
            echo "<a href='show_product.php?productID=" . urlencode($row['productID']) . "'>";
            if (!empty($row['image']) && file_exists("Product_image/" . $row['image'])) {
                echo "<img src='Product_image/" . htmlspecialchars($row['image']) . "' alt='" . htmlspecialchars($row['product_name']) . "'>";
            } else {
                echo "<img src='noimage.png' alt='ไม่มีรูป'>";
            }
            echo "</a>";

            // ✅ คลิกชื่อไป show_product.php
            echo "<h3><a href='show_product.php?productID=" . urlencode($row['productID']) . "' style='text-decoration:none; color:#333;'>" 
                 . htmlspecialchars($row['product_name']) . "</a></h3>";

            echo "<p class='price'>" . number_format($row['price'], 2) . " บาท</p>";
            echo "<p>" . htmlspecialchars(mb_strimwidth($row['details'], 0, 50, "...")) . "</p>";
            echo "<a class='btn' href='cart.php?action=add&id=" . urlencode($row['productID']) . "'>🛒 หยิบใส่ตะกร้า</a>";
            echo "</div>";
        }
    } else {
        echo "<p>ไม่มีสินค้า</p>";
    }
    ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
