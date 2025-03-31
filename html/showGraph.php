<?php
include_once 'connection.php';
session_start();

if (isset($_POST['btnID'])) {
    $user = $_POST['btnID'];

    $atus_query = "SELECT 
                      DATE(`current_date`) AS curr_date,
                      user,
                      SUM(Client) AS Client,
                      SUM(Rejected) AS Rejected,
                      SUM(Interested) AS Interested,
                      SUM(Hot) AS Hot,
                      SUM(Warm) AS Warm 
                   FROM `call_status_report`
                   GROUP BY user, curr_date 
                   HAVING curr_date >= DATE_SUB(CURRENT_DATE, INTERVAL 5 DAY) 
                      AND curr_date <= CURRENT_DATE 
                      AND `user` = '$user'";

    $Stus_res = mysqli_query($con, $atus_query);
    $chartData = [];

    while ($sho_Status = mysqli_fetch_array($Stus_res)) {
        $chartData[] = [
            'curr_date' => $sho_Status['curr_date'],
            'Client' => (int)$sho_Status['Client'],
            'Hot' => (int)$sho_Status['Hot'],
            'Interested' => (int)$sho_Status['Interested'],
            'Rejected' => (int)$sho_Status['Rejected'],
            'Warm' => (int)$sho_Status['Warm']
        ];
    }

    echo json_encode($chartData);
}
?>
