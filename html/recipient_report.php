<?php

include_once 'ltr/header.php';
include_once 'connection.php';

if (!isset($_SESSION['company_id']) || !isset($_SESSION['user_id'])) {
    echo "<script>alert('Unauthorized access!'); window.location.href='login.php';</script>";
    exit();
}

$company_id = $_SESSION['company_id'];
$user_id = $_SESSION['user_id'];

// Fetch user data for the given company ID and user ID
$fetch_user_data = "SELECT * FROM `users` WHERE `company_id` = '$company_id' AND `id` = '$user_id'";
$run_fetch_user_data = mysqli_query($con, $fetch_user_data);
$row = mysqli_fetch_array($run_fetch_user_data);

// Define column mappings
$columns = [
    "pan" => "pan",
    "tan" => "tan",
    "e_tds" => "e_tds",
    "it_returns" => "it_returns",
    "e_tender" => "e_tender",
    "gst" => "gst_fees",
    "dsc_subscriber" => "dsc_subscriber",
    "dsc_reseller" => "dsc_reseller",
    "other_services" => "other_services",
    "psp" => "psp",
    "trade_mark" => "trade_mark",
    "patent" => "patent",
    "copy_right" => "copy_right",
    "industrial_design" => "industrial_design",
    "trade_secret" => "trade_secret",
    "legal_notice" => "advocade_case"
];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recipient Report</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            display: flex;
            font-family: Arial, sans-serif;
        }
        .sidebar {
            width: 300px;
            background-color: #f4f4f4;
            padding: 20px;
            border-right: 1px solid #ddd;
            height: 100vh;
        }
        .report-section {
            flex-grow: 1;
            padding: 20px;
        }
        .tableScroll {
            height: 700px;
            overflow: auto;
        }
        .generate-btn {
            background-color: green;
            color: white;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            margin-top: 10px;
        }
        .generate-btn:hover {
            background-color: darkgreen;
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <h4>Filters</h4>
        <form id="userReport_form">
            <div>
                <label>From Date</label>
                <input type="date" id="from_Date" name="from_Date" class="form-control" value="<?php echo date('Y-m-d', strtotime("-1 month")); ?>">
            </div>
            <div>
                <label>To Date</label>
                <input type="date" id="to_Date" name="to_Date" class="form-control" value="<?php echo date('Y-m-d'); ?>">
            </div>
            <div>
                <label>Recipients</label>
                <select class="form-control" name="select_user[]" id="select_user" multiple>
                    <?php
                    $user_query = "SELECT * FROM `client_master` WHERE `company_id` = '$company_id' ORDER BY `client_name`";
                    $user_result = mysqli_query($con, $user_query);
                    while ($client_row = mysqli_fetch_array($user_result)) {
                        echo '<option value="' . $client_row['transaction_id'] . '">' . $client_row['client_name'] . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div>
                <label>Portfolio</label>
                <select class="form-control" name="portfolio[]" id="portfolio" multiple>
                    <?php
                    foreach ($columns as $column => $label) {
                        if (!empty($row[$column]) && $row[$column] == 1) {
                            echo "<option value='$column'>$label</option>";
                        }
                    }
                    ?>
                </select>
            </div>
            <button class="generate-btn" id="submitReport" type="submit">Show Report</button>
        </form>
    </div>

    <div class="report-section">
        <h2>📊 Recipient Report</h2>
        <div class="tableScroll">
            <div id="fetch_result">
                <table class="table table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th>No</th>
                            <th>Date</th>
                            <th>Service ID</th>
                            <th>Recipient Name</th>
                            <th>Fees</th>
                            <th>Fees Received</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="6" class="text-center">
                                <h4>Fill Details to see Report!</h4>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#userReport_form').submit(function(e) {
                e.preventDefault();
                var fromDate = $('#from_Date').val();
                var toDate = $('#to_Date').val();
                var portfolio = $('#portfolio').val();
                var users = $('#select_user').val();

                if (fromDate && toDate && portfolio.length > 0 && users.length > 0) {
                    $.ajax({
                        url: "html/recipient_reportAjax.php",
                        method: "POST",
                        data: $(this).serialize(),
                        success: function(data) {
                            $('#fetch_result').html(data);
                        },
                        error: function() {
                            alert("An error occurred. Please try again.");
                        }
                    });
                } else {
                    alert("Please fill all fields.");
                }
            });

            $('#portfolio').on('mousedown', function(e) {
                e.preventDefault();
                var scrollTop = $(this).scrollTop();
                $(this).focus();
                $(this).scrollTop(scrollTop);
                return false;
            });

            $('#select_user').on('mousedown', function(e) {
                e.preventDefault();
                var scrollTop = $(this).scrollTop();
                $(this).focus();
                $(this).scrollTop(scrollTop);
                return false;
            });

            $('#portfolio option, #select_user option').on('mousedown', function(e) {
                e.preventDefault();
                $(this).prop('selected', !$(this).prop('selected'));
                $(this).parent().change();
                return false;
            });
        });
    </script>

    <?php include_once 'ltr/header-footer.php'; ?>
</body>

</html>
