<?php 
    session_start();
    include_once '../connection.php';
    include_once '../mailFunction.php';
    if (!isset($_SESSION['change_Status'])) {
        //if ($_SESSION['change_Status'] == "Allowed") {
        header("Location: login");
        exit();
        //}
    }else{
        if ($_SESSION['change_Status'] != "Allowed") {
            header("Location: login");
            exit();
        }
    }
    if (isset($_POST['changePasswordBtn'])) {
        $changePassword_Email = $_SESSION['changePassword_Email'];
        $new_password = $_POST['new_password'];
        $retype_password = $_POST['retype_password'];

        if ($new_password != $retype_password) {
            $msg = "Both password must be same.!!";
            $class = "alert alert-danger";
        }else if ($new_password == $retype_password) {
            $changePassword_SQL = "UPDATE `users` SET `password`='".sha1($new_password)."',`OTPstatus`='0' WHERE `username` = '".$changePassword_Email."'";
            $run_changePassword_SQL = mysqli_query($con,$changePassword_SQL);
            if ($run_changePassword_SQL) {
                session_destroy();
                session_start();
                $_SESSION['msg'] = "Password Changed Successfully";
                $_SESSION['class'] = "alert alert-success";
                header("Location: login");
                exit();
            }
            //$msg = "Password Changed Successfully";
            //$class = "alert alert-success";
        }
    }
?>
<!DOCTYPE html>
<html dir="ltr">
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="html/images/favicon.ico">
    <title>STHANA</title>
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
</head>
<body>
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
        <div class="auth-wrapper d-flex no-block justify-content-center align-items-center bg-dark">
            <div class="auth-box bg-dark border-secondary">
                <div id="loginform">
                    <div class="text-center p-t-20 p-b-20">
                        <span class="db"><img src="html/images/logo.png" class="bg-light" alt="logo" /></span>
                    </div>
                    <!-- Form -->
                    <form class="form-horizontal m-t-20" id="loginform" method="post">
                        <div class="row p-b-30">
                            <div class="col-12">
                                <?php
                                    if (isset($_POST['changePasswordBtn'])) {
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
                                        <span class="input-group-text bg-success text-white" id="basic-addon1"><i class="ti-lock"></i></span>
                                    </div>
                                    <input type="password" required class="form-control form-control-lg" placeholder="New Password" aria-label="New Password" name="new_password" aria-describedby="basic-addon1" id="new_password" autofocus>
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-info text-white" id="basic-addon2"><a class="" id="shownewPassword"><i id="newpassIcon" class="fas fa-eye-slash"></i></a></span>
                                    </div>
                                </div>
                                
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-warning text-white" id="basic-addon2"><i class="ti-lock"></i></span>
                                    </div>
                                    <input type="password" required class="form-control form-control-lg" placeholder="Re-type Password" aria-label="Re-type Password" name="retype_password" aria-describedby="basic-addon1" id="retype_password">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-info text-white" id="basic-addon2"><a class="" id="showretypePassword"><i id="retypepassIcon" class="fas fa-eye-slash"></i></a></span>
                                    </div>
                                </div>
                                <span id="retype_password-status"></span>
                                <!--button type="button" id="changePasswordBtn" class="fadeIn fifth">Log In</button-->
                            </div>
                        </div>
                        <div class="row border-top border-secondary">
                            <div class="col-12">
                                <div class="form-group">
                                    <div class="p-t-20 text-center">
                                        <button type="button" class="btn btn-success" name="changePasswordBtn_temp" id="changePasswordBtn_temp">Change Password</button>
                                        <button type="submit" class="btn btn-success d-none" name="changePasswordBtn" id="changePasswordBtn">Change Password</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="assets/libs/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="assets/libs/popper.js/dist/umd/popper.min.js"></script>
    <script src="assets/libs/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- This page plugin js -->
    <!-- ============================================================== -->
    <script type="text/javascript">
        $('[data-toggle="tooltip"]').tooltip();
        $(".preloader").fadeOut();
        $('#shownewPassword').click(function(){
            if('password' == $('#new_password').attr('type')){
                 $('#new_password').prop('type', 'text');
                 $('#newpassIcon').removeClass('fas fa-eye-slash');
                 $('#newpassIcon').addClass('fas fa-eye');
            }else{
                 $('#new_password').prop('type', 'password');
                 $('#newpassIcon').removeClass('fas fa-eye');
                 $('#newpassIcon').addClass('fas fa-eye-slash');
            }
        });
        $('#showretypePassword').click(function(){
            if('password' == $('#retype_password').attr('type')){
                 $('#retype_password').prop('type', 'text');
                 $('#retypepassIcon').removeClass('fas fa-eye-slash');
                 $('#retypepassIcon').addClass('fas fa-eye');
            }else{
                 $('#retype_password').prop('type', 'password');
                 $('#retypepassIcon').removeClass('fas fa-eye');
                 $('#retypepassIcon').addClass('fas fa-eye-slash');
            }
        });
        $("#changePasswordBtn_temp").click(function () {
            var new_password = $("#new_password").val();
            var retype_password = $("#retype_password").val();
            if (new_password != "" && retype_password != "") {
                if (new_password != retype_password) {
                    $('#retype_password-status').html('Both password must be same.!!').css({'color':'red','font-size':'18px'});
                    $('#retype_password').addClass('border-danger');
                }else{
                    $('#retype_password-status').html('').css({'color':'green'});
                    $('#retype_password').removeClass('border-danger');
                    $("#changePasswordBtn").click();
                }
            }else{
                $('#retype_password-status').html('').css({'color':'green'});
                $('#retype_password').removeClass('border-danger');
                $("#changePasswordBtn").click();
            }
        });
    </script>
</body>
</html>