<?php 
	include_once 'ltr/header.php';
	include_once 'connection.php';
	error_reporting(E_ERROR | E_PARSE);

	$alertMsg = "";
	$alertClass = "";
	/* var_dump($_SERVER['CONTENT_LENGTH']);
    var_dump($_REQUEST); */

	if (isset($_POST['editUserbtn'])) {
		if (isset($_POST['userEditID'])) {
			$fetch_data = "SELECT * FROM `users` WHERE `id` = '".$_POST['userEditID']."'";
			$run_fetch_data = mysqli_query($con,$fetch_data);
			$row = mysqli_fetch_array($run_fetch_data);
			$edit_firstname = $row['firstname'];
			$edit_middlename = $row['middlename'];
			$edit_lastname = $row['lastname'];
			$edit_department = $row['department'];
			$edit_designation = $row['designation'];
			$edit_user_name = $row['username'];
			$edit_add_mobile = $row['mobile'];
			$admin=$row['type'];
			$edit_previous_password = $row['password'];
			$edit_reports = $row['reports'];
			$edit_client_master = $row['client_master'];
			$edit_supplier_master = $row['vendor_master'];
			$edit_dsc_subscriber = $row['dsc_subscriber'];
			$edit_add_taskmanager = $row['add_taskmanager'];
			$edit_dsc_reseller = $row['dsc_reseller'];
			$edit_pan = $row['pan'];
			$edit_tan = $row['tan'];
			$edit_it_returns = $row['it_returns'];
			$edit_e_tds = $row['e_tds'];
			$edit_gst = $row['gst'];
			$edit_other_services = $row['other_services'];
			$edit_psp = $row['psp'];
			$edit_psp_coupon_consumption = $row['psp_coupon_consumption'];
			$edit_financial_records = $row['financial_records'];
			$edit_payment = $row['payment'];
			$edit_e_tender = $row['e_tender'];
			$edit_trade_mark=$row['trade_mark'];
            $edit_patent=$row['patent'];
            $edit_copy_right=$row['copy_right'];
            $edit_trade_secret=$row['trade_secret'];
            $edit_industrial_design=$row['industrial_design'];
            $edit_legal_notice=$row['legal_notice'];
			$edit_document_records = $row['document_records'];
			$edit_audit = $row['audit'];
			$edit_contact_client = $row['contact_client'];
			$edit_other_transaction = $row['other_transaction'];
			$edit_add_users = $row['add_users'];
			$edit_company_profile = $row['company_profile'];
			$edit_payroll = $row['payroll'];
			$edit_outstanding = $row['outstanding'];
			$edit_whatsapp = $row['whatsapp'];
			$edit_crm_data_record = $row['data_record'];
			$edit_crm_rec_tranf = $row['record_transfer'];
			$edit_crm_trace_cont = $row['trace_contact'];
			$edit_add_clientConfig = $row['add_clientConfig'];
			$edit_add_passMang = $row['add_passMang'];
			$edit_add_enquiry = $row['add_enquiry'];
			$edit_add_jobProg = $row['add_jobProg'];
			$edit_addFix_meeting = $row['addFix_meeting'];
			$edit_mom_admin = $row['mom_admin'];
			$edit_add_Admin_filter = $row['add_Admin_filter'];
			$edit_addBidding = $row['addBidding'];
			$edit_settlement = $row['settlement'];
			$edit_expense = $row['expense'];
			$edit_contra_voucher = $row['contra_voucher'];
			$edit_bank_report = $row['bank_report'];
			$edit_ticket = $row['tickets'];
			$edit_mail_panel = $row['mail_panel'];
			$edit_api_setup = $row['api_setup'];
			$edit_depart_panel = $row['depart_panel'];
			$edit_desig_panel = $row['design_panel'];
			$edit_soft_export = $row['soft_export'];
			
			$edit_esp_latest_sales = $row['esp_latest_sales'];
			$edit_esp_income_expense = $row['esp_income_expense'];
			$edit_esp_payment_received = $row['esp_payment_received'];
			$edit_esp_payment_paid = $row['esp_payment_paid'];
			$edit_esp_highest_outstand = $row['esp_highest_outstanding'];
			$edit_esp_oto_board = $row['esp_oto_board'];
			$edit_esp_latest_enquiry = $row['esp_latest_enquiry'];
			$edit_esp_search_client = $row['esp_search_client'];
			$edit_esp_trading_inventory = $row['esp_trading_invent'];
			$edit_esp_bank_balance = $row['esp_bank_balance'];
			$edit_addtl = $row['crm_teamleader'];
			$edit_tlMember = explode(',',$row['crm_teamMember']);
			$edit_esp_attendence = $row['esp_attendence_graph'];
			$edit_ca_dashboard = $row['ca_dashboard'];
			$fetchClientIds = "SELECT * FROM `client_master` WHERE FIND_IN_SET('".$_POST['userEditID']."',users_access) AND `company_id` = '".$_SESSION['company_id']."'";
			$run_fetchClientIds = mysqli_query($con, $fetchClientIds);
			$SelectedClientIds = [];
			$Pre_UsersAccess_Clients = [];
			while ($row_fetchClientIds = mysqli_fetch_array($run_fetchClientIds)) {
				array_push($SelectedClientIds, $row_fetchClientIds['client_name']);
				array_push($Pre_UsersAccess_Clients, [$row_fetchClientIds['client_name'], $row_fetchClientIds['users_access']]);
			}
			$fetchVendorIds = "SELECT * FROM `vendor_master` WHERE FIND_IN_SET('".$_POST['userEditID']."',users_access) AND `company_id` = '".$_SESSION['company_id']."'";
			$run_fetchVendorIds = mysqli_query($con, $fetchVendorIds);
			$SelectedVendorIds = [];
			$Pre_UsersAccess_Vendors = [];
			while ($row_fetchVendorIds = mysqli_fetch_array($run_fetchVendorIds)) {
				array_push($SelectedVendorIds, $row_fetchVendorIds['client_name']);
				array_push($Pre_UsersAccess_Vendors, $row_fetchVendorIds['users_access']);
			}
		}
	}
	
	if (isset($_POST['userEditID_temp'])) {
		// echo "here";
		$firstname = $_POST['firstname'];
		$middlename = $_POST['middlename'];
		$lastname = $_POST['lastname'];
		$department = $_POST['department'];
		$designation = $_POST['designation'];
		$mobile = $_POST['mobile_no'];
		$crm_tl_member = implode(',',$_POST['crm_tl_member']);
		if (!empty($_POST['client_name'])) {
			$client_name = $_POST['client_name'];
		}else{
			$client_name = [];
		}
		if (!empty($_POST['vendor_name'])) {
			$vendor_name = $_POST['vendor_name'];
		}else{
			$vendor_name = [];
		}
		$user_name = $_POST['user_name'];
		if (isset($_POST['password']) && $_POST['password'] != "") {
			$password = sha1($_POST['password']);
		}else{
			$password = $_POST['previous_password'];
		}
		if (isset($_POST['re_type_password']) && $_POST['password'] != "") {
			$re_type_password = sha1($_POST['re_type_password']);
		}else{
			$re_type_password = $_POST['previous_password'];
		}
		if ($password != $re_type_password) {
			$alertMsg = "Password & Re-type password must be same!";
			$alertClass = "alert alert-danger";
			$reopen_firstname = $_POST['firstname'];
			$reopen_lastname = $_POST['lastname'];
			$reopen_user_name = $_POST['user_name'];
			$reopen_password = $_POST['password'];
			$reopen_re_type_password = $_POST['re_type_password'];
			$reopen_mobile = $_POST['mobile_no'];
			$last_password = $_POST['previous_password'];
			if (isset($_POST['reports'])) {
				$reopen_reports = $_POST['reports'];
			}
			if (isset($_POST['client_master'])) {
				$reopen_client_master = $_POST['client_master'];
			}
			if (isset($_POST['supplier_master'])) {
				$reopen_supplier_master = $_POST['supplier_master'];
			}
			if (isset($_POST['dsc_subscriber'])) {
				$reopen_dsc_subscriber = $_POST['dsc_subscriber'];
			}
			if (isset($_POST['dsc_reseller'])) {
				$reopen_dsc_reseller = $_POST['dsc_reseller'];
			}
			if (isset($_POST['pan'])) {
				$reopen_pan = $_POST['pan'];
			}
			if (isset($_POST['tan'])) {
				$reopen_tan = $_POST['tan'];
			}
			if (isset($_POST['it_returns'])) {
				$reopen_it_returns = $_POST['it_returns'];
			}
			if (isset($_POST['financial_records'])) {
				$reopen_financial_records = $_POST['financial_records'];
			}
			if (isset($_POST['e_tender'])) {
				$reopen_e_tender = $_POST['e_tender'];
			}
			if (isset($_POST['trade_mark'])) {
				$reopen_trade_mark = $_POST['trade_mark'];
			}
			if (isset($_POST['industrial_design'])) {
				$reopen_industrial_design = $_POST['industrial_design'];
			} 
			if (isset($_POST['legal_notice'])) {
				$reopen_legal_notice = $_POST['legal_notice'];
			}
			if (isset($_POST['patent'])) {
				$reopen_patent = $_POST['patent'];
			}
			if (isset($_POST['copy_right'])) {
				$reopen_copy_right = $_POST['copy_right'];
			}
			if (isset($_POST['trade_secret'])) {
				$reopen_trade_secret = $_POST['trade_secret'];
			}
			if (isset($_POST['contact_client'])) {
				$reopen_contact_client = $_POST['contact_client'];
			}
			if (isset($_POST['e_tds'])) {
				$reopen_e_tds = $_POST['e_tds'];
			}
			if (isset($_POST['document_records'])) {
				$reopen_document_records = $_POST['document_records'];
			}
			if (isset($_POST['gst'])) {
				$reopen_gst = $_POST['gst'];
			}
			if (isset($_POST['other_services'])) {
				$reopen_other_services = $_POST['other_services'];
			}
			if (isset($_POST['psp'])) {
				$reopen_psp = $_POST['psp'];
			}
			if (isset($_POST['psp_coupon_consumption'])) {
				$reopen_psp_coupon_consumption = $_POST['psp_coupon_consumption'];
			}
			if (isset($_POST['payment'])) {
				$reopen_payment = $_POST['payment'];
			}
			if (isset($_POST['audit'])) {
				$reopen_audit = $_POST['audit'];
			}
			if (isset($_POST['other_transaction'])) {
				$reopen_other_transaction = $_POST['other_transaction'];
			}
			if (isset($_POST['add_users'])) {
				$reopen_add_users = $_POST['add_users'];
			}
			if (isset($_POST['company_profile'])) {
				$reopen_company_profile = $_POST['company_profile'];
			}
			if (isset($_POST['payroll'])) {
				$reopen_payroll = $_POST['payroll'];
			}
			if (isset($_POST['add_taskM'])) {
				$reopen_add_taskM = $_POST['add_taskM'];
			}
            if (isset($_POST['add_passMang'])) {
				$reopen_add_passMang = $_POST['add_passMang'];
			}
			if (isset($_POST['outstanding'])) {
				$reopen_outstanding = $_POST['outstanding'];
			}
			
            /*CRM PART CODE*/
            if (isset($_POST['crm_clientConfig'])) {
				$reopen_add_clientConfig = $_POST['crm_clientConfig'];
			}
			if (isset($_POST['crm_enq'])) {
				$reopen_enquiry = $_POST['crm_enq'];
			}
			if (isset($_POST['crm_job'])) {
				$reopen_add_jobProg = $_POST['crm_job'];
			}
			if (isset($_POST['crm_admin_mom'])) {
				$reopen_mom_admin = $_POST['crm_admin_mom'];
			}
			if (isset($_POST['crm_admin_filter'])) {
				$reopen_add_Admin_filter = $_POST['crm_admin_filter'];
			}
			if (isset($_POST['crm_fix_meeting'])) {
				$reopen_addFix_meeting = $_POST['crm_fix_meeting'];
			}
			if (isset($_POST['crm_bidding'])) {
				$reopen_addBidding = $_POST['crm_bidding'];
			}
			if (isset($_POST['whatsapp'])) {
				$reopen_whatsapp = $_POST['whatsapp'];
			}
			if (isset($_POST['crm_data_record'])) {
				$reopen_crm_data_record = $_POST['crm_data_record'];
			}
			if (isset($_POST['crm_rec_tranf'])) {
				$reopen_crm_rec_tranf = $_POST['crm_rec_tranf'];
			}
			if (isset($_POST['crm_trace_cont'])) {
				$reopen_crm_trace_cont = $_POST['crm_trace_cont'];
			}
			if (isset($_POST['settlement'])) {
				$reopen_settlement = $_POST['settlement'];
			}
			if (isset($_POST['expense'])) {
				$reopen_expense = $_POST['expense'];
			}
			if (isset($_POST['contra_voucher'])) {
				$reopen_contra_voucher = $_POST['contra_voucher'];
			}
			if (isset($_POST['bank_report'])) {
				$reopen_bank_report = $_POST['bank_report'];
			}
			if (isset($_POST['ticket'])) {
				$reopen_ticket = $_POST['ticket'];
			}
			if (isset($_POST['mail_panel'])) {
				$reopen_mail_panel = $_POST['mail_panel'];
			}
			if (isset($_POST['api_setup'])) {
				$reopen_api_setup = $_POST['api_setup'];
			}
			if (isset($_POST['depart_panel'])) {
				$reopen_depart_panel = $_POST['depart_panel'];
			}
			if (isset($_POST['desig_panel'])) {
				$reopen_desig_panel = $_POST['desig_panel'];
			}
			if (isset($_POST['soft_export'])) {
				$reopen_soft_export = $_POST['soft_export'];
			}
			
			if (isset($_POST['esp_latest_sales'])) {
				$reopen_esp_latest_sales = $_POST['esp_latest_sales'];
			}
			if (isset($_POST['esp_income_expense'])) {
				$reopen_esp_income_expense = $_POST['esp_income_expense'];
			}
			if (isset($_POST['esp_payment_received'])) {
				$reopen_esp_payment_received = $_POST['esp_payment_received'];
			}
			if (isset($_POST['esp_payment_paid'])) {
				$reopen_esp_payment_paid = $_POST['esp_payment_paid'];
			}
			if (isset($_POST['esp_highest_outstand'])) {
				$reopen_esp_highest_outstand = $_POST['esp_highest_outstand'];
			}
			if (isset($_POST['esp_oto_board'])) {
				$reopen_esp_oto_board = $_POST['esp_oto_board'];
			}
			if (isset($_POST['esp_latest_enquiry'])) {
				$reopen_esp_latest_enquiry = $_POST['esp_latest_enquiry'];
			}
			if (isset($_POST['esp_search_client'])) {
				$reopen_esp_search_client = $_POST['esp_search_client'];
			}
			if (isset($_POST['esp_trading_inventory'])) {
				$reopen_esp_trading_inventory = $_POST['esp_trading_inventory'];
			}
			if (isset($_POST['esp_bank_balance'])) {
				$reopen_esp_bank_balance = $_POST['esp_bank_balance'];
			}
			if (isset($_POST['crm_tl'])) {
				$reopen_addtl = $_POST['crm_tl'];
			}
			if (isset($_POST['esp_attendence'])) {
				$reopen_esp_attendence = $_POST['esp_attendence'];
			}
			if (isset($_POST['ca_dashboard'])) {
				$reopen_ca_dashboard = $_POST['ca_dashboard'];
			}
		}else{
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
			if(!isset($_POST['supplier_master']))
			{
			     $supplier_master = 0;
			} else {
			     $supplier_master = $_POST['supplier_master'];
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
			if(!isset($_POST['financial_records']))
			{
			     $financial_records = 0;
			} else {
			     $financial_records = $_POST['financial_records'];
			}
			if(!isset($_POST['e_tender']))
			{
			     $e_tender = 0;
			} else {
			     $e_tender = $_POST['e_tender'];
			}
			if(!isset($_POST['contact_client']))
			{
			     $contact_client = 0;
			} else {
			     $contact_client = $_POST['contact_client'];
			}
			//$tan = $_POST['tan'];
			if(!isset($_POST['it_returns']))
			{
			     $it_returns = 0;
			} else {
			     $it_returns = $_POST['it_returns'];
			}
			if(!isset($_POST['document_records']))
			{
			     $document_records = 0;
			} else {
			     $document_records = $_POST['document_records'];
			}
			//$it_returns = $_POST['it_returns'];
			if(!isset($_POST['e_tds']))
			{
			     $e_tds = 0;
			} else {
			     $e_tds = $_POST['e_tds'];
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
			if(!isset($_POST['trade_mark']))
			{
			     $trade_mark = 0;
			} else {
			     $trade_mark = $_POST['trade_mark'];
			}
			if(!isset($_POST['industrial_design']))
			{
			     $industrial_design = 0;
			} else {
			     $industrial_design = $_POST['industrial_design'];
			}
			if(!isset($_POST['legal_notice']))
			{
			     $legal_notice = 0;
			} else {
			     $legal_notice = $_POST['legal_notice'];
			}
			if(!isset($_POST['patent']))
			{
			     $patent = 0;
			} else {
			     $patent = $_POST['patent'];
			}
			if(!isset($_POST['copy_right']))
			{
			     $copy_right = 0;
			} else {
			     $copy_right = $_POST['copy_right'];
			}
			if(!isset($_POST['trade_secret']))
			{
			     $trade_secret = 0;
			} else {
			     $trade_secret = $_POST['trade_secret'];
			}
			if(!isset($_POST['other_transaction']))
			{
			     $other_transaction = 0;
			} else {
			     $other_transaction = $_POST['other_transaction'];
			}
			//$audit = $_POST['audit'];
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
			if(!isset($_POST['add_passMang']))
			{
			     $add_passMang = 0;
			} else {
			     $add_passMang = $_POST['add_passMang'];
			}
			if(!isset($_POST['outstanding']))
			{
			     $outstanding = 0;
			} else {
			     $outstanding = $_POST['outstanding'];
			}
			
            // CRM PART CODE
            
            if(!isset($_POST['crm_clientConfig']))
			{
			     $crm_clientConfig = 0;
			} else {
			     $crm_clientConfig = $_POST['crm_clientConfig'];
			}
			if(!isset($_POST['crm_enq']))
			{
			     $crm_enq = 0;
			} else {
			     $crm_enq = $_POST['crm_enq'];
			}
			if(!isset($_POST['crm_job']))
			{
			     $crm_job = 0;
			} else {
			     $crm_job = $_POST['crm_job'];
			}
			if(!isset($_POST['crm_admin_mom']))
			{
			     $crm_admin_mom = 0;
			} else {
			     $crm_admin_mom = $_POST['crm_admin_mom'];
			}
			if(!isset($_POST['crm_admin_filter']))
			{
			     $crm_admin_filter = 0;
			} else {
			     $crm_admin_filter = $_POST['crm_admin_filter'];
			}
			if(!isset($_POST['crm_fix_meeting']))
			{
			     $crm_fix_meeting = 0;
			} else {
			     $crm_fix_meeting = $_POST['crm_fix_meeting'];
			}
			if(!isset($_POST['crm_bidding']))
			{
			     $crm_bidding = 0;
			} else {
			     $crm_bidding = $_POST['crm_bidding'];
			}
			if(!isset($_POST['whatsapp']))
			{
			     $whatsapp = 0;
			} else {
			     $whatsapp = $_POST['whatsapp'];
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
			if(!isset($_POST['crm_trace_cont']))
			{
			     $crm_trace_cont = 0;
			} else {
			     $crm_trace_cont = $_POST['crm_trace_cont'];
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
			if(!isset($_POST['ticket']))
			{
			     $ticket = 0;
			} else {
			     $ticket = $_POST['ticket'];
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
			
			if(!isset($_POST['esp_latest_sales']))
			{
			     $esp_latest_sales = 0;
			} else {
			     $esp_latest_sales = $_POST['esp_latest_sales'];
			}
			if(!isset($_POST['esp_income_expense']))
			{
			     $esp_income_expense = 0;
			} else {
			     $esp_income_expense = $_POST['esp_income_expense'];
			}
			if(!isset($_POST['esp_payment_received']))
			{
			     $esp_payment_received = 0;
			} else {
			     $esp_payment_received = $_POST['esp_payment_received'];
			}
			if(!isset($_POST['esp_payment_paid']))
			{
			     $esp_payment_paid = 0;
			} else {
			     $esp_payment_paid = $_POST['esp_payment_paid'];
			}
			if(!isset($_POST['esp_highest_outstand']))
			{
			     $esp_highest_outstand = 0;
			} else {
			     $esp_highest_outstand = $_POST['esp_highest_outstand'];
			}
			if(!isset($_POST['esp_oto_board']))
			{
			     $esp_oto_board = 0;
			} else {
			     $esp_oto_board = $_POST['esp_oto_board'];
			}
			if(!isset($_POST['esp_latest_enquiry']))
			{
			     $esp_latest_enquiry = 0;
			} else {
			     $esp_latest_enquiry = $_POST['esp_latest_enquiry'];
			}
			if(!isset($_POST['esp_search_client']))
			{
			     $esp_search_client = 0;
			} else {
			     $esp_search_client = $_POST['esp_search_client'];
			}
			if(!isset($_POST['esp_trading_inventory']))
			{
			     $esp_trading_inventory = 0;
			} else {
			     $esp_trading_inventory = $_POST['esp_trading_inventory'];
			}
			if(!isset($_POST['esp_bank_balance']))
			{
			     $esp_bank_balance = 0;
			} else {
			     $esp_bank_balance = $_POST['esp_bank_balance'];
			}
			if(!isset($_POST['crm_tl']))
			{
			     $crm_tl = 0;
			} else {
			     $crm_tl = $_POST['crm_tl'];
			}
			if(!isset($_POST['esp_attendence']))
			{
			     $esp_attendence = 0;
			} else {
			     $esp_attendence = $_POST['esp_attendence'];
			}
			if(!isset($_POST['ca_dashboard']))
			{
			     $ca_dashboard = 0;
			} else {
			     $ca_dashboard = $_POST['ca_dashboard'];
			}
			//$company_profile = $_POST['company_profile'];
			$fetch_email = "(SELECT DISTINCT `email_id` FROM `company_profile` WHERE `email_id` = '".$user_name."' AND `id` != '".$_POST['userEditID_temp']."') UNION (SELECT DISTINCT `username` FROM `users` WHERE `username` = '".$user_name."' AND `id` != '".$_POST['userEditID_temp']."')";
			$run_fetch_email = mysqli_query($con,$fetch_email);
			$rowEmail = mysqli_num_rows($run_fetch_email);
			if ($rowEmail > 0) {
				$alertMsg = "User already exist..!";
				$alertClass = "alert alert-danger";
			}else{
				$fetchDepartmentShortName = "SELECT * FROM `department` WHERE `department_name` = '".$department."' AND `company_id` = '".$_SESSION['company_id']."'";
				$run_fetchDepartmentShortName = mysqli_query($con, $fetchDepartmentShortName);
				$fetchDepartmentShortName_Row = mysqli_fetch_array($run_fetchDepartmentShortName);
				
				$fetchPreviousDepartment = "SELECT * FROM `users` WHERE `id` = '".$_POST['userEditID_temp']."'";
				$runPreviousDepartment = mysqli_query($con, $fetchPreviousDepartment);
				$PreviousDepartment_row = mysqli_fetch_array($runPreviousDepartment);
				// echo $PreviousDepartment_row['department'];
				if ($PreviousDepartment_row['department'] != $department) {
					$fetchUser_Id = "SELECT MAX(Substring(`user_id`, LOCATE('_', `user_id`)+1, length(`user_id`))) As `user_id` FROM `users` WHERE `company_id` = '".$_SESSION['company_id']."' AND `department` = '".$department."' AND `user_id` != '' AND `id` != '".$_POST['userEditID_temp']."'";
					// echo $fetchUser_Id;
					$runUser_Id = mysqli_query($con, $fetchUser_Id);
					$User_Id_row = mysqli_fetch_array($runUser_Id);
					// $LastUserId = substr($User_Id_row['user_id'], strpos($User_Id_row['user_id'], "_") + 1) + 1;
					$LastUserId = $User_Id_row['user_id'] + 1;
					// echo $LastUserId;
					$user_id = '';
					if ($User_Id_row['user_id'] == '') {
						$user_id = $fetchDepartmentShortName_Row['department_shortname'].'_1';
					}else{
						$user_id = $fetchDepartmentShortName_Row['department_shortname'].'_'.$LastUserId;
					}
				}else{
					$user_id = $PreviousDepartment_row['user_id'];
				}
				// echo "User id ".$user_id;
                
			    $user_update_query = "UPDATE `users` SET `ca_dashboard` = '".$ca_dashboard."',`esp_attendence_graph` = '".$esp_attendence."',`crm_teamMember` = '".$crm_tl_member."',`firstname` = '".$firstname."', `crm_teamleader`= '".$crm_tl."',`trade_mark`='" . $trade_mark . "',`patent`='" . $patent . "',`copy_right`='" . $copy_right . "',`industrial_design`='" . $industrial_design . "',`legal_notice`='".$legal_notice."',`trade_secret`='" . $trade_secret . "',`middlename` = '".$middlename."', `lastname` = '".$lastname."',`user_id` = '".$user_id."',`department` = '".$department."', `designation` = '".$designation."', `username` = '".$user_name."',`mobile` = '".$mobile."', `password` = '".$password."', `reports` = '".$reports."', `client_master` = '".$client_master."', `dsc_subscriber` = '".$dsc_subscriber."', `dsc_reseller` = '".$dsc_reseller."', `pan` = '".$pan."', `tan` = '".$tan."', `it_returns` = '".$it_returns."', `e_tds` = '".$e_tds."', `gst` = '".$gst."', `other_services` = '".$other_services."', `psp` = '".$psp."', `psp_coupon_consumption` = '".$psp_coupon_consumption."', `payment` = '".$payment."', `audit` = '".$audit."', `other_transaction` = '".$other_transaction."', `add_users` = '".$add_users."', `company_profile` = '".$company_profile."', `payroll` = '".$payroll."',`financial_records` = '".$financial_records."',`document_records` = '".$document_records."',`contact_client` = '".$contact_client."',`e_tender` = '".$e_tender."',`add_taskmanager` = '".$add_taskM."',`add_clientConfig` = '".$crm_clientConfig."',`add_passMang` = '".$add_passMang."',`add_enquiry` = '".$crm_enq."',`add_jobProg` = '".$crm_job."',`addFix_meeting` = '".$crm_fix_meeting."',`mom_admin` = '".$crm_admin_mom."',`add_Admin_filter` = '".$crm_admin_filter."',`addBidding` = '".$crm_bidding."',`vendor_master` = '".$supplier_master."',`outstanding` = '".$outstanding."',`whatsapp` = '".$whatsapp."',`data_record` = '".$crm_data_record."',`record_transfer` = '".$crm_rec_tranf."',`trace_contact` = '".$crm_trace_cont."',`settlement` = '".$settlement."',`expense` = '".$expense."',`contra_voucher` = '".$contra_voucher."',`bank_report` = '".$bank_report."',`tickets` = '".$ticket."',`mail_panel` = '".$mail_panel."',`api_setup` = '".$api_setup."',`depart_panel` = '".$depart_panel."',`design_panel` = '".$desig_panel."',`soft_export` = '".$soft_export."',`esp_latest_sales` = '".$esp_latest_sales."',`esp_income_expense` = '".$esp_income_expense."',`esp_payment_received` = '".$esp_payment_received."',`esp_payment_paid` = '".$esp_payment_paid."',`esp_highest_outstanding` = '".$esp_highest_outstand."',`esp_oto_board` = '".$esp_oto_board."',`esp_latest_enquiry` = '".$esp_latest_enquiry."',`esp_search_client` = '".$esp_search_client."',`esp_trading_invent` = '".$esp_trading_inventory."',`esp_bank_balance` = '".$esp_bank_balance."' WHERE `id` = '".$_POST['userEditID_temp']."'";
				$run_user_update = mysqli_query($con,$user_update_query);
				// $run_user_update = false;
				// echo $user_update_query;
				if ($run_user_update) {
					$alertMsg = "Record Updated";
					$alertClass = "alert alert-success";
				}
			}
		}
	}
	if (isset($_POST['user_delete'])) {
		if (isset($_POST['tempUserIDdel'])) {
			$deleteUser_query = "DELETE FROM `users` WHERE `id` = '".$_POST['tempUserIDdel']."'";
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
		<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
		<link rel="stylesheet" href="..//js/virtual-select1.min.css">
	<!--script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script-->
	<style>
		td {
			padding-right: 20px;
		}
		.client_multiple_select
        {
            height: 110px !important;
            width: 90%;
            overflow: auto;
            -webkit-appearance: menulist;
            position: relative;
        }
        .client_multiple_select::before
        {
            //content: var(--text);
            display: block;
          margin-left: 5px;
          margin-bottom: 2px;
        }
        .client_multiple_select_active
        {
            //overflow: visible !important;
            overflow-y: scroll;
        }
        .client_multiple_select option
        {
            //display: none;
            height: 18px;
            background-color: white;
        }
        .client_multiple_select_active option
        {
            display: block;
        }

        .client_multiple_select option::before {
          font-family: "Font Awesome 5 Free"; 
          content: "\f0c8 ";
          width: 1.3em;
          text-align: center;
          display: inline-block;
        }
        .client_multiple_select option:checked::before {
          font-family: "Font Awesome 5 Free"; 
          content: "\f14a ";
        }

		/* Vendor Checkboxes */
		.vendor_multiple_select
        {
            height: 110px !important;
            width: 90%;
            overflow: auto;
            -webkit-appearance: menulist;
            position: relative;
        }
        .vendor_multiple_select::before
        {
            //content: var(--text);
            display: block;
          margin-left: 5px;
          margin-bottom: 2px;
        }
        .vendor_multiple_select_active
        {
            //overflow: visible !important;
            overflow-y: scroll;
        }
        .vendor_multiple_select option
        {
            //display: none;
            height: 18px;
            background-color: white;
        }
        .vendor_multiple_select_active option
        {
            display: block;
        }

        .vendor_multiple_select option::before {
          font-family: "Font Awesome 5 Free"; 
          content: "\f0c8 ";
          width: 1.3em;
          text-align: center;
          display: inline-block;
        }
        .vendor_multiple_select option:checked::before {
          font-family: "Font Awesome 5 Free"; 
          content: "\f14a ";
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
	<div id='EditUserDiv'></div>
	<h2 align="center" class="pageHeading" id="pageHeading">Users</h2>
		<div class="row border justify-content-center" id="after-heading">
			<div class="col-sm-12 col-lg-12">
				<?php if (isset($_POST['user_save']) || isset($_POST['userEditID_temp']) || isset($_POST['user_delete'])) { ?>
					<div class="<?php echo $alertClass; ?> alert-dismissible" role="alert">
					  <?php echo $alertMsg; ?>
					  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
					    <span aria-hidden="true">&times;</span>
					  </button>
					</div>
				<?php } ?>
			</div>
			<div class="modal status_cap" id="status_cap" tabindex="-1" role="dialog">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title"><input type="text" id="clientNameStatusChanging" readonly style="border:none;"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                   <center>  <h3>Captcha:-</h3><p id="cachePaste" class="cachePaste unselectable"><button type="button" onClick="GFG_Fun()"><i class="fa-solid fa-rotate"></i><input type="hidden" id="cachePaste" value=""></button>
                        </p>
	        <input type="hidden" readonly id="tempMultipleIDdel" name="tempMultipleIDdel" class="tempMultipleIDdel">
	        <div class="form-group d-block">
					    <input type="text" name="captche" class="form-control w-100 cachePaste" required id="testCap" aria-describedby="emailHelp" placeholder="Enter Captcha" <?php if (isset($_POST['editUserbtn'])) {echo "value=".$edit_user_name;} if (isset($reopen_user_name)) {echo "value=".$reopen_user_name;}?>>
						<span id="user_name_status"></span>
					</div>
	        <p id="DeleteConfirmMsg">Verify Captcha To Activate | Inactivate Client ?</p>
              </div>
              <div class="modal-footer">
              </div>
            </div>
          </div>
        </div>
                <div class="modal status_cap1" id="status_cap1" tabindex="-1" role="dialog">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title"><input type="text" id="clientNameStatusChanging1" readonly style="border:none;"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                   <center>  <h3>Captcha:-</h3><p id="cachePaste1" class="cachePaste1 unselectable"><button type="button" onClick="GFG_Fun1()"><i class="fa-solid fa-rotate"></i><input type="text" id="cachePaste1" value=""></button>
                        </p>
	        <input type="hidden" readonly id="tempMultipleIDdel" name="tempMultipleIDdel" class="tempMultipleIDdel">
	        <div class="form-group d-block">
					    <input type="text" name="captche" class="form-control w-100 cachePaste1" required id="testCap1" aria-describedby="emailHelp" placeholder="Enter Captcha" <?php if (isset($_POST['editUserbtn'])) {echo "value=".$edit_user_name;} if (isset($reopen_user_name)) {echo "value=".$reopen_user_name;}?>>
						<span id="user_name_status"></span>
					</div>
	        <p id="DeleteConfirmMsg">Verify Captcha To Activate | Inactivate Client ?</p>
              </div>
              <div class="modal-footer">
              </div>
            </div>
          </div>
        </div>
			<form method="post" class="col-lg-12 col-sm-12 d-none" id="addNew_users" action="">
				<input type="hidden" readonly name="userEditID_temp" id="userEditID_temp" value="<?php if (isset($_POST['editUserbtn'])) echo $_POST['userEditID']; ?>">
				<div class="form-inline">
					<div class="form-group d-block col-md-3">
					    <label for="firstname" class="float-left p-2">Firstname <span style="color: red;" class="pl-1">*</span></label>
					    <input type="text" name="firstname" class="form-control w-100" required id="firstname" aria-describedby="emailHelp" placeholder="Enter Firstname" <?php if (isset($_POST['editUserbtn'])) {echo "value=".$edit_firstname;} if (isset($reopen_firstname)) {echo "value=".$reopen_firstname;}?>>
					</div>
					<div class="form-group d-block col-md-3">
					    <label for="middlename" class="float-left p-2">Middlename <span style="color: red;" class="pl-1">*</span></label>
					    <input type="text" name="middlename" class="form-control w-100" required id="middlename" aria-describedby="emailHelp" placeholder="Enter Lastname" <?php if (isset($_POST['editUserbtn'])) {echo "value=".$edit_middlename;} if (isset($reopen_middlename)) {echo "value=".$reopen_middlename;}?>>
					</div>
					<div class="form-group d-block col-md-3">
					    <label for="lastname" class="float-left p-2">Lastname (Surname) <span style="color: red;" class="pl-1">*</span></label>
					    <input type="text" name="lastname" class="form-control w-100" required id="lastname" aria-describedby="emailHelp" placeholder="Enter Lastname" <?php if (isset($_POST['editUserbtn'])) {echo "value=".$edit_lastname;} if (isset($reopen_lastname)) {echo "value=".$reopen_lastname;}?>>
					</div>
					<div class="form-group d-block col-md-3">
					    <label for="department" class="float-left p-2">Department <span style="color: red;" class="pl-1">*</span></label>
						<?php 
							$fetchDepartment = "SELECT * FROM `department` WHERE `company_id` = '".$_SESSION['company_id']."'";
							$runFetchDepartment = mysqli_query($con, $fetchDepartment);

						?>
					    <select required name="department" id="department" class="form-control w-100">
							<?php
								while ($DepartmentRow = mysqli_fetch_array($runFetchDepartment)) { ?>
									<option value="<?= $DepartmentRow['department_name']; ?>" <?php if (isset($_POST['editUserbtn'])) { if ($DepartmentRow['department_name'] == $edit_department) { echo 'selected'; }} ?>><?= $DepartmentRow['department_name']; ?></option>
							<?php } ?>
						</select>
					</div>
					<div class="form-group d-block col-md-3">
					    <label for="designation" class="float-left p-2">Designation <span style="color: red;" class="pl-1">*</span></label>
						<?php 
							$fetchDesignation = "SELECT * FROM `designation` WHERE `company_id` = '".$_SESSION['company_id']."'";
							$runFetchDesignation = mysqli_query($con, $fetchDesignation);

						?>
					    <select required name="designation" id="designation" class="form-control w-100">
							<?php
								while ($DesignationRow = mysqli_fetch_array($runFetchDesignation)) { ?>
									<option value="<?= $DesignationRow['designation_name']; ?>" <?php if (isset($_POST['editUserbtn'])) { if ($DesignationRow['designation_name'] == $edit_designation) { echo 'selected'; }} ?>><?= $DesignationRow['designation_name']; ?></option>
							<?php } ?>
						</select>
					</div>

					<div class="form-group d-block col-md-3">
						<label for="user_name" class="float-left p-2">Username <span style="color: red;" class="pl-1">*</span></label>
					    <input type="email" name="user_name" class="form-control w-100" required id="user_name" aria-describedby="emailHelp" placeholder="Enter Username"
                    <?php
                      if (isset($_POST['editUserbtn']) || isset($reopen_user_name)) {
                        echo "value='" . htmlspecialchars($edit_user_name ?? $reopen_user_name, ENT_QUOTES) . "' readonly";
                      }
                    ?>>

						<span id="user_name_status"></span>
					</div>
					<div class="form-group d-block col-md-3">
						<input type="hidden" readonly name="previous_password" id="previous_password" <?php if (isset($_POST['editUserbtn'])) {echo "value=".$edit_previous_password;} if (isset($last_password)) {echo "value=".$last_password;}?>>
					    <label for="previous_password" class="float-left p-2">Password <span style="color: red;" class="pl-1">*</span></label>
						<div class="input-group w-100" id="show_hide_password">
							<input type="password" name="password" class="form-control" id="password" aria-describedby="emailHelp" placeholder="Enter Password" <?php if (!isset($_POST['editUserbtn']) || isset($reopen_user_name)) {echo "required";} if (isset($reopen_password)) {echo "value=".$reopen_password;}?>>
							<div class="input-group-append">
								<span class="input-group-text"><a href="" id="add_acc_passLink"><i class="fa fa-eye-slash" aria-hidden="true"></i></a></span>
							</div>
						</div>
					</div>
					<div class="form-group d-block col-md-3">
					    <label for="re_type_password" class="float-left p-2">Re-type Password <span style="color: red;" class="pl-1">*</span></label>
					    <div class="input-group w-100" id="show_hide_con_password">
					    	<input type="password" name="re_type_password" class="form-control" id="re_type_password" aria-describedby="emailHelp" placeholder="Enter Re-type Password" <?php if (!isset($_POST['editUserbtn']) || isset($reopen_user_name)) {echo "required";} if (isset($reopen_re_type_password)) {echo "value=".$reopen_re_type_password;}?>>
							<div class="input-group-append">
		                        <span class="input-group-text"><a href="" id="add_acc_con_passLink"><i class="fa fa-eye-slash" aria-hidden="true"></i></a></span>
		                    </div>
							<span id="re_type_password_status"></span>
					    </div>
					</div>
				</div>
				<div class="form-inline">
					<div class="form-group d-block col-md-3">
					    <label for="firstname" class="float-left p-2">Mobile No <span style="color: red;" class="pl-1">*</span></label>
					    <input type="tel" name="mobile_no" class="form-control w-100" required id="mobile_no" maxlength="10" minlength="10" pattern="[0-9]{10}" aria-describedby="emailHelp" placeholder="Enter Mobile number" <?php if (isset($_POST['editUserbtn'])) {echo "value=".$edit_add_mobile;} if (isset($reopen_mobile)) {echo "value=".$reopen_mobile;}?>>
					    <span id="mobile_status"></span>
					</div>
				
					<div class="form-group d-block col-md-3">
					    <label for="firstname" class="float-left p-2">Selected Members <span style="color: red;" class="pl-1">*</span></label>
					    <textarea cols="5" rows="4" id="fetch_select_members" class="form-control w-100"></textarea>
					</div>
				</div>
				<center><h3>-:User Privilege:-</h3></center>
				<div class="form-inline">
				
				    <div class="form-group d-block col-md-4 table-responsive" id="esp_soft">
					    <label class="float-left p-2">ESP Software Permission</label>
						
					    <button type="button" class="collapsible">Master</button>
						
                            <div class="content" style="position: relative; z-index: 9999; overflow: visible;">
								<?php if($permission_row['client_master'] == 1) { ?>
                                <p><label for="previous_password" class="float-left p-2">Recipient Master:- </label><select class="form-control" id="client_master" name="client_master">
                                        <option value="0" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_client_master=="0" ? 'selected' : '');} if (isset($reopen_client_master)) { echo "selected";}?>>Restrict</option>
                                        <option value="1" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_client_master==1 ? 'selected' : '');} if (isset($reopen_client_master)) { echo "selected";}?>>Controller</option>
                                    </select>
                                </p><?php } else{ ?>
									<p><label for="previous_password" class="float-left p-2 d-none">Recipient Master:- </label><select class="form-control d-none" id="client_master" name="client_master">
                                        <option value="0" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_client_master=="0" ? 'selected' : '');} if (isset($reopen_client_master)) { echo "selected";}?>>Restrict</option>
                                        <option value="1" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_client_master==1 ? 'selected' : '');} if (isset($reopen_client_master)) { echo "selected";}?>>Controller</option>
                                    </select>
								</p>
								<?php }if($permission_row['vendor_master'] == 1) { ?>
                                <p><label for="previous_password" class="float-left p-2">Supplier Master:- </label><select class="form-control" id="supplier_master" name="supplier_master">
                                        <option value="0" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_supplier_master=="0" ? 'selected' : '');} if (isset($reopen_supplier_master)) { echo "selected";}?>>Restrict</option>
                                        <option value="1" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_supplier_master==1 ? 'selected' : '');} if (isset($reopen_supplier_master)) { echo "selected";}?>>Controller</option>
                                    </select>
                                </p>
								<?php } else {?>
									<p><label for="previous_password" class="float-left p-2 d-none">Supplier Master:- </label><select class="form-control d-none" id="supplier_master" name="supplier_master">
                                        <option value="0" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_supplier_master=="0" ? 'selected' : '');} if (isset($reopen_supplier_master)) { echo "selected";}?>>Restrict</option>
                                        <option value="1" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_supplier_master==1 ? 'selected' : '');} if (isset($reopen_supplier_master)) { echo "selected";}?>>Controller</option>
                                    </select>
                                </p>
								<?php } ?>
                            </div>
						
						<button type="button" class="collapsible">Recipient Station</button>
                            <div class="content" style="position: relative; z-index: 9999; overflow: visible;">
							<?php if($permission_row['dsc_subscriber'] == 1) { ?>	
                                <p><label for="previous_password" class="float-left p-2">DSC Subscriber:- </label><select class="form-control" id="dsc_subscriber" name="dsc_subscriber">
                                        <option value="0" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_dsc_subscriber=="0" ? 'selected' : '');} if (isset($reopen_dsc_subscriber)) { echo "selected";}?>>Restrict</option>
                                        <option value="1" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_dsc_subscriber==1 ? 'selected' : '');} if (isset($reopen_dsc_subscriber)) { echo "selected";}?>>Controller</option>
                                    </select></p>
								<?php } else {?>
									<p><label for="previous_password" class="float-left p-2 d-none">DSC Subscriber:- </label><select class="form-control d-none" id="dsc_subscriber" name="dsc_subscriber">
                                        <option value="0" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_dsc_subscriber=="0" ? 'selected' : '');} if (isset($reopen_dsc_subscriber)) { echo "selected";}?>>Restrict</option>
                                        <option value="1" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_dsc_subscriber==1 ? 'selected' : '');} if (isset($reopen_dsc_subscriber)) { echo "selected";}?>>Controller</option>
                                    </select></p>
								<?php }if($permission_row['dsc_reseller'] == 1) { ?>    
                                <p><label for="password" class="float-left p-2">DSC Reseller:- </label><select class="form-control" id="dsc_reseller" name="dsc_reseller">
                                        <option value="0" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_dsc_reseller=="0" ? 'selected' : '');} if (isset($reopen_dsc_reseller)) { echo "selected";}?>>Restrict</option>
                                        <option value="1" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_dsc_reseller==1 ? 'selected' : '');} if (isset($reopen_dsc_reseller)) { echo "selected";}?>>Controller</option>
                                    </select></p>
								<?php } else{?>
									<p><label for="password" class="float-left p-2 d-none">DSC Reseller:- </label><select class="form-control d-none" id="dsc_reseller" name="dsc_reseller">
                                        <option value="0" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_dsc_reseller=="0" ? 'selected' : '');} if (isset($reopen_dsc_reseller)) { echo "selected";}?>>Restrict</option>
                                        <option value="1" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_dsc_reseller==1 ? 'selected' : '');} if (isset($reopen_dsc_reseller)) { echo "selected";}?>>Controller</option>
                                    </select></p>
								<?php }if($permission_row['pan'] == 1){?>
                                <p><label for="password" class="float-left p-2 ">PAN:- </label><select class="form-control " id="pan" name="pan">
                                        <option value="0" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_pan=="0" ? 'selected' : '');} if (isset($reopen_pan)) { echo "selected";}?>>Restrict</option>
                                        <option value="1" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_pan==1 ? 'selected' : '');} if (isset($reopen_pan)) { echo "selected";}?>>Controller</option>
                                    </select></p>
                              <?php } else{ ?> 
								<p><label for="password" class="float-left p-2 d-none">PAN:- </label><select class="form-control d-none" id="pan" name="pan">
                                        <option value="0" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_pan=="0" ? 'selected' : '');} if (isset($reopen_pan)) { echo "selected";}?>>Restrict</option>
                                        <option value="1" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_pan==1 ? 'selected' : '');} if (isset($reopen_pan)) { echo "selected";}?>>Controller</option>
                                    </select></p>
							  <?php } if($permission_row['tan'] == 1){?>
								<p><label for="password" class="float-left p-2">TAN:- </label><select class="form-control" id="tan" name="tan">
                                        <option value="0" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_tan=="0" ? 'selected' : '');} if (isset($reopen_tan)) { echo "selected";}?>>Restrict</option>
                                        <option value="1" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_tan==1 ? 'selected' : '');} if (isset($reopen_tan)) { echo "selected";}?>>Controller</option>
                                    </select></p>
								<?php } else { ?>
									<p><label for="password" class="float-left p-2 d-none">TAN:- </label><select class="form-control d-none" id="tan" name="tan">
                                        <option value="0" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_tan=="0" ? 'selected' : '');} if (isset($reopen_tan)) { echo "selected";}?>>Restrict</option>
                                        <option value="1" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_tan==1 ? 'selected' : '');} if (isset($reopen_tan)) { echo "selected";}?>>Controller</option>
                                    </select></p>
								<?php } if($permission_row['it_returns'] == 1){?>
								<p><label for="password" class="float-left p-2">IT Return:- </label><select class="form-control" id="it_returns" name="it_returns">
                                        <option value="0" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_it_returns=="0" ? 'selected' : '');} if (isset($reopen_it_returns)) { echo "selected";}?>>Restrict</option>
                                        <option value="1" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_it_returns==1 ? 'selected' : '');} if (isset($reopen_it_returns)) { echo "selected";}?>>Controller</option>
                                    </select></p>
								<?php } else{?>
									<p><label for="password" class="float-left p-2 d-none">IT Return:- </label><select class="form-control d-none" id="it_returns" name="it_returns">
                                        <option value="0" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_it_returns=="0" ? 'selected' : '');} if (isset($reopen_it_returns)) { echo "selected";}?>>Restrict</option>
                                        <option value="1" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_it_returns==1 ? 'selected' : '');} if (isset($reopen_it_returns)) { echo "selected";}?>>Controller</option>
                                    </select></p>
								<?php } if($permission_row['e_tds'] == 1){?>
									<p><label for="password" class="float-left p-2">E-tds:- </label><select class="form-control" id="e_tds" name="e_tds">
											<option value="2" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_e_tds=="0" ? 'selected' : '');} if (isset($reopen_e_tds)) { echo "selected";}?>>Restrict</option>
											<option value="1" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_e_tds==1 ? 'selected' : '');} if (isset($reopen_e_tds)) { echo "selected";}?>>Controller</option>
										</select></p>
								<?php } else{ ?>
									<p><label for="password" class="float-left p-2 d-none">E-tds:- </label><select class="form-control d-none" id="e_tds" name="e_tds">
											<option value="2" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_e_tds=="0" ? 'selected' : '');} if (isset($reopen_e_tds)) { echo "selected";}?>>Restrict</option>
											<option value="1" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_e_tds==1 ? 'selected' : '');} if (isset($reopen_e_tds)) { echo "selected";}?>>Controller</option>
										</select></p>
								<?php } if($permission_row['gst'] == 1){?>
									<p><label for="password" class="float-left p-2">GST:- </label><select class="form-control" id="gst" name="gst">
											<option value="0" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_gst=="0" ? 'selected' : '');} if (isset($reopen_gst)) { echo "selected";}?>>Restrict</option>
											<option value="1" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_gst==1 ? 'selected' : '');} if (isset($reopen_gst)) { echo "selected";}?>>Controller</option>
										</select></p>
								<?php } else{?>
									<p><label for="password" class="float-left p-2 d-none">GST:- </label><select class="form-control d-none" id="gst" name="gst">
											<option value="0" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_gst=="0" ? 'selected' : '');} if (isset($reopen_gst)) { echo "selected";}?>>Restrict</option>
											<option value="1" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_gst==1 ? 'selected' : '');} if (isset($reopen_gst)) { echo "selected";}?>>Controller</option>
										</select></p>
								<?php }  if($permission_row['other_services'] == 1){?>    
									<p><label for="password" class="float-left p-2">Other Services:- </label><select class="form-control" id="other_services" name="other_services">
											<option value="0" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_other_services=="0" ? 'selected' : '');} if (isset($reopen_other_services)) { echo "selected";}?>>Restrict</option>
											<option value="1" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_other_services==1 ? 'selected' : '');} if (isset($reopen_other_services)) { echo "selected";}?>>Controller</option>
										</select></p>
								<?php } else { ?>
									<<p><label for="password" class="float-left p-2 d-none">Other Services:- </label><select class="form-control d-none" id="other_services" name="other_services">
											<option value="0" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_other_services=="0" ? 'selected' : '');} if (isset($reopen_other_services)) { echo "selected";}?>>Restrict</option>
											<option value="1" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_other_services==1 ? 'selected' : '');} if (isset($reopen_other_services)) { echo "selected";}?>>Controller</option>
										</select></p>
								<?php } if($permission_row['psp'] == 1){?>        
									<p><label for="password" class="float-left p-2">PSP:- </label><select class="form-control" id="psp" name="psp">
											<option value="0" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_psp=="0" ? 'selected' : '');} if (isset($reopen_psp)) { echo "selected";}?>>Restrict</option>
											<option value="1" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_psp==1 ? 'selected' : '');} if (isset($reopen_psp)) { echo "selected";}?>>Controller</option>
										</select></p>
								<?php } else{?>
									<p><label for="password" class="float-left p-2 d-none">PSP:- </label><select class="form-control d-none" id="psp" name="psp">
											<option value="0" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_psp=="0" ? 'selected' : '');} if (isset($reopen_psp)) { echo "selected";}?>>Restrict</option>
											<option value="1" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_psp==1 ? 'selected' : '');} if (isset($reopen_psp)) { echo "selected";}?>>Controller</option>
										</select></p>
								<?php } if($permission_row['psp_coupon_consumption'] == 1){?>    
									<p><label for="password" class="float-left p-2">PSP Coupon Comsumption:- </label><select class="form-control" id="psp_coupon_consumption" name="psp_coupon_consumption">
											<option value="0" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_psp_coupon_consumption=="0" ? 'selected' : '');} if (isset($reopen_psp_coupon_consumption)) { echo "selected";}?>>Restrict</option>
											<option value="1" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_psp_coupon_consumption==1 ? 'selected' : '');} if (isset($reopen_psp_coupon_consumption)) { echo "selected";}?>>Controller</option>
										</select></p>
								<?php } else{?>
									<p><label for="password" class="float-left p-2 d-none">PSP Coupon Comsumption:- </label><select class="form-control d-none" id="psp_coupon_consumption" name="psp_coupon_consumption">
											<option value="0" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_psp_coupon_consumption=="0" ? 'selected' : '');} if (isset($reopen_psp_coupon_consumption)) { echo "selected";}?>>Restrict</option>
											<option value="1" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_psp_coupon_consumption==1 ? 'selected' : '');} if (isset($reopen_psp_coupon_consumption)) { echo "selected";}?>>Controller</option>
										</select></p>
								<?php }  if($permission_row['audit'] == 1){?>        
									<p><label for="password" class="float-left p-2">Audit:- </label><select class="form-control" id="audit" name="audit">
											<option value="0" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_audit=="0" ? 'selected' : '');} if (isset($reopen_audit)) { echo "selected";}?>>Restrict</option>
											<option value="1" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_audit==1 ? 'selected' : '');} if (isset($reopen_audit)) { echo "selected";}?>>Controller</option>
										</select></p>
								<?php } else{?>
									<p><label for="password" class="float-left p-2 d-none">Audit:- </label><select class="form-control d-none" id="audit" name="audit">
											<option value="0" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_audit=="0" ? 'selected' : '');} if (isset($reopen_audit)) { echo "selected";}?>>Restrict</option>
											<option value="1" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_audit==1 ? 'selected' : '');} if (isset($reopen_audit)) { echo "selected";}?>>Controller</option>
										</select></p>
								<?php } if($permission_row['other_transaction'] == 1){?>        
									<p><label for="password" class="float-left p-2">Other Transaction:- </label><select class="form-control" id="other_transaction" name="other_transaction">
											<option value="0" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_other_transaction=="0" ? 'selected' : '');} if (isset($reopen_other_transaction)) { echo "selected";}?>>Restrict</option>
											<option value="1" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_other_transaction==1 ? 'selected' : '');} if (isset($reopen_other_transaction)) { echo "selected";}?>>Controller</option>
										</select></p>
								<?php } else{?>
									<p><label for="password" class="float-left p-2 d-none">Other Transaction:- </label><select class="form-control d-none" id="other_transaction" name="other_transaction">
											<option value="0" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_other_transaction=="0" ? 'selected' : '');} if (isset($reopen_other_transaction)) { echo "selected";}?>>Restrict</option>
											<option value="1" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_other_transaction==1 ? 'selected' : '');} if (isset($reopen_other_transaction)) { echo "selected";}?>>Controller</option>
										</select></p>
								<?php } if($permission_row['e_tender'] == 1){?>
									<p><label for="password" class="float-left p-2">E-tender:- </label><select class="form-control" id="e_tender" name="e_tender">
											<option value="0" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_e_tender==0 ? 'selected' : '');} if (isset($reopen_e_tender)) { echo "selected";}?>>Restrict</option>
											<option value="1" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_e_tender==1 ? 'selected' : '');} if (isset($reopen_e_tender)) { echo "selected";}?>>Controller</option>
										</select>
									</p>
								<?php } else{ ?>
									<p><label for="password" class="float-left p-2 d-none">E-tender:- </label><select class="form-control d-none" id="e_tender" name="e_tender">
                                        <option value="0" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_e_tender==0 ? 'selected' : '');} if (isset($reopen_e_tender)) { echo "selected";}?>>Restrict</option>
                                        <option value="1" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_e_tender==1 ? 'selected' : '');} if (isset($reopen_e_tender)) { echo "selected";}?>>Controller</option>
                                    </select>
								</p>
								<?php } if($permission_row['trade_mark'] == 1){?>
									<p><label for="password" class="float-left p-2">Trade Mark:- </label><select class="form-control" id="trade_mark" name="trade_mark">
											<option value="0" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_trade_mark==0 ? 'selected' : '');} if (isset($reopen_trade_mark)) { echo "selected";}?>>Restrict</option>
											<option value="1" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_trade_mark==1 ? 'selected' : '');} if (isset($reopen_trade_mark)) { echo "selected";}?>>Controller</option>
										</select></p>
								<?php } else{ ?>
									<p><label for="password" class="float-left p-2 d-none">Trade Mark:- </label><select class="form-control d-none" id="trade_mark" name="trade_mark">
                                        <option value="0" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_trade_mark==0 ? 'selected' : '');} if (isset($reopen_trade_mark)) { echo "selected";}?>>Restrict</option>
                                        <option value="1" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_trade_mark==1 ? 'selected' : '');} if (isset($reopen_trade_mark)) { echo "selected";}?>>Controller</option>
                                    </select></p>
								<?php } if($permission_row['patent'] == 1){?>
									<p><label for="password" class="float-left p-2">Patent:- </label><select class="form-control" id="patent" name="patent">
											<option value="0" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_patent==0 ? 'selected' : '');} if (isset($reopen_patent)) { echo "selected";}?>>Restrict</option>
											<option value="1" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_patent==1 ? 'selected' : '');} if (isset($reopen_patent)) { echo "selected";}?>>Controller</option>
										</select></p>
								<?php } else{ ?>
									<p><label for="password" class="float-left p-2 d-none">Patent:- </label><select class="form-control d-none" id="patent" name="patent">
                                        <option value="0" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_patent==0 ? 'selected' : '');} if (isset($reopen_patent)) { echo "selected";}?>>Restrict</option>
                                        <option value="1" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_patent==1 ? 'selected' : '');} if (isset($reopen_patent)) { echo "selected";}?>>Controller</option>
                                    </select></p>
								<?php } if($permission_row['copy_right'] == 1){?>
									<p><label for="password" class="float-left p-2">Copy Right:- </label><select class="form-control" id="copy_right" name="copy_right">
											<option value="0" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_copy_right==0 ? 'selected' : '');} if (isset($reopen_copy_right)) { echo "selected";}?>>Restrict</option>
											<option value="1" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_copy_right==1 ? 'selected' : '');} if (isset($reopen_copy_right)) { echo "selected";}?>>Controller</option>
										</select>
									</p>
								<?php } else{ ?>
									<p><label for="password" class="float-left p-2 d-none">Copy Right:- </label><select class="form-control d-none" id="copy_right" name="copy_right">
											<option value="0" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_copy_right==0 ? 'selected' : '');} if (isset($reopen_copy_right)) { echo "selected";}?>>Restrict</option>
											<option value="1" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_copy_right==1 ? 'selected' : '');} if (isset($reopen_copy_right)) { echo "selected";}?>>Controller</option>
										</select>
									</p>
								<?php }if($permission_row['trade_secret'] == 1){?>
									<p><label for="password" class="float-left p-2">Trade Secret:- </label><select class="form-control" id="trade_secret" name="trade_secret">
											<option value="0" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_trade_secret==0 ? 'selected' : '');} if (isset($reopen_trade_secret)) { echo "selected";}?>>Restrict</option>
											<option value="1" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_trade_secret==1 ? 'selected' : '');} if (isset($reopen_trade_secret)) { echo "selected";}?>>Controller</option>
										</select>
									</p>
								<?php } else{ ?> 
									<p><label for="password" class="float-left p-2 d-none">Trade Secret:- </label><select class="form-control d-none" id="trade_secret" name="trade_secret">
											<option value="0" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_trade_secret==0 ? 'selected' : '');} if (isset($reopen_trade_secret)) { echo "selected";}?>>Restrict</option>
											<option value="1" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_trade_secret==1 ? 'selected' : '');} if (isset($reopen_trade_secret)) { echo "selected";}?>>Controller</option>
										</select>
									</p>
								<?php } if($permission_row['industrial_design'] == 1){?>
									<p><label for="password" class="float-left p-2">Industrial Design:- </label><select class="form-control" id="industrial_design" name="industrial_design">
											<option value="0" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_industrial_design==0 ? 'selected' : '');} if (isset($reopen_industrial_design)) { echo "selected";}?>>Restrict</option>
											<option value="1" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_industrial_design==1 ? 'selected' : '');} if (isset($reopen_industrial_design)) { echo "selected";}?>>Controller</option>
										</select>
									</p>
								<?php } else{ ?> 
									<p><label for="password" class="float-left p-2 d-none">Industrial Design:- </label><select class="form-control d-none" id="industrial_design" name="industrial_design">
                                        <option value="0" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_industrial_design==0 ? 'selected' : '');} if (isset($reopen_industrial_design)) { echo "selected";}?>>Restrict</option>
                                        <option value="1" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_industrial_design==1 ? 'selected' : '');} if (isset($reopen_industrial_design)) { echo "selected";}?>>Controller</option>
                                    </select>
									</p>
								<?php }  if($permission_row['legal_notice'] == 1){?>
									<p><label for="password" class="float-left p-2">Advocate:- </label><select class="form-control" id="legal_notice" name="legal_notice">
											<option value="0" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_legal_notice==0 ? 'selected' : '');} if (isset($reopen_legal_notice)) { echo "selected";}?>>Restrict</option>
											<option value="1" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_legal_notice==1 ? 'selected' : '');} if (isset($reopen_legal_notice)) { echo "selected";}?>>Controller</option>
										</select>
									</p>
								<?php }else {?>
									<p><label for="password" class="float-left p-2 d-none">Advocate:- </label><select class="form-control d-none" id="legal_notice" name="legal_notice">
											<option value="0" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_legal_notice==0 ? 'selected' : '');} if (isset($reopen_legal_notice)) { echo "selected";}?>>Restrict</option>
											<option value="1" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_legal_notice==1 ? 'selected' : '');} if (isset($reopen_legal_notice)) { echo "selected";}?>>Controller</option>
										</select>
									</p>
								<?php } ?>
                            </div>
                            <button type="button" class="collapsible">Accounts/Document</button>
                            <div class="content" style="position: relative; z-index: 9999; overflow: visible;">
							<?php if($permission_row['document_records'] == 1) { ?>
                              <p><label for="previous_password" class="float-left p-2">Document Records:- </label><select class="form-control" id="document_records" name="document_records">
                                        <option value="0" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_document_records==0 ? 'selected' : '');} if (isset($reopen_document_records)) { echo "selected";}?>>Restrict</option>
                                        <option value="1" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_document_records==1 ? 'selected' : '');} if (isset($reopen_document_records)) { echo "selected";}?>>Controller</option>
                                    </select></p>
							<?php } else{ ?>
								<p><label for="previous_password" class="float-left p-2 d-none">Document Records:- </label><select class="form-control d-none" id="document_records" name="document_records">
                                        <option value="0" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_document_records==0 ? 'selected' : '');} if (isset($reopen_document_records)) { echo "selected";}?>>Restrict</option>
                                        <option value="1" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_document_records==1 ? 'selected' : '');} if (isset($reopen_document_records)) { echo "selected";}?>>Controller</option>
                                    </select></p>
							<?php } ?>		
                            </div>
                            <button type="button" class="collapsible">Finance Bank</button>
                            <div class="content" style="position: relative; z-index: 9999; overflow: visible;">
								<?php if($permission_row['payment'] == 1){ ?>
									<p><label for="password" class="float-left p-2">Payment:- </label><select class="form-control" id="payment" name="payment">
											<option value="0" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_payment=="0" ? 'selected' : '');} if (isset($reopen_payment)) { echo "selected";}?>>Restrict</option>
											<option value="1" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_payment==1 ? 'selected' : '');} if (isset($reopen_payment)) { echo "selected";}?>>Controller</option>
										</select></p>
								<?php } else{ ?>
									<p><label for="password" class="float-left p-2 d-none">Payment:- </label><select class="form-control d-none" id="payment" name="payment">
                                        <option value="0" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_payment=="0" ? 'selected' : '');} if (isset($reopen_payment)) { echo "selected";}?>>Restrict</option>
                                        <option value="1" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_payment==1 ? 'selected' : '');} if (isset($reopen_payment)) { echo "selected";}?>>Controller</option>
                                    </select></p>
								<?php } if($permission_row['settlement'] == 1){ ?>
									<p><label for="password" class="float-left p-2">Settlement:- </label><select class="form-control" id="settlement" name="settlement">
											<option value="0" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_settlement=="0" ? 'selected' : '');} if (isset($reopen_settlement)) { echo "selected";}?>>Restrict</option>
											<option value="1" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_settlement==1 ? 'selected' : '');} if (isset($reopen_settlement)) { echo "selected";}?>>Controller</option>
										</select></p>
								<?php } else{ ?> 
									<p><label for="password" class="float-left p-2 d-none">Settlement:- </label><select class="form-control d-none" id="settlement" name="settlement">
                                        <option value="0" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_settlement=="0" ? 'selected' : '');} if (isset($reopen_settlement)) { echo "selected";}?>>Restrict</option>
                                        <option value="1" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_settlement==1 ? 'selected' : '');} if (isset($reopen_settlement)) { echo "selected";}?>>Controller</option>
                                    </select></p>
								<?php } if($permission_row['expense'] == 1){ ?>
									<p><label for="password" class="float-left p-2">Expense:- </label><select class="form-control" id="expense" name="expense">
											<option value="0" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_expense=="0" ? 'selected' : '');} if (isset($reopen_expense)) { echo "selected";}?>>Restrict</option>
											<option value="1" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_expense==1 ? 'selected' : '');} if (isset($reopen_expense)) { echo "selected";}?>>Controller</option>
										</select></p>
								<?php } else{?> 
									<p><label for="password" class="float-left p-2 d-none">Expense:- </label><select class="form-control d-none" id="expense" name="expense">
                                        <option value="0" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_expense=="0" ? 'selected' : '');} if (isset($reopen_expense)) { echo "selected";}?>>Restrict</option>
                                        <option value="1" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_expense==1 ? 'selected' : '');} if (isset($reopen_expense)) { echo "selected";}?>>Controller</option>
                                    </select></p>
								<?php } if($permission_row['contra_voucher'] == 1){ ?>
									<p><label for="password" class="float-left p-2">Contra Voucher:- </label><select class="form-control" id="contra_voucher" name="contra_voucher">
											<option value="0" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_contra_voucher=="0" ? 'selected' : '');} if (isset($reopen_contra_voucher)) { echo "selected";}?>>Restrict</option>
											<option value="1" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_contra_voucher==1 ? 'selected' : '');} if (isset($reopen_contra_voucher)) { echo "selected";}?>>Controller</option>
										</select></p>
								<?php } else{ ?>
									<p><label for="password" class="float-left p-2 d-none">Contra Voucher:- </label><select class="form-control d-none" id="contra_voucher" name="contra_voucher">
                                        <option value="0" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_contra_voucher=="0" ? 'selected' : '');} if (isset($reopen_contra_voucher)) { echo "selected";}?>>Restrict</option>
                                        <option value="1" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_contra_voucher==1 ? 'selected' : '');} if (isset($reopen_contra_voucher)) { echo "selected";}?>>Controller</option>
                                    </select></p>
								<?php } ?>
                                <!--<p><label for="previous_password" class="float-left p-2">Financial Record:- </label><select class="form-control" id="financial_records" name="financial_records">-->
                                <!--        <option value="" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_financial_records==0 ? 'selected' : '');} if (isset($reopen_financial_records)) { echo "selected";}?>>Restrict</option>-->
                                <!--        <option value="1" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_financial_records==1 ? 'selected' : '');} if (isset($reopen_financial_records)) { echo "selected";}?>>Operator</option>-->
                                <!--    </select></p>-->
                            </div>
                            <button type="button" class="collapsible">Reports</button>
                            <div class="content" style="position: relative; z-index: 9999; overflow: visible;">
								<?php if($permission_row['reports'] == 1){ ?>
									<p><label for="previous_password" class="float-left p-2">Service Reports:- </label><select class="form-control" id="reports" name="reports">
											<option value="0" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_reports=="0" ? 'selected' : '');} if (isset($reopen_reports)) { echo "selected";}?>>Restrict</option>
											<option value="1" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_reports==1 ? 'selected' : '');} if (isset($reopen_reports)) { echo "selected";}?>>Controller</option>
										</select>
									</p>
								<?php } else{ ?>
									<p><label for="previous_password" class="float-left p-2 d-none">Service Reports:- </label><select class="form-control d-none" id="reports" name="reports">
                                        <option value="0" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_reports=="0" ? 'selected' : '');} if (isset($reopen_reports)) { echo "selected";}?>>Restrict</option>
                                        <option value="1" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_reports==1 ? 'selected' : '');} if (isset($reopen_reports)) { echo "selected";}?>>Controller</option>
                                    </select>
                                </p>
								<?php } if($permission_row['bank_report'] == 1){ ?>
									<p><label for="previous_password" class="float-left p-2">Bank Report:- </label><select class="form-control" id="bank_report" name="bank_report">
											<option value="0" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_bank_report=="0" ? 'selected' : '');} if (isset($reopen_bank_report)) { echo "selected";}?>>Restrict</option>
											<option value="1" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_bank_report==1 ? 'selected' : '');} if (isset($reopen_bank_report)) { echo "selected";}?>>Controller</option>
										</select>
									</p>
								<?php } else {?> 
										<p><label for="previous_password" class="float-left p-2 d-none">Bank Report:- </label><select class="form-control d-none" id="bank_report" name="bank_report">
											<option value="0" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_bank_report=="0" ? 'selected' : '');} if (isset($reopen_bank_report)) { echo "selected";}?>>Restrict</option>
											<option value="1" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_bank_report==1 ? 'selected' : '');} if (isset($reopen_bank_report)) { echo "selected";}?>>Controller</option>
										</select>
									</p>
								<?php }if($permission_row['outstanding'] == 1){ ?>
									<p><label for="previous_password" class="float-left p-2">Outstanding:- </label><select class="form-control" id="outstanding" name="outstanding">
											<option value="0" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_outstanding=="0" ? 'selected' : '');} if (isset($reopen_outstanding)) { echo "selected";}?>>Restrict</option>
											<option value="1" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_outstanding==1 ? 'selected' : '');} if (isset($reopen_outstanding)) { echo "selected";}?>>Controller</option>
										</select>
									</p>
								<?php } else { ?>
									<p><label for="previous_password" class="float-left p-2 d-none">Outstanding:- </label><select class="form-control d-none" id="outstanding" name="outstanding">
                                        <option value="0" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_outstanding=="0" ? 'selected' : '');} if (isset($reopen_outstanding)) { echo "selected";}?>>Restrict</option>
                                        <option value="1" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_outstanding==1 ? 'selected' : '');} if (isset($reopen_outstanding)) { echo "selected";}?>>Controller</option>
                                    </select>
                               	 </p>
								<?php }?>
                            </div>
                            <button type="button" class="collapsible">HR/Payroll</button>
                            <div class="content" style="position: relative; z-index: 9999; overflow: visible;">
								<?php  if($permission_row['payroll'] == 1){ ?>
									<p><label for="previous_password" class="float-left p-2">Payroll:- </label><select class="form-control" id="payroll" name="payroll">
											<option value="0" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_payroll==0 ? 'selected' : '');} if (isset($reopen_payroll)) { echo "selected";}?>>Restrict</option>
											<option value="1" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_payroll==1 ? 'selected' : '');} if (isset($reopen_payroll)) { echo "selected";}?>>Controller</option>
										</select></p>
								<?php } else{ ?>
									<p><label for="previous_password" class="float-left p-2 d-none">Payroll:- </label><select class="form-control d-none" id="payroll" name="payroll">
                                        <option value="0" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_payroll==0 ? 'selected' : '');} if (isset($reopen_payroll)) { echo "selected";}?>>Restrict</option>
                                        <option value="1" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_payroll==1 ? 'selected' : '');} if (isset($reopen_payroll)) { echo "selected";}?>>Controller</option>
                                    </select></p>
								<?php }?>
                            </div>
                            <button type="button" class="collapsible">Task Manager</button>
                            <div class="content" style="position: relative; z-index: 9999; overflow: visible;">
								<?php  if($permission_row['add_taskmanager'] == 1){ ?>
									<p><label for="previous_password" class="float-left p-2">Task Manager:- </label><select class="form-control" id="add_taskM" name="add_taskM">
											<option value="0" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_add_taskmanager==0 ? 'selected' : '');} if (isset($reopen_add_taskM)) { echo "selected";}?>>Restrict</option>
											<option value="1" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_add_taskmanager==1 ? 'selected' : '');} if (isset($reopen_add_taskM)) { echo "selected";}?>>Controller</option>
										</select></p>
								<?php } else{ ?>
									<p><label for="previous_password" class="float-left p-2 d-none">Task Manager:- </label><select class="form-control d-none" id="add_taskM" name="add_taskM">
                                        <option value="0" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_add_taskmanager==0 ? 'selected' : '');} if (isset($reopen_add_taskM)) { echo "selected";}?>>Restrict</option>
                                        <option value="1" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_add_taskmanager==1 ? 'selected' : '');} if (isset($reopen_add_taskM)) { echo "selected";}?>>Controller</option>
                                    </select></p>
								<?php }?>
                            </div>
                            <button type="button" class="collapsible">Booster Apps</button>
                            <div class="content" style="position: relative; z-index: 9999; overflow: visible;">
								<?php  if($permission_row['contact_client'] == 1){ ?>
									<p><label for="previous_password" class="float-left p-2">Contact Client:- </label><select class="form-control" id="contact_client" name="contact_client">
											<option value="0" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_contact_client==0 ? 'selected' : '');} if (isset($reopen_contact_client)) { echo "selected";}?>>Restrict</option>
											<option value="1" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_contact_client==1 ? 'selected' : '');} if (isset($reopen_contact_client)) { echo "selected";}?>>Controller</option>
										</select></p>
								<?php } else{ ?> 
									<p><label for="previous_password" class="float-left p-2 d-none">Contact Client:- </label><select class="form-control d-none" id="contact_client" name="contact_client">
                                        <option value="0" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_contact_client==0 ? 'selected' : '');} if (isset($reopen_contact_client)) { echo "selected";}?>>Restrict</option>
                                        <option value="1" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_contact_client==1 ? 'selected' : '');} if (isset($reopen_contact_client)) { echo "selected";}?>>Controller</option>
                                    </select></p>
								<?php } if($permission_row['add_passMang'] == 1){ ?>	
									<p><label for="previous_password" class="float-left p-2">Password Manager:- </label><select class="form-control" id="add_passMang" name="add_passMang">
											<option value="0" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_add_passMang=="0" ? 'selected' : '');} if (isset($reopen_add_passMang)) { echo "selected";}?>>Restrict</option>
											<option value="1" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_add_passMang==1 ? 'selected' : '');} if (isset($reopen_add_passMang)) { echo "selected";}?>>Controller</option>
										</select></p>
								<?php } else{ ?>
									<p><label for="previous_password" class="float-left p-2 d-none">Password Manager:- </label><select class="form-control d-none" id="add_passMang" name="add_passMang">
                                        <option value="0" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_add_passMang=="0" ? 'selected' : '');} if (isset($reopen_add_passMang)) { echo "selected";}?>>Restrict</option>
                                        <option value="1" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_add_passMang==1 ? 'selected' : '');} if (isset($reopen_add_passMang)) { echo "selected";}?>>Controller</option>
                                    </select></p>
								<?php }if($permission_row['addFix_meeting'] == 1){ ?>
									<p><label for="previous_password" class="float-left p-2">Fix Meeting:- </label><select class="form-control" id="crm_fix_meeting" name="crm_fix_meeting">
											<option value="0" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_addFix_meeting==0 ? 'selected' : '');} if (isset($reopen_addFix_meeting)) { echo "selected";}?>>Restrict</option>
											<option value="1" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_addFix_meeting==1 ? 'selected' : '');} if (isset($reopen_addFix_meeting)) { echo "selected";}?>>Controller</option>
										</select></p>
								<?php } else{ ?> 
									<p><label for="previous_password" class="float-left p-2 d-none">Fix Meeting:- </label><select class="form-control d-none" id="crm_fix_meeting" name="crm_fix_meeting">
                                        <option value="0" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_addFix_meeting==0 ? 'selected' : '');} if (isset($reopen_addFix_meeting)) { echo "selected";}?>>Restrict</option>
                                        <option value="1" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_addFix_meeting==1 ? 'selected' : '');} if (isset($reopen_addFix_meeting)) { echo "selected";}?>>Controller</option>
                                    </select></p>
								<?php }if($permission_row['tickets'] == 1){ ?>
									<p><label for="previous_password" class="float-left p-2">Tickets:- </label><select class="form-control" id="ticket" name="ticket">
											<option value="0" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_ticket==0 ? 'selected' : '');} if (isset($reopen_ticket)) { echo "selected";}?>>Restrict</option>
											<option value="1" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_ticket==1 ? 'selected' : '');} if (isset($reopen_ticket)) { echo "selected";}?>>Controller</option>
										</select></p>
								<?php } else{ ?>
									<p><label for="previous_password" class="float-left p-2 d-none">Tickets:- </label><select class="form-control d-none" id="ticket" name="ticket">
                                        <option value="0" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_ticket==0 ? 'selected' : '');} if (isset($reopen_ticket)) { echo "selected";}?>>Restrict</option>
                                        <option value="1" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_ticket==1 ? 'selected' : '');} if (isset($reopen_ticket)) { echo "selected";}?>>Controller</option>
                                    </select></p>
								<?php }if($permission_row['add_enquiry'] == 1){ ?>
									<p><label for="previous_password" class="float-left p-2">Enquiry:- </label><select class="form-control" id="crm_enq" name="crm_enq">
											<option value="0" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_add_enquiry==0 ? 'selected' : '');} if (isset($reopen_enquiry)) { echo "selected";}?>>Restrict</option>
											<option value="1" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_add_enquiry==1 ? 'selected' : '');} if (isset($reopen_enquiry)) { echo "selected";}?>>Controller</option>
										</select></p>
								<?php } else{ ?>
									<p><label for="previous_password" class="float-left p-2 d-none">Enquiry:- </label><select class="form-control d-none" id="crm_enq" name="crm_enq">
                                        <option value="0" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_add_enquiry==0 ? 'selected' : '');} if (isset($reopen_enquiry)) { echo "selected";}?>>Restrict</option>
                                        <option value="1" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_add_enquiry==1 ? 'selected' : '');} if (isset($reopen_enquiry)) { echo "selected";}?>>Controller</option>
                                    </select></p>
								<?php }?>
                            </div>
                            <button type="button" class="collapsible">Social PLatform</button>
                            <div class="content" style="position: relative; z-index: 9999; overflow: visible;">
							<?php if($permission_row['whatsapp'] == 1){ ?>
                              <p><label for="previous_password" class="float-left p-2">WhatsApp:- </label><select class="form-control" id="whatsapp" name="whatsapp">
                                        <option value="0" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_whatsapp=="0" ? 'selected' : '');} if (isset($reopen_whatsapp)) { echo "selected";}?>>Restrict</option>
                                        <option value="1" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_whatsapp==1 ? 'selected' : '');} if (isset($reopen_whatsapp)) { echo "selected";}?>>Controller</option>
                                    </select>
                                </p>
							<?php }else{ ?>
								<p><label for="previous_password" class="float-left p-2 d-none">WhatsApp:- </label><select class="form-control d-none" id="whatsapp" name="whatsapp">
                                        <option value="0" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_whatsapp=="0" ? 'selected' : '');} if (isset($reopen_whatsapp)) { echo "selected";}?>>Restrict</option>
                                        <option value="1" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_whatsapp==1 ? 'selected' : '');} if (isset($reopen_whatsapp)) { echo "selected";}?>>Controller</option>
                                    </select>
                                </p>
							<?php }?>
                            </div>
                            <button type="button" class="collapsible">Profile Management</button>
                            <div class="content" style="position: relative; z-index: 9999; overflow: visible;">
							<?php if($permission_row['add_users'] == 1){ ?>
                              <p><label for="previous_password" class="float-left p-2">Add Users:- </label><select class="form-control" id="add_users" name="add_users">
                                        <option value="0" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_add_users==0 ? 'selected' : '');} if (isset($reopen_add_users)) { echo "selected";}?>>Restrict</option>
                                        <option value="1" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_add_users==1 ? 'selected' : '');} if (isset($reopen_add_users)) { echo "selected";}?>>Controller</option>
                                    </select></p>
							<?php } else{ ?>
								<p><label for="previous_password" class="float-left p-2 d-none">Add Users:- </label><select class="form-control d-none" id="add_users" name="add_users">
                                        <option value="0" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_add_users==0 ? 'selected' : '');} if (isset($reopen_add_users)) { echo "selected";}?>>Restrict</option>
                                        <option value="1" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_add_users==1 ? 'selected' : '');} if (isset($reopen_add_users)) { echo "selected";}?>>Controller</option>
                                    </select></p>
							<?php }if($permission_row['company_profile'] == 1){ ?>
                              <p><label for="previous_password" class="float-left p-2">Company Profile:- </label><select class="form-control" id="company_profile" name="company_profile">
                                        <option value="0" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_company_profile==0 ? 'selected' : '');} if (isset($reopen_company_profile)) { echo "selected";}?>>Restrict</option>
                                        <option value="1" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_company_profile==1 ? 'selected' : '');} if (isset($reopen_company_profile)) { echo "selected";}?>>Controller</option>
                                    </select></p>
							<?php } else { ?>
								<p><label for="previous_password" class="float-left p-2 d-none">Company Profile:- </label><select class="form-control d-none" id="company_profile" name="company_profile">
                                        <option value="0" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_company_profile==0 ? 'selected' : '');} if (isset($reopen_company_profile)) { echo "selected";}?>>Restrict</option>
                                        <option value="1" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_company_profile==1 ? 'selected' : '');} if (isset($reopen_company_profile)) { echo "selected";}?>>Controller</option>
                                    </select></p>
							<?php }if($permission_row['mail_panel'] == 1){ ?>
                                <p><label for="previous_password" class="float-left p-2">Mail Panel:- </label><select class="form-control" id="mail_panel" name="mail_panel">
                                        <option value="0" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_mail_panel==0 ? 'selected' : '');} if (isset($reopen_mail_panel)) { echo "selected";}?>>Restrict</option>
                                        <option value="1" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_mail_panel==1 ? 'selected' : '');} if (isset($reopen_mail_panel)) { echo "selected";}?>>Controller</option>
                                    </select></p>
							<?php } else{ ?> 
								<p><label for="previous_password" class="float-left p-2 d-none">Mail Panel:- </label><select class="form-control d-none" id="mail_panel" name="mail_panel">
                                        <option value="0" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_mail_panel==0 ? 'selected' : '');} if (isset($reopen_mail_panel)) { echo "selected";}?>>Restrict</option>
                                        <option value="1" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_mail_panel==1 ? 'selected' : '');} if (isset($reopen_mail_panel)) { echo "selected";}?>>Controller</option>
                                    </select></p>
							<?php }if($permission_row['api_setup'] == 1){ ?>
                                <p><label for="previous_password" class="float-left p-2">Api Setup:- </label><select class="form-control" id="api_setup" name="api_setup">
                                        <option value="0" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_api_setup==0 ? 'selected' : '');} if (isset($reopen_api_setup)) { echo "selected";}?>>Restrict</option>
                                        <option value="1" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_api_setup==1 ? 'selected' : '');} if (isset($reopen_api_setup)) { echo "selected";}?>>Controller</option>
                                    </select></p>
							<?php } else{ ?>
								<p><label for="previous_password" class="float-left p-2 d-none">Api Setup:- </label><select class="form-control d-none" id="api_setup" name="api_setup">
                                        <option value="0" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_api_setup==0 ? 'selected' : '');} if (isset($reopen_api_setup)) { echo "selected";}?>>Restrict</option>
                                        <option value="1" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_api_setup==1 ? 'selected' : '');} if (isset($reopen_api_setup)) { echo "selected";}?>>Controller</option>
                                    </select></p>
							<?php }if($permission_row['depart_panel'] == 1){ ?>
                                <p><label for="previous_password" class="float-left p-2">Department Panel:- </label><select class="form-control" id="depart_panel" name="depart_panel">
                                        <option value="0" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_depart_panel==0 ? 'selected' : '');} if (isset($reopen_depart_panel)) { echo "selected";}?>>Restrict</option>
                                        <option value="1" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_depart_panel==1 ? 'selected' : '');} if (isset($reopen_depart_panel)) { echo "selected";}?>>Controller</option>
                                    </select></p>
							<?php } else{ ?> 
								<p><label for="previous_password" class="float-left p-2 d-none">Department Panel:- </label><select class="form-control d-none" id="depart_panel" name="depart_panel">
                                        <option value="0" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_depart_panel==0 ? 'selected' : '');} if (isset($reopen_depart_panel)) { echo "selected";}?>>Restrict</option>
                                        <option value="1" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_depart_panel==1 ? 'selected' : '');} if (isset($reopen_depart_panel)) { echo "selected";}?>>Controller</option>
                                    </select></p>
							<?php }if($permission_row['design_panel'] == 1){ ?>
                                <p><label for="previous_password" class="float-left p-2">Designation Panel:- </label><select class="form-control" id="desig_panel" name="desig_panel">
                                        <option value="0" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_desig_panel==0 ? 'selected' : '');} if (isset($reopen_desig_panel)) { echo "selected";}?>>Restrict</option>
                                        <option value="1" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_desig_panel==1 ? 'selected' : '');} if (isset($reopen_desig_panel)) { echo "selected";}?>>Controller</option>
                                    </select></p>
							<?php } else{ ?>
								<p><label for="previous_password" class="float-left p-2 d-none">Designation Panel:- </label><select class="form-control d-none " id="desig_panel" name="desig_panel">
                                        <option value="0" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_desig_panel==0 ? 'selected' : '');} if (isset($reopen_desig_panel)) { echo "selected";}?>>Restrict</option>
                                        <option value="1" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_desig_panel==1 ? 'selected' : '');} if (isset($reopen_desig_panel)) { echo "selected";}?>>Controller</option>
                                    </select></p>
							<?php }if($permission_row['soft_export'] == 1){ ?>
                                <p><label for="previous_password" class="float-left p-2">Export:- </label><select class="form-control" id="soft_export" name="soft_export">
                                        <option value="0" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_soft_export==0 ? 'selected' : '');} if (isset($reopen_soft_export)) { echo "selected";}?>>Restrict</option>
                                        <option value="1" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_soft_export==1 ? 'selected' : '');} if (isset($reopen_soft_export)) { echo "selected";}?>>Controller</option>
                                    </select></p>
							<?php } else{ ?> 
								<p><label for="previous_password" class="float-left p-2 d-none">Export:- </label><select class="form-control d-none" id="soft_export" name="soft_export">
                                        <option value="0" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_soft_export==0 ? 'selected' : '');} if (isset($reopen_soft_export)) { echo "selected";}?>>Restrict</option>
                                        <option value="1" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_soft_export==1 ? 'selected' : '');} if (isset($reopen_soft_export)) { echo "selected";}?>>Controller</option>
                                    </select></p>
							<?php } ?>
                            </div>
					</div>
					<div class="form-group d-block col-md-4 table-responsive" id="crm_soft">
					    <label class="float-left p-2">ESP Dashboard Permission</label>
					    <button type="button" class="collapsible">Dashboard Permission</button>
                            <div class="content" style="position: relative; z-index: 9999; overflow: visible;">
								<?php if($permission_row['esp_latest_sales'] == 1){ ?>
									<p><label for="previous_password" class="float-left p-2">Latest Sales:- </label><select class="form-control" id="esp_latest_sales" name="esp_latest_sales">
											<option value="0" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_esp_latest_sales==0 ? 'selected' : '');} if (isset($reopen_esp_latest_sales)) { echo "selected";}?>>Restrict</option>
											<option value="1" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_esp_latest_sales==1 ? 'selected' : '');} if (isset($reopen_esp_latest_sales)) { echo "selected";}?>>Controller</option>
										</select></p>
								<?php }else{ ?> 
									<p><label for="previous_password" class="float-left p-2 d-none">Latest Sales:- </label><select class="form-control d-none" id="esp_latest_sales" name="esp_latest_sales">
                                        <option value="0" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_esp_latest_sales==0 ? 'selected' : '');} if (isset($reopen_esp_latest_sales)) { echo "selected";}?>>Restrict</option>
                                        <option value="1" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_esp_latest_sales==1 ? 'selected' : '');} if (isset($reopen_esp_latest_sales)) { echo "selected";}?>>Controller</option>
                                    </select></p>
								<?php }if($permission_row['esp_income_expense'] == 1){ ?>
									<p><label for="previous_password" class="float-left p-2">Income & Expense:- </label><select class="form-control" id="esp_income_expense" name="esp_income_expense">
											<option value="0" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_esp_income_expense==0 ? 'selected' : '');} if (isset($reopen_esp_income_expense)) { echo "selected";}?>>Restrict</option>
											<option value="1" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_esp_income_expense==1 ? 'selected' : '');} if (isset($reopen_esp_income_expense)) { echo "selected";}?>>Controller</option>
										</select></p>
								<?php } else{ ?>
									<p><label for="previous_password" class="float-left p-2 d-none">Income & Expense:- </label><select class="form-control d-none" id="esp_income_expense" name="esp_income_expense">
											<option value="0" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_esp_income_expense==0 ? 'selected' : '');} if (isset($reopen_esp_income_expense)) { echo "selected";}?>>Restrict</option>
											<option value="1" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_esp_income_expense==1 ? 'selected' : '');} if (isset($reopen_esp_income_expense)) { echo "selected";}?>>Controller</option>
										</select></p>
								<?php }if($permission_row['esp_attendence_graph'] == 1){ ?>
									<p><label for="previous_password" class="float-left p-2">Attendence:- </label><select class="form-control" id="esp_attendence" name="esp_attendence">
											<option value="0" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_esp_attendence==0 ? 'selected' : '');} if (isset($reopen_esp_attendence)) { echo "selected";}?>>Restrict</option>
											<option value="1" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_esp_attendence==1 ? 'selected' : '');} if (isset($reopen_esp_attendence)) { echo "selected";}?>>Controller</option>
										</select></p>
								<?php } else{ ?>
									<p><label for="previous_password" class="float-left p-2 d-none">Attendence:- </label><select class="form-control d-none" id="esp_attendence" name="esp_attendence">
                                        <option value="0" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_esp_attendence==0 ? 'selected' : '');} if (isset($reopen_esp_attendence)) { echo "selected";}?>>Restrict</option>
                                        <option value="1" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_esp_attendence==1 ? 'selected' : '');} if (isset($reopen_esp_attendence)) { echo "selected";}?>>Controller</option>
                                    </select></p>
								<?php }if($permission_row['esp_payment_received'] == 1){ ?>
									<p><label for="previous_password" class="float-left p-2">Payment Received:- </label><select class="form-control" id="esp_payment_received" name="esp_payment_received">
											<option value="" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_esp_payment_received==0 ? 'selected' : '');} if (isset($reopen_esp_payment_received)) { echo "selected";}?>>Restrict</option>
											<option value="1" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_esp_payment_received==1 ? 'selected' : '');} if (isset($reopen_esp_payment_received)) { echo "selected";}?>>Controller</option>
										</select></p>
								<?php } else{?>
									<p><label for="previous_password" class="float-left p-2 d-none">Payment Received:- </label><select class="form-control d-none" id="esp_payment_received" name="esp_payment_received">
                                        <option value="" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_esp_payment_received==0 ? 'selected' : '');} if (isset($reopen_esp_payment_received)) { echo "selected";}?>>Restrict</option>
                                        <option value="1" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_esp_payment_received==1 ? 'selected' : '');} if (isset($reopen_esp_payment_received)) { echo "selected";}?>>Controller</option>
                                    </select></p>
								<?php }if($permission_row['esp_payment_paid'] == 1){ ?>
                                <p><label for="previous_password" class="float-left p-2">Payment Paid:- </label><select class="form-control" id="esp_payment_paid" name="esp_payment_paid">
                                        <option value="" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_esp_payment_paid==0 ? 'selected' : '');} if (isset($reopen_esp_payment_paid)) { echo "selected";}?>>Restrict</option>
                                        <option value="1" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_esp_payment_paid==1 ? 'selected' : '');} if (isset($reopen_esp_payment_paid)) { echo "selected";}?>>Controller</option>
                                    </select></p>
								<?php }else {?> 
									<p><label for="previous_password" class="float-left p-2 d-none">Payment Paid:- </label><select class="form-control d-none" id="esp_payment_paid" name="esp_payment_paid">
                                        <option value="" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_esp_payment_paid==0 ? 'selected' : '');} if (isset($reopen_esp_payment_paid)) { echo "selected";}?>>Restrict</option>
                                        <option value="1" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_esp_payment_paid==1 ? 'selected' : '');} if (isset($reopen_esp_payment_paid)) { echo "selected";}?>>Controller</option>
                                    </select></p>
								<?php }if($permission_row['esp_highest_outstanding'] == 1){ ?>
									<p><label for="previous_password" class="float-left p-2">Highest Outstanding:- </label><select class="form-control" id="esp_highest_outstand" name="esp_highest_outstand">
											<option value="" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_esp_highest_outstand==0 ? 'selected' : '');} if (isset($reopen_esp_highest_outstand)) { echo "selected";}?>>Restrict</option>
											<option value="1" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_esp_highest_outstand==1 ? 'selected' : '');} if (isset($reopen_esp_highest_outstand)) { echo "selected";}?>>Controller</option>
										</select></p>
								<?php } else{ ?>
									<p><label for="previous_password" class="float-left p-2 d-none">Highest Outstanding:- </label><select class="form-control d-none" id="esp_highest_outstand" name="esp_highest_outstand">
                                        <option value="" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_esp_highest_outstand==0 ? 'selected' : '');} if (isset($reopen_esp_highest_outstand)) { echo "selected";}?>>Restrict</option>
                                        <option value="1" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_esp_highest_outstand==1 ? 'selected' : '');} if (isset($reopen_esp_highest_outstand)) { echo "selected";}?>>Controller</option>
                                    </select></p>
								<?php }if($permission_row['esp_oto_board'] == 1){ ?>
                                <p><label for="previous_password" class="float-left p-2">OTO Board:- </label><select class="form-control" id="esp_oto_board" name="esp_oto_board">
                                        <option value="" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_esp_oto_board==0 ? 'selected' : '');} if (isset($reopen_esp_oto_board)) { echo "selected";}?>>Restrict</option>
                                        <option value="1" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_esp_oto_board==1 ? 'selected' : '');} if (isset($reopen_esp_oto_board)) { echo "selected";}?>>Controller</option>
                                    </select></p>
								<?php } else {?>
									<p><label for="previous_password" class="float-left p-2 d-none">OTO Board:- </label><select class="form-control d-none" id="esp_oto_board" name="esp_oto_board">
                                        <option value="" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_esp_oto_board==0 ? 'selected' : '');} if (isset($reopen_esp_oto_board)) { echo "selected";}?>>Restrict</option>
                                        <option value="1" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_esp_oto_board==1 ? 'selected' : '');} if (isset($reopen_esp_oto_board)) { echo "selected";}?>>Controller</option>
                                    </select></p>
								<?php }if($permission_row['esp_latest_enquiry'] == 1){ ?>
									<p><label for="previous_password" class="float-left p-2">Latest Enquiry:- </label><select class="form-control" id="esp_latest_enquiry" name="esp_latest_enquiry">
											<option value="" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_esp_latest_enquiry==0 ? 'selected' : '');} if (isset($reopen_esp_latest_enquiry)) { echo "selected";}?>>Restrict</option>
											<option value="1" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_esp_latest_enquiry==1 ? 'selected' : '');} if (isset($reopen_esp_latest_enquiry)) { echo "selected";}?>>Controller</option>
										</select></p>
								<?php } else{?>
									<p><label for="previous_password" class="float-left p-2 d-none">Latest Enquiry:- </label><select class="form-control d-none" id="esp_latest_enquiry" name="esp_latest_enquiry">
                                        <option value="" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_esp_latest_enquiry==0 ? 'selected' : '');} if (isset($reopen_esp_latest_enquiry)) { echo "selected";}?>>Restrict</option>
                                        <option value="1" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_esp_latest_enquiry==1 ? 'selected' : '');} if (isset($reopen_esp_latest_enquiry)) { echo "selected";}?>>Controller</option>
                                    </select></p>
								<?php }if($permission_row['esp_search_client'] == 1){ ?>
									<p><label for="previous_password" class="float-left p-2">Search Client:- </label><select class="form-control" id="esp_search_client" name="esp_search_client">
											<option value="" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_esp_search_client==0 ? 'selected' : '');} if (isset($reopen_esp_search_client)) { echo "selected";}?>>Restrict</option>
											<option value="1" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_esp_search_client==1 ? 'selected' : '');} if (isset($reopen_esp_search_client)) { echo "selected";}?>>Controller</option>
										</select></p>
								<?php }else{?>
									<p><label for="previous_password" class="float-left p-2 d-none">Search Client:- </label><select class="form-control d-none" id="esp_search_client" name="esp_search_client">
                                        <option value="" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_esp_search_client==0 ? 'selected' : '');} if (isset($reopen_esp_search_client)) { echo "selected";}?>>Restrict</option>
                                        <option value="1" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_esp_search_client==1 ? 'selected' : '');} if (isset($reopen_esp_search_client)) { echo "selected";}?>>Controller</option>
                                    </select></p>
								<?php }if($permission_row['esp_trading_invent'] == 1){ ?>
									<p><label for="previous_password" class="float-left p-2">Trading Inventory:- </label><select class="form-control" id="esp_trading_inventory" name="esp_trading_inventory">
											<option value="" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_esp_trading_inventory==0 ? 'selected' : '');} if (isset($reopen_esp_trading_inventory)) { echo "selected";}?>>Restrict</option>
											<option value="1" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_esp_trading_inventory==1 ? 'selected' : '');} if (isset($reopen_esp_trading_inventory)) { echo "selected";}?>>Controller</option>
										</select></p>
								<?php } else{ ?>
									<p><label for="previous_password" class="float-left p-2 d-none">Trading Inventory:- </label><select class="form-control d-none" id="esp_trading_inventory" name="esp_trading_inventory">
                                        <option value="" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_esp_trading_inventory==0 ? 'selected' : '');} if (isset($reopen_esp_trading_inventory)) { echo "selected";}?>>Restrict</option>
                                        <option value="1" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_esp_trading_inventory==1 ? 'selected' : '');} if (isset($reopen_esp_trading_inventory)) { echo "selected";}?>>Controller</option>
                                    </select></p>
								<?php }if($permission_row['esp_bank_balance'] == 1){ ?>
									<p><label for="previous_password" class="float-left p-2">Bank Balance:- </label><select class="form-control" id="esp_bank_balance" name="esp_bank_balance">
											<option value="" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_esp_bank_balance==0 ? 'selected' : '');} if (isset($reopen_esp_bank_balance)) { echo "selected";}?>>Restrict</option>
											<option value="1" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_esp_bank_balance==1 ? 'selected' : '');} if (isset($reopen_esp_bank_balance)) { echo "selected";}?>>Controller</option>
										</select></p>
								<?php } else{ ?>
									<p><label for="previous_password" class="float-left p-2 d-none">Bank Balance:- </label><select class="form-control d-none" id="esp_bank_balance" name="esp_bank_balance">
                                        <option value="" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_esp_bank_balance==0 ? 'selected' : '');} if (isset($reopen_esp_bank_balance)) { echo "selected";}?>>Restrict</option>
                                        <option value="1" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_esp_bank_balance==1 ? 'selected' : '');} if (isset($reopen_esp_bank_balance)) { echo "selected";}?>>Controller</option>
                                    </select></p>
								<?php }?>
                            </div>
					</div>
					<div class="form-group d-block col-md-4 table-responsive" id="crm_soft">
					    <label class="float-left p-2">CRM Software Permission</label>
					    <button type="button" class="collapsible">CRM Setup</button>
                            <div class="content" style="position: relative; z-index: 9999; overflow: visible;">
								<?php if($permission_row['data_record'] == 1){ ?>
									<p><label for="previous_password" class="float-left p-2">Data Record:- </label><select class="form-control" id="crm_data_record" name="crm_data_record">
											<option value="0" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_crm_data_record==0 ? 'selected' : '');} if (isset($reopen_crm_data_record)) { echo "selected";}?>>Restrict</option>
											<option value="1" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_crm_data_record==1 ? 'selected' : '');} if (isset($reopen_crm_data_record)) { echo "selected";}?>>Controller</option>
										</select></p>
								<?php }else { ?>
									<p><label for="previous_password" class="float-left p-2 d-none">Data Record:- </label><select class="form-control d-none" id="crm_data_record" name="crm_data_record">
                                        <option value="0" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_crm_data_record==0 ? 'selected' : '');} if (isset($reopen_crm_data_record)) { echo "selected";}?>>Restrict</option>
                                        <option value="1" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_crm_data_record==1 ? 'selected' : '');} if (isset($reopen_crm_data_record)) { echo "selected";}?>>Controller</option>
                                    </select></p>
								<?php }if($permission_row['record_transfer'] == 1){ ?>
									<p><label for="previous_password" class="float-left p-2">Record Transfer:- </label><select class="form-control" id="crm_rec_tranf" name="crm_rec_tranf">
											<option value="0" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_crm_rec_tranf==0 ? 'selected' : '');} if (isset($reopen_crm_rec_tranf)) { echo "selected";}?>>Restrict</option>
											<option value="1" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_crm_rec_tranf==1 ? 'selected' : '');} if (isset($reopen_crm_rec_tranf)) { echo "selected";}?>>Controller</option>
										</select></p>
								<?php } else{ ?>
									<p><label for="previous_password" class="float-left p-2 d-none">Record Transfer:- </label><select class="form-control d-none" id="crm_rec_tranf" name="crm_rec_tranf">
                                        <option value="0" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_crm_rec_tranf==0 ? 'selected' : '');} if (isset($reopen_crm_rec_tranf)) { echo "selected";}?>>Restrict</option>
                                        <option value="1" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_crm_rec_tranf==1 ? 'selected' : '');} if (isset($reopen_crm_rec_tranf)) { echo "selected";}?>>Controller</option>
                                    </select></p>
								<?php }if($permission_row['add_clientConfig'] == 1){ ?>
									<p><label for="previous_password" class="float-left p-2">Client Configuration:- </label><select class="form-control" id="crm_clientConfig" name="crm_clientConfig">
											<option value="" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_add_clientConfig==0 ? 'selected' : '');} if (isset($reopen_add_clientConfig)) { echo "selected";}?>>Restrict</option>
											<option value="1" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_add_clientConfig==1 ? 'selected' : '');} if (isset($reopen_add_clientConfig)) { echo "selected";}?>>Controller</option>
										</select></p>
								<?php } else{ ?>
									<p><label for="previous_password" class="float-left p-2 d-none">Client Configuration:- </label><select class="form-control d-none" id="crm_clientConfig" name="crm_clientConfig">
                                        <option value="" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_add_clientConfig==0 ? 'selected' : '');} if (isset($reopen_add_clientConfig)) { echo "selected";}?>>Restrict</option>
                                        <option value="1" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_add_clientConfig==1 ? 'selected' : '');} if (isset($reopen_add_clientConfig)) { echo "selected";}?>>Controller</option>
                                    </select></p>
								<?php }?>
                            </div>
                            <button type="button" class="collapsible">CRM Utility</button>
                            <div class="content" style="position: relative; z-index: 9999; overflow: visible;">
								<?php if($permission_row['mom_admin'] == 1){ ?>
									<p><label for="previous_password" class="float-left p-2">MOM Filter:- </label><select class="form-control" id="crm_admin_mom" name="crm_admin_mom">
											<option value="0" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_mom_admin==0 ? 'selected' : '');} if (isset($reopen_mom_admin)) { echo "selected";}?>>Restrict</option>
											<option value="1" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_mom_admin==1 ? 'selected' : '');} if (isset($reopen_mom_admin)) { echo "selected";}?>>Controller</option>
										</select></p>
								<?php } else{ ?>
									<p><label for="previous_password" class="float-left p-2 d-none">MOM Filter:- </label><select class="form-control d-none" id="crm_admin_mom" name="crm_admin_mom">
                                        <option value="0" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_mom_admin==0 ? 'selected' : '');} if (isset($reopen_mom_admin)) { echo "selected";}?>>Restrict</option>
                                        <option value="1" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_mom_admin==1 ? 'selected' : '');} if (isset($reopen_mom_admin)) { echo "selected";}?>>Controller</option>
                                    </select></p>
								<?php }if($permission_row['trace_contact'] == 1){ ?>
									<p><label for="previous_password" class="float-left p-2">Trace Contact:- </label><select class="form-control" id="crm_trace_cont" name="crm_trace_cont">
											<option value="0" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_crm_trace_cont==0 ? 'selected' : '');} if (isset($reopen_crm_trace_cont)) { echo "selected";}?>>Restrict</option>
											<option value="1" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_crm_trace_cont==1 ? 'selected' : '');} if (isset($reopen_crm_trace_cont)) { echo "selected";}?>>Controller</option>
										</select></p>
								<?php } else{ ?>
									<p><label for="previous_password" class="float-left p-2 d-none">Trace Contact:- </label><select class="form-control d-none" id="crm_trace_cont" name="crm_trace_cont">
                                        <option value="0" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_crm_trace_cont==0 ? 'selected' : '');} if (isset($reopen_crm_trace_cont)) { echo "selected";}?>>Restrict</option>
                                        <option value="1" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_crm_trace_cont==1 ? 'selected' : '');} if (isset($reopen_crm_trace_cont)) { echo "selected";}?>>Controller</option>
                                    </select></p>
								<?php }if($permission_row['add_Admin_filter	'] == 1){ ?>
									<p><label for="previous_password" class="float-left p-2">Admin Filter:- </label><select class="form-control" id="crm_admin_filter" name="crm_admin_filter">
											<option value="0" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_add_Admin_filter==0 ? 'selected' : '');} if (isset($reopen_add_Admin_filter)) { echo "selected";}?>>Restrict</option>
											<option value="1" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_add_Admin_filter==1 ? 'selected' : '');} if (isset($reopen_add_Admin_filter)) { echo "selected";}?>>Controller</option>
										</select></p>
								<?php } else{ ?> 
									<p><label for="previous_password" class="float-left p-2 d-none">Admin Filter:- </label><select class="form-control d-none" id="crm_admin_filter" name="crm_admin_filter">
                                        <option value="0" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_add_Admin_filter==0 ? 'selected' : '');} if (isset($reopen_add_Admin_filter)) { echo "selected";}?>>Restrict</option>
                                        <option value="1" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_add_Admin_filter==1 ? 'selected' : '');} if (isset($reopen_add_Admin_filter)) { echo "selected";}?>>Controller</option>
                                    </select></p>
								<?php }?>
                            </div>
                            <button type="button" class="collapsible">Job Progress</button>
                            <div class="content" style="position: relative; z-index: 9999; overflow: visible;">
								<?php if($permission_row['add_jobProg'] == 1){ ?>
									<p><label for="previous_password" class="float-left p-2">Job Progress:- </label><select class="form-control" id="crm_job" name="crm_job">
											<option value="" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_add_jobProg==0 ? 'selected' : '');} if (isset($reopen_add_jobProg)) { echo "selected";}?>>Restrict</option>
											<option value="1" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_add_jobProg==1 ? 'selected' : '');} if (isset($reopen_add_jobProg)) { echo "selected";}?>>Controller</option>
										</select></p>
								<?php } else{ ?> 
									<p><label for="previous_password" class="float-left p-2 d-none">Job Progress:- </label><select class="form-control d-none" id="crm_job" name="crm_job">
                                        <option value="" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_add_jobProg==0 ? 'selected' : '');} if (isset($reopen_add_jobProg)) { echo "selected";}?>>Restrict</option>
                                        <option value="1" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_add_jobProg==1 ? 'selected' : '');} if (isset($reopen_add_jobProg)) { echo "selected";}?>>Controller</option>
                                    </select></p>
								<?php }?>
                            </div>
                            <button type="button" class="collapsible">Bidding</button>
                            <div class="content" style="position: relative; z-index: 9999; overflow: visible;">
								<?php if($permission_row['addBidding'] == 1){ ?>
									<p><label for="previous_password" class="float-left p-2">Bidding:- </label><select class="form-control" id="crm_bidding" name="crm_bidding">
											<option value="" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_addBidding==0 ? 'selected' : '');} if (isset($reopen_addBidding)) { echo "selected";}?>>Restrict</option>
											<option value="1" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_addBidding==1 ? 'selected' : '');} if (isset($reopen_addBidding)) { echo "selected";}?>>Controller</option>
										</select></p>
								<?php } else{ ?> 
									<p><label for="previous_password" class="float-left p-2 d-none">Bidding:- </label><select class="form-control d-none" id="crm_bidding" name="crm_bidding">
                                        <option value="" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_addBidding==0 ? 'selected' : '');} if (isset($reopen_addBidding)) { echo "selected";}?>>Restrict</option>
                                        <option value="1" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_addBidding==1 ? 'selected' : '');} if (isset($reopen_addBidding)) { echo "selected";}?>>Controller</option>
                                    </select></p>
								<?php }?>
                            </div>
                            <button type="button" class="collapsible">Team Leader</button>
                            <div class="content" style="position: relative; z-index: 9999; overflow: visible;">
                                <p><label for="previous_password" class="float-left p-2">TL:- </label><select class="form-control" id="crm_tl" name="crm_tl">
                                        <option value="" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_addtl==0 ? 'selected' : '');} if (isset($reopen_addtl)) { echo "selected";}?>>Restrict</option>
                                        <option value="1" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_addtl==1 ? 'selected' : '');} if (isset($reopen_addtl)) { echo "selected";}?>>Controller</option>
                                    </select></p>
								<?php //} ?>
                                <p><select name="crm_tl_member[]" id="crm_tl_member" class="form-control col-2" style="width:100vh;" multiple multiselect-search="true" placeholder="select_member" multiselect-select-all="true">
                                        <?php
                    						$user = "select * from `users` where `company_id` = '".$_SESSION['company_id']."' AND `user_status` != 0 order by username";
                    						$user_result = mysqli_query($con, $user);
                    						while($user_show = mysqli_fetch_array($user_result)){
                    					?>
                    						<option value="<?= $user_show['username']; ?>" <?php if (isset($_POST['editUserbtn'])) { echo in_array($user_show['username'], $edit_tlMember) ? 'selected' : ''; }?>><?php echo ucfirst($user_show['firstname']),"  ",ucfirst($user_show['middlename']); ?></option>
                    					<?php } ?>
                					</select></p>
                            </div>
                            <button type="button" class="collapsible">CallAric</button>
                            <div class="content" style="position: relative; z-index: 9999; overflow: visible;">
								<?php if(($permission_row['esp_latest_sales'] == 1) || ($permission_row['esp_income_expense'] == 1) || ($permission_row['esp_attendence_graph'] == 1)|| ($permission_row['esp_payment_received'] == 1)|| ($permission_row['esp_payment_paid'] == 1)||($permission_row['esp_highest_outstanding'] == 1) || ($permission_row['esp_oto_board'] == 1) || ($permission_row['esp_latest_enquiry'] == 1)|| ($permission_row['esp_search_client'] == 1)|| ($permission_row['esp_trading_invent'] == 1)|| ($permission_row['esp_bank_balance'] == 1)){ ?>
									<p><label for="previous_password" class="float-left p-2">Dashboard:- </label><select class="form-control" id="ca_dashboard" name="ca_dashboard">
											<option value="" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_ca_dashboard==0 ? 'selected' : '');} if (isset($reopen_ca_dashboard)) { echo "selected";}?>>Restrict</option>
											<option value="1" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_ca_dashboard==1 ? 'selected' : '');} if (isset($reopen_ca_dashboard)) { echo "selected";}?>>Controller</option>
										</select></p>
								<?php } else { ?>
									<p><label for="previous_password" class="float-left p-2 d-none">Dashboard:- </label><select class="form-control d-none" id="ca_dashboard" name="ca_dashboard">
                                        <option value="" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_ca_dashboard==0 ? 'selected' : '');} if (isset($reopen_ca_dashboard)) { echo "selected";}?>>Restrict</option>
                                        <option value="1" <?php if (isset($_POST['editUserbtn'])) { echo ($edit_ca_dashboard==1 ? 'selected' : '');} if (isset($reopen_ca_dashboard)) { echo "selected";}?>>Controller</option>
                                    </select></p>
								<?php  }?>
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
					<?php if (isset($_POST['editUserbtn']) || isset($reopen_user_name)) {
						echo '<input type="submit" name="user_update" id="user_update" value="UPDATE" class="btn btn-vowel d-none">';
						echo '<input type="button" name="temp_user_update" id="temp_user_update" value="UPDATE" class="btn btn-vowel">';
					}else{
						echo '<input type="submit" name="user_save"  id="user_save" value="SAVE" class="btn btn-vowel d-none">';
						echo '<input type="button" name="temp_user_save" id="temp_user_save" value="SAVE" class="btn btn-vowel">';
					}?>
				</div>
			</form>
			<div class="table-responsive d-block" id="dataTable_users">
			
						<?php 
							$fetch_dsc_data = "SELECT * FROM `users` WHERE `company_id` = '".$_SESSION['company_id']."'";
							$run_dsc_data = mysqli_query($con,$fetch_dsc_data);
							while ($row = mysqli_fetch_array($run_dsc_data)) { ?>
								<tr>
									<td>
										<form method="post">
											<input type="hidden" name="userEditID" value="<?= $row['id']; ?>">
											<button class="editUserbtn mr-2" name="editUserbtn" id="editUserbtn" style="padding: 0;border: none;background: none; outline:none;" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fas fa-pencil-alt fa-lg" style="color:green;"></i></button>
										</form>
									</td>
									<td>
										<form method="post">
											<input type="hidden" name="userDeleteID" id="userDeleteID" value="<?= $row['id']; ?>"><span data-toggle="modal" data-target="#userConfirmMessagePopup">
											<button type="button" name="userDeletebtn" class="userDeletebtn" id="userDeletebtn" data-toggle="tooltip" data-placement="top" title="Delete" style="padding: 0;border: none;background: none; outline:none; color: red;"><i class="fas fa-trash-alt fa-lg text-orange"></i></button></span>
										</form>
									</td>
									<td><?= $row['firstname']; ?></td>
									<td><?= $row['lastname']; ?></td>
									<td><?= $row['username']; ?></td>
									<td><?= ($row['dsc_subscriber'] == 1)?'<i class="fa fa-2x fa-check text-success" aria-hidden="true"></i>':'<i class="fa fa-2x fa-times text-danger" aria-hidden="true"></i>'; ?></td>
									<td><?= ($row['add_users'] == 1)?'<i class="fa fa-2x fa-check text-success" aria-hidden="true"></i>':'<i class="fa fa-2x fa-times text-danger" aria-hidden="true"></i>'; ?></td>
								</tr>
					<?php   }
						?>
					</tbody>
				</table> 
			</div>
		</div>
	</div>

<!--Delete Confirm Popup-->
<div class="modal fade" data-backdrop="static" data-keyboard="false" id="userConfirmMessagePopup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
    	<form method="post">
	      <div class="modal-header">
	        <img src="html/images/logo.png" alt="Vowel" style="width: 150px; height: 55px;" class="logo navbar-brand mr-auto">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body bg-light">
	        <input type="hidden" readonly id="tempUserIDdel" name="tempUserIDdel" class="tempUserIDdel">
	        <?php echo "<p>Do You Really Want To Delete This Record ?</p>"; ?>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">NO</button>
	        <button type="submit" name="user_delete" id="user_delete" class="btn btn-vowel">YES</button>
	      </div>
	    </form>
    </div>
  </div>
</div>
<script type="text/javascript" src="..//js/virtual-select1.min.js"></script>

<script type="text/javascript">
$(document).ready(function () {
  VirtualSelect.init({ ele: 'select' });
  
    
  
    // Show select members of Team Leader
    $('#crm_tl_member').on('change', function() {
        var value = $('#crm_tl_member').val(); // Get the value
        value = String(value); // Convert value to a string
    
        var names = value.split(','); // Split the string by commas
        // $('#fetch_select_members').empty(); // Clear previous options
    
        // // Loop through each name and append it as a separate option
        var namesText = names.map(function(name) {
        return name.trim(); // Remove leading/trailing whitespaces
        }).join('\n');
    
        // Set the joined names as the value of the textarea
        $('#fetch_select_members').val(namesText);
    });
});
	$(document).ready(function(){
	     var MobileAvailable = false;
	    $('#mobile_no').on('keyup',function(){
	        var mobile = $('#mobile_no').val();
	        let userEditID_temp = $('#userEditID_temp').val();
	        $.ajax({
	            url: "html/check.php",
	            method: "post",
	            data: {verify_mob:mobile,userEditID_temp},
	            success:function(data){
	                if(data == 1){
	                    MobileAvailable = false;
	                    $('#mobile_status').html('Already Exist..!').css({'color':'red'});
						$('#mobile_no').addClass("border border-danger");
						$('.rsd').hide();
	                } else {
	                    $('.rsd').show();
	                    MobileAvailable = true;
	                    $('#mobile_status').html('').css({'color':'green'});
						$('#user_name').removeClass("border border-danger");
	                }
	            }
	        })
	    });
	    
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
	    
		$('#dataTable_users').load('html/AddUsers_DataList.php').fadeIn("slow");
		var selectedClientName = [];
		var selectedVendorName = [];
		var EmailAvailable = false;
		var PasswordMatched = false;
		var editMode = false;
		if ($('#userEditID_temp').val() != "") {
			editMode = true;
			PasswordMatched = true;
			EmailAvailable = true;
		}
		function getUnique(array){
			var uniqueArray = [];
			
			// Loop through array values
			for(i=0; i < array.length; i++){
				if(uniqueArray.indexOf(array[i]) === -1) {
					uniqueArray.push(array[i]);
				}
			}
			return uniqueArray;
		}
		$("#user_name").blur(function(){
			let user_name = $('#user_name').val();
			let userEditID_temp = $('#userEditID_temp').val();
			$('#pleaseWaitDialog').modal('show');
			$.ajax({
				url:"html/ProcessUserManagement.php",
				method:"post",
				data: {email:user_name,editMode,userEditID_temp},
				dataType:"text",
				success:function(data)
				{
					// alert(data);
					if (data == "already_exist") {
						EmailAvailable = false;
						$('#user_name_status').html('Already Exist..!').css({'color':'red'});
						$('#user_name').addClass("border border-danger");
					}else{
						EmailAvailable = true;
						$('#user_name_status').html('').css({'color':'green'});
						$('#user_name').removeClass("border border-danger");
					}
				},complete: function (data) {
					$('#pleaseWaitDialog').modal('hide');
				}
			});
		});

		$("#re_type_password").blur(function(){
			if ($('#password').val() == $('#re_type_password').val()) {
				PasswordMatched = true;
				$('#re_type_password_status').html('').css({'color':'green'});
				$('#re_type_password').removeClass("border border-danger");
			}else{
				PasswordMatched = false;
				$('#re_type_password_status').html('Both Password must be same..!').css({'color':'red'});
				$('#re_type_password').addClass("border border-danger");
			}
		});
		//alert(selectedClientName);

		$("#temp_user_save").click(function(){
			if ( $('#addNew_users')[0].checkValidity() ) {
				// the form is valid
				// alert('Valid');
				if ((EmailAvailable == true) && (PasswordMatched == true)) {
					$('#user_save').click();
					// $('#AskingMakeIncomePaymentPopup').modal('show');
				}
				//$('#makePaymentLink').attr('href','income');
			}else{
				$('#user_save').click();
				//$('#makePaymentLink').attr('href','#');
				//alert('In-valid');
			}
		});
		
		$("#temp_user_update").click(function(){
			var client_name = $('#client_name').val();
// 			alert(client_name.length);
			var vendor_name = $('#vendor_name').val();
			var user_name = $('#user_name').val();
			// alert(user_name);
			$('#pleaseWaitDialog').modal('show');
			$.ajax({
				url:"html/EditUser.php",
				method:"post",
				data: {user_name, client_name, vendor_name},
				dataType:"text",
				success:function(data)
				{
					// alert(data);
					$('#EditUserDiv').html(data);
				},complete: function (data) {
					$('#pleaseWaitDialog').modal('hide');
					if ( $('#addNew_users')[0].checkValidity() ) {
						// the form is valid
						// alert('Valid');
						if ((EmailAvailable == true) && (PasswordMatched == true)) {
							$('#user_update').click();
							// $('#AskingMakeIncomePaymentPopup').modal('show');
						}
						//$('#makePaymentLink').attr('href','income');
					}else{
						$('#user_update').click();
						//$('#makePaymentLink').attr('href','#');
						//alert('In-valid');
					}
				}
			});
		});
		
		$("#searchClientName").keyup(function () {
			var searchClientName = $('#searchClientName').val();
			// var from_date = $("#from_date").val();
			// var to_date = $("#to_date").val();
			//alert(from_date);
			// $("#select_allClientName").prop("checked", false);
			$('#client_name-status').html('').css({'color':'green'});
			$('#client_name').removeClass("border border-danger");
			// $('#tableDiv').hide();
			$('#pleaseWaitDialog').modal('show');
			$.ajax({
				url:"html/ProcessUserManagement.php",
				method:"post",
				data: {searchClientName:searchClientName},
				dataType:"text",
				success:function(data)
				{
					// alert(data);
					// $('#tableDiv').show();
					// $('#showReports').html(data);
					var array = JSON.parse(data);
					$('#client_name').empty();
					//$('#portfolio').empty();
					for(var i=0; i<array.length;i++){
						$('#client_name').append(new Option(array[i], array[i]));
					}
				},complete: function (data) {
					$('#pleaseWaitDialog').modal('hide');
						//printWithAjax();
						$(".client_multiple_select").mousedown(function(e) {
						if (e.target.tagName == "OPTION") 
						{
							return; //don't close dropdown if i select option
						}
						$(this).toggleClass('client_multiple_select_active'); //close dropdown if click inside <select> box
					});
					$(".client_multiple_select").on('blur', function(e) {
						$(this).removeClass('client_multiple_select_active'); //close dropdown if click outside <select>
					});

					var selectTop;
					var mustChangeScrollTop = false;

					$('.client_multiple_select').on('scroll',function (e) {
						if (mustChangeScrollTop){
							$(this).scrollTop(selectTop);
								mustChangeScrollTop = false;
						}
						return true;
					});
					$('.client_multiple_select option').mousedown(function(e) { //no ctrl to select multiple
						e.preventDefault();
						selectTop = $(this).parent().scrollTop();
						$(this).prop('selected', $(this).prop('selected') ? false : true); //set selected options on click
						$(this).parent().change(); //trigger change event
						mustChangeScrollTop = true;
						//alert($(this).prop('selected'));
						/*if(!selectedClientName.includes($(this).val())) {
							//this.items.push(item);
							selectedClientName.push($(this).val());
							//console.log(this.items);
						}else if ($(this).prop('selected') == false) {
							selectedClientName.remove($(this).val());
						}*/
						return false;
					});

					$('#client_name option').each(function() {
						if (this.selected){
							//alert('selected - ' + this.value);
							selectedClientName.push(this.value);
							tempClientValue.push(this.value);
						}/*else {
							selectedClientName = $(selectedClientName).not([this.value]).get();
							tempClientValue = $(tempClientValue).not([this.value]).get();
							//alert('not selected');
						}*/
					});

					$("#client_name").on('change', function() {
						var selected = $("#client_name").val().toString(); //here I get all options and convert to string
						var document_style = document.documentElement.style;
						/*if(selected !== "")
						document_style.setProperty('--text', "'Selected: "+selected+"'");
						else
						document_style.setProperty('--text', "'Select values'");*/
					});

					if (selectedClientName.length > 0) {
						$.each( selectedClientName, function( i, l ){
							//alert( "Index #" + i + ": " + l );
							$("#client_name").find("option[value='"+l+"']").attr("selected",true);
						});
					}
				}
			});
		});

		$("#searchVendorName").keyup(function () {
			var searchVendorName = $('#searchVendorName').val();
			// var from_date = $("#from_date").val();
			// var to_date = $("#to_date").val();
			//alert(from_date);
			// $("#select_allVendorName").prop("checked", false);
			$('#vendor_name-status').html('').css({'color':'green'});
			$('#vendor_name').removeClass("border border-danger");
			// $('#tableDiv').hide();
			$('#pleaseWaitDialog').modal('show');
			$.ajax({
				url:"html/ProcessUserManagement_Vendor.php",
				method:"post",
				data: {searchVendorName:searchVendorName},
				dataType:"text",
				success:function(data)
				{
					// alert(data);
					// $('#tableDiv').show();
					// $('#showReports').html(data);
					var array = JSON.parse(data);
					$('#vendor_name').empty();
					//$('#portfolio').empty();
					for(var i=0; i<array.length;i++){
						$('#vendor_name').append(new Option(array[i], array[i]));
					}
				},complete: function (data) {
					$('#pleaseWaitDialog').modal('hide');
						//printWithAjax();
						$(".vendor_multiple_select").mousedown(function(e) {
						if (e.target.tagName == "OPTION") 
						{
							return; //don't close dropdown if i select option
						}
						$(this).toggleClass('vendor_multiple_select_active'); //close dropdown if click inside <select> box
					});
					$(".vendor_multiple_select").on('blur', function(e) {
						$(this).removeClass('vendor_multiple_select_active'); //close dropdown if click outside <select>
					});

					var selectTop;
					var mustChangeScrollTop = false;

					$('.vendor_multiple_select').on('scroll',function (e) {
						if (mustChangeScrollTop){
							$(this).scrollTop(selectTop);
								mustChangeScrollTop = false;
						}
						return true;
					});
					$('.vendor_multiple_select option').mousedown(function(e) { //no ctrl to select multiple
						e.preventDefault();
						selectTop = $(this).parent().scrollTop();
						$(this).prop('selected', $(this).prop('selected') ? false : true); //set selected options on click
						$(this).parent().change(); //trigger change event
						mustChangeScrollTop = true;
						//alert($(this).prop('selected'));
						/*if(!selectedVendorName.includes($(this).val())) {
							//this.items.push(item);
							selectedVendorName.push($(this).val());
							//console.log(this.items);
						}else if ($(this).prop('selected') == false) {
							selectedVendorName.remove($(this).val());
						}*/
						return false;
					});

					$('#vendor_name option').each(function() {
						if (this.selected){
							//alert('selected - ' + this.value);
							selectedVendorName.push(this.value);
							tempVendorValue.push(this.value);
						}/*else {
							selectedVendorName = $(selectedVendorName).not([this.value]).get();
							tempVendorValue = $(tempVendorValue).not([this.value]).get();
							//alert('not selected');
						}*/
					});

					$("#vendor_name").on('change', function() {
						var selected = $("#vendor_name").val().toString(); //here I get all options and convert to string
						var document_style = document.documentElement.style;
						/*if(selected !== "")
						document_style.setProperty('--text', "'Selected: "+selected+"'");
						else
						document_style.setProperty('--text', "'Select values'");*/
					});

					if (selectedVendorName.length > 0) {
						$.each( selectedVendorName, function( i, l ){
							//alert( "Index #" + i + ": " + l );
							$("#vendor_name").find("option[value='"+l+"']").attr("selected",true);
						});
					}
				}
			});
		});
		// var from_date = $("#from_date").val();
		// var to_date = $("#to_date").val();
		//alert(from_date);
		$("#select_allClientName").prop("checked", false);
		$('#client_name-status').html('').css({'color':'green'});
		$('#client_name').removeClass("border border-danger");
		// $('#tableDiv').hide();
		$('#pleaseWaitDialog').modal('show');
		$.ajax({
			url:"html/ProcessUserManagement.php",
			method:"post",
			dataType:"text",
			success:function(data)
			{
				//alert(data);
				if (data != 'none') {
					var array = JSON.parse(data);
					$('#client_name').empty();
					// $('#portfolio').empty();
					for(var i=0; i<array.length;i++){
						$('#client_name').append(new Option(array[i], array[i]));
					}
					let clientName_temp = '<?php if (isset($_POST['editUserbtn'])) echo implode(',', $SelectedClientIds); ?>';
					// alert(clientName_temp);
					if ($("#userEditID_temp").val() != "") {
						$('#client_name').val(clientName_temp.split(","));
					}
				}
			},complete: function (data) {
				$('#pleaseWaitDialog').modal('hide');
					//printWithAjax();
					$(".client_multiple_select").mousedown(function(e) {
					if (e.target.tagName == "OPTION") 
					{
						return; //don't close dropdown if i select option
					}
					$(this).toggleClass('client_multiple_select_active'); //close dropdown if click inside <select> box
				});
				$(".client_multiple_select").on('blur', function(e) {
					$(this).removeClass('client_multiple_select_active'); //close dropdown if click outside <select>
				});

				var selectTop;
				var mustChangeScrollTop = false;

				$('.client_multiple_select').on('scroll',function (e) {
					if (mustChangeScrollTop){
						$(this).scrollTop(selectTop);
							mustChangeScrollTop = false;
					}
					return true;
				});
				$('.client_multiple_select option').mousedown(function(e) { //no ctrl to select multiple
					e.preventDefault();
					selectTop = $(this).parent().scrollTop();
					$(this).prop('selected', $(this).prop('selected') ? false : true); //set selected options on click
					$(this).parent().change(); //trigger change event
					mustChangeScrollTop = true;
					/*if(!selectedClientName.includes($(this).val())) {
						//this.items.push(item);
						selectedClientName.push($(this).val());
						//console.log(this.items);
					}else if ($(this).prop('selected') == false) {
						selectedClientName.remove($(this).val());
					}*/
					return false;
				});

				$("#client_name").on('change', function() {
					var selected = $("#client_name").val().toString(); //here I get all options and convert to string
					var document_style = document.documentElement.style;
					
				});

				/*if (selectedClientName.length > 0) {
					$.each( selectedClientName, function( i, l ){
						//alert( "Index #" + i + ": " + l );
						$("#client_name").find("option[value='"+l+"']").attr("selected",true);
					});
				}*/
				$('#client_name option').each(function() {
					if (this.selected){
						//alert('selected - ' + this.value);
						selectedClientName.push(this.value);
						tempClientValue.push(this.value);
					}else {
						selectedClientName = $(selectedClientName).not([this.value]).get();
						tempClientValue = $(tempClientValue).not([this.value]).get();
						//alert('not selected');
					}
				});
				if ($(this).val().length > 0) 
				{
					selectedClientName = getUnique(selectedClientName);
					tempClientValue = getUnique(tempClientValue);
					//alert("After selectedClientName - " + JSON.stringify(selectedClientName));
				}else if ($(this).val().length == 0) {
					$.each(tempClientValue, function (index, ClientValue){
						selectedClientName = $.grep(selectedClientName, function(RemoveValue) {
							return RemoveValue != ClientValue;
						});
					});
					selectedClientName = tempClientValue;
					//tempClientValue = [];
				}
			}
		});

		/* Vendor */
		$("#select_allVendorName").prop("checked", false);
		$('#vendor_name-status').html('').css({'color':'green'});
		$('#vendor_name').removeClass("border border-danger");
		// $('#tableDiv').hide();
		$('#pleaseWaitDialog').modal('show');
		$.ajax({
			url:"html/ProcessUserManagement_Vendor.php",
			method:"post",
			dataType:"text",
			success:function(data)
			{
				// alert(data);
				if (data != 'none') {
					var array = JSON.parse(data);
					$('#vendor_name').empty();
					// $('#portfolio').empty();
					for(var i=0; i<array.length;i++){
						$('#vendor_name').append(new Option(array[i], array[i]));
						
					}
					let vendorName_temp = '<?php if (isset($_POST['editUserbtn'])) echo implode(',', $SelectedVendorIds); ?>';
					
					if ($("#userEditID_temp").val() != "") {
						$('#vendor_name').val(vendorName_temp.split(","));
					}
				}
			},complete: function (data) {
				$('#pleaseWaitDialog').modal('hide');
					//printWithAjax();
					$(".vendor_multiple_select").mousedown(function(e) {
					if (e.target.tagName == "OPTION") 
					{
						return; //don't close dropdown if i select option
					}
					$(this).toggleClass('vendor_multiple_select_active'); //close dropdown if click inside <select> box
				});
				$(".vendor_multiple_select").on('blur', function(e) {
					$(this).removeClass('vendor_multiple_select_active'); //close dropdown if click outside <select>
				});

				var selectTop;
				var mustChangeScrollTop = false;

				$('.vendor_multiple_select').on('scroll',function (e) {
					if (mustChangeScrollTop){
						$(this).scrollTop(selectTop);
							mustChangeScrollTop = false;
					}
					return true;
				});
				$('.vendor_multiple_select option').mousedown(function(e) { //no ctrl to select multiple
					e.preventDefault();
					selectTop = $(this).parent().scrollTop();
					$(this).prop('selected', $(this).prop('selected') ? false : true); //set selected options on click
					$(this).parent().change(); //trigger change event
					mustChangeScrollTop = true;
					/*if(!selectedVendorName.includes($(this).val())) {
						//this.items.push(item);
						selectedVendorName.push($(this).val());
						//console.log(this.items);
					}else if ($(this).prop('selected') == false) {
						selectedVendorName.remove($(this).val());
					}*/
					return false;
				});

				$("#vendor_name").on('change', function() {
					var selected = $("#vendor_name").val().toString(); //here I get all options and convert to string
					var document_style = document.documentElement.style;
					/*if(selected !== "")
					document_style.setProperty('--text', "'Selected: "+selected+"'");
					else
					document_style.setProperty('--text', "'Select values'");*/
				});

				/*if (selectedVendorName.length > 0) {
					$.each( selectedVendorName, function( i, l ){
						//alert( "Index #" + i + ": " + l );
						$("#vendor_name").find("option[value='"+l+"']").attr("selected",true);
					});
				}*/
				$('#vendor_name option').each(function() {
					if (this.selected){
						//alert('selected - ' + this.value);
						selectedVendorName.push(this.value);
						tempVendorValue.push(this.value);
					}else {
						selectedVendorName = $(selectedVendorName).not([this.value]).get();
						tempVendorValue = $(tempVendorValue).not([this.value]).get();
						//alert('not selected');
					}
				});
				if ($(this).val().length > 0) 
				{
					selectedVendorName = getUnique(selectedVendorName);
					tempVendorValue = getUnique(tempVendorValue);
					//alert("After selectedVendorName - " + JSON.stringify(selectedVendorName));
				}else if ($(this).val().length == 0) {
					$.each(tempVendorValue, function (index, VendorValue){
						selectedVendorName = $.grep(selectedVendorName, function(RemoveValue) {
							return RemoveValue != VendorValue;
						});
					});
					selectedVendorName = tempVendorValue;
					//tempVendorValue = [];
				}
			}
		});

		$( "#select_allClientName" ).on( "click", function(){
			// $('#tableDiv').hide();
			if ($('#select_allClientName').is(":checked")){
				$('#client_name option').prop('selected', true);
				// $('#select_allPortfolio').prop('checked', false);
				var client_name = [];
				$.each($("#client_name option:selected"), function(){            
					client_name.push($(this).val());
				});
				// console.log("You have selected the client - " + client_name.join(", "));
			}else{
				$('#client_name option').prop('selected', false);
				// $('#select_allPortfolio').prop('checked', false);
				// $('#portfolio').empty();
			}
			$('#client_name option').each(function() {
				if (this.selected){
					//alert('selected - ' + this.value);
					selectedClientName.push(this.value);
					tempClientValue.push(this.value);
				}else {
					selectedClientName = $(selectedClientName).not([this.value]).get();
					tempClientValue = $(tempClientValue).not([this.value]).get();
					//alert('not selected');
				}
			});
			if ($(this).val().length > 0) 
			{
				selectedClientName = getUnique(selectedClientName);
				tempClientValue = getUnique(tempClientValue);
				//alert("After selectedClientName - " + JSON.stringify(selectedClientName));
			}else if ($(this).val().length == 0) {
				$.each(tempClientValue, function (index, ClientValue){
					selectedClientName = $.grep(selectedClientName, function(RemoveValue) {
						return RemoveValue != ClientValue;
					});
				});
				selectedClientName = tempClientValue;
				//tempClientValue = [];
			}
			// console.log("You have selected the client - " + client_name.join(", "));
		});

		/* Vendor */
		$( "#select_allVendorName" ).on( "click", function(){
			// $('#tableDiv').hide();
			if ($('#select_allVendorName').is(":checked")){
				$('#vendor_name option').prop('selected', true);
				// $('#select_allPortfolio').prop('checked', false);
				var vendor_name = [];
				$.each($("#vendor_name option:selected"), function(){            
					vendor_name.push($(this).val());
				});
				//alert("You have selected the vendor - " + vendor_name.join(", "));
			}else{
				$('#vendor_name option').prop('selected', false);
				// $('#select_allPortfolio').prop('checked', false);
				// $('#portfolio').empty();
			}
			$('#vendor_name option').each(function() {
				if (this.selected){
					//alert('selected - ' + this.value);
					selectedVendorName.push(this.value);
					tempVendorValue.push(this.value);
				}else {
					selectedVendorName = $(selectedVendorName).not([this.value]).get();
					tempVendorValue = $(tempVendorValue).not([this.value]).get();
					//alert('not selected');
				}
			});
			if ($(this).val().length > 0) 
			{
				selectedVendorName = getUnique(selectedVendorName);
				tempVendorValue = getUnique(tempVendorValue);
				//alert("After selectedVendorName - " + JSON.stringify(selectedVendorName));
			}else if ($(this).val().length == 0) {
				$.each(tempVendorValue, function (index, VendorValue){
					selectedVendorName = $.grep(selectedVendorName, function(RemoveValue) {
						return RemoveValue != VendorValue;
					});
				});
				selectedVendorName = tempVendorValue;
				//tempVendorValue = [];
			}
		});

		var tempClientValue = [];
		$("select#client_name").change(function(){
			//alert("TOP selectedClientName - " + JSON.stringify(selectedClientName));
			// $('select#client_name option').each(function() {
			//     if(this.selected){
			//         alert('Selected');
			//         //return false;
			//     }else{
			//         alert('Not Selected');
			//     }
			// });
			$('#client_name option').each(function() {
				if (this.selected){
					//alert('selected - ' + this.value);
					selectedClientName.push(this.value);
					tempClientValue.push(this.value);
				}else {
					selectedClientName = $(selectedClientName).not([this.value]).get();
					tempClientValue = $(tempClientValue).not([this.value]).get();
					//alert('not selected');
				}
			});
			if ($(this).val().length > 0) 
			{
				selectedClientName = getUnique(selectedClientName);
				tempClientValue = getUnique(tempClientValue);
				//alert("After selectedClientName - " + JSON.stringify(selectedClientName));
			}else if ($(this).val().length == 0) {
				$.each(tempClientValue, function (index, ClientValue){
					selectedClientName = $.grep(selectedClientName, function(RemoveValue) {
						return RemoveValue != ClientValue;
					});
				});
				selectedClientName = tempClientValue;
				//tempClientValue = [];
			}
		});

		/* Vendor */
		var tempVendorValue = [];
		$("select#vendor_name").change(function(){
			//alert("TOP selectedVendorName - " + JSON.stringify(selectedVendorName));
			// $('select#vendor_name option').each(function() {
			//     if(this.selected){
			//         alert('Selected');
			//         //return false;
			//     }else{
			//         alert('Not Selected');
			//     }
			// });
			$('#vendor_name option').each(function() {
				if (this.selected){
					//alert('selected - ' + this.value);
					selectedVendorName.push(this.value);
					tempVendorValue.push(this.value);
				}else {
					selectedVendorName = $(selectedVendorName).not([this.value]).get();
					tempVendorValue = $(tempVendorValue).not([this.value]).get();
					//alert('not selected');
				}
			});
			if ($(this).val().length > 0) 
			{
				selectedVendorName = getUnique(selectedVendorName);
				tempVendorValue = getUnique(tempVendorValue);
				//alert("After selectedVendorName - " + JSON.stringify(selectedVendorName));
			}else if ($(this).val().length == 0) {
				$.each(tempVendorValue, function (index, VendorValue){
					selectedVendorName = $.grep(selectedVendorName, function(RemoveValue) {
						return RemoveValue != VendorValue;
					});
				});
				selectedVendorName = tempVendorValue;
				//tempVendorValue = [];
			}
		});

		//Multiple Select Checkboxes
		$(".client_multiple_select").mousedown(function(e) {
			if (e.target.tagName == "OPTION") 
			{
				return; //don't close dropdown if i select option
			}
			$(this).toggleClass('client_multiple_select_active'); //close dropdown if click inside <select> box
		});
		$(".client_multiple_select").on('blur', function(e) {
			$(this).removeClass('client_multiple_select_active'); //close dropdown if click outside <select>
		});

		var selectTop;
		var mustChangeScrollTop = false;

		$('.client_multiple_select').on('scroll',function (e) {
			if (mustChangeScrollTop){
				$(this).scrollTop(selectTop);
					mustChangeScrollTop = false;
			}
			return true;
		});
		$('.client_multiple_select option').mousedown(function(e) { //no ctrl to select multiple
			e.preventDefault();
			selectTop = $(this).parent().scrollTop();
			$(this).prop('selected', $(this).prop('selected') ? false : true); //set selected options on click
			$(this).parent().change(); //trigger change event
			mustChangeScrollTop = true;
			/*if(!selectedClientName.includes($(this).val())) {
				//this.items.push(item);
				selectedClientName.push($(this).val());
				//console.log(this.items);
			}else if ($(this).prop('selected') == false) {
				selectedClientName.remove($(this).val());
			}*/
			return false;
		});
		$("#client_name").on('change', function() {
			var selected = $("#client_name").val().toString(); //here I get all options and convert to string
			var document_style = document.documentElement.style;
			/*if(selected !== "")
			document_style.setProperty('--text', "'Selected: "+selected+"'");
			else
			document_style.setProperty('--text', "'Select values'");*/
			//alert($("select[id$=client_name] option:selected").length);
		});

		/* Vendor */
		//Multiple Select Checkboxes
		$(".vendor_multiple_select").mousedown(function(e) {
			if (e.target.tagName == "OPTION") 
			{
				return; //don't close dropdown if i select option
			}
			$(this).toggleClass('vendor_multiple_select_active'); //close dropdown if click inside <select> box
		});
		$(".vendor_multiple_select").on('blur', function(e) {
			$(this).removeClass('vendor_multiple_select_active'); //close dropdown if click outside <select>
		});

		var selectTop;
		var mustChangeScrollTop = false;

		$('.vendor_multiple_select').on('scroll',function (e) {
			if (mustChangeScrollTop){
				$(this).scrollTop(selectTop);
					mustChangeScrollTop = false;
			}
			return true;
		});
		$('.vendor_multiple_select option').mousedown(function(e) { //no ctrl to select multiple
			e.preventDefault();
			selectTop = $(this).parent().scrollTop();
			$(this).prop('selected', $(this).prop('selected') ? false : true); //set selected options on click
			$(this).parent().change(); //trigger change event
			mustChangeScrollTop = true;
			/*if(!selectedClientName.includes($(this).val())) {
				//this.items.push(item);
				selectedClientName.push($(this).val());
				//console.log(this.items);
			}else if ($(this).prop('selected') == false) {
				selectedClientName.remove($(this).val());
			}*/
			return false;
		});
		$("#vendor_name").on('change', function() {
			var selected = $("#vendor_name").val().toString(); //here I get all options and convert to string
			var document_style = document.documentElement.style;
			/*if(selected !== "")
			document_style.setProperty('--text', "'Selected: "+selected+"'");
			else
			document_style.setProperty('--text', "'Select values'");*/
			//alert($("select[id$=vendor_name] option:selected").length);
		});
		
		$("#show_hide_password a").on('click', function(event) {
            event.preventDefault();
            if($('#show_hide_password input').attr("type") == "text"){
                $('#show_hide_password input').attr('type', 'password');
                $('#show_hide_password i').addClass( "fa-eye-slash" );
                $('#show_hide_password i').removeClass( "fa-eye" );
            }else if($('#show_hide_password input').attr("type") == "password"){
                $('#show_hide_password input').attr('type', 'text');
                $('#show_hide_password i').removeClass( "fa-eye-slash" );
                $('#show_hide_password i').addClass( "fa-eye" );
            }
        });

		//Hide/Show Confirm Password
        $("#show_hide_con_password a").on('click', function(event) {
            event.preventDefault();
            if($('#show_hide_con_password input').attr("type") == "text"){
                $('#show_hide_con_password input').attr('type', 'password');
                $('#show_hide_con_password i').addClass( "fa-eye-slash" );
                $('#show_hide_con_password i').removeClass( "fa-eye" );
            }else if($('#show_hide_con_password input').attr("type") == "password"){
                $('#show_hide_con_password input').attr('type', 'text');
                $('#show_hide_con_password i').removeClass( "fa-eye-slash" );
                $('#show_hide_con_password i').addClass( "fa-eye" );
            }
        });

		$('.table tbody').on('click', '#userDeletebtn', function () {
		  //var recordID = $('#recordID').val();
		  var row_indexDEL = $(this).closest('tr'); 
		  var deleteID = row_indexDEL.find('#userDeleteID').val();
			//var deleteID = $('#userDeleteID').val();
			//alert(deleteID);
			$('#tempUserIDdel').val(deleteID);

		});

		if($('#dsc_subscriber').is(':checked')){
			$(this).closest('td').find('.controllerOperator').removeClass('d-none');
			$(this).closest('td').find('.controllerOperator').addClass('d-flex');
		}else{
			$(this).closest('td').find('.controllerOperator').removeClass('d-flex');
			$(this).closest('td').find('.controllerOperator').addClass('d-none');
		}
		if($('#dsc_reseller').is(':checked')){
			$(this).closest('td').find('.controllerOperator').removeClass('d-none');
			$(this).closest('td').find('.controllerOperator').addClass('d-flex');
		}else{
			$(this).closest('td').find('.controllerOperator').removeClass('d-flex');
			$(this).closest('td').find('.controllerOperator').addClass('d-none');
		}
		if($('#pan').is(':checked')){
			$(this).closest('td').find('.controllerOperator').removeClass('d-none');
			$(this).closest('td').find('.controllerOperator').addClass('d-flex');
		}else{
			$(this).closest('td').find('.controllerOperator').removeClass('d-flex');
			$(this).closest('td').find('.controllerOperator').addClass('d-none');
			}
		if($('#tan').is(':checked')){
			$(this).closest('td').find('.controllerOperator').removeClass('d-none');
			$(this).closest('td').find('.controllerOperator').addClass('d-flex');
		}else{
			$(this).closest('td').find('.controllerOperator').removeClass('d-flex');
			$(this).closest('td').find('.controllerOperator').addClass('d-none');
		}
		if($('#it_returns').is(':checked')){
			$(this).closest('td').find('.controllerOperator').removeClass('d-none');
			$(this).closest('td').find('.controllerOperator').addClass('d-flex');
		}else{
			$(this).closest('td').find('.controllerOperator').removeClass('d-flex');
			$(this).closest('td').find('.controllerOperator').addClass('d-none');
		}
		if($('#e_tds').is(':checked')){
			$(this).closest('td').find('.controllerOperator').removeClass('d-none');
			$(this).closest('td').find('.controllerOperator').addClass('d-flex');
		}else{
			$(this).closest('td').find('.controllerOperator').removeClass('d-flex');
			$(this).closest('td').find('.controllerOperator').addClass('d-none');
		}
		if($('#gst').is(':checked')){
			$(this).closest('td').find('.controllerOperator').removeClass('d-none');
			$(this).closest('td').find('.controllerOperator').addClass('d-flex');
		}else{
			$(this).closest('td').find('.controllerOperator').removeClass('d-flex');
			$(this).closest('td').find('.controllerOperator').addClass('d-none');
		}
		if($('#other_services').is(':checked')){
			$(this).closest('td').find('.controllerOperator').removeClass('d-none');
			$(this).closest('td').find('.controllerOperator').addClass('d-flex');
		}else{
			$(this).closest('td').find('.controllerOperator').removeClass('d-flex');
			$(this).closest('td').find('.controllerOperator').addClass('d-none');
		}
		if($('#psp').is(':checked')){
			$(this).closest('td').find('.controllerOperator').removeClass('d-none');
			$(this).closest('td').find('.controllerOperator').addClass('d-flex');
		}else{
			$(this).closest('td').find('.controllerOperator').removeClass('d-flex');
			$(this).closest('td').find('.controllerOperator').addClass('d-none');
		}
		if($('#psp_coupon_consumption').is(':checked')){
			$(this).closest('td').find('.controllerOperator').removeClass('d-none');
			$(this).closest('td').find('.controllerOperator').addClass('d-flex');
		}else{
			$(this).closest('td').find('.controllerOperator').removeClass('d-flex');
			$(this).closest('td').find('.controllerOperator').addClass('d-none');
		}
		if($('#payment').is(':checked')){
			$(this).closest('td').find('.controllerOperator').removeClass('d-none');
			$(this).closest('td').find('.controllerOperator').addClass('d-flex');
		}else{
			$(this).closest('td').find('.controllerOperator').removeClass('d-flex');
			$(this).closest('td').find('.controllerOperator').addClass('d-none');
		}
		if($('#audit').is(':checked')){
			$(this).closest('td').find('.controllerOperator').removeClass('d-none');
			$(this).closest('td').find('.controllerOperator').addClass('d-flex');
		}else{
			$(this).closest('td').find('.controllerOperator').removeClass('d-flex');
			$(this).closest('td').find('.controllerOperator').addClass('d-none');
		}
		if($('#other_transaction').is(':checked')){
			$(this).closest('td').find('.controllerOperator').removeClass('d-none');
			$(this).closest('td').find('.controllerOperator').addClass('d-flex');
		}else{
			$(this).closest('td').find('.controllerOperator').removeClass('d-flex');
			$(this).closest('td').find('.controllerOperator').addClass('d-none');
		}

		$('.Portfoli_table tbody').on('click', '#dsc_subscriber', function () {
			// alert('here');
			if($('#dsc_subscriber').is(':checked')){
				$(this).closest('td').find('.controllerOperator').removeClass('d-none');
				$(this).closest('td').find('.controllerOperator').addClass('d-flex');
			}else{
				$(this).closest('td').find('.controllerOperator').removeClass('d-flex');
				$(this).closest('td').find('.controllerOperator').addClass('d-none');
			}
		});
		$('.Portfoli_table tbody').on('click', '#dsc_reseller', function () {
			// alert('here');
			if($('#dsc_reseller').is(':checked')){
				$(this).closest('td').find('.controllerOperator').removeClass('d-none');
				$(this).closest('td').find('.controllerOperator').addClass('d-flex');
			}else{
				$(this).closest('td').find('.controllerOperator').removeClass('d-flex');
				$(this).closest('td').find('.controllerOperator').addClass('d-none');
			}
		});
		$('.Portfoli_table tbody').on('click', '#pan', function () {
			// alert('here');
			if($('#pan').is(':checked')){
				$(this).closest('td').find('.controllerOperator').removeClass('d-none');
				$(this).closest('td').find('.controllerOperator').addClass('d-flex');
			}else{
				$(this).closest('td').find('.controllerOperator').removeClass('d-flex');
				$(this).closest('td').find('.controllerOperator').addClass('d-none');
			}
		});
		$('.Portfoli_table tbody').on('click', '#tan', function () {
			// alert('here');
			if($('#tan').is(':checked')){
				$(this).closest('td').find('.controllerOperator').removeClass('d-none');
				$(this).closest('td').find('.controllerOperator').addClass('d-flex');
			}else{
				$(this).closest('td').find('.controllerOperator').removeClass('d-flex');
				$(this).closest('td').find('.controllerOperator').addClass('d-none');
			}
		});
		$('.Portfoli_table tbody').on('click', '#it_returns', function () {
			// alert('here');
			if($('#it_returns').is(':checked')){
				$(this).closest('td').find('.controllerOperator').removeClass('d-none');
				$(this).closest('td').find('.controllerOperator').addClass('d-flex');
			}else{
				$(this).closest('td').find('.controllerOperator').removeClass('d-flex');
				$(this).closest('td').find('.controllerOperator').addClass('d-none');
			}
		});
		$('.Portfoli_table tbody').on('click', '#e_tds', function () {
			// alert('here');
			if($('#e_tds').is(':checked')){
				$(this).closest('td').find('.controllerOperator').removeClass('d-none');
				$(this).closest('td').find('.controllerOperator').addClass('d-flex');
			}else{
				$(this).closest('td').find('.controllerOperator').removeClass('d-flex');
				$(this).closest('td').find('.controllerOperator').addClass('d-none');
			}
		});
		$('.Portfoli_table tbody').on('click', '#gst', function () {
			// alert('here');
			if($('#gst').is(':checked')){
				$(this).closest('td').find('.controllerOperator').removeClass('d-none');
				$(this).closest('td').find('.controllerOperator').addClass('d-flex');
			}else{
				$(this).closest('td').find('.controllerOperator').removeClass('d-flex');
				$(this).closest('td').find('.controllerOperator').addClass('d-none');
			}
		});
		$('.Portfoli_table tbody').on('click', '#other_services', function () {
			// alert('here');
			if($('#other_services').is(':checked')){
				$(this).closest('td').find('.controllerOperator').removeClass('d-none');
				$(this).closest('td').find('.controllerOperator').addClass('d-flex');
			}else{
				$(this).closest('td').find('.controllerOperator').removeClass('d-flex');
				$(this).closest('td').find('.controllerOperator').addClass('d-none');
			}
		});
		$('.Portfoli_table tbody').on('click', '#psp', function () {
			// alert('here');
			if($('#psp').is(':checked')){
				$(this).closest('td').find('.controllerOperator').removeClass('d-none');
				$(this).closest('td').find('.controllerOperator').addClass('d-flex');
			}else{
				$(this).closest('td').find('.controllerOperator').removeClass('d-flex');
				$(this).closest('td').find('.controllerOperator').addClass('d-none');
			}
		});
		$('.Portfoli_table tbody').on('click', '#psp_coupon_consumption', function () {
			// alert('here');
			if($('#psp_coupon_consumption').is(':checked')){
				$(this).closest('td').find('.controllerOperator').removeClass('d-none');
				$(this).closest('td').find('.controllerOperator').addClass('d-flex');
			}else{
				$(this).closest('td').find('.controllerOperator').removeClass('d-flex');
				$(this).closest('td').find('.controllerOperator').addClass('d-none');
			}
		});
		$('.Portfoli_table tbody').on('click', '#payment', function () {
			// alert('here');
			if($('#payment').is(':checked')){
				$(this).closest('td').find('.controllerOperator').removeClass('d-none');
				$(this).closest('td').find('.controllerOperator').addClass('d-flex');
			}else{
				$(this).closest('td').find('.controllerOperator').removeClass('d-flex');
				$(this).closest('td').find('.controllerOperator').addClass('d-none');
			}
		});
		$('.Portfoli_table tbody').on('click', '#audit', function () {
			// alert('here');
			if($('#audit').is(':checked')){
				$(this).closest('td').find('.controllerOperator').removeClass('d-none');
				$(this).closest('td').find('.controllerOperator').addClass('d-flex');
			}else{
				$(this).closest('td').find('.controllerOperator').removeClass('d-flex');
				$(this).closest('td').find('.controllerOperator').addClass('d-none');
			}
		});
		$('.Portfoli_table tbody').on('click', '#other_transaction', function () {
			// alert('here');
			if($('#other_transaction').is(':checked')){
				$(this).closest('td').find('.controllerOperator').removeClass('d-none');
				$(this).closest('td').find('.controllerOperator').addClass('d-flex');
			}else{
				$(this).closest('td').find('.controllerOperator').removeClass('d-flex');
				$(this).closest('td').find('.controllerOperator').addClass('d-none');
			}
		});

		if ($("#userEditID_temp").val() != "") {
			$("#dataTable_users").removeClass("d-block");
            $("#dataTable_users").addClass("d-none");
            //$("#import_client").removeClass("d-block");
            //$("#import_client").addClass("d-none");

            $("#addNew_users").removeClass("d-none");
            $("#addNew_users").addClass("d-block");
		}
        $("#add_new_USERS").click(function(){
            $("#dataTable_users").removeClass("d-block");
            $("#dataTable_users").addClass("d-none");
            //$("#import_client").removeClass("d-block");
            //$("#import_client").addClass("d-none");

            $("#addNew_users").removeClass("d-none");
            $("#addNew_users").addClass("d-block");
        });
        $("#import_USERS").click(function(){
            $("#dataTable_users").removeClass("d-block");
            $("#dataTable_users").addClass("d-none");
            $("#addNew_users").removeClass("d-block");
            $("#addNew_users").addClass("d-none");

            //$("#import_client").removeClass("d-none");
            //$("#import_client").addClass("d-block");
        });
	});
</script>
<?php include_once 'ltr/header-footer.php'; ?>
</body>
</html>
<?php
if (isset($_POST['user_save'])) {
		$firstname = $_POST['firstname'];
		$middlename = $_POST['middlename'];
		$lastname = $_POST['lastname'];
		$department = $_POST['department'];
		$designation = $_POST['designation'];
		$user_name = $_POST['user_name'];
		// $client_name = implode(',', $_POST['client_name']);
		$client_name = $_POST['client_name'];
		$vendor_name = $_POST['vendor_name'];
		$add_taskM = $_POST['add_taskM'];
		$password = sha1($_POST['password']);
		$mobile = $_POST['mobile_no'];
		$tl_members = implode(',',$_POST['crm_tl_member']);
		$re_type_password = sha1($_POST['re_type_password']);
		if ($password != $re_type_password) {
			$alertMsg = "Password & Re-type password must be same!";
			$alertClass = "alert alert-danger";
			$reopen_firstname = $_POST['firstname'];
			$reopen_lastname = $_POST['lastname'];
			$reopen_user_name = $_POST['user_name'];
			$reopen_password = $_POST['password'];
			$reopen_re_type_password = $_POST['re_type_password'];
		}else{
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
			if(!isset($_POST['supplier_master']))
			{
			     $supplier_master = 0;
			} else {
			     $supplier_master = $_POST['supplier_master'];
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
			if(!isset($_POST['trade_mark']))
			{
			     $trade_mark = 0;
			} else {
			     $trade_mark = $_POST['trade_mark'];
			}
			if(!isset($_POST['patent']))
			{
			     $patent = 0;
			} else {
			     $patent = $_POST['patent'];
			}
			if(!isset($_POST['copy_right']))
			{
			     $copy_right = 0;
			} else {
			     $copy_right = $_POST['copy_right'];
			}
			if(!isset($_POST['trade_secret']))
			{
			     $trade_secret = 0;
			} else {
			     $trade_secret = $_POST['trade_secret'];
			}
			if(!isset($_POST['industrial_design']))
			{
			     $industrial_design = 0;
			} else {
			     $industrial_design = $_POST['industrial_design'];
			}
			if(!isset($_POST['legal_notice']))
			{
			     $legal_notice = 0;
			} else {
			     $legal_notice = $_POST['legal_notice'];
			}
			
			if(!isset($_POST['other_transaction']))
			{
			     $other_transaction = 0;
			} else {
			     $other_transaction = $_POST['other_transaction'];
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
			if(!isset($_POST['payroll']))
			{
			     $payroll = 0;
			} else {
			     $payroll = $_POST['payroll'];
			}
			if(!isset($_POST['document_records']))
			{
			     $payroll = 0;
			} else {
			     $document_records = $_POST['document_records'];
			}
			if(!isset($_POST['add_taskM']))
			{
			     $add_taskM = 0;
			} else {
			     $add_taskM = $_POST['add_taskM'];
			}
			
			if(!isset($_POST['add_taskM']))
			{
			     $add_taskM = 0;
			} else {
			     $add_taskM = $_POST['add_taskM'];
			}
			
            if(!isset($_POST['add_passMang']))
			{
			     $add_passMang = 0;
			} else {
			     $add_passMang = $_POST['add_passMang'];
			}
			
			if(!isset($_POST['outstanding']))
			{
			     $outstanding = 0;
			} else {
			     $outstanding = $_POST['outstanding'];
			}
			
            // CRM PART CODE
            
            if(!isset($_POST['crm_clientConfig']))
			{
			     $crm_clientConfig = 0;
			} else {
			     $crm_clientConfig = $_POST['crm_clientConfig'];
			}
			if(!isset($_POST['crm_enq']))
			{
			     $crm_enq = 0;
			} else {
			     $crm_enq = $_POST['crm_enq'];
			}
			if(!isset($_POST['crm_job']))
			{
			     $crm_job = 0;
			} else {
			     $crm_job = $_POST['crm_job'];
			}
			if(!isset($_POST['crm_admin_mom']))
			{
			     $crm_admin_mom = 0;
			} else {
			     $crm_admin_mom = $_POST['crm_admin_mom'];
			}
			if(!isset($_POST['crm_admin_filter']))
			{
			     $crm_admin_filter = 0;
			} else {
			     $crm_admin_filter = $_POST['crm_admin_filter'];
			}
			if(!isset($_POST['crm_fix_meeting']))
			{
			     $crm_fix_meeting = 0;
			} else {
			     $crm_fix_meeting = $_POST['crm_fix_meeting'];
			}
			if(!isset($_POST['crm_bidding']))
			{
			     $crm_bidding = 0;
			} else {
			     $crm_bidding = $_POST['crm_bidding'];
			}
			if(!isset($_POST['whatsapp']))
			{
			     $whatsapp = 0;
			} else {
			     $whatsapp = $_POST['whatsapp'];
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
			if(!isset($_POST['crm_trace_cont']))
			{
			     $crm_trace_cont = 0;
			} else {
			     $crm_trace_cont = $_POST['crm_trace_cont'];
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
			if(!isset($_POST['ticket']))
			{
			     $ticket = 0;
			} else {
			     $ticket = $_POST['ticket'];
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
			
			if(!isset($_POST['esp_latest_sales']))
			{
			     $esp_latest_sales = 0;
			} else {
			     $esp_latest_sales = $_POST['esp_latest_sales'];
			}
			if(!isset($_POST['esp_income_expense']))
			{
			     $esp_income_expense = 0;
			} else {
			     $esp_income_expense = $_POST['esp_income_expense'];
			}
			if(!isset($_POST['esp_payment_received']))
			{
			     $esp_payment_received = 0;
			} else {
			     $esp_payment_received = $_POST['esp_payment_received'];
			}
			if(!isset($_POST['esp_payment_paid']))
			{
			     $esp_payment_paid = 0;
			} else {
			     $esp_payment_paid = $_POST['esp_payment_paid'];
			}
			if(!isset($_POST['esp_highest_outstand']))
			{
			     $esp_highest_outstand = 0;
			} else {
			     $esp_highest_outstand = $_POST['esp_highest_outstand'];
			}
			if(!isset($_POST['esp_oto_board']))
			{
			     $esp_oto_board = 0;
			} else {
			     $esp_oto_board = $_POST['esp_oto_board'];
			}
			if(!isset($_POST['esp_latest_enquiry']))
			{
			     $esp_latest_enquiry = 0;
			} else {
			     $esp_latest_enquiry = $_POST['esp_latest_enquiry'];
			}
			if(!isset($_POST['esp_search_client']))
			{
			     $esp_search_client = 0;
			} else {
			     $esp_search_client = $_POST['esp_search_client'];
			}
			if(!isset($_POST['esp_trading_inventory']))
			{
			     $esp_trading_inventory = 0;
			} else {
			     $esp_trading_inventory = $_POST['esp_trading_inventory'];
			}
			if(!isset($_POST['esp_bank_balance']))
			{
			     $esp_bank_balance = 0;
			} else {
			     $esp_bank_balance = $_POST['esp_bank_balance'];
			}
			if(!isset($_POST['crm_tl']))
			{
			     $crm_tl = 0;
			} else {
			     $crm_tl = $_POST['crm_tl'];
			}
			if(!isset($_POST['esp_attendence']))
			{
			     $esp_attendence = 0;
			} else {
			     $esp_attendence = $_POST['esp_attendence'];
			}
			if(!isset($_POST['ca_dashboard']))
			{
			     $ca_dashboard = 0;
			} else {
			     $ca_dashboard = $_POST['ca_dashboard'];
			}
			//$company_profile = $_POST['company_profile'];
			//$audit = $_POST['audit'];
			
			$fetch_email = "(SELECT DISTINCT `email_id` FROM `company_profile` WHERE `email_id` = '".$user_name."') UNION (SELECT DISTINCT `username` FROM `users` WHERE `username` = '".$user_name."')";
			$run_fetch_email = mysqli_query($con,$fetch_email);
			$rowEmail = mysqli_num_rows($run_fetch_email);
			if ($rowEmail > 0) {
				$alertMsg = "User already exist..!";
				$alertClass = "alert alert-danger";
			}else{
				$fetchDepartmentShortName = "SELECT * FROM `department` WHERE `department_name` = '".$department."' AND `company_id` = '".$_SESSION['company_id']."'";
				$run_fetchDepartmentShortName = mysqli_query($con, $fetchDepartmentShortName);
				$fetchDepartmentShortName_Row = mysqli_fetch_array($run_fetchDepartmentShortName);
				
				$fetchUser_Id = "SELECT MAX(Substring(`user_id`, LOCATE('_', `user_id`)+1, length(`user_id`))) As `user_id` FROM `users` WHERE `company_id` = '".$_SESSION['company_id']."' AND `department` = '".$department."'";
				// echo $fetchUser_Id;
				$runUser_Id = mysqli_query($con, $fetchUser_Id);
				$User_Id_row = mysqli_fetch_array($runUser_Id);
				// $LastUserId = substr($User_Id_row['user_id'], strpos($User_Id_row['user_id'], "_") + 1) + 1;
				$LastUserId = $User_Id_row['user_id'] + 1;
				// echo $LastUserId;
				$user_id = '';
				if ($User_Id_row['user_id'] == '') {
					$user_id = $fetchDepartmentShortName_Row['department_shortname'].'_1';
				}else{
					$user_id = $fetchDepartmentShortName_Row['department_shortname'].'_'.$LastUserId;
				}
				// echo "User id ".$user_id;
				// echo "not_exist";
				$fetchUser_Id = "SELECT * FROM `users` WHERE `company_id` = '".$_SESSION['company_id']."'";
				$runUser_Id = mysqli_query($con, $fetchUser_Id);
				$row = mysqli_fetch_array($runUser_Id);
				
				$user_add_query = "INSERT INTO `users`(`ca_dashboard`,`legal_notice`,`industrial_design`,`esp_attendence_graph`,`crm_teamMember`,`crm_teamleader`,`trade_mark`,`patent`,`copy_right`,`trade_secret`,`company_id`, `user_type`, `firstname`, `middlename`, `lastname`, `user_id`, `department`, `designation`, `username`, `password`,`mobile`, `reports`, `client_master`, `dsc_subscriber`, `dsc_reseller`, `pan`, `tan`, `it_returns`, `e_tds`, `gst`, `other_services`, `psp`, `psp_coupon_consumption`, `payment`, `audit`, `other_transaction`, `add_users`, `company_profile`, `payroll`,`financial_records`,`document_records`,`contact_client`,`e_tender`,`add_taskmanager`,`add_clientConfig`,`add_passMang`,`add_enquiry`,`add_jobProg`,`addFix_meeting`,`mom_admin`,`add_Admin_filter`,`addBidding`,`vendor_master`,`outstanding`,`whatsapp`,`data_record`,`record_transfer`,`trace_contact`,`settlement`,`expense`,`contra_voucher`,`bank_report`,`tickets`,`mail_panel`,`api_setup`,`depart_panel`,`design_panel`,`soft_export`,`esp_latest_sales`,`esp_income_expense`,`esp_payment_received`,`esp_payment_paid`,`esp_highest_outstanding`,`esp_oto_board`,`esp_latest_enquiry`,`esp_search_client`,`esp_trading_invent`,`esp_bank_balance`) VALUES ('".$ca_dashboard."','".$legal_notice."','".$industrial_design."','".$esp_attendence."','".$tl_members."','".$crm_tl."','".$trade_mark."','".$patent."','".$copy_right."','".$trade_secret."','".$_SESSION['company_id']."', 'simple_user','".$firstname."','".$middlename."','".$lastname."', '".$user_id."','".$department."','".$designation."','".$user_name."','".$password."','".$mobile."','".$reports."','".$client_master."','".$dsc_subscriber."','".$dsc_reseller."','".$pan."','".$tan."','".$it_returns."','".$e_tds."','".$gst."','".$other_services."','".$psp."','".$psp_coupon_consumption."','".$payment."','".$audit."','".$other_transaction."','".$add_users."','".$company_profile."','".$payroll."','".$financial_records."','".$document_records."','".$contact_client."','".$e_tender."','".$add_taskM."','".$crm_clientConfig."','".$add_passMang."','".$crm_enq."','".$crm_job."','".$crm_fix_meeting."','".$crm_admin_mom."','".$crm_admin_filter."','".$crm_bidding."','".$supplier_master."','".$outstanding."','".$whatsapp."','".$crm_data_record."','".$crm_rec_tranf."','".$crm_trace_cont."','".$settlement."','".$expense."','".$contra_voucher."','".$bank_report."','".$ticket."','".$mail_panel."','".$api_setup."','".$depart_panel."','".$desig_panel."','".$soft_export."','".$esp_latest_sales."','".$esp_income_expense."','".$esp_payment_received."','".$esp_payment_paid."','".$esp_highest_outstand."','".$esp_oto_board."','".$esp_latest_enquiry."','".$esp_search_client."','".$esp_trading_inventory."','".$esp_bank_balance."')";
				$run_user_add = mysqli_query($con,$user_add_query);
				// $run_user_add = false;
				if ($run_user_add) {
					$fetchUserId = "SELECT `id` FROM `users` WHERE `username` = '".$user_name."' AND `company_id` = '".$_SESSION['company_id']."'";
					$runUserId = mysqli_query($con, $fetchUserId);
					$row = mysqli_fetch_array($runUserId);
					// First remove access from all clients for the logged in user
					$updateEachClient = "UPDATE `client_master` SET `users_access` = TRIM(',".$row['id']."' FROM `users_access`) WHERE FIND_IN_SET('".$row['id']."',users_access) AND `company_id` = '".$_SESSION['company_id']."'";
						// echo $updateEachClient;
					$run_updateEachClient = mysqli_query($con,$updateEachClient);

					// Now replace ,,(double commas) to ,(single comma)
					$updateEachClient = "UPDATE `client_master` SET `users_access` = REPLACE(`users_access`,',,',',') WHERE `company_id` = '".$_SESSION['company_id']."'";
					// FIND_IN_SET('".$row['id']."',users_access) AND
						// echo $updateEachClient;
					$run_updateEachClient = mysqli_query($con,$updateEachClient);

					// Now add access to the selected clients for the logged in user
					if (count($client_name) > 0) {
						foreach($client_name as $ClientName){
							$updateEachClient = "UPDATE `client_master` SET `users_access` = CONCAT(`users_access`, ',".$row['id']."') WHERE NOT FIND_IN_SET('".$row['id']."',users_access) AND `company_id` = '".$_SESSION['company_id']."' AND `client_name` = '".$ClientName."'";
							// echo $updateEachClient;
							$run_updateEachClient = mysqli_query($con,$updateEachClient);
						}
					}
					// Now replace ,,(double commas) to ,(single comma)
					$updateEachClient = "UPDATE `client_master` SET `users_access` = REPLACE(`users_access`,',,',',') WHERE `company_id` = '".$_SESSION['company_id']."'";
					// FIND_IN_SET('".$row['id']."',users_access) AND
						// echo $updateEachClient;
					$run_updateEachClient = mysqli_query($con,$updateEachClient);

					/* Vendors */
					// First remove access from all clients for the logged in user
					$updateEachVendor = "UPDATE `vendor_master` SET `users_access` = TRIM(',".$row['id']."' FROM `users_access`) WHERE FIND_IN_SET('".$row['id']."',users_access) AND `company_id` = '".$_SESSION['company_id']."'";
						// echo $updateEachVendor;
					$run_updateEachVendor = mysqli_query($con,$updateEachVendor);

					// Now replace ,,(double commas) to ,(single comma)
					$updateEachVendor = "UPDATE `vendor_master` SET `users_access` = REPLACE(`users_access`,',,',',') WHERE `company_id` = '".$_SESSION['company_id']."'";
					// FIND_IN_SET('".$row['id']."',users_access) AND
						// echo $updateEachVendor;
					$run_updateEachVendor = mysqli_query($con,$updateEachVendor);

					// Now add access to the selected clients for the logged in user
					if (count($vendor_name) > 0) {
						foreach($vendor_name as $VendorName){
							$updateEachVendor = "UPDATE `vendor_master` SET `users_access` = CONCAT(`users_access`, ',".$row['id']."') WHERE NOT FIND_IN_SET('".$row['id']."',users_access) AND `company_id` = '".$_SESSION['company_id']."' AND `client_name` = '".$VendorName."'";
							// echo $updateEachVendor;
							$run_updateEachVendor = mysqli_query($con,$updateEachVendor);
						}
					}
					// Now replace ,,(double commas) to ,(single comma)
					$updateEachVendor = "UPDATE `vendor_master` SET `users_access` = REPLACE(`users_access`,',,',',') WHERE `company_id` = '".$_SESSION['company_id']."'";
					// FIND_IN_SET('".$row['id']."',users_access) AND
						// echo $updateEachVendor;
					$run_updateEachVendor = mysqli_query($con,$updateEachVendor);
					$alertMsg = "Record Inserted";
					$alertClass = "alert alert-success";
				}
			}
		}
	}
?>   