

<link href="gaia_css/sidebar.css" rel="stylesheet" type="text/css"/>
<!-- sidebar-->
<div id="mySidenav" class="sidenav">
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
  &nbsp<img class="img_user" src="image/user.png"><div class="sidebar_name">Users</div>
  <br>
  <br>
  <a href="plant_menu.php">Shop</a>
  <a href="#"> Cart</a>
  <a href="#">History</a>
  <a href="promotion.php">Promotion</a>
  <a href="aboutUs.php">About us</a>
</div>

<button class="sidebar_btn" onclick="openNav()">&#9776</button>

<script>
function openNav() {
  document.getElementById("mySidenav").style.width = "250px";S
}

function closeNav() {
  document.getElementById("mySidenav").style.width = "0";

}
</script>
<!-- sidebar-->
