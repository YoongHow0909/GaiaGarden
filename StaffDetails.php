<?php
    include 'connDatabase.php'; 

    // Initialize variable for search
    $search = "";

    // Process search query if form submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $search = isset($_POST["search"]) ? $_POST["search"] : "";
        $search = mysqli_real_escape_string($conn, $search);
    }
?>
<?php
    // Build SQL query to count total number of rows
    $sql_count = "SELECT COUNT(*) as total FROM login";
    $result_count = $conn->query($sql_count);

    if ($result_count && $result_count->num_rows > 0) {
        $row_count = $result_count->fetch_assoc();
        $total_rows = $row_count['total'];
    } else {
        $total_rows = 0;
    }

    $conn->close();
?>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Staff Details</title>
        <link rel="stylesheet" href="gaia_css/Admin.css" />
        <?php include 'navigationAdmin.php'; ?>  
        <style>
          table {
            background-color: white;
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            margin-left: 15px;         
          }

          th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
          }

          th {
            background-color: #f2f2f2;
          }

          tr:hover {
            background-color: #f2f2f2;
          }

          .action-buttons {
            display: flex;
            justify-content: space-around;
          }

          .edit-btn, .delete-btn {
            padding: 4px 8px;
            cursor: pointer;
          }

          .edit-btn:hover, .delete-btn:hover {
            background-color: #e0f7fa;
          }

          .pagination{
              margin: 10px;
          }

            .pagination a {
              display: inline-block;
              padding: 8px 16px;
              text-decoration: none;
              color: black;
              border: 1px solid #ddd;
              background-color:white;
            }

            .pagination a.active {
              background-color: #e0f7fa;
            }

            .pagination a:hover:not(.active) {
              background-color: #ddd;
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
                <h1>Staff Details</h1>
                <div class="search_bar">
                    <form action="StaffDetails.php" method="POST">
                        <input type="search" style="width:250px;" placeholder="Search By Name" name="search" value="<?php echo $search; ?>">               
                        <input type="submit" style="width:100px;" value="Search">
                    </form>
                </div>
                <div class="row">
                    <a href="StaffDetails.php">See all</a>
                </div>

            <div class="customer-table">
                <form action="" method="POST">
                    <table>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Address</th>
                            <th ></th> 
                        </tr>
                       <?php
                        include 'connDatabase.php';

                        // Number of records per page
                        $records_per_page = 5;

                        // Determine current page number
                        if (isset($_GET['page']) && is_numeric($_GET['page'])) {
                            $page = $_GET['page'];
                        } else {
                            $page = 1;
                        }

                        // Calculate offset for the SQL query
                        $offset = ($page - 1) * $records_per_page;                    

                        // Initialize variable for search
                        $search = "";

                        // Process search query if form submitted
                        if ($_SERVER["REQUEST_METHOD"] == "POST") {
                            // Retrieve the search query
                            $search = isset($_POST["search"]) ? $_POST["search"] : "";

                            // Prevent SQL injection
                            $search = mysqli_real_escape_string($conn, $search);
                        }

                        // Build the SQL query
                        $sql = "SELECT user_id,name,email,user_phnum,user_address FROM login WHERE type = 'staff'";
                        if (!empty($search)) {
                            // Append the search condition to filter names starting with the entered letter
                            $sql .= " AND name LIKE '$search%'";
                        } else {
                            // Handle case when search term is empty
                            $sql .= " AND 1=1"; // This condition will always be true
                        }

                        $sql .= " LIMIT $records_per_page OFFSET $offset";

                        $result = $conn->query($sql);

                        // Check if there are results
                        if ($result) {
                            if ($result->num_rows > 0) {
                                // Output data of each row
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>" . $row["user_id"] . "</td>";
                                    echo "<td>" . $row["name"] . "</td>";
                                    echo "<td>" . $row["email"] . "</td>";
                                    echo "<td>" . $row["user_phnum"] . "</td>";
                                    echo "<td>" . $row["user_address"] . "</td>";
                                    echo "<td class='action-buttons'>";
                                    echo "<a href='editUser.php?user_id=" . $row["user_id"] . "' class='edit-btn'>Edit</a>";
                                    echo "<a href='deleteUser.php?user_id=" . $row["user_id"] . "' class='edit-btn'>Delete</a>";
                                    echo "</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='6'>No staff found</td></tr>";
                            }
                        } else {
                            // Handle query execution error
                            echo "Error: " . $conn->error;
                        }

                        $conn->close();
                        ?>
                    </table>           
                <a href="addStaff.php"><button type="button" class="btn">Add More</button></a>

                <div class="pagination">
                                <?php
                                // Calculate total number of pages
                                $total_pages = ceil($total_rows / $records_per_page);

                                // Output pagination links
                                for ($i = 1; $i <= $total_pages; $i++) {
                                    echo "<a href='?page=$i'>$i</a>";
                                }
                                ?>
                            </div>            

                      </form>
                        </div>
                      </div>
                    </div>
                    </section>
                  </div>
                </body>
</html>