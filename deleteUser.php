<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete User Details</title>
    <link rel="stylesheet" href="gaia_css/Admin.css" />
    <?php include 'navigationAdmin.php'; ?>
    <style>
        .content {
            background-color: #fff;
            width: 600px;
            border-radius: 10px;
            font-size: 17px;
            padding:20px;
            margin-left:20px
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

        .button {
            margin-top:10px;
            margin-left: 10px;
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
                <h1>Delete User Details</h1>
                <?php
                //connect to database
                @include 'connDatabase.php';

                // Check if user ID is provided
                if (isset($_GET['user_id'])) {
                    $user_id = $_GET['user_id'];

                    // Prepare and bind the query
                    $stmt = $conn->prepare("SELECT name, email, type, user_phnum, user_address FROM login WHERE user_id = ?");
                    $stmt->bind_param("s", $user_id);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        // Fetch user details
                        $row = $result->fetch_assoc();
                        $name = $row["name"];
                        $email = $row["email"];
                        $type = $row["type"];
                        $user_phnum = $row["user_phnum"];
                        $user_address = $row["user_address"];
                    } else {
                        echo "<span style='background-color:#fff;color:#00000;padding:10px;border-radius:10px;'>User not found.";
                        echo "<a href='AdminHome.php' style='text-decoration:underline;'>Back To Admin Home</a></span>";
                        exit; // Exit if user not found
                    }
                    $stmt->close();
                } else {
                    echo "<span style='background-color:#fff;color:#00000;padding:10px;border-radius:10px;'>User ID not provided.";
                    echo "<a href='AdminHome.php' style='text-decoration:underline;'>Back To Admin Home</a></span>";
                    exit; // Exit if user ID not provided
                }

                // Check if form submitted for deleting user
                if (isset($_POST['submit'])) {
                    // Prepare and bind the delete statement
                    $stmt = $conn->prepare("DELETE FROM login WHERE user_id = ?");
                    $stmt->bind_param("s", $user_id);
                    if ($stmt->execute()) {
                        echo "<span style='font-size:15px;margin:20px;'><b>User deleted successfully.</b></span>";
                    } else {
                        echo "<span style='background-color:#fff;color:#00000;padding:10px;border-radius:10px;'>Error deleting user: " . $conn->error;
                        echo "<a href='AdminHome.php' style='text-decoration:underline;'>Back To Admin Home</a></span>";
                    }
                    $stmt->close();
                }

                $conn->close();
                ?>
                <div class="content">
                    <form action="" method="post">
                        <div class="inputBox">
                            <span>Full Name: <b><?php echo $name ?></b> </span>
                        </div>

                        <div class="inputBox">
                            <span>Email Address: <b><?php echo $email ?></b> </span>
                        </div>

                        <div class="inputBox">
                            <span>User Type: <b><?php echo $type ?></b> </span>
                        </div>

                        <div class="inputBox">
                            <span>Phone Number: <b><?php echo $user_phnum ?></b></span>
                        </div>

                        <div class="inputBox">
                            <span>Address: <b><?php echo $user_address ?></b></span>
                        </div>
                    </div>
                    <div class="button">
                        <input type="submit" name="submit" value="Delete" class="btn">
                        <input type="button" name="btnCancel" value="Back" class="btn" onclick="location='AdminHome.php'">
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
</body>
</html>
