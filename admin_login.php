<?php
session_start();
require_once 'conn.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $sql = "SELECT * FROM admin WHERE username = ? LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $admin = $result->fetch_assoc();

        if (password_verify($password, $admin['password'])) {
            $_SESSION['admin_username'] = $admin['username'];
            header("Location: admin_dashboard.php");
            exit;
        } else {
            $error = "❌ รหัสผ่านไม่ถูกต้อง";
        }
    } else {
        $error = "❌ ไม่พบบัญชีแอดมิน";
    }
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>เข้าสู่ระบบแอดมิน | EC Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background:#e8f7ec; font-family:"Sarabun",sans-serif; }
        .login-box { max-width:400px; margin:80px auto; background:#fff; padding:30px; border-radius:12px; box-shadow:0 4px 12px rgba(0,0,0,0.1); }
        .btn-green { background:#28a745; color:#fff; }
        .btn-green:hover { background:#218838; }
    </style>
</head>
<body>

<!-- 🔹 Navbar -->
<?php include "admin_navbar.php"; ?>

<div class="login-box">
    <h2 class="text-center text-success">เข้าสู่ระบบแอดมิน</h2>
    <?php if($error): ?>
        <div class="alert alert-danger text-center"><?= $error ?></div>
    <?php endif; ?>
    <form method="post" class="d-grid gap-3">
        <input type="text" name="username" class="form-control" placeholder="ชื่อผู้ใช้แอดมิน" required>
        <input type="password" name="password" class="form-control" placeholder="รหัสผ่าน" required>
        <button type="submit" class="btn btn-green">เข้าสู่ระบบ</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
