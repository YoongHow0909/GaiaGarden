<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Login</title>
  <?php require_once "dblink.php"; ?>
  <link rel="stylesheet" href="css/newlogin.css">
</head>
<?php include "startheader.php"; ?>
<body>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Step 2: Connect PHP app with database
  mysqli_connect($dbhost, $username, $password, $dbname, $dbport);


  // Step 3: Check connection
  

  // Function to sanitize user input (prevent SQL injection)
  function sanitizeInput($data, $conn) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $conn->real_escape_string($data);
  }

  // Handle login form submission (if submitted)
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once "dblink.php";
    $name = sanitizeInput($_POST["name"], $conn);
    $password = sanitizeInput($_POST["password"], $conn);

    // **Warning: Not hashing passwords is a security risk!**
    // $hashedPassword = password_hash($password, PASSWORD_DEFAULT);  // Hash for comparison (if you decide to hash)

    $sql = "SELECT * FROM login WHERE name = '$name' AND pass = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
      // Login successful
      session_start();  // Start session for storing user data (optional)

      $row = $result->fetch_assoc();  // Get user data
      $_SESSION["user_id"] = $row["user_id"];
      if ($row["type"] == "staff" || $row["type"] == "manager") {
        $_SESSION["username"] = $name;  
        $_SESSION["user_id"] = $row["user_id"];
        $_SESSION["type"] = $row["type"];
        // Assuming you want to store the username
        header("Location: AdminHome.php");  // Redirect to manager.php for Staff/Manager
      } else {
        $_SESSION["username"] = $name;  // Assuming you want to store the username
         $_SESSION["type"] = $row["type"];
        header("Location:user.php");  // Redirect to home.php for other types
      }
    } else {
      // Login failed
      $loginError = "Invalid username or password.";
      echo "<script type='text/javascript'>
                        alert('$loginError');
                        window.location.href = 'index.php'; // Redirect to the login page after the alert
                      </script>";

    }
  }

  $conn->close();
}
?>

  <img src="image/plant.png" alt="plants" width="100%" height="660px">
  <div class="bigcontainer" style="
  border: 5px solid #ccc;
  position: absolute;
  z-index: 1;
  background-image: linear-gradient(to right, green 50%, white 50%);
  margin-top: -650px;
  margin-left: 400px;
  width: 900px;
  height: 600px;
  border-radius: 15px;">
  <!-- Your content here -->
  <img src="image/flower_show.png" alt="plants" width="50%" height="600px" ">

</div>
  <div class="login-container" id="user-login" style=" z-index: 2">
    <h2>Login</h2>
    <br>
    <div class="login-options">
        </div>
    <form action="" method="post">
        <label for="username">Username:</label>
        <input type="text" id="username" name="name" required autocomplete="off">
        <br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required  autocomplete="off">
        <br>
        <button type="submit">Login</button>
        <br>
        <br>
        <a href="register.php" style="margin-left: -1px;">Register</a> | <a href="forgot.php">Forgot Password?</a>
    </form>
</div>

  




</body>
<?php include 'footer.php'; ?>
</html>

