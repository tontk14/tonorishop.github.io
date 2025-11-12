<?php
session_start();
if (!isset($_SESSION['admin_username'])) {
    header("Location: admin_login.php");
    exit;
}
require_once 'conn.php';

$sql = "SELECT username, name, email, phone, address FROM members";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <title>ข้อมูลสมาชิก TONARI SHOP Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<!-- ✅ Navbar -->
<?php include "admin_navbar.php"; ?>

<div class="container mt-4">
  <h2>👥 ข้อมูลสมาชิก</h2>
  <table class="table table-bordered table-striped">
    <thead>
      <tr>
        <th>Username</th>
        <th>ชื่อ-นามสกุล</th>
        <th>Email</th>
        <th>เบอร์โทร</th>
        <th>ที่อยู่</th>
      </tr>
    </thead>
    <tbody>
    <?php if ($result && $result->num_rows > 0): ?>
      <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
          <td><?= htmlspecialchars($row['username']) ?></td>
          <td><?= htmlspecialchars($row['name']) ?></td>
          <td><?= htmlspecialchars($row['email']) ?></td>
          <td><?= htmlspecialchars($row['phone']) ?></td>
          <td><?= htmlspecialchars($row['address']) ?></td>
        </tr>
      <?php endwhile; ?>
    <?php else: ?>
        <tr><td colspan="5" class="text-center">ไม่มีข้อมูลสมาชิก</td></tr>
    <?php endif; ?>
    </tbody>
  </table>
</div>

</body>
</html>
