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
                if (isset($_GET['plant_id'])) {
                    $plant_id = $_GET['plant_id'];

                    // Prepare and bind the query
                    $stmt = $conn->prepare("SELECT plant_name, plant_price, plant_cate, plant_avail,plant_avail FROM plant WHERE plant_id = ?");
                    $stmt->bind_param("s", $plant_id);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        // Fetch user details
                        $row = $result->fetch_assoc();
                        $plant_name = $row["plant_name"];
                        $plant_price = $row["plant_price"];
                        $plant_cate = $row["plant_cate"];
                        $plant_avail = $row["plant_avail"];
                    } else {
                        echo "<span style='background-color:#fff;color:#00000;padding:10px;border-radius:10px;'>Product not found.";
                        echo "<a href='AdminHome.php' style='text-decoration:underline;'>Back To Admin Home</a></span>";
                        exit; // Exit if user not found
                    }
                    $stmt->close();
                } else {
                    echo "<span style='background-color:#fff;color:#00000;padding:10px;border-radius:10px;'>Product ID not provided.";
                    echo "<a href='AdminHome.php' style='text-decoration:underline;'>Back To Admin Home</a></span>";
                    exit; // Exit if user ID not provided
                }

                // Check if form submitted for deleting user
                if (isset($_POST['submit'])) {
                    // Prepare and bind the delete statement
                    $stmt = $conn->prepare("DELETE FROM plant WHERE plant_id = ?");
                    $stmt->bind_param("s", $plant_id);
                    if ($stmt->execute()) {
                        echo "<span style='font-size:15px;margin:20px;'><b>Product deleted successfully.</b></span>";
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
                            <span>Product Name: <b><?php echo $plant_name ?></b> </span>
                        </div>

                        <div class="inputBox">
                            <span>Product Price: <b><?php echo $plant_price ?></b> </span>
                        </div>

                        <div class="inputBox">
                            <span>Category: <b><?php echo $plant_cate ?></b> </span>
                        </div>

                        <div class="inputBox">
                            <span>Available: <b><?php echo $plant_avail ?></b></span>
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
