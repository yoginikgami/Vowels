<style>
.heading{
    height: 10px;
    
    background: #e5d2f1;
    position: sticky;
    top: 0;
}
.heading .txt{
    font-size: 12px;
    text-align:center;
    padding: 2px 2px 2px 2px;
}
.tableRecords{
    text-align:center;
}

.WrapText{
    
    white-space: nowrap;
        text-overflow: clip;
    inline-size:50px;
    overflow:hidden;
    font-size: 12px;
}
.ttext{
    font-size: 12px;
}
</style>
<?php
session_start();
include_once 'connection.php';

if (isset($_POST['pageno'])) {
	$pageno = $_POST['pageno'];
} else {
	$pageno = 1;
}

if (isset($_POST['no_of_records_per_page'])) {
	$no_of_records_per_page = $_POST['no_of_records_per_page'];
} else {
	$no_of_records_per_page = 10;
}
//echo $pageno;
$offset = ($pageno - 1) * $no_of_records_per_page;

if ($_SESSION['user_type'] == 'system_user') {
		$total_pages_sql = "SELECT COUNT(*) FROM `retail_invoice` WHERE `company_id` = '" . $_SESSION['company_id'] . "'";
} else {
	$total_pages_sql = "SELECT COUNT(*) FROM `retail_invoice` WHERE `company_id` = '" . $_SESSION['company_id'] . "' AND `client_name` = '" . $_SESSION['username'] . "' and `client_id`='".$_SESSION['service_id']."'";
}
$result = mysqli_query($con, $total_pages_sql);
$total_rows = mysqli_fetch_array($result)[0];
$total_pages = ceil($total_rows / $no_of_records_per_page);

if (isset($_SESSION['company_id'])) {
    $company_id = $_SESSION['company_id'];
    // Fetch user data for the given company ID and user ID
    $fetch_user_data = "SELECT * FROM `users` WHERE `company_id` = '$company_id' AND `id` = '" . $_SESSION['user_id'] . "'";
    $run_fetch_user_data = mysqli_query($con, $fetch_user_data);
    $permission_row = mysqli_fetch_array($run_fetch_user_data);
}
$sections = [];
if(($permission_row['type']== 1) || ($permission_row['document_records'] == 1))
{
    $sections[] = 'document_records';
}
?>
<!-- Custom Excel-Filter CSS -->
<link href="dist/css/excel-bootstrap-table-filter-style.css" rel="stylesheet">
<!-- Custom Excel-Filter JS -->
<script src="dist/js/excel-bootstrap-table-filter-bundle.js"></script>

<input type="hidden" name="currentPageno" id="currentPageno" value="<?php echo $pageno; ?>">
<input type="hidden" id="first" name="first" value="1">
<input type="hidden" id="Incomeprev" name="Incomeprev" value="<?php if ($pageno <= 1) {
																	echo '1';
																} else {
																	echo ($pageno - 1);
																} ?>">
<input type="hidden" id="IncomeNext" name="IncomeNext" value="<?php if ($pageno >= $total_pages) {
																	echo $total_pages;
																} else {
																	echo ($pageno + 1);
																} ?>">
<input type="hidden" id="IncomeLast" name="IncomeLast" value="<?= $total_pages ?>">

<!--Delete Confirm Popup-->
<div class="modal fade" data-backdrop="static" data-keyboard="false" id="pass_ManagerConfirmMessagePopup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<form method="post" action="password_manager">
				<div class="modal-header">
					<img src="html/images/logo.png" alt="Vyaya" style="width: 150px; height: 55px;" class="logo navbar-brand mr-auto">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body bg-light">
					<!--input type="hidden" name="pageno" id="pageno" value="<?php //echo $pageno; 
																				?>"-->
					<input type="hidden" id="tempPass_ManagerIDdel" name="tempPass_ManagerIDdel" class="tempPass_ManagerIDdel">
					<?php echo "<p>Do You Really Want To Delete This Record ?</p>"; ?>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">NO</button>
					<button type="submit" name="passMng_delete" id="passMng_delete" class="btn btn-vowel">YES</button>
				</div>
			</form>
		</div>
	</div>
</div>
<div class="container-fluid" id="No_ofshowRecord">
	<form method="post" action="gst" class="form-inline p-1">
		<?php
		if (isset($_POST['page']))    ?>
		<input type="hidden" name="page" id="page" value="<?= $page; ?>">
		<div class="showRecordsDiv">
			<label class="showRecordsLabels d-inline-block">Show &nbsp;</label>
			<select class="form-control" name="no_of_records_per_page" id="no_of_records_per_page">
                <!--<option <?php if(isset($_POST['no_of_records_per_page'])) if ($_POST['no_of_records_per_page'] == 5) echo 'selected'; ?> value="5">5</option>-->
                <option <?php if(isset($_POST['no_of_records_per_page'])) if ($_POST['no_of_records_per_page'] == 10) echo 'selected'; ?> value="10">10</option>
                <!--<option <?php if(isset($_POST['no_of_records_per_page'])) if ($_POST['no_of_records_per_page'] == 15) echo 'selected'; ?> value="15">15</option>-->
                <option <?php if(isset($_POST['no_of_records_per_page'])) if ($_POST['no_of_records_per_page'] == 25) echo 'selected'; ?> value="25">25</option>
                <option <?php if(isset($_POST['no_of_records_per_page'])) if ($_POST['no_of_records_per_page'] == 50) echo 'selected'; ?> value="50">50</option>
                <option <?php if(isset($_POST['no_of_records_per_page'])) if ($_POST['no_of_records_per_page'] == 100) echo 'selected'; ?> value="100">100</option>
                <option <?php if(isset($_POST['no_of_records_per_page'])) if ($_POST['no_of_records_per_page'] == '500') echo 'selected'; ?> value="500">500</option>
            </select>
			<label class="showRecordsLabels d-inline-block">&nbsp; Records</label>
		</div>

	</form>
</div>
<div class="table-responsive d-block showDataTable" id="dataTable_gst">
	<?php
	if (isset($_POST['search'])) {
		$search = $_POST['search'];
		if ($_SESSION['user_type'] == 'system_user') {
				$fetch_dsc_data = "SELECT * FROM `retail_invoice` WHERE `company_id` = '" . $_SESSION['company_id'] . "' AND (reference_number LIKE '%$search%' OR billing_date LIKE '%$search%' OR category LIKE '%$search%' OR client_name LIKE '%$search%' OR gst_number LIKE '%$search%' OR service_id LIKE '%$search%' OR retailable_amount LIKE '%$search%' OR total_retail_value LIKE '%$search%') ORDER BY `retail_invoice_number` DESC LIMIT $offset, $no_of_records_per_page";
		}else{
			$fetch_dsc_data = "SELECT * FROM `retail_invoice` WHERE `company_id` = '" . $_SESSION['company_id'] . "' AND (reference_number LIKE '%$search%' OR billing_date LIKE '%$search%' OR category LIKE '%$search%' OR client_name LIKE '%$search%' OR gst_number LIKE '%$search%' OR service_id LIKE '%$search%' OR retailable_amount LIKE '%$search%' OR total_retail_value LIKE '%$search%') AND `client_name` = '".$_SESSION['username']."' and `client_id`='".$_SESSION['service_id']."' ORDER BY `retail_invoice_number` DESC LIMIT $offset, $no_of_records_per_page";
		}
		$run_dsc_data = mysqli_query($con, $fetch_dsc_data);
		$rows = mysqli_num_rows($run_dsc_data);
		$regularData = false;
	} else {
		if ($_SESSION['user_type'] == 'system_user') {
				$fetch_dsc_data = "SELECT * FROM `retail_invoice` WHERE `company_id` = '" . $_SESSION['company_id'] . "' ORDER BY `retail_invoice_number` DESC LIMIT $offset, $no_of_records_per_page";
		}else{
			$fetch_dsc_data = "SELECT * FROM `retail_invoice` WHERE `company_id` = '".$_SESSION['company_id']."' AND `client_name` = '".$_SESSION['username']."' and `client_id`='".$_SESSION['service_id']."' ORDER BY `retail_invoice_number` DESC LIMIT $offset, $no_of_records_per_page";
		}
		$run_dsc_data = mysqli_query($con, $fetch_dsc_data);
		$rows = mysqli_num_rows($run_dsc_data);
		$regularData = true;
	}
	if ($rows > 0) {
        $count = 0;
        $showColumn = false;

        // Check if 'document_records' exists in $sections
        foreach ($sections as $section) {
            if ($section == 'document_records') {
                $showColumn = true;
                break;
            }
        }
		echo "<script type='text/javascript'>
		    	$('#pagination').removeClass('d-none');
				$('#pagination').addClass('d-block');
		    </script>";
	?>
		<div class="d-block" id="selectedRecordsDIV"></div>
		<table class="table-striped" id="gstTable" style="width:100%;">
			<thead class="bg-white" style="top: 0; position: sticky;">
				<tr class="heading">
					<?php if ($_SESSION['user_type'] == 'system_user') { ?>
						<th class="tableDate">Action</th>
						<?php if ($showColumn) { ?>
						<th>Send Invoice</th>
					<?php } }?>
					<th class="tableDate">DRI</th>
					<!-- <td style="font-weight: bold;" class="tableDate">Delete</td> -->
					<th class="txt">IN</th>
					<th class="txt">RN</th>
					<th class="txt">Date</th>
					<th class="txt">Category</th>
					<th class="txt">Drawee</th>
					<th class="txt">Client Name</th>
					<th class="txt">GST Number</th>
					<th class="txt">Service Id(s)</th>
					<th class="txt">Total Value (₹)</th>
					<th class="txt">Modify By</th>
					<!--<th class="txt">Modify Date</th>-->
				</tr>
			</thead>
			<tbody>
				<?php
				while ($row = mysqli_fetch_array($run_dsc_data)) { ?>
					<p><?php ++$count; ?></p>
					<tr>
						<?php if ($_SESSION['user_type'] == 'system_user') { ?>
							<?php if($showColumn) {?>
							<td class="d-flex">
								<form method="post">
									<input type="hidden" readonly name="gstDeleteID" id="gstDeleteID" value="<?= $row['id']; ?>"><span data-toggle="modal" data-target="#gstConfirmMessagePopup"><button type="button" name="gstDeletebtn" class="gstDeletebtn mr-2" id="gstDeletebtn" data-toggle="tooltip" data-placement="top" title="Delete" style="padding: 0;border: none;background: none; outline:none; color: red;"><i class="fas fa-times fa-lg"></i></button></span>
								</form>	
								<button type="button" class="viewButton" data-toggle="modal" data-target="#exampleModal1" data-emp-id="<?php echo $row['retail_invoice_number']; ?>"  style="border: none;">
                                    <i class="fas fa-eye fa-lg bg-vowel"></i>
                                </button></td>
							</td>
							<td>
								<form method="post">
									<input type="hidden" name="RetailInvoiceWhatsAppID" id="RetailInvoiceWhatsAppID" value="<?= $row['id']; ?>">
									<input type="hidden" name="RetailInvoiceClientID" id="RetailInvoiceClientID" value="<?= $row['client_id']; ?>">
									<input type="hidden" name="RetailInvoiceCategory" id="RetailInvoiceCategory" value="<?= $row['category']; ?>">
                                    <span><button type="button" name="gstWhatsAppbtn" class="gstWhatsAppbtn" id="gstWhatsAppbtn" <?php if(($_SESSION['accessToken'] != "invalid") && ($_SESSION['endpoint'] != "invalid")){ ?>
                                            data-toggle="tooltip" data-placement="top" title="Send Invoice on WhatsApp" <?php } ?>
                                            style="padding: 0;border: none;background: none; outline:none; color: green;"><i
                                            class="fab fa-whatsapp fa-lg"></i></button></span>
									<span><button type="button" name="gstGmailbtn" class="gstGmailbtn" id="gstGmailbtn" data-toggle="tooltip" data-placement="top" title="Send Invoice on Gmail" style="padding: 0;border: none;background: none; outline:none; color: red;"><i class="far fa-envelope fa-lg"></i></button></span>
								</form>
							</td>
						<?php }} ?>
						<td>
							<form class="d-inline" method='post' action='Download_RetailInvoice' target="_blank">
								<input type="hidden" readonly name="client_name" id="client_name" value="<?php echo $row['client_name']; ?>">
								<input type="hidden" readonly name="retail_invoice_number" id="retail_invoice_number" value="<?php echo $row['retail_invoice_number']; ?>">
								<input type="hidden" readonly name="reference_number" id="reference_number" value="<?php echo $row['reference_number']; ?>">
								<input type="hidden" readonly name="billing_date" id="billing_date" value="<?php echo $row['billing_date']; ?>">
								<input type="hidden" readonly name="service_id" id="service_id" value="<?php echo $row['service_id']; ?>">
								<input type="hidden" readonly name="drawee" id="drawee" value="<?php echo $row['drawee']; ?>">
								<button type='submit' name='Download_RetailInvoice' class="btn btn-link"><i class='fas fa-download text-center'></i></button>
								<!-- <a href='Download_RetailInvoice' target='_blank' id='downloadPDF' class="btn btn-link"><i class='fas fa-download text-center'></i></a> -->
							</form>
						</td>
						<td class="ttext"><?= $row['retail_invoice_number']; ?></td>
						<td class="ttext"><?= $row['reference_number']; ?></td>
						<td class="WrapText"><?= $row['billing_date']; ?></td>
						<td class="ttext"><?= $row['category']; ?></td>
						<td class="ttext"><?= $row['drawee']; ?></td>
						<td class="ttext"><?= $row['client_name']; ?></td>
						<td class="ttext"><?= $row['gst_number']; ?></td>
						<td class="ttext">
							<?php
								if ($row['service_id'] != '') {
									$firstComma = explode(",", $row['service_id']);
									// print_r($firstComma);
									foreach ($firstComma as $AfterCommaValue) {
										$firstUnderscore = explode("_", $AfterCommaValue);
										if ($firstComma != 'ADV_PMT') {
											if ($firstUnderscore[1] == 'CLM') {
												$fetchIdForServiceId = "SELECT * FROM `client_master` WHERE `transaction_id` = '".$AfterCommaValue."'";
												$ViewPageForServiceId = 'View_ClientMaster';
											}else if ($firstUnderscore[1] == 'GST') {
												$fetchIdForServiceId = "SELECT * FROM `gst_fees` WHERE `transaction_id` = '".$AfterCommaValue."'";
												$ViewPageForServiceId = 'View_GstFees';
											}else if ($firstUnderscore[1] == 'ADV') {
												$fetchIdForServiceId = "SELECT * FROM `advocade_case` WHERE `transaction_id` = '".$AfterCommaValue."'";
												$ViewPageForServiceId = 'View_Advocate';
											}else if ($firstUnderscore[1] == 'ITR') {
											 	$fetchIdForServiceId = "SELECT * FROM `it_returns` WHERE `transaction_id` = '".$AfterCommaValue."'";
												$ViewPageForServiceId = 'View_ItReturns';
											}else if ($firstUnderscore[1] == 'PAN') {
												$fetchIdForServiceId = "SELECT * FROM `pan` WHERE `transaction_id` = '".$AfterCommaValue."'";
												$ViewPageForServiceId = 'View_Pan';
											}else if ($firstUnderscore[1] == 'TAN') {
											 	$fetchIdForServiceId = "SELECT * FROM `tan` WHERE `transaction_id` = '".$AfterCommaValue."'";
												$ViewPageForServiceId = 'View_Tan';
											}else if ($firstUnderscore[1] == 'TSL') {
											 	$fetchIdForServiceId = "SELECT * FROM `sales` WHERE `transaction_id` = '".$AfterCommaValue."'";
												$ViewPageForServiceId = 'View_Sales';
											}else if ($firstUnderscore[1] == 'TDS') {
												$fetchIdForServiceId = "SELECT * FROM `e_tds` WHERE `transaction_id` = '".$AfterCommaValue."'";
												$ViewPageForServiceId = 'View_ETds';
											}else if ($firstUnderscore[1] == 'TRD') {
												 $fetchIdForServiceId = "SELECT * FROM `trade_mark` WHERE `transaction_id` = '".$AfterCommaValue."'";
												$ViewPageForServiceId = 'View_Trade_mark';
											}else if ($firstUnderscore[1] == 'PTN') {
												 $fetchIdForServiceId = "SELECT * FROM `patent` WHERE `transaction_id` = '".$AfterCommaValue."'";
												$ViewPageForServiceId = 'View_patent';
											}else if ($firstUnderscore[1] == 'IDS') {
												 $fetchIdForServiceId = "SELECT * FROM `industrial_design` WHERE `transaction_id` = '".$AfterCommaValue."'";
												$ViewPageForServiceId = 'View_industrial_design';
											}else if ($firstUnderscore[1] == 'COP') {
												 $fetchIdForServiceId = "SELECT * FROM `copy_right` WHERE `transaction_id` = '".$AfterCommaValue."'";
												$ViewPageForServiceId = 'View_copy_right';
											}else if ($firstUnderscore[1] == 'TRS') {
												 $fetchIdForServiceId = "SELECT * FROM `trade_secret` WHERE `transaction_id` = '".$AfterCommaValue."'";
												$ViewPageForServiceId = 'View_tradesecret';
											}else if ($firstUnderscore[1] == 'PSP') {
												$fetchIdForServiceId = "SELECT * FROM `psp` WHERE `transaction_id` = '".$AfterCommaValue."'";
												$ViewPageForServiceId = 'View_PspDistribution';
											}else if ($firstUnderscore[1] == 'DA') {
												$fetchIdForServiceId = "SELECT * FROM `dsc_subscriber` WHERE `transaction_id` = '".$AfterCommaValue."'";
												$ViewPageForServiceId = 'View_DscApplicant';
											}else if ($firstUnderscore[1] == 'DP') {
												$fetchIdForServiceId = "SELECT * FROM `dsc_reseller` WHERE `transaction_id` = '".$AfterCommaValue."'";
												$ViewPageForServiceId = 'View_DscPartner';
											}else if ($firstUnderscore[1] == 'DT') {
												$fetchIdForServiceId = "SELECT * FROM `dsc_token` WHERE `transaction_id` = '".$AfterCommaValue."'";
												$ViewPageForServiceId = 'View_TokenUsage';
											}else if ($firstUnderscore[1] == 'TND') {
												$fetchIdForServiceId = "SELECT * FROM `e_tender` WHERE `transaction_id` = '".$AfterCommaValue."'";
												$ViewPageForServiceId = 'View_Etender';
											}else if ($firstUnderscore[1] == 'OS') {
												$fetchIdForServiceId = "SELECT * FROM `other_services` WHERE `transaction_id` = '".$AfterCommaValue."'";
												$ViewPageForServiceId = 'View_OtherService';
											}else if ($firstUnderscore[1] == '24G') {
												$fetchIdForServiceId = "SELECT * FROM `24g` WHERE `transaction_id` = '".$AfterCommaValue."'";
												$ViewPageForServiceId = 'View_24G';
											}
											$run_fetchIdForServiceId = mysqli_query($con,$fetchIdForServiceId);
											$getIDForServiceId = mysqli_fetch_array($run_fetchIdForServiceId);
											
											if ($AfterCommaValue != 'ADV_PMT') { ?>
												<form action="<?= $ViewPageForServiceId; ?>" method="post" target="_blank" id="myform">
													<input type="hidden" readonly name="ViewID" value="<?= $getIDForServiceId['id']; ?>">
													 <button class="btn btn-link p-0"><?= $AfterCommaValue; ?>,</button> 
													<!--<a href="#" onclick="document.getElementById('myform').submit();"><?= $AfterCommaValue; ?>,</a>-->
												</form>
											<?php } else $AfterCommaValue;
										}
									}
								}
							?>
						</td>
						<!-- <td><?= $row['retailable_amount']; ?></td> -->
						<!-- <td><?= $row['gst_type']; ?></td>
						<td><?= $row['cgst_retail_percentage']; ?></td>
						<td><?= $row['cgst_retail_amount']; ?></td>
						<td><?= $row['sgst_retail_percentage']; ?></td>
						<td><?= $row['sgst_retail_amount']; ?></td>
						<td><?= $row['igst_retail_percentage']; ?></td>
						<td><?= $row['igst_retail_amount']; ?></td> -->
						<td class="ttext"><?= $row['total_retail_value']; ?></td>
						<td class="ttext"><?= $row['modify_by']; ?><br>
						<?= date('d-m-Y', strtotime($row['modify_date'])); ?></td>
					</tr>
				<?php   } ?>
			</tbody>
		</table>
		<input type="hidden" id="recordCount" name="recordCount" value="<?php echo $count; ?>">
</div>
<!-- Modal -->
<div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Service Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type='hidden' id='empIdModal1'>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Service ID</th>
                            <th>Portfolio</th>
                        </tr>
                    </thead>
                    <tbody id="modalTableBody">
                        <!-- Data rows will be added here dynamically -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('.viewButton').click(function() {
        var empId = $(this).data('emp-id'); // Get employee ID from button

        $('#empIdModal1').val(empId); // Store it in hidden field

        $.ajax({
            url: 'html/fetch_retails_invoice_service_id.php', 
            type: 'POST',
            data: { empId: empId },
            beforeSend: function() {
                $('#modalTableBody').html('<tr><td colspan="3">Loading...</td></tr>');
            },
            success: function(response) {
                console.log("Response:", response); // Debugging
                $('#modalTableBody').html(response);
                $('#exampleModal1').modal('show'); // Open modal after data is loaded
            },
            error: function(xhr, status, error) {
                console.error("Error:", error);
            }
        });
    });
});
</script>
<div class="pagination justify-content-left">
	<?php
		if (($offset + 1) != 1) {
			$count = $offset + $count;
		}

		if ($total_rows == $count) {
			echo "<script type='text/javascript'>
        		$('#prevLink').prop('disabled','disabled');
				$('#firstLink').prop('disabled','disabled');
				$('#prevLink').css('cursor','not-allowed');
				$('#firstLink').css('cursor','not-allowed');
		    	$('#nextLink').prop('disabled','disabled');
				$('#lastLink').prop('disabled','disabled');
				$('#nextLink').css('cursor','not-allowed');
				$('#lastLink').css('cursor','not-allowed');
		    </script>";
			//echo $count." rk ".$total_pages;
		} else if ($total_rows != $count) {
			echo "<script type='text/javascript'>
		    	$('#nextLink').prop('disabled',false);
				$('#lastLink').prop('disabled',false);
				$('#nextLink').css('cursor','pointer');
				$('#lastLink').css('cursor','pointer');
		    </script>";
		}
	?>
	<?php echo "<label style='font-weight: normal;' class='form-inline p-3'>Showing " . ($offset + 1) . " to " . $count . " of " . $total_rows . " Records</label>"; ?>
</div>
<?php  } else {
		if ($regularData == true) { ?>
	<div class="text-center">
		<p>No Record to show <?php if ($_SESSION['user_type'] == 'system_user') { ?><button type="button" class="btn btn-link" id="addNew_gst_link">Click here to add records</button><?php } ?></p>
	</div>
<?php echo "<script type='text/javascript'>
		    	$('#pagination').removeClass('d-block');
				$('#pagination').addClass('d-none');
				$('#No_ofshowRecord').removeClass('d-block');
				$('#No_ofshowRecord').addClass('d-none');
		    </script>";
		} else { ?>
	<div class="text-center">
		<p>No Record mathched!</p>
	</div>
<?php echo "<script type='text/javascript'>
		    	$('#pagination').removeClass('d-block');
				$('#pagination').addClass('d-none');
				$('#No_ofshowRecord').removeClass('d-block');
				$('#No_ofshowRecord').addClass('d-none');
		    </script>";
		}
	} ?>
<script type="text/javascript">
	$(function() {
		$('[data-toggle="tooltip"]').tooltip()
	})
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
		$('.table-striped tbody').on('click', '#gstDeletebtn', function() {
			//var recordID = $('#recordID').val();
			var row_indexDEL = $(this).closest('tr');
			var deleteID = row_indexDEL.find('#gstDeleteID').val();
			$('#tempGSTIDdel').val(deleteID);
		});
		
		// Send Invoice on Gmail
		$('.table-striped tbody').on('click', '#gstWhatsAppbtn', function() {
		    <?php if(($_SESSION['accessToken'] != "invalid") && ($_SESSION['endpoint'] != "invalid")){ ?>
			//var recordID = $('#recordID').val();
			var row_indexDEL = $(this).closest('tr');
			var GmailID = row_indexDEL.find('#RetailInvoiceWhatsAppID').val();
			var client_name = row_indexDEL.find('#client_name').val();
			var retail_invoice_number = row_indexDEL.find('#retail_invoice_number').val();
			var reference_number = row_indexDEL.find('#reference_number').val();
			var billing_date = row_indexDEL.find('#billing_date').val();
			var service_id = row_indexDEL.find('#service_id').val();
			var drawee =row_indexDEL.find('#drawee').val();
			let sendMail = false;
			var domain = "Retail Invoice";
            var template = "document_record_office1";
            var endPoint = "<?= $_SESSION['endpoint']; ?>";
            var apiProvider = "<?= $_SESSION['whatsapp_type']; ?>";
			var userResponse = window.confirm("Are you sure to send Whatsapp message to "+client_name+"?");
            if (userResponse) {
            // $('#loaderpopup').show();
			$.ajax({
				url: "html/whatsapi_RetailInvoice.php",
				method: "post",
				data: {
					client_name,
					retail_invoice_number,
					reference_number,
					billing_date,
					service_id,
					drawee,
					whatsapi_send:true,
				},
				dataType: "text",
				success: function(outerdata) {
				    try {
					    var jsonData = JSON.parse(outerdata);
					    var file_name  = retail_invoice_number+'_'+client_name;
    			        mobile = removeLeadingZero(jsonData.mobile_no);
                        mobile = mobile.replace(/\s/g, "");
                        if (apiProvider !== "local") {
                            if (containsCountryCode91(mobile)) {
                                mobile;
                            } else {
                                mobile = '91'+mobile;
                            }
				        }
                        if(jsonData.alert === "PDF File Created Successfully !!"){
                            if (apiProvider === "wati") {
                                sendWatiMessage(jsonData,template,endPoint,mobile);
                            } else if (apiProvider === "local") {
                                sendLocalMessage(jsonData,mobile);
                            } else {
                                alert("Whatsapp Support is not their");
                            }
                        }
				} catch (error) {
                        console.error('JSON parsing error:', error);
                    }
				}
			});
            }
			<?php } else { ?> alert('Whatsapp Support Is not their !'); <?php } ?>
		});
		

		// Send Invoice on Gmail
		$('.table-striped tbody').on('click', '#gstGmailbtn', function() {
			//var recordID = $('#recordID').val();
			var row_indexDEL = $(this).closest('tr');
			var GmailID = row_indexDEL.find('#RetailInvoiceWhatsAppID').val();
			var client_name = row_indexDEL.find('#client_name').val();
			var retail_invoice_number = row_indexDEL.find('#retail_invoice_number').val();
			var reference_number = row_indexDEL.find('#reference_number').val();
			var billing_date = row_indexDEL.find('#billing_date').val();
			var service_id = row_indexDEL.find('#service_id').val();
			var drawee =row_indexDEL.find('#drawee').val();
			alert(drawee);
			let sendMail = false;
            $('#loaderpopup').show();
			// Creating a PDF for the CLient and Storing on the server
			$.ajax({
				url: "html/CreateRetailInvoiceStoreProcess.php",
				method: "post",
				data: {
					client_name,
					retail_invoice_number,
					reference_number,
					billing_date,
					service_id,
					drawee
				},
				dataType: "text",
				success: function(outerdata) {
					// alert(outerdata);
					if (outerdata == 'File_Stored_On_Server') {
						$.ajax({
							url: "html/SendRetailInvoiceProcess.php",
							method: "post",
							data: {
								GmailID,
								client_name,
								retail_invoice_number,
								drawee
							},
							dataType: "text",
							success: function(data) {
								// alert(data);
								 $('#loaderpopup').hide();
								if (data == "client_notified") {
									swal({
                                      title: "Mail Send",
                                      icon: "success",
                                      button: "Close!",
                                    });
								}else{
								    swal({
                                      title: "Something went wrong!",
                                      icon: "success",
                                      button: "Close!",
                                    });
								}
							},
							complete: function() {
								//$("#wait").css("display", "none");
								$('#pleaseWaitDialog').modal('hide');
							}
						});
						// }
					}
				},
				complete: function() {
					//$("#wait").css("display", "none");
					$('#pleaseWaitDialog').modal('hide');
				}
			});

			// $('#tempGSTIDdel').val(deleteID);
		});

		$('.table-striped tbody').on('click', '#viewGSTDetailbtn', function() {
			//var recordID = $('#recordID').val();
			var row_indexDEL = $(this).closest('tr');
			var ViewID = row_indexDEL.find('#ViewID').val();
			$('#pleaseWaitDialog').modal('show');
			$.ajax({
				url: "html/ViewGSTFeesProcess.php",
				method: "post",
				data: {
					ViewID: ViewID
				},
				dataType: "text",
				success: function(data) {
					//alert(data);
					//$("#ViewModal_body").html(data);
					$("#showGSTWholeDetails").html(data);
					$("#showGSTWholeDetails").removeClass("d-none");
					$("#showGSTWholeDetails").addClass("d-block");
				},
				complete: function() {
					//$("#wait").css("display", "none");
					$('#pleaseWaitDialog').modal('hide');
				}
			});
		});
		$("#mainCheckbox").click(function() {
			if ($(this).prop("checked") == true) {
				$('td input:checkbox', '.table').prop('checked', this.checked);
				var checkedVal = [];
				var MultipledeleteID = [];
				$.each($("input[name='itemCheckBox']:checked"), function() {
					checkedVal.push($(this).val());
					var row_indexDEL = $(this).closest('tr');
					MultipledeleteID.push(row_indexDEL.find('#multipleDeleteID').val());
				});
				if (MultipledeleteID.length > 0) {
					$("#selectedRecordsDIV").html(MultipledeleteID.length + " Record(s) Selected");
				}
			} else {
				$('td input:checkbox', '.table').prop('checked', false);
				$("#selectedRecordsDIV").html("");
			}
		});
		$("#multipleDeletebtn").click(function() {
			var checkedVal = [];
			var MultipledeleteID = [];
			$.each($("input[name='itemCheckBox']:checked"), function() {
				checkedVal.push($(this).val());
				var row_indexDEL = $(this).closest('tr');
				MultipledeleteID.push(row_indexDEL.find('#multipleDeleteID').val());
			});
			if (MultipledeleteID.length == 0) {
				$("#DeleteConfirmMsg").empty();
				$("#DeleteConfirmMsg").html('Please select atleast one record..!');
				$("#bulk_delete_Yes").removeClass("d-block");
				$("#bulk_delete_Yes").addClass("d-none");
				$("#closeBtn").text("Close");
			} else {
				$("#DeleteConfirmMsg").empty();
				$("#DeleteConfirmMsg").html('Do You Really Want To Delete This Record(s) ?');
				$("#bulk_delete_Yes").removeClass("d-none");
				$("#bulk_delete_Yes").addClass("d-block");
				$("#closeBtn").text("No");
			}
			var totalArray = JSON.stringify(MultipledeleteID);
			$("#tempMultipleIDdel").val(totalArray);
			//$("#client_masterConfirmMessagePopup").modal("show");
		});
		$('.table-striped tbody').on('click', '#itemCheckBox', function() {
			var recordCount = $("#recordCount").val();
			if ($(this).prop("checked") == true) {
				var checkedVal = [];
				var MultipledeleteID = [];
				$.each($("input[name='itemCheckBox']:checked"), function() {
					checkedVal.push($(this).val());
					var row_indexDEL = $(this).closest('tr');
					MultipledeleteID.push(row_indexDEL.find('#multipleDeleteID').val());
				});
				$("#selectedRecordsDIV").html(MultipledeleteID.length + " Record(s) Selected");
				if (MultipledeleteID.length == recordCount) {
					$("#mainCheckbox").prop("checked", true);
				}
				//$('td input:checkbox','.table').prop('checked',this.checked);
			} else {
				var checkedVal = [];
				var MultipledeleteID = [];
				$.each($("input[name='itemCheckBox']:checked"), function() {
					checkedVal.push($(this).val());
					var row_indexDEL = $(this).closest('tr');
					MultipledeleteID.push(row_indexDEL.find('#multipleDeleteID').val());
				});
				if (MultipledeleteID.length > 0) {
					$("#selectedRecordsDIV").html(MultipledeleteID.length + " Record(s) Selected");
				} else {
					$("#selectedRecordsDIV").html("");
				}
				//$('td input:checkbox','.table').prop('checked',false);
				$("#mainCheckbox").prop("checked", false);
			}
		});
	});
	$("#no_of_records_per_page").change(function() {
		var no_of_records_per_page = $("#no_of_records_per_page").val();
		var first = $('#first').val();
		//alert(first);
		$.ajax({
			url: "html/showRetailInvoiceTable.php",
			method: "post",
			data: {
				pageno: first,
				no_of_records_per_page: no_of_records_per_page
			},
			dataType: "text",
			success: function(data) {
				//alert(data);
				//alert(first);
				$('#showRetailInvoiceTable').empty();
				$('#showRetailInvoiceTable').html(data);
				/*$('#prevLink').prop('disabled','disabled');
				$('#firstLink').prop('disabled','disabled');
				$('#prevLink').css('cursor','not-allowed');
				$('#firstLink').css('cursor','not-allowed');
				$('#nextLink').prop('disabled',false);
				$('#lastLink').prop('disabled',false);
				$('#nextLink').css('cursor','pointer');
				$('#lastLink').css('cursor','pointer');*/
			}
		});
	});
	/*$(function () {
      $('#gstTable').excelTableFilter();
    });*/
function sendWatiMessage(jsonData,template,endPoint,mobile) {
        const options = {
          method: 'POST',
          headers: {
            'content-type': 'text/json',
            Authorization: "<?= $_SESSION['accessToken']; ?>"
          },
          body: JSON.stringify({
            broadcast_name: 'document_record_office1',
            template_name: 'document_record_office1',
            parameters: [
              {
                name: 'pdflink',
                value: "<?= $_SESSION['location_path']; ?>"+'html/'+jsonData.path
              },
              {name: 'invoice_type', value: 'Retail Invoice'},
              {name: 'name', value: jsonData.client_name},
              {name: 'date', value: billing_date}
            ]
          })
        };
        
        fetch(endPoint+'/api/v1/sendTemplateMessage?whatsappNumber=9016043397', options)
              .then(response => response.json())
              .then(data => {
            // Access specific values from the JSON data
            const result = data.result;
            const mobile = data.phone_number;
            if(result === true){
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

async function sendLocalMessage(jsonData,mobile) {
    // API endpoint
    const apiUrl = "<?= $_SESSION['accessToken']; ?>";

    // API key, mobile number, and message content
    const apiKey = "<?= $_SESSION['endpoint']; ?>";
    // const mobileNumber = '9016043397';
    const message = jsonData.message;
    const image = "<?= $_SESSION['location_path']; ?>"+'html/'+jsonData.path;
    // Constructing the URL for the API request
    const apiRequestUrl = `${apiUrl}?apikey=${apiKey}&mobile=${mobile}&pdf=${image}`;
    const apiRequestUrl1 = `${apiUrl}?apikey=${apiKey}&mobile=${mobile}&msg=${encodeURIComponent(message)}`;
    // $('#gstWhatsAppbtn').click();
    swal({
      title: "Message Sent!",
      text: "WhatsApp message sent to "+mobile,
      icon: "success",
      button: "Close!",
    });

try {
    const response = await fetch(apiRequestUrl, { mode: 'no-cors' });
    const response1 = await fetch(apiRequestUrl1, { mode: 'no-cors' });
    
    if (!response.ok) {
        throw new Error(`HTTP error! Status: ${response.status}`);
    }

    console.log('API request was made, but CORS restrictions prevent accessing the response directly.');

    // Note: You won't be able to access response.json() or other response methods here.

} catch (error) {
    console.error('Error:', error);
}
}
</script>