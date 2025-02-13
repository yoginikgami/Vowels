<?php 
	include_once 'ltr/header.php';
	include_once 'connection.php';
	// include_once 'bulkDeletePopup.php';
	// include_once 'mailFunction.php';
	$_SESSION['pageName'] = "retail_invoice";
	?>
	
	<h2><span id="Service-status"></span></h2>
	<?php
	
	date_default_timezone_set('Asia/Kolkata');
	$alertMsg = "";
	$alertClass = "";
	if (isset($_POST['editGSTFeesbtn'])) {
		if (isset($_POST['gstEditID'])) {
			$fetch_data = "SELECT * FROM `gst_fees` WHERE `id` = '".$_POST['gstEditID']."'";
			$run_fetch_data = mysqli_query($con,$fetch_data);
			$row = mysqli_fetch_array($run_fetch_data);
			$edit_client_name = $row['client_name'];
			if ($row['date'] != '') {
				$edit_date = date('Y-m-d',strtotime($row['date']));
			}else{
				$edit_date = $row['date'];
			}
			$edit_gst_no = $row['gst_no'];
			//$edit_bill_no = $row['bill_no'];
			$edit_return_type = $row['return_type'];
			$edit_billing_year = $row['billing_year'];
			$edit_fees_mode = $row['fees_mode'];
			$edit_consulting_fees = $row['consulting_fees'];
			$edit_fees_received = $row['fees_received'];
			// $edit_users_access = explode(',', $row['users_access']);
			$edit_payment_mode = $row['payment_mode'];
			$edit_payment_description = $row['payment_description'];
			$edit_amount = $row['amount'];
			$edit_remarks = $row['remarks'];
		}
	}
	if (isset($_POST['RetailInvoice_save'])) {
		$retail_invoice_number = $_POST['invoice_number'];
		$reference_number = $_POST['reference_number'];
		$date = date('Y-M-d',strtotime($_POST['date']));
		$category = $_POST['category'];
// 		$client_name = $_POST['client_name'];
        $client_name = explode(',',$_POST['client_name']);
		$gst_no = $_POST['gst_no'];
		$serviceIds = $_POST['serviceIds'];
		$totalValue = $_POST['totalValue'];
        $totalValue = $_POST['totalValue'];
        $drawee = isset($_POST['drawee']) ? $_POST['drawee'] : ''; // Default value if "drawee" is not set
        $c_name=$_POST['c_name'];
        $client_id=$_POST['client_ID'];
        $Drawee_id=$_POST['drawee_ID'];
        
        $fech_add="select * from client_master where transaction_id='".$client_id."'";
        $run=mysqli_query($con,$fech_add);
        $addres_client_row=mysqli_fetch_array($run);
        $client_address=$addres_client_row['address'];

		$checkExistData = "SELECT * FROM `retail_invoice` WHERE `retail_invoice_number` = '".$retail_invoice_number."'";
		$run_checkExistData = mysqli_query($con,$checkExistData);
		if(mysqli_num_rows($run_checkExistData) > 0){
			$alertMsg = "Record already exist!";
			$alertClass = "alert alert-danger";
		} else{
			$MultipleServiceIds = explode(',', $_POST['serviceIds']);
			foreach($MultipleServiceIds as $serviceId){
				// print_r($serviceId);
				if ($serviceId != "") {
					$firstUnderscore = explode("_", $serviceId);

					if ($firstUnderscore[1] == 'CLM') {
						$updatePortfolio = "UPDATE `client_master` SET `retail_invoice_number` = '".$retail_invoice_number."' WHERE `transaction_id` = '".$serviceId."'";
					}else if ($firstUnderscore[1] == 'GST') {
						$updatePortfolio = "UPDATE `gst_fees` SET `retail_invoice_number` = '".$retail_invoice_number."' WHERE `transaction_id` = '".$serviceId."'";
					}else if ($firstUnderscore[1] == 'ITR') {
						$updatePortfolio = "UPDATE `it_returns` SET `retail_invoice_number` = '".$retail_invoice_number."' WHERE `transaction_id` = '".$serviceId."'";
					}else if ($firstUnderscore[1] == 'PAN') {
						$updatePortfolio = "UPDATE `pan` SET `retail_invoice_number` = '".$retail_invoice_number."' WHERE `transaction_id` = '".$serviceId."'";
					}else if ($firstUnderscore[1] == 'TAN') {
						$updatePortfolio = "UPDATE `tan` SET `retail_invoice_number` = '".$retail_invoice_number."' WHERE `transaction_id` = '".$serviceId."'";
					}else if ($firstUnderscore[1] == 'TDS') {
						$updatePortfolio = "UPDATE `e_tds` SET `retail_invoice_number` = '".$retail_invoice_number."' WHERE `transaction_id` = '".$serviceId."'";
					}else if ($firstUnderscore[1] == 'PSP') {
						$updatePortfolio = "UPDATE `psp` SET `retail_invoice_number` = '".$retail_invoice_number."' WHERE `transaction_id` = '".$serviceId."'";
					}else if ($firstUnderscore[1] == 'ADV') {
					echo	$updatePortfolio = "UPDATE `advocade_case` SET `retail_invoice_number` = '".$retail_invoice_number."' WHERE `transaction_id` = '".$serviceId."'";
					}else if ($firstUnderscore[1] == 'DA') {
						$updatePortfolio = "UPDATE `dsc_subscriber` SET `retail_invoice_number` = '".$retail_invoice_number."' WHERE `transaction_id` = '".$serviceId."'";
					}else if ($firstUnderscore[1] == 'DP') {
						$updatePortfolio = "UPDATE `dsc_reseller` SET `retail_invoice_number` = '".$retail_invoice_number."' WHERE `transaction_id` = '".$serviceId."'";
					}else if ($firstUnderscore[1] == 'TRD') {
    					$updatePortfolio = "UPDATE `trade_mark` SET `retail_invoice_number` = '".$retail_invoice_number."' WHERE `transaction_id` = '".$serviceId."'";
					}else if ($firstUnderscore[1] == 'COP') {
    					$updatePortfolio = "UPDATE `copy_right` SET `retail_invoice_number` = '".$retail_invoice_number."' WHERE `transaction_id` = '".$serviceId."'";
					}else if ($firstUnderscore[1] == 'TRS') {
    					$updatePortfolio = "UPDATE `trade_secret` SET `retail_invoice_number` = '".$retail_invoice_number."' WHERE `transaction_id` = '".$serviceId."'";
					}else if ($firstUnderscore[1] == 'IDS') {
    					$updatePortfolio = "UPDATE `industrial_design` SET `retail_invoice_number` = '".$retail_invoice_number."' WHERE `transaction_id` = '".$serviceId."'";
					}else if ($firstUnderscore[1] == 'PTN') {
    					$updatePortfolio = "UPDATE `patent` SET `retail_invoice_number` = '".$retail_invoice_number."' WHERE `transaction_id` = '".$serviceId."'";
					}else if ($firstUnderscore[1] == 'TSL') {
						$updatePortfolio = "UPDATE `sales` SET `retail_invoice_number` = '".$retail_invoice_number."' WHERE `transaction_id` = '".$serviceId."'";
					}else if ($firstUnderscore[1] == 'DT') {
						$updatePortfolio = "UPDATE `dsc_token` SET `retail_invoice_number` = '".$retail_invoice_number."' WHERE `transaction_id` = '".$serviceId."'";
					}else if ($firstUnderscore[1] == 'OS') {
						$updatePortfolio = "UPDATE `other_services` SET `retail_invoice_number` = '".$retail_invoice_number."' WHERE `transaction_id` = '".$serviceId."'";
					}else if ($firstUnderscore[1] == 'MOR') {
						$updatePortfolio = "UPDATE `mobile_repairing` SET `retail_invoice_number` = '".$retail_invoice_number."' WHERE `transaction_id` = '".$serviceId."'";
					}else if ($firstUnderscore[1] == 'TND') {
						$updatePortfolio = "UPDATE `e_tender` SET `retail_invoice_number` = '".$retail_invoice_number."' WHERE `transaction_id` = '".$serviceId."'";
					}else if ($firstUnderscore[1] == '24G') {
						$updatePortfolio = "UPDATE `24g` SET `retail_invoice_number` = '".$retail_invoice_number."' WHERE `transaction_id` = '".$serviceId."'";
					}
					$run_updatePortfolio = mysqli_query($con,$updatePortfolio);
				}
			}
            $RetailInvoice_add_query = "INSERT INTO `retail_invoice`(`address`,`drawee_id`,`client_id`,`company_id`, `drawee`,`c_name`,`retail_invoice_number`, `reference_number`, `billing_date`, `category`, `client_name`, `gst_number`, `service_id`, `retailable_amount`, `total_retail_value`, `modify_by`, `modify_date`) 
            VALUES ('".$client_address."','".$Drawee_id."','".$client_id."','".$_SESSION['company_id']."','".$drawee."','".$c_name."','".$retail_invoice_number."','".$reference_number."', '".$date."','".$category."','".$client_name[1]."','".$gst_no."','".$serviceIds."','".$totalValue."','".$totalValue."','".$_SESSION['username']."','".date('Y-m-d H:i:sa')."')";
            // echo $RetailInvoice_add_query;
            $run_RetailInvoice = mysqli_query($con,$RetailInvoice_add_query);
            if ($run_RetailInvoice) {
                $alertMsg = "Record Inserted";
                $alertClass = "alert alert-success";
            }
		}
	}
	if (isset($_POST['gstFees_update'])) {
		$client_name = $_POST['temp_client_name'];
		$date = date('Y-M-d',strtotime($_POST['date']));
		$gst_no = $_POST['gst_no'];
		$return_type = $_POST['return_type'];
		$billing_year = $_POST['temp_billing_year'];
        $fees_mode = $_POST['fees_mode'];
        $consulting_fees = $_POST['consulting_fees'];
		/* $payment_mode = $_POST['payment_mode'];
		if ($payment_mode != "Bank Online") {
			$payment_description = '';
		} else {
			$payment_description = $_POST['payment_description'];
		}
		$amount = $_POST['amount'];
		$remarks = $_POST['remarks']; */
		/* $fetchAdminId = "SELECT * FROM `users` WHERE `company_id` = '".$_SESSION['company_id']."' AND `admin_status` = '1'";
		$runAdminId = mysqli_query($con,$fetchAdminId);
		$AdminIdrow = mysqli_fetch_array($runAdminId);
		if ($_SESSION['admin_status'] == "1") {
			if (isset($_POST['users_access'])) {
				$users_access = $AdminIdrow['id'].",".implode(',', $_POST['users_access']);	
			}else{
				$users_access = $AdminIdrow['id'];
			}			
		}else{
			$users_access = $AdminIdrow['id'].",".$_SESSION['user_id'];
		} */
        	//echo $gstr_1_File;
		$checkExistData = "SELECT * FROM `gst_fees` WHERE `billing_year` = '".$billing_year."' AND `client_name` = '".$client_name."' AND `id` != '".$_POST['gstEditID_temp']."' AND `company_id` = '".$_SESSION['company_id']."'";
		$run_checkExistData = mysqli_query($con,$checkExistData);
		if(mysqli_num_rows($run_checkExistData) > 0){
			$alertMsg = "Record already exist!";
			$alertClass = "alert alert-danger";
		} else{
			// ,`payment_mode`='".$payment_mode."',`payment_description`='".$payment_description."',`amount`='".$amount."',`remarks`='".$remarks."', `users_access` = '".$users_access."'
			$gst_update_query = "UPDATE `gst_fees` SET `company_id` = '".$_SESSION['company_id']."',`client_name`='".$client_name."',`date`='".$date."',`gst_no`='".$gst_no."',`return_type`='".$return_type."',`billing_year`='".$billing_year."',`fees_mode`='".$fees_mode."',`consulting_fees`='".$consulting_fees."',`modify_by`='".$_SESSION['username']."',`modify_date`='".date('Y-m-d H:i:sa')."' WHERE `id` = '".$_POST['gstEditID_temp']."'";
			$run_gst_update = mysqli_query($con,$gst_update_query);
			if ($run_gst_update) {
				$alertMsg = "Record Updated";
				$alertClass = "alert alert-success";
			}
		}
	}
	$deletedRecords = false;
	$deletedServiceIncomeRecords = false;
	if (isset($_POST['gstFees_delete'])) {
		if (isset($_POST['tempGSTIDdel'])) {
            $fetch_ServiceId = "SELECT * FROM `retail_invoice` WHERE `id` = '".$_POST['tempGSTIDdel']."'";
			$runServiceId = mysqli_query($con, $fetch_ServiceId);
			$countServiceIncomeRecords = mysqli_num_rows($runServiceId);
			$rowFetchServiceId = mysqli_fetch_array($runServiceId);
			// echo $rowFetchServiceId;
			// $finalTax = (($rowFetchServiceId['cgst_tax_percentage'] + $rowFetchServiceId['sgst_tax_percentage'] + $rowFetchServiceId['igst_tax_percentage'] + 100) / 100);
			// echo $tax_percentage;
			$rowFetchServiceId= $rowFetchServiceId['service_id'];
			// echo $rowFetchServiceId;
			$MultipleServiceIds = explode(',', $rowFetchServiceId);
			foreach($MultipleServiceIds as $serviceId){
				// print_r($serviceId);
				if ($serviceId != "") {
					$firstUnderscore = explode("_", $serviceId);

					if ($firstUnderscore[1] == 'CLM') {
						$updatePortfolio = "UPDATE `client_master` SET `retail_invoice_number` = '' WHERE `transaction_id` = '".$serviceId."'";
					}else if ($firstUnderscore[1] == 'GST') {
						$updatePortfolio = "UPDATE `gst_fees` SET `retail_invoice_number` = '' WHERE `transaction_id` = '".$serviceId."'";
					}else if ($firstUnderscore[1] == 'ITR') {
						$updatePortfolio = "UPDATE `it_returns` SET `retail_invoice_number` = '' WHERE `transaction_id` = '".$serviceId."'";
					}else if ($firstUnderscore[1] == 'PAN') {
						$updatePortfolio = "UPDATE `pan` SET `retail_invoice_number` = '' WHERE `transaction_id` = '".$serviceId."'";
					}else if ($firstUnderscore[1] == 'TAN') {
						$updatePortfolio = "UPDATE `tan` SET `retail_invoice_number` = '' WHERE `transaction_id` = '".$serviceId."'";
					}else if ($firstUnderscore[1] == 'TDS') {
						$updatePortfolio = "UPDATE `e_tds` SET `retail_invoice_number` = '' WHERE `transaction_id` = '".$serviceId."'";
					}else if ($firstUnderscore[1] == 'PSP') {
						$updatePortfolio = "UPDATE `psp` SET `retail_invoice_number` = '' WHERE `transaction_id` = '".$serviceId."'";
					}else if ($firstUnderscore[1] == 'DA') {
						$updatePortfolio = "UPDATE `dsc_subscriber` SET `retail_invoice_number` = '' WHERE `transaction_id` = '".$serviceId."'";
					}else if ($firstUnderscore[1] == 'DP') {
						$updatePortfolio = "UPDATE `dsc_reseller` SET `retail_invoice_number` = '' WHERE `transaction_id` = '".$serviceId."'";
					}else if ($firstUnderscore[1] == 'TRD') {
						$updatePortfolio = "UPDATE `trade_mark` SET `retail_invoice_number` = '' WHERE `transaction_id` = '".$serviceId."'";
					}else if ($firstUnderscore[1] == 'COP') {
    					$updatePortfolio = "UPDATE `copy_right` SET `retail_invoice_number` = '' WHERE `transaction_id` = '".$serviceId."'";
					}else if ($firstUnderscore[1] == 'TRS') {
    					$updatePortfolio = "UPDATE `trade_secret` SET `retail_invoice_number` = '' WHERE `transaction_id` = '".$serviceId."'";
					}else if ($firstUnderscore[1] == 'IDS') {
    					$updatePortfolio = "UPDATE `industrial_design` SET `retail_invoice_number` = '' WHERE `transaction_id` = '".$serviceId."'";
					}else if ($firstUnderscore[1] == 'PTN') {
    					$updatePortfolio = "UPDATE `patent` SET `retail_invoice_number` = '' WHERE `transaction_id` = '".$serviceId."'";
					}else if ($firstUnderscore[1] == 'TSL') {
						$updatePortfolio = "UPDATE `sales` SET `retail_invoice_number` = '' WHERE `transaction_id` = '".$serviceId."'";
					}else if ($firstUnderscore[1] == 'DT') {
						$updatePortfolio = "UPDATE `dsc_token` SET `retail_invoice_number` = '' WHERE `transaction_id` = '".$serviceId."'";
					}else if ($firstUnderscore[1] == 'OS') {
						$updatePortfolio = "UPDATE `other_services` SET `retail_invoice_number` = '' WHERE `transaction_id` = '".$serviceId."'";
					}else if ($firstUnderscore[1] == 'MOR') {
						$updatePortfolio = "UPDATE `mobile_repairing` SET `retail_invoice_number` = '' WHERE `transaction_id` = '".$serviceId."'";
					}else if ($firstUnderscore[1] == 'TND') {
						$updatePortfolio = "UPDATE `e_tender` SET `retail_invoice_number` = '' WHERE `transaction_id` = '".$serviceId."'";
					}else if ($firstUnderscore[1] == '24G') {
						$updatePortfolio = "UPDATE `24g` SET `retail_invoice_number` = '' WHERE `transaction_id` = '".$serviceId."'";
					}
					$run_updatePortfolio = mysqli_query($con,$updatePortfolio);
				}
			}

			$deleteRetailInvoice_query = "DELETE FROM `retail_invoice` WHERE `id` = '".$_POST['tempGSTIDdel']."'";
			// $deleteServiceIncome_query = "DELETE FROM `service_income` WHERE `service_id` = '".$rowFetchServiceId['transaction_id']."'";
			$run_del_query_1 = mysqli_query($con,$deleteRetailInvoice_query);
			// $run_del_query_2 = mysqli_query($con,$deleteServiceIncome_query);
			if ($run_del_query_1) {
				$alertMsg = "Record Deleted";
				$alertClass = "alert alert-danger";
				// $deletedRecords = true;
			}
		}
	}
	
	if (isset($_POST['bulk_delete'])) {
		if (isset($_POST['tempMultipleIDdel']) && !empty($_POST['tempMultipleIDdel'])) {
			$MultipleDeleteArray = json_decode(stripslashes($_POST['tempMultipleIDdel']));
			//$allValues = implode(",", $MultipleDeleteArray);
			$TransactionCount = 0;
			$ServiceIncomeCount = 0;
			$DeletedTransaction = [];
			$DeletedServiceIncome = [];
			foreach($MultipleDeleteArray as $deleteList){
				$fetch_Transaction = "SELECT * FROM `gst_fees` WHERE `id` IN ('".$deleteList."')";
				$runTransaction = mysqli_query($con, $fetch_Transaction);
				$countTransactionRecords = mysqli_num_rows($runTransaction);
				if ($countTransactionRecords > 0) {
					$rowFetchServiceId = mysqli_fetch_array($runTransaction);
					$fetchServiceIncomeQuery = "SELECT `date`,`category`,`client_name`,`service_id`,`amount`,`amount_credited`,`transaction_id`,`description` FROM `service_income` WHERE `service_id` = '".$rowFetchServiceId['transaction_id']."'";
					$run_fetchServiceIncomeQuery = mysqli_query($con, $fetchServiceIncomeQuery);
					$countServiceIncomeRecords = mysqli_num_rows($run_fetchServiceIncomeQuery);
					$runServiceId = mysqli_query($con, $fetch_Transaction);
					while($While_rowFetchServiceId = mysqli_fetch_array($runServiceId)){
						$tempTransactionArray = [$While_rowFetchServiceId['client_name'].",".$While_rowFetchServiceId['date'].",".$While_rowFetchServiceId['return_type'].",".$While_rowFetchServiceId['billing_year'].",".$While_rowFetchServiceId['fees_mode'].",".$While_rowFetchServiceId['consulting_fees'].",".$While_rowFetchServiceId['fees_received'].",".$While_rowFetchServiceId['transaction_id']];
						// ,[implode(',', (array)$While_rowFetchServiceId['users_access'])]
						array_push($DeletedTransaction, $tempTransactionArray);
						$TransactionCount++;
					}
					if ($countServiceIncomeRecords > 0) {
						while($row_fetchServiceIncome = mysqli_fetch_array($run_fetchServiceIncomeQuery)){
							$tempServiceIncomeArray = [$row_fetchServiceIncome['date'].",".$row_fetchServiceIncome['category'].",".$row_fetchServiceIncome['client_name'].",".$row_fetchServiceIncome['service_id'].",".$row_fetchServiceIncome['amount'].",".$row_fetchServiceIncome['amount_credited'].",".$row_fetchServiceIncome['transaction_id'].",".$row_fetchServiceIncome['description']];
							array_push($DeletedServiceIncome, $tempServiceIncomeArray);
							$ServiceIncomeCount++;
						}
					}
					$deleteRetailInvoice_query = "DELETE FROM `gst_fees` WHERE `id` IN ('".$deleteList."')";
					$deleteServiceIncome_query = "DELETE FROM `service_income` WHERE `service_id` = '".$rowFetchServiceId['transaction_id']."'";
					$run_del_query_1 = mysqli_query($con,$deleteRetailInvoice_query);
					$run_del_query_2 = mysqli_query($con,$deleteServiceIncome_query);
				}
			}
			if ($TransactionCount > 0) {
				$_SESSION['DeletedTransactionQuery'] = $DeletedTransaction;
				$deletedRecords = true;
			}
			if ($ServiceIncomeCount > 0) {
				$_SESSION['DeletedServiceIncomeQuery'] = $DeletedServiceIncome;
				$deletedServiceIncomeRecords = true;
			}
			if ($run_del_query_1 && $run_del_query_2) {
				$alertMsg = $TransactionCount." Record(s) Deleted";
				$alertClass = "alert alert-danger";
			}
		}
	}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Vowel Enterprise CMS - GST Fees</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css"
        integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <!--script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script-->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
 <style>
 .hidden {
    display: none;
  }
	.lder {
        width: 90px;
        height: 90px;
        border-radius: 50%;
        background: linear-gradient(45deg, #ff9900, #ffcc00);
        position: relative;
        animation: loader-animation 2s ease-in-out infinite;
        transform-origin: center center;
    }

    #sending{
        padding-top: 30px;
        color: black;
        font-weight: bold;
        font-size: 1.1em;
    }

    .lder:before, .lder:after {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: inherit;
        height: inherit;
        border-radius: inherit;
        background: inherit;
        opacity: 0.6;
        animation: loader-animation 3s ease-in-out infinite;
    }
    
    .lder:before {
        animation-delay: 0.5s;
    }
    
    @keyframes loader-animation {
        0% {
            transform: scale(0);
        }
        50% {
            transform: scale(1);
        }
        100% {
            transform: scale(0);
        }
    }

	</style>
    <style type="text/css">
        /*Multiple Select Checkboxes*/
        /*:root
	    {
	        --text: "Select values";
	    }*/
        .multiple_select {
            height: 18px;
            width: 90%;
            overflow-y: auto;
            -webkit-appearance: menulist;
            position: relative;
        }

        .multiple_select::before {
            /* //content: var(--text); */
            display: block;
            margin-left: 5px;
            margin-bottom: 2px;
        }

        .multiple_select_active {
            /* //overflow: visible !important; */
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
    </style>
</head>

<body>
    <div class="modal hide" id="loaderpopup" data-backdrop="static" data-keyboard="false" style="z-index: 10000;">
	<!--<div class="modal fade" id="loaderpopup" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">-->
      <div class="modal-dialog modal-dialog-centered" role="document" style="width:200px;">
        <div class="modal-content" style="background:transparent;border:none">
          <div class="modal-body">
              <center>
            	<div class="lder"><p id="sending">sending . . . </p></div>
            	</center>
          </div>
        </div>
      </div>
    </div>
    <div class="container-fluid">
        <div id="EditUserDiv"></div>
        <h2 align="center" class="pageHeading" id="pageHeading">Retail Invoice Transaction</h2>
        <div class="row border justify-content-center" id="after-heading">
            <?php 
			if(isset($_POST['dsc_reseller_csv'])){
				//var_dump($_FILES['dsc_reseller_file']);
				//echo var_dump(expression)
				//echo $_FILES['dsc_reseller_file']['type'];
				//$info = pathinfo($_FILES['dsc_reseller_file']['tmp_name']);
				$type = explode(".",$_FILES['dsc_reseller_file']['name']);
				if(strtolower(end($type)) == 'csv'){
					$file = $_FILES['dsc_reseller_file']['tmp_name'];
					$state_csv = false;
					$first = false;
					$second = false;
					$ExistFlag = false;
					$bankExistFlag = false;
					$firstRow = false;
					$FormatErrorFlag = false;
					$ErroneousData = [];
					$ErroneouslineDataCount = 0;
					//$stored = [];
					$NotMatchedlineData = [];
					$DuplicatelineData = [];
					$duplicateRow = [];
					$successCount = 0;
					//$EmptylineData = [];
					$EmptylineDataCount = 0;
					$file = fopen($file, "r");
					$count = 0;
					$temp_ErroneouslineDataCount = 0;
					while ($row = fgetcsv($file)) {
						if (!$firstRow) {
							$firstFormat = implode(",", $row);
							// ,Fees Received,Service Id,Users Access
							if ($firstFormat != "Client Name,Date,Return Type,Billing Year,Fees Mode,Consulting Fees") {
								//echo "Not Matched";
								$FormatErrorFlag = true;
							}else{
								$FormatErrorFlag = false;
								$firstRow = true;
								//echo "Matched";
							}
						}
						if ($FormatErrorFlag == false) {
							if (!$first) {
								$first = true;
							}else{
								$clientMatched = false;
								$emptyRow = [];
								$notmatchedRow = [];
								$duplicateRow = [];
								$count++;
								$row[0] = trim(mysqli_real_escape_string($con,$row[0]));
								$row[1] = trim(mysqli_real_escape_string($con,$row[1]));
								$row[2] = trim(mysqli_real_escape_string($con,$row[2]));
								$row[3] = trim(mysqli_real_escape_string($con,$row[3]));
								$row[4] = trim(mysqli_real_escape_string($con,$row[4]));
								$row[5] = trim(mysqli_real_escape_string($con,$row[5]));
								// $row[6] = trim(mysqli_real_escape_string($con,$row[6]));
								// $row[7] = trim(mysqli_real_escape_string($con,$row[7]));
								// $row[8] = trim(mysqli_real_escape_string($con,$row[8]));
								if ($row[1] != "") {
									if (strtotime($row[1]) != '') {
										$row[1] = date("Y-M-d",strtotime($row[1]));
									}else{
										$row[1] = DateTime::createFromFormat('d/m/Y', $row[1], new DateTimeZone(('UTC')))->format('Y-M-d');
									}
								}

								$row[0] = strtoupper($row[0]);
								if ($row[0] == "") {
									array_push($emptyRow,"Client Name");
									$ErroneouslineDataCount++;
								}
								if ($row[1] == "") {
									array_push($emptyRow,"Date");
									$ErroneouslineDataCount++;
								}
								if ($row[2] == "") {
									array_push($emptyRow,"Return Type");
									$ErroneouslineDataCount++;
								}
								if ($row[3] == "") {
									array_push($emptyRow,"Billing Year");
									$ErroneouslineDataCount++;
								}
								if ($row[4] == "") {
									array_push($emptyRow,"Fees Mode");
									$ErroneouslineDataCount++;
								}
								if ($row[5] == "") {
									array_push($emptyRow,"Consulting Fees");
									$ErroneouslineDataCount++;
								}
								/* if ($row[6] == "") {
									array_push($emptyRow,"Users Access");
									$ErroneouslineDataCount++;
								} */

								if ($row[0] != "") {
									$clientQuery = "SELECT `client_name` FROM `client_master` WHERE `gst` = '1' AND `company_id` = '".$_SESSION['company_id']."'";
									$Result_client = mysqli_query($con,$clientQuery);
									if(mysqli_num_rows($Result_client) > 0){
										//echo nl2br("\n".$row[5]);
										while ($client_name_row = mysqli_fetch_array($Result_client)) {
											//echo $client_name_row['client_name'];
											if ($row[0] == $client_name_row['client_name']) {
												$clientMatched = true;
												break;
											}else{
												$clientMatched = false;
											}
										}
										if ($clientMatched == false) {
											array_push($notmatchedRow,"Client Name");
											$ErroneouslineDataCount++;
										}
									}
								}
								if ($row[2] != "" && $row[2] != "Regular" && $row[2] != "Composition") {
									array_push($notmatchedRow,"Return Type");
									$ErroneouslineDataCount++;
								}
								if ($row[3] != "" && $row[3] != "2019-20" && $row[3] != "2020-21" && $row[3] != "2021-22") {
									array_push($notmatchedRow,"Billing Year");
									$ErroneouslineDataCount++;
								}
								if ($row[4] != "" && $row[4] != "Annually" && $row[4] != "Monthly" && $row[4] != "Quarterly") {
									array_push($notmatchedRow,"Fees Mode");
									$ErroneouslineDataCount++;
								}

								// echo explode(",", $row[5])[0];
								/* if ($row[6] != "") {
									$tempUsersArrayExplode = explode(",", $row[6]);
									$tempUsersArrayImplode = [];
									foreach($tempUsersArrayExplode as $tempUsersArrayValue){
										array_push($tempUsersArrayImplode, '\''.trim($tempUsersArrayValue).'\'');
									}
									// $tempUsersArrayImplode = implode(",", $tempUsersArrayExplode);
									// print_r($tempUsersArrayImplode);
									// $tempUsersArray = implode(",", explode(",", $row[6]));
									$fetchUserAccessId = "SELECT * FROM `users` WHERE `company_id` = '".$_SESSION['company_id']."' AND `username` IN (".implode(",", $tempUsersArrayImplode).")";
									// $fetchUserAccessId = "SELECT * FROM `users` WHERE `company_id` = '".$_SESSION['company_id']."' AND CONCAT(`firstname`, ' ', `lastname`) IN (".implode(",", $tempUsersArrayImplode).")";
									// echo $fetchUserAccessId;
									$runUserAccessId = mysqli_query($con,$fetchUserAccessId);
									$UserAccessIds = [];
									while ($UserAccessIdrow = mysqli_fetch_array($runUserAccessId)) {
										array_push($UserAccessIds, $UserAccessIdrow['id']);
									}
									// print_r($UserAccessIds);
									$fetchAdminId = "SELECT * FROM `users` WHERE `company_id` = '".$_SESSION['company_id']."' AND `admin_status` = '1'";
									$runAdminId = mysqli_query($con,$fetchAdminId);
									$AdminIdrow = mysqli_fetch_array($runAdminId);
									if ($_SESSION['admin_status'] == "1") {
										if ($row[6] != "") {
											$users_access = $AdminIdrow['id'].",".implode(',', $UserAccessIds);	
										}else{
											$users_access = $AdminIdrow['id'];
										}			
									}else{
										$users_access = $AdminIdrow['id'].",".$_SESSION['user_id'];
									}

									// print_r($users_access);
									$checkUserAccessQuery = "SELECT * FROM `users` WHERE `company_id` = '".$_SESSION['company_id']."'";
									$Result_userAccess = mysqli_query($con,$checkUserAccessQuery);
									$TempCount = 0;
									if(mysqli_num_rows($Result_userAccess) > 0){
										while ($id_row = mysqli_fetch_array($Result_userAccess)) {
											//echo $id_row['client_name'];
											foreach($tempUsersArrayExplode as $tempUsersArrayValue){
												if ($tempUsersArrayValue == $id_row['username']) {
													$idMatched = true;
													$TempCount++;
													break;
												}else{
													$idMatched = false;
												}
											}
											// if ($idMatched == false) {
											// 	break;
											// }
										}
										// echo $TempCount;
										// echo count($tempUsersArrayExplode);
										if ($TempCount != count($tempUsersArrayExplode)) {
											array_push($notmatchedRow,"Users Access");
											$ErroneouslineDataCount++;
										}
									}
								} */
								/* if ($row[1] != "") {
									$checkDSCCompanyQuery = "SELECT dsc_reseller_company FROM `client_master` WHERE `dsc_reseller` = 1 AND `client_name` = '".$row[0]."' AND `company_id` = '".$_SESSION['company_id']."'";
									$Result_dscCompany = mysqli_query($con,$checkDSCCompanyQuery);
									if(mysqli_num_rows($Result_dscCompany) > 0){
										$dsc_company_row = mysqli_fetch_array($Result_dscCompany);
										//echo $dsc_company_row;
										$string_version = implode(',', $dsc_company_row);
										$destination_array = explode(',', $string_version);
										//echo $destination_array[0];
										foreach ($destination_array as $val) {
											//echo $dsc_company_row['client_name'];
											//$dscAllCompany = explode(',', $val);
											//echo nl2br("\n".$dscAllCompany."\n");
											//echo nl2br("\nVal - ".$val);
											//echo nl2br("\DSCCompany - ".$dsc_company_row);
											if ($row[1] == $val) {
												$dscCompanyMatched = true;
												break;
											}else{
												$dscCompanyMatched = false;
											}
										}
										if ($dscCompanyMatched == false) {
											array_push($notmatchedRow,"DSC Company");
											$ErroneouslineDataCount++;
										}
									}
								}
								if ($row[12] == "Bank Online" && $row[13] != "") {
									$checkbankQuery = "SELECT `bank_name` FROM `company_bank_details` WHERE `user_id` = '".$_SESSION['user_id']."' AND `company_id` = '".$_SESSION['company_id']."'";
									$Result_bank = mysqli_query($con,$checkbankQuery);
									if(mysqli_num_rows($Result_bank) > 0){
										while ($bank_name_row = mysqli_fetch_array($Result_bank)) {
											//echo $bank_name_row['client_name'];
											if ($row[13] == $bank_name_row['bank_name']) {
												$bankMatched = true;
												break;
											}else{
												$bankMatched = false;
											}
										}
										if ($bankMatched == false) {
											array_push($notmatchedRow,"Payment Description");
											$ErroneouslineDataCount++;
										}
									}
								}
								if ($row[8] != "Approved" && $row[8] != "Rejected") {
									array_push($notmatchedRow,"Status");
									$ErroneouslineDataCount++;
								}
								if ($row[12] != "Cash" && $row[12] != "Bank Online" && $row[12] != "Billing") {
									array_push($notmatchedRow,"Payment Mode");
									$ErroneouslineDataCount++;
								} */
								/* $serviceIdExist = false;
								if ($row[8] != "") {
									$Exist_Query = "SELECT * FROM `gst_fees` WHERE `transaction_id` = '".$row[8]."'";
									$Result_Exist = mysqli_query($con,$Exist_Query);
									if(mysqli_num_rows($Result_Exist) > 0){
										array_push($duplicateRow,"Service Id");
										$ErroneouslineDataCount++;
										$serviceIdExist = true;
									}
								} */
								if ($ErroneouslineDataCount > 0) {
									$erroneous_value = implode(",", $emptyRow)."','". implode(",", $notmatchedRow)."','". implode(",", $duplicateRow)."','". implode("','", $row);
								}else if (!$second) {
									//$second = true;
									$erroneous_value = "Uploaded"."','"."','".""."','". implode("','", $row);
								}
								if($temp_ErroneouslineDataCount == $ErroneouslineDataCount && $temp_ErroneouslineDataCount != 0){
									$erroneous_value = "Uploaded"."','"."','".""."','". implode("','", $row);
								}
								$temp_ErroneouslineDataCount = $ErroneouslineDataCount;

								if ($row[0] == "" || $row[1] == "" || $row[2] == "" || $row[3] == "" || $row[4] == "" || $row[5] == "") {
									//array_push($NotMatchedlineData,$value2);
									$EmptylineDataCount++;
								} else if ($row[0] != "" && $row[1] != "" && $row[2] != "" && $row[3] != "" && $row[4] != "" && $row[5] != "") {
									//  && ($serviceIdExist == false)
									/* if ($row[12] == "Bank Online" && $row[13] == "") {
										$ErroneouslineDataCount++;
										$EmptylineDataCount++;
										//echo "<script type='text/javascript'>alert('".$row[11]."')</script>";
										//echo "<script type='text/javascript'>alert(ronak);</script>";
									}else{
										if ($row[12] != "Bank Online") {
											$row[13] = "";
										} */
										//if ($row[7] != "Approved" || $row[7] != "Rejected") {}
										/* if ($row[7] == "") {
											$row[7] = 0;
										}
										if ($row[8] == '') {
											$fetchLastTransactionId = "SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = '".$DBName."' AND TABLE_NAME = 'gst_fees'";
											// echo $fetchLastTransactionId;
											$run_fetchLastTransactionId = mysqli_query($con,$fetchLastTransactionId);
											$transaction_id = "VE_GST_954";
											if (mysqli_num_rows($run_fetchLastTransactionId) > 0) {
												$FetchlastTransactionID_row = mysqli_fetch_array($run_fetchLastTransactionId);
												$transaction_id = "VE_GST_".($FetchlastTransactionID_row['AUTO_INCREMENT'] * 954);
												$row[8] = $transaction_id;
											}
										} */
										$fetchLastTransactionId = "SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = '".$DBName."' AND TABLE_NAME = 'gst_fees'";
										// echo $fetchLastTransactionId;
										$run_fetchLastTransactionId = mysqli_query($con,$fetchLastTransactionId);
										$transaction_id = "VE_GST_954";
										if (mysqli_num_rows($run_fetchLastTransactionId) > 0) {
											$FetchlastTransactionID_row = mysqli_fetch_array($run_fetchLastTransactionId);
											$transaction_id = "VE_GST_".($FetchlastTransactionID_row['AUTO_INCREMENT'] * 954);
											// $row[8] = $transaction_id;
										}
										// '".$transaction_id."',
										$value = "'".$_SESSION['company_id']."','". implode("','", $row) . "','".$_SESSION['username']."','".date('Y-m-d H:i:sa')."'";
										$value2 = implode("','", $row);
										//echo $value;
										//if (in_array($row[3], $stored)) { continue;}
										//echo $row[3];
										// $FinanceYear = strtok($row[5], '-');
										$fetchGSTNo = "SELECT `gst_no` FROM `client_master` WHERE `client_name` = '".$row[0]."' AND `company_id` = '".$_SESSION['company_id']."'";
										$runGSTNo = mysqli_query($con,$fetchGSTNo);
										$gst_no = mysqli_fetch_array($runGSTNo);

										// , `fees_received`, `transaction_id` ,'".$row[7]."','".$row[8]."',`users_access`,'".$users_access."'
										$insert_query = "INSERT INTO `gst_fees`(`company_id`,`client_name`, `date`, `gst_no`, `return_type`, `billing_year`, `fees_mode`, `consulting_fees`,`transaction_id`, `modify_by`,`modify_date`) VALUES ('".$_SESSION['company_id']."','".$row[0]."', '".$row[1]."','".$gst_no[0]."','".$row[2]."','".$row[3]."','".$row[4]."','".$row[5]."','".$transaction_id."','".$_SESSION['username']."','".date('Y-m-d H:i:sa')."')";
										// echo $insert_query;
										$prevQuery = "SELECT `client_name` FROM `client_master` WHERE `gst` = '1' AND `company_id` = '".$_SESSION['company_id']."'";
										$prevResult = mysqli_query($con,$prevQuery);

										/* $bankQuery = "SELECT `bank_name` FROM `company_bank_details` WHERE `user_id` = '".$_SESSION['user_id']."' AND `company_id` = '".$_SESSION['company_id']."'";
										$bankResult = mysqli_query($con,$bankQuery); */
										$checkUserAccessQuery = "SELECT * FROM `users` WHERE `company_id` = '".$_SESSION['company_id']."'";
										$Result_userAccess = mysqli_query($con,$checkUserAccessQuery);

										while ($client_name_row = mysqli_fetch_array($prevResult)) {
											//echo $client_name_row['client_name'];
											$names[] = $client_name_row['client_name'];
										}

										/* while ($bank_name_row = mysqli_fetch_array($bankResult)) {
											//echo $client_name_row['client_name'];
											$bank_names[] = $bank_name_row['bank_name'];
										} */
										while ($useraccessEmail_row = mysqli_fetch_array($Result_userAccess)) {
											//echo $client_name_row['client_name'];
											$user_accessEmail[] = $useraccessEmail_row['username'];
										}

										//$client_name_row = mysqli_fetch_array($prevResult);
										//echo $client_name_row['client_name'];
										if(mysqli_num_rows($prevResult) > 0){
											//$NotMatchedlineData = array($value);
											foreach($names as $name) {
												//echo nl2br("\n".$name."-".$row[0]);
												if ($name == $row[0]) {
													//echo "ROnAK";
													// $ExistFlag = true;
													// break;
													$TempCount = 0;
													foreach($user_accessEmail as $UsersEmail)
													{
														foreach($tempUsersArrayExplode as $tempUsersArrayValue){
															if ($UsersEmail == $tempUsersArrayValue) {
																$ExistFlag = true;
																$TempCount++;
																break;
															}else{
																$ExistFlag = false;
															}
														}
														/* if ($ExistFlag == false) {
															break;
														} */
													}
													// if ($ExistFlag == true) {
													if ($TempCount == count($tempUsersArrayExplode)) {
														break;
													}
												}else if ($name != $row[0]) {
													$ExistFlag = false;
													//echo "False";
													//echo nl2br("\n".$name." - ".$row[0]." - ".$row[7]." - ".$row[11]);
												}
											}
											if ($ExistFlag == false) {
												array_push($NotMatchedlineData,$value2);
											}else{
												//echo $insert_query;
												if(mysqli_query($con,$insert_query)){
													/* if ($row[12] == "Bank Online") {
														$transaction_type = $row[13];
													}else if ($row[12] == "Cash") {
														$transaction_type = "Cash";
													}else{
														$transaction_type = "Billing";
													}
													$update_transaction = "INSERT INTO `transaction_history` (`company_id`, `transaction_id`, `transaction_type`, `client_name`, `portfolio`, `fees`, `amount_received`) VALUES ('".$_SESSION['company_id']."','".date('d-m-Y H:i:sa')."','".$transaction_type."','".$row[0]."','DSC Reseller','".$row[11]."','".$row[14]."')";
													//$update_transaction = "INSERT INTO `transaction_history` (`company_id`, `transaction_id`, `client_name`, `portfolio`, `fees`, `amount_received`) VALUES ('".$_SESSION['company_id']."','".date('d-m-Y H:i:sa')."','".$row[0]."','DSC Reseller','".$row[10]."','".$row[13]."')";
													// echo $update_transaction;
													$run_transaction = mysqli_query($con,$update_transaction); */
													$state_csv = true;
													$successCount++;
													//$stored[] = $row[3];
												}else{
													$state_csv = false;
												}
											}										
											// Update member data in the database
											//$db->query("UPDATE members SET name = '".$name."', phone = '".$phone."', status = '".$status."', modified = NOW() WHERE email = '".$email."'");
										}
									// }
								}
								if (isset($ErroneouslineDataCount) && $ErroneouslineDataCount > 0) {
									array_push($ErroneousData,$erroneous_value);
								}else if (!$second) {
									array_push($ErroneousData,$erroneous_value);
									//$second = true;
								}
							}
						}else{
							$state_csv = "fileError";
							break;
						}
					}
					if ($state_csv == "fileError" && $state_csv != 1) {
						$alertMsg = "Please Check CSV Format!";
						$alertClass = "alert alert-danger";
					}else{
						if ($state_csv) {
							if ($EmptylineDataCount > 0) {
								$alertMsg = "Successfully Imported ".$successCount." record/s & Mandatory field/s are empty in ".$EmptylineDataCount." record/s.";
								$alertClass = "alert alert-success";	
							} else {
								$alertMsg = $successCount." Record/s Successfully Imported.";
								$alertClass = "alert alert-success";
							}
						} else {
							if ($EmptylineDataCount > 0) {
								$alertMsg = "Something went wrong! & Mandatory field/s are empty in ".$EmptylineDataCount." record/s.";
								$alertClass = "alert alert-danger";	
							} else {
								$alertMsg = "Something went wrong!";
								$alertClass = "alert alert-danger";
							}
						}
					}
					if (count($NotMatchedlineData) > 0 || count($DuplicatelineData) > 0) {
						echo "<script type='text/javascript'>
						$(document).ready(function(){ $('#notMatchedRecordModal').modal('show'); });</script>"; ?>
            <!-- Not Matched Record Modal -->
            <div class="modal fade" data-backdrop="static" data-keyboard="false" id="notMatchedRecordModal"
                tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <?php if (count($NotMatchedlineData) > 0 && count($DuplicatelineData) > 0) { ?>
                            <h5 class="modal-title" id="exampleModalLongTitle">Not Matched & Duplicate Values</h5>
                            <?php }else
						        { ?>
                            <?php if (count($NotMatchedlineData) > 0){ ?>
                            <h5 class="modal-title" id="exampleModalLongTitle">Not Matched Values</h5>
                            <?php }else if (count($DuplicatelineData) > 0){ ?>
                            <h5 class="modal-title" id="exampleModalLongTitle">Duplicate Values</h5>
                            <?php }
						        } ?>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <?php if (count($NotMatchedlineData) > 0){ ?>
                            <form method='post' action='Download_gst_fees'>
                                Download Not Matched Data
                                <?php 
											$_SESSION['array_value'] = $NotMatchedlineData;
										?>
                                <button type='submit' name='Download_NotMatched_gst_fees'
                                    class='btn btn-primary btn-sm'><i class='fas fa-download'></i> Download</button>
                            </form>
                            <?php } ?>
                            <?php if (count($DuplicatelineData) > 0){ ?>
                            <form method='post' action='Download_gst_fees' class="mt-2">
                                Download Duplicate Data
                                <?php 
						      			$_SESSION['array_Duplicate_value'] = $DuplicatelineData;
						      		?>
                                <button type='submit' name='Download_Duplicate_gst_fees'
                                    class='btn btn-primary btn-sm'><i class='fas fa-download'></i> Download</button>
                            </form>
                            <?php } ?>
                            <!--div class="table-responsive">
									<table class="table">
										<thead>
											<th>Id</th>
											<th>Client Name</th>
											<th>Date</th>
											<th>Reference</th>
											<th>Type</th>
											<th>Name</th>
											<th>Stock Transfer Type</th>
											<th>Certificate Usage</th>
											<th>Status</th>
											<th>Price Per Stock</th>
											<th>Tokken Usage</th>
											<th>Fees</th>
											<th>Payment Mode</th>
											<th>Payment Description</th>
											<th>Amount</th>
											<th>Modify By</th>
											<th>Modify Date</th>
										</thead>
										<tbody>
										<?php 
										//foreach($NotMatchedlineData as $notmatch){
										//	echo $notmatch;
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
            <div class="col-sm-12 col-lg-12">
                <?php if (isset($_POST['RetailInvoice_save']) || isset($_POST['gstFees_update']) || isset($_POST['gstFees_delete']) || isset($_POST['dsc_reseller_csv']) || isset($_POST['bulk_delete'])) { ?>
                <div class="<?php echo $alertClass; ?> alert-dismissible" role="alert">
                    <?php
				  	echo $alertMsg;
					if (isset($ErroneouslineDataCount)) {
				  		if ($ErroneouslineDataCount > 0) { ?>
                    <form method='post' action='Download_gst_fees'>
                        Download Erroneous Data
                        <?php 
					      			$_SESSION['erroneous_array_value'] = $ErroneousData;
					      		?>
                        <button type='submit' name='Download_erroneous_gst_fees' class='btn btn-primary btn-sm'><i
                                class='fas fa-download'></i> Download</button>
                    </form>
                    <?php }
				  	}
					if ($deletedRecords == true) { ?>
                    <form method='post' action='Download_Deleted_RetailInvoiceFees' class='d-inline'>
                        <button type='submit' name='Download_Deleted_RetailInvoiceFees'
                            id='Download_Deleted_RetailInvoiceFees' class='btn btn-primary btn-sm'><i
                                class='fas fa-download'></i> Download Deleted Records - GST Fees</button>
                    </form>
                    <?php
					}
					if ($deletedRecords == true && $deletedServiceIncomeRecords == true) {
				  ?>
                    <form method='post' action='Download_DeletedRecords' class='d-inline'>
                        <button type='submit' name='Download_Deleted_ServiceIncome' id='Download_Deleted_ServiceIncome'
                            class='btn btn-primary btn-sm'><i class='fas fa-download'></i> Download Deleted Records -
                            Service Income</button>
                    </form>
                    <?php } ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?php } ?>
            </div>
            <form method="post" class="form-inline p-2 d-none" id="import_RetailInvoice" enctype="multipart/form-data">
                <input type="file" class="form-control" name="dsc_reseller_file">
                <input type="submit" class="btn btn-vowel ml-2" name="dsc_reseller_csv" value="Import">&nbsp;
                <a href="html/csv_gst_fees.csv" target="_blank" download="csv_gst_fees.csv">Click here to download CSV
                    format</a>
                <p style="color: red;" class="form-horizontal">Mandatory fields : <span style="color: #000;">Client
                        Name, Date(Date Should be in YYYY-MON-DD format Ex.,2020-June-26), Return Type, Billing Year,
                        Fees Mode, Consulting Fees, Users Access</span></p>
                <!--https://vivaanintellects.com/vowel-->
            </form>
            
            <form method="post" enctype="multipart/form-data" class="col-lg-12 col-sm-12 d-none" id="addNew_RetailInvoice">
                <input type="hidden" readonly name="gstEditID_temp" id="gstEditID_temp"
                    value="<?php if (isset($_POST['editGSTFeesbtn'])) echo $_POST['gstEditID']; ?>">
                <div class="form-inline">
                    <?php
						$fetchLastTransactionId = "SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = '".$DBName."' AND TABLE_NAME = 'tax_invoice'";
						// echo $fetchLastTransactionId;
						$run_fetchLastTransactionId = mysqli_query($con,$fetchLastTransactionId);
						$addNewRetailNumber = "1";
						if (mysqli_num_rows($run_fetchLastTransactionId) > 0) {
							$FetchlastTransactionID_row = mysqli_fetch_array($run_fetchLastTransactionId);
							$addNewRetailNumber = $FetchlastTransactionID_row['AUTO_INCREMENT'];
						}
						$add_NewRetail_invoice_number = date('Ymd').'-'.$addNewRetailNumber;
						// echo $add_NewRetail_invoice_number;
					?>
					<?php 
                    // / Query to fetch previous invoice number and reference number
                        $query = "SELECT retail_invoice_number, reference_number FROM retail_invoice ORDER BY id DESC LIMIT 1";
                        $result = $con->query($query);
                        
                        $previous_invoice_number = "";
                        $previous_reference_number = "";
                        
                        if ($result->num_rows > 0) {
                            $row = $result->fetch_assoc();
                            $previous_invoice_number = $row['retail_invoice_number'];
                            $previous_reference_number = $row['reference_number'];
                        }
                    ?>
                    <div class="form-group d-block col-md-3">
                        <label for="invoice_number" class="d-flex justify-content-between p-2">
                            Invoice Number <span style="color: red;" class="pl-1">*</span> <!-- Asterisk next to Invoice Number -->
                            <span>Previous No: <span style="color: red;" class="pl-1"><?php echo $previous_invoice_number; ?></span></span>
                        </label>
                        <input type="number" min='1' required name="invoice_number" class="form-control w-100"
                            id="invoice_number" aria-describedby="emailHelp" autocomplete="off"
                            placeholder="Enter Invoice Number">
                        <span id="invoice_number_status"></span>
                    </div>
                    <div class="form-group d-block col-md-3">
                        <label for="reference_number" class="float-left p-2">
                            Reference Number <span style="color: red;" class="pl-1">*</span>
                        </label>
                        <input 
                            type="text" 
                            required 
                            name="reference_number" 
                            class="form-control w-100" 
                            id="reference_number"
                            placeholder="Enter Reference Number"
                            <?php if (isset($_POST['editGSTFeesbtn'])) { echo "value=" . htmlspecialchars($edit_date); } ?> 
                            oninvalid="this.setCustomValidity('Please fill out this field with valid input (A-Z, a-z, 0-9, /, \\, -).')" 
                            oninput="this.setCustomValidity('')">
                    
                        <!--<small id="allowed-pattern" style="color: gray; font-size: 12px;">Allowed: A-Z, a-z, 0-9, /, \\, -</small>-->
                        <small id="error-message" style="color: red; display: none;">Only letters, numbers, /, \, and - are allowed!</small>
                    </div>
                    
                    <script>
                    document.getElementById("reference_number").addEventListener("input", function(event) {
                        let inputField = event.target;
                        let value = inputField.value;
                    
                        // Regular expression to allow letters (A-Z, a-z), numbers (0-9), and /, \, -
                        let validPattern = /^[A-Za-z0-9\/\\-]*$/;
                    
                        // Show/hide error message dynamically
                        const errorMessage = document.getElementById("error-message");
                        if (!validPattern.test(value)) {
                            inputField.value = value.replace(/[^A-Za-z0-9\/\\-]/g, ''); // Remove invalid characters
                            errorMessage.style.display = "block";
                        } else {
                            errorMessage.style.display = "none";
                        }
                    });
                    </script>
                    <div class="form-group d-block col-md-3">
                        <label for="exampleInput1" class="float-left p-2">Date <span style="color: red;"
                                class="pl-1">*</span></label>
                        <input type="date" required name="date" class="form-control w-100" id="exampleInput1"
                            aria-describedby="emailHelp" placeholder="Enter Date"
                            <?php if (isset($_POST['editGSTFeesbtn'])) {echo "value=".$edit_date;}?>>
                    </div>
                    <div class="form-group d-block col-md-3">
                        <label for="exampleInput1" class="float-left p-2">Bill To <span style="color: red;"
                                class="pl-1">*</span></label>
                        <select name="category" required class="form-control w-100 category" style="width: 100%;"
                            id="category" <?php if (isset($_POST['editGSTFeesbtn'])) { echo "disabled"; } ?>>
                            <option value="Clients">Clients</option>
                            <option value="drawee1">Drawee</option>
                        </select>
                    </div>
                    <div class="form-group d-block col-md-3">
                        <label for="ClientNameSelect1" class="float-left p-2">Client Name <span style="color: red;"
                                class="pl-1">*</span></label>
                        <div class="d-block">
                            <select name="client_name" required class="form-control w-100 client_name" style="width:100%;" id="ClientNameSelect1" <?php if (isset($_POST['editPanbtn'])) {
                                                                                                                                                        echo "disabled";
                                                                                                                                                    } ?>>
                                <option value="" selected disabled hidden>Select</option>
                                <?php
                                // Fetch the type from recipient_name_setup
                                $type_query = "SELECT type FROM recipient_name_setup";
                                $type_result = mysqli_query($con, $type_query);
                                $type_row = mysqli_fetch_assoc($type_result);
                                $type = $type_row['type']; // Get the type
                        
                                // Fetch clients
                                $fetch_Client = "SELECT id, client_name, company_name FROM client_master WHERE company_id = '" . $_SESSION['company_id'] . "' ORDER BY client_name ASC";
                                $run_fetch_Client = mysqli_query($con, $fetch_Client);
                                while ($row = mysqli_fetch_array($run_fetch_Client)) {
                                    $display_value = ''; // Initialize display value
                        
                                    // Determine display value based on type
                                    switch ($type) {
                                        case 'Recipiet Name (Company Name)':
                                            $display_value = $row['client_name'] . ' (' . $row['company_name'] . ')';
                                            break;
                                        case 'Comapny Name (Recipiet Name)':
                                            $display_value = $row['company_name'] . ' (' . $row['client_name'] . ')';
                                            break;
                                        case 'Recipient Name':
                                            $display_value = $row['client_name'];
                                            break;
                                        case 'Company Name':
                                            $display_value = $row['company_name'];
                                            break;
                                        default:
                                            $display_value = $row['client_name']; // Fallback if type doesn't match
                                    }
                                ?>
                                    <option value="<?= $row['id'] . ',' . $row['client_name']; ?>"
                                        <?php if (isset($_POST['editPanbtn']) && $edit_client_name == $row['client_name']) {
                                            echo "selected";
                                        } ?>>
                                        <?= $display_value; ?>
                                    </option>
                                <?php } ?>
                            </select>
                            <input type="hidden" name="temp_client_name" id="temp_client_name" value="<?php if (isset($_POST['editPanbtn'])) {
                                                                                                            echo $edit_client_name;
                                                                                                        } ?>" readonly>
                        </div>
                    </div>
                    <div class="form-group d-block col-md-3">
					    <label for="fees_received" class="float-left p-2">Client ID</label>			
					    <input type="text" readonly class="form-control w-100" name="client_ID" id="client_ID" aria-describedby="emailHelp" placeholder="Enter Fees Received" value="<?php if (isset($_POST['editPanbtn'])) {echo $edit_fees_received;}?>">	
					</div>
                        <div class="form-group d-none col-md-3" id="drawee1">
                        <label for="igst" class="float-left p-2">Drawee <span style="color: red;"
                                class="pl-1">*</span></label>
                                <a href="#" class="float-right add_service_Link pt-2" data-toggle="modal" data-target="#addServiceModal"><i class="fas fa-plus"></i> Add New Drawee</a>
                        <select name="drawee" class="form-control w-100 drawee"
                                style="width: 100%;" id="drawee">
                                <option value="" selected disabled hidden>Select</option>
                            </select>
                            
                    </div>
                    <div class="form-group d-none col-md-3" id="drawee_id">
					    <label for="fees_received" class="float-left p-2">Drawee ID</label>			
					    <input type="text" readonly class="form-control w-100" name="drawee_ID" id="drawee_ID" aria-describedby="emailHelp" placeholder="Enter Fees Received" value="<?php if (isset($_POST['editPanbtn'])) {echo $edit_fees_received;}?>">	
					</div>
                    <div class="form-group d-block col-md-3">
                        <label for="gst_no_temp" class="float-left p-2">Client Company Name<span style="color: red;"
                                class="pl-1">*</span></label>
                        <div class="d-block">
                            <input type="text" readonly name="cc_name" class="form-control w-100"
                                id="cc_name" aria-describedby="emailHelp" placeholder="Company name"
                                value="<?php if (isset($_POST['editGSTFeesbtn'])) {echo $edit_gst_no;}?>">
                            <!--<input type="text" readonly name="Drawee_id" id="Drawee_id">-->
                        </div>
                    </div>
                   
                     <script>
    document.addEventListener("DOMContentLoaded", function () {
        const categorySelect = document.getElementById("category");
        const draweeSection = document.getElementById("drawee1");
        const companySection = document.getElementById("d_comapny");
        const drawee_idSection = document.getElementById("drawee_id");

        // Initial state
        if (categorySelect.value === "drawee1") {
            draweeSection.classList.remove("d-none");
            companySection.classList.remove("d-none");
            drawee_idSection.classList.remove("d-none");
        }

        categorySelect.addEventListener("change", function () {
            if (categorySelect.value === "drawee1") {
                draweeSection.classList.remove("d-none");
                companySection.classList.remove("d-none");
                drawee_idSection.classList.remove("d-none");
            } else {
                draweeSection.classList.add("d-none");
                companySection.classList.add("d-none");
                drawee_idSection.classList.add("d-none");
            }
        });
    });
</script>
 <div class="form-group d-none col-md-3" id="d_comapny">
                        <label for="gst_no_temp" class="float-left p-2">Drawee Company Name<span style="color: red;"
                                class="pl-1">*</span></label>
                        <div class="d-block">
                            <input type="text" readonly required name="c_name" class="form-control w-100"
                                id="c_name" aria-describedby="emailHelp" placeholder="Company name"
                                value="<?php if (isset($_POST['editGSTFeesbtn'])) {echo $edit_gst_no;}?>">
                            <!--<input type="text" readonly name="Drawee_id" id="Drawee_id">-->
                        </div>
                    </div>
                    <div class="form-group d-block col-md-3">
                        <label for="gst_no_temp" class="float-left p-2">GST Number<span style="color: red;"
                                class="pl-1">*</span></label>
                        <div class="d-block">
                            <input type="text" disabled required name="gst_no_temp" class="form-control w-100"
                                id="gst_no_temp" aria-describedby="emailHelp" placeholder="GST Number"
                                value="<?php if (isset($_POST['editGSTFeesbtn'])) {echo $edit_gst_no;}?>">
                            <input type="hidden" readonly name="gst_no" id="gst_no"
                                value="<?php if (isset($_POST['editGSTFeesbtn'])) {echo $edit_gst_no;}?>">
                        </div>
                    </div>
                   
                    <!--div class="form-group d-block col-md-3">
					    <label for="exampleInput1" class="float-left p-2">Client Name</label>
					    <input type="text" name="client_name" class="form-control w-100" id="exampleInput1" aria-describedby="emailHelp" placeholder="Enter Client Name" <?php //if (isset($_POST['editGSTFeesbtn'])) {echo "value=".$edit_client_name;}?>>
					</div-->
                    <div class="form-group d-block col-md-3">
                        <label class="float-left p-2" for="return_type">Service Id(s) <span style="color: red;"
                                class="pl-1">*</span></label>
                        <!-- <input type="text" name="temp_serviceIds" id="temp_serviceIds" readonly class="form-control w-100"> -->
                        <textarea name="temp_serviceIds" class="form-control" id="temp_serviceIds" cols="28" rows="3"
                            readonly></textarea>
                        <input type="hidden" name="serviceIds" id="serviceIds"
                            value="<?php if (isset($_POST['editGSTFeesbtn'])) echo $edit_return_type; ?>">
                        <span id="serviceIds_status"></span>
                    </div>
                    
                    
                   
                    <!-- <div class="form-group d-block col-md-3">
                        <label class="float-left p-2" for="temp_TotalAmount">Retailable Amount (₹) <span
                                style="color: red;" class="pl-1">*</span></label>
                        <input type="text" class="form-control w-100" name="temp_TotalAmount" id="temp_TotalAmount"
                            readonly>
                        <input type="hidden" readonly name="TotalAmount" id="TotalAmount"
                            value="<?php if (isset($_POST['editGSTFeesbtn'])) {  echo $edit_temp_TotalAmount; } ?>">
                    </div> -->
                    <!-- </div>
				<div class="form-inline"> -->
                    <!-- <div class="form-group d-block col-md-3">
                        <label class="float-left p-2" for="gst_type">GST Type <span style="color: red;"
                                class="pl-1">*</span></label>
                        <select class="form-control w-100" name="gst_type" id="gst_type">
                            <option value="CGST & SGST" <?php if (isset($_POST['editGSTFeesbtn'])) {
                                if ($edit_gst_type == "CGST & SGST" ) echo 'selected' ;}?>>CGST & SGST</option>
                            <option value="IGST" <?php if (isset($_POST['editGSTFeesbtn'])) {
                                if ($edit_gst_type == "IGST" ) echo 'selected' ;}?>>IGST</option>
                        </select>
                    </div>
                    <div class="form-group d-block col-md-3" id="cgst_sgst_DIV">
                        <label for="cgst" class="float-left p-2">CGST & SGST (%) <span style="color: red;"
                                class="pl-1">*</span></label>
                        <div class="input-group w-100">
                            <div class="input-group-prepend w-50">
                                <input type="number" min="0" class="form-control w-100" id="cgst" name="cgst"
                                    placeholder="CGST">
                            </div>
                            <input type="number" min="0" class="form-control" id="sgst" name="sgst" placeholder="SGST">
                        </div>
                    </div>
                    <div class="form-group d-none col-md-3" id="igst_DIV">
                        <label for="igst" class="float-left p-2">IGST (%) <span style="color: red;"
                                class="pl-1">*</span></label>
                        <input type="number" class="form-control w-100" name="igst" min="0" id="igst"
                            aria-describedby="emailHelp" placeholder="Enter IGST"
                            value="<?php if (isset($_POST['editGSTFeesbtn'])) {echo $edit_igst;}?>">
                    </div>
                    <div class="form-group d-block col-md-3" id="tax_cgst_sgst_DIV">
                        <label for="cgst" class="float-left p-2">Retail Value (₹) <span style="color: red;"
                                class="pl-1">*</span></label>
                        <div class="input-group w-100">
                            <div class="input-group-prepend w-50">
                                <input type="number" readonly min="0" class="form-control w-100" id="temp_tax_cgst"
                                    name="temp_tax_cgst" placeholder="CGST">
                                <input type="hidden" readonly min="0" id="tax_cgst" name="tax_cgst"
                                    placeholder="CGST Retail">
                            </div>
                            <input type="number" readonly min="0" class="form-control" id="temp_tax_sgst"
                                name="temp_tax_sgst" placeholder="SGST">
                            <input type="hidden" readonly min="0" id="tax_sgst" name="tax_sgst" placeholder="SGST Retail">
                        </div>
                    </div>
                    <div class="form-group d-none col-md-3" id="tax_igst_DIV">
                        <label for="temp_tax_igst" class="float-left p-2">Retail Value (₹) <span style="color: red;"
                                class="pl-1">*</span></label>
                        <input type="text" readonly class="form-control w-100" name="temp_tax_igst" id="temp_tax_igst"
                            aria-describedby="emailHelp" placeholder="Retail Value"
                            value="<?php if (isset($_POST['editGSTFeesbtn'])) {echo $edit_tax_value;}?>">
                        <input type="hidden" readonly name="tax_igst" id="tax_igst" aria-describedby="emailHelp"
                            placeholder="Retail Value"
                            value="<?php if (isset($_POST['editGSTFeesbtn'])) {echo $edit_tax_value;}?>">
                    </div> -->
                    <div class="form-group col-md-3">
                        <label for="temp_totalValue" class="float-left p-2">Total Value (₹) <span style="color: red;"
                                class="pl-1">*</span></label>
                        <input type="text" readonly class="form-control w-100" name="temp_totalValue"
                            id="temp_totalValue" aria-describedby="emailHelp" placeholder="Total Value"
                            value="<?php if (isset($_POST['editGSTFeesbtn'])) {echo $edit_tax_value;}?>">
                        <input type="hidden" readonly class="form-control w-100" name="totalValue" id="totalValue"
                            aria-describedby="emailHelp" placeholder="Total Value"
                            value="<?php if (isset($_POST['editGSTFeesbtn'])) {echo $edit_tax_value;}?>">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="temp_roundOff" class="float-left p-2">Round Off (₹) <span style="color: red;"
                                class="pl-1">*</span></label>
                        <input type="text" readonly class="form-control w-100" name="temp_roundOff" id="temp_roundOff"
                            aria-describedby="emailHelp" placeholder="Round off Value"
                            value="<?php if (isset($_POST['editGSTFeesbtn'])) {echo $edit_tax_value;}?>">
                        <input type="hidden" readonly class="form-control w-100" name="roundOff" id="roundOff"
                            aria-describedby="emailHelp" placeholder="Round off Value"
                            value="<?php if (isset($_POST['editGSTFeesbtn'])) {echo $edit_tax_value;}?>">
                    </div>
                    <!-- <?php if ($_SESSION['admin_status'] == "1") { ?> -->
                    <!-- <div class="form-group d-block col-md-6">
							<label for="ClientNameSelect1" class="float-left p-2">Users Access</label>
							<select name="users_access[]" id="users_access" multiple class="form-control w-100 h-100 multiple_select">
								<?php 
									/* $fetch_users = "SELECT * FROM `users` WHERE `company_id` = '".$_SESSION['company_id']."' ORDER BY `username`";
									$run_users = mysqli_query($con,$fetch_users);
									while ($row = mysqli_fetch_array($run_users)) 
									{ if($row['admin_status'] == "1") continue;?>
										<option value="<?= $row['id']; ?>" <?php if(isset($_POST['editGSTFeesbtn'])){ 
											foreach ($edit_users_access as $i) if ($i == $row['id']) { echo 'selected'; } } ?>><?= $row['username']; ?></option>
							<?php	} */ ?>
							</select>
		                </div> -->
                    <!-- <?php } ?> -->
                </div>
                <!-- <div class="form-inline">
					<div class="form-group d-block col-md-3">
					    <label for="PaymentModeSelect1" class="float-left p-2">Payment Mode <span style="color: red;" class="pl-1">*</span></label>
					    <div class="d-block">
						    <select name="payment_mode" class="form-control w-100" id="PaymentModeSelect1">
						      <option value="Bank Online" <?php if (isset($_POST['editGSTFeesbtn'])) {
									 if ($edit_payment_mode == "Bank Online" ) echo 'selected' ; }?>>Bank Online</option>
						      <option value="Cash" <?php if (isset($_POST['editGSTFeesbtn'])) {
									 if ($edit_payment_mode == "Cash" ) echo 'selected' ; }?>>Cash</option>
						      <option value="Billing" <?php if (isset($_POST['editGSTFeesbtn'])) {
									 if ($edit_payment_mode == "Billing" ) echo 'selected' ; }?>>Billing</option>
						    </select>
						</div>
					</div>
					<input type="hidden" name="payment_description_hidden" id="payment_description_hidden" <?php if (isset($edit_payment_mode)) {echo "value=".$edit_payment_mode;} ?>>
					<div class="form-group d-block col-md-3" id="payment_descriptionDIV">
					    <label for="BankNameSelect1" class="float-left p-2">Payment Bank <span style="color: red;" class="pl-1">*</span></label>
					    <div class="d-block">
						    <select name="payment_description" class="form-control w-100" id="BankNameSelect1">
						      <?php 
						      	// $fetch_Client = "SELECT `bank_name` FROM `company_bank_details` WHERE `company_id` = '".$_SESSION['company_id']."'";
						      	// $run_fetch_Client = mysqli_query($con,$fetch_Client);
						      	// while ($row = mysqli_fetch_array($run_fetch_Client)) { ?>
						  			<option value="<?= $row['bank_name']; ?>" <?php if (isset($_POST['editGSTFeesbtn'])) { if ($edit_payment_description == $row['bank_name']) { echo "selected"; }}?>><?= $row['bank_name']; ?></option>
						  <?php //}
						      ?>
						    </select>
						</div>
					</div>
					<div class="form-group d-block col-md-3">
					    <label for="amount" class="float-left p-2">Amount Received <span style="color: red;" class="pl-1">*</span></label>			
					    <input type="number" step=".01" class="form-control w-100" min="0" name="amount" id="amount" aria-describedby="emailHelp" placeholder="Enter Amount Received" value="<?php if (isset($_POST['editGSTFeesbtn'])) {echo $edit_amount;}?>">						
					</div>
					<div class="form-group d-block col-md-3">
					    <label for="remarks" class="float-left p-2">Remarks/Transaction Id</label>			
					    <input type="text" class="form-control w-100" name="remarks" id="remarks" aria-describedby="emailHelp" placeholder="Enter Remarks/Transaction Id" <?php if (isset($_POST['editDSCSubscriberbtn'])) {echo "value=".$edit_remarks;}?>>						
					</div>
				</div> -->
                <br>
                <div class="form-inline">
                    <div class="form-group d-block col-md-3">
                        <span style="color: red;" class="pl-1">Note : * fields are mandatory</span>
                    </div>
                </div>
                <input type="hidden" name="makePayment" id="makePayment" readonly>
                <div class="form-group text-center">
                    <?php if (isset($_POST['editGSTFeesbtn'])) {
						echo '<input type="submit" name="gstFees_update" value="UPDATE" class="btn btn-vowel">';
					}else{
						echo '<input type="submit" name="RetailInvoice_save" id="RetailInvoice_save" value="SAVE1" class="btn btn-vowel">';
				// 		echo '<input type="button" name="temp_RetailInvoice_save" id="temp_RetailInvoice_save" value="S1AVE" class="btn btn-vowel">';
					}?>
                </div>
                <div class="bs-example col-lg-12 col-md-12 d-none" id="clientTransaction_dataDIV">
                    <!-- <form method='post' action='Download_serviceIncome_client_transactions'>
						<button type='submit' name='Download_serviceIncome_client_transactions' class='btn btn-primary m-1'><i class='fas fa-download'></i> Download Transactions</button>
					</form>
					<p class="text-right m-0" id="advanceAmount"></p>
					<input type="hidden" readonly class="text-right m-0" id="TextadvanceAmount"/>
					<p class="text-right" id="pendingAmount"></p> -->
                    <table id="clientTransactionTable" class="table"></table>
                </div>
            </form>
            
        </div>

    </div>
    <div class="modal fade" data-backdrop="static" data-keyboard="false" id="serviceModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Terms and Conditions</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Form -->
                    <div id="form-section">
                        <form>
                            <div class="form-group">
                                <div class="row">
                                    <!-- Position Field -->
                                    <div class="col-md-2">
                                        <label for="position_number_txt_drop">Position</label>
                                        <input type="text" class="form-control form-control-lg" id="position_number_txt_drop" placeholder="Enter Position">
                                        <!--<span id="Service-status_position"></span>-->
                                    </div>

                                    <!-- Terms and Conditions Field -->
                                    <div class="col-md-10">
                                        <label for="company_name_txt_drop">Add Terms and Conditions</label>
                                        <input type="text" class="form-control form-control-lg" id="company_name_txt_drop" placeholder="Enter Terms and Conditions">
                                        <span id="Service-status_company"></span>
                                    </div>
                                </div>
                            </div>

                        </form>
                        <button type="button" class="btn btn-vowel" name="add_company_name_drop_btn" id="add_company_name_drop_btn">Add</button>
                    </div>

                    <!-- Table -->
                    <div id="table-section" style="display:none;">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>s
                                    <th scope="col">Terms and Conditions</th>
                                    <th scope="col">Action</th> <!-- New column for delete button -->
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql = "SELECT position, tems_cond_name, id FROM temps_condi_retail_invoice order by position"; // Assuming there is an 'id' column to uniquely identify each row
                                $result = $con->query($sql);
                                if ($result->num_rows > 0) {
                                    $counter = 1;
                                    while ($row = $result->fetch_assoc()) {
                                        echo '<tr>
                                            <th scope="row">' . htmlspecialchars($row['position']) . '</th>
                                            <td>' . htmlspecialchars($row['tems_cond_name']) . '</td>
                                            <td>
                                                <button class="btn btn-danger btn-sm delete-btn" data-id="' . $row['id'] . '">Delete</button>
                                            </td>
                                        </tr>';
                                    }
                                } else {
                                    echo '<tr><td colspan="3">No records found.</td></tr>';
                                }
                                ?>
                            </tbody>

                        
                        </table>
                        
                        
                    </div>
                </div>
                <div class="modal-footer">
                    <!-- Toggle buttons -->
                    <button type="button" class="btn btn-primary" id="view-table-btn">View Records</button>
                    <button type="button" class="btn btn-primary" id="view-form-btn" style="display:none;">View Form</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                </div>
            </div>
        </div>
    </div>
        <script>
        $(document).ready(function() {
            // $('#serviceModal').DataTable();

            // When "View Records" is clicked, show the table and hide the form
            $("#view-table-btn").click(function() {
                $("#form-section").hide(); // Hide the form
                $("#table-section").show(); // Show the table
                $("#view-table-btn").hide(); // Hide the "View Records" button
                $("#view-form-btn").show(); // Show the "View Form" button
            });

            // When "View Form" is clicked, show the form and hide the table
            $("#view-form-btn").click(function() {
                $("#form-section").show(); // Show the form
                $("#table-section").hide(); // Hide the table
                $("#view-form-btn").hide(); // Hide the "View Form" button
                $("#view-table-btn").show(); // Show the "View Records" button
            });
        });
        $(document).ready(function() {
            // Handle Delete Button Click
            $(document).on('click', '.delete-btn', function() {
                var id = $(this).data('id'); // Get the ID of the record
                var row = $(this).closest('tr'); // Get the row element to remove after deletion
                
                // Confirm delete action
                if (confirm('Are you sure you want to delete this record?')) {
                    $.ajax({
                        url: 'html/ProcessRetailInvoice.php', // The server-side script that will handle deletion
                        type: 'POST',
                        data: { id: id },
                        success: function(response) {
                            if (response == 'success') {
                                // Remove the row from the table
                                row.remove();
                            } else {
                                alert('Failed to delete the record.');
                            }
                        },
                        error: function() {
                            alert('Error occurred while deleting.');
                        }
                    });
                }
            });
        });

    </script>
    <div id="searchRetailInvoiceDiv" class="table-responsive d-block"></div>
    <div id="showRetailInvoice" class="table-responsive d-block"></div>
    <div id="showClient" class="table-responsive d-none"></div>
    <div id="showClientWholeDetails" class="table-responsive d-block"></div>
    <div id="showGSTWholeDetails" class="table-responsive d-none"></div>
<script>
//     $('#ClientNameSelect1').on("change", function (e) { 
// 		var ClientNameSelect1 = $("#ClientNameSelect1").val();
// 		$.ajax({
//             url:"html/Processgst.php",
//             method:"post",
//             data: {ClientNameSelect1:ClientNameSelect1},
//             dataType:"text",
//             success:function(data)
//             {   
//                 var jsonData = JSON.parse(data);
//             	$("#gst_no").val(jsonData.gst_no);
//             	$("#gst_no_temp").val(jsonData.gst_no);
//             	$("#client_ID").val(jsonData.client_id);
//             }
//         });
// 	});
	
	$('#drawee').on("change", function (e) { 
		var drawee = $('.drawee').find(':selected').val();
		var drawee = $("#drawee").val();
		$.ajax({
			url:"html/fetch_Drawee_Id.php",
			method:"post",
			data: {drawee:drawee},
			dataType:"text",
			success:function(data)
			{
                $("#drawee_ID").val(data);
			}
		});
	});
</script>

    <!--Add nre Draweee-->
    	<div class="modal fade" data-backdrop="static" data-keyboard="false" id="addServiceModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
		  <div class="modal-content">
			<div class="modal-header">
			  <h5 class="modal-title" id="exampleModalLabel">Add New Drawee</h5>
			  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			  </button>
			</div>
			<div class="modal-body">
			  <form>
				<!--<div class="form-group">-->
				<!--  <label for="Servicetxt">Service</label>-->
				<!--  <input type="text" class="form-control form-control-lg" id="Servicetxt" placeholder="Enter Service">-->
				<!--  <span id="Service-status"></span>-->
				<!--</div>-->
				<div class="form-inline">
						  <div class="form-group d-block col-md-3">
							  <label for="ClientNameSelect1" class="float-left p-2">Name<span style="color: red;" class="pl-1">*</span></label>
							  <div class="d-block">
								  <input type="text" required name="name" class="form-control w-100" id="NameTxt" aria-describedby="emailHelp" placeholder="Enter Name" <?php if (isset($_POST['editOtherServicebtn'])) {
								  echo "value=" . $edit_date;
							  } ?>>
								  <input type="hidden" name="temp_client_name" id="temp_client_name" value="<?php if (isset($_POST['editOtherServicebtn'])) {
									  echo $edit_client_name;
								  } ?>" readonly>
							  </div>
						  </div>
						  <!--div class="form-group d-block col-md-3">
							  <label for="exampleInput1" class="float-left p-2">Recipient Name</label>
							  <input type="text" name="client_name" class="form-control w-100" id="exampleInput1" aria-describedby="emailHelp" placeholder="Enter Recipient Name" <?php //if (isset($_POST['editOtherServicebtn'])) {echo "value=".$edit_client_name;}?>>
						  </div-->
						  <div class="form-group d-block col-md-3">
							  <label for="date" class="float-left p-2">Address <span style="color: red;" class="pl-1">*</span></label>
							  <input type="text" required name="address" class="form-control w-100" id="AddressTxt" aria-describedby="emailHelp" placeholder="Enter Address" <?php if (isset($_POST['editOtherServicebtn'])) {
								  echo "value=" . $edit_date;
							  } ?>>
						  </div>
						  <div class="form-group d-block col-md-3">
							  <label for="city" class="float-left p-2">City</label>
							  <div class="d-block">
								  <input type="text" name="city" class="form-control w-100" id="CityTxt" aria-describedby="emailHelp" placeholder="Enter City" <?php if (isset($_POST['editOtherServicebtn'])) {
									  echo "value=" . $edit_city;
								  } ?>>
							  </div>
						  </div>
						  <div class="form-group d-block col-md-3">
							  <label for="applicant_name" class="float-left p-2">State <span style="color: red;" class="pl-1">*</span></label>
							  <input type="text" required class="form-control w-100" name="state" id="StateTxt" aria-describedby="emailHelp" placeholder="Enter State" value="<?php if (isset($_POST['editOtherServicebtn'])) {
								  echo $edit_applicant_name;
							  } ?>">
						  </div>
						  
					  </div>
					  <div class="form-inline">
						  <div class="form-group d-block col-md-3">
							  <label for="ClientNameSelect1" class="float-left p-2">Client Name <span style="color: red;"
									  class="pl-1">*</span></label>
							  <div class="d-block">
								  <select name="client_name" required class="form-control w-100 client_name"
									  style="width: 100%;" id="ClientNameTxt"
									  <?php if (isset($_POST['editGSTFeesbtn'])) { echo "disabled"; } ?>>
									  <?php
									 
										$fetch_Client = "SELECT `client_name` FROM `client_master` WHERE `company_id` = '".$_SESSION['company_id']."' ORDER BY `client_name` ASC";
										$run_fetch_Client = mysqli_query($con,$fetch_Client);
										while ($row = mysqli_fetch_array($run_fetch_Client)) { ?>
									  <option value="<?= $row['client_name']; ?>"
										  <?php if (isset($_POST['editGSTFeesbtn'])) { if ($edit_client_name == $row['client_name']) { echo "selected"; }}?>>
										  <?= $row['client_name']; ?></option>
									  <?php }
									?>
								  </select>
								  <input type="hidden" name="temp_client_name" id="temp_client_name"
									  value="<?php if (isset($_POST['editGSTFeesbtn'])) {  echo $edit_client_name; } ?>"
									  readonly>
							  </div>
						  </div>
						  <div class="form-group d-block col-md-3">
							  <label for="address" class="float-left p-2">Company name <span style="color: red;" class="pl-1">*</span></label>
							  <input type="text" required class="form-control w-100" name="c_name" id="CNameTxt" aria-describedby="emailHelp" placeholder="Enter Company name" value="<?php if (isset($_POST['editOtherServicebtn'])) {
								  echo $edit_applicant_name;
							  } ?>">
						  </div>
						  <div class="form-group d-block col-md-3">
							  <label for="applicant_mobile" class="float-left p-2">Mobile No<span style="color: red;" class="pl-1">*</span></label>
							  <input type="number" required oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="10" class="form-control w-100" name="applicant_mobile" id="ApplicantMobileTxt" aria-describedby="emailHelp" placeholder="Enter Mobile Number" <?php if (isset($_POST['editOtherServicebtn'])) {
								  echo "value=" . $edit_applicant_mobile;
							  } ?>>
							  <span id="mobile_number_status"></span>
						  </div>
						  <div class="form-group d-block col-md-3">
							  <label for="address" class="float-left p-2">Email <span style="color: red;" class="pl-1">*</span></label>
							  <input type="email" required class="form-control w-100" name="email" id="EmailTxt" aria-describedby="emailHelp" placeholder="Enter Email Id" value="<?php if (isset($_POST['editOtherServicebtn'])) {
								  echo $edit_applicant_name;
							  } ?>">
							  <span id="email_id_1_status"></span>
						  </div>
					  </div>
					  <div class="form-inline">
						  
						  <div class="form-group d-block col-md-3">
							  <label for="address" class="float-left p-2">Pincode <span style="color: red;" class="pl-1">*</span></label>
							  <input type="number" required class="form-control w-100" name="pin_code" id="PinCodeTxt" aria-describedby="emailHelp" placeholder="Enter Pincode" value="<?php if (isset($_POST['editOtherServicebtn'])) {
								  echo $edit_applicant_name;
							  } ?>">
						  </div>
						  
						  
						  <div class="form-group d-block col-md-3">
							  <label for="pin_code" class="float-left p-2">GST</label>
							  <div class="d-block">
								  <input type="text" name="gst" class="form-control w-100" id="GSTTxt" aria-describedby="emailHelp" placeholder="Enter GST No" value="<?php if (isset($_POST['editOtherServicebtn'])) {
									  echo $edit_pin_code;
								  } ?>">
							  </div>
							  
						  </div>
						  
					  </div>
					  
					  
					  <br>
					  <div class="form-inline">
						  <div class="form-group d-block col-md-3">
							  <span style="color: red;" class="pl-1">Note : * fields are mandatory</span>
						  </div>
					  </div>
			  </form>
			</div>
			<div class="modal-footer">
			  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			  <button type="button" class="btn btn-vowel" name="add_Service" id="add_Service">Add</button>
			</div>
		  </div>
		</div>
	  </div>

    <!--Add File Confirm Popup-->
    <div class="modal fade" data-backdrop="static" data-keyboard="false" id="fileConfirmMessagePopup" tabindex="-1"
        role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form method="post">
                    <div class="modal-header">
                        <img src="<?php echo $main_company_logo; ?>" alt="Vowel" style="width: 150px; height: 55px;"
                            class="logo navbar-brand mr-auto">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body bg-light">
                        <form method="post" enctype="multipart/form-data">
                            <input type="hidden" id="fileFor">
                            <input type="button" id="gstr_1fileUpload" name="gstr_1fileUpload"
                                class="btn btn-vowel d-none" value="Choose file"
                                onclick="document.getElementById('gstr_1File').click()">
                            <input type="button" id="gstr_3bfileUpload" name="gstr_3bfileUpload"
                                class="btn btn-vowel d-none" value="Choose file"
                                onclick="document.getElementById('gstr_3bFile').click()">
                            <input type="button" id="trans_1fileUpload" name="trans_1fileUpload"
                                class="btn btn-vowel d-none" value="Choose file"
                                onclick="document.getElementById('trans_1File').click()">
                            <input type="button" id="trans_6fileUpload" name="trans_6fileUpload"
                                class="btn btn-vowel d-none" value="Choose file"
                                onclick="document.getElementById('trans_6File').click()">
                            <input type="button" id="gstr_2a_recofileUpload" name="gstr_2a_recofileUpload"
                                class="btn btn-vowel d-none" value="Choose file"
                                onclick="document.getElementById('gstr_2a_recoFile').click()">
                            <input type="button" id="trans_4fileUpload" name="trans_4fileUpload"
                                class="btn btn-vowel d-none" value="Choose file"
                                onclick="document.getElementById('trans_4File').click()">
                            <p id="tempFileName"></p>
                        </form>
                        <span id="fileUpload-status"></span>
                        <?php echo "<p id='comfirmMsg' class='d-block'>Do you want to upload file?</p>"; ?>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" id="filemodalCloseBtn"
                            data-dismiss="modal">NO</button>
                        <button type="button" name="gst_file_upload_yesBtn" id="gst_file_upload_yesBtn"
                            class="btn btn-vowel">YES</button>
                        <button type="button" name="gstr_1_file_uploadBtn" id="gstr_1_file_uploadBtn"
                            class="btn btn-vowel d-none">UPLOAD</button>
                        <button type="button" name="gstr_3b_file_uploadBtn" id="gstr_3b_file_uploadBtn"
                            class="btn btn-vowel d-none">UPLOAD</button>
                        <button type="button" name="trans_1_file_uploadBtn" id="trans_1_file_uploadBtn"
                            class="btn btn-vowel d-none">UPLOAD</button>
                        <button type="button" name="trans_6_file_uploadBtn" id="trans_6_file_uploadBtn"
                            class="btn btn-vowel d-none">UPLOAD</button>
                        <button type="button" name="gstr_2a_reco_file_uploadBtn" id="gstr_2a_reco_file_uploadBtn"
                            class="btn btn-vowel d-none">UPLOAD</button>
                        <button type="button" name="trans_4_file_uploadBtn" id="trans_4_file_uploadBtn"
                            class="btn btn-vowel d-none">UPLOAD</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--Delete Confirm Popup-->
    <div class="modal fade" data-backdrop="static" data-keyboard="false" id="gstConfirmMessagePopup" tabindex="-1"
        role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form method="post">
                    <div class="modal-header">
                        <img src="<?php echo $main_company_logo; ?>" alt="Vowel" style="width: 150px; height: 55px;"
                            class="logo navbar-brand mr-auto">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body bg-light">
                        <input type="hidden" readonly id="tempGSTIDdel" name="tempGSTIDdel" class="tempGSTIDdel">
                        <?php echo "<p>Do You Really Want To Delete This Record ?</p>"; ?>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">NO</button>
                        <button type="submit" name="gstFees_delete" id="gstFees_delete"
                            class="btn btn-vowel">YES</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!--Remove File Popup-->
    <div class="modal fade" data-backdrop="static" data-keyboard="false" id="gstFileRemoveConfirmMessagePopup"
        tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form method="post">
                    <div class="modal-header">
                        <img src="<?php echo $main_company_logo; ?>" alt="Vowel" style="width: 150px; height: 55px;"
                            class="logo navbar-brand mr-auto">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body bg-light">
                        <input type="hidden" id="tempAuditIDfile" name="tempAuditIDfile" class="tempAuditIDfile">
                        <?php echo "<p>Do You Really Want To Remove This File ?</p>"; ?>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">NO</button>
                        <button type="button" class="btn btn-vowel d-none" id="gstr_1closeFileNameBtn">Yes, Remove
                            It</button>
                        <button type="button" class="btn btn-vowel d-none" id="gstr_3bcloseFileNameBtn">Yes, Remove
                            It</button>
                        <button type="button" class="btn btn-vowel d-none" id="trans_1closeFileNameBtn">Yes, Remove
                            It</button>
                        <button type="button" class="btn btn-vowel d-none" id="trans_6closeFileNameBtn">Yes, Remove
                            It</button>
                        <button type="button" class="btn btn-vowel d-none" id="gstr_2a_recocloseFileNameBtn">Yes, Remove
                            It</button>
                        <button type="button" class="btn btn-vowel d-none" id="trans_4closeFileNameBtn">Yes, Remove
                            It</button>
                        <!--button type="submit" name="audit_delete" id="audit_delete" class="btn btn-vowel">YES</button-->
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!--Drawee Modal-->
    
   <script type="text/javascript">
		
		$(document).ready(function () {
		
		
		let MobileNumberCorrect = false;
			let EmailIdCorrect = false;
			// Check mobile to exist or not
			function CheckMobileNumberExist() {
				let ApplicantMobileTxt = $('#ApplicantMobileTxt').val();
				var other_serviceEditID_temp = $("#other_serviceEditID_temp").val();
				// alert(client_masterEditID_temp);
				$.ajax({
					url: "html/ProcessDrawee.php",
					method: "post",
					data: {
						ApplicantMobileTxt,
						other_serviceEditID_temp
					},
					dataType: "text",
					success: function(data) {
						// alert(data);
						if (data == "Mobile_No_exist") {
							MobileNumberCorrect = false;
							$('#ApplicantMobileTxt').addClass('border-danger');
							$('#mobile_number_status').html('This Mobile Number already exist').css(
								'color', 'red');
			                $('#add_Service').prop('disabled', true);

						} else {
							MobileNumberCorrect = true;
							$('#ApplicantMobileTxt').removeClass('border-danger');
							$('#mobile_number_status').html('').css('color', 'green');
							$('#add_Service').prop('disabled', false);
						}
					}
				});
			}
			
			$('#ApplicantMobileTxt').blur(function() {
				CheckMobileNumberExist();
			});
			function toTitleCase(str) {
            return str.replace(/\w\S*/g, function(txt) {
                return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
            });
        }

        $('#add_company_name_drop_btn').click(function() {
            // console.log('Button Clicked!'); // Check if the click event is firing
            // alert()
            var serviceValue = toTitleCase($('#company_name_txt_drop').val().toLowerCase());
            var position_number = toTitleCase($('#position_number_txt_drop').val().toLowerCase());
            // console.log('Service Value:', serviceValue); // Check the serviceValue
            // alert(position_number);
            // alert(serviceValue);
            // if (serviceValue === "") {
            //     alert('Input field is empty');
            // } else {
            //     // alert(serviceValue); // Check if the alert is firing
            // }

            if (serviceValue === "") {
                $('#Service-status_company').html('Please Fill This Field!').css({
                    'color': 'red'
                });
                $('#company_name_txt_drop').addClass("border border-danger");
            } else if (serviceValue.includes("(") || serviceValue.includes(")")) {
                $('#Service-status_company').html('Please Use [ ] Instead of ( )').css({
                    'color': 'red'
                });
                $('#company_name_txt_drop').addClass("border border-danger");
            }

            if (serviceValue !== "" && !serviceValue.includes("(") && !serviceValue.includes(")")) {
                // $('#pleaseWaitDialog').modal('show');

                $.ajax({
                    url: "html/ProcessRetailInvoice.php",
                    method: "POST",
                    data: {
                        send_temps_cond: serviceValue,
                        position_number: position_number
                    },
                    dataType: "text",
                    success: function(data) {
                        if (data == "service_ok") {
                            $('#Service-status_company').html("Possition Already Available").css({
                                'color': 'green'
                            });
                            $('#position_number_txt_drop').removeClass("border border-danger");
                            $('#company_name_drop').append(new Option(serviceValue, serviceValue));
                            $("#addComapny_name_Modal .close").click();
                            $('#company_name_txt_drop').val(serviceValue);
                        } else if (data == "service_taken") {
                            $('#Service-status_company').html("Possition Already Available").css({
                                'color': 'red'
                            });
                            $('#position_number_txt_drop').addClass("border border-danger");
                        }
                    },
                    complete: function() {
                        $('#pleaseWaitDialog').modal('hide');
                    }
                });
            }
        });
			
			$('#EmailTxt').blur(function() {
				CheckEmailIdExist();
			});
			
			
			function CheckEmailIdExist() {
				let email_id_1 = $('#EmailTxt').val();
				var other_serviceEditID_temp = $("#other_serviceEditID_temp").val();
				// alert(email_id_1);
				$.ajax({
					url: "html/ProcessDrawee.php",
					method: "post",
					data: {
						email_id_1,
						other_serviceEditID_temp
					},
					dataType: "text",
					success: function(data) {
						// alert(data);
						if (data == "Email_exist") {
							EmailIdCorrect = false;
							$('#EmailTxt').addClass('border-danger');
							$('#email_id_1_status').html('This Email Id already exist').css(
								'color', 'red');
							$('#add_Service').prop('disabled', true);
						} else {
							EmailIdCorrect = true;
							$('#EmailTxt').removeClass('border-danger');
							$('#email_id_1_status').html('').css('color', 'green');
							$('#add_Service').prop('disabled', false);
						}
					}
				});
			}
		$('#add_Service').click(function(){
			var nameValue = $('#NameTxt').val();
			var addressValue = $('#AddressTxt').val();
			var cityValue = $('#CityTxt').val();
			var stateValue = $('#StateTxt').val();
			var clientNameValue = $('#ClientNameTxt').val();
			var cNameValue = $('#CNameTxt').val();
			var applicantMobileValue = $('#ApplicantMobileTxt').val();
			var emailValue = $('#EmailTxt').val();
			var pinCodeValue = $('#PinCodeTxt').val();
			var gstValue = $('#GSTTxt').val();
			console.log("addressValue: ", addressValue);
			
			var ClientNameSelect1 = $("#ClientNameSelect1").val();

		  //  alert("vcesa");
// 			alert(ClientNameSelect1);
			
			if (nameValue == "") {
				$('#Name-status').html('Please Fill This Field!').css({'color':'red'});
				$('#NameTxt').addClass("border border-danger");
				
			} else if (nameValue.includes("(") || nameValue.includes(")")) {
				$('#Name-status').html('Please Use [ ] Instead of ( )').css({'color':'red'});
				$('#NameTxt').addClass("border border-danger");
			}
			
			// Similar checks for other fields...
		
// 			if (nameValue != "" && !nameValue.includes("(") && !nameValue.includes(")") &&
// 				addressValue != "" && cityValue != "" && stateValue != "" && clientNameValue != "" &&
// 				cNameValue != "" && applicantMobileValue != "" && emailValue != "" && pinCodeValue != "" && gstValue != "") {
				
				// $('#pleaseWaitDialog').modal('show');
		
				$.ajax({
					url: "html/ProcessAdd_Drawee.php",
					method: "post",
					data: {
						send_Name: nameValue,
						send_Address: addressValue,
						send_City: cityValue,
						send_State: stateValue,
						send_ClientName: clientNameValue,
						send_CName: cNameValue,
						send_ApplicantMobile: applicantMobileValue,
						send_Email: emailValue,
						send_PinCode: pinCodeValue,
						send_GST: gstValue
					},
					dataType: "text",
					success: function(data) {
						if (data == "client_ok") {
							
							// Additional logic for updating UI or other elements...
							$("#addServiceModal .close").click();
							$('#NameTxt, #AddressTxt, #CityTxt, #StateTxt, #ClientNameTxt, #CNameTxt, #ApplicantMobileTxt, #EmailTxt, #PinCodeTxt, #GSTTxt').val("");
							$('#Service-status').html("Drawee Added Successfully").css({ 'color': 'green' });
							$('#drawee').append(new Option(nameValue, nameValue));
							// Clearing or resetting the input fields...
							$('#drawee').val(nameValue);
						} else if (data == "client_taken") {
							$('#Name-status').html("Client Already Exist..!").css({'color':'red'});
							$('#NameTxt').addClass("border border-danger");
						}
					},
					complete: function() {
						$('#pleaseWaitDialog').modal('hide');
					}
				});
// 			}
		});
});
	</script>
    <script type="text/javascript">
    $(".client_name").select2();
    // $(".client_name").select2();
    

    var checkedVal = [];
    var MultipleServiceID = [];
    
    let taxInvoiceCorrect = false;
    $('#invoice_number').blur(function() {
        let invoice_number = $('#invoice_number').val();
        $.ajax({
            url: "html/ProcessRetailInvoice.php",
            method: "post",
            data: {
                invoice_number
            },
            dataType: "text",
            success: function(data) {
                // alert(data);
                if (data == "retail_invoice_exist") {
                    taxInvoiceCorrect = false;
                    $('#invoice_number').addClass('border-danger');
                    $('#invoice_number_status').html('This Invoice Number already exist').css(
                        'color', 'red');
                } else {
                    taxInvoiceCorrect = true;
                    $('#invoice_number').removeClass('border-danger');
                    $('#invoice_number_status').html('').css('color', 'green');
                    // $('#temp_RetailInvoice_save').click();
                }
            }
        });
    });

    var gst_type = $("#gst_type").val();
    if (gst_type == 'IGST') {
        $('#igst_DIV').removeClass('d-none');
        $('#igst_DIV').addClass('d-block');
        $('#tax_igst_DIV').removeClass('d-none');
        $('#tax_igst_DIV').addClass('d-block');
        $('#igst').prop('required', true);
        $('#igst').val('');
        $('#tax_igst').val('');
        $('#cgst_sgst_DIV').removeClass('d-block');
        $('#cgst_sgst_DIV').addClass('d-none');
        $('#tax_cgst_sgst_DIV').removeClass('d-block');
        $('#tax_cgst_sgst_DIV').addClass('d-none');
        $('#cgst').prop('required', false);
        $('#sgst').prop('required', false);
        $('#cgst').val('');
        $('#sgst').val('');
        $('#tax_cgst').val('');
        $('#tax_sgst').val('');
    } else {
        $('#igst_DIV').removeClass('d-block');
        $('#igst_DIV').addClass('d-none');
        $('#tax_igst_DIV').removeClass('d-block');
        $('#tax_igst_DIV').addClass('d-none');
        $('#igst').prop('required', false);
        $('#igst').val('');
        $('#cgst_sgst_DIV').removeClass('d-none');
        $('#cgst_sgst_DIV').addClass('d-block');
        $('#tax_cgst_sgst_DIV').removeClass('d-none');
        $('#tax_cgst_sgst_DIV').addClass('d-block');
        $('#cgst').prop('required', true);
        $('#sgst').prop('required', true);
        $('#cgst').val('');
        $('#sgst').val('');
    }

    function resetAllFields() {
        $('#temp_tax_cgst').val('');
        $('#temp_tax_sgst').val('');
        $('#temp_tax_igst').val('');
        $('#tax_cgst').val('');
        $('#tax_sgst').val('');
        $('#tax_igst').val('');
        $('#totalValue').val('');
        $('#temp_totalValue').val('');
        $('#temp_roundOff').val('');
        $('#roundOff').val('');
    }

    function resetServiceId() {
        $('#temp_serviceIds').val('');
        $('#serviceIds').val('');
        $('#temp_TotalAmount').val('');
        $('#TotalAmount').val('');
        checkedVal = [];
        MultipleServiceID = [];
    }
    $('#addServiceModal').on('hidden.bs.modal', function () {
            //$(this).find('form').trigger('reset');
            $('#Servicetxt').val('');
            $('#Service-status').html("").css({'color':'green'});
            $('#Servicetxt').removeClass("border border-danger");
        });

    function calculateGSTRetail() {
        let temp_totalValue = $('#temp_totalValue').val();
        resetAllFields();
        if (temp_totalValue != '') {
                let totalAmount = parseFloat(temp_totalValue).toFixed(2);
                let roundOffValue = (parseInt(totalAmount.toString().split(".")[1]) > 50) ? Math.ceil(totalAmount) :
                    Math.floor(totalAmount);
                $('#totalValue').val(totalAmount);
                $('#temp_totalValue').val(totalAmount);
                $('#temp_roundOff').val(roundOffValue);
                $('#roundOff').val(roundOffValue);

                /* $('#totalValue').val((parseFloat(temp_TotalAmount) + (parseFloat(igst)*parseFloat(temp_TotalAmount))/100).toFixed(2));
                $('#temp_totalValue').val((parseFloat(temp_TotalAmount) + (parseFloat(igst)*parseFloat(temp_TotalAmount))/100).toFixed(2));
                $('#temp_roundOff').val(ceil(parseFloat(temp_TotalAmount) + (parseFloat(igst)*parseFloat(temp_TotalAmount))/100).toFixed(2));
                $('#roundOff').val(ceil(parseFloat(temp_TotalAmount) + (parseFloat(igst)*parseFloat(temp_TotalAmount))/100).toFixed(2)); */
            // }
            // if (cgst != '' && sgst != '') {
                /* let totalAmount = (parseFloat(temp_TotalAmount) + (parseFloat(cgst) * parseFloat(temp_TotalAmount)) /
                    100 + (parseFloat(sgst) * parseFloat(temp_TotalAmount)) / 100).toFixed(2);
                let roundOffValue = (parseInt(totalAmount.toString().split(".")[1]) > 50) ? Math.ceil(totalAmount) :
                    Math.floor(totalAmount);
                $('#totalValue').val(totalAmount);
                $('#temp_totalValue').val(totalAmount);
                $('#temp_roundOff').val(roundOffValue);
                $('#roundOff').val(roundOffValue); */
            // }
        }
    }
    $('#cgst').on("keyup", function(e) {
        calculateGSTRetail();
    });
    $('#sgst').on("keyup", function(e) {
        calculateGSTRetail();
    });
    $('#igst').on("keyup", function(e) {
        calculateGSTRetail();
    });
    $('#gst_type').on("change", function(e) {
        var gst_type = $("#gst_type").val();
        $('#igst').val('');
        $('#cgst').val('');
        $('#sgst').val('');
        resetAllFields();
        if (gst_type == 'IGST') {
            $('#igst_DIV').removeClass('d-none');
            $('#igst_DIV').addClass('d-block');
            $('#tax_igst_DIV').removeClass('d-none');
            $('#tax_igst_DIV').addClass('d-block');
            $('#igst').prop('required', true);
            $('#cgst_sgst_DIV').removeClass('d-block');
            $('#cgst_sgst_DIV').addClass('d-none');
            $('#tax_cgst_sgst_DIV').removeClass('d-block');
            $('#tax_cgst_sgst_DIV').addClass('d-none');
            $('#cgst').prop('required', false);
            $('#sgst').prop('required', false);
        } else {
            $('#igst_DIV').removeClass('d-block');
            $('#igst_DIV').addClass('d-none');
            $('#tax_igst_DIV').removeClass('d-block');
            $('#tax_igst_DIV').addClass('d-none');
            $('#igst').prop('required', false);
            $('#cgst_sgst_DIV').removeClass('d-none');
            $('#cgst_sgst_DIV').addClass('d-block');
            $('#tax_cgst_sgst_DIV').removeClass('d-none');
            $('#tax_cgst_sgst_DIV').addClass('d-block');
            $('#cgst').prop('required', true);
            $('#sgst').prop('required', true);
        }
    });
    $('#ClientNameSelect1').on("change", function(e) {
        var ClientNameSelect1 = $("#ClientNameSelect1").val();
        
        $('#igst').val('');
        $('#cgst').val('');
        $('#sgst').val('');
        resetAllFields();
        resetServiceId();
        $.ajax({
            url: "html/Processgst.php",
            method: "post",
            data: {
                ClientNameSelect1: ClientNameSelect1
            },
            dataType: "text",
            success: function(data) {
                // alert(data);
                var jsonData = JSON.parse(data);
            	$("#gst_no").val(jsonData.gst_no);
            	$("#gst_no_temp").val(jsonData.gst_no);
            	$("#client_ID").val(jsonData.client_id);
                // $('#client_name').change(function(){
                /* $('#service_id').val('');
                if ($('#temp_category').val() == 'Suspense') {
                    $('#service_id').val('ADV_PMT');
                } */

                // $('#amount_creditedIn').val('CASH');
                var client_name = $('#ClientNameSelect1').val();
                var Client_id=$('#client_ID').val();
                // alert(Client_id);
                if (client_name != "") {
                    // $('#pleaseWaitDialog').modal('show');
                    // alert(client_name);
                    $.ajax({
                        url: "html/ProcessRetailInvoice.php",
                        method: "post",
                        data: {
                            client_name: client_name,
                            Client_id:Client_id
                        },
                        dataType: "text",
                        success: function(data) {
                            // alert(data);
                            // $('#clientTransaction_dataDIV').removeClass('d-none');
                            // $('#clientTransaction_dataDIV').addClass('d-block');
                            // $('#clientTransactionTable').html(data);
                            var array = JSON.parse(data);
                            // alert(array[3]);
                            if (array[0] !=
                                "<tr style='text-align:center;'><td colspan='4'>No Record Found!</td></tr>"
                            ) {
                                $('#clientTransaction_dataDIV').removeClass('d-none');
                                $('#clientTransaction_dataDIV').addClass('d-block');
                                $('#clientTransactionTable').html(array[0]);
                                $('#clientTransactionTable').DataTable({
                                    pagingType: "full_numbers",
                                    "bDestroy": true,
                                    "order": [
                                        [1, "DESC"]
                                    ]
                                });
                                // $('#pendingAmountMainPara').removeClass('d-none');
                                // $('#pendingAmountMainPara').addClass('d-block');
                                $('#pendingAmount').html('Pending Amount : ' + array[1]
                                    .toFixed(2)).css({
                                    'color': 'red',
                                    'font-size': '16px'
                                });
                                $('#advanceAmount').html('Advance Amount : ' + array[3])
                                    .css({
                                        'color': 'red',
                                        'font-size': '16px'
                                    });
                                $('#TextadvanceAmount').val(array[3]);
                            } else {
                                $('#clientTransaction_dataDIV').removeClass('d-none');
                                $('#clientTransaction_dataDIV').addClass('d-block');
                            
                                // Clear table and destroy DataTable if initialized
                                if ($.fn.DataTable.isDataTable('#clientTransactionTable')) {
                                    $('#clientTransactionTable').DataTable().clear().destroy();
                                }
                                $('#clientTransactionTable tbody').empty(); // Clear any existing rows
                                $('#clientTransactionTable').html(array[0]); // Set "No Record Found!" message
                            
                                // Clear pending and advance amounts
                                $('#pendingAmorunt').html('');
                                $('#advanceAmount').html('');
                            }
                        },
                        complete: function() {
                            //$("#wait").css("display", "none");
                            $('#pleaseWaitDialog').modal('hide');
                        }
                    });
                } else {
                    $('#clientTransaction_dataDIV').removeClass('d-block');
                    $('#clientTransaction_dataDIV').addClass('d-none');
                    $('#clientTransactionTable').html('');
                }
                // });
            }
        });
    });


$('#ClientNameSelect1').on("change", function (e) {
    var ClientNameSelect1 = $("#ClientNameSelect1").val();
    // $('#pleaseWaitDialog').modal('show');

    $.ajax({
        url: "html/fetch_draweer.php",
        method: "post",
        data: { ClientNameSelect1: ClientNameSelect1 },
        dataType: "text",
        success: function (data) {
            var array = JSON.parse(data);
            $('#drawee').empty();
            for (var i = 0; i < array.length; i++) {
                $('#drawee').append(new Option(array[i], array[i]));
            }

            $('#Drawee_id').val(data);
        },
        complete: function () {
            var drawee = $("#drawee").val();
            let parts = drawee.split("_");
            let result = parts[0];
            // alert(drawee);

            $.ajax({
                url: "html/fetch_drawee_company_name.php",
                method: "post",
                data: { drawee: drawee },
                dataType: "text",
                success: function (data) {
                    $('#c_name').empty();
                    $('#c_name').val(data); // Use .html() to set content in a div
                },
                complete: function () {
                    var ClientNameSelect1 = $("#ClientNameSelect1").val();
                    $.ajax({
                        url: "html/fetch_cc_name.php",
                        method: "post",
                        data: { ClientNameSelect1: ClientNameSelect1 }, // Provide a value here
                        dataType: "text",
                        success: function (data) {
                            $('#cc_name').empty();
                            $('#c_name').empty();
                            $('#cc_name').val(data); // Use .html() to set content in a div
                        }
                    });
                },
                complete:function(){
                    var drawee = $('.drawee').find(':selected').val();
            		var drawee = $("#drawee").val();
            		$.ajax({
            			url:"html/fetch_Drawee_Id.php",
            			method:"post",
            			data: {drawee:drawee},
            			dataType:"text",
            			success:function(data)
            			{
                            $("#drawee_ID").val(data);
            			}
            		});
                },
            });
        }
    });
});


$('#ClientNameSelect1').on("change",function(e){
    // var ClientNameSelect1 = $('.ClientNameSelect1').find(':selected').val();
    var ClientNameSelect1 = $("#ClientNameSelect1").val();
    
    // let originalString = "SHUBHAM_11";

    
    // var result=$("#drawee").val();
    // alert(ClientNameSelect1);
    
// 		$('#pleaseWaitDialog').modal('show');
// 		var ClientNameSelect1 = $("#ClientNameSelect1").val();
// 		alert(drawee);
		$.ajax({
			url:"html/fetch_cc_name.php",
			method:"post",
			data: {ClientNameSelect1:ClientNameSelect1},
			dataType:"text",
			success:function(data)
			{
				// var array = data.split(',');
				// var array = JSON.parse(data);//data.split(',');
				// $('#c_name').empty();
				// for(var i=0; i<array.length;i++){
    //                 $('#c_name').append(new Option(array[i], array[i]));
    //             }
    	        $('#cc_name').empty();
    	        $('#c_name').empty();
				$("#cc_name").val(data);
			}
});
});

$('#add_Service').on("change",function(e){
    var ClientNameSelect1 = $("#ClientNameSelect1").val();
    
    // let originalString = "SHUBHAM_11";

    
    // var result=$("#drawee").val();
    // alert(ClientNameSelect1);
    
// 		$('#pleaseWaitDialog').modal('show');
// 		var ClientNameSelect1 = $("#ClientNameSelect1").val();
// 		alert(drawee);
		$.ajax({
			url:"html/fetch_cc_name.php",
			method:"post",
			data: {ClientNameSelect1:ClientNameSelect1},
			dataType:"text",
			success:function(data)
			{
				// var array = data.split(',');
				// var array = JSON.parse(data);//data.split(',');
				// $('#c_name').empty();
				// for(var i=0; i<array.length;i++){
    //                 $('#c_name').append(new Option(array[i], array[i]));
    //             }
    	        $('#cc_name').empty();
    	        $('#c_name').empty();
				$("#cc_name").val(data);
			}
});
})

$('#drawee').on("change",function(e){
    // var ClientNameSelect1 = $('.ClientNameSelect1').find(':selected').val();
    var drawee = $("#drawee").val();
    
    // let originalString = "SHUBHAM_11";
    let parts = drawee.split("_");
    let result = parts[0];
    
    // var result=$("#drawee").val();
    // alert(drawee);
    var id=$('#Drawee_id').val();
// 		$('#pleaseWaitDialog').modal('show');
// 		var ClientNameSelect1 = $("#ClientNameSelect1").val();
// 		alert(drawee);
		$.ajax({
			url:"html/fetch_drawee_company_name.php",
			method:"post",
			data: {drawee:drawee},
			dataType:"text",
			success:function(data)
			{
				// var array = data.split(',');
				// var array = JSON.parse(data);//data.split(',');
				// $('#c_name').empty();
				// for(var i=0; i<array.length;i++){
    //                 $('#c_name').append(new Option(array[i], array[i]));
    //             }
    	        $('#c_name').empty();
    	        $('#c_name').empty();
				$("#c_name").val(data);
			}
});
});

    $(document).ready(function() {
        // To Remove element from array  
        Array.prototype.remove = function(v) {
            this.splice(this.indexOf(v) == -1 ? this.length : this.indexOf(v), 1);
        }

        $(document).on('click', '#clientTransactionTable tbody tr #addThisService', function(e) {
            // alert('roks');
            // alert($(this).find('#thisSeviceId').val());

            let totalValue = ($('#totalValue').val() > 0) ? $('#totalValue').val() : 0;
            if ($(this).prop("checked") == true) {
                // $.each($("input[name='addThisService']:checked"), function(){
                // alert($('#addThisService').is(":checked"));
                // if($('#addThisService').is(":checked")){
                checkedVal.push($(this).val());
                var row_indexDEL = $(this).closest('tr');
                MultipleServiceID.push(row_indexDEL.find('#thisSeviceId').val());
                totalValue = (parseFloat(totalValue) + parseFloat(row_indexDEL.find('#thisAmount')
                    .val().replace(/,/g, ''))).toFixed(2);
                // }
                $('#temp_serviceIds').val(MultipleServiceID);
                $('#serviceIds').val(MultipleServiceID);
                $('#temp_totalValue').val(totalValue);
                $('#totalValue').val(totalValue);
            } else {
                // var checkedVal = [];
                // var MultipleServiceID = [];
                // let totalValue = 0;
                // $.each($("input[name='addThisService']:checked"), function(){
                checkedVal.remove($(this).val());
                var row_indexDEL = $(this).closest('tr');
                MultipleServiceID.remove(row_indexDEL.find('#thisSeviceId').val());
                totalValue = (parseFloat(totalValue) - parseFloat(row_indexDEL.find('#thisAmount')
                    .val().replace(/,/g, ''))).toFixed(2);
                // });
                $('#temp_serviceIds').val(MultipleServiceID);
                $('#serviceIds').val(MultipleServiceID);
                $('#temp_totalValue').val(totalValue);
                $('#totalValue').val(totalValue);
            }
            $('#service_id').val($(this).closest('tr').find('#thisSeviceId').val());
            // $('#amount_creditedIn').val('CASH');
            $('#amount').prop('max', $(this).closest('tr').find('#thisAmount').val().replace(/,/g, ''));
            calculateGSTRetail();
        });

        // var client_name = $('#ClientNameSelect1').val();
        // if (client_name != "") {
        //     // $('#pleaseWaitDialog').modal('show');
        //     // alert(client_name);
        //     resetAllFields();
        //     resetServiceId();
        //     $.ajax({
        //         url: "html/ProcessRetailInvoice.php",
        //         method: "post",
        //         data: {
        //             client_name: client_name
        //         },
        //         dataType: "text",
        //         success: function(data) {
        //             // alert(data);
        //             // $('#clientTransaction_dataDIV').removeClass('d-none');
        //             // $('#clientTransaction_dataDIV').addClass('d-block');
        //             // $('#clientTransactionTable').html(data);
        //             var array = JSON.parse(data);
        //             // alert(array[3]);
        //             if (array[0] !=
        //                 "<tr style='text-align:center;'><td colspan='4'>No Record Found!</td></tr>"
        //             ) {
        //                 $('#clientTransaction_dataDIV').removeClass('d-none');
        //                 $('#clientTransaction_dataDIV').addClass('d-block');
        //                 $('#clientTransactionTable').html(array[0]);
        //                 $('#clientTransactionTable').DataTable({
        //                     pagingType: "full_numbers",
        //                     "bDestroy": true,
        //                     "order": [
        //                         [1, "DESC"]
        //                     ]
        //                 });
        //                 // $('#pendingAmountMainPara').removeClass('d-none');
        //                 // $('#pendingAmountMainPara').addClass('d-block');
        //                 $('#pendingAmount').html('Pending Amount : ' + array[1].toFixed(2)).css({
        //                     'color': 'red',
        //                     'font-size': '16px'
        //                 });
        //                 $('#advanceAmount').html('Advance Amount : ' + array[3]).css({
        //                     'color': 'red',
        //                     'font-size': '16px'
        //                 });
        //                 $('#TextadvanceAmount').val(array[3]);
        //             } else {
        //                 $('#clientTransaction_dataDIV').removeClass('d-none');
        //                 $('#clientTransaction_dataDIV').addClass('d-block');
        //                 $('#clientTransactionTable').html(array[0]);
        //                 // $('#pendingAmountMainPara').removeClass('d-block');
        //                 // $('#pendingAmountMainPara').addClass('d-none');
        //                 $('#pendingAmount').html('');
        //                 $('#advanceAmount').html('');
        //             }
        //         },
        //         complete: function() {
        //             //$("#wait").css("display", "none");
        //             $('#pleaseWaitDialog').modal('hide');
        //             // $('#clientTransactionTable tbody tr').on('click', function(){
        //             $('#clientTransactionTable tbody tr #selctionServiceIdBtn').on('click',
        //                 function() {
        //                     // alert('roks');
        //                     // alert($(this).find('#thisSeviceId').val());
        //                     // alert($(this).closest('tr').find('#thisAmount').val().replace(/,/g, ''));
        //                     $('#service_id').val($(this).closest('tr').find('#thisSeviceId')
        //                         .val());
        //                     // $('#amount_creditedIn').val('CASH');
        //                     $('#amount').prop('max', $(this).closest('tr').find('#thisAmount')
        //                         .val().replace(/,/g, ''));
        //                     $('#tempAdv_amount').prop('value', ($('#Original_amount').val()) - (
        //                         $(this).closest('tr').find('#thisAmount').val().replace(
        //                             /,/g, '')));
        //                     $('#amount').prop('value', $(this).closest('tr').find('#thisAmount')
        //                         .val().replace(/,/g, ''));
        //                     $('#temp_amount').prop('value', $(this).closest('tr').find(
        //                         '#thisAmount').val().replace(/,/g, ''));
        //                 });
        //         }
        //     });
        // } else {
        //     $('#clientTransaction_dataDIV').removeClass('d-block');
        //     $('#clientTransaction_dataDIV').addClass('d-none');
        //     $('#clientTransactionTable').html('');
        // }

        $('#consulting_fees').prop('max', $("#fees").val());
        $("#fees").change(function() {
            $('#consulting_fees').prop('max', $("#fees").val());
        });
        $("#update_income").hide();
        $('#searchRetailInvoiceDiv').hide();
        $('#showRetailInvoice').load('html/RetailInvoice_DataList.php').fadeIn("slow");
        $('#showClient').load('html/ClientList.php').fadeIn("slow");

        if ($("#gstEditID_temp").val() != "") {
            $("#showRetailInvoice").removeClass("d-block");
            $("#showRetailInvoice").addClass("d-none");
            $("#showClient").removeClass("d-block");
            $("#showClient").addClass("d-none");
            $("#showClientWholeDetails").removeClass("d-block");
            $("#showClientWholeDetails").addClass("d-none");
            $("#showGSTWholeDetails").removeClass("d-block");
            $("#showGSTWholeDetails").addClass("d-none");
            $("#import_RetailInvoice").removeClass("d-block");
            $("#import_RetailInvoice").addClass("d-none");

            $("#addNew_RetailInvoice").removeClass("d-none");
            $("#addNew_RetailInvoice").addClass("d-block");
            $('#Export_RetailInvoiceForm').attr('action', 'Export_RetailInvoice');
            $("#export_RetailInvoice").prop("name", "Export_RetailInvoice");
            $("#pageHeading").html("Retail Invoice Transaction");

            var selectedService = $("#PaymentModeSelect1").children("option:selected").val();
            if (selectedService == "Bank Online") {
                $("#payment_descriptionDIV").removeClass("d-none");
                $("#payment_descriptionDIV").addClass("d-block");
                //$('#amount').val('');
                $('#amount').prop('readonly', false);
            } else if (selectedService == "Billing") {
                $("#payment_descriptionDIV").removeClass("d-block");
                $("#payment_descriptionDIV").addClass("d-none");
                //$('#amount').val(0);
                $('#amount').prop('readonly', true);
            } else {
                //$('#amount').val('');
                $('#amount').prop('readonly', false);
                $("#payment_descriptionDIV").removeClass("d-block");
                $("#payment_descriptionDIV").addClass("d-none");
            }
        }

        $("#temp_RetailInvoice_save").click(function() {
            // $("#addNew_RetailInvoice").valid();
			if ($('#addNew_RetailInvoice')[0].checkValidity()) {
				if (taxInvoiceCorrect) {
				// the form is valid
					if ($('#serviceIds').val() == "") {
						$('#temp_serviceIds').addClass('border-danger');
						$('#serviceIds_status').html('Please select service(s) from below table').css(
							'color', 'red');
					} else {
						$('#temp_serviceIds').removeClass('border-danger');
						$('#serviceIds_status').html('').css('color', 'green');
						$('#RetailInvoice_save').click();
					}
				}
				// alert('Valid');
				// $('#AskingMakeIncomePaymentPopup').modal('show');
				//$('#makePaymentLink').attr('href','income');
			} else {
				$('#RetailInvoice_save').click();
				//$('#makePaymentLink').attr('href','#');
				//alert('In-valid');
			}
        });
        $("#No_makePaymentLink").click(function() {
            $('#makePayment').val(0);
            $('#RetailInvoice_save').click();
        });
        $("#makePaymentLink").click(function() {
            $('#makePayment').val(1);
            $('#RetailInvoice_save').click();
        });

        $("#add_new_RetailInvoice").click(function() {
    $("#showRetailInvoice").removeClass("d-block");
    $("#showRetailInvoice").addClass("d-none");
    $("#showClient").removeClass("d-block");
    $("#showClient").addClass("d-none");
    $("#showClientWholeDetails").removeClass("d-block");
    $("#showClientWholeDetails").addClass("d-none");
    $("#showGSTWholeDetails").removeClass("d-block");
    $("#showGSTWholeDetails").addClass("d-none");
    $("#import_RetailInvoice").removeClass("d-block");
    $("#import_RetailInvoice").addClass("d-none");

    // Hide addNew_RetailInvoice and form2 initially
    $("#addNew_RetailInvoice").removeClass("d-block");
    $("#addNew_RetailInvoice").addClass("d-none");
    $("#form2").removeClass("d-block");
    $("#form2").addClass("d-none");

    // Show addNew_RetailInvoice form and hide form2 if the selected option is "manual"
    if ($("#category").val() === "manual") {
        $("#form2").removeClass("d-none");
        $("#form2").addClass("d-block");
    } else {
        $("#addNew_RetailInvoice").removeClass("d-none");
        $("#addNew_RetailInvoice").addClass("d-block");
    }

    $('#Export_RetailInvoiceForm').attr('action', 'Export_RetailInvoice');
    $("#export_RetailInvoice").prop("name", "Export_RetailInvoice");
    $("#pageHeading").html("Retail Invoice Transaction");
});

        $("#import_RetailInvoice").click(function() {
            $("#showRetailInvoice").removeClass("d-block");
            $("#showRetailInvoice").addClass("d-none");
            $("#showClient").removeClass("d-block");
            $("#showClient").addClass("d-none");
            $("#showClientWholeDetails").removeClass("d-block");
            $("#showClientWholeDetails").addClass("d-none");
            $("#addNew_RetailInvoice").removeClass("d-block");
            $("#addNew_RetailInvoice").addClass("d-none");
            $('#Export_RetailInvoiceForm').attr('action', 'Export_RetailInvoice');
            $("#export_RetailInvoice").prop("name", "Export_RetailInvoice");
            $("#showGSTWholeDetails").removeClass("d-block");
            $("#showGSTWholeDetails").addClass("d-none");
            $("#import_RetailInvoice").removeClass("d-none");
            $("#import_RetailInvoice").addClass("d-block");
            $("#pageHeading").html("Retail Invoice Transaction");
        });
        $("#view_Service").click(function() {
    // Hide other sections as per your current logic
    $("#showClient").removeClass("d-block").addClass("d-none");
    $("#addNew_otherService").removeClass("d-block").addClass("d-none");
    $("#showOtherServices").removeClass("d-block").addClass("d-none");
    $("#showClientWholeDetails").removeClass("d-block").addClass("d-none");
    $("#import_OtherServiceFile").removeClass("d-block").addClass("d-none");

    // Update page heading
    $("#showServices").removeClass("d-none").addClass("d-block");
    $('#Export_otherServicesForm').attr('action', 'Export_Client');
    $("#export_other_services").prop("name", "Export_Client");
    // $("#pageHeading").html("Service List");

    // Trigger the modal using Bootstrap 5 method
    var serviceModal = new bootstrap.Modal(document.getElementById('serviceModal'), {
        backdrop: 'static',
        keyboard: false
    });
    serviceModal.show();
});
        $("#view_RetailInvoiceClient").click(function() {
            $("#showRetailInvoice").removeClass("d-block");
            $("#showRetailInvoice").addClass("d-none");
            $("#addNew_RetailInvoice").removeClass("d-block");
            $("#addNew_RetailInvoice").addClass("d-none");
            $("#showGSTWholeDetails").removeClass("d-block");
            $("#showGSTWholeDetails").addClass("d-none");
            $("#import_RetailInvoice").removeClass("d-block");
            $("#import_RetailInvoice").addClass("d-none");

            $("#showClient").removeClass("d-none");
            $("#showClient").addClass("d-block");
            $('#Export_RetailInvoiceForm').attr('action', 'Export_Client');
            $("#export_RetailInvoice").prop("name", "Export_Client");
            $("#pageHeading").html("GST Clients");
        });
        // var ClientNameSelect1 = $("#ClientNameSelect1").val();
        // $.ajax({
        //     url: "html/Processgst.php",
        //     method: "post",
        //     data: {
        //         ClientNameSelect1: ClientNameSelect1
        //     },
        //     dataType: "text",
        //     success: function(data) {
        //         $("#gst_no").val(data);
        //         $("#gst_no_temp").val(data);
        //     }
        // });
//         $('#ClientNameSelect1').on("change", function (e) { 
// 		var ClientNameSelect1 = $("#ClientNameSelect1").val();
// 		$.ajax({
//             url:"html/Processgst.php",
//             method:"post",
//             data: {ClientNameSelect1:ClientNameSelect1},
//             dataType:"text",
//             success:function(data)
//             {   
//                 var jsonData = JSON.parse(data);
//             	$("#gst_no").val(jsonData.gst_no);
//             	$("#gst_no_temp").val(jsonData.gst_no);
//             	$("#client_ID").val(jsonData.client_id);
//             }
//         });
// 	});
//         $('#ClientNameSelect1').on("change", function (e) { 
// 		var ClientNameSelect1 = $("#ClientNameSelect1").val();
// 		$.ajax({
//             url:"html/Processgst.php",
//             method:"post",
//             data: {ClientNameSelect1:ClientNameSelect1},
//             dataType:"text",
//             success:function(data)
//             {   
//                 var jsonData = JSON.parse(data);
//             	$("#gst_no").val(jsonData.gst_no);
//             	$("#gst_no_temp").val(jsonData.gst_no);
//             	$("#client_ID").val(jsonData.client_id);
//             }
//         });
// 	});
        /* $("#return_type").change(function(){
        	var selectedReturn = $(this). children("option:selected"). val();
        	if (selectedReturn == "Composition") {
        		$("#trans_4DIV").removeClass("d-none");
        		$("#trans_4DIV").addClass("d-block");

        		$("#gstr_1DIV").removeClass("d-block");
        		$("#gstr_1DIV").addClass("d-none");
        		$("#gstr_3BDIV").removeClass("d-block");
        		$("#gstr_3BDIV").addClass("d-none");
        		$("#trans_1DIV").removeClass("d-block");
        		$("#trans_1DIV").addClass("d-none");
        		$("#trans_6DIV").removeClass("d-block");
        		$("#trans_6DIV").addClass("d-none");
        		$("#gstr_2a_recoDIV").removeClass("d-block");
        		$("#gstr_2a_recoDIV").addClass("d-none");
        	}else{
        		$("#trans_4DIV").removeClass("d-block");
        		$("#trans_4DIV").addClass("d-none");

        		$("#gstr_1DIV").removeClass("d-none");
        		$("#gstr_1DIV").addClass("d-block");
        		$("#gstr_3BDIV").removeClass("d-none");
        		$("#gstr_3BDIV").addClass("d-block");
        		$("#trans_1DIV").removeClass("d-none");
        		$("#trans_1DIV").addClass("d-block");
        		$("#trans_6DIV").removeClass("d-none");
        		$("#trans_6DIV").addClass("d-block");
        		$("#gstr_2a_recoDIV").removeClass("d-none");
        		$("#gstr_2a_recoDIV").addClass("d-block");
        	}
        }); */
        $("#PaymentModeSelect1").change(function() {
            var selectedService = $(this).children("option:selected").val();
            if (selectedService == "Bank Online") {
                $("#payment_descriptionDIV").removeClass("d-none");
                $("#payment_descriptionDIV").addClass("d-block");
                $('#amount').val('');
                $('#amount').prop('readonly', false);
            } else if (selectedService == "Billing") {
                $("#payment_descriptionDIV").removeClass("d-block");
                $("#payment_descriptionDIV").addClass("d-none");
                $('#amount').val(0);
                $('#amount').prop('readonly', true);
            } else {
                $('#amount').val('');
                $('#amount').prop('readonly', false);
                $("#payment_descriptionDIV").removeClass("d-block");
                $("#payment_descriptionDIV").addClass("d-none");
            }
        });
        var payment_description_hidden = $("#payment_description_hidden").val();
        if (payment_description_hidden == "") {
            //alert(tan_no);
            $("#payment_descriptionDIV").removeClass("d-none");
            $("#payment_descriptionDIV").addClass("d-block");
            //$("#service").val("Others");
        } else if (payment_description_hidden == "Bank") {
            $("#payment_descriptionDIV").removeClass("d-none");
            $("#payment_descriptionDIV").addClass("d-block");
        } else {
            $("#payment_descriptionDIV").removeClass("d-block");
            $("#payment_descriptionDIV").addClass("d-none");
        }
        /* var Temp_return_type = $("#Temp_return_type").val();
        if (Temp_return_type != "") {
        	if (Temp_return_type == "Regular") {
        		$("#trans_4DIV").removeClass("d-block");
        		$("#trans_4DIV").addClass("d-none");

        		$("#gstr_1DIV").removeClass("d-none");
        		$("#gstr_1DIV").addClass("d-block");
        		$("#gstr_3BDIV").removeClass("d-none");
        		$("#gstr_3BDIV").addClass("d-block");
        		$("#trans_1DIV").removeClass("d-none");
        		$("#trans_1DIV").addClass("d-block");
        		$("#trans_6DIV").removeClass("d-none");
        		$("#trans_6DIV").addClass("d-block");
        		$("#gstr_2a_recoDIV").removeClass("d-none");
        		$("#gstr_2a_recoDIV").addClass("d-block");
        	}else if (Temp_return_type == "Composition") {
        		$("#trans_4DIV").removeClass("d-none");
        		$("#trans_4DIV").addClass("d-block");

        		$("#gstr_1DIV").removeClass("d-block");
        		$("#gstr_1DIV").addClass("d-none");
        		$("#gstr_3BDIV").removeClass("d-block");
        		$("#gstr_3BDIV").addClass("d-none");
        		$("#trans_1DIV").removeClass("d-block");
        		$("#trans_1DIV").addClass("d-none");
        		$("#trans_6DIV").removeClass("d-block");
        		$("#trans_6DIV").addClass("d-none");
        		$("#gstr_2a_recoDIV").removeClass("d-block");
        		$("#gstr_2a_recoDIV").addClass("d-none");
        	}
        } */
        //alert($("#gstr_1_fileName").text());
        if ($("#gstr_1_fileName").text() != "") {
            $("#gstr_1_fileNameDIV").removeClass("d-none");
            $("#gstr_1_fileNameDIV").addClass("d-block show");
        }
        if ($("#gstr_3b_fileName").text() != "") {
            $("#gstr_3b_fileNameDIV").removeClass("d-none");
            $("#gstr_3b_fileNameDIV").addClass("d-block show");
        }
        if ($("#trans_1_fileName").text() != "") {
            $("#trans_1_fileNameDIV").removeClass("d-none");
            $("#trans_1_fileNameDIV").addClass("d-block show");
        }
        if ($("#trans_6_fileName").text() != "") {
            $("#trans_6_fileNameDIV").removeClass("d-none");
            $("#trans_6_fileNameDIV").addClass("d-block show");
        }
        if ($("#gstr_2a_reco_fileName").text() != "") {
            $("#gstr_2a_reco_fileNameDIV").removeClass("d-none");
            $("#gstr_2a_reco_fileNameDIV").addClass("d-block show");
        }
        if ($("#trans_4_fileName").text() != "") {
            $("#trans_4_fileNameDIV").removeClass("d-none");
            $("#trans_4_fileNameDIV").addClass("d-block show");
        }
        $("#fees_mode").change(function() {
            var selectedService = $(this).children("option:selected").val();
            if (selectedService == "Filed") {
                $("#fileFor").val("fees_mode");
                $("#fileConfirmMessagePopup").modal("show");
                //$("#payment_descriptionDIV").addClass("d-block");
            } else {
                $("#gstr_1File").val('');
                $("#gstr_1_fileNameDIV").removeClass("d-block");
                $("#gstr_1_fileNameDIV").addClass("d-none");
                //$("#payment_descriptionDIV").removeClass("d-block");
                //$("#payment_descriptionDIV").addClass("d-none");
            }
        });
        $('#gst_file_upload_yesBtn').click(function() {
            var fileForValue = $("#fileFor").val();
            if (fileForValue == "fees_mode") {
                $("#comfirmMsg").removeClass("d-block");
                $("#comfirmMsg").addClass("d-none");
                $("#gstr_1fileUpload").removeClass("d-none");
                $("#gstr_1fileUpload").addClass("d-block");

                $("#gstr_1_file_uploadBtn").removeClass("d-none");
                $("#gstr_1_file_uploadBtn").addClass("d-block");
            } else if (fileForValue == "gstr_3b") {
                $("#comfirmMsg").removeClass("d-block");
                $("#comfirmMsg").addClass("d-none");
                $("#gstr_3bfileUpload").removeClass("d-none");
                $("#gstr_3bfileUpload").addClass("d-block");

                $("#gstr_3b_file_uploadBtn").removeClass("d-none");
                $("#gstr_3b_file_uploadBtn").addClass("d-block");
            } else if (fileForValue == "trans_1") {
                $("#comfirmMsg").removeClass("d-block");
                $("#comfirmMsg").addClass("d-none");
                $("#trans_1fileUpload").removeClass("d-none");
                $("#trans_1fileUpload").addClass("d-block");

                $("#trans_1_file_uploadBtn").removeClass("d-none");
                $("#trans_1_file_uploadBtn").addClass("d-block");
            } else if (fileForValue == "trans_6") {
                $("#comfirmMsg").removeClass("d-block");
                $("#comfirmMsg").addClass("d-none");
                $("#trans_6fileUpload").removeClass("d-none");
                $("#trans_6fileUpload").addClass("d-block");

                $("#trans_6_file_uploadBtn").removeClass("d-none");
                $("#trans_6_file_uploadBtn").addClass("d-block");
            } else if (fileForValue == "gstr_2a_reco") {
                $("#comfirmMsg").removeClass("d-block");
                $("#comfirmMsg").addClass("d-none");
                $("#gstr_2a_recofileUpload").removeClass("d-none");
                $("#gstr_2a_recofileUpload").addClass("d-block");

                $("#gstr_2a_reco_file_uploadBtn").removeClass("d-none");
                $("#gstr_2a_reco_file_uploadBtn").addClass("d-block");
            } else if (fileForValue == "trans_4") {
                $("#comfirmMsg").removeClass("d-block");
                $("#comfirmMsg").addClass("d-none");
                $("#trans_4fileUpload").removeClass("d-none");
                $("#trans_4fileUpload").addClass("d-block");

                $("#trans_4_file_uploadBtn").removeClass("d-none");
                $("#trans_4_file_uploadBtn").addClass("d-block");
            }
            $("#gst_file_upload_yesBtn").removeClass("d-block");
            $("#gst_file_upload_yesBtn").addClass("d-none");
            $("#filemodalCloseBtn").html("CLOSE");
        });
        $("#gstr_1File").change(function() {
            var selectedFile = $("#gstr_1File").val().replace(/.*(\/|\\)/, '');
            $("#tempFileName").html(selectedFile);
        });
        $("#gstr_1_file_uploadBtn").click(function() {
            var filePath = $("#gstr_1File").val();
            var fileName = $("#gstr_1File").val().replace(/.*(\/|\\)/, '');
            var extension = fileName.substr((fileName.lastIndexOf('.') + 1)).toLowerCase();
            if (fileName == "") {
                //alert(fileName);
                //$("#gstr_1fileUpload").addClass("border border-danger");
                $("#fileUpload-status").html("Please choose file..!").css({
                    'color': 'red'
                });
            } else if (extension != "jpeg" && extension != "jpg" && extension != "pdf") {
                //$("#gstr_1fileUpload").addClass("border border-danger");
                //$("#fileUpload-status").html("").css({'color':'green'});
                $("#fileUpload-status").html("Please select jpg/jpeg/pdf file only..!").css({
                    'color': 'red'
                });
            } else if ($("#gstr_1File")[0].files[0].size > 50000) {
                $("#fileUpload-status").html("selected file must be < 50kb..!").css({
                    'color': 'red'
                });
            } else {
                $("#gstr_1fileUpload").removeClass("border border-danger");
                $("#fileUpload-status").html("").css({
                    'color': 'green'
                });
                $("#gstr_1_fileNameDIV").removeClass("d-none");
                $("#gstr_1_fileNameDIV").addClass("d-block show");
                $("#gstr_1_fileName").html(fileName);
                $("#fileConfirmMessagePopup").modal("hide");
            }
        });
        //GSTR - 3B
        $("#gstr_3b").change(function() {
            var selectedService = $(this).children("option:selected").val();
            if (selectedService == "Filed") {
                $("#fileConfirmMessagePopup").modal("show");
                $("#fileFor").val("gstr_3b");
                //$("#payment_descriptionDIV").addClass("d-block");
            } else {
                $("#gstr_3bFile").val('');
                $("#gstr_3b_fileNameDIV").removeClass("d-block");
                $("#gstr_3b_fileNameDIV").addClass("d-none");
                //$("#payment_descriptionDIV").removeClass("d-block");
                //$("#payment_descriptionDIV").addClass("d-none");
            }
        });
        $("#gstr_3bFile").change(function() {
            var selectedFile = $("#gstr_3bFile").val().replace(/.*(\/|\\)/, '');
            $("#tempFileName").html(selectedFile);
        });
        $("#gstr_3b_file_uploadBtn").click(function() {
            var filePath = $("#gstr_3bFile").val();
            var fileName = $("#gstr_3bFile").val().replace(/.*(\/|\\)/, '');
            var extension = fileName.substr((fileName.lastIndexOf('.') + 1)).toLowerCase();
            if (fileName == "") {
                //$("#gstr_3bfileUpload").addClass("border border-danger");
                $("#fileUpload-status").html("Please choose file..!").css({
                    'color': 'red'
                });
            } else if (extension != "jpeg" && extension != "jpg" && extension != "pdf") {
                //$("#gstr_3bfileUpload").addClass("border border-danger");
                $("#fileUpload-status").html("Please choose jpg/jpeg/pdf file only..!").css({
                    'color': 'red'
                });
            } else if ($("#gstr_3bFile")[0].files[0].size > 50000) {
                $("#fileUpload-status").html("selected file must be < 50kb..!").css({
                    'color': 'red'
                });
            } else {
                $("#gstr_3bfileUpload").removeClass("border border-danger");
                $("#fileUpload-status").html("").css({
                    'color': 'green'
                });
                $("#gstr_3b_fileNameDIV").removeClass("d-none");
                $("#gstr_3b_fileNameDIV").addClass("d-block show");
                $("#gstr_3b_fileName").html(fileName);
                $("#fileConfirmMessagePopup").modal("hide");
            }
        });

        //TRANS - 1
        $("#trans_1").change(function() {
            var selectedService = $(this).children("option:selected").val();
            if (selectedService == "Filed") {
                $("#fileConfirmMessagePopup").modal("show");
                $("#fileFor").val("trans_1");
                //$("#payment_descriptionDIV").addClass("d-block");
            } else {
                $("#trans_1File").val('');
                $("#trans_1_fileNameDIV").removeClass("d-block");
                $("#trans_1_fileNameDIV").addClass("d-none");
                //$("#payment_descriptionDIV").removeClass("d-block");
                //$("#payment_descriptionDIV").addClass("d-none");
            }
        });
        $("#trans_1File").change(function() {
            var selectedFile = $("#trans_1File").val().replace(/.*(\/|\\)/, '');
            $("#tempFileName").html(selectedFile);
        });
        $("#trans_1_file_uploadBtn").click(function() {
            var filePath = $("#trans_1File").val();
            var fileName = $("#trans_1File").val().replace(/.*(\/|\\)/, '');
            var extension = fileName.substr((fileName.lastIndexOf('.') + 1)).toLowerCase();
            if (fileName == "") {
                //$("#trans_1fileUpload").addClass("border border-danger");
                $("#fileUpload-status").html("Please choose file..!").css({
                    'color': 'red'
                });
            } else if (extension != "jpeg" && extension != "jpg" && extension != "pdf") {
                //$("#trans_1fileUpload").addClass("border border-danger");
                $("#fileUpload-status").html("Please choose jpg/jpeg/pdf file only..!").css({
                    'color': 'red'
                });
            } else if ($("#trans_1File")[0].files[0].size > 50000) {
                $("#fileUpload-status").html("selected file must be < 50kb..!").css({
                    'color': 'red'
                });
            } else {
                $("#trans_1fileUpload").removeClass("border border-danger");
                $("#fileUpload-status").html("").css({
                    'color': 'green'
                });
                $("#trans_1_fileNameDIV").removeClass("d-none");
                $("#trans_1_fileNameDIV").addClass("d-block show");
                $("#trans_1_fileName").html(fileName);
                $("#fileConfirmMessagePopup").modal("hide");
            }
        });

        //TRANS - 6
        $("#trans_6").change(function() {
            var selectedService = $(this).children("option:selected").val();
            if (selectedService == "Filed") {
                $("#fileConfirmMessagePopup").modal("show");
                $("#fileFor").val("trans_6");
                //$("#payment_descriptionDIV").addClass("d-block");
            } else {
                $("#trans_6File").val('');
                $("#trans_6_fileNameDIV").removeClass("d-block");
                $("#trans_6_fileNameDIV").addClass("d-none");
                //$("#payment_descriptionDIV").removeClass("d-block");
                //$("#payment_descriptionDIV").addClass("d-none");
            }
        });
        $("#trans_6File").change(function() {
            var selectedFile = $("#trans_6File").val().replace(/.*(\/|\\)/, '');
            $("#tempFileName").html(selectedFile);
        });
        $("#trans_6_file_uploadBtn").click(function() {
            var filePath = $("#trans_6File").val();
            var fileName = $("#trans_6File").val().replace(/.*(\/|\\)/, '');
            var extension = fileName.substr((fileName.lastIndexOf('.') + 1)).toLowerCase();
            if (fileName == "") {
                //$("#trans_6fileUpload").addClass("border border-danger");
                $("#fileUpload-status").html("Please choose file..!").css({
                    'color': 'red'
                });
            } else if (extension != "jpeg" && extension != "jpg" && extension != "pdf") {
                //$("#trans_6fileUpload").addClass("border border-danger");
                $("#fileUpload-status").html("Please choose jpg/jpeg/pdf file only..!").css({
                    'color': 'red'
                });
            } else if ($("#trans_6File")[0].files[0].size > 50000) {
                $("#fileUpload-status").html("selected file must be < 50kb..!").css({
                    'color': 'red'
                });
            } else {
                $("#trans_6fileUpload").removeClass("border border-danger");
                $("#fileUpload-status").html("").css({
                    'color': 'green'
                });
                $("#trans_6_fileNameDIV").removeClass("d-none");
                $("#trans_6_fileNameDIV").addClass("d-block show");
                $("#trans_6_fileName").html(fileName);
                $("#fileConfirmMessagePopup").modal("hide");
            }
        });

        //GSTR - 2A - RECO
        $("#gstr_2a_reco").change(function() {
            var selectedService = $(this).children("option:selected").val();
            if (selectedService == "Done Reconciliation") {
                $("#fileConfirmMessagePopup").modal("show");
                $("#fileFor").val("gstr_2a_reco");
                //$("#payment_descriptionDIV").addClass("d-block");
            } else {
                $("#gstr_2a_recoFile").val('');
                $("#gstr_2a_reco_fileNameDIV").removeClass("d-block");
                $("#gstr_2a_reco_fileNameDIV").addClass("d-none");
                //$("#payment_descriptionDIV").removeClass("d-block");
                //$("#payment_descriptionDIV").addClass("d-none");
            }
        });
        $("#gstr_2a_recoFile").change(function() {
            var selectedFile = $("#gstr_2a_recoFile").val().replace(/.*(\/|\\)/, '');
            $("#tempFileName").html(selectedFile);
        });
        $("#gstr_2a_reco_file_uploadBtn").click(function() {
            var filePath = $("#gstr_2a_recoFile").val();
            var fileName = $("#gstr_2a_recoFile").val().replace(/.*(\/|\\)/, '');
            var extension = fileName.substr((fileName.lastIndexOf('.') + 1)).toLowerCase();
            if (fileName == "") {
                //$("#gstr_2a_recofileUpload").addClass("border border-danger");
                $("#fileUpload-status").html("Please choose file..!").css({
                    'color': 'red'
                });
            } else if (extension != "jpeg" && extension != "jpg" && extension != "pdf" && extension !=
                "xlsx") {
                //$("#gstr_2a_recofileUpload").addClass("border border-danger");
                $("#fileUpload-status").html("Please choose jpg/jpeg/pdf/excel file only..!").css({
                    'color': 'red'
                });
            } else if ($("#gstr_2a_recoFile")[0].files[0].size > 200000) {
                $("#fileUpload-status").html("selected file must be < 200kb..!").css({
                    'color': 'red'
                });
            } else {
                $("#gstr_2a_recofileUpload").removeClass("border border-danger");
                $("#fileUpload-status").html("").css({
                    'color': 'green'
                });
                $("#gstr_2a_reco_fileNameDIV").removeClass("d-none");
                $("#gstr_2a_reco_fileNameDIV").addClass("d-block show");
                $("#gstr_2a_reco_fileName").html(fileName);
                $("#fileConfirmMessagePopup").modal("hide");
            }
        });

        //TRANS - 4
        $("#trans_4").change(function() {
            var selectedService = $(this).children("option:selected").val();
            if (selectedService == "Filed") {
                $("#fileConfirmMessagePopup").modal("show");
                $("#fileFor").val("trans_4");
                //$("#payment_descriptionDIV").addClass("d-block");
            } else {
                $("#trans_4File").val('');
                $("#trans_4_fileNameDIV").removeClass("d-block");
                $("#trans_4_fileNameDIV").addClass("d-none");
                //$("#payment_descriptionDIV").removeClass("d-block");
                //$("#payment_descriptionDIV").addClass("d-none");
            }
        });
        $("#trans_4File").change(function() {
            var selectedFile = $("#trans_4File").val().replace(/.*(\/|\\)/, '');
            $("#tempFileName").html(selectedFile);
        });
        $("#trans_4_file_uploadBtn").click(function() {
            var filePath = $("#trans_4File").val();
            var fileName = $("#trans_4File").val().replace(/.*(\/|\\)/, '');
            var extension = fileName.substr((fileName.lastIndexOf('.') + 1)).toLowerCase();
            if (fileName == "") {
                //$("#trans_4fileUpload").addClass("border border-danger");
                $("#fileUpload-status").html("Please choose file..!").css({
                    'color': 'red'
                });
            } else if (extension != "jpeg" && extension != "jpg" && extension != "pdf") {
                //$("#trans_4fileUpload").addClass("border border-danger");
                $("#fileUpload-status").html("Please choose jpg/jpeg/pdf file only..!").css({
                    'color': 'red'
                });
            } else if ($("#trans_4File")[0].files[0].size > 50000) {
                $("#fileUpload-status").html("selected file must be < 50kb..!").css({
                    'color': 'red'
                });
            } else {
                $("#trans_4fileUpload").removeClass("border border-danger");
                $("#fileUpload-status").html("").css({
                    'color': 'green'
                });
                $("#trans_4_fileNameDIV").removeClass("d-none");
                $("#trans_4_fileNameDIV").addClass("d-block show");
                $("#trans_4_fileName").html(fileName);
                $("#fileConfirmMessagePopup").modal("hide");
            }
        });

        $('#filemodalCloseBtn').click(function() {
            var fileForValue = $("#fileFor").val();
            if (fileForValue == "fees_mode") {
                $("#gstr_1File").val('');
            } else if (fileForValue == "gstr_3b") {
                $("#gstr_3bFile").val('');
            } else if (fileForValue == "trans_1") {
                $("#trans_1File").val('');
            } else if (fileForValue == "trans_6") {
                $("#trans_6File").val('');
            } else if (fileForValue == "gstr_2a_reco") {
                $("#gstr_2a_recoFile").val('');
            } else if (fileForValue == "trans_4") {
                $("#trans_4File").val('');
            }
        });

        $("#gstr_1closeFileNameBtn").click(function() {
            $("#gstr_1_fileNameDIV").removeClass("d-block");
            $("#gstr_1_fileNameDIV").addClass("d-none");
            $("#gstr_1File").val('');
            $("#gstr_1_fileNameOLD").val('');
            $("#gstFileRemoveConfirmMessagePopup").modal("hide");
        });
        $("#gstr_3bcloseFileNameBtn").click(function() {
            $("#gstr_3b_fileNameDIV").removeClass("d-block");
            $("#gstr_3b_fileNameDIV").addClass("d-none");
            $("#gstr_3bFile").val('');
            $("#gstr_3b_fileNameOLD").val('');
            $("#gstFileRemoveConfirmMessagePopup").modal("hide");
        });
        $("#trans_1closeFileNameBtn").click(function() {
            $("#trans_1_fileNameDIV").removeClass("d-block");
            $("#trans_1_fileNameDIV").addClass("d-none");
            $("#trans_1File").val('');
            $("#trans_1_fileNameOLD").val('');
            $("#gstFileRemoveConfirmMessagePopup").modal("hide");
        });
        $("#trans_6closeFileNameBtn").click(function() {
            $("#trans_6_fileNameDIV").removeClass("d-block");
            $("#trans_6_fileNameDIV").addClass("d-none");
            $("#trans_6File").val('');
            $("#trans_6_fileNameOLD").val('');
            $("#gstFileRemoveConfirmMessagePopup").modal("hide");
        });
        $("#gstr_2a_recocloseFileNameBtn").click(function() {
            $("#gstr_2a_reco_fileNameDIV").removeClass("d-block");
            $("#gstr_2a_reco_fileNameDIV").addClass("d-none");
            $("#gstr_2a_recoFile").val('');
            $("#gstr_2a_reco_fileNameOLD").val('');
            $("#gstFileRemoveConfirmMessagePopup").modal("hide");
        });
        $("#trans_4closeFileNameBtn").click(function() {
            $("#trans_4_fileNameDIV").removeClass("d-block");
            $("#trans_4_fileNameDIV").addClass("d-none");
            $("#trans_4File").val('');
            $("#trans_4_fileNameOLD").val('');
            $("#gstFileRemoveConfirmMessagePopup").modal("hide");
        });

        $("#gstr_1closeFileNameModalBtn").click(function() {
            $("#gstr_1closeFileNameBtn").removeClass("d-none");
            $("#gstr_1closeFileNameBtn").addClass("d-block");
            $("#gstFileRemoveConfirmMessagePopup").modal("show");
        });
        $("#gstr_3bcloseFileNameModalBtn").click(function() {
            $("#gstr_3bcloseFileNameBtn").removeClass("d-none");
            $("#gstr_3bcloseFileNameBtn").addClass("d-block");
            $("#gstFileRemoveConfirmMessagePopup").modal("show");
        });
        $("#trans_1closeFileNameModalBtn").click(function() {
            $("#trans_1closeFileNameBtn").removeClass("d-none");
            $("#trans_1closeFileNameBtn").addClass("d-block");
            $("#gstFileRemoveConfirmMessagePopup").modal("show");
        });
        $("#trans_6closeFileNameModalBtn").click(function() {
            $("#trans_6closeFileNameBtn").removeClass("d-none");
            $("#trans_6closeFileNameBtn").addClass("d-block");
            $("#gstFileRemoveConfirmMessagePopup").modal("show");
        });
        $("#gstr_2a_recocloseFileNameModalBtn").click(function() {
            $("#gstr_2a_recocloseFileNameBtn").removeClass("d-none");
            $("#gstr_2a_recocloseFileNameBtn").addClass("d-block");
            $("#gstFileRemoveConfirmMessagePopup").modal("show");
        });
        $("#trans_4closeFileNameModalBtn").click(function() {
            $("#trans_4closeFileNameBtn").removeClass("d-none");
            $("#trans_4closeFileNameBtn").addClass("d-block");
            $("#gstFileRemoveConfirmMessagePopup").modal("show");
        });

        //Re-Arrange The Modals
        $('#gstFileRemoveConfirmMessagePopup').on('hidden.bs.modal', function() {
            $("#gstr_1closeFileNameBtn").removeClass("d-block");
            $("#gstr_1closeFileNameBtn").addClass("d-none");
            $("#gstr_3bcloseFileNameBtn").removeClass("d-block");
            $("#gstr_3bcloseFileNameBtn").addClass("d-none");
            $("#trans_1closeFileNameBtn").removeClass("d-block");
            $("#trans_1closeFileNameBtn").addClass("d-none");
            $("#trans_6closeFileNameBtn").removeClass("d-block");
            $("#trans_6closeFileNameBtn").addClass("d-none");
            $("#gstr_2a_recocloseFileNameBtn").removeClass("d-block");
            $("#gstr_2a_recocloseFileNameBtn").addClass("d-none");
            $("#trans_4closeFileNameBtn").removeClass("d-block");
            $("#trans_4closeFileNameBtn").addClass("d-none");
        });

        //Re-Arrange The Modals
        $('#fileConfirmMessagePopup').on('hidden.bs.modal', function() {
            $("#fileFor").val("");
            $("#tempFileName").html("");

            $("#gstr_1fileUpload").removeClass("border border-danger");
            $("#gstr_3bfileUpload").removeClass("border border-danger");
            $("#trans_1fileUpload").removeClass("border border-danger");
            $("#trans_6fileUpload").removeClass("border border-danger");
            $("#gstr_2a_recofileUpload").removeClass("border border-danger");
            $("#trans_4fileUpload").removeClass("border border-danger");

            $("#fileUpload-status").html("").css({
                'color': 'green'
            });
            $("#comfirmMsg").removeClass("d-none");
            $("#comfirmMsg").addClass("d-block");

            $("#gstr_1fileUpload").removeClass("d-block");
            $("#gstr_1fileUpload").addClass("d-none");
            $("#gstr_3bfileUpload").removeClass("d-block");
            $("#gstr_3bfileUpload").addClass("d-none");
            $("#trans_1fileUpload").removeClass("d-block");
            $("#trans_1fileUpload").addClass("d-none");
            $("#trans_6fileUpload").removeClass("d-block");
            $("#trans_6fileUpload").addClass("d-none");
            $("#gstr_2a_recofileUpload").removeClass("d-block");
            $("#gstr_2a_recofileUpload").addClass("d-none");
            $("#trans_4fileUpload").removeClass("d-block");
            $("#trans_4fileUpload").addClass("d-none");

            $("#gst_file_upload_yesBtn").removeClass("d-none");
            $("#gst_file_upload_yesBtn").addClass("d-block");

            $("#gstr_1_file_uploadBtn").removeClass("d-block");
            $("#gstr_1_file_uploadBtn").addClass("d-none");
            $("#gstr_3b_file_uploadBtn").removeClass("d-block");
            $("#gstr_3b_file_uploadBtn").addClass("d-none");
            $("#trans_1_file_uploadBtn").removeClass("d-block");
            $("#trans_1_file_uploadBtn").addClass("d-none");
            $("#trans_6_file_uploadBtn").removeClass("d-block");
            $("#trans_6_file_uploadBtn").addClass("d-none");
            $("#gstr_2a_reco_file_uploadBtn").removeClass("d-block");
            $("#gstr_2a_reco_file_uploadBtn").addClass("d-none");
            $("#trans_4_file_uploadBtn").removeClass("d-block");
            $("#trans_4_file_uploadBtn").addClass("d-none");

            $("#filemodalCloseBtn").html("NO");
        });

        //Show Client Data
        $('#lastLinkClient').click(function() {
            var LastClient = $('#LastClient').val();
            $.ajax({
                url: "html/showClientTable.php",
                method: "post",
                data: {
                    Client_pageno: LastClient
                },
                dataType: "text",
                success: function(data) {
                    //alert(data);
                    //alert(LastClient);
                    //$('#currentPageno').val(LastClient);
                    $('#showClientTable').empty();
                    $('#showClientTable').html(data);
                }
            });
        });
        $('#firstLinkClient').click(function() {
            var firstClient = $('#firstClient').val();
            $.ajax({
                url: "html/showClientTable.php",
                method: "post",
                data: {
                    Client_pageno: firstClient
                },
                dataType: "text",
                success: function(data) {
                    //alert(data);
                    //alert(firstClient);
                    $('#showClientTable').empty();
                    $('#showClientTable').html(data);
                }
            });
        });
        $('#nextLinkClient').click(function() {
            var NextClient = $('#NextClient').val();
            $.ajax({
                url: "html/showClientTable.php",
                method: "post",
                data: {
                    Client_pageno: NextClient
                },
                dataType: "text",
                success: function(data) {
                    //alert(data);
                    //alert(NextClient);
                    $('#showClientTable').empty();
                    $('#showClientTable').html(data);
                }
            });
        });
        $('#prevLinkClient').click(function() {
            var prevClient = $('#prevClient').val();
            $.ajax({
                url: "html/showClientTable.php",
                method: "post",
                data: {
                    Client_pageno: prevClient
                },
                dataType: "text",
                success: function(data) {
                    //alert(data);
                    //alert(prevClient);
                    $('#showClientTable').empty();
                    $('#showClientTable').html(data);
                }
            });
        });

        $('#lastLink').click(function() {
            var last = $('#last').val();
            $.ajax({
                url: "html/showRetailInvoiceTable.php",
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
                url: "html/showRetailInvoiceTable.php",
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
                url: "html/showRetailInvoiceTable.php",
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
                url: "html/showRetailInvoiceTable.php",
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
    $("#users_access").on('change', function() {
        var selected = $("#users_access").val().toString(); //here I get all options and convert to string
        var document_style = document.documentElement.style;
        /*if(selected !== "")
          document_style.setProperty('--text', "'Selected: "+selected+"'");
        else
          document_style.setProperty('--text', "'Select values'");*/
    });
    </script>
    <?php include_once 'ltr/header-footer.php'; ?>
    <script type="text/javascript" src="//cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
</body>

</html>