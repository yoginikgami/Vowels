<?php 
	include_once 'ltr/header.php';
	include_once 'connection.php';
	$alertMsg = "";
	$alertClass = "";
	error_reporting(E_ERROR | E_PARSE);
	//if (isset($_POST['editBankbtn'])) {
	// echo $_SESSION['company_id'];
	$fetch_Company_Query = "SELECT * FROM `company_profile` WHERE `company_id` = '".$_SESSION['company_id']."'";
	$run_fetch_CompanyData = mysqli_query($con,$fetch_Company_Query);
	if (mysqli_num_rows($run_fetch_CompanyData) > 0) {
		$row = mysqli_fetch_array($run_fetch_CompanyData);
		//$user_id = $_SESSION['user_id'];
		$seted_company_name = mysqli_real_escape_string($con,$row['company_name']);
		$seted_contact_person = mysqli_real_escape_string($con,$row['contact_person']);
		$seted_mobile_number = mysqli_real_escape_string($con,$row['mobile_no']);
		$seted_address = mysqli_real_escape_string($con,$row['address']);
		$seted_gst_no = mysqli_real_escape_string($con,$row['gst_no']);
		$seted_pan_no = mysqli_real_escape_string($con,$row['pan_no']);
		$seted_email_id = mysqli_real_escape_string($con,$row['email_id']);
		$seted_website = mysqli_real_escape_string($con,$row['website']);
		$seted_company_logo = str_replace('html/Uploaded_Files/CompanyLogos/', '',mysqli_real_escape_string($con,$row['company_logo']));
		$seted_verify_pin = mysqli_real_escape_string($con,$row['verify_pin']);
		$seted_dsc_subscriber_fees = mysqli_real_escape_string($con,$row['dsc_subscriber_fees']);
		$seted_dsc_reseller_fees = mysqli_real_escape_string($con,$row['dsc_reseller_fees']);
		$seted_pan_fees = mysqli_real_escape_string($con,$row['pan_fees']);
		$seted_tan_fees = mysqli_real_escape_string($con,$row['tan_fees']);
		$seted_it_returns_fees = mysqli_real_escape_string($con,$row['it_returns_fees']);
		$seted_e_tds_fees = mysqli_real_escape_string($con,$row['e-tds_fees']);
		$seted_gst_fees = mysqli_real_escape_string($con,$row['gst_fees']);
		$seted_other_services_fees = mysqli_real_escape_string($con,$row['other_services_fees']);
		$seted_psp_fees = mysqli_real_escape_string($con,$row['psp_fees']);
		$seted_psp_coupon_fees = mysqli_real_escape_string($con,$row['psp_coupon_fees']);
		$seted_audit_fees = mysqli_real_escape_string($con,$row['audit_fees']);
		$select_cash_on_hand=mysqli_real_escape_string($con,$row['cash_on_hand']);
		$seted_trade_mark_fees = mysqli_real_escape_string($con,$row['trade_mark_fees']);
		$seted_patent_fees = mysqli_real_escape_string($con,$row['patent_fees']);
		$seted_copy_right_fees = mysqli_real_escape_string($con,$row['copy_right_fees']);
		$seted_trade_secret_fees = mysqli_real_escape_string($con,$row['trade_secret_fees']);
		$seted_industrial_design_fees = mysqli_real_escape_string($con,$row['industrial_design_fees']);
		$seted_legal_notice_fees = mysqli_real_escape_string($con,$row['legal_notice_fees']);

		//echo $seted_trade_mark_fees;
		$select_time_zone=mysqli_real_escape_string($con,$row['time_zone']);
		if (isset($row['two_step_veri'])) {
            $select_two_step_veri = mysqli_real_escape_string($con, $row['two_step_veri']);
        } else {
            // Handle the case where 'two_step_veri' key is not defined in $row array
            // You may choose to provide a default value or handle it based on your requirements
        }
	}
	$fetch_data = "SELECT * FROM `users` WHERE `company_id` = '".$_SESSION['company_id']."'";
	$run_fetch_data = mysqli_query($con,$fetch_data);
	if (mysqli_num_rows($run_fetch_data) > 0) {
		$row = mysqli_fetch_array($run_fetch_data);
		$edit_reports = $row['reports'];
		$edit_client_master = $row['client_master'];
		$edit_dsc_subscriber = $row['dsc_subscriber'];
		$edit_dsc_reseller = $row['dsc_reseller'];
		$edit_pan = $row['pan'];
		$edit_tan = $row['tan'];
		$edit_it_returns = $row['it_returns'];
		$edit_e_tds = $row['e_tds'];
		$edit_gst = $row['gst'];
		$edit_other_services = $row['other_services'];
		$edit_psp = $row['psp'];
		$edit_psp_coupon_consumption = $row['psp_coupon_consumption'];
		$edit_payment = $row['payment'];
		$edit_audit = $row['audit'];
		$edit_add_users = $row['add_users'];
		$edit_company_profile = $row['company_profile'];
		$edit_e_tender = $row['e_tender'];
		$edit_trade_mark = $row['trade_mark'];
		$edit_patent = $row['patent'];
		$edit_copy_right = $row['copy_right'];
		$edit_trade_secret = $row['trade_secret'];
		$edit_industrial_design = $row['industrial_design'];
		$edit_legal_notice = $row['legal_notice'];
		$edit_document_records = $row['document_records'];
		$edit_settlement = $row['settlement'];
		$edit_expense = $row['expense'];
		$edit_contra_voucher = $row['contra_voucher'];
		$edit_bank_report = $row['bank_report'];
		$edit_outstanding = $row['outstanding'];
		$edit_payroll = $row['payroll'];
		$edit_add_taskmanager = $row['add_taskmanager'];
		$edit_contact_client = $row['contact_client'];
		$edit_add_passMang = $row['add_passMang'];
		$edit_addFix_meeting = $row['addFix_meeting'];
		$edit_ticket = $row['tickets'];
		$edit_add_enquiry = $row['add_enquiry'];
		$edit_whatsapp = $row['whatsapp'];
		$edit_mail_panel = $row['mail_panel'];
		$edit_api_setup = $row['api_setup'];
		$edit_depart_panel = $row['depart_panel'];
		$edit_desig_panel = $row['design_panel'];
		$edit_soft_export = $row['soft_export'];
		$edit_crm_data_record = $row['data_record'];
		$edit_crm_rec_tranf = $row['record_transfer'];
		$edit_add_clientConfig = $row['add_clientConfig'];
		$edit_mom_admin = $row['mom_admin'];
		$edit_crm_trace_cont = $row['trace_contact'];
		$edit_add_Admin_filter = $row['add_Admin_filter'];
		$edit_add_jobProg = $row['add_jobProg'];
        $edit_supplier_master = $row['vendor_master'];
        $edit_other_services = $row['other_services'];
        $edit_other_transaction = $row['other_transaction'];
	}	
	//echo $edit_trade_mark;
	if (isset($_POST['company_profile_save'])) {
		$user_id = $_SESSION['user_id'];
		$company_name = $_POST['company_name'];
		$contact_person = $_POST['contact_person'];
		$mobile_number = $_POST['mobile_number'];
		$address = mysqli_real_escape_string($con,$_POST['address']);
		$gst_no = $_POST['gst_no'];
		$pan_no = $_POST['pan_no'];
		$email_id = $_POST['email_id'];
		$website = $_POST['website'];
		$cash_on_hand=$_POST['cash_on_hand'];

		if (isset($_FILES['company_logo']['name'])) {
			$time = date('d_m_Y_h_i_s_a', time());
			$temp = explode(".", $_FILES["company_logo"]["name"]);
			$file_name = str_replace(' ', '_',(str_replace('-', '_',(str_replace(':', '_', $_SESSION['company_id'])))));
			$newfilename = $file_name . '.' . end($temp);
			$file_size = $_FILES['company_logo']['size'];
			$file_tmp = $_FILES['company_logo']['tmp_name'];
			$local_image = "Uploaded_Files";
			$target = "Uploaded_Files/CompanyLogos/".$newfilename;
			if (move_uploaded_file($file_tmp,$target)) {
				$company_logo = "html/Uploaded_Files/CompanyLogos/".$newfilename;
			}else{
				if ($_POST['temp_company_logo'] != "") {
					$company_logo = "html/Uploaded_Files/CompanyLogos/".$_POST['temp_company_logo'];
				}else{
					$company_logo = "";
				}
			}
		}else{
			if ($_POST['temp_company_logo'] != "") {
				$company_logo = "html/Uploaded_Files/CompanyLogos/".$_POST['temp_company_logo'];
			}else{
				$company_logo = "";
			}
		}

		$bulk_deletePin = $_POST['bulk_deletePin'];
		$dsc_subscriber_fees = $_POST['dsc_subscriber_fees'];
		$dsc_reseller_fees = $_POST['dsc_reseller_fees'];
		$pan_fees = $_POST['pan_fees'];
		$tan_fees = $_POST['tan_fees'];
		$it_returns_fees = $_POST['it_returns_fees'];
		$e_tds_fees = $_POST['e_tds_fees'];
		$trade_mark_fees = $_POST['trade_mark_fees'];
		$patent_fees = $_POST['patent_fees'];
		$copy_right_fees = $_POST['copy_right_fees'];
		$trade_secret_fees = $_POST['trade_secret_fees'];
		$industrial_design_fees = $_POST['industrial_design_fees'];
		$legal_notice_fees = $_POST['legal_notice_fees'];
		$gst_fees = $_POST['gst_fees'];
		$other_services_fees = $_POST['other_services_fees'];
		$psp_fees = $_POST['psp_fees'];
		$psp_coupon_fees = $_POST['psp_coupon_fees'];
		$audit_fees = $_POST['audit_fees'];
		//$tender = $_POST['tender'];
// 		$company_profile_add_query = "INSERT INTO `company_profile`(`user_id`, `company_name`, `contact_person`, `mobile_no`, `address`, `gst_no`, `pan_no`, `email_id`, `website`, `company_logo`, `verify_pin`, `dsc_subscriber_fees`, `dsc_reseller_fees`, `pan_fees`, `tan_fees`, `it_returns_fees`, `e-tds_fees`, `gst_fees`, `other_services_fees`, `psp_fees`, `psp_coupon_fees`, `audit_fees`) VALUES ('".$user_id."','".$company_name."','".$contact_person."','".$mobile_number."','".$address."','".$gst_no."','".$pan_no."','".$email_id."','".$website."','".$company_logo."','".$bulk_deletePin."','".$dsc_subscriber_fees."','".$dsc_reseller_fees."','".$pan_fees."','".$tan_fees."','".$it_returns_fees."','".$e_tds_fees."','".$gst_fees."','".$other_services_fees."','".$psp_fees."','".$psp_coupon_fees."','".$audit_fees."')";
        $company_profile_add_query = "INSERT INTO `company_profile`(`cash_on_hand`,`user_id`, `company_name`, `contact_person`, `mobile_no`, `address`, `gst_no`, `pan_no`, `email_id`, `website`, `company_logo`, `verify_pin`, `dsc_subscriber_fees`, `dsc_reseller_fees`, `pan_fees`, `tan_fees`, `it_returns_fees`, `e-tds_fees`,`trade_mark_fees`,`patent_fees`, `copy_right_fees`, `trade_secret_fees`, `industrial_design_fees`, `legal_notice_fees` ,`gst_fees`, `other_services_fees`, `psp_fees`, `psp_coupon_fees`, `audit_fees`) VALUES ('".$cash_on_hand."','".$user_id."','".$company_name."','".$contact_person."','".$mobile_number."','".$address."','".$gst_no."','".$pan_no."','".$email_id."','".$website."','".$company_logo."','".$bulk_deletePin."','".$dsc_subscriber_fees."','".$dsc_reseller_fees."','".$pan_fees."','".$tan_fees."','".$it_returns_fees."','".$e_tds_fees."','".$trade_mark_fees."','".$patent_fees."','".$copy_right_fees."','".$trade_secret_fees."','".$industrial_design_fees."','".$legal_notice_fees."','".$gst_fees."','".$other_services_fees."','".$psp_fees."','".$psp_coupon_fees."','".$audit_fees."')";
		$run_company_profile_add = mysqli_query($con,$company_profile_add_query);

		if ($run_company_profile_add) {
			$alertMsg = "Record Inserted";
			$alertClass = "alert alert-success";
			$fetch_Company_Query = "SELECT * FROM `company_profile` WHERE `company_id` = '".$_SESSION['company_id']."'";
			$run_fetch_CompanyData = mysqli_query($con,$fetch_Company_Query);
			if (mysqli_num_rows($run_fetch_CompanyData) > 0) {
				$row = mysqli_fetch_array($run_fetch_CompanyData);
				//$user_id = $_SESSION['user_id'];
				$seted_company_name = mysqli_real_escape_string($con,$row['company_name']);
				$seted_contact_person = mysqli_real_escape_string($con,$row['contact_person']);
				$seted_mobile_number = mysqli_real_escape_string($con,$row['mobile_no']);
				$seted_address = mysqli_real_escape_string($con,$row['address']);
				$seted_gst_no = mysqli_real_escape_string($con,$row['gst_no']);
				$seted_pan_no = mysqli_real_escape_string($con,$row['pan_no']);
				$seted_email_id = mysqli_real_escape_string($con,$row['email_id']);
				$seted_website = mysqli_real_escape_string($con,$row['website']);
				$seted_company_logo = str_replace('html/Uploaded_Files/CompanyLogos/', '',mysqli_real_escape_string($con,$row['company_logo']));
				$seted_verify_pin = mysqli_real_escape_string($con,$row['verify_pin']);
				$seted_dsc_subscriber_fees = mysqli_real_escape_string($con,$row['dsc_subscriber_fees']);
				$seted_dsc_reseller_fees = mysqli_real_escape_string($con,$row['dsc_reseller_fees']);
				$seted_pan_fees = mysqli_real_escape_string($con,$row['pan_fees']);
				$seted_tan_fees = mysqli_real_escape_string($con,$row['tan_fees']);
				$seted_it_returns_fees = mysqli_real_escape_string($con,$row['it_returns_fees']);
				$seted_e_tds_fees = mysqli_real_escape_string($con,$row['e-tds_fees']);
				$seted_trade_mark_fees = mysqli_real_escape_string($con,$row['trade_mark_fees']);
				$seted_patent_fees = mysqli_real_escape_string($con,$row['patent_fees']);
				$seted_copy_right_fees = mysqli_real_escape_string($con,$row['copy_right_fees']);
				$seted_trade_mark_fees = mysqli_real_escape_string($con,$row['trade_secret_fees']);
				$seted_industrial_design_fees = mysqli_real_escape_string($con,$row['industrial_design_fees']);
				$seted_legal_notice_fees = mysqli_real_escape_string( $con,$row['legal_notice_fees']);
				$seted_gst_fees = mysqli_real_escape_string($con,$row['gst_fees']);
				$seted_other_services_fees = mysqli_real_escape_string($con,$row['other_services_fees']);
				$seted_psp_fees = mysqli_real_escape_string($con,$row['psp_fees']);
				$seted_psp_coupon_fees = mysqli_real_escape_string($con,$row['psp_coupon_fees']);
				$seted_audit_fees = mysqli_real_escape_string($con,$row['audit_fees']);
				$seted_cash_on_hand = mysqli_real_escape_string($con,$row['cash_on_hand']);
				$seted_two_step_veri = mysqli_real_escape_string($con,$row['two_step_veri']);
				// $seted_two_step_veri = mysqli_real_escape_string($con,$row['two_step_veri']);
				$select_time_zone=mysqli_real_escape_string($con,$row['time_zone']);
			}
			$fetch_data = "SELECT * FROM `users` WHERE `company_id` = '".$_SESSION['company_id']."'";
			$run_fetch_data = mysqli_query($con,$fetch_data);
			if (mysqli_num_rows($run_fetch_data) > 0) {
				$row = mysqli_fetch_array($run_fetch_data);
				$edit_reports = $row['reports'];
				$edit_client_master = $row['client_master'];
				$edit_dsc_subscriber = $row['dsc_subscriber'];
				$edit_dsc_reseller = $row['dsc_reseller'];
				$edit_pan = $row['pan'];
				$edit_tan = $row['tan'];
				$edit_it_returns = $row['it_returns'];
				$edit_e_tds = $row['e_tds'];
				$edit_gst = $row['gst'];
				$edit_other_services = $row['other_services'];
				$edit_psp = $row['psp'];
				$edit_psp_coupon_consumption = $row['psp_coupon_consumption'];
				$edit_payment = $row['payment'];
				$edit_audit = $row['audit'];
				$edit_add_users = $row['add_users'];
				$edit_company_profile = $row['company_profile'];
				$edit_e_tender = $row['e_tender'];
				$edit_trade_mark = $row['trade_mark'];
				$edit_patent = $row['patent'];
				$edit_copy_right = $row['copy_right'];
				$edit_trade_secret = $row['trade_secret'];
				$edit_industrial_design = $row['industrial_design'];
				$edit_legal_notice = $row['legal_notice'];
        		$edit_document_records = $row['document_records'];
        		$edit_settlement = $row['settlement'];
        		$edit_expense = $row['expense'];
        		$edit_contra_voucher = $row['contra_voucher'];
        		$edit_bank_report = $row['bank_report'];
        		$edit_outstanding = $row['outstanding'];
        		$edit_payroll = $row['payroll'];
        		$edit_add_taskmanager = $row['add_taskmanager'];
        		$edit_contact_client = $row['contact_client'];
        		$edit_add_passMang = $row['add_passMang'];
        		$edit_addFix_meeting = $row['addFix_meeting'];
        		$edit_ticket = $row['ticket'];
        		$edit_add_enquiry = $row['add_enquiry'];
        		$edit_whatsapp = $row['whatsapp'];
        		$edit_mail_panel = $row['mail_panel'];
        		$edit_api_setup = $row['api_setup'];
        		$edit_depart_panel = $row['depart_panel'];
        		$edit_desig_panel = $row['design_panel'];
        		$edit_soft_export = $row['soft_export'];
        		$edit_crm_data_record = $row['data_record'];
        		$edit_crm_rec_tranf = $row['record_transfer'];
        		$edit_add_clientConfig = $row['add_clientConfig'];
        		$edit_mom_admin = $row['mom_admin'];
        		$edit_crm_trace_cont = $row['trace_contact'];
        		$edit_add_Admin_filter = $row['add_Admin_filter'];
        		$edit_add_jobProg = $row['add_jobProg'];
                $edit_supplier_master = $row['vendor_master'];
                $edit_other_services = $row['other_services'];
                $edit_other_transaction = $row['other_transaction'];
			}
			
		}
	}
	if (isset($_POST['bank_add'])) {
		$user_id = $_SESSION['user_id'];
		$bank_name = strtoupper($_POST['bank_name']);
		$bank_ac_no = $_POST['bank_ac_no'];
		$ifsc_code = $_POST['ifsc_code'];
		$mirc_code = $_POST['mirc_code'];
		$branch_address = $_POST['branch_address'];
		$branch_code = $_POST['branch_code'];
		$initial_balance = $_POST['initial_balance'];
		$company_profile_add_Bank_query = "INSERT INTO `company_bank_details`(`company_id`, `user_id`, `bank_name`, `bank_ac_no`, `ifsc_code`, `mirc_code`, `branch_address`, `branch_code`, `initial_balance`) VALUES ('".$_SESSION['company_id']."','".$user_id."','".$bank_name."','".$bank_ac_no."','".$ifsc_code."','".$mirc_code."','".$branch_address."','".$branch_code."','".$initial_balance."')";
		$run_company_profile_add_bank = mysqli_query($con,$company_profile_add_Bank_query);
		$insert_bank_tra="insert into `bank_transaction`(`company_id`,`bank_name`,`opening_balance`,`balance`)values('".$_SESSION['company_id']."','".$bank_name."','".$initial_balance."','".$initial_balance."')";
		$run_bank=mysqli_query($con,$insert_bank_tra);
		if ($run_company_profile_add_bank) {
			$alertMsg = "Bank Details Added Successfully";
			$alertClass = "alert alert-success";
		}
	}
	   
    
	if (isset($_POST['Recipient_sertup'])) {
        // Retrieve form data
        $selected_type = isset($_POST['type']) ? $_POST['type'] : '';
        $record_id = isset($_POST['bankEditIDtemp']) ? intval($_POST['bankEditIDtemp']) : 0;
    
        // Check if the record ID is provided
        // if ($record_id > 0) {
            // Prepare an SQL UPDATE statement
            $sql = "UPDATE recipient_name_setup SET type = ? ";
    
            // Use prepared statements to prevent SQL injection
            if ($stmt = $con->prepare($sql)) {
                // Bind parameters
                $stmt->bind_param("s", $selected_type,);
    
                // Execute the query
                if ($stmt->execute()) {
                    $alertMsg = "Recipient Format Updated Successfully";
                    $alertClass = "alert alert-success";
                    echo "<script>alert('Record updated successfully!');</script>";

                } else {
                    $alertMsg = "Error updating record: " . $con->error;
                    $alertClass = "alert alert-danger";
                    echo "<script>alert('Error preparing the query: " . $con->error . "');</script>";
                }
    
                // Close the statement
                $stmt->close();
            } else {
                echo "<script>alert('Error preparing the query: " . $con->error . "');</script>";
            }
        // }
        // else {
        //     echo "<script>alert('Invalid record ID.');</script>";
        // }
    }

	
	if(isset($_POST['primary_bank'])){
	    $bank_name = strtoupper($_POST['primary']);
	    $run_other="update `company_bank_details` set `primary_bank`=0";
	    $other=mysqli_query($con,$run_other);
	    if($other){
	    $run_primary="update `company_bank_details` set `primary_bank`=1 where `id`=$bank_name";
	    $run=mysqli_query($con,$run_primary);
	    if ($run) {
			$alertMsg = "Bank Details Added Successfully";
			$alertClass = "alert alert-success";
		}
	        
	    }
	}
	if (isset($_POST['bank_update'])) {
		$user_id = $_SESSION['user_id'];
		$bankEditID = $_POST['bankEditIDtemp'];
		$bank_name = strtoupper($_POST['bank_name']);
		$bank_ac_no = $_POST['bank_ac_no'];
		$ifsc_code = $_POST['ifsc_code'];
		$mirc_code = $_POST['mirc_code'];
		$branch_address = $_POST['branch_address'];
		$branch_code = $_POST['branch_code'];
		$initial_balance = $_POST['initial_balance'];
		$company_profile_update_Bank_query = "UPDATE `company_bank_details` SET `company_id` = '".$_SESSION['company_id']."',`bank_name`='".$bank_name."',`bank_ac_no`='".$bank_ac_no."',`ifsc_code`='".$ifsc_code."',`mirc_code`='".$mirc_code."',`branch_address`='".$branch_address."',`branch_code`='".$branch_code."',`initial_balance` = '".$initial_balance."' WHERE `id` = '".$bankEditID."'";
		$run_company_profile_update_bank = mysqli_query($con,$company_profile_update_Bank_query);
		if ($run_company_profile_update_bank) {
			$alertMsg = "Bank Details Updated Successfully";
			$alertClass = "alert alert-success";
		}
	}
	if (isset($_POST['company_profile_update'])) {
		$user_id = $_SESSION['user_id'];
		$company_name = $_POST['company_name'];
		$contact_person = $_POST['contact_person'];
		$mobile_number = $_POST['mobile_number'];
		$address = mysqli_real_escape_string($con,$_POST['address']);
		$gst_no = $_POST['gst_no'];
		$pan_no = $_POST['pan_no'];
		$email_id = $_POST['email_id'];
		$website = $_POST['website'];
		$cash_on_hand=$_POST['cash_on_hand'];
		$time_zone=$_POST['time_zone'];
		$two_step_veri = isset($_POST['two_step_veri']) ? $_POST['two_step_veri'] : 0;

		if (isset($_FILES['company_logo']['name'])) {
			$time = date('d_m_Y_h_i_s_a', time());
			$temp = explode(".", $_FILES["company_logo"]["name"]);
			$file_name = str_replace(' ', '_',(str_replace('-', '_',(str_replace(':', '_', $_SESSION['company_id'])))));
			$newfilename = $file_name . '.' . end($temp);
			$file_size = $_FILES['company_logo']['size'];
			$file_tmp = $_FILES['company_logo']['tmp_name'];
			$local_image = "Uploaded_Files";
			$target = "Uploaded_Files/CompanyLogos/".$newfilename;
			if (move_uploaded_file($file_tmp,$target)) {
				$company_logo = "html/Uploaded_Files/CompanyLogos/".$newfilename;
			}else{
				if ($_POST['temp_company_logo'] != "") {
					$company_logo = "html/Uploaded_Files/CompanyLogos/".$_POST['temp_company_logo'];
				}else{
					$company_logo = "";
				}
			}
		}else{
			if ($_POST['temp_company_logo'] != "") {
				$company_logo = "html/Uploaded_Files/CompanyLogos/".$_POST['temp_company_logo'];
			}else{
				$company_logo = "";
			}
		}

		$bulk_deletePin = $_POST['bulk_deletePin'];
		$dsc_subscriber_fees = $_POST['dsc_subscriber_fees'];
		$dsc_reseller_fees = $_POST['dsc_reseller_fees'];
		$pan_fees = $_POST['pan_fees'];
		$tan_fees = $_POST['tan_fees'];
		$it_returns_fees = $_POST['it_returns_fees'];
		$e_tds_fees = $_POST['e_tds_fees'];
		$trade_mark_fees = $_POST['trade_mark_fees'];
		$patent_fees = $_POST['patent_fees'];
		$copy_right_fees = $_POST['copy_right_fees'];
		$trade_secret_fees = $_POST['trade_secret_fees'];
		$industrial_design_fees = $_POST['industrial_design_fees'];
		$legal_notice_fees = $_POST['legal_notice_fees'];
		$gst_fees = $_POST['gst_fees'];
		$other_services_fees = $_POST['other_services_fees'];
		$psp_fees = $_POST['psp_fees'];
		$psp_coupon_fees = $_POST['psp_coupon_fees'];
		$audit_fees = $_POST['audit_fees'];
		if(!isset($_POST['reports']))
		{
		     $reports = 0;
		} else {
		     $reports = $_POST['reports'];
		}
		//$reports = $_POST['reports'];
		if(!isset($_POST['client_master']))
		{
		     $client_master = 0;
		} else {
		     $client_master = $_POST['client_master'];
		}
		//$client_master = $_POST['client_master'];
		if(!isset($_POST['dsc_subscriber']))
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
		if(!isset($_POST['trade_mark']))
		{
			$trade_mark = 0;
		}
		else{
			$trade_mark = $_POST['trade_mark'];
		}
		if(!isset($_POST['patent']))
		{
			$patent = 0;
		}
		else{
			$patent = $_POST['patent'];
		}
		if(!isset($_POST['copy_right']))
		{
			$copy_right = 0;
		}
		else{
			$copy_right = $_POST['copy_right'];
		}
		if(!isset($_POST['trade_secret']))
		{
			$trade_secret = 0;
		}
		else{
			$trade_secret = $_POST['trade_secret'];
		}
		if(!isset($_POST['industrial_design']))
		{
			$industrial_design = 0;
		}
		else{
			$industrial_design = $_POST['industrial_design'];
		}
		if(!isset($_POST['legal_notice']))
		{
			$legal_notice = 0;
		}
		else{
			$legal_notice = $_POST['legal_notice'];
		}
		//$e_tds = $_POST['e_tds'];
		if(!isset($_POST['gst']))
		{
		     $gst = 0;
		} else {
		     $gst = $_POST['gst'];
		}
		//$gst = $_POST['gst'];
		if(!isset($_POST['other_services']))
		{
		     $other_services = 0;
		} else {
		     $other_services = $_POST['other_services'];
		}
		//$other_services = $_POST['other_services'];
		if(!isset($_POST['psp']))
		{
		     $psp = 0;
		} else {
		     $psp = $_POST['psp'];
		}
		//$psp = $_POST['psp'];
		if(!isset($_POST['psp_coupon_consumption']))
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
		}
		//$payment = $_POST['payment'];
		if(!isset($_POST['audit']))
		{
		     $audit = 0;
		} else {
		     $audit = $_POST['audit'];
		}
		if(!isset($_POST['add_users']))
		{
		     $add_users = 0;
		} else {
		     $add_users = $_POST['add_users'];
		}
		//$add_users = $_POST['add_users'];
		if(!isset($_POST['company_profile']))
		{
		     $company_profile = 0;
		} else {
		     $company_profile = $_POST['company_profile'];
		}
		if(!isset($_POST['supplier_master']))
		{
		     $supplier_master = 0;
		} else {
		     $supplier_master = $_POST['supplier_master'];
		}
		if(!isset($_POST['other_services']))
			{
			     $other_services = 0;
			} else {
			     $other_services = $_POST['other_services'];
			}
			if(!isset($_POST['e_tender']))
			{
			     $e_tender = 0;
			} else {
			     $e_tender = $_POST['e_tender'];
			}
			if(!isset($_POST['document_records']))
			{
			     $document_records = 0;
			} else {
			     $document_records = $_POST['document_records'];
			}
			if(!isset($_POST['settlement']))
			{
			     $settlement = 0;
			} else {
			     $settlement = $_POST['settlement'];
			}
			if(!isset($_POST['expense']))
			{
			     $expense = 0;
			} else {
			     $expense = $_POST['expense'];
			}
			if(!isset($_POST['contra_voucher']))
			{
			     $contra_voucher = 0;
			} else {
			     $contra_voucher = $_POST['contra_voucher'];
			}
			if(!isset($_POST['bank_report']))
			{
			     $bank_report = 0;
			} else {
			     $bank_report = $_POST['bank_report'];
			}
			if(!isset($_POST['outstanding']))
			{
			     $outstanding = 0;
			} else {
			     $outstanding = $_POST['outstanding'];
			}
			if(!isset($_POST['payroll']))
			{
			     $payroll = 0;
			} else {
			     $payroll = $_POST['payroll'];
			}
			if(!isset($_POST['add_taskM']))
			{
			     $add_taskM = 0;
			} else {
			     $add_taskM = $_POST['add_taskM'];
			}
			if(!isset($_POST['contact_client']))
			{
			     $contact_client = 0;
			} else {
			     $contact_client = $_POST['contact_client'];
			}
			if(!isset($_POST['add_passMang']))
			{
			     $add_passMang = 0;
			} else {
			     $add_passMang = $_POST['add_passMang'];
			}
			if(!isset($_POST['crm_fix_meeting']))
			{
			     $crm_fix_meeting = 0;
			} else {
			     $crm_fix_meeting = $_POST['crm_fix_meeting'];
			}
			if(!isset($_POST['ticket']))
			{
			     $ticket = 0;
			} else {
			     $ticket = $_POST['ticket'];
			}
			if(!isset($_POST['crm_enq']))
			{
			     $crm_enq = 0;
			} else {
			     $crm_enq = $_POST['crm_enq'];
			}
			if(!isset($_POST['whatsapp']))
			{
			     $whatsapp = 0;
			} else {
			     $whatsapp = $_POST['whatsapp'];
			}
			if(!isset($_POST['mail_panel']))
			{
			     $mail_panel = 0;
			} else {
			     $mail_panel = $_POST['mail_panel'];
			}
			if(!isset($_POST['api_setup']))
			{
			     $api_setup = 0;
			} else {
			     $api_setup = $_POST['api_setup'];
			}
			if(!isset($_POST['depart_panel']))
			{
			     $depart_panel = 0;
			} else {
			     $depart_panel = $_POST['depart_panel'];
			}
			if(!isset($_POST['desig_panel']))
			{
			     $desig_panel = 0;
			} else {
			     $desig_panel = $_POST['desig_panel'];
			}
			if(!isset($_POST['soft_export']))
			{
			     $soft_export = 0;
			} else {
			     $soft_export = $_POST['soft_export'];
			}
			if(!isset($_POST['crm_data_record']))
			{
			     $crm_data_record = 0;
			} else {
			     $crm_data_record = $_POST['crm_data_record'];
			}
			if(!isset($_POST['crm_rec_tranf']))
			{
			     $crm_rec_tranf = 0;
			} else {
			     $crm_rec_tranf = $_POST['crm_rec_tranf'];
			}
			if(!isset($_POST['crm_clientConfig']))
			{
			     $crm_clientConfig = 0;
			} else {
			     $crm_clientConfig = $_POST['crm_clientConfig'];
			}
			if(!isset($_POST['crm_admin_mom']))
			{
			     $crm_admin_mom = 0;
			} else {
			     $crm_admin_mom = $_POST['crm_admin_mom'];
			}
			if(!isset($_POST['crm_trace_cont']))
			{
			     $crm_trace_cont = 0;
			} else {
			     $crm_trace_cont = $_POST['crm_trace_cont'];
			}
			if(!isset($_POST['crm_admin_filter']))
			{
			     $crm_admin_filter = 0;
			} else {
			     $crm_admin_filter = $_POST['crm_admin_filter'];
			}
			if(!isset($_POST['crm_job']))
			{
			     $crm_job = 0;
			} else {
			     $crm_job = $_POST['crm_job'];
			}
			if(!isset($_POST['other_transaction']))
			{
			     $other_transaction = 0;
			} else {
			     $other_transaction = $_POST['other_transaction'];
			}
		//$tender = $_POST['tender'];
// 		$company_profile_update_query = "UPDATE `company_profile` SET `company_name`='".$company_name."',`contact_person`='".$contact_person."',`mobile_no`='".$mobile_number."',`address`='".$address."',`gst_no`='".$gst_no."',`pan_no`='".$pan_no."',`email_id`='".$email_id."',`website`='".$website."',`company_logo`='".$company_logo."',`verify_pin`='".$bulk_deletePin."',`dsc_subscriber_fees`='".$dsc_subscriber_fees."',`dsc_reseller_fees`='".$dsc_reseller_fees."',`pan_fees`='".$pan_fees."',`tan_fees`='".$tan_fees."',`it_returns_fees`='".$it_returns_fees."',`e-tds_fees`='".$e_tds_fees."',`gst_fees`='".$gst_fees."',`other_services_fees`='".$other_services_fees."',`psp_fees`='".$psp_fees."',`psp_coupon_fees`='".$psp_coupon_fees."',`audit_fees`='".$audit_fees."' WHERE `company_id` = '".$_SESSION['company_id']."'";
        $company_profile_update_query = "UPDATE `company_profile` SET `company_name`='".$company_name."',`time_zone`='".$time_zone."',`cash_on_hand`='".$cash_on_hand."',`contact_person`='".$contact_person."',`mobile_no`='".$mobile_number."',`address`='".$address."',`gst_no`='".$gst_no."',`pan_no`='".$pan_no."',`email_id`='".$email_id."',`website`='".$website."',`company_logo`='".$company_logo."',`verify_pin`='".$bulk_deletePin."',`dsc_subscriber_fees`='".$dsc_subscriber_fees."',`dsc_reseller_fees`='".$dsc_reseller_fees."',`pan_fees`='".$pan_fees."',`tan_fees`='".$tan_fees."',`it_returns_fees`='".$it_returns_fees."',`e-tds_fees`='".$e_tds_fees."',`trade_mark__fees`= '".$trade_mark_fees."',`patent_fees` = '".$patent_fees."',`copy_right_fees` = '".$copy_right_fees."',`trade_secret_fees` = '".$trade_secret_fees."',`industrial_design_fees` ='".$industrial_design_fees."',`legal_notice_fees` = '".$legal_notice_fees."',`gst_fees`='".$gst_fees."',`other_services_fees`='".$other_services_fees."',`psp_fees`='".$psp_fees."',`psp_coupon_fees`='".$psp_coupon_fees."',`audit_fees`='".$audit_fees."' WHERE `company_id` = '".$_SESSION['company_id']."'";
		$run_company_profile_update = mysqli_query($con,$company_profile_update_query);
		

        $insert_bank_tra="insert into `bank_transaction`(`company_id`,`bank_name`,`opening_balance`,`balance`)values('".$_SESSION['company_id']."','Cash','".$cash_on_hand."','".$cash_on_hand."')";
        $run_bank=mysqli_query($con,$insert_bank_tra);
        
		$users_portfolio_update_query = "UPDATE `users` SET `company_id` = '".$_SESSION['company_id']."',`reports`='".$reports."',`client_master`='".$client_master."',`other_transaction` = '".$other_transaction."',`dsc_subscriber`='".$dsc_subscriber."',`dsc_reseller`='".$dsc_reseller."',`pan`='".$pan."',`tan`='".$tan."',`it_returns`='".$it_returns."',`e_tds`='".$e_tds."',`trade_mark`='".$trade_mark."',`patent` = '".$patent."',`copy_right` = '".$copy_right."',`trade_secret` ='".$trade_secret."',`industrial_design` = '".$industrial_design."',`legal_notice` = '".$legal_notice."',`gst`='".$gst."',`other_services`='".$other_services."',`psp`='".$psp."',`psp_coupon_consumption`='".$psp_coupon_consumption."',`payment`='".$payment."',`audit`='".$audit."',`add_users`='".$add_users."',`vendor_master` = '".$supplier_master."', `other_services` = '".$other_services."',`e_tender` = '".$e_tender."',`document_records` = '".$document_records."',`settlement` = '".$settlement."',`expense` = '".$expense."',`contra_voucher` = '".$contra_voucher."',`bank_report` = '".$bank_report."',`outstanding` = '".$outstanding."',`payroll` = '".$payroll."',`add_taskmanager` = '".$add_taskM."',`contact_client` = '".$contact_client."',`add_passMang` = '".$add_passMang."',`addFix_meeting` = '".$crm_fix_meeting."',`tickets` = '".$ticket."',`add_enquiry` = '".$crm_enq."',`whatsapp` = '".$whatsapp."',`mail_panel` = '".$mail_panel."',`api_setup` = '".$api_setup."',`depart_panel` = '".$depart_panel."',`design_panel` = '".$desig_panel."',`soft_export` = '".$soft_export."',`data_record` = '".$crm_data_record."',`record_transfer` = '".$crm_rec_tranf."',`add_clientConfig` = '".$crm_clientConfig."',`mom_admin` = '".$crm_admin_mom."',`trace_contact` = '".$crm_trace_cont."',`add_Admin_filter` = '".$crm_admin_filter."',`add_jobProg` = '".$crm_job."' WHERE `company_id` = '".$_SESSION['company_id']."'";
		$run_users_portfolio_update = mysqli_query($con,$users_portfolio_update_query);
		
		$update_admin="update `users` set `two_step_veri`='".$two_step_veri."' WHERE `company_id` = '".$_SESSION['company_id']."' and `username`='".$email_id."' ";
		$run_ad=mysqli_query($con,$update_admin);
		
		
		$update_admin1="update `company_profile` set `two_step_veri`='".$two_step_veri."' WHERE `company_id` = '".$_SESSION['company_id']."' and `email_id`='".$email_id."' ";
		$run_ad1=mysqli_query($con,$update_admin1);

		if ($run_company_profile_update) {
			$alertMsg = "Record Updated";
			$alertClass = "alert alert-success";
			//echo("<meta http-equiv='refresh' content='1'>");
			$fetch_Company_Query = "SELECT * FROM `company_profile` WHERE `company_id` = '".$_SESSION['company_id']."'";
			$run_fetch_CompanyData = mysqli_query($con,$fetch_Company_Query);
			if (mysqli_num_rows($run_fetch_CompanyData) > 0) {
				$row = mysqli_fetch_array($run_fetch_CompanyData);
				//$user_id = $_SESSION['user_id'];
				$seted_company_name = mysqli_real_escape_string($con,$row['company_name']);
				$seted_contact_person = mysqli_real_escape_string($con,$row['contact_person']);
				$seted_mobile_number = mysqli_real_escape_string($con,$row['mobile_no']);
				$seted_address = mysqli_real_escape_string($con,$row['address']);
				$seted_gst_no = mysqli_real_escape_string($con,$row['gst_no']);
				$seted_pan_no = mysqli_real_escape_string($con,$row['pan_no']);
				$seted_email_id = mysqli_real_escape_string($con,$row['email_id']);
				$seted_website = mysqli_real_escape_string($con,$row['website']);
				$seted_company_logo = str_replace('html/Uploaded_Files/CompanyLogos/', '',mysqli_real_escape_string($con,$row['company_logo']));
				$seted_verify_pin = mysqli_real_escape_string($con,$row['verify_pin']);
				$seted_dsc_subscriber_fees = mysqli_real_escape_string($con,$row['dsc_subscriber_fees']);
				$seted_dsc_reseller_fees = mysqli_real_escape_string($con,$row['dsc_reseller_fees']);
				$seted_pan_fees = mysqli_real_escape_string($con,$row['pan_fees']);
				$seted_tan_fees = mysqli_real_escape_string($con,$row['tan_fees']);
				$seted_it_returns_fees = mysqli_real_escape_string($con,$row['it_returns_fees']);
				$seted_e_tds_fees = mysqli_real_escape_string($con,$row['e-tds_fees']);
				$seted_trade_mark_fees = mysqli_real_escape_string($con,$row['trade_mark_fees']);
				$seted_patent_fees = mysqli_real_escape_string( $con,$row['patent_fees']);
				$seted_copy_right_fees = mysqli_real_escape_string( $con,$row['copy_right_fees']);
				$seted_trade_secret_fees = mysqli_real_escape_string( $con,$row['trade_secret_fees']);
				$seted_industrial_design_fees = mysqli_real_escape_string( $con,$row['industrial_design_fees']);
				$seted_legal_notice_fees = mysqli_real_escape_string( $con,$row['legal_notice_fees']);
				$seted_gst_fees = mysqli_real_escape_string($con,$row['gst_fees']);
				$seted_other_services_fees = mysqli_real_escape_string($con,$row['other_services_fees']);
				$seted_psp_fees = mysqli_real_escape_string($con,$row['psp_fees']);
				$seted_psp_coupon_fees = mysqli_real_escape_string($con,$row['psp_coupon_fees']);
				$seted_audit_fees = mysqli_real_escape_string($con,$row['audit_fees']);
				$seted_cash_on_hand = mysqli_real_escape_string($con,$row['cash_on_hand']);
				$seted_two_step_veri = mysqli_real_escape_string($con,$row['two_step_veri']);
				$select_time_zone=mysqli_real_escape_string($con,$row['time_zone']);
			}
			$fetch_data = "SELECT * FROM `users` WHERE `company_id` = '".$_SESSION['company_id']."'";
			$run_fetch_data = mysqli_query($con,$fetch_data);
			
			if (mysqli_num_rows($run_fetch_data) > 0) {
				$row = mysqli_fetch_array($run_fetch_data);
				$edit_reports = $row['reports'];
				$edit_client_master = $row['client_master'];
				$edit_dsc_subscriber = $row['dsc_subscriber'];
				$edit_dsc_reseller = $row['dsc_reseller'];
				$edit_pan = $row['pan'];
				$edit_tan = $row['tan'];
				$edit_it_returns = $row['it_returns'];
				$edit_e_tds = $row['e_tds'];
				$edit_trade_mark = $row['trade_mark'];
				$edit_patent =$row['patent'];
				$edit_copy_right = $row['copy_right'];
				$edit_trade_secret = $row['trade_secret'];
				$edit_industrial_design = $row['industrial_design'];
				$edit_legal_notice = $row['legal_notice'];
				$edit_gst = $row['gst'];
				$edit_other_services = $row['other_services'];
				$edit_psp = $row['psp'];
				$edit_psp_coupon_consumption = $row['psp_coupon_consumption'];
				$edit_payment = $row['payment'];
				$edit_audit = $row['audit'];
				$edit_add_users = $row['add_users'];
				$edit_company_profile = $row['company_profile'];
				$edit_e_tender = $row['e_tender'];
        		$edit_document_records = $row['document_records'];
        		$edit_settlement = $row['settlement'];
        		$edit_expense = $row['expense'];
        		$edit_contra_voucher = $row['contra_voucher'];
        		$edit_bank_report = $row['bank_report'];
        		$edit_outstanding = $row['outstanding'];
        		$edit_payroll = $row['payroll'];
        		$edit_add_taskmanager = $row['add_taskmanager'];
        		$edit_contact_client = $row['contact_client'];
        		$edit_add_passMang = $row['add_passMang'];
        		$edit_addFix_meeting = $row['addFix_meeting'];
        		$edit_ticket = $row['ticket'];
        		$edit_add_enquiry = $row['add_enquiry'];
        		$edit_whatsapp = $row['whatsapp'];
        		$edit_mail_panel = $row['mail_panel'];
        		$edit_api_setup = $row['api_setup'];
        		$edit_depart_panel = $row['depart_panel'];
        		$edit_desig_panel = $row['design_panel'];
        		$edit_soft_export = $row['soft_export'];
        		$edit_crm_data_record = $row['data_record'];
        		$edit_crm_rec_tranf = $row['record_transfer'];
        		$edit_add_clientConfig = $row['add_clientConfig'];
        		$edit_mom_admin = $row['mom_admin'];
        		$edit_crm_trace_cont = $row['trace_contact'];
        		$edit_add_Admin_filter = $row['add_Admin_filter'];
        		$edit_add_jobProg = $row['add_jobProg'];
			}
		}
	}
	if (isset($_POST['bank_delete'])) {
		if (isset($_POST['tempBankIDdel'])) {
			$deleteUser_query = "DELETE FROM `company_bank_details` WHERE `id` = '".$_POST['tempBankIDdel']."'";
			$run_del_query = mysqli_query($con,$deleteUser_query);
			if ($run_del_query) {
				$alertMsg = "Record Deleted";
				$alertClass = "alert alert-danger";
			}
		}
	}

	if (isset($_SESSION['company_id'])) {
		$company_id = $_SESSION['company_id'];
		// Fetch user data for the given company ID and user ID
		$fetch_user_data = "SELECT * FROM `users` WHERE `company_id` = '$company_id' AND `id` = '" . $_SESSION['user_id'] . "'";
		$run_fetch_user_data = mysqli_query($con, $fetch_user_data);
		$permission_row = mysqli_fetch_array($run_fetch_user_data);
	}
	
?>
<!DOCTYPE html>
<html>
<head>
	<title>Vowel Enterprise CMS - Recipient Master</title>
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<!--script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script-->
		<style>
        .primary{
  color: green;
  font-size: 30px;
}
             .switch {
  position: relative;
  display: inline-block;
  width: 30px;
  height: 10px;
}

.switch input { 
  opacity: 0;
  width: 0;
  height: 0;
}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: red;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 18px;
  width: 18px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #5DF62C;
}

input:focus + .slider {
  box-shadow: 0 0 1px #5DF62C;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
  height: 25px;
}

.slider.round:before {
  border-radius: 50%;
}

.collapsible {
  background-color: #777;
  color: white;
  cursor: pointer;
  padding: 10px;
  border: 1px solid black;
  width: 100%;
  border: none;
  text-align: left;
  outline: none;
  font-size: 15px;
}

.active, .collapsible:hover {
  background-color: #555;
}

.content {
  padding: 0 18px;
  display: none;
  overflow: hidden;
  background-color: #f1f1f1;
}

#esp_soft{
    height: 500px;
    overflow-x: hidden;
    overflow-y: auto;
}

#crm_soft{
    height: 500px;
    overflow-x: hidden;
    overflow-y: auto;
}
    </style>
</head>
<body>
	<div class="container-fluid">
	<h2 align="center" class="pageHeading" id="pageHeading">Company Profile</h2>
		<div class="row border justify-content-center" id="after-heading">
			<form method="post" class="col-lg-12 col-sm-12" enctype="multipart/form-data">
				<!-- <input type="hidden" name="userEditID_temp" value="<?= $_POST['userEditID']; ?>"> -->
				<?php if (isset($_POST['company_profile_save']) || isset($_POST['company_profile_update']) || isset($_POST['bank_add']) || isset($_POST['bank_delete']) || isset($_POST['bank_update'])) { ?>
					<div class="<?php echo $alertClass; ?> alert-dismissible" role="alert">
					  <?php echo $alertMsg; ?>
					  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
					    <span aria-hidden="true">&times;</span>
					  </button>
					</div>
				<?php } ?>
				<div class="col text-right showRecordsDiv">
		            <button type="button" class="btn mt-2 mb-2 btn-vowel" data-toggle="modal" data-target="#Recipient_setup_modal"><i class="fas fa-plus"></i> Recipient Format</button>
		            <button type="button" class="btn mt-2 mb-2 btn-vowel" data-toggle="modal" data-target="#AddBank_modal"><i class="fas fa-plus"></i> Add Bank Details</button>
		            <button type="button" class="btn mt-2 mb-2 btn-vowel" data-toggle="modal" data-target="#Primary_bank"><i class="fas fa-plus"></i> Primary Bank</button>
		        </div>
				<div class="form-inline">
					<div class="form-group d-block col-md-3">
					    <label for="exampleInput1" class="float-left p-2">Company Name <span style="color: red;" class="pl-1">*</span></label>
					    <input type="text" name="company_name" readonly class="form-control w-100" id="company_name" aria-describedby="emailHelp" required placeholder="Enter Company Name" value="<?php if (isset($seted_company_name)) {echo $seted_company_name;}?>">
					    
					</div>
					<div class="form-group d-block col-md-3">
					    <label for="exampleInput2" class="float-left p-2">Contact Person <span style="color: red;" class="pl-1">*</span></label>
					    <div class="d-block">
					    	<input type="text" required name="contact_person" class="form-control w-100" id="contact_person" aria-describedby="emailHelp" placeholder="Enter Contact Person" value="<?php  if (isset($seted_contact_person)) {echo $seted_contact_person;}?>" <?php if (isset($seted_contact_person)) {echo "disabled";}?>>
					    </div>
					</div>
					<div class="form-group d-block col-md-3">
					    <label for="exampleInput3" class="float-left p-2">Mobile Number <span style="color: red;" class="pl-1">*</span></label>
					    <input type="number" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="10" class="form-control w-100" name="mobile_number" required id="mobile_number" aria-describedby="emailHelp" placeholder="Enter Mobile Number" <?php if (isset($seted_mobile_number)) {echo "disabled value=".$seted_mobile_number;}?>>
					</div>
					<div class="form-group d-block col-md-3">
					    <label for="exampleInput2" class="float-left p-2">Address <span style="color: red;" class="pl-1">*</span></label>
					    <div class="d-block">
					    	<input type="text" required name="address" class="form-control w-100" id="address" aria-describedby="emailHelp" placeholder="Enter Address" <?php if (isset($seted_address)) {echo "disabled";}?> value="<?php if (isset($seted_address)) {echo $seted_address; } ?>">
					    </div>
					</div>
					<div class="form-group d-block col-md-3">
					    <label for="exampleInput2" class="float-left p-2">GST Number</label>
					    <div class="d-block">
					    	<input type="text" name="gst_no" oninput="this.value=this.value.replace(/[^0-9a-zA-Z]/g,'');" class="form-control w-100" id="gst_no" aria-describedby="emailHelp" placeholder="Enter GST Number" <?php if (isset($seted_gst_no)) {echo "disabled value=".$seted_gst_no;}?>>
					    </div>
					</div>
					<div class="form-group d-block col-md-3">
					    <label for="exampleInput3" class="float-left p-2">PAN Number <span style="color: red;" class="pl-1">*</span></label>
					    <input type="text" readonly oninput="this.value=this.value.replace(/[^0-9a-zA-Z]/g,'');" class="form-control w-100" required name="pan_no" id="pan_no" aria-describedby="emailHelp" placeholder="Enter PAN Number" <?php if (isset($seted_pan_no)) {echo "disabled value=".$seted_pan_no;}?>>
					</div>
					<div class="form-group d-block col-md-3">
					    <label for="exampleInput2" class="float-left p-2">Email Id <span style="color: red;" class="pl-1">*</span></label>
					    <div class="d-block">
					    	<input type="email" required name="email_id" readonly class="form-control w-100" id="email_id" aria-describedby="emailHelp" placeholder="Enter Email Id" <?php if (isset($seted_email_id)) {echo "disabled value=".$seted_email_id;}?>>
					    </div>
					</div>
					<div class="form-group d-block col-md-3">
					    <label for="exampleInput2" class="float-left p-2">Website</label>
					    <div class="d-block">
					    	<input type="text" name="website" class="form-control w-100" id="website" aria-describedby="emailHelp" placeholder="Enter Website" <?php if (isset($seted_website)) {echo "disabled value=".$seted_website;}?>>
					    </div>
					</div>
					<div class="form-group d-block col-md-3">
					    <label for="company_logo" class="float-left p-2">Company Logo</label>
					    <div class="d-block">
							<input type="file" accept=".jpg,.jpeg,.png" name="company_logo" class="form-control w-100" id="company_logo" aria-describedby="emailHelp" <?php if (isset($seted_company_logo)) {echo "disabled";}?> onchange="return fileValidation()">
							<input type="hidden" name="temp_company_logo" readonly value="<?php if (isset($seted_company_logo)) {echo $seted_company_logo;}?>">
					    </div>
					    <span id="company_logo-error"></span>
					    <span id="company_logo-old_logo"><?php if (isset($seted_company_logo)) {echo $seted_company_logo;}?></span>
					</div>
					<div class="form-group d-block col-md-3">
					    <label for="exampleInput2" class="float-left p-2">Pin for bulk deletion</label>
					    <div class="d-block">
					    	<input type="number" name="bulk_deletePin" class="form-control w-100" id="bulk_deletePin" aria-describedby="emailHelp" placeholder="Enter Pin" <?php if (isset($seted_verify_pin)) {echo "disabled value=".$seted_verify_pin;}?>>
					    </div>
					</div>
					<div class="form-group d-block col-md-3">
					    <label for="cash_on_hand" class="float-left p-2">Cash On Hand</label>
					    <div class="d-block"> 
					    	<input type="number" min="0" name="cash_on_hand" class="form-control w-100" id="cash_on_hand" aria-describedby="emailHelp" placeholder="Enter Cash" <?php if (isset($select_cash_on_hand)) {echo "disabled value=".$select_cash_on_hand;}?>>
					    </div>
					</div>
					<div class="form-group d-block col-md-3">
					    <label for="cash_on_hand" class="float-left p-2">Time Zone</label>
					    <div class="d-block"> 
					    	<input type="text" min="0" name="time_zone" class="form-control w-100" id="time_zone" aria-describedby="emailHelp" placeholder="Enter Time Zone" <?php if (isset($select_time_zone)) {echo "disabled value=".$select_time_zone;}?>>
					    </div>
					</div>
					<div class="form-group d-block col-md-3 text-center">
                        <!-- Add text-center class for centering -->
                        <label class="float-left p-2" for="gstr_10_temp_file_uploaded">2-Step verification <span style="color: red;" class="pl-1">*</span></label>
                        <input type="checkbox" class="form-control w-100" name="two_step_veri" id="two_step_veri" style="width: 30px; height: 30px;" value="1" <?php if (isset($select_two_step_veri) && $select_two_step_veri == 1) { echo "checked"; } ?><?php if (isset($select_two_step_veri)) { echo " disabled"; } ?> onclick="updateValue()">
                    </div>
                    
                    <script>
                        function updateValue() {
                            var checkbox = document.getElementById('two_step_veri');
                            var select_two_step_veri = document.getElementById('select_two_step_veri');
                    
                            if (checkbox.checked) {
                                select_two_step_veri.value = 1;
                            } else {
                                select_two_step_veri.value = 0;
                            }
                        }
                    </script>
				</div>
				<div class="form-inline">
					<div class="form-group d-block col-md-6 table-responsive" id="esp_soft">
					    <label class="float-left p-2">ESP Software Permission</label>
					    <button type="button" class="collapsible">Master</button>
                            <div class="content">
							<?php  if($permission_row['client_master'] == 1) { ?>
                                <p><label for="previous_password" class="float-left p-2">Recipient Master:- </label><select class="form-control" id="client_master" name="client_master">
                                        <option value="0" <?php echo ($edit_client_master=="0" ? 'selected' : ''); ?>>Restrict</option>
                                        <option value="1" <?php echo ($edit_client_master==1 ? 'selected' : ''); ?>>Controller</option>
                                    </select>
                            	</p>
							<?php } else{ ?>
								<p><label for="previous_password" class="float-left p-2 d-none">Recipient Master:- </label><select class="form-control d-none" id="client_master" name="client_master">
                                        <option value="0" <?php echo ($edit_client_master=="0" ? 'selected' : ''); ?>>Restrict</option>
                                        <option value="1" <?php echo ($edit_client_master==1 ? 'selected' : ''); ?>>Controller</option>
                                    </select>
                                </p>
							<?php  }if($permission_row['vendor_master'] == 1) { ?>
                                <p><label for="previous_password" class="float-left p-2">Supplier Master:- </label><select class="form-control" id="supplier_master" name="supplier_master">
                                        <option value="0" <?php echo ($edit_supplier_master=="0" ? 'selected' : ''); ?>>Restrict</option>
                                        <option value="1" <?php echo ($edit_supplier_master=="1" ? 'selected' : ''); ?>>Controller</option>
                                    </select>
                                </p>
							<?php } else{?>
								<p><label for="previous_password" class="float-left p-2 d-none">Supplier Master:- </label><select class="form-control d-none" id="supplier_master" name="supplier_master">
                                        <option value="0" <?php echo ($edit_supplier_master=="0" ? 'selected' : ''); ?>>Restrict</option>
                                        <option value="1" <?php echo ($edit_supplier_master=="1" ? 'selected' : ''); ?>>Controller</option>
                                    </select>
                                </p>
							<?php  } ?>
                            </div>
						<button type="button" class="collapsible">Recipient Station</button>
                            <div class="content">
							<?php if($permission_row['dsc_subscriber'] == 1) { ?>	
                                <p><label for="previous_password" class="float-left p-2">DSC Subscriber:- </label><select class="form-control" id="dsc_subscriber" name="dsc_subscriber">
                                        <option value="0" <?php echo ($edit_dsc_subscriber=="0" ? 'selected' : ''); ?>>Restrict</option>
                                        <option value="1" <?php echo ($edit_dsc_subscriber==1 ? 'selected' : ''); ?>>Controller</option>
                                    </select></p>
							<?php  } else {?>
								<p><label for="previous_password" class="float-left p-2 d-none">DSC Subscriber:- </label><select class="form-control d-none" id="dsc_subscriber" name="dsc_subscriber">
                                        <option value="0" <?php echo ($edit_dsc_subscriber=="0" ? 'selected' : ''); ?>>Restrict</option>
                                        <option value="1" <?php echo ($edit_dsc_subscriber==1 ? 'selected' : ''); ?>>Controller</option>
                                    </select></p>
							<?php }if($permission_row['dsc_reseller'] == 1) { ?>  
                                <p><label for="password" class="float-left p-2">DSC Reseller:- </label><select class="form-control" id="dsc_reseller" name="dsc_reseller">
                                        <option value="0" <?php echo ($edit_dsc_reseller=="0" ? 'selected' : ''); ?>>Restrict</option>
                                        <option value="1" <?php echo ($edit_dsc_reseller==1 ? 'selected' : ''); ?>>Controller</option>
                                    </select></p>
							<?php  } else{?>
								<p><label for="password" class="float-left p-2 d-none">DSC Reseller:- </label><select class="form-control d-none" id="dsc_reseller" name="dsc_reseller">
                                        <option value="0" <?php echo ($edit_dsc_reseller=="0" ? 'selected' : ''); ?>>Restrict</option>
                                        <option value="1" <?php echo ($edit_dsc_reseller==1 ? 'selected' : ''); ?>>Controller</option>
                                    </select></p>
							<?php  }if($permission_row['pan'] == 1){?>		
                                <p><label for="password" class="float-left p-2">PAN:- </label><select class="form-control" id="pan" name="pan">
                                        <option value="0" <?php echo ($edit_pan=="0" ? 'selected' : ''); ?>>Restrict</option>
                                        <option value="1" <?php echo ($edit_pan==1 ? 'selected' : ''); ?>>Controller</option>
                                    </select></p>
							<?php } else{ ?>
								<p><label for="password" class="float-left p-2 d-none">PAN:- </label><select class="form-control d-none" id="pan" name="pan">
                                        <option value="0" <?php echo ($edit_pan=="0" ? 'selected' : ''); ?>>Restrict</option>
                                        <option value="1" <?php echo ($edit_pan==1 ? 'selected' : ''); ?>>Controller</option>
                                    </select></p>
							<?php } if($permission_row['tan'] == 1){?>
								<p><label for="password" class="float-left p-2">TAN:- </label><select class="form-control" id="tan" name="tan">
                                        <option value="0" <?php echo ($edit_tan=="0" ? 'selected' : ''); ?>>Restrict</option>
                                        <option value="1" <?php echo ($edit_tan==1 ? 'selected' : ''); ?>>Controller</option>
                                    </select></p>
							<?php } else { ?>  
								<p><label for="password" class="float-left p-2 d-none">TAN:- </label><select class="form-control d-none" id="tan" name="tan">
                                        <option value="0" <?php echo ($edit_tan=="0" ? 'selected' : ''); ?>>Restrict</option>
                                        <option value="1" <?php echo ($edit_tan==1 ? 'selected' : ''); ?>>Controller</option>
                                    </select></p> 
							<?php } if($permission_row['it_returns'] == 1){?> 
								<p><label for="password" class="float-left p-2">IT Return:- </label><select class="form-control" id="it_returns" name="it_returns">
                                        <option value="0" <?php echo ($edit_it_returns=="0" ? 'selected' : ''); ?>>Restrict</option>
                                        <option value="1" <?php echo ($edit_it_returns==1 ? 'selected' : ''); ?>>Controller</option>
                                    </select></p>
							<?php } else{?>
                                <p><label for="password" class="float-left p-2 d-none">IT Return:- </label><select class="form-control d-none" id="it_returns" name="it_returns">
                                        <option value="0" <?php echo ($edit_it_returns=="0" ? 'selected' : ''); ?>>Restrict</option>
                                        <option value="1" <?php echo ($edit_it_returns==1 ? 'selected' : ''); ?>>Controller</option>
                                    </select></p>
							<?php } if($permission_row['e_tds'] == 1){?>
								<p><label for="password" class="float-left p-2">E-tds:- </label><select class="form-control" id="e_tds" name="e_tds">
                                        <option value="0" <?php echo ($edit_e_tds=="0" ? 'selected' : ''); ?>>Restrict</option>
                                        <option value="1" <?php echo ($edit_e_tds==1 ? 'selected' : ''); ?>>Controller</option>
                                    </select></p>
							<?php } else{ ?>
								<p><label for="password" class="float-left p-2 d-none">E-tds:- </label><select class="form-control d-none" id="e_tds" name="e_tds">
                                        <option value="0" <?php echo ($edit_e_tds=="0" ? 'selected' : ''); ?>>Restrict</option>
                                        <option value="1" <?php echo ($edit_e_tds==1 ? 'selected' : ''); ?>>Controller</option>
                                    </select></p>
							<?php } if($permission_row['gst'] == 1){?>
                                <p><label for="password" class="float-left p-2">GST:- </label><select class="form-control" id="gst" name="gst">
                                        <option value="0" <?php echo ($edit_gst=="0" ? 'selected' : ''); ?>>Restrict</option>
                                        <option value="1" <?php echo ($edit_gst==1 ? 'selected' : ''); ?>>Controller</option>
                                    </select></p>
							<?php } else{?>     
								<p><label for="password" class="float-left p-2 d-none">GST:- </label><select class="form-control d-none" id="gst" name="gst">
                                        <option value="0" <?php echo ($edit_gst=="0" ? 'selected' : ''); ?>>Restrict</option>
                                        <option value="1" <?php echo ($edit_gst==1 ? 'selected' : ''); ?>>Controller</option>
                                    </select></p>
							<?php }  if($permission_row['other_services'] == 1){?> 
								<p><label for="password" class="float-left p-2">Other Services:- </label><select class="form-control" id="other_services" name="other_services">
                                        <option value="0" <?php echo ($edit_other_services=="0" ? 'selected' : ''); ?>>Restrict</option>
                                        <option value="1" <?php echo ($edit_other_services==1 ? 'selected' : ''); ?>>Controller</option>
                                    </select></p>
							<?php } else { ?>    
								<p><label for="password" class="float-left p-2 d-none">Other Services:- </label><select class="form-control d-none" id="other_services" name="other_services">
                                        <option value="0" <?php echo ($edit_other_services=="0" ? 'selected' : ''); ?>>Restrict</option>
                                        <option value="1" <?php echo ($edit_other_services==1 ? 'selected' : ''); ?>>Controller</option>
                                    </select></p>
							<?php } if($permission_row['psp'] == 1){?> 
								<p><label for="password" class="float-left p-2">PSP:- </label><select class="form-control" id="psp" name="psp">
                                        <option value="0" <?php echo ($edit_psp=="0" ? 'selected' : ''); ?>>Restrict</option>
                                        <option value="1" <?php echo ($edit_psp==1 ? 'selected' : ''); ?>>Controller</option>
                                    </select></p>
							<?php } else{?>
								<p><label for="password" class="float-left p-2 d-none">PSP:- </label><select class="form-control d-none" id="psp" name="psp">
                                        <option value="0" <?php echo ($edit_psp=="0" ? 'selected' : ''); ?>>Restrict</option>
                                        <option value="1" <?php echo ($edit_psp==1 ? 'selected' : ''); ?>>Controller</option>
                                    </select></p>
							<?php } if($permission_row['psp_coupon_consumption'] == 1){?>
								<p><label for="password" class="float-left p-2">PSP Coupon Comsumption:- </label><select class="form-control" id="psp_coupon_consumption" name="psp_coupon_consumption">
                                        <option value="0" <?php echo ($edit_psp_coupon_consumption=="0" ? 'selected' : ''); ?>>Restrict</option>
                                        <option value="1" <?php echo ($edit_psp_coupon_consumption=="1" ? 'selected' : ''); ?>>Controller</option>
                                    </select></p>
							<?php  } else{?> 
								<p><label for="password" class="float-left p-2 d-none">PSP Coupon Comsumption:- </label><select class="form-control d-none" id="psp_coupon_consumption" name="psp_coupon_consumption">
                                        <option value="0" <?php echo ($edit_psp_coupon_consumption=="0" ? 'selected' : ''); ?>>Restrict</option>
                                        <option value="1" <?php echo ($edit_psp_coupon_consumption=="1" ? 'selected' : ''); ?>>Controller</option>
                                    </select></p>
							<?php }  if($permission_row['audit'] == 1){?>   
								<p><label for="password" class="float-left p-2">Audit:- </label><select class="form-control" id="audit" name="audit">
                                        <option value="0" <?php echo ($edit_audit=="0" ? 'selected' : ''); ?>>Restrict</option>
                                        <option value="1" <?php echo ($edit_audit==1 ? 'selected' : ''); ?>>Controller</option>
                                    </select></p>
							<?php  } else{?>
								<p><label for="password" class="float-left p-2 d-none">Audit:- </label><select class="form-control d-none" id="audit" name="audit">
                                        <option value="0" <?php echo ($edit_audit=="0" ? 'selected' : ''); ?>>Restrict</option>
                                        <option value="1" <?php echo ($edit_audit==1 ? 'selected' : ''); ?>>Controller</option>
                                    </select></p>
							<?php } if($permission_row['other_transaction'] == 1){?>
								<p><label for="password" class="float-left p-2">Other Transaction:- </label><select class="form-control" id="other_transaction" name="other_transaction">
                                        <option value="0" <?php echo ($edit_other_transaction=="0" ? 'selected' : ''); ?>>Restrict</option>
                                        <option value="1" <?php echo ($edit_other_transaction=="1" ? 'selected' : ''); ?>>Controller</option>
                                    </select></p>
							<?php } else{?> 
								<p><label for="password" class="float-left p-2 d-none">Other Transaction:- </label><select class="form-control d-none" id="other_transaction" name="other_transaction">
                                        <option value="0" <?php echo ($edit_other_transaction=="0" ? 'selected' : ''); ?>>Restrict</option>
                                        <option value="1" <?php echo ($edit_other_transaction=="1" ? 'selected' : ''); ?>>Controller</option>
                                    </select></p>     
							<?php } if($permission_row['e_tender'] == 1){?>
								<p><label for="password" class="float-left p-2">E-tender:- </label><select class="form-control" id="e_tender" name="e_tender">
                                        <option value="0" <?php echo ($edit_e_tender=="0" ? 'selected' : ''); ?>>Restrict</option>
                                        <option value="1" <?php echo ($edit_e_tender=="1" ? 'selected' : ''); ?>>Controller</option>
                                    </select>
								</p>
							<?php } else{ ?>
								<p><label for="password" class="float-left p-2 d-none">E-tender:- </label><select class="form-control d-none" id="e_tender" name="e_tender">
                                        <option value="0" <?php echo ($edit_e_tender==0 ? 'selected' : ''); ?>>Restrict</option>
                                        <option value="1" <?php echo ($edit_e_tender==1 ? 'selected' : ''); ?>>Controller</option>
                                    </select>
								</p>
							<?php  } if($permission_row['trade_mark'] == 1){?>
								<p><label for="password" class="float-left p-2">Trade mark:- </label><select class="form-control" id="trade_mark" name="trade_mark">
                                        <option value="0" <?php echo ($edit_trade_mark=="0" ? 'selected' : ''); ?>>Restrict</option>
                                        <option value="1" <?php echo ($edit_trade_mark=="1" ? 'selected' : ''); ?>>Controller</option>
                                    </select>
								</p>
							<?php } else{ ?>
								<p><label for="password" class="float-left p-2 d-none">Trade mark:- </label><select class="form-control d-none" id="trade_mark" name="trade_mark">
                                        <option value="0" <?php echo ($edit_trade_mark=="0" ? 'selected' : ''); ?>>Restrict</option>
                                        <option value="1" <?php echo ($edit_trade_mark=="1" ? 'selected' : ''); ?>>Controller</option>
                                    </select>
								</p>
							<?php } if($permission_row['patent'] == 1){?>
								<p><label for="password" class="float-left p-2">Patent:- </label><select class="form-control" id="patent" name="patent">
                                        <option value="0" <?php echo ($edit_patent=="0" ? 'selected' : ''); ?>>Restrict</option>
                                        <option value="1" <?php echo ($edit_patent=="1" ? 'selected' : ''); ?>>Controller</option>
                                    </select>
								</p>
							<?php } else{ ?>
								<p><label for="password" class="float-left p-2 d-none">Patent:- </label><select class="form-control d-none" id="patent" name="patent">
                                        <option value="0" <?php echo ($edit_patent=="0" ? 'selected' : ''); ?>>Restrict</option>
                                        <option value="1" <?php echo ($edit_patent=="1" ? 'selected' : ''); ?>>Controller</option>
                                    </select>
								</p>
							<?php  } if($permission_row['copy_right'] == 1){?>
								<p><label for="password" class="float-left p-2">Copy right:- </label><select class="form-control" id="copy_right" name="copy_right">
                                        <option value="0" <?php echo ($edit_copy_right=="0" ? 'selected' : ''); ?>>Restrict</option>
                                        <option value="1" <?php echo ($edit_copy_right=="1" ? 'selected' : ''); ?>>Controller</option>
                                    </select>
								</p>
							<?php } else{ ?>
								<p><label for="password" class="float-left p-2 d-none">Copy right:- </label><select class="form-control d-none" id="copy_right" name="copy_right">
                                        <option value="0" <?php echo ($edit_copy_right==0 ? 'selected' : ''); ?>>Restrict</option>
                                        <option value="1" <?php echo ($edit_copy_right==1 ? 'selected' : ''); ?>>Controller</option>
                                    </select>
								</p>
							<?php }if($permission_row['trade_secret'] == 1){?>
								<p><label for="password" class="float-left p-2">Trade Secret:- </label><select class="form-control" id="trade_secret" name="trade_secret">
                                        <option value="0" <?php echo ($edit_trade_secret=="0" ? 'selected' : ''); ?>>Restrict</option>
                                        <option value="1" <?php echo ($edit_trade_secret=="1" ? 'selected' : ''); ?>>Controller</option>
                                    </select>
								</p>
							<?php   } else{ ?>
								<p><label for="password" class="float-left p-2 d-none">Trade Secret:- </label><select class="form-control d-none" id="trade_secret" name="trade_secret">
                                        <option value="0" <?php echo ($edit_trade_secret==0 ? 'selected' : ''); ?>>Restrict</option>
                                        <option value="1" <?php echo ($edit_trade_secret==1 ? 'selected' : ''); ?>>Controller</option>
                                    </select>
								</p>
							<?php  } if($permission_row['industrial_design'] == 1){?>
								<p><label for="password" class="float-left p-2">Industrial Design:- </label><select class="form-control" id="industrial_design" name="industrial_design">
                                        <option value="0" <?php echo ($edit_industrial_design=="0" ? 'selected' : ''); ?>>Restrict</option>
                                        <option value="1" <?php echo ($edit_industrial_design=="1" ? 'selected' : ''); ?>>Controller</option>
                                    </select>
								</p>
							<?php } else{ ?>
								<p><label for="password" class="float-left p-2 d-none">Industrial Design:- </label><select class="form-control d-none" id="industrial_design" name="industrial_design">
                                        <option value="0" <?php echo ($edit_industrial_design==0 ? 'selected' : ''); ?>>Restrict</option>
                                        <option value="1" <?php echo ($edit_industrial_design==1 ? 'selected' : ''); ?>>Controller</option>
                                    </select>
								</p>
							<?php }  if($permission_row['legal_notice'] == 1){?>
								<p><label for="password" class="float-left p-2">Advocate:- </label><select class="form-control" id="legal_notice" name="legal_notice">
                                        <option value="0" <?php echo ($edit_legal_notice=="0" ? 'selected' : ''); ?>>Restrict</option>
                                        <option value="1" <?php echo ($edit_legal_notice=="1" ? 'selected' : ''); ?>>Controller</option>
                                    </select>
								</p>
							<?php } else{ ?>
								<p><label for="password" class="float-left p-2 d-none">Advocate:- </label><select class="form-control d-none" id="advocate" name="advocate">
                                        <option value="0" <?php echo ($edit_legal_notice=="0" ? 'selected' : ''); ?>>Restrict</option>
                                        <option value="1" <?php echo ($edit_legal_notice=="1" ? 'selected' : ''); ?>>Controller</option>
                                    </select>
								</p>
							<?php  } ?>
                            </div>
                            <button type="button" class="collapsible">Accounts/Document</button>
                            <div class="content">
							<?php if($permission_row['document_records'] == 1) { ?>
                              <p><label for="previous_password" class="float-left p-2">Document Records:- </label><select class="form-control" id="document_records" name="document_records">
                                        <option value="0" <?php echo ($edit_document_records==0 ? 'selected' : ''); ?>>Restrict</option>
                                        <option value="1" <?php echo ($edit_document_records==1 ? 'selected' : ''); ?>>Controller</option>
                                    </select></p>
							<?php } ?>
                            </div>
                            <button type="button" class="collapsible">Finance Bank</button>
                            <div class="content">
							<?php if($permission_row['payment'] == 1){ ?>
                                <p><label for="password" class="float-left p-2">Payment:- </label><select class="form-control" id="payment" name="payment">
                                        <option value="0" <?php echo ($edit_payment=="0" ? 'selected' : ''); ?>>Restrict</option>
                                        <option value="1" <?php echo ($edit_payment==1 ? 'selected' : ''); ?>>Controller</option>
                                    </select></p>
							<?php } else{ ?>
								<p><label for="password" class="float-left p-2 d-none">Payment:- </label><select class="form-control d-none" id="payment" name="payment">
                                        <option value="0" <?php echo ($edit_payment=="0" ? 'selected' : ''); ?>>Restrict</option>
                                        <option value="1" <?php echo ($edit_payment==1 ? 'selected' : ''); ?>>Controller</option>
                                    </select></p>
							<?php } if($permission_row['settlement'] == 1){ ?>
                                <p><label for="password" class="float-left p-2">Settlement:- </label><select class="form-control" id="settlement" name="settlement">
                                        <option value="0" <?php echo ($edit_settlement=="0" ? 'selected' : ''); ?>>Restrict</option>
                                        <option value="1" <?php echo ($edit_settlement==1 ? 'selected' : ''); ?>>Controller</option>
                                    </select></p>
							<?php } else{ ?>
								<p><label for="password" class="float-left p-2 d-none">Settlement:- </label><select class="form-control d-none" id="settlement" name="settlement">
                                        <option value="0" <?php echo ($edit_settlement=="0" ? 'selected' : ''); ?>>Restrict</option>
                                        <option value="1" <?php echo ($edit_settlement==1 ? 'selected' : ''); ?>>Controller</option>
                                    </select></p>
							<?php } if($permission_row['expense'] == 1){ ?>
                                <p><label for="password" class="float-left p-2">Expense:- </label><select class="form-control" id="expense" name="expense">
                                        <option value="0" <?php echo ($edit_expense=="0" ? 'selected' : ''); ?>>Restrict</option>
                                        <option value="1" <?php echo ($edit_expense==1 ? 'selected' : ''); ?>>Controller</option>
                                    </select></p>
							<?php } else{ ?>
								<p><label for="password" class="float-left p-2 d-none">Expense:- </label><select class="form-control d-none" id="expense" name="expense">
                                        <option value="0" <?php echo ($edit_expense=="0" ? 'selected' : ''); ?>>Restrict</option>
                                        <option value="1" <?php echo ($edit_expense==1 ? 'selected' : ''); ?>>Controller</option>
                                    </select></p>
							<?php } if($permission_row['contra_voucher'] == 1){ ?>
                                <p><label for="password" class="float-left p-2">Contra Voucher:- </label><select class="form-control" id="contra_voucher" name="contra_voucher">
                                        <option value="0" <?php echo ($edit_contra_voucher=="0" ? 'selected' : ''); ?>>Restrict</option>
                                        <option value="1" <?php echo ($edit_contra_voucher==1 ? 'selected' : ''); ?>>Controller</option>
                                    </select></p>
							<?php } else{ ?>
								<p><label for="password" class="float-left p-2 d-none">Contra Voucher:- </label><select class="form-control d-none" id="contra_voucher" name="contra_voucher">
                                        <option value="0" <?php echo ($edit_contra_voucher=="0" ? 'selected' : ''); ?>>Restrict</option>
                                        <option value="1" <?php echo ($edit_contra_voucher==1 ? 'selected' : ''); ?>>Controller</option>
                                    </select></p>
							<?php } ?>
                                <!--<p><label for="previous_password" class="float-left p-2">Financial Record:- </label><select class="form-control" id="financial_records" name="financial_records">-->
                                <!--        <option value="" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_financial_records==0 ? 'selected' : '');} if (isset($reopen_financial_records)) { echo "selected";}?>>Restrict</option>-->
                                <!--        <option value="1" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_financial_records==1 ? 'selected' : '');} if (isset($reopen_financial_records)) { echo "selected";}?>>Operator</option>-->
                                <!--    </select></p>-->
                            </div>
                            <button type="button" class="collapsible">Reports</button>
                            <div class="content">
							<?php  if($permission_row['reports'] == 1){ ?>
                                <p><label for="previous_password" class="float-left p-2">Service Reports:- </label><select class="form-control" id="reports" name="reports">
                                        <option value="0" <?php echo ($edit_reports=="0" ? 'selected' : ''); ?>>Restrict</option>
                                        <option value="1" <?php echo ($edit_reports==1 ? 'selected' : ''); ?>>Controller</option>
                                    </select>
                                </p>
							<?php } else{ ?>
								<p><label for="previous_password" class="float-left p-2 d-none">Service Reports:- </label><select class="form-control d-none" id="reports" name="reports">
                                        <option value="0" <?php echo ($edit_reports=="0" ? 'selected' : ''); ?>>Restrict</option>
                                        <option value="1" <?php echo ($edit_reports==1 ? 'selected' : ''); ?>>Controller</option>
                                    </select>
                                </p>
							<?php  } if($permission_row['bank_report'] == 1){ ?>
                                 <p><label for="previous_password" class="float-left p-2">Bank Report:- </label><select class="form-control" id="bank_report" name="bank_report">
                                        <option value="0" <?php echo ($edit_bank_report=="0" ? 'selected' : ''); ?>>Restrict</option>
                                        <option value="1" <?php echo ($edit_bank_report==1 ? 'selected' : ''); ?>>Controller</option>
                                    </select>
                                </p>
							<?php } else {?>
								<p><label for="previous_password" class="float-left p-2 d-none">Bank Report:- </label><select class="form-control d-none" id="bank_report" name="bank_report">
                                        <option value="0" <?php echo ($edit_bank_report=="0" ? 'selected' : ''); ?>>Restrict</option>
                                        <option value="1" <?php echo ($edit_bank_report==1 ? 'selected' : ''); ?>>Controller</option>
                                    </select>
                                </p>
							<?php }if($permission_row['outstanding'] == 1){ ?>
                                <p><label for="previous_password" class="float-left p-2">Outstanding:- </label><select class="form-control" id="outstanding" name="outstanding">
                                        <option value="0" <?php echo ($edit_outstanding=="0" ? 'selected' : ''); ?>>Restrict</option>
                                        <option value="1" <?php echo ($edit_outstanding==1 ? 'selected' : ''); ?>>Controller</option>
                                    </select>
                                </p>
							<?php } else {?>
								<p><label for="previous_password" class="float-left p-2 d-none">Outstanding:- </label><select class="form-control d-none" id="outstanding" name="outstanding">
                                        <option value="0" <?php echo ($edit_outstanding=="0" ? 'selected' : ''); ?>>Restrict</option>
                                        <option value="1" <?php echo ($edit_outstanding==1 ? 'selected' : ''); ?>>Controller</option>
                                    </select>
                                </p>
							<?php } ?>	
                            </div>
                            <button type="button" class="collapsible">HR/Payroll</button>
                            <div class="content">
							<?php  if($permission_row['payroll'] == 1){ ?>
                                <p><label for="previous_password" class="float-left p-2">Payroll:- </label><select class="form-control" id="payroll" name="payroll">
                                        <option value="0" <?php echo ($edit_payroll==0 ? 'selected' : ''); ?>>Restrict</option>
                                        <option value="1" <?php echo ($edit_payroll==1 ? 'selected' : ''); ?>>Controller</option>
                                    </select></p>
							<?php } else {?>
								<p><label for="previous_password" class="float-left p-2 d-none">Payroll:- </label><select class="form-control d-none" id="payroll" name="payroll">
                                        <option value="0" <?php echo ($edit_payroll==0 ? 'selected' : ''); ?>>Restrict</option>
                                        <option value="1" <?php echo ($edit_payroll==1 ? 'selected' : ''); ?>>Controller</option>
                                    </select></p>
							<?php } ?>
                            </div>
                            <button type="button" class="collapsible">Task Manager</button>
                            <div class="content">
							<?php  if($permission_row['add_taskmanager'] == 1){ ?>
                                <p><label for="previous_password" class="float-left p-2">Task Manager:- </label><select class="form-control" id="add_taskM" name="add_taskM">
                                        <option value="0" <?php echo ($edit_add_taskmanager=="0" ? 'selected' : ''); ?>>Restrict</option>
                                        <option value="1" <?php echo ($edit_add_taskmanager=="1" ? 'selected' : ''); ?>>Controller</option>
                                    </select></p>
							<?php } else {?>
								<p><label for="previous_password" class="float-left p-2 d-none">Task Manager:- </label><select class="form-control d-none" id="add_taskM" name="add_taskM">
                                        <option value="0" <?php echo ($edit_add_taskmanager=="0" ? 'selected' : ''); ?>>Restrict</option>
                                        <option value="1" <?php echo ($edit_add_taskmanager=="1" ? 'selected' : ''); ?>>Controller</option>
                                    </select></p>
							<?php } ?>
                            </div>
                            <button type="button" class="collapsible">Booster Apps</button>
                            <div class="content">
							<?php  if($permission_row['contact_client'] == 1){ ?>
                                <p><label for="previous_password" class="float-left p-2">Contact Client:- </label><select class="form-control" id="contact_client" name="contact_client">
                                        <option value="0" <?php echo ($edit_contact_client==0 ? 'selected' : ''); ?>>Restrict</option>
                                        <option value="1" <?php echo ($edit_contact_client==1 ? 'selected' : ''); ?>>Controller</option>
                                    </select></p>
							<?php } else {?>
								<p><label for="previous_password" class="float-left p-2 d-none">Contact Client:- </label><select class="form-control d-none" id="contact_client" name="contact_client">
                                        <option value="0" <?php echo ($edit_contact_client==0 ? 'selected' : ''); ?>>Restrict</option>
                                        <option value="1" <?php echo ($edit_contact_client==1 ? 'selected' : ''); ?>>Controller</option>
                                    </select></p>
							<?php } if($permission_row['add_passMang'] == 1){ ?>
                                <p><label for="previous_password" class="float-left p-2">Password Manager:- </label><select class="form-control" id="add_passMang" name="add_passMang">
                                        <option value="0" <?php echo ($edit_add_passMang=="0" ? 'selected' : ''); ?>>Restrict</option>
                                        <option value="1" <?php echo ($edit_add_passMang=="1" ? 'selected' : ''); ?>>Controller</option>
                                    </select></p>
							<?php } else {?>
								<p><label for="previous_password" class="float-left p-2 d-none">Password Manager:- </label><select class="form-control d-none" id="add_passMang" name="add_passMang">
                                        <option value="0" <?php echo ($edit_add_passMang=="0" ? 'selected' : ''); ?>>Restrict</option>
                                        <option value="1" <?php echo ($edit_add_passMang=="1" ? 'selected' : ''); ?>>Controller</option>
                                    </select></p>
							<?php }if($permission_row['addFix_meeting'] == 1){ ?>
                                <p><label for="previous_password" class="float-left p-2">Fix Meeting:- </label><select class="form-control" id="crm_fix_meeting" name="crm_fix_meeting">
                                        <option value="0" <?php echo ($edit_addFix_meeting==0 ? 'selected' : ''); ?>>Restrict</option>
                                        <option value="1" <?php echo ($edit_addFix_meeting==1 ? 'selected' : ''); ?>>Controller</option>
                                    </select></p>
							<?php } else {?>
								<p><label for="previous_password" class="float-left p-2 d-none">Fix Meeting:- </label><select class="form-control d-none" id="crm_fix_meeting" name="crm_fix_meeting">
                                        <option value="0" <?php echo ($edit_addFix_meeting==0 ? 'selected' : ''); ?>>Restrict</option>
                                        <option value="1" <?php echo ($edit_addFix_meeting==1 ? 'selected' : ''); ?>>Controller</option>
                                    </select></p>
							<?php }if($permission_row['tickets'] == 1){ ?>
                                <p><label for="previous_password" class="float-left p-2">Tickets:- </label><select class="form-control" id="ticket" name="ticket">
                                        <option value="0" <?php echo ($edit_ticket=="0" ? 'selected' : ''); ?>>Restrict</option>
                                        <option value="1" <?php echo ($edit_ticket=="1" ? 'selected' : ''); ?>>Controller</option>
                                    </select></p>
							<?php } else {?>
								<p><label for="previous_password" class="float-left p-2 d-none">Tickets:- </label><select class="form-control d-none" id="ticket" name="ticket">
                                        <option value="0" <?php echo ($edit_ticket=="0" ? 'selected' : ''); ?>>Restrict</option>
                                        <option value="1" <?php echo ($edit_ticket=="1" ? 'selected' : ''); ?>>Controller</option>
                                    </select></p>
							<?php }if($permission_row['add_enquiry'] == 1){ ?>
                                <p><label for="previous_password" class="float-left p-2">Enquiry:- </label><select class="form-control" id="crm_enq" name="crm_enq">
                                        <option value="0" <?php echo ($edit_add_enquiry==0 ? 'selected' : ''); ?>>Restrict</option>
                                        <option value="1" <?php echo ($edit_add_enquiry==1 ? 'selected' : ''); ?>>Controller</option>
                                    </select></p>
							<?php } else {?>
								<p><label for="previous_password" class="float-left p-2 d-none">Enquiry:- </label><select class="form-control d-none" id="crm_enq" name="crm_enq">
                                        <option value="0" <?php echo ($edit_add_enquiry==0 ? 'selected' : ''); ?>>Restrict</option>
                                        <option value="1" <?php echo ($edit_add_enquiry==1 ? 'selected' : ''); ?>>Controller</option>
                                    </select></p>
							<?php } ?>
                            </div>
                            <button type="button" class="collapsible">Social PLatform</button>
                            <div class="content">
							<?php if($permission_row['whatsapp'] == 1){ ?>
                              <p><label for="previous_password" class="float-left p-2">WhatsApp:- </label><select class="form-control" id="whatsapp" name="whatsapp">
                                        <option value="0" <?php echo ($edit_whatsapp=="0" ? 'selected' : ''); ?>>Restrict</option>
                                        <option value="1" <?php echo ($edit_whatsapp==1 ? 'selected' : ''); ?>>Controller</option>
                                    </select>
                                </p>
							<?php } else {?>
								<p><label for="previous_password" class="float-left p-2 d-none">WhatsApp:- </label><select class="form-control d-none" id="whatsapp" name="whatsapp">
                                        <option value="0" <?php echo ($edit_whatsapp=="0" ? 'selected' : ''); ?>>Restrict</option>
                                        <option value="1" <?php echo ($edit_whatsapp==1 ? 'selected' : ''); ?>>Controller</option>
                                    </select>
                                </p>
							<?php } ?>
                            </div>
                            <button type="button" class="collapsible">Profile Management</button>
                            <div class="content">
							<?php if($permission_row['add_users'] == 1){ ?>
                              <p><label for="previous_password" class="float-left p-2">Add Users:- </label><select class="form-control" id="add_users" name="add_users">
                                        <option value="0" <?php echo ($edit_add_users==0 ? 'selected' : ''); ?>>Restrict</option>
                                        <option value="1" <?php echo ($edit_add_users==1 ? 'selected' : ''); ?>>Controller</option>
                                    </select></p>
							<?php } else {?>
								<p><label for="previous_password" class="float-left p-2 d-none">Add Users:- </label><select class="form-control d-none" id="add_users" name="add_users">
                                        <option value="0" <?php echo ($edit_add_users==0 ? 'selected' : ''); ?>>Restrict</option>
                                        <option value="1" <?php echo ($edit_add_users==1 ? 'selected' : ''); ?>>Controller</option>
                                    </select></p>
									<?php }if($permission_row['mail_panel'] == 1){ ?>
                                <p><label for="previous_password" class="float-left p-2">Mail Panel:- </label><select class="form-control" id="mail_panel" name="mail_panel">
                                        <option value="0" <?php echo ($edit_mail_panel==0 ? 'selected' : ''); ?>>Restrict</option>
                                        <option value="1" <?php echo ($edit_mail_panel==1 ? 'selected' : ''); ?>>Controller</option>
                                    </select></p>
							<?php } else {?>
								<p><label for="previous_password" class="float-left p-2 d-none">Mail Panel:- </label><select class="form-control d-none" id="mail_panel" name="mail_panel">
                                        <option value="0" <?php echo ($edit_mail_panel==0 ? 'selected' : ''); ?>>Restrict</option>
                                        <option value="1" <?php echo ($edit_mail_panel==1 ? 'selected' : ''); ?>>Controller</option>
                                    </select></p>
							<?php }if($permission_row['api_setup'] == 1){ ?>
                                <p><label for="previous_password" class="float-left p-2">Api Setup:- </label><select class="form-control" id="api_setup" name="api_setup">
                                        <option value="0" <?php echo ($edit_api_setup==0 ? 'selected' : ''); ?>>Restrict</option>
                                        <option value="1" <?php echo ($edit_api_setup==1 ? 'selected' : ''); ?>>Controller</option>
                                    </select></p>
							<?php } else {?>
							</p><label for="previous_password" class="float-left p-2 d-none">Api Setup:- </label><select class="form-control d-none" id="api_setup" name="api_setup">
                                        <option value="0" <?php echo ($edit_api_setup==0 ? 'selected' : ''); ?>>Restrict</option>
                                        <option value="1" <?php echo ($edit_api_setup==1 ? 'selected' : ''); ?>>Controller</option>
                                    </select></p>
							<?php }if($permission_row['depart_panel'] == 1){ ?>
                                <p><label for="previous_password" class="float-left p-2">Department Panel:- </label><select class="form-control" id="depart_panel" name="depart_panel">
                                        <option value="0" <?php echo ($edit_depart_panel==0 ? 'selected' : ''); ?>>Restrict</option>
                                        <option value="1" <?php echo ($edit_depart_panel==1 ? 'selected' : ''); ?>>Controller</option>
                                    </select></p>
							<?php } else {?>
								<p><label for="previous_password" class="float-left p-2 d-none">Department Panel:- </label><select class="form-control d-none" id="depart_panel" name="depart_panel">
                                        <option value="0" <?php echo ($edit_depart_panel==0 ? 'selected' : ''); ?>>Restrict</option>
                                        <option value="1" <?php echo ($edit_depart_panel==1 ? 'selected' : ''); ?>>Controller</option>
                                    </select></p>
							<?php }if($permission_row['design_panel'] == 1){ ?>
                                <p><label for="previous_password" class="float-left p-2">Designation Panel:- </label><select class="form-control" id="desig_panel" name="desig_panel">
                                        <option value="0" <?php echo ($edit_desig_panel==0 ? 'selected' : ''); ?>>Restrict</option>
                                        <option value="1" <?php echo ($edit_desig_panel==1 ? 'selected' : ''); ?>>Controller</option>
                                    </select></p>
							<?php } else {?>
								<p><label for="previous_password" class="float-left p-2 d-none">Designation Panel:- </label><select class="form-control d-none" id="desig_panel" name="desig_panel">
                                        <option value="0" <?php echo ($edit_desig_panel==0 ? 'selected' : ''); ?>>Restrict</option>
                                        <option value="1" <?php echo ($edit_desig_panel==1 ? 'selected' : ''); ?>>Controller</option>
                                    </select></p>
							<?php }if($permission_row['soft_export'] == 1){ ?>
                                <p><label for="previous_password" class="float-left p-2">Export:- </label><select class="form-control" id="soft_export" name="soft_export">
                                        <option value="0" <?php echo ($edit_soft_export==0 ? 'selected' : ''); ?>>Restrict</option>
                                        <option value="1" <?php echo ($edit_soft_export==1 ? 'selected' : ''); ?>>Controller</option>
                                    </select></p>
							<?php } else {?>
								<p><label for="previous_password" class="float-left p-2 d-none">Export:- </label><select class="form-control d-none" id="soft_export" name="soft_export">
                                        <option value="0" <?php echo ($edit_soft_export==0 ? 'selected' : ''); ?>>Restrict</option>
                                        <option value="1" <?php echo ($edit_soft_export==1 ? 'selected' : ''); ?>>Controller</option>
                                    </select></p>
							<?php } ?>
                            </div>
					</div>
					<div class="form-group d-block col-md-6 table-responsive" id="crm_soft">
					    <label class="float-left p-2">CRM Software Permission</label>
					    <button type="button" class="collapsible">CRM Setup</button>
                            <div class="content">
							<?php if($permission_row['data_record'] == 1){ ?>
                                <p><label for="previous_password" class="float-left p-2">Data Record:- </label><select class="form-control" id="crm_data_record" name="crm_data_record">
                                        <option value="0" <?php echo ($edit_crm_data_record==0 ? 'selected' : ''); ?>>Restrict</option>
                                        <option value="1" <?php echo ($edit_crm_data_record==1 ? 'selected' : ''); ?>>Controller</option>
                                    </select></p>
							<?php }else { ?>
								<p><label for="previous_password" class="float-left p-2 d-none">Data Record:- </label><select class="form-control d-none" id="crm_data_record" name="crm_data_record">
                                        <option value="0" <?php echo ($edit_crm_data_record==0 ? 'selected' : ''); ?>>Restrict</option>
                                        <option value="1" <?php echo ($edit_crm_data_record==1 ? 'selected' : ''); ?>>Controller</option>
                                    </select></p>
							<?php }if($permission_row['record_transfer'] == 1){ ?>
                                <p><label for="previous_password" class="float-left p-2">Record Transfer:- </label><select class="form-control" id="crm_rec_tranf" name="crm_rec_tranf">
                                        <option value="0" <?php echo ($edit_crm_rec_tranf==0 ? 'selected' : ''); ?>>Restrict</option>
                                        <option value="1" <?php echo ($edit_crm_rec_tranf==1 ? 'selected' : ''); ?>>Controller</option>
                                    </select></p>
							<?php }else { ?>
								<p><label for="previous_password" class="float-left p-2 d-none">Record Transfer:- </label><select class="form-control d-none" id="crm_rec_tranf" name="crm_rec_tranf">
                                        <option value="0" <?php echo ($edit_crm_rec_tranf==0 ? 'selected' : ''); ?>>Restrict</option>
                                        <option value="1" <?php echo ($edit_crm_rec_tranf==1 ? 'selected' : ''); ?>>Controller</option>
                                    </select></p>
							<?php }if($permission_row['add_clientConfig'] == 1){ ?>
                                <p><label for="previous_password" class="float-left p-2">Client Configuration:- </label><select class="form-control" id="crm_clientConfig" name="crm_clientConfig">
                                        <option value="0" <?php echo ($edit_add_clientConfig==0 ? 'selected' : ''); ?>>Restrict</option>
                                        <option value="1" <?php echo ($edit_add_clientConfig==1 ? 'selected' : ''); ?>>Controller</option>
                                    </select></p>
							<?php }else { ?>
								<p><label for="previous_password" class="float-left p-2 d-none">Client Configuration:- </label><select class="form-control d-none" id="crm_clientConfig" name="crm_clientConfig">
                                        <option value="0" <?php echo ($edit_add_clientConfig==0 ? 'selected' : ''); ?>>Restrict</option>
                                        <option value="1" <?php echo ($edit_add_clientConfig==1 ? 'selected' : ''); ?>>Controller</option>
                                    </select></p>
							<?php } ?>
                            </div>
                            <button type="button" class="collapsible">CRM Utility</button>
                            <div class="content">
							<?php if($permission_row['mom_admin'] == 1){ ?>
                                <p><label for="previous_password" class="float-left p-2">MOM Filter:- </label><select class="form-control" id="crm_admin_mom" name="crm_admin_mom">
                                        <option value="0" <?php echo ($edit_mom_admin==0 ? 'selected' : ''); ?>>Restrict</option>
                                        <option value="1" <?php echo ($edit_mom_admin==1 ? 'selected' : ''); ?>>Controller</option>
                                    </select></p>
							<?php } else{ ?>
								<p><label for="previous_password" class="float-left p-2 d-none">MOM Filter:- </label><select class="form-control d-none" id="crm_admin_mom" name="crm_admin_mom">
                                        <option value="0" <?php echo ($edit_mom_admin==0 ? 'selected' : ''); ?>>Restrict</option>
                                        <option value="1" <?php echo ($edit_mom_admin==1 ? 'selected' : ''); ?>>Controller</option>
                                    </select></p>
							<?php }if($permission_row['trace_contact'] == 1){ ?>
                                <p><label for="previous_password" class="float-left p-2">Trace Contact:- </label><select class="form-control" id="crm_trace_cont" name="crm_trace_cont">
                                        <option value="0" <?php echo ($edit_crm_trace_cont==0 ? 'selected' : ''); ?>>Restrict</option>
                                        <option value="1" <?php echo ($edit_crm_trace_cont==1 ? 'selected' : ''); ?>>Controller</option>
                                    </select></p>
							<?php } else{ ?>
								<p><label for="previous_password" class="float-left p-2 d-none">Trace Contact:- </label><select class="form-control d-none" id="crm_trace_cont" name="crm_trace_cont">
                                        <option value="0" <?php echo ($edit_crm_trace_cont==0 ? 'selected' : ''); ?>>Restrict</option>
                                        <option value="1" <?php echo ($edit_crm_trace_cont==1 ? 'selected' : ''); ?>>Controller</option>
                                    </select></p>
							<?php }if($permission_row['add_Admin_filter	'] == 1){ ?>
                                <p><label for="previous_password" class="float-left p-2 ">Admin Filter:- </label><select class="form-control" id="crm_admin_filter" name="crm_admin_filter">
                                        <option value="0" <?php echo ($edit_add_Admin_filter==0 ? 'selected' : ''); ?>>Restrict</option>
                                        <option value="1" <?php echo ($edit_add_Admin_filter==1 ? 'selected' : ''); ?>>Controller</option>
                                    </select></p>
							<?php } else{ ?>
								<p><label for="previous_password" class="float-left p-2 d-none">Admin Filter:- </label><select class="form-control d-none" id="crm_admin_filter" name="crm_admin_filter">
                                        <option value="0" <?php echo ($edit_add_Admin_filter==0 ? 'selected' : ''); ?>>Restrict</option>
                                        <option value="1" <?php echo ($edit_add_Admin_filter==1 ? 'selected' : ''); ?>>Controller</option>
                                    </select></p>
							<?php } ?> 
                            </div>
                            <button type="button" class="collapsible">Job Progress</button>
                            <div class="content">
							<?php if($permission_row['add_jobProg'] == 1){ ?>
                                <p><label for="previous_password" class="float-left p-2">Job Progress:- </label><select class="form-control" id="crm_job" name="crm_job">
                                        <option value="0" <?php echo ($edit_add_jobProg==0 ? 'selected' : ''); ?>>Restrict</option>
                                        <option value="1" <?php echo ($edit_add_jobProg==1 ? 'selected' : ''); ?>>Controller</option>
                                    </select></p>
							<?php } else{ ?>
								<p><label for="previous_password" class="float-left p-2 d-none">Job Progress:- </label><select class="form-control d-none" id="crm_job" name="crm_job">
                                        <option value="0" <?php echo ($edit_add_jobProg==0 ? 'selected' : ''); ?>>Restrict</option>
                                        <option value="1" <?php echo ($edit_add_jobProg==1 ? 'selected' : ''); ?>>Controller</option>
                                    </select></p>
							<?php } ?>
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
					<?php 
					echo '<input type="button" name="company_profile_edit" id="company_profile_edit" value="Update" class="btn btn-vowel"> &nbsp;';
					if (isset($seted_company_name)) {
						echo '<input type="submit" name="company_profile_update" id="company_profile_update" disabled value="Save Changes" class="btn btn-vowel">';
					}else{
						echo '<input type="submit" name="company_profile_save" value="SAVE" class="btn btn-vowel">';
					}?>
				</div>
			</form>
			<div class="table-responsive">
				<table class="table">
					<thead>
						<th style="font-weight: bold;" class="tableDate">Edit</th>
						<th style="font-weight: bold;" class="tableDate">Delete</th>
						<th>Primary A/C</th>
						<th>Bank Name</th>
						<th>Bank Account Number</th>
						<th>IFSC Code</th>
						<th>MIRC Code</th>
						<th>Branch Address</th>
						<th>Branch Code</th>
						<th>Initial Balance</th>
					</thead>
					<tbody>
						<?php 
							$fetch_bank_data = "SELECT * FROM `company_bank_details` WHERE `company_id` = '".$_SESSION['company_id']."' AND `company_id` = '".$_SESSION['company_id']."' ";
							$run_bank_data = mysqli_query($con,$fetch_bank_data);
							while ($row = mysqli_fetch_array($run_bank_data)) { ?>
								<tr>
									<td>
										<form method="post">
											<input type="hidden" name="bankEditID" id="bankEditID" value="<?= $row['id']; ?>"><span data-toggle="modal" data-target="#AddBank_modal">
											<button type="button" class="editBankbtn mr-2" name="editBankbtn" id="editBankbtn" data-toggle="tooltip" data-placement="top" title="Edit" style="padding: 0;border: none;background: none; outline:none;"><i class="fas fa-pencil-alt fa-lg" style="color:green;"></i></button></span>
										</form>
									</td>
									<td>
										<form method="post">
											<input type="hidden" name="bankDeleteID" id="bankDeleteID" value="<?= $row['id']; ?>"><span data-toggle="modal" data-target="#userConfirmMessagePopup">
											<button type="button" name="bankDeletebtn" class="bankDeletebtn" id="bankDeletebtn" data-toggle="tooltip" data-placement="top" title="Delete" style="padding: 0;border: none;background: none; outline:none; color: red;"><i class="fas fa-times fa-lg"></i></button></span>
										</form>
									</td>
									<td class="primary">
									    <?php 
									    if($row['primary_bank']){
									        ?>
									       <span>&#10003;</span>
<?php
									    }else{
									       // echo "No";
									    }
									    
									    ?>
									</td>
									<td><?= $row['bank_name']; ?></td>
									<td><?= $row['bank_ac_no']; ?></td>
									<td><?= $row['ifsc_code']; ?></td>
									<td><?= $row['mirc_code']; ?></td>
									<td><?= $row['branch_address']; ?></td>
									<td><?= $row['branch_code']; ?></td>
									<td><?= $row['initial_balance']; ?></td>
								</tr>
					<?php   }
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>

<!--Add Bank Popup-->
<div class="modal fade" data-backdrop="static" data-keyboard="false" id="AddBank_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
    	<form method="post">
	      <div class="modal-header">
	        <img src="<?php echo $main_company_logo; ?>" alt="The Thu" class="logo navbar-brand mr-auto">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body bg-light">
	      	<input type="hidden" name="bankEditIDtemp" id="bankEditIDtemp">
	      	<div class="form-inline">
		        <div class="form-group d-block col-md-6">
				    <label for="bank_name" class="float-left p-2">Bank Name</label>
				    <div class="d-block">
				    	<input type="text" required name="bank_name" class="form-control w-100" id="bank_name" aria-describedby="emailHelp" placeholder="Enter Bank Name">
				    </div>
				</div>
				<div class="form-group d-block col-md-6">
				    <label for="bank_ac_no" class="float-left p-2">Bank A/c Number</label>
				    <div class="d-block">
				    	<input type="text" required name="bank_ac_no" class="form-control w-100" id="bank_ac_no" aria-describedby="emailHelp" placeholder="Enter Bank A/c Number">
				    </div>
				</div>
			</div>
			<div class="form-inline">
		        <div class="form-group d-block col-md-6">
				    <label for="ifsc_code" class="float-left p-2">IFSC Code</label>
				    <div class="d-block">
				    	<input type="text" required name="ifsc_code" class="form-control w-100" id="ifsc_code" aria-describedby="emailHelp" placeholder="Enter IFSC Code">
				    </div>
				</div>
				<div class="form-group d-block col-md-6">
				    <label for="mirc_code" class="float-left p-2">MIRC Code</label>
				    <div class="d-block">
				    	<input type="text" required name="mirc_code" class="form-control w-100" id="mirc_code" aria-describedby="emailHelp" placeholder="Enter MIRC Code">
				    </div>
				</div>
			</div>
			<div class="form-inline">
		        <div class="form-group d-block col-md-6">
				    <label for="branch_address" class="float-left p-2">Branch Address</label>
				    <div class="d-block">
				    	<input type="text" required name="branch_address" class="form-control w-100" id="branch_address" aria-describedby="emailHelp" placeholder="Enter Branch Address">
				    </div>
				</div>
				<div class="form-group d-block col-md-6">
				    <label for="branch_code" class="float-left p-2">Branch Code</label>
				    <div class="d-block">
				    	<input type="text" required name="branch_code" class="form-control w-100" id="branch_code" aria-describedby="emailHelp" placeholder="Enter Branch Code">
				    </div>
				</div>
			</div>
			<div class="form-inline">
		        <div class="form-group d-block col-md-6">
				    <label for="initial_balance" class="float-left p-2">Initial Balance</label>
				    <div class="d-block">
				    	<input type="number" required min="0" step="0.01" name="initial_balance" class="form-control w-100" id="initial_balance" aria-describedby="emailHelp" placeholder="Enter Initial Balance">
				    </div>
				</div>
			</div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
	        <button type="submit" name="bank_add" id="bank_add" class="btn btn-vowel d-block">Add</button>
	        <button type="submit" name="bank_update" id="bank_update" class="btn btn-vowel d-none">Update</button>
	      </div>
	    </form>
    </div>
  </div>
</div>

<!--Recipient Setup-->
<div class="modal fade" data-backdrop="static" data-keyboard="false" id="Recipient_setup_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <form method="post">
        <div class="modal-header">
          <img src="<?php echo $main_company_logo; ?>" alt="The Thu" class="logo navbar-brand mr-auto">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body bg-light">
          <!--<input type="hidden" name="bankEditIDtemp" id="bankEditIDtemp">-->

            <?php 
            
            $selected_type = '';
            // if (isset($_GET['id'])) {
                // $id = intval($_GET['id']);
                $sql = "SELECT type FROM recipient_name_setup";
                
                if ($stmt = $con->prepare($sql)) {
                    // $stmt->bind_param("i", $id);
                    $stmt->execute();
                    $stmt->bind_result($selected_type);
                    $stmt->fetch();
                    $stmt->close();
                }
            // }
            ?>
          <!--<input type="text" name="bankEditIDtemp" id="bankEditIDtemp" value="<?php echo isset($id) ? $id : ''; ?>">-->
          <!-- Flexbox Layout -->
          <div class="d-flex justify-content-between align-items-start mt-3">
            <!-- Radio Buttons -->
            <div class="form-group">
              <label class="d-block">Select Type</label>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="type" id="type1" value="Recipiet Name (Company Name)" 
                <?php echo ($selected_type === 'Recipiet Name (Company Name)') ? 'checked' : ''; ?>>
                <label class="form-check-label" for="type1">Recipiet (Company)</label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="type" id="type2" value="Comapny Name (Recipiet Name)" 
                <?php echo ($selected_type === 'Comapny Name (Recipiet Name)') ? 'checked' : ''; ?>>
                <label class="form-check-label" for="type2">Comapny (Recipiet)</label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="type" id="type3" value="Recipient Name" 
                <?php echo ($selected_type === 'Recipient Name') ? 'checked' : ''; ?>>
                <label class="form-check-label" for="type3">Recipient</label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="type" id="type4" value="Company Name" 
                <?php echo ($selected_type === 'Company Name') ? 'checked' : ''; ?>>
                <label class="form-check-label" for="type4">Company</label>
              </div>
            </div>

            <!-- Dynamic Select Tag -->
            <div class="form-group w-50">
              <label for="dynamic_select">Select Option</label>
              <select class="form-control" id="dynamic_select" name="dynamic_select">
                <?php if (!empty($selected_type)): ?>
                  <option value="<?php echo $selected_type; ?>" selected><?php echo $selected_type; ?></option>
                <?php else: ?>
                  <option value="">Please select a type first</option>
                <?php endif; ?>
              </select>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button type="submit" name="Recipient_sertup" id="Recipient_sertup" class="btn btn-vowel d-block">Add</button>
          <button type="submit" name="bank_update" id="bank_update" class="btn btn-vowel d-none">Update</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  // jQuery to handle radio button selection and dynamic select options
  $(document).ready(function () {
    $('input[name="type"]').on('change', function () {
      const selectedType = $(this).val();
      const selectBox = $('#dynamic_select');
      selectBox.empty(); // Clear existing options

      if (selectedType) {
        selectBox.append(`<option value="">Select ${selectedType}</option>`);
        selectBox.append(`<option value="${selectedType} Option 1">${selectedType} Option 1</option>`);
        selectBox.append(`<option value="${selectedType} Option 2">${selectedType} Option 2</option>`);
        selectBox.append(`<option value="${selectedType} Option 3">${selectedType} Option 3</option>`);
      } else {
        selectBox.append('<option value="">Please select a type first</option>');
      }
    });
  });
</script>


<script>
  // jQuery to handle radio button selection and dynamic select options
  $(document).ready(function () {
    $('input[name="type"]').on('change', function () {
      const selectedType = $(this).val();
      const selectBox = $('#dynamic_select');
      selectBox.empty(); // Clear existing options

      if (selectedType) {
        selectBox.append(`<option value="">Select ${selectedType}</option>`);
        selectBox.append(`<option value="${selectedType}">${selectedType}</option>`);
        selectBox.append(`<option value="${selectedType}">${selectedType}</option>`);
        selectBox.append(`<option value="${selectedType}">${selectedType}</option>`);
      } else {
        selectBox.append('<option value="">Please select a type first</option>');
      }
    });
  });
</script>


<!-- Primary bank-->
<div class="modal fade" data-backdrop="static" data-keyboard="false" id="Primary_bank" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
    	<form method="post">
	      <div class="modal-header">
	        <img src="<?php echo $main_company_logo; ?>" alt="The Thu" class="logo navbar-brand mr-auto">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body bg-light">
	      	<table>
	      	    <tr>
	      	        <!--<th>No</th>-->
    	      	    <th>Primary</th>
    	      	    <th>Bank Name</th>    
	      	    </tr>
	      	    
	      	    <?php 
				$fetch_bank_data = "SELECT * FROM `company_bank_details` WHERE `company_id` = '".$_SESSION['company_id']."' AND `company_id` = '".$_SESSION['company_id']."' ";
				$run_bank_data = mysqli_query($con,$fetch_bank_data);
				while ($row = mysqli_fetch_array($run_bank_data)) { ?>
				<tr>
				    <td><input type="radio" name="primary" value="<?php echo $row['id'];?>"></td>
				    <td><?php echo $row['bank_name'];?></td>
				<?php
				}
				?>
	      	    </tr>
	      	</table>
	      	
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
	        <button type="submit" name="primary_bank" id="primary_bank" class="btn btn-vowel d-block">Add</button>
	        <button type="submit" name="bank_update" id="bank_update" class="btn btn-vowel d-none">Update</button>
	      </div>
	    </form>
    </div>
  </div>
</div>
<!--Delete Confirm Popup-->
<div class="modal fade" data-backdrop="static" data-keyboard="false" id="userConfirmMessagePopup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
    	<form method="post">
	      <div class="modal-header">
	        <!-- <img src="assets/images/sthana-logo-2.png" alt="Vowel" class="logo navbar-brand mr-auto"> -->
	        <img src="<?php echo $main_company_logo; ?>" alt="The Thu" class="logo navbar-brand mr-auto">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body bg-light">
	        <input type="hidden" id="tempBankIDdel" name="tempBankIDdel" class="tempBankIDdel">
	        <?php echo "<p>Do You Really Want To Delete This Record ?</p>"; ?>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">NO</button>
	        <button type="submit" name="bank_delete" id="bank_delete" class="btn btn-vowel">YES</button>
	      </div>
	    </form>
    </div>
  </div>
</div>
<!--Loading Modal-->
<div class="modal hide" id="pleaseWaitDialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="background: rgba(0,0,0,0); border: none;">
            <!--div class="modal-header">
                <h1>Please Wait</h1>
            </div-->
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="visibility: hidden;">
	          <span aria-hidden="true">&times;</span>
	        </button>
            <div class="modal-body">
                <div id="ajax_loader">
                    <img src="html/images/demo_wait-4.gif" style="display: block; margin-left: auto; margin-right: auto;">
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
var coll = document.getElementsByClassName("collapsible");
        var i;
        
        for (i = 0; i < coll.length; i++) {
          coll[i].addEventListener("click", function() {
            this.classList.toggle("active");
            var content = this.nextElementSibling;
            if (content.style.display === "block") {
              content.style.display = "none";
            } else {
              content.style.display = "block";
            }
          });
        }
	$(document).ready(function(){
		$('.table tbody').on('click', '#editBankbtn', function () {
			//$('#pleaseWaitDialog').modal('hide');
			//$("#pleaseWaitDialog .close").click();
            //$("#AddBank_modal").modal("show");
			//var recordID = $('#recordID').val();
			var row_indexDEL = $(this).closest('tr'); 
			var recordID = row_indexDEL.find('#bankEditID').val();
			//var recordID = $('#bankrecordID').val();
			//alert(recordID);
			$('#bankEditIDtemp').val(recordID);
			//$('#pleaseWaitDialog').modal('show');
			$.ajax({
				url:"html/bankProcess.php",
				method:"post",
				data: {send_recordID:recordID},
				dataType:"text",
		        success:function(data)
		        {
		        //$('#pleaseWaitDialog').modal('show');	
		        	//alert(data);
		        	//$("#pleaseWaitDialog .close").click();
					/*if (data == "done") {
						alert("Done");

					}else if (data == "none") {
						alert("None");
					}*/
					var array = JSON.parse(data);
					//alert(array[0]);
					$('#bank_add').removeClass('d-block');
					$('#bank_add').addClass('d-none');
					$('#bank_update').removeClass('d-none');
					$('#bank_update').addClass('d-block');
					$("#bank_name").val(array[0]);
					$("#bank_ac_no").val(array[1]);
					$('#ifsc_code').val(array[2]);
					$('#mirc_code').val(array[3]);
					$("#branch_address").val(array[4]);
					$("#branch_code").val(array[5]);
					$("#initial_balance").val(array[6]);
					//$('#hiddenID').val(recordID);
				}
			  });
		});
	});
	$(document).ready(function(){
		$('.table tbody').on('click', '#bankDeletebtn', function () {
		  //var recordID = $('#recordID').val();
		  var row_indexDEL = $(this).closest('tr'); 
		  var deleteID = row_indexDEL.find('#bankDeleteID').val();
			//var deleteID = $('#bankDeleteID').val();
			//alert(deleteID);
			$('#tempBankIDdel').val(deleteID);
		});
	});
	$('#company_profile_edit').click(function () {
	  	//$('#company_name').prop("disabled", true);
    	$('#company_name').removeAttr("disabled");
    	$('#contact_person').removeAttr("disabled");
    	$('#mobile_number').removeAttr("disabled");
    	$('#address').removeAttr("disabled");
    	$('#gst_no').removeAttr("disabled");
    	$('#pan_no').removeAttr("disabled");
    	$('#email_id').removeAttr("disabled");
    	$('#website').removeAttr("disabled");
    	$('#company_logo').removeAttr("disabled");
    	$('#bulk_deletePin').removeAttr("disabled");
    	$('#dsc_subscriber_fees').removeAttr("disabled");
    	$('#dsc_reseller_fees').removeAttr("disabled");
    	$('#pan_fees').removeAttr("disabled");
    	$('#tan_fees').removeAttr("disabled");
    	$('#it_returns_fees').removeAttr("disabled");
    	$('#e_tds_fees').removeAttr("disabled");
		$('#trade_mark_fees').removeAttr("disabled");
		$('#patent_fees').removeAttr("disabled");
		$('#copy_right_fees').removeAttr("disable");
		$('#trade_secret_fees').removeAttr("disable");
		$('#industrial_design_fees').removeAttr("disable");
		$('#legal_notice_fees').removeAttr("disable");
    	$('#gst_fees').removeAttr("disabled");
    	$('#other_services_fees').removeAttr("disabled");
    	$('#psp_fees').removeAttr("disabled");
    	$('#psp_coupon_fees').removeAttr("disabled");
    	$('#audit_fees').removeAttr("disabled");
    	$('#company_profile_update').removeAttr("disabled");
    	$('input[type^=checkbox]').removeAttr("disabled");
    	$('#company_profile_edit').addClass('d-none');
    	$('#cash_on_hand').removeAttr("disabled");
	});

	function fileValidation() {
        var fileInput = 
            document.getElementById('company_logo');
          
        var filePath = fileInput.value;
      
        // Allowing file type
        var allowedExtensions = /(\.jpeg|\.jpg|\.png)$/i;
          
        if (!allowedExtensions.exec(filePath)) {
            //alert('Invalid file type');
            $('#company_logo-error').html('Invalid File! [Use .jpeg/ .jpg/ .png]');
            $('#company_logo-error').addClass('text-danger');
            fileInput.value = '';
            return false;
        }else{
        	$('#company_logo-error').html('');
            $('#company_logo-error').removeClass('text-danger');
            let img = new Image()
			img.src = window.URL.createObjectURL(event.target.files[0])
			img.onload = () => {
			   if (img.width > 330 || img.height > 100) {
				   	$('#company_logo-error').html('Too large Image! [Select in 330*100]');
		            $('#company_logo-error').addClass('text-danger');
			   		fileInput.value = '';
		            return false;
			   }else{
				   	$('#company_logo-error').html('');
		            $('#company_logo-error').removeClass('text-danger');
			   }
			   //alert(img.width + " " + img.height);
			}
        }
    }
</script>
<?php include_once 'ltr/header-footer.php'; ?>
</body>
</html>