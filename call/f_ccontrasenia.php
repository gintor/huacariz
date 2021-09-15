<?php
session_start();
include 'cone.php';
//include '../cons.php';
include 'func.php';
$no=iseguro($cone, $_SESSION['nousu']);
$id=iseguro($cone, $_SESSION['idusu']);
if(vlogin($cone, $no, $id)){
?>
  <div class="form-group">
    <label for="acon" class="col-sm-4 control-label">Contraseña Actual</label>
    <div class="col-sm-8">
      <input type="password" class="form-control" name="acon" id="acon" placeholder="Contraseña Actual">
    </div>
  </div>
  <div class="form-group">
    <label for="ncon" class="col-sm-4 control-label">Nueva Contraseña</label>
    <div class="col-sm-8">
      <input type="password" class="form-control" name="ncon" id="ncon" placeholder="Nueva Contraseña">
    </div>
  </div>
  <div class="form-group">
    <label for="rcon" class="col-sm-4 control-label">Repite Nueva Contraseña</label>
    <div class="col-sm-8">
      <input type="password" class="form-control" name="rcon" id="rcon" placeholder="Repite Nueva Contraseña">
    </div>
  </div>
  <div class="row">
    <div class="col-sm-12" id="r_ccontrasenia">

    </div>
  </div>

<?php
}else{
  redireccinar();
}
mysqli_close($cone);
?>