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
?>
          <div class="form-group">
            <label for="mie" class="col-sm-2 control-label">Miembro</label>
            <div class="col-sm-10">
              <input type="hidden" name="acc" value="add">
              <input type="hidden" name="idm" value="<?php echo $idm; ?>">
              <select class="form-control" name="mie" id="miesinusu" style="width: 100%;">

              </select>
            </div>
          </div>
          <div class="form-group">
            <label for="usu" class="col-sm-2 control-label">Usuario</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" name="usu" id="usu" placeholder="Usuario">
            </div>
          </div>
          <div class="form-group">
            <label for="con" class="col-sm-2 control-label">Contraseña</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" name="con" id="con" placeholder="Contraseña">
            </div>
          </div>
          <div class="form-group">
            <label for="est" class="col-sm-2 control-label">Estado</label>
            <div class="col-sm-10">
              <div class="checkbox">
                <label>
                  <input type="checkbox" name="est" id="est" value="1"> Activo
                </label>
              </div>
            </div>
          </div>
          <div id="r_usuario">
 
          </div>
          <script>
			  $( "#miesinusu" ).select2({ 
			    placeholder: 'Busque y seleccione un miembro',
			    ajax: {
			        url: base+"callpage/se_miesinusu.php",
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
          </script>
<?php
		}elseif($acc=="edit"){
			if(isset($_POST['idu']) && !empty($_POST['idu'])){
				$idu=iseguro($cone,$_POST['idu']);
				$cu=mysqli_query($cone,"SELECT * FROM usuario WHERE idusuario=$idu;");
				if($ru=mysqli_fetch_assoc($cu)){
?>
	          <div class="form-group">
	            <label for="mie" class="col-sm-2 control-label">Miembro</label>
	            <div class="col-sm-10">
	              <input type="hidden" name="acc" value="edit">
	              <input type="hidden" name="idm" value="<?php echo $idm; ?>">
	              <input type="hidden" name="idu" value="<?php echo $idu; ?>">
	              <input type="text" class="form-control" name="mie" id="mie" readonly="readonly" value="<?php echo nombre($cone,$ru['idmiembro']); ?>">
	            </div>
	          </div>
	          <div class="form-group">
	            <label for="usu" class="col-sm-2 control-label">Usuario</label>
	            <div class="col-sm-10">
	              <input type="text" class="form-control" name="usu" id="usu" placeholder="Usuario" value="<?php echo $ru['nombre']; ?>">
	            </div>
	          </div>
	          <div class="form-group">
	            <label for="est" class="col-sm-2 control-label">Estado</label>
	            <div class="col-sm-10">
	              <div class="checkbox">
	                <label>
	                  <input type="checkbox" name="est" id="est" value="1" <?php echo $ru['estado']==1 ? "checked" : ""; ?>> Activo
	                </label>
	              </div>
	            </div>
	          </div>
	          <div id="r_usuario">
	 
	          </div>
<?php
				}else{
					echo mensajeda("Datos incorrectos");
				}
			}else{
				echo mensajeda("Faltan datos");
			}
		}elseif($acc=="perm"){
			if(isset($_POST['idu']) && !empty($_POST['idu'])){
				$idu=iseguro($cone,$_POST['idu']);
				$cu=mysqli_query($cone,"SELECT idusuario FROM usuario WHERE idusuario=$idu;");
				if($ru=mysqli_fetch_assoc($cu)){
					$cmo=mysqli_query($cone,"SELECT idmodulo, nombre FROM modulo WHERE estado=1 ORDER BY orden ASC;");
					if(mysqli_num_rows($cmo)>0){
?>
					<h4><i class="fa fa-user text-green"></i> <?php echo nombre($cone,$idu); ?></h4>
					<hr>
					<table class="table table-bordered table-hover">
						<thead>
							<tr>
								<th>MÓDULO</th>
								<th>PERMISO</th>
							</tr>
						</thead>
						<tbody>
<?php
							while($rmo=mysqli_fetch_assoc($cmo)){
								$idmod=$rmo['idmodulo'];
								$cmu=mysqli_query($cone,"SELECT nivel FROM modusuario WHERE idusuario=$idu AND idmodulo=$idmod AND estado=1;");
								if($rmu=mysqli_fetch_assoc($cmu)){
									$ni=$rmu['nivel'];
								}else{
									$ni=3;
								}
?>
							<tr>
								<td><?php echo $rmo['nombre']; ?></td>
								<td>
									<select class="form-control" onchange="g_perusuario(<?php echo $idm.",".$idu.",".$idmod.","; ?>this);">
										<option value="3" <?php echo $ni==3 ? "selected" : ""; ?>>NINGUNO</option>
										<option value="2" <?php echo $ni==2 ? "selected" : ""; ?>>CONSULTA</option>
										<option value="1" <?php echo $ni==1 ? "selected" : ""; ?>>ADMINISTRADOR</option>
									</select>
								</td>
							</tr>
<?php
							}
?>
						</tbody>
					</table>
<?php

					}else{
						echo mensajeda("No se hallaron módulos");
					}

				}else{
					echo mensajeda("Datos incorrectos");
				}
			}else{
				echo mensajeda("Faltan datos");
			}
		}elseif($acc=="cont"){
			if(isset($_POST['idu']) && !empty($_POST['idu'])){
				$idu=iseguro($cone,$_POST['idu']);
				$cu=mysqli_query($cone,"SELECT idusuario FROM usuario WHERE idusuario=$idu;");
				if($ru=mysqli_fetch_assoc($cu)){
?>
				<h4><i class="fa fa-user text-green"></i> <?php echo nombre($cone,$idu); ?></h4>
				<hr>
	          <div class="form-group">
	          	<input type="hidden" name="acc" value="<?php echo $acc; ?>">
	            <input type="hidden" name="idm" value="<?php echo $idm; ?>">
	            <input type="hidden" name="idu" value="<?php echo $idu; ?>">
	            <label for="con" class="col-sm-3 control-label">Nueva Contraseña</label>
	            <div class="col-sm-9">
	              <input type="password" class="form-control" name="con" id="con" placeholder="****">
	            </div>
	          </div>
	          <div class="form-group">
	            <label for="rcon" class="col-sm-3 control-label">Repetir Contraseña</label>
	            <div class="col-sm-9">
	              <input type="password" class="form-control" name="rcon" id="rcon" placeholder="****">
	            </div>
	          </div>
	          <div id="r_usuario">
	 
	          </div>
<?php
				}else{
					echo mensajeda("Datos incorrectos");
				}
			}else{
				echo mensajeda("Faltan datos");
			}
		}
	}
	mysqli_close($cone);
}
?>