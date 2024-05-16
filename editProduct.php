<?php
include 'connDatabase.php'; 

$plant_id = "";
$plant_name = "";
$plant_img = "";
$plant_price = "";
$plant_cate = "";
$plant_avail = "";
$plant_desp = "";

// Check if plant_id is set
if(isset($_GET['plant_id'])) {
    $plant_id = $_GET['plant_id'];

    // Retrieve plant details
    $sql = "SELECT * FROM plant WHERE plant_id = '$plant_id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Fetch plant details
        $row = $result->fetch_assoc();
        $plant_name = $row["plant_name"]; 
        $plant_img = $row["plant_img"]; 
        $plant_price = $row["plant_price"];
        $plant_cate = $row["plant_cate"];
        $plant_avail = $row["plant_avail"];
        $plant_desp = $row["plant_desp"];
    } else {
        echo "Product not found.";
        echo "<br/><a href='adminHome.php'>Back To Admin Home</a>";
        exit; // Exit if plant not found
    }
} else {
    echo "<span style ='background-color:#fff;color:#00000;padding:10px;border-radius:10px;'>Product ID not provided.";                                 
    echo "  <a href='adminHome.php' style='text-decoration:underline;'>Click Here Back To Admin Home</a></span>"; 
    exit; // Exit if plant ID not provided
}
?>

<html>
<head>
    <title>Product Edit</title>
    <link rel="stylesheet" href="gaia_css/Admin.css" />
    <?php include 'navigationAdmin.php'; ?>
  
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

        .inputBox input {
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
                <h1 style="text-align: center;">Edit Product Details</h1>
            </div>
            
            <div class="content">
                <?php
                // Check if form submitted for updating plant details
                if(isset($_POST['submit'])) {
                    // Retrieve updated details
                    $plant_name = isset($_POST['hdName']) ? $_POST['hdName'] : "";
                    $plant_price = isset($_POST['hdPrice']) ? $_POST['hdPrice'] : "";
                    $plant_cate = isset($_POST['hdCategory']) ? $_POST['hdCategory'] : "";
                    $plant_avail = isset($_POST['hdAvailable']) ? $_POST['hdAvailable'] : "";
                    $plant_desp = isset($_POST['hdDescription']) ? $_POST['hdDescription'] : "";
                    
                    // Check if the image file was uploaded
                    if(isset($_FILES["hdImage"]) && $_FILES["hdImage"]["error"] == UPLOAD_ERR_OK) {
                        // Handle file upload
                        $folderName = trim($plant_cate);
                        $target_dir = "gaia_img/" . $folderName . "/";
                        $target_file = $target_dir . basename($_FILES["hdImage"]["name"]);
                        $uploadOk = 1;
                        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

                        // Check if file already exists
                        if (file_exists($target_file)) {
                            echo "Sorry, file already exists.";
                            $uploadOk = 0;
                        }

                        // Check file size
                        if ($_FILES["hdImage"]["size"] > 500000) {
                            echo "Sorry, your file is too large.";
                            $uploadOk = 0;
                        }

                        // Allow certain file formats
                        $allowed_extensions = array("jpg", "jpeg", "png", "gif");
                        if(!in_array($imageFileType, $allowed_extensions)) {
                            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                            $uploadOk = 0;
                        }

                        // Check if $uploadOk is set to 0 by an error
                        if ($uploadOk == 0) {
                            echo "Sorry, your file was not uploaded.";
                        // if everything is ok, try to upload file
                        } else {
                            if (move_uploaded_file($_FILES["hdImage"]["tmp_name"], $target_file)) {
                                echo "The file ". htmlspecialchars( basename( $_FILES["hdImage"]["name"])). " has been uploaded.";
                                $plant_img = $target_file; // Save the file path to database
                            } else {
                                echo "Sorry, there was an error uploading your file.";
                            }
                        }
                    } else {
                        echo "Please select a file to upload.";
                    }
                    
                    // Validation checks
                    $errors = array();

                    // Validate plant name
                    if(empty($plant_name) || strlen($plant_name) > 20) {
                        $errors[] = "Product name must not be empty and should not exceed 20 characters.";
                    }

                    // If there are validation errors, display them
                    if(!empty($errors)) {
                        foreach($errors as $error) {
                            echo "<span style='color: red;'>$error</span><br>";
                        }
                    } else {
                        // Update plant details in the database
                        $update_sql = "UPDATE plant SET plant_name='$plant_name', plant_img='$plant_img', plant_price='$plant_price', plant_cate='$plant_cate', plant_avail='$plant_avail', plant_desp='$plant_desp' WHERE plant_id='$plant_id'";
                        if ($conn->query($update_sql) === TRUE) {
                            echo "<span style='font-size:15px;margin:20px;'><b>Successfully Edited!<b></span>";
                        } else {
                            echo "Error updating product details: " . $conn->error;
                            echo "<a href='adminHome.php'>Back</a>";
                        }
                    }
                }
                ?>
                
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="form-columns">
                        <div class="form-column">
                    <div class="inputBox">
                        <span>Product Name:</span>    
                        <input type="text" name="hdName" value="<?php echo $plant_name?>"/>               
                    </div>

                    <div class="inputBox">
                        <span>Product Price:</span>    
                        <input type="text" name="hdPrice" value="<?php echo $plant_price?>"/>               
                    </div>                
                    
                    <div class="inputBox">
                        <span>Product Image:</span>    
                        <input type="file" name="hdImage"/>               
                    </div>
                        </div>
                        
                    <div class="form-column">
                    <div class="inputBox">
                        <span>Category:</span>                            
                    <br/>
                    <select name="hdCategory" style="border: 2px solid black;width:100px;">
                        <option value="climbers" <?php if($plant_cate == 'climbers') echo 'selected'; ?>>Climbers</option>
                        <option value="creepers" <?php if($plant_cate == 'creepers') echo 'selected'; ?>>Creepers</option>
                        <option value="flowering" <?php if($plant_cate == 'flowering') echo 'selected'; ?>>Flowering</option>
                        <option value="herbs" <?php if($plant_cate == 'herbs') echo 'selected'; ?>>Herbs</option>
                        <option value="shrubs" <?php if($plant_cate == 'shrubs') echo 'selected'; ?>>Shrubs</option>
                        <option value="trees" <?php if($plant_cate == 'trees') echo 'selected'; ?>>Trees</option>
                    </select>               
                    </div>                    
                        
                    <div class="inputBox">
                        <span>Available:</span>    
                        <input type="text" name="hdAvailable" value="<?php echo $plant_avail?>"/>               
                    </div>                    

                    <div class="inputBox">
                        <span>Description:</span>    
                        <input type="text" name="hdDescription" value="<?php echo $plant_desp?>"/>               
                    </div>      
                    </div>
                        
                    </div>
                    <div class="button">
                        <input type="submit" name="submit" value="Edit" class="btn">        
                        <input type="button" name="btnCancel" value="Back" class="btn" onclick="location='adminHome.php'">        
                    </div>
                    
                </form>            
            </div>
        </section>
    </div>
</body>
</html>
