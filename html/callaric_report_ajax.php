<?php 
session_start();
include_once 'connection.php';
date_default_timezone_set('Asia/Kolkata'); // Set this to your preferred timezone

// Get the current date and time
$currentDate = date("Y-m-d"); // Format: 2024-08-22
// Get yesterday's date
$yesterdayDate = date("Y-m-d", strtotime("-1 day")); // Format: 2024-11-26
// Get the date range for last week
$startDate = date("Y-m-d", strtotime("-7 days")); // Start date of the last 7 days
$endDate = date("Y-m-d", strtotime("-1 day"));   // End date, excluding today

if((isset($_GET['fetch_todays_call'])) || isset($_GET['fetch_todays_call_staff'])){
    if(isset($_GET['fetch_todays_call_staff'])){
        $fetch_query = "SELECT count(*) as total_calls, COUNT(DISTINCT(REPLACE(calls.phoneNumber, '+91', ''))) as unique_client,SUM(CASE WHEN calls.callStatus = 'Incoming' THEN 1 ELSE 0 END) AS total_incoming_calls,
    SUM(CASE WHEN calls.callStatus = 'Missed' THEN 1 ELSE 0 END) AS total_missed_calls, SUM(CASE WHEN calls.callStatus = 'Outgoing' THEN 1 ELSE 0 END) AS total_outgoing_calls,
    SUM(CASE WHEN calls.callStatus = 'Rejected' THEN 1 ELSE 0 END) AS total_rejected_calls,  SUM(CASE WHEN calls.callDuration > 0 THEN 1 ELSE 0 END) AS total_connected_calls, 
REPLACE(calls.phoneNumber, '+91', '') AS phoneNumber,
CONCAT(
        FLOOR(SUM(calls.callDuration) / 3600), ' h ', 
        FLOOR((SUM(calls.callDuration) % 3600) / 60), ' m'
    ) AS callDurationInHoursMinutes,
DATE(STR_TO_DATE(calls.callDate, '%d-%m-%Y %H:%i:%s')) AS callDate,
REPLACE(calls.registeredNumber, '+91', '') AS registeredNumber,
users.firstname FROM call_logs calls LEFT JOIN users users ON REPLACE(calls.registeredNumber, '+91', '') = users.mobile
where DATE(STR_TO_DATE(calls.callDate, '%d-%m-%Y %H:%i:%s')) = '$currentDate' AND REPLACE(calls.registeredNumber, '+91', '') like '%".$_SESSION['mobile']."%'";
    }
    if(isset($_GET['fetch_todays_call'])){
    $fetch_query = "SELECT count(*) as total_calls, COUNT(DISTINCT(REPLACE(calls.phoneNumber, '+91', ''))) as unique_client,SUM(CASE WHEN calls.callStatus = 'Incoming' THEN 1 ELSE 0 END) AS total_incoming_calls,
    SUM(CASE WHEN calls.callStatus = 'Missed' THEN 1 ELSE 0 END) AS total_missed_calls, SUM(CASE WHEN calls.callStatus = 'Outgoing' THEN 1 ELSE 0 END) AS total_outgoing_calls,
    SUM(CASE WHEN calls.callStatus = 'Rejected' THEN 1 ELSE 0 END) AS total_rejected_calls,  SUM(CASE WHEN calls.callDuration > 0 THEN 1 ELSE 0 END) AS total_connected_calls, 
REPLACE(calls.phoneNumber, '+91', '') AS phoneNumber,
CONCAT(
        FLOOR(SUM(calls.callDuration) / 3600), ' h ', 
        FLOOR((SUM(calls.callDuration) % 3600) / 60), ' m'
    ) AS callDurationInHoursMinutes,
DATE(STR_TO_DATE(calls.callDate, '%d-%m-%Y %H:%i:%s')) AS callDate,
REPLACE(calls.registeredNumber, '+91', '') AS registeredNumber,
users.firstname FROM call_logs calls LEFT JOIN users users ON REPLACE(calls.registeredNumber, '+91', '') = users.mobile
where DATE(STR_TO_DATE(calls.callDate, '%d-%m-%Y %H:%i:%s')) = '$currentDate'";
}
$result = mysqli_query($con,$fetch_query);
$show = mysqli_fetch_array($result);
$response = [
        'total_calls' => $show['total_calls'],
        'call_duration' => $show['callDurationInHoursMinutes'],
        'incoming' => $show['total_incoming_calls'],
        'outgoing' => $show['total_outgoing_calls'],
        'missed' => $show['total_missed_calls'],
        'rejected' => $show['total_rejected_calls'],
        'unique_clients' => $show['unique_client'],
        'connected_calls' => $show['total_connected_calls']
    ];
    
    echo json_encode($response);
}

if(isset($_GET['fetch_yesterday_call']) || isset($_GET['fetch_yesterday_call_staff'])){
    if(isset($_GET['fetch_yesterday_call_staff'])){
        $fetch_query = "SELECT count(*) as total_calls, COUNT(DISTINCT(REPLACE(calls.phoneNumber, '+91', ''))) as unique_client,SUM(CASE WHEN calls.callStatus = 'Incoming' THEN 1 ELSE 0 END) AS total_incoming_calls,
                    SUM(CASE WHEN calls.callStatus = 'Missed' THEN 1 ELSE 0 END) AS total_missed_calls, SUM(CASE WHEN calls.callStatus = 'Outgoing' THEN 1 ELSE 0 END) AS total_outgoing_calls,
                    SUM(CASE WHEN calls.callStatus = 'Rejected' THEN 1 ELSE 0 END) AS total_rejected_calls,  SUM(CASE WHEN calls.callDuration > 0 THEN 1 ELSE 0 END) AS total_connected_calls, 
                    REPLACE(calls.phoneNumber, '+91', '') AS phoneNumber,
                    CONCAT(
                            FLOOR(SUM(calls.callDuration) / 3600), ' h ', 
                            FLOOR((SUM(calls.callDuration) % 3600) / 60), ' m'
                        ) AS callDurationInHoursMinutes,
                    DATE(STR_TO_DATE(calls.callDate, '%d-%m-%Y %H:%i:%s')) AS callDate,
                    REPLACE(calls.registeredNumber, '+91', '') AS registeredNumber,
                    users.firstname FROM call_logs calls LEFT JOIN users users ON REPLACE(calls.registeredNumber, '+91', '') = users.mobile
                    where DATE(STR_TO_DATE(calls.callDate, '%d-%m-%Y %H:%i:%s')) = '$yesterdayDate' AND REPLACE(calls.registeredNumber, '+91', '') like '%".$_SESSION['mobile']."%'";
    }
    if(isset($_GET['fetch_yesterday_call'])){ 
    $fetch_query = "SELECT count(*) as total_calls, COUNT(DISTINCT(REPLACE(calls.phoneNumber, '+91', ''))) as unique_client,SUM(CASE WHEN calls.callStatus = 'Incoming' THEN 1 ELSE 0 END) AS total_incoming_calls,
                    SUM(CASE WHEN calls.callStatus = 'Missed' THEN 1 ELSE 0 END) AS total_missed_calls, SUM(CASE WHEN calls.callStatus = 'Outgoing' THEN 1 ELSE 0 END) AS total_outgoing_calls,
                    SUM(CASE WHEN calls.callStatus = 'Rejected' THEN 1 ELSE 0 END) AS total_rejected_calls,  SUM(CASE WHEN calls.callDuration > 0 THEN 1 ELSE 0 END) AS total_connected_calls, 
                    REPLACE(calls.phoneNumber, '+91', '') AS phoneNumber,
                    CONCAT(
                            FLOOR(SUM(calls.callDuration) / 3600), ' h ', 
                            FLOOR((SUM(calls.callDuration) % 3600) / 60), ' m'
                        ) AS callDurationInHoursMinutes,
                    DATE(STR_TO_DATE(calls.callDate, '%d-%m-%Y %H:%i:%s')) AS callDate,
                    REPLACE(calls.registeredNumber, '+91', '') AS registeredNumber,
                    users.firstname FROM call_logs calls LEFT JOIN users users ON REPLACE(calls.registeredNumber, '+91', '') = users.mobile
                    where DATE(STR_TO_DATE(calls.callDate, '%d-%m-%Y %H:%i:%s')) = '$yesterdayDate'";
    }
                    $result = mysqli_query($con,$fetch_query);
                    $show = mysqli_fetch_array($result);
                    $response = [
                            'total_calls' => $show['total_calls'],
                            'call_duration' => $show['callDurationInHoursMinutes'],
                            'incoming' => $show['total_incoming_calls'],
                            'outgoing' => $show['total_outgoing_calls'],
                            'missed' => $show['total_missed_calls'],
                            'rejected' => $show['total_rejected_calls'],
                            'unique_clients' => $show['unique_client'],
                            'connected_calls' => $show['total_connected_calls']
                        ];
    
    echo json_encode($response);
}

if(isset($_GET['fetch_lweek_call']) || isset($_GET['fetch_lweek_call_staff'])){
    if(isset($_GET['fetch_lweek_call_staff'])){
        $fetch_query = "SELECT count(*) as total_calls, COUNT(DISTINCT(REPLACE(calls.phoneNumber, '+91', ''))) as unique_client,SUM(CASE WHEN calls.callStatus = 'Incoming' THEN 1 ELSE 0 END) AS total_incoming_calls,
                    SUM(CASE WHEN calls.callStatus = 'Missed' THEN 1 ELSE 0 END) AS total_missed_calls, SUM(CASE WHEN calls.callStatus = 'Outgoing' THEN 1 ELSE 0 END) AS total_outgoing_calls,
                    SUM(CASE WHEN calls.callStatus = 'Rejected' THEN 1 ELSE 0 END) AS total_rejected_calls,  SUM(CASE WHEN calls.callDuration > 0 THEN 1 ELSE 0 END) AS total_connected_calls, 
                    REPLACE(calls.phoneNumber, '+91', '') AS phoneNumber,
                    CONCAT(
                            FLOOR(SUM(calls.callDuration) / 3600), ' h ', 
                            FLOOR((SUM(calls.callDuration) % 3600) / 60), ' m'
                        ) AS callDurationInHoursMinutes,
                    DATE(STR_TO_DATE(calls.callDate, '%d-%m-%Y %H:%i:%s')) AS callDate,
                    REPLACE(calls.registeredNumber, '+91', '') AS registeredNumber,
                    users.firstname FROM call_logs calls LEFT JOIN users users ON REPLACE(calls.registeredNumber, '+91', '') = users.mobile
                    where DATE(STR_TO_DATE(calls.callDate, '%d-%m-%Y %H:%i:%s')) >= '$startDate' AND DATE(STR_TO_DATE(calls.callDate, '%d-%m-%Y %H:%i:%s')) <= '$endDate' AND REPLACE(calls.registeredNumber, '+91', '') like '%".$_SESSION['mobile']."%'";
    }
    if(isset($_GET['fetch_lweek_call'])){
    $fetch_query = "SELECT count(*) as total_calls, COUNT(DISTINCT(REPLACE(calls.phoneNumber, '+91', ''))) as unique_client,SUM(CASE WHEN calls.callStatus = 'Incoming' THEN 1 ELSE 0 END) AS total_incoming_calls,
                    SUM(CASE WHEN calls.callStatus = 'Missed' THEN 1 ELSE 0 END) AS total_missed_calls, SUM(CASE WHEN calls.callStatus = 'Outgoing' THEN 1 ELSE 0 END) AS total_outgoing_calls,
                    SUM(CASE WHEN calls.callStatus = 'Rejected' THEN 1 ELSE 0 END) AS total_rejected_calls,  SUM(CASE WHEN calls.callDuration > 0 THEN 1 ELSE 0 END) AS total_connected_calls, 
                    REPLACE(calls.phoneNumber, '+91', '') AS phoneNumber,
                    CONCAT(
                            FLOOR(SUM(calls.callDuration) / 3600), ' h ', 
                            FLOOR((SUM(calls.callDuration) % 3600) / 60), ' m'
                        ) AS callDurationInHoursMinutes,
                    DATE(STR_TO_DATE(calls.callDate, '%d-%m-%Y %H:%i:%s')) AS callDate,
                    REPLACE(calls.registeredNumber, '+91', '') AS registeredNumber,
                    users.firstname FROM call_logs calls LEFT JOIN users users ON REPLACE(calls.registeredNumber, '+91', '') = users.mobile
                    where DATE(STR_TO_DATE(calls.callDate, '%d-%m-%Y %H:%i:%s')) >= '$startDate' AND DATE(STR_TO_DATE(calls.callDate, '%d-%m-%Y %H:%i:%s')) <= '$endDate'";
    }
                    $result = mysqli_query($con,$fetch_query);
                    $show = mysqli_fetch_array($result);
                    $response = [
                            'total_calls' => $show['total_calls'],
                            'call_duration' => $show['callDurationInHoursMinutes'],
                            'incoming' => $show['total_incoming_calls'],
                            'outgoing' => $show['total_outgoing_calls'],
                            'missed' => $show['total_missed_calls'],
                            'rejected' => $show['total_rejected_calls'],
                            'unique_clients' => $show['unique_client'],
                            'connected_calls' => $show['total_connected_calls']
                        ];
    
    echo json_encode($response);
}

// Check if the request contains 'fetch_todays_call'
if ((isset($_POST['fetch_todays_call'])) || isset($_POST['fetch_todays_call_staff'])) {
    header('Content-Type: application/json');

if(isset($_POST['fetch_todays_call_staff'])){
   $query = "
        SELECT 
    DATE(STR_TO_DATE(callDate, '%d-%m-%Y %H:%i:%s')) AS callDate,
    COUNT(*) AS totalCalls
FROM 
    call_logs
WHERE 
    MONTH(STR_TO_DATE(callDate, '%d-%m-%Y %H:%i:%s')) = MONTH(CURDATE()) 
    AND YEAR(STR_TO_DATE(callDate, '%d-%m-%Y %H:%i:%s')) = YEAR(CURDATE())
    AND REPLACE(registeredNumber, '+91', '') like '%".$_SESSION['mobile']."%'
GROUP BY 
    DATE(STR_TO_DATE(callDate, '%d-%m-%Y %H:%i:%s'))
ORDER BY 
    DATE(STR_TO_DATE(callDate, '%d-%m-%Y %H:%i:%s')) ASC
    "; 
}
if(isset($_POST['fetch_todays_call'])){
// Database query has already been verified, so no changes here
$query = "
        SELECT 
    DATE(STR_TO_DATE(callDate, '%d-%m-%Y %H:%i:%s')) AS callDate,
    COUNT(*) AS totalCalls
FROM 
    call_logs
WHERE 
    MONTH(STR_TO_DATE(callDate, '%d-%m-%Y %H:%i:%s')) = MONTH(CURDATE()) 
    AND YEAR(STR_TO_DATE(callDate, '%d-%m-%Y %H:%i:%s')) = YEAR(CURDATE())
GROUP BY 
    DATE(STR_TO_DATE(callDate, '%d-%m-%Y %H:%i:%s'))
ORDER BY 
    DATE(STR_TO_DATE(callDate, '%d-%m-%Y %H:%i:%s')) ASC
    ";
}
$result = mysqli_query($con, $query);

$data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = [
        'date' => $row['callDate'],
        'totalCalls' => (int) $row['totalCalls']
    ];
}

// Output JSON
echo json_encode($data);
exit;
}

if (isset($_POST['fetch_client_stats']) || isset($_POST['fetch_client_stats_staff'])) {
    // Replace this query with your actual logic to fetch the data
    if(isset($_POST['fetch_client_stats_staff'])){
        $query = "
        SELECT 
            COUNT(DISTINCT REPLACE(phoneNumber, '+91', '')) AS uniqueCalls,
            COUNT(*) AS totalCalls
        FROM call_logs where DATE(STR_TO_DATE(callDate, '%d-%m-%Y %H:%i:%s')) = '$currentDate' AND REPLACE(registeredNumber, '+91', '') like '%".$_SESSION['mobile']."%'
    ";
    }
    if(isset($_POST['fetch_client_stats'])){
    $query = "
        SELECT 
            COUNT(DISTINCT REPLACE(phoneNumber, '+91', '')) AS uniqueCalls,
            COUNT(*) AS totalCalls
        FROM call_logs where DATE(STR_TO_DATE(callDate, '%d-%m-%Y %H:%i:%s')) = '$currentDate'
    ";
    }
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);

    $data = [
        'uniqueCalls' => (int) $row['uniqueCalls'],
        'totalCalls' => (int) $row['totalCalls']
    ];

    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
}

if (isset($_POST['fetch_call_status']) || isset($_POST['fetch_call_status_staff'])) {
    // Replace this query with your actual logic to fetch the data
    if(isset($_POST['fetch_call_status_staff'])){
    $query = "
        SELECT 
            SUM(CASE WHEN callStatus = 'Incoming' THEN 1 ELSE 0 END) AS incoming,
            SUM(CASE WHEN callStatus = 'Outgoing' THEN 1 ELSE 0 END) AS outgoing,
            SUM(CASE WHEN callStatus = 'Missed' THEN 1 ELSE 0 END) AS missed,
            SUM(CASE WHEN callStatus = 'Rejected' THEN 1 ELSE 0 END) AS rejected,
            SUM(CASE WHEN callDuration > 0 THEN 1 ELSE 0 END) AS total_connected_calls
        FROM call_logs where DATE(STR_TO_DATE(callDate, '%d-%m-%Y %H:%i:%s')) = '$currentDate' AND REPLACE(registeredNumber, '+91', '') like '%".$_SESSION['mobile']."%'
    ";
    }
    if(isset($_POST['fetch_call_status'])){
    $query = "
        SELECT 
            SUM(CASE WHEN callStatus = 'Incoming' THEN 1 ELSE 0 END) AS incoming,
            SUM(CASE WHEN callStatus = 'Outgoing' THEN 1 ELSE 0 END) AS outgoing,
            SUM(CASE WHEN callStatus = 'Missed' THEN 1 ELSE 0 END) AS missed,
            SUM(CASE WHEN callStatus = 'Rejected' THEN 1 ELSE 0 END) AS rejected,
            SUM(CASE WHEN callDuration > 0 THEN 1 ELSE 0 END) AS total_connected_calls
        FROM call_logs where DATE(STR_TO_DATE(callDate, '%d-%m-%Y %H:%i:%s')) = '$currentDate'
    ";
    }
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);

    $data = [
        'incoming' => (int) $row['incoming'],
        'outgoing' => (int) $row['outgoing'],
        'missed' => (int) $row['missed'],
        'rejected' => (int) $row['rejected'],
        'connected' => (int) $row['total_connected_calls']
    ];

    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
}

if(isset($_GET['getStaffCall_log'])){
    $no = 1;
    $callReport_Fdate = isset($_GET['callReport_Fdate']) && !empty($_GET['callReport_Fdate']) ? $_GET['callReport_Fdate'] : null;
    $callReport_Tdate = isset($_GET['callReport_Tdate']) && !empty($_GET['callReport_Tdate']) ? $_GET['callReport_Tdate'] : null;
    $conditions = []; // Array to hold conditions dynamically
    if ($callReport_Fdate == "" && $callReport_Tdate == "") {
        $conditions[] = "DATE(STR_TO_DATE(calls.callDate, '%d-%m-%Y %H:%i:%s')) = '$currentDate'";
    } else {
        // Build conditions based on the filters provided
        if ($callReport_Fdate) {
            $conditions[] = "DATE(STR_TO_DATE(calls.callDate, '%d-%m-%Y %H:%i:%s')) >= '$callReport_Fdate'";
        }
        if ($callReport_Tdate) {
            $conditions[] = "DATE(STR_TO_DATE(calls.callDate, '%d-%m-%Y %H:%i:%s')) <= '$callReport_Tdate'";
        }
    }
    // Combine conditions
    $whereClause = !empty($conditions) ? "WHERE " . implode(" AND ", $conditions) : "";
    
    $fetch_query = "SELECT count(*) as total_calls, COUNT(DISTINCT(REPLACE(calls.phoneNumber, '+91', ''))) as unique_client,
    SUM(CASE WHEN calls.callStatus = 'Incoming' THEN 1 ELSE 0 END) AS total_incoming_calls,
    SUM(CASE WHEN calls.callStatus = 'Missed' THEN 1 ELSE 0 END) AS total_missed_calls,
    SUM(CASE WHEN calls.callStatus = 'Outgoing' THEN 1 ELSE 0 END) AS total_outgoing_calls,
    SUM(CASE WHEN calls.callStatus = 'Rejected' THEN 1 ELSE 0 END) AS total_rejected_calls,
    SUM(CASE WHEN calls.callDuration > 0 THEN 1 ELSE 0 END) AS total_connected_calls, 
    SUM(CASE WHEN calls.callStatus = 'Outgoing' AND calls.callDuration = 0 then 1 else 0 end) as not_picked,
    REPLACE(calls.phoneNumber, '+91', '') AS phoneNumber,
    CONCAT(
            FLOOR(SUM(calls.callDuration) / 3600), ' h ', 
            FLOOR((SUM(calls.callDuration) % 3600) / 60), ' m'
        ) AS callDurationInHoursMinutes,
    DATE(STR_TO_DATE(calls.callDate, '%d-%m-%Y %H:%i:%s')) AS callDate,
    REPLACE(calls.registeredNumber, '+91', '') AS registeredNumber,
    ROUND(SUM(CASE WHEN calls.callDuration > 0 THEN 1 ELSE 0 END)*100/count(*),2) as convertion_rate,
    users.firstname FROM call_logs calls LEFT JOIN users users ON REPLACE(calls.registeredNumber, '+91', '') = users.mobile
    $whereClause group by REPLACE(calls.registeredNumber, '+91', '')";
    $result = mysqli_query($con,$fetch_query);
    while($show = mysqli_fetch_array($result)){ ?>
        <tr>
            <td><?= $no; ?></td>
            <td><?= $show['firstname']; ?></td>
            <td><a href="#" class="dial-client" data-client-mobile="<?php echo $show['registeredNumber']; ?>">
                <?php echo $show['registeredNumber']; ?></td>
            <td><?= $show['total_calls']; ?></td>
            <td><?= $show['callDurationInHoursMinutes']; ?></td>
            <td><?= $show['unique_client']; ?></td>
            <td><?= $show['total_connected_calls']; ?></td>
            <td><?= $show['total_incoming_calls']; ?></td>
            <td><?= $show['total_outgoing_calls']; ?></td>
            <td><?= $show['total_missed_calls']; ?></td>
            <td><?= $show['total_rejected_calls']; ?></td>
            <td><?= $show['not_picked']; ?></td>
            <td><?= $show['convertion_rate'].' %'; ?></td>
        </tr>
    <?php $no++;} 
}
if(isset($_GET['fromDate'])){
    $no = 1;
    $fromDate = isset($_GET['fromDate']) && !empty($_GET['fromDate']) ? $_GET['fromDate'] : null;
    $toDate = isset($_GET['toDate']) && !empty($_GET['toDate']) ? $_GET['toDate'] : null;
    $employee = isset($_GET['employee']) && !empty($_GET['employee']) ? $_GET['employee'] : null;
    $callStatus = isset($_GET['callStatus']) && !empty($_GET['callStatus']) ? $_GET['callStatus'] : null;
    $conditions = []; // Array to hold conditions dynamically
    // Build conditions
    // Check if all filters are empty
    if ($fromDate == "" && $toDate == "" && $employee == "" && $callStatus == "") {
        $conditions[] = "DATE(STR_TO_DATE(calls.callDate, '%d-%m-%Y %H:%i:%s')) = '$currentDate'";
    } else {
        // Build conditions based on the filters provided
        if ($fromDate) {
            $conditions[] = "DATE(STR_TO_DATE(calls.callDate, '%d-%m-%Y %H:%i:%s')) >= '$fromDate'";
        }
        if ($toDate) {
            $conditions[] = "DATE(STR_TO_DATE(calls.callDate, '%d-%m-%Y %H:%i:%s')) <= '$toDate'";
        }
        if ($employee) {
            $conditions[] = "REPLACE(calls.registeredNumber, '+91', '') IN (SELECT mobile FROM users WHERE id = '$employee')";
        }
        if ($callStatus) {
            $conditions[] = "calls.callStatus = '$callStatus'";
        }
    }
    // Combine conditions
    $whereClause = !empty($conditions) ? "WHERE " . implode(" AND ", $conditions) : "";
    // echo $fetch_query;
    $fetch_query = "
            SELECT 
                calls.id,
                DATE(STR_TO_DATE(calls.callDate, '%d-%m-%Y %H:%i:%s')) AS callDate,
                TIME(STR_TO_DATE(calls.callDate, '%d-%m-%Y %H:%i:%s')) AS callTime,
                REPLACE(calls.registeredNumber, '+91', '') AS registeredNumber,
                REPLACE(calls.phoneNumber, '+91', '') AS phoneNumber,
                calls.callStatus,
                calls.client_name,
                CONCAT(
                    FLOOR(calls.callDuration / 3600), ' h ',
                    FLOOR((calls.callDuration % 3600) / 60), ' m ',
                    calls.callDuration % 60, ' s'
                ) AS callDurationInHoursMinutesSeconds,
                users.firstname
            FROM 
                call_logs calls
            LEFT JOIN users users ON REPLACE(calls.registeredNumber, '+91', '') = users.mobile
            $whereClause order by id desc";
    $result = mysqli_query($con,$fetch_query);
    while($show = mysqli_fetch_array($result)){ ?>
        <tr>
            <td><?= $no; ?></td>
            <td><?= $show['firstname']; ?></td>
            <td><?= $show['registeredNumber']; ?></td>
            <td><?= $show['phoneNumber']; ?></td>
            <td><?= $show['client_name']; ?></td>
            <td><?= $show['callDate']; ?></td>
            <td><?= $show['callTime']; ?></td>
            <td><?= $show['callStatus']; ?></td>
            <td><?= $show['callDurationInHoursMinutesSeconds']; ?></td>
        </tr>
    <?php $no++;} 
}

if(isset($_POST['aric_users'])){
    $users = $_POST['aric_users'];
    $timePeriod = $_POST['aric_time'];
    // Wrap each user ID in single quotes
$users = array_map(function($user) {
    return "'" . $user . "'";
}, $users);

// Convert the array to a comma-separated string
$usersString = implode(',', $users);
    $startDate = date('Y-m-d', strtotime("-$timePeriod days"));
     
    $query = "SELECT users.mobile,users.username, 
                 SUM(calls.callDuration) AS totalCallDuration, 
                 DATE(STR_TO_DATE(calls.callDate, '%d-%m-%Y %H:%i:%s')) AS callDate
          FROM call_logs calls 
          LEFT JOIN users ON REPLACE(calls.registeredNumber, '+91', '') = users.mobile
          WHERE REPLACE(calls.registeredNumber, '+91', '') IN ($usersString) 
          AND DATE(STR_TO_DATE(calls.callDate, '%d-%m-%Y %H:%i:%s')) >= '$startDate'
          GROUP BY users.mobile, DATE(STR_TO_DATE(calls.callDate, '%d-%m-%Y %H:%i:%s')) ORDER BY `callDate` ASC";

    $result = mysqli_query($con, $query);
    
    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
    
    // Format data for Chart.js
    $labels = [];
    $datasets = [];
    foreach ($data as $item) {
        if (!in_array($item['callDate'], $labels)) {
            $labels[] = $item['callDate'];
        }
    
        $datasets[$item['username']]['label'] = $item['username'];
        $datasets[$item['username']]['data'][] = $item['totalCallDuration'] / 60; // Convert to minutes
        $datasets[$item['username']]['borderColor'] = '#' . dechex(rand(0x000000, 0xFFFFFF));
        $datasets[$item['username']]['fill'] = false;
    }
    
    echo json_encode(['labels' => $labels, 'datasets' => array_values($datasets)]);
}

if(isset($_POST['total_users'])){
    $users = $_POST['total_users'];
    $timePeriod = $_POST['total_time'];
    $users = array_map(function($user) {
    return "'" . $user . "'";
}, $users);
    $usersString = implode(',', $users);
    $startDate = date('Y-m-d', strtotime("-$timePeriod days"));
    
    $query = "SELECT users.mobile,users.username, 
                 count(*) as total_calls, 
                 DATE(STR_TO_DATE(calls.callDate, '%d-%m-%Y %H:%i:%s')) AS callDate
          FROM call_logs calls 
          LEFT JOIN users ON REPLACE(calls.registeredNumber, '+91', '') = users.mobile
          WHERE REPLACE(calls.registeredNumber, '+91', '') IN ($usersString) 
          AND DATE(STR_TO_DATE(calls.callDate, '%d-%m-%Y %H:%i:%s')) >= '$startDate'
          GROUP BY users.mobile, DATE(STR_TO_DATE(calls.callDate, '%d-%m-%Y %H:%i:%s')) ORDER BY `callDate` ASC";

    $result = mysqli_query($con, $query);
    
    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
    
    // Format data for Chart.js
    $labels = [];
    $datasets = [];
    foreach ($data as $item) {
        if (!in_array($item['callDate'], $labels)) {
            $labels[] = $item['callDate'];
        }
    
        $datasets[$item['username']]['label'] = $item['username'];
        $datasets[$item['username']]['data'][] = $item['total_calls'];
        $datasets[$item['username']]['borderColor'] = '#' . dechex(rand(0x000000, 0xFFFFFF));
        $datasets[$item['username']]['fill'] = false;
    }
    
    echo json_encode(['labels' => $labels, 'datasets' => array_values($datasets)]);
}

if(isset($_POST['income_users'])){
    $users = $_POST['income_users'];
    $timePeriod = $_POST['income_time'];
    $users = array_map(function($user) {
    return "'" . $user . "'";
}, $users);
    $usersString = implode(',', $users);
    $startDate = date('Y-m-d', strtotime("-$timePeriod days"));
    
    $query = "SELECT users.mobile,users.username, 
                 count(*) as total_calls, 
                 DATE(STR_TO_DATE(calls.callDate, '%d-%m-%Y %H:%i:%s')) AS callDate
          FROM call_logs calls 
          LEFT JOIN users ON REPLACE(calls.registeredNumber, '+91', '') = users.mobile
          WHERE REPLACE(calls.registeredNumber, '+91', '') IN ($usersString) 
          AND DATE(STR_TO_DATE(calls.callDate, '%d-%m-%Y %H:%i:%s')) >= '$startDate' AND calls.callStatus = 'Incoming'
          GROUP BY users.mobile, DATE(STR_TO_DATE(calls.callDate, '%d-%m-%Y %H:%i:%s')) ORDER BY `callDate` ASC";

    $result = mysqli_query($con, $query);
    
    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
    
    // Format data for Chart.js
    $labels = [];
    $datasets = [];
    foreach ($data as $item) {
        if (!in_array($item['callDate'], $labels)) {
            $labels[] = $item['callDate'];
        }
    
        $datasets[$item['username']]['label'] = $item['username'];
        $datasets[$item['username']]['data'][] = $item['total_calls'];
        $datasets[$item['username']]['borderColor'] = '#' . dechex(rand(0x000000, 0xFFFFFF));
        $datasets[$item['username']]['fill'] = false;
    }
    
    echo json_encode(['labels' => $labels, 'datasets' => array_values($datasets)]);
}

if(isset($_POST['outgoing_users'])){
    $users = $_POST['outgoing_users'];
    $timePeriod = $_POST['outgoing_time'];
    $users = array_map(function($user) {
    return "'" . $user . "'";
}, $users);
    $usersString = implode(',', $users);
    $startDate = date('Y-m-d', strtotime("-$timePeriod days"));
    
    $query = "SELECT users.mobile,users.username, 
                 count(*) as total_calls, 
                 DATE(STR_TO_DATE(calls.callDate, '%d-%m-%Y %H:%i:%s')) AS callDate
          FROM call_logs calls 
          LEFT JOIN users ON REPLACE(calls.registeredNumber, '+91', '') = users.mobile
          WHERE REPLACE(calls.registeredNumber, '+91', '') IN ($usersString) 
          AND DATE(STR_TO_DATE(calls.callDate, '%d-%m-%Y %H:%i:%s')) >= '$startDate' AND calls.callStatus = 'Outgoing'
          GROUP BY users.mobile, DATE(STR_TO_DATE(calls.callDate, '%d-%m-%Y %H:%i:%s')) ORDER BY `callDate` ASC";

    $result = mysqli_query($con, $query);
    
    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
    
    // Format data for Chart.js
    $labels = [];
    $datasets = [];
    foreach ($data as $item) {
        if (!in_array($item['callDate'], $labels)) {
            $labels[] = $item['callDate'];
        }
    
        $datasets[$item['username']]['label'] = $item['username'];
        $datasets[$item['username']]['data'][] = $item['total_calls'];
        $datasets[$item['username']]['borderColor'] = '#' . dechex(rand(0x000000, 0xFFFFFF));
        $datasets[$item['username']]['fill'] = false;
    }
    
    echo json_encode(['labels' => $labels, 'datasets' => array_values($datasets)]);
}

if(isset($_POST['missed_users'])){
    $users = $_POST['missed_users'];
    $timePeriod = $_POST['missed_time'];
    $users = array_map(function($user) {
    return "'" . $user . "'";
}, $users);
    $usersString = implode(',', $users);
    $startDate = date('Y-m-d', strtotime("-$timePeriod days"));
    
    $query = "SELECT users.mobile,users.username, 
                 count(*) as total_calls, 
                 DATE(STR_TO_DATE(calls.callDate, '%d-%m-%Y %H:%i:%s')) AS callDate
          FROM call_logs calls 
          LEFT JOIN users ON REPLACE(calls.registeredNumber, '+91', '') = users.mobile
          WHERE REPLACE(calls.registeredNumber, '+91', '') IN ($usersString) 
          AND DATE(STR_TO_DATE(calls.callDate, '%d-%m-%Y %H:%i:%s')) >= '$startDate' AND calls.callStatus = 'Missed'
          GROUP BY users.mobile, DATE(STR_TO_DATE(calls.callDate, '%d-%m-%Y %H:%i:%s')) ORDER BY `callDate` ASC";

    $result = mysqli_query($con, $query);
    
    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
    
    // Format data for Chart.js
    $labels = [];
    $datasets = [];
    foreach ($data as $item) {
        if (!in_array($item['callDate'], $labels)) {
            $labels[] = $item['callDate'];
        }
    
        $datasets[$item['username']]['label'] = $item['username'];
        $datasets[$item['username']]['data'][] = $item['total_calls'];
        $datasets[$item['username']]['borderColor'] = '#' . dechex(rand(0x000000, 0xFFFFFF));
        $datasets[$item['username']]['fill'] = false;
    }
    
    echo json_encode(['labels' => $labels, 'datasets' => array_values($datasets)]);
}

if(isset($_POST['rejected_users'])){
    $users = $_POST['rejected_users'];
    $users = array_map(function($user) {
    return "'" . $user . "'";
}, $users);
    $timePeriod = $_POST['rejected_time'];
    $usersString = implode(',', $users);
    $startDate = date('Y-m-d', strtotime("-$timePeriod days"));
    
    $query = "SELECT users.mobile,users.username, 
                 count(*) as total_calls, 
                 DATE(STR_TO_DATE(calls.callDate, '%d-%m-%Y %H:%i:%s')) AS callDate
          FROM call_logs calls 
          LEFT JOIN users ON REPLACE(calls.registeredNumber, '+91', '') = users.mobile
          WHERE REPLACE(calls.registeredNumber, '+91', '') IN ($usersString) 
          AND DATE(STR_TO_DATE(calls.callDate, '%d-%m-%Y %H:%i:%s')) >= '$startDate' AND calls.callStatus = 'Rejected'
          GROUP BY users.mobile, DATE(STR_TO_DATE(calls.callDate, '%d-%m-%Y %H:%i:%s')) ORDER BY `callDate` ASC";

    $result = mysqli_query($con, $query);
    
    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
    
    // Format data for Chart.js
    $labels = [];
    $datasets = [];
    foreach ($data as $item) {
        if (!in_array($item['callDate'], $labels)) {
            $labels[] = $item['callDate'];
        }
    
        $datasets[$item['username']]['label'] = $item['username'];
        $datasets[$item['username']]['data'][] = $item['total_calls'];
        $datasets[$item['username']]['borderColor'] = '#' . dechex(rand(0x000000, 0xFFFFFF));
        $datasets[$item['username']]['fill'] = false;
    }
    
    echo json_encode(['labels' => $labels, 'datasets' => array_values($datasets)]);
}

if(isset($_POST['unique_users'])){
    $users = $_POST['unique_users'];
    $users = array_map(function($user) {
    return "'" . $user . "'";
}, $users);
    $timePeriod = $_POST['unique_time'];
    $usersString = implode(',', $users);
    $startDate = date('Y-m-d', strtotime("-$timePeriod days"));
    
    $query = "SELECT users.mobile,users.username, COUNT(DISTINCT(REPLACE(calls.phoneNumber, '+91', ''))) as total_calls,
                 DATE(STR_TO_DATE(calls.callDate, '%d-%m-%Y %H:%i:%s')) AS callDate
          FROM call_logs calls 
          LEFT JOIN users ON REPLACE(calls.registeredNumber, '+91', '') = users.mobile
          WHERE REPLACE(calls.registeredNumber, '+91', '') IN ($usersString) 
          AND DATE(STR_TO_DATE(calls.callDate, '%d-%m-%Y %H:%i:%s')) >= '$startDate'
          GROUP BY users.mobile, DATE(STR_TO_DATE(calls.callDate, '%d-%m-%Y %H:%i:%s')) ORDER BY `callDate` ASC";

    $result = mysqli_query($con, $query);
    
    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
    
    // Format data for Chart.js
    $labels = [];
    $datasets = [];
    foreach ($data as $item) {
        if (!in_array($item['callDate'], $labels)) {
            $labels[] = $item['callDate'];
        }
    
        $datasets[$item['username']]['label'] = $item['username'];
        $datasets[$item['username']]['data'][] = $item['total_calls'];
        $datasets[$item['username']]['borderColor'] = '#' . dechex(rand(0x000000, 0xFFFFFF));
        $datasets[$item['username']]['fill'] = false;
    }
    
    echo json_encode(['labels' => $labels, 'datasets' => array_values($datasets)]);
}

if(isset($_POST['connect_users'])){
    $users = $_POST['connect_users'];
    $users = array_map(function($user) {
    return "'" . $user . "'";
}, $users);
    $timePeriod = $_POST['connect_time'];
    $usersString = implode(',', $users);
    $startDate = date('Y-m-d', strtotime("-$timePeriod days"));
    
    $query = "SELECT users.mobile,users.username, SUM(CASE WHEN calls.callDuration > 0 THEN 1 ELSE 0 END) AS total_calls,
                 DATE(STR_TO_DATE(calls.callDate, '%d-%m-%Y %H:%i:%s')) AS callDate
          FROM call_logs calls 
          LEFT JOIN users ON REPLACE(calls.registeredNumber, '+91', '') = users.mobile
          WHERE REPLACE(calls.registeredNumber, '+91', '') IN ($usersString) 
          AND DATE(STR_TO_DATE(calls.callDate, '%d-%m-%Y %H:%i:%s')) >= '$startDate'
          GROUP BY users.mobile, DATE(STR_TO_DATE(calls.callDate, '%d-%m-%Y %H:%i:%s')) ORDER BY `callDate` ASC";

    $result = mysqli_query($con, $query);
    
    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
    
    // Format data for Chart.js
    $labels = [];
    $datasets = [];
    foreach ($data as $item) {
        if (!in_array($item['callDate'], $labels)) {
            $labels[] = $item['callDate'];
        }
    
        $datasets[$item['username']]['label'] = $item['username'];
        $datasets[$item['username']]['data'][] = $item['total_calls'];
        $datasets[$item['username']]['borderColor'] = '#' . dechex(rand(0x000000, 0xFFFFFF));
        $datasets[$item['username']]['fill'] = false;
    }
    
    echo json_encode(['labels' => $labels, 'datasets' => array_values($datasets)]);
}
?>

