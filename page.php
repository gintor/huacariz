<?php
session_start();
include_once 'call/cone.php';
include_once 'cons.php';
include_once 'call/func.php';
$no=iseguro($cone, $_SESSION['nousu']);
$id=iseguro($cone, $_SESSION['idusu']);
$lo=iseguro($cone, $_SESSION['local']);
if(vlogin($cone, $no, $id)){
  $p=iseguro($cone,$_GET['p']);
  $p=explode("/",$p);
  $page="error";
  if(isset($p[1]) && is_numeric($p[1])){
    $idm=$p[1];
    $p_cm=mysqli_query($cone,"SELECT nombre FROM modulo WHERE idmodulo=$idm AND estado=1;");
    if($p_rm=mysqli_fetch_assoc($p_cm)){
      $mod=$p_rm['nombre'];
      $moda=amigable($mod);
      $page=$moda.$idm;
    }
    mysqli_free_result($p_cm);
  }

?>
<!DOCTYPE html>
<html lang="es">
<?php include 'structure/head.php'; ?>
<body class="hold-transition fixed skin-red-light sidebar-mini">
<div class="wrapper">
  <?php include 'structure/header.php'; ?>
  <?php include 'structure/aside.php'; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <?php include 'structure/breadcrumb.php'; ?>

    <?php
    if(is_file("content/".$page.".php")){
      if($page!="error"){
          include 'content/'.$page.'.php';
      }else{
          include 'content/error.php';
      }
    }else{
          include 'content/sincon.php';
    }
    ?>

  </div>
  <!-- /.content-wrapper -->
  <?php include 'structure/modal.php' ?>
  <?php include 'structure/footer.php'; ?>

</div>
<!-- ./wrapper -->
<?php include 'structure/js.php'; ?>
<script>
  $(document).ready(function(){
    $('.sidebar-menu').tree();
    <?php if(isset($mod)){ ?>
    $("#<?php echo $idm.$moda; ?>").addClass("active");
    <?php } ?>
  })
</script>
</body>
</html>
<?php
}else{
  redireccinar();
}
?>