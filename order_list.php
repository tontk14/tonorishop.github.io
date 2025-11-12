<?php
session_start();
if (!isset($_SESSION['admin_username'])) {
    header("Location: admin_login.php");
    exit;
}
require_once 'conn.php';

$sql = "SELECT * FROM orders ORDER BY order_date DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <title>รายการสั่งซื้อ | EC Shop Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<!-- ✅ Navbar -->
<?php include "admin_navbar.php"; ?>

<div class="container mt-4">
  <h2>📋 รายการสั่งซื้อ</h2>
  <table class="table table-bordered table-striped">
    <thead>
      <tr>
        <th>Order ID</th>
        <th>ชื่อลูกค้า</th>
        <th>วันที่สั่งซื้อ</th>
        <th>วิธีชำระเงิน</th>
        <th>ราคารวม</th>
      </tr>
    </thead>
    <tbody>
      <?php if ($result && $result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
          <tr>
            <td>
              <a href="viewOrder.php?order_id=<?= urlencode($row['order_id']) ?>">
                <?= htmlspecialchars($row['order_id']) ?>
              </a>
            </td>
            <td><?= htmlspecialchars($row['username']) ?></td>
            <td><?= htmlspecialchars($row['order_date']) ?></td>
            <td><?= htmlspecialchars($row['payment_method']) ?></td>
            <td><?= number_format($row['total_price'], 2) ?> บาท</td>
          </tr>
        <?php endwhile; ?>
      <?php else: ?>
          <tr><td colspan="5" class="text-center">ไม่มีคำสั่งซื้อ</td></tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>

</body>
</html>
