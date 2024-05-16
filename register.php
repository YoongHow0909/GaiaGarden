<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link href="css/newlogin.css" rel="stylesheet" type="text/css"/>
    <link href="css/loginHeaders.css" rel="stylesheet" type="text/css"/>
    <style>
        .title {
            text-align: center;
            font-size: 18px;
            margin-bottom: 15px;
        }
        .inputbox {
            margin-bottom: 10px;
        }
        .inputbox span {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input[type="text"],
        input[type="email"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }
        .error {
            color: red;
            font-size: 12px;
        }
    </style>

<?php include 'header.php';
   ?>
</head>
<body>
<img src="image/plant.png" alt="plants" width="100%" height="660px">
<div class="bigcontainer" style="border: 5px solid #ccc; position: absolute; z-index: 1; background-image: linear-gradient(to right, green 50%, white 50%); margin-top: -650px; margin-left: 400px; width: 900px; height: 700px; border-radius: 15px;">
    <img src="image/flower_show.png" alt="plants" width="50%" height="700px">
</div>
<div class="r-container">
    <form action="registerValidation.php" method="post">
        <div class="row">
            <div class="col">
                <h2 style="position:relative; margin-top:170px;">Register</h2>
                <br>
                <div class="inputbox">
                    <span style="margin-top:0px;">Username</span>
                    <input type="text" name="name" placeholder="Lim ah lin" style="width: 330px;margin: 0px;">
                    <?php if (isset($_SESSION['nameErr'])) { ?>
                        <span class="error"><?= $_SESSION['nameErr'] ?></span>
                        <?php unset($_SESSION['nameErr']); } ?>
                </div>
                <div class="inputbox">
                    <span>Email</span>
                    <input type="email" name="email" value="" placeholder="example@example.com" style="width: 330px;">
                    <?php if (isset($_SESSION['emailErr'])) { ?>
                        <span class="error" style="width: 330px;"><?= $_SESSION['emailErr'] ?></span>
                        <?php unset($_SESSION['emailErr']); } ?>
                </div>
                <div class="inputbox">
                    <span>Mobile Number</span>
                    <input type="text" name="pnumber" placeholder="0123456789" style="width: 330px;margin: 0px;">
                    <?php if (isset($_SESSION['pnumberErr'])) { ?>
                        <span class="error"><?= $_SESSION['pnumberErr'] ?></span>
                        <?php unset($_SESSION['pnumberErr']); } ?>
                </div>
            </div>
            <div class="inputbox">
                <span>Address</span>
                <input type="text" name="address" placeholder="LIM AH LIN" style="width: 330px; margin: 0px;">
                <?php if (isset($_SESSION['addressErr'])) { ?>
                    <span class="error"><?= $_SESSION['addressErr'] ?></span>
                    <?php unset($_SESSION['addressErr']); } ?>
            </div>
            <div class="inputbox">
                <span>Password</span>
                <input type="password" name="pass" value="" placeholder="********" style="width: 330px;">
                <?php if (isset($_SESSION['passErr'])) { ?>
                    <span class="error"><?= $_SESSION['passErr'] ?></span>
                    <?php unset($_SESSION['passErr']); } ?>
            </div>
            <div class="inputbox">
                <span>Confirm Password</span>
                <input type="password" name="cpass" value="" placeholder="********" style="width: 330px;">
                <?php if (isset($_SESSION['cpassErr'])) { ?>
                    <span class="error"><?= $_SESSION['cpassErr'] ?></span>
                    <?php unset($_SESSION['cpassErr']); } ?>
            </div>
        </div>
        <div class="title">
            <div class="inputbox">
                <input type="submit" name="btn_submit" value="Register" style=" background-color: #4CAF50;  /* Green color for button */
  color: white;
  padding: 10px 20px;
  border: none;
  border-radius: 4px;
  cursor: pointer;">
            </div>
            <div class="inputbox">
              
            </div>
        </div>
    </form>
</div>
</body>
</html>
