<?php
include 'connection.php';
if(isset($_POST['time'])){
    $timeData = $_POST['time'] ?? 'All';
    // echo $timeData;
    // Determine the date range based on the `time` parameter
    switch ($timeData) {
        case 'Today':
            $dateCondition = "STR_TO_DATE(date, '%Y-%b-%d') = CURDATE()";
            break;
        case 'Week':
            $dateCondition = "STR_TO_DATE(date, '%Y-%b-%d') >= CURDATE() - INTERVAL 7 DAY";
            break;
        case 'Month':
            $dateCondition = "STR_TO_DATE(date, '%Y-%b-%d') >= CURDATE() - INTERVAL 30 DAY";
            break;
        case 'Year':
            $dateCondition = "STR_TO_DATE(date, '%Y-%b-%d') >= CURDATE() - INTERVAL 365 DAY";
            break;
        default:
            $dateCondition = "1"; // Fetch all data
    }
    
    // Queries to calculate totals
    $incomeQuery = "SELECT SUM(amount) AS totalIncome FROM advance WHERE payment_mode_pay = 'Recived' AND $dateCondition";
    $expenseQuery = "SELECT SUM(amount) AS totalExpense FROM advance WHERE payment_mode_pay = 'Paid' AND $dateCondition";
    
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
    // Return the results as JSON
    $data = [
        'total_income' => $total_income,
        'total_expense' => $total_expense,
        'profit' => $profit
    ];
    echo json_encode($data);
}

if(isset($_POST['id']))
{
    $clientId = $_POST['id']; // Get client ID from AJAX request
    $sql = "SELECT * FROM client_master WHERE id = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param('i', $clientId);
    $stmt->execute();
    $result = $stmt->get_result();

    $clientDetails = $result->fetch_assoc();

    echo json_encode($clientDetails);
    $con->close();
}

if(isset($_POST['salesPeriod']) && isset($_POST['selectedPortfolios']))
{
    
        $salesPeriod = $_POST['salesPeriod'];  // Selected sales period
        $selectedPortfolios = $_POST['selectedPortfolios'];  // Array of selected portfolios
    // Initialize an empty response array
    $response = [];
    
    // Define column mappings for each portfolio
    $columnMappings = [
        'e_tds' => ['dates' => 'receipt_date', 'fees' => 'fees', 'fees_received' => 'fees_received'],
        'dsc_subscriber' => ['dates' => 'registration_date', 'fees' => 'fees', 'fees_received' => 'fees_received'],
        'e_tender' => ['dates' => 'date', 'fees' => 'bill_amu', 'fees_received' => 'fees_received'],
        'gst_fees' => ['dates' => 'date', 'fees' => 'consulting_fees', 'fees_received' => 'fees_received'],
        'sales' => ['dates' => 'date', 'fees' => 'billing_amount', 'fees_received' => 'fees_received'],
        'trade_mark' => ['dates' => 'date_application', 'fees' => 'bill_amt', 'fees_received' => 'fees_received'],
        'patent' => ['dates' => 'filling_date', 'fees' => 'billing_amount', 'fees_received' => 'fees_recived'],
        'copy_right' => ['dates' => 'filling_date', 'fees' => 'billing_amount', 'fees_received' => 'fees_recived'],
        'industrial_design' => ['dates' => 'filling_date', 'fees' => 'billing_amount', 'fees_received' => 'fees_recived'],
        'trade_secret' => ['dates' => 'date_of_filling', 'fees' => 'billing_amount', 'fees_received' => 'fees_recived'],
        'advocade_case' => ['dates' => 'file_date', 'fees' => 'fees', 'fees_received' => 'fees_received'],
    ];
    
    // Check if portfolios are selected
    if (!empty($selectedPortfolios)) {
        // Define the date condition based on the selected period
        $dateCondition = '';
        switch ($salesPeriod) {
            case 'lastday':
                $dateCondition = "WHERE STR_TO_DATE({dates}, '%Y-%b-%d') >= CURDATE() - INTERVAL 1 DAY";
                break;
            case 'lasttwoday':
                $dateCondition = "WHERE STR_TO_DATE({dates}, '%Y-%b-%d') >= CURDATE() - INTERVAL 2 DAY";
                break;
            case 'lastthreeday':
                $dateCondition = "WHERE STR_TO_DATE({dates}, '%Y-%b-%d') >= CURDATE() - INTERVAL 3 DAY";
                break;
            case 'lastfourday':
                $dateCondition = "WHERE STR_TO_DATE({dates}, '%Y-%b-%d') >= CURDATE() - INTERVAL 4 DAY";
                break;
            case 'lastfiveday':
                $dateCondition = "WHERE STR_TO_DATE({dates}, '%Y-%b-%d') >= CURDATE() - INTERVAL 5 DAY";
                break;
            case 'lastMonth':
                $dateCondition = "WHERE STR_TO_DATE({dates}, '%Y-%b-%d') >= CURDATE() - INTERVAL 1 MONTH";
                break;
            case 'lastYear':
                $dateCondition = "WHERE STR_TO_DATE({dates}, '%Y-%b-%d') >= CURDATE() - INTERVAL 1 YEAR";
                break;
            case 'allrecord':
            default:
                $dateCondition = ''; // No filtering for all records
                break;
        }

        // Loop through selected portfolios and execute query for each
        $response = []; // Initialize the response array
        foreach ($selectedPortfolios as $table) {
            // Use column mappings for the selected table
            $columns = $columnMappings[$table] ?? ['dates' => 'date', 'fees' => 'fees', 'fees_received' => 'fees_received'];

            // Replace placeholder in the date condition
            $currentDateCondition = str_replace('{dates}', $columns['dates'], $dateCondition);

            // Specific tables requiring a specific date format
            $specificDateTables = ['copy_right', 'patent', 'trade_mark', 'trade_secret'];
            
            // Construct the query
            if (in_array($table, $specificDateTables)) {
                $query = "
                    SELECT 
                        '{$table}' AS table_name,
                        transaction_id,
                        client_name,
                        {$columns['dates']} AS date,
                        {$columns['fees']} AS fees,
                        {$columns['fees_received']} AS fees_received
                    FROM `{$table}`
                    WHERE STR_TO_DATE({$columns['dates']}, '%Y-%m-%d') >= CURDATE() - INTERVAL 1 DAY";  // This is for the specific date tables
            } else {
                $query = "
                    SELECT 
                        '{$table}' AS table_name,
                        transaction_id,
                        client_name,
                        {$columns['dates']} AS date,
                        {$columns['fees']} AS fees,
                        {$columns['fees_received']} AS fees_received
                    FROM `{$table}`
                    {$currentDateCondition}";
            }

            // Execute the query
            $result = $con->query($query);
            if ($result && $result->num_rows > 0) {
                while ($salesData = $result->fetch_assoc()) {
                    $response[] = $salesData;
                }
            }
        }
    header('Content-Type: application/json');
    // Return the response as JSON
    echo json_encode($response);
    }
}


if (isset($_GET['product_name'])) {
    $productName = $_GET['product_name'];

    // Debugging: Log received product name
    error_log("Received Product Name: " . $productName);

    // Use DISTINCT to remove duplicates
    $brandQuery = "SELECT DISTINCT brand_name FROM product_list WHERE product_name = ?";
    $stmt = $con->prepare($brandQuery);

    if ($stmt) {
        $stmt->bind_param('s', $productName);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if brands are available
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<option value="' . htmlspecialchars($row['brand_name']) . '">' . htmlspecialchars($row['brand_name']) . '</option>';
            }
        } else {
            echo '<option value="">No Brands Available</option>';
        }

        $stmt->close();
    } else {
        echo '<option value="">Query Error</option>';
    }
}

if (isset($_GET['brand_name'])) {
    $brandName = $_GET['brand_name']; 

    // Debugging: Check received brand name
    error_log("Received Brand Name: " . $brandName);

    $quantityQuery = "SELECT SUM(unit_value) AS total_quantity FROM product_list WHERE brand_name = ?";
    $stmt = $con->prepare($quantityQuery);

    if ($stmt) {
        $stmt->bind_param('s', $brandName);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();

        echo ($data['total_quantity']) ? $data['total_quantity'] : '0'; // Output total quantity

        $stmt->close();
    } else {
        echo 'Query Error';
    }
}
?>
