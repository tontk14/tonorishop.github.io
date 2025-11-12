<?php
session_start();
define('MAIN_PAGE', true);  // ✅ กำหนดค่าเพื่อบอกว่าไฟล์นี้คือหน้าแรก
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ToNORI | หน้าแรก</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-family: "Sarabun", sans-serif; background:#f8f9fa; }
        .navbar-brand { font-weight:700; color:#28a745 !important; }
        .hero {
            background:#e8f7ec;
            padding:60px 20px;
            text-align:center;
        }
        .hero h1 { font-size:2.5rem; font-weight:700; color:#28a745; }
        .hero p { font-size:1.2rem; color:#555; }
        .btn-main {
            background:#28a745;
            color:#fff;
            padding:12px 30px;
            font-size:1.1rem;
            border-radius:30px;
            text-decoration:none;
        }
        .btn-main:hover { background:#218838; color:#fff; }
        .product-section { padding:40px 20px; }
    </style>
</head>
<body>

<!-- ░░ Navbar ░░ -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="index.php">TONORI Shop</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <?php if (!empty($_SESSION['sess_username'])): ?>
                    <li class="nav-item"><a class="nav-link" href="show_profile.php">หน้าโปรไฟล์</a></li>
                    <li class="nav-item"><a class="nav-link" href="logout.php">ออกจากระบบ</a></li>
                <?php else: ?>
                    <li class="nav-item"><a class="nav-link" href="register_form.php">สมัครสมาชิก</a></li>
                    <li class="nav-item"><a class="nav-link" href="login_form.php">เข้าสู่ระบบ</a></li>
                <?php endif; ?>
                <li class="nav-item"><a class="nav-link" href="cart.php">ตะกร้าสินค้า</a></li>
            </ul>
        </div>
    </div>
</nav>

<!-- ░░ Hero Banner ░░ -->
<section class="hero">
    <div class="container">
        <h1>ยินดีต้อนรับสู่ TONORI Shop</h1>
        <p>ร้านค้าออนไลน์ ซื้อขายง่าย จ่ายสะดวก</p>
        <?php if (empty($_SESSION['sess_username'])): ?>
            <a href="register_form.php" class="btn-main mt-3">สมัครสมาชิก</a>
        <?php else: ?>
            <a href="#products" class="btn-main mt-3">เริ่มช้อปเลย</a>
        <?php endif; ?>
    </div>
</section>

<!-- ░░ Product Section ░░ -->
<section id="products" class="product-section">
    <div class="container">
        <?php
            // ✅ include ไฟล์แสดงสินค้า
            include __DIR__ . '/Show_allProduct.php';
        ?>
    </div>
</section>

<!-- ░░ Footer ░░ -->
<footer class="text-center py-4 bg-white border-top mt-5">
    <small>© <?=date('Y')?> EC Shop. All rights reserved.</small>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
