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
	    $no_of_records_per_page = 5;
	}
	//echo $pageno;
	$offset = ($pageno-1) * $no_of_records_per_page; 
	//echo nl2br("\n".$offset);
	if ($_SESSION['user_type'] == 'system_user') {
		/* $fetch_Company_Query = "SELECT * FROM `controller_operator` WHERE `company_id` = '".$_SESSION['company_id']."' AND FIND_IN_SET('".$_SESSION['user_id']."',users_access_Pan)";
		$run_fetch_ControllerData = mysqli_query($con,$fetch_Company_Query);
		if (mysqli_num_rows($run_fetch_ControllerData) > 0) {
			// $row = mysqli_fetch_array($run_fetch_ControllerData);
			$total_pages_sql = "SELECT COUNT(*) FROM `users` WHERE `company_id` = '".$_SESSION['company_id']."'";
		}else{
			$client_access = [];
			$fetchAdminId = "SELECT * FROM `client_master` WHERE `company_id` = '".$_SESSION['company_id']."' AND FIND_IN_SET('".$_SESSION['user_id']."',users_access)";
			$runAdminId = mysqli_query($con,$fetchAdminId);
			while ($AdminIdrow = mysqli_fetch_array($runAdminId)) {
				array_push($client_access, "'".$AdminIdrow['client_name']."'");
			} */
			$total_pages_sql = "SELECT COUNT(*) FROM `users` WHERE `company_id` = '".$_SESSION['company_id']."'";
		// }
	}else{
		$total_pages_sql = "SELECT COUNT(*) FROM `users` WHERE `company_id` = '".$_SESSION['company_id']."'";
	}
	$result = mysqli_query($con,$total_pages_sql);
	$total_rows = mysqli_fetch_array($result)[0];
	$total_pages = ceil($total_rows / $no_of_records_per_page);
?>
<!-- Custom Excel-Filter CSS -->
<link href="dist/css/excel-bootstrap-table-filter-style.css" rel="stylesheet">
<!-- Custom Excel-Filter JS -->
<script src="dist/js/excel-bootstrap-table-filter-bundle.js"></script>

<input type="hidden" name="currentPageno" id="currentPageno" value="<?php echo $pageno; ?>">
<input type="hidden" id="first" name="first" value="1">
<input type="hidden" id="Incomeprev" name="Incomeprev" value="<?php if($pageno <= 1){ echo '1'; } else { echo ($pageno - 1); } ?>">
<input type="hidden" id="IncomeNext" name="IncomeNext" value="<?php if($pageno >= $total_pages) { echo $total_pages; } else { echo ($pageno + 1); } ?>">
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
          <!--input type="hidden" name="pageno" id="pageno" value="<?php //echo $pageno; ?>"-->
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
	<form method="post" action="client_master" class="form-inline p-1">
        <?php
            if(isset($_POST['page']))    ?>
                <input type="hidden" name="page" id="page" value="<?= $page; ?>">
        <div class="showRecordsDiv">
            <label class="showRecordsLabels d-inline-block">Show &nbsp;</label> 
            <select class="form-control" name="no_of_records_per_page" id="no_of_records_per_page">
                <option <?php if(isset($_POST['no_of_records_per_page'])) if ($_POST['no_of_records_per_page'] == 5) echo 'selected'; ?> value="5">5</option>
                <option <?php if(isset($_POST['no_of_records_per_page'])) if ($_POST['no_of_records_per_page'] == 10) echo 'selected'; ?> value="10">10</option>
                <option <?php if(isset($_POST['no_of_records_per_page'])) if ($_POST['no_of_records_per_page'] == 15) echo 'selected'; ?> value="15">15</option>
                <option <?php if(isset($_POST['no_of_records_per_page'])) if ($_POST['no_of_records_per_page'] == 20) echo 'selected'; ?> value="20">20</option>
                <option <?php if(isset($_POST['no_of_records_per_page'])) if ($_POST['no_of_records_per_page'] == 25) echo 'selected'; ?> value="25">25</option>
                <option <?php if(isset($_POST['no_of_records_per_page'])) if ($_POST['no_of_records_per_page'] == 30) echo 'selected'; ?> value="30">30</option>
                <option <?php if(isset($_POST['no_of_records_per_page'])) if ($_POST['no_of_records_per_page'] == '9999999') echo 'selected'; ?> value="9999999">All</option>
            </select>
            <label class="showRecordsLabels d-inline-block">&nbsp; Records</label>
        </div>
    </form>
</div>
<div class="table-responsive d-block showDataTable" id="dataTable_pan">
	<?php 
	if (isset($_POST['search'])) {
		$search = $_POST['search'];
		if ($_SESSION['user_type'] == 'system_user') {
			/* $fetch_Company_Query = "SELECT * FROM `controller_operator` WHERE `company_id` = '".$_SESSION['company_id']."' AND FIND_IN_SET('".$_SESSION['user_id']."',users_access_Pan)";
			$run_fetch_ControllerData = mysqli_query($con,$fetch_Company_Query);
			if (mysqli_num_rows($run_fetch_ControllerData) > 0) {
				$fetch_dsc_data = "SELECT * FROM `users` WHERE `company_id` = '".$_SESSION['company_id']."' AND (transaction_id LIKE '%$search%' OR tax_invoice_number LIKE '%$search%' OR client_name LIKE '%$search%' OR date LIKE '%$search%' OR acknowledgement_no LIKE '%$search%' OR name_on_card LIKE '%$search%' OR other_charges LIKE '%$search%' OR description LIKE '%$search%' OR fees LIKE '%$search%' OR pan_status LIKE '%$search%' OR pan_no LIKE '%$search%') LIMIT $offset, $no_of_records_per_page";
			}else{
				$client_access = [];
				$fetchAdminId = "SELECT * FROM `client_master` WHERE `company_id` = '".$_SESSION['company_id']."' AND FIND_IN_SET('".$_SESSION['user_id']."',users_access)";
				$runAdminId = mysqli_query($con,$fetchAdminId);
				while ($AdminIdrow = mysqli_fetch_array($runAdminId)) {
					array_push($client_access, "'".$AdminIdrow['client_name']."'");
				} */
			// OR payment_mode LIKE '%$search%' OR payment_description LIKE '%$search%' OR amount LIKE '%$search%' OR remarks LIKE '%$search%' 
				$fetch_dsc_data = "SELECT * FROM `users` WHERE `company_id` = '".$_SESSION['company_id']."' AND (firstname LIKE '%$search%' OR lastname LIKE '%$search%' OR username LIKE '%$search%') LIMIT $offset, $no_of_records_per_page";
			// }
		}else{
			$fetch_dsc_data = "SELECT * FROM `users` WHERE `company_id` = '".$_SESSION['company_id']."' AND (transaction_id LIKE '%$search%' OR tax_invoice_number LIKE '%$search%' OR client_name LIKE '%$search%' OR date LIKE '%$search%' OR acknowledgement_no LIKE '%$search%' OR name_on_card LIKE '%$search%' OR other_charges LIKE '%$search%' OR description LIKE '%$search%' OR fees LIKE '%$search%' OR pan_status LIKE '%$search%' OR pan_no LIKE '%$search%') AND `client_name` = '".$_SESSION['username']."' LIMIT $offset, $no_of_records_per_page";
		}
		$run_dsc_data = mysqli_query($con,$fetch_dsc_data);
		$rows = mysqli_num_rows($run_dsc_data);
		$regularData = false;
	} else {
		if ($_SESSION['user_type'] == 'system_user') {
			/* $fetch_Company_Query = "SELECT * FROM `controller_operator` WHERE `company_id` = '".$_SESSION['company_id']."' AND FIND_IN_SET('".$_SESSION['user_id']."',users_access_Pan)";
			$run_fetch_ControllerData = mysqli_query($con,$fetch_Company_Query);
			if (mysqli_num_rows($run_fetch_ControllerData) > 0) {
				$fetch_dsc_data = "SELECT * FROM `users` WHERE `company_id` = '".$_SESSION['company_id']."' LIMIT $offset, $no_of_records_per_page";
			}else{ */
				/* $client_access = [];
				$fetchAdminId = "SELECT * FROM `client_master` WHERE `company_id` = '".$_SESSION['company_id']."' AND FIND_IN_SET('".$_SESSION['user_id']."',users_access)";
				$runAdminId = mysqli_query($con,$fetchAdminId);
				while ($AdminIdrow = mysqli_fetch_array($runAdminId)) {
					array_push($client_access, "'".$AdminIdrow['client_name']."'");
				} */
				$fetch_dsc_data = "SELECT * FROM `users` WHERE `company_id` = '".$_SESSION['company_id']."' LIMIT $offset, $no_of_records_per_page";
			// }
		}else{
			$fetch_dsc_data = "SELECT * FROM `users` WHERE `company_id` = '".$_SESSION['company_id']."' LIMIT $offset, $no_of_records_per_page";
		}
		$run_dsc_data = mysqli_query($con,$fetch_dsc_data);
		$rows = mysqli_num_rows($run_dsc_data);
		$regularData = true;
	}
		if ($rows > 0) {
			$count = 0;
			echo "<script type='text/javascript'>
		    	$('#pagination').removeClass('d-none');
				$('#pagination').addClass('d-block');
		    </script>";
	?>
	<div class="d-block" id="selectedRecordsDIV"></div>
	<table class="table" id="panTable">
		<thead class="bg-white" style="top: 0; position: sticky;">
			<?php if ($_SESSION['user_type'] == 'system_user') { ?>
				<!-- <th class="tableDate">
					<label class="customcheckbox m-b-20">
			            <input type="checkbox" id="mainCheckbox" />
			            <span class="checkmark"></span>
			        </label>
			        <form method="post" style="padding-left: 2px;">
						<span data-toggle="modal" data-target="#bulkDeleteConfirmMessagePopup">
						<button type="button" name="multipleDeletebtn" class="multipleDeletebtn" id="multipleDeletebtn" data-toggle="tooltip" data-placement="top" title="Delete Selected Records" style="padding: 0;border: none;background: none; outline:none; color: red;"><i class="fas fa-times fa-lg"></i></button></span>
					</form>
				</th> -->
				<th class="tableDate">Action</th>
		<?php } ?>
			<!-- <td style="font-weight: bold;" class="tableDate">Delete</td> -->
			<!-- <th style="font-weight: bold;" class="tableDate">Edit</th>
            <th style="font-weight: bold;" class="tableDate">Delete</th> -->
            <th>2-Step verification</th>
            <th>User Id</th>
            <th>Firstname</th>
            <th>Middlename</th>
            <th>Lastname</th>
            <th>Username</th>
            <th>Status</th>
            <th>Report</th>
            <th>Recipient Master</th>
            <th>Supplier Master</th>
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
            <th>Payment</th>
            <th>Audit</th>
            <th>Other Transaction</th>
            <th>User Management</th>
            <th>Company Profile</th>
            <th>Payroll</th>
		</thead>
		<tbody>
            <?php 
                // $fetch_dsc_data = "SELECT * FROM `users` WHERE `company_id` = '".$_SESSION['company_id']."'";
                // $run_dsc_data = mysqli_query($con,$fetch_dsc_data);
                while ($row = mysqli_fetch_array($run_dsc_data)) { ?>
                    <p><?php ++$count; ?></p>
                    <tr>
                        <td class="d-flex">
                            <form method="post">
                                <input type="hidden" readonly name="userEditID" value="<?= $row['id']; ?>">
                                <button class="editUserbtn mr-2" name="editUserbtn" id="editUserbtn" style="padding: 0;border: none;background: none; outline:none;" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fas fa-pencil-alt fa-lg" style="color:green;"></i></button>
                            </form>
                        </td>
                        <td>
                            <?php if ($row['type'] != 1): ?>
                                <label class="switch">
                                    <input type="hidden" value="<?= $row['username']; ?>" id="comp_title1">
                                    <input type="hidden" value="<?= $row['id']; ?>" id="id_comp_title1">
                                    <input type="hidden" value="<?= $row['two_step_veri']; ?>" id="notcheck1">
                                    <input type="checkbox" id="chkbox1" class="chkbox1" onclick="toggleStatus1(<?= $row['id']; ?>)" <?php if ($row['two_step_veri'] == 1) echo "checked"; ?>>
                                    <span class="slider round"></span>
                                </label>
                            <?php else: ?>
                                Restricted
                            <?php endif; ?>
                        </td>
                        <td><?= $row['user_id']; ?></td>
                        <td><?= $row['firstname']; ?></td>
                        <td><?= $row['middlename']; ?></td>
                        <td><?= $row['lastname']; ?></td>
                        <td><?= $row['username']; ?></td>
                        <td><?php if($row['type'] != 1){ ?><label class="switch"><input type="hidden" value="<?= $row['username']; ?>" id="comp_title"><input type="hidden" value="<?= $row['user_status']; ?>" id="notcheck"><input type="checkbox" id="chkbox" class="chkbox" onclick="toggleStatus(<?php echo $row['id']; ?>)" <?php if($row['user_status'] == 1){echo "checked";} ?>><span class="slider round"></span></label><?php } else { echo "Restricted";}?></td>
                        <td><?= ($row['reports'] == 1)?'<i class="fa fa-2x fa-check text-success" aria-hidden="true"></i>':'<i class="fa fa-2x fa-times text-danger" aria-hidden="true"></i>'; ?></td>
                        <td><?= ($row['client_master'] == 1)?'<i class="fa fa-2x fa-check text-success" aria-hidden="true"></i>':'<i class="fa fa-2x fa-times text-danger" aria-hidden="true"></i>'; ?></td>
                        <td><?= ($row['vendor_master'] == 1)?'<i class="fa fa-2x fa-check text-success" aria-hidden="true"></i>':'<i class="fa fa-2x fa-times text-danger" aria-hidden="true"></i>'; ?></td>
                        <td><?= ($row['dsc_subscriber'] == 1)?'<i class="fa fa-2x fa-check text-success" aria-hidden="true"></i>':'<i class="fa fa-2x fa-times text-danger" aria-hidden="true"></i>'; ?></td>
                        <td><?= ($row['dsc_reseller'] == 1)?'<i class="fa fa-2x fa-check text-success" aria-hidden="true"></i>':'<i class="fa fa-2x fa-times text-danger" aria-hidden="true"></i>'; ?></td>
                        <td><?= ($row['pan'] == 1)?'<i class="fa fa-2x fa-check text-success" aria-hidden="true"></i>':'<i class="fa fa-2x fa-times text-danger" aria-hidden="true"></i>'; ?></td>
                        <td><?= ($row['tan'] == 1)?'<i class="fa fa-2x fa-check text-success" aria-hidden="true"></i>':'<i class="fa fa-2x fa-times text-danger" aria-hidden="true"></i>'; ?></td>
                        <td><?= ($row['it_returns'] == 1)?'<i class="fa fa-2x fa-check text-success" aria-hidden="true"></i>':'<i class="fa fa-2x fa-times text-danger" aria-hidden="true"></i>'; ?></td>
                        <td><?= ($row['e_tds'] == 1)?'<i class="fa fa-2x fa-check text-success" aria-hidden="true"></i>':'<i class="fa fa-2x fa-times text-danger" aria-hidden="true"></i>'; ?></td>
                        <td><?= ($row['gst'] == 1)?'<i class="fa fa-2x fa-check text-success" aria-hidden="true"></i>':'<i class="fa fa-2x fa-times text-danger" aria-hidden="true"></i>'; ?></td>
                        <td><?= ($row['other_services'] == 1)?'<i class="fa fa-2x fa-check text-success" aria-hidden="true"></i>':'<i class="fa fa-2x fa-times text-danger" aria-hidden="true"></i>'; ?></td>
                        <td><?= ($row['psp'] == 1)?'<i class="fa fa-2x fa-check text-success" aria-hidden="true"></i>':'<i class="fa fa-2x fa-times text-danger" aria-hidden="true"></i>'; ?></td>
                        <td><?= ($row['psp_coupon_consumption'] == 1)?'<i class="fa fa-2x fa-check text-success" aria-hidden="true"></i>':'<i class="fa fa-2x fa-times text-danger" aria-hidden="true"></i>'; ?></td>
                        <td><?= ($row['payment'] == 1)?'<i class="fa fa-2x fa-check text-success" aria-hidden="true"></i>':'<i class="fa fa-2x fa-times text-danger" aria-hidden="true"></i>'; ?></td>
                        <td><?= ($row['audit'] == 1)?'<i class="fa fa-2x fa-check text-success" aria-hidden="true"></i>':'<i class="fa fa-2x fa-times text-danger" aria-hidden="true"></i>'; ?></td>
                        <td><?= ($row['other_transaction'] == 1)?'<i class="fa fa-2x fa-check text-success" aria-hidden="true"></i>':'<i class="fa fa-2x fa-times text-danger" aria-hidden="true"></i>'; ?></td>
                        <td><?= ($row['add_users'] == 1)?'<i class="fa fa-2x fa-check text-success" aria-hidden="true"></i>':'<i class="fa fa-2x fa-times text-danger" aria-hidden="true"></i>'; ?></td>
                        <td><?= ($row['company_profile'] == 1)?'<i class="fa fa-2x fa-check text-success" aria-hidden="true"></i>':'<i class="fa fa-2x fa-times text-danger" aria-hidden="true"></i>'; ?></td>
                        <td><?= ($row['payroll'] == 1)?'<i class="fa fa-2x fa-check text-success" aria-hidden="true"></i>':'<i class="fa fa-2x fa-times text-danger" aria-hidden="true"></i>'; ?></td>
                    </tr>
            <?php } ?>
        </tbody>
	</table>
	<input type="hidden" id="recordCount" name="recordCount" value="<?php echo $count; ?>">
</div>
<div class="pagination justify-content-left">
	<?php
	//echo $_POST['offset'];
	//$offset = 1;
        if (($offset+1) != 1) {
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
        }else if ($total_rows != $count) {
        	echo "<script type='text/javascript'>
		    	$('#nextLink').prop('disabled',false);
				$('#lastLink').prop('disabled',false);
				$('#nextLink').css('cursor','pointer');
				$('#lastLink').css('cursor','pointer');
		    </script>";
        }
    ?>
	<?php echo "<label style='font-weight: normal;' class='form-inline p-3'>Showing ".($offset+1)." to ".$count." of ".$total_rows." Records</label>"; ?>
</div>
<?php  }else{ 
	if($regularData == true) { ?>
		<div class="text-center">
			<p>No Record to show <?php if ($_SESSION['user_type'] == 'system_user') { ?><button type="button" class="btn btn-link" id="addNew_pan_link">Click here to add records</button><?php } ?></p>
		</div>
<?php echo "<script type='text/javascript'>
		    	$('#pagination').removeClass('d-block');
				$('#pagination').addClass('d-none');
				$('#No_ofshowRecord').removeClass('d-block');
				$('#No_ofshowRecord').addClass('d-none');
		    </script>";
	}else{ ?>
		<div class="text-center">
			<p>No Record mathched!</p>
		</div>
<?php	echo "<script type='text/javascript'>
		    	$('#pagination').removeClass('d-block');
				$('#pagination').addClass('d-none');
				$('#No_ofshowRecord').removeClass('d-block');
				$('#No_ofshowRecord').addClass('d-none');
		    </script>";
		} 
	} ?>
<script type="text/javascript">
	$(function () {
		$('[data-toggle="tooltip"]').tooltip()
	})
	$('.table tbody').on('click', '#userDeletebtn', function () {
		  //var recordID = $('#recordID').val();
		  var row_indexDEL = $(this).closest('tr'); 
		  var deleteID = row_indexDEL.find('#userDeleteID').val();
			//var deleteID = $('#panDeleteID').val();
			//alert(deleteID);
			$('#tempUserIDdel').val(deleteID);
	});
	$("#no_of_records_per_page").change(function () {
		var no_of_records_per_page = $("#no_of_records_per_page").val();
		var first = $('#first').val();
		//alert(first);
		$.ajax({
			url:"html/showAddUsersTable.php",
			method:"post",
			data: {pageno:first,no_of_records_per_page:no_of_records_per_page},
			dataType:"text",
			success:function(data)
			{
				//alert(data);
				//alert(first);
				$('#showAddUsersTable').empty();
				$('#showAddUsersTable').html(data);
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
      $('#panTable').excelTableFilter();
    });*/
    $(document).ready(function(){
	    $("#mainCheckbox").click(function(){
	        if($(this).prop("checked") == true){
    			$('td input:checkbox','.table').prop('checked',this.checked);
    			var checkedVal = [];
	        	var MultipledeleteID = [];
				$.each($("input[name='itemCheckBox']:checked"), function(){
				    checkedVal .push($(this).val());
				    var row_indexDEL = $(this).closest('tr'); 
				  	MultipledeleteID .push(row_indexDEL.find('#multipleDeleteID').val());
				});
				if(MultipledeleteID.length > 0){
					$("#selectedRecordsDIV").html(MultipledeleteID.length+" Record(s) Selected");
				}
	        }else{
	        	$('td input:checkbox','.table').prop('checked',false);
	        	$("#selectedRecordsDIV").html("");
	        }
	    });
	    $("#multipleDeletebtn").click(function(){
	        var checkedVal = [];
	        var MultipledeleteID = [];
	        $.each($("input[name='itemCheckBox']:checked"), function(){
			    checkedVal .push($(this).val());
			    var row_indexDEL = $(this).closest('tr'); 
			  	MultipledeleteID .push(row_indexDEL.find('#multipleDeleteID').val());
			});
			if (MultipledeleteID.length == 0) {
				$("#DeleteConfirmMsg").empty();
				$("#DeleteConfirmMsg").html('Please select atleast one record..!');
				$("#bulk_delete_Yes").removeClass("d-block");
				$("#bulk_delete_Yes").addClass("d-none");
				$("#closeBtn").text("Close");
			}else{
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
	    $('.table tbody').on('click', '#itemCheckBox', function () {
	    	var recordCount = $("#recordCount").val();
			if($(this).prop("checked") == true){
				var checkedVal = [];
	        	var MultipledeleteID = [];
				$.each($("input[name='itemCheckBox']:checked"), function(){
				    checkedVal .push($(this).val());
				    var row_indexDEL = $(this).closest('tr'); 
				  	MultipledeleteID .push(row_indexDEL.find('#multipleDeleteID').val());
				});
				$("#selectedRecordsDIV").html(MultipledeleteID.length+" Record(s) Selected");
				if (MultipledeleteID.length == recordCount) {
					$("#mainCheckbox").prop("checked",true);
				}
    			//$('td input:checkbox','.table').prop('checked',this.checked);
	        }else{
	        	var checkedVal = [];
	        	var MultipledeleteID = [];
				$.each($("input[name='itemCheckBox']:checked"), function(){
				    checkedVal .push($(this).val());
				    var row_indexDEL = $(this).closest('tr'); 
				  	MultipledeleteID .push(row_indexDEL.find('#multipleDeleteID').val());
				});
				if(MultipledeleteID.length > 0){
					$("#selectedRecordsDIV").html(MultipledeleteID.length+" Record(s) Selected");
				}else{
					$("#selectedRecordsDIV").html("");
				}
	        	//$('td input:checkbox','.table').prop('checked',false);
	        	$("#mainCheckbox").prop("checked",false);
	        }
		});
	});
	
	function toggleStatus(id){
      GFG_Fun();
      var status_id = id;
      $('.table tbody').on('click','#chkbox', function(){
          var row_indexDEL = $(this).closest('tr'); 
          var notcheck = row_indexDEL.find('#notcheck').val();
          var comp_title = row_indexDEL.find('#comp_title').val();
          $('#clientNameStatusChanging').val(comp_title);
      $('#status_cap').modal('show');
      if(notcheck == 1){
          $("#chkbox").prop("checked", true);
      }else{
          $("#chkbox").prop("checked", false);
      }
      
      $('#status_cap #testCap').on('keyup', function () {
		  var capt = $('#status_cap #testCap').val();
		  var pre = $('#cachePaste').val();
		  if(capt == pre){
		      $('#testCap').html('').css({'color':'green'});
		      //document.getElementById('save_cap').style.visibility = 'visible';
		      
		      $.ajax({
                  url:"html/verifyPinProcess.php",
                  method: "POST",
                  data: {User_status_id:status_id,},
                  success:function(data){
                    if(data == 1){
                        swal({
                          title: "Status Active!",
                          icon: "success",
                          button: "Close!",
                        }); 
                        $("#chkbox").prop("checked", true);
                    } else {
                        swal({
                          title: "Status Inactive!",
                          icon: "success",
                          button: "Close!",
                        });
                        $("#chkbox").prop("checked", false);
                    }
                  },
                  complete:function(data){
                    setInterval('location.reload()', 1000);  
                  },
              })
              $('#testCap').val("");
              $('#status_cap').modal('hide');
      
		  } else {
		      $('#testCap').html('').css({'color':'red'});
		      //$(".client_delete").modal('hide');
		      //document.getElementById('save_cap').style.visibility = 'hidden';
		  }
		});
      });
  }
  
//   var up = document.getElementById('GFG_UP');
    var down = document.getElementById('cachePaste');
    

    function GFG_Fun() {
        document.getElementById("cachePaste").value = down.innerText =
        Math.random().toString(36).slice(2); 
    }
</script>
<script>
        
function toggleStatus1(id) {
    // alert(id);
    GFG_Fun1();
}

$(document).ready(function () {
    $('.table tbody').on('click', '#chkbox1', function () {
        // var id = ""; // Define id variable or fetch it from somewhere
// var status_id1 = id;
        var row_indexDEL = $(this).closest('tr');
        var notcheck1 = row_indexDEL.find('#notcheck1').val();
        var id_comp_title1 = row_indexDEL.find('#id_comp_title1').val();
        var comp_title1 = row_indexDEL.find('#comp_title1').val();
        $('#clientNameStatusChanging1').val(comp_title1);
        $('#status_cap1').modal('show');
        
        if (notcheck1 == 1) {
            $(this).prop("checked", true);
        } else {
            $(this).prop("checked", false);
        }

        $('#status_cap1 #testCap1').on('keyup', function () {
            var capt1 = $('#status_cap1 #testCap1').val();
            var pre1 = $('#cachePaste1').val();
            
            if (capt1 == pre1) {
                $('#testCap1').html('').css({ 'color': 'green' });
                $.ajax({
                    url: "html/verifyPinProcess.php",
                    method: "POST",
                    data: { User_status_id1: id_comp_title1 },
                    success: function (data) {
                        // alert(data);
                        if (data == 1) {
                            swal({
                                title: "2-Step verification On",
                                icon: "success",
                                button: "Close!",
                            });
                            // row_indexDEL.find("#chkbox1").prop("checked", true);
                        } else {
                            swal({
                                title: "2-Step verification Off",
                                icon: "success",
                                button: "Close!",
                            });
                            // row_indexDEL.find("#chkbox1").prop("checked", false);
                        }
                    },
                    error: function(xhr, status, error) {
                        alert("Error: " + xhr.responseText);
                    },
                    complete: function () {
                        // Remove the interval here, it's unnecessary
                        location.reload();
                    },
                });
                $('#testCap1').val("");
                $('#status_cap1').modal('hide');
            } else {
                $('#testCap1').html('').css({ 'color': 'red' });
            }
        });
    });
});


// Definition of GFG_Fun1 function
function GFG_Fun1() {
    var down1 = document.getElementById('cachePaste1');
    document.getElementById("cachePaste1").value = down1.innerText = Math.random().toString(36).slice(2); 
}


</script>