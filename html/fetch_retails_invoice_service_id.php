<?php
session_start();
include_once 'connection.php';

if (isset($_POST['empId'])) {
    $empId = mysqli_real_escape_string($con, $_POST['empId']); // Prevent SQL Injection

   echo $fetch_data = "SELECT * FROM retail_invoice WHERE retail_invoice_number = '$empId'";
    $run_data = mysqli_query($con, $fetch_data);

    // $data = array();
    //echo $empId;
    
while ($row = mysqli_fetch_assoc($run_data)) {
    $service_ids = explode(',', $row['service_id']);
    $client_name = $row['client_name'];

    foreach ($service_ids as $service_id) {
        // Output each service ID within a <tr> element
        echo "<tr style='font-size:14px;'>";

        $firstUnderscore = explode("_", $service_id);

        // Extract the service type
        $service_type = $firstUnderscore[1];
            switch ($firstUnderscore[1]) {
        case 'CLM':
            $table_name = 'client_master';
            $ViewPageForServiceId = 'View_ClientMaster';
            break;
        case 'GST':
            $table_name = 'gst_fees';
            $ViewPageForServiceId = 'View_GstFees';
            $portfolio_name="GST Fees";
            break;
        case 'ITR':
            $table_name = 'it_returns';
            $ViewPageForServiceId = 'View_ItReturns';
            $portfolio_name="IT Returns";
            break;
        case 'PAN':
            $table_name = 'pan';
            $ViewPageForServiceId = 'View_Pan';
            $portfolio_name="PAN";
            break;
        case 'TAN':
            $table_name = 'tan';
            $ViewPageForServiceId = 'View_Tan';
            $portfolio_name="TAN";
            break;
        case 'TDS':
            $table_name = 'e_tds';
            $ViewPageForServiceId = 'View_ETds';
            $portfolio_name="E TDS";
            break;
        case 'PSP':
            $table_name = 'psp';
            $ViewPageForServiceId = 'View_PspDistribution';
            $portfolio_name="PSP";
            break;
        case 'DA':
            $table_name = 'dsc_subscriber';
            $ViewPageForServiceId = 'View_DscApplicant';
            $portfolio_name="DSC Subscriber";
            break;
        case 'DP':
            $table_name = 'dsc_reseller';
            $ViewPageForServiceId = 'View_DscPartner';
            $portfolio_name="DSC Reseller";
            break;
        case 'DT':
            $table_name = 'dsc_token';
            $ViewPageForServiceId = 'View_TokenUsage';
            $portfolio_name="DSC Token";
            break;
        case 'TRD':
            $table_name = 'trade_mark';
            $ViewPageForServiceId = 'View_Trade_mark';
            $portfolio_name="Trade Mark";
            break;
        case 'PTN':
            $table_name = 'patent';
            $ViewPageForServiceId = 'View_patent';
            $portfolio_name="Patent";
            break;
        case 'IDS':
            $table_name = 'industrial_design';
            $ViewPageForServiceId = 'View_industrial_design';
            $portfolio_name="Industrial Design";
            break;
        case 'COP':
            $table_name = 'copy_right';
            $ViewPageForServiceId = 'View_copy_right';
            $portfolio_name="Copy Right";
            break;
        case 'TRS':
            $table_name = 'trade_secret';
            $ViewPageForServiceId = 'View_tradesecret';
            $portfolio_name="Trade Secret";
            break;
        case 'TSL':
            $table_name = 'sales';
            $ViewPageForServiceId = 'View_Sales';
            $portfolio_name="Sales";
            break;
        case 'TND':
            $table_name = 'e_tender';
            $ViewPageForServiceId = 'View_Etender';
            $portfolio_name="E tender";
            break;
        case 'OS':
            $table_name = 'other_services';
            $ViewPageForServiceId = 'View_OtherService';
            $portfolio_name="Other Sevices";
            break;
        case '24G':
            $table_name = '24g';
            $ViewPageForServiceId = 'View_24G';
            $portfolio_name="24G";
            break;
        default:
            // Handle the default case if needed
            break;
    }
    

        // Fetch corresponding data from the appropriate table
        if (!empty($table_name)) {
            $fetchIdForServiceId = "SELECT * FROM `$table_name` WHERE `transaction_id` = '$service_id'";
            $run_fetchIdForServiceId = mysqli_query($con, $fetchIdForServiceId);
            $getIDForServiceId = mysqli_fetch_array($run_fetchIdForServiceId);

            // Output the service ID in a <td> element
            // echo "<td>$service_id</td>";
            echo "<td>";
            ?>
            <form action="<?= $ViewPageForServiceId; ?>" method="post" target="_blank" id="myform">
                <input type="hidden" readonly name="ViewID" value="<?= $getIDForServiceId['id']; ?>">
                <button class="btn btn-link p-0"><?= $service_id; ?>,</button>
            </form>
            <?php
            echo "</td>";
            // Output the client name in a <td> element
            echo "<td>$portfolio_name</td>";
            echo "</tr>";
            
        }
    }
}
// echo $data;
} else {
    echo "empId not set";
}
?>
