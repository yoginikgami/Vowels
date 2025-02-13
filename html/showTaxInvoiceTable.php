<style>
    .heading {
        height: 10px;

        background: #e5d2f1;
        position: sticky;
        top: 0;
    }

    .heading .txt {
        font-size: 12px;
        text-align: center;
        padding: 2px 2px 2px 2px;
    }

    .tableRecords {
        text-align: center;
    }

    .WrapText {

        white-space: nowrap;
        text-overflow: clip;
        inline-size: 50px;
        overflow: hidden;
        font-size: 12px;
    }

    .ttext {
        font-size: 12px;
    }
</style>
<?php

use function PHPSTORM_META\type;

session_start();
// include_once 'mailFunction.php';
include_once 'connection.php';

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
$service_conditions = [
    "other_services" => "DO_OS",
    "trade_secret" => "DO_TRS",
    "pan" => "DO_PAN",
    "tan" => "DO_TAN",
    "e_tds" => "DO_TDS",
    "psp" => "DO_PSP",
    "psp_coupon_consumption" => "DO_PSP_COUPON",
    "trade_mark" => "DO_TRD",
    "dsc_subscriber" => "DO_DA",
    "dsc_reseller" => "DO_DP",
    "e_tender" => "DO_TND",
    "patent" => "DO_PTN",
    "copy_right" => "DO_COP",
    "industrial_design" => "DO_IDS",
    "legal_notice" => "DO_ADV",
    "it_returns" => "DO_ITR",
    "gst" => "DO_GST",
    "client_master" => "DO_CLM"
];

// Generate SQL conditions based on permissions
$allowed_services = [];
foreach ($service_conditions as $column => $prefix) {
    if (!empty($permission_row[$column]) && $permission_row[$column] == 1) {
        $allowed_services[] = "`service_id` LIKE '%$prefix%'";
    }
}

// If no permissions are granted, do not show any data
if (empty($allowed_services)) {
    $service_condition_sql = "AND 1=0"; // No records will match
} else {
    $service_condition_sql = "AND (" . implode(" OR ", $allowed_services) . ")";
}

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
//echo nl2br("\n".$offset);
if ($_SESSION['user_type'] == 'system_user') {
    $total_pages_sql = "SELECT COUNT(*) FROM `tax_invoice` WHERE `company_id` = '" . $_SESSION['company_id'] . "' $service_condition_sql ";
} else {
    $total_pages_sql = "SELECT COUNT(*) FROM `tax_invoice` WHERE `company_id` = '" . $_SESSION['company_id'] . "' 
                        AND `client_name` = '" . $_SESSION['username'] . "' 
                        AND `client_id` = '" . $_SESSION['service_id'] . "' 
                        $service_condition_sql";
}
$result = mysqli_query($con, $total_pages_sql);
$total_rows = mysqli_fetch_array($result)[0];
$total_pages = ceil($total_rows / $no_of_records_per_page);
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
<div class="modal fade" data-backdrop="static" data-keyboard="false" id="pass_ManagerConfirmMessagePopup" tabindex="-1"
    role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form method="post" action="password_manager">
                <div class="modal-header">
                    <img src="html/images/logo.png" alt="Vyaya" style="width: 150px; height: 55px;"
                        class="logo navbar-brand mr-auto">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body bg-light">
                    <input type="hidden" id="tempPass_ManagerIDdel" name="tempPass_ManagerIDdel"
                        class="tempPass_ManagerIDdel">
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
                <!--<option <?php if (isset($_POST['no_of_records_per_page'])) if ($_POST['no_of_records_per_page'] == 5) echo 'selected'; ?> value="5">5</option>-->
                <option <?php if (isset($_POST['no_of_records_per_page'])) if ($_POST['no_of_records_per_page'] == 10) echo 'selected'; ?> value="10">10</option>
                <!--<option <?php if (isset($_POST['no_of_records_per_page'])) if ($_POST['no_of_records_per_page'] == 15) echo 'selected'; ?> value="15">15</option>-->
                <option <?php if (isset($_POST['no_of_records_per_page'])) if ($_POST['no_of_records_per_page'] == 25) echo 'selected'; ?> value="25">25</option>
                <option <?php if (isset($_POST['no_of_records_per_page'])) if ($_POST['no_of_records_per_page'] == 50) echo 'selected'; ?> value="50">50</option>
                <option <?php if (isset($_POST['no_of_records_per_page'])) if ($_POST['no_of_records_per_page'] == 100) echo 'selected'; ?> value="100">100</option>
                <option <?php if (isset($_POST['no_of_records_per_page'])) if ($_POST['no_of_records_per_page'] == '500') echo 'selected'; ?> value="500">500</option>
            </select>
            <label class="showRecordsLabels d-inline-block">&nbsp; Records</label>
        </div>

    </form>
</div>
<div class="table-responsive d-block showDataTable" id="dataTable_gst">
    <?php

    // Search condition
    $search_condition = "";
    if (isset($_POST['search'])) {
        $search = $_POST['search'];
        $search_condition = "AND (reference_number LIKE '%$search%' OR billing_date LIKE '%$search%' 
            OR category LIKE '%$search%' OR client_name LIKE '%$search%' OR gst_number LIKE '%$search%' 
            OR service_id LIKE '%$search%' OR taxable_amount LIKE '%$search%' OR gst_type LIKE '%$search%' 
            OR total_tax_value LIKE '%$search%')";
    }
    
    if ($_SESSION['user_type'] == 'system_user') {
        $fetch_dsc_data = "SELECT * FROM `tax_invoice` WHERE `company_id` = '" . $_SESSION['company_id'] . "' 
            $search_condition $service_condition_sql
            ORDER BY `tax_invoice_number` DESC LIMIT $offset, $no_of_records_per_page";
    } else {
        $fetch_dsc_data = "SELECT * FROM `tax_invoice` WHERE `company_id` = '" . $_SESSION['company_id'] . "' 
            AND `client_name` = '" . $_SESSION['username'] . "' 
            AND `client_id` = '" . $_SESSION['service_id'] . "' 
            $search_condition $service_condition_sql
            ORDER BY `tax_invoice_number` DESC LIMIT $offset, $no_of_records_per_page";
    }
    
    $run_dsc_data = mysqli_query($con, $fetch_dsc_data);
    $rows = mysqli_num_rows($run_dsc_data);
    $regularData = isset($_POST['search']) ? false : true;

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
            <thead>
                <tr class="heading">

                <?php if ($_SESSION['user_type'] == 'system_user') { ?>
                <th class="tableDate">Action</th>
                <?php if ($showColumn) { ?>
                    <th class="txt">Send Invoice</th>
                <?php } ?>
            <?php } ?>
                    <th class="tableDate">DTI</th>
                    <th class="tableDate">PT</th>
                    <th class="txt">IN</th>
                    <th class="txt">RN</th>
                    <th class="txt">Date</th>
                    <th class="txt">Category</th>
                    <th class="txt">Client Name</th>
                    <th class="txt">GST Number</th>
                    <th class="txt">Taxable Amount (₹)</th>
                    <th class="txt">Total Value (₹)</th>
                    <th class="txt">Modify By</th>
                </tr>
            </thead>
            <tbody class="tableRecords" id="tableRecords">
                <tr id="tableids">
                    <?php
                    while ($row = mysqli_fetch_array($run_dsc_data)) { ?>
                        <p><?php ++$count; ?></p>
                        <?php if ($_SESSION['user_type'] == 'system_user') { ?>
                            
                            <td class="d-flex">
                                <?php if($showColumn) {?>
                                <form method="post">
                                    <input type="hidden" readonly name="gstDeleteID" id="gstDeleteID"
                                        value="<?= $row['id']; ?>"><span data-toggle="modal"
                                        data-target="#gstConfirmMessagePopup"><button type="button" name="gstDeletebtn"
                                            class="gstDeletebtn mr-2" id="gstDeletebtn" data-toggle="tooltip" data-placement="top"
                                            title="Delete"
                                            style="padding: 0;border: none;background: none; outline:none; color: red;"><i
                                                class="fas fa-times fa-lg"></i></button></span>
                                </form><?php } ?>
                                <button type="button" class="viewButton" data-toggle="modal" data-target="#exampleModal1" data-emp-id="<?php echo $row['tax_invoice_number']; ?>" data-emp-year="<?php echo $row['financial_year']; ?>" style="border: none;">
                                    <i class="fas fa-eye fa-lg bg-vowel"></i>
                                </button>
                            </td><?php if($showColumn) {?>
                            <td>
                                <form method="post">
                                    <input type="hidden" name="TaxInvoiceWhatsAppID" id="TaxInvoiceWhatsAppID" value="<?= $row['id']; ?>">
                                    <input type="hidden" name="TaxInvoiceClientID" id="TaxInvoiceClientID" value="<?= $row['client_id']; ?>">
                                    <span><button type="button" name="gstWhatsAppbtn" class="gstWhatsAppbtn" id="gstWhatsAppbtn"
                                            data-toggle="tooltip" data-placement="top" title="Send Invoice on WhatsApp"
                                            style="padding: 0;border: none;background: none; outline:none; color: green;"><i
                                                class="fab fa-whatsapp fa-lg"></i></button></span>
                                    <span><button type="button" name="gstGmailbtn" class="gstGmailbtn" id="gstGmailbtn"
                                            data-toggle="tooltip" data-placement="top" title="Send Invoice on Gmail"
                                            style="padding: 0;border: none;background: none; outline:none; color: red;"><i
                                                class="far fa-envelope fa-lg"></i></button></span>
                                </form>
                            </td><?php } ?>
                        <?php } ?>
                        <td>
                            <form class="d-inline" method='post' action='Download_TaxInvoice' target="_blank">
                                <input type="hidden" readonly name="client_name" id="client_name"
                                    value="<?php echo $row['client_name']; ?>">
                                <input type="hidden" readonly name="tax_invoice_number" id="tax_invoice_number"
                                    value="<?php echo $row['tax_invoice_number']; ?>">
                                <input type="hidden" readonly name="reference_number" id="reference_number"
                                    value="<?php echo $row['reference_number']; ?>">
                                <input type="hidden" readonly name="billing_date" id="billing_date"
                                    value="<?php echo $row['billing_date']; ?>">
                                <input type="hidden" readonly name="service_id" id="service_id"
                                    value="<?php echo $row['service_id']; ?>">
                                <input type="hidden" readonly name="cgst_tax_percentage" id="cgst_tax_percentage"
                                    value="<?php echo $row['cgst_tax_percentage']; ?>">
                                <input type="hidden" readonly name="sgst_tax_percentage" id="sgst_tax_percentage"
                                    value="<?php echo $row['sgst_tax_percentage']; ?>">
                                <input type="hidden" readonly name="igst_tax_percentage" id="igst_tax_percentage"
                                    value="<?php echo $row['igst_tax_percentage']; ?>">
                                <input type="hidden" readonly name="cgst_tax_amount" id="cgst_tax_amount"
                                    value="<?php echo $row['cgst_tax_amount']; ?>">
                                <input type="hidden" readonly name="sgst_tax_amount" id="sgst_tax_amount"
                                    value="<?php echo $row['sgst_tax_amount']; ?>">
                                <input type="hidden" readonly name="igst_tax_amount" id="igst_tax_amount"
                                    value="<?php echo $row['igst_tax_amount']; ?>">
                                <button type='submit' name='Download_TaxInvoice' class="btn btn-link"><i
                                        class='fas fa-download text-center'></i></button>
                            </form>
                        </td>
                        <td class="ttext"><?= $row['procure_type']; ?></td>
                        <td class="ttext"><?= $row['tax_invoice_number']; ?></td>
                        <td class="ttext"><?= $row['reference_number']; ?></td>
                        <td class="WrapText"><?= $row['billing_date']; ?></td>
                        <td class="ttext"><?= $row['category']; ?></td>
                        <td class="ttext"><?= $row['client_name']; ?></td>
                        <td class="ttext"><?= $row['gst_number']; ?></td>

                        <td><?= $row['taxable_amount']; ?></td>
                        <!--<td><?= $row['gst_type']; ?></td>-->
                        <!--<td><?= $row['cgst_tax_percentage']; ?></td>-->
                        <!--<td><?= $row['cgst_tax_amount']; ?></td>-->
                        <!--<td><?= $row['sgst_tax_percentage']; ?></td>-->
                        <!--<td><?= $row['sgst_tax_amount']; ?></td>-->
                        <!--<td><?= $row['igst_tax_percentage']; ?></td>-->
                        <!--<td><?= $row['igst_tax_amount']; ?></td>-->
                        <td class="ttext"><?= $row['total_tax_value']; ?></td>
                        <td class="ttext"><?= $row['modify_by']; ?><br>
                            <?= date('d-m-Y', strtotime($row['modify_date'])); ?></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
        <input type="hidden" id="recordCount" name="recordCount" value="<?php echo $count; ?>">
</div>
<div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type='hidden' id='empIdModal1'>
                <input type='hidden' id='empIdModal112'>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Service Id(s) </th>
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
        // Handle the Pay button click
        $('.viewButton').click(function() {
            var empId = $(this).data('emp-id');
             var empYear = $(this).data('emp-year');
            $('#empIdModal1').val(empId);
             $('#empIdModal112').val(empYear);
            $.ajax({
                url: 'html/fetch_tax_invoice_service_id.php', // Replace with your PHP script path
                type: 'POST',
                data: {
                    empId: empId,
                    empYear: empYear
                },
                success: function(response) {
                    $('#modalTableBody').html(response);
                },
                error: function(xhr, status, error) {
                    console.error("An error occurred: " + error);
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
        <p>No Record to show <?php if ($_SESSION['user_type'] == 'system_user') { ?><button type="button"
                    class="btn btn-link" id="addNew_gst_link">Click here to add records</button><?php } ?></p>
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
    $(document).ready(function() {
        $('.table-striped tbody').on('click', '#gstDeletebtn', function() {
            var row_indexDEL = $(this).closest('tr');
            var deleteID = row_indexDEL.find('#gstDeleteID').val();
            $('#tempGSTIDdel').val(deleteID);
        });
        
        // Send Invoice on Gmail
        $('.table-striped tbody').on('click', '#gstGmailbtn', function() {
            var row_indexDEL = $(this).closest('tr');
            var GmailID = row_indexDEL.find('#TaxInvoiceWhatsAppID').val();
            var client_name = row_indexDEL.find('#client_name').val();
            var tax_invoice_number = row_indexDEL.find('#tax_invoice_number').val();
            var reference_number = row_indexDEL.find('#reference_number').val();
            var billing_date = row_indexDEL.find('#billing_date').val();
            var service_id = row_indexDEL.find('#service_id').val();
            var cgst_tax_percentage = row_indexDEL.find('#cgst_tax_percentage').val();
            var sgst_tax_percentage = row_indexDEL.find('#sgst_tax_percentage').val();
            var igst_tax_percentage = row_indexDEL.find('#igst_tax_percentage').val();
            var cgst_tax_amount = row_indexDEL.find('#cgst_tax_amount').val();
            var sgst_tax_amount = row_indexDEL.find('#sgst_tax_amount').val();
            var igst_tax_amount = row_indexDEL.find('#igst_tax_amount').val();
            let sendMail = false;
            
            $('#loaderpopup').show();
            // Creating a PDF for the CLient and Storing on the server
            $.ajax({
                url: "html/CreateTaxInvoiceStoreProcess.php",
                method: "post",
                data: {
                    client_name,
                    tax_invoice_number,
                    reference_number,
                    billing_date,
                    service_id,
                    cgst_tax_percentage,
                    sgst_tax_percentage,
                    igst_tax_percentage,
                    cgst_tax_amount,
                    sgst_tax_amount,
                    igst_tax_amount
                },
                dataType: "text",
                success: function(outerdata) {
                    if (outerdata == 'File_Stored_On_Server') {
                        $.ajax({
                            url: "html/SendTaxInvoiceProcess.php",
                            method: "post",
                            data: {
                                GmailID,
                                client_name,
                                tax_invoice_number
                            },
                            dataType: "text",
                            success: function(data) {
                                $('#loaderpopup').hide();
                                if (data == "client_notified") {
                                    swal({
                                        title: "Mail Send",
                                        icon: "success",
                                        button: "Close!",
                                    });
                                } else {
                                    swal({
                                        title: "Something went wrong!",
                                        icon: "success",
                                        button: "Close!",
                                    });
                                }
                            },
                            complete: function() {
                                $('#pleaseWaitDialog').modal('hide');
                            }
                        });
                    }
                },
                complete: function() {
                    $('#pleaseWaitDialog').modal('hide');
                }
            });
        });

        $('.table-striped tbody').on('click', '#gstWhatsAppbtn', function() {
            var row_indexDEL = $(this).closest('tr');
            var GmailID = row_indexDEL.find('#TaxInvoiceWhatsAppID').val();
            var client_name = row_indexDEL.find('#client_name').val();
            var tax_invoice_number = row_indexDEL.find('#tax_invoice_number').val();
            var reference_number = row_indexDEL.find('#reference_number').val();
            var billing_date = row_indexDEL.find('#billing_date').val();
            var service_id = row_indexDEL.find('#service_id').val();
            var cgst_tax_percentage = row_indexDEL.find('#cgst_tax_percentage').val();
            var sgst_tax_percentage = row_indexDEL.find('#sgst_tax_percentage').val();
            var igst_tax_percentage = row_indexDEL.find('#igst_tax_percentage').val();
            var cgst_tax_amount = row_indexDEL.find('#cgst_tax_amount').val();
            var sgst_tax_amount = row_indexDEL.find('#sgst_tax_amount').val();
            var igst_tax_amount = row_indexDEL.find('#igst_tax_amount').val();
            let sendMail = false;
            $.ajax({
                url: "html/whatsapi_taxInvoice.php",
                method: "post",
                data: {
                    client_name,
                    tax_invoice_number,
                    reference_number,
                    billing_date,
                    service_id,
                    cgst_tax_percentage,
                    sgst_tax_percentage,
                    igst_tax_percentage,
                    cgst_tax_amount,
                    sgst_tax_amount,
                    igst_tax_amount
                },
                dataType: "text",
                success: function(outerdata) {
                    try {
                        var jsonData = JSON.parse(outerdata);
                        console.log(jsonData);
                    } catch (error) {
                        console.error('JSON parsing error:', error);
                    }
                },
                complete: function() {
                    $('#pleaseWaitDialog').modal('hide');
                }
            });
        });

        $('.table-striped tbody').on('click', '#viewGSTDetailbtn', function() {
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
                    $("#showGSTWholeDetails").html(data);
                    $("#showGSTWholeDetails").removeClass("d-none");
                    $("#showGSTWholeDetails").addClass("d-block");
                },
                complete: function() {
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
                $("#mainCheckbox").prop("checked", false);
            }
        });
    });
    $("#no_of_records_per_page").change(function() {
        var no_of_records_per_page = $("#no_of_records_per_page").val();
        var first = $('#first').val();
        $.ajax({
            url: "html/showTaxInvoiceTable.php",
            method: "post",
            data: {
                pageno: first,
                no_of_records_per_page: no_of_records_per_page
            },
            dataType: "text",
            success: function(data) {
                $('#showTaxInvoiceTable').empty();
                $('#showTaxInvoiceTable').html(data);
            }
        });
    });
</script>