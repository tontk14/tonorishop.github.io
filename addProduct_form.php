<?php
session_start();
if (!isset($_SESSION['admin_username'])) {
    header("Location: admin_login.php");
    exit;
}

// ฟังก์ชันสร้างรหัสสินค้าแบบสุ่ม เช่น PD123456
function generateProductID() {
    $prefix = "PD";
    $randomNumber = mt_rand(100000, 999999);
    return $prefix . $randomNumber;
}

$randomProductID = generateProductID();
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เพิ่มข้อมูลสินค้า | EC Shop Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #fdfcf8;
            font-family: 'Prompt', sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 700px;
            margin: 50px auto;
            background-color: #ffffff;
            padding: 30px 40px;
            border-radius: 15px;
            box-shadow: 0 0 12px rgba(0, 0, 0, 0.08);
        }

        h2 {
            text-align: center;
            color: #444;
            margin-bottom: 30px;
        }

        label {
            font-weight: bold;
            display: block;
            margin-bottom: 8px;
            color: #333;
        }

        input[type="text"],
        input[type="number"],
        textarea,
        input[type="file"] {
            width: 100%;
            padding: 10px 12px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            font-size: 1rem;
            box-sizing: border-box;
        }

        input[readonly] {
            background-color: #f5f5f5;
        }

        textarea {
            resize: vertical;
            min-height: 100px;
        }

        input[type="submit"] {
            width: 100%;
            padding: 12px;
            background-color: #eee8dc;
            border: none;
            border-radius: 10px;
            font-weight: bold;
            font-size: 1rem;
            color: #333;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #ddd4c6;
        }

        @media (max-width: 768px) {
            .container {
                margin: 20px;
                padding: 20px;
            }
        }
    </style>
</head>
<body>

<!-- ✅ เรียก Navbar ของแอดมิน -->
<?php include "admin_navbar.php"; ?>

<div class="container">
    <h2>➕ เพิ่มข้อมูลสินค้า</h2>
    <form action="add_Product.php" method="post" enctype="multipart/form-data">
        <label for="productID">รหัสสินค้า (Product ID):</label>
        <input type="text" id="productID" name="productID" value="<?php echo $randomProductID; ?>" readonly>

        <label for="product_name">ชื่อสินค้า:</label>
        <input type="text" id="product_name" name="product_name" required>

        <label for="price">ราคาสินค้า:</label>
        <input type="number" id="price" name="price" step="0.01" required>

        <label for="details">รายละเอียดสินค้า:</label>
        <textarea id="details" name="details" required></textarea>

        <label for="image">รูปภาพสินค้า:</label>
        <input type="file" id="image" name="image" accept="image/*" required>

        <input type="submit" value="บันทึกสินค้า">
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
