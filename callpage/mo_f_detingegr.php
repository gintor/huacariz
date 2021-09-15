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
            <label for="tmov" class="col-sm-2 control-label">Tipo Movimiento</label>
            <div class="col-sm-4">
              <input type="hidden" name="acc" value="<?php echo $acc; ?>">
              <input type="hidden" name="idm" value="<?php echo $idm; ?>">
              <input type="hidden" name="mean" value="<?php echo $mean; ?>">
              <select class="form-control" name="tmov" id="tmov">
				<option value="">Tipo Movimiento</option>
				<option value="1">Ingreso</option>
				<option value="2">Egreso</option>
              </select>
            </div>
			<label for="freg" class="col-sm-2 control-label">Fecha Registro</label>
            <div class="col-sm-4 has-feedback">
              <input type="text" class="form-control" name="freg" id="freg" placeholder="dd/mm/aaaa" value="<?php echo date("d/m/Y"); ?>" readonly="readonly">
              <span class="fa fa-calendar form-control-feedback"></span>
            </div>
          </div>
          <div class="form-group">
            <label for="tdoc" class="col-sm-2 control-label">Tipo Documento</label>
            <div class="col-sm-4">
              <select class="form-control" name="tdoc" id="tdoc">
				<option value="">Tipo Documento</option>
				<?php
				$ctd=mysqli_query($cone,"SELECT idtipodocumento, descripcion FROM tipodocumento ORDER BY descripcion ASC;");
				if(mysqli_num_rows($ctd)>0){
					while($rtd=mysqli_fetch_assoc($ctd)){
				?>
				<option value="<?php echo $rtd['idtipodocumento']; ?>"><?php echo $rtd['descripcion']; ?></option>
				<?php
					}
				}
				mysqli_free_result($ctd);
				?>
              </select>
            </div>
            <label for="sdoc" class="col-sm-2 control-label">Serie Documento</label>
            <div class="col-sm-4">
              <input type="text" class="form-control" name="sdoc" id="sdoc" placeholder="Serie Documento">
            </div>
          </div>
          <div class="form-group">
            <label for="ndoc" class="col-sm-2 control-label">Num. Documento</label>
            <div class="col-sm-4">
              <input type="text" class="form-control" name="ndoc" id="ndoc" placeholder="Número Documento">
            </div>
            <label for="fdoc" class="col-sm-2 control-label">Fec. Documento</label>
            <div class="col-sm-4 has-feedback">
              <input type="text" class="form-control" name="fdoc" id="fdoc" placeholder="dd/mm/aaaa">
              <span class="fa fa-calendar form-control-feedback"></span>
            </div>
          </div>
          <div class="form-group">
            <label for="tot" class="col-sm-2 control-label">Total</label>
            <div class="col-sm-4">
              <input type="number" class="form-control" name="tot" id="tot" placeholder="00.00">
            </div>
            <label for="mon" class="col-sm-2 control-label">Moneda</label>
            <div class="col-sm-4">
              <select class="form-control" name="mon" id="mon">
				<option value="">Moneda</option>
				<?php
				$cmo=mysqli_query($cone,"SELECT idmoneda, nombre FROM moneda ORDER BY nombre ASC;");
				if(mysqli_num_rows($cmo)>0){
					while($rmo=mysqli_fetch_assoc($cmo)){
				?>
				<option value="<?php echo $rmo['idmoneda']; ?>"><?php echo $rmo['nombre']; ?></option>
				<?php
					}
				}
				mysqli_free_result($cmo);
				?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label for="nope" class="col-sm-2 control-label">Num. Operación</label>
            <div class="col-sm-4">
              <input type="text" class="form-control" name="nope" id="nope" placeholder="Num. Operación">
            </div>
            <label for="sdia" class="col-sm-2 control-label">SubDiario</label>
            <div class="col-sm-4">
              <select class="form-control" name="sdia" id="sdia">
				<option value="">SubDiario</option>
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
          </div>
          <div class="form-group">
            <label for="tpag" class="col-sm-2 control-label">Tipo Pago</label>
            <div class="col-sm-4">
              <select class="form-control" name="tpag" id="tpag">
				<option value="">Tipo Pago</option>
				<?php
				$ctp=mysqli_query($cone,"SELECT * FROM tipopago ORDER BY descripcion ASC;");
				if(mysqli_num_rows($ctp)>0){
					while($rtp=mysqli_fetch_assoc($ctp)){
				?>
				<option value="<?php echo $rtp['idtipopago']; ?>"><?php echo $rtp['descripcion']; ?></option>
				<?php
					}
				}
				mysqli_free_result($ctp);
				?>
              </select>
            </div>
            <label for="cue" class="col-sm-2 control-label">Cuenta</label>
            <div class="col-sm-4">
              <select class="form-control" name="cue" id="cue">
				<option value="">Cuenta</option>
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
            <label for="act" class="col-sm-2 control-label">Actividad</label>
            <div class="col-sm-4">
              <select class="form-control" name="act" id="act">
				<option value="">Actividad</option>
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
            <label for="mie" class="col-sm-2 control-label">Miembro</label>
            <div class="col-sm-4">
              <select class="form-control" name="mie" id="miembros" style="width: 100%;">

              </select>
            </div>
          </div>
          <div class="form-group">
            <label for="emp" class="col-sm-2 control-label">Empresa</label>
            <div class="col-sm-10">
              <select class="form-control" name="emp" id="empresas" style="width: 100%;">

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
          <div id="r_ingegr">
 
          </div>
          <script>
          	  $(".select2").select2();
			  $("#miembros").select2({
			    placeholder: 'Busque y seleccione un miembro',
			    ajax: {
			        url: base+"callpage/ge_miembros.php",
			        dataType: 'json',
			        delay: 250,
			        data: function (params) {
			            return {
			                q: params.term // search term
			            };
			        },
			        processResults: function (data) {
			            return {
			                results: data
			            };
			        },
			        cache: true
			    },
			    minimumInputLength: 3
			  });
			  $("#empresas").select2({
			    placeholder: 'Busque y seleccione una empresa',
			    ajax: {
			        url: base+"callpage/ge_empresas.php",
			        dataType: 'json',
			        delay: 250,
			        data: function (params) {
			            return {
			                q: params.term // search term
			            };
			        },
			        processResults: function (data) {
			            return {
			                results: data
			            };
			        },
			        cache: true
			    },
			    minimumInputLength: 3
			  });
			  $('#fdoc').datepicker({
				format: 'dd/mm/yyyy',
				autoclose: true,
				language: "es",
				startDate: <?php echo "'01/".$mean."'"; ?>,
				endDate: <?php echo "'".cal_days_in_month(CAL_GREGORIAN,$meana[0],$meana[1])."/".$mean."'"; ?>

			  });
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
            <div class="col-sm-4">
              <input type="text" class="form-control" name="cod" id="cod" value="<?php echo codmovimiento($cone,$rm['idmovimiento']); ?>" readonly="readonly">
            </div>
			<label for="res" class="col-sm-2 control-label">Responsable</label>
            <div class="col-sm-4">
              <input type="text" class="form-control" name="res" id="res" value="<?php echo nombre($cone,$rm['usuario']); ?>" readonly="readonly">
            </div>
          </div>
          <div class="form-group">
            <label for="tmov" class="col-sm-2 control-label">Tipo Movimiento</label>
            <div class="col-sm-4">
              <input type="hidden" name="acc" value="<?php echo $acc; ?>">
              <input type="hidden" name="idm" value="<?php echo $idm; ?>">
              <input type="hidden" name="mean" value="<?php echo $mean; ?>">
              <input type="hidden" name="idmov" value="<?php echo $rm['idmovimiento']; ?>">
              <select class="form-control" name="tmov" id="tmov">
				<option value="">Tipo Movimiento</option>
				<option value="1" <?php echo $rm['tipomovimiento']==1 ? "selected" : ""; ?>>Ingreso</option>
				<option value="2" <?php echo $rm['tipomovimiento']==2 ? "selected" : ""; ?>>Egreso</option>
              </select>
            </div>
			<label for="freg" class="col-sm-2 control-label">Fecha Registro</label>
            <div class="col-sm-4 has-feedback">
              <input type="text" class="form-control" name="freg" id="freg" placeholder="dd/mm/aaaa" value="<?php echo fnormal($rm['fecregistro']); ?>" readonly="readonly">
              <span class="fa fa-calendar form-control-feedback"></span>
            </div>
          </div>
          <div class="form-group">
            <label for="tdoc" class="col-sm-2 control-label">Tipo Documento</label>
            <div class="col-sm-4">
              <select class="form-control" name="tdoc" id="tdoc">
				<option value="">Tipo Documento</option>
				<?php
				$ctd=mysqli_query($cone,"SELECT idtipodocumento, descripcion FROM tipodocumento ORDER BY descripcion ASC;");
				if(mysqli_num_rows($ctd)>0){
					while($rtd=mysqli_fetch_assoc($ctd)){
				?>
				<option value="<?php echo $rtd['idtipodocumento']; ?>" <?php echo $rtd['idtipodocumento']==$rm['idtipodocumento'] ? "selected" : ""; ?>><?php echo $rtd['descripcion']; ?></option>
				<?php
					}
				}
				mysqli_free_result($ctd);
				?>
              </select>
            </div>
            <label for="sdoc" class="col-sm-2 control-label">Serie Documento</label>
            <div class="col-sm-4">
              <input type="text" class="form-control" name="sdoc" id="sdoc" placeholder="Serie Documento" value="<?php echo $rm['serdocumento']; ?>">
            </div>
          </div>
          <div class="form-group">
            <label for="ndoc" class="col-sm-2 control-label">Num. Documento</label>
            <div class="col-sm-4">
              <input type="text" class="form-control" name="ndoc" id="ndoc" placeholder="Número Documento" value="<?php echo $rm['numdocumento']; ?>">
            </div>
            <label for="fdoc" class="col-sm-2 control-label">Fec. Documento</label>
            <div class="col-sm-4 has-feedback">
              <input type="text" class="form-control" name="fdoc" id="fdoc" placeholder="dd/mm/aaaa" value="<?php echo fnormal($rm['fecdocumento']); ?>">
              <span class="fa fa-calendar form-control-feedback"></span>
            </div>
          </div>
          <div class="form-group">
            <label for="tot" class="col-sm-2 control-label">Total</label>
            <div class="col-sm-4">
              <input type="number" class="form-control" name="tot" id="tot" placeholder="00.00" value="<?php echo $rm['total']; ?>">
            </div>
            <label for="mon" class="col-sm-2 control-label">Moneda</label>
            <div class="col-sm-4">
              <select class="form-control" name="mon" id="mon">
				<option value="">Moneda</option>
				<?php
				$cmo=mysqli_query($cone,"SELECT idmoneda, nombre FROM moneda ORDER BY nombre ASC;");
				if(mysqli_num_rows($cmo)>0){
					while($rmo=mysqli_fetch_assoc($cmo)){
				?>
				<option value="<?php echo $rmo['idmoneda']; ?>" <?php echo $rmo['idmoneda']==$rm['idmoneda'] ? "selected" : ""; ?>><?php echo $rmo['nombre']; ?></option>
				<?php
					}
				}
				mysqli_free_result($cmo);
				?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label for="nope" class="col-sm-2 control-label">Num. Operación</label>
            <div class="col-sm-4">
              <input type="text" class="form-control" name="nope" id="nope" placeholder="Num. Operación" value="<?php echo $rm['numoperacion']; ?>">
            </div>
            <label for="sdia" class="col-sm-2 control-label">SubDiario</label>
            <div class="col-sm-4">
              <input type="hidden" name="sdiaa" value="<?php echo $rm['idsubdiario']; ?>">
              <select class="form-control" name="sdia" id="sdia">
				<option value="">SubDiario</option>
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
          </div>
          <div class="form-group">
            <label for="tpag" class="col-sm-2 control-label">Tipo Pago</label>
            <div class="col-sm-4">
              <select class="form-control" name="tpag" id="tpag">
				<option value="">Tipo Pago</option>
				<?php
				$ctp=mysqli_query($cone,"SELECT * FROM tipopago ORDER BY descripcion ASC;");
				if(mysqli_num_rows($ctp)>0){
					while($rtp=mysqli_fetch_assoc($ctp)){
				?>
				<option value="<?php echo $rtp['idtipopago']; ?>" <?php echo $rtp['idtipopago']==$rm['idtipopago'] ? "selected" : ""; ?>><?php echo $rtp['descripcion']; ?></option>
				<?php
					}
				}
				mysqli_free_result($ctp);
				?>
              </select>
            </div>
            <label for="cue" class="col-sm-2 control-label">Cuenta</label>
            <div class="col-sm-4">
              <select class="form-control" name="cue" id="cue">
				<option value="">Cuenta</option>
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
            <label for="act" class="col-sm-2 control-label">Actividad</label>
            <div class="col-sm-4">
              <select class="form-control" name="act" id="act">
				<option value="">Actividad</option>
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
            <label for="mie" class="col-sm-2 control-label">Miembro</label>
            <div class="col-sm-4">
              <select class="form-control" name="mie" id="miembros" style="width: 100%;">
				<option value="<?php echo $rm['idmiembro']; ?>" selected><?php echo nombremie($cone, $rm['idmiembro']); ?></option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label for="emp" class="col-sm-2 control-label">Empresa</label>
            <div class="col-sm-10">
              <select class="form-control" name="emp" id="empresas" style="width: 100%;">
				<option value="<?php echo $rm['idempresa']; ?>" selected><?php echo nombreemp($cone, $rm['idempresa']); ?></option>
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
              <input type="text" class="form-control" name="obs" id="obs" placeholder="Observación" value="<?php echo $rm['observacion'] ?>">
            </div>
          </div>
          <div id="r_ingegr">
 
          </div>
          <script>
          	  $(".select2").select2();
			  $("#miembros").select2({
			    placeholder: 'Busque y seleccione un miembro',
			    ajax: {
			        url: base+"callpage/ge_miembros.php",
			        dataType: 'json',
			        delay: 250,
			        data: function (params) {
			            return {
			                q: params.term // search term
			            };
			        },
			        processResults: function (data) {
			            return {
			                results: data
			            };
			        },
			        cache: true
			    },
			    minimumInputLength: 3
			  });
			  $("#empresas").select2({
			    placeholder: 'Busque y seleccione una empresa',
			    ajax: {
			        url: base+"callpage/ge_empresas.php",
			        dataType: 'json',
			        delay: 250,
			        data: function (params) {
			            return {
			                q: params.term // search term
			            };
			        },
			        processResults: function (data) {
			            return {
			                results: data
			            };
			        },
			        cache: true
			    },
			    minimumInputLength: 3
			  });
			  $('#fdoc').datepicker({
				format: 'dd/mm/yyyy',
				autoclose: true,
				language: "es",
				startDate: <?php echo "'01/".$mean."'"; ?>,
				endDate: <?php echo "'".cal_days_in_month(CAL_GREGORIAN,$mes,$anio)."/".$mean."'"; ?>

			  });
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