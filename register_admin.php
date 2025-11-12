<?php
session_start();
require_once 'conn.php';

$msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $name     = trim($_POST['name']);
    $email    = trim($_POST['email']);

    // ✅ เช็คว่าซ้ำหรือไม่
    $sql = "SELECT * FROM admin WHERE username = ? OR email = ? LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $msg = "❌ ชื่อผู้ใช้หรืออีเมลนี้มีอยู่แล้ว";
    } else {
        // ✅ บันทึกลง DB (เข้ารหัสรหัสผ่าน)
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $sql_insert = "INSERT INTO admin (username, password, name, email, created_at)
                       VALUES (?, ?, ?, ?, NOW())";
        $stmt = $conn->prepare($sql_insert);
        $stmt->bind_param("ssss", $username, $hashedPassword, $name, $email);

        if ($stmt->execute()) {
            $msg = "✅ สมัครแอดมินสำเร็จแล้ว สามารถเข้าสู่ระบบได้";
        } else {
            $msg = "❌ เกิดข้อผิดพลาด: " . $conn->error;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>สมัครแอดมิน | EC Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background:#f0f2f5; font-family: "Sarabun", sans-serif; }
        .register-box {
            max-width:500px;
            margin:50px auto;
            background:#fff;
            padding:30px;
            border-radius:12px;
            box-shadow:0 4px 12px rgba(0,0,0,0.1);
        }
        .btn-green { background:#28a745; color:#fff; }
        .btn-green:hover { background:#218838; }
    </style>
</head>
<body>

<?php include "admin_navbar.php"; ?>

<div class="register-box">
    <h2 class="text-center text-success">สมัครแอดมินใหม่</h2>

    <?php if($msg): ?>
        <div class="alert alert-info text-center"><?= $msg ?></div>
    <?php endif; ?>

    <form method="post" class="d-grid gap-3">
        <input type="text" name="username" class="form-control" placeholder="ชื่อผู้ใช้" required>
        <input type="password" name="password" class="form-control" placeholder="รหัสผ่าน" required>
        <input type="text" name="name" class="form-control" placeholder="ชื่อ-นามสกุล" required>
        <input type="email" name="email" class="form-control" placeholder="อีเมล" required>
        <button type="submit" class="btn btn-green">สมัครสมาชิก</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
