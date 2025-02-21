<?php 

include('connection.php');

$category = $_POST['category'];
// $current_date
$current_date = date('Y-m-d');

// Prepare and execute the query to fetch data based on the category
// $query = "SELECT title_date, COUNT(*) AS record_count FROM date_title_data WHERE portfolio = ? and status_title='pending' and date_time='$current_date' and title_date!='Date of Application' GROUP BY title_date";
$query = "SELECT title_date, COUNT(*) AS record_count FROM date_title_data WHERE portfolio = ? and status_title='pending' and title_date!='Date of Application' GROUP BY title_date";
$stmt = $con->prepare($query);
$stmt->bind_param("s", $category);
$stmt->execute();
$result = $stmt->get_result();

// Fetch the data into an associative array
$data = array();
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

// Return the data as JSON
echo json_encode($data);
