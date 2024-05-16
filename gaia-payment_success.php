<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Payment Success</title>
        <link href="gaia_css/gaia-payment_success.css?version=51" rel="stylesheet" type="text/css"/>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script>
            $(document).ready(function() {
                $("table.shipOrder").hide();
                $("[name='viewOrder']").click(function() {
                    $("table.shipOrder").toggle();
                });
            });
        </script>
    </head>
    <?php include "userheader.php"; ?>
    <body>
        <?php 
            require_once "db_conn.php"; 
            $cart_str = (isset($_GET["cart_str"]))?$_GET["cart_str"]:"";
            $cart_str = str_replace(",", "','", $cart_str);
        ?>
        <div class="pay-success">
            <?php if(isset($_GET["cart_str"])): ?>
            <p class="payment-success">Payment Success</p><br/>
            <p>Thank You for choosing us! &#128149;</p>
            <p style="display: inline-block;">Your order is ready to ship&#128674;</p>&nbsp;
            <button name="viewOrder" class="view-order">View Order</button>
            <table class="shipOrder">
                <tr>
                    <th>Plant Name</th><th>Plant Category</th><th>Order Qty</th>
                </tr>
                <?php
                    $conn = mysqli_connect($dbhost, $username, $password, $dbname, $dbport);
                    $selectSQL = "SELECT * FROM cart INNER JOIN plant
                            ON cart.plant_id = plant.plant_id 
                            WHERE cart_id IN ('".$cart_str."')";
                    $result = $conn->query($selectSQL);
                    if($result->num_rows > 0){
                        while($record = $result->fetch_object()){
                            echo "<tr>";
                                printf("<td name='plantName'>%s</td><td name='plantCate'>%s</td><td name='orderQty'>%d</td>",
                                        $record->plant_name, $record->plant_cate, $record->order_qty);
                            echo "</tr>";
                            $plant_avail = $record->plant_avail - $record->order_qty;
                            $updateSQL = "UPDATE plant JOIN cart ON cart.plant_id = plant.plant_id 
                                          SET plant.plant_avail = ? WHERE cart.cart_id = ?";
                            $stmt = $conn->prepare($updateSQL);
                            $stmt->bind_param("is", $plant_avail, $record->cart_id);
                            $stmt->execute();
                            if($stmt->affected_rows > 0){
                            }else{
                            }
                        }
                    }
                    $result->free();
                    $stmt->close();
                    $conn->close();
                ?>
            </table><br/>
            <?php 
                $timezone = new DateTimeZone("Asia/Kuala_Lumpur");
                $now = new DateTime("now", $timezone);
                $now->modify("+3 day");
                $date_receive = $now->format("d/m/Y");
            ?>
            <p>Your plant&#x1fab4; will reach to you before <?php echo $date_receive; ?></p>
            <?php else: ?>
            <p class="payment-failed">Payment Failed</p><br/>
            <p>You are not payment yet. Please <a href="gaia-cart.php">try again</a></p>
            <?php endif; ?>
            <br/><br/>
            <a href="home.php" style="color: #B3DC33;">&#11164; Back to Home</a>
            <a href="gaia-payment_history.php" style="float: right; color: #B3DC33;">Payment History &#11166;</a>
        </div>
    </body>
    <?php include "footer.php"; ?>
</html>