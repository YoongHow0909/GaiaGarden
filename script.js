var topSalesChart;

$(document).ready(function() {
    $("#startDate, #endDate").datepicker();

    $("#submitBtn").on("click", function() {
        var startDate = $("#startDate").val();
        var endDate = $("#endDate").val();

        $.ajax({
            url: "get_statistics.php",
            type: "GET",
            data: { startDate: startDate, endDate: endDate },
            dataType: "json",
            success: function(response) {
                if (response.topSalesData && response.topSalesData.length > 0) {
                    createPieChart(response.topSalesData, 'topSalesChart');
                } else {
                    createEmptyChart('topSalesChart', 'No sales data for the selected date.');
                }
                if (response.totalOrders !== undefined) {
                    $("#totalOrders").text(response.totalOrders);
                }
                if (response.totalRevenue !== undefined) {
                    $("#totalRevenue").text("RM" + response.totalRevenue.toFixed(2));
                }
                displayRecentSales(response.recentSalesData);
            },
            error: function(error) {
                console.error("Error fetching statistics:", error);
            }
        });
    });

    function loadInitialData() {
        $.ajax({
            url: "get_statistics.php",
            type: "GET",
            dataType: "json",
            success: function(response) {
                if (response.topSalesData && response.topSalesData.length > 0) {
                    createPieChart(response.topSalesData, 'topSalesChart');
                } else {
                    createEmptyChart('topSalesChart', 'No sales data for the selected date.');
                }
                if (response.totalOrders !== undefined) {
                    $("#totalOrders").text(response.totalOrders);
                }
                if (response.totalRevenue !== undefined) {
                    $("#totalRevenue").text("RM" + response.totalRevenue.toFixed(2));
                }
                displayRecentSales(response.recentSalesData);
            },
            error: function(error) {
                console.error("Error fetching initial statistics:", error);
            }
        });
    }

    loadInitialData();
});

function createPieChart(data, chartId) {
    var ctx = document.getElementById(chartId).getContext('2d');
    
    if (topSalesChart) {
        topSalesChart.destroy();
    }
    
    topSalesChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: data.map(item => item.label),
            datasets: [{
                label: 'Top 10 Sales',
                data: data.map(item => item.y),
                backgroundColor: [
                    'rgba(255, 99, 132, 0.5)',
                    'rgba(54, 162, 235, 0.5)',
                    'rgba(255, 206, 86, 0.5)',
                    'rgba(75, 192, 192, 0.5)',
                    'rgba(153, 102, 255, 0.5)',
                    'rgba(255, 159, 64, 0.5)',
                    'rgba(255, 99, 132, 0.5)',
                    'rgba(54, 162, 235, 0.5)',
                    'rgba(255, 206, 86, 0.5)',
                    'rgba(75, 192, 192, 0.5)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)',
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            legend: {
                display: false
            },
            tooltips: {
                callbacks: {
                    label: function(tooltipItem, data) {
                        var dataset = data.datasets[tooltipItem.datasetIndex];
                        var total = dataset.data.reduce(function(previousValue, currentValue) {
                            return previousValue + currentValue;
                        }, 0);
                        var currentValue = dataset.data[tooltipItem.index];
                        var percentage = Math.floor(((currentValue / total) * 100) + 0.5);         
                        return percentage + "%";
                    }
                }
            }
        }
    });
}


function displayRecentSales(data) {
    var html = "<h2>Recent Sales</h2><table><tr><th>Plant Name</th><th>Plant Price</th><th>Order Quantity</th><th>Total Sale</th><th>Date</th></tr>";
    for (var i = 0; i < data.length; i++) {
        html += "<tr><td>" + data[i].plant_name + "</td><td>RM" + data[i].plant_price + "</td><td>" + data[i].order_qty + "</td><td>RM" + data[i].total_sale + "</td><td>" + data[i].payment_date + "</td></tr>";
    }
    html += "</table>";
    $("#recentSalesContent").html(html);
}

