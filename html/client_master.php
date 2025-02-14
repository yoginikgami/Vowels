<?php
include_once 'ltr/header.php';
include_once 'connection.php';
//include_once 'bulkDeletePopup.php';
error_reporting(E_ERROR | E_PARSE);
//$csv = new csv();
date_default_timezone_set('Asia/Kolkata');
$alertMsg = "";
$alertClass = "";

if(isset($_POST['rejectClient'])){
    $rej_ID = $_POST['fetchRejectID'];
    $query = "select * from `addClient_approval_Status` where `id` = '".$rej_ID."'";
    $result = mysqli_query($con,$query);
    $selRow = mysqli_fetch_array($result);
    $status = "Hot";
    $crm_query = "insert into `addHot_Status`(`title_id`,`company_id`,`comp_name`,`cont_person`,`mob1`,`mob2`,`email1`,`email2`,`state`,`city`,`pincode`,`website`,`whatsapp`,`designation`,`department`,`reff`,`other`,`keyword`,`leadDate`,`username2`,`status`,`mom`,`remark`,`followUpDate`,`modify_by`,`stat_modify_at`,`created_by`) values('".$selRow['title_id']."','".$selRow['company_id']."','".$selRow['comp_name']."','".$selRow['cont_person']."','".$selRow['mob1']."','".$selRow['mob2']."','".$selRow['email1']."','".$selRow['email2']."','".$selRow['state']."','".$selRow['city']."','".$selRow['pincode']."','".$selRow['website']."','".$selRow['whatsapp']."','".$selRow['designation']."','".$selRow['department']."','".$selRow['reff']."','".$selRow['other']."','".$selRow['keyword']."','".$selRow['leadDate']."','".$selRow['username2']."','".$status."','".$selRow['mom']."','".$selRow['remark']."','".$selRow['followUpDate']."','" . date('Y-m-d') . "','" . date('Y-m-d') . "','" . $selRow['created_by'] . "')";
    $result = mysqli_query($con,$crm_query);
    if($result){
        $delQ = "update `addClient_approval_Status` set `client_approval` = 2,`client_status_by` = '".$_SESSION['email_id']."' where `id` = '".$rej_ID."'";
        $result1 = mysqli_query($con,$delQ);
        if($result1){
            $alertMsg = "Client Approval Rejected";
			$alertClass = "alert alert-success";
        }
    }
    
}

if(isset($_POST['rejectPartner'])){
    $rej_ID = $_POST['fetchpartnerRejectID'];
    $query = "update `calling_partner` set `partner_status` = 2 where `id` = '".$rej_ID."'";
    $result = mysqli_query($con,$query);
    if($result){
        $alertMsg = "Partner Approval Rejected";
		$alertClass = "alert alert-success";
    }
}



if (isset($_POST['editClient_Masterbtn'])) {
	if (isset($_POST['client_masterEditID'])) {
		$fetch_data = "SELECT * FROM `client_master` WHERE `id` = '" . $_POST['client_masterEditID'] . "'";
		$run_fetch_data = mysqli_query($con, $fetch_data);
		$row = mysqli_fetch_array($run_fetch_data);
		//$edit_vendor_client = $row['vendor_client'];
		$edit_client_name = $row['client_name'];
		$edit_company_name = $row['company_name'];
		$edit_contact_person = $row['contact_person'];
		$edit_mobile_number = $row['mobile_no'];
		$edit_pan_number = $row['pan_no'];
		$edit_landline_number = $row['landline_no'];
		$edit_email_id_1 = $row['email_1'];
		$edit_password = $row['password'];
		$edit_email_id_2 = $row['email_2'];
		$edit_address = mysqli_real_escape_string($con, $row['address']);
		$edit_city = $row['city'];
		$edit_state = $row['state'];
		$edit_pincode = $row['pincode'];
		$edit_bank_account_no = $row['bank_account_no'];
		$edit_ifsc_code = $row['ifsc_code'];
		$edit_bank_name = $row['bank_name'];
		$edit_branch_code = $row['branch_code'];
		$dsc_subscriber = $row['dsc_subscriber'];
		$e_tender = $row['e_tender'];
		$dsc_reseller = $row['dsc_reseller'];
		$pan = $row['pan'];
		$tan = $row['tan'];
		$it_returns = $row['it_returns'];
		$e_tds = $row['e_tds'];
		$twenty4g = $row['24g'];
		$gst = $row['gst'];
		$other_services = $row['other_services'];
		$mobile_repairing = $row['mobile_repairing'];
		$advocate = $row['advocate'];
		$psp = $row['psp'];
		$trade_mark=$row['trade_mark'];
        $patent=$row['patent'];
        $trade_secret=$row['trade_secret'];
        $copy_right=$row['copy_right'];
        $industrial_design=$row['industrial_design'];
		$psp_coupon_consumption = $row['psp_coupon_consumption'];
		//$payment = $row['payment'];
		$audit = $row['audit'];
		$trading = $row['trading'];
		$gst_no = $row['gst_no'];
		$psp_vle_id = $row['psp_vle_id'];
		$cin = $row['cin'];
		$other_description = $row['other_description'];
		$edit_previous_balance = $row['previous_balance'];
		$edit_advance_balance = $row['advance_balance'];
		$edit_fees_received = $row['fees_received'];
		//$edit_dsc_company = $row['dsc_reseller_company'];
		$edit_dsc_company = explode(',', $row['dsc_reseller_company']);
		$edit_users_access = explode(',', $row['users_access']);
		// echo $edit_dsc_company; 
	}
}
if (isset($_POST['client_save'])) {
	/*if (!isset($_POST['vendor_client'])) {
			$vendor_client = 0;
		} else {
			$vendor_client = 1;
		}*/
	$client_name = strtoupper(trim($_POST['client_name']));
	$company_name = $_POST['company_name'];
	$contact_person = $_POST['contact_person'];
	$mobile_number = $_POST['mobile_number'];
	$pan_no = strtoupper($_POST['pan_no']);
	$landline_number = $_POST['landline_number'];
	$email_id_1 = $_POST['email_id_1'];
	$password = $_POST['password'];
	$email_id_2 = $_POST['email_id_2'];
	$address = mysqli_real_escape_string($con, $_POST['address']);
	$city = $_POST['city'];
	$state = strtoupper($_POST['state']);
	$pincode = $_POST['pincode'];
	$bank_account_no = $_POST['bank_account_no'];
	$ifsc_code = $_POST['ifsc_code'];
	$bank_name = $_POST['bank_name'];
	$branch_code = $_POST['branch_code'];
	$crm_client = $_POST['crm_client'];
	$expl = explode('_',$crm_client);
	$CRM = $expl[0];
	$title_id = $expl[1];
	$position = strpos($CRM, 'CRM');
    if ($position !== false) {
        $CRM_d = 1;
        $title_name = $title_id;
    } else {
        $CRM_d = 0;
        $title_name = "";
    }
	if (isset($_POST['dsc_company'])) {
		$dsc_company = implode(',', $_POST['dsc_company']);
	} else {
		$dsc_company = '';
	}
	//$transaction_allows = implode(',', $_POST['transaction_allows']);
	$dsc_subscriber = 0;
	$dsc_reseller = 0;
	$pan = 0;
	$tan = 0;
	$e_tender=0;
	$it_returns = 0;
	$e_tds = 0;
	$twenty4g = 0;
	$gst = 0;
	$other_services = 0;
	$mobile_repairing = 0;
	$trading = 0;
	$advocate = 0;
	$psp = 0;
	$psp_coupon_consumption = 0;
	$audit = 0;
	$trade_mark=0;
    $patent=0;
    $trade_secret=0;
    $copy_right=0;
    $industrial_design=0;
	if (isset($_POST['dsc_allows'])) {
		foreach ($_POST['dsc_allows'] as $key => $value) {
			if ($_POST['dsc_allows'][$key] == "DSC Applicant") {
				$dsc_subscriber = 1;
			}
			if ($_POST['dsc_allows'][$key] == "DSC Partner") {
				$dsc_reseller = 1;
			}
		}
	}
	if (isset($_POST['nsdl_allows'])) {
		foreach ($_POST['nsdl_allows'] as $key => $value) {
			if ($_POST['nsdl_allows'][$key] == "PAN") {
				$pan = 1;
			}
			if ($_POST['nsdl_allows'][$key] == "TAN") {
				$tan = 1;
			}
			if ($_POST['nsdl_allows'][$key] == "e-TDS") {
				$e_tds = 1;
			}
			if ($_POST['nsdl_allows'][$key] == "24G") {
				$twenty4g = 1;
			}
		}
	}
	if (isset($_POST['taxation_allows'])) {
		foreach ($_POST['taxation_allows'] as $key => $value) {
			if ($_POST['taxation_allows'][$key] == "IT Returns") {
				$it_returns = 1;
			}
			if ($_POST['taxation_allows'][$key] == "GST") {
				$gst = 1;
			}
			if ($_POST['taxation_allows'][$key] == "Audit") {
				$audit = 1;
			}
		}
	}
	if (isset($_POST['otherServices_allows'])) {
		foreach ($_POST['otherServices_allows'] as $key => $value) {
			if ($_POST['otherServices_allows'][$key] == "Other Services") {
				$other_services = 1;
			}
			if ($_POST['otherServices_allows'][$key] == "Trading") {
				$trading = 1;
			}
			if ($_POST['otherServices_allows'][$key] == "E-Tender") {
				$e_tender = 1;
			}
			if ($_POST['otherServices_allows'][$key] == "Mobile Repairing") {
				$mobile_repairing = 1;
			}
			if ($_POST['otherServices_allows'][$key] == "Advocate") {
				$advocate = 1;
			}
		}
	}
	if (isset($_POST['uti_allows'])) {
		foreach ($_POST['uti_allows'] as $key => $value) {
			if ($_POST['uti_allows'][$key] == "PSP") {
				$psp = 1;
			}
		}
	}
	
	if (isset($_POST['ip_allows'])) {
		foreach ($_POST['ip_allows'] as $key => $value) {
			if ($_POST['ip_allows'][$key] == "trade_mark") {
				$trade_mark = 1;
			}
			if ($_POST['ip_allows'][$key] == "patent") {
				$patent = 1;
			}
			if ($_POST['ip_allows'][$key] == "trade_secret") {
				$trade_secret = 1;
			}
			if ($_POST['ip_allows'][$key] == "copy_right") {
				$copy_right = 1;
			}
			if ($_POST['ip_allows'][$key] == "industrial_design") {
				$industrial_design = 1;
			}
		}
	}

	$gst_no = $_POST['gst_no'];
	if (!isset($_POST['gst'])) {
		//$gst = 0;
		//  $gst_no = '';
	} else {
		//$gst = $_POST['gst'];
	}
	
	
	if (!isset($_POST['previous_balance']) || empty($_POST['previous_balance'])) {
		$previous_balance = 0;
	} else {
		$previous_balance = $_POST['previous_balance'];
	}
	//$previous_balance = $_POST['previous_balance'];
	$advance_balance = $_POST['advance_balance'];
	if ($psp == 1) {
		//$psp = $_POST['psp'];
		$psp_vle_id = $_POST['psp_vle_id'];
	} else {
		//$psp = 0;
		$psp_vle_id = '';
	}
	
	if ($audit == 1) {
		$cin = $_POST['cin'];
	} else {
		$cin = '';
	}
	//$audit = $_POST['audit'];
	$other_description = $_POST['other_description'];

	$fetchAdminId = "SELECT * FROM `users` WHERE `company_id` = '" . $_SESSION['company_id'] . "' AND `admin_status` = '1'";
	$runAdminId = mysqli_query($con, $fetchAdminId);
	$AdminIdrow = mysqli_fetch_array($runAdminId);
	if ($_SESSION['admin_status'] == "1") {
		if (isset($_POST['users_access'])) {
			$users_access = $AdminIdrow['id'] . "," . implode(',', $_POST['users_access']);
		} else {
			$users_access = $AdminIdrow['id'];
		}
	} else {
		// $users_access = $AdminIdrow['id'].",".$_SESSION['user_id'];
		$users_access = $AdminIdrow['id'] . "," . implode(',', $_POST['users_access']);
	}
	if (!empty($gst_no) || $gst_no != "") {
		if ($pan_no != "") {
			$checkExistData = "SELECT `id` FROM `client_master` WHERE (`pan_no` = '" . $pan_no . "' OR `gst_no` = '" . $gst_no . "') AND `company_id` = '" . $_SESSION['company_id'] . "'";
		} else if ($pan_no == "") {
			$checkExistData = "SELECT `id` FROM `client_master` WHERE (`gst_no` = '" . $gst_no . "') AND `company_id` = '" . $_SESSION['company_id'] . "'";
		}
	} else {
		if ($pan_no != "") {
			$checkExistData = "SELECT `id` FROM `client_master` WHERE (`pan_no` = '" . $pan_no . "') AND `company_id` = '" . $_SESSION['company_id'] . "'";
		} 
		else if ($pan_no == "") {
			$checkExistData = "SELECT `id` FROM `client_master` WHERE (`pan_no` = '" . $pan_no . "') AND `company_id` = '" . $_SESSION['company_id'] . "'";
		}
	}
	
		$fetchLastTransactionId = "SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = '" . $DBName . "' AND TABLE_NAME = 'client_master'";
		$run_fetchLastTransactionId = mysqli_query($con, $fetchLastTransactionId);
// 		$transaction_id = "VE_CLM_954";
		if (mysqli_num_rows($run_fetchLastTransactionId) > 0) {
			$FetchlastTransactionID_row = mysqli_fetch_array($run_fetchLastTransactionId);
// 			$transaction_id = "VE_CLM_" . ($FetchlastTransactionID_row['AUTO_INCREMENT'] * 954);
			$transaction_id = $_SESSION['company_name_for_transacrion_id'] . "_CLM_" . ($FetchlastTransactionID_row['AUTO_INCREMENT'] * 954);
		
		$client_add_query = "INSERT INTO `client_master` (`advocate`,`trade_mark`,`patent`,`trade_secret`,`copy_right`,`industrial_design`,`crm_client`,`title_id`,`transaction_id`, `company_id`, `client_name`, `company_name`, `contact_person`, `mobile_no`, `pan_no`, `landline_no`, `email_1`, `password`, `email_2`, `address`, `state`, `city`, `pincode`, `bank_account_no`, `ifsc_code`, `bank_name`, `branch_code`, `dsc_subscriber`, `dsc_reseller`, `pan`, `tan`, `it_returns`, `e_tds`,`24g`, `gst`, `other_services`,`mobile_repairing`,`e_tender` ,`trading`, `psp`, `psp_coupon_consumption`, `audit`, `gst_no`, `other_description`, `psp_vle_id`, `cin`,`previous_balance`,`advance_balance`,`dsc_reseller_company`,`users_access`,`modify_by`,`modify_date`,`entry_id`) VALUES ('".$advocate."','".$trade_mark."','".$patent."','".$trade_secret."','".$copy_right."','".$industrial_design."','".$CRM_d."','".$title_name."','" . $transaction_id . "', '" . $_SESSION['company_id'] . "','" . $client_name . "','" . $company_name . "','" . $contact_person . "','" . $mobile_number . "','" . $pan_no . "','" . $landline_number . "','" . $email_id_1 . "','" . $password . "','" . $email_id_2 . "','" . $address . "','" . $state . "','" . $city . "','" . $pincode . "','" . $bank_account_no . "','" . $ifsc_code . "','" . $bank_name . "','" . $branch_code . "','" . $dsc_subscriber . "','" . $dsc_reseller . "','" . $pan . "','" . $tan . "','" . $it_returns . "','" . $e_tds . "','" . $twenty4g . "','" . $gst . "','" . $other_services . "','".$mobile_repairing."','" . $e_tender . "','" . $trading . "','" . $psp . "','" . $psp_coupon_consumption . "','" . $audit . "','" . $gst_no . "','" . $other_description . "', '" . $psp_vle_id . "', '" . $cin . "','" . $previous_balance . "','" . $advance_balance . "','" . $dsc_company . "','" . $users_access . "','" . $_SESSION['username'] . "','" . date('Y-m-d H:i:sa') . "','".$_SESSION['employee_id']."')";
		$run_client_add = mysqli_query($con, $client_add_query);
		if ($run_client_add) {
            if(strpos($title_id, 'PARTNER') !== false){
                if($run_client_add){
    	            $partnerQuery = "update `calling_partner` set `part_id` = '".$transaction_id."',`partner_status` = 1,`approved_by` = '".$_SESSION['username']."' where `part_id` = '".$title_name."'";
    	            $partnerResult = mysqli_query($con,$partnerQuery);
	            }
            }
		    if($CRM === "CRM"){
		        $selQuery = "select c1.transaction_id,a1.title_id,a1.company_id,a1.comp_name,a1.cont_person,a1.mob1,a1.mob2,a1.email1,a1.email2,a1.state,a1.city,a1.pincode,a1.website,a1.whatsapp,a1.designation,a1.department,a1.reff,a1.other,a1.keyword,a1.leadDate,a1.username2,a1.status,a1.mom,a1.remark,a1.followUpDate,a1.modify_by,a1.stat_modify_at,a1.created_by from `client_master` c1 right join `addClient_approval_Status` a1 on c1.title_id=a1.title_id where c1.title_id = '".$title_name."'";
		        $selQuery = mysqli_query($con,$selQuery);
		        $selRow = mysqli_fetch_array($selQuery);
		        $client = "Client";
		        date_default_timezone_set('Asia/Kolkata');
                $currentTime = date( 'Y-m-d', time () );
                $date = date('Y-m-d');
		        $crm_query = "insert into `addClient_Status`(`client_id`,`title_id`,`company_id`,`comp_name`,`cont_person`,`mob1`,`mob2`,`email1`,`email2`,`state`,`city`,`pincode`,`website`,`whatsapp`,`designation`,`department`,`reff`,`other`,`keyword`,`leadDate`,`username2`,`status`,`mom`,`remark`,`followUpDate`,`modify_by`,`stat_modify_at`,`created_by`) values('".$selRow['transaction_id']."','".$selRow['title_id']."','".$selRow['company_id']."','".$selRow['comp_name']."','".$selRow['cont_person']."','".$selRow['mob1']."','".$selRow['mob2']."','".$selRow['email1']."','".$selRow['email2']."','".$selRow['state']."','".$selRow['city']."','".$selRow['pincode']."','".$selRow['website']."','".$selRow['whatsapp']."','".$selRow['designation']."','".$selRow['department']."','".$selRow['reff']."','".$selRow['other']."','".$selRow['keyword']."','".$selRow['leadDate']."','".$selRow['username2']."','".$client."','".$selRow['mom']."','".$selRow['remark']."','".$selRow['followUpDate']."','" . date('Y-m-d') . "','" . date('Y-m-d') . "','" . $selRow['created_by'] . "')";
		        $crm_result = mysqli_query($con,$crm_query);
		        if($crm_result){
		            $upQuery = "update `addClient_approval_Status` set `client_approval` = 1,`client_status_by` = '".$_SESSION['email_id']."' where `title_id` = '".$title_name."'";
		            $upResult = mysqli_query($con,$upQuery);
		        }
		        
		    }
			$alertMsg = "Record Inserted";
			$alertClass = "alert alert-success";
		}
	}
}
if ($_SESSION['admin_status'] == "1") {
	if (isset($_POST['client_save_duplicate'])) {
		/*if (!isset($_POST['vendor_client'])) {
				$vendor_client = 0;
			} else {
				$vendor_client = 1;
			}*/
		$client_name = strtoupper(trim($_POST['client_name']));
		$company_name = $_POST['company_name'];
		$contact_person = $_POST['contact_person'];
		$mobile_number = $_POST['mobile_number'];
		$pan_no = strtoupper($_POST['pan_no']);
		$landline_number = $_POST['landline_number'];
		$email_id_1 = $_POST['email_id_1'];
		$password = $_POST['password'];
		$email_id_2 = $_POST['email_id_2'];
		$address = mysqli_real_escape_string($con, $_POST['address']);
		$city = $_POST['city'];
		$state = strtoupper($_POST['state']);
		$pincode = $_POST['pincode'];
		$bank_account_no = $_POST['bank_account_no'];
		$ifsc_code = $_POST['ifsc_code'];
		$bank_name = $_POST['bank_name'];
		$branch_code = $_POST['branch_code'];
		if (isset($_POST['dsc_company'])) {
			$dsc_company = implode(',', $_POST['dsc_company']);
		} else {
			$dsc_company = '';
		}
		//$dsc_company = $_POST['dsc_company'];

		$dsc_subscriber = 0;
		$dsc_reseller = 0;
		$pan = 0;
		$tan = 0;
		$it_returns = 0;
		$e_tds = 0;
		$twenty4g = 0;
		$gst = 0;
		$other_services = 0;
		$mobile_repairing = 0;
		$advocate = 0;
		$e_tender=0;
		$trade_mark=0;
        $patent=0;
        $trade_secret=0;
        $copy_right=0;
        $industrial_design=0;
		$psp = 0;
		$psp_coupon_consumption = 0;
		$audit = 0;
		if (isset($_POST['dsc_allows'])) {
			foreach ($_POST['dsc_allows'] as $key => $value) {
				if ($_POST['dsc_allows'][$key] == "DSC Applicant") {
					$dsc_subscriber = 1;
				}
				if ($_POST['dsc_allows'][$key] == "DSC Partner") {
					$dsc_reseller = 1;
				}
			}
		}
		if (isset($_POST['nsdl_allows'])) {
			foreach ($_POST['nsdl_allows'] as $key => $value) {
				if ($_POST['nsdl_allows'][$key] == "PAN") {
					$pan = 1;
				}
				if ($_POST['nsdl_allows'][$key] == "TAN") {
					$tan = 1;
				}
				if ($_POST['nsdl_allows'][$key] == "e-TDS") {
					$e_tds = 1;
				}
				if ($_POST['nsdl_allows'][$key] == "24G") {
					$twenty4g = 1;
				}
			}
		}
		if (isset($_POST['taxation_allows'])) {
			foreach ($_POST['taxation_allows'] as $key => $value) {
				if ($_POST['taxation_allows'][$key] == "IT Returns") {
					$it_returns = 1;
				}
				if ($_POST['taxation_allows'][$key] == "GST") {
					$gst = 1;
				}
				if ($_POST['taxation_allows'][$key] == "Audit") {
					$audit = 1;
				}
			}
		}
		if (isset($_POST['otherServices_allows'])) {
			foreach ($_POST['otherServices_allows'] as $key => $value) {
				if ($_POST['otherServices_allows'][$key] == "Other Services") {
					$other_services = 1;
				}
				if ($_POST['otherServices_allows'][$key] == "Trading") {
					$trading = 1;
				}
				if ($_POST['otherServices_allows'][$key] == "E-Tender") {
					$e_tender = 1;
				}
				if ($_POST['otherServices_allows'][$key] == "Mobile Repairing") {
					$mobile_repairing = 1;
				}
				if ($_POST['otherServices_allows'][$key] == "Advocate") {
					$advocate = 1;
				}
			}
		}
		if (isset($_POST['uti_allows'])) {
			foreach ($_POST['uti_allows'] as $key => $value) {
				if ($_POST['uti_allows'][$key] == "PSP") {
					$psp = 1;
				}
			}
		}
		
		if (isset($_POST['ip_allows'])) {
    		foreach ($_POST['ip_allows'] as $key => $value) {
    			if ($_POST['ip_allows'][$key] == "trade_mark") {
    				$trade_mark = 1;
    			}
    			if ($_POST['ip_allows'][$key] == "patent") {
    				$patent = 1;
    			}
    			if ($_POST['ip_allows'][$key] == "trade_secret") {
    				$trade_secret = 1;
    			}
    			if ($_POST['ip_allows'][$key] == "copy_right") {
    				$copy_right = 1;
    			}
    			if ($_POST['ip_allows'][$key] == "industrial_design") {
    				$industrial_design = 1;
    			}
    		}
    	}

		$gst_no = $_POST['gst_no'];
		if ($gst == 1) {
			//$gst = $_POST['gst'];
		} else {
			//$gst = 0;
			// $gst_no = '';
		}
		//$gst = $_POST['gst'];
		/*if(!isset($_POST['dsc_subscriber']))
			{
			     $dsc_subscriber = 0;
			} else {
			     $dsc_subscriber = $_POST['dsc_subscriber'];
			}
			//$dsc_subscriber = $_POST['dsc_subscriber'];
			if(!isset($_POST['dsc_reseller']))
			{
			     $dsc_reseller = 0;
			} else {
			     $dsc_reseller = $_POST['dsc_reseller'];
			}
			//$dsc_reseller = $_POST['dsc_reseller'];
			if(!isset($_POST['pan']))
			{
			     $pan = 0;
			} else {
			     $pan = $_POST['pan'];
			}
			//$pan = $_POST['pan'];
			if(!isset($_POST['tan']))
			{
			     $tan = 0;
			} else {
			     $tan = $_POST['tan'];
			}
			//$tan = $_POST['tan'];
			if(!isset($_POST['it_returns']))
			{
			     $it_returns = 0;
			} else {
			     $it_returns = $_POST['it_returns'];
			}
			//$it_returns = $_POST['it_returns'];
			if(!isset($_POST['e_tds']))
			{
			     $e_tds = 0;
			} else {
			     $e_tds = $_POST['e_tds'];
			}
			//$e_tds = $_POST['e_tds'];
			if(!isset($_POST['other_services']))
			{
			     $other_services = 0;
			} else {
			     $other_services = $_POST['other_services'];
			}*/
		//$other_services = $_POST['other_services'];
		if (!isset($_POST['previous_balance']) || empty($_POST['previous_balance'])) {
			$previous_balance = 0;
		} else {
			$previous_balance = $_POST['previous_balance'];
		}
		//$previous_balance = $_POST['previous_balance'];
		$advance_balance = $_POST['advance_balance'];
		if ($psp == 1) {
			//$psp = $_POST['psp'];
			$psp_vle_id = $_POST['psp_vle_id'];
		} else {
			//$psp = 0;
			$psp_vle_id = '';
		}
		//$psp = $_POST['psp'];
		/*if(!isset($_POST['psp_coupon_consumption']))
			{
			     $psp_coupon_consumption = 0;
			} else {
			     $psp_coupon_consumption = $_POST['psp_coupon_consumption'];
			}*/
		//$psp_coupon_consumption = $_POST['psp_coupon_consumption'];
		//if(!isset($_POST['payment']))
		//{
		//     $payment = 0;
		//} else {
		//     $payment = $_POST['payment'];
		//}
		//$payment = $_POST['payment'];
		/*if(!isset($_POST['audit']))
			{
			     $audit = 0;
			} else {
			     $audit = $_POST['audit'];
			}*/
		if ($audit == 1) {
			$cin = $_POST['cin'];
		} else {
			$cin = '';
		}
		//$audit = $_POST['audit'];
		$other_description = $_POST['other_description'];

		$fetchAdminId = "SELECT * FROM `users` WHERE `company_id` = '" . $_SESSION['company_id'] . "' AND `admin_status` = '1'";
		$runAdminId = mysqli_query($con, $fetchAdminId);
		$AdminIdrow = mysqli_fetch_array($runAdminId);
		if ($_SESSION['admin_status'] == "1") {
			if (isset($_POST['users_access'])) {
				$users_access = $AdminIdrow['id'] . "," . implode(',', $_POST['users_access']);
			} else {
				$users_access = $AdminIdrow['id'];
			}
		} else {
			// $users_access = $AdminIdrow['id'].",".$_SESSION['user_id'];
			$users_access = $AdminIdrow['id'] . "," . implode(',', $_POST['users_access']);
		}
		/*if (isset($_POST['psp_vle_id'])) {
				$psp_vle_id = $_POST['psp_vle_id'];
			}else{
				$psp_vle_id = '';
			}*/
		/*$checkExistData = "SELECT `id` FROM `client_master` WHERE `pan_no` = '".$pan_no."'";
	        $run_checkExistData = mysqli_query($con,$checkExistData);
	        if(mysqli_num_rows($run_checkExistData) > 0){
	        	$alertMsg = "Record with this pan number already exist!";
				$alertClass = "alert alert-danger";
	        } else{*/
		$fetchLastTransactionId = "SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = '" . $DBName . "' AND TABLE_NAME = 'client_master'";
		$run_fetchLastTransactionId = mysqli_query($con, $fetchLastTransactionId);
// 		$transaction_id = "VE_CLM_954";
		if (mysqli_num_rows($run_fetchLastTransactionId) > 0) {
			$FetchlastTransactionID_row = mysqli_fetch_array($run_fetchLastTransactionId);
// 			$transaction_id = "VE_CLM_" . ($FetchlastTransactionID_row['AUTO_INCREMENT'] * 954);
			$transaction_id = $_SESSION['company_name_for_transacrion_id'] . "_CLM_" . ($FetchlastTransactionID_row['AUTO_INCREMENT'] * 954);
		}

		$client_add_query = "INSERT INTO `client_master` (`advocate`,`transaction_id`, `company_id`, `client_name`, `company_name`, `contact_person`, `mobile_no`, `pan_no`, `landline_no`, `email_1`, `password`, `email_2`, `address`, `state`, `city`, `pincode`, `bank_account_no`, `ifsc_code`, `bank_name`, `branch_code`, `dsc_subscriber`, `dsc_reseller`, `pan`, `tan`, `it_returns`, `e_tds`, `24g`, `gst`, `other_services`,`mobile_repairing`,`e_tender`, `trading`, `psp`, `psp_coupon_consumption`, `audit`, `gst_no`, `other_description`, `psp_vle_id`,`cin`,`previous_balance`,`advance_balance`,`dsc_reseller_company`,`users_access`,`modify_by`,`modify_date`) VALUES ('".$advocate."','" . $transaction_id . "', '" . $_SESSION['company_id'] . "','" . $client_name . "','" . $company_name . "','" . $contact_person . "','" . $mobile_number . "','" . $pan_no . "','" . $landline_number . "','" . $email_id_1 . "', '" . $password . "','" . $email_id_2 . "','" . $address . "','" . $state . "','" . $city . "','" . $pincode . "','" . $bank_account_no . "','" . $ifsc_code . "','" . $bank_name . "','" . $branch_code . "','" . $dsc_subscriber . "','" . $dsc_reseller . "','" . $pan . "','" . $tan . "','" . $it_returns . "','" . $e_tds . "','" . $twenty4g . "','" . $gst . "','" . $other_services . "','".$mobile_repairing."','" . $e_tender . "','" . $trading . "','" . $psp . "','" . $psp_coupon_consumption . "','" . $audit . "','" . $gst_no . "','" . $other_description . "', '" . $psp_vle_id . "', '" . $cin . "','" . $previous_balance . "','" . $advance_balance . "','" . $dsc_company . "','" . $users_access . "','" . $_SESSION['username'] . "','" . date('Y-m-d H:i:sa') . "')";
		$run_client_add = mysqli_query($con, $client_add_query);
		if ($run_client_add) {
			$alertMsg = "Record Inserted";
			$alertClass = "alert alert-success";
		}
		//}
	}
}
if (isset($_POST['client_update'])) {
	$client_name = strtoupper(trim($_POST['client_name']));
	$company_name = $_POST['company_name'];
	$contact_person = $_POST['contact_person'];
	$mobile_number = $_POST['mobile_number'];
	$pan_no = strtoupper($_POST['pan_no']);
	$landline_number = $_POST['landline_number'];
	$email_id_1 = $_POST['email_id_1'];
	$password = $_POST['password'];
	/* if ($_POST['password'] == "") {
			$password = $_POST['temp_password'];
		} */
	$email_id_2 = $_POST['email_id_2'];
	$address = mysqli_real_escape_string($con, $_POST['address']);
	$city = $_POST['city'];
	$state = strtoupper($_POST['state']);
	$pincode = $_POST['pincode'];
	$bank_account_no = $_POST['bank_account_no'];
	$ifsc_code = $_POST['ifsc_code'];
	$bank_name = $_POST['bank_name'];
	$branch_code = $_POST['branch_code'];
	//$dsc_company = $_POST['dsc_company'];
	if (isset($_POST['dsc_company'])) {
		$dsc_company = implode(',', $_POST['dsc_company']);
	} else {
		$dsc_company = '';
	}
	$dsc_subscriber = 0;
	$dsc_reseller = 0;
	$pan = 0;
	$tan = 0;
	$it_returns = 0;
	$e_tds = 0;
	$twenty4g = 0;
	$gst = 0;
	$other_services = 0;
	$mobile_repairing = 0;
	$advocate = 0;
	$e_tender=0;
	$trade_mark=0;
    $patent=0;
    $trade_secret=0;
    $copy_right=0;
    $industrial_design=0;
	$trading = 0;
	$psp = 0;
	$psp_coupon_consumption = 0;
	$audit = 0;
	if (isset($_POST['dsc_allows'])) {
		foreach ($_POST['dsc_allows'] as $key => $value) {
			if ($_POST['dsc_allows'][$key] == "DSC Applicant") {
				$dsc_subscriber = 1;
			}
			if ($_POST['dsc_allows'][$key] == "DSC Partner") {
				$dsc_reseller = 1;
			}
		}
	}
	if (isset($_POST['nsdl_allows'])) {
		foreach ($_POST['nsdl_allows'] as $key => $value) {
			if ($_POST['nsdl_allows'][$key] == "PAN") {
				$pan = 1;
			}
			if ($_POST['nsdl_allows'][$key] == "TAN") {
				$tan = 1;
			}
			if ($_POST['nsdl_allows'][$key] == "e-TDS") {
				$e_tds = 1;
			}
			if ($_POST['nsdl_allows'][$key] == "24G") {
				$twenty4g = 1;
			}
		}
	}
	if (isset($_POST['taxation_allows'])) {
		foreach ($_POST['taxation_allows'] as $key => $value) {
			if ($_POST['taxation_allows'][$key] == "IT Returns") {
				$it_returns = 1;
			}
			if ($_POST['taxation_allows'][$key] == "GST") {
				$gst = 1;
			}
			if ($_POST['taxation_allows'][$key] == "Audit") {
				$audit = 1;
			}
		}
	}
	if (isset($_POST['otherServices_allows'])) {
		foreach ($_POST['otherServices_allows'] as $key => $value) {
			if ($_POST['otherServices_allows'][$key] == "Other Services") {
				$other_services = 1;
			}
			if ($_POST['otherServices_allows'][$key] == "Trading") {
				$trading = 1;
			}
			if ($_POST['otherServices_allows'][$key] == "E-Tender") {
				$e_tender = 1;
			}
			if ($_POST['otherServices_allows'][$key] == "Mobile Repairing") {
				$mobile_repairing = 1;
			}
			if ($_POST['otherServices_allows'][$key] == "Advocate") {
				$advocate = 1;
			}
		}
	}
	if (isset($_POST['uti_allows'])) {
		foreach ($_POST['uti_allows'] as $key => $value) {
			if ($_POST['uti_allows'][$key] == "PSP") {
				$psp = 1;
			}
		}
	}
	
	if (isset($_POST['ip_allows'])) {
		foreach ($_POST['ip_allows'] as $key => $value) {
			if ($_POST['ip_allows'][$key] == "trade_mark") {
				$trade_mark = 1;
			}
			if ($_POST['ip_allows'][$key] == "patent") {
				$patent = 1;
			}
			if ($_POST['ip_allows'][$key] == "trade_secret") {
				$trade_secret = 1;
			}
			if ($_POST['ip_allows'][$key] == "copy_right") {
				$copy_right = 1;
			}
			if ($_POST['ip_allows'][$key] == "industrial_design") {
				$industrial_design = 1;
			}
		}
	}
	if ($dsc_reseller == 0) {
		$dsc_company = '';
	}

	/*if ($_POST['uti_allows'][$key] == "PSP Coupon Consumption") {
			$psp_coupon_consumption = 1;
		}*/
	//echo nl2br("\n".$_POST['transaction_allows'][$key]);

	/*if(!isset($_POST['dsc_subscriber']))
		{
		     $dsc_subscriber = 0;
		} else {
		     $dsc_subscriber = $_POST['dsc_subscriber'];
		}
		//$dsc_subscriber = $_POST['dsc_subscriber'];
		if(!isset($_POST['dsc_reseller']))
		{
		     $dsc_reseller = 0;
		} else {
		     $dsc_reseller = $_POST['dsc_reseller'];
		}
		//$dsc_reseller = $_POST['dsc_reseller'];
		if(!isset($_POST['pan']))
		{
		     $pan = 0;
		} else {
		     $pan = $_POST['pan'];
		}
		//$pan = $_POST['pan'];
		if(!isset($_POST['tan']))
		{
		     $tan = 0;
		} else {
		     $tan = $_POST['tan'];
		}
		//$tan = $_POST['tan'];
		if(!isset($_POST['it_returns']))
		{
		     $it_returns = 0;
		} else {
		     $it_returns = $_POST['it_returns'];
		}
		//$it_returns = $_POST['it_returns'];
		if(!isset($_POST['e_tds']))
		{
		     $e_tds = 0;
		} else {
		     $e_tds = $_POST['e_tds'];
		}
		//$e_tds = $_POST['e_tds'];*/
	$gst_no = $_POST['gst_no'];
	if ($gst == 1) {
		//$gst = $_POST['gst'];
	} else {
		//$gst = 0;
		// $gst_no = '';
	}
	//$gst = $_POST['gst'];
	/* if(!isset($_POST['other_services']))
		{
		     $other_services = 0;
		} else {
		     $other_services = $_POST['other_services'];
		} */
	//$other_services = $_POST['other_services'];
	if (!isset($_POST['previous_balance']) || empty($_POST['previous_balance'])) {
		$previous_balance = 0;
	} else {
		$previous_balance = $_POST['previous_balance'];
	}
	//$previous_balance = $_POST['previous_balance'];
	if ($psp == 1) {
		//$psp = $_POST['psp'];
		$psp_vle_id = $_POST['psp_vle_id'];
	} else {
		//$psp = 0;
		$psp_vle_id = '';
	}
	//$psp = $_POST['psp'];
	/*if(!isset($_POST['psp_coupon_consumption']))
		{
		     $psp_coupon_consumption = 0;
		} else {
		     $psp_coupon_consumption = $_POST['psp_coupon_consumption'];
		}
		//$psp_coupon_consumption = $_POST['psp_coupon_consumption'];
		if(!isset($_POST['payment']))
		{
		     $payment = 0;
		} else {
		     $payment = $_POST['payment'];
		}*/
	//$payment = $_POST['payment'];
	/*if(!isset($_POST['audit']))
		{
		     $audit = 0;
		} else {
		     $audit = $_POST['audit'];
		}*/
	if ($audit == 1) {
		$cin = $_POST['cin'];
	} else {
		$cin = '';
	}
	//$audit = $_POST['audit'];
	$other_description = $_POST['other_description'];
	/*if (isset($_POST['psp_vle_id'])) {
			$psp_vle_id = $_POST['psp_vle_id'];
		}else{
			$psp_vle_id = '';
		}*/
	$fetchAdminId = "SELECT * FROM `users` WHERE `company_id` = '" . $_SESSION['company_id'] . "' AND `admin_status` = '1'";
	$runAdminId = mysqli_query($con, $fetchAdminId);
	$AdminIdrow = mysqli_fetch_array($runAdminId);
	if ($_SESSION['admin_status'] == "1") {
		if (isset($_POST['users_access'])) {
			$users_access = $AdminIdrow['id'] . "," . implode(',', $_POST['users_access']);
		} else {
			$users_access = $AdminIdrow['id'];
		}
	} else {
		// $users_access = $AdminIdrow['id'].",".$_SESSION['user_id'];
		$users_access = $AdminIdrow['id'] . "," . implode(',', $_POST['users_access']);
	}

	if (!empty($gst_no) || $gst_no != "") {
		if (!empty($pan_no) || $pan_no != "") {
			$checkExistData = "SELECT `id` FROM `client_master` WHERE (`mobile_no` = '" . $mobile_number . "' OR `pan_no` = '" . $pan_no . "' OR `gst_no` = '" . $gst_no . "') AND `id` != '" . $_POST['client_masterEditID_temp'] . "' AND `company_id` = '" . $_SESSION['company_id'] . "'";
		} else if ($pan_no == "") {
			$checkExistData = "SELECT `id` FROM `client_master` WHERE (`mobile_no` = '" . $mobile_number . "' OR `gst_no` = '" . $gst_no . "') AND `id` != '" . $_POST['client_masterEditID_temp'] . "' AND `company_id` = '" . $_SESSION['company_id'] . "'";
		}
	} else {
		if (!empty($pan_no) || $pan_no != "") {
			$checkExistData = "";
			//$checkExistData = "SELECT `id` FROM `client_master` WHERE (`mobile_no` = '".$mobile_number."' OR `pan_no` = '".$pan_no."') AND `id` != '".$_POST['client_masterEditID_temp']."' AND `company_id` = '".$_SESSION['company_id']."'";
		} else if ($pan_no == "") {
			$checkExistData = "SELECT `id` FROM `client_master` WHERE (`mobile_no` = '" . $mobile_number . "') AND `id` != '" . $_POST['client_masterEditID_temp'] . "' AND `company_id` = '" . $_SESSION['company_id'] . "'";
		}
	}
	$NumRows = 0;
	$RunStatus = false;
	//$alertMsg = "Ronak here bro..:)))";
	if ($checkExistData != "") {
		$run_checkExistData = mysqli_query($con, $checkExistData);
		$RunStatus = true;
	} else {
		$RunStatus = false;
	}
	if ($RunStatus == true) {
		$NumRows = mysqli_num_rows($run_checkExistData);
	}
	if ($NumRows > 0) {
		$alertMsg = "Record already exist! ";
		$alertClass = "alert alert-danger";
	} else {
	    
	    $old_data_query = "SELECT `updated_user`, `updated_time`, `updated_id` FROM `client_master` WHERE `id` = '".$_POST['panEditID_temp']."'";
            // Execute the query and fetch the result, assuming you have a database connection
            $old_data_result = mysqli_query($con, $old_data_query);
            $old_data_row = mysqli_fetch_assoc($old_data_result);
            
            // Assuming you fetched old data from the database
            $old_updated_user = $old_data_row['updated_user'];
            $old_updated_time = $old_data_row['updated_time'];
            $old_updated_id = $old_data_row['updated_id'];
            
            // Prepare new data
            $new_updated_user = $_SESSION['username'];
            $new_updated_time = date('Y-m-d H:i:sa');
            $new_updated_id = $_SESSION['employee_id'];
            
            // Construct additional update values
            $additional_update_values = array();
            
            // Check if old data exists and add it to the update query
            if ($old_updated_user) {
                $additional_update_values[] = "`updated_user`=('" . $old_updated_user . "," . $new_updated_user . "')";
            } else {
                $additional_update_values[] = "`updated_user`=('" . $new_updated_user . "')";
            }
            
            if ($old_updated_time) {
                $additional_update_values[] = "`updated_time`=('" . $old_updated_time . "," . $new_updated_time . "')";
            } else {
                $additional_update_values[] = "`updated_time`=('" . $new_updated_time . "')";
            }
            
            if ($old_updated_id) {
                $additional_update_values[] = "`updated_id`=('" . $old_updated_id . "," . $new_updated_id . "')";
            } else {
                $additional_update_values[] = "`updated_id`=('" . $new_updated_id . "')";
            }

            
            // Implode additional update values
            $additional_update_query = implode(", ", $additional_update_values);
            
            
		// if ($_SESSION['admin_status'] == "1") {
		$client_master_update_query = "UPDATE `client_master` SET `company_id` = '" . $_SESSION['company_id'] . "',`trade_mark`='" . $trade_mark . "',`patent`='" . $patent . "',`trade_secret`='" . $trade_secret . "',`copy_right`='" . $copy_right . "',`industrial_design`='" . $industrial_design . "',`client_name`='" . $client_name . "',`company_name`='" . $company_name . "',`contact_person`='" . $contact_person . "',`mobile_no`='" . $mobile_number . "',`pan_no`='" . $pan_no . "',`landline_no`='" . $landline_number . "',`email_1`='" . $email_id_1 . "',`password`='" . $password . "',`email_2`='" . $email_id_2 . "',`address`='" . $address . "',`state`='" . $state . "',`city`='" . $city . "',`pincode`='" . $pincode . "',`bank_account_no`='" . $bank_account_no . "',`ifsc_code`='" . $ifsc_code . "',`bank_name`='" . $bank_name . "',`branch_code`='" . $branch_code . "',`dsc_subscriber`='" . $dsc_subscriber . "',`dsc_reseller`='" . $dsc_reseller . "',`pan`='" . $pan . "',`tan`='" . $tan . "',`it_returns`='" . $it_returns . "',`e_tds`='" . $e_tds . "',`24g`='" . $twenty4g . "',`gst`='" . $gst . "',`other_services`='" . $other_services . "',`mobile_repairing`='".$mobile_repairing."',`advocate`='".$advocate."',`e_tender`='" . $e_tender . "',`trading`='" . $trading . "',`psp`='" . $psp . "',`psp_coupon_consumption`='" . $psp_coupon_consumption . "',`audit`='" . $audit . "',`gst_no`='" . $gst_no . "',`other_description`='" . $other_description . "', `psp_vle_id` = '" . $psp_vle_id . "', `cin` = '" . $cin . "', `previous_balance`='" . $previous_balance . "', `dsc_reseller_company`='" . $dsc_company . "', `users_access` = '" . $users_access . "', ".$additional_update_query." WHERE `id` = '" . $_POST['client_masterEditID_temp'] . "'";
		// }else{
		// 	$client_master_update_query = "UPDATE `client_master` SET `company_id` = '".$_SESSION['company_id']."',`client_name`='".$client_name."',`company_name`='".$company_name."',`contact_person`='".$contact_person."',`mobile_no`='".$mobile_number."',`pan_no`='".$pan_no."',`landline_no`='".$landline_number."',`email_1`='".$email_id_1."',`password`='".$password."',`email_2`='".$email_id_2."',`address`='".$address."',`state`='".$state."',`city`='".$city."',`pincode`='".$pincode."',`bank_account_no`='".$bank_account_no."',`ifsc_code`='".$ifsc_code."',`bank_name`='".$bank_name."',`branch_code`='".$branch_code."',`dsc_subscriber`='".$dsc_subscriber."',`dsc_reseller`='".$dsc_reseller."',`pan`='".$pan."',`tan`='".$tan."',`it_returns`='".$it_returns."',`e_tds`='".$e_tds."',`24g`='".$twenty4g."',`gst`='".$gst."',`other_services`='".$other_services."',`psp`='".$psp."',`psp_coupon_consumption`='".$psp_coupon_consumption."',`audit`='".$audit."',`gst_no`='".$gst_no."',`other_description`='".$other_description."', `psp_vle_id` = '".$psp_vle_id."', `cin` = '".$cin."', `previous_balance`='".$previous_balance."',`modify_by`='".$_SESSION['username']."',`modify_date`='".date('Y-m-d H:i:sa')."', `dsc_reseller_company`='".$dsc_company."' WHERE `id` = '".$_POST['client_masterEditID_temp']."'";

		// }
		$run_client_master_update = mysqli_query($con, $client_master_update_query);
		if ($run_client_master_update) {
			$alertMsg = "Record Updated";
			$alertClass = "alert alert-success";
		}
	}
}
if ($_SESSION['admin_status'] == "1") {
	if (isset($_POST['client_update_duplicate'])) {
		$client_name = strtoupper(trim($_POST['client_name']));
		$company_name = $_POST['company_name'];
		$contact_person = $_POST['contact_person'];
		$mobile_number = $_POST['mobile_number'];
		$pan_no = strtoupper($_POST['pan_no']);
		$landline_number = $_POST['landline_number'];
		$email_id_1 = $_POST['email_id_1'];
		$password = $_POST['password'];
		/* if ($_POST['password'] == "") {
				$password = $_POST['temp_password'];
			} */
		$email_id_2 = $_POST['email_id_2'];
		$address = mysqli_real_escape_string($con, $_POST['address']);
		$city = $_POST['city'];
		$state = strtoupper($_POST['state']);
		$pincode = $_POST['pincode'];
		$bank_account_no = $_POST['bank_account_no'];
		$ifsc_code = $_POST['ifsc_code'];
		$bank_name = $_POST['bank_name'];
		$branch_code = $_POST['branch_code'];
		if (isset($_POST['dsc_company'])) {
			$dsc_company = implode(',', $_POST['dsc_company']);
		} else {
			$dsc_company = '';
		}

		$dsc_subscriber = 0;
		$dsc_reseller = 0;
		$pan = 0;
		$tan = 0;
		$it_returns = 0;
		$e_tds = 0;
		$twenty4g = 0;
		$gst = 0;
		$other_services = 0;
		$mobile_repairing = 0;
		$advocate = 0;
		$e_tender=0;
		$trade_mark=0;
        $patent=0;
        $trade_secret=0;
        $copy_right=0;
        $industrial_design=0;
		$trading = 0;
		$psp = 0;
		$psp_coupon_consumption = 0;
		$audit = 0;
		if (isset($_POST['dsc_allows'])) {
			foreach ($_POST['dsc_allows'] as $key => $value) {
				if ($_POST['dsc_allows'][$key] == "DSC Applicant") {
					$dsc_subscriber = 1;
				}
				if ($_POST['dsc_allows'][$key] == "DSC Partner") {
					$dsc_reseller = 1;
				}
			}
		}
		if (isset($_POST['nsdl_allows'])) {
			foreach ($_POST['nsdl_allows'] as $key => $value) {
				if ($_POST['nsdl_allows'][$key] == "PAN") {
					$pan = 1;
				}
				if ($_POST['nsdl_allows'][$key] == "TAN") {
					$tan = 1;
				}
				if ($_POST['nsdl_allows'][$key] == "e-TDS") {
					$e_tds = 1;
				}
				if ($_POST['nsdl_allows'][$key] == "24G") {
					$twenty4g = 1;
				}
			}
		}
		if (isset($_POST['taxation_allows'])) {
			foreach ($_POST['taxation_allows'] as $key => $value) {
				if ($_POST['taxation_allows'][$key] == "IT Returns") {
					$it_returns = 1;
				}
				if ($_POST['taxation_allows'][$key] == "GST") {
					$gst = 1;
				}
				if ($_POST['taxation_allows'][$key] == "Audit") {
					$audit = 1;
				}
			}
		}
		if (isset($_POST['otherServices_allows'])) {
			foreach ($_POST['otherServices_allows'] as $key => $value) {
				if ($_POST['otherServices_allows'][$key] == "Other Services") {
					$other_services = 1;
				}
				if ($_POST['otherServices_allows'][$key] == "Trading") {
					$trading = 1;
				}
				if ($_POST['otherServices_allows'][$key] == "E-Tender") {
					$e_tender = 1;
				}
				if ($_POST['otherServices_allows'][$key] == "Mobile Repairing") {
					$mobile_repairing = 1;
				}
				if ($_POST['otherServices_allows'][$key] == "Advocate") {
					$advocate = 1;
				}
			}
		}
		if (isset($_POST['uti_allows'])) {
			foreach ($_POST['uti_allows'] as $key => $value) {
				if ($_POST['uti_allows'][$key] == "PSP") {
					$psp = 1;
				}
			}
		}
		
		if (isset($_POST['ip_allows'])) {
    		foreach ($_POST['ip_allows'] as $key => $value) {
    			if ($_POST['ip_allows'][$key] == "trade_mark") {
    				$trade_mark = 1;
    			}
    			if ($_POST['ip_allows'][$key] == "patent") {
    				$patent = 1;
    			}
    			if ($_POST['ip_allows'][$key] == "trade_secret") {
    				$trade_secret = 1;
    			}
    			if ($_POST['ip_allows'][$key] == "copy_right") {
    				$copy_right = 1;
    			}
    			if ($_POST['ip_allows'][$key] == "industrial_design") {
    				$industrial_design = 1;
    			}
    		}
    	}
		if ($dsc_reseller == 0) {
			$dsc_company = '';
		}
		/*if ($_POST['uti_allows'][$key] == "PSP Coupon Consumption") {
				$psp_coupon_consumption = 1;
			}*/
		//echo nl2br("\n".$_POST['transaction_allows'][$key]);

		/*if(!isset($_POST['dsc_subscriber']))
			{
			     $dsc_subscriber = 0;
			} else {
			     $dsc_subscriber = $_POST['dsc_subscriber'];
			}
			//$dsc_subscriber = $_POST['dsc_subscriber'];
			if(!isset($_POST['dsc_reseller']))
			{
			     $dsc_reseller = 0;
			} else {
			     $dsc_reseller = $_POST['dsc_reseller'];
			}
			//$dsc_reseller = $_POST['dsc_reseller'];
			if(!isset($_POST['pan']))
			{
			     $pan = 0;
			} else {
			     $pan = $_POST['pan'];
			}
			//$pan = $_POST['pan'];
			if(!isset($_POST['tan']))
			{
			     $tan = 0;
			} else {
			     $tan = $_POST['tan'];
			}
			//$tan = $_POST['tan'];
			if(!isset($_POST['it_returns']))
			{
			     $it_returns = 0;
			} else {
			     $it_returns = $_POST['it_returns'];
			}
			//$it_returns = $_POST['it_returns'];
			if(!isset($_POST['e_tds']))
			{
			     $e_tds = 0;
			} else {
			     $e_tds = $_POST['e_tds'];
			}
			//$e_tds = $_POST['e_tds'];*/
		$gst_no = $_POST['gst_no'];
		if ($gst == 1) {
			//$gst = $_POST['gst'];
		} else {
			//$gst = 0;
			// $gst_no = '';
		}
		//$gst = $_POST['gst'];
		/*if(!isset($_POST['other_services']))
			{
			     $other_services = 0;
			} else {
			     $other_services = $_POST['other_services'];
			}
			//$other_services = $_POST['other_services'];*/
		if (!isset($_POST['previous_balance']) || empty($_POST['previous_balance'])) {
			$previous_balance = 0;
		} else {
			$previous_balance = $_POST['previous_balance'];
		}
		//$previous_balance = $_POST['previous_balance'];
		if ($psp == 1) {
			//$psp = $_POST['psp'];
			$psp_vle_id = $_POST['psp_vle_id'];
		} else {
			//$psp = 0;
			$psp_vle_id = '';
		}
		// $alertMsg = $psp;
		// $alertClass = "alert alert-success";
		//$psp = $_POST['psp'];
		/*if(!isset($_POST['psp_coupon_consumption']))
			{
			     $psp_coupon_consumption = 0;
			} else {
			     $psp_coupon_consumption = $_POST['psp_coupon_consumption'];
			}
			//$psp_coupon_consumption = $_POST['psp_coupon_consumption'];
			if(!isset($_POST['payment']))
			{
			     $payment = 0;
			} else {
			     $payment = $_POST['payment'];
			}*/
		//$payment = $_POST['payment'];
		/*if(!isset($_POST['audit']))
			{
			     $audit = 0;
			} else {
			     $audit = $_POST['audit'];
			}*/
		// if ($cin == 1) {
			$cin = $_POST['cin'];
		/* } else {
			$cin = '';
		} */
		//$audit = $_POST['audit'];
		$other_description = $_POST['other_description'];
		/*if (isset($_POST['psp_vle_id'])) {
				$psp_vle_id = $_POST['psp_vle_id'];
			}else{
				$psp_vle_id = '';
			}*/

		$fetchAdminId = "SELECT * FROM `users` WHERE `company_id` = '" . $_SESSION['company_id'] . "' AND `admin_status` = '1'";
		$runAdminId = mysqli_query($con, $fetchAdminId);
		$AdminIdrow = mysqli_fetch_array($runAdminId);
		if ($_SESSION['admin_status'] == "1") {
			if (isset($_POST['users_access'])) {
				$users_access = $AdminIdrow['id'] . "," . implode(',', $_POST['users_access']);
			} else {
				$users_access = $AdminIdrow['id'];
			}
		} else {
			// $users_access = $AdminIdrow['id'].",".$_SESSION['user_id'];
			$users_access = $AdminIdrow['id'] . "," . implode(',', $_POST['users_access']);
		}
        
        // Fetch old data
            $old_data_query = "SELECT `updated_user`, `updated_time`, `updated_id` FROM `client_master` WHERE `id` = '".$_POST['panEditID_temp']."'";
            // Execute the query and fetch the result, assuming you have a database connection
            $old_data_result = mysqli_query($con, $old_data_query);
            $old_data_row = mysqli_fetch_assoc($old_data_result);
            
            // Assuming you fetched old data from the database
            $old_updated_user = $old_data_row['updated_user'];
            $old_updated_time = $old_data_row['updated_time'];
            $old_updated_id = $old_data_row['updated_id'];
            
            // Prepare new data
            $new_updated_user = $_SESSION['username'];
            $new_updated_time = date('Y-m-d H:i:sa');
            $new_updated_id = $_SESSION['employee_id'];
            
            // Construct additional update values
            $additional_update_values = array();
            
            // Check if old data exists and add it to the update query
            if ($old_updated_user) {
                $additional_update_values[] = "`updated_user`=('" . $old_updated_user . "," . $new_updated_user . "')";
            } else {
                $additional_update_values[] = "`updated_user`=('" . $new_updated_user . "')";
            }
            
            if ($old_updated_time) {
                $additional_update_values[] = "`updated_time`=('" . $old_updated_time . "," . $new_updated_time . "')";
            } else {
                $additional_update_values[] = "`updated_time`=('" . $new_updated_time . "')";
            }
            
            if ($old_updated_id) {
                $additional_update_values[] = "`updated_id`=('" . $old_updated_id . "," . $new_updated_id . "')";
            } else {
                $additional_update_values[] = "`updated_id`=('" . $new_updated_id . "')";
            }

            
            // Implode additional update values
            $additional_update_query = implode(", ", $additional_update_values);
            
            
		$client_master_update_query = "UPDATE `client_master` SET `company_id` = '" . $_SESSION['company_id'] . "',`client_name`='" . $client_name . "',`trade_mark`='" . $trade_mark . "',`patent`='" . $patent . "',`trade_secret`='" . $trade_secret . "',`copy_right`='" . $copy_right . "',`industrial_design`='" . $industrial_design . "',`company_name`='" . $company_name . "',`contact_person`='" . $contact_person . "',`mobile_no`='" . $mobile_number . "',`pan_no`='" . $pan_no . "',`landline_no`='" . $landline_number . "',`email_1`='" . $email_id_1 . "',`password`='" . $password . "',`email_2`='" . $email_id_2 . "',`address`='" . $address . "',`state`='" . $state . "',`city`='" . $city . "',`pincode`='" . $pincode . "',`bank_account_no`='" . $bank_account_no . "',`ifsc_code`='" . $ifsc_code . "',`bank_name`='" . $bank_name . "',`branch_code`='" . $branch_code . "',`dsc_subscriber`='" . $dsc_subscriber . "',`dsc_reseller`='" . $dsc_reseller . "',`pan`='" . $pan . "',`tan`='" . $tan . "',`it_returns`='" . $it_returns . "',`e_tds`='" . $e_tds . "',`24g`='" . $twenty4g . "',`gst`='" . $gst . "',`other_services`='" . $other_services . "',`e_tender`='" . $e_tender . "',`mobile_repairing`='" . $mobile_repairing . "',`advocate`='".$advocate."',`trading`='" . $trading . "',`psp`='" . $psp . "',`psp_coupon_consumption`='" . $psp_coupon_consumption . "',`audit`='" . $audit . "',`gst_no`='" . $gst_no . "',`other_description`='" . $other_description . "', `psp_vle_id` = '" . $psp_vle_id . "', `cin` = '" . $cin . "', `previous_balance` = '" . $previous_balance . "',',`dsc_reseller_company`='" . $dsc_company . "', `users_access` = '" . $users_access . "', ".$additional_update_query." WHERE `id` = '" . $_POST['client_masterEditID_temp'] . "'";
		$run_client_master_update = mysqli_query($con, $client_master_update_query);
		if ($run_client_master_update) {
			$alertMsg = "Record Updated";
			$alertClass = "alert alert-success";
		}
	}
}
if (isset($_POST['client_delete'])) {
	if (isset($_POST['tempClient_MasterIDdel']) && !empty($_POST['tempClient_MasterIDdel'])) {
		$deleteClient_Master_query = "DELETE FROM `client_master` WHERE `id` = '" . $_POST['tempClient_MasterIDdel'] . "'";
		$run_del_query = mysqli_query($con, $deleteClient_Master_query);
		if ($run_del_query) {
			$alertMsg = "Record Deleted";
			$alertClass = "alert alert-danger";
		}
	}
}
if (isset($_POST['bulk_delete'])) {
	if (isset($_POST['tempMultipleIDdel']) && !empty($_POST['tempMultipleIDdel'])) {
		$MultipleDeleteArray = json_decode(stripslashes($_POST['tempMultipleIDdel']));
		//$allValues = implode(",", $MultipleDeleteArray);
		$count = 0;
		foreach ($MultipleDeleteArray as $deleteList) {
			$MultipleDelete_query = "DELETE FROM `client_master` WHERE `id` IN ('" . $deleteList . "')";
			$run_del_query = mysqli_query($con, $MultipleDelete_query);
			$count++;
		}
		if ($run_del_query) {
			$alertMsg = $count . " Record(s) Deleted";
			$alertClass = "alert alert-danger";
		}
	}
}
?>
<!DOCTYPE html>
<html>

<head>
	<title>Vowel Enterprise CMS - Recipient Master</title>
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<link rel="stylesheet" href="//cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
	<style type="text/css">
		.toggleswitch {
			position: relative;
			display: inline-block;
			width: 30px;
			height: 17px;
		}

		.toggleswitch input {
			opacity: 0;
			width: 0;
			height: 0;
		}

		.toggleslider {
			position: absolute;
			cursor: pointer;
			top: 0;
			left: 0;
			right: 0;
			bottom: 0;
			background-color: #ccc;
			-webkit-transition: .4s;
			transition: .4s;
		}

		.toggleslider:before {
			position: absolute;
			content: "";
			height: 13px;
			width: 13px;
			left: 2px;
			bottom: 2px;
			background-color: white;
			-webkit-transition: .4s;
			transition: .4s;
		}

		input:checked+.toggleslider {
			background-color: #2196F3;
		}

		/*.TDtoggleswitch:before {
			background-color: #FFF;
		}

		.TDtoggleswitch .toggleswitch input:checked ~ .TDtoggleswitch::before {
			background-color: #777;
		}

		.TDtoggleswitch .toggleswitch input:checked~ .TDtoggleswitch::after {
			background-color: red;
		}*/

		input:focus+.toggleslider {
			box-shadow: 0 0 1px #2196F3;
		}

		input:checked+.toggleslider:before {
			-webkit-transform: translateX(13px);
			-ms-transform: translateX(13px);
			transform: translateX(13px);
		}

		/* Rounded sliders */
		.toggleslider.toggleround {
			border-radius: 34px;
		}

		.toggleslider.toggleround:before {
			border-radius: 50%;
		}

		.equalDivide tr td {
			width: 35%;
		}

		/*.first-col {
		    position: absolute;
		    width: auto;
		    //margin-left: 2%;
		    background: #FFF;
		    z-index: 1;
		    height: 10%;
		}
		.second-col {
		    position: absolute;
		    width: auto;
		    margin-left: 4%;
		    background: #FFF;
		    z-index: 2;
		    height: 10%;
		}
		.third-col {
		    position: absolute;
		    width: auto;
		    margin-left: 8%;
		    background: #FFF;
		    z-index: 3;
		    height: 10%;
		}
		.fourth-col {
		    position: absolute;
		    width: auto;
		    margin-left: 12%;
		    background: #FFF;
		    z-index: 4;
		    height: 10%;
		}
		.table-wrapper {
		    overflow-x: scroll;
			width: 100%;
			margin: 0 auto;
			//border: 1px solid red;
			z-index: 5;
		}*/
		.dsc_company {
			height: 120px;
			width: 100%;
			overflow-y: auto;
			-webkit-appearance: menulist;
			position: relative;
		}

		.dsc_company::before {
			//content: var(--text);
			display: block;
			margin-left: 5px;
			margin-bottom: 2px;
		}

		.dsc_company_active {
			//overflow: visible !important;
			overflow-y: scroll;
		}

		.dsc_company option {
			//display: none;
			height: 18px;
			background-color: white;
		}

		.dsc_company_active option {
			display: block;
		}

		.dsc_company option::before {
			font-family: "Font Awesome 5 Free";
			content: "\f0c8 ";
			width: 1.3em;
			text-align: center;
			display: inline-block;
		}

		.dsc_company option:checked::before {
			font-family: "Font Awesome 5 Free";
			content: "\f14a ";
		}

		/*Taxation Allows*/
		.taxation_allows {
			height: 180px;
			width: 100%;
			overflow-y: auto;
			-webkit-appearance: menulist;
			position: relative;
		}

		.taxation_allows::before {
			//content: var(--text);
			display: block;
			margin-left: 5px;
			margin-bottom: 2px;
		}

		.taxation_allows_active {
			//overflow: visible !important;
			overflow-y: scroll;
		}

		.taxation_allows option {
			//display: none;
			height: 18px;
			background-color: white;
		}

		.taxation_allows_active option {
			display: block;
		}

		.taxation_allows option::before {
			font-family: "Font Awesome 5 Free";
			content: "\f0c8 ";
			width: 1.3em;
			text-align: center;
			display: inline-block;
		}

		.taxation_allows option:checked::before {
			font-family: "Font Awesome 5 Free";
			content: "\f14a ";
		}

		/*NSDL Allows*/
		.nsdl_allows {
			height: 180px;
			width: 100%;
			overflow-y: auto;
			-webkit-appearance: menulist;
			position: relative;
		}

		.nsdl_allows::before {
			//content: var(--text);
			display: block;
			margin-left: 5px;
			margin-bottom: 2px;
		}

		.nsdl_allows_active {
			//overflow: visible !important;
			overflow-y: scroll;
		}

		.nsdl_allows option {
			//display: none;
			height: 18px;
			background-color: white;
		}

		.nsdl_allows_active option {
			display: block;
		}

		.nsdl_allows option::before {
			font-family: "Font Awesome 5 Free";
			content: "\f0c8 ";
			width: 1.3em;
			text-align: center;
			display: inline-block;
		}

		.nsdl_allows option:checked::before {
			font-family: "Font Awesome 5 Free";
			content: "\f14a ";
		}

		/*DSC Allows*/
		.dsc_allows {
			height: 180px;
			width: 100%;
			overflow-y: auto;
			-webkit-appearance: menulist;
			position: relative;
		}

		.dsc_allows::before {
			//content: var(--text);
			display: block;
			margin-left: 5px;
			margin-bottom: 2px;
		}

		.dsc_allows_active {
			//overflow: visible !important;
			overflow-y: scroll;
		}

		.dsc_allows option {
			//display: none;
			height: 18px;
			background-color: white;
		}

		.dsc_allows_active option {
			display: block;
		}

		.dsc_allows option::before {
			font-family: "Font Awesome 5 Free";
			content: "\f0c8 ";
			width: 1.3em;
			text-align: center;
			display: inline-block;
		}

		.dsc_allows option:checked::before {
			font-family: "Font Awesome 5 Free";
			content: "\f14a ";
		}

		/*Other Services Allows*/
		.otherServices_allows {
			height: 180px;
			width: 100%;
			overflow-y: auto;
			-webkit-appearance: menulist;
			position: relative;
		}

		.otherServices_allows::before {
			//content: var(--text);
			display: block;
			margin-left: 5px;
			margin-bottom: 2px;
		}

		.otherServices_allows_active {
			//overflow: visible !important;
			overflow-y: scroll;
		}

		.otherServices_allows option {
			//display: none;
			height: 18px;
			background-color: white;
		}

		.otherServices_allows_active option {
			display: block;
		}

		.otherServices_allows option::before {
			font-family: "Font Awesome 5 Free";
			content: "\f0c8 ";
			width: 1.3em;
			text-align: center;
			display: inline-block;
		}

		.otherServices_allows option:checked::before {
			font-family: "Font Awesome 5 Free";
			content: "\f14a ";
		}

		/*UTI Allows*/
		.uti_allows {
			height: 180px;
			width: 100%;
			overflow-y: auto;
			-webkit-appearance: menulist;
			position: relative;
		}

		.uti_allows::before {
			//content: var(--text);
			display: block;
			margin-left: 5px;
			margin-bottom: 2px;
		}

		.uti_allows_active {
			//overflow: visible !important;
			overflow-y: scroll;
		}

		.uti_allows option {
			//display: none;
			height: 18px;
			background-color: white;
		}

		.uti_allows_active option {
			display: block;
		}

		.uti_allows option::before {
			font-family: "Font Awesome 5 Free";
			content: "\f0c8 ";
			width: 1.3em;
			text-align: center;
			display: inline-block;
		}

		.uti_allows option:checked::before {
			font-family: "Font Awesome 5 Free";
			content: "\f14a ";
		}
		
		
		
		/*Intellectual Property Allows*/
		.ip_allows {
			height: 180px;
			width: 100%;
			overflow-y: auto;
			-webkit-appearance: menulist;
			position: relative;
		}

		.ip_allows::before {
			//content: var(--text);
			display: block;
			margin-left: 5px;
			margin-bottom: 2px;
		}

		.ip_allows_active {
			//overflow: visible !important;
			overflow-y: scroll;
		}

		.ip_allows option {
			//display: none;
			height: 18px;
			background-color: white;
		}

		.ip_allows_active option {
			display: block;
		}

		.ip_allows option::before {
			font-family: "Font Awesome 5 Free";
			content: "\f0c8 ";
			width: 1.3em;
			text-align: center;
			display: inline-block;
		}

		.ip_allows option:checked::before {
			font-family: "Font Awesome 5 Free";
			content: "\f14a ";
		}

		/* Users access */
		.multiple_select {
			height: 18px;
			width: 90%;
			overflow-y: auto;
			-webkit-appearance: menulist;
			position: relative;
		}

		.multiple_select::before {
			//content: var(--text);
			display: block;
			margin-left: 5px;
			margin-bottom: 2px;
		}

		.multiple_select_active {
			//overflow: visible !important;
			overflow-y: scroll;
		}

		.multiple_select option {
			display: block;
			height: 18px;
			background-color: white;
		}

		.multiple_select_active option {
			display: block;
		}

		.multiple_select option::before {
			font-family: "Font Awesome 5 Free";
			content: "\f0c8 ";
			width: 1.3em;
			text-align: center;
			display: inline-block;
		}

		.multiple_select option:checked::before {
			font-family: "Font Awesome 5 Free";
			content: "\f14a ";
		}
		
		/* Style the tab */
        .tab {
          overflow: hidden;
          border: 1px solid #ccc;
          background-color: #f1f1f1;
        }
        
        /* Style the buttons inside the tab */
        .tab button {
          background-color: inherit;
          float: left;
          border: none;
          outline: none;
          cursor: pointer;
          padding: 14px 16px;
          transition: 0.3s;
          font-size: 17px;
        }
        
        /* Change background color of buttons on hover */
        .tab button:hover {
          background-color: #ddd;
        }
        
        /* Create an active/current tablink class */
        .tab button.active {
          background-color: #ccc;
        }
        
        /* Style the tab content */
        .tabcontent {
          display: none;
          border-top: none;
        }
	</style>
	<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
	<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
</head>

<body>
	<div class="container-fluid">
		<h2 align="center" class="pageHeading" id="pageHeading">Recipient Master</h2>
		<div class="row border justify-content-center" id="after-heading">
			<?php
			if (isset($_POST['client_master_csv'])) {
				//var_dump($_FILES['client_file']);
				//echo var_dump(expression)
				//echo $_FILES['client_file']['type'];
				//$info = pathinfo($_FILES['client_file']['tmp_name']);
				$type = explode(".", $_FILES['client_file']['name']);
				if (strtolower(end($type)) == 'csv') {
					$file = $_FILES['client_file']['tmp_name'];
					$state_csv = false;
					$first = false;
					$second = false;
					$ExistFlag = false;
					$HeaderRow = false;
					$FormatErrorFlag = false;
					$ErroneousData = [];
					$ErroneouslineDataCount = 0;
					//$stored = [];
					$NotMatchedlineData = [];
					$DuplicatelineData = [];
					$successCount = 0;
					$EmptylineDataCount = 0;
					$file = fopen($file, "r");
					$count = 0;
					$temp_ErroneouslineDataCount = 0;
					while ($row = fgetcsv($file)) {
						if ($HeaderRow == false) {
							$firstFormat = implode(",", $row);
							// ,Fees Received,Service Id
							if ($firstFormat != "Recipient Name,Company Name,Contact Person,Mobile Number,Pan Number,Landline Number,E-Mail ID - 1,E-Mail ID - 2,Address,State,City,Pincode,Bank Account Number,IFSC Code,Bank Name,Branch Code,GST Number,Other Description,DSC Applicant,DSC Partner,PAN,TAN,IT Returns,e-TDS,24G,GST,Other Services,PSP,PSP Coupon Consumption,Audit,PSP VLE ID,CIN,Previous Balance,DSC Company,Password,Trade Mark,Patent,Trade Secret,Copy Right,Industrial Design,Bank EmPanelment") {
							// if ($firstFormat != "Recipient Name,Company Name,Contact Person,Mobile Number,Pan Number,Landline Number,E-Mail ID - 1,E-Mail ID - 2,Address,State,City,Pincode,Bank Account Number,IFSC Code,Bank Name,Branch Code,GST Number,Other Description,DSC Applicant,DSC Partner,PAN,TAN,IT Returns,e-TDS,24G,GST,Other Services,PSP,PSP Coupon Consumption,Audit,PSP VLE ID,CIN,Previous Balance,DSC Company,Password,Fees Received,Service Id") {
								//echo "Not Matched";
								$FormatErrorFlag = true;
								$HeaderRow = false;
							} else {
								$FormatErrorFlag = false;
								$HeaderRow = true;
								//echo "Matched";
							}
						}
						if ($HeaderRow == true) {
							if (!$first) {
								$first = true;
							} else {
								$emptyRow = [];
								$duplicateRow = [];
								$NotMatchedlineData = [];
								$Allow_DscComapny = true;
								$runInsertPostion = false;
								$count++;
								$row[0] = mysqli_real_escape_string($con, $row[0]);
								$row[1] = mysqli_real_escape_string($con, $row[1]);
								$row[2] = mysqli_real_escape_string($con, $row[2]);
								$row[3] = mysqli_real_escape_string($con, $row[3]);
								$row[4] = mysqli_real_escape_string($con, $row[4]);
								$row[5] = mysqli_real_escape_string($con, $row[5]);
								$row[6] = mysqli_real_escape_string($con, $row[6]);
								$row[7] = mysqli_real_escape_string($con, $row[7]);
								$row[8] = mysqli_real_escape_string($con, $row[8]);
								$row[9] = mysqli_real_escape_string($con, $row[9]);
								$row[10] = mysqli_real_escape_string($con, $row[10]);
								$row[11] = mysqli_real_escape_string($con, $row[11]);
								$row[12] = mysqli_real_escape_string($con, $row[12]);
								$row[13] = mysqli_real_escape_string($con, $row[13]);
								$row[14] = mysqli_real_escape_string($con, $row[14]);
								$row[15] = mysqli_real_escape_string($con, $row[15]);
								$row[16] = mysqli_real_escape_string($con, $row[16]);
								$row[17] = mysqli_real_escape_string($con, $row[17]);
								$row[18] = mysqli_real_escape_string($con, $row[18]);
								$row[19] = mysqli_real_escape_string($con, $row[19]);
								$row[20] = mysqli_real_escape_string($con, $row[20]);
								$row[21] = mysqli_real_escape_string($con, $row[21]);
								$row[22] = mysqli_real_escape_string($con, $row[22]);
								$row[23] = mysqli_real_escape_string($con, $row[23]);
								$row[24] = mysqli_real_escape_string($con, $row[24]);

								$row[25] = mysqli_real_escape_string($con, $row[25]);
								$row[26] = mysqli_real_escape_string($con, $row[26]);
								$row[27] = mysqli_real_escape_string($con, $row[27]);
								$row[28] = mysqli_real_escape_string($con, $row[28]);
								$row[29] = mysqli_real_escape_string($con, $row[29]);
								$row[30] = mysqli_real_escape_string($con, $row[30]);
								$row[31] = mysqli_real_escape_string($con, $row[31]);
								$row[32] = mysqli_real_escape_string($con, $row[32]);
								$row[33] = mysqli_real_escape_string($con, $row[33]);
								$row[34] = mysqli_real_escape_string($con, $row[34]);
								$row[34] = mysqli_real_escape_string($con, $row[35]);
								$row[34] = mysqli_real_escape_string($con, $row[36]);
								$row[34] = mysqli_real_escape_string($con, $row[37]);
								$row[34] = mysqli_real_escape_string($con, $row[38]);
								$row[34] = mysqli_real_escape_string($con, $row[39]);
								$row[34] = mysqli_real_escape_string($con, $row[40]);
								// $row[35] = mysqli_real_escape_string($con,$row[35]);
								// $row[36] = mysqli_real_escape_string($con,$row[36]);
								if ($row[34] != '') {
									$row[34] = mysqli_real_escape_string($con, $row[34]);
								}
								if ($row[18] == "") {
									$row[18] = 0;
								}
								if ($row[19] == "") {
									$row[19] = 0;
								}
								if ($row[20] == "") {
									$row[20] = 0;
								}
								if ($row[21] == "") {
									$row[21] = 0;
								}
								if ($row[22] == "") {
									$row[22] = 0;
								}
								if ($row[23] == "") {
									$row[23] = 0;
								}
								if ($row[24] == "") {
									$row[24] = 0;
								}
								if ($row[25] == "") {
									$row[25] = 0;
								}
								if ($row[26] == "") {
									$row[26] = 0;
								}
								if ($row[27] == "") {
									$row[27] = 0;
								}
								if ($row[28] == "") {
									$row[28] = 0;
								}
								if ($row[29] == "") {
									$row[29] = 0;
								}

								if ($row[0] == "") {
									array_push($emptyRow, "Recipient Name");
									$ErroneouslineDataCount++;
								}
								if ($row[1] == "") {
									array_push($emptyRow, "Company Name");
									$ErroneouslineDataCount++;
								}
								if ($row[2] == "") {
									array_push($emptyRow, "Contact Person");
									$ErroneouslineDataCount++;
								}
								if ($row[3] == "") {
									array_push($emptyRow, "Mobile Number");
									$ErroneouslineDataCount++;
								}
								/*if ($row[4] == "") {
										array_push($emptyRow,"Pan Number");
										$ErroneouslineDataCount++;
									}*/
								if ($row[6] == "") {
									array_push($emptyRow, "E-Mail ID - 1");
									$ErroneouslineDataCount++;
								}
								/*if ($row[8] == "") {
										array_push($emptyRow,"Address");
										$ErroneouslineDataCount++;
									}
									if ($row[9] == "") {
										array_push($emptyRow,"State");
										$ErroneouslineDataCount++;
									}
									if ($row[10] == "") {
										array_push($emptyRow,"City");
										$ErroneouslineDataCount++;
									}
									if ($row[11] == "") {
										array_push($emptyRow,"Pincode");
										$ErroneouslineDataCount++;
									}*/
								if ($row[30] == "" && $row[27] == 1) {
									array_push($emptyRow, "PSP VLE ID");
									$ErroneouslineDataCount++;
								}
								if ($row[31] == "" && $row[29] == 1) {
									array_push($emptyRow, "CIN");
									$ErroneouslineDataCount++;
								}
								/*if ($row[32] == "") {
										$row[32] = 1;
									}*/
								if ($row[16] != "" || !empty($row[16])) {
									$gstQuery = "SELECT `id` FROM `client_master` WHERE `gst_no` = '" . $row[16] . "' AND `company_id` = '" . $_SESSION['company_id'] . "'";
									$Result_gst = mysqli_query($con, $gstQuery);
									if (mysqli_num_rows($Result_gst) > 0) {
										array_push($duplicateRow, "GST Number");
										$ErroneouslineDataCount++;
									}
									$mobileQuery = "SELECT `id` FROM `client_master` WHERE `mobile_no` = '" . $row[3] . "' AND `company_id` = '" . $_SESSION['company_id'] . "'";
									$Result_mobile = mysqli_query($con, $mobileQuery);
									if (mysqli_num_rows($Result_mobile) > 0) {
										array_push($duplicateRow, "Mobile Number");
										$ErroneouslineDataCount++;
									}
									/*if ($row[4] != "") {
						                	$panQuery = "SELECT `id` FROM `client_master` WHERE `pan_no` = '".$row[4]."' AND `company_id` = '".$_SESSION['company_id']."'";
									    	$Result_pan = mysqli_query($con,$panQuery);
							                if(mysqli_num_rows($Result_pan) > 0){
							                	array_push($duplicateRow,"Pan Number");
							                	$ErroneouslineDataCount++;
							                }
						                }*/
								} else {
									//echo "string";
									$mobileQuery = "SELECT `id` FROM `client_master` WHERE `mobile_no` = '" . $row[3] . "' AND `company_id` = '" . $_SESSION['company_id'] . "'";
									$Result_mobile = mysqli_query($con, $mobileQuery);
									if (mysqli_num_rows($Result_mobile) > 0) {
										array_push($duplicateRow, "Mobile Number");
										$ErroneouslineDataCount++;
									}
									/*if ($row[4] != "") {
							                $panQuery = "SELECT `id` FROM `client_master` WHERE `pan_no` = '".$row[4]."' AND `company_id` = '".$_SESSION['company_id']."'";
									    	$Result_pan = mysqli_query($con,$panQuery);
							                if(mysqli_num_rows($Result_pan) > 0){
							                	array_push($duplicateRow,"Pan Number");
							                	$ErroneouslineDataCount++;
							                }
							            }*/
								}
								//echo nl2br("\nDuplicate".implode(",", $duplicateRow));
								//echo nl2br("\nDsc Partner - ".$row[19]);
								if ($row[19] == '1' && $row[33] == '') {
									array_push($emptyRow, "DSC Company");
									$ErroneouslineDataCount++;
									$Allow_DscComapny = false;
								// 	echo "Nor ing";
								} else if ($row[19] == '1' && $row[33] != '') {
								    // echo "IN DSC";
									$arr = explode(',', $row[33]);
									foreach ($arr as $dscCompany) {
										//echo nl2br("\n".$dscCompany);
										if ($dscCompany != "Capricorn" && $dscCompany != "Siffy" && $dscCompany != "Emudra" && $dscCompany != "Vsign" && $dscCompany != "IDsign" && $dscCompany != "Pantasign" && $dscCompany != "Xtra Trust") {
											array_push($NotMatchedlineData, "DSC Company");
											$ErroneouslineDataCount++;
										}
									}
								}
								/* if (implode(",", $emptyRow) == "") {
										echo nl2br("\n".implode(",", $emptyRow)." ".$row[0]." ".$ErroneouslineDataCount);
										//$emptyRow = ["Upload"];
									} */
								$serviceIdExist = false;
								/* if ($row[11] != "") {
										$Exist_Query = "SELECT * FROM `client_master` WHERE `transaction_id` = '".$row[11]."'";
										$Result_Exist = mysqli_query($con,$Exist_Query);
										if(mysqli_num_rows($Result_Exist) > 0){
											array_push($duplicateRow,"Service Id");
											$ErroneouslineDataCount++;
											$serviceIdExist = true;
										}
									} */

								if ($ErroneouslineDataCount > 0) {
									$erroneous_value = implode(",", $emptyRow) . "','" . implode(",", $duplicateRow) . "','" . implode(",", $NotMatchedlineData) . "','" . implode("','", $row);
								} else if (!$second) {
								    echo "s";
									$erroneous_value = "Uploaded" . "','" . "','" . "','" . implode("','", $row);
								}
								if ($temp_ErroneouslineDataCount == $ErroneouslineDataCount && $temp_ErroneouslineDataCount != 0) {
									$erroneous_value = "Uploaded" . "','" . "','" . "','" . implode("','", $row);
								}
								$temp_ErroneouslineDataCount = $ErroneouslineDataCount;
								//echo $Allow_DscComapny;
								if ($row[0] == "" && $row[1] == "" && $row[2] == "" && $row[3] == "" && $row[6] == "" && $Allow_DscComapny == false) // || $row[8] == "" || $row[9] == "" || $row[10] == "" || $row[11] == "")
								{
									//array_push($ErroneousData,$erroneous_value);
									$EmptylineDataCount++;
									//echo "row all";
								} else if ($row[0] != "" && $row[1] != "" && $row[2] != "" && $row[3] != "" && $row[6] != "" && ($Allow_DscComapny == true) && ($serviceIdExist == false)) // || $row[8] != "" || $row[9] != "" || $row[10] != "" || $row[11] != "") 
								{
									$row[0] = strtoupper($row[0]);
									$row[9] = strtoupper($row[9]);
									$row[30] = strtoupper($row[30]);
									if ($row[32] == "") {
										$row[32] = 0;
									}
									if ($row[27] == 1 || $row[29] == 1) {
										//echo nl2br("\n".'here - Out');
										if ($row[27] == 1) {
											if ($row[30] == "") {
												//array_push($ErroneousData,$erroneous_value);
												$ErroneouslineDataCount++;
												$EmptylineDataCount++;
												$allowToProceedOne = false;
												//echo "row 29";
											} else {
												$allowToProceedOne = true;
											}
										} else {
											$allowToProceedOne = true;
										}
										if ($row[29] == 1) {
											if ($row[31] == "") {
												//array_push($ErroneousData,$erroneous_value);
												$ErroneouslineDataCount++;
												$EmptylineDataCount++;
												$allowToProceedTwo = false;
												//echo "row 28";
											} else {
												$allowToProceedTwo = true;
											}
										} else {
											$allowToProceedTwo = true;
										}
										if ($allowToProceedOne == true && $allowToProceedTwo == true) {
											//echo 'here - IN';
											$runInsertPostion = true;
											/* $value = "'".$_SESSION['company_id']."','". implode("','", $row) . "','".$_SESSION['username']."','".date('Y-m-d H:i:sa')."'";
												//$value2 = "<tr><td>". $count."</td><td>". implode("<td>", $row) . "</td></tr>";
												$value2 = implode("','", $row);
												$insert_query = "INSERT INTO `client_master` (`company_id`, `client_name`, `company_name`, `contact_person`, `mobile_no`, `pan_no`, `landline_no`, `email_1`, `email_2`, `address`, `state`, `city`, `pincode`, `bank_account_no`, `ifsc_code`, `bank_name`, `branch_code`, `gst_no`, `other_description`, `dsc_subscriber`, `dsc_reseller`, `pan`, `tan`, `it_returns`, `e_tds`, `24g`, `gst`, `other_services`, `psp`, `psp_coupon_consumption`, `audit`, `psp_vle_id`, `cin`,`previous_balance`,`dsc_reseller_company`,`modify_by`,`modify_date`) VALUES (". $value .")";
											    //echo $insert_query;
												if ($row[16] != "") {
													$prevQuery = "SELECT `id` FROM `client_master` WHERE (`mobile_no` = '".$row[3]."' OR `gst_no` = '".$row[16]."') AND `company_id` = '".$_SESSION['company_id']."'";
													//echo nl2br("\nNot Null ".$prevQuery);
												}else if ($row[16] == ""){
													$prevQuery = "SELECT `id` FROM `client_master` WHERE (`mobile_no` = '".$row[3]."') AND `company_id` = '".$_SESSION['company_id']."'";
													//echo nl2br("\nNull ".$prevQuery);
												} */
											/*if ($row[16] != "") {
											    	// /*if ($row[4] != "") {
											    	// 	$prevQuery = "SELECT `id` FROM `client_master` WHERE (`mobile_no` = '".$row[3]."' OR `pan_no` = '".$row[4]."' OR `gst_no` = '".$row[16]."') AND `company_id` = '".$_SESSION['company_id']."'";
											    	// }else
													 if ($row[4] == ""){
											    		$prevQuery = "SELECT `id` FROM `client_master` WHERE (`mobile_no` = '".$row[3]."' OR `gst_no` = '".$row[16]."') AND `company_id` = '".$_SESSION['company_id']."'";
											    	}
											    }else if ($row[16] == ""){
											    	// /*if ($row[4] != "") {
											    	// 	$prevQuery = "SELECT `id` FROM `client_master` WHERE (`mobile_no` = '".$row[3]."' OR `pan_no` = '".$row[4]."') AND `company_id` = '".$_SESSION['company_id']."'";
											    	// }else
													 if ($row[4] == "") {
											    		$prevQuery = "SELECT `id` FROM `client_master` WHERE (`mobile_no` = '".$row[3]."') AND `company_id` = '".$_SESSION['company_id']."'";
											    	}
											    }*/
											/* $arr = explode(',', $row[33]);
								                $prevResult = mysqli_query($con,$prevQuery);
								                if(mysqli_num_rows($prevResult) > 0){
													array_push($DuplicatelineData,$value2);
								                	//echo "Bro Here";
								                }else{
													if ($row[19] == '1' && $row[33] != '') {
														foreach ($arr as $dscCompany) {
															//echo nl2br("\n".$dscCompany);
															if ($dscCompany == "Capricorn" || $dscCompany == "Siffy" || $dscCompany == "Emudra" || $dscCompany == "Vsign" || $dscCompany == "IDsign" || $dscCompany == "Pantasign") {
																$ExistFlag = true;
																break;
															}
														}												
													}
													echo nl2br("\nhere - ".$ExistFlag." ".$row[32]." ".$row[33]);
													if ($ExistFlag == false) {
														array_push($NotMatchedlineData,$value2);
													}else{
														if(mysqli_query($con,$insert_query)){
															$state_csv = true;
															$successCount++;
														}else{
															$state_csv = false;
														}
													}
												} */
										} else {
											$runInsertPostion = false;
										}
									} else if ($row[27] != 1 && $row[29] != 1) {
										$row[30] = "";
										$row[31] = "";
										$runInsertPostion = true;
									}
									if ($runInsertPostion == true) {
										/* if ($row[35] != "") {
												$row[35] = 0;
											}
											if ($row[36] == '') {
												$fetchLastTransactionId = "SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = '".$DBName."' AND TABLE_NAME = 'client_master'";
												$run_fetchLastTransactionId = mysqli_query($con,$fetchLastTransactionId);
												$transaction_id = "VE_CLM_54";
												if (mysqli_num_rows($run_fetchLastTransactionId) > 0) {
													$FetchlastTransactionID_row = mysqli_fetch_array($run_fetchLastTransactionId);
													$transaction_id = "VE_CLM_".($FetchlastTransactionID_row['AUTO_INCREMENT'] * 54);
													$row[36] = $transaction_id;
												}
											} */
										$fetchLastTransactionId = "SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = '" . $DBName . "' AND TABLE_NAME = 'client_master'";
										$run_fetchLastTransactionId = mysqli_query($con, $fetchLastTransactionId);
								// 		$transaction_id = "VE_CLM_954";
										if (mysqli_num_rows($run_fetchLastTransactionId) > 0) {
											$FetchlastTransactionID_row = mysqli_fetch_array($run_fetchLastTransactionId);
								// 			$transaction_id = "VE_CLM_" . ($FetchlastTransactionID_row['AUTO_INCREMENT'] * 954);
											$transaction_id = $_SESSION['company_name_for_transacrion_id'] . "_CLM_" . ($FetchlastTransactionID_row['AUTO_INCREMENT'] * 954);
											// $row[36] = $transaction_id;
										}

										// '".$transaction_id."',
										$value = "'" . $transaction_id . "','" . $_SESSION['company_id'] . "','" . implode("','", $row) . "','" . $_SESSION['username'] . "','" . date('Y-m-d H:i:sa') . "'";
										//$value2 = "<tr><td>". $count."</td><td>". implode("<td>", $row) . "</td></tr>";
										$value2 = implode("','", $row);
										$insert_query = "INSERT INTO `client_master` (`transaction_id`, `company_id`, `client_name`, `company_name`, `contact_person`, `mobile_no`, `pan_no`, `landline_no`, `email_1`, `email_2`, `address`, `state`, `city`, `pincode`, `bank_account_no`, `ifsc_code`, `bank_name`, `branch_code`, `gst_no`, `other_description`, `dsc_subscriber`, `dsc_reseller`, `pan`, `tan`, `it_returns`, `e_tds`, `24g`, `gst`, `other_services`, `psp`, `psp_coupon_consumption`, `audit`, `psp_vle_id`, `cin`,`previous_balance`,`dsc_reseller_company`, `password`,`trade_mark`,`patent`,`trade_secret`,`copy_right`,`industrial_design`,`legal_notice`,`modify_by`,`modify_date`) VALUES (" . $value . ")";
										// , `fees_received`, `transaction_id`
										if ($row[16] != "") {
											$prevQuery = "SELECT `id` FROM `client_master` WHERE (`mobile_no` = '" . $row[3] . "' OR `gst_no` = '" . $row[16] . "') AND `company_id` = '" . $_SESSION['company_id'] . "'";
											//echo nl2br("\nNot Null ".$prevQuery);
										} else if ($row[16] == "") {
											$prevQuery = "SELECT `id` FROM `client_master` WHERE (`mobile_no` = '" . $row[3] . "') AND `company_id` = '" . $_SESSION['company_id'] . "'";
											//echo nl2br("\nNull ".$prevQuery);
										} // OR `pan_no` = '".$row[4]."'
										$arr = explode(',', $row[33]);
										$prevResult = mysqli_query($con, $prevQuery);
										if (mysqli_num_rows($prevResult) > 0) {
											array_push($DuplicatelineData, $value2);
								// 			echo "Bro Here";
										} else {
										  //  echo "Fsff";
										    $ExistFlag = true;
											if ($row[19] == '1' && $row[33] != '') {
												foreach ($arr as $dscCompany) {
												// 	echo nl2br("\n".$dscCompany);
												// echo "Check DSC";
													if ($dscCompany == "Capricorn" || $dscCompany == "Siffy" || $dscCompany == "Emudra" || $dscCompany == "Vsign" || $dscCompany == "IDsign" || $dscCompany == "Pantasign" || $dscCompany == "Xtra Trust") {
														$ExistFlag = true;
														break;
													}
												}
											}
								// 			echo nl2br("\n - ".$ExistFlag." ".$row[32]." ".$row[33]);
								// 			if ($ExistFlag == false) {
								// 				array_push($NotMatchedlineData, $value2);
								// 				echo "not";
								// 			} else {
								// 				if (mysqli_query($con, $insert_query)) {
								// 				    echo "insert";
								// 					$state_csv = true;
								// 					$successCount++;
								// 				} else {
								// 					$state_csv = false;
								// 				}
								// 			}
								
								// echo nl2br("\n - " . $ExistFlag . " " . $row[32] . " " . $row[33]);
                                
                                if ($ExistFlag == false) {
                                    array_push($NotMatchedlineData, $value2);
                                    // echo "not";
                                } else {
                                    // var_dump($ExistFlag);  // Add this line for debugging
                                    // echo "insert";
                                    if (mysqli_query($con, $insert_query)) {
                                        $state_csv = true;
                                        $successCount++;
                                    } else {
                                        $state_csv = false;
                                    }
                                }

										}
									}
								}
								if (isset($ErroneouslineDataCount) && $ErroneouslineDataCount > 0) {
									array_push($ErroneousData, $erroneous_value);
								} else if (!$second) {
									array_push($ErroneousData, $erroneous_value);
									//$second = true;
								}
							}
						} else if ($HeaderRow == false) {
							//echo "Not Matched";
							$state_csv = "fileError";
							break;
						}
					}
					//echo $state_csv;
					if ($state_csv == "fileError" && $state_csv != 1) {
						$alertMsg = "Please Check CSV Format!";
						$alertClass = "alert alert-danger";
					} else {
						if ($state_csv) {
							if ($EmptylineDataCount > 0) {
								$alertMsg = "Successfully Imported " . $successCount . " record/s & Mandatory field/s are empty in " . $EmptylineDataCount . " record/s.";
								$alertClass = "alert alert-success";
							} else {
								$alertMsg = $successCount . " Record/s Successfully Imported.";
								$alertClass = "alert alert-success";
							}
						} else if ($state_csv == false) {
							if ($EmptylineDataCount > 0) {
								$alertMsg = "Something went wrong! & Mandatory field/s are empty in " . $EmptylineDataCount . " record/s.";
								$alertClass = "alert alert-danger";
							} else {
								$alertMsg = "Something went wrong!";
								$alertClass = "alert alert-danger"; ?>
						<?php }
						}
					}
					if (count($DuplicatelineData) > 0) {
						echo "<script type='text/javascript'>
								$(document).ready(function(){ $('#duplicateRecordModal').modal('show'); });</script>"; ?>
						<!-- Duplicate Record Modal -->
						<div class="modal fade" data-backdrop="static" data-keyboard="false" id="duplicateRecordModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
							<div class="modal-dialog modal-dialog-centered" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title" id="exampleModalLongTitle">Duplicate Values</h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<div class="modal-body">
										<form method='post' action='Download_duplicate_Client'>
											Download Duplicate Data
											<?php
											$_SESSION['array_value'] = $DuplicatelineData;
											?>
											<button type='submit' name='Download_duplicate_Client' class='btn btn-primary btn-sm'><i class='fas fa-download'></i> Download</button>
										</form>
										<!--div class="table-responsive">
				<table class="table">
					<thead>
						<th>Id</th>
						<th>Recipient Name</th>
						<th>Company Name</th>
						<th>Contact Person</th>
						<th>Mobile Number</th>
						<th>Pan Number</th>
						<th>Landline</th>
						<th>Email ID - 1</th>
						<th>Email ID - 2</th>
						<th>Address</th>
						<th>State</th>
						<th>City</th>
						<th>Pioncode</th>
						<th>Bank Account No.</th>
						<th>IFSC Code</th>
						<th>Bank Name</th>
						<th>Branch Code</th>
						<th>DSC Applicant</th>
						<th>DSC Partner</th>
						<th>PAN</th>
						<th>TAN</th>
						<th>IT Returns</th>
						<th>e-TDS</th>
						<th>GST</th>
						<th>Other Services</th>
						<th>PSP</th>
						<th>PSP Coupon Consumption</th>
						<th>Audit</th>
						<th>Other Description</th>
					</thead>
					<tbody>
					<?php
						//foreach($DuplicatelineData as $duplicate){
						//	echo $duplicate;
						//}
					?>
					</tbody>
				</table>
				</div-->
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						</div>
					</div>
				</div>
				</div>
				<?php }
				} else {
					//die("Sorry, mime type not allowed");
					$alertMsg = "Please select CSV file only!";
					$alertClass = "alert alert-danger";
				}
			}
			?>
			
			<div class="modal fade clientApproval_modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                  
                  <div class="modal-body">
                      <div class="tab">
                          <button class="tablinks" onclick="openCity(event, 'client_approval')">Client Approval</button>
                          <button class="tablinks" onclick="openCity(event, 'partner_approval')">Associate Approval</button>
                        </div>

                        <div id="client_approval" class="tabcontent">
                          <!--<h3>Client</h3>-->
                          <form method="post" action="html/allCallData_Export.php"><button name="export_clientApprovals" class="btn btn-success">Client Approvals Export</button></form>
                          <table class="table table-striped" id="ClientApproval_table">
                          <thead>
                            <tr>
                              <th scope="col">No</th>
                              <th scope="col">Title ID</th>
                              <th scope="col">Company</th>
                              <th scope="col">Contact Person</th>
                              <th scope="col">Mobile</th>
                              <th scope="col">State</th>
                              <th scope="col">Approve</th>
                              <th scope="col">Reject</th>
                            </tr>
                          </thead>
                          <tbody class="approveTbody">
                              <?php
                                $no = 1;
                                $client_query = "SELECT * FROM `addClient_approval_Status` WHERE client_approval = 0";
                                $Cresult = mysqli_query($con,$client_query);
                                while($Cshow = mysqli_fetch_array($Cresult)) {
                              ?>
                            <tr id="approvetr">
                              <th scope="row"><?= $no; ?></th>
                              <td><?= $Cshow['title_id']; ?></td>
                              <td><?= $Cshow['comp_name']; ?></td>
                              <td><?= $Cshow['cont_person']; ?></td>
                              <td><?= $Cshow['mob1']; ?></td>
                              <td><?= $Cshow['state']; ?></td>
                              <td><input type="hidden" id="clientApproval_id" value="<?= $Cshow['id']; ?>"><button type="button" class="btn btn-success" id="clientApproval_Appbtn">Approve</button></td>
                              <td><input type="hidden" id="clientApproval_rejid" value="<?= $Cshow['id']; ?>"><button type="button" data-toggle="modal" data-target="#rejectModal" class="btn btn-danger" id="clientApproval_Rejbtn">Reject</button></td>
                            </tr>
                            <?php $no++; } ?>
                          </tbody>
                        </table>
                        </div>
                        
                        <div id="partner_approval" class="tabcontent">
                          <!--<h3>Tokyo</h3>-->
                          <form method="post" action="html/allCallData_Export.php"><button name="export_partnerApprovals" class="btn btn-success">Partner Approvals Export</button></form>
                          <table class="table table-striped" id="PartnerApproval_table">
                          <thead>
                            <tr>
                              <th scope="col">No</th>
                              <th scope="col">Title ID</th>
                              <th scope="col">Company</th>
                              <th scope="col">Contact Person</th>
                              <th scope="col">Mobile</th>
                              <th scope="col">State</th>
                              <th scope="col">Approve</th>
                              <th scope="col">Reject</th>
                            </tr>
                          </thead>
                          <tbody class="approveTbody1">
                              <?php
                                $no = 1;
                                $client_query = "SELECT `id`,`part_id` as unique_id,`partner_name` as comp_name,`cont_person`,`mob1`,`state` FROM `calling_partner` where partner_status = 0";
                                $Cresult = mysqli_query($con,$client_query);
                                while($Cshow = mysqli_fetch_array($Cresult)) {
                              ?>
                            <tr id="approvetr1">
                              <th scope="row"><?= $no; ?></th>
                              <td><?= $Cshow['unique_id']; ?></td>
                              <td><?= $Cshow['comp_name']; ?></td>
                              <td><?= $Cshow['cont_person']; ?></td>
                              <td><?= $Cshow['mob1']; ?></td>
                              <td><?= $Cshow['state']; ?></td>
                              <td><input type="hidden" id="partnerApproval_id" value="<?= $Cshow['id']; ?>"><button type="button" class="btn btn-success" id="partnerApproval_Appbtn">Approve</button></td>
                              <td><input type="hidden" id="partnerApproval_rejid" value="<?= $Cshow['id']; ?>"><button type="button" data-toggle="modal" data-target="#rejectPartnerModal" class="btn btn-danger" id="partnerApproval_Rejbtn">Reject</button></td>
                            </tr>
                            <?php $no++; } ?>
                          </tbody>
                        </table>
                        </div>
                  </div>
                  <div class="modal-footer">
                    <!--<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>-->
                    <!--<button type="button" class="btn btn-primary">Save changes</button>-->
                  </div>
                </div>
              </div>
            </div>
            
            <!-- Modal -->
            <div class="modal fade" id="rejectModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Reject Client Approval</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    Are you sure to reject client approval?
                  </div>
                  <div class="modal-footer">
                      <form method="post">
                      <input type="hidden" name="fetchRejectID" id="fetchRejectID">
                    <!--<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>-->
                    <button type="submit" name="rejectClient" class="btn btn-primary">Reject Approval</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
            
            <!-- Modal -->
            <div class="modal fade" id="rejectPartnerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Reject Associate Approval</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    Are you sure to reject partner approval?
                  </div>
                  <div class="modal-footer">
                      <form method="post">
                      <input type="hidden" name="fetchpartnerRejectID" id="fetchpartnerRejectID">
                    <!--<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>-->
                    <button type="submit" name="rejectPartner" class="btn btn-primary">Reject Approval</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
        
			<div class="col-lg-12 col-sm-12">
				<?php if (isset($_POST['client_save']) || isset($_POST['client_update']) || isset($_POST['client_delete']) || isset($_POST['bulk_delete']) || isset($_POST['client_master_csv']) || isset($_POST['client_save_duplicate']) || isset($_POST['client_update_duplicate'])) { ?>
					<div class="<?php echo $alertClass; ?> alert-dismissible" role="alert">
						<?php
						echo $alertMsg; //echo $ErroneouslineDataCount;
						if (isset($ErroneouslineDataCount)) {
							if ($ErroneouslineDataCount > 0) { ?>
								<form method='post' action='Download_erroneous_Client'>
									Download Erroneous Data
									<?php
									$_SESSION['erroneous_array_value'] = $ErroneousData;
									?>
									<button type='submit' name='Download_erroneous_Client' class='btn btn-primary btn-sm'><i class='fas fa-download'></i> Download</button>
								</form>
						<?php }
						}
						?>
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
				<?php } ?>
			</div>
			<form method="post" class="form-inline p-2 d-none" id="import_client" enctype="multipart/form-data">
				<input type="file" class="form-control" name="client_file">
				<input type="submit" class="btn btn-vowel ml-2" name="client_master_csv" value="Import">&nbsp;
				<a href="html/csv_client_master.csv" target="_blank" download="csv_Recipient Master.csv">Click here to download CSV format</a>
				<p style="color: red;" class="form-horizontal">Mandatory fields : <span style="color: #000;">Recipient Name, Company Name, Contact Person, Mobile Number, E-Mail ID - 1</span></p>
				<p style="color: red;" class="form-horizontal">Unique fields : <span style="color: #000; margin-top: 15px;"> Mobile Number, Pan Number, GST Number</span></p>
				<!--https://vivaanintellects.com/vowel-->
			</form>
			<form method="post" class="col-lg-12 col-sm-12 d-none" id="addNew_client">
                        <div class="accordion" id="accordionExample">
                            <div class="card">
								<div class="row">
							<div class="col-md-6">
                                <div class="card-header" id="headingOne">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link btn-block text-left" type="button"
                                            data-toggle="collapse" data-target="#collapseOne" aria-expanded="true"
                                            aria-controls="collapseOne">
                                            Primary Details
                                        </button>
                                    </h2>
                                </div>
								<input type="hidden" name="crm_client" id="crm_client" class="crm_client">
								<input type="hidden" name="client_masterEditID_temp" id="client_masterEditID_temp" value="<?php if (isset($_POST['editClient_Masterbtn'])) echo $_POST['client_masterEditID']; ?>">
								<div id="collapseOne" class="collapse show" aria-labelledby="headingOne"
                                    data-parent="#accordionExample">
                                    <div class="card-body">
                                        <div class=" row">
                                            <div class="form-group d-block col-md-6">
												<label for="exampleInput1" class="float-left p-2">Recipient Name <span style="color: red;" class="pl-1">*</span></label>
												<input type="text" name="client_name" pattern = "[a-zA-Z\& ]+" class="form-control w-100 client_name" id="exampleInput1" aria-describedby="emailHelp" required value="<?php if (isset($_POST['editClient_Masterbtn'])) {
																																														echo $edit_client_name;
																																													} ?>" <?php if (isset($_POST['editClient_Masterbtn'])) {
																																																echo 'readonly';
																																															} ?>>
											</div>
											<div class="form-group d-block col-md-6">
												<label for="exampleInput1" class="float-left p-2">Company Name <span style="color: red;" class="pl-1">*</span></label>
												<input type="text" name="company_name" pattern="^[a-zA-Z0-9\/\\\-=_@.&,#?+ ]+$" class="form-control w-100 company_name" id="exampleInput1" aria-describedby="emailHelp" required value="<?php if (isset($_POST['editClient_Masterbtn'])) {
																																														echo $edit_company_name;
																																													} ?>">
											</div>
											<div class="form-group d-block col-md-6">
												<label for="exampleInput2" class="float-left p-2">Contact Person <span style="color: red;" class="pl-1">*</span></label>
												<div class="d-block">
													<input type="text" pattern = "[a-zA-Z ]+" required name="contact_person" class="form-control w-100 contact_person" id="exampleInput2" aria-describedby="emailHelp" value="<?php if (isset($_POST['editClient_Masterbtn'])) {
																																															echo $edit_contact_person;
																																														} ?>">
												</div>
											</div>
											<div class="form-group d-block col-md-6">
												<label for="exampleInput3" class="float-left p-2">Mobile Number <span style="color: red;" class="pl-1">*</span></label>
												<input type="number" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="10" class="form-control w-100 mobile_number" name="mobile_number" required id="mobile_number" aria-describedby="emailHelp" <?php if (isset($_POST['editClient_Masterbtn'])) {echo "value=" . $edit_mobile_number;} ?>>
												<span id="mobile_number_status"></span>
											</div>
											<div class="form-group d-block col-md-6">
												<label for="exampleInput2" class="float-left p-2">E-Mail ID - 1 <span style="color: red;" class="pl-1">*</span></label>
												<div class="d-block">
													<input type="email" required name="email_id_1" pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$" class="form-control w-100 email_id_1" id="email_id_1" aria-describedby="emailHelp" <?php if (isset($_POST['editClient_Masterbtn'])) { echo "value=" . $edit_email_id_1; } ?>>
													<span id="email_id_1_status"></span>
												</div>
											</div>
											<div class="form-group d-block col-md-6">
												<label for="exampleInput2" class="float-left p-2">Password </label>
												<div class="input-group mb-3 w-100" id="show_hide_password">
													<input type="password" name="password" id="password" class="form-control" placeholder="Enter Password" value="<?php if (isset($_POST['editClient_Masterbtn'])) {
																																										echo $edit_password;
																																									} ?>">
													<div class="input-group-append">
														<span class="input-group-text"><a href="" id="add_acc_passLink"><i class="fa fa-eye-slash" aria-hidden="true"></i></a></span>
													</div>
												</div>
												<!-- <input type="hidden" readonly name="temp_password" value="<?php if (isset($_POST['editClient_Masterbtn'])) { echo $edit_password; } ?>"> -->
											</div>
										</div>
									</div>
								</div>
							</div>

							<div class="col-md-6">
								<div class="card-header" id="headingFour">
                                    <h2 class="mb-0">
									<button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseFour" aria-expanded="true" aria-controls="collapseFour">
										Permissions
									</button>
                                    </h2>
                                </div>

                                <div id="collapseFour" class="collapse show" aria-labelledby="headingFour" data-parent="#accordionExample">
                                    <div class="card-body">
										<div class="row">
											<div class="form-group d-block col-md-6">
												<label for="taxation_allows" class="float-left p-2">Taxation</label>
												<div class="d-block">
													<select name="taxation_allows[]" multiple class="form-control taxation_allows w-100 h-100" id="taxation_allows">
														<option value="GST" <?php if (isset($_POST['editClient_Masterbtn'])) {
																				if ($gst == 1) echo 'selected';
																			} ?>>GST</option>
														<option value="IT Returns" <?php if (isset($_POST['editClient_Masterbtn'])) {
																						if ($it_returns == 1) echo 'selected';
																					} ?>>IT Returns</option>
														<option value="Audit" <?php if (isset($_POST['editClient_Masterbtn'])) {
																					if ($audit == 1) echo 'selected';
																				} ?>>Audit</option>
													</select>
												</div>
											</div>	
											<div class="form-group d-block col-md-6">
												<label for="nsdl_allows" class="float-left p-2">NSDL</label>
												<div class="d-block">
													<select name="nsdl_allows[]" multiple class="form-control nsdl_allows w-100 h-100" id="nsdl_allows">
														<option value="PAN" <?php if (isset($_POST['editClient_Masterbtn'])) {
																				if ($pan == 1) echo 'selected';
																			} ?>>PAN</option>
														<option value="TAN" <?php if (isset($_POST['editClient_Masterbtn'])) {
																				if ($tan == 1) echo 'selected';
																			} ?>>TAN</option>
														<option value="e-TDS" <?php if (isset($_POST['editClient_Masterbtn'])) {
																					if ($e_tds == 1) echo 'selected';
																				} ?>>e-TDS</option>
														<option value="24G" <?php if (isset($_POST['editClient_Masterbtn'])) {
																				if ($twenty4g == 1) echo 'selected';
																			} ?>>24G</option>
													</select>
												</div>
											</div>
											<div class="form-group d-block col-md-6">
												<label for="dsc_allows" class="float-left p-2">DSC</label>
												<div class="d-block">
													<select name="dsc_allows[]" multiple class="form-control dsc_allows w-100 h-100" id="dsc_allows">
														<option value="DSC Applicant" <?php if (isset($_POST['editClient_Masterbtn'])) {
																							if ($dsc_subscriber == 1) {
																								echo 'selected';
																							}
																						} ?>>DSC Applicant</option>
														<option value="DSC Partner" <?php if (isset($_POST['editClient_Masterbtn'])) {
																						if ($dsc_reseller == 1) echo 'selected';
																					} ?>>DSC Partner</option>
													</select>
												</div>
											</div>
											<div class="form-group d-block col-md-6">
												<label for="otherServices_allows" class="float-left p-2">Other Services</label>
												<div class="d-block">
													<select name="otherServices_allows[]" multiple class="form-control otherServices_allows w-100 h-100" id="otherServices_allows">
														<option value="Other Services" <?php if (isset($_POST['editClient_Masterbtn'])) { if ($other_services == 1) echo 'selected'; } ?>>Other Service</option>
														<option value="Trading" <?php if (isset($_POST['editClient_Masterbtn'])) { if ($trading == 1) echo 'selected'; } ?>>Trading</option>
														<option value="E-Tender" <?php if (isset($_POST['editClient_Masterbtn'])) { if ($e_tender == 1) echo 'selected'; } ?>>E-Tender</option>
														<option value="Mobile Repairing" <?php if (isset($_POST['editClient_Masterbtn'])) { if ($mobile_repairing == 1) echo 'selected'; } ?>>Mobile Repairing</option>
														<option value="Advocate" <?php if (isset($_POST['editClient_Masterbtn'])) { if ($advocate == 1) echo 'selected'; } ?>>Advocate</option>
													</select>
												</div>
											</div>
											<div class="form-group d-block col-md-6">
												<label for="uti_allows" class="float-left p-2">UTI</label>
												<div class="d-block">
													<select name="uti_allows[]" multiple class="form-control uti_allows w-100 h-100" id="uti_allows">
														<option value="PSP" <?php if (isset($_POST['editClient_Masterbtn'])) {
																				if ($psp == 1) echo 'selected';
																			} ?>>PSP</option>
													</select>
												</div>
											</div>
											<div class="form-group d-block col-md-6">
												<label for="ip_allows" class="float-left p-2">Intellectual Property</label>
												<div class="d-block">
													<select name="ip_allows[]" multiple class="form-control ip_allows w-100 h-100" id="ip_allows">
														<option value="trade_mark" <?php if (isset($_POST['editClient_Masterbtn'])) {
																				if ($trade_mark == 1) echo 'selected';
																			} ?>>Trade Mark</option>
														<option value="patent" <?php if (isset($_POST['editClient_Masterbtn'])) {
																				if ($patent == 1) echo 'selected';
																			} ?>>Patent</option>
														<option value="trade_secret" <?php if (isset($_POST['editClient_Masterbtn'])) {
																				if ($trade_secret == 1) echo 'selected';
																			} ?>>Trade Secret</option>
														<option value="copy_right" <?php if (isset($_POST['editClient_Masterbtn'])) {
																				if ($copy_right == 1) echo 'selected';
																			} ?>>Copy Right</option>
														<option value="industrial_design" <?php if (isset($_POST['editClient_Masterbtn'])) {
																				if ($industrial_design == 1) echo 'selected';
																			} ?>>Industrial Design</option>
													</select>
												</div>
											</div>
											<div class="form-group d-none col-md-6" id="dsc_companyDIV">
												<label for="ClientNameSelect1" class="float-left p-2">DSC Company <span style="color: red;" class="pl-1">*</span></label>
												<div class="d-block">
													<?php
													$Capricorn = false;
													$Siffy = false;
													$Emudra = false;
													$Vsign = false;
													$IDsign = false;
													$Pantasign = false;
													$Xtra_Trust = false;
													if (isset($_POST['editClient_Masterbtn'])) {
														foreach ($edit_dsc_company as $val) {
															if ($val == "Capricorn") {
																$Capricorn = true;
															}
															if ($val == "Siffy") {
																$Siffy = true;
															}
															if ($val == "Emudra") {
																$Emudra = true;
															}
															if ($val == "Vsign") {
																$Vsign = true;
															}
															if ($val == "IDsign") {
																$IDsign = true;
															}
															if ($val == "Pantasign") {
																$Pantasign = true;
															}
															if ($val == "Xtra Trust") {
																$Xtra_Trust = true;
															}
														}
													} ?>
													<select name="dsc_company[]" multiple class="form-control dsc_company w-100" id="dsc_company">
														<?php 
															$fetch_Client = "SELECT `dsc_company_name` FROM `dsc_company` WHERE `company_id` = '".$_SESSION['company_id']."' ORDER BY `dsc_company_name` ASC";
															$run_fetch_Client = mysqli_query($con,$fetch_Client);
															while ($row = mysqli_fetch_array($run_fetch_Client)) { ?>
																<option value="<?= $row['dsc_company_name']; ?>" <?php if (isset($_POST['editClient_Masterbtn'])) { if (in_array($row['dsc_company_name'], $edit_dsc_company)) { echo "selected"; }}?>><?= $row['dsc_company_name']; ?></option>
													<?php } ?>
													</select>
												</div>
											</div>
											<div class="form-group d-block col-md-6">
													<label for="ClientNameSelect1" class="float-left p-2">Users Access</label>
													<br>
													<div class="col d-flex justify-content-left float-left">
														<div class="custom-control custom-checkbox pl-2">
															<input type="checkbox" class="custom-control-input" id="select_allUsers" name="select_allUsers">
															<label class="custom-control-label pl-3" for="select_allUsers">Select All</label>
														</div>
													</div>
													<select name="users_access[]" id="users_access" multiple class="form-control w-100 h-100 multiple_select">
														<?php
														$fetch_users = "SELECT * FROM `users` WHERE `company_id` = '" . $_SESSION['company_id'] . "' ORDER BY `username`";
														$run_users = mysqli_query($con, $fetch_users);
														while ($row = mysqli_fetch_array($run_users)) {
															if ($row['admin_status'] == "1") continue; ?>
																<option value="<?= $row['id']; ?>" <?php if (isset($_POST['editClient_Masterbtn'])) {
																		foreach ($edit_users_access as $i) if ($i == $row['id']) {
																			echo 'selected';
																		}
																	} else {
																		echo 'selected';
																	} ?>><?= $row['username'] . ' (' . $row['firstname'] . ')'; ?></option>
														<?php } ?>
													</select>
											</div>	
										</div>
									</div> 
								</div>
							</div>
							</div>
								<d class="card">
                                <div class="card-header" id="headingTwo">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link btn-block text-left collapsed" type="button"
                                            data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false"
                                            aria-controls="collapseTwo">
                                            Secondary details
                                        </button>
                                    </h2>
                                </div>
                                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo"
                                    data-parent="#accordionExample">
                                    <div class="card-body">
                                        <div class="row">
											<div class="form-group d-block col-md-3">
												<label for="exampleInput3" class="float-left p-2">Pan Number </label>
												<input type="text" maxlength="10" pattern="[a-zA-Z]{5}[0-9]{4}[a-zA-Z]{1}" class="form-control w-100" name="pan_no" id="pan_no" aria-describedby="emailHelp" <?php if (isset($_POST['editClient_Masterbtn'])) {echo "value=" . $edit_pan_number;} ?>>
											</div>
											<div class="form-group d-block col-md-3">
												<label for="exampleInput1" class="float-left p-2">Landline number</label>
												<input type="text" name="landline_number" class="form-control w-100 landline_number" id="exampleInput1" aria-describedby="emailHelp" value="<?php if (isset($_POST['editClient_Masterbtn'])) {echo $edit_landline_number;} ?>">
											</div>
											
											<div class="form-group d-block col-md-3">
												<label for="exampleInput2" class="float-left p-2">E-Mail ID - 2</label>
												<div class="d-block">
													<input type="email" name="email_id_2" pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$" class="form-control w-100 email_id_2" id="exampleInput2" aria-describedby="emailHelp" <?php if (isset($_POST['editClient_Masterbtn'])) {
																																											echo "value=" . $edit_email_id_2;
																																										} ?>>
												</div>
											</div>
											<div class="form-group d-block col-md-3">
												<label for="exampleInput3" class="float-left p-2">Address</label>
												<input type="text" pattern="^[a-zA-Z0-9\/\\\-=_@.&,#?+ ]+$" class="form-control w-100" name="address" id="exampleInput3" aria-describedby="emailHelp" value="<?php if (isset($_POST['editClient_Masterbtn'])) {
																																										echo $edit_address;
																																									} ?>">
											</div>
											<div class="form-group d-block col-md-3">
												<label for="exampleInput1" class="float-left p-2">State</label>
												<input type="text" class="form-control w-100 state" name="state" id="exampleInput1" value="<?php if (isset($_POST['editClient_Masterbtn'])) {
																																										echo $edit_state;
																																									} ?>">
												
											</div>
											<div class="form-group d-block col-md-3">
												<label for="exampleInput2" class="float-left p-2">City</label>
												<div class="d-block">
													<input type="text" pattern = "[a-zA-Z ]+" name="city" class="form-control w-100 city" id="exampleInput2" aria-describedby="emailHelp" value="<?php if (isset($_POST['editClient_Masterbtn'])) {
																																											echo $edit_city;
																																										} ?>">
												</div>
											</div>
											<div class="form-group d-block col-md-3">
												<label for="exampleInput2" class="float-left p-2">Pincode</label>
												<div class="d-block">
													<input type="number" name="pincode" class="form-control w-100 pincode" id="exampleInput2" aria-describedby="emailHelp" <?php if (isset($_POST['editClient_Masterbtn'])) {
																																										echo "value=" . $edit_pincode;
																																									} ?>>
												</div>
											</div>

										</div>
									</div>
								</div>
								<div class="card">
                                <div class="card-header" id="headingThree">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link btn-block text-left collapsed" type="button"
                                            data-toggle="collapse" data-target="#collapseThree" aria-expanded="false"
                                            aria-controls="collapseThree">
                                            Bank Details
                                        </button>
                                    </h2>
                                </div>
                                <div id="collapseThree" class="collapse" aria-labelledby="headingThree"
                                    data-parent="#accordionExample">
                                    <div class="card-body">
                                        <div class=" row">
											<div class="form-group d-block col-md-3">
												<label for="exampleInput3" class="float-left p-2">Bank Account Number</label>
												<input type="number" class="form-control w-100" name="bank_account_no" id="exampleInput3" aria-describedby="emailHelp" <?php if (isset($_POST['editClient_Masterbtn'])) {
																																											echo "value=" . $edit_bank_account_no;
																																										} ?>>
											</div>
											<div class="form-group d-block col-md-3">
												<label for="exampleInput1" class="float-left p-2">IFSC Code</label>
												<input type="text" pattern = "[a-zA-Z0-9 ]+" name="ifsc_code" class="form-control w-100" id="exampleInput1" aria-describedby="emailHelp" value="<?php if (isset($_POST['editClient_Masterbtn'])) {
																																											echo $edit_ifsc_code;
																																										} ?>">
											</div>
											<div class="form-group d-block col-md-3">
												<label for="exampleInput2" class="float-left p-2">Bank Name</label>
												<div class="d-block">
													<input type="text" pattern = "[a-zA-Z ]+" name="bank_name" class="form-control w-100" id="exampleInput2" aria-describedby="emailHelp" value="<?php if (isset($_POST['editClient_Masterbtn'])) {
																																												echo $edit_bank_name;
																																											} ?>">
												</div>
											</div>
											<div class="form-group d-block col-md-3">
												<label for="exampleInput2" class="float-left p-2">Branch Code</label>
												<div class="d-block">
													<input type="text" pattern = "[a-zA-Z0-9 ]+" name="branch_code" class="form-control w-100" id="exampleInput2" aria-describedby="emailHelp" value="<?php if (isset($_POST['editClient_Masterbtn'])) {
																																												echo $edit_branch_code;
																																											} ?>">
												</div>
											</div>
											<div class="form-group col-md-3">
												<label for="gst_no" class="float-left p-2">GST Number <span id="asterisk" style="color: red; display: none;" class="pl-1">*</span></label> 

												<input type="text" pattern = "[a-zA-Z0-9 ]+" name="gst_no" class="form-control w-100" id="gst_no" aria-describedby="emailHelp" value="<?php if (isset($_POST['editClient_Masterbtn'])) {echo $gst_no;} ?>">
											</div>
											<div class="form-group d-block col-md-3">
												<label for="other_description" class="float-left p-2">Other Description</label>
												<input type="text" pattern="^[a-zA-Z0-9\/\\\-=_@#?+ ]+$" name="other_description" class="form-control w-100" id="other_description" aria-describedby="emailHelp" value="<?php if (isset($_POST['editClient_Masterbtn'])) {
																																														echo $other_description;
																																													} ?>">
											</div>
											<div class="form-group d-block col-md-3">
												<label for="previous_balance" class="float-left p-2">Previous Balance</label>
												<input type="number" step=".01" name="previous_balance" class="form-control w-100" id="previous_balance" aria-describedby="emailHelp" value="<?php if (isset($_POST['editClient_Masterbtn'])) {
																																																	echo $edit_previous_balance;
																																																} else {
																																																	echo 0;
																																																} ?>">
											</div>
											<div class="form-group d-block col-md-3">
												<label for="advance_balance" class="float-left p-2">Advance Balance</label>
												<input type="number" step=".01" name="advance_balance" class="form-control w-100" id="advance_balance" aria-describedby="emailHelp" value="<?php if (isset($_POST['editClient_Masterbtn'])) {
																																																echo $edit_advance_balance;
																																															} else {
																																																echo 0;
																																															} ?>" <?php if (isset($_POST['editClient_Masterbtn'])) {
																																																		echo 'disabled';
																																																	} ?>>
											</div>
											<div class="form-group col-md-6 d-none" id="cinDIV">
												<label for="cin" class="float-left p-2">CIN</label>
												<input type="text" pattern = "[a-zA-Z0-9 ]+" name="cin" class="form-control w-100" id="cin" aria-describedby="emailHelp" value="<?php if (isset($_POST['editClient_Masterbtn'])) {
																																							echo $cin;
																																						} ?>">
											</div>
											<div class="form-group d-block col-md-3">
												<label for="fees_received" class="float-left p-2">Fees Received</label>
												<input type="number"  readonly class="form-control w-100" name="fees_received" id="fees_received" aria-describedby="emailHelp" placeholder="Enter Fees Received" value="<?php if (isset($_POST['editClient_Masterbtn'])) {
																																																							echo $edit_fees_received;
																																																						} ?>">
											</div>

										</div>
									</div>
								</div>																																					
								
                                
								</div>
							</div>
						
				<br>
				<div class="form-inline">
					<div class="form-group d-block col-md-3">
						<span style="color: red;" class="pl-1">Note : * fields are mandatory</span>
					</div>
				</div>
				<div class="form-group text-center">
					<?php if (isset($_POST['editClient_Masterbtn'])) {
						if ($_SESSION['admin_status'] == "1") {
							echo '<input type="button" name="client_update_admin" id="client_update_admin" value="UPDATE" class="btn btn-vowel">';
							echo '<input type="submit" name="client_update" id="client_update" value="UPDATE" class="btn btn-vowel d-none">'; ?>
							<input type="submit" name="client_update_duplicate" id="client_update_duplicate" value="UPDATE" class="btn btn-vowel d-none">
						<?php } else {
							echo '<input type="button" name="temp_client_update" id="temp_client_update" value="UPDATE" class="btn btn-vowel">';
							echo '<input type="submit" name="client_update" id="client_update" value="UPDATE" class="btn btn-vowel d-none">';
						}
					} else {
						
				// 			echo '<input type="button" name="client_save_admin" id="client_save_admin" value="SAVE" class="btn btn-vowel">';
							echo '<input type="submit" name="client_save" id="client_save" value="SAVE" class="btn btn-vowel">'; ?>
							<!--<input type="submit" name="client_save_duplicate" id="client_save_duplicate" value="SAVE" class="btn btn-vowel d-none">-->
					<?php
				// 			echo '<input type="button" name="temp_client_save" id="temp_client_save" value="SAVE" class="btn btn-vowel">';
				// 			echo '<input type="submit" name="client_save" id="client_save" value="SAVE" class="btn btn-vowel d-none">';
						
					} ?>
				</div>
			</form>
		</div>
	</div>
	<div id="searchClientDiv" class="table-responsive d-block"></div>
	<div id="showClientMaster" class="table-responsive d-block"></div>
	<div id="showWholeDetails" class="table-responsive d-block"></div>

	<!--Delete Confirm Popup-->
	<div class="modal fade" data-backdrop="static" data-keyboard="false" id="client_masterConfirmMessagePopup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<form method="post">
					<div class="modal-header">
						<img src="<?php echo $main_company_logo; ?>" alt="Vowel" style="width: 150px; height: 55px;" class="logo navbar-brand mr-auto">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body bg-light">
						<input type="hidden" id="tempClient_MasterIDdel" name="tempClient_MasterIDdel" class="tempClient_MasterIDdel">
						<!--input type="hidden" id="tempMultipleIDdel" name="tempMultipleIDdel" class="tempMultipleIDdel"-->
						<p>Do You Really Want To Delete This Record(s) ?</p>
					</div>
					<div class="modal-footer">
						<button type="button" id="closeBtn" class="btn btn-secondary" data-dismiss="modal">NO</button>
						<button type="submit" name="client_delete" class="btn btn-vowel d-block">YES</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<input type="hidden" readonly id="tempDSCCompany" name="tempDSCCompany" value="<?php if(isset($edit_DSCStock_company)) echo($edit_DSCStock_company); ?>">
<input type="hidden" readonly id="tempTokenName" name="tempTokenName" value="<?php if(isset($edit_DSCStock_certificate_name)) echo($edit_DSCStock_certificate_name); ?>">
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var gstOption = document.querySelector('option[value="GST"]');
        var gstNumberInput = document.getElementById('gst_no');
        var asteriskSpan = document.getElementById('asterisk');

        gstOption.addEventListener('click', function() {
            gstNumberInput.setAttribute('required', 'required');
            asteriskSpan.style.display = 'inline';
            // alert('You clicked on the GST option.');
        });
    });
</script>


	<script type="text/javascript">
		$(document).ready(function() {
        $('.approveTbody #approvetr').on('click','#clientApproval_Appbtn', function(){
        var row_indexDEL = $(this).closest('#approvetr'); 
        var btnID = row_indexDEL.find('#clientApproval_id').val();
        document.getElementById('pleaseWaitDialog').style.display = 'block';
        $.ajax({
        	url:"html/verifyPinProcess.php",
        	method:"post",
        	data: {approve_client:btnID,},
        	dataType:"text",
        	success:function(data)
        	{
        	   $("#showClientMaster").removeClass("d-block");
        		$("#showClientMaster").addClass("d-none");
        		$("#import_client").removeClass("d-block");
        		$("#import_client").addClass("d-none");
        
        		$("#addNew_client").removeClass("d-none");
        		$("#addNew_client").addClass("d-block");
        		$('#clientApproval_modal_btn').click();
        		var jsonData = JSON.parse(data);
        		var client_details = jsonData.client_from+'_'+jsonData.title_id;
        		$('.crm_client').val(client_details);
        		$('.client_name').val(jsonData.comp_name);
                $('.company_name').val(jsonData.comp_name);
                $('.contact_person').val(jsonData.client_name);
                $('.mobile_number').val(jsonData.mobile_no1);
                $('.landline_number').val(jsonData.mobile_no2);
                $('.email_id_1').val(jsonData.email1);
                $('.email_id_2').val(jsonData.email2);
                $('.state').val(jsonData.state);
                $('.city').val(jsonData.city);
                $('.pincode').val(jsonData.path);
        	},complete: function(){
        		document.getElementById('pleaseWaitDialog').style.display = 'none';
          }
        });
        });
        $('.approveTbody1 #approvetr1').on('click','#partnerApproval_Appbtn', function(){
        var row_indexDEL = $(this).closest('#approvetr1'); 
        var btnID = row_indexDEL.find('#partnerApproval_id').val();
        document.getElementById('pleaseWaitDialog').style.display = 'block';
        $.ajax({
        	url:"html/verifyPinProcess.php",
        	method:"post",
        	data: {approve_partner:btnID,},
        	dataType:"text",
        	success:function(data)
        	{
        	   $("#showClientMaster").removeClass("d-block");
        		$("#showClientMaster").addClass("d-none");
        		$("#import_client").removeClass("d-block");
        		$("#import_client").addClass("d-none");
        
        		$("#addNew_client").removeClass("d-none");
        		$("#addNew_client").addClass("d-block");
        		$('#clientApproval_modal_btn').click();
        		var jsonData = JSON.parse(data);
        		var client_details = jsonData.client_from+'_'+jsonData.title_id;
        		$('.crm_client').val(client_details);
        		$('.client_name').val(jsonData.comp_name);
                $('.company_name').val(jsonData.comp_name);
                $('.contact_person').val(jsonData.client_name);
                $('.mobile_number').val(jsonData.mobile_no1);
                $('.landline_number').val(jsonData.mobile_no2);
                $('.email_id_1').val(jsonData.email1);
                $('.email_id_2').val(jsonData.email2);
                $('.state').val(jsonData.state);
                $('.city').val(jsonData.city);
                $('.pincode').val(jsonData.path);
        	},complete: function(){
        		document.getElementById('pleaseWaitDialog').style.display = 'none';
          }
        });
        });
        $('.approveTbody #approvetr').on('click','#clientApproval_Rejbtn', function(){
        var row_indexDEL = $(this).closest('#approvetr'); 
        var btnID = row_indexDEL.find('#clientApproval_rejid').val();
        $('#fetchRejectID').val(btnID);
        });
        $('.approveTbody1 #approvetr1').on('click','#partnerApproval_Rejbtn', function(){
        var row_indexDEL = $(this).closest('#approvetr1'); 
        var btnID = row_indexDEL.find('#partnerApproval_rejid').val();
        $('#fetchpartnerRejectID').val(btnID);
        });

			let MobileNumberCorrect = false;
			let EmailIdCorrect = false;
			// Check mobile to exist or not
			function CheckMobileNumberExist() {
				let mobile_number = $('#mobile_number').val();
				var client_masterEditID_temp = $("#client_masterEditID_temp").val();
				// alert(client_masterEditID_temp);
				$.ajax({
					url: "html/clientProcess.php",
					method: "post",
					data: {
						mobile_number,
						client_masterEditID_temp
					},
					dataType: "text",
					success: function(data) {
						// alert(data);
						if (data == "mobile_exist") {
							MobileNumberCorrect = false;
							$('#mobile_number').addClass('border-danger');
							$('#mobile_number_status').html('This Mobile Number already exist').css(
								'color', 'red');
						} else {
							MobileNumberCorrect = true;
							$('#mobile_number').removeClass('border-danger');
							$('#mobile_number_status').html('').css('color', 'green');
						}
					}
				});
			}
			// Check email to exist or not
			function CheckEmailIdExist() {
				let email_id_1 = $('#email_id_1').val();
				var client_masterEditID_temp = $("#client_masterEditID_temp").val();
				// alert(client_masterEditID_temp);
				$.ajax({
					url: "html/clientProcess.php",
					method: "post",
					data: {
						email_id_1,
						client_masterEditID_temp
					},
					dataType: "text",
					success: function(data) {
						// alert(data);
						if (data == "email_exist") {
							EmailIdCorrect = false;
							$('#email_id_1').addClass('border-danger');
							$('#email_id_1_status').html('This Email Id already exist').css(
								'color', 'red');
						} else {
							EmailIdCorrect = true;
							$('#email_id_1').removeClass('border-danger');
							$('#email_id_1_status').html('').css('color', 'green');
						}
					}
				});
			}

			$('#mobile_number').blur(function() {
				CheckMobileNumberExist();
			});
			$('#email_id_1').blur(function() {
				CheckEmailIdExist();
			});
			// Save Button Cliking event for user
			$("#temp_client_save").click(function() {
				if ($('#addNew_client')[0].checkValidity()) {
					if (MobileNumberCorrect && EmailIdCorrect) {
						$('#client_save').click();
					}
				} else {
					$('#client_save').click();
					//$('#makePaymentLink').attr('href','#');
					//alert('In-valid');
				}
			});
			$("#temp_client_update").click(function() {
				if ($('#addNew_client')[0].checkValidity()) {
					if (MobileNumberCorrect && EmailIdCorrect) {
						$('#client_update').click();
					}
				} else {
					$('#client_update').click();
					//$('#makePaymentLink').attr('href','#');
					//alert('In-valid');
				}
			});
			// Save Button Cliking event for admin
			$("#client_save_admin").click(function() {
				if ($('#addNew_client')[0].checkValidity()) {
					if (MobileNumberCorrect) {
						var mobile_no = $("#mobile_number").val();
						var email_1 = $("#email_id_1").val();
						var pan_no = $("#pan_no").val();
						$.ajax({
							url: "html/clientProcess.php",
							method: "post",
							data: {
								mobile_no: mobile_no,
								email_1: email_1
							},
							dataType: "text",
							success: function(data) {
								//alert(data);
								var array = JSON.parse(data);
								if (array[0] == "not duplicate") {
									//$("#duplicateAllowPopup").show();
									$("#client_save").click();
								} else if (array[0] == "duplicate") {
									$("#duplicateAllowPopup").modal("show");
									$("#DuplicationMsg").html("Duplication found in " + jQuery.parseJSON(array[1]) + " Do you want to continue?");
									$("#yesAllowDuplicate_save").removeClass("d-none");
									$("#yesAllowDuplicate_save").addClass("d-block");
									$("#yesAllowDuplicate_update").removeClass("d-block");
									$("#yesAllowDuplicate_update").addClass("d-none");
								}
							}
						});
					}
				} else {
					$('#client_save').click();
					//$('#makePaymentLink').attr('href','#');
					//alert('In-valid');
				}
			});
			// Update Button Cliking event for admin
			$("#client_update_admin").click(function() {
				if ($('#addNew_client')[0].checkValidity()) {
					// alert(MobileNumberCorrect);
					if (MobileNumberCorrect) {
						var mobile_no = $("#mobile_number").val();
						var email_1 = $("#email_id_1").val();
						var pan_no = $("#pan_no").val();
						var client_masterEditID_temp = $("#client_masterEditID_temp").val();
						$.ajax({
							url: "html/clientProcess.php",
							method: "post",
							data: {
								mobile_no: mobile_no,
								email_1: email_1,
								client_masterEditID_temp: client_masterEditID_temp
							},
							dataType: "text",
							success: function(data) {
								//alert(data[0]);
								var array = JSON.parse(data);
								if (array[0] == "not duplicate") {
									//$("#duplicateAllowPopup").show();
									$("#client_update").click();
								} else if (array[0] == "duplicate") {
									//alert(jQuery.parseJSON(array[1]));
									$("#duplicateAllowPopup").modal("show");
									$("#duplicateAllowPopup #DuplicationMsg").html("Duplication found in " + jQuery.parseJSON(array[1]) + " Do you want to continue?");
									$("#yesAllowDuplicate_save").removeClass("d-block");
									$("#yesAllowDuplicate_save").addClass("d-none");
									$("#yesAllowDuplicate_update").removeClass("d-none");
									$("#yesAllowDuplicate_update").addClass("d-block");
								}
							}
						});
					}
				} else {
					$('#client_update').click();
					//$('#makePaymentLink').attr('href','#');
					//alert('In-valid');
				}
			});
			$("#yesAllowDuplicate_save").click(function() {
				$("#client_save_duplicate").click();
			});
			$("#yesAllowDuplicate_update").click(function() {
				$("#client_update_duplicate").click();
			});
			//Multiple Select Checkboxes
			$(".dsc_company").mousedown(function(e) {
				if (e.target.tagName == "OPTION") {
					return; //don't close dropdown if i select option
				}
				$(this).toggleClass('dsc_company_active'); //close dropdown if click inside <select> box
			});
			$(".dsc_company").on('blur', function(e) {
				$(this).removeClass('dsc_company_active'); //close dropdown if click outside <select>
			});

			var selectTop;
			var mustChangeScrollTop = false;

			$('.dsc_company').on('scroll', function(e) {
				if (mustChangeScrollTop) {
					$(this).scrollTop(selectTop);
					mustChangeScrollTop = false;
				}
				return true;
			});
			$('.dsc_company option').mousedown(function(e) { //no ctrl to select multiple
				e.preventDefault();
				selectTop = $(this).parent().scrollTop();
				//alert($('.dsc_company').val().length);
				$(this).prop('selected', $(this).prop('selected') ? false : true); //set selected options on click
				if ($('.dsc_company').val().length == 0) {
					//$('.dsc_company').val("Cash");
					$(this).prop('selected', true);
				}
				$(this).parent().change(); //trigger change event
				mustChangeScrollTop = true;
				return false;
			});
			//Taxation Multiple Select Checkboxes
			$(".taxation_allows").mousedown(function(e) {
				if (e.target.tagName == "OPTION") {
					return; //don't close dropdown if i select option
				}
				$(this).toggleClass('taxation_allows_active'); //close dropdown if click inside <select> box
			});
			$(".taxation_allows").on('blur', function(e) {
				$(this).removeClass('taxation_allows_active'); //close dropdown if click outside <select>
			});

			var selectTop;
			var mustChangeScrollTop = false;

			$('.taxation_allows').on('scroll', function(e) {
				if (mustChangeScrollTop) {
					$(this).scrollTop(selectTop);
					mustChangeScrollTop = false;
				}
				return true;
			});
			$('.taxation_allows option').mousedown(function(e) { //no ctrl to select multiple
				e.preventDefault();
				selectTop = $(this).parent().scrollTop();
				//alert($('.taxation_allows').val().length);
				$(this).prop('selected', $(this).prop('selected') ? false : true); //set selected options on click
				/*if ($('.taxation_allows').val().length == 0) {
					//$('.taxation_allows').val("Cash");
					$(this).prop('selected', true);
				}*/
				var select_button_text = $('#taxation_allows option:selected')
					.toArray().map(item => item.value);
				//alert(jQuery.inArray("Audit", select_button_text));
				if (jQuery.inArray("Audit", select_button_text) !== -1) {
					$("#cinDIV").removeClass("d-none");
					$("#cinDIV").addClass("d-block");
					$("#cin").prop('required', true);
				} else if (jQuery.inArray("Audit", select_button_text) === -1) {
					$("#cinDIV").removeClass("d-block");
					$("#cinDIV").addClass("d-none");
					$("#cin").prop('required', false);
				}
				$(this).parent().change(); //trigger change event
				mustChangeScrollTop = true;
				return false;
			});

			//NSDL Multiple Select Checkboxes
			$(".nsdl_allows").mousedown(function(e) {
				if (e.target.tagName == "OPTION") {
					return; //don't close dropdown if i select option
				}
				$(this).toggleClass('nsdl_allows_active'); //close dropdown if click inside <select> box
			});
			$(".nsdl_allows").on('blur', function(e) {
				$(this).removeClass('nsdl_allows_active'); //close dropdown if click outside <select>
			});

			var selectTop;
			var mustChangeScrollTop = false;

			$('.nsdl_allows').on('scroll', function(e) {
				if (mustChangeScrollTop) {
					$(this).scrollTop(selectTop);
					mustChangeScrollTop = false;
				}
				return true;
			});
			$('.nsdl_allows option').mousedown(function(e) { //no ctrl to select multiple
				e.preventDefault();
				selectTop = $(this).parent().scrollTop();
				//alert($('.nsdl_allows').val().length);
				$(this).prop('selected', $(this).prop('selected') ? false : true); //set selected options on click
				/*if ($('.nsdl_allows').val().length == 0) {
					//$('.nsdl_allows').val("Cash");
					$(this).prop('selected', true);
				}*/
				$(this).parent().change(); //trigger change event
				mustChangeScrollTop = true;
				return false;
			});

			//DSC Multiple Select Checkboxes
			$(".dsc_allows").mousedown(function(e) {
				if (e.target.tagName == "OPTION") {
					return; //don't close dropdown if i select option
				}
				$(this).toggleClass('dsc_allows_active'); //close dropdown if click inside <select> box
			});
			$(".dsc_allows").on('blur', function(e) {
				$(this).removeClass('dsc_allows_active'); //close dropdown if click outside <select>
			});

			var selectTop;
			var mustChangeScrollTop = false;

			$('.dsc_allows').on('scroll', function(e) {
				if (mustChangeScrollTop) {
					$(this).scrollTop(selectTop);
					mustChangeScrollTop = false;
				}
				return true;
			});
			$('.dsc_allows option').mousedown(function(e) { //no ctrl to select multiple
				e.preventDefault();
				selectTop = $(this).parent().scrollTop();
				//alert($('.dsc_allows').val().length);
				$(this).prop('selected', $(this).prop('selected') ? false : true); //set selected options on click
				/*if ($('.dsc_allows').val().length == 0) {
					//$('.dsc_allows').val("Cash");
					$(this).prop('selected', true);
				}*/
				$(this).parent().change(); //trigger change event
				mustChangeScrollTop = true;
				return false;
			});

			//Other Services Multiple Select Checkboxes
			$(".otherServices_allows").mousedown(function(e) {
				if (e.target.tagName == "OPTION") {
					return; //don't close dropdown if i select option
				}
				$(this).toggleClass('otherServices_allows_active'); //close dropdown if click inside <select> box
			});
			$(".otherServices_allows").on('blur', function(e) {
				$(this).removeClass('otherServices_allows_active'); //close dropdown if click outside <select>
			});

			var selectTop;
			var mustChangeScrollTop = false;

			$('.otherServices_allows').on('scroll', function(e) {
				if (mustChangeScrollTop) {
					$(this).scrollTop(selectTop);
					mustChangeScrollTop = false;
				}
				return true;
			});
			$('.otherServices_allows option').mousedown(function(e) { //no ctrl to select multiple
				e.preventDefault();
				selectTop = $(this).parent().scrollTop();
				//alert($('.otherServices_allows').val().length);
				$(this).prop('selected', $(this).prop('selected') ? false : true); //set selected options on click
				/*if ($('.otherServices_allows').val().length == 0) {
					//$('.otherServices_allows').val("Cash");
					$(this).prop('selected', true);
				}*/
				$(this).parent().change(); //trigger change event
				mustChangeScrollTop = true;
				return false;
			});

			//UTI Multiple Select Checkboxes
			$(".uti_allows").mousedown(function(e) {
				if (e.target.tagName == "OPTION") {
					return; //don't close dropdown if i select option
				}
				$(this).toggleClass('uti_allows_active'); //close dropdown if click inside <select> box
			});
			$(".uti_allows").on('blur', function(e) {
				$(this).removeClass('uti_allows_active'); //close dropdown if click outside <select>
			});

			var selectTop;
			var mustChangeScrollTop = false;

			$('.ip_allows').on('scroll', function(e) {
				if (mustChangeScrollTop) {
					$(this).scrollTop(selectTop);
					mustChangeScrollTop = false;
				}
				return true;
			});
			$('.ip_allows option').mousedown(function(e) { //no ctrl to select multiple
				e.preventDefault();
				selectTop = $(this).parent().scrollTop();
				//alert($('.uti_allows').val().length);
				$(this).prop('selected', $(this).prop('selected') ? false : true); //set selected options on click
				/*if ($('.uti_allows').val().length == 0) {
					//$('.uti_allows').val("Cash");
					$(this).prop('selected', true);
				}*/

				
				$(this).parent().change(); //trigger change event
				mustChangeScrollTop = true;
				return false;
			});
			
			//Intellectual Property Multiple Select Checkboxes
			$(".ip_allows").mousedown(function(e) {
				if (e.target.tagName == "OPTION") {
					return; //don't close dropdown if i select option
				}
				$(this).toggleClass('ip_allows_active'); //close dropdown if click inside <select> box
			});
			$(".ip_allows").on('blur', function(e) {
				$(this).removeClass('ip_allows_active'); //close dropdown if click outside <select>
			});

			var selectTop;
			var mustChangeScrollTop = false;

			$('.ip_allows').on('scroll', function(e) {
				if (mustChangeScrollTop) {
					$(this).scrollTop(selectTop);
					mustChangeScrollTop = false;
				}
				return true;
			});
			$('.ip_allows option').mousedown(function(e) { //no ctrl to select multiple
				e.preventDefault();
				selectTop = $(this).parent().scrollTop();
				//alert($('.uti_allows').val().length);
				// $(this).prop('selected', $(this).prop('selected') ? false : true); //set selected options on click
				/*if ($('.uti_allows').val().length == 0) {
					//$('.uti_allows').val("Cash");
					$(this).prop('selected', true);
				}*/

				// if ($(this).filter(':selected').val() == 'PSP') {
				// 	$("#psp_vle_idDIV").removeClass("d-none");
				// 	$("#psp_vle_idDIV").addClass("d-block");
				// 	$("#psp_vle_id").prop('required', true);
				// } else if ($(this).filter(':selected').val() != 'PSP') {
				// 	$("#psp_vle_idDIV").removeClass("d-block");
				// 	$("#psp_vle_idDIV").addClass("d-none");
				// 	$("#psp_vle_id").prop('required', false);
				// }
				$(this).parent().change(); //trigger change event
				mustChangeScrollTop = true;
				return false;
			});
			
			$("#dsc_allows").change(function() {
				//alert($(this).val());
				if ($(this).val() == '') {
					$("#dsc_companyDIV").removeClass("d-block");
					$("#dsc_companyDIV").addClass("d-none");
					$("#dsc_company").prop('required', false);
				}
				$.each($(this).val(), function(index, value) {
					// Get value in alert  
					if (value == "DSC Partner") {
						$("#dsc_companyDIV").removeClass("d-none");
						$("#dsc_companyDIV").addClass("d-block");
						$("#dsc_company").prop('required', true);
						return false;
					} else {
						$("#dsc_companyDIV").removeClass("d-block");
						$("#dsc_companyDIV").addClass("d-none");
						$("#dsc_company").prop('required', false);
					}
					//alert(value);
				});
			});

			//Multiple Select Checkboxes
			$(".multiple_select").mousedown(function(e) {
				if (e.target.tagName == "OPTION") {
					return; //don't close dropdown if i select option
				}
				$(this).toggleClass('multiple_select_active'); //close dropdown if click inside <select> box
			});
			$(".multiple_select").on('blur', function(e) {
				$(this).removeClass('multiple_select_active'); //close dropdown if click outside <select>
			});

			$('.multiple_select').on('scroll', function(e) {
				if (mustChangeScrollTop) {
					$(this).scrollTop(selectTop);
					mustChangeScrollTop = false;
				}
				return true;
			});
			$('.multiple_select option').mousedown(function(e) { //no ctrl to select multiple
				e.preventDefault();
				selectTop = $(this).parent().scrollTop();
				$(this).prop('selected', $(this).prop('selected') ? false : true); //set selected options on click
				$(this).parent().change(); //trigger change event
				mustChangeScrollTop = true;
				return false;
			});

			$("#select_allUsers").on("click", function() {
				if ($('#select_allUsers').is(":checked")) {
					$('#users_access option').prop('selected', true);
					$('#select_allUsers').prop('checked', true);
					//alert("You have selected the client - " + client_name.join(", "));
				} else {
					$('#users_access option').prop('selected', false);
					$('#select_allUsers').prop('checked', false);
				}
			});
			$("#update_income").hide();
			$('#searchClientDiv').hide();
			$('#showClientMaster').load('html/ClientMaster_DataList.php').fadeIn("slow");

			$(function() {
				$('input[type="checkbox"]:checked').closest('td').addClass('bg-success');
			});
			$('input[type=checkbox]').on('change', function() {
				$(this).closest('td').toggleClass('bg-success', $(this).is(':checked'));
			});

			if ($("#psp_vle_id").val() != "") {
				$("#psp_vle_idDIV").removeClass("d-none");
				$("#psp_vle_idDIV").addClass("d-block");
				$("#psp_vle_id").prop('required', true);
			}
			if ($("#cin").val() != "") {
				$("#cinDIV").removeClass("d-none");
				$("#cinDIV").addClass("d-block");
				$("#cin").prop('required', true);
			}
			if ($("#client_masterEditID_temp").val() != "") {
				CheckMobileNumberExist();
				CheckEmailIdExist();
				$("#showClientMaster").removeClass("d-block");
				$("#showClientMaster").addClass("d-none");
				$("#import_client").removeClass("d-block");
				$("#import_client").addClass("d-none");

				$("#addNew_client").removeClass("d-none");
				$("#addNew_client").addClass("d-block");

				$.each($("#dsc_allows").val(), function(index, value) {
					// Get value in alert  
					if (value == "DSC Partner") {
						$("#dsc_companyDIV").removeClass("d-none");
						$("#dsc_companyDIV").addClass("d-block");
						$("#dsc_company").prop('required', true);
						//break;
					} else {
						//alert(value);
						$("#dsc_companyDIV").removeClass("d-block");
						$("#dsc_companyDIV").addClass("d-none");
						$("#dsc_company").prop('required', false);
					}
				});
				//$("#DIVvendor_client").removeClass("d-none");
				//$("#DIVvendor_client").addClass("d-block");
			}
			$("#add_new_clientMaster").click(function() {
				$("#showClientMaster").removeClass("d-block");
				$("#showClientMaster").addClass("d-none");
				$("#import_client").removeClass("d-block");
				$("#import_client").addClass("d-none");

				$("#addNew_client").removeClass("d-none");
				$("#addNew_client").addClass("d-block");
				//$("#DIVvendor_client").removeClass("d-none");
				//$("#DIVvendor_client").addClass("d-block");
			});
			$("#import_clientMaster").click(function() {
				$("#showClientMaster").removeClass("d-block");
				$("#showClientMaster").addClass("d-none");
				$("#addNew_client").removeClass("d-block");
				$("#addNew_client").addClass("d-none");
				//$("#DIVvendor_client").removeClass("d-block");
				//$("#DIVvendor_client").addClass("d-none");

				$("#import_client").removeClass("d-none");
				$("#import_client").addClass("d-block");
			});

			$("#show_hide_password a").on('click', function(event) {
				event.preventDefault();
				if ($('#show_hide_password input').attr("type") == "text") {
					$('#show_hide_password input').attr('type', 'password');
					$('#show_hide_password i').addClass("fa-eye-slash");
					$('#show_hide_password i').removeClass("fa-eye");
				} else if ($('#show_hide_password input').attr("type") == "password") {
					$('#show_hide_password input').attr('type', 'text');
					$('#show_hide_password i').removeClass("fa-eye-slash");
					$('#show_hide_password i').addClass("fa-eye");
				}
			});

			$('#lastLink').click(function() {
				var last = $('#last').val();
				$.ajax({
					url: "html/showClientMasterTable.php",
					method: "post",
					data: {
						pageno: last
					},
					dataType: "text",
					success: function(data) {
						//alert(data);
						//alert(last);
						//$('#currentPageno').val(last);
						$('#showTable').empty();
						$('#showTable').html(data);
					}
				});
			});
			$('#firstLink').click(function() {
				var last = $('#first').val();
				$.ajax({
					url: "html/showClientMasterTable.php",
					method: "post",
					data: {
						pageno: last
					},
					dataType: "text",
					success: function(data) {
						//alert(data);
						//alert(last);
						$('#showTable').empty();
						$('#showTable').html(data);
					}
				});
			});
			$('#nextLink').click(function() {
				var last = $('#next').val();
				$.ajax({
					url: "html/showClientMasterTable.php",
					method: "post",
					data: {
						pageno: last
					},
					dataType: "text",
					success: function(data) {
						//alert(data);
						//alert(last);
						$('#showTable').empty();
						$('#showTable').html(data);
					}
				});
			});
			$('#prevLink').click(function() {
				var last = $('#prev').val();
				$.ajax({
					url: "html/showClientMasterTable.php",
					method: "post",
					data: {
						pageno: last
					},
					dataType: "text",
					success: function(data) {
						//alert(data);
						//alert(last);
						$('#showTable').empty();
						$('#showTable').html(data);
					}
				});
			});
		});
		
		function openCity(evt, cityName) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(cityName).style.display = "block";
  evt.currentTarget.className += " active";
}
	</script>
	<?php include_once 'ltr/header-footer.php'; ?>
<script src="//cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script>
	$(document).ready( function () {
        $('#ClientApproval_table').DataTable();
        $('#PartnerApproval_table').DataTable();
	});
</script>
</body>
</html>