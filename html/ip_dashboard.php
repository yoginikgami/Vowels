    <?php 
	include_once 'ltr/header.php';
	include_once 'connection.php';
	date_default_timezone_set('Asia/Kolkata');
    $currentTime = date( 'Y-m-d', time () );
	$date = date('Y-m-d');
	
	$alertMsg = "";
	$alertClass = "";
	 if (isset($_SESSION['company_id'])) {
        $fetch_user_data = "SELECT * FROM `users` WHERE `company_id` = '".$_SESSION['company_id']."' AND `id` = '".$_SESSION['user_id']."' AND `crm_teamleader` = 1";
        $run_fetch_user_data = mysqli_query($con,$fetch_user_data);
        $userrow = mysqli_fetch_array($run_fetch_user_data);
        $leader_member = explode(',',$userrow['username'].','.$userrow['crm_teamMember']);
        $members = implode("', '", $leader_member);
      }
  
  if(isset($_POST['save_mom'])){
      $mom_client_id = $_POST['mom_client_id'];
      $user_name = $_POST['user_name'];
      $client_name = $_POST['client_name'];
      $paragraph = $_POST['paragraph'];
      $query = "insert into `call_client_mom`(`company_id`,`client_id`,`by_user`,`to_client`,`paragraph`,`modify_date`) values('".$_SESSION['company_id']."','$mom_client_id','$user_name','$client_name','$paragraph','".date('Y-m-d h:m:s')."')";
      $result = mysqli_query($con,$query);
  }



  
  if(isset($_POST['mom_chat_del'])){
      $tempMultipleIDdel = $_POST['tempMultipleIDdel'];
      $tempMultipleClientIDdel = $_POST['tempMultipleClientIDdel'];
      $delquery = "delete from `call_client_mom` where `id` = '$tempMultipleIDdel'";
      $result = mysqli_query($con,$delquery);
  }
  
    if(isset($_GET['myStatus'])) { 
      $str = str_replace("add","",$_GET['myStatus']);
      $str = str_replace("_Status","",$_GET['myStatus']);
      $tableName = $_GET['myStatus'];
    }
    
    if(isset($_GET['Today'])){
        $str = str_replace("add","",$_GET['Today']);
      $str = str_replace("_Status","",$_GET['Today']);
      $str = "Today's ".$str;
      $tableName = $_GET['Today'];
    }
  
    // $num_per_page = 2000;
    // if(isset($_GET["page"])){
    //     $page = $_GET["page"];
    // } else {
    //     $page = 1;
    // }
    // $start_from = ($page-1)*2000;

//   on edit
  	if(isset($_POST['editSheet_Data'])){
      if (isset($_POST['sheet_EditID'])) {
        $editQuery = "select * from `" . $tableName . "` where id = '" . $_POST['sheet_EditID'] . "'";
		$run_fetch_data = mysqli_query($con, $editQuery);
		$row = mysqli_fetch_array($run_fetch_data);
		$title_id = $row['title_id'];
		$comp_name = $row['comp_name'];
		$cont_person = $row['cont_person'];
		$mob1 = $row['mob1'];
		$mob2 = $row['mob2'];
		$email1 = $row['email1'];
		$email2 = $row['email2'];
		$state = $row['state'];
		$city = $row['city'];
		$pincode = $row['pincode'];
		$website = $row['website'];
		$whatsapp = $row['whatsapp'];
		$department = $row['department'];
		$designation = $row['designation'];
		$reff = $row['reff'];
		$others = $row['other'];
		$keyword = $row['keyword'];
		$leadDate = $row['leadDate'];
		$userName = $row['username2'];
		$Status = $row['status'];
// 		$Stat_table = "add".ucwords($Status)."_Status";
		$mom = $row['mom'];
		$remark = $row['remark'];
		$followUpDate = $row['followUpDate'];
      }
  }
  
  if(isset($_POST['changeToStatus'])){
        $id = $_POST['statusSID'];
        $table_name = $_POST['statusTable_name'];
        $desired_table = $_POST['statusSName'];
        $str = str_replace("add","",$desired_table);
        $str = str_replace("_Status","",$desired_table);
        // echo "ID".$id;
        // echo "current table".$table_name;
        // echo "desired table".$desired_table;
        $query = "select `title_id`,`company_id`,`comp_name`,`cont_person`,`mob1`,`mob2`,`email1`,`email2`,`state`,`city`,`pincode`,`website`,`whatsapp`,`designation`,`department`,`reff`,`other`,`keyword`,`leadDate`,`username2`,`status`,`mom`,`remark`,`followUpDate`,`modify_by`,`created_by` from `$table_name` where `title_id` = '".$id."'";
        $result1 = mysqli_query($con,$query);
        $row = mysqli_fetch_array($result1);
        
        $update = "insert into `$desired_table`(`title_id`,`company_id`,`comp_name`,`cont_person`,`mob1`,`mob2`,`email1`,`email2`,`state`,`city`,`pincode`,`website`,`whatsapp`,`designation`,`department`,`reff`,`other`,`keyword`,`leadDate`,`username2`,`status`,`mom`,`remark`,`followUpDate`,`modify_by`,`stat_modify_at`,`created_by`) values('".$row['title_id']."','".$row['company_id']."','".$row['comp_name']."','".$row['cont_person']."','".$row['mob1']."','".$row['mob2']."','".$row['email1']."','".$row['email2']."','".$row['state']."','".$row['city']."','".$row['pincode']."','".$row['website']."','".$row['whatsapp']."','".$row['designation']."','".$row['department']."','".$row['reff']."','".$row['other']."','".$row['keyword']."','".$row['leadDate']."','".$row['username2']."','".$str."','".$row['mom']."','".$row['remark']."','".$row['followUpDate']."','" . date('Y-m-d') . "','" . date('Y-m-d') . "','" . $_SESSION['username'] . "')";
        $result2 = mysqli_query($con,$update);
        if($result2){
            $querys = "insert into `status_update_history`(`username`,`client_id`,`status`,`old_status_date`) values('".$row['username2']."','".$row['title_id']."','".$table_name."','".$row['stat_modify_at']."')";
            $result3 = mysqli_query($con,$querys);
        }
        
        if($result2){
            $drop = "delete from `$table_name` where `title_id` = '".$id."'";
            $rs_drop = mysqli_query($con,$drop);
            echo '<div class="alert alert-success alert-dismissible">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>Success!</strong>Data has been moved.
                    </div>';
        } else {
            echo '<div class="alert alert-danger alert-dismissible">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>Failed!</strong>Some problem has occured, Try again after some time.
                    </div>';
        }
        
    }
  
    if(isset($_POST['user_update'])){
        $editSheet_Data_temp = $_POST['editSheet_Data_temp'];
        $editSheetTitle_id = $_POST['editSheetTitle_id'];
		$comp_name = $_POST['company_name'];
		$cont_person = $_POST['cont_person'];
		$mob1 = $_POST['mob1'];
		$mob2 = $_POST['mob2'];
		$email1 = $_POST['email1'];
		$email2 = $_POST['email2'];
		$state = $_POST['state'];
		$city = $_POST['city'];
		$pincode = $_POST['pincode'];
		$website = $_POST['website'];
		$whatsapp = $_POST['whatsapp'];
		$department = $_POST['department'];
		$designation = $_POST['designation'];
		$reff = $_POST['reff'];
		$others = $_POST['other'];
		$keyword = $_POST['keyword'];
		$leadDate = $_POST['leadDate'];
		$userName = $_POST['userName'];
		$Status = $_POST['Status'];
// 		$Stat_table = "add".ucwords($Status)."_Status";
		$mom = $_POST['mom'];
		$remark = $_POST['remark'];
		$followUpDate = $_POST['followUpDate'];
		$editQuery = "select * from `" . $tableName . "` where id = '" . $editSheet_Data_temp . "'";
		$run_fetch_data = mysqli_query($con, $editQuery);
		$row = mysqli_fetch_array($run_fetch_data);
		$prevStatus = $row['status'];
		if($prevStatus == $Status){
    		$query = "update `".$tableName."` set `title_id`= '".$editSheetTitle_id."',`comp_name` = '".$comp_name."',`cont_person` = '".$cont_person."',`mob1` = '".$mob1."',`mob2` = '".$mob2."',`email1` = '".$email1."',`email2` = '".$email2."',`state` = '".$state."',`city` = '".$city."',`pincode` = '".$pincode."',`website` = '".$website."',`whatsapp` = '".$whatsapp."',`designation` = '".$designation."',`department` = '".$department."',`reff` = '".$reff."',`other` = '".$others."',`keyword` = '".$keyword."',`leadDate` = '".$leadDate."',`status` = '".$Status."',`mom`='".$mom."',`remark` = '".$remark."',`followUpDate` = '".$followUpDate."',`modify_by` = '" . date('Y-m-d') . "' where id = '".$editSheet_Data_temp."'";
    		$queryResult = mysqli_query($con,$query);
    		if($queryResult){
    		    echo '<div class="alert alert-success alert-dismissible">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>Success!</strong>Data has been updated.
                    </div>';
    		} else {
                echo '<div class="alert alert-danger alert-dismissible">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>Failed!</strong>Some problem has occured, Try again after some time.
                    </div>';
    		}
		
		} else {
		    $Stat_table = "add".ucwords($Status)."_Status";
		    $insertquery = "insert into `".$Stat_table."`(`title_id`,`company_id`,`comp_name`,`cont_person`,`mob1`,`mob2`,`email1`,`email2`,`state`,`city`,`pincode`,`website`,`whatsapp`,`designation`,`department`,`reff`,`other`,`keyword`,`leadDate`,`username2`,`status`,`mom`,`remark`,`followUpDate`,`modify_by`,`stat_modify_at`,`created_by`) values('".$editSheetTitle_id."','" . $_SESSION['company_id'] . "','" . $comp_name . "','" . $cont_person . "','" . $mob1 . "','" . $mob2 . "','" . $email1 . "','" . $email2 . "','" . $state . "','" . $city . "','" . $pincode . "','" . $website . "','" . $whatsapp . "','" . $department . "','" . $designation . "','" . $reff . "','" . $others . "','" . $keyword . "','".$leadDate."','".$row['username2']."','".$Status."','".$mom."','".$remark."','".$followUpDate."','" . date('Y-m-d') . "','" . date('Y-m-d') . "','" . $_SESSION['username'] . "')";
		    $insertResult = mysqli_query($con,$insertquery);
		    if($insertResult){
		        $query = "update `$Stat_table` set `client_id` = concat('CLT-0',`id`) where `id` is not null";
		        $run = mysqli_query($con,$query);
		        $delData = "delete from `".$tableName."` where id = '$editSheet_Data_temp'";
                $delResult = mysqli_query($con,$delData);
                if($delResult){
                    $querys = "insert into `status_update_history`(`username`,`client_id`,`status`,`old_status_date`) values('".$userrow['username']."','".$editSheetTitle_id."','".$Status."','".$row['stat_modify_at']."')";
                    $result3 = mysqli_query($con,$querys);
                }
                echo '<div class="alert alert-success alert-dismissible">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>Success!</strong>Data has been moved.
                    </div>';
    		} else {
                echo '<div class="alert alert-danger alert-dismissible">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>Failed!</strong>Some problem has occured, Try again after some time.
                    </div>';
    		}
		    
		}
  }
  
  $current = "select * from `users` where `firstname` = '".$_SESSION['username']."'";
    $rs_result = mysqli_query($con,$current);
	$rs_show = mysqli_fetch_array($rs_result);
?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
	<!--<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>-->
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

	    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>



	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
	<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
	<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
	<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>-->
	<!-- <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css"/> -->
	<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.11.3/css/dataTables.bootstrap4.min.css"/>
	<!--<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">-->
    <!--<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>-->
    <!--<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>-->
    <!--<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>-->
	<script type="text/javascript" src="js/virtual-select.min.js"></script>
	<link rel="stylesheet" href="//cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

	<style type="text/css">
	
	/* General styles for multi-select dropdown and search */
.custom-control {
    display: flex;
    align-items: center;
}

.custom-control-label {
    font-size: 14px;
    margin-left: 5px;
}

/* Multi-select dropdowns */
.client_multiple_select,
.panStatus_multiple_select,
.typeOfProcess_multiple_select {
    height: 150px;
    overflow: auto; /* Only show scrollbars when content overflows */
    width: 90%;
    position: relative;
    -webkit-appearance: menulist;
}

/* Form control and group styles */
.form-control {
    margin-bottom: 10px;
    font-size: 14px;
}

.form-group.hidden {
    display: none;
}

/* Toggle switch design */
.toggle {
    position: relative;
    display: inline-block;
    width: 50px;
    height: 26px;
    background-color: red;
    border-radius: 15px;
    border: 2px solid gray;
}

.toggle:after {
    content: '';
    position: absolute;
    width: 15px;
    height: 15px;
    border-radius: 50%;
    background-color: gray;
    top: 6.5px;
    left: 6.5px;
    transition: all 0.5s;
}

/* Toggle active state */
.checkbox:checked + .toggle {
    background-color: green;
}

.checkbox:checked + .toggle:after {
    left: 25px;
}

/* Hide checkbox */
.checkbox {
    display: none;
}

/* Active state for multi-select dropdown */
.client_multiple_select_active,
.panStatus_multiple_select_active,
.typeOfProcess_multiple_select_active {
    overflow: auto; /* Scrollbars only when needed */
}

/* Option styles */
.client_multiple_select option,
.panStatus_multiple_select option,
.typeOfProcess_multiple_select option {
    height: 18px;
    background-color: white;
    white-space: nowrap; /* Prevent text wrapping */
}

.client_multiple_select option::before,
.panStatus_multiple_select option::before,
.typeOfProcess_multiple_select option::before {
    font-family: "Font Awesome 5 Free";
    content: "\f0c8 ";
    width: 1.3em;
    text-align: center;
    display: inline-block;
}

.client_multiple_select option:checked::before,
.panStatus_multiple_select option:checked::before,
.typeOfProcess_multiple_select option:checked::before {
    content: "\f14a ";
}

/* Add spacing and labels before dropdowns */
.client_multiple_select::before,
.panStatus_multiple_select::before,
.typeOfProcess_multiple_select::before {
    display: block;
    margin-left: 5px;
    margin-bottom: 2px;
}

/* Specific height and overflow settings */
.client_multiple_select {
    height: 110px !important;
}

.panStatus_multiple_select,
.typeOfProcess_multiple_select {
    height: 90px !important;
    overflow: auto; /* Only show scrollbars when content overflows */
}

/* Custom scrollbar for webkit browsers (Chrome, Edge, Safari) */
.client_multiple_select::-webkit-scrollbar,
.panStatus_multiple_select::-webkit-scrollbar,
.typeOfProcess_multiple_select::-webkit-scrollbar {
    width: 6px; /* Narrow scrollbar width */
    height: 6px; /* Narrow scrollbar height for horizontal scrolling */
}

.client_multiple_select::-webkit-scrollbar-track,
.panStatus_multiple_select::-webkit-scrollbar-track,
.typeOfProcess_multiple_select::-webkit-scrollbar-track {
    background: #f1f1f1; /* Background color of the scrollbar track */
    border-radius: 3px; /* Rounded edges for the track */
}

.client_multiple_select::-webkit-scrollbar-thumb,
.panStatus_multiple_select::-webkit-scrollbar-thumb,
.typeOfProcess_multiple_select::-webkit-scrollbar-thumb {
    background: #888; /* Scrollbar thumb color */
    border-radius: 3px; /* Rounded edges for the thumb */
}

.client_multiple_select::-webkit-scrollbar-thumb:hover,
.panStatus_multiple_select::-webkit-scrollbar-thumb:hover,
.typeOfProcess_multiple_select::-webkit-scrollbar-thumb:hover {
    background: #555; /* Darker thumb color on hover */
}

/* Firefox-specific scrollbar styling */
@supports (scrollbar-width: thin) {
    .client_multiple_select,
    .panStatus_multiple_select,
    .typeOfProcess_multiple_select {
        scrollbar-width: thin; /* Thin scrollbar for Firefox */
        scrollbar-color: #888 #f1f1f1; /* Thumb and track colors */
    }
}


		/* Optional: Scrollbar customization */
		/*.typeOfProcess_multiple_select::-webkit-scrollbar {*/
		height: 8px;
		/* Height of the horizontal scrollbar */
		/*}*/

		/*.typeOfProcess_multiple_select::-webkit-scrollbar-thumb {*/
		background-color: #888;
		/* Color of the scrollbar thumb */
		border-radius: 4px;
		/* Rounded corners for the thumb */
		/*}*/

		/*.typeOfProcess_multiple_select::-webkit-scrollbar-thumb:hover {*/
		background-color: #555;
		/* Darker thumb color on hover */
		/*}*/

		/*.typeOfProcess_multiple_select::-webkit-scrollbar-track {*/
		background: #f1f1f1;
		/* Background of the scrollbar track */
		/*}*/
	</style>
</head>
<body>
<div class="container-fluid">
 <div id='EditUserDiv'></div>
 <input type="hidden" id="showDetailStatus" value="<?php if(isset($_GET['myStatus'])) { echo $_GET['myStatus']; } ?>">
 <input type="hidden" id="showTodayDetailStatus" value="<?php if(isset($_GET['Today'])) { echo $_GET['Today']; } ?>">
	<h4 align="center" class="pageHeading" id="pageHeading"><?php if(isset($str)) { echo $modified_variable = str_replace("add", "",  $str); } ?></h4>
	<?php
	$current_date = date('Y-m-d');

    // Construct the query to count the rows
    $count_query = "SELECT COUNT(*) as count FROM trade_mark WHERE DATE(reply_fill_date) = '$current_date'";
    // / $count_query;
    
    // Execute the query
    $count_result = mysqli_query($con, $count_query);
    
    if ($count_result) {
        // Fetch the count result
        $show_count_result = mysqli_fetch_assoc($count_result);
        $count = $show_count_result['count'];
        // echo "N/umber of rows: " . $count;
    } else {
        // echo "Quer/y failed: " . mysqli_error($con);
    }
	?>
	<?php
	
$data = array();
$current_date = date('Y-m-d'); // Define the current date
// $query = "SELECT portfolio, COUNT(*) AS record_count FROM date_title_data WHERE title_date != 'Date of Application' and DATE(date_time) = '$current_date' and status_title='pending' GROUP BY portfolio";
$query = "SELECT portfolio, COUNT(*) AS record_count FROM date_title_data WHERE title_date != 'Date of Application' and status_title='pending' GROUP BY portfolio";
$result = $con->query($query);

while ($row = $result->fetch_assoc()) {
    $data[] = array($row['portfolio'], (int)$row['record_count']);
}


// // Call the function with the data retrieved from MySQL
// generateGooglePieCha/rt($data);

?>

<div class="container mt-4">
  <div class="row">
    <div class="col-md-6">
        
      <?php
function generateGooglePieChart($data) {
    // Convert data array to JSON format
    $jsonTable = json_encode($data);

    // Display GET parameters if there are any
    // if (!empty($_GET)) {
    //     echo '<div style="padding: 10px; background-color: #f0f0f0; margin-bottom: 10px;">';
    //     echo '<h4>GET Parameters:</h4>';
    //     echo '<pre>';
    //     print_r($_GET);
    //     echo '</pre>';
    //     echo '</div>';
    // }

    // Define an array of colors
    $colors = ['blue', 'green', 'red', 'yellow', 'orange', 'purple', 'pink', 'brown', 'grey'];

    // HTML and JavaScript to render the chart
    echo '
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load(\'current\', {\'packages\':[\'corechart\']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = new google.visualization.DataTable();
        data.addColumn(\'string\', \'Category\');
        data.addColumn(\'number\', \'Record Count\');
        data.addRows(' . $jsonTable . ');

        var options = {
          title: \'Record Count by Category\',
          width: \'100%\',
          height: 400,
          chartArea: { width: \'80%\', height: \'75%\' }
        };

        var chart = new google.visualization.PieChart(document.getElementById(\'piechart_div\'));
        chart.draw(data, options);

        // Add click event listener to handle click on chart slices
        google.visualization.events.addListener(chart, \'select\', function() {
            var selectedItem = chart.getSelection()[0];
            if (selectedItem) {
                var category = data.getValue(selectedItem.row, 0); // Get the category

                // Update the URL without refreshing the page
                var newUrl = \'ip_dashboard?category=\' + encodeURIComponent(category);
                window.history.pushState({ path: newUrl }, \'\', newUrl);

                // Reload the page
                window.location.reload();
            }
        });

        // Fetch data based on initial URL parameters if present
        var urlParams = new URLSearchParams(window.location.search);
        var categoryParam = urlParams.get(\'category\');
        if (categoryParam) {
            fetchData(categoryParam);
        }
      }

      function fetchData(category) {
        var xhr = new XMLHttpRequest();
        xhr.open(\'POST\', \'html/fetch_data_ip_dashboard_port.php\', true);
        xhr.setRequestHeader(\'Content-Type\', \'application/x-www-form-urlencoded\');
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                // Handle the response from the server
                var response = JSON.parse(xhr.responseText);
                displayData(response, category);
            }
        };
        xhr.send(\'category=\' + encodeURIComponent(category));
      }

      function displayData(data, category) {
        var dataContainer = document.getElementById(\'data_container\');
        dataContainer.innerHTML = \'\';

        var colors = ' . json_encode($colors) . ';
        var colorIndex = 0;

        if (data.length > 0) {
            var row = document.createElement(\'div\');
            row.className = \'row\';

            for (var i = 0; i < data.length; i++) {
                var titleDate = data[i].title_date || \'No Date\';
                var col = document.createElement(\'div\');
                col.className = \'col-md-4 mb-3\';  // Adjust the column size as needed

                // Cycle through colors
                var color = colors[colorIndex];
                colorIndex = (colorIndex + 1) % colors.length;

                col.innerHTML = \'<div class="rectangle \' + color + \'" data-title-date="\' + titleDate + \'" data-category="\' + category + \'">\' +
                                    \'<div class="inner-content">\' +
                                        \'<div class="total-users">\' + data[i].record_count + \'</div>\' +
                                        \'<div class="label">\' + titleDate + \'</div>\' +
                                    \'</div>\' +
                                \'</div>\';
                row.appendChild(col);
            }

            dataContainer.appendChild(row);

            // Add event listener for the rectangles
            var rectangles = document.getElementsByClassName(\'rectangle\');
            for (var j = 0; j < rectangles.length; j++) {
                rectangles[j].addEventListener(\'click\', function() {
                    var titleDate = this.getAttribute(\'data-title-date\');
                    var category = this.getAttribute(\'data-category\');
                    var newUrl = \'ip_dashboard?category=\' + encodeURIComponent(category) + \'&titleDate=\' + encodeURIComponent(titleDate);
                    window.history.pushState({ path: newUrl }, \'\', newUrl);
                    window.location.reload();
                });
            }
        } else {
            dataContainer.innerHTML = \'<div class="alert alert-info" role="alert">No data available for this category.</div>\';
        }
      }
    </script>
    <div id="piechart_div" class="mt-3"></div>
    <div id="data_container" class="mt-3"></div>
    ';

    // Add inline CSS for rectangle colors
    echo '
    <style>
      .rectangle.blue { background-color: #007bff; }
      .rectangle.green { background-color: #28a745; }
      .rectangle.red { background-color: #dc3545; }
      .rectangle.yellow { background-color: #ffc107; }
      .rectangle.orange { background-color: #fd7e14; }
      .rectangle.purple { background-color: #6f42c1; }
      .rectangle.pink { background-color: #e83e8c; }
      .rectangle.brown { background-color: #795548; }
      .rectangle.grey { background-color: #6c757d; }
      .rectangle {
        padding:25px;
        height: 80%;
        border-radius: 5px;
        color: #fff;
        cursor: pointer;
        display: flex;
        margin:0px;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        margin-bottom:-10%;
      }
      .inner-content {
        text-align: center;
        margin-bottom:none;
      }
      .total-users {
        font-size: 24px;
        font-weight: bold;
        margin-bottom:-40%;
        margin-top:-17%;
      }
      .label {
        font-size: 14px;
      }
    </style>
    ';
}
      // Call the function with the data retrieved from MySQL
      generateGooglePieChart($data);
      ?>
    </div>
    <!--<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css">-->
    <!--<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-multiselect@1.1.0/dist/css/bootstrap-multiselect.css">-->
    <!--<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>-->
    <!--<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>-->
    <!--<script src="https://cdn.jsdelivr.net/npm/bootstrap-multiselect@1.1.0/dist/js/bootstrap-multiselect.min.js"></script>-->
    <!--<div class="form-group col-md-6" style="height:500px;">-->
    <!--	               <h4 class="col-md-12">30 Days Sales Graph</h4>-->
    <!--	               <form method="post" id="salesGraph_form">-->
    <!--	               <div class="form-inline">-->
    <!--					<div class="form-group d-block col-md-12">-->
    <!--					    <select class="form-control w-100" name="salesPorfolio[]" id="salesPorfolio[]" multiple multiselect-search="true" placeholder="Select Portfolio" multiselect-select-all="true">-->
                            <!--<option value="dsc_subscriber">DSC Applicant</option>-->
                            <!--<option value="dsc_reseller">DSC Partner</option>-->
                            <!--<option value="pan">PAN</option>-->
                            <!--<option value="tan">TAN</option>-->
                            <!--<option value="it_returns">IT Returns</option>-->
                            <!--<option value="e_tds">e-TDS</option>-->
                            <!--<option value="gst_fees">GST Fees</option>-->
                            <!--<option value="other_services">Other Services</option>-->
                            <!--<option value="psp">PSP Coupon Distribution</option>-->
                            <!--<option value="dsc_token">DSC Token</option>-->
                            <!--<option value="e_tender">E-Tender</option>-->
                            <!--<option value="sales">Sales</option>-->
    <!--                        <option value="trade_mark">Trade Mark</option>-->
    <!--                        <option value="patent">Patent</option>-->
    <!--                        <option value="copy_right">Copy Right</option>-->
    <!--                        <option value="trade_secret">Trade Secret</option>-->
    <!--                        <option value="industrial_design">Industrial Design</option>-->
    <!--                    </select><input type="submit" name="latest_sales_graph" id="latest_sales_graph" value="Search" class="btn btn-vowel">-->
    <!--					</div>-->
    					
        					
    <!--					</div>-->
    <!--					</form>-->
    <!--					<div class="chart-container" id="sales_material" style="width:100%;height:400px;"></div>-->
    <!--					</div>-->
    <div class="form-group col-md-6" style="height:500px;">
    	               <h4 class="col-md-12">30 Days Sales Graph</h4>
<form method="post" id="salesGraph_form">
    <div class="form-inline">
        <div class="form-group d-block col-md-12">
            <select class="form-control w-100" name="salesPorfolio[]" id="salesPorfolio[]" multiple multiselect-search="true" placeholder="Select Portfolio" multiselect-select-all="true">
                <option value="trade_mark">Trade Mark</option>
                <option value="patent">Patent</option>
                <option value="copy_right">Copy Right</option>
                <option value="trade_secret">Trade Secret</option>
                <option value="industrial_design">Industrial Design</option>
            </select>
        </div>
    </div>
</form>
<div class="chart-container" id="sales_material" style="width:100%;height:400px;"></div>
</div>


<script>
    $(document).ready(function () {
        // Trigger the chart fetching and rendering when the page loads
        fetchAndDisplayChart();

        // Update chart dynamically on portfolio change
        $('#salesPorfolio\\[\\]').change(function () {
            fetchAndDisplayChart();
        });

        function fetchAndDisplayChart() {
            var portfolio = $('#salesGraph_form').serialize();
            
            // Send AJAX request to fetch chart data
            $.ajax({
                method: "post",
                url: 'html/sales_graph.php',
                data: portfolio,
                success: function (response) {
                    $('#sales_material').html(response); // Inject the response HTML/JS
                },
                error: function (xhr, status, error) {
                    console.error("AJAX Error: " + status + " - " + error);
                }
            });
        }
    });
</script>

  </div>
  <?php
  if(isset($_GET['category'])){
    $_GET['category'];
    $cat = $_GET['category']; // Assign category to variable $cat
}

if(isset($_GET['titleDate'])){
    // $_GET['titleDate'] can be an array if multiple parameters are passed with the same name
    if(is_array($_GET['titleDate'])){
        foreach($_GET['titleDate'] as $date){
            echo $date . "<br>";
            $date_val=$_GET['titleDate'];
            // Construct and execute your SQL query
            $display_date_data = "SELECT * FROM date_title_data WHERE portfolio='$cat' and title_date='$date_val'";
            if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                // Access columns from $row as needed
                $row['transaction_id']; // Example of accessing a column
                
                // Assuming $row['transaction_id'] is used directly instead of $client_name_fees
                $transaction_id = $row['transaction_id'];
                
                // Construct your SQL query based on $transaction_id
                $fetchIdForServiceId = "";
                $ViewPageForServiceId = "";
                
                // Example switch statement to determine SQL query based on $transaction_id
                switch ($transaction_id) {
                case 'TRD':
                   $fetchIdForServiceId = "SELECT dt.title_date,tr.transaction_id, tr.tax_invoice_number, tr.retail_invoice_number, tr.client_name, tr.status_fetch, tr.id, tr.modify_by, tr.modify_date
                        FROM `trade_mark` tr
                        JOIN `date_title_data` dt ON tr.transaction_id = dt.transaction_id
                        WHERE tr.transaction_id = '" . $transaction_id_full . "' AND dt.status_title = 'pending' and dt.date_time='$current_date' and dt.title_date='$date_val'";

                    // SELECT Orders.OrderID, Customers.CustomerName, Orders.OrderDate FROM Orders INNER JOIN Customers ON Orders.CustomerID=Customers.CustomerID;
                    $count_result = mysqli_query($con, $fetchIdForServiceId);
                    $ViewPageForServiceId = 'View_Trade_mark';
                    $ViewPageForServiceId_page='intell_trademark';
                    break;
                case 'PTN':
                    // $fetchIdForServiceId = "SELECT * FROM `patent` WHERE `transaction_id` = '" . $transaction_id_full . "'";
                    $fetchIdForServiceId = "SELECT tr.transaction_id, tr.tax_invoice_number, tr.retail_invoice_number, tr.client_name, tr.status_fetch, tr.id, tr.modify_by, tr.modify_date
                        FROM `patent` tr
                        JOIN `date_title_data` dt ON tr.transaction_id = dt.transaction_id
                        WHERE tr.transaction_id = '" . $transaction_id_full . "' AND dt.status_title = 'pending' and dt.date_time='$current_date' and dt.title_date='$date_val'";
                    $count_result = mysqli_query($con, $fetchIdForServiceId);
                    $ViewPageForServiceId = 'View_patent';
                    $ViewPageForServiceId_page='intell_patent';
                    break;
                case 'COP':
                    // $fetchIdForServiceId = "SELECT * FROM `patent` WHERE `transaction_id` = '" . $transaction_id_full . "'";
                    $fetchIdForServiceId = "SELECT tr.transaction_id, tr.tax_invoice_number, tr.retail_invoice_number, tr.client_name, tr.status_fetch, tr.id, tr.modify_by, tr.modify_date
                        FROM `copy_right` tr
                        JOIN `date_title_data` dt ON tr.transaction_id = dt.transaction_id
                        WHERE tr.transaction_id = '" . $transaction_id_full . "' AND dt.status_title = 'pending' and dt.date_time='$current_date' and dt.title_date='$date_val'";
                    $count_result = mysqli_query($con, $fetchIdForServiceId);
                    $ViewPageForServiceId = 'View_copy_right';
                    $ViewPageForServiceId_page='intell_copyright';
                    break;
                case 'TRS':
                    // $fetchIdForServiceId = "SELECT * FROM `patent` WHERE `transaction_id` = '" . $transaction_id_full . "'";
                    $fetchIdForServiceId = "SELECT tr.transaction_id, tr.tax_invoice_number, tr.retail_invoice_number, tr.client_name, tr.status_fetch, tr.id, tr.modify_by, tr.modify_date
                        FROM `trade_secret` tr
                        JOIN `date_title_data` dt ON tr.transaction_id = dt.transaction_id
                        WHERE tr.transaction_id = '" . $transaction_id_full . "' AND dt.status_title = 'pending' and dt.date_time='$current_date' and dt.title_date='$date_val'";
                    $count_result = mysqli_query($con, $fetchIdForServiceId);
                    $ViewPageForServiceId = 'View_tradesecret';
                    $ViewPageForServiceId_page='intell_tradesecret';
                    break;
                case 'IDS':
                    // $fetchIdForServiceId = "SELECT * FROM `patent` WHERE `transaction_id` = '" . $transaction_id_full . "'";
                    $fetchIdForServiceId = "SELECT tr.transaction_id, tr.tax_invoice_number, tr.retail_invoice_number, tr.client_name, tr.status_fetch, tr.id, tr.modify_by, tr.modify_date
                        FROM `industrial_design` tr
                        JOIN `date_title_data` dt ON tr.transaction_id = dt.transaction_id
                        WHERE tr.transaction_id = '" . $transaction_id_full . "' AND dt.status_title = 'pending' and dt.date_time='$current_date' and dt.title_date='$date_val'";
                    $count_result = mysqli_query($con, $fetchIdForServiceId);
                    $ViewPageForServiceId = 'View_industrial_design';
                    $ViewPageForServiceId_page='industrial_design';
                    break;
                // Add more cases as needed for different types
                default:
                    // Handle default case or unknown transaction_id
                    break;
            }
                
                // Execute SQL query and fetch data
                
            }
        } else {
            // Handle the case where $result is false or query execution fails
            echo "Error executing query: " . mysqli_error($con);
        }
        }
    } else {
        // Handle single value if needed
        $date_val=$_GET['titleDate'];
        // Construct and execute your SQL query for single value
        $display_date_data = "SELECT * FROM date_title_data WHERE portfolio='$cat' and title_date='$date_val'";
        // Assuming you want to execute the query here, but consider using prepared statements for security
        $result = mysqli_query($con, $display_date_data); // Replace $your_db_connection with your actual database connection variable
        // // Handle the result as needed
        
if ($result && mysqli_num_rows($result) > 0) {
    ?>
    <table class="table-striped" id="otherServicesTable">
        <thead class="bg-white">
            <?php if ($_SESSION['user_type'] == 'system_user') {?>
                <th class="tableDate">
                    <!-- Checkbox or other elements for system users -->
                </th>
                <th class="tableDate">Action</th>
            <?php }?>
            <th class="txt">Service Id</th>
            <th class="txt">Recipient Name</th>
            <th class="txt">Date Type</th>
            <th class="txt">Status</th>
            <!--<th>User</th>-->
        </thead>
        <tbody>
        <?php
        $current_date = date('Y-m-d');
        while ($row = mysqli_fetch_assoc($result)) {
            // Access columns from $row as needed
            $transaction_id_full = $row['transaction_id'];
            $transaction_parts = explode('_', $transaction_id_full);
            $transaction_id = $transaction_parts[1];
            
            // Construct your SQL query based on $transaction_id
            $fetchIdForServiceId = "";
            $count_result = null;
            $ViewPageForServiceId = "";
            

            // Example switch statement to determine SQL query based on $transaction_id
            
switch ($transaction_id) {
    case 'TRD':
        $fetchIdForServiceId = "SELECT tr.id as id, dt.title_date, tr.transaction_id, tr.tax_invoice_number, 
                                tr.retail_invoice_number, tr.client_name, tr.status_fetch, tr.modify_by, 
                                tr.modify_date 
                                FROM `trade_mark` tr
                                JOIN `date_title_data` dt ON tr.transaction_id = dt.transaction_id
                                WHERE tr.transaction_id = '" . $transaction_id_full . "' 
                                AND dt.status_title = 'pending' 
                                AND dt.date_time = '$current_date' 
                                AND dt.title_date = '$date_val'";
        $ViewPageForServiceId = 'View_Trade_mark';
        $ViewPageForServiceId_page = 'intell_trademark';
        break;

    case 'PTN':
        $fetchIdForServiceId = "SELECT dt.title_date, tr.transaction_id, tr.tax_invoice_number, 
                                tr.retail_invoice_number, tr.client_name, tr.status_fetch, tr.id, 
                                tr.modify_by, tr.modify_date
                                FROM `patent` tr
                                JOIN `date_title_data` dt ON tr.transaction_id = dt.transaction_id
                                WHERE tr.transaction_id = '" . $transaction_id_full . "' 
                                AND dt.status_title = 'pending' 
                                AND dt.date_time = '$current_date' 
                                AND dt.title_date = '$date_val'";
        $ViewPageForServiceId = 'View_patent';
        $ViewPageForServiceId_page = 'intell_patent';
        break;

    case 'COP':
        $fetchIdForServiceId = "SELECT dt.title_date, tr.transaction_id, tr.tax_invoice_number, 
                                tr.retail_invoice_number, tr.client_name, tr.status_fetch, tr.id, 
                                tr.modify_by, tr.modify_date
                                FROM `copy_right` tr
                                JOIN `date_title_data` dt ON tr.transaction_id = dt.transaction_id
                                WHERE tr.transaction_id = '" . $transaction_id_full . "' 
                                AND dt.status_title = 'pending' 
                                AND dt.date_time = '$current_date' 
                                AND dt.title_date = '$date_val'";
        $ViewPageForServiceId = 'View_copy_right';
        $ViewPageForServiceId_page = 'intell_copyright';
        break;

    case 'TRS':
        $fetchIdForServiceId = "SELECT dt.title_date, tr.transaction_id, tr.tax_invoice_number, 
                                tr.retail_invoice_number, tr.client_name, tr.status_fetch, tr.id, 
                                tr.modify_by, tr.modify_date
                                FROM `trade_secret` tr
                                JOIN `date_title_data` dt ON tr.transaction_id = dt.transaction_id
                                WHERE tr.transaction_id = '" . $transaction_id_full . "' 
                                AND dt.status_title = 'pending' 
                                AND dt.date_time = '$current_date' 
                                AND dt.title_date = '$date_val'";
        $ViewPageForServiceId = 'View_tradesecret';
        $ViewPageForServiceId_page = 'intell_tradesecret';
        break;

    case 'IDS':
        $fetchIdForServiceId = "SELECT dt.title_date, tr.transaction_id, tr.tax_invoice_number, 
                                tr.retail_invoice_number, tr.client_name, tr.status_fetch, tr.id, 
                                tr.modify_by, tr.modify_date
                                FROM `industrial_design` tr
                                JOIN `date_title_data` dt ON tr.transaction_id = dt.transaction_id
                                WHERE tr.transaction_id = '" . $transaction_id_full . "' 
                                AND dt.status_title = 'pending' 
                                AND dt.date_time = '$current_date' 
                                AND dt.title_date = '$date_val'";
        $ViewPageForServiceId = 'View_industrial_design';
        $ViewPageForServiceId_page = 'industrial_design';
        break;

    default:
        echo "Unknown transaction type.";
        break;
}

// Execute the query
$count_result = mysqli_query($con, $fetchIdForServiceId);

// Check and fetch data rows
if ($count_result && mysqli_num_rows($count_result) > 0) {
    while ($row = mysqli_fetch_assoc($count_result)) { 
        ?>
        <tr>
            <?php if ($_SESSION['user_type'] == 'system_user') { ?>
                <td>
                    <form method="post" action="<?php echo $ViewPageForServiceId_page; ?>" target="_blank" class="inline-form">
                        <input type="hidden" name="other_serviceEditID" value="<?= htmlspecialchars($row['id']); ?>">
                        <button class="editOtherServicebtn mr-2" name="editOtherServicebtn" id="editOtherServicebtn" style="padding: 0; border: none; background: none;" data-toggle="tooltip" data-placement="top" title="Edit">
                            <i class="fas fa-pencil-alt fa-lg" style="color:green;"></i>
                        </button>
                    </form>
                </td>
            <?php } ?>
            <td class="ttext"><?= htmlspecialchars($row['transaction_id']); ?></td>
            <td>
                <form method="post" action="<?= $ViewPageForServiceId; ?>" target="_blank" style="display: inline;">
                    <input type="hidden" name="ViewID" id="ViewID" value="<?= htmlspecialchars($row['id']); ?>">
                    <button type="submit" name="viewOtherServiceDetailbtn" id="viewOtherServiceDetailbtn" 
                        style="padding: 0; border: none; background: none; color: blue; text-decoration: underline; cursor: pointer;">
                        <?= htmlspecialchars($row['transaction_id']); ?>
                    </button>
                </form>
            </td>
            <td class="ttext"><?= htmlspecialchars($row['client_name']); ?></td>
            <td class="ttext"><?= htmlspecialchars($row['title_date']); ?></td>
            <td class="ttext"><?= htmlspecialchars($row['status_fetch']); ?></td>
        </tr>
        <?php
    }
}

// End of while loop for count_result
        } // End of while loop for $result
        ?>
        </tbody>
    </table>
    
    <?php
} 

 else {
            // Handle the case where $result is false or query execution fails
            echo "Error executing query: " . mysqli_error($con);
        }
    }
}
  ?>
</div>
<script>
$(document).ready(function() {
    $('#salesPorfolio').multiselect({
        includeSelectAllOption: true,
        enableFiltering: true,
        filterPlaceholder: 'Search Portfolio',
        buttonWidth: '100%'
    });
});
</script>
<div class="row border justify-content-center mt-4" id="after-heading">
</div>
<div id="searchShowDetails" class="table-responsive d-block mt-4"></div>

<!--<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.1.0/mdb.min.js"></script>-->

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>


$('#salesGraph_form').submit(function(e){
		    e.preventDefault();
		    var portfolio = $('#salesGraph_form').serialize();
		  //  alert(portfolio);
		   $.ajax({
    method: "post",
    url: 'html/sales_graph.php',
    data: $('#salesGraph_form').serialize(),
    success: function(data) {
        // console.log(data); // Check the response data
        $('#sales_material').html(data); // Ensure this is correct
    }
});

    });


$('#meeting_rectangle').on('click',function(){
    $('#showMeeting_btn').addClass('d-block');
    $('#showMeeting_btn').removeClass('d-none');
    $('#showEnquiry_btn').addClass('d-none');
    $('#showEnquiry_btn').removeClass('d-block');
    $('#showMeet_enq_btn').addClass('d-block');
    $('#showMeet_enq_btn').removeClass('d-none');
    
    var div = document.getElementById('svg_section');
    div.style.display = 'none'; // Hide the div
    var div1 = document.getElementById('showTodays_section');
    div1.style.display = 'none'; // Hide the div
});
$('#enquiry_rectangle').on('click',function(){
    $('#showEnquiry_btn').addClass('d-block');
    $('#showEnquiry_btn').removeClass('d-none');
    $('#showMeeting_btn').addClass('d-none');
    $('#showMeeting_btn').removeClass('d-block');
    $('#showMeet_enq_btn').addClass('d-block');
    $('#showMeet_enq_btn').removeClass('d-none');
    var div = document.getElementById('svg_section');
    div.style.display = 'none'; // Hide the div
    var div1 = document.getElementById('showTodays_section');
    div1.style.display = 'none'; // Hide the div
});
$('.tableRecords #tableids').on('change','#Status_change', function(){
     var row_indexDEL = $(this).closest('tr'); 
     var btnID = row_indexDEL.find('#sheetTitle_id').val();
    var btnStatus = row_indexDEL.find('#Status_change').val();
    const colorModal = new bootstrap.Modal(document.getElementById('colorModal'));
    colorModal.show();
    $('#statusSID').val(btnID);
    $('#statusSName').val(btnStatus);
});
$('#testCap').on('keyup', function () {
		  var capt = $('#testCap').val();
		  var pre = $('#Pastemomcache').val();
		  if(capt == pre){
		      $('#testCap').html('').css({'color':'green'});
		      document.getElementById('mom_chat_del').style.visibility = 'visible';
		  } else {
		      $('#testCap').html('').css({'color':'red'});
		      //$(".client_delete").modal('hide');
		      document.getElementById('mom_chat_del').style.visibility = 'hidden';
		  }
		});

var up = document.getElementById('MOM_Fun');
    var down = document.getElementById('Pastemomcache');
    

    function MOM_Fun() {
        document.getElementById("Pastemomcache").value = down.innerText =
        Math.random().toString(36).slice(2);
    }
    
    $('#summernote').summernote({
        tabsize: 2,
        height: 120,
        toolbar: [
          ['style', ['style']],
          ['font', ['bold', 'underline', 'clear']],
          ['color', ['color']],
          ['para', ['ul', 'ol', 'paragraph']],
          ['table', ['table']],
          ['insert', ['link', 'picture', 'video']],
          ['view', ['fullscreen', 'codeview', 'help']]
        ]
      });
      function removeLeadingZero(inputString) {
      if (inputString.charAt(0) === "0") {
        return inputString.substring(1);
      } else {
        return inputString;
      }
    }
    function containsCountryCode91(number) {
      const pattern = /^(91\d{10})|\+91\d{10}/;
      return pattern.test(number);
    }
$(document).ready(function() {
    $(document).on('submit', '#update-form', function() {
      // do your things
      return false;
     });
     


     $('.tableRecords #tableids').on('click', '#gstWhatsAppbtn', function() {
         <?php if(($_SESSION['accessToken'] != "invalid") && ($_SESSION['endpoint'] != "invalid")){ ?>
        var row_indexDEL = $(this).closest('tr'); 
        var btnID1 = row_indexDEL.find('#companyWhatsAppID').val();
        var btnID = row_indexDEL.find('#mobiWhatsAppID').val();
        var domain = "User Dashboard";
        var template = "chatbot_client_msg";
        var endPoint = "<?= $_SESSION['endpoint']; ?>";
        var apiProvider = "<?= $_SESSION['whatsapp_type']; ?>";
		var userResponse = window.confirm("Are you sure to send Whatsapp message to "+btnID1+"?");
        btnID = removeLeadingZero(btnID);
        mobile = btnID.replace(/\s/g, "");
        if (userResponse) {
          try {
                if (apiProvider !== "local") {
                    if (containsCountryCode91(mobile)) {
                        mobile;
                    } else {
                        mobile = '91'+mobile;
                    }
		        }
		        mobile = "9016043397";
                if(mobile != ""){
                    if (apiProvider === "wati") {
                        sendWatiMessage(endPoint,mobile);
                    } else if (apiProvider === "local") {
                        var user_dashboard_fetch_data = "sdwd";
                        $.ajax({
                    		url:"html/verifyPinProcess.php",
                    		method:"post",
                    		data: {user_dashboard_fetch_data:user_dashboard_fetch_data},
                    		dataType:"text",
                    		success:function(data)
                    		{
                    		    var jsonData = JSON.parse(data);
                    		    var result = jsonData.result;
                    		    var message = jsonData.message;
                    		    var file = jsonData.file;
                                sendLocalMessage(mobile,result,message,file);
                    		}
                        });
                    } else {
                        alert("Whatsapp Support is not their");
                    }
                }
                  
        	} catch (error) {
                console.error('JSON parsing error:', error);
            }
        }
            <?php } else { ?> alert('Whatsapp Support Is not their !'); <?php } ?>
    	});
     
     $('.tableRecords #tableids').on('click','#active_client_mom_btn', function(){
          var row_indexDEL = $(this).closest('tr'); 
          var btnID = row_indexDEL.find('#active_client_mom_id').val();
          $('#mom_client_id').val(btnID);
            $.ajax({
				url:"html/verifyPinProcess.php",
				method:"post",
				data: {show_clientMOM:true,btnID:btnID},
				dataType:"text",
				success:function(data)
				{
				    $("#client_mom_table").html(data);
				},
			});
  });
});
$(document).ready(function() {
if ($("#editSheet_Data_temp").val() != "") {
		// CheckMobileNumberExist();
		// CheckEmailIdExist();
		$("#showData").removeClass("d-none");
		$("#showData").addClass("d-block");
		$("selectTitle").removeClass("d-none");
		// $("#import_client").removeClass("d-block");
		// $("#import_client").addClass("d-none");
        $("#searchShowDetails").addClass("d-none");
		        $("#searchShowDetails").removeClass("d-block");
		$("#addNew_Data").removeClass("d-none");
		$("#addNew_Data").addClass("d-block");

	}
});
function sendWatiMessage(endPoint,mobile) {
    const options = {
      method: 'POST',
      headers: {
        'content-type': 'text/json',
        Authorization: "<?= $_SESSION['accessToken']; ?>"
      },
      body: JSON.stringify({
        broadcast_name: 'chatbot_client_msg',
        template_name: 'chatbot_client_msg',
        parameters: [{name: 'link', value: 'Tendervow.com'}]
      })
    };
    
    fetch(endPoint+'/api/v1/sendTemplateMessage?whatsappNumber='+mobile, options)
          .then(response => response.json())
          .then(data => {
            // Access specific values from the JSON data
            const result = data.result;
            const mobile = data.phone_number;
            if(result === true){
        //         $.ajax({
        // 			url:"html/whatsapi_log_file.php",
        // 			method:"post",
        // 			data: {user_dashboard:domain,template:template,mobile:mobile,result:result,},
        // 			dataType:"text",
        // 			success:function(data)
        // 			{
        // 			}
        // 		});
            $('#EditUserDiv').append('\<div class="alert alert-success alert-dismissible fade show" role="alert">\
              <strong>Success! </strong> Message sent to '+mobile+'.\
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                <span aria-hidden="true">&times;</span>\
              </button>\
            </div>');
            // $('#gstWhatsAppbtn').click();
            } else {
                $('#EditUserDiv').append('\<div class="alert alert-danger alert-dismissible fade show" role="alert">\
              <strong>Failed! </strong> Message not sent to '+mobile+'.\
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">\
                <span aria-hidden="true">&times;</span>\
              </button>\
            </div>');
            // $('#gstWhatsAppbtn').click();
            }
        })
}

async function sendLocalMessage(mobile,result,message,file) {
		    if(result != "empty"){
			const apiUrl = "<?= $_SESSION['accessToken']; ?>";
            const apiKey = "<?= $_SESSION['endpoint']; ?>";
            // const message = message;
            // alert(file);
            if(file != ""){
                const image = "<?= $_SESSION['location_path']; ?>"+'html/whatsapp_template_file/'+file;
                if (image.indexOf("jpg") !== -1 || image.indexOf("png") !== -1) {
                    var file_type = `&img1=${image}`;
                } else if (image.indexOf("pdf") !== -1) {
                    var file_type = `&pdf=${image}`;
                    // const apiRequestUrl = `${apiUrl}?apikey=${apiKey}&mobile=${mobile}&pdf=${image}`;
                }
            }
            const apiRequestUrl = `${apiUrl}?apikey=${apiKey}&mobile=${mobile}`+file_type;
            const apiRequestUrl1 = `${apiUrl}?apikey=${apiKey}&mobile=${mobile}&msg=${encodeURIComponent(message)}`;
//             // $('#gstWhatsAppbtn').click();
            swal({
              title: "Message Sent!",
              text: "WhatsApp message sent to "+mobile,
              icon: "success",
              button: "Close!",
            });
        
            try {
                if(file != ""){
                const response = await fetch(apiRequestUrl, { mode: 'no-cors' });
                
                const response1 = await fetch(apiRequestUrl1, { mode: 'no-cors' });
                
                if (!response.ok) {
                    throw new Error(`HTTP error! Status: ${response.status}`);
                }
            
                console.log('API request was made, but CORS restrictions prevent accessing the response directly.');
                }
            //     // Note: You won't be able to access response.json() or other response methods here.
            
            } catch (error) {
                console.error('Error:', error);
            }
		    }
		
    
}
function openTitle() {
  document.getElementById("mysideTitle").style.width = "250px";
}

function closeTitle() {
  document.getElementById("mysideTitle").style.width = "0";
}
    $(document).ready(function() {
        $("#search").on("input", function(){
        var search = $("#search").val();
        var tstatus = $("#showTodayDetailStatus").val();
		var status = $('#showDetailStatus').val();
		
		$.ajax({
			url:"html/showUserStatus_Data.php",
			method:"post",
			data: {search:search,status:status,tstatus:tstatus},
			dataType:"text",
			success:function(data)
			{
				$("#showData").addClass("d-none");
		        $("#showData").removeClass("d-block");
				$("#searchShowDetails").addClass("d-block");
		        $("#searchShowDetails").removeClass("d-none");
		        $("#searchShowDetails").html(data);
			}
		});
    });
    
    $('#closeSearch').click(function(){
		$("#search").val('');
		var no_of_records_per_page = $("#no_of_records_per_page").val();
		var first = $('#first').val();
		var currentPageno = $('#currentPageno').val();
		var last = $('#IncomeLast').val();
                $("#showData").addClass("d-block");
		        $("#showData").removeClass("d-none");
	            $("#searchShowDetails").addClass("d-none");
		        $("#searchShowDetails").removeClass("d-block");
	});
	
	$('#Status').on('change',function(){
        var status = $('#Status').val();
        if(status == "Client" || status == "Rejected"){
            $("#followDate").addClass("d-none");
		        $("#followDate").removeClass("d-block");
		        $("#followDate").prop('required',false);
        } else {
            $("#followDate").addClass("d-block");
		        $("#followDate").removeClass("d-none");
		        $("#followDate").prop('required',true);
 }
});
    var get = $('#Status').val();
    if(get == "Client" || get == "Rejected"){
        $("#followDate").addClass("d-none");
		        $("#followDate").removeClass("d-block");
		        $("#followDate").prop('required',false);
    } else{
        $("#followDate").addClass("d-block");
		        $("#followDate").removeClass("d-none");
		        $("#followDate").prop('required',true);
    }
    });
</script>
</body>
</html>
<?php include_once 'ltr/header-footer.php'; ?>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.js"></script>
    <script>
        $(document).ready(function() {
            $('#otherServicesTable').DataTable();
        });
    </script>