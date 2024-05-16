<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Statistics Report</title>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="gaia_css/style.css">
    <?php include("header.php"); ?>
</head>
<body>
    <div class="container">
        <h1>Admin Statistics Report</h1>
        <div id="datePicker">
            <label for="startDate">Start Date:</label>
            <input type="date" id="startDate" name="startDate">
            <label for="endDate">End Date:</label>
            <input type="date" id="endDate" name="endDate">
            <button id="submitBtn">Submit</button>
        </div>
            <div id="totals-container">
                <div id="totalOrdersDiv" class="stats-box">
                    <span>Total Orders: </span>
                    <span id="totalOrders"></span>
                </div>
                <div id="totalRevenueDiv" class="stats-box">
                    <span>Total Revenue: </span>
                    <span id="totalRevenue"></span>
                </div>
            </div>
            <div id="statistics">
            <h2>Top 10 Sales Report</h2>
            <div id="topSalesChartContainer">
                <canvas id="topSalesChart"></canvas>
            </div>
            <div id="recentSalesContent"></div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="script.js"></script>
</body>
<footer><?php include("footer.php"); ?></footer>
</html>
