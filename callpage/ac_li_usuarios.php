<?php
session_start();
if(isset($_POST['idm']) && !empty($_POST['idm'])){
	include_once '../call/cone.php';
	include_once '../cons.php';
	include_once '../call/func.php';
	$idm=iseguro($cone, $_POST['idm']);
	$no=iseguro($cone, $_SESSION['nousu']);
	$id=iseguro($cone, $_SESSION['idusu']);
	$lo=iseguro($cone, $_SESSION['local']);

		if(vaccesom($cone,$id,$idm,2) || vaccesom($cone,$id,$idm,1)){
?>
				<div class="row">
					<div class="col-md-8">
						<span class="titulo"><i class="fa fa-user text-muted"></i> Usuarios</span>
					</div>
					<div class="col-md-4 text-right">
						<?php if(vaccesom($cone,$id,$idm,1)){ ?>
						<button class="btn bg-orange" onclick="ac_f_accesos(<?php echo $idm.", 'addusu', 0"; ?>);"><i class="fa fa-plus"></i> Nuevo</button>
						<?php } ?>
					</div>
				</div>
				<hr>
<?php
			$cu=mysqli_query($cone,"SELECT u.idusuario, u.estado, p.nombre FROM usuario u INNER JOIN persona p ON u.idpersona=p.idpersona ORDER BY idusuario DESC;");
			if(mysqli_num_rows($cu)>0){
?>
				<table class="table table-bordered table-hover" id="dt_usuarios">
					<thead>
						<tr>
							<th>#</th>
							<th>NOMBRE</th>
							<th>ESTADO</th>
							<th>ACCIÓN</th>
						</tr>
					</thead>
					<tbody>
<?php
				$n=0;
				while($ru=mysqli_fetch_assoc($cu)){
					$n++;
?>
						<tr>
							<td><?php echo $n; ?></td>
							<td><?php echo $ru['nombre']; ?></td>
							<td><?php echo estado($ru['estado']); ?></td>
							<td>
								<div class="btn-group btn-group-xs">
								  <?php if(vaccesom($cone,$id,$idm,1)){ ?>
								  <button type="button" class="btn btn-default" title="<?php echo $ru['estado']==1 ? "Desactivar" : "Activar"; ?>" onclick="ac_f_accesos(<?php echo $idm.",'estusu',".$ru['idusuario']; ?>)"><i class="fa fa-toggle-on"></i></button>
								  <button type="button" class="btn btn-default" title="Cambiar contraseña" onclick="ac_f_accesos(<?php echo $idm.",'conusu',".$ru['idusuario']; ?>)"><i class="fa fa-unlock-alt"></i></button>
								  <button type="button" class="btn btn-default" title="Accesos" onclick="ac_f_accesos(<?php echo $idm.",'accusu',".$ru['idusuario']; ?>)"><i class="fa fa-key"></i></button>
								  <?php } ?>
								</div>
							</td>
						</tr>
<?php
				}
?>
					</tbody>
				</table>
<?php
			}else{
				echo mensajeda("No se encontró datos");
			}
			mysqli_free_result($cu);
?>
<script>
$("#dt_usuarios").DataTable();
</script>
<?php
		}

	mysqli_close($cone);
}
?>