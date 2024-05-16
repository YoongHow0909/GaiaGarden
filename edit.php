<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Edit Profile</title>
    <link href="css/edit.css" rel="stylesheet" type="text/css"/>
    
    <?php include 'userheader.php'; ?>
    <?php include 'dblink.php'; ?>
</head>
<body>

<?php
// Check if the form has been submitted
$success = isset($_GET['success']) ? $_GET['success'] : null;
$error = isset($_GET['error']) ? $_GET['error'] : null;
$errorMessage = isset($_SESSION['errorMessage']) ? $_SESSION['errorMessage'] : null;

if ($success && $success == 'true') {
    echo "<script type='text/javascript'>
                        alert(Profile updated successfully');
                      </script>";
} elseif ($error && $error == 'true') {
    echo "<p>Error updating profile: " . htmlspecialchars($errorMessage) . "</p>";
}

// Retrieve user information from the database
$conn = null;
$stmt = null;
$rs = null;
$userImageBytes = null; // Declare userImageBytes variable here
try {
    $conn = new mysqli($dbhost, $username, $password, $dbname, $dbport);
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }

    // Prepare the SQL query to select user information
    $query = "SELECT * FROM login WHERE user_id = '$userID'";
    $result = $conn->query($query);

   if($result->num_rows > 0){ 
    while($record = $result->fetch_object()){
        $name = $record->name;
        $email = $record->email;
        $phone = $record->user_phnum;
        $address = $record->user_address;
        $image = $record->user_img;
        // Convert Blob to byte array
       
    }
    } else {
        echo "<p>Error: User data not found.</p>";
    }
} catch (Exception $e) {
    echo "<p>Error retrieving user information: " . htmlspecialchars($e->getMessage()) . "</p>";
} finally {

}
?>

<!-- Sidebar -->
<div id="mySidenav" class="sidenav">
    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
    <img class="img_user" src="image/user.png" alt="User Image">
    <div class="sidebar_name">Users</div>
    <br><br>
    <a href="#">Shop</a>
    <a href="#">Cart</a>
    <a href="#">History</a>
    <a href="#">About Us</a>
</div>

<button class="sidebar_btn" onclick="openNav()">&#9776;</button>

<!-- Edit Profile Form -->
<div class="container" style="height: 650px; margin-top: 50px; margin-bottom: 50px;">
    <h2>Edit Profile</h2>
    <!-- Display user's image -->
    <div class="profile-image">
        <img src="<?php echo $image ?>" alt="User Image" class="user-img">
    </div>

   
    
    <!-- Edit Profile Form -->
    <form action="upload.php" method="post" enctype="multipart/form-data" id="editProfile">
    <p>User ID: <?php echo $userID; ?></p> <!-- Echo out the user ID -->
        <label for="newImage">Choose a new picture:</label><br>
        
        <input type="file" id="newImage" name="newImage" accept="image/*"><br><br>
       
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required><br>
        <?php if (isset($_SESSION['Emailmessage'])) { ?>
            <span class="error" style="bottom: 50px; color: red;"><?php echo htmlspecialchars($_SESSION['Emailmessage']); ?></span>
        <?php } ?>
        <label for="phone">Phone Number:</label><br>
        <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($phone); ?>" required><br>
        <?php if (isset($_SESSION['Phonemessage'])) { ?>
            <span class="error" style="bottom: 50px; color: red;"><?php echo htmlspecialchars($_SESSION['Phonemessage']); ?></span>
        <?php } ?>
        <label for="address">Address:</label><br>
        <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($address); ?>" required><br>
        <input type="submit" value="Save Changes" name="submitEdit">
    </form>
</div>

<footer>
    <?php include 'footer.php'; ?>
</footer>

</body>
</html>
