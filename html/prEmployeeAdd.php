<?php
include_once 'ltr/header.php';
include_once 'connection.php';
$_SESSION['pageName'] = "prEmployeeAdd";
?>
<!DOCTYPE html>
<html>

<head>
    <title>Employee Add</title>
    <!-- <?php include 'include/header.php'; ?> -->

</head>

<body>

    <!-- <?php include 'include/sidebar.php'; ?> -->
    <!-- <div class="page-wrapper"> -->
    <div class="page-breadcrumb d-none">
        <div class="row">
            <div class="col-6 d-flex no-block align-items-center">
                <div>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Employee Add</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="col-6">
                <div class="text-right">
                    <a href="EmployeeMaster" class="btn btn-success">View</a>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid ">
        <div class="col-12">
            <?php if (isset($msg)) { ?>
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong><?php echo $msg; ?></strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php } ?>
            <div class="col-md-12">
                <div class="card">
                    <form name="Employee" id="NewEmployeeForm" name="NewEmployeeForm" action="prEmployeeMaster"
                        method="post" enctype="multipart/form-data">
                        <br>
                        <h2 class="text-center">Employee Master</h2>
                        <!-- <center><h2 class="card-title">Employee Master</h2></center> -->
                        <div class="accordion" id="accordionExample">
                            <div class="card">

                                <div class="card-header" id="headingOne">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link btn-block text-left" type="button"
                                            data-toggle="collapse" data-target="#collapseOne" aria-expanded="true"
                                            aria-controls="collapseOne">
                                            Personal Details
                                        </button>
                                    </h2>
                                </div>

                                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne"
                                    data-parent="#accordionExample">
                                    <div class="card-body">
                                        <div class=" row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Intials :</label>
                                                    <select class="form-control" name="Intials" id="Intials"
                                                        required="">
                                                        <option value="Mr">Mr.</option>
                                                        <option value="MS">MS.</option>
                                                        <option value="Mrs">Mrs.</option>
                                                        <option value="Dr">Dr.</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>First Name :</label>
                                                    <!-- <input class="form-control" name="EmployeeFirstName" id="EmployeeFirstName" type="text" placeholder="Enter First Name" maxlength="40" onkeypress="isInputchar(event)" required>
                                                            <span class="error-form" id="EmployeeFirstName_error_message" style="color: red;"></span> -->
                                                    <select name="EmployeeFirstName" 
                                                        class="form-control w-100 EmployeeFirstName" style="width:100%;"
                                                        id="ClientNameSelect1" required>
                                                        <?php if (isset($_POST['editPanbtn'])) { echo "disabled"; }?>>
                                                        <?php 
                                                                $fetch_Client = "SELECT `firstname` FROM `users` WHERE `company_id` = '".$_SESSION['company_id']."' ORDER BY `firstname` ASC";
                                                                $run_fetch_Client = mysqli_query($con,$fetch_Client);
                                                                while ($row = mysqli_fetch_array($run_fetch_Client)) { ?>
                                                        <option value="<?= $row['firstname']; ?>">
                                                            <?= $row['firstname']; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Middle Name :</label>
                                                    <input readonly class="form-control" name="temp_EmployeeMiddleName"
                                                        id="temp_EmployeeMiddleName" maxlength="40" type="text"
                                                        placeholder="Enter Middle Name" onkeypress="isInputchar(event)"
                                                        required>
                                                    <span class="error-form" id="EmployeeMiddleName_error_message"
                                                        style="color: red;"></span>
                                                    <input type="hidden" readonly name="EmployeeMiddleName" id="EmployeeMiddleName">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Last Name :</label>
                                                    <input readonly class="form-control" name="temp_EmployeeLastName"
                                                        id="temp_EmployeeLastName" maxlength="40" type="text"
                                                        placeholder="Enter Last Name" onkeypress="isInputchar(event)"
                                                        required>
                                                    <span class="error-form" id="temp_EmployeeLastName_error_message"
                                                        style="color: red;"></span>
                                                    <input type="hidden" readonly name="EmployeeLastName"
                                                        id="EmployeeLastName">
                                                </div>
                                            </div>
                                        </div>
                                        <div class=" row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Address :</label>

                                                    <textarea class="form-control" name="EmployeeAddress"
                                                        id="EmployeeAddress" cols="30" rows="2"
                                                        placeholder="Enter Address" maxlength="600"
                                                        required></textarea>
                                                    <span class="error-form" id="EmployeeAddress_error_message"
                                                        style="color: red;"></span>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>State :</label>
                                                    <input class="form-control" name="EmployeeState" id="EmployeeState"
                                                        type="text" onkeypress="isInputchar(event)" maxlength="30"
                                                        placeholder="Enter State" required>
                                                    <span class="error-form" id="state_error_message"
                                                        style="color: red;"></span>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>District :</label>
                                                    <input class="form-control" name="EmployeeCity" id="EmployeeCity"
                                                        type="text" maxlength="30" onkeypress="isInputchar(event)"
                                                        placeholder="Enter District" required>
                                                    <span class="error-form" id="city_error_message"
                                                        style="color: red;"></span>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Pin Code :</label>
                                                    <input class="form-control" name="EmployeePinCode"
                                                        id="EmployeePinCode" type="text" placeholder="Enter Pin Code"
                                                        maxlength="6" minlength="6" onkeypress="isInputpincode(event)"
                                                        required>
                                                </div>
                                                <span class="error-form" id="pincode_error_message"
                                                    style="color: red;"></span>
                                            </div>
                                        </div>
                                        <div class=" row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Department :</label>
                                                    <input readonly class="form-control" name="temp_EmployeeDepartment" id="temp_EmployeeDepartment" maxlength="40" type="text" required placeholder="Enter Department" onkeypress="isInputchar(event)" >
                                                    <span class="error-form" id="EmployeeDepartment_error_message" style="color: red;"></span>
                                                    <input type="hidden" readonly name="EmployeeDepartment" id="EmployeeDepartment">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Designation :</label>
                                                    <input readonly class="form-control" name="temp_EmployeeDesignation" id="temp_EmployeeDesignation" required maxlength="40" type="text" placeholder="Enter Designation" onkeypress="isInputchar(event)" >
                                                    <span class="error-form" id="EmployeeDesignation_error_message" style="color: red;"></span>
                                                    <input type="hidden" readonly name="EmployeeDesignation" id="EmployeeDesignation">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Mobile No :</label>
                                                    <input class="form-control" name="EmployeeMobileNo"
                                                        id="EmployeeMobileNo" type="text" minlength="10" maxlength="10"
                                                        onkeypress="isInputNumber(event)" placeholder="Enter Mobile No"
                                                        required>
                                                    <span class="error-form" id="MobileNo_error_message"
                                                        style="color: red;"></span>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Email Id :</label>
                                                    <input class="form-control" onkeypress="isInputEmail(event)"
                                                        name="EmployeeEmailId" id="EmployeeEmailId" type="email"
                                                        maxlength="40" placeholder="Enter Email Id" required>
                                                    <span class="error-form" id="Emailid_error_message"
                                                        style="color: red;"></span>
                                                    <span id="span1" style="color: red;"
                                                        class="error-form d-none">Sorry, only letters (a-z), number
                                                        (0-9), and periods (.) are allowed</span>
                                                    <span id="span2" style="color: red;" class="error-form d-none">Email
                                                        Id Required</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>UAN No :</label>
                                                    <input class="form-control" maxlength="12" name="EmployeeUanNo"
                                                        id="EmployeeUanNo" type="text" placeholder="Enter UAN No"
                                                        onkeypress="isInputNumber(event)" required>
                                                    <span class="error-form" id="una_no_error_message"
                                                        style="color: red;"></span>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>PF No :</label>
                                                    <input class="form-control" maxlength="30" name="EmployeePfNo"
                                                        id="EmployeePfNo" type="text" placeholder="Enter Pf No"
                                                        onkeypress="isInputall(event)" required>
                                                    <span class="error-form" id="Employeepf_error_message"
                                                        style="color: red;"></span>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Date of Join :</label>
                                                    <input class="form-control" name="Date_of_Join" id="Date_of_Join"
                                                        type="date" placeholder="Select Date of Join" required>
                                                    <span class="error-form" id="EmployeeDate_of_Join_error_message"
                                                        style="color: red;"></span>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Aadhar No.:</label>
                                                    <input class="form-control" maxlength="12"
                                                        name="EmployeeAdharNumber" id="EmployeeAdharNumber" type="text"
                                                        placeholder="Enter Employee Adhar No" required>
                                                    <span class="error-form" id="EmployeeAdharNumber_error_message"
                                                        style="color: red;"></span>
                                                </div>

                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>PAN No.:</label>
                                                    <input class="form-control" maxlength="10" name="EmployeePanNumber"
                                                        id="EmployeePanNumber" type="text"
                                                        placeholder="Enter Employee PAN No " required>
                                                    <span class="error-form" id="EmployeeAdharNumber_error_message"
                                                        style="color: red;"></span>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="headingTwo">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link btn-block text-left collapsed" type="button"
                                            data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false"
                                            aria-controls="collapseTwo">
                                            Education details
                                        </button>
                                    </h2>
                                </div>
                                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo"
                                    data-parent="#accordionExample">
                                    <div class="card-body">
                                        <div class="row">
                                            <table class="table" id="dynamic_field1">
                                                <tr id="Edu_row0">
                                                    <td>
                                                        <strong class="float-left">Education Leval :</strong>
                                                        <select class="form-control p-2 EducationSelect"
                                                            name="EducationSelect[]" id="EducationSelect">
                                                            <option value="SSC">SSC</option>
                                                            <option value="HSC">HSC</option>
                                                            <option value="Degree">Degree</option>
                                                            <option value="Post_Graduation">Post Graduation</option>
                                                            <option value="Diploma">Diploma</option>
                                                            <option value="Certificate">Certificate</option>
                                                            <option value="P.G.Diploma">P.G.Diploma</option>
                                                            <option value="M.Phil">M.Phil</option>
                                                            <option value="Ph.D">Ph.D</option>
                                                            <option value="Other">Other</option>
                                                        </select>
                                                        <br>
                                                        <input type="text" name="other1[]" placeholder="Enter Other"
                                                            onkeypress="isInputchar(event)" id="other1" maxlength="30"
                                                            class="form-control other1 d-none">
                                                    </td>
                                                    <td>
                                                        <strong class="float-left">Degree Name:</strong>
                                                        <input type="text" name="Degree_Name[]"
                                                            placeholder="Enter Degree Name" id="Degree_Name"
                                                            maxlength="40" onkeypress="isInputchar(event)"
                                                            class="form-control">
                                                    </td>
                                                    <td>
                                                        <strong class="float-left">Board / University:</strong>
                                                        <input type="text" name="BoardUniversity[]"
                                                            placeholder="Enter Board / University Name"
                                                            id="BoardUniversity" maxlength="40"
                                                            onkeypress="isInputchar(event)" class="form-control">
                                                    </td>
                                                    <td>
                                                        <strong class="float-left">Passing Year:</strong>
                                                        <input type="text" name="PassingYear[]"
                                                            placeholder="Enter Passing Year" maxlength="4" minlength="4"
                                                            onkeypress="isInputNumber(event)" id="PassingYear"
                                                            class="form-control">
                                                    </td>
                                                    <td>
                                                        <strong class="float-left">Result In :</strong>
                                                        <select class="form-control p-2" name="ResultIn[]"
                                                            id="ResultIn">
                                                            <option value="Percentage">Percentage</option>
                                                            <option value="CGPA">CGPA</option>

                                                        </select>

                                                    </td>
                                                    <td>
                                                        <strong class="float-left">Percentage / CGPA:</strong>
                                                        <input type="text" maxlength="5" min="0" max="100"
                                                            name="PercentageCgpa[]"
                                                            placeholder="Enter Percentage / CGPA" id="PercentageCgpa"
                                                            onkeypress="isInputNumberSpe(event)"
                                                            onkeyup="checkDec(this);" class="form-control">
                                                    </td>
                                                    <td><button type="button" name="remove" id="0"
                                                            class="btn btn-danger Edu_btn_remove">X</button></td>

                                                </tr>
                                                <div class="w-100">
                                                    <button type="button" name="education_add" id="education_add"
                                                        class="btn btn-success float-right">Add More</button>
                                                </div>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="headingThree">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link btn-block text-left collapsed" type="button"
                                            data-toggle="collapse" data-target="#collapseThree" aria-expanded="false"
                                            aria-controls="collapseThree">
                                            Bank Details
                                        </button>
                                    </h2>
                                </div>
                                <div id="collapseThree" class="collapse" aria-labelledby="headingThree"
                                    data-parent="#accordionExample">
                                    <div class="card-body">
                                        <div class=" row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Bank Name :</label>
                                                    <input class="form-control" name="BankName" id="BankName"
                                                        type="text" onkeypress="isInputchar(event)" maxlength="30"
                                                        placeholder="Enter Bank Name" required>
                                                    <span class="error-form" id="BankName_error_message"
                                                        style="color: red;"></span>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Branch Name :</label>
                                                    <input class="form-control" name="BranchName" id="BranchName"
                                                        type="text" maxlength="30" onkeypress="isInputchar(event)"
                                                        placeholder="Enter Branch Name" required>
                                                    <span class="error-form" id="BranchName_error_message"
                                                        style="color: red;"></span>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Branch Code :</label>
                                                    <input class="form-control" name="BranchCode" id="BranchCode"
                                                        type="text" onkeypress="isInputall(event)" maxlength="30"
                                                        placeholder="Enter Branch Code" required>
                                                    <span class="error-form" id="BranchCode_error_message"
                                                        style="color: red;"></span>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Account No :</label>
                                                    <input class="form-control" name="Accountno" id="Accountno"
                                                        type="text" maxlength="30" onkeypress="isInputNumber(event)"
                                                        placeholder="Enter Account No" required>
                                                    <span class="error-form" id="Accountno_error_message"
                                                        style="color: red;"></span>
                                                </div>
                                            </div>

                                        </div>
                                        <div class=" row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>MICR No:</label>
                                                    <input class="form-control" name="MicrNo" id="MicrNo" type="text"
                                                        onkeypress="isInputall(event)" placeholder="Enter MICR No"
                                                        maxlength="30" required>
                                                    <span class="error-form" id="MicrNo_error_message"
                                                        style="color: red;"></span>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Bank Address :</label>
                                                    <textarea class="form-control" name="BankAddress" id="BankAddress"
                                                        cols="30" rows="2" maxlength="50"
                                                        placeholder="Enter Bank Address"
                                                        onkeypress="isInputaddress(event)" required ></textarea>
                                                    <span class="error-form" id="BankAddress_error_message"
                                                        style="color: red;"></span>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Ifsc Code :</label>
                                                    <input class="form-control" name="EmployeeIfscCode"
                                                        id="EmployeeIfscCode" type="text" maxlength="30"
                                                        placeholder="Enter Ifsc Code" onkeypress="isInputall(event)"
                                                        required>
                                                    <span class="error-form" id="EmployeeIfscCode_error_message"
                                                        style="color: red;"></span>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Bank Holder Name :</label>
                                                    <input class="form-control" name="BankHolderName"
                                                        id="BankHolderName" type="text" maxlength="50"
                                                        placeholder="Enter Bank Holder Name"
                                                        onkeypress="isInputchar(event)" required>
                                                    <span class="error-form" id="BankHolderName_error_message"
                                                        style="color: red;"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="headingFour">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link btn-block text-left collapsed" type="button"
                                            data-toggle="collapse" data-target="#collapseFour" aria-expanded="false"
                                            aria-controls="collapseFour">
                                            Salary Details
                                        </button>
                                    </h2>
                                </div>
                                <div id="collapseFour" class="collapse" aria-labelledby="headingFour"
                                    data-parent="#accordionExample">
                                    <div class="card-body">
                                        <h3>Earning</h3>
                                        <div class=" row">
                                            <div class="col-md-3 pb-4">
                                                <div class="form-group">
                                                    <label>Basic Salary :</label>
                                                    <input class="form-control" name="BasicSalary" id="BasicSalary"
                                                        type="text" maxlength="10" placeholder="Enter Basic Salary"
                                                        onkeyup="checkDec(this);" onkeypress="isInputNumberSpe(event)"
                                                        required>
                                                    <span class="error-form" id="BasicSalary_error_message"
                                                        style="color: red;"></span>
                                                </div>
                                            </div>
                                            <div class="col-md-3 ">
                                                <div class="form-group">
                                                    <label>Dearness Allowance :</label>
                                                    <select class="form-control mb-2" name="DaType" id="DaType" 
                                                        >
                                                        <option>Percentage</option>
                                                        <option>Amount</option>
                                                    </select>

                                                    <input class="form-control" maxlength="10" name="Da" id="Da"
                                                        type="text" placeholder="Enter Dearness Allowance" value=0
                                                        onkeypress="isInputNumberSpe(event)" 
                                                        onkeyup="checkDec(this);">
                                                    <span class="error-form" id="Da_error_message"
                                                        style="color: red;"></span>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>House Rent Allowance :</label>
                                                    <select class="form-control mb-2" name="HraType" id="HraType"
                                                        >
                                                        <option>Percentage</option>
                                                        <option>Amount</option>
                                                    </select>
                                                    <input class="form-control" name="Hra" maxlength="10" id="Hra"
                                                        type="text" onkeypress="isInputNumberSpe(event)" value=0
                                                        onkeyup="checkDec(this);"
                                                        placeholder="Enter House Rent Allowance" >
                                                    <span class="error-form" id="Hra_error_message"
                                                        style="color: red;"></span>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Travelling Allowance :</label>
                                                    <select class="form-control mb-2" name="TaType" id="TaType"
                                                        >

                                                        <option>Amount</option>
                                                        <option>Percentage</option>

                                                    </select>

                                                    <input class="form-control" name="Ta" maxlength="10" id="Ta"
                                                        type="test" onkeypress="isInputNumberSpe(event)"
                                                        onkeyup="checkDec(this);" value=0
                                                        placeholder="Enter Travelling Allowance" >
                                                    <span class="error-form" id="Ta_error_message"
                                                        style="color: red;"></span>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class=" row">
                                            <div class="col-md-3 pb-4">
                                                <div class="form-group">
                                                    <label>Medical Allowance :</label>
                                                    <select class="form-control mb-2" name="MedicalExpensesType" id="MedicalExpensesType">
                                                        <option>Amount</option>
                                                        <option>Percentage</option>
                                                    </select>
                                                    <input class="form-control" name="MedicalExpenses" id="MedicalExpenses" type="text" maxlength="10" placeholder="Enter Medical Expenses" value="0" onkeypress="isInputNumberSpe(event)" onkeyup="checkDec(this);">
                                                    <span class="error-form" id="MedicalExpenses_error_message" style="color: red;"></span>
                                                </div>
                                            </div>
                                            <div class="col-md-3 ">
                                                <div class="form-group">
                                                    <label>CA :</label>
                                                    <select class="form-control mb-2" name="CaEarningType" id="CaEarningType">
                                                        <option>Amount</option>
                                                        <option>Percentage</option>
                                                    </select>
                                                    <input class="form-control" name="CaEarning" id="CaEarning" type="text" maxlength="10" placeholder="Enter CA Earning" value="0" onkeyup="checkDec(this);" onkeypress="isInputNumberSpe(event)">
                                                    <span class="error-form" id="CaEarning_error_message" style="color: red;"></span>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>SA :</label>
                                                    <select class="form-control mb-2" name="SaEarningType" id="SaEarningType">
                                                        <option>Amount</option>
                                                        <option>Percentage</option>
                                                    </select>
                                                    <input class="form-control" name="SaEarning" id="SaEarning" type="text" maxlength="10" placeholder="Enter SA Earning" value="0" onkeyup="checkDec(this);" onkeypress="isInputNumberSpe(event)">
                                                    <span class="error-form" id="SaEarning_error_message" style="color: red;"></span>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Other :</label>
                                                    <select class="form-control mb-2" name="OtherEarningType" id="OtherEarningType">
                                                        <option>Amount</option>
                                                        <option>Percentage</option>
                                                    </select>
                                                    <input class="form-control" name="OtherEarning" id="OtherEarning" type="text" maxlength="10" placeholder="Enter Other Earning" value="0" onkeyup="checkDec(this);" onkeypress="isInputNumberSpe(event)">
                                                    <span class="error-form" id="OtherEarning_error_message" style="color: red;"></span>
                                                </div>
                                            </div>
                                        </div>
                                        

                                    <div class="card-body">
                                        <h3>Deduction</h3>
                                        <div class=" row">
                                            <div class="col-md-3 pb-4"> 
                                               <div class="form-group">
                                                    <label>Provident Fund :</label>
                                                    <select class="form-control mb-2" name="PFType" id="PFType"
                                                        >

                                                        <option>Percentage</option>
                                                        <option>Amount</option>

                                                    </select>

                                                    <input class="form-control" name="PF" maxlength="10" id="PF"
                                                        type="text" onkeypress="isInputNumberSpe(event)" value=0
                                                        placeholder="Enter Provident Fund" >
                                                    <span class="error-form" onkeyup="checkDec(this);"
                                                        id="PF_error_message" style="color: red;"></span>
                                                </div>
                                            </div>
                                            <div class="col-md-3 ">
                                                <div class="form-group">
                                                    <label>Professional Tax:</label>
                                                    <select class="form-control mb-2" name="PTType" id="PTType"
                                                        >

                                                        <option>Amount</option>
                                                        <option>Percentage</option>

                                                    </select>

                                                    <input class="form-control" name="PR" maxlength="10" id="PR"
                                                        type="text" placeholder="Enter Professional Tax" value=0
                                                        onkeypress="isInputNumberSpe(event)" >
                                                    <span class="error-form" onkeyup="checkDec(this);"
                                                        id="PR_error_message" style="color: red;"></span>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>ESI:</label>
                                                    <select class="form-control mb-2" name="esiType" id="esiType">
                                                        <option>Amount</option>
                                                        <option>Percentage</option>

                                                    </select>

                                                    <input class="form-control" name="esi" maxlength="10" id="esi"
                                                        type="text" placeholder="Enter Professional Tax" value=0
                                                        onkeypress="isInputNumberSpe(event)" >
                                                    <span class="error-form" onkeyup="checkDec(this);"
                                                        id="PR_error_message" style="color: red;"></span>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Income Tax:</label>

                                                    <input class="form-control mb-2" maxlength="10" name="IncomeTex" value=0
                                                        id="IncomeTex" type="text" onkeypress="isInputNumberSpe(event)"
                                                        onkeyup="checkDec(this);" placeholder="Enter Income Tax"
                                                        >
                                                    <span class="error-form" id="IncomeTex_error_message"
                                                        style="color: red;"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class=" row">
                                            <div class="col-md-3 pb-4">
                                                <div class="form-group">
                                                    <label>TDS:</label>
                                                    <select class="form-control mb-2" name="tds_type" id="tds_type">
                                                        <option>Amount</option>
                                                        <option>Percentage</option>

                                                    </select>
                                                    <input class="form-control mb-2" maxlength="10" name="tds" value=0
                                                        id="tds" type="text" onkeypress="isInputNumberSpe(event)"
                                                        onkeyup="checkDec(this);" placeholder="Enter Income Tax"
                                                        >
                                                    <span class="error-form" id="IncomeTex_error_message"
                                                        style="color: red;"></span>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Insurance:</label>
                                                    <select class="form-control mb-2" name="inso_type" id="inso_type">
                                                        <option>Amount</option>
                                                        <option>Percentage</option>

                                                    </select>
                                                    <input class="form-control mb-2" maxlength="10" name="IncomeTex" value=0
                                                        id="IncomeTex" type="text" onkeypress="isInputNumberSpe(event)"
                                                        onkeyup="checkDec(this);" placeholder="Enter Income Tax"
                                                        >
                                                    <span class="error-form" id="IncomeTex_error_message"
                                                        style="color: red;"></span>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Other :</label>
                                                    <select class="form-control mb-2" name="OtherType" id="OtherType"
                                                        >

                                                        <option>Amount</option>
                                                        <option>Percentage</option>

                                                    </select>

                                                    <input class="form-control" name="Other" id="Other" type="text"
                                                        onkeypress="isInputNumberSpe(event)" maxlength="10" value=0
                                                        placeholder="Enter Other" >
                                                    <span class="error-form" onkeyup="checkDec(this);"
                                                        id="Other_error_message" style="color: red;"></span>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Salary Advance:</label>
                                                    <select class="form-control mb-2" name="SalaryAdvanceType"
                                                        id="SalaryAdvanceType" >
                                                        <option>Amount</option>
                                                        <option>Percentage</option>

                                                    </select>

                                                    <input class="form-control" name="SalaryAdvance" id="SalaryAdvance"
                                                        type="text" onkeypress="isInputNumberSpe(event)"
                                                        onkeyup="checkDec(this);" maxlength="10" value=0
                                                        placeholder="Enter Salary Advance" >
                                                    <span class="error-form" id="SalaryAdvance_error_message"
                                                        style="color: red;"></span>
                                                </div>
                                            </div>

                                        </div>
                                        <div class=" row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>EMI :</label>

                                                    <input class="form-control" maxlength="10" name="EMI" id="EMI"
                                                        type="text" onkeypress="isInputNumberSpe(event)" value=0
                                                        placeholder="Enter EMI" onkeyup="checkDec(this);" >
                                                    <span class="error-form" id="EMI_error_message"
                                                        style="color: red;"></span>

                                                </div>
                                            </div>
                                            <!--<div class="col-md-3 pb-4">-->
                                                
                                            <!--</div>-->
                                            <!--<div class="col-md-3">-->
                                                
                                            <!--</div>-->
                                            <!--<div class="col-md-3">-->
                                                
                                            <!--</div>-->

                                        </div>
                                        <!--<div class=" row">-->
                                        <!--    <div class="col-md-3 pb-4">-->
                                                
                                        <!--    </div>-->
                                        <!--    <div class="col-md-3">-->
                                                
                                        <!--    </div>-->
                                        <!--    <div class="col-md-3">-->
                                                
                                        <!--    </div>-->
                                        <!--    <div class="col-md-3">-->
                                        <!--        <div class="form-group">-->
                                        <!--            <label>Loan Paid :</label>-->
                                        <!--            <select class="form-control mb-2" name="LoanPaidType"-->
                                        <!--                id="LoanPaidType" >-->
                                        <!--                <option>Amount</option>-->
                                        <!--                <option>Percentage</option>-->

                                        <!--            </select>-->

                                        <!--            <input class="form-control" name="LoanPaid" id="LoanPaid"-->
                                        <!--                type="text" onkeypress="isInputNumberSpe(event)" maxlength="10" value=0-->
                                        <!--                placeholder="Enter Loan Paid" >-->
                                        <!--            <span class="error-form" onkeyup="checkDec(this);"-->
                                        <!--                id="LoanPaid_error_message" style="color: red;"></span>-->
                                        <!--        </div>-->
                                        <!--    </div>-->
                                        <!--</div>-->
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="headingFive">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link btn-block text-left collapsed" type="button"
                                            data-toggle="collapse" data-target="#collapsefive" aria-expanded="false"
                                            aria-controls="collapsefive">
                                            Documents
                                        </button>
                                    </h2>
                                </div>
                                <div id="collapsefive" class="collapse" aria-labelledby="headingFive"
                                    data-parent="#accordionExample">
                                    <div class="card-body">
                                        <div class="row">
                                            <table class="table col-md-12" id="dynamic_field">
                                                <tr id="row0">
                                                    <td>
                                                        <label>Document Name :</label>
                                                        <select class="form-control Documents" name="Documents[]"
                                                            id="Documents">

                                                            <option value="SSC_Marksheet">SSC Marksheet</option>
                                                            <option value="HSC_Marksheet">HSC Marksheet</option>
                                                            <option value="Leaving_Certificate">Leaving Certificate
                                                            </option>
                                                            <option value="Graduation_Certificate"> Graduation
                                                                Certificate</option>
                                                            <option value="Post_Graduation_Certificate">Post Graduation
                                                                Certificate</option>
                                                            <option value="Aadhar_Card">Aadhar Card</option>
                                                            <option value="Pan_Card">Pan Card</option>
                                                            <option value="Photograph">Photograph</option>
                                                            <option value="Experience_Letter">Experience Letter</option>
                                                            <option value="Other">Other</option>
                                                        </select>
                                                        <br>
                                                        <input type="text" name="other2[]" placeholder="Enter Other"
                                                            id="other2" onkeypress="isInputchar(event)" maxlength="30"
                                                            class="form-control other2 d-none">
                                                    </td>
                                                    <td>
                                                        <strong class="float-left">Document Upload:</strong>
                                                        <input type="file" name="DocumentUpload[]" id="DocumentUpload"
                                                            class="form-control" accept=".pdf,image/x-png,image/jpeg"
                                                            placeholder="Choose Document 3"
                                                            onchange="validate_fileupload(this.value, this.id);">
                                                    </td>
                                                    <td>
                                                        <label>Remark :</label>
                                                        <textarea class="form-control" name="Comment[]" id="Comment"
                                                            cols="30" rows="2" onkeypress="isInputchar(event)"
                                                            maxlength="200" placeholder="Enter Remark"></textarea>
                                                    </td>
                                                    <td>
                                                    <td><button type="button" name="remove" id="0"
                                                            class="btn btn-danger Doc_btn_remove">X</button></td>
                                                    <td>
                                                </tr>
                                                <div class="w-100">
                                                    <button type="button" name="add" id="add"
                                                        class="btn btn-success float-right">Add More</button></td>
                                                </div>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="headingSix">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link btn-block text-left collapsed" type="button"
                                            data-toggle="collapse" data-target="#collapseSix" aria-expanded="false"
                                            aria-controls="collapseSix">
                                            Leave
                                        </button>
                                    </h2>
                                </div>
                                <div id="collapseSix" class="collapse" aria-labelledby="headingSix"
                                    data-parent="#accordionExample">
                                    <div class="card-body">
                                        <div class=" row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Casual Leave :</label>
                                                    <input class="form-control" name="CasualLeave" id="CasualLeave"
                                                        type="text" placeholder="Enter No Of Casual Leave"
                                                        onkeypress="isInputNumberSpe(event)" onkeyup="checkDec(this);"
                                                        maxlength="10" required>
                                                    <span class="error-form" id="CasualLeave_error_message"
                                                        style="color: red;"></span>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Sick Leave :</label>
                                                    <input class="form-control" name="SickLeave" id="SickLeave"
                                                        type="text" placeholder="Enter No Of Sick Leave"
                                                        onkeypress="isInputNumberSpe(event)" maxlength="10" required>
                                                    <span class="error-form" onkeyup="checkDec(this);"
                                                        id="SickLeave_error_message" style="color: red;"></span>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Earned Leave :</label>
                                                    <input class="form-control" name="EarnedLeave" id="EarnedLeave"
                                                        type="text" placeholder="Enter No Of Earned Leave"
                                                        onkeypress="isInputNumberSpe(event)" maxlength="10"
                                                        onkeyup="checkDec(this);" required>
                                                    <span class="error-form" id="EarnedLeave_error_message"
                                                        style="color: red;"></span>
                                                </div>
                                                <!-- Status Start Here -->
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <input class="form-control" name="status" id="status" required
                                                            type="hidden" value="0" placeholder="status">
                                                    </div>
                                                </div>
                                                <!-- End Here -->
                                            </div>
                                                <div class="form-group">
                                                    <label>Maternity Leave:</label>
                                                    <input class="form-control" name="MaternityLeave" id="MaternityLeave"
                                                        type="text" placeholder="Enter No Of Maternity Leave"
                                                        onkeypress="isInputNumberSpe(event)" maxlength="10"
                                                        onkeyup="checkDec(this);" required>
                                                    <span class="error-form" id="MaternityLeave_error_message"
                                                        style="color: red;"></span>
                                                </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <center><input type="submit" name="submit" id="submit" class="btn btn-primary"
                                            value="Add"></center>
                                </div>
                            </div>
                        </div>
                </div>

                </form>

            </div>
        </div>
    </div>
    </div>
    <!-- <?php include 'include/footer.php'; ?> -->


</body>
<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> -->

<script type="text/javascript">
function checkDec(el) {
    // alert("Hello Anddroid???");
    var ex = /^[0-9]+\.?[0-9]*$/;

    if (ex.test(el.value) == false) {
        el.value = el.value.substring(0, el.value.length - 1);
    }

}

function validate_fileupload(fileName, id) {
    var allowed_extensions = new Array("jpg", "png", "pdf");
    var file_extension = fileName.split('.').pop().toLowerCase();
    var flag = false;
    for (var i = 0; i < allowed_extensions.length; i++) {
        if (allowed_extensions[i] == file_extension) {
            flag = true;
            break;
        }
    }
    if (flag == true) {
        return true;
    } else {
        $("#" + id).val('');
        alert("Please select file in (jpg/png/pdf) format");
        return false;
    }
}
</script>
<!-- <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script> -->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
                <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> -->
<script type="text/javascript">
$(document).ready(function() {
    function getLastName() {
        var ClientNameSelect1 = $("#ClientNameSelect1").val();
        $.ajax({
            url: "html/ProcessPrEmployeeAdd.php",
            method: "post",
            data: {
                ClientNameSelect1: ClientNameSelect1
            },
            dataType: "text",
            success: function(data) {
                // alert(data);
                var array = JSON.parse(data);
                $('#temp_EmployeeLastName').val(array[0]);
                $('#EmployeeLastName').val(array[0]);
                $('#temp_EmployeeMiddleName').val(array[1]);
                $('#EmployeeMiddleName').val(array[1]);
                $('#temp_EmployeeDepartment').val(array[2]);
                $('#EmployeeDepartment').val(array[2]);
                $('#temp_EmployeeDesignation').val(array[3]);
                $('#EmployeeDesignation').val(array[3]);
            }
        });
    }
    getLastName();
    $('#ClientNameSelect1').on("change", function(e) {
        getLastName();
    });
    var i = 0;
    $('#add').click(function() {
        i++;
        var newRow = '<tr id="row' + i +
            '"><td ><label>Document Name :</label><select class="form-control Documents" name="Documents[]" id="Documents" ><option value="SSC_Marksheet">SSC Marksheet</option><option value="HSC_Marksheet">HSC Marksheet</option><option value="Leaving_Certificate">Leaving Certificate</option><option value="Graduation_Certificate">Graduation Certificate</option><option value="Post_Graduation_Certificate">Post Graduation Certificate</option><option value="Aadhar_Card">Aadhar Card</option><option value="Pan_Card">Pan Card</option><option value="Photograph">Photograph</option><option value="Experience_Letter">Experience Letter</option><option value="Other">Other</option></select><br><input type="text" name="other2[]" placeholder="Enter Other" id="other2" maxlength="30" onkeypress="isInputchar(event)" class="form-control d-none other2"></td><td><strong class="float-left">Document Upload:</strong><input type="file" name="DocumentUpload[]"  id="DocumentUpload" class="form-control" accept=".pdf,image/x-png,image/jpeg" placeholder="Choose Document 3" onchange="validate_fileupload(this.value, this.id);"></td><td ><label>Comment :</label><textarea class="form-control" name="Comment[]" onkeypress="isInputchar(event)" id="Comment" cols="30" rows="2" maxlength="200" placeholder="Enter Comment"></textarea></td><td><button type="button" name="remove" id="' +
            i + '" class="btn btn-danger Doc_btn_remove">X</button></td></tr>';
        $('#dynamic_field').append(newRow);
    });
    $(document).on('click', '.Doc_btn_remove', function() {
        var button_id = $(this).attr("id");
        $('#row' + button_id + '').remove();
    });

    $('#dynamic_field').on('change', '.Documents', function() {
        var row_Index = $(this).closest('tr').find('.Documents').val();

        if ($(this).closest('tr').find('.Documents').val() == 'Other') {

            $(this).closest('tr').find('.Documents').closest('tr td').find('.other2').removeClass(
                'd-none');
            $(this).closest('tr').find('.Documents').closest('tr td').find('.other2').addClass(
                'd-block');
        } else {
            $(this).closest('tr').find('.Documents').closest('tr td').find('.other2').removeClass(
                'd-block');
            $(this).closest('tr').find('.Documents').closest('tr td').find('.other2').addClass(
                'd-none');
        }
    });
    var j = 0;
    $('#education_add').click(function() {
        j++;

        var newRow = '<tr id="Edu_row' + j +
            '"><td><strong class="float-left">Degree:</strong><select class="form-control EducationSelect" name="EducationSelect[]" id="EducationSelect" ><option value="SSC_Marksheet">SSC Marksheet</option><option value="HSC_Marksheet">HSC Marksheet</option><option value="Leaving_Certificate">Leaving Certificate</option><option value="Graduation_Certificate">Graduation Certificate</option><option value="Post_Graduation_Certificate">Post Graduation Certificate</option><option value="Other">Other</option></select><br><input type="text" name="other1[]" placeholder="Enter Other" maxlength="30" onkeypress="isInputchar(event)" id="other1" class="form-control d-none other1"></td><td><strong class="float-left">Degree Name:</strong><input type="text" name="Degree_Name[]" placeholder="Enter Degree Name" id="Degree_Name" maxlength="40" onkeypress="isInputchar(event)" class="form-control"></td><td><strong class="float-left">Board / University:</strong><input type="text" name="BoardUniversity[]" onkeypress="isInputchar(event)" maxlength="40" placeholder="Enter Board / University Name"  id="BoardUniversity" class="form-control"></td><td><strong class="float-left">Passing Year:</strong><input type="text" name="PassingYear[]" placeholder="Enter Passing Year" onkeypress="isInputNumber(event)" maxlength="4" id="PassingYear" class="form-control"></td><td><strong class="float-left">Result IN :</strong><select class="form-control p-2" name="ResultIn[]" id="Result"><option value="Percentage">Percentage</option><option value="CGPA">CGPA</option></select></td><td><strong class="float-left">Percentage / CGPA:</strong><input type="text" maxlength="5" onkeypress="isInputNumber(event)" name="PercentageCgpa[]" placeholder="Enter Percentage / CGPA" id="PercentageCgpa" class="form-control"></td><td><button type="button" name="remove" id="' +
            j + '" class="btn btn-danger Edu_btn_remove">X</button></td></tr>';
        $('#dynamic_field1').append(newRow);

    });
    $(document).on('click', '.Edu_btn_remove', function() {
        var button_id = $(this).attr("id");
        $('#Edu_row' + button_id + '').remove();
    });


    $('#dynamic_field1').on('change', '.EducationSelect', function() {
        var row_Index = $(this).closest('tr').find('.EducationSelect').val();

        if ($(this).closest('tr').find('.EducationSelect').val() == 'Other') {

            $(this).closest('tr').find('.EducationSelect').closest('tr td').find('.other1').removeClass(
                'd-none');
            $(this).closest('tr').find('.EducationSelect').closest('tr td').find('.other1').addClass(
                'd-block');
        } else {
            $(this).closest('tr').find('.EducationSelect').closest('tr td').find('.other1').removeClass(
                'd-block');
            $(this).closest('tr').find('.EducationSelect').closest('tr td').find('.other1').addClass(
                'd-none');
        }
    });

    $('.btn_view').change
});

function isInputNumber(evt) {
    var ch = String.fromCharCode(evt.which);
    if (!(/[0-9]/.test(ch))) {
        evt.preventDefault();
    }
}

function isInputchar(evt) {
    var cha = String.fromCharCode(evt.which);
    if (!(/[a-z,A-Z, ,]/.test(cha))) {
        evt.preventDefault();
    }
}

function isInputEmail(evt) {
    var cha = String.fromCharCode(evt.which);
    if (!(/[a-z,A-Z,0-9,@,.]/.test(cha))) {
        evt.preventDefault();
    }
}

function isInputall(evt) {
    var cha = String.fromCharCode(evt.which);
    if (!(/[a-z,A-Z,0-9]/.test(cha))) {
        evt.preventDefault();
    }
}

function isInputaddress(evt) {
    var cha = String.fromCharCode(evt.which);
    if (!(/[a-z,A-Z,0-9,/,,-, ,]/.test(cha))) {
        evt.preventDefault();
    }
}

function isInputpincode(evt) {
    var cha = String.fromCharCode(evt.which);
    if (!(/[0-9]/.test(cha))) {
        evt.preventDefault();
    }
}

function isInputNumberSpe(evt) {
    var cha = String.fromCharCode(evt.which);
    if (!(/[0-9,.,]/.test(cha))) {
        evt.preventDefault();
    }
}


$(function() {

    $("#EmployeeFirstName_error_message").hide();
    $("#EmployeeMiddleName_error_message").hide();
    $("#EmployeeLastName_error_message").hide();
    $("#EmployeeAddress_error_message").hide();
    $("#state_error_message").hide();
    $("#city_error_message").hide();
    $("#pincode_error_message").hide();
    $("#EmployeeDepartment_error_message").hide();
    $("#EmployeeDesignation_error_message").hide();
    $("#MobileNo_error_message").hide();
    $("#Emailid_error_message").hide();
    $("#una_no_error_message").hide();
    $("#Employeepf_error_message").hide();
    $("#BankName_error_message").hide();
    $("#BranchName_error_message").hide();
    $("#BranchCode_error_message").hide();
    $("#Accountno_error_message").hide();
    $("#MicrNo_error_message").hide();
    $("#BankAddress_error_message").hide();
    $("#EmployeeIfscCode_error_message").hide();
    $("#BankHolderName_error_message").hide();
    $("#BasicSalary_error_message").hide();
    $("#Da_error_message").hide();
    $("#Hra_error_message").hide();
    $("#Ta_error_message").hide();
    $("#MedicalExpenses_error_message").hide();
    $("#OtherEarning_error_message").hide();
    $("#ArrearPayments_error_message").hide();
    $("#LoanReceived_error_message").hide();
    $("#SalaryAdvance_error_message").hide();
    $("#PF_error_message").hide();
    $("#PR_error_message").hide();
    $("#IncomeTex_error_message").hide();
    $("#EMI_error_message").hide();
    $("#Insurance_error_message").hide();
    $("#Other_error_message").hide();
    $("#LoanPaid_error_message").hide();
    $("#CasualLeave_error_message").hide();
    $("#SickLeave_error_message").hide();
    $("#EarnedLeave_error_message").hide();
    $("#MaternityLeave_error_message").hide();




    var EmployeeFirstName_error_message = false;
    var EmployeeMiddleName_error_message = false;
    var EmployeeLastName_error_message = false;
    var EmployeeAddress_error_message = false;
    var state_error_message = false;
    var city_error_message = false;
    var pincode_error_message = false;
    var EmployeeDepartment_error_message = false;
    var EmployeeDesignation_error_message = false;
    var MobileNo_error_message = false;
    var Emailid_error_message = false;
    var una_no_error_message = false;
    var Employeepf_error_message = false;
    var BankName_error_message = false;
    var BranchName_error_message = false;
    var BranchCode_error_message = false;
    var Accountno_error_message = false;
    var MicrNo_error_message = false;
    var BankAddress_error_message = false;
    var EmployeeIfscCode_error_message = false;
    var BankHolderName_error_message = false;
    var BasicSalary_error_message = false;
    var Da_error_message = false;
    var Hra_error_message = false;
    var Ta_error_message = false;
    var MedicalExpenses_error_message = false;
    var OtherEarning_error_message = false;
    var ArrearPayments_error_message = false;
    var LoanReceived_error_message = false;
    var SalaryAdvance_error_message = false;
    var PF_error_message = false;
    var PR_error_message = false;
    var IncomeTex_error_message = false;
    var EMI_error_message = false;
    var Insurance_error_message = false;
    var Other_error_message = false;
    var LoanPaid_error_message = false;
    var CasualLeave_error_message = false;
    var SickLeave_error_message = false;
    var EarnedLeave_error_message = false;
    var MaternityLeave_error_message = false;


    $("#EmployeeFirstName").focusout(function() {
        check_EmployeeFirstName();
    });

    $("#EmployeeMiddleName").focusout(function() {
        check_EmployeeMiddleName();
    });

    $("#EmployeeLastName").focusout(function() {
        check_EmployeeLastName();
    });

    $("#EmployeeAddress").focusout(function() {
        check_EmployeeAddress();
    });

    $("#EmployeeState").focusout(function() {
        check_EmployeeState();
    });

    $("#EmployeeCity").focusout(function() {
        check_EmployeeCity();
    });

    $("#EmployeePinCode").focusout(function() {
        check_EmployeePinCode();
    });

    $("#EmployeeDepartment").focusout(function() {
        check_EmployeeDepartment();
    });

    $("#EmployeeDesignation").focusout(function() {
        check_EmployeeDesignation();
    });

    $("#EmployeeMobileNo").focusout(function() {
        check_EmployeeMobileNo();
    });

    $("#EmployeeEmailId").focusout(function() {
        check_EmployeeEmailId();
    });

    $("#EmployeeUanNo").focusout(function() {
        check_EmployeeUanNo();
    });

    $("#EmployeePfNo").focusout(function() {
        check_EmployeePfNo();
    });

    $("#BankName").focusout(function() {
        check_BankName();
    });

    $("#BranchName").focusout(function() {
        check_BranchName();
    });

    $("#BranchCode").focusout(function() {
        check_BranchCode();
    });

    $("#Accountno").focusout(function() {
        check_Accountno();
    });

    $("#MicrNo").focusout(function() {
        check_MicrNo();
    });

    $("#BankAddress").focusout(function() {
        check_BankAddress();
    });

    $("#EmployeeIfscCode").focusout(function() {
        check_EmployeeIfscCode();
    });

    $("#BankHolderName").focusout(function() {
        check_BankHolderName();
    });

    $("#BasicSalary").focusout(function() {
        check_BasicSalary();
    });

    $("#Da").focusout(function() {
        check_Da();
    });

    $("#Hra").focusout(function() {
        check_Hra();
    });

    $("#Ta").focusout(function() {
        check_Ta();
    });

    $("#MedicalExpenses").focusout(function() {
        check_MedicalExpenses();
    });

    $("#OtherEarning").focusout(function() {
        check_OtherEarning();
    });

    $("#ArrearPayments").focusout(function() {
        check_ArrearPayments();
    });

    $("#LoanReceived").focusout(function() {
        check_LoanReceived();
    });

    $("#SalaryAdvance").focusout(function() {
        check_SalaryAdvance();
    });

    $("#PF").focusout(function() {
        check_PF();
    });

    $("#PR").focusout(function() {
        check_PR();
    });

    $("#IncomeTex").focusout(function() {
        check_IncomeTex();
    });

    $("#EMI").focusout(function() {
        check_EMI();
    });

    $("#Insurance").focusout(function() {
        check_Insurance();
    });

    $("#Other").focusout(function() {
        check_Other();
    });

    $("#LoanPaid").focusout(function() {
        check_LoanPaid();
    });

    $("#CasualLeave").focusout(function() {
        check_CasualLeave();
    });

    $("#SickLeave").focusout(function() {
        check_SickLeave();
    });

    $("#EarnedLeave").focusout(function() {
        check_EarnedLeave();
    });
    
     $("#MaternityLeave").focusout(function() {
        check_MaternityLeave();
    });


    function check_EmployeeFirstName() {
        var EmployeeFirstName = $("#EmployeeFirstName").val().length;

        if (EmployeeFirstName == "") {
            $("#EmployeeFirstName_error_message").html("first name required");
            $("#EmployeeFirstName_error_message").show();
            $("#EmployeeFirstName").css("border-bottom", "2px solid #F90A0A");
            EmployeeFirstName_error_message = true;
        } else {
            $("#EmployeeFirstName_error_message").hide();
            $("#EmployeeFirstName").css("border-bottom", "2px solid #34F458");
        }
    }

    function check_EmployeeMiddleName() {
        var EmployeeMiddleName = $("#EmployeeMiddleName").val().length;

        if (EmployeeMiddleName == "") {
            $("#EmployeeMiddleName_error_message").html("Middle name required");
            $("#EmployeeMiddleName_error_message").show();
            $("#EmployeeMiddleName").css("border-bottom", "2px solid #F90A0A");
            EmployeeMiddleName_error_message = true;
        } else {
            $("#EmployeeMiddleName_error_message").hide();
            $("#EmployeeMiddleName").css("border-bottom", "2px solid #34F458");
        }
    }

    function check_EmployeeLastName() {
        var EmployeeLastName = $("#EmployeeLastName").val().length;

        if (EmployeeLastName == "") {
            $("#EmployeeLastName_error_message").html("Last name required");
            $("#EmployeeLastName_error_message").show();
            $("#EmployeeLastName").css("border-bottom", "2px solid #F90A0A");
            EmployeeLastName_error_message = true;
        } else {
            $("#EmployeeLastName_error_message").hide();
            $("#EmployeeLastName").css("border-bottom", "2px solid #34F458");
        }
    }

    function check_EmployeeAddress() {
        var EmployeeAddress = $("#EmployeeAddress").val().length;

        if (EmployeeAddress == "") {
            $("#EmployeeAddress_error_message").html("Address required");
            $("#EmployeeAddress_error_message").show();
            $("#EmployeeAddress").css("border-bottom", "2px solid #F90A0A");
            EmployeeAddress_error_message = true;
        } else {
            $("#EmployeeAddress_error_message").hide();
            $("#EmployeeAddress").css("border-bottom", "2px solid #34F458");
        }
    }

    function check_EmployeeState() {
        var EmployeeState = $("#EmployeeState").val().length;

        if (EmployeeState == "") {
            $("#state_error_message").html("State required");
            $("#state_error_message").show();
            $("#EmployeeState").css("border-bottom", "2px solid #F90A0A");
            state_error_message = true;
        } else {
            $("#state_error_message").hide();
            $("#EmployeeState").css("border-bottom", "2px solid #34F458");
        }
    }

    function check_EmployeeCity() {
        var EmployeeCity = $("#EmployeeCity").val().length;

        if (EmployeeCity == "") {
            $("#city_error_message").html("City required");
            $("#city_error_message").show();
            $("#EmployeeCity").css("border-bottom", "2px solid #F90A0A");
            city_error_message = true;
        } else {
            $("#city_error_message").hide();
            $("#EmployeeCity").css("border-bottom", "2px solid #34F458");
        }
    }

    function check_EmployeePinCode() {
        var EmployeePinCode = $("#EmployeePinCode").val().length;

        if (EmployeePinCode == "") {
            $("#pincode_error_message").html("Pin Code required");
            $("#pincode_error_message").show();
            $("#EmployeePinCode").css("border-bottom", "2px solid #F90A0A");
            pincode_error_message = true;
        } else {
            $("#pincode_error_message").hide();
            $("#EmployeePinCode").css("border-bottom", "2px solid #34F458");
        }
    }

    function check_EmployeeDepartment() {
        var EmployeeDepartment = $("#EmployeeDepartment").val().length;

        if (EmployeeDepartment == "") {
            $("#EmployeeDepartment_error_message").html("Department required");
            $("#EmployeeDepartment_error_message").show();
            $("#EmployeeDepartment").css("border-bottom", "2px solid #F90A0A");
            EmployeeDepartment_error_message = true;
        } else {
            $("#EmployeeDepartment_error_message").hide();
            $("#EmployeeDepartment").css("border-bottom", "2px solid #34F458");
        }
    }

    function check_EmployeeDesignation() {
        var EmployeeDesignation = $("#EmployeeDesignation").val().length;

        if (EmployeeDesignation == "") {
            $("#EmployeeDesignation_error_message").html("Designation required");
            $("#EmployeeDesignation_error_message").show();
            $("#EmployeeDesignation").css("border-bottom", "2px solid #F90A0A");
            EmployeeDesignation_error_message = true;
        } else {
            $("#EmployeeDesignation_error_message").hide();
            $("#EmployeeDesignation").css("border-bottom", "2px solid #34F458");
        }
    }

    function check_EmployeeMobileNo() {
        var EmployeeMobileNo = $("#EmployeeMobileNo").val().length;

        if (EmployeeMobileNo == "") {
            $("#MobileNo_error_message").html("Mobile No required");
            $("#MobileNo_error_message").show();
            $("#EmployeeMobileNo").css("border-bottom", "2px solid #F90A0A");
            MobileNo_error_message = true;
        } else {
            $("#MobileNo_error_message").hide();
            $("#EmployeeMobileNo").css("border-bottom", "2px solid #34F458");
        }
    }

    function check_EmployeeEmailId() {
        var EmployeeEmailId = $("#EmployeeEmailId").val();
        var pattern = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;

        if (EmployeeEmailId !== '') {

            if (pattern.test(EmployeeEmailId)) {
                $('#span1').removeClass('d-block');
                $('#span1').addClass('d-none');
            } else {
                $('#span1').removeClass('d-none');
                $('#span1').addClass('d-block');
            }
            $('#EmployeeEmailId').css('border', '1px solid green');

            $('#span2').removeClass('d-block');
            $('#span2').addClass('d-none');
        } else {

            $('#EmployeeEmailId').css('border', '1px solid red');
            $('#span1').removeClass('d-block');
            $('#span1').addClass('d-none');
            $('#span2').removeClass('d-none');
            $('#span2').addClass('d-block');
        }
    }

    function check_EmployeeUanNo() {
        var EmployeeUanNo_length = $("#EmployeeUanNo").val().length;
        var EmployeeUanNo = $("#EmployeeUanNo").val();

        if (EmployeeUanNo_length == "") {
            $("#una_no_error_message").html("UAN No required");
            $("#una_no_error_message").show();
            $("#EmployeeUanNo").css("border-bottom", "2px solid #F90A0A");
            una_no_error_message = true;
        } else {
            // $("#una_no_error_message").hide();
            // $("#EmployeeUanNo").css("border-bottom", "2px solid #34F458");
            $.ajax({
                url:"html/ProcessPrEmployeeAdd.php",
                method:"post",
                data: {EmployeeUanNo},
                dataType:"text",
                success:function(data)
                {
                    // alert(data);
                if (data == 'already_exist') {
                        $("#una_no_error_message").html("UAN No already Exist!");
                        $("#una_no_error_message").show();
                        $("#EmployeeUanNo").css("border-bottom", "2px solid #F90A0A");
                    }else{
                        $("#una_no_error_message").hide();
                        $("#EmployeeUanNo").css("border-bottom", "2px solid #34F458");
                    }
                }
            });
        }
    }

    function check_EmployeePfNo() {
        var EmployeePfNo = $("#EmployeePfNo").val().length;

        if (EmployeePfNo == "") {
            $("#Employeepf_error_message").html("PF No required");
            $("#Employeepf_error_message").show();
            $("#EmployeePfNo").css("border-bottom", "2px solid #F90A0A");
            Employeepf_error_message = true;
        } else {
            $("#Employeepf_error_message").hide();
            $("#EmployeePfNo").css("border-bottom", "2px solid #34F458");
        }
    }

    function check_BankName() {
        var BankName = $("#BankName").val().length;

        if (BankName == "") {
            $("#BankName_error_message").html("Bank Name required");
            $("#BankName_error_message").show();
            $("#BankName").css("border-bottom", "2px solid #F90A0A");
            BankName_error_message = true;
        } else {
            $("#BankName_error_message").hide();
            $("#BankName").css("border-bottom", "2px solid #34F458");
        }
    }

    function check_BranchName() {
        var BranchName = $("#BranchName").val().length;

        if (BranchName == "") {
            $("#BranchName_error_message").html("Branch Name required");
            $("#BranchName_error_message").show();
            $("#BranchName").css("border-bottom", "2px solid #F90A0A");
            BranchName_error_message = true;
        } else {
            $("#BranchName_error_message").hide();
            $("#BranchName").css("border-bottom", "2px solid #34F458");
        }
    }

    function check_BranchCode() {
        var BranchCode = $("#BranchCode").val().length;

        if (BranchCode == "") {
            $("#BranchCode_error_message").html("Branch Code required");
            $("#BranchCode_error_message").show();
            $("#BranchCode").css("border-bottom", "2px solid #F90A0A");
            BranchCode_error_message = true;
        } else {
            $("#BranchCode_error_message").hide();
            $("#BranchCode").css("border-bottom", "2px solid #34F458");
        }
    }

    function check_Accountno() {
        var Accountno = $("#Accountno").val().length;

        if (Accountno == "") {
            $("#Accountno_error_message").html("Micr No required");
            $("#Accountno_error_message").show();
            $("#Accountno").css("border-bottom", "2px solid #F90A0A");
            Accountno_error_message = true;
        } else {
            $("#Accountno_error_message").hide();
            $("#Accountno").css("border-bottom", "2px solid #34F458");
        }
    }

    function check_MicrNo() {
        var MicrNo = $("#MicrNo").val().length;

        if (MicrNo == "") {
            $("#MicrNo_error_message").html("Micr No required");
            $("#MicrNo_error_message").show();
            $("#MicrNo").css("border-bottom", "2px solid #F90A0A");
            MicrNo_error_message = true;
        } else {
            $("#MicrNo_error_message").hide();
            $("#MicrNo").css("border-bottom", "2px solid #34F458");
        }
    }

    function check_BankAddress() {
        var BankAddress = $("#BankAddress").val().length;

        if (BankAddress == "") {
            $("#BankAddress_error_message").html("Bank Address required");
            $("#BankAddress_error_message").show();
            $("#BankAddress").css("border-bottom", "2px solid #F90A0A");
            BankAddress_error_message = true;
        } else {
            $("#BankAddress_error_message").hide();
            $("#BankAddress").css("border-bottom", "2px solid #34F458");
        }
    }

    function check_EmployeeIfscCode() {
        var EmployeeIfscCode = $("#EmployeeIfscCode").val().length;

        if (EmployeeIfscCode == "") {
            $("#EmployeeIfscCode_error_message").html("IFSC Code required");
            $("#EmployeeIfscCode_error_message").show();
            $("#EmployeeIfscCode").css("border-bottom", "2px solid #F90A0A");
            EmployeeIfscCode_error_message = true;
        } else {
            $("#EmployeeIfscCode_error_message").hide();
            $("#EmployeeIfscCode").css("border-bottom", "2px solid #34F458");
        }
    }

    function check_BankHolderName() {
        var BankHolderName = $("#BankHolderName").val().length;

        if (BankHolderName == "") {
            $("#BankHolderName_error_message").html("Bank Holder Name required");
            $("#BankHolderName_error_message").show();
            $("#BankHolderName").css("border-bottom", "2px solid #F90A0A");
            BankHolderName_error_message = true;
        } else {
            $("#BankHolderName_error_message").hide();
            $("#BankHolderName").css("border-bottom", "2px solid #34F458");
        }
    }

    function check_BasicSalary() {
        var BasicSalary = $("#BasicSalary").val().length;

        if (BasicSalary == "") {
            $("#BasicSalary_error_message").html("Basic Salary required");
            $("#BasicSalary_error_message").show();
            $("#BasicSalary").css("border-bottom", "2px solid #F90A0A");
            BasicSalary_error_message = true;
        } else {
            $("#BasicSalary_error_message").hide();
            $("#BasicSalary").css("border-bottom", "2px solid #34F458");
        }
    }

    function check_Da() {
        var Da = $("#Da").val().length;

        if (Da == "") {
            $("#Da_error_message").html("Da required");
            $("#Da_error_message").show();
            $("#Da").css("border-bottom", "2px solid #F90A0A");
            Da_error_message = true;
        } else {
            $("#Da_error_message").hide();
            $("#Da").css("border-bottom", "2px solid #34F458");
        }
    }

    function check_Hra() {
        var Hra = $("#Hra").val().length;

        if (Hra == "") {
            $("#Hra_error_message").html("HRA required");
            $("#Hra_error_message").show();
            $("#Hra").css("border-bottom", "2px solid #F90A0A");
            Hra_error_message = true;
        } else {
            $("#Hra_error_message").hide();
            $("#Hra").css("border-bottom", "2px solid #34F458");
        }
    }

    function check_Ta() {
        var Ta = $("#Ta").val().length;

        if (Ta == "") {
            $("#Ta_error_message").html("Ta required");
            $("#Ta_error_message").show();
            $("#Ta").css("border-bottom", "2px solid #F90A0A");
            Ta_error_message = true;
        } else {
            $("#Ta_error_message").hide();
            $("#Ta").css("border-bottom", "2px solid #34F458");
        }
    }

    function check_MedicalExpenses() {
        var MedicalExpenses = $("#MedicalExpenses").val().length;

        if (MedicalExpenses == "") {
            $("#MedicalExpenses_error_message").html("Medical Expenses required");
            $("#MedicalExpenses_error_message").show();
            $("#MedicalExpenses").css("border-bottom", "2px solid #F90A0A");
            MedicalExpenses_error_message = true;
        } else {
            $("#MedicalExpenses_error_message").hide();
            $("#MedicalExpenses").css("border-bottom", "2px solid #34F458");
        }
    }

    function check_OtherEarning() {
        var OtherEarning = $("#OtherEarning").val().length;

        if (OtherEarning == "") {
            $("#OtherEarning_error_message").html("Other Earning required");
            $("#OtherEarning_error_message").show();
            $("#OtherEarning").css("border-bottom", "2px solid #F90A0A");
            OtherEarning_error_message = true;
        } else {
            $("#OtherEarning_error_message").hide();
            $("#OtherEarning").css("border-bottom", "2px solid #34F458");
        }
    }

    function check_ArrearPayments() {
        var ArrearPayments = $("#ArrearPayments").val().length;

        if (ArrearPayments == "") {
            $("#ArrearPayments_error_message").html("Arrear Payments required");
            $("#ArrearPayments_error_message").show();
            $("#ArrearPayments").css("border-bottom", "2px solid #F90A0A");
            ArrearPayments_error_message = true;
        } else {
            $("#ArrearPayments_error_message").hide();
            $("#ArrearPayments").css("border-bottom", "2px solid #34F458");
        }
    }

    function check_LoanReceived() {
        var LoanReceived = $("#LoanReceived").val().length;

        if (LoanReceived == "") {
            $("#LoanReceived_error_message").html("Loan Received required");
            $("#LoanReceived_error_message").show();
            $("#LoanReceived").css("border-bottom", "2px solid #F90A0A");
            LoanReceived_error_message = true;
        } else {
            $("#LoanReceived_error_message").hide();
            $("#LoanReceived").css("border-bottom", "2px solid #34F458");
        }
    }

    function check_SalaryAdvance() {
        var SalaryAdvance = $("#SalaryAdvance").val().length;

        if (SalaryAdvance == "") {
            $("#SalaryAdvance_error_message").html("Salary Advance required");
            $("#SalaryAdvance_error_message").show();
            $("#SalaryAdvance").css("border-bottom", "2px solid #F90A0A");
            SalaryAdvance_error_message = true;
        } else {
            $("#SalaryAdvance_error_message").hide();
            $("#SalaryAdvance").css("border-bottom", "2px solid #34F458");
        }
    }

    function check_PF() {
        var PF = $("#PF").val().length;

        if (PF == "") {
            $("#PF_error_message").html("PF required");
            $("#PF_error_message").show();
            $("#PF").css("border-bottom", "2px solid #F90A0A");
            PF_error_message = true;
        } else {
            $("#PF_error_message").hide();
            $("#PF").css("border-bottom", "2px solid #34F458");
        }
    }

    function check_PR() {
        var PR = $("#PR").val().length;

        if (PR == "") {
            $("#PR_error_message").html("PT required");
            $("#PR_error_message").show();
            $("#PR").css("border-bottom", "2px solid #F90A0A");
            PR_error_message = true;
        } else {
            $("#PR_error_message").hide();
            $("#PR").css("border-bottom", "2px solid #34F458");
        }
    }

    function check_IncomeTex() {
        var IncomeTex = $("#IncomeTex").val().length;

        if (IncomeTex == "") {
            $("#IncomeTex_error_message").html("Income Tex required");
            $("#IncomeTex_error_message").show();
            $("#IncomeTex").css("border-bottom", "2px solid #F90A0A");
            IncomeTex_error_message = true;
        } else {
            $("#IncomeTex_error_message").hide();
            $("#IncomeTex").css("border-bottom", "2px solid #34F458");
        }
    }

    function check_EMI() {
        var EMI = $("#EMI").val().length;

        if (EMI == "") {
            $("#EMI_error_message").html("EMI required");
            $("#EMI_error_message").show();
            $("#EMI").css("border-bottom", "2px solid #F90A0A");
            EMI_error_message = true;
        } else {
            $("#EMI_error_message").hide();
            $("#EMI").css("border-bottom", "2px solid #34F458");
        }
    }

    function check_Insurance() {
        var Insurance = $("#Insurance").val().length;

        if (Insurance == "") {
            $("#Insurance_error_message").html("Insurance required");
            $("#Insurance_error_message").show();
            $("#Insurance").css("border-bottom", "2px solid #F90A0A");
            Insurance_error_message = true;
        } else {
            $("#Insurance_error_message").hide();
            $("#Insurance").css("border-bottom", "2px solid #34F458");
        }
    }

    function check_Other() {
        var Other = $("#Other").val().length;

        if (Other == "") {
            $("#Other_error_message").html("Other required");
            $("#Other_error_message").show();
            $("#Other").css("border-bottom", "2px solid #F90A0A");
            Other_error_message = true;
        } else {
            $("#Other_error_message").hide();
            $("#Other").css("border-bottom", "2px solid #34F458");
        }
    }

    function check_LoanPaid() {
        var LoanPaid = $("#LoanPaid").val().length;

        if (LoanPaid == "") {
            $("#LoanPaid_error_message").html("Loan Paid required");
            $("#LoanPaid_error_message").show();
            $("#LoanPaid").css("border-bottom", "2px solid #F90A0A");
            LoanPaid_error_message = true;
        } else {
            $("#LoanPaid_error_message").hide();
            $("#LoanPaid").css("border-bottom", "2px solid #34F458");
        }
    }

    function check_CasualLeave() {
        var CasualLeave = $("#CasualLeave").val().length;

        if (CasualLeave == "") {
            $("#CasualLeave_error_message").html("Casual Leave required");
            $("#CasualLeave_error_message").show();
            $("#CasualLeave").css("border-bottom", "2px solid #F90A0A");
            CasualLeave_error_message = true;
        } else {
            $("#CasualLeave_error_message").hide();
            $("#CasualLeave").css("border-bottom", "2px solid #34F458");
        }
    }

    function check_SickLeave() {
        var SickLeave = $("#SickLeave").val().length;

        if (SickLeave == "") {
            $("#SickLeave_error_message").html("Sick Leave required");
            $("#SickLeave_error_message").show();
            $("#SickLeave").css("border-bottom", "2px solid #F90A0A");
            SickLeave_error_message = true;
        } else {
            $("#SickLeave_error_message").hide();
            $("#SickLeave").css("border-bottom", "2px solid #34F458");
        }
    }

    function check_EarnedLeave() {
        var EarnedLeave = $("#EarnedLeave").val().length;

        if (EarnedLeave == "") {
            $("#EarnedLeave_error_message").html("Earned Leave required");
            $("#EarnedLeave_error_message").show();
            $("#EarnedLeave").css("border-bottom", "2px solid #F90A0A");
            EarnedLeave_error_message = true;
        } else {
            $("#EarnedLeave_error_message").hide();
            $("#EarnedLeave").css("border-bottom", "2px solid #34F458");
        }
    }
    
     function check_MaternityLeave() {
        var MaternityLeave = $("#MaternityLeave").val().length;

        if (MaternityLeave == "") {
            $("#MaternityLeave_error_message").html("Maternity Leave required");
            $("#MaternityLeave_error_message").show();
            $("#MaternityLeave").css("border-bottom", "2px solid #F90A0A");
            EarnedLeave_error_message = true;
        } else {
            $("#MaternityLeave_error_message").hide();
            $("#MaternityLeave").css("border-bottom", "2px solid #34F458");
        }
    }



    $("#submit").submit(function() {

        EmployeeFirstName_error_message = false;
        EmployeeMiddleName_error_message = false;
        EmployeeLastName_error_message = false;
        EmployeeAddress_error_message = false;
        state_error_message = false;
        city_error_message = false;
        pincode_error_message = false;
        EmployeeDepartment_error_message = false;
        EmployeeDesignation_error_message = false;
        MobileNo_error_message = false;
        Emailid_error_message = false;
        una_no_error_message = false;
        Employeepf_error_message = false;
        BankName_error_message = false;
        BranchName_error_message = false;
        BranchCode_error_message = false;
        Accountno_error_message = false;
        MicrNo_error_message = false;
        BankAddress_error_message = false;
        EmployeeIfscCode_error_message = false;
        BankHolderName_error_message = false;
        BasicSalary_error_message = false;
        Da_error_message = false;
        Hra_error_message = false;
        Ta_error_message = false;
        MedicalExpenses_error_message = false;
        OtherEarning_error_message = false;
        ArrearPayments_error_message = false;
        LoanReceived_error_message = false;
        SalaryAdvance_error_message = false;
        PF_error_message = false;
        PR_error_message = false;
        IncomeTex_error_message = false;
        EMI_error_message = false;
        Insurance_error_message = false;
        Other_error_message = false;
        LoanPaid_error_message = false;
        CasualLeave_error_message = false;
        SickLeave_error_message = false;
        EarnedLeave_error_message = false;
        MaternityLeave_error_message = false;

        check_EmployeeFirstName();
        check_EmployeeMiddleName();
        check_EmployeeLastName();
        check_EmployeeAddress();
        check_EmployeeState();
        check_EmployeeCity();
        check_EmployeePinCode();
        check_EmployeeDepartment();
        check_EmployeeDesignation();
        check_EmployeeMobileNo();
        check_EmployeeEmailId();
        check_EmployeeUanNo();
        check_EmployeePfNo();
        check_BankName();
        check_BranchName();
        check_BranchCode();
        check_Accountno();
        check_MicrNo();
        check_BankAddress();
        check_EmployeeIfscCode();
        check_BankHolderName();
        check_BasicSalary();
        check_Da();
        check_Hra();
        check_Ta();
        check_MedicalExpenses();
        check_OtherEarning();
        check_ArrearPayments();
        check_LoanReceived();
        check_SalaryAdvance();
        check_PF();
        check_PR();
        check_IncomeTex();
        check_EMI();
        check_Insurance();
        check_Other();
        check_LoanPaid();
        check_CasualLeave();
        check_SickLeave();
        check_EarnedLeave();
        check_MaternityLeave();



        if (EmployeeFirstName_error_message == false && EmployeeMiddleName_error_message == false &&
            EmployeeLastName_error_message == false && EmployeeAddress_error_message == false &&
            state_error_message == false && city_error_message == false && pincode_error_message ==
            false && EmployeeDepartment_error_message == false && EmployeeDesignation_error_message ==
            false && MobileNo_error_message == false && Emailid_error_message == false &&
            una_no_error_message == false && Employeepf_error_message == false &&
            BankName_error_message == false && BranchName_error_message == false &&
            BranchCode_error_message == false && Accountno_error_message == false &&
            MicrNo_error_message == false && BankAddress_error_message == false &&
            EmployeeIfscCode_error_message == false && BankHolderName_error_message == false &&
            BasicSalary_error_message == false && Da_error_message == false && Hra_error_message ==
            false && Ta_error_message == false && MedicalExpenses_error_message == false &&
            OtherEarning_error_message == false && ArrearPayments_error_message == false &&
            LoanReceived_error_message == false && SalaryAdvance_error_message == false &&
            PF_error_message == false && PR_error_message == false && IncomeTex_error_message ==
            false && EMI_error_message == false && Insurance_error_message == false &&
            Other_error_message == false && LoanPaid_error_message == false &&
            CasualLeave_error_message == false && SickLeave_error_message == false &&
            EarnedLeave_error_message == false && MaternityLeave_error_message == false) {
            return true;
        } else {
            return false;
        }

    });
});
</script>
<?php include_once 'ltr/header-footer.php'; ?>

</html>