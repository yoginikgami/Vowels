</div>
</div>
</div>
</div>
</div>
<!-- ============================================================== -->
<!-- Sales chart -->
<!-- ============================================================== -->
</div>
<!-- ============================================================== -->
<!-- End Container fluid  -->
<!-- ============================================================== -->
<!-- ============================================================== -->
<!-- footer -->
<!-- ============================================================== -->
<!--footer class="footer text-center">
                © 2020 All Rights Reserved. Vivaan Intellects</a>
            </footer-->
<!--footer class="page-footer pb-0 mb-0 bg-light">
              <div class="footer-copyright py-1 text-center">
                <p class="mt-2">© 2020 <mark> All Rights Reserved.</mark><mark>Vivaan Intellects</mark></p>
              </div>
            </footer-->
<!-- ============================================================== -->
<!-- End footer -->
<!-- ============================================================== -->
</div>
<!-- ============================================================== -->
<!-- End Page wrapper  -->
<!-- ============================================================== -->
</div>
<!-- ============================================================== -->
<!-- End Wrapper -->
<!-- ============================================================== -->
<!-- ============================================================== -->
<!-- All Jquery -->
<!-- ============================================================== -->

<script src="assets/libs/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap tether Core JavaScript -->
<script src="assets/libs/popper.js/dist/umd/popper.min.js"></script>
<script src="assets/libs/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js"></script>
<script src="assets/extra-libs/sparkline/sparkline.js"></script>
<!--Wave Effects -->
<script src="dist/js/waves.js"></script>
<!--Menu sidebar -->
<script src="dist/js/sidebarmenu.js"></script>
<!--Custom JavaScript -->
<script src="dist/js/custom.min.js"></script>
<!--This page JavaScript -->
<!-- <script src="dist/js/pages/dashboards/dashboard1.js"></script> -->
<!-- Charts js Files -->
<script src="assets/libs/flot/excanvas.js"></script>
<script src="assets/libs/flot/jquery.flot.js"></script>
<script src="assets/libs/flot/jquery.flot.pie.js"></script>
<script src="assets/libs/flot/jquery.flot.time.js"></script>
<script src="assets/libs/flot/jquery.flot.stack.js"></script>
<script src="assets/libs/flot/jquery.flot.crosshair.js"></script>
<script src="assets/libs/flot.tooltip/js/jquery.flot.tooltip.min.js"></script>
<script src="dist/js/pages/chart/chart-page-init.js"></script>

<!-- Links of Task Manager -->
<!-- SweetAlert2 -->
<!-- <script src="tm_assets/plugins/sweetalert2/sweetalert2.min.js"></script> -->
<!-- Toastr -->
<!-- <script src="tm_assets/plugins/toastr/toastr.min.js"></script> -->
<!-- Switch Toggle -->
<!-- <script src="tm_assets/plugins/bootstrap4-toggle/js/bootstrap4-toggle.min.js"></script> -->
<!-- Select2 -->
<!-- <script src="tm_assets/plugins/select2/js/select2.full.min.js"></script> -->
<!-- Summernote -->
<!-- <script src="tm_assets/plugins/summernote/summernote-bs4.min.js"></script> -->
<!-- dropzonejs -->
<!-- <script src="tm_assets/plugins/dropzone/min/dropzone.min.js"></script>
    <script src="tm_assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script> -->
<!-- DataTables  & Plugins -->
<!-- <script src="tm_assets/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="tm_assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="tm_assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="tm_assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="tm_assets/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="tm_assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script> -->

<script>
    window.start_load = function() {
        $('body').prepend('<div id="preloader2"></div>');
        // $('#pleaseWaitDialog').modal('show');
    }
    window.end_load = function() {
        $('#preloader2').fadeOut('fast', function() {
            $(this).remove();
        })
        // $('#pleaseWaitDialog').modal('hide');
    }
    window.viewer_modal = function($src = '') {
        start_load()
        var t = $src.split('.')
        t = t[1]
        if (t == 'mp4') {
            var view = $("<video src='" + $src + "' controls autoplay></video>")
        } else {
            var view = $("<img src='" + $src + "' />")
        }
        $('#viewer_modal .modal-content video,#viewer_modal .modal-content img').remove()
        $('#viewer_modal .modal-content').append(view)
        $('#viewer_modal').modal({
            show: true,
            backdrop: 'static',
            keyboard: false,
            focus: true
        })
        end_load()

    }
    window.uni_modal = function($title = '', $url = '', $size = "") {
        start_load()
        $.ajax({
            url: $url,
            error: err => {
                console.log()
                alert("An error occured")
            },
            success: function(resp) {
                if (resp) {
                    $('#uni_modal .modal-title').html($title)
                    $('#uni_modal .modal-body').html(resp)
                    if ($size != '') {
                        $('#uni_modal .modal-dialog').addClass($size)
                    } else {
                        $('#uni_modal .modal-dialog').removeAttr("class").addClass("modal-dialog modal-md")
                    }
                    $('#uni_modal').modal({
                        show: true,
                        backdrop: 'static',
                        keyboard: false,
                        focus: true
                    })
                    end_load()
                }
            }
        })
    }
    window._conf = function($msg = '', $func = '', $params = []) {
        $('#confirm_modal #confirm').attr('onclick', $func + "(" + $params.join(',') + ")")
        $('#confirm_modal .modal-body').html($msg)
        $('#confirm_modal').modal('show')
    }
    window.alert_toast = function($msg = 'TEST', $bg = 'success', $pos = '') {
        var Toast = Swal.mixin({
            toast: true,
            position: $pos || 'top-end',
            showConfirmButton: false,
            timer: 5000
        });
        Toast.fire({
            icon: $bg,
            title: $msg
        })
    }
    $(function() {
        bsCustomFileInput.init();
        $('.summernote').summernote({
            height: 300,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear']],
                ['fontname', ['fontname']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ol', 'ul', 'paragraph', 'height']],
                ['table', ['table']],
                ['view', ['undo', 'redo', 'fullscreen', 'codeview', 'help']]
            ]
        })

        $('.datetimepicker').datetimepicker({
            format: 'Y/m/d H:i',
        });
    });
</script>

<?php include_once 'footer.php'; ?>
</body>

</html>