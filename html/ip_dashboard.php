<?php
include_once 'ltr/header.php';
include_once 'connection.php';
date_default_timezone_set('Asia/Kolkata');
$currentTime = date('Y-m-d', time());
$date = date('Y-m-d');

if (isset($_SESSION['company_id'])) {
    $company_id = $_SESSION['company_id'];
    // Fetch user data for the given company ID and user ID
    $fetch_user_data = "SELECT * FROM `users` WHERE `company_id` = '$company_id' AND `id` = '" . $_SESSION['user_id'] . "'";
    $run_fetch_user_data = mysqli_query($con, $fetch_user_data);
    $portfoliorow = mysqli_fetch_array($run_fetch_user_data);
}

$columns = [
    "trade_mark" => "trade_mark",
    "patent" => "patent",
    "copy_right" => "copy_right",
    "industrial_design" => "industrial_design",
    "trade_secret" => "trade_secret",
];

$hasPortfolio = false;
foreach ($columns as $key => $value) {
    if (!empty($portfoliorow[$key]) && $portfoliorow[$key] == 1) {
        $hasPortfolio = true;
        break;
    }
}

$card_columns = [
    "trade_mark" => ["label" => "Trade Mark", "table" => "trade_mark"],
    "patent" => ["label" => "Patent", "table" => "patent"],
    "copy_right" => ["label" => "Copyright", "table" => "copy_right"],
    "industrial_design" => ["label" => "Industrial Design", "table" => "industrial_design"],
    "trade_secret" => ["label" => "Trade Secret", "table" => "trade_secret"]
];

$colors = ["#ff6b6b", "#1e90ff", "#2ecc71", "#ff9f43", "#8e44ad"];

// If no portfolio data, show message
if (!$hasPortfolio) {
    echo '<div class="alert alert-warning">No portfolio data available.</div>';
    exit;
}

// Define status labels correctly
$statuses = [
    "registration" => "Pending",
    "hearing" => "Active", // ✅ Changed from "Active" to "Hearing"
    "expired" => "Expired"
];

$total_portfolio = 0;
$index = 0;

// Define portfolio options with database table mapping
$portfolioOptions = [
    "trade_mark" => ["name" => "Trade Mark", "table" => "trade_mark", "date_column" => "date_application"],
    "patent" => ["name" => "Patent", "table" => "patent", "date_column" => "filling_date"],
    "copy_right" => ["name" => "Copyright", "table" => "copy_right", "date_column" => "filling_date"],
    "industrial_design" => ["name" => "Industrial Design", "table" => "industrial_design", "date_column" => "filling_date"],
    "trade_secret" => ["name" => "Trade Secret", "table" => "trade_secret", "date_column" => "date_of_filling"]
];

// Build dynamic SQL query based on enabled portfolios
$queryParts = [];

foreach ($portfolioOptions as $key => $details) {
    if (!empty($portfoliorow[$key]) && $portfoliorow[$key] == 1) {
        $queryParts[] = "(SELECT '{$details['name']}' AS type, transaction_id, client_name, {$details['date_column']} AS expiry_date FROM {$details['table']} ORDER BY {$details['date_column']} ASC LIMIT 5)";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IP Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.11.3/css/dataTables.bootstrap4.min.css" />
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">

    <style>
        .multiselect-container {
            position: relative;
            width: 100%;
        }

        .multiselect-dropdown {
            background: white;
            border: 1px solid #ccc;
            padding: 5px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            position: relative;
            /* Ensure correct positioning */
            z-index: 10;
        }

        .multiselect-dropdown span {
            font-size: 14px;
            color: #333;
        }

        .multiselect-options {
            position: absolute;
            top: 100%;
            left: 0;
            width: 100%;
            background: white;
            border: 1px solid #ccc;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            display: none;
            max-height: 200px;
            overflow-y: auto;
            z-index: 1000;
        }

        .multiselect-options.show {
            display: block;
        }

        .multiselect-options input[type="text"] {
            width: 100%;
            padding: 5px;
            box-sizing: border-box;
            border: none;
            border-bottom: 1px solid #ccc;
            outline: none;
        }

        .multiselect-options ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .multiselect-options li {
            padding: 5px;
            display: flex;
            align-items: center;
        }

        .multiselect-options input[type="checkbox"] {
            margin-right: 8px;
        }

        /* .card {
        min-height: 100px; 
        display: flex;
        flex-direction: column;
    } */
        table {
            width: 100%;
            border-collapse: collapse;
            font-family: Arial, sans-serif;
            border: 1px solid #ccc;
            border-radius: 10px;
            overflow: hidden;
            /* Ensures border-radius works */
        }

        thead tr {
            background-color: #218125 !important;
            /* Ensure Green Color */
            color: white !important;
        }

        thead th {
            background-color: #218125 !important;
            /* Apply Green Background to Each <th> */
            color: white !important;
            padding: 8px;
            text-align: left;
        }

        th,
        td {
            padding: 10px;
            border: 1px solid #ddd;
        }

        tbody tr:nth-child(odd) {
            background-color: #fff;
        }

        tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tbody tr:hover {
            background-color: #e9ecef;
            transition: background-color 0.3s;
        }

        .card h5 {

            font-weight: bold;
        }

        .table th,
        .table td {

            vertical-align: middle;
        }

        /* Card Base Styling */
        .portfolio-card {
            padding: 15px;
            text-align: center;
            color: white;
            font-weight: bold;
            border-radius: 10px;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.2);
            transition: 0.3s ease-in-out;
        }

        /* Hover Effect */
        .portfolio-card:hover {
            transform: scale(1.05);
            box-shadow: 4px 4px 12px rgba(0, 0, 0, 0.3);
        }

        /* Different Colors for Each Card */
        .portfolio-total {
            background: rgb(39, 39, 40);
        }

        /* Dark Gray */
        .portfolio-trademark {
            background: rgb(97, 161, 229);
        }

        /* Blue */
        .portfolio-patent {
            background: rgb(22, 181, 59);
        }

        /* Green */
        .portfolio-industrial {
            background: rgb(253, 121, 13);
        }

        /* Orange */
        .portfolio-copyright {
            background: rgb(95, 41, 196);
        }

        /* Purple */
        .portfolio-secret {
            background: rgb(234, 4, 27);
        }

        /* Red */

        /* Responsive Design */
        @media (max-width: 768px) {
            .portfolio-card {
                margin-bottom: 10px;
                font-size: 14px;
            }
        }

        p {
            margin-top: 0;
            margin-bottom: 0.rem;

        }
        .container-fluid.custom-gap {
            padding-top: 0.5rem;
            /* Adjust top padding */
            padding-bottom: 0.5rem;
            /* Adjust bottom padding */
        }

        .container-fluid.custom-gap .card {
            margin-bottom: 0.5rem;
            /* Adjust gap between cards */
        }
        /* .row {
    display: flex;
    flex-wrap: wrap;
}

.col-md-4 {
    display: flex;
} */

.rectangle {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    text-align: center;
    width: 100%;
    height: 100%;
    min-height: 110px; /* Ensures equal height */
    padding: 20px;
    border-radius: 10px;
}



    </style>
</head>

<body>
    <div class="container mt-4">
        <div class="row d-flex align-items-stretch">
            <div class="col-md-6 d-flex">
                <div class="card p-3 flex-fill w-100">
                    <div class="row ">
                        <h5>Intellectual Property Sales Graph</h5>
                        <br>

                        <div class="col-md-6">
                            <label><b>From:</b></label>
                            <input type="date" class="form-control" id="fromDate">
                        </div>
                        <div class="col-md-6">
                            <label><b>To:</b></label>
                            <input type="date" class="form-control" id="toDate">
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="salesPorfolio[]" class="font-weight-bold" style="font-size: 14px;">Select Portfolios:</label>

                        <div class="multiselect-container">
                            <div class="multiselect-dropdown" onclick="toggleDropdown()">
                                <span id="selectedText">Select Portfolios</span>
                                <div class="multiselect-options">
                                    <!-- <input type="text" id="searchBox" placeholder="Search..." onkeyup="filterOptions()"> -->

                                    <ul>
                                        <li>
                                            <!-- <input type="checkbox" id="selectAll" onclick="selectAllToggle(this)"> -->
                                            <!-- <label for="selectAll"><b>Select All</b></label> -->
                                        </li>
                                        <?php
                                        foreach ($columns as $key => $label) {
                                            if (!empty($portfoliorow[$key]) && $portfoliorow[$key] == 1) {
                                                echo '<li>
                                                <input type="checkbox" class="multi-checkbox" name="salesPorfolio[]" value="' . $key . '" onclick="updateSelection()">
                                                ' . ucfirst(str_replace('_', ' ', $label)) . '
                                            </li>';
                                            }
                                        }
                                        ?>
                                    </ul>
                                </div>
                            </div>


                            <div id="sales_material" style="width: 100%; height: 350px;"></div>
                        </div>
                    </div>
                </div>
                <script>
                    document.addEventListener("DOMContentLoaded", function() {
                        let fromDateInput = document.getElementById("fromDate");
                        let toDateInput = document.getElementById("toDate");

                        // Get today's date in YYYY-MM-DD format
                        let today = new Date();
                        let todayStr = today.toISOString().split('T')[0];

                        // Get date 1 month ago
                        let pastDate = new Date();
                        pastDate.setMonth(today.getMonth() - 1);
                        let pastDateStr = pastDate.toISOString().split('T')[0];

                        // Set default values for "From Date" and "To Date"
                        fromDateInput.value = pastDateStr;
                        toDateInput.value = todayStr;

                        // Set max limit for "From Date" (future dates not allowed)
                        fromDateInput.setAttribute("max", todayStr);

                        // Ensure "To Date" is within the allowed range
                        toDateInput.setAttribute("min", pastDateStr);
                        toDateInput.setAttribute("max", todayStr);

                        // Event listener for "From Date" selection or manual entry
                        fromDateInput.addEventListener("change", function() {
                            let selectedFromDate = new Date(fromDateInput.value);

                            // Check if the manually entered date is in the future
                            if (selectedFromDate > today) {
                                alert("Future dates are not allowed in 'From Date'. Resetting to 1 month ago.");
                                fromDateInput.value = pastDateStr; // Reset to 1 month ago
                            }

                            // Adjust "To Date" limits
                            toDateInput.setAttribute("min", fromDateInput.value);
                            toDateInput.setAttribute("max", todayStr);

                            // Reset "To Date" if it's out of range
                            if (new Date(toDateInput.value) < selectedFromDate || new Date(toDateInput.value) > today) {
                                toDateInput.value = todayStr;
                            }
                        });



                        toDateInput.addEventListener("change", function() {
                            let selectedFromDate = new Date(fromDateInput.value);
                            let selectedToDate = new Date(toDateInput.value);

                            if (selectedToDate < selectedFromDate) {

                                toDateInput.value = fromDateInput.value;
                            }
                        });

                        // Default: Select all portfolios
                        let checkboxes = document.querySelectorAll(".multi-checkbox");
                        checkboxes.forEach(cb => cb.checked = true);

                        // Update chart on load with all selected portfolios
                        updateSelection();
                    });


                    function toggleDropdown() {
                        let dropdownMenu = document.querySelector(".multiselect-options");
                        dropdownMenu.style.display = dropdownMenu.style.display === "block" ? "none" : "block";
                    }

                    // Close dropdown when clicking outside
                    document.addEventListener("click", function(event) {
                        let container = document.querySelector(".multiselect-container");
                        if (!container.contains(event.target)) {
                            document.querySelector(".multiselect-options").style.display = "none";
                        }
                    });

                    // Search filter for dropdown options
                    function filterOptions() {
                        let searchBox = document.getElementById("searchBox").value.toLowerCase();
                        let options = document.querySelectorAll(".multiselect-options ul li");

                        options.forEach(option => {
                            let label = option.textContent.toLowerCase();
                            option.style.display = label.includes(searchBox) ? "block" : "none";
                        });
                    }

                    // Select/Deselect All
                    function selectAllToggle(selectAllCheckbox) {
                        let checkboxes = document.querySelectorAll(".multi-checkbox");
                        checkboxes.forEach(checkbox => checkbox.checked = selectAllCheckbox.checked);
                        updateSelection();
                    }

                    // Update selected text
                    function updateSelection() {
                        let selectedOptions = [];
                        document.querySelectorAll(".multi-checkbox:checked").forEach(checkbox => {
                            selectedOptions.push(checkbox.parentNode.textContent.trim());
                        });

                        document.getElementById("selectedText").innerText = selectedOptions.length > 0 ? selectedOptions.join(", ") : "Select Portfolios";
                    }
                </script>
                <script>
                    document.addEventListener("DOMContentLoaded", function() {
                        document.getElementById("fromDate").addEventListener("change", fetchGraphData);
                        document.getElementById("toDate").addEventListener("change", fetchGraphData);
                        document.querySelectorAll(".multi-checkbox").forEach(cb => cb.addEventListener("change", fetchGraphData));

                        function fetchGraphData() {
                            let fromDate = document.getElementById("fromDate").value;
                            let toDate = document.getElementById("toDate").value;

                            let selectedPortfolios = [];
                            document.querySelectorAll(".multi-checkbox:checked").forEach(checkbox => {
                                selectedPortfolios.push(checkbox.value);
                            });

                            if (selectedPortfolios.length === 0) {
                                alert("Please select at least one portfolio.");
                                return;
                            }

                            let formData = new FormData();
                            formData.append("from_date", fromDate);
                            formData.append("to_date", toDate);
                            selectedPortfolios.forEach((portfolio, index) => {
                                formData.append("salesPorfolio[]", portfolio);
                            });

                            fetch("html/ip_sales_graph.php", {
                                    method: "POST",
                                    body: formData
                                })
                                .then(response => response.json()) // Expect JSON response
                                .then(data => {
                                    //console.log("Received Data:", data); // Debugging Step 1
                                    if (data.success) {
                                        drawPortfolioGraph(data.salesData);
                                    } else {
                                        alert("No data found for the selected filters.");
                                    }
                                })
                                .catch(error => console.error("Error fetching graph data:", error));

                        }

                        function drawPortfolioGraph(salesData) {
                            google.charts.load('current', {
                                'packages': ['corechart']
                            });
                            google.charts.setOnLoadCallback(() => {
                                let chartData = [
                                    ['Portfolio', 'Total Sales']
                                ];
                                salesData.forEach(item => chartData.push([item.portfolio, parseFloat(item.sales) || 0]));

                                let data = google.visualization.arrayToDataTable(chartData);
                                let options = {
                                    title: 'Sales by Portfolio',
                                    hAxis: {
                                        title: 'Portfolio'
                                    },
                                    vAxis: {
                                        title: 'Total Sales'
                                    },
                                    legend: {
                                        position: 'none'
                                    },
                                    bar: {
                                        groupWidth: '75%'
                                    },
                                    colors: ['#4CAF50']
                                };

                                let chart = new google.visualization.ColumnChart(document.getElementById('sales_material'));
                                chart.draw(data, options);
                            });
                        }

                        // Load data on page load
                        fetchGraphData();
                    });
                </script>

            </div>

            <div class="col-md-6 d-flex">
                <div class="card p-3 flex-fill w-100 ">
                    <h5>Status</h5>
                    <br>
                    <div class="row d-flex align-items-stretch">
                        <?php
                        foreach ($card_columns as $column => $data) {
                            if (!empty($portfoliorow[$column]) && $portfoliorow[$column] == 1) {
                                $table_name = $data["table"];
                                $category_total = 0;

                                // Fetch status counts
                                $query = "SELECT LOWER(`status_fetch`) AS status_fetch, COUNT(*) AS total FROM `$table_name` GROUP BY `status_fetch`";
                                $result = mysqli_query($con, $query);

                                if (!$result) {
                                    echo "Error fetching status data: " . mysqli_error($con);
                                    continue;
                                }

                                // Initialize status counts
                                $status_counts = ["registration" => 0, "hearing" => 0, "expired" => 0];

                                while ($row = mysqli_fetch_assoc($result)) {
                                    $db_status = trim(strtolower($row["status_fetch"])); // ✅ Trim spaces + Convert to lowercase
                                    if (isset($status_counts[$db_status])) {
                                        $status_counts[$db_status] = $row["total"];
                                    }
                                }

                                // Calculate total for category
                                $category_total = array_sum($status_counts);
                                $total_portfolio += $category_total;

                                // Display card with status counts
                                echo '<div class="col-md-4 mb-3">
                            <div class="card p-3 text-white " style="background-color: ' . $colors[$index] . ';">
                                <h5>' . $data["label"] . '</h5>
                                <p>Pending: <strong>' . $status_counts["registration"] . '</strong></p>
                                <p>Hearing: <strong>' . $status_counts["hearing"] . '</strong></p>  
                                <p>Expired: <strong>' . $status_counts["expired"] . '</strong></p>
                            </div>
                          </div>';
                                $index++;
                            }
                        }
                        ?>

                        <!-- Total Portfolio Card -->
                        <div class="col-md-4 mb-3 d-flex">
                            <div class="card p-3 text-white flex-fill w-100" style="background-color: #2d3436;">
                                <h5>Total Portfolio</h5>
                                <p>Total portfolio: <strong><?php echo $total_portfolio; ?></strong></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

            <div class="row d-flex align-items-stretch">
                <!-- Last Expiring Record -->
                <div class="col-md-6 d-flex">
                    <div class="card p-3 flex-fill w-100">
                        <h5>Last Expiring Record</h5><br>
                        <?php
                        include_once 'connection.php';

                        if (!empty($queryParts)) {
                            $query = implode(" UNION ALL ", $queryParts) . " ORDER BY expiry_date ASC LIMIT 5";
                            $result = mysqli_query($con, $query);

                            echo '<table class="table">
                    <thead><tr><th>Type</th><th>Transaction ID</th><th>Name</th><th>Expiry Date</th></tr></thead>
                    <tbody>';

                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr>
                            <td>{$row['type']}</td>
                            <td>{$row['transaction_id']}</td>
                            <td>{$row['client_name']}</td>
                            <td>{$row['expiry_date']}</td>
                        </tr>";
                                }
                            } else {
                                echo "<tr><td colspan='4' class='text-center text-muted'>No data available</td></tr>";
                            }

                            echo '</tbody></table>';
                            mysqli_free_result($result);
                        } else {
                            echo "<p class='text-center text-muted'>No categories enabled to display data.</p>";
                        }
                        ?>
                    </div>
                </div>

                <!-- Last File Examination Record -->
                <div class="col-md-6 d-flex">
                    <div class="card p-3 flex-fill w-100">
                        <h5>Last File Examination Record</h5><br>
                        <?php
                        include_once 'connection.php';

                        if (!empty($queryParts)) {
                            $query = implode(" UNION ALL ", $queryParts) . " ORDER BY expiry_date DESC LIMIT 5";
                            $result = mysqli_query($con, $query);

                            echo '<table class="table">
                    <thead><tr><th>Type</th><th>Transaction ID</th><th>Name</th><th>Examination Date</th></tr></thead>
                    <tbody>';

                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr>
                            <td>{$row['type']}</td>
                            <td>{$row['transaction_id']}</td>
                            <td>{$row['client_name']}</td>
                            <td>{$row['expiry_date']}</td>
                        </tr>";
                                }
                            } else {
                                echo "<tr><td colspan='4' class='text-center text-muted'>No data available</td></tr>";
                            }

                            echo '</tbody></table>';
                            mysqli_free_result($result);
                        } else {
                            echo "<p class='text-center text-muted'>No categories enabled to display data.</p>";
                        }
                        ?>
                    </div>
                </div>
            </div>

            <div class="row d-flex align-items-stretch">
                <!-- Last Renewals Record -->
                <div class="col-md-6 d-flex">
                    <div class="card p-3 flex-fill w-100">
                        <h5>Last Renewals Record</h5><br>
                        <?php
                        include_once 'connection.php';

                        if (!empty($queryParts)) {
                            $query = implode(" UNION ALL ", $queryParts) . " ORDER BY expiry_date DESC LIMIT 5";
                            $result = mysqli_query($con, $query);

                            echo '<table class="table">
                    <thead><tr><th>Type</th><th>Transaction ID</th><th>Name</th><th>Renewals Date</th></tr></thead>
                    <tbody>';

                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr>
                            <td>{$row['type']}</td>
                            <td>{$row['transaction_id']}</td>
                            <td>{$row['client_name']}</td>
                            <td>{$row['expiry_date']}</td>
                        </tr>";
                                }
                            } else {
                                echo "<tr><td colspan='4' class='text-center text-muted'>No data available</td></tr>";
                            }

                            echo '</tbody></table>';
                            mysqli_free_result($result);
                        } else {
                            echo "<p class='text-center text-muted'>No categories enabled to display data.</p>";
                        }
                        ?>
                    </div>
                </div>

                <!-- Last Update Record -->
                <div class="col-md-6 d-flex">
                    <div class="card p-3 flex-fill w-100">
                        <h5>Last Update Record</h5><br>
                        <?php
                        include_once 'connection.php';

                        if (!empty($queryParts)) {
                            $query = implode(" UNION ALL ", $queryParts) . " ORDER BY expiry_date DESC LIMIT 5";
                            $result = mysqli_query($con, $query);

                            echo '<table class="table">
                    <thead><tr><th>Type</th><th>Transaction ID</th><th>Name</th><th>Update Date</th></tr></thead>
                    <tbody>';

                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr>
                            <td>{$row['type']}</td>
                            <td>{$row['transaction_id']}</td>
                            <td>{$row['client_name']}</td>
                            <td>{$row['expiry_date']}</td>
                        </tr>";
                                }
                            } else {
                                echo "<tr><td colspan='4' class='text-center text-muted'>No data available</td></tr>";
                            }

                            echo '</tbody></table>';
                            mysqli_free_result($result);
                        } else {
                            echo "<p class='text-center text-muted'>No categories enabled to display data.</p>";
                        }
                        ?>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card p-3">
                        <div id='EditUserDiv'></div>
                        <input type="hidden" id="showDetailStatus" value="<?php if (isset($_GET['myStatus'])) {
                                                                                echo $_GET['myStatus'];
                                                                            } ?>">
                        <input type="hidden" id="showTodayDetailStatus" value="<?php if (isset($_GET['Today'])) {
                                                                                    echo $_GET['Today'];
                                                                                } ?>">
                        <h4 align="center" class="pageHeading" id="pageHeading"><?php if (isset($str)) {
                                                                                    echo $modified_variable = str_replace("add", "",  $str);
                                                                                } ?></h4>
                        <?php
                        $current_date = date('Y-m-d');

                        // Construct the query to count the rows
                        $count_query = "SELECT COUNT(*) as count FROM trade_mark WHERE DATE(reply_fill_date) = '$current_date'";

                        // Execute the query
                        $count_result = mysqli_query($con, $count_query);

                        if ($count_result) {
                            // Fetch the count result
                            $show_count_result = mysqli_fetch_assoc($count_result);
                            $count = $show_count_result['count'];
                        } else {
                        }
                        ?>
                       <?php
                            // Database connection
                            include 'connection.php';

                            if (isset($_SESSION['company_id'])) {
                                $company_id = $_SESSION['company_id'];

                                // Fetch user data for the given company ID and user ID
                                $fetch_user_data = "SELECT * FROM `users` WHERE `company_id` = '$company_id' AND `id` = '" . $_SESSION['user_id'] . "'";
                                $run_fetch_user_data = mysqli_query($con, $fetch_user_data);
                                $user_row = mysqli_fetch_array($run_fetch_user_data);
                            }

                            // Define portfolio-related columns (Ensuring correct case)
                            $columns = [
                                "trade_mark" => "trade mark",
                                "patent" => "patent",
                                "copy_right" => "copy right",
                                "industrial_design" => "industrial design",
                                "trade_secret" => "trade secret"
                            ];

                            $data = array(); // Store chart data

                            // Fetch record counts from `date_title_data` where the status is 'pending'
                            $query = "SELECT LOWER(portfolio) AS portfolio, COUNT(*) AS record_count FROM date_title_data 
                                    WHERE title_date != 'Date of Application' AND status_title='pending' GROUP BY portfolio";
                            $result = $con->query($query);

                            while ($row = $result->fetch_assoc()) {
                                $portfolio_name = strtolower($row['portfolio']); // Ensure lowercase match
                                $record_count = (int)$row['record_count'];

                                // Check if the portfolio corresponds to a column where the value is 1 in `users`
                                foreach ($columns as $column => $label) {
                                    if (isset($user_row[$column]) && $user_row[$column] == 1 && $portfolio_name == $label) {
                                        $data[] = array(ucwords(str_replace("_", " ", $portfolio_name)), $record_count);
                                    }
                                }
                            }

                            // Convert the filtered data into JSON for Google Charts
                            $jsonTable = json_encode($data);
                            echo "<script>console.log(" . json_encode($data) . ");</script>";
                        ?>

                        <div class="container">
                            <div class="row">
                                <div class="col-md-12">

                                    <?php
                                    function generateGooglePieChart($data)
                                    {
                                        // Convert data array to JSON format
                                        $jsonTable = json_encode($data);

                                        $colors = ['blue', 'green', 'red', 'yellow', 'orange', 'purple', 'pink', 'brown', 'grey'];

                                        // HTML and JavaScript to render the chart
                                        echo '
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load(\'current\', {\'packages\':[\'corechart\']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = new google.visualization.DataTable();
        data.addColumn(\'string\', \'Category\');
        data.addColumn(\'number\', \'Record Count\');
        data.addRows(' . $jsonTable . ');

        var options = {
          title: \'Record Count by Category\',
          width: \'100%\',
          height: 400,
          chartArea: { width: \'80%\', height: \'75%\' }
        };

        var chart = new google.visualization.PieChart(document.getElementById(\'piechart_div\'));
        chart.draw(data, options);

        // Add click event listener to handle click on chart slices
         google.visualization.events.addListener(chart, \'select\', function() {
        var selectedItem = chart.getSelection()[0];
        if (selectedItem) {
            var category = data.getValue(selectedItem.row, 0); // Get the category
            fetchData(category); // Fetch data using AJAX
        }
    });

        // Fetch data based on initial URL parameters if present
        var urlParams = new URLSearchParams(window.location.search);
        var categoryParam = urlParams.get(\'category\');
        if (categoryParam) {
            fetchData(categoryParam);
        }
      }

      function fetchData(category) {
        var xhr = new XMLHttpRequest();
        xhr.open(\'POST\', \'html/fetch_data_ip_dashboard_port.php\', true);
        xhr.setRequestHeader(\'Content-Type\', \'application/x-www-form-urlencoded\');
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                // Handle the response from the server
                var response = JSON.parse(xhr.responseText);
                displayData(response, category);
            }
        };
        xhr.send(\'category=\' + encodeURIComponent(category));
      }

      function displayData(data, category) {
        var dataContainer = document.getElementById(\'data_container\');
        dataContainer.innerHTML = \'\';

        var colors = ' . json_encode($colors) . ';
        var colorIndex = 0;

        if (data.length > 0) {
            var row = document.createElement(\'div\');
            row.className = \'row\';

            for (var i = 0; i < data.length; i++) {
                var titleDate = data[i].title_date || \'No Date\';
                var col = document.createElement(\'div\');
                col.className = \'col-md-4 mb-3 d-flex\';  // Adjust the column size as needed

                // Cycle through colors
                var color = colors[colorIndex];
                colorIndex = (colorIndex + 1) % colors.length;

                col.innerHTML = \'<div class="rectangle \' + color + \'" data-title-date="\' + titleDate + \'" data-category="\' + category + \'">\' +
                                    \'<div class="inner-content">\' +
                                        \'<div class="total-users">\' + data[i].record_count + \'</div>\' +
                                        \'<div class="label">\' + titleDate + \'</div>\' +
                                    \'</div>\' +
                                \'</div>\';
                row.appendChild(col);
            }

            dataContainer.appendChild(row);

            // Add event listener for the rectangles
            var rectangles = document.getElementsByClassName(\'rectangle\');
            for (var j = 0; j < rectangles.length; j++) {
                rectangles[j].addEventListener(\'click\', function() {
                    var titleDate = this.getAttribute(\'data-title-date\');
                    var category = this.getAttribute(\'data-category\');
                    var newUrl = \'ip_dashboard?category=\' + encodeURIComponent(category) + \'&titleDate=\' + encodeURIComponent(titleDate);
                    window.history.pushState({ path: newUrl }, \'\', newUrl);
                    window.location.reload();
                });
            }
        } else {
            dataContainer.innerHTML = \'<div class="alert alert-info" role="alert">No data available for this category.</div>\';
        }
      }
    </script>
    <div class="row d-flex align-items-stretch">
        <div class="col-md-6 d-flex">
            <div class="card p-3 flex-fill w-100">
                <div id="piechart_div" class="mt-3"></div>
            </div>
        </div>
        <div class="col-md-6 d-flex">
            <div class="card p-3 flex-fill w-100 ">
                <div id="data_container" class="mt-3 h-100"></div>
            </div>
        </div>
    </div>
    ';

                                        // Add inline CSS for rectangle colors
                                        echo '
    <style>
      .rectangle.blue { background-color: #1e90ff; }
      .rectangle.green { background-color: #2ecc71; }
      .rectangle.red { background-color: #e84118; }
      .rectangle.yellow { background-color: #f1c40f; }
      .rectangle.orange { background-color: #ff9f43; }
      .rectangle.purple { background-color: #8e44ad; }
      .rectangle.pink { background-color: #f368e0; }
      .rectangle.brown { background-color: #e84118; }
      .rectangle.grey { background-color: #34495e; }
      .rectangle {
        padding:25px;
        height: 90%;
        border-radius: 5px;
        color: #fff;
        cursor: pointer;
        display: flex;
        margin:0px;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        margin-bottom:20%;
      }
      .inner-content {
        text-align: center;
        margin-bottom:none;
      }
      .total-users {
        font-size: 26px;
        font-weight: bold;
        margin-bottom:-25%;
        margin-top:-17%;
      }
      .label {
        font-size: 18px;
        line-height: normal;
      }   
    </style>
    ';
                                    }
                                    // Call the function with the data retrieved from MySQL
                                    generateGooglePieChart($data);
                                    ?>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card p-3">
                                <?php
                                if (isset($_GET['category'])) {
                                    $_GET['category'];
                                    $cat = $_GET['category']; // Assign category to variable $cat
                                }

                                if (isset($_GET['titleDate'])) {
                                    // $_GET['titleDate'] can be an array if multiple parameters are passed with the same name
                                    if (is_array($_GET['titleDate'])) {
                                        foreach ($_GET['titleDate'] as $date) {
                                            echo $date . "<br>";
                                            $date_val = $_GET['titleDate'];
                                            // Construct and execute your SQL query
                                            $display_date_data = "SELECT * FROM date_title_data WHERE portfolio='$cat' and title_date='$date_val'";
                                            if ($result) {
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    // Access columns from $row as needed
                                                    $row['transaction_id']; // Example of accessing a column

                                                    // Assuming $row['transaction_id'] is used directly instead of $client_name_fees
                                                    $transaction_id = $row['transaction_id'];

                                                    // Construct your SQL query based on $transaction_id
                                                    $fetchIdForServiceId = "";
                                                    $ViewPageForServiceId = "";

                                                    // Example switch statement to determine SQL query based on $transaction_id
                                                    switch ($transaction_id) {
                                                        case 'TRD':
                                                            $fetchIdForServiceId = "SELECT DISTINCT tr.transaction_id, tr.tax_invoice_number, tr.retail_invoice_number, 
                                tr.client_name, tr.status_fetch, tr.id, tr.modify_by, tr.modify_date
                                FROM `trade_mark` tr
                                JOIN `date_title_data` dt ON tr.transaction_id = dt.transaction_id
                                WHERE tr.transaction_id = '" . $transaction_id_full . "' 
                                  AND dt.status_title = 'pending' 
                                  AND dt.date_time = '$current_date' 
                                  AND dt.title_date = '$date_val'
                                LIMIT 1";
                                                            $count_result = mysqli_query($con, $fetchIdForServiceId);
                                                            $ViewPageForServiceId = 'View_Trade_mark';
                                                            $ViewPageForServiceId_page = 'intell_trademark';
                                                            break;

                                                        case 'PTN':
                                                            $fetchIdForServiceId = "SELECT DISTINCT tr.transaction_id, tr.tax_invoice_number, tr.retail_invoice_number, 
                                tr.client_name, tr.status_fetch, tr.id, tr.modify_by, tr.modify_date
                                FROM `patent` tr
                                JOIN `date_title_data` dt ON tr.transaction_id = dt.transaction_id
                                WHERE tr.transaction_id = '" . $transaction_id_full . "' 
                                  AND dt.status_title = 'pending' 
                                  AND dt.date_time = '$current_date' 
                                  AND dt.title_date = '$date_val'
                                LIMIT 1";
                                                            $count_result = mysqli_query($con, $fetchIdForServiceId);
                                                            $ViewPageForServiceId = 'View_patent';
                                                            $ViewPageForServiceId_page = 'intell_patent';
                                                            break;

                                                        case 'COP':
                                                            $fetchIdForServiceId = "SELECT DISTINCT tr.transaction_id, tr.tax_invoice_number, tr.retail_invoice_number, 
                                tr.client_name, tr.status_fetch, tr.id, tr.modify_by, tr.modify_date
                                FROM `copy_right` tr
                                JOIN `date_title_data` dt ON tr.transaction_id = dt.transaction_id
                                WHERE tr.transaction_id = '" . $transaction_id_full . "' 
                                  AND dt.status_title = 'pending' 
                                  AND dt.date_time = '$current_date' 
                                  AND dt.title_date = '$date_val'
                                LIMIT 1";
                                                            $count_result = mysqli_query($con, $fetchIdForServiceId);
                                                            $ViewPageForServiceId = 'View_copy_right';
                                                            $ViewPageForServiceId_page = 'intell_copyright';
                                                            break;

                                                        case 'TRS':
                                                            $fetchIdForServiceId = "SELECT DISTINCT tr.transaction_id, tr.tax_invoice_number, tr.retail_invoice_number, 
                                tr.client_name, tr.status_fetch, tr.id, tr.modify_by, tr.modify_date
                                FROM `trade_secret` tr
                                JOIN `date_title_data` dt ON tr.transaction_id = dt.transaction_id
                                WHERE tr.transaction_id = '" . $transaction_id_full . "' 
                                  AND dt.status_title = 'pending' 
                                  AND dt.date_time = '$current_date' 
                                  AND dt.title_date = '$date_val'
                                LIMIT 1";
                                                            $count_result = mysqli_query($con, $fetchIdForServiceId);
                                                            $ViewPageForServiceId = 'View_tradesecret';
                                                            $ViewPageForServiceId_page = 'intell_tradesecret';
                                                            break;

                                                        case 'IDS':
                                                            $fetchIdForServiceId = "SELECT DISTINCT tr.transaction_id, tr.tax_invoice_number, tr.retail_invoice_number, 
                                tr.client_name, tr.status_fetch, tr.id, tr.modify_by, tr.modify_date
                                FROM `industrial_design` tr
                                JOIN `date_title_data` dt ON tr.transaction_id = dt.transaction_id
                                WHERE tr.transaction_id = '" . $transaction_id_full . "' 
                                  AND dt.status_title = 'pending' 
                                  AND dt.date_time = '$current_date' 
                                  AND dt.title_date = '$date_val'
                                LIMIT 1";
                                                            $count_result = mysqli_query($con, $fetchIdForServiceId);
                                                            $ViewPageForServiceId = 'View_industrial_design';
                                                            $ViewPageForServiceId_page = 'industrial_design';
                                                            break;

                                                        default:
                                                            // Handle default case or unknown transaction_id
                                                            break;
                                                    }
                                                    // Execute SQL query and fetch data
                                                }
                                            } else {
                                                // Handle the case where $result is false or query execution fails
                                                echo "Error executing query: " . mysqli_error($con);
                                            }
                                        }
                                    } else {
                                        // Handle single value if needed
                                        $date_val = $_GET['titleDate'];
                                        // Construct and execute your SQL query for single value
                                        $display_date_data = "SELECT * FROM date_title_data WHERE portfolio='$cat' and title_date='$date_val'";
                                        // Assuming you want to execute the query here, but consider using prepared statements for security
                                        $result = mysqli_query($con, $display_date_data); // Replace $your_db_connection with your actual database connection variable
                                        // // Handle the result as needed

                                        if ($result && mysqli_num_rows($result) > 0) {
                                ?>
                                            <table class="table-striped" id="otherServicesTable">
                                                <thead class="bg-white">
                                                    <?php if ($_SESSION['user_type'] == 'system_user') { ?>
                                                        <th class="tableDate">
                                                            <!-- Checkbox or other elements for system users -->
                                                        </th>
                                                        <th class="tableDate">Action</th>
                                                    <?php } ?>
                                                    <th class="txt">Service Id</th>
                                                     <th class="txt">Recipient Name</th>
                                                    <th class="txt">Date Type</th>
                                                    <th class="txt">Status</th>
                                                    <!--<th>User</th>-->
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $current_date = date('Y-m-d');
                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                        // Access columns from $row as needed
                                                        $transaction_id_full = $row['transaction_id'];
                                                        $transaction_parts = explode('_', $transaction_id_full);
                                                        $transaction_id = $transaction_parts[1];

                                                        // Construct your SQL query based on $transaction_id
                                                        $fetchIdForServiceId = "";
                                                        $count_result = null;
                                                        $ViewPageForServiceId = "";

                                                        $groupByClause = "GROUP BY tr.transaction_id, dt.transaction_id";

                                                        switch ($transaction_id) {
                                                            case 'TRD':
                                                                $fetchIdForServiceId = "SELECT tr.id as id, dt.title_date, tr.transaction_id, 
                                       tr.tax_invoice_number, tr.retail_invoice_number, 
                                       tr.client_name, tr.status_fetch, tr.modify_by, 
                                       tr.modify_date
                                FROM `trade_mark` tr
                                JOIN `date_title_data` dt ON tr.transaction_id = dt.transaction_id
                                WHERE tr.transaction_id = '" . $transaction_id_full . "' 
                                  AND dt.status_title = 'pending' 
                                  AND dt.title_date = '$date_val'
                                $groupByClause";
                                                                $ViewPageForServiceId = 'View_Trade_mark';
                                                                $ViewPageForServiceId_page = 'intell_trademark';
                                                                break;

                                                            case 'PTN':
                                                                $fetchIdForServiceId = "SELECT dt.title_date, tr.transaction_id, 
                                       tr.tax_invoice_number, tr.retail_invoice_number, 
                                       tr.client_name, tr.status_fetch, tr.id, 
                                       tr.modify_by, tr.modify_date
                                FROM `patent` tr
                                JOIN `date_title_data` dt ON tr.transaction_id = dt.transaction_id
                                WHERE tr.transaction_id = '" . $transaction_id_full . "' 
                                  AND dt.status_title = 'pending' 
                                  AND dt.title_date = '$date_val'
                                $groupByClause";
                                                                $ViewPageForServiceId = 'View_patent';
                                                                $ViewPageForServiceId_page = 'intell_patent';
                                                                break;

                                                            case 'COP':
                                                                $fetchIdForServiceId = "SELECT dt.title_date, tr.transaction_id, 
                                       tr.tax_invoice_number, tr.retail_invoice_number, 
                                       tr.client_name, tr.status_fetch, tr.id, 
                                       tr.modify_by, tr.modify_date
                                FROM `copy_right` tr
                                JOIN `date_title_data` dt ON tr.transaction_id = dt.transaction_id
                                WHERE tr.transaction_id = '" . $transaction_id_full . "' 
                                  AND dt.status_title = 'pending' 
                                  AND dt.title_date = '$date_val'
                                $groupByClause";
                                                                $ViewPageForServiceId = 'View_copy_right';
                                                                $ViewPageForServiceId_page = 'intell_copyright';
                                                                break;

                                                            case 'TRS':
                                                                $fetchIdForServiceId = "SELECT dt.title_date, tr.transaction_id, 
                                       tr.tax_invoice_number, tr.retail_invoice_number, 
                                       tr.client_name, tr.status_fetch, tr.id, 
                                       tr.modify_by, tr.modify_date
                                FROM `trade_secret` tr
                                JOIN `date_title_data` dt ON tr.transaction_id = dt.transaction_id
                                WHERE tr.transaction_id = '" . $transaction_id_full . "' 
                                  AND dt.status_title = 'pending' 
                                  AND dt.title_date = '$date_val'
                                $groupByClause";
                                                                $ViewPageForServiceId = 'View_tradesecret';
                                                                $ViewPageForServiceId_page = 'intell_tradesecret';
                                                                break;

                                                            case 'IDS':
                                                                $fetchIdForServiceId = "SELECT dt.title_date, tr.transaction_id, 
                                       tr.tax_invoice_number, tr.retail_invoice_number, 
                                       tr.client_name, tr.status_fetch, tr.id, 
                                       tr.modify_by, tr.modify_date
                                FROM `industrial_design` tr
                                JOIN `date_title_data` dt ON tr.transaction_id = dt.transaction_id
                                WHERE tr.transaction_id = '" . $transaction_id_full . "' 
                                  AND dt.status_title = 'pending' 
                                  AND dt.title_date = '$date_val'
                                $groupByClause";
                                                                $ViewPageForServiceId = 'View_industrial_design';
                                                                $ViewPageForServiceId_page = 'industrial_design';
                                                                break;

                                                            default:
                                                                echo "Unknown transaction type.";
                                                                break;
                                                        }


                                                        // Execute the query
                                                        $count_result = mysqli_query($con, $fetchIdForServiceId);

                                                        // Check and fetch data rows
                                                        if ($count_result && mysqli_num_rows($count_result) > 0) {
                                                            while ($row = mysqli_fetch_assoc($count_result)) {
                                                    ?>
                                                                <tr>
                                                                    <?php if ($_SESSION['user_type'] == 'system_user') { ?>
                                                                        <td>
                                                                            <form method="post" action="<?php echo $ViewPageForServiceId_page; ?>" target="_blank" class="inline-form">
                                                                                <input type="hidden" name="other_serviceEditID" value="<?= htmlspecialchars($row['id']); ?>">
                                                                                <button class="editOtherServicebtn mr-2" name="editOtherServicebtn" id="editOtherServicebtn" style="padding: 0; border: none; background: none;" data-toggle="tooltip" data-placement="top" title="Edit">
                                                                                    <i class="fas fa-pencil-alt fa-lg" style="color:green;"></i>
                                                                                </button>
                                                                            </form>
                                                                        </td>
                                                                    <?php } ?>
                                                                    <td class="ttext"><?= htmlspecialchars($row['transaction_id']); ?></td>
                                                                    <td>
                                                                        <form method="post" action="<?= $ViewPageForServiceId; ?>" target="_blank" style="display: inline;">
                                                                            <input type="hidden" name="ViewID" id="ViewID" value="<?= htmlspecialchars($row['id']); ?>">
                                                                            <button type="submit" name="viewOtherServiceDetailbtn" id="viewOtherServiceDetailbtn"
                                                                                style="padding: 0; border: none; background: none; color: blue; text-decoration: underline; cursor: pointer;">
                                                                                <?= htmlspecialchars($row['transaction_id']); ?>
                                                                            </button>
                                                                        </form>
                                                                    </td>
                                                                    <td class="ttext"><?= htmlspecialchars($row['client_name']); ?></td>
                                                                    <td class="ttext"><?= htmlspecialchars($row['title_date']); ?></td>
                                                                    <td class="ttext"><?= htmlspecialchars($row['status_fetch']); ?></td>
                                                                </tr>
                                                    <?php
                                                            }
                                                        }

                                                        // End of while loop for count_result
                                                    } // End of while loop for $result
                                                    ?>
                                                </tbody>
                                            </table>

                                <?php
                                        } else {
                                            // Handle the case where $result is false or query execution fails
                                            echo "Error executing query: " . mysqli_error($con);
                                        }
                                    }
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
</body>

</html>

<?php include_once 'ltr/header-footer.php'; ?>