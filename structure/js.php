<!-- jQuery 3 -->
<script src="<?php echo ROOT; ?>bower_components/jquery/dist/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?php echo ROOT; ?>bower_components/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
  var base="<?php echo ROOT; ?>";
  var idm="<?php echo $idm; ?>";
</script>
<!-- Bootstrap 3.3.7 -->
<script src="<?php echo ROOT; ?>bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Select2 -->
<script src="<?php echo ROOT; ?>bower_components/select2/dist/js/select2.full.min.js"></script>
<!-- Morris.js charts -->
<script src="<?php echo ROOT; ?>bower_components/raphael/raphael.min.js"></script>
<script src="<?php echo ROOT; ?>bower_components/morris.js/morris.min.js"></script>
<!-- jvectormap -->
<script src="<?php echo ROOT; ?>plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="<?php echo ROOT; ?>plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- datepicker -->
<script src="<?php echo ROOT; ?>bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="<?php echo ROOT; ?>bower_components/bootstrap-datepicker/dist/locales/bootstrap-datepicker.es.min.js"></script>
<!-- DataTables -->
<script src="<?php echo ROOT; ?>bower_components/datatables.net/js/jquery.dataTables.js"></script>
<script src="<?php echo ROOT; ?>bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="<?php echo ROOT; ?>bower_components/datatables.net/js/dataTables.buttons.min.js"></script>
<script src="<?php echo ROOT; ?>bower_components/datatables.net/js/jszip.min.js"></script>
<script src="<?php echo ROOT; ?>bower_components/datatables.net/js/pdfmake.min.js"></script>
<script src="<?php echo ROOT; ?>bower_components/datatables.net/js/vfs_fonts.js"></script>
<script src="<?php echo ROOT; ?>bower_components/datatables.net/js/buttons.html5.min.js"></script>
<script src="<?php echo ROOT; ?>bower_components/datatables.net/js/buttons.print.min.js"></script>
<!-- Slimscroll -->
<script src="<?php echo ROOT; ?>bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo ROOT; ?>dist/js/adminlte.min.js"></script>
<!-- Alertify -->
<script src="<?php echo ROOT; ?>bower_components/alertifyjs/alertify.min.js"></script>
<script src="<?php echo ROOT; ?>dist/js/page.js"></script>
<script src="<?php echo ROOT; ?>js/<?php echo $moda; ?>.js"></script>