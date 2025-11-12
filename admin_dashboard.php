<?php
session_start();
if (!isset($_SESSION['admin_username'])) {
    header("Location: admin_login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>แดชบอร์ดแอดมิน | EC Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background:#f8f9fa; font-family:"Sarabun",sans-serif; }
        .dashboard { max-width:1000px; margin:40px auto; }
        .card { border-radius:12px; box-shadow:0 4px 10px rgba(0,0,0,.05); }
        .card h5 { font-weight:600; }
    </style>
</head>
<body>

<?php include "admin_navbar.php"; ?>

<div class="container dashboard">
    <h2 class="text-center text-success mb-4">📊 แดชบอร์ดผู้ดูแลระบบ</h2>
    <p class="text-center">สวัสดี <strong><?= htmlspecialchars($_SESSION['admin_username']) ?></strong> ยินดีต้อนรับสู่ระบบจัดการร้าน TONARI SHOP</p>

    <div class="row g-4 mt-4">
        <!-- จัดการสินค้า -->
        <div class="col-md-4">
            <div class="card text-center p-4">
                <h5>📦 ดูรายการสินค้า</h5>
                <p> รายการสินค้าในร้าน</p>
                <a href="Product_list.php" class="btn btn-success">ไปที่นี่</a>
            </div>
        </div>

        <!-- เพิ่มสินค้า -->
        <div class="col-md-4">
            <div class="card text-center p-4">
                <h5>➕ เพิ่มสินค้าใหม่</h5>
                <p>บันทึกข้อมูลสินค้าเข้าสู่ระบบ</p>
                <a href="addProduct_form.php" class="btn btn-success">เพิ่มสินค้า</a>
            </div>
        </div>

        <!-- รายการสั่งซื้อ -->
        <div class="col-md-4">
            <div class="card text-center p-4">
                <h5>📋 รายการสั่งซื้อ</h5>
                <p>ตรวจสอบและติดตามคำสั่งซื้อทั้งหมด</p>
                <a href="order_list.php" class="btn btn-success">ดูออเดอร์</a>
            </div>
        </div>

        <!-- ข้อมูลสมาชิก -->
        <div class="col-md-4">
            <div class="card text-center p-4">
                <h5>👥 ข้อมูลสมาชิก</h5>
                <p>ดูและจัดการบัญชีผู้ใช้งาน</p>
                <a href="show_members.php" class="btn btn-success">ดูสมาชิก</a>
            </div>
        </div>

        <!-- สมัครแอดมินใหม่ -->
        <div class="col-md-4">
            <div class="card text-center p-4">
                <h5>🛡️ จัดการแอดมิน</h5>
                <p>สมัครแอดมินใหม่เพื่อช่วยจัดการระบบ</p>
                <a href="register_admin.php" class="btn btn-warning">สมัครแอดมิน</a>
            </div>
        </div>

        <!-- ออกจากระบบ -->
        <div class="col-md-4">
            <div class="card text-center p-4">
                <h5>🚪 ออกจากระบบ</h5>
                <p>ออกจากระบบผู้ดูแลระบบ</p>
                <a href="logout_admin.php" class="btn btn-danger">ออกจากระบบ</a>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
