<!-- admin_navbar.php -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
  <div class="container-fluid">
    <a class="navbar-brand text-warning fw-bold" href="admin_dashboard.php">TONARI SHOP  Admin</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarNav" aria-controls="navbarNav"
            aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item"><a class="nav-link" href="admin_dashboard.php">หน้าแรก</a></li>
        <li class="nav-item"><a class="nav-link" href="admin_login.php">เข้าสู่ระบบ</a></li>
        <li class="nav-item"><a class="nav-link" href="register_admin.php">สมัครสมาชิก</a></li>
        <li class="nav-item"><a class="nav-link" href="addProduct_form.php">➕ เพิ่มสินค้า</a></li>
        <li class="nav-item"><a class="nav-link" href="order_list.php">📋 ดูข้อมูลการสั่งซื้อ</a></li>
        <li class="nav-item"><a class="nav-link" href="show_members.php">👥 ดูข้อมูลสมาชิก</a></li>
        <?php if (!empty($_SESSION['admin_username'])): ?>
          <li class="nav-item"><a class="nav-link text-danger" href="logout_admin.php">ออกจากระบบ</a></li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>
