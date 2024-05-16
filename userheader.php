<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link href="gaia_css/header.css" rel="stylesheet" type="text/css"/>
        <?php session_start(); ?>
        <style>
            /* Style for the slide bar */
            .slide-bar {
                display: none;
                position: absolute;
                background-color: #ffffff;
                min-width: 120px;
                box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
                padding: 12px 16px;
                z-index: 1;
                border-radius: 4px;
                border: 1px solid #ccc;
                margin-left: 600px; 
                animation: slideIn 0.5s ease-in-out;
            }

            /* Animation for slide in effect */
            @keyframes slideIn {
                from {
                    margin-left: 600px;
                    opacity: 0;
                }
                to {
                    margin-left: 530px;
                    opacity: 1;
                }
            }

            /* Style for the options in the slide bar */
            .slide-bar a {
                padding: 8px 0;
                display: block;
                color: black;
                text-decoration: none;
                font-size: 14px;
                transition: color 0.3s ease-in-out;
            }

            /* Style for the options in the slide bar on hover */
            .slide-bar a:hover {
                color: #007bff;
            }
        </style>
    </head>
    <header>
        <?php
        // Check if a session variable named "username" is set
        if (isset($_SESSION['username'])) {
            $username = $_SESSION['username'];
            $userID = $_SESSION['user_id'];
            $userType = $_SESSION['type'];
        ?>
        <div class="head_design">
            <img class="logo" src="gaia_img/logo.png" onclick="window.location.href='index.php';">  
            <p class ="title">Gaia's <br>Garden</p>
            <div class="btn_row">
                <?php if(isset($userType) && ($userType == "staff" || $userType == "manager")) { ?>
                    <button class="head_btn" onclick="location.href='AdminHome.php'"><span>Admin Home</span></button>
                <?php } ?>                
                <button class="head_btn" onclick="window.location.href='index.php';">Home<span>&raquo;</span></button>
                <button class="head_btn" onclick="window.location.href='aboutUs.php';">About us<span>&raquo;</span></button>
                <button class="head_btn" onclick="window.location.href='plant_menu.php';">Shop<span>&raquo;</span></button>
                <button class="head_btn" onclick="window.location.href='contactUs.php';">Contact us<span>&raquo;</span></button>
                <div class="slide-bar" id="slideBar">
                    <a href="edit.php">Edit Profile</a>
                    <a href="inResetPassword.php">Change Password</a>
                    <a href="logout.php">Log Out</a>
                </div>
                <button class="Sign_in" id="editProfileButton">
                    <?php echo $username; ?>
                </button>
            </div>
        </div>
        <?php } else { ?>
        <div class="head_design">
            <img class="logo" src="gaia_img/logo.png" onclick="window.location.href='aboutUs.php';">  
            <p class ="title">Gaia's <br>Garden</p> 
            <div class="btn_row">
                <button class="head_btn" onclick="window.location.href='index.php';">Home<span>&raquo;</span></button>
                <button class="head_btn" onclick="window.location.href='aboutUs.php';">About us<span>&raquo;</span></button>
                <button class="head_btn" onclick="window.location.href='plant_menu.php';">Shop<span>&raquo;</span></button>
                <button class="head_btn" onclick="window.location.href='contactUs.php';">Contact us<span>&raquo;</span></button>
                <button class="Sign_in" onclick="window.location.href='login.php';">Get Started</button>
            </div>
        </div>
        <?php } ?>
    </header>
    <script>
        document.getElementById("editProfileButton").addEventListener("click", function() {
            var slideBar = document.getElementById("slideBar");
            if (slideBar.style.display === "none" || slideBar.style.display === "") {
                slideBar.style.display = "block";
            } else {
                slideBar.style.display = "none";
            }
        });
    </script>
    <body>
    </body>
</html>
