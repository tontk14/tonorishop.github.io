<?php
require_once 'conn.php'; // เชื่อมต่อฐานข้อมูล

// รับค่าจากฟอร์ม
$productID = $_POST['productID'];
$product_name = $_POST['product_name'];
$price = $_POST['price'];
$details = $_POST['details'];

// รับไฟล์รูปภาพ
$image_name = $_FILES['image']['name'];
$image_tmp = $_FILES['image']['tmp_name'];

// สร้างโฟลเดอร์ Product_image หากยังไม่มี
$upload_dir = 'Product_image/';
if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0777, true);
}

// กำหนดพาธปลายทาง
$target_path = $upload_dir . basename($image_name);

// ย้ายไฟล์รูปภาพไปยังโฟลเดอร์ Product_image
if (move_uploaded_file($image_tmp, $target_path)) {

    // เพิ่มข้อมูลสินค้าเข้าในฐานข้อมูล
    $sql = "INSERT INTO product (productID, product_name, price, details, image)
            VALUES (?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssdss", $productID, $product_name, $price, $details, $image_name);

    if ($stmt->execute()) {
        echo "✅ เพิ่มสินค้าสำเร็จ!";
    } else {
        echo "❌ เกิดข้อผิดพลาดในการเพิ่มสินค้า: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "❌ การอัปโหลดรูปภาพล้มเหลว กรุณาลองใหม่.";
}

$conn->close();
?>
