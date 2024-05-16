

<link href="gaia_css/sidebar.css" rel="stylesheet" type="text/css"/>
<script>
    function openNav() {
      document.getElementById("mySidenav").style.width = "250px";
    }
    function closeNav() {
      document.getElementById("mySidenav").style.width = "0";
    }
</script>
<!-- sidebar-->
<div id="mySidenav" class="sidenav">
    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>&nbsp;
    <div class="user_tag">
        <img class="img_user" src="gaia_img/user_profile.png"><p class="sidebar_name">
          <?php 
          if($username != null){
          echo $username;
          }
          else{
            echo "User";
          }
          ?>
          </p>
    </div>
    <br/><br/>
    <a href="plant_menu.php">Shop</a>
    <a href="gaia-cart.php">Cart</a>
    <a href="gaia-payment_history.php">History</a>
    <a href="aboutUs.php">About us</a>
</div>
<button class="sidebar_btn" onclick="openNav()">&#9776</button>
<!-- sidebar-->