<?php
require_once 'check_session.php';
require_once 'conn.php';

$username = $_SESSION['sess_username'];

$sql  = "SELECT username, name, email, phone, address
         FROM   members
         WHERE  username = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) { die('ไม่พบข้อมูลผู้ใช้'); }
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>ข้อมูลส่วนตัว | <?= htmlspecialchars($user['name']) ?> | EC Shop</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body{
            background:#e8f7ec;
            font-family:"Sarabun",sans-serif;
            min-height:100vh;
        }
        .profile-card{
            max-width:640px;
            margin:4rem auto;
            border:2px solid #49b66e;
            border-radius:20px;
            background:#fff;
            box-shadow:0 10px 22px rgba(0,0,0,.07);
        }
        /* --- ส่วนหัว --- */
        .header-bar{
            background:#49b66e;
            color:#fff;
            padding:1rem 2rem;
            border-top-left-radius:18px;
            border-top-right-radius:18px;
            display:flex;
            justify-content:space-between;
            align-items:center;
        }
        .header-left{display:flex;flex-direction:column;gap:.25rem;}
        .title{font-weight:700;font-size:1.25rem;}
        .name{font-weight:500;font-size:1rem;}

        /* ปุ่มออกจากระบบ สีแดง */
        .btn-logout{
            background:transparent;
            border:1.5px solid #ff4d4f;
            color:#ff4d4f;
            padding:.35rem .8rem;
            border-radius:.4rem;
            font-weight:600;
            text-decoration:none;
            transition:background-color .3s,color .3s;
        }
        .btn-logout:hover{
            background:#ff4d4f;
            color:#fff;
            text-decoration:none;
        }

        /* --- เนื้อหา --- */
        .content-body{padding:2rem 2.5rem;}
        .info-block{margin-bottom:1.25rem;}
        .info-label{
            color:#3b9756;
            font-weight:600;
            margin:0 0 .25rem 0;
        }
        .info-value{margin:0;}
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
        <li class="nav-item"><a class="nav-link" href="show_allProduct.php">สินค้าทั้งหมด</a></li>
        <li class="nav-item"><a class="nav-link" href="viewOrder.php?order_id=1">ตะกร้าสินค้า</a></li>
        <li class="nav-item"><a class="nav-link active" href="show_profile.php">โปรไฟล์</a></li>
      </ul>
    </div>
  </div>
</nav>
<!-- 🔹 End Navbar -->

<div class="profile-card">
    <!-- แถบส่วนหัว -->
    <div class="header-bar">
        <div class="header-left">
            <div class="title">ข้อมูลส่วนตัว</div>
            <div class="name"><?= htmlspecialchars($user['name'] ?? '-') ?></div>
        </div>
        <a href="logout.php" class="btn-logout">ออกจากระบบ</a>
    </div>

    <!-- เนื้อหา -->
    <div class="content-body">
        <!-- Username -->
        <div class="info-block">
            <p class="info-label">ชื่อผู้ใช้ (Username):</p>
            <p class="info-value"><?= htmlspecialchars($user['username'] ?? '-') ?></p>
        </div>

        <!-- ชื่อ-นามสกุล -->
        <div class="info-block">
            <p class="info-label">ชื่อ-นามสกุล:</p>
            <p class="info-value"><?= htmlspecialchars($user['name'] ?? '-') ?></p>
        </div>

        <!-- อีเมล -->
        <div class="info-block">
            <p class="info-label">อีเมล:</p>
            <p class="info-value"><?= htmlspecialchars($user['email'] ?? '-') ?></p>
        </div>

        <!-- เบอร์โทร -->
        <div class="info-block">
            <p class="info-label">เบอร์โทรศัพท์:</p>
            <p class="info-value"><?= htmlspecialchars($user['phone'] ?? '-') ?></p>
        </div>

        <!-- ที่อยู่จัดส่ง -->
        <div class="info-block">
            <p class="info-label">ที่อยู่จัดส่ง:</p>
            <p class="info-value"><?= nl2br(htmlspecialchars($user['address'] ?? '-')) ?></p>
        </div>

        <!-- ปุ่มไปหน้าซื้อสินค้า -->
        <div class="text-center mt-4">
            <a href="show_allProduct.php" class="btn btn-success px-4 py-2">
                🛒 ซื้อสินค้า
            </a>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
