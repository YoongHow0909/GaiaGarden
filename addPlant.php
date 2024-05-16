<!DOCTYPE html>
<?php 
include('helper.php');
?>

<html>
<head>
    <meta charset="UTF-8">
    <title>Add Plant</title>
    <link rel="stylesheet" href="gaia_css/Admin.css" />

    <?php  
    include 'navigationAdmin.php';
  

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

    <style>
        .content {
            background-color: #fff;
            width: 800px;
            border-radius: 10px;
            font-size: 17px;
            padding:20px;
            margin:0 auto;
        }

        .inputBox {
            margin: 15px 0;
        }

        .inputBox input ,.inputBox select,textarea {
            border: 2px solid black;
            border-radius: 5px;
            padding: 8px; 
            width: 100%; 
            box-sizing: border-box;
        }

        .inputBox span {
            margin-bottom: 5px;
        }
        
        .button{
            margin-top:10px;
            margin-left: 10px;
        }
        
        .form-columns {
            display: flex;
            justify-content: space-between;
        }

        .form-column {
            width: calc(50% - 10px); /* Adjusted width for two columns */
        }

        /* Adjusted style for input and select */
        .form-column .inputBox input,
        .form-column .inputBox select {
            width: calc(100% - 16px);
        }          
        
    </style> 

</head>
<body>
    <div class="container">
        <section class="main">
            <div class="main-top">
              <p>Admin Control Page</p>
            </div>
            <div class="main-body">
                    <h1 style="text-align: center;">Add Plant</h1>  
            </div>
            
            <div class="content">
                <div class="form-columns">
                    <div class="form-column">
                <form action="addPlant.php" method="POST" enctype="multipart/form-data">
                    <div class="inputBox">                    
                    <label for="plant_id">Plant ID: </label>
                    <input type="text" name="plant_id" required>
                    </div>
                    
                    <div class="inputBox">                    
                    <label for="plant_name">Plant Name: </label>
                    <input type="text" name="plant_name" required>
                    </div>
                    
                    
                    <div class="inputBox">
                    <label for="plant_img">Plant image: </label>
                    <input type="file" name="plant_img" id="plant_img" required>
                    </div>
                    
                    <div class="inputBox">                    
                    <label for="plant_price">Plant price:</label>
                    <input type="number" name="plant_price" required>
                    </div>
                    </div>
                    
                    <div class="form-column"> 
                    <div class="inputBox">                        
                    <label for="plant_cate">Plant category:</label>
                    <select name="plant_cate" required>
                        <option value="">Please select a option</option>
                        <option value="climbers">climbers</option>
                        <option value="creepers">creepers</option>
                        <option value="flowering">flowering</option>
                        <option value="herbs">herbs</option>
                        <option value="shrubs">shrubs</option>
                        <option value="trees">trees</option>
                    </select>
                    </div>
                        
                    <div class="inputBox">                    
                    <label for="plant_avail">Plant available:</label>
                    <input type="number" name="plant_avail" required>
                    </div>
                        
                        
                    <div class="inputBox">                    
                    <label for="plant_desp">Plant description:</label>
                    <textarea name="plant_desp"></textarea>
                    </div>
                    </div>
                    </div> 
                    <input type="submit" name="submit" class="btn">
                    <input type="button" name="btnCancel" class="btn" value="Back" onclick="location='adminHome.php'">

                </form>                
                
            </div>
  
                        
            
        </section>
        
    </div>
    
    





</body>

    </html>