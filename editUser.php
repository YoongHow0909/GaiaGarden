<?php
include 'connDatabase.php'; 

$user_id = "";              
$name = "";
$email = "";
$user_phnum = "";
$pass = "";
$user_address = "";
$type = "";
$user_img = "";

// Check if user_id is set
if(isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];

    // Retrieve user details
    $sql = "SELECT * FROM login WHERE user_id = '$user_id'"; // Enclose $user_id in single quotes
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Fetch user details
        $row = $result->fetch_assoc();
        $name = $row["name"]; // Correct column name
        $email = $row["email"]; // Correct column name
        $type = $row["type"];
        $user_phnum = $row["user_phnum"];
        $user_address = $row["user_address"];
        $pass = $row["pass"];
        $user_img = $row["user_img"];
    } else {
        echo "User not found.";
        echo "<br/><a href='adminHome.php'>Back To Admin Home</a>";                  
        exit; // Exit if user not found
    }
} else {
    echo "<span style ='background-color:#fff;color:#00000;padding:10px;border-radius:10px;'>User ID not provided.";                                 
    echo "  <a href='adminHome.php' style='text-decoration:underline;'>Click Here Back To Admin Home</a></span>"; 
    exit; // Exit if user ID not provided
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User Details</title>
    <link rel="stylesheet" href="gaia_css/Admin.css" />
    <?php include 'navigationAdmin.php'; ?>               
    <style>
        .content {
            background-color: #fff;
            width: 800px;
            border-radius: 10px;
            font-size: 17px;
            padding:20px;
            margin: 0 auto;
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
                <h1 style="text-align:center;">Edit User Details</h1>
                <div class="content">
                    <?php
                    // Check if form submitted for updating user details
                    if(isset($_POST['submit'])) {
                        // Retrieve updated details
                        $name = $_POST['hdName'];
                        $email = $_POST['hdEmail'];
                        $type = $_POST['hdType'];
                        $user_phnum = $_POST['hdPhone'];
                        $user_address = $_POST['hdAddress'];
                        $pass = $_POST['hdPassword'];
                        
                        // Handle file upload
                        if(isset($_FILES["hdImg"]["tmp_name"]) && !empty($_FILES["hdImg"]["tmp_name"])) {
                            $target_dir = "gaia_img/"; // Specify the directory where the file will be stored
                            $target_file = $target_dir . basename($_FILES["hdImg"]["name"]); // Get the name of the file
                            $uploadOk = 1; // Flag to check if upload is successful
                            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION)); // Get the file extension

                            // Check if image file is a actual image or fake image
                            $check = getimagesize($_FILES["hdImg"]["tmp_name"]);
                            if($check !== false) {
                                $uploadOk = 1;
                            } else {
                                echo "File is not an image.";
                                $uploadOk = 0;
                            }

                            // Check file size
                            if ($_FILES["hdImg"]["size"] > 500000) {
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
                                if (move_uploaded_file($_FILES["hdImg"]["tmp_name"], $target_file)) {
                                    echo "successfully updated image";
                                } else {
                                    echo "Sorry, there was an error uploading your file.";
                                }
                            }
                        }
                        
                        // Validation checks
                        $errors = array();

                        // Validate user name
                        if(empty($name) || strlen($name) > 20) {
                            $errors[] = "User name must not be empty and should not exceed 20 characters.";
                        }

                        // Validate email
                        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                            $errors[] = "Invalid email format.";
                        }

                        // If there are validation errors, display them
                        if(!empty($errors)) {
                            foreach($errors as $error) {
                                echo "<span style='color: red;'>$error</span><br>";
                            }
                        } else {
                            // Update user details in the database
                            $update_sql = "UPDATE login SET name='$name', email='$email', type='$type', user_phnum='$user_phnum', user_address='$user_address', pass='$pass', user_img='$user_img' WHERE user_id='$user_id'";
                            echo "<span style='font-size:15px;margin:20px;'><b>Successfully Edited!<b></span>";
                            if ($conn->query($update_sql) === TRUE) {
                            } else {
                                echo "Error updating user details: " . $conn->error;
                                echo "<a href='adminHome.php'>Back</a>";
                            }
                        }
                    }
                    ?>

                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="form-columns">
                               <div class="form-column">
                        <div class="inputBox">
                            <span>Full Name:</span>    
                            <input type="text" name="hdName" value="<?php echo $name?>"/>               
                        </div>

                        <div class="inputBox">
                            <span>Email Address:</span>    
                            <input type="text" name="hdEmail" value="<?php echo $email?>"/>               
                        </div>

                        <div class="inputBox">
                            <span>Password:</span>    
                            <input type="text" name="hdPassword" value="<?php echo $pass?>"/>               
                        </div>                
                                
                        <div class="inputBox">
                            <span>User Type:</span>
                            </br>
                            <select name="hdType" style="border: 2px solid black;width:100px;">
                                <option value="staff" <?php if($type == 'staff') echo 'selected'; ?>>Staff</option>
                                <option value="user" <?php if($type == 'user') echo 'selected'; ?>>User</option>           
                            </select>
                        </div>
                               </div>
                            
                            <div class="form-column">
                        <div class="inputBox">
                            <span>Profile Picture:</span>    
                            <input type="file" name="hdImg"/>               
                        </div>                 
                            
                        <div class="inputBox">
                            <span>Phone Number:</span>    
                            <input type="text" name="hdPhone" value="<?php echo $user_phnum?>"/>               
                        </div>                    
                            
                        <div class="inputBox">
                            <span>Address:</span>    
                            <input type="text" name="hdAddress" value="<?php echo $user_address?>"/>               
                        </div>                    
                            </div>
                                </div>
                        <div class="button">
                            <input type="submit" name="submit" value="Edit" class="btn">        
                            <input type="button" name="btnCancel" value="Back" class="btn" onclick="location='adminHome.php'">        
                        </div> 
                           
                    </form>
                </div>
            </div>
        </section>
    </div>
</body>
</html>
