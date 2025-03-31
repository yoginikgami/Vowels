<?php
include_once 'ltr/header.php';
include_once 'connection.php';
$Timezone = date_default_timezone_set('Asia/Kolkata');
$date = date('Y-m-d');
$alertMsg = "";
$alertClass = "";

// Fetch all users under the company
$query = "SELECT * FROM `users` WHERE `company_id` = '$company_id'";
$Query_res = mysqli_query($con, $query);

if (isset($_SESSION['company_id'])) {
  $fetch_user_data = "SELECT * FROM `users` WHERE `company_id` = '" . $_SESSION['company_id'] . "' AND `id` = '" . $_SESSION['user_id'] . "'";
  $run_fetch_user_data = mysqli_query($con, $fetch_user_data);
  $userrow = mysqli_fetch_array($run_fetch_user_data);
}
$query = "SELECT * FROM `users` WHERE `company_id` = '" . $_SESSION['company_id'] . "'";
$Query_res = mysqli_query($con, $query);

while ($Query_show = mysqli_fetch_array($Query_res)) {
  $columnName = $Query_show['username'];

  // Check if the column already exists
  $checkColumnQuery = "
        SELECT COUNT(*) AS column_exists 
        FROM INFORMATION_SCHEMA.COLUMNS 
        WHERE TABLE_NAME = 'chat' 
        AND COLUMN_NAME = '$columnName'
    ";
  $checkColumnResult = mysqli_query($con, $checkColumnQuery);
  $columnExistsRow = mysqli_fetch_assoc($checkColumnResult);

  // Add column if it does not exist
  if ($columnExistsRow['column_exists'] == 0) {
    $alterchatQuery = "ALTER TABLE `chat` ADD COLUMN `$columnName` INT(1) DEFAULT 0";
    mysqli_query($con, $alterchatQuery);
  }
}

$Status_query = "select date(`current_date`) as curr_date,user,SUM(Client) as Client,SUM(Hot) as Hot,SUM(Interested) as Interested,SUM(Rejected) as Rejected,SUM(Warm) as Warm from `call_status_report` group by curr_date,user HAVING curr_date >= DATE_SUB(CURRENT_DATE, INTERVAL 5 DAY) AND curr_date <= CURRENT_DATE order by current_date asc";
$Status_res = mysqli_query($con, $Status_query);
$chart_data = '';
while ($show_Status = mysqli_fetch_array($Status_res)) {
  $userStatus[] = $show_Status['user'];
  $totalStatus[] = $show_Status['Client'] + $show_Status['Hot'] + $show_Status['Interested'] + $show_Status['Rejected'] + $show_Status['Warm'];
}
?>
<!DOCTYPE html>
<html>

<head>
  <title>Vowel Enterprise CMS - Recipient Master</title>

  <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
  <script src='assets/bootstrap/js/bootstrap.min.js'></script>

  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://kit.fontawesome.com/d3dd33a66d.js" crossorigin="anonymous"></script>
  <!--script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script-->
  <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
  <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
  <!--<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet"/>-->
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
  <!--<link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.1.0/mdb.min.css" rel="stylesheet"/>-->
  <script type="text/javascript" src="js/virtual-select.min.js"></script>
  <link rel="stylesheet" href="//cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
  <script src="https://code.jquery.com/jquery-3.6.3.js" integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM=" crossorigin="anonymous"></script>

  <style>
    .calendar {
      width: 370px;
      box-shadow: 0px 0px 35px -16px rgba(0, 0, 0, 0.75);
      font-family: 'Roboto', sans-serif;
      padding: 20px 30px;
      color: #363b41;
      display: inline-block;
      height: 500px;
      overflow-y: scroll;
    }

    .calendar_header {
      border-bottom: 2px solid rgba(0, 0, 0, 0.08);
    }

    .header_copy {
      color: light_grey;
      font-size: 20px;
    }

    /*.calendar_plan{*/
    /*  margin:0px 0 10px;*/
    /*}*/
    .cl_plan {
      width: 100%;
      height: 80px;
      background-image: linear-gradient(-222deg, #FF8494, #ffa9b7);
      box-shadow: 0px 0px 32px -18px rgba(0, 0, 0, 0.75);
      padding: 10px;
      color: #fff;
    }

    .cl_title {}

    .cl_copy {
      font-size: 20px;
      margin: 10px 0;
      display: inline-block;
    }

    /*.cl_add{*/
    /*  display: inline-block;*/
    /*  width: 40px;*/
    /*  height:40px;*/
    /*  border-radius:50%;*/
    /*  background-color: #fff;*/
    /*  cursor: pointer;*/
    /*  margin:0 0 0 65px;*/
    /*  color:#c2c2c2;*/
    /*  padding: 11px 13px;*/
    /*}*/
    .calendar_events {
      color: light_grey;
    }

    /*.ce_title{*/
    /*  font-size:14px;*/
    /*}*/

    .event_item {
      margin: 18px 0;
      padding: 5px;
      cursor: pointer;

      &:hover {
        background-image: linear-gradient(-222deg, #FF8494, #ffa9b7);
        box-shadow: 0px 0px 52px -18px rgba(0, 0, 0, 0.75);

        .ei_Dot {
          background-color: #fff;
        }

        .ei_Copy,
        .ei_Title {
          color: #fff;
        }
      }
    }

    .ei_Dot,
    .ei_Title {
      display: inline-block;
    }

    .ei_Dot {
      border-radius: 50%;
      width: 10px;
      height: 10px;
      background-color: light_grey;
      box-shadow: 0px 0px 52px -18px rgba(0, 0, 0, 0.75);
    }

    .dot_active {
      background-color: #FF8494;
    }

    .ei_Title {
      margin-left: 10px;
      color: #363b41;
    }

    .ei_Copy {
      font-size: 12px;
      margin-left: 27px;
    }

    .dark {
      background-image: linear-gradient(-222deg, #646464, #454545);
      color: #fff;

      .header_title,
      .ei_Title,
      .ce_title {
        color: #fff;
      }

    }
  </style>
</head>

<body>

  <?php
  $queryInt = "select username2,count(username2) as Total_update from `addInterested_Status` where `modify_by` = date('$date') group by username2";
  $IntResult = mysqli_query($con, $queryInt);
  while ($Intshow = mysqli_fetch_array($IntResult)) {
    $selectInt = "select user,Interested,current_date from `call_user_report` where `user` = '" . $Intshow['username2'] . "' and `current_date` = date('$date')";
    $selectIntResult = mysqli_query($con, $selectInt);
    $selectIntResult = mysqli_num_rows($selectIntResult);
    if ($selectIntResult > 0) {
      $updateInt = "update `call_user_report` set `Interested` = '" . $Intshow['Total_update'] . "' where `user` = '" . $Intshow['username2'] . "' and current_date = date('$date')";
      mysqli_query($con, $updateInt);
    } else {
      $query = "insert into `call_user_report`(`user`,`Interested`,`current_date`) values('" . $Intshow['username2'] . "','" . $Intshow['Total_update'] . "',date('$date'))";
      $result = mysqli_query($con, $query);
    }
  }
  $queryHot = "select username2,count(username2) as Total_update from `addHot_Status` where `modify_by` = date('$date') group by username2";
  $HotResult = mysqli_query($con, $queryHot);
  while ($Hotshow = mysqli_fetch_array($HotResult)) {
    $selectHot = "select user,Hot,current_date from `call_user_report` where `user` = '" . $Hotshow['username2'] . "' and `current_date` = date('$date')";
    $selectHotResult = mysqli_query($con, $selectHot);
    $selectHotResult = mysqli_num_rows($selectHotResult);
    if ($selectHotResult > 0) {
      $updateHot = "update `call_user_report` set `Hot` = '" . $Hotshow['Total_update'] . "' where `user` = '" . $Hotshow['username2'] . "' and `current_date` = date('$date')";
      mysqli_query($con, $updateHot);
    } else {
      $query = "insert into `call_user_report`(`user`,`Hot`,`current_date`) values('" . $Hotshow['username2'] . "','" . $Hotshow['Total_update'] . "',date('$date'))";
      $result = mysqli_query($con, $query);
    }
  }
  $queryClient = "select username2,count(username2) as Total_update from `addClient_Status` where `modify_by` = date('$date') group by username2";
  $ClientResult = mysqli_query($con, $queryClient);
  while ($Clientshow = mysqli_fetch_array($ClientResult)) {
    $selectClient = "select user,Client,current_date from `call_user_report` where `user` = '" . $Clientshow['username2'] . "' and `current_date` = date('$date')";
    $selectClientResult = mysqli_query($con, $selectClient);
    $selectClientResult = mysqli_num_rows($selectClientResult);
    if ($selectClientResult > 0) {
      $updateClient = "update `call_user_report` set `Client` = '" . $Clientshow['Total_update'] . "' where `user` = '" . $Clientshow['username2'] . "' and `current_date` = date('$date')";
      mysqli_query($con, $updateClient);
    } else {
      $query = "insert into `call_user_report`(`user`,`Client`,`current_date`) values('" . $Clientshow['username2'] . "','" . $Clientshow['Total_update'] . "',date('$date'))";
      $result = mysqli_query($con, $query);
    }
  }
  $queryRejected = "select username2,count(username2) as Total_update from `addRejected_Status` where `modify_by` = date('$date') group by username2";
  $RejectedResult = mysqli_query($con, $queryRejected);
  while ($Rejectedshow = mysqli_fetch_array($RejectedResult)) {
    $selectRej = "select user,Client,current_date from `call_user_report` where `user` = '" . $Rejectedshow['username2'] . "' and `current_date` = date('$date')";
    $selectRejResult = mysqli_query($con, $selectRej);
    $selectRejResult = mysqli_num_rows($selectRejResult);
    if ($selectRejResult > 0) {
      $updateRej = "update `call_user_report` set `Rejected` = '" . $Rejectedshow['Total_update'] . "' where `user` = '" . $Rejectedshow['username2'] . "' and `current_date` = date('$date')";
      mysqli_query($con, $updateRej);
    } else {
      $query = "insert into `call_user_report`(`user`,`Rejected`,`current_date`) values('" . $Rejectedshow['username2'] . "','" . $Rejectedshow['Total_update'] . "',date('$date'))";
      $result = mysqli_query($con, $query);
    }
  }
  $queryWarm = "select username2,count(username2) as Total_update from `addWarm_Status` where `modify_by` = date('$date') group by username2";
  $WarmResult = mysqli_query($con, $queryWarm);
  while ($Warmshow = mysqli_fetch_array($WarmResult)) {
    $selectWarm = "select user,Client,current_date from `call_user_report` where `user` = '" . $Warmshow['username2'] . "' and `current_date` = date('$date')";
    $selectWarmResult = mysqli_query($con, $selectWarm);
    $selectWarmResult = mysqli_num_rows($selectWarmResult);
    if ($selectWarmResult > 0) {
      $updateWarm = "update `call_user_report` set `Warm` = '" . $Warmshow['Total_update'] . "' where `user` = '" . $Warmshow['username2'] . "' and `current_date` = date('$date')";
      mysqli_query($con, $updateWarm);
    } else {
      $query = "insert into `call_user_report`(`user`,`Warm`,`current_date`) values('" . $Warmshow['username2'] . "','" . $Warmshow['Total_update'] . "',date('$date'))";
      $result = mysqli_query($con, $query);
    }
  }

  $testQ = "
                      (select username2,count(username2) as Total_status,'Warm' as ColumnName from `addWarm_Status` where `stat_modify_at` = date('$date') group by username2) union 
                      (select username2,count(username2) as Total_status,'Client' as ColumnName from `addClient_Status` where `stat_modify_at` = date('$date') group by username2) union
                      (select username2,count(username2) as Total_status,'Hot' as ColumnName from `addHot_Status` where `stat_modify_at` = date('$date') group by username2) union
                      (select username2,count(username2) as Total_status,'Interested' as ColumnName from `addInterested_Status` where `stat_modify_at` = date('$date') group by username2) union
                      (select username2,count(username2) as Total_status,'Rejected' as ColumnName from `addRejected_Status` where `stat_modify_at` = date('$date') group by username2)";

  $testRes = mysqli_query($con, $testQ);
  while ($show = mysqli_fetch_array($testRes)) {
    $sel = "select `user`,`" . $show['ColumnName'] . "`,current_date from `call_status_report` where `user` = '" . $show['username2'] . "' and `current_date` = date('$date')";
    $selsult = mysqli_query($con, $sel);
    $selectesult = mysqli_num_rows($selsult);
    if ($selectesult > 0) {
      $updaarm = "update `call_status_report` set `" . $show['ColumnName'] . "` = '" . $show['Total_status'] . "' where `user` = '" . $show['username2'] . "' and `current_date` = date('$date')";
      mysqli_query($con, $updaarm);
    } else {
      $addQ = "insert into `call_status_report`(`user`,`" . $show['ColumnName'] . "`,`current_date`) values ('" . $show['username2'] . "','" . $show['Total_status'] . "',date('$date'))";
      $addRes = mysqli_query($con, $addQ);
    }
  }
  ?>

  <?php
  $dateFrom = isset($_POST['filter_dd_from']) ? $_POST['filter_dd_from'] : date('Y-m-d');
  $dateTo = isset($_POST['filter_dd_to']) ? $_POST['filter_dd_to'] : date('Y-m-d');

  $usersFilter = "";
  if (isset($_POST['filterUser']) && !empty($_POST['filterUser'])) {
    $selectedUsers = implode("','", $_POST['filterUser']);
    $usersFilter = "AND users.username IN ('$selectedUsers')";
  }

  // Query to count different types of calls
  $query = "
          SELECT 
              calls.callStatus, 
              COUNT(*) as totalCalls
          FROM call_logs calls 
          LEFT JOIN users users ON REPLACE(calls.registeredNumber, '+91', '') = users.mobile
          WHERE DATE(STR_TO_DATE(calls.callDate, '%d-%m-%Y %H:%i:%s')) BETWEEN '$dateFrom' AND '$dateTo'
          $usersFilter
          GROUP BY calls.callStatus
      ";

  $result = mysqli_query($con, $query);
  $callData = [
    "Outgoing" => ["count" => 0],
    "Incoming" => ["count" => 0],
    "Missed" => ["count" => 0],
    "Rejected" => ["count" => 0]
  ];


  // Fetch results
  while ($row = mysqli_fetch_assoc($result)) {
    $callData[$row['callStatus']]['count'] = $row['totalCalls'];
  }

  $conditions = [];
  if ($dateFrom == "" && $dateTo == "") {
    $conditions[] = "DATE(STR_TO_DATE(calls.callDate, '%d-%m-%Y %H:%i:%s')) = '$currentDate'";
  } else {
    // Build conditions based on the filters provided
    if ($dateFrom) {
      $conditions[] = "DATE(STR_TO_DATE(calls.callDate, '%d-%m-%Y %H:%i:%s')) >= '$dateFrom'";
    }
    if ($dateTo) {
      $conditions[] = "DATE(STR_TO_DATE(calls.callDate, '%d-%m-%Y %H:%i:%s')) <= '$dateTo'";
    }
  }
  // Combine conditions and add the user filter
  $whereClause = !empty($conditions) ? "WHERE " . implode(" AND ", $conditions) : "WHERE 1";
  $whereClause .= " $usersFilter";

  $query = "
          SELECT count(*) as total_calls, COUNT(DISTINCT(REPLACE(calls.phoneNumber, '+91', ''))) as unique_client,
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

  $result = mysqli_query($con, $query);

  $dounatchart = "
    SELECT 
        COUNT(*) as total_calls, 
        COUNT(DISTINCT(REPLACE(calls.phoneNumber, '+91', ''))) as unique_calls,
        SUM(CASE WHEN calls.callDuration > 0 THEN 1 ELSE 0 END) AS total_connected_calls
    FROM call_logs calls 
    LEFT JOIN users users ON REPLACE(calls.registeredNumber, '+91', '') = users.mobile
    WHERE DATE(STR_TO_DATE(calls.callDate, '%d-%m-%Y %H:%i:%s')) BETWEEN '$dateFrom' AND '$dateTo'
    $usersFilter";

  $resultdounatchart = mysqli_query($con, $dounatchart);
  $data = mysqli_fetch_assoc($resultdounatchart);

  // Prepare JSON data for JavaScript
  $total_calls = $data['total_calls'] ?? 0;
  $unique_calls = $data['unique_calls'] ?? 0;
  $total_connected_calls = $data['total_connected_calls'] ?? 0;

  ?>
  <div class="container-fluid py-2">
    <div class="row g-3">
      <div class="col-md-12">
        <div class="card p-3 shadow-sm" style="background-color:rgb(248, 245, 250); border-radius:15px">
          <form method="post">
            <div class="row">
              <div class="col-md-4">
                <select name="filterUser[]" id="filterUser" class="form-control" multiple multiselect-search="true" placeholder="User Details" multiselect-select-all="true" style="height: 100px;color:black;">
                  <?php
                  if (($userrow['add_Admin_filter'] != 1) && ($userrow['crm_teamleader'] == 1)) {
                    $leader_member = explode(',', $userrow['username'] . ',' . $userrow['crm_teamMember']);
                    $members = implode("', '", $leader_member);
                    $user = "SELECT * FROM `users` WHERE `company_id` = '" . $_SESSION['company_id'] . "' AND `user_status` = 1 AND `username` IN ('$members') ORDER BY username";
                  } else {
                    $user = "SELECT * FROM `users` WHERE `company_id` = '" . $_SESSION['company_id'] . "' AND `user_status` = 1 ORDER BY username";
                  }

                  $user_result = mysqli_query($con, $user);
                  while ($user_show = mysqli_fetch_array($user_result)) {
                  ?>
                    <option value="<?= $user_show['username']; ?>" selected>
                      <?php echo ucfirst($user_show['firstname']) . " " . ucfirst($user_show['middlename']); ?>
                    </option>
                  <?php } ?>
                </select>
              </div>
              <div class="col-md-2">
                <input name="filter_dd_from" class="form-control" type="date" id="dd_from" required>
              </div>
              <div class="col-md-2">
                <input name="filter_dd_to" class="form-control" type="date" id="dd_to" required>
              </div>

              <!-- <div class="col"><button type="submit" name="showReport" id="showReport" class="btn btn-secondary">Lead Activity Report</button></div> -->
              <div class="col-md-2"><button type="submit" name="showStatus_report" id="showStatus_report" class="btn btn-secondary" style="width: 150px;">Submit</button></div>
          </form>
          <div class="col-md-2">
            <form method="post" action="Export_report.php">
              <input type="hidden" name="fuser" value="<?php if ((isset($_POST['showReport'])) || (isset($_POST['showStatus_report']))) {
                                                          echo implode("','", $_POST['filterUser']);
                                                        } ?>">
              <input type="hidden" name="ffrom" value="<?php if ((isset($_POST['showReport'])) || (isset($_POST['showStatus_report']))) {
                                                          echo $_POST['filter_dd_from'];
                                                        } ?>">
              <input type="hidden" name="fto" value="<?php if ((isset($_POST['showReport'])) || (isset($_POST['showStatus_report']))) {
                                                        echo $_POST['filter_dd_to'];
                                                      } ?>">
              <input type="hidden" name="ftable_name" value="<?php if (isset($_POST['showReport'])) {
                                                                echo "call_user_report";
                                                              } else {
                                                                echo "call_status_report";
                                                              } ?>" readonly>
              <button type="submit" name="Export_Report" id="Export_Report" class="btn btn-secondary" style="width: 150px;">Export Report</button>
              <!--<button type="submit" name="showReport" id="showReport">Show Report</button>-->
          </div>
          </form>
        </div>
      </div>
    </div>
    <!-- Lead Conversion Report -->

    <div class="col-md-12">
      <div class="card p-3 shadow-sm" style="background-color:rgb(248, 245, 250); border-radius:15px;">
        <center>
          <h4>Lead Conversion Report</h4>
        </center><br>
        <table class="table" id="status_report" style="border: 2px solid Green;">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Username</th>
              <th scope="col">Client</th>
              <th scope="col">Hot</th>
              <th scope="col">Interested</th>
              <th scope="col">Rejected</th>
              <th scope="col">Warm</th>
              <th scope="col">Date</th>
            </tr>
          </thead>
          <tbody>
            <?php
            if (isset($_POST['showStatus_report'])) {
              $no = 1;
              $user = array_map(function ($usr) use ($con) {
                return mysqli_real_escape_string($con, $usr);
              }, $_POST['filterUser']);
              $user = implode("','", $user);

              $fil_from = mysqli_real_escape_string($con, $_POST['filter_dd_from']);
              $fil_to = mysqli_real_escape_string($con, $_POST['filter_dd_to']);

              $query = "SELECT * FROM `call_status_report` 
                                  WHERE `user` IN ('$user') 
                                  AND `current_date` BETWEEN DATE('$fil_from') AND DATE('$fil_to')";
              $queryResult = mysqli_query($con, $query);

              $totalClient = $totalHot = $totalInterested = $totalRejected = $totalWarm = 0;

              while ($qShow = mysqli_fetch_array($queryResult)) {
                $totalClient += $qShow['Client'];
                $totalHot += $qShow['Hot'];
                $totalInterested += $qShow['Interested'];
                $totalRejected += $qShow['Rejected'];
                $totalWarm += $qShow['Warm'];
            ?>
                <tr>
                  <th scope="row"><?php echo $no; ?></th>
                  <td><?php echo htmlspecialchars($qShow['user']); ?></td>
                  <td><a href="view_client_details?client_id=<?php echo urlencode($qShow['user']); ?>&table_name=addClient_Status&fromDD=<?= $fil_from; ?>&toDD=<?= $fil_to; ?>" target="_blank"><?php echo $qShow['Client']; ?></a></td>
                  <td><a href="view_client_details?client_id=<?php echo urlencode($qShow['user']); ?>&table_name=addHot_Status&fromDD=<?= $fil_from; ?>&toDD=<?= $fil_to; ?>" target="_blank"><?php echo $qShow['Hot']; ?></a></td>
                  <td><a href="view_client_details?client_id=<?php echo urlencode($qShow['user']); ?>&table_name=addInterested_Status&fromDD=<?= $fil_from; ?>&toDD=<?= $fil_to; ?>" target="_blank"><?php echo $qShow['Interested']; ?></a></td>
                  <td><a href="view_client_details?client_id=<?php echo urlencode($qShow['user']); ?>&table_name=addRejected_Status&fromDD=<?= $fil_from; ?>&toDD=<?= $fil_to; ?>" target="_blank"><?php echo $qShow['Rejected']; ?></a></td>
                  <td><a href="view_client_details?client_id=<?php echo urlencode($qShow['user']); ?>&table_name=addWarm_Status&fromDD=<?= $fil_from; ?>&toDD=<?= $fil_to; ?>" target="_blank"><?php echo $qShow['Warm']; ?></a></td>
                  <td><?php echo htmlspecialchars($qShow['current_date']); ?></td>
                </tr>
              <?php
                $no++;
              }
              ?>
              <tr>
                <td><strong>Total:</strong></td>
                <td></td>
                <td><a href="view_client_details?new_total_table=addClient_Status&fromDD=<?= $fil_from; ?>&toDD=<?= $fil_to; ?>" target="_blank"><?php echo $totalClient; ?></a></td>
                <td><a href="view_client_details?new_total_table=addHot_Status&fromDD=<?= $fil_from; ?>&toDD=<?= $fil_to; ?>" target="_blank"><?php echo $totalHot; ?></a></td>
                <td><a href="view_client_details?new_total_table=addInterested_Status&fromDD=<?= $fil_from; ?>&toDD=<?= $fil_to; ?>" target="_blank"><?php echo $totalInterested; ?></a></td>
                <td><a href="view_client_details?new_total_table=addRejected_Status&fromDD=<?= $fil_from; ?>&toDD=<?= $fil_to; ?>" target="_blank"><?php echo $totalRejected; ?></a></td>
                <td><a href="view_client_details?new_total_table=addWarm_Status&fromDD=<?= $fil_from; ?>&toDD=<?= $fil_to; ?>" target="_blank"><?php echo $totalWarm; ?></a></td>
                <td></td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>

    <!-- card : Graph -->
     <div class="col-md-12">
    <div class="row g-3">
      <div class="col-md-6">
        <div class="card p-3 shadow-sm" style="background-color:rgb(248, 245, 250); border-radius:15px; ">
          <div class="form-group ">
            <!--<h4>Latest Enquiry</h4>-->
            <div class="chart-container" id="barchart_material" style="width:70vh;height:400px;"></div>
          </div>
        </div>
      </div>

      <div class="col-md-6">
        <div class="card p-3 shadow-sm" style="background-color:rgb(248, 245, 250); border-radius:15px">
          <div class="form-group ">

            <!--<h4>Latest Enquiry</h4>-->
            <select id="selectedUser" name="">
              <option>Select user</option>
              <?php
              $defaultUser = $_SESSION['username']; // Get logged-in username

              if (($userrow['add_Admin_filter'] != 1) && ($userrow['crm_teamleader'] == 1)) {
                $leader_member = explode(',', $userrow['username'] . ',' . $userrow['crm_teamMember']);
                $members = implode("', '", $leader_member);
                $userShow_query = "SELECT * FROM `users` WHERE `company_id` = '" . $_SESSION['company_id'] . "' AND `user_status` != 0 AND `username` IN ('$members') ORDER BY username";
              } else {
                $userShow_query = "SELECT * FROM `users` WHERE `company_id` = '" . $_SESSION['company_id'] . "' AND `user_status` != 0 ORDER BY username";
              }

              $userResult = mysqli_query($con, $userShow_query);
              while ($Ushow = mysqli_fetch_array($userResult)) {
                $selected = ($Ushow['username'] == $defaultUser) ? "selected" : ""; // Check if it's the logged-in user
                echo "<option value='" . $Ushow['username'] . "' $selected>" . $Ushow['username'] . "</option>";
              }

              ?>
            </select>
            <!-- <input type="button" id="selectedUserGraph" value="show Graph"> -->
            <div class="chart-container" id="barchart1_material" style="width:70vh;height:380px;"></div>
          </div>
        </div>
      </div>
    </div>
    </div>

    <div class="col-md-6">
      <div class="card p-3 shadow-sm " style="background-color:rgb(248, 245, 250); border-radius:15px; height: 450px">
        <div class="row g-3">
          <div class="col-md-6 text-center">
            <div class="card p-3" style="background-color:rgb(254, 171, 46); color: white; border-radius: 15px;">
              <h4><b>Outgoing Call</b></h4>
              <h4><?php echo $callData['Outgoing']['count']; ?></h4>
            </div>
          </div>

          <div class="col-md-6 text-center">
            <div class="card p-3" style="background-color:rgb(62, 180, 68); color: white; border-radius: 15px;">
              <h4><b>Incoming Call</b></h4>
              <h5><?php echo $callData['Incoming']['count']; ?></h5>
            </div>
          </div>

        </div>
        <div class="row g-3">
          <div class="col-md-6 text-center">
            <div class="card p-3" style="background-color:rgb(251, 74, 74); color: white; border-radius: 15px;">
              <h4><b>Missed Call</b></h4>
              <h5><?php echo $callData['Missed']['count']; ?></h5>
            </div>
          </div>

          <div class="col-md-6 text-center">
            <div class="card p-3" style="background-color:rgb(148, 55, 231); color: white; border-radius: 15px;">
              <h4><b>Rejected Call</b></h4>
              <h5><?php echo $callData['Rejected']['count']; ?></h5>
            </div>
          </div>
        </div>
        <?php
        ?>
        <div class="row g-3">
          <div class="col-md-6 text-center">
            <div class="card p-3" style="background-color:rgb(81, 98, 88); color: white; border-radius: 15px;">
              <h4><b>Unique Call</b></h4>
              <h5><?php echo $unique_calls; ?></h5>
            </div>
          </div>

          <div class="col-md-6 text-center">
            <div class="card p-3" style="background-color:rgb(159, 80, 64); color: white; border-radius: 15px;">
              <h4><b>Connected Call</b></h4>
              <h5><?php echo $total_calls; ?></h5>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="card p-3 shadow-sm " style="background-color:rgb(248, 245, 250); border-radius:15px; height: 450px">
        <h4>Client Stats</h4>
        <div class="card-body">
          <div class="chart-container pie-chart">
            <canvas id="doughnut_chart"></canvas>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-12">
      <div class="card p-4 shadow-sm" style="background-color:rgb(248, 245, 250); border-radius:15px">
        <center>
          <h4>Call Log </h4>
        </center><br>
        <div style="overflow-x: auto; width: 100%;">
          <table class="table" id="call_logs" style="border: 2px solid Green; min-width: 1500px; ">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Employee</th>
                <th scope="col">Register Number</th>
                <th scope="col">Mobile Number</th>
                <th scope="col">Total Calls</th>
                <th scope="col">Total Duration</th>
                <th scope="col">Unique Calls</th>
                <th scope="col">Connected Calls</th>
                <th scope="col">Incoming Calls</th>
                <th scope="col">Outgoing Calls</th>
                <th scope="col">Missed Calls</th>
                <th scope="col">Rejected Calls</th>
                <th scope="col">Not picked up by client</th>
                <th scope="col">Conversion Rate</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $no = 1;
              while ($call_log = mysqli_fetch_assoc($result)) {
              ?>
                <tr>
                  <td><?php echo $no++; ?></td>
                  <td><?php echo $call_log['firstname']; ?></td>
                  <td><?php echo $call_log['registeredNumber']; ?></td>
                  <td><?php echo $call_log['phoneNumber']; ?></td>
                  <td><?php echo $call_log['total_calls']; ?></td>
                  <td><?php echo $call_log['callDurationInHoursMinutes']; ?></td>
                  <td><?php echo $call_log['unique_client']; ?></td>
                  <td><?php echo $call_log['total_connected_calls']; ?></td>
                  <td><?php echo $call_log['total_incoming_calls']; ?></td>
                  <td><?php echo $call_log['total_outgoing_calls']; ?></td>
                  <td><?php echo $call_log['total_missed_calls']; ?></td>
                  <td><?php echo $call_log['total_rejected_calls']; ?></td>
                  <td><?php echo $call_log['not_picked']; ?></td>
                  <td><?php echo $call_log['convertion_rate']; ?></td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>

  </div>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

  <script>
    $(document).ready(function() {
      google.charts.load('current', {
        'packages': ['bar']
      }); 

      google.charts.setOnLoadCallback(function() {
        var defaultUser = $('#selectedUser').val();
        loadGraph(defaultUser); // Load default user's graph on page load
      });

      // When the dropdown selection changes, update the graph
      $('#selectedUser').on('change', function() {
        var selectedUser = $(this).val();
        loadGraph(selectedUser);
      });

      function loadGraph(user) {
        $.ajax({
          url: "html/showGraph.php",
          method: "POST",
          data: {
            btnID: user
          },
          dataType: "json",
          success: function(response) {
            drawChart(response, user); // Call function to draw chart
          }
        });
      }

      function drawChart(chartData, user) {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Date');
        data.addColumn('number', 'Client');
        data.addColumn('number', 'Hot');
        data.addColumn('number', 'Interested');
        data.addColumn('number', 'Rejected');
        data.addColumn('number', 'Warm');

        if (chartData.length === 0) {
          data.addRow(['No Data', 0, 0, 0, 0, 0]); // Show empty data if no records
        } else {
          chartData.forEach(function(row) {
            data.addRow([
              row.curr_date,
              row.Client,
              row.Hot,
              row.Interested,
              row.Rejected,
              row.Warm
            ]);
          });
        }

        var options = {
          chart: {
            title: 'Last 5 Days User Graph',
            subtitle: user
          },
          bars: 'vertical'
        };

        var chart = new google.charts.Bar(document.getElementById('barchart1_material'));
        chart.draw(data, google.charts.Bar.convertOptions(options));
      }
    });

    function drawChart(chartData, user) {
      google.charts.load('current', {
        'packages': ['bar']
      });
      google.charts.setOnLoadCallback(function() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Date');
        data.addColumn('number', 'Client');
        data.addColumn('number', 'Hot');
        data.addColumn('number', 'Interested');
        data.addColumn('number', 'Rejected');
        data.addColumn('number', 'Warm');

        chartData.forEach(function(row) {
          data.addRow([
            row.curr_date,
            row.Client,
            row.Hot,
            row.Interested,
            row.Rejected,
            row.Warm
          ]);
        });

        var options = {
          chart: {
            title: 'Last 5 Days User Graph',
            subtitle: user
          },
          bars: 'vertical'
        };

        var chart = new google.charts.Bar(document.getElementById('barchart1_material'));
        chart.draw(data, google.charts.Bar.convertOptions(options));
      });
    }



    google.charts.load('current', {
      'packages': ['bar']
    });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
      var data = google.visualization.arrayToDataTable([
        ['Year', 'Client', 'Hot', 'Interested', 'Rejected', 'Warm'],
        <?php
        $atus_query = "select date(`current_date`) as curr_date,SUM(Client) as Client,SUM(Hot) as Hot,SUM(Interested) as Interested,SUM(Rejected) as Rejected,SUM(Warm) as Warm from `call_status_report` group by curr_date HAVING curr_date >= DATE_SUB(CURRENT_DATE, INTERVAL 5 DAY) AND curr_date <= CURRENT_DATE order by current_date asc";
        $Stus_res = mysqli_query($con, $atus_query);
        while ($sho_Status = mysqli_fetch_array($Stus_res)) {
          $current_date = $sho_Status['curr_date'];
          $clientStatus = $sho_Status['Client'];
          $hotStatus = $sho_Status['Hot'];
          $interestedStatus = $sho_Status['Interested'];
          $rejectedStatus = $sho_Status['Rejected'];
          $warmStatus = $sho_Status['Warm'];
        ?>['<?php echo $current_date; ?>', <?php echo $clientStatus; ?>, <?php echo $hotStatus; ?>, <?php echo $interestedStatus; ?>, <?php echo $rejectedStatus; ?>, <?php echo $warmStatus; ?>],
        <?php } ?>
      ]);

      var options = {
        chart: {
          title: 'Last 5D Status Graph',
          subtitle: 'Client, Hot, Interested, Rejected, Warm',
        },
        bars: 'vertical' // Required for Material Bar Charts.
      };

      var chart = new google.charts.Bar(document.getElementById('barchart_material'));
      chart.draw(data, google.charts.Bar.convertOptions(options));
    }

    function openTitle() {
      document.getElementById("mysideTitle").style.width = "250px";
    }

    function closeTitle() {
      document.getElementById("mysideTitle").style.width = "0";
    }

    $(document).ready(function() {
      // Function to set default dates (31 days before today & today's date)
      function setDefaultDates() {
        let today = new Date();
        let todayFormatted = today.toISOString().split('T')[0]; // Format: YYYY-MM-DD

        let lastMonth = new Date();
        lastMonth.setDate(today.getDate() - 31);
        let lastMonthFormatted = lastMonth.toISOString().split('T')[0];

        // Always set default values, do not store in localStorage
        $("#dd_from").val(lastMonthFormatted);
        $("#dd_to").val(todayFormatted);
      }

      setDefaultDates(); // Call function on page load

      // When user changes date, only update UI without storing in localStorage
      $("#dd_from, #dd_to").on("change", function() {
        sendData(); // Automatically update data via AJAX
      });

      // AJAX function to send data when date changes
      function sendData() {
        $.ajax({
          url: "", // Add your server-side PHP script here
          type: "POST",
          data: {
            filter_dd_from: $("#dd_from").val(),
            filter_dd_to: $("#dd_to").val()
          },
          success: function(response) {
            $("#result").html(response);
          },
          error: function() {
            $("#result").html("<p class='text-danger'>Error fetching data.</p>");
          }
        });
      }
    });

    $(document).ready(function() {
      var ctx = document.getElementById("doughnut_chart").getContext("2d");

      // PHP values embedded into JavaScript
      var totalCalls = <?php echo $total_calls; ?>;
      var uniqueCalls = <?php echo $unique_calls; ?>;

      var myChart = new Chart(ctx, {
        type: "doughnut",
        data: {
          labels: ["Total Calls", "Unique Calls"],
          datasets: [{
            data: [totalCalls, uniqueCalls], // Using PHP values
            backgroundColor: ["#36A2EB", "#FF6384"]
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false
        }
      });
    });
  </script>
  <?php include_once 'ltr/header-footer.php'; ?>
  <script src="//cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
  <script>
    $(document).ready(function() {
      $('#call_report').DataTable();
    });
    $(document).ready(function() {
      $('#status_report').DataTable();
    });
    $(document).ready(function() {
      $('#call_logs').DataTable();
    });
  </script>
</body>

</html>