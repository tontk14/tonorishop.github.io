<?php
session_start();

// ลบ session ของแอดมินออก
unset($_SESSION['admin_username']);

// ทำลาย session ทั้งหมด (ถ้าอยากล้างหมด)
session_destroy();

// กลับไปหน้า login ของแอดมิน
header("Location: admin_login.php");
exit;
