<?php
session_start();
include_once '../call/cone.php';
include_once '../cons.php';
include_once '../call/func.php';
$no=iseguro($cone, $_SESSION['nousu']);
$id=iseguro($cone, $_SESSION['idusu']);
$lo=iseguro($cone, $_SESSION['local']);

?>
<!DOCTYPE html>
<html lang="es">
<?php include '../structure/head.php'; ?>
<body class="hold-transition fixed skin-red-light sidebar-mini">
<div class="wrapper">
  <?php include '../structure/header.php'; ?>
  <?php include '../structure/aside.php'; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <?php include '../structure/breadcrumb.php'; ?>
	
	<button class="btn bg-red text-center" onclick="impcom('20603317085-03-B002-00000029');"><i class="fa fa-print"></i></button>
	<div id="d_impcom"></div>
  </div>
  <!-- /.content-wrapper -->
  <?php include '../structure/modal.php' ?>
  <?php include '../structure/footer.php'; ?>

</div>
<!-- ./wrapper -->
<?php include '../structure/js.php'; ?>
<script>
function impcom(com){
  $.ajax({
    type: "post",
    url: base+"callpage/impcom.php",//print/callprint
    dataType: "html",
    data: {com: com},
    beforeSend: function () {
      $("#d_impcom").html('<h4 class="text-center"><i class="fa fa-spinner fa-spin"></i></h4>');
    },
    success:function(e){
      $("#d_impcom").html(e);
    }
  });
}
</script>
</body>
</html>