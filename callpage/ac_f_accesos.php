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
		if($acc=="addusu"){


?>
					  <div class="form-group">
		                <label for="usu" class="col-sm-2 control-label">Colaborador</label>
		                <div class="col-sm-10">
		                  <input type="hidden" name="acc" value="<?php echo $acc; ?>">
		                  <input type="hidden" name="idm" value="<?php echo $idm; ?>">
		                  <select class="form-control" id="usu" name="usu" style="width: 100%;">
		                  </select>
		                </div>
		              </div>
		              <div class="form-group">
		                <label for="nusu" class="col-sm-2 control-label">Usuario</label>
		                <div class="col-sm-10">
							<input type="text" name="nusu" id="nusu" class="form-control">
		                </div>
		              </div>
		              <div class="form-group">
		                <label for="con1" class="col-sm-2 control-label">Contraseña</label>
		                <div class="col-sm-4">
		                  <input type="password" name="con1" id="con1" class="form-control">
		                </div>
		                <label for="con2" class="col-sm-2 control-label">Repetir</label>
		                <div class="col-sm-4">
		                  <input type="password" name="con2" id="con2" class="form-control">
		                </div>
		              </div>
					  <div id="d_resultado">

					  </div>
					  <script>
					  	  //select2 para busqueda de productos
						  $( "#usu" ).select2({
						      placeholder: 'BUSCAR COLABORADOR',   
						      ajax: {
						          url: base+"callpage/ge_colaboradores.php",
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



		}elseif($acc=="estusu"){
			if(isset($_POST['idf']) && !empty($_POST['idf'])){
				$idf=iseguro($cone,$_POST['idf']);
				$cm=mysqli_query($cone,"SELECT u.usuario, u.estado, p.nombre FROM usuario u INNER JOIN persona p ON u.idpersona=p.idpersona WHERE idusuario=$idf;");
				if($rm=mysqli_fetch_assoc($cm)){
?>

				<div class="text-center">
					<h4><i class="fa fa-info-circle text-red"></i> Está por <b><?php echo $rm['estado']==1 ? "desactivar" : "activar"; ?></b> a:</h4>
					<h4 class="text-red"><small>Colaborador: </small><?php echo $rm['nombre']; ?></h4>
					<h4 class="text-red"><small>Usuario: </small><?php echo $rm['usuario']; ?></h4>
					
					<input type="hidden" name="acc" value="<?php echo $acc; ?>">
	              	<input type="hidden" name="idm" value="<?php echo $idm; ?>">
	              	<input type="hidden" name="idf" value="<?php echo $idf; ?>">
				</div>

			<div id="d_resultado">
 
        	</div>
<?php
				}else{
					echo mensajeda("Datos incorrectos");
				}
				mysqli_free_result($cm);
			}else{
				echo mensajeda("Faltan datos");
			}
		}elseif($acc=="conusu"){
			if(isset($_POST['idf']) && !empty($_POST['idf'])){
				$idf=iseguro($cone,$_POST['idf']);
				$cm=mysqli_query($cone,"SELECT u.usuario, u.estado, p.nombre FROM usuario u INNER JOIN persona p ON u.idpersona=p.idpersona WHERE idusuario=$idf;");
				if($rm=mysqli_fetch_assoc($cm)){
?>

				<div class="text-center">
					<h4><i class="fa fa-info-circle text-red"></i> Cambiará la contraseña de:</h4>
					<h4 class="text-red"><small>Colaborador: </small><?php echo $rm['nombre']; ?></h4>
					<h4 class="text-red"><small>Usuario: </small><?php echo $rm['usuario']; ?></h4>
					
					<input type="hidden" name="acc" value="<?php echo $acc; ?>">
	              	<input type="hidden" name="idm" value="<?php echo $idm; ?>">
	              	<input type="hidden" name="idf" value="<?php echo $idf; ?>">
				</div>
				<div class="form-group">
	                <label for="con1" class="col-sm-2 control-label">Contraseña</label>
	                <div class="col-sm-4">
	                  <input type="password" name="con1" id="con1" class="form-control">
	                </div>
	                <label for="con2" class="col-sm-2 control-label">Repetir</label>
	                <div class="col-sm-4">
	                  <input type="password" name="con2" id="con2" class="form-control">
	                </div>
		        </div>
				<div id="d_resultado">
	 
	        	</div>
<?php
				}else{
					echo mensajeda("Datos incorrectos");
				}
				mysqli_free_result($cm);
			}else{
				echo mensajeda("Faltan datos");
			}
		}elseif($acc=="accusu"){
			if(isset($_POST['idf']) && !empty($_POST['idf'])){
				$idf=iseguro($cone,$_POST['idf']);
				$cm=mysqli_query($cone,"SELECT idmodulo, nombre FROM modulo WHERE estado=1;");
				if(mysqli_num_rows($cm)>0){
?>
					<table class="table table-bordered table-hover">
						<tr>
							<th>MÓDULO</th>
							<th>PERMISO</th>
						</tr>
<?php
					$n=0;
					while ($rm=mysqli_fetch_assoc($cm)) {
						$n++;
						$idmod=$rm['idmodulo'];
						$cmu=mysqli_query($cone,"SELECT nivel FROM modusuario WHERE idusuario=$idf AND idmodulo=$idmod AND estado=1;");
						if($rmu=mysqli_fetch_assoc($cmu)){
							$niv=$rmu['nivel'];
						}else{
							$niv=3;
						}
						mysqli_free_result($cmu);
?>
						<tr>
							<td><?php echo $rm['nombre']; ?></td>
							<td>
								<select name="p_<?php echo $n ?>" id="p_<?php echo $n ?>" class="form-control" onchange="g_accusuario(<?php echo $idm.",".$idf.",".$idmod.","; ?>this)">
									<option value="1" <?php echo $niv==1 ? "selected" : ""; ?>>Administrador</option>
									<option value="2" <?php echo $niv==2 ? "selected" : ""; ?>>Consulta</option>
									<option value="3" <?php echo $niv==3 ? "selected" : ""; ?>>Ninguno</option>
								</select>
							</td>
						</tr>
<?php
						
					}
				}
				mysqli_free_result($cm);
?>
					</table>
<?php
			}else{
				echo mensajeda("Faltan datos");
			}
		}
	}
	mysqli_close($cone);
}
?>