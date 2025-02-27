<?php 

include('connection.php');

$category = $_POST['category'];
// $current_date
$current_date = date('Y-m-d');

if(isset($_SESSION['company_id'])) {
    $company_id = $_SESSION['company_id'];
    // Fetch user data for the given company ID and user ID
    $fetch_user_data = "SELECT * FROM `users` WHERE `company_id` = '$company_id' AND `id` = '" . $_SESSION['user_id'] . "'";
    $run_fetch_user_data = mysqli_query($con, $fetch_user_data);
    $row = mysqli_fetch_array($run_fetch_user_data);
}

$columns = [
    "trade_mark" => "trade_mark",
    "patent" => "patent",
    "copy_right" => "copy_right",
    "industrial_design" => "industrial_design",
    "trade_secret" => "trade_secret"
];

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
?>
