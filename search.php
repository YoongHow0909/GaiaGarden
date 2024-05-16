<?php

if(isset($_POST["searchBar"])){


    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<div class='plant-container'>";
        $count = 0;
        while ($row = $result->fetch_assoc()) {
            if ($count % 4 == 0) {
                echo "<div class='plant-row'>";
            }
    
            $imageFolder = $row["plant_cate"];
            echo "<div class='plant_list' id='plant_box' onclick=\"openModal('" . $row["plant_name"] . "', " . $row["plant_price"] . ", '" . $imageFolder . "/" . $row["plant_img"] . "', '" . $row["plant_desp"] . "')\">";
            echo '<img src="image/' . $imageFolder . '/' . $row["plant_img"] . '" alt="' . $row["plant_name"] . '"> <br><br>';
            echo  '<span class="plant_details">' . $row["plant_name"] . "<br><b>" . "RM" . $row["plant_price"] . "</b></span><br><br>";
            echo "<button type='button' class='btn btn-outline-success'>Add to cart</button>";
            echo "</div>";
            
            $count++;
            if ($count % 4 == 0) {
                echo "</div>";
            }
        }
        if ($count % 4 != 0) {
            echo "</div>";
        }
        echo "</div>";
    } else {
        echo "No record found";
    }


}
