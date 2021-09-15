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
	if(isset($_POST['idc']) && !empty($_POST['idc'])){
		$idc=iseguro($cone,$_POST['idc']);
		if(vaccesom($cone,$id,$idm,2) || vaccesom($cone,$id,$idm,1)){
			$cc=mysqli_query($cone,"SELECT * FROM caja WHERE idcaja=$idc;");
			if($rc=mysqli_fetch_assoc($cc)){
				$iduc=$rc['idusuario'];
?>
				<hr>
				<div class="row">
					<div class="col-md-7">
						<h4 class="text-red"><i class="fa fa-archive text-gray"></i> <?php echo nombreusu($cone, $rc['idusuario'])." <small>(".ftnormal($rc['fecapertura']).") ".estadocaja($rc['estado'])."</small> "; ?></h4>
						<input type="hidden" id="idca" value="<?php echo $idc; ?>">
					</div>
					<div class="col-md-5 text-right">
						<?php if(vaccesom($cone,$id,$idm,1) && $iduc==$id && $rc['estado']==1){ ?>
						<button class="btn bg-orange" onclick="ca_f_caja(<?php echo $idm.", 'addmov', ".$idc; ?>);"><i class="fa fa-expand"></i> Movimiento</button>
						<button class="btn bg-red" onclick="ca_f_caja(<?php echo $idm.", 'cercaj', ".$idc; ?>);"><i class="fa fa-archive"></i> Cerrar Caja</button>
						<?php } ?>
						<button class="btn bg-maroon" onclick="ca_l_ventas(<?php echo $idm.", ".$idc; ?>);"><i class="fa fa-refresh"></i> Actualizar</button>
					</div>
				</div>
				<div class="row">
					<div class="col-md-8">
						<h5 class="text-green"><i class="fa fa-angle-right text-orange"></i> Ventas</h5>
<?php

							$ttp=array();
							$ctp=mysqli_query($cone,"SELECT tipopag FROM tipopag WHERE estado=1");
							if(mysqli_num_rows($ctp)>0){
								while($rtp=mysqli_fetch_assoc($ctp)){
									$ttp[$rtp['tipopag']]=0;
								}
							}
							mysqli_free_result($ctp);

						$cu=mysqli_query($cone,"SELECT v.idventa, v.cliente, v.fecha, v.estado, v.descuento, td.tipodoc, tp.tipopag, dv.numero FROM venta v INNER JOIN docventa dv ON v.idventa=dv.idventa INNER JOIN tipodoc td ON dv.idtipodoc=td.idtipodoc INNER JOIN tipopag tp ON v.idtipopag=tp.idtipopag WHERE v.idcaja=$idc ORDER BY v.idventa DESC;");
						if(mysqli_num_rows($cu)>0){
?>
						<table class="table table-bordered table-hover" id="dt_ventas">
							<thead>
								<tr>
									<th>#</th>
									<th>CLIENTE</th>
									<th>FECHA</th>
									<th>NUM DOC.</th>
									<th>TIPO PAGO</th>
									<th>MONTO</th>
									<th>ESTADO</th>
									<th>ACCIÓN</th>
								</tr>
							</thead>
							<tbody>
<?php

							$ttv=0;
							while($ru=mysqli_fetch_assoc($cu)){
								
									$idv=$ru['idventa'];
									$cdv=mysqli_query($cone,"SELECT subtotal FROM detventa WHERE idventa=$idv;");
									if(mysqli_num_rows($cdv)>0){
										$tv=0;
										$tvd=0;
										while($rdv=mysqli_fetch_assoc($cdv)){
											$tv=$tv+$rdv['subtotal'];
										}
										//$tvd=$tv*(1-$ru['descuento']);
									}
										
?>
								<tr>
									<td><?php echo $ru['idventa'];; ?></td>
									<td><?php echo nompersona($cone, $ru['cliente']); ?></td>
									<td><?php echo ftnormal($ru['fecha']); ?></td>
									<td><?php echo substr($ru['tipodoc'],0,1)."-".$ru['numero']; ?></td>
									<td><?php echo $ru['tipopag']; ?></td>
									<td><?php echo n_22decimal($tv); ?></td>
									<td><?php echo estadoventa($ru['estado']); ?></td>
									<td>
										<div class="btn-group btn-group-xs">
										<?php if(vaccesom($cone,$id,$idm,1) && $iduc==$id && $rc['estado']==1){ ?>
										  <?php if($ru['estado']!=3){ ?>
										  <button type="button" class="btn btn-default" title="Anular" onclick="ca_f_caja(<?php echo $idm.",'canven',".$ru['idventa']; ?>)"><i class="fa fa-ban"></i></button>
										  <?php } ?>
										<?php } ?>
										  <button type="button" class="btn btn-default" title="Info" onclick="ca_f_caja(<?php echo $idm.", 'infoven', ".$ru['idventa']; ?>)"><i class="fa fa-info-circle"></i></button>
										</div>
									</td>
								</tr>
<?php
								if($ru['estado']==2){
									$ttv=$ttv+$tv;
									$ttp[$ru['tipopag']]=$ttp[$ru['tipopag']]+$tv;
								}

							}
							
?>
							</tbody>
						</table>

						<table class="table table-bordered table-hover">
							<tr>
								<th>TOTAL</th>
								<th><?php echo n_22decimal($ttv); ?></th>
							</tr>
						</table>
					

<?php
						}else{
							echo mensajeda("No se encontró datos");
						}
						mysqli_free_result($cu);
?>
						<h5 class="text-muted"><i class="fa fa-angle-right text-orange"></i> Movimientos</h5>
						<table class="table table-bordered table-hover">
							<thead>
							<tr>
								<th>#</th>
								<th>DESCRIPCIÓN</th>
								<th>TIPO</th>
								<th>FECHA</th>
								<th>MONTO</th>
							</tr>
							</thead>
<?php
						$cm=mysqli_query($cone,"SELECT * FROM movcaja WHERE idcaja=$idc;");
						if(mysqli_num_rows($cm)>0){
							$m=0;
							$mt=0;
							while($rm=mysqli_fetch_assoc($cm)){
								$m++;
								if($rm['tipo']==1){
									$mt=$mt+$rm['monto'];
								}else{
									$mt=$mt-$rm['monto'];
								}
?>
							<tr>
								<td><?php echo $m; ?></td>
								<td><?php echo $rm['descripcion']; ?></td>
								<td><?php echo tmovcaja($rm['tipo']); ?></td>
								<td><?php echo ftnormal($rm['fecha']); ?></td>
								<td><?php echo $rm['monto']; ?></td>
							</tr>
<?php
							}
						}
						mysqli_free_result($cm);
?>
							<tr>
								<th colspan="4">TOTAL</th>
								<th><?php echo n_22decimal($mt); ?></th>
							</tr>
						</table>
						<h5 class="text-red"><i class="fa fa-angle-right text-orange"></i> Resumen</h5>
						<table class="table table-hover table-bordered">
							<tr>
								<th>TOTAL VENTAS</th>
								<th class="text-red"><?php echo n_22decimal($ttv); ?></th>
							</tr>
							<tr>
								<th>TOTAL MOVIMIENTOS</th>
								<th class="text-red"><?php echo n_22decimal($mt); ?></th>
							</tr>
							<tr>
								<th>TOTAL</th>
								<th class="text-red"><?php echo n_22decimal($ttv+$mt); ?></th>
							</tr>
						</table>
						<table class="table table-hover table-bordered">
							<tr>
								<th>TIPO PAGO</th>
								<th>TOTAL</th>
							</tr>
<?php
						foreach ($ttp as $key => $value) {
?>
							<tr>
								<td><?php echo $key; ?></td>
								<td><?php echo n_22decimal($value); ?></td>
							</tr>	
<?php
						}
?>
						</table>
						<table class="table table-hover table-bordered">
							<tr>
								<th>TOTAL EFECTIVO</th>
								<th><?php echo n_22decimal($ttp['EFECTIVO']+$mt); ?></th>
							</tr>							
						</table>
					</div>
					<div class="col-md-4">

						<h5 class="text-muted"><i class="fa fa-angle-right text-orange"></i> Despachos</h5>
<?php
					if($rc['estado']==1){
						$cv=mysqli_query($cone,"SELECT idventa, estado, cliente FROM venta WHERE idlocal=$lo AND idcaja IS NULL;");
						if(mysqli_num_rows($cv)>0){
?>
						<table class="table table-bordered table-hover" id="dt_despachos">
							<thead>
								<tr>
									<th>#</th>
									<th>CLIENTE</th>
									<th>ESTADO</th>
									<?php if(vaccesom($cone,$id,$idm,1) && $rc['idusuario']==$id && $rc['estado']==1){ ?>
									<th>ACCIÓN</th>
									<?php } ?>
								</tr>
							</thead>
							<tbody>
<?php
							$n=0;
							while($rv=mysqli_fetch_assoc($cv)){
								$n++;
?>
								<tr>
									<td><?php echo $rv['idventa']; ?></td>
									<td><?php echo nompersona($cone,$rv['cliente']); ?></td>		
									<td><?php echo estadoventa($rv['estado']); ?></td>
									<?php if(vaccesom($cone,$id,$idm,1) && $rc['idusuario']==$id && $rc['estado']==1){ ?>
									<td>
										<div class="btn-group btn-group-xs">
										  <?php if(vaccesom($cone,$id,$idm,1)){ ?>
										  <button type="button" class="btn btn-default" title="Cobrar" onclick="ca_f_caja(<?php echo $idm.",'cobdes',".$rv['idventa']; ?>)"><i class="fa fa-money"></i></button>
										  <?php } ?>
										</div>
									</td>
									<?php } ?>
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
						mysqli_free_result($cv);
					}else{
						echo mensajeda("Caja Cerrada");
					}
?>
					</div>
				</div>			
<?php
			}else{
				echo mensajeda("Datos inválidos");
			}
?>
<script>
$("#dt_ventas").DataTable({
	"order": [ 0, 'desc' ]
});
//$("#dt_despachos").DataTable();
</script>
<?php
		}
	}
	mysqli_close($cone);
}
?>