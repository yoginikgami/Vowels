<?php 
    session_start();
    include_once '../connection.php';
    if (isset($_SESSION['user_id'])) {
        header("Location: Dashboard");
        exit();
    }
    if (isset($_SESSION['change_Status'])) {
        if ($_SESSION['change_Status'] == "Allowed") {
            header("Location: changePassword");
            exit();
        }
    }

    if (isset($_POST['userEmail'])) {
        $UpdateQuery_sql = "UPDATE `users` SET `verified` = '0' WHERE `username` = '".$_POST['userEmail']."'";
        $runUpdate = mysqli_query($con,$UpdateQuery_sql);
        if ($runUpdate) {
            //echo $_POST['userEmail'];
            $msg = "Congratulations, your email is  verified. Please use login id and and password to signin";
            $class = "alert alert-success";
        }
    }
    if (isset($_POST['registerSuccess'])) {
        //echo "rok";
        $msg = "Registration Successfull Please verify your email id";
        $class = "alert alert-success";
    }
    if (isset($_POST['loginUserBtn'])) {
        if (isset($_POST['username']) && isset($_POST['password'])) {
            $fetchAdminSQL = "SELECT * FROM `users` WHERE `username` = '".$_POST['username']."' AND `password` = '".sha1($_POST['password'])."'";
            $runAdmin = mysqli_query($con,$fetchAdminSQL);
            $rows = mysqli_num_rows($runAdmin);
            $userdata = mysqli_fetch_array($runAdmin);

            $fetchClientSQL = "SELECT * FROM `client_master` WHERE `email_1` = '".$_POST['username']."' AND `password` = '".$_POST['password']."'";
            $runClient = mysqli_query($con,$fetchClientSQL);
            $rowsClient = mysqli_num_rows($runClient);
            $clientdata = mysqli_fetch_array($runClient);

            if($rows > 0){
                $_SESSION['user_type'] = 'system_user';
                $_SESSION['login_type'] = $userdata['type'];
                if ($userdata['user_type'] == 'company') {
                    $fetchCompanyApprove = "SELECT * FROM `company_profile` WHERE `email_id` = '".$_POST['username']."'";
                    $runApprovedSQL = mysqli_query($con,$fetchCompanyApprove);
                    $rowsApproved = mysqli_num_rows($runApprovedSQL);
                    $ApprovedData = mysqli_fetch_array($runApprovedSQL);
                    if ($ApprovedData['approved'] != '1') {
                        $msg = "You Can't Login without Approve Your Company by Admin!";
                        $class = "alert alert-danger"; 
                    }else if ($ApprovedData['approved'] == '1') {
                        if (!empty($_POST['user_remember'])) {
                            setcookie("login_VowelUser",$_POST['username'],time()+(10*365*24*60*60));
                            setcookie("password_VowelUser",$_POST['password'],time()+(10*365*24*60*60));
                            //echo "user_remember";
                        }else {         
                            if (isset($_COOKIE['login_VowelUser'])) {
                                setcookie("login_VowelUser","");                
                            }
                            if (isset($_COOKIE['password_VowelUser'])) {
                                setcookie("password_VowelUser","");             
                            }
                            //echo "Not user_remember";
                        }
                        $_SESSION['user_id'] = $userdata['id'];
                        //$_SESSION['user_email'] = $userdata['username'];
                        if ($userdata['firstname'] == "") {
                            $_SESSION['username'] = $userdata['username'];
                        }else{
                            $_SESSION['username'] = $userdata['firstname'];
                        }
                        if ($userdata['admin_status'] == "") {
                            $_SESSION['admin_status'] = "0";
                        }else{
                            $_SESSION['admin_status'] = $userdata['admin_status'];
                        }
                        
                        $_SESSION['company_id'] = $userdata['company_id'];
                        $_SESSION['verified'] = $userdata['verified'];
                        if (isset($_SESSION['user_id'])) {
                            $fetch_company_data = "SELECT * FROM `company_profile` WHERE `user_id` = '".$_SESSION['user_id']."'";
                            $run_fetch_company_data = mysqli_query($con,$fetch_company_data);
                            $row = mysqli_fetch_array($run_fetch_company_data);
                            //$_SESSION['company_id'] = $row['id'];
                            
                            $fetch_user_data = "SELECT * FROM `users` WHERE `id` = '".$_SESSION['user_id']."'";
                            $run_fetch_user_data = mysqli_query($con,$fetch_user_data);
                            $row = mysqli_fetch_array($run_fetch_user_data);
                            if ($row['reports']) {
                                $_SESSION['page'] = "reports";
                            }else if ($row['client_master']) {
                                $_SESSION['page'] = "client_master";
                            }else if ($row['dsc_subscriber']) {
                                $_SESSION['page'] = "dsc_subscriber";
                            }else if ($row['dsc_reseller']) {
                                $_SESSION['page'] = "dsc_reseller";
                            }else if ($row['pan']) {
                                $_SESSION['page'] = "pan";
                            }else if ($row['tan']) {
                                $_SESSION['page'] = "tan";
                            }else if ($row['it_returns']) {
                                $_SESSION['page'] = "it_returns";
                            }else if ($row['e_tds']) {
                                $_SESSION['page'] = "e_tds";
                            }else if ($row['gst']) {
                                $_SESSION['page'] = "gst";
                            }else if ($row['other_services']) {
                                $_SESSION['page'] = "other_services";
                            }else if ($row['psp']) {
                                $_SESSION['page'] = "psp";
                            }else if ($row['psp_coupon_consumption']) {
                                $_SESSION['page'] = "psp_coupon_consumption";
                            }else if ($row['payment']) {
                                $_SESSION['page'] = "payment";
                            }else if ($row['tender']) {
                                $_SESSION['page'] = "tender";
                            }
                        }
                        //echo $_SESSION['page'];
                        //$array = array('data' => 'Valid User', 'page' => $_SESSION['page']);
                        //echo json_encode($array);
                        header("Location: Dashboard");
                        exit();
                    }
                }else{
                    //$fetchAdminSQL = "SELECT * FROM `users` WHERE `username` = '".$_POST['username']."' AND `password` = '".sha1($_POST['password'])."'";
                    //$runAdmin = mysqli_query($con,$fetchAdminSQL);
                    //$rows = mysqli_num_rows($runAdmin);
                    //echo '<span class="text-danger">Username Already Exists..!</span>';
                    
                    if (!empty($_POST['user_remember'])) {
                        setcookie("login_VowelUser",$_POST['username'],time()+(10*365*24*60*60));
                        setcookie("password_VowelUser",$_POST['password'],time()+(10*365*24*60*60));
                        //echo "user_remember";
                    }else {         
                        if (isset($_COOKIE['login_VowelUser'])) {
                            setcookie("login_VowelUser","");                
                        }
                        if (isset($_COOKIE['password_VowelUser'])) {
                            setcookie("password_VowelUser","");             
                        }
                        //echo "Not user_remember";
                    }
                    $_SESSION['user_id'] = $userdata['id'];
                    if ($userdata['firstname'] == "") {
                        $_SESSION['username'] = $userdata['username'];
                    }else{
                        $_SESSION['username'] = $userdata['firstname'];
                    }
                    if ($userdata['admin_status'] == "") {
                        $_SESSION['admin_status'] = "0";
                    }else{
                        $_SESSION['admin_status'] = $userdata['admin_status'];
                    }
                    
                    $_SESSION['company_id'] = $userdata['company_id'];
                    $_SESSION['verified'] = $userdata['verified'];
                    if (isset($_SESSION['user_id'])) {
                        $fetch_company_data = "SELECT * FROM `company_profile` WHERE `user_id` = '".$_SESSION['user_id']."'";
                        $run_fetch_company_data = mysqli_query($con,$fetch_company_data);
                        $row = mysqli_fetch_array($run_fetch_company_data);
                        //$_SESSION['company_id'] = $row['id'];
                        
                        $fetch_user_data = "SELECT * FROM `users` WHERE `id` = '".$_SESSION['user_id']."'";
                        $run_fetch_user_data = mysqli_query($con,$fetch_user_data);
                        $row = mysqli_fetch_array($run_fetch_user_data);
                        if ($row['reports']) {
                            $_SESSION['page'] = "reports";
                        }else if ($row['client_master']) {
                            $_SESSION['page'] = "client_master";
                        }else if ($row['dsc_subscriber']) {
                            $_SESSION['page'] = "dsc_subscriber";
                        }else if ($row['dsc_reseller']) {
                            $_SESSION['page'] = "dsc_reseller";
                        }else if ($row['pan']) {
                            $_SESSION['page'] = "pan";
                        }else if ($row['tan']) {
                            $_SESSION['page'] = "tan";
                        }else if ($row['it_returns']) {
                            $_SESSION['page'] = "it_returns";
                        }else if ($row['e_tds']) {
                            $_SESSION['page'] = "e_tds";
                        }else if ($row['gst']) {
                            $_SESSION['page'] = "gst";
                        }else if ($row['other_services']) {
                            $_SESSION['page'] = "other_services";
                        }else if ($row['psp']) {
                            $_SESSION['page'] = "psp";
                        }else if ($row['psp_coupon_consumption']) {
                            $_SESSION['page'] = "psp_coupon_consumption";
                        }else if ($row['payment']) {
                            $_SESSION['page'] = "payment";
                        }else if ($row['tender']) {
                            $_SESSION['page'] = "tender";
                        }
                    }
                    //echo $_SESSION['page'];
                    //$array = array('data' => 'Valid User', 'page' => $_SESSION['page']);
                    //echo json_encode($array);
                    header("Location: user_dashboard");
                    exit();
                    //}
                }//Simpale User End Block
            }else if ($rowsClient > 0) {
                $tempLoginPushed = false;
                if ($tempLoginPushed == false) {
                    $_SESSION['user_type'] = 'client_user';
                    if (!empty($_POST['user_remember'])) {
                        setcookie("login_VowelUser",$_POST['username'],time()+(10*365*24*60*60));
                        setcookie("password_VowelUser",$_POST['password'],time()+(10*365*24*60*60));
                        //echo "user_remember";
                    }else {         
                        if (isset($_COOKIE['login_VowelUser'])) {
                            setcookie("login_VowelUser","");                
                        }
                        if (isset($_COOKIE['password_VowelUser'])) {
                            setcookie("password_VowelUser","");             
                        }
                        //echo "Not user_remember";
                    }
                    $_SESSION['user_id'] = $clientdata['id'];
                    if ($clientdata['client_name'] == "") {
                        $_SESSION['username'] = $clientdata['email_1'];
                    }else{
                        $_SESSION['username'] = $clientdata['client_name'];
                    }
                    /*if ($clientdata['admin_status'] == "") {
                        $_SESSION['admin_status'] = "0";
                    }else{
                        $_SESSION['admin_status'] = $clientdata['admin_status'];
                    }*/
                    $_SESSION['company_id'] = $clientdata['company_id'];
                    $_SESSION['service_id'] = $clientdata['transaction_id'];
    
                    if ($rowsClient['reports']) {
                        $_SESSION['page'] = "reports";
                    }else if ($rowsClient['client_master']) {
                        $_SESSION['page'] = "client_master";
                    }else if ($rowsClient['dsc_subscriber']) {
                        $_SESSION['page'] = "dsc_subscriber";
                    }else if ($rowsClient['dsc_reseller']) {
                        $_SESSION['page'] = "dsc_reseller";
                    }else if ($rowsClient['pan']) {
                        $_SESSION['page'] = "pan";
                    }else if ($rowsClient['tan']) {
                        $_SESSION['page'] = "tan";
                    }else if ($rowsClient['it_returns']) {
                        $_SESSION['page'] = "it_returns";
                    }else if ($rowsClient['e_tds']) {
                        $_SESSION['page'] = "e_tds";
                    }else if ($rowsClient['gst']) {
                        $_SESSION['page'] = "gst";
                    }else if ($rowsClient['other_services']) {
                        $_SESSION['page'] = "other_services";
                    }else if ($rowsClient['psp']) {
                        $_SESSION['page'] = "psp";
                    }else if ($rowsClient['psp_coupon_consumption']) {
                        $_SESSION['page'] = "psp_coupon_consumption";
                    }else if ($rowsClient['payment']) {
                        $_SESSION['page'] = "payment";
                    }else if ($rowsClient['tender']) {
                        $_SESSION['page'] = "tender";
                    }
                    header("Location: Dashboard");
                    exit();
                }else{
                    $msg = "Client login is in under maintenance";
                    $class = "alert alert-danger";
                }
            }else{
                //echo "Invalid User";
                //$array = array('data' => 'Invalid User');
                //echo json_encode($array);
                $msg = "Invalid Username or Password";
                $class = "alert alert-danger";
            }
        }
    }
?>
<!DOCTYPE html>
<html dir="ltr">

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
    <link href="dist/css/style.min.css" rel="stylesheet">

    <link rel="stylesheet" href="dist/notifications.css">
    <script src="dist/notifications.js"></script>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
<style type="text/css">
    #showPassword:hover{
        cursor: pointer;
    }
    #registerLink{
        color: #FFF;
        border-bottom: 1px solid #FFF;
        font-size: 16px;
    }
    #registerLink:hover{
        color: #00F;
        border-bottom: 1px solid #00F;
    }
</style>
</head>

<body>
    
    <?php //print_r($_COOKIE);
//echo $_COOKIE['login_VowelUser']; ?>
    <div class="main-wrapper">
        <!-- ============================================================== -->
        <!-- Preloader - style you can find in spinners.css -->
        <!-- ============================================================== -->
        <div class="preloader">
            <div class="lds-ripple">
                <div class="lds-pos"></div>
                <div class="lds-pos"></div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- Preloader - style you can find in spinners.css -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Login box.scss -->
        <!-- ============================================================== -->
        <div class="auth-wrapper d-flex no-block justify-content-center align-items-center bg-dark">
            <div class="auth-box bg-dark border-secondary" style="//margin-top: 0px;">
                <div id="loginform">
                    <div class="text-center p-t-20 p-b-20">
                        <span class="db" class=""><img src="html/images/logo.png" class="bg-dark" alt="logo" style="width: 30%;" /></span>
                        <!-- <p style="color: #fff; margin: 0px; font-size: 17px;">Clienserv</p> -->
                        <!-- <p style="color: #fff; margin: 0px; font-size: 17px;">Minute Data Analyzer</p> -->
                    </div>
                    <!-- Form -->
                    <form class="form-horizontal m-t-20" id="loginform" method="post">
                        <div class="row p-b-30">
                            <div class="col-12">
                                <?php
                                    if (isset($_SESSION['msg'])) {
                                        ?>
                                        <div class="<?php echo $_SESSION['class']." alert-dismissible fade show" ?>">
                                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                                          <?php echo $_SESSION['msg']; ?>
                                        </div>
                                        <?php
                                        session_destroy();
                                    }
                                    if (isset($_POST['loginUserBtn']) || isset($_POST['registerSuccess']) || isset($_POST['userEmail'])) {
                                        ?>
                                        <div class="<?php echo $class." alert-dismissible fade show" ?>">
                                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                                          <?php echo $msg; ?>
                                        </div>
                                        <?php
                                    }
                                ?>
                                <span id="username-status"></span>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-success text-white" id="basic-addon1"><i class="ti-user"></i></span>
                                    </div>
                                    <input type="text" required class="form-control form-control-lg" placeholder="Username" aria-label="Username" name="username" aria-describedby="basic-addon1" id="username" autofocus value="<?php if(isset($_COOKIE['login_VowelUser'])) echo $_COOKIE['login_VowelUser']; ?>">
                                </div>
                                <span id="password-status"></span>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-warning text-white" id="basic-addon2"><i class="ti-pencil"></i></span>
                                    </div>
                                    <input type="password" required class="form-control form-control-lg" placeholder="Password" aria-label="Password" name="password" aria-describedby="basic-addon1" id="password" value="<?php if(isset($_COOKIE['password_VowelUser'])) echo $_COOKIE['password_VowelUser']; ?>">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-info text-white" id="basic-addon2"><a class="" id="showPassword"><i id="passIcon" class="fas fa-eye-slash"></i></a></span>
                                    </div>
                                </div>
                                
                                <div class="row d-flex justify-content-center fadeIn fourth">
                                      <div class="custom-control custom-checkbox pl-2" style="width: 143px;">
                                    <input type="checkbox" class="custom-control-input " id="user_remember" name="user_remember" <?php if(isset($_COOKIE["login_VowelUser"])) { echo "checked"; } ?> >
                                    <label class="custom-control-label pl-3 text-white" for="user_remember">Remember me</label>
                                  </div>
                                </div>
                                <!--button type="button" id="loginUserBtn" class="fadeIn fifth">Log In</button-->
                            </div>
                        </div>
                        <div class="row border-top border-secondary">
                            <div class="col-12">
                                <div class="form-group">
                                    <div class="p-t-20">
                                        <button class="btn btn-info" id="to-recover" type="button"><i class="fa fa-lock m-r-5"></i> Lost password?</button>
                                        <button type="submit" class="btn btn-success float-right" name="loginUserBtn" id="loginUserBtn">Login</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row border-top border-secondary">
                            <div class="col-12 text-center">
                                <div class="form-group">
                                    <div class="p-t-20">
                                        <a href="https://www.vowelindia.com/services/dsc-fc-portal-creation-form/" id="registerLink">Not registered yet? Click here.</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <?php 
                    //OTP Function
                    function generateNumericOTP($n) {
                        $generator = "r1At3eGu5kDg7dJs9aWb0cTx2lQp4oCw6bXv8jZ";
                        $result = ""; 
                        for ($i = 1; $i <= $n; $i++) { 
                            $result .= substr($generator, (rand()%(strlen($generator))), 1); 
                        } 
                        // Return result 
                        return $result; 
                    }
                    $msg = "Null";
                    $class = "Null";
                    $msg2 = "Null";
                    $class2 = "Null";
                    if (isset($_POST['recoverBtn'])) {
                        $recoverEmail = $_POST['recoverEmail'];
                        $checkExistSQL = "SELECT * FROM `users` WHERE `username` = '".$recoverEmail."'";
                        $run_checkExistSQL = mysqli_query($con,$checkExistSQL);
                        $row_Exist = mysqli_num_rows($run_checkExistSQL);
                        $msg2 = "Null";
                        $class2 = "Null";
                        if ($row_Exist > 0) {
                            $msg = "Valid Email Id";
                            $class = "alert alert-success";
                            $OTP = generateNumericOTP(16);
                            $to = $recoverEmail;
                            $subject = "Forgot Password OTP";
                            $html = "
                            <table>
                                 <tr>
                                    <th><p>Dear User,<br>We received your request to access your Vowel Account through your email address.<br> Your Email verification code is: $OTP</p><br><hr>
                                  <p style='color:red;'>Note: This is a system generated mail. Please do not reply to it.</p></th>
                                    
                                </tr>
                                  <tr>
                                    
                                  </tr>
                                  <tr>
                                    
                                  </tr>
                                  <tr>
                                    
                                  </tr>
                                  <tr>
                                    
                                  </tr>
                                  <tr>
                                    <td>Thank You</td>
                                  </tr>
                                  <tr>
                                    <td>With Regards</td>
                                  </tr>
                                  <tr>
                                    <td>Vowel Enterprise</td>
                                  </tr>
                            </table>";
                            $body = $html;
                                ini_set('display_errors',1);
                                error_reporting(E_ALL);
                                $from='donotreply@clienserv.com';
                                //$to=$_POST['send_email'];
                                $message=$body;
                                $headers = "From: Vowel Enterprise <".$from.">\n";
                                // $headers .= 'X-Mailer: PHP/' . phpversion();
                                //$headers .= "X-Priority: 1\n";
                                // $headers .= "MIME-Version: 1.0\r\n";
                                // $headers .= "X-Mailer: PHP/" . phpversion() . "\r\n";
                                $headers .= " " . "\r\n";
                                $headers .= "Content-Type: text/html; charset=iso-8859-1\r\n\r\n";
                                //$headers .= "Content-Type: multipart/mixed; charset=iso-8859-1\n";
                                $mailer = mail($to,$subject,$message,$headers);
                                if($mailer){                
                                        echo "send_success";
                                    } else {
                                        echo "send_fail";
                                    }
                                if ($mailer == "send_success") {
                                    //echo "Registration Successfull";
                                    $updateOTP = "UPDATE `users` SET `forgotpasswordOTP` = '".$OTP."', `OTPstatus` = '1' WHERE `username` = '".$recoverEmail."'";
                                    $resultOTP = mysqli_query($con,$updateOTP);

                                    $msg2 = "OTP Sent on '".$recoverEmail."' Please Verify It";
                                    $class2 = "alert alert-success";
                                    //echo "<script type='text/javascript'> $(document).ready(function () { $('#SubmitSuccessRegistration').submit(); }); </script>";
                                    //header("Location: login");
                                    //exit();
                                }else if($mailer == "send_fail"){
                                    $msg = "Error To Send Mail.!!";
                                    $class = "alert alert-danger";
                                }else if ($mailer == "send_fail") {
                                    $msg = "Check Your Internet Connection.!!";
                                    $class = "alert alert-danger";
                                }
                          echo"The email was sent";
                        }else{
                            $msg = "Invalid Email Id.!!";
                            $class = "alert alert-danger";
                            $class2 = "alert alert-danger";
                        }
                    }

                    if (isset($_POST['verifyotp'])) {
                        $checkOTP = "SELECT `id` FROM `users` WHERE `username` = '".$_POST['forgotEmail']."' AND `forgotpasswordOTP` = '".$_POST['forgotpasswordOTP']."' AND `OTPstatus` = '1'";
                        $run_checkOTP = mysqli_query($con,$checkOTP);
                        $row_checkOTP = mysqli_num_rows($run_checkOTP);
                        if ($row_checkOTP > 0) {
                            //header("Location: changePassword");
                            //exit();
                            //echo "Right";
                            $msg2 = "Null";
                            $class = "Null";
                            $msg = "Null";
                            $class2 = "Null";

                            $_SESSION['change_Status'] = "Allowed";
                            $_SESSION['changePassword_Email'] = $_POST['forgotEmail'];
                            //header("Location: changePassword");
                            //exit();
                            //echo '<meta http-equiv="refresh" content="1; URL=changePassword.php" />';
                            echo "<script type='text/javascript'> window.location.replace('changePassword'); </script>";
                        }else{
                            $msg2 = "Invalid OTP.!!";
                            $class = "alert alert-danger";
                            $msg = "Null";
                            $class2 = "Null";
                            //echo "Invalid";
                            $_SESSION['change_Status'] = "Not Allowed";
                        }
                    }
                ?>
                <div id="recoverform">
                    <?php
                        if (isset($_POST['recoverBtn']) && ($msg == "Invalid Email Id.!!" || $msg == "Error To Send Mail.!!" || $msg == "Check Your Internet Connection.!!")) {
                            ?>
                            <div class="<?php echo $class." alert-dismissible fade show" ?>">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                              <?php echo $msg; ?>
                            </div>
                            <?php
                        }
                    ?>
                    <?php //if (isset($_POST['recoverBtn']) && $msg != "Valid Email Id") { ?>
                    <div class="text-center">
                        <span class="text-white">Enter your e-mail address below and we will send you instructions how to recover a password.</span>
                    </div>
                    <div class="row m-t-20">
                        <!-- Form -->
                        <form class="col-12" method="post">
                            <!-- email -->
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-danger text-white" id="basic-addon1"><i class="ti-email"></i></span>
                                </div>
                                <input type="text" class="form-control form-control-lg" placeholder="Email Address" aria-label="Username" name="recoverEmail" id="recoverEmail" required aria-describedby="basic-addon1" value="<?php if (isset($_POST['recoverBtn'])) { echo $_POST['recoverEmail']; } ?>">
                                <input type="hidden" name="validEmail" id="validEmail" readonly value="<?php if (isset($_POST['recoverBtn'])) { echo $msg; } ?>">
                            </div>
                            <!-- pwd -->
                            <div class="row m-t-20 p-t-20 border-top border-secondary">
                                <div class="col-12">
                                    <a class="btn btn-success" href="#" id="to-login" name="action">Back To Login</a>
                                    <button class="btn btn-info float-right" type="submit" id="recoverBtn" name="recoverBtn">Recover</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <?php 
                //}
                if ($msg == "Valid Email Id" || $class2 == "alert alert-success" || $msg2 == "Invalid OTP.!!") { ?>
                <div id="validotpform">
                    <?php
                        //if (isset($_POST['verifyotp']) && $msg == "Invalid OTP") {
                            ?>
                            <div class="<?php echo $class." alert-dismissible fade show" ?>">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                              <?php echo $msg2; ?>
                            </div>
                            <?php
                        //}
                    ?>
                    <div class="text-center">
                        <span class="text-white">Enter OTP which is send on your e-mail address.</span>
                    </div>
                    <div class="row m-t-20">
                        <!-- Form -->
                        <form class="col-12" method="post">
                            <!-- email -->
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-danger text-white" id="basic-addon1"><i class="ti-email"></i></span>
                                </div>
                                <input type="hidden" class="form-control form-control-lg" placeholder="Email Address" aria-label="Username" name="forgotEmail" id="forgotEmail" required aria-describedby="basic-addon1" value="<?php if (isset($_POST['recoverBtn'])) { echo $_POST['recoverEmail']; }else if (isset($_POST['verifyotp'])) { echo $_POST['forgotEmail']; } ?>">
                                <input type="text" name="forgotpasswordOTP" id="forgotpasswordOTP" class="form-control form-control-lg" placeholder="OTP" aria-label="Username" aria-describedby="basic-addon1" required>
                                <input type="hidden" name="validOTP" id="validOTP" readonly value="<?php if (isset($_POST['verifyotp'])) { echo $msg2; } ?>">
                            </div>
                            <!-- pwd -->
                            <div class="row m-t-20 p-t-20 border-top border-secondary">
                                <div class="col-12">
                                    <a class="btn btn-success" href="#" id="varifyto-login" name="action">Back To Login</a>
                                    <button class="btn btn-info float-right" id="verifyotp" name="verifyotp" type="submit">Verify OTP</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            <?php } ?>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- Login box.scss -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper scss in scafholding.scss -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper scss in scafholding.scss -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Right Sidebar -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Right Sidebar -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    
    <!-- All Required js -->
    <!-- ============================================================== -->
    <script src="assets/libs/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="assets/libs/popper.js/dist/umd/popper.min.js"></script>
    <script src="assets/libs/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- ============================================================== -->
    <!-- This page plugin js -->
    <!-- ============================================================== -->
    <script type="text/javascript">
        $('[data-toggle="tooltip"]').tooltip();
        $(".preloader").fadeOut();
        // ============================================================== 
        // Login and Recover Password 
        // ============================================================== 
        //$("#validotpform").hide();
        $('#to-recover').on("click", function() {
            $("#loginform").slideUp();
            //$("#validotpform").hide();
            $("#recoverform").fadeIn();
        });
        $('#to-login').click(function(){
            //$("#validotpform").hide();
            $("#recoverform").hide();
            $("#loginform").fadeIn();
        });
        $('#varifyto-login').click(function(){
            $("#validotpform").hide();
            $("#recoverform").hide();
            $("#loginform").fadeIn();
            $("#recoverEmail").val('');
        });

        if ($("#recoverEmail").val() != "") {
            $("#loginform").slideUp();
            //$("#validotpform").hide();
            $("#recoverform").fadeIn(); 
        }
        if ($("#validEmail").val() == "Valid Email Id") {
            $("#loginform").slideUp();
            $("#recoverform").hide();
            $("#validotpform").fadeIn(); 
        }
        if ($("#validOTP").val() == "Invalid OTP.!!") {
            $("#loginform").slideUp();
            $("#recoverform").hide();
            $("#validotpform").fadeIn();
            //$("#forgotEmail").val($("#recoverEmail").val());
        }

        $('#showPassword').click(function(){
            if('password' == $('#password').attr('type')){
                 $('#password').prop('type', 'text');
                 $('#passIcon').removeClass('fas fa-eye-slash');
                 $('#passIcon').addClass('fas fa-eye');
            }else{
                 $('#password').prop('type', 'password');
                 $('#passIcon').removeClass('fas fa-eye');
                 $('#passIcon').addClass('fas fa-eye-slash');
            }
        });
    </script>
<!--script type="text/javascript">
    $(document).ready(function(){
      /*$('#loginUserBtn').click(function(){
        var username = $('#username').val();
        var password = $('#password').val();
        var user_remember = $('#user_remember').prop("checked");
        if (username == "") {
          $('#username-status').html('Please Enter Username!').css({'color':'red'});
          $('#username').addClass('border-danger');
        }else if (username != "") {
          $('#username-status').html('').css({'color':'green'});
          $('#username').removeClass('border-danger');
        }
        if (password == "") {
          $('#password-status').html('Please Enter Password!').css({'color':'red'});
          $('#password').addClass('border-danger');
        }else if (password != "") {
          $('#password-status').html('').css({'color':'green'});
          $('#password').removeClass('border-danger');
        }
        if (username != "" && password != "") {
          $.ajax({
            url:"html/adminloginProcess.php",
            method:"post",
            data: {username:username, password:password, user_remember:user_remember},
            dataType:"text",
            success:function(data)
            {
              //alert(data);
              //var page='<?php //echo $_COOKIE['login_VowelUser'] ?>';
              //alert(page);
              data = JSON.parse(data)
              if(data['data'] == "Valid User")
              { 
                //var page='<?php //echo $_COOKIE['login_VowelUser'];?>';
                //alert(data['data']); +data['page']
                $('#username').val('');
                $('#password').val('');                
                $(location).attr('href', "Dashboard");
              }
              else if(data['data'] == "Invalid User")
              {
                $('#username').val(username);
                $('#password').val(password);
                window.createNotification({
                  closeOnClick: true,
                  displayCloseButton: true,
                  positionClass: "nfc-top-right",
                  showDuration: 3000,
                  theme: "error"
                })({
                  title: "Error",
                  message: "Invalid Username or Password"
                });
              }
            }
          });
        }
      });*/
    });
  </script-->
</body>
</html>