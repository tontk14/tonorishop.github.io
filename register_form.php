<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>สมัครสมาชิก | EC Shop</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #e6ffeeff;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 500px;
            margin: 80px auto;
            background-color: #f0fff8ff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(255, 105, 180, 0.2);
        }

        h2 {
            text-align: center;
            color: #2a7f42ff;
        }

        label {
            display: block;
            margin-top: 15px;
            color: #167337ff;
            font-weight: bold;
        }

        input, textarea {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #c1ffd8ff;
            border-radius: 5px;
            box-sizing: border-box;
        }

        input:focus, textarea:focus {
            border-color: #279d52ff;
            outline: none;
        }

        button {
            margin-top: 20px;
            width: 100%;
            padding: 12px;
            background-color: #279344ff;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color: #d81b60;
        }
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
        <li class="nav-item">
            <li class="nav-item"><a class="nav-link" href="index.php">หน้าแรก</a></li>
          <a class="nav-link active" href="register_form.php">สมัครสมาชิก</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="login_form.php">เข้าสู่ระบบ</a>
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

<div class="container">
    <h2>สมัครสมาชิก</h2>
    <form action="register.php" method="POST">
        <label for="username">ชื่อผู้ใช้ (Username)</label>
        <input type="text" id="username" name="username" required>

        <label for="password">รหัสผ่าน (Password)</label>
        <input type="password" id="password" name="password" required>

        <label for="name">ชื่อ-นามสกุล</label>
        <input type="text" id="name" name="name" required>

        <label for="email">อีเมล</label>
        <input type="email" id="email" name="email" required>

        <label for="phone">เบอร์โทรศัพท์</label>
        <input type="tel" id="phone" name="phone">

        <label for="address">ที่อยู่</label>
        <textarea id="address" name="address" rows="4"></textarea>

        <button type="submit">สมัครสมาชิก</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
