<?php
// ---------- login_form.php ----------
session_start();

// ถ้ามี error ส่งกลับมาจาก check_login.php ให้เก็บข้อความไว้แสดง
$errorMsg = '';
if (isset($_GET['error']) && $_GET['error'] == 1) {
    $errorMsg = 'ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง';
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>เข้าสู่ระบบ | EC Shop</title>
    <!-- Bootstrap 5 CDN -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">
    <style>
        body {
            background:#e8f7ec;
            font-family: "Sarabun", sans-serif;
        }
        .login-card {
            max-width: 380px;
            width: 100%;
            border: 2px solid #b6e2c3;
            border-radius: 14px;
            background: #ffffff;
            padding: 2.5rem 2rem;
            box-shadow: 0 8px 20px rgba(0,0,0,.08);
            margin: 80px auto;
        }
        .login-card h2 {
            color: #3b9756;
            font-weight: 700;
            margin-bottom: 1.5rem;
            text-align:center;
        }
        .btn-green {
            background:#49b66e;
            color:#fff;
        }
        .btn-green:hover{background:#3fa363;}
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
        <li class="nav-item">
          <a class="nav-link" href="register_form.php">สมัครสมาชิก</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="login_form.php">เข้าสู่ระบบ</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="show_allProduct.php">สินค้าทั้งหมด</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="viewOrder.php?order_id=1">ตะกร้าสินค้า</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
<!-- 🔹 End Navbar -->

<div class="login-card">
    <h2>เข้าสู่ระบบ</h2>

    <?php if ($errorMsg): ?>
        <div class="alert alert-danger py-2 text-center" role="alert">
            <?= htmlspecialchars($errorMsg) ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="check_login.php" class="d-grid gap-3">
        <input type="text"
               name="username"
               placeholder="Username"
               class="form-control"
               required
               autofocus>

        <input type="password"
               name="password"
               placeholder="Password"
               class="form-control"
               required>

        <button type="submit" class="btn btn-green w-100">เข้าสู่ระบบ</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
