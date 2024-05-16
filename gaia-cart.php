<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Cart</title>
        <link href="gaia_css/gaia-cart.css?version=51" rel="stylesheet" type="text/css"/>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script>
            function updateCart(cart_id, amt){
                amt = (amt != 0)?amt:amt=document.getElementById("orderQty"+cart_id).value;
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                    if (this.readyState === 4 && this.status === 200) {
                        location.reload();
                    }
                }
                xmlhttp.open("GET", "gaia-update_cart.php?cart="+cart_id+"&amt="+amt, true);
                xmlhttp.send();
            }
            function deleteCart(cart_id){
                if(confirm("Are you sure to delete?") == true){
                    var xmlhttp = new XMLHttpRequest();
                    xmlhttp.onreadystatechange = function() {
                        if (this.readyState === 4 && this.status === 200) {
                            location.reload();
                        }
                    }
                    xmlhttp.open("GET", "gaia-delete_cart.php?cart="+cart_id, true);
                    xmlhttp.send();
                }else{
                }
            }
            $(document).ready(function() {
                $("#cart-form").submit(function() {
                    if($("input[type='checkbox']:checked").length > 0) {
                        $("#cart-form").attr("action", "gaia-payment.php");
                    } else {
                        $("#cart-form").attr("action", "");
                        event.preventDefault();
                        $(".errormsg").show();
                    }
                }); 
                document.querySelectorAll(".item-ckb").forEach(function(checkbox){
                    checkbox.addEventListener("change", function(){
                        if(this.checked)
                            $(".errormsg").hide();
                    });
                });
            });
        </script>
    </head>
    <?php include "userheader.php"; ?>
    <body>
        <?php require_once "db_conn.php"; ?>
        <?php
            //$userID = isset($_SESSION["userID"])?$userID = trim($_SESSION["userID"]):$userID = "";
            $total_price = 0;
      
        ?>
        <h2 style="margin-left: 320px;">Cart</h2>
        <form method="POST" action="" id="cart-form">
            <?php
                $conn = mysqli_connect($dbhost, $username, $password, $dbname, $dbport);
                $sql = "SELECT * FROM cart INNER JOIN plant
                        ON cart.plant_id = plant.plant_id
                        WHERE user_id = '$userID'";
                $result = $conn->query($sql);
                if($result->num_rows > 0){
                    while($record = $result->fetch_object()){
                        echo "<div class='item-container'>";
                            echo "<input type='checkbox' class='item-ckb' name='itemckb[]' value='$record->cart_id'>";
                          printf("<img src='gaia_img/%s/%s' alt='%s' class='item-img'/>", $record->plant_cate, 
                                  $record->plant_img, $record->plant_name);
                            echo "<div class='item-desc-container>";
                              printf("<h3 class='item-title'><b>%s</b></h3>", $record->plant_name);
                              printf("<p class='item-desc'>Category: %s</p>", $record->plant_cate);
                              printf("<p class='item-desc'>Description: %s</p>", $record->plant_desp);
                            echo "</div>";
                            echo "<div class='item-ctrl-info'>";
                                printf("<img src='gaia_img/delete-btn.png' alt='Delete' 
                                    class='del-ctrl' onclick='deleteCart(\"%s\");'/>", $record->cart_id);
                                  echo "<div class='item-price'>";
                                      echo "<div class='item-amt'>";
                                      if ($record->order_qty > 1) {
                                          printf("<input type='button' value='-' name='subBtn'
                                                onclick='updateCart(\"%s\",%d)'/>", $record->cart_id, $record->order_qty-1);
                                      } else {
                                          printf("<input type='button' value='-' name='subBtn' disabled/>");
                                      }
                                      echo "<input type='text' id='orderQty".$record->cart_id."' value='".$record->order_qty."' 
                                            style='width: 25px; text-align: center;' onblur='updateCart(\"".$record->cart_id."\",0)'>";
                                      if ($record->order_qty <  $record->plant_avail) {
                                          printf("<input type='button' value='+' name='addBtn'
                                                    onclick='updateCart(\"%s\",%d)'/>", $record->cart_id, $record->order_qty+1);
                                      } else {
                                          printf("<input type='button' value='+' name='addBtn' disabled/>");
                                      }
                                      echo "</div>";
                                    printf("<p class='subtotal-price'>RM %.2f</p>", $record->plant_price * $record->order_qty);
                                  echo "</div>";
                              echo "</div>";
                          echo "</div>";
                        $total_price += ($record->plant_price * $record->order_qty);
                    }
                    printf("<div class='checkout'>
                                <p class='errormsg' hidden>At least 1 item must be checked</p>
                                <p class='total-price'>
                                Total <br/>
                                RM %.2f
                                </p>
                                <input type='submit' value='Check-Out' name='checkout-btn'>
                            </div>", $total_price);
                    echo "<br>";
                }else{
                    printf("<h3 style='text-align: center; color: grey;'>No item in cart</h3>");
                }
                $result->free();
                $conn->close();
            ?>
        </form>
        <?php include "footer.php"; ?>
    </body>
</html>