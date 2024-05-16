<!DOCTYPE html>
<?php 
include('helper.php');
?>

<html>
<head>
    <meta charset="UTF-8">
    <title>Add Plant</title>
    <?php  
    include('header.php');  
  

    if(isset($_POST["submit"])){
          
    $plant_id = trim($_POST["plant_id"]);
    $plant_name = trim($_POST["plant_name"]);
    $plant_price = trim($_POST["plant_price"]);
    $plant_cate = trim($_POST["plant_cate"]);
    $plant_avail = trim($_POST["plant_avail"]);
    $plant_desp = trim($_POST["plant_desp"]);
    $target_dir = "image/$plant_cate/";
    $plant_img = basename($_FILES["plant_img"]["name"]);
    $target_file = $target_dir . $plant_img;
    
        if (move_uploaded_file($_FILES["plant_img"]["tmp_name"], $target_file)) {
            // Insert data into the database
            $sql = "INSERT INTO plant (plant_id, plant_name, plant_img, plant_price, plant_cate, plant_avail, plant_desp ) 
        VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([
                $plant_id,
                $plant_name,
                $plant_img,
                $plant_price,
                $plant_cate,
                $plant_avail,
                $plant_desp
            ]);
?>

<script>
alert('the plant add successfully');

</script>

  <?php          
        } else {
            echo "Sorry, there was an error uploading your file.";
        }

    }

    ?>
</head>
<body>
    <h1>Add plant php</h1><br>
<form action="addPlant.php" method="POST" enctype="multipart/form-data">
<label for="plant_id">Plant ID: </label>
<input type="text" name="plant_id" required><br><br>

<label for="plant_name">Plant Name: </label>
<input type="text" name="plant_name" required><br><br>

<label for="plant_img">Plant image: </label>
<input type="file" name="plant_img" id="plant_img" required><br><br>

<label for="plant_price">Plant price:</label>
<input type="number" name="plant_price" required><br><br>

<label for="plant_cate">Plant category:</label>
<select name="plant_cate" required>
    <option value="">Please select a option</option>
    <option value="climbers">climbers</option>
    <option value="creepers">creepers</option>
    <option value="flowering">flowering</option>
    <option value="herbs">herbs</option>
    <option value="shrubs">shrubs</option>
    <option value="trees">trees</option>
</select><br><br>
<label for="plant_avail">Plant available:</label>
<input type="number" name="plant_avail" required><br><br>
<label for="plant_desp">Plant description:</label>
<textarea name="plant_desp"></textarea><br><br>
<input type="submit" name="submit">
</form>




</body>
<footer>
<?php
include('footer.php');
?>
</footer>
    </html>