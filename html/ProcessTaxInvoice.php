<?php
session_start();
include_once 'connection.php';
date_default_timezone_set('Asia/Kolkata');
header('Content-Type: application/json');
if (isset($_POST['client_name']) && (!isset($_POST['bill_to_value']))) {
    $_SESSION['serviceIncomeClientName'] = $_POST['client_name'];
    $SentClient_name1 = $_POST['client_name'];
    $SentClient_name=explode(",",$SentClient_name1);
    $SentClient_name[1];
    $Client_id=$_POST['Client_id'];
    $client_name = [];
    $client_name_fees = [];
    $Complete_client_name_fees = [];
    $output = "";
    $Complete_output = "";
    $count = 0;
    $Complete_count = 0;
    
    $fetchBilledData = "SELECT * FROM `tax_invoice`  WHERE `company_id` = '".$_SESSION['company_id']."' AND `client_id` = '".$Client_id."'";
    $run_BilledData = mysqli_query($con,$fetchBilledData);
    
    $serviceId = [];
    $BillNumber = [];
    
      $fetch_portfolio_subscriber = "(
        SELECT `fees_received`, `transaction_id`, `id`,`registration_date` as date,`client_name`,`fees` as fees,`amount`,'DSC Applicant' as Source,`applicant_name` as applicant_name FROM `dsc_subscriber` WHERE `company_id` = '".$_SESSION['company_id']."' and `client_id`='".$Client_id."' AND `client_name` = '".$SentClient_name[1]."' AND `retail_invoice_number` = '') UNION (
        SELECT `fees_received`, `transaction_id`, `id`,`date`,`client_name`,`fees` as fees,`amount`,'DSC Partner' as Source,`stock_transfer_type` as applicant_name FROM `dsc_reseller` WHERE `company_id` = '".$_SESSION['company_id']."' AND `client_name` = '".$SentClient_name[1]."' and `client_id`='".$Client_id."' AND `retail_invoice_number` = '') UNION (
        SELECT `fees_received`, `transaction_id`, `id`,`date`,`client_name`,`fees` as fees,`amount`,'PAN' as Source,`name_on_card` as applicant_name FROM `pan` WHERE `company_id` = '".$_SESSION['company_id']."' AND `client_name` = '".$SentClient_name[1]."' and `client_id`='".$Client_id."' AND `retail_invoice_number` = '') UNION (
        SELECT `fees_received`, `transaction_id`, `id`,`date`,`client_name`,`fees` as fees,`amount`,'TAN' as Source,`name_on_card` as applicant_name FROM `tan` WHERE `company_id` = '".$_SESSION['company_id']."' AND `client_name` = '".$SentClient_name[1]."' and `client_id`='".$Client_id."' AND `retail_invoice_number` = '') UNION (
        SELECT `fees_received`, `transaction_id`, `id`,`receipt_date` as date,`client_name`,`fees` as fees,`amount`,'E-TDS' as Source,`deductor_collector_name` as applicant_name FROM `e_tds` WHERE `company_id` = '".$_SESSION['company_id']."' AND `client_name` = '".$SentClient_name[1]."' and `client_id`='".$Client_id."' AND `retail_invoice_number` = '') UNION (
        SELECT `fees_received`, `transaction_id`, `id`,`date`,`client_name`,`consulting_fees` as fees,`amount`,'GST Fees' as Source,`client_name` as applicant_name FROM `gst_fees` WHERE `company_id` = '".$_SESSION['company_id']."' AND `client_name` = '".$SentClient_name[1]."' and `client_id`='".$Client_id."' AND `retail_invoice_number` = '') UNION (
        SELECT `fees_received`, `transaction_id`, `id`,`date`,`client_name`,`billing_amount` as fees,`amount`,'Sales' as Source,`client_name` as applicant_name FROM `sales` WHERE `company_id` = '".$_SESSION['company_id']."' AND `client_name` = '".$SentClient_name[1]."' and `client_id`='".$Client_id."' AND `retail_invoice_number` = '') UNION (
        SELECT `fees_received`, `transaction_id`, `id`,`date`,`client_name`,`fees` as fees,`amount`,'Coupon Distribution' as Source,`branch_code` as applicant_name FROM `psp` WHERE `company_id` = '".$_SESSION['company_id']."' AND `client_name` = '".$SentClient_name[1]."' and `client_id`='".$Client_id."' AND `retail_invoice_number` = '') UNION (
        SELECT `fees_received`, `transaction_id`, `id`,`date`,`client_name`,`fees` as fees,`amount`,'Other Services' as Source,`applicant_name` as applicant_name FROM `other_services` WHERE `company_id` = '".$_SESSION['company_id']."' AND `client_name` = '".$SentClient_name[1]."' and `client_id`='".$Client_id."' AND `retail_invoice_number` = '') UNION (
        SELECT `fees_received`, `transaction_id`, `id`,`file_date` as date,`client_name`,`fees` as fees,`amount`,'Advocade' as Source,`title_holder_name` as applicant_name FROM `advocade_case` WHERE `company_id` = '".$_SESSION['company_id']."' AND `client_name` = '".$SentClient_name[1]."' and `client_id`='".$Client_id."' AND `retail_invoice_number` = '') UNION (
        
        SELECT `fees_received`, `transaction_id`, `id`,`date`,`client_name`,`fees` as fees,`amount`,'DSC Token' as Source,`token_name` as applicant_name FROM `dsc_token` WHERE `company_id` = '".$_SESSION['company_id']."' AND `client_name` = '".$SentClient_name[1]."' and `client_id`='".$Client_id."' AND `retail_invoice_number` = '') UNION (
        SELECT `fees_received`, `transaction_id`, `id`,`date`,`client_name`,`fees` as fees,`amount`,'IT Returns' as Source,`applicant_full_name` as applicant_name FROM `it_returns` WHERE `company_id` = '".$_SESSION['company_id']."' AND `client_name` = '".$SentClient_name[1]."' and `client_id`='".$Client_id."' AND `retail_invoice_number` = '') UNION (
        SELECT `fees_received`, `transaction_id`, `id`,`date`,`client_name`,`bill_amu` as fees,`amount`,'E-Tender' as Source,`applicant_name` FROM `e_tender` WHERE `company_id` = '".$_SESSION['company_id']."' AND `client_name` = '".$SentClient_name[1]."' and `client_id`='".$Client_id."' AND `retail_invoice_number` = '') UNION (
        SELECT `fees_received`, `transaction_id`, `id`,`date_application` as date,`client_name`,`bill_amt` as fees,`amount`,'Trade Mark' as Source,`applicant_name` FROM `trade_mark` WHERE `company_id` = '".$_SESSION['company_id']."' AND `client_name` = '".$SentClient_name[1]."' and `client_id`='".$Client_id."' AND `retail_invoice_number` = '') UNION (
        SELECT `fees_recived` as fees_received, `transaction_id`, `id`,`filling_date` as date,`client_name`,`billing_amount` as fees,`amount`,'Copy right' as Source,`client_name` as applicant_name FROM `copy_right` WHERE `company_id` = '".$_SESSION['company_id']."' AND `client_name` = '".$SentClient_name[1]."' and `client_id`='".$Client_id."' AND `retail_invoice_number` = '') UNION (
        SELECT `fees_recived` as fees_received , `transaction_id`, `id`,`filling_date` as date,`client_name`,`billing_amount` as fees,`amount`,'Patent' as Source,`applicant_name` FROM `patent` WHERE `company_id` = '".$_SESSION['company_id']."' AND `client_name` = '".$SentClient_name[1]."' and `client_id`='".$Client_id."' AND `retail_invoice_number` = '') UNION (
        SELECT `fees_recived` as fees_received , `transaction_id`, `id`,`date_of_filling` as date,`client_name`,`billing_amount` as fees,`amount`,'Trade Secret ' as Source,`client_name` as applicant_name FROM `trade_secret` WHERE `company_id` = '".$_SESSION['company_id']."' AND `client_name` = '".$SentClient_name[1]."' and `client_id`='".$Client_id."' AND `retail_invoice_number` = '') UNION (
        SELECT `fees_recived` as fees_received , `transaction_id`, `id`,`filling_date` as date,`client_name`,`billing_amount` as fees,`amount`,'Industrial Design ' as Source,`applicant_name` as applicant_name FROM `industrial_design` WHERE `company_id` = '".$_SESSION['company_id']."' AND `client_name` = '".$SentClient_name[1]."' and `client_id`='".$Client_id."' AND `retail_invoice_number` = '') UNION (
        SELECT `fees_received`, `transaction_id`, `id`,`receipt_date` as date,`client_name`,`upload_fees` as fees,`upload_fees` as amount,'24G' as Source,`ao_name` as applicant_name FROM `24g` WHERE `company_id` = '".$_SESSION['company_id']."' AND `client_name` = '".$SentClient_name[1]."' and `client_id`='".$Client_id."' AND `retail_invoice_number` = '') ORDER BY STR_TO_DATE(`date`, '%Y-%b-%d') DESC";
    
        $feesTotal = 0; 
        $feesReceivedTotal = 0;
        $fetchIdForServiceId = ''; // Initialize with a default value
        $ViewPageForServiceId = '';
        foreach($client_name_fees as $eachRow)
        {
            if ($eachRow[1] != '') {
                $Completed_firstUnderscore = explode("_", $eachRow[1]);
                if ($eachRow[1] != 'ADV_PMT') {
                    switch ($Completed_firstUnderscore[1]) {
                case 'CLM':
                    $fetchIdForServiceId = "SELECT * FROM `client_master` WHERE `transaction_id` = '" . $eachRow[1] . "'";
                    $ViewPageForServiceId = 'View_ClientMaster';
                    break;
                case 'GST':
                    $fetchIdForServiceId = "SELECT * FROM `gst_fees` WHERE `transaction_id` = '" . $eachRow[1] . "'";
                    $ViewPageForServiceId = 'View_GstFees';
                    break;
                case 'ITR':
                    $fetchIdForServiceId = "SELECT * FROM `it_returns` WHERE `transaction_id` = '" . $eachRow[1] . "'";
                    $ViewPageForServiceId = 'View_ItReturns';
                    break;
                case 'PAN':
                    $fetchIdForServiceId = "SELECT * FROM `pan` WHERE `transaction_id` = '" . $eachRow[1] . "'";
                    $ViewPageForServiceId = 'View_Pan';
                    break;
                case 'TND':
                    $fetchIdForServiceId = "SELECT * FROM `e_tender` WHERE `transaction_id` = '" . $eachRow[1] . "'";
                    $ViewPageForServiceId = 'View_Etender';
                    break;
                case 'TAN':
                    $fetchIdForServiceId = "SELECT * FROM `tan` WHERE `transaction_id` = '" . $eachRow[1] . "'";
                    $ViewPageForServiceId = 'View_Tan';
                    break;
                case 'TDS':
                    $fetchIdForServiceId = "SELECT * FROM `e_tds` WHERE `transaction_id` = '" . $eachRow[1] . "'";
                    $ViewPageForServiceId = 'View_ETds';
                    break;
                case 'PSP':
                    $fetchIdForServiceId = "SELECT * FROM `psp` WHERE `transaction_id` = '" . $eachRow[1] . "'";
                    $ViewPageForServiceId = 'View_PspDistribution';
                    break;
                case 'DA':
                    $fetchIdForServiceId = "SELECT * FROM `dsc_subscriber` WHERE `transaction_id` = '" . $eachRow[1] . "'";
                    $ViewPageForServiceId = 'View_DscApplicant';
                    break;
                case 'DP':
                    $fetchIdForServiceId = "SELECT * FROM `dsc_reseller` WHERE `transaction_id` = '" . $eachRow[1] . "'";
                    $ViewPageForServiceId = 'View_DscPartner';
                    break;
                case 'PTN':
                    $fetchIdForServiceId = "SELECT * FROM `patent` WHERE `transaction_id` = '" . $eachRow[1] . "'";
                    $ViewPageForServiceId = 'View_patent';
                    break;
                case 'ADV':
                    $fetchIdForServiceId = "SELECT * FROM `advocade_case` WHERE `transaction_id` = '" . $eachRow[1] . "'";
                    $ViewPageForServiceId = 'View_Advocate';
                    break;
                case 'COP':
                    $fetchIdForServiceId = "SELECT * FROM `copy_right` WHERE `transaction_id` = '" . $eachRow[1] . "'";
                    $ViewPageForServiceId = 'View_copy_right';
                    break;
                case 'TRS':
                    $fetchIdForServiceId = "SELECT * FROM `trade_secret` WHERE `transaction_id` = '" . $eachRow[1] . "'";
                    $ViewPageForServiceId = 'View_tradesecret';
                    break;
                case 'TRD':
                    $fetchIdForServiceId = "SELECT * FROM `trade_mark` WHERE `transaction_id` = '" . $eachRow[1] . "'";
                    $ViewPageForServiceId = 'View_Trade_mark';
                    break;
                case 'IDS':
                    $fetchIdForServiceId = "SELECT * FROM `industrial_design` WHERE `transaction_id` = '" . $eachRow[1] . "'";
                    $ViewPageForServiceId = 'View_industrial_design';
                    break;
                case 'DT':
                    $fetchIdForServiceId = "SELECT * FROM `dsc_token` WHERE `transaction_id` = '" . $eachRow[1] . "'";
                    $ViewPageForServiceId = 'View_TokenUsage';
                    break;
                case 'OS':
                    $fetchIdForServiceId = "SELECT * FROM `other_services` WHERE `transaction_id` = '" . $eachRow[1] . "'";
                    $ViewPageForServiceId = 'View_OtherService';
                    break;
                case '24G':
                    $fetchIdForServiceId = "SELECT * FROM `24g` WHERE `transaction_id` = '" . $eachRow[1] . "'";
                    $ViewPageForServiceId = 'View_24G';
                    break;
                case 'TSL':
                    $fetchIdForServiceId = "SELECT * FROM `sales` WHERE `transaction_id` = '" . $eachRow[1] . "'";
                    $ViewPageForServiceId = 'View_Sales';
                    break;
                case 'MOR':
                    $fetchIdForServiceId = "SELECT * FROM `mobile_repairing` WHERE `transaction_id` = '" . $eachRow[1] . "'";
                    $ViewPageForServiceId = 'View_mobile_repairing';
                    break;
                default:
                    echo "Unknown transaction type: " . $Completed_firstUnderscore[1];
                    break;
            }
                    $run_fetchIdForServiceId = mysqli_query($con,$fetchIdForServiceId);
                    $getIDForServiceId = mysqli_fetch_array($run_fetchIdForServiceId);
                }
            }
            // $feesTotal += number_format($eachRow[4], 2); 
            $feesTotal += $eachRow[4]; 
            $feesReceivedTotal += $eachRow[5];
            if ($_SESSION['user_type'] == 'system_user') {
                $BilledStatus = false;
                $billNumber = "";
                while ($BilledData = mysqli_fetch_array($run_BilledData)) {
                    array_push($serviceId, ["id" => $BilledData['service_id'], "bill_no" => $BilledData['tax_invoice_number']]);
                }
                for ($i=0; $i < COUNT($serviceId); $i++) { 
                    // $temp_serviceId = print_r($serviceId);
                    $id = explode(',', $serviceId[$i]['id']);
                    if(in_array($eachRow[1], $id)) {
                        $BilledStatus = true;
                        $billNumber = $serviceId[$i]['bill_no'];
                        break;
                    }else{
                        $BilledStatus = false;
                    }
                    // $temp_serviceId = $serviceId[$i]['id'];
                }
                if ($BilledStatus == true) {
                    $output .= "<tr>
                    <td class='tableLeftData'>".$billNumber."</td>
                    <td class='tableDate'><input type='hidden' id='thisSeviceId' readonly value='".$eachRow[1]."'><input type='hidden' id='thisAmount' readonly value='".number_format(($eachRow[4]), 2)."'>".date('d-m-Y', strtotime($eachRow[0]))."</td>
                    <td class='tableLeftData'>";
                    if ($eachRow[1] != 'ADV_PMT') {
                        $output .= '<form action='. $ViewPageForServiceId .' method="post" target="_blank">
                            <input type="hidden" readonly name="ViewID" value='. $getIDForServiceId['id'] .'>
                            <button class="btn btn-link">'. $eachRow[1] .'</button>
                        </form>';
                    } else { 
                        $output .= $eachRow[1];
                    }
                    $output .= "</td>
                    <td class='tableLeftData'>".$eachRow[2]."</td>
                    <td class='tableTotalAmount'>".$eachRow[3]."</td>
                    <td class='tableTotalAmount'>".number_format($eachRow[4], 2)."</td>
                    <td class='tableTotalAmount'>".$eachRow[5]."</td></tr>";
                }else{
                    $output .= "<tr>
                    <td class='tableLeftData'><input type='checkbox' name='addThisService' id='addThisService'></td>
                    <td class='tableDate'><input type='hidden' id='thisSeviceId' readonly value='".$eachRow[1]."'><input type='hidden' id='thisAmount' readonly value='".number_format(($eachRow[4]), 2)."'>".date('d-m-Y', strtotime($eachRow[0]))."</td>
                    <td class='tableLeftData'>";
                   if ($getIDForServiceId !== null && isset($eachRow[1]) && $eachRow[1] != 'ADV_PMT') {
                        $output .= '<form action=' . $ViewPageForServiceId . ' method="post" target="_blank">
                            <input type="hidden" readonly name="ViewID" value=' . $getIDForServiceId['id'] . '>
                            <button class="btn btn-link">' . $eachRow[1] . '</button>
                        </form>';
                    } elseif (isset($eachRow[1])) {
                        $output .= $eachRow[1];
                    } else {
                        // Handle the case where $eachRow[1] is not set or is null
                        $output .= 'Value not set';
                    }

                    $output .= "</td>
                    <td class='tableLeftData'>".$eachRow[2]."</td>
                    <td class='tableTotalAmount'>".$eachRow[3]."</td>
                    <td class='tableTotalAmount'>".number_format($eachRow[4], 2)."</td>
                    <td class='tableTotalAmount'>".$eachRow[5]."</td></tr>";                
                }   
            }else{
                $output .= "<tr>
                <td class='tableDate'><input type='hidden' id='thisSeviceId' readonly value='".$eachRow[1]."'><input type='hidden' id='thisAmount' readonly value='".($eachRow[4])."'>".date('d-m-Y', strtotime($eachRow[0]))."</td>
                <td class='tableLeftData'>";
                if ($eachRow[1] != 'ADV_PMT') {
                    $output .= '<form action='. $ViewPageForServiceId .' method="post" target="_blank">
                        <input type="hidden" readonly name="ViewID" value='. $getIDForServiceId['id'] .'>
                        <button class="btn btn-link">'. $eachRow[1] .'</button>
                    </form>';
                } else { 
                    $output .= $eachRow[1];
                }
                $output .= "</td>
                <td class='tableLeftData'>".$eachRow[2]."</td>
                <td class='tableTotalAmount'>".$eachRow[3]."</td>
                <td class='tableTotalAmount'>".number_format($eachRow[4], 2)."</td>
                <td class='tableTotalAmount'>".$eachRow[5]."</td></tr>";
            }
            $count++;
            /* if ($eachRow[3] == '') {
            } */
        }
        $pendingAmount = $feesTotal - $feesReceivedTotal;
        if ($count == 0) {
            $output = "<tr style='text-align:center;'><td colspan='4'>No Record Found!</td></tr>";
        }

        // Completed Portion
        $Complete_feesTotal = 0; 
        $Complete_feesReceivedTotal = 0; 
        $fetchIdForServiceId = ''; // Initialize with a default value
        $ViewPageForServiceId = '';
        foreach($Complete_client_name_fees as $eachRow)
        {
            if ($eachRow[1] != '') {
                $Completed_firstUnderscore = explode("_", $eachRow[1]);
                if ($eachRow[1] != 'ADV_PMT') {
                    switch ($Completed_firstUnderscore[1]) {
                case 'CLM':
                    $fetchIdForServiceId = "SELECT * FROM `client_master` WHERE `transaction_id` = '" . $eachRow[1] . "'";
                    $ViewPageForServiceId = 'View_ClientMaster';
                    break;
                case 'GST':
                    $fetchIdForServiceId = "SELECT * FROM `gst_fees` WHERE `transaction_id` = '" . $eachRow[1] . "'";
                    $ViewPageForServiceId = 'View_GstFees';
                    break;
                case 'ITR':
                    $fetchIdForServiceId = "SELECT * FROM `it_returns` WHERE `transaction_id` = '" . $eachRow[1] . "'";
                    $ViewPageForServiceId = 'View_ItReturns';
                    break;
                case 'PAN':
                    $fetchIdForServiceId = "SELECT * FROM `pan` WHERE `transaction_id` = '" . $eachRow[1] . "'";
                    $ViewPageForServiceId = 'View_Pan';
                    break;
                case 'TSL':
                    $fetchIdForServiceId = "SELECT * FROM `sales` WHERE `transaction_id` = '" . $eachRow[1] . "'";
                    $ViewPageForServiceId = 'View_Sales';
                case 'TND':
                    $fetchIdForServiceId = "SELECT * FROM `e_tender` WHERE `transaction_id` = '" . $eachRow[1] . "'";
                    $ViewPageForServiceId = 'View_Etender';
                    break;
                case 'TAN':
                    $fetchIdForServiceId = "SELECT * FROM `tan` WHERE `transaction_id` = '" . $eachRow[1] . "'";
                    $ViewPageForServiceId = 'View_Tan';
                    break;
                case 'TDS':
                    $fetchIdForServiceId = "SELECT * FROM `e_tds` WHERE `transaction_id` = '" . $eachRow[1] . "'";
                    $ViewPageForServiceId = 'View_ETds';
                    break;
                case 'PSP':
                    $fetchIdForServiceId = "SELECT * FROM `psp` WHERE `transaction_id` = '" . $eachRow[1] . "'";
                    $ViewPageForServiceId = 'View_PspDistribution';
                    break;
                case 'DA':
                    $fetchIdForServiceId = "SELECT * FROM `dsc_subscriber` WHERE `transaction_id` = '" . $eachRow[1] . "'";
                    $ViewPageForServiceId = 'View_DscApplicant';
                    break;
                case 'DP':
                    $fetchIdForServiceId = "SELECT * FROM `dsc_reseller` WHERE `transaction_id` = '" . $eachRow[1] . "'";
                    $ViewPageForServiceId = 'View_DscPartner';
                    break;
                case 'PTN':
                    $fetchIdForServiceId = "SELECT * FROM `patent` WHERE `transaction_id` = '" . $eachRow[1] . "'";
                    $ViewPageForServiceId = 'View_patent';
                    break;
                case 'COP':
                    $fetchIdForServiceId = "SELECT * FROM `copy_right` WHERE `transaction_id` = '" . $eachRow[1] . "'";
                    $ViewPageForServiceId = 'View_copy_right';
                    break;
                case 'TRS':
                    $fetchIdForServiceId = "SELECT * FROM `trade_secret` WHERE `transaction_id` = '" . $eachRow[1] . "'";
                    $ViewPageForServiceId = 'View_tradesecret';
                    break;
                case 'TRD':
                    $fetchIdForServiceId = "SELECT * FROM `trade_mark` WHERE `transaction_id` = '" . $eachRow[1] . "'";
                    $ViewPageForServiceId = 'View_Trade_mark';
                    break;
                case 'IDS':
                    $fetchIdForServiceId = "SELECT * FROM `industrial_design` WHERE `transaction_id` = '" . $eachRow[1] . "'";
                    $ViewPageForServiceId = 'View_industrial_design';
                    break;
                case 'DT':
                    $fetchIdForServiceId = "SELECT * FROM `dsc_token` WHERE `transaction_id` = '" . $eachRow[1] . "'";
                    $ViewPageForServiceId = 'View_TokenUsage';
                    break;
                case 'OS':
                    $fetchIdForServiceId = "SELECT * FROM `other_services` WHERE `transaction_id` = '" . $eachRow[1] . "'";
                    $ViewPageForServiceId = 'View_OtherService';
                    break;
                case 'MOR':
                    $fetchIdForServiceId = "SELECT * FROM `mobile_repairing` WHERE `transaction_id` = '" . $eachRow[1] . "'";
                    $ViewPageForServiceId = 'View_mobile_repairing';
                    break;
                case '24G':
                    $fetchIdForServiceId = "SELECT * FROM `24g` WHERE `transaction_id` = '" . $eachRow[1] . "'";
                    $ViewPageForServiceId = 'View_24G';
                    break;
                default:
                    echo "Unknown transaction type: " . $Completed_firstUnderscore[1];
                    break;
            }
                    $run_fetchIdForServiceId = mysqli_query($con,$fetchIdForServiceId);
                    $getIDForServiceId = mysqli_fetch_array($run_fetchIdForServiceId);
                }
            }
            // $Complete_feesTotal += number_format($eachRow[4], 2); 
            $Complete_feesTotal += $eachRow[4]; 
            $Complete_feesReceivedTotal += $eachRow[5];
            if ($_SESSION['user_type'] == 'system_user') {
                $BilledStatus = false;
                $billNumber = "";
                /* for($i=0; $i<COUNT($serviceId); $i++)
                {
                    if($eachRow[1] == $serviceId[$i]) {
                        $BilledStatus = true;
                        $billNumber = $BillNumber[$i];
                        break;
                    }else{
                        $BilledStatus = false;
                    }
                } */
                if ($BilledStatus == true) {
                    $Complete_output .= "<tr>
                    <td class='tableLeftData'>".$billNumber."</td>
                    <td class='tableDate'><input type='hidden' id='thisSeviceId' readonly value='".$eachRow[1]."'><input type='hidden' id='thisAmount' readonly value='".($eachRow[4])."'>".date('d-m-Y', strtotime($eachRow[0]))."</td>
                    <td class='tableLeftData'>";
                    if ($eachRow[1] != 'ADV_PMT') {
                        $Complete_output .= '<form action='. $ViewPageForServiceId .' method="post" target="_blank">
                            <input type="hidden" readonly name="ViewID" value='. $getIDForServiceId['id'] .'>
                            <button class="btn btn-link">'. $eachRow[1] .'</button>
                        </form>';
                    } else { 
                        $Complete_output .= $eachRow[1];
                    }
                    $Complete_output .= "</td>
                    <td class='tableLeftData'>".$eachRow[2]."</td>
                    <td class='tableTotalAmount'>".$eachRow[3]."</td>
                    <td class='tableTotalAmount'>".number_format($eachRow[4], 2)."</td>
                    <td class='tableTotalAmount'>".$eachRow[5]."</td></tr>";
                }else{
                    $Complete_output .= "<tr>
                    <td class='tableLeftData'><input type='checkbox' name='addThisService' id='addThisService'></td>
                    <td class='tableDate'><input type='hidden' id='thisSeviceId' readonly value='".$eachRow[1]."'><input type='hidden' id='thisAmount' readonly value='".($eachRow[4])."'>".date('d-m-Y', strtotime($eachRow[0]))."</td>
                    <td class='tableLeftData'>";
                    if ($eachRow[1] != 'ADV_PMT') {
                        $Complete_output .= '<form action='. $ViewPageForServiceId .' method="post" target="_blank">
                            <input type="hidden" readonly name="ViewID" value='. $getIDForServiceId['id'] .'>
                            <button class="btn btn-link">'. $eachRow[1] .'</button>
                        </form>';
                    } else { 
                        $Complete_output .= $eachRow[1];
                    }
                    $Complete_output .= "</td>
                    <td class='tableLeftData'>".$eachRow[2]."</td>
                    <td class='tableTotalAmount'>".$eachRow[3]."</td>
                    <td class='tableTotalAmount'>".number_format($eachRow[4], 2)."</td>
                    <td class='tableTotalAmount'>".$eachRow[5]."</td></tr>";
                }
            }else{
                $Complete_output .= "<tr>
                <td class='tableDate'><input type='hidden' id='thisSeviceId' readonly value='".$eachRow[1]."'><input type='hidden' id='thisAmount' readonly value='".($eachRow[4])."'>".date('d-m-Y', strtotime($eachRow[0]))."</td>
                <td class='tableLeftData'>";
                    if ($eachRow[1] != 'ADV_PMT') {
                        $output .= '<form action='. $ViewPageForServiceId .' method="post" target="_blank">
                            <input type="hidden" readonly name="ViewID" value='. $getIDForServiceId['id'] .'>
                            <button class="btn btn-link">'. $eachRow[1] .'</button>
                        </form>';
                    } else { 
                        $output .= $eachRow[1];
                    }
                    $output .= "</td>
                <td class='tableLeftData'>".$eachRow[2]."</td>
                <td class='tableTotalAmount'>".$eachRow[3]."</td>
                <td class='tableTotalAmount'>".number_format($eachRow[4], 2)."</td>
                <td class='tableTotalAmount'>".$eachRow[5]."</td></tr>";
            }
            $Complete_count++;
        }
        if ($Complete_count == 0) {
            $Complete_output = "<tr style='text-align:center;'><td colspan='4'>No Record Found!</td></tr>";
        }

        echo json_encode([$output,$pendingAmount,$Complete_output,$advanceAmount]);
    // }
}


if (isset($_POST['client_name']) && isset($_POST['bill_to_value'])) {
    $_SESSION['serviceIncomeClientName'] = $_POST['client_name'];
    $SentClient_name1 = $_POST['client_name'];
    $SentClient_name=explode(",",$SentClient_name1);
    $SentClient_name[1];
    $Client_id=$_POST['Client_id'];
    $client_name = [];
    // $Client_id=[];
    $client_name_fees = [];
    $Complete_client_name_fees = [];
    $output = "";
    $Complete_output = "";
    $count = 0;
    $Complete_count = 0;
    // UNION (SELECT `transaction_id`, `id`,`date`,`client_name`,SUM(`fees`) as fees,`amount`,'Audit' as Source FROM `audit` WHERE `company_id` = '".$_SESSION['company_id']."' AND `client_name` = '".$SentClient_name."' AND `retail_invoice_number` = '')
    //  UNION (SELECT `fees_received`, `transaction_id`, `id`,`date`,`client_name`,`fees` as fees,`amount`,'PSP Coupon Consumption' as Source FROM `psp_coupon_consumption` WHERE `company_id` = '".$_SESSION['company_id']."' AND `client_name` = '".$SentClient_name."' AND `retail_invoice_number` = '')
    $fetchBilledData = "SELECT * FROM `tax_invoice`  WHERE `company_id` = '".$_SESSION['company_id']."' AND `client_id` = '".$Client_id."'";
    $run_BilledData = mysqli_query($con,$fetchBilledData);
    
    //  $fetchBilledData1 = "SELECT `service_id`, `total_tax_value` FROM `tax_invoice` WHERE `company_id` = '".$_SESSION['company_id']."' AND `client_id` = '".$Client_id."'";
    // $result_billed = mysqli_query($con, $fetchBilledData1);
    
    // // Create an array to store service_id and total_tax_value pairs for comparison
    // $tax_invoices = [];
    // while ($row_billed = mysqli_fetch_assoc($result_billed)) {
    //     $tax_invoices[$row_billed['service_id']] = $row_billed['total_tax_value'];
    // }
    $fetchBilledData1 = "SELECT `service_id`, `total_tax_value` FROM `tax_invoice` 
                     WHERE `company_id` = '".$_SESSION['company_id']."' 
                     AND `client_id` = '".$Client_id."'";

$result_billed = mysqli_query($con, $fetchBilledData1);

// Create an array to store multiple tax invoice values per service_id
$tax_invoices = [];
while ($row_billed = mysqli_fetch_assoc($result_billed)) {
    $service_id = $row_billed['service_id'];
    $tax_value = is_numeric($row_billed['total_tax_value']) ? (float)$row_billed['total_tax_value'] : 0.00;

    // Store multiple values per service_id
    if (!isset($tax_invoices[$service_id])) {
        $tax_invoices[$service_id] = [];
    }
    $tax_invoices[$service_id][] = $tax_value;
}
    
    
    $serviceId = [];
    $BillNumber = [];
    
    
      $fetch_portfolio_subscriber = "(
        SELECT `fees_received`, `transaction_id`, `id`,`registration_date` as date,`client_name`,`fees` as fees,`amount`,'DSC Applicant' as Source,`applicant_name` as applicant_name FROM `dsc_subscriber` WHERE `company_id` = '".$_SESSION['company_id']."' and `client_id`='".$Client_id."' AND `client_name` = '".$SentClient_name[1]."' AND `retail_invoice_number` = '') UNION (
        SELECT `fees_received`, `transaction_id`, `id`,`date`,`client_name`,`fees` as fees,`amount`,'DSC Partner' as Source,`stock_transfer_type` as applicant_name FROM `dsc_reseller` WHERE `company_id` = '".$_SESSION['company_id']."' AND `client_name` = '".$SentClient_name[1]."' and `client_id`='".$Client_id."' AND `retail_invoice_number` = '') UNION (
        SELECT `fees_received`, `transaction_id`, `id`,`date`,`client_name`,`fees` as fees,`amount`,'PAN' as Source,`name_on_card` as applicant_name FROM `pan` WHERE `company_id` = '".$_SESSION['company_id']."' AND `client_name` = '".$SentClient_name[1]."' and `client_id`='".$Client_id."' AND `retail_invoice_number` = '') UNION (
        SELECT `fees_received`, `transaction_id`, `id`,`date`,`client_name`,`fees` as fees,`amount`,'TAN' as Source,`name_on_card` as applicant_name FROM `tan` WHERE `company_id` = '".$_SESSION['company_id']."' AND `client_name` = '".$SentClient_name[1]."' and `client_id`='".$Client_id."' AND `retail_invoice_number` = '') UNION (
        SELECT `fees_received`, `transaction_id`, `id`,`receipt_date` as date,`client_name`,`fees` as fees,`amount`,'E-TDS' as Source,`deductor_collector_name` as applicant_name FROM `e_tds` WHERE `company_id` = '".$_SESSION['company_id']."' AND `client_name` = '".$SentClient_name[1]."' and `client_id`='".$Client_id."' AND `retail_invoice_number` = '') UNION (
        SELECT `fees_received`, `transaction_id`, `id`,`date`,`client_name`,`consulting_fees` as fees,`amount`,'GST Fees' as Source,`client_name` as applicant_name FROM `gst_fees` WHERE `company_id` = '".$_SESSION['company_id']."' AND `client_name` = '".$SentClient_name[1]."' and `client_id`='".$Client_id."' AND `retail_invoice_number` = '') UNION (
        SELECT `fees_received`, `transaction_id`, `id`,`date`,`client_name`,`billing_amount` as fees,`amount`,'Sales' as Source,`client_name` as applicant_name FROM `sales` WHERE `company_id` = '".$_SESSION['company_id']."' AND `client_name` = '".$SentClient_name[1]."' and `client_id`='".$Client_id."' AND `retail_invoice_number` = '') UNION (
        SELECT `fees_received`, `transaction_id`, `id`,`date`,`client_name`,`fees` as fees,`amount`,'Coupon Distribution' as Source,`branch_code` as applicant_name FROM `psp` WHERE `company_id` = '".$_SESSION['company_id']."' AND `client_name` = '".$SentClient_name[1]."' and `client_id`='".$Client_id."' AND `retail_invoice_number` = '') UNION (
        SELECT `fees_received`, `transaction_id`, `id`,`date`,`client_name`,`fees` as fees,`amount`,'Other Services' as Source,`applicant_name` as applicant_name FROM `other_services` WHERE `company_id` = '".$_SESSION['company_id']."' AND `client_name` = '".$SentClient_name[1]."' and `client_id`='".$Client_id."' AND `retail_invoice_number` = '') UNION (
        SELECT `fees_received`, `transaction_id`, `id`,`file_date` as date,`client_name`,`fees` as fees,`amount`,'Advocade' as Source,`title_holder_name` as applicant_name FROM `advocade_case` WHERE `company_id` = '".$_SESSION['company_id']."' AND `client_name` = '".$SentClient_name[1]."' and `client_id`='".$Client_id."' AND `retail_invoice_number` = '') UNION (
        
        SELECT `fees_received`, `transaction_id`, `id`,`date`,`client_name`,`fees` as fees,`amount`,'DSC Token' as Source,`token_name` as applicant_name FROM `dsc_token` WHERE `company_id` = '".$_SESSION['company_id']."' AND `client_name` = '".$SentClient_name[1]."' and `client_id`='".$Client_id."' AND `retail_invoice_number` = '') UNION (
        SELECT `fees_received`, `transaction_id`, `id`,`date`,`client_name`,`fees` as fees,`amount`,'IT Returns' as Source,`applicant_full_name` as applicant_name FROM `it_returns` WHERE `company_id` = '".$_SESSION['company_id']."' AND `client_name` = '".$SentClient_name[1]."' and `client_id`='".$Client_id."' AND `retail_invoice_number` = '') UNION (
        SELECT `fees_received`, `transaction_id`, `id`,`date`,`client_name`,`bill_amu` as fees,`amount`,'E-Tender' as Source,`applicant_name` FROM `e_tender` WHERE `company_id` = '".$_SESSION['company_id']."' AND `client_name` = '".$SentClient_name[1]."' and `client_id`='".$Client_id."' AND `retail_invoice_number` = '') UNION (
        SELECT `fees_received`, `transaction_id`, `id`,`date_application` as date,`client_name`,`bill_amt` as fees,`amount`,'Trade Mark' as Source,`applicant_name` FROM `trade_mark` WHERE `company_id` = '".$_SESSION['company_id']."' AND `client_name` = '".$SentClient_name[1]."' and `client_id`='".$Client_id."' AND `retail_invoice_number` = '') UNION (
        SELECT `fees_recived` as fees_received, `transaction_id`, `id`,`filling_date` as date,`client_name`,`billing_amount` as fees,`amount`,'Copy right' as Source,`client_name` as applicant_name FROM `copy_right` WHERE `company_id` = '".$_SESSION['company_id']."' AND `client_name` = '".$SentClient_name[1]."' and `client_id`='".$Client_id."' AND `retail_invoice_number` = '') UNION (
        SELECT `fees_recived` as fees_received , `transaction_id`, `id`,`filling_date` as date,`client_name`,`billing_amount` as fees,`amount`,'Patent' as Source,`applicant_name` FROM `patent` WHERE `company_id` = '".$_SESSION['company_id']."' AND `client_name` = '".$SentClient_name[1]."' and `client_id`='".$Client_id."' AND `retail_invoice_number` = '') UNION (
        SELECT `fees_recived` as fees_received , `transaction_id`, `id`,`date_of_filling` as date,`client_name`,`billing_amount` as fees,`amount`,'Trade Secret ' as Source,`client_name` as applicant_name FROM `trade_secret` WHERE `company_id` = '".$_SESSION['company_id']."' AND `client_name` = '".$SentClient_name[1]."' and `client_id`='".$Client_id."' AND `retail_invoice_number` = '') UNION (
        SELECT `fees_recived` as fees_received , `transaction_id`, `id`,`filling_date` as date,`client_name`,`billing_amount` as fees,`amount`,'Industrial Design ' as Source,`applicant_name` as applicant_name FROM `industrial_design` WHERE `company_id` = '".$_SESSION['company_id']."' AND `client_name` = '".$SentClient_name[1]."' and `client_id`='".$Client_id."' AND `retail_invoice_number` = '') UNION (
        SELECT `fees_received`, `transaction_id`, `id`,`receipt_date` as date,`client_name`,`upload_fees` as fees,`upload_fees` as amount,'24G' as Source,`ao_name` as applicant_name FROM `24g` WHERE `company_id` = '".$_SESSION['company_id']."' AND `client_name` = '".$SentClient_name[1]."' and `client_id`='".$Client_id."' AND `retail_invoice_number` = '') ORDER BY STR_TO_DATE(`date`, '%Y-%b-%d') DESC";
    

    $fetch_Opening_Balance = "SELECT `fees_received`, `transaction_id`, `id`, `modify_date` as date, `client_name`, `previous_balance` as fees, 'Opening Balance' as Source, `advance_balance` FROM `client_master` WHERE `company_id` = '".$_SESSION['company_id']."' AND `client_name` = '".$SentClient_name[1]."' AND `retail_invoice_number` = '' and `transaction_id`='".$Client_id."'";

    if ($_SESSION['user_type'] == 'system_user') {
        $output = "<thead>
        <th style='font-weight: bold;' class='tableDate'>#</th>
        <th style='font-weight: bold;' class='tableDate'>Date of Transaction</th>
        <th style='font-weight: bold;' class='tableLeftData'>Service ID</th>
        <th style='font-weight: bold;' class='tableLeftData'>Portfolio</th>
        <th style='font-weight: bold;' class='tableLeftData'>Applicant Name</th>
        <th style='font-weight: bold;' class='tableLeftData'>Fees</th>
        <th style='font-weight: bold;' class='tableLeftData'>Fees Received</th></thead><tbody>";
    }else{
        $output = "<thead>
        <th style='font-weight: bold;' class='tableDate'>Date of Transaction</th>
        <th style='font-weight: bold;' class='tableLeftData'>Service ID</th>
        <th style='font-weight: bold;' class='tableLeftData'>Portfolio</th>
        <th style='font-weight: bold;' class='tableLeftData'>Applicant Name</th>
        <th style='font-weight: bold;' class='tableLeftData'>Fees</th>
        <th style='font-weight: bold;' class='tableLeftData'>Fees Received</th></thead><tbody>";
        
        $Complete_output = "<thead>
        <th style='font-weight: bold;' class='tableDate'>Date of Transaction</th>
        <th style='font-weight: bold;' class='tableLeftData'>Service ID</th>
        <th style='font-weight: bold;' class='tableLeftData'>Portfolio</th>
        <th style='font-weight: bold;' class='tableLeftData'>Applicant Name</th>
        <th style='font-weight: bold;' class='tableLeftData'>Fees</th>
        <th style='font-weight: bold;' class='tableLeftData'>Fees Received</th></thead><tbody>";
    }
    // echo $fetch_Opening_Balance;
    $row_1 = mysqli_query($con,$fetch_portfolio_subscriber);
    $row_2 = mysqli_query($con,$fetch_Opening_Balance);
    // echo $fetch_Opening_Balance;
    $advanceAmount = number_format(0, 2);
$client_name_fees = [];

    while ($rows2 = mysqli_fetch_array($row_2)) {
        //$client_vendor_name = $rows['client_name'];
        if ($rows2['fees'] > $rows2['fees_received']) {
            $Client_Details = [$rows2['date'],$rows2['transaction_id'],$rows2['Source'],'', $rows2['fees'], $rows2['fees_received']];
            array_push($client_name_fees, $Client_Details);
            $advanceAmount = $rows2['advance_balance'];
        }else if (($rows2['fees'] == $rows2['fees_received']) && ($rows2['fees'] != '0')) {
            $Complete_Client_Details = [$rows2['date'],$rows2['transaction_id'],$rows2['Source'],'', $rows2['fees'], $rows2['fees_received']];
            array_push($Complete_client_name_fees, $Complete_Client_Details);
            $advanceAmount = $rows2['advance_balance'];
        }
    }
    // while ($rows = mysqli_fetch_array($row_1)) {
    //     //$client_vendor_name = $rows['client_name'];
    //     $Client_Details = [$rows['date'],$rows['transaction_id'],$rows['Source'], $rows['applicant_name'], $rows['fees'], $rows['fees_received']];
    //     if ($rows['fees'] > $rows['fees_received']) {
    //         array_push($client_name_fees, $Client_Details);
    //     }else if (($rows['fees'] == $rows['fees_received']) && ($rows['fees'] != '0')) {
    //         // $Complete_Client_Details = [$rows2['date'],$rows2['transaction_id'],$rows2['Source'],'', $rows2['fees'], $rows2['fees_received']];
    //         array_push($Complete_client_name_fees, $Client_Details);
    //         // $Complete_count++;
    //     }
    //     //array_push($client_vendor_name, $tempClientName);
    //     //echo nl2br($rows['fees']." ".$tempClientName." ".$total_fees." ".$clientCount." ".$prev_clientCount."\n");
    //     //echo nl2br(max($client_name_fees)."\n");
    //     // echo $Client_Details;
    //     // echo $Complete_Client_Details[0];
    //     // echo count($client_name_fees);
    //     // echo $Complete_count;
    // }
    
    while ($rows = mysqli_fetch_array($row_1)) {
    // Create an array with the initial client details
    $Client_Details = [
        $rows['date'], 
        $rows['transaction_id'], 
        $rows['Source'], 
        $rows['applicant_name'], 
        $rows['fees'], 
        $rows['fees_received']
    ];

    // Check if the transaction_id from portfolio matches any service_id in tax_invoice
    if (isset($tax_invoices[$rows['transaction_id']])) {
        // Get all tax invoice values associated with this transaction_id
        $total_tax_values = $tax_invoices[$rows['transaction_id']];

        // Sum up all tax invoice values
        $sum_total_tax_value = array_sum($total_tax_values);

        // Add the summed total tax value to the client details
        array_push($Client_Details, $sum_total_tax_value);

        // Compare total tax invoice sum with fees
        if ($sum_total_tax_value != $rows['fees']) {
            // Store this entry if the total tax invoice does not match the fees
            array_push($client_name_fees, $Client_Details);
        }
    }
}

    // echo count($Complete_client_name_fees);
    // print_r($Complete_client_name_fees);
    // if (count($client_name_fees) > 0) {
        $feesTotal = 0; 
        $feesReceivedTotal = 0;
        $fetchIdForServiceId = ''; // Initialize with a default value
        $ViewPageForServiceId = '';
        foreach($client_name_fees as $eachRow)
        {
            if ($eachRow[1] != '') {
                $Completed_firstUnderscore = explode("_", $eachRow[1]);
                if ($eachRow[1] != 'ADV_PMT') {
                    switch ($Completed_firstUnderscore[1]) {
                case 'CLM':
                    $fetchIdForServiceId = "SELECT * FROM `client_master` WHERE `transaction_id` = '" . $eachRow[1] . "'";
                    $ViewPageForServiceId = 'View_ClientMaster';
                    break;
                case 'GST':
                    $fetchIdForServiceId = "SELECT * FROM `gst_fees` WHERE `transaction_id` = '" . $eachRow[1] . "'";
                    $ViewPageForServiceId = 'View_GstFees';
                    break;
                case 'ITR':
                    $fetchIdForServiceId = "SELECT * FROM `it_returns` WHERE `transaction_id` = '" . $eachRow[1] . "'";
                    $ViewPageForServiceId = 'View_ItReturns';
                    break;
                case 'PAN':
                    $fetchIdForServiceId = "SELECT * FROM `pan` WHERE `transaction_id` = '" . $eachRow[1] . "'";
                    $ViewPageForServiceId = 'View_Pan';
                    break;
                case 'TND':
                    $fetchIdForServiceId = "SELECT * FROM `e_tender` WHERE `transaction_id` = '" . $eachRow[1] . "'";
                    $ViewPageForServiceId = 'View_Etender';
                    break;
                case 'TAN':
                    $fetchIdForServiceId = "SELECT * FROM `tan` WHERE `transaction_id` = '" . $eachRow[1] . "'";
                    $ViewPageForServiceId = 'View_Tan';
                    break;
                case 'TDS':
                    $fetchIdForServiceId = "SELECT * FROM `e_tds` WHERE `transaction_id` = '" . $eachRow[1] . "'";
                    $ViewPageForServiceId = 'View_ETds';
                    break;
                case 'PSP':
                    $fetchIdForServiceId = "SELECT * FROM `psp` WHERE `transaction_id` = '" . $eachRow[1] . "'";
                    $ViewPageForServiceId = 'View_PspDistribution';
                    break;
                case 'DA':
                    $fetchIdForServiceId = "SELECT * FROM `dsc_subscriber` WHERE `transaction_id` = '" . $eachRow[1] . "'";
                    $ViewPageForServiceId = 'View_DscApplicant';
                    break;
                case 'DP':
                    $fetchIdForServiceId = "SELECT * FROM `dsc_reseller` WHERE `transaction_id` = '" . $eachRow[1] . "'";
                    $ViewPageForServiceId = 'View_DscPartner';
                    break;
                case 'PTN':
                    $fetchIdForServiceId = "SELECT * FROM `patent` WHERE `transaction_id` = '" . $eachRow[1] . "'";
                    $ViewPageForServiceId = 'View_patent';
                    break;
                case 'ADV':
                    $fetchIdForServiceId = "SELECT * FROM `advocade_case` WHERE `transaction_id` = '" . $eachRow[1] . "'";
                    $ViewPageForServiceId = 'View_Advocate';
                    break;
                case 'COP':
                    $fetchIdForServiceId = "SELECT * FROM `copy_right` WHERE `transaction_id` = '" . $eachRow[1] . "'";
                    $ViewPageForServiceId = 'View_copy_right';
                    break;
                case 'TRS':
                    $fetchIdForServiceId = "SELECT * FROM `trade_secret` WHERE `transaction_id` = '" . $eachRow[1] . "'";
                    $ViewPageForServiceId = 'View_tradesecret';
                    break;
                case 'TRD':
                    $fetchIdForServiceId = "SELECT * FROM `trade_mark` WHERE `transaction_id` = '" . $eachRow[1] . "'";
                    $ViewPageForServiceId = 'View_Trade_mark';
                    break;
                case 'IDS':
                    $fetchIdForServiceId = "SELECT * FROM `industrial_design` WHERE `transaction_id` = '" . $eachRow[1] . "'";
                    $ViewPageForServiceId = 'View_industrial_design';
                    break;
                case 'DT':
                    $fetchIdForServiceId = "SELECT * FROM `dsc_token` WHERE `transaction_id` = '" . $eachRow[1] . "'";
                    $ViewPageForServiceId = 'View_TokenUsage';
                    break;
                case 'OS':
                    $fetchIdForServiceId = "SELECT * FROM `other_services` WHERE `transaction_id` = '" . $eachRow[1] . "'";
                    $ViewPageForServiceId = 'View_OtherService';
                    break;
                case '24G':
                    $fetchIdForServiceId = "SELECT * FROM `24g` WHERE `transaction_id` = '" . $eachRow[1] . "'";
                    $ViewPageForServiceId = 'View_24G';
                    break;
                case 'TSL':
                    $fetchIdForServiceId = "SELECT * FROM `sales` WHERE `transaction_id` = '" . $eachRow[1] . "'";
                    $ViewPageForServiceId = 'View_Sales';
                    break;
                case 'MOR':
                    $fetchIdForServiceId = "SELECT * FROM `mobile_repairing` WHERE `transaction_id` = '" . $eachRow[1] . "'";
                    $ViewPageForServiceId = 'View_mobile_repairing';
                    break;
                default:
                    echo "Unknown transaction type: " . $Completed_firstUnderscore[1];
                    break;
            }
                    $run_fetchIdForServiceId = mysqli_query($con,$fetchIdForServiceId);
                    $getIDForServiceId = mysqli_fetch_array($run_fetchIdForServiceId);
                }
            }
            // $feesTotal += number_format($eachRow[4], 2); 
            $feesTotal += $eachRow[4]; 
            $feesReceivedTotal += $eachRow[5];
            if ($_SESSION['user_type'] == 'system_user') {
                $BilledStatus = false;
                $billNumber = "";
                // while ($BilledData = mysqli_fetch_array($run_BilledData)) {
                //     array_push($serviceId, ["id" => $difference['service_id'], "bill_no" => $BilledData['tax_invoice_number']]);
                // }
                for ($i=0; $i < COUNT($serviceId); $i++) { 
                    // $temp_serviceId = print_r($serviceId);
                    $id = explode(',', $serviceId[$i]['id']);
                    if(in_array($eachRow[1], $id)) {
                        $BilledStatus = true;
                        $billNumber = $serviceId[$i]['bill_no'];
                        break;
                    }else{
                        $BilledStatus = false;
                    }
                    // $temp_serviceId = $serviceId[$i]['id'];
                }
                if ($BilledStatus == true) {
                    $output .= "<tr>
                    $difference = number_format($eachRow[4] - $eachRow[6], 2); // Difference between fees and fees_received
                    <td class='tableLeftData'>".$billNumber."</td>
                    <td class='tableDate'><input type='hidden' id='thisSeviceId' readonly value='".$eachRow[1]."'><input type='hidden' id='thisAmount' readonly value='".number_format(($difference), 2)."'>".date('d-m-Y', strtotime($eachRow[0]))."</td>
                    <td class='tableLeftData'>";
                    if ($eachRow[1] != 'ADV_PMT') {
                        $output .= '<form action='. $ViewPageForServiceId .' method="post" target="_blank">
                            <input type="hidden" readonly name="ViewID" value='. $getIDForServiceId['id'] .'>
                            <button class="btn btn-link">'. $eachRow[1] .'</button>
                        </form>';
                    } else { 
                        $output .= $eachRow[1];
                    }
                    $output .= "</td>
                    <td class='tableLeftData'>".$eachRow[2]."</td>
                    <td class='tableTotalAmount'>".$eachRow[3]."</td>
                    <td class='tableTotalAmount'>".number_format($difference, 2)."</td>
                    <td class='tableTotalAmount'>".$eachRow[5]."</td></tr>";
                }else{
// Debugging: Check values before calculation
$fees_raw = $eachRow[4];
$fees_received_raw = $eachRow[6];

// Ensure both values are numeric, or set them to 0 if they are not
$fees = is_numeric($fees_raw) ? (float)$fees_raw : 0.00;
$fees_received = is_numeric($fees_received_raw) ? (float)$fees_received_raw : 0.00;

// Debugging: Print values for verification (remove in production)
error_log("fees: " . $fees . " | fees_received: " . $fees_received);

// Calculate the difference safely
$difference = $fees - $fees_received;

// Ensure difference is properly formatted
$differenceFormatted = number_format($difference, 2);

$output .= "<tr>
    <td class='tableLeftData'><input type='checkbox' name='addThisService' id='addThisService'></td>
    <td class='tableDate'>
        <input type='hidden' id='thisSeviceId' readonly value='".htmlspecialchars($eachRow[1])."'>
        <input type='hidden' id='thisAmount' readonly value='".$differenceFormatted."'>".
        date('d-m-Y', strtotime($eachRow[0]))."
    </td>
    <td class='tableLeftData'>";

// Handle the service ID logic correctly
if ($getIDForServiceId !== null && isset($eachRow[1]) && $eachRow[1] != 'ADV_PMT') {
    $output .= '<form action="' . htmlspecialchars($ViewPageForServiceId) . '" method="post" target="_blank">
        <input type="hidden" readonly name="ViewID" value="' . htmlspecialchars($getIDForServiceId['id']) . '">
        <button class="btn btn-link">' . htmlspecialchars($eachRow[1]) . '</button>
    </form>';
} elseif (isset($eachRow[1])) {
    $output .= htmlspecialchars($eachRow[1]);
} else {
    $output .= 'Value not set';
}

$output .= "</td>
    <td class='tableLeftData'>".htmlspecialchars($eachRow[2])."</td>
    <td class='tableTotalAmount'>".htmlspecialchars($eachRow[3])."</td>
    <td class='tableTotalAmount'>".$differenceFormatted."</td>
    <td class='tableTotalAmount'>".htmlspecialchars($eachRow[5])."</td>
</tr>";
            
                }   
            }else{
                $difference = number_format($eachRow[4] - $eachRow[6], 2); // Difference between fees and fees_received
                $output .= "<tr>
                <td class='tableDate'><input type='hidden' id='thisSeviceId' readonly value='".$eachRow[1]."'><input type='hidden' id='thisAmount' readonly value='".($difference)."'>".date('d-m-Y', strtotime($eachRow[0]))."</td>
                <td class='tableLeftData'>";
                if ($eachRow[1] != 'ADV_PMT') {
                    $output .= '<form action='. $ViewPageForServiceId .' method="post" target="_blank">
                        <input type="hidden" readonly name="ViewID" value='. $getIDForServiceId['id'] .'>
                        <button class="btn btn-link">'. $eachRow[1] .'</button>
                    </form>';
                } else { 
                    $output .= $eachRow[1];
                }
                $output .= "</td>
                <td class='tableLeftData'>".$eachRow[2]."</td>
                <td class='tableTotalAmount'>".$eachRow[3]."</td>
                <td class='tableTotalAmount'>".number_format($difference, 2)."</td>
                <td class='tableTotalAmount'>".$eachRow[5]."</td></tr>";
            }
            $count++;
        }
        $pendingAmount = $feesTotal - $feesReceivedTotal;
        if ($count == 0) {
            $output = "<tr style='text-align:center;'><td colspan='4'>No Record Found!</td></tr>";
        }

        // Completed Portion
        $Complete_feesTotal = 0; 
        $Complete_feesReceivedTotal = 0; 
        $fetchIdForServiceId = ''; // Initialize with a default value
        $ViewPageForServiceId = '';
        foreach($Complete_client_name_fees as $eachRow)
        {
            if ($eachRow[1] != '') {
                $Completed_firstUnderscore = explode("_", $eachRow[1]);
                if ($eachRow[1] != 'ADV_PMT') {
                    switch ($Completed_firstUnderscore[1]) {
                case 'CLM':
                    $fetchIdForServiceId = "SELECT * FROM `client_master` WHERE `transaction_id` = '" . $eachRow[1] . "'";
                    $ViewPageForServiceId = 'View_ClientMaster';
                    break;
                case 'GST':
                    $fetchIdForServiceId = "SELECT * FROM `gst_fees` WHERE `transaction_id` = '" . $eachRow[1] . "'";
                    $ViewPageForServiceId = 'View_GstFees';
                    break;
                case 'ITR':
                    $fetchIdForServiceId = "SELECT * FROM `it_returns` WHERE `transaction_id` = '" . $eachRow[1] . "'";
                    $ViewPageForServiceId = 'View_ItReturns';
                    break;
                case 'PAN':
                    $fetchIdForServiceId = "SELECT * FROM `pan` WHERE `transaction_id` = '" . $eachRow[1] . "'";
                    $ViewPageForServiceId = 'View_Pan';
                    break;
                case 'TSL':
                    $fetchIdForServiceId = "SELECT * FROM `sales` WHERE `transaction_id` = '" . $eachRow[1] . "'";
                    $ViewPageForServiceId = 'View_Sales';
                case 'TND':
                    $fetchIdForServiceId = "SELECT * FROM `e_tender` WHERE `transaction_id` = '" . $eachRow[1] . "'";
                    $ViewPageForServiceId = 'View_Etender';
                    break;
                case 'TAN':
                    $fetchIdForServiceId = "SELECT * FROM `tan` WHERE `transaction_id` = '" . $eachRow[1] . "'";
                    $ViewPageForServiceId = 'View_Tan';
                    break;
                case 'TDS':
                    $fetchIdForServiceId = "SELECT * FROM `e_tds` WHERE `transaction_id` = '" . $eachRow[1] . "'";
                    $ViewPageForServiceId = 'View_ETds';
                    break;
                case 'PSP':
                    $fetchIdForServiceId = "SELECT * FROM `psp` WHERE `transaction_id` = '" . $eachRow[1] . "'";
                    $ViewPageForServiceId = 'View_PspDistribution';
                    break;
                case 'DA':
                    $fetchIdForServiceId = "SELECT * FROM `dsc_subscriber` WHERE `transaction_id` = '" . $eachRow[1] . "'";
                    $ViewPageForServiceId = 'View_DscApplicant';
                    break;
                case 'DP':
                    $fetchIdForServiceId = "SELECT * FROM `dsc_reseller` WHERE `transaction_id` = '" . $eachRow[1] . "'";
                    $ViewPageForServiceId = 'View_DscPartner';
                    break;
                case 'PTN':
                    $fetchIdForServiceId = "SELECT * FROM `patent` WHERE `transaction_id` = '" . $eachRow[1] . "'";
                    $ViewPageForServiceId = 'View_patent';
                    break;
                case 'COP':
                    $fetchIdForServiceId = "SELECT * FROM `copy_right` WHERE `transaction_id` = '" . $eachRow[1] . "'";
                    $ViewPageForServiceId = 'View_copy_right';
                    break;
                case 'TRS':
                    $fetchIdForServiceId = "SELECT * FROM `trade_secret` WHERE `transaction_id` = '" . $eachRow[1] . "'";
                    $ViewPageForServiceId = 'View_tradesecret';
                    break;
                case 'TRD':
                    $fetchIdForServiceId = "SELECT * FROM `trade_mark` WHERE `transaction_id` = '" . $eachRow[1] . "'";
                    $ViewPageForServiceId = 'View_Trade_mark';
                    break;
                case 'IDS':
                    $fetchIdForServiceId = "SELECT * FROM `industrial_design` WHERE `transaction_id` = '" . $eachRow[1] . "'";
                    $ViewPageForServiceId = 'View_industrial_design';
                    break;
                case 'DT':
                    $fetchIdForServiceId = "SELECT * FROM `dsc_token` WHERE `transaction_id` = '" . $eachRow[1] . "'";
                    $ViewPageForServiceId = 'View_TokenUsage';
                    break;
                case 'OS':
                    $fetchIdForServiceId = "SELECT * FROM `other_services` WHERE `transaction_id` = '" . $eachRow[1] . "'";
                    $ViewPageForServiceId = 'View_OtherService';
                    break;
                case 'MOR':
                    $fetchIdForServiceId = "SELECT * FROM `mobile_repairing` WHERE `transaction_id` = '" . $eachRow[1] . "'";
                    $ViewPageForServiceId = 'View_mobile_repairing';
                    break;
                case '24G':
                    $fetchIdForServiceId = "SELECT * FROM `24g` WHERE `transaction_id` = '" . $eachRow[1] . "'";
                    $ViewPageForServiceId = 'View_24G';
                    break;
                default:
                    echo "Unknown transaction type: " . $Completed_firstUnderscore[1];
                    break;
            }
                    $run_fetchIdForServiceId = mysqli_query($con,$fetchIdForServiceId);
                    $getIDForServiceId = mysqli_fetch_array($run_fetchIdForServiceId);
                }
            }
            // $Complete_feesTotal += number_format($eachRow[4], 2); 
            $Complete_feesTotal += $eachRow[4]; 
            $Complete_feesReceivedTotal += $eachRow[5];
            if ($_SESSION['user_type'] == 'system_user') {
                $BilledStatus = false;
                $billNumber = "";
                
                if ($BilledStatus == true) {
                    $Complete_output .= "<tr>
                    <td class='tableLeftData'>".$billNumber."</td>
                    <td class='tableDate'><input type='hidden' id='thisSeviceId' readonly value='".$eachRow[1]."'><input type='hidden' id='thisAmount' readonly value='".($eachRow[4])."'>".date('d-m-Y', strtotime($eachRow[0]))."</td>
                    <td class='tableLeftData'>";
                    if ($eachRow[1] != 'ADV_PMT') {
                        $Complete_output .= '<form action='. $ViewPageForServiceId .' method="post" target="_blank">
                            <input type="hidden" readonly name="ViewID" value='. $getIDForServiceId['id'] .'>
                            <button class="btn btn-link">'. $eachRow[1] .'</button>
                        </form>';
                    } else { 
                        $Complete_output .= $eachRow[1];
                    }
                    $difference = number_format($eachRow[4] - $eachRow[6], 2); // Difference between fees and fees_received
                    $Complete_output .= "</td>
                    <td class='tableLeftData'>".$eachRow[2]."</td>
                    <td class='tableTotalAmount'>".$eachRow[3]."</td>
                    <td class='tableTotalAmount'>".number_format($difference, 2)."</td>
                    <td class='tableTotalAmount'>".$eachRow[5]."</td></tr>";
                }else{
                    $Complete_output .= "<tr>
                    <td class='tableLeftData'><input type='checkbox' name='addThisService' id='addThisService'></td>
                    <td class='tableDate'><input type='hidden' id='thisSeviceId' readonly value='".$eachRow[1]."'><input type='hidden' id='thisAmount' readonly value='".($eachRow[4])."'>".date('d-m-Y', strtotime($eachRow[0]))."</td>
                    <td class='tableLeftData'>";
                    if ($eachRow[1] != 'ADV_PMT') {
                        $Complete_output .= '<form action='. $ViewPageForServiceId .' method="post" target="_blank">
                            <input type="hidden" readonly name="ViewID" value='. $getIDForServiceId['id'] .'>
                            <button class="btn btn-link">'. $eachRow[1] .'</button>
                        </form>';
                    } else { 
                        $Complete_output .= $eachRow[1];
                    }
                    $difference = number_format($eachRow[4] - $eachRow[6], 2); // Difference between fees and fees_received
                    $Complete_output .= "</td>
                    <td class='tableLeftData'>".$eachRow[2]."</td>
                    <td class='tableTotalAmount'>".$eachRow[3]."</td>
                    <td class='tableTotalAmount'>".number_format($difference, 2)."</td>
                    <td class='tableTotalAmount'>".$eachRow[5]."</td></tr>";
                }
            }else{
                $Complete_output .= "<tr>
                <td class='tableDate'><input type='hidden' id='thisSeviceId' readonly value='".$eachRow[1]."'><input type='hidden' id='thisAmount' readonly value='".($eachRow[4])."'>".date('d-m-Y', strtotime($eachRow[0]))."</td>
                <td class='tableLeftData'>";
                    if ($eachRow[1] != 'ADV_PMT') {
                        $output .= '<form action='. $ViewPageForServiceId .' method="post" target="_blank">
                            <input type="hidden" readonly name="ViewID" value='. $getIDForServiceId['id'] .'>
                            <button class="btn btn-link">'. $eachRow[1] .'</button>
                        </form>';
                    } else { 
                        $output .= $eachRow[1];
                    }
                    $difference = number_format($eachRow[4] - $eachRow[6], 2); // Difference between fees and fees_received
                    $output .= "</td>
                <td class='tableLeftData'>".$eachRow[2]."</td>
                <td class='tableTotalAmount'>".$eachRow[3]."</td>
                <td class='tableTotalAmount'>".number_format($difference, 2)."</td>
                <td class='tableTotalAmount'>".$eachRow[5]."</td></tr>";
            }
            $Complete_count++;
        }
        if ($Complete_count == 0) {
            $Complete_output = "<tr style='text-align:center;'><td colspan='4'>No Record Found!</td></tr>";
        }
        
        echo json_encode([$output,$pendingAmount,$Complete_output,$advanceAmount]);
}

if (isset($_POST['invoice_number'])) {
    $invoice_number = $_POST['invoice_number'];
    $financialYearInput=$_POST['financialYearInput'];
    
    $fetch_TaxInvoiceNumber = "SELECT `tax_invoice_number` FROM `tax_invoice` WHERE `tax_invoice_number` = '".$invoice_number."' and `financial_year` ='".$financialYearInput."' AND `company_id` = '".$_SESSION['company_id']."'";
    $run_fetch_TaxInvoiceNumber = mysqli_query($con,$fetch_TaxInvoiceNumber);
    if(mysqli_num_rows($run_fetch_TaxInvoiceNumber) > 0){
        echo 'tax_invoice_exist';
    }else{
        echo 'tax_invoice_not_exist';
    }
    // $row = mysqli_fetch_array($run_fetch_TaxInvoiceNumber);
}
if(isset($_POST['year'])) {
    echo "sd";
}

$response = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['send_temps_cond'])) {
        // Handle Add Request
        $send_Service = mysqli_real_escape_string($con, trim($_POST['send_temps_cond']));
        $position_num = mysqli_real_escape_string($con, trim($_POST['position_number']));
        $optional_value = isset($_POST['optional_value']) ? mysqli_real_escape_string($con, $_POST['optional_value']) : "0";

        if (empty($send_Service) || empty($position_num)) {
            $response = ["success" => false, "error" => "Position and Terms & Conditions are required!"];
        } elseif (!preg_match('/^[a-zA-Z0-9&.-\/, ]+$/', $send_Service)) {
            $response = ["success" => false, "error" => "Special characters are not allowed in the term name!"];
        } else {
            $company_id = $_SESSION['company_id'] ?? 0;
            $username = $_SESSION['username'] ?? "Unknown";

            // **Insert the new term (catch duplicate errors)**
            $insertSQL = "INSERT INTO `temps_condi_tax_invoice` 
                          (`company_id`, `tems_cond_name`, `modify_by`, `modify_date`, `position`, `optional`) 
                          VALUES ('$company_id', '$send_Service', '$username', NOW(), '$position_num', '$optional_value')";

            $run_Insert = mysqli_query($con, $insertSQL);

            if ($run_Insert) {
                $last_id = mysqli_insert_id($con);
                $response = ["success" => true, "id" => $last_id, "position" => $position_num, "terms" => $send_Service];
            } else {
                // **Check if duplicate entry error occurred**
                if (mysqli_errno($con) == 1062) {
                    $response = ["success" => false, "error" => "This term already exists for this company!"];
                } else {
                    $response = ["success" => false, "error" => "Database Insert Failed: " . mysqli_error($con)];
                }
            }
        }
    } 
    elseif (!empty($_POST['id']) && $_POST['action'] === "delete") {
        // ✅ Handle Delete Request
        $id = mysqli_real_escape_string($con, $_POST['id']);

        if (!is_numeric($id)) {
            echo json_encode(["success" => false, "error" => "Invalid ID"]);
            exit;
        }

        $deleteSQL = "DELETE FROM `temps_condi_tax_invoice` WHERE `id` = '$id'";
        $run_Delete = mysqli_query($con, $deleteSQL);

        if ($run_Delete) {
            $response = ["success" => true, "message" => "Record deleted successfully"];
        } else {
            $response = ["success" => false, "error" => "Delete failed"];
        }
    } else {
        $response = ["success" => false, "error" => "Invalid Request"];
    }
} else {
    $response = ["success" => false, "error" => "Invalid method"];
}

echo json_encode($response);
exit;

?>