<?php
$cart_id = isset($_GET["cart"])?trim($_GET["cart"]):"";
require_once "db_conn.php";
$conn = mysqli_connect($db_host, $db_user, $db_password, $db_name);
$sql = "DELETE FROM CART WHERE cart_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $cart_id);
$stmt->execute();
if($stmt->affected_rows > 0){
    
}else{
    
}
$stmt->close();
$conn->close();