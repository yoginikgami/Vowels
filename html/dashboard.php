<?php
// Include the header and database connection
include_once 'ltr/header.php';
include 'connection.php';

// Check if session variables are set
if (isset($_SESSION['company_id'])) {
    $company_id = $_SESSION['company_id'];

    // Fetch user data for the given company ID and user ID
    $fetch_user_data = "SELECT * FROM `users` WHERE `company_id` = '$company_id' AND `id` = '" . $_SESSION['user_id'] . "'";
    $run_fetch_user_data = mysqli_query($con, $fetch_user_data);
    $row = mysqli_fetch_array($run_fetch_user_data);
}

//Queries to calculate totals
$incomeQuery = "SELECT SUM(amount) AS totalIncome FROM advance WHERE payment_mode_pay = 'Recived'";
$expenseQuery = "SELECT SUM(amount) AS totalExpense FROM advance WHERE payment_mode_pay = 'Paid'";

// Execute queries and fetch results
$incomeResult = $con->query($incomeQuery);
$expenseResult = $con->query($expenseQuery);

if ($incomeResult && $expenseResult) {
    $total_income = $incomeResult->fetch_assoc()['totalIncome'] ?? 0;
    $total_expense = $expenseResult->fetch_assoc()['totalExpense'] ?? 0;
    $profit = $total_income - $total_expense;
} else {
    // Log error if query fails
    error_log("Database query failed: " . $con->error);
}

$productQuery = "SELECT company_id, product_name FROM product_list GROUP BY product_name";
$productResult = $con->query($productQuery);
$products = [];
while ($row = $productResult->fetch_assoc()) {
    $products[] = $row;
}

if (isset($_SESSION['company_id'])) {
    $company_id = $_SESSION['company_id'];
    // Fetch user data for the given company ID and user ID
    $fetch_user_data = "SELECT * FROM `users` WHERE `company_id` = '$company_id' AND `id` = '" . $_SESSION['user_id'] . "'";
    $run_fetch_user_data = mysqli_query($con, $fetch_user_data);
    $row = mysqli_fetch_array($run_fetch_user_data);
}
// Default card order if user has no custom order
$default_order = [
    'sales_report_graph',
    'income_expense',
    'search_client',
    'attendance_report',
    'payment_received',
    'payment_paid',
    'trading_inventory'
];
// Define permission-based visibility
$sections = [];

if (($row['type'] == 1) || ($row['esp_latest_sales'] == 1)) {
    $sections[] = 'sales_report_graph';
}
if (($row['type'] == 1) || ($row['esp_income_expense'] == 1)) {
    $sections[] = 'income_expense';
}
if (($row['type'] == 1) || ($row['esp_attendence_graph'] == 1)) {
    $sections[] = 'attendance_report';
}
if (($row['type'] == 1) || ($row['esp_search_client'] == 1)) {
    $sections[] = 'search_client';
}
if (($row['type'] == 1) || ($row['esp_payment_received'] == 1)) {
    $sections[] = 'payment_received';
}
if (($row['type'] == 1) || ($row['esp_payment_paid'] == 1)) {
    $sections[] = 'payment_paid';
}
if (($row['type'] == 1) || ($row['esp_trading_invent'] == 1)) {
    $sections[] = 'tranding_invent';
}
if ($row['payment'] == 1 || $row['settlement'] == 1 || $row['expense'] == 1 || $row['contra_voucher'] == 1) {
    $sections[] = 'income_expense';
    $sections[] = 'payment_received';
    $sections[] = 'payment_paid';
}
if($row['payroll'] == 1){
    $sections[] = 'attendance_report';   
}

// List of dropdown menu items to check
$columns = [
    "pan" => "pan",
    "tan" => "tan",
    "e_tds" => "e_tds",
    "it_returns" => "it_returns",
    "e_tender" => "e_tender",
    "gst" => "gst_fees",
    "dsc_subscriber" => "dsc_subscriber",
    "dsc_reseller" => "dsc_reseller",
    "other_services" => "other_services",
    "psp" => "psp",
    "trade_mark" => "trade_mark",
    "patent" => "patent",
    "copy_right" => "copy_right",
    "industrial_design" => "industrial_design",
    "trade_secret" => "trade_secret",
    "legal_notice" => "advocade_case"
];

$dropdown_options = [];
foreach ($columns as $col) {
    if (isset($row[$col]) && $row[$col] == 1) {
        $dropdown_options[$col] = $col;
    }
}
$multiple_dropdown = $dropdown_options;
$clientmaster = $dropdown_options;
if (isset($row['gst']) && $row['gst'] == 1) {
    
    $dropdown_options['gst_fees'] = 'gst_fees'; 
    $multiple_dropdown['gst_fees'] = 'gst_fees';
    $clientmaster['gst_fees'] = 'gst_fees'; 
}
if (isset($row['legal_notice']) && $row['legal_notice'] == 1) {
    $dropdown_options['advocate_case'] = 'advocate_case'; 
    $multiple_dropdown['advocate_case'] = 'advocate_case';
    $clientmaster['advocate_case'] = 'advocate_case'; 
}

$sections = array_unique($sections);

// Fetch user-defined order if available
if (!empty($row['display_order'])) {
    $custom_order = explode(',', $row['display_order']);

    // Keep only sections that the user has permission for
    $ordered_sections = array_intersect($custom_order, $sections);

    // Append any missing sections that were not in user preference
    $sections = array_merge($ordered_sections, array_diff($sections, $custom_order));
} else {
    $sections = array_merge(array_intersect($default_order, $sections), array_diff($sections, $default_order));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interactive Dashboard</title>

    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom File Input CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bs-custom-file-input/dist/bs-custom-file-input.min.css" rel="stylesheet">

    <!-- Chosen CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.min.css" />

    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet">

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Bootstrap JS Bundle -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.bundle.min.js"></script>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- bsCustomFileInput JS -->
    <script src="https://cdn.jsdelivr.net/npm/bs-custom-file-input/dist/bs-custom-file-input.min.js"></script>

    <!-- Chosen JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.jquery.min.js"></script>

    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <!-- Include DataTable CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.2.1/css/dataTables.dataTables.min.css">

    <!-- Include DataTable JS -->
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/2.2.1/js/dataTables.min.js"></script>


    <style>
        .form-control:disabled,
        .form-control[readonly] {
            height: 35px;
        }

        label {
            margin-bottom: 0;
            /* Removes extra space below label */
        }

        input,
        select {
            height: 36px;
            /* Adjust input height for consistency */
        }

        .page-wrapper>.container-fluid {
            padding: 5px;
            min-height: calc(100vh - 180px);
        }

        .multiselect-dropdown-list {
            max-height: 200px;
            /* Set the maximum height for the dropdown */
            max-width: 25%;
            position: absolute;
            overflow-y: auto;
            /* Enable vertical scrolling */
            overflow-x: hidden;
            /* Disable horizontal scrolling */
            border: 1px solid #ccc;
            z-index: 1050;
            /* Optional: Add a border for better visibility */
            padding: 10px;
            /* Optional: Add some padding for better spacing */
            background: white;
        }

        .multiselect-dropdown-search {
            width: 100%;
            /* Make the search input take up the full width */
            margin-bottom: 10px;
            /* Add space below the search input */
            padding: 5px;
            /* Add padding inside the search box */
            border: 1px solid #ccc;
            /* Add a border to match the dropdown */
            border-radius: 4px;
            /* Round the corners */
        }

        .hide {
            display: none;
            /* Keep this class to hide the dropdown initially */
        }

        /* table */
        table {
            width: 100%;
            border-collapse: collapse;
            font-family: Arial, sans-serif;
            border: 1px solid #ccc;
            border-radius: 10px;
            /* Rounded corners for the entire table */
            overflow: hidden;
            /* Ensures the border-radius works properly */
        }

        thead {
            background-color: #218125;
            text-align: left;
            color: white;
        }

        th,
        td {
            padding: 5px;
            border: 0px solid #ccc;
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

        .col-md-6 {
            flex: 1;
            padding: 15px;
        }

        .card {
            height: 100%;
            display: flex;
            flex-direction: column;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            background-color: #fff;
            margin-bottom: 0px;
        }

        .card-body {
            -ms-flex: 1 1 auto;
            flex: 1 1 auto;
            min-height: 1px;
            padding: 1rem;
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

        .row {
            margin-bottom: 0.1rem;
            /* Reduced gap between rows */
        }

        .col-sm-3,
        .col-sm-4 {
            font-weight: bold;
        }

        .mb-3,
        .my-3 {
            margin-bottom: 0.2rem !important;
        }

        .form-control {
            border-radius: 0.25rem;
        }

        .sm-4 {
            padding-right: 0.01rem !important;
        }

        .pb-4,
        .py-4 {
            padding-bottom: 0.01rem !important;
            padding-top: 0.01rem !important;
        }

        /* Container for the toggle */
        .toggle-switch {
            position: relative;
            display: inline-block;
            width: 50px;
            height: 24px;
        }

        /* Hide the default checkbox */
        .toggle-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        /* The track */
        .slider {
            position: absolute;
            cursor: pointer;
            background-color: #ccc;
            border-radius: 12px;
            /* Rounded corners for the track */
            width: 100%;
            height: 100%;
            transition: background-color 0.3s;
        }

        /* The circular slider */
        .slider::before {
            content: "";
            position: absolute;
            height: 16px;
            width: 16px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            border-radius: 50%;
            transition: transform 0.3s;
        }

        /* Toggled state (when the checkbox is checked) */
        .toggle-switch input:checked+.slider {
            background-color: #4caf50;
            /* Green when toggled */
        }

        .toggle-switch input:checked+.slider::before {
            transform: translateX(26px);
            /* Move slider to the right */
        }
    </style>
</head>
<body>
    <div class="container-fluid py-4">
        <div class="row g-3">
            <?php foreach ($sections as $index => $section) { ?>
                <div class="col-md-6">
                    <div class="card p-3">
                        <?php if ($section == 'sales_report_graph') { ?>
                            <!-- Toggle Switch -->
                            <label class="toggle-switch square">
                                <input type="checkbox" id="chartToggle" class="chart-toggle">
                                <span class="slider"></span>
                            </label>
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <h5>Sales Report</h5>
                                <!-- Buttons to filter data -->
                                <div class="button-group">
                                    <button class="btn btn-primary" data-sales="today_sale">Today</button>
                                    <button class="btn btn-secondary" data-sales="week_sale">Week</button>
                                    <button class="btn btn-success" data-sales="month_sale">Month</button>
                                    <button class="btn btn-warning" data-sales="year_sale">Year</button>
                                </div>
                            </div>
                            <div class="container">
                                <select id="portfolio" multiple style="width: 70%;">
                                    <?php foreach ($dropdown_options as $value => $label): ?>
                                        <option value="<?= htmlspecialchars($value); ?>"><?= htmlspecialchars($label); ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <div id="salesResults"></div>
                            </div>
                            <canvas id="salesChart1" style="width: 100%; height: 400px;"></canvas>
                            <canvas id="salesChart" style="width: 100%; height: 200px; display: none;"></canvas>

                            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                            <script>
                                let selectedFilter = 'year_sale'; // Default filter is year_sale
                                let salesChart = null; // Declare chart globally
                                let chartType = 'line'; // Default chart type is line

                                // Event listener for the filter buttons
                                document.querySelectorAll('.button-group button').forEach(button => {
                                    button.addEventListener('click', function() {
                                        selectedFilter = this.getAttribute('data-sales');
                                        fetchSalesData();
                                    });
                                });
                                document.addEventListener('DOMContentLoaded', () => {
                                    // Automatically select the 'Year' filter button
                                    document.querySelector('[data-sales="year_sale"]').click();

                                    // Select all options in the portfolio dropdown
                                    const portfolio = document.getElementById('portfolio');
                                    for (let i = 0; i < portfolio.options.length; i++) {
                                        portfolio.options[i].selected = true;
                                    }
                                    // Fetch data on page load with default settings
                                    fetchSalesData();
                                });
                                // Event listener for the toggle chart type button
                                document.getElementById('chartToggle').addEventListener('change', function() {
                                    // Toggle the chart type between 'line' and 'bar'
                                    chartType = this.checked ? 'bar' : 'line';

                                    // Re-fetch the sales data and update the chart
                                    fetchSalesData();
                                });

                                function fetchSalesData() {
                                    const selectedTables = Array.from(document.getElementById('portfolio').selectedOptions).map(option => option.value);

                                    if (selectedTables.length === 0) {
                                        const options = portfolio.options;
                                        for (let i = 0; i < options.length; i++) {
                                            options[i].selected = true; // Select all options
                                        }
                                    }
                                    const requestData = {
                                        filter: selectedFilter,
                                        tables: selectedTables
                                    };
                                    fetch('html/fetch_sales.php', {
                                            method: 'POST',
                                            headers: {
                                                'Content-Type': 'application/json'
                                            },
                                            body: JSON.stringify(requestData),
                                        })
                                        .then(response => response.json())
                                        .then(data => {
                                            updateChart(data);
                                        })
                                        .catch(error => {
                                            console.error('Error:', error);
                                        });
                                }

                                function updateChart(data) {
                                    const labels = Object.keys(data).filter(key => key !== 'total_sales');
                                    const salesData = labels.map(label => parseFloat(data[label].replace(/[^0-9.-]+/g, "")) || 0);

                                    if (salesChart) {
                                        salesChart.destroy(); // Destroy the previous chart
                                    }
                                    const chartData = {
                                        labels: labels,
                                        datasets: [{
                                            label: 'Sales Fees',
                                            data: salesData,
                                            backgroundColor: [
                                                '#FF6384', '#36A2EB', '#FFCE56', '#38a832', '#ff1a1a', '#88cc00',
                                                '#4d79ff', '#bf8040', '#ff4d94', '#FF6384', '#36A2EB', '#FFCE56'
                                            ],
                                            borderColor: '#36A2EB',
                                            tension: 0.1
                                        }]
                                    };
                                    const config = {
                                        type: chartType, // Dynamic chart type (line or bar)
                                        data: chartData,
                                        options: {
                                            responsive: true,
                                            scales: {
                                                y: {
                                                    beginAtZero: true,
                                                    ticks: {
                                                        callback: function(value) {
                                                            return value.toLocaleString();
                                                        }
                                                    }
                                                },
                                            },
                                            plugins: {
                                                legend: {
                                                    position: 'top',
                                                },
                                                title: {
                                                    display: true,
                                                    text: 'Sales Report'
                                                }
                                            }
                                        }
                                    };
                                    salesChart = new Chart(document.getElementById('salesChart'), config);
                                    // Toggle visibility between different charts
                                    document.getElementById('salesChart1').style.display = 'none';
                                    document.getElementById('salesChart').style.display = 'block';
                                }
                            </script>
                        <?php } elseif ($section == 'income_expense') { ?>
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <h5>Income & Expense</h5>
                                <div class="button-group">
                                    <button class="btn btn-primary filter-button" data-time="Today">Today</button>
                                    <button class="btn btn-secondary filter-button" data-time="Week">Week</button>
                                    <button class="btn btn-success filter-button" data-time="Month">Month</button>
                                    <button class="btn btn-warning filter-button" data-time="Year">Year</button>
                                </div>
                            </div>
                            <br>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <div class="card text-center p-3 bg-light-green shadow-sm">
                                        <h6 class="text-muted">Total Income</h6>
                                        <h5 class="fw-bold text-success" id="income"><?php echo number_format($total_income, 2); ?></h5>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card text-center p-3 bg-light-red shadow-sm">
                                        <h6 class="text-muted">Total Expense</h6>
                                        <h5 class="fw-bold text-danger" id="expense"><?php echo number_format($total_expense, 2); ?></h5>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card text-center p-3 bg-light-blue shadow-sm">
                                        <h6 class="text-muted">Profit</h6>
                                        <h5 class="fw-bold text-primary" id="profit"><?php echo number_format($profit, 2); ?></h5>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="chart-container" style="position: relative;">
                                <canvas id="incomeExpenseChart"></canvas>
                            </div>

                            <script>
                                // Initialize the chart with default data
                                const incomeExpenseData = {
                                    labels: ['Expense', 'Profit'], // Two labels: 'Expense' and 'Profit'
                                    datasets: [{
                                        label: 'Amount',
                                        data: [0, 0], // Placeholder for initial Expense and Profit data
                                        backgroundColor: ['#F44336', '#4CAF50'], // Red for Expense and Green for Profit
                                        borderColor: ['#F44336', '#4CAF50'], // Border color for the bars
                                        borderWidth: 1, // Border width for the bars
                                        barThickness: 100,
                                    }]
                                };
                                // Chart configuration
                                const incomeExpenseConfig = {
                                    type: 'bar', // Bar chart type
                                    data: incomeExpenseData,
                                    options: {
                                        responsive: true,
                                        plugins: {
                                            legend: {
                                                position: 'top', // Position of the legend
                                            },
                                            title: {
                                                display: true,
                                                text: 'Income, Expense & Profit Distribution' // Title of the chart
                                            }
                                        },
                                        scales: {
                                            x: {
                                                // X-axis labels ('Expense' and 'Profit')
                                            },
                                            y: {
                                                beginAtZero: true, // Ensure Y-axis starts at 0
                                            }
                                        }
                                    }
                                };
                                // Render the chart
                                const incomeExpenseChart = new Chart(
                                    document.getElementById('incomeExpenseChart'), // Canvas element ID
                                    incomeExpenseConfig // Chart configuration
                                );

                                // Function to update chart data dynamically
                                function updateChartData(time) {
                                    $.ajax({
                                        url: 'html/fetch_dash.php', // Replace with your PHP endpoint
                                        method: 'POST',
                                        data: {
                                            time: time
                                        },
                                        dataType: 'json',
                                        success: function(response) {
                                            // Update datasets with new data
                                            incomeExpenseChart.data.datasets[0].data = [response.total_expense, response.profit]; // Expense and Profit data

                                            // Update the chart
                                            incomeExpenseChart.update();
                                        },
                                        error: function(xhr, status, error) {
                                            console.error('Error fetching data:', error);
                                        }
                                    });
                                }

                                // Add event listeners to buttons
                                $(document).ready(function() {
                                    $('.filter-button').on('click', function() {
                                        const time = $(this).data('time'); // Get the 'time' data from button
                                        updateChartData(time); // Call the function to update the chart
                                    });

                                    // Load default data (e.g., "All") when the page loads
                                    updateChartData('Year');
                                });
                            </script>
                            <script>
                                $(document).ready(function() {
                                    // When a filter button is clicked
                                    $('.filter-button').on('click', function() {
                                        var buttonText = $(this).text(); // Get the text of the clicked button
                                        var timeData = $(this).data('time'); // Get the data-time attribute

                                        // Perform AJAX request
                                        $.ajax({
                                            url: 'html/fetch_dash.php', // URL to the PHP endpoint
                                            type: 'POST', // POST method to send data
                                            dataType: 'text',
                                            data: {
                                                time: timeData
                                            }, // Send 'time' data to PHP
                                            success: function(response) {
                                                // Display the updated data in the target section
                                                $('#button-name').html(response);
                                                const data = JSON.parse(response); // Parse the JSON response
                                                $('#income').text(data.total_income); // Display the income
                                                $('#expense').text(data.total_expense); // Display the expense
                                                $('#profit').text(data.profit); // Display the profit

                                            },
                                            error: function(xhr, status, error) {
                                                // Handle any errors
                                                $('#button-name').html('<p>Error: ' + error + '</p>');
                                            }
                                        });
                                    });
                                });
                            </script>
                        <?php } elseif ($section == 'search_client') { ?>

                            <h5 class="mb-3">Search Client</h5>
                            <br>
                            <form>
                                <!-- Client Name Dropdown -->
                                <div class="row g-2 align-items-center mb-2">
                                    <label for="client" class="col-sm-4 ">Client Name:</label>
                                    <div class="col-sm-8">
                                        <select id="client" name="client" class="form-select">
                                            <option value="">Choose...</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Company Name -->
                                <div class="row g-2 align-items-center mb-2">
                                    <label for="company" class="col-sm-4 ">Company Name:</label>
                                    <div class="col-sm-8">
                                        <input type="text" id="company" class="form-control" class="col-sm-8" disabled>
                                    </div>
                                </div>

                                <!-- Contact Person -->
                                <div class="row g-2 align-items-center mb-2">
                                    <label for="contact" class="col-sm-4 col-form-label fw-bold">Contact Person:</label>
                                    <div class="col-sm-8">
                                        <input type="text" id="contact" class="form-control" disabled>
                                    </div>
                                </div>

                                <!-- Mobile No & Email -->
                                <div class="row g-2 align-items-center mb-2">
                                    <label for="mobile" class="col-sm-3 col-form-label fw-bold">Mobile No:</label>
                                    <div class="col-sm-3">
                                        <input type="text" id="mobile" class="form-control" disabled>
                                    </div>
                                    <label for="email" class="col-sm-3 col-form-label fw-bold">Email ID:</label>
                                    <div class="col-sm-3">
                                        <input type="text" id="email" class="form-control" disabled>
                                    </div>
                                </div>

                                <!-- State & City -->
                                <div class="row g-2 align-items-center">
                                    <label for="state" class="col-sm-3 col-form-label fw-bold">State:</label>
                                    <div class="col-sm-3">
                                        <input type="text" id="state" class="form-control" disabled>
                                    </div>
                                    <label for="city" class="col-sm-3 col-form-label fw-bold">City:</label>
                                    <div class="col-sm-3">
                                        <input type="text" id="city" class="form-control" disabled>
                                    </div>
                                </div>
                            </form>

                            <script>
                                //Pass PHP client data to JavaScript
                                let client_array = <?php echo json_encode($clientmaster); ?>;
                                
                                //Fetch client data from PHP using AJAX
                                fetch('html/fetch_clients.php', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                    },
                                    body: JSON.stringify({ clientmaster: client_array }),
                                })
                                .then(response => response.json())  // Parse the response as JSON
                                .then(data => {
                                    console.log('Data passed:', data);  // Log the returned data for debugging

                                    //Populate the dropdown with client data
                                    let clientDropdown = document.getElementById('client');  // Get the dropdown element
                                    clientDropdown.innerHTML = '<option value="">Choose...</option>';  // Clear previous options

                                    // Create options dynamically
                                    data.forEach(client => {
                                        let option = document.createElement('option');  // Create a new option element
                                        option.value = client.id;  // Set client ID as the value
                                        option.textContent = client.client_name;  // Display the client name
                                        clientDropdown.appendChild(option);  // Append the option to the dropdown
                                    });

                                    //Add event listener to fetch client details when a client is selected
                                    clientDropdown.addEventListener('change', function() {
                                        let clientId = this.value;  // Get the selected client ID
                                        if (clientId) {
                                            fetchClientDetails(clientId);  // Fetch client details if a client is selected
                                        } else {
                                            // Clear form fields if no client is selected
                                            $('#clientForm').find('input').val('');
                                        }
                                    });
                                })
                                .catch(error => console.error('Error:', error));  // Handle any errors

                                //Function to fetch client details based on the selected client ID
                                function fetchClientDetails(clientId) {
                                    $.ajax({
                                        url: 'html/fetch_dash.php',  // PHP script for fetching client details
                                        type: 'POST',
                                        data: { id: clientId },  // Send the selected client ID
                                        dataType: 'json',
                                        success: function(data) {
                                            // Populate form fields with fetched client details
                                            if (data) {
                                                $('#company').val(data.company_name);
                                                $('#contact').val(data.contact_person);
                                                $('#mobile').val(data.mobile_no);
                                                $('#email').val(data.email_1);
                                                $('#state').val(data.state);
                                                $('#city').val(data.city);
                                            }
                                        },
                                        error: function(xhr, status, error) {
                                            console.error('Error fetching client details:', error);
                                        }
                                    });
                                }
                            </script>

                        <?php } elseif ($section == 'attendance_report') { ?>
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <h5>Attendance Report</h5>
                                <form id="attendanceForm">
                                    <label for="date">Select Date:</label>
                                    <input type="date" id="date" name="date" required>
                                </form>
                            </div>
                            <div class="container mt-3">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <div class="card text-center p-3 bg-light-green shadow-sm">
                                            <h6 class="text-muted">Total Employees</h6>
                                            <h5 id="totalEmployees" class="fw-bold text-success">0 Employees</h5>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card text-center p-3 bg-light-blue shadow-sm">
                                            <h6 class="text-muted">Present Employees</h6>
                                            <h5 id="presentEmployees" class="fw-bold text-primary">0 Present</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <div class="card text-center p-3 bg-light-yellow shadow-sm">
                                            <h6 class="text-muted">LWP Employees</h6>
                                            <h5 id="lwpEmployees" class="fw-bold text-warning">0 LWP</h5>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card text-center p-3 bg-light-red shadow-sm">
                                            <h6 class="text-muted">Casual Leave Employees</h6>
                                            <h5 id="casualLeaveEmployees" class="fw-bold text-danger">0 Casual Leave</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <script>
                                // Set the default date to today
                                const dateInput = document.getElementById('date');
                                dateInput.valueAsDate = new Date();
                                // Fetch data on date change
                                dateInput.addEventListener('change', function() {
                                    const date = dateInput.value;
                                    // Send the AJAX request
                                    fetch('html/fetch_attendance.php', {
                                            method: 'POST',
                                            headers: {
                                                'Content-Type': 'application/json',
                                            },
                                            body: JSON.stringify({
                                                date: date
                                            }),
                                        })
                                        .then(response => {
                                            if (!response.ok) {
                                                throw new Error('Network response was not ok');
                                            }
                                            return response.json();
                                        })
                                        .then(data => {
                                            if (data.error) {
                                                alert(data.error);
                                            } else {
                                                // Update the UI with data
                                                document.getElementById('totalEmployees').textContent = `${data.total} Employees`;
                                                document.getElementById('presentEmployees').textContent = `${data.present} Present`;
                                                document.getElementById('lwpEmployees').textContent = `${data.lwp} LWP`;
                                                document.getElementById('casualLeaveEmployees').textContent = `${data.casual_leave} Casual Leave`;
                                            }
                                        })
                                        .catch(error => {
                                            console.error('Fetch error:', error);
                                        });
                                });
                                // Trigger the data fetch on page load for the default date
                                dateInput.dispatchEvent(new Event('change'));
                            </script>
                        <?php } elseif ($section == 'payment_received') { ?>
                            <h5>Last - 5 Payment Recieved</h5>
                            <table border="1">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Date</th>
                                        <th>Client Name</th>
                                        <th>Amt Received</th>
                                        <th>Amt Credited</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    require 'connection.php';
                                    $payment_recived = "SELECT date, client_name, amount, amount_credited FROM advance WHERE payment_mode_pay = 'Recived' ORDER BY date DESC LIMIT 5";
                                    $result = $con->query($payment_recived);
                                    if ($result->num_rows > 0) {
                                        $id = 1;
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<tr>";
                                            echo "<td>" . $id++ . "</td>";
                                            echo "<td>" . $row["date"] . "</td>";
                                            echo "<td>" . $row["client_name"] . "</td>";
                                            echo "<td>" . $row["amount"] . "</td>";
                                            echo "<td>" . $row["amount_credited"] . "</td>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='5'> No records found </td></tr>";
                                    }
                                    $con->close();
                                    ?>
                                </tbody>
                            </table>


                        <?php } elseif ($section == 'payment_paid') { ?>
                            <h5>Last - 5 Payment Paid</h5>
                            <table border="1">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Date</th>
                                        <th>Client Name</th>
                                        <th>Amt Received</th>
                                        <th>Amt Credited</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    require 'connection.php';
                                    $payment_recived = "SELECT date, client_name, amount, amount_credited FROM advance WHERE payment_mode_pay = 'Paid' ORDER BY date DESC LIMIT 5";
                                    $result = $con->query($payment_recived);
                                    if ($result->num_rows > 0) {
                                        $id = 1;
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<tr>";
                                            echo "<td>" . $id++ . "</td>";
                                            echo "<td>" . $row["date"] . "</td>";
                                            echo "<td>" . $row["client_name"] . "</td>";
                                            echo "<td>" . $row["amount"] . "</td>";
                                            echo "<td>" . $row["amount_credited"] . "</td>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='5'> No records found </td></tr>";
                                    }
                                    $con->close();
                                    ?>
                                </tbody>
                            </table> 
                        <?php } elseif ($section == 'tranding_invent') { ?>  
                            <h5 class="mb-4">Trading Inventory</h5>
                            <!-- Product Name Dropdown -->
                            <div class="row mb-3 align-items-center">
                                <label for="productName" class="col-sm-4 col-form-label fw-bold">Product Name:</label>
                                <div class="col-sm-8">
                                    <select id="productName" class="form-select" name="product">
                                        <option value="">Select Product</option>
                                        <?php foreach ($products as $product): ?>
                                            <option value="<?= $product['product_name'] ?>"><?= $product['product_name'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <!-- Brand Name Dropdown -->
                            <div class="row mb-3 align-items-center">
                                <label for="brandName" class="col-sm-4 col-form-label fw-bold">Brand Name:</label>
                                <div class="col-sm-8">
                                    <select id="brandName" class="form-select" name="brand">
                                        <option value="">Select Brand</option>
                                    </select>
                                </div>
                            </div>
                            <!-- Total Quantity Input -->
                            <div class="row mb-3 align-items-center">
                                <label for="totalQuantity" class="col-sm-4 col-form-label fw-bold">Total Quantity:</label>
                                <div class="col-sm-4">
                                    <input type="text" id="totalQuantity" class="form-control" readonly>
                                </div>
                            </div>
                            <script>
                              $(document).ready(function () {
                                    // Fetch brands when product is selected
                                    $('#productName').on('change', function () {
                                        let productName = $(this).val(); // Get selected product name

                                        //console.log("Selected Product Name:", productName); // Debugging log

                                        if (productName) {
                                            $.ajax({
                                                url: 'html/fetch_dash.php',
                                                type: 'GET',
                                                data: { product_name: productName },
                                                dataType: 'html', // Ensure response is treated as HTML
                                                success: function (response) {
                                                    //console.log("Brand AJAX Response:", response); // Debugging log
                                                    $('#brandName').html(response); // Update brand dropdown
                                                    // Automatically trigger change event to select first available brand
                                                    $('#brandName').trigger('change');
                                                },
                                                error: function () {
                                                    alert("Error fetching brands.");
                                                }
                                            });
                                        } else {
                                            $('#brandName').html('<option value="">Select Brand</option>');
                                            $('#totalQuantity').val('');
                                        }
                                    });

                                    // Fetch total quantity when a brand is selected
                                    $('#brandName').on('change', function () {
                                        let brandName = $(this).val();

                                        //console.log("Selected Brand Name:", brandName);

                                        if (brandName) {
                                            $.ajax({
                                                url: 'html/fetch_dash.php',
                                                type: 'GET',
                                                data: { brand_name: brandName },
                                                dataType: 'text', // Ensure response is treated as text
                                                success: function (response) {
                                                    //console.log("Quantity AJAX Response:", response);
                                                    $('#totalQuantity').val(response);
                                                },
                                                error: function () {
                                                    alert("Error fetching quantity.");
                                                }
                                            });
                                        } else {
                                            $('#totalQuantity').val('');
                                        }
                                    });
                                });
                            </script>  
                        <?php } ?>
                    </div>
                </div>
                <?php if (($index + 1) % 2 == 0) { ?>
        </div>
        <div class="row g-3">
        <?php } ?>
    <?php } ?>
    <div class="container-fluid py-4">
                    <div class="card shadow-sm w-100" style="max-width: 100%;">
                        <div class="card-body">
                            <h5>Sales Data</h5>
                            <!-- <div id="result">Result will be displayed here.</div> -->
                            <div style="display: flex; align-items: center; justify-content: flex-start; margin-top: 20px">
                                <select id="salesPeriod" style="width: 150px;">
                                <option value="lastday" >Last 1 Day</option>
                                <option value="lasttwoday">Last 2 Days</option>
                                <option value="lastthreeday">Last 3 Days</option>
                                <option value="lastfourday">Last 4 Days</option>
                                <option value="lastfiveday">Last 5 Days</option>
                                <option value="lastMonth">Last Month</option>
                                <option value="lastYear">Last Year</option>
                                <option value="allrecord">All Records</option>
                            </select>
                                <!-- Button for Dropdown -->
                                <button class="dropdown-btn" style="margin-right: 10px;margin-left: 100px; font-family: Arial, sans-serif; height: 35px; width: 170px; background-color:#218125; color: white; border-radius: 5px">Select Portfolio</button>
                                <!-- Selected Portfolio List -->
                                <div id="selectedPortfolio" class="form-control" style="flex-grow: 2; text-align: left;">
                                    Selected Portfolio: None
                                </div>
                            </div>
                             <!-- <div id="result" style="margin-top: 20px; font-size: 18px; color: green;"></div>  -->
                                <div class="multiselect-dropdown hide" style="margin-left: 150px;">
                                    
                                <ul class="multiselect-dropdown-list" style="center; justify-content: flex-start;">
                                    <input class="multiselect-dropdown-search" type="text" placeholder="Search...">
                                    
                                    <li class="multiselect-dropdown-all-selector">
                                        <input type="checkbox" id="selectAll"> <label for="selectAll">Select All</label>
                                    </li>

                                    <?php foreach ($multiple_dropdown as $value => $label): ?>
                                        <li>
                                            <input type="checkbox" id="<?= htmlspecialchars($value); ?>" 
                                                <?php if (isset($row[$value]) && $row[$value] == 1): ?>checked<?php endif; ?> >
                                            <label for="<?= htmlspecialchars($value); ?>"><?= htmlspecialchars($label); ?></label>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                                    <span class="optext maxselected">0 selected</span>
                                </div>  
                                <br>
                                <table id="dataforsale" border="1" class="display" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Table Name</th>
                                            <th>Transaction ID</th>
                                            <th>Client Name</th>
                                            <th>Date</th>
                                            <th>Fees</th>
                                            <th>Fees Received</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Data will be appended here -->
                                    </tbody>
                                </table>
                                
                            <script>
                                const dropdownBtn = document.querySelector('.dropdown-btn');
                                const dropdown = document.querySelector('.multiselect-dropdown');
                                const selectAllCheckbox = document.getElementById('selectAll');
                                const checkboxes = document.querySelectorAll('.multiselect-dropdown-list input[type="checkbox"]:not(#selectAll)');
                                const selectedPortfolio = document.getElementById('selectedPortfolio');
                                const salesPeriod = document.getElementById('salesPeriod'); 
                                dropdownBtn.addEventListener('click', () => {
                                    dropdown.classList.toggle('show');
                                    dropdown.classList.toggle('hide');
                                });
                                // Select or Unselect All checkboxes when the "Select All" checkbox is clicked
                                selectAllCheckbox.addEventListener('change', () => {
                                    checkboxes.forEach(checkbox => {
                                        checkbox.checked = selectAllCheckbox.checked;
                                    });
                                    updateSelectedCount();
                                    updateSelectedPortfolio();
                                });

                                function updateSelectedPortfolio() {
                                    const selected = [];
                                    // Check the state of all checkboxes except "Select All"
                                    checkboxes.forEach(checkbox => {
                                        if (checkbox.checked && checkbox.id !== 'selectAll') {
                                            selected.push(document.querySelector(`label[for="${checkbox.id}"]`).textContent);
                                        }
                                    });
                                    // Special case: If "Select All" is checked, display all values
                                    if (selectAll.checked) {
                                        const allLabels = [...document.querySelectorAll('.multiselect-dropdown-list label')];
                                        const allValues = allLabels
                                            .filter(label => label.htmlFor !== 'selectAll') // Exclude "Select All" label
                                            .map(label => label.textContent);
                                        selectedPortfolio.textContent = `Selected Portfolio: ${allValues.join(', ')}`;
                                    } else {
                                        // Update the display for regular cases
                                        selectedPortfolio.textContent = selected.length
                                            ? `Selected Portfolio: ${selected.join(', ')}`
                                            : 'Selected Portfolio: None';
                                    }
                                }
                                function updateSelectedPeriod() {
                                    const selectedPeriod = salesPeriod.value; // Get selected period from the dropdown
                                    let periodText = '';
                                    switch (selectedPeriod) {
                                        case 'lastday':
                                            periodText = 'Last 1 Day';
                                            break;
                                        case 'lasttwoday':
                                            periodText = 'Last 2 Days';
                                            break;
                                        case 'lastthreeday':
                                            periodText = 'Last 3 Days';
                                            break;
                                        case 'lastfourday':
                                            periodText = 'Last 4 Days';
                                            break;
                                        case 'lastfiveday':
                                            periodText = 'Last 5 Days';
                                            break;
                                        case 'lastMonth':
                                            periodText = 'Last Month';
                                            break;
                                        case 'lastYear':
                                            periodText = 'Last Year';
                                            break;
                                        case 'allrecord':
                                            periodText = 'All Records';
                                            break;
                                        default:
                                            periodText = 'No Period Selected';
                                    }
                                    // Update the displayed selected period text
                                    selectedPortfolio.textContent = `Selected Period: ${periodText}`;
                                }
                                // Bind both functions to updates
                                $('#salesPeriod').change(function() {
                                    updateSelectedPeriod();
                                    updateSelectedPortfolio();  // Update both the selected period and portfolio
                                });
                                checkboxes.forEach(checkbox => {
                                    checkbox.addEventListener('change', function() {
                                        updateSelectedPortfolio(); // Update portfolio whenever a checkbox is clicked
                                    });
                                });
                                // Update the selected count
                                checkboxes.forEach(checkbox => {
                                    checkbox.addEventListener('change', () => {
                                        if (!checkbox.checked) {
                                            selectAllCheckbox.checked = false; // Uncheck 'Select All' if any item is unchecked
                                        } else {
                                            const allChecked = Array.from(checkboxes).every(checkbox => checkbox.checked);
                                            selectAllCheckbox.checked = allChecked; // Check 'Select All' if all items are checked
                                        }
                                        updateSelectedCount();
                                        updateSelectedPortfolio();
                                    });
                                });
                                // Function to update the selected count
                                function updateSelectedCount() {
                                    const selectedCount = Array.from(checkboxes).filter(checkbox => checkbox.checked).length;
                                    document.querySelector('.optext').textContent = `${selectedCount} selected`;
                                }
                                // Search functionality
                                const searchInput = document.querySelector('.multiselect-dropdown-search');
                                searchInput.addEventListener('input', () => {
                                    const filter = searchInput.value.toLowerCase();
                                    const items = document.querySelectorAll('.multiselect-dropdown-list li');
                                    items.forEach(item => {
                                        const label = item.querySelector('label');
                                        if (label && label.textContent.toLowerCase().indexOf(filter) > -1) {
                                            item.style.display = 'block';
                                        } else {
                                            item.style.display = 'none';
                                        }
                                    });
                                });
                                
                                $(document).ready(function() {
                                    let table = new DataTable('#dataforsale');
                                    $('#salesPeriod').val('lastday');
                                    $('.multiselect-dropdown-list input[type="checkbox"]').prop('checked', true);
                                    updateData();
                                    // Function to update selected portfolios and period
                                    function updateData() {
                                        var selectedPeriod = $('#salesPeriod').val();
                                        var selectedPortfolios = [];
                                        
                                        // Get selected portfolios
                                        $('.multiselect-dropdown-list input:checked').each(function() {
                                            selectedPortfolios.push($(this).attr('id'));
                                        });

                                        // Send AJAX request
                                        $.ajax({
                                            url: 'html/fetch_dash.php',
                                            method: 'POST',
                                            data: {
                                                salesPeriod: selectedPeriod,
                                                selectedPortfolios: selectedPortfolios
                                            },
                                            success: function(response) {
                                                // Clear the table body
                                                $('#dataforsale tbody').empty();
                                                
                                                // Append the new data
                                                $.each(response, function(index, row) {
                                                    $('#dataforsale tbody').append(
                                                        `<tr>
                                                            <td>${row.table_name}</td>
                                                            <td>${row.transaction_id}</td>
                                                            <td>${row.client_name}</td>
                                                            <td>${row.date}</td>
                                                            <td>${row.fees}</td>
                                                            <td>${row.fees_received}</td>
                                                        </tr>`
                                                    );
                                                });

                                            },
                                            error: function(xhr, status, error) {
                                                console.error('Request failed: ' + error);
                                                $('#result').html('<div style="color: red;">An error occurred while processing your request.</div>');
                                            }
                                        });
                                    }

                                    // Trigger data update on 'salesPeriod' change
                                    $('#salesPeriod').change(function() {
                                        updateData();  // Call the updateData function to refresh the data
                                    });

                                    // Trigger data update on portfolio checkbox change
                                    $('.multiselect-dropdown-list input[type="checkbox"]').change(function() {
                                        updateData();  // Call the updateData function to refresh the data
                                    });

                                    // Initialize DataTable
                                    updateData();
                                });

                            	window.addEventListener('load', () => {
                                        // Check the "Select All" checkbox by default
                                        selectAllCheckbox.checked = true;
                                        // Select all individual checkboxes
                                        checkboxes.forEach(checkbox => {
                                            checkbox.checked = true;
                                        });
                                        updateSelectedCount();
                                        updateSelectedPortfolio();
                                    });                  
                            </script>
                        </div>
                    </div>
                </div> 
        </div>
    </div>
</body>
</html>
<?php
include_once 'ltr/header-footer.php';
?>