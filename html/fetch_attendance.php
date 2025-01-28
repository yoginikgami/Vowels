<?php
require 'connection.php';

// Get the POSTed data
$input = json_decode(file_get_contents('php://input'), true);
$date = isset($input['date']) ? $input['date'] : date('Y-m-d');

// Query to get the attendance data
$query = "SELECT 
            COUNT(*) AS total, 
            SUM(CASE WHEN Full_attendance = 'Present' THEN 1 ELSE 0 END) AS present,
            SUM(CASE WHEN Full_attendance = 'LWP' THEN 1 ELSE 0 END) AS lwp,
            SUM(CASE WHEN Full_attendance = 'Casual_Leave' THEN 1 ELSE 0 END) AS casual_leave
          FROM employee_attendance
          WHERE DATE(attendance_date) = '$date'";

// Execute the query
$result = mysqli_query($con, $query);

// Prepare the response
if ($result) {
    $row = mysqli_fetch_assoc($result);
    echo json_encode([
        'total' => $row['total'],
        'present' => $row['present'],
        'lwp' => $row['lwp'],
        'casual_leave' => $row['casual_leave']
    ]);
} else {
    echo json_encode(['error' => 'No data found for the selected date']);
}

// Close the connection
mysqli_close($con);
?>