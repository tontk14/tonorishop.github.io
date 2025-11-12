<?php
include "conn.php";

$username = $_POST['username'];
$password = $_POST['password'];
$name     = $_POST['name'];
$email    = $_POST['email'];
$phone    = $_POST['phone'];
$address  = $_POST['address'];

// ตรวจสอบ username ซ้ำ
$check_stmt = $conn->prepare("SELECT id FROM members WHERE username = ?");
$check_stmt->bind_param("s", $username);
$check_stmt->execute();
$check_stmt->store_result();

if ($check_stmt->num_rows > 0) {
    echo "<h2 style='color:red;'>ชื่อผู้ใช้ '$username' มีอยู่ในระบบแล้ว กรุณาเลือกชื่ออื่น</h2>";
    echo "<a href='register_form.php'>← กลับไปหน้าฟอร์ม</a>";
    $check_stmt->close();
    $conn->close();
    exit;
}
$check_stmt->close();

// เพิ่มข้อมูลใหม่
$stmt = $conn->prepare(
    "INSERT INTO members (username, password, name, email, phone, address)
     VALUES (?, ?, ?, ?, ?, ?)"
);
$stmt->bind_param("ssssss", $username, $password, $name, $email, $phone, $address);

if ($stmt->execute()) {
    // ✅ แสดงข้อความสำเร็จ + ปุ่มไปหน้า login_form.php
    echo "<h2 style='color:green;'>สมัครสมาชิกสำเร็จ!</h2>";
    echo "<a href='register_form.php' style='margin-right:15px;'>← สมัครสมาชิกเพิ่ม</a>";
    echo "<a href='login_form.php' 
             style='display:inline-block;
                    padding:10px 18px;
                    background:#4CAF50;
                    color:white;
                    text-decoration:none;
                    border-radius:5px;'>เข้าสู่ระบบ</a>";
} else {
    echo "เกิดข้อผิดพลาด: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
