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
			$cu=mysqli_query($cone,"SELECT * FROM venta WHERE Estado=1 AND idlocal=$lo;");
?>
				<button class="btn bg-maroon" onclick="l_despachos(<?php echo $idm; ?>)"><i class="fa fa-refresh"></i> Actualizar</button>
				<br><br>
<?php
			if(mysqli_num_rows($cu)>0){
?>
				<table class="table table-bordered table-hover" id="dt_despachos">
					<thead>
						<tr>
							<th>#</th>
							<th>CLIENTE</th>
							<th>FECHA</th>
							<!--<th>RESPONSABLE</th>-->
							<th>ESTADO</th>
							<th>ACCIÓN</th>
						</tr>
					</thead>
					<tbody>
<?php
				while($ru=mysqli_fetch_assoc($cu)){
?>
						<tr>
							<td><small><?php echo $ru['idventa']; ?></small></td>
							<td><small><?php echo nompersona($cone,$ru['cliente']); ?></small></td>
							<td><small><?php echo fnormal($ru['fecha']); ?></small></td>
							<!--<td><?php //echo nombreusu($cone, $ru['idusuario']); ?></td>-->
							<td><small><?php echo estadoventa($ru['estado']); ?></small></td>
							<td>
								<div class="btn-group btn-group-xs">
								  <?php if(vaccesom($cone,$id,$idm,1)){ ?>
								  <button type="button" class="btn btn-default" title="Editar" onclick="de_f_despacho(<?php echo $idm.",'edides',".$ru['idventa']; ?>)"><i class="fa fa-pencil"></i></button>
								  
								  <button type="button" class="btn btn-default" title="Eliminar" onclick="de_f_despacho(<?php echo $idm.",'elides',".$ru['idventa']; ?>)"><i class="fa fa-trash"></i></button>
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
$("#dt_despachoss").DataTable();
</script>
<?php
		}

	mysqli_close($cone);
}
?>