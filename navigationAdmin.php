<?php
session_start();
?>

<html>
<head>
  <title>Product Edit</title>
  <link rel="stylesheet" href="gaia_css/Admin.css" />
</head>
<body>
  <div class="container">
    <nav>
      <div class="navbar">
        <div class="logo">
          <img src="gaia_img/logo.png">
          <h1>Gaia's Garden</h1>
        </div>

        <ul>
          <li><a href="AdminHome.php">
            <i class="fas fa-user"></i>
            <span class="nav-item">Dashboard</span>
          </a></li>

          <li><a href="admin_stats.php">
            <i class="fas fa-user"></i>
            <span class="nav-item">Report</span>
          </a></li>
          
          <li><a href="home.php">
            <i class="fas fa-user"></i>
            <span class="nav-item">Main Home Page</span>
          </a></li>          
          
          <li><a href="CustomerDetails.php">
            <i class="fas fa-chart-bar"></i>
            <span class="nav-item">Customer Details</span>
          </a></li>
          
          <li><a href="ProductDetails.php">
            <i class="fas fa-tasks"></i>
            <span class="nav-item">Product Details</span>
          </a></li>
          
          <?php if ($_SESSION["type"] == "manager") { ?>
            <li><a href="StaffDetails.php">
              <i class="fab fa-dochub"></i>
              <span class="nav-item">Staff Details</span>
            </a></li>
          <?php } ?>
            
          <li><a href="logout.php" class="logout">
            <i class="fas fa-sign-out-alt"></i>
            <span class="nav-item">Logout</span>
          </a></li>
          
        </ul>
      </div>
    </nav>
  </div>
</body>
</html>
