<?php
  session_start();
  include_once 'connection.php';
  include_once 'mailFunction.php';
  if (!isset($_SESSION['username'])) {
    header("Location: login");
    exit();
  }
  if (isset($_SESSION['company_id'])) {
    $fetch_user_data = "SELECT * FROM `users` WHERE `company_id` = '".$_SESSION['company_id']."' AND `id` = '".$_SESSION['user_id']."'";
    $run_fetch_user_data = mysqli_query($con,$fetch_user_data);
    $userrow = mysqli_fetch_array($run_fetch_user_data);
  }
  $_SESSION['fullname'] = $userrow['firstname']." ".$userrow['middlename'];
  $_SESSION['email_id'] = $userrow['username'];
    $fetch_email_id = "SELECT * FROM `email_panel` WHERE `company_id` = '".$_SESSION['company_id']."'";
    $run_email_id = mysqli_query($con,$fetch_email_id);
    $email_rows = mysqli_num_rows($run_email_id);
    if ($email_rows > 0) {
        $getting = mysqli_fetch_array($run_email_id);
        $_SESSION['EmailFromPanel'] = $getting['emailId'];
        // $_SESSION['EmailSignatureFromPanel'] = '<span style="color: rgb(255, 0, 0); font-family: Arial, Helvetica, sans-serif; font-size: small;">Vowel Enterprise</span><br style="color: rgb(255, 0, 0); font-family: Arial, Helvetica, sans-serif; font-size: small;"><span style="color: rgb(255, 0, 0); font-family: Arial, Helvetica, sans-serif; font-size: small;">A-1, 1st Floor,</span><br style="color: rgb(255, 0, 0); font-family: Arial, Helvetica, sans-serif; font-size: small;"><span style="color: rgb(255, 0, 0); font-family: Arial, Helvetica, sans-serif; font-size: small;">Asharam Complex,</span><br style="color: rgb(255, 0, 0); font-family: Arial, Helvetica, sans-serif; font-size: small;"><span style="color: rgb(255, 0, 0); font-family: Arial, Helvetica, sans-serif; font-size: small;">Above Umiya Motor Driving School,</span><br style="color: rgb(255, 0, 0); font-family: Arial, Helvetica, sans-serif; font-size: small;"><span style="color: rgb(255, 0, 0); font-family: Arial, Helvetica, sans-serif; font-size: small;">Opp. K C tea stall, Hatkeshwar circle,</span><br style="color: rgb(255, 0, 0); font-family: Arial, Helvetica, sans-serif; font-size: small;"><span style="color: rgb(255, 0, 0); font-family: Arial, Helvetica, sans-serif; font-size: small;">Hatkeswar, Ahmedabad-380026, Gujarat</span><br style="color: rgb(255, 0, 0); font-family: Arial, Helvetica, sans-serif; font-size: small;"><span style="color: rgb(255, 0, 0); font-family: Arial, Helvetica, sans-serif; font-size: small;">Web- </span><a href="https://vowelindia.com/" target="_blank" data-saferedirecturl="https://www.google.com/url?q=https://vowelindia.com&source=gmail&ust=1648124850972000&usg=AOvVaw2maiEG9mJe2HIzeqQCm2HW" style="color: rgb(17, 85, 204); font-family: Arial, Helvetica, sans-serif; font-size: small; background-color: rgb(255, 255, 255);">https://vowelindia.com</a><span style="color: rgb(255, 0, 0); font-family: Arial, Helvetica, sans-serif; font-size: small;"></span><br style="color: rgb(255, 0, 0); font-family: Arial, Helvetica, sans-serif; font-size: small;"><span style="color: rgb(255, 0, 0); font-family: Arial, Helvetica, sans-serif; font-size: small;">E-mail id:- </span><a href="mailto:vowel.dsc@gmail.com" target="_blank" style="color: rgb(17, 85, 204); font-family: Arial, Helvetica, sans-serif; font-size: small; background-color: rgb(255, 255, 255);">vowel.dsc@gmail.com</a><span style="color: rgb(255, 0, 0); font-family: Arial, Helvetica, sans-serif; font-size: small;">, </span><a href="mailto:contact@vowelindia.com" target="_blank" style="color: rgb(17, 85, 204); font-family: Arial, Helvetica, sans-serif; font-size: small; background-color: rgb(255, 255, 255);">contact@vowelindia.com</a><span style="color: rgb(255, 0, 0); font-family: Arial, Helvetica, sans-serif; font-size: small;"></span><br style="color: rgb(255, 0, 0); font-family: Arial, Helvetica, sans-serif; font-size: small;"><span style="color: rgb(255, 0, 0); font-family: Arial, Helvetica, sans-serif; font-size: small;">Land Line:- 079 2272 1172</span><br style="color: rgb(255, 0, 0); font-family: Arial, Helvetica, sans-serif; font-size: small;"><span style="color: rgb(255, 0, 0); font-family: Arial, Helvetica, sans-serif; font-size: small;">Mo:- 9898186349, 9106448443<br></span>';
        $_SESSION['EmailSignatureFromPanel'] = $getting['email_signature'];
    }else{
        $_SESSION['EmailFromPanel'] = "null";
        $_SESSION['EmailSignatureFromPanel'] = "null";
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
    <link rel="stylesheet" href="tm_assets/dist/css/adminlte.min.css">
    <!-- Custom CSS -->
    <link href="dist/css/style.min.css" rel="stylesheet">
    <!-- CSS For Pre-loading -->
    <!-- <link href="dist/css/preloading.css" rel="stylesheet">
    <script src="dist/js/preloading.js"></script> -->
    
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> -->

    <link rel="stylesheet" href="dist/notifications.css">
    <script src="dist/notifications.js"></script>

    <!-- <link rel="stylesheet" href="tm_assets/dist/css/styles.css"> -->
    <!-- <script src="tm_assets/plugins/jquery/jquery.min.js"></script> -->

    <!-- Style of Task Manager -->
    <!-- Select2 -->
    <link rel="stylesheet" href="tm_assets/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="tm_assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="tm_assets/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <!-- Toastr -->
    <link rel="stylesheet" href="tm_assets/plugins/toastr/toastr.min.css">
    <!-- dropzonejs -->
    <link rel="stylesheet" href="tm_assets/plugins/dropzone/min/dropzone.min.css">
    <!-- DateTimePicker -->
    <link rel="stylesheet" href="tm_assets/dist/css/jquery.datetimepicker.min.css">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="tm_assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Switch Toggle -->
    <link rel="stylesheet" href="tm_assets/plugins/bootstrap4-toggle/css/bootstrap4-toggle.min.css">
    <!-- summernote -->
    <link rel="stylesheet" href="tm_assets/plugins/summernote/summernote-bs4.min.css">
     <!-- DataTables -->
    <link rel="stylesheet" href="tm_assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="tm_assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="tm_assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

    <link href="dist/css/select2.min.css" rel="stylesheet">
    <script src="dist/js/select2.min.js"></script>
<!--script src="https://use.fontawesome.com/05ccf72100.js"></script-->

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
<style type="text/css">
    body{
      background: #8C8C8C; //#adb5bb;
      color: #000;
      //font-family: Comic Sans MS bold;
      //font-size: 13px;
      position: relative;
      padding-bottom: 56px;
      min-height: 100vh;
      font-family: 'open sans', sans-serif;
    }
    .btn-vowel{
        background: #27a9e3;
        color: #FFF;
    }
    .btn-vowel:hover{
        background: #FFF;
        color: #27a9e3;
        border-color: #27a9e3;
    }
    .btn-vowel:disabled:hover{
        cursor: not-allowed;
        background: #FFF;
        color: #27a9e3;
    }
    .bg-vowel{
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
    .btn-secondary:hover{
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
    input[type="text"]:disabled:hover, input[type="number"]:disabled:hover, input[type="submit"]:disabled:hover, input[type="email"]:disabled:hover, input[type="checkbox"]:disabled:hover {
        //background: #dddddd;
        cursor: not-allowed;
    }
    /* , input[type="submit"]:read-only:hover */
    /* , input[type="checkbox"]:read-only:hover */
    input[type="text"]:read-only:hover, input[type="number"]:read-only:hover, input[type="email"]:read-only:hover {
        //background: #dddddd;
        cursor: not-allowed;
    }
    .left-menu {
        //height: 100%;
        min-height:100vh;
        position: fixed;
        overflow-y: scroll;
    }
    .table thead th{
        font-weight: bold;
    }
    button:hover{
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
        background-color: #72C7EC;//#e36127;
        color: #FFF;
        font-weight: bold;
        //content: "-->";
        //font-family: Font Awesome 5 Free;
    }
    .sidebar-nav ul .sidebar-item.selected>.sidebar-link{
        background:#27a9e3;
        //background: #E36127; //a9e327
        opacity:1;
    }
    .sidebar-nav ul .sidebar-item ul .sidebar-link{
        background: #FFF;
        color: #000;
        //opacity: 1;
    }
    .sidebar-nav ul .sidebar-item ul .sidebar-link .mdi, .sidebar-nav ul .sidebar-item ul .sidebar-link .fas, .sidebar-nav ul .sidebar-item ul .sidebar-link .far{
        color: #000;
    }

    .sidebar-nav ul .sidebar-item ul .sidebar-link.active .mdi, .sidebar-nav ul .sidebar-item ul .sidebar-link.active .fas, .sidebar-nav ul .sidebar-item ul .sidebar-link.active .far{
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
    #ViewModal_body{
        height: 480px;
        overflow-y: scroll;
    }

    /*Sticky Heading*/
    .pageHeading {
      padding: 10px 16px;
      background: #FFF;
      //color: #f1f1f1;
      z-index: 5000;
      align-self: center;
    }
    .sticky {
      position: fixed;
      top: 64px;
      width: 77%;
      //max-width: 100%;
      //color: #f1f1f1;
      z-index: 1;
      align-self: center;
      //border: 1px solid red;
    }
    .after-heading{
        margin-top:65px;
        align-self: center;
    }
    .showDataTable{
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
        width: 25px; // just wide enough to show mic icon
        height: 25px; // just high enough to show mic icon
        cursor:pointer;
        border: none;
        position: absolute;
        margin-left: 5px;
        outline: none;
        background: transparent;
    }
    .modal-header .logo{
        //border: 1px solid red;
        width: 160px !important; //70px
        height: 80px !important;
        //min-height: 1% !important;
    }
    
    .preloader{
        width:100%;
        height:100%;
        top:0px;
        position:fixed;
        z-index:99999;
        background:#fff;
        animation: pulse 5s infinite;
    }
    .lds-ripple{
        display:inline-block;
        position:relative;
        /* width:64px; */
        width: 100%;
        height:64px;
        position:absolute;
        top: 0px;
        left: 0px;
        /* top:calc(50% - 3.5px); */
        /* left:calc(50% - 3.5px) */
    }
    .lds-ripple .lds-pos{
        position:absolute;
        border:2px solid #2962FF;
        opacity:1;
        border-radius:50%;
        -webkit-animation:lds-ripple 1s cubic-bezier(0, 0.1, 0.5, 1) infinite;
        animation:lds-ripple 1s cubic-bezier(0, 0.1, 0.5, 1) infinite
    }
    .lds-ripple .lds-pos:nth-child(2){
        -webkit-animation-delay:-0.5s;
        animation-delay:-0.5s
    }
    @-webkit-keyframes lds-ripple{
        0%{
            top:28px;
            left:28px;
            width:0;
            height:0;
            opacity:0
        }5%{
            top:28px;
            left:28px;
            width:0;
            height:0;
            opacity:1
        }to{
            top:-1px;
            left:-1px;
            width:58px;
            height:58px;
            opacity:0
        }
    }
    @keyframes lds-ripple{
        0%{
            top:28px;
            left:28px;
            width:0;
            height:0;
            opacity:0
        }5%{
            top:28px;
            left:28px;
            width:0;
            height:0;
            opacity:1
        }to{
            top:-1px;
            left:-1px;
            width:58px;
            height:58px;
            opacity:0
        }
    }

    .loading_container {
        overflow: hidden; /* Hide scrollbars */
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
</style>
</head>

<body>
    <?php 
        // if ($_SESSION['user_type'] == 'system_user') {
          if (isset($_SESSION['company_id'])) {
            $fetchComapnyLogo = "SELECT * FROM `company_profile` WHERE `company_id` = '".$_SESSION['company_id']."'";
            $run_fetch_company_Logo = mysqli_query($con,$fetchComapnyLogo);
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
                             <!-- <img src="<?php //echo $main_company_logo; ?>" alt="homepage" class="light-logo" style="width: 90%;//background-color: #FFF;" /> -->
                             <?php
                             if ($main_company_logo != "") { ?>
                                <img src="<?php echo $main_company_logo; ?>" alt="Logo to be uploaded" class="light-logo" style="width: 90%;//background-color: #FFF;" />
                             <?php }else{ ?>
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
                    if ($_SESSION['user_type'] == 'system_user') {
                      if (isset($_SESSION['company_id'])) {
                        $fetch_user_data = "SELECT * FROM `users` WHERE `company_id` = '".$_SESSION['company_id']."' AND `id` = '".$_SESSION['user_id']."'";
                        $run_fetch_user_data = mysqli_query($con,$fetch_user_data);
                        $row = mysqli_fetch_array($run_fetch_user_data);
                      } ?>
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
                                    <?php if ($row['add_users'] == "1") { ?>
                                        <!-- <a class="dropdown-item" href="controller_operator"><i class="fas fa-wrench m-r-5 m-l-5"></i> Controller Operator</a> -->
                                        <!--<a class="dropdown-item" href="add_users"><i class="fas fa-users-cog m-r-5 m-l-5"></i> User Management</a>-->
                                        <!-- <a class="dropdown-item" href="manage_dashboard"><i class="fas fa-users-cog m-r-5 m-l-5"></i> Dashboard Panel</a> -->
                                    <?php } ?>
                                    <?php if ($row['admin_status'] == "1") { ?>
                                    <a class="dropdown-item" href="add_users"><i class="fas fa-users-cog m-r-5 m-l-5"></i> User Management</a>
                                    <a class="dropdown-item" href="department"><i class="fas fa-envelope m-r-5 m-l-5"></i> Department Panel</a>
                                    <a class="dropdown-item" href="designation"><i class="fas fa-envelope m-r-5 m-l-5"></i> Designation Panel</a>
                                    <a class="dropdown-item" href="calling_data"><i class="fas fa-envelope m-r-5 m-l-5"></i> Data</a>
                                    <a class="dropdown-item" href="call_Filter"><i class="fas fa-envelope m-r-5 m-l-5"></i> Filter</a>
                                    <a class="dropdown-item" href="ac_Change"><i class="fas fa-envelope m-r-5 m-l-5"></i> A/c Change</a><hr>
                                    <a class="dropdown-item" href="filter_partner"><i class="fas fa-envelope m-r-5 m-l-5"></i> Partner Filter</a>
                                    <a class="dropdown-item" href="sendMailPanel"><i class="fas fa-envelope m-r-5 m-l-5"></i> Mail Panel</a>
                                    <?php } ?>
                                    <?php if ($row['user_type'] == "simple_user") { ?>
                                    <a class="dropdown-item" href="addRecord"><i class="fas fa-envelope m-r-5 m-l-5"></i> Add Record</a>
                                    <?php } ?>
                                    <?php if ($row['company_profile'] == "1") { ?>
                                    <a class="dropdown-item" href="Ex_Tan" target="_blank" onclick="window.open('Ex_Gst'); window.open('Ex_Pan'); window.open('Ex_Etds'); window.open('Ex_psp_consumption'); window.open('Ex_Psp_Coupon_Distribution'); window.open('Ex_Token_Stock'); window.open('Ex_dsc_token'); window.open('Ex_exchange'); window.open('Ex_Other_Services'); window.open('Ex_Services_Received'); window.open('Ex_advance'); window.open('Ex_service_income'); window.open('Ex_Contra_Voucher'); window.open('Ex_Tax_Invoice'); window.open('Ex_Retail_Invoice'); window.open('Ex_Credit_Note'); window.open('Ex_Debit_Note'); window.open('Ex_Purchase_Note'); window.open('Ex_Quotation_Note'); window.open('Ex_it_returns'); window.open('Ex_audit'); window.open('Ex_Dsc_Applicant'); window.open('Ex_dsc_stock'); window.open('Ex_vendor_master'); window.open('Ex_outstanding_data'); window.open('Ex_client_master'); window.open('Ex_Dsc_Partner'); window.open('Ex_service_expense'); window.open('Ex_24G'); window.open('Ex_gst_returns');"><i class="fas fa-users-cog m-r-5 m-l-5"></i>Export</a> 
                                    <?php } ?>
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
                <?php }else{ ?>
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
                                    <a class="dropdown-item" href="" data-toggle="modal" data-target="#ChangePasswordPopup"><i class="fa fa-key m-r-5 m-l-5"></i> Change Password</a>
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
                            <?php if($userrow['type'] == 1){
                                echo '<li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link singleLink" href="Dashboard" aria-expanded="false"><i class="fas fa-tachometer-alt"></i><span class="hide-menu">Dashboard</span></a></li>';
                                echo '<li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link singleLink" href="Partner_dashboard" aria-expanded="false"><i class="fas fa-tachometer-alt"></i><span class="hide-menu">Partner</span></a></li>';
                            }
                            if($userrow['type'] == 3){
                                echo '<li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link singleLink" href="user_dashboard" aria-expanded="false"><i class="fas fa-tachometer-alt"></i><span class="hide-menu">Dashboard</span></a></li>';
                            } ?>
                            
                            <!--<li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fas fa-calculator"></i><span class="hide-menu">DSC</span></a>-->
                            <!--    <ul aria-expanded="false" class="collapse first-level pl-3">-->
                            <!--    <?php /*if ($row['client_master'] == "1") { ?>-->
                            <!--    <?php }-->
                            <!--    if ($row['dsc_subscriber'] == "1" || $row['dsc_reseller'] == "1") {?>-->
                            <!--    <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="dsc_portal" aria-expanded="false"><i class="mdi mdi-receipt"></i><span class="hide-menu">DSC </span></a>-->
                            <!--        <ul aria-expanded="false" class="collapse  first-level pl-3">-->
                            <!--            <?php if ($row['dsc_subscriber'] == "1") {?>-->
                            <!--                <li class="sidebar-item"><a href="dsc_subscriber" class="sidebar-link"><i class="mdi mdi-note-outline"></i><span class="hide-menu"> DSC Applicant </span></a></li>-->
                            <!--            <?php } if ($row['dsc_reseller'] == "1") {?>-->
                            <!--                <li class="sidebar-item"><a href="dsc_reseller" class="sidebar-link"><i class="mdi mdi-note-plus"></i><span class="hide-menu"> DSC Partner </span></a></li>-->
                            <!--            <?php } ?>-->
                            <!--             <li class="sidebar-item"><a href="dsc_portal" class="sidebar-link"><i class="mdi mdi-note-plus"></i><span class="hide-menu"> DSC Portal </span></a></li>-->
                            <!--            <li class="sidebar-item"><a href="dsc_token" class="sidebar-link"><i class="mdi mdi-note-plus"></i><span class="hide-menu"> Token Usage </span></a></li>-->
                            <!--            <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-receipt"></i><span class="hide-menu">Inventory </span></a>-->
                            <!--                <ul aria-expanded="false" class="collapse  first-level pl-3">-->
                            <!--                    <li class="sidebar-item"><a href="token_stock" class="sidebar-link"><i class="mdi mdi-note-plus"></i><span class="hide-menu"> Procured Stock </span></a></li>-->
                            <!--                    <li class="sidebar-item"><a href="dsc_stock" class="sidebar-link"><i class="mdi mdi-note-plus"></i><span class="hide-menu"> DSC Inventory </span></a></li>-->
                            <!--                    <li class="sidebar-item"><a href="exchange" class="sidebar-link"><i class="mdi mdi-note-plus"></i><span class="hide-menu"> Exchange </span></a></li>-->
                            <!--                </ul>-->
                            <!--            </li>-->
                            <!--        </ul>-->
                            <!--    </li>-->
                            <!--    <?php } */?>-->
                            <!--    <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fas fa-calculator"></i><span class="hide-menu">Task Manager</span></a>-->
                            <!--    <ul aria-expanded="false" class="collapse  first-level pl-3">-->
                            <!--        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link singleLink" href="main_content" aria-expanded="false"><i class="mdi mdi-view-dashboard"></i><span class="hide-menu">Home</span></a></li>-->
                                    
                            <!--        <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fas fa-calculator"></i><span class="hide-menu">OTO-Task </span></a>-->
                            <!--            <ul aria-expanded="false" class="collapse  first-level pl-3">-->
                            <!--                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link singleLink" href="do_task" aria-expanded="false"><i class="mdi mdi-coins"></i><span class="hide-menu">Do Task</span></a></li>-->
                            <!--                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link singleLink" href="give_task" aria-expanded="false"><i class="mdi mdi-coins"></i><span class="hide-menu">Give Task</span></a></li>-->
                            <!--            </ul>-->
                            <!--        </li>-->
                            <!--        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link singleLink" href="group" aria-expanded="false"><i class="mdi mdi-coins"></i><span class="hide-menu">Group</span></a></li>-->
                            <!--    </ul>-->
                            <!--</li>-->
                                <?php /*if ($row['other_services'] == "1") {?>
                                    <!--<li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link singleLink" href="other_services" aria-expanded="false"><i class="mdi mdi-view-dashboard"></i><span class="hide-menu">Other Services</span></a></li>-->
                                <?php }*/ ?>
                            <!--    </ul>-->
                            <!--</li>-->
                            <!--<li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fas fa-calculator"></i><span class="hide-menu">Supplier Station </span></a>-->
                            <!--    <ul aria-expanded="false" class="collapse first-level pl-3">-->
                            <!--        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link singleLink" href="services_received" aria-expanded="false"><i class="mdi mdi-view-dashboard"></i><span class="hide-menu">Services Received</span></a></li>-->
                            <!--    </ul>-->
                            <!--</li>-->
                            <?php /*if ($row['client_master'] == "1") {?>
                                 <!--<li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-receipt"></i><span class="hide-menu">Document Records </span></a>-->
                                 <!--    <ul aria-expanded="false" class="collapse  first-level pl-3">-->
                                 <!--        <li class="sidebar-item"><a href="tax_invoice" class="sidebar-link"><i class="mdi mdi-note-outline"></i><span class="hide-menu"> Tax Invoice </span></a></li>-->
                                 <!--        <li class="sidebar-item"><a href="retail_invoice" class="sidebar-link"><i class="mdi mdi-note-outline"></i><span class="hide-menu"> Retail Invoice </span></a></li>-->
                                 <!--        <li class="sidebar-item"><a href="credit_note" class="sidebar-link"><i class="mdi mdi-note-outline"></i><span class="hide-menu"> Credit Note </span></a></li>-->
                                 <!--        <li class="sidebar-item"><a href="debit_note" class="sidebar-link"><i class="mdi mdi-note-outline"></i><span class="hide-menu"> Debit Note </span></a></li>-->
                                 <!--        <li class="sidebar-item"><a href="purchase_note" class="sidebar-link"><i class="mdi mdi-note-outline"></i><span class="hide-menu"> Purchase Order </span></a></li>-->
                                 <!--        <li class="sidebar-item"><a href="quotation_note" class="sidebar-link"><i class="mdi mdi-note-outline"></i><span class="hide-menu"> Quotation </span></a></li>-->
                                 <!--    </ul>-->
                                 <!--</li>-->
                            <?php }*/ ?>
                            <!-- <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fas fa-calculator"></i><span class="hide-menu">Supplier </span></a>
                                <ul aria-expanded="false" class="collapse  first-level pl-3">
                                    <?php /*if ($row['client_master'] == "1") { ?>
                                        <li class="sidebar-item"> <a class="sidebar-link sidebar-link singleLink" href="vendor_master" aria-expanded="false"><i class="fas fa-users"></i><span class="hide-menu">Supplier Master</span></a></li>
                                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link singleLink" href="services_received" aria-expanded="false"><i class="mdi mdi-view-dashboard"></i><span class="hide-menu">Services Received</span></a></li>
                                    <?php }*/ ?>
                                </ul>
                            </li> -->
                            <?php /*if ($row['payment'] == "1") {?>
                                <!-- <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link singleLink" href="bank_transaction" aria-expanded="false"><i class="fas fa-university"></i><span class="hide-menu">Bank Transaction</span></a></li> -->
                            <?php }*/ ?>
                            <!--<li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fas fa-calculator"></i><span class="hide-menu">Financial Records </span></a>-->
                            <!--<ul aria-expanded="false" class="collapse  first-level pl-3">-->
                            <!--    <li class="sidebar-item"> <a class="sidebar-link sidebar-link singleLink" href="advance" aria-expanded="false"><i class="fas fa-coins"></i><span class="hide-menu">Payment Received</span></a></li>-->
                            <!--    <li class="sidebar-item"> <a class="sidebar-link sidebar-link singleLink" href="service_income" aria-expanded="false"><i class="fas fa-coins"></i><span class="hide-menu">Service settlement</span></a></li>-->
                            <!--    <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link singleLink" href="service_expense" aria-expanded="false"><i class="mdi mdi-view-dashboard"></i><span class="hide-menu">Supplier Expense</span></a></li>-->
                            <!--    <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link singleLink" href="service_contra" aria-expanded="false"><i class="mdi mdi-coins"></i><span class="hide-menu">Contra Voucher</span></a></li>-->
                            <!--    <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link singleLink" href="outstanding" aria-expanded="false"><i class="mdi mdi-coins"></i><span class="hide-menu">Outstanding</span></a></li>-->
                            <!--</ul>-->
                            <!--li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-receipt"></i><span class="hide-menu">Other Services </span></a>
                                <ul aria-expanded="false" class="collapse  first-level">
                                    <li class="sidebar-item"><a href="passport" class="sidebar-link"><i class="mdi mdi-note-outline"></i><span class="hide-menu"> Passport </span></a></li>
                                    <li class="sidebar-item"><a href="marriage_certificate" class="sidebar-link"><i class="mdi mdi-note-plus"></i><span class="hide-menu"> Marriage Certificate </span></a></li>
                                    <li class="sidebar-item"><a href="other_services" class="sidebar-link"><i class="mdi mdi-note-plus"></i><span class="hide-menu"> Others </span></a></li>
                                </ul>
                            </li-->
                            <?php /*if ($row['other_transaction'] == "1") {?>
                                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link singleLink" href="other_transaction" aria-expanded="false"><i class="mdi mdi-view-dashboard"></i><span class="hide-menu">Other Transaction</span></a></li>
                            <?php } */?>
                            
                            <?php /*if ($row['payroll'] == "1") {?>
                                <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-receipt"></i><span class="hide-menu">Payroll </span></a>
                                    <ul aria-expanded="false" class="collapse  first-level">
                                        <li class="sidebar-item"><a href="prEmployeeMaster" class="sidebar-link"><i class="fas fa-bell icons"></i><span class="hide-menu"> Employees </span></a></li>
                                        <li class="sidebar-item"><a href="prEmployeeAttendance" class="sidebar-link"><i class="fas fa-bell icons"></i><span class="hide-menu"> Attendance </span></a></li>
                                        <li class="sidebar-item"><a href="prEmployeeSalary" class="sidebar-link"><i class="fas fa-coins icons"></i><span class="hide-menu"> Salary </span></a></li>
                                        <li class="sidebar-item"><a href="prSetting" class="sidebar-link"><i class="fas fa-bell icons"></i><span class="hide-menu"> Settings </span></a></li>
                                    </ul>
                                </li>
                            <?php }*/ ?>
                            <!--<li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-receipt"></i><span class="hide-menu">Trading Station </span></a>-->
                            <!--    <ul aria-expanded="false" class="collapse  first-level">-->
                            <!--        <li class="sidebar-item"><a href="sales" class="sidebar-link"><i class="fas fa-bell icons"></i><span class="hide-menu"> Sales </span></a></li>-->
                            <!--        <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-receipt"></i><span class="hide-menu">Purchase </span></a>-->
                            <!--            <ul aria-expanded="false" class="collapse  first-level pl-3">-->
                            <!--                <li class="sidebar-item"><a href="inventory" class="sidebar-link"><i class="fas fa-bell icons"></i><span class="hide-menu"> Inventory </span></a></li>-->
                            <!--                <li class="sidebar-item"><a href="procure" class="sidebar-link"><i class="fas fa-bell icons"></i><span class="hide-menu"> Procure </span></a></li>-->
                            <!--            </ul>-->
                            <!--        </li>-->
                            <!--    </ul>-->
                            <!--</li>-->
                            <!--<li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fas fa-calculator"></i><span class="hide-menu">Pocket Apps </span></a>-->
                            <!--    <ul aria-expanded="false" class="collapse  first-level pl-3">-->
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
                            <!--        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link singleLink" href="password_manager" aria-expanded="false"><i class="mdi mdi-view-dashboard"></i><span class="hide-menu">Password Manager</span></a></li>-->
                            <!--        <?php /*if ($row['client_master'] == "1") { ?>-->
                                        <!-- <li class="sidebar-item"> <a class="sidebar-link sidebar-link singleLink" href="contact_client" aria-expanded="false"><i class="fas fa-id-card"></i><span class="hide-menu">Chats</span></a></li> -->
                            <!--            <li class="sidebar-item"> <a class="sidebar-link sidebar-link singleLink" href="contact_client" aria-expanded="false"><i class="fas fa-id-card"></i><span class="hide-menu">Contacts</span></a></li>-->
                            <!--            <?php }*/ ?>-->
                            <!--    </ul>-->
                            <!--</li>-->
                           
                            <!--li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="charts.html" aria-expanded="false"><i class="mdi mdi-chart-bar"></i><span class="hide-menu">Charts</span></a></li>
                            <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="widgets.html" aria-expanded="false"><i class="mdi mdi-chart-bubble"></i><span class="hide-menu">Widgets</span></a></li>
                            <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="tables.html" aria-expanded="false"><i class="mdi mdi-border-inside"></i><span class="hide-menu">Tables</span></a></li>
                            <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="grid.html" aria-expanded="false"><i class="mdi mdi-blur-linear"></i><span class="hide-menu">Full Width</span></a></li>
                            <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-receipt"></i><span class="hide-menu">Forms </span></a>
                                <ul aria-expanded="false" class="collapse  first-level">
                                    <li class="sidebar-item"><a href="form-basic.html" class="sidebar-link"><i class="mdi mdi-note-outline"></i><span class="hide-menu"> Form Basic </span></a></li>
                                    <li class="sidebar-item"><a href="form-wizard.html" class="sidebar-link"><i class="mdi mdi-note-plus"></i><span class="hide-menu"> Form Wizard </span></a></li>
                                </ul>
                            </li>
                            <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="pages-buttons.html" aria-expanded="false"><i class="mdi mdi-relative-scale"></i><span class="hide-menu">Buttons</span></a></li>
                            <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-face"></i><span class="hide-menu">Icons </span></a>
                                <ul aria-expanded="false" class="collapse  first-level">
                                    <li class="sidebar-item"><a href="icon-material.html" class="sidebar-link"><i class="mdi mdi-emoticon"></i><span class="hide-menu"> Material Icons </span></a></li>
                                    <li class="sidebar-item"><a href="icon-fontawesome.html" class="sidebar-link"><i class="mdi mdi-emoticon-cool"></i><span class="hide-menu"> Font Awesome Icons </span></a></li>
                                </ul>
                            </li>
                            <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="pages-elements.html" aria-expanded="false"><i class="mdi mdi-pencil"></i><span class="hide-menu">Elements</span></a></li>
                            <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-move-resize-variant"></i><span class="hide-menu">Addons </span></a>
                                <ul aria-expanded="false" class="collapse  first-level">
                                    <li class="sidebar-item"><a href="index2.html" class="sidebar-link"><i class="mdi mdi-view-dashboard"></i><span class="hide-menu"> Dashboard-2 </span></a></li>
                                    <li class="sidebar-item"><a href="pages-gallery.html" class="sidebar-link"><i class="mdi mdi-multiplication-box"></i><span class="hide-menu"> Gallery </span></a></li>
                                    <li class="sidebar-item"><a href="pages-calendar.html" class="sidebar-link"><i class="mdi mdi-calendar-check"></i><span class="hide-menu"> Calendar </span></a></li>
                                    <li class="sidebar-item"><a href="pages-invoice.html" class="sidebar-link"><i class="mdi mdi-bulletin-board"></i><span class="hide-menu"> Invoice </span></a></li>
                                    <li class="sidebar-item"><a href="pages-chat.html" class="sidebar-link"><i class="mdi mdi-message-outline"></i><span class="hide-menu"> Chat Option </span></a></li>
                                </ul>
                            </li>
                            <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-account-key"></i><span class="hide-menu">Authentication </span></a>
                                <ul aria-expanded="false" class="collapse  first-level">
                                    <li class="sidebar-item"><a href="authentication-login.html" class="sidebar-link"><i class="mdi mdi-all-inclusive"></i><span class="hide-menu"> Login </span></a></li>
                                    <li class="sidebar-item"><a href="authentication-register.html" class="sidebar-link"><i class="mdi mdi-all-inclusive"></i><span class="hide-menu"> Register </span></a></li>
                                </ul>
                            </li>
                            <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-alert"></i><span class="hide-menu">Errors </span></a>
                                <ul aria-expanded="false" class="collapse  first-level">
                                    <li class="sidebar-item"><a href="error-403.html" class="sidebar-link"><i class="mdi mdi-alert-octagon"></i><span class="hide-menu"> Error 403 </span></a></li>
                                    <li class="sidebar-item"><a href="error-404.html" class="sidebar-link"><i class="mdi mdi-alert-octagon"></i><span class="hide-menu"> Error 404 </span></a></li>
                                    <li class="sidebar-item"><a href="error-405.html" class="sidebar-link"><i class="mdi mdi-alert-octagon"></i><span class="hide-menu"> Error 405 </span></a></li>
                                    <li class="sidebar-item"><a href="error-500.html" class="sidebar-link"><i class="mdi mdi-alert-octagon"></i><span class="hide-menu"> Error 500 </span></a></li>
                                </ul>
                            </li-->
                        </ul>
                    </nav>
                    <!-- End Sidebar navigation -->
                </div>
                <!-- End Sidebar scroll-->
            </aside>
        <?php }else{ ?>
            <aside class="left-sidebar left-menu" data-sidebarbg="skin5">
                <!-- Sidebar scroll-->
                <div class="scroll-sidebar">
                    <!-- Sidebar navigation-->
                    <nav class="sidebar-nav">
                        <ul id="sidebarnav" class="p-t-30">
                            <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link singleLink" href="Dashboard" aria-expanded="false"><i class="fas fa-tachometer-alt"></i><span class="hide-menu">Dashboard</span></a></li>
                            <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-effect waves-dark" href="client_dsc_portal" aria-expanded="false"><i class="mdi mdi-receipt"></i><span class="hide-menu">DSC </span></a></li>
                            <!--<li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fas fa-calculator"></i><span class="hide-menu">DSC </span></a>-->
                                <ul aria-expanded="false" class="collapse first-level pl-3">
                                    <!--<li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fas fa-calculator"></i><span class="hide-menu">Taxation </span></a>-->
                                    <!--    <ul aria-expanded="false" class="collapse first-level pl-3">-->
                                            <!-- <li class="sidebar-item"><a href="gst" class="sidebar-link"><i class="mdi mdi-note-plus"></i><span class="hide-menu"> GST </span></a></li> -->
                                    <!--        <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fas fa-calculator"></i><span class="hide-menu">GST </span></a>-->
                                    <!--            <ul aria-expanded="false" class="collapse first-level pl-3">-->
                                    <!--                <li class="sidebar-item"> <a class="sidebar-link sidebar-link singleLink" href="gst_fees" aria-expanded="false"><i class="fas fa-calculator"></i><span class="hide-menu">GST Fees</span></a></li>-->
                                    <!--                <li class="sidebar-item"> <a class="sidebar-link sidebar-link singleLink" href="gst_returns" aria-expanded="false"><i class="fas fa-calculator"></i><span class="hide-menu">GST Returns</span></a></li>-->
                                    <!--            </ul>-->
                                    <!--        </li>-->
                                    <!--        <li class="sidebar-item"><a href="it_returns" class="sidebar-link"><i class="mdi mdi-note-plus"></i><span class="hide-menu"> IT Returns </span></a></li>-->
                                    <!--        <li class="sidebar-item"><a href="audit" class="sidebar-link"><i class="mdi mdi-note-plus"></i><span class="hide-menu"> Audit </span></a></li>-->
                                    <!--    </ul>-->
                                    <!--</li>-->
                                    <!--<li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-receipt"></i><span class="hide-menu">Tin/Pan-FC </span></a>-->
                                    <!--    <ul aria-expanded="false" class="collapse  first-level pl-3">-->
                                    <!--        <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-receipt"></i><span class="hide-menu">NSDL </span></a>-->
                                    <!--            <ul aria-expanded="false" class="collapse  first-level pl-3">-->
                                    <!--                <li class="sidebar-item"><a href="pan" class="sidebar-link"><i class="mdi mdi-note-outline"></i><span class="hide-menu"> PAN </span></a></li>-->
                                    <!--                <li class="sidebar-item"><a href="tan" class="sidebar-link"><i class="mdi mdi-note-plus"></i><span class="hide-menu"> TAN </span></a></li>-->
                                    <!--                <li class="sidebar-item"><a href="e_tds" class="sidebar-link"><i class="mdi mdi-note-plus"></i><span class="hide-menu"> e-TDS </span></a></li>-->
                                    <!--                <li class="sidebar-item"><a href="twenty4g" class="sidebar-link"><i class="mdi mdi-note-plus"></i><span class="hide-menu"> 24G </span></a></li>-->
                                    <!--            </ul>-->
                                    <!--        </li>-->
                                    <!--        <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-receipt"></i><span class="hide-menu">UTI </span></a>-->
                                    <!--            <ul aria-expanded="false" class="collapse  first-level pl-3">-->
                                    <!--                <li class="sidebar-item"><a href="psp" class="sidebar-link"><i class="mdi mdi-note-outline"></i><span class="hide-menu"> PSP Coupon Distribution </span></a></li>-->
                                                    <!-- <li class="sidebar-item"><a href="coupon_consumption" class="sidebar-link"><i class="mdi mdi-note-plus"></i><span class="hide-menu"> PSP Coupon </span></a></li> -->
                                    <!--            </ul>-->
                                    <!--        </li>-->
                                    <!--    </ul>-->
                                    <!--</li>-->
                                    <!--<li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-receipt"></i><span class="hide-menu">DSC </span></a>-->
                                    <!--    <ul aria-expanded="false" class="collapse  first-level pl-3">-->
                                    <!--        <li class="sidebar-item"><a href="dsc_subscriber" class="sidebar-link"><i class="mdi mdi-note-outline"></i><span class="hide-menu"> DSC Applicant </span></a></li>-->
                                    <!--        <li class="sidebar-item"><a href="dsc_reseller" class="sidebar-link"><i class="mdi mdi-note-plus"></i><span class="hide-menu"> DSC Partner </span></a></li>-->
                                    <!--        <li class="sidebar-item"><a href="dsc_token" class="sidebar-link"><i class="mdi mdi-note-plus"></i><span class="hide-menu"> Token Usage </span></a></li>-->
                                    <!--        <li class="sidebar-item"><a href="client_dsc_portal" class="sidebar-link"><i class="mdi mdi-note-plus"></i><span class="hide-menu"> DSC Portal </span></a></li>-->
                                    <!--        <li class="sidebar-item d-none"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-receipt"></i><span class="hide-menu">Inventory </span></a>-->
                                    <!--        <ul aria-expanded="false" class="collapse  first-level pl-3">-->
                                    <!--            <li class="sidebar-item"><a href="token_stock" class="sidebar-link"><i class="mdi mdi-note-plus"></i><span class="hide-menu"> Procured Stock </span></a></li>-->
                                    <!--            <li class="sidebar-item"><a href="dsc_stock" class="sidebar-link"><i class="mdi mdi-note-plus"></i><span class="hide-menu"> DSC Inventory </span></a></li>-->
                                    <!--        </ul>-->
                                    <!--    </li>-->
                                    <!--</ul>-->
                                <!--</li>-->
                                <!--<li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link singleLink" href="other_services" aria-expanded="false"><i class="mdi mdi-view-dashboard"></i><span class="hide-menu">Other Services</span></a></li>-->
                                <!--<li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-receipt"></i><span class="hide-menu">Document Records </span></a>-->
                                <!--    <ul aria-expanded="false" class="collapse  first-level pl-3">-->
                                <!--        <li class="sidebar-item"><a href="tax_invoice" class="sidebar-link"><i class="mdi mdi-note-outline"></i><span class="hide-menu"> Tax Invoice </span></a></li>-->
                                <!--        <li class="sidebar-item"><a href="retail_invoice" class="sidebar-link"><i class="mdi mdi-note-outline"></i><span class="hide-menu"> Retail Invoice </span></a></li>-->
                                <!--        <li class="sidebar-item"><a href="credit_note" class="sidebar-link"><i class="mdi mdi-note-outline"></i><span class="hide-menu"> Credit Note </span></a></li>-->
                                <!--        <li class="sidebar-item"><a href="debit_note" class="sidebar-link"><i class="mdi mdi-note-outline"></i><span class="hide-menu"> Debit Note </span></a></li>-->
                                <!--        <li class="sidebar-item"><a href="purchase_note" class="sidebar-link"><i class="mdi mdi-note-outline"></i><span class="hide-menu"> Purchase Order </span></a></li>-->
                                <!--        <li class="sidebar-item"><a href="quotation_note" class="sidebar-link"><i class="mdi mdi-note-outline"></i><span class="hide-menu"> Quotation </span></a></li>-->
                                <!--    </ul>-->
                                <!--</li>-->
                                <!--<li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-receipt"></i><span class="hide-menu">Financial Consultancy </span></a>-->
                                <!--    <ul aria-expanded="false" class="collapse  first-level pl-3">-->
                                <!--        <li class="sidebar-item"><a href="loan" class="sidebar-link"><i class="mdi mdi-note-outline"></i><span class="hide-menu"> Loan </span></a></li>-->
                                <!--        <li class="sidebar-item"><a href="insurance" class="sidebar-link"><i class="mdi mdi-note-plus"></i><span class="hide-menu"> Insurance </span></a></li>-->
                                <!--        <li class="sidebar-item"><a href="finance" class="sidebar-link"><i class="mdi mdi-note-plus"></i><span class="hide-menu"> Finance </span></a></li>-->
                                <!--    </ul>-->
                                <!--</li>-->
                                <!-- <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link singleLink" href="invoice_receipt" aria-expanded="false"><i class="fas fa-rupee-sign"></i><span class="hide-menu">Reports</span></a></li>
                                </ul> -->
                            </li>
                            <!--<li class="sidebar-item d-none"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fas fa-calculator"></i><span class="hide-menu">Supplier </span></a>-->
                            <!--    <ul aria-expanded="false" class="collapse  first-level pl-3">-->
                                    <!-- <li class="sidebar-item"> <a class="sidebar-link sidebar-link singleLink" href="vendor_master" aria-expanded="false"><i class="fas fa-users"></i><span class="hide-menu">Supplier Master</span></a></li> -->
                            <!--        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link singleLink" href="services_received" aria-expanded="false"><i class="mdi mdi-view-dashboard"></i><span class="hide-menu">Services Received</span></a></li>-->
                            <!--        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link singleLink" href="invoice_payment" aria-expanded="false"><i class="mdi mdi-coins"></i><span class="hide-menu">Payment</span></a></li>-->
                            <!--    </ul>-->
                            <!--</li>-->
                            <!-- <li class="sidebar-item d-none"> <a class="sidebar-link waves-effect waves-dark sidebar-link singleLink" href="bank_transaction" aria-expanded="false"><i class="fas fa-university"></i><span class="hide-menu">Bank Transaction</span></a></li> -->
                            <!--<li class="sidebar-item d-none"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fas fa-calculator"></i><span class="hide-menu">Other Apps </span></a>-->
                            <!--    <ul aria-expanded="false" class="collapse  first-level pl-3">-->
                                    <!-- <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-receipt"></i><span class="hide-menu">Pocket Accounts </span></a>
                                        <ul aria-expanded="false" class="collapse  first-level pl-3">-->
                            <!--                <li class="sidebar-item"><a href="income" class="sidebar-link"><i class="mdi mdi-note-plus"></i><span class="hide-menu"> Income </span></a></li>-->
                            <!--                <li class="sidebar-item"><a href="expense" class="sidebar-link"><i class="mdi mdi-note-plus"></i><span class="hide-menu"> Expense </span></a></li>-->
                            <!--                <li class="sidebar-item"><a href="payable" class="sidebar-link"><i class="mdi mdi-airplane-takeoff"></i><span class="hide-menu"> Payable </span></a></li>-->
                            <!--                <li class="sidebar-item"><a href="receivable" class="sidebar-link"><i class="mdi mdi-airplane-landing"></i><span class="hide-menu"> Receivable </span></a></li>-->
                            <!--                <li class="sidebar-item"><a href="account_report" class="sidebar-link"><i class="fas fa-edit icons"></i><span class="hide-menu"> Summary </span></a></li>-->
                            <!--                <li class="sidebar-item"><a href="setting" class="sidebar-link"><i class="fas fa-cogs"></i><span class="hide-menu"> Settings </span></a></li>-->
                            <!--                <li class="sidebar-item"><a href="notes" class="sidebar-link"><i class="far fa-sticky-note icons"></i><span class="hide-menu"> Notes </span></a></li>-->
                            <!--                <li class="sidebar-item"><a href="reminder" class="sidebar-link"><i class="fas fa-bell icons"></i><span class="hide-menu"> Reminder </span></a></li>-->
                            <!--            </ul>-->
                            <!--        </li> -->
                            <!--        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link singleLink" href="password_manager" aria-expanded="false"><i class="mdi mdi-view-dashboard"></i><span class="hide-menu">Password Manager</span></a></li>-->
                                                                     
                               <!-- </ul>
                            </li>
                        </ul> -->
                                             
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
                            <?php if($userrow['type'] == 1){
                                echo '<li class="breadcrumb-item"><a href="Dashboard">Home</a></li>';
                            }
                            if($userrow['type'] == 3){
                                echo '<li class="breadcrumb-item"><a href="user_dashboard">Home</a></li>';
                            }?>
                            
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
                                    echo "<li class='breadcrumb-item active' aria-current='page'><a href='service_expense'>Supplier Expense</a></li>";
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
                                if ($filename == "sales") {
                                    echo "<li class='breadcrumb-item active' aria-current='page'>Trading Station</li>";
                                    // echo "<li class='breadcrumb-item active' aria-current='page'>Sales</li>";
                                    echo "<li class='breadcrumb-item active' aria-current='page'><a href='sales'>Sales</a></li>";
                                }
                                if ($filename == "productList") {
                                    echo "<li class='breadcrumb-item active' aria-current='page'><a href='productList'>Product List</a></li>";
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
                                // Calling breadcrumbs
                                if ($filename == "calling_data") {
                                    echo "<li class='breadcrumb-item active' aria-current='page'><a href='calling_data'>Data</a></li>";
                                }
                                if ($filename == "CallTitle_DataList") {
                                    echo "<li class='breadcrumb-item active' aria-current='page'><a href='calling_data'>Data</a></li>";
                                    echo "<li class='breadcrumb-item active' aria-current='page'><a href='CallTitle_DataList'>Sheets</a></li>";
                                }
                                if ($filename == "listData") {
                                    echo "<li class='breadcrumb-item active' aria-current='page'><a href='listData'>Data</a></li>";
                                }
                                if ($filename == "call_Filter") {
                                    echo "<li class='breadcrumb-item active' aria-current='page'><a href='call_Filter'>Filter</a></li>";
                                }
                                if ($filename == "client_partner") {
                                    echo "<li class='breadcrumb-item active' aria-current='partner'><a href='partner'>Partner</a></li>";
                                    echo "<li class='breadcrumb-item active' aria-current='page'><a href='client'>Client</a></li>";
                                }
                                if ($filename == "partner") {
                                    echo "<li class='breadcrumb-item active' aria-current='page'><a href='partner'>Partner</a></li>";
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
                                        if ($filename == "client_master") {
                                            echo "<button class='btn btn-success btn-sm mr-1' id='add_new_clientMaster'><i class='fas fa-plus'></i> Add New Client</button>
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
                                            echo "<button class='btn btn-success btn-sm mr-1' id='add_new_TaxInvoice'><i class='fas fa-plus'></i> Add New</button>
                                            <form method='post' id='Export_TaxInvoiceForm' action='Export_Tax_Invoice'>
                                                <button type='submit' name='Export_Tax_Invoice' class='btn btn-secondary btn-sm' id='export_gst'><i class='fas fa-file-export'></i> Export</button>
                                            </form>";
                                        }
                                        if ($filename == "retail_invoice") {
                                            echo "<button class='btn btn-success btn-sm mr-1' id='add_new_RetailInvoice'><i class='fas fa-plus'></i> Add New</button>
                                            <form method='post' id='Export_RetailInvoiceForm' action='Export_Retail_Invoice'>
                                                <button type='submit' name='Export_Retail_Invoice' class='btn btn-secondary btn-sm' id='export_gst'><i class='fas fa-file-export'></i> Export</button>
                                            </form>";
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
                                            echo "<button class='btn btn-success btn-sm mr-1' id='add_new_PurchaseNote'><i class='fas fa-plus'></i> Add New</button>
                                            <form method='post' id='Export_PurchaseNoteForm' action='Export_Purchase_Note'>
                                                <button type='submit' name='Export_Purchase_Note' class='btn btn-secondary btn-sm mr-1' id='export_purchase'><i class='fas fa-file-export'></i> Export Purchase Orders</button>
                                            </form>
                                            <form method='post' id='Export_PurchaseNoteForm' action='Export_Purchase_Note'>
                                                <button type='submit' name='Export_Purchase_Note_Products' class='btn btn-secondary btn-sm' id='export_purchaseProducts'><i class='fas fa-file-export'></i> Export Products</button>
                                            </form>";
                                        }
                                        if ($filename == "quotation_note") {
                                            echo "<button class='btn btn-success btn-sm mr-1' id='add_new_QuotationNote'><i class='fas fa-plus'></i> Add New</button>
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
                                        if ($filename == "inventory") {
                                            echo "<a class='btn btn-success btn-sm mr-1' href='productList'><i class='fas fa-plus'></i> Products</a>
                                            <!--form method='post' id='Export_otherProductsForm' action='Export_other_services'>
                                                <button type='submit' name='Export_other_services' class='btn btn-secondary btn-sm' id='export_other_services'><i class='fas fa-file-export'></i> Export</button>
                                            </form-->";
                                        }
                                        if ($filename == "procure") {
                                            echo "<button class='btn btn-info btn-sm mr-1 d-block' id='View_Procure'><i class='fas fa-eye'></i> View Procure List</button><button class='btn btn-success btn-sm mr-1 d-none' id='Add_Procure'><i class='fas fa-plus'></i> Add New</button>
                                            <!--form method='post' id='Export_PurchaseNoteForm' action='Export_Purchase_Note'>
                                                <button type='submit' name='Export_Purchase_Note' class='btn btn-secondary btn-sm mr-1' id='export_purchase'><i class='fas fa-file-export'></i> Export Purchase Orders</button>
                                            </form>
                                            <form-- method='post' id='Export_PurchaseNoteForm' action='Export_Purchase_Note'>
                                                <button type='submit' name='Export_Purchase_Note_Products' class='btn btn-secondary btn-sm' id='export_purchaseProducts'><i class='fas fa-file-export'></i> Export Products</button>
                                            </form-->";
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
                                            <button class='btn btn-primary btn-sm mr-1' id='view_Units'><i class='fa fa-cubes'></i> View Units</button>
                                            <button class='btn btn-primary btn-sm mr-1' id='view_Packages'><i class='fa fa-cubes'></i> View Packages</button>
                                            <!--form method='post' id='Export_otherProductsForm' action='Export_other_services'>
                                                <button type='submit' name='Export_other_services' class='btn btn-secondary btn-sm' id='export_other_services'><i class='fas fa-file-export'></i> Export</button>
                                            </form-->";
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
                                            echo "<button class='btn btn-success btn-sm mr-1' id='add_new_USERS'><i class='fas fa-plus'></i> Add New</button>
                                        <button class='btn btn-info btn-sm d-none' id='import_USERS'><i class='fas fa-file-import'></i> Import</button>";
                                        }
                                         if ($filename == "main_content") {
                                            echo '<a href="add_user"><button class="btn btn-success btn-sm mr-1" type="submit"><i class="fas fa-plus"></i>View User</button></a>';
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
                                            <button class='btn btn-info btn-sm d-none' id='import_USERS'><i class='fas fa-file-import'></i> Import</button>";
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
                                        // Calling
                                        if ($filename == "calling_data") {
                                            echo "<button class='btn btn-success btn-sm mr-1' id='showAdd_Data' data-toggle='modal' data-target='.showAdd_Data'><i class='fas fa-plus'></i> View Title</button>";
                                        }
                                        if ($filename == "CallTitle_DataList") {
                                            echo "<button class='btn btn-success btn-sm mr-1' id='add_new_TitleData'><i class='fas fa-plus'></i> Add new</button>
                                                <button class='btn btn-success btn-sm mr-1' id='import_dscSubscriber'><i class='fas fa-plus'></i> Import</button>
                                                <form method='post' id='Export_TitleData' action='Export_Title_Data'>
                                                    <button type='submit' name='Export_Title_Data' class='btn btn-secondary btn-sm' id='Export_Title_Data'><i class='fas fa-file-export'></i> Export</button>
                                                </form>
                                                <button class='btn btn-success btn-sm mr-1' id='showAdd_Data' data-toggle='modal' data-target='.showAdd_Data'><i class='fas fa-plus'></i> Filter</button>";
                                        }
                                        if ($filename == "call_user_data") {
                                            echo "<a href='listData'><button class='btn btn-success btn-sm mr-1' id='add_new_TitleData'><i class='fas fa-plus'></i> Data</button></a>";
                                        }
                                         if ($row['type'] == "3") {
                                        if ($filename == "user_dashboard") {
                                            echo '<div class="FilterClass" id="FilterClass"><select id="FilterStatus">
                                                    <option value="0">Select Status:</option>
                                                    <option value="addNew_Status">New</option>
                                                    <option value="addWarm_Status">Warm</option>
                                                    <option value="addInterested_Status">Interested</option>
                                                    <option value="addHot_Status">Hot</option>
                                                    <option value="addClient_Status">Client</option>
                                                    <option value="addRejected_Status">Rejected</option>
                                                  </select></div>';
                                        }}
                                        if ($filename == "partner") {
                                            echo "<button class='btn btn-success btn-sm mr-1' id='add_new_partner'><i class='fas fa-plus'></i> Add Partner</button>
                                            <a href='client_partner'><button class='btn btn-success btn-sm mr-1'><i class='fas fa-plus'></i> Client</button></a>";
                                        }
                                        if ($filename == "client_partner") {
                                            echo "<button class='btn btn-success btn-sm mr-1' id='add_new_client'><i class='fas fa-plus'></i> Add Client</button>";
                                        }
                                        if ($filename == "Partner_dashboard") {
                                            echo "<a href='partner'><button class='btn btn-success btn-sm mr-1'><i class='fas fa-plus'></i> Add Partner</button></a>";
                                            echo "<a href='client_partner'><button class='btn btn-success btn-sm mr-1'><i class='fas fa-plus'></i> Add Client</button></a>";
                                        }
                                        if ($filename == "filter_partner") { ?>
                                            <select id="selectpartner" name="status" class="btn btn-light" style="border: 1px solid black;"> Status
                    					    <option>Choose Status</option>
                    					    <?php 
                    					        $query = "select * from `calling_partner` group by part_id";
                    					        $result = mysqli_query($con,$query);
                    					        while($show = mysqli_fetch_array($result)){
                    					    ?>
                    					    <!--<option value="addNew_Status" class="form-check-label" style="background-color: white;color: black;">New</option>-->
                    					    <option value="<?= $show['part_id']; ?>" class="form-check-label" style="background-color: white;color: black;"><?= $show['partner_name']; ?></option>
                    					    <?php } ?>
                    					</select>
                                       <?php }
                                        ?>
                                    </ol>
                                </nav>
                            </div>
                    <?php }else{ ?>
                            <div class="ml-auto text-right">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <?php
                                            if ($filename == "gst_fees") {
                                                echo "S
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
<?php //include_once 'footer.php'; ?>
<script type="text/javascript">
    $(document). ready(function(){
        // Pre-Loading Script
        /* var body = document.querySelector('body');
        var bar = document.querySelector('.progress-bar');
        var counter = document.querySelector('.count-bar');
        var i = 0;
        var throttle = 0.7; // 0-1
        // alert(counter);
        (function draw() {
        if(i <= 100) {
            var r = Math.random();
            
            requestAnimationFrame(draw);  
            bar.style.width = i + '%';
            counter.innerHTML = Math.round(i) + '%';
            
            if(r < throttle) { // Simulate d/l speed and uneven bitrate
            i = i + r;
            }
        } else {;
            bar.className += " done";
        }
        })(); */

        //Sticky Heading
        //window.onscroll = function() {myFunction()};
        window.onscroll = function() {myFunction();}
        var header = document.getElementById("pageHeading");
        var sticky = header.offsetTop;

        function myFunction() {
            //alert("MyFunction" + window.pageYOffset);
          if (window.pageYOffset > 88) {
            header.classList.add("sticky");
            $("#after-heading").addClass("after-heading");
          } else {
            header.classList.remove("sticky");
            $("#after-heading").removeClass("after-heading");
          }
        }
        /*var current = location.pathname;
        var current_page_URL = location.href;
        var filename = current_page_URL.match(/.*\/(.*)$/)[1];
        //alert(filename);
        if (filename == "client_master") {
            $("#add_new_clientMaster").removeClass("d-none");
            $("#add_new_clientMaster").addClass("d-block");
            $("#import_clientMaster").removeClass("d-none");
            $("#import_clientMaster").addClass("d-block");

            $("#add_new_Gst").removeClass("d-block");
            $("#add_new_Gst").addClass("d-none");
            $("#import_Gst").removeClass("d-block");
            $("#import_Gst").addClass("d-none");
        }else{
            $("#add_new_clientMaster").removeClass("d-block");
            $("#add_new_clientMaster").addClass("d-none");
            $("#import_clientMaster").removeClass("d-block");
            $("#import_clientMaster").addClass("d-none");
        }*/
        $(".closeAlert").click(function () {
            $("#updateSuccessDIV").removeClass("d-block");
            $("#updateSuccessDIV").addClass("d-none");
            $("#insertSuccessDIV").removeClass("d-block");
            $("#insertSuccessDIV").addClass("d-none");
            $("#deleteSuccessDIV").removeClass("d-block");
            $("#deleteSuccessDIV").addClass("d-none");
        });
        $(".readonly").keydown(function(e){
            e.preventDefault();
        });
    });
</script>