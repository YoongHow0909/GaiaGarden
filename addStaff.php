<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Staff</title>
    <link rel="stylesheet" href="css/Admin.css" />
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

        .inputBox input, .inputBox select {
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

        .error-message {
            color: red;
            margin-top: 5px;
        }
        
        .userImage {
            width: 200px;
            height: auto;
            max-width: 400px;
            max-height: 200px;      
            border-radius: 10%;
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
        
        .error{
            color: red;
            font-size: 14px;
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
            
            <h1 style="text-align: center;">Add Staff</h1>
            
            <div class="content">
                
                <form action="addStfValidate.php" method="post">
                    <div class="form-columns">
                        <div class="form-column">
                            <div class="inputBox">
                                <span>Username</span><br>
                                <input type="text" name="name" placeholder="Lim12345" >
                                <?php if (isset($_SESSION['nameErr'])) { ?>
                                   <br><span class="error"><?php echo $_SESSION['nameErr']; ?></span>
                                <?php } ?>
                            </div>

                            <div class="inputBox">
                                <span>Email</span><br>
                                <input type="email" name="email" value="" placeholder="example@example.com">
                                <?php if (isset($_SESSION['emailErr'])) { ?>
                                   <br><span class="error"><?php echo $_SESSION['emailErr']; ?></span>
                                <?php } ?>
                            </div>

                            <div class="inputBox">
                                <span>Mobile Number</span><br>
                                <input type="text" name="pnumber" placeholder="0123456789">
                                <?php if (isset($_SESSION['pnumberErr'])) { ?>
                                   <br><span class="error"><?php echo $_SESSION['pnumberErr']; ?></span>
                                <?php } ?>
                            </div>
                            
                            <div class="inputBox">
                                <span>Address</span><br>
                                <input type="text" name="address" placeholder="LIM12345">
                                <?php if (isset($_SESSION['addressErr'])) { ?>
                                   <br><span class="error"><?php echo $_SESSION['addressErr']; ?></span>
                                <?php } ?>
                            </div>                
                        </div>
                        
                        <div class="form-column">
                            <div class="inputBox">
                                <span>Password</span><br>
                                <input type="password" name="pass" placeholder="">
                                <?php if (isset($_SESSION['passErr'])) { ?>
                                   <br><span class="error"><?php echo $_SESSION['passErr']; ?></span>
                                <?php } ?>
                            </div>

                            <div class="inputBox">
                                <span>Confirm Password</span><br>
                                <input type="password" name="cpass" placeholder="">
                                <?php if (isset($_SESSION['cpassErr'])) { ?>
                                   <br><span class="error"><?php echo $_SESSION['cpassErr']; ?></span>
                                <?php } ?>
                            </div>
                            
                            <div class="inputBox">
                                <span>Select Role</span><br>
                                <select name="role">
                                    <option value="staff">Staff</option>
                                    <option value="manager">Manager</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="button">
                        <input type="submit" name="submit" value="Add" class="btn">
                        <input type="button" name="btnCancel" value="Back" class="btn" onclick="location.href='AdminHome.php'">
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>


</body>
</html>
