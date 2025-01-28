<?php 
	include_once 'ltr/header.php';
	include_once 'customPopup.php';
	//echo $_SESSION['company_id'];
	//print_r($_COOKIE);
	//echo $_COOKIE['login_VowelUser']; 
	//echo $_SESSION['verified'];
	if (isset($_SESSION['verified'])) {
	  if ($_SESSION['verified'] == '1') {
	    echo "<script type='text/javascript'>$(document).ready(function(){ $('#VerifyMsgModal').modal('show'); }); </script>";
	    //$_SESSION['LastLoginDate'] = date('Y-m-d');
	  }
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<!-- <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css"/> -->
	<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.11.3/css/dataTables.bootstrap4.min.css"/>
	<style type="text/css">
		.client-to-grow, .vendor-to-grow, .gst-to-grow, .itReturns-to-grow, .audit-to-grow, .pan-to-grow, .tan-to-grow, .e_Tds-to-grow, .dsc_Subscriber-to-grow, .dsc_Reseller-to-grow, .Psp_Distribution-to-grow, .Psp_Consumption-to-grow, .income-to-grow, .expense-to-grow, .notes-to-grow, .reminder-to-grow, .passwordManager-to-grow, .advance-to-grow {
		font-size: 18px;
		}
		
		/*fieldset.scheduler-border {
			border: 1px groove #ddd !important;
			height: auto;
			line-height: .8;
			//padding: 0 0 0 0;
			//margin: 0 0 0 0;
			//margin: 0 0 1.5em 0 !important;
			-webkit-box-shadow:  0px 0px 0px 0px #000;
					box-shadow:  0px 0px 0px 0px #000;
			//white-space: normal;
		}
		legend.scheduler-border {
			width:auto; /* Or auto */
			/*padding:0 10px; /* To give a bit of padding on the left and right */
			/*border-bottom:none;
		}*/
		fieldset 
		{
			border: 1px solid #ddd !important;
			margin: 0;
			xmin-width: 0;
			padding: 10px;       
			position: relative;
			border-radius:4px;
			//background-color:#f5f5f5;
			padding-left:10px!important;
		}
		legend
		{
			font-size:16px;
			font-weight:bold;
			margin-bottom: 0px; 
			width: 35%; 
			border: 1px solid #ddd;
			border-radius: 4px; 
			padding: 5px 5px 5px 10px; 
			background-color:#f0f0f0;
		}
		/*@media (max-width: 1200px)
		{
			h6{
				font-size: calc(1vw);
			}
		}
		h6 {font-size:1rem;}*/
		.internalTab{
			background: #292B2C;
			color: #FFF;
		}
		.internalTab:hover{
			background: #292B2C;
			color: #FFF;
		}
	</style>
</head>
<body>
    <div class="col-12">
        <!-- Column -->
        <?php /* if ($_SESSION['user_type'] == 'system_user') {
        	$clientMaster = "SELECT * FROM `client_master` WHERE `company_id` = '".$_SESSION['company_id']."'";
        	$run_clientMaster = mysqli_query($con,$clientMaster);

        	$vendorMaster = "SELECT * FROM `vendor_master` WHERE `company_id` = '".$_SESSION['company_id']."'";
        	$run_vendorMaster = mysqli_query($con,$vendorMaster);

        	$Gst = "SELECT * FROM `gst` WHERE `company_id` = '".$_SESSION['company_id']."'";
        	$run_Gst = mysqli_query($con,$Gst);

        	$itReturns = "SELECT * FROM `it_returns` WHERE `company_id` = '".$_SESSION['company_id']."'";
        	$run_itReturns = mysqli_query($con,$itReturns);

        	$Audit = "SELECT * FROM `audit` WHERE `company_id` = '".$_SESSION['company_id']."'";
        	$run_Audit = mysqli_query($con,$Audit);

        	$Pan = "SELECT * FROM `pan` WHERE `company_id` = '".$_SESSION['company_id']."'";
        	$run_Pan = mysqli_query($con,$Pan);

        	$Tan = "SELECT * FROM `tan` WHERE `company_id` = '".$_SESSION['company_id']."'";
        	$run_Tan = mysqli_query($con,$Tan);

        	$e_Tds = "SELECT * FROM `e_tds` WHERE `company_id` = '".$_SESSION['company_id']."'";
        	$run_e_Tds = mysqli_query($con,$e_Tds);

        	$dsc_Subscriber = "SELECT * FROM `dsc_subscriber` WHERE `company_id` = '".$_SESSION['company_id']."'";
        	$run_dsc_Subscriber = mysqli_query($con,$dsc_Subscriber);

        	$dsc_Reseller = "SELECT * FROM `dsc_reseller` WHERE `company_id` = '".$_SESSION['company_id']."'";
        	$run_dsc_Reseller = mysqli_query($con,$dsc_Reseller);

        	$Psp_Distribution = "SELECT * FROM `psp` WHERE `company_id` = '".$_SESSION['company_id']."'";
        	$run_Psp_Distribution = mysqli_query($con,$Psp_Distribution);

        	$Psp_Consumption = "SELECT * FROM `psp_coupon_consumption` WHERE `company_id` = '".$_SESSION['company_id']."'";
        	$run_Psp_Consumption = mysqli_query($con,$Psp_Consumption);

        	$Incomes = "SELECT * FROM `income` WHERE `company_id` = '".$_SESSION['company_id']."'";
        	$run_Incomes = mysqli_query($con,$Incomes);

        	$Expenses = "SELECT * FROM `expense` WHERE `company_id` = '".$_SESSION['company_id']."'";
        	$run_Expenses = mysqli_query($con,$Expenses);
        	
        	$Notes = "SELECT * FROM `user_notes` WHERE `company_id` = '".$_SESSION['company_id']."'";
        	$run_Notes = mysqli_query($con,$Notes);

        	$Reminder = "SELECT * FROM `reminder` WHERE `company_id` = '".$_SESSION['company_id']."'";
        	$run_Reminder = mysqli_query($con,$Reminder);

        	$passwordManager = "SELECT * FROM `accounts` WHERE `company_id` = '".$_SESSION['company_id']."'";
        	$run_passwordManager = mysqli_query($con,$passwordManager);
        }else{
        	$clientMaster = "SELECT * FROM `client_master` WHERE `company_id` = '".$_SESSION['company_id']."' AND `client_name` = '".$_SESSION['username']."'";
        	$run_clientMaster = mysqli_query($con,$clientMaster);

        	$vendorMaster = "SELECT * FROM `vendor_master` WHERE `company_id` = '".$_SESSION['company_id']."' AND `client_name` = '".$_SESSION['username']."'";
        	$run_vendorMaster = mysqli_query($con,$vendorMaster);

        	$Gst = "SELECT * FROM `gst` WHERE `company_id` = '".$_SESSION['company_id']."' AND `client_name` = '".$_SESSION['username']."'";
        	$run_Gst = mysqli_query($con,$Gst);

        	$itReturns = "SELECT * FROM `it_returns` WHERE `company_id` = '".$_SESSION['company_id']."' AND `client_name` = '".$_SESSION['username']."'";
        	$run_itReturns = mysqli_query($con,$itReturns);

        	$Audit = "SELECT * FROM `audit` WHERE `company_id` = '".$_SESSION['company_id']."' AND `client_name` = '".$_SESSION['username']."'";
        	$run_Audit = mysqli_query($con,$Audit);

        	$Pan = "SELECT * FROM `pan` WHERE `company_id` = '".$_SESSION['company_id']."' AND `client_name` = '".$_SESSION['username']."'";
        	$run_Pan = mysqli_query($con,$Pan);

        	$Tan = "SELECT * FROM `tan` WHERE `company_id` = '".$_SESSION['company_id']."' AND `client_name` = '".$_SESSION['username']."'";
        	$run_Tan = mysqli_query($con,$Tan);

        	$e_Tds = "SELECT * FROM `e_tds` WHERE `company_id` = '".$_SESSION['company_id']."' AND `client_name` = '".$_SESSION['username']."'";
        	$run_e_Tds = mysqli_query($con,$e_Tds);

        	$dsc_Subscriber = "SELECT * FROM `dsc_subscriber` WHERE `company_id` = '".$_SESSION['company_id']."' AND `client_name` = '".$_SESSION['username']."'";
        	$run_dsc_Subscriber = mysqli_query($con,$dsc_Subscriber);

        	$dsc_Reseller = "SELECT * FROM `dsc_reseller` WHERE `company_id` = '".$_SESSION['company_id']."' AND `client_name` = '".$_SESSION['username']."'";
        	$run_dsc_Reseller = mysqli_query($con,$dsc_Reseller);

        	$Psp_Distribution = "SELECT * FROM `psp` WHERE `company_id` = '".$_SESSION['company_id']."' AND `client_name` = '".$_SESSION['username']."'";
        	$run_Psp_Distribution = mysqli_query($con,$Psp_Distribution);

        	$Psp_Consumption = "SELECT * FROM `psp_coupon_consumption` WHERE `company_id` = '".$_SESSION['company_id']."' AND `client_name` = '".$_SESSION['username']."'";
        	$run_Psp_Consumption = mysqli_query($con,$Psp_Consumption);

        	$Incomes = "SELECT * FROM `income` WHERE `company_id` = '".$_SESSION['company_id']."' AND `client_name` = '".$_SESSION['username']."'";
        	$run_Incomes = mysqli_query($con,$Incomes);

        	$Expenses = "SELECT * FROM `expense` WHERE `company_id` = '".$_SESSION['company_id']."' AND `client_name` = '".$_SESSION['username']."'";
        	$run_Expenses = mysqli_query($con,$Expenses);
        	
        	$Notes = "SELECT * FROM `user_notes` WHERE `company_id` = '".$_SESSION['company_id']."' AND `client_name` = '".$_SESSION['username']."'";
        	$run_Notes = mysqli_query($con,$Notes);

        	$Reminder = "SELECT * FROM `reminder` WHERE `company_id` = '".$_SESSION['company_id']."' AND `client_name` = '".$_SESSION['username']."'";
        	$run_Reminder = mysqli_query($con,$Reminder);

        	$passwordManager = "SELECT * FROM `accounts` WHERE `company_id` = '".$_SESSION['company_id']."' AND `client_name` = '".$_SESSION['username']."'";
        	$run_passwordManager = mysqli_query($con,$passwordManager);
        } */

		$AdvClientMaster = "SELECT SUM(`advance_balance`) as advance_balance FROM `client_master` WHERE (`advance_balance` > 0) AND `company_id` = '".$_SESSION['company_id']."'";
		$run_AdvClientMaster = mysqli_query($con,$AdvClientMaster);
		$AdvanceRow_2 = mysqli_fetch_array($run_AdvClientMaster);
        ?>
		<?php if ($_SESSION['user_type'] == 'system_user') { ?>
        <div class="row">
			<?php $fetch_user_data_2 = "SELECT * FROM `users` WHERE `company_id` = '".$_SESSION['company_id']."' AND `id` = '".$_SESSION['user_id']."'";
					$run_fetch_user_data_2 = mysqli_query($con,$fetch_user_data_2);
					$row_2 = mysqli_fetch_array($run_fetch_user_data_2);
				if ($row_2['client_master'] == "1") {?>
					<!-- Column -->
					<fieldset class="form-inline col-md-2 col-lg-2" style="height: 160px;">
						<legend class="w-auto">Clients</legend>
						<div class="row" style="width: 100%;">
							<div class="col-md-12 col-lg-12 col-xlg-12">
								<a href="client_master">
									<div class="card card-hover">
										<div class="box bg-cyan text-center">
											<h3 class="font-light text-white"><i class="mdi mdi-view-dashboard"></i></h3>
											<h6 class="text-white">Client Master</h6>
										</div>
									</div>
								</a>
							</div>
						</div>
					</fieldset>
					<?php }	if ($row_2['gst'] == "1" || $row_2['it_returns'] == "1" || $row_2['audit'] == "1") { ?>
					<fieldset class="form-inline col-md-6 col-lg-6" style="height: 160px;">
						<legend class="w-auto">Taxation</legend>
						<div class="row" style="width: 100%;">
							<?php if ($row_2['gst'] == "1") {?>
								<div class="col-md-4 col-lg-4 col-xlg-4">
									<a href="gst_fees">
										<div class="card card-hover">
											<div class="box bg-success text-center">
												<h3 class="font-light text-white"><i class="mdi mdi-chart-areaspline"></i></h3>
												<h6 class="text-white">GST</h6>
											</div>
										</div>
									</a>
								</div>
							<?php } if ($row_2['it_returns'] == "1") {?>
							<!-- Column -->
								<div class="col-md-4 col-lg-4 col-xlg-4">
									<a href="it_returns">
										<div class="card card-hover">
											<div class="box bg-warning text-center">
												<h3 class="font-light text-white"><i class="mdi mdi-collage"></i></h3>
												<h6 class="text-white">IT Returns</h6>
											</div>
										</div>
									</a>
								</div>
							<?php } if ($row_2['audit'] == "1") {?>
							<!-- Column -->
								<div class="col-md-4 col-lg-4 col-xlg-4">
									<a href="audit">
										<div class="card card-hover">
											<div class="box bg-danger text-center">
												<h3 class="font-light text-white"><i class="mdi mdi-border-outside"></i></h3>
												<h6 class="text-white">Audit</h6>
											</div>
										</div>
									</a>
								</div>
							<?php } ?>
						</div>
					</fieldset>
			<?php 	} if ($row_2['dsc_subscriber'] == "1" || $row_2['dsc_reseller'] == "1") {?>
						<!-- Column -->
						<fieldset class="form-inline col-md-4 col-lg-4" style="height: 160px;">
							<legend class="w-auto">DSC</legend>
							<div class="row" style="width: 100%;">
								<?php if ($row_2['dsc_subscriber'] == "1") {?>
									<div class="col-md-6 col-lg-6 col-xlg-4">
										<a href="dsc_subscriber">
											<div class="card card-hover">
												<div class="box bg-cyan text-center">
													<h3 class="font-light text-white"><i class="mdi mdi-pencil"></i></h3>
													<h6 class="text-white">DSC Applicant</h6>
												</div>
											</div>
										</a>
									</div>
								<?php } if ($row_2['dsc_reseller'] == "1") {?>
								<!-- Column -->
									<div class="col-md-6 col-lg-6 col-xlg-4">
										<a href="dsc_reseller">
											<div class="card card-hover">
												<div class="box bg-success text-center">
													<h3 class="font-light text-white"><i class="mdi mdi-calendar-check"></i></h3>
													<h6 class="text-white">DSC Partner</h6>
												</div>
											</div>
										</a>
									</div>
								<?php } ?>
							</div>
						</fieldset>
			<?php 	} ?>
			</div>
			<!-- Column -->
			<div class="row">
				<?php if ($row_2['pan'] == "1" || $row_2['tan'] == "1" || $row_2['e_tds'] == "1") {?>
					<fieldset class="form-inline col-md-6 col-lg-6" style="height: 160px;">
						<legend class="w-auto">NSDL</legend>
						<div class="row" style="width: 100%;">
						<?php if ($row_2['pan'] == "1") {?>
							<!-- Column -->
							<div class="col-md-4 col-lg-4 col-xlg-4">
								<a href="pan">
									<div class="card card-hover">
										<div class="box bg-info text-center">
											<h3 class="font-light text-white"><i class="mdi mdi-arrow-all"></i></h3>
											<h6 class="text-white">PAN</h6>
										</div>
									</div>
								</a>
							</div>
						<?php } if ($row_2['tan'] == "1") {?>
							<!-- Column -->
							<div class="col-md-4 col-lg-4 col-xlg-4">
								<a href="tan">
									<div class="card card-hover">
										<div class="box bg-danger text-center">
											<h3 class="font-light text-white"><i class="mdi mdi-receipt"></i></h3>
											<h6 class="text-white">TAN</h6>
										</div>
									</div>
								</a>
							</div>
						<?php } if ($row_2['e_tds'] == "1") {?>
							<!-- Column -->
							<div class="col-md-4 col-lg-4 col-xlg-4">
								<a href="e_tds">
									<div class="card card-hover">
										<div class="box bg-info text-center">
											<h3 class="font-light text-white"><i class="mdi mdi-relative-scale"></i></h3>
											<h6 class="text-white">e-TDS</h6>
										</div>
									</div>
								</a>
							</div>
						<?php } ?>
						</div>
					</fieldset>
				<?php } if ($row_2['psp'] == "1" || $row_2['psp_coupon_consumption'] == "1") {?>
					<!-- Column -->
					<fieldset class="form-inline col-md-4 col-lg-4" style="height: 160px;">
						<legend class="w-auto">UTI</legend>
						<div class="row" style="width: 100%;">
						<?php if ($row_2['psp'] == "1") {?>
							<div class="col-md-6 col-lg-6 col-xlg-3">
								<a href="psp">
									<div class="card card-hover">
										<div class="box bg-info text-center">
											<h3 class="font-light text-white"><i class="mdi mdi-arrow-all"></i></h3>
											<h6 class="text-white">PSP Agent</h6>
										</div>
									</div>
								</a>
							</div>
						<?php } if ($row_2['psp_coupon_consumption'] == "1") {?>
							<!-- Column -->
							<!-- Column -->
							<div class="col-md-6 col-lg-6 col-xlg-3">
								<a href="coupon_consumption">
									<div class="card card-hover">
										<div class="box bg-danger text-center">
											<h3 class="font-light text-white"><i class="mdi mdi-border-outside"></i></h3>
											<h6 class="text-white">PSP Coupon</h6>
										</div>
									</div>
								</a>
							</div>
						<?php } ?>
						</div>
					</fieldset>
				<?php } ?>
				<!-- Column -->
				<!-- <fieldset class="form-inline col-md-2 col-lg-2" style="height: 160px;">
					<legend class="w-auto">Password</legend>
					<div class="row" style="width: 100%;">
						<div class="col-md-12 col-lg-12 col-xlg-3">
							<a href="password_manager">
								<div class="card card-hover">
									<div class="box bg-dark text-center">
										<h3 class="font-light text-white"><i class="mdi mdi-calendar-check"></i></h3>
										<h6 class="text-white">Password Mng.</h6>
										<h6 class="text-white passwordManager-to-grow" data-end="<?php //echo mysqli_num_rows($run_passwordManager); ?>">0</h6>
									</div>
								</div>
							</a>
						</div>
					</div>
				</fieldset> -->
				<fieldset class="form-inline col-md-2 col-lg-2" style="height: 160px;">
					<legend class="w-auto">Vendors</legend>
					<div class="row" style="width: 100%;">
						<div class="col-md-12 col-lg-12 col-xlg-12">
							<a href="vendor_master">
								<div class="card card-hover">
									<div class="box bg-primary text-center">
										<h3 class="font-light text-white"><i class="mdi mdi-view-dashboard"></i></h3>
										<h6 class="text-white">Vendor Master</h6>
									</div>
								</div>
							</a>
						</div>
					</div>
				</fieldset>
			</div>
		<?php } ?>
			<!-- Column -->
			<?php if ($_SESSION['user_type'] == 'system_user') { ?>
				<fieldset class="form-inline col-md-12 col-lg-12" style="height: 160px;">
					<legend class="w-auto">Finance</legend>
					<div class="row" style="width: 100%;">
						<div class="col-md-2 col-lg-2 col-xlg-3">
							<a href="service_income">
								<div class="card card-hover">
									<div class="box bg-warning text-center">
										<h3 class="font-light text-white"><i class="mdi mdi-alert"></i></h3>
										<h6 class="text-white">Incomes</h6>
									</div>
								</div>
							</a>
						</div>
						<!-- Column -->
						<!-- Column -->
						<div class="col-md-2 col-lg-2 col-xlg-3">
							<a href="service_expense">
								<div class="card card-hover">
									<div class="box bg-success text-center">
										<h3 class="font-light text-white"><i class="mdi mdi-chart-areaspline"></i></h3>
										<h6 class="text-white">Expenses</h6>
									</div>
								</div>
							</a>
						</div>

						<div class="col-md-2 col-lg-2 col-xlg-3">
							<a href="service_contra">
								<div class="card card-hover">
									<div class="box bg-danger text-center">
										<h3 class="font-light text-white"><i class="mdi mdi-view-dashboard"></i></h3>
										<h6 class="text-white">Contra</h6>
									</div>
								</div>
							</a>
						</div>
						<div class="col-md-2 col-lg-2 col-xlg-3">
							<a href="invoice_receipt">
								<div class="card card-hover">
									<div class="box bg-info text-center">
										<h3 class="font-light text-white"><i class="mdi mdi-border-outside"></i></h3>
										<h6 class="text-white">Service Reports</h6>
									</div>
								</div>
							</a>
						</div>
						<div class="col-md-2 col-lg-2 col-xlg-3">
							<a href="finance_report">
								<div class="card card-hover">
									<div class="box bg-cyan text-center">
										<h3 class="font-light text-white"><i class="mdi mdi-receipt"></i></h3>
										<h6 class="text-white">Financial Reports</h6>
									</div>
								</div>
							</a>
						</div>
						<div class="col-md-2 col-lg-2 col-xlg-3">
							<a href="finance_report#outstanding" id='outstandingLink'>
								<div class="card card-hover">
									<div class="box bg-primary text-center">
										<h3 class="font-light text-white"><i class="mdi mdi-relative-scale"></i></h3>
										<h6 class="text-white p-1">Outstanding Amount</h6>
									</div>
								</div>
							</a>
						</div>
					</div>
				</fieldset>
				<div class="row">
					<fieldset class="form-inline col-md-12 col-lg-12 w-75" style="height: 160px;">
						<legend class="w-auto">Apps</legend>
						<div class="row" style="width: 100%;">
							<div class="col-md-2 col-lg-2 col-xlg-2">
							<!-- <div class="pr-2" style="width:20%;"> -->
								<a href="password_manager">
									<div class="card card-hover">
										<div class="box bg-dark text-center">
											<h3 class="font-light text-white"><i class="mdi mdi-calendar-check"></i></h3>
											<h6 class="text-white">Password Manager</h6>
										</div>
									</div>
								</a>
							</div>
							<div class="col-md-2 col-lg-2 col-xlg-3">
							<!-- <div class="pr-2" style="width:20%;"> -->
								<a href="service_expense">
									<div class="card card-hover">
										<div class="box bg-success text-center">
											<h3 class="font-light text-white"><i class="mdi mdi-chart-areaspline"></i></h3>
											<h6 class="text-white">Task Manager</h6>
										</div>
									</div>
								</a>
							</div>

							<div class="col-md-2 col-lg-2 col-xlg-3">
							<!-- <div class="pr-2" style="width:20%;"> -->
								<a href="service_contra">
									<div class="card card-hover">
										<div class="box bg-danger text-center">
											<h3 class="font-light text-white"><i class="mdi mdi-view-dashboard"></i></h3>
											<h6 class="text-white">Payroll</h6>
										</div>
									</div>
								</a>
							</div>
							<div class="col-md-2 col-lg-2 col-xlg-3">
							<!-- <div class="pr-2" style="width:20%;"> -->
								<a href="service_report">
									<div class="card card-hover">
										<div class="box bg-info text-center">
											<h3 class="font-light text-white"><i class="mdi mdi-border-outside"></i></h3>
											<h6 class="text-white">Chats</h6>
										</div>
									</div>
								</a>
							</div>
							<div class="col-md-2 col-lg-2 col-xlg-3">
							<!-- <div class="pr-2" style="width:20%;"> -->
								<a href="finance_report">
									<div class="card card-hover">
										<div class="box bg-cyan text-center">
											<h3 class="font-light text-white"><i class="mdi mdi-receipt"></i></h3>
											<h6 class="text-white">Contacts</h6>
										</div>
									</div>
								</a>
							</div>
							<div class="col-md-2 col-lg-2 col-xlg-3">
							<!-- <div class="pr-2" style="width:20%;"> -->
								<a href="advance_balance">
									<div class="card card-hover">
										<div class="box bg-cyan text-center">
											<h3 class="font-light text-white"><i class="mdi mdi-view-dashboard"></i></h3>
											<h6 class="text-white">Advance</h6>
										</div>
									</div>
								</a>
							</div>
						</div>
					</fieldset>
					<!-- <fieldset class="form-inline col-md-2 col-lg-2" style="height: 160px;">
						<legend class="w-auto">Clients</legend>
						<div class="row" style="width: 100%;">
							<div class="col-md-12 col-lg-12 col-xlg-12">
								<a href="client_master">
									<div class="card card-hover">
										<div class="box bg-cyan text-center">
											<h3 class="font-light text-white"><i class="mdi mdi-view-dashboard"></i></h3>
											<h6 class="text-white">Advance</h6>
										</div>
									</div>
								</a>
							</div>
						</div>
					</fieldset> -->
				</div>
			<?php } ?>
			<!-- Column -->
			<!-- Column -->
		</div>
		<?php if ($_SESSION['user_type'] == 'client_user') { ?>
			<div class="bs-example col-lg-12 col-md-12 d-block" id="transaction_reportDIV">
				<ul class="nav nav-tabs">
					<li class="nav-item pr-2">
						<a href="#ServicePayments" id="ServicePayments_Link" class="nav-link internalTab active" data-toggle="tab">Outstanding Records</a>
					</li>
					<li class="nav-item pr-2">
						<a href="#ServicePaymentComplete" id="ServicePaymentComplete_Link" class="nav-link internalTab" data-toggle="tab">Settled Records</a>
					</li>
				</ul>
				<div class="tab-content pr-4">
					<div class="tab-pane fade show active" id="ServicePayments">
						<h2 align="center" class="w-100">Outstanding Records</h2>
						<!-- <div id="showDscReseller" class="table-responsive d-block"></div> -->
						<div class="bs-example col-lg-12 col-md-12 d-none" id="clientTransaction_dataDIV">
							<div id="downloadLinkOutstanding" class="p-2 d-none">
								<td colspan='5' class='tableDate'>
									<form method='post' action='Download_ClientOutstanding_data'>
										<button type='submit' name='Download_ClientOutstanding_data' class='btn btn-primary m-1'><i class='fas fa-download'></i> Download Outstanding Report</button>
									</form>
									<!--form method='post' action='Download_invoice_report'>
										<button type='submit' name='Download_invoice_report' class='btn btn-primary m-1'><i class='fas fa-download'></i> Download Invoice Report</button>
									</form-->
									<!--button type="button" class='btn btn-primary d-inline' name="mailPDF" id='mailPDF'>Mail Report</button-->
									<!--div id="wait" style="display:none;width:69px;height:89px;border:1px solid black;position:absolute;left:50%;padding:2px;"><img src='Images/demo_wait.gif' width="64" height="64" /><br>Loading..</div-->
								</td>
							</div>
							<p class="text-right" id="pendingAmount"></p>
							<table id="clientTransactionTable" class="table"></table>
						</div>
					</div>
					<div class="tab-pane fade" id="ServicePaymentComplete">
						<h2 align="center" class="w-100">Settled Records</h2>
						<!-- <div id="showDscReseller" class="table-responsive d-block"></div> -->
						<div class="bs-example col-lg-12 col-md-12 d-none" id="Complete_clientTransaction_dataDIV">
							<!-- <p class="text-right" id="pendingAmount"></p> -->
							<div id="downloadLinkSettled" class="p-2 d-none">
								<td colspan='5' class='tableDate'>
									<form method='post' action='Download_ClientSettled_data'>
										<button type='submit' name='Download_ClientSettled_data' class='btn btn-primary m-1'><i class='fas fa-download'></i> Download Settled Report</button>
									</form>
									<!--form method='post' action='Download_invoice_report'>
										<button type='submit' name='Download_invoice_report' class='btn btn-primary m-1'><i class='fas fa-download'></i> Download Invoice Report</button>
									</form-->
									<!--button type="button" class='btn btn-primary d-inline' name="mailPDF" id='mailPDF'>Mail Report</button-->
									<!--div id="wait" style="display:none;width:69px;height:89px;border:1px solid black;position:absolute;left:50%;padding:2px;"><img src='Images/demo_wait.gif' width="64" height="64" /><br>Loading..</div-->
								</td>
							</div>
							<table id="Complete_clientTransactionTable" class="table"></table>
						</div>
					</div>
				</div>
			</div>
			<script>
				$(document).ready(function(){
					// $('#showDscReseller').load('html/serviceIncome_DataList.php').fadeIn("slow");
					// var recent_client_name = '<?php //echo $_SESSION['user_type']; ?>';
					var client_name = '<?php echo $_SESSION['username']; ?>';
					if (client_name != "") {
						$('#pleaseWaitDialog').modal('show');
						// alert(client_name);
						$.ajax({
							url:"html/ProcessServiceIncome.php",
							method:"post",
							data: {client_name:client_name},
							dataType:"text",
							success:function(data)
							{
								// alert(data);
								// $('#clientTransaction_dataDIV').removeClass('d-none');
								// $('#clientTransaction_dataDIV').addClass('d-block');
								// $('#clientTransactionTable').html(data);
								var array = JSON.parse(data);
								// alert(array[2]);
								if (array[0] != "<tr style='text-align:center;'><td colspan='4'>No Record Found!</td></tr>") {
									$('#clientTransaction_dataDIV').removeClass('d-none');
									$('#clientTransaction_dataDIV').addClass('d-block');
									$('#downloadLinkOutstanding').removeClass('d-none');
									$('#downloadLinkOutstanding').addClass('d-block');
									$('#clientTransactionTable').html(array[0]);
									$('#clientTransactionTable').DataTable({
										pagingType: "full_numbers",
										"bDestroy": true,
										"order": [[ 0, "DESC" ]]
									});
									// $('#pendingAmountMainPara').removeClass('d-none');
									// $('#pendingAmountMainPara').addClass('d-block');
									$('#pendingAmount').html('Pending Amount : ' + array[1].toFixed(2)).css({'color':'red','font-size':'16px'});
								}else{
									$('#clientTransaction_dataDIV').removeClass('d-none');
									$('#clientTransaction_dataDIV').addClass('d-block');
									$('#downloadLinkOutstanding').removeClass('d-block');
									$('#downloadLinkOutstanding').addClass('d-none');
									$('#clientTransactionTable').html(array[0]);
									// $('#pendingAmountMainPara').removeClass('d-block');
									// $('#pendingAmountMainPara').addClass('d-none');
									$('#pendingAmount').html('');
								}
								// Complete Payments
								if (array[2] != "<tr style='text-align:center;'><td colspan='4'>No Record Found!</td></tr>") {
									$('#Complete_clientTransaction_dataDIV').removeClass('d-none');
									$('#Complete_clientTransaction_dataDIV').addClass('d-block');
									$('#downloadLinkSettled').removeClass('d-none');
									$('#downloadLinkSettled').addClass('d-block');
									$('#Complete_clientTransactionTable').html(array[2]);
									$('#Complete_clientTransactionTable').DataTable({
										pagingType: "full_numbers",
										"bDestroy": true,
										"order": [[ 0, "DESC" ]]
									});
								}else{
									$('#Complete_clientTransaction_dataDIV').removeClass('d-none');
									$('#Complete_clientTransaction_dataDIV').addClass('d-block');
									$('#downloadLinkSettled').removeClass('d-block');
									$('#downloadLinkSettled').addClass('d-none');
									$('#Complete_clientTransactionTable').html(array[2]);
									// $('#pendingAmountMainPara').removeClass('d-block');
									// $('#pendingAmountMainPara').addClass('d-none');
									// $('#pendingAmount').html('');
								}
								$('#service_id').val('');
							},complete: function(){
								//$("#wait").css("display", "none");
								$('#pleaseWaitDialog').modal('hide');
								// $('#clientTransactionTable tbody tr').on('click', function(){
								/* $('#clientTransactionTable tbody tr #selctionServiceIdBtn').on('click', function(){
									// alert('roks');
									// alert($(this).find('#thisSeviceId').val());
									$('#service_id').val($(this).closest('tr').find('#thisSeviceId').val());
								}); */
							}
						});
					}else{
						$('#clientTransaction_dataDIV').removeClass('d-block');
						$('#clientTransaction_dataDIV').addClass('d-none');
						$('#clientTransactionTable').html('');
					}
				});
			</script>
		<?php } ?>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script type="text/javascript">
		$(document).ready(function () {
			$('#outstandingTable').DataTable({
				pagingType: "full_numbers",
				"bDestroy": true
				// "order": [[ 0, "DESC" ]]
			});
			$(document).on('click', '#outstandingTable tbody tr #notifyClient', function(e){
				// alert('roks');
				// alert($(this).find('#thisSeviceId').val());
				var row_indexDEL = $(this).closest('tr');
				var Temp_ClientName = row_indexDEL.find('#Temp_ClientName').val();
				var Temp_DueBalance = row_indexDEL.find('#Temp_DueBalance').val();
				// alert(Temp_DueBalance);
				$('#pleaseWaitDialog').modal('show');
				$.ajax({
					url:"html/ProcessDashboard.php",
					method:"post",
					data: {ClientName:Temp_ClientName, DueBalance:Temp_DueBalance},
					dataType:"text",
					success:function(data)
					{
						// alert(data);
						if (data == "client_notified") {
							window.createNotification({
								closeOnClick: true,
								displayCloseButton: true,
								positionClass: "nfc-top-right",
								showDuration: 3000,
								theme: "success"
							})({
								title: "Congratulations",
								message: "Nofied successfully"
							});
						}
					},complete: function (data) {
						$('#pleaseWaitDialog').modal('hide');
					}
				});
				// $('#service_id').val($(this).closest('tr').find('#thisSeviceId').val());
				// $('#amount_creditedIn').val('CASH');
				// $('#amount').prop('max',$(this).closest('tr').find('#thisAmount').val().replace(/,/g, ''));
			});
		});
    	$({someValue: 0}).stop(true).animate({someValue: $(".client-to-grow").data("end")}, {
	        duration : 4000,
	        easing: "swing",
	        step: function () {  
	            var displayVal = Math.round(this.someValue);
	            $(".client-to-grow").text(displayVal);
	        }
	    }).promise().done(function () {
	        $(".client-to-grow").text($(".client-to-grow").data("end"));
	    });
    	
		$({someValue: 0}).stop(true).animate({someValue: $(".advance-to-grow").data("end")}, {
	        duration : 4000,
	        easing: "swing",
	        step: function () {  
	            var displayVal = Math.round(this.someValue);
	            $(".advance-to-grow").text(displayVal);
	        }
	    }).promise().done(function () {
	        $(".advance-to-grow").text($(".advance-to-grow").data("end"));
	    });

	    $({someValue: 0}).stop(true).animate({someValue: $(".vendor-to-grow").data("end")}, {
	        duration : 4000,
	        easing: "swing",
	        step: function () {  
	            var displayVal = Math.round(this.someValue);
	            $(".vendor-to-grow").text(displayVal);
	        }
	    }).promise().done(function () {
	        $(".vendor-to-grow").text($(".vendor-to-grow").data("end"));
	    });

	    $({someValue: 0}).stop(true).animate({someValue: $(".gst-to-grow").data("end")}, {
	        duration : 4000,
	        easing: "swing",
	        step: function () {
	            var displayVal = Math.round(this.someValue);
	            $(".gst-to-grow").text(displayVal);
	        }
	    }).promise().done(function () {
	        $(".gst-to-grow").text($(".gst-to-grow").data("end"));
	    });

	    $({someValue: 0}).stop(true).animate({someValue: $(".itReturns-to-grow").data("end")}, {
	        duration : 4000,
	        easing: "swing",
	        step: function () {  
	            var displayVal = Math.round(this.someValue);
	            $(".itReturns-to-grow").text(displayVal);
	        }
	    }).promise().done(function () {
	        $(".itReturns-to-grow").text($(".itReturns-to-grow").data("end"));
	    });

	    $({someValue: 0}).stop(true).animate({someValue: $(".audit-to-grow").data("end")}, {
	        duration : 4000,
	        easing: "swing",
	        step: function () {  
	            var displayVal = Math.round(this.someValue);
	            $(".audit-to-grow").text(displayVal);
	        }
	    }).promise().done(function () {
	        $(".audit-to-grow").text($(".audit-to-grow").data("end"));
	    });

	    $({someValue: 0}).stop(true).animate({someValue: $(".pan-to-grow").data("end")}, {
	        duration : 4000,
	        easing: "swing",
	        step: function () {  
	            var displayVal = Math.round(this.someValue);
	            $(".pan-to-grow").text(displayVal);
	        }
	    }).promise().done(function () {
	        $(".pan-to-grow").text($(".pan-to-grow").data("end"));
	    });

	    $({someValue: 0}).stop(true).animate({someValue: $(".tan-to-grow").data("end")}, {
	        duration : 4000,
	        easing: "swing",
	        step: function () {  
	            var displayVal = Math.round(this.someValue);
	            $(".tan-to-grow").text(displayVal);
	        }
	    }).promise().done(function () {
	        $(".tan-to-grow").text($(".tan-to-grow").data("end"));
	    });

	    $({someValue: 0}).stop(true).animate({someValue: $(".e_Tds-to-grow").data("end")}, {
	        duration : 4000,
	        easing: "swing",
	        step: function () {  
	            var displayVal = Math.round(this.someValue);
	            $(".e_Tds-to-grow").text(displayVal);
	        }
	    }).promise().done(function () {
	        $(".e_Tds-to-grow").text($(".e_Tds-to-grow").data("end"));
	    });

	    $({someValue: 0}).stop(true).animate({someValue: $(".dsc_Subscriber-to-grow").data("end")}, {
	        duration : 4000,
	        easing: "swing",
	        step: function () {  
	            var displayVal = Math.round(this.someValue);
	            $(".dsc_Subscriber-to-grow").text(displayVal);
	        }
	    }).promise().done(function () {
	        $(".dsc_Subscriber-to-grow").text($(".dsc_Subscriber-to-grow").data("end"));
	    });

	    $({someValue: 0}).stop(true).animate({someValue: $(".dsc_Reseller-to-grow").data("end")}, {
	        duration : 4000,
	        easing: "swing",
	        step: function () {  
	            var displayVal = Math.round(this.someValue);
	            $(".dsc_Reseller-to-grow").text(displayVal);
	        }
	    }).promise().done(function () {
	        $(".dsc_Reseller-to-grow").text($(".dsc_Reseller-to-grow").data("end"));
	    });

	    $({someValue: 0}).stop(true).animate({someValue: $(".Psp_Distribution-to-grow").data("end")}, {
	        duration : 4000,
	        easing: "swing",
	        step: function () {  
	            var displayVal = Math.round(this.someValue);
	            $(".Psp_Distribution-to-grow").text(displayVal);
	        }
	    }).promise().done(function () {
	        $(".Psp_Distribution-to-grow").text($(".Psp_Distribution-to-grow").data("end"));
	    });

	    $({someValue: 0}).stop(true).animate({someValue: $(".Psp_Consumption-to-grow").data("end")}, {
	        duration : 4000,
	        easing: "swing",
	        step: function () {  
	            var displayVal = Math.round(this.someValue);
	            $(".Psp_Consumption-to-grow").text(displayVal);
	        }
	    }).promise().done(function () {
	        $(".Psp_Consumption-to-grow").text($(".Psp_Consumption-to-grow").data("end"));
	    });

	    $({someValue: 0}).stop(true).animate({someValue: $(".income-to-grow").data("end")}, {
	        duration : 4000,
	        easing: "swing",
	        step: function () {  
	            var displayVal = Math.round(this.someValue);
	            $(".income-to-grow").text(displayVal);
	        }
	    }).promise().done(function () {
	        $(".income-to-grow").text($(".income-to-grow").data("end"));
	    });

	    $({someValue: 0}).stop(true).animate({someValue: $(".expense-to-grow").data("end")}, {
	        duration : 4000,
	        easing: "swing",
	        step: function () {  
	            var displayVal = Math.round(this.someValue);
	            $(".expense-to-grow").text(displayVal);
	        }
	    }).promise().done(function () {
	        $(".expense-to-grow").text($(".expense-to-grow").data("end"));
	    });

	    $({someValue: 0}).stop(true).animate({someValue: $(".notes-to-grow").data("end")}, {
	        duration : 4000,
	        easing: "swing",
	        step: function () {  
	            var displayVal = Math.round(this.someValue);
	            $(".notes-to-grow").text(displayVal);
	        }
	    }).promise().done(function () {
	        $(".notes-to-grow").text($(".notes-to-grow").data("end"));
	    });

	    $({someValue: 0}).stop(true).animate({someValue: $(".reminder-to-grow").data("end")}, {
	        duration : 4000,
	        easing: "swing",
	        step: function () {  
	            var displayVal = Math.round(this.someValue);
	            $(".reminder-to-grow").text(displayVal);
	        }
	    }).promise().done(function () {
	        $(".reminder-to-grow").text($(".reminder-to-grow").data("end"));
	    });

	    $({someValue: 0}).stop(true).animate({someValue: $(".passwordManager-to-grow").data("end")}, {
	        duration : 4000,
	        easing: "swing",
	        step: function () {  
	            var displayVal = Math.round(this.someValue);
	            $(".passwordManager-to-grow").text(displayVal);
	        }
	    }).promise().done(function () {
	        $(".passwordManager-to-grow").text($(".passwordManager-to-grow").data("end"));
	    });
    </script>
</body>
</html>
<?php
	include_once 'ltr/header-footer.php';
?>
<script type="text/javascript" src="//cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="//cdn.datatables.net/1.11.3/js/dataTables.bootstrap4.min.js"></script>