<?php
session_start();
if (!isset($_SESSION['admin_username'])) {
    header("Location: admin_login.php");
    exit;
}

require_once 'conn.php';

// query ข้อมูลสินค้า
$sql = "SELECT productID, product_name, price, details, image FROM product";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>รายการสินค้า | EC Shop Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f8f9fa;
            font-family: "Sarabun", sans-serif;
        }
        table {
            border-collapse: collapse;
            width: 95%;
            margin: 20px auto;
            background: #fff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        th, td {
            padding: 12px;
            text-align: center;
        }
        th {
            background: #f5f5f5;
        }
        tr:nth-child(even) {
            background: #fafafa;
        }
        img {
            width: 100px;
            height: auto;
            border-radius: 6px;
        }
        .btn {
            padding: 6px 12px;
            border: none;
            background: #007bff;
            color: #fff;
            border-radius: 6px;
            cursor: pointer;
            text-decoration: none;
        }
        .btn:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>

<!-- ✅ Navbar -->
<?php include "admin_navbar.php"; ?>

<h2 style="text-align:center; margin-top:20px;">📦 รายการสินค้า</h2>
<table border="1">
    <tr>
        <th>รหัสสินค้า</th>
        <th>รูปสินค้า</th>
        <th>ชื่อสินค้า</th>
        <th>ราคา</th>
        <th>รายละเอียด</th>
        <th>ดูสินค้า</th>
    </tr>
    <?php
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['productID']) . "</td>";

            // แสดงรูปสินค้า ถ้าไม่มีรูปให้แสดงข้อความ
            if (!empty($row['image']) && file_exists("Product_image/" . $row['image'])) {
                echo "<td><img src='Product_image/" . htmlspecialchars($row['image']) . "' alt='รูปสินค้า'></td>";
            } else {
                echo "<td><span style='color:gray;'>ไม่มีรูป</span></td>";
            }

            echo "<td>" . htmlspecialchars($row['product_name']) . "</td>";
            echo "<td>" . number_format($row['price'], 2) . " บาท</td>";
            echo "<td>" . htmlspecialchars($row['details']) . "</td>";
            echo "<td><a class='btn' href='show_product.php?productID=" . urlencode($row['productID']) . "'>ดูสินค้า</a></td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='6'>ไม่มีข้อมูลสินค้า</td></tr>";
    }
    ?>
</table>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
