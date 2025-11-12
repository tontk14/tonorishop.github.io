<?php
$hostname = "localhost";
$database = "ec_shop";
$username = "root";
$password = "";

// สร้างการเชื่อมต่อ
$conn = new mysqli($hostname, $username, $password, $database);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("เชื่อมต่อฐานข้อมูลล้มเหลว: " . $conn->connect_error);
}

//echo "เชื่อมต่อฐานข้อมูลสำเร็จ!";
?>