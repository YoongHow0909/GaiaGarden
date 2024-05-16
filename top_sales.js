$(document).ready(function() {
    $.ajax({
        url: "get_statistics.php",
        type: "GET",
        dataType: "json",
        success: function(response) {
            if (response.topSalesData && response.topSalesData.length > 0) {
                displayTopSales(response.topSalesData);
            } else {
                $("#topSalesList").html("<p>No sales data available.</p>");
            }
        },
        error: function(error) {
            console.error("Error fetching top sales data:", error);
            $("#topSalesList").html("<p>Error loading sales data.</p>");
        }
    });

    function displayTopSales(data) {
        var html = "";
        data.forEach(function(item) {
            html += `<div class="plant-item">
                        <img src="${item.image}" alt="${item.label}" class="plant-image"/>
                        <p>${item.label}</p>
                     </div>`;
        });
        $("#topSalesList").html(html);
    }
});
        