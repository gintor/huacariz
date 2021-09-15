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
						<span class="titulo"><i class="fa fa-building-o text-muted"></i> Locales</span>
					</div>
					<div class="col-md-4 text-right">
						<?php if(vaccesom($cone,$id,$idm,1)){ ?>
						<button class="btn bg-orange" onclick="ma_f_mante(<?php echo $idm.", 'addloc', 0"; ?>);"><i class="fa fa-plus"></i> Nuevo</button>
						<?php } ?>
					</div>
				</div>
				<hr>
<?php
			$cu=mysqli_query($cone,"SELECT * FROM local ORDER BY idlocal DESC;");
			if(mysqli_num_rows($cu)>0){
?>
				<table class="table table-bordered table-hover" id="dt_local">
					<thead>
						<tr>
							<th>#</th>
							<th>LOCAL</th>
							<th>DIRECCIÓN</th>
							<th>SERIE</th>
							<th>TIPO PRECIO</th>
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
							<td><?php echo $ru['direccion']; ?></td>
							<td><?php echo $ru['seriecom']; ?></td>
							<td><?php echo tipprecio($ru['tipoprecio']); ?></td>		
							<td><?php echo estado($ru['estado']); ?></td>
							<td>
								<div class="btn-group btn-group-xs">
								  <?php if(vaccesom($cone,$id,$idm,1)){ ?>
								  <button type="button" class="btn btn-default" title="<?php echo $ru['estado']==1 ? "Desactivar" : "Activar" ?>" onclick="ma_f_mante(<?php echo $idm.",'estloc',".$ru['idlocal']; ?>)"><i class="fa fa-toggle-on"></i></button>
								  <button type="button" class="btn btn-default" title="Editar" onclick="ma_f_mante(<?php echo $idm.",'ediloc',".$ru['idlocal']; ?>)"><i class="fa fa-pencil"></i></button>
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
$("#dt_local").DataTable();
</script>
<?php
		}

	mysqli_close($cone);
}
?>