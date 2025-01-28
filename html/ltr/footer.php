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
<style type="text/css">
	/*FOOTER DESIGN*/
  mark{
    background: none;
   // color: #fff;
  }
  footer{
    //background: linear-gradient(-180deg, #66A5AD, #07575B, #004445);
    background-color: #93036C;
    //border-top: 1px solid #93036C; 
    //color: #fff;
    position: absolute;
    bottom: 0;
    width: 100%;
    color: #000;
    margin-left: 50px;
  }
</style>
<footer class="page-footer pb-0 mb-0 bg-light">
  <div class="footer-copyright py-1 text-center">
    <p class="mt-2">© 2020 - <?php echo date('Y'); ?><mark> All Rights Reserved.</mark> <mark>Clienserv</mark></p>
  </div>
</footer>