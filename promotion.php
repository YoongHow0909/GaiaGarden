<!DOCTYPE html>
<html>
    <head>
    <?php include('header.php') ?>
    <link href="gaia_css/promotion.css" rel="stylesheet" type="text/css"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <title>Promotion</title>
    </head>
    <body>

    <form method="POST" action="promotion.php">
    <input type="text" class="searchBar" name="searchBar" placeholder="Examples: rose, sunflower">
    <button type="submit" class="searchbtn" name="submit"><i class="fa fa-search" aria-hidden="true"></i></button>  
    </form>
    

<form method="post" action="promotion.php">
<div id="myModal" class="modal">
  <!-- Modal content -->
  <div class="modal-content">
    <span class="close">&times;</span>
    
    <div class="left">
    <img class="modal-voucher-image" alt="Plant Image">
    </div>
    <div class="right">
    <p><span class="modal-voucher-name"></span></p>
    <p class="modal-voucher-description"></p>

    <p><span class="modal-voucher-discount"></span></p>

    <button class="right_btn">Back</button>
    </div>
  </div>
</div>
    </form>









    <?php

include('sidebar.php');
include("helper.php");

$sql = "SELECT * FROM promotion";
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
    echo "<div class='promotion-container'>";
    $count = 0;
    while ($row = $result->fetch_assoc()) {
        if ($count % 4 == 0) {
            echo "<div class='promotion-row'>";
        }

        $imageFolder = $row["voucher_img"];
        echo "<div class='promotion_list'>";
        echo "<div id='voucher_box' onclick=\"openModal('" . $row["voucher_name"] . "', '" .  $row["voucher_cate"] . "', '" . $row["discount"] . "', '" . $row["voucher_desp"] . "')\">";
        echo '<img src="' .$imageFolder . '" alt="' . $row["voucher_name"] . '"> <br><br>';
        echo  '<span class="promotion_details">' . $row["voucher_name"] . "<br><b>" . $row["exp_date"] ."<br>". $row["discount"] ."%"."</b></span><br><br>";
        echo "</div>";
        echo "<button type='button' class='btn btn-outline-success'>view details</button>"; 
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


    </body>
    <footer>
        <?php include('footer.php'); ?>
    </footer>
</html>