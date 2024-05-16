<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Payment History</title>
        <link href="gaia_css/gaia-payment_history.css?version=51" rel="stylesheet" type="text/css"/>
    </head>
    <?php include "userheader.php"; ?>
    <body>
        <?php 
            require_once "db_conn.php"; 
            //session_start();
            //$userID = isset($_SESSION["user_id"])?$userID = trim($_SESSION["user_id"]):$userID = "";
        ?>
        <div class="payment-history">
            <h2 class="payment_history">Payment History</h2>
            <?php
                $conn = mysqli_connect($dbhost, $username, $password, $dbname, $dbport);
                $sql = "SELECT * FROM payment "
                     . "INNER JOIN cart ON cart.cart_id = payment.cart_id "
                     . "INNER JOIN plant ON cart.plant_id = plant.plant_id "
                     . "WHERE payment.user_id = '".$userID."'";
                $result = $conn->query($sql);
                if($result->num_rows > 0){
            ?>
            <table class="pay-history">
                <tr>
                    <th>Plant Name</th><th>Plant Category</th><th>Order Qty</th>
                    <th>Payment Price</th><th>Payment Method</th><th>Payment Date</th>
                </tr>
                <?php
                    while($record = $result->fetch_object()){
                        echo "<tr>";
                        printf("<td>%s</td><td name='plantCate'>%s</td><td name='orderQty'>%d</td>
                                <td>RM %.2f</td><td name='paymentMethod'>%s</td><td>%s</td>", 
                                $record->plant_name, $record->plant_cate, $record->order_qty, 
                                $record->payment_amt, $record->payment_type, 
                                date("d/m/Y",strtotime($record->payment_date)));
                        echo "</tr>";
                    }
                ?>
            </table>
            <?php
                } else {
                    echo "<p class='errormsg'>No payment history found !!</p>";
                }
            ?>
        </div>
        <?php include "footer.php"; ?>
    </body>
</html>