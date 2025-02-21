<?php
session_start();
include_once 'connection.php';
date_default_timezone_set('Asia/Kolkata');

if (isset($_POST['viewID_replay_trade_mark'])) {
    echo $viewID_replay_trade_mark = $_POST['viewID_replay_trade_mark'];
    $portfolio_name = $_POST['portfolio_name'];
    //echo $ClientNameSelect1;
    //echo "Rok";
    $fetch_TaxInvoiceNumber = "SELECT * FROM `intell_status` WHERE `status` = '".$status_add."' and `portfolio`='".$portfolio_name."' AND `company_id` = '".$_SESSION['company_id']."'";
    $run_fetch_TaxInvoiceNumber = mysqli_query($con,$fetch_TaxInvoiceNumber);
    if(mysqli_num_rows($run_fetch_TaxInvoiceNumber) > 0){
        echo 'tax_invoice_exist';
    }else{
        echo 'tax_invoice_not_exist';
    }
    // $row = mysqli_fetch_array($run_fetch_TaxInvoiceNumber);
}