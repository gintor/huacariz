<?php
session_start();
if(isset($_POST['acc']) && !empty($_POST['acc'])){
	include_once '../call/cone.php';
	include_once '../cons.php';
	include_once '../call/func.php';
	$id=iseguro($cone, $_SESSION['idusu']);
	$acc=iseguro($cone,$_POST['acc']);
	$idm=iseguro($cone,$_POST['idm']);
	if(vaccesom($cone, $id, $idm, 1)){
		if($acc=="add"){
			$mean=iseguro($cone,$_POST['mean']);
			$meana=explode("/",$mean);
?>
		<div class="text-center">
			<span class="subtitulo"><i class="fa fa-calendar-o text-gray"></i> <?php echo nmes($meana[0])."-".$meana[1]; ?></span>
			<hr>
		</div>
          <div class="form-group">
            <label for="sdia" class="col-sm-2 control-label">SubDiario</label>
            <input type="hidden" name="acc" value="<?php echo $acc; ?>">
          	<input type="hidden" name="idm" value="<?php echo $idm; ?>">
          	<input type="hidden" name="mean" value="<?php echo $mean; ?>">
            <div class="col-sm-4">
              <select class="form-control select2" name="sdia" id="sdia" style="width: 100%;">
				<?php
				$csd=mysqli_query($cone,"SELECT idsubdiario, descripcion FROM subdiario ORDER BY descripcion ASC;");
				if(mysqli_num_rows($csd)>0){
					while($rsd=mysqli_fetch_assoc($csd)){
				?>
				<option value="<?php echo $rsd['idsubdiario']; ?>"><?php echo $rsd['descripcion']; ?></option>
				<?php
					}
				}
				mysqli_free_result($csd);
				?>
              </select>
            </div>
			<label for="act" class="col-sm-2 control-label">Actividad</label>
            <div class="col-sm-4">
              <select class="form-control select2" name="act" id="act" style="width: 100%;">
				<?php
				$cac=mysqli_query($cone,"SELECT idactividad, nombre FROM actividad ORDER BY nombre ASC;");
				if(mysqli_num_rows($cac)>0){
					while($rac=mysqli_fetch_assoc($cac)){
				?>
				<option value="<?php echo $rac['idactividad']; ?>"><?php echo $rac['nombre']; ?></option>
				<?php
					}
				}
				mysqli_free_result($cac);
				?>
              </select>
            </div>
          </div>
          <div class="form-group">
          	<label for="nope" class="col-sm-2 control-label">Num. Operación</label>
            <div class="col-sm-4">
              <input type="text" class="form-control" name="nope" id="nope" placeholder="Num. Operación">
            </div>
            <label for="cue" class="col-sm-2 control-label">Cuenta</label>
            <div class="col-sm-4">
              <select class="form-control" name="cue" id="cue">
				<option value="">NINGUNA</option>
				<?php
				$ccu=mysqli_query($cone,"SELECT idcuenta, numcuenta FROM cuenta ORDER BY numcuenta ASC;");
				if(mysqli_num_rows($ccu)>0){
					while($rcu=mysqli_fetch_assoc($ccu)){
				?>
				<option value="<?php echo $rcu['idcuenta']; ?>"><?php echo $rcu['numcuenta']; ?></option>
				<?php
					}
				}
				mysqli_free_result($ccu);
				?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label for="glo" class="col-sm-2 control-label">Glosa</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" name="glo" id="glo" placeholder="Glosa">
            </div>
          </div>
          <div class="form-group">
            <label for="obs" class="col-sm-2 control-label">Observación</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" name="obs" id="obs" placeholder="Observación">
            </div>
          </div>
          <div class="form-group">
            <label for="freg" class="col-sm-2 control-label">Fecha Registro</label>
            <div class="col-sm-4 has-feedback">
              <input type="text" class="form-control" name="freg" id="freg" placeholder="dd/mm/aaaa" value="<?php echo date("d/m/Y"); ?>" readonly="readonly">
              <span class="fa fa-calendar form-control-feedback"></span>
            </div>
          </div>
          <div id="r_ingegr">
 
          </div>
          <script>
          	  $(".select2").select2();
          </script>
<?php
		}elseif($acc=="edi"){
			if(isset($_POST['idmov']) && !empty($_POST['idmov'])){
				$idmov=iseguro($cone,$_POST['idmov']);
				$cm=mysqli_query($cone,"SELECT * FROM movimiento WHERE idmovimiento=$idmov;");
				if($rm=mysqli_fetch_assoc($cm)){
					$mes=strlen($rm['mes'])==1 ? "0".$rm['mes'] : $rm['mes'];
					$anio=$rm['anio'];
					$mean=$mes."/".$anio;
?>
	    <div class="text-center">
			<span class="subtitulo"><i class="fa fa-calendar-o text-gray"></i> <?php echo nmes($mes)."-".$anio; ?></span>
			<hr>
		</div>
		  <div class="form-group">
            <label for="cod" class="col-sm-2 control-label">Código</label>
            <div class="col-sm-4 text-sinput">
              <span><?php echo codmovimiento($cone,$rm['idmovimiento']); ?></span>
            </div>
			<label for="res" class="col-sm-2 control-label">Por</label>
            <div class="col-sm-4 text-sinput">
              <span><?php echo nombre($cone,$rm['usuario']); ?></span>
            </div>
          </div>
          <div class="form-group">
            <label for="sdia" class="col-sm-2 control-label">SubDiario</label>
            <input type="hidden" name="acc" value="<?php echo $acc; ?>">
          	<input type="hidden" name="idm" value="<?php echo $idm; ?>">
          	<input type="hidden" name="mean" value="<?php echo $mean; ?>">
          	<input type="hidden" name="idmov" value="<?php echo $rm['idmovimiento']; ?>">
            <div class="col-sm-4">
              <input type="hidden" name="sdiaa" value="<?php echo $rm['idsubdiario']; ?>">
              <select class="form-control select2" name="sdia" id="sdia" style="width: 100%;">
				<?php
				$csd=mysqli_query($cone,"SELECT idsubdiario, descripcion FROM subdiario ORDER BY descripcion ASC;");
				if(mysqli_num_rows($csd)>0){
					while($rsd=mysqli_fetch_assoc($csd)){
				?>
				<option value="<?php echo $rsd['idsubdiario']; ?>" <?php echo $rsd['idsubdiario']==$rm['idsubdiario'] ? "selected" : ""; ?>><?php echo $rsd['descripcion']; ?></option>
				<?php
					}
				}
				mysqli_free_result($csd);
				?>
              </select>
            </div>
			<label for="act" class="col-sm-2 control-label">Actividad</label>
            <div class="col-sm-4">
              <select class="form-control select2" name="act" id="act" style="width: 100%;">
				<?php
				$cac=mysqli_query($cone,"SELECT idactividad, nombre FROM actividad ORDER BY nombre ASC;");
				if(mysqli_num_rows($cac)>0){
					while($rac=mysqli_fetch_assoc($cac)){
				?>
				<option value="<?php echo $rac['idactividad']; ?>" <?php echo $rac['idactividad']==$rm['idactividad'] ? "selected" : ""; ?>><?php echo $rac['nombre']; ?></option>
				<?php
					}
				}
				mysqli_free_result($cac);
				?>
              </select>
            </div>
          </div>
          <div class="form-group">
          	<label for="nope" class="col-sm-2 control-label">Num. Operación</label>
            <div class="col-sm-4">
              <input type="text" class="form-control" name="nope" id="nope" placeholder="Num. Operación" value="<?php echo $rm['numoperacion'] ?>">
            </div>
            <label for="cue" class="col-sm-2 control-label">Cuenta</label>
            <div class="col-sm-4">
              <select class="form-control" name="cue" id="cue">
				<option value="">NINGUNA</option>
				<?php
				$ccu=mysqli_query($cone,"SELECT idcuenta, numcuenta FROM cuenta ORDER BY numcuenta ASC;");
				if(mysqli_num_rows($ccu)>0){
					while($rcu=mysqli_fetch_assoc($ccu)){
				?>
				<option value="<?php echo $rcu['idcuenta']; ?>" <?php echo $rcu['idcuenta']==$rm['idcuenta'] ? "selected" : ""; ?>><?php echo $rcu['numcuenta']; ?></option>
				<?php
					}
				}
				mysqli_free_result($ccu);
				?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label for="glo" class="col-sm-2 control-label">Glosa</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" name="glo" id="glo" placeholder="Glosa" value="<?php echo $rm['glosa']; ?>">
            </div>
          </div>
          <div class="form-group">
            <label for="obs" class="col-sm-2 control-label">Observación</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" name="obs" id="obs" placeholder="Observación" value="<?php echo $rm['observacion']; ?>">
            </div>
          </div>
          <div class="form-group">
            <label for="freg" class="col-sm-2 control-label">Fecha Registro</label>
            <div class="col-sm-4 text-sinput">
              <span><?php echo fnormal($rm['fecregistro']); ?></span>
            </div>
          </div>
          <div id="r_ingegr">
 
          </div>
          <script>
          	  $(".select2").select2();
          </script>
<?php
				}else{
					echo mensajeda("Datos incorrectos");
				}
				mysqli_free_result($cm);
			}else{
				echo mensajeda("Faltan datos");
			}
		}elseif($acc=="est"){
			if(isset($_POST['idmov']) && !empty($_POST['idmov'])){
				$idmov=iseguro($cone,$_POST['idmov']);
				$cmo=mysqli_query($cone,"SELECT idmovimiento, estado FROM movimiento WHERE idmovimiento=$idmov;");
				if($rmo=mysqli_fetch_assoc($cmo)){
?>
					<p class="text-center">¿Esta seguro que desea <?php echo $rmo['estado']==1 ? "desactivar" : "activar"; ?> el movimiento con código?</p>
					<h4 class="text-center subtitulo"><?php echo codmovimiento($cone, $rmo['idmovimiento']); ?></h4>
				  <input type="hidden" name="acc" value="<?php echo $acc; ?>">
	              <input type="hidden" name="idm" value="<?php echo $idm; ?>">
	              <input type="hidden" name="idmov" value="<?php echo $rmo['idmovimiento']; ?>">
	              <input type="hidden" name="est" value="<?php echo $rmo['estado']; ?>">
	            <div id="r_ingegr">
	 
	          	</div>
<?php
				}else{
					echo mensajeda("Datos incorrectos");
				}
				mysqli_free_result($cmo);
			}else{
				echo mensajeda("Faltan datos");
			}
		}elseif($acc=="eli"){
			if(isset($_POST['idmov']) && !empty($_POST['idmov'])){
				$idmov=iseguro($cone,$_POST['idmov']);
				$cmo=mysqli_query($cone,"SELECT idmovimiento FROM movimiento WHERE idmovimiento=$idmov;");
				if($rmo=mysqli_fetch_assoc($cmo)){
?>
					<p class="text-center">¿Esta seguro que desea eliminar el movimiento con código?</p>
					<h4 class="text-center subtitulo"><?php echo codmovimiento($cone, $rmo['idmovimiento']); ?></h4>
				  <input type="hidden" name="acc" value="<?php echo $acc; ?>">
	              <input type="hidden" name="idm" value="<?php echo $idm; ?>">
	              <input type="hidden" name="idmov" value="<?php echo $rmo['idmovimiento']; ?>">
	            <div id="r_ingegr">
	 
	          	</div>
<?php
				}else{
					echo mensajeda("Datos incorrectos");
				}
				mysqli_free_result($cmo);
			}else{
				echo mensajeda("Faltan datos");
			}
		}
	}
	mysqli_close($cone);
}
?>