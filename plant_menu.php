<?php
include("helper.php");

?>
<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<html>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<link href="gaia_css/plantmenu.css" rel="stylesheet" type="text/css"/>
<script src="plant_boxs.js"></script>

<head>
    <meta charset="UTF-8">
    <title>plant menu page</title>
 <?php
    include("header.php");
    ?>
</head>

<body>
   
<form method="post" action="plant_menu.php">
    <div class="plant_menu_sidebar">

        <ul style="list-style: none;">
            <li><button class="side_menu_btn" name="all" value="all">All</a></button></li>
            <li><button class="side_menu_btn" name="category" value="herbs">Herbs</button></li>
            <li><button class="side_menu_btn" name="category" value="shrubs">Shrubs</button></li>
            <li><button class="side_menu_btn" name="category" value="trees">Trees</button></li>
            <li><button class="side_menu_btn" name="category" value="creepers">Creepers</button></li>
            <li><button class="side_menu_btn" name="category" value="climbers">Climbers</button></li>
            <li><button class="side_menu_btn" name="category" value="flowering">Flowering</button></li>

        </ul>
    </div>
   

</form>
 <form method="POST" action="plant_menu.php">
    <input type="text" class="searchBar" name="searchBar" placeholder="Examples: rose, sunflower">
    <button type="submit" class="searchbtn" name="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
    
</form>
    

<form method="post" action="plant_menu.php">
<div id="myModal" class="modal">
  <!-- Modal content -->
  <div class="modal-content">
    <span class="close">&times;</span>
    
    <div class="left">
    <img class="modal-plant-image" alt="Plant Image">
    </div>
    <div class="right">
    <p><span class="modal-plant-name"></span></p>
    <p class="modal-plant-description"></p>

    <p><span class="modal-plant-price"></span></p>
    <div class="counter">
      <span class="down" onClick='decreaseCount(event, this)'>-</span>
      <input type="text" value="1">
      <span class="up"  onClick='increaseCount(event, this)'>+</span>
    </div>
    <script type="text/javascript">
      function increaseCount(a, b) {
        var input = b.previousElementSibling;
        var value = parseInt(input.value, 10); 
        value = isNaN(value)? 0 : value;
        value ++;
        input.value = value;
      }
      function decreaseCount(a, b) {
        var input = b.nextElementSibling;
        var value = parseInt(input.value, 10); 
        if (value > 1) {
          value = isNaN(value)? 0 : value;
          value --;
          input.value = value;
        }
      }
    </script>
    <button class="right_btn">Add to cart</button><button class="left_btn">Buy Now</button> <!--add to cart -->
    </div>
  </div>
</div>
    </form>
<br>







    <?php
include("helper.php");

$sql = "SELECT * FROM plant";
if (isset($_POST['category']) && !empty($_POST['category'])) {
    $category = $_POST['category'];
    $sql .= " WHERE plant_cate = ?";
} 
if (isset($_POST['searchBar']) && !empty($_POST['searchBar'])) {
    $searchBar = $_POST['searchBar'];
    if (strpos($sql, 'WHERE') !== false) {
        $sql .= " AND plant_name LIKE ?";
    } else {
        $sql .= " WHERE plant_name LIKE ?";
    }
}

// Prepare and execute the query
$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die("Prepare failed: " . $conn->error);
}

$bindTypes = '';
$params = [];
if (isset($category)) {
    $bindTypes .= 's';
    $params[] = &$category;
}
if (isset($searchBar)) {
    $search = "%$searchBar%";
    $bindTypes .= 's';
    $params[] = &$search;
}

if (!empty($bindTypes)) {
    $stmt->bind_param($bindTypes, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();

// Fetch the results
if ($result->num_rows > 0) {
    echo "<div class='plant-container'>";
    $count = 0;
    while ($row = $result->fetch_assoc()) {
        if ($count % 4 == 0) {
            echo "<div class='plant-row'>";
        }

        $imageFolder = $row["plant_img"];
        echo "<div class='plant_list'>";
        echo "<div id='plant_box' onclick=\"openModal('" . $row["plant_name"] . "', '" .  $row["plant_price"] . "', '" . $row["plant_img"] . "', '" . $row["plant_desp"] . "')\">";
        echo '<img src="image/'.$row["plant_cate"].'/'.$imageFolder . '" alt="' . $row["plant_name"] . '"> <br><br>';
        echo  '<span class="plant_details">' . $row["plant_name"] . "<br><b>" . "RM" . $row["plant_price"] . "</b></span><br><br>";
        echo "</div>";
        echo "<button type='button' class='btn btn-outline-success'>Add to cart</button>"; //addtocart
        echo "</div>";
        
        $count++;
        if ($count % 4 == 0) {
            echo "</div>";
        }
    }
    if ($count % 4 != 0) {
        echo "</div>";
    }
    echo "</div>";
} else {
    echo "No record found";
}

$stmt->close();
$conn->close();
?>

    <?php
    include('sidebar.php');
    ?>

</body>
<?php
include("footer.php");
?>
<footer>

</footer>

</html>