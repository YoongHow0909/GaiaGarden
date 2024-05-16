<?php
include("helper.php");
$startDate = isset($_GET['startDate']) && !empty($_GET['startDate']) ? $_GET['startDate'] : date("Y-m-d");
$endDate = isset($_GET['endDate']) && !empty($_GET['endDate']) ? $_GET['endDate'] : date("Y-m-d");

$sqlTopSales = "SELECT p.plant_name, (p.plant_price * c.order_qty) AS total_sale 
                FROM cart c 
                JOIN plant p ON c.plant_id = p.plant_id 
                JOIN payment pay ON c.cart_id = pay.cart_id 
                WHERE pay.payment_date BETWEEN ? AND ? 
                ORDER BY total_sale DESC 
                LIMIT 10";
$stmtTopSales = $conn->prepare($sqlTopSales);
$stmtTopSales->bind_param("ss", $startDate, $endDate);
$stmtTopSales->execute();
$resultTopSales = $stmtTopSales->get_result();

$topSalesData = [];
while ($row = $resultTopSales->fetch_assoc()) {
    $topSalesData[] = array("label" => $row['plant_name'], "y" => $row['total_sale']);
}

$sqlRecentSales = "SELECT p.plant_name, p.plant_price, c.order_qty, (p.plant_price * c.order_qty) AS total_sale, pay.payment_date
                FROM cart c 
                JOIN plant p ON c.plant_id = p.plant_id 
                JOIN payment pay ON c.cart_id = pay.cart_id 
                ORDER BY pay.payment_date DESC 
                LIMIT 5";
$stmtRecentSales = $conn->prepare($sqlRecentSales);
$stmtRecentSales->execute();
$resultRecentSales = $stmtRecentSales->get_result();

$recentSalesData = [];
while ($row = $resultRecentSales->fetch_assoc()) {
    $recentSalesData[] = $row;
}

$sqlOrders = "SELECT COUNT(*) AS totalOrders FROM payment WHERE payment_date BETWEEN ? AND ?";
$stmtOrders = $conn->prepare($sqlOrders);
$stmtOrders->bind_param("ss", $startDate, $endDate);
$stmtOrders->execute();
$resultOrders = $stmtOrders->get_result();
$totalOrders = $resultOrders->fetch_assoc()['totalOrders'];

$sqlRevenue = "SELECT SUM(payment_amt) AS totalRevenue FROM payment WHERE payment_date BETWEEN ? AND ?";
$stmtRevenue = $conn->prepare($sqlRevenue);
$stmtRevenue->bind_param("ss", $startDate, $endDate);
$stmtRevenue->execute();
$resultRevenue = $stmtRevenue->get_result();
$totalRevenue = $resultRevenue->fetch_assoc()['totalRevenue'];

$response = [
    "topSalesData" => $topSalesData,
    "totalOrders" => $totalOrders,
    "totalRevenue" => $totalRevenue,  
    "recentSalesData" => $recentSalesData
];

echo json_encode($response);

$conn->close();

