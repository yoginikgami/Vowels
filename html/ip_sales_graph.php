<?php
// session_start();
// include_once 'connection.php';

// // Retrieve data from POST request
// $from_date = isset($_POST['from_date']) && !empty($_POST['from_date']) ? $_POST['from_date'] : date('Y-m-d', strtotime('-30 days'));
// $to_date = isset($_POST['to_date']) && !empty($_POST['to_date']) ? $_POST['to_date'] : date('Y-m-d');
// $portfolioArray = isset($_POST['salesPorfolio']) ? $_POST['salesPorfolio'] : [];

// // Validate that portfolios are selected
// if (!empty($portfolioArray)) {
//     // Build query dynamically based on selected portfolios
//     $portfolioQueries = [];
//     foreach ($portfolioArray as $portfolio) {
//         if ($portfolio === "trade_mark") {
//             $portfolioQueries[] = "SELECT 'Trade Mark' AS portfolio, SUM(bill_amt) AS sales FROM trade_mark WHERE company_id = '{$_SESSION['company_id']}' AND date_application BETWEEN '$from_date' AND '$to_date'";
//         } elseif ($portfolio === "patent") {
//             $portfolioQueries[] = "SELECT 'Patent' AS portfolio, SUM(billing_amount) AS sales FROM patent WHERE company_id = '{$_SESSION['company_id']}' AND filling_date BETWEEN '$from_date' AND '$to_date'";
//         } elseif ($portfolio === "copy_right") {
//             $portfolioQueries[] = "SELECT 'Copy Right' AS portfolio, SUM(billing_amount) AS sales FROM copy_right WHERE company_id = '{$_SESSION['company_id']}' AND filling_date BETWEEN '$from_date' AND '$to_date'";
//         } elseif ($portfolio === "trade_secret") {
//             $portfolioQueries[] = "SELECT 'Trade Secret' AS portfolio, SUM(billing_amount) AS sales FROM trade_secret WHERE company_id = '{$_SESSION['company_id']}' AND date_of_filling BETWEEN '$from_date' AND '$to_date'";
//         } elseif ($portfolio === "industrial_design") {
//             $portfolioQueries[] = "SELECT 'Industrial Design' AS portfolio, SUM(billing_amount) AS sales FROM industrial_design WHERE company_id = '{$_SESSION['company_id']}' AND filling_date BETWEEN '$from_date' AND '$to_date'";
//         }
//     }

//     // Combine queries with UNION
//     $finalQuery = implode(" UNION ALL ", $portfolioQueries);
// // echo $finalQuery;
//     $result = mysqli_query($con, $finalQuery);
//     if ($result && mysqli_num_rows($result) > 0) {
//         echo "<script type='text/javascript'>
//     google.charts.load('current', {'packages':['corechart']});
//     google.charts.setOnLoadCallback(drawPortfolioGraph);

//     function drawPortfolioGraph() {
//         console.log('Drawing chart...'); // Debug
//         var data = google.visualization.arrayToDataTable([
//             ['Portfolio', 'Total Sales'],";
// while ($row = mysqli_fetch_assoc($result)) {
//     echo "['" . $row['portfolio'] . "', " . ($row['sales'] ?: 0) . "],"; // Ensure 0 for empty sales
// }
// echo "]);
//         console.log(data); // Debug
//         var options = {
//             title: 'Sales by Portfolio',
//             hAxis: { title: 'Portfolio' },
//             vAxis: { title: 'Total Sales' },
//             legend: { position: 'none' },
//             bar: { groupWidth: '75%' },
//             colors: ['#4CAF50']
//         };
//         var chart = new google.visualization.ColumnChart(document.getElementById('sales_material'));
//         chart.draw(data, options);
//     }
// </script>";

//     } else {
//         echo "No data available for the selected date range and portfolios.";
//     }
// } else {
//     echo "Please select at least one portfolio.";
// }



session_start();
include_once 'connection.php';

header('Content-Type: application/json');

// Retrieve data from AJAX request
$from_date = isset($_POST['from_date']) ? $_POST['from_date'] : date('Y-m-d', strtotime('-30 days'));
$to_date = isset($_POST['to_date']) ? $_POST['to_date'] : date('Y-m-d');
$portfolioArray = isset($_POST['salesPorfolio']) ? $_POST['salesPorfolio'] : [];

if (!empty($portfolioArray)) {
    $portfolioQueries = [];
    foreach ($portfolioArray as $portfolio) {
        if ($portfolio === "trade_mark") {
            $portfolioQueries[] = "SELECT 'Trade Mark' AS portfolio, SUM(bill_amt) AS sales FROM trade_mark WHERE company_id = '{$_SESSION['company_id']}' AND date_application BETWEEN '$from_date' AND '$to_date'";
        } elseif ($portfolio === "patent") {
            $portfolioQueries[] = "SELECT 'Patent' AS portfolio, SUM(billing_amount) AS sales FROM patent WHERE company_id = '{$_SESSION['company_id']}' AND filling_date BETWEEN '$from_date' AND '$to_date'";
        } elseif ($portfolio === "copy_right") {
            $portfolioQueries[] = "SELECT 'Copy Right' AS portfolio, SUM(billing_amount) AS sales FROM copy_right WHERE company_id = '{$_SESSION['company_id']}' AND filling_date BETWEEN '$from_date' AND '$to_date'";
        } elseif ($portfolio === "trade_secret") {
            $portfolioQueries[] = "SELECT 'Trade Secret' AS portfolio, SUM(billing_amount) AS sales FROM trade_secret WHERE company_id = '{$_SESSION['company_id']}' AND date_of_filling BETWEEN '$from_date' AND '$to_date'";
        } elseif ($portfolio === "industrial_design") {
            $portfolioQueries[] = "SELECT 'Industrial Design' AS portfolio, SUM(billing_amount) AS sales FROM industrial_design WHERE company_id = '{$_SESSION['company_id']}' AND filling_date BETWEEN '$from_date' AND '$to_date'";
        }
    }

    $finalQuery = implode(" UNION ALL ", $portfolioQueries);
    $result = mysqli_query($con, $finalQuery);
    
    $salesData = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $salesData[] = [
            "portfolio" => $row['portfolio'],
            "sales" => $row['sales'] ?: 0 // Default to 0 if NULL
        ];
    }

    echo json_encode(["success" => true, "salesData" => $salesData]);
} else {
    echo json_encode(["success" => false, "message" => "No portfolios selected"]);
}


?>
