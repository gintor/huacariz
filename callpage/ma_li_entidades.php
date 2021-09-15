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
						<span class="titulo"><i class="fa fa-user-secret text-muted"></i> Entidad</span>
					</div>
					<div class="col-md-4 text-right">
						<?php if(vaccesom($cone,$id,$idm,1)){ ?>
						<button class="btn bg-orange" onclick="ma_f_mante(<?php echo $idm.", 'addent', 0"; ?>);"><i class="fa fa-plus"></i> Nuevo</button>
						<?php } ?>
					</div>
				</div>
				<hr>
<?php
			$cu=mysqli_query($cone,"SELECT idpersona, nombre, tipodocumento, numerodoc, tipocli, relacion, estado, descuento FROM persona ORDER BY idpersona DESC;");
			if(mysqli_num_rows($cu)>0){
?>
				<table class="table table-bordered table-hover" id="dt_personas">
					<thead>
						<tr>
							<th>#</th>
							<th>NOMBRE</th>
							<th>TIPO DOC.</th>
							<th>NÚMERO DOC.</th>
							<th>TIPO CLIENTE</th>
							<th>RELACIÓN</th>
							<th>DTO (%)</th>
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
							<td><a href="javascript:void(0)" onclick="ma_f_mante(<?php echo $idm.",'infoent',".$ru['idpersona']; ?>)"><?php echo $ru['nombre']; ?></a></td>
							<td><?php echo tipodocumento($ru['tipodocumento']); ?></td>
							<td><?php echo $ru['numerodoc']; ?></td>
							<td><?php echo tipocli($ru['tipocli']); ?></td>
							<td><?php echo relacionper($ru['relacion']); ?></td>
							<td><?php echo ($ru['descuento']*100); ?></td>
							<td><?php echo estado($ru['estado']); ?></td>
							<td>
								<div class="btn-group btn-group-xs">
								  <?php if(vaccesom($cone,$id,$idm,1)){ ?>
								  <button type="button" class="btn btn-default" title="<?php echo $ru['estado']==1 ? "Desactivar" : "Activar"; ?>" onclick="ma_f_mante(<?php echo $idm.",'estent',".$ru['idpersona']; ?>)"><i class="fa fa-toggle-on"></i></button>
								  <button type="button" class="btn btn-default" title="Editar" onclick="ma_f_mante(<?php echo $idm.",'edient',".$ru['idpersona']; ?>)"><i class="fa fa-pencil"></i></button>
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
$("#dt_personas").DataTable();
</script>
<?php
		}

	mysqli_close($cone);
}
?>