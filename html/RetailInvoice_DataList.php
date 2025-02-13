<?php 
	//session_start();
	include_once 'connection.php';
?>

<div id="showRetailInvoiceTable">
	<?php include_once "showRetailInvoiceTable.php"; ?>
</div>

<?php 
	if ($total_pages > 0) {
?>
<nav class="form-inline pr-3" id="pagination" style="margin-top: -50px;">
	<ul class="pagination ml-auto justify-content-end">
	    <li class="page-item"><button class="btn btn-vowel page-link" id="firstLink">First</button></li>&nbsp;
	    <li class="<?php if($pageno <= 1){ echo 'disabled'; } ?>">
	        <button class="btn btn-vowel page-link" id="prevLink">Prev</button>
	    </li>&nbsp;
	    <li class="<?php if($pageno >= $total_pages){ echo 'disabled'; } ?>">
	        <button class="btn btn-vowel page-link" id="nextLink">Next</button>
	    </li>&nbsp;
	    <li class="page-item"><button class="btn btn-vowel page-link" id="lastLink">Last</button></li>
	</ul>
</nav>
<?php } ?>
<script type="text/javascript">
	$(document).ready(function(){
		$("#addNew_gst_link").click(function(){
			$("#add_new_RetailInvoice").click();
		});
		var currentPageno = $('#currentPageno').val();
		var first = $('#first').val();
		var last = $('#IncomeLast').val();
		if (currentPageno == first) {
			$('#prevLink').prop('disabled','disabled');
			$('#firstLink').prop('disabled','disabled');
			$('#prevLink').css('cursor','not-allowed');
			$('#firstLink').css('cursor','not-allowed');
		}
		if (currentPageno == last) {
			$('#nextLink').prop('disabled','disabled');
			$('#lastLink').prop('disabled','disabled');
			$('#nextLink').css('cursor','not-allowed');
			$('#lastLink').css('cursor','not-allowed');
		}
		$('#firstLink').click(function(){
			var no_of_records_per_page = $("#no_of_records_per_page").val();
			var first = $('#first').val();
			$.ajax({
				url:"html/showRetailInvoiceTable.php",
				method:"post",
				data: {pageno:first,no_of_records_per_page:no_of_records_per_page},
				dataType:"text",
				success:function(data)
				{
					//alert(data);
					//alert(first);
					$('#showRetailInvoiceTable').empty();
					$('#showRetailInvoiceTable').html(data);
					$('#prevLink').prop('disabled','disabled');
					$('#firstLink').prop('disabled','disabled');
					$('#prevLink').css('cursor','not-allowed');
					$('#firstLink').css('cursor','not-allowed');
					$('#nextLink').prop('disabled',false);
					$('#lastLink').prop('disabled',false);
					$('#nextLink').css('cursor','pointer');
					$('#lastLink').css('cursor','pointer');
				}
			});	
		});
		$('#prevLink').click(function(){
			var Incomeprev = $('#Incomeprev').val();
			var first = $('#first').val();
			var no_of_records_per_page = $("#no_of_records_per_page").val();
			$.ajax({
				url:"html/showRetailInvoiceTable.php",
				method:"post",
				data: {pageno:Incomeprev,no_of_records_per_page:no_of_records_per_page},
				dataType:"text",
				success:function(data)
				{
					//alert(data);
					//alert(Incomeprev);					
					$('#showRetailInvoiceTable').empty();
					$('#showRetailInvoiceTable').html(data);
					$('#nextLink').prop('disabled',false);
					$('#lastLink').prop('disabled',false);
					$('#nextLink').css('cursor','pointer');
					$('#lastLink').css('cursor','pointer');
					if (first == Incomeprev) {
						$('#firstLink').prop('disabled','disabled');
						$('#prevLink').prop('disabled','disabled');
						$('#prevLink').css('cursor','not-allowed');
						$('#firstLink').css('cursor','not-allowed');
					}
				}
			});		
		});
		$('#nextLink').click(function(){
			var next = $('#IncomeNext').val();
			var last = $('#IncomeLast').val();
			var no_of_records_per_page = $("#no_of_records_per_page").val();
			$.ajax({
				url:"html/showRetailInvoiceTable.php",
				method:"post",
				data: {pageno:next,no_of_records_per_page:no_of_records_per_page},
				dataType:"text",
				success:function(data)
				{
					//alert(data);
					//alert(next);
					$('#showRetailInvoiceTable').empty();
					$('#showRetailInvoiceTable').html(data);
					if (last == next) {
						$('#nextLink').prop('disabled','disabled');
						$('#lastLink').prop('disabled','disabled');
						$('#nextLink').css('cursor','not-allowed');
						$('#lastLink').css('cursor','not-allowed');
					}
					$('#firstLink').prop('disabled',false);
					$('#prevLink').prop('disabled',false);
					$('#prevLink').css('cursor','pointer');
					$('#firstLink').css('cursor','pointer');
				}
			});	
		});
		$('#lastLink').click(function(){
			var last = $('#IncomeLast').val();
			var no_of_records_per_page = $("#no_of_records_per_page").val();
			$.ajax({
				url:"html/showRetailInvoiceTable.php",
				method:"post",
				data: {pageno:last,no_of_records_per_page:no_of_records_per_page},
				dataType:"text",
				success:function(data)
				{
					//alert(data);
					//alert(last);
					//$('#currentPageno').val(last);
					$('#showRetailInvoiceTable').empty();
					$('#showRetailInvoiceTable').html(data);
					$('#nextLink').prop('disabled','disabled');
					$('#lastLink').prop('disabled','disabled');
					$('#nextLink').css('cursor','not-allowed');
					$('#lastLink').css('cursor','not-allowed');
					$('#firstLink').prop('disabled',false);
					$('#prevLink').prop('disabled',false);
					$('#prevLink').css('cursor','pointer');
					$('#firstLink').css('cursor','pointer');
				}
			});	
		});
	});
$(document).ready(function(){
	
	$('#closeSearch').click(function(){
		//var closeSearch = $('#IncomeLast').val();
		$("#search").val('');
		var no_of_records_per_page = $("#no_of_records_per_page").val();
		var first = $('#first').val();
		var currentPageno = $('#currentPageno').val();
		var last = $('#IncomeLast').val();
		$.ajax({
			url:"html/showRetailInvoiceTable.php",
			method:"post",
			data: {pageno:first,no_of_records_per_page:no_of_records_per_page},
			dataType:"text",
			success:function(data)
			{
				//alert(data);
				//alert(first);
				$('#showRetailInvoiceTable').empty();
				$('#showRetailInvoiceTable').html(data);
				$('#prevLink').prop('disabled','disabled');
				$('#firstLink').prop('disabled','disabled');
				$('#prevLink').css('cursor','not-allowed');
				$('#firstLink').css('cursor','not-allowed');
				if (currentPageno == last) {
					$('#nextLink').prop('disabled','disabled');
					$('#lastLink').prop('disabled','disabled');
					$('#nextLink').css('cursor','not-allowed');
					$('#lastLink').css('cursor','not-allowed');
				}else{
					$('#nextLink').prop('disabled',false);
					$('#lastLink').prop('disabled',false);
					$('#nextLink').css('cursor','pointer');
					$('#lastLink').css('cursor','pointer');
				}
			}
		});
	});

    $("#search").on("input", function(){

        var search = $("#search").val();
        //alert(search);
        var no_of_records_per_page = $("#no_of_records_per_page").val();
		var first = $('#first').val();
		$.ajax({
			url:"html/showRetailInvoiceTable.php",
			method:"post",
			data: {search:search,pageno:first,no_of_records_per_page:no_of_records_per_page},
			dataType:"text",
			success:function(data)
			{
				//alert(data);
				//alert(first);
				$('#showRetailInvoiceTable').empty();
				$('#showRetailInvoiceTable').html(data);
				$('#prevLink').prop('disabled','disabled');
				$('#firstLink').prop('disabled','disabled');
				$('#prevLink').css('cursor','not-allowed');
				$('#firstLink').css('cursor','not-allowed');
				$('#nextLink').prop('disabled','disabled');
				$('#lastLink').prop('disabled','disabled');
				$('#nextLink').css('cursor','not-allowed');
				$('#lastLink').css('cursor','not-allowed');
			}
		});
    });

});
</script>