<?php
$cart_id = isset($_GET["cart"])?trim($_GET["cart"]):"";
$amount = isset($_GET["amt"])?trim($_GET["amt"]):"";
require_once "db_conn.php";
$conn = mysqli_connect($dbhost, $username, $password, $dbname, $dbport);
$sql = "UPDATE CART SET order_qty = ? WHERE cart_id = ? ";
$stmt = $conn->prepare($sql);
$stmt->bind_param('ss', $amount, $cart_id);
$stmt->execute();
if($stmt->affected_rows > 0){
    
}else{
    
}
$stmt->close();
$conn->close();