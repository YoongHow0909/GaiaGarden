<?php
// Start session
session_start();

// Include necessary files
include("header.php");
include("dblink.php");

// Initialize error messages
$NerrorMessage = isset($_REQUEST['NerrorMessage']) ? $_REQUEST['NerrorMessage'] : null;
$CerrorMessage = isset($_REQUEST['CerrorMessage']) ? $_REQUEST['CerrorMessage'] : null;
$errorMessage = isset($_REQUEST['errorMessage']) ? $_REQUEST['errorMessage'] : null;
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
    <link rel="stylesheet" href="css/newlogin.css">
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
        height: 600px;
        border-radius: 15px;">
        <img src="image/flower_show.png" alt="plants" width="50%" height="600px">
    </div>

    <div class="login-container" id="user-login" style="z-index: 2; width:370px">
        <h2>Reset Password</h2>
        <br>
        <div class="login-options"></div>
        <form action="resetServlet.php" method="post">
            <label for="new">New Password</label>
            <input type="password" id="new" name="new" style="width: 330px; margin: 0px;">
            <?php if ($NerrorMessage != null) { ?>
                <span class="error" style="bottom: 50px; color:red; text-align: center;"><?php echo $NerrorMessage; ?></span>
            <?php } ?>
            <br>
            <label for="cpassword">Confirm Password</label>
            <input type="password" id="cpassword" name="cpassword" style="width: 330px; margin: 0px;">
            <?php if ($CerrorMessage != null) { ?>
                <span class="error" style="bottom: 50px; color:red; text-align: center;"><?php echo $CerrorMessage; ?></span>
            <?php } ?>
            <br>
            <?php if ($errorMessage != null) { ?>
                <span class="error" style="bottom: 50px; color:red; text-align: center;"><?php echo $errorMessage; ?></span>
            <?php } ?>
            <br>
            <button type="submit">Reset</button>
            <br><br>
        </form>
    </div>

    <?php echo $_SESSION['userEmail']; ?>
</body>
<?php include("footer.php"); ?>
</html>
