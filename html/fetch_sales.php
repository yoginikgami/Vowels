<?php
require 'connection.php';

// Get the selected filter and tables from the frontend request
$request = json_decode(file_get_contents('php://input'), true);
$filter = $request['filter'] ?? 'year_sale'; // Default filter is 'year_sale'
$tables = $request['tables'] ?? [];

// Validate input
$response = [];

// Determine the date condition based on the filter
switch ($filter) {
    case 'today_sale':
        $dateCondition = "CURDATE()";
        break;
    case 'week_sale':
        $dateCondition = "CURDATE() - INTERVAL 7 DAY";
        break;
    case 'month_sale':
        $dateCondition = "CURDATE() - INTERVAL 30 DAY";
        break;
    case 'year_sale':
        $dateCondition = "CURDATE() - INTERVAL 365 DAY";
        break;
    default:
        $dateCondition = "CURDATE()";
        break;
}

try {
    foreach ($tables as $table) {
        // Map table names to their respective columns and date columns
        $tableColumns = [
            'pan' => ['fees', 'date'],
            'tan' => ['fees', 'date'],
            'e_tds' => ['fees', 'receipt_date'],
            'it_returns' => ['fees', 'date'],
            'e_tender' => ['bill_amu', 'date'],
            'gst_fees' => ['consulting_fees', 'date'],
            'dsc_subscriber' => ['fees', 'registration_date'],
            'dsc_token' => ['fees', 'date'],
            'dsc_reseller' => ['fees', 'date'],
            'other_services' => ['fees', 'date'],
            'psp' => ['fees', 'date'],
            'sales' => ['billing_amount', 'date'],
            'trade_mark' => ['bill_amt', 'date_application'],
            'patent' => ['billing_amount', 'filling_date'],
            'copy_right' => ['billing_amount', 'filling_date'],
            'industrial_design' => ['billing_amount', 'filling_date'],
            'trade_secret' => ['billing_amount', 'date_of_filling'],
            'advocade_case' => ['fees', 'file_date']
        ];

        if (!isset($tableColumns[$table])) {
            // Skip invalid tables
            continue;
        }

        [$column, $dateColumn] = $tableColumns[$table];

        // Check if the table requires a specific date format
        $specificDateTables = ['copy_right', 'patent', 'trade_mark', 'trade_secret'];
        if (in_array($table, $specificDateTables)) {
            $query = "SELECT SUM($column) AS totalFees FROM $table WHERE STR_TO_DATE($dateColumn, '%Y-%m-%d') >= $dateCondition";
        } else {
            $query = "SELECT SUM($column) AS totalFees FROM $table WHERE STR_TO_DATE($dateColumn, '%Y-%b-%d') >= $dateCondition";
        }

        // Prepare and execute the query
        $stmt = $con->prepare($query);
        $stmt->execute();

        $result = $stmt->get_result();
        $tableSales = $result->fetch_assoc()['totalFees'] ?? 0;

        // Format sales data
        $response[$table] = number_format($tableSales, 2); // Individual table sales
        $stmt->close();
    }

    // Return the sales data without the total_sales
    header('Content-Type: application/json');
    echo json_encode($response);
} catch (Exception $e) {
    error_log("Error: " . $e->getMessage());
    echo json_encode(['error' => 'Database query failed']);
}

$con->close();
?>
