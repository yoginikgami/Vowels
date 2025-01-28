<style>
  .message{
	position: relative;
	display: flex;
	width: 100%;
	margin: 5px 0;
}
.message p{
	position: relative;
	text-align: right;

	right: 5px;
	max-width: 65%;
	padding: 10px;
	background: #dcf8c6;
	border-radius: 10px;
	font-size: 0.9em;
}

.message p span{
	display: block;
	margin-top: 5px;
	font-size: 0.85em;
	opacity: 0.5;
	word-spacing: 15px;
}

.my_message{
	justify-content: flex-end;
}

.frnd_message{
	justify-content: flex-start;
}

.frnd_message p{
	text-align: left;
	right: -20px;
	background: white;
}
</style>
<script type="text/javascript">
  $('#showPassword').click(function(){
      if('password' == $('#changePass').attr('type')){
           $('#changePass').prop('type', 'text');
           $('#passIcon').removeClass('fas fa-eye-slash');
           $('#passIcon').addClass('fas fa-eye');
      }else{
           $('#changePass').prop('type', 'password');
           $('#passIcon').removeClass('fas fa-eye');
           $('#passIcon').addClass('fas fa-eye-slash');
      }
  });
  $('#showCon_Password').click(function(){
      if('password' == $('#retype_changePass').attr('type')){
           $('#retype_changePass').prop('type', 'text');
           $('#con_passIcon').removeClass('fas fa-eye-slash');
           $('#con_passIcon').addClass('fas fa-eye');
      }else{
           $('#retype_changePass').prop('type', 'password');
           $('#con_passIcon').removeClass('fas fa-eye');
           $('#con_passIcon').addClass('fas fa-eye-slash');
      }
  });
  $('#changePassBTN').click(function () {
     var changePass = $('#changePass').val();
     var retype_changePass = $('#retype_changePass').val();
     if (changePass == "" && retype_changePass == "") {
      $('#changePass-status').html('Please fill the field').css({'color':'red'});
      $('#changePass').addClass("border border-danger");
      $('#retype_changePass-status').html('Please fill the field').css({'color':'red'});
      $('#retype_changePass').addClass("border border-danger");
     }else if (changePass == "") {
      $('#changePass-status').html('Please fill the field').css({'color':'red'});
      $('#changePass').addClass("border border-danger");
      $('#retype_changePass-status').html('').css({'color':'green'});
      $('#retype_changePass').removeClass("border border-danger");
     }else if (retype_changePass == "") {
      $('#retype_changePass-status').html('Please fill the field').css({'color':'red'});
      $('#retype_changePass').addClass("border border-danger");
      $('#changePass-status').html('').css({'color':'green'});
      $('#changePass').removeClass("border border-danger");
     }else if (changePass != retype_changePass) {
      $('#changePass-status').html('').css({'color':'green'});
      $('#changePass').removeClass("border border-danger");
      $('#retype_changePass-status').html('Both password must be same').css({'color':'red'});
      $('#retype_changePass').addClass("border border-danger");
     }else if ((changePass != "" && retype_changePass != "") && (changePass == retype_changePass)) {
      $('#pleaseWaitDialog').modal('show');
      $.ajax({
          url:"html/ProcessChangePassword.php",
          method:"post",
          data: {changePass:changePass},
          dataType:"text",
          success:function(data)
          {
            //alert(data);
            //$('#showBankTransaction').html(data);
            $('#ChangePasswordPopup .close').click();
            if (data == 'success') {
              window.createNotification({
                  closeOnClick: true,
                  displayCloseButton: true,
                  positionClass: "nfc-top-right",
                  showDuration: 3000,
                  theme: "success"
              })({
                  title: "Congratulations",
                  message: "Password Changed Successfuly"
              });
            }else if (data == 'fail') {
              window.createNotification({
                  closeOnClick: true,
                  displayCloseButton: true,
                  positionClass: "nfc-top-right",
                  showDuration: 3000,
                  theme: "error"
              })({
                  title: "Soory",
                  message: "Password Not Changed"
              });
            }
          },
          complete: function(){
            $('#pleaseWaitDialog').modal('hide');
          }
      });
     }
  });
  $('#ChangePasswordPopup').on('hidden.bs.modal', function () {
      $('#changePass-status').html('').css({'color':'green'});
      $('#changePass').removeClass("border border-danger");
      $('#retype_changePass-status').html('').css({'color':'green'});
      $('#retype_changePass').removeClass("border border-danger");
      $('#changePass').val('');
      $('#retype_changePass').val('');
  });

</script>