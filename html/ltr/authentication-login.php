<?php
// $sessionTimeout = 43200;

// // Set session configuration parameters
// session_set_cookie_params($sessionTimeout);
// session_set_cookie_params(120);
// / server should keep session data for AT LEAST 1 hour
ini_set('session.gc_maxlifetime', 43200);

// each client should remember their session id for EXACTLY 1 hour
session_set_cookie_params(43200);
session_start();
include_once '../connection.php';
include_once '../mailFunction_withoutLogin.php';


$_SESSION['expiration_time'] = time() + 43200;
$_SESSION['LAST_ACTIVITY'] = time();


$sessionTimeout = 60; // 30 minutes

// Array of session variables to track last access time
// $sessionVariables = array('login_type', 'user_type','username');

// // Loop through each session variable
// foreach($sessionVariables as $variable) {
//     // Check if last access time is stored in session for this variable
//     if(isset($_SESSION[$variable]['last_access_time'])) {
//         $lastAccessTime = $_SESSION[$variable]['last_access_time'];

//         // Calculate time elapsed since last access
//         $currentTime = time();
//         $elapsedTime = $currentTime - $lastAccessTime;

//         // Extend session if less than half of the session timeout has elapsed
//         if($elapsedTime < ($sessionTimeout / 2)) {
//             // Extend session by updating last access time
//             $_SESSION[$variable]['last_access_time'] = $currentTime;
//         }
//     } else {
//         // First time visit, set last access time
//         $_SESSION[$variable]['last_access_time'] = time();
//     }
// }

// Set session timeout
// ini_set('session.gc_maxlifetime', $sessionTimeout);


// Fetch username, MAC address, and random number from URL parameters
$username = isset($_GET['username']) ? $_GET['username'] : '';
$mac_address = isset($_GET['mac_address']) ? $_GET['mac_address'] : '';
$random_number = isset($_GET['random_number']) ? $_GET['random_number'] : '';
$username_from_snap = isset($_GET['username']) ? $_GET['username'] : '';


// error_reporting(E_ALL);
// ini_set('display_errors', 1);


// Run the SQL query
$updat = "Select * from `temp_login_app` WHERE mac_address='" . $mac_address . "' and random_number='" . $random_number . "' and username='" . $username_from_snap . "' and active=1";
$ru = mysqli_query($con, $updat);
$value = mysqli_num_rows($ru);
// echo $data_val=$value['two'];
if ($value > 0) {
    if ($_SESSION['random_number'] = $random_number) {
        $_SESSION['mac_address'] = $mac_address;

        $updat = "UPDATE `temp_login_app` SET `random_number`='',two='" . $random_number . "' WHERE mac_address='" . $mac_address . "' and random_number='" . $random_number . "'";
        $ru = mysqli_query($con, $updat);
    }
}



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
    $UpdateQuery_sql = "UPDATE `users` SET `verified` = '0' WHERE `username` = '" . $_POST['userEmail'] . "'";
    $runUpdate = mysqli_query($con, $UpdateQuery_sql);
    if ($runUpdate) {
        //echo $_POST['userEmail'];
        $msg = "Congratulations, your email is  verified. Please use login id and and password to signin";
        $class = "alert alert-success";
    }
}

if (isset($_POST['send_request1'])) {
    $otp = $_POST['otp'];
    $user_id = $_POST['username'];
    $password = $_POST['password'];

    // $check_log="select * from otp_varify where `value`='".$otp."' and `user_name`='".$user_id."' and `expired`=0 and AND time(MINUTE, `timestamp`, NOW()) <= 15";
    $check_log = "SELECT * FROM otp_varify 
              WHERE `value` = '" . $otp . "' 
              AND `user_name` = '" . $user_id . "' 
              AND `expired` = 0 
              AND TIMESTAMPDIFF(MINUTE, `time`, NOW()) <= 15";

    $run_log = mysqli_query($con, $check_log);
    $value_otp = mysqli_fetch_array($run_log);
    if ($value_otp['value'] == $otp) {
        // echo "yes";
        $fetchAdminSQL = "SELECT * FROM `users` WHERE `username` = '" . $_POST['username'] . "' AND `password` = '" . sha1($_POST['password']) . "'";
        $runAdmin = mysqli_query($con, $fetchAdminSQL);
        $rows = mysqli_num_rows($runAdmin);

        $update_otp = "update otp_varify set expired=1 where `user_name`='" . $user_id . "'";
        $run_otp = mysqli_query($con, $update_otp);

        // $check_ad=mysqli_fetch_array($runAdmin);
        $userdata = mysqli_fetch_array($runAdmin);
        $_SESSION['user_type'] = 'system_user';

        $_SESSION['login_type'] = $userdata['type'];
        // Set login type with session time
        // $_SESSION['login_type'] = array(
        //     'type' => $_SESSION['user_type'],
        //     'session_time' => $_SESSION['LAST_ACTIVITY']
        // );
        if ($userdata['user_type'] == 'company') {
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
        }
    } else {
?>
        <div id="simpleModal12" class="modal" data-backdrop='static' tabindex="-1" role="dialog">
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
                                <b>
                                    <p style="color: red; font-size: 18px; text-align: center; margin: 0;">Wrong OTP</p>
                                </b>
                                <label style="font-size: 15px;"><b>satee.....cli.....com</b>
                                    Please enter the OTP in the field below to verify your Email.</label>
                                <div class="form-group col-md-9 text-center">
                                    <input type="hidden" name="username" id="username" value="<?php echo $_POST['username']; ?>">
                                    <input type="hidden" name="password" id="password" value="<?php echo $_POST['password']; ?>">
                                    <div class="input-group">
                                        <input type="text" name="otp" class="form-control" placeholder="Enter OTP" style="border: 1px solid black;" required>&nbsp;&nbsp;&nbsp;&nbsp;
                                        <div class="input-group-append">
                                            <input type="submit" name="send_request1" class="btn btn-success" value="Login" style="height: 100%;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <!--Re-send OTP-->
                                <!--<p>Re-send OTP After </p><br>-->
                                <a href="#" id="myLink1">Re-Send OTP</a> After <span id="countdown">60 </span> &nbsp; Second
                            </div>
                        </div>
                        <div class="modal-footer">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <script>
            $(document).ready(function() {
                $("#myLink1").on("click", function(e) {
                    e.preventDefault();
                    alert("Hello");
                    // Perform AJAX request to generate a new OTP
                    $.ajax({
                        type: "POST",
                        url: "html/your_php_script.php", // Replace with the actual path to your PHP script
                        success: function(response) {
                            if (response === "success") {
                                // Display the modal with the new OTP
                                $('#simpleModal12').modal('show');
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
            // countdown.js
            export let countdownTime = 60;

            export function startCountdown() {
                function updateCountdown() {
                    const countdownElement = document.getElementById("countdown");
                    countdownElement.textContent = countdownTime;

                    if (countdownTime <= 0) {
                        const myLink = document.getElementById("myLink");
                        myLink.style.color = "";
                        myLink.style.pointerEvents = "auto";
                        myLink.href = "https://example.com";
                        countdownElement.textContent = "";
                    } else {
                        countdownTime--;
                        setTimeout(updateCountdown, 1000);
                    }
                }

                updateCountdown();
            }
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
            window.onload = function() {
                OpenBootstrapPopup();
            };

            function OpenBootstrapPopup() {
                $("#simpleModal12").modal('show');
            }
        </script>
        <?php
    }
}
if (isset($_POST['send_request'])) {
    echo '<script>alert("Message")</script>';

    $user_id = $_POST['username'];
    $user_password = $_POST['password'];
    $server_id = $_SERVER['REMOTE_ADDR'];
    $name = $_POST['name'];
    $mno = $_POST['m_no'];

    $insert_query = "insert into `req_user`(`company_id`,`user_id`,`server_id`,`name`,`mobile`)values('" . $_SESSION['company_id'] . "','" . $user_id . "','" . $server_id . "','" . $name . "','" . $mno . "')";
    $run_query = mysqli_query($con, $insert_query);
}

if (isset($_POST['registerSuccess'])) {
    //echo "rok";
    $msg = "Registration Successfull Please verify your email id";
    $class = "alert alert-success";
}


if (isset($_POST['loginUserBtn'])) {
    if (isset($_POST['username']) && isset($_POST['password'])) {



        $fetchAdminSQL = "SELECT * FROM `users` WHERE `username` = '" . mysqli_real_escape_string($con, $_POST['username']) . "' AND `password` = '" . sha1($_POST['password']) . "'";
        $runAdmin = mysqli_query($con, $fetchAdminSQL);

        // Check if the query executed successfully
        if (!$runAdmin) {
            die("Error in query execution: " . mysqli_error($con));
        }

        $rows12 = mysqli_num_rows($runAdmin);

        // Proceed only if at least one row is found
        if ($rows12 > 0) {
            $userdata = mysqli_fetch_array($runAdmin);
            $free_mac = $userdata['two_step_veri']; // Access safely
        } else {
            $free_mac = null; // Or handle the case where no data is found
        }

        // Optional: Handle the result
        if ($free_mac === null) {
            // echo "No two-step verification data found for this user.";
        } else {
            // echo "Two-step verification status: $free_mac";
        }

        if ($free_mac == 0) {
            if ($rows12 > 0) {
                if ($userdata['user_status'] != '0') {
                    $msg = "You Can't Login without Approve Your Company by Adminmcksdnfvkldsnvlksdnvs!";
                    $class = "alert alert-danger";
                    $_SESSION['user_type'] = 'system_user';
                    $_SESSION['login_type'] = $userdata['type'];
                    // Set login type with session time
                    // $_SESSION['login_type'] = array(
                    //     'type' => $_SESSION['user_type'],
                    //     'session_time' => $_SESSION['LAST_ACTIVITY']
                    // );
                    if ($userdata['user_type'] == 'company') {
                        $fetchCompanyApprove = "SELECT * FROM `company_profile` WHERE `email_id` = '" . $_POST['username'] . "'";
                        $runApprovedSQL = mysqli_query($con, $fetchCompanyApprove);
                        $rowsApproved = mysqli_num_rows($runApprovedSQL);
                        $ApprovedData = mysqli_fetch_array($runApprovedSQL);
                        if ($ApprovedData['approved'] != '1') {
                            $msg = "You Can't Login without Approve Your Company by Admin!vdskvnld";
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
                                } else if ($row['tax_invoice']) {
                                    $_SESSION['page'] = "tax_invoice";
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
                                } else if ($row['e_tender']) {
                                    $_SESSION['page'] = "e_tender";
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
                    } else {
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
                            } else if ($row['tax_invoice']) {
                                $_SESSION['page'] = "tax_invoice";
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
                            } else if ($row['e_tender']) {
                                $_SESSION['page'] = "e_tender";
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
                    } //Simpale User End Block
                }
            }
        } else {
            // if (isset($_POST['username']) && isset($_POST['password'])) {

            $fetchAdminSQL = "SELECT * FROM `users` WHERE `username` = '" . $_POST['username'] . "' AND `password` = '" . sha1($_POST['password']) . "'";
            $runAdmin = mysqli_query($con, $fetchAdminSQL);
            $rows = mysqli_num_rows($runAdmin);
            // }
        }
        $fetchClientSQL = "SELECT * FROM `client_master` WHERE `email_1` = '" . $_POST['username'] . "' AND `password` = '" . $_POST['password'] . "'";
        $runClient = mysqli_query($con, $fetchClientSQL);
        $rowsClient = mysqli_num_rows($runClient);
        $clientdata = mysqli_fetch_array($runClient);

        if ($rows > 0) {
            $currentTimestamp = strtotime(date("Y-m-d"));
            $threshold = 30;
            $lastLoginTimestamp = strtotime($userdata['last_pass_reset']);
            // Fetch MAC address and random number from URL parameters
            $mac_address = isset($_GET['mac_address']) ? $_GET['mac_address'] : '';
            $random_number = isset($_GET['random_number']) ? $_GET['random_number'] : '';
            $username_from_snap = isset($_GET['username']) ? $_GET['username'] : '';

            // Check if session variables are set
            if (isset($_SESSION['mac_address']) && isset($_SESSION['random_number'])) {
                $session_mac_address = $_SESSION['mac_address'];
                $session_random_number = $_SESSION['random_number'];
            } else {
                $session_mac_address = '';
                $session_random_number = '';
            }

            $today_date = date("Y-m-d");
            // $fetch_id = "SELECT mac_address FROM temp_login_app where username='" . $username_from_snap . "' and mac_address='".$_SESSION['mac_address']."' and two='".$_SESSION['random_number']."'";
            $fetch_id = "SELECT mac_address FROM temp_login_app WHERE username='$username_from_snap' AND mac_address='$session_mac_address' AND two='$session_random_number'";

            $run_query = mysqli_query($con, $fetch_id);
            // if($run_query){

            // }
            $expectedIpAddress = array();
            while ($row = mysqli_fetch_array($run_query)) {
                $expectedIpAddress[] = $row['mac_address'];
            }


            if (($currentTimestamp - $lastLoginTimestamp) <= 30 * 24 * 60 * 60) {
                if ($userdata['type'] == 1) {
                    $otp = mt_rand(100000, 999999);
                    $user_name = $_POST['username'];
                    // $recoverEmail="vowel.sateesh@gmail.com";
                    $recoverEmail = "sateesh@clienserv.com";

                    // $recoverEmail="shubhampal2120@gmail.com";

                    $insert_otp = "insert into `otp_varify` (`user_name`,`value`)values ('" . $user_name . "','" . $otp . "')";
                    $run_qury = mysqli_query($con, $insert_otp);

                    if ($run_qury) {
                        $returnSthana = sthanamail($recoverEmail, '<html>
					<body>
					<div>
						OTP id ' . $otp . '
						
					</div>
					<hr>
						<p style="color:red;">Note: This is a system generated mail. Please do not reply to it. For any further query please contact</p>
					</body>
					</html>', "Clienserv - Record Created"); ?>

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
                            $(document).ready(function() {
                                $("#myLink12").on("click", function(e) {
                                    console.log("Link clicked");
                                    e.preventDefault();
                                    alert("Hello");

                                    // Perform AJAX request to generate a new OTP
                                    $.ajax({
                                        type: "POST",
                                        url: "html/your_php_script.php", // Replace with the actual path to your PHP script
                                        success: function(response) {
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
                            window.onload = function() {
                                OpenBootstrapPopup();
                            };

                            function OpenBootstrapPopup() {
                                $("#simpleModal1").modal('show');
                            }
                        </script>
                    <?php
                    }
                } elseif (!empty($expectedIpAddress)) {



                    echo $_SESSION['user_type'] = 'system_user';
                    echo $_SESSION['login_type'] = $userdata['type'];
                    // Set login type with session time
                    // $_SESSION['login_type'] = array(
                    //     'type' => $_SESSION['user_type'],
                    //     'session_time' => $_SESSION['LAST_ACTIVITY']
                    // );
                    // print_r($expectedIpAddress);
                    // echo "dscf";
                    if ($userdata['user_type'] == 'company') {

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
                    } else {

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
                } else {
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
                                    <a href="https://drive.google.com/file/d/1VeHIT7_yyF5z8v3Y8FT2lvG6w67Xma_L/view?usp=drive_link" class="download-button">Download</a>
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
                        window.onload = function() {
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
                                            <input type="hidden" name="username" id="username" value="<?php echo $_POST['username']; ?>">
                                            <input type="hidden" name="password" id="oldPassword"
                                                value="<?php echo $_POST['password']; ?>">
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

                            <script>
                                $(document).ready(function() {
                                    $("#re-set_password").click(function() {
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
                                            $.ajax({
                                                type: "POST",
                                                url: "../html/reset_password.php", // Specify the URL of your server-side script
                                                data: {
                                                    username: username,
                                                    oldPassword: oldPassword,
                                                    newPassword: newPassword
                                                },
                                                // alert(data);
                                                success: function(response) {
                                                    $("#message").html(response);
                                                    $("#otpDiv").show();
                                                    $("#submit_otp").show();
                                                    $("#re-set_password").hide();
                                                }
                                            });
                                        }
                                    });
                                    $("#submit_otp").click(function() {
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
                                            success: function(response) {
                                                $("#message").html(response);

                                                if (response === "Password updated successfully.") {
                                                    setTimeout(function() {
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
                                reEnterPasswordInput.addEventListener("input", function() {
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
                    window.onload = function() {
                        OpenBootstrapPopup();
                    };

                    function OpenBootstrapPopup() {
                        $("#simpleModal1111").modal('show');
                    }
                </script>
<?php
            }
        } else {
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
    <script src="
https://cdn.jsdelivr.net/npm/sweetalert2@11.7.31/dist/sweetalert2.all.min.js
"></script>
    <link href="
https://cdn.jsdelivr.net/npm/sweetalert2@11.7.31/dist/sweetalert2.min.css
" rel="stylesheet">
    <!-- <link rel="stylesheet" href="dist/notifications.css"> -->
    <!-- <script src="dist/notifications.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
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
            color: blue;
            /* Change the color to make it appear disabled */
            pointer-events: none;
            /* Disable pointer events */
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

<body>

    <?php //print_r($_COOKIE);
    //echo $_COOKIE['login_VowelUser']; 
    ?>
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
            <div class="auth-box bg-dark border-secondary" style="margin-top: 0px;">
                <div id="loginform">
                    <div class="text-center p-t-20 p-b-20">
                        <span class="db" class=""><img src="html/images/logo.png" class="bg-dark" alt="logo"
                                style="width: 30%;" /></span>
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
                                    <div class="<?php echo $_SESSION['class'] . " alert-dismissible fade show" ?>">
                                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                                        <?php echo $_SESSION['msg']; ?>
                                    </div>
                                <?php
                                    session_destroy();
                                }
                                if (isset($_POST['loginUserBtn']) || isset($_POST['registerSuccess']) || isset($_POST['userEmail'])) {
                                ?>
                                    <?php
                                    // Initialize $msg to avoid undefined variable warning
                                    $msg = isset($msg) ? $msg : '';

                                    $class = isset($class) ? $class : ''; // Initialize $class if it's not set
                                    ?>
                                    <div class="<?php echo $class . " alert-dismissible fade show" ?>">
                                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                                        <?php echo $msg; ?>
                                    </div>
                                <?php
                                }
                                ?>
                                <span id="username-status"></span>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-success text-white" id="basic-addon1"><i
                                                class="ti-user"></i></span>
                                    </div>
                                    <input type="text" required class="form-control form-control-lg"
                                        placeholder="Username" aria-label="Username" name="username"
                                        aria-describedby="basic-addon1" id="username" autofocus
                                        value="<?php if (isset($_COOKIE['login_VowelUser']))
                                                    echo $_COOKIE['login_VowelUser']; ?>">
                                </div>
                                <span id="password-status"></span>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-warning text-white" id="basic-addon2"><i
                                                class="ti-pencil"></i></span>
                                    </div>
                                    <input type="password" required class="form-control form-control-lg"
                                        placeholder="Password" aria-label="Password" name="password"
                                        aria-describedby="basic-addon1" id="password"
                                        value="<?php if (isset($_COOKIE['password_VowelUser']))
                                                    echo $_COOKIE['password_VowelUser']; ?>">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-info text-white" id="basic-addon2"><a class=""
                                                id="showPassword"><i id="passIcon"
                                                    class="fas fa-eye-slash"></i></a></span>
                                    </div>
                                </div>

                                <div class="row d-flex justify-content-center fadeIn fourth">
                                    <div class="custom-control custom-checkbox pl-2" style="width: 143px;">
                                        <input type="checkbox" class="custom-control-input " id="user_remember"
                                            name="user_remember" <?php if (isset($_COOKIE["login_VowelUser"])) {
                                                                        echo "checked";
                                                                    } ?>>
                                        <label class="custom-control-label pl-3 text-white" for="user_remember">Remember
                                            me</label>
                                    </div>
                                </div>
                                <!--button type="button" id="loginUserBtn" class="fadeIn fifth">Log In</button-->
                            </div>
                        </div>
                        <div class="row border-top border-secondary">
                            <div class="col-12">
                                <div class="form-group">
                                    <div class="p-t-20">
                                        <button class="btn btn-info" id="to-recover" type="button"><i
                                                class="fa fa-lock m-r-5"></i> Lost password?</button>
                                        <button type="submit" class="btn btn-success float-right" name="loginUserBtn"
                                            id="loginUserBtn">Login</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row border-top border-secondary">
                            <div class="col-12 text-center">
                                <div class="form-group">
                                    <div class="p-t-20">
                                        <a href="register" id="registerLink">Not registered yet? Click here.</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <?php
                //OTP Function
                function generateNumericOTP($n)
                {
                    $generator = "r1At3eGu5kDg7dJs9aWb0cTx2lQp4oCw6bXv8jZ";
                    $result = "";
                    for ($i = 1; $i <= $n; $i++) {
                        $result .= substr($generator, (rand() % (strlen($generator))), 1);
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
                    $checkExistSQL = "SELECT * FROM `users` WHERE `username` = '" . $recoverEmail . "'";
                    $run_checkExistSQL = mysqli_query($con, $checkExistSQL);
                    $row_Exist = mysqli_num_rows($run_checkExistSQL);
                    $msg2 = "Null";
                    $class2 = "Null";
                    if ($row_Exist > 0) {
                        $msg = "Valid Email Id";
                        $class = "alert alert-success";
                        $OTP = generateNumericOTP(16);
                        $returnSthana = sthanamail($recoverEmail, '<html>
                                  <body>
                                  <div>
                                        <p>
                                  Dear User,<br>We received your request to access your Vowel Account through your email address.<br> Your Email verification code is: ' . $OTP . '</p><br><hr>
                                  <p style="color:red;">Note: This is a system generated mail. Please do not reply to it.</p>
                                    </div>
                                  </body>
                                  </html>', "Sthana - Forgot Password OTP");
                        if ($returnSthana == "send_success") {
                            //echo "Registration Successfull";
                            $updateOTP = "UPDATE `users` SET `forgotpasswordOTP` = '" . $OTP . "', `OTPstatus` = '1' WHERE `username` = '" . $recoverEmail . "'";
                            $resultOTP = mysqli_query($con, $updateOTP);

                            $msg2 = "OTP Sent on '" . $recoverEmail . "' Please Verify It";
                            $class2 = "alert alert-success";
                            //echo "<script type='text/javascript'> $(document).ready(function () { $('#SubmitSuccessRegistration').submit(); }); </script>";
                            //header("Location: login");
                            //exit();
                        } else if ($returnSthana == "send_fail") {
                            $msg = "Error To Send Mail.!!";
                            $class = "alert alert-danger";
                        } else if ($returnSthana == "internet_error") {
                            $msg = "Check Your Internet Connection.!!";
                            $class = "alert alert-danger";
                        }
                        //echo"The email was sent";
                    } else {
                        $msg = "Invalid Email Id.!!";
                        $class = "alert alert-danger";
                        $class2 = "alert alert-danger";
                    }
                }

                if (isset($_POST['verifyotp'])) {
                    $checkOTP = "SELECT `id` FROM `users` WHERE `username` = '" . $_POST['forgotEmail'] . "' AND `forgotpasswordOTP` = '" . $_POST['forgotpasswordOTP'] . "' AND `OTPstatus` = '1'";
                    $run_checkOTP = mysqli_query($con, $checkOTP);
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
                    } else {
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
                        <div class="<?php echo $class . " alert-dismissible fade show" ?>">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <?php echo $msg; ?>
                        </div>
                    <?php
                    }
                    ?>
                    <?php //if (isset($_POST['recoverBtn']) && $msg != "Valid Email Id") { 
                    ?>
                    <div class="text-center">
                        <span class="text-white">Enter your e-mail address below and we will send you instructions how
                            to recover a password.</span>
                    </div>
                    <div class="row m-t-20">
                        <!-- Form -->
                        <form class="col-12" method="post">
                            <!-- email -->
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-danger text-white" id="basic-addon1"><i
                                            class="ti-email"></i></span>
                                </div>
                                <input type="text" class="form-control form-control-lg" placeholder="Email Address"
                                    aria-label="Username" name="recoverEmail" id="recoverEmail" required
                                    aria-describedby="basic-addon1"
                                    value="<?php if (isset($_POST['recoverBtn'])) {
                                                echo $_POST['recoverEmail'];
                                            } ?>">
                                <input type="hidden" name="validEmail" id="validEmail" readonly
                                    value="<?php if (isset($_POST['recoverBtn'])) {
                                                echo $msg;
                                            } ?>">
                            </div>
                            <!-- pwd -->
                            <div class="row m-t-20 p-t-20 border-top border-secondary">
                                <div class="col-12">
                                    <a class="btn btn-success" href="#" id="to-login" name="action">Back To Login</a>
                                    <button class="btn btn-info float-right" type="submit" id="recoverBtn"
                                        name="recoverBtn">Recover</button>
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
                        <div class="<?php echo $class . " alert-dismissible fade show" ?>">
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
                                        <span class="input-group-text bg-danger text-white" id="basic-addon1"><i
                                                class="ti-email"></i></span>
                                    </div>
                                    <input type="hidden" class="form-control form-control-lg" placeholder="Email Address"
                                        aria-label="Username" name="forgotEmail" id="forgotEmail" required
                                        aria-describedby="basic-addon1"
                                        value="<?php if (isset($_POST['recoverBtn'])) {
                                                    echo $_POST['recoverEmail'];
                                                } else if (isset($_POST['verifyotp'])) {
                                                    echo $_POST['forgotEmail'];
                                                } ?>">
                                    <input type="text" name="forgotpasswordOTP" id="forgotpasswordOTP"
                                        class="form-control form-control-lg" placeholder="OTP" aria-label="Username"
                                        aria-describedby="basic-addon1" required>
                                    <input type="hidden" name="validOTP" id="validOTP" readonly
                                        value="<?php if (isset($_POST['verifyotp'])) {
                                                    echo $msg2;
                                                } ?>">
                                </div>
                                <!-- pwd -->
                                <div class="row m-t-20 p-t-20 border-top border-secondary">
                                    <div class="col-12">
                                        <a class="btn btn-success" href="#" id="varifyto-login" name="action">Back To
                                            Login</a>
                                        <button class="btn btn-info float-right" id="verifyotp" name="verifyotp"
                                            type="submit">Verify OTP</button>
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
        $('#to-login').click(function() {
            //$("#validotpform").hide();
            $("#recoverform").hide();
            $("#loginform").fadeIn();
        });
        $('#varifyto-login').click(function() {
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

        $('#showPassword').click(function() {
            if ('password' == $('#password').attr('type')) {
                $('#password').prop('type', 'text');
                $('#passIcon').removeClass('fas fa-eye-slash');
                $('#passIcon').addClass('fas fa-eye');
            } else {
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
              //var page='<?php //echo $_COOKIE['login_VowelUser'] 
                            ?>';
              //alert(page);
              data = JSON.parse(data)
              if(data['data'] == "Valid User")
              { 
                //var page='<?php //echo $_COOKIE['login_VowelUser'];
                            ?>';
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