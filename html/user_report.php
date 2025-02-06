<?php 
	include_once 'ltr/header.php';
	include_once 'connection.php';
	// include_once 'bulkDeletePopup.php';

    if (isset($_SESSION['company_id'])) {
        $company_id = $_SESSION['company_id'];
    
        // Fetch user data for the given company ID and user ID
        $fetch_user_data = "SELECT * FROM `users` WHERE `company_id` = '$company_id' AND `id` = '" . $_SESSION['user_id'] . "'";
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
    }
?>
<!DOCTYPE html>
<html>
<head>
	<title>Vowel Enterprise CMS - Recipient Master</title>
	<script src="https://kit.fontawesome.com/d3dd33a66d.js" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.6.3.js" integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM=" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
    <script type="text/javascript" src="js/virtual-select.min.js"></script>
	<style>
	    #user_allot_scroll {
			/* background-color: lightblue; */
			/*width: 150px;*/
			height: 110px;
			overflow: auto;
			}
			::-webkit-scrollbar {
			width: 10px;
			}

			/* Track */
			::-webkit-scrollbar-track {
			background: #f1f1f1; 
			}
			
			/* Handle */
			::-webkit-scrollbar-thumb {
			background: #888; 
			}

			/* Handle on hover */
			::-webkit-scrollbar-thumb:hover {
			background: #555; 
			}
			.heading{
                height: 10px;
                
                background: #e5d2f1;
                position: sticky;
                top: 0;
            }
            .heading .txt{
                font-size: 1em;
                text-align:center;
                padding: 3px 3px 3px 3px;
            }
            .tableRecords{
                text-align:center;
            }
             .tableScroll {
                height:700px;
                overflow: auto;

        }
        .tableScroll::-webkit-scrollbar{
	        width:10px;
	    }
	    .tableScroll::-::-webkit-scrollbar-track{
            -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
            border-radius:5px;
        }
        .tableScroll::-webkit-scrollbar-thumb{
            border-radius: 5px;
            -webkit-box-shadow: inset 0 0 6px #757373;
        }  
        h5 {
            display: flex;
            flex-direction: row;
            color: grey;
        }
          
        h5:before,
        h5:after {
            content: "";
            flex: 1 1;
            border-bottom: 1px solid grey;
            margin: auto;
        }
	</style>
</head>
<body>
<div class="container-fluid">
	<div id='EditUserDiv'></div>
	<!--<h2 align="center" class="pageHeading" id="pageHeading">Data</h2>-->
		<div class="row border justify-content-center" id="after-heading">
		    <div class="modal-body">
		       <div class="row">
            
            <!-- Brand List  -->
            <div class="col-2.5" >
                    <div class="card shadow" style="background-color:#D3D6D7;border-radius:4px;">
                        <div class="card-header">
                            <form method="post" class="d-block" id="userReport_form">
                            <h3 style="color:#252627;"> <center>User Report </center></h3><hr>
                            
                            <!--Choose Status BootStrap-->
                            <h4 style="color:#252627;"><i class="fa-solid fa-user"></i> &nbsp;From Date</h4>
                             <input type="date" class="form-control" name="from_Date" id="from_Date"><br>
                            
                            <h4 style="color:#252627;"><i class="fa-solid fa-user"></i> &nbsp;To Date</h4>
                             <input type="date" class="form-control" name="to_Date" id="to_Date"><br>
                             
                             <h4 style="color:#252627;"><i class="fa-solid fa-sheet-plastic"></i> &nbsp;Sort By</h4>
        					<select class="form-control" name="sort_by" id="sort_by" placeholder="Select Portfolio" multiselect-select-all="true">
                                <option value="created_at">Created At</option>
                                <option value="modify_by">Modify At</option>
                            </select><br>
        					
        					<h4 style="color:#252627;"><i class="fa-solid fa-sheet-plastic"></i> &nbsp;Portfolio</h4>
        					<select class="form-control" name="portfolio[]" id="portfolio[]" multiple multiselect-search="true" placeholder="Select Portfolio" multiselect-select-all="true">
                                <?php
                                // Loop through columns and check if the value is 1
                                foreach ($columns as $column => $label) {
                                    if (!empty($row[$column]) && $row[$column] == 1) {
                                        echo "<option value='$column'>$label</option>";
                                    }
                                }
                                ?>
                            </select><br><br>
                            
                            <h4 style="color:#252627;"><i class="fa-solid fa-paper-plane"></i> &nbsp;Users</h4>
                            <select class="form-control" name="select_user[]" id="select_user[]" multiple multiselect-search="true" placeholder="Select User" multiselect-select-all="true">
                             <?php
                    			$user = "select * from `users` where `company_id` = '".$_SESSION['company_id']."' AND `user_status` != 0 order by username";
                    			$user_result = mysqli_query($con, $user);
                    			while($user_show = mysqli_fetch_array($user_result)){
                    			?>
                              <!--$tableName = "add" . ucwords($call_title) . "_Data";-->
                              <button type="button"><option value="<?= $user_show['user_id']; ?>"><?= $user_show['user_id'].' - '.$user_show['firstname'].' '.$user_show['lastname']; ?></option></button>
                              <?php } ?>
                            </select><br><br>
                            <div class="row">
                            <div class="col"><button type="submit" name="transferData" class="btn btn-success" id="submitTransferId" style="border-radius:4px;">Show Report</button></div>
                            </form>
                            <div class="col"><form method='post' action='ExportreportJob_progress.php'><button type="submit" name='user_report_export' id="user_report_export" class="btn btn-secondary d-none" style="border-radius:4px;"><i class="fa-solid fa-download"></i></button></form></div></div>
                        </div> 
                    </div>
            </div>

            <!-- Brand Items - Products -->
            <div class="col-md-9" style="border-left:1px solid black">
                <div class="card ">
                    
                        <div class="tableScroll">
                    <div id="showData">
                        
                    <div class="card-body row" id="fetch_result">
                        <table class="table table-striped" >
                            <thead class="thead-dark">
                                <tr>
                                  <th class="txt">No</th>
                                  <th class="txt">User</th>
                                  <th class="txt">Portfolio</th>
                                  <th class="txt">Recipient</th>
                                  <th class="txt">Service ID</th>
                                  <th class="txt">Fees</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td>
                                    <td><h4>Fill Details to see Report !</h4></td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div></div>
                    <div id="searchShowDetails" class="table-responsive d-block"></div>
                </div>
            </div>
        </div>
        </div>
        </div></div>
	</div>
<script>

var up = document.getElementById('GFG_UP');
        var down = document.getElementById('cachePaste');
    $(document).ready(function(){
        $('#userReport_form').submit(function(e){
            e.preventDefault();
            var from_Date = $('#from_Date').val();
            var toDate = $('#to_Date').val();
            var portfolio = $('#portflio').val();
            var user = $('#select_user').val();
            var check = from_Date != "" & toDate != "" & portfolio != "" & user != "";
            if(check != ""){
                $.ajax({
                  url: "html/user_reportAjax",
                  method: "POST",
                  data: $('#userReport_form').serialize(),
                  success:function(data){
                      $('#fetch_result').html(data);
                      $('#user_report_export').removeClass('d-none');
                      $('#user_report_export').addClass('d-block');
                  },
                });
            } else {
                alert("Rejected");
            }
        });
		
		
		$("#search").on("input", function(){
        var search = $("#search").val();
		var usernameSearch = $('#usernameSearch').val();
		var statusSearch = $('#statusSearch').val();
		var titleSearch = $('#titleSearch').val();
		$.ajax({
			url:"html/showTitle_ChangeData.php",
			method:"post",
			data: {search:search,usernameSearch:usernameSearch,statusSearch:statusSearch,titleSearch:titleSearch},
			dataType:"text",
			success:function(data)
			{
				$("#showData").addClass("d-none");
		        $("#showData").removeClass("d-block");
				$("#searchShowDetails").addClass("d-block");
		        $("#searchShowDetails").removeClass("d-none");
		        $("#searchShowDetails").html(data);
			}
		});
        });
        
        $('#closeSearch').click(function(){
    		$("#search").val('');
    		var no_of_records_per_page = $("#no_of_records_per_page").val();
    		var first = $('#first').val();
    		var currentPageno = $('#currentPageno').val();
    		var last = $('#IncomeLast').val();
                    $("#showData").addClass("d-block");
    		        $("#showData").removeClass("d-none");
    	            $("#searchShowDetails").addClass("d-none");
    		        $("#searchShowDetails").removeClass("d-block");
    	});
    	
        });
</script>
<script>
    $(document).ready(function() {
        $('#portfolio').multiselect({
            enableFiltering: true,  // Adds a search box
            includeSelectAllOption: true,  // Adds "Select All" option
            selectAllText: 'Select All',
            nonSelectedText: 'Select Portfolio',
            buttonWidth: '100%',  // Adjusts button width
            maxHeight: 250,  // Sets dropdown height with scrollbar
            enableCaseInsensitiveFiltering: true, // Allows case-insensitive search
        });
    });
</script>

<?php include_once 'ltr/header-footer.php'; ?>
</body>
</html>