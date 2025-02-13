<?php
// $sessionTimeout = 3600;
// 	date_default_timezone_set('Asia/Kolkata');



// // Set session configuration parameters
// session_set_cookie_params($sessionTimeout);

// / server should keep session data for AT LEAST 1 hour
ini_set('session.gc_maxlifetime', 43200);

// each client should remember their session id for EXACTLY 1 hour
session_set_cookie_params(43200);
session_start();
include_once 'connection.php';
if (!isset($_SESSION['username'])) {
    header("Location: login");
    exit();
}

function storeSessionData($con)
{
    // Retrieve session data
    $user_id = $_SESSION['user_id'];
    $username = $_SESSION['username'];

    // Prepare SQL statement
    // $sql = "INSERT INTO session_data (user_id, username) VALUES ('$user_id', '$username')";
    $user_id = $_SESSION['user_id'];
    $destroy_time = date('Y-m-d H:i:s'); // Get the current time
    if (isset($_SESSION['mac_address'])) {
        $system_id = $_SESSION['mac_address'];

        $fethc_name = "select * from users where id='" . $user_id . "'";
        $run = mysqli_query($con, $fethc_name);
        $value = mysqli_fetch_array($run);
        $username_va = $value['username'];


        // Insert into your database table
        $query = "UPDATE `temp_login_app` SET `log_out_time`='" . $destroy_time . "' WHERE username='" . $username_va . "' and mac_address='" . $system_id . "' order by id desc limit 1";
        $ru = mysqli_query($con, $query);
    } else {
        // Handle the case where 'mac_address' is not set in the session
        // For example, you could set a default value or show an error message
        // $system_id = 'default_value'; // Replace 'default_value' with an appropriate default value
        // or
        // echo 'MAC address is not set in the session.';
    }





    // Execute SQL statement

}

// Call storeSessionData() to store session data in the database
storeSessionData($con);

// Check for session expiration (60 seconds of inactivity)
//   $session_timeout = 60;
// if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 60)) {
// // if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > $session_timeout)) {

//     // Session expired, destroy session and redirect to login page or perform any other action
//     session_unset();
//     session_destroy();
//     header("Location: login");
//     exit;
// }
if (isset($_SESSION['LAST_ACTIVITY'])) {
    // Calculate the remaining time
    $maxLifetime = ini_get('session.gc_maxlifetime');
    $startTime = $_SESSION['LAST_ACTIVITY'];
    $currentTime = time();
    $timeElapsed = $currentTime - $startTime;
    $remainingTime = $maxLifetime - $timeElapsed;

    if ($remainingTime > 0) {
        // echo "Remaining time: $remainingTime seconds";
    } else {
        // echo "Session has expired.";
        $user_id = $_SESSION['user_id'];
        $destroy_time = date('Y-m-d H:i:s'); // Get the current time
        $system_id = $_SESSION['mac_address'];


        $fethc_name = "select * from users where id='" . $user_id . "'";
        $run = mysqli_query($con, $fethc_name);
        $value = mysqli_fetch_array($run);
        $username_va = $value['username'];


        // Insert into your database table
        $query = "UPDATE `temp_login_app` SET `log_out_time`='" . $destroy_time . "' WHERE username='" . $username_va . "' and mac_address='" . $system_id . "' order by id desc limit 1";
        $ru = mysqli_query($con, $query);
        unset($_SESSION['user_id']);
        unset($_SESSION['mac_address']);
        unset($_SESSION['user_email']);
        session_destroy();
        // header('Location: login');
        // exit();
        // Perform any necessary actions, such as logging out the user or redirecting to a login page
    }
} else {
    // echo "Session not started.";
    echo '<script>window.location.reload();</script>';
}
$_SESSION['domain_name'] = $_SERVER['SERVER_NAME'];
$fetch_email_id = "SELECT * FROM `email_panel` WHERE `company_id` = '" . $_SESSION['company_id'] . "'";
$run_email_id = mysqli_query($con, $fetch_email_id);
$email_rows = mysqli_num_rows($run_email_id);
if ($email_rows > 0) {
    $getting = mysqli_fetch_array($run_email_id);
    $_SESSION['EmailFromPanel'] = $getting['emailId'];
    // $_SESSION['EmailSignatureFromPanel'] = '<span style="color: rgb(255, 0, 0); font-family: Arial, Helvetica, sans-serif; font-size: small;">Vowel Enterprise</span><br style="color: rgb(255, 0, 0); font-family: Arial, Helvetica, sans-serif; font-size: small;"><span style="color: rgb(255, 0, 0); font-family: Arial, Helvetica, sans-serif; font-size: small;">A-1, 1st Floor,</span><br style="color: rgb(255, 0, 0); font-family: Arial, Helvetica, sans-serif; font-size: small;"><span style="color: rgb(255, 0, 0); font-family: Arial, Helvetica, sans-serif; font-size: small;">Asharam Complex,</span><br style="color: rgb(255, 0, 0); font-family: Arial, Helvetica, sans-serif; font-size: small;"><span style="color: rgb(255, 0, 0); font-family: Arial, Helvetica, sans-serif; font-size: small;">Above Umiya Motor Driving School,</span><br style="color: rgb(255, 0, 0); font-family: Arial, Helvetica, sans-serif; font-size: small;"><span style="color: rgb(255, 0, 0); font-family: Arial, Helvetica, sans-serif; font-size: small;">Opp. K C tea stall, Hatkeshwar circle,</span><br style="color: rgb(255, 0, 0); font-family: Arial, Helvetica, sans-serif; font-size: small;"><span style="color: rgb(255, 0, 0); font-family: Arial, Helvetica, sans-serif; font-size: small;">Hatkeswar, Ahmedabad-380026, Gujarat</span><br style="color: rgb(255, 0, 0); font-family: Arial, Helvetica, sans-serif; font-size: small;"><span style="color: rgb(255, 0, 0); font-family: Arial, Helvetica, sans-serif; font-size: small;">Web- </span><a href="https://vowelindia.com/" target="_blank" data-saferedirecturl="https://www.google.com/url?q=https://vowelindia.com&source=gmail&ust=1648124850972000&usg=AOvVaw2maiEG9mJe2HIzeqQCm2HW" style="color: rgb(17, 85, 204); font-family: Arial, Helvetica, sans-serif; font-size: small; background-color: rgb(255, 255, 255);">https://vowelindia.com</a><span style="color: rgb(255, 0, 0); font-family: Arial, Helvetica, sans-serif; font-size: small;"></span><br style="color: rgb(255, 0, 0); font-family: Arial, Helvetica, sans-serif; font-size: small;"><span style="color: rgb(255, 0, 0); font-family: Arial, Helvetica, sans-serif; font-size: small;">E-mail id:- </span><a href="mailto:vowel.dsc@gmail.com" target="_blank" style="color: rgb(17, 85, 204); font-family: Arial, Helvetica, sans-serif; font-size: small; background-color: rgb(255, 255, 255);">vowel.dsc@gmail.com</a><span style="color: rgb(255, 0, 0); font-family: Arial, Helvetica, sans-serif; font-size: small;">, </span><a href="mailto:contact@vowelindia.com" target="_blank" style="color: rgb(17, 85, 204); font-family: Arial, Helvetica, sans-serif; font-size: small; background-color: rgb(255, 255, 255);">contact@vowelindia.com</a><span style="color: rgb(255, 0, 0); font-family: Arial, Helvetica, sans-serif; font-size: small;"></span><br style="color: rgb(255, 0, 0); font-family: Arial, Helvetica, sans-serif; font-size: small;"><span style="color: rgb(255, 0, 0); font-family: Arial, Helvetica, sans-serif; font-size: small;">Land Line:- 079 2272 1172</span><br style="color: rgb(255, 0, 0); font-family: Arial, Helvetica, sans-serif; font-size: small;"><span style="color: rgb(255, 0, 0); font-family: Arial, Helvetica, sans-serif; font-size: small;">Mo:- 9898186349, 9106448443<br></span>';
    $_SESSION['EmailSignatureFromPanel'] = $getting['email_signature'];
} else {
    $_SESSION['EmailFromPanel'] = "null";
    $_SESSION['EmailSignatureFromPanel'] = "null";
}

if (isset($_SESSION['company_id'])) {
    $fetch_user_data = "SELECT * FROM `users` WHERE `company_id` = '" . $_SESSION['company_id'] . "' AND `id` = '" . $_SESSION['user_id'] . "'";
    $run_fetch_user_data = mysqli_query($con, $fetch_user_data);
    $userrow = mysqli_fetch_array($run_fetch_user_data);
}
if (isset($userrow['firstname']) && isset($userrow['middlename'])) {
    $_SESSION['fullname'] = $userrow['firstname'] . " " . $userrow['middlename'];
} else {
    $_SESSION['fullname'] = ""; // or some default value
}

if (isset($userrow['username'])) {
    $_SESSION['email_id'] = $userrow['username'];
} else {
    $_SESSION['email_id'] = ""; // or some default value
}

$substring = "wati";
$fetch_api_setup = "select * from `whatsapi_setup_tb` WHERE `company_id` = '" . $_SESSION['company_id'] . "'";
$run_api_setup = mysqli_query($con, $fetch_api_setup);
$api_row = mysqli_num_rows($run_api_setup);
if ($api_row > 0) {
    $api_getting = mysqli_fetch_array($run_api_setup);
    if ($api_getting['access_token'] == "") {
        $_SESSION['accessToken'] = "invalid";
    } else {
        $_SESSION['accessToken'] = $api_getting['access_token'];
    }
    if ($api_getting['endpoint'] == "") {
        $_SESSION['endpoint'] = "invalid";
    } else {
        $_SESSION['endpoint'] = $api_getting['endpoint'];
    }
    if ($api_getting['location_path'] == "") {
        $_SESSION['location_path'] = "invalid";
    } else {
        $_SESSION['location_path'] = $api_getting['location_path'];
    }
    if (strpos($_SESSION['endpoint'], $substring) !== false) {
        $_SESSION['whatsapp_type'] = "wati";
    } else {
        $_SESSION['whatsapp_type'] = "local";
    }
}

$fetch_company_name = "select * from company_profile where `company_id` = '" . $_SESSION['company_id'] . "'";
$run_compny_nmae = mysqli_query($con, $fetch_company_name);
$row_company_name = mysqli_fetch_array($run_compny_nmae);
$company_name = $row_company_name['company_name'];


// Extract the first character
$first_character = substr($company_name, 0, 1);

// Find the position of the first space
$first_space_position = strpos($company_name, ' ');

// Check if there is a space after the first word
if ($first_space_position !== false) {
    // Extract the character after the first space
    $second_character_after_space = substr($company_name, $first_space_position + 1, 1);
} else {
    // If no space is found, extract the last character
    $last_character = substr($company_name, -1, 1);

    // Set the second character to be the same as the first character
    $second_character_after_space = $last_character;
}

// Concatenate the characters
$result_comapny_name = strtoupper($first_character . $second_character_after_space);
// $result = $first_character . $second_character_after_space;


$_SESSION['company_name_for_transacrion_id'] = $result_comapny_name;


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
    $sections = 'document_records';
}

?>
<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="html/images/favicon.ico">
    <title>Clienserv</title>
    <!-- Custom CSS -->
    <link href="assets/libs/flot/css/float-chart.css" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <!-- Task Manager Theme style -->
    <!-- <link rel="stylesheet" href="tm_assets/dist/css/adminlte.min.css"> -->
    <!-- Custom CSS -->
    <link href="dist/css/style.min.css" rel="stylesheet">
    <!-- CSS For Pre-loading -->
    <!-- <link href="dist/css/preloading.css" rel="stylesheet">
    <script src="dist/js/preloading.js"></script> -->


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> -->

    <!-- <link rel="stylesheet" href="dist/notifications.css">
    <script src="dist/notifications.js"></script> -->

    <!-- <link rel="stylesheet" href="tm_assets/dist/css/styles.css"> -->
    <!-- <script src="tm_assets/plugins/jquery/jquery.min.js"></script> -->

    <!-- Style of Task Manager -->
    <!-- Select2 -->
    <!-- <link rel="stylesheet" href="tm_assets/plugins/select2/css/select2.min.css"> -->
    <!-- <link rel="stylesheet" href="tm_assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css"> -->
    <!-- SweetAlert2 -->
    <!-- <link rel="stylesheet" href="tm_assets/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css"> -->
    <!-- Toastr -->
    <!-- <link rel="stylesheet" href="tm_assets/plugins/toastr/toastr.min.css"> -->
    <!-- dropzonejs -->
    <!-- <link rel="stylesheet" href="tm_assets/plugins/dropzone/min/dropzone.min.css"> -->
    <!-- DateTimePicker -->
    <!-- <link rel="stylesheet" href="tm_assets/dist/css/jquery.datetimepicker.min.css"> -->
    <!-- iCheck for checkboxes and radio inputs -->
    <!-- <link rel="stylesheet" href="tm_assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css"> -->
    <!-- Switch Toggle -->
    <!-- <link rel="stylesheet" href="tm_assets/plugins/bootstrap4-toggle/css/bootstrap4-toggle.min.css"> -->
    <!-- summernote -->
    <!-- <link rel="stylesheet" href="tm_assets/plugins/summernote/summernote-bs4.min.css"> -->
    <!-- DataTables -->
    <!-- <link rel="stylesheet" href="tm_assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="tm_assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="tm_assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css"> -->
    <script src="https://kit.fontawesome.com/d3dd33a66d.js" crossorigin="anonymous"></script>
    <!-- <link href="dist/css/select2.min.css" rel="stylesheet">
    <script src="dist/js/select2.min.js"></script> -->
    <!--script src="https://use.fontawesome.com/05ccf72100.js"></script-->

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
    <style type="text/css">
        .rectangle {
            width: 150px;
            height: 100px;
            background-color: #3498db;
            /* Blue background color */
            color: white;
            /* Text color */
            text-align: center;
            /* Center text horizontally */
            line-height: 100px;
            /* Center text vertically */
            font-family: Arial, sans-serif;
            /* Font family */
            border-radius: 10px;
            /* Rounded corners */
        }

        body {
            background: #8C8C8C; 
            color: #000;
            position: relative;
            padding-bottom: 56px;
            min-height: 100vh;
            font-family: 'open sans', sans-serif;
        }

        .btn-vowel {
            background: #27a9e3;
            color: #FFF;
        }

        .btn-vowel:hover {
            background: #FFF;
            color: #27a9e3;
            border-color: #27a9e3;
        }

        .btn-vowel:disabled:hover {
            cursor: not-allowed;
            background: #FFF;
            color: #27a9e3;
        }

        .bg-vowel {
            background: none;
            color: #27a9e3;
        }

        /*.bg-vowel:hover{
        background: #FFF;
        color: #27a9e3;
        border-color: #27a9e3;
    }
    .bg-vowel:disabled:hover{
        cursor: not-allowed;
        background: #FFF;
        color: #27a9e3;
    }*/
        .btn-secondary:hover {
            border: 1px solid #292b2c;
            color: #292b2c;
            background: none;
        }

        /* Chrome, Safari, Edge, Opera */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }

        input[type="text"]:disabled:hover,
        input[type="number"]:disabled:hover,
        input[type="submit"]:disabled:hover,
        input[type="email"]:disabled:hover,
        input[type="checkbox"]:disabled:hover {
            
            cursor: not-allowed;
        }

        /* , input[type="submit"]:read-only:hover */
        /* , input[type="checkbox"]:read-only:hover */
        input[type="text"]:read-only:hover,
        input[type="number"]:read-only:hover,
        input[type="email"]:read-only:hover {
            /* //background: #dddddd; */
            cursor: not-allowed;
        }

        .left-menu {
            /* //height: 100%; */
            min-height: 100vh;
            position: fixed;
            overflow-y: scroll;
        }

        .table thead th {
            font-weight: bold;
        }

        button:hover {
            cursor: pointer;
        }

        .btn-success:hover {
            color: #36bea6;
            background-color: transparent;
            border-color: #36bea6;
        }

        .btn-danger:hover {
            color: #da542e;
            background-color: transparent;
            border-color: #da542e;
        }

        .btn-info:hover {
            color: #2962FF;
            background-color: transparent;
            border-color: #2962FF;
        }

        .btn-primary:hover {
            color: #7460ee;
            background-color: transparent;
            border-color: #7460ee;
        }

        .sidebar-nav ul .sidebar-item .sidebar-link.active {
            background-color: #72C7EC;/* //#e36127;*/
            color: #FFF;
            font-weight: bold;
            /* //content: "-->";
            //font-family: Font Awesome 5 Free; */
        }

        .sidebar-nav ul .sidebar-item.selected>.sidebar-link {
            background: #27a9e3;
            /* //background: #E36127; //a9e327 */
            opacity: 1;
        }

        .sidebar-nav ul .sidebar-item ul .sidebar-link {
            background: #FFF;
            color: #000;
            /* //opacity: 1; */
        }

        .sidebar-nav ul .sidebar-item ul .sidebar-link .mdi,
        .sidebar-nav ul .sidebar-item ul .sidebar-link .fas,
        .sidebar-nav ul .sidebar-item ul .sidebar-link .far {
            color: #000;
        }

        .sidebar-nav ul .sidebar-item ul .sidebar-link.active .mdi,
        .sidebar-nav ul .sidebar-item ul .sidebar-link.active .fas,
        .sidebar-nav ul .sidebar-item ul .sidebar-link.active .far {
            color: #FFF;
        }

        /*
        #e36127
        #e327a9
        #27e361
    */
        .sidebar-nav ul .sidebar-item .singleLink.active::after,
        .sidebar-nav ul .sidebar-item ul .sidebar-item .sidebar-link.active::after {
            font-family: "Font Awesome 5 Free";
            font-weight: 900;
            font-size: 18px;
            content: "\3000\3000\f0a4";
        }

        #ViewModal_body {
            height: 480px;
            overflow-y: scroll;
        }

        /*Sticky Heading*/
        .pageHeading {
            padding: 10px 16px;
            background: #FFF;
            /* //color: #f1f1f1; */
            z-index: 5000;
            align-self: center;
        }

        .sticky {
            position: fixed;
            top: 64px;
            width: 77%;
            /* //max-width: 100%;
            //color: #f1f1f1; */
            z-index: 1;
            align-self: center;
            /* //border: 1px solid red; */
        }

        .after-heading {
            margin-top: 65px;
            align-self: center;
        }

        .showDataTable {
            height: 500px;
        }

        /*.sticky-top{
        position: -webkit-sticky !important;
        position: -moz-sticky !important;
        position: -ms-sticky !important;
        position: -o-sticky !important;
        position: sticky !important;
        top: 0px;
    }*/
        #speechinput {
            width: 25px; /*// just wide enough to show mic icon*/
            height: 25px; /*// just high enough to show mic icon*/
            cursor: pointer;
            border: none;
            position: absolute;
            margin-left: 5px;
            outline: none;
            background: transparent;
        }

        .modal-header .logo {
            /*//border: 1px solid red;*/
            width: 160px !important; /*//70px*/
            height: 80px !important;
            /*//min-height: 1% !important;
        }

        .preloader {
            width: 100%;
            height: 100%;
            top: 0px;
            position: fixed;
            z-index: 99999;
            background: #fff;
            animation: pulse 5s infinite;
        }

        .lds-ripple {
            display: inline-block;
            position: relative;
            /* width:64px; */
            width: 100%;
            height: 64px;
            position: absolute;
            top: 0px;
            left: 0px;
            /* top:calc(50% - 3.5px); */
            /* left:calc(50% - 3.5px) */
        }

        .lds-ripple .lds-pos {
            position: absolute;
            border: 2px solid #2962FF;
            opacity: 1;
            border-radius: 50%;
            -webkit-animation: lds-ripple 1s cubic-bezier(0, 0.1, 0.5, 1) infinite;
            animation: lds-ripple 1s cubic-bezier(0, 0.1, 0.5, 1) infinite
        }

        .lds-ripple .lds-pos:nth-child(2) {
            -webkit-animation-delay: -0.5s;
            animation-delay: -0.5s
        }

        @-webkit-keyframes lds-ripple {
            0% {
                top: 28px;
                left: 28px;
                width: 0;
                height: 0;
                opacity: 0
            }

            5% {
                top: 28px;
                left: 28px;
                width: 0;
                height: 0;
                opacity: 1
            }

            to {
                top: -1px;
                left: -1px;
                width: 58px;
                height: 58px;
                opacity: 0
            }
        }

        @keyframes lds-ripple {
            0% {
                top: 28px;
                left: 28px;
                width: 0;
                height: 0;
                opacity: 0
            }

            5% {
                top: 28px;
                left: 28px;
                width: 0;
                height: 0;
                opacity: 1
            }

            to {
                top: -1px;
                left: -1px;
                width: 58px;
                height: 58px;
                opacity: 0
            }
        }

        .loading_container {
            overflow: hidden;
            /* Hide scrollbars */
            position: relative;
            width: 50%;
            /* margin: 280px auto;  */
            margin: 100px auto;
            padding: 20px 40px;
            border-radius: 4px;
            box-sizing: border-box;
            background: #fff;
            box-shadow: 0 10px 20px rgba(0, 0, 0, .5);
        }

        .Loading {
            position: relative;
            display: inline-block;
            width: 100%;
            height: 10px;
            background: #f1f1f1;
            box-shadow: inset 0 0 5px rgba(0, 0, 0, .2);
            border-radius: 4px;
            overflow: hidden;
        }

        .Loading:after {
            content: '';
            position: absolute;
            left: 0;
            width: 0;
            height: 100%;
            border-radius: 4px;
            box-shadow: 0 0 5px rgba(0, 0, 0, .2);
            animation: load 5s infinite;
        }

        @keyframes load {
            0% {
                width: 0;
                background: #a28089;
            }

            25% {
                width: 40%;
                background: #a0d2eb;
            }

            50% {
                width: 60%;
                background: #ffa8b6;
            }

            75% {
                width: 75%;
                background: #d0bdf4;
            }

            100% {
                width: 100%;
                background: #494d5f;
            }
        }

        @keyframes pulse {
            0% {
                background: #a28089;
            }

            25% {
                background: #a0d2eb;
            }

            50% {
                background: #ffa8b6;
            }

            75% {
                background: #d0bdf4;
            }

            100% {
                background: #494d5f;
            }
        }

        .grid-container {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            /* 3 equal columns */
            grid-gap: 10px;
            /* Gap between grid items */
        }
    </style>
</head>

<body>
    <?php
    // if ($_SESSION['user_type'] == 'system_user') {
    if (isset($_SESSION['company_id'])) {
        $fetchComapnyLogo = "SELECT * FROM `company_profile` WHERE `company_id` = '" . $_SESSION['company_id'] . "'";
        $run_fetch_company_Logo = mysqli_query($con, $fetchComapnyLogo);
        $stored_company_logo = mysqli_fetch_array($run_fetch_company_Logo);
        $main_company_logo = $stored_company_logo['company_logo'];
    }
    // }
    ?>
    <!--Logout Popup-->
    <div class="modal fade" data-backdrop="static" data-keyboard="false" id="LogoutPopup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <img src="<?php echo $main_company_logo; ?>" alt="The Thu" style="//width: 30%; //background-color: #FFF;" class="logo navbar-brand mr-auto">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body bg-light">
                    <?php echo "<p>Are you sure to logout of Vowel?</p>"; ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No, keep me logged in</button>
                    <a class="btn btn-vowel" href="2">Yes, please</a>
                </div>
            </div>
        </div>
    </div>

    <!--Asking for adding Payment for the transaction  Popup-->
    <div class="modal fade" data-backdrop="static" data-keyboard="false" id="AskingMakeIncomePaymentPopup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <img src="<?php echo $main_company_logo; ?>" alt="The Thu" class="logo navbar-brand mr-auto">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body bg-light">
                    <?php echo "<p>Do you want to add payment details for this transaction?</p>"; ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="No_makePaymentLink" data-dismiss="modal">No</button>
                    <a class="btn btn-vowel" id="makePaymentLink" href="#">Yes</a>
                </div>
            </div>
        </div>
    </div>

    <!--Change Password Popup-->
    <div class="modal fade" data-backdrop="static" data-keyboard="false" id="ChangePasswordPopup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <img src="<?php echo $main_company_logo; ?>" alt="The Thu" style="//width: 30%; //background-color: #FFF;" class="logo navbar-brand mr-auto">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body bg-light">
                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-warning text-white" id="basic-addon2"><i class="ti-lock"></i></span>
                            </div>
                            <!-- <input type="password" required class="form-control form-control-lg" placeholder="Password" aria-label="Password" name="password" aria-describedby="basic-addon1" id="password"> -->
                            <input type="password" class="form-control" name="changePass" id="changePass" placeholder="Password">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-info text-white" id="basic-addon2"><a class="" id="showPassword"><i id="passIcon" class="fas fa-eye-slash"></i></a></span>
                            </div>
                        </div>
                        <span id="changePass-status"></span>
                    </div>
                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-warning text-white" id="basic-addon2"><i class="ti-lock"></i></span>
                            </div>
                            <!-- <input type="password" required class="form-control form-control-lg" placeholder="Confirm Password" aria-label="Password" name="con_password" aria-describedby="basic-addon1" id="con_password"> -->
                            <input type="password" class="form-control" name="retype_changePass" id="retype_changePass" placeholder="Re-type Password">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-info text-white" id="basic-addon2"><a class="" id="showCon_Password"><i id="con_passIcon" class="fas fa-eye-slash"></i></a></span>
                            </div>
                        </div>
                        <span id="retype_changePass-status"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-vowel" id="changePassBTN">Save</button>
                </div>
            </div>
        </div>
    </div>

    <!--Loading Modal-->
    <div class="modal hide" id="pleaseWaitDialog" data-backdrop="static" data-keyboard="false" style="z-index: 10000;">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content" style="background: rgba(0,0,0,0); border: none;">
                <!--div class="modal-header">
                    <h1>Please Wait</h1>
                </div-->
                <div class="modal-body">
                    <div id="ajax_loader">
                        <img src="html/images/demo_wait-4.gif" style="display: block; margin-left: auto; margin-right: auto;">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="pinModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Pin Item</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="grid-container" id="showPinnedItems_here">
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="preloader">
        <div class="lds-ripple">
            <!-- <div class="lds-pos">
                <div class="progress-bar"></div>
                <h1 class="count-bar"></h1>
            </div> -->
            <img src="<?php echo 'html/images/logo.png'; ?>" alt="Clienserve" style="width: 30%; //background-color: #FFF;" class="logo navbar-brand mr-auto">
            <div class="loading_container">
                <p>Please relax while we set up your dashboard...</p>
                <div class="Loading"></div>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <header class="topbar" data-navbarbg="skin5">
            <nav class="navbar top-navbar navbar-expand-md navbar-dark fixed-top">
                <div class="navbar-header" data-logobg="skin5">
                    <!-- This is for the sidebar toggle which is visible on mobile only -->
                    <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)"><i class="ti-menu ti-close"></i></a>
                    <!-- ============================================================== -->
                    <!-- Logo -->
                    <!-- ============================================================== -->
                    <a class="navbar-brand" href="Dashboard">
                        <!-- Logo icon -->
                        <b class="logo-icon p-l-10">
                            <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                            <!-- Dark Logo icon -->
                            <!--img src="html/images/logo-icon.png" alt="homepage" class="light-logo" /-->

                        </b>
                        <!--End Logo icon -->
                        <!-- Logo text -->
                        <span class="logo-text" style="text-align: center;">
                            <!-- dark Logo text -->
                            <!-- <img src="<?php //echo $main_company_logo; 
                                            ?>" alt="homepage" class="light-logo" style="width: 90%;//background-color: #FFF;" /> -->
                            <?php
                            if ($main_company_logo != "") { ?>
                                <img src="<?php echo $main_company_logo; ?>" alt="Logo to be uploaded" class="light-logo" style="width: 90%;" />
                            <?php } else { ?>
                                <span>Logo to be uploaded</span>
                            <?php } ?>
                            <!-- <p style="color: #fff; margin: 0px; padding: 0px; font-size: 17px;">Minute Data Analyzer</p> -->
                        </span>
                        <!-- Logo icon -->
                        <!-- <b class="logo-icon"> -->
                        <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                        <!-- Dark Logo icon -->
                        <!-- <img src="html/images/logo-text.png" alt="homepage" class="light-logo" /> -->

                        <!-- </b> -->
                        <!--End Logo icon -->
                    </a>
                    <!-- ============================================================== -->
                    <!-- End Logo -->
                    <!-- ============================================================== -->
                    <!-- ============================================================== -->
                    <!-- Toggle which is visible on mobile only -->
                    <!-- ============================================================== -->
                    <a class="topbartoggler d-block d-md-none waves-effect waves-light" href="javascript:void(0)" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><i class="ti-more"></i></a>
                </div>
                <!-- ============================================================== -->
                <!-- End Logo -->
                <!-- ============================================================== -->
                <div class="navbar-collapse collapse" id="navbarSupportedContent" data-navbarbg="skin5">
                    <!-- ============================================================== -->
                    <!-- toggle and nav items -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav float-left mr-auto">
                        <li class="nav-item d-none d-md-block"><a class="nav-link sidebartoggler waves-effect waves-light" href="javascript:void(0)" data-sidebartype="mini-sidebar"><i class="mdi mdi-menu font-24"></i></a></li>
                        <!-- ============================================================== -->
                        <!-- create new -->
                        <!-- ============================================================== -->
                        <!--li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                             <span class="d-none d-md-block">Create New <i class="fa fa-angle-down"></i></span>
                             <span class="d-block d-md-none"><i class="fa fa-plus"></i></span>   
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="#">Action</a>
                                <a class="dropdown-item" href="#">Another action</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#">Something else here</a>
                            </div>
                        </li-->
                        <!-- ============================================================== -->
                        <!-- Search -->
                        <!-- ============================================================== -->
                        <li class="nav-item search-box"> <a class="nav-link waves-effect waves-dark" href="javascript:void(0)"><i class="ti-search"></i></a>
                            <form class="app-search position-absolute">
                                <input type="search" name="search" id="search" class="form-control" placeholder="Search &amp; enter"> <a class="srh-btn" id="closeSearch"><i class="ti-close"></i></a>
                            </form>
                        </li>
                    </ul>

                    <?php


                    ?>
                    <marquee behavior="scroll" direction="left" style="color: green; margin-right:20%; width:55%; height:50px; align-items:center;">
                        <p style="margin-top:10px;"><b><span class="marquee-content"></span></b></p>
                    </marquee>



                    <script>
                        $(document).ready(function() {
                            // Function to update remaining time using AJAX
                            // function updateRemainingTime() {
                            //     $.ajax({
                            //         url: 'html/ltr/update_session_time.php', // PHP script to update session time
                            //         type: 'GET',
                            //         success: function(response) {
                            //             // Update the HTML element with the new remaining time
                            //             $('.marquee-content').html(response);
                            //             // alert('Remaining time updated!' +response);

                            //         },
                            //         error: function(xhr, status, error) {
                            //             console.error(xhr.responseText);
                            //         }
                            //     });
                            // }

                            // // Call the updateRemainingTime function initially
                            // updateRemainingTime();

                            // // Set interval to update remaining time every second
                            // setInterval(updateRemainingTime, 1000);
                        });
                    </script>
                    <?php
                    if ($_SESSION['user_type'] == 'system_user') {
                        if (isset($_SESSION['company_id'])) {
                            $fetch_user_data = "SELECT * FROM `users` WHERE `company_id` = '" . $_SESSION['company_id'] . "' AND `id` = '" . $_SESSION['user_id'] . "'";
                            $run_fetch_user_data = mysqli_query($con, $fetch_user_data);
                            $row = mysqli_fetch_array($run_fetch_user_data);
                            $admin = $row['type'];
                        } ?>
                        <!-- ============================================================== -->
                        <!-- Right side toggle and nav items -->
                        <!-- ============================================================== -->
                        <a href="https://webmail.clienserv.com/cpsess3465175377/3rdparty/roundcube/index.php?_task=mail&_mbox=INBOX" target="_blank"><img src="html/images/gmail.png" style="width:30px;"></a>
                        <button type="button" onclick="getPinnedItems()" class="btn btn-light" style="border:none;background:none;" data-toggle="modal" data-target="#pinModal"><i style="font-size:1.5em;color:white;" class="fa-solid fa-link"></i></button>




                        <ul class="navbar-nav float-right">
                            <!-- ============================================================== -->
                            <!-- User profile and search -->
                            <!-- ============================================================== -->
                            <!--<img src="html/images/users/1.jpg" alt="user" class="rounded-circle" width="31">-->
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark pro-pic" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Hey, <?php echo  $_SESSION['username']; ?></a>
                                <div class="dropdown-menu dropdown-menu-right user-dd animated">
                                    <?php if ($row['add_users'] == "1") { ?>
                                        <!-- <a class="dropdown-item" href="controller_operator"><i class="fas fa-wrench m-r-5 m-l-5"></i> Controller Operator</a> -->
                                        <a class="dropdown-item" href="add_users"><i class="fas fa-users-cog m-r-5 m-l-5"></i> User Management</a>
                                        <!--<a class="dropdown-item" href="manage_dashboard"><i class="fas fa-users-cog m-r-5 m-l-5"></i> Dashboard Panel</a>-->
                                    <?php } ?>
                                    <?php if ($row['type'] == 1 || $row['depart_panel'] == 1) { ?>
                                        <a class="dropdown-item" href="department"><i class="fas fa-envelope m-r-5 m-l-5"></i> Department Panel</a>
                                    <?php }
                                    if ($row['type'] == 1 || $row['design_panel'] == 1) { ?>
                                        <a class="dropdown-item" href="designation"><i class="fas fa-envelope m-r-5 m-l-5"></i> Designation Panel</a>
                                    <?php }
                                    if ($row['type'] == 1 || $row['mail_panel'] == 1) { ?>
                                        <a class="dropdown-item" href="sendMailPanel"><i class="fas fa-envelope m-r-5 m-l-5"></i> Mail Panel</a>
                                    <?php }
                                    if ($row['type'] == 1 || $row['api_setup'] == 1) { ?>
                                        <a class="dropdown-item" href="whatsapi_setup"><i class="fas fa-envelope m-r-5 m-l-5"></i> WhatsApi Setup</a>
                                    <?php }
                                    if ($row['type'] == 1) { ?>
                                        <?php if ($admin == 1) { ?>
                                            <a class="dropdown-item" href="user_access"><i class="fas fa-user-circle m-r-5 m-l-5" aria-hidden="true"></i> User Access</a>
                                        <?php } ?>
                                        <!--<a class="dropdown-item" href="email_log_data"><i class="fas fa-envelope m-r-5 m-l-5"></i> Email Log</a>-->
                                    <?php }
                                    if ($row['type'] == 1) { ?>
                                        <a class="dropdown-item" href="user_log_data"><i class="fas fa-envelope m-r-5 m-l-5"></i> User Log</a>
                                    <?php }
                                    if ($row['type'] == 1) { ?>
                                        <!--<a class="dropdown-item" href="data_user_log_down"><i class="fas fa-envelope m-r-5 m-l-5"></i> User Log Download</a>-->
                                    <?php }
                                    if ($row['type'] == 1 || $row['company_profile'] == 1) { ?>
                                        <a class="dropdown-item" href="company_profile"><i class="fas fa-user-circle m-r-5 m-l-5" aria-hidden="true"></i> Company Profile</a>
                                        <a class="dropdown-item" href="documents_setup"><i class="fas fa-user-circle m-r-5 m-l-5" aria-hidden="true"></i> Documents Setup</a>
                                    <?php } ?>
                                    <?php if ($row['type'] == 1 || $row['soft_export'] == 1) { ?>
                                        <a class="dropdown-item" href="export_allData"><i class="fas fa-envelope m-r-5 m-l-5"></i> Export</a>
                                    <?php }
                                    if ($row['type'] == 1 || $row['admin_status'] == 1) { ?>
                                        <!--<a class="dropdown-item" href="we_register"><i class="fas fa-plus m-r-5 m-l-5" aria-hidden="true"></i> Register Company</a>-->
                                    <?php } ?>
                                    <a class="dropdown-item" href="email_log_data"><i class="fas fa-envelope m-r-5 m-l-5"></i> Email Log</a>
                                    <a class="dropdown-item" href="" data-toggle="modal" data-target="#LogoutPopup"><i class="fa fa-power-off m-r-5 m-l-5"></i> Logout</a>
                                    <!--a class="dropdown-item" href="javascript:void(0)"><i class="ti-email m-r-5 m-l-5"></i> Inbox</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="javascript:void(0)"><i class="ti-settings m-r-5 m-l-5"></i> Account Setting</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="javascript:void(0)"><i class="fa fa-power-off m-r-5 m-l-5"></i> Logout</a>
                                    <div class="dropdown-divider"></div>
                                    <div class="p-l-30 p-10"><a href="javascript:void(0)" class="btn btn-sm btn-success btn-rounded">View Profile</a></div-->
                                </div>
                            </li>
                            <!-- ============================================================== -->
                            <!-- User profile and search -->
                            <!-- ============================================================== -->
                        </ul>
                    <?php } else { ?>
                        <!-- ============================================================== -->
                        <!-- Right side toggle and nav items -->
                        <!-- ============================================================== -->
                        <ul class="navbar-nav float-right">
                            <!-- ============================================================== -->
                            <!-- User profile and search -->
                            <!-- ============================================================== -->
                            <!--<img src="html/images/users/1.jpg" alt="user" class="rounded-circle" width="31">-->
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark pro-pic" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Hey, <?php echo  $_SESSION['username']; ?></a>
                                <div class="dropdown-menu dropdown-menu-right user-dd animated">
                                    <a class="dropdown-item" href="#"><i class="fa fa-user m-r-5 m-l-5"></i> Client Id : <b><?php echo $_SESSION['service_id']; ?></b></a>
                                    <!--<a class="dropdown-item" href="" data-toggle="modal" data-target="#ChangePasswordPopup"><i class="fa fa-key m-r-5 m-l-5"></i> Change Password</a>-->
                                    <a class="dropdown-item" href="" data-toggle="modal" data-target="#LogoutPopup"><i class="fa fa-power-off m-r-5 m-l-5"></i> Logout</a>
                                    <!--a class="dropdown-item" href="javascript:void(0)"><i class="ti-email m-r-5 m-l-5"></i> Inbox</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="javascript:void(0)"><i class="ti-settings m-r-5 m-l-5"></i> Account Setting</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="javascript:void(0)"><i class="fa fa-power-off m-r-5 m-l-5"></i> Logout</a>
                                    <div class="dropdown-divider"></div>
                                    <div class="p-l-30 p-10"><a href="javascript:void(0)" class="btn btn-sm btn-success btn-rounded">View Profile</a></div-->
                                </div>
                            </li>
                            <!-- ============================================================== -->
                            <!-- User profile and search -->
                            <!-- ============================================================== -->
                        </ul>
                    <?php }
                    ?>
                </div>
            </nav>
        </header>
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <?php if ($_SESSION['user_type'] == 'system_user') { ?>
            <aside class="left-sidebar left-menu" data-sidebarbg="skin5">
                <!-- Sidebar scroll-->
                <div class="scroll-sidebar">
                    <!-- Sidebar navigation-->
                    <nav class="sidebar-nav">
                        <ul id="sidebarnav" class="p-t-30">
                            <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link singleLink" href="Dashboard" aria-expanded="false"><i class="fas fa-tachometer-alt"></i><span class="hide-menu">ESP Dashboard</span></a></li>

                            <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fas fa-calculator"></i><span class="hide-menu">Operations </span></a>
                                <ul aria-expanded="false" class="collapse  first-level pl-3">
                                    <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fas fa-calculator"></i><span class="hide-menu">Master </span></a>
                                        <ul aria-expanded="false" class="collapse first-level pl-3">
                                            <?php if ($row['client_master'] == "1") { ?>
                                                <li class="sidebar-item"> <a class="sidebar-link sidebar-link singleLink" href="client_master" aria-expanded="false"><i class="fas fa-users"></i><span class="hide-menu">Recipient Master</span></a></li>
                                            <?php }
                                            if ($row['vendor_master'] == "1") { ?>
                                                <li class="sidebar-item"> <a class="sidebar-link sidebar-link singleLink" href="vendor_master" aria-expanded="false"><i class="fas fa-users"></i><span class="hide-menu">Supplier Master</span></a></li>
                                            <?php } ?>
                                        </ul>
                                    </li>

                                    <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fas fa-calculator"></i><span class="hide-menu">Recipient Station </span></a>
                                        <ul aria-expanded="false" class="collapse first-level pl-3">
                                            <?php if ($row['client_master'] == "1") { ?>
                                            <?php }
                                            if ($row['gst'] == "1" || $row['it_returns'] == "1" || $row['audit'] == "1") { ?>
                                                <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fas fa-calculator"></i><span class="hide-menu">Taxation </span></a>
                                                    <ul aria-expanded="false" class="collapse first-level pl-3">
                                                        <?php if ($userrow['type'] == 1 || $row['gst'] == "1") { ?>
                                                            <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fas fa-calculator"></i><span class="hide-menu">GST </span></a>
                                                                <ul aria-expanded="false" class="collapse first-level pl-3">
                                                                    <li class="sidebar-item"> <a class="sidebar-link sidebar-link singleLink" href="gst_fees" aria-expanded="false"><i class="fas fa-calculator"></i><span class="hide-menu">GST Fees</span></a></li>
                                                                    <li class="sidebar-item"> <a class="sidebar-link sidebar-link singleLink" href="gst_returns" aria-expanded="false"><i class="fas fa-calculator"></i><span class="hide-menu">GST Returns</span></a></li>
                                                                </ul>
                                                            </li>
                                                        <?php }
                                                        if ($row['it_returns'] == "1") { ?>
                                                            <li class="sidebar-item"><a href="it_returns" class="sidebar-link"><i class="mdi mdi-note-plus"></i><span class="hide-menu"> IT Returns </span></a></li>
                                                        <?php }
                                                        if ($row['audit'] == "1") { ?>
                                                            <li class="sidebar-item"><a href="audit" class="sidebar-link"><i class="mdi mdi-note-plus"></i><span class="hide-menu"> Audit </span></a></li>
                                                        <?php } ?>
                                                    </ul>
                                                </li>
                                            <?php }
                                            if ($row['pan'] == "1" || $row['tan'] == "1" || $row['e_tds'] == "1" || $row['psp'] == "1" || $row['psp_coupon_consumption'] == "1") { ?>
                                                <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-receipt"></i><span class="hide-menu">Tin/Pan-FC </span></a>
                                                    <ul aria-expanded="false" class="collapse first-level pl-3">
                                                        <?php if ($row['pan'] == "1" || $row['tan'] == "1" || $row['e_tds'] == "1") { ?>
                                                            <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-receipt"></i><span class="hide-menu">NSDL </span></a>
                                                                <ul aria-expanded="false" class="collapse  first-level pl-3">
                                                                    <?php if ($row['pan'] == "1") { ?>
                                                                        <li class="sidebar-item"><a href="pan" class="sidebar-link"><i class="mdi mdi-note-outline"></i><span class="hide-menu"> PAN </span></a></li>
                                                                    <?php }
                                                                    if ($row['tan'] == "1") { ?>
                                                                        <li class="sidebar-item"><a href="tan" class="sidebar-link"><i class="mdi mdi-note-plus"></i><span class="hide-menu"> TAN </span></a></li>
                                                                    <?php }
                                                                    if ($row['e_tds'] == "1") { ?>
                                                                        <li class="sidebar-item"><a href="e_tds" class="sidebar-link"><i class="mdi mdi-note-plus"></i><span class="hide-menu"> e-TDS </span></a></li>
                                                                    <?php } ?>
                                                                    <li class="sidebar-item"><a href="twenty4g" class="sidebar-link"><i class="mdi mdi-note-plus"></i><span class="hide-menu"> 24G </span></a></li>
                                                                </ul>
                                                            </li>
                                                        <?php }
                                                        if ($row['psp'] == "1" || $row['psp_coupon_consumption'] == "1") { ?>
                                                            <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-receipt"></i><span class="hide-menu">UTI </span></a>
                                                                <ul aria-expanded="false" class="collapse first-level pl-3">
                                                                    <?php if ($row['psp'] == "1") { ?>
                                                                        <li class="sidebar-item"><a href="psp" class="sidebar-link"><i class="mdi mdi-note-outline"></i><span class="hide-menu" style="font-size: 13px;"> Sub-PSP </span></a></li>
                                                                    <?php }
                                                                    if ($row['psp_coupon_consumption'] == "1") { ?>
                                                                        <!-- <li class="sidebar-item"><a href="coupon_consumption" class="sidebar-link"><i class="mdi mdi-note-plus"></i><span class="hide-menu"> PSP Coupon </span></a></li> -->
                                                                    <?php } ?>
                                                                </ul>
                                                            </li>
                                                        <?php } ?>
                                                    </ul>
                                                </li>
                                            <?php }
                                            if ($row['dsc_subscriber'] == "1" || $row['dsc_reseller'] == "1") { ?>
                                                <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-receipt"></i><span class="hide-menu">DSC </span></a>
                                                    <ul aria-expanded="false" class="collapse  first-level pl-3">
                                                        <?php if ($row['dsc_subscriber'] == "1") { ?>
                                                            <li class="sidebar-item"><a href="dsc_subscriber" class="sidebar-link"><i class="mdi mdi-note-outline"></i><span class="hide-menu"> DSC Applicant </span></a></li>
                                                        <?php }
                                                        if ($row['dsc_reseller'] == "1") { ?>
                                                            <li class="sidebar-item"><a href="dsc_reseller" class="sidebar-link"><i class="mdi mdi-note-plus"></i><span class="hide-menu"> DSC Partner </span></a></li>
                                                        <?php } ?>
                                                        <li class="sidebar-item"><a href="dsc_token" class="sidebar-link"><i class="mdi mdi-note-plus"></i><span class="hide-menu"> Token Usage </span></a></li>
                                                        <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-receipt"></i><span class="hide-menu">Inventory </span></a>
                                                            <ul aria-expanded="false" class="collapse  first-level pl-3">
                                                                <li class="sidebar-item"><a href="token_stock" class="sidebar-link"><i class="mdi mdi-note-plus"></i><span class="hide-menu"> Procured Stock </span></a></li>
                                                                <li class="sidebar-item"><a href="dsc_stock" class="sidebar-link"><i class="mdi mdi-note-plus"></i><span class="hide-menu"> DSC Inventory </span></a></li>
                                                                <li class="sidebar-item"><a href="exchange" class="sidebar-link"><i class="mdi mdi-note-plus"></i><span class="hide-menu"> Exchange </span></a></li>
                                                            </ul>
                                                        </li>
                                                    </ul>
                                                </li>
                                            <?php } ?>


                                            <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-receipt"></i><span class="hide-menu">Financial Consultancy </span></a>
                                                <ul aria-expanded="false" class="collapse  first-level pl-3">
                                                    <li class="sidebar-item"><a href="loan" class="sidebar-link"><i class="mdi mdi-note-outline"></i><span class="hide-menu"> Loan </span></a></li>
                                                    <li class="sidebar-item"><a href="insurance" class="sidebar-link"><i class="mdi mdi-note-plus"></i><span class="hide-menu"> Insurance </span></a></li>
                                                    <li class="sidebar-item"><a href="finance" class="sidebar-link"><i class="mdi mdi-note-plus"></i><span class="hide-menu"> Finance </span></a></li>
                                                </ul>
                                            </li>
                                            <?php if ($row['other_services'] == "1") { ?>
                                                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link singleLink" href="other_services" aria-expanded="false"><i class="mdi mdi-view-dashboard"></i><span class="hide-menu">Other Services</span></a></li>
                                            <?php } ?>
                                            <?php if ($row['e_tender'] == "1") { ?>
                                                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link singleLink" href="e_tender" aria-expanded="false"><i class="mdi mdi-view-dashboard"></i><span class="hide-menu">E tender</span></a></li>
                                            <?php } ?>
                                            <?php
                                            if ($row['dsc_subscriber'] == "1") { ?>
                                                <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-receipt"></i><span class="hide-menu">Trading Station </span></a>
                                                    <ul aria-expanded="false" class="collapse  first-level pl-3">
                                                        <li class="sidebar-item"><a href="sales" class="sidebar-link"><i class="mdi mdi-note-outline"></i><span class="hide-menu"> Sales </span></a></li>
                                                        <li class="sidebar-item"><a href="inventory" class="sidebar-link"><i class="mdi mdi-note-plus"></i><span class="hide-menu"> Inventory </span></a></li>
                                                    </ul>
                                                </li>
                                            <?php }
                                            ?>
                                            <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-receipt"></i><span class="hide-menu">Intellectual Property </span></a>
                                                <ul aria-expanded="false" class="collapse  first-level pl-3">
                                                    <?php
                                                    if ($row['trade_mark'] == "1" || $row['patent'] == "1" || $row['copy_right'] == "1" || $row['trade_secret'] == "1" || $row['industrial_design'] == "1") { ?>
                                                        <li class="sidebar-item"><a href="ip_dashboard" class="sidebar-link"><i class="mdi mdi-note-plus"></i><span class="hide-menu"> IP Dashboard </span></a></li>
                                                    <?php }
                                                    if ($row['trade_mark'] == "1") { ?>
                                                        <li class="sidebar-item"><a href="intell_trademark" class="sidebar-link"><i class="mdi mdi-note-plus"></i><span class="hide-menu"> Trade mark </span></a></li>
                                                    <?php }
                                                    if ($row['patent'] == "1") { ?>
                                                        <li class="sidebar-item"><a href="intell_patent" class="sidebar-link"><i class="mdi mdi-note-plus"></i><span class="hide-menu"> Patent </span></a></li>
                                                    <?php }
                                                    if ($row['copy_right'] == "1") { ?>
                                                        <li class="sidebar-item"><a href="intell_copyright" class="sidebar-link"><i class="mdi mdi-note-plus"></i><span class="hide-menu"> Copy right </span></a></li>
                                                    <?php }
                                                    if ($row['trade_secret'] == "1") { ?>
                                                        <li class="sidebar-item"><a href="intell_tradesecret" class="sidebar-link"><i class="mdi mdi-note-plus"></i><span class="hide-menu"> Trade Secret </span></a></li>
                                                    <?php }
                                                    if ($row['industrial_design'] == "1") { ?>
                                                        <li class="sidebar-item"><a href="industrial_design" class="sidebar-link"><i class="mdi mdi-note-plus"></i><span class="hide-menu"> Industrial Design </span></a></li>
                                                    <?php }
                                                    if ($row['trade_mark'] == "1" || $row['patent'] == "1" || $row['copy_right'] == "1" || $row['trade_secret'] == "1" || $row['industrial_design'] == "1") { ?>
                                                        <li class="sidebar-item"><a href="ip_utility" class="sidebar-link"><i class="mdi mdi-note-plus"></i><span class="hide-menu"> IP Utility </span></a></li>
                                                    <?php } ?>
                                                </ul>
                                            </li>
                                            <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-receipt"></i><span class="hide-menu">Advocate </span></a>
                                                <ul aria-expanded="false" class="collapse  first-level pl-3">

                                                    <li class="sidebar-item"><a href="advocate_case" class="sidebar-link"><i class="mdi mdi-note-outline"></i><span class="hide-menu"> Cases </span></a></li>
                                                    <li class="sidebar-item"><a href="advocate_setup" class="sidebar-link"><i class="mdi mdi-note-outline"></i><span class="hide-menu"> Setup </span></a></li>

                                                    <!--<li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-receipt"></i><span class="hide-menu">Setup </span></a>-->
                                                    <!--    <ul aria-expanded="false" class="collapse  first-level pl-3">-->
                                                    <!--        <li class="sidebar-item"><a href="token_stock" class="sidebar-link"><i class="mdi mdi-note-plus"></i><span class="hide-menu"> Product List </span></a></li>-->
                                                    <!--        <li class="sidebar-item"><a href="dsc_stock" class="sidebar-link"><i class="mdi mdi-note-plus"></i><span class="hide-menu"> Fees Structure </span></a></li>-->
                                                    <!--        <li class="sidebar-item"><a href="exchange" class="sidebar-link"><i class="mdi mdi-note-plus"></i><span class="hide-menu"> File Inward Mode </span></a></li>-->
                                                    <!--        <li class="sidebar-item"><a href="exchange" class="sidebar-link"><i class="mdi mdi-note-plus"></i><span class="hide-menu"> Property Discription </span></a></li>-->
                                                    <!--        <li class="sidebar-item"><a href="exchange" class="sidebar-link"><i class="mdi mdi-note-plus"></i><span class="hide-menu"> Controlling Branch </span></a></li>-->
                                                    <!--        <li class="sidebar-item"><a href="exchange" class="sidebar-link"><i class="mdi mdi-note-plus"></i><span class="hide-menu"> Status List </span></a></li>-->
                                                    <!--    </ul>-->
                                                    <!--</li>-->
                                                </ul>
                                            </li>

                                        </ul>
                                    </li>

                                    <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fas fa-calculator"></i><span class="hide-menu">Supplier Station </span></a>
                                        <ul aria-expanded="false" class="collapse first-level pl-3">
                                            <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link singleLink" href="supplier_received" xpanded="false"><i class="mdi mdi-view-dashboard"></i><span class="hide-menu">Supplier Received</span></a></li>
                                            <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link singleLink" href="servise_received" aria-expanded="false"><i class="mdi mdi-view-dashboard"></i><span class="hide-menu">Service Configuration</span></a></li>
                                            <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link singleLink" href="goods_received" aria-expanded="false"><i class="mdi mdi-view-dashboard"></i><span class="hide-menu">Goods Configuration</span></a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                            <?php if ($row['document_records'] == "1") { ?>
                                <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-receipt"></i><span class="hide-menu">Accounts/Documents </span></a>
                                    <ul aria-expanded="false" class="collapse  first-level pl-3">
                                        <li class="sidebar-item"><a href="tax_invoice" class="sidebar-link"><i class="mdi mdi-note-outline"></i><span class="hide-menu"> Tax Invoice </span></a></li>
                                        <li class="sidebar-item"><a href="retail_invoice" class="sidebar-link"><i class="mdi mdi-note-outline"></i><span class="hide-menu"> Retail Invoice </span></a></li>
                                        <li class="sidebar-item"><a href="purchase_note" class="sidebar-link"><i class="mdi mdi-note-outline"></i><span class="hide-menu"> Purchase Order </span></a></li>
                                        <li class="sidebar-item"><a href="quotation_note" class="sidebar-link"><i class="mdi mdi-note-outline"></i><span class="hide-menu"> Quotation </span></a></li>
                                        <li class="sidebar-item"><a href="credit_note" class="sidebar-link"><i class="mdi mdi-note-outline"></i><span class="hide-menu"> Credit Note </span></a></li>
                                        <li class="sidebar-item"><a href="debit_note" class="sidebar-link"><i class="mdi mdi-note-outline"></i><span class="hide-menu"> Debit Note </span></a></li>
                                        <li class="sidebar-item"><a href="drawee" class="sidebar-link"><i class="mdi mdi-note-outline"></i><span class="hide-menu"> Drawee </span></a></li>
                                    </ul>
                                </li>
                            <?php } ?>

                            <?php if ($row['payment'] == "1" || $row['settlement'] == "1" || $row['expense'] == "1" || $row['contra_voucher'] == "1") { ?>
                                <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fas fa-calculator"></i><span class="hide-menu">Finance/Bank </span></a>
                                    <ul aria-expanded="false" class="collapse  first-level pl-3">
                                        <?php if ($row['payment'] == "1") { ?>
                                            <li class="sidebar-item"> <a class="sidebar-link sidebar-link singleLink" href="advance" aria-expanded="false"><i class="fas fa-coins"></i><span class="hide-menu">Payment</span></a></li>
                                        <?php }
                                        if ($row['settlement'] == "1") { ?>

                                            <li class="sidebar-item"> <a class="sidebar-link sidebar-link singleLink" href="service_income" aria-expanded="false"><i class="fas fa-coins"></i><span class="hide-menu">Settlement</span></a></li>
                                            <!--<li class="sidebar-item"> <a class="sidebar-link sidebar-link singleLink" href="service_income" aria-expanded="false"><i class="fas fa-coins"></i><span class="hide-menu">Service settlement</span></a></li>-->
                                            <!--<li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fas fa-calculator"></i><span class="hide-menu">Settlement </span></a>-->
                                            <!--    <ul aria-expanded="false" class="collapse first-level pl-3">-->
                                            <!--        <li class="sidebar-item"> <a class="sidebar-link sidebar-link singleLink" href="service_income" aria-expanded="false"><i class="fas fa-calculator"></i><span class="hide-menu">Income Settlement</span></a></li>-->
                                            <!--        <li class="sidebar-item"> <a class="sidebar-link sidebar-link singleLink" href="service_income1" aria-expanded="false"><i class="fas fa-calculator"></i><span class="hide-menu">Expense Settlement</span></a></li>-->
                                            <!--    </ul>-->
                                            <!--</li>-->
                                        <?php }
                                        if ($row['expense'] == "1") { ?>
                                            <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fas fa-calculator"></i><span class="hide-menu">Expense </span></a>
                                                <ul aria-expanded="false" class="collapse first-level pl-3">
                                                    <li class="sidebar-item"> <a class="sidebar-link sidebar-link singleLink" href="emp_salary_settelment" aria-expanded="false"><i class="fas fa-calculator"></i><span class="hide-menu">Salary Settlement</span></a></li>
                                                    <li class="sidebar-item"> <a class="sidebar-link sidebar-link singleLink" href="staff_pay_addition" aria-expanded="false"><i class="fas fa-calculator"></i><span class="hide-menu">Staff Pay Addition</span></a></li>
                                                    <li class="sidebar-item"> <a class="sidebar-link sidebar-link singleLink" href="utility" aria-expanded="false"><i class="fas fa-calculator"></i><span class="hide-menu">Utility</span></a></li>
                                                </ul>
                                            </li>
                                        <?php }
                                        if ($row['contra_voucher'] == "1") { ?>
                                            <!--<li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link singleLink" href="service_expense" aria-expanded="false"><i class="mdi mdi-view-dashboard"></i><span class="hide-menu"> Records</span></a></li>-->
                                            <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link singleLink" href="service_contra" aria-expanded="false"><i class="mdi mdi-coins"></i><span class="hide-menu">Contra Voucher</span></a></li>
                                        <?php } ?>
                                        <!--<li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link singleLink" href="outstadings_both" aria-expanded="false"><i class="mdi mdi-coins"></i><span class="hide-menu">Outstanding</span></a></li>-->
                                    </ul>
                                    <!--<ul aria-expanded="false" class="collapse  first-level pl-3">-->
                                    <!--    <li class="sidebar-item"> <a class="sidebar-link sidebar-link singleLink" href="advance" aria-expanded="false"><i class="fas fa-coins"></i><span class="hide-menu">Payment Received</span></a></li>-->
                                    <!--    <li class="sidebar-item"> <a class="sidebar-link sidebar-link singleLink" href="service_income" aria-expanded="false"><i class="fas fa-coins"></i><span class="hide-menu">Service settlement</span></a></li>-->
                                    <!--    <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link singleLink" href="service_expense" aria-expanded="false"><i class="mdi mdi-view-dashboard"></i><span class="hide-menu">Expense</span></a></li>-->
                                    <!--    <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link singleLink" href="service_contra" aria-expanded="false"><i class="mdi mdi-coins"></i><span class="hide-menu">Contra Voucher</span></a></li>-->
                                    <!--</ul>-->
                                </li>
                            <?php } ?>
                            <?php if ($row['reports'] == "1" || $row['bank_report'] == "1" || $row['outstanding'] == "1") { ?>
                                <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fas fa-calculator"></i><span class="hide-menu">Report </span></a>
                                    <ul aria-expanded="false" class="collapse  first-level pl-3">
                                        <?php if ($row['reports'] == "1") { ?>
                                            <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link singleLink" href="recipient_report" aria-expanded="false"><i class="fas fa-rupee-sign"></i><span class="hide-menu">Recipient Report</span></a></li>
                                            <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link singleLink" href="supplier_report" aria-expanded="false"><i class="fas fa-rupee-sign"></i><span class="hide-menu">Supplier Report</span></a></li>
                                        <?php }
                                        if ($row['bank_report'] == "1") { ?>
                                            <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link singleLink" href="finance_report" aria-expanded="false"><i class="mdi mdi-coins"></i><span class="hide-menu">Bank Report</span></a></li>
                                        <?php }
                                        if ($row['outstanding'] == "1") { ?>
                                            <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link singleLink" href="outstanding" aria-expanded="false"><i class="mdi mdi-coins"></i><span class="hide-menu">Outstanding</span></a></li>
                                        <?php }
                                        if ($row['outstanding'] == "1") { ?>
                                            <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link singleLink" href="supplier_outstanding" aria-expanded="false"><i class="mdi mdi-coins"></i><span class="hide-menu">Expense Outstanding</span></a></li>
                                        <?php } ?>
                                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link singleLink" href="user_report" aria-expanded="false"><i class="mdi mdi-coins"></i><span class="hide-menu">User Report</span></a></li>
                                </li>
                        </ul>
                        </li>
                    <?php } ?>
                    <?php if ($row['payroll'] == "1") { ?>

                        <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-receipt"></i><span class="hide-menu">HR/Payroll</span></a>
                            <ul aria-expanded="false" class="collapse  first-level pl-3">
                                <li class="sidebar-item"><a href="prEmployeeMaster" class="sidebar-link"><i class="mdi mdi-note-outline"></i><span class="hide-menu">Employees</span></a></li>
                                <li class="sidebar-item"><a href="prEmployeeAttendance" class="sidebar-link"><i class="mdi mdi-note-plus"></i><span class="hide-menu">Attendance</span></a></li>
                                <li class="sidebar-item"><a href="showsalarypage" class="sidebar-link"><i class="mdi mdi-note-plus"></i><span class="hide-menu"> Salary Slip </span></a></li>
                                <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-receipt"></i><span class="hide-menu">Allotments </span></a>
                                    <ul aria-expanded="false" class="collapse  first-level pl-3">
                                        <li class="sidebar-item"><a href="prSetting" class="sidebar-link"><i class="mdi mdi-note-outline"></i><span class="hide-menu"> Off & Leaves </span></a></li>
                                        <li class="sidebar-item"><a href="emp_loans" class="sidebar-link"><i class="mdi mdi-note-plus"></i><span class="hide-menu"> Loans </span></a></li>
                                        <!--    <li class="sidebar-item"><a href="e_tds" class="sidebar-link"><i class="mdi mdi-note-plus"></i><span class="hide-menu"> e-TDS </span></a></li>-->
                                        <!--    <li class="sidebar-item"><a href="twenty4g" class="sidebar-link"><i class="mdi mdi-note-plus"></i><span class="hide-menu"> 24G </span></a></li>-->
                                    </ul>
                                </li>
                                <!--<li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-receipt"></i><span class="hide-menu">UTI </span></a>-->
                                <!--    <ul aria-expanded="false" class="collapse  first-level pl-3">-->
                                <!--        <li class="sidebar-item"><a href="psp" class="sidebar-link"><i class="mdi mdi-note-outline"></i><span class="hide-menu"> Sub-PSP</span></a></li>-->
                                <!-- <li class="sidebar-item"><a href="coupon_consumption" class="sidebar-link"><i class="mdi mdi-note-plus"></i><span class="hide-menu"> PSP Coupon </span></a></li> -->
                                <!--    </ul>-->
                                <!--</li>-->
                            </ul>
                        </li>
                    <?php } ?>
                    <?php if ($row['add_taskmanager'] == "1") { ?>
                        <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fas fa-calculator"></i><span class="hide-menu">Task Management</span></a>
                            <ul aria-expanded="false" class="collapse  first-level pl-3">
                                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link singleLink" href="main_content" aria-expanded="false"><i class="mdi mdi-view-dashboard"></i><span class="hide-menu">Home</span></a></li>

                                <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fas fa-calculator"></i><span class="hide-menu">OTO-Task </span></a>
                                    <ul aria-expanded="false" class="collapse  first-level pl-3">
                                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link singleLink" href="do_task" aria-expanded="false"><i class="mdi mdi-coins"></i><span class="hide-menu">Do Task</span></a></li>
                                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link singleLink" href="give_task" aria-expanded="false"><i class="mdi mdi-coins"></i><span class="hide-menu">Give Task</span></a></li>
                                    </ul>
                                </li>
                                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link singleLink" href="group" aria-expanded="false"><i class="mdi mdi-coins"></i><span class="hide-menu">Group</span></a></li>
                            </ul>
                        </li>
                    <?php } ?>




                    <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fas fa-calculator"></i><span class="hide-menu">Booster Apps </span></a>
                        <ul aria-expanded="false" class="collapse  first-level pl-3">
                            <!-- <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-receipt"></i><span class="hide-menu">Pocket Accounts </span></a>
                                        <ul aria-expanded="false" class="collapse  first-level pl-3">
                                            <li class="sidebar-item"><a href="income" class="sidebar-link"><i class="mdi mdi-note-plus"></i><span class="hide-menu"> Income </span></a></li>
                                            <li class="sidebar-item"><a href="expense" class="sidebar-link"><i class="mdi mdi-note-plus"></i><span class="hide-menu"> Expense </span></a></li>
                                            <li class="sidebar-item"><a href="payable" class="sidebar-link"><i class="mdi mdi-airplane-takeoff"></i><span class="hide-menu"> Payable </span></a></li>
                                            <li class="sidebar-item"><a href="receivable" class="sidebar-link"><i class="mdi mdi-airplane-landing"></i><span class="hide-menu"> Receivable </span></a></li>
                                            <li class="sidebar-item"><a href="account_report" class="sidebar-link"><i class="fas fa-edit icons"></i><span class="hide-menu"> Summary </span></a></li>
                                            <li class="sidebar-item"><a href="setting" class="sidebar-link"><i class="fas fa-cogs"></i><span class="hide-menu"> Settings </span></a></li>
                                            <li class="sidebar-item"><a href="notes" class="sidebar-link"><i class="far fa-sticky-note icons"></i><span class="hide-menu"> Notes </span></a></li>
                                            <li class="sidebar-item"><a href="reminder" class="sidebar-link"><i class="fas fa-bell icons"></i><span class="hide-menu"> Reminder </span></a></li>
                                        </ul>
                                    </li> -->
                            <?php if ($row['add_Cont'] == "1") { ?>
                                <li class="sidebar-item"> <a class="sidebar-link sidebar-link singleLink" href="contact_client" aria-expanded="false"><i class="fas fa-id-card"></i><span class="hide-menu">Contacts</span></a></li>
                            <?php } ?>
                            <?php if ($row['add_passMang'] == "1") { ?>
                                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link singleLink" href="password_manager" aria-expanded="false"><i class="mdi mdi-view-dashboard"></i><span class="hide-menu">Password Manager</span></a></li>
                            <?php } ?>
                            <li class="sidebar-item"> <a class="sidebar-link sidebar-link singleLink" href="fix_meeting" aria-expanded="false"><i class="fas fa-id-card"></i><span class="hide-menu">Fix Meeting</span></a></li>
                            <?php if ($row['tickets'] == "1") { ?>
                                <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fas fa-calculator"></i><span class="hide-menu">Tickets </span></a>
                                    <ul aria-expanded="false" class="collapse  first-level pl-3">
                                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link singleLink" href="Client_query" aria-expanded="false"><i class="mdi mdi-view-dashboard"></i><span class="hide-menu">Fresh Chats</span></a></li>
                                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link singleLink" href="resolved_chat.php" aria-expanded="false"><i class="mdi mdi-view-dashboard"></i><span class="hide-menu">Replied Chats</span></a></li>
                                    </ul>
                                <li>
                                <?php } ?>
                                <?php if ($row['add_enquiry'] == "1") { ?>
                                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link singleLink" href="enquiry" aria-expanded="false"><i class="fas fa-id-card"></i><span class="hide-menu">Internal Enquiry</span></a></li>
                            <?php } ?>
                        </ul>
                    </li>
                    <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fas fa-calculator"></i><span class="hide-menu">CRM </span></a>
                        <ul aria-expanded="false" class="collapse  first-level pl-3">
                            <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fas fa-calculator"></i><span class="hide-menu">CRM Dashboard </span></a>
                                <ul aria-expanded="false" class="collapse  first-level pl-3">
                                    <?php if ($row['add_Admin_filter'] == "1") { ?>
                                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link singleLink" href="crm_dashboard" aria-expanded="false"><i class="fas fa-tachometer-alt"></i><span class="hide-menu">CRM Admin Dashboard</span></a></li>
                                    <?php } ?>
                                    <?php if ($userrow['type'] == 3) { ?>
                                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link singleLink" href="user_dashboard" aria-expanded="false"><i class="fas fa-tachometer-alt"></i><span class="hide-menu">My Dashboard</span></a></li>
                                    <?php } ?>
                                    <?php if ($userrow['crm_teamleader'] == 1) { ?>
                                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link singleLink" href="team_leader_dashboard" aria-expanded="false"><i class="fas fa-tachometer-alt"></i><span class="hide-menu">TL Dashboard</span></a></li>
                                    <?php } ?>
                                </ul>
                            </li>
                            <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fas fa-calculator"></i><span class="hide-menu">CALLARIC </span></a>
                                <ul aria-expanded="false" class="collapse  first-level pl-3">
                                    <?php if ($userrow['ca_dashboard'] == 1) { ?>
                                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link singleLink" href="callaric" aria-expanded="false"><i class="fas fa-tachometer-alt"></i><span class="hide-menu">Dashboard</span></a></li>
                                    <?php } ?>
                                    <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link singleLink" href="staff_dashboard" aria-expanded="false"><i class="fas fa-tachometer-alt"></i><span class="hide-menu">Staff Dashboard</span></a></li>
                                    <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link singleLink" href="aric_analytics" aria-expanded="false"><i class="fas fa-tachometer-alt"></i><span class="hide-menu">Aric Analytics</span></a></li>
                                    <?php if ($userrow['ca_dashboard'] == 1) { ?>
                                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link singleLink" href="call_report" aria-expanded="false"><i class="fas fa-tachometer-alt"></i><span class="hide-menu">Call Report</span></a></li>
                                    <?php } ?>
                                    <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link singleLink" href="log_report" aria-expanded="false"><i class="fas fa-tachometer-alt"></i><span class="hide-menu">Call Log</span></a></li>

                                </ul>
                            </li>
                            <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fas fa-calculator"></i><span class="hide-menu">CRM Setup </span></a>
                                <ul aria-expanded="false" class="collapse  first-level pl-3">
                                    <?php if (($row['admin_status'] == "1") || ($row['data_record'] == "1")) { ?>
                                        <li class="sidebar-item"> <a class="sidebar-link sidebar-link singleLink" href="calling_data" aria-expanded="false"><i class="fas fa-id-card"></i><span class="hide-menu">Data Record</span></a></li>
                                    <?php } ?>
                                    <?php if (($row['admin_status'] == "1") || ($row['record_transfer'] == "1")) { ?>
                                        <li class="sidebar-item"> <a class="sidebar-link sidebar-link singleLink" href="ac_Change" aria-expanded="false"><i class="fas fa-id-card"></i><span class="hide-menu">Record Transfer</span></a></li>
                                    <?php } ?>
                                    <?php if ($row['add_clientConfig'] == "1") { ?>
                                        <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fas fa-calculator"></i><span class="hide-menu">Client Configuration</span></a>
                                            <ul aria-expanded="false" class="collapse  first-level pl-3">
                                                <!--<li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link singleLink" href="client_status" aria-expanded="false"><i class="mdi mdi-view-dashboard"></i><span class="hide-menu">Client Status</span></a></li>-->
                                                <!--<li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link singleLink" href="client_service" aria-expanded="false"><i class="mdi mdi-view-dashboard"></i><span class="hide-menu">Service</span></a></li>                                    -->
                                                <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fas fa-calculator"></i><span class="hide-menu">Assist Status </span></a>
                                                    <ul aria-expanded="false" class="collapse  first-level pl-3">
                                                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link singleLink" href="client_status" aria-expanded="false"><i class="mdi mdi-coins"></i><span class="hide-menu">V Client Status</span></a></li>
                                                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link singleLink" href="Status_partner" aria-expanded="false"><i class="mdi mdi-coins"></i><span class="hide-menu">Assoc Client Status</span></a></li>
                                                    </ul>
                                                </li>
                                                <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fas fa-calculator"></i><span class="hide-menu">Assist Service </span></a>
                                                    <ul aria-expanded="false" class="collapse  first-level pl-3">
                                                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link singleLink" href="client_service" aria-expanded="false"><i class="mdi mdi-coins"></i><span class="hide-menu">V Client Service</span></a></li>
                                                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link singleLink" href="service_Partner" aria-expanded="false"><i class="mdi mdi-coins"></i><span class="hide-menu">Assoc Client Service</span></a></li>
                                                    </ul>
                                                </li>
                                                <!--<li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link singleLink" href="group" aria-expanded="false"><i class="mdi mdi-coins"></i><span class="hide-menu">Group</span></a></li>-->
                                            </ul>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </li>
                            <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fas fa-calculator"></i><span class="hide-menu">CRM Utility </span></a>
                                <ul aria-expanded="false" class="collapse  first-level pl-3">
                                    <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link singleLink" href="mom_filter" aria-expanded="false"><i class="fas fa-tachometer-alt"></i><span class="hide-menu">MOM Filter</span></a></li>
                                    <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link singleLink" href="client_filter" aria-expanded="false"><i class="fas fa-tachometer-alt"></i><span class="hide-menu">Trace Contact</span></a></li>
                                    <?php if (($row['admin_status'] == "1") || ($row['add_Admin_filter'] == "1")) { ?>
                                        <li class="sidebar-item"> <a class="sidebar-link sidebar-link singleLink" href="call_Filter" aria-expanded="false"><i class="fas fa-id-card"></i><span class="hide-menu">Admin Filter</span></a></li>
                                    <?php } ?>
                                    <?php if ($row['user_type'] == "simple_user") { ?>
                                        <li class="sidebar-item"> <a class="sidebar-link sidebar-link singleLink" href="addRecord" aria-expanded="false"><i class="fas fa-id-card"></i><span class="hide-menu">Add Record</span></a></li>
                                    <?php } ?>
                                </ul>
                            </li>

                            <?php if ($row['add_jobProg'] == "1") { ?>
                                <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fas fa-calculator"></i><span class="hide-menu">Job Progress </span></a>
                                    <ul aria-expanded="false" class="collapse  first-level pl-3">
                                        <li class="sidebar-item"> <a class="sidebar-link sidebar-link singleLink" href="job_progress" aria-expanded="false"><i class="fas fa-id-card"></i><span class="hide-menu">Client Job Progress</span></a></li>
                                        <li class="sidebar-item"> <a class="sidebar-link sidebar-link singleLink" href="part_progress" aria-expanded="false"><i class="fas fa-id-card"></i><span class="hide-menu">Assoc. Job Progress</span></a></li>
                                    </ul>
                                </li>
                            <?php } ?>
                            <?php if ($row['addBidding'] == "1") { ?>
                                <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fas fa-calculator"></i><span class="hide-menu">Bidding </span></a>
                                    <ul aria-expanded="false" class="collapse  first-level pl-3">
                                        <li class="sidebar-item"> <a class="sidebar-link sidebar-link singleLink" href="dashboard_bid" aria-expanded="false"><i class="fas fa-id-card"></i><span class="hide-menu">Participate Bidding</span></a></li>
                                        <li class="sidebar-item"> <a class="sidebar-link sidebar-link singleLink" href="filter_bid" aria-expanded="false"><i class="fas fa-id-card"></i><span class="hide-menu">Report</span></a></li>
                                    </ul>
                                </li>
                            <?php } ?>
                        </ul>
                    </li>
                    <?php if ($row['whatsapp'] == "1") { ?>
                        <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fas fa-calculator"></i><span class="hide-menu">Social Platforms </span></a>
                            <ul aria-expanded="false" class="collapse  first-level pl-3">
                                <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fas fa-calculator"></i><span class="hide-menu">WhatsApp </span></a>
                                    <ul aria-expanded="false" class="collapse first-level pl-3">
                                        <li class="sidebar-item"> <a class="sidebar-link sidebar-link singleLink" href="broadcast_Camp" aria-expanded="false"><i class="fas fa-users"></i><span class="hide-menu"> BC Campaign</span></a></li>
                                        <li class="sidebar-item"> <a class="sidebar-link sidebar-link singleLink" href="indieWhatsApp" aria-expanded="false"><i class="fas fa-users"></i><span class="hide-menu">Indie WhatsApp</span></a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                    <?php } ?>
                    </ul>
                    </nav>
                    <!-- End Sidebar navigation -->
                </div>
                <!-- End Sidebar scroll-->
            </aside>
        <?php } else { ?>
            <aside class="left-sidebar left-menu" data-sidebarbg="skin5">
                <!-- Sidebar scroll-->
                <div class="scroll-sidebar">
                    <!-- Sidebar navigation-->
                    <nav class="sidebar-nav">
                        <ul id="sidebarnav" class="p-t-30">
                            <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link singleLink" href="Dashboard" aria-expanded="false"><i class="fas fa-tachometer-alt"></i><span class="hide-menu">ESP Dashboard</span></a></li>
                            <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fas fa-calculator"></i><span class="hide-menu">Operations </span></a>
                                <ul aria-expanded="false" class="collapse  first-level pl-3">
                                    <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fas fa-calculator"></i><span class="hide-menu">Recipient Station </span></a>
                                        <ul aria-expanded="false" class="collapse first-level pl-3">
                                            <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fas fa-calculator"></i><span class="hide-menu">Taxation </span></a>
                                                <ul aria-expanded="false" class="collapse first-level pl-3">
                                                    <!-- <li class="sidebar-item"><a href="gst" class="sidebar-link"><i class="mdi mdi-note-plus"></i><span class="hide-menu"> GST </span></a></li> -->
                                                    <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fas fa-calculator"></i><span class="hide-menu">GST </span></a>
                                                        <ul aria-expanded="false" class="collapse first-level pl-3">
                                                            <li class="sidebar-item"> <a class="sidebar-link sidebar-link singleLink" href="gst_fees" aria-expanded="false"><i class="fas fa-calculator"></i><span class="hide-menu">GST Fees</span></a></li>
                                                            <li class="sidebar-item"> <a class="sidebar-link sidebar-link singleLink" href="gst_returns" aria-expanded="false"><i class="fas fa-calculator"></i><span class="hide-menu">GST Returns</span></a></li>
                                                        </ul>
                                                    </li>
                                                    <li class="sidebar-item"><a href="it_returns" class="sidebar-link"><i class="mdi mdi-note-plus"></i><span class="hide-menu"> IT Returns </span></a></li>
                                                    <li class="sidebar-item"><a href="audit" class="sidebar-link"><i class="mdi mdi-note-plus"></i><span class="hide-menu"> Audit </span></a></li>
                                                </ul>
                                            </li>
                                            <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-receipt"></i><span class="hide-menu">Tin/Pan-FC </span></a>
                                                <ul aria-expanded="false" class="collapse  first-level pl-3">
                                                    <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-receipt"></i><span class="hide-menu">NSDL </span></a>
                                                        <ul aria-expanded="false" class="collapse  first-level pl-3">
                                                            <li class="sidebar-item"><a href="pan" class="sidebar-link"><i class="mdi mdi-note-outline"></i><span class="hide-menu"> PAN </span></a></li>
                                                            <li class="sidebar-item"><a href="tan" class="sidebar-link"><i class="mdi mdi-note-plus"></i><span class="hide-menu"> TAN </span></a></li>
                                                            <li class="sidebar-item"><a href="e_tds" class="sidebar-link"><i class="mdi mdi-note-plus"></i><span class="hide-menu"> e-TDS </span></a></li>
                                                            <li class="sidebar-item"><a href="twenty4g" class="sidebar-link"><i class="mdi mdi-note-plus"></i><span class="hide-menu"> 24G </span></a></li>
                                                        </ul>
                                                    </li>
                                                    <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-receipt"></i><span class="hide-menu">UTI </span></a>
                                                        <ul aria-expanded="false" class="collapse  first-level pl-3">
                                                            <li class="sidebar-item"><a href="psp" class="sidebar-link"><i class="mdi mdi-note-outline"></i><span class="hide-menu"> Sub-PSP</span></a></li>
                                                            <!-- <li class="sidebar-item"><a href="coupon_consumption" class="sidebar-link"><i class="mdi mdi-note-plus"></i><span class="hide-menu"> PSP Coupon </span></a></li> -->
                                                        </ul>
                                                    </li>
                                                </ul>
                                            </li>
                                            <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-receipt"></i><span class="hide-menu">DSC </span></a>
                                                <ul aria-expanded="false" class="collapse  first-level pl-3">
                                                    <li class="sidebar-item"><a href="dsc_subscriber" class="sidebar-link"><i class="mdi mdi-note-outline"></i><span class="hide-menu"> DSC Applicant </span></a></li>
                                                    <li class="sidebar-item"><a href="dsc_reseller" class="sidebar-link"><i class="mdi mdi-note-plus"></i><span class="hide-menu"> DSC Partner </span></a></li>
                                                    <li class="sidebar-item"><a href="dsc_token" class="sidebar-link"><i class="mdi mdi-note-plus"></i><span class="hide-menu"> Token Usage </span></a></li>
                                                    <li class="sidebar-item d-none"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-receipt"></i><span class="hide-menu">Inventory </span></a>
                                                        <ul aria-expanded="false" class="collapse  first-level pl-3">
                                                            <li class="sidebar-item"><a href="token_stock" class="sidebar-link"><i class="mdi mdi-note-plus"></i><span class="hide-menu"> Procured Stock </span></a></li>
                                                            <li class="sidebar-item"><a href="dsc_stock" class="sidebar-link"><i class="mdi mdi-note-plus"></i><span class="hide-menu"> DSC Inventory </span></a></li>
                                                        </ul>
                                                    </li>
                                                </ul>
                                            </li>
                                            <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link singleLink" href="other_services" aria-expanded="false"><i class="mdi mdi-view-dashboard"></i><span class="hide-menu">Other Services</span></a></li>
                                            <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-receipt"></i><span class="hide-menu">Financial Consultancy </span></a>
                                                <ul aria-expanded="false" class="collapse  first-level pl-3">
                                                    <li class="sidebar-item"><a href="loan" class="sidebar-link"><i class="mdi mdi-note-outline"></i><span class="hide-menu"> Loan </span></a></li>
                                                    <li class="sidebar-item"><a href="insurance" class="sidebar-link"><i class="mdi mdi-note-plus"></i><span class="hide-menu"> Insurance </span></a></li>
                                                    <li class="sidebar-item"><a href="finance" class="sidebar-link"><i class="mdi mdi-note-plus"></i><span class="hide-menu"> Finance </span></a></li>
                                                </ul>
                                            </li>
                                            <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-receipt"></i><span class="hide-menu">Intellectual Property </span></a>
                                                <ul aria-expanded="false" class="collapse  first-level pl-3">
                                                    <li class="sidebar-item"><a href="intell_trademark" class="sidebar-link"><i class="mdi mdi-note-plus"></i><span class="hide-menu"> Trade mark </span></a></li>
                                                    <li class="sidebar-item"><a href="intell_patent" class="sidebar-link"><i class="mdi mdi-note-plus"></i><span class="hide-menu"> Patent </span></a></li>
                                                    <li class="sidebar-item"><a href="intell_copyright" class="sidebar-link"><i class="mdi mdi-note-plus"></i><span class="hide-menu"> Copy right </span></a></li>
                                                    <li class="sidebar-item"><a href="intell_tradesecret" class="sidebar-link"><i class="mdi mdi-note-plus"></i><span class="hide-menu"> Trade Secret </span></a></li>
                                                    <li class="sidebar-item"><a href="industrial_design" class="sidebar-link"><i class="mdi mdi-note-plus"></i><span class="hide-menu"> Industrial Design </span></a></li>
                                                </ul>
                                            </li>
                                            <!-- <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link singleLink" href="invoice_receipt" aria-expanded="false"><i class="fas fa-rupee-sign"></i><span class="hide-menu">Reports</span></a></li>
                                </ul> -->
                                    </li>
                                </ul>
                            </li>
                            <li class="sidebar-item d-none"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fas fa-calculator"></i><span class="hide-menu">Supplier </span></a>
                                <ul aria-expanded="false" class="collapse  first-level pl-3">
                                    <!-- <li class="sidebar-item"> <a class="sidebar-link sidebar-link singleLink" href="vendor_master" aria-expanded="false"><i class="fas fa-users"></i><span class="hide-menu">Supplier Master</span></a></li> -->
                                    <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link singleLink" href="services_received" aria-expanded="false"><i class="mdi mdi-view-dashboard"></i><span class="hide-menu">Services Received</span></a></li>
                                    <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link singleLink" href="invoice_payment" aria-expanded="false"><i class="mdi mdi-coins"></i><span class="hide-menu">Payment</span></a></li>
                                </ul>
                            </li>
                            <!-- <li class="sidebar-item d-none"> <a class="sidebar-link waves-effect waves-dark sidebar-link singleLink" href="bank_transaction" aria-expanded="false"><i class="fas fa-university"></i><span class="hide-menu">Bank Transaction</span></a></li> -->
                            <li class="sidebar-item d-none"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fas fa-calculator"></i><span class="hide-menu">Other Apps </span></a>
                                <ul aria-expanded="false" class="collapse  first-level pl-3">
                                    <!-- <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-receipt"></i><span class="hide-menu">Pocket Accounts </span></a>
                                        <ul aria-expanded="false" class="collapse  first-level pl-3">
                                            <li class="sidebar-item"><a href="income" class="sidebar-link"><i class="mdi mdi-note-plus"></i><span class="hide-menu"> Income </span></a></li>
                                            <li class="sidebar-item"><a href="expense" class="sidebar-link"><i class="mdi mdi-note-plus"></i><span class="hide-menu"> Expense </span></a></li>
                                            <li class="sidebar-item"><a href="payable" class="sidebar-link"><i class="mdi mdi-airplane-takeoff"></i><span class="hide-menu"> Payable </span></a></li>
                                            <li class="sidebar-item"><a href="receivable" class="sidebar-link"><i class="mdi mdi-airplane-landing"></i><span class="hide-menu"> Receivable </span></a></li>
                                            <li class="sidebar-item"><a href="account_report" class="sidebar-link"><i class="fas fa-edit icons"></i><span class="hide-menu"> Summary </span></a></li>
                                            <li class="sidebar-item"><a href="setting" class="sidebar-link"><i class="fas fa-cogs"></i><span class="hide-menu"> Settings </span></a></li>
                                            <li class="sidebar-item"><a href="notes" class="sidebar-link"><i class="far fa-sticky-note icons"></i><span class="hide-menu"> Notes </span></a></li>
                                            <li class="sidebar-item"><a href="reminder" class="sidebar-link"><i class="fas fa-bell icons"></i><span class="hide-menu"> Reminder </span></a></li>
                                        </ul>
                                    </li> -->
                                    <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link singleLink" href="password_manager" aria-expanded="false"><i class="mdi mdi-view-dashboard"></i><span class="hide-menu">Password Manager</span></a></li>

                                    <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-receipt"></i><span class="hide-menu">Payroll </span></a>
                                        <ul aria-expanded="false" class="collapse  first-level">
                                            <li class="sidebar-item"><a href="master" class="sidebar-link"><i class="fas fa-bell icons"></i><span class="hide-menu"> Master </span></a></li>
                                            <li class="sidebar-item"><a href="attendance" class="sidebar-link"><i class="fas fa-bell icons"></i><span class="hide-menu"> Attendance </span></a></li>
                                            <li class="sidebar-item"><a href="salary" class="sidebar-link"><i class="fas fa-coins icons"></i><span class="hide-menu"> Salary </span></a></li>
                                            <li class="sidebar-item"><a href="exit" class="sidebar-link"><i class="fas fa-bell icons"></i><span class="hide-menu"> Exit </span></a></li>
                                        </ul>
                                    </li>

                                </ul>
                            </li>
                        </ul>
                        <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-receipt"></i><span class="hide-menu">Accounts/Documents </span></a>
                            <ul aria-expanded="false" class="collapse  first-level pl-3">
                                <li class="sidebar-item"><a href="tax_invoice" class="sidebar-link"><i class="mdi mdi-note-outline"></i><span class="hide-menu"> Tax Invoice </span></a></li>
                                <li class="sidebar-item"><a href="retail_invoice" class="sidebar-link"><i class="mdi mdi-note-outline"></i><span class="hide-menu"> Retail Invoice </span></a></li>
                                <li class="sidebar-item"><a href="quotation_note" class="sidebar-link"><i class="mdi mdi-note-outline"></i><span class="hide-menu"> Quotation </span></a></li>
                                <li class="sidebar-item"><a href="credit_note" class="sidebar-link"><i class="mdi mdi-note-outline"></i><span class="hide-menu"> Credit Note </span></a></li>
                                <li class="sidebar-item"><a href="debit_note" class="sidebar-link"><i class="mdi mdi-note-outline"></i><span class="hide-menu"> Debit Note </span></a></li>
                            </ul>
                        </li>
                        <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fas fa-calculator"></i><span class="hide-menu">Report </span></a>
                            <ul aria-expanded="false" class="collapse first-level pl-3">
                                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link singleLink" href="invoice_receipt" aria-expanded="false"><i class="fas fa-rupee-sign"></i><span class="hide-menu">Service Report</span></a></li>
                            </ul>
                        </li>
                        <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fas fa-calculator"></i><span class="hide-menu">Finance Bank </span></a>
                            <ul aria-expanded="false" class="collapse  first-level pl-3">
                                <li class="sidebar-item"> <a class="sidebar-link sidebar-link singleLink" href="advance" aria-expanded="false"><i class="fas fa-coins"></i><span class="hide-menu">Payment</span></a></li>
                                <li class="sidebar-item"> <a class="sidebar-link sidebar-link singleLink" href="service_income" aria-expanded="false"><i class="fas fa-coins"></i><span class="hide-menu">Settlement</span></a></li>
                                <!-- <li class="sidebar-item"> <a class="sidebar-link sidebar-link singleLink" href="service_income" aria-expanded="false"><i class="fas fa-coins"></i><span class="hide-menu">Service settlement</span></a></li> -->
                            </ul>
                        </li>
                        <!--<li class="sidebar-item"><a href="sales" class="sidebar-link"><i class="mdi mdi-receipt"></i><span class="hide-menu"> Trading Station </span></a></li>-->
                        <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fas fa-calculator"></i><span class="hide-menu">Tickets</span></a>
                            <ul aria-expanded="false" class="collapse  first-level pl-3">
                                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link singleLink" href="Client_query" aria-expanded="false"><i class="mdi mdi-view-dashboard"></i><span class="hide-menu">Fresh Chat</span></a></li>
                                <!--<li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link singleLink" href="client_replied_message" aria-expanded="false"><i class="mdi mdi-view-dashboard"></i><span class="hide-menu">Replied Chat</span></a></li>-->
                            </ul>
                        <li>
                    </nav>
                </div>
            </aside>
        <?php } ?>
        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="page-breadcrumb">
                <div class="row">
                    <div class="col-12 d-flex no-block align-items-center">
                        <?php
                        
                        $filename = basename($_SERVER['PHP_SELF'], '.php');
                        //echo $filename;

                        ?>
                        <!--h4 class="page-title">Dashboard</h4-->
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="Dashboard">Home</a></li>
                            <?php
                            if ($filename == "prEmployeeMaster" || $filename == "prEmployeeAdd" || $filename == "prEmployeeUpdate" || $filename == "prEmployeeView") {
                                // echo "<li class='breadcrumb-item active' aria-current='page'>Employee Master</li>";
                                echo "<li class='breadcrumb-item active' aria-current='page'><a href='prEmployeeMaster'>Employee Master</a></li>";
                            }
                            // echo $filename;
                            if ($filename == "prEmployeeAttendance" || $filename == "prEmployee_Attendance_add" || $filename == "prBulkAttendance" || $filename == "prUpdateEmployeeAttendance" || $filename == "prViewEmployeeAttendance") {
                                // echo "<li class='breadcrumb-item active' aria-current='page'>Employee Master</li>";
                                echo "<li class='breadcrumb-item active' aria-current='page'><a href='prEmployeeAttendance'>Employee Attendace</a></li>";
                            }
                            if ($filename == "prEmployeeSalary") {
                                // echo "<li class='breadcrumb-item active' aria-current='page'>Employee Master</li>";
                                echo "<li class='breadcrumb-item active' aria-current='page'><a href='prEmployeeSalary'>Employee Salary</a></li>";
                            }
                            if ($filename == "prSetting" || $filename == "prWeekoff_add" || $filename == "prWeekoff_filter" || $filename == "prUpdate_Weekoff" || $filename == "prView_weekoff") {
                                // echo "<li class='breadcrumb-item active' aria-current='page'>Employee Master</li>";
                                echo "<li class='breadcrumb-item active' aria-current='page'><a href='prSetting'>Settings</a></li>";
                            }
                            if ($filename == "advance") {
                                echo "<li class='breadcrumb-item active' aria-current='page'>Finacial Records</li>";
                                echo "<li class='breadcrumb-item active' aria-current='page'><a href='advance'>Payment Received</a></li>";
                            }
                            if ($filename == "service_income") {
                                echo "<li class='breadcrumb-item active' aria-current='page'>Finacial Records</li>";
                                echo "<li class='breadcrumb-item active' aria-current='page'><a href='service_income'>Service settlement</a></li>";
                            }
                            if ($filename == "service_expense") {
                                echo "<li class='breadcrumb-item active' aria-current='page'>Finacial Records</li>";
                                echo "<li class='breadcrumb-item active' aria-current='page'><a href='service_expense'>Expense</a></li>";
                            }
                            if ($filename == "advocate_setup") {
                                echo "<li class='breadcrumb-item active' aria-current='page'>Advocate</li>";
                                echo "<li class='breadcrumb-item active' aria-current='page'><a href='advocate_setup'>Setup</a></li>";
                            }
                            if ($filename == "advocate_case") {
                                echo "<li class='breadcrumb-item active' aria-current='page'>Advocate</li>";
                                echo "<li class='breadcrumb-item active' aria-current='page'><a href='advocate_case'>Case</a></li>";
                            }
                            if ($filename == "prEmployeeSalary") {
                                // echo "<li class='breadcrumb-item active' aria-current='page'>Employee Master</li>";
                                echo "<li class='breadcrumb-item active' aria-current='page'><a href='showsalarypage'>Employee Salary</a></li>";
                            }
                            if ($filename == "showsalarypage") {
                                // echo "<li class='breadcrumb-item active' aria-current='page'>Employee Master</li>";
                                echo "<li class='breadcrumb-item active' aria-current='page'><a href='prEmployeeSalary'>Add Salary</a></li>";
                            }
                            if ($filename == "utility") {
                                echo "<li class='breadcrumb-item active' aria-current='page'>Finacial Records</li>";
                                echo "<li class='breadcrumb-item active' aria-current='page'><a href='utility'>Utility</a></li>";
                            }
                            if ($filename == "staff_pay_addition") {
                                echo "<li class='breadcrumb-item active' aria-current='page'>Staff Pay Addition</li>";
                                echo "<li class='breadcrumb-item active' aria-current='page'><a href='staff_pay_addition'>Staff Pay Addition</a></li>";
                            }

                            if ($filename == "emp_loans") {
                                echo "<li class='breadcrumb-item active' aria-current='page'>Loans</li>";
                                echo "<li class='breadcrumb-item active' aria-current='page'><a href='emp_loans'>Loans</a></li>";
                            }
                            if ($filename == "emp_salary_settelment") {
                                echo "<li class='breadcrumb-item active' aria-current='page'>Salary Settle</li>";
                                echo "<li class='breadcrumb-item active' aria-current='page'><a href='emp_salary_settelment'>Salary Pending Settle</a></li>";
                            }
                            if ($filename == "service_contra") {
                                echo "<li class='breadcrumb-item active' aria-current='page'>Finacial Records</li>";
                                echo "<li class='breadcrumb-item active' aria-current='page'><a href='service_contra'>Contra Voucher</a></li>";
                            }
                            if ($filename == "finance_report") {
                                echo "<li class='breadcrumb-item active' aria-current='page'>Report</li>";
                                echo "<li class='breadcrumb-item active' aria-current='page'><a href='finance_report'>Bank Report</a></li>";
                            }
                            if ($filename == "company_profile") {
                                echo "<li class='breadcrumb-item active' aria-current='page'><a href='company_profile'>Company Profile</a></li>";
                            }
                            if ($filename == "add_users") {
                                echo "<li class='breadcrumb-item active' aria-current='page'><a href='add_users'>User Management</a></li>";
                            }
                            if ($filename == "manage_dashboard_panel") {
                                echo "<li class='breadcrumb-item active' aria-current='page'><a href='manage_dashboard'>Dashboard Panel</a></li>";
                            }
                            if ($filename == "sendMailPanel") {
                                echo "<li class='breadcrumb-item active' aria-current='page'><a href='sendMailPanel'>Send Mail</a></li>";
                            }
                            if ($filename == "department") {
                                echo "<li class='breadcrumb-item active' aria-current='page'><a href='department'>Department</a></li>";
                            }
                            if ($filename == "designation") {
                                echo "<li class='breadcrumb-item active' aria-current='page'><a href='designation'>Designation</a></li>";
                            }

                            if ($filename == "client_master") {
                                echo "<li class='breadcrumb-item active' aria-current='page'>Master</li>";
                                echo "<li class='breadcrumb-item active' aria-current='page'><a href='client_master'>Recipient Master</a></li>";
                            }
                            if ($filename == "vendor_master") {
                                echo "<li class='breadcrumb-item active' aria-current='page'>Master</li>";
                                echo "<li class='breadcrumb-item active' aria-current='page'><a href='vendor_master'>Supplier Master</a></li>";
                            }
                            if ($filename == "contact_client") {
                                echo "<li class='breadcrumb-item active' aria-current='page'>Pocket Apps</li>";
                                echo "<li class='breadcrumb-item active' aria-current='page'><a href='contact_client'>Contacts</a></li>";
                            }
                            if ($filename == "invoice_receipt") {
                                echo "<li class='breadcrumb-item active' aria-current='page'>Report</li>";
                                echo "<li class='breadcrumb-item active' aria-current='page'><a href='invoice_receipt'>Service Reports</a></li>";
                            }
                            if ($filename == "invoice_payment") {
                                echo "<li class='breadcrumb-item active' aria-current='page'>Report</li>";
                                echo "<li class='breadcrumb-item active' aria-current='page'><a href='invoice_payment'>Payment</a></li>";
                            }
                            if ($filename == "bank_transaction") {
                                echo "<li class='breadcrumb-item active' aria-current='page'>Report</li>";
                                echo "<li class='breadcrumb-item active' aria-current='page'><a href='bank_transaction'>Bank Transaction</a></li>";
                            }
                            /* if ($filename == "gst") {
                                    echo "<li class='breadcrumb-item active' aria-current='page'>Recipient Station</li>";
                                    echo "<li class='breadcrumb-item active' aria-current='page'>Taxation</li>";
                                    echo "<li class='breadcrumb-item active' aria-current='page'><a href='gst'>GST</a></li>";
                                } */
                            if ($filename == "gst_fees") {
                                echo "<li class='breadcrumb-item active' aria-current='page'>Recipient Station</li>";
                                echo "<li class='breadcrumb-item active' aria-current='page'>Taxation</li>";
                                echo "<li class='breadcrumb-item active' aria-current='page'>GST</li>";
                                echo "<li class='breadcrumb-item active' aria-current='page'><a href='gst_fees'>GST Fees</a></li>";
                            }
                            if ($filename == "tax_invoice") {
                                echo "<li class='breadcrumb-item active' aria-current='page'>Document Records</li>";
                                echo "<li class='breadcrumb-item active' aria-current='page'><a href='tax_invoice'>Tax Invoice</a></li>";
                            }
                            if ($filename == "drawee") {
                                echo "<li class='breadcrumb-item active' aria-current='page'>Drawee</li>";
                                echo "<li class='breadcrumb-item active' aria-current='page'><a href='drawee'>Drawee</a></li>";
                            }
                            if ($filename == "retail_invoice") {
                                echo "<li class='breadcrumb-item active' aria-current='page'>Document Records</li>";
                                echo "<li class='breadcrumb-item active' aria-current='page'><a href='retail_invoice'>Retail Invoice</a></li>";
                            }
                            if ($filename == "credit_note") {
                                echo "<li class='breadcrumb-item active' aria-current='page'>Document Records</li>";
                                echo "<li class='breadcrumb-item active' aria-current='page'><a href='credit_note'>Credit Note</a></li>";
                            }
                            if ($filename == "debit_note") {
                                echo "<li class='breadcrumb-item active' aria-current='page'>Document Records</li>";
                                echo "<li class='breadcrumb-item active' aria-current='page'><a href='debit_note'>Debit Note</a></li>";
                            }
                            if ($filename == "purchase_note") {
                                echo "<li class='breadcrumb-item active' aria-current='page'>Document Records</li>";
                                echo "<li class='breadcrumb-item active' aria-current='page'><a href='purchase_note'>Purchase Order</a></li>";
                            }
                            if ($filename == "quotation_note") {
                                echo "<li class='breadcrumb-item active' aria-current='page'>Document Records</li>";
                                echo "<li class='breadcrumb-item active' aria-current='page'><a href='quotation_note'>Quotation</a></li>";
                            }
                            if ($filename == "gst_returns") {
                                echo "<li class='breadcrumb-item active' aria-current='page'>Recipient Station</li>";
                                echo "<li class='breadcrumb-item active' aria-current='page'>Taxation</li>";
                                echo "<li class='breadcrumb-item active' aria-current='page'>GST</li>";
                                echo "<li class='breadcrumb-item active' aria-current='page'><a href='gst_returns'>GST Returns</a></li>";
                            }
                            if ($filename == "it_returns") {
                                echo "<li class='breadcrumb-item active' aria-current='page'>Recipient Station</li>";
                                echo "<li class='breadcrumb-item active' aria-current='page'>Taxation</li>";
                                echo "<li class='breadcrumb-item active' aria-current='page'><a href='it_returns'>IT Returns</a></li>";
                            }
                            if ($filename == "audit") {
                                echo "<li class='breadcrumb-item active' aria-current='page'>Recipient Station</li>";
                                echo "<li class='breadcrumb-item active' aria-current='page'>Taxation</li>";
                                echo "<li class='breadcrumb-item active' aria-current='page'><a href='audit'>Audit</a></li>";
                            }
                            if ($filename == "pan") {
                                echo "<li class='breadcrumb-item active' aria-current='page'>NSDL</li>";
                                echo "<li class='breadcrumb-item active' aria-current='page'><a href='pan'>PAN</a></li>";
                            }
                            if ($filename == "tan") {
                                echo "<li class='breadcrumb-item active' aria-current='page'>NSDL</li>";
                                echo "<li class='breadcrumb-item active' aria-current='page'><a href='tan'>TAN</a></li>";
                            }
                            if ($filename == "e_tds") {
                                echo "<li class='breadcrumb-item active' aria-current='page'>NSDL</li>";
                                echo "<li class='breadcrumb-item active' aria-current='page'><a href='e_tds'>E-TDS</a></li>";
                            }
                            if ($filename == "24g") {
                                echo "<li class='breadcrumb-item active' aria-current='page'>NSDL</li>";
                                echo "<li class='breadcrumb-item active' aria-current='page'><a href='twenty4g'>24G</a></li>";
                            }
                            if ($filename == "dsc_subscriber") {
                                echo "<li class='breadcrumb-item active' aria-current='page'>DSC</li>";
                                echo "<li class='breadcrumb-item active' aria-current='page'><a href='dsc_subscriber'>DSC Applicant</a></li>";
                            }
                            if ($filename == "intell_trademark") {
                                echo "<li class='breadcrumb-item active' aria-current='page'>Trade Mark</li>";
                                echo "<li class='breadcrumb-item active' aria-current='page'><a href='intell_trademark'>Trade mark</a></li>";
                            }
                            if ($filename == "legal_notice") {
                                echo "<li class='breadcrumb-item active' aria-current='page'>Legal Notice</li>";
                                echo "<li class='breadcrumb-item active' aria-current='page'><a href='legal_notice'>Legal Notice</a></li>";
                            }
                            if ($filename == "intell_patent") {
                                echo "<li class='breadcrumb-item active' aria-current='page'>Patent</li>";
                                echo "<li class='breadcrumb-item active' aria-current='page'><a href='intell_patent'>Patent</a></li>";
                            }
                            if ($filename == "intell_copyright") {
                                echo "<li class='breadcrumb-item active' aria-current='page'>Copyright</li>";
                                echo "<li class='breadcrumb-item active' aria-current='page'><a href='intell_copyright'>Copyright</a></li>";
                            }
                            if ($filename == "intell_tradesecret") {
                                echo "<li class='breadcrumb-item active' aria-current='page'>Trade Secret</li>";
                                echo "<li class='breadcrumb-item active' aria-current='page'><a href='intell_tradesecret'>Trade Secret</a></li>";
                            }
                            if ($filename == "industrial_design") {
                                echo "<li class='breadcrumb-item active' aria-current='page'>Industrial Design</li>";
                                echo "<li class='breadcrumb-item active' aria-current='page'><a href='industrial_design'>Industrial Design</a></li>";
                            }
                            if ($filename == "dsc_reseller") {
                                echo "<li class='breadcrumb-item active' aria-current='page'>DSC</li>";
                                echo "<li class='breadcrumb-item active' aria-current='page'><a href='dsc_reseller'>DSC Partner</a></li>";
                            }
                            if ($filename == "dsc_token") {
                                echo "<li class='breadcrumb-item active' aria-current='page'>DSC</li>";
                                echo "<li class='breadcrumb-item active' aria-current='page'><a href='dsc_token'>Token Usage</a></li>";
                            }
                            if ($filename == "token_stock") {
                                echo "<li class='breadcrumb-item active' aria-current='page'>DSC</li>";
                                echo "<li class='breadcrumb-item active' aria-current='page'><a href='token_stock'>Procured Stock</a></li>";
                            }
                            if ($filename == "dsc_stock") {
                                echo "<li class='breadcrumb-item active' aria-current='page'>DSC</li>";
                                echo "<li class='breadcrumb-item active' aria-current='page'><a href='dsc_stock'>DSC Inventory</a></li>";
                            }
                            if ($filename == "exchange") {
                                echo "<li class='breadcrumb-item active' aria-current='page'>DSC</li>";
                                echo "<li class='breadcrumb-item active' aria-current='page'>Inventory</li>";
                                echo "<li class='breadcrumb-item active' aria-current='page'><a href='exchange'>Exchange</a></li>";
                            }
                            if ($filename == "incomes") {
                                echo "<li class='breadcrumb-item active' aria-current='page'>Pocket Accounts</li>";
                                echo "<li class='breadcrumb-item active' aria-current='page'><a href='income'>Income</a></li>";
                            }
                            if ($filename == "expenses") {
                                echo "<li class='breadcrumb-item active' aria-current='page'>Pocket Accounts</li>";
                                echo "<li class='breadcrumb-item active' aria-current='page'><a href='expense'>Expense</a></li>";
                            }
                            if ($filename == "payables") {
                                echo "<li class='breadcrumb-item active' aria-current='page'>Pocket Accounts</li>";
                                echo "<li class='breadcrumb-item active' aria-current='page'><a href='payable'>Payable</a></li>";
                            }
                            if ($filename == "receivables") {
                                echo "<li class='breadcrumb-item active' aria-current='page'>Pocket Accounts</li>";
                                echo "<li class='breadcrumb-item active' aria-current='page'><a href='receivable'>Receivable</a></li>";
                            }
                            if ($filename == "account_reports") {
                                echo "<li class='breadcrumb-item active' aria-current='page'>Pocket Accounts</li>";
                                echo "<li class='breadcrumb-item active' aria-current='page'><a href='account_report'>Account Report</a></li>";
                            }
                            if ($filename == "settings") {
                                echo "<li class='breadcrumb-item active' aria-current='page'>Pocket Accounts</li>";
                                echo "<li class='breadcrumb-item active' aria-current='page'><a href='setting'>Settings</a></li>";
                            }
                            if ($filename == "notes") {
                                echo "<li class='breadcrumb-item active' aria-current='page'>Pocket Accounts</li>";
                                echo "<li class='breadcrumb-item active' aria-current='page'><a href='notes'>Notes</a></li>";
                            }
                            if ($filename == "reminders") {
                                echo "<li class='breadcrumb-item active' aria-current='page'>Pocket Accounts</li>";
                                echo "<li class='breadcrumb-item active' aria-current='page'><a href='reminder'>Reminders</a></li>";
                            }
                            if ($filename == "master") {
                                echo "<li class='breadcrumb-item active' aria-current='page'>Payroll</li>";
                                echo "<li class='breadcrumb-item active' aria-current='page'><a href='master'>Master</a></li>";
                            }
                            if ($filename == "attendance") {
                                echo "<li class='breadcrumb-item active' aria-current='page'>Payroll</li>";
                                echo "<li class='breadcrumb-item active' aria-current='page'><a href='attendance'>Attendance</a></li>";
                            }
                            if ($filename == "salary") {
                                echo "<li class='breadcrumb-item active' aria-current='page'>Payroll</li>";
                                echo "<li class='breadcrumb-item active' aria-current='page'><a href='salary'>Salary</a></li>";
                            }
                            if ($filename == "exit") {
                                echo "<li class='breadcrumb-item active' aria-current='page'>Payroll</li>";
                                echo "<li class='breadcrumb-item active' aria-current='page'><a href='exit'>Exit</a></li>";
                            }
                            if ($filename == "other_services") {
                                echo "<li class='breadcrumb-item active' aria-current='page'><a href='other_services'>Other Services</a></li>";
                            }
                            if ($filename == "servise_received") {
                                echo "<li class='breadcrumb-item active' aria-current='page'><a href='servise_received'>Servise Received</a></li>";
                            }
                            if ($filename == "e_tender") {
                                echo "<li class='breadcrumb-item active' aria-current='page'><a href='e_tender'>E Tender</a></li>";
                            }
                            if ($filename == "inventory") {
                                echo "<li class='breadcrumb-item active' aria-current='page'>Trading Station</li>";
                                echo "<li class='breadcrumb-item active' aria-current='page'>Purchase</li>";
                                echo "<li class='breadcrumb-item active' aria-current='page'><a href='inventory'>Inventory</a></li>";
                            }
                            if ($filename == "procure") {
                                echo "<li class='breadcrumb-item active' aria-current='page'>Trading Station</li>";
                                echo "<li class='breadcrumb-item active' aria-current='page'>Purchase</li>";
                                echo "<li class='breadcrumb-item active' aria-current='page'><a href='procure'>Procure</a></li>";
                            }
                            if ($filename == "supplier_received") {
                                // echo "<li class='breadcrumb-item active' aria-current='page'>Trading Station</li>";
                                // echo "<li class='breadcrumb-item active' aria-current='page'>Purchase</li>";
                                echo "<li class='breadcrumb-item active' aria-current='page'><a href='supplier_received'>Supplier Received</a></li>";
                            }
                            if ($filename == "sales") {
                                echo "<li class='breadcrumb-item active' aria-current='page'>Trading Station</li>";
                                // echo "<li class='breadcrumb-item active' aria-current='page'>Sales</li>";
                                echo "<li class='breadcrumb-item active' aria-current='page'><a href='sales'>Sales</a></li>";
                            }
                            if ($filename == "productList") {
                                echo "<li class='breadcrumb-item active' aria-current='page'><a href='productList'>Product List</a></li>";
                            }
                            if ($filename == "goods_received") {
                                echo "<li class='breadcrumb-item active' aria-current='page'><a href='goods_received'>Goods Received</a></li>";
                            }
                            if ($filename == "client_message") {
                                echo "<li class='breadcrumb-item active' aria-current='page'><a href='client_message'>Messages</a></li>";
                            }
                            if ($filename == "register_company") {
                                echo "<li class='breadcrumb-item active' aria-current='page'><a href='register_company'>Register Company</a></li>";
                            }
                            if ($filename == "services_received") {
                                echo "<li class='breadcrumb-item active' aria-current='page'>Supplier Station</li>";
                                echo "<li class='breadcrumb-item active' aria-current='page'><a href='services_received'>Services Received</a></li>";
                            }
                            if ($filename == "other_transaction") {
                                echo "<li class='breadcrumb-item active' aria-current='page'><a href='other_transaction'>Other Transaction</a></li>";
                            }
                            if ($filename == "psp") {
                                echo "<li class='breadcrumb-item active' aria-current='page'>UTI</li>";
                                echo "<li class='breadcrumb-item active' aria-current='page'><a href='psp'>PSP Coupon Distribution</a></li>";
                            }
                            if ($filename == "coupon_consumption") {
                                echo "<li class='breadcrumb-item active' aria-current='page'>UTI</li>";
                                echo "<li class='breadcrumb-item active' aria-current='page'><a href='psp_coupon_consumption'>PSP Coupon</a></li>";
                            }
                            if ($filename == "password_manager") {
                                echo "<li class='breadcrumb-item active' aria-current='page'>Pocket Apps</li>";
                                echo "<li class='breadcrumb-item active' aria-current='page'><a href='password_manager'>Password Manager</a></li>";
                            }
                            if ($filename == "report") {
                                echo "<li class='breadcrumb-item active' aria-current='page'><a href='report'>Report</a></li>";
                            }
                            if ($filename == "broadcast_Camp") {
                                echo "<li class='breadcrumb-item active' aria-current='page'><a href='broadcast_Camp'>Broadcast Campaign</a></li>";
                            }
                            if ($filename == "ac_Change") {
                                echo "<li class='breadcrumb-item active' aria-current='partner'>CRM Setup</li>";
                                echo "<li class='breadcrumb-item active' aria-current='page'><a href='ac_Change'>Record Transfer</a></li>";
                            }
                            if ($filename == "calling_data") {
                                echo "<li class='breadcrumb-item active' aria-current='partner'>CRM Setup</li>";
                                echo "<li class='breadcrumb-item active' aria-current='page'><a href='calling_data'>Data Record</a></li>";
                            }
                            if ($filename == "CallTitle_DataList") {
                                echo "<li class='breadcrumb-item active' aria-current='partner'>CRM Setup</li>";
                                echo "<li class='breadcrumb-item active' aria-current='page'><a href='calling_data'>Data Record</a></li>";
                                echo "<li class='breadcrumb-item active' aria-current='page'><a href='CallTitle_DataList'>Sheets</a></li>";
                            }
                            if ($filename == "call_Filter") {
                                echo "<li class='breadcrumb-item active' aria-current='page'><a href='call_Filter'>Filter</a></li>";
                            }
                            if ($filename == "crm_dashboard") {
                                echo "<li class='breadcrumb-item active' aria-current='page'><a href='crm_dashboard'>CRM Dashboard</a></li>";
                            }
                            if ($filename == "client_status") {
                                echo "<li class='breadcrumb-item active' aria-current='partner'>Client Configuration</li>";
                                echo "<li class='breadcrumb-item active' aria-current='partner'>Client Status</li>";
                                echo "<li class='breadcrumb-item active' aria-current='partner'><a href='client_status'>Vowel Client Status</a></li>";
                            }
                            if ($filename == "client_service") {
                                echo "<li class='breadcrumb-item active' aria-current='partner'>Client Configuration</li>";
                                echo "<li class='breadcrumb-item active' aria-current='partner'>Client Service</li>";
                                echo "<li class='breadcrumb-item active' aria-current='partner'><a href='client_service'>Vowel Client Service</a></li>";
                            }
                            if ($filename == "job_progress") {
                                echo "<li class='breadcrumb-item active' aria-current='partner'>Job Progress</li>";
                                echo "<li class='breadcrumb-item active' aria-current='partner'><a href='job_progress'>Vowel Job Progress</a></li>";
                            }
                            if ($filename == "mom_filter") {
                                echo "<li class='breadcrumb-item active' aria-current='partner'><a href='mom_filter'>MOM Filter</a></li>";
                            }
                            if ($filename == "client_filter") {
                                echo "<li class='breadcrumb-item active' aria-current='partner'><a href='client_filter'>Trace Contact</a></li>";
                            }
                            if ($filename == "enquiry") {
                                echo "<li class='breadcrumb-item active' aria-current='partner'><a href='enquiry'>Enquiry</a></li>";
                            }
                            if ($filename == "fix_meeting") {
                                echo "<li class='breadcrumb-item active' aria-current='partner'>Pocket Apps</li>";
                                echo "<li class='breadcrumb-item active' aria-current='partner'><a href='fix_meeting'>Fix Meeting</a></li>";
                            }
                            if ($filename == "filter_partner") {
                                echo "<li class='breadcrumb-item active' aria-current='partner'>Associate Configuration</li>";
                                echo "<li class='breadcrumb-item active' aria-current='partner'><a href='partner'>Associate List</a></li>";
                                echo "<li class='breadcrumb-item active' aria-current='partner'><a href='filter_partner'>Asso. Filter</a></li>";
                            }
                            if ($filename == "partner") {
                                echo "<li class='breadcrumb-item active' aria-current='partner'>Associate Configuration</li>";
                                echo "<li class='breadcrumb-item active' aria-current='partner'><a href='partner'>Associate List</a></li>";
                            }
                            if ($filename == "client_partner") {
                                echo "<li class='breadcrumb-item active' aria-current='partner'>Associate Configuration</li>";
                                echo "<li class='breadcrumb-item active' aria-current='partner'><a href='client_partner'>Asso. Client List</a></li>";
                            }
                            if ($filename == "dashboard_bid") {
                                echo "<li class='breadcrumb-item active' aria-current='partner'><a href='dashboard_bid'>Bid Dashboard</a></li>";
                            }
                            if ($filename == "bidding") {
                                echo "<li class='breadcrumb-item active' aria-current='partner'><a href='dashboard_bid'>Bid Dashboard</a></li>";
                                echo "<li class='breadcrumb-item active' aria-current='page'><a href='bidding'>Bidding</a></li>";
                            }
                            if ($filename == "Status_partner") {
                                echo "<li class='breadcrumb-item active' aria-current='partner'>Client Configuration</li>";
                                echo "<li class='breadcrumb-item active' aria-current='partner'>Client Status</li>";
                                echo "<li class='breadcrumb-item active' aria-current='partner'><a href='Status_partner'>Partner Client Status</a></li>";
                            }
                            if ($filename == "service_Partner") {
                                echo "<li class='breadcrumb-item active' aria-current='partner'>Client Configuration</li>";
                                echo "<li class='breadcrumb-item active' aria-current='partner'>Client Service</li>";
                                echo "<li class='breadcrumb-item active' aria-current='partner'><a href='service_Partner'>Partner Client Service</a></li>";
                            }
                            if ($filename == "part_progress") {
                                echo "<li class='breadcrumb-item active' aria-current='partner'>Job Progress</li>";
                                echo "<li class='breadcrumb-item active' aria-current='partner'><a href='part_progress'>Partner Job Progress</a></li>";
                            }
                            ?>
                        </ol>
                        <?php if ($_SESSION['user_type'] == 'system_user') { ?>
                            <div class="ml-auto text-right">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <!--li class="breadcrumb-item"><a href="client_master">Home</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Library</li-->

                                        <?php
                                        if ($filename == "outstanding") {
                                            echo "<button class='btn btn-primary btn-sm mr-1 d-none' id='view_outstandingReportBtn'><i class='fas fa-eye'></i> View Outstanding Report</button>
                                            <form method='post' action='Download_outstanding_data'>
                                            <button type='submit' name='Download_outstanding_data' class='btn btn-secondary btn-sm d-block' id='export_clientMaster'><i class='fas fa-download'></i> Download Outstanding Report</button></form>";
                                        }
                                        if ($filename == "advocate_setup") {
                                            echo "<button class='btn btn-primary btn-sm mr-1 d-none' id='bank_branch_btn'><i class='fa fa-plus'></i> Bank Branch Setup</button>
                                            <button class='btn btn-primary btn-sm mr-1' id='property_discripiton_btn'><i class='fa fa-plus'></i> Product List</button>
                                            <button class='btn btn-primary btn-sm mr-1' id='product_list_btn'><i class='fa fa-plus'></i> Property Discription</button>
                                            <button class='btn btn-primary btn-sm mr-1' id='fees_structure_btn'><i class='fa fa-plus'></i>Fees Structure</button>
                                            <button class='btn btn-primary btn-sm mr-1' id='file_inward_mode_btn'><i class='fa fa-plus'></i> File Inward Mode</button>
                                            <button class='btn btn-primary btn-sm mr-1' id='controlling_branch_btn'><i class='fa fa-plus'></i> Controlling branch</button>
                                            <button class='btn btn-primary btn-sm mr-1' id='status_btn'><i class='fa fa-plus'></i> Status</button>
                                            
                                            ";
                                        }
                                        if ($filename == "advocate_case") {
                                            echo "<button class='btn btn-success btn-sm mr-1' id='add_new_otherService'><i class='fas fa-plus'></i> Add New</button>
                                            <button class='btn btn-primary btn-sm mr-1' id='view_otherServiceClient'><i class='fas fa-users'></i> Analysis Report</button>
                                            ";
                                        }
                                        if ($filename == "client_master") {
                                            echo "
                                            <button type='button' class='btn btn-primary btn-sm mr-1' id='clientApproval_modal_btn' data-toggle='modal' data-target='.clientApproval_modal'>Client Approval</button>
                                            <button class='btn btn-success btn-sm mr-1' id='add_new_clientMaster'><i class='fas fa-plus'></i> Add New Client</button>
                                        <button class='btn btn-info btn-sm mr-1' id='import_clientMaster'><i class='fas fa-file-import'></i> Import</button>
                                        <form method='post' action='Export_client_master'>
                                            <button type='submit' name='Export_client_master' class='btn btn-secondary btn-sm' id='export_clientMaster'><i class='fas fa-file-export'></i> Export</button>
                                        </form>";
                                        }
                                        if ($filename == "vendor_master") {
                                            echo "<button class='btn btn-success btn-sm mr-1' id='add_new_clientMaster'><i class='fas fa-plus'></i> Add New Supplier</button>
                                        <button class='btn btn-info btn-sm mr-1' id='import_vendorMaster'><i class='fas fa-file-import'></i> Import</button>
                                        <form method='post' action='Export_vendor_master'>
                                            <button type='submit' name='Export_vendor_master' class='btn btn-secondary btn-sm' id='export_vendorMaster'><i class='fas fa-file-export'></i> Export</button>
                                        </form>";
                                        }
                                        if ($filename == "contact_client") {
                                            echo "<button class='btn btn-success btn-sm mr-1' id='add_new_contactPerson'><i class='fas fa-plus'></i> Add Client Contact</button>
                                        <form method='post' action='Export_contact_client'>
                                            <button type='submit' name='Export_contact_client' class='btn btn-secondary btn-sm' id='export_clientMaster'><i class='fas fa-file-export'></i> Export</button>
                                        </form>";
                                        }
                                        if ($filename == "finance_report") {
                                            echo "<button class='btn btn-primary btn-sm mr-1 d-none' id='view_outstandingReportBtn'><i class='fas fa-eye'></i> View Outstanding Report</button>
                                            <form method='post' action='Download_outstanding_data'>
                                            <button type='submit' name='Download_outstanding_data' class='btn btn-secondary btn-sm d-none' id='export_clientMaster'><i class='fas fa-download'></i> Download Outstanding Report</button></form>";
                                        }
                                        if ($filename == "bank_transaction") {
                                            echo "<button class='btn btn-success btn-sm mr-1' id='add_new_Payment'><i class='fas fa-plus'></i> Add New Payment</button>
                                        <button class='btn btn-info btn-sm mr-1' id='import_bankTransaction'><i class='fas fa-file-import'></i> Import</button>
                                        <button class='btn btn-primary btn-sm mr-1' id='view_BankTransaction'><i class='fas fa-eye'></i> View Bank Report</button>
                                        <!--form method='post' id='Export_GstForm' action='Export_gst'>
                                            <button type='submit' name='Export_gst' class='btn btn-secondary btn-sm' id='export_gst'><i class='fas fa-file-export'></i> Export</button>
                                        </form-->";
                                        }
                                        if ($filename == "old_gst") {
                                            echo "<button class='btn btn-success btn-sm mr-1' id='add_new_Gst'><i class='fas fa-plus'></i> Add New</button>
                                        <button class='btn btn-info btn-sm mr-1 d-none' id='import_Gst'><i class='fas fa-file-import'></i> Import</button>
                                        <button class='btn btn-primary btn-sm mr-1' id='view_GstClient'><i class='fas fa-users'></i> View Client Details</button>
                                        <form method='post' id='Export_GstForm' action='Export_gst'>
                                            <button type='submit' name='Export_gst' class='btn btn-secondary btn-sm' id='export_gst'><i class='fas fa-file-export'></i> Export</button>
                                        </form>";
                                        }
                                        if ($filename == "gst_fees") {
                                            echo "<button class='btn btn-success btn-sm mr-1' id='add_new_Gst'><i class='fas fa-plus'></i> Add New</button>
                                            <button class='btn btn-info btn-sm mr-1' id='import_Gst'><i class='fas fa-file-import'></i> Import</button>
                                            <button class='btn btn-primary btn-sm mr-1' id='view_GstClient'><i class='fas fa-users'></i> View Client Details</button>
                                            <form method='post' id='Export_GstForm' action='Export_gst_fees'>
                                                <button type='submit' name='Export_gst_fees' class='btn btn-secondary btn-sm' id='export_gst'><i class='fas fa-file-export'></i> Export</button>
                                            </form>";
                                        }
                                        if ($filename == "tax_invoice") {
                                            if($sections == 'document_records'){
                                                echo "<button class='btn btn-primary btn-sm mr-1' id='view_Service'><i class='fa fa-plus'></i> Add (T&Cs)</button>
                                            <button class='btn btn-success btn-sm mr-1' id='add_new_TaxInvoice'><i class='fas fa-plus'></i> Add New</button>
                                            <form method='post' id='Export_TaxInvoiceForm' action='Export_Tax_Invoice'>
                                                <button type='submit' name='Export_Tax_Invoice' class='btn btn-secondary btn-sm' id='export_gst'><i class='fas fa-file-export'></i> Export</button>
                                            </form>";
                                            }
                                            
                                        }


                                        if ($filename == "drawee") {
                                            echo "<button class='btn btn-success btn-sm mr-1' id='add_new_e_tender'><i class='fas fa-plus'></i> Add New</button>";
                                            //  echo "<form method='post' action='activeInactiveExport.php'><button class='btn btn-secondary btn-sm mr-1' id='add_new_TitleData' name='activeInactiveExport'><i class='fas fa-plus'></i> Export</button></form>&nbsp;";
                                        }
                                        if ($filename == "retail_invoice") {
                                            if($sections == 'document_records'){
                                                    echo "<button class='btn btn-primary btn-sm mr-1' id='view_Service'><i class='fa fa-plus'></i> Add (T&Cs)</button>
                                                <button class='btn btn-success btn-sm mr-1' id='add_new_RetailInvoice'><i class='fas fa-plus'></i> Add New</button>
                                                <form method='post' id='Export_RetailInvoiceForm' action='Export_Retail_Invoice'>
                                                    <button type='submit' name='Export_Retail_Invoice' class='btn btn-secondary btn-sm' id='export_gst'><i class='fas fa-file-export'></i> Export</button>
                                                </form>";
                                            }
                                            
                                        }
                                        if ($filename == "credit_note") {
                                            echo "<button class='btn btn-success btn-sm mr-1' id='add_new_CreditNote'><i class='fas fa-plus'></i> Add New</button>
                                            <form method='post' id='Export_CreditNoteForm' action='Export_Credit_Note'>
                                                <button type='submit' name='Export_Credit_Note' class='btn btn-secondary btn-sm' id='export_gst'><i class='fas fa-file-export'></i> Export</button>
                                            </form>";
                                        }
                                        if ($filename == "debit_note") {
                                            echo "<button class='btn btn-success btn-sm mr-1' id='add_new_DebitNote'><i class='fas fa-plus'></i> Add New</button>
                                            <form method='post' id='Export_DebitNoteForm' action='Export_Debit_Note'>
                                                <button type='submit' name='Export_Debit_Note' class='btn btn-secondary btn-sm' id='export_gst'><i class='fas fa-file-export'></i> Export</button>
                                            </form>";
                                        }
                                        if ($filename == "purchase_note") {
                                            echo "<button class='btn btn-primary btn-sm mr-1' id='view_Service'><i class='fa fa-plus'></i> Add (T&Cs)</button>
                                            <button class='btn btn-success btn-sm mr-1' id='add_new_PurchaseNote'><i class='fas fa-plus'></i> Add New</button>
                                            <form method='post' id='Export_PurchaseNoteForm' action='Export_Purchase_Note'>
                                                <button type='submit' name='Export_Purchase_Note' class='btn btn-secondary btn-sm mr-1' id='export_purchase'><i class='fas fa-file-export'></i> Export Purchase Orders</button>
                                            </form>
                                            <form method='post' id='Export_PurchaseNoteForm' action='Export_Purchase_Note'>
                                                <button type='submit' name='Export_Purchase_Note_Products' class='btn btn-secondary btn-sm' id='export_purchaseProducts'><i class='fas fa-file-export'></i> Export Products</button>
                                            </form>";
                                        }
                                        if ($filename == "quotation_note") {
                                            echo "<button class='btn btn-primary btn-sm mr-1' id='view_Service'><i class='fa fa-plus'></i> Add (T&Cs)</button>
                                            <button class='btn btn-success btn-sm mr-1' id='add_new_QuotationNote'><i class='fas fa-plus'></i> Add New</button>
                                            <form method='post' id='Export_QuotationNoteForm' action='Export_Quotation_Note'>
                                                <button type='submit' name='Export_Quotation_Note' class='btn btn-secondary btn-sm mr-1' id='export_quotation'><i class='fas fa-file-export'></i> Export Quotation Notes</button>
                                            </form>
                                            <form method='post' id='Export_QuotationNoteForm' action='Export_Quotation_Note'>
                                                <button type='submit' name='Export_Quotation_Note_Products' class='btn btn-secondary btn-sm' id='export_quotationProducts'><i class='fas fa-file-export'></i> Export Products</button>
                                            </form>";
                                        }
                                        if ($filename == "gst_returns") {
                                            echo "<button class='btn btn-success btn-sm mr-1' id='add_new_Gst'><i class='fas fa-plus'></i> Add New</button>
                                        <button class='btn btn-info btn-sm mr-1 d-none' id='import_Gst'><i class='fas fa-file-import'></i> Import</button>
                                        <button class='btn btn-primary btn-sm mr-1' id='view_GstClient'><i class='fas fa-users'></i> View Client Details</button>
                                        <button class='btn btn-primary btn-sm mr-1' id='view_GstClientBasedStatus'><i class='fas fa-search'></i> View Client Based Status</button>
                                        <button class='btn btn-primary btn-sm mr-1' id='view_GstPeriodBasedStatus'><i class='fas fa-search'></i> View Period Based Status</button>
                                        <form method='post' id='Export_GstForm' action='Export_gst_returns'>
                                            <button type='submit' name='Export_gst_returns' class='btn btn-secondary btn-sm' id='export_gst'><i class='fas fa-file-export'></i> Export</button>
                                        </form>";
                                        }
                                        if ($filename == "it_returns") {
                                            echo "<button class='btn btn-success btn-sm mr-1' id='add_new_itReturns'><i class='fas fa-plus'></i> Add New</button>
                                        <button class='btn btn-info btn-sm mr-1' id='import_itReturns'><i class='fas fa-file-import'></i> Import</button>
                                        <button class='btn btn-primary btn-sm mr-1' id='view_ItReturnsClient'><i class='fas fa-users'></i> View Client Details</button>
                                        <form method='post' id='Export_itReturnForm' action='Export_it_returns'>
                                            <button type='submit' name='Export_it_returns' class='btn btn-secondary btn-sm' id='export_it_returns'><i class='fas fa-file-export'></i> Export</button>
                                        </form>";
                                        }
                                        if ($filename == "audit") {
                                            echo "<button class='btn btn-success btn-sm mr-1' id='add_new_Audit'><i class='fas fa-plus'></i> Add New</button>
                                        <button class='btn btn-info btn-sm mr-1 d-none' id='import_Audit'><i class='fas fa-file-import'></i> Import</button>
                                        <button class='btn btn-primary btn-sm mr-1' id='view_AuditClient'><i class='fas fa-users'></i> View Client Details</button>
                                        <form method='post' id='Export_AuditForm' action='Export_audit'>
                                            <button type='submit' name='Export_audit' class='btn btn-secondary btn-sm' id='export_audit'><i class='fas fa-file-export'></i> Export</button>
                                        </form>";
                                        }
                                        if ($filename == "pan") {
                                            echo "<button class='btn btn-success btn-sm mr-1' id='add_new_Pan'><i class='fas fa-plus'></i> Add New</button>
                                        <button class='btn btn-info btn-sm mr-1' id='import_Pan'><i class='fas fa-file-import'></i> Import</button>
                                        <button class='btn btn-primary btn-sm mr-1' id='view_PanClient'><i class='fas fa-users'></i> View Client Details</button>
                                        <button class='btn btn-primary btn-sm mr-1' id='view_PanStatus'><i class='fas fa-exclamation-circle'></i> View Status</button>
                                        <form method='post' id='Export_PanForm' action='Export_pan'>
                                            <button type='submit' name='Export_pan' class='btn btn-secondary btn-sm' id='export_pan'><i class='fas fa-file-export'></i> Export</button>
                                        </form>";
                                        }
                                        if ($filename == "tan") {
                                            echo "<button class='btn btn-success btn-sm mr-1' id='add_new_Tan'><i class='fas fa-plus'></i> Add New</button>
                                        <button class='btn btn-info btn-sm mr-1' id='import_Tan'><i class='fas fa-file-import'></i> Import</button>
                                        <button class='btn btn-primary btn-sm mr-1' id='view_TanClient'><i class='fas fa-users'></i> View Client Details</button>
                                        <button class='btn btn-primary btn-sm mr-1' id='view_TanStatus'><i class='fas fa-exclamation-circle'></i> View Status</button>
                                        <form method='post' id='Export_TanForm' action='Export_tan'>
                                            <button type='submit' name='Export_tan' class='btn btn-secondary btn-sm' id='export_tan'><i class='fas fa-file-export'></i> Export</button>
                                        </form>";
                                        }
                                        if ($filename == "e_tds") {
                                            echo "<button class='btn btn-success btn-sm mr-1' id='add_new_e_TDS'><i class='fas fa-plus'></i> Add New</button>
                                        <button class='btn btn-info btn-sm mr-1' id='import_e_TDS'><i class='fas fa-file-import'></i> Import</button>
                                        <button class='btn btn-primary btn-sm mr-1' id='view_e_TDSClient'><i class='fas fa-users'></i> View Client Details</button>
                                        <button class='btn btn-primary btn-sm mr-1' id='view_TanStatus'><i class='fas fa-exclamation-circle'></i> View Status</button>
                                        <form method='post' id='Export_ETdsForm' action='Export_e_tds'>
                                            <button type='submit' name='Export_e_tds' class='btn btn-secondary btn-sm' id='export_e_tds'><i class='fas fa-file-export'></i> Export</button>
                                        </form>";
                                        }
                                        if ($filename == "24g") {
                                            echo "<button class='btn btn-success btn-sm mr-1' id='add_new_dscToken'><i class='fas fa-plus'></i> Add New</button>
                                            <button class='btn btn-info btn-sm mr-1' id='import_24g'><i class='fas fa-file-import'></i> Import</button>
                                            <!--button class='btn btn-primary btn-sm mr-1' id='view_e_TDSClient'><i class='fas fa-users'></i> View Client Details</button-->
                                            <form method='post' id='Export_24gForm' action='Export_24G'>
                                                <button type='submit' name='Export_24G' class='btn btn-secondary btn-sm' id='export_24g'><i class='fas fa-file-export'></i> Export</button>
                                            </form>";
                                        }
                                        if ($filename == "dsc_subscriber") {
                                            echo "<button class='btn btn-success btn-sm mr-1' id='add_new_dscSubscriber'><i class='fas fa-plus'></i> Add New</button>
                                        <button class='btn btn-info btn-sm mr-1' id='import_dscSubscriber'><i class='fas fa-file-import'></i> Import</button>
                                        <button class='btn btn-primary btn-sm mr-1' id='view_dscSubscriberClient'><i class='fas fa-users'></i> View Client Details</button>
                                        <button class='btn btn-primary btn-sm mr-1' id='view_dscSubscriberStatus'><i class='fas fa-exclamation-circle'></i> View Status</button>
                                        <form method='post' id='Export_dscSubscriberForm' action='Export_dsc_subscriber'>
                                            <button type='submit' name='Export_dsc_subscriber' class='btn btn-secondary btn-sm' id='export_dsc_subscriber'><i class='fas fa-file-export'></i> Export</button>
                                        </form>";
                                        }
                                        if ($filename == "dsc_reseller") {
                                            echo "<button class='btn btn-success btn-sm mr-1' id='add_new_dscReseller'><i class='fas fa-plus'></i> Add New</button>
                                        <button class='btn btn-info btn-sm mr-1' id='import_dscReseller'><i class='fas fa-file-import'></i> Import</button>
                                        <button class='btn btn-primary btn-sm mr-1' id='view_dscResellerClient'><i class='fas fa-users'></i> View Client Details</button>
                                        <button class='btn btn-primary btn-sm mr-1' id='view_dscResellerStatus'><i class='fas fa-exclamation-circle'></i> View Status</button>
                                        <form method='post' id='Export_dscResellerForm' action='Export_dsc_reseller'>
                                            <button type='submit' name='Export_dsc_reseller' class='btn btn-secondary btn-sm' id='export_dsc_reseller'><i class='fas fa-file-export'></i> Export</button>
                                        </form>";
                                        }
                                        if ($filename == "dsc_token") {
                                            echo "<button class='btn btn-success btn-sm mr-1' id='add_new_dscToken'><i class='fas fa-plus'></i> Add New</button>
                                            <button class='btn btn-info btn-sm mr-1' id='import_dscToken'><i class='fas fa-file-import'></i> Import</button>
                                            <!--button class='btn btn-primary btn-sm mr-1' id='view_dscTokenClient'><i class='fas fa-users'></i> View Client Details</button-->
                                            <button class='btn btn-primary btn-sm mr-1' id='view_dscTokenStatus'><i class='fas fa-exclamation-circle'></i> View Status</button>
                                            <form method='post' id='Export_dscTokenForm' action='Export_Dsc_Token'>
                                                <button type='submit' name='Export_dsc_token' class='btn btn-secondary btn-sm' id='export_dsc_token'><i class='fas fa-file-export'></i> Export</button>
                                            </form>";
                                        }
                                        if ($filename == "token_stock") {
                                            echo "<button class='btn btn-success btn-sm mr-1' id='add_new_dscToken'><i class='fas fa-plus'></i> Add New</button>
                                            <button class='btn btn-primary btn-sm mr-1' id='add_new_Product'><i class='fas fa-plus'></i> Add New Product</button>
                                            <button class='btn btn-primary btn-sm mr-1' id='view_Service'><i class='fa fa-cubes'></i> View Products</button>
                                        <!--button class='btn btn-info btn-sm mr-1' id='import_dscToken'><i class='fas fa-file-import'></i> Import</button>
                                        <button class='btn btn-primary btn-sm mr-1' id='view_dscTokenClient'><i class='fas fa-users'></i> View Client Details</button-->
                                        <form method='post' id='Export_TokenStockForm' action='Export_Token_Stock'>
                                            <button type='submit' name='Export_token_stock' class='btn btn-secondary btn-sm' id='export_token_stock'><i class='fas fa-file-export'></i> Export</button>
                                        </form>";
                                        }
                                        if ($filename == "dsc_stock") {
                                            echo "<button class='btn btn-success btn-sm mr-1' id='add_new_dscToken'><i class='fas fa-plus'></i> Procure DSC</button>
                                            <button class='btn btn-primary btn-sm mr-1' id='add_new_Product'><i class='fas fa-plus'></i> Create New Product</button>
                                            <button class='btn btn-primary btn-sm mr-1' id='view_Service'><i class='fa fa-cubes'></i> View Products</button>
                                            <button class='btn btn-info btn-sm mr-1' id='view_TotalStock'><i class='fa fa-eye'></i> View Procured Stock</button>
                                            <button class='btn btn-primary btn-sm mr-1' id='view_Company'><i class='fa fa-cubes'></i> View DSC Company</button>
                                            <!--button class='btn btn-info btn-sm mr-1' id='exchange'><i class='fa fa-eye'></i> Exchange</button-->
                                        <!--button class='btn btn-info btn-sm mr-1' id='import_dscToken'><i class='fas fa-file-import'></i> Import</button>
                                        <button class='btn btn-primary btn-sm mr-1' id='view_dscTokenClient'><i class='fas fa-users'></i> View Client Details</button-->
                                        <form method='post' id='Export_DscStockForm' action='Export_Dsc_Stock'>
                                            <button type='submit' name='Export_dsc_stock' class='btn btn-secondary btn-sm' id='export_dsc_stock'><i class='fas fa-file-export'></i> Export</button>
                                        </form>";
                                        }
                                        if ($filename == "exchange") {
                                            echo "<button class='btn btn-success btn-sm mr-1' id='add_new_dscToken'><i class='fas fa-plus'></i> Add New</button>
                                            <!--button class='btn btn-primary btn-sm mr-1' id='add_new_Product'><i class='fas fa-plus'></i> Add New Product</button>
                                            <button class='btn btn-primary btn-sm mr-1' id='view_Service'><i class='fa fa-cubes'></i> View Products</button-->
                                            <form method='post' id='Export_DscStockForm' action='Export_Exchange'>
                                                <button type='submit' name='Export_exchange' class='btn btn-secondary btn-sm' id='export_exchange'><i class='fas fa-file-export'></i> Export</button>
                                            </form>";
                                        }
                                        if ($filename == "advance") {
                                            echo "<button class='btn btn-success btn-sm mr-1' id='add_new_dscToken'><i class='fas fa-plus'></i> Add New</button>
                                            <button class='btn btn-primary btn-sm mr-1' id='view_Service'><i class='fa fa-cubes'></i> View Category</button>
                                            <!--button class='btn btn-primary btn-sm mr-1' id='add_new_Product'><i class='fas fa-plus'></i> Add New Product</button>
                                            <button class='btn btn-primary btn-sm mr-1' id='view_Service'><i class='fa fa-cubes'></i> View Products</button-->
                                            <form method='post' id='Export_DscStockForm' action='Export_Advance'>
                                                <button type='submit' name='Export_advance' class='btn btn-secondary btn-sm' id='export_advance'><i class='fas fa-file-export'></i> Export</button>
                                            </form>";
                                        }
                                        if ($filename == "other_services") {
                                            echo "<button class='btn btn-success btn-sm mr-1' id='add_new_otherService'><i class='fas fa-plus'></i> Add New</button>
                                            <button class='btn btn-info btn-sm mr-1' id='import_otherService'><i class='fas fa-file-import'></i> Import</button>
                                            <button class='btn btn-primary btn-sm mr-1' id='view_otherServiceClient'><i class='fas fa-users'></i> View Client Details</button>
                                            <button class='btn btn-primary btn-sm mr-1' id='view_Service'><i class='fa fa-cubes'></i> View Services</button>
                                            <form method='post' id='Export_otherServicesForm' action='Export_other_services'>
                                                <button type='submit' name='Export_other_services' class='btn btn-secondary btn-sm' id='export_other_services'><i class='fas fa-file-export'></i> Export</button>
                                            </form>";
                                        }
                                        if ($filename == "intell_trademark") {
                                            echo "<button class='btn btn-success btn-sm mr-1' id='add_new_otherService'><i class='fas fa-plus'></i> Add New</button>
                                            <button class='btn btn-primary btn-sm mr-1' id='view_PanStatus'><i class='fas fa-exclamation-circle'></i> View Status</button>
                                            <form method='post' id='Export_otherServicesForm' action='Export_Trade_mark'>
                                            	<button type='submit' name='Export_Trade_mark' class='btn btn-secondary btn-sm' id='Export_Trade_mark'><i class='fas fa-file-export'></i> Export</button>
                                            </form>";
                                        }
                                        if ($filename == "ip_utility") {
                                            echo "<button class='btn btn-success btn-sm mr-1' id='add_new_otherService'><i class='fas fa-plus'></i> Add New</button>";
                                        }
                                        if ($filename == "ip_title") {
                                            echo "<button class='btn btn-success btn-sm mr-1' id='add_new_otherService'><i class='fas fa-plus'></i> Add New</button>";
                                        }
                                        if ($filename == "intell_patent") {
                                            echo "<button class='btn btn-success btn-sm mr-1' id='add_new_otherService'><i class='fas fa-plus'></i> Add New</button>
                                            <button class='btn btn-primary btn-sm mr-1' id='view_PanStatus'><i class='fas fa-exclamation-circle'></i> View Status</button>
                                            <form method='post' id='Export_otherServicesForm' action='Export_patent'>
                                            	<button type='submit' name='Export_patent' class='btn btn-secondary btn-sm' id='Export_patent'><i class='fas fa-file-export'></i> Export</button>
                                            </form>
                                            ";
                                        }
                                        if ($filename == "legal_notice") {
                                            echo "<button class='btn btn-success btn-sm mr-1' id='add_new_otherService'><i class='fas fa-plus'></i> Add New</button>
                                            <button class='btn btn-primary btn-sm mr-1' id='view_PanStatus'><i class='fas fa-exclamation-circle'></i> View Status</button>
                                            <form method='post' id='Export_otherServicesForm' action='Export_patent'>
                                            	<button type='submit' name='Export_patent' class='btn btn-secondary btn-sm' id='Export_patent'><i class='fas fa-file-export'></i> Export</button>
                                            </form>
                                            ";
                                        }
                                        if ($filename == "intell_copyright") {
                                            echo "<button class='btn btn-success btn-sm mr-1' id='add_new_otherService'><i class='fas fa-plus'></i> Add New</button>
                                            <button class='btn btn-primary btn-sm mr-1' id='view_PanStatus'><i class='fas fa-exclamation-circle'></i> View Status</button>
                                            <form method='post' id='Export_otherServicesForm' action='Export_copyright'>
                                            	<button type='submit' name='Export_copyright' class='btn btn-secondary btn-sm' id='Export_copyright'><i class='fas fa-file-export'></i> Export</button>
                                            </form>
                                            ";
                                        }
                                        if ($filename == "intell_tradesecret") {
                                            echo "<button class='btn btn-success btn-sm mr-1' id='add_new_otherService'><i class='fas fa-plus'></i> Add New</button>
                                            <button class='btn btn-primary btn-sm mr-1' id='view_PanStatus'><i class='fas fa-exclamation-circle'></i> View Status</button>
                                            <form method='post' id='Export_otherServicesForm' action='Export_tradesecret'>
                                            	<button type='submit' name='Export_tradesecret' class='btn btn-secondary btn-sm' id='Export_tradesecret'><i class='fas fa-file-export'></i> Export</button>
                                            </form>
                                            ";
                                        }
                                        if ($filename == "industrial_design") {
                                            echo "<button class='btn btn-success btn-sm mr-1' id='add_new_otherService'><i class='fas fa-plus'></i> Add New</button>
                                            <button class='btn btn-primary btn-sm mr-1' id='view_PanStatus'><i class='fas fa-exclamation-circle'></i> View Status</button>
                                            <form method='post' id='Export_otherServicesForm' action='Export_industrial_design'>
                                            	<button type='submit' name='Export_industrial_design' class='btn btn-secondary btn-sm' id='Export_industrial_design'><i class='fas fa-file-export'></i> Export</button>
                                            </form>
                                            ";
                                        }
                                        if ($filename == "servise_received") {
                                            echo "<button class='btn btn-success btn-sm mr-1' id='add_new_otherService'><i class='fas fa-plus'></i> Add New</button>
                                            <form method='post' id='Export_otherServicesForm' action='Export_other_services'>
                                                <button type='submit' name='Export_other_services' class='btn btn-secondary btn-sm' id='export_other_services'><i class='fas fa-file-export'></i> Export</button>
                                            </form>";
                                        }
                                        if ($filename == "broadcast_Camp") { ?>
                                            <button class='btn btn-success btn-sm mr-1' onclick="loadPage('create_broadcast_group')" id='add_new_clientMaster'><i class='fas fa-plus'></i> BC Group</button>
                                            <button class='btn btn-success btn-sm mr-1' onclick="loadPage('create_campaign')" id='add_campaignMaster'><i class='fas fa-plus'></i>Campaign</button>
                                        <?php }
                                        if ($filename == "e_tender") {
                                            echo "<button class='btn btn-success btn-sm mr-1' id='add_new_e_tender'><i class='fas fa-plus'></i> Add New</button>
                                            <button type='button' class='btn btn-primary btn-sm mr-1' data-toggle='modal' data-target='#service_modal'>Service Plan</button>
                                           <button type='button' class='btn btn-primary btn-sm mr-1' data-toggle='modal' data-target='#department_modal'>Department</button>
                                            
                                            ";
                                            echo "<form method='post' action='activeInactiveExport.php'><button class='btn btn-secondary btn-sm mr-1' id='add_new_TitleData' name='activeInactiveExport'><i class='fas fa-plus'></i> Export</button></form>&nbsp;";
                                        }
                                        if ($filename == "inventory") {
                                            "<a class='btn btn-success btn-sm mr-1' href='productList'><i class='fas fa-plus'></i> Products</a>
                                            <!--form method='post' id='Export_otherProductsForm' action='Export_other_services'>
                                                <button type='submit' name='Export_other_services' class='btn btn-secondary btn-sm' id='export_other_services'><i class='fas fa-file-export'></i> Export</button>
                                            </form-->";
                                        }
                                        if ($filename == "procure") {
                                            echo "<button class='btn btn-info btn-sm mr-1 d-none' id='View_Procure'><i class='fas fa-eye'></i> View Procure List</button>
                                            <button class='btn btn-success btn-sm mr-1' id='Add_Sales'><i class='fas fa-plus'></i> Add New</button>
                                            <form method='post' id='Export_PurchaseNoteForm' action='Export_Purchase_Note'>
                                                <button type='submit' name='Export_Purchase_Note' class='btn btn-secondary btn-sm mr-1' id='export_purchase'><i class='fas fa-file-export'></i> Export Purchase Orders</button>
                                            </form>
                                            <form method='post' id='Export_PurchaseNoteForm' action='Export_Purchase_Note'>
                                                <button type='submit' name='Export_Purchase_Note_Products' class='btn btn-secondary btn-sm' id='export_purchaseProducts'><i class='fas fa-file-export'></i> Export Products</button>
                                            </form>";
                                        }
                                        if ($filename == "supplier_received") {
                                            echo "<button class='btn btn-info btn-sm mr-1 d-none' id='View_Procure'><i class='fas fa-eye'></i> View Procure List</button>
                                            <button class='btn btn-success btn-sm mr-1' id='Add_Sales'><i class='fas fa-plus'></i> Add New</button>
                                            <form method='post' id='Export_PurchaseNoteForm' action='Export_Purchase_Note'>
                                                <button type='submit' name='Export_Purchase_Note' class='btn btn-secondary btn-sm mr-1' id='export_purchase'><i class='fas fa-file-export'></i> Export Service</button>
                                            </form>
                                            <form method='post' id='Export_PurchaseNoteForm' action='Export_Purchase_Note'>
                                                <button type='submit' name='Export_Purchase_Note_Products' class='btn btn-secondary btn-sm' id='export_purchaseProducts'><i class='fas fa-file-export'></i> Export Goods</button>
                                            </form>";
                                        }
                                        if ($filename == "sales") {
                                            echo "<button class='btn btn-success btn-sm mr-1 d-block' id='Add_Sales'><i class='fas fa-plus'></i> Create Sales</button>
                                            <form method='post' id='Export_sales' action='Export_sales'>
                                                <button type='submit' name='Export_sales' class='btn btn-secondary btn-sm mr-1' id='export_purchase'><i class='fas fa-file-export'></i> Export</button>
                                            </form>
                                            <!--form-- method='post' id='Export_PurchaseNoteForm' action='Export_Purchase_Note'>
                                                <button type='submit' name='Export_Purchase_Note_Products' class='btn btn-secondary btn-sm' id='export_purchaseProducts'><i class='fas fa-file-export'></i> Export Products</button>
                                            </!--form-->";
                                        }
                                        if ($filename == "productList") {
                                            echo "<button class='btn btn-success btn-sm mr-1' id='add_new_otherProduct'><i class='fas fa-plus'></i> Create Product</button>
                                            <button class='btn btn-primary btn-sm mr-1' id='view_Products'><i class='fa fa-cubes'></i> View Products</button>
                                            <button class='btn btn-primary btn-sm mr-1' id='view_Brand'><i class='fa fa-cubes'></i> View Brand</button>
                                            <button class='btn btn-primary btn-sm mr-1' id='view_Units'><i class='fa fa-cubes'></i> View Units</button>
                                            <button class='btn btn-primary btn-sm mr-1' id='view_Packages'><i class='fa fa-cubes'></i> View Packages</button>
                                            <!--form method='post' id='Export_otherProductsForm' action='Export_other_services'>
                                                <button type='submit' name='Export_other_services' class='btn btn-secondary btn-sm' id='export_other_services'><i class='fas fa-file-export'></i> Export</button>
                                            </form-->";
                                        }
                                        if ($filename == "goods_received") {
                                            echo "<button class='btn btn-success btn-sm mr-1' id='add_new_otherProduct'><i class='fas fa-plus'></i> Create Product</button>
                                            <button class='btn btn-primary btn-sm mr-1' id='view_Products'><i class='fa fa-cubes'></i> View Products</button>
                                            <button class='btn btn-primary btn-sm mr-1' id='view_Brand'><i class='fa fa-cubes'></i> View Brand</button>
                                            <button class='btn btn-primary btn-sm mr-1' id='view_Units'><i class='fa fa-cubes'></i> View Units</button>
                                            <button class='btn btn-primary btn-sm mr-1' id='view_Packages'><i class='fa fa-cubes'></i> View Packages</button>
                                            <form method='post' id='Export_otherProductsForm' action='Export_Goods_records'>
                                                <button type='submit' name='Export_Goods_records' class='btn btn-secondary btn-sm' id='export_other_services'><i class='fas fa-file-export'></i> Export</button>
                                            </form>";
                                        }
                                        if ($filename == "register_company") {
                                            //echo "<button class='btn btn-success btn-sm mr-1' id='add_new_otherService'><i class='fas fa-plus'></i> Add New Company</button>";
                                            /*<button class='btn btn-info btn-sm mr-1 d-none' id='import_otherService'><i class='fas fa-file-import'></i> Import</button>
                                        <button class='btn btn-primary btn-sm mr-1' id='view_otherServiceClient'><i class='fas fa-users'></i> View Client Details</button>
                                        <button class='btn btn-primary btn-sm mr-1' id='view_Service'><i class='fa fa-cubes'></i> View Services</button>
                                        <form method='post' id='Export_otherServicesForm' action='Export_other_services'>
                                            <button type='submit' name='Export_other_services' class='btn btn-secondary btn-sm' id='export_other_services'><i class='fas fa-file-export'></i> Export</button>
                                        </form>*/
                                        }
                                        if ($filename == "user_log_data") {
                                            echo "<a href='data_user_log_down' class='btn btn-success btn-sm mr-1' id=''><i class='fas fa-plus'></i> Export Log</a>";
                                        }
                                        if ($filename == "services_received") {
                                            echo "<button class='btn btn-success btn-sm mr-1' id='add_new_otherService'><i class='fas fa-plus'></i> Add New</button>
                                        <button class='btn btn-info btn-sm mr-1 d-none' id='import_otherService'><i class='fas fa-file-import'></i> Import</button>
                                        <button class='btn btn-primary btn-sm mr-1' id='view_otherServiceClient'><i class='fas fa-users'></i> View Client Details</button>
                                        <button class='btn btn-primary btn-sm mr-1' id='view_Service'><i class='fa fa-cubes'></i> View Services</button>
                                        <form method='post' id='Export_otherServicesForm' action='Export_services_received'>
                                            <button type='submit' name='Export_services_received' class='btn btn-secondary btn-sm' id='export_other_services'><i class='fas fa-file-export'></i> Export</button>
                                        </form>";
                                        }
                                        if ($filename == "other_transaction") {
                                            echo "<button class='btn btn-success btn-sm mr-1' id='add_new_OtherTransaction'><i class='fas fa-plus'></i> Add New</button>
                                        <!--button class='btn btn-info btn-sm mr-1' id='import_Tan'><i class='fas fa-file-import'></i> Import</button>
                                        <button class='btn btn-primary btn-sm mr-1' id='view_TanClient'><i class='fas fa-users'></i> View Client Details</button-->
                                        <form method='post' id='Export_OtherTransactionForm' action='Export_other_transaction'>
                                            <button type='submit' name='Export_other_transaction' class='btn btn-secondary btn-sm' id='export_other_transaction'><i class='fas fa-file-export'></i> Export</button>
                                        </form>";
                                        }
                                        if ($filename == "psp") {
                                            echo "<button class='btn btn-success btn-sm mr-1' id='add_new_PSP'><i class='fas fa-plus'></i> Add New</button>
                                        <button class='btn btn-info btn-sm mr-1' id='import_PSP'><i class='fas fa-file-import'></i> Import</button>
                                        <button class='btn btn-primary btn-sm mr-1' id='view_PSPClient'><i class='fas fa-users'></i> View Client Details</button>
                                        <form method='post' id='Export_pspDistributionForm' action='Export_psp_distribution'>
                                            <button type='submit' name='Export_psp_distribution' class='btn btn-secondary btn-sm' id='export_psp_distribution'><i class='fas fa-file-export'></i> Export</button>
                                        </form>";
                                        }
                                        if ($filename == "coupon_consumption") {
                                            echo "<button class='btn btn-success btn-sm mr-1' id='add_new_PSPcouponConsumption'><i class='fas fa-plus'></i> Add New</button>
                                        <button class='btn btn-info btn-sm mr-1' id='import_PSPcouponConsumption'><i class='fas fa-file-import'></i> Import</button>
                                        <button class='btn btn-primary btn-sm mr-1' id='view_PSPcouponConsumptionClient'><i class='fas fa-users'></i> View Client Details</button>
                                        <form method='post' id='Export_pspCunsumptionForm' action='Export_psp_consumption'>
                                            <button type='submit' name='Export_psp_consumption' class='btn btn-secondary btn-sm' id='export_psp_consumption'><i class='fas fa-file-export'></i> Export</button>
                                        </form>";
                                        }
                                        if ($filename == "add_users") {
                                            echo "<button class='btn btn-success btn-sm mr-1' id='add_new_USERS'><i class='fas fa-plus'></i> Add New</button>";

                                            if ($admin == 1) {
                                                // echo "<a href='user_access' class='btn btn-success btn-sm mr-1'>User Access</a>";
                                            }

                                            echo "<button class='btn btn-info btn-sm d-none' id='import_USERS'><i class='fas fa-file-import'></i> Import</button>";
                                        ?>
                                            <!--<div class="FilterClass" id="FilterClass"><form><select name="userStatus" onchange='this.form.submit()'>-->
                                            <!--        <option value="">Select User Status</option>-->
                                            <!--        <option value="active">Active</option>-->
                                            <!--        <option value="inactive">Inactive</option>-->
                                            <!--      </select>-->
                                            <!--      <noscript><input type="submit" value="Submit"></noscript></form></div>-->
                                            <?php
                                        }

                                        if ($filename == "user_access") {
                                            echo "<a href='access_record' class='btn btn-success btn-sm mr-1'>Past User Access</a>";
                                        }
                                        if ($filename == "manage_dashboard_panel") {
                                            echo "<button class='btn btn-success btn-sm mr-1' id='add_new_USERS'><i class='fas fa-plus'></i> Add New</button>
                                        <button class='btn btn-info btn-sm d-none' id='import_USERS'><i class='fas fa-file-import'></i> Import</button>";
                                        }
                                        if ($filename == "sendMailPanel") {
                                            echo "<button class='btn btn-success btn-sm mr-1 d-none' id='add_new_Email'><i class='fas fa-plus'></i> Add New</button>";
                                        }

                                        if ($filename == "incomes") {
                                            echo "<button class='btn btn-success btn-sm mr-1' id='add_new_Income'><i class='fas fa-plus'></i> Add New</button>
                                        <button class='btn btn-info btn-sm d-none' id='import_USERS'><i class='fas fa-file-import'></i> Import</button>
                                        <form method='post' action='Export_income'>
                                            <button type='submit' name='Export_income' class='btn btn-secondary btn-sm' id='export_income'><i class='fas fa-file-export'></i> Export</button>
                                        </form>";
                                        }
                                        if ($filename == "expenses") {
                                            echo "<button class='btn btn-success btn-sm mr-1' id='add_new_Expense'><i class='fas fa-plus'></i> Add New</button>
                                        <button class='btn btn-info btn-sm d-none' id='import_USERS'><i class='fas fa-file-import'></i> Import</button>
                                        <form method='post' action='Export_expense'>
                                            <button type='submit' name='Export_expense' class='btn btn-secondary btn-sm' id='export_expense'><i class='fas fa-file-export'></i> Export</button>
                                        </form>";
                                        }
                                        if ($filename == "payables") {
                                            echo "<button class='btn btn-success btn-sm mr-1' id='add_new_Payable'><i class='fas fa-plus'></i> Add New</button>
                                        <button class='btn btn-info btn-sm d-none' id='import_USERS'><i class='fas fa-file-import'></i> Import</button>
                                        <form method='post' action='Export_payable'>
                                            <button type='submit' name='Export_payable' class='btn btn-secondary btn-sm' id='export_payable'><i class='fas fa-file-export'></i> Export</button>
                                        </form>";
                                        }
                                        if ($filename == "receivables") {
                                            echo "<button class='btn btn-success btn-sm mr-1' id='add_new_Receivable'><i class='fas fa-plus'></i> Add New</button>
                                        <button class='btn btn-info btn-sm d-none' id='import_USERS'><i class='fas fa-file-import'></i> Import</button>
                                        <form method='post' action='Export_receivable'>
                                            <button type='submit' name='Export_receivable' class='btn btn-secondary btn-sm' id='export_receivable'><i class='fas fa-file-export'></i> Export</button>
                                        </form>";
                                        }
                                        if ($filename == "reminders") {
                                            echo "<button class='btn btn-success btn-sm mr-1' id='add_new_Reminder'><i class='fas fa-plus'></i> Add New</button>
                                        <button class='btn btn-info btn-sm d-none' id='import_USERS'><i class='fas fa-file-import'></i> Import</button>
                                        <form method='post' action='Export_reminder'>
                                            <button type='submit' name='Export_reminder' class='btn btn-secondary btn-sm' id='export_reminder'><i class='fas fa-file-export'></i> Export</button>
                                        </form>";
                                        }
                                        if ($filename == "master") {
                                            echo "<button class='btn btn-success btn-sm mr-1' id='add_new_Master'><i class='fas fa-plus'></i> Add New</button>
                                        <button class='btn btn-info btn-sm d-none' id='import_USERS'><i class='fas fa-file-import'></i> Import</button>
                                        <form method='post' class='d-none' action='Export_reminder'>
                                            <button type='submit' name='Export_reminder' class='btn btn-secondary btn-sm' id='export_reminder'><i class='fas fa-file-export'></i> Export</button>
                                        </form>";
                                        }
                                        if ($filename == "attendance") {
                                            echo "<button class='btn btn-success btn-sm mr-1' id='add_new_Attendance'><i class='fas fa-plus'></i> Add New</button>
                                        <button class='btn btn-info btn-sm d-none' id='import_USERS'><i class='fas fa-file-import'></i> Import</button>
                                        <form method='post' class='d-none' action='Export_reminder'>
                                            <button type='submit' name='Export_reminder' class='btn btn-secondary btn-sm' id='export_reminder'><i class='fas fa-file-export'></i> Export</button>
                                        </form>";
                                        }
                                        /*if ($filename == "salary") {
                                            echo "<button class='btn btn-success btn-sm mr-1' id='add_new_Salary'><i class='fas fa-plus'></i> Add New</button>
                                        <button class='btn btn-info btn-sm d-none' id='import_USERS'><i class='fas fa-file-import'></i> Import</button>
                                        <form method='post' class='d-none' action='Export_reminder'>
                                            <button type='submit' name='Export_reminder' class='btn btn-secondary btn-sm' id='export_reminder'><i class='fas fa-file-export'></i> Export</button>
                                        </form>";
                                        }*/
                                        if ($filename == "exit") {
                                            echo "<button class='btn btn-success btn-sm mr-1' id='add_new_Exit'><i class='fas fa-plus'></i> Add New</button>
                                        <button class='btn btn-info btn-sm d-none' id='import_USERS'><i class='fas fa-file-import'></i> Import</button>
                                        <form method='post' class='d-none' action='Export_reminder'>
                                            <button type='submit' name='Export_reminder' class='btn btn-secondary btn-sm' id='export_reminder'><i class='fas fa-file-export'></i> Export</button>
                                        </form>";
                                        }
                                        if ($filename == "password_manager") {
                                            echo "<button class='btn btn-success btn-sm mr-1' id='add_new_passwordManager'><i class='fas fa-plus'></i> Add New</button>
                                            <button class='btn btn-info btn-sm d-none' id='import_USERS'><i class='fas fa-file-import'></i> Import</button>
                                            <button type='button' class='btn btn-primary' data-toggle='modal' data-target='#passwordManagerDepartmentModal'>Department</button>";
                                        }
                                        if ($filename == "report") {
                                            echo "<button class='btn btn-info btn-sm mr-1' id='show_report'><i class='fas fa-eye'></i> Show Suspense Records</button>
                                            <button class='btn btn-info btn-sm d-none' id='import_USERS'><i class='fas fa-file-import'></i> Import</button>";
                                        }

                                        if ($filename == "service_income") {
                                            echo "<button class='btn btn-success btn-sm mr-1' id='add_new_serviceIncome'><i class='fas fa-plus'></i> Add New</button>
                                            <button class='btn btn-info btn-sm mr-1' id='import_serviceIncome'><i class='fas fa-file-import'></i> Import</button>";
                                            if ($_SESSION['admin_status'] == '1') {
                                                // echo "<button class='btn btn-primary btn-sm mr-1' id='view_Service'><i class='fa fa-cubes'></i> View Category</button>";
                                            }
                                            echo "<!--button class='btn btn-primary btn-sm mr-1' id='view_serviceIncomeClient'><i class='fas fa-users'></i> View Client Details</button>
                                            <button class='btn btn-primary btn-sm mr-1' id='view_serviceIncomeStatus'><i class='fas fa-exclamation-circle'></i> View Status</button-->
                                            <form method='post' id='Export_serviceIncomeForm' action='Export_service_income'>
                                                <button type='submit' name='Export_service_income' class='btn btn-secondary btn-sm' id='Export_service_income'><i class='fas fa-file-export'></i> Export</button>
                                            </form>";
                                        }

                                        if ($filename == "service_expense") {
                                            echo "<button class='btn btn-success btn-sm mr-1' id='add_new_serviceExpense'><i class='fas fa-plus'></i> Add New</button>
                                            <button class='btn btn-info btn-sm mr-1' id='import_serviceExpense'><i class='fas fa-file-import'></i> Import</button>";
                                            if ($_SESSION['admin_status'] == '1') {
                                                echo "<button class='btn btn-primary btn-sm mr-1' id='view_Service'><i class='fa fa-cubes'></i> View Category</button>";
                                            }
                                            echo "<!--button class='btn btn-primary btn-sm mr-1' id='view_serviceExpenseClient'><i class='fas fa-users'></i> View Client Details</button>
                                            <button class='btn btn-primary btn-sm mr-1' id='view_serviceExpenseStatus'><i class='fas fa-exclamation-circle'></i> View Status</button-->
                                            <form method='post' id='Export_serviceExpenseForm' action='Export_service_expense'>
                                                <button type='submit' name='Export_service_expense' class='btn btn-secondary btn-sm' id='Export_service_expense'><i class='fas fa-file-export'></i> Export</button>
                                            </form>";
                                        }

                                        if ($filename == "service_contra") {
                                            echo "<button class='btn btn-success btn-sm mr-1' id='add_new_Contra'><i class='fas fa-plus'></i> Add New</button>
                                        <!--button class='btn btn-info btn-sm mr-1' id='import_Contra'><i class='fas fa-file-import'></i> Import</button>
                                        <button class='btn btn-primary btn-sm mr-1' id='view_ContraClient'><i class='fas fa-users'></i> View Client Details</button>
                                        <button class='btn btn-primary btn-sm mr-1' id='view_ContraStatus'><i class='fas fa-exclamation-circle'></i> View Status</button-->
                                        <form method='post' id='Export_ContraForm' action='Export_service_contra'>
                                            <button type='submit' name='Export_service_contra' class='btn btn-secondary btn-sm' id='Export_service_contra'><i class='fas fa-file-export'></i> Export</button>
                                        </form>";
                                        }
                                        if ($filename == "showsalarypage") {
                                            // echo "<li class='breadcrumb-item active' aria-current='page'>Employee Master</li>";prEmployeeSalary
                                            echo "<a href='filter_salary' class='btn btn-success btn-sm'>Filter</a>&nbsp;&nbsp";
                                            echo "<form method='post' id='Export_TanForm' action='Export_salary'>
                                                            <button type='submit' name='Export_salary' class='btn btn-secondary btn-sm' id='export_tan'><i class='fas fa-file-export'></i> Export</button>
                                                        </form>&nbsp;&nbsp";
                                            echo "<a href='prEmployeeSalary' class='btn btn-success btn-sm'>Salaray Slip Generation</a>";
                                        }
                                        if ($filename == "utility") {
                                            echo "<button class='btn btn-success btn-sm mr-1' id='add_new_serviceExpense'><i class='fas fa-plus'></i>  New Utility</button>
                                            ";
                                            if ($_SESSION['admin_status'] == '1') {
                                                echo "<button class='btn btn-primary btn-sm mr-1' id='view_Service'><i class='fa fa-cubes'></i> View Utility Category</button>";
                                            }
                                        }
                                        if ($filename == "staff_pay_addition") {
                                            echo "<button class='btn btn-success btn-sm mr-1' id='add_new_otherService'><i class='fas fa-plus'></i>Add New</button>
                                            ";
                                        }
                                        if ($filename == "emp_salary_settelment") {
                                            echo "<button class='btn btn-success btn-sm mr-1' id='add_new_Pan'><i class='fas fa-plus'></i> Settled Salary</button>
                                        ";
                                        }
                                        if ($filename == "emp_loans") {
                                            echo "<button class='btn btn-success btn-sm mr-1' id='add_new_otherService'><i class='fas fa-plus'></i>New Account</button>
                                                <button class='btn btn-success btn-sm mr-1' id='add_new_otherService1'><i class='fas fa-plus'></i>Set Recovery</button>";
                                        }
                                        if ($filename == "client_message") {
                                            // echo "<button class='btn btn-success btn-sm mr-1' id='add_new_PSP'><i class='fas fa-plus'></i> Add New</button>";
                                        }

                                        if ($filename == "department") {
                                            echo "<button class='btn btn-success btn-sm mr-1' id='add_new_department'><i class='fas fa-plus'></i> Add New</button>";
                                        }
                                        if ($filename == "designation") {
                                            echo "<button class='btn btn-success btn-sm mr-1' id='add_new_designation'><i class='fas fa-plus'></i> Add New</button>";
                                        }

                                        if ($filename == "prEmployeeAdd" || $filename == "prEmployeeUpdate" || $filename == "prEmployeeView") {
                                            echo "<a href='prEmployeeMaster' class='btn btn-success'>View</a>";
                                        }
                                        if ($filename == "prEmployeeMaster") {
                                            echo "<a href='prEmployeeAdd' class='btn btn-success'>Add</a>";
                                        }
                                        if ($filename == "prEmployeeAttendance") {
                                            echo "<a href='prBulkAttendance' class='btn btn-success btn-sm'>Bulk Attendances</a>&nbsp;&nbsp;<a href='prEmployee_Attendance_add' class='btn btn-success btn-sm'>Add</a>";
                                        }
                                        if ($filename == "prUpdateEmployeeAttendance" || $filename == "prViewEmployeeAttendance") {
                                            echo "<a href='prEmployeeAttendance' class='btn btn-success'>View</a>";
                                        }
                                        if ($filename == "prBulkAttendance") {
                                            echo "<a href='prEmployee_Attendance_add' class='btn btn-success btn-sm'><i class='fa fa-arrow-left' aria-hidden='true'></i> Back</a>&nbsp;&nbsp;<a href='prEmployeeAttendance' class='btn btn-success btn-sm'>View</a>";
                                        }
                                        if ($filename == "prEmployeeSalary") {
                                            echo "<button class='btn btn-success btn-sm d-block' id='NewEmployeeSalaryViewBTN'>
                                            <i class='fas fa-filter'></i>Filter Records</button><button class='btn btn-success btn-sm d-none' id='NewEmployeeSalaryAddBTN'>
                                            <i class='fas fa-eye'></i>	
                                            Show Salary</button>";
                                        }
                                        if ($filename == "prSetting") {
                                            echo "<a href='prWeekoff_add' class='btn btn-success mx-1'>Add</a><a href='prWeekoff_filter' class='btn btn-success mx-1'><i class='fas fa-filter'></i> Filter Records</a><button class='btn btn-info btn-sm mx-1' id='import_Settings'><i class='fas fa-file-import'></i> Import</button>";
                                        }
                                        if ($filename == "prWeekoff_add" || $filename == "prView_weekoff" || $filename == "prUpdate_Weekoff") {
                                            echo "<a href='prSetting' class='btn btn-success'>View</a>";
                                        }

                                        if ($filename == "group") {
                                            echo "<a href='GroupForm'><button class='btn btn-success btn-sm mr-1'><i class='fas fa-plus'></i> Create Group</button></a>";
                                            echo "<a href='creategroup'><button class='btn btn-success btn-sm mr-1'><i class='fas fa-plus'></i> Group List</button></a>";
                                        }
                                        if ($filename == "CallTitle_DataList") {
                                            echo "<button class='btn btn-success btn-sm mr-1' id='add_new_TitleData'><i class='fas fa-plus'></i> Add new</button>
                                                <button class='btn btn-success btn-sm mr-1' id='import_dscSubscriber'><i class='fas fa-plus'></i> Import</button>
                                                <form method='post' id='Export_TitleData' action='Export_Title_Data'>
                                                    <button type='submit' name='Export_Title_Data' class='btn btn-secondary btn-sm' id='Export_Title_Data'><i class='fas fa-file-export'></i> Export</button>
                                                </form>";
                                        }
                                        if ($row['type'] == "3") {
                                            if ($filename == "user_dashboard") { ?>
                                                <div class="FilterClass" id="FilterClass">
                                                    <form><select name="myStatus" onchange='this.form.submit()'>
                                                            <option value="0">Select Status:</option>
                                                            <option value="addNew_Status">New</option>
                                                            <option value="addWarm_Status">Warm</option>
                                                            <option value="addInterested_Status">Interested</option>
                                                            <option value="addHot_Status">Hot</option>
                                                            <option value="addClient_Status">Client</option>
                                                            <option value="addRejected_Status">Rejected</option>
                                                        </select>
                                                        <noscript><input type="submit" value="Submit"></noscript>
                                                    </form>
                                                </div>
                                                <!--id="FilterStatus"-->
                                            <?php }
                                        }
                                        if ($filename == "client_status") {
                                            echo "<form method='post' action='activeInactiveExport.php'><button class='btn btn-success btn-sm mr-1' id='add_new_TitleData' name='activeInactiveExport'><i class='fas fa-plus'></i> Export</button></form>&nbsp;";
                                            echo "<form><select name='CurrentStatus' onchange='this.form.submit()' class='btn btn-light btn-sm mr-1' style='height:28px;'>
                                                    <option>Select Status</option>
                                                    <option value='1'>Active</option>
                                                    <option value='0'>InActive</option>
                                                  </select>
                                                  <noscript><input type='submit' value='Submit'></noscript></form>";
                                        }
                                        if ($filename == "client_service") {
                                            echo "<button type='button' class='btn btn-primary btn-sm mr-1' data-toggle='modal' data-target='#service_modal'>Service Plan</button>
                                           <button type='button' class='btn btn-primary btn-sm mr-1' data-toggle='modal' data-target='#department_modal'>Department</button>";
                                        }
                                        if ($filename == "job_progress") {
                                            echo "<button class='btn btn-success btn-sm mr-1' id='generate_report'><i class='fas fa-plus'></i> Report </button>";
                                            echo "<form method='post' action='allCallData_Export.php'><button class='btn btn-success btn-sm mr-1' name='Clientjob_export'><i class='fas fa-plus'></i> Export</button></form>&nbsp;";
                                            echo "<button class='btn btn-success btn-sm mr-1' id='add_new_meeting'><i class='fas fa-plus'></i> Add Job</button>";
                                        }
                                        if ($filename == "enquiry") {
                                            echo "<button class='btn btn-success btn-sm mr-1' id='add_new_meeting'><i class='fas fa-plus'></i> Raise Enquiry</button>
                                           <button class='btn btn-success btn-sm mr-1' id='addService_btn'><i class='fas fa-plus'></i> Add Service</button>";
                                        }
                                        if ($filename == "enquiry") {
                                            echo "<form method='post' action='allCallData_Export.php'><button class='btn btn-success btn-sm mr-1' name='EnquiryData_export'><i class='fas fa-plus'></i> Export</button></form>&nbsp;";
                                        }
                                        if ($filename == "fix_meeting") {
                                            echo "<form method='post' action='allCallData_Export.php'><button class='btn btn-success btn-sm mr-1' name='fixMeeting_export'><i class='fas fa-plus'></i> Export</button></form>&nbsp;";
                                            echo "<button class='btn btn-success btn-sm mr-1' id='add_new_meeting'><i class='fas fa-plus'></i> Add Meeting</button>";
                                        }
                                        if ($filename == "filter_partner") { ?>
                                            <select id="selectpartner" name="status" class="btn btn-light" style="border: 1px solid black;"> Status
                                                <option>Choose Status</option>
                                                <?php
                                                $query = "select * from `calling_partner` group by part_id";
                                                $result = mysqli_query($con, $query);
                                                while ($show = mysqli_fetch_array($result)) {
                                                ?>
                                                    <!--<option value="addNew_Status" class="form-check-label" style="background-color: white;color: black;">New</option>-->
                                                    <option value="<?= $show['part_id']; ?>" class="form-check-label" style="background-color: white;color: black;"><?= $show['partner_name']; ?></option>
                                                <?php } ?>
                                            </select>
                                        <?php }
                                        if ($filename == "partner") {
                                            echo "<button class='btn btn-success btn-sm mr-1' id='add_new_partner'><i class='fas fa-plus'></i> Add Associate</button>
                                            <a href='filter_partner'><button class='btn btn-success btn-sm mr-1'><i class='fas fa-plus'></i> Asso. Filter</button></a>";
                                        }
                                        if ($filename == "client_partner") {
                                            echo "<button class='btn btn-success btn-sm mr-1' id='add_new_client'><i class='fas fa-plus'></i> Add Asso. Client</button>";
                                        }
                                        if ($filename == "bidding") {
                                            echo "<button class='btn btn-success btn-sm mr-1' id='add_bidding'><i class='fas fa-plus'></i> Participate</button>";
                                        }
                                        if ($filename == "dashboard_bid") {
                                            echo "<a href='bidding'><button class='btn btn-success btn-sm mr-1'><i class='fas fa-plus'></i> Bidding</button></a>";
                                        }
                                        if ($filename == "Status_partner") {
                                            echo "<form method='post' action='activeInactiveExport.php'><button class='btn btn-success btn-sm mr-1' id='add_new_partnerData' name='add_new_partnerData'><i class='fas fa-plus'></i> Export</button></form>&nbsp;";
                                            echo "<form><select name='CurrentStatus' onchange='this.form.submit()' class='btn btn-light btn-sm mr-1' style='height:28px;'>
                                                    <option>Select Status</option>
                                                    <option value='1'>Active</option>
                                                    <option value='0'>InActive</option>
                                                  </select>
                                                  <noscript><input type='submit' value='Submit'></noscript></form>";
                                        }
                                        if ($filename == "part_progress") {
                                            echo "<form method='post' action='ExportreportJob_progress.php'><button class='btn btn-success btn-sm mr-1' name='ExportPartnerreportJob_progress'><i class='fas fa-plus'></i> Export Report</button></form>&nbsp;";
                                            echo "<button class='btn btn-success btn-sm mr-1' id='generate_report'><i class='fas fa-plus'></i> Report </button>";
                                            echo "<form method='post' action='allCallData_Export.php'><button class='btn btn-success btn-sm mr-1' name='Partnerjob_export'><i class='fas fa-plus'></i> Export</button></form>&nbsp;";
                                            echo "<button class='btn btn-success btn-sm mr-1' id='add_new_meeting'><i class='fas fa-plus'></i> Add Job</button>";
                                        }
                                        if ($filename == "dashboard") { ?>
                                            <?php if (($row['type'] == 1) || ($row['esp_bank_balance'] == 1)) { ?>
                                                <!--<h5>Bank Balance</h5><br>-->
                                                <div class="row">

                                                    <div class="col">

                                                        <select class="form-control" id="bank_name_fetch">
                                                            <option>Select Bank</option>
                                                            <option>CASH</option>
                                                            <?php
                                                            $query = "SELECT * FROM `company_bank_details` WHERE `company_id` = '" . $_SESSION['company_id'] . "' AND `company_id` = '" . $_SESSION['company_id'] . "'";
                                                            $result = mysqli_query($con, $query);
                                                            while ($show = mysqli_fetch_array($result)) {
                                                            ?>
                                                                <option><?= $show['bank_name']; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                    <div class="col">
                                                        <div class="input-group mb-3">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text" id="basic-addon1">Opening Balance</span>
                                                            </div>
                                                            <input type="text" class="form-control" id="today_bank_balance" placeholder="Rs *************" aria-label="Username" aria-describedby="basic-addon1">
                                                        </div>
                                                    </div>
                                                </div>
                                        <?php }
                                        }
                                        ?>
                                        <button onclick="getCurrentURL()" style="border:none;background:none;">
                                            <!--"http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"-->
                                            <?php
                                            $link = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
                                            $urlquery = "select * from `webpage_pin` where `url_page_link` like ('%$link') and `username` = '" . $_SESSION['email_id'] . "'";
                                            $urlresult = mysqli_query($con, $urlquery);
                                            if (mysqli_num_rows($urlresult) > 0) {
                                            ?>
                                                <i id="pinIcon" style="font-size:2em;" class="fa-solid fa-link-slash"></i>
                                            <?php } else { ?>
                                                <i id="pinIcon" style="font-size:2em;" class="fa-solid fa-link"></i>
                                            <?php } ?>
                                        </button>
                                    </ol>
                                </nav>
                            </div>
                        <?php } else { ?>
                            <div class="ml-auto text-right">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <?php
                                        if ($filename == "gst_fees") {
                                            echo "
                                                <form method='post' id='Export_GstForm' action='Export_gst_fees'>
                                                    <button type='submit' name='Export_gst_fees' class='btn btn-secondary btn-sm' id='export_gst'><i class='fas fa-file-export'></i> Export</button>
                                                </form>";
                                        }
                                        if ($filename == "gst_returns") {
                                            echo "
                                                <form method='post' id='Export_GstForm' action='Export_gst_returns'>
                                                    <button type='submit' name='Export_gst_returns' class='btn btn-secondary btn-sm' id='export_gst'><i class='fas fa-file-export'></i> Export</button>
                                                </form>";
                                        }
                                        if ($filename == "it_returns") {
                                            echo "
                                                <form method='post' id='Export_itReturnForm' action='Export_it_returns'>
                                                    <button type='submit' name='Export_it_returns' class='btn btn-secondary btn-sm' id='export_it_returns'><i class='fas fa-file-export'></i> Export</button>
                                                </form>";
                                        }
                                        if ($filename == "pan") {
                                            echo "
                                                <form method='post' id='Export_PanForm' action='Export_pan'>
                                                    <button type='submit' name='Export_pan' class='btn btn-secondary btn-sm' id='export_pan'><i class='fas fa-file-export'></i> Export</button>
                                                </form>";
                                        }
                                        if ($filename == "tan") {
                                            echo "
                                                <form method='post' id='Export_TanForm' action='Export_tan'>
                                                    <button type='submit' name='Export_tan' class='btn btn-secondary btn-sm' id='export_tan'><i class='fas fa-file-export'></i> Export</button>
                                                </form>";
                                        }
                                        if ($filename == "e_tds") {
                                            echo "
                                                <form method='post' id='Export_ETdsForm' action='Export_e_tds'>
                                                    <button type='submit' name='Export_e_tds' class='btn btn-secondary btn-sm' id='export_e_tds'><i class='fas fa-file-export'></i> Export</button>
                                                </form>";
                                        }
                                        if ($filename == "24g") {
                                            echo "
                                                <form method='post' id='Export_24gForm' action='Export_24G'>
                                                        <button type='submit' name='Export_24G' class='btn btn-secondary btn-sm' id='export_24g'><i class='fas fa-file-export'></i> Export</button>
                                                    </form>";
                                        }
                                        if ($filename == "psp") {
                                            echo "
                                                <form method='post' id='Export_pspDistributionForm' action='Export_psp_distribution'>
                                                    <button type='submit' name='Export_psp_distribution' class='btn btn-secondary btn-sm' id='export_psp_distribution'><i class='fas fa-file-export'></i> Export</button>
                                                </form>";
                                        }
                                        if ($filename == "dsc_subscriber") {
                                            echo "
                                                <form method='post' id='Export_dscSubscriberForm' action='Export_dsc_subscriber'>
                                                <button type='submit' name='Export_dsc_subscriber' class='btn btn-secondary btn-sm' id='export_dsc_subscriber'><i class='fas fa-file-export'></i> Export</button>
                                            </form>";
                                        }
                                        if ($filename == "intell_trademark") {
                                            echo "
                                                <form method='post' id='Export_otherServicesForm' action='Export_Trade_mark'>
                                            	<button type='submit' name='Export_Trade_mark' class='btn btn-secondary btn-sm' id='Export_Trade_mark'><i class='fas fa-file-export'></i> Export</button>
                                            </form>";
                                        }
                                        if ($filename == "intell_patent") {
                                            echo "
                                                <form method='post' id='Export_otherServicesForm' action='Export_patent'>
                                            	<button type='submit' name='Export_patent' class='btn btn-secondary btn-sm' id='Export_patent'><i class='fas fa-file-export'></i> Export</button>
                                            </form>";
                                        }
                                        if ($filename == "intell_tradesecret") {
                                            echo "
                                                <form method='post' id='Export_otherServicesForm' action='Export_tradesecret'>
                                            	<button type='submit' name='Export_tradesecret' class='btn btn-secondary btn-sm' id='Export_tradesecret'><i class='fas fa-file-export'></i> Export</button>
                                            </form>";
                                        }
                                        if ($filename == "industrial_design") {
                                            echo "
                                                <form method='post' id='Export_otherServicesForm' action='Export_industrial_design'>
                                            	<button type='submit' name='Export_industrial_design' class='btn btn-secondary btn-sm' id='Export_industrial_design'><i class='fas fa-file-export'></i> Export</button>
                                            </form>";
                                        }
                                        if ($filename == "intell_copyright") {
                                            echo "
                                                <form method='post' id='Export_otherServicesForm' action='Export_copyright'>
                                            	<button type='submit' name='Export_copyright' class='btn btn-secondary btn-sm' id='Export_copyright'><i class='fas fa-file-export'></i> Export</button>
                                            </form>";
                                        }


                                        if ($filename == "dsc_reseller") {
                                            echo "
                                                <form method='post' id='Export_dscResellerForm' action='Export_dsc_reseller'>
                                                <button type='submit' name='Export_dsc_reseller' class='btn btn-secondary btn-sm' id='export_dsc_reseller'><i class='fas fa-file-export'></i> Export</button>
                                            </form>";
                                        }
                                        if ($filename == "dsc_token") {
                                            echo "
                                                <form method='post' id='Export_dscTokenForm' action='Export_Dsc_Token'>
                                                    <button type='submit' name='Export_dsc_token' class='btn btn-secondary btn-sm' id='export_dsc_token'><i class='fas fa-file-export'></i> Export</button>
                                                </form>";
                                        }
                                        if ($filename == "other_services") {
                                            echo "
                                                <form method='post' id='Export_otherServicesForm' action='Export_other_services'>
                                                    <button type='submit' name='Export_other_services' class='btn btn-secondary btn-sm' id='export_other_services'><i class='fas fa-file-export'></i> Export</button>
                                                </form>";
                                        }
                                        if ($filename == "client_message") {
                                            echo "<button class='btn btn-success btn-sm mr-1' id='add_new_PSP'><i class='fas fa-plus'></i> Add New</button>";
                                        }

                                        ?>
                                    </ol>
                                </nav>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- End Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Sales Cards  -->
                <!-- ============================================================== -->

                <!-- ============================================================== -->
                <!-- Sales chart -->
                <!-- ============================================================== -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-md-flex align-items-center">
                                    <div>
                                        <!--h4 class="card-title">Site Analysis</h4>
                                        <h5 class="card-subtitle">Overview of Latest Month</h5-->
                                    </div>
                                </div>
                                <div class="row">
                                    <!-- column -->
                                    <!--div class="col-lg-9">
                                        <div class="flot-chart">
                                            <div class="flot-chart-content" id="flot-line-chart"></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="bg-dark p-10 text-white text-center">
                                                   <i class="fa fa-user m-b-5 font-16"></i>
                                                   <h5 class="m-b-0 m-t-5">2540</h5>
                                                   <small class="font-light">Total Users</small>
                                                </div>
                                            </div>
                                             <div class="col-6">
                                                <div class="bg-dark p-10 text-white text-center">
                                                   <i class="fa fa-plus m-b-5 font-16"></i>
                                                   <h5 class="m-b-0 m-t-5">120</h5>
                                                   <small class="font-light">New Users</small>
                                                </div>
                                            </div>
                                            <div class="col-6 m-t-15">
                                                <div class="bg-dark p-10 text-white text-center">
                                                   <i class="fa fa-cart-plus m-b-5 font-16"></i>
                                                   <h5 class="m-b-0 m-t-5">656</h5>
                                                   <small class="font-light">Total Shop</small>
                                                </div>
                                            </div>
                                             <div class="col-6 m-t-15">
                                                <div class="bg-dark p-10 text-white text-center">
                                                   <i class="fa fa-tag m-b-5 font-16"></i>
                                                   <h5 class="m-b-0 m-t-5">9540</h5>
                                                   <small class="font-light">Total Orders</small>
                                                </div>
                                            </div>
                                            <div class="col-6 m-t-15">
                                                <div class="bg-dark p-10 text-white text-center">
                                                   <i class="fa fa-table m-b-5 font-16"></i>
                                                   <h5 class="m-b-0 m-t-5">100</h5>
                                                   <small class="font-light">Pending Orders</small>
                                                </div>
                                            </div>
                                            <div class="col-6 m-t-15">
                                                <div class="bg-dark p-10 text-white text-center">
                                                   <i class="fa fa-globe m-b-5 font-16"></i>
                                                   <h5 class="m-b-0 m-t-5">8540</h5>
                                                   <small class="font-light">Online Orders</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div-->
                                    <!-- column -->
                                    <div class="modal fade" id="confirm_modal" role='dialog'>
                                        <div class="modal-dialog modal-md" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Confirmation</h5>
                                                </div>
                                                <div class="modal-body">
                                                    <div id="delete_content"></div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-primary" id='confirm' onclick="">Continue</button>
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal fade" id="uni_modal" role='dialog'>
                                        <div class="modal-dialog modal-md" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title"></h5>
                                                </div>
                                                <div class="modal-body">
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-primary" id='submit' onclick="$('#uni_modal form').submit()">Save</button>
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal fade" id="uni_modal_right" role='dialog'>
                                        <div class="modal-dialog modal-full-height  modal-md" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title"></h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span class="fa fa-arrow-right"></span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal fade" id="viewer_modal" role='dialog'>
                                        <div class="modal-dialog modal-md" role="document">
                                            <div class="modal-content">
                                                <button type="button" class="btn-close" data-dismiss="modal"><span class="fa fa-times"></span></button>
                                                <img src="" alt="">
                                            </div>
                                        </div>
                                    </div>
                                    <?php //include_once 'footer.php'; 
                                    ?>
                                    <script type="text/javascript">
                                        $(document).ready(function() {
                                            var header = document.getElementById("pageHeading");
                                            if (header) {
                                                var sticky = header.offsetTop;

                                                window.onscroll = function() {
                                                    myFunction();
                                                };

                                                function myFunction() {
                                                    if (window.pageYOffset > sticky) {
                                                        header.classList.add("sticky");
                                                        $("#after-heading").addClass("after-heading");
                                                    } else {
                                                        header.classList.remove("sticky");
                                                        $("#after-heading").removeClass("after-heading");
                                                    }
                                                }
                                            } else {
                                                console.warn("Element with ID 'pageHeading' not found.");
                                            }

                                            $(".closeAlert").click(function() {
                                                $("#updateSuccessDIV").removeClass("d-block").addClass("d-none");
                                                $("#insertSuccessDIV").removeClass("d-block").addClass("d-none");
                                                $("#deleteSuccessDIV").removeClass("d-block").addClass("d-none");
                                            });

                                            $(".readonly").keydown(function(e) {
                                                e.preventDefault();
                                            });
                                        });

                                        function getCurrentURL() {
                                            var currentURL = window.location.href;
                                            var parts = currentURL.split("/");
                                            var desiredPart = parts[parts.length - 1];
                                            var username = "<?php echo $_SESSION['email_id']; ?>";
                                            $.ajax({
                                                method: "post",
                                                url: 'html/verifyPinProcess.php',
                                                data: {
                                                    currentURL: currentURL,
                                                    desiredPart: desiredPart,
                                                    username: username,
                                                },
                                                success: function(data) {
                                                    var pinIcon = document.getElementById("pinIcon");
                                                    if (data == "Successfully Pin") {
                                                        pinIcon.className = "fa-solid fa-link-slash";
                                                    } else {
                                                        pinIcon.className = "fa-solid fa-link";
                                                    }
                                                }
                                            });
                                        }

                                        function getPinnedItems() {
                                            var fetch_items = true;
                                            $.ajax({
                                                method: "post",
                                                url: 'html/verifyPinProcess.php',
                                                data: {
                                                    fetch_items,
                                                },
                                                success: function(data) {
                                                    $('#showPinnedItems_here').html(data);
                                                    //  alert(data);
                                                }
                                            });
                                        }
                                    </script>
                                    <script src="//cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>