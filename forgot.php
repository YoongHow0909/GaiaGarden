<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Forgot Password</title>
    <?php include("header.php"); ?>
    <?php include("dblink.php"); ?>
    <link rel="stylesheet" href="css/newlogin.css">
    <style>
        /* Add your custom styles here */
        .error {
            color: red;
            font-size: 12px;
            margin-top: -10px;
        }
    </style>
</head>
<body>
    <img src="image/plant.png" alt="plants" width="100%" height="660px">
    <div class="bigcontainer" style="
      border: 5px solid #ccc;
      position: absolute;
      z-index: 1;
      background-image: linear-gradient(to right, green 50%, white 50%);
      margin-top: -650px;
      margin-left: 400px;
      width: 900px;
      height: 610px;
      border-radius: 15px;">
      <!-- Your content here -->
      <img src="image/flower_show.png" alt="plants" width="50%" height="610px">
    </div>    
    <div class="login-container" id="user-login" style="z-index:2;">
        <h2>Forgot Password</h2>
        <br>
        <div class="login-options">
        </div>
        <form action="ForgotPassword.php" method="post" onsubmit="sendEmail(); return false;">
            <div class="inputbox">
                <span>Email</span>
                <input type="text" id="email" name="email" placeholder="example@example.com">
                <?php // Include error message handling for email here ?>
                <span class="error">
                    <?php 
                    $errorMessage = isset($_REQUEST['errorMessage']) ? $_REQUEST['errorMessage'] : null;
                    if ($errorMessage !== null) { 
                        echo '<span class="error">' . $errorMessage . '</span>';
                    } ?>
                </span>
            </div>
            <button type="submit">Update</button>
            <br>
            <br>
            <a href="login.php" style="margin-left: -1px;">Back</a> 
        </form>
    </div>
    <?php include("footer.php"); ?>
</body>
</html>
