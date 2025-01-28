<?php
	date_default_timezone_set('Asia/Kolkata');

ini_set('session.gc_maxlifetime', 43200);

// each client should remember their session id for EXACTLY 1 hour
session_set_cookie_params(43200);
session_start();
include_once '../connection.php';
include_once '../mailFunction_withoutLogin.php';


$_SESSION['LAST_ACTIVITY'] = time(); 

// $random_number = mt_rand(1000, 9999);


// Fetch username, MAC address, and random number from URL parameters
$username = isset($_GET['username']) ? $_GET['username'] : '';
$mac_address = isset($_GET['mac_address']) ? $_GET['mac_address'] : '';
$random_number = isset($_GET['random_number']) ? $_GET['random_number'] : '';
$username_from_snap = isset($_GET['username']) ? $_GET['username'] : '';
$hashed_password_snap = isset($_GET['hashed_password']) ? $_GET['hashed_password'] : '';



// error_reporting(E_ALL);
// ini_set('display_errors', 1);


// Run the SQL query
$updat = "Select * from `temp_login_app` WHERE mac_address='" . $mac_address . "' and random_number='" . $random_number . "' and username='".$username_from_snap."' and active=1";
$ru = mysqli_query($con, $updat);
$value=mysqli_num_rows($ru);
// echo $data_val=$value['two'];
if($value>0){
    if($_SESSION['random_number'] = $random_number){
        $_SESSION['mac_address'] = $mac_address;
        
    $updat = "UPDATE `temp_login_app` SET `random_number`='',two='".$random_number."' WHERE mac_address='" . $mac_address . "' and random_number='" . $random_number . "'";
    $ru = mysqli_query($con, $updat);
}
}



$fetch_id = "SELECT mac_address FROM temp_login_app where username='" . $username_from_snap . "' and mac_address='".$_SESSION['mac_address']."' and two='".$_SESSION['random_number']."'";
$run_query = mysqli_query($con, $fetch_id);
if($run_query){
            $fetchAdminSQL = "SELECT * FROM `users` WHERE `username` = '" . $username_from_snap . "' AND `password` = '" . $hashed_password_snap . "'";
            $runAdmin = mysqli_query($con, $fetchAdminSQL);
            $rows12 = mysqli_num_rows($runAdmin);
            // $check_ad=mysqli_fetch_array($runAdmin);
            $userdata = mysqli_fetch_array($runAdmin);
            $free_mac=$userdata['two_step_veri'];
            if($free_mac==0){
                if($rows12 > 0){
                    if($userdata['user_status'] != '0'){
                        $msg = "You Can't Login without Approve Your Company by Adminmcksdnfvkldsnvlksdnvs!";
                            $class = "alert alert-danger"; 
                    $_SESSION['user_type'] = 'system_user';
                    $_SESSION['login_type'] = $userdata['type'];
                    if ($userdata['user_type'] == 'company') {
                        $fetchCompanyApprove = "SELECT * FROM `company_profile` WHERE `email_id` = '".$_POST['username']."'";
                        $runApprovedSQL = mysqli_query($con,$fetchCompanyApprove);
                        $rowsApproved = mysqli_num_rows($runApprovedSQL);
                        $ApprovedData = mysqli_fetch_array($runApprovedSQL);
                        if ($ApprovedData['approved'] != '1') {
                            $msg = "You Can't Login without Approve Your Company by Admin!vdskvnld";
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
                                $_SESSION['employee_id'] = $userdata['user_id'];
                            }else{
                                $_SESSION['username'] = $userdata['firstname'];
                                $_SESSION['employee_id'] = $userdata['user_id'];
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
                                }else if ($row['tax_invoice']) {
                                    $_SESSION['page'] = "tax_invoice";
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
                                }else if ($row['e_tender']) {
                                    $_SESSION['page'] = "e_tender";
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
                            $_SESSION['employee_id'] = $userdata['user_id'];
                        }else{
                            $_SESSION['username'] = $userdata['firstname'];
                            $_SESSION['employee_id'] = $userdata['user_id'];
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
                            }else if ($row['tax_invoice']) {
                                $_SESSION['page'] = "tax_invoice";
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
                            }else if ($row['e_tender']) {
                                $_SESSION['page'] = "e_tender";
                            }else if ($row['tender']) {
                                $_SESSION['page'] = "tender";
                            }
                        }
                        //echo $_SESSION['page'];
                        //$array = array('data' => 'Valid User', 'page' => $_SESSION['page']);
                        //echo json_encode($array);
                        header("Location: Dashboard");
                        exit();
                        //}
                    }//Simpale User End Block
                }
                }
            }else{
                $fetchAdminSQL = "SELECT * FROM `users` WHERE `username` = '" . $username_from_snap . "' AND `password` = '" . $hashed_password_snap . "'";
                $runAdmin = mysqli_query($con, $fetchAdminSQL);
                $rows = mysqli_num_rows($runAdmin);
            }
            if (isset($_POST['username']) && isset($_POST['password'])) {

                $fetchClientSQL = "SELECT * FROM `client_master` WHERE `email_1` = '" . $_POST['username'] . "' AND `password` = '" . $_POST['password'] . "'";
                $runClient = mysqli_query($con, $fetchClientSQL);
                $rowsClient = mysqli_num_rows($runClient);
                $clientdata = mysqli_fetch_array($runClient);
                }
            if($rows>0){
                $currentTimestamp = strtotime(date("Y-m-d"));
                $threshold = 30;
                $lastLoginTimestamp = strtotime($userdata['last_pass_reset']);
                // Fetch MAC address and random number from URL parameters
                $mac_address = isset($_GET['mac_address']) ? $_GET['mac_address'] : '';
                $random_number = isset($_GET['random_number']) ? $_GET['random_number'] : '';
                $username_from_snap = isset($_GET['username']) ? $_GET['username'] : '';
                
                $today_date = date("Y-m-d");
                $fetch_id = "SELECT mac_address FROM temp_login_app where username='" . $username_from_snap . "' and mac_address='".$_SESSION['mac_address']."' and two='".$_SESSION['random_number']."'";
                $run_query = mysqli_query($con, $fetch_id);
                // if($run_query){
                    
                // }
                $expectedIpAddress = array();
                while ($row = mysqli_fetch_array($run_query)) {
                    $expectedIpAddress[] = $row['mac_address'];
                }
    
                
                if (($currentTimestamp - $lastLoginTimestamp) <= 30 * 24 * 60 * 60) {
                    if($userdata['type'] == 1){
                        $otp = mt_rand(100000, 999999);
                        $user_name=$_POST['username'];
                        // $recoverEmail="vowel.sateesh@gmail.com";
                        $recoverEmail="sateesh@clienserv.com";
                        
                        // $recoverEmail="shubhampal2120@gmail.com";
                        
                        $insert_otp="insert into `otp_varify` (`user_name`,`value`)values ('".$user_name."','".$otp."')";
                        $run_qury=mysqli_query($con,$insert_otp);
                        
                        if($run_qury){
                            $returnSthana = sthanamail($recoverEmail,'<html>
    					<body>
    					<div>
    						OTP id '.$otp.'
    						
    					</div>
    					<hr>
    						<p style="color:red;">Note: This is a system generated mail. Please do not reply to it. For any further query please contact</p>
    					</body>
    					</html>',"Clienserv - Record Created");?>
    					
    					<?php 
    					if ($returnSthana == "send_success") {
    					    ?>
    					    <div id="simpleModal1" class="modal" data-backdrop='static' tabindex="-1" role="dialog">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" style="font-size: 20px;">Email OTP Verification</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form method="post">
                                        <div class="modal-body">
                                            <div class="form-row">
                                                <label style="font-size: 15px;">A OTP (One Time Passcode) has been sent to
                                                    <b>satee.....cli.....com</b>
                                                    Please enter the OTP in the field below to verify your Email.</label>
                                                <div class="form-group col-md-9 text-center">
                                                    <input type="hidden" name="username" id="username"
                                                        value="<?php echo $_POST['username']; ?>">
                                                    <input type="hidden" name="password" id="password"
                                                        value="<?php echo $_POST['password']; ?>">
                                                    <div class="input-group">
                                                        <input type="text" name="otp" class="form-control" placeholder="Enter OTP"
                                                            style="border: 1px solid black;" required>&nbsp;&nbsp;&nbsp;&nbsp;
                                                        <div class="input-group-append">
                                                            <input type="submit" name="send_request1" class="btn btn-success" value="Login"
                                                                style="height: 100%;">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <!--Re-send OTP-->
                                                <!--<p>Re-send OTP After </p><br>-->
                                                <a href="#" id="myLink12">Re-Send OTP</a> After <span id="countdown">60 </span> &nbsp; Second
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
    					    <?php
    					}
    					?>
    					
    
                        <script>
                            $(document).ready(function () {
                                $("#myLink12").on("click", function (e) {
                                    console.log("Link clicked");
                                    e.preventDefault();
                                    alert("Hello");
    
                                    // Perform AJAX request to generate a new OTP
                                    $.ajax({
                                        type: "POST",
                                        url: "html/your_php_script.php", // Replace with the actual path to your PHP script
                                        success: function (response) {
                                            if (response === "success") {
                                                // Display the modal with the new OTP
                                                $('#simpleModal1').modal('show');
                                            } else {
                                                // Handle the error or show a message to the user
                                                alert("Error generating OTP.");
                                            }
                                        }
                                    });
                                });
                            });
                        </script>
                        <script>
                            // Set the countdown time in seconds
                            let countdownTime = 60;
    
                            // Function to update the countdown timer
                            function updateCountdown() {
                                const countdownElement = document.getElementById("countdown");
                                countdownElement.textContent = countdownTime;
    
                                if (countdownTime <= 0) {
                                    // Enable the link
                                    const myLink = document.getElementById("myLink");
                                    myLink.style.color = ""; // Reset the color
                                    myLink.style.pointerEvents = "auto"; // Enable pointer events
                                    myLink.href = "https://example.com"; // Set the link's destination
                                    countdownElement.textContent = "";
                                } else {
                                    countdownTime--;
                                    setTimeout(updateCountdown, 1000); // Update the countdown every second
                                }
                            }
    
                            // Start the countdown
                            updateCountdown();
                        </script>
                        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
                            integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
                            crossorigin="anonymous"></script>
                        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
                            integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous" />
                        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
                            integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
                            crossorigin="anonymous"></script>
                        <script type="text/javascript">
                            window.onload = function () {
                                OpenBootstrapPopup();
                            };
                            function OpenBootstrapPopup() {
                                $("#simpleModal1").modal('show');
                            }
                        </script>
    					<?php
                        }
                    }elseif(!empty($expectedIpAddress)){
                        
                        
                        
                        echo $_SESSION['user_type'] = 'system_user';
                        echo $_SESSION['login_type'] = $userdata['type'];
                        // print_r($expectedIpAddress);
                        // echo "dscf";
                        if($userdata['user_type'] == 'company'){
                            
                            $fetchCompanyApprove = "SELECT * FROM `company_profile` WHERE `email_id` = '" . $_POST['username'] . "'";
                            $runApprovedSQL = mysqli_query($con, $fetchCompanyApprove);
                            $rowsApproved = mysqli_num_rows($runApprovedSQL);
                            $ApprovedData = mysqli_fetch_array($runApprovedSQL);
                            if ($ApprovedData['approved'] != '1') {
                                $msg = "You Can't Login without Approve Your Company by Admin!";
                                $class = "alert alert-danger";
                            } else if ($ApprovedData['approved'] == '1') {
                                if (!empty($_POST['user_remember'])) {
                                    setcookie("login_VowelUser", $_POST['username'], time() + (10 * 365 * 24 * 60 * 60));
                                    setcookie("password_VowelUser", $_POST['password'], time() + (10 * 365 * 24 * 60 * 60));
                                    //echo "user_remember";
                                } else {
                                    if (isset($_COOKIE['login_VowelUser'])) {
                                        setcookie("login_VowelUser", "");
                                    }
                                    if (isset($_COOKIE['password_VowelUser'])) {
                                        setcookie("password_VowelUser", "");
                                    }
                                    //echo "Not user_remember";
                                }
                                $_SESSION['user_id'] = $userdata['id'];
                                //$_SESSION['user_email'] = $userdata['username'];
                                if ($userdata['firstname'] == "") {
                                    $_SESSION['username'] = $userdata['username'];
                                    $_SESSION['employee_id'] = $userdata['user_id'];
                                } else {
                                    $_SESSION['username'] = $userdata['firstname'];
                                    $_SESSION['employee_id'] = $userdata['user_id'];
                                }
                                if ($userdata['admin_status'] == "") {
                                    $_SESSION['admin_status'] = "0";
                                } else {
                                    $_SESSION['admin_status'] = $userdata['admin_status'];
                                }
    
                                $_SESSION['company_id'] = $userdata['company_id'];
                                $_SESSION['verified'] = $userdata['verified'];
                                if (isset($_SESSION['user_id'])) {
                                    $fetch_company_data = "SELECT * FROM `company_profile` WHERE `user_id` = '" . $_SESSION['user_id'] . "'";
                                    $run_fetch_company_data = mysqli_query($con, $fetch_company_data);
                                    $row = mysqli_fetch_array($run_fetch_company_data);
                                    //$_SESSION['company_id'] = $row['id'];
    
                                    $fetch_user_data = "SELECT * FROM `users` WHERE `id` = '" . $_SESSION['user_id'] . "'";
                                    $run_fetch_user_data = mysqli_query($con, $fetch_user_data);
                                    $row = mysqli_fetch_array($run_fetch_user_data);
                                    if ($row['reports']) {
                                        $_SESSION['page'] = "reports";
                                    } else if ($row['client_master']) {
                                        $_SESSION['page'] = "client_master";
                                    } else if ($row['dsc_subscriber']) {
                                        $_SESSION['page'] = "dsc_subscriber";
                                    } else if ($row['dsc_reseller']) {
                                        $_SESSION['page'] = "dsc_reseller";
                                    } else if ($row['pan']) {
                                        $_SESSION['page'] = "pan";
                                    } else if ($row['tan']) {
                                        $_SESSION['page'] = "tan";
                                    } else if ($row['it_returns']) {
                                        $_SESSION['page'] = "it_returns";
                                    } else if ($row['e_tds']) {
                                        $_SESSION['page'] = "e_tds";
                                    } else if ($row['gst']) {
                                        $_SESSION['page'] = "gst";
                                    } else if ($row['other_services']) {
                                        $_SESSION['page'] = "other_services";
                                    } else if ($row['psp']) {
                                        $_SESSION['page'] = "psp";
                                    } else if ($row['psp_coupon_consumption']) {
                                        $_SESSION['page'] = "psp_coupon_consumption";
                                    } else if ($row['payment']) {
                                        $_SESSION['page'] = "payment";
                                    } else if ($row['tender']) {
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
                                setcookie("login_VowelUser", $_POST['username'], time() + (10 * 365 * 24 * 60 * 60));
                                setcookie("password_VowelUser", $_POST['password'], time() + (10 * 365 * 24 * 60 * 60));
                                //echo "user_remember";
                            } else {
                                if (isset($_COOKIE['login_VowelUser'])) {
                                    setcookie("login_VowelUser", "");
                                }
                                if (isset($_COOKIE['password_VowelUser'])) {
                                    setcookie("password_VowelUser", "");
                                }
                                //echo "Not user_remember";
                            }
                            $_SESSION['user_id'] = $userdata['id'];
                            if ($userdata['firstname'] == "") {
                                $_SESSION['username'] = $userdata['username'];
                                $_SESSION['employee_id'] = $userdata['user_id'];
                            } else {
                                $_SESSION['username'] = $userdata['firstname'];
                                $_SESSION['employee_id'] = $userdata['user_id'];
                            }
                            if ($userdata['admin_status'] == "") {
                                $_SESSION['admin_status'] = "0";
                            } else {
                                $_SESSION['admin_status'] = $userdata['admin_status'];
                            }
    
                            $_SESSION['company_id'] = $userdata['company_id'];
                            $_SESSION['verified'] = $userdata['verified'];
                            if (isset($_SESSION['user_id'])) {
                                $fetch_company_data = "SELECT * FROM `company_profile` WHERE `user_id` = '" . $_SESSION['user_id'] . "'";
                                $run_fetch_company_data = mysqli_query($con, $fetch_company_data);
                                $row = mysqli_fetch_array($run_fetch_company_data);
                                //$_SESSION['company_id'] = $row['id'];
    
                                $fetch_user_data = "SELECT * FROM `users` WHERE `id` = '" . $_SESSION['user_id'] . "'";
                                $run_fetch_user_data = mysqli_query($con, $fetch_user_data);
                                $row = mysqli_fetch_array($run_fetch_user_data);
                                if ($row['reports']) {
                                    $_SESSION['page'] = "reports";
                                } else if ($row['client_master']) {
                                    $_SESSION['page'] = "client_master";
                                } else if ($row['dsc_subscriber']) {
                                    $_SESSION['page'] = "dsc_subscriber";
                                } else if ($row['dsc_reseller']) {
                                    $_SESSION['page'] = "dsc_reseller";
                                } else if ($row['pan']) {
                                    $_SESSION['page'] = "pan";
                                } else if ($row['tan']) {
                                    $_SESSION['page'] = "tan";
                                } else if ($row['it_returns']) {
                                    $_SESSION['page'] = "it_returns";
                                } else if ($row['e_tds']) {
                                    $_SESSION['page'] = "e_tds";
                                } else if ($row['gst']) {
                                    $_SESSION['page'] = "gst";
                                } else if ($row['other_services']) {
                                    $_SESSION['page'] = "other_services";
                                } else if ($row['psp']) {
                                    $_SESSION['page'] = "psp";
                                } else if ($row['psp_coupon_consumption']) {
                                    $_SESSION['page'] = "psp_coupon_consumption";
                                } else if ($row['payment']) {
                                    $_SESSION['page'] = "payment";
                                } else if ($row['tender']) {
                                    $_SESSION['page'] = "tender";
                                }
                            }
                            //echo $_SESSION['page'];
                            //$array = array('data' => 'Valid User', 'page' => $_SESSION['page']);
                            //echo json_encode($array);
                            header("Location: Dashboard");
                            exit();
                            //}
                        
                        }
                      
                    }else{
                        ?>
                         <div id="simpleModal" class="modal" data-backdrop='static' tabindex="-1" role="dialog">
                            <div class="modal-dialog" role="document">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h4 class="modal-title">Request for Approval</h4>
                                  <!--<button type="button" class="close" data-dismiss="modal" aria-label="Close">-->
                                  <!--  <span aria-hidden="true">&times;</span>-->
                                  <!--</button>-->
                                </div>
                                <div class="modal-body">
                                  <p>Please click the 'Download' button and run the executable file after entering your username for approval.</p>
                                  <a href="send_mac.exe" class="download-button">Download</a>
                                </div>
                              </div>
                            </div>
                          </div>
                        
                        <!--</div>-->
    
    
                        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
                            integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
                            crossorigin="anonymous"></script>
                        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
                            integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous" />
                        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
                            integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
                            crossorigin="anonymous"></script>
                        <script type="text/javascript">
                            window.onload = function () {
                                OpenBootstrapPopup();
                            };
                            function OpenBootstrapPopup() {
                                $("#simpleModal").modal('show');
                            }
                        </script>
                        
                        <?php
                    }
                } else {
                    ?>
                    <div id="simpleModal1111" class="modal" data-backdrop='static' tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" style="font-size: 20px;">New Password Generation</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form method="post">
                                <div id="message" style="font-size: 18px; color: red; font-weight: bold;"></div>
                                <div class="modal-body">
                                    <div class="form-row">
                                        <div class="form-group col text-center">
                                            <label for="inputEmail4" style="font-size: 18px;">Enter New Password</label>
                                            <input type="hidden" name="username" id="username" value="<?php echo $_GET['username']; ?>">
                                            <input type="hidden" name="password" id="oldPassword" value="<?php echo $_GET['hashed_password']; ?>">
                                            <input type="password" class="form-control" style="border: 1px solid black;"
                                                placeholder="Enter Your Name" name="pass_new" id="pass_new" required>
                                        </div>
                                        <div class="form-group col text-center">
                                            <label for="re_enter_pass" style="font-size: 18px;">Re-Enter Password</label>
                                            <input type="password" class="form-control" style="border: 1px solid black;"
                                                placeholder="Enter Your Mobile No" name="re_enter_pass" id="re_enter_pass" required>
                                        </div>
                                        
                                    </div>
                                    <div id="otpDiv" style="display: none;">
                                            <!-- OTP input fields go here -->
                                            <input type="text" class="form-control" style="border: 1px solid black;" placeholder="Enter OTP" name="otp" id="otp" required>
                                        </div>
                                    <div class="text-center">
                                        <input type="button" name="re-set_password" id="re-set_password" class="btn btn-success"
                                            value="Send Request">
                                        <input type="button" name="submit_otp" id="submit_otp" class="btn btn-success" value="submit OTP" style="display: none;">
                                    </div>
                                </div>
                            </form>
                            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                            <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
                            <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>

    
                            <script>
                                $(document).ready(function () {
                                    $("#re-set_password").click(function () {
                                        // alert("sdfsa");
                                        var username = $("#username").val();
                                        var oldPassword = $("#oldPassword").val();
                                        var newPassword = $("#pass_new").val();
                                        var confirmPassword = $("#re_enter_pass").val();
    
                                        // alert(newPassword);
    
                                        if (newPassword === oldPassword) {
                                            $("#message").html("New password cannot be the same as the old password.");
                                        } else if (newPassword !== confirmPassword) {
                                            $("#message").html("Passwords do not match.");
                                        } else {
                                            // alert("sd");
                                            $.ajax({
                                                type: "POST",
                                                url: "../html/reset_password.php", // Specify the URL of your server-side script
                                                data: {
                                                    username: username,
                                                    oldPassword: oldPassword,
                                                    newPassword: newPassword
                                                },
                                                // alert(data);
                                                success: function (response) {
                                                    $("#message").html(response);
                                                    $("#otpDiv").show();
                                                    $("#submit_otp").show();
                                                    $("#re-set_password").hide();
                                                }
                                            });
                                        }
                                    });
                                    $("#submit_otp").click(function (){
                                    //   alert("Hello Meet") ;
                                    var username = $("#username").val();
                                    var newPassword = $("#pass_new").val();
                                    var otpValue = $("#otp").val();
                                    
                                    $.ajax({
                                    type: "POST",
                                    url: "../html/reset_password_otp.php",
                                    data: {
                                        username: username,
                                        newPassword: newPassword,
                                        otpValue: otpValue
                                    },
                                    success: function (response) {
                                        $("#message").html(response);
        
                                        if (response === "Password updated successfully.") {
                                            setTimeout(function () {
                                                window.location.href = "login";
                                            }, 5000);
                                        }
                                    }
                                });
                                    });
                                });
    
                            </script>
    
                            <script>
                                // Get references to the input fields and the message element
                                var newPasswordInput = document.getElementById("pass_new");
                                var reEnterPasswordInput = document.getElementById("re_enter_pass");
                                var message = document.getElementById("message");
    
                                // Add an event listener to the "Re-Enter Password" field to check in real-time
                                reEnterPasswordInput.addEventListener("input", function () {
                                    var newPassword = newPasswordInput.value;
                                    var reEnterPassword = reEnterPasswordInput.value;
    
                                    if (newPassword !== reEnterPassword) {
                                        message.innerHTML = "Passwords do not match!";
                                    } else {
                                        message.innerHTML = "";
                                    }
                                });
                            </script>
    
                        </div>
                    </div>
    
                </div>
    
                <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
                    integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
                    crossorigin="anonymous"></script>
                <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
                    integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous" />
                <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
                    integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
                    crossorigin="anonymous"></script>
                <script type="text/javascript">
                    window.onload = function () {
                        OpenBootstrapPopup();
                    };
                    function OpenBootstrapPopup() {
                        $("#simpleModal1111").modal('show');
                    }
                </script>
                    <?php
                }
    
            }else{
                $msg = "Invalid Username or Password";
                $class = "alert alert-danger";
            }
}
?>

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
    <script src="
https://cdn.jsdelivr.net/npm/sweetalert2@11.7.31/dist/sweetalert2.all.min.js
"></script>
<link href="
https://cdn.jsdelivr.net/npm/sweetalert2@11.7.31/dist/sweetalert2.min.css
" rel="stylesheet">
    <link rel="stylesheet" href="dist/notifications.css">
    <script src="dist/notifications.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="assets/libs/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="assets/libs/popper.js/dist/umd/popper.min.js"></script>
    <script src="assets/libs/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
    <style type="text/css">
  /*   .modal {*/
  /*  display: none;*/
  /*  position: fixed;*/
  /*  z-index: 1000;*/
  /*  left: 0;*/
  /*  top: 0;*/
  /*  width: 100%;*/
  /*  height: 100%;*/
  /*  overflow: auto;*/
  /*  background-color: rgba(0,0,0,0.5);*/
  /*}*/
  .modal-dialog {
    margin: auto;
    width: 50%;
    max-width: 500px;
    background-color: #fff;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0,0,0,0.3);
    padding: 20px;
  }
  .modal-header {
    padding-bottom: 10px;
    border-bottom: 1px solid #ccc;
  }
  .modal-title {
    font-size: 20px;
    margin: 0;
  }
  .modal-body {
    padding: 20px 0;
  }
  .close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
  }
  .close:hover,
  .close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
  }
  .download-button {
    display: block;
    width: 200px;
    margin: 20px auto;
    padding: 10px 20px;
    background-color: #007bff;
    color: #fff;
    text-align: center;
    text-decoration: none;
    border-radius: 5px;
    transition: background-color 0.3s ease;
  }
  .download-button:hover {
    background-color: #0056b3;
  }
        #showPassword:hover {
            cursor: pointer;
        }
#myLink {
            color: blue; /* Change the color to make it appear disabled */
            pointer-events: none; /* Disable pointer events */
        }
        #registerLink {
            color: #FFF;
            border-bottom: 1px solid #FFF;
            font-size: 16px;
        }

        #registerLink:hover {
            color: #00F;
            border-bottom: 1px solid #00F;
        }
    </style>
</head>
</html>