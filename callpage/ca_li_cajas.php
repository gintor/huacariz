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
	if(isset($_POST['fec']) && !empty($_POST['fec'])){
		$fec=iseguro($cone,$_POST['fec']);
		if(vaccesom($cone,$id,$idm,2) || vaccesom($cone,$id,$idm,1)){
			$cu=mysqli_query($cone,"SELECT * FROM caja WHERE DATE_FORMAT(fecapertura, '%d/%m/%Y')='$fec' AND idlocal=$lo;");
?>
				<hr>
				<div class="row">
					<div class="col-md-8">
						<span class="titulo"><i class="fa fa-calendar-o text-muted"></i> <?php echo $fec; ?></span>
						<input type="hidden" id="cfec" value="<?php echo $fec; ?>">
					</div>
					<div class="col-md-4 text-right">
						<?php if(vaccesom($cone,$id,$idm,1) && $fec==date("d/m/Y")){ ?>
						<button class="btn bg-orange" onclick="ca_f_caja(<?php echo $idm.", 'addcaj', 0"; ?>);"><i class="fa fa-archive"></i> Abrir Caja</button>
						<?php } ?>
					</div>
				</div>
				<hr>
<?php
			if(mysqli_num_rows($cu)>0){
?>
				<table class="table table-bordered table-hover" id="dt_cajas">
					<thead>
						<tr>
							<th>#</th>
							<th>RESPONSABLE</th>
							<th>F. APERTURA</th>
							<th>F. CIERRE</th>
							<th>TURNO</th>
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
							<td><?php echo nombreusu($cone, $ru['idusuario']); ?></td>
							<td><?php echo ftnormal($ru['fecapertura']); ?></td>
							<td><?php echo ftnormal($ru['feccierre']); ?></td>
							<td><?php echo turno($ru['turno']); ?></td>				
							<td><?php echo estadocaja($ru['estado']); ?></td>
							<td>
								<div class="btn-group btn-group-xs">
								  <?php if(vaccesom($cone,$id,$idm,1)){ ?>
								  <button type="button" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="Eliminar" onclick="ca_f_caja(<?php echo $idm.",'elicaj',".$ru['idcaja']; ?>)"><i class="fa fa-trash"></i></button>
								  <?php } ?>
								  <button type="button" class="btn btn-default" title="Ir a caja" onclick="ca_l_ventas(<?php echo $idm.",".$ru['idcaja']; ?>)"><i class="fa fa-chevron-circle-right"></i></button>
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
$("#dt_cajas").DataTable();
</script>
<?php
		}
	}
	mysqli_close($cone);
}
?>