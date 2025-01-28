<?php
require 'connection.php';

// Get selected period and portfolios from the POST request
if (isset($_POST['salesPeriod']) && isset($_POST['selectedPortfolios'])) {
    $salesPeriod = $_POST['salesPeriod']; // Selected sales period
    $selectedPortfolios = $_POST['selectedPortfolios']; // Array of selected portfolios

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
        'trade_secret' => ['dates' => 'date_of_filling', 'fees' => 'billing_amount', 'fees_received' => 'fees_received'],
        'advocade_case' => ['dates' => 'file_date', 'fees' => 'fees', 'fees_received' => '	fees_received'],
    ];

    // Tables requiring specific date format
    $specificDateTables = ['copy_right', 'patent', 'trade_mark', 'trade_secret', 'industrial_design'];

    // Check if portfolios are selected
    if (!empty($selectedPortfolios)) {
        // Define the date condition based on the selected period
        $dateCondition = '';
        switch ($salesPeriod) {
            case 'lastday':
                $dateCondition = " >= CURDATE() - INTERVAL 1 DAY";
                break;
            case 'lasttwoday':
                $dateCondition = " >= CURDATE() - INTERVAL 2 DAY";
                break;
            case 'lastthreeday':
                $dateCondition = " >= CURDATE() - INTERVAL 3 DAY";
                break;
            case 'lastfourday':
                $dateCondition = " >= CURDATE() - INTERVAL 4 DAY";
                break;
            case 'lastfiveday':
                $dateCondition = " >= CURDATE() - INTERVAL 5 DAY";
                break;
            case 'lastMonth':
                $dateCondition = " >= CURDATE() - INTERVAL 1 MONTH";
                break;
            case 'lastYear':
                $dateCondition = " >= CURDATE() - INTERVAL 1 YEAR";
                break;
            case 'allrecord':
            default:
                $dateCondition = ''; // No filtering for all records
                break;
        }

        // Loop through selected portfolios and execute query for each
        foreach ($selectedPortfolios as $table) {
            // Use column mappings for the selected table
            $columns = $columnMappings[$table] ?? ['dates' => 'date', 'fees' => 'fees', 'fees_received' => 'fees_received'];

            // Check if the table requires the specific date format
            if (in_array($table, $specificDateTables)) {
                $currentDateCondition = "WHERE {$columns['dates']} $dateCondition";
            } else {
                $currentDateCondition = "WHERE STR_TO_DATE({$columns['dates']}, '%Y-%b-%d') $dateCondition";
            }

            // Construct the query
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
            
            // Debug: Log or echo the query for verification
             echo $query;

            // Execute the query
            $result = $con->query($query);
            
            // Fetch data and append it to the response array
            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $response[] = $row;
                }
            } else {
                // Debug: Log empty result for the current table
                // echo "No data found for table: {$table}";
            }
        }
    } else {
        $response[] = ['error' => 'No portfolio or period selected.'];
    }
    header('Content-Type: application/json');
    // Return the response as JSON
    echo json_encode($response);
}
?>
