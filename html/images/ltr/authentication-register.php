<?php 
    session_start();
    include_once '../connection.php';
    include_once '../mailFunction.php';
    date_default_timezone_set('Asia/Kolkata');
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
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
    <!-- All Required js -->
    <!-- ============================================================== -->
    <script src="assets/libs/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="assets/libs/popper.js/dist/umd/popper.min.js"></script>
    <script src="assets/libs/bootstrap/dist/js/bootstrap.min.js"></script>
<style type="text/css">
    #loginLink{
        color: #FFF;
        border-bottom: 1px solid #FFF;
        font-size: 16px;
    }
    #loginLink:hover{
        color: #00F;
        border-bottom: 1px solid #00F;
    }
    /* Chrome, Safari, Edge, Opera */
    input[type=number]::-webkit-inner-spin-button, 
    input[type=number]::-webkit-outer-spin-button { 
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        margin: 0; 
    }

    input[type=number] {
        -moz-appearance:textfield;
    }
</style>
</head>

<body>
    <?php 
        if (isset($_POST['register'])) {
            $company_name = $_POST['company_name'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $company_address = $_POST['company_address'];
            $mobile_number = $_POST['mobile_number'];

            $fetch_email = "(SELECT DISTINCT `email_id` FROM `company_profile` WHERE `email_id` = '".$email."') UNION (SELECT DISTINCT `username` FROM `users` WHERE `username` = '".$email."')";
            $fetch_mobile = "(SELECT DISTINCT `mobile_no` FROM `company_profile` WHERE `mobile_no` = '".$mobile_number."') UNION (SELECT DISTINCT `username` FROM `users` WHERE `username` = '".$email."')";
            //$fetch_email = "SELECT `email_id` FROM `company_profile` cp,`users` usr WHERE `email_id` = '".$email."'";
            $run_fetch_email = mysqli_query($con,$fetch_email);
            $rowEmail = mysqli_num_rows($run_fetch_email);
            $run_fetch_mobile = mysqli_query($con,$fetch_mobile);
            $rowMobile = mysqli_num_rows($run_fetch_mobile);
            if ($rowEmail > 0) {
                $msg = "Email id already exist.!!";
                $class = "alert alert-danger";
            }else if ($rowMobile > 0) {
                $msg = "Mobile Number already exist.!!";
                $class = "alert alert-danger";
            }else{
                $register_SQL = "INSERT INTO `company_profile` (`company_id`, `company_name`, `address`, `email_id`, `mobile_no`, `approved`) VALUES ('".date('d-m-Y H:i:sa')."','".$company_name."','".$company_address."','".$email."','".$mobile_number."','0')";
                $run_register_SQL = mysqli_query($con,$register_SQL);

                if ($run_register_SQL > 0) {
                    $fetch_companyId = "SELECT * FROM `company_profile` WHERE `email_id` = '".$email."'";
                    $run_fetch_companyId = mysqli_query($con,$fetch_companyId); 
                    $row_id = mysqli_fetch_assoc($run_fetch_companyId);

                    $register_UserSQL = "INSERT INTO `users` (`company_id`, `user_type`, `username`, `password`, `verified`, `registration_date`, `reports`, `client_master`, `dsc_subscriber`, `dsc_reseller`, `pan`, `tan`, `it_returns`, `e_tds`, `gst`, `other_services`, `psp`, `psp_coupon_consumption`, `payment`, `audit`, `add_users`, `company_profile`) VALUES ('".$row_id['company_id']."', 'company', '".$email."', '".sha1($password)."', '1', '".date('Y-m-d')."','1','1','1','1','1','1','1','1','1','1','1','1','1','1','1','1')";
                    $run_register_UserSQL = mysqli_query($con,$register_UserSQL);

                    $returnSthana = sthanamail($email,'<html>
                      <body>
                        <p>
                            Welcome To Sthana,
                                Congratulations You Have Successfully Register on Our Service.
                        </p><br>
                        <p>Please Verify Your Email Address</p><br>
                        <div>
                        <form method="post" target="_blank" action="https://clienserv.com/vowel/login">
                            <input type="hidden" name="userEmail" value="'.$email.'">
                            <input type="submit" value="Verify" style="display: block;
                                width: 115px;
                                height: 45px;
                                background: #27a9e3;
                                padding: 10px;
                                text-align: center;
                                border-radius: 5px;
                                border: none;
                                color: white;
                                font-weight: bold;
                                font-size: 17px;
                                text-decoration:none;
                                line-height: 25px;">
                        </form>
                        </div>
                        <hr>
                          <p style="color:red;">Note: This is a system generated mail. Please do not reply to it.</p>
                      </body>
                      </html>',"Sthana - Registration Successfull");
                    if ($returnSthana == "send_success") {
                        //echo "Registration Successfull";
                        $msg = "Registration Successfull Please verify your email id";
                        $class = "alert alert-success";
                        echo "<script type='text/javascript'> $(document).ready(function () { $('#SubmitSuccessRegistration').submit(); }); </script>";
                        //header("Location: login");
                        //exit();
                    }
                }
            }
        }
    ?>
    <form method='post' action='login' class="d-none" id="SubmitSuccessRegistration">
        <input type='hidden' name='registerSuccess' value='success'>
        <input type="submit" name="successBtn" value="Submit">
    </form>
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
                <div>
                    <div class="text-center p-t-20 p-b-20">
                        <span class="db"><img src="html/images/logo.png" class="bg-dark" alt="logo" /></span>
                        <p style="color: #fff; margin: 0px; font-size: 17px;">Clienserv</p>
                        <!-- <p style="color: #fff; margin: 0px; font-size: 17px;">Minute Data Analyzer</p> -->
                    </div>
                    <!-- Form -->
                    <form class="form-horizontal m-t-20" method="post">
                        <div class="row p-b-30">
                            <div class="col-12">
                                <?php
                                    if (isset($_POST['register'])) {
                                        ?>
                                        <div class="<?php echo $class." alert-dismissible fade show" ?>">
                                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                                          <?php echo $msg; ?>
                                        </div>
                                        <?php
                                    }
                                ?>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-success text-white" id="basic-addon1"><i class="ti-user"></i></span>
                                    </div>
                                    <input type="text" name="company_name" class="form-control form-control-lg" placeholder="Company Name" aria-label="Company Name" aria-describedby="basic-addon1" required>
                                </div>
                                <!--div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-warning text-white" id="basic-addon2"><i class="ti-pencil"></i></span>
                                    </div>
                                    <input type="text" name="password" class="form-control form-control-lg" placeholder="Password" aria-label="Password" aria-describedby="basic-addon1" required>
                                </div-->
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-info text-white" id="basic-addon2"><i class="ti-home"></i></span>
                                    </div>
                                    <input type="text" name="company_address" class="form-control form-control-lg" placeholder="Company Address" aria-label="Company Address" aria-describedby="basic-addon1" required>
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-info text-white" id="basic-addon2"><i class="ti-mobile"></i></span>
                                    </div>
                                    <input type="number" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="10" min="1" name="mobile_number" class="form-control form-control-lg" placeholder="Mobile Number" aria-label="Mobile Number" aria-describedby="basic-addon1" required>
                                </div>
                                <!-- email -->
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-danger text-white" id="basic-addon1"><i class="ti-email"></i></span>
                                    </div>
                                    <input type="text" name="email" class="form-control form-control-lg" placeholder="Email Address" aria-label="Username" aria-describedby="basic-addon1" required>
                                </div>
                                <span id="password-status"></span>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-warning text-white" id="basic-addon2"><i class="ti-lock"></i></span>
                                    </div>
                                    <input type="password" required class="form-control form-control-lg" placeholder="Password" aria-label="Password" name="password" aria-describedby="basic-addon1" id="password">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-info text-white" id="basic-addon2"><a class="" id="showPassword"><i id="passIcon" class="fas fa-eye-slash"></i></a></span>
                                    </div>
                                </div>
                                <span id="con_password-status"></span>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-warning text-white" id="basic-addon2"><i class="ti-lock"></i></span>
                                    </div>
                                    <input type="password" required class="form-control form-control-lg" placeholder="Confirm Password" aria-label="Password" name="con_password" aria-describedby="basic-addon1" id="con_password">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-info text-white" id="basic-addon2"><a class="" id="showCon_Password"><i id="con_passIcon" class="fas fa-eye-slash"></i></a></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row border-top border-secondary">
                            <div class="col-12">
                                <div class="form-group">
                                    <div class="p-t-20">
                                        <button class="btn btn-block btn-lg btn-info d-none" name="register" id="register" type="submit">Sign Up</button>
                                        <button type="button" class="btn btn-block btn-lg btn-info" name="registerCheck" id="registerCheck">Sign Up</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row border-top border-secondary">
                            <div class="col-12 text-center">
                                <div class="form-group">
                                    <div class="p-t-20">
                                        <a href="login" id="loginLink">Login Instead ?</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
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

    <!-- ============================================================== -->
    <!-- This page plugin js -->
    <!-- ============================================================== -->
    <script>
        $('[data-toggle="tooltip"]').tooltip();
        $(".preloader").fadeOut();

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
        $('#showCon_Password').click(function(){
            if('password' == $('#con_password').attr('type')){
                 $('#con_password').prop('type', 'text');
                 $('#con_passIcon').removeClass('fas fa-eye-slash');
                 $('#con_passIcon').addClass('fas fa-eye');
            }else{
                 $('#con_password').prop('type', 'password');
                 $('#con_passIcon').removeClass('fas fa-eye');
                 $('#con_passIcon').addClass('fas fa-eye-slash');
            }
        });
        $(document).ready(function(){
            $("#registerCheck").click(function () {
                var password = $("#password").val();
                var con_password = $("#con_password").val();
                if (password != con_password) {
                    $("#con_password-status").html('Both password must be same').css({'color':'red'});
                    $("#con_password").addClass("border-danger");
                }else{
                    $("#con_password-status").html('').css({'color':'green'});
                    $("#con_password").removeClass("border-danger");
                    $("#register").click();
                }
            });
        });
    </script>
</body>
</html>