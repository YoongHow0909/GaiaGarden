<?php
session_start();
$cart_id = "CART".sprintf("%04d",(isset($_SESSION["cartID"]))?$_SESSION["cartID"]: $_SESSION["cartID"] = 1);
$user_id = (isset($_SESSION["user_id"]))?$_SESSION["user_id"]:"";
$plant_id = (isset($_POST["plantID"]))?$_POST["plantID"]:"";
$order_qty = (isset($_POST["orderQty"]))?$_POST["orderQty"]:1;
require_once "db_conn.php";
$conn = mysqli_connect($dbhost, $username, $password, $dbname, $dbport);
$sql = "INSERT INTO cart (cart_id, user_id, plant_id, order_qty) VALUES (?,?,?,?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssi", $cart_id, $user_id, $plant_id, $order_qty);
$stmt->execute();
if($stmt->affected_rows > 0){
    $_SESSION["cartID"] += 1;
}
$stmt->close();
$conn->close();