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
$sql_count = "SELECT COUNT(*) as total FROM plant";
$result_count = $conn->query($sql_count);

if ($result_count && $result_count->num_rows > 0) {
    $row_count = $result_count->fetch_assoc();
    $total_rows = $row_count['total'];
} else {
    $total_rows = 0;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Product Details</title>
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
      padding: 12px;
      text-align: left;
      border-bottom: 1px solid #ddd;
      font-size: 16px;
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
      padding: 6px 12px;
      cursor: pointer;
    }

    .edit-btn:hover, .delete-btn:hover {
      background-color: #e0f7fa;
    }

    .pagination {
      margin-top: 20px;
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
        <h1>Product Details</h1>
      
        <div class="search_bar">
            <form action="ProductDetails.php" method="POST">
                <input type="search" style="width:250px;" placeholder="Search By Name" name="search" value="<?php echo $search; ?>">               
                <input type="submit" style="width:100px;" value="Search">
            </form>
        </div>

      <div class="row">
        <a href="ProductDetails.php">See all</a>
      </div>
        
        <div class="customer-table">
            <form action="" method="POST">
                <table>
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Plant Name</th>
                      <th>Price</th>
                      <th>Category</th>
                      <th>Available</th>
                      <th></th> 
                    </tr>
                  </thead>
                  <tbody>
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
                    
                    // Build the SQL query
                    $sql = "SELECT plant_id, plant_name, plant_price, plant_cate, plant_avail FROM plant";
                    if (!empty($search)) {
                        // Append the search condition to filter names starting with the entered letter
                        $sql .= " WHERE plant_name LIKE '$search%'";
                    } 
                    
                    $sql .= " LIMIT $records_per_page OFFSET $offset";

                    // Execute SQL query
                    $result = $conn->query($sql);

                    // Output data of each row
                    if ($result && $result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["plant_id"] . "</td>";
                            echo "<td>" . $row["plant_name"] . "</td>";
                            echo "<td>" . $row["plant_price"] . "</td>";
                            echo "<td>" . $row["plant_cate"] . "</td>";
                            echo "<td>" . $row["plant_avail"] . "</td>";
                            echo "<td class='action-buttons'>";
                            echo "<a href='editProduct.php?plant_id=" . $row["plant_id"] . "' class='edit-btn'>Edit</a>";
                            echo "<a href='deleteProduct.php?plant_id=" . $row["plant_id"] . "' class='edit-btn'>Delete</a>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>No records found</td></tr>";
                    }

                    $conn->close();
                    ?>
                    
                  </tbody>
                </table>
             <button type="button" class="btn" onclick="window.location.href='addPlant.php'">Add More</button>
             
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
