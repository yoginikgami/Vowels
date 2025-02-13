<?php
// Start a session
session_start();

include_once 'connection.php';
require_once 'vendor/autoload.php';

date_default_timezone_set('Asia/Kolkata');

use Dompdf\Dompdf;

$document = new Dompdf();
// $from_date = $_SESSION['from_date'];
// $to_date = $_SESSION['to_date'];
// $show_income_expense = $_SESSION['show_income_expense'];
// $show_client_vendor_name = json_decode(stripslashes($_SESSION['show_client_vendor_name']));
// $showRecords_transaction_type = json_decode(stripslashes($_SESSION['showRecords_transaction_type']));
$count = 0;
$output = "
<title>Vowel Report - PDF</title>
<link rel='stylesheet' type='text/css' href='assest/libs/bootstrap/dist/css/bootstrap.min.css'>
<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js'></script>
<style type='text/css'>
.dynamic-row {
    font-size: calc(10px + 0.5vw); /* Adjust font size based on viewport width */
    line-height: 1.5; /* Optional: Adjust line height for better readability */
}

table {
    border-collapse: collapse;
    table-layout: auto; /* Allow dynamic column width */
    width: 100%; /* Adjust to parent container */
}



	body, table {
		font-family: 'Arial, Helvetica, sans-serif';
		border-collapse: collapse;
		width: 100%;
	}
	td, th {
		border: 1px solid #000;
		text-align: left;
		padding: 8px;
	}
	header {
	    position: fixed;
	    top: -3px;
	    left: -8px;
	    right: 0px;
	    height: 50px;

	    /** Extra personal styles **/
	    //background-color: #03a9f4;
	    //color: white;
	    //text-align: center;
	    line-height: 35px;
	    display: inline-block;
	}
	
	footer {
	    position: fixed; 
	    bottom: -30px; 
	    left: 0px; 
	    right: 0px;
	    height: 50px; 

	    /** Extra personal styles **/
	    //background-color: #03a9f4;
	    //color: white;
	    text-align: right;
	    line-height: 35px;
	}
	.tableAmount{
      text-align: right;
    }
    .tableDate{
      text-align: center;
    }
    .tableLeftData{
      text-align: left;
    }
    .tableTotalHead{
      text-align: right;
    }
    .tableTotalAmount{
      text-align: right;
    }
</style>";
//$page = $document->get_canvas()->page_text(72, 18, "{PAGE_NUM} of {PAGE_COUNT}", $font, 10, array(0,0,0)).toString();
$page = "{PAGE_NUM}";
//$whichDate = date("d-m-Y", strtotime($_SESSION['from'])).' to '.date("d-m-Y", strtotime($_SESSION['to']));
date_default_timezone_set('Asia/Kolkata');


$fetch_ClientDetails = "SELECT * FROM `client_master` WHERE `client_name` = '" . $_POST['client_name'] . "' AND `company_id` = '" . $_SESSION['company_id'] . "' ORDER BY `client_name` ASC";
$row_11 = mysqli_query($con, $fetch_ClientDetails);
// $row_ClientDetails = mysqli_num_rows($row_11);
$rows = mysqli_fetch_assoc($row_11);
$service_id = $_POST['service_id'];
$ExplodeCommmas = explode(",", $service_id);
foreach ($ExplodeCommmas as $Id) {
}
$run_drwa = "select * from retail_invoice where `client_name` = '" . $_POST['client_name'] . "' and `retail_invoice_number`= '" . $_POST['retail_invoice_number'] . "'";
$run_dra = mysqli_query($con, $run_drwa);
$row_1231 = mysqli_fetch_array($run_dra);
$drwee_name_from_invoice = $row_1231['drawee'];
$procure_type = $row_1231['procure_type'];
$gst_number_Fetch = $row_1231['gst_number'];
$client_address = $row_1231['address'];


$string = "$drwee_name_from_invoice";
$parts = explode("_", $string);
$result = $parts[0];
// echo $result;

$for_drwaree_name = "select * from drawee where `client_name` = '" . $_POST['client_name'] . "' and `name`='$result'";
$rub_d_name = mysqli_query($con, $for_drwaree_name);
$d_row = mysqli_fetch_array($rub_d_name);

$fetch_company_details = "select * from company_profile where `company_id` = '" . $_SESSION['company_id'] . "'";
$run_company_details = mysqli_query($con, $fetch_company_details);
$row11 = mysqli_fetch_array($run_company_details);
$company_name = $row11['company_name'];
$company_address = $row11['address'];
$company_email = $row11['email_id'];
$comapny_gst_no = $row11['gst_no'];

$fetch_comapny_bank = "select * from company_bank_details where `company_id` = '" . $_SESSION['company_id'] . "' and `primary_bank`=1";
$run_fetch_bank_details = mysqli_query($con, $fetch_comapny_bank);
$row12 = mysqli_fetch_array($run_fetch_bank_details);

$company_bank_name = $row12['bank_name'];
$company_acc_no = $row12['bank_ac_no'];
$comapny_branch_name = $row12['branch_address'];
$company_ifc_code = $row12['ifsc_code'];
$company_mirc_code = $row12['mirc_code'];
$comany_brandch_code = $row12['branch_code'];


$fetch_client_recode = "select * from client_master where client_name ='" . $_POST['client_name'] . "'";
$run_fetch_client_recode = mysqli_query($con, $fetch_client_recode);
$clinet_recode = mysqli_fetch_array($run_fetch_client_recode);
$client_comany_name = $clinet_recode['company_name'];

$fetchComapnyLogo = "SELECT * FROM `company_profile` WHERE `company_id` = '" . $_SESSION['company_id'] . "'";
$run_fetch_company_Logo = mysqli_query($con, $fetchComapnyLogo);
$stored_company_logo = mysqli_fetch_array($run_fetch_company_Logo);
$main_company_logo = $stored_company_logo['company_logo'];
$path = "$main_company_logo";
$path = str_replace('html/', '', $path);
$type = pathinfo($path, PATHINFO_EXTENSION);
$data = file_get_contents($path);
$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);

// Dynamic Document


// Remove leading and trailing underscores, if any
// $cleaned_service_id = trim($service_id, '_');

// // Extract the part between the underscores
// $parts = explode('_', $cleaned_service_id);

// if (count($parts) > 1) {
//     // Extract the second part (value between underscores)
//     $adv_value = $parts[1]; // This will be 'ADV'

//     // Use this value in your query
//     $fetch_doc_cl = "SELECT * FROM documents_column WHERE serice_id = '$adv_value'";

//     // Output the query or execute it
//     // echo $fetch_doc_cl; // Outputs: SELECT * FROM documents_column WHERE serice_id = 'ADV'
// } else {
//     echo "Invalid service_id format.";
// }

// $sql = "SELECT * FROM documents_column";
// $result = $con->query($sql);
// Fetch all records from the documents_column table
$fetch_doc_cl = "SELECT * FROM documents_column";
$run_doc = mysqli_query($con, $fetch_doc_cl);

if ($run_doc && mysqli_num_rows($run_doc) > 0) {
    // Extract the ADV or equivalent from the input service_id
    $input_service_id = explode(',', $_POST['service_id']); // Example: VE_ADV_18126
    $input_parts = explode('_', $input_service_id[0]);
    $input_adv = $input_parts[1] ?? null; // Extract 'ADV'

    if ($input_adv) {
        // Loop through each record
        while ($row = mysqli_fetch_assoc($run_doc)) {
            // Extract ADV or equivalent from the database `serice_id`
            $db_service_id = $row['serice_id']; // Assuming the column is named `serice_id`
            $db_parts = explode('_', $db_service_id);
            $db_adv = $db_parts[1] ?? null; // Extract 'ADV'

            // Compare the ADV parts
            if ($db_adv === $input_adv) {
                // echo "Match found: " . json_encode($row) . "\n";
                $final_col = $db_adv;
                $colmnf = $row['column_name'];
                $colmcsd = $row['display_name'];
                $portfolio = $row['portfolio'];
                $columns = explode(',', $colmnf);
                $hedaer_column = explode(',', $colmcsd);
            }
        }
    }
}
// $firstUnderscore = explode("_", $service_id);
// $fetch_doc_cl="select * from documents_column where serice_id='".$_POST['service_id']."'"; 
// $run_doc=mysqli_query($con,$fetch_doc_cl);
// $ro = mysqli_fetch_array($run_doc);
// $check_portfolio = $ro['serice_id'];



// foreach (explode(",", ($check_portfolio)) as $service_id) {
//             $firstUnderscore = explode("_", $service_id);
//             $count++;
//             $column_for_table_heder = "";
//             switch ($firstUnderscore[1]) {
//                 case 'CLM':
//                     $column_for_table_heder = "SELECT `previous_balance` as fees, 'Opening Balance' as Source, `client_name` as applicant_name FROM `client_master` WHERE `transaction_id` = '" . $service_id . "'";
//                     break;
//                 case 'GST':
//                     $column_for_table_heder = "SELECT `consulting_fees` as fees, 'GST Fees' as Source, `client_name` as applicant_name FROM `gst_fees` WHERE `transaction_id` = '" . $service_id . "'";
//                     break;
//                 case 'ADV':
//                     $column_for_table_heder = "SELECT `fees` as fees, 'Advocade' as Source, `title_holder_name` as applicant_name FROM `advocade_case` WHERE `transaction_id` = '" . $service_id . "'";
//                     break;
//                 case 'ITR':
//                     $column_for_table_heder = "SELECT `fees`, 'IT Returns' as Source, `applicant_full_name` as applicant_name FROM `it_returns` WHERE `transaction_id` = '" . $service_id . "'";
//                     break;
//                 case 'PAN':
//                     $column_for_table_heder = "SELECT `fees`, 'PAN' as Source, `name_on_card` as applicant_name FROM `pan` WHERE `transaction_id` = '" . $service_id . "'";
//                     break;
//                 case 'TAN':
//                     $column_for_table_heder = "SELECT `fees`, 'TAN' as Source, `name_on_card` as applicant_name FROM `tan` WHERE `transaction_id` = '" . $service_id . "'";
//                     break;
//                 case 'TDS':
//                     $column_for_table_heder = "SELECT `fees`, 'E-TDS' as Source, `deductor_collector_name` as applicant_name FROM `e_tds` WHERE `transaction_id` = '" . $service_id . "'";
//                     break;
//                 case 'PSP':
//                     $column_for_table_heder = "SELECT `fees`, 'Coupon Distribution' as Source, `branch_code` as applicant_name FROM `psp` WHERE `transaction_id` = '" . $service_id . "'";
//                     break;
//                 case 'DA':
//                     $column_for_table_heder = "SELECT `fees`, 'DSC Applicant' as Source, `applicant_name` as applicant_name FROM `dsc_subscriber` WHERE `transaction_id` = '" . $service_id . "'";
//                     break;
//                 case 'TRD':
//                     $column_for_table_heder = "SELECT `bill_amt` as fees, 'Trade mark' as Source, `applicant_name` as applicant_name FROM `trade_mark` WHERE `transaction_id` = '" . $service_id . "'";
//                     break;
//                 case 'PTN':
//                     $column_for_table_heder = "SELECT `billing_amount` as fees, 'Patent' as Source, `applicant_name` as applicant_name FROM `patent` WHERE `transaction_id` = '" . $service_id . "'";
//                     break;
//                 case 'COP':
//                     $column_for_table_heder = "SELECT `billing_amount` as fees, 'Copy right' as Source, `applicant_name` as applicant_name FROM `copy_right` WHERE `transaction_id` = '" . $service_id . "'";
//                     break;
//                 case 'TRS':
//                     $column_for_table_heder = "SELECT `billing_amount` as fees, 'Trade Secret' as Source, `client_name` as applicant_name FROM `trade_secret` WHERE `transaction_id` = '" . $service_id . "'";
//                     break;
//                 case 'IDS':
//                     $column_for_table_heder = "SELECT `billing_amount` as fees, 'Industrial Design' as Source, `applicant_name` as applicant_name FROM `industrial_design` WHERE `transaction_id` = '" . $service_id . "'";
//                     break;
//                 case 'DP':
//                     $column_for_table_heder = "SELECT `fees`, 'DSC Partner' as Source, `stock_transfer_type` as applicant_name FROM `dsc_reseller` WHERE `transaction_id` = '" . $service_id . "'";
//                     break;
//                 case 'DT':
//                     $column_for_table_heder = "SELECT `fees`, 'DSC Token' as Source, `token_name` as applicant_name FROM `dsc_token` WHERE `transaction_id` = '" . $service_id . "'";
//                     break;
//                 case 'TND':
//                     $column_for_table_heder = "SELECT `bill_amu` as fees, 'E-Tender' as Source, `applicant_name` FROM `e_tender` WHERE `transaction_id` = '" . $service_id . "'";
//                     break;
//                 case 'OS':
//                     $column_for_table_heder = "SELECT `fees`, 'Other Services' as Source, `applicant_name` as applicant_name FROM `other_services` WHERE `transaction_id` = '" . $service_id . "'";
//                     break;
//                 case 'MOR':
//                     $column_for_table_heder = "SELECT `fees`, 'Mobile Repairing' as Source, `applicant_name` as applicant_name FROM `mobile_repairing` WHERE `transaction_id` = '" . $service_id . "'";
//                     break;
//                 case '24G':
//                     $column_for_table_heder = "SELECT `upload_fees` as fees, '24G' as Source, `ao_name` as applicant_name FROM `24g` WHERE `transaction_id` = '" . $service_id . "'";
//                     break;
//                 default:
//                     // Handle the case where the service type is unknown
//                     $column_for_table_heder = "";
//                     break;
//             }

//             if ($column_for_table_heder != "") {
//                 $run_FetchPortfolioRecords1 = mysqli_query($con, $column_for_table_heder);
//                 if (!$run_FetchPortfolioRecords1) {
//                     // Log or output the SQL query and error message for debugging
//                     error_log("Error executing query: " . $column_for_table_heder . " - " . mysqli_error($con));
//                     continue; // Skip this iteration and move to the next service_id
//                 }
//                 $output .= "
//         <tr>
//             <td style='font-size: 12px;'>$count</td>
//             <td style='font-size: 12px;'>$service_id</td>";
//                 while ($row = mysqli_fetch_array($run_FetchPortfolioRecords1)) {
//                     $output .= "<td style='font-size: 12px;'>" . $row['Source'] . "</td>";
//                     $output .= "<td style='font-size: 12px;'>" . $row['applicant_name'] . "</td>";
//                     $output .= "<td style='text-align: right; font-size: 12px;'>" . ($row['fees'] / $finalTax) . "</td>";
//                     $totalFees += ($row['fees'] / $finalTax);
//                 }
//                 $output .= "</tr>";
//             }
//         }


if (isset($_POST['client_name'])) {
    $client_name = $_POST['client_name'];

    // Query to get the company name where client_name matches
    $fetch_company_query = "SELECT company_name FROM client_master WHERE client_name = '$client_name' AND company_id = '" . $_SESSION['company_id'] . "'";
    $fetch_company_result = mysqli_query($con, $fetch_company_query);

    if ($fetch_company_result) {
        $company_row1 = mysqli_fetch_assoc($fetch_company_result);
        $company_name_client = $company_row1['company_name'];

        // Check if client_name and company_name are the same
        // If both are the same, display only client_name
        // if ($client_name == $company_name_client) {
        //     $client_and_company_name = $client_name;  // Display only client_name
        // } else {
        //     $client_and_company_name = $client_name . ' (' . $company_name_client . ')';  // Display client_name and company_name
        // }
    }

    // Get the type from recipient_name_setup
    $type_query = "SELECT type FROM recipient_name_setup";
    $type_result = mysqli_query($con, $type_query);
    $type_row = mysqli_fetch_assoc($type_result);
    $type = $type_row['type']; // Get the type

    // Assuming you are inside a loop where $row contains the client data
    switch ($type) {
        case 'Recipiet Name (Company Name)':
            // Display only client_name if client_name and company_name are the same
            if ($client_name == $company_name_client) {
                $display_value = $client_name; // Display client_name only
            } else {
                $display_value = $client_name . ' (' . $company_name_client . ')'; // Display client_name and company_name
            }
            break;
        case 'Comapny Name (Recipiet Name)':
            // Display only client_name if client_name and company_name are the same
            if ($client_name == $company_name_client) {
                $display_value = $client_name; // Display client_name only
            } else {
                $display_value = $company_name_client . ' (' . $client_name . ')'; // Display company_name (client_name)
            }
            break;
        case 'Recipient Name':
            $display_value = $client_name; // Just client_name
            break;
        case 'Company Name':
            $display_value = $company_name_client; // Just company_name
            break;
        default:
            $display_value = $client_name; // Fallback to client_name if no match
    }
}



        $output = "<table border='1' style='box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.2); border: 1px solid black;'>
    <tr style='height:100px; '>
        <td colspan='2' style='border:none;'>
            <img src='" . $base64 . "' alt='' width='80%' height='5.5%' class='comp_logo'>
        </td>
        <td colspan='3' style='font-size: 20px; font-weight: bold; text-align: center; border:none; '>Retail Invoice</td>
        <td colspan='1' style='font-size: 12px; align-items:center; justify-content:center; border:none;'> 
            <table align='right' style=''>
                <tr>
                    <td style='border-left:none; border-right:none; border-top:none;'>Retail Invoice Number : " . $_POST['retail_invoice_number'] . "</td>
                </tr>
                <tr>
                    <td style='border-left:none; border-right:none; border-top:none;'>Reference Number: " . $_POST['reference_number'] . "</td>
                </tr>
                <tr>
                    <td style='border-left:none; border-right:none; border-top:none;'>Billing Date: " . date('d-M-Y', strtotime($_POST['billing_date'])) . "</td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
    <td colspan='6' style='border-top:none; border-right:none; border-left:none;'></td>
    </tr>
    <td style='width:1%; font-size: 12px; border:none;'></td>
        <td colspan='3' style='font-size: 12px; text-align: left; vertical-align:top; border-left:none; border-top:none; border-bottom:none;'>
            <b style='margin: 0px;'>" . $company_name . "</b>
            <p style='margin: 0px;'>" . $company_address . "</p>
            <p style='margin: 0px'>GST No :" . $comapny_gst_no . "</p> 
            <p style='margin: 0px'>E-Mail : " . $company_email . "</p>
        </td>
        <td colspan='2' style='font-size: 12px; border-left:none; text-align: left; vertical-align:top; border-right:none; border-top:none; border-bottom:none;'>
            <p style='margin: 0px;'>To,</p>
            <b style='margin: 0px;'>" . $display_value . "</b>
            <p style='margin: 0px;'>Address: " . $client_address . "</p>
            <p style='margin: 0px;'>GSTIN/UIN : " . $gst_number_Fetch . "</p>
        </td>
    </tr>
    
";


        $output .= "<tr>
                <td colspan='6' style='font-size: 12px; font-weight: bold; text-align: center;  color: black;'>Description</td>

            </tr>";

        $input_service_ids = explode(',', $_POST['service_id']); // Split the service IDs into an array
        $index = 1; // Initialize row counter
        $totalFees = 0; // Initialize total fees

        $grouped_services = []; // Array to group service IDs by their ADV component

        // Group service IDs by their ADV value
        foreach ($input_service_ids as $service_id1) {
            // Extract ADV or equivalent from the service ID
            $input_parts = explode('_', $service_id1);
            $input_adv = $input_parts[1] ?? null; // Extract 'ADV'

            if ($input_adv) {
                // Group by ADV
                if (!isset($grouped_services[$input_adv])) {
                    $grouped_services[$input_adv] = [];
                }
                $grouped_services[$input_adv][] = $service_id1;
            } else {
                $output .= "<tr><td colspan='6' style='text-align: center;'>Invalid Service ID: $service_id1</td></tr>";
            }
        }

        // To avoid duplicate headers, we'll keep track of displayed portfolios
        $displayed_headers = [];

        foreach ($grouped_services as $adv => $service_ids) {
            // Check if the portfolio for this ADV has already been displayed
            if (!in_array($adv, $displayed_headers)) {
                $output .= "<tr style='font-size: 12px;'><td colspan='6' style='border:none;'>"; // Start the row

                // For each service group, find the matching portfolio and columns
                foreach ($service_ids as $service_id1) {
                    $input_parts = explode('_', $service_id1);
                    $input_adv = $input_parts[1] ?? null;

                    if ($input_adv) {
                        $found_match = false;

                        mysqli_data_seek($run_doc, 0); // Reset the pointer in the result set
                        while ($row = mysqli_fetch_assoc($run_doc)) {
                            $db_service_id = $row['serice_id'];
                            $db_parts = explode('_', $db_service_id);
                            $db_adv = $db_parts[1] ?? null;

                            if ($db_adv === $input_adv) {
                                $portfolio = $row['portfolio'];
                                $columns = explode(',', $row['column_name']);
                                $header_column = explode(',', $row['display_name']);
                                $found_match = true;
                                break;
                            }
                        }

                        if (!$found_match) {
                            $output .= "Portfolio Name: Not Found for Service ID: $service_id1</td></tr>";
                            continue;
                        }

                        // Display the portfolio name after finding a match
                        $output .= "Portfolio Name: " . htmlspecialchars($portfolio) . "</td></tr>";

                        // Table header
                        $output .= "<tr style='font-size: 12px;'><td colspan='6' style='text-align: center; border:none;'>
                            <table border='1' style='width: 100%; border-collapse: collapse;'>
                                <tr style='font-size: 12px;'>
                                    <td style='font-size: 12px; text-align: center;'>Sr No.</td>";

                        // Display column headers (only once per portfolio)
                        if (!in_array($portfolio, $displayed_headers)) {
                            foreach ($header_column as $column_value) {
                                $output .= "<td style='font-size: 12px; text-align: center;'>" . htmlspecialchars($column_value) . "</td>";
                            }
                            $displayed_headers[] = $portfolio; // Mark portfolio as displayed
                        }

                        // Fetch data for this portfolio
                        $query_inner = "SELECT " . implode(',', array_map(function ($col) {
                            return "`$col`";
                        }, $columns)) . " FROM `$portfolio` WHERE transaction_id = ?";

                        $stmt_inner = $con->prepare($query_inner);

                        if ($stmt_inner) {
                            $stmt_inner->bind_param('s', $service_id1);
                            $stmt_inner->execute();
                            $result_inner = $stmt_inner->get_result();

                            if ($result_inner->num_rows > 0) {
                                while ($row_inner = $result_inner->fetch_assoc()) {
                                    $output .= "<tr>";
                                    $output .= "<td style='text-align: center;'>" . $index++ . "</td>";

                                    foreach ($columns as $column_value) {
                                        $output .= "<td style='text-align: center;'>" . htmlspecialchars($row_inner[$column_value]) . "</td>";
                                    }

                                    $lastColumn = end($columns);
                                    $lastValue = htmlspecialchars($row_inner[$lastColumn]);

                                    $totalFees += is_numeric($lastValue) ? (float)$lastValue : 0;

                                    $output .= "</tr>";
                                }
                            } else {
                                $output .= "<tr><td colspan='" . (count($columns) + 1) . "' style='text-align: center;'>No data found for Service ID: $service_id1</td></tr>";
                            }

                            $stmt_inner->close();
                        } else {
                            $output .= "<tr><td colspan='" . (count($columns) + 1) . "' style='text-align: center;'>Query error: " . $con->error . "</td></tr>";
                        }

                        $output .= "</table></td></tr>";
                        break; // Once a portfolio is found and displayed, exit the loop
                    }
                }
            }
        }







     


        $output .= "<tr>
                    <td colspan='5' style='border-left:none; border-top:none;  text-align: right; font-size: 12px;'>Total Fees</td>
                    <td style='border-left:none; border-top:none;  text-align: right; font-size: 12px; border-right:none;'>" . $totalFees . "</td>
                </tr>
                
                <tr>
                    <td colspan='5' style=' text-align: right; font-size: 12px; border-left:none; border-top:none;'>Total Bill Value</td>
                    <td style=' text-align: right; font-size: 12px; border-left:none; border-top:none; border-right:none;'><b>" . ($totalFees) . "</b></td>
                </tr>
                <tr>
                    <td colspan='5' style=' text-align: right; font-size: 12px; border-left:none; border-top:none;'>Round Off </td>
                    <td style=' text-align: right; font-size: 12px; border-left:none; border-top:none; border-right:none;'>" . round($totalFees) . "</td>
                </tr>
                <tr>
                    <td colspan='4' style='border-left:none; border-top:none; font-size: 12px; text-align: left; width:50%; vertical-align:top; '>
                        <p style='margin: 0px;'>Our Bank Detail <br>
                        Bank Name :" . $company_bank_name . " <br>
                        A/c No. :" . $company_acc_no . " <br>
                        Branch & IFS Code :" . $comapny_branch_name . " " . $company_ifc_code . "</p>
                    </td>
                    <td rowspan='2' colspan='2' style='border-left:none; border-right:none; border-top:none; border-bottom:none; font-size: 12px; text-align: left; width:50%;'>
                        <div style='margin: 0px; padding: 0px; float: left; top: 0;text-align: right; width: 100%;'>for <b>$company_name</b></div><br><br><br><br><br><br>
                        <div style='width: 100%; float: right; text-align: right; margin: 0px; padding: 0px;'>Authorised Signature</div>
                    </td>
                </tr>
                <tr>
                    <td colspan='4' style='border-left:none; border-top:none; border-bottom:none; margin: 0px; font-size: 12px;'  padding: 0px;'>
                        <p style='margin: 0px; paddgin: 0px; text-align: left;'>Declaration</p>
                        <p style='margin: 0px; paddgin: 0px; text-align: left;'>We declare that this invoice shows the actual price of
                        the goods described and that all particulars are true
                        and correct.</p>
                    </td>
                </tr>";
        $output .= '</table>';
        $sql = "SELECT position, tems_cond_name FROM temps_condi_retail_invoice"; // Updated SQL to fetch ID
        $result = $con->query($sql);

        $terms = [];

        // Check if there are results
        if ($result->num_rows > 0) {
            // Fetch each term and store it in the array
            while ($row = $result->fetch_assoc()) {
                $terms[] = [
                    'position' => $row['position'], // Storing ID
                    'name' => $row['tems_cond_name'] // Storing term name
                ];
            }
        }


        // Building the output for Terms and Conditions
        $output .= '
        <p style="font-size: 14px; font-weight: bold; margin-bottom: 10px; text-decoration: underline;">Terms & Conditions</p>
        <div style="width: 100%;">';

        foreach ($terms as $term) {
            $output .= '<p style="font-size: 12px; margin:0 ; padding: 5px 0;">
                    ' . htmlspecialchars($term['position']) . '. ' . htmlspecialchars($term['name']) . '
                </p>';
        }

        $output .= '</div>';
    




// $output = '<table><tr><td>'.$_POST['client_name'].'</td></tr></table>';
$document->loadHtml($output);

// $document->setPaper('A4', 'landscape');
$document->setPaper('A4', 'portrait');

$document->render();

$font = $document->getFontMetrics()->get_font("arial");
$document->getCanvas()->page_text(530, 815, "Page {PAGE_NUM}/{PAGE_COUNT}", $font, 10, array(0, 0, 0));
$document->getCanvas()->page_text(35, 815, $_SESSION['username'], $font, 12, array(0, 0, 0));
//$font = $document->getFontMetrics()->get_font("Times", "bold");
//$document->getCanvas()->page_text(72, 18, "Page: {PAGE_NUM} of {PAGE_COUNT}", $font, 10, array(0,0,0));

$output = $document->output();
//Replace New PDF File
//unlink('Vowel Report.pdf');
//file_put_contents('Vowel Report.pdf', $output);
$document->stream("Tax Invoice " . date('d-m-Y'), array("Attachment" => 0));
