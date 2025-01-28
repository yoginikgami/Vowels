<?php
require 'connection.php';

// Get the time range from the AJAX request
$timeData = $_POST['time'] ;
echo $timeData;
// Determine the date range based on the `time` parameter
switch ($timeData) {
    case 'Today':
        $dateCondition = "modify_date = CURDATE()";
        break;
    case 'Week':
        $dateCondition = "modify_date >= CURDATE() - INTERVAL 7 DAY";
        break;
    case 'Month':
        $dateCondition = "modify_date >= CURDATE() - INTERVAL 30 DAY";
        break;
    case 'Year':
        $dateCondition = "modify_date >= CURDATE() - INTERVAL 365 DAY";
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
echo json_encode([
    'total_income' => $total_income,
    'total_expense' => $total_expense,
    'profit' => $profit
]);

$con->close();



?>