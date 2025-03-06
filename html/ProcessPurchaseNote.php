<?php
session_start();
include_once 'connection.php';
date_default_timezone_set('Asia/Kolkata');

if (isset($_POST['note_number'])) {
    $note_number = $_POST['note_number'];
    //echo $ClientNameSelect1;
    //echo "Rok";
    $fetch_PurchaseNoteNumber = "SELECT `purchase_note_number` FROM `purchase_note` WHERE `purchase_note_number` = '".$note_number."' AND `company_id` = '".$_SESSION['company_id']."'";
    $run_fetch_PurchaseNoteNumber = mysqli_query($con,$fetch_PurchaseNoteNumber);
    if(mysqli_num_rows($run_fetch_PurchaseNoteNumber) > 0){
        echo 'purchase_note_exist';
    }else{
        echo 'purchase_note_not_exist';
    }
    // $row = mysqli_fetch_array($run_fetch_PurchaseNoteNumber);
}

if(isset($_POST['send_temps_cond']))
{
	$send_Service = mysqli_real_escape_string($con,$_POST['send_temps_cond']);
	$position_num = mysqli_real_escape_string($con,$_POST['position_number']);
	if($send_Service=="")
	{
		echo "Please fill this field!";
	}else{
		$sql = "SELECT `id` FROM `temps_condi_purchase_note` WHERE `position` = '".$position_num."' AND `company_id` = '".$_SESSION['company_id']."'";
		$query = mysqli_query($con,$sql);
		$rows = mysqli_num_rows($query);
		if($rows > 0){
			echo "service_taken";
		}else{
			$add_Category_Insert = "INSERT INTO `temps_condi_purchase_note`(`company_id`, `tems_cond_name`, `modify_by`,`modify_date`,`position`) VALUES ('".$_SESSION['company_id']."','".$send_Service."','".$_SESSION['username']."','".date('Y-m-d H:i:sa')."','".$position_num."')";
			$run_Insert_Category = mysqli_query($con,$add_Category_Insert);
			if($run_Insert_Category){
				echo "service_ok";	
			}
			
		}
	}
}

if (isset($_POST['id'])) {
    $id = $_POST['id'];

    // Prepare and execute the delete query
    $sql = "DELETE FROM temps_condi_purchase_note WHERE id = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param('i', $id);

    if ($stmt->execute()) {
        echo 'success';
    } else {
        echo 'error';
    }

    $stmt->close();
}
?>