<?php
session_start();
$cart_str = (isset($_POST["payCartStr"]))?$_POST["payCartStr"]:"";
$cart_ids = explode(",", $cart_str);
$user_id = (isset($_SESSION["user_id"]))?$_SESSION["user_id"]:"";
$payment_type = (isset($_POST["paymentType"]))?$_POST["paymentType"]:"";
$payment_cardnum = (isset($_POST["cardNum"]))?$_POST["cardNum"]:"";
$timezone = new DateTimeZone("Asia/Kuala_Lumpur");
$now = new DateTime("now", $timezone);
$payment_date = $now->format("Y-m-d");
$error = false;
require_once "db_conn.php";
$conn = mysqli_connect($dbhost, $username, $password, $dbname, $dbport);
$sql = "INSERT INTO payment (payment_id, cart_id, user_id, payment_type, "
        . "payment_amt, payment_cardnum, payment_date) VALUES (?,?,?,?,?,?,?)";
$stmt = $conn->prepare($sql);
foreach($cart_ids as $cart_id){
    $payment_id = "PAID".sprintf("%04d",(isset($_SESSION["payID"]))?$_SESSION["payID"]: $_SESSION["payID"] = 1);
    $payment_amt = (isset($_POST["payAmt".$cart_id]))?$_POST["payAmt".$cart_id]:"";
    $stmt->bind_param("ssssdis", $payment_id, $cart_id, $user_id, 
            $payment_type, $payment_amt, $payment_cardnum, $payment_date);
    $stmt->execute();
    if($stmt->affected_rows > 0){
        $_SESSION["payID"] += 1;
    }
}
if($stmt->affected_rows > 0){
    header("Location: gaia-payment_success.php?cart_str=".$cart_str);
} else {
    echo "<script>";
    echo "alert('Failed to insert payment record. Please try again\n".$e->getMessage()."');";
    echo "window.location.href = 'gaia-payment.php';";
    echo "</script>";
}
$stmt->close();
$conn->close();