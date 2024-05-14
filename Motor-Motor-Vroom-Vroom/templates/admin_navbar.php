<head>
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<aside>
  <div class="nav-links">

    <a href="admin_home.php" class="nav-links-item" name ="nav-link-start">
    <i class='bx bx-home bx-lg'></i>
      <span>Inventory</span>
    </a>

    <a href="admin_add_item.php" class="nav-links-item">
    <i class='bx bx-cart-add bx-lg'></i>
      <span>Add Item</span>
    </a>

    <a href="admin_category.php" class="nav-links-item">
    <i class='bx bx-category bx-lg' ></i>
      <span>Category</span>
    </a>

    <a href="admin_sales.php" class="nav-links-item">
      <i class='bx bx-bar-chart-alt-2 bx-lg' ></i>
      <span>Sales</span>
    </a>

    <a href="accounts.php" class="nav-links-item">
    <i class='bx bx-user-circle bx-lg'></i>
      <span>Account</span>
    </a>

  </div>
  <div class="logout-nav">
    <a href="api/logout_controller.php" class="nav-links-item">
    <i class='bx bx-log-out bx-lg' ></i>
      <span>Logout</span>
    </a>

  </div>
</aside>

<style>
@import url('https://fonts.googleapis.com/css2?family=Oswald:wght@200..700&display=swap');

*{
  font-family: "Oswald";
  font-size: 14px;
}

.nav-links {
  margin-top: 70px; 
  position: center;
  display: flex;
  justify-content: space-between;
  flex-direction: column;
}
.nav-links .nav-links-item{
  margin-bottom: 20px;
}


.logout-nav {
  margin-top: 55px;
}

</style>