<?php
require 'connection.php';

// Get the raw POST data
$rawData = file_get_contents("php://input");
$clientmaster = json_decode($rawData, true);

// Validate received data
if (!$clientmaster || !is_array($clientmaster)) {
    echo json_encode(["error" => "Invalid input"]);
    exit;
}

// Column Mapping (Ensures correct column names)
$columnMapping = [
    "gst_fees" => "gst",
    "advocate_case" => "legal_notice",
    "pan" => "pan",
    "tan" => "tan",
    "e_tds" => "e_tds",
    "it_returns" => "it_returns",
    "e_tender" => "e_tender",
    "dsc_subscriber" => "dsc_subscriber",
    "dsc_reseller" => "dsc_reseller",
    "other_services" => "other_services",
    "psp" => "psp",
    "trade_mark" => "trade_mark",
    "patent" => "patent",
    "copy_right" => "copy_right",
    "industrial_design" => "industrial_design",
    "trade_secret" => "trade_secret"
];

// Build WHERE conditions dynamically
$whereClauses = [];
foreach ($clientmaster as $key => $value) {
    if (isset($columnMapping[$key])) {
        $columnName = $columnMapping[$key]; // Convert to actual column name
        $whereClauses[] = "$columnName = 1"; // Only check for 1 values
    }
}

// Ensure a valid SQL query
$whereSql = count($whereClauses) > 0 ? implode(" OR ", $whereClauses) : "1=1";

// Select client name and id based on the filters
$clientSearch = "SELECT id, client_name FROM client_master WHERE $whereSql";

// Execute the query
$result = $con->query($clientSearch);

// Check for SQL errors
if (!$result) {
    echo json_encode(["error" => "SQL Error: " . $con->error]);
    exit;
}

// Fetch client names and IDs
$clients = [];

if ($result->num_rows > 0) {
    // Fetch each client as an associative array
    while ($row = $result->fetch_assoc()) {
        $clients[] = [
            'id' => $row['id'], // Include client ID
            'client_name' => $row['client_name'] // Include client name
        ];
    }
}

// Return JSON response
echo json_encode($clients);
?>
